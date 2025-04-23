<?php
// Register AJAX action to handle search
function handle_ajax_search() {
  // Get the search query from the AJAX request
  $search_query = isset($_GET['s']) ? sanitize_text_field($_GET['s']) : '';

  // Set up the query to fetch posts based on the search query
  $args = array(
    'post_type' => 'post',
    'posts_per_page' => 6, // Adjust this as needed
    's' => $search_query,
    'post_status' => 'publish',
    'paged' => isset($_GET['paged']) ? intval($_GET['paged']) : 1, // Ensure pagination works
  );

  $query = new WP_Query($args);

  if ($query->have_posts()) :
    // Loop through the posts and output the HTML
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
            <div class="read"><?php echo get_field('read_time') ? get_field('read_time') : 7 ?> Min Read</div>
          </div>
        </div>
      </div>
      <?php
    endwhile;
    wp_reset_postdata();
  else :
    echo '<p>No posts found for your search.</p>';
  endif;

  die(); // Ensure proper termination of the AJAX request
}
add_action('wp_ajax_search_posts', 'handle_ajax_search');
add_action('wp_ajax_nopriv_search_posts', 'handle_ajax_search'); // For non-logged-in users



// Handle AJAX search request
function handle_ajax_search_hb() {
    if (isset($_GET['query']) && !empty($_GET['query'])) {
        $search_query = sanitize_text_field($_GET['query']); // Sanitize the search input

        // Define query arguments
        $args = array(
            'post_type' => 'courses', // Or any custom post type you want to search
            'posts_per_page' => 10, // Limit results
            's' => $search_query, // The search query
        );

        // Query the posts
        $query = new WP_Query($args);

        // Check if there are any posts
        if ($query->have_posts()) {
            while ($query->have_posts()) {
                $query->the_post();
                // Output post title and permalink
                echo '<div class="search-result-item">';
                echo '<a href="' . get_permalink() . '">' . get_the_title() . '</a>';
                echo '</div>';
            }
        } else {
            echo '<p>No results found</p>';
        }

        wp_die(); // Terminate the AJAX request
    }
}
add_action('wp_ajax_search_posts_home', 'handle_ajax_search_hb'); // For logged-in users
add_action('wp_ajax_nopriv_search_posts_home', 'handle_ajax_search_hb'); // For non-logged-in users
