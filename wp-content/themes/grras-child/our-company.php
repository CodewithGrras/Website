<?php
/**
 * Template Name: Our Company
 * 
 */
 get_header();
?>
<body>


    <!-- ourstory section -->
    <div class="ourstory">
      <div class="container">
        <div class="row">
              <?php if( have_rows('our_story') ): ?>
          <?php while( have_rows('our_story') ): the_row(); ?>
          <div class="col-lg-6">
                <h2><?php the_sub_field('title'); ?></h2>
            <p><?php the_sub_field('description'); ?></p>
            </div>
          <?php endwhile; ?>
        <?php else: ?>
          <p>No story content available.</p>
        <?php endif; ?>
        </div>
      </div>
    </div>

    <!-- board -->
    <div class="board">
      <div class="container">
        <div class="row">
          <div class="col-lg-12">
            <h2><?php echo get_field('profile_title') ?></h2>
          </div>
                
              <?php if( have_rows('directors_profile') ): ?>
          <?php while( have_rows('directors_profile') ): the_row(); ?>
                    <div class="col-lg-6">
            <div class="bordbox">
              <img src="<?php the_sub_field('profile'); ?>" alt="">
              <div class="content">
                <h3><?php the_sub_field('name'); ?> <span><?php the_sub_field('designation'); ?></span></h3>
                <div class="exp"><?php the_sub_field('experience'); ?></div>
                <p><?php the_sub_field('description'); ?></p>
              </div>
            </div>
          </div>

        
          <?php endwhile; ?>
        <?php else: ?>
          <p>No story content available.</p>
        <?php endif; ?>
        </div>
  
      </div>
    </div>

    <!-- Our Recent Placements -->
    <div class="ourplacement">
      <div class="container">
        <div class="row d-flex align-items-center">
          <div class="col-lg-8">
            <h2><?php 
            $placements = get_field('placements');
            $our_mission = get_field('our_mission');
            $partner = get_field('partner');
            $awards_recognitions = get_field('awards_&_recognitions');
            echo $placements['title'];
            ?></h2>
            <p><?php echo $placements['description'] ?></p>
          </div>
          <div class="col-lg-4">
            <iframe width="100%" height="200" src="<?php echo $placements['youtube_url'] ?>" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen=""></iframe>
          </div>
        </div>
      </div>
    </div>

    <!-- Waht The World is Learning Now? -->
    <div class="learnnow">
      <div class="container">
        <div class="row">
          <div class="col-lg-12">
            <h2>Waht The World is Learning Now?</h2>
            <p>Learn the latest technologies that are evolving in the market and build up a splendid portfolio to showcase <br>your skills and nail that perfect job with apt expertise and knowledge.</p>
            <div class="table-responsive">
              <table class="table">
                <tbody><tr>
                  <td class="green">aws</td>
                  <td>RedHat</td>
                  <td>ccna</td>
                  <td class="orange">python</td>
                  <td>ansible</td>
                  <td class="orange">hadoop</td>
                </tr>
                <tr>
                  <td class="green">devops</td>
                  <td class="orange">linus</td>
                  <td class="orange">aws</td>
                  <td>Linus</td>
                  <td class="green">php</td>
                  <td class="orange">ccna</td>
                </tr>
                <tr>
                  <td class="green">aws</td>
                  <td>aws</td>
                  <td>linux</td>
                  <td class="orange">python</td>
                  <td class="green">aws</td>
                  <td class="orange">aws</td>
                </tr>
                <tr>
                  <td class="green">python</td>
                  <td class="blue">aws</td>
                  <td class="orange">linux</td>
                  <td>python</td>
                  <td class="green">aws</td>
                  <td class="orange">aws</td>
                </tr>
              </tbody></table>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Our Mission/Vision -->
    <div class="missionvision">
      <div class="container">
        <div class="row">
          <div class="col-lg-4 col-md-12">
            <h2><?php echo $our_mission['title'] ?></h2>
            <p><?php echo $our_mission['description'] ?></p>
          </div>
          <div class="col-lg-4 col-md-6 col-sm-6">
            <div class="ourvision">
              <img src="<?php echo $our_mission['our_mission_image'] ?>" class="img-fluid" alt="">
              <h5>Our Mission</h5>
            </div>
          </div>
          <div class="col-lg-4 col-md-6 col-sm-6">
            <div class="ourvision">
              <img src="<?php echo $our_mission['our_vision'] ?>" class="img-fluid" alt="">
              <h5>Our Vision</h5>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Partner with Us -->
    <div class="container">
      <div class="partnerwith">
        <div class="row d-flex align-items-center">
          <div class="col-lg-4">
            <h2><?php echo $partner['title'] ?></h2>
            <a href="<?php echo $partner['apply_now_url'] ?>" class="btn btn-dark d-none d-md-block">apply now</a>
          </div>
          <div class="col-lg-8">
            <p><?php echo $partner['description'] ?></p>
            <a href="<?php echo $partner['apply_now_url'] ?>" class="btn btn-dark d-block d-md-none mt-3">apply now</a>
          </div>
        </div>
      </div>
    </div>

    <!-- Awards & Recognitions -->
    <div class="awardrec">
      <div class="container">
        <div class="row">
          <div class="col-lg-4 col-md-12">
            <h2><?php echo $awards_recognitions['title'] ?></h2>
<?php echo wpautop($awards_recognitions['description']) ?>
          </div>
          <div class="col-lg-4 col-md-6 col-sm-6">
            <div class="imgbox aw">
              <img src="<?php echo $awards_recognitions['awards'] ?>" class="img-fluid" alt="">
              <h5>AWARDS</h5>
              <a href="<?php echo $awards_recognitions['award_url'] ?>" class="arrow"><img src="<?php echo get_stylesheet_directory_uri() ?>/images/arrow.png" alt=""></a>
            </div>
          </div>
          <div class="col-lg-4 col-md-6 col-sm-6">
            <div class="imgbox re">
              <img src="<?php echo $awards_recognitions['recognitions_image'] ?>" class="img-fluid" alt="">
              <h5>RECOGNITIONS</h5>
              <a href="<?php echo $awards_recognitions['recognitions__url'] ?>" class="arrow"><img src="<?php echo get_stylesheet_directory_uri() ?>/images/arrow.png" alt=""></a>
            </div>
          </div>
        </div>
      </div>
    </div>

<?php
 include "components/faq.php";
get_footer();