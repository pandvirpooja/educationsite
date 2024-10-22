<?php
/* ThemeREX Socials support functions
------------------------------------------------------------------------------- */

// Theme init priorities:
// 9 - register other filters (for installer, etc.)
if ( ! function_exists( 'hogwords_trx_socials_theme_setup9' ) ) {
	add_action( 'after_setup_theme', 'hogwords_trx_socials_theme_setup9', 9 );
	function hogwords_trx_socials_theme_setup9() {
		if ( is_admin() ) {
			add_filter( 'hogwords_filter_tgmpa_required_plugins', 'hogwords_trx_socials_tgmpa_required_plugins' );
		}
	}
}


// Filter to add in the required plugins list
if ( ! function_exists( 'hogwords_trx_socials_tgmpa_required_plugins' ) ) {
	function hogwords_trx_socials_tgmpa_required_plugins( $list = array()) {
		if (hogwords_storage_isset('required_plugins', 'trx_socials')) {
			$path = hogwords_get_file_dir('plugins/trx_socials/trx_socials.zip');
			$list[] = array(
				'name'     => esc_html__( 'ThemeREX Socials', 'hogwords' ),
				'slug'     => 'trx_socials',
				'version'  => '1.4.5',
				'source'   => ! empty( $path ) ? $path : 'upload://trx_socials.zip',
				'required' => false,
			);
		}
		return $list;
	}
}

// Check if plugin installed and activated
if ( !function_exists( 'hogwords_exists_trx_socials' ) ) {
    function hogwords_exists_trx_socials() {
        return function_exists( 'trx_socials_load_plugin_textdomain' );
    }
}
