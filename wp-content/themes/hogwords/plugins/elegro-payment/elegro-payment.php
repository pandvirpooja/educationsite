<?php
/* elegro Crypto Payment support functions
------------------------------------------------------------------------------- */


// Check if this plugin installed and activated
if ( ! function_exists( 'hogwords_exists_elegro_payment' ) ) {
	function hogwords_exists_elegro_payment() {
		return class_exists( 'WC_Elegro_Payment' );
	}
}


/* Mail Chimp support functions
------------------------------------------------------------------------------- */

// Theme init priorities:
// 9 - register other filters (for installer, etc.)
if (!function_exists('hogwords_elegro_payment_theme_setup9')) {
    add_action('after_setup_theme', 'hogwords_elegro_payment_theme_setup9', 9);
    function hogwords_elegro_payment_theme_setup9()
    {
        if (hogwords_exists_elegro_payment()) {
            add_action('wp_enqueue_scripts', 'hogwords_elegro_payment_frontend_scripts', 1100);
            add_filter('hogwords_filter_merge_styles', 'hogwords_elegro_payment_merge_styles');
        }
        if (is_admin()) {
            add_filter('hogwords_filter_tgmpa_required_plugins', 'hogwords_elegro_payment_tgmpa_required_plugins');
        }
    }
}



// Filter to add in the required plugins list
if (!function_exists('hogwords_elegro_payment_tgmpa_required_plugins')) {
    function hogwords_elegro_payment_tgmpa_required_plugins($list = array()) {

        if (hogwords_storage_isset('required_plugins', 'elegro-payment')) {
            $list[] = array(

                'name' 		=> hogwords_storage_get_array('required_plugins', 'elegro-payment'),
                'slug' => 'elegro-payment',
                'required' => false
            );
        }
        return $list;
    }
}



// Custom styles and scripts
//------------------------------------------------------------------------

// Enqueue custom styles
if (!function_exists('hogwords_elegro_payment_frontend_scripts')) {
    function hogwords_elegro_payment_frontend_scripts()
    {
        if (hogwords_exists_elegro_payment()) {
            if (hogwords_is_on(hogwords_get_theme_option('debug_mode')) && hogwords_get_file_dir('plugins/elegro-payment/elegro-payment.css') != '')
                wp_enqueue_style('hogwords-elegro-payment', hogwords_get_file_url('plugins/elegro-payment/elegro-payment.css'), array(), null);
        }
    }
}

// Merge custom styles
if (!function_exists('hogwords_elegro_payment_merge_styles')) {
    function hogwords_elegro_payment_merge_styles($list)
    {
        $list[] = 'plugins/elegro-payment/elegro-payment.css';
        return $list;
    }
}


