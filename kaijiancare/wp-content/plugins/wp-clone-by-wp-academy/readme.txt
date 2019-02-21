=== WP Clone by WP Academy ===
Contributors: wpacademy
Donate link: http://members.wpacademy.com/wpclone-faq/
Tags: wp academy, wpacademy, move wordpress, copy wordpress, clone wordpress, install wordpress, wordpress hosting, backup, restore
Author URI: http://wpacademy.com
Plugin URI: http://wpacademy.com/software
Requires at least: 3.0
Tested up to: 4.7.1
Stable tag: 2.2.4
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Move or copy a WordPress site to another server or to another domain name, move to/from local server hosting, and backup sites.

== Description ==

WP Clone is the easiest, fastest and most secure way to move or copy a WordPress site to another domain or hosting server.  You can also use it to move your site to/from local server hosting, to create copies of your site for development or testing purposes, to backup your site, and to install pre-configured versions of WordPress.

WP Clone is a superior solution to even commercial WordPress cloning plugins for the following reasons:

* Does not require FTP access to either the source or destination site &ndash; just install a new WordPress on the destination site, upload and activate WP Clone plugin, and follow the prompts
* It does not backup or restore the WordPress system files (just the user content and database) &ndash; reducing upload time and improving security of your site
* It fetches the site backup via your host&apos;s direct http connection, which saves you from needing to upload large files through your internet connection

<blockquote>
= Update January 2017 =
WP Clone fails to restore in approximately 10% of installations (particularly larger installations), 
as reflected in the negative reviews. <strong>Please carefully read the section below NO SUPPORT AND DISCLAIMER before you attempt to use this plugin</strong>. 
You also may use our <a href="http://members.wpacademy.com/services/">Paid Site Transfer Service</a>.
</blockquote>

= Help Video =
[youtube http://www.youtube.com/watch?v=xN5Ffhyn4Ao]

= NO SUPPORT AND DISCLAIMER =
As mentioned above, WP Clone fails in 10-20% of installations.  As such it is NOT intended as a regular backup method, its strength consists in migrating WordPress installations.  The failures appear to be related to the multiplicity of WordPress hosting platforms and the size of the installation rather than the WordPress version (so please don't feedback "WP Clone does not work for my version of WordPress", this is most probably false). Do however, leave negative reviews and open a discussion on the support forum if you get a failure, providing as much detail as possible, including your hosting system and the size of your site.  We will likely not be able to respond, but the information will be useful in helping to isolate the problems with the different hosting systems.  Thank you. 

= Recommendations for using (or not) WP Clone =
* NEVER overwrite an installation for which you do not have an alternate backup source (i.e. a cPanel backup).  Normally you would restore onto a fresh WP installation on another host or on a subdomain.  If the restore fails your destination site might become unusable, so be  prepared to enter cPanel and then destroy / recreate the new installation if necessary.
* There is never an issue in damaging the source installation. So backup sites at your pleasure. If your backup succeeds it is probable that your restore will also succeed. But don't take any chances.
* Large sites (>2GB) might take as long as an hour to backup. Sites of 250 MB or less should take no more than a minute or two, depending on your server.
* We recommend you deactivate and delete page caching, security and maybe redirection plugins and re-install them on the new site, if necessary.  In general, delete all unnecessary plugins and data from your site before you backup.  You can also use the "Exclude directories" option if you have large media files, which you can then copy back to the new site with FTP. 
* An alternate method that should work in 99% of installations is to do a "Database Only" backup (use "Advanced Settings"), transfer the wp-content directory over with FTP, and then restore new site.
* Note also that WP Clone should NOT be used on WP Engine or any hosting system with proprietary operating system. Instead, use their built-in tools.

You can also try the [Duplicator plugin](https://wordpress.org/plugins/duplicator/) or [All-in-One WP Migration](https://wordpress.org/plugins/all-in-one-wp-migration/), both of which work pretty good, but are not as fast as WP Clone to migrate sites; or use the manual method described here http://wpencyclopedia.com/enc/index.htm?moving-wordpress.htm

= Donations =
Although we are not able to provide support to every installation, we have spent countless hours improving the plugin and responding to user feedback.  
We believe that WP Clone is far and away the easiest WordPress restoration plugin and intend to continue to develop it. 
If you are able to support our efforts, use the [Donations Page](http://members.wpacademy.com/wpclone-faq/).

= Additional documentation =
Additional documentation, including supported hosts, at the [WP Clone FAQ Page](http://members.wpacademy.com/wpclone-faq "WP Clone FAQ")

= Other contributors =
WP Clone uses functions from the "Safe Search and Replace on Database with Serialized Data" script first written by David Coveney of Interconnect IT Ltd (UK) http://www.davidcoveney.com or http://www.interconnectit.com and
released under the WTFPL http://sam.zoy.org/wtfpl/. Partial script with full changelog is placed inside 'lib/files' directory.

If you are able to help out with plugin development or wish to contribute insights into improving the product, we would also appreciate that very much.  Write to marc@wpacademy.com.

== Installation ==

1. Navigate to Plugins > Add New
2. Search for "WP Clone"
3. Install and activate the plugin
4. Follow remaining instructions in the help video

== Frequently Asked Questions ==
Review FAQ's and Help Video at the [WP Clone FAQ Page](http://members.wpacademy.com/wpclone-faq "WP Clone FAQ")

== Changelog ==
= 2.2.4 - 2017-01-28 =
* Updated: Admin area.
* Updated: `Tested up to` tag.

= 2.2.3 - 2016-11-29 =
* Added: PHP7 support
* Added: a multisite check during restore.
* Fixed: failed backups due to unreadable files.

= 2.2.2 - 2015-12-30 =
* Fixed: A bug introduced in 2.2.1 which caused the file archiver to use the wrong zip library on installations where ziparchive is disabled.

= 2.2.1 - 2015-12-29 =
* Fixed: Backup names will use the time zone selected in general settings.
* Added: basic backup/restore logs.
* Added: An option to exclude files based on size (files larger than 25MB will be excluded by default)
* Added: An option to ignore the wordpress table prefix during backup/restore.
* Added: An option to check the mysql connection during restore.
* Added: A search and replace tool into the plugin dashboard.
* Changed: A .htaccess file will be placed in the temporary directories to prevent external access to the files.
* Changed: Files are no longer copied to a temporary location during backup.
* Changed: Database import is done before the rest of the files are extracted.
* Changed: siteurl option is updated during the database import.
* Changed: search and replace will not run when the URLs are similar.
* Changed: Increased the default values for memory_limit and max_execution_time from 512MB/300 to 1024MB/600.
* Removed: The use of wordpress' unzip_file (ziparchive will be used when available with pclzip as fallback)

= 2.2 - 2015-11-16 =
* Fixed: Missing backups that some users encountered after upgrading to 2.1.9
* Added: An option to refresh the backup list.
* Added: An option to remove the database entry and delete all the backup files.
* Added: A section that shows the uncompressed database size and the uncompressed size and the number of files that will be archived during a full backup.
* Added: Notes in the advanced settings section regarding the Maximum memory limit and the Script execution time fields.
* Added: The report returned from the search and replace process into the restore successful page.
* Changed: Moved the backup list location from the custom table to the wp_options table. (previous backups will be imported and the custom table will be removed on existing installations)
* Changed: Moved the system information block from the advanced settings section into the "normal" dashboard page.
* Changed: Only the tables with the wordpress table prefix will be altered during a restore.
* Changed: Only the tables with the wordpress table prefix will be saved during a backup.
* Changed: Backup deletion is now handled using AJAX.

= 2.1.9 - 2015-11-10 =
* Disabled heartbeat on wpclone's admin page.
* DB_CHARSET in wp-config.php is used during direct database transactions.

= 2.1.8 - 2014-09-18 =
* Updated: Readme description.

= 2.1.7 - 2014-07-30 =
* Changed: Admin page links.

= 2.1.6 - 2013-07-07 =
* Added: An option to exclude specific directories during backup.
* Added: An option to only backup the database.
* Added: An admin notice for multisite users.
* Changed: File operations during backup are now handled directly instead of using the WP filesystem abstraction class.

= 2.1.5 - 2013-06-05 =
* Changed: UI Twitter feed from rss to the official twitter widget.
* Changed: UI Sidebar link attributes.

= 2.1.4 - 2013-03-18 =
* Fixed: When javascript is disabled,submit button shows "Create Backup" but the plugin attempts to do a restore.
* Changed: The temporary directory location during the restore process from '/wp-content/' to '/wp-content/wpclone-temp/'.

= 2.1.3 - 2013-03-17 =
* Fixed: The 'copy' link in the 'backup successful' screen which stopped working after the 2.1.2 update.
* Added: An option to backup the database using WordPress' WPDB class.
* Removed: The need to keep the original backup names intact.
* Removed: 'lib/DirectoryTree.php' and 'lib/class.php'.
* Changed: The backup name structure.
* Changed: Backup file downloads are now handled using WP core functions.

= 2.1.2 - 2013-03-07 =
* Fixed: An XSS vulnerability caused by an older version of the ZeroClipboard library.

= 2.1.1 - 2013-02-16 =
* Fixed: a missing nonce action which was causing a wp_nonce_ays loop on some hosts.
* Fixed: a couple of UI issues.

= 2.1 - 2012-12-25 =
* Added: WP Academy sidebar.

= 2.0.6 - 2012-08-05 =
* Added: WP Filesystem integration
* Added: Alternate zip method for better compatibility with hosts that haven't enabled PHP's zip extension

= 2.0.5 - 2012-06-25 =
* Fixed: A secondary search and replace that was corrupting serialized entries

= 2.0.3 - 2012-05-16 =
* Fixed: ignoring trailing slashes in the site URLs

= 2.0.2 -	2012-04-12 =
* Initial release