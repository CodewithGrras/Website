<div class="owl-carousel video-review">
               <?php
// The Loop to fetch the testimonials
$args = array(
    'post_type' => 'testimonials',
    'post_per_page' => 10,
    'order_by' => 'DESC',
    
);

$testimonials_query = new WP_Query($args);

    $arr = [];
if ($testimonials_query->have_posts()) :
    while ($testimonials_query->have_posts()) : $testimonials_query->the_post();
?>
                  <div class="item">
                    <div class="orangebox">
                      <div class="content">
                        <div class="row">
                          <div class="col-4"><img src="<?php echo get_stylesheet_directory_uri() ?>/images/orange-quote.jpg" class="img-fluid" alt=""></div>
                          <div class="col-8 text-right"><img src="<?php echo get_stylesheet_directory_uri() ?>/images/ornage-star.jpg" class="img-fluid" alt=""></div>
                        </div>
                        <p class="custom_contant" style="display: -webkit-box;"><?php echo get_the_content(); ?></p>
                      </div>
                      <div class="blackbg">
                        <img src="<?php echo get_the_post_thumbnail_url(); ?>" class="img-fluid" alt="">
                        <h5><?php echo get_the_title(); ?></h5>
                      </div>
                    </div>
                  </div>
                  
                  <?php
                  endwhile;
                   wp_reset_postdata();
                  endif;
                  ?>
                </div>