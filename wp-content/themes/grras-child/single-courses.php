  <?php
  get_header();
  $permission = get_field('permission') ?? [];
?>
  <style>
.jobform {
  
    background: url(<?php echo get_field('background_image') ?>) no-repeat center bottom;

}
</style>

  <!-- breadcrumb -->
  <nav aria-label="breadcrumb" class="breadcrumb">
    <div class="container">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?php echo site_url(); ?>">Home</a></li>
        <li class="breadcrumb-item"><a href="<?php get_link_custom("course") ?>">Courses</a></li>
        <li class="breadcrumb-item active" aria-current="page"><?php the_title(); ?></li>
      </ol>
    </div>
  </nav>

  <!-- Learn today -->
  <div class="jobform">
    <div class="container">
      <div class="row justify-content-between">
        <div class="col-lg-6 wow fadeInLeft">
          <h1><?php echo get_field('banner_title') ?></h1>
          <div class="subtext"><?php the_content() ?></div>
          <a href="#" class="btn btn-primary d-block d-sm-none mb-5" data-bs-toggle="modal" data-bs-target="#exampleModal6">Download Brochure</a>
          <div class="lang"><?php echo get_field("stack_top_heading") ?></div>
          <?php 
          if (!in_array("Tages Slider Remove", $permission)) {
  include('components/tagsCoursal.php');
}
?>

          
          <div class="btntext"><?php echo get_field("stack_bottom_heading") ?></div>
          <!--<a href="<?php echo get_field('download_brochure'); ?>" class="btn btn-dark d-none d-sm-block">Download Brochure</a>-->
          <a href="#" class="btn btn-dark d-none d-sm-block" data-bs-toggle="modal" data-bs-target="#exampleModal6">Download Brochures</a>
<!-- Modal -->
<div class="modal fade" id="otpModal" tabindex="-1" aria-labelledby="exampleModalLabel" style="display: none;" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                       <div class="modal-body">
        <form id="otpForm">
          <div class="form-group">
            <label for="mobileNumber">Mobile Number</label>
            <input type="tel" class="form-control" id="mobileNumber" placeholder="Enter mobile number">
          </div>
          <button type="button" class="btn btn-primary" id="sendOtpButton">Send OTP</button>
        </form>
      </div>
                    </div>
                </div>
            </div>


        </div>
        <div class="col-lg-5 wow fadeInRight pattern">
          <div class="formbox">
            <h3><?php echo get_field("form_heading",17246) ?></h3>
 <?php echo do_shortcode('[gravityform id="18" title="false" ajax="true"]') ?>
          </div>
        </div>
      </div>
    </div>
  </div>


  <!-- Build your portfolio -->
 <?php
  include('components/portfolio.php');
?>
  <!-- Available Delivery -->
  <?php
   include('components/available-delevry.php');
?>
    <div class="overview wow fadeInLeft">
      <div class="tabbed-content">
        <div class="container-fluid sticky-nav">
          <nav class="tabs nav navtab d-none d-md-block ">
            <ul>
              <li><a href="#overview" data-scroll="overview" class="active">Overview</a></li>
              <li><a href="#whythis" data-scroll="whythis">Why this course</a></li>
              <?php
              if (!in_array("Benefits Remove", $permission)) {
?>
              <li><a href="#curriculum" data-scroll="curriculum">Curriculum</a></li>
  <?php
              }
              ?>
                <?php
              if (!in_array("Project Remove", $permission)) {
?>
              <li><a href="#projects" data-scroll="projects">Projects</a></li>
  <?php
              }
              ?>
              <li><a href="#certification" data-scroll="certification">Certification</a></li>
              <li><a href="#placement" data-scroll="placement">Placement Partners</a></li>
              <li><a href="#careerservice" data-scroll="careerservice">Career Service</a></li>
              <li><a href="#faqsec" data-scroll="faqsec">FAQ</a></li>
            </ul>
          </nav>
        </div>
        <div class="overbg">
          <div class="container">
            <section class="scroller" id="overview" data-anchor="overview">
              <div class="item-content">

                <div class="row justify-content-between align-items-center">
                  <div class="col-lg-6">
                    <h2><?php $course_overview = get_field("course_overview"); ?></h2>
                    <div class="custom_contant" style="display: -webkit-box;"><?php echo wpautop($course_overview["content"]); ?></div>
                    <div class="my-5">
                      <a href="javascript:void(0)" class="btn btn-secondary mr-2 hide_custom" >Explore</a>
                      <!--<a href="<?php echo get_field('download_brochure'); ?>" class="btn btn-primary">Download Brochure</a>-->
					  <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal6">Download Brochure</a>
                    </div>
                  </div>
                  <div class="col-lg-5 overview_view">
                    <div class="videobox">
                      <iframe width="100%" height="315" src="<?php echo $course_overview["youtube_url"] ?>" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
                    </div>
                  </div>
                </div>                
              </div>
            </section>
          </div>
        </div>
      </div>
    </div>
<script>
    window.addEventListener('scroll', function() {
  const element = document.querySelector('.sticky-nav');
  const element1 = document.querySelector('.overview');
  const elementTop = element1.getBoundingClientRect().top + window.pageYOffset;
  const stickyClass = 'sticky-nav';

  if (window.pageYOffset >= elementTop) {
    // element.classList.add(stickyClass);
    element.style.position = 'fixed';
  } else {
    // element.classList.remove(stickyClass);
    element.style.position = 'sticky';
  }
});

</script>
  <!-- Benefits -->
  <style>
      html :where(img[class*=wp-image-]) {
    height: auto;
    max-width: 113%;
}
  </style>
   <?php
              if (!in_array("Benefits Remove", $permission)) {
?>
            <div class="benefits scroller" id="whythis" data-anchor="whythis">
    <div class="tabbed-content">
      <div class="container d-none d-md-block">
        <div class="row">

          <div class="col-lg-12">
            <h2 class="text-center"><?php echo get_field("benefit_heading"); ?></h2>
            <p class="text-center"><?php echo get_field("benefit_description"); ?></p>
          </div>
          <div class="col-lg-4">
            <h4>Designation</h4>
          </div>
          <div class="col-lg-4">
            <h4>Annual Salary</h4>
          </div>
          <div class="col-lg-4">
            <h4>Hiring Companies</h4>
          </div>
        </div>
        <div class="taborder">
          <div class="row">
            <div class="col-lg-4">
              <nav class="tabs"><!-- Comprehensive Career Support -->
                <ul>
                  <?php
                  if (have_rows('benefits')):
                    $i = 0;
                    while (have_rows('benefits')): the_row();
                      $title = get_sub_field('designation');
                    if(!empty($title)):
                  ?>
                      <li><a href="#<?php 
                                    $slug = create_slug($title);
                                    echo $slug; ?>" class="<?php echo ($i == 0 ? 'active' : ''); ?>"><?php echo get_sub_field('designation') ?></a></li>
                  <?php
                  endif;
                      $i++;
                    endwhile;

                  endif;
                  ?>
                </ul>
              </nav>
            </div>
            <div class="col-lg-8 bennifit_">
              <?php
              if (have_rows('benefits')):
                $i = 0;
                while (have_rows('benefits')): the_row();
                  $title = get_sub_field('designation');
                 if(!empty($title)):
              ?>
                  <section id="<?php 
                                $slug = create_slug($title);
                                echo $slug; ?>" class="item <?php echo ($i == 0 ? 'active' : ''); ?>" 
                        
                                >
                    <div class="item-content">
                      <div class="row align-items-center">
                        <div class="col-lg-6 text-center" >
                          <h5>Annual Salary</h5>
                          <div class="imgbox p-2"  >
                              <!--<img src="<?php echo get_sub_field('annual_salary') ?>" class="img-fluid" alt="">-->
                              
                             <div id="salary-content">
    <?php echo get_sub_field('annual_salary'); ?>
</div>


                          
                          </div>
                        </div>
                        <div class="col-lg-6 text-center">
                          <h5>Hiring Companies</h5>
                          <div class="imgbox p-2">
                              <?php echo get_sub_field('hiring_companies') ?>
                              
                        </div>
                      </div>
                    </div>
                    </div>
                  </section>

              <?php
              endif;
                  $i++;
                endwhile;

              endif;
              ?>

            </div>
          </div>
        </div>
      </div>

      <!-- mobile acrodian -->
      <div class="container d-block d-md-none">
        <div class="col-lg-12">
          <h2 class="text-center"><?php echo get_field("benefit_heading"); ?></h2>
          <p class="text-center"><?php echo get_field("benefit_description"); ?></p>
        </div>
     
        <div class="accordion" id="accordionExample">
                   <?php
              if (have_rows('benefits')):
                $i = 0;
                while (have_rows('benefits')): the_row();
              $title = get_sub_field('designation');
               if(!empty($title)):
              ?>
                    <div class="accordion-item">
            <h2 class="accordion-header">
              <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#<?php 
                                $slug = create_slug($title);
                                echo $slug; ?>" aria-expanded="false" aria-controls="<?php $title = get_sub_field('designation');
                                $slug = create_slug($title);
                                echo $slug; ?>">
                <?php echo get_sub_field('designation'); ?>
              </button>
            </h2>
            <div id="<?php $title = get_sub_field('designation');
                                $slug = create_slug($title);
                                echo $slug; ?>" class="accordion-collapse collapse <?php echo $i == 0 && 'show' ?>" data-bs-parent="#accordionExample">
              <div class="accordion-body">
                <div class="row">
                  <div class="col-lg-6 text-center">
                    <h5>Annual Salary</h5>
                    <div class="imgbox">
                        <?php echo wpautop(get_sub_field('annual_salary')) ?>
                        </div>
                  </div>
                  <div class="col-lg-6 text-center">
                    <h5>Hiring Companies</h5>
                    <div class="imgbox">
                        <?php echo wpautop(get_sub_field('hiring_companies')) ?></div>
                  </div>
                </div>
              </div>
            </div>
          </div>
                 
              <?php
              endif;
                  $i++;
                endwhile;

              endif;
              ?>
    
     
    
        </div>
      </div>
    </div>
  </div>

      
  <?php
              }
              ?>

  <!-- Why enrol for GRRAS -->
  <div class="yourgoal whyenroll wow fadeInLeft" >
    <div class="container">
      <div class="row">
        <div class="col-12">
          <h2><?php echo get_field("why_enrol_for_grras_heading"); ?></h2>
        </div>
        <?php
        if (have_rows('why_enrol')):

          while (have_rows('why_enrol')): the_row();
        ?>
            <div class="col-lg-3 col-sm-6 col-6 g-3">
              <div class="goalbox">
                <img src="<?php echo get_sub_field('icon') ?>" class="img-fluid" alt="">
                <?php echo get_sub_field('title') ?>
                <?php echo get_sub_field('content') ?>
              </div>
            </div>
        <?php

          endwhile;

        endif;
        ?>

      </div>
    </div>
  </div>


  <div class="fullstack wow fadeInUp scroller" id="curriculum" data-anchor="curriculum">
    <div class="container">
        <div class="row" style="position: relative!important;">
            <div class="col-lg-8 " style="position: relative;">
                <style>
                    .hidden-item {
    display: none;
}

                </style>
                <h2><?php echo get_field("course_curriculum_heading"); ?></h2>
                <div class="subtext"><?php echo get_field("course_curriculum_description"); ?></div>
            <div class="accordion" id="accordionExample2">
    <?php
    $count = 0;
    if (have_rows('course_learning')):
        while (have_rows('course_learning')): the_row();
            $count++;
            $title = get_sub_field('title');
            $slug = create_slug($title) .'-'. $count;
            $is_multiple = get_sub_field('is_multiple') == 'True';
            $multiple = get_sub_field('multiple');
    ?>
    <div class="accordion-item<?php echo ($count > 14) ? ' hidden-item' : ''; ?>">
        <h4 class="accordion-header" id="heading-<?php echo $slug; ?>">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-<?php echo $slug; ?>" aria-expanded="false" aria-controls="collapse-<?php echo $slug; ?>">
                <?php echo $title; ?>
            </button>
        </h4>
        <div id="collapse-<?php echo $slug; ?>" class="accordion-collapse collapse" aria-labelledby="heading-<?php echo $slug; ?>" data-bs-parent="#accordionExample2">
            <div class="accordion-body">
                <?php echo wpautop(get_sub_field('content')); ?>
                <?php if ($is_multiple): ?>
                    <div class="accordion" id="accordionExample4">
                        <?php foreach ($multiple as $i => $item): ?>
                            <div class="accordion-item">
                                <h4 class="accordion-header" id="heading-<?php echo $slug . '-' . $i; ?>">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-<?php echo $slug . '-' . $i; ?>" aria-expanded="false" aria-controls="collapse-<?php echo $slug . '-' . $i; ?>">
                                        <?php echo $item["title"]; ?>
                                    </button>
                                </h4>
                                <div id="collapse-<?php echo $slug . '-' . $i; ?>" class="accordion-collapse collapse" aria-labelledby="heading-<?php echo $slug . '-' . $i; ?>" data-bs-parent="#accordionExample4">
                                    <div class="accordion-body">
                                        <?php echo $item['content']; ?>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <?php
        endwhile;
    endif;
    ?>
</div>
<script>
    document.addEventListener("DOMContentLoaded", function() {
    const viewMoreBtn = document.getElementById('view-more-btn');
    const hiddenItems = document.querySelectorAll('.hidden-item');

    viewMoreBtn.addEventListener('click', function(e) {
        e.preventDefault();
        hiddenItems.forEach(function(item) {
            item.style.display = 'block';
        });
        if(viewMoreBtn.textContent == 'Show Less'){
        viewMoreBtn.textContent = 'Show More';
        hiddenItems.forEach(function(item) {
            item.style.display = 'none';
        });
        }else{
        viewMoreBtn.textContent = 'Show Less'; 
        }
    });
});

</script>
<?php if($count > 13): ?>
<div class="my-3 text-center"><a href="javascript:void(0)" id="view-more-btn" class="link-primary">View More</a></div>
<?php endif; ?>

                <!--<a href="#" class="btn btn-secondary">Download Brochure</a>-->
            </div>
            <div class="col-lg-4 d-none d-sm-block top-fixed">
                <div class="excel">
                    <ul>
                        <?php
                        if (have_rows('live_classes')):
                            $i = 0;
                            while (have_rows('live_classes')): the_row();
                                if ($i == 3):
                        ?>
                        <li class="separater"></li>
                        <?php
                                endif;
                        ?>
                        <li><img src="<?php echo get_sub_field('icon'); ?>" alt=""> <?php echo get_sub_field('name'); ?></li>
                        <?php
                                $i++;
                            endwhile;
                        endif;
                        ?>
                    </ul>
                    <!--<a href="<?php echo get_field('download_brochure') ?>" class="btn btn-primary d-block">Download Brochure</a>-->
					<a href="#" class="btn btn-primary d-block" data-bs-toggle="modal" data-bs-target="#exampleModal6">Download Brochure</a>
                </div>
            </div>
        </div>
    </div>
</div>

  <!-- HTML 5.1(Hyper Text Markup language) -->


    <!-- Tolls -->
<?php 

              if (!in_array("Skill Remove", $permission)) {

  include('components/CoureTags.php');
              }
              ?>



  <!-- industry project -->
  <?php 

              if (!in_array("Project Remove", $permission)) {


include 'components/projectCourse.php';
              }
              ?>



  <!-- certificate -->
 <div class="certificate-full wow fadeInLeft scroller" id="certification" data-anchor="certification">
      <div class="container">
        <div class="row justify-content-between align-items-center">
          <div class="col-lg-7">
            <h2><?php $certification = get_field('certification'); 
            echo $certification['title'];
            ?></h2>
            <p><?php echo $certification['description'] ?></p>
          </div>
          <div class="col-lg-4">
            <div class="certibox">
              <img src="<?php echo $certification['image'] ?>" class="img-fluid" alt="">
            </div>
            <div class="text-center d-none d-md-block"><a href="#" class="link" data-bs-toggle="modal" data-bs-target="#exampleModal">Click to Zoom</a></div>
          </div>
        </div>
      </div>
    </div>

<div class="modal modal-lg fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" style="display: none;" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          <div class="modal-body">
            <img src="<?php echo $certification['image'] ?>" class="img-fluid w-100" alt="">
          </div>
        </div>
      </div>
    </div> <!-- Our Recent Placements -->
<?php include "components/placement_couse_details.php";?>


  <!-- Our Hiring Partners -->
<?php include "components/OurHiringPartner.php";?>

  <!-- Who Should Do This Course? -->
  <div class="thiscourse">
    <div class="container">
      <div class="row">
        <div class="col-lg-6">
          <h2>Who Should Do This Course?</h2>
          <ul>
            <?php
            if (have_rows('who_should_do_this_course')):

              while (have_rows('who_should_do_this_course')): the_row();
            ?>
                <li><?php echo get_sub_field('name') ?></li>
            <?php

              endwhile;

            endif;
            ?>

          </ul>
          <a  href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#exampleModal5" class="btn btn-primary">Enquire Now</a>
        </div>
        <div class="col-lg-6 text-center">
        
          <div class="whoshold d-none d-md-block">
              <div class="yearof">
                <?php 
$left_section = get_field('left_section');
echo $left_section['experience'];
?>
              </div>
              <img src="<?php echo $left_section['first_image']; ?>" class="img-fluid" alt="">  
              <img src="<?php echo $left_section['second_image']; ?>" class="img-fluid img2" alt="">  
              <img src="<?php echo $left_section['third_image']; ?>" class="img-fluid img3" alt="">  
            </div>
        </div>
      </div>
    </div>
  </div>



  <!-- Happy Student -->
  <section class="studentsay">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <h2>Our Satisfied & Happy Students</h2>
        </div>
      </div>
      <div class="row">
        <div class="col-lg-6">
          <div class="owl-carousel student-carousel">
              
<?php
// The custom WP Query to fetch testimonials
$args = array(
    'post_type' => 'testimonials', // Custom post type name
    'posts_per_page' => -1, // Get all testimonials
);
$testimonial_query = new WP_Query( $args );

if( $testimonial_query->have_posts() ) :
    while( $testimonial_query->have_posts() ) : $testimonial_query->the_post();
        // Get ACF fields
        $designation = get_field('title'); // ACF field for designation
        $company = get_field('company'); // ACF field for company (assuming you have it)
        $testimonial_content = get_the_content();
        $testimonial_image = get_the_post_thumbnail_url(); // Assuming there's a featured image for the testimonial
        ?>
        <div class="item">
             <a href="/review-rating" class="global-link">
          <div class="whbox">
            <img src="<?php echo $testimonial_image ?: get_stylesheet_directory_uri() . '/images/student.jpg'; ?>" class="img-fluid" alt="">
            <div class="student">
              <h5><?php the_title(); ?></h5>
              <div class="subtext"><?php echo esc_html($designation); ?> @<?php echo esc_html($company); ?></div>
            </div>

            <!-- Display truncated content with a "More" link -->
            <div class="testimonial-content">
              <p class="more-text"><?php echo wp_trim_words( $testimonial_content, 40, '...'); ?></p>
              <p class="full-text" style="display:none;"><?php echo nl2br($testimonial_content); ?></p>
              <a href="javascript:void(0);" class="read-more">More</a>
            </div>

          </div>
          </a>
        </div>
    <?php endwhile;
    wp_reset_postdata(); // Reset the post data
else :
    echo 'No testimonials found';
endif;
?>


         <script>
             document.addEventListener("DOMContentLoaded", function() {
    const readMoreButtons = document.querySelectorAll('.read-more');

    readMoreButtons.forEach(function(button) {
        button.addEventListener('click', function() {
            const parent = button.closest('.testimonial-content');
            const fullText = parent.querySelector('.full-text');
            const moreText = parent.querySelector('.more-text');
            
            // Check if the full text is currently visible
            if (fullText.style.display === 'none') {
                // Show the full text
                fullText.style.display = 'block';
                moreText.style.display = 'none';
                button.textContent = 'Less'; // Change the button text to "Less"
            } else {
                // Hide the full text
                fullText.style.display = 'none';
                moreText.style.display = 'block';
                button.textContent = 'More'; // Change the button text to "More"
            }

            // Toggle active class for the "More/Less" button
            button.classList.toggle('active');
        });
    });
});

         </script>
          </div>
        </div>
        <div class="col-lg-6">
          <div class="videobox"><iframe width="100%" height="315" src="<?php echo get_field('our_satisfied')["youtube_url"] ?>" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe></div>
        </div>
      </div>
    </div>
  </section>

    <style>


        .container_details {
            display: flex;
            flex-direction: column;
            gap: 20px;
            padding: 20px;
        }

        .sidebar_details {
            width: 100%;
        }


        .sidebar_details div {
            padding: 15px;
            margin-bottom: 10px;
            background: #fff;
            border-radius: 5px;
            cursor: pointer;
            font-size: 18px;
            color: #333;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }

        .sidebar_details .selected {
            color: #ff6600;
            font-weight: 500;
        }

        .content_details {
            display: grid;
            gap: 10px;
            width: 100%;
            margin-bottom: 100px;
        }

        .card_details {
            background: #fffaf0;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            height: 190px;
        }

        .card_details img {
            display: block;

            border-radius: 5px;
            margin-bottom: 10px;
        }

        .card_details img {
            width: 60px;
            height: 60px;
        }

        .card_details h3 {
            color: #252525;
            font-size: 18px;
            font-weight: bold;
        }

        .card_details p {
            color: #555;
            font-size: 15px;
        }

        @media (min-width: 768px) {
            .container_details {
                flex-direction: row;
            }

            .sidebar_details {
                width: 30%;
            }

            .content_details {
                grid-template-columns: repeat(2, 1fr);
                width: 70%;
            }
        }

        @media (max-width: 767px) {
            .sidebar_details div {
                font-size: 15px;
                padding: 10px;
            }

            .card_details h3 {
                font-size: 15px;
                /* card_details ke heading ka font size chhota */
            }

            .card_details p {
                font-size: 13px;
                /* card_details ke paragraph ka font size chhota */
            }

            .card_details {
                background: #fffaf0;
                padding: 20px;
                border-radius: 8px;
                box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
                height: 150px;
            }

        }

        @media (max-width: 767px) {
            .card_details img {
                width: 40px;
                height: 40px;
            }
        }
    </style>
<section class="support wow fadeInLeft scroller" id="careerservice" data-anchor="careerservice">
    <div class="container">
        <h2><?php echo get_field('career_support_title') ?></h2>

        <div class="container_details">
            <div class="sidebar_details" id="sidebar_details">
                <?php
                if (have_rows('career_support')): 
                    $i = 0;
                    while (have_rows('career_support')): the_row();
                        $title = get_sub_field('title');
                        $slug = create_slug($title);  // Assuming create_slug is a function that sanitizes the title
                ?>
                    <div onclick="changecontent_details(<?php echo $i; ?>, this)" 
                         class="<?php echo ($i == 0 ? 'selected' : ''); ?>">
                        <?php echo $title; ?>
                    </div>
                <?php
                        $i++;
                    endwhile;
                endif;
                ?>
            </div>

            <div class="content_details" id="content_details">
                <?php
                if (have_rows('career_support')): 
                    $i = 0;
                    while (have_rows('career_support')): the_row();
                        $title = get_sub_field('title');
                        $description = get_sub_field('description');
                        $img = get_sub_field('image');  // Assuming the image field is present
                ?>
                    <div class="card_details card inserted-content_details <?php echo ($i == 0 ? 'active' : ''); ?>">
                        <img src="<?php echo esc_url($img); ?>" alt="" />
                        <h3><?php echo $title; ?></h3>
                        <p><?php echo $description; ?></p>
                    </div>
                <?php
                        $i++;
                    endwhile;
                endif;
                ?>
            </div>
        </div>
    </div>
</section>

<script>
    const content_detailsData = [
        <?php 
        if (have_rows('career_support')): 
            $i = 0;
            while (have_rows('career_support')): the_row();
                $title = get_sub_field('title') || "";
                $description = get_sub_field('description');
                $img = get_sub_field('image') || null;
        ?>
            [
                {
                    img: "<?php echo esc_url($img); ?>",
                    title: "<?php echo $title; ?>",
                    text: "<?php echo $description; ?>",
                }
            ],
        <?php
                $i++;
            endwhile;
        endif;
        ?>
    ];

    function changecontent_details(index, element) {
        let content_detailscontainer_details = document.getElementById("content_details");
        let existingcontent_details = document.querySelectorAll(".inserted-content_details");

        if (element.classList.contains("selected")) {
            existingcontent_details.forEach((el) => el.remove());
            element.classList.remove("selected");
            return;
        }

        document
            .querySelectorAll(".inserted-content_details")
            .forEach((el) => el.remove());
        document
            .querySelectorAll(".sidebar_details div")
            .forEach((div) => div.classList.remove("selected"));

        element.classList.add("selected");

        let content_detailsHTML = content_detailsData[index]
            .map(
                (item) => `
        <div class="card_details inserted-content_details">
            <img src="${item.img}" alt="Training Image" style="border-radius: 5px; display: block;">
            <h3>${item.title}</h3>
            <p>${item.text}</p>
        </div>`
            )
            .join("");

        if (window.innerWidth < 768) {
            element.insertAdjacentHTML("afterend", content_detailsHTML);
        } else {
            content_detailscontainer_details.innerHTML = content_detailsHTML;
        }
    }

    document.addEventListener("DOMContentLoaded", function () {
        if (window.innerWidth < 768) {
            document.getElementById("content_details").innerHTML = "";
        }
    });
</script>


  <!-- Comprehensive Career Support -->
  <section class="support wow fadeInLeft scroller d-none" id="careerservice" data-anchor="careerservice">
    <div class="tabbed-content">
      <div class="container">
        <h2><?php echo get_field('career_support_title') ?></h2>
        <div class="row align-items-center">
          <div class="col-lg-5 d-none d-lg-block">
            <img src="<?php echo get_field('career_support_image') ?>" class="img-fluid" alt="">
          </div>
          <div class="col-lg-7">
            <nav class="tabs">
              <ul>
                <?php
                if (have_rows('career_support')):
                  $i = 0;
                  while (have_rows('career_support')): the_row();
                ?>
                    <li><a href="#<?php $title = get_sub_field('title');
                                  $slug = create_slug($title);
                                  echo $slug; ?>" class="<?php echo ($i == 0 ? 'active' : ''); ?>"><?php echo get_sub_field('title') ?></a></li>
                <?php
                    $i++;
                  endwhile;

                endif;
                ?>
				<div class="clearfix"></div>
              </ul>
            </nav>
            <?php
            if (have_rows('career_support')):
              $i = 0;
              while (have_rows('career_support')): the_row();
            ?>
                <section id="<?php $title = get_sub_field('title');
                              $slug = create_slug($title);
                              echo $slug;  ?>" class="item <?php echo ($i == 0 ? 'active' : ''); ?>" data-title="<?php $title = get_sub_field('title');
                                                                                    $slug = create_slug($title);
                                                                                    echo $slug;  ?>">
                  <div class="item-content">
                    <div class="posts">
                      <?php echo get_sub_field('description', false, false); ?>
                      <div class="clearfix"></div>
                    </div>
                  </div>
                </section>
            <?php
                $i++;
              endwhile;

            endif;
            ?>


          </div>
        </div>
      </div>
    </div>
  </section>
  <script>
    document.addEventListener("DOMContentLoaded", function() {
        var content = document.getElementById("salary-content");
        var paragraphs = content.getElementsByTagName("p");
        if (paragraphs.length > 0) {
            var parent = paragraphs[0].parentNode;
            while (paragraphs[0].firstChild) {
                parent.insertBefore(paragraphs[0].firstChild, paragraphs[0]);
            }
            parent.removeChild(paragraphs[0]);
        }
    });
</script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        
    const stickyNav = document.querySelector('.sticky-nav');
    const footer = document.querySelector('footer');

    function stickyUntilFooter() {
        const footerRect = footer.getBoundingClientRect();
        const stickyNavRect = stickyNav.getBoundingClientRect();
        if (footerRect.top <= stickyNavRect.bottom) {
            stickyNav.style.position = 'absolute';
            stickyNav.style.top = `${footerRect.top - stickyNavRect.height}px`;
        } else {
            stickyNav.style.position = '-webkit-sticky';
            stickyNav.style.position = 'sticky';
            stickyNav.style.top = '0px';
        }
    }

    window.addEventListener('scroll', stickyUntilFooter);
    window.addEventListener('resize', stickyUntilFooter);
    stickyUntilFooter(); 
});

</script>


  <?php
  include('components/course-details-workshop.php');
  include('components/details-course-TopChoices.php');
  include('components/faq.php');
  include('components/city.php');
  get_footer();
