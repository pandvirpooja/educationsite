<?php
/* Tribe Events Calendar support functions
------------------------------------------------------------------------------- */

// Theme init priorities:
// 1 - register filters, that add/remove lists items for the Theme Options
if (!function_exists('hogwords_tribe_events_theme_setup1')) {
	add_action( 'after_setup_theme', 'hogwords_tribe_events_theme_setup1', 1 );
	function hogwords_tribe_events_theme_setup1() {
		add_filter( 'hogwords_filter_list_sidebars', 'hogwords_tribe_events_list_sidebars' );
	}
}

// Theme init priorities:
// 3 - add/remove Theme Options elements
if (!function_exists('hogwords_tribe_events_theme_setup3')) {
	add_action( 'after_setup_theme', 'hogwords_tribe_events_theme_setup3', 3 );
	function hogwords_tribe_events_theme_setup3() {
		if (hogwords_exists_tribe_events()) {
		
			// Section 'Tribe Events'
			hogwords_storage_merge_array('options', '', array_merge(
				array(
					'events' => array(
						"title" => esc_html__('Events', 'hogwords'),
						"desc" => wp_kses_data( __('Select parameters to display the events pages', 'hogwords') ),
						"type" => "section"
						)
				),
				hogwords_options_get_list_cpt_options('events')
			));
		}
	}
}

// Theme init priorities:
// 9 - register other filters (for installer, etc.)
if (!function_exists('hogwords_tribe_events_theme_setup9')) {
	add_action( 'after_setup_theme', 'hogwords_tribe_events_theme_setup9', 9 );
	function hogwords_tribe_events_theme_setup9() {
		
		if (hogwords_exists_tribe_events()) {
			add_action( 'wp_enqueue_scripts', 								'hogwords_tribe_events_frontend_scripts', 1100 );
			add_filter( 'hogwords_filter_merge_styles',						'hogwords_tribe_events_merge_styles' );
			add_filter( 'hogwords_filter_post_type_taxonomy',				'hogwords_tribe_events_post_type_taxonomy', 10, 2 );
			if (!is_admin()) {
				add_filter( 'hogwords_filter_detect_blog_mode',				'hogwords_tribe_events_detect_blog_mode' );
				add_filter( 'hogwords_filter_get_post_categories', 			'hogwords_tribe_events_get_post_categories');
				add_filter( 'hogwords_filter_get_post_date',		 			'hogwords_tribe_events_get_post_date');
			}
		}
		if (is_admin()) {
			add_filter( 'hogwords_filter_tgmpa_required_plugins',			'hogwords_tribe_events_tgmpa_required_plugins' );
		}

	}
}

// Filter to add in the required plugins list
if ( !function_exists( 'hogwords_tribe_events_tgmpa_required_plugins' ) ) {
	
	function hogwords_tribe_events_tgmpa_required_plugins($list=array()) {
		if (hogwords_storage_isset('required_plugins', 'the-events-calendar')) {
			$list[] = array(
					'name' 		=> hogwords_storage_get_array('required_plugins', 'the-events-calendar'),
					'slug' 		=> 'the-events-calendar',
					'required' 	=> false
				);
		}
		return $list;
	}
}


// Remove 'Tribe Events' section from Customizer
if (!function_exists('hogwords_tribe_events_customizer_register_controls')) {
	add_action( 'customize_register', 'hogwords_tribe_events_customizer_register_controls', 100 );
	function hogwords_tribe_events_customizer_register_controls( $wp_customize ) {
		$wp_customize->remove_panel( 'tribe_customizer');
	}
}


// Check if Tribe Events is installed and activated
if ( !function_exists( 'hogwords_exists_tribe_events' ) ) {
	function hogwords_exists_tribe_events() {
		return class_exists( 'Tribe__Events__Main' );
	}
}

// Return true, if current page is any tribe_events page
if ( !function_exists( 'hogwords_is_tribe_events_page' ) ) {
	function hogwords_is_tribe_events_page() {
		$rez = false;
		if (hogwords_exists_tribe_events())
			if (!is_search()) $rez = tribe_is_event() || tribe_is_event_query() || tribe_is_event_category() || tribe_is_event_venue() || tribe_is_event_organizer();
		return $rez;
	}
}

// Detect current blog mode
if ( !function_exists( 'hogwords_tribe_events_detect_blog_mode' ) ) {
	
	function hogwords_tribe_events_detect_blog_mode($mode='') {
		if (hogwords_is_tribe_events_page())
			$mode = 'events';
		return $mode;
	}
}

// Return taxonomy for current post type
if ( !function_exists( 'hogwords_tribe_events_post_type_taxonomy' ) ) {
	
	function hogwords_tribe_events_post_type_taxonomy($tax='', $post_type='') {
		if (hogwords_exists_tribe_events() && $post_type == Tribe__Events__Main::POSTTYPE)
			$tax = Tribe__Events__Main::TAXONOMY;
		return $tax;
	}
}

// Show categories of the current event
if ( !function_exists( 'hogwords_tribe_events_get_post_categories' ) ) {
	
	function hogwords_tribe_events_get_post_categories($cats='') {
		if (get_post_type() == Tribe__Events__Main::POSTTYPE)
			$cats = hogwords_get_post_terms(', ', get_the_ID(), Tribe__Events__Main::TAXONOMY);
		return $cats;
	}
}

// Return date of the current event
if ( !function_exists( 'hogwords_tribe_events_get_post_date' ) ) {
	
	function hogwords_tribe_events_get_post_date($dt='') {
		if (get_post_type() == Tribe__Events__Main::POSTTYPE) {
			$dt = tribe_events_event_schedule_details( get_the_ID(), '', '' );
		}
		return $dt;
	}
}

// Enqueue Tribe Events custom scripts and styles
if ( !function_exists( 'hogwords_tribe_events_frontend_scripts' ) ) {
	
	function hogwords_tribe_events_frontend_scripts() {
		if (hogwords_is_tribe_events_page()) {
			if (hogwords_is_on(hogwords_get_theme_option('debug_mode')) && hogwords_get_file_dir('plugins/the-events-calendar/the-events-calendar.css')!='')
				wp_enqueue_style( 'hogwords-the-events-calendar',  hogwords_get_file_url('plugins/the-events-calendar/the-events-calendar.css'), array(), null );
			if (hogwords_is_on(hogwords_get_theme_option('debug_mode')) && hogwords_get_file_dir('css/the-events-calendar.css')!='')
				wp_enqueue_style( 'hogwords-the-events-calendar-images',  hogwords_get_file_url('css/the-events-calendar.css'), array(), null );
		}
	}
}

// Merge custom styles
if ( !function_exists( 'hogwords_tribe_events_merge_styles' ) ) {
	
	function hogwords_tribe_events_merge_styles($list) {
		$list[] = 'plugins/the-events-calendar/the-events-calendar.css';
		$list[] = 'css/the-events-calendar.css';
		return $list;
	}
}



// Add Tribe Events specific items into lists
//------------------------------------------------------------------------

// Add sidebar
if ( !function_exists( 'hogwords_tribe_events_list_sidebars' ) ) {
	
	function hogwords_tribe_events_list_sidebars($list=array()) {
		$list['tribe_events_widgets'] = array(
											'name' => esc_html__('Tribe Events Widgets', 'hogwords'),
											'description' => esc_html__('Widgets to be shown on the Tribe Events pages', 'hogwords')
											);
		return $list;
	}
}


// Add plugin-specific colors and fonts to the custom CSS
if (hogwords_exists_tribe_events()) { require_once HOGWORDS_THEME_DIR . 'plugins/the-events-calendar/the-events-calendar.styles.php'; }
?>