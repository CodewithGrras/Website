<?php
// Register Custom Post Type Projects
function register_projects_post_type() {

    $labels = array(
        'name'                  => _x( 'Projects', 'Post Type General Name', 'text_domain' ),
        'singular_name'         => _x( 'Project', 'Post Type Singular Name', 'text_domain' ),
        'menu_name'             => __( 'Projects', 'text_domain' ),
        'name_admin_bar'        => __( 'Project', 'text_domain' ),
        'archives'              => __( 'Project Archives', 'text_domain' ),
        'attributes'            => __( 'Project Attributes', 'text_domain' ),
        'parent_item_colon'     => __( 'Parent Item:', 'text_domain' ),
        'all_items'             => __( 'All Projects', 'text_domain' ),
        'add_new_item'          => __( 'Add New Project', 'text_domain' ),
        'add_new'               => __( 'Add New', 'text_domain' ),
        'new_item'              => __( 'New Project', 'text_domain' ),
        'edit_item'             => __( 'Edit Project', 'text_domain' ),
        'update_item'           => __( 'Update Project', 'text_domain' ),
        'view_item'             => __( 'View Project', 'text_domain' ),
        'view_items'            => __( 'View Projects', 'text_domain' ),
        'search_items'          => __( 'Search Project', 'text_domain' ),
        'not_found'             => __( 'Not found', 'text_domain' ),
        'not_found_in_trash'    => __( 'Not found in Trash', 'text_domain' ),
        'featured_image'        => __( 'Featured Image', 'text_domain' ),
        'set_featured_image'    => __( 'Set featured image', 'text_domain' ),
        'remove_featured_image' => __( 'Remove featured image', 'text_domain' ),
        'use_featured_image'    => __( 'Use as featured image', 'text_domain' ),
        'insert_into_item'      => __( 'Insert into Project', 'text_domain' ),
        'uploaded_to_this_item' => __( 'Uploaded to this Project', 'text_domain' ),
        'items_list'            => __( 'Projects list', 'text_domain' ),
        'items_list_navigation' => __( 'Projects list navigation', 'text_domain' ),
        'filter_items_list'     => __( 'Filter Projects list', 'text_domain' ),
    );
    $args = array(
        'label'                 => __( 'Project', 'text_domain' ),
        'description'           => __( 'Projects', 'text_domain' ),
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
    register_post_type( 'projects', $args );

}
add_action( 'init', 'register_projects_post_type', 0 );

// Associate 'course_types' Taxonomy with 'projects' Post Type
function associate_course_type_taxonomy_with_projects() {
    register_taxonomy_for_object_type( 'course_types', 'projects' );
}
add_action( 'init', 'associate_course_type_taxonomy_with_projects' );

// Add filter dropdown on admin page for projects
function filter_projects_by_taxonomy() {
    global $typenow;
    $post_type = 'projects'; // change to your post type
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
add_action('restrict_manage_posts', 'filter_projects_by_taxonomy');


function display_projects_slider($atts) {
    // Get current page's 'course_types' taxonomy term
    $terms = get_the_terms(get_the_ID(), 'course_types');
    if (!empty($terms) && !is_wp_error($terms)) {
        $term = array_shift($terms);
        $term_id = $term->term_id;

        // Query projects based on current page's 'course_types' taxonomy term
        $projects_args = array(
            'post_type'      => 'projects',
            'posts_per_page' => -1,
            'tax_query'      => array(
                array(
                    'taxonomy' => 'course_types',
                    'field'    => 'id',
                    'terms'    => $term_id,
                ),
            ),
        );

        $projects_query = new WP_Query($projects_args);

        // Check if projects found
        if ($projects_query->have_posts()) {
            $slider_html = '<div class="project-slider swiper-container">';
            $slider_html .= '<div class="swiper-wrapper">';
            while ($projects_query->have_posts()) {
                $projects_query->the_post();
                $title = get_post_meta(get_the_ID(), 'title', true); // Get the "title" field
                $post_title = get_the_title(); // Get the post title
                $project_image = get_the_post_thumbnail(get_the_ID(), 'thumbnail'); // Get the post thumbnail
                $excerpt = wp_trim_words(get_the_excerpt(), 20, '...'); // Limit excerpt to 20 words
                $content = get_the_content(); // Get the post content
                $project_id = 'project-' . get_the_ID(); // Unique identifier for each project item

                // Add project details and "Read More" button
                $slider_html .= '<div id="' . $project_id . '" class="swiper-slide">';
                $slider_html .= '<div class="project-item">';
                $slider_html .= '<div class="project-image">' . $project_image . '</div>'; // Display image
                $slider_html .= '<div class="project-details">';
                $slider_html .= '<h3 class="project-post-title">' . esc_html($post_title) . '</h3>'; // Display post title
                $slider_html .= '<h4 class="project-title">' . esc_html($title) . '</h4>'; // Display title
                $slider_html .= '<div class="project-excerpt">' . esc_html($excerpt) . '</div>'; // Display excerpt with word limit
                $slider_html .= '<a class="read-more" href="#" data-title="' . esc_attr($post_title) . '" data-content="' . esc_attr($content) . '">Read More</a>'; // Link to trigger popup
                $slider_html .= '</div>'; // project-details
                $slider_html .= '</div>'; // project-item
                $slider_html .= '</div>'; // swiper-slide
            }
            $slider_html .= '</div>';
            $slider_html .= '<div class="swiper-button-next"></div>';
            $slider_html .= '<div class="swiper-button-prev"></div>';
            $slider_html .= '</div>';

            // Add necessary scripts and popup HTML
            $slider_html .= '
            <div id="project-popup">
                <h3 id="popup-title"></h3>
                <div id="popup-content"></div>
                <button id="popup-close" style="margin-top:10px;">Close</button>
            </div>
            <div id="popup-overlay" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.5); z-index:999;"></div>
            <script>
          document.addEventListener("DOMContentLoaded", function() {
    var readMoreLinks = document.querySelectorAll(".read-more");
    var popup = document.getElementById("project-popup");
    var popupOverlay = document.getElementById("popup-overlay");
    var popupTitle = document.getElementById("popup-title");
    var popupContent = document.getElementById("popup-content");
    var popupClose = document.getElementById("popup-close");

    readMoreLinks.forEach(function(link) {
        link.addEventListener("click", function(e) {
            e.preventDefault();
            var title = this.getAttribute("data-title");
            var content = this.getAttribute("data-content");

            popupTitle.textContent = title;
            popupContent.innerHTML = content;

            popup.style.display = "block";
            popupOverlay.style.display = "block";

            // Lock scroll
            document.body.classList.add("no-scroll");
        });
    });

    popupClose.addEventListener("click", function() {
        popup.style.display = "none";
        popupOverlay.style.display = "none";

        // Unlock scroll
        document.body.classList.remove("no-scroll");
    });

    popupOverlay.addEventListener("click", function() {
        popup.style.display = "none";
        popupOverlay.style.display = "none";

        // Unlock scroll
        document.body.classList.remove("no-scroll");
    });
});

            </script>';

            return $slider_html;
        } else {
            return '<p>No projects found for this category.</p>';
        }

        // Restore original post data
        wp_reset_postdata();
    } else {
        return '<p>No category found for this page.</p>';
    }
}
add_shortcode('projects_slider', 'display_projects_slider');

function project_details_shortcode($atts) {
    $atts = shortcode_atts(array(
        'project_id' => '',
    ), $atts, 'project_details');

    $project_id = $atts['project_id'];

    if (empty($project_id)) {
        return '<p>No project ID provided.</p>';
    }

    $project_post = get_post($project_id);

    if (!$project_post || $project_post->post_type !== 'projects') {
        return '<p>Invalid project ID.</p>';
    }

    $title = get_the_title($project_post);
    $content = apply_filters('the_content', $project_post->post_content);

    ob_start();
    ?>
    <div class="project-details-popup">
        <h2 class="project-title"><?php echo esc_html($title); ?></h2>
        <div class="project-content"><?php echo $content; ?></div>
    </div>
    <?php
    return ob_get_clean();
}
add_shortcode('project_details', 'project_details_shortcode');

