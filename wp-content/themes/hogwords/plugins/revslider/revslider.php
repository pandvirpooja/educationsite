<?php
/* Revolution Slider support functions
------------------------------------------------------------------------------- */

// Theme init priorities:
// 9 - register other filters (for installer, etc.)
if (!function_exists('hogwords_revslider_theme_setup9')) {
	add_action( 'after_setup_theme', 'hogwords_revslider_theme_setup9', 9 );
	function hogwords_revslider_theme_setup9() {
		if (hogwords_exists_revslider()) {
			add_action( 'wp_enqueue_scripts', 					'hogwords_revslider_frontend_scripts', 1100 );
			add_filter( 'hogwords_filter_merge_styles',			'hogwords_revslider_merge_styles' );
		}
		if (is_admin()) {
			add_filter( 'hogwords_filter_tgmpa_required_plugins','hogwords_revslider_tgmpa_required_plugins' );
		}
	}
}

// Filter to add in the required plugins list
if ( !function_exists( 'hogwords_revslider_tgmpa_required_plugins' ) ) {
	
	function hogwords_revslider_tgmpa_required_plugins($list=array()) {
		if (hogwords_storage_isset('required_plugins', 'revslider')) {
			$path = hogwords_get_file_dir('plugins/revslider/revslider.zip');
			if (!empty($path) || hogwords_get_theme_setting('tgmpa_upload')) {
				$list[] = array(
					'name' 		=> hogwords_storage_get_array('required_plugins', 'revslider'),
					'slug' 		=> 'revslider',
					'version'	=> '6.6.16',
					'source'	=> !empty($path) ? $path : 'upload://revslider.zip',
					'required' 	=> false
				);
			}
		}
		return $list;
	}
}

// Check if RevSlider installed and activated
if ( !function_exists( 'hogwords_exists_revslider' ) ) {
	function hogwords_exists_revslider() {
		return function_exists('rev_slider_shortcode');
	}
}
	
// Enqueue custom styles
if ( !function_exists( 'hogwords_revslider_frontend_scripts' ) ) {
	
	function hogwords_revslider_frontend_scripts() {
		if (hogwords_is_on(hogwords_get_theme_option('debug_mode')) && hogwords_get_file_dir('plugins/revslider/revslider.css')!='')
			wp_enqueue_style( 'hogwords-revslider',  hogwords_get_file_url('plugins/revslider/revslider.css'), array(), null );
	}
}
	
// Merge custom styles
if ( !function_exists( 'hogwords_revslider_merge_styles' ) ) {
	
	function hogwords_revslider_merge_styles($list) {
		$list[] = 'plugins/revslider/revslider.css';
		return $list;
	}
}
?>