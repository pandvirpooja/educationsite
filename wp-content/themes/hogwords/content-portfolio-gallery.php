<?php
/**
 * The Gallery template to display posts
 *
 * Used for index/archive/search.
 *
 * @package WordPress
 * @subpackage HOGWORDS
 * @since HOGWORDS 1.0
 */

$hogwords_blog_style = explode('_', hogwords_get_theme_option('blog_style'));
$hogwords_columns = empty($hogwords_blog_style[1]) ? 2 : max(2, $hogwords_blog_style[1]);
$hogwords_post_format = get_post_format();
$hogwords_post_format = empty($hogwords_post_format) ? 'standard' : str_replace('post-format-', '', $hogwords_post_format);
$hogwords_animation = hogwords_get_theme_option('blog_animation');
$hogwords_image = wp_get_attachment_image_src( get_post_thumbnail_id(get_the_ID()), 'full' );

?><article id="post-<?php the_ID(); ?>" 
	<?php post_class( 'post_item post_layout_portfolio post_layout_gallery post_layout_gallery_'.esc_attr($hogwords_columns).' post_format_'.esc_attr($hogwords_post_format) ); ?>
	<?php echo (!hogwords_is_off($hogwords_animation) ? ' data-animation="'.esc_attr(hogwords_get_animation_classes($hogwords_animation)).'"' : ''); ?>
	data-size="<?php if (!empty($hogwords_image[1]) && !empty($hogwords_image[2])) echo intval($hogwords_image[1]) .'x' . intval($hogwords_image[2]); ?>"
	data-src="<?php if (!empty($hogwords_image[0])) echo esc_url($hogwords_image[0]); ?>"
	>

	<?php

	// Sticky label
	if ( is_sticky() && !is_paged() ) {
		?><span class="post_label label_sticky"></span><?php
	}

	// Featured image
	$hogwords_image_hover = 'icon';
	if (in_array($hogwords_image_hover, array('icons', 'zoom'))) $hogwords_image_hover = 'dots';
	$hogwords_components = hogwords_is_inherit(hogwords_get_theme_option_from_meta('meta_parts')) 
								? 'categories,date,counters,share'
								: hogwords_array_get_keys_by_value(hogwords_get_theme_option('meta_parts'));
	$hogwords_counters = hogwords_is_inherit(hogwords_get_theme_option_from_meta('counters')) 
								? 'comments'
								: hogwords_array_get_keys_by_value(hogwords_get_theme_option('counters'));
	hogwords_show_post_featured(array(
		'hover' => $hogwords_image_hover,
		'thumb_size' => hogwords_get_thumb_size( strpos(hogwords_get_theme_option('body_style'), 'full')!==false || $hogwords_columns < 3 ? 'masonry-big' : 'masonry' ),
		'thumb_only' => true,
		'show_no_image' => true,
		'post_info' => '<div class="post_details">'
							. '<h2 class="post_title"><a href="'.esc_url(get_permalink()).'">'. esc_html(get_the_title()) . '</a></h2>'
							. '<div class="post_description">'
								. (!empty($hogwords_components)
										? hogwords_show_post_meta(apply_filters('hogwords_filter_post_meta_args', array(
											'components' => $hogwords_components,
											'counters' => $hogwords_counters,
											'seo' => false,
											'echo' => false
											), $hogwords_blog_style[0], $hogwords_columns))
										: '')
								. '<div class="post_description_content">'
									. apply_filters('the_excerpt', get_the_excerpt())
								. '</div>'
								. '<a href="'.esc_url(get_permalink()).'" class="theme_button post_readmore"><span class="post_readmore_label">' . esc_html__('Learn more', 'hogwords') . '</span></a>'
							. '</div>'
						. '</div>'
	));
	?>
</article>