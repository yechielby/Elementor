<?php

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// adding .css file in child theme
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function twentytwentychild_theme_enqueue_styles() {
    $parenthandle = 'twentytwenty-style';
    $theme = wp_get_theme();
    wp_enqueue_style( $parenthandle, get_template_directory_uri() . '/style.css', array(), $theme->parent()->get('Version') );
    wp_enqueue_style( 'twentytwenty-child-style', get_stylesheet_uri(), array( $parenthandle ), filemtime( dirname( __FILE__ ) . '/style.css' ) );
}
add_action( 'wp_enqueue_scripts', 'twentytwentychild_theme_enqueue_styles' );
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////


//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\
// adding .js file in child theme
//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\
// function twentytwentychild_theme_enqueue_scripts() {
//      $theme_version = wp_get_theme()->get( 'Version' );
//	
//      //app script need to be in the End
// 	    wp_enqueue_script( 'script-app', get_stylesheet_directory_uri() . '/app.js', array(), $theme_version, true );
// }
// add_action( 'wp_enqueue_scripts', 'twentytwentychild_theme_enqueue_scripts' );
//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\


///////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Disable wp admin bar for username 'wp-test'
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function twentytwentychild_remove_admin_bar() {
	if (!is_admin()) {
		$user = wp_get_current_user();
		if($user && isset($user->user_login) && $user->user_login == 'wp-test') {
			show_admin_bar(false);
		}
	}
}
add_action('after_setup_theme', 'twentytwentychild_remove_admin_bar');
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////


//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\
// Creating a new Custom Post Type
//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\ 
function twentytwentychild_custom_post_type() {

	// Set UI labels for Custom Post Type
	$labels = array(
		'name'                => _x( 'Products', 'Post Type General Name', 'twentytwentychild' ),
		'singular_name'       => _x( 'Product', 'Post Type Singular Name', 'twentytwentychild' ),
		'menu_name'           => __( 'Products', 'twentytwentychild' ),
		'parent_item_colon'   => __( 'Parent Product', 'twentytwentychild' ),
		'all_items'           => __( 'All Products', 'twentytwentychild' ),
		'view_item'           => __( 'View Product', 'twentytwentychild' ),
		'add_new_item'        => __( 'Add New Product', 'twentytwentychild' ),
		'add_new'             => __( 'Add New', 'twentytwentychild' ),
		'edit_item'           => __( 'Edit Product', 'twentytwentychild' ),
		'update_item'         => __( 'Update Product', 'twentytwentychild' ),
		'search_items'        => __( 'Search Product', 'twentytwentychild' ),
		'not_found'           => __( 'Not Found', 'twentytwentychild' ),
        'not_found_in_trash'  => __( 'Not found in Trash', 'twentytwentychild' )
    );

	// Set other options for Custom Post Type
	$args = array(
		'label'                 => __( 'Products', 'twentytwentychild' ),
		'labels'                => $labels,
		'has_archive'           => true,
		'menu_position'         => 5,
		'menu_icon'             => 'dashicons-tag',
		'public'                => true,
		'rewrite'               => array( 'slug' => 'products' ),
		'show_in_rest'          => true,
		'supports'              => array( 'title', 'editor', 'thumbnail', 'custom-fields' ), //array( 'title', 'editor', 'excerpt', 'author', 'comments', 'revisions', 'custom-fields', ),
    );

	register_post_type( 'products', $args );
}
add_action( 'init', 'twentytwentychild_custom_post_type', 0 );
//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\


///////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// create taxonomies, Categories for the post type 'product'.
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function twentytwentychild_register_new_taxonomy() {
    $labels = [
		'name'              => _x( 'Categories', 'taxonomy general name', 'twentytwentychild' ),
		'singular_name'     => _x( 'Category', 'taxonomy singular name', 'twentytwentychild' ),
		'search_items'      => __( 'Search Categories', 'twentytwentychild' ),
		'all_items'         => __( 'All Categories', 'twentytwentychild' ),
		'parent_item'       => __( 'Parent Category', 'twentytwentychild' ),
		'parent_item_colon' => __( 'Parent Category:', 'twentytwentychild' ),
		'edit_item'         => __( 'Edit Category', 'twentytwentychild' ),
		'update_item'       => __( 'Update Category', 'twentytwentychild' ),
		'add_new_item'      => __( 'Add New Category', 'twentytwentychild' ),
		'new_item_name'     => __( 'New Category Name', 'twentytwentychild' ),
		'menu_name'         => __( 'Categories', 'twentytwentychild' ),
	];

	// Configuration parameters for the Category taxonomy.
	$args = [
		'hierarchical'      => true,
		'labels'            => $labels,
		'show_ui'           => true,
		'show_admin_column' => true,
		'show_in_rest'      => true, // Needed for tax to appear in Gutenberg editor.
		'query_var'         => true,
		'rewrite'           => [ 'slug' => 'custom_categories' ],
	];

	register_taxonomy( 'custom_categories', [ 'products' ], $args );
}
add_action( 'init', 'twentytwentychild_register_new_taxonomy', 0 );
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////


//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\
// register meta for products
//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\
function twentytwentychild_register_meta() {
    
    register_post_meta( 'products', 'twentytwentychild_products_description', array(
        'type'		=> 'string',
        'single'	=> true,
        'show_in_rest'	=> true,
    ) );

    register_post_meta( 'products', 'twentytwentychild_products_price', array(
        'type'		=> 'number',
        'single'	=> true,
        'show_in_rest'	=> true,
    ) );

    register_post_meta( 'products', 'twentytwentychild_products_is_on_sale', array(
        'type'		=> 'boolean',
        'single'	=> true,
        'show_in_rest'	=> true,
    ) );
    
    register_post_meta( 'products', 'twentytwentychild_products_sele_price', array(
        'type'		=> 'number',
        'single'	=> true,
        'show_in_rest'	=> true,
    ) );
    register_post_meta( 'products', 'twentytwentychild_products_video', array(
        'type'		=> 'string',
        'single'	=> true,
        'show_in_rest'	=> true,
    ) );

};
add_action( 'init', 'twentytwentychild_register_meta');
//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\


///////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// add react components in sidebar on Gutenberg
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function twentytwentychild_enqueue_assets() {
    $screen = get_current_screen();
    if( $screen->post_type != 'products' ) return; // only for Product
    
    wp_enqueue_script(
        'twentytwentychild-gutenberg-sidebar',
        get_stylesheet_directory_uri() . '/sidebar/products.js',
        array( 'wp-i18n', 'wp-blocks', 'wp-edit-post', 'wp-element', 'wp-editor', 'wp-components', 'wp-data', 'wp-plugins', 'wp-edit-post' ),
        filemtime( dirname( __FILE__ ) . '/sidebar/products.js' )
    );
}
add_action( 'enqueue_block_editor_assets', 'twentytwentychild_enqueue_assets' );
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////


//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\
//
//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\
function get_product_description( $id ) {
    return get_post_meta($id, 'twentytwentychild_products_description', true);
}
function get_product_price( $id ) {
    return get_post_meta($id, 'twentytwentychild_products_price', true);
}
function get_product_is_on_sale( $id ) {
    return get_post_meta($id, 'twentytwentychild_products_is_on_sale', true);
}
function get_product_sele_price( $id ) {
    return get_post_meta($id, 'twentytwentychild_products_sele_price', true);
}
function get_product_video( $id ) {
    return get_post_meta($id, 'twentytwentychild_products_video', true);
}
//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\


///////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// shortcode
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function get_featured_image_by_id( $id ){
	global $post; 
	$post = get_post($id); 

	ob_start();
	get_template_part( 'template-parts/featured-image');
	$result = ob_get_contents(); 
	ob_end_clean();  
	wp_reset_postdata();

	return $result;
}
function twentytwentychild_product_shortcode($atts) {

	extract(shortcode_atts(array(
		'id'=>0,
		'color'=>'#BBB'
    ), $atts));
    
	$result = '';

	if( $id ) {
        $price = get_product_price($id);
        $is_on_sale = get_product_is_on_sale($id);
        $sele_price = get_product_sele_price($id);

		$result .=	'<div class="grid">';
		$result .= 		'<a href="' . esc_url( get_permalink($id) ) . '" class="grid-column grid-column-center" style="border: 1px solid '. $color .';">';
		$result .= 			get_featured_image_by_id($id);
		$result .=			'<p class="entry-title grid-title">' . get_the_title($id) . '</p>';
		$result .=			'<p class="price">' . ( $is_on_sale ? $price.'<span>'.$sele_price.'</span>' : $price ) . '</p>';
		if( $is_on_sale ) {
			$result .= 		'<div class="sale"><span>'.__('SALE', 'twentytwentychild' ).'</span></div>';
		}
		$result .= 		'</a>';
		$result .=	'</div>';
	}

	return apply_filters('custom_shortcode_product', $result);
}
add_shortcode('product', 'twentytwentychild_product_shortcode');
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////


//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\
// test filter as 'custom_shortcode_product'
//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\
// function aShortcodeFilter(string $input): string	{
//     return '<div style="background: red;">'.$input.'</div>';	
// }
// add_filter('custom_shortcode_product', 'aShortcodeFilter');
//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\


///////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// add endpoint “../wp-json/products/v1/category/slug_or_id”
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function twentytwentychild_products_post_by_category_slug_or_id( $val ) {
    $query_on = is_numeric($val['pram']) ? 'id' : 'slug';
	$args = [
        'post_type' => 'products',
        'posts_per_page' => -1,
        'tax_query' => array(
            array(
                'taxonomy' => 'custom_categories',
                'field' => $query_on,
                'terms' => $val['pram']
            )
        )
	];

	$posts = get_posts($args);


	$data = [];
	$i = 0;
	foreach($posts as $post) {
		$data[$i]['id'] = $post->ID;
        $data[$i]['slug'] = $post->post_name;
        $data[$i]['link'] = get_permalink( $post->ID );
		$data[$i]['title'] = $post->post_title;
        $data[$i]['description'] = get_product_description($post->ID);
		$data[$i]['featured_image']['thumbnail'] = get_the_post_thumbnail_url($post->ID, 'thumbnail');
		$data[$i]['featured_image']['medium'] = get_the_post_thumbnail_url($post->ID, 'medium');
        $data[$i]['featured_image']['large'] = get_the_post_thumbnail_url($post->ID, 'large');
        $data[$i]['price'] = get_product_price($post->ID);
        $data[$i]['is_on_sale'] = get_product_is_on_sale($post->ID);
        $data[$i]['sele_price'] = get_product_sele_price($post->ID);
		$i++;
	}

	return $data;
}

function twentytwentychild_new_endpoints() {
	register_rest_route( 'products/v1', 'category/(?P<pram>[a-zA-Z0-9-]+)', array(
		'methods' => 'GET',
		'callback' => 'twentytwentychild_products_post_by_category_slug_or_id',
	) );
};
add_action('rest_api_init', 'twentytwentychild_new_endpoints');
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////


//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\
//
//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\
function twentytwentychild_custom_columns_posts_head($defaults) {
    // ADD NEW COLUMN
    $new_array['shortcode'] = '<div style="text-align: center;">Shortcode<div>';
    array_splice( $defaults, 3, 0, $new_array );
    return $defaults;
}

function twentytwentychild_custom_columns_content($column_name, $post_ID) {
    switch ( $column_name ) {
        case 'shortcode':
            echo '<div style="text-align: center;"><code>[product id="'.$post_ID.'" color="#BBB"]</code><div>';
            break;
    }
}
add_filter('manage_products_posts_columns', 'twentytwentychild_custom_columns_posts_head');
add_action('manage_products_posts_custom_column', 'twentytwentychild_custom_columns_content', 10,2);
//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\


///////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// code..
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////