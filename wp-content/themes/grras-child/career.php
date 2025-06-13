<?php

/**

 * Template Name:  Career

 * 

 */

get_header();

?>

<!-- career banner -->

<!--<style>

    .career-banner {

    background: url(<?php echo get_field('banner_image') ?>)

}

</style>-->

<div class="career-banner">

      <div class="container">

        <div class="bcontent">

          <h2><?php echo get_field('banner_title') ?></h2>

          <p><?php echo get_field('banner_short_description') ?></p>

        </div>

      </div>

    </div>

<!-- Why join Grras -->

<div class="whyjoin">

    <div class="container">

        <div class="row">

            <div class="col-lg-12">

                <h2 class="text-center">

                    <?php

                    $why_join = get_field('why_join');

                    echo $why_join["title"];

                    ?>

                </h2>

                <p><?php echo $why_join["sub_title"]; ?></p>

            </div>

            <?php if (have_rows('points')): ?>



                <?php while (have_rows('points')): the_row(); ?>

                    <div class="col-lg-4 col-sm-6">

                        <div class="iconbox">

                            <img src="<?php echo get_sub_field('icon') ?>" alt="">

                            <h4><?php echo get_sub_field('title') ?></h4>

                            <p><?php echo get_sub_field('description') ?></p>

                        </div>



                    </div>

                <?php endwhile; ?>



            <?php endif; ?>



        </div>

    </div>

</div>



<!-- Job Openings -->

<div class="jobopen">

    <div class="container">

        <div class="row">

            <div class="col-lg-12">

                <h2 class="text-center">Job Openings</h2>

            </div>

        </div>



        <?php

        // WP Query to get Career custom post type

        $args = array(

            'post_type' => 'career',    // The custom post type for careers

            'posts_per_page' => -1,     // Fetch all career posts

        );

        $careers_query = new WP_Query($args);



        if ($careers_query->have_posts()) :

            while ($careers_query->have_posts()) : $careers_query->the_post();

                // Get custom fields using ACF (if you've created them)

                $job_location = get_field('locate');

                $post_date = get_the_date('F j, Y'); // Date when the job was posted

                ?>



                <div class="jobox">

                        <a href="<?php echo get_post_permalink();?>" style="text-decoration: none;">

                    <div class="row align-items-center">

                        <div class="col-md-6 col-sm-6">

                            <div class="date">Posted on <?php echo esc_html($post_date); ?></div>

                            <h4>

                             

                                 <?php the_title(); ?>

                        </h4>

                        </div>

                        <div class="col-md-6 col-sm-6">

                            <div class="time"><?php echo esc_html($job_location ); ?></div>

                        </div>

                    </div>

                                </a>   

                </div>



            <?php

            endwhile;

        else :

            echo '<p>No job openings found.</p>';

        endif;

        

        wp_reset_postdata();

        ?>



        <div class="mt-5 text-center d-none">

            <a href="#" class="btn btn-secondary">View More Openings</a>

        </div>

    </div>

</div>



<?php

include 'components/faq.php';

get_footer();

