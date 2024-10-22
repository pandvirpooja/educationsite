<?php
/**
 * The template to display default site header
 *
 * @package WordPress
 * @subpackage HOGWORDS
 * @since HOGWORDS 1.0
 */


$hogwords_header_css = $hogwords_header_image = '';
$hogwords_header_video = hogwords_get_header_video();
if (true || empty($hogwords_header_video)) {
	$hogwords_header_image = get_header_image();
	if (hogwords_trx_addons_featured_image_override()) $hogwords_header_image = hogwords_get_current_mode_image($hogwords_header_image);
}

?><header class="top_panel top_panel_default<?php
					echo !empty($hogwords_header_image) || !empty($hogwords_header_video) ? ' with_bg_image' : ' without_bg_image';
					if ($hogwords_header_video!='') echo ' with_bg_video';
					if ($hogwords_header_image!='') echo ' '.esc_attr(hogwords_add_inline_css_class('background-image: url('.esc_url($hogwords_header_image).');'));
					if (is_single() && has_post_thumbnail()) echo ' with_featured_image';
					if (hogwords_is_on(hogwords_get_theme_option('header_fullheight'))) echo ' header_fullheight hogwords-full-height';
					?> scheme_<?php echo esc_attr(hogwords_is_inherit(hogwords_get_theme_option('header_scheme')) 
													? hogwords_get_theme_option('color_scheme') 
													: hogwords_get_theme_option('header_scheme'));
					?>"><?php

	// Background video
	if (!empty($hogwords_header_video)) {
		get_template_part( 'templates/header-video' );
	}
	
	// Main menu
	if (hogwords_get_theme_option("menu_style") == 'top') {
		get_template_part( 'templates/header-navi' );
	}

	// Page title and breadcrumbs area
	get_template_part( 'templates/header-title');

	// Header widgets area
	get_template_part( 'templates/header-widgets' );


?></header>