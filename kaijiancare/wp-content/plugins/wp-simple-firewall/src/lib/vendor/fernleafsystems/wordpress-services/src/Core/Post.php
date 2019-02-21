<?php

namespace FernleafSystems\Wordpress\Services\Core;

/**
 */
class Post {

	/**
	 * @param $nId
	 * @return false|\WP_Post
	 */
	public function getById( $nId ) {
		return \WP_Post::get_instance( $nId );
	}
}