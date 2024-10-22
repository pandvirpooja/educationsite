<?php
/**
 * The template for homepage posts with "Portfolio" style
 *
 * @package WordPress
 * @subpackage HOGWORDS
 * @since HOGWORDS 1.0
 */

hogwords_storage_set('blog_archive', true);

get_header(); 

if (have_posts()) {

	hogwords_show_layout(get_query_var('blog_archive_start'));

	$hogwords_stickies = is_home() ? get_option( 'sticky_posts' ) : false;
	$hogwords_sticky_out = hogwords_get_theme_option('sticky_style')=='columns' 
							&& is_array($hogwords_stickies) && count($hogwords_stickies) > 0 && get_query_var( 'paged' ) < 1;
	
	// Show filters
	$hogwords_cat = hogwords_get_theme_option('parent_cat');
	$hogwords_post_type = hogwords_get_theme_option('post_type');
	$hogwords_taxonomy = hogwords_get_post_type_taxonomy($hogwords_post_type);
	$hogwords_show_filters = hogwords_get_theme_option('show_filters');
	$hogwords_tabs = array();
	if (!hogwords_is_off($hogwords_show_filters)) {
		$hogwords_args = array(
			'type'			=> $hogwords_post_type,
			'child_of'		=> $hogwords_cat,
			'orderby'		=> 'name',
			'order'			=> 'ASC',
			'hide_empty'	=> 1,
			'hierarchical'	=> 0,
			'exclude'		=> '',
			'include'		=> '',
			'number'		=> '',
			'taxonomy'		=> $hogwords_taxonomy,
			'pad_counts'	=> false
		);
		$hogwords_portfolio_list = get_terms($hogwords_args);
		if (is_array($hogwords_portfolio_list) && count($hogwords_portfolio_list) > 0) {
			$hogwords_tabs[$hogwords_cat] = esc_html__('All', 'hogwords');
			foreach ($hogwords_portfolio_list as $hogwords_term) {
				if (isset($hogwords_term->term_id)) $hogwords_tabs[$hogwords_term->term_id] = $hogwords_term->name;
			}
		}
	}
	if (count($hogwords_tabs) > 0) {
		$hogwords_portfolio_filters_ajax = true;
		$hogwords_portfolio_filters_active = $hogwords_cat;
		$hogwords_portfolio_filters_id = 'portfolio_filters';
		?>
		<div class="portfolio_filters hogwords_tabs hogwords_tabs_ajax">
			<ul class="portfolio_titles hogwords_tabs_titles">
				<?php
				foreach ($hogwords_tabs as $hogwords_id=>$hogwords_title) {
					?><li><a href="<?php echo esc_url(hogwords_get_hash_link(sprintf('#%s_%s_content', $hogwords_portfolio_filters_id, $hogwords_id))); ?>" data-tab="<?php echo esc_attr($hogwords_id); ?>"><?php echo esc_html($hogwords_title); ?></a></li><?php
				}
				?>
			</ul>
			<?php
			$hogwords_ppp = hogwords_get_theme_option('posts_per_page');
			if (hogwords_is_inherit($hogwords_ppp)) $hogwords_ppp = '';
			foreach ($hogwords_tabs as $hogwords_id=>$hogwords_title) {
				$hogwords_portfolio_need_content = $hogwords_id==$hogwords_portfolio_filters_active || !$hogwords_portfolio_filters_ajax;
				?>
				<div id="<?php echo esc_attr(sprintf('%s_%s_content', $hogwords_portfolio_filters_id, $hogwords_id)); ?>"
					class="portfolio_content hogwords_tabs_content"
					data-blog-template="<?php echo esc_attr(hogwords_storage_get('blog_template')); ?>"
					data-blog-style="<?php echo esc_attr(hogwords_get_theme_option('blog_style')); ?>"
					data-posts-per-page="<?php echo esc_attr($hogwords_ppp); ?>"
					data-post-type="<?php echo esc_attr($hogwords_post_type); ?>"
					data-taxonomy="<?php echo esc_attr($hogwords_taxonomy); ?>"
					data-cat="<?php echo esc_attr($hogwords_id); ?>"
					data-parent-cat="<?php echo esc_attr($hogwords_cat); ?>"
					data-need-content="<?php echo (false===$hogwords_portfolio_need_content ? 'true' : 'false'); ?>"
				>
					<?php
					if ($hogwords_portfolio_need_content) 
						hogwords_show_portfolio_posts(array(
							'cat' => $hogwords_id,
							'parent_cat' => $hogwords_cat,
							'taxonomy' => $hogwords_taxonomy,
							'post_type' => $hogwords_post_type,
							'page' => 1,
							'sticky' => $hogwords_sticky_out
							)
						);
					?>
				</div>
				<?php
			}
			?>
		</div>
		<?php
	} else {
		hogwords_show_portfolio_posts(array(
			'cat' => $hogwords_cat,
			'parent_cat' => $hogwords_cat,
			'taxonomy' => $hogwords_taxonomy,
			'post_type' => $hogwords_post_type,
			'page' => 1,
			'sticky' => $hogwords_sticky_out
			)
		);
	}

	hogwords_show_layout(get_query_var('blog_archive_end'));

} else {

	if ( is_search() )
		get_template_part( 'content', 'none-search' );
	else
		get_template_part( 'content', 'none-archive' );

}

get_footer();
?>