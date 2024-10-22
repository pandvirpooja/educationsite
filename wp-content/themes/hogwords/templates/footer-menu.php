<?php
/**
 * The template to display menu in the footer
 *
 * @package WordPress
 * @subpackage HOGWORDS
 * @since HOGWORDS 1.0.10
 */

// Footer menu
$hogwords_menu_footer = hogwords_get_nav_menu(array(
											'location' => 'menu_footer',
											'class' => 'sc_layouts_menu sc_layouts_menu_default'
											));
if (!empty($hogwords_menu_footer)) {
	?>
	<div class="footer_menu_wrap">
		<div class="footer_menu_inner">
			<?php hogwords_show_layout($hogwords_menu_footer); ?>
		</div>
	</div>
	<?php
}
?>