<?php
/**
 * The template to display the logo or the site name and the slogan in the Header
 *
 * @package WordPress
 * @subpackage HOGWORDS
 * @since HOGWORDS 1.0
 */

$hogwords_args = get_query_var('hogwords_logo_args');

// Site logo
$hogwords_logo_type   = isset($hogwords_args['type']) ? $hogwords_args['type'] : '';
$hogwords_logo_image  = hogwords_get_logo_image($hogwords_logo_type);
$hogwords_logo_text   = hogwords_is_on(hogwords_get_theme_option('logo_text')) ? get_bloginfo( 'name' ) : '';
$hogwords_logo_slogan = get_bloginfo( 'description', 'display' );
if (!empty($hogwords_logo_image) || !empty($hogwords_logo_text)) {
	?><a class="sc_layouts_logo" href="<?php echo is_front_page() ? '#' : esc_url(home_url('/')); ?>"><?php
		if (!empty($hogwords_logo_image)) {
			if (empty($hogwords_logo_type) && function_exists('the_custom_logo') && (int) $hogwords_logo_image > 0) {
				the_custom_logo();
			} else {
				$hogwords_attr = hogwords_getimagesize($hogwords_logo_image);
				echo '<img src="'.esc_url($hogwords_logo_image).'" alt="'. esc_attr(basename($hogwords_logo_image)).'"'.(!empty($hogwords_attr[3]) ? ' '.wp_kses_data($hogwords_attr[3]) : '').'>';
			}
		} else {
			hogwords_show_layout(hogwords_prepare_macros($hogwords_logo_text), '<span class="logo_text">', '</span>');
			hogwords_show_layout(hogwords_prepare_macros($hogwords_logo_slogan), '<span class="logo_slogan">', '</span>');
		}
	?></a><?php
}
?>