<!-- Career Success Stories -->
<?php
// Custom query to get 'career_success_story' posts with 'story_types' term 'rating-page'
$args = array(
    'post_type' => 'career_success_story',
    'tax_query' => array(
        array(
            'taxonomy' => 'story_types',
            'field'    => 'slug',
            'terms'    => 'course-page',
            
        ),
    ),
);

// Create a new query
$custom_query = new WP_Query($args);
?>
<div class="row">
    <div class="owl-carousel success-story">
        <?php
    if ($custom_query->have_posts()) {
        // Loop through the posts
        $i = 0;
        while ($custom_query->have_posts()) {
            $i++;
            $custom_query->the_post();
    ?>
            <div class="item">
              <div class="carbox" href="#exampleModasdfsdl-<?php echo $i; ?>" data-bs-toggle="modal" data-bs-target="#exampleModasdfsdl-<?php echo $i; ?>">
                <div class="bigimg"><img src="<?php the_post_thumbnail_url(); ?>" class="img-fluid" alt=""></div>
                <a href="#exampleModasdfsdl-<?php echo $i; ?>" class="play" data-bs-toggle="modal" data-bs-target="#exampleModasdfsdl-<?php echo $i; ?>"><img src="<?php echo get_stylesheet_directory_uri() ?>/images/caree-play1.png" alt=""></a>
                <div class="company"><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/auto.png" class="img-fluid" alt=""></div>
                <div class="coname">
                  <h4><?php the_title(); ?></h4>
                  <p><?php echo get_field('post_designation')?> - <?php echo get_field('location'); ?></p>
                </div>
              </div>
            </div>
          <?php
        }
    } else {
        echo 'No success stories found.';
    }
      wp_reset_postdata();
    ?>
          </div>


    <?php
    if ($custom_query->have_posts()) {
        // Loop through the posts
        $i = 0;
        while ($custom_query->have_posts()) {
            $i++;
            $custom_query->the_post();

            $video_link = get_field('video_link');
    ?>
            <div class="youtubeModal modal fade" data-owl-carousel=".success-story" id="exampleModasdfsdl-<?php echo $i; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        <div class="modal-body">
                            <iframe class="youtubeIframe" width="100%" height="315" src="<?php echo esc_url($video_link); ?>" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
                        </div>
                    </div>
                </div>
            </div>
    <?php
        }
    } else {
        echo 'No success stories found.';
    }
    // Reset post data
    wp_reset_postdata();
    ?>
         
</div>

<div class="text-center pt-3">
    <a href="<?php get_link_custom('review-rating') ?>" class="btn btn-primary">Read Our Success Stories</a>
</div>