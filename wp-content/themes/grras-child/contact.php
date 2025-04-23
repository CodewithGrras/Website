<?php

/**
 * Template Name: Contact Us
 */
get_header();
?>
<!-- contact form -->
<div class="contactform">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 wow fadeInLeft">
                <h1><?php the_field('title') ?></h1>
                <div class="location"><?php the_field('short_description') ?></div>
            </div>
            <div class="col-lg-6">
                <div class="coform wow fadeInLeft">
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
            <?php if (have_rows('locations')): ?>
                <?php while (have_rows('locations')): the_row(); ?>
                <div class="col-lg-4 col-sm-6">
            <div class="imgbox">
              <div class="front"><img src="<?php echo get_sub_field('image') ?>" class="img-fluid" alt=""></div>
              <div class="back">
                <?php echo wpautop(get_sub_field('address'))?>
                <a href="<?php echo get_sub_field('map_link')?>" target="_blank" class="btn btn-outline-light">Click Here</a>
              </div>
            </div>
          </div>
                   
                <?php endwhile; ?>
            <?php endif; ?>

        </div>
    </div>
</div>

    <!-- exam center -->
    <div class="examcenter">
      <div class="container">
        <div class="row">
          <div class="col-lg-12">
            <h2 class="text-center">Exam Centers</h2>
          </div>
        </div>
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
