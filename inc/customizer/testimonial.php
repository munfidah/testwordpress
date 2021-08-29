<?php
/**
 * Add Testimonial Settings in Customizer
 *
 * @package Intuitive
*/

/**
 * Add testimonial options to theme options
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function intuitive_testimonial_options( $wp_customize ) {
    // Add note to Jetpack Testimonial Section
    intuitive_register_option( $wp_customize, array(
            'name'              => 'intuitive_jetpack_testimonial_cpt_note',
            'sanitize_callback' => 'sanitize_text_field',
            'custom_control'    => 'Intuitive_Note_Control',
            'label'             => sprintf( esc_html__( 'For Testimonial Options in Intuitive Theme, go %1$shere%2$s', 'intuitive' ),
                '<a href="javascript:wp.customize.section( \'intuitive_testimonials\' ).focus();">',
                 '</a>'
            ),
           'section'            => 'jetpack_testimonials',
            'type'              => 'description',
            'priority'          => 1,
        )
    );

    $wp_customize->add_section( 'intuitive_testimonials', array(
            'panel'    => 'intuitive_theme_options',
            'title'    => esc_html__( 'Testimonials', 'intuitive' ),
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
            'name'              => 'intuitive_testimonial_jetpack_note',
            'sanitize_callback' => 'sanitize_text_field',
            'custom_control'    => 'Intuitive_Note_Control',
            'active_callback'   => 'intuitive_is_ect_testimonial_inactive',
            /* translators: 1: <a>/link tag start, 2: </a>/link tag close. */
            'label'             => sprintf( esc_html__( 'For Testimonial, install %1$sEssential Content Types%2$s Plugin with testimonial Type Enabled', 'intuitive' ),
                '<a target="_blank" href="' . esc_url( $install_url ) . '">',
                '</a>'

            ),
            'section'            => 'intuitive_testimonials',
            'type'              => 'description',
            'priority'          => 1,
        )
    );

    intuitive_register_option( $wp_customize, array(
            'name'              => 'intuitive_testimonial_option',
            'default'           => 'disabled',
            'active_callback'   => 'intuitive_is_ect_testimonial_active',
            'sanitize_callback' => 'intuitive_sanitize_select',
            'choices'           => intuitive_section_visibility_options(),
            'label'             => esc_html__( 'Enable on', 'intuitive' ),
            'section'           => 'intuitive_testimonials',
            'type'              => 'select',
            'priority'          => 1,
        )
    );

    intuitive_register_option( $wp_customize, array(
            'name'              => 'intuitive_testimonial_cpt_note',
            'sanitize_callback' => 'sanitize_text_field',
            'custom_control'    => 'Intuitive_Note_Control',
            'active_callback'   => 'intuitive_is_testimonial_active',
            /* translators: 1: <a>/link tag start, 2: </a>/link tag close. */
			'label'             => sprintf( esc_html__( 'For CPT heading and sub-heading, go %1$shere%2$s', 'intuitive' ),
                '<a href="javascript:wp.customize.section( \'jetpack_testimonials\' ).focus();">',
                '</a>'
            ),
            'section'           => 'intuitive_testimonials',
            'type'              => 'description',
        )
    );

    intuitive_register_option( $wp_customize, array(
            'name'              => 'intuitive_testimonial_number',
            'default'           => 4,
            'sanitize_callback' => 'intuitive_sanitize_number_range',
            'active_callback'   => 'intuitive_is_testimonial_active',
            'label'             => esc_html__( 'No of items', 'intuitive' ),
            'section'           => 'intuitive_testimonials',
            'type'              => 'number',
            'input_attrs'       => array(
                'style'             => 'width: 100px;',
                'min'               => 1,
                'max'               => 7,
            ),
        )
    );

    $number = get_theme_mod( 'intuitive_testimonial_number', 4 );

    for ( $i = 1; $i <= $number ; $i++ ) {

        //for CPT
        intuitive_register_option( $wp_customize, array(
                'name'              => 'intuitive_testimonial_cpt_' . $i,
                'sanitize_callback' => 'intuitive_sanitize_post',
                'active_callback'   => 'intuitive_is_testimonial_active',
                'label'             => esc_html__( 'Testimonial', 'intuitive' ) . ' ' . $i ,
                'section'           => 'intuitive_testimonials',
                'type'              => 'select',
                'choices'           => intuitive_generate_post_array( 'jetpack-testimonial' ),
            )
        );
    } // End for().
}
add_action( 'customize_register', 'intuitive_testimonial_options' );

/**
 * Active Callback Functions
 */
if ( ! function_exists( 'intuitive_is_testimonial_active' ) ) :
    /**
    * Return true if testimonial is active
    *
    * @since Intuitive 1.0
    */
    function intuitive_is_testimonial_active( $control ) {
        $enable = $control->manager->get_setting( 'intuitive_testimonial_option' )->value();

        //return true only if previewed page on customizer matches the type of content option selected
        return ( intuitive_is_ect_testimonial_active( $control ) &&  intuitive_check_section( $enable ) );
    }
endif;

if ( ! function_exists( 'intuitive_is_ect_testimonial_inactive' ) ) :
    /**
    *
    * @since Intuitive 1.0
    */
    function intuitive_is_ect_testimonial_inactive( $control ) {
        return ! ( class_exists( 'Essential_Content_Jetpack_testimonial' ) || class_exists( 'Essential_Content_Pro_Jetpack_testimonial' ) );
    }
endif;

if ( ! function_exists( 'intuitive_is_ect_testimonial_active' ) ) :
    /**
    *
    * @since Intuitive 1.0
    */
    function intuitive_is_ect_testimonial_active( $control ) {
        return ( class_exists( 'Essential_Content_Jetpack_testimonial' ) || class_exists( 'Essential_Content_Pro_Jetpack_testimonial' ) );
    }
endif;
