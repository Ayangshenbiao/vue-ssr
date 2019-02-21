<?php

namespace FernleafSystems\Wordpress\Services\Utilities\ClassicPress;

use FernleafSystems\Wordpress\Services\Services;

/**
 * Class Checksums
 * @package FernleafSystems\Wordpress\Services\Utilities\ClassicPress
 */
class Checksums {

	const URL_GIT_ROOT_ZIP = 'https://github.com/ClassicPress/ClassicPress-release/archive/%s.zip';

	/**
	 * @var string
	 */
	private $sWorkingVersion;

	/**
	 * @throws \Exception
	 */
	public function __construct() {
		if ( !function_exists( 'classicpress_version' ) ) {
			throw new \Exception( 'ClassicPress is not installed' );
		}
	}

	/**
	 * @return string[]
	 */
	public function getChecksums() {
		$sKey = 'odp-clpr-checksums-'.$this->getWorkingVersion();
		$oWp = Services::WpGeneral();

		$aCs = $oWp->getTransient( $sKey );
		if ( empty( $aCs ) || !is_array( $aCs ) ) {
			$aCs = $this->buildChecksums();
			$oWp->setTransient( $sKey, $aCs, WEEK_IN_SECONDS * 6 );
		}

		return $aCs;
	}

	/**
	 * @return string[]
	 */
	public function buildChecksums() {
		$aCheckSums = [];

		$sWorkingDir = $this->prepPackage();
		if ( !empty( $sWorkingDir ) ) {

			$sAbsDir = path_join( $sWorkingDir, sprintf( 'ClassicPress-release-%s', $this->getWorkingVersion() ) ).'/';
			foreach ( Services::WpFs()->getFilesInDir( $sAbsDir, 0 ) as $oItem ) {
				$aCheckSums[ str_replace( $sAbsDir, '', $oItem->getPathname() ) ] = md5_file( $oItem->getPathname() );
			}
			Services::WpFs()->deleteDir( $sWorkingDir );
		}

		return $aCheckSums;
	}

	/**
	 * @return \SplFileInfo[]
	 */
	protected function getFilesInDir() {
		$aFiles = [];
		if ( !empty( $sWorkingDir ) ) {
		}
		return $aFiles;
	}

	/**
	 * @return string
	 */
	private function prepPackage() {
		$bSuccess = false;

		$oFs = Services::WpFs();
		$sTmpDir = path_join( get_temp_dir(), uniqid( 'cp_checksum' ) );
		if ( $oFs->exists( $sTmpDir ) ) {
			$oFs->deleteDir( $sTmpDir );
		}
		if ( $oFs->mkdir( $sTmpDir ) && $oFs->exists( $sTmpDir ) ) {
			$sFile = $this->downloadZip();
			if ( is_string( $sFile ) ) {
				$bSuccess = unzip_file( $sFile, $sTmpDir );
			}
		}

		return $bSuccess ? rtrim( $sTmpDir, '/' ).'/' : '';
	}

	/**
	 * @return string|\WP_Error
	 */
	private function downloadZip() {
		$sUrl = sprintf( self::URL_GIT_ROOT_ZIP, $this->getWorkingVersion() );
		return download_url( $sUrl );
	}

	/**
	 * @return string
	 */
	public function getWorkingVersion() {
		if ( empty( $this->sWorkingVersion ) ) {
			$this->sWorkingVersion = Services::WpGeneral()->getVersion();
		}
		return $this->sWorkingVersion;
	}

	/**
	 * @param string $sVersion
	 * @return $this
	 */
	public function setWorkingVersion( $sVersion ) {
		$this->sWorkingVersion = $sVersion;
		return $this;
	}
}