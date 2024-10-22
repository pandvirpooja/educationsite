<?php
/* Essential Grid support functions
------------------------------------------------------------------------------- */


// Theme init priorities:
// 9 - register other filters (for installer, etc.)
if (!function_exists('hogwords_essential_grid_theme_setup9')) {
	add_action( 'after_setup_theme', 'hogwords_essential_grid_theme_setup9', 9 );
	function hogwords_essential_grid_theme_setup9() {
		if (hogwords_exists_essential_grid()) {
			add_action( 'wp_enqueue_scripts', 							'hogwords_essential_grid_frontend_scripts', 1100 );
			add_filter( 'hogwords_filter_merge_styles',					'hogwords_essential_grid_merge_styles' );
		}
		if (is_admin()) {
			add_filter( 'hogwords_filter_tgmpa_required_plugins',		'hogwords_essential_grid_tgmpa_required_plugins' );
		}
	}
}

// Filter to add in the required plugins list
if ( !function_exists( 'hogwords_essential_grid_tgmpa_required_plugins' ) ) {
	
	function hogwords_essential_grid_tgmpa_required_plugins($list=array()) {
		if (hogwords_storage_isset('required_plugins', 'essential-grid')) {
			$path = hogwords_get_file_dir('plugins/essential-grid/essential-grid.zip');
			if (!empty($path) || hogwords_get_theme_setting('tgmpa_upload')) {
				$list[] = array(
						'name' 		=> hogwords_storage_get_array('required_plugins', 'essential-grid'),
						'slug' 		=> 'essential-grid',
                        'version'	=> '3.0.19',
						'source'	=> !empty($path) ? $path : 'upload://essential-grid.zip',
						'required' 	=> false
				);
			}
		}
		return $list;
	}
}

// Check if plugin installed and activated
if ( !function_exists( 'hogwords_exists_essential_grid' ) ) {
	function hogwords_exists_essential_grid() {
		return defined('EG_PLUGIN_PATH') || defined( 'ESG_PLUGIN_PATH' );
	}
}
	
// Enqueue plugin's custom styles
if ( !function_exists( 'hogwords_essential_grid_frontend_scripts' ) ) {
	
	function hogwords_essential_grid_frontend_scripts() {
		if (hogwords_is_on(hogwords_get_theme_option('debug_mode')) && hogwords_get_file_dir('plugins/essential-grid/essential-grid.css')!='')
			wp_enqueue_style( 'hogwords-essential-grid',  hogwords_get_file_url('plugins/essential-grid/essential-grid.css'), array(), null );
	}
}
	
// Merge custom styles
if ( !function_exists( 'hogwords_essential_grid_merge_styles' ) ) {
	
	function hogwords_essential_grid_merge_styles($list) {
		$list[] = 'plugins/essential-grid/essential-grid.css';
		return $list;
	}
}
?>