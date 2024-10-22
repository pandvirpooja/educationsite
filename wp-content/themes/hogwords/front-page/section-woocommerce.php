<div class="front_page_section front_page_section_woocommerce<?php
			$hogwords_scheme = hogwords_get_theme_option('front_page_woocommerce_scheme');
			if (!hogwords_is_inherit($hogwords_scheme)) echo ' scheme_'.esc_attr($hogwords_scheme);
			echo ' front_page_section_paddings_'.esc_attr(hogwords_get_theme_option('front_page_woocommerce_paddings'));
		?>"<?php
		$hogwords_css = '';
		$hogwords_bg_image = hogwords_get_theme_option('front_page_woocommerce_bg_image');
		if (!empty($hogwords_bg_image)) 
			$hogwords_css .= 'background-image: url('.esc_url(hogwords_get_attachment_url($hogwords_bg_image)).');';
		if (!empty($hogwords_css))
			echo ' style="' . esc_attr($hogwords_css) . '"';
?>><?php
	// Add anchor
	$hogwords_anchor_icon = hogwords_get_theme_option('front_page_woocommerce_anchor_icon');	
	$hogwords_anchor_text = hogwords_get_theme_option('front_page_woocommerce_anchor_text');	
	if ((!empty($hogwords_anchor_icon) || !empty($hogwords_anchor_text)) && shortcode_exists('trx_sc_anchor')) {
		echo do_shortcode('[trx_sc_anchor id="front_page_section_woocommerce"'
										. (!empty($hogwords_anchor_icon) ? ' icon="'.esc_attr($hogwords_anchor_icon).'"' : '')
										. (!empty($hogwords_anchor_text) ? ' title="'.esc_attr($hogwords_anchor_text).'"' : '')
										. ']');
	}
	?>
	<div class="front_page_section_inner front_page_section_woocommerce_inner<?php
			if (hogwords_get_theme_option('front_page_woocommerce_fullheight'))
				echo ' hogwords-full-height sc_layouts_flex sc_layouts_columns_middle';
			?>"<?php
			$hogwords_css = '';
			$hogwords_bg_mask = hogwords_get_theme_option('front_page_woocommerce_bg_mask');
			$hogwords_bg_color = hogwords_get_theme_option('front_page_woocommerce_bg_color');
			if (!empty($hogwords_bg_color) && $hogwords_bg_mask > 0)
				$hogwords_css .= 'background-color: '.esc_attr($hogwords_bg_mask==1
																	? $hogwords_bg_color
																	: hogwords_hex2rgba($hogwords_bg_color, $hogwords_bg_mask)
																).';';
			if (!empty($hogwords_css))
				echo ' style="' . esc_attr($hogwords_css) . '"';
	?>>
		<div class="front_page_section_content_wrap front_page_section_woocommerce_content_wrap content_wrap woocommerce">
			<?php
			// Content wrap with title and description
			$hogwords_caption = hogwords_get_theme_option('front_page_woocommerce_caption');
			$hogwords_description = hogwords_get_theme_option('front_page_woocommerce_description');
			if (!empty($hogwords_caption) || !empty($hogwords_description) || (current_user_can('edit_theme_options') && is_customize_preview())) {
				// Caption
				if (!empty($hogwords_caption) || (current_user_can('edit_theme_options') && is_customize_preview())) {
					?><h2 class="front_page_section_caption front_page_section_woocommerce_caption front_page_block_<?php echo !empty($hogwords_caption) ? 'filled' : 'empty'; ?>"><?php
						echo wp_kses($hogwords_caption, 'hogwords_kses_content');
					?></h2><?php
				}
			
				// Description (text)
				if (!empty($hogwords_description) || (current_user_can('edit_theme_options') && is_customize_preview())) {
					?><div class="front_page_section_description front_page_section_woocommerce_description front_page_block_<?php echo !empty($hogwords_description) ? 'filled' : 'empty'; ?>"><?php
						echo wp_kses(wpautop($hogwords_description), 'hogwords_kses_content');
					?></div><?php
				}
			}
		
			// Content (widgets)
			?><div class="front_page_section_output front_page_section_woocommerce_output list_products shop_mode_thumbs"><?php 
				$hogwords_woocommerce_sc = hogwords_get_theme_option('front_page_woocommerce_products');
				if ($hogwords_woocommerce_sc == 'products') {
					$hogwords_woocommerce_sc_ids = hogwords_get_theme_option('front_page_woocommerce_products_per_page');
					$hogwords_woocommerce_sc_per_page = count(explode(',', $hogwords_woocommerce_sc_ids));
				} else {
					$hogwords_woocommerce_sc_per_page = max(1, (int) hogwords_get_theme_option('front_page_woocommerce_products_per_page'));
				}
				$hogwords_woocommerce_sc_columns = max(1, min($hogwords_woocommerce_sc_per_page, (int) hogwords_get_theme_option('front_page_woocommerce_products_columns')));
				echo do_shortcode("[{$hogwords_woocommerce_sc}"
									. ($hogwords_woocommerce_sc == 'products' 
											? ' ids="'.esc_attr($hogwords_woocommerce_sc_ids).'"' 
											: '')
									. ($hogwords_woocommerce_sc == 'product_category' 
											? ' category="'.esc_attr(hogwords_get_theme_option('front_page_woocommerce_products_categories')).'"' 
											: '')
									. ($hogwords_woocommerce_sc != 'best_selling_products' 
											? ' orderby="'.esc_attr(hogwords_get_theme_option('front_page_woocommerce_products_orderby')).'"'
											  . ' order="'.esc_attr(hogwords_get_theme_option('front_page_woocommerce_products_order')).'"' 
											: '')
									. ' per_page="'.esc_attr($hogwords_woocommerce_sc_per_page).'"' 
									. ' columns="'.esc_attr($hogwords_woocommerce_sc_columns).'"' 
									. ']');
			?></div>
		</div>
	</div>
</div>