<script type="text/javascript">
    jQuery ( function($) {

        ZeroClipboard.setDefaults( { moviePath: '<?php echo WPCLONE_URL_PLUGIN ?>lib/js/ZeroClipboard.swf' } );

        /**workaround for firefox versions 18 and 19.
           https://bugzilla.mozilla.org/show_bug.cgi?id=829557
           https://github.com/jonrohan/ZeroClipboard/issues/73
        */
        var enableZC = true;
        var is_firefox18 = navigator.userAgent.toLowerCase().indexOf('firefox/18') > -1;
        var is_firefox19 = navigator.userAgent.toLowerCase().indexOf('firefox/19') > -1;
        if (is_firefox18 || is_firefox19) enableZC = false;

        if ( $( ".restore-backup-options" ).length ) {
            $( ".restore-backup-options" ).each( function() {
                var clip = new ZeroClipboard( $( "a.copy-button",this ) );
                /** FF 18/19 users won't see an alert box. */
                if (enableZC) {
                    clip.on( 'complete', function (client, args) {
                        alert( "Copied to clipboard:\n" + args.text );
                    });
                }
            });
        } else {
            var clip = new ZeroClipboard( $( "a.copy-button" ) );
            /** FF 18/19 users won't see an alert box. */
            if (enableZC) {
                clip.on( 'complete', function (client, args) {
                    alert( "Copied to clipboard:\n" + args.text );
                });
            }
        }
    });

</script>

<?php
if (wpa_wpfs_init()) return;

if( false === get_option( 'wpclone_backups' ) ) wpa_wpc_import_db();
$backups = get_option( 'wpclone_backups' );
?>
<div id="search-n-replace">
    <a href="#" id="close-thickbox" class="button">X</a>
    <form name="searchnreplace" action="#" method="post">
        <table class="searchnreplace">
            <tr><th><label for="searchfor">Search for</label></th><td colspan="5"><input type="text" name="searchfor" /></td></tr>
            <tr><th><label for="replacewith">Replace with</label></th><td colspan="5"><input type="text" name="replacewith" /></td></tr>
            <tr><th><label for="ignoreprefix">Ignore table prefix</label></th><td colspan="2"><input type="checkbox" name="ignoreprefix" value="true" /></td></tr>
        </table>
        <input type="submit" class="button" name="search-n-replace-submit" value="Run">
    </form>
    <div id="search-n-replace-info"></div>
</div>
<div id="wrapper">
<div id="MainView">

    <h2>Welcome to WP Clone by <a href="http://wpacademy.com">WP Academy</a></h2>

    <p>You can use this tool to create a backup of this site and (optionally) restore it to another server, or another WordPress installation on the same server.</p>

    <p><strong>Here is how it works:</strong> the "Backup" function will give you a URL that you can then copy and paste
        into the "Restore" dialog of a new WordPress site, which will clone the original site to the new site. You must
        install the plugin on the new site and then run the WP Clone > Restore function.</p>
    <p><b>Attention:</b> The restore process will fail on approximately 10% of installations and may render your site unusable.
        Please carefully read <a href="http://members.wpacademy.com/wpclone-faq/">No Support and Disclaimer</a>.  
        We do offer <a href="http://members.wpacademy.com/services/">Paid Site Transfer Services</a> using more reliable backup methods.</p>
    
    <p><strong>Choose your selection below:</strong> either create a backup of this site, or choose which backup you
        would like to restore.</p>

    <p>&nbsp;</p>

    <form id="backupForm" name="backupForm" action="#" method="post">
<?php
    if ( isset($_GET['mode']) && 'advanced' == $_GET['mode'] ) { ?>
        <div class="info width-60">
            <table>
                <tr align="left"><th colspan=""><label for="zipmode">Alternate zip method</label></th><td colspan="2"><input type="checkbox" name="zipmode" value="alt" /></td></tr>
                <tr align="left"><th><label for="use_wpdb">Use wpdb to backup the database</label></th><td colspan="2"><input type="checkbox" name="use_wpdb" value="true" /></td></tr>
                <tr align="left"><th><label for="ignore_prefix">Ignore table prefix</label></th><td colspan="2"><input type="checkbox" name="ignore_prefix" value="true" /></td></tr>
                <tr>
                    <td colspan="4">
                        <p>If enabled during a backup, all the tables in the database will be included in the backup.</br>
                        If enabled during a restore, search and replace will alter all the tables in the database.</br>
                        By default, only the tables that share the wordpress table prefix are included/altered during a backup/restore.</p>
                    </td>
                </tr>
                <tr align="left"><th><label for="mysql_check">Refresh MySQL connection during Restore</label></th><td colspan="2"><input type="checkbox" name="mysql_check" value="true" /></td></tr>
                <tr>
                    <td colspan="4">
                        <p>This will check the MySQL connection inside the main loop before each database query during restore. Enable this if the restored site is incomplete.</p>
                    </td>
                </tr>
                <tr><td colspan="4"><h3>Overriding the Maximum memory and Execution time</h3></td></tr>
                <tr><td colspan="4"><p>You can use these two fields to override the maximum memory and execution time on most hosts.</br>
                            For example, if you want to increase the RAM to 2GB, enter <code>2048</code> into the Maximum memory limit field.</br>
                            And if you want to increase the execution time to 15 minutes, enter <code>900</code> into the Script execution time field.</br>
                            Default values will be used if you leave them blank. The default value for RAM is 1024MB and the default value for execution time is 600 seconds (ten minutes).</p></td></tr>                
                <tr align="left"><th><label for="maxmem">Maximum memory limit</label></th><td colspan="2"><input type="text" name="maxmem" /></td></tr>
                <tr align="left"><th><label for="maxexec">Script execution time</label></th><td><input type="text" name="maxexec" /></td></tr>
                <tr><td colspan="4"><h3>Exclude directories from backup, and backup database only</h3></td></tr>
                <tr><td colspan="4"><p>Depending on your web host, WP Clone may  not work for large sites.
                            You may, however, exclude all of your 'wp-content' directory from the backup (use "Backup database only" option below), or exclude specific directories.
                            You would then copy these files over to the new site via FTP before restoring the backup with WP Clone.</p>
                        <p>You could also skip files that are larger than the value entered into the below field. For example, enter <code>100</code> if you want to skip files larger than 100MB.
                            The default value of 25MB will be used If you leave it blank. Enter <code>0</code> if you want to disable it.</p></td></tr>
                <tr align="left"><th><label for="dbonly">Backup database only</label></th><td colspan="2"><input type="checkbox" name="dbonly" value="true" /></td></tr>
                <tr align="left"><th><label for="skipfiles">Skip files larger than</label></th><td><input type="text" name="skipfiles" />&nbsp;<strong>MB</strong></td></tr>
                <tr align="left"><th><label for="exclude">Excluded directories</label></th><td><textarea cols="70" rows="5" name="exclude" ></textarea></td></tr>
                <tr><th></th><td colspan="5"><p>Enter one per line, i.e.  <code>uploads/backups</code>,use the forward slash <code>/</code> as the directory separator. Directories start at 'wp-content' level.</br>
                </br>For example, BackWPup saves its backups into <code>/wp-content/uploads/backwpup-abc123-backups/</code> (the middle part, 'abc123' in this case, is random characters).
                If you wanted to exclude that directory, you have to enter <code>uploads/backwpup-abc123-backups</code> into the above field.</p></td></tr>                
            </table>
        </div>
<?php
}
?>
        <strong>Create Backup</strong>
        <input id="createBackup" name="createBackup" type="radio" value="fullBackup" checked="checked"/><br/><br/>

        <?php if( false !== $backups && ! empty( $backups ) ) : ?>

        <div class="try">

            <table class="restore-backup-options">

            <?php

                foreach ($backups AS $key => $backup) :

                $filename = convertPathIntoUrl(WPCLONE_DIR_BACKUP . $backup['name']);
                $url = wp_nonce_url( get_bloginfo('wpurl') . '/wp-admin/admin.php?page=wp-clone&del=' . $key, 'wpclone-submit');

            ?>
                <tr>
                    <th>Restore backup</th>

                    <td><input class="restoreBackup" name="restoreBackup" type="radio" value="<?php echo $filename ?>" /></td>

                    <td>
                        <a href="<?php echo $filename ?>" class="zclip"> (<?php echo bytesToSize($backup['size']);?>)&nbsp;&nbsp;<?php echo $backup['name'] ?></a>
                        <input type="hidden" name="backup_name" value="<?php echo $filename ?>" />
                    </td>
                    <?php                        
                        if( isset( $backup['log'] ) ){
                            printf( '<td><a href="%s">log</a></td>', convertPathIntoUrl(WPCLONE_DIR_BACKUP . $backup['log'] ) ); 
                        } else {
                            echo '<td>&mdash;</td>';
                        }
                    ?>
                    <td><a class="copy-button" href="#" data-clipboard-text="<?php echo $filename ?>" >Copy URL</a></td>
                    <td><a href="<?php echo $url; ?>" class="delete" data-fileid="<?php echo $key; ?>">Delete</a></td>
                    
                </tr>

                <?php endforeach ?>

            </table>
        </div>

        <?php endif ?>

        <strong>Restore from URL:</strong><input id="backupUrl" name="backupUrl" type="radio" value="backupUrl"/>

        <input type="text" name="restore_from_url" class="Url" value="" size="80px"/><br/><br/>

        <div class="RestoreOptions" id="RestoreOptions">

            <input type="checkbox" name="approve" id="approve" /> I AGREE (Required for "Restore" function):<br/>

            1. You have nothing of value in your current site <strong>[<?php echo site_url() ?>]</strong><br/>

            2. Your current site at <strong>[<?php echo site_url() ?>]</strong> may become unusable in case of failure,
            and you will need to re-install WordPress<br/>

            3. Your WordPress database <strong>[<?php echo DB_NAME; ?>]</strong> will be overwritten from the database in the backup file. <br/>

        </div>

        <input id="submit" name="submit" class="btn-primary btn" type="submit" value="Create Backup"/>


    <?php wp_nonce_field('wpclone-submit')?>
    </form>
    <?php
        if(!isset($_GET['mode'])){
            $link = admin_url( 'admin.php?page=wp-clone&mode=advanced' );
            echo "<p style='padding:5px;'><a href='{$link}' style='margin-top:10px'>Advanced Settings</a></p>";
        }


        echo "<p><a href='#' id='dirscan' class='button' style='margin-top:10px'>Scan and repopulate the backup list</a>"
        . "</br>Use the above button to refresh your backup list. It will list <em>all</em> the zip files found in the backup directory, it will also remove references to files that no longer exist.</p>";

        wpa_wpc_sysinfo();

        echo "<p><a href='#' id='uninstall' class='button' style='margin-top:10px'>Delete backups and remove database entries</a>"
        . "</br>WP Clone does not remove backups when you deactivate the plugin. Use the above button if you want to remove all the backups.</p>";

        echo '<p><a href="#TB_inline?height=200&width=600&inlineId=search-n-replace&modal=true" class="thickbox">Search and Replace</a></p>';


    ?>
</div>
<div id="sidebar">		

		<ul>
			<h2>Managed WordPress Hosting from $12/mth, with 6 months free!</h2>
                        <p>Watch us test the performance of WP Academy hosting, and review benefits</p>
                        <iframe src="//player.vimeo.com/video/187757407?title=0&amp;byline=0&amp;portrait=0" width="300" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>                        
                        <p>Get true <a href="http://wpacademy.com/hosting">Managed WordPress Hosting</a> for just $12/mth (20% discount) 
                            <a href ="https://wpwebsitenow.com/billing/cart.php?a=add&pid=9">here</a>.
                            Enter coupon <b>FREE6</b> at checkout for additional 6 months free. Unlimited sites!</p>
			
		</ul>
    
                <ul>
			<h2>Site Transfer Service from $10!</h2>
                        <a href="http://members.wpacademy.com/services/"><img src="//d28zm3zq58hlat.cloudfront.net/img/wordpress-site-clone-backup-buddy.jpg" /></a>
                        <p>Save time and avoid headaches: hire us to transfer your site.  
                            The <a href="http://members.wpacademy.com/product/clone-backupbuddy/">upgrade option</a> even includes a lifetime license and configuration of 
                            <b>Backup Buddy</b>, the best WordPress backup plugin!</p>
			
		</ul>

    
		<ul>
			<h2>Help & Support</h2>
			<li><a href="http://members.wpacademy.com/wpclone-faq" target="_blank" title="WP Clone FAQ">Visit the WP Clone FAQ Page</a></li>
			<li><a href="http://wordpress.org/support/plugin/wp-clone-by-wp-academy" target="_blank" title="Support Forum">Support forum at WordPress.org</a></li>
                        <li><a href="http://members.wpacademy.com/services/">Paid Site Transfer Service</a></li>
		</ul>

	</div>
</div> <!--wrapper-->
<p style="clear: both;" ></p>
<?php

    function wpa_wpc_sysinfo(){
        global $wpdb;
        echo '<div class="info width-60">';
        echo '<h3>System Info:</h3><p>';
        echo 'Memory limit: ' . ini_get('memory_limit');
        if( false === ini_set( 'memory_limit', '257M' ) ) {
            echo '&nbsp;<span style="color:#660000">memory limit cannot be increased</span></br>';
        } else {
            echo '</br>';
        }
        echo 'Maximum execution time: ' . ini_get('max_execution_time') . ' seconds</br>';
        echo 'PHP version : ' . phpversion() . '</br>';
        echo 'MySQL version : ' . $wpdb->db_version() . '</br>';
        if (ini_get('safe_mode')) { echo '<span style="color:#f11">PHP is running in safemode!</span></br>'; }
        printf( 'Root directory : <code>%s</code></br>', WPCLONE_ROOT );
        if ( ! file_exists( WPCLONE_DIR_BACKUP ) ) {
            echo 'Backup path :<span style="color:#660000">Backup directory not found. '
            . 'Unless there is a permissions or ownership issue, refreshing the backup list should create the directory.</span></br>';
        } else {
            echo 'Backup directory : <code>' . WPCLONE_DIR_BACKUP . '</code></br>';
        }
        echo 'Files : <span id="filesize"><img src="' . esc_url( admin_url( 'images/spinner.gif' ) ) . '"></span></br>';
        if ( file_exists( WPCLONE_DIR_BACKUP ) && !is_writable(WPCLONE_DIR_BACKUP)) { echo '<span style="color:#f11">Backup directory is not writable, please change its permissions.</span></br>'; }
        if (!is_writable(WPCLONE_WP_CONTENT)) { echo '<span style="color:#f11">wp-content is not writable, please change its permissions before you perform a restore.</span></br>'; }
        if (!is_writable(wpa_wpconfig_path())) { echo '<span style="color:#f11">wp-config.php is not writable, please change its permissions before you perform a restore.</span></br>'; }
        echo '</p></div>';
    }    

/** it all ends here folks. */