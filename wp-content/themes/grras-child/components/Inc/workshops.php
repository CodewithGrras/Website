<?php
/**
 * Create Workshop Custom Post Type and Related Functionality
 */

// Create Workshop Custom Post Type
function workshop_custom_post_type() {
    // Set UI labels for Custom Post Type
    $labels = array(
        'name'                => _x('Workshops', 'Post Type General Name', 'grras-child'),
        'singular_name'       => _x('Workshop', 'Post Type Singular Name', 'grras-child'),
        'menu_name'           => __('Workshops', 'grras-child'),
        'parent_item_colon'   => __('Parent Workshop', 'grras-child'),
        'all_items'           => __('All Workshops', 'grras-child'),
        'view_item'           => __('View Workshop', 'grras-child'),
        'add_new_item'        => __('Add New Workshop', 'grras-child'),
        'add_new'             => __('Add New', 'grras-child'),
        'edit_item'           => __('Edit Workshop', 'grras-child'),
        'update_item'         => __('Update Workshop', 'grras-child'),
        'search_items'        => __('Search Workshop', 'grras-child'),
        'not_found'           => __('Not Found', 'grras-child'),
        'not_found_in_trash'  => __('Not found in Trash', 'grras-child'),
    );
    
    // Set other options for Custom Post Type
    $args = array(
        'label'               => __('workshops', 'grras-child'),
        'description'         => __('Workshop news and reviews', 'grras-child'),
        'labels'              => $labels,
        'supports'            => array('title', 'editor', 'excerpt', 'author', 'thumbnail', 'comments', 'revisions', 'custom-fields', 'tags'),
        'taxonomies'          => array('workshop_types', 'courses'),
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
        'capability_type'     => 'workshop', // Changed from 'post' to 'workshop'
        'map_meta_cap'        => true, // Important for custom capabilities
        'show_in_rest'        => true,
    );
    
    // Registering your Custom Post Type
    register_post_type('workshops', $args);

    // Register Courses Taxonomy
    $taxonomy_labels = array(
        'name'              => _x('Courses', 'taxonomy general name', 'grras-child'),
        'singular_name'     => _x('Course', 'taxonomy singular name', 'grras-child'),
        'search_items'      => __('Search Courses', 'grras-child'),
        'all_items'         => __('All Courses', 'grras-child'),
        'parent_item'       => __('Parent Course', 'grras-child'),
        'parent_item_colon' => __('Parent Course:', 'grras-child'),
        'edit_item'         => __('Edit Course', 'grras-child'),
        'update_item'       => __('Update Course', 'grras-child'),
        'add_new_item'      => __('Add New Course', 'grras-child'),
        'new_item_name'     => __('New Course Name', 'grras-child'),
        'menu_name'         => __('Courses', 'grras-child'),
    );

    $taxonomy_args = array(
        'hierarchical'      => true,
        'labels'            => $taxonomy_labels,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => array('slug' => 'course'),
        'show_in_rest'      => true,
    );

    register_taxonomy('courses', array('workshops'), $taxonomy_args);
}
// Hook into the 'init' action
add_action('init', 'workshop_custom_post_type', 0);

// Register Workshop Types Taxonomy
function workshop_themes_taxonomy() {
    register_taxonomy(
        'workshop_types',
        'workshops',
        array(
            'hierarchical' => true,
            'label' => 'Workshop Types',
            'query_var' => true,
            'rewrite' => array(
                'slug' => 'workshop_types',
                'with_front' => false
            ),
            'show_in_rest' => true
        )
    );
}
add_action('init', 'workshop_themes_taxonomy', 0);

