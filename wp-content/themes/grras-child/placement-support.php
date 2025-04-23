<?php

/**
 * 
 * Template Name: Placement Support
 */
get_header();
?>
<!-- Our Recent Placements -->
<div class="placesupport wow fadeInLeft">
  <div class="container">
    <div class="row align-items-center">
      <div class="col-lg-7">
        <h1>
          <?php
          $banner = get_field('banner');
          $stories_from_people = get_field('stories_from_people');
          echo $banner["title"];
          ?></h1>
        <p><?php echo $banner["sub_title"]; ?></p>
     <ul>
          <?php
          foreach ($banner["tags"] as $item) {
          ?>
            <li>
                <img src="<?php echo $item["icon"] ?>" alt="">
                <?php echo $item["name"] ?></li>
          <?php
          }
          ?>
        </ul> 
       
      </div>
      <div class="col-md-5 wow fadeInRight">
            <div class="videobox">
              <iframe width="100%" height="320" src="<?php echo the_field('banner_youtube_url') ?>" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen=""></iframe>
            </div>
          </div>
      <!--<div class="col-lg-5">-->
      <!--  <div class="imgbox"><img src="<?php echo get_the_post_thumbnail_url() ?>" class="img-fluid" alt=""></div>-->
      <!--</div>-->
    </div>
  </div>
</div>


<div class="replace">
  <!-- company logo -->
 <?php include 'components/top-companies.php'; ?>
</div>

<!-- How to Reach Your Goal? -->
<div class="trackrecord wow fadeInLeft">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-12 mb-3">
        <h2 class="text-center">Grras Solutions Proven Track Record</h2>
      </div>

      <?php if (have_rows('grras_solutions')): ?>

        <?php while (have_rows('grras_solutions')): the_row();
          $image = get_sub_field('image'); // Adjust this to match your subfield name
          $title = get_sub_field('title'); // Adjust this to match your subfield name
        ?>
          <div class="col-lg-3 col-md-6 g-3 col-6">

            <div class="trackbox">
              <img src="<?php echo $image; ?>" class="img-fluid" alt="">
              <p><?php echo $title; ?></p>
            </div>
          </div>
        <?php endwhile; ?>

      <?php endif; ?>
    </div>
  </div>
</div>


<!-- Stories from people like you -->
<div class="storypeople wow fadeInLeft">
  <div class="container">
    <div class="row justify-content-between">
      <div class="col-lg-3 stories_like">
        <h2><?php echo $stories_from_people["title"] ?></h2>
        <ul class="dotlist">
          <?php foreach ($stories_from_people["points"] as $item) {
          ?>
            <li><?php echo $item["name"] ?></li>
          <?php
          }
          ?>
        </ul>
        <!--<a href="<?php echo $stories_from_people["url_placement_brochure"] ?>" class="btn btn-primary d-block">Placement Brochure</a>-->		<a href="#" class="btn btn-primary d-block" data-bs-toggle="modal" data-bs-target="#exampleModal6">Download Brochure</a>
      </div>
<?php include 'components/placement-supports.php';?>
    </div>
  </div>
</div>
</div>


<!-- Placement Process -->
<div class="placement wow fadeInLeft">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <h2 class="pt-1">Placement Process</h2>
      </div>
      <div class="col-md-12">
        <ul>
          <?php if (have_rows('placement_process')): ?>

            <?php while (have_rows('placement_process')): the_row();
              $image = get_sub_field('icon'); // Adjust this to match your subfield name
              $title = get_sub_field('title'); // Adjust this to match your subfield name
            ?>
              <li>
                <div class="icon">
                  <img src="<?php echo $image ?>" alt="">
                </div>
                <p class="w-25"><?php echo $title ?></p>
              </li>
            <?php endwhile; ?>

          <?php endif; ?>

        </ul>
      </div>
      <div class="col-md-6"><div class="text-center d-blcok d-md-none"><a href="#" class="btn btn-primary">View Students Placement</a></div></div>
    </div>
  </div>
</div>

<!-- studentclub -->
<div class="studentclub">
  <div class="container">
    <div class="row align-items-center">
        
      <!--<div class="col-lg-4">-->
      <!--  <div class="imgbox"><img src="<?php echo get_field('placement_left_image') ?>" class="img-fluid" alt=""></div>-->
      <!--</div>-->
      <div class="col-lg-8">
        <div class="clubbox">
          <div class="clubimg">
            <img src="<?php 
            $student_clubs = get_field('student_clubs');
            echo $student_clubs['image'];
            ?>" class="img-fluid" alt="">
            <h4><?php echo $student_clubs['title'];?></h4>
          </div>
          <ul class="clublist">
          <?php 
          foreach($student_clubs['club_list'] as $item){
          ?>
            <li><?php echo $item['name'] ?></li>
          <?php }?>
          </ul>
        </div>
      </div>
      <div class="col-lg-4 order-lg-first">
        <div class="imgbox"> <iframe width="100%" height="425" src="https://www.youtube.com/embed/gZcwX4mZAJ8?si=1CRx2d8RV74OiMnK" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen=""></iframe> </div>
      </div>
    </div>
  </div>
</div>


<div class="recentplacement successstory trustedby wow fadeInRight">
  <div class="container">
    <h2 class="text-center">
    <?php 
    $what_our_learners = get_field('what_our_learners','option');
    
    echo get_field('trusted_by_learners_title') ?></h2>

    <ul class="review">
      <?php if ($what_our_learners['companies_image']): ?>

        <?php foreach ($what_our_learners['companies_image'] as $item){
          $image = $item['image'] // Adjust this to match your subfield name
        ?>

          <li>
              <a href="<?php echo $item['link'] ?>">
              <img src="<?php echo $image ?>" class="img-fluid" alt="">
              </a>
              </li>
        <?php } ?>

      <?php endif; ?>
    </ul>



<?php include 'components/success-story-placement-support.php';
include 'components/faq.php';
get_footer();
