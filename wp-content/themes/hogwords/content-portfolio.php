<?php
/**
 * The Portfolio template to display the content
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

?><article id="post-<?php the_ID(); ?>" 
	<?php post_class( 'post_item post_layout_portfolio post_layout_portfolio_'.esc_attr($hogwords_columns).' post_format_'.esc_attr($hogwords_post_format).(is_sticky() && !is_paged() ? ' sticky' : '') ); ?>
	<?php echo (!hogwords_is_off($hogwords_animation) ? ' data-animation="'.esc_attr(hogwords_get_animation_classes($hogwords_animation)).'"' : ''); ?>>
	<?php

	// Sticky label
	if ( is_sticky() && !is_paged() ) {
		?><span class="post_label label_sticky"></span><?php
	}

	$hogwords_image_hover = hogwords_get_theme_option('image_hover');
	// Featured image
	hogwords_show_post_featured(array(
		'thumb_size' => hogwords_get_thumb_size(strpos(hogwords_get_theme_option('body_style'), 'full')!==false || $hogwords_columns < 3 
								? 'big'
								: 'big'),
		'show_no_image' => true,
		'class' => $hogwords_image_hover == 'dots' ? 'hover_with_info' : '',
		'post_info' => $hogwords_image_hover == 'dots' ? '<div class="post_info">'.esc_html(get_the_title()).'</div>' : ''
	));
	?>
</article>