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

  <div class="youtubeModal modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">

    <div class="modal-dialog modal-lg">

      <div class="modal-content">

        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

        <div class="modal-body">

          <iframe class="youtubeIframe" width="100%" height="315" src="<?php echo $banner["video_link"] ?>" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>

        </div>

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

<div class="globalsection section-padding">
      <div class="container">
        <div class="row mb-4 mb-lg-5 heading-area">
          <div class="col-12 col-lg-6">
            <h2 class="fw-semibold mb-2"><?php echo get_field('get_globally_recognized_title'); ?></h2>
          </div>
          <div class="col-12 col-lg-6">
            <div class="subtext"><p><?php echo get_field('get_globally_recognized_subheading'); ?></p></div>
          </div>
        </div>  
        <div class="owl-carousel our_global">
          <?php if( have_rows('get_globally_recognized_items') ): ?>
  <?php while( have_rows('get_globally_recognized_items') ): the_row(); 
    $item_logo = get_sub_field('item_logo');
    $item_title = get_sub_field('item_title');
    $item_description = get_sub_field('item_description');
    $discovered_more_label = get_sub_field('discovered_more_label');
    $discovered_more_link = get_sub_field('discover_more_link');
  ?>
    <div class="item">
      <div class="card h-100 me-3 mb-3 ms-1">
        <div class="card-body">
          <div class="card_icon mb-3">
            <?php if( $item_logo ): ?>
              <img src="<?php echo esc_url($item_logo); ?>" class="img-fluid w-auto" alt="<?php echo esc_attr($item_title); ?>" />
            <?php endif; ?>
          </div>
          <div class="carddata-area">
            <?php if( $item_title ): ?>
              <h6 class="fw-semibold"><?php echo esc_html($item_title); ?></h6>
            <?php endif; ?>
            <?php if( $item_description ): ?>
              <p class="mb-2"><?php echo esc_html($item_description); ?></p>
            <?php endif; ?>
            <div class="btnarea">
              <a href="<?php echo esc_url( $discovered_more_link ); ?>" class="f-14 theme-text-primary fw-medium text-decoration-none">
                <span><?php echo esc_html($discovered_more_label ?: 'Discover More'); ?></span>
                <svg xmlns="http://www.w3.org/2000/svg" width="13" height="12" viewBox="0 0 13 12" fill="none">
                  <path d="M7.21167 2.51001L10.6784 5.97676M10.6784 5.97676L7.21167 9.44352M10.6784 5.97676L1.76392 5.97676" stroke="#12141D" stroke-width="0.990501" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>
  <?php endwhile; ?>
<?php endif; ?>

        </div>     
    </div>
  </div>

<!-- Career Oriented Courses -->

<div class="careercourses wow fadeInRight" style="    background: transparent;">

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

<div class="locationsection section-padding">
      <div class="container">
        <div class="row mb-4 mb-lg-5 heading-area">
          <div class="col-12 col-lg-12 text-center">
            <h2 class="fw-semibold mb-2">Skill Up With Our Career-Oriented Workshops</h2>
            <p>Equip yourself with market-relevant skills to unlock your potential and opportunities.</p>
          </div>
        </div>  
        <?php
$contact_us_page = get_page_by_path('contact-us');
$contact_page_id = $contact_us_page ? $contact_us_page->ID : null;

if ($contact_page_id && have_rows('worldwide_locations', $contact_page_id)): ?>
    <div class="bg-white rounded-2 locationmap-area pe-lg-3">
        <div class="row gx-0">
            <!-- Tabs -->
            <div class="col-12 col-sm-12 col-lg-3 pe-0">
                <ul class="nav nav-tabs w-100 border-0" id="myTab" role="tablist">
                    <?php
                    $count = 0;
                    while (have_rows('worldwide_locations', $contact_page_id)): the_row();
                        $country_name = get_sub_field('country_name');
                        $country_logo = get_sub_field('country_logo');
                        //if (strtolower($country_name) !== 'india') continue;
                    ?>
                        <li class="nav-item w-100" role="presentation">
                            <button class="nav-link <?php if($count === 0) { echo 'active'; } ?> w-100" data-bs-toggle="tab" data-bs-target="#<?php echo sanitize_title($country_name); ?>" type="button">
                                <div class="iconbar-area d-flex gap-4 align-items-center">
                                    <div class="iconbar">
                                        <img src="<?php echo esc_url($country_logo); ?>" class="img-fluid" />
                                    </div>
                                    <div class="iconbar-data text-start">
                                        <h5 class="text-uppercase fw-semibold mb-0"><?php echo esc_html($country_name); ?></h5>
                                    </div>
                                </div>
                            </button>
                        </li>
                    <?php $count++; endwhile; ?>
                </ul>
            </div>

            <!-- Locations -->
            <div class="col-5 col-lg-4 p-2 p-lg-3">
                <div class="tab-content" id="myTabContent">
                    <?php
                    $count = 0;
                    if (have_rows('worldwide_locations', $contact_page_id)):
                        while (have_rows('worldwide_locations', $contact_page_id)): the_row();
                            $country_name = get_sub_field('country_name');
                    ?>
                        <div class="tab-pane fade <?php if($count === 0) { echo 'show active'; } ?>" id="<?php echo sanitize_title($country_name); ?>">
                            <ul class="list-unstyled mb-0 insidetabarea p-lg-3">
                                <?php if (have_rows('country_locations')): ?>
                                    <?php while (have_rows('country_locations')): the_row(); 
                                        $location_name = get_sub_field('location_name');
                                        $is_head_office = get_sub_field('is_it_a_head_office');
                                        $iframe_code = get_sub_field('map_iframe_code');
                                    ?>
                                        <li>
                                            <a href="javascript:void(0);" class="location-link" data-map="<?php echo esc_attr($iframe_code); ?>">
                                                <span>
                                                    <?php 
                                                    echo esc_html($location_name);
                                                    if ($is_head_office) echo " (Head Office)";
                                                    ?>
                                                </span>
                                                <svg xmlns="http://www.w3.org/2000/svg" width="9" height="16" viewBox="0 0 9 16" fill="none">
                                                    <path d="M0.000768682 13.7422L1.62011 15.5L8.5293 8L1.62011 0.5L0.000768819 2.25781L5.29062 8L0.000768682 13.7422Z" fill="#EF7220"></path>
                                                </svg>
                                            </a>
                                        </li>
                                    <?php endwhile; ?>
                                <?php endif; ?>
                            </ul>
                        </div>
                    <?php $count++; endwhile; endif; ?>
                </div>
            </div>

            <!-- Map -->
            <div class="col-7 col-lg-5">
                <div class="maparea py-2 py-lg-3 h-100 pe-2 pe-lg-0">
                    <div id="mapContainer" class="w-100 h-100">
                        <iframe id="locationMap" src="" width="100%" height="100%" style="border:0;" allowfullscreen loading="lazy"></iframe>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>

    </div>
  </div>
<style>
    #mapContainer iframe {
      width: 100%;
      height: 100%;
     
    }
</style>
<!-- Career Oriented Courses -->



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

