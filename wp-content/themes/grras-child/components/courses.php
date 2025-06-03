<?php



$args = array(

    'post_type' => 'internships',

    array(

        'taxonomy' => 'internship_types',

        'field'    => 'slug',



    )

);



// Create a new query

$custom_query = new WP_Query($args);

// Step 1: Retrieve the terms without ordering

$terms = get_terms(array(

    'taxonomy' => 'internship_types',

    'hide_empty' => true

));



// Step 2: Create an array with the desired order

$desired_order = array('All', '30 Days', '45 Days', '3 Months', '6 Months');



// Step 3: Sort the terms based on the desired order

usort($terms, function($a, $b) use ($desired_order) {

    $pos_a = array_search($a->name, $desired_order);

    $pos_b = array_search($b->name, $desired_order);

    return $pos_a - $pos_b;

});

?>

<!-- course -->



<!-- course -->

    <div class="intcourse coursesec wow fadeInUp">

      <div class="container">

        <div class="row">

          <div class="col-lg-12 text-center">

            <div class="proven">proven placement record</div>

            <h2><?php echo get_field("placement_short_description"); ?><span><?php echo get_field("proven_title"); ?></span></h2>

          </div>

<div class="col-12">

    <ul class="nav intab" id="myTab" role="tablist">

        <?php

        // Check if there are terms to display

        if (!empty($terms) && !is_wp_error($terms)) {

            $i = 0;

            foreach ($terms as $term) {

        ?>

        <li class="nav-item" role="presentation">

            <a href="#" class="nav-link <?php echo ($i == 0 ? "active" : "") ?>" id="ss<?php echo $term->slug ?>-tab" data-bs-toggle="tab" data-bs-target="#ss<?php echo $term->slug ?>-tab-pane" role="tab" aria-controls="ss<?php echo $term->slug ?>-tab-pane" aria-selected="false"><?php echo esc_html($term->name) ?></a>

        </li>

        <?php

        $i++;

            }

        } else {

            echo 'No categories found.';

        }

        ?>

    </ul>

</div>



<div class="tab-content" id="myTabContent">

    <!-- tab1 -->

    <?php

    if (!empty($terms) && !is_wp_error($terms)) {

        $k = 0;

        foreach ($terms as $term) {

    ?>

    <div class="tab-pane fade <?php echo ($k == 0 ? "show active" : "") ?>" id="ss<?php echo $term->slug ?>-tab-pane" role="tabpanel" aria-labelledby="ss<?php echo $term->slug ?>-tab" tabindex="0">

        <div class="d-none d-sm-block">

            <div class="row" id="">

                <?php

                $args = array(

                    'post_type' => 'internships',

                    'tax_query' => array(

                        array(

                            'taxonomy' => 'internship_types',

                            'field'    => 'slug',

                            'terms'    => $term->slug,

                        ),

                    ),

                );



                $courses_query = new WP_Query($args);



                if ($courses_query->have_posts()) :

                    while ($courses_query->have_posts()) : $courses_query->the_post();

                ?>

                <div class="col-lg-3 col-md-4 col-sm-6 col-6 g-3">

                    <?php get_template_part('template-parts/intern', 'internships'); ?>

                </div>

                <?php

                    endwhile;

                else :

                    echo '<p>No courses found.</p>';

                endif;



                wp_reset_postdata();

                ?>

            </div>

        </div>

          <div class="course-mobile d-block d-sm-none">

               <?php

                $args1 = array(

                    'post_type' => 'internships',

                    'tax_query' => array(

                        array(

                            'taxonomy' => 'internship_types',

                            'field'    => 'slug',

                            'terms'    => $term->slug,

                        ),

                    ),

                );



                $courses_query1 = new WP_Query($args1);



                if ($courses_query1->have_posts()) :

                    while ($courses_query1->have_posts()) : $courses_query1->the_post();

               $course_terms1 = get_the_terms(get_the_ID(), 'internship_types');

             $term_names = [];    

            if ($course_terms1) {

              foreach ($course_terms1 as $term) {

                $term_classes .= ' ' . esc_attr($term->slug);

                $term_names[] = $term->name;    

              }

            }

            ?>

             <a href="<?php the_permalink(); ?>">

             <div class="cobox">

                    <div class="imgbox">

                      <img src="<?php echo get_field('mobile_background_image')?>" class="img-fluid bigimg" alt="">

                      <div class="imgcontent">

                        <div class="icon"><img src="<?php the_post_thumbnail_url(); ?>" class="img-fluid" alt=""></div>

                      </div>

                      <?php if (get_field('discount')) : ?>

                          <div class="offer"><?php echo get_field('discount'); ?><span>%</span> OFF</div>               

                        <?php endif; ?>

                    </div>

                    <div class="right-content">

                      <div class="<?php echo get_field('best_seller_color'); ?>"><?php echo get_field('best_seller'); ?></div>

                      <h4> <small><?php echo $term_names[0]?></small><br><?php the_title(); ?></h4>

                

                          <?php the_content()?>



                      <div class="content">

                        <div class="row">

                          <div class="col-md-6 col-6">

                            <div class="star">

                                <?php 

                                $rating = get_field('rating');

                                for($i = 1; $i <= $rating; $i++){

?>

                                <span class="star star-enabled">★</span>

<?php

                                }

                                ?>



                                &nbsp; <?php echo $rating?>/5 <span>(<?php echo get_field('review_count')?>)</span>

                              </div>

                          </div>

                          <div class="col-md-6 col-6">

                            <div class="day">
                                <img src="<?php echo get_stylesheet_directory_uri() ?>/images/days.svg" alt=""> <?php echo get_field('days'); ?> Day</div>

                          </div>

                        </div>

                      </div>              

                    </div>

                  </div>

            </a>

                 <?php

                    endwhile;

                else :

                    echo '<p>No courses found.</p>';

                endif;



                wp_reset_postdata();

                ?>

              </div>

    </div>

    <?php

        $k++;

        }

    } else {

        echo 'No categories found.';

    }

    ?>

      <!-- course mobile -->



</div>



            

        </div>



      </div>

    </div>





<script>

document.addEventListener('DOMContentLoaded', function() {

showItems('view-more','#row-container','.col-lg-4.col-md-6.col-sm-6.g-3.single-content.grid-item','program-count');

showDefault('view-more','#row-container .col-lg-4.col-md-6.col-sm-6.g-3.single-content.grid-item','#row-container','.col-lg-4.col-md-6.col-sm-6.g-3.single-content.grid-item','program-count',3);

});

</script>