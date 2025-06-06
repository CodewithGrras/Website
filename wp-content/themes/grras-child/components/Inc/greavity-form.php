<?php
// 1. Add a new menu in the admin sidebar
add_action('admin_menu', 'custom_feedback_menu');
function custom_feedback_menu() {
    
    add_menu_page(
        'Feedback Entries',
        'Feedback Entries',
        'feedback_access',
        'custom-feedback-entries',
        'render_feedback_entries_page',
        'dashicons-testimonial',
        26
    );

    add_submenu_page(
        'custom-feedback-entries',
        'Add New Feedback',
        'Add New',
        'feedback_access',
        'add-new-feedback',
        'render_add_new_feedback_page'
    );
    
    add_submenu_page(
        'custom-feedback-entries',
        'Import/Export',
        'Import/Export',
        'feedback_access',
        'feedback-import-export',
        'render_import_export_page'
    );
}

function render_feedback_entries_page() {
    $form_id = 28;

    if (!class_exists('GFAPI')) {
        echo '<p>Gravity Forms is not active.</p>';
        return;
    }

    // Handle delete action
    if (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['entry_id'])) {
        $entry_id = intval($_GET['entry_id']);
        $result = GFAPI::delete_entry($entry_id);
        if ($result) {
            echo '<div class="notice notice-success"><p>Entry deleted successfully!</p></div>';
        } else {
            echo '<div class="notice notice-error"><p>Failed to delete entry.</p></div>';
        }
    }

    $current_user = wp_get_current_user();

    if (in_array('administrator', $current_user->roles)) {
        // Admins see all entries
        $search_criteria = array();
    } else {
        // Branch admins see entries created by users they created
        $user_ids = getBranchAdminUser();

        // Prevent empty IN clause (which would return all if not handled)
        if (empty($user_ids)) {
            $user_ids = array(0); // no match
        }

        $search_criteria = array(
            'field_filters' => array(
                array(
                    'key' => '9',
                    'operator' => 'in',
                    'value' => $user_ids
                )
            )
        );
    }

    $sorting = array('key' => 'date_created', 'direction' => 'DESC');

    // Pagination
    $page = isset($_GET['paged']) ? max(1, intval($_GET['paged'])) : 1;
    $per_page = 20;
    $offset = ($page - 1) * $per_page;
    $paging = array('offset' => $offset, 'page_size' => $per_page);


    $entries = GFAPI::get_entries($form_id, $search_criteria, $sorting, $paging);
    $total_entries = GFAPI::count_entries($form_id, $search_criteria);

    echo '<div class="wrap"><h1>Feedback Entries</h1>';

    // Import/Export Button
    echo '<div style="margin: 15px 0;">';
    echo '<a href="' . admin_url('admin.php?page=feedback-import-export') . '" class="button">Import/Export Feedback</a>';
    echo '</div>';

    if (empty($entries)) {
        echo '<p>No feedback entries found.</p>';
    } else {
        echo '<table class="widefat fixed striped">';
        echo '<thead><tr><th>#</th>';

        // Get field labels
        $form = GFAPI::get_form($form_id);
        $field_labels = [];
        foreach ($form['fields'] as $field) {
            echo '<th>' . esc_html($field->label) . '</th>';
            $field_labels[] = $field->id;
        }

        echo '<th>Actions</th>';
        echo '</tr></thead><tbody>';

        // Show entries
        foreach ($entries as $index => $entry) {
            echo '<tr><td>' . ($offset + $index + 1) . '</td>';

            foreach ($field_labels as $field_id) {
                $value = rgar($entry, $field_id);
                echo '<td>' . esc_html($value) . '</td>';
            }

            if (in_array('administrator', $current_user->roles)){
            echo '<td>';
            echo '<a href="' . admin_url('admin.php?page=custom-feedback-entries&action=delete&entry_id=' . $entry['id']) . '" onclick="return confirm(\'Are you sure you want to delete this entry?\');" class="button button-small">Delete</a>';
            echo '</td>';
}
            echo '</tr>';
        }

        echo '</tbody></table>';

        // Pagination
        $total_pages = ceil($total_entries / $per_page);
        if ($total_pages > 1) {
            echo '<div class="tablenav bottom">';
            echo '<div class="tablenav-pages">';
            echo '<span class="displaying-num">' . $total_entries . ' items</span>';

            $pagination_args = array(
                'base' => add_query_arg('paged', '%#%'),
                'format' => '',
                'prev_text' => '&laquo;',
                'next_text' => '&raquo;',
                'total' => $total_pages,
                'current' => $page
            );

            echo paginate_links($pagination_args);
            echo '</div></div>';
        }
    }

    echo '</div>';
}


// 3. Add New Feedback Page
function render_add_new_feedback_page() {
    // Replace this with your actual form ID
    $form_id = 28;
    if (!class_exists('GFAPI')) {
        echo '<p>Gravity Forms is not active.</p>';
        return;
    }
    
    $form = GFAPI::get_form($form_id);
    if (!$form) {
        echo '<p>Form not found.</p>';
        return;
    }
    
    echo '<div class="wrap"><h1>Add New Feedback</h1>';
    
    // Handle form submission
    if (isset($_POST['submit_feedback'])) {
        
        $form_id = 28;
        $entry = array();
        
        // // Process the workshop user and post ID if present
        // if (isset($_POST['workshop_user']) && !empty($_POST['workshop_user'])) {
        //     $entry['workshop_user'] = sanitize_text_field($_POST['workshop_user']);
        // }
        
        // if (isset($_POST['post_id']) && !empty($_POST['post_id'])) {
        //     $entry['post_id'] = intval($_POST['post_id']);
        // }
        
        // Process each field from the form
        foreach ($form['fields'] as $field) {
            $field_id = $field->id;
            if (isset($_POST['input_' . $field_id])) {
                $entry[$field_id] = sanitize_text_field($_POST['input_' . $field_id]);
            }
        }
        
        // Add entry creation date
        $entry['date_created'] = current_time('mysql');
        
        // Add entry to the form
        $entry['form_id'] = $form_id;
     
        $result = GFAPI::add_entry($entry);

        if (is_wp_error($result)) {
            echo '<div class="notice notice-error"><p>Failed to add feedback: ' . $result->get_error_message() . '</p></div>';
        } else {
            echo '<div class="notice notice-success"><p>Feedback added successfully!</p></div>';
        }
    }
    
    // Display the form
    echo '<form method="post">';
    echo '<table class="form-table">';

// Fetch workshops
$current_user = wp_get_current_user();

if (in_array('administrator', $current_user->roles)) {
    // Admins see all workshops
    $workshops = get_posts(array(
        'post_type' => 'workshops',
        'posts_per_page' => -1,
        'post_status' => 'publish',
        'orderby' => 'title',
        'order' => 'ASC'
    ));
} else {
    // Branch admin + users they created
    $user_ids = getBranchAdminUser();

    $workshops = get_posts(array(
        'post_type' => 'workshops',
        'posts_per_page' => -1,
        'post_status' => 'publish',
        'orderby' => 'title',
        'order' => 'ASC',
        'author__in' => $user_ids
    ));
}
// Fetch users (adjust role or args as needed)
// $users = get_userget_users

?>

<tr>
    <th><label for="post_id">Select Workshop</label></th>
    <td>
<select name="post_id" id="post_id">
    <option value="">-- Select a Workshop --</option>
    <?php


    foreach ($workshops as $workshop) {
        $author_id = $workshop->post_author;
        $author = get_userdata($author_id);
        $author_name = $author ? $author->display_name : 'Unknown';

        echo '<option value="' . esc_attr($workshop->ID) . '" 
                    data-user-id="' . esc_attr($author_id) . '" 
                    data-user-name="' . esc_attr($author_name) . '">';
        echo esc_html($workshop->post_title);
        echo '</option>';
    }
    ?>
</select>


    </td>
</tr>




<script>
document.addEventListener('DOMContentLoaded', function () {
 const workshopSelect = document.getElementById('post_id');
 const workshop_id = document.getElementById('workshop_id');
 const workshop_user_id = document.getElementById('workshop_user_id');
const userRow = document.getElementById('user_info_row');
const userDisplay = document.getElementById('workshop_user_display');
const userHidden = document.getElementById('workshop_user');

workshopSelect.addEventListener('change', function () {
    const selectedOption = this.options[this.selectedIndex];
    const userId = selectedOption.dataset.userId;
    const userName = selectedOption.dataset.userName;

    if (this.value && userId && userName) {
        userDisplay.value = `${userName} (ID: ${userId})`;
        userHidden.value = userName;
        workshop_user_id.value = userId;
        workshop_id.value = this.value;
        userRow.style.display = '';
    } else {
        userDisplay.value = '';
        userHidden.value = '';
        userRow.style.display = 'none';
    }
});


});
</script>
<?php
    // Display form fields
    foreach ($form['fields'] as $field) {
        $field_id = $field->id;
        $field_label = $field->label;
// echo $field_label. $field_id .'<br>';
        echo '<tr>';
        if ($field_id !== 7) {
        echo '<th><label for="input_' . $field_id . '">' . esc_html($field_label) . '</label></th>';
        }
        
        // Different input types based on field type
        if ($field->type == 'textarea') {
            echo '<td><textarea name="input_' . $field_id . '" id="input_' . $field_id . '" class="large-text" rows="5"></textarea></td>';
        } elseif ($field->type == 'select') {
            echo '<td><select name="input_' . $field_id . '" id="input_' . $field_id . '">';
            foreach ($field->choices as $choice) {
                echo '<option value="' . esc_attr($choice['value']) . '">' . esc_html($choice['text']) . '</option>';
            }
            echo '</select></td>';
        } elseif ($field_id == '7') {
            ?>
            <tr id="user_info_row" style="display: none;">
    <th><label for="workshop_user">Workshop Author</label></th>
    <td>
        <input type="text" id="workshop_user_display" class="regular-text" disabled>
        <input type="hidden" name="<?php echo 'input_' . $field_id; ?>" id="workshop_user">
    </td>
</tr>
            <?php
        }elseif ($field_id == '8') {
            ?>
       
   
    <td>
      
        <input type="text" name="<?php echo 'input_' . $field_id; ?>" id="workshop_id" readonly>
    </td>

            <?php
        }
        elseif ($field_id == '9') {
            ?>
       
   
    <td>
      
        <input type="text" name="<?php echo 'input_' . $field_id; ?>" id="workshop_user_id" readonly>
    </td>

            <?php
        }
        else {
            echo '<td><input type="text" name="input_' . $field_id . '" id="input_' . $field_id . '" class="regular-text"></td>';
        }
        
        echo '</tr>';
    }
    
    echo '</table>';
    echo '<p class="submit"><input type="submit" name="submit_feedback" class="button button-primary" value="Add Feedback"></p>';
    echo '</form>';
    echo '</div>';
}

// 4. Import/Export Page
function render_import_export_page() {
    // Replace this with your actual form ID
    $form_id = 28;
    if (!class_exists('GFAPI')) {
        echo '<p>Gravity Forms is not active.</p>';
        return;
    }
    
    echo '<div class="wrap"><h1>Import/Export Feedback</h1>';
    
    // Handle CSV Export
if (isset($_POST['export_csv'])) {
    // Check if Gravity Forms is active
    if (!class_exists('GFAPI')) {
        wp_die('Gravity Forms is not active.');
    }

    $form_id = 28;
    $current_user = wp_get_current_user();

    // Role-based filtering
    if (in_array('administrator', $current_user->roles)) {
        $search_criteria = array();
    } else {
        $user_ids = getBranchAdminUser();
        if (empty($user_ids)) {
            $user_ids = array(0); // Prevent returning all entries if empty
        }

        $search_criteria = array(
            'field_filters' => array(
                array(
                    'key' => '9', // Field ID of the user who created the entry
                    'operator' => 'in',
                    'value' => $user_ids
                )
            )
        );
    }

    // Get entries and form structure
    $entries = GFAPI::get_entries($form_id, $search_criteria);
    $form = GFAPI::get_form($form_id);

    // Prepare data
    $data_to_export = [];
    $headers = ['Entry ID', 'Date Created'];
    foreach ($form['fields'] as $field) {
        $headers[] = $field->label;
    }
    $data_to_export[] = $headers;

    foreach ($entries as $entry) {
        $row = [
            $entry['id'],
            $entry['date_created']
        ];
        foreach ($form['fields'] as $field) {
            $row[] = rgar($entry, $field->id);
        }
        $data_to_export[] = $row;
    }
// return print_r($data_to_export);
// Send headers
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="export.csv"');
    header('Pragma: no-cache');
    header('Expires: 0');

    // Make sure no extra whitespace or output is sent
    ob_clean();
    flush();

    $output = fopen('php://output', 'w');

    // Write CSV rows
    foreach ($data_to_export as $fields) {
        fputcsv($output, $fields);
    }

    fclose($output);
    exit; // IMPORTANT: Stop further HTML from loading
}

    // Handle CSV Import
    if (isset($_POST['import_csv']) && isset($_FILES['csv_file'])) {
        $file = $_FILES['csv_file'];
        
        // Check for errors
        if ($file['error'] == UPLOAD_ERR_OK) {
            $form = GFAPI::get_form($form_id);
            
            // Process the CSV file
            $handle = fopen($file['tmp_name'], 'r');
            
            // First row should be headers
            $headers = fgetcsv($handle);
            
            // Map headers to field IDs
            $field_map = array();
            foreach ($form['fields'] as $field) {
                // Find the header position that matches this field label
                $pos = array_search($field->label, $headers);
                if ($pos !== false) {
                    $field_map[$pos] = $field->id;
                }
            }
            
            // Get the positions for special columns
            $id_pos = array_search('ID', $headers);
            $date_pos = array_search('Date Created', $headers);
            $workshop_pos = array_search('Workshop User', $headers);
            $post_id_pos = array_search('Post ID', $headers);
            
            $count = 0;
            $errors = 0;
            
            // Process each row
            while (($data = fgetcsv($handle)) !== FALSE) {
                $entry = array();
                
                // Add workshop user and post ID if present
                if ($workshop_pos !== false && isset($data[$workshop_pos])) {
                    $entry['workshop_user'] = sanitize_text_field($data[$workshop_pos]);
                }
                
                if ($post_id_pos !== false && isset($data[$post_id_pos])) {
                    $entry['post_id'] = intval($data[$post_id_pos]);
                }
                
                // Add date created if present, otherwise use current time
                if ($date_pos !== false && isset($data[$date_pos])) {
                    $entry['date_created'] = $data[$date_pos];
                } else {
                    $entry['date_created'] = current_time('mysql');
                }
                
                // Map field values based on the header mapping
                foreach ($field_map as $pos => $field_id) {
                    if (isset($data[$pos])) {
                        $entry[$field_id] = $data[$pos];
                    }
                }
                
                // If ID is present, check if we should update
                if ($id_pos !== false && !empty($data[$id_pos])) {
                    $existing_entry = GFAPI::get_entry($data[$id_pos]);
                    if (!is_wp_error($existing_entry)) {
                        // Update existing entry
                        $entry['id'] = $data[$id_pos];
                        $result = GFAPI::update_entry($entry, $data[$id_pos]);
                    } else {
                        // ID provided but not found, create new
                              $entry['form_id'] = $form_id;
                        $result = GFAPI::add_entry($entry);
                    }
                } else {
                    // No ID, create new entry
                          $entry['form_id'] = $form_id;
                    $result = GFAPI::add_entry($entry);
                }

                if (is_wp_error($result)) {
                    $errors++;
                } else {
                    $count++;
                }
            }
            
            fclose($handle);
            
            if ($errors > 0) {
                echo '<div class="notice notice-warning"><p>Import completed with ' . $count . ' entries added/updated and ' . $errors . ' errors.</p></div>';
            } else {
                echo '<div class="notice notice-success"><p>Successfully imported ' . $count . ' feedback entries.</p></div>';
            }
        } else {
            echo '<div class="notice notice-error"><p>Error uploading file. Error code: ' . $file['error'] . '</p></div>';
        }
    }
 if (isset($_POST['download_sample_csv'])) {
    $form_id = 28; // define if not already
    $form = GFAPI::get_form($form_id);

    // CSV headers
    $headers = ['ID', 'Date Created', 'Workshop User', 'Post ID'];
    foreach ($form['fields'] as $field) {
        $headers[] = $field->label;
    }

    $sample_row = ['(leave empty for new)', date('Y-m-d H:i:s'), 'editor', 12345];
    foreach ($form['fields'] as $field) {
        $sample_row[] = 'Sample ' . $field->label;
    }

    // Clean output buffer
    if (ob_get_length()) {
        ob_clean();
    }
    flush();

    // Set download headers
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="sample_import.csv"');
    header('Pragma: no-cache');
    header('Expires: 0');

    // Output CSV
    $output = fopen('php://output', 'w');
    fputcsv($output, $headers);
    fputcsv($output, $sample_row);
    fclose($output);
    exit; // Stop anything else
}

    // Export form
    echo '<div class="card" style="max-width: 800px; padding: 20px; margin-bottom: 20px;">';
    echo '<h2>Export Feedback</h2>';
    echo '<p>Download all feedback data as a CSV file.</p>';
    echo '<form method="post">';
    echo '<p class="submit"><input type="submit" name="export_csv" class="button button-primary" value="Export to CSV"></p>';
    echo '</form>';
    echo '</div>';
    //dawnload sample 
        // Export form
    echo '<div class="card" style="max-width: 800px; padding: 20px; margin-bottom: 20px;">';
    echo '<h2>Export Feedback</h2>';
    echo '<p>Download Sample formate.</p>';
    echo '<form method="post">';
    echo '<p class="submit"><input type="submit" name="download_sample_csv" class="button button-primary" value="Dawnload"></p>';
    echo '</form>';
    echo '</div>';
    
    // Import form
    echo '<div class="card" style="max-width: 800px; padding: 20px;">';
    echo '<h2>Import Feedback</h2>';
    echo '<p>Upload a CSV file to import feedback entries. The CSV should have the same structure as the exported CSV.</p>';
    echo '<p><strong>Note:</strong> If the CSV includes entry IDs, existing entries will be updated.</p>';
    echo '<form method="post" enctype="multipart/form-data">';
    echo '<p><input type="file" name="csv_file" required accept=".csv"></p>';
    echo '<p class="submit"><input type="submit" name="import_csv" class="button button-primary" value="Import from CSV"></p>';
    echo '</form>';
    echo '</div>';
    
    echo '</div>';
}
// for the feedback url 
function add_feedback_url_action($actions, $post) {

if ($post->post_type == 'workshops') {
    // Get post data
    $post_id = $post->ID;
    $post_name = $post->post_name;
    $author_name = get_the_author_meta('display_name', $post->post_author);

    // Base URL for the post
    $base_url = site_url('workshops/' . $post_name);

    // Build your feedback URL with query args
    $feedback_url = add_query_arg(array(
        'post_id'     => $post_id,
        'post_name'   => $post_name,
        'author_name' => urlencode($author_name)
    ), $base_url);

    // Add new action link
    $actions['feedback_url'] = '<a href="' . esc_url($feedback_url) . '" target="_blank">Feedback URL</a>';
}


    return $actions;
}
add_filter('post_row_actions', 'add_feedback_url_action', 10, 2);
