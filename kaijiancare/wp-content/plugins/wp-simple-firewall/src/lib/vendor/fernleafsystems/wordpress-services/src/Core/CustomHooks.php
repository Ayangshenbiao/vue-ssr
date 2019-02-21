<?php

namespace FernleafSystems\Wordpress\Services\Core;

/**
 * Class CustomHooks
 * @package FernleafSystems\Wordpress\Services\Core
 */
class CustomHooks {

	const HOOK_PREFIX = 'odp_';

	public function __construct() {
		add_action( 'upgrader_process_complete', array( $this, 'onUpgraderProcessComplete' ), 100, 2 );
	}

	/**
	 * 'install', 'update'
	 * 'plugin', 'theme', 'translation', or 'core'
	 * @param \WP_Upgrader $oUpgrader
	 * @param array        $aOptions
	 */
	public function onUpgraderProcessComplete( $oUpgrader, $aOptions ) {
		if ( !empty( $aOptions[ 'type' ] ) && !empty( $aOptions[ 'action' ] ) ) {
			// e.g. odp_plugin_install_complete
			$sHookName = static::HOOK_PREFIX.$aOptions[ 'type' ].'_'.$aOptions[ 'action' ].'_complete';
			do_action( $sHookName, $oUpgrader, $aOptions );
		}
	}
}