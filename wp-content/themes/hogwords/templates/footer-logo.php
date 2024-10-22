<?php
/**
 * The template to display the site logo in the footer
 *
 * @package WordPress
 * @subpackage HOGWORDS
 * @since HOGWORDS 1.0.10
 */

// Logo
if (hogwords_is_on(hogwords_get_theme_option('logo_in_footer'))) {
	$hogwords_logo_image = '';
	if (hogwords_is_on(hogwords_get_theme_option('logo_retina_enabled')) && hogwords_get_retina_multiplier(2) > 1)
		$hogwords_logo_image = hogwords_get_theme_option( 'logo_footer_retina' );
	if (empty($hogwords_logo_image)) 
		$hogwords_logo_image = hogwords_get_theme_option( 'logo_footer' );
	$hogwords_logo_text   = get_bloginfo( 'name' );
	if (!empty($hogwords_logo_image) || !empty($hogwords_logo_text)) {
		?>
		<div class="footer_logo_wrap">
			<div class="footer_logo_inner">
				<?php
				if (!empty($hogwords_logo_image)) {
					$hogwords_attr = hogwords_getimagesize($hogwords_logo_image);
					echo '<a href="'.esc_url(home_url('/')).'"><img src="'.esc_url($hogwords_logo_image).'" class="logo_footer_image" alt="'. esc_attr(basename($hogwords_logo_image)).'"'.(!empty($hogwords_attr[3]) ? ' ' . wp_kses_data($hogwords_attr[3]) : '').'></a>' ;
				} else if (!empty($hogwords_logo_text)) {
					echo '<h1 class="logo_footer_text"><a href="'.esc_url(home_url('/')).'">' . esc_html($hogwords_logo_text) . '</a></h1>';
				}
				?>
			</div>
		</div>
		<?php
	}
}
?>