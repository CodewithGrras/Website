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

/**
 * Add Workshop User Role and Capabilities
 */
function add_workshop_user_role() {
    // Only run this function once
    if (get_option('workshop_roles_set') !== 'yes') {
        // Remove the role if it exists (to reset it)
        remove_role('workshop_user');
        
        // Add the custom role with basic capabilities
        add_role(
            'workshop_user',
            'Workshop User',
            array(
                'read' => true,
                'upload_files' => true,
                'edit_posts' => false,
                'edit_workshop' => true,
                'edit_workshops' => true,
                'edit_published_workshops' => true,
                'edit_others_workshops' => false,
                'delete_workshop' => true,
                'delete_workshops' => true,
                'delete_published_workshops' => true,
                'delete_others_workshops' => false,
                'publish_workshops' => false,
                'read_private_workshops' => false,
            )
        );
        
        // Define all capabilities for the workshop post type
        $workshop_caps = array(
            // Workshop singular capabilities
            'edit_workshop',
            'read_workshop',
            'delete_workshop',
            // Workshop plural capabilities
            'edit_workshops',
            'edit_others_workshops',
            'publish_workshops',
            'read_private_workshops',
            'delete_workshops',
            'delete_others_workshops',
            'delete_published_workshops',
            'delete_private_workshops',
            'edit_published_workshops',
            'edit_private_workshops',
        );
        
        // Add capabilities to existing roles
        $admin = get_role('administrator');
        $editor = get_role('editor');
        
        // Add all capabilities to admin
        if ($admin) {
            foreach ($workshop_caps as $cap) {
                $admin->add_cap($cap);
            }
        }
        
        // Add limited capabilities to editor
        if ($editor) {
            $editor->add_cap('read_workshop');
            $editor->add_cap('edit_workshop');
            $editor->add_cap('edit_workshops');
            $editor->add_cap('edit_others_workshops');
            $editor->add_cap('edit_published_workshops');
            $editor->add_cap('publish_workshops');
            $editor->add_cap('delete_workshops');
            $editor->add_cap('delete_others_workshops');
            $editor->add_cap('delete_published_workshops');
            $editor->add_cap('read_private_workshops');
        }
        
        // Set an option to prevent this from running multiple times
        update_option('workshop_roles_set', 'yes');
    }
}
add_action('init', 'add_workshop_user_role', 10);

/**
 * Restrict workshop posts to the author for workshop_user role in admin area
 */
function restrict_workshops_in_admin($query) {
    global $pagenow, $typenow;
    
    // Check if we're in the admin area and the current user is a workshop_user
    if (is_admin() && current_user_can('edit_workshops') && !current_user_can('edit_others_workshops')) {
        // Check if we're on the edit.php page and the post type is workshops
        if ('edit.php' === $pagenow && $typenow === 'workshops') {
            $query->set('author', get_current_user_id());
        }
    }
    
    return $query;
}
add_action('pre_get_posts', 'restrict_workshops_in_admin');

/**
 * Restrict workshop posts to the author for workshop_user role on frontend
 */
function restrict_workshop_posts_to_author($query) {
    // Only apply to the main query
    if (!is_admin() && $query->is_main_query()) {
        // Get current user
        $current_user = wp_get_current_user();
        
        // Check if user has workshop_user role
        if (is_user_logged_in() && in_array('workshop_user', (array) $current_user->roles)) {
            // Get the post type being queried
            $post_type = $query->get('post_type');
            
            // Check if we're querying workshops
            if ($post_type === 'workshops' || 
                (is_array($post_type) && in_array('workshops', $post_type)) ||
                (empty($post_type) && $query->is_tax('workshop_types') || $query->is_tax('courses'))) {
                
                // Restrict to current user's posts
                $query->set('author', $current_user->ID);
            }
        }
    }
    return $query;
}
add_action('pre_get_posts', 'restrict_workshop_posts_to_author');

/**
 * Block access to single workshop posts that don't belong to the current user
 */
function restrict_single_workshop_access() {
    // Only run on single workshop posts
    if (is_singular('workshops')) {
        global $post;
        
        // Check if current user is a workshop_user and not the author
        if (is_user_logged_in() && 
            in_array('workshop_user', (array) wp_get_current_user()->roles) && 
            $post->post_author != get_current_user_id()) {
            
            // Redirect to workshops archive
            wp_redirect(get_post_type_archive_link('workshops'));
            exit;
        }
    }
}
add_action('template_redirect', 'restrict_single_workshop_access');

/**
 * Set default post status for workshop users
 */
function set_workshop_default_status($post_id, $post, $update) {
    // Only run for workshops post type and non-admin users
    if ($post->post_type === 'workshops' && !current_user_can('administrator')) {
        // Get current user
        $current_user = wp_get_current_user();
        
        // Only apply to workshop_user role
        if (in_array('workshop_user', (array) $current_user->roles)) {
            // Only change from publish to draft (don't affect other statuses)
            if ($post->post_status === 'publish' && !current_user_can('publish_workshops')) {
                // Set to draft
                wp_update_post(array(
                    'ID' => $post_id,
                    'post_status' => 'draft',
                ));
            }
        }
    }
}
add_action('save_post', 'set_workshop_default_status', 10, 3);

/**
 * Add a dashboard widget for workshop users
 */
function add_workshop_dashboard_widget() {
    // Only show to workshop users
    if (current_user_can('edit_workshops') && !current_user_can('edit_others_workshops')) {
        wp_add_dashboard_widget(
            'workshop_dashboard_widget',
            'Workshop Dashboard',
            'display_workshop_dashboard_widget'
        );
    }
}
add_action('wp_dashboard_setup', 'add_workshop_dashboard_widget');

function display_workshop_dashboard_widget() {
    // Get the current user's workshops
    $current_user = wp_get_current_user();
    $args = array(
        'post_type' => 'workshops',
        'author' => $current_user->ID,
        'posts_per_page' => 5,
        'post_status' => array('draft', 'pending', 'publish')
    );
    
    $workshops = new WP_Query($args);
    
    echo '<p>Welcome to your Workshop Dashboard!</p>';
    
    if ($workshops->have_posts()) {
        echo '<h4>Your Recent Workshops:</h4>';
        echo '<ul>';
        while ($workshops->have_posts()) {
            $workshops->the_post();
            echo '<li>';
            echo '<a href="' . get_edit_post_link(get_the_ID()) . '">' . get_the_title() . '</a> - ';
            echo get_post_status();
            echo '</li>';
        }
        echo '</ul>';
        echo '<p><a href="' . admin_url('edit.php?post_type=workshops') . '" class="button">View All Your Workshops</a></p>';
    } else {
        echo '<p>You haven\'t created any workshops yet.</p>';
        echo '<p><a href="' . admin_url('post-new.php?post_type=workshops') . '" class="button">Create a Workshop</a></p>';
    }
    
    wp_reset_postdata();
}

/**
 * Modify admin menu visibility for workshop users
 */
function modify_admin_menu_for_workshop_users() {
    // Check if current user is a workshop user
    if (current_user_can('edit_workshops') && !current_user_can('edit_others_workshops')) {
        // Remove access to posts, comments, etc.
        remove_menu_page('edit.php');
        remove_menu_page('edit-comments.php');
        
        // Optionally remove other menus that workshop users shouldn't access
        remove_menu_page('tools.php');
        
        // Rename the dashboard to make it more user-friendly
        global $menu;
        foreach ($menu as $key => $item) {
            if ($item[2] === 'index.php') {
                $menu[$key][0] = 'Workshop Dashboard';
            }
        }
    }
}
add_action('admin_menu', 'modify_admin_menu_for_workshop_users');