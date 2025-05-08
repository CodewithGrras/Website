<?php

include 'testimonials.php'; 
include 'internship-programs.php'; 
include 'career.php';
include 'courses.php';
include 'project.php';
include 'workshops.php';
include 'career-stories.php';
include 'placement.php';
include 'blog-search.php';
include 'red-hate.php';
include 'caps.php';
include 'greavity-form.php';
include 'attendence.php';
// include 'users-management.php';
// print_r(wp_get_current_user());
function create_review_post_type()
{
    register_post_type(
        'user_review',
        array(
            'labels' => array(
                'name' => __('User Reviews'),
                'singular_name' => __('User Review')
            ),
            'public' => true,
            'has_archive' => true,
            'supports' => array('title', 'editor', 'custom-fields'),
            'menu_icon' => 'dashicons-star-filled',
        )
    );
}
add_action('init', 'create_review_post_type');

function enqueue_custom_scripts_1()
{
    wp_enqueue_script('jquery');
    wp_enqueue_script('custom-script', get_stylesheet_directory_uri() . '/js/custom-script.js', array('jquery'), null, true);
    wp_localize_script('custom-script', 'ajax_object', array('ajax_url' => admin_url('admin-ajax.php')));
}
add_action('wp_enqueue_scripts', 'enqueue_custom_scripts_1');
function handle_form_submission()
{
    // Validate inputs
    if (empty($_POST['fullname']) || empty($_POST['email']) || empty($_POST['review'])) {
        wp_send_json_error('All fields are required.');
    }

    // Sanitize and prepare the data
    $fullname = sanitize_text_field($_POST['fullname']);
    $email = sanitize_email($_POST['email']);
    // $rating = intval($_POST['review-rating']); // Set this based on your star selection logic
    $rating = 5; // Set this based on your star selection logic
    $review = sanitize_textarea_field($_POST['review']);
    $post_content = "Review: $review";

    // Create a new post of the custom type
    $post_data = array(
        'post_title'   => $fullname, // Use the full name as the title
        'post_content' => $post_content,
        'post_status'  => 'publish',
        'post_type'    => 'user_review',
    );

    $post_id = wp_insert_post($post_data);

    if ($post_id) {
        // Save custom fields
        add_post_meta($post_id, 'email', $email);
        add_post_meta($post_id, 'rating', $rating);

        wp_send_json_success('Your review has been submitted successfully.');
    } else {
        wp_send_json_error('There was an error saving your review.');
    }
}

add_action('wp_ajax_submit_review', 'handle_form_submission');
add_action('wp_ajax_nopriv_submit_review', 'handle_form_submission');
function set_custom_edit_user_review_columns($columns)
{
    unset($columns['title']);
    unset($columns['date']);
    $columns['title'] = __('Name');
    $columns['email'] = __('Email');
    $columns['rating'] = __('Rating');
    $columns['date'] = __('Date');

    return $columns;
}
add_filter('manage_user_review_posts_columns', 'set_custom_edit_user_review_columns');

function custom_user_review_column($column, $post_id)
{
    switch ($column) {
        case 'email':
            echo get_post_meta($post_id, 'email', true);
            break;
        case 'rating':
            echo get_post_meta($post_id, 'rating', true);
            break;
        case 'title':
            echo get_the_title($post_id);
            break;
    }
}
add_action('manage_user_review_posts_custom_column', 'custom_user_review_column', 10, 2);

// Step 3: Make columns sortable
function user_review_sortable_columns($columns)
{
    $columns['email'] = 'email';
    $columns['rating'] = 'rating';
    return $columns;
}
add_filter('manage_edit-user_review_sortable_columns', 'user_review_sortable_columns');

// Step 4: Handle sorting
function user_review_orderby($query)
{
    if (!is_admin()) {
        return;
    }

    if ($query->get('post_type') === 'user_review') {
        if ('email' === $query->get('orderby')) {
            $query->set('meta_key', 'email');
            $query->set('orderby', 'meta_value');
        }
        if ('rating' === $query->get('orderby')) {
            $query->set('meta_key', 'rating');
            $query->set('orderby', 'meta_value_num');
        }
    }
}
add_action('pre_get_posts', 'user_review_orderby');
// Step 5: Add meta boxes
function add_review_meta_boxes()
{
    add_meta_box('review_email', __('Email'), 'render_review_email_meta_box', 'user_review', 'side', 'default');
    add_meta_box('review_rating', __('Rating'), 'render_review_rating_meta_box', 'user_review', 'side', 'default');
}
add_action('add_meta_boxes', 'add_review_meta_boxes');

function render_review_email_meta_box($post)
{
    $email = get_post_meta($post->ID, 'email', true);
    echo '<label for="review_email">' . __('Email:') . '</label>';
    echo '<input type="email" id="review_email" name="review_email" value="' . esc_attr($email) . '" class="widefat" />';
}

function render_review_rating_meta_box($post)
{
    $rating = get_post_meta($post->ID, 'rating', true);
    echo '<label for="review_rating">' . __('Rating:') . '</label>';
    echo '<input type="number" id="review_rating" name="review_rating" value="' . esc_attr($rating) . '" class="widefat" min="1" max="5" />';
}

// Step 6: Save meta box data
function save_review_meta_boxes($post_id)
{
    if (array_key_exists('review_email', $_POST)) {
        update_post_meta($post_id, 'email', sanitize_email($_POST['review_email']));
    }
    if (array_key_exists('review_rating', $_POST)) {
        update_post_meta($post_id, 'rating', intval($_POST['review_rating']));
    }
}
add_action('save_post', 'save_review_meta_boxes');


if ( function_exists('acf_add_options_page') ) {
    // Add a main options page
    acf_add_options_page(array(
        'page_title'    => 'Theme Options',
        'menu_title'    => 'Theme Options',
        'menu_slug'     => 'theme-options',
        'capability'    => 'edit_others_posts', // Change capability to allow Editors to access
        'redirect'      => false,
        'icon_url'      => 'dashicons-admin-generic',
    ));
}


if( !function_exists('get_link_custom'))  {
    function get_link_custom($slug="home"){
        $workshop_page = get_page_by_path($slug); 
        if ($workshop_page) {
            echo get_permalink($workshop_page->ID); 
        }
    }
}

function enqueue_load_more_scripts() {
    wp_enqueue_script('load-more', get_stylesheet_directory_uri() . '/js/load-more.js', array('jquery'), null, true);

    // Pass AJAX URL to the script
    wp_localize_script('load-more', 'load_more_params', array(
        'ajax_url' => admin_url('admin-ajax.php'), // WordPress AJAX handler URL
        'nonce' => wp_create_nonce('load_more_nonce'), // Security nonce
    ));
}
add_action('wp_enqueue_scripts', 'enqueue_load_more_scripts');


function load_more_posts() {
    // Verify nonce for security
    if (!isset($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'load_more_nonce')) {
        die('Permission Denied');
    }
    // Get the page number
    $page = isset($_POST['page']) ? $_POST['page'] : 1;
    $args = array(
        'post_type' => 'post',
        'posts_per_page' => 6, // Number of posts to load
        'paged' => $page, // Set the page for pagination
        'post_status' => 'publish',
    );

    // Create a new query
    $query = new WP_Query($args);

    // Check if there are posts
    if ($query->have_posts()) {
        // Loop through the posts
        while ($query->have_posts()) : $query->the_post();
            ?>
            <div class="col-lg-4 col-sm-6">
                <div class="blog-content">
                    <div class="imgbox">
                        <?php
                        if (has_post_thumbnail()) {
                            the_post_thumbnail('medium', array('class' => 'img-fluid'));
                        } else {
                            echo '<img src="' . get_stylesheet_directory_uri() . '/images/default-image.jpg" class="img-fluid" alt="">';
                        }
                        ?>
                    </div>
                    <div class="contentbox">
                        <h4><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
                        <div class="admin"><span>By</span> <?php the_author(); ?></div>
                        <div class="date"><?php echo get_the_date(); ?></div>
                        <div class="read"><?php echo get_post_meta(get_the_ID(), '_reading_time', true); ?> Min Read</div>
                    </div>
                </div>
            </div>
            <?php
        endwhile;
        wp_reset_postdata();
    } else {
        echo 'no more'; // No more posts to load
    }

    die(); // Don't forget to call die() in AJAX functions
}
add_action('wp_ajax_load_more_posts', 'load_more_posts'); // For logged-in users
add_action('wp_ajax_nopriv_load_more_posts', 'load_more_posts'); // For non-logged-in users
function category_listing(){
    $category = get_sub_field('category');

    // Replace underscores with spaces and capitalize each word
    $formatted_category = ucwords(str_replace('_', ' ', $category));
    
    echo $formatted_category;
    
}

// Register Custom Navigation Menu Location
function register_custom_menu() {
    register_nav_menu('custom-menu-location', __('Custom Menu Location'));
}
add_action('after_setup_theme', 'register_custom_menu');

function add_custom_menu_items() {
    // Check if the menu already exists
    $menu_name = 'Footer Menu';  // The name of your menu (choose any name you want)

    $menu_exists = wp_get_nav_menu_object($menu_name);

    // If the menu doesn't exist, create it
    if (!$menu_exists) {
        $menu_id = wp_create_nav_menu($menu_name);

        // Add menu items to the new menu
        wp_update_nav_menu_item($menu_id, 0, array(
            'menu-item-title' =>  __('Popular Workshops'),
            'menu-item-url' => home_url('/popular-workshops'),  // Link to the URL or page
            'menu-item-status' => 'publish'
        ));

        wp_update_nav_menu_item($menu_id, 0, array(
            'menu-item-title' =>  __('Career Oriented Courses'),
            'menu-item-url' => home_url('/career-oriented-courses'),
            'menu-item-status' => 'publish'
        ));

        wp_update_nav_menu_item($menu_id, 0, array(
            'menu-item-title' =>  __('Internship Courses'),
            'menu-item-url' => home_url('/internship-courses'),
            'menu-item-status' => 'publish'
        ));

        wp_update_nav_menu_item($menu_id, 0, array(
            'menu-item-title' =>  __('Popular Courses'),
            'menu-item-url' => home_url('/popular-courses'),
            'menu-item-status' => 'publish'
        ));
    }
}
add_action('after_setup_theme', 'add_custom_menu_items');

function create_slug($string) {
    // Convert to lowercase
    $slug = strtolower($string);
    // Replace spaces with hyphens
    $slug = preg_replace('/\s+/', '-', $slug);
    // Remove special characters
    $slug = preg_replace('/[^a-z0-9\-]/', '', $slug);
    // Trim hyphens from both ends
    $slug = trim($slug, '-');
    
    return $slug;
}

// for the course page
// Enqueue scripts and localize variables
function enqueue_scripts() {
    wp_enqueue_script('ajax-script', get_stylesheet_directory_uri() . '/js/ajax-script.js', array('jquery'), null, true);
    wp_localize_script('ajax-script', 'load_more_againa_params', array(
        'ajax_url' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('load_more_againa_nonce')
    ));
}
add_action('wp_enqueue_scripts', 'enqueue_scripts');

if (!function_exists('load_more_courses_ak')) {
    // AJAX handler function
    function load_more_courses_ak() {
        check_ajax_referer('load_more_againa_nonce', 'nonce');

        $page = isset($_POST['page']) ? intval($_POST['page']) : 1;
        $term = isset($_POST['term']) ? sanitize_text_field($_POST['term']) : '';
        $posts_per_page = 8;
        $offset = ($page - 1) * $posts_per_page;

        $args = array(
            'post_type' => 'courses', 
            'posts_per_page' => $posts_per_page,
            'offset' => $offset,
        );

        if ($term && $term !== '*') {
            $args['tax_query'] = array(
                array(
                    'taxonomy' => 'course_types',
                    'field'    => 'slug',
                    'terms'    => $term,
                ),
            );
        }

        $courses_query = new WP_Query($args);

        if ($courses_query->have_posts()) :
            while ($courses_query->have_posts()) : $courses_query->the_post();
                $course_terms = get_the_terms(get_the_ID(), 'course_types');
                $term_classes = '';

                if ($course_terms) {
                    foreach ($course_terms as $term) {
                        $term_classes .= ' ' . esc_attr($term->slug);
                    }
                }
                ?>

                <div class="col-lg-3 col-md-6 single-content grid-item col-sm-6 <?php echo $term_classes; ?>" data-post-id="<?php echo get_the_ID(); ?>">
                    <div class="cousebox">
                        <img src="<?php the_post_thumbnail_url(); ?>" class="icon">
                        <h4>
                            <a href="<?php the_permalink(); ?>">
                                <?php the_title(); ?>
                            </a>
                        </h4>
                        <p><img src="<?php echo get_stylesheet_directory_uri() ?>/images/clock1.png" alt=""> <strong><?php echo get_field('hourse'); ?></strong></p>
                        <p><img src="<?php echo get_stylesheet_directory_uri() ?>/images/calendar1.png" alt=""> <strong><?php echo get_field('days'); ?></strong></p>
                    </div>
                </div>
                
                <?php
            endwhile;
        else :
            echo '<p>No courses found.</p>';
        endif;

        wp_reset_postdata();
        wp_die();
    }
    add_action('wp_ajax_load_more_courses_ak', 'load_more_courses_ak');
    add_action('wp_ajax_nopriv_load_more_courses_ak', 'load_more_courses_ak');
}

function fetch_project_content() {
    // Sanitize and validate the project ID
    $post_id = intval($_GET['id']);
    if (!$post_id) {
        wp_send_json_error(['message' => 'Invalid project ID']); // Log error
    }

    $post = get_post($post_id);
    if (!$post || $post->post_type !== 'projects') {
        wp_send_json_error(['message' => 'Project not found']); // Log error
    }

    // Return the project title and content
    wp_send_json_success([
        'title'   => get_the_title($post),
        'content' => apply_filters('the_content', $post->post_content),
    ]);
}
add_action('wp_ajax_fetch_project_content', 'fetch_project_content');
add_action('wp_ajax_nopriv_fetch_project_content', 'fetch_project_content');

function load_more_placements() {
    $offset = isset($_GET['offset']) ? intval($_GET['offset']) : 0;
    $posts_per_page = isset($_GET['posts_per_page']) ? intval($_GET['posts_per_page']) : 6;
    $loaded_posts = isset($_GET['loaded_posts']) ? $_GET['loaded_posts'] : array();

    $args = array(
        'post_type' => 'placements',
        'posts_per_page' => $posts_per_page,
        'offset' => $offset, // Offset for already loaded posts
        'post__not_in' => $loaded_posts, // Exclude already loaded posts
        'taxonomy' => 'placement_types',
        'field' => 'slug',
        'hide_empty' => true,
    );

    $custom_query = new WP_Query($args);

    if ($custom_query->have_posts()) {
      
        
        while ($custom_query->have_posts()) {
            $custom_query->the_post();
            $terms = get_the_terms(get_the_ID(), 'placement_types');

            $term_names = [];
            if ($terms && !is_wp_error($terms)) {
                foreach ($terms as $term) {
                    $term_names[] = $term->slug;
                }
                $term_string = implode(' ', $term_names);
            }
            ?>
              <script>
            
            jQuery(document).ready(function($) {
            
                $('.grid').isotope({
  itemSelector: '.grid-item',
});
            })
        </script>
            <div class="col-lg-4 g-3 col-md-6 single-content grid-item bais <?php echo $term_string ?>" data-post-id="<?php echo get_the_ID(); ?>">
                <div class="cousebox">
                    <div class="employ"><img src="<?php the_post_thumbnail_url() ?>" class="img-fluid" alt=""></div>
                    <div class="name">
                        <h4><?php the_title(); ?></h4>
                        <div class="subtxt"><?php the_field('designation'); ?></div>
                    </div>
                    <div class="coname"><img src="<?php the_field('company'); ?>" alt=""></div>
                    <div class="content">
                        <p><?php the_field('course_undertaken'); ?></p>
                        <p><?php the_content(); ?></p>
                    </div>
                </div>
            </div>
            <?php
        }
        ?>
        
        <?php
    } else {
        echo 'No more success stories found.';
    }

    wp_die();
}
add_action('wp_ajax_load_more_placements', 'load_more_placements');
add_action('wp_ajax_nopriv_load_more_placements', 'load_more_placements');


function add_theme_options_capability() {
// Ros7Gzv4WAZ5n^n0SpmUpj8A

    $role = get_role('editor');
   
	// Add a new capability.

	$role->add_cap( 'edit_others_posts', true );
    $role->add_cap('edit_theme_options');
}
add_action('admin_init', 'add_theme_options_capability');


add_filter( 'gform_predefined_choices', 'add_predefined_choice' );
function add_predefined_choice( $choices ) {
    // Fetch courses posts
    $courses = get_posts(array(
        'post_type' => 'courses',
        'posts_per_page' => -1, // Fetch all courses
        'post_status' => 'publish'
    ));
    
    // Initialize an empty array for course titles
    $course_titles = array();

    // Loop through the courses and get their titles
    foreach ($courses as $course) {
        $course_titles[] = $course->post_title;
    }

    // Add course titles as a predefined choice in Gravity Forms
    $choices['Courses'] = $course_titles;

    return $choices;
}
// removing
remove_filter ('acf_the_content', 'wpautop');
// filter by catgory on the blog page

function filter_posts_by_category() {
    $category_id = isset($_GET['category_id']) ? intval($_GET['category_id']) : 0;

    $args = array(
        'post_type' => 'post',
        'posts_per_page' => 6,
        'post_status' => 'publish',
        'cat' => $category_id
    );

    $query = new WP_Query($args);

    if ($query->have_posts()) :
        while ($query->have_posts()) : $query->the_post();
            ?>
            <div class="col-lg-4 col-sm-6 col-6">
                <div class="blog-content">
                    <div class="imgbox">
                        <?php
                        if (has_post_thumbnail()) {
                            the_post_thumbnail('medium', array('class' => 'img-fluid'));
                        } else {
                            echo '<img src="' . get_stylesheet_directory_uri() . '/images/default-image.jpg" class="img-fluid" alt="">';
                        }
                        ?>
                    </div>
                    <div class="contentbox">
                        <h4><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
                        <div class="admin"><span>By</span> <?php the_author(); ?></div>
                        <div class="date"><?php echo get_the_date(); ?></div>
                        <div class="read"><?php echo get_field('read_time') ? get_field('read_time') : 7 ?> Min Read</div>
                    </div>
                </div>
            </div>
            <?php
        endwhile;
    else:
        echo '<p>No posts found.</p>';
    endif;
    wp_reset_postdata();

    wp_die();
}
add_action('wp_ajax_filter_posts_by_category', 'filter_posts_by_category');
add_action('wp_ajax_nopriv_filter_posts_by_category', 'filter_posts_by_category');
function custom_excerpt_length($length) {
    return 20; // Change this to the number of words you want
}
add_filter('excerpt_length', 'custom_excerpt_length');

function new_excerpt_more($more) {
    return '...';
}
add_filter('excerpt_more', 'new_excerpt_more');

function slug_custom($text) {
    // Convert to lowercase
    $slug = strtolower($text);

    // Replace spaces and special characters with underscores
    $slug = preg_replace('/[^\w]+/', '_', trim($slug));

    // Remove any leading or trailing underscores
    $slug = trim($slug, '_');

    echo $slug;
}

