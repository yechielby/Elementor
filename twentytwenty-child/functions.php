<?php

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// adding .css file in child theme
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function twentytwentychild_theme_enqueue_styles() {
    $parenthandle = 'twentytwenty-style';
    $theme = wp_get_theme();
    wp_enqueue_style( $parenthandle, get_template_directory_uri() . '/style.css', array(), $theme->parent()->get('Version') );
    wp_enqueue_style( 'twentytwenty-child-style', get_stylesheet_uri(), array( $parenthandle ), $theme->get('Version') );
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
		'not_found_in_trash'  => __( 'Not found in Trash', 'twentytwentychild' ),
	);
		 
	// Set other options for Custom Post Type
	$args = array(
		'label'               => __( 'Products', 'twentytwentychild' ),
		'labels' => $labels,
		'has_archive' => true,
		'menu_position'       	=> 5,
		'menu_icon'				=> 'dashicons-tag',
		'public' => true,
		'rewrite' => array( 'slug' => 'products' ),
		'show_in_rest' => true,
		'supports' => array( 'title', 'editor', 'thumbnail' ), //array( 'title', 'editor', 'excerpt', 'author', 'comments', 'revisions', 'custom-fields', ),
		'publicly_queryable'  	=> true,
		'query_var'          => true,		
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
//
//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\
// code..
//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\


///////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// code..
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////