<?php
/**
 * The template for displaying testimonial items
 *
 * @package Intuitive
 */
?>

<?php
$enable = get_theme_mod( 'intuitive_testimonial_option', 'disabled' );

if ( ! intuitive_check_section( $enable ) ) {
	// Bail if featured content is disabled
	return;
}

// Get Jetpack options for testimonial.
$jetpack_defaults = array(
	'page-title' => esc_html__( 'Testimonials', 'intuitive' ),
);

// Get Jetpack options for testimonial.
$jetpack_options = get_theme_mod( 'jetpack_testimonials', $jetpack_defaults );

$headline        = isset( $jetpack_options['page-title'] ) ? $jetpack_options['page-title'] : esc_html__( 'Testimonials', 'intuitive' );

$subheadline = isset( $jetpack_options['page-content'] ) ? $jetpack_options['page-content'] : '';


$classes[] = 'section testimonial-wrapper';

?>

<div class="testimonials-content-wrapper <?php echo esc_attr( implode( ' ', $classes ) ); ?>">
	<div class="wrapper">

		<?php if ( $headline || $subheadline ) : ?>
			<div class="section-heading-wrapper">
			<?php if ( $headline ) : ?>
				<div class="section-title-wrapper">
					<h2 class="section-title"><?php echo wp_kses_post( $headline ); ?></h2>
				</div>
			<?php endif; ?>

			<?php if ( $subheadline ) : ?>
				<div class="section-description">
					<?php
					$subheadline = apply_filters( 'the_content', $subheadline );
					echo str_replace( ']]>', ']]&gt;', $subheadline );
					?>
				</div><!-- .section-description -->
			<?php endif; ?>
			</div><!-- .section-heading-wrap -->
		<?php endif; ?>

		<?php
			get_template_part( 'template-parts/testimonials/post-types', 'testimonial' );
		?>
	</div><!-- .wrapper -->
</div><!-- .testimonials-content-wrapper -->
