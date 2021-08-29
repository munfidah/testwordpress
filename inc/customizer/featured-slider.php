<?php
/**
 * Featured Slider Options
 *
 * @package Intuitive
 */

/**
 * Add hero content options to theme options
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function intuitive_slider_options( $wp_customize ) {
	$wp_customize->add_section( 'intuitive_featured_slider', array(
			'panel' => 'intuitive_theme_options',
			'title' => esc_html__( 'Featured Slider', 'intuitive' ),
		)
	);

	intuitive_register_option( $wp_customize, array(
			'name'              => 'intuitive_slider_option',
			'default'           => 'disabled',
			'sanitize_callback' => 'intuitive_sanitize_select',
			'choices'           => intuitive_section_visibility_options(),
			'label'             => esc_html__( 'Enable on', 'intuitive' ),
			'section'           => 'intuitive_featured_slider',
			'type'              => 'select',
		)
	);

	intuitive_register_option( $wp_customize, array(
			'name'              => 'intuitive_slider_number',
			'default'           => '4',
			'sanitize_callback' => 'intuitive_sanitize_number_range',

			'active_callback'   => 'intuitive_is_slider_active',
			'description'       => esc_html__( 'Save and refresh the page if No. of Slides is changed (Max no of slides is 20)', 'intuitive' ),
			'input_attrs'       => array(
				'style' => 'width: 45px;',
				'min'   => 0,
				'max'   => 20,
				'step'  => 1,
			),
			'label'             => esc_html__( 'No of items', 'intuitive' ),
			'section'           => 'intuitive_featured_slider',
			'type'              => 'number',
			'transport'         => 'postMessage',
		)
	);

	$slider_number = get_theme_mod( 'intuitive_slider_number', 4 );

	for ( $i = 1; $i <= $slider_number ; $i++ ) {
		// Page Sliders
		intuitive_register_option( $wp_customize, array(
				'name'              =>'intuitive_slider_page_' . $i,
				'sanitize_callback' => 'intuitive_sanitize_post',
				'active_callback'   => 'intuitive_is_slider_active',
				'label'             => esc_html__( 'Page', 'intuitive' ) . ' # ' . $i,
				'section'           => 'intuitive_featured_slider',
				'type'              => 'dropdown-pages',
				'allow_addition'    => true,
			)
		);
	} // End for().
}
add_action( 'customize_register', 'intuitive_slider_options' );

/** Active Callback Functions */
if( ! function_exists( 'intuitive_is_slider_active' ) ) :
	/**
	* Return true if slider is active
	*
	* @since Intuitive 1.0
	*/
	function intuitive_is_slider_active( $control ) {
		$enable = $control->manager->get_setting( 'intuitive_slider_option' )->value();

		//return true only if previewed page on customizer matches the type of slider option selected
		return ( intuitive_check_section( $enable ) );
	}
endif;
