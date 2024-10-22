<?php
/**
 * The Sidebar containing the main widget areas.
 *
 * @package WordPress
 * @subpackage HOGWORDS
 * @since HOGWORDS 1.0
 */

if (hogwords_sidebar_present()) {
	ob_start();
	$hogwords_sidebar_name = hogwords_get_theme_option('sidebar_widgets');
	hogwords_storage_set('current_sidebar', 'sidebar');
	if ( is_active_sidebar($hogwords_sidebar_name) ) {
		dynamic_sidebar($hogwords_sidebar_name);
	}
	$hogwords_out = trim(ob_get_contents());
	ob_end_clean();
	if (!empty($hogwords_out)) {
		$hogwords_sidebar_position = hogwords_get_theme_option('sidebar_position');
		?>
		<div class="sidebar <?php echo esc_attr($hogwords_sidebar_position); ?> widget_area<?php if (!hogwords_is_inherit(hogwords_get_theme_option('sidebar_scheme'))) echo ' scheme_'.esc_attr(hogwords_get_theme_option('sidebar_scheme')); ?>" role="complementary">
			<div class="sidebar_inner">
				<?php
				do_action( 'hogwords_action_before_sidebar' );
				hogwords_show_layout(preg_replace("/<\/aside>[\r\n\s]*<aside/", "</aside><aside", $hogwords_out));
				do_action( 'hogwords_action_after_sidebar' );
				?>
			</div><!-- /.sidebar_inner -->
		</div><!-- /.sidebar -->
		<?php
	}
}
?>