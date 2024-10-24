<?php
/**
 * The style "default" of the Site Title
 *
 * @package WordPress
 * @subpackage ThemeREX Addons
 * @since v1.6.08
 */

$args = get_query_var('trx_addons_args_sc_layouts_title');

$need_content = (!empty($args['meta']) && is_single())
					|| !empty($args['title'])
					|| !empty($args['breadcrumbs']);
$need_override = !empty($args['use_featured_image']) 
					&& apply_filters('trx_addons_filter_featured_image_override', is_singular() 
																			&& in_array(get_post_type(), array('post', 'page')) 
																			&& has_post_thumbnail());
$need_image = !empty($args['image']) || $need_override;

if ( $need_content || $need_image )  {
	if ($need_image) {
		$trx_addons_attachment_src = !empty($args['image'])	? trx_addons_get_attachment_url($args['image'], 'full')	: '';
		if ($need_override) {
			$trx_addons_attachment = trx_addons_get_current_mode_image();
			if (!empty($trx_addons_attachment)) {
				$trx_addons_attachment_src = $trx_addons_attachment;
			}
		}
		$need_image = !empty($trx_addons_attachment_src);
		if ($need_image) $args['css'] = 'background-image:url('.esc_url($trx_addons_attachment_src).');' . $args['css'];
	}
	if ( $need_content || $need_image )  {
		if (!empty($args['height'])) {
			$args['css'] = trx_addons_get_css_dimensions_from_values(array('min-height' => $args['height'])) . ';' . $args['css'];
			$need_image = true;	// To vertical position title block to the center of the area
		}
		?><div<?php if (!empty($args['id'])) echo ' id="'.esc_attr($args['id']).'"'; ?> class="sc_layouts_title<?php
				trx_addons_cpt_layouts_sc_add_classes($args);
				if ($need_content) echo ' with_content';
				if ($need_image) echo ' with_image';
			?>"<?php
			if (!empty($args['css'])) echo ' style="'.esc_attr($args['css']).'"'; ?>><?php
		
			if ( $need_content )  {

				?><div class="sc_layouts_title_content"><?php

					// Post meta on the single post
					if (!empty($args['meta']) && is_single() )  {
						?><div class="sc_layouts_title_meta"><?php
							trx_addons_sc_show_post_meta('sc_layouts', apply_filters('trx_addons_filter_show_post_meta', array(
										'components' => 'categories,date,counters',
										'counters' => 'views,comments,likes',
										'seo' => true
										), 'sc_layouts', !empty($args['columns']) ? $args['columns'] : 1)
									);
						?></div><?php
						trx_addons_sc_layouts_showed('postmeta', true);
					}
				
					// Blog/Post title
					if (!empty($args['title']) )  {
						?><div class="sc_layouts_title_title"><?php
							$trx_addons_blog_title = trx_addons_get_blog_title();
							$trx_addons_blog_title_text = $trx_addons_blog_title_class = $trx_addons_blog_title_link = $trx_addons_blog_title_link_text = '';
							if (is_array($trx_addons_blog_title)) {
								$trx_addons_blog_title_text = $trx_addons_blog_title['text'];
								$trx_addons_blog_title_class = !empty($trx_addons_blog_title['class']) ? ' '.$trx_addons_blog_title['class'] : '';
								$trx_addons_blog_title_link = !empty($trx_addons_blog_title['link']) ? $trx_addons_blog_title['link'] : '';
								$trx_addons_blog_title_link_text = !empty($trx_addons_blog_title['link_text']) ? $trx_addons_blog_title['link_text'] : '';
							} else
								$trx_addons_blog_title_text = $trx_addons_blog_title;
							?>
							<h1<?php trx_addons_seo_snippets('headline'); ?> class="sc_layouts_title_caption<?php echo esc_attr($trx_addons_blog_title_class); ?>"><?php
								$trx_addons_top_icon = trx_addons_get_category_icon();
								if (!empty($trx_addons_top_icon)) {
									$trx_addons_attr = trx_addons_getimagesize($trx_addons_top_icon);
									?><img src="<?php echo esc_url($trx_addons_top_icon); ?>" alt="<?php echo esc_attr(basename($trx_addons_top_icon)); ?>" <?php if (!empty($trx_addons_attr[3])) trx_addons_show_layout($trx_addons_attr[3]);?>><?php
								}
								echo wp_kses_data($trx_addons_blog_title_text);
							?></h1>
							<?php

								
							// Category/Tag description
							if ( is_category() || is_tag() || is_tax() ) 
								the_archive_description( '<div class="sc_layouts_title_description">', '</div>' );
						?></div><?php
						trx_addons_sc_layouts_showed('title', true);
					}
				
					// Breadcrumbs
					if (!empty($args['breadcrumbs']) )  {
						?><div class="sc_layouts_title_breadcrumbs"><?php
							do_action( 'trx_addons_action_breadcrumbs');
						?></div><?php
						trx_addons_sc_layouts_showed('breadcrumbs', true);
					}

				?></div><!-- .sc_layouts_title_content --><?php
			}
		
		?></div><!-- /.sc_layouts_title --><?php
	}
}