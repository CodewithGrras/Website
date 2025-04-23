<?php
/**
 * Custom User Role Management with Per-User Capabilities
 * 
 * Creates a restricted_user role and allows assigning specific 
 * permissions to each user through a custom interface.
 */

// Create restricted_user role with minimal capabilities
function create_restricted_user_role() {
    // Remove role if it exists to recreate it
    remove_role('restricted_user');
    
    // Create role with just reading capability
    add_role('restricted_user', 'Restricted User', [
        'read' => true, // Basic capability to access dashboard
    ]);
}
add_action('init', 'create_restricted_user_role');

// Add admin menu for permissions management
function add_granular_permissions_page() {
    add_menu_page(
        'User Permissions', 
        'User Permissions', 
        'manage_options', 
        'granular-permissions', 
        'render_granular_permissions_page',
        'dashicons-lock',
        99
    );
}
add_action('admin_menu', 'add_granular_permissions_page');

// Allow access to specific admin pages based on permissions
function filter_admin_access_by_permissions() {
    // Only run in admin
    if (!is_admin()) {
        return;
    }
    
    global $pagenow;
    $current_user = wp_get_current_user();
    
    // Only apply to restricted users
    if (!$current_user || !in_array('restricted_user', $current_user->roles)) {
        return;
    }
    
    // Get user's custom permissions
    $user_permissions = get_user_meta($current_user->ID, 'custom_content_permissions', true);
    if (!is_array($user_permissions)) {
        $user_permissions = [];
    }

    // Specific page access control
    if ($pagenow == 'upload.php' || $pagenow == 'media-new.php') {
        // Check if user has any create or edit permissions that would require media
        $needs_media = false;
        
        if (isset($user_permissions['post_types'])) {
            foreach ($user_permissions['post_types'] as $type_perms) {
                if (isset($type_perms['create']) || isset($type_perms['edit'])) {
                    $needs_media = true;
                    break;
                }
            }
        }
        
        if (!$needs_media) {
            wp_die('You do not have permission to access media.', 'Permission Denied', ['response' => 403]);
        }
    }
    
    // User management permissions
    if ($pagenow == 'users.php' || $pagenow == 'user-new.php' || $pagenow == 'user-edit.php') {
        if (!isset($user_permissions['admin_capabilities']['manage_users'])) {
            wp_die('You do not have permission to manage users.', 'Permission Denied', ['response' => 403]);
        }
    }
}
add_action('admin_init', 'filter_admin_access_by_permissions', 5);

// Render the user-specific permissions page
function render_granular_permissions_page() {
    // Check user capabilities
    if (!current_user_can('manage_options')) {
        return;
    }

    // Process form submission
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['save_user_permissions']) && check_admin_referer('save_user_permissions_nonce')) {
        $user_id = isset($_POST['user_id']) ? intval($_POST['user_id']) : 0;
        $permissions = isset($_POST['user_permissions']) ? $_POST['user_permissions'] : [];
        
        if ($user_id > 0) {
            update_user_meta($user_id, 'custom_content_permissions', $permissions);
            echo '<div class="updated"><p>User permissions updated successfully!</p></div>';
        }
    }

    // Get all users with restricted_user role
    $restricted_users = get_users([
        'role' => 'restricted_user'
    ]);
    
    // Get all post types
    $post_types = get_post_types(['public' => true], 'objects');
    
    // Get all categories
    $categories = get_categories(['hide_empty' => false]);
    
    // Selected user
    $selected_user_id = isset($_GET['user_id']) ? intval($_GET['user_id']) : 0;
    $user_permissions = [];
    
    if ($selected_user_id > 0) {
        $user_permissions = get_user_meta($selected_user_id, 'custom_content_permissions', true);
        if (!is_array($user_permissions)) {
            $user_permissions = [];
        }
    }
    ?>
    <div class="wrap">
        <h1>Granular User Permissions</h1>
        
        <h2>Select User</h2>
        <form method="get" action="">
            <input type="hidden" name="page" value="granular-permissions">
            <select name="user_id" onchange="this.form.submit()">
                <option value="">-- Select User --</option>
                <?php foreach ($restricted_users as $user): ?>
                    <option value="<?php echo $user->ID; ?>" <?php selected($selected_user_id, $user->ID); ?>>
                        <?php echo esc_html($user->display_name); ?> (<?php echo esc_html($user->user_email); ?>)
                    </option>
                <?php endforeach; ?>
            </select>
        </form>
        
        <?php if ($selected_user_id > 0): ?>
            <h2>Set Permissions for: <?php echo get_userdata($selected_user_id)->display_name; ?></h2>
            <form method="post" action="">
                <?php wp_nonce_field('save_user_permissions_nonce'); ?>
                <input type="hidden" name="user_id" value="<?php echo $selected_user_id; ?>">
                
                <h3>Admin Capabilities</h3>
                <table class="wp-list-table widefat fixed striped">
                    <thead>
                        <tr>
                            <th>Capability</th>
                            <th>Enable</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Manage Users</td>
                            <td>
                                <input type="checkbox" name="user_permissions[admin_capabilities][manage_users]" value="1" 
                                    <?php checked(isset($user_permissions['admin_capabilities']['manage_users']), true); ?>>
                            </td>
                        </tr>
                    </tbody>
                </table>
                
                <h3>Post Type Permissions</h3>
                <table class="wp-list-table widefat fixed striped">
                    <thead>
                        <tr>
                            <th>Post Type</th>
                            <th>View</th>
                            <th>Create</th>
                            <th>Edit</th>
                            <th>Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($post_types as $post_type): ?>
                            <tr>
                                <td><?php echo $post_type->label; ?></td>
                                <td>
                                    <input type="checkbox" name="user_permissions[post_types][<?php echo $post_type->name; ?>][view]" value="1" 
                                        <?php checked(isset($user_permissions['post_types'][$post_type->name]['view']), true); ?>>
                                </td>
                                <td>
                                    <input type="checkbox" name="user_permissions[post_types][<?php echo $post_type->name; ?>][create]" value="1" 
                                        <?php checked(isset($user_permissions['post_types'][$post_type->name]['create']), true); ?>>
                                </td>
                                <td>
                                    <input type="checkbox" name="user_permissions[post_types][<?php echo $post_type->name; ?>][edit]" value="1" 
                                        <?php checked(isset($user_permissions['post_types'][$post_type->name]['edit']), true); ?>>
                                </td>
                                <td>
                                    <input type="checkbox" name="user_permissions[post_types][<?php echo $post_type->name; ?>][delete]" value="1" 
                                        <?php checked(isset($user_permissions['post_types'][$post_type->name]['delete']), true); ?>>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                
                <h3>Category Permissions</h3>
                <table class="wp-list-table widefat fixed striped">
                    <thead>
                        <tr>
                            <th>Category</th>
                            <th>View Posts</th>
                            <th>Create Posts</th>
                            <th>Edit Posts</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($categories as $category): ?>
                            <tr>
                                <td><?php echo $category->name; ?></td>
                                <td>
                                    <input type="checkbox" name="user_permissions[categories][<?php echo $category->term_id; ?>][view]" value="1" 
                                        <?php checked(isset($user_permissions['categories'][$category->term_id]['view']), true); ?>>
                                </td>
                                <td>
                                    <input type="checkbox" name="user_permissions[categories][<?php echo $category->term_id; ?>][create]" value="1" 
                                        <?php checked(isset($user_permissions['categories'][$category->term_id]['create']), true); ?>>
                                </td>
                                <td>
                                    <input type="checkbox" name="user_permissions[categories][<?php echo $category->term_id; ?>][edit]" value="1" 
                                        <?php checked(isset($user_permissions['categories'][$category->term_id]['edit']), true); ?>>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                
                <h3>Other User's Posts</h3>
                <table class="wp-list-table widefat fixed striped">
                    <thead>
                        <tr>
                            <th>Option</th>
                            <th>Enable</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Edit other user's posts</td>
                            <td>
                                <input type="checkbox" name="user_permissions[other_capabilities][edit_others_posts]" value="1" 
                                    <?php checked(isset($user_permissions['other_capabilities']['edit_others_posts']), true); ?>>
                            </td>
                        </tr>
                    </tbody>
                </table>
                
                <input type="submit" name="save_user_permissions" class="button button-primary" value="Save User Permissions">
            </form>
        <?php endif; ?>
    </div>
    <?php
}

// Allow dashboard and post type access based on user permissions
function allow_dashboard_and_post_type_access() {
    $current_user = wp_get_current_user();

    // Check if the user is a restricted user
    if (!in_array('restricted_user', $current_user->roles)) {
        return;
    }

    // Get user permissions
    $user_permissions = get_user_meta($current_user->ID, 'custom_content_permissions', true);
    if (!is_array($user_permissions)) {
        return;
    }

    // Grant access to the dashboard
    $current_user->allcaps['read'] = true;
    $current_user->caps['read'] = true; // Add to caps array

    // Post type permissions
    if (isset($user_permissions['post_types'])) {
        foreach ($user_permissions['post_types'] as $post_type => $perms) {
            $post_type_obj = get_post_type_object($post_type);
            if ($post_type_obj) {
                // Add capabilities to the user
                if (!empty($perms['view'])) {
                    $current_user->allcaps[$post_type_obj->cap->read_post] = true;
                    $current_user->caps[$post_type_obj->cap->read_post] = true; // Add to caps array
                }
                if (!empty($perms['edit'])) {
                    $current_user->allcaps[$post_type_obj->cap->edit_post] = true;
                    $current_user->allcaps[$post_type_obj->cap->edit_posts] = true;
                    $current_user->caps[$post_type_obj->cap->edit_post] = true; // Add to caps array
                    $current_user->caps[$post_type_obj->cap->edit_posts] = true; // Add to caps array

                    // Explicitly grant `edit_posts` for `post` type to access edit.php
                    if ($post_type === 'post') {
                        $current_user->allcaps['edit_posts'] = true;
                        $current_user->caps['edit_posts'] = true; // Add to caps array
                    }
                }
                if (!empty($perms['create'])) {
                    $current_user->allcaps[$post_type_obj->cap->publish_posts] = true;
                    $current_user->caps[$post_type_obj->cap->publish_posts] = true; // Add to caps array
                }
                if (!empty($perms['delete'])) {
                    $current_user->allcaps[$post_type_obj->cap->delete_post] = true;
                    $current_user->allcaps[$post_type_obj->cap->delete_posts] = true;
                    $current_user->caps[$post_type_obj->cap->delete_post] = true; // Add to caps array
                    $current_user->caps[$post_type_obj->cap->delete_posts] = true; // Add to caps array
                }
            }
        }
    }

    // Edit other's posts permission
    if (!empty($user_permissions['other_capabilities']['edit_others_posts'])) {
        foreach ($user_permissions['post_types'] as $post_type => $perms) {
            if (!empty($perms['edit'])) {
                $post_type_obj = get_post_type_object($post_type);
                if ($post_type_obj) {
                    $current_user->allcaps[$post_type_obj->cap->edit_others_posts] = true;
                    $current_user->caps[$post_type_obj->cap->edit_others_posts] = true; // Add to caps array
                }
            }
        }
    }

    // Admin capabilities
    if (isset($user_permissions['admin_capabilities'])) {
        if (!empty($user_permissions['admin_capabilities']['manage_users'])) {
            $current_user->allcaps['list_users'] = true;
            $current_user->allcaps['create_users'] = true;
            $current_user->allcaps['edit_users'] = true;
            $current_user->caps['list_users'] = true; // Add to caps array
            $current_user->caps['create_users'] = true; // Add to caps array
            $current_user->caps['edit_users'] = true; // Add to caps array
        }
    }

    // Grant access to media library if needed
    if (isset($user_permissions['post_types'])) {
        foreach ($user_permissions['post_types'] as $type_perms) {
            if (!empty($type_perms['create']) || !empty($type_perms['edit'])) {
                $current_user->allcaps['upload_files'] = true;
                $current_user->caps['upload_files'] = true; // Add to caps array
                break;
            }
        }
    }

    // Debugging: Log the user's capabilities
    // print_r($current_user->allcaps);
    // print_r($current_user->caps);
      wp_update_user($current_user);
    // error_log('User Capabilities After Refresh: ' . print_r($current_user->allcaps, true));
    // error_log('User Caps Array: ' . print_r($current_user->caps, true));
}
add_action('admin_init', 'allow_dashboard_and_post_type_access', 1);

// Modify admin menu visibility for restricted users based on permissions
function modify_admin_menu_for_restricted_users() {
    $current_user = wp_get_current_user();
// print_r($current_user->allcaps);
    // Check if the user is a restricted_user
    // Check if the user is a restricted user
    if (!in_array('restricted_user', $current_user->roles)) {
        return;
    }

    // Get user permissions
    $user_permissions = get_user_meta($current_user->ID, 'custom_content_permissions', true);
    if (!is_array($user_permissions)) {
        return;
    }

    // Grant access to the dashboard
    $current_user->allcaps['read'] = true;

    // Post type permissions
    if (isset($user_permissions['post_types'])) {
        foreach ($user_permissions['post_types'] as $post_type => $perms) {
            $post_type_obj = get_post_type_object($post_type);
            // print_r($post_type_obj);
            if ($post_type_obj) {
                // Add capabilities to the user
                if (isset($perms['view']) && $perms['view']) {
                    $current_user->allcaps[$post_type_obj->cap->read_post] = true;
                    $current_user->allcaps['read'] = true;
                }
                if (isset($perms['edit']) && $perms['edit']) {
                        //  $current_user->allcaps[] = true;
                    $current_user->allcaps[$post_type_obj->cap->edit_post] = true;
                    $current_user->allcaps[$post_type_obj->cap->edit_posts] = true;
                }
                if (isset($perms['create']) && $perms['create']) {
                    $current_user->allcaps[$post_type_obj->cap->publish_posts] = true;
                    $current_user->allcaps[$post_type_obj->cap->edit_posts] = true;
                }
                if (isset($perms['delete']) && $perms['delete']) {
                    $current_user->allcaps[$post_type_obj->cap->delete_post] = true;
                    $current_user->allcaps[$post_type_obj->cap->delete_posts] = true;
                }
            }
        }
    }

    // Edit other's posts permission
    if (isset($user_permissions['other_capabilities']['edit_others_posts'])) {
        // Apply across all permitted post types
        if (isset($user_permissions['post_types'])) {
            foreach ($user_permissions['post_types'] as $post_type => $perms) {
                if (isset($perms['edit']) && $perms['edit']) {
                    $post_type_obj = get_post_type_object($post_type);
                    if ($post_type_obj) {
                        $current_user->allcaps[$post_type_obj->cap->edit_others_posts] = true;
                    }
                }
            }
        }
    }

    // Admin capabilities
    if (isset($user_permissions['admin_capabilities'])) {
        if (isset($user_permissions['admin_capabilities']['manage_users'])) {
            $current_user->allcaps['list_users'] = true;
            $current_user->allcaps['create_users'] = true;
            $current_user->allcaps['edit_users'] = true;
        }
    }

    // Grant access to media library if needed
    if (isset($user_permissions['post_types'])) {
        foreach ($user_permissions['post_types'] as $type_perms) {
            if (isset($type_perms['create']) || isset($type_perms['edit'])) {
                $current_user->allcaps['upload_files'] = true;
                break;
            }
        }
    }
    
      // Remove unnecessary menu items
      remove_menu_page('edit-comments.php'); // Comments
      remove_menu_page('tools.php'); // Tools
      
      // Only remove users menu if not specifically allowed
      if (!isset($user_permissions['admin_capabilities']['manage_users'])) {
          remove_menu_page('users.php');
      }

      // Optionally rename the dashboard
      global $menu;
      foreach ($menu as $key => $item) {
          if ($item[2] === 'index.php') {
              $menu[$key][0] = 'Dashboard';
          }
      }
    //   print_r($current_user->allcaps);

}
add_action('admin_menu', 'modify_admin_menu_for_restricted_users', 999);

// Filter post queries to only show allowed content
function filter_posts_for_restricted_users($query) {
    if (!is_admin() && !$query->is_main_query()) {
        return;
    }
    
    $current_user = wp_get_current_user();
    if (!$current_user || !in_array('restricted_user', $current_user->roles)) {
        return;
    }
    
    $user_permissions = get_user_meta($current_user->ID, 'custom_content_permissions', true);
    if (!is_array($user_permissions)) {
        // No permissions, show nothing
        $query->set('post__in', [0]);
        return;
    }
    
    // Get allowed post types
    $allowed_post_types = [];
    if (isset($user_permissions['post_types'])) {
        foreach ($user_permissions['post_types'] as $post_type => $perms) {
            if (isset($perms['view'])) {
                $allowed_post_types[] = $post_type;
            }
        }
    }
    
    // Get allowed categories
    $allowed_categories = [];
    if (isset($user_permissions['categories'])) {
        foreach ($user_permissions['categories'] as $cat_id => $perms) {
            if (isset($perms['view'])) {
                $allowed_categories[] = $cat_id;
            }
        }
    }
    
    // Only apply filters if we have post types to show
    if (!empty($allowed_post_types)) {
        $current_post_type = $query->get('post_type');
        
        // Only apply post type filter if not already set
        if (empty($current_post_type)) {
            $query->set('post_type', $allowed_post_types);
        }
    }
    
    // Apply category filter for posts
    if (!empty($allowed_categories) && is_admin() && $query->is_main_query()) {
        $screen = get_current_screen();
        if ($screen && $screen->base === 'edit' && $screen->post_type === 'post') {
            $query->set('cat', implode(',', $allowed_categories));
        }
    }
}
add_action('pre_get_posts', 'filter_posts_for_restricted_users');

// Add per-user dashboard widget
function add_restricted_user_dashboard_widget() {
    $current_user = wp_get_current_user();
    if (in_array('restricted_user', $current_user->roles)) {
        wp_add_dashboard_widget(
            'restricted_user_permissions',
            'Your Permissions',
            'display_user_permissions_widget'
        );
    }
}
add_action('wp_dashboard_setup', 'add_restricted_user_dashboard_widget');

function display_user_permissions_widget() {
    $current_user = wp_get_current_user();
    $user_permissions = get_user_meta($current_user->ID, 'custom_content_permissions', true);
    
    if (!is_array($user_permissions)) {
        echo '<p>You have no specific permissions assigned yet.</p>';
        return;
    }
    
    echo '<h4>Your Assigned Permissions:</h4>';
    
    // Post Types
    if (isset($user_permissions['post_types']) && !empty($user_permissions['post_types'])) {
        echo '<h5>Content Types:</h5>';
        echo '<ul>';
        foreach ($user_permissions['post_types'] as $post_type => $perms) {
            $post_type_obj = get_post_type_object($post_type);
            if ($post_type_obj) {
                $capabilities = [];
                if (isset($perms['view'])) $capabilities[] = 'view';
                if (isset($perms['create'])) $capabilities[] = 'create';
                if (isset($perms['edit'])) $capabilities[] = 'edit';
                if (isset($perms['delete'])) $capabilities[] = 'delete';
                
                if (!empty($capabilities)) {
                    echo '<li><strong>' . $post_type_obj->labels->name . '</strong>: ' . 
                         ucwords(implode(', ', $capabilities)) . '</li>';
                }
            }
        }
        echo '</ul>';
    }
    
    // Categories
    if (isset($user_permissions['categories']) && !empty($user_permissions['categories'])) {
        echo '<h5>Categories:</h5>';
        echo '<ul>';
        foreach ($user_permissions['categories'] as $cat_id => $perms) {
            $category = get_category($cat_id);
            if ($category) {
                $capabilities = [];
                if (isset($perms['view'])) $capabilities[] = 'view';
                if (isset($perms['create'])) $capabilities[] = 'create';
                if (isset($perms['edit'])) $capabilities[] = 'edit';
                
                if (!empty($capabilities)) {
                    echo '<li><strong>' . $category->name . '</strong>: ' . 
                         ucwords(implode(', ', $capabilities)) . '</li>';
                }
            }
        }
        echo '</ul>';
    }
    
    // Admin capabilities
    if (isset($user_permissions['admin_capabilities'])) {
        echo '<h5>Admin Capabilities:</h5>';
        echo '<ul>';
        if (isset($user_permissions['admin_capabilities']['manage_users'])) {
            echo '<li>Manage Users</li>';
        }
        echo '</ul>';
    }
    
    // Other capabilities
    if (isset($user_permissions['other_capabilities'])) {
        echo '<h5>Other Capabilities:</h5>';
        echo '<ul>';
        if (isset($user_permissions['other_capabilities']['edit_others_posts'])) {
            echo '<li>Edit Other User\'s Posts</li>';
        }
        echo '</ul>';
    }
}