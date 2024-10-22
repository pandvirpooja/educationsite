<?php
/**
 * The default template to display the content of the single post, page or attachment
 *
 * Used for index/archive/search.
 *
 * @package WordPress
 * @subpackage HOGWORDS
 * @since HOGWORDS 1.0
 */

$hogwords_seo = hogwords_is_on(hogwords_get_theme_option('seo_snippets'));
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'post_item_single post_type_'.esc_attr(get_post_type()) 
												. ' post_format_'.esc_attr(str_replace('post-format-', '', get_post_format())) 
												);
		if ($hogwords_seo) {
			?> itemscope="itemscope" 
			   itemprop="articleBody" 
			   itemtype="//schema.org/<?php echo esc_attr(hogwords_get_markup_schema()); ?>"
			   itemid="<?php echo esc_url(get_the_permalink()); ?>"
			   content="<?php the_title_attribute(); ?>"<?php
		}
?>><?php

	do_action('hogwords_action_before_post_data'); 

	// Structured data snippets
	if ($hogwords_seo)
		get_template_part('templates/seo');

	// Featured image
	if ( hogwords_is_off(hogwords_get_theme_option('hide_featured_on_single'))
			&& !hogwords_sc_layouts_showed('featured') 
			&& strpos(get_the_content(), '[trx_widget_banner]')===false) {
		do_action('hogwords_action_before_post_featured'); 
		hogwords_show_post_featured();
		do_action('hogwords_action_after_post_featured'); 
	} else if (has_post_thumbnail()) {
		?><meta itemprop="image" itemtype="//schema.org/ImageObject" content="<?php echo esc_url(wp_get_attachment_url(get_post_thumbnail_id())); ?>"><?php
	}

	// Title and post meta
	if ( (!hogwords_sc_layouts_showed('title') || !hogwords_sc_layouts_showed('postmeta')) && !in_array(get_post_format(), array('link', 'aside', 'status', 'quote')) ) {
		do_action('hogwords_action_before_post_title'); 
		?>
		<div class="post_header entry-header">
			<?php
			// Post title
			if (!hogwords_sc_layouts_showed('title')) {
				the_title( '<h3 class="post_title entry-title"'.($hogwords_seo ? ' itemprop="headline"' : '').'>', '</h3>' );
			}
			// Post meta
			if (!hogwords_sc_layouts_showed('postmeta') && hogwords_is_on(hogwords_get_theme_option('show_post_meta'))) {
				hogwords_show_post_meta(apply_filters('hogwords_filter_post_meta_args', array(
					'components' => hogwords_array_get_keys_by_value(hogwords_get_theme_option('meta_parts')),
					'counters' => hogwords_array_get_keys_by_value(hogwords_get_theme_option('counters')),
					'seo' => hogwords_is_on(hogwords_get_theme_option('seo_snippets'))
					), 'single', 1)
				);
			}
			?>
		</div><!-- .post_header -->
		<?php
		do_action('hogwords_action_after_post_title'); 
	}

	do_action('hogwords_action_before_post_content'); 

	// Post content
	?>
	<div class="post_content entry-content" itemprop="mainEntityOfPage">
		<?php
		the_content( );

		do_action('hogwords_action_before_post_pagination'); 

		wp_link_pages( array(
			'before'      => '<div class="page_links"><span class="page_links_title">' . esc_html__( 'Pages:', 'hogwords' ) . '</span>',
			'after'       => '</div>',
			'link_before' => '<span>',
			'link_after'  => '</span>',
			'pagelink'    => '<span class="screen-reader-text">' . esc_html__( 'Page', 'hogwords' ) . ' </span>%',
			'separator'   => '<span class="screen-reader-text">, </span>',
		) );
		?>
	<div class="post_meta_bottom"><?php
		// Post meta
		if (!hogwords_sc_layouts_showed('postmeta') && hogwords_is_on(hogwords_get_theme_option('show_post_meta'))) {
			hogwords_show_post_meta(apply_filters('hogwords_filter_post_meta_args', array(
					'components' => hogwords_array_get_keys_by_value(hogwords_get_theme_option('meta_parts')),
					'counters' => hogwords_array_get_keys_by_value(hogwords_get_theme_option('counters')),
					'seo' => hogwords_is_on(hogwords_get_theme_option('seo_snippets'))
				), 'single', 1)
			);
		}
		?></div><?php

		// Taxonomies and share
		if ( is_single() && !is_attachment() ) {
			
			do_action('hogwords_action_before_post_meta'); 

			?><div class="post_meta post_meta_single"><?php
				
				// Post taxonomies
				the_tags( '<span class="post_meta_item post_tags"><span class="post_meta_label">'.esc_html__('Tags:', 'hogwords').'</span> ', ', ', '</span>' );


			?></div><?php

			do_action('hogwords_action_after_post_meta'); 
		}
		?>
	</div><!-- .entry-content -->
	

	<?php
	do_action('hogwords_action_after_post_content'); 

	// Author bio.
	if ( hogwords_get_theme_option('show_author_info')==1 && is_single() && !is_attachment() && get_the_author_meta( 'description' ) ) {
		do_action('hogwords_action_before_post_author'); 
		get_template_part( 'templates/author-bio' );
		do_action('hogwords_action_after_post_author'); 
	}

	do_action('hogwords_action_after_post_data'); 
	?>
</article>
