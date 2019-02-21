<?php

namespace FernleafSystems\Wordpress\Services\Core;

use FernleafSystems\Utilities\Response;
use FernleafSystems\Wordpress\Services\Services;

/**
 * Class Respond
 * @package FernleafSystems\Wordpress\Services\Core
 */
class Respond {

	/**
	 * @var Response
	 */
	protected $oResponse;

	public function send() {
		if ( Services::WpGeneral()->getIsAjax() ) {
			$this->sendAjax();
		}
		else {
			// render?
		}
		die();
	}

	/**
	 */
	public function sendAjax() {
		$oResponse = $this->getResponse();
		$aData = $oResponse->getData();

		$sMessage = $oResponse->getMessageText();
		if ( empty( $aData[ 'message' ] ) && !empty( $sMessage ) ) {
			$aData[ 'message' ] = $sMessage;
		}
		wp_send_json( $aData, null );
	}

	/**
	 * @return Response
	 */
	public function getResponse() {
		return $this->oResponse;
	}

	/**
	 * @param Response $oResponse
	 * @return $this
	 */
	public function setResponse( $oResponse ) {
		$this->oResponse = $oResponse;
		return $this;
	}
}