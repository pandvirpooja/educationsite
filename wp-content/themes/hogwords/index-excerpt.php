<?php
/**
 * The template for homepage posts with "Excerpt" style
 *
 * @package WordPress
 * @subpackage HOGWORDS
 * @since HOGWORDS 1.0
 */

hogwords_storage_set('blog_archive', true);

get_header(); 

if (have_posts()) {

	hogwords_show_layout(get_query_var('blog_archive_start'));

	?><div class="posts_container"><?php
	
	$hogwords_stickies = is_home() ? get_option( 'sticky_posts' ) : false;
	$hogwords_sticky_out = hogwords_get_theme_option('sticky_style')=='columns' 
							&& is_array($hogwords_stickies) && count($hogwords_stickies) > 0 && get_query_var( 'paged' ) < 1;
	if ($hogwords_sticky_out) {
		?><div class="sticky_wrap columns_wrap"><?php	
	}
	while ( have_posts() ) { the_post(); 
		if ($hogwords_sticky_out && !is_sticky()) {
			$hogwords_sticky_out = false;
			?></div><?php
		}
		get_template_part( 'content', $hogwords_sticky_out && is_sticky() ? 'sticky' : 'excerpt' );
	}
	if ($hogwords_sticky_out) {
		$hogwords_sticky_out = false;
		?></div><?php
	}
	
	?></div><?php

	hogwords_show_pagination();

	hogwords_show_layout(get_query_var('blog_archive_end'));

} else {

	if ( is_search() )
		get_template_part( 'content', 'none-search' );
	else
		get_template_part( 'content', 'none-archive' );

}

get_footer();
?>