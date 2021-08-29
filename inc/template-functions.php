<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package Intuitive
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function intuitive_body_classes( $classes ) {
	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}

	$classes[] = 'navigation-classic';

	// Adds a class with respect to layout selected.
	$layout  = intuitive_get_theme_layout();
	$sidebar = intuitive_get_sidebar_id();

	if ( 'no-sidebar-full-width' === $layout ) {
		$classes[] = 'no-sidebar full-width-layout';
	} elseif ( 'right-sidebar' === $layout ) {
		if ( '' !== $sidebar ) {
			$classes[] = 'two-columns-layout content-left';
		}
	}

	$classes[] = 'fluid-layout';

	$header_media_title    = get_theme_mod( 'intuitive_header_media_title', esc_html__( 'The Solution To
Grow Your Business', 'intuitive' ) );
	$header_media_subtitle = get_theme_mod( 'intuitive_header_media_subtitle', esc_html__( 'We Provide', 'intuitive' ) );
	$header_media_text     = get_theme_mod( 'intuitive_header_media_text' );
	$header_media_url      = get_theme_mod( 'intuitive_header_media_url', '#' );
	$header_media_url_text = get_theme_mod( 'intuitive_header_media_url_text', esc_html__( 'Discover More', 'intuitive' ) );

	$header_image = intuitive_featured_overall_image();

	if ( '' == $header_image ) {
		$classes[] = 'no-header-media-image';
	}

	$header_text_enabled = intuitive_has_header_media_text();

	if ( ! $header_text_enabled ) {
		$classes[] = 'no-header-media-text';
	}

	$enable_slider = intuitive_check_section( get_theme_mod( 'intuitive_slider_option', 'disabled' ) );

	if ( ! $enable_slider ) {
		$classes[] = 'no-featured-slider';
	}

	if ( '' == $header_image && ! $header_text_enabled && ! $enable_slider ) {
		$classes[] = 'content-has-padding-top';
	}

	if ( $enable_slider || $header_image ) {
		$classes[] = 'absolute-header';
	}

	if ( ! has_nav_menu( 'social' ) ) {
		$classes[] = 'social-header-disabled';
	}

	// Add Color Scheme to Body Class.
	$classes[] = esc_attr( 'color-scheme-' . get_theme_mod( 'color_scheme', 'default' ) );

	return $classes;
}
add_filter( 'body_class', 'intuitive_body_classes' );

/**
 * Add a pingback url auto-discovery header for singularly identifiable articles.
 */
function intuitive_pingback_header() {
	if ( is_singular() && pings_open() ) {
		echo '<link rel="pingback" href="', esc_url( get_bloginfo( 'pingback_url' ) ), '">';
	}
}
add_action( 'wp_head', 'intuitive_pingback_header' );

/**
 * Adds header image overlay for each section
 */
function intuitive_header_image_overlay_css() {
	$css = '';

	$overlay = get_theme_mod( 'intuitive_header_media_opacity', '0' );

	$overlay_bg = $overlay / 100;

	if ( '0' !== $overlay ) {
		$css = '.custom-header:after { background-color: rgba(0, 0, 0, ' . esc_attr( $overlay_bg ) . '); } '; // Dividing by 100 as the option is shown as % for user
	}

	wp_add_inline_style( 'intuitive-style', $css );
}
add_action( 'wp_enqueue_scripts', 'intuitive_header_image_overlay_css', 11 );

/**
 * Remove first post from blog as it is already show via recent post template
 */
function intuitive_alter_home( $query ) {
	if ( $query->is_home() && $query->is_main_query() ) {
		$cats = get_theme_mod( 'intuitive_front_page_category' );

		if ( is_array( $cats ) && ! in_array( '0', $cats ) ) {
			$query->query_vars['category__in'] = $cats;
		}
	}
}
add_action( 'pre_get_posts', 'intuitive_alter_home' );

if ( ! function_exists( 'intuitive_content_nav' ) ) :
	/**
	 * Display navigation/pagination when applicable
	 *
	 * @since Intuitive 1.0
	 */
	function intuitive_content_nav() {
		global $wp_query;

		// Don't print empty markup in archives if there's only one page.
		if ( $wp_query->max_num_pages < 2 && ( is_home() || is_archive() || is_search() ) ) {
			return;
		}

		$pagination_type = get_theme_mod( 'intuitive_pagination_type', 'default' );

		/**
		 * Check if navigation type is Jetpack Infinite Scroll and if it is enabled, else goto default pagination
		 * if it's active then disable pagination
		 */
		if ( ( 'infinite-scroll' === $pagination_type ) && class_exists( 'Jetpack' ) && Jetpack::is_module_active( 'infinite-scroll' ) ) {
			return false;
		}

		if ( 'numeric' === $pagination_type && function_exists( 'the_posts_pagination' ) ) {
			the_posts_pagination( array(
				'prev_text'          => esc_html__( 'Previous', 'intuitive' ),
				'next_text'          => esc_html__( 'Next', 'intuitive' ),
				'before_page_number' => '<span class="meta-nav screen-reader-text">' . esc_html__( 'Page', 'intuitive' ) . ' </span>',
			) );
		} else {
			the_posts_navigation();
		}
	}
endif; // intuitive_content_nav

/**
 * Check if a section is enabled or not based on the $value parameter
 * @param  string $value Value of the section that is to be checked
 * @return boolean return true if section is enabled otherwise false
 */
function intuitive_check_section( $value ) {
	global $wp_query;

	// Get Page ID outside Loop
	$page_id = absint( $wp_query->get_queried_object_id() );

	// Front page displays in Reading Settings
	$page_for_posts = absint( get_option( 'page_for_posts' ) );

	return ( 'entire-site' == $value  || ( ( is_front_page() || ( is_home() && $page_for_posts !== $page_id ) ) && 'homepage' == $value ) );
}

/**
 * Return the first image in a post. Works inside a loop.
 * @param [integer] $post_id [Post or page id]
 * @param [string/array] $size Image size. Either a string keyword (thumbnail, medium, large or full) or a 2-item array representing width and height in pixels, e.g. array(32,32).
 * @param [string/array] $attr Query string or array of attributes.
 * @return [string] image html
 *
 * @since Intuitive 1.0
 */

function intuitive_get_first_image( $postID, $size, $attr, $src = false ) {
	ob_start();

	ob_end_clean();

	$image 	= '';

	$output = preg_match_all( '/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', get_post_field( 'post_content', $postID ) , $matches );

	if( isset( $matches[1][0] ) ) {
		//Get first image
		$first_img = $matches[1][0];

		if ( $src ) {
			//Return url of src is true
			return $first_img;
		}

		return '<img class="pngfix wp-post-image" src="' . $first_img . '">';
	}

	return false;
}

function intuitive_get_theme_layout() {
	$layout = '';

	if ( is_page_template( 'templates/full-width-page.php' ) ) {
		$layout = 'no-sidebar-full-width';
	} else {
		$layout = get_theme_mod( 'intuitive_default_layout', 'right-sidebar' );

		if ( is_home() || is_archive() || is_search() ) {
			$layout = get_theme_mod( 'intuitive_homepage_archive_layout', 'no-sidebar-full-width' );
		}
	}

	return $layout;
}

function intuitive_get_sidebar_id() {
	$sidebar = '';

	$layout = intuitive_get_theme_layout();

	$sidebaroptions = '';

	if ( 'no-sidebar-full-width' === $layout ) {
		return $sidebar;
	}

	if ( is_active_sidebar( 'sidebar-1' ) ) {
		$sidebar = 'sidebar-1'; // Primary Sidebar.
	}

	return $sidebar;
}

/**
 * Featured content posts
 */
function intuitive_get_featured_posts() {

	$number = get_theme_mod( 'intuitive_featured_content_number', 3 );

	$post_list    = array();

	$args = array(
		'posts_per_page'      => $number,
		'post_type'           => 'post',
		'ignore_sticky_posts' => 1, // ignore sticky posts.
	);

	// Get valid number of posts.
		$args['post_type'] = 'featured-content';

	for ( $i = 1; $i <= $number; $i++ ) {
		$post_id = '';

		$post_id = get_theme_mod( 'intuitive_featured_content_cpt_' . $i );
		
		if ( $post_id && '' !== $post_id ) {
			$post_list = array_merge( $post_list, array( $post_id ) );
		}
	}

	$args['post__in'] = $post_list;
	$args['orderby']  = 'post__in';

	$featured_posts = get_posts( $args );

	return $featured_posts;
}


/**
 * Services content posts
 */
function intuitive_get_services_posts() {

	$number = get_theme_mod( 'intuitive_service_number', 3 );

	$post_list    = array();

	$args = array(
		'posts_per_page'      => $number,
		'post_type'           => 'post',
		'ignore_sticky_posts' => 1, // ignore sticky posts.
	);

// Get valid number of posts.

	$args['post_type'] = 'ect-service';

	for ( $i = 1; $i <= $number; $i++ ) {
		$post_id = '';

		$post_id = get_theme_mod( 'intuitive_service_cpt_' . $i );
		

		if ( $post_id && '' !== $post_id ) {
			$post_list = array_merge( $post_list, array( $post_id ) );
		}
	}

	$args['post__in'] = $post_list;
	$args['orderby']  = 'post__in';
	

	$services_posts = get_posts( $args );

	return $services_posts;
}

if ( ! function_exists( 'intuitive_sections' ) ) :
	/**
	 * Display Sections on header and footer with respect to the section option set in intuitive_sections_sort
	 */
	function intuitive_sections( $selector = 'header' ) {
		get_template_part( 'template-parts/header/header', 'media' );
		get_template_part( 'template-parts/slider/content', 'display' );
		get_template_part( 'template-parts/featured-content/display', 'featured' );
		get_template_part( 'template-parts/hero-content/content','hero' );
		get_template_part( 'template-parts/services/display', 'services' );
		get_template_part( 'template-parts/testimonials/display', 'testimonial' );
		get_template_part( 'template-parts/portfolio/display', 'portfolio' );
	}
endif;

if ( ! function_exists( 'intuitive_get_no_thumb_image' ) ) :
	/**
	 * $image_size post thumbnail size
	 * $type image, src
	 */
	function intuitive_get_no_thumb_image( $image_size = 'post-thumbnail', $type = 'image' ) {
		$image = $image_url = '';

		global $_wp_additional_image_sizes;

		$size = $_wp_additional_image_sizes['post-thumbnail'];

		if ( isset( $_wp_additional_image_sizes[ $image_size ] ) ) {
			$size = $_wp_additional_image_sizes[ $image_size ];
		}

		$image_url  = trailingslashit( get_template_directory_uri() ) . 'assets/images/no-thumb.jpg';

		if ( 'post-thumbnail' !== $image_size ) {
			$image_url  = trailingslashit( get_template_directory_uri() ) . 'assets/images/no-thumb-' . $size['width'] . 'x' . $size['height'] . '.jpg';
		}

		if ( 'src' === $type ) {
			return $image_url;
		}

		return '<img class="no-thumb ' . esc_attr( $image_size ) . '" src="' . esc_url( $image_url ) . '" />';
	}
endif;
