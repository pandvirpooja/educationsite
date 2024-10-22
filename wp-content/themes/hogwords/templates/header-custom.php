<?php
/**
 * The template to display custom header from the ThemeREX Addons Layouts
 *
 * @package WordPress
 * @subpackage HOGWORDS
 * @since HOGWORDS 1.0.06
 */

$hogwords_header_css = $hogwords_header_image = '';
$hogwords_header_video = hogwords_get_header_video();
if (true || empty($hogwords_header_video)) {
	$hogwords_header_image = get_header_image();
	if (hogwords_trx_addons_featured_image_override()) $hogwords_header_image = hogwords_get_current_mode_image($hogwords_header_image);
}

$hogwords_header_id = str_replace('header-custom-', '', hogwords_get_theme_option("header_style"));
if ((int) $hogwords_header_id == 0) {
	$hogwords_header_id = hogwords_get_post_id(array(
												'name' => $hogwords_header_id,
												'post_type' => defined('TRX_ADDONS_CPT_LAYOUTS_PT') ? TRX_ADDONS_CPT_LAYOUTS_PT : 'cpt_layouts'
												)
											);
} else {
	$hogwords_header_id = apply_filters('hogwords_filter_get_translated_layout', $hogwords_header_id);
}
$hogwords_header_meta = get_post_meta($hogwords_header_id, 'trx_addons_options', true);

?><header class="top_panel top_panel_custom top_panel_custom_<?php echo esc_attr($hogwords_header_id); 
				?> top_panel_custom_<?php echo esc_attr(sanitize_title(get_the_title($hogwords_header_id)));
				echo !empty($hogwords_header_image) || !empty($hogwords_header_video) 
					? ' with_bg_image' 
					: ' without_bg_image';
				if ($hogwords_header_video!='') 
					echo ' with_bg_video';
				if ($hogwords_header_image!='') 
					echo ' '.esc_attr(hogwords_add_inline_css_class('background-image: url('.esc_url($hogwords_header_image).');'));
				if (!empty($hogwords_header_meta['margin']) != '') 
					echo ' '.esc_attr(hogwords_add_inline_css_class('margin-bottom: '.esc_attr(hogwords_prepare_css_value($hogwords_header_meta['margin'])).';'));
				if (is_single() && has_post_thumbnail()) 
					echo ' with_featured_image';
				if (hogwords_is_on(hogwords_get_theme_option('header_fullheight'))) 
					echo ' header_fullheight hogwords-full-height';
				?> scheme_<?php echo esc_attr(hogwords_is_inherit(hogwords_get_theme_option('header_scheme')) 
												? hogwords_get_theme_option('color_scheme') 
												: hogwords_get_theme_option('header_scheme'));
				?>"><?php

	// Background video
	if (!empty($hogwords_header_video)) {
		get_template_part( 'templates/header-video' );
	}
		
	// Custom header's layout
	do_action('hogwords_action_show_layout', $hogwords_header_id);

	// Header widgets area
	get_template_part( 'templates/header-widgets' );
		
?></header>