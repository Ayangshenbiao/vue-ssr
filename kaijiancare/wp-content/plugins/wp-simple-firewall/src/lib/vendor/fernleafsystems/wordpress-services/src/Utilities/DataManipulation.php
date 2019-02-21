<?php

namespace FernleafSystems\Wordpress\Services\Utilities;

/**
 * Class DataManipulation
 * @package FernleafSystems\Wordpress\Services\Utilities
 */
class DataManipulation {

	/**
	 * @param string $sFullFilePath
	 * @return string
	 */
	public function convertLineEndingsDosToLinux( $sFullFilePath ) {
		return str_replace( ["\r\n","\r"], "\n", file_get_contents( $sFullFilePath ) );
	}

	/**
	 * @param array $aArrayToConvert
	 * @return string
	 */
	public function convertArrayToJavascriptDataString( $aArrayToConvert ) {
		$sParamsAsJs = '';
		foreach ( $aArrayToConvert as $sKey => $sValue ) {
			$sParamsAsJs .= sprintf( "'%s':'%s',", $sKey, $sValue );
		}
		return trim( $sParamsAsJs, ',' );
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
	 * @param \stdClass $oStdClass
	 * @return array
	 */
	public function convertStdClassToArray( $oStdClass ) {
		return json_decode( json_encode( $oStdClass ), true );
	}

	/**
	 * @param array $aArray1
	 * @param array $aArray2
	 * @return array
	 */
	public function mergeArraysRecursive( $aArray1, $aArray2 ) {
		foreach ( $aArray2 as $key => $Value ) {
			if ( array_key_exists( $key, $aArray1 ) && is_array( $Value ) ) {
				$aArray1[ $key ] = $this->mergeArraysRecursive( $aArray1[ $key ], $aArray2[ $key ] );
			}
			else {
				$aArray1[ $key ] = $Value;
			}
		}
		return $aArray1;
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
}