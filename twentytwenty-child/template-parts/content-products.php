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

$post_id = get_the_ID();
$description = get_product_description($post_id);
$video = get_product_video($post_id);
$price = get_product_price($post_id);
$is_on_sale = get_product_is_on_sale($post_id);
$sele_price = get_product_sele_price($post_id);
?>

<article <?php post_class(); ?> id="post-<?php the_ID(); ?>">

	<header class="entry-header has-text-align-center header-footer-group">
		<div class="entry-header-inner section-inner medium">
			<h1 class="entry-title"><?php the_title(); ?></h1>
		</div><!-- .entry-header-inner -->
	</header>
	
	<?php
	get_template_part( 'template-parts/featured-image' );
	echo '<p class="price">$' . ( $is_on_sale ? $price.'<span>$'.$sele_price.'</span>' : $price ) . '</p>';
	?>

	<div class="post-inner thin">
		<div class="entry-content">
			<?php
			echo '<div class="section-inner section-description">';
			echo 	'<h2 class="widget-title subheading heading-size-3">'.__('Product Description', 'twentytwentychild' ).'</h2>';
			echo	'<p class="heading-size-5">'.$description.'</p>';
			if ($video) {
			echo 	'<iframe  class="product-video"  width="1280" height="720" src="'.$video.'" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>';
			}
			echo '</div>';
			?>

			
			<?php the_content( __( 'Continue reading', 'twentytwenty' ) ); ?>
				

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
									if ( get_product_is_on_sale( get_the_ID() ) ) {
									echo '<div class="sale"><span>'.__('SALE', 'twentytwentychild' ).'</span></div>';
									}
								echo '</a>';
							}
						echo '</div>'.
					'</div>';
			}
			wp_reset_postdata();

			?>

		</div><!-- .entry-content -->
	</div><!-- .post-inner -->

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
