<?php

/**
 * Template Name: Internship
 */
get_header();
?>
<!-- Learn today -->
<div class="intern-banner">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-6 wow fadeInLeft">
                <h1><?php $banner = get_field("banner");
                    echo $banner["title"];
                    ?></h1>
                    <p>
                <?php echo $banner["short_description"] ?>
                </p>
                <a href="javascript:void(0)" class="btn btn-dark"  data-bs-toggle="modal" data-bs-target="#exampleModal590" class="btn btn-dark">Apply Now</a>
                <a href="<?php echo $banner["brochore_url"] ?>" class="btn btn-primary">Download Brochrue</a>
                
            </div>
        </div>
    </div>
    
    <div class="bannerhero wow fadeInRight"><img src="<?php echo $banner["image"] ?>" class="img-fluid" alt=""></div>
</div>

<!-- course -->
<?php include 'components/courses.php'; ?>

<!-- The Summer Training program 2023 Provides -->
<div class="thesummer bg-image-hide">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h2 class="text-center"><?php echo get_field("training_title"); ?></h2>

                <?php if (have_rows('training')): ?>
                    <ul>
                        <?php while (have_rows('training')): the_row(); ?>
                            <li>
                                <img src="<?php the_sub_field('icon'); ?>" alt="">
                                <p><?php the_sub_field('title'); ?></p>
                            </li>
                        <?php endwhile; ?>
                    </ul>
                <?php endif; ?>

            </div>
        </div>
    </div>
</div>

<?php include 'components/whyGrasss.php'; ?>
<?php include 'components/trainining-to-placement.php'; ?>


<!-- certificate -->
<div class="certificate wow fadeInLeft">
    <div class="container">
        <div class="certibox">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <h2><?php echo $certificate['title']; ?></h2>
                    <?php echo $certificate['description']; ?>
                     <a href="javascript:void(0)" class="btn btn-primary"  data-bs-toggle="modal" data-bs-target="#exampleModal590">Apply for Internship</a>
                </div>
                <div class="col-lg-6">
                    <div class="imgbox">
                        <img src="<?php echo $certificate['image']; ?>" class="img-fluid" alt="">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- company logo -->
    <?php //include 'components/top-companies.php'; ?>	<!-- top companies start -->				      <?php $id = get_the_ID(); ?>  <div class="<?php echo ($id == 16765 ? 'container-fluid wow fadeInUp' : 'container wow fadeInLeft'); ?>">     <div class="<?php echo ($id == 16765 ? 'cologo homecologo talentbox' : 'cologo'); ?>">        <h4>Talents from top companies have chosen our expertise to advance their careers  </h4>        <div class="owl-carousel top-company owl-loaded owl-drag">          <?php if (have_rows('top_companies')): ?>                <?php while (have_rows('top_companies')): the_row(); ?>                    <div class="item"><img src="<?php echo get_sub_field('image'); ?>" class="img-fluid" alt=""></div>                <?php endwhile; ?>                <?php else:                while (have_rows('top_companies', 'option')): the_row(); ?>                    <div class="item"><img src="<?php echo get_sub_field('image'); ?>" class="img-fluid" alt=""></div>                <?php endwhile; ?>            <?php endif; ?>        </div>      </div>    </div>			<!-- top compainies ends -->

</div>

      
      
        <div class="modal fade" id="exampleModal590" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog reqcallback" >
        <div class="modal-content" style="background: #ffe7d8;">
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          <div class="modal-body">
            <div class="row">
              <div class="col-lg-6">
                <div class="imgbox"><img src="<?php 
                $request_call_back_images = get_field('internship_page_form','option');
                echo $request_call_back_images['desktop_image']; ?>" class="img-fluid d-none d-lg-block" alt=""></div>
                <div class="imgbox"><img src="<?php echo $request_call_back_images['mobile_image']; ?>" class="img-fluid d-block d-lg-none" alt=""></div>
              </div>
              <div class="col-lg-6">
              <div class="formbox">
                  <h4>Book a Demo Class, For <strong>Free!</strong> </h4>
                  <?php echo do_shortcode('[gravityform id="21" title="false" ajax="true"]'); ?>
              </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
<?php
include 'components/WhatOurLeaarnerSay.php';

include 'components/empower.php';
include 'components/grass-vs-otherers.php';
include 'components/latest-workshop-internship.php';
include 'components/faq.php';

get_footer();
