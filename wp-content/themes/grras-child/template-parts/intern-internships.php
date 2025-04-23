  <?php
    $course_terms = get_the_terms(get_the_ID(), 'internship_types');
            $term_classes = '';
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
                    <img src="<?php echo get_field('small_background_image') ?>" class="img-fluid bigimg" alt="">
                    <div class="imgcontent">
                      <div class="icon"><img src="<?php echo the_post_thumbnail_url(); ?>" class="img-fluid" alt=""></div>
                      <h4 class="two_line">
                          <small><?php echo $term_names[0]?></small>
                          </br>
                          <?php echo get_the_title() ?>
                         </h4>
                    </div>
                      <?php if (get_field('best_seller')) : ?>
                        <div class="bestseller"><?php echo get_field('best_seller'); ?></div>                      
                        <?php endif; ?>
                        <?php if (get_field('discount')) : ?>
                          <div class="offer"><?php echo get_field('discount'); ?><span>%</span> OFF</div>               
                        <?php endif; ?>
                  </div>
                 <div class="content">
    <p><?php echo wp_trim_words(get_the_content(), 12, '...'); ?></p>
</div>

                  <div class="content line">
                    <h5>Skills</h5>
                    <ul>
                       <?php
  
  $post_id = get_the_ID(); // This gets the current post ID.
  $taxonomy = 'internship-tags'; // We're looking for categories here. 
  $tags = get_the_terms($post_id, $taxonomy);
  
  if ( ! empty( $tags ) && ! is_wp_error( $tags ) ) :
      
    $tag_count = count($tags);
    $display_count = 4;
    $remaining_count = $tag_count - $display_count;
    $counter = 0;
  
    foreach ( $tags as $tag ) :
      if ($counter < $display_count) :
        $tag_permalink = get_term_link( $tag );
        ?>
        <li>
        <?php echo  wp_trim_words($tag->name, 2, '...');  ?></li>
      <?php
      endif;
      $counter++;
    endforeach;
  
    if ($remaining_count > 0) :
      ?>
      <li>More +<?php echo $remaining_count; ?></li>
    <?php
    endif;
  else : ?>
    <li></li>
  <?php endif; ?>
                    </ul>
                  </div>
                  <div class="content line">
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
                </a>