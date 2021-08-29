<?php
/**
 * The template for displaying featured posts on the front page
 *
 * @package Intuitive
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="hentry-inner">
		<?php if ( has_post_thumbnail() ) { ?>
			<div class="post-thumbnail">
				<a href="<?php the_permalink(); ?>">
					<?php

						the_post_thumbnail( 'intuitive-featured-content' );
					?>
				</a>
			</div>
		<?php } ?>

		<div class="entry-container">
			<header class="entry-header">
					<?php the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">','</a></h2>' ); ?>

				<?php 
				echo '<div class="entry-meta">';
					intuitive_posted_on();
				echo '</div><!-- .entry-meta -->';
				?>

			</header>

			<div class="entry-summary"><?php the_excerpt(); ?></div><!-- .entry-summary -->
		</div><!-- .entry-container -->
	</div> <!-- .hentry-inner -->
</article>
