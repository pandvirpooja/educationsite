<?php
if ( ! defined( 'ABSPATH' ) ) {
	wp_die( '-1' );
}

/**
 * Add new property into shortcode tour.
 */
add_action( 'vc_after_init', 'hogwords_after_vc_init_actions' );
function hogwords_after_vc_init_actions() {

	//*******************//
	// VC TEXT REMAPPING //
	//*******************//

	// Add Params
	$vc_tta_tour_new_params = array(
		array(

			'type'        => 'checkbox',
			'param_name'  => 'change_tab_on_hover',
			'value'       => 'false',
			'heading'     => esc_html__( 'Toggle a tab when you hover', 'hogwords' ),
			'description' => esc_html__( 'Toggle a tab when you hover over the title.', 'hogwords' ),
		)
	);

	$vc_tta_section_new_params = array(
		array(

			'type'        => 'textfield',
			'param_name'  => 'tab_link',
			'heading'     => esc_html__( 'Href', 'hogwords' ),
			'description' => esc_html__( 'Enter title link.', 'hogwords' ),
			'value'       => '',
		)
	);

	vc_add_params( 'vc_tta_section', $vc_tta_section_new_params );
	vc_add_params( 'vc_tta_tour', $vc_tta_tour_new_params );
}

add_filter( 'vc-tta-get-params-tabs-list', 'hogwords_tabs_list', 4, 9 );
function hogwords_tabs_list( $html, $atts, $content, $tab ) {

	if( ! empty( $atts['change_tab_on_hover'] ) && 'true' === $atts['change_tab_on_hover'] ){

		$links = array();
		$link_count = 0;

		foreach ( WPBakeryShortCode_VC_Tta_Section::$section_info as $nth => $section) {
			$links[ $nth ] = !empty( $section['tab_link'] ) ? $section['tab_link'] : '' ;
		}

		foreach ( $html as $key => $value) {

			if( ! preg_match('/<li\s+/', $value ) ){
				continue;
			}

			$html[ $key ] = preg_replace( '/<a\s+href/', '<a data-href="' . esc_url($links[ $link_count ]) . '" href', $value );
			$link_count++;
		}
	}
	return $html;
}

