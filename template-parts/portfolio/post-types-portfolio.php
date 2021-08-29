<?php
/**
 * The template for displaying portfolio items
 *
 * @package Intuitive
 */
?>

<?php
$number = get_theme_mod( 'intuitive_portfolio_number', 3 );

if ( ! $number ) {
	// If number is 0, then this section is disabled
	return;
}

$args = array(
	'ignore_sticky_posts' => 1 // ignore sticky posts
);

$post_list  = array();// list of valid post/page ids

$args['post_type'] = 'jetpack-portfolio';

for ( $i = 1; $i <= $number; $i++ ) {
	$intuitive_post_id = '';

	$intuitive_post_id =  get_theme_mod( 'intuitive_portfolio_cpt_' . $i );
	

	if ( $intuitive_post_id && '' !== $intuitive_post_id ) {
		// Polylang Support.
		if ( class_exists( 'Polylang' ) ) {
			$intuitive_post_id = pll_get_post( $intuitive_post_id, pll_current_language() );
		}

		$post_list = array_merge( $post_list, array( $intuitive_post_id ) );

	}
}

$args['post__in'] = $post_list;
$args['orderby'] = 'post__in';


$args['posts_per_page'] = $number;
$loop     = new WP_Query( $args );

if ( $loop -> have_posts() ) :
	while ( $loop -> have_posts() ) :
		$loop -> the_post();

		get_template_part( 'template-parts/portfolio/content', 'portfolio' );

	endwhile;
	wp_reset_postdata();
endif;
