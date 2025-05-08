<?php 
/**
 * User Attendance Tracker
 * Add this code to your theme's functions.php file
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}
/**
 * Get active session for a user
 */
function handle_get_active_session() {
    // Check nonce
    check_ajax_referer('attendance_nonce', 'nonce');
    
    // Check capabilities
    if (!current_user_can('attendence_access')) {
        wp_send_json_error('Permission denied');
        return;
    }
    
    // Validate input
    $user_id = isset($_POST['user_id']) ? intval($_POST['user_id']) : 0;
    
    if (empty($user_id)) {
        wp_send_json_error('Missing user ID');
        return;
    }
    
    // Get active session
    global $wpdb;
    $table_name = $wpdb->prefix . 'user_attendance';
    
    $record = $wpdb->get_row(
        $wpdb->prepare(
            "SELECT * FROM $table_name 
            WHERE user_id = %d AND punch_out IS NULL 
            ORDER BY punch_in DESC 
            LIMIT 1",
            $user_id
        )
    );
    
    if (!$record) {
        wp_send_json_error('No active session found');
        return;
    }
    
    wp_send_json_success($record);
}
add_action('wp_ajax_get_active_session', 'handle_get_active_session');

/**
 * Save complete record AJAX request
 */
function handle_save_complete_record() {
    // Check nonce
    check_ajax_referer('attendance_nonce', 'nonce');
    
    // Check capabilities
    if (!current_user_can('attendence_access')) {
        wp_send_json_error('Permission denied');
        return;
    }
    
    // Validate input
    $record_id = isset($_POST['record_id']) ? intval($_POST['record_id']) : 0;
    $user_id = isset($_POST['user_id']) ? intval($_POST['user_id']) : 0;
    $punch_in = isset($_POST['punch_in']) ? sanitize_text_field($_POST['punch_in']) : '';
    $punch_out = isset($_POST['punch_out']) ? sanitize_text_field($_POST['punch_out']) : null;
    $notes = isset($_POST['notes']) ? sanitize_textarea_field($_POST['notes']) : '';
    
    if (empty($user_id) || empty($punch_in)) {
        wp_send_json_error('Missing required fields');
        return;
    }
    
    // Check if user exists
    if (!get_user_by('id', $user_id)) {
        wp_send_json_error('User not found');
        return;
    }
    
    global $wpdb;
    $table_name = $wpdb->prefix . 'user_attendance';
    
    // If record_id is provided, update existing record
    if ($record_id > 0) {
        $data = array(
            'user_id' => $user_id,
            'punch_in' => $punch_in,
            'notes' => $notes
        );
        
        $format = array('%d', '%s', '%s');
        
        if (!empty($punch_out)) {
            $data['punch_out'] = $punch_out;
            $format[] = '%s';
        } else {
            $data['punch_out'] = null;
            $format[] = null;
        }
        
        $result = $wpdb->update(
            $table_name,
            $data,
            array('id' => $record_id),
            $format,
            array('%d')
        );
        
        if ($result === false) {
            wp_send_json_error('Database error during update');
            return;
        }
        
        wp_send_json_success(array(
            'message' => 'Record updated successfully'
        ));
    } else {
        // Insert new record
        $data = array(
            'user_id' => $user_id,
            'punch_in' => $punch_in,
            'notes' => $notes
        );
        
        $format = array('%d', '%s', '%s');
        
        if (!empty($punch_out)) {
            $data['punch_out'] = $punch_out;
            $format[] = '%s';
        }
        
        $result = $wpdb->insert(
            $table_name,
            $data,
            $format
        );
        
        if ($result === false) {
            wp_send_json_error('Database error during insert');
            return;
        }
        
        wp_send_json_success(array(
            'id' => $wpdb->insert_id,
            'message' => 'Record saved successfully'
        ));
    }
}
add_action('wp_ajax_save_complete_record', 'handle_save_complete_record');

/**
 * Get record details AJAX request
 */
function handle_get_record() {
    // Check nonce
    check_ajax_referer('attendance_nonce', 'nonce');
    
    // Check capabilities
    if (!current_user_can('attendence_access')) {
        wp_send_json_error('Permission denied');
        return;
    }
    
    // Validate input
    $record_id = isset($_POST['record_id']) ? intval($_POST['record_id']) : 0;
    
    if (empty($record_id)) {
        wp_send_json_error('Missing record ID');
        return;
    }
    
    // Get record
    global $wpdb;
    $table_name = $wpdb->prefix . 'user_attendance';
    
    $record = $wpdb->get_row(
        $wpdb->prepare(
            "SELECT * FROM $table_name WHERE id = %d",
            $record_id
        )
    );
    
    if (!$record) {
        wp_send_json_error('Record not found');
        return;
    }
    
    wp_send_json_success($record);
}
add_action('wp_ajax_get_record', 'handle_get_record');

/**
 * Delete record AJAX request
 */
function handle_delete_record() {
    // Check nonce
    check_ajax_referer('attendance_nonce', 'nonce');
    
    // Check capabilities
    if (!current_user_can('attendence_access')) {
        wp_send_json_error('Permission denied');
        return;
    }
    
    // Validate input
    $record_id = isset($_POST['record_id']) ? intval($_POST['record_id']) : 0;
    
    if (empty($record_id)) {
        wp_send_json_error('Missing record ID');
        return;
    }
    
    // Delete record
    global $wpdb;
    $table_name = $wpdb->prefix . 'user_attendance';
    
    $result = $wpdb->delete(
        $table_name,
        array('id' => $record_id),
        array('%d')
    );
    
    if ($result === false) {
        wp_send_json_error('Database error');
        return;
    }
    
    wp_send_json_success(array(
        'message' => 'Record deleted successfully'
    ));
}
add_action('wp_ajax_delete_record', 'handle_delete_record');

// Create CSS and JS files when the theme is activated
add_action('after_switch_theme', function() {
    create_attendance_admin_css();
    create_attendance_admin_js();
});

/**
 * Create the attendance database table
 */
// function create_attendance_table() {
//     global $wpdb;

//     $table_name = $wpdb->prefix . 'user_attendance';
//     $charset_collate = $wpdb->get_charset_collate();

//     // Check if table exists first (optional)
//     if ($wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name) {
//         require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

//         $sql = "CREATE TABLE `$table_name` (
//             `id` mediumint(9) NOT NULL AUTO_INCREMENT,
//             `user_id` bigint(20) NOT NULL,
//             `punch_in` datetime NOT NULL,
//             `punch_out` datetime DEFAULT NULL,
//             `notes` text DEFAULT NULL,
//             `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
//             PRIMARY KEY (`id`)
//         ) $charset_collate;";

//         dbDelta($sql);
//     }
// }

// // Run when the theme is switched (or use plugin activation hook if in plugin)
// add_action('after_switch_theme', 'create_attendance_table');


/**
 * Register admin menu pages
 */
function register_attendance_admin_menu() {
    // Only allow administrators to access
    if (!current_user_can('attendence_access')) {
        return;
    }

    add_menu_page(
        'User Attendance',
        'Attendance',
        'attendence_access',
        'user-attendance',
        'render_attendance_page',
        'dashicons-clock',
        30
    );
    
    add_submenu_page(
        'user-attendance',
        'Attendance Records',
        'Records',
        'attendence_access',
        'user-attendance',
        'render_attendance_page'
    );
    
    add_submenu_page(
        'user-attendance',
        'Import/Export',
        'Import/Export',
        'attendence_access',
        'attendance-import-export',
        'render_import_export_page_attendence'
    );
}
add_action('admin_menu', 'register_attendance_admin_menu');

/**
 * Enqueue scripts and styles
 */
function enqueue_attendance_scripts($hook) {
    // Only load on our plugin pages
    if (!in_array($hook, array('toplevel_page_user-attendance', 'attendance_page_attendance-import-export'))) {
        return;
    }
    
    wp_enqueue_style('attendance-admin-css', get_stylesheet_directory_uri() . '/css/attendance.css', array(), '1.0.0');
    wp_enqueue_script('attendance-admin-js', get_stylesheet_directory_uri() . '/js/attendance.js', array('jquery'), '1.0.0', true);
    
    wp_localize_script('attendance-admin-js', 'attendanceData', array(
        'ajax_url' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('attendance_nonce')
    ));
}
add_action('admin_enqueue_scripts', 'enqueue_attendance_scripts');

/**
 * Render the main attendance page
 */
function render_attendance_page() {
    // Check user capabilities
    if (!current_user_can('attendence_access')) {
        return;
    }
     $current_user = wp_get_current_user();
$user = [];
    if (in_array('administrator', $current_user->roles)) {
        // Admins see all entries
        $users = get_users(array(
        'fields' => array('ID', 'display_name'),
    ));
    } else {
 $user_ids = getBranchAdminUser();

// Prevent empty IN clause
if (empty($user_ids)) {
    $user_ids = array(0); // ensures no matches
}

$current_user = wp_get_current_user();

// Get users created by branch admins
$users = get_users(array(
    'meta_query' => array(
        array(
            'key'     => 'created_by',
            'value'   => $user_ids,
            'compare' => 'IN',
        ),
    ),
    'fields' => array('ID', 'display_name'),
));

// Create a stdClass object for the current user
$current_user_obj = new stdClass();
$current_user_obj->ID = $current_user->ID;
$current_user_obj->display_name = $current_user->display_name;

// Append the current user object to the array
$users[] = $current_user_obj;

// Print the result
// print_r($users);

    }

    global $wpdb;
$table_name = $wpdb->prefix . 'user_attendance';

// Pagination
$per_page = 20;
$current_page = isset($_GET['paged']) ? max(1, intval($_GET['paged'])) : 1;
$offset = ($current_page - 1) * $per_page;

// Filter parameters
$where = '1=1';
$user_filter = isset($_GET['user_id']) && !empty($_GET['user_id']) ? intval($_GET['user_id']) : 0;
$date_from = isset($_GET['date_from']) && !empty($_GET['date_from']) ? sanitize_text_field($_GET['date_from']) : '';
$date_to = isset($_GET['date_to']) && !empty($_GET['date_to']) ? sanitize_text_field($_GET['date_to']) : '';

// Apply filters
if ($user_filter > 0) {
    $where .= $wpdb->prepare(" AND a.user_id = %d", $user_filter);
}
if (!empty($date_from)) {
    $where .= $wpdb->prepare(" AND DATE(a.punch_in) >= %s", $date_from);
}
if (!empty($date_to)) {
    $where .= $wpdb->prepare(" AND DATE(a.punch_in) <= %s", $date_to);
}

// Get current user and check role
$current_user = wp_get_current_user();
$is_admin = in_array('administrator', $current_user->roles);

// Role-based data access
if (!$is_admin) {
    $current_user_id = $current_user->ID;

    // Get branch admin users related to this user
    $branch_admins = getBranchAdminUser(); // You defined this elsewhere

    if (empty($branch_admins)) {
        $branch_admins = array(0); // ensures no matches
    }

    // Get users created by branch admins
    $created_users = get_users(array(
        'meta_query' => array(
            array(
                'key'     => 'created_by',
                'value'   => $branch_admins,
                'compare' => 'IN',
            ),
        ),
        'fields' => array('ID'),
    ));

    $allowed_user_ids = wp_list_pluck($created_users, 'ID');
    $allowed_user_ids[] = $current_user_id; // Include self

    // Sanitize for SQL IN clause
    $placeholders = implode(',', array_fill(0, count($allowed_user_ids), '%d'));
    $where .= $wpdb->prepare(" AND a.user_id IN ($placeholders)", ...$allowed_user_ids);
}

// Total records for pagination
$total_records = $wpdb->get_var("SELECT COUNT(*) FROM $table_name a WHERE $where");
$total_pages = ceil($total_records / $per_page);

// Fetch attendance records
$records = $wpdb->get_results(
    $wpdb->prepare(
        "SELECT a.*, u.display_name 
         FROM $table_name a 
         LEFT JOIN {$wpdb->users} u ON a.user_id = u.ID 
         WHERE $where 
         ORDER BY a.punch_in DESC 
         LIMIT %d OFFSET %d",
        $per_page, $offset
    )
);

// You can now loop through $records to display them.

    ?>
    <div class="wrap">
        <h1><?php echo esc_html(get_admin_page_title()); ?></h1>
        
        <!-- Add New Attendance Record Section -->
        <div class="attendance-card">
            <h2>Record New Attendance</h2>
            <form id="add-attendance-form" method="post">
                <div class="form-row">
                    <div class="form-group">
                        <label for="user_id">Select User:</label>
                        <select name="user_id" id="user_id" required>
                            <option value="">- Select User -</option>
                            <?php foreach ($users as $user) : ?>
                                <option value="<?php echo esc_attr($user->ID); ?>"><?php echo esc_html($user->display_name); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="punch_in">Punch In:</label>
                        <input type="datetime-local" name="punch_in" id="punch_in" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="punch_out">Punch Out:</label>
                        <input type="datetime-local" name="punch_out" id="punch_out">
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group full-width">
                        <label for="notes">Notes:</label>
                        <textarea name="notes" id="notes" rows="2"></textarea>
                    </div>
                </div>
                
                <div class="form-actions">
                    <button type="button" id="punch-in-btn" class="button button-primary">Punch In</button>
                    <button type="button" id="punch-out-btn" class="button">Punch Out</button>
                    <button type="button" id="save-record-btn" class="button button-secondary">Save Complete Record</button>
                </div>
                
                <?php wp_nonce_field('attendance_action', 'attendance_nonce'); ?>
            </form>
        </div>
        
        <!-- Filters Section -->
        <div class="attendance-card">
            <h2>Filter Records</h2>
            <form method="get">
                <input type="hidden" name="page" value="user-attendance">
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="filter_user_id">User:</label>
                        <select name="user_id" id="filter_user_id">
                            <option value="">All Users</option>
                            <?php foreach ($users as $user) : ?>
                                <option value="<?php echo esc_attr($user->ID); ?>" <?php selected($user_filter, $user->ID); ?>>
                                    <?php echo esc_html($user->display_name); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="date_from">Date From:</label>
                        <input type="date" name="date_from" id="date_from" value="<?php echo esc_attr($date_from); ?>">
                    </div>
                    
                    <div class="form-group">
                        <label for="date_to">Date To:</label>
                        <input type="date" name="date_to" id="date_to" value="<?php echo esc_attr($date_to); ?>">
                    </div>
                    
                    <div class="form-actions">
                        <button type="submit" class="button button-secondary">Filter</button>
                        <a href="<?php echo admin_url('admin.php?page=user-attendance'); ?>" class="button">Reset</a>
                    </div>
                </div>
            </form>
        </div>
        
        <!-- Records Table -->
        <div class="attendance-card">
            <h2>Attendance Records</h2>
            
            <?php if (empty($records)) : ?>
                <p>No attendance records found.</p>
            <?php else : ?>
                <table class="wp-list-table widefat fixed striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>User</th>
                            <th>Punch In</th>
                            <th>Punch Out</th>
                            <th>Duration</th>
                            <th>Notes</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($records as $record) : ?>
                            <tr>
                                <td><?php echo esc_html($record->id); ?></td>
                                <td><?php echo esc_html($record->display_name); ?></td>
                                <td><?php echo esc_html(date_i18n('Y-m-d H:i:s', strtotime($record->punch_in))); ?></td>
                                <td>
                                    <?php if (!empty($record->punch_out)) : ?>
                                        <?php echo esc_html(date_i18n('Y-m-d H:i:s', strtotime($record->punch_out))); ?>
                                    <?php else : ?>
                                        <span class="active-session">Active Session</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if (!empty($record->punch_out)) : 
                                        $duration = strtotime($record->punch_out) - strtotime($record->punch_in);
                                        $hours = floor($duration / 3600);
                                        $minutes = floor(($duration % 3600) / 60);
                                        echo esc_html(sprintf('%02d:%02d', $hours, $minutes));
                                    else : ?>
                                        -
                                    <?php endif; ?>
                                </td>
                                <td><?php echo esc_html($record->notes); ?></td>
                                <td>
                                    <a href="#" class="edit-record" data-id="<?php echo esc_attr($record->id); ?>">Edit</a> | 
                                    <a href="#" class="delete-record" data-id="<?php echo esc_attr($record->id); ?>">Delete</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                
                <!-- Pagination -->
                <?php if ($total_pages > 1) : ?>
                    <div class="tablenav">
                        <div class="tablenav-pages">
                            <span class="displaying-num"><?php printf(_n('%s item', '%s items', $total_records), number_format_i18n($total_records)); ?></span>
                            <span class="pagination-links">
                                <?php
                                echo paginate_links(array(
                                    'base' => add_query_arg('paged', '%#%'),
                                    'format' => '',
                                    'prev_text' => '&laquo;',
                                    'next_text' => '&raquo;',
                                    'total' => $total_pages,
                                    'current' => $current_page
                                ));
                                ?>
                            </span>
                        </div>
                    </div>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </div>
    <?php
}

/**
 * Render the import/export page
 */
function render_import_export_page_attendence() {
    // Check user capabilities
    if (!current_user_can('attendence_access')) {
        return;
    }
    
    ?>
    <div class="wrap">
        <h1><?php echo esc_html(get_admin_page_title()); ?></h1>
        
        <!-- Export Section -->
        <div class="attendance-card">
            <h2>Export Attendance Records</h2>
            <p>Export attendance records to a CSV file for backup or analysis.</p>
            
            <form method="post" action="<?php echo admin_url('admin-ajax.php'); ?>">
                <input type="hidden" name="action" value="export_attendance">
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="export_user_id">User:</label>
                        <select name="user_id" id="export_user_id">
                            <option value="">All Users</option>
                            <?php 
                            $users = get_users(array('fields' => array('ID', 'display_name')));
                            foreach ($users as $user) : 
                            ?>
                                <option value="<?php echo esc_attr($user->ID); ?>"><?php echo esc_html($user->display_name); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="export_date_from">Date From:</label>
                        <input type="date" name="date_from" id="export_date_from">
                    </div>
                    
                    <div class="form-group">
                        <label for="export_date_to">Date To:</label>
                        <input type="date" name="date_to" id="export_date_to">
                    </div>
                </div>
                
                <div class="form-actions">
                    <button type="submit" class="button button-primary">Export to CSV</button>
                </div>
                
                <?php wp_nonce_field('export_attendance_action', 'export_attendance_nonce'); ?>
            </form>
        </div>
        
        <!-- Import Section -->
        <div class="attendance-card">
            <h2>Import Attendance Records</h2>
            <p>Import attendance records from a CSV file. The CSV file should have the following columns: user_id, punch_in, punch_out, notes.</p>
            <p><strong>Format:</strong> user_id, punch_in (YYYY-MM-DD HH:MM:SS), punch_out (YYYY-MM-DD HH:MM:SS), notes</p>
            
            <form method="post" enctype="multipart/form-data" id="import-form">
                <div class="form-row">
                    <div class="form-group full-width">
                        <label for="csv_file">Select CSV File:</label>
                        <input type="file" name="csv_file" id="csv_file" accept=".csv" required>
                    </div>
                </div>
                
                <div class="form-actions">
                    <button type="button" id="import-csv-btn" class="button button-primary">Import CSV</button>
                </div>
                
                <div id="import-results" style="display: none;"></div>
                
                <?php wp_nonce_field('import_attendance_action', 'import_attendance_nonce'); ?>
            </form>
        </div>
    </div>
    <?php
}

/**
 * Handle punch in AJAX request
 */
function handle_punch_in() {
    // Check nonce
    check_ajax_referer('attendance_nonce', 'nonce');
    
    // Check capabilities
    if (!current_user_can('attendence_access')) {
        wp_send_json_error('Permission denied');
        return;
    }
    
    // Validate input
    $user_id = isset($_POST['user_id']) ? intval($_POST['user_id']) : 0;
    $punch_in = isset($_POST['punch_in']) ? sanitize_text_field($_POST['punch_in']) : '';
    $notes = isset($_POST['notes']) ? sanitize_textarea_field($_POST['notes']) : '';
    
    if (empty($user_id) || empty($punch_in)) {
        wp_send_json_error('Missing required fields');
        return;
    }
    
    // Check if user exists
    if (!get_user_by('id', $user_id)) {
        wp_send_json_error('User not found');
        return;
    }
    
    // Insert record
    global $wpdb;
    $table_name = $wpdb->prefix . 'user_attendance';
    
    $result = $wpdb->insert(
        $table_name,
        array(
            'user_id' => $user_id,
            'punch_in' => $punch_in,
            'notes' => $notes
        ),
        array('%d', '%s', '%s')
    );
    
    if ($result === false) {
        wp_send_json_error('Database error');
        return;
    }
    
    wp_send_json_success(array(
        'id' => $wpdb->insert_id,
        'message' => 'Punch in recorded successfully'
    ));
}
add_action('wp_ajax_punch_in', 'handle_punch_in');

/**
 * Handle punch out AJAX request
 */
function handle_punch_out() {
    // Check nonce
    check_ajax_referer('attendance_nonce', 'nonce');
    
    // Check capabilities
    if (!current_user_can('attendence_access')) {
        wp_send_json_error('Permission denied');
        return;
    }
    
    // Validate input
    $record_id = isset($_POST['record_id']) ? intval($_POST['record_id']) : 0;
    $punch_out = isset($_POST['punch_out']) ? sanitize_text_field($_POST['punch_out']) : '';
    $notes = isset($_POST['notes']) ? sanitize_textarea_field($_POST['notes']) : '';
    
    if (empty($record_id) || empty($punch_out)) {
        wp_send_json_error('Missing required fields');
        return;
    }
    
    // Update record
    global $wpdb;
    $table_name = $wpdb->prefix . 'user_attendance';
    
    $result = $wpdb->update(
        $table_name,
        array(
            'punch_out' => $punch_out,
            'notes' => $notes
        ),
        array('id' => $record_id),
        array('%s', '%s'),
        array('%d')
    );
    
    if ($result === false) {
        wp_send_json_error('Database error');
        return;
    }
    
    wp_send_json_success(array(
        'message' => 'Punch out recorded successfully'
    ));
}
add_action('wp_ajax_punch_out', 'handle_punch_out');

/**
 * Handle export attendance records
 */
function handle_export_attendance() {
    // Verify nonce
    if (!isset($_POST['export_attendance_nonce']) || !wp_verify_nonce($_POST['export_attendance_nonce'], 'export_attendance_action')) {
        wp_die('Security check failed');
    }
    
    // Check user capabilities
    if (!current_user_can('attendence_access')) {
        wp_die('Permission denied');
    }
    
    // Get filter parameters
    $user_id = isset($_POST['user_id']) ? intval($_POST['user_id']) : 0;
    $date_from = isset($_POST['date_from']) && !empty($_POST['date_from']) ? sanitize_text_field($_POST['date_from']) : '';
    $date_to = isset($_POST['date_to']) && !empty($_POST['date_to']) ? sanitize_text_field($_POST['date_to']) : '';
    
    // Build query
    global $wpdb;
    $table_name = $wpdb->prefix . 'user_attendance';
    
    $where = '1=1';
    
    if ($user_id > 0) {
        $where .= $wpdb->prepare(" AND user_id = %d", $user_id);
    }
    
    if (!empty($date_from)) {
        $where .= $wpdb->prepare(" AND DATE(punch_in) >= %s", $date_from);
    }
    
    if (!empty($date_to)) {
        $where .= $wpdb->prepare(" AND DATE(punch_in) <= %s", $date_to);
    }
    // Get current user and check role
$current_user = wp_get_current_user();
$is_admin = in_array('administrator', $current_user->roles);

// Role-based data access
if (!$is_admin) {
    $current_user_id = $current_user->ID;

    // Get branch admin users related to this user
    $branch_admins = getBranchAdminUser(); // You defined this elsewhere

    if (empty($branch_admins)) {
        $branch_admins = array(0); // ensures no matches
    }

    // Get users created by branch admins
    $created_users = get_users(array(
        'meta_query' => array(
            array(
                'key'     => 'created_by',
                'value'   => $branch_admins,
                'compare' => 'IN',
            ),
        ),
        'fields' => array('ID'),
    ));

    $allowed_user_ids = wp_list_pluck($created_users, 'ID');
    $allowed_user_ids[] = $current_user_id; // Include self

    // Sanitize for SQL IN clause
    $placeholders = implode(',', array_fill(0, count($allowed_user_ids), '%d'));
    $where .= $wpdb->prepare(" AND a.user_id IN ($placeholders)", ...$allowed_user_ids);
}
    // Get records
    $records = $wpdb->get_results(
        "SELECT a.*, u.display_name 
        FROM $table_name a 
        LEFT JOIN {$wpdb->users} u ON a.user_id = u.ID 
        WHERE $where 
        ORDER BY punch_in DESC"
    );
    
    // Set up the CSV headers
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="attendance-export-' . date('Y-m-d') . '.csv"');
    header('Pragma: no-cache');
    header('Expires: 0');
    
    // Create file pointer
    $output = fopen('php://output', 'w');
    
    // Add column headers
    fputcsv($output, array(
        'ID',
        'User ID',
        'User Name',
        'Punch In',
        'Punch Out',
        'Duration (hours)',
        'Notes',
        'Created At'
    ));
    
    // Add data rows
    foreach ($records as $record) {
        $duration = '';
        if (!empty($record->punch_out)) {
            $duration_seconds = strtotime($record->punch_out) - strtotime($record->punch_in);
            $duration = number_format($duration_seconds / 3600, 2);
        }
        
        fputcsv($output, array(
            $record->id,
            $record->user_id,
            $record->display_name,
            $record->punch_in,
            $record->punch_out,
            $duration,
            $record->notes,
            $record->created_at
        ));
    }
    
    fclose($output);
    exit;
}
add_action('wp_ajax_export_attendance', 'handle_export_attendance');

/**
 * Process CSV import
 */
function process_csv_import() {
    // Check nonce
    check_ajax_referer('attendance_nonce', 'nonce');
    
    // Check capabilities
    if (!current_user_can('attendence_access')) {
        wp_send_json_error('Permission denied');
        return;
    }
    
    // Validate file upload
    if (!isset($_FILES['csv_file']) || $_FILES['csv_file']['error'] !== UPLOAD_ERR_OK) {
        wp_send_json_error('File upload error');
        return;
    }
    
    // Validate file type
    $file_info = pathinfo($_FILES['csv_file']['name']);
    if ($file_info['extension'] !== 'csv') {
        wp_send_json_error('Invalid file type. Please upload a CSV file.');
        return;
    }
    
    // Read CSV file
    $file = fopen($_FILES['csv_file']['tmp_name'], 'r');
    if (!$file) {
        wp_send_json_error('Could not open file');
        return;
    }
    
    // Read header row
    $header = fgetcsv($file);
    if (!$header) {
        fclose($file);
        wp_send_json_error('Could not read CSV header');
        return;
    }
    
    // Validate required columns
    $required_columns = array('user_id', 'punch_in');
    $missing_columns = array_diff($required_columns, $header);
    
    if (!empty($missing_columns)) {
        fclose($file);
        wp_send_json_error('Missing required columns: ' . implode(', ', $missing_columns));
        return;
    }
    
    // Map column indices
    $columns = array();
    foreach ($header as $index => $column) {
        $columns[strtolower(trim($column))] = $index;
    }
    
    // Process data rows
    global $wpdb;
    $table_name = $wpdb->prefix . 'user_attendance';
    
    $success_count = 0;
    $error_count = 0;
    $line_number = 1; // Header row is line 1
    $errors = array();
    
    while (($data = fgetcsv($file)) !== false) {
        $line_number++;
        
        // Validate row data
        if (count($data) < count($header)) {
            $errors[] = "Line $line_number: Insufficient columns";
            $error_count++;
            continue;
        }
        
        // Extract data
        $user_id = intval($data[$columns['user_id']]);
        $punch_in = sanitize_text_field($data[$columns['punch_in']]);
        $punch_out = isset($columns['punch_out']) && !empty($data[$columns['punch_out']]) ? sanitize_text_field($data[$columns['punch_out']]) : null;
        $notes = isset($columns['notes']) ? sanitize_textarea_field($data[$columns['notes']]) : '';
        
        // Validate user
        if (!get_user_by('id', $user_id)) {
            $errors[] = "Line $line_number: Invalid user ID ($user_id)";
            $error_count++;
            continue;
        }
        
        // Validate dates
        if (!strtotime($punch_in)) {
            $errors[] = "Line $line_number: Invalid punch in date format";
            $error_count++;
            continue;
        }
        
        if ($punch_out !== null && !strtotime($punch_out)) {
            $errors[] = "Line $line_number: Invalid punch out date format";
            $error_count++;
            continue;
        }
        
        // Insert record
        $record_data = array(
            'user_id' => $user_id,
            'punch_in' => $punch_in,
            'notes' => $notes,
        );
        
        $record_format = array('%d', '%s', '%s');
        
        if ($punch_out !== null) {
            $record_data['punch_out'] = $punch_out;
            $record_format[] = '%s';
        }
        
        $result = $wpdb->insert($table_name, $record_data, $record_format);
        
        if ($result === false) {
            $errors[] = "Line $line_number: Database error";
            $error_count++;
        } else {
            $success_count++;
        }
    }
    
    fclose($file);
    
    // Send response
    wp_send_json_success(array(
        'message' => sprintf('Import completed: %d records imported, %d errors', $success_count, $error_count),
        'success_count' => $success_count,
        'error_count' => $error_count,
        'errors' => $errors
    ));
}
add_action('wp_ajax_process_csv_import', 'process_csv_import');

/**
 * Create CSS file for the admin interface
 * Add this to your theme's css folder as 'attendance-admin.css'
 */
function create_attendance_admin_css() {
    $css_dir = get_stylesheet_directory_uri() . '/css';
    
    // Create folder if it doesn't exist
    if (!file_exists($css_dir)) {
        mkdir($css_dir, 0755, true);
    }
    
    $css_file = $css_dir . '/attendance.css';
    $css_content = '
    /* User Attendance Admin Styles */
.attendance-card {
    background: #fff;
    border: 1px solid #ccd0d4;
    box-shadow: 0 1px 1px rgba(0,0,0,.04);
    margin: 20px 0;
    padding: 20px;
}

.form-row {
    display: flex;
    flex-wrap: wrap;
    margin: 0 -10px;
}

.form-group {
    padding: 0 10px;
    margin-bottom: 15px;
    flex: 1;
    min-width: 200px;
}

.form-group.full-width {
    flex: 0 0 100%;
}

.form-group label {
    display: block;
    margin-bottom: 5px;
    font-weight: 600;
}

.form-group input[type="text"],
.form-group input[type="date"],
.form-group input[type="datetime-local"],
.form-group select,
.form-group textarea {
    width: 100%;
}

.form-actions {
    padding: 10px;
    display: flex;
    gap: 10px;
}

.active-session {
    color: #46b450;
    font-weight: 600;
}

#import-results {
    margin-top: 20px;
    padding: 15px;
    background: #f8f8f8;
    border-left: 4px solid #46b450;
}

#import-results.error {
    border-left-color: #dc3232;
}

#import-results ul {
    margin-left: 20px;
    list-style-type: disc;
}';
    
    // Create the CSS file
    file_put_contents($css_file, $css_content);
}

/**
 * Create JS file for the admin interface
 * Add this to your theme's js folder as 'attendance-admin.js'
 */
function create_attendance_admin_js() {
    $js_dir = get_stylesheet_directory_uri() . '/js';
    
    // Create folder if it doesn't exist
    if (!file_exists($js_dir)) {
        mkdir($js_dir, 0755, true);
    }
    
    $js_file = $js_dir . '/attendance.js';
    $js_content = "jQuery(document).ready(function($) {
    // Punch In button
    $('#punch-in-btn').on('click', function() {
        var userId = $('#user_id').val();
        var punchIn = $('#punch_in').val();
        var notes = $('#notes').val();
        
        if (!userId || !punchIn) {
            alert('Please select a user and enter punch in time');
            return;
        }
        
        $.ajax({
            url: attendanceData.ajax_url,
            type: 'POST',
            data: {
                action: 'punch_in',
                nonce: attendanceData.nonce,
                user_id: userId,
                punch_in: punchIn,
                notes: notes
            },
            success: function(response) {
                if (response.success) {
                    alert('Punch in recorded successfully!');
                    window.location.reload();
                } else {
                    alert('Error: ' + response.data);
                }
            },
            error: function() {
                alert('Server error. Please try again.');
            }
        });
    });
    
    // Punch Out button
    $('#punch-out-btn').on('click', function() {
        var userId = $('#user_id').val();
        var notes = $('#notes').val();
        
        // First check if there's an active session for this user
        $.ajax({
            url: attendanceData.ajax_url,
            type: 'POST',
            data: {
                action: 'get_active_session',
                nonce: attendanceData.nonce,
                user_id: userId
            },
            success: function(response) {
                if (response.success && response.data.id) {
                    // We have an active session, ask for confirmation
                    if (confirm('Active session found. Do you want to punch out now?')) {
                        // Set current time as punch out
                        var now = new Date();
                        var punchOut = now.toISOString().slice(0, 16);
                        $('#punch_out').val(punchOut);
                        
                        // Submit punch out
                        $.ajax({
                            url: attendanceData.ajax_url,
                            type: 'POST',
                            data: {
                                action: 'punch_out',
                                nonce: attendanceData.nonce,
                                record_id: response.data.id,
                                punch_out: punchOut,
                                notes: notes
                            },
                            success: function(response) {
                                if (response.success) {
                                    alert('Punch out recorded successfully!');
                                    window.location.reload();
                                } else {
                                    alert('Error: ' + response.data);
                                }
                            },
                            error: function() {
                                alert('Server error. Please try again.');
                            }
                        });
                    }
                } else {
                    alert('No active session found for this user.');
                }
            },
            error: function() {
                alert('Server error. Please try again.');
            }
        });
    });
    
    // Save Complete Record button
    $('#save-record-btn').on('click', function() {
        var userId = $('#user_id').val();
        var punchIn = $('#punch_in').val();
        var punchOut = $('#punch_out').val();
        var notes = $('#notes').val();
        
        if (!userId || !punchIn) {
            alert('Please select a user and enter punch in time');
            return;
        }
        
        $.ajax({
            url: attendanceData.ajax_url,
            type: 'POST',
            data: {
                action: 'save_complete_record',
                nonce: attendanceData.nonce,
                user_id: userId,
                punch_in: punchIn,
                punch_out: punchOut,
                notes: notes
            },
            success: function(response) {
                if (response.success) {
                    alert('Record saved successfully!');
                    window.location.reload();
                } else {
                    alert('Error: ' + response.data);
                }
            },
            error: function() {
                alert('Server error. Please try again.');
            }
        });
    });
    
    // Edit record
    $('.edit-record').on('click', function(e) {
        e.preventDefault();
        var recordId = $(this).data('id');
        
        $.ajax({
            url: attendanceData.ajax_url,
            type: 'POST',
            data: {
                action: 'get_record',
                nonce: attendanceData.nonce,
                record_id: recordId
            },
            success: function(response) {
                if (response.success) {
                    var record = response.data;
                    
                    // Populate form
                    $('#user_id').val(record.user_id);
                    $('#punch_in').val(record.punch_in.slice(0, 16));
                    
                    if (record.punch_out) {
                        $('#punch_out').val(record.punch_out.slice(0, 16));
                    } else {
                        $('#punch_out').val('');
                    }
                    
                    $('#notes').val(record.notes);
                    
                    // Change save button text and add record ID as data attribute
                    $('#save-record-btn').text('Update Record').data('record-id', recordId);
                    
                    // Scroll to form
                    $('html, body').animate({
                        scrollTop: $('#add-attendance-form').offset().top - 50
                    }, 500);
                } else {
                    alert('Error: ' + response.data);
                }
            },
            error: function() {
                alert('Server error. Please try again.');
            }
        });
    });
    
    // Delete record
    $('.delete-record').on('click', function(e) {
        e.preventDefault();
        var recordId = $(this).data('id');
        
        if (confirm('Are you sure you want to delete this record? This action cannot be undone.')) {
            $.ajax({
                url: attendanceData.ajax_url,
                type: 'POST',
                data: {
                    action: 'delete_record',
                    nonce: attendanceData.nonce,
                    record_id: recordId
                },
                success: function(response) {
                    if (response.success) {
                        alert('Record deleted successfully!');
                        window.location.reload();
                    } else {
                        alert('Error: ' + response.data);
                    }
                },
                error: function() {
                    alert('Server error. Please try again.');
                }
            });
        }
    });
    
    // Import CSV
    $('#import-csv-btn').on('click', function() {
        var formData = new FormData();
        var fileInput = $('#csv_file')[0];
        
        if (fileInput.files.length === 0) {
            alert('Please select a CSV file to import');
            return;
        }
        
        formData.append('action', 'process_csv_import');
        formData.append('nonce', attendanceData.nonce);
        formData.append('csv_file', fileInput.files[0]);
        
        $.ajax({
            url: attendanceData.ajax_url,
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                if (response.success) {
                    var resultsDiv = $('#import-results');
                    resultsDiv.removeClass('error');
                    
                    var content = '<h3>Import Results</h3>';
                    content += '<p>' + response.data.message + '</p>';
                    
                    if (response.data.error_count > 0 && response.data.errors.length > 0) {
                        content += '<h4>Errors:</h4>';
                        content += '<ul>';
                        $.each(response.data.errors, function(index, error) {
                            content += '<li>' + error + '</li>';
                        });
                        content += '</ul>';
                    }
                    
                    resultsDiv.html(content).show();
                } else {
                    var resultsDiv = $('#import-results');
                    resultsDiv.addClass('error');
                    resultsDiv.html('<h3>Import Error</h3><p>' + response.data + '</p>').show();
                }
            },
            error: function() {
                alert('Server error. Please try again.');
            }
        });
    });
});";
    
    // Create the JS file
    file_put_contents($js_file, $js_content);
}