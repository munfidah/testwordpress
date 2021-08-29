<?php
/**
 * Primary Menu Template
 *
 * @package Intuitive Pro
 */

?>
<div id="site-header-menu" class="site-header-menu">
	<div id="primary-menu-wrapper" class="menu-wrapper">
		<div class="menu-toggle-wrapper">
			<button id="menu-toggle" class="menu-toggle" aria-controls="top-menu" aria-expanded="false">
				<span class="menu-label"><?php echo esc_html_e( 'Menu', 'intuitive' ); ?></span>
			</button>
		</div><!-- .menu-toggle-wrapper -->

		<div class="menu-inside-wrapper">
				<?php get_template_part( 'template-parts/header/header', 'navigation' ); ?>

				<div class="mobile-header-top">
					<?php get_template_part( 'template-parts/header/header', 'top' ); ?>
				</div>

			<div class="mobile-social-search">
				<div class="search-container">
					<?php get_search_form(); ?>
				</div>

				<nav class="social-navigation" role="navigation" aria-label="<?php esc_attr_e( 'Social Links Menu', 'intuitive' ); ?>">
					<?php
						wp_nav_menu( array(
							'theme_location' => 'social',
							'container'       => 'div',
							'container_class' => 'menu-social-container',
							'link_before'    => '<span class="screen-reader-text">',
							'link_after'     => '</span>',
							'depth'          => 1,
						) );
					?>
				</nav><!-- .social-navigation -->
			</div><!-- .mobile-social-search -->
		</div><!-- .menu-inside-wrapper -->
	</div><!-- #primary-menu-wrapper.menu-wrapper -->

	<?php get_template_part( 'template-parts/header/social', 'header' ); ?>

	<div id="primary-search-wrapper" class="menu-wrapper">
		<div class="menu-toggle-wrapper">
			<button id="search-toggle" class="menu-toggle search-toggle">
				<span class="menu-label screen-reader-text"><?php echo esc_html_e( 'Search', 'intuitive' ); ?></span>
			</button>
		</div><!-- .menu-toggle-wrapper -->

		<div class="menu-inside-wrapper">
			<div class="search-container">
				<?php get_Search_form(); ?>
			</div>
		</div><!-- .menu-inside-wrapper -->
	</div><!-- #social-search-wrapper.menu-wrapper -->
</div><!-- .site-header-menu -->
