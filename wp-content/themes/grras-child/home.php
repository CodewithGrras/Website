<?php

/**
 * Template Name: Home
 */
get_header();
$banner = get_field("banner");
$choose_your_career = get_field("choose_your_career");
$career_oriented = get_field("career_oriented");
?>

<!-- home banner -->
<div class="homebanner">
  <div class="learn">
    <div class="container">
      <div class="row align-items-center">
        <div class="col-md-6 wow fadeInLeft">
          <h2><?php echo get_field('title') ?></h2>
          <!-- <p>Build a strong foundation in coding principles</p> -->
          <div class="owl-carousel homeslid">
            <?php if (have_rows('quotes')): ?>
              <?php while (have_rows('quotes')): the_row();
                $item = get_sub_field('name'); // Adjust this to match your subfield name
              ?>
                <div class="item">
                  <p><?php echo $item; ?></p>
                </div>
              <?php endwhile; ?>

            <?php endif; ?>
          </div>
          <ul>
            <?php if (have_rows('placement_points')): ?>
              <?php while (have_rows('placement_points')): the_row();
                $title = get_sub_field('title'); // Adjust this to match your subfield name
                $icon = get_sub_field('icon'); // Adjust this to match your subfield name
              ?>
                <li><img src="<?php echo $icon ?>" alt=""> <?php echo $title; ?></li>
              <?php endwhile; ?>
            <?php endif; ?>
          </ul>
        </div>
        <div class="col-md-6 wow fadeInRight">
          <div class="videobox">
            <img src="<?php echo $banner["image"] ?>" class="img-fluid videimg" alt="">
            <div class="play"><a href="#" data-bs-toggle="modal" data-bs-target="#exampleModal"><img src="<?php echo get_stylesheet_directory_uri() ?>/images/play.png" class="img-fluid" alt=""></a></div>
            <div class="content">
              <h4><?php echo $banner["title"] ?></h4>
              <p><?php echo $banner["sub_title"] ?></p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- form popup -->
  <div class="modal fade youtubeModal" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        <div class="modal-body">
          <iframe class="youtubeIframe" width="100%" height="315" src="<?php echo $banner["video_link"] ?>" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
        </div>
      </div>
    </div>
  </div>
  <!-- Book demo -->
  <div class="container wow fadeInUp">
    <div class="bookdemo">
      <h2><?php echo $choose_your_career["title"]; ?></h2>
      <p><?php echo $choose_your_career["short_description"]; ?></p>
    
      <div class="row g-3 align-items-center">
            <?php echo do_shortcode('[gravityform id="10" title="false" ajax="true"]'); ?>
     
      </div>
    </div>
  </div>
</div>

<!-- company logo -->

<!--<?php include 'components/top-companies.php'; ?>-->

<?php include 'components/3-line-partnersLogo.php'; ?>
<?php include 'components/TopChoices.php'; ?>

<!-- all course -->

<?php
include "components/featured-courses.php";
// include "components/Grass-Courseas.php"; 
?>

<!-- Career Oriented Courses -->
<div class="careercourses wow fadeInRight">
  <div class="container">
    <div class="row">
      <div class="col-lg-4">
        <h2 class="mb-3"><?php echo $career_oriented["title"] ?></h2>
         <div class="custom_contant" style="display: -webkit-box;"><?php echo $career_oriented["short_description"] ?></div>
         <div class="my-1 text-center-ms" style="     text-align: left;">
        <a href="javascript:void(0)" class="link-primary hide_custom "style="    color: orange;
    text-decoration: none;" >Read More</a>
        </div>
         <div class="my-3">
                
        <a href="javascript:void(0)" class="btn btn-primary"  data-bs-toggle="modal" data-bs-target="#exampleModal5">Enquire Now</a>
        </div>
      </div>
      <?php
      if ($career_oriented["oriented"]):
        foreach ($career_oriented["oriented"] as $value):
      ?>
          <div class="col-lg-4 col-md-6 col-6">
            <div class="imgbox deg">
              <img src="<?php echo $value["image"] ?>" class="img-fluid" alt="">
              <h4><?php echo $value["title"] ?></h4>
              <a href="<?php echo $value["link"] ?>" class="link"><img src="<?php echo get_stylesheet_directory_uri() ?>/images/course-right-arrow.png" alt=""></a>
            </div>
          </div>
      <?php
        endforeach;
      endif;
      ?>
    </div>
  </div>
</div>

<?php include 'components/our-placement-home.php'; ?>
<?php include 'components/home-stories.php'; ?>

<!-- Why grras -->

<?php include 'components/whyGrasss.php'; ?>

<!-- What our learners have to say about Grras -->
<?php include 'components/home-workshop.php' ?>
<?php include 'components/WhatOurLeaarnerSay.php' ?>
<!-- award -->


<?php

include 'components/award.php';
include 'components/latest_blog.php';
get_footer();
