<?php
/**
 * The template to display posts in widgets and/or in the search results
 *
 * @package WordPress
 * @subpackage HOGWORDS
 * @since HOGWORDS 1.0
 */

$hogwords_post_id    = get_the_ID();
$hogwords_post_date  = hogwords_get_date();
$hogwords_post_title = get_the_title();
$hogwords_post_link  = get_permalink();
$hogwords_post_author_id   = get_the_author_meta('ID');
$hogwords_post_author_name = get_the_author_meta('display_name');
$hogwords_post_author_url  = get_author_posts_url($hogwords_post_author_id, '');

$hogwords_args = get_query_var('hogwords_args_widgets_posts');
$hogwords_show_date = isset($hogwords_args['show_date']) ? (int) $hogwords_args['show_date'] : 1;
$hogwords_show_image = isset($hogwords_args['show_image']) ? (int) $hogwords_args['show_image'] : 1;
$hogwords_show_author = isset($hogwords_args['show_author']) ? (int) $hogwords_args['show_author'] : 1;
$hogwords_show_counters = isset($hogwords_args['show_counters']) ? (int) $hogwords_args['show_counters'] : 1;
$hogwords_show_categories = isset($hogwords_args['show_categories']) ? (int) $hogwords_args['show_categories'] : 1;

$hogwords_output = hogwords_storage_get('hogwords_output_widgets_posts');

$hogwords_post_counters_output = '';
if ( $hogwords_show_counters ) {
	$hogwords_post_counters_output = '<span class="post_info_item post_info_counters">'
								. hogwords_get_post_counters('comments')
							. '</span>';
}


$hogwords_output .= '<article class="post_item with_thumb">';

if ($hogwords_show_image) {
	$hogwords_post_thumb = get_the_post_thumbnail($hogwords_post_id, hogwords_get_thumb_size('tiny'), array(
		'alt' => the_title_attribute( array( 'echo' => false ) )
	));
	if ($hogwords_post_thumb) $hogwords_output .= '<div class="post_thumb">' . ($hogwords_post_link ? '<a href="' . esc_url($hogwords_post_link) . '">' : '') . ($hogwords_post_thumb) . ($hogwords_post_link ? '</a>' : '') . '</div>';
}

$hogwords_output .= '<div class="post_content">'
			. ($hogwords_show_categories 
					? '<div class="post_categories">'
						. hogwords_get_post_categories()
						. $hogwords_post_counters_output
						. '</div>' 
					: '')
			. '<h6 class="post_title">' . ($hogwords_post_link ? '<a href="' . esc_url($hogwords_post_link) . '">' : '') . ($hogwords_post_title) . ($hogwords_post_link ? '</a>' : '') . '</h6>'
			. apply_filters('hogwords_filter_get_post_info', 
								'<div class="post_info">'
									. ($hogwords_show_date 
										? '<span class="post_info_item post_info_posted">'
											. ($hogwords_post_link ? '<a href="' . esc_url($hogwords_post_link) . '" class="post_info_date">' : '') 
											. esc_html($hogwords_post_date) 
											. ($hogwords_post_link ? '</a>' : '')
											. '</span>'
										: '')
									. ($hogwords_show_author 
										? '<span class="post_info_item post_info_posted_by">' 
											. esc_html__('by', 'hogwords') . ' ' 
											. ($hogwords_post_link ? '<a href="' . esc_url($hogwords_post_author_url) . '" class="post_info_author">' : '') 
											. esc_html($hogwords_post_author_name) 
											. ($hogwords_post_link ? '</a>' : '') 
											. '</span>'
										: '')
									. (!$hogwords_show_categories && $hogwords_post_counters_output
										? $hogwords_post_counters_output
										: '')
								. '</div>')
		. '</div>'
	. '</article>';
hogwords_storage_set('hogwords_output_widgets_posts', $hogwords_output);
?>