<?php

namespace FernleafSystems\Wordpress\Services\Utilities\WpOrg;

use FernleafSystems\Wordpress\Services\Services;

class Plugins {

	const URL_TEMPLATE_DOWNLOAD_ZIP = 'https://downloads.wordpress.org/plugin/%s.%s.zip';
	const URL_TEMPLATE_DOWNLOAD_SVN_VERSIONS = 'https://plugins.svn.wordpress.org/%s/tags/';
	const URL_TEMPLATE_DOWNLOAD_SVN_FILE = 'https://plugins.svn.wordpress.org/%s/tags/%s/%s';

	/**
	 * @var string
	 */
	private $sWorkingSlug;

	/**
	 * @return string
	 */
	public function getWorkingSlug() {
		return $this->sWorkingSlug;
	}

	/**
	 * @param string $sVersion
	 * @param string $sFile
	 * @return string
	 * @throws \Exception
	 */
	public function fileFromVersion( $sVersion, $sFile ) {
		$sUrl = sprintf( static::URL_TEMPLATE_DOWNLOAD_SVN_FILE,
			$this->getWorkingSlug(),
			$sVersion,
			$sFile
		);
		return $this->checkUrl( $sUrl )
					->downloadUrl( $sUrl );
	}

	/**
	 * @return string[]
	 */
	public function getAllVersions() {
		$aV = array();
		$sSvnVersionsContent = Services::WpFs()->getUrlContent(
			sprintf( static::URL_TEMPLATE_DOWNLOAD_SVN_VERSIONS, $this->getWorkingSlug() )
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
	 * @return string
	 * @throws \Exception
	 */
	public function latestVersion() {
		$sFileLocation = null;
		$api = plugins_api( 'plugin_information', array(
			'slug'   => $this->getWorkingSlug(),
			'fields' => array(
				'sections' => false,
			),
		) );

		if ( is_wp_error( $api ) ) {
			throw new \Exception( $api->get_error_message() );
		}
		return $this->downloadUrl( $api->download_link );
	}

	/**
	 * @param string $sVersion
	 * @return string
	 * @throws \Exception
	 */
	public function version( $sVersion ) {
		$sVersionUrl = sprintf( static::URL_TEMPLATE_DOWNLOAD_ZIP,
			$this->getWorkingSlug(),
			$sVersion
		);

		return $this->checkUrl( $sVersionUrl )
					->downloadUrl( $sVersionUrl );
	}

	/**
	 * @param string $sVersion
	 * @return string
	 * @throws \Exception
	 */
	public function versionExists( $sVersion ) {
		$sVersionUrl = sprintf( 'https://downloads.wordpress.org/plugin/%s.%s.zip',
			$this->getWorkingSlug(),
			$sVersion
		);

		try {
			$this->checkUrl( $sVersionUrl );
			$bExists = true;
		}
		catch ( \Exception $oE ) {
			$bExists = false;
		};
		return $bExists;
	}

	/**
	 * @param string $sUrl
	 * @return $this
	 * @throws \Exception
	 */
	protected function checkUrl( $sUrl ) {
		$aResponse = wp_remote_head( $sUrl );
		if ( is_wp_error( $aResponse ) ) {
			throw new \Exception( $aResponse->get_error_message() );
		}

		/** @var \WP_HTTP_Requests_Response $oResp */
		$oResp = $aResponse[ 'http_response' ];
		if ( $oResp->get_response_object()->status_code !== 200 ) {
			throw new \Exception( 'Head Request Failed. Likely the version does not exist.' );
		}

		return $this;
	}

	/**
	 * @param string $sUrl
	 * @return string
	 * @throws \Exception
	 */
	protected function downloadUrl( $sUrl ) {
		/** @var string|\WP_Error $sFile */
		$sFile = download_url( $sUrl );
		if ( is_wp_error( $sFile ) ) {
			throw new \Exception( $sFile->get_error_message() );
		}
		if ( !realpath( $sFile ) ) {
			throw new \Exception( 'Downloaded could not be found' );
		}
		return $sFile;
	}

	/**
	 * @param string $sWorkingSlug
	 * @return $this
	 */
	public function setWorkingSlug( $sWorkingSlug ) {
		$this->sWorkingSlug = $sWorkingSlug;
		return $this;
	}
}