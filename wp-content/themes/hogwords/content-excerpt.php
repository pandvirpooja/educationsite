<?php
/**
 * The default template to display the content
 *
 * Used for index/archive/search.
 *
 * @package WordPress
 * @subpackage HOGWORDS
 * @since HOGWORDS 1.0
 */

$hogwords_post_format = get_post_format();
$hogwords_post_format = empty($hogwords_post_format) ? 'standard' : str_replace('post-format-', '', $hogwords_post_format);
$hogwords_animation = hogwords_get_theme_option('blog_animation');
$hogwords_show_audio = in_array($hogwords_post_format, array('audio'));
$hogwords_hide_audio = !in_array($hogwords_post_format, array('audio'));

?><article id="post-<?php the_ID(); ?>" 
	<?php post_class( 'post_item post_layout_excerpt post_format_'.esc_attr($hogwords_post_format) ); ?>
	<?php echo (!hogwords_is_off($hogwords_animation) ? ' data-animation="'.esc_attr(hogwords_get_animation_classes($hogwords_animation)).'"' : ''); ?>
	><?php

	// Sticky label
	if ( is_sticky() && !is_paged() ) {
		?><span class="post_label label_sticky"></span><?php
	}

	?><div class="post_featured_width"><?php

	// Featured image
	if (($hogwords_hide_audio)) {
	hogwords_show_post_featured(array( 'thumb_size' => hogwords_get_thumb_size( strpos( hogwords_get_theme_option('body_style'), 'full')!==false || ($hogwords_post_format == 'gallery') ? 'full' : 'big' ) ));
}

		?></div><?php

	?><div class="post_description"><?php
		// Title and post meta
		if (get_the_title() != '') {
			?>
			<div class="post_header entry-header">
				<?php
				do_action('hogwords_action_before_post_title');

				// Post title
				the_title( sprintf( '<h2 class="post_title entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' );

				do_action('hogwords_action_before_post_meta');

				// Post meta
				$hogwords_components = hogwords_is_inherit(hogwords_get_theme_option_from_meta('meta_parts'))
											? 'categories,date,counters,edit'
											: hogwords_array_get_keys_by_value(hogwords_get_theme_option('meta_parts'));
				$hogwords_counters = hogwords_is_inherit(hogwords_get_theme_option_from_meta('counters'))
											? 'views,likes,comments'
											: hogwords_array_get_keys_by_value(hogwords_get_theme_option('counters'));

				if (!empty($hogwords_components))
					hogwords_show_post_meta(apply_filters('hogwords_filter_post_meta_args', array(
						'components' => $hogwords_components,
						'counters' => $hogwords_counters,
						'seo' => false
						), 'excerpt', 1)
					);
				?>
			</div><!-- .post_header --><?php
		}

		// Post content
		if ($hogwords_show_audio) {
			// Featured image
			hogwords_show_post_featured(array( 'thumb_size' => hogwords_get_thumb_size( strpos(hogwords_get_theme_option('body_style'), 'full')!==false ? 'full' : 'big' ) ));
		}
		?><div class="post_content entry-content"><?php
			if (hogwords_get_theme_option('blog_content') == 'fullpost') {
				// Post content area
				?><div class="post_content_inner"><?php
					the_content( '' );
				?></div><?php
				// Inner pages
				wp_link_pages( array(
					'before'      => '<div class="page_links"><span class="page_links_title">' . esc_html__( 'Pages:', 'hogwords' ) . '</span>',
					'after'       => '</div>',
					'link_before' => '<span>',
					'link_after'  => '</span>',
					'pagelink'    => '<span class="screen-reader-text">' . esc_html__( 'Page', 'hogwords' ) . ' </span>%',
					'separator'   => '<span class="screen-reader-text">, </span>',
				) );

			} else {

				$hogwords_show_learn_more = !in_array($hogwords_post_format, array('link', 'aside', 'status', 'quote'));

				// Post content area
				?><div class="post_content_inner"><?php
					if (has_excerpt()) {
						the_excerpt();
					} else if (strpos(get_the_content('!--more'), '!--more')!==false) {
						the_content( '' );
					} else if (in_array($hogwords_post_format, array('link', 'aside', 'status'))) {
						the_content();
					} else if ($hogwords_post_format == 'quote') {
						if (($quote = hogwords_get_tag(get_the_content(), '<blockquote>', '</blockquote>'))!='')
							hogwords_show_layout(wpautop($quote));
						else
							the_excerpt();
					} else if (substr(get_the_content(), 0, 1)!='[') {
						the_excerpt();
					}
				?></div>

			<div class="post_meta_bottom"><?php
				// Post meta
				$hogwords_components = hogwords_is_inherit(hogwords_get_theme_option_from_meta('meta_parts'))
					? 'categories,date,counters,edit'
					: hogwords_array_get_keys_by_value(hogwords_get_theme_option('meta_parts'));
				$hogwords_counters = hogwords_is_inherit(hogwords_get_theme_option_from_meta('counters'))
					? 'views,likes,comments'
					: hogwords_array_get_keys_by_value(hogwords_get_theme_option('counters'));

				if (!empty($hogwords_components))
					hogwords_show_post_meta(apply_filters('hogwords_filter_post_meta_args', array(
							'components' => $hogwords_components,
							'counters' => $hogwords_counters,
							'seo' => false
						), 'excerpt', 1)
					);
				?></div><?php

			}



	?></div><!-- .entry-content -->

	</div>
<div class="clearfix"></div>
</article>

