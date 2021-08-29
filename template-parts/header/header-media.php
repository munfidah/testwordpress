<?php
/**
 * Display Header Media
 *
 * @package Intuitive
 */
?>

<?php
	$header_image = intuitive_featured_overall_image();

	if ( '' == $header_image && ! intuitive_has_header_media_text() ) {
		// Bail if all header media are disabled.
		return;
	}
?>
<div class="custom-header">
	<?php if ( ( is_header_video_active() && has_header_video() ) || $header_image ) : ?>
	<div class="custom-header-media">
		<?php
		if ( is_header_video_active() && has_header_video() ) {
			the_custom_header_markup();
		} elseif ( $header_image ) {
			echo '<img src="' . esc_url( $header_image ) . '"/>';
		}
		?>
	</div>
	<?php endif; ?>

	<?php intuitive_header_media_text(); ?>

	<?php
		if ( get_theme_mod( 'intuitive_header_media_scroll_down', 1 ) ) { ?>
			<div class="scroll-down">
				<?php echo '<span>' . esc_html__( 'Scroll', 'intuitive' ) . '</span>
				<span class="fa fa-angle-down" aria-hidden="true"></span>
			</div><!-- .scroll-down -->';
	}	?>
</div><!-- .custom-header -->
