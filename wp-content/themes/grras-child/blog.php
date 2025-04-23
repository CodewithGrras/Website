<?php
/**
 * Template Name: Blog
 */
get_header();
?>
    <!-- Blogs -->
    <div class="blogs wow fadeInRight">
      <div class="container">
        <div class="row">
          <div class="col-lg-9">
            <h2>Blogs <small><?php echo get_the_category_list(', ', '', get_the_ID()); ?></small></h2> <!-- Dynamically show categories -->
          </div>
          <div class="col-lg-3">
            <form id="search-form" class="form-inline" action="javascript:void(0);" >
              <input type="text" class="form-control" placeholder="Search" id="search-input2" name="s">
              <!--<?php echo get_search_query(); ?>-->
              <!-- <button type="submit" class="btn btn-primary">Search</button> -->
            </form>
          </div>

        </div>

          <div class="blogbox">
            <div class="row align-items-center">
              <div class="col-lg-6">
                <?php
                // Query to get the latest post
                $args = array(
                  'post_type' => 'post',
                  'posts_per_page' => 1,
                  'post_status' => 'publish',
               
                );
                $latest_post_query = new WP_Query($args);

                if ($latest_post_query->have_posts()) :
                  while ($latest_post_query->have_posts()) : $latest_post_query->the_post();
                ?>
                  <div class="imgbox">
                    <?php
                    if (has_post_thumbnail()) {
                   echo '<img src="' . get_the_post_thumbnail_url() . '" class="img-fluid" alt="Default image">';

                    } else {
                      echo '<img src="' . get_stylesheet_directory_uri() . '/images/default-image.jpg" class="img-fluid" alt="Default image">';
                    }
                    ?>
                  </div>
              </div>
              <div class="col-lg-6">
                <div class="subtext">
                  <?php
                  $categories = get_the_category();
                  if (!empty($categories)) {
                    echo $categories[0]->name . ' <span>' . get_the_date() . '</span>';
                  }
                  ?>
                </div>
                <h3 class="custom_contant" style="-webkit-line-clamp: 3!important;"><?php the_title(); ?></h3>
                <p><?php echo wp_trim_words(get_the_excerpt(), 25, '...'); ?></p>
              </div>
            </div>
          </div>
        <?php endwhile; wp_reset_postdata(); endif; ?>
      </div>
    </div>

    <div class="latestblog wow fadeInUp">
      <div class="container">
        <div class="row">
        <div class="col-md-3 top-fixed3">
    <ul class="bloglist ">
            <li><a href="javascript:void(0);" class="category-link" data-category-id="" data-name="All">All</a></li>
        <?php
        $categories = get_categories();
        foreach ($categories as $category) {
            echo '<li><a href="javascript:void(0);" class="category-link" data-category-id="' . $category->term_id . '" data-name="' . $category->name . '">' . $category->name . '</a></li>';
        }
        ?>
    </ul>
</div>


          <div class="col-md-9">
            <h2 id="display-change">All</h2>
            <div class="row" id="post-container">
              <?php
              // Define the query arguments to fetch the latest posts
              $args = array(
                'post_type' => 'post',
                'posts_per_page' => 6,
                'post_status' => 'publish',
                'paged' => get_query_var('paged') ? get_query_var('paged') : 1, // Pagination
                's' => get_search_query(), // Include search term
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
                      <h4><a href="<?php the_permalink(); ?>" class="custom_contant" style="-webkit-line-clamp: 3!important;"><?php the_title(); ?></a></h4>
                      <div class="admin"><span>By</span> <?php the_author(); ?></div>
                      <div class="date"><?php echo get_the_date(); ?></div>
                      <div class="read"><?php echo get_field('read_time') ? get_field('read_time') : 7 ?> Min Read</div>
                    </div>
                  </div>
                </div>
              <?php endwhile; wp_reset_postdata(); else: ?>
                <p>No posts found.</p>
              <?php endif; ?>
            </div>

            <!-- Pagination -->
            <div class="col-lg-12 text-center">
         <?php    if ($query->max_num_pages > 1) :
    $current_page = max(1, get_query_var('paged'));
    $total_pages = $query->max_num_pages;
    $range = 2; // Adjust the range as needed

    echo '<nav aria-label="Page navigation"><ul class="pagination">';

    // Display the first page and "..." if necessary
    if ($current_page > $range + 1) {
        echo '<li class="page-item"><a class="page-link" href="' . get_pagenum_link(1) . '">1</a></li>';
        if ($current_page > $range + 2) {
            echo '<li class="page-item disabled"><span class="page-link">...</span></li>';
        }
    }

    // Display page numbers within the range
    for ($i = max(1, $current_page - $range); $i <= min($total_pages, $current_page + $range); $i++) {
        if ($i === $current_page) {
            echo '<li class="page-item active"><span class="page-link">' . $i . '</span></li>';
        } else {
            echo '<li class="page-item"><a class="page-link" href="' . get_pagenum_link($i) . '">' . $i . '</a></li>';
        }
    }

    // Display the last page and "..." if necessary
    if ($current_page < $total_pages - $range) {
        if ($current_page < $total_pages - $range - 1) {
            echo '<li class="page-item disabled"><span class="page-link">...</span></li>';
        }
        echo '<li class="page-item"><a class="page-link" href="' . get_pagenum_link($total_pages) . '">' . $total_pages . '</a></li>';
    }

    echo '</ul></nav>';
endif;
?>
            </div>
          </div>
        </div>
      </div>
    </div>
  <script>
jQuery(document).ready(function($) {
  // Handle the category link click event
  $('.category-link').on('click', function(e) {
    e.preventDefault();
    
    var categoryId = $(this).data('category-id'); 
var name = $(this).data('name'); 
$('#display-change').text(name);

    // Send an AJAX request to WordPress
    $.ajax({
      url: '<?php echo admin_url("admin-ajax.php"); ?>', // WordPress AJAX URL
      type: 'GET',
      data: {
        action: 'filter_posts_by_category', // Custom action name
        category_id: categoryId // Category ID
      },
      success: function(response) {
        // Replace the post container with the new category posts
        
        $('#post-container').html(response);
        $('html, body').animate({
          scrollTop: $('#post-container').offset().top
        }, 1000);
      },
      error: function() {
        alert('There was an error with the category request.');
      }
    });
  });

  // Handle the search form submission
  $('#search-form').on('submit', function(e) {
    e.preventDefault();

    var searchQuery = $('#search-input2').val();
console.log(searchQuery)
    // Send an AJAX request to WordPress
    $.ajax({
      url: '<?php echo admin_url("admin-ajax.php"); ?>', // WordPress AJAX URL
      type: 'GET',
      data: {
        action: 'search_posts', // Custom action name
        s: searchQuery, // Search query
        paged: 1 // Start from the first page
      },
      success: function(response) {
        // Replace the post container with the new search results
        $('#post-container').html(response);
        $('html, body').animate({
          scrollTop: $('#post-container').offset().top
        }, 1000);
      },
      error: function() {
        alert('There was an error with the search request.');
      }
    });
  });
});
</script>


<?php
include "components/TopChoices.php";

get_footer();
