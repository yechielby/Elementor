<?php
/**
 * The products template for displaying content
 *
 * Used for singular product.
 *
 * @package WordPress
 * @subpackage Twenty_Twenty
 * @since Twenty Twenty 1.0
 */

?>

<article <?php post_class(); ?> id="post-<?php the_ID(); ?>">

	<?php

	get_template_part( 'template-parts/entry-header' );

	if ( ! is_search() ) {
		get_template_part( 'template-parts/featured-image' );
	}

	?>

	<div class="post-inner <?php echo is_page_template( 'templates/template-full-width.php' ) ? '' : 'thin'; ?> ">

		<div class="entry-content">

			<?php
			if ( is_search() || ! is_singular() && 'summary' === get_theme_mod( 'blog_content', 'full' ) ) {
				the_excerpt();
			} else {
				the_content( __( 'Continue reading', 'twentytwenty' ) );
			}
			?>

		</div><!-- .entry-content -->

	</div><!-- .post-inner -->

	<div class="section-inner">
		<?php
		wp_link_pages(
			array(
				'before'      => '<nav class="post-nav-links bg-light-background" aria-label="' . esc_attr__( 'Page', 'twentytwenty' ) . '"><span class="label">' . __( 'Pages:', 'twentytwenty' ) . '</span>',
				'after'       => '</nav>',
				'link_before' => '<span class="page-number">',
				'link_after'  => '</span>',
			)
		);

		edit_post_link();

		// Single bottom post meta.
		twentytwenty_the_post_meta( get_the_ID(), 'single-bottom' );

		if ( post_type_supports( get_post_type( get_the_ID() ), 'author' ) && is_single() ) {

			get_template_part( 'template-parts/entry-author-bio' );

		}
		?>

	</div><!-- .section-inner -->

	<?php
	// Related Products
	$post_id = get_the_ID();
	$categories = wp_get_post_terms($post_id, 'custom_categories');
	// get the list category in this product.
	$categories_ids = array();
	foreach ($categories as $category) {
		$categories_ids[] = $category->term_id;
	}
	// The Query
	$the_query = new WP_Query( array(
		'post_type' => 'products',
		'post_status' => 'publish',
		'post__not_in'=> array($post_id),
		'tax_query' => array(array(
			'taxonomy' => 'custom_categories',
			'field' => 'term_id',
			'terms' => $categories_ids,
			'operator' => 'IN'
		)),
		'orderby' => 'date',
		'order' => 'DESC',
		'posts_per_page' => 3
	));

	// The Loop
	if ( $the_query->have_posts() ) {
		echo '<div class="section-inner section-categories">'.
				'<h2 class="widget-title subheading heading-size-3">'.__('Related Products', 'twentytwentychild' ).'</h2>'.
				'<div class="grid">';
					while ( $the_query->have_posts() ) {
						$the_query->the_post();
						echo '<a href="' . esc_url( get_permalink() ) . '" class="grid-column">';
						get_template_part( 'template-parts/featured-image' );
						the_title( '<p class="entry-title grid-title">', '</p>' );
						echo '<div class="sale"><span>'.__('SALE', 'twentytwentychild' ).'</span></div>';
						echo '</a>';
					}
				echo '</div>'.
			'</div>';
	}
	wp_reset_postdata();

	?>

	<?php

	if ( is_single() ) {

		get_template_part( 'template-parts/navigation' );

	}

	/**
	 *  Output comments wrapper if it's a post, or if comments are open,
	 * or if there's a comment number – and check for password.
	 * */
	if ( ( is_single() || is_page() ) && ( comments_open() || get_comments_number() ) && ! post_password_required() ) {
		?>

		<div class="comments-wrapper section-inner">

			<?php comments_template(); ?>

		</div><!-- .comments-wrapper -->

		<?php
	}
	?>

</article><!-- .post -->
