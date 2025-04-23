
<div class="owl-carousel top-company-course owl-loaded owl-drag" id="custom-showsjdfk">
     <?php
      // Get the tags for the current course post
    //   $tags = get_terms( array(
    //     'taxonomy' => 'course-tags',
    //     'orderby'  => 'name', // Optional: Sort alphabetically by name
    //     'hide_empty' => false, // Optional: Show empty tags or not
    //   ) );
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
         
            <div class="item">
              <div class="icon"><img src="<?php echo esc_url( $image_url ); ?>" class="img-fluid" alt=""></div>
              <span><?php echo esc_html( $tag->name ); ?></span>
            </div>
        
        <?php endforeach; ?>
      <?php else : ?>
        <li>No tags found for this course.</li>
      <?php endif; ?>
          
          
          </div>