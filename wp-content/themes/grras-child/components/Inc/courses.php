<?php
function custom_post_type() {
  
    // Set UI labels for Custom Post Type
        $labels = array(
            'name'                => _x( 'Courses', 'Post Type General Name', 'grras-child' ),
            'singular_name'       => _x( 'Course', 'Post Type Singular Name', 'grras-child' ),
            'menu_name'           => __( 'Courses', 'grras-child' ),
            'parent_item_colon'   => __( 'Parent Course', 'grras-child' ),
            'all_items'           => __( 'All Courses', 'grras-child' ),
            'view_item'           => __( 'View Course', 'grras-child' ),
            'add_new_item'        => __( 'Add New Course', 'grras-child' ),
            'add_new'             => __( 'Add New', 'grras-child' ),
            'edit_item'           => __( 'Edit Course', 'grras-child' ),
            'update_item'         => __( 'Update Course', 'grras-child' ),
            'search_items'        => __( 'Search Course', 'grras-child' ),
            'not_found'           => __( 'Not Found', 'grras-child' ),
            'not_found_in_trash'  => __( 'Not found in Trash', 'grras-child' ),
        );
          
    // Set other options for Custom Post Type
          
        $args = array(
            'label'               => __( 'courses', 'grras-child' ),
            'description'         => __( 'Course news and reviews', 'grras-child' ),
            'labels'              => $labels,
            // Features this CPT supports in Post Editor
            'supports'            => array( 'title', 'editor', 'excerpt', 'author', 'thumbnail', 'comments', 'revisions', 'custom-fields', ),
            // You can associate this CPT with a taxonomy or custom taxonomy. 
            'taxonomies'          => array( 'course_types' ),
            /* A hierarchical CPT is like Pages and can have
            * Parent and child items. A non-hierarchical CPT
            * is like Posts.
            */
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
            'capability_type'     => 'post',
            'show_in_rest' => true,
      
        );
          
        // Registering your Custom Post Type
        register_post_type( 'courses', $args );
      
    }
       
    add_action( 'init', 'custom_post_type', 0 );
    
    
    
    
    
    function themes_taxonomy() {
        register_taxonomy(
            'course_types',  // The name of the taxonomy. Name should be in slug form (must not contain capital letters or spaces).
            'courses',             // post type name
            array(
                'hierarchical' => true,
                'label' => 'Courses type', // display name
                'query_var' => true,
                'rewrite' => array(
                    'slug' => 'course_types',    // This controls the base slug that will display before each term
                    'with_front' => false  // Don't display the category base before
                )
            )
        );
    }
    add_action( 'init', 'themes_taxonomy');
    
    // Add filter dropdown on admin page for courses
    function filter_courses_by_taxonomy() {
        global $typenow;
        $post_type = 'courses'; // change to your post type
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
    add_action('restrict_manage_posts', 'filter_courses_by_taxonomy');
    
    // Register Custom Taxonomy for 'Course Tags'
function register_course_tags_taxonomy() {
    $labels = array(
        'name'                       => _x( 'Course Tags', 'Taxonomy General Name', 'grras-child' ),
        'singular_name'              => _x( 'Course Tag', 'Taxonomy Singular Name', 'grras-child' ),
        'menu_name'                  => __( 'Course Tags', 'grras-child' ),
        'all_items'                  => __( 'All Course Tags', 'grras-child' ),
        'parent_item'                => __( 'Parent Course Tag', 'grras-child' ),
        'parent_item_colon'          => __( 'Parent Course Tag:', 'grras-child' ),
        'new_item_name'              => __( 'New Course Tag Name', 'grras-child' ),
        'add_new_item'               => __( 'Add New Course Tag', 'grras-child' ),
        'edit_item'                  => __( 'Edit Course Tag', 'grras-child' ),
        'update_item'                => __( 'Update Course Tag', 'grras-child' ),
        'view_item'                  => __( 'View Course Tag', 'grras-child' ),
        'separate_items_with_commas' => __( 'Separate course tags with commas', 'grras-child' ),
        'add_or_remove_items'        => __( 'Add or remove course tags', 'grras-child' ),
        'choose_from_most_used'      => __( 'Choose from the most used course tags', 'grras-child' ),
        'popular_items'              => __( 'Popular Course Tags', 'grras-child' ),
        'search_items'               => __( 'Search Course Tags', 'grras-child' ),
        'not_found'                  => __( 'Not Found', 'grras-child' ),
        'no_terms'                   => __( 'No tags', 'grras-child' ),
        'items_list'                 => __( 'Course Tags list', 'grras-child' ),
        'items_list_navigation'      => __( 'Course Tags list navigation', 'grras-child' ),
    );

    $args = array(
        'hierarchical'          => false, // Set to false for tags-style behavior (non-hierarchical)
        'labels'                => $labels,
        'show_ui'               => true,
        'show_in_rest'          => true,  // Enable in the block editor
        'show_admin_column'     => true,
        'query_var'             => true,
    
    );

    // Register the 'course_tags' taxonomy for 'courses' post type
    register_taxonomy( 'course-tags', array( 'courses' ), $args );
}
add_action( 'init', 'register_course_tags_taxonomy', 0 );
function register_course_city_taxonomy() {
    $labels = array(
        'name'                       => _x( 'Course city', 'Taxonomy General Name', 'grras-child' ),
        'singular_name'              => _x( 'Course city', 'Taxonomy Singular Name', 'grras-child' ),
        'menu_name'                  => __( 'Course city', 'grras-child' ),
        'all_items'                  => __( 'All Course city', 'grras-child' ),
        'parent_item'                => __( 'Parent Course city', 'grras-child' ),
        'parent_item_colon'          => __( 'Parent Course city:', 'grras-child' ),
        'new_item_name'              => __( 'New Course city Name', 'grras-child' ),
        'add_new_item'               => __( 'Add New Course city', 'grras-child' ),
        'edit_item'                  => __( 'Edit Course city', 'grras-child' ),
        'update_item'                => __( 'Update Course city', 'grras-child' ),
        'view_item'                  => __( 'View Course city', 'grras-child' ),
        'separate_items_with_commas' => __( 'Separate course city with commas', 'grras-child' ),
        'add_or_remove_items'        => __( 'Add or remove course city', 'grras-child' ),
        'choose_from_most_used'      => __( 'Choose from the most used course city', 'grras-child' ),
        'popular_items'              => __( 'Popular Course Tags', 'grras-child' ),
        'search_items'               => __( 'Search Course Tags', 'grras-child' ),
        'not_found'                  => __( 'Not Found', 'grras-child' ),
        'no_terms'                   => __( 'No tags', 'grras-child' ),
        'items_list'                 => __( 'Course city list', 'grras-child' ),
        'items_list_navigation'      => __( 'Course city list navigation', 'grras-child' ),
    );

    $args = array(
        'hierarchical'          => false, // Set to false for tags-style behavior (non-hierarchical)
        'labels'                => $labels,
        'show_ui'               => true,
        'show_in_rest'          => true,  // Enable in the block editor
        'show_admin_column'     => true,
        'query_var'             => true,
    
    );

    // Register the 'course_tags' taxonomy for 'courses' post type
    register_taxonomy( 'city', array( 'courses' ), $args );
}
add_action( 'init', 'register_course_city_taxonomy', 0 );

// for the pagination 
function my_enqueue_scripts() {
    wp_enqueue_script('ajax-pagination', get_stylesheet_directory_uri() . '/js/ajax-pagination.js', array('jquery'), null, true);
    wp_localize_script('ajax-pagination', 'ajaxpagination', array(
        'ajaxurl' => admin_url('admin-ajax.php'),
        'noposts' => __('No more posts found', 'your-text-domain')
    ));
}
add_action('wp_enqueue_scripts', 'my_enqueue_scripts');
function load_more_courses() {
    $paged = $_POST['page'] + 1;
    $query = new WP_Query(array(
        'post_type' => 'courses',
        'posts_per_page' => 4,
        'paged' => $paged
    ));

    if ($query->have_posts()) {
        while ($query->have_posts()) : $query->the_post();
            get_template_part('template-parts/content', 'course'); // Create a template for single course item
        endwhile;
    } else {
        echo '<p>' . esc_html__('No more posts found', 'your-text-domain') . '</p>';
    }
    wp_reset_postdata();
    die();
}
add_action('wp_ajax_nopriv_load_more_courses', 'load_more_courses');
add_action('wp_ajax_load_more_courses', 'load_more_courses');

    // pagination 
    function enqueue_scriptsss() {
    wp_enqueue_script('custom-ajax', get_stylesheet_directory_uri() . '/js/custom-ajax.js', ['jquery'], null, true);
    wp_localize_script('custom-ajax', 'ajaxurl', admin_url('admin-ajax.php'));
}
add_action('wp_enqueue_scripts', 'enqueue_scriptsss');

    add_action('wp_ajax_load_courses', 'load_courses_handler');
add_action('wp_ajax_nopriv_load_courses', 'load_courses_handler');

function load_courses_handler() {
    $category = isset($_POST['category']) ? sanitize_text_field($_POST['category']) : '';
    $page = isset($_POST['page']) ? intval($_POST['page']) : 1;

    $posts_per_page = get_the_ID() == 17246 ? 9 : 9;
   

$args = [
    'post_type'      => 'courses',
    'tax_query'      => array(
        array(
            'taxonomy' => 'city', // The taxonomy name
            'field'    => 'term_id', // Fetch term IDs
            'terms'    => get_terms(array( // Fetch all terms in the 'city' taxonomy
                'taxonomy' => 'city',
                'fields'   => 'ids',
            )),
            'operator' => 'NOT IN', // Exclude all terms in the taxonomy
        ),
    ),
    'posts_per_page' => $posts_per_page,
    'paged'          => $page,
];

    if ($category) {
        $args['tax_query'] = [
             array(
            'taxonomy' => 'city', // The taxonomy name
            'field'    => 'term_id', // You can use 'slug' if needed
            'terms'    => get_terms(array( // Fetch all terms in the 'city' taxonomy
                'taxonomy' => 'city',
                'fields'   => 'ids',
            )),
            'operator' => 'NOT IN', // Exclude all terms in the taxonomy
        ),
            
            [
                'taxonomy' => 'course_types',
                'field' => 'slug',
                'terms' => $category,
            ],
            
        ];
    }

    $query = new WP_Query($args);

    ob_start();

    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
            $course_terms = get_the_terms(get_the_ID(), 'course_types');
             $term_names = [];    
            if ($course_terms) {
              foreach ($course_terms as $term) {
                $term_classes .= ' ' . esc_attr($term->slug);
                $term_names[] = $term->name;    
              }
            }
            ?>
             <a href="<?php the_permalink(); ?>">
             <div class="cobox">
                    <div class="imgbox">
                      <img src="<?php echo get_field('mobile_background_image')?>" class="img-fluid bigimg" alt="">
                      <div class="imgcontent">
                        <div class="icon"><img src="<?php the_post_thumbnail_url(); ?>" class="img-fluid" alt=""></div>
                      </div>
                      <?php if (get_field('discount')) : ?>
                          <div class="offer"><?php echo get_field('discount'); ?><span>%</span> OFF</div>               
                        <?php endif; ?>
                    </div>
                    <div class="right-content">
                      <div class="<?php echo get_field('best_seller_color'); ?>"><?php echo get_field('best_seller'); ?></div>
                      <h4> <small><?php echo $term_names[0]?></small><br><?php the_title(); ?></h4>
                
                          <?php the_content()?>

                      <div class="content">
                        <div class="row">
                          <div class="col-md-6 col-6">
                            <div class="star">
                                <?php 
                                $rating = get_field('rating');
                                for($i = 1; $i <= $rating; $i++){
?>
                                <span class="star star-enabled">★</span>
<?php
                                }
                                ?>

                                &nbsp; <?php echo $rating?>/5 <span>(<?php echo get_field('review_count')?>)</span>
                              </div>
                          </div>
                          <div class="col-md-6 col-6">
                            <div class="day"><img src="<?php echo get_stylesheet_directory_uri() ?>/images/days.svg" alt=""> <?php echo get_field('days'); ?> Day</div>
                          </div>
                        </div>
                      </div>              
                    </div>
                  </div>
            </a>
            <?php
        }
    } else {
        echo '<p>No courses found.</p>';
    }

    $courses_html = ob_get_clean();

ob_start();

$total_pages = $query->max_num_pages;
$current_page = $page;
$range = 2; 

if ($total_pages > 1) {
    echo '<nav aria-label="Page navigation"><ul class="pagination">';

    // Display the first page and "..." if necessary
    if ($current_page > $range + 1) {
        echo '<li class="page-item"><a class="page-link" href="#" data-page="1">1</a></li>';
        if ($current_page > $range + 2) {
            echo '<li class="page-item disabled"><span class="page-link">...</span></li>';
        }
    }

    // Display page numbers within the range
    for ($i = max(1, $current_page - $range); $i <= min($total_pages, $current_page + $range); $i++) {
        if ($i === $current_page) {
            echo '<li class="page-item active"><span class="page-link">' . $i . '</span></li>';
        } else {
            echo '<li class="page-item"><a class="page-link" href="#" data-page="' . $i . '">' . $i . '</a></li>';
        }
    }

    // Display the last page and "..." if necessary
    if ($current_page < $total_pages - $range) {
        if ($current_page < $total_pages - $range - 1) {
            echo '<li class="page-item disabled"><span class="page-link">...</span></li>';
        }
        echo '<li class="page-item"><a class="page-link" href="#" data-page="' . $total_pages . '">' . $total_pages . '</a></li>';
    }

    echo '</ul></nav>';
}

$pagination_html = ob_get_clean();


    wp_send_json([
        'courses' => $courses_html,
        'pagination' => $pagination_html,
    ]);

    wp_die();
}

    