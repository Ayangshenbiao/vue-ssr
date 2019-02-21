<?php

function wpCloneSafePathMode($path) {
    return str_replace("\\", "/", $path);
}

function wpCloneDirectory($path) {
    return rtrim(str_replace("//", "/", wpCloneSafePathMode($path)), '/') . '/';
}

function convertPathIntoUrl($path) {
    return str_replace(rtrim(WPCLONE_ROOT, "/\\"), site_url(), $path);
}

function convertUrlIntoPath($url) {
    return str_replace(site_url(), rtrim(WPCLONE_ROOT, "/\\"), $url);
}

function wpa_db_backup_wpdb($destination)
{
    global $wpdb;

    $return = '';

    // Get all of the tables
    if( isset( $_POST['ignore_prefix'] ) && 'true' === $_POST['ignore_prefix'] ) {
        wpa_wpc_log( 'ignore prefix enabled, backing up all the tables' );
        $tables = $wpdb->get_col('SHOW TABLES');

    } else {
        wpa_wpc_log( sprintf( 'backing up tables with "%s" prefix', $wpdb->prefix ) );
        $tables = $wpdb->get_col('SHOW TABLES LIKE "' . $wpdb->prefix . '%"');

    }

    wpa_wpc_log( sprintf( 'number of tables to backup - %d', count( $tables ) ) );
    
    // Cycle through each provided table
    foreach ($tables as $table) {

        // First part of the output � remove the table
        $result = $wpdb->get_results("SELECT * FROM {$table}", ARRAY_N);
        $numberOfItems = count($result);
        if ($numberOfItems == 0) {
              // Empty table - don't attempt to use $result[0] as it doesn't exist 
              $numberOfFields = 0;
        }
        else {
            $numberOfFields = count($result[0]);
        }
        
        // Second part of the output � create table
        $row2 = $wpdb->get_row("SHOW CREATE TABLE {$table}", ARRAY_N);
        $return.= 'DROP TABLE IF EXISTS '.$table.';';
        $return .= "\n\n" . $row2[1] . ";\n\n";

        // Third part of the output � insert values into new table
        for ($currentRowNumber = 0; $currentRowNumber < $numberOfItems; $currentRowNumber++) {

            $row = $result[$currentRowNumber];
            $query = "INSERT INTO {$table} VALUES(";

            for ($j = 0; $j < $numberOfFields; $j++) {
                // Change to 'isset()' instead of 'empty()' as 'empty()' returns true for the 
                // string "0" - but we may need to explicitly set value to 0 for fields where this
                // is not the default. This makes the output of this method identical to the 
                // wpa_db_backup_direct() method
                $query .= (!isset($row[$j])) ? '"", ' : '"' . esc_sql($row[$j]) . '", ';
            }

            $return .= substr($query, 0, -2) .  ");\n";

        }

        $return .= "\n";
    }

    // Generate the filename for the sql file
    $File_open = fopen($destination . '/database.sql', 'w+');

    // Save the sql file
    fwrite($File_open, $return);

    //file close
    fclose($File_open);

    $wpdb->flush();
}

/**
 * @link http://davidwalsh.name/backup-mysql-database-php
 */
function wpa_db_backup_direct($destination)
{

    global $wpdb;
    $prefix = $wpdb->prefix;
    $wpcdb = wpa_wpc_mysql_connect();
    if ( false === $wpcdb->get_dbh() ) {
        wpa_backup_error('db', $wpcdb->error() );
    }

    $tables = array();

    if( isset( $_POST['ignore_prefix'] ) && 'true' === $_POST['ignore_prefix'] ) {
        wpa_wpc_log( 'ignore prefix enabled, backing up all the tables' );
        $result = $wpcbd->query('SHOW TABLES');

    } else {
        wpa_wpc_log( sprintf( 'backing up tables with "%s" prefix', $prefix ) );
        $result = $wpcdb->query('SHOW TABLES LIKE "' . $prefix . '%"');
    }

    if ( false === $result ) {
        wpa_backup_error('db', $wpcdb->error() );
    }

    while( $row = $wpcdb->fetch_row( $result ) ) {
        $tables[] = $row[0];
    }

    wpa_wpc_log( sprintf( 'number of tables to backup - %d', count( $tables ) ) );
    $return = '';

    foreach($tables as $table)
    {
        $result = $wpcdb->query( 'SELECT * FROM ' . $table );
        if ( false === $result ) {
            wpa_backup_error('db', $wpcdb->error() );
        }
        $num_fields = $wpcdb->num_fields($result);

        $return.= 'DROP TABLE IF EXISTS '.$table.';';
        $row2 = $wpcdb->fetch_row( $wpcdb->query( 'SHOW CREATE TABLE ' . $table ) );
        $return.= "\n\n".$row2[1].";\n\n";

        for ($i = 0; $i < $num_fields; $i++)
        {
            while($row = $wpcdb->fetch_row($result))
            {
                $return.= 'INSERT INTO '.$table.' VALUES(';
                for($j=0; $j<$num_fields; $j++)
                {
                        $row[$j] = $wpcdb->real_escape_string( $row[$j] );
                        if (isset($row[$j])) { $return.= '"'.$row[$j].'"' ; } else { $return.= '""'; }
                        if ($j<($num_fields-1)) { $return.= ', '; } // Add extra space to match wpdb backup method
                }
                $return.= ");\n";
            }
        }
        $return.="\n";

    }
    //save file
    $handle = fopen($destination . '/database.sql','w+');
    fwrite($handle,$return);
    fclose($handle);
}

function wpa_insert_data($name, $size)
{
    $backups = get_option( 'wpclone_backups' );
    $time = current_time( 'timestamp', get_option('gmt_offset') );
    global $current_user;
    $backup = array(
        $time => array(
            'name'     => $name . '.zip',
            'log'      => $name . '.log',
            'creator'  => $current_user->user_login,
            'size'     => $size
        )
    );

    if( false === $backups ) {
        add_option( 'wpclone_backups', $backup );
        return;
    }

    $backups = $backups + $backup;
    update_option( 'wpclone_backups', $backups );

    return;

}

function CreateWPFullBackupZip($backupName, $zipmode, $use_wpdb = false )
{
    $folderToBeZipped = WPCLONE_DIR_BACKUP . 'wpclone_backup';
    $htaccess         = "<Files>\r\n\tOrder allow,deny\r\n\tDeny from all\r\n\tSatisfy all\r\n</Files>";
    $zipFileName      = WPCLONE_DIR_BACKUP . $backupName . '.zip';
    $exclude          = wpa_excluded_dirs();
    $dbonly           = isset( $_POST['dbonly'] ) && 'true' == $_POST['dbonly'] ? true : false;
    $skip             = 25 * 1024 * 1024;

    if( isset( $_POST['skipfiles'] ) && '' !== $_POST['skipfiles'] ) {

        if( 0 === $_POST['skipfiles'] ) {
            $skip = false;

        } else {
            $skip = $_POST['skipfiles'] * 1024 * 1024;

        }

    }

    if( false === mkdir( $folderToBeZipped ) ) {
        wpa_backup_error ( 'file', sprintf( __( 'Unable to create the temporary backup directory,please make sure that PHP has permission to write into the <code>%s</code> directory.' ), WPCLONE_DIR_BACKUP ) );
    }
    
    file_put_contents( $folderToBeZipped . '/.htaccess', $htaccess );

    if( $dbonly ) {
        wpa_wpc_log ( 'database only backup, no files will be copied' );
    }

    if( false === $dbonly ) {        
        if( $skip ) {
            wpa_wpc_log( sprintf( 'files larger than %s will be excluded from the backup', bytesToSize( $skip ) ) );
        }
        wpa_wpc_log( 'generating file list' );
        file_put_contents( $folderToBeZipped . '/file.list', serialize( wpa_wpc_get_filelist( WPCLONE_WP_CONTENT, $exclude, $skip ) ) );
        wpa_wpc_log( 'finished generating file list' );
    }

    wpa_save_prefix($folderToBeZipped);
    /*  error handler is called from within the db backup functions */
    if ( $use_wpdb ) {
        wpa_wpc_log ( 'database backup started [wpdb]' );
        wpa_db_backup_wpdb( $folderToBeZipped );
    } else {
        wpa_wpc_log ( 'database backup started' );
        wpa_db_backup_direct( $folderToBeZipped );
    }
    wpa_wpc_log ( 'database backup finished' );

    /* error handler is called from within the wpa_zip function */

    wpa_zip($zipFileName, $folderToBeZipped, $zipmode);
    
    wpa_delete_dir( $folderToBeZipped );
    
    if( ! file_exists( $zipFileName ) ) {
        wpa_backup_error( 'backup', 'possibly out of free disk space' );
    }
    $zipSize = filesize($zipFileName);
    return array($backupName, $zipSize);
}

function DeleteWPBackupZip($nm)
{
    $backups = get_option( 'wpclone_backups' );

    if( empty( $backups ) || ! isset( $backups[$nm] ) ) {
        return array(
            'status' => 'failed',
            'msg' => 'Something is not quite right here, refresh the backup list and try again later.' );
    }

    if( isset( $backups[$nm]['log'] ) && file_exists( WPCLONE_DIR_BACKUP . $backups[$nm]['log'] ) ) {
        @unlink( WPCLONE_DIR_BACKUP . $backups[$nm]['log'] );

    }

    if ( file_exists( WPCLONE_DIR_BACKUP . $backups[$nm]['name'] ) ) {

        if( ! unlink( WPCLONE_DIR_BACKUP . $backups[$nm]['name'] ) ) {
            return array(
                'status' => 'failed',
                'msg' => 'Unable to delete file' );
        }

        unset( $backups[$nm] );
        update_option( 'wpclone_backups', $backups );
        return array(
                'status' => 'deleted',
                'msg' => 'File deleted' );

    } else {

        return array(
                'status' => 'failed',
                'msg' => 'File not found. Refresh the backup list to remove missing backups.' );

    }

}

function bytesToSize($bytes, $precision = 2)
{
    $kilobyte = 1024;
    $megabyte = $kilobyte * 1024;
    $gigabyte = $megabyte * 1024;
    $terabyte = $gigabyte * 1024;
    if (($bytes >= 0) && ($bytes < $kilobyte)) {
        return $bytes . ' B';
    } elseif (($bytes >= $kilobyte) && ($bytes < $megabyte)) {
        return round($bytes / $kilobyte, $precision) . ' KB';
    } elseif (($bytes >= $megabyte) && ($bytes < $gigabyte)) {
        return round($bytes / $megabyte, $precision) . ' MB';
    } elseif (($bytes >= $gigabyte) && ($bytes < $terabyte)) {
        return round($bytes / $gigabyte, $precision) . ' GB';
    } elseif ($bytes >= $terabyte) {
        return round($bytes / $terabyte, $precision) . ' TB';
    } else {
        return $bytes . ' B';
    }
}

function wpa_wpc_get_url( $db ) {

    $pos = strpos( $db, 'siteurl' ) + 8;
    $urlStartPos = strpos( $db, '"', $pos ) + 1;
    $urlEndPos = strpos( $db, '"', $urlStartPos );
    $backupSiteUrl = substr( $db, $urlStartPos, $urlEndPos - $urlStartPos );
    return $backupSiteUrl;

}


function wpa_wpc_mysql_connect() {
    // Use subclass of wpdb to ensure compatibility with WordPress database and use the appropriate MySQL module
    // and provide the extra functions we need
    $db = new wpc_wpdb( DB_USER, DB_PASSWORD, DB_NAME, DB_HOST  );
    return $db;
}

/**
 * @param type $search URL of the previous site.
 * @param type $replace URL of the current site.
 * @return type total time it took for the operation.
 */
function wpa_safe_replace_wrapper ( $search, $replace, $prefix ) {
    if ( !function_exists( 'icit_srdb_replacer' ) && !function_exists( 'recursive_unserialize_replace' ) ) {
        require_once 'icit_srdb_replacer.php';
    }

    wpa_wpc_log( 'search and replace started' );

    $wpcdb = wpa_wpc_mysql_connect();
    
    if ( false === $wpcdb->get_dbh() ) {

        wpa_wpc_log( 'mysql connection failure @ safe replace wrapper - error : "' . $wpdbc->error() . '" retrying..'  );

        $wpcdb->close();
        sleep(1);
        // Try to create a new connection
        $wpcdb = wpa_wpc_mysql_connect();
    }

    $all_tables = array();

    if( isset( $_POST['ignore_prefix'] ) && 'true' === $_POST['ignore_prefix'] ) {
        wpa_wpc_log( 'ignore table prefix enabled, search and replace will scan all the tables in the database' );
        $all_tables_mysql = @$wpcdb->query( 'SHOW TABLES' );

    } else {
        $all_tables_mysql = @$wpcdb->query( 'SHOW TABLES LIKE "' . $prefix . '%"' );
    }

    while ( $table = $wpcdb->fetch_array( $all_tables_mysql ) ) {
        $all_tables[] = $table[ 0 ];
    }

    wpa_wpc_log( sprintf( 'there are %d tables to scan', count( $all_tables ) ) );

    $report = icit_srdb_replacer( $wpcdb, $search, $replace, $all_tables );
    $wpcdb->close( );
    wpa_wpc_log( 'search and replace finished' );
    return $report;
}

function wpa_wpc_temp_dir() {

    global $wp_filesystem;
    $temp_dir = trailingslashit( WPCLONE_WP_CONTENT ) . 'wpclone-temp';
    $err      = $wp_filesystem->mkdir( $temp_dir );

    if ( is_wp_error( $err ) ) {
        wpa_backup_error('dirrest', $err->get_error_message(), true );
    }

    $content = "<Files>\r\n\tOrder allow,deny\r\n\tDeny from all\r\n\tSatisfy all\r\n</Files>";
    $file = trailingslashit( $temp_dir ) . '.htaccess';
    $wp_filesystem->put_contents( $file, $content, 0644 );

    return $temp_dir;

}

function processRestoringBackup($url, $zipmode) {
    if( true === is_multisite() )
        die( 'wpclone does not work on multisite installs.' );
    
    wpa_cleanup( true );
    if (!is_string($url) || '' == $url) {
        wpa_backup_error( 'restore', sprintf( __( 'The provided URL "<code>%s</code>" is either not valid or empty' ), $url ), true );
    }

    global $wp_filesystem;
    $GLOBALS['wpclone']['logfile'] = 'wpclone_restore_' . current_time( 'dS_M_Y_h-iA', false ) . '_' . wp_generate_password( 10, false ) . '.log';

    wpa_wpc_log_start( 'restore' );

    if( $zipmode ) {
        define( 'PCLZIP_TEMPORARY_DIR', WPCLONE_DIR_BACKUP );
        
    }
    
    $temp_dir        = wpa_wpc_temp_dir();
    $site_url        = site_url();
    $permalink_url   = admin_url( 'options-permalink.php' );
    $zipfile         = wpa_fetch_file($url);
    $report          = wpa_wpc_process_db( $zipfile, $zipmode );    
    $unzipped_folder = wpCloneSafePathMode( trailingslashit( $temp_dir ) . 'wpclone_backup' );


    wpa_unzip( $zipfile, $temp_dir, $zipmode );
    wpa_wpc_log( 'copying files..' );
    wpa_copy( $unzipped_folder . '/wp-content', WPCLONE_WP_CONTENT );

    wpa_wpc_log( 'deleting temp directory..' );
    $wp_filesystem->delete( $temp_dir, true );
    /* remove the zip file only if it was downloaded from an external location. */
    $wptmp = explode( '.', $zipfile );
    if ( in_array( 'tmp', $wptmp ) ) {
        wpa_wpc_log( 'deleting downloaded zip file..' );
        $wp_filesystem->delete( $zipfile );
    }

    wpa_wpc_log( 'restore finished' );

    echo '<div class="width-60"><h1>Restore Successful!</h1>';
    printf( 'Visit your restored site [ <a href="%s" target=blank>here</a> ]<br><br>', $site_url );
    printf( '<strong>You may need to re-save your permalink structure <a href="%s" target=blank>Here</a></strong>', $permalink_url );
    printf( '</br><a href="%s">log</a>',  convertPathIntoUrl( WPCLONE_DIR_BACKUP . $GLOBALS['wpclone']['logfile'] ) );
    unset( $GLOBALS['wpclone'] );
    echo wpa_wpc_search_n_replace_report( $report );


}

function wpa_wpc_search_n_replace_report( $report ) {
    
    if( is_string( $report ) ) {
        return sprintf( '<div class="info"><p>%s</p></div>', $report );
    }

    $time = array_sum( explode( ' ', $report[ 'end' ] ) ) - array_sum( explode( ' ', $report[ 'start' ] ) );
    $return = sprintf( '<div class="info"><p>Search and replace scanned <strong>%d</strong> tables with a total of <strong>%d</strong> rows. ' , $report['tables'], $report['rows'] );
    $return .= sprintf( '<strong>%d</strong> cells were changed and <strong>%d</strong> db updates were performed in <strong>%f</strong> seconds.</p></div>', $report['change'], $report['updates'], $time );

    if ( ! empty( $report['errors'] ) && is_array( $report['errors'] ) ) {
        $return .= '<div>';
        $return .= '<h4>search and replace returned the following errors.</h4>';
        foreach( $report['errors'] as $error ) {
            $return .= '<p class="error">' . $error . '</p>';
        }
        $return .= '</div>';
    }

    return $return;

}

function wpa_save_prefix($path) {
    global $wpdb;
    $prefix = $wpdb->prefix;    
    $file = $path . '/prefix.txt';
    if ( is_dir($path) && is_writable($path) ) {
        file_put_contents($file, $prefix);
    }
}
/**
 * Checks to see whether the destination site's table prefix matches that of the origin site.old prefix is returned in case of a mismatch.
 *
 * @param type $file path to the prefix.txt file.
 * @return type bool string
 */
function wpa_check_prefix($file) {
    global $wpdb;
    $prefix = $wpdb->prefix;
    if (file_exists($file) && is_readable($file)) {
        $old_prefix = file_get_contents($file);
        if ( $prefix !== $old_prefix ) {
            return $old_prefix;
        }
        else {
            return false;
        }
    }
    return false;
}

/**
 * @since 2.0.6
 *
 * @param type $zipfile path to the zip file that needs to be extracted.
 * @param type $path the place to where the file needs to be extracted.
 * @return as false in the event of failure.
 */
function wpa_unzip($zipfile, $path, $zipmode = false){

    if ( $zipmode || ( ! in_array('ZipArchive', get_declared_classes() ) || ! class_exists( 'ZipArchive' ) ) ) {

        wpa_wpc_log( 'extracting archive using pclzip' );

        if ( ini_get('mbstring.func_overload') && function_exists('mb_internal_encoding') ) {
            $previous_encoding = mb_internal_encoding();
            mb_internal_encoding('ISO-8859-1');
        }

        require_once ( ABSPATH . 'wp-admin/includes/class-pclzip.php' );
        $z = new PclZip($zipfile);
        
        $files = $z->extract( PCLZIP_OPT_PATH, $path );

        if ( isset( $previous_encoding ) ) {
            mb_internal_encoding( $previous_encoding );
            
        }

        if ( $files === 0 ) {
            wpa_backup_error( 'pclunzip', $z->errorInfo(true), true );
        }

    } else {
        wpa_wpc_log( 'extracting archive using ziparchive' );
        wpa_wpc_unzip( $zipfile, $path );

    }

}
/**
 * @since 2.0.6
 *
 * @param type $name name of the zip file.
 * @param type $file_list an array of files that needs to be archived.
 */
function wpa_zip($zip_name, $folder, $zipmode = false){
    if ( $zipmode || (!in_array('ZipArchive', get_declared_classes()) || !class_exists('ZipArchive')) ) {
        wpa_wpc_log( 'archiving files using pclzip' );
        $zipmode = true;
        define('PCLZIP_TEMPORARY_DIR', WPCLONE_DIR_BACKUP);
        require_once ( ABSPATH . 'wp-admin/includes/class-pclzip.php');
        $z = new PclZip($zip_name);
        $v_list = $z->create($folder, PCLZIP_OPT_REMOVE_PATH, WPCLONE_DIR_BACKUP );
        if ($v_list == 0) {
            wpa_backup_error( 'pclzip', $z->errorInfo(true) );
        }
        $file_list = wpa_wpc_zip( $z, $zipmode );

        if( $file_list ) {
            $z->add( $file_list, PCLZIP_OPT_REMOVE_PATH, WPCLONE_ROOT, PCLZIP_OPT_ADD_PATH, 'wpclone_backup' );
        }

        $z->delete( PCLZIP_OPT_BY_NAME, 'wpclone_backup/file.list' );

    } else {
        wpa_wpc_log( 'archiving files using ziparchive' );
        $z = new ZipArchive();
        if ( true !== $z->open( $zip_name, ZIPARCHIVE::CREATE ) ) {
            wpa_backup_error( 'zip', $z->getStatusString() );
        }
        wpa_ziparc($z, $folder, WPCLONE_DIR_BACKUP);

        wpa_wpc_zip( $z, $zipmode );
        $z->deleteName( 'wpclone_backup/file.list' );
        $z->close();

    }


}

function wpa_ziparc($zip, $dir, $base) {
    $new_folder = str_replace($base, '', $dir);
    $zip->addEmptyDir($new_folder);
    foreach( glob( $dir . '/*' ) as $file ){
        if( is_dir($file) ) {
            wpa_ziparc($zip, $file, $base);
        } else {
            $new_file = str_replace( $base, '', $file );
            $zip->addFile($file, $new_file);
        }
    }
}
/**
 * just a simple function to increase PHP limits.
 * @since 2.0.6
 */
function wpa_bump_limits(){
    $GLOBALS['wpclone'] = array();
    $GLOBALS['wpclone']['time'] = isset( $_POST['maxexec'] ) && '' != $_POST['maxexec'] ? $_POST['maxexec'] : 600; /* 10 minutes */
    $GLOBALS['wpclone']['mem']  =  isset ( $_POST['maxmem'] ) && '' != $_POST['maxmem']  ? $_POST['maxmem'] . 'M' : '1024M';

    @ini_set('memory_limit', $GLOBALS['wpclone']['mem']);
    @ini_set('max_execution_time', $GLOBALS['wpclone']['time']);
    @ini_set('mysql.connect_timeout', $GLOBALS['wpclone']['time']);
    @ini_set('default_socket_timeout', $GLOBALS['wpclone']['time']);
}

/**
 * @since 2.0.6
 */
function wpa_wpfs_init(){
    if (!empty($_REQUEST['del'])) {
        wpa_remove_backup();
        return true;
    }
    if (empty($_POST)) return false;
    check_admin_referer('wpclone-submit');

    wpa_bump_limits();

    if (isset($_POST['createBackup'])) {
        wpa_create_backup();
        return true;
    }

    $form_post = wp_nonce_url('admin.php?page=wp-clone', 'wpclone-submit');
    $extra_fields = array( 'restore_from_url', 'maxmem', 'maxexec', 'zipmode', 'ignore_prefix', 'wipedb', 'mysql_check', 'restoreBackup', 'createBackup' );
    $type = '';
    if ( false === ($creds = request_filesystem_credentials($form_post, $type, false, false, $extra_fields)) ){
        return true;
    }
    if (!WP_Filesystem($creds)) {
        request_filesystem_credentials($form_post, $type, true, false, $extra_fields);
        return true;
    }

    $zipmode = isset($_POST['zipmode']) ? true : false;
    $url = isset($_POST['restoreBackup']) ? $_POST['restoreBackup'] : $_POST['restore_from_url'];
    processRestoringBackup($url, $zipmode);
    return true;
}
/**
 * @since 2.0.6
 */
function wpa_copy($source, $target) {
    global $wp_filesystem;
    if (is_readable($source)) {
        if (is_dir($source)) {
            if (!file_exists($target)) {
                $wp_filesystem->mkdir($target);
            }
            $d = dir($source);
            while (FALSE !== ($entry = $d->read())) {
                if ($entry == '.' || $entry == '..') {
                    continue;
                }
                $Entry = "{$source}/{$entry}";
                if (is_dir($Entry)) {
                    wpa_copy($Entry, $target . '/' . $entry);
                } else {
                    $wp_filesystem->copy($Entry, $target . '/' . $entry, true, FS_CHMOD_FILE);
                }
            }
            $d->close();
        }
        else {
            $wp_filesystem->copy($source, $target, true);
        }
    }
}
/**
 * @since 2.0.6
 */
function wpa_replace_prefix( $current, $new ){

    $wpconfig = wpa_wpconfig_path();
    global $wp_filesystem;

    if ( ! $wp_filesystem->is_writable($wpconfig) ) {
        if( false === $wp_filesystem->chmod( $wpconfig ) )
            wpa_backup_error('wpconfig', sprintf( __( "<code>%s</code> is not writable and wpclone was unable to change the file permissions." ), $wpconfig ), true );

    }

    $content = file( $wpconfig );

    foreach( $content as $key => $value ) {

        if( false !== strpos( $value, '$table_prefix' ) ) {
            $content[$key] = str_replace( $current, $new, $value );
        }

    }

    $content = implode( $content );
    $wp_filesystem->put_contents( $wpconfig, $content, 0600 );

}
/**
 * @since 2.0.6
 */
function wpa_create_backup (){

    if( true === is_multisite() )
        die( 'wpclone does not work on multisite installs.' );
    if ( !file_exists(WPCLONE_DIR_BACKUP) ) {
        wpa_create_directory();
    }
    wpa_cleanup();
    $use_wpdb = isset( $_POST['use_wpdb'] ) && 'true' == $_POST['use_wpdb'] ? true : false;
    $backupName = wpa_backup_name();
    $GLOBALS['wpclone']['logfile'] = $backupName . '.log';

    wpa_wpc_log_start( 'backup' );

    $zipmode = isset($_POST['zipmode']) ? true : false;
    list($zipFileName, $zipSize) = CreateWPFullBackupZip($backupName, $zipmode, $use_wpdb);

    wpa_insert_data($zipFileName, $zipSize);
    $backZipPath = convertPathIntoUrl(WPCLONE_DIR_BACKUP . $zipFileName . '.zip');
    $zipSize = bytesToSize($zipSize);
    wpa_wpc_log( 'backup finished');

    echo <<<EOF

<h1>Backup Successful!</h1>

<br />

Here is your backup file : <br />

    <a href='{$backZipPath}'><span>{$backZipPath}</span></a> ( {$zipSize} ) &nbsp;&nbsp;|&nbsp;&nbsp;
    <input type='hidden' name='backupUrl' class='backupUrl' value="{$backZipPath}" />
    <a class='copy-button' href='#' data-clipboard-text='{$backZipPath}'>Copy URL</a> &nbsp;<br /><br />

    (Copy that link and paste it into the "Restore URL" of your new WordPress installation to clone this site)
EOF;
    printf( '</br><a href="%s">log</a>',  convertPathIntoUrl( WPCLONE_DIR_BACKUP . $GLOBALS['wpclone']['logfile'] ) );
    unset( $GLOBALS['wpclone'] );
}
/**
 * @since 2.0.6
 */
function wpa_remove_backup(){
    check_admin_referer('wpclone-submit');
    $deleteRow = DeleteWPBackupZip($_REQUEST['del']);
    echo $deleteRow['msg'];

}
/**
 * @since 2.1.2
 * copypasta from wp-load.php
 * @return the path to wp-config.php
 */
function wpa_wpconfig_path () {

    if ( file_exists( ABSPATH . 'wp-config.php') ) {

        /** The config file resides in ABSPATH */
        return ABSPATH . 'wp-config.php';

    }
    elseif ( file_exists( dirname(ABSPATH) . '/wp-config.php' ) && ! file_exists( dirname(ABSPATH) . '/wp-settings.php' ) ) {

        /** The config file resides one level above ABSPATH but is not part of another install */
        return dirname(ABSPATH) . '/wp-config.php';

    }
    else {

        return false;

    }

}

function wpa_fetch_file($path){
    $z = pathinfo($path);
    global $wp_filesystem;
    if ( $wp_filesystem->is_file(WPCLONE_DIR_BACKUP . $z['basename']) ) {
        wpa_wpc_log( 'file exists in the backup folder, filesize - ' . bytesToSize( filesize( WPCLONE_DIR_BACKUP . $z['basename'] ) ) );
        return WPCLONE_DIR_BACKUP . $z['basename'];
    }
    else {
        wpa_wpc_log( 'file download started' );
        $url = download_url($path, 750);
        if ( is_wp_error($url) ) {
            wpa_backup_error( 'url', $url->get_error_message(), true );
        }
        wpa_wpc_log( 'download finished, filesize - ' . bytesToSize( filesize( $url ) ) );
        return $url;
    }
}

function wpa_backup_name() {
    $backup_name = 'wpclone_backup_' . current_time( 'dS_M_Y_h-iA', false ) . '_'  . get_option( 'blogname' );
    $backup_name = substr( str_replace( ' ', '', $backup_name ), 0, 40 );
    $rand_str = substr( str_shuffle( "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789" ), 0, 10 );
    $backup_name = sanitize_file_name( $backup_name ) . '_' . $rand_str;
    return $backup_name;
}

function wpa_backup_error($error, $data, $restore = false) {

    $temp_dir = $restore ? trailingslashit( WPCLONE_WP_CONTENT ) . 'wpclone-temp' : trailingslashit( WPCLONE_DIR_BACKUP ) . 'wpclone_backup';
    $disp_dir = str_replace( WPCLONE_ROOT, '**SITE-ROOT**/', wpCloneSafePathMode( $temp_dir ) );

    if( !file_exists( $temp_dir ) ) {
        unset($temp_dir);
    }
    
    switch ( $error ) :
        /* during backup */
        case 'file' :
            $error = __( 'while copying files into the temp directory' );
            break;
        case 'db' :
            $error = __( 'during the database backup' );
            break;
        case 'zip' :
            $error = __( 'while creating the zip file using PHP\'s ZipArchive library' );
            break;
        case 'pclzip' :
            $error = __( 'while creating the zip file using the PclZip library' );
            break;
        /* during restore */
        case 'dirrest' :
            $error = __( 'while creating the temp directory' );
            break;
        case 'filerest' :
            $error = __( 'while copying files from the temp directory into the wp-content directory' );
            break;
        case 'dbrest' :
            $error = __( 'while cloning the database' );
            break;
        case 'unzip' :
            $error = __( 'while extracting the zip file using php ziparchive' );
            break;
        case 'pclunzip' :
            $error = __( 'while extracting the zip file using the PclZip library' );
            break;
        case 'url' :
            $error = __( 'while downloading the zip file' );
            break;
        case 'wpconfig' :
            $error = __( 'while trying to modify the table prefix in the wp-config.php file' );
            break;
        /* and a catch all for the things that aren't covered above */
        default :
            $error = sprintf( __( 'during the %s process' ), $error );
    endswitch;

    echo '<div class="wpclone_notice updated">';
    printf( __( 'The plugin encountered an error %s,the following error message was returned:</br>' ), $error );
    echo '<div class="error">' . __( 'Error Message : ' ) . $data . '</div></br>';
    if( isset( $temp_dir ) ) {
        printf( __( 'Temporary files created in <code>%s</code> will be deleted.' ), $disp_dir );
        echo '</div>';
        if( $restore ) {
            global $wp_filesystem;
            $wp_filesystem->delete($temp_dir, true);
        } else {
            wpa_delete_dir( $temp_dir );
        }
    } else {
        echo '</div>';
    }
    die;
}

function wpa_cleanup( $restore = false ) {
    $backup_dir = $restore ? trailingslashit( WPCLONE_WP_CONTENT ) . 'wpclone-temp' : trailingslashit( WPCLONE_DIR_BACKUP ) . 'wpclone_backup';
    if ( file_exists( $backup_dir ) && is_dir( $backup_dir ) ) {
        if( $restore ) {
            global $wp_filesystem;
            $wp_filesystem->delete($backup_dir, true);
        } else {
            wpa_delete_dir( $backup_dir );
        }
    }
}
/**
 * recursively copies a directory from one place to another. excludes 'uploads/wp-clone' by default.
 * @since 2.1.6
 * @param string $from
 * @param string $to
 * @param array $exclude an array of directory paths to exclude.
 */
function wpa_copy_dir( $from, $to, $exclude ) {
    if( false === stripos( wpCloneSafePathMode( $from ), rtrim( wpCloneSafePathMode( WPCLONE_DIR_BACKUP ), "/\\" ) ) ) {
        if( !file_exists( $to ) )
            @mkdir ( $to );
        $files = array_diff( scandir( $from ), array( '.', '..' ) );
        foreach( $files as $file ) {
            if( in_array( $from . '/' . $file, $exclude ) ) {
                continue;
            } else {
                if( is_dir( $from . '/' . $file ) ) {
                    wpa_copy_dir( $from . '/' . $file, $to . '/' . $file, $exclude );
                } else {
                    @copy( $from . '/' . $file, $to . '/' . $file );
                }
            }
        }
        unset( $files );
    }
}
/**
 * recursively deletes all the files in the given directory.
 * @since 2.1.6
 * @param string $dir path to the directory that needs to be deleted.
 */
function wpa_delete_dir( $dir ) {
    if( !empty( $dir ) ) {
        $dir = trailingslashit( $dir );
        $files = array_diff( scandir( $dir ), array( '.', '..' ) );
        foreach ( $files as $file ) {
            if( is_dir( $dir . $file ) ) {
                wpa_delete_dir( $dir . $file );
            } else {
                @unlink( $dir . $file );
            }
        }
        @rmdir($dir);
    }
}
/**
 * @since 2.1.6
 */
function wpa_excluded_dirs() {
    $exclude = array();
    if( isset( $_POST['exclude'] ) && '' != $_POST['exclude'] ) {
        foreach( explode( "\n", $_POST['exclude'] ) as $ex ) {
            $ex = trim( $ex );
            if( '' !== $ex ) {
                $ex = trim( $ex, "/\\" );
                wpa_wpc_log( sprintf( 'files inside "**SITE_ROOT**/wp-content/%s/" will not be included in the backup', $ex ) );
                $exclude[] = wpCloneSafePathMode( trailingslashit( WPCLONE_WP_CONTENT ) . $ex ) ;
            }
        }
    }
    return $exclude;
}

function wpa_wpc_dir_size( $path ) {

    $i = new RecursiveIteratorIterator( new RecursiveDirectoryIterator( $path ) );
    $size  = 0;
    $files = 0;

    foreach( $i as $file => $info ) {

        if( false === strpos( wpCloneSafePathMode( $file ), WPCLONE_DIR_BACKUP ) ) {
            $size += $info->getSize();
            $files++;

        }

    }

    $ret = array(
        'dbsize' => wpa_wpc_db_size(),
        'size'   => bytesToSize( $size ),
        'files'  => $files,
        'time'   => time()
    );

    update_option( 'wpclone_directory_scan', $ret );
    unset( $ret['time'] );
    return $ret;

}

function wpa_wpc_db_size() {

    global $wpdb;
    $sql = 'SELECT sum(data_length + index_length) FROM information_schema.TABLES WHERE table_schema = "' . DB_NAME . '"';
    $size = $wpdb->get_var( $sql );
    return bytesToSize( $size );

}

function wpa_wpc_scan_dir() {

    $backups = get_option( 'wpclone_backups' );
    $backup_list = array();
    $files = array();
    $old_backups = array();

    foreach( glob( WPCLONE_DIR_BACKUP . '*.zip' ) as $file ){

        $files[] = str_replace( WPCLONE_DIR_BACKUP, '', $file );

    }

    if( false === $backups ) {
        $backups = array();
    }

    foreach( $backups as $key => $backup ) {

        if( ! file_exists( WPCLONE_DIR_BACKUP . $backup['name'] ) ) {
            unset( $backups[$key] );
            continue;
        }
        $backup_list[] = $backup['name'];

    }


    $list = wpa_wpc_filter_list( $files, $backup_list );

    if( ! empty( $list ) ) {

        foreach( $list as $backup ) {

            $time = strtotime( substr( str_replace( array( 'wpclone_backup_', '_', '-' ), array( '', ' ', ':' ), $backup ), 0, 21 ) ) + rand(1, 60);
            $old_backups[$time] = array(
                'name' => $backup,
                'creator' => 'dirscan',
                'size' => @filesize( WPCLONE_DIR_BACKUP . $backup )
            );

        }

    }

    $backups = $backups + $old_backups;
    ksort( $backups );
    update_option( 'wpclone_backups', $backups );

}

/*
 * @link http://stackoverflow.com/questions/2479963/how-does-array-diff-work/6700430#6700430
 */
function wpa_wpc_filter_list( $a, $b ) {

    $return = array();
    foreach( $a as $v ) {
        $return[$v] = '';
    }
    foreach( $b as $v ) {
        unset( $return[$v] );
    }
    return array_keys( $return );

}

function wpa_wpc_log( $msg ) {

    if( ! isset( $GLOBALS['wpclone']['logfile'] ) ) {
        return;
    }
    $file = WPCLONE_DIR_BACKUP . $GLOBALS['wpclone']['logfile'];
    $time = date( 'l, d-M-Y H:i:s', time() + ( get_option( 'gmt_offset' ) * HOUR_IN_SECONDS ) );
    $msg  = $time . ' - ' . $msg . "\r\n";
    file_put_contents( $file, $msg, FILE_APPEND );

}

function wpa_wpc_log_start( $action ) {

    global $wp_version;
    global $wpdb;

    wpa_wpc_log( sprintf( '%s started', $action ) );
    wpa_wpc_log( 'wp version     : ' . $wp_version );
    wpa_wpc_log( 'php version    : ' . phpversion() );
    wpa_wpc_log( 'mysql version  : ' . $wpdb->db_version() );
    wpa_wpc_log( 'memory limit   : ' . ini_get( 'memory_limit' ) );
    wpa_wpc_log( 'execution time : ' . ini_get( 'max_execution_time' ) );
    wpa_wpc_log( 'mysql timeout  : ' . ini_get( 'mysql.connect_timeout' ) );
    wpa_wpc_log( 'socket timeout : ' . ini_get( 'default_socket_timeout' ) );

}

function wpa_wpc_strpos_array( $array, $haystack ) {

    foreach( $array as $needle ) {
        if( false !== strpos( $haystack, $needle ) ) {
            return true;

        }

    }

}

function wpa_wpc_get_filelist( $path, $exclude, $skip = false ) {

    $i = new RecursiveIteratorIterator( new RecursiveDirectoryIterator( $path, FilesystemIterator::CURRENT_AS_SELF | FilesystemIterator::UNIX_PATHS | FilesystemIterator::SKIP_DOTS ) );
    $skipped  = 0;
    $size     = 0;
    $files    = 0;
    $list     = array();

    foreach( $i as $file => $info ) {

        $file = wpCloneSafePathMode( $file );

        if( false !== strpos( $file, WPCLONE_DIR_BACKUP ) ) {
            continue;
        }

        if( false !== strpos( $file, WPCLONE_DIR_PLUGIN ) ) {
            continue;
        }

        if( ! $info->isReadable() ) {
            $skipped++;
            wpa_wpc_log( sprintf( 'file skipped, file is not readable - "%s"',
                                    str_replace( WPCLONE_ROOT, '**SITE-ROOT**/', $file ) ) );
            continue;
            
        }
        
        if( ! empty( $exclude ) && wpa_wpc_strpos_array( $exclude, $file ) ) {
            $skipped++;
            wpa_wpc_log( sprintf( 'file is inside an excluded directory, and it will not be included in the backup - "%s"',
                                    str_replace( WPCLONE_ROOT, '**SITE-ROOT**/', $file ) ) );
            continue;

        }

        if( $skip && $info->getSize() > $skip ) {
            $skipped++;
            wpa_wpc_log( sprintf( 'file skipped, file is larger than %s - "%s"  %s',
                                    bytesToSize( $skip ), str_replace( WPCLONE_ROOT, '**SITE-ROOT**/', $file ), bytesToSize( $info->getSize() ) ) );
            continue;

        }

        if( $info->isFile() ) {
            $list[] = $file;
            $files++;
            $size += $info->getSize();

        }

    }

    if( $skipped > 0 ) {
        wpa_wpc_log( sprintf( '%d files were excluded from the backup', $skipped ) );
    }

    wpa_wpc_log( sprintf( 'number of files to include in the archive is %d, and their uncompressed size is %s',
                            $files, bytesToSize( $size ) ) );

    return $list;

}


function wpa_wpc_zip( $zh, $zipmode ) {

    $file = WPCLONE_DIR_BACKUP . 'wpclone_backup/file.list';

    if( is_readable( $file ) ) {
        $filelist = unserialize( file_get_contents( $file ) );

    } else {
        return false;

    }

    if( $zipmode ) {
        return $filelist;

    }

    foreach( $filelist as $file ) {
        $zh->addFile( $file, str_replace( WPCLONE_ROOT, 'wpclone_backup/', $file ) );

    }

    $zh->deleteName( 'wpclone_backup/file.list' );

}

function wpa_wpc_unzip( $zipfile, $temp_dir ) {

    $z = new ZipArchive();

    if( true === $z->open( $zipfile ) ) {
        $z->extractTo( $temp_dir );

    } else {
        wpa_wpc_log( sprintf( 'failed to open the zip file : %s', $z->getStatusString() ) );
        wpa_backup_error( 'unzip', $z->getStatusString(), true );

    }

}

function wpa_wpc_get_db( $zipfile, $zipmode ) {

    $ret = array();
    if( $zipmode || ( ! in_array( 'ZipArchive', get_declared_classes() ) || ! class_exists( 'ZipArchive' ) ) ) {

        wpa_wpc_log( 'extracting database using pclzip' );

        if ( ini_get('mbstring.func_overload') && function_exists('mb_internal_encoding') ) {
            $previous_encoding = mb_internal_encoding();
            mb_internal_encoding('ISO-8859-1');
        }

        require_once ( ABSPATH . 'wp-admin/includes/class-pclzip.php' );
        $z = new PclZip($zipfile);
        $database = $z->extract( PCLZIP_OPT_BY_NAME, 'wpclone_backup/database.sql', PCLZIP_OPT_EXTRACT_AS_STRING );
        $prefix   = $z->extract( PCLZIP_OPT_BY_NAME, 'wpclone_backup/prefix.txt', PCLZIP_OPT_EXTRACT_AS_STRING );

        if ( isset( $previous_encoding ) ) {
            mb_internal_encoding($previous_encoding);

        }

        if( 'ok' === $database[0]['status'] && 'ok' === $prefix[0]['status'] ) {
            $ret['database'] = $database[0]['content'];
            $ret['prefix']   = $prefix[0]['content'];

        } else {
            wpa_backup_error( 'pclunzip', $z->errorInfo(true), true );

        }

        return $ret;

    } else {

        $z = new ZipArchive();

        if( true === $z->open( $zipfile ) ) {

            wpa_wpc_log( 'extracting database using ziparchive' );
            $ret['database'] = $z->getFromName( 'wpclone_backup/database.sql' );
            $ret['prefix']   = $z->getFromName( 'wpclone_backup/prefix.txt' );
            if( false === $ret['database'] || false === $ret['prefix'] ) {
                wpa_backup_error( 'unzip', $z->getStatusString(), true );

            }

            $z->close();
            return $ret;

        } else {
            wpa_backup_error( 'unzip', $z->getStatusString(), true );

        }

    }

}

function wpa_wpc_process_db( $zipfile, $zipmode = false ) {

    $files   = wpa_wpc_get_db( $zipfile, $zipmode );

    $prefix  = wpa_wpc_get_prefix( $files['prefix'] );
    $old_url = untrailingslashit( wpa_wpc_get_url( $files['database'] ) );
    $cur_url = untrailingslashit( site_url() );
    $found   = false;
    $db      = explode( ";\n", $files['database'] );
    $wpcdb   = wpa_wpc_mysql_connect();
    
    wpa_wpc_log( 'database import started' );
    foreach( $db as $query ) {

        if( ! $found && false !== strpos( $query, '"siteurl",' ) ) {            
            $query = str_replace( $old_url, $cur_url, $query, $count );
            wpa_wpc_log( sprintf( 'updating mysql query with current site\'s url - new query : "%s"', ltrim( $query ) ) );
            if( $count > 0 ) {
                $found = true;
                
            }

        }

        if( isset( $_POST['mysql_check'] ) && 'true' === $_POST['mysql_check'] ) {
            if( ! $wpcdb->ping() ) {
                $wpcdb->close();
                $wpcdb = wpa_wpc_mysql_connect();
            }
        }

        $status = $wpcdb->query( $query );
        
        if( false === $status ) {
            wpa_wpc_log( sprintf( 'mysql query failed. error : %d %s - query : "%s"', $wpcdb->errno(), $wpcdb->error(), ltrim( $query ) ) );
        }

    }
    wpa_wpc_log( 'database import finished' );

    if( $cur_url === $old_url ) {
        wpa_wpc_log( 'URLs are similar, skipping search and replace' );
        $report = 'Search and replace did not run because the URLs are similar';
        
    } else {
        $report = wpa_safe_replace_wrapper( $old_url, $cur_url, $prefix );
        
    }
    
    return $report;


}

function wpa_wpc_get_prefix( $prev_prefix ) {

    global $wpdb;
    $cur_prefix  = $wpdb->prefix;

    if ( $cur_prefix !== $prev_prefix ) {
        wpa_wpc_log( sprintf( 'changing prefix from "%s" to "%s"', $cur_prefix, $prev_prefix ) );
        wpa_replace_prefix( $cur_prefix, $prev_prefix );
        $cur_prefix = $prev_prefix;

    }

    return $cur_prefix;

}


/* end of file */