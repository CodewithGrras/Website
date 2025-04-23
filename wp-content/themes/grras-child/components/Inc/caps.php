<?php

/**
 * Restrict posts in admin dashboard based on user role and creation relationship
 * 
 * For branch_admin users: Show posts from all users they created
 * For self_post_can_seen users: Show only their own posts
 */
 function getBranchAdminUser(){
     $current_user_id = get_current_user_id();
        
        // Get all users created by this branch admin
        $created_users = get_users(array(
            'meta_key' => 'created_by',
            'meta_value' => $current_user_id,
            'fields' => 'ID'
        ));
        return $created_users;
 }
function restrict_posts_by_sub_admin($query) {
    global $pagenow;
    
    // Only apply on admin post listings
    if (!is_admin() || $pagenow !== 'edit.php' || !$query->is_main_query()) {
        return $query;
    }
    
    // For users who can only see their own posts
    if (current_user_can('self_post_can_seen')) {
        $query->set('author', get_current_user_id());
        return $query;
    }
    
    // For branch admins
    if (current_user_can('branch_admin')) {
        
        $created_users = getBranchAdminUser();
        // If branch admin has created users, show their posts and the admin's own posts
        if (!empty($created_users)) {
            // Add the branch admin's ID to the list
            $created_users[] = $current_user_id;
            
            // Set the query to include posts from all these users
            $query->set('author__in', $created_users);
        } else {
            // If no users created yet, only show branch admin's own posts
            $query->set('author', $current_user_id);
        }
    }
    
    return $query;
}
add_filter('pre_get_posts', 'restrict_posts_by_sub_admin');
/**
 * Allow branch admins to edit and publish posts created by users they've created
 * This function modifies the WordPress capability checks for post editing
 */
 /*
function branch_admin_edit_permissions($allcaps, $caps, $args, $user) {
    // Only proceed if we're checking edit_post, edit_others_posts, or publish_posts capabilities
    if (!isset($args[0]) || !in_array($args[0], array('edit_post', 'edit_others_posts', 'publish_posts'))) {
        return $allcaps;
    }
    
    // Only proceed for branch admins
    if (empty($allcaps['branch_admin'])) {
        return $allcaps;
    }
    
    // Get the current user ID (the branch admin)
    $branch_admin_id = $user->ID;
    
    // For edit_post capability, we need to check the specific post's author
    if ($args[0] === 'edit_post' && isset($args[2])) {
        $post_id = $args[2];
        $post = get_post($post_id);
        
        if (!$post) {
            return $allcaps;
        }
        
        $post_author_id = $post->post_author;
        
        // Check if this post author was created by this branch admin
        $author_creator = get_user_meta($post_author_id, 'created_by', true);
        
        if (absint($author_creator) === $branch_admin_id) {
            // Grant the capability to edit this specific post
            $allcaps['edit_others_posts'] = true;
            
            // Also allow publishing/updating the post
            $allcaps['publish_posts'] = true;
            
            // Handle other post type specific capabilities
            $post_type = get_post_type($post_id);
            if ($post_type) {
                $allcaps["edit_others_{$post_type}s"] = true;
                $allcaps["publish_{$post_type}s"] = true;
            }
        }
    }
    
    // For general edit_others_posts and publish_posts capabilities
    // These are needed for the UI to properly show edit options
    if ($args[0] === 'edit_others_posts' || $args[0] === 'publish_posts') {
        // We'll grant these conditionally, but WordPress will still check specific posts
        // with the edit_post capability which we've handled above
        $allcaps[$args[0]] = true;
    }
    
    return $allcaps;
}
add_filter('user_has_cap', 'branch_admin_edit_permissions', 10, 4);
*/
/**
 * Modify the post row actions to ensure branch admins see edit/trash links
 * for posts created by their users
 */
function branch_admin_modify_row_actions($actions, $post) {
    // Only proceed for branch admins
    if (!current_user_can('branch_admin')) {
        return $actions;
    }
    
    // Get the current user ID (the branch admin)
    $branch_admin_id = get_current_user_id();
    
    // Get the post author
    $post_author_id = $post->post_author;
    
    // Check if this post author was created by this branch admin
    $author_creator = get_user_meta($post_author_id, 'created_by', true);
    
    if (absint($author_creator) === $branch_admin_id) {
        // Ensure edit link is available
        if (!isset($actions['edit'])) {
            $actions['edit'] = sprintf(
                '<a href="%s">%s</a>',
                get_edit_post_link($post->ID),
                __('Edit')
            );
        }
        
        // Ensure other actions are available as needed
        // You can add additional actions here
    }
    
    return $actions;
}
add_filter('post_row_actions', 'branch_admin_modify_row_actions', 10, 2);
add_filter('page_row_actions', 'branch_admin_modify_row_actions', 10, 2);
/**
 * Set default post status for workshop users
 */
function set_posts_default_status($post_id, $post, $update) {
    // Only run for workshops post type and non-admin users
    if ($post->post_type === 'workshops' && !current_user_can('administrator')) {
        // Get current user
        $current_user = wp_get_current_user();

        if (current_user_can('publishe_posts_for_admin_review')) {
            // Only change from publish to draft (don't affect other statuses)
            if ($post->post_status === 'publish' && !current_user_can('publish_post')) {
                // Set to draft
                wp_update_post(array(
                    'ID' => $post_id,
                    'post_status' => 'draft',
                ));
            }
        }
    }
}
add_action('save_post', 'set_posts_default_status', 10, 3);
// assing self user
function track_user_creation($user_id) {
    // Check if the current user has the 'assign_user' capability
    if (current_user_can('branch_admin')) {
        // Get the ID of the current user (the one creating the new user)
        $creator_id = get_current_user_id();

        // Store the creator's ID as user meta for the newly created user
        update_user_meta($user_id, 'created_by', $creator_id);
    }
}
add_action('user_register', 'track_user_creation');

function filter_user_listing_based_on_creator($query) {
    // Only apply this filter in the WordPress admin area for the user listing page
    if (is_admin()) {

        if (current_user_can('branch_admin')) {

            // Get the ID of the current user (the one doing the filtering)
            $creator_id = get_current_user_id();

            // Modify the user query to only show users created by the current user
            $query->set('meta_key', 'created_by');  // Meta key where creator ID is stored
            $query->set('meta_value', $creator_id);  // Only show users created by the current user
        }
    }
 
}
add_action('pre_get_users', 'filter_user_listing_based_on_creator');


function restrict_user_editing($allcaps, $cap, $args, $user) {
    // Check if the user has the 'edit_user' capability
    if (in_array('edit_user', $cap)) {
      if (current_user_can('branch_admin')) {
        $user_id = $args[0];  // The user ID being edited

        // Check if the current user is trying to edit their own created user
        $creator_id = get_user_meta($user_id, 'created_by', true);

        if ($creator_id && $creator_id != $user->ID) {
            // If the current user is not the creator, they cannot edit
            $allcaps['edit_user'] = false;
        }
    }
      }

    return $allcaps;
}
add_filter('user_has_cap', 'restrict_user_editing', 10, 4);

/**
function show_debug_message_on_dashboard() {
    // Check if the current user has the 'self_post_can_seen' capability
    if ( current_user_can( 'self_post_can_seen' ) ) {
        // Display a debug message in the WordPress dashboard
        ?>
        <div class="notice notice-success is-dismissible">
            <p><strong>Debug Info:</strong> You have the 'self_post_can_seen' capability. This is for debugging purposes.</p>
        </div>
        <?php
    }else{
        ?>
        <div class="notice notice-error is-dismissible">
            <p><strong>Debug Info:</strong> You dont have the 'self_post_can_seen' capability. This is for debugging purposes.</p>
        </div>
        
        <?php
    }
}
add_action( 'admin_notices', 'show_debug_message_on_dashboard' );
*/