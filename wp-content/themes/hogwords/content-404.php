<article <?php post_class( 'post_item_single post_item_404' ); ?>>
	<div class="post_content">
		<div class="page_info">
			<h1 class="page_title"><?php esc_html_e( '404', 'hogwords' ); ?></h1>
			<h3 class="page_subtitle"><?php esc_html_e('The Requested Page cannot be Found', 'hogwords'); ?></h3>
			<p class="page_description"><?php echo wp_kses(__("Can't find what you need? Take a moment and do a search below or start from our homepage.", 'hogwords'), 'hogwords_kses_content'); ?></p>
			<a href="<?php echo esc_url(home_url('/')); ?>" class="go_home theme_button"><?php esc_html_e('Homepage', 'hogwords'); ?></a>
		</div>
		<div class="post_404_img_bg_right">
		</div>
	</div>
</article>
