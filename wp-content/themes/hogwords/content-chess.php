<?php
/**
 * The Classic template to display the content
 *
 * Used for index/archive/search.
 *
 * @package WordPress
 * @subpackage HOGWORDS
 * @since HOGWORDS 1.0
 */

$hogwords_blog_style = explode('_', hogwords_get_theme_option('blog_style'));
$hogwords_columns = empty($hogwords_blog_style[1]) ? 1 : max(1, $hogwords_blog_style[1]);
$hogwords_expanded = !hogwords_sidebar_present() && hogwords_is_on(hogwords_get_theme_option('expand_content'));
$hogwords_post_format = get_post_format();
$hogwords_post_format = empty($hogwords_post_format) ? 'standard' : str_replace('post-format-', '', $hogwords_post_format);
$hogwords_animation = hogwords_get_theme_option('blog_animation');

?><article id="post-<?php the_ID(); ?>" 
	<?php post_class( 'post_item post_layout_chess post_layout_chess_'.esc_attr($hogwords_columns).' post_format_'.esc_attr($hogwords_post_format) ); ?>
	<?php echo (!hogwords_is_off($hogwords_animation) ? ' data-animation="'.esc_attr(hogwords_get_animation_classes($hogwords_animation)).'"' : ''); ?>>

	<?php
	// Add anchor
	if ($hogwords_columns == 1 && shortcode_exists('trx_sc_anchor')) {
		echo do_shortcode('[trx_sc_anchor id="post_'.esc_attr(get_the_ID()).'" title="'.the_title_attribute( array( 'echo' => false ) ).'"]');
	}

	// Sticky label
	if ( is_sticky() && !is_paged() ) {
		?><span class="post_label label_sticky"></span><?php
	}

	// Featured image
	hogwords_show_post_featured( array(
											'class' => $hogwords_columns == 1 ? 'hogwords-full-height' : '',
											'show_no_image' => true,
											'thumb_bg' => true,
											'thumb_size' => hogwords_get_thumb_size(
																	strpos(hogwords_get_theme_option('body_style'), 'full')!==false
																		? ( $hogwords_columns > 1 ? 'huge' : 'original' )
																		: (	$hogwords_columns > 2 ? 'big' : 'huge')
																	)
											) 
										);

	?><div class="post_inner"><div class="post_inner_content"><?php 

		?><div class="post_header entry-header"><?php 
			do_action('hogwords_action_before_post_title'); 

			// Post title
			the_title( sprintf( '<h3 class="post_title entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h3>' );
			
			do_action('hogwords_action_before_post_meta'); 

			// Post meta
			$hogwords_components = hogwords_is_inherit(hogwords_get_theme_option_from_meta('meta_parts')) 
										? 'categories,date'.($hogwords_columns < 3 ? ',counters' : '').($hogwords_columns == 1 ? ',edit' : '')
										: hogwords_array_get_keys_by_value(hogwords_get_theme_option('meta_parts'));
			$hogwords_counters = hogwords_is_inherit(hogwords_get_theme_option_from_meta('counters')) 
										? 'comments'
										: hogwords_array_get_keys_by_value(hogwords_get_theme_option('counters'));
			$hogwords_post_meta = empty($hogwords_components) 
										? '' 
										: hogwords_show_post_meta(apply_filters('hogwords_filter_post_meta_args', array(
												'components' => $hogwords_components,
												'counters' => $hogwords_counters,
												'seo' => false,
												'echo' => false
												), $hogwords_blog_style[0], $hogwords_columns)
											);
			hogwords_show_layout($hogwords_post_meta);
		?></div><!-- .entry-header -->
	
		<div class="post_content entry-content">
			<div class="post_content_inner">
				<?php
				$hogwords_show_learn_more = !in_array($hogwords_post_format, array('link', 'aside', 'status', 'quote'));
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
				?>
			</div>
			<?php
			// Post meta
			if (in_array($hogwords_post_format, array('link', 'aside', 'status', 'quote'))) {
				hogwords_show_layout($hogwords_post_meta);
			}?>
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
			?>
		</div><!-- .entry-content -->

	</div></div><!-- .post_inner -->

</article>