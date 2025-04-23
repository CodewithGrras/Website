<?php
get_header(); ?>

<div class="container">
  <div class="row">
    <div class="col-lg-9">
        
      <h2>Category: <?php single_cat_title(); ?></h2>
      <p><?php echo category_description(); ?></p> <!-- Display the category description -->

      <?php
      // Start the Loop to display posts in the category
      if (have_posts()) :
        while (have_posts()) : the_post();
          ?>
          <div class="post-item">
            <div class="post-thumbnail">
              <?php
              // Display the post thumbnail (if available)
              if (has_post_thumbnail()) {
                the_post_thumbnail('medium', ['class' => 'img-fluid']);
              } else {
                echo '<img src="' . get_stylesheet_directory_uri() . '/images/default-image.jpg" class="img-fluid" alt="Default image">';
              }
              ?>
            </div>
            <div class="post-content">
              <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
              <p><?php echo wp_trim_words(get_the_excerpt(), 20, '...'); ?></p>
              <a href="<?php the_permalink(); ?>" class="btn btn-primary">Read More</a>
            </div>
          </div>
          <?php
        endwhile;

        // Pagination for category posts
        the_posts_pagination(array(
          'prev_text' => 'Previous',
          'next_text' => 'Next',
        ));
      else :
        echo '<p>No posts found in this category.</p>';
      endif;
      ?>
    </div>

    <!-- Sidebar (optional) -->
    <div class="col-lg-3">
      <?php get_sidebar(); ?>
    </div>
  </div>
</div>

<?php
get_footer();
?>
