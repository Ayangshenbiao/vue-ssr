<?php

namespace FernleafSystems\Wordpress\Services\Utilities\WpOrg;

use FernleafSystems\Wordpress\Services\Services;

class Core {

	const URL_SVN_ROOT = 'https://core.svn.wordpress.org';

	/**
	 * @var string[]
	 */
	private $aWpVersions;

	/**
	 * @return string[]
	 */
	public function getAllVersions() {
		if ( empty( $this->aWpVersions ) ) {
			$this->aWpVersions = $this->downloadVersions();
		}
		return $this->aWpVersions;
	}

	/**
	 * @return string
	 */
	public function getLatestVersion() {
		$aVs = $this->getAllVersions();
		return end( $aVs );
	}

	/**
	 * @param string $sVersionBranch - leave empty to use the current WP Version
	 * @return string
	 * @throws \Exception
	 */
	public function getLatestVersionForBranch( $sVersionBranch = null ) {
		if ( empty( $sVersionBranch ) ) {
			$sVersionBranch = Services::WpGeneral()->getVersion();
		}
		$aParts = explode( '.', $sVersionBranch );
		if ( count( $aParts ) < 2 ) {
			throw new \Exception( sprintf( 'Invalid version "%s" provided.', $sVersionBranch ) );
		}

		$sThisBranch = $aParts[ 0 ].'.'.$aParts[ 1 ];

		$aPossible = array_filter(
			$this->getAllVersions(),
			function ( $sVersion ) use ( $sThisBranch ) {
				return strpos( $sVersion, $sThisBranch ) === 0;
			}
		);
		return end( $aPossible );
	}

	/**
	 * @return array
	 */
	protected function downloadVersions() {
		$aV = array();
		$sSvnVersionsContent = Services::WpFs()->getUrlContent(
			sprintf( '%s/%s/', static::URL_SVN_ROOT, 'tags' )
		);

		if ( !empty( $sSvnVersionsContent ) ) {
			$oSvnDom = new \DOMDocument();
			$oSvnDom->loadHTML( $sSvnVersionsContent );

			foreach ( $oSvnDom->getElementsByTagName( 'a' ) as $oElem ) {
				/** @var \DOMElement $oElem */
				$sHref = $oElem->getAttribute( 'href' );
				if ( $sHref != '../' && !filter_var( $sHref, FILTER_VALIDATE_URL ) ) {
					$aV[] = trim( $sHref, '/' );
				}
			}
		}

		usort( $aV, 'version_compare' );
		return $aV;
	}

	/**
	 * @param string[] $aWpVersions
	 * @return $this
	 */
	public function setWpVersions( $aWpVersions ) {
		$this->aWpVersions = $aWpVersions;
		return $this;
	}
}