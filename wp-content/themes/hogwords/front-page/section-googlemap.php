<div class="front_page_section front_page_section_googlemap<?php
			$hogwords_scheme = hogwords_get_theme_option('front_page_googlemap_scheme');
			if (!hogwords_is_inherit($hogwords_scheme)) echo ' scheme_'.esc_attr($hogwords_scheme);
			echo ' front_page_section_paddings_'.esc_attr(hogwords_get_theme_option('front_page_googlemap_paddings'));
		?>"<?php
		$hogwords_css = '';
		$hogwords_bg_image = hogwords_get_theme_option('front_page_googlemap_bg_image');
		if (!empty($hogwords_bg_image)) 
			$hogwords_css .= 'background-image: url('.esc_url(hogwords_get_attachment_url($hogwords_bg_image)).');';
		if (!empty($hogwords_css))
			echo ' style="' . esc_attr($hogwords_css) . '"';
?>><?php
	// Add anchor
	$hogwords_anchor_icon = hogwords_get_theme_option('front_page_googlemap_anchor_icon');	
	$hogwords_anchor_text = hogwords_get_theme_option('front_page_googlemap_anchor_text');	
	if ((!empty($hogwords_anchor_icon) || !empty($hogwords_anchor_text)) && shortcode_exists('trx_sc_anchor')) {
		echo do_shortcode('[trx_sc_anchor id="front_page_section_googlemap"'
										. (!empty($hogwords_anchor_icon) ? ' icon="'.esc_attr($hogwords_anchor_icon).'"' : '')
										. (!empty($hogwords_anchor_text) ? ' title="'.esc_attr($hogwords_anchor_text).'"' : '')
										. ']');
	}
	?>
	<div class="front_page_section_inner front_page_section_googlemap_inner<?php
			if (hogwords_get_theme_option('front_page_googlemap_fullheight'))
				echo ' hogwords-full-height sc_layouts_flex sc_layouts_columns_middle';
			?>"<?php
			$hogwords_css = '';
			$hogwords_bg_mask = hogwords_get_theme_option('front_page_googlemap_bg_mask');
			$hogwords_bg_color = hogwords_get_theme_option('front_page_googlemap_bg_color');
			if (!empty($hogwords_bg_color) && $hogwords_bg_mask > 0)
				$hogwords_css .= 'background-color: '.esc_attr($hogwords_bg_mask==1
																	? $hogwords_bg_color
																	: hogwords_hex2rgba($hogwords_bg_color, $hogwords_bg_mask)
																).';';
			if (!empty($hogwords_css))
				echo ' style="' . esc_attr($hogwords_css) . '"';
	?>>
		<div class="front_page_section_content_wrap front_page_section_googlemap_content_wrap<?php
			$hogwords_layout = hogwords_get_theme_option('front_page_googlemap_layout');
			if ($hogwords_layout != 'fullwidth')
				echo ' content_wrap';
		?>">
			<?php
			// Content wrap with title and description
			$hogwords_caption = hogwords_get_theme_option('front_page_googlemap_caption');
			$hogwords_description = hogwords_get_theme_option('front_page_googlemap_description');
			if (!empty($hogwords_caption) || !empty($hogwords_description) || (current_user_can('edit_theme_options') && is_customize_preview())) {
				if ($hogwords_layout == 'fullwidth') {
					?><div class="content_wrap"><?php
				}
					// Caption
					if (!empty($hogwords_caption) || (current_user_can('edit_theme_options') && is_customize_preview())) {
						?><h2 class="front_page_section_caption front_page_section_googlemap_caption front_page_block_<?php echo !empty($hogwords_caption) ? 'filled' : 'empty'; ?>"><?php
							echo wp_kses($hogwords_caption, 'hogwords_kses_content');
						?></h2><?php
					}
				
					// Description (text)
					if (!empty($hogwords_description) || (current_user_can('edit_theme_options') && is_customize_preview())) {
						?><div class="front_page_section_description front_page_section_googlemap_description front_page_block_<?php echo !empty($hogwords_description) ? 'filled' : 'empty'; ?>"><?php
							echo wp_kses(wpautop($hogwords_description), 'hogwords_kses_content');
						?></div><?php
					}
				if ($hogwords_layout == 'fullwidth') {
					?></div><?php
				}
			}

			// Content (text)
			$hogwords_content = hogwords_get_theme_option('front_page_googlemap_content');
			if (!empty($hogwords_content) || (current_user_can('edit_theme_options') && is_customize_preview())) {
				if ($hogwords_layout == 'columns') {
					?><div class="front_page_section_columns front_page_section_googlemap_columns columns_wrap">
						<div class="column-1_3">
					<?php
				} else if ($hogwords_layout == 'fullwidth') {
					?><div class="content_wrap"><?php
				}
	
				?><div class="front_page_section_content front_page_section_googlemap_content front_page_block_<?php echo !empty($hogwords_content) ? 'filled' : 'empty'; ?>"><?php
					echo wp_kses($hogwords_content, 'hogwords_kses_content');
				?></div><?php
	
				if ($hogwords_layout == 'columns') {
					?></div><div class="column-2_3"><?php
				} else if ($hogwords_layout == 'fullwidth') {
					?></div><?php
				}
			}
			
			// Widgets output
			?><div class="front_page_section_output front_page_section_googlemap_output"><?php 
				if (is_active_sidebar('front_page_googlemap_widgets')) {
					dynamic_sidebar( 'front_page_googlemap_widgets' );
				} else if (current_user_can( 'edit_theme_options' )) {
					if (!hogwords_exists_trx_addons())
						hogwords_customizer_need_trx_addons_message();
					else
						hogwords_customizer_need_widgets_message('front_page_googlemap_caption', 'ThemeREX Addons - Google map');
				}
			?></div><?php

			if ($hogwords_layout == 'columns' && (!empty($hogwords_content) || (current_user_can('edit_theme_options') && is_customize_preview()))) {
				?></div></div><?php
			}
			?>			
		</div>
	</div>
</div>