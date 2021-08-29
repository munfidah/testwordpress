<?php
/**
 * Hero Content Options
 *
 * @package Intuitive
 */

/**
 * Add hero content options to theme options
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function intuitive_hero_content_options( $wp_customize ) {
	$wp_customize->add_section( 'intuitive_hero_content_options', array(
			'title' => esc_html__( 'Hero Content', 'intuitive' ),
			'panel' => 'intuitive_theme_options',
		)
	);

	intuitive_register_option( $wp_customize, array(
			'name'              => 'intuitive_hero_content_visibility',
			'default'           => 'disabled',
			'sanitize_callback' => 'intuitive_sanitize_select',
			'choices'           => intuitive_section_visibility_options(),
			'label'             => esc_html__( 'Enable on', 'intuitive' ),
			'section'           => 'intuitive_hero_content_options',
			'type'              => 'select',
		)
	);

	intuitive_register_option( $wp_customize, array(
			'name'              => 'intuitive_hero_content',
			'default'           => '0',
			'sanitize_callback' => 'intuitive_sanitize_post',
			'active_callback'   => 'intuitive_is_hero_content_active',
			'label'             => esc_html__( 'Page', 'intuitive' ),
			'section'           => 'intuitive_hero_content_options',
			'type'              => 'dropdown-pages',
			'allow_addition'    => true,
		)
	);

	intuitive_register_option( $wp_customize, array(
			'name'              => 'intuitive_hero_content_show',
			'default'           => 'full-content',
			'sanitize_callback' => 'intuitive_sanitize_select',
			'active_callback'   => 'intuitive_is_hero_content_active',
			'choices'           => intuitive_content_show(),
			'label'             => esc_html__( 'Display Content', 'intuitive' ),
			'section'           => 'intuitive_hero_content_options',
			'type'              => 'select',
		)
	);

	intuitive_register_option( $wp_customize, array(
			'name'              => 'intuitive_hero_content_subtitle',
			'sanitize_callback' => 'sanitize_text_field',
			'active_callback'   => 'intuitive_is_hero_content_active',
			'label'             => esc_html__( 'Subtitle', 'intuitive' ),
			'section'           => 'intuitive_hero_content_options',
			'type'              => 'text',
		)
	);
}
add_action( 'customize_register', 'intuitive_hero_content_options' );

/** Active Callback Functions **/
if ( ! function_exists( 'intuitive_is_hero_content_active' ) ) :
	/**
	* Return true if hero content is active
	*
	* @since Intuitive 1.0
	*/
	function intuitive_is_hero_content_active( $control ) {
		$enable = $control->manager->get_setting( 'intuitive_hero_content_visibility' )->value();

		//return true only if previewed page on customizer matches the type of content option selected
		return ( intuitive_check_section( $enable ) );
	}
endif;
