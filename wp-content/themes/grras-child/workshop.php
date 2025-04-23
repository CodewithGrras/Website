<?php

/**
 * Template Name: Workshop
 */
get_header();
$join_grass = get_field('join_grass');
include 'components/WorkShopPage.php';
?>
<!-- Join Grras WhatsApp Community -->
<div class="container">
  <div class="joingrass">
    <div class="row">
      <div class="col-lg-10">
        <h2><?php echo $join_grass['title'] ?></h2>
        <div class="subtext"><?php echo $join_grass['sub_title'] ?></div>
      </div>
      <div class="col-lg-2">
        <div class="qrcode">
          <img src="<?php echo $join_grass["qr_code"] ?>" class="img-fluid" alt="">
          <div class="textsmall"><?php echo $join_grass["sub_title_qr"] ?></div>
        </div>
      </div>
      <?php foreach ($join_grass['points'] as $item) { ?>
        <div class="col-md-3">
          <h4><?php echo $item["title"] ?></h4>
          <p><?php echo $item["short_description"] ?></p>
        </div>
      <?php } ?>
    </div>
  </div>
</div>

<!-- Glimpse, you can’t afford to miss -->
<div class="glimpse">
  <div class="container">
    <div class="row">
      <div class="col-lg-12">
        <h2 class="text-center"><?php echo get_field('glimpse_title'); ?></h2>
        <div class="gilscroll">
        <ul>
    <?php
    if (have_rows('students_video')):
$i = 0;
        while (have_rows('students_video')): the_row();
            $thumbnail = get_sub_field('thumbnail');
            $name = get_sub_field('name');
            $video_link = get_sub_field('video_link');
    $i++;
    ?>
            <li>
                <div class="imgbox">
                    <img src="<?php echo esc_url($thumbnail); ?>" alt="">
                </div>
                <a href="#" data-bs-toggle="modal" data-bs-target="#exampleModal-<?php echo esc_attr($name) . $i; ?>" class="play">
                    <img src="<?php echo esc_url(get_stylesheet_directory_uri() . '/images/gilplay.jpg'); ?>" alt="">
                </a>
                <p><?php echo esc_html($name); ?></p>
            </li>

    <?php
        endwhile;

    endif;
    ?>

    <!-- Modal -->
    <?php if (have_rows('students_video')): 
      $i = 0;
      ?>
        <?php while (have_rows('students_video')): the_row(); 
            $video_link = get_sub_field('video_link');
            $i++;
             $name = get_sub_field('name');
            ?>
            <div class="modal fade" id="exampleModal-<?php echo esc_attr($name) . $i; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        <div class="modal-body">
                            <iframe width="100%" height="315" src="<?php echo esc_url($video_link); ?>" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
                        </div>
                    </div>
                </div>
            </div>
        <?php endwhile; ?>
    <?php endif; ?>
</ul>
</div>

      </div>
    </div>
  </div>
</div>


<!-- See what learners are saying -->
<div class="learners wow fadeInRight">
  <div class="container">
    <div class="text-center">
      <h2>See what learners are saying</h2>
    </div>
    <div class="owl-carousel featured-course">
      <?php
      if (have_rows('what_learners')):
        while (have_rows('what_learners')): the_row();
      ?>
          <div class="item">
            <div class="content">
              <img src="<?php echo esc_url(get_sub_field('image')) ?>" alt="">
              <img src="<?php echo esc_url(get_sub_field('review_image')) ?>" alt="">
              <p><?php echo get_sub_field('short_description') ?></p>
              <h4><?php echo get_sub_field('name') ?></h4>
            </div>
          </div>

      <?php
        endwhile;

      endif;
      ?>

    </div>
  </div>
</div>

<!-- Faq -->
<?php include 'components/faq.php' ?>

<?php
get_footer();
