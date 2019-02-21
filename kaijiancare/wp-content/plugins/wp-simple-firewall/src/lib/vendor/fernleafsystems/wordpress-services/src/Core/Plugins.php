<?php

namespace FernleafSystems\Wordpress\Services\Core;

use FernleafSystems\Wordpress\Services\Core\Upgrades;
use FernleafSystems\Wordpress\Services\Core\VOs\WpPluginVo;
use FernleafSystems\Wordpress\Services\Services;

/**
 * Class Plugins
 * @package FernleafSystems\Wordpress\Services\Core
 */
class Plugins {

	/**
	 * @param string $sPluginFile
	 * @param bool   $bNetworkWide
	 * @return null|\WP_Error
	 */
	public function activate( $sPluginFile, $bNetworkWide = false ) {
		return activate_plugin( $sPluginFile, '', $bNetworkWide );
	}

	/**
	 * @param string $sPluginFile
	 * @param bool   $bNetworkWide
	 * @return null|\WP_Error
	 */
	protected function activateQuietly( $sPluginFile, $bNetworkWide = false ) {
		return activate_plugin( $sPluginFile, '', $bNetworkWide, true );
	}

	/**
	 * @param string $sPluginFile
	 * @param bool   $bNetworkWide
	 */
	public function deactivate( $sPluginFile, $bNetworkWide = false ) {
		deactivate_plugins( $sPluginFile, '', $bNetworkWide );
	}

	/**
	 * @param string $sPluginFile
	 * @param bool   $bNetworkWide
	 */
	protected function deactivateQuietly( $sPluginFile, $bNetworkWide = false ) {
		deactivate_plugins( $sPluginFile, true, $bNetworkWide );
	}

	/**
	 * @param string $sFile
	 * @param bool   $bNetworkWide
	 * @return bool
	 */
	public function delete( $sFile, $bNetworkWide = false ) {
		if ( !$this->isInstalled( $sFile ) ) {
			return false;
		}

		if ( $this->isActive( $sFile ) ) {
			$this->deactivate( $sFile, $bNetworkWide );
		}
		$this->uninstall( $sFile );

		// delete the folder
		$sPluginDir = dirname( $sFile );
		if ( $sPluginDir == '.' ) { //it's not within a sub-folder
			$sPluginDir = $sFile;
		}
		$sPath = path_join( WP_PLUGIN_DIR, $sPluginDir );
		return Services::WpFs()->deleteDir( $sPath );
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
		$oUpgrader = new Upgrades\PluginUpgrader( $oUpgraderSkin );
		$oUpgrader->setOverwriteMode( $bOverwrite );
		if ( $bMaintenanceMode ) {
			$oUpgrader->maintenance_mode( true );
		}

		ob_start();
		$sInstallResult = $oUpgrader->install( $sUrlToInstall );
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
			$aResult[ 'plugin_info' ] = $oUpgrader->plugin_info();
		}

		$aResult[ 'feedback' ] = $oUpgraderSkin->getFeedback();
		$aResult[ 'raw' ] = $sInstallResult;
		return $aResult;
	}

	/**
	 * @param $sSlug
	 * @return array|bool
	 */
	public function installFromWpOrg( $sSlug ) {
		include_once( ABSPATH.'wp-admin/includes/plugin-install.php' );

		$api = plugins_api( 'plugin_information', array(
			'slug'   => $sSlug,
			'fields' => array(
				'sections' => false,
			),
		) );

		if ( !is_wp_error( $api ) ) {
			return $this->install( $api->download_link, true, true );
		}
		return false;
	}

	/**
	 * @param string $sFile
	 * @param bool   $bUseBackup
	 * @return bool
	 */
	public function reinstall( $sFile, $bUseBackup = false ) {
		$bSuccess = false;

		if ( $this->isInstalled( $sFile ) ) {

			$sSlug = $this->getSlug( $sFile );
			if ( !empty( $sSlug ) ) {
				$oFS = Services::WpFs();

				$sDir = dirname( path_join( WP_PLUGIN_DIR, $sFile ) );
				$sBackupDir = WP_PLUGIN_DIR.'/../'.basename( $sDir ).'bak'.time();
				if ( $bUseBackup ) {
					rename( $sDir, $sBackupDir );
				}

				$aResult = $this->installFromWpOrg( $sSlug );
				$bSuccess = $aResult[ 'successful' ];
				if ( $bSuccess ) {
					wp_update_plugins(); //refreshes our update information
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

		$oUpgraderSkin = new Upgrades\BulkPluginUpgraderSkin();
		ob_start();
		( new Upgrades\PluginUpgrader( $oUpgraderSkin ) )->bulk_upgrade( array( $sFile ) );
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
	 * @param string $sPluginFile
	 * @return true
	 */
	public function uninstall( $sPluginFile ) {
		return uninstall_plugin( $sPluginFile );
	}

	/**
	 * @return bool|null
	 */
	protected function checkForUpdates() {

		if ( class_exists( 'WPRC_Installer' ) && method_exists( 'WPRC_Installer', 'wprc_update_plugins' ) ) {
			WPRC_Installer::wprc_update_plugins();
			return true;
		}
		else if ( function_exists( 'wp_update_plugins' ) ) {
			return ( wp_update_plugins() !== false );
		}
		return null;
	}

	/**
	 */
	protected function clearUpdates() {
		$oWp = Services::WpGeneral();
		$sKey = 'update_plugins';
		$oResponse = Services::WpGeneral()->getTransient( $sKey );
		if ( !is_object( $oResponse ) ) {
			$oResponse = new \stdClass();
		}
		$oResponse->last_checked = 0;
		$oWp->setTransient( $sKey, $oResponse );
	}

	/**
	 * @param string $sValueToCompare
	 * @param string $sKey
	 * @return null|string
	 */
	public function findPluginBy( $sValueToCompare, $sKey = 'Name' ) {
		$sFilename = null;

		if ( !empty( $sValueToCompare ) ) {
			foreach ( $this->getPlugins() as $sBaseFileName => $aPluginData ) {
				if ( isset( $aPluginData[ $sKey ] ) && $sValueToCompare == $aPluginData[ $sKey ] ) {
					$sFilename = $sBaseFileName;
				}
			}
		}

		return $sFilename;
	}

	/**
	 * @param string $sFile - plugin base file, e.g. wp-folder/wp-plugin.php
	 * @return string
	 */
	public function getInstallationDir( $sFile ) {
		return dirname( path_join( WP_PLUGIN_DIR, $sFile ) );
	}

	/**
	 * @param string $sPluginFile
	 * @return string
	 */
	public function getLinkPluginActivate( $sPluginFile ) {
		$sUrl = self_admin_url( 'plugins.php' );
		$aQueryArgs = array(
			'action'   => 'activate',
			'plugin'   => urlencode( $sPluginFile ),
			'_wpnonce' => wp_create_nonce( 'activate-plugin_'.$sPluginFile )
		);
		return add_query_arg( $aQueryArgs, $sUrl );
	}

	/**
	 * @param string $sPluginFile
	 * @return string
	 */
	public function getLinkPluginDeactivate( $sPluginFile ) {
		$sUrl = self_admin_url( 'plugins.php' );
		$aQueryArgs = array(
			'action'   => 'deactivate',
			'plugin'   => urlencode( $sPluginFile ),
			'_wpnonce' => wp_create_nonce( 'deactivate-plugin_'.$sPluginFile )
		);
		return add_query_arg( $aQueryArgs, $sUrl );
	}

	/**
	 * @param string $sPluginFile
	 * @return string
	 */
	public function getLinkPluginUpgrade( $sPluginFile ) {
		$sUrl = self_admin_url( 'update.php' );
		$aQueryArgs = array(
			'action'   => 'upgrade-plugin',
			'plugin'   => urlencode( $sPluginFile ),
			'_wpnonce' => wp_create_nonce( 'upgrade-plugin_'.$sPluginFile )
		);
		return add_query_arg( $aQueryArgs, $sUrl );
	}

	/**
	 * @param string $sPluginFile
	 * @return array|null
	 */
	public function getPlugin( $sPluginFile ) {
		$aPlugin = null;

		$aPlugins = $this->getPlugins();
		if ( !empty( $sPluginFile ) && !empty( $aPlugins )
			 && is_array( $aPlugins ) && array_key_exists( $sPluginFile, $aPlugins ) ) {
			$aPlugin = $aPlugins[ $sPluginFile ];
		}
		return $aPlugin;
	}

	/**
	 * @param string $sPluginFile
	 * @return WpPluginVo|null
	 */
	public function getPluginAsVo( $sPluginFile ) {
		$oPlug = null;
		try {
			$oPlug = new WpPluginVo( $sPluginFile );
		}
		catch ( \Exception $oE ) {
		}
		return $oPlug;
	}

	/**
	 * @param string $sPluginFile
	 * @return null|\stdClass
	 */
	public function getPluginDataAsObject( $sPluginFile ) {
		$aPlugin = $this->getPlugin( $sPluginFile );
		return is_null( $aPlugin ) ? null : Services::DataManipulation()->convertArrayToStdClass( $aPlugin );
	}

	/**
	 * @param string $sPluginFile
	 * @return int
	 */
	public function getActivePluginLoadPosition( $sPluginFile ) {
		$nPosition = array_search( $sPluginFile, $this->getActivePlugins() );
		return ( $nPosition === false ) ? -1 : $nPosition;
	}

	/**
	 * @return array
	 */
	public function getActivePlugins() {
		$oWp = Services::WpGeneral();
		$sOptionKey = $oWp->isMultisite() ? 'active_sitewide_plugins' : 'active_plugins';
		return $oWp->getOption( $sOptionKey );
	}

	/**
	 * @return string[]
	 */
	public function getInstalledPluginFiles() {
		return array_keys( $this->getPlugins() );
	}

	/**
	 * @return array[]
	 */
	public function getPlugins() {
		if ( !function_exists( 'get_plugins' ) ) {
			require_once( ABSPATH.'wp-admin/includes/plugin.php' );
		}
		return function_exists( 'get_plugins' ) ? get_plugins() : array();
	}

	/**
	 * @return WpPluginVo[]
	 */
	public function getPluginsAsVo() {
		return array_filter(
			array_map(
				function ( $sPluginFile ) {
					return $this->getPluginAsVo( $sPluginFile );
				},
				$this->getInstalledPluginFiles()
			)
		);
	}

	/**
	 * @return array - keys are plugin base files
	 */
	public function getAllExtendedData() {
		$oData = Services::WpGeneral()->getTransient( 'update_plugins' );
		return array_merge(
			isset( $oData->no_update ) ? $oData->no_update : array(),
			isset( $oData->response ) ? $oData->response : array()
		);
	}

	/**
	 * @param string $sBaseFile
	 * @return array
	 */
	public function getExtendedData( $sBaseFile ) {
		$aData = $this->getAllExtendedData();
		return isset( $aData[ $sBaseFile ] ) ? $aData[ $sBaseFile ] : array();
	}

	/**
	 * @return array
	 */
	public function getAllSlugs() {
		$aSlugs = array();

		foreach ( $this->getAllExtendedData() as $sBaseName => $oPlugData ) {
			if ( isset( $oPlugData->slug ) ) {
				$aSlugs[ $sBaseName ] = $oPlugData->slug;
			}
		}

		return $aSlugs;
	}

	/**
	 * @param $sBaseName
	 * @return string
	 */
	public function getSlug( $sBaseName ) {
		$oPluginInfo = $this->getExtendedData( $sBaseName );
		return isset( $oPluginInfo->slug ) ? $oPluginInfo->slug : '';
	}

	/**
	 * @param string $sBaseName
	 * @return bool
	 */
	public function isWpOrg( $sBaseName ) {
		$oPluginInfo = $this->getExtendedData( $sBaseName );
		return isset( $oPluginInfo->id ) ? strpos( $oPluginInfo->id, 'w.org/' ) === 0 : false;
	}

	/**
	 * @param string $sFile
	 * @return \stdClass|null
	 */
	public function getUpdateInfo( $sFile ) {
		$aU = $this->getUpdates();
		return isset( $aU[ $sFile ] ) ? $aU[ $sFile ] : null;
	}

	/**
	 * @param string $sFile
	 * @return string
	 */
	public function getUpdateNewVersion( $sFile ) {
		$oInfo = $this->getUpdateInfo( $sFile );
		return ( !is_null( $oInfo ) && isset( $oInfo->new_version ) ) ? $oInfo->new_version : '';
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
		$aUpdates = Services::WpGeneral()->getWordpressUpdates( 'plugins' );
		return is_array( $aUpdates ) ? $aUpdates : array();
	}

	/**
	 * @param string $sFile
	 * @return bool
	 */
	public function isActive( $sFile ) {
		return ( $this->isInstalled( $sFile ) && is_plugin_active( $sFile ) );
	}

	/**
	 * @param string $sFile The full plugin file.
	 * @return bool
	 */
	public function isInstalled( $sFile ) {
		return !empty( $sFile ) && !is_null( $this->getPlugin( $sFile ) );
	}

	/**
	 * @param string $sFile
	 * @return boolean|\stdClass
	 */
	public function isUpdateAvailable( $sFile ) {
		return !is_null( $this->getUpdateInfo( $sFile ) );
	}

	/**
	 * @param string $sFile
	 * @param int    $nDesiredPosition
	 */
	public function setActivePluginLoadPosition( $sFile, $nDesiredPosition = 0 ) {
		$oWp = Services::WpGeneral();
		$oData = Services::DataManipulation();

		$aActive = $oData->setArrayValueToPosition(
			$oWp->getOption( 'active_plugins' ),
			$sFile,
			$nDesiredPosition
		);
		$oWp->updateOption( 'active_plugins', $aActive );

		if ( $oWp->isMultisite() ) {
			$aActive = $oData
				->setArrayValueToPosition( $oWp->getOption( 'active_sitewide_plugins' ), $sFile, $nDesiredPosition );
			$oWp->updateOption( 'active_sitewide_plugins', $aActive );
		}
	}

	/**
	 * @param string $sFile
	 */
	public function setActivePluginLoadFirst( $sFile ) {
		$this->setActivePluginLoadPosition( $sFile, 0 );
	}

	/**
	 * @param string $sFile
	 */
	public function setActivePluginLoadLast( $sFile ) {
		$this->setActivePluginLoadPosition( $sFile, 1000 );
	}
}