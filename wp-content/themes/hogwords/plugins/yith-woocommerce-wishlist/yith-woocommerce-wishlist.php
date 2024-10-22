<?php
/* Yith wcwl wishlist support functions
------------------------------------------------------------------------------- */

// Theme init priorities:
// 9 - register other filters (for installer, etc.)
if (!function_exists('hogwords_yith_wcwl_wishlist_theme_setup9')) {
	add_action( 'after_setup_theme', 'hogwords_yith_wcwl_wishlist_theme_setup9', 9 );
	function hogwords_yith_wcwl_wishlist_theme_setup9() {

		if (is_admin()) {
			add_filter( 'hogwords_filter_tgmpa_required_plugins',			'hogwords_yith_wcwl_wishlist_tgmpa_required_plugins' );
		}
	}
}

// Filter to add in the required plugins list
if ( !function_exists( 'hogwords_yith_wcwl_wishlist_tgmpa_required_plugins' ) ) {
	
	function hogwords_yith_wcwl_wishlist_tgmpa_required_plugins($list=array()) {
		if (hogwords_storage_isset('required_plugins', 'yith-woocommerce-wishlist')) {
			$list[] = array(
					'name' 		=> hogwords_storage_get_array('required_plugins', 'yith-woocommerce-wishlist'),
					'slug' 		=> 'yith-woocommerce-wishlist',
					'required' 	=> false
				);
		}
		return $list;
	}
}

// Check if YITH WooCommerce Wishlist installed and activated
if ( !function_exists( 'hogwords_exists_yith_wcwl_wishlist' ) ) {
	function hogwords_exists_yith_wcwl_wishlist() {
		return class_exists('YITH_WCWL');
	}
}

// Set plugin's specific importer options
if ( !function_exists( 'hogwords_yith_wcwl_wishlist_importer_set_options' ) ) {
	if (is_admin()) add_filter( 'trx_addons_filter_importer_options',	'hogwords_yith_wcwl_wishlist_importer_set_options' );
	function hogwords_yith_wcwl_wishlist_importer_set_options($options=array()) {
		if ( hogwords_exists_yith_wcwl_wishlist() && in_array('yith-woocommerce-wishlist', $options['required_plugins']) ) {
			$options['additional_options'][]	= 'yith_wcwl_%';					// Add slugs to export options for this plugin
			if (is_array($options['files']) && count($options['files']) > 0) {
				foreach ($options['files'] as $k => $v) {
					$options['files'][$k]['file_with_yith_wcwl_wishlist'] = str_replace('name.ext', 'yith-woocommerce-wishlist.txt', $v['file_with_']);
				}
			}
		}
		return $options;
	}
}
?>
