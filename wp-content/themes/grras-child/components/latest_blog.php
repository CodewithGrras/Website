<!-- Latest Blogs -->
<div class="lastestblog wow fadeInUp">
  <div class="container">
    <div class="row">
      <div class="col-12">
        <h2 class="text-center">Blogs</h2>
      </div>
      <style>
      .excerpt_blog {
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
    overflow: hidden;
    text-overflow: ellipsis;
}
</style>

      <div class="owl-carousel blog-slid">
        
        <?php
        // Define the query arguments to fetch the latest posts
        $args = array(
          'post_type' => 'post', // Only posts
          'posts_per_page' => 6, // Number of posts to show
          'post_status' => 'publish', // Only published posts
          
          
        );

        // Query the latest posts
        $latest_posts = new WP_Query( $args );

        // Check if there are posts
        if ( $latest_posts->have_posts() ) :
          // Loop through the posts
          while ( $latest_posts->have_posts() ) : $latest_posts->the_post();
        ?>
	
        <div class="item"><a href="<?php the_permalink(); ?>" >
          <div class="cousebox">
            <?php 
            // Check if the post has a featured image
            if ( has_post_thumbnail() ) : 
              // Display the featured image
              the_post_thumbnail( 'full', array( 'class' => 'img-fluid' ) );
            else : 
              // Fallback image if no featured image is set
            ?>
              <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/default-image.png" class="img-fluid" alt="">
            <?php endif; ?>

            <div class="content">
              <h4 class="excerpt_blog"><?php the_title(); ?></h4>
              <p><?php echo wp_trim_words( get_the_excerpt(), 16, '...' ); ?></p>
              <a href="<?php the_permalink(); ?>" class="link">Read More</a>
              <div class="date"><?php echo get_the_date( 'M d, Y' ); ?></div>
            </div>
          </div></a>
        </div>		

        <?php
          endwhile;
          wp_reset_postdata(); // Reset post data after the loop
        else :
          // If no posts are found
        ?>
          <div class="item">
            <div class="cousebox">
              <p>No blog posts found.</p>
            </div>
          </div>
        <?php endif; ?>

      </div>
      <div class="col-lg-12 text-center mt-5">
        <a href="<?php get_link_custom('blog') ?>" class="btn btn-primary">Read More Blogs</a>
      </div>
    </div>
  </div>
</div>
