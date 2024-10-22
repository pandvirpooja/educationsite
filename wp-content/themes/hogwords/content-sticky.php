<?php
/**
 * The Sticky template to display the sticky posts
 *
 * Used for index/archive
 *
 * @package WordPress
 * @subpackage HOGWORDS
 * @since HOGWORDS 1.0
 */

$hogwords_columns = max(1, min(3, count(get_option( 'sticky_posts' ))));
$hogwords_post_format = get_post_format();
$hogwords_post_format = empty($hogwords_post_format) ? 'standard' : str_replace('post-format-', '', $hogwords_post_format);
$hogwords_animation = hogwords_get_theme_option('blog_animation');

?><div class="column-1_<?php echo esc_attr($hogwords_columns); ?>"><article id="post-<?php the_ID(); ?>" 
	<?php post_class( 'post_item post_layout_sticky post_format_'.esc_attr($hogwords_post_format) ); ?>
	<?php echo (!hogwords_is_off($hogwords_animation) ? ' data-animation="'.esc_attr(hogwords_get_animation_classes($hogwords_animation)).'"' : ''); ?>
	>

	<?php
	if ( is_sticky() && is_home() && !is_paged() ) {
		?><span class="post_label label_sticky"></span><?php
	}

	// Featured image
	hogwords_show_post_featured(array(
		'thumb_size' => hogwords_get_thumb_size($hogwords_columns==1 ? 'big' : ($hogwords_columns==2 ? 'med' : 'avatar'))
	));

	if ( !in_array($hogwords_post_format, array('link', 'aside', 'status', 'quote')) ) {
		?>
		<div class="post_header entry-header">
			<?php
			// Post title
			the_title( sprintf( '<h6 class="post_title entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h6>' );
			// Post meta
			hogwords_show_post_meta(apply_filters('hogwords_filter_post_meta_args', array(), 'sticky', $hogwords_columns));
			?>
		</div><!-- .entry-header -->
		<?php
	}
	?>
</article></div>