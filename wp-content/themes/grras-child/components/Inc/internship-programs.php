<?php
/*
* Creating a function to create our CPT
*/
  
function internship_custom_post_type() {
  
    // Set UI labels for Custom Post Type
        $labels = array(
            'name'                => _x( 'internships', 'Post Type General Name', 'grras-child' ),
            'singular_name'       => _x( 'internship', 'Post Type Singular Name', 'grras-child' ),
            'menu_name'           => __( 'Internships Programs', 'grras-child' ),
            'parent_item_colon'   => __( 'Parent internship', 'grras-child' ),
            'all_items'           => __( 'All internships', 'grras-child' ),
            'view_item'           => __( 'View internship', 'grras-child' ),
            'add_new_item'        => __( 'Add New internship', 'grras-child' ),
            'add_new'             => __( 'Add New', 'grras-child' ),
            'edit_item'           => __( 'Edit internship', 'grras-child' ),
            'update_item'         => __( 'Update internship', 'grras-child' ),
            'search_items'        => __( 'Search internship', 'grras-child' ),
            'not_found'           => __( 'Not Found', 'grras-child' ),
            'not_found_in_trash'  => __( 'Not found in Trash', 'grras-child' ),
            
        );
          
    // Set other options for Custom Post Type
          
        $args = array(
            'label'               => __( 'internships', 'grras-child' ),
            'description'         => __( 'internship news and reviews', 'grras-child' ),
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
            'menu_position'       => 7,
            'can_export'          => true,
            'has_archive'         => true,
            'exclude_from_search' => false,
            'publicly_queryable'  => true,
            'capability_type'     => 'post',
            'show_in_rest' => true,
      
        );
          
        // Registering your Custom Post Type
        register_post_type( 'internships', $args );
      
    }
      
    /* Hook into the 'init' action so that the function
    * Containing our post type registration is not 
    * unnecessarily executed. 
    */
      
    add_action( 'init', 'internship_custom_post_type', 0 );
    
    function internship_themes_taxonomy() {
        register_taxonomy(
            'internship_types',  // The name of the taxonomy. Name should be in slug form (must not contain capital letters or spaces).
            'internships',             // post type name
            array(
                'hierarchical' => true,
                'label' => 'internship type', // display name
                'query_var' => true,
                'rewrite' => array(
                    'slug' => 'internship_types',    // This controls the base slug that will display before each term
                    'with_front' => false  // Don't display the category base before
                )
            )
        );
    }
    add_action( 'init', 'internship_themes_taxonomy');
    
    function internship_tags() {
        register_taxonomy(
            'internship-tags',  // The name of the taxonomy. Name should be in slug form (must not contain capital letters or spaces).
            'internships',             // post type name
            array(
                'hierarchical' => true,
                'label' => 'Internship Tags', // display name
                'query_var' => true,
                'rewrite' => array(
                    'slug' => 'internship-tags',    // This controls the base slug that will display before each term
                    'with_front' => false  // Don't display the category base before
                )
            )
        );
    }
    add_action( 'init', 'internship_tags');
    
    