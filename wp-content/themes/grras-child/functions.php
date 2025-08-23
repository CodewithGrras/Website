<?php
/**
 * Theme functions and definitions
 *
 * @package Grras Child
 */

/**
 * Load child theme css and optional scripts
 *
 * @return void
 */
 
/* Marito Functions */

function sendToNoPaperForms(array $leadData, $source = "Website", $campaign = "Website Leads", $operator = "Auto") {
    $url = 'https://api.nopaperforms.io/lead/v1/createOrUpdate';
    $headers = getNoPaperFormsHeaders();

    $commonData = buildLeadPayload($leadData, $source, $campaign, $operator);

    // Attempt 1: With email as identifier
    $payload1 = array_merge([
        "search_criteria" => "email",
        "email" => $leadData['email']
    ], $commonData);

    $response1 = callNoPaperFormsAPI($url, $headers, $payload1);

    // If failed, attempt 2: With mobile as fallback
    if ($response1['http_code'] !== 200) {
        $payload2 = array_merge([
            "search_criteria" => "mobile"
        ], $commonData);
        unset($payload2['email']);
        $payload2['field_message'] = "email : " . $leadData['email']; // embed email in message
        $response2 = callNoPaperFormsAPI($url, $headers, $payload2);
        return $response2;
    }

    return $response1;
}

function getNoPaperFormsHeaders() {
    return [
        "Content-Type: application/json",
        "secret-key: d8ca6fa80d7d44d3b59ac3c4ee7212c7",
        "access-key: 7312a817c32d45aeb06bbce7b4504b22"
    ];
}

function buildLeadPayload(array $leadData, $source, $campaign, $operator) {
    $payload = [
        "name"                      => $leadData['name'],
        "country_dial_code"         => "91",
        "mobile"                    => $leadData['mobile'],
        "field_whatsapp_number"     => "+91-" . $leadData['mobile'],
        "field_message"             => "email : " . $leadData['email'],
        //"field_courses"             => $leadData['course'],
        "field_mode_of_delivery"    => $leadData['delivery_mode'] ?? "Online",
        "field_preferred_location"  => "Jaipur - Gopalpura",
        "field_preferred_language"  => $leadData['preferred_language'] ?? "English",
        "field_website_page_url"    => $leadData['website_url'],
        "field_data_entry_operator" => $operator,
        "field_purpose"             => "Course",
        "source"                    => $source,
        "medium"                    => "NA",
        "campaign"                  => $campaign,
        //"field_category"            => $leadData['category'],
        //"field_occupation"          => $leadData['occupation']
    ];
    
    if(isset($leadData['course'])) {
        $payload['field_courses'] = $leadData['course'];    
    }
    
    if(isset($leadData['category'])) {
        $payload['field_category'] = $leadData['category'];
    }
    
    if(isset($leadData['occupation'])) {
        $payload['field_occupation'] = $leadData['occupation'];
    }
    
    
    if($leadData['category'] == 'Internship') {
        $payload['field_duration'] = $leadData['duration'];
    }
    return $payload;
}

function callNoPaperFormsAPI($url, $headers, $payload) {
    $ch = curl_init($url);
    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST           => true,
        CURLOPT_HTTPHEADER     => $headers,
        CURLOPT_POSTFIELDS     => json_encode($payload),
    ]);

    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    logNoPaperFormsRequest($payload, $response, $httpCode);

    return [
        'http_code' => $httpCode,
        'response'  => $response,
        'payload'   => $payload
    ];
}

function logNoPaperFormsRequest($payload, $response, $httpCode) {
    $logFile = WP_CONTENT_DIR . '/nopaperforms-logs/nopaper-' . date('Ymd-His') . '.log';
    $logDir = dirname($logFile);

    if (!file_exists($logDir)) {
        mkdir($logDir, 0755, true);
    }

    $log = "=== NoPaperForms API Call ===\n";
    $log .= "Time: " . date('Y-m-d H:i:s') . "\n";
    $log .= "HTTP Code: {$httpCode}\n";
    $log .= "Payload:\n" . print_r($payload, true) . "\n";
    $log .= "Response:\n" . $response . "\n";
    $log .= "============================\n\n";

    file_put_contents($logFile, $log);
}

/* Marito functions */

function grras_child_enqueue_scripts() {
    wp_enqueue_style(
        'grras-child-style',
        get_stylesheet_directory_uri() . '/style.css',
        [
            'grras-style',
        ],
        '1.0.0'
    ); 
    wp_enqueue_style(
        'grras-child-responsive',
        get_stylesheet_directory_uri() . '/css/responsive.css',
        [
            'grras-style',
        ],
        '1.0.0'
    ); 
}
add_action( 'wp_enqueue_scripts', 'grras_child_enqueue_scripts', 20 );

// ----------------------------------
function my_theme_enqueue_styles() {
    // Bootstrap CSS
    wp_enqueue_script('jquery');
    wp_enqueue_style(
        'bootstrap',
        get_stylesheet_directory_uri() . '/css/bootstrap.min.css',
        array(),
        time() // Set version to current timestamp
    );

    // Owl Carousel CSS
    wp_enqueue_style(
        'owl-carousel',
        get_stylesheet_directory_uri() . '/css/owl.carousel.min.css',
        array(),
        time() // Set version to current timestamp
    );

    // Animate CSS
    wp_enqueue_style(
        'animate',
        get_stylesheet_directory_uri() . '/css/animate.css',
        array(),
        time() // Set version to current timestamp
    );

    // Custom CSS
    // wp_enqueue_style(
    //     'custom',
    //     get_stylesheet_directory_uri() . '/css/custom.css',
    //     array(),
    //     time() // Set version to current timestamp
    // );
    // wp_enqueue_style(
    //     'aos',
    //     get_stylesheet_directory_uri() . '/css/aos.min.css',
    //     array(),
    //     time() // Set version to current timestamp
    // );
    /*wp_enqueue_style(
        'style-new',
        get_stylesheet_directory_uri() . '/css/style-new.css',
        array(),
        time() // Set version to current timestamp
    );*/

    // Google Fonts (typically doesn't need versioning)
    wp_enqueue_style(
        'google-fonts',
        'https://fonts.googleapis.com/css2?family=Merriweather:wght@400;700;900&family=Poppins:wght@300;400;500;600;700&display=swap',
        array(),
        null // No version for Google Fonts
    );
}

//add_action('wp_enqueue_scripts', 'my_theme_enqueue_styles');

/*
* Creating a function to create our CPT
*/
function my_theme_enqueue_scripts() {
    // jQuery (included with WordPress)
    wp_enqueue_script('jquery');

    // Bootstrap Bundle JS
    wp_enqueue_script(
        'bootstrap-bundle',
        get_stylesheet_directory_uri() . '/js/bootstrap.bundle.min.js',
        array('jquery'),
        time(), // Set version to current timestamp
        false // Load in footer
    );

    // Owl Carousel JS
    wp_enqueue_script(
        'owl-carousel',
        get_stylesheet_directory_uri() . '/js/owl.carousel.min.js',
        array('jquery'),
        time(), // Set version to current timestamp
        false // Load in footer
    );

    // WOW.js (for animations)
    wp_enqueue_script(
        'wow',
        get_stylesheet_directory_uri() . '/js/wow.min.js',
        array(),
        time(), // Set version to current timestamp
        false // Load in footer
    );
   
    wp_enqueue_script(
        'iospot',
        get_stylesheet_directory_uri() . '/js/isotope.pkgd.min.js',
        array(),
        time(), // Set version to current timestamp
        false // Load in footer
    );
}

add_action('wp_enqueue_scripts', 'my_theme_enqueue_scripts');

// include 'components/inc/courses.php';

// // -----------------------------------------------------------------------




// include 'components/Inc/career-stories.php';
// // ----------------------------------
// /*
// * Creating a function to create our CPT
// */
// include 'components/Inc/workshops.php';
// -----------------------------------------------------------------------
// show category name & images
function post_category_image(){
    // Get the taxonomy terms (e.g., categories or tags)
    $taxonomy = 'category'; // Change to 'post_tag' for tags
    $terms = get_terms($taxonomy);

    // Loop through each term
    foreach ($terms as $term) {
        // Get the term ID
        $term_id = $term->term_id;

        // Get the term name
        $term_name = $term->name;

        // Get the term image using ACF
        $term_image = get_field('category_image', $taxonomy . '_' . $term_id);
        
        // Display the term name and image
        if ($term_image) {
            echo '<div class="taxonomy-item">';
            echo '<a href="' . get_term_link($term_id) . '">';
            echo '<img src="' . esc_url($term_image) . '" alt="' . esc_attr($term_name) . '" />';
            echo '<h3>' . esc_html($term_name) . '</h3>';
            echo '</a>';
            echo '</div>';
        }
        
    }
    
}
add_shortcode('post_cat_image', 'post_category_image');






 add_filter( 'elementor_pro/custom_fonts/font_display', function( $current_value, $font_family, $data ) {
    return 'swap';
}, 10, 3 );


function register_my_menus() {
    register_nav_menus(
        array(
            'primary-menu' => __( 'Primary Menu' ),
        )
    );
}
add_action( 'init', 'register_my_menus' );


// 

// Custom shortcode for displaying tags related to the "courses" custom post type
function custom_courses_tags_shortcode() {
    // Get the current post's ID
    $post_id = get_the_ID();

    // Retrieve tags associated with the "courses" custom post type
    $post_tags = wp_get_post_terms($post_id, 'courses-tag');
    
    $output = '';

    // Check if tags are found
    if ($post_tags && !is_wp_error($post_tags)) {
        $total_tags = count($post_tags);
        $display_tags_count = min(5, $total_tags); // Display maximum of 5 tags

        $output .= '<ul class="courses-module-tags">';

        // Display the first 5 tags
        for ($i = 0; $i < $display_tags_count; $i++) {
            $output .= '<li><a href="' . get_term_link($post_tags[$i]->term_id, 'courses-tag') . '">' . $post_tags[$i]->name . '</a></li>';
        }

        // Check if there are more than 5 tags
        if ($total_tags > 5) {
            $remaining_tags_count = $total_tags - 5;
            for ($i = 5; $i < $total_tags; $i++) {
                $output .= '<li class="remaining-tag hidden"><a href="' . get_term_link($post_tags[$i]->term_id, 'courses-tag') . '">' . $post_tags[$i]->name . '</a></li>';
            }
            $output .= '<li class="show-more"><a href="#">More +' . $remaining_tags_count . '</a></li>';
        }

        $output .= '</ul>';
    } else {
        $output .= 'No tags found for this post.';
    }

    return $output;
}
add_shortcode('courses_tags', 'custom_courses_tags_shortcode');
    



// Classic Editor Shortcode 

add_filter('use_block_editor_for_post', '__return_false', 10);




// Book Now Functions

function book_status_toggle_shortcode($atts) {
    $atts = shortcode_atts(
        array(
            'post_id' => get_the_ID(), // Default to current post ID
            'no_link' => 'false', 
        ),
        $atts,
        'book_status_toggle'
    );

    $book_status = get_field('book_status', $atts['post_id']);

    if ($book_status == 'Open') {
        $button_text = 'Register Now';
        $new_status = 'Close';
        $button_class = 'book-open';
    } else {
        $button_text = 'Booking Close';
        $new_status = 'Open';
        $button_class = 'booking-close';
    }


    $post_url = $atts['no_link'] === 'true' ? '' : 'data-post-url="' . esc_url(get_permalink($atts['post_id'])) . '"';

    $button_html = '<button class="book-status-toggle ' . esc_attr($button_class) . '" data-post-id="' . esc_attr($atts['post_id']) . '" data-new-status="' . esc_attr($new_status) . '" ' . $post_url . '>' . esc_html($button_text) . '</button>';

    return $button_html;
}
add_shortcode('book_status_toggle', 'book_status_toggle_shortcode');



 
// Register Custom Post Type FAQ's
function register_course_faq_post_type() {

    $labels = array(
        'name'                  => _x( 'Course FAQs', 'Post Type General Name', 'text_domain' ),
        'singular_name'         => _x( 'Course FAQ', 'Post Type Singular Name', 'text_domain' ),
        'menu_name'             => __( 'Course FAQs', 'text_domain' ),
        'name_admin_bar'        => __( 'Course FAQ', 'text_domain' ),
        'archives'              => __( 'FAQ Archives', 'text_domain' ),
        'attributes'            => __( 'FAQ Attributes', 'text_domain' ),
        'parent_item_colon'     => __( 'Parent Item:', 'text_domain' ),
        'all_items'             => __( 'All FAQs', 'text_domain' ),
        'add_new_item'          => __( 'Add New FAQ', 'text_domain' ),
        'add_new'               => __( 'Add New', 'text_domain' ),
        'new_item'              => __( 'New FAQ', 'text_domain' ),
        'edit_item'             => __( 'Edit FAQ', 'text_domain' ),
        'update_item'           => __( 'Update FAQ', 'text_domain' ),
        'view_item'             => __( 'View FAQ', 'text_domain' ),
        'view_items'            => __( 'View FAQs', 'text_domain' ),
        'search_items'          => __( 'Search FAQ', 'text_domain' ),
        'not_found'             => __( 'Not found', 'text_domain' ),
        'not_found_in_trash'    => __( 'Not found in Trash', 'text_domain' ),
        'featured_image'        => __( 'Featured Image', 'text_domain' ),
        'set_featured_image'    => __( 'Set featured image', 'text_domain' ),
        'remove_featured_image' => __( 'Remove featured image', 'text_domain' ),
        'use_featured_image'    => __( 'Use as featured image', 'text_domain' ),
        'insert_into_item'      => __( 'Insert into FAQ', 'text_domain' ),
        'uploaded_to_this_item' => __( 'Uploaded to this FAQ', 'text_domain' ),
        'items_list'            => __( 'FAQs list', 'text_domain' ),
        'items_list_navigation' => __( 'FAQs list navigation', 'text_domain' ),
        'filter_items_list'     => __( 'Filter FAQs list', 'text_domain' ),
    );
    $args = array(
        'label'                 => __( 'Course FAQ', 'text_domain' ),
        'description'           => __( 'Course FAQs', 'text_domain' ),
        'labels'                => $labels,
        'supports'              => array( 'title', 'editor', 'thumbnail', 'excerpt', 'custom-fields', 'comments' ),
        'taxonomies'            => array( 'course_types' ),
        'hierarchical'          => false,
        'public'                => true,
        'show_ui'               => true,
        'show_in_menu'          => true,
        'menu_position'         => 5,
        'show_in_admin_bar'     => true,
        'show_in_nav_menus'     => true,
        'can_export'            => true,
        'has_archive'           => true,
        'exclude_from_search'   => false,
        'publicly_queryable'    => true,
        'capability_type'       => 'post',
    );
    register_post_type( 'course-faq', $args );

}
add_action( 'init', 'register_course_faq_post_type', 0 );

// Associate 'course_types' Taxonomy with 'course-faq' Post Type
function associate_course_type_taxonomy_with_course_faq() {
    register_taxonomy_for_object_type( 'course_types', 'course-faq' );
}
add_action( 'init', 'associate_course_type_taxonomy_with_course_faq' );


// Add filter dropdown on admin page
function filter_faqs_by_taxonomy() {
    global $typenow;
    $post_type = 'course-faq'; // change to your post type
    $taxonomy  = 'course_types'; // change to your taxonomy
    if ($typenow == $post_type) {
        $selected      = isset($_GET[$taxonomy]) ? $_GET[$taxonomy] : '';
        $info_taxonomy = get_taxonomy($taxonomy);
        $terms         = get_terms([
            'taxonomy'   => $taxonomy,
            'hide_empty' => true,
        ]);
        echo "<select name='$taxonomy' id='$taxonomy' class='postform'>";
        echo "<option value=''>Show All {$info_taxonomy->label}</option>";
        foreach ($terms as $term) {
            $count = (isset($_GET[$taxonomy]) && $_GET[$taxonomy] == $term->slug) ? " ($term->count)" : '';
            echo '<option value="' . esc_attr($term->slug) . '"' . selected($selected, $term->slug, false) . '>' . esc_html($term->name) . $count . '</option>';
        }
        echo "</select>";
    }
}
add_action('restrict_manage_posts', 'filter_faqs_by_taxonomy');



// Custom shortcode to display FAQs in accordion format based on current page's 'course_types' taxonomy term
function display_faqs_accordion($atts) {
    // Get current page's 'course_types' taxonomy term
    $terms = get_the_terms(get_the_ID(), 'course_types');
    if (!empty($terms) && !is_wp_error($terms)) {
        $term = array_shift($terms);
        $term_id = $term->term_id;

        // Query FAQs based on current page's 'course_types' taxonomy term
        $faqs_args = array(
            'post_type'      => 'course-faq',
            'posts_per_page' => -1,
            'tax_query'      => array(
                array(
                    'taxonomy' => 'course_types',
                    'field'    => 'id',
                    'terms'    => $term_id,
                ),
            ),
        );

        $faqs_query = new WP_Query($faqs_args);

        // Check if FAQs found
        if ($faqs_query->have_posts()) {
            $accordion_html = '<div class="faq-accordion">';
            while ($faqs_query->have_posts()) {
                $faqs_query->the_post();
                $accordion_html .= '<div class="faq-item">';
                $accordion_html .= '<h3 class="faq-question">' . get_the_title() . '<span class="toggle-icon">+</span></h3>';
                $accordion_html .= '<div class="faq-answer">' . get_the_content() . '</div>';
                $accordion_html .= '</div>';
            }
            $accordion_html .= '</div>';
        } else {
            $accordion_html = '<p>No FAQs found for this category.</p>';
        }

        // Restore original post data
        wp_reset_postdata();

        return $accordion_html;
    } else {
        return '<p>No category found for this page.</p>';
    }
}
add_shortcode('faqs_accordion', 'display_faqs_accordion');

// Enqueue script
function faqs_accordion_enqueue_script() {
    wp_enqueue_script('faq-accordion-script', get_stylesheet_directory_uri(), array('jquery'), '1.0', true);
}
//add_action('wp_enqueue_scripts', 'faqs_accordion_enqueue_script');

// Inline script for accordion functionality
function faqs_accordion_inline_script() {
    ?>
    <script type="text/javascript">
    jQuery(document).ready(function($) {
        // Hide all answers initially
        $('.faq-answer').hide();
        
        // Toggle accordion items
        $('.faq-item').on('click', '.faq-question', function() {
            $(this).toggleClass('open').next('.faq-answer').slideToggle();
            $(this).find('.toggle-icon').text(function(_, text) {
                return text === '+' ? '-' : '+';
            });
        });
    });
    </script>
    <?php
}
add_action('wp_footer', 'faqs_accordion_inline_script');


// Redirect Functions

function my_custom_redirect() {
    if (is_page('courses')) {
        error_log('Redirecting from "courses" page'); // Check error log
        wp_redirect('http://showcase.ninealgo.com/grras/course/', 301);
        exit();
    }
}
add_action('template_redirect', 'my_custom_redirect');




// Fallback Functions
function my_custom_search_fallback_image($image_html, $post_id) {
    if (is_search() && empty($image_html)) {
        // Define the URL of your fallback image
        $fallback_image_url = 'http://showcase.ninealgo.com/grras/wp-content/uploads/2024/05/Degree-Program-1.jpg';

        // Generate the image HTML
        $image_html = '<img src="' . esc_url($fallback_image_url) . '" alt="' . esc_attr(get_the_title($post_id)) . '">';
    }
    return $image_html;
}
add_filter('elementor_pro/utils/get_the_post_thumbnail', 'my_custom_search_fallback_image', 10, 2);


// Greadint color Functions
// function add_custom_gradient_css() {
//     if (is_singular('courses')) {
//         $color1 = get_post_meta(get_the_ID(), 'color1', true);
//         if ($color1) {
//             echo "
//                 <style>
//                 .post-id-" . get_the_ID() . " .all-colors-shades {
//                     background: linear-gradient(to right, {$color1}, {$color2}) !important;
//                 }
//                 </style>
//             ";
//         }
//     }
// }
// add_action('wp_head', 'add_custom_gradient_css');




// Enqueue custom scripts and localize for AJAX
function enqueue_custom_scripts() {
    //wp_enqueue_script('custom-popup-script', get_template_directory_uriget_template_directory_uri, array('jquery'), null, true);

    // Localize script to pass AJAX URL and nonce
    wp_localize_script('custom-popup-script', 'ajax_object', array(
        'ajax_url' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('popup_content_nonce')
    ));
}
add_action('wp_enqueue_scripts', 'enqueue_custom_scripts');




// Handle AJAX request for post content
function fetch_post_content() {
    check_ajax_referer('popup_content_nonce', 'nonce');

    $post_id = intval($_POST['post_id']);
    $post = get_post($post_id);

    if ($post && $post->post_type == 'case-study') {
        $content = apply_filters('the_content', $post->post_content);
        wp_send_json_success(array(
            'content' => $content,
        ));
    } else {
        wp_send_json_error(array(
            'message' => 'Post not found or invalid post type',
        ));
    }
}




add_action('wp_ajax_fetch_post_content', 'fetch_post_content');
add_action('wp_ajax_nopriv_fetch_post_content', 'fetch_post_content');

// Shortcode for the Read More button
function case_study_read_more_button($atts) {
    // Get current post ID
    $post_id = get_the_ID();
    
    // Output button HTML
    return '<button id="popup-content" class="case-study-read-more" data-post-id="' . esc_attr($post_id) . '">Read full story ></button>';
}
add_shortcode('case_study_button', 'case_study_read_more_button');

// Shortcode for placeholder div in the popup
function case_study_popup_placeholder_shortcode() {
    return '<div id="case-study-popup-content"></div>';
}
add_shortcode('case_study_popup_placeholder', 'case_study_popup_placeholder_shortcode');


include 'components/Inc/them-function.php'; 

add_action( 'gform_after_submission', 'after_submission', 10, 2 );
function after_submission( $entry, $form ) {
    ?>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var modalHTML = `
               <!-- Thank you -->
   <div class="modal fade show" id="exampleModalsub" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" style="display: block">
  <div class="modal-dialog thankpage">
    <div class="modal-content">
      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" 
              onclick="(function() {
                        document.getElementById('exampleModalsub').classList.remove('show');
                        document.getElementById('exampleModalsub').style.display = 'none';
                      })();"></button>

          <div class="modal-body text-center">
            <div class="row">
              <div class="col-lg-12">
                <dotlottie-player
                  src="https://lottie.host/f2262720-afbe-4a60-a226-a43f78cd7cf4/ruddE3yOJa.lottie"
                  background="transparent"
                  speed="0.8"
                  style="width: 300px; height: 300px; margin: -50px auto 0 auto;"
                  autoplay>
                </dotlottie-player>

                <h2>Thank you</h2>
                <p>Your form has been successfully submitted.<br>We’ve received your information, & our team will contact you shortly.</p>
                <a href="/" class="btn btn-outline-primary">Back to site</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
               `;
            
            document.body.insertAdjacentHTML('afterbegin', modalHTML);
            var exampleModal = document.getElementById('exampleModalsub');
            exampleModal.classList.add('show');
            exampleModal.style.display = 'block';
            document.getElementById('close-btnsh').addEventListener('click', function() {
    let exampleModal = document.getElementById('exampleModalsub');
                exampleModal.classList.remove('show');
                exampleModal.style.display = 'none';
            });
            document.getElementById('exampleModalsub').addEventListener('click', function() {
                let exampleModal = document.getElementById('exampleModalsub');
                
                exampleModal.classList.remove('show');
                exampleModal.style.display = 'none';
            });
        });
    </script>
    <?php
}

/////////////////  Download Pdf on Submitting Gravity Form (Course Detail Page)  /////////////////
add_filter('gform_confirmation_22', function($confirmation, $form, $entry) {

    $post_id = rgar($entry, '10'); // hidden field id
    $pdf_url = null;
    if(is_front_page()) {
        $pdf_url = get_field('download_placement_report', $post_id); // Change 'course_pdf' to your actual ACF field name
    } else {
        $pdf_url = get_field('download_brochure', $post_id); // Change 'course_pdf' to your actual ACF field name    
    }
    if (empty($pdf_url)) {
        $pdf_url = site_url('/wp-content/uploads/sample.pdf'); // Default PDF if none exists
    }


    //$download_url = get_stylesheet_directory_uri().'/download_pdf.php?file=' . urlencode($pdf_url);
    $confirmation = "<script>window.open('$pdf_url', '_blank');</script>";

    return $confirmation;
}, 10, 3);

add_filter('gform_confirmation_21', function($confirmation, $form, $entry) {

    /*$data = [
        'form' => $form,
        'entry' => $entry
    ];
    $timestamp = time();
    $log_filename = "gform-entry-21-{$timestamp}.log";
    $log_path = WP_CONTENT_DIR . '/'.$log_filename;
    $log_content = "=== Entry Submitted on " . date('Y-m-d H:i:s') . " ===\n<pre>";
    $log_content .= print_r($data, true);
    $log_content .= "</pre>\n=============================\n\n";

    file_put_contents($log_path, $log_content, FILE_APPEND | LOCK_EX);*/
    
    $occupation = '';
    if($entry[8] == 'Working Professional' || $entry[8] == 'Student') {
        $occupation = $entry[8];
    } else {
        $occupation = 'Others';
    }
    $lead = [
        'name' => $entry[4],
        'email' => $entry[1],
        'mobile' => $entry[5],
        'course' => $entry[6],
        'category' => 'Internship',
        'occupation' => $occupation,
        'website_url' => $entry['source_url'],
        'duration' => $entry[7]
    ];
    
    $response = sendToNoPaperForms($lead, 'Grras Website Internship-Page');
    
    $post_id = rgar($entry, '10'); // hidden field id
    $pdf_id = get_field('banner_download_brochure', $post_id); // Change 'course_pdf' to your actual ACF field name
    $pdf_url = !empty($pdf_id) ? wp_get_attachment_url($pdf_id) : null;
    if (empty($pdf_url)) {
        $pdf_url = site_url('/wp-content/uploads/sample.pdf'); // Default PDF if none exists
    } 


    //$download_url = get_stylesheet_directory_uri().'/download_pdf.php?file=' . urlencode($pdf_url);
    $confirmation = "<script>window.open('$pdf_url', '_blank');</script>";

    return $confirmation;
}, 10, 3);

/////////////////  Download Pdf on Submitting Gravity Form (Home Page)  /////////////////
/*add_filter('gform_confirmation_22', function($confirmation, $form, $entry) {

    $post_id = rgar($entry, '10'); // hidden field id
    $pdf_url = get_field('download_placement_report', $post_id); // Change 'course_pdf' to your actual ACF field name
    if (!$pdf_url) {
        $pdf_url = site_url('/wp-content/uploads/sample.pdf'); // Default PDF if none exists
    }


    //$download_url = get_stylesheet_directory_uri().'/download_pdf.php?file=' . urlencode($pdf_url);
    $confirmation = "<script>window.open('$pdf_url', '_blank');</script>";

    return $confirmation;
}, 10, 3);*/

/////////////////  Download Pdf on Submitting Gravity Form (Placement Page)  /////////////////
/*add_filter('gform_confirmation_22', function($confirmation, $form, $entry) {

    $post_id = rgar($entry, '10'); // hidden field id

	$group_field = get_field('stories_from_people', $post_id);
	
	if ($group_field) {
		$sub_field_value = $group_field['download_placement_brochure'];
		$pdf_url = $sub_field_value;
	}
	
    if (!$pdf_url) {
        $pdf_url = site_url('/wp-content/uploads/sample.pdf'); // Default PDF if none exists
    }


    //$download_url = get_stylesheet_directory_uri().'/download_pdf.php?file=' . urlencode($pdf_url);
    $confirmation = "<script>window.open('$pdf_url', '_blank');</script>";

    return $confirmation;
}, 10, 3);*/

add_filter('gform_confirmation_7', function($confirmation, $form, $entry) {
    $event = rgar($entry, '15'); // hidden field id
    if ($event == 'past') {
        $post_id = get_the_ID(); // Make sure you have the correct $post_id
        
        $past_workshops_resources = get_field('past_workshops_resources', $post_id);
        if ($past_workshops_resources) {
            $download_script = "<script>";
            
            foreach ($past_workshops_resources as $item) {
                if (!empty($item['resources'])) {
                    $file_url = $item['resources'];
                    // Add each file to download queue
                    $download_script .= "
                    (function(url) {
                        var link = document.createElement('a');
                        link.href = url;
                        link.download = url.split('/').pop();
                        link.style.display = 'none';
                        document.body.appendChild(link);
                        link.click();
                        setTimeout(function() {
                            document.body.removeChild(link);
                        }, 100);
                    })('" . esc_js($file_url) . "');";
                }
            }
            
            $download_script .= "</script>";
            
            // Add the download script to confirmation message
            if (is_string($confirmation)) {
                $confirmation .= $download_script;
            } else {
                // If confirmation is an array (e.g., with a redirect)
                // We need to modify approach to use a message confirmation instead
                $confirmation = "<p>Thank you for your submission.</p>" . $download_script;
            }
        }
    }
    return $confirmation; 
}, 10, 3);

add_filter('gform_confirmation_18', function($confirmation, $form, $entry) {
    /*$data = [
        'form' => $form,
        'entry' => $entry
    ];
    $timestamp = time();
    $log_filename = "gform-entry-18-{$timestamp}.log";
    $log_path = WP_CONTENT_DIR . '/'.$log_filename;
    $log_content = "=== Entry Submitted on " . date('Y-m-d H:i:s') . " ===\n<pre>";
    $log_content .= print_r($data, true);
    $log_content .= "</pre>\n=============================\n\n";

    file_put_contents($log_path, $log_content, FILE_APPEND | LOCK_EX);*/
    
    $occupation = '';
    if($entry[18] == 'Working Professional' || $entry[18] == 'Student') {
        $occupation = $entry[18];
    } else {
        $occupation = 'Others';
    }
    $lead = [
        'name' => $entry[3],
        'email' => $entry[20],
        'mobile' => $entry[17],
        'course' => $entry[19],
        'occupation' => $occupation,
        'category' => '',
        'website_url' => $entry[11]
    ];
    
    $response = sendToNoPaperForms($lead);

    return $confirmation;
}, 10, 3);

add_filter('gform_confirmation_1', function($confirmation, $form, $entry) {
    /*$data = [
        'entry' => $entry
    ];
    $timestamp = time();
    $log_filename = "gform-entry-1-{$timestamp}.log";
    $log_path = WP_CONTENT_DIR . '/'.$log_filename;
    $log_content = "=== Entry Submitted on " . date('Y-m-d H:i:s') . " ===\n<pre>";
    $log_content .= print_r($data, true);
    $log_content .= "</pre>\n=============================\n\n";

    file_put_contents($log_path, $log_content, FILE_APPEND | LOCK_EX);*/
    
    
    $lead = [
        'name' => $entry[6],
        'email' => $entry[2],
        'mobile' => preg_replace('/\D+/', '', $entry[5]),
        'category' => '',
        'website_url' => $entry['source_url']
    ];
    
    $response = sendToNoPaperForms($lead, 'Grras Website');

    return $confirmation;
}, 10, 3);

function get_total_partner_count($term_slug) {
    $query = new WP_Query([
        'post_type'      => 'partners',
        'post_status'    => 'publish',
        'fields'         => 'ids',
        'tax_query'      => [[
            'taxonomy' => 'partner-type',
            'field'    => 'slug',
            'terms'    => $term_slug,
        ]],
    ]);
        return $query->found_posts;
}

/*function remove_course_slug_rewrite() {
    add_rewrite_rule(
        '^([^/]+)?$',
        'index.php?post_type=courses&name=$matches[1]',
        'top'
    );
}
add_action('init', 'remove_course_slug_rewrite');

function detect_course_post_type($query_vars) {
    if (!isset($query_vars['post_type']) && isset($query_vars['name'])) {
        global $wpdb;
        $slug = $query_vars['name'];

        // Check if it's a 'course' post
        $exists = $wpdb->get_var($wpdb->prepare(
            "SELECT ID FROM $wpdb->posts WHERE post_name = %s AND post_type = 'courses' LIMIT 1",
            $slug
        ));

        if ($exists) {
            $query_vars['post_type'] = 'courses';
        }
    }

    return $query_vars;
}
add_filter('request', 'detect_course_post_type');

function redirect_old_course_urls() {
    if (is_singular('courses') && strpos($_SERVER['REQUEST_URI'], '/course/') > 0) {
        wp_redirect(home_url('/' . get_post_field('post_name', get_post())), 301);
        exit;
    }
}
add_action('template_redirect', 'redirect_old_course_urls');*/

function limitTextHtml($full_text, $limit = 200) {
    // Remove block-level tags that cannot go inside <span>
    $allowed_tags = '<span><b><strong><i><em><u><a><br>';
    $inline_safe_html = strip_tags($full_text, $allowed_tags);

    // Decode HTML entities for safe mb_substr
    $text_content = html_entity_decode(strip_tags($inline_safe_html));
    
    $short_text = mb_substr($text_content, 0, $limit);
    $is_long = mb_strlen($text_content) > $limit;

    // Encode again for HTML output
    $short_text_encoded = htmlentities($short_text);
    $remaining_text_encoded = htmlentities(mb_substr($text_content, $limit));

    // Wrap in span-based layout
    $html  = '<span class="short-text">' . $short_text_encoded . '</span>';
    if ($is_long) {
        $html .= '<span class="dots">...</span>';
        $html .= '<span class="more-text d-none">' . $remaining_text_encoded . '</span>';
        $html .= '<a href="javascript:void(0);" class="theme-text-primary fw-semibold text-decoration-none toggle-more p-1">Read more</a>';
    }

    return $html;
}

add_action('wp_ajax_load_more_academic_partners', 'load_more_academic_partners');
add_action('wp_ajax_nopriv_load_more_academic_partners', 'load_more_academic_partners');

function load_more_academic_partners() {
    $offset = isset($_POST['offset']) ? intval($_POST['offset']) : 0;
    $slug = sanitize_text_field($_POST['slug']);

    $query = new WP_Query([
        'post_type'      => 'partners',
        'post_status'    => 'publish',
        'posts_per_page' => 8,
        'offset'         => $offset,
        'tax_query'      => [[
            'taxonomy' => 'partner-type',
            'field'    => 'slug',
            'terms'    => $slug,
        ]],
    ]);

    if ($query->have_posts()) :
        while ($query->have_posts()): $query->the_post(); ?>
            <div class="col-6 col-md-4 col-lg-3 col-xl-3 mb-4">
              <div class="trackbox text-center p-4 border-0">
                <?php if (has_post_thumbnail()): ?>
                  <img src="<?php echo esc_url(get_the_post_thumbnail_url(get_the_ID(), 'medium')); ?>" alt="<?php the_title_attribute(); ?>" class="img-fluid">
                <?php endif; ?>
                <p><?php the_title(); ?></p>
                <a class="verify-btn" href="<?php echo get_field('verify_auth_link'); ?>" <?php if(!empty(get_field('verify_auth_link'))) { echo 'target="_blank"'; } ?>>Verify Authorisation</a>
              </div>
            </div>
        <?php endwhile;
        wp_reset_postdata();
    endif;

    wp_die(); // Required to properly terminate AJAX
}

// AJAX handler for loading more corporate partners
add_action('wp_ajax_load_more_corporate_partners', 'ajax_load_more_corporate_partners');
add_action('wp_ajax_nopriv_load_more_corporate_partners', 'ajax_load_more_corporate_partners');

function ajax_load_more_corporate_partners() {
    $page = isset($_POST['page']) ? intval($_POST['page']) : 1;
    $per_page = 10;
    $corporate_slug = 'corporate-partner';

    $query = new WP_Query([
        'post_type'      => 'partners',
        'post_status'    => 'publish',
        'posts_per_page' => $per_page,
        'paged'          => $page,
        'tax_query'      => [[
            'taxonomy' => 'partner-type',
            'field'    => 'slug',
            'terms'    => $corporate_slug,
        ]],
    ]);

    ob_start();

    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post(); ?>
            <div class="imgbox text-center bg-white">
                <?php if (has_post_thumbnail()): ?>
                    <img src="<?php echo esc_url(get_the_post_thumbnail_url(get_the_ID(), 'medium')); ?>" alt="<?php the_title_attribute(); ?>" class="img-fluid p-3">
                <?php endif; ?>
                <div class="fw-semibold name p-3"><?php the_title(); ?></div>
            </div>
            <?php
        }
        wp_reset_postdata();
    }

    $html = ob_get_clean();

    $total_posts = get_total_partner_count($corporate_slug);
    $has_more = ($page * $per_page) < $total_posts;
    $remaining = max(0, $total_posts - ($page * $per_page));

    wp_send_json_success([
        'html'      => $html,
        'has_more'  => $has_more,
        'remaining' => $remaining,
    ]);
}

add_action('wp_ajax_load_more_awards', 'ajax_load_more_awards');
add_action('wp_ajax_nopriv_load_more_awards', 'ajax_load_more_awards');

function ajax_load_more_awards() {
    $page = isset($_POST['page']) ? intval($_POST['page']) : 1;
    $year = isset($_POST['year']) ? intval($_POST['year']) : date('Y');
    $per_page = 9;

    $query = new WP_Query([
        'post_type'      => 'awards',
        'post_status'    => 'publish',
        'posts_per_page' => $per_page,
        'paged'          => $page,
        'date_query'     => [[
            'year' => $year,
        ]],
    ]);

    ob_start();

    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post(); ?>
            <div class="col-12 col-md-6 col-lg-4">
                <div class="awardbox p-3 text-center mb-4">
                    <div class="image-box pb-md-3 mb-md-3 border-bottom">
                        <?php if (has_post_thumbnail()): ?>
                            <img src="<?php echo esc_url(get_the_post_thumbnail_url(get_the_ID(), 'medium')); ?>" class="img-fluid" alt="<?php the_title_attribute(); ?>">
                        <?php endif; ?>
                    </div>
                    <div class="content">
                        <h5 class="color-black fw-bold"><?php the_title(); ?></h5>
                        <p><?php echo wp_kses_post(get_the_excerpt()); ?></p>
                        <a href="<?php the_permalink(); ?>" class="theme-text-primary fw-medium text-decoration-none">Learn more</a>
                    </div>
                </div>
            </div>
            <?php
        }
        wp_reset_postdata();
    }

    // Count total posts for this year
    $count_query = new WP_Query([
        'post_type'   => 'awards',
        'post_status' => 'publish',
        'posts_per_page' => -1,
        'date_query' => [[
            'year' => $year,
        ]],
    ]);

    $total_awards = $count_query->found_posts;
    $has_more = ($page * $per_page) < $total_awards;
    $remaining = max(0, $total_awards - ($page * $per_page));

    wp_send_json_success([
        'html'      => ob_get_clean(),
        'has_more'  => $has_more,
        'remaining' => $remaining,
    ]);
}

add_action('wp_ajax_search_courses', 'ajax_search_courses');
add_action('wp_ajax_nopriv_search_courses', 'ajax_search_courses');

function ajax_search_courses() {
    $term = sanitize_text_field($_GET['term']);

    $args = array(
        'post_type' => 'courses',
        'posts_per_page' => -1,
        's' => $term,
        'tax_query' => array(
            array(
                'taxonomy' => 'city',
                'field'    => 'term_id',
                'terms'    => get_terms(array(
                    'taxonomy'   => 'city',
                    'fields'     => 'ids',
                    'hide_empty' => false,
                )),
                'operator' => 'NOT IN',
            ),
        ),
    );

    $query = new WP_Query($args);

    ob_start();

    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
            ?>
            <div class="col-lg-4 col-md-4 col-sm-6 col-6 g-3">
                <?php get_template_part('template-parts/details', 'course'); ?>
            </div>
            <?php
        }
    } else {
        echo '<p>No courses found.</p>';
    }

    wp_reset_postdata();

    echo ob_get_clean();
    wp_die();
}

add_action('wp_ajax_redhat_filter_courses', 'redhat_filter_courses');
add_action('wp_ajax_nopriv_redhat_filter_courses', 'redhat_filter_courses');

function redhat_filter_courses() {
    $search = sanitize_text_field($_POST['search']);
    $device = $_POST['device'] === 'mobile' ? 'mobile' : 'desktop';

    $tax_query = ['relation' => 'AND'];
    $taxonomies = ['types_of_offerings', 'certification_path', 'product_lines', 'products'];
    
    $mapPostToTaxes = [
        'offering'      => 'types_of_offerings',
        'certification' => 'certification_path',
        'productline'   => 'product_lines',
        'product'       => 'products'
    ];

    foreach ($mapPostToTaxes as $taxkey => $taxSlug) {
        if (!empty($_POST[$taxkey])) {
            $redhatTerms = array_map('intval', explode(',', $_POST[$taxkey]));
            $tax_query[] = [
                'taxonomy' => $taxSlug,
                'field'    => 'term_id',
                'terms'    => $redhatTerms,
                'operator' => 'IN' 
            ];
        }
    }

    $args = [
        'post_type'      => 'redhat_courses',
        'posts_per_page' => -1,
        's'              => $search,
        'tax_query'      => count($tax_query) > 1 ? $tax_query : [],
    ];
    //echo "<pre>"; print_r($args); die;

    $query = new WP_Query($args);

    ob_start();
    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();

            $course_id = get_the_ID();
            $course_image = get_the_post_thumbnail_url();
            $course_title = get_the_title();
            $content = get_the_content();
            $course_duration = get_field('days');
            $term_names = [];
            $terms = get_the_terms($course_id, 'red_hat_category');
            
            $course_code = get_field('course_code');
            $specialization = get_field('course_specialization');
            $rating = get_field('rating'); // e.g. 5
            $rating_count = get_field('review_count'); // e.g. 21
            $duration = get_field('days'); // e.g. "30 Day"
            $icon = get_field('course_icon'); // ACF image
            $featured_img = get_the_post_thumbnail_url(get_the_ID(), 'full');
            if ($terms) {
                foreach ($terms as $term) {
                    $term_names[] = $term->name;
                }
            }

            if ($device === 'desktop') {
                ?>
                <div class="col-lg-4 col-md-4 col-sm-6 col-6 g-3">
                    <div class="cobox">
                        <div class="imgbox">
                            <img src="<?php echo esc_url(get_field('mobile_background_image')); ?>" class="img-fluid bigimg" alt="">
                            <div class="imgcontent">
                                <div class="icon"><img src="<?php echo esc_url($course_image); ?>" class="img-fluid" alt=""></div>
                                <h4><small><?php echo esc_html($term_names[0] ?? ''); ?></small><br><?php echo esc_html($course_title); ?></h4>
                            </div>
                            <?php if (get_field('best_seller')) : ?>
                                <div class="<?php echo esc_attr(get_field('best_seller_color')); ?>"><?php echo esc_html(get_field('best_seller')); ?></div>
                            <?php endif; ?>
                            <?php if (get_field('discount')) : ?>
                                <div class="offer"><?php echo esc_html(get_field('discount')); ?><span>%</span> OFF</div>
                            <?php endif; ?>
                        </div>
                        <div class="content">
                            <p><a href="<?php the_permalink(); ?>" class="two_line"> <?php echo wp_trim_words($content, 20); ?></a></p>
                        </div>
                        <div class="content line">
                            <h5>Skills</h5>
                            <ul>
                                <?php
                                $skills = get_the_terms($course_id, 'skills');
                                $count = 0;
                                if ($skills && !is_wp_error($skills)) {
                                    foreach ($skills as $skill) {
                                        if ($count++ < 4) {
                                            echo '<li>' . esc_html($skill->name) . '</li>';
                                        }
                                    }
                                }
                                if ($count > 4) {
                                    echo '<li>More +' . ($count - 4) . '</li>';
                                }
                                ?>
                            </ul>
                        </div>
                        <div class="content line">
                            <div class="row">
                                <div class="col-md-6 col-6">
                                    <div class="star"><a href="#"><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/star.svg" alt=""></a> 5/5 <span>(21)</span></div>
                                </div>
                                <div class="col-md-6 col-6">
                                    <div class="day"><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/days.svg" alt=""> <?php echo esc_html($course_duration); ?> Days</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
            } else {
                // Simplified mobile output (or repeat desktop markup if mobile card is identical)
                ?>
                <div class="cobox mt-3">
                <div class="imgbox">
                  <img src="<?php echo get_stylesheet_directory_uri() ?>/images/red-coursem.png" class="img-fluid bigimg" alt="">
                  <div class="imgcontent">
                    <div class="icon">
                        <img src="<?php echo esc_url($featured_img); ?>" class="img-fluid" alt="">
                    </div>
                  </div>
                </div>
                <div class="right-content">
                  <h4>
                    <small><?php the_title(); ?></small><br>
                    <?php echo esc_html($course_code); ?>
                  </h4>
                  <p><a href="<?php the_permalink(); ?>"><?php echo esc_html($specialization); ?></a></p>
                  <div class="content">
                    <div class="row">
                      <div class="col-md-6 col-6">
                        <div class="star">
                          <a href="#"><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/star.svg" alt=""></a>
                          <?php echo esc_html($rating); ?>/5 <span>(<?php echo esc_html($rating_count); ?>)</span>
                        </div>
                      </div>
                      <div class="col-md-6 col-6">
                        <div class="day">
                          <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/days.svg" alt="">
                          <?php echo esc_html($duration); ?>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
                <?php
            }
        }
    } else {
        echo '<div class="col-md-12">No courses found.</div>';
    }
    wp_reset_postdata();
    
    echo ob_get_clean();
    wp_die();
}


function custom_courses_display_shortcode($atts) {
    ob_start();

    // Shortcode attributes
    $atts = shortcode_atts(array(
        'type_id' => '',
        'show_title' => true,
        'show_desc' => true,
        'button_text' => 'Explore more courses',
        'button_page_slug' => 'course'
    ), $atts);

    // Prepare query args
    $args = array(
        'post_type' => 'courses',
        'posts_per_page' => 6,
        'tax_query' => array(
            array(
                'taxonomy' => 'city',
                'field'    => 'term_id',
                'terms'    => get_terms(array(
                    'taxonomy' => 'city',
                    'fields'   => 'ids',
                )),
                'operator' => 'NOT IN',
            ),
        )
    );

    // Add course_types filter if provided
    if (!empty($atts['type_id'])) {
        $args['tax_query'][] = array(
            'taxonomy' => 'course_types',
            'field'    => 'id',
            'terms'    => $atts['type_id'],
        );
    }

    $query = new WP_Query($args);
    echo "<div class='row'>";
    ?>
    <div class="col-12">
        <?php if(!empty($atts['type_id'])) {
                $term = get_term($atts['type_id']);
            ?>
            <?php if($atts['show_title'] === true) { ?>
            <h6 class="mb-1"><?php echo esc_html($term->name) ?></h6>
            <?php } ?>
            
            <?php if($atts['show_desc'] === true) { ?>
            <p class="unstyled f12 mt-0"><?php echo esc_html($term->description) ?></p>
            <?php } ?>
        <?php } ?>
    </div>
    <?php
    if ($query->have_posts()) :
        
        while ($query->have_posts()) : $query->the_post();

            // Get first term from taxonomy for display
            $terms = get_the_terms(get_the_ID(), 'course_types');
            $term_name = !empty($terms) && !is_wp_error($terms) ? $terms[0]->name : '';

            ?>
            <div class="col-lg-6 col-12">
            <a href="<?php the_permalink(); ?>">
                <div class="cobox">
                    <div class="imgbox">
                        <img src="<?php echo esc_url(get_field('mobile_background_image')); ?>" class="img-fluid bigimg" alt="">
                        <div class="imgcontent">
                            <div class="icon"><img src="<?php echo esc_url(get_the_post_thumbnail_url()); ?>" class="img-fluid" alt=""></div>
                        </div>
                        <?php if (get_field('discount')) : ?>
                            <div class="offer"><?php echo esc_html(get_field('discount')); ?><span>%</span> OFF</div>
                        <?php endif; ?>
                    </div>

                    <div class="right-content">
                        <div class="<?php echo esc_attr(get_field('best_seller_color')); ?>">
                            <?php echo esc_html(get_field('best_seller')); ?>
                        </div>
                        <h4><small><?php echo esc_html($term_name); ?></small><br><span><?php the_title(); ?></span></h4>
                        <p><?php the_content(); ?></p>

                        <div class="content">
                            <div class="row align-items-center">
                                <div class="col-md-9 col-9 align-self-center">
                                    <div class="star">
                                        <?php
                                        $rating = get_field('rating');
                                        for ($i = 1; $i <= $rating; $i++) {
                                            echo '<span class="star star-enabled">★</span>';
                                        }
                                        ?>
                                        &nbsp;  <span><?php echo esc_html($rating); ?>/5 (<?php echo esc_html(get_field('review_count')); ?>)</span>
                                    </div>
                                </div>
                                <div class="col-md-3 col-3 px-0">
                                    <div class="day text-start">
                                        <img src="<?php echo esc_url(get_stylesheet_directory_uri() . '/images/hours.svg'); ?>" alt="">
                                        <span><?php echo esc_html(get_field('course_hours')); ?> hrs</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </a>    
            </div>
            
            <?php

        endwhile;
        wp_reset_postdata();
        
    else :
        //echo '<p>No courses found.</p>';
    endif;
    if(!empty($atts['button_text']) && !empty($atts['button_page_slug'])):
        $page = get_page_by_path($atts['button_page_slug']);
        $page_url = '#';
        if ( $page ) {
            $page_url = get_permalink( $page->ID );
        }
    ?>
    
    <a href="<?php echo $page_url; ?>" class="mt-2" style="color: inherit;">
        <span class="svg-icon">
            <svg viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg" width="16px" height="16px" fill="CurrentColor"><path d="m29.71 16.71-9 9a1 1 0 0 1 -1.42 0 1 1 0 0 1 0-1.42l7.3-7.29h-24.59a1 1 0 0 1 0-2h24.59l-7.3-7.29a1 1 0 0 1 1.42-1.42l9 9a1 1 0 0 1 0 1.42z"></path></svg>
        </span>
        <span class="item-title ms-2 fw-normal f-12 text-decoration-underline"><?php echo $atts['button_text']; ?></span>
    </a>
    <?php
    endif;
    echo "</div>";

    return ob_get_clean();
}
add_shortcode('courses_display', 'custom_courses_display_shortcode');

function header_ads_banner_shortcode($atts) {
    $header_ads_banner = get_field('header_ads_banner', 'option');
    
    $atts = shortcode_atts(array(
        'button_text' => '',
        'button_page_slug' => ''
    ), $atts);
    
    $button_text = sanitize_text_field($atts['button_text']);
    $button_page_slug  = sanitize_text_field($atts['button_page_slug']);

    if (!$header_ads_banner) return '';

    ob_start();
    ?> 
    <div class="addbox">
        <?php if (!empty($header_ads_banner['title'])) : ?>
            <h3><?php echo esc_html($header_ads_banner['title']); ?></h3>
        <?php endif; ?>

        <?php if (!empty($header_ads_banner['sub_title'])) : ?>
            <p><?php echo esc_html($header_ads_banner['sub_title']); ?></p>
        <?php endif; ?>

        <?php if (!empty($header_ads_banner['image'])) : ?>
            <img src="<?php echo esc_url($header_ads_banner['image']); ?>" class="img-fluid" alt="">
        <?php endif; ?>
        
    </div>
    <?php
    return ob_get_clean();
}
add_shortcode('header_add_banner', 'header_ads_banner_shortcode');

function grras_grid_display_shortcode($atts) {
    ob_start();
    $hoursKey = 'hours';
    
    // Shortcode attributes
    $atts = shortcode_atts(array(
        'post_type' => 'courses',
        'taxonomy'  => '',       // accepts 'course_types', 'internship_types', etc.
        'type_id'   => '',        // term ID to filter,
        'show_title' => true,
        'show_desc' => true,
        'override_title' => '',
        'override_desc' => '',
        'button_text' => '',
        'button_page_slug' => ''
    ), $atts);

    $post_type = sanitize_text_field($atts['post_type']);
    $taxonomy  = sanitize_text_field($atts['taxonomy']);
    $type_id   = intval($atts['type_id']);

    // Prepare query args
    $args = array(
        'post_type'      => $post_type,
        'posts_per_page' => 6,
    );

    $tax_query = array();

    // Optional: exclude all 'city' terms for post_type 'courses'
    if ($post_type === 'courses') {
        $tax_query[] = array(
            'taxonomy' => 'city',
            'field'    => 'term_id',
            'terms'    => get_terms(array(
                'taxonomy' => 'city',
                'fields'   => 'ids',
            )),
            'operator' => 'NOT IN',
        );
        $hoursKey = 'course_hours';
    }

    // Add custom taxonomy filter if provided
    if (!empty($taxonomy) && !empty($type_id)) {
        $tax_query[] = array(
            'taxonomy' => $taxonomy,
            'field'    => 'id',
            'terms'    => $type_id,
        );
    }

    if (!empty($tax_query)) {
        $args['tax_query'] = $tax_query;
    }

    $query = new WP_Query($args);

    echo "<div class='row'>";
    ?>
    <div class="col-12">
        <?php if(!empty($atts['type_id'])) {
                $term = get_term($atts['type_id']);
            ?>
            <?php if($atts['show_title'] === true) { ?>
            <h6 class="mb-1"><?php echo !empty($atts['override_title']) ? $atts['override_title'] : esc_html($term->name); ?></h6>
            <?php } ?>
            
            <?php if($atts['show_desc'] === true) { ?>
            <p class="unstyled f12 mt-0"><?php echo esc_html($term->description); ?></p>
            <?php } ?>
        <?php } else { ?>
            <?php if($atts['show_title'] === true && !empty($atts['override_title'])) { ?>
            <h6 class="mb-1"><?php echo $atts['override_title']; ?></h6>
            <?php } ?>
            <?php if($atts['show_desc'] === true && !empty($atts['override_desc'])) { ?>
            <p class="unstyled f12 mt-0"><?php echo esc_html($atts['override_desc']); ?></p>
            <?php } ?>
        <?php } ?>
    </div>
    <?php
    if ($query->have_posts()) :
        while ($query->have_posts()) : $query->the_post();

            // Get first term name for display (from provided taxonomy)
            $terms = get_the_terms(get_the_ID(), $taxonomy);
            $term_name = !empty($terms) && !is_wp_error($terms) ? $terms[0]->name : '';

            ?>
            <div class="col-lg-6 col-12">
                <a href="<?php the_permalink(); ?>">
                    <div class="cobox">
                        <div class="imgbox">
                            <img src="<?php echo esc_url(get_field('mobile_background_image')); ?>" class="img-fluid bigimg" alt="">
                            <div class="imgcontent">
                                <div class="icon">
                                    <img src="<?php echo esc_url(get_the_post_thumbnail_url()); ?>" class="img-fluid" alt="">
                                </div>
                            </div>
                            <?php if (get_field('discount')) : ?>
                                <div class="offer"><?php echo esc_html(get_field('discount')); ?><span>%</span> OFF</div>
                            <?php endif; ?>
                        </div>

                        <div class="right-content">
                            <?php if(!empty(get_field('best_seller'))): ?>
                            <div class="<?php echo esc_attr(get_field('best_seller_color')); ?>">
                                <?php echo esc_html(get_field('best_seller')); ?>
                            </div>
                            <?php endif; ?>
                            <h4><small><?php echo esc_html($term_name); ?></small><br><?php the_title(); ?></h4>
                            <p><?php the_content(); ?></p>

                            <div class="content">
                                <div class="row align-items-center">
                                    <div class="col-md-9 col-9 align-self-center">
                                        <div class="star">
                                            <?php
                                            $rating = get_field('rating');
                                            for ($i = 1; $i <= $rating; $i++) {
                                                echo '<span class="star star-enabled">★</span>';
                                            }
                                            ?>
                                            &nbsp;<span><?php echo esc_html($rating); ?>/5 (<?php echo esc_html(get_field('review_count')); ?>)</span>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-3 px-0">
                                        <div class="day text-start">
                                            <img src="<?php echo esc_url(get_stylesheet_directory_uri() . '/images/hours.svg'); ?>" alt="">
                                            <span><?php echo esc_html(get_field($hoursKey)); ?> hrs</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <?php

        endwhile;
        
    else :
        // echo '<p>No posts found.</p>';
    endif;
    wp_reset_postdata();
    echo "</div>";
    if(!empty($atts['button_text']) && !empty($atts['button_page_slug'])):
        $page = get_page_by_path($atts['button_page_slug']);
        $page_url = '#';
        if ( $page ) {
            $page_url = get_permalink( $page->ID );
        }
    ?>
    
    <a href="<?php echo $page_url; ?>" class="mt-2" style="color: inherit;">
        <span class="svg-icon">
            <svg viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg" width="16px" height="16px" fill="CurrentColor"><path d="m29.71 16.71-9 9a1 1 0 0 1 -1.42 0 1 1 0 0 1 0-1.42l7.3-7.29h-24.59a1 1 0 0 1 0-2h24.59l-7.3-7.29a1 1 0 0 1 1.42-1.42l9 9a1 1 0 0 1 0 1.42z"></path></svg>
        </span>
        <span class="item-title ms-2 fw-normal f-12  text-decoration-underline"><?php echo $atts['button_text']; ?></span>
    </a>
    <?php
    endif;
    return ob_get_clean();
}
add_shortcode('grras_grid_display', 'grras_grid_display_shortcode');

function grras_header_listarea($atts) {
    $atts = shortcode_atts(array(
        'acf_field' => ''
    ), $atts);
    
    $acf_field = sanitize_text_field($atts['acf_field']);
    
    $acf_group = get_field($acf_field, 'option');
    
    if (!$acf_group) return '';
    
    //$items = $acf_group['content_items'];

    ob_start();
    ?> 
    <div class="contextBox">
        <h6 class="fw-medium"><?php echo $acf_group['title']; ?></h6>
        <p class="f-12 unstyled"><?php echo $acf_group['tagline']; ?></p>
        
        <?php if ( have_rows($acf_field . '_content_items', 'option') ): ?>
            <ul class="list-unstyled mb-0 mt-4">
                <?php while ( have_rows($acf_field . '_content_items', 'option') ): the_row(); ?>
                    <li class="mb-2">
                        <span class="svg-icon">
                            <svg viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg" width="16px" height="16px" fill="CurrentColor"><path d="m29.71 16.71-9 9a1 1 0 0 1 -1.42 0 1 1 0 0 1 0-1.42l7.3-7.29h-24.59a1 1 0 0 1 0-2h24.59l-7.3-7.29a1 1 0 0 1 1.42-1.42l9 9a1 1 0 0 1 0 1.42z"></path></svg>
                        </span>
                        <span class="item-title ms-2 f-12"><?php echo get_sub_field('item_title'); ?></span>
                    </li>
                <?php endwhile; ?>
            </ul>
        <?php endif; ?>
    </div>
    <?php
    return ob_get_clean();
}
add_shortcode('grras_header_listarea', 'grras_header_listarea');

/*add_action('admin_menu', 'grras_custom_admin_menu');
function grras_custom_admin_menu() {
    // 1. Create the main "Grras" menu
    add_menu_page(
        'Grras Settings',
        'Grras Settings',
        'manage_options',
        'grras-main-menu',
        '', // No callback, acts as a container
        'dashicons-admin-site',
        2 // Position
    );
}

add_filter('register_post_type_args', 'grras_override_cpt_menu', 20, 2);
function grras_override_cpt_menu($args, $post_type) {
    $grras_cpts = ['course-faq', 'testimonials', 'courses', 'internships', 'projects', 'workshops', 'career_success_story', 'placements', 'redhat_courses', 'faqs']; // Your CPT slugs

    if (in_array($post_type, $grras_cpts)) {
        $args['show_in_menu'] = 'grras-main-menu'; // Move under "Grras"
    }
    return $args;
}*/

add_filter( 'qsm_display_banner', function( $id, $question, $answers ) {

    // Only show image after every even answer
    if ( mt_rand(1, 100) <= 30 ) {
        
        // List of real Unsplash images
        $images = [
            'https://images.unsplash.com/photo-1506744038136-46273834b3fb?w=800', // Mountains
            'https://images.unsplash.com/photo-1493244040629-496f6d136cc3?w=800', // Beach
            'https://images.unsplash.com/photo-1516117172878-fd2c41f4a759?w=800', // Forest road
            'https://images.unsplash.com/photo-1507525428034-b723cf961d3e?w=800', // Ocean wave
            'https://images.unsplash.com/photo-1519985176271-adb1088fa94c?w=800', // City skyline
        ];

        // Pick a random one
        $random_image = $images[ array_rand( $images ) ];

        // Append image HTML
        $content .= '<div class="qsm-even-image" style="margin:10px 0;text-align:center;">
                        <img src="' . esc_url( $random_image ) . '" alt="Random" style="max-width:100%;height:auto;border-radius:8px;" />
                     </div>';
    }

    return $content;

}, 10, 4 ); // Priority 10, and 4 arguments so we can use $mlw_answer_total

// Fetch quiz instructions
add_action('wp_ajax_get_quiz_instructions', 'get_quiz_instructions');
add_action('wp_ajax_nopriv_get_quiz_instructions', 'get_quiz_instructions');

function get_quiz_instructions() {
    $post_id = intval($_POST['post_id']);
    $instructions = get_post_meta($post_id, 'quiz_instructions_html', true);

    if (!empty($instructions)) {
        wp_send_json_success(['instructions' => wp_kses_post($instructions)]);
    } else {
        wp_send_json_error(['message' => 'No instructions found.']);
    }
}

// Ensure Administrators always see all 'courses' posts
add_action('pre_get_posts', function($query) {
    if (
        is_admin() && 
        $query->is_main_query() && 
        (!isset($_GET['author'])) &&
        current_user_can('administrator')
    ) {
        // Remove any author restriction
        $query->set('author', '');
    }
});


add_action('wp_ajax_filter_quizzes', 'qsm_filter_quizzes');
add_action('wp_ajax_nopriv_filter_quizzes', 'qsm_filter_quizzes');

function qsm_filter_quizzes() {
  $search = isset($_POST['search']) ? sanitize_text_field(wp_unslash($_POST['search'])) : '';
  $selectedCats = [];
  if (!empty($_POST['selectedCats'])) {
    $decoded = json_decode(stripslashes($_POST['selectedCats']), true);
    if (is_array($decoded)) {
      $selectedCats = array_map('intval', $decoded);
    }
  }

  $args = [
    'post_type'      => 'qsm_quiz',
    'post_status'    => 'publish',
    's'              => $search,
    'posts_per_page' => 12,         // tweak as needed
    'orderby'        => 'date',
    'order'          => 'DESC',
  ];

  if (!empty($selectedCats)) {
    $args['tax_query'] = [
      [
        'taxonomy' => 'quiz-categories',
        'field'    => 'term_id',
        'terms'    => $selectedCats,
      ],
    ];
  }

  $quiz_query = new WP_Query($args);

  ob_start();

  ?>
  <div class="exam-course-area coursesec d-md-none" id="mobileMcqs">
    <div class="exam-course-area-item p-2">
      <div class="row">
        <?php
        if ($quiz_query->have_posts()) {
          while ($quiz_query->have_posts()) {
            $quiz_query->the_post();

            // ====== Your quiz data block (kept from your template) ======
            $quizId          = get_field('quiz_id');
            $questions_count = 0;
            $quiz_duration   = 0;
            $firstCatName    = '';
            global $mlwQuizMasterNext;

            if ($quizId && isset($mlwQuizMasterNext)) {
              $quiz_data = $mlwQuizMasterNext->pluginHelper->prepare_quiz($quizId);
              if ($quiz_data) {
                $qmn_quiz_options = (array) $mlwQuizMasterNext->quiz_settings->get_quiz_options();
                $question_ids     = $mlwQuizMasterNext->pluginHelper->get_questions_ids($quizId);
                $questions_count  = is_array($question_ids) ? count($question_ids) : 0;
                $quiz_duration    = !empty($qmn_quiz_options['timer_limit']) ? intval($qmn_quiz_options['timer_limit']) : 0;

                $terms = wp_get_post_terms(get_the_ID(), 'quiz-categories');
                if (!empty($terms) && !is_wp_error($terms)) {
                  $firstCatName = $terms[0]->name;
                }
              } else {
                // Skip if quiz not properly prepared
                continue;
              }
            } else {
              continue;
            }
            ?>
            <div class="col-12 col-md-12 intcourse pt-0 pb-3 px-2">
              <div class="cobox">
                <div class="p-3">
                  <div class="imgbox">
                    <small><a class="link fw-medium"><?php echo esc_html($firstCatName); ?></a></small>
                  </div>
                  <div class="content p-0">
                    <h6><a class="fw-semibold"><?php the_title(); ?></a></h6>
                    <p class="mb-0"><?php echo esc_html(get_field('quiz_tagline')); ?></p>
                  </div>
                </div>

                <div class="content line py-2 px-3">
                  <?php
                  $terms = get_the_terms(get_the_ID(), 'quiz_tags');
                  if ($terms && !is_wp_error($terms)) {
                    echo '<ul>';
                    foreach ($terms as $term) {
                      echo '<li>';
                      echo '<svg xmlns="http://www.w3.org/2000/svg" width="11px" height="11px" viewBox="0 0 24 24" fill="none" transform="matrix(-1, 0, 0, 1, 0, 0)">
<g clip-path="url(#ef7220clip0_15_213)">  <path d="M9.16894 21.8995L19.4357 11.6327C19.6505 11.4179 19.756 11.1171 19.7225 10.8152L19.1568 5.72404C19.1051 5.2592 18.7382 4.89224 18.2733 4.84059L13.1822 4.27491C12.8802 4.24136 12.5794 4.34687 12.3646 4.56168L2.09787 14.8284C1.70735 15.219 1.70735 15.8521 2.09787 16.2426L7.75472 21.8995C8.14525 22.29 8.77841 22.29 9.16894 21.8995Z" stroke="#000" stroke-linecap="round" stroke-linejoin="round"></path> <circle cx="14.1205" cy="9.88055" r="2" transform="rotate(45 14.1205 9.88055)" stroke="#000" stroke-linejoin="round"></circle> </g>
</svg> ';
                      echo '<a href="#">' . esc_html($term->name) . '</a>';
                      echo '</li>';
                    }
                    echo '</ul>';
                  }
                  ?>
                </div>

                <ul class="list-unstyled px-3 question-list">
                  <li>
                    <span>Questions</span>
                    <span class="float-end"><?php echo intval($questions_count); ?></span>
                  </li>
                  <li>
                    <span>Time duration</span>
                    <span class="float-end"><?php echo intval($quiz_duration); ?> min</span>
                  </li>
                </ul>

                <div class="cobox-footer-quiz p-3 pt-0">
                  <button
                    data-url="<?php echo esc_url(get_permalink()); ?>"
                    data-quiz="<?php echo get_the_ID(); ?>"
                    data-quizname="<?php echo esc_attr(get_the_title()); ?>"
                    class="btn btn-primary btn-sm p-2 w-100 startQuiz">
                    Start Quiz
                  </button>
                </div>
              </div>
            </div>
            <?php
          } // while
          wp_reset_postdata();
        } else {
          echo '<div class="col-12 p-3 text-muted">No quizzes matched your filters.</div>';
        }
        ?>
      </div>
    </div>
  </div>
  <?php

  $html = ob_get_clean();
  wp_send_json(['success' => true, 'html' => $html]);
}
