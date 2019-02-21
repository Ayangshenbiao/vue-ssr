<?php

class WPML_ST_Upgrade extends WPML_WPDB_And_SP_User {
	
	private $string_settings;
	
	public function __construct( &$wpdb, &$sitepress ) {
		parent::__construct( $wpdb, $sitepress );
		$this->string_settings = $this->sitepress->get_setting( 'st', array() );
	}
	
	public function run() {
		if ( $this->sitepress->get_wp_api()->is_admin() ) {
			if ( $this->sitepress->get_wp_api()->constant( 'DOING_AJAX' ) ) {
				$this->run_ajax();
			} else {
				$this->run_admin();
			}
		} else {
			$this->run_front_end();
		}
	}
	
	private function run_admin() {
		$this->maybe_run( 'WPML_ST_Upgrade_Migrate_Originals' );
	}

	private function run_ajax() {
		$this->maybe_run_ajax( 'WPML_ST_Upgrade_Migrate_Originals' );
	}

	private function run_front_end() {
		
	}
	
	private function maybe_run( $class ) {
		if ( ! isset( $this->string_settings[ $class . '_has_run' ] ) ) {
			$upgrade = new $class( $this->wpdb, $this->sitepress );
			if ( $upgrade->run() ) {
				$this->string_settings[ $class . '_has_run' ] = true;
				$this->sitepress->set_setting( 'st', $this->string_settings, true );
				wp_cache_flush();
			}
		}
	}

	private function maybe_run_ajax( $class ) {
		if ( ! isset( $this->string_settings[ $class . '_has_run' ] ) ) {
			if ( $this->nonce_ok( $class ) ) {
				$upgrade = new $class( $this->wpdb, $this->sitepress );
				if ( $upgrade->run_ajax() ) {
					$this->string_settings[ $class . '_has_run' ] = true;
					$this->sitepress->set_setting( 'st', $this->string_settings, true );
					wp_cache_flush();
					$this->sitepress->get_wp_api()->wp_send_json_success( '' );
				}
			}
		}
	}
	
	private function nonce_ok( $class ) {
		$ok = false;
		
		$class = strtolower( $class );
		$class = str_replace( '_', '-', $class );
		if ( isset( $_POST['action'] ) && $_POST['action'] === $class ) {
			$nonce = filter_input( INPUT_POST, 'nonce', FILTER_SANITIZE_FULL_SPECIAL_CHARS );
			if ( $this->sitepress->get_wp_api()->wp_verify_nonce( $nonce, $class . '-nonce' ) ) {
				$ok = true;
			}
		}
		return $ok;
	}
}

