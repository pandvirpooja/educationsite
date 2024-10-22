<?php
/**
 * The template 'Style 1' to displaying related posts
 *
 * @package WordPress
 * @subpackage HOGWORDS
 * @since HOGWORDS 1.0
 */

$hogwords_link = get_permalink();
$hogwords_post_format = get_post_format();
$hogwords_post_format = empty($hogwords_post_format) ? 'standard' : str_replace('post-format-', '', $hogwords_post_format);
?><div id="post-<?php the_ID(); ?>" 
	<?php post_class( 'related_item related_item_style_1 post_format_'.esc_attr($hogwords_post_format) ); ?>><?php
	hogwords_show_post_featured(array(
		'thumb_size' => hogwords_get_thumb_size( (int) hogwords_get_theme_option('related_posts') == 1 ? 'huge' : 'big' ),
		'show_no_image' => false,
		'singular' => false,
		'post_info' => '<div class="post_header entry-header">'
							. '<div class="post_categories">'.wp_kses_post(hogwords_get_post_categories('')).'</div>'
							. '<h6 class="post_title entry-title"><a href="'.esc_url($hogwords_link).'">'.esc_html(get_the_title()).'</a></h6>'
							. (in_array(get_post_type(), array('post', 'attachment'))
									? '<span class="post_date"><a href="'.esc_url($hogwords_link).'">'.wp_kses_data(hogwords_get_date()).'</a></span>'
									: '')
						. '</div>'
		)
	);
?></div>