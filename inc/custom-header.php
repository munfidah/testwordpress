<?php
/**
 * Sample implementation of the Custom Header feature
 *
 * You can add an optional custom header image to header.php like so ...
 *
	<?php the_header_image_tag(); ?>
 *
 * @link https://developer.wordpress.org/themes/functionality/custom-headers/
 *
 * @package Intuitive
 */

// For registration of custom-header, check customizer/header-background-color.php


if ( ! function_exists( 'intuitive_header_style' ) ) :
	/**
	 * Styles the header image and text displayed on the blog.
	 *
	 * @see intuitive_custom_header_setup().
	 */
	function intuitive_header_style() {
		$header_text_color = get_header_textcolor();
		$header_image = intuitive_featured_overall_image();

		if ( $header_image ) : ?>
			<style type="text/css" rel="header-image">
				.custom-header:before {
					background-image: url( <?php echo esc_url( $header_image ); ?>);
					background-position: center;
					background-repeat: no-repeat;
					background-size: cover;
				}
			</style>
		<?php
		endif;

		/*
		 * If no custom options for text are set, let's bail.
		 * get_header_textcolor() options: Any hex value, 'blank' to hide text. Default: add_theme_support( 'custom-header' ).
		 */
		if ( '#111111' === $header_text_color ) {
			return;
		}

		// If we get this far, we have custom styles. Let's do this.
		?>
		<style type="text/css">
		<?php
		// Has the text been hidden?
		if ( ! display_header_text() ) :
		?>
			.absolute-header .site-title a,
			.site-description {
				position: absolute;
				clip: rect(1px, 1px, 1px, 1px);
			}
		<?php
			// If the user has set a custom color for the text use that.
			else :
		?>
			.absolute-header .site-title a,
			.site-description {
				color: #<?php echo esc_attr( $header_text_color ); ?>;
			}
		<?php endif; ?>
		</style>
		<?php
	}
endif;

if ( ! function_exists( 'intuitive_featured_image' ) ) :
	/**
	 * Template for Featured Header Image from theme options
	 *
	 * To override this in a child theme
	 * simply create your own intuitive_featured_image(), and that function will be used instead.
	 *
	 * @since Intuitive 1.0
	 */
	function intuitive_featured_image() {
		$thumbnail = is_front_page() ? 'intuitive-header-inner' : 'intuitive-slider';

		if ( is_post_type_archive( 'jetpack-testimonial' ) ) {
			$jetpack_options = get_theme_mod( 'jetpack_testimonials' );

			if ( isset( $jetpack_options['featured-image'] ) && '' !== $jetpack_options['featured-image'] ) {
				$image = wp_get_attachment_image_src( (int) $jetpack_options['featured-image'], $thumbnail );
				return $image[0];
			} else {
				return false;
			}
		} elseif ( is_post_type_archive( 'jetpack-portfolio' ) || is_post_type_archive( 'featured-content' ) || is_post_type_archive( 'ect-service' ) ) {
			$option = '';

			if ( is_post_type_archive( 'jetpack-portfolio' ) ) {
				$option = 'jetpack_portfolio_featured_image';
			} elseif ( is_post_type_archive( 'featured-content' ) ) {
				$option = 'featured_content_featured_image';
			} elseif ( is_post_type_archive( 'ect-service' ) ) {
				$option = 'ect_service_featured_image';
			}

			$featured_image = get_option( $option );

			if ( '' !== $featured_image ) {
				$image = wp_get_attachment_image_src( (int) $featured_image, $thumbnail );
				return $image[0];
			} else {
				return get_header_image();
			}
		} elseif ( is_header_video_active() && has_header_video() ) {
			return true;
		} else {
			return get_header_image();
		}
	} // intuitive_featured_image
endif;

if ( ! function_exists( 'intuitive_featured_overall_image' ) ) :
	/**
	 * Template for Featured Header Image from theme options
	 *
	 * To override this in a child theme
	 * simply create your own intuitive_featured_pagepost_image(), and that function will be used instead.
	 *
	 * @since Intuitive 1.0
	 */
	function intuitive_featured_overall_image() {
		$enable = get_theme_mod( 'intuitive_header_media_option', 'homepage' );
		
		if ( ( 'homepage' === $enable && ( is_front_page() || is_home() ) ) || 'entire-site' === $enable ) {
			return intuitive_featured_image();
		}

		return false;
	} // intuitive_featured_overall_image
endif;

if ( ! function_exists( 'intuitive_header_media_text' ) ):
	/**
	 * Display Header Media Text
	 *
	 * @since Intuitive 1.0
	 */
	function intuitive_header_media_text() {
		if ( ! intuitive_has_header_media_text() ) {
			// Bail early if header media text is disabled
			return false;
		}

		$content_align = get_theme_mod( 'intuitive_header_media_content_align', 'content-aligned-left' );
		$text_align  = get_theme_mod( 'intuitive_header_media_text_align', 'text-aligned-left' );

		$classes[] = 'custom-header-content';
		$classes[] = $content_align;
		$classes[] = $text_align;

		?>
		<div class="<?php echo esc_attr( implode( ' ', $classes ) ); ?>">
			<div class="entry-container">
				<div class="entry-container-wrap">
				<header class="entry-header">
					<?php 
						if ( is_singular() ) {
							echo '<h1 class="entry-title">';
							intuitive_header_title(); 
							echo '</h1>';
						} else {
							echo '<h2 class="entry-title">';
							intuitive_header_title(); 
							echo '</h2>';
						}
					?>
				</header>

				<?php intuitive_header_text(); ?>
			</div> <!-- .entry-container-wrap -->
			</div>
		</div> <!-- entry-container -->
		<?php
	} // intuitive_header_media_text.
endif;

if ( ! function_exists( 'intuitive_has_header_media_text' ) ):
	/**
	 * Return Header Media Text fro front page
	 *
	 * @since Intuitive 1.0
	 */
	function intuitive_has_header_media_text() {
		$header_media_title    = get_theme_mod( 'intuitive_header_media_title', esc_html__( 'The Solution To
Grow Your Business', 'intuitive' ) );
		$header_media_subtitle = get_theme_mod( 'intuitive_header_media_subtitle', esc_html__( 'We Provide', 'intuitive' ) );
		$header_media_text     = get_theme_mod( 'intuitive_header_media_text' );
		$header_media_url      = get_theme_mod( 'intuitive_header_media_url', '#' );
		$header_media_url_text = get_theme_mod( 'intuitive_header_media_url_text', esc_html__( 'Discover More', 'intuitive' ) );

		$header_image = intuitive_featured_overall_image();

		if ( ( is_front_page() && ! $header_media_title && ! $header_media_subtitle && ! $header_media_text && ! $header_media_url && ! $header_media_url_text ) || ( ( is_singular() || is_archive() || is_search() || is_404() ) && ! $header_image ) ) {
			// Header Media text Disabled1
			return false;
		}

		return true;
	} // intuitive_has_header_media_text.
endif;
