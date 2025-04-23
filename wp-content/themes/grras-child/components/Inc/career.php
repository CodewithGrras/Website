<?php 
function create_career_post_type() {
    // Arguments for the Career custom post type
    $args = array(
        'labels' => array(
            'name'                  => 'Careers', // Plural form for admin menu
            'singular_name'         => 'Career',  // Singular form for admin menu
            'menu_name'             => 'Careers', // Admin menu name
            'name_admin_bar'        => 'Career',
            'add_new'               => 'Add New',
            'add_new_item'          => 'Add New Career',
            'new_item'              => 'New Career',
            'edit_item'             => 'Edit Career',
            'view_item'             => 'View Career',
            'all_items'             => 'All Careers',
            'search_items'          => 'Search Careers',
            'parent_item_colon'     => 'Parent Careers:',
            'not_found'             => 'No careers found.',
            'not_found_in_trash'    => 'No careers found in Trash.',
            'featured_image'        => 'Career Image',
            'set_featured_image'    => 'Set career image',
            'remove_featured_image' => 'Remove career image',
            'use_featured_image'    => 'Use as career image',
            'archives'              => 'Career Archives',
            'insert_into_item'      => 'Insert into career',
            'uploaded_to_this_item' => 'Uploaded to this career',
            'filter_items_list'     => 'Filter careers list',
            'items_list_navigation' => 'Careers list navigation',
            'items_list'            => 'Careers list',
        ),
        'public'              => true, // Make the CPT publicly accessible
        'show_ui'             => true, // Enable the admin UI for the CPT
        'show_in_menu'        => true, // Show the CPT in the admin menu
        'menu_position'       => 5, // Position of the menu in the sidebar
        'show_in_rest'        => true, // Enable Gutenberg (Block Editor) support
        'supports'            => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'custom-fields' ),
        'taxonomies'          => array( 'category', 'post_tag' ), // Optionally enable categories/tags for the CPT
        'has_archive'         => true, // Enable an archive page
        'rewrite'             => array( 'slug' => 'career' ), // URL slug
        'hierarchical'        => false, // Make it non-hierarchical like posts
        'show_in_rest'        => true, // This allows Gutenberg block editor to be used
    );

    // Register the "Career" custom post type
    register_post_type( 'career', $args );
}
add_action( 'init', 'create_career_post_type' );
