<?php
/**
 * The Footer: widgets area, logo, footer menu and socials
 *
 * @package WordPress
 * @subpackage HOGWORDS
 * @since HOGWORDS 1.0
 */

						// Widgets area inside page content
						hogwords_create_widgets_area('widgets_below_content');
						?>				
					</div><!-- </.content> -->

					<?php
					// Show main sidebar
					get_sidebar();

					// Widgets area below page content
					hogwords_create_widgets_area('widgets_below_page');

					$hogwords_body_style = hogwords_get_theme_option('body_style');
					if ($hogwords_body_style != 'fullscreen') {
						?></div><!-- </.content_wrap> --><?php
					}
					?>
			</div><!-- </.page_content_wrap> -->

			<?php
			// Footer
			$hogwords_footer_type = hogwords_get_theme_option("footer_type");
			if ($hogwords_footer_type == 'custom' && !hogwords_is_layouts_available())
				$hogwords_footer_type = 'default';
			get_template_part( "templates/footer-{$hogwords_footer_type}");
			?>

		</div><!-- /.page_wrap -->

	</div><!-- /.body_wrap -->

	<?php if (hogwords_is_on(hogwords_get_theme_option('debug_mode')) && hogwords_get_file_dir('images/makeup.jpg')!='') { ?>
		<img src="<?php echo esc_url(hogwords_get_file_url('images/makeup.jpg')); ?>" id="makeup">
	<?php } ?>

	<?php wp_footer(); ?>

</body>
</html>