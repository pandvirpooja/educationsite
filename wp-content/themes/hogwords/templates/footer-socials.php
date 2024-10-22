<?php
/**
 * The template to display the socials in the footer
 *
 * @package WordPress
 * @subpackage HOGWORDS
 * @since HOGWORDS 1.0.10
 */


// Socials
if ( hogwords_is_on(hogwords_get_theme_option('socials_in_footer')) && ($hogwords_output = hogwords_get_socials_links()) != '') {
	?>
	<div class="footer_socials_wrap socials_wrap">
		<div class="footer_socials_inner">
			<?php hogwords_show_layout($hogwords_output); ?>
		</div>
	</div>
	<?php
}
?>