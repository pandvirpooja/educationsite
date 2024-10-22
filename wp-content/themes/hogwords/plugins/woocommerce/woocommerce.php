<?php
/* Woocommerce support functions
------------------------------------------------------------------------------- */

// Theme init priorities:
// 1 - register filters, that add/remove lists items for the Theme Options
if (!function_exists('hogwords_woocommerce_theme_setup1')) {
	add_action( 'after_setup_theme', 'hogwords_woocommerce_theme_setup1', 1 );
	function hogwords_woocommerce_theme_setup1() {

		add_theme_support( 'woocommerce', array( 'product_grid' => array( 'max_columns' => 4 ) ) );

		// Next setting from the WooCommerce 3.0+ enable built-in image zoom on the single product page
		add_theme_support( 'wc-product-gallery-zoom' );

		// Next setting from the WooCommerce 3.0+ enable built-in image slider on the single product page
		add_theme_support( 'wc-product-gallery-slider' );

		// Next setting from the WooCommerce 3.0+ enable built-in image lightbox on the single product page
		add_theme_support( 'wc-product-gallery-lightbox' );

		add_filter( 'hogwords_filter_list_sidebars', 	'hogwords_woocommerce_list_sidebars' );
		add_filter( 'hogwords_filter_list_posts_types',	'hogwords_woocommerce_list_post_types');
	}
}

// Theme init priorities:
// 3 - add/remove Theme Options elements
if (!function_exists('hogwords_woocommerce_theme_setup3')) {
	add_action( 'after_setup_theme', 'hogwords_woocommerce_theme_setup3', 3 );
	function hogwords_woocommerce_theme_setup3() {
		if (hogwords_exists_woocommerce()) {

			// Section 'WooCommerce'
			hogwords_storage_set_array_before('options', 'fonts', array_merge(
				array(
					'shop' => array(
						"title" => esc_html__('Shop', 'hogwords'),
						"desc" => wp_kses_data( __('Select parameters to display the shop pages', 'hogwords') ),
						"priority" => 80,
						"type" => "section"
						),

					'products_info_shop' => array(
						"title" => esc_html__('Products list', 'hogwords'),
						"desc" => '',
						"type" => "info",
						),
					'shop_mode' => array(
						"title" => esc_html__('Shop mode', 'hogwords'),
						"desc" => wp_kses_data( __('Select style for the products list', 'hogwords') ),
						"std" => 'thumbs',
						"options" => array(
							'thumbs'=> esc_html__('Thumbnails', 'hogwords'),
							'list'	=> esc_html__('List', 'hogwords'),
						),
						"type" => "select"
						),
					'shop_hover' => array(
						"title" => esc_html__('Hover style', 'hogwords'),
						"desc" => wp_kses_data( __('Hover style on the products in the shop archive', 'hogwords') ),
						"std" => 'shop_buttons',
						"options" => apply_filters('hogwords_filter_shop_hover', array(
							'none' => esc_html__('None', 'hogwords'),
							'shop' => esc_html__('Icons', 'hogwords'),
							'shop_buttons' => esc_html__('Buttons', 'hogwords')
						)),
						"type" => "select"
						),

					'single_info_shop' => array(
						"title" => esc_html__('Single product', 'hogwords'),
						"desc" => '',
						"type" => "info",
						),
					'stretch_tabs_area' => array(
						"title" => esc_html__('Stretch tabs area', 'hogwords'),
						"desc" => wp_kses_data( __('Stretch area with tabs on the single product to the screen width if the sidebar is hidden', 'hogwords') ),
						"std" => 1,
						"type" => "checkbox"
						),
					'show_related_posts_shop' => array(
						"title" => esc_html__('Show related products', 'hogwords'),
						"desc" => wp_kses_data( __("Show section 'Related products' on the single product page", 'hogwords') ),
						"std" => 1,
						"type" => "checkbox"
						),
					'related_posts_shop' => array(
						"title" => esc_html__('Related products', 'hogwords'),
						"desc" => wp_kses_data( __('How many related products should be displayed on the single product page?', 'hogwords') ),
						"dependency" => array(
							'show_related_posts_shop' => array(1)
						),
						"std" => 3,
						"options" => hogwords_get_list_range(1,9),
						"type" => "select"
						),
					'related_columns_shop' => array(
						"title" => esc_html__('Related columns', 'hogwords'),
						"desc" => wp_kses_data( __('How many columns should be used to output related products on the single product page?', 'hogwords') ),
						"dependency" => array(
							'show_related_posts_shop' => array(1)
						),
						"std" => 3,
						"options" => hogwords_get_list_range(1,4),
						"type" => "select"
						)
				),
				hogwords_options_get_list_cpt_options('shop')
			));
		}
	}
}


// Add section 'Products' to the Front Page option
if (!function_exists('hogwords_woocommerce_front_page_options')) {
	if (!HOGWORDS_THEME_FREE) add_filter( 'hogwords_filter_front_page_options', 'hogwords_woocommerce_front_page_options' );
	function hogwords_woocommerce_front_page_options($options) {
		if (hogwords_exists_woocommerce()) {

			$options['front_page_sections']['std'] .= (!empty($options['front_page_sections']['std']) ? '|' : '') . 'woocommerce=1';
			$options['front_page_sections']['options'] = array_merge($options['front_page_sections']['options'],
																	array(
																		'woocommerce' => esc_html__('Products', 'hogwords')
																		)
																	);
			$options = array_merge($options, array(

				// Front Page Sections - WooCommerce
				'front_page_woocommerce' => array(
					"title" => esc_html__('Products', 'hogwords'),
					"desc" => '',
					"priority" => 200,
					"type" => "section",
					),
				'front_page_woocommerce_layout_info' => array(
					"title" => esc_html__('Layout', 'hogwords'),
					"desc" => '',
					"type" => "info",
					),
				'front_page_woocommerce_fullheight' => array(
					"title" => esc_html__('Full height', 'hogwords'),
					"desc" => wp_kses_data( __('Stretch this section to the window height', 'hogwords') ),
					"std" => 0,
					"refresh" => false,
					"type" => "checkbox"
					),
				'front_page_woocommerce_paddings' => array(
					"title" => esc_html__('Paddings', 'hogwords'),
					"desc" => wp_kses_data( __('Select paddings inside this section', 'hogwords') ),
					"std" => 'medium',
					"options" => hogwords_get_list_paddings(),
					"refresh" => false,
					"type" => "switch"
					),
				'front_page_woocommerce_heading_info' => array(
					"title" => esc_html__('Title', 'hogwords'),
					"desc" => '',
					"type" => "info",
					),
				'front_page_woocommerce_caption' => array(
					"title" => esc_html__('Section title', 'hogwords'),
					"desc" => '',
					"refresh" => false,
					"std" => wp_kses_data(__('This text can be changed in the section "Products"', 'hogwords')),
					"type" => "text"
					),
				'front_page_woocommerce_description' => array(
					"title" => esc_html__('Description', 'hogwords'),
					"desc" => wp_kses_data( __("Short description after the section's title", 'hogwords') ),
					"refresh" => false,
					"std" => wp_kses_data(__('This text can be changed in the section "Products"', 'hogwords')),
					"type" => "textarea"
					),
				'front_page_woocommerce_products_info' => array(
					"title" => esc_html__('Products parameters', 'hogwords'),
					"desc" => '',
					"type" => "info",
					),
				'front_page_woocommerce_products' => array(
					"title" => esc_html__('Type of the products', 'hogwords'),
					"desc" => '',
					"std" => 'products',
					"options" => array(
									'recent_products' => esc_html__('Recent products', 'hogwords'),
									'featured_products' => esc_html__('Featured products', 'hogwords'),
									'top_rated_products' => esc_html__('Top rated products', 'hogwords'),
									'sale_products' => esc_html__('Sale products', 'hogwords'),
									'best_selling_products' => esc_html__('Best selling products', 'hogwords'),
									'product_category' => esc_html__('Products from categories', 'hogwords'),
									'products' => esc_html__('Products by IDs', 'hogwords')
									),
					"type" => "select"
					),
				'front_page_woocommerce_products_categories' => array(
					"title" => esc_html__('Categories', 'hogwords'),
					"desc" => esc_html__('Comma separated category slugs. Used only with "Products from categories"', 'hogwords'),
					"dependency" => array(
						'front_page_woocommerce_products' => array('product_category')
					),
					"std" => '',
					"type" => "text"
					),
				'front_page_woocommerce_products_per_page' => array(
					"title" => esc_html__('Per page', 'hogwords'),
					"desc" => wp_kses_data( __('How many products will be displayed on the page. Attention! For "Products by IDs" specify comma separated list of the IDs', 'hogwords') ),
					"std" => 3,
					"type" => "text"
					),
				'front_page_woocommerce_products_columns' => array(
					"title" => esc_html__('Columns', 'hogwords'),
					"desc" => wp_kses_data( __("How many columns will be used", 'hogwords') ),
					"std" => 3,
					"type" => "text"
					),
				'front_page_woocommerce_products_orderby' => array(
					"title" => esc_html__('Order by', 'hogwords'),
					"desc" => wp_kses_data( __("Not used with Best selling products", 'hogwords') ),
					"std" => 'date',
					"options" => array(
									'date' => esc_html__('Date', 'hogwords'),
									'title' => esc_html__('Title', 'hogwords')
									),
					"type" => "switch"
					),
				'front_page_woocommerce_products_order' => array(
					"title" => esc_html__('Order', 'hogwords'),
					"desc" => wp_kses_data( __("Not used with Best selling products", 'hogwords') ),
					"std" => 'desc',
					"options" => array(
									'asc' => esc_html__('Ascending', 'hogwords'),
									'desc' => esc_html__('Descending', 'hogwords')
									),
					"type" => "switch"
					),
				'front_page_woocommerce_color_info' => array(
					"title" => esc_html__('Colors and images', 'hogwords'),
					"desc" => '',
					"type" => "info",
					),
				'front_page_woocommerce_scheme' => array(
					"title" => esc_html__('Color scheme', 'hogwords'),
					"desc" => wp_kses_data( __('Color scheme for this section', 'hogwords') ),
					"std" => 'inherit',
					"options" => array(),
					"refresh" => false,
					"type" => "switch"
					),
				'front_page_woocommerce_bg_image' => array(
					"title" => esc_html__('Background image', 'hogwords'),
					"desc" => wp_kses_data( __('Select or upload background image for this section', 'hogwords') ),
					"refresh" => '.front_page_section_woocommerce',
					"refresh_wrapper" => true,
					"std" => '',
					"type" => "image"
					),
				'front_page_woocommerce_bg_color' => array(
					"title" => esc_html__('Background color', 'hogwords'),
					"desc" => wp_kses_data( __('Background color for this section', 'hogwords') ),
					"std" => '',
					"refresh" => false,
					"type" => "color"
					),
				'front_page_woocommerce_bg_mask' => array(
					"title" => esc_html__('Background mask', 'hogwords'),
					"desc" => wp_kses_data( __('Use Background color as section mask with specified opacity. If 0 - mask is not used', 'hogwords') ),
					"std" => 1,
					"max" => 1,
					"step" => 0.1,
					"refresh" => false,
					"type" => "slider"
					),
				'front_page_woocommerce_anchor_info' => array(
					"title" => esc_html__('Anchor', 'hogwords'),
					"desc" => wp_kses_data( __('You can select icon and/or specify a text to create anchor for this section and show it in the side menu (if selected in the section "Header - Menu".', 'hogwords'))
								. '<br>'
								. wp_kses_data(__('Attention! Anchors available only if plugin "hogwords Addons is installed and activated!', 'hogwords')),
					"type" => "info",
					),
				'front_page_woocommerce_anchor_icon' => array(
					"title" => esc_html__('Anchor icon', 'hogwords'),
					"desc" => '',
					"std" => '',
					"type" => "icon"
					),
				'front_page_woocommerce_anchor_text' => array(
					"title" => esc_html__('Anchor text', 'hogwords'),
					"desc" => '',
					"std" => '',
					"type" => "text"
					)
			));
		}
		return $options;
	}
}

// Theme init priorities:
// 9 - register other filters (for installer, etc.)
if (!function_exists('hogwords_woocommerce_theme_setup9')) {
	add_action( 'after_setup_theme', 'hogwords_woocommerce_theme_setup9', 9 );
	function hogwords_woocommerce_theme_setup9() {

		if (hogwords_exists_woocommerce()) {
			add_action( 'wp_enqueue_scripts', 								'hogwords_woocommerce_frontend_scripts', 1100 );
			add_filter( 'hogwords_filter_merge_styles',						'hogwords_woocommerce_merge_styles' );
			add_filter( 'hogwords_filter_merge_scripts',						'hogwords_woocommerce_merge_scripts');
			add_filter( 'hogwords_filter_get_post_info',		 				'hogwords_woocommerce_get_post_info');
			add_filter( 'hogwords_filter_post_type_taxonomy',				'hogwords_woocommerce_post_type_taxonomy', 10, 2 );
			add_action( 'hogwords_action_override_theme_options',			'hogwords_woocommerce_override_theme_options');
			if (!is_admin()) {
				add_filter( 'hogwords_filter_detect_blog_mode',				'hogwords_woocommerce_detect_blog_mode');
				add_filter( 'hogwords_filter_get_post_categories', 			'hogwords_woocommerce_get_post_categories');
				add_filter( 'hogwords_filter_allow_override_header_image',	'hogwords_woocommerce_allow_override_header_image');
				add_filter( 'hogwords_filter_get_blog_title',				'hogwords_woocommerce_get_blog_title');
				add_action( 'hogwords_action_before_post_meta',				'hogwords_woocommerce_action_before_post_meta');
				add_filter( 'hogwords_filter_localize_script',				'hogwords_woocommerce_localize_script');
			}
		}
		if (is_admin()) {
			add_filter( 'hogwords_filter_tgmpa_required_plugins',			'hogwords_woocommerce_tgmpa_required_plugins' );
		}

		// Add wrappers and classes to the standard WooCommerce output
		if (hogwords_exists_woocommerce()) {

			// Remove WOOC sidebar
			remove_action( 'woocommerce_sidebar', 						'woocommerce_get_sidebar', 10 );

			// Remove link around product item
			remove_action('woocommerce_before_shop_loop_item',			'woocommerce_template_loop_product_link_open', 10);
			remove_action('woocommerce_after_shop_loop_item',			'woocommerce_template_loop_product_link_close', 5);

			// Remove link around product category
			remove_action('woocommerce_before_subcategory',				'woocommerce_template_loop_category_link_open', 10);
			remove_action('woocommerce_after_subcategory',				'woocommerce_template_loop_category_link_close', 10);

			// Open main content wrapper - <article>
			remove_action( 'woocommerce_before_main_content',			'woocommerce_output_content_wrapper', 10);
			add_action(    'woocommerce_before_main_content',			'hogwords_woocommerce_wrapper_start', 10);
			// Close main content wrapper - </article>
			remove_action( 'woocommerce_after_main_content',			'woocommerce_output_content_wrapper_end', 10);
			add_action(    'woocommerce_after_main_content',			'hogwords_woocommerce_wrapper_end', 10);

			// Close header section
			add_action(    'woocommerce_after_main_content',			'hogwords_woocommerce_archive_description', 1);
			add_action(    'woocommerce_before_shop_loop',				'hogwords_woocommerce_archive_description', 5 );
			add_action(    'woocommerce_no_products_found',				'hogwords_woocommerce_archive_description', 5 );

			// Add theme specific search form
			add_filter(    'get_product_search_form',					'hogwords_woocommerce_get_product_search_form' );

			// Change text on 'Add to cart' button
			add_filter(    'woocommerce_product_add_to_cart_text',		'hogwords_woocommerce_add_to_cart_text' );
			add_filter(    'woocommerce_product_single_add_to_cart_text','hogwords_woocommerce_add_to_cart_text' );

			// Add list mode buttons
			add_action(    'woocommerce_before_shop_loop', 				'hogwords_woocommerce_before_shop_loop', 10 );

			// Open product/category item wrapper
			add_action(    'woocommerce_before_subcategory_title',		'hogwords_woocommerce_item_wrapper_start', 9 );
			add_action(    'woocommerce_before_shop_loop_item_title',	'hogwords_woocommerce_item_wrapper_start', 9 );
			// Close featured image wrapper and open title wrapper
			add_action(    'woocommerce_before_subcategory_title',		'hogwords_woocommerce_title_wrapper_start', 20 );
			add_action(    'woocommerce_before_shop_loop_item_title',	'hogwords_woocommerce_title_wrapper_start', 20 );

			// Add tags before title
			add_action(    'woocommerce_before_shop_loop_item_title',	'hogwords_woocommerce_title_tags', 30 );

			// Wrap product title into link
			add_action(    'the_title',									'hogwords_woocommerce_the_title');
			// Wrap category title into link
			add_action(		'woocommerce_shop_loop_subcategory_title',  'hogwords_woocommerce_shop_loop_subcategory_title', 9, 1);

			// Close title wrapper and add description in the list mode
			add_action(    'woocommerce_after_shop_loop_item_title',	'hogwords_woocommerce_title_wrapper_end', 7);
			add_action(    'woocommerce_after_subcategory_title',		'hogwords_woocommerce_title_wrapper_end2', 10 );
			// Close product/category item wrapper
			add_action(    'woocommerce_after_subcategory',				'hogwords_woocommerce_item_wrapper_end', 20 );
			add_action(    'woocommerce_after_shop_loop_item',			'hogwords_woocommerce_item_wrapper_end', 20 );

			// Add product ID into product meta section (after categories and tags)
			add_action(    'woocommerce_product_meta_end',				'hogwords_woocommerce_show_product_id', 10);

			// Set columns number for the product's thumbnails
			add_filter(    'woocommerce_product_thumbnails_columns',	'hogwords_woocommerce_product_thumbnails_columns' );

			// Decorate price
			add_filter(    'woocommerce_get_price_html',				'hogwords_woocommerce_get_price_html' );

			// Wrap a category title with a link (from WooCommerce 3.2.2+ )
			add_action( 'woocommerce_before_subcategory_title', 'hogwords_woocommerce_before_subcategory_title', 22, 1 );
			add_action( 'woocommerce_after_subcategory_title', 'hogwords_woocommerce_after_subcategory_title', 2, 1 );


			// Detect current shop mode
			if (!is_admin()) {
				$shop_mode = hogwords_get_value_gpc('hogwords_shop_mode');
				if (empty($shop_mode) && hogwords_check_theme_option('shop_mode'))
					$shop_mode = hogwords_get_theme_option('shop_mode');
				if (empty($shop_mode))
					$shop_mode = 'thumbs';
				hogwords_storage_set('shop_mode', $shop_mode);
			}
		}
	}
}

// Theme init priorities:
// Action 'wp'
// 1 - detect override mode. Attention! Only after this step you can use overriden options (separate values for the shop, courses, etc.)
if (!function_exists('hogwords_woocommerce_theme_setup_wp')) {
	add_action( 'wp', 'hogwords_woocommerce_theme_setup_wp' );
	function hogwords_woocommerce_theme_setup_wp() {
		if (hogwords_exists_woocommerce()) {
			// Set columns number for the related products
			if ((int) hogwords_get_theme_option('show_related_posts') == 0 || (int) hogwords_get_theme_option('related_posts') == 0) {
				remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20 );
			} else {
				add_filter(    'woocommerce_output_related_products_args',	'hogwords_woocommerce_output_related_products_args' );
				add_filter(    'woocommerce_related_products_columns',		'hogwords_woocommerce_related_products_columns' );
			}
		}
	}
}

// Filter to add in the required plugins list
if ( !function_exists( 'hogwords_woocommerce_tgmpa_required_plugins' ) ) {
	
	function hogwords_woocommerce_tgmpa_required_plugins($list=array()) {
		if (hogwords_storage_isset('required_plugins', 'woocommerce')) {
			$list[] = array(
					'name' 		=> hogwords_storage_get_array('required_plugins', 'woocommerce'),
					'slug' 		=> 'woocommerce',
					'required' 	=> false
				);
		}
		return $list;
	}
}


// Check if WooCommerce installed and activated
if ( !function_exists( 'hogwords_exists_woocommerce' ) ) {
	function hogwords_exists_woocommerce() {
		return class_exists('Woocommerce');
	}
}

// Return true, if current page is any woocommerce page
if ( !function_exists( 'hogwords_is_woocommerce_page' ) ) {
	function hogwords_is_woocommerce_page() {
		$rez = false;
		if (hogwords_exists_woocommerce())
			$rez = is_woocommerce() || is_shop() || is_product() || is_product_category() || is_product_tag() || is_product_taxonomy() || is_cart() || is_checkout() || is_account_page();
		return $rez;
	}
}

// Detect current blog mode
if ( !function_exists( 'hogwords_woocommerce_detect_blog_mode' ) ) {
	
	function hogwords_woocommerce_detect_blog_mode($mode='') {
		if (is_shop() || is_product_category() || is_product_tag() || is_product_taxonomy())
			$mode = 'shop';
		else if (is_product() || is_cart() || is_checkout() || is_account_page())
			$mode = 'shop';
		return $mode;
	}
}

// Override options with stored page meta on 'Shop' pages
if ( !function_exists('hogwords_woocommerce_override_theme_options') ) {
	
	function hogwords_woocommerce_override_theme_options() {
		// Remove ' || is_product()' from the condition in the next row
		// if you don't need to override theme options from the page 'Shop' on single products
		if (is_shop() || is_product_category() || is_product_tag() || is_product_taxonomy() || is_product()) {
			if (($id = hogwords_woocommerce_get_shop_page_id()) > 0)
				hogwords_storage_set('options_meta', get_post_meta($id, 'hogwords_options', true));
		}
	}
}

// Return current page title
if ( !function_exists( 'hogwords_woocommerce_get_blog_title' ) ) {
	
	function hogwords_woocommerce_get_blog_title($title='') {
		if (!hogwords_exists_trx_addons() && hogwords_exists_woocommerce() && hogwords_is_woocommerce_page() && is_shop()) {
			$id = hogwords_woocommerce_get_shop_page_id();
			$title = $id ? get_the_title($id) : esc_html__('Shop', 'hogwords');
		}
		return $title;
	}
}


// Return taxonomy for current post type
if ( !function_exists( 'hogwords_woocommerce_post_type_taxonomy' ) ) {
	
	function hogwords_woocommerce_post_type_taxonomy($tax='', $post_type='') {
		if ($post_type == 'product')
			$tax = 'product_cat';
		return $tax;
	}
}

// Return true if page title section is allowed
if ( !function_exists( 'hogwords_woocommerce_allow_override_header_image' ) ) {
	
	function hogwords_woocommerce_allow_override_header_image($allow=true) {
		return is_product() ? false : $allow;
	}
}

// Return shop page ID
if ( !function_exists( 'hogwords_woocommerce_get_shop_page_id' ) ) {
	function hogwords_woocommerce_get_shop_page_id() {
		return get_option('woocommerce_shop_page_id');
	}
}

// Return shop page link
if ( !function_exists( 'hogwords_woocommerce_get_shop_page_link' ) ) {
	function hogwords_woocommerce_get_shop_page_link() {
		$url = '';
		$id = hogwords_woocommerce_get_shop_page_id();
		if ($id) $url = get_permalink($id);
		return $url;
	}
}

// Show categories of the current product
if ( !function_exists( 'hogwords_woocommerce_get_post_categories' ) ) {
	
	function hogwords_woocommerce_get_post_categories($cats='') {
		if (get_post_type()=='product') {
			$cats = hogwords_get_post_terms(', ', get_the_ID(), 'product_cat');
		}
		return $cats;
	}
}

// Add 'product' to the list of the supported post-types
if ( !function_exists( 'hogwords_woocommerce_list_post_types' ) ) {
	
	function hogwords_woocommerce_list_post_types($list=array()) {
		$list['product'] = esc_html__('Products', 'hogwords');
		return $list;
	}
}

// Show price of the current product in the widgets and search results
if ( !function_exists( 'hogwords_woocommerce_get_post_info' ) ) {
	
	function hogwords_woocommerce_get_post_info($post_info='') {
		if (get_post_type()=='product') {
			global $product;
			if ( $price_html = $product->get_price_html() ) {
				$post_info = '<div class="post_price product_price price">' . trim($price_html) . '</div>' . $post_info;
			}
		}
		return $post_info;
	}
}

// Show price of the current product in the search results streampage
if ( !function_exists( 'hogwords_woocommerce_action_before_post_meta' ) ) {
	
	function hogwords_woocommerce_action_before_post_meta() {
		if (!is_single() && get_post_type()=='product') {
			global $product;
			if ( $price_html = $product->get_price_html() ) {
				?><div class="post_price product_price price"><?php hogwords_show_layout($price_html); ?></div><?php
			}
		}
	}
}

// Enqueue WooCommerce custom styles
if ( !function_exists( 'hogwords_woocommerce_frontend_scripts' ) ) {
	
	function hogwords_woocommerce_frontend_scripts() {
			if (hogwords_is_on(hogwords_get_theme_option('debug_mode')) && hogwords_get_file_dir('plugins/woocommerce/woocommerce.css')!='')
				wp_enqueue_style( 'hogwords-woocommerce',  hogwords_get_file_url('plugins/woocommerce/woocommerce.css'), array(), null );
			if (hogwords_is_on(hogwords_get_theme_option('debug_mode')) && hogwords_get_file_dir('plugins/woocommerce/woocommerce.js')!='')
				wp_enqueue_script( 'hogwords-woocommerce', hogwords_get_file_url('plugins/woocommerce/woocommerce.js'), array('jquery'), null, true );
	}
}

// Merge custom styles
if ( !function_exists( 'hogwords_woocommerce_merge_styles' ) ) {
	
	function hogwords_woocommerce_merge_styles($list) {
		$list[] = 'plugins/woocommerce/woocommerce.css';
		return $list;
	}
}

// Merge custom scripts
if ( !function_exists( 'hogwords_woocommerce_merge_scripts' ) ) {
	
	function hogwords_woocommerce_merge_scripts($list) {
		$list[] = 'plugins/woocommerce/woocommerce.js';
		return $list;
	}
}



// Add WooCommerce specific items into lists
//------------------------------------------------------------------------

// Add sidebar
if ( !function_exists( 'hogwords_woocommerce_list_sidebars' ) ) {
	
	function hogwords_woocommerce_list_sidebars($list=array()) {
		$list['woocommerce_widgets'] = array(
											'name' => esc_html__('WooCommerce Widgets', 'hogwords'),
											'description' => esc_html__('Widgets to be shown on the WooCommerce pages', 'hogwords')
											);
		return $list;
	}
}




// Decorate WooCommerce output: Loop
//------------------------------------------------------------------------

// Before main content
if ( !function_exists( 'hogwords_woocommerce_wrapper_start' ) ) {
	
	function hogwords_woocommerce_wrapper_start() {
		if (is_product() || is_cart() || is_checkout() || is_account_page()) {
			?>
			<article class="post_item_single post_type_product">
			<?php
		} else {
			?>
			<div class="list_products shop_mode_<?php echo esc_attr(!hogwords_storage_empty('shop_mode') ? hogwords_storage_get('shop_mode') : 'thumbs'); ?>">
				<div class="list_products_header">
			<?php
			hogwords_storage_set('woocommerce_list_products_header', true);
		}
	}
}

// After main content
if ( !function_exists( 'hogwords_woocommerce_wrapper_end' ) ) {
	
	function hogwords_woocommerce_wrapper_end() {
		if (is_product() || is_cart() || is_checkout() || is_account_page()) {
			?>
			</article><!-- /.post_item_single -->
			<?php
		} else {
			?>
			</div><!-- /.list_products -->
			<?php
		}
	}
}

// Close header section
if ( !function_exists( 'hogwords_woocommerce_archive_description' ) ) {
	
	
	
	function hogwords_woocommerce_archive_description() {
		if (hogwords_storage_get('woocommerce_list_products_header')) {
			?>
			</div><!-- /.list_products_header -->
			<?php
			hogwords_storage_set('woocommerce_list_products_header', false);
			remove_action('woocommerce_after_main_content', 'hogwords_woocommerce_archive_description', 1);
		} else if (!is_singular())
			get_template_part( 'content', 'none-search' );
	}
}

// Add list mode buttons
if ( !function_exists( 'hogwords_woocommerce_before_shop_loop' ) ) {
	
	function hogwords_woocommerce_before_shop_loop() {
		?>
		<div class="hogwords_shop_mode_buttons"><form action="<?php echo esc_url(hogwords_get_current_url()); ?>" method="post"><input type="hidden" name="hogwords_shop_mode" value="<?php echo esc_attr(hogwords_storage_get('shop_mode')); ?>" /><a href="#" class="woocommerce_thumbs icon-th" title="<?php esc_attr_e('Show products as thumbs', 'hogwords'); ?>"></a><a href="#" class="woocommerce_list icon-th-list" title="<?php esc_attr_e('Show products as list', 'hogwords'); ?>"></a></form></div><!-- /.hogwords_shop_mode_buttons -->
		<?php
	}
}


// Open item wrapper for categories and products
if ( !function_exists( 'hogwords_woocommerce_item_wrapper_start' ) ) {
	
	
	function hogwords_woocommerce_item_wrapper_start($cat='') {
		hogwords_storage_set('in_product_item', true);
		$hover = hogwords_get_theme_option('shop_hover');
		?>
		<div class="post_item post_layout_<?php echo esc_attr(is_shop() || is_product_category() || is_product_tag() || is_product_taxonomy() ? hogwords_storage_get('shop_mode') : 'thumbs'); ?>">
			<div class="post_featured hover_<?php echo esc_attr($hover); ?>">
				<?php do_action('hogwords_action_woocommerce_item_featured_start'); ?>
				<a href="<?php echo esc_url(is_object($cat) ? get_term_link($cat->slug, 'product_cat') : get_permalink()); ?>">
				<?php
	}
}

// Open item wrapper for categories and products
if ( !function_exists( 'hogwords_woocommerce_open_item_wrapper' ) ) {
	
	
	function hogwords_woocommerce_title_wrapper_start($cat='') {
				?></a><?php
				if (($hover = hogwords_get_theme_option('shop_hover')) != 'none') {
					?><div class="mask"></div><?php
					hogwords_hovers_add_icons($hover, array('cat'=>$cat));
				}
				do_action('hogwords_action_woocommerce_item_featured_end');
				?>
			</div><!-- /.post_featured -->
			<div class="post_data">
				<div class="post_data_inner">
					<div class="post_header entry-header">
					<?php
	}
}


// Display product's tags before the title
if ( !function_exists( 'hogwords_woocommerce_title_tags' ) ) {
	
	function hogwords_woocommerce_title_tags() {
		global $product;
		hogwords_show_layout(wc_get_product_tag_list( $product->get_id(), ', ', '<div class="post_tags product_tags">', '</div>' ));
	}
}

// Wrap product title into link
if ( !function_exists( 'hogwords_woocommerce_the_title' ) ) {
	
	function hogwords_woocommerce_the_title($title) {
		if (hogwords_storage_get('in_product_item') && get_post_type()=='product') {
			$title = '<a href="'.esc_url(get_permalink()).'">'.esc_html($title).'</a>';
		}
		return $title;
	}
}

// Wrap category title into link
if ( !function_exists( 'hogwords_woocommerce_shop_loop_subcategory_title' ) ) {
	
	function hogwords_woocommerce_shop_loop_subcategory_title($cat) {
		if (hogwords_storage_get('in_product_item') && is_object($cat)) {
			$cat =  '<a href="'.esc_url(get_term_link($cat->slug, 'product_cat')).'">'.esc_attr($cat->name).'</a>';
		}
		return $cat;
	}
}

// Add excerpt in output for the product in the list mode
if ( !function_exists( 'hogwords_woocommerce_title_wrapper_end' ) ) {
	
	function hogwords_woocommerce_title_wrapper_end() {
			?>
			</div><!-- /.post_header -->
		<?php
		if (hogwords_storage_get('shop_mode') == 'list' && (is_shop() || is_product_category() || is_product_tag() || is_product_taxonomy()) && !is_product()) {
		    $excerpt = apply_filters('the_excerpt', get_the_excerpt());
			?>
			<div class="post_content entry-content"><?php hogwords_show_layout($excerpt); ?></div>
			<?php
		}
	}
}

// Add excerpt in output for the product in the list mode
if ( !function_exists( 'hogwords_woocommerce_title_wrapper_end2' ) ) {
	
	function hogwords_woocommerce_title_wrapper_end2($category) {
			?>
			</div><!-- /.post_header -->
		<?php
		if (hogwords_storage_get('shop_mode') == 'list' && is_shop() && !is_product()) {
			?>
			<div class="post_content entry-content"><?php hogwords_show_layout($category->description); ?></div><!-- /.post_content -->
			<?php
		}
	}
}

// Close item wrapper for categories and products
if ( !function_exists( 'hogwords_woocommerce_close_item_wrapper' ) ) {
	
	
	function hogwords_woocommerce_item_wrapper_end($cat='') {
				?>
				</div><!-- /.post_data_inner -->
			</div><!-- /.post_data -->
		</div><!-- /.post_item -->
		<?php
		hogwords_storage_set('in_product_item', false);
	}
}

// Change text on 'Add to cart' button to 'Buy now'
if ( ! function_exists( 'hogwords_woocommerce_add_to_cart_text' ) ) {
	
	
	function hogwords_woocommerce_add_to_cart_text( $text = '' ) {
		global $product;
		return is_object( $product )
				&& $product->is_in_stock()
				&& $product->is_purchasable()
				&& 'grouped' !== $product->get_type()
				&& ( 'external' !== $product->get_type() || $product->get_button_text() == '' )
					? esc_html__( 'Buy now', 'hogwords' )
					: $text;
	}
}

// Decorate price
if ( !function_exists( 'hogwords_woocommerce_get_price_html' ) ) {
	
	function hogwords_woocommerce_get_price_html($price='') {
		if (!is_admin() && !empty($price)) {
			$sep = get_option('woocommerce_price_decimal_sep');
			if (empty($sep)) $sep = '.';
			$price = preg_replace('/([0-9,]+)(\\'.trim($sep).')([0-9]{2})/', '\\1<span class="decimals">\\3</span>', $price);
		}
		return $price;
	}
}



// Decorate WooCommerce output: Single product
//------------------------------------------------------------------------

// Add WooCommerce specific vars into localize array
if (!function_exists('hogwords_woocommerce_localize_script')) {
	
	function hogwords_woocommerce_localize_script($arr) {
		$arr['stretch_tabs_area'] = !hogwords_sidebar_present() ? hogwords_get_theme_option('stretch_tabs_area') : 0;
		return $arr;
	}
}

// Add Product ID for the single product
if ( !function_exists( 'hogwords_woocommerce_show_product_id' ) ) {
	
	function hogwords_woocommerce_show_product_id() {
		$authors = wp_get_post_terms(get_the_ID(), 'pa_product_author');
		if (is_array($authors) && count($authors)>0) {
			echo '<span class="product_author">'.esc_html__('Author: ', 'hogwords');
			$delim = '';
			foreach ($authors as $author) {
				echo  esc_html($delim) . '<span>' . esc_html($author->name) . '</span>';
				$delim = ', ';
			}
			echo '</span>';
		}
		echo '<span class="product_id">'.esc_html__('Product ID: ', 'hogwords') . '<span>' . get_the_ID() . '</span></span>';
	}
}

// Number columns for the product's thumbnails
if ( !function_exists( 'hogwords_woocommerce_product_thumbnails_columns' ) ) {
	
	function hogwords_woocommerce_product_thumbnails_columns($cols) {
		return 4;
	}
}

// Set products number for the related products
if ( !function_exists( 'hogwords_woocommerce_output_related_products_args' ) ) {
	
	function hogwords_woocommerce_output_related_products_args($args) {
		$args['posts_per_page'] = (int) hogwords_get_theme_option('show_related_posts')
										? max(0, min(9, hogwords_get_theme_option('related_posts')))
										: 0;
		$args['columns'] = max(1, min(4, hogwords_get_theme_option('related_columns')));
		return $args;
	}
}

// Set columns number for the related products
if ( !function_exists( 'hogwords_woocommerce_related_products_columns' ) ) {
	
	function hogwords_woocommerce_related_products_columns($columns) {
		$columns = max(1, min(4, hogwords_get_theme_option('related_columns')));
		return $columns;
	}
}

if ( ! function_exists( 'hogwords_woocommerce_price_filter_widget_step' ) ) {
    add_filter('woocommerce_price_filter_widget_step', 'hogwords_woocommerce_price_filter_widget_step');
    function hogwords_woocommerce_price_filter_widget_step( $step = '' ) {
        $step = 1;
        return $step;
    }
}


// Decorate WooCommerce output: Widgets
//------------------------------------------------------------------------

// Search form
if ( !function_exists( 'hogwords_woocommerce_get_product_search_form' ) ) {
	
	function hogwords_woocommerce_get_product_search_form($form) {
		return '
		<form role="search" method="get" class="search_form" action="' . esc_url(home_url('/')) . '">
			<input type="text" class="search_field" placeholder="' . esc_attr__('Search for products &hellip;', 'hogwords') . '" value="' . get_search_query() . '" name="s" /><button class="search_button" type="submit">' . esc_html__('Search', 'hogwords') . '</button>
			<input type="hidden" name="post_type" value="product" />
		</form>
		';
	}
}

// Wrap category title to the link: open tag
if ( ! function_exists( 'hogwords_woocommerce_before_subcategory_title' ) ) {
	
	function hogwords_woocommerce_before_subcategory_title( $cat ) {
		if ( hogwords_storage_get( 'in_product_item' ) && is_object( $cat ) ) {
			?>
			<a href="<?php echo esc_url( get_term_link( $cat->slug, 'product_cat' ) ); ?>">
			<?php
		}
	}
}

// Wrap category title to the link: close tag
if ( ! function_exists( 'hogwords_woocommerce_after_subcategory_title' ) ) {
	
	function hogwords_woocommerce_after_subcategory_title( $cat ) {
		if ( hogwords_storage_get( 'in_product_item' ) && is_object( $cat ) ) {
			?>
			</a>
			<?php
		}
	}
}


// Add plugin-specific colors and fonts to the custom CSS
if (hogwords_exists_woocommerce()) { require_once HOGWORDS_THEME_DIR . 'plugins/woocommerce/woocommerce.styles.php'; }
?>