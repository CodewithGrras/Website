<?php
/*
* Creating a function to create our CPT
*/
  
function placement_custom_post_type() {
  
// Set UI labels for Custom Post Type
    $labels = array(
        'name'                => _x( 'Placements', 'Post Type General Name', 'grras-child' ),
        'singular_name'       => _x( 'Placement', 'Post Type Singular Name', 'grras-child' ),
        'menu_name'           => __( 'Placements', 'grras-child' ),
        'parent_item_colon'   => __( 'Parent Placement', 'grras-child' ),
        'all_items'           => __( 'All Placements', 'grras-child' ),
        'view_item'           => __( 'View Placement', 'grras-child' ),
        'add_new_item'        => __( 'Add New Placement', 'grras-child' ),
        'add_new'             => __( 'Add New', 'grras-child' ),
        'edit_item'           => __( 'Edit Placement', 'grras-child' ),
        'update_item'         => __( 'Update Placement', 'grras-child' ),
        'search_items'        => __( 'Search Placement', 'grras-child' ),
        'not_found'           => __( 'Not Found', 'grras-child' ),
        'not_found_in_trash'  => __( 'Not found in Trash', 'grras-child' ),
    );
      
// Set other options for Custom Post Type
      
    $args = array(
        'label'               => __( 'placements', 'grras-child' ),
        'description'         => __( 'Placement news and reviews', 'grras-child' ),
        'labels'              => $labels,
        // Features this CPT supports in Post Editor
        'supports'            => array( 'title', 'editor', 'excerpt', 'author', 'thumbnail', 'comments', 'revisions', 'custom-fields', ),
        // You can associate this CPT with a taxonomy or custom taxonomy. 
        'taxonomies'          => array( 'course_types' ),
        /* A hierarchical CPT is like Pages and can have
        * Parent and child items. A non-hierarchical CPT
        * is like Posts.
        */
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
        'capability_type'     => 'post',
        'show_in_rest' => true,
  
    );
      
    // Registering your Custom Post Type
    register_post_type( 'placements', $args );
  
}
  
/* Hook into the 'init' action so that the function
* Containing our post type registration is not 
* unnecessarily executed. 
*/
  
add_action( 'init', 'placement_custom_post_type', 0 );

function placement_themes_taxonomy() {
    register_taxonomy(
        'placement_types',  // The name of the taxonomy. Name should be in slug form (must not contain capital letters or spaces).
        'placements',             // post type name
        array(
            'hierarchical' => true,
            'label' => 'Placement type', // display name
            'query_var' => true,
            'rewrite' => array(
                'slug' => 'placement_types',    // This controls the base slug that will display before each term
                'with_front' => false  // Don't display the category base before
            )
        )
    );
    register_taxonomy(
        'placement_category',  // The name of the taxonomy. Name should be in slug form (must not contain capital letters or spaces).
        'placements',             // post type name
        array(
            'hierarchical' => true,
            'label' => 'Placement Category', // display name
            'query_var' => true,
            'rewrite' => array(
                'slug' => 'placement_categories',    // This controls the base slug that will display before each term
                'with_front' => false  // Don't display the category base before
            )
        )
    );
}
add_action( 'init', 'placement_themes_taxonomy');