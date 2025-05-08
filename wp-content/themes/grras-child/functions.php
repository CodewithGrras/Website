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

function grras_child_enqueue_scripts() {
    wp_enqueue_style(
        'grras-child-style',
        get_stylesheet_directory_uri() . '/style.css',
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
    wp_enqueue_style(
        'style-new',
        get_stylesheet_directory_uri() . '/css/style-new.css',
        array(),
        time() // Set version to current timestamp
    );

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
    $pdf_url = get_field('download_brochure', $post_id); // Change 'course_pdf' to your actual ACF field name

    if (!$pdf_url) {
        $pdf_url = site_url('/wp-content/uploads/sample.pdf'); // Default PDF if none exists
    }


    //$download_url = get_stylesheet_directory_uri().'/download_pdf.php?file=' . urlencode($pdf_url);
    $confirmation = "<script>window.open('$pdf_url', '_blank');</script>";

    return $confirmation;
}, 10, 3);

/////////////////  Download Pdf on Submitting Gravity Form (Home Page)  /////////////////
add_filter('gform_confirmation_22', function($confirmation, $form, $entry) {

    $post_id = rgar($entry, '10'); // hidden field id
    $pdf_url = get_field('download_placement_report', $post_id); // Change 'course_pdf' to your actual ACF field name

    if (!$pdf_url) {
        $pdf_url = site_url('/wp-content/uploads/sample.pdf'); // Default PDF if none exists
    }


    //$download_url = get_stylesheet_directory_uri().'/download_pdf.php?file=' . urlencode($pdf_url);
    $confirmation = "<script>window.open('$pdf_url', '_blank');</script>";

    return $confirmation;
}, 10, 3);

/////////////////  Download Pdf on Submitting Gravity Form (Placement Page)  /////////////////
add_filter('gform_confirmation_22', function($confirmation, $form, $entry) {

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
}, 10, 3);



