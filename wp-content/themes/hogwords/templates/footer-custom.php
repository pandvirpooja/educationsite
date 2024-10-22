<?php
/**
 * The template to display default site footer
 *
 * @package WordPress
 * @subpackage HOGWORDS
 * @since HOGWORDS 1.0.10
 */

$hogwords_footer_scheme =  hogwords_is_inherit(hogwords_get_theme_option('footer_scheme')) ? hogwords_get_theme_option('color_scheme') : hogwords_get_theme_option('footer_scheme');
$hogwords_footer_id = str_replace('footer-custom-', '', hogwords_get_theme_option("footer_style"));
if ((int) $hogwords_footer_id == 0) {
	$hogwords_footer_id = hogwords_get_post_id(array(
												'name' => $hogwords_footer_id,
												'post_type' => defined('TRX_ADDONS_CPT_LAYOUTS_PT') ? TRX_ADDONS_CPT_LAYOUTS_PT : 'cpt_layouts'
												)
											);
} else {
	$hogwords_footer_id = apply_filters('hogwords_filter_get_translated_layout', $hogwords_footer_id);
}
$hogwords_footer_meta = get_post_meta($hogwords_footer_id, 'trx_addons_options', true);
?>
<footer class="footer_wrap footer_custom footer_custom_<?php echo esc_attr($hogwords_footer_id); 
						?> footer_custom_<?php echo esc_attr(sanitize_title(get_the_title($hogwords_footer_id))); 
						if (!empty($hogwords_footer_meta['margin']) != '') 
							echo ' '.esc_attr(hogwords_add_inline_css_class('margin-top: '.hogwords_prepare_css_value($hogwords_footer_meta['margin']).';'));
						?> scheme_<?php echo esc_attr($hogwords_footer_scheme); 
						?>">
	<?php
    // Custom footer's layout
    do_action('hogwords_action_show_layout', $hogwords_footer_id);
	?>
</footer><!-- /.footer_wrap -->
