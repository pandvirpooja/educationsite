<?php
/**
 * The template to display the page title and breadcrumbs
 *
 * @package WordPress
 * @subpackage HOGWORDS
 * @since HOGWORDS 1.0
 */

// Page (category, tag, archive, author) title

if ( hogwords_need_page_title() ) {
	hogwords_sc_layouts_showed('title', true);
	hogwords_sc_layouts_showed('postmeta', true);
	?>
	<div class="top_panel_breadcrumbs sc_layouts_row sc_layouts_row_type_narrow">
		<div class="content_wrap">
			<div class="sc_layouts_column sc_layouts_column_align_left">
				<div class="sc_layouts_item">
					<div class="sc_layouts_breadcrumbs sc_align_left">
						<?php
						// Post meta on the single post
						if ( is_single() )  {
							?><div class="sc_layouts_title_meta"><?php
								hogwords_show_post_meta(apply_filters('hogwords_filter_post_meta_args', array(
									'components' => 'categories,date,counters,edit',
									'counters' => 'views,comments,likes',
									'seo' => true
									), 'header', 1)
								);
							?></div><?php
						}
						// Breadcrumbs
						?><div class="sc_layouts_title_breadcrumbs"><?php
							do_action( 'hogwords_action_breadcrumbs');
							?></div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="top_panel_title sc_layouts_row">
		<div class="content_wrap">
			<div class="sc_layouts_column sc_layouts_column_align_left">
				<div class="sc_layouts_item">
					<div class="sc_layouts_title sc_align_left">
						<?php
						// Blog/Post title
						?><div class="sc_layouts_title_title"><?php
							$hogwords_blog_title = hogwords_get_blog_title();
							$hogwords_blog_title_text = $hogwords_blog_title_class = $hogwords_blog_title_link = $hogwords_blog_title_link_text = '';
							if (is_array($hogwords_blog_title)) {
								$hogwords_blog_title_text = $hogwords_blog_title['text'];
								$hogwords_blog_title_class = !empty($hogwords_blog_title['class']) ? ' '.$hogwords_blog_title['class'] : '';
								$hogwords_blog_title_link = !empty($hogwords_blog_title['link']) ? $hogwords_blog_title['link'] : '';
								$hogwords_blog_title_link_text = !empty($hogwords_blog_title['link_text']) ? $hogwords_blog_title['link_text'] : '';
							} else
								$hogwords_blog_title_text = $hogwords_blog_title;
							?>
							<h1 itemprop="headline" class="sc_layouts_title_caption<?php echo esc_attr($hogwords_blog_title_class); ?>"><?php
								$hogwords_top_icon = hogwords_get_category_icon();
								if (!empty($hogwords_top_icon)) {
									$hogwords_attr = hogwords_getimagesize($hogwords_top_icon);
									?><img src="<?php echo esc_url($hogwords_top_icon); ?>" alt="<?php echo esc_attr(basename($hogwords_top_icon)); ?>" <?php if (!empty($hogwords_attr[3])) hogwords_show_layout($hogwords_attr[3]);?>><?php
								}
								echo wp_kses_post($hogwords_blog_title_text);
							?></h1>
							<?php
							if (!empty($hogwords_blog_title_link) && !empty($hogwords_blog_title_link_text)) {
								?><a href="<?php echo esc_url($hogwords_blog_title_link); ?>" class="theme_button theme_button_small sc_layouts_title_link"><?php echo esc_html($hogwords_blog_title_link_text); ?></a><?php
							}
							
							// Category/Tag description
							if ( is_category() || is_tag() || is_tax() ) 
								the_archive_description( '<div class="sc_layouts_title_description">', '</div>' );
		
						?></div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php
}
?>