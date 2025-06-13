

  





  <!-- new html -->

  <div class="recentplacement whychoose wow fadeInLeft section-padding bg-theme-light bg-image-hide">

      <div class="tabbed-content">

        <div class="container">

          <div class="row justify-content-center text-center">

            <div class="col-lg-8 mb-0 mb-lg-5">

              <h2>Why Choose us?<br><span>Specialisation Course - An Overview</span></h2>

            </div>

          </div>



          <!-- <nav class="tabs text-center">

            <ul>

              <li><a href="#tab11" class="active">Our Alumni work in top companies</a></li>

              <li><a href="#tab12">About GRRAS Solutions</a></li>

              <li><a href="#tab13">Market Trends</a></li>

              

            </ul>

          </nav> -->

          <section id="tab11" class="item active">

            <div class="item-content">

             <div class="owl-carousel featured-course">

                   <?php

                                // Custom query to get 'career_success_story' posts with 'story_types' term 'rating-page'

                                $args = array(

                                    'post_type' => 'placements',

                                    'hide_empty' => true,



                                    'tax_query' => array(

                                        array(

                                            'taxonomy' => 'placement_category',

                                            'field'    => 'slug',

                                            'terms'    => 'our-alumni-work-in-top-companies',

                                        ),

                                        

                                    ),

                                );



                                // Create a new query

                                $custom_query = new WP_Query($args);//echo "<pre>"; print_r($custom_query); exit;

                                if ($custom_query->have_posts()) {





                                    // Loop through the posts

                                    while ($custom_query->have_posts()) {

                                        $custom_query->the_post();



                                ?>

              <div class="item">

                   <a href="<?php echo site_url('placement-support'); ?>" class="global-link">

                <div class="cousebox">

                  <div class="employ"><img src="<?php echo get_the_post_thumbnail_url(); ?>" class="img-fluid" alt=""></div>

                  <div class="name">

                    <h4><?php the_title(); ?></h4>

                    <div class="subtxt"><?php the_field("designation") ?></div>

                  </div>

                  <div class="coname"><img src="<?php the_field("company") ?>" alt=""></div>

                  <div class="content">

                    <h5><?php the_field("course_undertaken") ?></h5>

                    <div class="placement_contant"><?php the_content() ?></div>

                    <a href="<?php echo site_url('placement-support'); ?>" class="link placement_show">Read more</a>

                  </div>

                </div>

                </a>

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

             <div class="text-center mt-4 mt-md-0"><a href="/review-rating" class="btn btn-primary">Read All Success Stories</a></div>

            </div>

          </section>

          <section id="tab12" class="item">

            <div class="item-content">

              <div class="content">

               <?php echo get_field('about_grras_solutions','option') ?>

              </div>

               <div class="text-center mt-5"><a href="/aboutus" class="btn btn-primary">About Us</a></div>

            </div>

          </section>

          <section id="tab13" class="item">

            <div class="item-content">

              <div class="row">

         <?php if( have_rows('market_trends') ): ?>

   

        <?php while( have_rows('market_trends') ): the_row(); 

         

        ?>

            <div class="col-md-3">

                  <div class="content cobox">

                  <?php echo get_sub_field('content'); ?>

                  </div>

                </div>

        <?php endwhile; ?>



<?php endif; ?>



               

         

              </div>

              

            </div>

          </section>                

          

         

        </div>

      </div>

    </div>