<?php get_header(); ?>

    <div class="blogs wow fadeInRight">
      <div class="container">
<div class="latestblog wow fadeInUp">
  <div class="container">
    <div class="row">
      <!-- Sidebar: Displaying the categories dynamically -->
      <div class="col-md-3">
        <ul class="bloglist">
          <?php
          // Display categories dynamically
          $categories = get_categories(array(
            'orderby' => 'name',
            'order' => 'ASC',
          ));

          foreach ($categories as $category) :
            ?>
            <li><a href="<?php echo get_category_link($category->term_id); ?>"><?php echo esc_html($category->name); ?></a></li>
          <?php endforeach; ?>
        </ul>
      </div>

      <!-- Main Content: Display posts from the selected category -->
      <div class="col-md-9">
   

        <div class="row">
          <?php
          // Start the Loop to display posts in the current category
          if (have_posts()) :
            while (have_posts()) : the_post();
          ?>
              <div class="col-lg-4 col-sm-6">
                <div class="blog-content">
                  <div class="imgbox">
                    <?php
                    // Display the post thumbnail (if available)
                    if (has_post_thumbnail()) {
                      the_post_thumbnail('medium', ['class' => 'img-fluid']);
                    } else {
                      echo '<img src="' . get_stylesheet_directory_uri() . '/images/default-image.jpg" class="img-fluid" alt="Default image">';
                    }
                    ?>
                  </div>
                  <div class="contentbox">
                    <h4><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
                    <div class="admin"><span>By</span> <?php the_author(); ?></div>
                    <div class="date"><?php echo get_the_date(); ?></div>
                    <div class="read"><?php echo get_field('read_time') ? get_field('read_time') : 5 ?> Min Read</div>
                  </div>
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

        <!-- Load More Articles Button (static or could be made dynamic with AJAX) -->
        <!--<div class="col-lg-12 text-center">-->
        <!--  <a href="#" class="btn btn-outline-primary">Load More Articles</a>-->
        <!--</div>-->
      </div>
    </div>
  </div>
</div>
</div>
</div>

<?php get_footer(); ?>
