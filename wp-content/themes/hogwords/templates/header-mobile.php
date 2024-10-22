<?php
/**
 * The template to show mobile header and menu
 *
 * @package WordPress
 * @subpackage HOGWORDS
 * @since HOGWORDS 1.0
 */

// Mobile header
if (hogwords_get_theme_option('header_mobile_enabled')) {
	$hogwords_header_css = $hogwords_header_image = '';
	$hogwords_header_image = get_header_image();
	if (hogwords_trx_addons_featured_image_override()) $hogwords_header_image = hogwords_get_current_mode_image($hogwords_header_image);
	?>
	<div class="top_panel_mobile<?php
						echo !empty($hogwords_header_image) ? ' with_bg_image' : ' without_bg_image';
						if ($hogwords_header_image!='') echo ' '.esc_attr(hogwords_add_inline_css_class('background-image: url('.esc_url($hogwords_header_image).');'));
						?> scheme_<?php echo esc_attr(hogwords_is_inherit(hogwords_get_theme_option('header_scheme')) 
														? hogwords_get_theme_option('color_scheme') 
														: hogwords_get_theme_option('header_scheme'));
						?>"><?php
		
		do_action('hogwords_action_before_header_mobile_info');

		// Additional info
		if (hogwords_is_off(hogwords_get_theme_option('header_mobile_hide_info')) && ($hogwords_info=hogwords_get_theme_option('header_mobile_additional_info'))!='') {
			?><div class="top_panel_mobile_info sc_layouts_row sc_layouts_row_type_compact sc_layouts_row_delimiter">
				<div class="content_wrap">
					<div class="columns_wrap">
						<div class="sc_layouts_column sc_layouts_column_align_center sc_layouts_column_icons_position_left column-1_1"><?php
							?><div class="sc_layouts_item"><?php
								hogwords_show_layout($hogwords_info);
							?></div><!-- /.sc_layouts_item -->
						</div><!-- /.sc_layouts_column -->
					</div><!-- /.columns_wrap -->
				</div><!-- /.content_wrap -->
			</div><!-- /.sc_layouts_row --><?php
		}

		do_action('hogwords_action_before_header_mobile_before_navi');

		?><div class="top_panel_mobile_navi sc_layouts_row sc_layouts_row_type_compact sc_layouts_row_delimiter sc_layouts_row_fixed sc_layouts_row_fixed_always">
			<div class="content_wrap">
				<div class="columns_wrap columns_fluid">
					<div class="sc_layouts_column sc_layouts_column_align_left sc_layouts_column_icons_position_left sc_layouts_column_fluid column-1_3"><?php
						do_action('hogwords_action_before_header_mobile_before_logo');
						// Logo
						if (hogwords_is_off(hogwords_get_theme_option('header_mobile_hide_logo'))) {
							?><div class="sc_layouts_item"><?php
								set_query_var('hogwords_logo_args', array('type' => 'mobile_header'));
								get_template_part( 'templates/header-logo' );
								set_query_var('hogwords_logo_args', array());
							?></div><?php
						}
						do_action('hogwords_action_before_header_mobile_after_logo');
					?></div><?php
					
					// Attention! Don't place any spaces between columns!
					?><div class="sc_layouts_column sc_layouts_column_align_right sc_layouts_column_icons_position_left sc_layouts_column_fluid  column-2_3"><?php
						if (hogwords_exists_trx_addons()) {
							do_action('hogwords_action_before_header_mobile_before_login');
							// Display login/logout
							if (hogwords_is_off(hogwords_get_theme_option('header_mobile_hide_login'))) {
								ob_start();
								do_action('hogwords_action_login', array('text_login' => false, 'text_logout' => false));
								$hogwords_action_output = ob_get_contents();
								ob_end_clean();
								if (!empty($hogwords_action_output)) {
									?><div class="sc_layouts_item sc_layouts_menu sc_layouts_menu_default"><?php
										hogwords_show_layout($hogwords_action_output);
									?></div><?php
								}
							}
							do_action('hogwords_action_before_header_mobile_before_cart');
							// Display cart button
							if (hogwords_is_off(hogwords_get_theme_option('header_mobile_hide_cart'))) {
								ob_start();
								do_action('hogwords_action_cart');
								$hogwords_action_output = ob_get_contents();
								ob_end_clean();
								if (!empty($hogwords_action_output)) {
									?><div class="sc_layouts_item"><?php
										hogwords_show_layout($hogwords_action_output);
									?></div><?php
								}
							}
							do_action('hogwords_action_before_header_mobile_before_search');
							// Display search field
							if (hogwords_is_off(hogwords_get_theme_option('header_mobile_hide_search'))) {
								ob_start();
								do_action('hogwords_action_search', 'fullscreen', 'header_mobile_search', false);
								$hogwords_action_output = ob_get_contents();
								ob_end_clean();
								if (!empty($hogwords_action_output)) {
									?><div class="sc_layouts_item"><?php
										hogwords_show_layout($hogwords_action_output);
									?></div><?php
								}
							}
						}

						do_action('hogwords_action_before_header_mobile_before_menu_button');
						
						// Mobile menu button
						?><div class="sc_layouts_item">
							<div class="sc_layouts_iconed_text sc_layouts_menu_mobile_button">
								<a class="sc_layouts_item_link sc_layouts_iconed_text_link" href="#">
									<span class="sc_layouts_item_icon sc_layouts_iconed_text_icon trx_addons_icon-menu"></span>
								</a>
							</div>
						</div><?php

						do_action('hogwords_action_before_header_mobile_after_menu_button');

					?></div><!-- /.sc_layouts_column -->
				</div><!-- /.columns_wrap -->
			</div><!-- /.content_wrap -->
		</div><!-- /.sc_layouts_row --><?php

		do_action('hogwords_action_before_header_mobile_after_navi');
		
	?></div><!-- /.top_panel_mobile --><?php
}

// Mobile menu
?>
<div class="menu_mobile_overlay"></div>
<div class="menu_mobile menu_mobile_<?php echo esc_attr(hogwords_get_theme_option('menu_mobile_fullscreen') > 0 ? 'fullscreen' : 'narrow'); ?> scheme_dark">
	<div class="menu_mobile_inner">
		<a class="menu_mobile_close icon-cancel"></a><?php

		// Logo
		set_query_var('hogwords_logo_args', array('type' => 'mobile'));
		get_template_part( 'templates/header-logo' );
		set_query_var('hogwords_logo_args', array());

		// Mobile menu
		$hogwords_menu_mobile = hogwords_get_nav_menu('menu_mobile');

		if (empty($hogwords_menu_mobile)) {
			$hogwords_menu_mobile = apply_filters('hogwords_filter_get_mobile_menu', '');

			if (empty($hogwords_menu_mobile)) $hogwords_menu_mobile = hogwords_get_nav_menu('menu_main');
			if (empty($hogwords_menu_mobile)) $hogwords_menu_mobile = hogwords_get_nav_menu();

		}
		if (!empty($hogwords_menu_mobile)) {

			if (!empty($hogwords_menu_mobile)){
				$hogwords_menu_mobile = str_replace(
					array('menu_main', 'id="menu-', 'sc_layouts_menu_nav', 'sc_layouts_hide_on_mobile', 'hide_on_mobile'),
					array('menu_mobile', 'id="menu_mobile-', '', '', ''),
					$hogwords_menu_mobile
					);}
			if (strpos($hogwords_menu_mobile, '<nav ')===false)
				$hogwords_menu_mobile = sprintf('<nav class="menu_mobile_nav_area">%s</nav>', $hogwords_menu_mobile);
			hogwords_show_layout(apply_filters('hogwords_filter_menu_mobile_layout', $hogwords_menu_mobile));
		}


		?>
	</div>
</div>
