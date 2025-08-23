<?php
/**
 * Template Name: MCQ Template
 *
 *  */
get_header();
global $mlwQuizMasterNext;
?>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css" />
<script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>

<!-- Academy Banner -->
    <div class="mcq-section coursebanner bg-theme-light section-padding image-cover pb-4" style="background-image: url(./images/mcq-bg.jpg);">
      <div class="container">
        <?php if ( have_rows('banner_slider') ) : ?>
            <div class="owl-carousel mcq-banner-slider">
                <?php while ( have_rows('banner_slider') ) : the_row(); 
                    $background_image = get_sub_field('background_image'); // can be array or url
                    $heading          = get_sub_field('heading');
                    $subheading       = get_sub_field('subheading');
                    $description      = get_sub_field('description');
                    
                    // Ensure image URL works regardless of return format
                    $bg_url = is_array($background_image) ? $background_image['url'] : $background_image;
                ?>
                    <div class="item wow fadeInUp">
                        <div class="row d-flex align-items-center justify-content-between">
                            <div class="col-12 col-md-7 mb-5 mb-md-0">
                                <div class="banner-content text-center text-md-start">
                                    <?php if ( $heading ) : ?>
                                        <h1 class="f-42 fw-bold mb-3"><?php echo $heading; ?></h1>
                                    <?php endif; ?>
                                    
                                    <?php if ( $subheading ) : ?>
                                        <h3><?php echo $subheading; ?></h3>
                                    <?php endif; ?>
                                    
                                    <?php if ( $description ) : ?>
                                        <p><?php echo $description; ?></p>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="col-12 col-md-5">
                                <div class="banner-image-area position-relative text-center text-lg-end">
                                    <?php if ( $bg_url ) : ?>
                                        <img src="<?php echo esc_url($bg_url); ?>" class="img-fluid" alt="">
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        <?php endif; ?>

      </div>
    </div>
    <!-- End Academy Banner -->

    <!-- Counter Section -->
    <div class="user-section bglight section-padding">
      <div class="container">
        <div class="bg-white p-2 rounded-2">
          <div class="row">
             <?php if ( have_rows('below_banner_tags') ) : ?>
                <?php while ( have_rows('below_banner_tags') ) : the_row(); ?>
                    <div class="col-6 col-md-6 col-lg-6 col-xl-3 wow fadeInUp">
                      <div class="user-block-area p-3 rounded-1 hover-1">
                          <div class="d-flex align-items-center">
                              <div class="user-block-icon me-3">
                                <?php echo get_sub_field('icon_svg_code'); ?>
                              </div>
                              <div class="user-block-data">
                                  <div class="user-name fw-medium"><?php echo get_sub_field('icon_title'); ?></div>
                                  <div class="usercount fw-semibold"><?php echo get_sub_field('icon_caption'); ?></div>
                              </div>
                          </div>
                      </div>
                    </div>
                <?php endwhile; ?>
            <?php endif; ?>
          </div>
        </div>
      </div>
    </div>
    <!-- End Counter Section -->

    <!-- Exam Section -->
    <div class="exam-section bglight section-padding pt-0">
        <div class="container">
        <div class="row">
            <!-- Heading -->
            <div class="col-12 col-md-8">
                <div class="heading-area">
                    <?php
                    $total_quizzes = wp_count_posts('qsm_quiz')->publish;
                    ?>
                    <h1 class="fw-bold"><?php echo $total_quizzes; ?>+ Explore all Exams</h1>
                    <p class="theme-text-light">Get exam-ready with concepts and questions as per the latest pattern</p>
                </div>
            </div>

            <!-- Search -->
            <div class="col-12 col-md-4">
                <form class="Exam-form d-none d-md-flex" method="get" action="<?php echo home_url('/'); ?>">
                    <input type="text" name="s" id="quizClientSearch" class="form-control" placeholder="Find quizes" />
                    <input type="hidden" name="post_type" value="qsm_quiz">
                    <button type="button" class="btn btn-dark btn-sm py-1 px-3 rounded-1 fw-normal ms-2">Search</button>
                </form>
            </div>
        </div>
        <!-- Mobile Filter -->
<div class="mobile-filter d-md-none p-3 shadow rounded">
  <h5 class="mb-3">Quiz Search 🔍</h5>

  <!-- Search box -->
  <div class="mb-3">
    <input type="text" class="form-control stylish-input"  id="mobSrcBox" placeholder="Find Quiz..." />
  </div>

  <!-- Dropdown with select all -->
  <?php
    $mobileTerms = get_terms([
        'taxonomy'   => 'quiz-categories',
        'hide_empty' => true,
    ]);
    if (!empty($mobileTerms) && !is_wp_error($mobileTerms)) {
  ?>
  <div class="mb-3">
    <select id="filterDropdown" multiple>
      <option value="all" data-custom-properties="select-all">Select All</option>
      <?php foreach($mobileTerms as $mobTKey=>$mobTObj): ?>
      <option value="<?php echo $mobTObj->term_id; ?>"><?php echo $mobTObj->name; ?></option>
      <?php endforeach; ?>
    </select>
  </div>
  <?php } ?>
  <!-- Submit button -->
  <button class="btn btn-primary w-100 stylish-btn mobSrcBtn" type="button">Apply Filters</button>
</div>

<style>
.mobile-filter {
  background: #fff;
  border-radius: 16px;
  transition: 0.3s;
}
.stylish-input {
  border-radius: 12px;
  border: 1px solid #ddd;
  padding: 10px 14px;
  font-size: 15px;
}
.stylish-btn {
  border-radius: 14px;
  font-weight: 600;
  padding: 12px;
  box-shadow: 0 4px 12px rgba(0, 123, 255, 0.3);
}
.stylish-btn:hover {
  transform: translateY(-2px);
  box-shadow: 0 6px 16px rgba(0, 123, 255, 0.4);
}
</style>


        <div class="bg-white p-2 rounded-2 mt-4 mt-md-0">
            <div class="row gx-2">
                <!-- Left Sidebar Tabs -->
                <div class="col-12 col-md-3">
                    <ul class="nav left-tab mt-0 tab-big" id="myTab" role="tablist">
                        <li class="nav-item w-100" role="presentation">
                          <a href="#" class="nav-link active d-none d-md-block" id="all-tab" data-bs-toggle="tab" data-bs-target="#all-tab-pane">
                            <div class="iconarea">
                              
                              <span class="ms-1">All</span>
                              <span class="arrow-area d-md-none float-end">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="12" height="8" viewBox="0 0 12 8" fill="none">
                                        <path d="M10.7458 1.1675C10.5584 0.981247 10.305 0.876705 10.0408 0.876705C9.77661 0.876705 9.52316 0.981247 9.3358 1.1675L5.7458 4.7075L2.2058 1.1675C2.01844 0.981247 1.76498 0.876705 1.5008 0.876705C1.23661 0.876705 0.983161 0.981247 0.795798 1.1675C0.70207 1.26046 0.627675 1.37106 0.576907 1.49292C0.526138 1.61478 0.5 1.74549 0.5 1.8775C0.5 2.00951 0.526138 2.14022 0.576907 2.26207C0.627675 2.38393 0.70207 2.49453 0.795798 2.5875L5.0358 6.8275C5.12876 6.92123 5.23936 6.99562 5.36122 7.04639C5.48308 7.09716 5.61379 7.1233 5.7458 7.1233C5.87781 7.1233 6.00852 7.09716 6.13037 7.04639C6.25223 6.99562 6.36283 6.92123 6.4558 6.8275L10.7458 2.5875C10.8395 2.49453 10.9139 2.38393 10.9647 2.26207C11.0155 2.14022 11.0416 2.00951 11.0416 1.8775C11.0416 1.74549 11.0155 1.61478 10.9647 1.49292C10.9139 1.37106 10.8395 1.26046 10.7458 1.1675Z" fill="CurrentColor"/>
                                    </svg>
                                </span>
                              <div class="collapseicon-mobile d-md-none">
                                
                              </div>
                            </div>
                          </a>
                          <?php
                          $quiz_query = new WP_Query([
                                'post_type' => 'qsm_quiz',
                                'posts_per_page' => -1
                            ]);

                            if ($quiz_query->have_posts()) {
                          ?>
                          <div class="exam-course-area coursesec  d-md-none" id="mobileMcqs">
                            <div class="exam-course-area-item p-2 d-none">
                              <div class="row">
                                  <?php
                                  while ($quiz_query->have_posts()) {
                                    $quiz_query->the_post();
                                    
                                    $quizId = get_field('quiz_id');
                                    $questions_count = 0;
                                    $quiz_duration = 0;
                                    $quiz_data = $mlwQuizMasterNext->pluginHelper->prepare_quiz($quizId);
                                    
                                    $firstCatName = "";
                                    
        				            if ( $quiz_data ) {
        					            $qmn_quiz_options = (array) $mlwQuizMasterNext->quiz_settings->get_quiz_options();
        					            $question_ids = $mlwQuizMasterNext->pluginHelper->get_questions_ids($quizId);
        					            $questions_count = count( $question_ids );
        					            $quiz_duration = $qmn_quiz_options['timer_limit'] ? $qmn_quiz_options['timer_limit'] :  0;
        					            
        					            $terms = wp_get_post_terms( get_the_ID(), 'quiz-categories' );

                                        if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) {
                                            $firstCatName = $terms[0]->name; // first term name
                                        }
        					        } else {
        				                continue;
        				            }
                                  ?>
                                    <div class="col-12 col-md-12 intcourse pt-0 pb-3 px-2">
                                        <div class="cobox">
                                    <div class="p-3">
                                      <div class="imgbox">
                                        <small><a class="link fw-medium"><?php echo $firstCatName; ?></a></small>
                                      </div>
                                      <div class="content p-0">
                                        <h6><a class="fw-semibold"><?php echo get_the_title(); ?></a></h6>
                                        <p class="mb-0"><?php echo get_field('quiz_tagline'); ?></p>
                                      </div>
                                    </div>
                                    <div class="content line  py-2 px-3">
                                      <?php
                                          $terms = get_the_terms(get_the_ID(), 'quiz_tags');
                                          if ($terms && !is_wp_error($terms)) {
                                                echo '<ul>';
                                                foreach ($terms as $term) {
                                                    echo '<li>';
                                                    // Your SVG icon
                                                    echo '<svg xmlns="http://www.w3.org/2000/svg" width="11px" height="11px" viewBox="0 0 24 24" fill="none" transform="matrix(-1, 0, 0, 1, 0, 0)">
<g clip-path="url(#ef7220clip0_15_213)">  <path d="M9.16894 21.8995L19.4357 11.6327C19.6505 11.4179 19.756 11.1171 19.7225 10.8152L19.1568 5.72404C19.1051 5.2592 18.7382 4.89224 18.2733 4.84059L13.1822 4.27491C12.8802 4.24136 12.5794 4.34687 12.3646 4.56168L2.09787 14.8284C1.70735 15.219 1.70735 15.8521 2.09787 16.2426L7.75472 21.8995C8.14525 22.29 8.77841 22.29 9.16894 21.8995Z" stroke="#000" stroke-linecap="round" stroke-linejoin="round"></path> <circle cx="14.1205" cy="9.88055" r="2" transform="rotate(45 14.1205 9.88055)" stroke="#000" stroke-linejoin="round"></circle> </g>
</svg> ';
                                                    // Term link
                                                    echo '<a href="#">' . esc_html($term->name) . '</a>';
                                                    echo '</li>';
                                                }
                                                echo '</ul>';
                                          }
                                      ?>
                                    </div>
                                    <ul class="list-unstyled px-3 question-list">
                                      <li>
                                        <span>Questions</span>
                                        <span class="float-end"><?php echo $questions_count; ?></span>
                                      </li>
                                      <li>
                                        <span>Time duration</span>
                                        <span class="float-end"><?php echo $quiz_duration; ?> min</span>
                                      </li>
                                    </ul>
                                    <div class="cobox-footer-quiz p-3 pt-0">
                                        <button data-url="<?php the_permalink(); ?>" data-quiz="<?php echo get_the_ID(); ?>" data-quizname="<?php the_title(); ?>" class="btn btn-primary btn-sm p-2 w-100 startQuiz">Start Quiz</button>
                                    </div>
                                  </div>
                                    </div>
                                  <?php }
                                  wp_reset_postdata();
                                  ?>
                              </div>
                            </div>
                          </div>
                          <?php } ?>
                        </li>
                        <?php
                        $terms = get_terms([
                            'taxonomy'   => 'quiz-categories',
                            'hide_empty' => true,
                        ]);
                        if (!empty($terms) && !is_wp_error($terms)) {
                            foreach ($terms as $index => $term) {
                            ?>
                                <li class="nav-item w-100" role="presentation">
                                    <a class="nav-link d-none d-md-block" id="tab-<?php echo $term->term_id; ?>" data-bs-toggle="tab" href="#pane-<?php echo $term->term_id; ?>" role="tab">
                                        <div class="iconarea">
                                            <?php echo get_term_meta($term->term_id, 'svg_code', true); ?>
                                            <span class="ms-1"><?php echo esc_html($term->name); ?></span>
                                            <span class="arrow-area d-md-none float-end">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="8" viewBox="0 0 12 8" fill="none">
                                                    <path d="M10.7458 1.1675C10.5584 0.981247 10.305 0.876705 10.0408 0.876705C9.77661 0.876705 9.52316 0.981247 9.3358 1.1675L5.7458 4.7075L2.2058 1.1675C2.01844 0.981247 1.76498 0.876705 1.5008 0.876705C1.23661 0.876705 0.983161 0.981247 0.795798 1.1675C0.70207 1.26046 0.627675 1.37106 0.576907 1.49292C0.526138 1.61478 0.5 1.74549 0.5 1.8775C0.5 2.00951 0.526138 2.14022 0.576907 2.26207C0.627675 2.38393 0.70207 2.49453 0.795798 2.5875L5.0358 6.8275C5.12876 6.92123 5.23936 6.99562 5.36122 7.04639C5.48308 7.09716 5.61379 7.1233 5.7458 7.1233C5.87781 7.1233 6.00852 7.09716 6.13037 7.04639C6.25223 6.99562 6.36283 6.92123 6.4558 6.8275L10.7458 2.5875C10.8395 2.49453 10.9139 2.38393 10.9647 2.26207C11.0155 2.14022 11.0416 2.00951 11.0416 1.8775C11.0416 1.74549 11.0155 1.61478 10.9647 1.49292C10.9139 1.37106 10.8395 1.26046 10.7458 1.1675Z" fill="CurrentColor"/>
                                                </svg>
                                            </span>
                                        </div>
                                    </a>
                                </li>
                            <?php
                            }
                        }
                        ?>
                    </ul>
                </div>

                <!-- Right Content Area -->
                <div class="col-12 col-md-9">
                    <div class="exam-course-area coursesec p-4 d-none d-md-block">
                        <div class="tab-content" id="myTabContent">
                            <?php
                            echo '<div class="tab-pane fade show active" id="all-tab-pane" role="tabpanel">';
                            echo '<div class="row">';

                            $quiz_query = new WP_Query([
                                'post_type' => 'qsm_quiz',
                                'posts_per_page' => -1
                            ]);

                            if ($quiz_query->have_posts()) {
                                while ($quiz_query->have_posts()) {
                                    $quiz_query->the_post();
                                    
                                    $quizId = get_field('quiz_id');
                                    $questions_count = 0;
                                    $quiz_duration = 0;
                                    $quiz_data = $mlwQuizMasterNext->pluginHelper->prepare_quiz($quizId);
                                    
                                    $firstCatName = "";
                                    
        				            if ( $quiz_data ) {
        					            $qmn_quiz_options = (array) $mlwQuizMasterNext->quiz_settings->get_quiz_options();
        					            $question_ids = $mlwQuizMasterNext->pluginHelper->get_questions_ids($quizId);
        					            $questions_count = count( $question_ids );
        					            $quiz_duration = $qmn_quiz_options['timer_limit'] ? $qmn_quiz_options['timer_limit'] :  0;
        					            
        					            $terms = wp_get_post_terms( get_the_ID(), 'quiz-categories' );

                                        if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) {
                                            $firstCatName = $terms[0]->name; // first term name
                                        }
        					        } else {
        				                continue;
        				            }
                                    ?>
                                    <div class="col-12 col-md-6 col-xl-4 intcourse pt-0 pb-3 px-2">
                                        <div class="cobox">
                                            <div class="p-3">
                                                <div class="imgbox">
                                                    <small><a class="link fw-medium">
                                                        <?php echo esc_html($firstCatName); ?>
                                                    </a></small>
                                                </div>
                                                <div class="content p-0">
                                                    <h6><a class="fw-semibold"><?php the_title(); ?></a></h6>
                                                    <p class="mb-0"><?php echo get_field('quiz_tagline'); ?></p>
                                                </div>
                                            </div>
                                            <div class="content line py-2 px-3">
                                                <?php
                                                  $terms = get_the_terms(get_the_ID(), 'quiz_tags');
                                                  if ($terms && !is_wp_error($terms)) {
                                                        echo '<ul>';
                                                        foreach ($terms as $term) {
                                                            echo '<li>';
                                                            // Your SVG icon
                                                            echo '<svg xmlns="http://www.w3.org/2000/svg" width="11px" height="11px" viewBox="0 0 24 24" fill="none" transform="matrix(-1, 0, 0, 1, 0, 0)">
<g clip-path="url(#ef7220clip0_15_213)">  <path d="M9.16894 21.8995L19.4357 11.6327C19.6505 11.4179 19.756 11.1171 19.7225 10.8152L19.1568 5.72404C19.1051 5.2592 18.7382 4.89224 18.2733 4.84059L13.1822 4.27491C12.8802 4.24136 12.5794 4.34687 12.3646 4.56168L2.09787 14.8284C1.70735 15.219 1.70735 15.8521 2.09787 16.2426L7.75472 21.8995C8.14525 22.29 8.77841 22.29 9.16894 21.8995Z" stroke="#000" stroke-linecap="round" stroke-linejoin="round"></path> <circle cx="14.1205" cy="9.88055" r="2" transform="rotate(45 14.1205 9.88055)" stroke="#000" stroke-linejoin="round"></circle> </g>
</svg> ';
                                                            // Term link
                                                            echo '<a href="#">' . esc_html($term->name) . '</a>';
                                                            echo '</li>';
                                                        }
                                                        echo '</ul>';
                                                  }
                                                ?>
                                            </div>
                                            <ul class="list-unstyled px-3 question-list">
                                                <li><span>Total Questions</span><span class="float-end"><?php echo $questions_count; ?></span></li>
                                                <li><span>Time Duration</span><span class="float-end"><?php echo $quiz_duration ? $quiz_duration. ' min' : 'N/A'; ?></span></li>
                                            </ul>
                                            <div class="cobox-footer p-3 pt-0">
                                                <button data-url="<?php the_permalink(); ?>" data-quiz="<?php echo get_the_ID(); ?>" data-quizname="<?php the_title(); ?>" class="btn btn-primary btn-sm p-2 w-100 startQuiz">Start Quiz</button>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                }
                                wp_reset_postdata();
                            } 
                            echo '</div></div>';
                            if (!empty($terms) && !is_wp_error($terms)) {
                                foreach ($terms as $index => $term) {
                                    echo '<div class="tab-pane fade" id="pane-' . $term->term_id . '" role="tabpanel">';
                                    echo '<div class="row">';

                                    $quiz_query = new WP_Query([
                                        'post_type' => 'qsm_quiz',
                                        'tax_query' => [
                                            [
                                                'taxonomy' => 'quiz-categories',
                                                'field'    => 'term_id',
                                                'terms'    => $term->term_id,
                                            ]
                                        ],
                                        'posts_per_page' => -1
                                    ]);

                                    if ($quiz_query->have_posts()) {
                                        while ($quiz_query->have_posts()) {
                                            $quiz_query->the_post();

                                            $quizId = get_field('quiz_id');
                                            $questions_count = 0;
                                            $quiz_duration = 0;
                                            $quiz_data = $mlwQuizMasterNext->pluginHelper->prepare_quiz($quizId);
                                            
                				            if ( $quiz_data ) {
                					            $qmn_quiz_options = (array) $mlwQuizMasterNext->quiz_settings->get_quiz_options();
                					            $question_ids = $mlwQuizMasterNext->pluginHelper->get_questions_ids($quizId);
                					            $questions_count = count( $question_ids );
                					            $quiz_duration = $qmn_quiz_options['timer_limit'] ? $qmn_quiz_options['timer_limit'] :  0;
                					        } else {
                				                continue;
                				            }
                                            ?>
                                            <div class="col-12 col-md-6 col-xl-4 intcourse pt-0 pb-3 px-2">
                                                <div class="cobox">
                                                    <div class="p-3">
                                                        <div class="content p-0">
                                                            <h6><a class="fw-semibold"><?php the_title(); ?></a></h6>
                                                            <p class="mb-0"><?php echo get_field('quiz_tagline'); ?></p>
                                                        </div>
                                                    </div>
                                                    <div class="content line py-2 px-3">
                                                        <?php
                                                          $terms = get_the_terms(get_the_ID(), 'quiz_tags');
                                                          if ($terms && !is_wp_error($terms)) {
                                                                echo '<ul>';
                                                                foreach ($terms as $term) {
                                                                    echo '<li>';
                                                                    // Your SVG icon
                                                                    echo '<svg xmlns="http://www.w3.org/2000/svg" width="11px" height="11px" viewBox="0 0 24 24" fill="none" transform="matrix(-1, 0, 0, 1, 0, 0)">
<g clip-path="url(#ef7220clip0_15_213)">  <path d="M9.16894 21.8995L19.4357 11.6327C19.6505 11.4179 19.756 11.1171 19.7225 10.8152L19.1568 5.72404C19.1051 5.2592 18.7382 4.89224 18.2733 4.84059L13.1822 4.27491C12.8802 4.24136 12.5794 4.34687 12.3646 4.56168L2.09787 14.8284C1.70735 15.219 1.70735 15.8521 2.09787 16.2426L7.75472 21.8995C8.14525 22.29 8.77841 22.29 9.16894 21.8995Z" stroke="#000" stroke-linecap="round" stroke-linejoin="round"></path> <circle cx="14.1205" cy="9.88055" r="2" transform="rotate(45 14.1205 9.88055)" stroke="#000" stroke-linejoin="round"></circle> </g>
</svg> ';
                                                                    // Term link
                                                                    echo '<a href="#">' . esc_html($term->name) . '</a>';
                                                                    echo '</li>';
                                                                }
                                                                echo '</ul>';
                                                          }
                                                          ?>
                                                    </div>
                                                    <ul class="list-unstyled px-3 question-list">
                                                        <li><span>Total Questions</span><span class="float-end"><?php echo $questions_count; ?></span></li>
                                                        <li><span>Time Duration</span><span class="float-end"><?php echo $quiz_duration ? $quiz_duration. ' min' : 'N/A'; ?></span></li>
                                                    </ul>
                                                    <div class="cobox-footer p-3 pt-0">
                                                        <button data-url="<?php the_permalink(); ?>" data-quiz="<?php echo get_the_ID(); ?>" data-quizname="<?php the_title(); ?>" class="btn btn-primary btn-sm p-2 w-100 startQuiz">Start Quiz</button>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php
                                        }
                                        wp_reset_postdata();
                                    } else {
                                        echo '<p class="text-muted">No quizzes found in this category.</p>';
                                    }
                                    echo '</div></div>';
                                }
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <!-- Heading -->
            <div class="col-12 col-md-12">
                <div class="banner-area pt-5">
                    <a href="https://google.com">
                        <img src="https://webnew.grras.com/wp-content/uploads/2025/08/UIUX-1200X300-2.jpg" alt="Landing Quiz" class="img-fluid w-100 h-100" style="object-fit: cover; object-position: bottom;">
                    </a>
                </div>
            </div>
        </div>
    </div>
    </div>
    <!-- End Exam Section -->

    <!-- Choice Section -->
    <div class="topchoice choice-section bg-theme-dark-gradient section-padding">
      <div class="container">
        <div class="row">
          <div class="col-12 col-md-12">
            <div class="heading-area text-center mb-md-4">
              <h1 class="fw-bold"><?php echo get_field('top_choice_mcq_title'); ?></h1>
              <p class="mb-0 mb-md-3"><?php echo get_field('top_choice_mcq_description'); ?></p>
            </div>
          </div>
        </div>
        <?php 
        $mcqs = get_field('top_choice_mcqs');
        ?>
        <div class="row">
          <div class="col-12 col-md-12">
            <div class="wow fadeInUp owl-carousel choice-course overflow-visible exam-course-area coursesec bg-transparent" style="max-height: initial;">
              <?php foreach($mcqs as $mcq):
                    $quizId = get_field('quiz_id', $mcq);
                    $questions_count = 0;
                    $quiz_duration = 0;
                    $quiz_data = $mlwQuizMasterNext->pluginHelper->prepare_quiz($quizId);
                    
		            if ( $quiz_data ) {
			            $qmn_quiz_options = (array) $mlwQuizMasterNext->quiz_settings->get_quiz_options();
			            $question_ids = $mlwQuizMasterNext->pluginHelper->get_questions_ids($quizId);
			            $questions_count = count( $question_ids );
			            $quiz_duration = $qmn_quiz_options['timer_limit'] ? $qmn_quiz_options['timer_limit'] :  0;
			        }
              ?>
              <div class="item">
                <div class="intcourse py-0">
                  <div class="cobox">
                    <div class="p-3">
                      <div class="content p-0">
                        <h6><a class="fw-semibold"><?php echo get_the_title($mcq); ?></a></h6>
                        <p class="mb-0"><?php echo get_field('quiz_tagline', $mcq); ?></p>
                      </div>
                    </div>
                    <div class="content line  py-2 px-3">
                      <?php
                      $terms = get_the_terms($mcq, 'quiz_tags');
                      if ($terms && !is_wp_error($terms)) {
                            echo '<ul>';
                            foreach ($terms as $term) {
                                echo '<li>';
                                // Your SVG icon
                                echo '<svg xmlns="http://www.w3.org/2000/svg" width="11px" height="11px" viewBox="0 0 24 24" fill="none" transform="matrix(-1, 0, 0, 1, 0, 0)">
<g clip-path="url(#ef7220clip0_15_213)">  <path d="M9.16894 21.8995L19.4357 11.6327C19.6505 11.4179 19.756 11.1171 19.7225 10.8152L19.1568 5.72404C19.1051 5.2592 18.7382 4.89224 18.2733 4.84059L13.1822 4.27491C12.8802 4.24136 12.5794 4.34687 12.3646 4.56168L2.09787 14.8284C1.70735 15.219 1.70735 15.8521 2.09787 16.2426L7.75472 21.8995C8.14525 22.29 8.77841 22.29 9.16894 21.8995Z" stroke="#000" stroke-linecap="round" stroke-linejoin="round"></path> <circle cx="14.1205" cy="9.88055" r="2" transform="rotate(45 14.1205 9.88055)" stroke="#000" stroke-linejoin="round"></circle> </g>
</svg> ';
                                // Term link
                                echo '<a href="#">' . esc_html($term->name) . '</a>';
                                echo '</li>';
                            }
                            echo '</ul>';
                      }
                      ?>
                    </div>
                    <ul class="list-unstyled px-3 question-list">
                      <li>
                        <span>Total Questions</span>
                        <span class="float-end"><?php echo $questions_count; ?></span>
                      </li>
                      <li>
                        <span>Time Duration</span>
                        <span class="float-end"><?php echo $quiz_duration ? $quiz_duration. ' min' : 'N/A'; ?></span>
                      </li>
                    </ul>
                    <div class="cobox-footer d-flex p-3 pt-0">
                        <button data-url="<?php the_permalink($mcq); ?>" data-quiz="<?php echo $mcq; ?>" data-quizname="<?php echo get_the_title($mcq); ?>" class="btn btn-primary btn-sm p-2 w-100 startQuiz">Start Quiz</button>
                    </div>
                  </div>
                </div>
              </div>
              <?php endforeach; ?>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- End Choice Section -->
    
    <!-- Trusted by Learners -->

    <?php
    // Get the page object for the slug "course"
    $course_page = get_page_by_path('course');
    // Ensure the page exists
    if ($course_page && have_rows('trusted_by_learners', $course_page->ID)) :
    ?>
        <div class="successstory turst-learn wow fadeInUp">
            <div class="container">
                <h2 class="text-center">Trusted by Learners</h2>
                <div class="review">
    
                    <?php if (have_rows('trusted_by_learners', $course_page->ID)): ?>
    
    
    
                    <?php while (have_rows('trusted_by_learners', $course_page->ID)) : the_row();
    
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
    <?php endif; ?>
    <div class="container">
        <div class="banner-area pt-5">
            <a href="https://google.com">
                <img src="https://webnew.grras.com/wp-content/uploads/2025/08/UIUX-1200X300-2.jpg" alt="Landing Quiz" class="img-fluid w-100 h-100" style="object-fit: cover; object-position: bottom;">
            </a>
        </div>
    </div>
    <?php
    include('components/faq.php');
    ?>
    
    <!-- Quiz Modal-->
    <div class="modal fade" id="quixpopup" tabindex="-1">
      <div class="modal-dialog my-5">
        <div class="modal-content">
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          <div class="modal-body contactform p-0">
            <div class="coform rounded-2 bg-white position-relative">
              <h5 class="text-start fw-semibold mb-3">Test Your Knowledge with Our Free MCQ Practice!</h5>
              <form>
                <div class="form-group mb-3">
                    <label class="form-label">Email Address <span>*</span></label>
                    <input type="email" id="userEmail" class="form-control forEmail" placeholder="Enter your email">
                </div>
                <div class="form-group mb-3">
                  <label class="form-label">Full Name <span>*</span></label>
                  <input type="text" id="userName" class="form-control forName" placeholder="Enter your Name">
                </div>
                <div class="form-group mb-3">
                  <label class="form-label">Phone Number <span>*</span></label>
                  <input type="text" id="userPhoneNumber" class="form-control forPhone" placeholder="Enter your mobile number">
                </div>
                <button type="button" class="btn btn-outline-primary w-100 m-0 text-uppercase quizPopupSubmit">Submit</button>
              </form>
            </div>
            
            <div class="loader-overlay" aria-hidden="true">
                <div class="spinner"></div>
                <div class="loader-text">Loading…</div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- End Quiz Modal-->

     <!-- Quiz Modal 2-->
    <div class="modal fade" id="quixpopup2" tabindex="-1">
      <div class="modal-dialog my-5 modal-lg">
        <div class="modal-content">
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          <div class="modal-body contactform p-0">
            <div class="coform rounded-2 bg-white position-relative">
              <h4 class="text-start fw-semibold mb-3 text-center" id="quizName"></h4>
              <div class="row position-relative">
                <div class="col-12 col-sm-12">
                  <div class="instructions">
                        
                  </div>
                  
                  <div class="d-flex justify-content-center pt-3 align-items-center border-top gap-1 gap-md-4">
                    <button type="button" id="nextbtn" class="btn btn-primary btn-sm f14 p-2">
                      <span>I am ready to begin</span>
                      <svg xmlns="http://www.w3.org/2000/svg" width="16px" height="16px" viewBox="0 0 23 22" fill="none">
                        <g clip-path="url(#clip0_7001_110698)">
                          <path d="M11.5 0C5.4346 0 0.5 4.9346 0.5 11C0.5 17.0654 5.4346 22 11.5 22C17.5654 22 22.5 17.0654 22.5 11C22.5 4.9346 17.5654 0 11.5 0ZM15.5404 11.707L10.2071 17.0405C10.0119 17.2357 9.75593 17.3333 9.5 17.3333C9.24407 17.3333 8.98813 17.2357 8.79293 17.0404C8.4024 16.6499 8.4024 16.0167 8.79293 15.6262L13.4191 10.9998L8.79293 6.37367C8.4024 5.9832 8.4024 5.35 8.79293 4.95947C9.1834 4.56893 9.8166 4.56893 10.2071 4.95947L15.5405 10.2927C15.7281 10.4802 15.8334 10.7345 15.8334 10.9997C15.8333 11.2651 15.728 11.5195 15.5404 11.707Z" fill="#fff"/>
                        </g>
                      </svg>
                    </button>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- End Quiz Modal 2-->
    
<?php
get_footer();
?>
<script>
  document.addEventListener('DOMContentLoaded', function () {
    const searchInput = document.getElementById('quizClientSearch');
    if (!searchInput) return;

    searchInput.addEventListener('input', function () {
      const searchTerm = this.value.toLowerCase().trim();

      // Find the active tab pane content container
      const activeTabPane = document.querySelector('.tab-pane.active');
      if (!activeTabPane) return;

      // All quiz cards inside active tab pane
      const quizCards = activeTabPane.querySelectorAll('.intcourse');

      quizCards.forEach(card => {
        // Get quiz title and tagline text for matching
        const titleEl = card.querySelector('h6 a.fw-semibold');
        const taglineEl = card.querySelector('.content p.mb-0');

        const title = titleEl ? titleEl.textContent.toLowerCase() : '';
        const tagline = taglineEl ? taglineEl.textContent.toLowerCase() : '';

        // Show card if title or tagline includes search term
        if (title.includes(searchTerm) || tagline.includes(searchTerm)) {
          card.style.display = '';
        } else {
          card.style.display = 'none';
        }
      });
    });
  });
  
jQuery(document).ready(function($) {
    let quizData = {
        postId: null,
        quizName: null,
        email: '',
        name: '',
        phone: '',
        ele: null
    };

    // Click on Start Quiz button
    $(document).on('click', '.startQuiz', function(e) {
        e.preventDefault();
        quizData.postId = $(this).data('quiz');
        quizData.quizName = $(this).data('quizname');
        quizData.ele = this;
        $('#quixpopup').modal('show');
    });

    // Submit in first popup
    /*$('#quixpopup .quizPopupSubmit').on('click', function() {
        quizData.email = $('#userEmail').val().trim();
        quizData.name = $('#userName').val().trim();
        quizData.phone = $('#userPhoneNumber').val().trim();
        
        if (!quizData.email || !quizData.name || !quizData.phone) {
            alert('Please fill in all required fields.');
            return false;
        }

        // Load quiz instructions via AJAX
        $.ajax({
            url: '<?php echo admin_url("admin-ajax.php"); ?>',
            type: 'POST',
            dataType: 'json',
            data: {
                action: 'get_quiz_instructions',
                post_id: quizData.postId
            },
            beforeSend: function() {
                $('.loader-overlay').addClass('show');
            },
            success: function(response) {
                $('.loader-overlay').removeClass('show');
                if (response.success) {
                    $('.instructions').html(response.data.instructions);
                } else {
                    $('.instructions').html('');
                }
                $('#quizName').html(quizData.quizName);

                // After loading instructions, show modal 2
                $('#quixpopup').modal('hide');
                setTimeout(() => {
                    $('#quixpopup2').modal('show');
                }, 300);
            },
            error: function() {
                $('.instructions').html('<p>Error loading instructions.</p>');
                $('#quixpopup').modal('hide');
                setTimeout(() => {
                    $('#quixpopup2').modal('show');
                }, 300);
            }
        });
    });*/
    
    $('#quixpopup .quizPopupSubmit').on('click', function () {
        // Clear old errors
        $('.error-msg').remove();
    
        quizData.email = $('#userEmail').val().trim();
        quizData.name = $('#userName').val().trim();
        quizData.phone = $('#userPhoneNumber').val().trim();
    
        let isValid = true;
    
        // Regex patterns
        const namePattern = /^[A-Za-z\s]{2,50}$/; // letters + spaces, 2–50 chars
        const emailPattern = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
        const phonePattern = /^[0-9+\-\s]{7,15}$/; // digits, +, -, spaces
    
        // Name validation
        if (!quizData.name || !namePattern.test(quizData.name)) {
            $('#userName').after('<div class="error-msg text-danger small">Please enter a valid name.</div>');
            isValid = false;
        }
    
        // Email validation
        if (!quizData.email || !emailPattern.test(quizData.email)) {
            $('#userEmail').after('<div class="error-msg text-danger small">Please enter a valid email address.</div>');
            isValid = false;
        }
    
        // Phone validation
        if (!quizData.phone || !phonePattern.test(quizData.phone)) {
            $('#userPhoneNumber').after('<div class="error-msg text-danger small">Please enter a valid phone number.</div>');
            isValid = false;
        }
    
        if (!isValid) {
            return false;
        }
    
        // Load quiz instructions via AJAX
        $.ajax({
            url: '<?php echo admin_url("admin-ajax.php"); ?>',
            type: 'POST',
            dataType: 'json',
            data: {
                action: 'get_quiz_instructions',
                post_id: quizData.postId
            },
            beforeSend: function () {
                $('.loader-overlay').addClass('show');
            },
            success: function (response) {
                $('.loader-overlay').removeClass('show');
                if (response.success) {
                    $('.instructions').html(response.data.instructions);
                } else {
                    $('.instructions').html('');
                }
                $('#quizName').html(quizData.quizName);
    
                $('#quixpopup').modal('hide');
                setTimeout(() => {
                    $('#quixpopup2').modal('show');
                }, 300);
            },
            error: function () {
                $('.instructions').html('<p>Error loading instructions.</p>');
                $('#quixpopup').modal('hide');
                setTimeout(() => {
                    $('#quixpopup2').modal('show');
                }, 300);
            }
        });
    });

    // I am ready to begin
    $('#quixpopup2 .btn.btn-primary').on('click', function(e) {
        e.preventDefault();
        
        if (!quizData.postId) {
            alert("No quiz selected.");
            return;
        }

        // Use data-url if available
        let quizUrl = $(quizData.ele).data('url');
        if (quizUrl) {
            quizUrl += (quizUrl.includes('?') ? '&' : '?') +
                'quizUserName=' + encodeURIComponent(quizData.name) +
                '&quizUserEmail=' + encodeURIComponent(quizData.email) +
                '&quizUserPhone=' + encodeURIComponent(quizData.phone);
            window.location.href = quizUrl;
        }
    });
});

</script>

<!-- Choices.js -->
<script>
  document.addEventListener('DOMContentLoaded', function () {
      // Initialize Choices
      const dropdown = new Choices('#filterDropdown', {
        removeItemButton: true,
        searchEnabled: true,
        placeholderValue: 'Select Category...',
        searchPlaceholderValue: 'Search Category...',
        shouldSort: false,
      });
    
      // Handle "Select All"
      dropdown.passedElement.element.addEventListener('addItem', function(event) {
        if (event.detail.value === 'all') {
          dropdown.clearStore();
          dropdown.setChoices([
            <?php foreach($mobileTerms as $mobTKey=>$mobTObj): ?>
            { value: '<?php echo $mobTObj->term_id; ?>', label: '<?php echo $mobTObj->name; ?>', selected: true },
            <?php endforeach; ?>
          ], 'value', 'label', true);
        }
      });
      
      // Custom render: show only first 2 + counter
      const limitVisible = 2;
    
      dropdown.passedElement.element.addEventListener('change', function () {
          const selected = dropdown.getValue(true); // array of selected values
          const container = dropdown.containerInner.element;
        
          // Hide all selected tags first
          const allItems = container.querySelectorAll('.choices__item--selectable');
          allItems.forEach((item, index) => {
            item.style.display = index < limitVisible ? 'inline-flex' : 'none';
          });
        
          // Remove old counter
          let oldCounter = container.querySelector('.choices__counter');
          if (oldCounter) oldCounter.remove();
        
          // Add counter if needed
          if (selected.length > limitVisible) {
            const extraCount = selected.length - limitVisible;
            const counter = document.createElement('span');
            counter.className = 'choices__counter badge bg-secondary ms-2';
            counter.innerText = `+${extraCount} more`;
            container.appendChild(counter);
        
            // Optional: toggle full view on click
            counter.addEventListener('click', () => {
              allItems.forEach(item => (item.style.display = 'inline-flex'));
              counter.remove();
            });
          }
        });
      // Bind the Apply Filters button (class, not id)
      // You can use event delegation or a direct bind:
      
      // Utility to fetch + render
      async function fetchQuizzes() {
    const selectedCats = dropdown.getValue(true)
      .filter(v => v && v !== 'all'); // remove blanks and 'all'

    const search = (document.querySelector('#mobSrcBox')?.value || '').trim();

    // Optional: visual loading state
    const target = document.querySelector('#mobileMcqs');
    if (target) {
      target.classList.add('loading');
      target.style.opacity = '0.6';
    }

    try {
      const form = new FormData();
      form.append('action', 'filter_quizzes');
      form.append('nonce', window.qsmAjax?.nonce || '');
      form.append('search', search);
      form.append('selectedCats', JSON.stringify(selectedCats));

      const res = await fetch('<?php echo admin_url('admin-ajax.php'); ?>', {
        method: 'POST',
        body: form
      });

      const data = await res.json();
      if (data.success) {
        // Expecting HTML for #mobileMcqs
        if (target) target.innerHTML = data.html;
      } else {
        if (target) target.innerHTML = `<div class="p-3 text-muted">${data.message || 'No results found.'}</div>`;
      }
    } catch (e) {
      if (target) target.innerHTML = `<div class="p-3 text-danger">Error loading results.</div>`;
      console.error(e);
    } finally {
      if (target) {
        target.classList.remove('loading');
        target.style.opacity = '1';
      }
    }
  }
      
      document.querySelectorAll('.mobSrcBtn').forEach(btn => {
          btn.addEventListener('click', fetchQuizzes);
      });
  });
  
</script>
