<?php

/**
 * Function to register control and setting
 */
function intuitive_register_option( $wp_customize, $option ) {
	// Initialize Setting.
	$wp_customize->add_setting( $option['name'], array(
		'sanitize_callback'    => $option['sanitize_callback'],
		'default'              => isset( $option['default'] ) ? $option['default'] : '',
		'transport'            => isset( $option['transport'] ) ? $option['transport'] : 'refresh',
		'theme_supports'       => isset( $option['theme_supports'] ) ? $option['theme_supports'] : '',
	) );

	$control = array(
		'label'    => $option['label'],
		'section'  => $option['section'],
		'settings' => isset( $option['settings'] ) ? $option['settings'] : $option['name'],
	);

	if ( isset( $option['active_callback'] ) ) {
		$control['active_callback'] = $option['active_callback'];
	}

	if ( isset( $option['priority'] ) ) {
		$control['priority'] = $option['priority'];
	}

	if ( isset( $option['choices'] ) ) {
		$control['choices'] = $option['choices'];
	}

	if ( isset( $option['type'] ) ) {
		$control['type'] = $option['type'];
	}

	if ( isset( $option['input_attrs'] ) ) {
		$control['input_attrs'] = $option['input_attrs'];
	}

	if ( isset( $option['description'] ) ) {
		$control['description'] = $option['description'];
	}

	if ( isset( $option['custom_control'] ) ) {
		$wp_customize->add_control( new $option['custom_control']( $wp_customize, $option['name'], $control ) );
	} else {
		$wp_customize->add_control( $option['name'], $control );
	}
}

/**
 * Render the site title for the selective refresh partial.
 *
 * @since Intuitive 1.0
 * @see intuitive_customize_register()
 *
 * @return void
 */
function intuitive_customize_partial_blogname() {
	bloginfo( 'name' );
}

/**
 * Render the site tagline for the selective refresh partial.
 *
 * @since Intuitive 1.0
 * @see intuitive_customize_register()
 *
 * @return void
 */
function intuitive_customize_partial_blogdescription() {
	bloginfo( 'description' );
}

/**
 * Alphabetically sort theme options sections
 *
 * @param  wp_customize object $wp_customize wp_customize object.
 */
function intuitive_sort_sections_list( $wp_customize ) {
	foreach ( $wp_customize->sections() as $section_key => $section_object ) {
		if ( false !== strpos( $section_key, 'intuitive_' ) && 'intuitive_reset_all' !== $section_key && 'intuitive_important_links' !== $section_key ) {
			$options[] = $section_key;
		}
	}

	sort( $options );

	$priority = 1;
	foreach ( $options as  $option ) {
		$wp_customize->get_section( $option )->priority = $priority++;
	}
}
add_action( 'customize_register', 'intuitive_sort_sections_list' );

/**
 * Returns an array of visibility options for featured sections
 *
 * @since Intuitive 1.0
 */
function intuitive_section_visibility_options() {
	$options = array(
		'disabled'    => esc_html__( 'Disabled', 'intuitive' ),
		'homepage'    => esc_html__( 'Homepage / Frontpage', 'intuitive' ),
		'entire-site' => esc_html__( 'Entire Site', 'intuitive' ),
	);

	return apply_filters( 'intuitive_section_visibility_options', $options );
}

/**
 * Returns an array of featured content options
 *
 * @since Intuitive 1.0
 */
function intuitive_sections_layout_options() {
	$options = array(
		'layout-one'   => esc_html__( '1 column', 'intuitive' ),
		'layout-two'   => esc_html__( '2 columns', 'intuitive' ),
		'layout-three' => esc_html__( '3 columns', 'intuitive' ),
		'layout-four'  => esc_html__( '4 columns', 'intuitive' ),
	);

	return apply_filters( 'intuitive_sections_layout_options', $options );
}

/**
 * Returns an array of section types
 *
 * @since Intuitive 1.0
 */
function intuitive_section_type_options() {
	$options = array(
		'post'     => esc_html__( 'Post', 'intuitive' ),
		'page'     => esc_html__( 'Page', 'intuitive' ),
		'category' => esc_html__( 'Category', 'intuitive' ),
		'custom'   => esc_html__( 'Custom', 'intuitive' ),
	);

	return apply_filters( 'intuitive_section_type_options', $options );
}

/**
 * Returns an array of color schemes registered for catchresponsive.
 *
 * @since Intuitive 1.0
 */
function intuitive_get_pagination_types() {
	$pagination_types = array(
		'default' => esc_html__( 'Default(Older Posts/Newer Posts)', 'intuitive' ),
		'numeric' => esc_html__( 'Numeric', 'intuitive' ),
	);

	return apply_filters( 'intuitive_get_pagination_types', $pagination_types );
}

/**
 * Generate a list of all available post array
 *
 * @param  string $post_type post type.
 * @return post_array
 */
function intuitive_generate_post_array( $post_type = 'post' ) {
	$output = array();
	$posts = get_posts( array(
		'post_type'        => $post_type,
		'post_status'      => 'publish',
		'suppress_filters' => false,
		'posts_per_page'   => -1,
		)
	);

	$output['0']= esc_html__( '-- Select --', 'intuitive' );

	foreach ( $posts as $post ) {
		/* translators: 1: post id. */
		$output[ $post->ID ] = ! empty( $post->post_title ) ? $post->post_title : sprintf( __( '#%d (no title)', 'intuitive' ), $post->ID );
	}

	return $output;
}

/**
 * Generate a list of all available taxonomy
 *
 * @param  string $post_type post type.
 * @return post_array
 */
function intuitive_generate_taxonomy_array( $taxonomy = 'category' ) {
	$output = array();
	$taxonomy = get_categories( array( 'taxonomy' => $taxonomy ) );

	$output['0']= esc_html__( '-- Select --', 'intuitive' );

	foreach ( $taxonomy as $tax ) {
		$output[ $tax->term_id ] = ! empty($tax->name ) ?$tax->name : sprintf( __( '#%d (no title)', 'intuitive' ), $tax->term_id );
	}

	return $output;
}

/**
 * Returns an array of featured content show registered for Lucida.
 *
 * @since Intuitive 1.0
 */
function intuitive_content_show() {
	$options = array(
		'excerpt'      => esc_html__( 'Show Excerpt', 'intuitive' ),
		'full-content' => esc_html__( 'Full Content', 'intuitive' ),
		'hide-content' => esc_html__( 'Hide Content', 'intuitive' ),
	);
	return apply_filters( 'intuitive_content_show', $options );
}

/**
 * Returns an array of featured content show registered for Lucida.
 *
 * @since Intuitive 1.0
 */
function intuitive_meta_show() {
	$options = array(
		'show-meta' => esc_html__( 'Show Meta', 'intuitive' ),
		'hide-meta' => esc_html__( 'Hide Meta', 'intuitive' ),
	);
	return apply_filters( 'intuitive_content_show', $options );
}
