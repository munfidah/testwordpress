<?php
/**
 * Template part for displaying posts
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Intuitive
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<div class="hentry-inner">
		<?php
		$thumb = get_the_post_thumbnail_url( $post->ID );

		if ( ! $thumb ) {
			$thumb = trailingslashit( esc_url ( get_template_directory_uri() ) ) . 'assets/images/no-thumb-606x606.jpg';
		}

		?>
		<div class="post-thumbnail" style="background-image: url( '<?php echo esc_url( $thumb ); ?>' )">
			<a href="<?php the_permalink(); ?>" rel="bookmark"></a>
		</div>

		<div class="entry-container">
			<?php if ( is_sticky() ) { ?>
			<span class="sticky-label"><?php esc_html_e( 'Featured', 'intuitive' ); ?></span>
			<?php } ?>

			<header class="entry-header">
				<?php
				if ( is_singular() ) :
					the_title( '<h1 class="entry-title">', '</h1>' );
				else :
					the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
				endif;
				
				if ( 'post' === get_post_type() ) :
					?>
					<div class="entry-meta">
						<?php intuitive_posted_on(); ?>
					</div><!-- .entry-meta -->
				<?php
				endif;
				?>
			</header><!-- .entry-header -->

			<div class="entry-summary"><?php the_excerpt(); ?></div><!-- .entry-summary -->
		</div> <!-- .entry-container -->
	</div> <!-- .hentry-inner -->
</article><!-- #post-<?php the_ID(); ?> -->
