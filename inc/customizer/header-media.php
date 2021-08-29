<?php
/**
 * Header Media Options
 *
 * @package Intuitive
 */

/**
 * Add Header Media options
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function intuitive_header_media_options( $wp_customize ) {
	$wp_customize->get_section( 'header_image' )->description = esc_html__( 'If you add video, it will only show up on Homepage/FrontPage. Other Pages will use Header/Post/Page Image depending on your selection of option. Header Image will be used as a fallback while the video loads ', 'intuitive' );

	intuitive_register_option( $wp_customize, array(
			'name'              => 'intuitive_header_media_option',
			'default'           => 'homepage',
			'sanitize_callback' => 'intuitive_sanitize_select',
			'choices'           => array(
				'homepage'    => esc_html__( 'Homepage / Frontpage', 'intuitive' ),
				'entire-site' => esc_html__( 'Entire Site', 'intuitive' ),
				'disable'     => esc_html__( 'Disabled', 'intuitive' ),
			),
			'label'             => esc_html__( 'Enable on', 'intuitive' ),
			'section'           => 'header_image',
			'type'              => 'select',
			'priority'          => 1,
		)
	);

	intuitive_register_option( $wp_customize, array(
			'name'              => 'intuitive_header_media_content_align',
			'default'           => 'content-aligned-left',
			'sanitize_callback' => 'intuitive_sanitize_select',
			'choices'           => array(
				'content-aligned-center' => esc_html__( 'Center', 'intuitive' ),
				'content-aligned-right'  => esc_html__( 'Right', 'intuitive' ),
				'content-aligned-left'   => esc_html__( 'Left', 'intuitive' ),
			),
			'label'             => esc_html__( 'Content Position', 'intuitive' ),
			'section'           => 'header_image',
			'type'              => 'select',
		)
	);

	intuitive_register_option( $wp_customize, array(
			'name'              => 'intuitive_header_media_text_align',
			'default'           => 'text-aligned-left',
			'sanitize_callback' => 'intuitive_sanitize_select',
			'choices'           => array(
				'text-aligned-right'  => esc_html__( 'Right', 'intuitive' ),
				'text-aligned-center' => esc_html__( 'Center', 'intuitive' ),
				'text-aligned-left'   => esc_html__( 'Left', 'intuitive' ),
			),
			'label'             => esc_html__( 'Text Alignment', 'intuitive' ),
			'section'           => 'header_image',
			'type'              => 'select',
		)
	);

	intuitive_register_option( $wp_customize, array(
			'name'              => 'intuitive_header_media_opacity',
			'default'           => 0,
			'sanitize_callback' => 'intuitive_sanitize_number_range',
			'label'             => esc_html__( 'Header Media Overlay', 'intuitive' ),
			'section'           => 'header_image',
			'type'              => 'number',
			'input_attrs'       => array(
				'style' => 'width: 60px;',
				'min'   => 0,
				'max'   => 100,
			),
		)
	);

	intuitive_register_option( $wp_customize, array(
			'name'              => 'intuitive_header_media_scroll_down',
			'default'			=> 1,
			'sanitize_callback' => 'intuitive_sanitize_checkbox',
			'label'             => esc_html__( 'Scroll Down Button', 'intuitive' ),
			'section'           => 'header_image',
			'custom_control' 	=> 'Intuitive_Toggle_Control',
		)
	);

	intuitive_register_option( $wp_customize, array(
			'name'              => 'intuitive_header_media_subtitle',
			'default' 			=> esc_html__( 'We Provide', 'intuitive' ),
			'sanitize_callback' => 'wp_kses_post',
			'label'             => esc_html__( 'Header Media Sub Title', 'intuitive' ),
			'section'           => 'header_image',
			'type'              => 'text',
		)
	);

	intuitive_register_option( $wp_customize, array(
			'name'              => 'intuitive_header_media_title',
			'default' 			=> esc_html__( 'The Solution To Grow Your Business', 'intuitive' ),
			'sanitize_callback' => 'wp_kses_post',
			'label'             => esc_html__( 'Header Media Title', 'intuitive' ),
			'section'           => 'header_image',
			'type'              => 'text',
		)
	);

    intuitive_register_option( $wp_customize, array(
			'name'              => 'intuitive_header_media_text',
			'sanitize_callback' => 'wp_kses_post',
			'label'             => esc_html__( 'Header Media Text', 'intuitive' ),
			'section'           => 'header_image',
			'type'              => 'textarea',
		)
	);

	intuitive_register_option( $wp_customize, array(
			'name'              => 'intuitive_header_media_url',
			'default'           => '#',
			'sanitize_callback' => 'esc_url_raw',
			'label'             => esc_html__( 'Header Media Url', 'intuitive' ),
			'section'           => 'header_image',
		)
	);

	intuitive_register_option( $wp_customize, array(
			'name'              => 'intuitive_header_media_url_text',
			'default' 			=> esc_html__( 'Discover More', 'intuitive' ),			'sanitize_callback' => 'sanitize_text_field',
			'label'             => esc_html__( 'Header Media Url Text', 'intuitive' ),
			'section'           => 'header_image',
		)
	);

	intuitive_register_option( $wp_customize, array(
			'name'              => 'intuitive_header_url_target',
			'sanitize_callback' => 'intuitive_sanitize_checkbox',
			'label'             => esc_html__( 'Open Link in New Window/Tab', 'intuitive' ),
			'section'           => 'header_image',
			'custom_control'	=> 'Intuitive_Toggle_Control',
		)
	);
}
add_action( 'customize_register', 'intuitive_header_media_options' );
