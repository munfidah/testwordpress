<?php
/**
 * Custom template tags for this theme
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package Intuitive
 */

if ( ! function_exists( 'intuitive_posted_on' ) ) :
	/**
	 * Prints HTML with meta information for the current post-date/time and author.
	 */
	function intuitive_posted_on() {
		$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
		if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
			$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
		}

		$time_string = sprintf( $time_string,
			esc_attr( get_the_date( 'c' ) ),
			esc_html( get_the_date() ),
			esc_attr( get_the_modified_date( 'c' ) ),
			esc_html( get_the_modified_date() )
		);

		$posted_on = sprintf(
			/* translators: %s: post date */
			__( '<span class="date-label"> </span>%s', 'intuitive' ),
			'<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>'
		);

		// Get the author name; wrap it in a link.
		$byline = sprintf(
			/* translators: %s: post author */
			__( '<span class="author-label">By </span>%s', 'intuitive' ),
			'<span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a></span>'
		);

		echo '<span class="byline screen-reader-text"> ' . $byline . '</span><span class="posted-on">' . $posted_on . '</span>';

	}
endif;

if ( ! function_exists( 'intuitive_entry_category' ) ) :
	/**
	 * Prints HTML with meta information for the category.
	 */
	function intuitive_entry_category( $echo = true ) {
		$output = '';

		// Hide category and tag text for pages.
		if ( 'post' === get_post_type() ) {
			/* translators: used between list items, there is a space after the comma */
			$categories_list = get_the_category_list( ' ' );
			if ( $categories_list ) {
				/* translators: 1: list of categories. */
				$output = sprintf( '<span class="cat-links">%1$s%2$s</span>',
					sprintf( _x( '<span class="cat-text screen-reader-text">Categories</span>', 'Used before category names.', 'intuitive' ) ),
					$categories_list
				);
			}
		}

		if ( 'ect-service' === get_post_type() || 'featured-content' === get_post_type() || 'jetpack-portfolio' === get_post_type() ) {
			/* translators: used between list items, there is a space after the comma */
			$term_list = get_the_term_list( get_the_ID(), get_post_type() . '-type' );
			if ( $term_list &&  ! is_wp_error( $term_list ) ) {
				/* translators: 1: list of categories. */
				$output = sprintf( '<span class="cat-links">%1$s%2$s</span>',
					sprintf( _x( '<span class="cat-text screen-reader-text">Categories</span>', 'Used before category names.', 'intuitive' ) ),
					$term_list
				);
			}
		}

		if ( $echo ) {
			echo $output;
		} else {
			return $output;
		}
	}
endif;

if ( ! function_exists( 'intuitive_entry_footer' ) ) :
	/**
	 * Prints HTML with meta information for the categories, tags and comments.
	 */
	function intuitive_entry_footer() {
		// Hide category and tag text for pages.
		if ( 'post' === get_post_type() ) {
			/* translators: used between list items, there is a space after the comma */
			$categories_list = get_the_category_list( ' ' );
			if ( $categories_list ) {
				/* translators: 1: list of categories. */
				printf( '<span class="cat-links">%1$s%2$s</span>',
					sprintf( _x( '<span class="cat-text screen-reader-text">Categories</span>', 'Used before category names.', 'intuitive' ) ),
					$categories_list
				);
			}

			/* translators: used between list items, there is a space after the comma */
			$tags_list = get_the_tag_list();
			if ( $tags_list ) {
				/* translators: 1: list of tags. */
				printf( '<span class="tags-links">%1$s%2$s</span>',
					sprintf( _x( '<span class="tags-text screen-reader-text">Tags</span>', 'Used before tag names.', 'intuitive' ) ),
					$tags_list
				);
			}
		}

		if ( ! is_single() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
			echo '<span class="comments-link">';
			comments_popup_link(
				sprintf(
					wp_kses(
						/* translators: %s: post title */
						__( 'Leave a Comment<span class="screen-reader-text"> on %s</span>', 'intuitive' ),
						array(
							'span' => array(
								'class' => array(),
							),
						)
					),
					get_the_title()
				)
			);
			echo '</span>';
		}

		edit_post_link(
			sprintf(
				wp_kses(
					/* translators: %s: Name of current post. Only visible to screen readers */
					__( 'Edit <span class="screen-reader-text">%s</span>', 'intuitive' ),
					array(
						'span' => array(
							'class' => array(),
						),
					)
				),
				get_the_title()
			),
			'<span class="edit-link">',
			'</span>'
		);
	}
endif;

if ( ! function_exists( 'intuitive_author_bio' ) ) :
	/**
	 * Prints HTML with meta information for the author bio.
	 */
	function intuitive_author_bio() {
		if ( '' !== get_the_author_meta( 'description' ) ) {
			get_template_part( 'template-parts/biography' );
		}
	}
endif;

if ( ! function_exists( 'intuitive_header_title' ) ) :
	/**
	 * Display Header Media Title
	 */
	function intuitive_header_title() {
		if ( is_front_page() ) {
			$subtitle = get_theme_mod( 'intuitive_header_media_subtitle', esc_html__( 'We Provide', 'intuitive' ) ) ? '<span class="sub-title">' . wp_kses_post( get_theme_mod( 'intuitive_header_media_subtitle', esc_html__( 'We Provide', 'intuitive' ) ) ) . '</span><!-- .sub-title -->' : '';

			echo wp_kses_post( $subtitle . get_theme_mod( 'intuitive_header_media_title', 'The Solution To
Grow Your Business' ) );
		} elseif ( is_singular() ) {
			the_title();
		} elseif ( is_404() ) {
			esc_html_e( 'Oops! That page can&rsquo;t be found.', 'intuitive' );
		} elseif ( is_search() ) {
			/* translators: %s: search query. */
			printf( esc_html__( 'Search Results for: %s', 'intuitive' ), '<span>' . get_search_query() . '</span>' );
		} else {
			the_archive_title();
		}
	}
endif;

if ( ! function_exists( 'intuitive_header_text' ) ) :
	/**
	 * Display Header Media Text
	 */
	function intuitive_header_text() {
		if ( is_front_page() ) {
			$content = get_theme_mod( 'intuitive_header_media_text' );

			if ( $header_media_url = get_theme_mod( 'intuitive_header_media_url', '#' ) ) {
				$target = get_theme_mod( 'intuitive_header_url_target' ) ? '_blank' : '_self';

				$content .= '<span class="more-button"><a href="'. esc_url( $header_media_url ) . '" target="' . $target . '" class="more-link">' .esc_html( get_theme_mod( 'intuitive_header_media_url_text', 'Discover More' ) ) . '<span class="screen-reader-text">' .wp_kses_post( get_theme_mod( 'intuitive_header_media_title' ) ) . '</span></a></span>';
			}

			echo '<div class="entry-summary">' . wp_kses_post( $content ) . '</div>';
		} elseif ( is_404() ) {
			esc_html_e( 'It looks like nothing was found at this location. Maybe try one of the links below or a search?', 'intuitive' );
		} elseif( ! is_search() ) {
			the_archive_description();
		}
	}
endif;


if ( ! function_exists( 'intuitive_single_image' ) ) :
	/**
	 * Display Single Page/Post Image
	 */
	function intuitive_single_image() {
		$featured_image = get_theme_mod( 'intuitive_single_layout', 'disabled' );

		if ( 'disabled' == $featured_image || ! has_post_thumbnail() ) {
			echo '<!-- Page/Post Single Image Disabled -->';
			return false;
		}
		
		?>
		<div class="post-thumbnail <?php echo esc_attr( $featured_image ); ?>">
            <?php the_post_thumbnail( $featured_image ); ?>
        </div>
	   	<?php
	}
endif;

if ( ! function_exists( 'intuitive_comment' ) ) :
	/**
	 * Template for comments and pingbacks.
	 * Used as a callback by wp_list_comments() for displaying the comments.
	 */
	function intuitive_comment( $comment, $args, $depth ) {
		if ( 'pingback' == $comment->comment_type || 'trackback' == $comment->comment_type ) : ?>

		<li id="comment-<?php comment_ID(); ?>" <?php comment_class(); ?>>
			<div class="comment-body">
				<?php esc_html_e( 'Pingback:', 'intuitive' ); ?> <?php comment_author_link(); ?> <?php edit_comment_link( esc_html__( 'Edit', 'intuitive' ), '<span class="edit-link">', '</span>' ); ?>
			</div>

		<?php else : ?>

		<li id="comment-<?php comment_ID(); ?>" <?php comment_class( empty( $args['has_children'] ) ? '' : 'parent' ); ?>>
			<article id="div-comment-<?php comment_ID(); ?>" class="comment-body">

				<div class="comment-author-container">
					<div class="comment-author vcard">
						<?php if ( 0 != $args['avatar_size'] ) echo get_avatar( $comment, $args['avatar_size'] ); ?>
					</div><!-- .comment-author -->

						<div class="comment-metadata">


							<?php
								comment_reply_link( array_merge( $args, array(
									'add_below' => 'div-comment',
									'depth'     => $depth,
									'max_depth' => $args['max_depth'],
									'before'    => '<span class="reply">',
									'after'     => '</span>',
								) ) );
							?>
					</div><!-- .comment-metadata -->

				</div><!-- .comment-container -->

				<div class="comment-container">
				<div class="comment-content">
					<?php comment_text(); ?>
					</div><!-- .comment-content -->

										<div class="comment-header">
							<header class="comment-meta">
							<?php printf( __( '%s <span class="says screen-reader-text">says:</span>', 'intuitive' ), sprintf( '<cite class="fn author-name">%s</cite>', get_comment_author_link() ) ); ?>
						</header><!-- .comment-meta -->
						<div class="comment-metadata">
									<a class="comment-permalink" href="<?php echo esc_url( get_comment_link( $comment->comment_ID ) ); ?>">
								<time datetime="<?php comment_time( 'c' ); ?>">
									<?php
										printf(
											/* translators: Comment Date at Comment Time */
											esc_html__( '%1$s at %2$s', 'intuitive' ),
											get_comment_time( get_option( 'date_format' ) ),
											get_comment_time( get_option( 'time_format' ) )
										);
									?>
								</time></a>
							<?php edit_comment_link( esc_html__( 'Edit', 'intuitive' ), '<span class="edit-link">', '</span>' ); ?>

							<?php if ( '0' == $comment->comment_approved ) : ?>
								<p class="comment-awaiting-moderation"><?php esc_html_e( 'Your comment is awaiting moderation.', 'intuitive' ); ?></p>
							<?php endif; ?>
						</div> <!-- .comment-metadata -->
						</div><!-- .comment-header -->
				</div><!-- .comment-container -->
			</article><!-- .comment-body -->
		<?php /* No closing </li> is needed.  WordPress will know where to add it. */ ?>

		<?php
		endif;
	}
endif; // ends check for intuitive_comment()


