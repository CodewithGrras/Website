<?php

// Register Custom Post Type Testimonials
function register_testimonials_post_type() {

    $labels = array(
        'name'                  => _x( 'Testimonials', 'Post Type General Name', 'text_domain' ),
        'singular_name'         => _x( 'Testimonial', 'Post Type Singular Name', 'text_domain' ),
        'menu_name'             => __( 'Testimonials', 'text_domain' ),
        'name_admin_bar'        => __( 'Testimonial', 'text_domain' ),
        'archives'              => __( 'Testimonial Archives', 'text_domain' ),
        'attributes'            => __( 'Testimonial Attributes', 'text_domain' ),
        'parent_item_colon'     => __( 'Parent Item:', 'text_domain' ),
        'all_items'             => __( 'All Testimonials', 'text_domain' ),
        'add_new_item'          => __( 'Add New Testimonial', 'text_domain' ),
        'add_new'               => __( 'Add New', 'text_domain' ),
        'new_item'              => __( 'New Testimonial', 'text_domain' ),
        'edit_item'             => __( 'Edit Testimonial', 'text_domain' ),
        'update_item'           => __( 'Update Testimonial', 'text_domain' ),
        'view_item'             => __( 'View Testimonial', 'text_domain' ),
        'view_items'            => __( 'View Testimonials', 'text_domain' ),
        'search_items'          => __( 'Search Testimonial', 'text_domain' ),
        'not_found'             => __( 'Not found', 'text_domain' ),
        'not_found_in_trash'    => __( 'Not found in Trash', 'text_domain' ),
        'featured_image'        => __( 'Featured Image', 'text_domain' ),
        'set_featured_image'    => __( 'Set featured image', 'text_domain' ),
        'remove_featured_image' => __( 'Remove featured image', 'text_domain' ),
        'use_featured_image'    => __( 'Use as featured image', 'text_domain' ),
        'insert_into_item'      => __( 'Insert into Testimonial', 'text_domain' ),
        'uploaded_to_this_item' => __( 'Uploaded to this Testimonial', 'text_domain' ),
        'items_list'            => __( 'Testimonials list', 'text_domain' ),
        'items_list_navigation' => __( 'Testimonials list navigation', 'text_domain' ),
        'filter_items_list'     => __( 'Filter Testimonials list', 'text_domain' ),
    );
    $args = array(
        'label'                 => __( 'Testimonial', 'text_domain' ),
        'description'           => __( 'Testimonials', 'text_domain' ),
        'labels'                => $labels,
        'supports'              => array( 'title', 'editor', 'thumbnail', 'excerpt', 'custom-fields', 'comments' ),
        'taxonomies'            => array( 'course_types' ), // Assigning the existing 'course_types' taxonomy
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
    register_post_type( 'testimonials', $args );

}
add_action( 'init', 'register_testimonials_post_type', 0 );

// Associate 'course_types' Taxonomy with 'testimonials' Post Type
function associate_course_type_taxonomy_with_testimonials() {
    register_taxonomy_for_object_type( 'course_types', 'testimonials' );
}
add_action( 'init', 'associate_course_type_taxonomy_with_testimonials' );


// Add filter dropdown on admin page for testimonials
function filter_testimonials_by_taxonomy() {
    global $typenow;
    $post_type = 'testimonials'; // change to your post type
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
add_action('restrict_manage_posts', 'filter_testimonials_by_taxonomy');



function display_testimonials_slider($atts) {
    // Get current page's 'course_types' taxonomy term
    $terms = get_the_terms(get_the_ID(), 'course_types');
    if (!empty($terms) && !is_wp_error($terms)) {
        $term = array_shift($terms);
        $term_id = $term->term_id;

        // Query testimonials based on current page's 'course_types' taxonomy term
        $testimonials_args = array(
            'post_type'      => 'testimonials',
            'posts_per_page' => -1,
            'tax_query'      => array(
                array(
                    'taxonomy' => 'course_types',
                    'field'    => 'id',
                    'terms'    => $term_id,
                ),
            ),
        );

        $testimonials_query = new WP_Query($testimonials_args);

        // Check if testimonials found
        if ($testimonials_query->have_posts()) {
            $slider_html = '<div class="testimonial-slider swiper-container">';
            $slider_html .= '<div class="swiper-wrapper">';
while ($testimonials_query->have_posts()) {
    $testimonials_query->the_post();
    $title = get_post_meta(get_the_ID(), 'title', true); // Get the "title" field
    $post_title = get_the_title(); // Get the post title
    $testimonial_image = get_the_post_thumbnail(get_the_ID(), 'thumbnail'); // Get the post thumbnail
    $slider_html .= '<div class="swiper-slide">';
    $slider_html .= '<div class="testimonial-item">';
    $slider_html .= '<div class="testimonial-image">' . $testimonial_image . '</div>'; // Display image
    $slider_html .= '<div class="testimonial-details">';
    $slider_html .= '<h3 class="testimonial-post-title">' . esc_html($post_title) . '</h3>'; // Display post title
    $slider_html .= '<h4 class="testimonial-title">' . esc_html($title) . '</h4>'; // Display title
    $slider_html .= '</div>'; // testimonial-details
    $slider_html .= '</div>'; // testimonial-item
    $slider_html .= '<div class="testimonial-content">' . get_the_content() . '</div>';
    $slider_html .= '</div>'; // swiper-slide
}
            $slider_html .= '</div>';
            $slider_html .= '<div class="swiper-pagination"></div>';
            $slider_html .= '</div>';

            return $slider_html;
        } else {
            return '<p>No testimonials found for this category.</p>';
        }

        // Restore original post data
        wp_reset_postdata();
    } else {
        return '<p>No category found for this page.</p>';
    }
}
add_shortcode('testimonials_slider', 'display_testimonials_slider');

