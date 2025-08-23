<?php

/**
 * Template Name: Contact Us
 */
get_header();
?>
<!-- contact form -->
<div class="contactform bg-theme-light section-padding">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 wow fadeInLeft text-center text-lg-start">
                <h1 class="mb-3"><?php the_field('title') ?></h1>
                <div class="location"><?php the_field('short_description') ?></div>
            </div>
            <div class="col-lg-6">
                <div class="coform wow fadeInLeft bg-white">
                    <h3>Contact Us</h3>

                    <?php echo do_shortcode('[gravityform id="1" title="false"]') ?>

                </div>
            </div>
        </div>
    </div>
</div>
<!-- locate -->
<div class="locate wow fadeInUp">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-12">
                <h2><?php echo get_field('location_title') ?></h2>
            </div>
            
            <?php if (have_rows('worldwide_locations')): ?>
              <?php while (have_rows('worldwide_locations')): the_row(); ?>
                <?php 
                  $country_name = get_sub_field('country_name');
                  //if (strtolower($country_name) !== 'india') continue; // Skip if not India
                ?>
                
                <?php if (have_rows('country_locations')): ?>
                <!--<h2><?php echo esc_html($country_name); ?></h2>-->
            
                <?php if (have_rows('country_locations')): ?>
                  <div class="row">
                    <?php while (have_rows('country_locations')): the_row(); ?>
                      <div class="col-lg-4 col-sm-6">
                        <div class="imgbox">
                          <div class="front">
                            <img src="<?php echo esc_url(get_sub_field('image')); ?>" class="img-fluid" alt="">
                          </div>
                          <div class="back">
                            <?php echo wpautop(get_sub_field('address')); ?>
                            <a href="<?php echo esc_url(get_sub_field('map_link')); ?>" target="_blank" class="btn btn-outline-light">Click Here</a>
                          </div>
                        </div>
                      </div>
                    <?php endwhile; ?>
                  </div>
                <?php endif; ?>
                <?php endif; ?>
              <?php endwhile; ?>
            <?php endif; ?>


        </div>
    </div>
</div>

    <!-- exam center -->
    <div class="examcenter">
      <div class="container">
        <div class="row p-0">
          <div class="col-lg-12">
            <h2 class="text-center mb-4 mb-lg-4"><?php echo get_field('exam_center_title'); ?></h2>
          </div>
        <div class="col-lg-12">
  <?php if (have_rows('exam_centers')): ?>
                <?php while (have_rows('exam_centers')): the_row(); ?>
                <a href="<?php echo get_sub_field('google_link')?>" target="_blank">
          <div class="row align-items-center">
            <div class="col-sm-6">
              <img src="<?php echo get_sub_field('image')?>" class="img-fluid" alt="">
              <h4><?php echo get_sub_field('title')?></h4>
            </div>
            <div class="col-sm-6">
              <p><?php echo get_sub_field('description')?></p>
            </div>
          </div>
        </a>
                <?php endwhile; ?>
            <?php endif; ?>
        </div>
</div>
      </div>
    </div>

    <!-- partner -->
    <div class="hiring wow fadeInUp">
        <div class="container">
            <div class="whbox">
                <h4>Our Hiring Partners</h4>
                <div class="owl-carousel partner-logo">
                <?php if (have_rows('our_hiring_partners')): ?>
                <?php while (have_rows('our_hiring_partners')): the_row(); ?>
                <div class="item"><img src="<?php echo get_sub_field('image')?>" class="img-fluid" alt=""></div>
                <?php endwhile; ?>
            <?php endif; ?>
                                    </div>
            </div>
        </div>
    </div>
    
    <?php
    include "components/faq.php";
    get_footer();
