<?php
/**
 * Information about this theme
 *
 * @package WordPress
 * @subpackage HOGWORDS
 * @since HOGWORDS 1.0.30
 */


// Redirect to the 'About Theme' page after switch theme
if (!function_exists('hogwords_about_after_switch_theme')) {
	add_action('after_switch_theme', 'hogwords_about_after_switch_theme', 1000);
	function hogwords_about_after_switch_theme() {
		update_option('hogwords_about_page', 1);
	}
}
if ( !function_exists('hogwords_about_after_setup_theme') ) {
	add_action( 'init', 'hogwords_about_after_setup_theme', 1000 );
	function hogwords_about_after_setup_theme() {
		if (get_option('hogwords_about_page') == 1) {
			update_option('hogwords_about_page', 0);
			wp_safe_redirect(admin_url().'themes.php?page=hogwords_about');
			exit();
		}
	}
}


// Add 'About Theme' item in the Appearance menu
if (!function_exists('hogwords_about_add_menu_items')) {
	add_action( 'admin_menu', 'hogwords_about_add_menu_items' );
	function hogwords_about_add_menu_items() {
		$theme = wp_get_theme();
		$theme_name = $theme->name . (HOGWORDS_THEME_FREE ? ' ' . esc_html__('Free', 'hogwords') : '');
		add_theme_page(
			// Translators: Add theme name to the page title
			sprintf(esc_html__('About %s', 'hogwords'), $theme_name),	//page_title
			// Translators: Add theme name to the menu title
			sprintf(esc_html__('About %s', 'hogwords'), $theme_name),	//menu_title
			'manage_options',											//capability
			'hogwords_about',											//menu_slug
			'hogwords_about_page_builder'								//callback

		);
	}
}


// Load page-specific scripts and styles
if (!function_exists('hogwords_about_enqueue_scripts')) {
	add_action( 'admin_enqueue_scripts', 'hogwords_about_enqueue_scripts' );
	function hogwords_about_enqueue_scripts() {
		$screen = function_exists('get_current_screen') ? get_current_screen() : false;
		if (is_object($screen) && $screen->id == 'appearance_page_hogwords_about') {
			// Scripts
			wp_enqueue_script( 'jquery-ui-tabs', false, array('jquery', 'jquery-ui-core'), null, true );
			
			if (function_exists('hogwords_plugins_installer_enqueue_scripts'))
				hogwords_plugins_installer_enqueue_scripts();
			
			// Styles
			wp_enqueue_style( 'fontello-icons',  hogwords_get_file_url('css/font-icons/css/fontello-embedded.css'), array(), null );
			if ( ($fdir = hogwords_get_file_url('theme-specific/theme.about/theme.about.css')) != '' )
				wp_enqueue_style( 'hogwords-about',  $fdir, array(), null );
		}
	}
}


// Build 'About Theme' page
if (!function_exists('hogwords_about_page_builder')) {
	function hogwords_about_page_builder() {
		$theme = wp_get_theme();
		?>
		<div class="hogwords_about">
			<div class="hogwords_about_header">
				<div class="hogwords_about_logo"><?php
					$logo = hogwords_get_file_url('theme-specific/theme.about/logo.jpg');
					if (empty($logo)) $logo = hogwords_get_file_url('screenshot.jpg');
					if (!empty($logo)) {
						?><img src="<?php echo esc_url($logo); ?>"><?php
					}
				?></div>
				
				<?php if (HOGWORDS_THEME_FREE) { ?>
					<a href="<?php echo esc_url(hogwords_storage_get('theme_download_url')); ?>"
										   target="_blank"
										   class="hogwords_about_pro_link button button-primary"><?php
											esc_html_e('Get PRO version', 'hogwords');
										?></a>
				<?php } ?>
				<h1 class="hogwords_about_title"><?php
					// Translators: Add theme name and version to the 'Welcome' message
					echo esc_html(sprintf(esc_html__('Welcome to %1$s %2$s v.%3$s', 'hogwords'),
								$theme->name,
								HOGWORDS_THEME_FREE ? esc_html__('Free', 'hogwords') : '',
								$theme->version
								));
				?></h1>
				<div class="hogwords_about_description">
					<?php
					if (HOGWORDS_THEME_FREE) {
						?><p><?php
							// Translators: Add the download url and the theme name to the message
							echo wp_kses_data(sprintf(__('Now you are using Free version of <a href="%1$s">%2$s Pro Theme</a>.', 'hogwords'),
														esc_url(hogwords_storage_get('theme_download_url')),
														$theme->name
														)
												);
							// Translators: Add the theme name and supported plugins list to the message
							echo '<br>' . wp_kses_data(sprintf(__('This version is SEO- and Retina-ready. It also has a built-in support for parallax and slider with swipe gestures. %1$s Free is compatible with many popular plugins, such as %2$s', 'hogwords'),
														$theme->name,
														hogwords_about_get_supported_plugins()
														)
												);
						?></p>
						<p><?php
							// Translators: Add the download url to the message
							echo wp_kses_data(sprintf(__('We hope you have a great acquaintance with our themes. If you are looking for a fully functional website, you can get the <a href="%s">Pro Version here</a>', 'hogwords'),
														esc_url(hogwords_storage_get('theme_download_url'))
														)
												);
						?></p><?php
					} else {
						?><p><?php
							// Translators: Add the theme name to the message
							echo wp_kses_data(sprintf(__('%s is a Premium WordPress theme. It has a built-in support for parallax, slider with swipe gestures, and is SEO- and Retina-ready', 'hogwords'),
														$theme->name
														)
												);
						?></p>
						<p><?php
							// Translators: Add supported plugins list to the message
							echo wp_kses_data(sprintf(__('The Premium Theme is compatible with many popular plugins, such as %s', 'hogwords'),
														hogwords_about_get_supported_plugins()
														)
												);
						?></p><?php
					}
					?>
				</div>
			</div>
			<div id="hogwords_about_tabs" class="hogwords_tabs hogwords_about_tabs">
				<ul>
					<li><a href="#hogwords_about_section_start"><?php esc_html_e('Getting started', 'hogwords'); ?></a></li>
					<li><a href="#hogwords_about_section_actions"><?php esc_html_e('Recommended actions', 'hogwords'); ?></a></li>
					<?php if (HOGWORDS_THEME_FREE) { ?>
						<li><a href="#hogwords_about_section_pro"><?php esc_html_e('Free vs PRO', 'hogwords'); ?></a></li>
					<?php } ?>
				</ul>
				<div id="hogwords_about_section_start" class="hogwords_tabs_section hogwords_about_section"><?php
				
					// Install required plugins
					if (!HOGWORDS_THEME_FREE_WP && !hogwords_exists_trx_addons()) {
						?><div class="hogwords_about_block"><div class="hogwords_about_block_inner">
							<h2 class="hogwords_about_block_title">
								<i class="dashicons dashicons-admin-plugins"></i>
								<?php esc_html_e('ThemeREX Addons', 'hogwords'); ?>
							</h2>
							<div class="hogwords_about_block_description"><?php
								esc_html_e('It is highly recommended that you install the companion plugin "ThemeREX Addons" to have access to the layouts builder, awesome shortcodes, team and testimonials, services and slider, and many other features ...', 'hogwords');
							?></div>
							<?php hogwords_plugins_installer_get_button_html('trx_addons'); ?>
						</div></div><?php
					}
					
					// Install recommended plugins
					?><div class="hogwords_about_block"><div class="hogwords_about_block_inner">
						<h2 class="hogwords_about_block_title">
							<i class="dashicons dashicons-admin-plugins"></i>
							<?php esc_html_e('Recommended plugins', 'hogwords'); ?>
						</h2>
						<div class="hogwords_about_block_description"><?php
							// Translators: Add the theme name to the message
							echo esc_html(sprintf(esc_html__('Theme %s is compatible with a large number of popular plugins. You can install only those that are going to use in the near future.', 'hogwords'), $theme->name));
						?></div>
						<a href="<?php echo esc_url(admin_url().'themes.php?page=tgmpa-install-plugins'); ?>"
						   class="hogwords_about_block_link button button-primary"><?php
							esc_html_e('Install plugins', 'hogwords');
						?></a>
					</div></div><?php
					
					// Customizer or Theme Options
					?><div class="hogwords_about_block"><div class="hogwords_about_block_inner">
						<h2 class="hogwords_about_block_title">
							<i class="dashicons dashicons-admin-appearance"></i>
							<?php esc_html_e('Setup Theme options', 'hogwords'); ?>
						</h2>
						<div class="hogwords_about_block_description"><?php
							esc_html_e('Using the WordPress Customizer you can easily customize every aspect of the theme. If you want to use the standard theme settings page - open Theme Options and follow the same steps there.', 'hogwords');
						?></div>
						<a href="<?php echo esc_url(admin_url().'customize.php'); ?>"
						   class="hogwords_about_block_link button button-primary"><?php
							esc_html_e('Customizer', 'hogwords');
						?></a>
						<?php esc_html_e('or', 'hogwords'); ?>
						<a href="<?php echo esc_url(admin_url().'themes.php?page=theme_options'); ?>"
						   class="hogwords_about_block_link button"><?php
							esc_html_e('Theme Options', 'hogwords');
						?></a>
					</div></div><?php
					
					// Documentation
					?><div class="hogwords_about_block"><div class="hogwords_about_block_inner">
						<h2 class="hogwords_about_block_title">
							<i class="dashicons dashicons-book"></i>
							<?php esc_html_e('Read full documentation', 'hogwords');	?>
						</h2>
						<div class="hogwords_about_block_description"><?php
							// Translators: Add the theme name to the message
							echo esc_html(sprintf(esc_html__('Need more details? Please check our full online documentation for detailed information on how to use %s.', 'hogwords'), $theme->name));
						?></div>
						<a href="<?php echo esc_url(hogwords_storage_get('theme_doc_url')); ?>"
						   target="_blank"
						   class="hogwords_about_block_link button button-primary"><?php
							esc_html_e('Documentation', 'hogwords');
						?></a>
					</div></div><?php
					
					// Video tutorials
					?><div class="hogwords_about_block"><div class="hogwords_about_block_inner">
						<h2 class="hogwords_about_block_title">
							<i class="dashicons dashicons-video-alt2"></i>
							<?php esc_html_e('Video tutorials', 'hogwords');	?>
						</h2>
						<div class="hogwords_about_block_description"><?php
							// Translators: Add the theme name to the message
							echo esc_html(sprintf(esc_html__('No time for reading documentation? Check out our video tutorials and learn how to customize %s in detail.', 'hogwords'), $theme->name));
						?></div>
						<a href="<?php echo esc_url(hogwords_storage_get('theme_video_url')); ?>"
						   target="_blank"
						   class="hogwords_about_block_link button button-primary"><?php
							esc_html_e('Watch videos', 'hogwords');
						?></a>
					</div></div><?php
					
					// Support
					if (!HOGWORDS_THEME_FREE) {
						?><div class="hogwords_about_block"><div class="hogwords_about_block_inner">
							<h2 class="hogwords_about_block_title">
								<i class="dashicons dashicons-sos"></i>
								<?php esc_html_e('Support', 'hogwords'); ?>
							</h2>
							<div class="hogwords_about_block_description"><?php
								// Translators: Add the theme name to the message
								echo esc_html(sprintf(esc_html__('We want to make sure you have the best experience using %s and that is why we gathered here all the necessary informations for you.', 'hogwords'), $theme->name));
							?></div>
							<a href="<?php echo esc_url(hogwords_storage_get('theme_support_url')); ?>"
							   target="_blank"
							   class="hogwords_about_block_link button button-primary"><?php
								esc_html_e('Support', 'hogwords');
							?></a>
						</div></div><?php
					}
					
					// Online Demo
					?><div class="hogwords_about_block"><div class="hogwords_about_block_inner">
						<h2 class="hogwords_about_block_title">
							<i class="dashicons dashicons-images-alt2"></i>
							<?php esc_html_e('On-line demo', 'hogwords'); ?>
						</h2>
						<div class="hogwords_about_block_description"><?php
							// Translators: Add the theme name to the message
							echo esc_html(sprintf(esc_html__('Visit the Demo Version of %s to check out all the features it has', 'hogwords'), $theme->name));
						?></div>
						<a href="<?php echo esc_url(hogwords_storage_get('theme_demo_url')); ?>"
						   target="_blank"
						   class="hogwords_about_block_link button button-primary"><?php
							esc_html_e('View demo', 'hogwords');
						?></a>
					</div></div>
					
				</div>



				<div id="hogwords_about_section_actions" class="hogwords_tabs_section hogwords_about_section"><?php
				
					// Install required plugins
					if (!HOGWORDS_THEME_FREE_WP && !hogwords_exists_trx_addons()) {
						?><div class="hogwords_about_block"><div class="hogwords_about_block_inner">
							<h2 class="hogwords_about_block_title">
								<i class="dashicons dashicons-admin-plugins"></i>
								<?php esc_html_e('ThemeREX Addons', 'hogwords'); ?>
							</h2>
							<div class="hogwords_about_block_description"><?php
								esc_html_e('It is highly recommended that you install the companion plugin "ThemeREX Addons" to have access to the layouts builder, awesome shortcodes, team and testimonials, services and slider, and many other features ...', 'hogwords');
							?></div>
							<?php hogwords_plugins_installer_get_button_html('trx_addons'); ?>
						</div></div><?php
					}
					
					// Install recommended plugins
					?><div class="hogwords_about_block"><div class="hogwords_about_block_inner">
						<h2 class="hogwords_about_block_title">
							<i class="dashicons dashicons-admin-plugins"></i>
							<?php esc_html_e('Recommended plugins', 'hogwords'); ?>
						</h2>
						<div class="hogwords_about_block_description"><?php
							// Translators: Add the theme name to the message
							echo esc_html(sprintf(esc_html__('Theme %s is compatible with a large number of popular plugins. You can install only those that are going to use in the near future.', 'hogwords'), $theme->name));
						?></div>
						<a href="<?php echo esc_url(admin_url().'themes.php?page=tgmpa-install-plugins'); ?>"
						   class="hogwords_about_block_link button button button-primary"><?php
							esc_html_e('Install plugins', 'hogwords');
						?></a>
					</div></div><?php
					
					// Customizer or Theme Options
					?><div class="hogwords_about_block"><div class="hogwords_about_block_inner">
						<h2 class="hogwords_about_block_title">
							<i class="dashicons dashicons-admin-appearance"></i>
							<?php esc_html_e('Setup Theme options', 'hogwords'); ?>
						</h2>
						<div class="hogwords_about_block_description"><?php
							esc_html_e('Using the WordPress Customizer you can easily customize every aspect of the theme. If you want to use the standard theme settings page - open Theme Options and follow the same steps there.', 'hogwords');
						?></div>
						<a href="<?php echo esc_url(admin_url().'customize.php'); ?>"
						   target="_blank"
						   class="hogwords_about_block_link button button-primary"><?php
							esc_html_e('Customizer', 'hogwords');
						?></a>
						<?php esc_html_e('or', 'hogwords'); ?>
						<a href="<?php echo esc_url(admin_url().'themes.php?page=theme_options'); ?>"
						   class="hogwords_about_block_link button"><?php
							esc_html_e('Theme Options', 'hogwords');
						?></a>
					</div></div>
					
				</div>



				<?php if (HOGWORDS_THEME_FREE) { ?>
					<div id="hogwords_about_section_pro" class="hogwords_tabs_section hogwords_about_section">
						<table class="hogwords_about_table" cellpadding="0" cellspacing="0" border="0">
							<thead>
								<tr>
									<td class="hogwords_about_table_info">&nbsp;</td>
									<td class="hogwords_about_table_check"><?php
										// Translators: Show theme name with suffix 'Free'
										echo esc_html(sprintf(esc_html__('%s Free', 'hogwords'), $theme->name));
									?></td>
									<td class="hogwords_about_table_check"><?php
										// Translators: Show theme name with suffix 'PRO'
										echo esc_html(sprintf(esc_html__('%s PRO', 'hogwords'), $theme->name));
									?></td>
								</tr>
							</thead>
							<tbody>
	
	
								<?php
								// Responsive layouts
								?>
								<tr>
									<td class="hogwords_about_table_info">
										<h2 class="hogwords_about_table_info_title">
											<?php esc_html_e('Mobile friendly', 'hogwords'); ?>
										</h2>
										<div class="hogwords_about_table_info_description"><?php
											esc_html_e('Responsive layout. Looks great on any device.', 'hogwords');
										?></div>
									</td>
									<td class="hogwords_about_table_check"><i class="dashicons dashicons-yes"></i></td>
									<td class="hogwords_about_table_check"><i class="dashicons dashicons-yes"></i></td>
								</tr>
	
								<?php
								// Built-in slider
								?>
								<tr>
									<td class="hogwords_about_table_info">
										<h2 class="hogwords_about_table_info_title">
											<?php esc_html_e('Built-in posts slider', 'hogwords'); ?>
										</h2>
										<div class="hogwords_about_table_info_description"><?php
											esc_html_e('Allows you to add beautiful slides using the built-in shortcode/widget "Slider" with swipe gestures support.', 'hogwords');
										?></div>
									</td>
									<td class="hogwords_about_table_check"><i class="dashicons dashicons-yes"></i></td>
									<td class="hogwords_about_table_check"><i class="dashicons dashicons-yes"></i></td>
								</tr>
	
								<?php
								// Revolution slider
								if (hogwords_storage_isset('required_plugins', 'revslider')) {
								?>
								<tr>
									<td class="hogwords_about_table_info">
										<h2 class="hogwords_about_table_info_title">
											<?php esc_html_e('Revolution Slider Compatibility', 'hogwords'); ?>
										</h2>
										<div class="hogwords_about_table_info_description"><?php
											esc_html_e('Our built-in shortcode/widget "Slider" is able to work not only with posts, but also with slides created  in "Revolution Slider".', 'hogwords');
										?></div>
									</td>
									<td class="hogwords_about_table_check"><i class="dashicons dashicons-yes"></i></td>
									<td class="hogwords_about_table_check"><i class="dashicons dashicons-yes"></i></td>
								</tr>
								<?php } ?>
	
								<?php
								// SiteOrigin Panels
								if (hogwords_storage_isset('required_plugins', 'siteorigin-panels')) {
								?>
								<tr>
									<td class="hogwords_about_table_info">
										<h2 class="hogwords_about_table_info_title">
											<?php esc_html_e('Free PageBuilder', 'hogwords'); ?>
										</h2>
										<div class="hogwords_about_table_info_description"><?php
											esc_html_e('Full integration with a nice free page builder "SiteOrigin Panels".', 'hogwords');
										?></div>
									</td>
									<td class="hogwords_about_table_check"><i class="dashicons dashicons-yes"></i></td>
									<td class="hogwords_about_table_check"><i class="dashicons dashicons-yes"></i></td>
								</tr>
								<tr>
									<td class="hogwords_about_table_info">
										<h2 class="hogwords_about_table_info_title">
											<?php esc_html_e('Additional widgets pack', 'hogwords'); ?>
										</h2>
										<div class="hogwords_about_table_info_description"><?php
											esc_html_e('A number of useful widgets to create beautiful homepages and other sections of your website with SiteOrigin Panels.', 'hogwords');
										?></div>
									</td>
									<td class="hogwords_about_table_check"><i class="dashicons dashicons-no"></i></td>
									<td class="hogwords_about_table_check"><i class="dashicons dashicons-yes"></i></td>
								</tr>
								<?php } ?>
	
								<?php
								// WPBakery Page Builder
								?>
								<tr>
									<td class="hogwords_about_table_info">
										<h2 class="hogwords_about_table_info_title">
											<?php esc_html_e('WPBakery Page Builder', 'hogwords'); ?>
										</h2>
										<div class="hogwords_about_table_info_description"><?php
											esc_html_e('Full integration with a very popular page builder "WPBakery Page Builder". A number of useful shortcodes and widgets to create beautiful homepages and other sections of your website.', 'hogwords');
										?></div>
									</td>
									<td class="hogwords_about_table_check"><i class="dashicons dashicons-no"></i></td>
									<td class="hogwords_about_table_check"><i class="dashicons dashicons-yes"></i></td>
								</tr>
								<tr>
									<td class="hogwords_about_table_info">
										<h2 class="hogwords_about_table_info_title">
											<?php esc_html_e('Additional shortcodes pack', 'hogwords'); ?>
										</h2>
										<div class="hogwords_about_table_info_description"><?php
											esc_html_e('A number of useful shortcodes to create beautiful homepages and other sections of your website with WPBakery Page Builder.', 'hogwords');
										?></div>
									</td>
									<td class="hogwords_about_table_check"><i class="dashicons dashicons-no"></i></td>
									<td class="hogwords_about_table_check"><i class="dashicons dashicons-yes"></i></td>
								</tr>
	
								<?php
								// Layouts builder
								?>
								<tr>
									<td class="hogwords_about_table_info">
										<h2 class="hogwords_about_table_info_title">
											<?php esc_html_e('Headers and Footers builder', 'hogwords'); ?>
										</h2>
										<div class="hogwords_about_table_info_description"><?php
											esc_html_e('Powerful visual builder of headers and footers! No manual code editing - use all the advantages of drag-and-drop technology.', 'hogwords');
										?></div>
									</td>
									<td class="hogwords_about_table_check"><i class="dashicons dashicons-no"></i></td>
									<td class="hogwords_about_table_check"><i class="dashicons dashicons-yes"></i></td>
								</tr>
	
								<?php
								// WooCommerce
								if (hogwords_storage_isset('required_plugins', 'woocommerce')) {
								?>
								<tr>
									<td class="hogwords_about_table_info">
										<h2 class="hogwords_about_table_info_title">
											<?php esc_html_e('WooCommerce Compatibility', 'hogwords'); ?>
										</h2>
										<div class="hogwords_about_table_info_description"><?php
											esc_html_e('Ready for e-commerce. You can build an online store with this theme.', 'hogwords');
										?></div>
									</td>
									<td class="hogwords_about_table_check"><i class="dashicons dashicons-yes"></i></td>
									<td class="hogwords_about_table_check"><i class="dashicons dashicons-yes"></i></td>
								</tr>
								<?php } ?>
	
								<?php
								// Easy Digital Downloads
								if (hogwords_storage_isset('required_plugins', 'easy-digital-downloads')) {
								?>
								<tr>
									<td class="hogwords_about_table_info">
										<h2 class="hogwords_about_table_info_title">
											<?php esc_html_e('Easy Digital Downloads Compatibility', 'hogwords'); ?>
										</h2>
										<div class="hogwords_about_table_info_description"><?php
											esc_html_e('Ready for digital e-commerce. You can build an online digital store with this theme.', 'hogwords');
										?></div>
									</td>
									<td class="hogwords_about_table_check"><i class="dashicons dashicons-no"></i></td>
									<td class="hogwords_about_table_check"><i class="dashicons dashicons-yes"></i></td>
								</tr>
								<?php } ?>
	
								<?php
								// Other plugins
								?>
								<tr>
									<td class="hogwords_about_table_info">
										<h2 class="hogwords_about_table_info_title">
											<?php esc_html_e('Many other popular plugins compatibility', 'hogwords'); ?>
										</h2>
										<div class="hogwords_about_table_info_description"><?php
											esc_html_e('PRO version is compatible (was tested and has built-in support) with many popular plugins.', 'hogwords');
										?></div>
									</td>
									<td class="hogwords_about_table_check"><i class="dashicons dashicons-no"></i></td>
									<td class="hogwords_about_table_check"><i class="dashicons dashicons-yes"></i></td>
								</tr>
	
								<?php
								// Support
								?>
								<tr>
									<td class="hogwords_about_table_info">
										<h2 class="hogwords_about_table_info_title">
											<?php esc_html_e('Support', 'hogwords'); ?>
										</h2>
										<div class="hogwords_about_table_info_description"><?php
											esc_html_e('Our premium support is going to take care of any problems, in case there will be any of course.', 'hogwords');
										?></div>
									</td>
									<td class="hogwords_about_table_check"><i class="dashicons dashicons-no"></i></td>
									<td class="hogwords_about_table_check"><i class="dashicons dashicons-yes"></i></td>
								</tr>
	
								<?php
								// Get PRO version
								?>
								<tr>
									<td class="hogwords_about_table_info">&nbsp;</td>
									<td class="hogwords_about_table_check" colspan="2">
										<a href="<?php echo esc_url(hogwords_storage_get('theme_download_url')); ?>"
										   target="_blank"
										   class="hogwords_about_block_link hogwords_about_pro_link button button-primary"><?php
											esc_html_e('Get PRO version', 'hogwords');
										?></a>
									</td>
								</tr>
	
							</tbody>
						</table>
					</div>
				<?php } ?>
				
			</div>
		</div>
		<?php
	}
}


// Utils
//------------------------------------

// Return supported plugin's names
if (!function_exists('hogwords_about_get_supported_plugins')) {
	function hogwords_about_get_supported_plugins() {
		return '"' . join('", "', array_values(hogwords_storage_get('required_plugins'))) . '"';
	}
}

require_once HOGWORDS_THEME_DIR . 'includes/plugins.installer/plugins.installer.php';
?>