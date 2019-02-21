<?php

namespace FernleafSystems\Wordpress\Services\Core;

use FernleafSystems\Wordpress\Services\Core\Upgrades;
use FernleafSystems\Wordpress\Services\Services;

/**
 * Class Themes
 * @package FernleafSystems\Wordpress\Services\Core
 */
class Themes {

	/**
	 * @param string $sThemeStylesheet
	 * @return bool
	 */
	public function activate( $sThemeStylesheet ) {
		if ( empty( $sThemeStylesheet ) ) {
			return false;
		}

		$oTheme = $this->getTheme( $sThemeStylesheet );
		if ( !$oTheme->exists() ) {
			return false;
		}

		switch_theme( $oTheme->get_stylesheet() );

		// Now test currently active theme
		$oCurrentTheme = $this->getCurrent();

		return ( !is_null( $oCurrentTheme ) && ( $sThemeStylesheet == $oCurrentTheme->get_stylesheet() ) );
	}

	/**
	 * @param string $sStylesheet
	 * @return bool|\WP_Error
	 */
	public function delete( $sStylesheet ) {
		if ( empty( $sStylesheet ) ) {
			return false;
		}
		if ( !function_exists( 'delete_theme' ) ) {
			require_once( ABSPATH.'wp-admin/includes/theme.php' );
		}
		return function_exists( 'delete_theme' ) ? delete_theme( $sStylesheet ) : false;
	}

	/**
	 * @param $sSlug
	 * @return array|bool
	 */
	public function installFromWpOrg( $sSlug ) {
		include_once( ABSPATH.'wp-admin/includes/plugin-install.php' );

		$oApi = $this->getExtendedData( $sSlug );

		if ( !is_wp_error( $oApi ) ) {
			return $this->install( $oApi->download_link, true, true );
		}
		return false;
	}

	/**
	 * @param string $sUrlToInstall
	 * @param bool   $bOverwrite
	 * @param bool   $bMaintenanceMode
	 * @return array
	 */
	public function install( $sUrlToInstall, $bOverwrite = true, $bMaintenanceMode = false ) {

		$aResult = array(
			'successful'  => true,
			'plugin_info' => '',
			'errors'      => array()
		);

		$oUpgraderSkin = new Upgrades\UpgraderSkin();
		$oUpgrader = new Upgrades\ThemeUpgrader( $oUpgraderSkin );
		$oUpgrader->setOverwriteMode( $bOverwrite );
		if ( $bMaintenanceMode ) {
			$oUpgrader->maintenance_mode( true );
		}

		ob_start();
		$oUpgrader->install( $sUrlToInstall );
		ob_end_clean();

		if ( $bMaintenanceMode ) {
			$oUpgrader->maintenance_mode( false );
		}

		$aErrors = $oUpgraderSkin->getErrors();
		if ( isset( $aErrors[ 0 ] ) && is_wp_error( $aErrors[ 0 ] ) ) {
			/** @var \WP_Error $oErr */
			$oErr = $aErrors[ 0 ];
			$aResult[ 'successful' ] = false;
			$aResult[ 'errors' ] = $oErr->get_error_messages();
		}
		else {
			$aResult[ 'theme_info' ] = $oUpgrader->theme_info();
		}

		$aResult[ 'feedback' ] = $oUpgraderSkin->getFeedback();
		return $aResult;
	}

	/**
	 * @param string $sSlug
	 * @param bool   $bUseBackup
	 * @return bool
	 */
	public function reinstall( $sSlug, $bUseBackup = false ) {
		$bSuccess = false;

		if ( $this->isInstalled( $sSlug ) ) {
			$oFS = Services::WpFs();

			$oTheme = $this->getTheme( $sSlug );

			$sDir = $oTheme->get_stylesheet_directory();
			$sBackupDir = dirname( $sDir ).'/../../'.$sSlug.'bak'.time();
			if ( $bUseBackup ) {
				rename( $sDir, $sBackupDir );
			}

			$aResult = $this->installFromWpOrg( $sSlug );
			$bSuccess = $aResult[ 'successful' ];
			if ( $bSuccess ) {
				wp_update_themes(); //refreshes our update information
				if ( $bUseBackup ) {
					$oFS->deleteDir( $sBackupDir );
				}
			}
			else {
				if ( $bUseBackup ) {
					$oFS->deleteDir( $sDir );
					rename( $sBackupDir, $sDir );
				}
			}
		}
		return $bSuccess;
	}

	/**
	 * @param string $sFile
	 * @return array
	 */
	public function update( $sFile ) {

		$aResult = array(
			'successful' => 1,
			'errors'     => array()
		);

		$oUpgraderSkin = new Upgrades\BulkThemeUpgraderSkin();
		$oUpgrader = new Upgrades\ThemeUpgrader( $oUpgraderSkin );
		ob_start();
		$oUpgrader->bulk_upgrade( array( $sFile ) );
		if ( ob_get_contents() ) {
			// for some reason this errors with no buffer present
			ob_end_clean();
		}

		$aErrors = $oUpgraderSkin->getErrors();
		if ( isset( $aErrors[ 0 ] ) && is_wp_error( $aErrors[ 0 ] ) ) {
			/** @var \WP_Error $oErr */
			$oErr = $aErrors[ 0 ];
			$aResult[ 'successful' ] = 0;
			$aResult[ 'errors' ] = $oErr->get_error_messages();
		}
		$aResult[ 'feedback' ] = $oUpgraderSkin->getFeedback();
		return $aResult;
	}

	/**
	 * @return false|string
	 */
	public function getCurrentThemeName() {
		return $this->getCurrent()->get( 'Name' );
	}

	/**
	 * @return null|\WP_Theme
	 */
	public function getCurrent() {
		return $this->getTheme();
	}

	/**
	 * @param string $sStylesheet
	 * @return bool
	 */
	public function getExists( $sStylesheet ) {
		$oTheme = $this->getTheme( $sStylesheet );
		return ( !is_null( $oTheme ) && ( $oTheme instanceof \WP_Theme ) && $oTheme->exists() );
	}

	/**
	 * @param string $sSlug - the folder name of the theme
	 * @return string
	 */
	public function getInstallationDir( $sSlug ) {
		return $this->getTheme( $sSlug )->get_stylesheet_directory();
	}

	/**
	 * @param string $sStylesheet
	 * @return null|\WP_Theme
	 */
	public function getTheme( $sStylesheet = null ) {
		if ( Services::WpGeneral()->getWordpressIsAtLeastVersion( '3.4.0' ) ) {
			if ( !function_exists( 'wp_get_theme' ) ) {
				require_once( ABSPATH.'wp-admin/includes/theme.php' );
			}
			return function_exists( 'wp_get_theme' ) ? wp_get_theme( $sStylesheet ) : null;
		}
		$aThemes = $this->getThemes();
		return array_key_exists( $sStylesheet, $aThemes ) ? $aThemes[ $sStylesheet ] : null;
	}

	/**
	 * Abstracts the WordPress wp_get_themes()
	 * @return array|\WP_Theme[]
	 */
	public function getThemes() {
		if ( !function_exists( 'wp_get_themes' ) ) {
			require_once( ABSPATH.'wp-admin/includes/theme.php' );
		}
		return function_exists( 'wp_get_themes' ) ? wp_get_themes() : get_themes();
	}

	/**
	 * @param string $sSlug
	 * @return array|null
	 */
	public function getUpdateInfo( $sSlug ) {
		$aU = $this->getUpdates();
		return isset( $aU[ $sSlug ] ) ? $aU[ $sSlug ] : null;
	}

	/**
	 * @param bool $bForceUpdateCheck
	 * @return array
	 */
	public function getUpdates( $bForceUpdateCheck = false ) {
		if ( $bForceUpdateCheck ) {
			$this->clearUpdates();
			$this->checkForUpdates();
		}
		$aUpdates = Services::WpGeneral()->getWordpressUpdates( 'themes' );
		return is_array( $aUpdates ) ? $aUpdates : array();
	}

	/**
	 * @return null|\WP_Theme
	 */
	public function getCurrentParent() {
		$oTheme = $this->getCurrent();
		return $this->isActiveThemeAChild() ? $this->getTheme( $oTheme->get_template() ) : null;
	}

	/**
	 * @param string $sBase
	 * @return object|\WP_Error
	 */
	public function getExtendedData( $sBase ) {
		include_once( ABSPATH.'wp-admin/includes/theme.php' );

		$oApi = themes_api( 'theme_information', array(
			'slug'   => $sBase,
			'fields' => array(
				'sections' => false,
			),
		) );
		return $oApi;
	}

	/**
	 * @param string $sSlug
	 * @param bool   $bCheckIsActiveParent
	 * @return bool
	 */
	public function isActive( $sSlug, $bCheckIsActiveParent = false ) {
		return ( $this->isInstalled( $sSlug ) && $this->getCurrent()->get_stylesheet() == $sSlug )
			   || ( $bCheckIsActiveParent && $this->isActiveParent( $sSlug ) );
	}

	/**
	 * @return bool
	 */
	public function isActiveThemeAChild() {
		$oTheme = $this->getCurrent();
		return ( $oTheme->get_stylesheet() != $oTheme->get_template() );
	}

	/**
	 * @param string $sSlug
	 * @return bool - true if this is the Parent of the currently active theme
	 */
	public function isActiveParent( $sSlug ) {
		return ( $this->isInstalled( $sSlug ) && $this->getCurrent()->get_template() == $sSlug );
	}

	/**
	 * @param string $sSlug The directory slug.
	 * @return bool
	 */
	public function isInstalled( $sSlug ) {
		return !empty( $sSlug ) && !is_null( $this->getTheme( $sSlug ) );
	}

	/**
	 * @param string $sSlug
	 * @return boolean
	 */
	public function isUpdateAvailable( $sSlug ) {
		return !is_null( $this->getUpdateInfo( $sSlug ) );
	}

	/**
	 * @param string $sBaseName
	 * @return bool
	 */
	public function isWpOrg( $sBaseName ) {
		$bIsWpOrg = false;
		$oInfo = $this->getExtendedData( $sBaseName );
		if ( !empty( $oInfo ) && !is_wp_error( $oInfo ) && isset( $oInfo->download_link ) ) {
			$bIsWpOrg = strpos( $oInfo->download_link, 'https://downloads.wordpress.org' ) === 0;
		}
		return $bIsWpOrg;
	}

	/**
	 * @return boolean|null
	 */
	protected function checkForUpdates() {

		if ( class_exists( 'WPRC_Installer' ) && method_exists( 'WPRC_Installer', 'wprc_update_themes' ) ) {
			WPRC_Installer::wprc_update_themes();
			return true;
		}
		else if ( function_exists( 'wp_update_themes' ) ) {
			return ( wp_update_themes() !== false );
		}
		return null;
	}

	/**
	 */
	protected function clearUpdates() {
		$sKey = 'update_themes';
		$oResponse = Services::WpGeneral()->getTransient( $sKey );
		if ( !is_object( $oResponse ) ) {
			$oResponse = new \stdClass();
		}
		$oResponse->last_checked = 0;
		Services::WpGeneral()->setTransient( $sKey, $oResponse );
	}

	/**
	 * @return array
	 */
	public function wpmsGetSiteAllowedThemes() {
		return ( function_exists( 'get_site_allowed_themes' ) ? get_site_allowed_themes() : array() );
	}
}