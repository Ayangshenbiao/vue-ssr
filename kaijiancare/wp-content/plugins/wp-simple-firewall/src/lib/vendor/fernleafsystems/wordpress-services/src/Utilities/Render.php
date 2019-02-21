<?php

namespace FernleafSystems\Wordpress\Services\Utilities;

use FernleafSystems\Wordpress\Services\Services;

class Render {

	const TEMPLATE_ENGINE_TWIG = 0;
	const TEMPLATE_ENGINE_PHP = 1;
	const TEMPLATE_ENGINE_HTML = 2;

	/**
	 * @var array
	 */
	protected $aRenderVars;

	/**
	 * @var array
	 */
	protected $aTemplateRoots;

	/**
	 * @var string
	 */
	protected $sTemplate;

	/**
	 * @var int
	 */
	protected $nTemplateEngine;

	/**
	 * @return string
	 */
	public function render() {

		switch ( $this->getTemplateEngine() ) {

			case self::TEMPLATE_ENGINE_TWIG :
				$sOutput = $this->renderTwig();
				break;

			case self::TEMPLATE_ENGINE_HTML :
				$sOutput = $this->renderHtml();
				break;

			default:
				$sOutput = $this->renderPhp();
				break;
		}
		return $sOutput;
	}

	/**
	 * @return string
	 */
	private function renderHtml() {
		ob_start();
		@include( path_join( $this->getTemplateRoot(), $this->getTemplate() ) );
		return ob_get_clean();
	}

	/**
	 * @return string
	 */
	private function renderPhp() {
		if ( count( $this->getRenderVars() ) > 0 ) {
			extract( $this->getRenderVars() );
		}

		$sTemplate = path_join( $this->getTemplateRoot(), $this->getTemplate() );
		if ( Services::WpFs()->isFile( $sTemplate ) ) {
			ob_start();
			include( $sTemplate );
			$sContents = ob_get_clean();
		}
		else {
			$sContents = 'Error: Template file not found: '.$sTemplate;
		}

		return $sContents;
	}

	/**
	 * @return string
	 */
	private function renderTwig() {
		try {
			return $this->getTwigEnvironment()
						->render( $this->getTemplate(), $this->getRenderVars() );
		}
		catch ( \Exception $oE ) {
			return 'Could not render Twig with following Exception: '.$oE->getMessage();
		}
	}

	/**
	 */
	public function display() {
		echo $this->render();
		return $this;
	}

	/**
	 * @return $this
	 */
	public function clearRenderVars() {
		return $this->setRenderVars( array() );
	}

	/**
	 * @return \Twig_Environment
	 */
	protected function getTwigEnvironment() {
		return new \Twig_Environment(
			new \Twig_Loader_Filesystem( $this->getTemplateRoots() ),
			array(
				'debug'            => true,
				'strict_variables' => true,
			)
		);
	}

	/**
	 * @return string
	 */
	public function getTemplate() {
		$this->sTemplate = Services::Data()->addExtensionToFilePath( $this->sTemplate, $this->getEngineStub() );
		return $this->sTemplate;
	}

	/**
	 * @return int
	 */
	public function getTemplateEngine() {
		if ( !isset( $this->nTemplateEngine )
			 || !in_array( $this->nTemplateEngine, array(
				self::TEMPLATE_ENGINE_TWIG,
				self::TEMPLATE_ENGINE_PHP,
				self::TEMPLATE_ENGINE_HTML
			) ) ) {
			$this->nTemplateEngine = self::TEMPLATE_ENGINE_PHP;
		}
		return $this->nTemplateEngine;
	}

	/**
	 * @param string $sTemplate
	 * @return string
	 */
	public function getTemplateExists( $sTemplate = '' ) {
		return strlen( $this->getTemplateRoot( $sTemplate ) ) > 0;
	}

	/**
	 * @param string $sTemplate
	 * @return string
	 */
	public function getTemplateRoot( $sTemplate = '' ) {
		$sRoot = '';
		$oFs = Services::WpFs();
		$sTemplate = empty( $sTemplate ) ? $this->getTemplate() : $sTemplate;
		foreach ( $this->getTemplateRoots() as $sPossibleRoot ) {
			if ( $oFs->exists( path_join( $sPossibleRoot, $sTemplate ) ) ) {
				$sRoot = $sPossibleRoot;
				break;
			}
		}
		return $sRoot;
	}

	/**
	 * @return array
	 */
	public function getTemplateRoots() {
		return array_map(
			function ( $sRoot ) {
				return path_join( $sRoot, $this->getEngineStub() );
			},
			$this->getTemplateRootsPlain()
		);
	}

	/**
	 * @return array
	 */
	private function getTemplateRootsPlain() {
		if ( !is_array( $this->aTemplateRoots ) ) {
			$this->aTemplateRoots = array();
		}
		return $this->aTemplateRoots;
	}


	/**
	 * @return array
	 */
	public function getRenderVars() {
		return is_array( $this->aRenderVars ) ? $this->aRenderVars : array();
	}

	/**
	 * @param array $aVars
	 * @return $this
	 */
	public function setRenderVars( $aVars ) {
		$this->aRenderVars = $aVars;
		return $this;
	}

	/**
	 * @param string $sPath
	 * @return $this
	 */
	public function setTemplate( $sPath ) {
//			if ( !preg_match( '#\.twig$#', $sPath ) ) {
//				$sPath = $sPath . '.twig';
//			}
		$this->sTemplate = $sPath;
		return $this;
	}

	/**
	 * @return $this
	 */
	public function setTemplateEngineHtml() {
		return $this->setTemplateEngine( self::TEMPLATE_ENGINE_HTML );
	}

	/**
	 * @return $this
	 */
	public function setTemplateEnginePhp() {
		return $this->setTemplateEngine( self::TEMPLATE_ENGINE_PHP );
	}

	/**
	 * @return $this
	 */
	public function setTemplateEngineTwig() {
		return $this->setTemplateEngine( self::TEMPLATE_ENGINE_TWIG );
	}

	/**
	 * @param int $nEngine
	 * @return $this
	 */
	protected function setTemplateEngine( $nEngine ) {
		$this->nTemplateEngine = $nEngine;
		return $this;
	}

	/**
	 * @param string $sPath
	 * @return $this
	 */
	public function setTemplateRoot( $sPath ) {
		if ( !empty( $sPath ) ) {
			$aTemps = $this->getTemplateRootsPlain();
			$aTemps[] = $sPath;
			$this->aTemplateRoots = array_unique( $aTemps );
		}
		return $this;
	}

	/**
	 * @return string
	 */
	private function getEngineStub() {
		switch ( $this->getTemplateEngine() ) {

			case self::TEMPLATE_ENGINE_TWIG:
				$sStub = 'twig';
				break;

			case self::TEMPLATE_ENGINE_HTML:
				$sStub = 'html';
				break;

			case self::TEMPLATE_ENGINE_PHP:
				$sStub = 'php';
				break;

			default:
				$sStub = 'php';
				break;
		}
		return $sStub;
	}
}