<?php
/* Instagram Feed support functions
------------------------------------------------------------------------------- */

// Theme init priorities:
// 9 - register other filters (for installer, etc.)
if (!function_exists('hogwords_instagram_feed_theme_setup9')) {
	add_action( 'after_setup_theme', 'hogwords_instagram_feed_theme_setup9', 9 );
	function hogwords_instagram_feed_theme_setup9() {
		if (is_admin()) {
			add_filter( 'hogwords_filter_tgmpa_required_plugins',		'hogwords_instagram_feed_tgmpa_required_plugins' );
		}
	}
}

// Filter to add in the required plugins list
if ( !function_exists( 'hogwords_instagram_feed_tgmpa_required_plugins' ) ) {
	
	function hogwords_instagram_feed_tgmpa_required_plugins($list=array()) {
		if (hogwords_storage_isset('required_plugins', 'instagram-feed')) {
			$list[] = array(
					'name' 		=> hogwords_storage_get_array('required_plugins', 'instagram-feed'),
					'slug' 		=> 'instagram-feed',
					'required' 	=> false
				);
		}
		return $list;
	}
}

// Check if Instagram Feed installed and activated
if ( !function_exists( 'hogwords_exists_instagram_feed' ) ) {
	function hogwords_exists_instagram_feed() {
		return defined('SBIVER');
	}
}
?>