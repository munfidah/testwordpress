<?php
/**
 * The template for displaying the Slider
 *
 * @package Intuitive
 */

if ( ! function_exists( 'intuitive_featured_slider' ) ) :
	/**
	 * Add slider.
	 *
	 * @uses action hook intuitive_before_content.
	 *
	 * @since Intuitive 1.0
	 */
	function intuitive_featured_slider() {
		if ( intuitive_is_slider_displayed() ) {
			$output = '
				<div class="slider-content-wrapper section style-without-bg">
					<div class="wrapper">
						<div class="section-content-wrap">
							<div class="cycle-slideshow"
								data-cycle-log="false"
								data-cycle-pause-on-hover="true"
								data-cycle-swipe="true"
								data-cycle-auto-height=container
								data-cycle-speed=1000
								data-cycle-pager="#featured-slider-pager"
								data-cycle-prev="#featured-slider-prev"
								data-cycle-next="#featured-slider-next"
								data-cycle-slides="> .post-slide"
								>';

							$output .= '
											<div class="controllers">
												<!-- prev/next links -->
												<div id="featured-slider-prev" class="cycle-prev fa fa-angle-left" aria-label="Previous" aria-hidden="true"><span class="screen-reader-text">' . esc_html__( 'Previous Slide', 'intuitive' ) . '</span></div>

												<!-- empty element for pager links -->
												<div id="featured-slider-pager" class="cycle-pager"></div>

												<div id="featured-slider-next" class="cycle-next fa fa-angle-right" aria-label="Next" aria-hidden="true"><span class="screen-reader-text">' . esc_html__( 'Next Slide', 'intuitive' ) . '</span></div>

											</div><!-- .controllers -->';

							$output .= intuitive_post_page_category_slider();
							
							$output .= '</div><!-- .cycle-slideshow -->
						</div><!-- .section-content-wrap -->
					</div><!-- .wrapper -->	
					
					<div class="scroll-down">
						<span>' . esc_html__( 'Scroll', 'intuitive' ) . '</span>
						<span class="fa fa-angle-down" aria-hidden="true"></span>
					</div><!-- .scroll-down -->
				</div><!-- .slider-content-wrapper -->';

			echo $output;
		} // End if().
	}
	endif;
add_action( 'intuitive_slider', 'intuitive_featured_slider', 10 );

if ( ! function_exists( 'intuitive_post_page_category_slider' ) ) :
	/**
	 * This function to display featured posts/page/category slider
	 *
	 * @param $options: intuitive_theme_options from customizer
	 *
	 * @since Intuitive 1.0
	 */
	function intuitive_post_page_category_slider() {
		$quantity     = get_theme_mod( 'intuitive_slider_number', 4 );
		$no_of_post   = 0; // for number of posts
		$post_list    = array();// list of valid post/page ids
		$output       = '';

		$args = array(
			'post_type'           => 'page',
			'orderby'             => 'post__in',
			'ignore_sticky_posts' => 1, // ignore sticky posts
		);

		for ( $i = 1; $i <= $quantity; $i++ ) {
			$post_id = get_theme_mod( 'intuitive_slider_page_' . $i );

			if ( $post_id && '' !== $post_id ) {
				$post_list = array_merge( $post_list, array( $post_id ) );

				$no_of_post++;
			}
		}
		
		$args['post__in'] = $post_list;

		if ( ! $no_of_post ) {
			return;
		}

		$args['posts_per_page'] = $no_of_post;

		$loop = new WP_Query( $args );

		while ( $loop->have_posts() ) :
			$loop->the_post();

			$title_attribute = the_title_attribute( 'echo=0' );

			$text_align = 'text-aligned-left';

			$content_position = 'content-aligned-left';
			
			if ( 0 === $loop->current_post ) {
				$classes = 'post post-' . get_the_ID() . ' hentry slides displayblock ' . $content_position . ' ' . $text_align;

			} else {
				$classes = 'post post-' . get_the_ID() . ' hentry slides displaynone ' . $content_position . ' ' . $text_align;
			}

			$thumbnail = 'intuitive-slider';
			$image_url = trailingslashit( esc_url ( get_template_directory_uri() ) ) . 'assets/images/no-thumb-1920x1080.jpg';

			if ( has_post_thumbnail() ) {
				$image_url = get_the_post_thumbnail_url( get_the_ID(), $thumbnail );
			} else {
				// Get the first image in page, returns false if there is no image.
				$first_image_url = intuitive_get_first_image( get_the_ID(), $thumbnail, '', true );

				// Set value of image as first image if there is an image present in the page.
				if ( $first_image_url ) {
					$image_url = $first_image_url;
				}
			}

			$more_tag_text = get_theme_mod( 'intuitive_excerpt_more_text',  esc_html__( 'Continue reading', 'intuitive' ) );

			$output .= '
			<div class="post-slide">
				<article class="' . esc_attr( $classes ) . '">
					<div class="slider-image">
						<a href="' . esc_url( get_permalink() ) . '" title="' . $title_attribute . '">
							<img src="' . esc_url( $image_url ) . '" class="wp-post-image" alt="' . $title_attribute . '">
						</a>
					</div><!-- .slider-image -->
					
					<div class="entry-container">
						<div class="entry-container-wrap">
							' . the_title( '<header class="entry-header"><h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '">', '</a></h2></header>', false ) . '

							<div class="entry-summary"><p>' . wp_strip_all_tags(get_the_excerpt() ) . '</p></div><!-- .entry-summary -->
						</div><!-- .entry-container-wrap -->
					</div><!-- .entry-container -->
				</article><!-- .slides -->
			</div><!-- .post-slide -->';
		endwhile;

		wp_reset_postdata();

		return $output;
	}
endif; // intuitive_post_page_category_slider.

if ( ! function_exists( 'intuitive_is_slider_displayed' ) ) :
	/**
	 * Return true if slider image is displayed
	 *
	 */
	function intuitive_is_slider_displayed() {
		$enable_slider = get_theme_mod( 'intuitive_slider_option', 'disabled' );

		return intuitive_check_section( $enable_slider );
	}
endif; // intuitive_is_slider_displayed.
