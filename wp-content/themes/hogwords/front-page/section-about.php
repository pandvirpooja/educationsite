<div class="front_page_section front_page_section_about<?php
			$hogwords_scheme = hogwords_get_theme_option('front_page_about_scheme');
			if (!hogwords_is_inherit($hogwords_scheme)) echo ' scheme_'.esc_attr($hogwords_scheme);
			echo ' front_page_section_paddings_'.esc_attr(hogwords_get_theme_option('front_page_about_paddings'));
		?>"<?php
		$hogwords_css = '';
		$hogwords_bg_image = hogwords_get_theme_option('front_page_about_bg_image');
		if (!empty($hogwords_bg_image)) 
			$hogwords_css .= 'background-image: url('.esc_url(hogwords_get_attachment_url($hogwords_bg_image)).');';
		if (!empty($hogwords_css))
			echo ' style="' . esc_attr($hogwords_css) . '"';
?>><?php
	// Add anchor
	$hogwords_anchor_icon = hogwords_get_theme_option('front_page_about_anchor_icon');	
	$hogwords_anchor_text = hogwords_get_theme_option('front_page_about_anchor_text');	
	if ((!empty($hogwords_anchor_icon) || !empty($hogwords_anchor_text)) && shortcode_exists('trx_sc_anchor')) {
		echo do_shortcode('[trx_sc_anchor id="front_page_section_about"'
										. (!empty($hogwords_anchor_icon) ? ' icon="'.esc_attr($hogwords_anchor_icon).'"' : '')
										. (!empty($hogwords_anchor_text) ? ' title="'.esc_attr($hogwords_anchor_text).'"' : '')
										. ']');
	}
	?>
	<div class="front_page_section_inner front_page_section_about_inner<?php
			if (hogwords_get_theme_option('front_page_about_fullheight'))
				echo ' hogwords-full-height sc_layouts_flex sc_layouts_columns_middle';
			?>"<?php
			$hogwords_css = '';
			$hogwords_bg_mask = hogwords_get_theme_option('front_page_about_bg_mask');
			$hogwords_bg_color = hogwords_get_theme_option('front_page_about_bg_color');
			if (!empty($hogwords_bg_color) && $hogwords_bg_mask > 0)
				$hogwords_css .= 'background-color: '.esc_attr($hogwords_bg_mask==1
																	? $hogwords_bg_color
																	: hogwords_hex2rgba($hogwords_bg_color, $hogwords_bg_mask)
																).';';
			if (!empty($hogwords_css))
				echo ' style="' . esc_attr($hogwords_css) . '"';
	?>>
		<div class="front_page_section_content_wrap front_page_section_about_content_wrap content_wrap">
			<?php
			// Caption
			$hogwords_caption = hogwords_get_theme_option('front_page_about_caption');
			if (!empty($hogwords_caption) || (current_user_can('edit_theme_options') && is_customize_preview())) {
				?><h2 class="front_page_section_caption front_page_section_about_caption front_page_block_<?php echo !empty($hogwords_caption) ? 'filled' : 'empty'; ?>"><?php echo wp_kses($hogwords_caption, 'hogwords_kses_content'); ?></h2><?php
			}
		
			// Description (text)
			$hogwords_description = hogwords_get_theme_option('front_page_about_description');
			if (!empty($hogwords_description) || (current_user_can('edit_theme_options') && is_customize_preview())) {
				?><div class="front_page_section_description front_page_section_about_description front_page_block_<?php echo !empty($hogwords_description) ? 'filled' : 'empty'; ?>"><?php echo wp_kses(wpautop($hogwords_description), 'hogwords_kses_content'); ?></div><?php
			}
			
			// Content
			$hogwords_content = hogwords_get_theme_option('front_page_about_content');
			if (!empty($hogwords_content) || (current_user_can('edit_theme_options') && is_customize_preview())) {
				?><div class="front_page_section_content front_page_section_about_content front_page_block_<?php echo !empty($hogwords_content) ? 'filled' : 'empty'; ?>"><?php
					$hogwords_page_content_mask = '%%CONTENT%%';
					if (strpos($hogwords_content, $hogwords_page_content_mask) !== false) {
						$hogwords_content = preg_replace(
									'/(\<p\>\s*)?'.$hogwords_page_content_mask.'(\s*\<\/p\>)/i',
									sprintf('<div class="front_page_section_about_source">%s</div>',
												apply_filters('the_content', get_the_content())),
									$hogwords_content
									);
					}
					hogwords_show_layout($hogwords_content);
				?></div><?php
			}
			?>
		</div>
	</div>
</div>