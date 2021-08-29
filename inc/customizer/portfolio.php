<?php
/**
 * Add Portfolio Settings in Customizer
 *
 * @package Intuitive
 */

/**
 * Add portfolio options to theme options
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function intuitive_portfolio_options( $wp_customize ) {
    // Add note to Jetpack Portfolio Section
    intuitive_register_option( $wp_customize, array(
            'name'              => 'intuitive_jetpack_portfolio_cpt_note',
            'sanitize_callback' => 'sanitize_text_field',
            'custom_control'    => 'Intuitive_Note_Control',
            'label'             => sprintf( esc_html__( 'For Portfolio Options for Intuitive Theme, go %1$shere%2$s', 'intuitive' ),
                 '<a href="javascript:wp.customize.section( \'intuitive_portfolio\' ).focus();">',
                 '</a>'
            ),
            'section'           => 'jetpack_portfolio',
            'type'              => 'description',
            'priority'          => 1,
        )
    );

	$wp_customize->add_section( 'intuitive_portfolio', array(
            'panel'    => 'intuitive_theme_options',
            'title'    => esc_html__( 'Portfolio', 'intuitive' ),
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
            'name'              => 'intuitive_portfolio_jetpack_note',
            'sanitize_callback' => 'sanitize_text_field',
            'custom_control'    => 'Intuitive_Note_Control',
            'active_callback'   => 'intuitive_is_ect_portfolio_inactive',
            /* translators: 1: <a>/link tag start, 2: </a>/link tag close. */
            'label'             => sprintf( esc_html__( 'For Portfolio, install %1$sEssential Content Types%2$s Plugin with Portfolio Type Enabled', 'intuitive' ),
                '<a target="_blank" href="' . esc_url( $install_url ) . '">',
                '</a>'

            ),
           'section'            => 'intuitive_portfolio',
            'type'              => 'description',
            'priority'          => 1,
        )
    );

    intuitive_register_option( $wp_customize, array(
			'name'              => 'intuitive_portfolio_option',
			'default'           => 'disabled',
            'active_callback'   => 'intuitive_is_ect_portfolio_active',
			'sanitize_callback' => 'intuitive_sanitize_select',
			'choices'           => intuitive_section_visibility_options(),
			'label'             => esc_html__( 'Enable on', 'intuitive' ),
			'section'           => 'intuitive_portfolio',
			'type'              => 'select',
		)
	);

    intuitive_register_option( $wp_customize, array(
            'name'              => 'intuitive_portfolio_cpt_note',
            'sanitize_callback' => 'sanitize_text_field',
            'custom_control'    => 'Intuitive_Note_Control',
            'active_callback'   => 'intuitive_is_portfolio_active',
            /* translators: 1: <a>/link tag start, 2: </a>/link tag close. */
			'label'             => sprintf( esc_html__( 'For CPT heading and sub-heading, go %1$shere%2$s', 'intuitive' ),
                 '<a href="javascript:wp.customize.control( \'jetpack_portfolio_title\' ).focus();">',
                 '</a>'
            ),
            'section'           => 'intuitive_portfolio',
            'type'              => 'description',
        )
    );

    intuitive_register_option( $wp_customize, array(
            'name'              => 'intuitive_portfolio_number',
            'default'           => '3',
            'sanitize_callback' => 'intuitive_sanitize_number_range',
            'active_callback'   => 'intuitive_is_portfolio_active',
            'label'             => esc_html__( 'Number of items to show', 'intuitive' ),
            'section'           => 'intuitive_portfolio',
            'type'              => 'number',
            'input_attrs'       => array(
                'style'             => 'width: 100px;',
                'min'               => 0,
            ),
        )
    );

    $number = get_theme_mod( 'intuitive_portfolio_number', 3 );

    for ( $i = 1; $i <= $number ; $i++ ) {

        //for CPT
        intuitive_register_option( $wp_customize, array(
                'name'              => 'intuitive_portfolio_cpt_' . $i,
                'sanitize_callback' => 'intuitive_sanitize_post',
                'active_callback'   => 'intuitive_is_portfolio_active',
                'label'             => esc_html__( 'Portfolio', 'intuitive' ) . ' ' . $i ,
                'section'           => 'intuitive_portfolio',
                'type'              => 'select',
                'choices'           => intuitive_generate_post_array( 'jetpack-portfolio' ),
            )
        );
    } // End for().
}
add_action( 'customize_register', 'intuitive_portfolio_options' );

/**
 * Active Callback Functions
 */
if ( ! function_exists( 'intuitive_is_portfolio_active' ) ) :
    /**
    * Return true if portfolio is active
    *
    * @since Intuitive 1.0
    */
    function intuitive_is_portfolio_active( $control ) {
        $enable = $control->manager->get_setting( 'intuitive_portfolio_option' )->value();

        //return true only if previwed page on customizer matches the type of content option selected
        return ( intuitive_is_ect_portfolio_active( $control ) &&  intuitive_check_section( $enable ) );
    }
endif;

if ( ! function_exists( 'intuitive_is_ect_portfolio_inactive' ) ) :
    /**
    *
    * @since Intuitive 1.0
    */
    function intuitive_is_ect_portfolio_inactive( $control ) {
        return ! ( class_exists( 'Essential_Content_Jetpack_Portfolio' ) || class_exists( 'Essential_Content_Pro_Jetpack_Portfolio' ) );
    }
endif;

if ( ! function_exists( 'intuitive_is_ect_portfolio_active' ) ) :
    /**
    *
    * @since Intuitive 1.0
    */
    function intuitive_is_ect_portfolio_active( $control ) {
        return ( class_exists( 'Essential_Content_Jetpack_Portfolio' ) || class_exists( 'Essential_Content_Pro_Jetpack_Portfolio' ) );
    }
endif;
