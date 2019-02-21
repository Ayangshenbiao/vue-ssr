<?php

namespace FernleafSystems\Wordpress\Services\Core;

use FernleafSystems\Wordpress\Services\Services;

/**
 * Class Includes
 * @package FernleafSystems\Wordpress\Services\Core
 */
class Includes {

	/**
	 * @return string
	 */
	public function getUrl_Jquery() {
		return $this->getJsUrl( 'jquery/jquery.js' );
	}

	/**
	 * @param string $sJsInclude
	 * @return string
	 */
	public function getJsUrl( $sJsInclude ) {
		return $this->getIncludeUrl( path_join( 'js', $sJsInclude ) );
	}

	/**
	 * @param string $sInclude
	 * @return string
	 */
	public function getIncludeUrl( $sInclude ) {
		$sInclude = path_join( 'wp-includes', $sInclude );
		return $this->addIncludeModifiedParam( path_join( Services::WpGeneral()->getWpUrl(), $sInclude ), $sInclude );
	}

	/**
	 * @param $sUrl
	 * @param $sInclude
	 * @return string
	 */
	public function addIncludeModifiedParam( $sUrl, $sInclude ) {
		$nTime = Services::WpFs()->getModifiedTime( path_join( ABSPATH, $sInclude ) );
		return add_query_arg( array( 'mtime' => $nTime ), $sUrl );
	}
}