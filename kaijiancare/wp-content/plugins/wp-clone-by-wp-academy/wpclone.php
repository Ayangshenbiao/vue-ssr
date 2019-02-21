<?php
/*
Plugin name: WP Clone by WP Academy
Plugin URI: http://wpacademy.com/software/
Description: Move or copy a WordPress site to another server or to another domain name, move to/from local server hosting, and backup sites.
Author: WP Academy
Version: 2.2.4
Author URI: http://wpacademy.com/
*/

include_once 'lib/functions.php';
include_once 'lib/class.wpc-wpdb.php';

$upload_dir = wp_upload_dir();

define('WPBACKUP_FILE_PERMISSION', 0755);
define('WPCLONE_ROOT',  rtrim(str_replace("\\", "/", ABSPATH), "/\\") . '/');
define('WPCLONE_BACKUP_FOLDER',  'wp-clone');
define('WPCLONE_DIR_UPLOADS',  str_replace('\\', '/', $upload_dir['basedir']));
define('WPCLONE_DIR_PLUGIN', str_replace('\\', '/', plugin_dir_path(__FILE__)));
define('WPCLONE_URL_PLUGIN', plugin_dir_url(__FILE__));
define('WPCLONE_DIR_BACKUP',  WPCLONE_DIR_UPLOADS . '/' . WPCLONE_BACKUP_FOLDER . '/');
define('WPCLONE_INSTALLER_PATH', WPCLONE_DIR_PLUGIN);
define('WPCLONE_WP_CONTENT' , str_replace('\\', '/', WP_CONTENT_DIR));


/* Init options & tables during activation & deregister init option */

register_activation_hook((__FILE__), 'wpa_wpclone_activate');
register_deactivation_hook(__FILE__ , 'wpa_wpclone_deactivate');
add_action('admin_menu', 'wpclone_plugin_menu');
add_action( 'wp_ajax_wpclone-ajax-size', 'wpa_wpc_ajax_size' );
add_action( 'wp_ajax_wpclone-ajax-dir', 'wpa_wpc_ajax_dir' );
add_action( 'wp_ajax_wpclone-ajax-delete', 'wpa_wpc_ajax_delete' );
add_action( 'wp_ajax_wpclone-ajax-uninstall', 'wpa_wpc_ajax_uninstall' );
add_action( 'wp_ajax_wpclone-search-n-replace', 'wpa_wpc_ajax_search_n_replace' );

function wpclone_plugin_menu() {
    add_menu_page (
        'WP Clone Plugin Options',
        'WP Clone',
        'manage_options',
        'wp-clone',
        'wpclone_plugin_options'
    );
}

function wpa_wpc_ajax_size() {

    check_ajax_referer( 'wpclone-ajax-submit', 'nonce' );

    $cached = get_option( 'wpclone_directory_scan' );
    $interval = 600; /* 10 minutes */

    if( false !== $cached && time() - $cached['time'] < $interval ) {
        $size = $cached;
        $size['time'] = date( 'i', time() - $size['time'] );
    } else {
        $size = wpa_wpc_dir_size( WP_CONTENT_DIR );
    }

    echo json_encode( $size );
    wp_die();

}

function wpa_wpc_ajax_dir() {

    check_ajax_referer( 'wpclone-ajax-submit', 'nonce' );
    if( ! file_exists( WPCLONE_DIR_BACKUP ) ) wpa_create_directory();
    wpa_wpc_scan_dir();
    wp_die();

}

function wpa_wpc_ajax_delete() {

    check_ajax_referer( 'wpclone-ajax-submit', 'nonce' );

    if( isset( $_REQUEST['fileid'] ) && ! empty( $_REQUEST['fileid'] ) ) {

        echo json_encode( DeleteWPBackupZip( $_REQUEST['fileid'] ) );


    }

    wp_die();

}

function wpa_wpc_ajax_uninstall() {

    check_ajax_referer( 'wpclone-ajax-submit', 'nonce' );
    if( file_exists( WPCLONE_DIR_BACKUP ) ) {
        wpa_delete_dir( WPCLONE_DIR_BACKUP );

    }

    if( file_exists( WPCLONE_WP_CONTENT . 'wpclone-temp' ) ) {
        wpa_delete_dir( WPCLONE_WP_CONTENT . 'wpclone-temp' );

    }

    delete_option( 'wpclone_backups' );
    wpa_wpc_remove_table();
    wp_die();

}

function wpa_wpc_ajax_search_n_replace() {
    check_ajax_referer( 'wpclone-ajax-submit', 'nonce' );
    global $wpdb;
    $search  = isset( $_POST['search'] ) ? $_POST['search'] : '';
    $replace = isset( $_POST['replace'] ) ? $_POST['replace'] : '';

    if( empty( $search ) || empty( $replace ) ) {
        echo '<p class="error">Search and Replace values cannot be empty.</p>';
        wp_die();
    }

    wpa_bump_limits();
    $report = wpa_safe_replace_wrapper( $search, $replace, $wpdb->prefix );
    echo wpa_wpc_search_n_replace_report( $report );

    wp_die();
}

function wpclone_plugin_options() {
    include_once 'lib/view.php';
}

function wpa_enqueue_scripts(){
    wp_register_script('jquery-zclip', plugin_dir_url(__FILE__) . '/lib/js/zeroclipboard.min.js', array('jquery'));
    wp_register_script('wpclone', plugin_dir_url(__FILE__) . '/lib/js/backupmanager.js', array('jquery'));
    wp_register_style('wpclone', plugin_dir_url(__FILE__) . '/lib/css/style.css');
    wp_localize_script('wpclone', 'wpclone', array( 'nonce' => wp_create_nonce( 'wpclone-ajax-submit' ), 'spinner' => esc_url( admin_url( 'images/spinner.gif' ) ) ) );
    wp_enqueue_script('jquery-zclip');
    wp_enqueue_script('wpclone');
    wp_enqueue_style('wpclone');
    wp_deregister_script('heartbeat');
    add_thickbox();
}
if( isset($_GET['page']) && 'wp-clone' == $_GET['page'] ) add_action('admin_enqueue_scripts', 'wpa_enqueue_scripts');

function wpa_wpclone_activate() {
    wpa_create_directory();
}

function wpa_wpclone_deactivate() {

    if( file_exists( WPCLONE_DIR_BACKUP ) ) {
        $data = "<Files>\r\n\tOrder allow,deny\r\n\tDeny from all\r\n\tSatisfy all\r\n</Files>";
        $file = WPCLONE_DIR_BACKUP . '.htaccess';
        file_put_contents($file, $data);
    }

}

function wpa_wpc_remove_table() {
    global $wpdb;
    $wp_backup = $wpdb->prefix . 'wpclone';
    $wpdb->query ("DROP TABLE IF EXISTS $wp_backup");
}

function wpa_create_directory() {
    $indexFile = (WPCLONE_DIR_BACKUP.'index.html');
    $htacc = WPCLONE_DIR_BACKUP . '.htaccess';
    $htacc_data = "Options All -Indexes";
    if (!file_exists($indexFile)) {
        if(!file_exists(WPCLONE_DIR_BACKUP)) {
            if(!mkdir(WPCLONE_DIR_BACKUP, WPBACKUP_FILE_PERMISSION)) {
                die("Unable to create directory '" . rtrim(WPCLONE_DIR_BACKUP, "/\\"). "'. Please set 0755 permission to wp-content.");
            }
        }
        $handle = fopen($indexFile, "w");
        fclose($handle);
    }
    if( file_exists( $htacc ) ) {
        @unlink ( $htacc );
    }
    file_put_contents($htacc, $htacc_data);
}

function wpa_wpc_import_db(){

    global $wpdb;
    $table_name = $wpdb->prefix . 'wpclone';

    if( $wpdb->get_var( "SHOW TABLES LIKE '$table_name'") === $table_name ) {

        $old_backups = array();
        $result = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}wpclone ORDER BY id DESC", ARRAY_A);

        foreach( $result as $row ) {

            $time = strtotime( $row['data_time'] );
            $old_backups[$time] = array(
                    'name' => $row['backup_name'],
                    'creator' => $row['creator'],
                    'size' => $row['backup_size']

            );

        }

        if( false !== get_option( 'wpclone_backups' ) ) {
            $old_backups = get_option( 'wpclone_backups' ) + $old_backups;
        }

        update_option( 'wpclone_backups', $old_backups );

        wpa_wpc_remove_table();

    }


}

function wpa_wpc_msnotice() {
    echo '<div class="error">';
    echo '<h4>WP Clone Notice.</h4>';
    echo '<p>WP Clone is not compatible with multisite installations.</p></div>';
}

if ( is_multisite() )
    add_action( 'admin_notices', 'wpa_wpc_msnotice');

function wpa_wpc_phpnotice() {
    echo '<div class="error">';
    echo '<h4>WP Clone Notice.</h4>';
    printf( '<p>WP Clone is not compatible with PHP %s, please upgrade to PHP 5.3 or newer.</p></div>', phpversion() );
}

if( version_compare( phpversion(), '5.3', '<' ) ){
    add_action( 'admin_notices', 'wpa_wpc_phpnotice');    
}