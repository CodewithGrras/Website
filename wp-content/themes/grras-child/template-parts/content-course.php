
<div class="col-lg-3 col-md-6 col-sm-6">
    <div class="cousebox">
        <img src="<?php the_post_thumbnail_url(); ?>" class="icon" alt="">
        <div class="elecont">
            <h4><?php the_title(); ?></h4>
            <p><img src="<?php echo get_stylesheet_directory_uri() ?>/images/clock1.png" alt=""> <strong><?php echo get_field('course_duration'); ?> hours</strong></p>
            <p><img src="<?php echo get_stylesheet_directory_uri() ?>/images/calendar1.png" alt=""> <strong><?php echo get_field('course_days'); ?> days</strong></p>
            <a href="<?php the_permalink(); ?>" class="link">Know more</a>
        </div>
    </div>
</div>
