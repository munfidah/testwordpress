<?php
/**
 * Theme Options
 *
 * @package Intuitive
 */

/**
 * Add theme options
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function intuitive_theme_options( $wp_customize ) {
	$wp_customize->add_panel( 'intuitive_theme_options', array(
		'title'    => esc_html__( 'Theme Options', 'intuitive' ),
		'priority' => 130,
	) );

	// Layout Options
	$wp_customize->add_section( 'intuitive_layout_options', array(
		'title' => esc_html__( 'Layout Options', 'intuitive' ),
		'panel' => 'intuitive_theme_options',
		)
	);

	/* Default Layout */
	intuitive_register_option( $wp_customize, array(
			'name'              => 'intuitive_default_layout',
			'default'           => 'right-sidebar',
			'sanitize_callback' => 'intuitive_sanitize_select',
			'label'             => esc_html__( 'Default Layout', 'intuitive' ),
			'section'           => 'intuitive_layout_options',
			'type'              => 'radio',
			'choices'           => array(
				'right-sidebar'         => esc_html__( 'Right Sidebar ( Content, Primary Sidebar )', 'intuitive' ),
				'no-sidebar-full-width' => esc_html__( 'No Sidebar: Full Width', 'intuitive' ),
			),
		)
	);

	/* Homepage/Archive Layout */
	intuitive_register_option( $wp_customize, array(
			'name'              => 'intuitive_homepage_archive_layout',
			'default'           => 'no-sidebar-full-width',
			'sanitize_callback' => 'intuitive_sanitize_select',
			'label'             => esc_html__( 'Homepage/Archive Layout', 'intuitive' ),
			'section'           => 'intuitive_layout_options',
			'type'              => 'radio',
			'choices'           => array(
				'right-sidebar'         => esc_html__( 'Right Sidebar ( Content, Primary Sidebar )', 'intuitive' ),
				'no-sidebar-full-width' => esc_html__( 'No Sidebar: Full Width', 'intuitive' ),
			),
		)
	);

	// Single Page/Post Image
	intuitive_register_option( $wp_customize, array(
			'name'              => 'intuitive_single_layout',
			'default'           => 'disabled',
			'sanitize_callback' => 'intuitive_sanitize_select',
			'label'             => esc_html__( 'Single Page/Post Image', 'intuitive' ),
			'section'           => 'intuitive_layout_options',
			'type'              => 'radio',
			'choices'           => array(
				'disabled'       => esc_html__( 'Disabled', 'intuitive' ),
				'post-thumbnail' => esc_html__( 'Post Thumbnail (606x606)', 'intuitive' ),
			),
		)
	);

	// Excerpt Options.
	$wp_customize->add_section( 'intuitive_excerpt_options', array(
		'panel' => 'intuitive_theme_options',
		'title' => esc_html__( 'Excerpt Options', 'intuitive' ),
	) );

	intuitive_register_option( $wp_customize, array(
			'name'              => 'intuitive_excerpt_length',
			'default'           => '10',
			'sanitize_callback' => 'absint',
			'description' => esc_html__( 'Excerpt length. Default is 10 words', 'intuitive' ),
			'input_attrs' => array(
				'min'   => 10,
				'max'   => 200,
				'step'  => 5,
				'style' => 'width: 60px;',
			),
			'label'    => esc_html__( 'Excerpt Length (words)', 'intuitive' ),
			'section'  => 'intuitive_excerpt_options',
			'type'     => 'number',
		)
	);

	intuitive_register_option( $wp_customize, array(
			'name'              => 'intuitive_excerpt_more_text',
			'default'           => esc_html__( 'Continue reading', 'intuitive' ),
			'sanitize_callback' => 'sanitize_text_field',
			'label'             => esc_html__( 'Read More Text', 'intuitive' ),
			'section'           => 'intuitive_excerpt_options',
			'type'              => 'text',
		)
	);

	// Excerpt Options.
	$wp_customize->add_section( 'intuitive_search_options', array(
		'panel'     => 'intuitive_theme_options',
		'title'     => esc_html__( 'Search Options', 'intuitive' ),
	) );

	intuitive_register_option( $wp_customize, array(
			'name'              => 'intuitive_search_text',
			'default'           => esc_html__( 'Search ...', 'intuitive' ),
			'sanitize_callback' => 'wp_kses_data',
			'label'             => esc_html__( 'Search Text', 'intuitive' ),
			'section'           => 'intuitive_search_options',
			'type'              => 'text',
		)
	);

	// Homepage / Frontpage Options.
	$wp_customize->add_section( 'intuitive_homepage_options', array(
		'description' => esc_html__( 'Only posts that belong to the categories selected here will be displayed on the front page', 'intuitive' ),
		'panel'       => 'intuitive_theme_options',
		'title'       => esc_html__( 'Homepage / Frontpage Options', 'intuitive' ),
	) );

	intuitive_register_option( $wp_customize, array(
			'name'              => 'intuitive_recent_posts_heading',
			'sanitize_callback' => 'sanitize_text_field',
			'default'           => esc_html__( 'Our Blog', 'intuitive' ),
			'label'             => esc_html__( 'Recent Posts Heading', 'intuitive' ),
			'section'           => 'intuitive_homepage_options',
		)
	);

	intuitive_register_option( $wp_customize, array(
			'name'              => 'intuitive_recent_posts_subheading',
			'default'           => esc_html__( 'Company News', 'intuitive' ),
			'sanitize_callback' => 'sanitize_text_field',
			'default'           => esc_html__( 'Company News', 'intuitive' ),
			'label'             => esc_html__( 'Recent Posts Sub Heading', 'intuitive' ),
			'section'           => 'intuitive_homepage_options',
		)
	);

	intuitive_register_option( $wp_customize, array(
			'name'              => 'intuitive_front_page_category',
			'sanitize_callback' => 'intuitive_sanitize_category_list',
			'custom_control'    => 'Intuitive_Multi_Cat',
			'label'             => esc_html__( 'Categories', 'intuitive' ),
			'section'           => 'intuitive_homepage_options',
			'type'              => 'dropdown-categories',
		)
	);

	// Pagination Options.
	$wp_customize->add_section( 'intuitive_pagination_options', array(
		'panel'       => 'intuitive_theme_options',
		'title'       => esc_html__( 'Pagination Options', 'intuitive' ),
	) );

	intuitive_register_option( $wp_customize, array(
			'name'              => 'intuitive_pagination_type',
			'default'           => 'default',
			'sanitize_callback' => 'intuitive_sanitize_select',
			'choices'           => intuitive_get_pagination_types(),
			'label'             => esc_html__( 'Pagination type', 'intuitive' ),
			'section'           => 'intuitive_pagination_options',
			'type'              => 'select',
		)
	);
}
add_action( 'customize_register', 'intuitive_theme_options' );


/**
 * Returns an array of avaliable fonts registered for Intuitive
 *
 * @since Intuitive 1.0
 */
function intuitive_avaliable_fonts() {
	$avaliable_fonts = array(
		'arial-black' => array(
			'value' => 'arial-black',
			'label' => '"Arial Black", Gadget, sans-serif',
		),
		'allan' => array(
			'value' => 'allan',
			'label' => '"Allan", sans-serif',
		),
		'allerta' => array(
			'value' => 'allerta',
			'label' => '"Allerta", sans-serif',
		),
		'amaranth' => array(
			'value' => 'amaranth',
			'label' => '"Amaranth", sans-serif',
		),
		'amatic-sc' => array(
			'value' => 'amatic-sc',
			'label' => '"Amatic SC", cursive',
		),
		'arial' => array(
			'value' => 'arial',
			'label' => 'Arial, Helvetica, sans-serif',
		),
		'arizonia' => array(
			'value' => 'arizonia',
			'label' => '"Arizonia", cursive',
		),
		'bitter' => array(
			'value' => 'bitter',
			'label' => '"Bitter", sans-serif',
		),
		'cabin' => array(
			'value' => 'cabin',
			'label' => '"Cabin", sans-serif',
		),
		'cantarell' => array(
			'value' => 'cantarell',
			'label' => '"Cantarell", sans-serif',
		),
		'cousine' => array(
			'value' => 'cousine',
			'label' => '"Cousine", monospace',
		),
		'century-gothic' => array(
			'value' => 'century-gothic',
			'label' => '"Century Gothic", sans-serif',
		),
		'courier-new' => array(
			'value' => 'courier-new',
			'label' => '"Courier New", Courier, monospace',
		),
		'crimson-text' => array(
			'value' => 'crimson-text',
			'label' => '"Crimson Text", sans-serif',
		),
		'cuprum' => array(
			'value' => 'cuprum',
			'label' => '"Cuprum", sans-serif',
		),
		'dancing-script' => array(
			'value' => 'dancing-script',
			'label' => '"Dancing Script", sans-serif',
		),
		'droid-sans' => array(
			'value' => 'droid-sans',
			'label' => '"Droid Sans", sans-serif',
		),
		'droid-serif' => array(
			'value' => 'droid-serif',
			'label' => '"Droid Serif", sans-serif',
		),
		'exo' => array(
			'value' => 'exo',
			'label' => '"Exo", sans-serif',
		),
		'exo-2' => array(
			'value' => 'exo-2',
			'label' => '"Exo 2", sans-serif',
		),
		'georgia' => array(
			'value' => 'georgia',
			'label' => 'Georgia, "Times New Roman", Times, serif',
		),
		'great-vibes' => array(
			'value' => 'great-vibes',
			'label' => '"Great Vibes", cursive',
		),
		'helvetica' => array(
			'value' => 'helvetica',
			'label' => 'Helvetica, "Helvetica Neue", Arial, sans-serif',
		),
		'helvetica-neue' => array(
			'value' => 'helvetica-neue',
			'label' => '"Helvetica Neue",Helvetica,Arial,sans-serif',
		),
		'istok-web' => array(
			'value' => 'istok-web',
			'label' => '"Istok Web", sans-serif',
		),
		'impact' => array(
			'value' => 'impact',
			'label' => 'Impact, Charcoal, sans-serif',
		),
		'josefin-sans' => array(
			'value' => 'josefin-sans',
			'label' => '"Josefin Sans", sans-serif',
		),
		'lato' => array(
			'value' => 'lato',
			'label' => '"Lato", sans-serif',
		),
		'lucida-sans-unicode' => array(
			'value' => 'lucida-sans-unicode',
			'label' => '"Lucida Sans Unicode", "Lucida Grande", sans-serif',
		),
		'lucida-grande' => array(
			'value' => 'lucida-grande',
			'label' => '"Lucida Grande", "Lucida Sans Unicode", sans-serif',
		),
		'lobster' => array(
			'value' => 'lobster',
			'label' => '"Lobster", sans-serif',
		),
		'lora' => array(
			'value' => 'lora',
			'label' => '"Lora", serif',
		),
		'monaco' => array(
			'value' => 'monaco',
			'label' => 'Monaco, Consolas, "Lucida Console", monospace, sans-serif',
		),
		'montserrat' => array(
			'value' => 'montserrat',
			'label' => '"Montserrat", sans-serif',
		),
		'nobile' => array(
			'value' => 'nobile',
			'label' => '"Nobile", sans-serif',
		),
		'noto-serif' => array(
			'value' => 'noto-serif',
			'label' => '"Noto Serif", serif',
		),
		'neuton' => array(
			'value' => 'neuton',
			'label' => '"Neuton", serif',
		),
		'open-sans' => array(
			'value' => 'open-sans',
			'label' => '"Open Sans", sans-serif',
		),
		'oswald' => array(
			'value' => 'oswald',
			'label' => '"Oswald", sans-serif',
		),
		'palatino' => array(
			'value' => 'palatino',
			'label' => 'Palatino, "Palatino Linotype", "Book Antiqua", serif',
		),
		'patua-one' => array(
			'value' => 'patua-one',
			'label' => '"Patua One", sans-serif',
		),
		'playfair-display' => array(
			'value' => 'playfair-display',
			'label' => '"Playfair Display", sans-serif',
		),
		'pt-sans' => array(
			'value' => 'pt-sans',
			'label' => '"PT Sans", sans-serif',
		),
		'pt-serif' => array(
			'value' => 'pt-serif',
			'label' => '"PT Serif", serif',
		),
		'quattrocento-sans' => array(
			'value' => 'quattrocento-sans',
			'label' => '"Quattrocento Sans", sans-serif',
		),
		'roboto' => array(
			'value' => 'roboto',
			'label' => '"Roboto", sans-serif',
		),
		'roboto-slab' => array(
			'value' => 'roboto-slab',
			'label' => '"Roboto Slab", serif',
		),
		'rubik' => array(
			'value' => 'rubik',
			'label' => '"Rubik", serif',
		),
		'sans-serif' => array(
			'value' => 'sans-serif',
			'label' => 'Sans Serif, Arial',
		),
		'source-sans-pro' => array(
			'value' => 'source-sans-pro',
			'label' => '"Source Sans Pro", sans-serif',
		),
		'tahoma' => array(
			'value' => 'tahoma',
			'label' => 'Tahoma, Geneva, sans-serif',
		),
		'trebuchet-ms' => array(
			'value' => 'trebuchet-ms',
			'label' => '"Trebuchet MS", "Helvetica", sans-serif',
		),
		'times-new-roman' => array(
			'value' => 'times-new-roman',
			'label' => '"Times New Roman", Times, serif',
		),
		'ubuntu' => array(
			'value' => 'ubuntu',
			'label' => '"Ubuntu", sans-serif',
		),
		'varela' => array(
			'value' => 'varela',
			'label' => '"Varela", sans-serif',
		),
		'verdana' => array(
			'value' => 'verdana',
			'label' => 'Verdana, Geneva, sans-serif',
		),
		'yanone-kaffeesatz' => array(
			'value' => 'yanone-kaffeesatz',
			'label' => '"Yanone Kaffeesatz", sans-serif',
		),
	);

	return apply_filters( 'intuitive_avaliable_fonts', $avaliable_fonts );
}
