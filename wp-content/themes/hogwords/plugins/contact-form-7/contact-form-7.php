<?php
/* Instagram Feed support functions
------------------------------------------------------------------------------- */

// Theme init priorities:
// 9 - register other filters (for installer, etc.)
if (!function_exists('hogwords_cf7_theme_setup9')) {
	add_action( 'after_setup_theme', 'hogwords_cf7_theme_setup9', 9 );
	function hogwords_cf7_theme_setup9() {
		add_filter('wpcf7_autop_or_not', '__return_false');
		if ( hogwords_exists_cf7() ) {
			add_action( 'wp_enqueue_scripts', 'hogwords_cf7_frontend_scripts', 1100 );
			add_filter( 'hogwords_filter_merge_scripts', 'hogwords_cf7_merge_scripts' );
		}
		if (is_admin()) {
			add_filter( 'hogwords_filter_tgmpa_required_plugins',		'hogwords_cf7_tgmpa_required_plugins' );
		}
	}
}

// Filter to add in the required plugins list
if ( !function_exists( 'hogwords_cf7_tgmpa_required_plugins' ) ) {
	
	function hogwords_cf7_tgmpa_required_plugins($list=array()) {
		if (hogwords_storage_isset('required_plugins', 'contact-form-7')) {
			$list[] = array(
					'name' 		=> hogwords_storage_get_array('required_plugins', 'contact-form-7'),
					'slug' 		=> 'contact-form-7',
					'required' 	=> false
				);
		}
		return $list;
	}
}

// Enqueue WooCommerce custom styles
if ( !function_exists( 'hogwords_cf7_frontend_scripts' ) ) {
	
	function hogwords_cf7_frontend_scripts() {
			if (hogwords_is_on(hogwords_get_theme_option('debug_mode')) && hogwords_get_file_dir('plugins/contact-form-7/contact-form-7.js')!='') {
				wp_enqueue_script( 'hogwords-cf7', hogwords_get_file_url('plugins/contact-form-7/contact-form-7.js'), array('jquery'), null, true );
			}
	}
}

// Merge custom scripts
if ( ! function_exists( 'hogwords_cf7_merge_scripts' ) ) {
	function hogwords_cf7_merge_scripts( $list ) {
		$list[] = 'plugins/contact-form-7/contact-form-7.js';
		return $list;
	}
}

// Check if Instagram Feed installed and activated
if ( !function_exists( 'hogwords_exists_cf7' ) ) {
	function hogwords_exists_cf7() {
		return class_exists( 'WPCF7' );
	}
}

?>