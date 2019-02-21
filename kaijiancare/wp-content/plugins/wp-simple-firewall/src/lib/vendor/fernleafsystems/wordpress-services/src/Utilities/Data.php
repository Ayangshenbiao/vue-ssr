<?php

namespace FernleafSystems\Wordpress\Services\Utilities;

use FernleafSystems\Wordpress\Services\Services;

class Data {

	/**
	 * @var bool
	 */
	public static $bUseFilterInput = false;

	/**
	 * @var string
	 */
	protected static $sIpAddress = false;

	/**
	 * @var string
	 */
	protected static $nIpAddressVersion = false;

	/**
	 * @param boolean $bAsHuman
	 * @return int|string|bool - visitor IP Address as IP2Long
	 */
	public function getVisitorIpAddress( $bAsHuman = true ) {

		if ( empty( self::$sIpAddress ) ) {
			self::$sIpAddress = $this->findViableVisitorIp();
		}

		if ( !self::$sIpAddress || $bAsHuman ) {
			return self::$sIpAddress;
		}

		// If it's IPv6 we never return as long (we can't!)
		return ( $this->getVisitorIpVersion() == 4 ) ? ip2long( self::$sIpAddress ) : self::$sIpAddress;
	}

	/**
	 * Cloudflare compatible.
	 * @return string|bool
	 */
	protected function findViableVisitorIp() {

		$aAddressSourceOptions = array(
			'HTTP_CF_CONNECTING_IP',
			'HTTP_X_FORWARDED_FOR',
			'HTTP_X_FORWARDED',
			'HTTP_X_REAL_IP',
			'HTTP_X_SUCURI_CLIENTIP',
			'HTTP_INCAP_CLIENT_IP',
			'HTTP_FORWARDED',
			'HTTP_CLIENT_IP',
			'REMOTE_ADDR'
		);

		$sIpToReturn = false;
		$oReq = Services::Request();
		foreach ( $aAddressSourceOptions as $sOption ) {

			$sIpAddressToTest = $oReq->server( $sOption );
			if ( empty( $sIpAddressToTest ) ) {
				continue;
			}

			$aIpAddresses = explode( ',', $sIpAddressToTest ); //sometimes a comma-separated list is returned
			foreach ( $aIpAddresses as $sIpAddress ) {
				if ( empty( $sIpAddress ) ) {
					continue;
				}

				// this version checking serves to weed out IPv6 if filter_var isn't supported by their PHP.
				// I.e. We ONLY support IPv6 if filter_var() is supported.
				$nVersion = $this->getIpAddressVersion( $sIpAddress );
				if ( $nVersion != false ) {
					$sIpToReturn = $sIpAddress;
					break( 2 );
				}
			}
		}
		return $sIpToReturn;
	}

	/**
	 * @param string $sPath
	 * @param string $sExtensionToAdd
	 * @return string
	 */
	public function addExtensionToFilePath( $sPath, $sExtensionToAdd ) {

		if ( strpos( $sExtensionToAdd, '.' ) === false ) {
			$sExtensionToAdd = '.'.$sExtensionToAdd;
		}

		if ( !$this->getIfStringEndsIn( $sPath, $sExtensionToAdd ) ) {
			$sPath = $sPath.$sExtensionToAdd;
		}
		return $sPath;
	}

	/**
	 * @param string $sHaystack
	 * @param string $sNeedle
	 * @return bool
	 */
	public function getIfStringEndsIn( $sHaystack, $sNeedle ) {
		$nNeedleLength = strlen( $sNeedle );
		$sStringEndsIn = substr( $sHaystack, strlen( $sHaystack ) - $nNeedleLength, $nNeedleLength );
		return ( $sStringEndsIn == $sNeedle );
	}

	/**
	 * @param string $sPath
	 * @return string
	 */
	public function getExtension( $sPath ) {
		$nLastPeriod = strrpos( $sPath, '.' );
		return ( $nLastPeriod === false ) ? $sPath : str_replace( '.', '', substr( $sPath, $nLastPeriod ) );
	}

	/**
	 * @return bool|int|string
	 */
	public function getVisitorIpVersion() {
		if ( empty( self::$nIpAddressVersion ) ) {
			self::$nIpAddressVersion = $this->getIpAddressVersion( $this->getVisitorIpAddress( true ) );
		}
		return self::$nIpAddressVersion;
	}

	/**
	 * @param string $sEmail
	 * @return bool
	 */
	public function validEmail( $sEmail ) {
		return ( !empty( $sEmail ) && is_email( $sEmail ) );
	}

	/**
	 * @param string $sRawList
	 * @return array
	 */
	public function extractCommaSeparatedList( $sRawList = '' ) {

		$aRawList = array();
		if ( empty( $sRawList ) ) {
			return $aRawList;
		}

		$aRawList = array_map( 'trim', preg_split( '/\r\n|\r|\n/', $sRawList ) );
		$aNewList = array();
		$bHadStar = false;
		foreach ( $aRawList as $sKey => $sRawLine ) {

			if ( empty( $sRawLine ) ) {
				continue;
			}
			$sRawLine = str_replace( ' ', '', $sRawLine );
			$aParts = explode( ',', $sRawLine, 2 );
			// we only permit 1x line beginning with *
			if ( $aParts[ 0 ] == '*' ) {
				if ( $bHadStar ) {
					continue;
				}
				$bHadStar = true;
			}
			else {
				//If there's only 1 item on the line, we assume it to be a global
				// parameter rule
				if ( count( $aParts ) == 1 || empty( $aParts[ 1 ] ) ) { // there was no comma in this line in the first place
					array_unshift( $aParts, '*' );
				}
			}

			$aParams = empty( $aParts[ 1 ] ) ? array() : explode( ',', $aParts[ 1 ] );
			$aNewList[ $aParts[ 0 ] ] = $aParams;
		}
		return $aNewList;
	}

	/**
	 * @param string $sRawAddress
	 *
	 * @return string
	 */
	public static function Clean_Ip( $sRawAddress ) {
		$sRawAddress = preg_replace( '/[a-z\s]/i', '', $sRawAddress );
		$sRawAddress = str_replace( '.', 'PERIOD', $sRawAddress );
		$sRawAddress = str_replace( '-', 'HYPEN', $sRawAddress );
		$sRawAddress = str_replace( ':', 'COLON', $sRawAddress );
		$sRawAddress = preg_replace( '/[^a-z0-9]/i', '', $sRawAddress );
		$sRawAddress = str_replace( 'PERIOD', '.', $sRawAddress );
		$sRawAddress = str_replace( 'HYPEN', '-', $sRawAddress );
		$sRawAddress = str_replace( 'COLON', ':', $sRawAddress );
		return $sRawAddress;
	}

	/**
	 * Taken from http://www.phacks.net/detecting-search-engine-bot-and-web-spiders/
	 */
	public static function IsSearchEngineBot() {

		$sUserAgent = Services::Request()->server( 'HTTP_USER_AGENT' );
		if ( empty( $sUserAgent ) ) {
			return false;
		}

		$sBots = 'Googlebot|bingbot|Twitterbot|Baiduspider|ia_archiver|R6_FeedFetcher|NetcraftSurveyAgent'
				 .'|Sogou web spider|Yahoo! Slurp|facebookexternalhit|PrintfulBot|msnbot|UnwindFetchor|urlresolver|Butterfly|TweetmemeBot';

		return ( preg_match( "/$sBots/", $sUserAgent ) > 0 );
	}

	/**
	 * @param $sRawKeys
	 * @return array
	 */
	public static function CleanYubikeyUniqueKeys( $sRawKeys ) {
		$aKeys = explode( "\n", $sRawKeys );
		foreach ( $aKeys as $nIndex => $sUsernameKey ) {
			if ( empty( $sUsernameKey ) ) {
				unset( $aKeys[ $nIndex ] );
				continue;
			}
			$aParts = array_map( 'trim', explode( ',', $sUsernameKey ) );
			if ( empty( $aParts[ 0 ] ) || empty( $aParts[ 1 ] ) || strlen( $aParts[ 1 ] ) < 12 ) {
				unset( $aKeys[ $nIndex ] );
				continue;
			}
			$aParts[ 1 ] = substr( $aParts[ 1 ], 0, 12 );
			$aKeys[ $nIndex ] = array( $aParts[ 0 ] => $aParts[ 1 ] );
		}
		return $aKeys;
	}

	/**
	 * Strength can be 1, 3, 7, 15
	 *
	 * @param integer $nLength
	 * @param integer $nStrength
	 * @param boolean $bIgnoreAmb
	 *
	 * @return string
	 */
	static public function GenerateRandomString( $nLength = 10, $nStrength = 7, $bIgnoreAmb = true ) {
		$aChars = array( 'abcdefghijkmnopqrstuvwxyz' );

		if ( $nStrength & 2 ) {
			$aChars[] = '023456789';
		}

		if ( $nStrength & 4 ) {
			$aChars[] = 'ABCDEFGHJKLMNPQRSTUVWXYZ';
		}

		if ( $nStrength & 8 ) {
			$aChars[] = '$%^&*#';
		}

		if ( !$bIgnoreAmb ) {
			$aChars[] = 'OOlI1';
		}

		$sPassword = '';
		$sCharset = implode( '', $aChars );
		for ( $i = 0 ; $i < $nLength ; $i++ ) {
			$sPassword .= $sCharset[ ( rand()%strlen( $sCharset ) ) ];
		}
		return $sPassword;
	}

	/**
	 * @return string
	 */
	static public function GenerateRandomLetter() {
		$sAtoZ = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
		$nRandomInt = rand( 0, ( strlen( $sAtoZ ) - 1 ) );
		return $sAtoZ[ $nRandomInt ];
	}

	/**
	 * @return string|null
	 */
	static public function GetScriptName() {
		$sScriptName = Services::Request()->server( 'SCRIPT_NAME' );
		return !empty( $sScriptName ) ? $sScriptName : Services::Request()->server( 'PHP_SELF' );
	}

	/**
	 * @param array  $aArray
	 * @param string $sKey The array key to fetch
	 * @param mixed  $mDefault
	 * @return mixed|null
	 */
	public static function ArrayFetch( &$aArray, $sKey, $mDefault = null ) {
		if ( !isset( $aArray[ $sKey ] ) ) {
			return $mDefault;
		}
		return $aArray[ $sKey ];
	}

	/**
	 * @param string $sRequestedUrl
	 * @param string $sBaseUrl
	 */
	public function doSendApache404( $sRequestedUrl, $sBaseUrl ) {
		header( 'HTTP/1.1 404 Not Found' );
		die( '<html><head><title>404 Not Found</title><style type="text/css"></style></head><body><h1>Not Found</h1><p>The requested URL '.$sRequestedUrl.' was not found on this server.</p><p>Additionally, a 404 Not Found error was encountered while trying to use an ErrorDocument to handle the request.</p><hr><address>Apache Server at '.$sBaseUrl.' Port 80</address></body></html>' );
	}

	/**
	 * @param string $sStringContent
	 * @param string $sFilename
	 * @return bool
	 */
	public function downloadStringAsFile( $sStringContent, $sFilename ) {
		header( "Content-type: application/octet-stream" );
		header( "Content-disposition: attachment; filename=".$sFilename );
		header( "Content-Transfer-Encoding: binary" );
		header( "Content-Length: ".strlen( $sStringContent ) );
		echo $sStringContent;
		die();
	}

	/**
	 * @param      $sKey
	 * @param      $mValue
	 * @param int  $nExpireLength
	 * @param null $sPath
	 * @param null $sDomain
	 * @param bool $bSsl
	 *
	 * @return bool
	 */
	public function setCookie( $sKey, $mValue, $nExpireLength = 3600, $sPath = null, $sDomain = null, $bSsl = null ) {
		if ( function_exists( 'headers_sent' ) && headers_sent() ) {
			return false;
		}
		$_COOKIE[ $sKey ] = $mValue;
		return setcookie(
			$sKey,
			$mValue,
			(int)( Services::Request()->ts() + $nExpireLength ),
			( is_null( $sPath ) && defined( 'COOKIEPATH' ) ) ? COOKIEPATH : $sPath,
			( is_null( $sDomain ) && defined( 'COOKIE_DOMAIN' ) ) ? COOKIE_DOMAIN : $sDomain,
			is_null( $bSsl ) ? ( is_ssl() ? true : false ) : $bSsl
		);
	}

	/**
	 * @param string $sKey
	 * @return bool
	 */
	public function setDeleteCookie( $sKey ) {
		unset( $_COOKIE[ $sKey ] );
		return $this->setCookie( $sKey, '', -3600 );
	}

	/**
	 * Effectively validates and IP Address.
	 *
	 * @param string $sIpAddress
	 * @return int|false
	 */
	public function getIpAddressVersion( $sIpAddress ) {

		if ( filter_var( $sIpAddress, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4 ) ) {
			return 4;
		}
		if ( filter_var( $sIpAddress, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6 ) ) {
			return 6;
		}
		return false;
	}

	/**
	 * @return string
	 */
	public function getPhpVersion() {
		return ( defined( 'PHP_VERSION' ) ? PHP_VERSION : phpversion() );
	}

	/**
	 * Cleans out any of the junk that can appear in a PHP version and returns just the 5.4.45
	 * e.g. 5.4.45-0+deb7u5
	 * @return string
	 */
	public function getPhpVersionCleaned() {
		$sVersion = $this->getPhpVersion();
		if ( preg_match( '#^[0-9]{1}\.[0-9]{1}(\.[0-9]{1,3})?#', $sVersion, $aMatches ) ) {
			return $aMatches[ 0 ];
		}
		else {
			return $sVersion;
		}
	}

	/**
	 * @param string $sAtLeastVersion
	 * @return bool
	 */
	public function getPhpVersionIsAtLeast( $sAtLeastVersion ) {
		return version_compare( $this->getPhpVersion(), $sAtLeastVersion, '>=' );
	}

	/**
	 * @return bool
	 */
	public function getPhpSupportsNamespaces() {
		return $this->getPhpVersionIsAtLeast( '5.3' );
	}

	/**
	 * @return bool
	 */
	public function getCanOpensslSign() {
		return function_exists( 'base64_decode' )
			   && function_exists( 'openssl_sign' )
			   && function_exists( 'openssl_verify' )
			   && defined( 'OPENSSL_ALGO_SHA1' );
	}

	/**
	 * @param array $aArray
	 * @return \stdClass
	 */
	public function convertArrayToStdClass( $aArray ) {
		$oObject = new \stdClass();
		if ( !empty( $aArray ) && is_array( $aArray ) ) {
			foreach ( $aArray as $sKey => $mValue ) {
				$oObject->{$sKey} = $mValue;
			}
		}
		return $oObject;
	}

	/**
	 * @param array $aSubjectArray
	 * @param mixed $mValue
	 * @param int   $nDesiredPosition
	 * @return array
	 */
	public function setArrayValueToPosition( $aSubjectArray, $mValue, $nDesiredPosition ) {

		if ( $nDesiredPosition < 0 ) {
			return $aSubjectArray;
		}

		$nMaxPossiblePosition = count( $aSubjectArray ) - 1;
		if ( $nDesiredPosition > $nMaxPossiblePosition ) {
			$nDesiredPosition = $nMaxPossiblePosition;
		}

		$nPosition = array_search( $mValue, $aSubjectArray );
		if ( $nPosition !== false && $nPosition != $nDesiredPosition ) {

			// remove existing and reset index
			unset( $aSubjectArray[ $nPosition ] );
			$aSubjectArray = array_values( $aSubjectArray );

			// insert and update
			// http://stackoverflow.com/questions/3797239/insert-new-item-in-array-on-any-position-in-php
			array_splice( $aSubjectArray, $nDesiredPosition, 0, $mValue );
		}

		return $aSubjectArray;
	}

	/**
	 * Taken from: http://stackoverflow.com/questions/1755144/how-to-validate-domain-name-in-php
	 *
	 * @param string $sDomainName
	 * @return bool
	 */
	public function isValidDomainName( $sDomainName ) {
		$sDomainName = trim( $sDomainName );
		return ( preg_match( "/^([a-z\d](-*[a-z\d])*)(\.([a-z\d](-*[a-z\d])*))*$/i", $sDomainName ) //valid chars check
				 && preg_match( "/^.{1,253}$/", $sDomainName ) //overall length check
				 && preg_match( "/^[^\.]{1,63}(\.[^\.]{1,63})*$/", $sDomainName ) );//length of each label
	}
}