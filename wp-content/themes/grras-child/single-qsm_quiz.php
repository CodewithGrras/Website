<?php
if(!isset($_GET['quizUserName']) && !isset($_GET['adminView'])) {
    wp_die('Direct access is not allowed.');
}
get_header();
global $post;
global $mlwQuizMasterNext;

$quizId = get_field('quiz_id');
$quiz_data = $mlwQuizMasterNext->pluginHelper->prepare_quiz($quizId);
$qmn_quiz_options = [];


if ( $quiz_data ) {
    $qmn_quiz_options = (array) $mlwQuizMasterNext->quiz_settings->get_quiz_options();
    $question_ids = $mlwQuizMasterNext->pluginHelper->get_questions_ids($quizId);
    $questions_count = count( $question_ids );
    $quiz_duration = $qmn_quiz_options['timer_limit'] ? $qmn_quiz_options['timer_limit'] :  0;
} else {
    wp_die('Quiz not found');
}
?>
<style>
    a.qmn_btn.mlw_qmn_quiz_link.mlw_previous span {
        margin-left: 8px;
        position: relative;
        top: 2px;
    }
    a.qmn_btn.mlw_qmn_quiz_link.mlw_next span {
        margin-right: 5px;
        position: relative;
        top: 2px;
    }
    
    .qsm-submit-btn {
        width: 100% !important;
        padding: 15px !important;
        background: linear-gradient(90deg,rgba(239, 114, 32, 1) 0%, rgba(255, 165, 2, 1) 100%) !important;
    }
    
    .qsm_contact_div {
        display: none;
    }
    
</style>
<!-- blog detail -->
    <!-- breadcrumb -->

		<nav aria-label="breadcrumb" class="breadcrumb bglight2">

		  <div class="container">

		    <ol class="breadcrumb override">

		      <li class="breadcrumb-item"><a href="<?php echo site_url(); ?>">Home</a></li>

		      <li class="breadcrumb-item"><a href="<?php echo site_url('mcq'); ?>">MCQ</a></li>

		      <li class="breadcrumb-item active" aria-current="page"><?php echo get_the_title(); ?></li>

		    </ol>

		  </div>

		</nav>
    <div class="blogdetail mcq-detail pt-4 pt-lg-5">
      <div class="container">
        <div class="row">
          <div class="col-12 col-lg-8">
              <div class="d-lg-none">
                  <a href="<?php echo get_field('mcq_pdf_file'); ?>" target="_blank" class="align-items-center btn f14 btn-primary btn-sm d-inline-flex justify-content-center px-2 text-center w-100 mb-3">
                      <span class="btn-icon d-inline-flex justify-content-center align-items-center rounded-pill">
                        <svg xmlns="http://www.w3.org/2000/svg" width="26" height="24" viewBox="0 0 26 24" fill="none">
                          <path d="M14.1993 7.75C14.1993 7.55109 14.1203 7.36032 13.9796 7.21967C13.839 7.07902 13.6482 7 13.4493 7C13.2504 7 13.0596 7.07902 12.919 7.21967C12.7783 7.36032 12.6993 7.55109 12.6993 7.75V14.34L10.7493 12.24C10.614 12.0941 10.4264 12.008 10.2276 12.0005C10.0288 11.993 9.83516 12.0647 9.68929 12.2C9.54342 12.3353 9.45725 12.5229 9.44975 12.7217C9.44225 12.9205 9.51403 13.1141 9.64929 13.26L12.8993 16.76C12.9695 16.8357 13.0546 16.8961 13.1492 16.9375C13.2439 16.9788 13.346 17.0001 13.4493 17.0001C13.5526 17.0001 13.6547 16.9788 13.7493 16.9375C13.844 16.8961 13.9291 16.8357 13.9993 16.76L17.2493 13.26C17.3845 13.1141 17.4563 12.9205 17.4488 12.7217C17.4413 12.5229 17.3552 12.3353 17.2093 12.2C17.0634 12.0647 16.8698 11.993 16.671 12.0005C16.4722 12.008 16.2845 12.0941 16.1493 12.24L14.1993 14.34V7.75Z" fill="white"/>
                          <path fill-rule="evenodd" clip-rule="evenodd" d="M13.4492 2.00002C12.7226 2.0001 11.9981 2.07855 11.2882 2.23402C10.5405 2.39878 9.81436 2.64944 9.12423 2.98102C7.86482 3.58701 6.74592 4.44943 5.83923 5.51302C4.29383 7.32079 3.4461 9.62174 3.44923 12C3.44923 17.523 7.92623 22 13.4492 22C18.9722 22 23.4492 17.523 23.4492 12C23.4492 9.52502 22.5492 7.26002 21.0592 5.51302C20.1525 4.44943 19.0336 3.58701 17.7742 2.98102C16.425 2.33215 14.9464 1.99679 13.4492 2.00002ZM12.5292 3.55002C13.451 3.45108 14.3826 3.50173 15.2882 3.70002C15.9226 3.83961 16.5386 4.05202 17.1242 4.33302C18.1958 4.84844 19.1478 5.58212 19.9192 6.48702C21.2325 8.02333 21.9526 9.97891 21.9492 12C21.9492 13.6419 21.4737 15.2487 20.5801 16.6262C19.6865 18.0036 18.4131 19.0927 16.9138 19.762C15.4144 20.4312 13.7534 20.6519 12.1313 20.3973C10.5093 20.1427 8.99565 19.4238 7.77343 18.3274C6.5512 17.2311 5.67267 15.8042 5.24401 14.2192C4.81536 12.6342 4.85492 10.959 5.35793 9.39607C5.86094 7.83311 6.80585 6.44928 8.07848 5.41184C9.3511 4.37439 10.897 3.72774 12.5292 3.55002Z" fill="white"/>
                        </svg>
                      </span>
                      <span class="ps-2">Download Stack MCQs Free PDF</span>
                </a>
              </div>
            <div class="bg-theme-light-gradient-sm p-3 mb-4">
              <div class="row d-flex">
                  <div class="d-flex">
                        <h6 class="fw-medium mb-lg-4"  style="flex: 1;">Stack MCQ Quiz - Objective Question with Answer for Stack.
                        </h6> 
                        <div class="d-none d-lg-block">
                            <a href="<?php echo get_field('mcq_pdf_file'); ?>" target="_blank" class="align-items-center btn f14 btn-primary btn-sm d-inline-flex justify-content-center px-2 text-center">
                              <span class="btn-icon d-inline-flex justify-content-center align-items-center rounded-pill">
                                <svg xmlns="http://www.w3.org/2000/svg" width="26" height="24" viewBox="0 0 26 24" fill="none">
                                  <path d="M14.1993 7.75C14.1993 7.55109 14.1203 7.36032 13.9796 7.21967C13.839 7.07902 13.6482 7 13.4493 7C13.2504 7 13.0596 7.07902 12.919 7.21967C12.7783 7.36032 12.6993 7.55109 12.6993 7.75V14.34L10.7493 12.24C10.614 12.0941 10.4264 12.008 10.2276 12.0005C10.0288 11.993 9.83516 12.0647 9.68929 12.2C9.54342 12.3353 9.45725 12.5229 9.44975 12.7217C9.44225 12.9205 9.51403 13.1141 9.64929 13.26L12.8993 16.76C12.9695 16.8357 13.0546 16.8961 13.1492 16.9375C13.2439 16.9788 13.346 17.0001 13.4493 17.0001C13.5526 17.0001 13.6547 16.9788 13.7493 16.9375C13.844 16.8961 13.9291 16.8357 13.9993 16.76L17.2493 13.26C17.3845 13.1141 17.4563 12.9205 17.4488 12.7217C17.4413 12.5229 17.3552 12.3353 17.2093 12.2C17.0634 12.0647 16.8698 11.993 16.671 12.0005C16.4722 12.008 16.2845 12.0941 16.1493 12.24L14.1993 14.34V7.75Z" fill="white"/>
                                  <path fill-rule="evenodd" clip-rule="evenodd" d="M13.4492 2.00002C12.7226 2.0001 11.9981 2.07855 11.2882 2.23402C10.5405 2.39878 9.81436 2.64944 9.12423 2.98102C7.86482 3.58701 6.74592 4.44943 5.83923 5.51302C4.29383 7.32079 3.4461 9.62174 3.44923 12C3.44923 17.523 7.92623 22 13.4492 22C18.9722 22 23.4492 17.523 23.4492 12C23.4492 9.52502 22.5492 7.26002 21.0592 5.51302C20.1525 4.44943 19.0336 3.58701 17.7742 2.98102C16.425 2.33215 14.9464 1.99679 13.4492 2.00002ZM12.5292 3.55002C13.451 3.45108 14.3826 3.50173 15.2882 3.70002C15.9226 3.83961 16.5386 4.05202 17.1242 4.33302C18.1958 4.84844 19.1478 5.58212 19.9192 6.48702C21.2325 8.02333 21.9526 9.97891 21.9492 12C21.9492 13.6419 21.4737 15.2487 20.5801 16.6262C19.6865 18.0036 18.4131 19.0927 16.9138 19.762C15.4144 20.4312 13.7534 20.6519 12.1313 20.3973C10.5093 20.1427 8.99565 19.4238 7.77343 18.3274C6.5512 17.2311 5.67267 15.8042 5.24401 14.2192C4.81536 12.6342 4.85492 10.959 5.35793 9.39607C5.86094 7.83311 6.80585 6.44928 8.07848 5.41184C9.3511 4.37439 10.897 3.72774 12.5292 3.55002Z" fill="white"/>
                                </svg>
                              </span>
                              <span class="ps-2">Download Stack MCQs Free PDF</span>
                            </a>
                      </div>
                  </div>
              </div>
              <span>
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="15" viewBox="0 0 16 15" fill="none">
                  <path fill-rule="evenodd" clip-rule="evenodd" d="M7.99213 0.5C3.64512 0.5 0.125 3.636 0.125 7.5C0.125 11.364 3.64512 14.5 7.99213 14.5C12.347 14.5 15.875 11.364 15.875 7.5C15.875 3.636 12.347 0.5 7.99213 0.5ZM8 13.5C4.27062 13.5 1.25 10.815 1.25 7.5C1.25 4.185 4.27062 1.5 8 1.5C11.7294 1.5 14.75 4.185 14.75 7.5C14.75 10.815 11.7294 13.5 8 13.5ZM8.39371 4H7.21246V8.2L11.3469 10.405L11.9375 9.544L8.39371 7.675V4Z" fill="#343A40"/>
                </svg>
                <span class="f14">Last updated on <?php echo esc_html( get_the_modified_date( 'M d, Y', $post->ID ) ); ?></span>
              </span>
            </div>
            <?php
                if (have_posts()) :
                    while (have_posts()) : the_post();
            ?>
                <div class="post-content" id="divh">
                    <?php the_content(); ?>
                </div>
            <?php endwhile; endif; ?>
          </div>
          <div class="col-12 col-lg-4">
            <?php
            // Get the repeater field
            $mcqPage = get_page_by_path('mcq');
            if($mcqPage) {
            $ads = get_field('adds', $mcqPage->ID);
            
            if ($ads && is_array($ads) && !empty($ads)) {
                $random_ad = $ads[array_rand($ads)];
                // Pick a random ad
                // Extract fields
                $ad_image = $random_ad['add_image'];
                $ad_link  = $random_ad['add_link'];
            ?>
            <div class="ads-area mb-4" style="width: 350px;">
              <a href="<?php echo $ad_link; ?>"><img src="<?php echo $ad_image; ?>" class="img-fluid w-100 h-100" /></a>
            </div>
            <?php } } ?>
              <?php
                $related_mcqs = new WP_Query([
                    'post_type'      => 'qsm_quiz',
                    'posts_per_page' => 10, // change limit as needed
                    'orderby'        => 'title',
                    'order'          => 'ASC',
                    'post__not_in'   => [ get_the_ID() ], // exclude current post
                ]);
                
                if ($related_mcqs->have_posts() && $qmn_quiz_options['pagination'] === 0) : ?>
                    <div class="related-area p-4">
                        <h5>Related MCQ</h5>
                        <ul class="mb-0 list-unstyled mt-3">
                            <?php while ($related_mcqs->have_posts()) : $related_mcqs->the_post(); ?>
                                <li>
                                    <a href="<?php the_permalink(); ?>">
                                        <?php the_title(); ?>
                                    </a>
                                </li>
                            <?php endwhile; ?>
                        </ul>
                    </div>
                <?php 
                endif; 
                wp_reset_postdata();
                ?>
            
            <?php if($qmn_quiz_options['pagination'] === 0): ?>
            <div class="getfree">
              <h3>Get Free Career Counselling</h3>
              <?php echo do_shortcode('[gravityform id="25" title="false" ajax="true"]'); ?>
              <!--<div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Full Name <span>*</span></label>
                <input type="name" class="form-control" id="exampleInputEmail1" placeholder="Enter your name">
              </div>
              <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Email <span>*</span></label>
                <input type="name" class="form-control" id="exampleInputEmail1" placeholder="Enter your emal">
              </div>
              <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Phone Number <span>*</span></label>
                <div id="emailHelp" class="form-text">OTP will be sent to this number for verification</div>
                <input type="name" class="form-control" id="exampleInputEmail1" placeholder="Enter your mobile number">
              </div>
              <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Experience <span>*</span></label>
                <select class="form-control">
                  <option>Experience</option>
                </select>
              </div>
              <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Program <span>*</span></label>
                <select class="form-control">
                  <option>Program</option>
                </select>
              </div>
              <a href="#" class="btn btn-dark d-block btn-sm text-uppercase fw-normal">Enquire Now</a>-->
            </div>
            <?php endif; ?>
          </div>
        </div>
      </div>
    </div>

    <?php
    // Get the repeater field
    $mcqPage = get_page_by_path('mcq');
    if($mcqPage):
        $ads = get_field('adds', $mcqPage->ID);
        if ($ads && is_array($ads) && !empty($ads)) {
        $random_ad = $ads[array_rand($ads)];
        // Pick a random ad
        // Extract fields
        $ad_image = $random_ad['add_image'];
        $ad_link  = $random_ad['add_link'];
        ?>
        <div class="ads-banner pb-5">
            <div class="container">
                <div class="row">
                    <div class="col-12 col-sm-12">
                        <div class="ads-area" style="height: 300px;">
                            <a href="<?php echo esc_url($ad_link); ?>">
                                <img src="<?php echo esc_url($ad_image); ?>" 
                                     alt="<?php echo $post->post_title; ?>" 
                                     class="img-fluid w-100 h-100" style="object-fit: cover; object-position: bottom;" />
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }
    endif; 
    ?>


<style>
    .quiz_section {
        width: 100% !important;
    }
</style>

<div class="modal fade" id="quizmodal" tabindex="-1">
      <div class="modal-dialog modal-md">
        <div class="modal-content">
          <button type="button" class="btn-close d-none" data-bs-dismiss="modal" aria-label="Close"></button>
          <div class="modal-body">Are you sure you want to submit this quiz?</div>
          <div class="button-footer jus p-3 text-end">
            <button type="button" class="btn btnlight btn-sm f14 text-white rounded-1 py-2 px-4" style="min-height: 41px;" data-bs-dismiss="modal">No</button>
            <button type="button" class="btn btn-primary f14 rounded-1 px-4 qsm-sure" data-bs-dismiss="modal">Yes</button>
          </div>
        </div>
      </div>
    </div>
<?php
get_footer();
?>