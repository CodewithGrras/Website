<?php
/*
* Creating a function to create our CPT
*/
  
function career_success_story_custom_post_type() {
  
    // Set UI labels for Custom Post Type
    $labels = array(
        'name'                => _x( 'Career Success Stories', 'Post Type General Name', 'grras-child' ),
        'singular_name'       => _x( 'Career Success Story', 'Post Type Singular Name', 'grras-child' ),
        'menu_name'           => __( 'Career Success Stories', 'grras-child' ),
        'parent_item_colon'   => __( 'Parent Career Success Story', 'grras-child' ),
        'all_items'           => __( 'All Career Success Stories', 'grras-child' ),
        'view_item'           => __( 'View Career Success Story', 'grras-child' ),
        'add_new_item'        => __( 'Add New Career Success Story', 'grras-child' ),
        'add_new'             => __( 'Add New', 'grras-child' ),
        'edit_item'           => __( 'Edit Career Success Story', 'grras-child' ),
        'update_item'         => __( 'Update Career Success Story', 'grras-child' ),
        'search_items'        => __( 'Search Career Success Story', 'grras-child' ),
        'not_found'           => __( 'Not Found', 'grras-child' ),
        'not_found_in_trash'  => __( 'Not found in Trash', 'grras-child' ),
    );
      
    // Set other options for Custom Post Type
    $args = array(
        'label'               => __( 'Career Success Stories', 'grras-child' ),
        'description'         => __( 'Career Success Story news and reviews', 'grras-child' ),
        'labels'              => $labels,
        'supports'            => array( 'title', 'editor', 'excerpt', 'author', 'thumbnail', 'comments', 'revisions', 'custom-fields', ),
        'taxonomies'          => array( 'story_types', 'story_categories' ), // Add new taxonomy here
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
        'show_in_rest'        => true,
    );
      
    // Registering your Custom Post Type
    register_post_type( 'career_success_story', $args );
}
  
add_action( 'init', 'career_success_story_custom_post_type', 0 );

function career_success_story_themes_taxonomy() {
    register_taxonomy(
        'story_types',  // Existing taxonomy
        'career_success_story',             
        array(
            'hierarchical' => true,
            'label' => 'Story Type', // display name
            'query_var' => true,
            'rewrite' => array(
                'slug' => 'story_types',
                'with_front' => false
            )
        )
    );

    // Register the new taxonomy
    register_taxonomy(
        'story_categories',  // New taxonomy name
        'career_success_story',             
        array(
            'hierarchical' => true,
            'label' => 'Story Categories', // display name
            'query_var' => true,
            'rewrite' => array(
                'slug' => 'story_categories', // New base slug
                'with_front' => false
            )
        )
    );
}
add_action( 'init', 'career_success_story_themes_taxonomy');
