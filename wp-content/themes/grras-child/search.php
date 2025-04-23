<?php
/**
 * Template Name: Search
 */

get_header();

// Get the search query
$search = isset($_GET['q']) ? sanitize_text_field($_GET['q']) : '';

// Redirect to the home page if no search query is provided
if (empty($search)) {
    
    // wp_redirect(home_url());
    // exit;
}
 
        $args = array(
             's' => $search,
            'post_type' => 'courses',
          
        );
        $courses_query = new WP_Query($args);
        $args1 = array(
             's' => $search,
            'post_type' => 'internships',
          
        );
        $courses_query1 = new WP_Query($args1);
       
        $args2 = array(
             's' => $search,
            'post_type' => 'workshops',
          
        );
        $courses_query2 = new WP_Query($args2);
        
        $args3 = array(
             's' => $search,
            'post_type' => 'post',
          
        );
        $courses_query3 = new WP_Query($args3);
        $args4 = array(
             's' => $search,
            'post_type' => 'placements',
          
        );
        $courses_query4 = new WP_Query($args4);



 ?>

 <!-- search breadcumb -->
    <nav aria-label="breadcrumb" class="breadcrumb">
      <div class="container">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="https://webnew.grras.com">Home</a></li>
          <li class="breadcrumb-item active" aria-current="page">Search</li>
        </ol>
      </div>
    </nav>


    <!-- search start -->
    <div class="intcourse wow fadeInUp">
      <div class="container">
        <div class="row">
          <div class="col-lg-3"> </div>
          <div class="col-lg-7">
            <h2><?php 
echo count($courses_query->posts) + count($courses_query1->posts) + count($courses_query2->posts) + count($courses_query3->posts) + count($courses_query4->posts); 
?>
 Resources found for “<?php echo $search?>”</h2>
          </div>
        </div>
        <div class="row">
          <div class="col-lg-3 top-fixed3">
            <ul class="nav left-tab">
              <li class="nav-item">
               <a href="#courses" class="nav-link active">courses (<?php echo count($courses_query->posts); ?>)</a>

              </li>
              <li class="nav-item">
                <a href="#internship" class="nav-link">Internship courses (<?php echo count($courses_query1->posts); ?>)</a>
              </li>
              <li class="nav-item">
                <a href="#workshop" class="nav-link">Workshop/ Webinars (<?php echo count($courses_query2->posts); ?>)</a>
              </li>
              <li class="nav-item">
                <a href="#blogs" class="nav-link">Blogs/ Articles (<?php echo count($courses_query3->posts); ?>)</a>
              </li>
              <!--<li class="nav-item">-->
              <!--  <a href="#ebooks" class="nav-link">Ebooks (23)</a>-->
              <!--</li>-->
              <li class="nav-item">
                <a href="#placement" class="nav-link">Placement (<?php echo count($courses_query4->posts); ?>)</a>
              </li>
            </ul>
          </div>
          <div class="col-lg-9">
            <!-- Courses -->
             <?php
             if ($courses_query->have_posts()) : 
             ?>
            <div class="d-none d-sm-block">
              <div class="row serach-course intcourse coursesec p-0" id="courses">
                <div class="col-md-12">
                  <h2>Courses</h2>
                </div>
                  <div class="row" id="row-container">
         <?php

        if ($courses_query->have_posts()) :
          while ($courses_query->have_posts()) : $courses_query->the_post();
            $course_terms = get_the_terms(get_the_ID(), 'course_types');
            $term_classes = '';
            $term_names = [];    
            if ($course_terms) {
              foreach ($course_terms as $term) {
                $term_classes .= ' ' . esc_attr($term->slug);
                $term_names[] = $term->name;    
              }
            }
            ?>
                  <div class="col-lg-4 col-md-6 col-sm-6 col-6 g-3">
                    <?php get_template_part('template-parts/details', 'course');  ?>
                  </div>
                  <?php endwhile;
        else :
          echo '<p>No courses found.</p>';
        endif;

        wp_reset_postdata();
        ?>
                  <div class="col-md-12 g-3 text-center">
                    <p><span id="program-count"></span></p>
                    <a href="#" class="btn btn-outline-primary mt-3 rounded-pill" id="course-view">View More</a>
                  </div>
                </div>
               
              </div>
            </div>

            <!-- course mobile -->
            <div class="intcourse coursesec d-block d-sm-none p-0">
              <div class="course-mobile">
                <h2>Courses</h2>
                <div id="row-container-5">
                     <?php

        if ($courses_query->have_posts()) :
          while ($courses_query->have_posts()) : $courses_query->the_post();
            $course_terms = get_the_terms(get_the_ID(), 'course_types');
            $term_classes = '';
            $term_names = [];    
            if ($course_terms) {
              foreach ($course_terms as $term) {
                $term_classes .= ' ' . esc_attr($term->slug);
                $term_names[] = $term->name;    
              }
            }
            ?>
                 <a href="<?php the_permalink(); ?>" class="course-mobile-s">
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
                        <?php if(get_field('best_seller_color') != "--Choose--"): ?>
                      <div class="<?php echo get_field('best_seller_color'); ?>">Best Seller</div>
                      <?php endif; ?>
                      <h4> <small><?php echo $term_names[0]?></small><br><?php the_title(); ?></h4>
                      <p><?php the_content()?></p>
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
                            <div class="day"><img src="<?php echo get_stylesheet_directory_uri() ?>/images/days.svg" alt=""> <?php echo get_field('days'); ?> Day</div>
                          </div>
                        </div>
                      </div>              
                    </div>
                  </div>
            </a>
             <?php endwhile;
        else :
          echo '<p>No courses found.</p>';
        endif;

        wp_reset_postdata();
        ?>
            </div>
                <div class="col-md-12 g-3 text-center serach-course">
                  <p><span id="program-count-5"></span></p>
                  <a href="#" class="btn btn-outline-primary my-3 rounded-pill" id="view-more-5">View More</a>
                </div>
              </div>
            </div>
 <?php
             endif; 
             ?>
            <!-- Internship courses -->
            <?php
            if ($courses_query1->have_posts()) : ?>
            <div class="d-none d-sm-block">
              <div class="row serach-course intcourse coursesec p-0" id="internship">
                <div class="col-md-12">
                  <h2>Internship courses</h2>
                </div>
 <div class="row" id="row-container-1">
                  <?php

        if ($courses_query1->have_posts()) :
          while ($courses_query1->have_posts()) : $courses_query1->the_post();
            
            ?>
                  <div class="col-lg-4 col-md-6 col-sm-6 col-6 g-3">
                    <?php get_template_part('template-parts/intern', 'internships');  ?>
                  </div>
                  <?php endwhile;
        else :
          echo '<p>No courses found.</p>';
        endif;

        wp_reset_postdata();
        ?>
            </div>
             
                <div class="col-md-12 g-3 text-center">
                  <p><span id="program-count-1"></span></p>
                  <a href="#" class="btn btn-outline-primary my-3 rounded-pill" id="course-view-1">View More</a>
                </div>
              </div>
            </div>

            <!-- Internship course mobile -->
            <div class="intcourse coursesec d-block d-sm-none p-0">
              <div class="course-mobile">
                <h2>Internship courses</h2>
                
                
 <div id="row-container-6">bestseller
                     <?php

        if ($courses_query1->have_posts()) :
          while ($courses_query1->have_posts()) : $courses_query1->the_post();
            $course_terms = get_the_terms(get_the_ID(), 'internship_types');
            $term_classes = '';
            $term_names = [];    
            if ($course_terms) {
              foreach ($course_terms as $term) {
                $term_classes .= ' ' . esc_attr($term->slug);
                $term_names[] = $term->name;    
              }
            }
            ?>
                 <a href="<?php the_permalink(); ?>" class="course-mobile-s">
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
                      <?php if(get_field('best_seller_color')): ?>
                      <div class="<?php echo get_field('best_seller_color'); ?>">Best Seller</div>
                      <?php endif; ?>
                      <h4> <small><?php echo $term_names[0]?></small><br><?php the_title(); ?></h4>
                      <p><?php the_content()?></p>
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
                            <div class="day"><img src="<?php echo get_stylesheet_directory_uri() ?>/images/days.svg" alt=""> <?php echo get_field('days'); ?> Day</div>
                          </div>
                        </div>
                      </div>              
                    </div>
                  </div>
            </a>
             <?php endwhile;
        else :
          echo '<p>No courses found.</p>';
        endif;

        wp_reset_postdata();
        ?>
            </div>
                <div class="col-md-12 g-3 text-center serach-course">
                  <p><span id="program-count-6"></span></p>
                  <a href="#" class="btn btn-outline-primary my-3 rounded-pill" id="view-more-6">View More</a>
                </div>
              </div>
            </div>
<?php
             endif; 
             ?>
            <!-- Workshop/ Webinars -->
            <?php 
             if ($courses_query2->have_posts()): 
             ?>
            <div class="row serach-course" id="workshop">
              <div class="col-md-12">
                <h2>Workshop/ Webinars</h2>
              </div>
                 <div class="row" id="row-container-2">
                        <?php
                        if ($courses_query2->have_posts()) {
                            // Loop through the posts
                            while ($courses_query2->have_posts()) {
                                $courses_query2->the_post();
                                $terms = get_the_terms(get_the_ID(), 'courses');
                        ?>
                                <?php
                                if ($terms && !is_wp_error($terms)) {
                                    $term_names = []; // Initialize an array to hold term names
                                    foreach ($terms as $term) {
                                        // Assuming $term is an object and you want its name
                                        $term_names[] = $term->slug; // Collect term names
                                    }
                                    $term_string = implode(' ', $term_names);
                                }

                                // Determine the workshop status
                                $start_time = get_field('workshop_start_time'); // Make sure this is the correct field name
                                $end_time = get_field('workshop_end_time'); // Make sure this is the correct field name
                               
// Current time
$current_time = date('Y-m-d H:i:s'); // Fetches the current time in the proper format

// Initialize status
$status = '';

if ($start_time && $end_time) {
    // Convert start and end times into DateTime objects
    $start_date_time = DateTime::createFromFormat('Y-m-d H:i:s', $start_time);
    $end_date_time = DateTime::createFromFormat('Y-m-d H:i:s', $end_time);
    $current_date_time = DateTime::createFromFormat('Y-m-d H:i:s', $current_time);

    if ($start_date_time && $end_date_time && $current_date_time) {
        // Compare current time with start and end times
        if ($current_date_time >= $start_date_time && $current_date_time <= $end_date_time) {
            $status = 'live';
        } elseif ($current_date_time < $start_date_time) {
            $status = 'upcoming';
        } else {
            $status = 'past';
        }
    } else {
        error_log('Invalid date format for start_time, end_time, or current_time.');
    }
} else {
    error_log('Start time or end time is missing.');
}


                                ?>
                                <div class="col-lg-6 col-md-6 col-sm-6 g-3">
                                    <div class="cousebox">
                                        <img src="<?php the_post_thumbnail_url() ?>" class="img-fluid" alt="">
                                        <div class="<?php echo $status; ?>">
                                            <?php echo ucfirst($status); ?>
                                        </div>
                                        <div class="content">
                                            <div class="detail">
                                                <h4><?php the_title(); ?></h4>
                                                <div class="date">
                                                    <?php
                                                    // Display formatted date
                                                    if ($start_date_time) {
                                                        echo $start_date_time->format('jS M, D');
                                                    } else {
                                                        echo 'Invalid start time';
                                                    }
                                                    ?>
                                                </div>
                                                <div class="time">
                                                    <?php
                                                    // Display formatted time range
                                                    if ($start_date_time && $end_date_time) {
                                                        echo $start_date_time->format('h:i A') . ' - ' . $end_date_time->format('h:i A');
                                                    } else {
                                                        echo 'Invalid time range';
                                                    }
                                                    ?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="botmcontent">
                                            <p><strong><?php the_field('register_people'); ?> people have registered</strong></p>
                                            <a href="<?php echo get_post_permalink(); ?>" class="btn btn-success"><?php echo $status == 'past' ? "View Past Event": "Register Now"?></a>
                                        </div>
                                    </div>
                                </div>
                        <?php
                            }
                        } else {
                            echo 'No workshops found.';
                        }
                        // Reset post data
                        wp_reset_postdata();
                        ?>
                    </div>
              <!--<div class="col-lg-6 col-md-6 col-sm-6 g-3">-->
              <!--  <div class="cousebox">-->
              <!--    <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/workshop1.jpg" class="img-fluid" alt="">-->
              <!--    <div class="live">Live</div>-->
              <!--    <div class="content">-->
              <!--      <div class="detail">-->
              <!--        <h4><a href="#">Master Backtracking: From Basics to Advanced for SDEs</a></h4>-->
              <!--        <div class="date">13th Jul, Sat</div>-->
              <!--        <div class="time">07:00 PM - 09:00 PM</div>-->
              <!--      </div>-->
              <!--    </div>-->
              <!--    <div class="botmcontent">-->
              <!--      <p><strong>2250 people have registered</strong></p>-->
              <!--      <a href="#" class="btn btn-success d-block">Register Now</a>-->
              <!--    </div>-->
              <!--  </div>-->
              <!--</div>-->
       
              
              <div class="col-md-12 g-3 text-center">
                <p><span id="program-count-2"></span></p>
                <a href="#" class="btn btn-outline-primary my-3 rounded-pill" id="view-more-2">View More</a>
              </div>
            </div>
<?php endif; ?>
            <!-- Blogs/ Articles -->
             <?php 
             if ($courses_query3->have_posts()): 
             ?>
            <div class="row serach-course" id="blogs">
              <div class="col-md-12">
                <h2>Blogs/ Articles</h2>
              </div>
               <div class="row" id="row-container-3">
               <?php

        if ($courses_query3->have_posts()) :
          while ($courses_query3->have_posts()) : $courses_query3->the_post();
            
            ?>
                  <div class="col-lg-4 col-sm-6 col-6 g-3">
              <?php get_template_part('template-parts/content', 'posts');  ?>
              </div>
                  <?php endwhile;
        else :
          echo '<p>No courses found.</p>';
        endif;

        wp_reset_postdata();
        ?>
              
              </div>
              <div class="col-md-12 g-3 text-center">
                <a href="#" class="btn btn-outline-primary my-3 rounded-pill" id="view-more-3">View More</a>
              </div>
            </div>
<?php
             endif; 
             ?>
            <!-- Ebooks -->
            <!--<div class="row serach-course" id="ebooks">-->
            <!--  <div class="col-md-12">-->
            <!--    <h2>Ebooks</h2>-->
            <!--  </div>-->
            <!--  <div class="col-lg-4 col-sm-6 col-6 g-3">-->
            <!--    <div class="blog-content ">-->
            <!--      <div class="imgbox"><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/bb1.png" class="img-fluid" alt=""></div>-->
            <!--      <div class="contentbox">-->
            <!--        <h4><a href="#">How to Automate the Deployment Pipeline in Azure DevOps?</a></h4>-->
            <!--        <div class="mt-4">-->
            <!--          <div class="date"><a href="#" class="btn btn-outline-secondary btn-sm">Ebooks</a></div>-->
            <!--          <div class="read mt-2"><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/download.png" class="mx-2" alt="">5032</div>-->
            <!--        </div>-->
            <!--      </div>-->
            <!--    </div>-->
            <!--  </div>-->
            <!--  <div class="col-lg-4 col-sm-6 col-6 g-3">-->
            <!--    <div class="blog-content ">-->
            <!--      <div class="imgbox"><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/bb1.png" class="img-fluid" alt=""></div>-->
            <!--      <div class="contentbox">-->
            <!--        <h4><a href="#">How to Automate the Deployment Pipeline in Azure DevOps?</a></h4>-->
            <!--        <div class="mt-4">-->
            <!--            <div class="date"><a href="#" class="btn btn-outline-secondary btn-sm">Ebooks</a></div>-->
            <!--            <div class="read mt-2"><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/download.png" class="mx-2" alt="">5032</div>-->
            <!--        </div>-->
            <!--      </div>-->
            <!--    </div>-->
            <!--  </div>-->
            <!--  <div class="col-lg-4 col-sm-6 col-6 g-3">-->
            <!--    <div class="blog-content ">-->
            <!--      <div class="imgbox"><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/bb1.png" class="img-fluid" alt=""></div>-->
            <!--      <div class="contentbox">-->
            <!--        <h4><a href="#">How to Automate the Deployment Pipeline in Azure DevOps?</a></h4>-->
            <!--        <div class="mt-4">-->
            <!--          <div class="date"><a href="#" class="btn btn-outline-secondary btn-sm">Ebooks</a></div>-->
            <!--          <div class="read mt-2"><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/download.png" class="mx-2" alt="">5032</div>-->
            <!--        </div>-->
            <!--      </div>-->
            <!--    </div>-->
            <!--  </div>-->

            <!--  <div class="col-lg-4 col-sm-6 col-6 g-3">-->
            <!--    <div class="blog-content ">-->
            <!--      <div class="imgbox"><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/bb1.png" class="img-fluid" alt=""></div>-->
            <!--      <div class="contentbox">-->
            <!--        <h4><a href="#">How to Automate the Deployment Pipeline in Azure DevOps?</a></h4>-->
            <!--        <div class="mt-4">-->
            <!--          <div class="date"><a href="#" class="btn btn-outline-secondary btn-sm">Ebooks</a></div>-->
            <!--          <div class="read mt-2"><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/download.png" class="mx-2" alt="">5032</div>-->
            <!--        </div>-->
            <!--      </div>-->
            <!--    </div>-->
            <!--  </div>-->
            <!--  <div class="col-lg-4 col-sm-6 col-6 g-3">-->
            <!--    <div class="blog-content ">-->
            <!--      <div class="imgbox"><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/bb1.png" class="img-fluid" alt=""></div>-->
            <!--      <div class="contentbox">-->
            <!--        <h4><a href="#">How to Automate the Deployment Pipeline in Azure DevOps?</a></h4>-->
            <!--        <div class="mt-4">-->
            <!--          <div class="date"><a href="#" class="btn btn-outline-secondary btn-sm">Ebooks</a></div>-->
            <!--          <div class="read mt-2"><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/download.png" class="mx-2" alt="">5032</div>-->
            <!--        </div>-->
            <!--      </div>-->
            <!--    </div>-->
            <!--  </div>-->
            <!--  <div class="col-lg-4 col-sm-6 col-6 g-3">-->
            <!--    <div class="blog-content ">-->
            <!--      <div class="imgbox"><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/bb1.png" class="img-fluid" alt=""></div>-->
            <!--      <div class="contentbox">-->
            <!--        <h4><a href="#">How to Automate the Deployment Pipeline in Azure DevOps?</a></h4>-->
            <!--        <div class="mt-4">-->
            <!--          <div class="date"><a href="#" class="btn btn-outline-secondary btn-sm">Ebooks</a></div>-->
            <!--          <div class="read mt-2"><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/download.png" class="mx-2" alt="">5032</div>-->
            <!--        </div>-->
            <!--      </div>-->
            <!--    </div>-->
            <!--  </div>-->
              
            <!--  <div class="col-md-12 g-3 text-center">-->
            <!--    <a href="#" class="btn btn-outline-primary my-3 rounded-pill">View More</a>-->
            <!--  </div>-->
            <!--</div>-->

            <!-- Placement -->
             <?php 
             if ($courses_query4->have_posts()): 
             ?>
            <div class="row serach-course" id="placement">
              <div class="col-md-12">
                <h2>Placement</h2>
              </div>
              <div class='row' id="row-container-4">
                  <?php

        if ($courses_query4->have_posts()) :
            $i = 0;
          while ($courses_query4->have_posts()) : $courses_query4->the_post();
            $i++;
            ?>
            <div class="col-lg-6 col-sm-6 col-6 g-3">
                   
                            <div class="voicebox">
                                <div class="voicecontent">
                                    <div class="vioceimg"><img src="<?php the_post_thumbnail_url() ?>" class="img-fluid" alt=""></div>
                                    <div class="voicetitle">
                                        <h4><?php the_title(); ?></h4>
                                        <div class="special"><?php echo the_field('post_designation'); ?></div>
                                        <div class="location"><?php echo the_field('location'); ?></div>
                                    </div>
                                    <div class="clearfix">
                                    </div>
                                    <p><?php the_excerpt() ?></p>
                                    <a href="#" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar-<?php echo $i ?>"  aria-controls="offcanvasNavbar-<?php echo $i ?>" aria-label="Toggle navigation" class="playbar">Click to know more about <?php the_title(); ?></a>
                                </div>
                                <hr>
                                <div class="text-right"><a href="#" class="readstory navbar-toggler" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar-<?php echo $i ?>"  aria-controls="offcanvasNavbar-<?php echo $i ?>" aria-label="Toggle navigation">Read full story</a></div>
                            </div>

                                <!-- form popup -->
                                <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar-<?php echo $i ?>" aria-labelledby="offcanvasNavbar-<?php echo $i ?>Label">
                                    <div class="offcanvas-body">
                                        <div class="reviewpop">
                                            <div class="reviewimg"><img src="<?php the_post_thumbnail_url() ?>" class="img-fluid" alt=""></div>
                                            <div class="reviewcont">
                                                <h3><?php the_title(); ?></h3>
                                                <div class="degi"><?php echo the_field('post_designation'); ?></div>
                                                <div class="backend"></div>
                                                <div class="location"><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/marker.png" alt=""><?php echo the_field('location'); ?></div>
                                                <div class="uni"><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/home.png" alt=""> <?php echo the_field('university'); ?></div>
                                                <div class="edu"><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/cap.png" alt=""> <?php echo the_field('degree'); ?></div>
                                                <div class="exp"><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/case.png" alt=""> <?php echo the_field('experience_line'); ?></div>
                                            </div>
                                            <div class="clearfix"></div>
                                            <ul class="pregrass">
                                                
                                               <?php if( have_rows('pre_post_grass') ): ?>

        <?php while( have_rows('pre_post_grass') ): the_row(); 
            // Get the sub fields
            $title = get_sub_field('title'); 
            $logo = get_sub_field('logo'); 
            $post_content = get_sub_field('post'); 
        ?>
            <li>
                <p><?php echo esc_html($title); ?></p>
                <?php if($logo): ?>
                    <img src="<?php echo esc_url($logo); ?>" class="img-fluid" >
                <?php endif; ?>
                <p><?php echo esc_html($post_content); ?></p>
            </li>
        <?php endwhile; ?>
    
<?php else: ?>
    <p>No entries found.</p>
<?php endif; ?>

                                            </ul>
                                            <div class="salary">
                                                <span><?php echo the_field('salary_hike_line'); ?></span>
                                            </div>
                                            <ul class="share">
                                                <li><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/share.png" class="img-fluid" alt=""> Share Profile</li>
                                                <li><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/linkin.png" class="img-fluid" alt=""> Linkedin</li>
                                            </ul>
                                            <h4>Reviews and Blogs</h4>
                                            <div class="subtext"><?php the_content() ?></div>
                                            <div class="linkd"><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/inreview.png" alt=""> Read review on Linkedin</div>
                                            <h4>Reviews by Madhav Singh on <span>YouTube</span></h4>
                                            <img src="<?php echo get_field("image") ?>" class="img-fluid" alt="">
                                        </div>
                                    </div>

                                </div>

              </div>
                  <?php endwhile;
        else :
          echo '<p>No courses found.</p>';
        endif;

        wp_reset_postdata();
        ?>
              
    </div>
              <div class="col-md-12 g-3 text-center">
                <a href="#" class="btn btn-outline-primary my-3 rounded-pill" id="view-more-4">View More</a>
              </div>
            </div>
<?php
             endif; 
             ?>
          </div>
        </div>

      </div>
    </div>
    <!-- search end -->
    <!-- search end -->
    
<script>
document.addEventListener('DOMContentLoaded', function() {
showItems('course-view','#row-container','.col-lg-4.col-md-6.col-sm-6.col-6.g-3','program-count');
showDefault('course-view','#row-container .col-lg-4.col-md-6.col-sm-6.col-6.g-3','#row-container','.col-lg-4.col-md-6.col-sm-6.col-6.g-3','program-count',6);
});
// internship
document.addEventListener('DOMContentLoaded', function() {
showItems('course-view-1','#row-container-1','.col-lg-4.col-md-6.col-sm-6.col-6.g-3','program-count-1');
showDefault('course-view-1','#row-container-1 .col-lg-4.col-md-6.col-sm-6.col-6.g-3','#row-container-1','.col-lg-4.col-md-6.col-sm-6.col-6.g-3','program-count',6);
});
// workshop
document.addEventListener('DOMContentLoaded', function() {
showItems('view-more-2','#row-container-2','.col-lg-6.col-md-6.col-sm-6.g-3','program-count-2');
showDefault('view-more-2','#row-container-2 .col-lg-6.col-md-6.col-sm-6.g-3','#row-container-2','.col-lg-6.col-md-6.col-sm-6.g-3','program-count-2',6);
});
// blogs
document.addEventListener('DOMContentLoaded', function() {
showItems('view-more-3','#row-container-3','.col-lg-4.col-sm-6.col-6.g-3','program-cou');
showDefault('view-more-3','#row-container-3 .col-lg-4.col-sm-6.col-6.g-3','#row-container-3','.col-lg-4.col-sm-6.col-6.g-3','program-cou',6);
});
// placement
document.addEventListener('DOMContentLoaded', function() {
showItems('view-more-4','#row-container-4','.col-lg-6.col-sm-6.col-6.g-3','program-cou');
showDefault('view-more-4','#row-container-4 .col-lg-6.col-sm-6.col-6.g-3','#row-container-4','.col-lg-6.col-sm-6.col-6.g-3','program-couss',6);
});
// course mobile
document.addEventListener('DOMContentLoaded', function() {
showItems('view-more-5','#row-container-5','.course-mobile-s','program-count-5');
showDefault('view-more-5','#row-container-5 .course-mobile-s','#row-container-5','.course-mobile-s','program-count-5',6);
});
// internship mobile
document.addEventListener('DOMContentLoaded', function() {
showItems('view-more-6','#row-container-6','.internship-mobile-s','program-count-6');
showDefault('view-more-6','#row-container-6 .internship-mobile-s','#row-container-6','.internship-mobile-s','program-count-6',6);
});
</script>
 
 <?php
 get_footer();