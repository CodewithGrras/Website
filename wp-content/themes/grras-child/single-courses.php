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
  <div class="jobform jobfornnew">
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

          
          <!-- <div class="btntext"><?php echo get_field("stack_bottom_heading") ?></div> -->
          <!--<a href="<?php echo get_field('download_brochure'); ?>" class="btn btn-dark d-none d-sm-block">Download Brochure</a>-->
          <a href="#" class="btn btn-primary d-none d-sm-inline-block mt-lg-5" data-bs-toggle="modal" data-bs-target="#exampleModal6">Download Brochures</a>
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
        <div class="overbg bglight-sm section-padding">
          <div class="container">
            <section class="scroller" id="overview" data-anchor="overview">
              <div class="item-content">

                <div class="row justify-content-between align-items-center">
                  <div class="col-lg-6">
                    <?php $course_overview = get_field("course_overview"); ?>
                    <h2 style="font-weight: 700;"><?php echo $course_overview['title']; ?></h2>
                    <div class="custom_contant" style="display: -webkit-box;">
                      <?php
                        echo $course_overview["content"];
                        //echo "<p>Test job</p>";
                      ?>
                      
                    </div>
                    <div class="mt-4 mt-lg-5">
                      <a href="javascript:void(0)" class="btn btn-dark fw-normal py-2 px-3 mr-2 hide_custom" >Read more</a>
                      <!--<a href="<?php echo get_field('download_brochure'); ?>" class="btn btn-primary">Download Brochure</a>-->
					            <a href="#" class="btn btn-primary py-2 px-3" data-bs-toggle="modal" data-bs-target="#exampleModal6" >Download Brochure</a>
                    </div>
                  </div>
                  <div class="col-lg-5 overview_view mt-4 mt-lg-0">
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
            <div class="benefits">
    <div class="tabbed-content">
      <div class="container d-none d-md-block">
        <div class="row">

          <div class="col-lg-12 mb-3">
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
                          <div class="imgbox"  >
                              <!--<img src="<?php echo get_sub_field('annual_salary') ?>" class="img-fluid" alt="">-->
                              
                             <div id="salary-content">
    <?php echo get_sub_field('annual_salary'); ?>
</div>


                          
                          </div>
                        </div>
                        <div class="col-lg-6 text-center">
                          <h5>Hiring Companies</h5>
                          <div class="imgbox">
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
        <div class="col-lg-12 mb-4 mb-md-0">
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
  <div class="yourgoal whyenroll wow fadeInLeft scroller" id="whythis" data-anchor="whythis">
      
    <div class="container">
      <div class="row">
        <div class="col-12">
          <h2><?php echo get_field("why_enrol_for_grras_heading"); ?></h2>
        </div>
        <?php
        if (have_rows('why_enrol')):

          while (have_rows('why_enrol')): the_row();
        ?>
            <div class="col-lg-3 col-sm-6 col-12 g-3">
              <div class="goalbox text-start">
                <div class="goal-row d-flex align-items-center gap-2 mb-2">
                    <img src="<?php echo get_sub_field('icon') ?>" class="img-fluid" alt="">
                    <h4 class="goal-title py-0 ms-3" style="min-height: inherit !important;"><?php echo get_sub_field('tittle') ?></h4>    
                </div>
                <div class="readmoretext looklikep"><?php echo limitTextHtml(get_sub_field('content'), 150); ?></div>
                
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
            <div class="col-lg-8" style="position: relative;">
                <h2 class="mb-2"><?php echo get_field("course_curriculum_heading"); ?></h2>
                <h5><?php echo get_field("course_curriculum_subheading"); ?></h5>
                <div class="subtext"><?php echo get_field("course_curriculum_description"); ?></div>
                <div class="accordion" id="accordionExample2">
                    <?php
                    $count = 0;
                    if (have_rows('course_learning')):
                        while (have_rows('course_learning')): the_row();
                            $count++;
                            $title = get_sub_field('title');
                            $slug = create_slug($title) . '-' . $count;
                            $is_multiple = get_sub_field('is_multiple') == 'True';
                            $multiple = get_sub_field('multiple');
                            $has_video = false;

                            // Check if any item has a YouTube video link
                            if ($is_multiple) {
                                foreach ($multiple as $item) {
                                    if (!empty($item['youtube_video_link'])) {
                                        $has_video = true;
                                        break;
                                    }
                                }
                            }
                    ?>
                    <div class="accordion-item<?php echo ($count > 14) ? ' hidden-item' : ''; ?>">
                        <h4 class="accordion-header d-flex justify-content-between align-items-center" id="heading-<?php echo $slug; ?>">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-<?php echo $slug; ?>" aria-expanded="false" aria-controls="collapse-<?php echo $slug; ?>">
                                <?php echo $title; ?>
                            </button>
                            <?php if ($has_video): ?>
                                <span class="small text-theme-orange me-3">Preview</span>
                            <?php endif; ?>
                        </h4>
                        <div id="collapse-<?php echo $slug; ?>" class="accordion-collapse collapse" aria-labelledby="heading-<?php echo $slug; ?>" data-bs-parent="#accordionExample2">
                            <div class="accordion-body">
                                <?php echo wpautop(get_sub_field('content')); ?>
                                <?php if ($is_multiple): ?>
                                    <div class="accordion" id="accordionExample4">
                                        <?php foreach ($multiple as $i => $item):
                                            $item_slug = $slug . '-' . $i;
                                            $youtube_link = $item['youtube_video_link'];
                                            preg_match('/(?:youtube\.com\/watch\?v=|youtu\.be\/)([^&]+)/', $youtube_link, $matches);
                                            $youtube_id = $matches[1] ?? '';
                                        ?>
                                        <div class="accordion-item">
                                            <h4 class="accordion-header d-flex justify-content-between align-items-center" id="heading-<?php echo $item_slug; ?>">
                                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-<?php echo $item_slug; ?>" aria-expanded="false" aria-controls="collapse-<?php echo $item_slug; ?>">
                                                    <?php echo $item["title"]; ?>
                                                </button>
                                                <?php if (!empty($youtube_id)): ?>
                                                <div class="d-flex align-items-center">
                                                    <button class="btn btn-link p-0 me-2 play-video-btn" data-video-id="<?php echo $youtube_id; ?>">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="#ef721f" viewBox="0 0 16 16">
                                                            <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM6.271 5.055a.5.5 0 0 0-.771.423v5.044a.5.5 0 0 0 .771.423l4.276-2.522a.5.5 0 0 0 0-.846L6.271 5.055z"/>
                                                        </svg>
                                                    </button>
                                                    <span class="text-theme-orange fw-medium small f-14" id="duration-<?php echo $youtube_id; ?>">Loading...</span>
                                                </div>
                                                <?php endif; ?>
                                            </h4>
                                            <div id="collapse-<?php echo $item_slug; ?>" class="accordion-collapse collapse" aria-labelledby="heading-<?php echo $item_slug; ?>" data-bs-parent="#accordionExample4">
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
                    <?php endwhile; endif; ?>
                </div>

                <script>
                document.addEventListener("DOMContentLoaded", function() {
                    const API_KEY = 'AIzaSyDp6GjV0wmZ2IXdTADrQ2m3ix7eIZ8PrY8';
                    const playButtons = document.querySelectorAll('.play-video-btn');

                    playButtons.forEach(btn => {
                        const videoId = btn.getAttribute('data-video-id');
                        if (videoId) {
                            fetch(`https://www.googleapis.com/youtube/v3/videos?part=contentDetails&id=${videoId}&key=${API_KEY}`)
                                .then(response => response.json())
                                .then(data => {
                                    const isoDuration = data.items[0].contentDetails.duration;
                                    const duration = iso8601DurationToTime(isoDuration);
                                    document.getElementById(`duration-${videoId}`).textContent = duration;
                                })
                                .catch(() => {
                                    document.getElementById(`duration-${videoId}`).textContent = 'N/A';
                                });
                        }
                    });

                    function iso8601DurationToTime(duration) {
                        const match = duration.match(/PT(\d+H)?(\d+M)?(\d+S)?/);
                        const hours = (parseInt(match[1]) || 0);
                        const minutes = (parseInt(match[2]) || 0);
                        const seconds = (parseInt(match[3]) || 0);
                        return [hours, minutes, seconds]
                            .map(v => v < 10 ? "0" + v : v)
                            .filter((v, i) => i > 0 || v !== "00")
                            .join(':');
                    }

                    // Play video on click
                    playButtons.forEach(btn => {
                        btn.addEventListener('click', function() {
                            const videoId = this.getAttribute('data-video-id');
                            const modalBody = document.getElementById('videoModalBody');
                            modalBody.innerHTML = `<iframe class="youtubeIframe" width="100%" height="400" src="https://www.youtube.com/embed/${videoId}?autoplay=1" frameborder="0" allowfullscreen></iframe>`;
                            const modal = new bootstrap.Modal(document.getElementById('videoModal'));
                            modal.show();
                        });
                    });
                });
                </script>

                <div class="youtubeModal modal fade" id="videoModal" tabindex="-1" aria-labelledby="videoModalLabel" aria-hidden="true">
                  <div class="modal-dialog modal-lg modal-dialog-centered">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="videoModalLabel">Video Preview</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>
                      <div class="modal-body" id="videoModalBody">
                      </div>
                    </div>
                  </div>
                </div>
            </div>

            <div class="col-lg-4 d-none d-sm-block top-fixed">
                <div class="excel make-me-sticky-global">
                    <ul>
                        <?php
                        if (have_rows('live_classes')):
                            $i = 0;
                            while (have_rows('live_classes')): the_row();
                                if ($i == 3): ?>
                        <li class="separater"></li>
                        <?php endif; ?>
                        <li><img src="<?php echo get_sub_field('icon'); ?>" alt=""> <?php echo get_sub_field('name'); ?></li>
                        <?php $i++; endwhile; endif; ?>
                    </ul>
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
  <section class="studentsay section-padding bg-theme-light">
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
    <?php 
    $course_common_detail = get_field('course_common_config', 'option');
    ?>
<section class="faqs faq-section py-5 scroller" id="careerservice" data-anchor="careerservice">
      <div class="container wow fadeInUp">
        <div class="row justify-content-center">
          <div class="col-md-12">
            <div class="heading-area mb-4">
              <h2 class="fw-bold"><?php echo $course_common_detail['from_training_to_placement_a_roadmap_to_success_title_course']; ?></h2>
              <p></p>
            </div>
          </div>
        </div>
        <?php 
        $tabsData = $course_common_detail['from_training_to_placement_a_roadmap_to_success_tabs_course'];
        if(!empty($tabsData)):
        ?>
        <div class="row">
          <div class="col-12  col-md-4">
            <ul class="nav left-tab my-0 theme-default-tab" id="myTab" role="tablist">
              <?php 
              $countTab = 1;
              foreach($tabsData as $tabKey=>$tabObj):
              ?>
              <li class="nav-item" role="presentation">
                <a href="#" class="nav-link <?php if($countTab === 1 ) { echo 'active'; } ?> bg-white border rounded-1" data-bs-toggle="tab" data-bs-target="#RoadmapTab-<?php echo $countTab; ?>"><?php echo $tabObj['tab_title']; ?></a>
                <div class="mobile-view-tab d-none p-2">
                  <?php if(isset($tabObj['tab_boxes']) && !empty($tabObj['tab_boxes'])): ?>
                    <?php foreach($tabObj['tab_boxes'] as $boxKey=>$boxObj): ?>
                          <div class="row">
                            <div class="col-12 col-sm-6 col-lg-6 mb-3">
                              <div class="card h-100 roadmap-block border-0 bg-theme-light">
                                <div class="card-body p-lg-4">
                                    <div class="cardicon mb-3 d-flex justify-content-center align-items-center">
                                      <?php echo $boxObj['svg_code']; ?>
                                    </div>
                                    <h5 class="fw-semibold"><?php echo $boxObj['box_title']; ?></h5>
                                    <p class="mb-0 p-0"><?php echo $boxObj['box_description']; ?></p>
                                </div>
                              </div>
                            </div>
                          </div>
                    <?php endforeach; ?>
                  <?php endif; ?>
                </div>
              </li>
              <?php $countTab++; endforeach; ?>
            </ul>
          </div>
          <div class="col-12 col-md-8">
            <div class="tab-content d-none d-md-block" id="myTabContent">
            <?php 
              $countTab = 1;
              foreach($tabsData as $tabKey=>$tabObj):
            ?>
              <div class="tab-pane fade <?php if($countTab == 1) { echo 'show active'; } ?>" id="RoadmapTab-<?php echo $countTab; ?>">
                <div class="row">
                  <?php if(isset($tabObj['tab_boxes']) && !empty($tabObj['tab_boxes'])): ?>  
                    <?php foreach($tabObj['tab_boxes'] as $boxKey=>$boxObj): ?>
                        <div class="col-12 col-sm-6 col-lg-6 mb-3">
                            <div class="card h-100 roadmap-block border-0 bg-theme-light">
                                <div class="card-body p-lg-4">
                                    <div class="cardicon mb-3 d-flex justify-content-center align-items-center">
                                        <?php echo $boxObj['svg_code']; ?>
                                    </div>
                                    <h5 class="fw-semibold"><?php echo $boxObj['box_title']; ?></h5>
                                    <p class="mb-0 p-0"><?php echo $boxObj['box_description']; ?></p>
                                 </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                  <?php endif; ?>
                </div>
              </div>
            <?php $countTab++; endforeach; ?>
            </div>
          </div>
        </div>
        <?php endif; ?>
        <?php
		$attachment_id = $course_common_detail['our_mission_download_placement_report_file_course'];
		$attachment_url = $attachment_id ? wp_get_attachment_url($attachment_id) : 'javascript:void(0);';
		$download_attr = $attachment_id ? 'download' : '';
		
		$attachment_right_id = $course_common_detail['our_mission_right_image_course'];
		$attachment_right_url = $attachment_right_id ? wp_get_attachment_url($attachment_right_id) : '';
        ?>
        <div class="border rounded-2 brd-theme-light mt-4">
          <div class="row">
            <div class="col-12 col-lg-8 order-2 order-lg-1">
              <div class="dataarea p-3">
                <span><?php echo $course_common_detail['our_mission_revolves_around_our_learners_title_course']; ?></span>
                <h4 class="fw-bold my-md-3"><?php echo $course_common_detail['our_mission_revolves_around_our_learners_subheading_course']; ?></h4>
                <a href="<?php echo $attachment_url; ?>" class="align-items-center btn btn-primary btnwith-icon-sm d-inline-flex justify-content-center p-2 rounded-2 text-center" <?php echo $download_attr; ?>>
                  <span class="pe-3 ps-2">Download Placement Report</span>
                  <span class="btn-icon d-inline-flex justify-content-center align-items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="21" viewBox="0 0 20 21" fill="none">
                      <path d="M5.39062 9.46533C5.50781 9.33512 5.6543 9.27002 5.83008 9.27002C6.00586 9.27002 6.15234 9.33512 6.26953 9.46533L10 13.1763L13.7305 9.46533C13.8477 9.33512 13.9941 9.27002 14.1699 9.27002C14.3457 9.27002 14.4922 9.33512 14.6094 9.46533C14.7266 9.58252 14.7852 9.729 14.7852 9.90479C14.7852 10.0806 14.7266 10.2271 14.6094 10.3442L10.4492 14.5044C10.319 14.6346 10.1693 14.6997 10 14.6997C9.83073 14.6997 9.68099 14.6346 9.55078 14.5044L5.39062 10.3442C5.27344 10.2271 5.21484 10.0806 5.21484 9.90479C5.21484 9.729 5.27344 9.58252 5.39062 9.46533ZM10 4.27002C10.1693 4.27002 10.3158 4.33187 10.4395 4.45557C10.5632 4.57926 10.625 4.72575 10.625 4.89502V13.2349C10.625 13.4041 10.5632 13.5506 10.4395 13.6743C10.3158 13.798 10.1693 13.8599 10 13.8599C9.83073 13.8599 9.68424 13.798 9.56055 13.6743C9.43685 13.5506 9.375 13.4041 9.375 13.2349V4.89502C9.375 4.72575 9.43685 4.57926 9.56055 4.45557C9.68424 4.33187 9.83073 4.27002 10 4.27002ZM3.53516 17.395C3.53516 17.2257 3.59701 17.0793 3.7207 16.9556C3.8444 16.8319 3.99089 16.77 4.16016 16.77H15.8398C16.0091 16.77 16.1556 16.8319 16.2793 16.9556C16.403 17.0793 16.4648 17.2257 16.4648 17.395C16.4648 17.5773 16.403 17.7271 16.2793 17.8442C16.1556 17.9614 16.0091 18.02 15.8398 18.02H4.16016C3.99089 18.02 3.8444 17.9614 3.7207 17.8442C3.59701 17.7271 3.53516 17.5773 3.53516 17.395Z" fill="white"/>
                    </svg>
                  </span>
                </a>
              </div>
            </div>
            <div class="col-12 col-lg-4 order-1 order-lg-2">
              <div class="image-area text-end">
                <img src="<?php echo $attachment_right_url; ?>" class="img-fluid" alt="">
              </div>
            </div>
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
