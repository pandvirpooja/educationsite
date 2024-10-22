<?php
/**
 * Setup theme-specific fonts and colors
 *
 * @package WordPress
 * @subpackage HOGWORDS
 * @since HOGWORDS 1.0.22
 */

if (!defined("HOGWORDS_THEME_FREE")) define("HOGWORDS_THEME_FREE", false);
if (!defined("HOGWORDS_THEME_FREE_WP")) define("HOGWORDS_THEME_FREE_WP", false);

// Theme storage
$HOGWORDS_STORAGE = array(
	// Theme required plugin's slugs
	'required_plugins' => array_merge(

		// List of plugins for both - FREE and PREMIUM versions
		//-----------------------------------------------------
		array(
			// Required plugins
			// DON'T COMMENT OR REMOVE NEXT LINES!
			'trx_addons'					=> esc_html__('ThemeREX Addons', 'hogwords'),
			
			// Recommended (supported) plugins fot both (lite and full) versions
			// If plugin not need - comment (or remove) it

			'woocommerce'					=> esc_html__('WooCommerce', 'hogwords'),
			'yith-woocommerce-compare'		=> esc_html__('YITH WooCommerce Compare', 'hogwords'),
			'yith-woocommerce-wishlist'		=> esc_html__('YITH WooCommerce Wishlist', 'hogwords'),
			'elegro-payment'				=> esc_html__('elegro Crypto Payment', 'hogwords'),
			'contact-form-7'				=> esc_html__('Contact Form 7', 'hogwords'),
			'trx_updater'				    => esc_html__('ThemeREX Updater', 'hogwords'),
			'instagram-feed'				=> esc_html__('Instagram Feed', 'hogwords'),
		),

		// List of plugins for PREMIUM version only
		//-----------------------------------------------------
		HOGWORDS_THEME_FREE ? array() : array(
					// Recommended (supported) plugins for the PRO (full) version
					// If plugin not need - comment (or remove) it

					'essential-grid'			=> esc_html__('Essential Grid', 'hogwords'),
					'revslider'					=> esc_html__('Revolution Slider', 'hogwords'),
					'the-events-calendar'		=> esc_html__('The Events Calendar', 'hogwords'),
					'js_composer'				=> esc_html__('WPBakery Page Builder', 'hogwords'),

				)
	),
	
	// Theme-specific URLs (will be escaped in place of the output)
	'theme_demo_url'	=> '//hogwords.axiomthemes.com',
	'theme_doc_url'		=> '//hogwords.axiomthemes.com/doc',
    'theme_download_url'=> 'https://1.envato.market/c/1262870/275988/4415?subId1=axiom&u=themeforest.net/item/hogwords-education-center-wordpress-theme/21376785',

	'theme_support_url'	=> '//themerex.net/support',									// Axiom

	'theme_video_url'	=> 'https://www.youtube.com/channel/UCBjqhuwKj3MfE3B6Hg2oA8Q',	// Axiom
);

// Theme init priorities:
// Action 'after_setup_theme'
// 1 - register filters to add/remove lists items in the Theme Options
// 2 - create Theme Options
// 3 - add/remove Theme Options elements
// 5 - load Theme Options. Attention! After this step you can use only basic options (not overriden)
// 9 - register other filters (for installer, etc.)
//10 - standard Theme init procedures (not ordered)
// Action 'wp_loaded'
// 1 - detect override mode. Attention! Only after this step you can use overriden options (separate values for the shop, courses, etc.)

if ( !function_exists('hogwords_customizer_theme_setup1') ) {
	add_action( 'after_setup_theme', 'hogwords_customizer_theme_setup1', 1 );
	function hogwords_customizer_theme_setup1() {

		// -----------------------------------------------------------------
		// -- ONLY FOR PROGRAMMERS, NOT FOR CUSTOMER
		// -- Internal theme settings
		// -----------------------------------------------------------------
		hogwords_storage_set('settings', array(
			
			'duplicate_options'		=> 'child',		// none  - use separate options for template and child-theme
													// child - duplicate theme options from the main theme to the child-theme only
													// both  - sinchronize changes in the theme options between main and child themes
			
			'custmize_refresh'		=> 'auto',		// Refresh method for preview area in the Appearance - Customize:
													// auto - refresh preview area on change each field with Theme Options
													// manual - refresh only obn press button 'Refresh' at the top of Customize frame
		
			'max_load_fonts'		=> 5,			// Max fonts number to load from Google fonts or from uploaded fonts
		
			'comment_maxlength'		=> 1000,		// Max length of the message from contact form

			'comment_after_name'	=> true,		// Place 'comment' field before the 'name' and 'email'
			
			'socials_type'			=> 'icons',		// Type of socials:
													// icons - use font icons to present social networks
													// images - use images from theme's folder trx_addons/css/icons.png
			
			'icons_type'			=> 'icons',		// Type of other icons:
													// icons - use font icons to present icons
													// images - use images from theme's folder trx_addons/css/icons.png
			
			'icons_selector'		=> 'internal',	// Icons selector in the shortcodes:

													// internal - internal popup with plugin's or theme's icons list (fast)
			'check_min_version'		=> true,		// Check if exists a .min version of .css and .js and return path to it
													// instead the path to the original file
													// (if debug_mode is off and modification time of the original file < time of the .min file)
			'autoselect_menu'		=> true,		// Show any menu if no menu selected in the location 'main_menu'
													// (for example, the theme is just activated)
			'disable_jquery_ui'		=> false,		// Prevent loading custom jQuery UI libraries in the third-party plugins
		
			'use_mediaelements'		=> true,		// Load script "Media Elements" to play video and audio
			
			'tgmpa_upload'			=> false		// Allow upload not pre-packaged plugins via TGMPA
		));


		// -----------------------------------------------------------------
		// -- Theme fonts (Google and/or custom fonts)
		// -----------------------------------------------------------------
		
		// Fonts to load when theme start
		// It can be Google fonts or uploaded fonts, placed in the folder /css/font-face/font-name inside the theme folder
		// Attention! Font's folder must have name equal to the font's name, with spaces replaced on the dash '-'
		
		hogwords_storage_set('load_fonts', array(
			// Google font
			array(
				'name'	 => 'Open Sans',
				'family' => 'sans-serif',
				'styles' => '300,400,600,700,800'		// Parameter 'style' used only for the Google fonts
				),
			array(
				'name'	 => 'Montserrat',
				'family' => 'sans-serif',
				'styles' => '300,400,500,600,700,800,900'		// Parameter 'style' used only for the Google fonts
			),
			array(
				'name'	 => 'Love Ya Like A Sister',
				'family' => 'cursive',
				'styles' => '400'		// Parameter 'style' used only for the Google fonts
			),

		));
		
		// Characters subset for the Google fonts. Available values are: latin,latin-ext,cyrillic,cyrillic-ext,greek,greek-ext,vietnamese
		hogwords_storage_set('load_fonts_subset', 'latin,latin-ext');
		
		// Settings of the main tags
		hogwords_storage_set('theme_fonts', array(
			'p' => array(
				'title'				=> esc_html__('Main text', 'hogwords'),
				'description'		=> esc_html__('Font settings of the main text of the site', 'hogwords'),
				'font-family'		=> '"Open Sans",sans-serif',
				'font-size' 		=> '1rem',
				'font-weight'		=> '400',
				'font-style'		=> 'normal',
				'line-height'		=> '1.5em',
				'text-decoration'	=> 'none',
				'text-transform'	=> 'none',
				'letter-spacing'	=> '-0.18px',
				'margin-top'		=> '0em',
				'margin-bottom'		=> '1.87em'
				),
			'h1' => array(
				'title'				=> esc_html__('Heading 1', 'hogwords'),
				'font-family'		=> '"Open Sans",sans-serif',
				'font-size' 		=> '3em',
				'font-weight'		=> '600',
				'font-style'		=> 'normal',
				'line-height'		=> '1.25em',
				'text-decoration'	=> 'none',
				'text-transform'	=> 'none',
				'letter-spacing'	=> '-0.5px',
				'margin-top'		=> '1.15em',
				'margin-bottom'		=> '0.5em'
				),
			'h2' => array(
				'title'				=> esc_html__('Heading 2', 'hogwords'),
				'font-family'		=> '"Open Sans",sans-serif',
				'font-size' 		=> '2.5em',
				'font-weight'		=> '600',
				'font-style'		=> 'normal',
				'line-height'		=> '1.2em',
				'text-decoration'	=> 'none',
				'text-transform'	=> 'none',
				'letter-spacing'	=> '-0.38px',
				'margin-top'		=> '0.96em',
				'margin-bottom'		=> '0.56em'
				),
			'h3' => array(
				'title'				=> esc_html__('Heading 3', 'hogwords'),
				'font-family'		=> '"Open Sans",sans-serif',
				'font-size' 		=> '2em',
				'font-weight'		=> '600',
				'font-style'		=> 'normal',
				'line-height'		=> '1.22em',
				'text-decoration'	=> 'none',
				'text-transform'	=> 'none',
				'letter-spacing'	=> '-0.02px',
				'margin-top'		=> '1.1em',
				'margin-bottom'		=> '0.6em'
				),
			'h4' => array(
				'title'				=> esc_html__('Heading 4', 'hogwords'),
				'font-family'		=> '"Open Sans",sans-serif',
				'font-size' 		=> '1.5em',
				'font-weight'		=> '600',
				'font-style'		=> 'normal',
				'line-height'		=> '1.25em',
				'text-decoration'	=> 'none',
				'text-transform'	=> 'none',
				'letter-spacing'	=> '0em',
				'margin-top'		=> '0em',
				'margin-bottom'		=> '0.65em'
				),
			'h5' => array(
				'title'				=> esc_html__('Heading 5', 'hogwords'),
				'font-family'		=> '"Open Sans",sans-serif',
				'font-size' 		=> '1.125em',
				'font-weight'		=> '800',
				'font-style'		=> 'normal',
				'line-height'		=> '1.39em',
				'text-decoration'	=> 'none',
				'text-transform'	=> 'none',
				'letter-spacing'	=> '-0.18px',
				'margin-top'		=> '1.5em',
				'margin-bottom'		=> '0.85em'
				),
			'h6' => array(
				'title'				=> esc_html__('Heading 6', 'hogwords'),
				'font-family'		=> '"Open Sans",sans-serif',
				'font-size' 		=> '1em',
				'font-weight'		=> '700',
				'font-style'		=> 'normal',
				'line-height'		=> '1.5em',
				'text-decoration'	=> 'none',
				'text-transform'	=> 'none',
				'letter-spacing'	=> '0px',
				'margin-top'		=> '1.87em',
				'margin-bottom'		=> '0.6em'
				),
			'logo' => array(
				'title'				=> esc_html__('Logo text', 'hogwords'),
				'description'		=> esc_html__('Font settings of the text case of the logo', 'hogwords'),
				'font-family'		=> '"Love Ya Like A Sister",cursive',
				'font-size' 		=> '1.8em',
				'font-weight'		=> '700',
				'font-style'		=> 'normal',
				'line-height'		=> '1.25em',
				'text-decoration'	=> 'none',
				'text-transform'	=> 'uppercase',
				'letter-spacing'	=> '1px'
				),
			'button' => array(
				'title'				=> esc_html__('Buttons', 'hogwords'),
				'font-family'		=> '"Montserrat",sans-serif',
				'font-size' 		=> '14px',
				'font-weight'		=> '700',
				'font-style'		=> 'normal',
				'line-height'		=> '2.14em',
				'text-decoration'	=> 'none',
				'text-transform'	=> 'uppercase',
				'letter-spacing'	=> '-0.3px'
				),
			'input' => array(
				'title'				=> esc_html__('Input fields', 'hogwords'),
				'description'		=> esc_html__('Font settings of the input fields, dropdowns and textareas', 'hogwords'),
				'font-family'		=> '"Open Sans",sans-serif',
				'font-size' 		=> '1em',
				'font-weight'		=> '400',
				'font-style'		=> 'normal',
				'line-height'		=> '1.75em',	// Attention! Firefox don't allow line-height less then 1.5em in the select
				'text-decoration'	=> 'none',
				'text-transform'	=> 'none',
				'letter-spacing'	=> '0px'
				),
			'info' => array(
				'title'				=> esc_html__('Post meta', 'hogwords'),
				'description'		=> esc_html__('Font settings of the post meta: date, counters, share, etc.', 'hogwords'),
				'font-family'		=> 'inherit',
				'font-size' 		=> '14px',
				'font-weight'		=> '600',
				'font-style'		=> 'normal',
				'line-height'		=> '1.5em',
				'text-decoration'	=> 'none',
				'text-transform'	=> 'none',
				'letter-spacing'	=> '0px',
				'margin-top'		=> '0.4em',
				'margin-bottom'		=> ''
				),
			'menu' => array(
				'title'				=> esc_html__('Main menu', 'hogwords'),
				'description'		=> esc_html__('Font settings of the main menu items', 'hogwords'),
				'font-family'		=> '"Open Sans",sans-serif',
				'font-size' 		=> '16px',
				'font-weight'		=> '700',
				'font-style'		=> 'normal',
				'line-height'		=> '1.5em',
				'text-decoration'	=> 'none',
				'text-transform'	=> 'none',
				'letter-spacing'	=> '0px'
				),
			'submenu' => array(
				'title'				=> esc_html__('Dropdown menu', 'hogwords'),
				'description'		=> esc_html__('Font settings of the dropdown menu items', 'hogwords'),
				'font-family'		=> '"Open Sans",sans-serif',
				'font-size' 		=> '14px',
				'font-weight'		=> '700',
				'font-style'		=> 'normal',
				'line-height'		=> '1.5em',
				'text-decoration'	=> 'none',
				'text-transform'	=> 'none',
				'letter-spacing'	=> '0px'
				)
		));
		
		
		// -----------------------------------------------------------------
		// -- Theme colors for customizer
		// -- Attention! Inner scheme must be last in the array below
		// -----------------------------------------------------------------
		hogwords_storage_set('scheme_color_groups', array(
			'main'	=> array(
							'title'			=> esc_html__('Main', 'hogwords'),
							'description'	=> esc_html__('Colors of the main content area', 'hogwords')
							),
			'alter'	=> array(
							'title'			=> esc_html__('Alter', 'hogwords'),
							'description'	=> esc_html__('Colors of the alternative blocks (sidebars, etc.)', 'hogwords')
							),
			'extra'	=> array(
							'title'			=> esc_html__('Extra', 'hogwords'),
							'description'	=> esc_html__('Colors of the extra blocks (dropdowns, price blocks, table headers, etc.)', 'hogwords')
							),
			'inverse' => array(
							'title'			=> esc_html__('Inverse', 'hogwords'),
							'description'	=> esc_html__('Colors of the inverse blocks - when link color used as background of the block (dropdowns, blockquotes, etc.)', 'hogwords')
							),
			'input'	=> array(
							'title'			=> esc_html__('Input', 'hogwords'),
							'description'	=> esc_html__('Colors of the form fields (text field, textarea, select, etc.)', 'hogwords')
							),
			)
		);
		hogwords_storage_set('scheme_color_names', array(
			'bg_color'	=> array(
							'title'			=> esc_html__('Background color', 'hogwords'),
							'description'	=> esc_html__('Background color of this block in the normal state', 'hogwords')
							),
			'bg_hover'	=> array(
							'title'			=> esc_html__('Background hover', 'hogwords'),
							'description'	=> esc_html__('Background color of this block in the hovered state', 'hogwords')
							),
			'bd_color'	=> array(
							'title'			=> esc_html__('Border color', 'hogwords'),
							'description'	=> esc_html__('Border color of this block in the normal state', 'hogwords')
							),
			'bd_hover'	=>  array(
							'title'			=> esc_html__('Border hover', 'hogwords'),
							'description'	=> esc_html__('Border color of this block in the hovered state', 'hogwords')
							),
			'text'		=> array(
							'title'			=> esc_html__('Text', 'hogwords'),
							'description'	=> esc_html__('Color of the plain text inside this block', 'hogwords')
							),
			'text_dark'	=> array(
							'title'			=> esc_html__('Text dark', 'hogwords'),
							'description'	=> esc_html__('Color of the dark text (bold, header, etc.) inside this block', 'hogwords')
							),
			'text_light'=> array(
							'title'			=> esc_html__('Text light', 'hogwords'),
							'description'	=> esc_html__('Color of the light text (post meta, etc.) inside this block', 'hogwords')
							),
			'text_link'	=> array(
							'title'			=> esc_html__('Link', 'hogwords'),
							'description'	=> esc_html__('Color of the links inside this block', 'hogwords')
							),
			'text_hover'=> array(
							'title'			=> esc_html__('Link hover', 'hogwords'),
							'description'	=> esc_html__('Color of the hovered state of links inside this block', 'hogwords')
							),
			'text_link2'=> array(
							'title'			=> esc_html__('Link 2', 'hogwords'),
							'description'	=> esc_html__('Color of the accented texts (areas) inside this block', 'hogwords')
							),
			'text_hover2'=> array(
							'title'			=> esc_html__('Link 2 hover', 'hogwords'),
							'description'	=> esc_html__('Color of the hovered state of accented texts (areas) inside this block', 'hogwords')
							),
			'text_link3'=> array(
							'title'			=> esc_html__('Link 3', 'hogwords'),
							'description'	=> esc_html__('Color of the other accented texts (buttons) inside this block', 'hogwords')
							),
			'text_hover3'=> array(
							'title'			=> esc_html__('Link 3 hover', 'hogwords'),
							'description'	=> esc_html__('Color of the hovered state of other accented texts (buttons) inside this block', 'hogwords')
							),
		'text_menu'=> array(
							'title'			=> esc_html__('Text menu', 'hogwords'),
							'description'	=> esc_html__('Color for text of menu', 'hogwords')
							)

			)
		);
		hogwords_storage_set('schemes', array(
		
			// Color scheme: 'default'
			'default' => array(
				'title'	 => esc_html__('Default', 'hogwords'),
				'colors' => array(
					
					// Whole block border and background
					'bg_color'			=> '#ffffff',//+
					'bd_color'			=> '#f6f6f6',//+
		
					// Text and links colors
					'text'				=> '#727272',//+
					'text_light'		=> '#adadad',//+
					'text_dark'			=> '#252525',//+
					'text_link'			=> '#66bc4c',//+
					'text_hover'		=> '#ffc000',//+
					'text_link2'		=> '#f46400',//+
					'text_hover2'		=> '#ffc000',//+
					'text_link3'		=> '#ddb837',
					'text_hover3'		=> '#eec432',
					'text_menu'		    => '#252525',//+
		
					// Alternative blocks (sidebar, tabs, alternative blocks, etc.)
					'alter_bg_color'	=> '#f9f9f9',//+
					'alter_bg_hover'	=> '#f6f6f6',//+
					'alter_bd_color'	=> '#ededed',//+
					'alter_bd_hover'	=> '#dadada',
					'alter_text'		=> '#727272',//+
					'alter_light'		=> '#66bc4c',//+
					'alter_dark'		=> '#252525',//+
					'alter_link'		=> '#66bc4c',//+
					'alter_hover'		=> '#ffc000',//+
					'alter_link2'		=> '#8be77c',
					'alter_hover2'		=> '#80d572',
					'alter_link3'		=> '#eec432',
					'alter_hover3'		=> '#ddb837',
		
					// Extra blocks (submenu, tabs, color blocks, etc.)
					'extra_bg_color'	=> '#f46400',//+
					'extra_bg_hover'	=> '#28272e',
					'extra_bd_color'	=> '#ffffff',//+
					'extra_bd_hover'	=> '#3d3d3d',
					'extra_text'		=> '#ffffff',//+
					'extra_light'		=> '#afafaf',//+
					'extra_dark'		=> '#ffffff',//+
					'extra_link'		=> '#fff200',//+
					'extra_hover'		=> '#fe7259',
					'extra_link2'		=> '#80d572',
					'extra_hover2'		=> '#8be77c',
					'extra_link3'		=> '#ddb837',
					'extra_hover3'		=> '#eec432',
		
					// Input fields (form's fields and textarea)
					'input_bg_color'	=> '#ffffff',//+
					'input_bg_hover'	=> '#ffffff',//+
					'input_bd_color'	=> '#e7eaed',
					'input_bd_hover'	=> '#0b3d6c',//+
					'input_text'		=> '#adadad',//+
					'input_light'		=> '#a7a7a7',
					'input_dark'		=> '#0b3d6c',//+
					
					// Inverse blocks (text and links on the 'text_link' background)
					'inverse_bd_color'	=> '#67bcc1',
					'inverse_bd_hover'	=> '#5aa4a9',
					'inverse_text'		=> '#ffffff',//+
					'inverse_light'		=> '#333333',
					'inverse_dark'		=> '#1d1d1d',//+
					'inverse_link'		=> '#fff200',//+
					'inverse_hover'		=> '#0b3d6c'//+
				)
			),
		
			// Color scheme: 'dark'
			'dark' => array(
				'title'  => esc_html__('Dark', 'hogwords'),
				'colors' => array(
					
					// Whole block border and background
					'bg_color'			=> '#252525',//+
					'bd_color'			=> '#333333',//+
		
					// Text and links colors
					'text'				=> '#ffffff',//+
					'text_light'		=> '#7a7a7a',//+
					'text_dark'			=> '#ffffff',//+
					'text_link'			=> '#66bc4c',//+
					'text_hover'		=> '#ffc000',//+
					'text_link2'		=> '#f46400',//+
					'text_hover2'		=> '#ffc000',//+
					'text_link3'		=> '#ddb837',
					'text_hover3'		=> '#eec432',
					'text_menu'		    => '#252525',//+

					// Alternative blocks (sidebar, tabs, alternative blocks, etc.)
					'alter_bg_color'	=> '#202020',//+
					'alter_bg_hover'	=> '#1a1a1a',//+
					'alter_bd_color'	=> '#333333',//+
					'alter_bd_hover'	=> '#4a4a4a',
					'alter_text'		=> '#d9d9d9',//+
					'alter_light'		=> '#7a7a7a',//+
					'alter_dark'		=> '#ffffff',//+
					'alter_link'		=> '#66bc4c',//+
					'alter_hover'		=> '#ffc000',//+
					'alter_link2'		=> '#8be77c',
					'alter_hover2'		=> '#80d572',
					'alter_link3'		=> '#eec432',
					'alter_hover3'		=> '#ddb837',

					// Extra blocks (submenu, tabs, color blocks, etc.)
					'extra_bg_color'	=> '#ffc000',//+
					'extra_bg_hover'	=> '#f3f5f7',//+
					'extra_bd_color'	=> '#ffffff',//+
					'extra_bd_hover'	=> '#f6f6f6',//+
					'extra_text'		=> '#ffffff',//+
					'extra_light'		=> '#b7b7b7',//+
					'extra_dark'		=> '#ffffff',//+
					'extra_link'		=> '#0b3d6c',//+
					'extra_hover'		=> '#fe7259',
					'extra_link2'		=> '#80d572',
					'extra_hover2'		=> '#8be77c',
					'extra_link3'		=> '#ddb837',
					'extra_hover3'		=> '#eec432',

					// Input fields (form's fields and textarea)
					'input_bg_color'	=> '#252525',//+
					'input_bg_hover'	=> '#252525',//+
					'input_bd_color'	=> '#2e2d32',
					'input_bd_hover'	=> '#ffc000',//+
					'input_text'		=> '#adadad',//+
					'input_light'		=> '#252525',//+
					'input_dark'		=> '#ffffff',//+
					
					// Inverse blocks (text and links on the 'text_link' background)
					'inverse_bd_color'	=> '#e36650',
					'inverse_bd_hover'	=> '#cb5b47',
					'inverse_text'		=> '#ffffff',//+
					'inverse_light'		=> '#5f5f5f',
					'inverse_dark'		=> '#1d1d1d',//+
					'inverse_link'		=> '#fff200',//+
					'inverse_hover'		=> '#0b3d6c'//+
				)
			)
		
		));
		
		// Simple schemes substitution
		hogwords_storage_set('schemes_simple', array(
			// Main color	// Slave elements and it's darkness koef.
			'text_link'		=> array('alter_hover' => 1,	'extra_link' => 1, 'inverse_bd_color' => 0.85, 'inverse_bd_hover' => 0.7),
			'text_hover'	=> array('alter_link' => 1,		'extra_hover' => 1),
			'text_link2'	=> array('alter_hover2' => 1,	'extra_link2' => 1),
			'text_hover2'	=> array('alter_link2' => 1,	'extra_hover2' => 1),
			'text_link3'	=> array('alter_hover3' => 1,	'extra_link3' => 1),
			'text_hover3'	=> array('alter_link3' => 1,	'extra_hover3' => 1)
		));

		// Additional colors for each scheme
		// Parameters:	'color' - name of the color from the scheme that should be used as source for the transformation
		//				'alpha' - to make color transparent (0.0 - 1.0)
		//				'hue', 'saturation', 'brightness' - inc/dec value for each color's component
		hogwords_storage_set('scheme_colors_add', array(
			'bg_color_0'		=> array('color' => 'bg_color',			'alpha' => 0),
			'bg_color_02'		=> array('color' => 'bg_color',			'alpha' => 0.2),
			'bg_color_07'		=> array('color' => 'bg_color',			'alpha' => 0.7),
			'bg_color_08'		=> array('color' => 'bg_color',			'alpha' => 0.8),
			'bg_color_09'		=> array('color' => 'bg_color',			'alpha' =>  0.9),
			'alter_bg_color_07'	=> array('color' => 'alter_bg_color',	'alpha' => 0.7),
			'alter_bg_color_04'	=> array('color' => 'alter_bg_color',	'alpha' => 0.4),
			'alter_bg_color_02'	=> array('color' => 'alter_bg_color',	'alpha' => 0.2),
			'alter_bd_color_02'	=> array('color' => 'alter_bd_color',	'alpha' => 0.2),
			'extra_bg_color_07'	=> array('color' => 'extra_bg_color',	'alpha' => 0.7),
			'text_dark_07'		=> array('color' => 'text_dark',		'alpha' => 0.7),
			'text_link_02'		=> array('color' => 'text_link',		'alpha' => 0.2),
			'text_link_07'		=> array('color' => 'text_link',		'alpha' => 0.7),
			'text_link_blend'	=> array('color' => 'text_link',		'hue' => 2, 'saturation' => -5, 'brightness' => 5),
			'alter_link_blend'	=> array('color' => 'alter_link',		'hue' => 2, 'saturation' => -5, 'brightness' => 5)
		));
		
		
		// -----------------------------------------------------------------
		// -- Theme specific thumb sizes
		// -----------------------------------------------------------------
		hogwords_storage_set('theme_thumbs', apply_filters('hogwords_filter_add_thumb_sizes', array(
			'hogwords-thumb-huge'		=> array(
												'size'	=> array(1170, 658, true),
												'title' => esc_html__( 'Huge image', 'hogwords' ),
												'subst'	=> 'trx_addons-thumb-huge'
												),
			'hogwords-thumb-big' 		=> array(
												'size'	=> array( 760, 589, true),
												'title' => esc_html__( 'Large image', 'hogwords' ),
												'subst'	=> 'trx_addons-thumb-big'
												),
			'hogwords-thumb-big-team' 		=> array(
												'size'	=> array( 760, 532, true),
												'title' => esc_html__( 'Team large image', 'hogwords' ),
												'subst'	=> 'trx_addons-thumb-big-team'
												),
			'hogwords-thumb-big-team-avatar' 	=> array(
												'size'	=> array( 600, 600, true),
												'title' => esc_html__( 'Team large avatar image', 'hogwords' ),
												'subst'	=> 'trx_addons-thumb-big-team-avatar'
												),
			'hogwords-thumb-med' 		=> array(
												'size'	=> array( 370, 208, true),
												'title' => esc_html__( 'Medium image', 'hogwords' ),
												'subst'	=> 'trx_addons-thumb-medium'
												),

			'hogwords-thumb-tiny' 		=> array(
												'size'	=> array(  150,  150, true),
												'title' => esc_html__( 'Small square avatar', 'hogwords' ),
												'subst'	=> 'trx_addons-thumb-tiny'
												),

			'hogwords-thumb-masonry-big' => array(
												'size'	=> array( 760,   0, false),		// Only downscale, not crop
												'title' => esc_html__( 'Masonry Large (scaled)', 'hogwords' ),
												'subst'	=> 'trx_addons-thumb-masonry-big'
												),

			'hogwords-thumb-masonry'		=> array(
												'size'	=> array( 370,   0, false),		// Only downscale, not crop
												'title' => esc_html__( 'Masonry (scaled)', 'hogwords' ),
												'subst'	=> 'trx_addons-thumb-masonry'
												)
			))
		);
	}
}




//------------------------------------------------------------------------
// One-click import support
//------------------------------------------------------------------------

// Set theme specific importer options
if ( !function_exists( 'hogwords_importer_set_options' ) ) {
	add_filter( 'trx_addons_filter_importer_options', 'hogwords_importer_set_options', 9 );
	function hogwords_importer_set_options($options=array()) {
		if (is_array($options)) {
			// Save or not installer's messages to the log-file
			$options['debug'] = false;
			// Prepare demo data
			$options['demo_url'] = esc_url(hogwords_get_protocol() . '://demofiles.axiomthemes.com/hogwords/');
			// Required plugins
			$options['required_plugins'] = array_keys(hogwords_storage_get('required_plugins'));
			// Set number of thumbnails to regenerate when its imported (if demo data was zipped without cropped images)
			// Set 0 to prevent regenerate thumbnails (if demo data archive is already contain cropped images)
			$options['regenerate_thumbnails'] = 3;
			// Default demo
			$options['files']['default']['title'] = esc_html__('Hogwords Demo', 'hogwords');
			$options['files']['default']['domain_dev'] = esc_url(hogwords_get_protocol() . '://hogwords.axiomthemes.dev');		// Developers domain
			$options['files']['default']['domain_demo']= esc_url(hogwords_get_protocol() . '://hogwords.axiomthemes.com');		// Demo-site domain
			// If theme need more demo - just copy 'default' and change required parameter
			// Banners
			$options['banners'] = array(
				array(
					'image' => hogwords_get_file_url('theme-specific/theme.about/images/frontpage.png'),
					'title' => esc_html__('Front page Builder', 'hogwords'),
					'content' => wp_kses_post(__('Create your Frontpage right in WordPress Customizer! To do this, you will not need neither the WPBakery Page Builder nor any other Builder. Just turn on/off sections, and fill them with content and decorate to your liking', 'hogwords')),
					'link_url' => esc_url('//www.youtube.com/watch?v=VT0AUbMl_KA'),
					'link_caption' => esc_html__('More about Frontpage Builder', 'hogwords'),
					'duration' => 20
					),
				array(
					'image' => hogwords_get_file_url('theme-specific/theme.about/images/layouts.png'),
					'title' => esc_html__('Custom layouts', 'hogwords'),
					'content' => wp_kses_post(__('Forget about problems with customization of header or footer! You can edit any of layout without any changes in CSS or HTML directly in Visual Builder. Moreover - you can easily create your own headers and footers and use them along with built-in', 'hogwords')),
					'link_url' => esc_url('//www.youtube.com/watch?v=pYhdFVLd7y4'),
					'link_caption' => esc_html__('More about Custom Layouts', 'hogwords'),
					'duration' => 20
					),
				array(
					'image' => hogwords_get_file_url('theme-specific/theme.about/images/documentation.png'),
					'title' => esc_html__('Read full documentation', 'hogwords'),
					'content' => wp_kses(__('Need more details? Please check our full online documentation for detailed information on how to use Hogwords', 'hogwords'), 'hogwords_kses_content'),
					'link_url' => esc_url(hogwords_storage_get('theme_doc_url')),
					'link_caption' => esc_html__('Online documentation', 'hogwords'),
					'duration' => 15
					),
				array(
					'image' => hogwords_get_file_url('theme-specific/theme.about/images/video-tutorials.png'),
					'title' => esc_html__('Video tutorials', 'hogwords'),
					'content' => wp_kses(__('No time for reading documentation? Check out our video tutorials and learn how to customize Hogwords in detail.', 'hogwords'), 'hogwords_kses_content'),
					'link_url' => esc_url(hogwords_storage_get('theme_video_url')),
					'link_caption' => esc_html__('Video tutorials', 'hogwords'),
					'duration' => 15
					),
				array(
					'image' => hogwords_get_file_url('theme-specific/theme.about/images/studio.jpg'),
					'title' => esc_html__('Website Customization', 'hogwords'),
					'content' => wp_kses(__('We can make a website based on this theme for a very fair price.
We can implement any extra functional: translate your website, WPML implementation and many other customization accroding to your request.', 'hogwords'), 'hogwords_kses_content'),
					'link_url' => esc_url('//themerex.net/offers/?utm_source=offers&utm_medium=click&utm_campaign=themedash '),
					'link_caption' => esc_html__('Contact us', 'hogwords'),
					'duration' => 25
					)
				);
		}
		return $options;
	}
}




// -----------------------------------------------------------------
// -- Theme options for customizer
// -----------------------------------------------------------------
if (!function_exists('hogwords_create_theme_options')) {

	function hogwords_create_theme_options() {

		// Message about options override. 
		// Attention! Not need esc_html() here, because this message put in wp_kses_data() below
		$msg_override = __('<b>Attention!</b> Some of these options can be overridden in the following sections (Blog, Plugins settings, etc.) or in the settings of individual pages', 'hogwords');

		hogwords_storage_set('options', array(
		
			// 'Logo & Site Identity'
			'title_tagline' => array(
				"title" => esc_html__('Logo & Site Identity', 'hogwords'),
				"desc" => '',
				"priority" => 10,
				"type" => "section"
				),
			'logo_info' => array(
				"title" => esc_html__('Logo in the header', 'hogwords'),
				"desc" => '',
				"priority" => 20,
				"type" => "info",
				),
			'logo_text' => array(
				"title" => esc_html__('Use Site Name as Logo', 'hogwords'),
				"desc" => wp_kses_data( __('Use the site title and tagline as a text logo if no image is selected', 'hogwords') ),
				"class" => "hogwords_column-1_2 hogwords_new_row",
				"priority" => 30,
				"std" => 1,
				"type" => HOGWORDS_THEME_FREE ? "hidden" : "checkbox"
				),
			'logo_retina_enabled' => array(
				"title" => esc_html__('Allow retina display logo', 'hogwords'),
				"desc" => wp_kses_data( __('Show fields to select logo images for Retina display', 'hogwords') ),
				"class" => "hogwords_column-1_2",
				"priority" => 40,
				"refresh" => false,
				"std" => 0,
				"type" => HOGWORDS_THEME_FREE ? "hidden" : "checkbox"
				),
			'logo_max_height' => array(
				"title" => esc_html__('Logo max. height', 'hogwords'),
				"desc" => wp_kses_data( __("Max. height of the logo image (in pixels). Maximum size of logo depends on the actual size of the picture", 'hogwords') ),
				"std" => 80,
				"min" => 20,
				"max" => 160,
				"step" => 1,
				"refresh" => false,
				"type" => HOGWORDS_THEME_FREE ? "hidden" : "slider"
				),
			// Parameter 'logo' was replaced with standard WordPress 'custom_logo'
			'logo_retina' => array(
				"title" => esc_html__('Logo for Retina', 'hogwords'),
				"desc" => wp_kses_data( __('Select or upload site logo used on Retina displays (if empty - use default logo from the field above)', 'hogwords') ),
				"class" => "hogwords_column-1_2",
				"priority" => 70,
				"dependency" => array(
					'logo_retina_enabled' => array(1)
				),
				"std" => '',
				"type" => HOGWORDS_THEME_FREE ? "hidden" : "image"
				),
			'logo_mobile_header' => array(
				"title" => esc_html__('Logo for the mobile header', 'hogwords'),
				"desc" => wp_kses_data( __('Select or upload site logo to display it in the mobile header (if enabled in the section "Header - Header mobile"', 'hogwords') ),
				"class" => "hogwords_column-1_2 hogwords_new_row",
				"std" => '',
				"type" => "image"
				),
			'logo_mobile_header_retina' => array(
				"title" => esc_html__('Logo for the mobile header for Retina', 'hogwords'),
				"desc" => wp_kses_data( __('Select or upload site logo used on Retina displays (if empty - use default logo from the field above)', 'hogwords') ),
				"class" => "hogwords_column-1_2",
				"dependency" => array(
					'logo_retina_enabled' => array(1)
				),
				"std" => '',
				"type" => HOGWORDS_THEME_FREE ? "hidden" : "image"
				),
			'logo_mobile' => array(
				"title" => esc_html__('Logo mobile', 'hogwords'),
				"desc" => wp_kses_data( __('Select or upload site logo to display it in the mobile menu', 'hogwords') ),
				"class" => "hogwords_column-1_2 hogwords_new_row",
				"std" => '',
				"type" => "image"
				),
			'logo_mobile_retina' => array(
				"title" => esc_html__('Logo mobile for Retina', 'hogwords'),
				"desc" => wp_kses_data( __('Select or upload site logo used on Retina displays (if empty - use default logo from the field above)', 'hogwords') ),
				"class" => "hogwords_column-1_2",
				"dependency" => array(
					'logo_retina_enabled' => array(1)
				),
				"std" => '',
				"type" => HOGWORDS_THEME_FREE ? "hidden" : "image"
				),
			'logo_side' => array(
				"title" => esc_html__('Logo side', 'hogwords'),
				"desc" => wp_kses_data( __('Select or upload site logo (with vertical orientation) to display it in the side menu', 'hogwords') ),
				"class" => "hogwords_column-1_2 hogwords_new_row",
				"std" => '',
				"type" => "image"
				),
			'logo_side_retina' => array(
				"title" => esc_html__('Logo side for Retina', 'hogwords'),
				"desc" => wp_kses_data( __('Select or upload site logo (with vertical orientation) to display it in the side menu on Retina displays (if empty - use default logo from the field above)', 'hogwords') ),
				"class" => "hogwords_column-1_2",
				"dependency" => array(
					'logo_retina_enabled' => array(1)
				),
				"std" => '',
				"type" => HOGWORDS_THEME_FREE ? "hidden" : "image"
				),
			
		
		
			// 'General settings'
			'general' => array(
				"title" => esc_html__('General Settings', 'hogwords'),
				"desc" => wp_kses_data( $msg_override ),
				"priority" => 20,
				"type" => "section",
				),

			'general_layout_info' => array(
				"title" => esc_html__('Layout', 'hogwords'),
				"desc" => '',
				"type" => "info",
				),
			'body_style' => array(
				"title" => esc_html__('Body style', 'hogwords'),
				"desc" => wp_kses_data( __('Select width of the body content', 'hogwords') ),
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Content', 'hogwords')
				),
				"refresh" => false,
				"std" => 'wide',
				"options" => hogwords_get_list_body_styles(),
				"type" => "select"
				),
			'boxed_bg_image' => array(
				"title" => esc_html__('Boxed bg image', 'hogwords'),
				"desc" => wp_kses_data( __('Select or upload image, used as background in the boxed body', 'hogwords') ),
				"dependency" => array(
					'body_style' => array('boxed')
				),
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Content', 'hogwords')
				),
				"std" => '',
				"hidden" => true,
				"type" => "image"
				),
			'remove_margins' => array(
				"title" => esc_html__('Remove margins', 'hogwords'),
				"desc" => wp_kses_data( __('Remove margins above and below the content area', 'hogwords') ),
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Content', 'hogwords')
				),
				"refresh" => false,
				"std" => 0,
				"type" => "checkbox"
				),

			'general_sidebar_info' => array(
				"title" => esc_html__('Sidebar', 'hogwords'),
				"desc" => '',
				"type" => "info",
				),
			'sidebar_position' => array(
				"title" => esc_html__('Sidebar position', 'hogwords'),
				"desc" => wp_kses_data( __('Select position to show sidebar', 'hogwords') ),
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Widgets', 'hogwords')
				),
				"std" => 'right',
				"options" => array(),
				"type" => "switch"
				),
			'sidebar_widgets' => array(
				"title" => esc_html__('Sidebar widgets', 'hogwords'),
				"desc" => wp_kses_data( __('Select default widgets to show in the sidebar', 'hogwords') ),
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Widgets', 'hogwords')
				),
				"dependency" => array(
					'sidebar_position' => array('left', 'right')
				),
				"std" => 'sidebar_widgets',
				"options" => array(),
				"type" => "select"
				),
			'expand_content' => array(
				"title" => esc_html__('Expand content', 'hogwords'),
				"desc" => wp_kses_data( __('Expand the content width if the sidebar is hidden', 'hogwords') ),
				"refresh" => false,
				"std" => 1,
				"type" => "checkbox"
				),


			'general_widgets_info' => array(
				"title" => esc_html__('Additional widgets', 'hogwords'),
				"desc" => '',
				"type" => HOGWORDS_THEME_FREE ? "hidden" : "info",
				),
			'widgets_above_page' => array(
				"title" => esc_html__('Widgets at the top of the page', 'hogwords'),
				"desc" => wp_kses_data( __('Select widgets to show at the top of the page (above content and sidebar)', 'hogwords') ),
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Widgets', 'hogwords')
				),
				"std" => 'hide',
				"options" => array(),
				"type" => HOGWORDS_THEME_FREE ? "hidden" : "select"
				),
			'widgets_above_content' => array(
				"title" => esc_html__('Widgets above the content', 'hogwords'),
				"desc" => wp_kses_data( __('Select widgets to show at the beginning of the content area', 'hogwords') ),
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Widgets', 'hogwords')
				),
				"std" => 'hide',
				"options" => array(),
				"type" => HOGWORDS_THEME_FREE ? "hidden" : "select"
				),
			'widgets_below_content' => array(
				"title" => esc_html__('Widgets below the content', 'hogwords'),
				"desc" => wp_kses_data( __('Select widgets to show at the ending of the content area', 'hogwords') ),
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Widgets', 'hogwords')
				),
				"std" => 'hide',
				"options" => array(),
				"type" => HOGWORDS_THEME_FREE ? "hidden" : "select"
				),
			'widgets_below_page' => array(
				"title" => esc_html__('Widgets at the bottom of the page', 'hogwords'),
				"desc" => wp_kses_data( __('Select widgets to show at the bottom of the page (below content and sidebar)', 'hogwords') ),
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Widgets', 'hogwords')
				),
				"std" => 'hide',
				"options" => array(),
				"type" => HOGWORDS_THEME_FREE ? "hidden" : "select"
				),

			'general_effects_info' => array(
				"title" => esc_html__('Design & Effects', 'hogwords'),
				"desc" => '',
				"type" => "info",
				),
			'border_radius' => array(
				"title" => esc_html__('Border radius', 'hogwords'),
				"desc" => wp_kses_data( __('Specify the border radius of the form fields and buttons in pixels or other valid CSS units', 'hogwords') ),
				"std" => 0,
				"type" => "text",
				"hidden"=> true
				),

			'general_misc_info' => array(
				"title" => esc_html__('Miscellaneous', 'hogwords'),
				"desc" => '',
				"type" => HOGWORDS_THEME_FREE ? "hidden" : "info",
				),
			'seo_snippets' => array(
				"title" => esc_html__('SEO snippets', 'hogwords'),
				"desc" => wp_kses_data( __('Add structured data markup to the single posts and pages', 'hogwords') ),
				"std" => 0,
				"type" => HOGWORDS_THEME_FREE ? "hidden" : "checkbox"
				),
            'privacy_text' => array(
                "title" => esc_html__("Text with Privacy Policy link", 'hogwords'),
                "desc"  => wp_kses_data( __("Specify text with Privacy Policy link for the checkbox 'I agree ...'", 'hogwords') ),
                "std"   => wp_kses( __( 'I agree that my submitted data is being collected and stored.', 'hogwords'), 'hogwords_kses_content' ),
                "type"  => "text"
            ),
		
		
			// 'Header'
			'header' => array(
				"title" => esc_html__('Header', 'hogwords'),
				"desc" => wp_kses_data( $msg_override ),
				"priority" => 30,
				"type" => "section"
				),

			'header_style_info' => array(
				"title" => esc_html__('Header style', 'hogwords'),
				"desc" => '',
				"type" => "info"
				),
			'header_type' => array(
				"title" => esc_html__('Header style', 'hogwords'),
				"desc" => wp_kses_data( __('Choose whether to use the default header or header Layouts (available only if the ThemeREX Addons is activated)', 'hogwords') ),
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Header', 'hogwords')
				),
				"std" => 'default',
				"options" => hogwords_get_list_header_footer_types(),
				"type" => HOGWORDS_THEME_FREE ? "hidden" : "switch"
				),
			'header_style' => array(
				"title" => esc_html__('Select custom layout', 'hogwords'),
				"desc" => wp_kses( __("Select custom header from Layouts Builder", 'hogwords'), 'hogwords_kses_content' ),
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Header', 'hogwords')
				),
				"dependency" => array(
					'header_type' => array('custom')
				),
				"std" => HOGWORDS_THEME_FREE ? 'header-custom-sow-header-default' : 'header-custom-header-default',
				"options" => array(),
				"type" => "select"
				),
			'header_position' => array(
				"title" => esc_html__('Header position', 'hogwords'),
				"desc" => wp_kses_data( __('Select position to display the site header', 'hogwords') ),
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Header', 'hogwords')
				),
				"std" => 'default',
				"options" => array(),
				"type" => HOGWORDS_THEME_FREE ? "hidden" : "switch"
				),
			'header_fullheight' => array(
				"title" => esc_html__('Header fullheight', 'hogwords'),
				"desc" => wp_kses_data( __("Enlarge header area to fill whole screen. Used only if header have a background image", 'hogwords') ),
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Header', 'hogwords')
				),
				"std" => 0,
				"type" => HOGWORDS_THEME_FREE ? "hidden" : "checkbox"
				),
			'header_zoom' => array(
				"title" => esc_html__('Header zoom', 'hogwords'),
				"desc" => wp_kses_data( __("Zoom the header title. 1 - original size", 'hogwords') ),
				"std" => 1,
				"min" => 0.3,
				"max" => 2,
				"step" => 0.1,
				"refresh" => false,
				"type" => HOGWORDS_THEME_FREE ? "hidden" : "slider"
				),
			'header_wide' => array(
				"title" => esc_html__('Header fullwide', 'hogwords'),
				"desc" => wp_kses_data( __('Do you want to stretch the header widgets area to the entire window width?', 'hogwords') ),
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Header', 'hogwords')
				),
				"dependency" => array(
					'header_type' => array('default')
				),
				"std" => 1,
				"type" => HOGWORDS_THEME_FREE ? "hidden" : "checkbox"
				),

			'header_widgets_info' => array(
				"title" => esc_html__('Header widgets', 'hogwords'),
				"desc" => wp_kses_data( __('Here you can place a widget slider, advertising banners, etc.', 'hogwords') ),
				"type" => "info"
				),
			'header_widgets' => array(
				"title" => esc_html__('Header widgets', 'hogwords'),
				"desc" => wp_kses_data( __('Select set of widgets to show in the header on each page', 'hogwords') ),
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Header', 'hogwords'),
					"desc" => wp_kses_data( __('Select set of widgets to show in the header on this page', 'hogwords') ),
				),
				"std" => 'hide',
				"options" => array(),
				"type" => "select"
				),
			'header_columns' => array(
				"title" => esc_html__('Header columns', 'hogwords'),
				"desc" => wp_kses_data( __('Select number columns to show widgets in the Header. If 0 - autodetect by the widgets count', 'hogwords') ),
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Header', 'hogwords')
				),
				"dependency" => array(
					'header_type' => array('default'),
					'header_widgets' => array('^hide')
				),
				"std" => 0,
				"options" => hogwords_get_list_range(0,6),
				"type" => "select"
				),

			'menu_info' => array(
				"title" => esc_html__('Main menu', 'hogwords'),
				"desc" => wp_kses_data( __('Select main menu style, position, color scheme and other parameters', 'hogwords') ),
				"type" => HOGWORDS_THEME_FREE ? "hidden" : "info"
				),
			'menu_style' => array(
				"title" => esc_html__('Menu position', 'hogwords'),
				"desc" => wp_kses_data( __('Select position of the main menu', 'hogwords') ),
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Header', 'hogwords')
				),
				"std" => 'top',
				"options" => array(
					'top'	=> esc_html__('Top',	'hogwords')
				),
				"type" => HOGWORDS_THEME_FREE ? "hidden" : "switch"
				),
			'menu_side_stretch' => array(
				"title" => esc_html__('Stretch sidemenu', 'hogwords'),
				"desc" => wp_kses_data( __('Stretch sidemenu to window height (if menu items number >= 5)', 'hogwords') ),
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Header', 'hogwords')
				),
				"dependency" => array(
					'menu_style' => array('left', 'right')
				),
				"std" => 0,
				"type" => HOGWORDS_THEME_FREE ? "hidden" : "checkbox"
				),
			'menu_side_icons' => array(
				"title" => esc_html__('Iconed sidemenu', 'hogwords'),
				"desc" => wp_kses_data( __('Get icons from anchors and display it in the sidemenu or mark sidemenu items with simple dots', 'hogwords') ),
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Header', 'hogwords')
				),
				"dependency" => array(
					'menu_style' => array('left', 'right')
				),
				"std" => 1,
				"type" => HOGWORDS_THEME_FREE ? "hidden" : "checkbox"
				),
			'menu_mobile_fullscreen' => array(
				"title" => esc_html__('Mobile menu fullscreen', 'hogwords'),
				"desc" => wp_kses_data( __('Display mobile and side menus on full screen (if checked) or slide narrow menu from the left or from the right side (if not checked)', 'hogwords') ),
				"std" => 1,
				"type" => HOGWORDS_THEME_FREE ? "hidden" : "checkbox"
				),

			'header_image_info' => array(
				"title" => esc_html__('Header image', 'hogwords'),
				"desc" => '',
				"type" => HOGWORDS_THEME_FREE ? "hidden" : "info"
				),
			'header_image_override' => array(
				"title" => esc_html__('Header image override', 'hogwords'),
				"desc" => wp_kses_data( __("Allow override the header image with the page's/post's/product's/etc. featured image", 'hogwords') ),
				"override" => array(
					'mode' => 'page',
					'section' => esc_html__('Header', 'hogwords')
				),
				"std" => 0,
				"type" => HOGWORDS_THEME_FREE ? "hidden" : "checkbox"
				),

			'header_mobile_info' => array(
				"title" => esc_html__('Mobile header', 'hogwords'),
				"desc" => wp_kses_data( __("Configure the mobile version of the header", 'hogwords') ),
				"priority" => 500,
				"type" => HOGWORDS_THEME_FREE ? "hidden" : "info"
				),
			'header_mobile_enabled' => array(
				"title" => esc_html__('Enable the mobile header', 'hogwords'),
				"desc" => wp_kses_data( __("Use the mobile version of the header (if checked) or relayout the current header on mobile devices", 'hogwords') ),
				"std" => 0,
				"type" => HOGWORDS_THEME_FREE ? "hidden" : "checkbox"
				),
			'header_mobile_additional_info' => array(
				"title" => esc_html__('Additional info', 'hogwords'),
				"desc" => wp_kses_data( __('Additional info to show at the top of the mobile header', 'hogwords') ),
				"std" => '',
				"dependency" => array(
					'header_mobile_enabled' => array(1)
				),
				"refresh" => false,
				"teeny" => false,
				"rows" => 20,
				"type" => HOGWORDS_THEME_FREE ? "hidden" : "text_editor"
				),
			'header_mobile_hide_info' => array(
				"title" => esc_html__('Hide additional info', 'hogwords'),
				"std" => 0,
				"dependency" => array(
					'header_mobile_enabled' => array(1)
				),
				"type" => HOGWORDS_THEME_FREE ? "hidden" : "checkbox"
				),
			'header_mobile_hide_logo' => array(
				"title" => esc_html__('Hide logo', 'hogwords'),
				"std" => 0,
				"dependency" => array(
					'header_mobile_enabled' => array(1)
				),
				"type" => HOGWORDS_THEME_FREE ? "hidden" : "checkbox"
				),
			'header_mobile_hide_login' => array(
				"title" => esc_html__('Hide login/logout', 'hogwords'),
				"std" => 0,
				"dependency" => array(
					'header_mobile_enabled' => array(1)
				),
				"type" => HOGWORDS_THEME_FREE ? "hidden" : "checkbox"
				),
			'header_mobile_hide_search' => array(
				"title" => esc_html__('Hide search', 'hogwords'),
				"std" => 0,
				"dependency" => array(
					'header_mobile_enabled' => array(1)
				),
				"type" => HOGWORDS_THEME_FREE ? "hidden" : "checkbox"
				),
			'header_mobile_hide_cart' => array(
				"title" => esc_html__('Hide cart', 'hogwords'),
				"std" => 0,
				"dependency" => array(
					'header_mobile_enabled' => array(1)
				),
				"type" => HOGWORDS_THEME_FREE ? "hidden" : "checkbox"
				),


		
			// 'Footer'
			'footer' => array(
				"title" => esc_html__('Footer', 'hogwords'),
				"desc" => wp_kses_data( $msg_override ),
				"priority" => 50,
				"type" => "section"
				),
			'footer_type' => array(
				"title" => esc_html__('Footer style', 'hogwords'),
				"desc" => wp_kses_data( __('Choose whether to use the default footer or footer Layouts (available only if the ThemeREX Addons is activated)', 'hogwords') ),
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Footer', 'hogwords')
				),
				"std" => 'default',
				"options" => hogwords_get_list_header_footer_types(),
				"type" => HOGWORDS_THEME_FREE ? "hidden" : "switch"
				),
			'footer_style' => array(
				"title" => esc_html__('Select custom layout', 'hogwords'),
				"desc" => wp_kses( __("Select custom footer from Layouts Builder", 'hogwords'), 'hogwords_kses_content' ),
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Footer', 'hogwords')
				),
				"dependency" => array(
					'footer_type' => array('custom')
				),
				"std" => HOGWORDS_THEME_FREE ? 'footer-custom-sow-footer-default' : 'footer-custom-footer-default',
				"options" => array(),
				"type" => "select"
				),
			'footer_widgets' => array(
				"title" => esc_html__('Footer widgets', 'hogwords'),
				"desc" => wp_kses_data( __('Select set of widgets to show in the footer', 'hogwords') ),
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Footer', 'hogwords')
				),
				"dependency" => array(
					'footer_type' => array('default')
				),
				"std" => 'footer_widgets',
				"options" => array(),
				"type" => "select"
				),
			'footer_columns' => array(
				"title" => esc_html__('Footer columns', 'hogwords'),
				"desc" => wp_kses_data( __('Select number columns to show widgets in the footer. If 0 - autodetect by the widgets count', 'hogwords') ),
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Footer', 'hogwords')
				),
				"dependency" => array(
					'footer_type' => array('default'),
					'footer_widgets' => array('^hide')
				),
				"std" => 3,
				"options" => hogwords_get_list_range(0,6),
				"type" => "select"
				),
			'footer_wide' => array(
				"title" => esc_html__('Footer fullwide', 'hogwords'),
				"desc" => wp_kses_data( __('Do you want to stretch the footer to the entire window width?', 'hogwords') ),
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Footer', 'hogwords')
				),
				"dependency" => array(
					'footer_type' => array('default')
				),
				"std" => 0,
				"type" => "checkbox"
				),
			'logo_in_footer' => array(
				"title" => esc_html__('Show logo', 'hogwords'),
				"desc" => wp_kses_data( __('Show logo in the footer', 'hogwords') ),
				'refresh' => false,
				"dependency" => array(
					'footer_type' => array('default')
				),
				"std" => 0,
				"type" => "checkbox"
				),
			'logo_footer' => array(
				"title" => esc_html__('Logo for footer', 'hogwords'),
				"desc" => wp_kses_data( __('Select or upload site logo to display it in the footer', 'hogwords') ),
				"dependency" => array(
					'footer_type' => array('default'),
					'logo_in_footer' => array(1)
				),
				"std" => '',
				"type" => "image"
				),
			'logo_footer_retina' => array(
				"title" => esc_html__('Logo for footer (Retina)', 'hogwords'),
				"desc" => wp_kses_data( __('Select or upload logo for the footer area used on Retina displays (if empty - use default logo from the field above)', 'hogwords') ),
				"dependency" => array(
					'footer_type' => array('default'),
					'logo_in_footer' => array(1),
					'logo_retina_enabled' => array(1)
				),
				"std" => '',
				"type" => HOGWORDS_THEME_FREE ? "hidden" : "image"
				),
			'socials_in_footer' => array(
				"title" => esc_html__('Show social icons', 'hogwords'),
				"desc" => wp_kses_data( __('Show social icons in the footer (under logo or footer widgets)', 'hogwords') ),
				"dependency" => array(
					'footer_type' => array('default')
				),
				"std" => 0,
				"type" => "checkbox"
				),
			'copyright' => array(
				"title" => esc_html__('Copyright', 'hogwords'),
				"desc" => wp_kses_data( __('Copyright text in the footer. Use {Y} to insert current year and press "Enter" to create a new line', 'hogwords') ),
				"std" => esc_html__('Copyright &copy; {Y} by AxiomThemes. All rights reserved.', 'hogwords'),
				"dependency" => array(
					'footer_type' => array('default')
				),
				"refresh" => false,
				"type" => "textarea"
				),
			
		
		
			// 'Blog'
			'blog' => array(
				"title" => esc_html__('Blog', 'hogwords'),
				"desc" => wp_kses_data( __('Options of the the blog archive', 'hogwords') ),
				"priority" => 70,
				"type" => "panel",
				),
		
				// Blog - Posts page
				'blog_general' => array(
					"title" => esc_html__('Posts page', 'hogwords'),
					"desc" => wp_kses_data( __('Style and components of the blog archive', 'hogwords') ),
					"type" => "section",
					),
				'blog_general_info' => array(
					"title" => esc_html__('General settings', 'hogwords'),
					"desc" => '',
					"type" => "info",
					),
				'blog_style' => array(
					"title" => esc_html__('Blog style', 'hogwords'),
					"desc" => '',
					"override" => array(
						'mode' => 'page',
						'section' => esc_html__('Content', 'hogwords')
					),
					"dependency" => array(
						'#page_template' => array('blog.php'),
                        '.editor-page-attributes__template select' => array( 'blog.php' ),
					),
					"std" => 'excerpt',
					"options" => array(),
					"type" => "select"
					),
				'first_post_large' => array(
					"title" => esc_html__('First post large', 'hogwords'),
					"desc" => wp_kses_data( __('Make your first post stand out by making it bigger', 'hogwords') ),
					"override" => array(
						'mode' => 'page',
						'section' => esc_html__('Content', 'hogwords')
					),
					"dependency" => array(
						'#page_template' => array('blog.php'),
                        '.editor-page-attributes__template select' => array( 'blog.php' ),
						'blog_style' => array('classic', 'masonry')
					),
					"std" => 0,
					"type" => "checkbox"
					),
				"blog_content" => array( 
					"title" => esc_html__('Posts content', 'hogwords'),
					"desc" => wp_kses_data( __("Display either post excerpts or the full post content", 'hogwords') ),
					"std" => "excerpt",
					"dependency" => array(
						'blog_style' => array('excerpt')
					),
					"options" => array(
						'excerpt'	=> esc_html__('Excerpt',	'hogwords'),
						'fullpost'	=> esc_html__('Full post',	'hogwords')
					),
					"type" => "switch"
					),
				'excerpt_length' => array(
					"title" => esc_html__('Excerpt length', 'hogwords'),
					"desc" => wp_kses_data( __("Length (in words) to generate excerpt from the post content. Attention! If the post excerpt is explicitly specified - it appears unchanged", 'hogwords') ),
					"dependency" => array(
						'blog_style' => array('excerpt'),
						'blog_content' => array('excerpt')
					),
					"std" => 30,
					"type" => "text"
					),
				'blog_columns' => array(
					"title" => esc_html__('Blog columns', 'hogwords'),
					"desc" => wp_kses_data( __('How many columns should be used in the blog archive (from 2 to 4)?', 'hogwords') ),
					"std" => 2,
					"options" => hogwords_get_list_range(2,4),
					"type" => "hidden"
					),
				'post_type' => array(
					"title" => esc_html__('Post type', 'hogwords'),
					"desc" => wp_kses_data( __('Select post type to show in the blog archive', 'hogwords') ),
					"override" => array(
						'mode' => 'page',
						'section' => esc_html__('Content', 'hogwords')
					),
					"dependency" => array(
						'#page_template' => array('blog.php'),
                        '.editor-page-attributes__template select' => array( 'blog.php' ),
					),
					"linked" => 'parent_cat',
					"refresh" => false,
					"hidden" => true,
					"std" => 'post',
					"options" => array(),
					"type" => "select"
					),
				'parent_cat' => array(
					"title" => esc_html__('Category to show', 'hogwords'),
					"desc" => wp_kses_data( __('Select category to show in the blog archive', 'hogwords') ),
					"override" => array(
						'mode' => 'page',
						'section' => esc_html__('Content', 'hogwords')
					),
					"dependency" => array(
						'#page_template' => array('blog.php'),
                        '.editor-page-attributes__template select' => array( 'blog.php' ),
					),
					"refresh" => false,
					"hidden" => true,
					"std" => '0',
					"options" => array(),
					"type" => "select"
					),
				'posts_per_page' => array(
					"title" => esc_html__('Posts per page', 'hogwords'),
					"desc" => wp_kses_data( __('How many posts will be displayed on this page', 'hogwords') ),
					"override" => array(
						'mode' => 'page',
						'section' => esc_html__('Content', 'hogwords')
					),
					"dependency" => array(
						'#page_template' => array('blog.php'),
                        '.editor-page-attributes__template select' => array( 'blog.php' ),
					),
					"hidden" => true,
					"std" => '',
					"type" => "text"
					),
				"blog_pagination" => array( 
					"title" => esc_html__('Pagination style', 'hogwords'),
					"desc" => wp_kses_data( __('Show Older/Newest posts or Page numbers below the posts list', 'hogwords') ),
					"override" => array(
						'mode' => 'page',
						'section' => esc_html__('Content', 'hogwords')
					),
					"std" => "pages",
					"dependency" => array(
						'#page_template' => array('blog.php'),
                        '.editor-page-attributes__template select' => array( 'blog.php' ),
					),
					"options" => array(
						'pages'	=> esc_html__("Page numbers", 'hogwords'),
						'links'	=> esc_html__("Older/Newest", 'hogwords'),
						'more'	=> esc_html__("Load more", 'hogwords'),
						'infinite' => esc_html__("Infinite scroll", 'hogwords')
					),
					"type" => "select"
					),
				'show_filters' => array(
					"title" => esc_html__('Show filters', 'hogwords'),
					"desc" => wp_kses_data( __('Show categories as tabs to filter posts', 'hogwords') ),
					"override" => array(
						'mode' => 'page',
						'section' => esc_html__('Content', 'hogwords')
					),
					"dependency" => array(
						'#page_template' => array('blog.php'),
                        '.editor-page-attributes__template select' => array( 'blog.php' ),
						'blog_style' => array('portfolio', 'gallery')
					),
					"hidden" => true,
					"std" => 0,
					"type" => HOGWORDS_THEME_FREE ? "hidden" : "checkbox"
					),
	
				'blog_sidebar_info' => array(
					"title" => esc_html__('Sidebar', 'hogwords'),
					"desc" => '',
					"type" => "info",
					),
				'sidebar_position_blog' => array(
					"title" => esc_html__('Sidebar position', 'hogwords'),
					"desc" => wp_kses_data( __('Select position to show sidebar', 'hogwords') ),
					"std" => 'right',
					"options" => array(),
					"type" => "switch"
					),
				'sidebar_widgets_blog' => array(
					"title" => esc_html__('Sidebar widgets', 'hogwords'),
					"desc" => wp_kses_data( __('Select default widgets to show in the sidebar', 'hogwords') ),
					"dependency" => array(
						'sidebar_position_blog' => array('left', 'right')
					),
					"std" => 'sidebar_widgets',
					"options" => array(),
					"type" => "select"
					),
				'expand_content_blog' => array(
					"title" => esc_html__('Expand content', 'hogwords'),
					"desc" => wp_kses_data( __('Expand the content width if the sidebar is hidden', 'hogwords') ),
					"refresh" => false,
					"std" => 1,
					"type" => "checkbox"
					),
	
	
				'blog_widgets_info' => array(
					"title" => esc_html__('Additional widgets', 'hogwords'),
					"desc" => '',
					"type" => HOGWORDS_THEME_FREE ? "hidden" : "info",
					),
				'widgets_above_page_blog' => array(
					"title" => esc_html__('Widgets at the top of the page', 'hogwords'),
					"desc" => wp_kses_data( __('Select widgets to show at the top of the page (above content and sidebar)', 'hogwords') ),
					"std" => 'hide',
					"options" => array(),
					"type" => HOGWORDS_THEME_FREE ? "hidden" : "select"
					),
				'widgets_above_content_blog' => array(
					"title" => esc_html__('Widgets above the content', 'hogwords'),
					"desc" => wp_kses_data( __('Select widgets to show at the beginning of the content area', 'hogwords') ),
					"std" => 'hide',
					"options" => array(),
					"type" => HOGWORDS_THEME_FREE ? "hidden" : "select"
					),
				'widgets_below_content_blog' => array(
					"title" => esc_html__('Widgets below the content', 'hogwords'),
					"desc" => wp_kses_data( __('Select widgets to show at the ending of the content area', 'hogwords') ),
					"std" => 'hide',
					"options" => array(),
					"type" => HOGWORDS_THEME_FREE ? "hidden" : "select"
					),
				'widgets_below_page_blog' => array(
					"title" => esc_html__('Widgets at the bottom of the page', 'hogwords'),
					"desc" => wp_kses_data( __('Select widgets to show at the bottom of the page (below content and sidebar)', 'hogwords') ),
					"std" => 'hide',
					"options" => array(),
					"type" => HOGWORDS_THEME_FREE ? "hidden" : "select"
					),

				'blog_advanced_info' => array(
					"title" => esc_html__('Advanced settings', 'hogwords'),
					"desc" => '',
					"type" => "info",
					),
				'no_image' => array(
					"title" => esc_html__('Image placeholder', 'hogwords'),
					"desc" => wp_kses_data( __('Select or upload an image used as placeholder for posts without a featured image', 'hogwords') ),
					"std" => '',
					"type" => "image"
					),
				'time_diff_before' => array(
					"title" => esc_html__('Easy Readable Date Format', 'hogwords'),
					"desc" => wp_kses_data( __("For how many days to show the easy-readable date format (e.g. '3 days ago') instead of the standard publication date", 'hogwords') ),
					"std" => 5,
					"type" => "text"
					),
				'sticky_style' => array(
					"title" => esc_html__('Sticky posts style', 'hogwords'),
					"desc" => wp_kses_data( __('Select style of the sticky posts output', 'hogwords') ),
					"std" => 'inherit',
					"options" => array(
						'inherit' => esc_html__('Decorated posts', 'hogwords'),
						'columns' => esc_html__('Mini-cards',	'hogwords')
					),
					"type" => HOGWORDS_THEME_FREE ? "hidden" : "select"
					),
				"blog_animation" => array( 
					"title" => esc_html__('Animation for the posts', 'hogwords'),
					"desc" => wp_kses_data( __('Select animation to show posts in the blog. Attention! Do not use any animation on pages with the "wheel to the anchor" behaviour (like a "Chess 2 columns")!', 'hogwords') ),
					"override" => array(
						'mode' => 'page',
						'section' => esc_html__('Content', 'hogwords')
					),
					"dependency" => array(
						'#page_template' => array('blog.php'),
                        '.editor-page-attributes__template select' => array( 'blog.php' ),
					),
					"std" => "none",
					"options" => array(),
					"type" => HOGWORDS_THEME_FREE ? "hidden" : "select"
					),
				'meta_parts' => array(
					"title" => esc_html__('Post meta', 'hogwords'),
					"desc" => wp_kses_data( __("If your blog page is created using the 'Blog archive' page template, set up the 'Post Meta' settings in the 'Theme Options' section of that page.", 'hogwords') )
								. '<br>'
								. wp_kses_data( __("<b>Tip:</b> Drag items to change their order.", 'hogwords') ),
					"override" => array(
						'mode' => 'page',
						'section' => esc_html__('Content', 'hogwords')
					),
					"dependency" => array(
						'#page_template' => array('blog.php'),
                        '.editor-page-attributes__template select' => array( 'blog.php' ),
					),
					"dir" => 'vertical',
					"sortable" => true,
					"std" => 'date=1|author=1|counters=1|categories=0|share=1|edit=1',
					"options" => array(
						'date'		 => esc_html__('Post date', 'hogwords'),
						'author'	 => esc_html__('Post author', 'hogwords'),
						'categories' => esc_html__('Categories', 'hogwords'),
						'counters'	 => esc_html__('Views, Likes and Comments', 'hogwords'),
						'share'		 => esc_html__('Share links', 'hogwords'),
						'edit'		 => esc_html__('Edit link', 'hogwords')
					),
					"type" => HOGWORDS_THEME_FREE ? "hidden" : "checklist"
				),
				'counters' => array(
					"title" => esc_html__('Views, Likes and Comments', 'hogwords'),
					"desc" => wp_kses_data( __("Likes and Views are available only if ThemeREX Addons is active", 'hogwords') ),
					"override" => array(
						'mode' => 'page',
						'section' => esc_html__('Content', 'hogwords')
					),
					"dependency" => array(
						'#page_template' => array('blog.php'),
                        '.editor-page-attributes__template select' => array( 'blog.php' ),
					),
					"dir" => 'vertical',
					"sortable" => true,
					"std" => 'views=1|likes=1|comments=1',
					"options" => array(
						'views' => esc_html__('Views', 'hogwords'),
						'likes' => esc_html__('Likes', 'hogwords'),
						'comments' => esc_html__('Comments', 'hogwords')
					),
					"type" => HOGWORDS_THEME_FREE ? "hidden" : "checklist"
				),

				
				// Blog - Single posts
				'blog_single' => array(
					"title" => esc_html__('Single posts', 'hogwords'),
					"desc" => wp_kses_data( __('Settings of the single post', 'hogwords') ),
					"type" => "section",
					),
				'hide_featured_on_single' => array(
					"title" => esc_html__('Hide featured image on the single post', 'hogwords'),
					"desc" => wp_kses_data( __("Hide featured image on the single post's pages", 'hogwords') ),
					"override" => array(
						'mode' => 'page,post',
						'section' => esc_html__('Content', 'hogwords')
					),
					"std" => 0,
					"type" => "checkbox"
					),
				'hide_sidebar_on_single' => array(
					"title" => esc_html__('Hide sidebar on the single post', 'hogwords'),
					"desc" => wp_kses_data( __("Hide sidebar on the single post's pages", 'hogwords') ),
					"std" => 0,
					"type" => "checkbox"
					),
				'show_post_meta' => array(
					"title" => esc_html__('Show post meta', 'hogwords'),
					"desc" => wp_kses_data( __("Display block with post's meta: date, categories, counters, etc.", 'hogwords') ),
					"std" => 1,
					"type" => "checkbox"
					),
				'meta_parts_post' => array(
					"title" => esc_html__('Post meta', 'hogwords'),
					"desc" => wp_kses_data( __("Meta parts for single posts.", 'hogwords') ),
					"dependency" => array(
						'show_post_meta' => array(1)
					),
					"dir" => 'vertical',
					"sortable" => true,
					"std" => 'author=1|date=1|counters=1|categories=0|share=1|edit=1',
					"options" => array(
						'categories' => esc_html__('Categories', 'hogwords'),
						'date'		 => esc_html__('Post date', 'hogwords'),
						'author'	 => esc_html__('Post author', 'hogwords'),
						'counters'	 => esc_html__('Views, Likes and Comments', 'hogwords'),
						'share'		 => esc_html__('Share links', 'hogwords'),
						'edit'		 => esc_html__('Edit link', 'hogwords')
					),
					"type" => HOGWORDS_THEME_FREE ? "hidden" : "checklist"
				),
				'counters_post' => array(
					"title" => esc_html__('Views, Likes and Comments', 'hogwords'),
					"desc" => wp_kses_data( __("Likes and Views are available only if ThemeREX Addons is active", 'hogwords') ),
					"dependency" => array(
						'show_post_meta' => array(1)
					),
					"dir" => 'vertical',
					"sortable" => true,
					"std" => 'views=1|likes=1|comments=1',
					"options" => array(
						'views' => esc_html__('Views', 'hogwords'),
						'likes' => esc_html__('Likes', 'hogwords'),
						'comments' => esc_html__('Comments', 'hogwords')
					),
					"type" => HOGWORDS_THEME_FREE ? "hidden" : "checklist"
				),
				'show_share_links' => array(
					"title" => esc_html__('Show share links', 'hogwords'),
					"desc" => wp_kses_data( __("Display share links on the single post", 'hogwords') ),
					"std" => 1,
					"type" => "checkbox"
					),
				'show_author_info' => array(
					"title" => esc_html__('Show author info', 'hogwords'),
					"desc" => wp_kses_data( __("Display block with information about post's author", 'hogwords') ),
					"std" => 1,
					"type" => "checkbox"
					),
				'blog_single_related_info' => array(
					"title" => esc_html__('Related posts', 'hogwords'),
					"desc" => '',
					"type" => "info",
					),
				'show_related_posts' => array(
					"title" => esc_html__('Show related posts', 'hogwords'),
					"desc" => wp_kses_data( __("Show section 'Related posts' on the single post's pages", 'hogwords') ),
					"override" => array(
						'mode' => 'page,post,cpt_courses',
						'section' => esc_html__('Content', 'hogwords')
					),
					"std" => 0,
					"type" => "checkbox"
					),
				'related_posts' => array(
					"title" => esc_html__('Related posts', 'hogwords'),
					"desc" => wp_kses_data( __('How many related posts should be displayed in the single post? If 0 - no related posts showed.', 'hogwords') ),
					"dependency" => array(
						'show_related_posts' => array(1)
					),
					"std" => 2,
					"options" => hogwords_get_list_range(1,9),
					"type" => HOGWORDS_THEME_FREE ? "hidden" : "select"
					),
				'related_columns' => array(
					"title" => esc_html__('Related columns', 'hogwords'),
					"desc" => wp_kses_data( __('How many columns should be used to output related posts in the single page (from 2 to 4)?', 'hogwords') ),
					"dependency" => array(
						'show_related_posts' => array(1)
					),
					"std" => 2,
					"options" => hogwords_get_list_range(1,4),
					"type" => HOGWORDS_THEME_FREE ? "hidden" : "switch"
					),
				'related_style' => array(
					"title" => esc_html__('Related posts style', 'hogwords'),
					"desc" => wp_kses_data( __('Select style of the related posts output', 'hogwords') ),
					"dependency" => array(
						'show_related_posts' => array(1)
					),
					"std" => 2,
					"options" => hogwords_get_list_styles(1,2),
					"type" => HOGWORDS_THEME_FREE ? "hidden" : "switch"
					),
			'blog_end' => array(
				"type" => "panel_end",
				),
			
		
		
			// 'Colors'
			'panel_colors' => array(
				"title" => esc_html__('Colors', 'hogwords'),
				"desc" => '',
				"priority" => 300,
				"type" => "section"
				),

			'color_schemes_info' => array(
				"title" => esc_html__('Color schemes', 'hogwords'),
				"desc" => wp_kses_data( __('Color schemes for various parts of the site. "Inherit" means that this block is used the Site color scheme (the first parameter)', 'hogwords') ),
				"type" => "info",
				),
			'color_scheme' => array(
				"title" => esc_html__('Site Color Scheme', 'hogwords'),
				"desc" => '',
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Colors', 'hogwords')
				),
				"std" => 'default',
				"options" => array(),
				"refresh" => false,
				"type" => "switch"
				),
			'header_scheme' => array(
				"title" => esc_html__('Header Color Scheme', 'hogwords'),
				"desc" => '',
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Colors', 'hogwords')
				),
				"std" => 'inherit',
				"options" => array(),
				"refresh" => false,
				"type" => "switch"
				),
			'menu_scheme' => array(
				"title" => esc_html__('Sidemenu Color Scheme', 'hogwords'),
				"desc" => '',
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Colors', 'hogwords')
				),
				"std" => 'inherit',
				"options" => array(),
				"refresh" => false,
				"type" => HOGWORDS_THEME_FREE ? "hidden" : "switch"
				),
			'sidebar_scheme' => array(
				"title" => esc_html__('Sidebar Color Scheme', 'hogwords'),
				"desc" => '',
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Colors', 'hogwords')
				),
				"std" => 'inherit',
				"options" => array(),
				"refresh" => false,
				"type" => "switch"
				),
			'footer_scheme' => array(
				"title" => esc_html__('Footer Color Scheme', 'hogwords'),
				"desc" => '',
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Colors', 'hogwords')
				),
				"std" => 'inherit',
				"options" => array(),
				"refresh" => false,
				"type" => "switch"
				),

			'color_scheme_editor_info' => array(
				"title" => esc_html__('Color scheme editor', 'hogwords'),
				"desc" => wp_kses_data(__('Select color scheme to modify. Attention! Only those sections in the site will be changed which this scheme was assigned to', 'hogwords') ),
				"type" => "info",
				),
			'scheme_storage' => array(
				"title" => esc_html__('Color scheme editor', 'hogwords'),
				"desc" => '',
				"std" => '$hogwords_get_scheme_storage',
				"refresh" => false,
				"colorpicker" => "tiny",
				"type" => "scheme_editor"
				),


			// 'Hidden'
			'media_title' => array(
				"title" => esc_html__('Media title', 'hogwords'),
				"desc" => wp_kses_data( __('Used as title for the audio and video item in this post', 'hogwords') ),
				"override" => array(
					'mode' => 'post',
					'section' => esc_html__('Content', 'hogwords')
				),
				"hidden" => true,
				"std" => '',
				"type" => HOGWORDS_THEME_FREE ? "hidden" : "text"
				),
			'media_author' => array(
				"title" => esc_html__('Media author', 'hogwords'),
				"desc" => wp_kses_data( __('Used as author name for the audio and video item in this post', 'hogwords') ),
				"override" => array(
					'mode' => 'post',
					'section' => esc_html__('Content', 'hogwords')
				),
				"hidden" => true,
				"std" => '',
				"type" => HOGWORDS_THEME_FREE ? "hidden" : "text"
				),


			// Internal options.
			// Attention! Don't change any options in the section below!
			// Use huge priority to call render this elements after all options!
			'reset_options' => array(
				"title" => '',
				"desc" => '',
				"std" => '0',
				"priority" => 10000,
				"type" => "hidden",
				),

			'last_option' => array(		// Need to manually call action to include Tiny MCE scripts
				"title" => '',
				"desc" => '',
				"std" => 1,
				"type" => "hidden",
				),

		));


		// Prepare panel 'Fonts'
		$fonts = array(
		
			// 'Fonts'
			'fonts' => array(
				"title" => esc_html__('Typography', 'hogwords'),
				"desc" => '',
				"priority" => 200,
				"type" => "panel"
				),

			// Fonts - Load_fonts
			'load_fonts' => array(
				"title" => esc_html__('Load fonts', 'hogwords'),
				"desc" => wp_kses_data( __('Specify fonts to load when theme start. You can use them in the base theme elements: headers, text, menu, links, input fields, etc.', 'hogwords') )
						. '<br>'
						. wp_kses_data( __('<b>Attention!</b> Press "Refresh" button to reload preview area after the all fonts are changed', 'hogwords') ),
				"type" => "section"
				),
			'load_fonts_subset' => array(
				"title" => esc_html__('Google fonts subsets', 'hogwords'),
				"desc" => wp_kses_data( __('Specify comma separated list of the subsets which will be load from Google fonts', 'hogwords') )
						. '<br>'
						. wp_kses_data( __('Available subsets are: latin,latin-ext,cyrillic,cyrillic-ext,greek,greek-ext,vietnamese', 'hogwords') ),
				"class" => "hogwords_column-1_3 hogwords_new_row",
				"refresh" => false,
				"std" => '$hogwords_get_load_fonts_subset',
				"type" => "text"
				)
		);

		for ($i=1; $i<=hogwords_get_theme_setting('max_load_fonts'); $i++) {
			if (hogwords_get_value_gp('page') != 'theme_options') {
				$fonts["load_fonts-{$i}-info"] = array(
					// Translators: Add font's number - 'Font 1', 'Font 2', etc
					"title" => esc_html(sprintf(esc_html__('Font %s', 'hogwords'), $i)),
					"desc" => '',
					"type" => "info",
					);
			}
			$fonts["load_fonts-{$i}-name"] = array(
				"title" => esc_html__('Font name', 'hogwords'),
				"desc" => '',
				"class" => "hogwords_column-1_3 hogwords_new_row",
				"refresh" => false,
				"std" => '$hogwords_get_load_fonts_option',
				"type" => "text"
				);
			$fonts["load_fonts-{$i}-family"] = array(
				"title" => esc_html__('Font family', 'hogwords'),
				"desc" => $i==1 
							? wp_kses_data( __('Select font family to use it if font above is not available', 'hogwords') )
							: '',
				"class" => "hogwords_column-1_3",
				"refresh" => false,
				"std" => '$hogwords_get_load_fonts_option',
				"options" => array(
					'inherit' => esc_html__("Inherit", 'hogwords'),
					'serif' => esc_html__('serif', 'hogwords'),
					'sans-serif' => esc_html__('sans-serif', 'hogwords'),
					'monospace' => esc_html__('monospace', 'hogwords'),
					'cursive' => esc_html__('cursive', 'hogwords'),
					'fantasy' => esc_html__('fantasy', 'hogwords')
				),
				"type" => "select"
				);
			$fonts["load_fonts-{$i}-styles"] = array(
				"title" => esc_html__('Font styles', 'hogwords'),
				"desc" => $i==1 
							? wp_kses_data( __('Font styles used only for the Google fonts. This is a comma separated list of the font weight and styles. For example: 400,400italic,700', 'hogwords') )
								. '<br>'
								. wp_kses_data( __('<b>Attention!</b> Each weight and style increase download size! Specify only used weights and styles.', 'hogwords') )
							: '',
				"class" => "hogwords_column-1_3",
				"refresh" => false,
				"std" => '$hogwords_get_load_fonts_option',
				"type" => "text"
				);
		}
		$fonts['load_fonts_end'] = array(
			"type" => "section_end"
			);

		// Fonts - H1..6, P, Info, Menu, etc.
		$theme_fonts = hogwords_get_theme_fonts();
		foreach ($theme_fonts as $tag=>$v) {
			$fonts["{$tag}_section"] = array(
				"title" => !empty($v['title']) 
								? $v['title'] 
								// Translators: Add tag's name to make title 'H1 settings', 'P settings', etc.
								: esc_html(sprintf(esc_html__('%s settings', 'hogwords'), $tag)),
				"desc" => !empty($v['description']) 
								? $v['description'] 
								// Translators: Add tag's name to make description
								: wp_kses_post( sprintf(__('Font settings of the "%s" tag.', 'hogwords'), $tag) ),
				"type" => "section",
				);
	
			foreach ($v as $css_prop=>$css_value) {
				if (in_array($css_prop, array('title', 'description'))) continue;
				$options = '';
				$type = 'text';
				$title = ucfirst(str_replace('-', ' ', $css_prop));
				if ($css_prop == 'font-family') {
					$type = 'select';
					$options = array();
				} else if ($css_prop == 'font-weight') {
					$type = 'select';
					$options = array(
						'inherit' => esc_html__("Inherit", 'hogwords'),
						'100' => esc_html__('100 (Light)', 'hogwords'), 
						'200' => esc_html__('200 (Light)', 'hogwords'), 
						'300' => esc_html__('300 (Thin)',  'hogwords'),
						'400' => esc_html__('400 (Normal)', 'hogwords'),
						'500' => esc_html__('500 (Semibold)', 'hogwords'),
						'600' => esc_html__('600 (Semibold)', 'hogwords'),
						'700' => esc_html__('700 (Bold)', 'hogwords'),
						'800' => esc_html__('800 (Black)', 'hogwords'),
						'900' => esc_html__('900 (Black)', 'hogwords')
					);
				} else if ($css_prop == 'font-style') {
					$type = 'select';
					$options = array(
						'inherit' => esc_html__("Inherit", 'hogwords'),
						'normal' => esc_html__('Normal', 'hogwords'), 
						'italic' => esc_html__('Italic', 'hogwords')
					);
				} else if ($css_prop == 'text-decoration') {
					$type = 'select';
					$options = array(
						'inherit' => esc_html__("Inherit", 'hogwords'),
						'none' => esc_html__('None', 'hogwords'), 
						'underline' => esc_html__('Underline', 'hogwords'),
						'overline' => esc_html__('Overline', 'hogwords'),
						'line-through' => esc_html__('Line-through', 'hogwords')
					);
				} else if ($css_prop == 'text-transform') {
					$type = 'select';
					$options = array(
						'inherit' => esc_html__("Inherit", 'hogwords'),
						'none' => esc_html__('None', 'hogwords'), 
						'uppercase' => esc_html__('Uppercase', 'hogwords'),
						'lowercase' => esc_html__('Lowercase', 'hogwords'),
						'capitalize' => esc_html__('Capitalize', 'hogwords')
					);
				}
				$fonts["{$tag}_{$css_prop}"] = array(
					"title" => $title,
					"desc" => '',
					"class" => "hogwords_column-1_5",
					"refresh" => false,
					"std" => '$hogwords_get_theme_fonts_option',
					"options" => $options,
					"type" => $type
				);
			}
			
			$fonts["{$tag}_section_end"] = array(
				"type" => "section_end"
				);
		}

		$fonts['fonts_end'] = array(
			"type" => "panel_end"
			);

		// Add fonts parameters to Theme Options
		hogwords_storage_set_array_before('options', 'panel_colors', $fonts);

		// Add Header Video if WP version < 4.7
		if (!function_exists('get_header_video_url')) {
			hogwords_storage_set_array_after('options', 'header_image_override', 'header_video', array(
				"title" => esc_html__('Header video', 'hogwords'),
				"desc" => wp_kses_data( __("Select video to use it as background for the header", 'hogwords') ),
				"override" => array(
					'mode' => 'page',
					'section' => esc_html__('Header', 'hogwords')
				),
				"std" => '',
				"type" => "video"
				)
			);
		}

		// Add option 'logo' if WP version < 4.5
		// or 'custom_logo' if current page is 'Theme Options'
		if (!function_exists('the_custom_logo') || (isset($_REQUEST['page']) && $_REQUEST['page']=='theme_options')) {
			hogwords_storage_set_array_before('options', 'logo_retina', function_exists('the_custom_logo') ? 'custom_logo' : 'logo', array(
				"title" => esc_html__('Logo', 'hogwords'),
				"desc" => wp_kses_data( __('Select or upload the site logo', 'hogwords') ),
				"class" => "hogwords_column-1_2 hogwords_new_row",
				"priority" => 60,
				"std" => '',
				"type" => "image"
				)
			);
		}
	}
}


// Returns a list of options that can be overridden for CPT
if (!function_exists('hogwords_options_get_list_cpt_options')) {
	function hogwords_options_get_list_cpt_options($cpt, $title='') {
		if (empty($title)) $title = ucfirst($cpt);
		return array(
					"header_info_{$cpt}" => array(
						"title" => esc_html__('Header', 'hogwords'),
						"desc" => '',
						"type" => "info",
						),
					"header_type_{$cpt}" => array(
						"title" => esc_html__('Header style', 'hogwords'),
						"desc" => wp_kses_data( __('Choose whether to use the default header or header Layouts (available only if the ThemeREX Addons is activated)', 'hogwords') ),
						"std" => 'inherit',
						"options" => hogwords_get_list_header_footer_types(true),
						"type" => HOGWORDS_THEME_FREE ? "hidden" : "switch"
						),
					"header_style_{$cpt}" => array(
						"title" => esc_html__('Select custom layout', 'hogwords'),
						// Translators: Add CPT name to the description
						"desc" => wp_kses_data( sprintf(__('Select custom layout to display the site header on the %s pages', 'hogwords'), $title) ),
						"dependency" => array(
							"header_type_{$cpt}" => array('custom')
						),
						"std" => 'inherit',
						"options" => array(),
						"type" => HOGWORDS_THEME_FREE ? "hidden" : "select"
						),
					"header_position_{$cpt}" => array(
						"title" => esc_html__('Header position', 'hogwords'),
						// Translators: Add CPT name to the description
						"desc" => wp_kses_data( sprintf(__('Select position to display the site header on the %s pages', 'hogwords'), $title) ),
						"std" => 'inherit',
						"options" => array(),
						"type" => HOGWORDS_THEME_FREE ? "hidden" : "switch"
						),
					"header_image_override_{$cpt}" => array(
						"title" => esc_html__('Header image override', 'hogwords'),
						"desc" => wp_kses_data( __("Allow override the header image with the post's featured image", 'hogwords') ),
						"std" => 0,
						"type" => HOGWORDS_THEME_FREE ? "hidden" : "checkbox"
						),
					"header_widgets_{$cpt}" => array(
						"title" => esc_html__('Header widgets', 'hogwords'),
						// Translators: Add CPT name to the description
						"desc" => wp_kses_data( sprintf(__('Select set of widgets to show in the header on the %s pages', 'hogwords'), $title) ),
						"std" => 'hide',
						"options" => array(),
						"type" => "select"
						),
						
					"sidebar_info_{$cpt}" => array(
						"title" => esc_html__('Sidebar', 'hogwords'),
						"desc" => '',
						"type" => "info",
						),
					"sidebar_position_{$cpt}" => array(
						"title" => esc_html__('Sidebar position', 'hogwords'),
						// Translators: Add CPT name to the description
						"desc" => wp_kses_data( sprintf(__('Select position to show sidebar on the %s pages', 'hogwords'), $title) ),
						"refresh" => false,
						"std" => 'left',
						"options" => array(),
						"type" => "switch"
						),
					"sidebar_widgets_{$cpt}" => array(
						"title" => esc_html__('Sidebar widgets', 'hogwords'),
						// Translators: Add CPT name to the description
						"desc" => wp_kses_data( sprintf(__('Select sidebar to show on the %s pages', 'hogwords'), $title) ),
						"dependency" => array(
							"sidebar_position_{$cpt}" => array('left', 'right')
						),
						"std" => 'hide',
						"options" => array(),
						"type" => "select"
						),
					"hide_sidebar_on_single_{$cpt}" => array(
						"title" => esc_html__('Hide sidebar on the single pages', 'hogwords'),
						"desc" => wp_kses_data( __("Hide sidebar on the single page", 'hogwords') ),
						"std" => 0,
						"type" => "checkbox"
						),
						
					"footer_info_{$cpt}" => array(
						"title" => esc_html__('Footer', 'hogwords'),
						"desc" => '',
						"type" => "info",
						),
					"footer_type_{$cpt}" => array(
						"title" => esc_html__('Footer style', 'hogwords'),
						"desc" => wp_kses_data( __('Choose whether to use the default footer or footer Layouts (available only if the ThemeREX Addons is activated)', 'hogwords') ),
						"std" => 'inherit',
						"options" => hogwords_get_list_header_footer_types(true),
						"type" => HOGWORDS_THEME_FREE ? "hidden" : "switch"
						),
					"footer_style_{$cpt}" => array(
						"title" => esc_html__('Select custom layout', 'hogwords'),
						"desc" => wp_kses_data( __('Select custom layout to display the site footer', 'hogwords') ),
						"std" => 'inherit',
						"dependency" => array(
							"footer_type_{$cpt}" => array('custom')
						),
						"options" => array(),
						"type" => HOGWORDS_THEME_FREE ? "hidden" : "select"
						),
					"footer_widgets_{$cpt}" => array(
						"title" => esc_html__('Footer widgets', 'hogwords'),
						"desc" => wp_kses_data( __('Select set of widgets to show in the footer', 'hogwords') ),
						"dependency" => array(
							"footer_type_{$cpt}" => array('default')
						),
						"std" => 'footer_widgets',
						"options" => array(),
						"type" => "select"
						),
					"footer_columns_{$cpt}" => array(
						"title" => esc_html__('Footer columns', 'hogwords'),
						"desc" => wp_kses_data( __('Select number columns to show widgets in the footer. If 0 - autodetect by the widgets count', 'hogwords') ),
						"dependency" => array(
							"footer_type_{$cpt}" => array('default'),
							"footer_widgets_{$cpt}" => array('^hide')
						),
						"std" => 3,
						"options" => hogwords_get_list_range(0,6),
						"type" => "select"
						),
					"footer_wide_{$cpt}" => array(
						"title" => esc_html__('Footer fullwide', 'hogwords'),
						"desc" => wp_kses_data( __('Do you want to stretch the footer to the entire window width?', 'hogwords') ),
						"dependency" => array(
							"footer_type_{$cpt}" => array('default')
						),
						"std" => 0,
						"type" => "checkbox"
						),
						
					"widgets_info_{$cpt}" => array(
						"title" => esc_html__('Additional panels', 'hogwords'),
						"desc" => '',
						"type" => HOGWORDS_THEME_FREE ? "hidden" : "info",
						),
					"widgets_above_page_{$cpt}" => array(
						"title" => esc_html__('Widgets at the top of the page', 'hogwords'),
						"desc" => wp_kses_data( __('Select widgets to show at the top of the page (above content and sidebar)', 'hogwords') ),
						"std" => 'hide',
						"options" => array(),
						"type" => HOGWORDS_THEME_FREE ? "hidden" : "select"
						),
					"widgets_above_content_{$cpt}" => array(
						"title" => esc_html__('Widgets above the content', 'hogwords'),
						"desc" => wp_kses_data( __('Select widgets to show at the beginning of the content area', 'hogwords') ),
						"std" => 'hide',
						"options" => array(),
						"type" => HOGWORDS_THEME_FREE ? "hidden" : "select"
						),
					"widgets_below_content_{$cpt}" => array(
						"title" => esc_html__('Widgets below the content', 'hogwords'),
						"desc" => wp_kses_data( __('Select widgets to show at the ending of the content area', 'hogwords') ),
						"std" => 'hide',
						"options" => array(),
						"type" => HOGWORDS_THEME_FREE ? "hidden" : "select"
						),
					"widgets_below_page_{$cpt}" => array(
						"title" => esc_html__('Widgets at the bottom of the page', 'hogwords'),
						"desc" => wp_kses_data( __('Select widgets to show at the bottom of the page (below content and sidebar)', 'hogwords') ),
						"std" => 'hide',
						"options" => array(),
						"type" => HOGWORDS_THEME_FREE ? "hidden" : "select"
						)
					);
	}
}


// Return lists with choises when its need in the admin mode
if (!function_exists('hogwords_options_get_list_choises')) {
	add_filter('hogwords_filter_options_get_list_choises', 'hogwords_options_get_list_choises', 10, 2);
	function hogwords_options_get_list_choises($list, $id) {
		if (is_array($list) && count($list)==0) {
			if (strpos($id, 'header_style')===0)
				$list = hogwords_get_list_header_styles(strpos($id, 'header_style_')===0);
			else if (strpos($id, 'header_position')===0)
				$list = hogwords_get_list_header_positions(strpos($id, 'header_position_')===0);
			else if (strpos($id, 'header_widgets')===0)
				$list = hogwords_get_list_sidebars(strpos($id, 'header_widgets_')===0, true);
			else if (substr($id, -7) == '_scheme')
				$list = hogwords_get_list_schemes($id!='color_scheme');
			else if (strpos($id, 'sidebar_widgets')===0)
				$list = hogwords_get_list_sidebars(strpos($id, 'sidebar_widgets_')===0, true);
			else if (strpos($id, 'sidebar_position')===0)
				$list = hogwords_get_list_sidebars_positions(strpos($id, 'sidebar_position_')===0);
			else if (strpos($id, 'widgets_above_page')===0)
				$list = hogwords_get_list_sidebars(strpos($id, 'widgets_above_page_')===0, true);
			else if (strpos($id, 'widgets_above_content')===0)
				$list = hogwords_get_list_sidebars(strpos($id, 'widgets_above_content_')===0, true);
			else if (strpos($id, 'widgets_below_page')===0)
				$list = hogwords_get_list_sidebars(strpos($id, 'widgets_below_page_')===0, true);
			else if (strpos($id, 'widgets_below_content')===0)
				$list = hogwords_get_list_sidebars(strpos($id, 'widgets_below_content_')===0, true);
			else if (strpos($id, 'footer_style')===0)
				$list = hogwords_get_list_footer_styles(strpos($id, 'footer_style_')===0);
			else if (strpos($id, 'footer_widgets')===0)
				$list = hogwords_get_list_sidebars(strpos($id, 'footer_widgets_')===0, true);
			else if (strpos($id, 'blog_style')===0)
				$list = hogwords_get_list_blog_styles(strpos($id, 'blog_style_')===0);
			else if (strpos($id, 'post_type')===0)
				$list = hogwords_get_list_posts_types();
			else if (strpos($id, 'parent_cat')===0)
				$list = hogwords_array_merge(array(0 => esc_html__('- Select category -', 'hogwords')), hogwords_get_list_categories());
			else if (strpos($id, 'blog_animation')===0)
				$list = hogwords_get_list_animations_in();
			else if ($id == 'color_scheme_editor')
				$list = hogwords_get_list_schemes();
			else if (strpos($id, '_font-family') > 0)
				$list = hogwords_get_list_load_fonts(true);
		}
		return $list;
	}
}
?>