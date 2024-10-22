<?php
/**
 * The template to display the widgets area in the header
 *
 * @package WordPress
 * @subpackage HOGWORDS
 * @since HOGWORDS 1.0
 */

// Header sidebar
$hogwords_header_name = hogwords_get_theme_option('header_widgets');
$hogwords_header_present = !hogwords_is_off($hogwords_header_name) && is_active_sidebar($hogwords_header_name);
if ($hogwords_header_present) { 
	hogwords_storage_set('current_sidebar', 'header');
	$hogwords_header_wide = hogwords_get_theme_option('header_wide');
	ob_start();
	if ( is_active_sidebar($hogwords_header_name) ) {
		dynamic_sidebar($hogwords_header_name);
	}
	$hogwords_widgets_output = ob_get_contents();
	ob_end_clean();
	if (!empty($hogwords_widgets_output)) {
		$hogwords_widgets_output = preg_replace("/<\/aside>[\r\n\s]*<aside/", "</aside><aside", $hogwords_widgets_output);
		$hogwords_need_columns = strpos($hogwords_widgets_output, 'columns_wrap')===false;
		if ($hogwords_need_columns) {
			$hogwords_columns = max(0, (int) hogwords_get_theme_option('header_columns'));
			if ($hogwords_columns == 0) $hogwords_columns = min(6, max(1, substr_count($hogwords_widgets_output, '<aside ')));
			if ($hogwords_columns > 1)
				$hogwords_widgets_output = preg_replace("/<aside([^>]*)class=\"widget/", "<aside$1class=\"column-1_".esc_attr($hogwords_columns).' widget', $hogwords_widgets_output);
			else
				$hogwords_need_columns = false;
		}
		?>
		<div class="header_widgets_wrap widget_area<?php echo !empty($hogwords_header_wide) ? ' header_fullwidth' : ' header_boxed'; ?>">
			<div class="header_widgets_inner widget_area_inner">
				<?php 
				if (!$hogwords_header_wide) { 
					?><div class="content_wrap"><?php
				}
				if ($hogwords_need_columns) {
					?><div class="columns_wrap"><?php
				}
				do_action( 'hogwords_action_before_sidebar' );
				hogwords_show_layout($hogwords_widgets_output);
				do_action( 'hogwords_action_after_sidebar' );
				if ($hogwords_need_columns) {
					?></div>	<!-- /.columns_wrap --><?php
				}
				if (!$hogwords_header_wide) {
					?></div>	<!-- /.content_wrap --><?php
				}
				?>
			</div>	<!-- /.header_widgets_inner -->
		</div>	<!-- /.header_widgets_wrap -->
		<?php
	}
}
?>