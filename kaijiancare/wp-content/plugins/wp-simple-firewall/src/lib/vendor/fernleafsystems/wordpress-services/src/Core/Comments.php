<?php

namespace FernleafSystems\Wordpress\Services\Core;

use FernleafSystems\Wordpress\Services\Services;

/**
 */
class Comments {

	/**
	 * @var bool
	 */
	protected $bIsCommentSubmission;

	/**
	 * @return bool
	 */
	public function getIfCommentsMustBePreviouslyApproved() {
		return ( Services::WpGeneral()->getOption( 'comment_whitelist' ) == 1 );
	}

	/**
	 * @param \WP_Post|null $oPost - queries the current post if null
	 * @return bool
	 */
	public function isCommentsOpen( $oPost = null ) {
		if ( is_null( $oPost ) || !is_a( $oPost, 'WP_Post' )) {
			global $post;
			$oPost = $post;
		}
		$bOpen = is_a( $oPost, '\WP_Post' )
			&& comments_open( $oPost->ID )
			&& get_post_status( $oPost ) != 'trash'
			&& !post_password_required( $oPost->ID );
		return $bOpen;
	}

	/**
	 * @return bool
	 */
	public function isCommentsOpenByDefault() {
		return ( Services::WpGeneral()->getOption( 'default_comment_status' ) == 'open' );
	}

	/**
	 * @param string $sAuthorEmail
	 * @return bool
	 */
	public function isCommentAuthorPreviouslyApproved( $sAuthorEmail ) {

		if ( empty( $sAuthorEmail ) || !is_email( $sAuthorEmail ) ) {
			return false;
		}

		$oDb = Services::WpDb();
		$sQuery = "
				SELECT comment_approved
				FROM %s
				WHERE
					comment_author_email = '%s'
					AND comment_approved = '1'
					LIMIT 1
			";

		$sQuery = sprintf(
			$sQuery,
			$oDb->getTable_Comments(),
			esc_sql( $sAuthorEmail )
		);
		return $oDb->getVar( $sQuery ) == 1;
	}

	/**
	 * @return bool
	 */
	public function isCommentSubmission() {
		if ( !isset( $this->bIsCommentSubmission ) ) {
			$this->bIsCommentSubmission = Services::Request()->isPost() && Services::WpGeneral()->getIsCurrentPage( 'wp-comments-post.php' );
			if ( $this->bIsCommentSubmission ) {
				$nPostId = Services::Request()->post( 'comment_post_ID' );
				$this->bIsCommentSubmission = !empty( $nPostId ) && is_numeric( $nPostId );
			}
		}
		return $this->bIsCommentSubmission;
	}

	/**
	 * @return bool
	 */
	public function getCommentSubmissionEmail() {
		$sData = null;
		if ( $this->isCommentSubmission() ) {
			$sData = Services::Request()->query( 'email' );
			$sData = is_string( $sData ) ? trim( $sData ) : null;
		}
		return $sData;
	}

	/**
	 * @return array
	 */
	public function getCommentSubmissionComponents() {
		return array(
			'comment_post_ID',
			'author',
			'email',
			'url',
			'comment',
			'comment_parent',
		);
	}
}