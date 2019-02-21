<?php

namespace FernleafSystems\Wordpress\Services\Utilities;

use FernleafSystems\Utilities\Data\Adapter\StdClassAdapter;
use FernleafSystems\Wordpress\Services\Services;
use Html2Text\Html2Text;

/**
 * Class Email
 * @package FernleafSystems\Wordpress\Services\Utilities
 * @property string $to_email
 * @property string $to_name
 * @property string $from_email
 * @property string $from_name
 * @property string $subject
 * @property array  $content
 * @property bool   $wrap_content
 * @property bool   $wrap_subject
 * @property bool   $is_html
 * @property bool   $is_success  whether the last email sent was successful (according to WP)
 */
class Email {

	use StdClassAdapter;

	public function __construct() {
	}

	/**
	 * @param string $sLine
	 * @return $this
	 */
	public function addContentLine( $sLine ) {
		$aC = $this->getContentBody();
		$aC[] = $sLine;
		return $this->setContentBody( $aC );
	}

	/**
	 * @return $this
	 */
	public function addContentNewLine() {
		return $this->addContentLine( "\r\n" );
	}

	/**
	 * @param $bAdd - true to add, false to remove
	 */
	protected function emailFilters( $bAdd ) {
		if ( $bAdd ) {
			add_action( 'phpmailer_init', array( $this, 'onPhpMailerInit' ), PHP_INT_MAX, 1 );
			add_filter( 'wp_mail_from', array( $this, 'filterMailFrom' ), 100 );
			add_filter( 'wp_mail_from_name', array( $this, 'filterMailFromName' ), 100 );
			add_filter( 'wp_mail_content_type', array( $this, 'filterMailContentType' ), 100, 0 );
		}
		else {
			remove_action( 'phpmailer_init', array( $this, 'onPhpMailerInit' ), PHP_INT_MAX );
			remove_filter( 'wp_mail_from', array( $this, 'filterMailFrom' ), 100 );
			remove_filter( 'wp_mail_from_name', array( $this, 'filterMailFromName' ), 100 );
			remove_filter( 'wp_mail_content_type', array( $this, 'filterMailContentType' ), 100 );
		}
	}

	/**
	 * Ensures HTML emails are correctly formated to contain plain text content also.
	 * @param \PHPMailer $oMailer
	 */
	public function onPhpMailerInit( $oMailer ) {
		if ( strcasecmp( $oMailer->ContentType, 'text/html' ) == 0 && empty( $oMailer->AltBody ) ) {
			try {
				$oMailer->AltBody = Html2Text::convert( $oMailer->Body );
			}
			catch ( \Exception $oE ) {
			}
		}
	}

	/**
	 * @return $this
	 */
	public function send() {
		// Add our filters for From.
		$this->emailFilters( true );
		$this->is_success = wp_mail(
			$this->getToAddress(),
			$this->getSubject(),
			$this->getMessageBody()
		);
		$this->emailFilters( false );
		return $this->resetPhpMailer();
	}

	/**
	 * @return $this
	 */
	public function resetPhpMailer() {
		global $phpmailer;
		$phpmailer = null;
		return $this;
	}

	/**
	 * @return string
	 */
	protected function getMessageBody() {
		$aBody = $this->getContentBody();
		if ( $this->isWrapContentBody() ) {
			$aBody = array_merge(
				$this->getContentHeader(),
				[ '' ],
				$aBody,
				[ '' ],
				$this->getContentFooter()
			);
		}
		$sBody = implode( ( $this->isHtml() ? '<br />' : "\r\n" ), $aBody );
		if ( $this->isHtml() ) {
			$sBody = '<html><body>'.$sBody.'</body></html>';
		}
		return $sBody;
	}

	/**
	 * @return array
	 */
	protected function getContentHeader() {
		return array( sprintf( __( 'Hi%s' ), empty( $this->to_name ) ? '' : ' '.$this->to_name ).',' );
	}

	/**
	 * @return array
	 */
	protected function getContentBody() {
		return $this->getArrayParam( 'content' );
	}

	/**
	 * @return array
	 */
	protected function getContentFooter() {
		$sUrl = Services::WpGeneral()->getHomeUrl();
		return array(
			'----',
			sprintf( __( 'Email sent from %s' ), sprintf( '<a href="%s">%s</a>', $sUrl, $sUrl ) ),
			__( 'Note: Email delays are caused by website hosting and email providers.' ),
			sprintf( __( 'Time Sent: %s' ), Services::WpGeneral()->getTimeStampForDisplay() )
		);
	}

	/**
	 * @return string
	 */
	protected function getSubject() {
		$sSub = (string)$this->subject;
		if ( $this->isWrapSubject() ) {
			$sSub = sprintf( '[%s] %s', Services::WpGeneral()->getSiteName(), $sSub );
		}
		return wp_specialchars_decode( $sSub );
	}

	/**
	 * @return string
	 */
	protected function getToAddress() {
		return Services::Data()->validEmail( $this->to_email ) ? $this->to_email : Services::WpGeneral()
																						   ->getSiteAdminEmail();
	}

	/**
	 * @return bool
	 */
	protected function isHtml() {
		return isset( $this->is_html ) ? (bool)$this->is_html : true;
	}

	/**
	 * @return bool
	 */
	protected function isWrapContentBody() {
		return isset( $this->wrap_content ) ? (bool)$this->wrap_content : true;
	}

	/**
	 * Whether to wrap the given email subject with a prefix that indicate the source site
	 * @return bool
	 */
	protected function isWrapSubject() {
		return isset( $this->wrap_subject ) ? (bool)$this->wrap_subject : true;
	}

	/**
	 * @param array|string $aContent
	 * @return $this
	 */
	public function setContentBody( $aContent ) {
		if ( !is_array( $aContent ) && is_scalar( $aContent ) ) {
			$aContent = [ $aContent ];
		}
		return $this->setParam( 'content', $aContent );
	}

	/**
	 * @return string
	 */
	public function filterMailContentType() {
		return $this->isHtml() ? 'text/html' : 'text/plain';
	}

	/**
	 * @param string $sFrom
	 * @return string
	 */
	public function filterMailFrom( $sFrom ) {
		if ( Services::Data()->validEmail( $this->from_email ) ) {
			$sFrom = $this->from_email;
		}
		return $sFrom;
	}

	/**
	 * @param string $sFrom
	 * @return string
	 */
	public function filterMailFromName( $sFrom ) {
		if ( !empty( $this->from_name ) ) {
			$sFrom = $this->from_name;
		}
		return $sFrom;
	}

	/**
	 * @param bool $bWrap
	 * @return $this
	 */
	public function setIsWrapBodyContent( $bWrap ) {
		$this->wrap_content = (bool)$bWrap;
		return $this;
	}

	/**
	 * @param string $sSubject
	 * @return $this
	 */
	public function setSubject( $sSubject ) {
		$this->subject = $sSubject;
		return $this;
	}

	/**
	 * @param string $sEmail
	 * @return $this
	 */
	public function setToEmail( $sEmail ) {
		$this->to_email = $sEmail;
		return $this;
	}
}