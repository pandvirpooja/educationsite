<?php
/**
 * The template to display blog archive
 *
 * @package WordPress
 * @subpackage HOGWORDS
 * @since HOGWORDS 1.0
 */

/*
Template Name: Blog archive
*/

/**
 * Make page with this template and put it into menu
 * to display posts as blog archive
 * You can setup output parameters (blog style, posts per page, parent category, etc.)
 * in the Theme Options section (under the page content)
 * You can build this page in the WordPress editor or any Page Builder to make custom page layout:
 * just insert %%CONTENT%% in the desired place of content
 */

// Get template page's content
$hogwords_content = '';
$hogwords_blog_archive_mask = '%%CONTENT%%';
$hogwords_blog_archive_subst = sprintf('<div class="blog_archive">%s</div>', $hogwords_blog_archive_mask);
if ( have_posts() ) {
	the_post();
	if (($hogwords_content = apply_filters('the_content', get_the_content())) != '') {
		if (($hogwords_pos = strpos($hogwords_content, $hogwords_blog_archive_mask)) !== false) {
			$hogwords_content = preg_replace('/(\<p\>\s*)?'.$hogwords_blog_archive_mask.'(\s*\<\/p\>)/i', $hogwords_blog_archive_subst, $hogwords_content);
		} else
			$hogwords_content .= $hogwords_blog_archive_subst;
		$hogwords_content = explode($hogwords_blog_archive_mask, $hogwords_content);
		// Add VC custom styles to the inline CSS
		$vc_custom_css = get_post_meta( get_the_ID(), '_wpb_shortcodes_custom_css', true );
		if ( !empty( $vc_custom_css ) ) hogwords_add_inline_css(strip_tags($vc_custom_css));
	}
}

// Prepare args for a new query
$hogwords_args = array(
	'post_status' => current_user_can('read_private_pages') && current_user_can('read_private_posts') ? array('publish', 'private') : 'publish'
);
$hogwords_args = hogwords_query_add_posts_and_cats($hogwords_args, '', hogwords_get_theme_option('post_type'), hogwords_get_theme_option('parent_cat'));
$hogwords_page_number = get_query_var('paged') ? get_query_var('paged') : (get_query_var('page') ? get_query_var('page') : 1);
if ($hogwords_page_number > 1) {
	$hogwords_args['paged'] = $hogwords_page_number;
	$hogwords_args['ignore_sticky_posts'] = true;
}
$hogwords_ppp = hogwords_get_theme_option('posts_per_page');
if ((int) $hogwords_ppp != 0)
	$hogwords_args['posts_per_page'] = (int) $hogwords_ppp;
// Make a new main query
$GLOBALS['wp_the_query']->query($hogwords_args);


// Add internal query vars in the new query!
if (is_array($hogwords_content) && count($hogwords_content) == 2) {
	set_query_var('blog_archive_start', $hogwords_content[0]);
	set_query_var('blog_archive_end', $hogwords_content[1]);
}

get_template_part('index');
?>