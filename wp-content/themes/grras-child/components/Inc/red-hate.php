<?php
function create_redhat_courses_post_type() {
    $labels = array(
        'name'               => 'Red Hat Courses',
        'singular_name'      => 'Red Hat Course',
        'menu_name'          => 'Red Hat Courses',
        'name_admin_bar'     => 'Red Hat Course',
        'add_new'            => 'Add New',
        'add_new_item'       => 'Add New Course',
        'new_item'           => 'New Course',
        'edit_item'          => 'Edit Course',
        'view_item'          => 'View Course',
        'all_items'          => 'All Courses',
        'search_items'       => 'Search Courses',
        'not_found'          => 'No courses found.',
        'not_found_in_trash' => 'No courses found in Trash.',
    );

    $args = array(
        'labels'             => $labels,
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'rewrite'            => array('slug' => 'redhat-courses'),
        'capability_type'    => 'post',
        'has_archive'        => true,
        'hierarchical'       => false,
        'menu_position'      => 5,
        'supports'           => array('title', 'editor', 'thumbnail', 'excerpt', 'custom-fields'),
    );

    register_post_type('redhat_courses', $args);

    // Register Custom Taxonomies
    // Types of Offerings
    register_taxonomy('types_of_offerings', 'redhat_courses', array(
        'label' => 'Types of Offerings',
        'hierarchical' => true,
        'show_ui' => true,
        'show_admin_column' => true,
        'query_var' => true,
        'rewrite' => array('slug' => 'types-of-offerings'),
    ));

    // Certification Path
    register_taxonomy('certification_path', 'redhat_courses', array(
        'label' => 'Certification Path',
        'hierarchical' => true,
        'show_ui' => true,
        'show_admin_column' => true,
        'query_var' => true,
        'rewrite' => array('slug' => 'certification-path'),
    ));

    // Product Lines
    register_taxonomy('product_lines', 'redhat_courses', array(
        'label' => 'Product Lines',
        'hierarchical' => true,
        'show_ui' => true,
        'show_admin_column' => true,
        'query_var' => true,
        'rewrite' => array('slug' => 'product-lines'),
    ));

    // Products
    register_taxonomy('products', 'redhat_courses', array(
        'label' => 'Products',
        'hierarchical' => true,
        'show_ui' => true,
        'show_admin_column' => true,
        'query_var' => true,
        'rewrite' => array('slug' => 'products'),
    ));
    register_taxonomy('skills', 'redhat_courses', array(
        'label' => 'Skills',
        'hierarchical' => true,
        'show_ui' => true,
        'show_admin_column' => true,
        'query_var' => true,
        'rewrite' => array('slug' => 'skills'),
    ));
    register_taxonomy('red_hat_category', 'redhat_courses', array(
        'label' => 'Category',
        'hierarchical' => true,
        'show_ui' => true,
        'show_admin_column' => true,
        'query_var' => true,
        'rewrite' => array('slug' => 'skills'),
    ));

    // Category (default WordPress category)

}

add_action('init', 'create_redhat_courses_post_type');
