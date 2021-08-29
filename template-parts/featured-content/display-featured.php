<?php
/**
 * The template for displaying featured content
 *
 * @package Intuitive
 */
?>

<?php
$enable_content = get_theme_mod( 'intuitive_featured_content_option', 'disabled' );

if ( ! intuitive_check_section( $enable_content ) ) {
	// Bail if featured content is disabled.
	return;
}

$featured_posts = intuitive_get_featured_posts();

if ( empty( $featured_posts ) ) {
	return;
}


$intuitive_title    = get_option( 'featured_content_title', esc_html__( 'Contents', 'intuitive' ) );
$subtitle = get_option( 'featured_content_content' );

?>

<div class="featured-content-section section">
	<div class="wrapper">
		<?php if ( '' !== $intuitive_title || $subtitle ) : ?>
			<div class="section-heading-wrapper">
				<?php if ( '' !== $intuitive_title ) : ?>
					<div class="section-title-wrapper">
						<h2 class="section-title"><?php echo wp_kses_post( $intuitive_title ); ?></h2>
					</div><!-- .page-title-wrapper -->
				<?php endif; ?>

				<?php if ( $subtitle ) : ?>
					<div class="section-description">
						<?php
						$subtitle = apply_filters( 'the_content', $subtitle );
						echo wp_kses_post( str_replace( ']]>', ']]&gt;', $subtitle ) );
						?>
					</div><!-- .section-description -->
				<?php endif; ?>
			</div><!-- .section-heading-wrapper -->
		<?php endif; ?>

		<div class="section-content-wrapper layout-three">

			<?php
			  	foreach ( $featured_posts as $post ) {
			  		setup_postdata( $post );

					// Include the featured content template.
					get_template_part( 'template-parts/featured-content/content', 'featured' );
				}

				wp_reset_postdata();
			?>
		</div><!-- .featured-content-wrapper -->
	</div><!-- .wrapper -->
</div><!-- #featured-content-section -->
