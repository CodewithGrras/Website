<?php



/**

 * Template Name: Course

 *  */

get_header();



?>







<!-- Featured Courses -->



    <!-- search breadcumb -->

    <nav aria-label="breadcrumb" class="breadcrumb">

      <div class="container">

        <ol class="breadcrumb">

          <li class="breadcrumb-item"><a href="https://webnew.grras.com">Home</a></li>

          <li class="breadcrumb-item active" aria-current="page">Course</li>

        </ol>

      </div>

    </nav>





    <!-- course banner -->

          <?php include 'components/courseBanner.php'; ?>

    <!-- course desktop -->

<?php include "components/featured-courses.php"; ?>

    <!-- topchoice -->

<?php include "components/topChoicesCoursePage.php"; ?>





<!-- Browse by -->

<?php

// Custom query to get 'career_success_story' posts with 'story_types' term 'rating-page'

$args = array(

    'post_type' => 'courses',

    'tax_query' => array(

        array(

            'taxonomy' => 'course_types',

            'field'    => 'slug',

            'terms'    => 'international-certifications',

        ),

    ),

    'order' => 'DESC'

    

);



// Create a new query

$custom_query = new WP_Query($args);

if ($custom_query->have_posts()) {

?>

<div class="browseby wow fadeInUp">

    <div class="container">

        <div class="row">

            <div class="col-lg-12">

                <h2 class="text-center"><?php echo get_field('certifications_title') ?>s</h2>

            </div>



            <?php

                // Loop through the posts

                $i = 0;

                while ($custom_query->have_posts()) {

                    $i++;

                    $custom_query->the_post();

            ?>

           

                    <div class="col-lg-3 col-sm-6 col-6 g-2">

                        <a href="#" class="brwsbox <?php echo get_field('color') ?>">

                            <img src="<?php the_post_thumbnail_url() ?>" class="img-fluid" alt="">

                            <h4><?php the_title() ?></h4>

                        </a>

                    </div>

            <?php

                }

            // Reset post data

            wp_reset_postdata();

            ?>

        </div>

    </div>

</div>

<?php

}

include "components/course-workshops.php"; ?>



<!-- Traditional Education -->

<div class="tradedu wow fadeInLeft">

    <div class="container">

        <div class="row d-flex align-items-center m-0">

            <div class="col-lg-3">

                <h2>Grras<br><em>vs<br>Others</em></h2>

            </div>

            <div class="col-lg-9 m-0 p-0">

                <ul class="tainlist">

                    <?php if (have_rows('points')):

                        while (have_rows('points')): the_row();

                            $name = get_sub_field('name'); 

                    ?>

                            <li><?php echo $name; ?></li>

                        <?php endwhile; ?>



                    <?php endif; ?>

                </ul>

                <div class="edubox">

                    <h4>Traditional Education</h4>

                    <ul>

                    <?php if (have_rows('traditional_education')):

                        while (have_rows('traditional_education')): the_row();

                            $name = get_sub_field('name'); 

                    ?>

                            <li>

                                <img src="<?php echo get_sub_field('icon'); ?>" alt="">

                                <?php echo $name; ?></li>

                        <?php endwhile; ?>



                    <?php endif; ?>

                    </ul>

                </div>



                <div class="gsbenifit">

                    <h4>Grras Benefits</h4>

                    <ul>

                    <?php if (have_rows('grras_benefits')):

                        while (have_rows('grras_benefits')): the_row();

                            $name = get_sub_field('title'); 

                    ?>

                            <li><img src="<?php echo get_sub_field('icon'); ?>" alt=""><?php echo $name; ?></li>

                        <?php endwhile; ?>



                    <?php endif; ?>

                    </ul>

                </div>

              

            </div>

                

        </div>

    </div>

</div>







<!-- Trusted by Learners -->

<div class="successstory turst-learn wow fadeInUp">

    <div class="container">

        <h2 class="text-center">Trusted by Learners</h2>



        <div class="review">

                <?php if (have_rows('trusted_by_learners')): ?>



                <?php while (have_rows('trusted_by_learners')): the_row();

                    $image = get_sub_field('image'); // Adjust this to match your subfield name

                    $star_rating = get_sub_field('star_rating'); 

                ?>



                    <div class="fb-google-area d-flex align-items-center">

                        <div class="link text-start">

                            <a href="<?php echo get_sub_field('link') ?>">

                                <img src="<?php echo $image ?>" class="img-fluid" alt="<?php echo $image; ?>" style="max-width: 180px;">

                            </a>

                            <!-- <div class="rating d-flex">

                                <div class="stars">

                                    <?php for ($i = 1; $i <= 5; $i++) { ?>

                                        <span class="star star-enabled">★</span>

                                    <?php } ?>

                                </div>

                            </div> -->

                        </div>

                         <div class="rating-number fw-semibold px-4 ms-4"><?php echo $star_rating; ?></div>           
                    </div>

                <?php endwhile; ?>



                <?php endif; ?>

        </div>



      <?php include "components/course-stories.php"; ?>

    </div>

</div>

    

<?php

include "components/faq.php";

get_footer();

