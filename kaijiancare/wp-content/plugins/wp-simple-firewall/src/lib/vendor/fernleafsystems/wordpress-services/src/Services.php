<?php

namespace FernleafSystems\Wordpress\Services;

use FernleafSystems\Wordpress\Services\Core;
use FernleafSystems\Wordpress\Services\Utilities;
use Pimple\Container;

class Services {

	/**
	 * @var Container
	 */
	static protected $oDic;

	/**
	 * @var Services The reference to *Singleton* instance of this class
	 */
	private static $oInstance;

	static protected $aItems;

	/**
	 * @return Services
	 */
	public static function GetInstance() {
		if ( null === static::$oInstance ) {
			static::$oInstance = new static();
		}
		return static::$oInstance;
	}

	/**
	 * Protected constructor to prevent creating a new instance of the
	 * *Singleton* via the `new` operator from outside of this class.
	 */
	protected function __construct() {
		$this->registerAll();
		self::CustomHooks(); // initiate these early
		self::Request(); // initiate these early
		self::WpCron();
	}

	public function registerAll() {
		self::$oDic = new Container();
		self::$oDic[ 'service_data' ] = function () {
			return new Utilities\Data();
		};
		self::$oDic[ 'service_corefilehashes' ] = function () {
			return new Core\CoreFileHashes();
		};
		self::$oDic[ 'service_email' ] = function () {
			return new Utilities\Data();
		};
		self::$oDic[ 'service_datamanipulation' ] = function () {
			return new Utilities\DataManipulation();
		};
		self::$oDic[ 'service_customhooks' ] = function () {
			return new Core\CustomHooks();
		};
		self::$oDic[ 'service_request' ] = function () {
			return new Core\Request();
		};
		self::$oDic[ 'service_render' ] = function () {
			return new Utilities\Render();
		};
		self::$oDic[ 'service_respond' ] = function () {
			return new Core\Respond();
		};
		self::$oDic[ 'service_includes' ] = function () {
			return new Core\Includes();
		};
		self::$oDic[ 'service_ip' ] = function () {
			return Utilities\IpUtils::GetInstance();
		};
		self::$oDic[ 'service_geoip' ] = function () {
			return Utilities\GeoIp::GetInstance();
		};
		self::$oDic[ 'service_wpadminnotices' ] = function () {
			return new Core\AdminNotices();
		};
		self::$oDic[ 'service_wpcomments' ] = function () {
			return new Core\Comments();
		};
		self::$oDic[ 'service_wpcron' ] = function () {
			return new Core\Cron();
		};
		self::$oDic[ 'service_wpdb' ] = function () {
			return new Core\Db();
		};
		self::$oDic[ 'service_wpfs' ] = function () {
			return new Core\Fs();
		};
		self::$oDic[ 'service_wpgeneral' ] = function () {
			return new Core\General();
		};
		self::$oDic[ 'service_wpplugins' ] = function () {
			return new Core\Plugins();
		};
		self::$oDic[ 'service_wpthemes' ] = function () {
			return new Core\Themes();
		};
		self::$oDic[ 'service_wppost' ] = function () {
			return new Core\Post();
		};
		self::$oDic[ 'service_wptrack' ] = function () {
			return new Core\Track();
		};
		self::$oDic[ 'service_wpusers' ] = function () {
			return new Core\Users();
		};
	}

	/**
	 * @return Core\CustomHooks
	 */
	static public function CustomHooks() {
		return self::getObj( __FUNCTION__ );
	}

	/**
	 * @return Utilities\Data
	 */
	static public function Data() {
		return self::getObj( __FUNCTION__ );
	}

	/**
	 * @return Utilities\Email
	 */
	static public function Email() {
		return self::getObj( __FUNCTION__ );
	}

	/**
	 * @return Utilities\DataManipulation
	 */
	static public function DataManipulation() {
		return self::getObj( __FUNCTION__ );
	}

	/**
	 * @return Core\CoreFileHashes
	 */
	static public function CoreFileHashes() {
		return self::getObj( __FUNCTION__ );
	}

	/**
	 * @return Core\Includes
	 */
	static public function Includes() {
		return self::getObj( __FUNCTION__ );
	}

	/**
	 * @return Utilities\GeoIp
	 */
	static public function GeoIp() {
		return self::getObj( __FUNCTION__ );
	}

	/**
	 * @return Utilities\IpUtils
	 */
	static public function IP() {
		return self::getObj( __FUNCTION__ );
	}

	/**
	 * @param string $sTemplatePath
	 * @return Utilities\Render
	 */
	static public function Render( $sTemplatePath = '' ) {
		/** @var Utilities\Render $oRender */
		$oRender = self::getObj( __FUNCTION__ );
		if ( !empty( $sTemplatePath ) ) {
			$oRender->setTemplateRoot( $sTemplatePath );
		}
		return ( clone $oRender );
	}

	/**
	 * @return Core\Request
	 */
	static public function Request() {
		return self::getObj( __FUNCTION__ );
	}

	/**
	 * @return Core\Respond
	 */
	static public function Respond() {
		return self::getObj( __FUNCTION__ );
	}

	/**
	 * @return Core\AdminNotices
	 */
	static public function WpAdminNotices() {
		return self::getObj( __FUNCTION__ );
	}

	/**
	 * @return Core\Comments
	 */
	static public function WpComments() {
		return self::getObj( __FUNCTION__ );
	}

	/**
	 * @return Core\Cron
	 */
	static public function WpCron() {
		return self::getObj( __FUNCTION__ );
	}

	/**
	 * @return Core\Db
	 */
	static public function WpDb() {
		return self::getObj( __FUNCTION__ );
	}

	/**
	 * @return Core\Fs
	 */
	static public function WpFs() {
		return self::getObj( __FUNCTION__ );
	}

	/**
	 * @return Core\General
	 */
	static public function WpGeneral() {
		return self::getObj( __FUNCTION__ );
	}

	/**
	 * @return Core\Plugins
	 */
	static public function WpPlugins() {
		return self::getObj( __FUNCTION__ );
	}

	/**
	 * @return Core\Themes
	 */
	static public function WpThemes() {
		return self::getObj( __FUNCTION__ );
	}

	/**
	 * @return Core\Post
	 */
	static public function WpPost() {
		return self::getObj( __FUNCTION__ );
	}

	/**
	 * @return Core\Track
	 */
	static public function WpTrack() {
		return self::getObj( __FUNCTION__ );
	}

	/**
	 * @return Core\Users
	 */
	static public function WpUsers() {
		return self::getObj( __FUNCTION__ );
	}

	static protected function getObj( $sKeyFunction ) {
		$sFullKey = 'service_'.strtolower( $sKeyFunction );
		if ( !is_array( self::$aItems ) ) {
			self::$aItems = array();
		}
		if ( !isset( self::$aItems[ $sFullKey ] ) ) {
			self::$aItems[ $sFullKey ] = self::$oDic[ $sFullKey ];
		}
		return self::$aItems[ $sFullKey ];
	}
}