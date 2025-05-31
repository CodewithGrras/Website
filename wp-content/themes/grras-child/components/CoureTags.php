<div class="endcareer endcareer2 wow fadeInUp section-padding bg-image-hide bg-white mb-0">
    <div class="container">
      <div class="row">
        <div class="col-lg-12 text-center">
          <h2 class="mb-0"><?php echo get_field('course_project_heading_and_tags_heading')['tags_heading']; ?></h2>
        </div>
        <?php 
        $post_id = get_the_ID(); // This gets the current post ID.
        $taxonomy = 'course-tags'; // We're looking for categories here. 
        $tags = get_the_terms($post_id, $taxonomy);

        if ( ! empty( $tags ) && ! is_wp_error( $tags ) ) :
          // Loop through the tags and display them
          foreach ( $tags as $tag ) :
            // Get ACF Image Field for each tag (assuming 'tag_image' is the ACF field name)
            $image = get_field('image', 'course-tags_' . $tag->term_id);  // 'course-tags_' . $tag->term_id is the ACF field key for the taxonomy

            if ( $image ) : // Check if the image exists
              $image_url = $image;
              $image_alt =  $tag->name;
            else :
              $image_url = 'path_to_default_image.png'; // Fallback image if no image is set
              $image_alt = $tag->name;
            endif;
            $tag_permalink = get_term_link( $tag );
        ?>
        <div class="col-lg-4 col-sm-6 col-6 g-3">
          <div class="endcareer2-area align-items-center d-flex gap-3 p-3 border rounded-2 brd-theme-light">
            <img class="img-tool-icon" src="<?php echo $image_url; ?>" alt="<?php echo $image_alt; ?>" />
            <h6 class="mb-0"><?php echo $image_alt; ?></h6>
          </div>
        </div>
        <?php endforeach; endif; ?>
        
      </div>
    </div>
</div>
