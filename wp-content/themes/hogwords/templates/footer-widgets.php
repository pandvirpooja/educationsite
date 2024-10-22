<?php
/**
 * The template to display the widgets area in the footer
 *
 * @package WordPress
 * @subpackage HOGWORDS
 * @since HOGWORDS 1.0.10
 */

// Footer sidebar
$hogwords_footer_name = hogwords_get_theme_option('footer_widgets');
$hogwords_footer_present = !hogwords_is_off($hogwords_footer_name) && is_active_sidebar($hogwords_footer_name);
if ($hogwords_footer_present) { 
	hogwords_storage_set('current_sidebar', 'footer');
	$hogwords_footer_wide = hogwords_get_theme_option('footer_wide');
	ob_start();
	if ( is_active_sidebar($hogwords_footer_name) ) {
		dynamic_sidebar($hogwords_footer_name);
	}
	$hogwords_out = trim(ob_get_contents());
	ob_end_clean();
	if (!empty($hogwords_out)) {
		$hogwords_out = preg_replace("/<\\/aside>[\r\n\s]*<aside/", "</aside><aside", $hogwords_out);
		$hogwords_need_columns = true;
		if ($hogwords_need_columns) {
			$hogwords_columns = max(0, (int) hogwords_get_theme_option('footer_columns'));
			if ($hogwords_columns == 0) $hogwords_columns = min(4, max(1, substr_count($hogwords_out, '<aside ')));
			if ($hogwords_columns > 1)
				$hogwords_out = preg_replace("/<aside([^>]*)class=\"widget/", "<aside$1class=\"column-1_".esc_attr($hogwords_columns).' widget', $hogwords_out);
			else
				$hogwords_need_columns = false;
		}
		?>
		<div class="footer_widgets_wrap widget_area<?php echo !empty($hogwords_footer_wide) ? ' footer_fullwidth' : ''; ?> sc_layouts_row  sc_layouts_row_type_normal">
			<div class="footer_widgets_inner widget_area_inner">
				<?php 
				if (!$hogwords_footer_wide) { 
					?><div class="content_wrap"><?php
				}
				if ($hogwords_need_columns) {
					?><div class="columns_wrap"><?php
				}
				do_action( 'hogwords_action_before_sidebar' );
				hogwords_show_layout($hogwords_out);
				do_action( 'hogwords_action_after_sidebar' );
				if ($hogwords_need_columns) {
					?></div><!-- /.columns_wrap --><?php
				}
				if (!$hogwords_footer_wide) {
					?></div><!-- /.content_wrap --><?php
				}
				?>
			</div><!-- /.footer_widgets_inner -->
		</div><!-- /.footer_widgets_wrap -->
		<?php
	}
}
?>