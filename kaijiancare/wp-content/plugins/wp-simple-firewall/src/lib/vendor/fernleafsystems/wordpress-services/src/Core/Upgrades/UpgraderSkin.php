<?php

namespace FernleafSystems\Wordpress\Services\Core\Upgrades;

require_once( ABSPATH.'wp-admin/includes/upgrade.php' );
require_once( ABSPATH.'wp-admin/includes/class-wp-upgrader.php' );

class UpgraderSkin extends \WP_Upgrader_Skin {

	/**
	 * @var array
	 */
	public $aErrors;

	/**
	 * @var array
	 */
	public $aFeedback;

	public function __construct() {
		parent::__construct();
		$this->done_header = true;
	}

	/**
	 * @return array
	 */
	public function getErrors() {
		return is_array( $this->aErrors ) ? $this->aErrors : array();
	}

	/**
	 * @return array
	 */
	public function getFeedback() {
		return is_array( $this->aFeedback ) ? $this->aFeedback : array();
	}

	function error( $errors ) {
	}

	function feedback( $string ) {
	}
}