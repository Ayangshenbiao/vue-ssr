<?php

namespace FernleafSystems\Wordpress\Services\Core;

use FernleafSystems\Wordpress\Services\Services;
use FernleafSystems\Wordpress\Services\Utilities\ClassicPress\Checksums;

class General {

	/**
	 * @var string
	 */
	protected $sWpVersion;

	/**
	 * @return null|string
	 */
	public function findWpLoad() {
		return $this->findWpCoreFile( 'wp-load.php' );
	}

	/**
	 * @param $sFilename
	 * @return null|string
	 */
	public function findWpCoreFile( $sFilename ) {
		$sLoaderPath = __DIR__;
		$nLimiter = 0;
		$nMaxLimit = count( explode( DIRECTORY_SEPARATOR, trim( $sLoaderPath, DIRECTORY_SEPARATOR ) ) );
		$bFound = false;

		do {
			if ( @is_file( $sLoaderPath.DIRECTORY_SEPARATOR.$sFilename ) ) {
				$bFound = true;
				break;
			}
			$sLoaderPath = realpath( $sLoaderPath.DIRECTORY_SEPARATOR.'..' );
			$nLimiter++;
		} while ( $nLimiter < $nMaxLimit );

		return $bFound ? $sLoaderPath.DIRECTORY_SEPARATOR.$sFilename : null;
	}

	/**
	 * @param string $sRedirect
	 * @return bool
	 */
	public function doForceRunAutomaticUpdates( $sRedirect = '' ) {

		$lock_name = 'auto_updater.lock'; //ref: /wp-admin/includes/class-wp-upgrader.php
		delete_option( $lock_name );
		if ( !defined( 'DOING_CRON' ) ) {
			define( 'DOING_CRON', true ); // this prevents WP from disabling plugins pre-upgrade
		}

		// does the actual updating
		wp_maybe_auto_update();

		if ( !empty( $sRedirect ) ) {
			$this->doRedirect( network_admin_url( $sRedirect ) );
		}
		return true;
	}

	/**
	 * @return bool
	 */
	public function getIsRunningAutomaticUpdates() {
		return ( get_option( 'auto_updater.lock' ) ? true : false );
	}

	/**
	 * @return bool
	 */
	public function isDebug() {
		return defined( 'WP_DEBUG' ) && WP_DEBUG;
	}

	/**
	 * Clears any WordPress caches
	 */
	public function doBustCache() {
		global $_wp_using_ext_object_cache, $wp_object_cache;
		$_wp_using_ext_object_cache = false;
		if ( !empty( $wp_object_cache ) ) {
			@$wp_object_cache->flush();
		}
	}

	/**
	 * @return bool
	 */
	public function getIsPermalinksEnabled() {
		return ( $this->getOption( 'permalink_structure' ) ? true : false );
	}

	/**
	 * @see wp_redirect_admin_locations()
	 * @return array
	 */
	public function getAutoRedirectLocations() {
		return array( 'wp-admin', 'dashboard', 'admin', 'login', 'wp-login.php' );
	}

	/**
	 * @return string[]
	 */
	public function getCoreChecksums() {
		return $this->isClassicPress() ? $this->getCoreChecksums_CP() : $this->getCoreChecksums_WP();
	}

	/**
	 * @return string[]
	 */
	private function getCoreChecksums_CP() {
		try {
			return ( new Checksums() )->getChecksums();
		}
		catch ( \Exception $oE ) {
			return [];
		}
	}

	/**
	 * @return string[]
	 */
	private function getCoreChecksums_WP() {
		$aChecksumData = array();
		$sCurrentVersion = $this->getVersion();

		include_once( ABSPATH.'/wp-admin/includes/update.php' );
		if ( function_exists( 'get_core_checksums' ) ) { // if it's loaded, we use it.
			$aChecksumData = get_core_checksums( $sCurrentVersion, $this->getLocale( true ) );
		}
		else {
			$aQueryArgs = array(
				'version' => $sCurrentVersion,
				'locale'  => $this->getLocale( true )
			);
			$sQueryUrl = add_query_arg( $aQueryArgs, 'https://api.wordpress.org/core/checksums/1.0/' );
			$sResponse = Services::WpFs()->getUrlContent( $sQueryUrl );
			if ( !empty( $sResponse ) ) {
				$aDecodedResponse = json_decode( trim( $sResponse ), true );
				if ( is_array( $aDecodedResponse ) && isset( $aDecodedResponse[ 'checksums' ] ) && is_array( $aDecodedResponse[ 'checksums' ] ) ) {
					$aChecksumData = $aDecodedResponse[ 'checksums' ];
				}
			}
		}
		return $aChecksumData;
	}

	/**
	 * @param string $sPath
	 * @param bool   $bWpmsOnly
	 * @return string
	 */
	public function getAdminUrl( $sPath = '', $bWpmsOnly = false ) {
		return $bWpmsOnly ? network_admin_url( $sPath ) : admin_url( $sPath );
	}

	/**
	 * @param bool $bWpmsOnly
	 * @return string
	 */
	public function getAdminUrl_Plugins( $bWpmsOnly = false ) {
		return $this->getAdminUrl( 'plugins.php', $bWpmsOnly );
	}

	/**
	 * @param bool $bWpmsOnly
	 * @return string
	 */
	public function getAdminUrl_Themes( $bWpmsOnly = false ) {
		return $this->getAdminUrl( 'themes.php', $bWpmsOnly );
	}

	/**
	 * @param bool $bWpmsOnly
	 * @return string
	 */
	public function getAdminUrl_Updates( $bWpmsOnly = false ) {
		return $this->getAdminUrl( 'update-core.php', $bWpmsOnly );
	}

	/**
	 * @param bool $bRemoveSchema
	 * @return string
	 */
	public function getHomeUrl( $bRemoveSchema = false ) {
		$sUrl = home_url();
		if ( empty( $sUrl ) ) {
			remove_all_filters( 'home_url' );
			$sUrl = home_url();
		}
		if ( $bRemoveSchema ) {
			$sUrl = preg_replace( '#^((http|https):)?\/\/#i', '', $sUrl );
		}
		return $sUrl;
	}

	/**
	 * @param string $sPath
	 * @return string
	 */
	public function getUrlWithPath( $sPath ) {
		return rtrim( $this->getHomeUrl(), '/' ).'/'.ltrim( $sPath, '/' );
	}

	/**
	 * @param bool $bRemoveSchema
	 * @return string
	 */
	public function getWpUrl( $bRemoveSchema = false ) {
		$sUrl = network_site_url();
		if ( empty( $sUrl ) ) {
			remove_all_filters( 'site_url' );
			remove_all_filters( 'network_site_url' );
			$sUrl = network_site_url();
		}
		if ( $bRemoveSchema ) {
			$sUrl = preg_replace( '#^((http|https):)?\/\/#i', '', $sUrl );
		}
		return $sUrl;
	}

	/**
	 * @param string $sPageSlug
	 * @param bool   $bWpmsOnly
	 * @return string
	 */
	public function getUrl_AdminPage( $sPageSlug, $bWpmsOnly = false ) {
		$sUrl = sprintf( 'admin.php?page=%s', $sPageSlug );
		return $bWpmsOnly ? network_admin_url( $sUrl ) : admin_url( $sUrl );
	}

	/**
	 * @param bool $bForChecksums
	 * @return string
	 */
	public function getLocale( $bForChecksums = false ) {
		$sLocale = get_locale();
		if ( $bForChecksums ) {
			global $wp_local_package;
			$sLocale = empty( $wp_local_package ) ? 'en_US' : $wp_local_package;
		}
		return $sLocale;
	}

	/**
	 * @param int $nTime
	 * @return string
	 */
	public function getTimeStampForDisplay( $nTime = null ) {
		$nTime = empty( $nTime ) ? Services::Request()->time() : $nTime;
		return date_i18n( DATE_RFC2822, $this->getTimeAsGmtOffset( $nTime ) );
	}

	/**
	 * @param string $sType - plugins, themes
	 * @return array
	 */
	public function getWordpressUpdates( $sType = 'plugins' ) {
		$oCurrent = $this->getTransient( 'update_'.$sType );
		return ( isset( $oCurrent->response ) && is_array( $oCurrent->response ) ) ? $oCurrent->response : array();
	}

	/**
	 * @param string $sKey
	 * @return mixed
	 */
	public function getTransient( $sKey ) {
		// TODO: Handle multisite

		if ( function_exists( 'get_site_transient' ) ) {
			$mResult = get_site_transient( $sKey );
			if ( empty( $mResult ) ) {
				remove_all_filters( 'pre_site_transient_'.$sKey );
				$mResult = get_site_transient( $sKey );
			}
		}
		else if ( version_compare( $this->getVersion(), '2.7.9', '<=' ) ) {
			$mResult = get_option( $sKey );
		}
		else if ( version_compare( $this->getVersion(), '2.9.9', '<=' ) ) {
			$mResult = apply_filters( 'transient_'.$sKey, get_option( '_transient_'.$sKey ) );
		}
		else {
			$mResult = apply_filters( 'site_transient_'.$sKey, get_option( '_site_transient_'.$sKey ) );
		}
		return $mResult;
	}

	/**
	 * @return bool
	 */
	public function isClassicPress() {
		return function_exists( 'classicpress_version' );
	}

	/**
	 * @param string $sKey
	 * @param mixed  $mValue
	 * @param int    $nExpire
	 * @return bool
	 */
	public function setTransient( $sKey, $mValue, $nExpire = 0 ) {
		return set_site_transient( $sKey, $mValue, $nExpire );
	}

	/**
	 * @param $sKey
	 * @return bool
	 */
	public function deleteTransient( $sKey ) {

		if ( version_compare( $this->getVersion(), '2.7.9', '<=' ) ) {
			$bResult = delete_option( $sKey );
		}
		else if ( function_exists( 'delete_site_transient' ) ) {
			$bResult = delete_site_transient( $sKey );
		}
		else if ( version_compare( $this->getVersion(), '2.9.9', '<=' ) ) {
			$bResult = delete_option( '_transient_'.$sKey );
		}
		else {
			$bResult = delete_option( '_site_transient_'.$sKey );
		}
		return $bResult;
	}

	/**
	 * TODO: Create ClassicPress override class for this stuff
	 * @param bool $bAlwaysWp if true returns the $wp_version regardless of ClassicPress or not
	 * @return string
	 */
	public function getVersion( $bAlwaysWp = false ) {

		if ( empty( $this->sWpVersion ) ) {
			$sVersionContents = file_get_contents( ABSPATH.WPINC.'/version.php' );

			if ( preg_match( '/wp_version\s=\s\'([^(\'|")]+)\'/i', $sVersionContents, $aMatches ) ) {
				$this->sWpVersion = $aMatches[ 1 ];
			}
			else {
				global $wp_version;
				$this->sWpVersion = $wp_version;
			}
		}
		return ( $bAlwaysWp || !$this->isClassicPress() ) ? $this->sWpVersion : classicpress_version();
	}

	/**
	 * @param string $sVersionToMeet
	 * @return boolean
	 */
	public function getWordpressIsAtLeastVersion( $sVersionToMeet ) {
		return version_compare( $this->getVersion(), $sVersionToMeet, '>=' );
	}

	/**
	 * @param string $sPluginBaseFilename
	 * @return boolean
	 */
	public function getIsPluginAutomaticallyUpdated( $sPluginBaseFilename ) {
		$oUpdater = $this->getWpAutomaticUpdater();
		if ( !$oUpdater ) {
			return false;
		}

		// This is due to a change in the filter introduced in version 3.8.2
		if ( $this->getWordpressIsAtLeastVersion( '3.8.2' ) ) {
			$mPluginItem = new \stdClass();
			$mPluginItem->plugin = $sPluginBaseFilename;
		}
		else {
			$mPluginItem = $sPluginBaseFilename;
		}

		return $oUpdater->should_update( 'plugin', $mPluginItem, WP_PLUGIN_DIR );
	}

	/**
	 * @param array $aQueryParams
	 */
	public function redirectToLogin( $aQueryParams = array() ) {
		$this->doRedirect( wp_login_url(), $aQueryParams );
	}

	/**
	 * @param array $aQueryParams
	 */
	public function redirectToAdmin( $aQueryParams = array() ) {
		$this->doRedirect( is_multisite() ? get_admin_url() : admin_url(), $aQueryParams );
	}

	/**
	 * @param array $aQueryParams
	 */
	public function redirectToHome( $aQueryParams = array() ) {
		$this->doRedirect( home_url(), $aQueryParams );
	}

	/**
	 * @param string $sUrl
	 * @param array  $aQueryParams
	 * @param bool   $bSafe
	 * @param bool   $bProtectAgainstInfiniteLoops - if false, ignores the redirect loop protection
	 */
	public function doRedirect( $sUrl, $aQueryParams = array(), $bSafe = true, $bProtectAgainstInfiniteLoops = true ) {
		$sUrl = empty( $aQueryParams ) ? $sUrl : add_query_arg( $aQueryParams, $sUrl );

		// we prevent any repetitive redirect loops
		if ( $bProtectAgainstInfiniteLoops ) {
			if ( Services::Request()->cookie( 'icwp-isredirect' ) == 'yes' ) {
				return;
			}
			else {
				Services::Data()->setCookie( 'icwp-isredirect', 'yes', 7 );
			}
		}

		// based on: https://make.wordpress.org/plugins/2015/04/20/fixing-add_query_arg-and-remove_query_arg-usage/
		// we now escape the URL to be absolutely sure since we can't guarantee the URL coming through there
		$sUrl = esc_url_raw( $sUrl );
		$bSafe ? wp_safe_redirect( $sUrl ) : wp_redirect( $sUrl );
		exit();
	}

	/**
	 * @return string
	 */
	public function getCurrentPage() {
		global $pagenow;
		return $pagenow;
	}

	/**
	 * @return \WP_Post
	 */
	public function getCurrentPost() {
		global $post;
		return $post;
	}

	/**
	 * @return int
	 */
	public function getCurrentPostId() {
		$oPost = $this->getCurrentPost();
		return empty( $oPost->ID ) ? -1 : $oPost->ID;
	}

	/**
	 * @param $nPostId
	 * @return false|\WP_Post
	 */
	public function getPostById( $nPostId ) {
		return \WP_Post::get_instance( $nPostId );
	}

	/**
	 * @return string
	 */
	public function getUrl_CurrentAdminPage() {

		$sPage = $this->getCurrentPage();
		$sUrl = self_admin_url( $sPage );

		//special case for plugin admin pages.
		if ( $sPage == 'admin.php' ) {
			$sSubPage = Services::Request()->query( 'page' );
			if ( !empty( $sSubPage ) ) {
				$aQueryArgs = array(
					'page' => $sSubPage,
				);
				$sUrl = add_query_arg( $aQueryArgs, $sUrl );
			}
		}
		return $sUrl;
	}

	/**
	 * @param string
	 * @return string
	 */
	public function getIsCurrentPage( $sPage ) {
		return $sPage == $this->getCurrentPage();
	}

	/**
	 * @param string
	 * @return string
	 */
	public function getIsPage_Updates() {
		return $this->getIsCurrentPage( 'update.php' );
	}

	/**
	 * @return bool
	 */
	public function getIsLoginRequest() {
		$oReq = Services::Request();
		return
			$oReq->isPost()
			&& !is_null( $oReq->post( 'log' ) )
			&& !is_null( $oReq->post( 'pwd' ) )
			&& $this->getIsLoginUrl();
	}

	/**
	 * @return bool
	 */
	public function getIsRegisterRequest() {
		$oReq = Services::Request();
		return
			$oReq->isPost()
			&& !is_null( $oReq->post( 'user_login' ) )
			&& !is_null( $oReq->post( 'user_email' ) )
			&& $this->getIsLoginUrl();
	}

	/**
	 * @return bool
	 */
	public function getIsLoginUrl() {
		$aLoginUrlParts = @parse_url( wp_login_url() );
		$aRequestParts = Services::Request()->getRequestUriParts();
		return ( !empty( $aRequestParts[ 'path' ] ) && ( rtrim( $aRequestParts[ 'path' ], '/' ) == rtrim( $aLoginUrlParts[ 'path' ], '/' ) ) );
	}

	/**
	 * @param $sTermSlug
	 * @return bool
	 */
	public function getDoesWpSlugExist( $sTermSlug ) {
		return ( $this->getDoesWpPostSlugExist( $sTermSlug ) || term_exists( $sTermSlug ) );
	}

	/**
	 * @param $sTermSlug
	 * @return bool
	 */
	public function getDoesWpPostSlugExist( $sTermSlug ) {
		$oDb = Services::WpDb();
		$sQuery = "
				SELECT ID
				FROM %s
				WHERE
					post_name = '%s'
					LIMIT 1
			";
		$sQuery = sprintf(
			$sQuery,
			$oDb->getTable_Posts(),
			$sTermSlug
		);
		$nResult = $oDb->getVar( $sQuery );
		return !is_null( $nResult ) && $nResult > 0;
	}

	/**
	 * @return string
	 */
	public function getSiteName() {
		return function_exists( 'get_bloginfo' ) ? get_bloginfo( 'name' ) : 'WordPress Site';
	}

	/**
	 * @return string
	 */
	public function getSiteAdminEmail() {
		return function_exists( 'get_bloginfo' ) ? get_bloginfo( 'admin_email' ) : '';
	}

	/**
	 * @return string
	 */
	public function getCookieDomain() {
		return defined( 'COOKIE_DOMAIN' ) ? COOKIE_DOMAIN : false;
	}

	/**
	 * @return string
	 */
	public function getCookiePath() {
		return defined( 'COOKIEPATH' ) ? COOKIEPATH : '/';
	}

	/**
	 * @return boolean
	 */
	public function getIsAjax() {
		return defined( 'DOING_AJAX' ) && DOING_AJAX;
	}

	/**
	 * @return boolean
	 */
	public function getIsCron() {
		return defined( 'DOING_CRON' ) && DOING_CRON;
	}

	/**
	 * @return boolean
	 */
	public function getIsXmlrpc() {
		return defined( 'XMLRPC_REQUEST' ) && XMLRPC_REQUEST;
	}

	/**
	 * @return boolean
	 */
	public function getIsMobile() {
		return function_exists( 'wp_is_mobile' ) && wp_is_mobile();
	}

	/**
	 * @return array
	 */
	public function getAllUserLoginUsernames() {
		$aUsers = get_users( array( 'fields' => array( 'user_login' ) ) );
		$aLogins = array();
		foreach ( $aUsers as $oUser ) {
			$aLogins[] = $oUser->user_login;
		}
		return $aLogins;
	}

	/**
	 * @return bool
	 */
	public function isMultisite() {
		if ( !isset( $this->bIsMultisite ) ) {
			$this->bIsMultisite = function_exists( 'is_multisite' ) && is_multisite();
		}
		return $this->bIsMultisite;
	}

	/**
	 * @param string $sKey
	 * @param string $sValue
	 * @return bool
	 */
	public function addOption( $sKey, $sValue ) {
		return $this->isMultisite() ? add_site_option( $sKey, $sValue ) : add_option( $sKey, $sValue );
	}

	/**
	 * @param string $sKey
	 * @param        $sValue
	 * @return boolean
	 */
	public function updateOption( $sKey, $sValue ) {
		return $this->isMultisite() ? update_site_option( $sKey, $sValue ) : update_option( $sKey, $sValue );
	}

	/**
	 * @param string $sKey
	 * @param mixed  $mDefault
	 * @return mixed
	 */
	public function getOption( $sKey, $mDefault = false ) {
		return $this->isMultisite() ? get_site_option( $sKey, $mDefault ) : get_option( $sKey, $mDefault );
	}

	/**
	 * @param string $sKey
	 * @return mixed
	 */
	public function deleteOption( $sKey ) {
		return $this->isMultisite() ? delete_site_option( $sKey ) : delete_option( $sKey );
	}

	/**
	 * @return string
	 */
	public function getCurrentWpAdminPage() {
		$oReq = Services::Request();
		$sScript = $oReq->server( 'SCRIPT_NAME' );
		if ( empty( $sScript ) ) {
			$sScript = $oReq->server( 'PHP_SELF' );
		}
		if ( is_admin() && !empty( $sScript ) && basename( $sScript ) == 'admin.php' ) {
			$sCurrentPage = $oReq->query( 'page' );
		}
		return empty( $sCurrentPage ) ? '' : $sCurrentPage;
	}

	/**
	 * @param int|null $nTime
	 * @param bool     $bShowTime
	 * @param bool     $bShowDate
	 * @return string
	 */
	public function getTimeStringForDisplay( $nTime = null, $bShowTime = true, $bShowDate = true ) {
		$nTime = empty( $nTime ) ? Services::Request()->time() : $nTime;

		$sFullTimeString = $bShowTime ? $this->getTimeFormat() : '';
		if ( empty( $sFullTimeString ) ) {
			$sFullTimeString = $bShowDate ? $this->getDateFormat() : '';
		}
		else {
			$sFullTimeString = $bShowDate ? ( $sFullTimeString.' '.$this->getDateFormat() ) : $sFullTimeString;
		}
		return date_i18n( $sFullTimeString, $this->getTimeAsGmtOffset( $nTime ) );
	}

	/**
	 * @param null $nTime
	 * @return int|null
	 */
	public function getTimeAsGmtOffset( $nTime = null ) {

		$nTimezoneOffset = wp_timezone_override_offset();
		if ( $nTimezoneOffset === false ) {
			$nTimezoneOffset = $this->getOption( 'gmt_offset' );
			if ( empty( $nTimezoneOffset ) ) {
				$nTimezoneOffset = 0;
			}
		}

		$nTime = empty( $nTime ) ? Services::Request()->time() : $nTime;
		return $nTime + ( $nTimezoneOffset*HOUR_IN_SECONDS );
	}

	/**
	 * @return string
	 */
	public function getTimeFormat() {
		$sFormat = $this->getOption( 'time_format' );
		if ( empty( $sFormat ) ) {
			$sFormat = 'H:i';
		}
		return $sFormat;
	}

	/**
	 * @return string
	 */
	public function getDateFormat() {
		$sFormat = $this->getOption( 'date_format' );
		if ( empty( $sFormat ) ) {
			$sFormat = 'F j, Y';
		}
		return $sFormat;
	}

	/**
	 * @return false|\WP_Automatic_Updater
	 */
	public function getWpAutomaticUpdater() {
		if ( !isset( $this->oWpAutomaticUpdater ) ) {
			if ( !class_exists( 'WP_Automatic_Updater', false ) ) {
				include_once( ABSPATH.'wp-admin/includes/class-wp-upgrader.php' );
			}
			if ( class_exists( 'WP_Automatic_Updater', false ) ) {
				$this->oWpAutomaticUpdater = new \WP_Automatic_Updater();
			}
			else {
				$this->oWpAutomaticUpdater = false;
			}
		}
		return $this->oWpAutomaticUpdater;
	}

	/**
	 * Flushes the Rewrite rules and forces a re-commit to the .htaccess where applicable
	 */
	public function resavePermalinks() {
		/** @var \WP_Rewrite $wp_rewrite */
		global $wp_rewrite;
		if ( is_object( $wp_rewrite ) ) {
			$wp_rewrite->flush_rules( true );
		}
	}

	/**
	 * @return bool
	 */
	public function turnOffCache() {
		if ( !defined( 'DONOTCACHEPAGE' ) ) {
			define( 'DONOTCACHEPAGE', true );
		}
		return DONOTCACHEPAGE;
	}

	/**
	 * @param string $sMessage
	 * @param string $sTitle
	 * @param bool   $bTurnOffCachePage
	 */
	public function wpDie( $sMessage, $sTitle = '', $bTurnOffCachePage = true ) {
		if ( $bTurnOffCachePage ) {
			$this->turnOffCache();
		}
		wp_die( $sMessage, $sTitle );
	}

	/**
	 * @deprecated
	 * @param string $sPluginFile
	 * @return boolean
	 */
	public function doPluginUpgrade( $sPluginFile ) {
		Services::WpPlugins()->update( $sPluginFile );
	}

	/**
	 * @deprecated
	 * @return array
	 */
	public function getWordpressUpdates_Plugins() {
		return Services::WpPlugins()->getUpdates();
	}

	/**
	 * @deprecated
	 * @param string $sCompareString
	 * @param string $sKey
	 * @return bool|string
	 */
	public function getIsPluginInstalled( $sCompareString, $sKey = 'Name' ) {
		$aPlugins = $this->getPlugins();
		if ( empty( $aPlugins ) || !is_array( $aPlugins ) ) {
			return false;
		}

		foreach ( $aPlugins as $sBaseFileName => $aPluginData ) {
			if ( isset( $aPluginData[ $sKey ] ) && $sCompareString == $aPluginData[ $sKey ] ) {
				return $sBaseFileName;
			}
		}
		return false;
	}

	/**
	 * @deprecated
	 * @param string $sPluginBaseFile
	 * @return bool
	 */
	public function getIsPluginInstalledByFile( $sPluginBaseFile ) {
		return Services::WpPlugins()->isInstalled( $sPluginBaseFile );
	}

	/**
	 * @deprecated
	 * @return array
	 */
	public function getThemes() {
		return Services::WpThemes()->getThemes();
	}

	/**
	 * @deprecated
	 * @param string $sPluginFile
	 * @return string
	 */
	public function getPluginActivateLink( $sPluginFile ) {
		return Services::WpPlugins()->getLinkPluginActivate( $sPluginFile );
	}

	/**
	 * @deprecated
	 * @param string $sPluginFile
	 * @return string
	 */
	public function getPluginDeactivateLink( $sPluginFile ) {
		return Services::WpPlugins()->getLinkPluginDeactivate( $sPluginFile );
	}

	/**
	 * @deprecated
	 * @param string $sPluginFile
	 * @return string
	 */
	public function getPluginUpgradeLink( $sPluginFile ) {
		return Services::WpPlugins()->getLinkPluginUpgrade( $sPluginFile );
	}

	/**
	 * @deprecated
	 * @param string $sPluginFile
	 * @return int
	 */
	public function getActivePluginLoadPosition( $sPluginFile ) {
		return Services::WpPlugins()->getActivePluginLoadPosition( $sPluginFile );
	}

	/**
	 * @deprecated
	 * @return array
	 */
	public function getActivePlugins() {
		return Services::WpPlugins()->getActivePlugins();
	}

	/**
	 * @deprecated
	 * @return array
	 */
	public function getPlugins() {
		return Services::WpPlugins()->getPlugins();
	}

	/**
	 * @deprecated
	 * @param string $sRootPluginFile - the full path to the root plugin file
	 * @return \stdClass
	 */
	public function getPluginData( $sRootPluginFile ) {
		return Services::WpPlugins()->getExtendedData( $sRootPluginFile );
	}

	/**
	 * @deprecated
	 * @param string $sPluginFile
	 * @return \stdClass|null
	 */
	public function getPluginUpdateInfo( $sPluginFile ) {
		return Services::WpPlugins()->getUpdateInfo( $sPluginFile );
	}

	/**
	 * @deprecated
	 * @param string $sPluginFile
	 * @return string
	 */
	public function getPluginUpdateNewVersion( $sPluginFile ) {
		return Services::WpPlugins()->getUpdateNewVersion( $sPluginFile );
	}

	/**
	 * @deprecated
	 * @param string $sPluginFile
	 * @return boolean|\stdClass
	 */
	public function getIsPluginUpdateAvailable( $sPluginFile ) {
		return Services::WpPlugins()->isUpdateAvailable( $sPluginFile );
	}

	/**
	 * @deprecated
	 * @param string $sCompareString
	 * @param string $sKey
	 * @return bool
	 */
	public function getIsPluginActive( $sCompareString, $sKey = 'Name' ) {
		$sPluginFile = $this->getIsPluginInstalled( $sCompareString, $sKey );
		if ( !$sPluginFile ) {
			return false;
		}
		return is_plugin_active( $sPluginFile ) ? $sPluginFile : false;
	}

	/**
	 * @deprecated
	 * @param string $sPluginFile
	 * @param int    $nDesiredPosition
	 */
	public function setActivePluginLoadPosition( $sPluginFile, $nDesiredPosition = 0 ) {
		Services::WpPlugins()->setActivePluginLoadPosition( $sPluginFile, $nDesiredPosition );
	}

	/**
	 * @deprecated
	 * @param string $sPluginBaseFilename
	 * @return null|\stdClass
	 */
	public function getPluginDataAsObject( $sPluginBaseFilename ) {
		return Services::WpPlugins()->getPluginDataAsObject( $sPluginBaseFilename );
	}

	/**
	 * @deprecated
	 * @param string $sPluginFile
	 */
	public function setActivePluginLoadFirst( $sPluginFile ) {
		Services::WpPlugins()->setActivePluginLoadFirst( $sPluginFile );
	}

	/**
	 * @deprecated
	 * @param string $sPluginFile
	 */
	public function setActivePluginLoadLast( $sPluginFile ) {
		Services::WpPlugins()->setActivePluginLoadPosition( $sPluginFile, 1000 );
	}

	/**
	 * @deprecated
	 * @return array
	 */
	public function getWordpressUpdates_Themes() {
		return Services::WpThemes()->getUpdates();
	}

	/**
	 * @deprecated
	 * @return string
	 */
	public function getWordpressVersion() {
		return $this->getVersion();
	}

	/**
	 * @deprecated getAdminUrl()
	 * @return string
	 */
	public function getUrl_WpAdmin() {
		return get_admin_url();
	}
}