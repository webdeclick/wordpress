<?php

function products_post_type() {

    $labels = array(
        'name'                => _x( 'Products', 'Post Type General Name', 'text_domain' ),
        'singular_name'       => _x( 'Product', 'Post Type Singular Name', 'text_domain' ),
        'menu_name'           => __( 'Products', 'text_domain' ),
        'parent_item_colon'   => __( 'Parent Product:', 'text_domain' ),
        'all_items'           => __( 'All Products', 'text_domain' ),
        'view_item'           => __( 'View Product', 'text_domain' ),
        'add_new_item'        => __( 'Add New Product', 'text_domain' ),
        'add_new'             => __( 'New Product', 'text_domain' ),
        'edit_item'           => __( 'Edit Product', 'text_domain' ),
        'update_item'         => __( 'Update Product', 'text_domain' ),
        'search_items'        => __( 'Search products', 'text_domain' ),
        'not_found'           => __( 'No products found', 'text_domain' ),
        'not_found_in_trash'  => __( 'No products found in Trash', 'text_domain' ),
    );
    $args = array(
        'label'               => __( 'product', 'text_domain' ),
        'description'         => __( 'Product information pages', 'text_domain' ),
        'labels'              => $labels,
        'supports'            => array( 'title', 'editor', 'excerpt', 'thumbnail', 'custom-fields', ),
        'taxonomies'          => array( 'category', 'post_tag', 'salut_tag' ),
        'hierarchical'        => false,
        'public'              => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'show_in_nav_menus'   => true,
        'show_in_admin_bar'   => true,
        'menu_position'       => 5,
        'can_export'          => true,
        'has_archive'         => true,
        'exclude_from_search' => false,
        'publicly_queryable'  => true,
        'capability_type'     => 'page',
    );
    register_post_type( 'product', $args );

}

// Hook into the 'init' action
add_action( 'init', 'products_post_type');


// hook into the init action and call create_course_taxonomies when it fires
add_action( 'init', 'create_marque_taxonomies', 0 );
 
// create two taxonomies, course and writers for the post type "post"
function create_marque_taxonomies() {
    // Add new taxonomy, make it hierarchical (like categories)
    $labels = array(
        'name'              => _x( 'Marques', 'taxonomy general name' ),
        'singular_name'     => _x( 'Marque', 'taxonomy singular name' ),
        'search_items'      => __( 'Search Marques' ),
        'all_items'         => __( 'All Marques' ),
        'parent_item'       => __( 'Parent Marque' ),
        'parent_item_colon' => __( 'Parent Marque:' ),
        'edit_item'         => __( 'Edit Marque' ),
        'update_item'       => __( 'Update Marque' ),
        'add_new_item'      => __( 'Add New Marque' ),
        'new_item_name'     => __( 'New Marque Name' ),
        'menu_name'         => __( 'Marque' ),
    );
 
    $args = array(
        'hierarchical'      => true,
        'labels'            => $labels,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => array( 'slug' => 'marque' ),
    );
 
    register_taxonomy( 'marque', array( 'product' ), $args );
}


?>
