<?php
/**
 * Services options
 *
 * @package Intuitive Pro
 */

/**
 * Add services content options to theme options
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function intuitive_service_options( $wp_customize ) {
	// Add note to Jetpack Testimonial Section
    intuitive_register_option( $wp_customize, array(
            'name'              => 'intuitive_service_jetpack_note',
            'sanitize_callback' => 'sanitize_text_field',
            'custom_control'    => 'Intuitive_Note_Control',
            'label'             => sprintf( esc_html__( 'For all Services Options in Intuitive Theme, go %1$shere%2$s', 'intuitive' ),
                '<a href="javascript:wp.customize.section( \'intuitive_service\' ).focus();">',
                 '</a>'
            ),
           'section'            => 'services',
            'type'              => 'description',
            'priority'          => 1,
        )
    );

    $wp_customize->add_section( 'intuitive_service', array(
			'title' => esc_html__( 'Services', 'intuitive' ),
			'panel' => 'intuitive_theme_options',
		)
	);

	$action = 'install-plugin';
    $slug   = 'essential-content-types';

    $install_url = wp_nonce_url(
        add_query_arg(
            array(
                'action' => $action,
                'plugin' => $slug
            ),
            admin_url( 'update.php' )
        ),
        $action . '_' . $slug
    );

    intuitive_register_option( $wp_customize, array(
            'name'              => 'intuitive_service_jetpack_note',
            'sanitize_callback' => 'sanitize_text_field',
            'custom_control'    => 'Intuitive_Note_Control',
            'active_callback'   => 'intuitive_is_ect_services_inactive',
            /* translators: 1: <a>/link tag start, 2: </a>/link tag close. */
            'label'             => sprintf( esc_html__( 'For Services, install %1$sEssential Content Types%2$s Plugin with Service Type Enabled', 'intuitive' ),
                '<a target="_blank" href="' . esc_url( $install_url ) . '">',
                '</a>'

            ),
           'section'            => 'intuitive_service',
            'type'              => 'description',
            'priority'          => 1,
        )
    );

	// Add color scheme setting and control.
	intuitive_register_option( $wp_customize, array(
			'name'              => 'intuitive_service_option',
			'default'           => 'disabled',
			'active_callback'   => 'intuitive_is_ect_services_active',
			'sanitize_callback' => 'intuitive_sanitize_select',
			'choices'           => intuitive_section_visibility_options(),
			'label'             => esc_html__( 'Enable on', 'intuitive' ),
			'section'           => 'intuitive_service',
			'type'              => 'select',
		)
	);

    intuitive_register_option( $wp_customize, array(
            'name'              => 'intuitive_service_cpt_note',
            'sanitize_callback' => 'sanitize_text_field',
            'custom_control'    => 'Intuitive_Note_Control',
            'active_callback'   => 'intuitive_is_services_active',
            /* translators: 1: <a>/link tag start, 2: </a>/link tag close. */
			'label'             => sprintf( esc_html__( 'For CPT heading and sub-heading, go %1$shere%2$s', 'intuitive' ),
                 '<a href="javascript:wp.customize.control( \'ect_service_title\' ).focus();">',
                 '</a>'
            ),
            'section'           => 'intuitive_service',
            'type'              => 'description',
        )
    );

	intuitive_register_option( $wp_customize, array(
			'name'              => 'intuitive_service_number',
			'default'           => 3,
			'sanitize_callback' => 'intuitive_sanitize_number_range',
			'active_callback'   => 'intuitive_is_services_active',
			'description'       => esc_html__( 'Save and refresh the page if No. of Services is changed (Max no of Services is 20)', 'intuitive' ),
			'input_attrs'       => array(
				'style' => 'width: 100px;',
				'min'   => 0,
			),
			'label'             => esc_html__( 'No of items', 'intuitive' ),
			'section'           => 'intuitive_service',
			'type'              => 'number',
			'transport'         => 'postMessage',
		)
	);

	$number = get_theme_mod( 'intuitive_service_number', 3 );

	//loop for services post content
	for ( $i = 1; $i <= $number ; $i++ ) {

		intuitive_register_option( $wp_customize, array(
				'name'              => 'intuitive_service_cpt_' . $i,
				'sanitize_callback' => 'intuitive_sanitize_post',
				'active_callback'   => 'intuitive_is_services_active',
				'label'             => esc_html__( 'Services', 'intuitive' ) . ' ' . $i ,
				'section'           => 'intuitive_service',
				'type'              => 'select',
                'choices'           => intuitive_generate_post_array( 'ect-service' ),
			)
		);
	} // End for().
}
add_action( 'customize_register', 'intuitive_service_options', 10 );

/** Active Callback Functions **/
if ( ! function_exists( 'intuitive_is_services_active' ) ) :
	/**
	* Return true if services content is active
	*
	* @since Intuitive 1.0
	*/
	function intuitive_is_services_active( $control ) {
		$enable = $control->manager->get_setting( 'intuitive_service_option' )->value();

		//return true only if previewed page on customizer matches the type of content option selected
		return ( intuitive_is_ect_services_active( $control ) &&  intuitive_check_section( $enable ) );
	}
endif;

if ( ! function_exists( 'intuitive_is_ect_services_inactive' ) ) :
    /**
    * Return true if service is active
    *
    * @since Intuitive 1.0
    */
    function intuitive_is_ect_services_inactive( $control ) {
        return ! ( class_exists( 'Essential_Content_Service' ) || class_exists( 'Essential_Content_Pro_Service' ) );
    }
endif;

if ( ! function_exists( 'intuitive_is_ect_services_active' ) ) :
    /**
    * Return true if service is active
    *
    * @since Intuitive 1.0
    */
    function intuitive_is_ect_services_active( $control ) {
        return ( class_exists( 'Essential_Content_Service' ) || class_exists( 'Essential_Content_Pro_Service' ) );
    }
endif;
