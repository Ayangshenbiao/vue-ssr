<?php

namespace FernleafSystems\Wordpress\Services\Utilities;

use FernleafSystems\Wordpress\Services\Services;
use GeoIp2\Database\Reader;

/**
 * Class GeoIp
 * @package FernleafSystems\Wordpress\Services\Utilities
 */
class GeoIp {
	/**
	 * @var Reader
	 */
	private $oReader;

	/**
	 * @var string
	 */
	private $sDbSource;

	/**
	 * @var GeoIp
	 */
	protected static $oInstance = null;

	/**
	 * @return GeoIp
	 */
	public static function GetInstance() {
		if ( is_null( self::$oInstance ) ) {
			self::$oInstance = new self();
		}
		return self::$oInstance;
	}

	/**
	 * @param string $sIP
	 * @return string
	 */
	public function countryName( $sIP ) {
		$sCountry = '';
		$oCountry = $this->getRegisteredCountry( $sIP );
		if ( !is_null( $oCountry ) ) {
			$sLoc = explode( '-', Services::WpGeneral()->getLocale() )[ 0 ];
			$sCountry = isset( $oCountry->names[ $sLoc ] ) ? $oCountry->names[ $sLoc ] : $oCountry->name;
		}
		return $sCountry;
	}

	/**
	 * @param string $sIP
	 * @return string
	 */
	public function countryIso( $sIP ) {
		$sIso = '';
		$oCountry = $this->getRegisteredCountry( $sIP );
		if ( !is_null( $oCountry ) ) {
			$sIso = $oCountry->isoCode;
		}
		return $sIso;
	}

	/**
	 * @param string $sIP
	 * @return \GeoIp2\Record\Country|null
	 */
	public function getRegisteredCountry( $sIP ) {
		$oCountry = null;
		if ( $this->isReady() ) {
			try {
				$oCountry = $this->getReader()
								 ->country( $sIP )->registeredCountry;
			}
			catch ( \Exception $oe ) {
			}
		}
		return $oCountry;
	}

	/**
	 * @return bool
	 */
	public function isReady() {
		return ( $this->getReader() !== false );
	}

	/**
	 * @return \GeoIp2\Database\Reader|false
	 */
	protected function getReader() {
		if ( !isset( $this->oReader ) ) {
			try {
				$this->oReader = new Reader( $this->getDbSource() );
			}
			catch ( \Exception $oE ) {
				$this->oReader = false;
			}
		}
		return $this->oReader;
	}

	/**
	 * @return string
	 */
	public function getDbSource() {
		return $this->sDbSource;
	}

	/**
	 * @param string $sDbSource
	 * @return $this
	 */
	public function setDbSource( $sDbSource ) {
		$this->sDbSource = $sDbSource;
		return $this;
	}
}