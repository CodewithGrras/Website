<?php

$post_id = get_the_ID(); // This gets the current post ID.
$taxonomy = 'city'; // We're looking for categories here. 
$tags = get_the_terms($post_id, $taxonomy);

      if ( ! empty( $tags ) && ! is_wp_error( $tags ) ) :
          ?>
  
  <div class="container wow fadeInUp">
  <h3><?php the_title(); ?> in Other Cities</h3>
  <div class="tagging-round mt-4 mb-4">
      <?php
      
        $args = array(
                    'post_type' => 'courses',
                    's' => $tags->slug,
                    'tax_query' => array(
                      array(
            'taxonomy' => 'city',
            'operator' => 'EXISTS'
        ),
                    ),
                    );

                $courses_query = new WP_Query($args);
                if ($courses_query->have_posts()) :
                    while ($courses_query->have_posts()) : $courses_query->the_post();
                ?>
      <a class="tagging-round--item" href="<?php echo get_post_permalink(); ?>"><?php the_title(); ?></a>
       <?php
                    endwhile;
                else :
                    echo '<p>No courses found.</p>';
                endif;

                wp_reset_postdata();
                ?>
      </div>
      </div>
      <?php
      endif;
      ?>