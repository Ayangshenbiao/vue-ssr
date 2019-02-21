<?php

/**
 * Class WPML_Displayed_String_Filter
 *
 * Handles all string translating when rendering translated strings to the user, unless auto-registering is
 * active for strings.
 */
class WPML_Displayed_String_Filter extends WPML_WPDB_And_SP_User {

	protected $language;
	protected $name_cache = array();
	protected $untranslated_cache = array();
	protected $cache_is_warm = false;
	
	protected $object_cache = null;
	protected $found_cache = array();
	protected $cache_needs_saving = false;
	
	// Current string data.
	protected $name;
	protected $domain;
	protected $gettext_context;
	protected $name_and_gettext_context;
	protected $key;

	/**
	 * @param wpdb $wpdb
	 * @param SitePress $sitepress
	 * @param string $language
	 * @param null|object $existing_filter
	 */
	public function __construct( &$wpdb, &$sitepress, $language, $existing_filter = null ) {
		parent::__construct( $wpdb, $sitepress );
		$this->language           = $language;
		
		if ( $existing_filter ) {
			$this->name_cache = $existing_filter->name_cache;
			$this->untranslated_cache = $existing_filter->untranslated_cache;
			$this->cache_is_warm = $existing_filter->cache_is_warm;
			$this->object_cache = $existing_filter->object_cache;
			$this->found_cache = $existing_filter->found_cache;
			$this->cache_needs_saving = $existing_filter->cache_needs_saving;
		} else {
			$this->object_cache = new WPML_WP_Cache( 'wpml_display_filter' );
		}
	}
	
	public function save_to_cache() {
		if ( $this->cache_needs_saving ) {
			foreach( array_keys( $this->found_cache ) as $cache_key ) {
				$this->object_cache->set( $cache_key, $this->found_cache[ $cache_key ] );
			}
		}
	}
	
	public function clear_cache() {
		$this->found_cache = array();
		$this->object_cache->flush_group_cache();
		$this->cache_needs_saving = false;
	}

	/**
	 * @param string       $untranslated_text
	 * @param string       $name
	 * @param string|array $context
	 * @param null|bool    $has_translation
	 *
	 * @return bool|false|string
	 */
	public function translate_by_name_and_context( $untranslated_text, $name, $context = "", &$has_translation = null ) {
		$this->initialize_current_string( $name, $context );
 		$key_name = $this->name_and_gettext_context;
		$key_context = $this->domain;

		$cache_key = $key_context . $this->language;
		if ( ! isset( $this->found_cache[ $cache_key ] ) ) {
			$this->found_cache[ $cache_key ] = $this->object_cache->get( $cache_key, $found );
			if ( ! $found ) {
				$this->found_cache[ $cache_key ] = array();
			}
		}
		
		$found = false;
		if ( isset( $this->found_cache[ $cache_key ][ $key_name ] ) ) {
			$res = $this->found_cache[ $cache_key ][ $key_name ];
			$has_translation = $res[1];
			$res = $res[0];
			$found = true;
		}
		
		if ( ! $found ) {
		
			$res = $this->string_from_registered( );
			$untranslated_text_has_content = !is_array($untranslated_text) && strlen( $untranslated_text ) !== 0 ? true : false;
			$has_translation = $res !== false && ! isset( $this->untranslated_cache[ $this->key ] ) ? true : null;
			$res             = $res === false && $untranslated_text_has_content === true ? $untranslated_text : $res;
			$res             = $res === false ? $this->get_original_value( $name, $context ) : $res;
			
			$this->found_cache[ $cache_key ][ $key_name ] = array( $res, $has_translation );
			$this->cache_needs_saving = true;
		}

		return $res;
	}

	/**
	 * @param string $name
	 * @param string $context
	 *
	 * Tries to retrieve a string from the cache and runs fallback logic for the default WP context
	 *
	 * @return bool
	 */
	protected function string_from_registered(  ) {
		if ( $this->cache_is_warm === false ) {
			$this->warm_cache();
		}

		$res = $this->get_string_from_cache( );
		$res = $res === false ? $this->try_fallback_domain( ) : $res;
		
		return $res;
	}
	
	private function try_fallback_domain( ) {

		$res = false;

		if ($this->domain === 'default' ) {
			$this->domain = 'WordPress';
			$this->key = md5( $this->domain . $this->name_and_gettext_context );
			$res = $this->get_string_from_cache( );
		} elseif ( $this->domain === 'WordPress' ) {
			$this->domain = 'default';
			$this->key = md5( $this->domain . $this->name_and_gettext_context );
			$res = $this->get_string_from_cache( );
		}

		return $res;
	}

	/**
	 * Populates the caches in this object
	 *
	 * @param string|null          $name
	 * @param string|string[]|null $context
	 * @param string               $untranslated_value
	 */
	protected function warm_cache( $name = null, $context = null, $untranslated_value = "" ) {
		$res_args    = array( ICL_TM_COMPLETE, $this->language, $this->language );

		$filter = '';
		if ( null !== $name ) {
			list( , , $key ) = $this->key_by_name_and_context( $name, $context );
			if ( isset( $this->name_cache[ $key ] ) ) {
				return;
			} else {
				$name_cache[ $key ]               = $untranslated_value;
				$this->untranslated_cache[ $key ] = true;
				$filter                           = ' WHERE s.name=%s';
				$res_args[] = $name;
			}
		} else {
			$this->cache_is_warm = true;
		}

		$res_query   = "
					SELECT
						st.value AS tra,
						s.value AS org,
						s.domain_name_context_md5 AS ctx
					FROM {$this->wpdb->prefix}icl_strings s
					LEFT JOIN {$this->wpdb->prefix}icl_string_translations st
						ON s.id=st.string_id
							AND st.status=%d
							AND st.language=%s
							AND s.language!=%s
					{$filter}
					";
		$res_prepare = $this->wpdb->prepare( $res_query, $res_args );
		$res         = $this->wpdb->get_results( $res_prepare, ARRAY_A );

		$name_cache = array();
		foreach ( $res as $str ) {
			if ( $str['tra'] != null ) {
				$name_cache[ $str['ctx'] ] = &$str['tra'];
			} else {
				$name_cache[ $str['ctx'] ] = &$str['org'];
			}
			$this->untranslated_cache[ $str['ctx'] ] = $str['tra'] == '' ? true : null;
		}

		$this->name_cache     = $name_cache;
	}
	
	/**
	 * @param string          $name
	 * @param string|string[] $context
	 */
	protected function initialize_current_string( $name, $context ) {
		if ( is_array( $context ) ) {
			$this->domain          = isset ( $context[ 'domain' ] ) ? $context[ 'domain' ] : '';
			$this->gettext_context = isset ( $context[ 'context' ] ) ? $context[ 'context' ] : '';
		} else {
			$this->domain = $context;
			$this->gettext_context = '';
		}
		list( $this->name, $this->domain ) = array_map( array(
			$this,
			'truncate_long_string'
		), array( $name, $this->domain ) );

		$this->name_and_gettext_context = $this->name . $this->gettext_context;
		$this->key = md5( $this->domain . $this->name_and_gettext_context );
	}
	
	/**
	 * @param string          $name
	 * @param string|string[] $context
	 *
	 * @return array
	 */
	protected function truncate_name_and_context( $name, $context) {
		if ( is_array( $context ) ) {
			$domain          = isset ( $context[ 'domain' ] ) ? $context[ 'domain' ] : '';
			$gettext_context = isset ( $context[ 'context' ] ) ? $context[ 'context' ] : '';
		} else {
			$domain = $context;
			$gettext_context = '';
		}
		list( $name, $domain ) = array_map( array(
			$this,
			'truncate_long_string'
		), array( $name, $domain ) );

		return array( $name . $gettext_context, $domain );
	}

	protected function key_by_name_and_context( $name, $context ) {

		return array(
			$this->domain,
			$this->gettext_context,
			md5( $this->domain . $this->name_and_gettext_context )
		);
	}

	/**
	 * Truncates a string to the maximum string table column width
	 *
	 * @param string $string
	 *
	 * @return string
	 */
	private function truncate_long_string( $string ) {

		return mb_strlen( $string ) > WPML_STRING_TABLE_NAME_CONTEXT_LENGTH
			? substr( $string, 0,
				WPML_STRING_TABLE_NAME_CONTEXT_LENGTH )
			: $string;
	}

	/**
	 * @param string       $name
	 * @param string|array $context
	 *
	 * @return string|bool|false
	 */
	private function get_original_value( $name, $context ) {

		static $domains_loaded = array();

		if ( ! isset( $this->name_cache[ $this->key ] ) ) {
			if ( ! in_array( $this->domain, $domains_loaded ) ) {
				// preload all strings in this context
				$query   = $this->wpdb->prepare(
					"SELECT value, name FROM {$this->wpdb->prefix}icl_strings WHERE context = %s",
					$this->domain
				);
				$results = $this->wpdb->get_results( $query );
				foreach ( $results as $string ) {
					$string_key = md5( $this->domain . $string->name . $this->gettext_context );
					if ( ! isset( $this->name_cache[ $string_key ] ) ) {
						$this->name_cache[ $string_key ] = $string->value;
					}
				}
				$domains_loaded[] = $this->domain;
			}

			if ( ! isset( $this->name_cache[ $this->key ] ) ) {
				$this->name_cache[ $this->key ] = false;
			}
		}

		return $this->name_cache[ $this->key ];
	}

	private function get_string_from_cache( ) {
		$res = isset( $this->name_cache[ $this->key ] ) ? $this->name_cache[ $this->key ] : false;

		return $res;
	}


}