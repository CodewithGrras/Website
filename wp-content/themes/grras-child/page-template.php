<?php

/**
 * Template Name: Academy Page Template
 */
get_header();
?>

    <!-- Academy Banner -->
    <div class="academy-section coursebanner bg-theme-light section-padding" style="background-image: url('<?php echo get_field('banner_background_image'); ?>');">
      <div class="container">
        <div class="row d-flex align-items-center justify-content-between">
          <div class="col-12 col-md-6 mb-5 mb-md-0">
            <div class="banner-content text-center text-md-start">
              <?php echo get_field('banner_left_content'); ?>
            </div>
          </div>
          <div class="col-12 col-md-6">
            <div class="banner-image-area position-relative text-center text-md-start">
              <img src="<?php echo get_field('banner_right_section_image_1'); ?>" class="img-fluid" alt="">
              <div class="avatar-area bg-white theme-box-shadow py-3 px-3 px-md-4 rounded position-absolute text-start">
                <?php echo get_field('banner_right_section_text'); ?>
                <div class="userimage mt-2">
                  <img src="<?php echo get_field('banner_right_section_image_2'); ?>" class="img-fluid" />
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- End Academy Banner -->

    <!-- Learner Section -->
    <?php if( have_rows('learner_partners') ): ?>
    
    <div class="learner-section wow fadeInUp section-padding">
      <div class="container">
        <div class="row">
          <div class="col-12 col-lg-12">
            <div class="heading-area text-center">
              <h1 class="fw-bold"><?php echo get_field('learner_section_heading'); ?></h1>
              <p class="theme-text-light"><?php echo get_field('learner_section_subheading'); ?></p>
            </div>
          </div>
        </div>
        <?php
        $total = wp_count_posts('learning-partners')->publish;
        $limit = 15;

        $partners = new WP_Query([
        'post_type' => 'learning-partners',
        'posts_per_page' => $limit,
        'post_status' => 'publish'
        ]);
        ?>

        <div class="learner-grid mt-4">
        <?php if ( $partners->have_posts() ): ?>
            <?php while ( $partners->have_posts() ): $partners->the_post();
            $image = get_the_post_thumbnail_url(get_the_ID(), 'medium');
            $name = get_the_title();
            ?>
            <div class="imgbox text-center">
                <img src="<?php echo esc_url($image); ?>" alt="<?php echo esc_attr($name); ?>" class="img-fluid p-3">
                <div class="fw-semibold name p-3"><?php echo esc_html($name); ?></div>
            </div>
            <?php endwhile; ?>
            <?php wp_reset_postdata(); ?>
        <?php endif; ?>
        </div>

        <?php if ( $total > $limit ): ?>
        <div class="row mt-4">
            <div class="col-12 text-center">
            <div class="text-secondary fw-medium mb-3"><?php echo ($total - $limit); ?> more partners available</div>
            <a href="<?php echo get_post_type_archive_link('learning-partners'); ?>" class="btn btn-outline-primary rounded-pill btn-sm">View More</a>
            </div>
        </div>
        <?php endif; ?>

      </div>
    </div>
    
    <?php endif; ?>
    <!-- End Learner Section -->

    <!-- Industry Section -->
    <div class="industry-section wow fadeInUp bg-theme-light section-padding">
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-12 col-lg-12 col-xl-10">
            <div class="heading-area text-lg-center">
              <h1 class="fw-bold"><?php echo get_field('industry_heading'); ?></h1>
              <p><?php echo get_field('industry_subheading'); ?></p>
            </div>
          </div>
        </div>
        <?php if(have_rows('industry_sections')) {
            while( have_rows('industry_sections') ) {
                the_row();
                $sectionType = get_sub_field('section_template_type'); 
        ?>

        <?php if($sectionType === 'left_image_right_text') { ?>
        <div class="row justify-content-center py-4 py-lg-5 <?php echo get_sub_field('additional_row_class'); ?>">
          <div class="col-12 col-lg-6 order-2 order-lg-1">
            <div class="img-area">
              <img src="<?php echo get_sub_field('left_image'); ?>" class="img-fluid" />
            </div>
          </div>
          <div class="col-12 col-lg-6 order-1 order-lg-2 mb-3 mb-lg-0">
              <div class="content-area">
                <?php echo get_sub_field('right_text'); ?>
              </div>
          </div>
        </div>
        <?php } else { ?>
        <div class="row justify-content-center py-4 py-lg-5 <?php echo get_sub_field('additional_row_class'); ?>">
          <div class="col-12 col-lg-6">
              <div class="content-area">
              <?php echo get_sub_field('left_text'); ?>
              </div>
          </div>
          <div class="col-12 col-lg-6">
            <div class="img-area">
              <img src="<?php echo get_sub_field('right_image'); ?>" class="img-fluid" />
            </div>
          </div>
        </div>
        <?php } ?>

        <?php 
            }
        }
        ?>
    
      </div>
    </div>
    <!-- End Industry Section -->

    <!-- Collaborating Section -->
    <div class="collaborate-section wow fadeInUp section-padding">
      
      <div class="container">
        <div class="row justify-content-center align-items-center">
          <div class="col-12 col-lg-6">
            <div class="heading-area">
              <?php echo get_field('collaborate_left_section'); ?>
            </div>
          </div>
          <div class="col-12 col-lg-6">
            <?php echo get_field('collaborate_right_section'); ?>
          </div>
        </div>
      </div>
    </div>
    <!-- End Collaborating Section -->

    <!-- Help Section -->
    <div class="help-section wow fadeInUp bg-theme-light section-padding position-relative">
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-12 col-lg-12 col-xl-10">
            <div class="heading-area text-lg-center">
              <h1 class="fw-bold"><?php echo get_field('collaboration_help_headline'); ?></h1>
            </div>
          </div>
        </div>
        <div class="row justify-content-center mt-4 mt-lg-5">
            <?php if(have_rows('collaboration_help_boxes')):
                while(have_rows('collaboration_help_boxes')): the_row(); 
                $boxHtml = get_sub_field('box_html');
                ?>  
            <div class="col-6 col-sm-6 col-lg-3 mb-3 mb-lg-0">
                <div class="card border brd-theme rounded-4 h-100">
                <div class="card-body p-lg-4">
                    <?php echo $boxHtml; ?>
                </div>
                </div>
            </div>
            <?php endwhile; endif; ?>
        </div>
      </div>
    </div>
    <!-- End Help Section -->

     <!-- Hear Section -->
    <!-- Hear From -->
    <div class="hearform">
          <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h2><?php echo get_field('testimonial_section_heading'); ?></h2>
                </div> 
                <div class="col-md-6">
                    <div class="subtext"><?php echo get_field('testimonial_section_subheading'); ?></div>
                </div>
            </div>
          </div>
	      <div class="container-fluid">
	        <div class="row mt-80 d-flex align-items-center">
	          <div class="col-md-2">
	            <div class="nav" id="v-pills-tab" role="tablist">
	              <a href="#" class="nav-link" id="video-tab" data-bs-toggle="pill" data-bs-target="#video" role="tab" aria-controls="video" aria-selected="false">Video<br>Review</a>
	              <a href="#" class="nav-link active" id="review-tab" data-bs-toggle="pill" data-bs-target="#review" role="tab" aria-controls="review" aria-selected="true">Review</a>
	              <a href="#" class="nav-link" id="college-tab" data-bs-toggle="pill" data-bs-target="#college" role="tab" aria-controls="college" aria-selected="false">College <br>Collaboration</a>
	            </div>
	          </div>
	          <div class="col-md-10">
	            <div class="tab-content" id="v-pills-tabContent">
	              <div class="tab-pane fade" id="video" role="tabpanel" aria-labelledby="video-tab" tabindex="0">
	                <div class="owl-carousel video-review-2">
	                    <?php
						$choose_video_review = get_field('choose_video_review');
						if ($choose_video_review):
							foreach ($choose_video_review as $choose):
								$permalink = get_permalink($choose->ID);
								$image = wp_get_attachment_image_src(get_post_thumbnail_id($choose->ID), 'single-post-thumbnail');
								$title = get_the_title($choose->ID);
								$content = wp_trim_words(get_the_content($choose->ID), 20);
						?>
						<div class="item">
							<div class="carbox">
								<div class="bigimg">
									<?php if (!empty($image[0])): ?>
										<img src="<?php echo htmlspecialchars($image[0]); ?>" class="img-fluid" alt="">
									<?php endif; ?>
								</div>
								<a href="#" class="play" data-bs-toggle="modal" data-bs-target="#exampleModal">
									<img src="<?php echo get_stylesheet_directory_uri() ?>/images/caree-play1.png" alt="">
								</a>
								<div class="company">
									<img src="<?php echo get_stylesheet_directory_uri() ?>/images/gpc.png" class="img-fluid" alt="">
								</div>
								<div class="coname">
									<h4><?php echo htmlspecialchars($title); ?></h4>
									<p><?php echo htmlspecialchars(get_field('post_designation', $choose->ID)); ?></p>
								</div>
							</div>
						</div>
						<?php 
							endforeach;
						else:
						?>
							<p>No projects found.</p>
						<?php
						endif;
						?>

	                </div>
	              </div>
	              <div class="tab-pane fade show active" id="review" role="tabpanel" aria-labelledby="review-tab" tabindex="0">
	                <div class="owl-carousel video-review-2">
	                    <?php
						$choose_reviews= get_field('choose_reviews');
						if($choose_reviews):

							foreach ($choose_reviews as $choose):
								$permalink = get_permalink($choose->ID);
								$image = wp_get_attachment_image_src(get_post_thumbnail_id($choose->ID), 'single-post-thumbnail');
								$title = get_the_title($choose->ID);
								$content = wp_trim_words(get_the_content($choose->ID), 20);
						?>
						<div class="item">
							<div class="orangebox">
								<div class="content">
									<div class="row">
									<div class="col-4"><img src="<?php echo get_stylesheet_directory_uri() ?>/images/orange-quote.jpg" class="img-fluid" alt=""></div>
									<div class="col-8 text-right">
										<div class="star">
												<span class="star star-enabled">★</span>
												<span class="star star-enabled">★</span>
												<span class="star star-enabled">★</span>
												<span class="star star-enabled">★</span>
												<span class="star star-enabled">★</span>
											</div>
									</div>
									</div>
									<p>“ <?php echo wp_trim_words($choose->post_content,30); ?></p>
								</div>
								<div class="blackbg">
									<?php if (!empty($image[0])): ?>
										<img src="<?php echo htmlspecialchars($image[0]); ?>" class="img-fluid" alt="">
									<?php endif; ?>
									<h5><?php echo htmlspecialchars($title); ?></h5>
								</div>
							</div>
	                  	</div>

						<?php 
							endforeach;
						else:
						?>
							<p>No projects found.</p>
						<?php
						endif;
						?>

	                  
	                </div>
	              </div>
	              <div class="tab-pane fade" id="college" role="tabpanel" aria-labelledby="college-tab" tabindex="0">
	                <div class="owl-carousel video-review-2">
	                     <?php
						$choose_placments = get_field('choose_placments');
						if ($choose_placments):
							foreach ($choose_placments as $choose):
						
								// $permalink = get_permalink($choose->ID);
								$image = wp_get_attachment_image_src(get_post_thumbnail_id($choose->ID), 'single-post-thumbnail');
						
						?>
						<div class="item">
							<div class="reviewbox">
								<img src="<?php echo $image[0] ?>" alt="" style="width: 63px; height: 63px">
								</br>
								<div class="content">
									<h4><?php echo $choose->post_title; ?></h4>
									<p><?php echo get_field('designation',$choose->ID) ?> @ <?php echo get_field('course_undertaken',$choose->ID) ?></p>
								</div>
								<p><small><?php echo $choose->post_content ?></small></p>
							</div>
	                  	</div>
	               
	                  	<?php 
							endforeach;
						else:
						?>
							<p>No projects found.</p>
						<?php
						endif;
						?>
	                </div>
	              </div>
	            </div>
	          </div>
	        </div>
	      </div>
	    </div>
    <!-- End Hear Section -->

    <!-- Innovation Section -->
    <div class="innovation wow fadeInUp section-padding pt-0">
      <div class="container">
        <div class="row justify-content-center align-items-center">
          <div class="col-12 col-lg-7 mb-4 mb-lg-0">
            <div class="heading-area">
              <h1 class="fw-bold">Innovation in Action Hackathons and Competitions</h1>
              <p>Our industry-academic collaborations bring learning to life through exciting hackathons and competitions. These platforms allow students to</p>
              <ul class="list-unstyled mb-0 theme-text-light">
                <li class="mb-2">
                  <svg xmlns="http://www.w3.org/2000/svg" width="18px" height="18px" viewBox="0 0 22 22" fill="none">
                    <path d="M21.6562 10.75C21.6562 16.6367 16.8438 21.4062 11 21.4062C5.11328 21.4062 0.34375 16.6367 0.34375 10.75C0.34375 4.90625 5.11328 0.09375 11 0.09375C16.8438 0.09375 21.6562 4.90625 21.6562 10.75ZM9.75391 16.4219L17.6602 8.51562C17.918 8.25781 17.918 7.78516 17.6602 7.52734L16.6719 6.58203C16.4141 6.28125 15.9844 6.28125 15.7266 6.58203L9.28125 13.0273L6.23047 10.0195C5.97266 9.71875 5.54297 9.71875 5.28516 10.0195L4.29688 10.9648C4.03906 11.2227 4.03906 11.6953 4.29688 11.9531L8.76562 16.4219C9.02344 16.6797 9.49609 16.6797 9.75391 16.4219Z" fill="#EF7221"/>
                  </svg>
                  <span>Solve real-world challenges.</span>
                </li>
                <li class="mb-2">
                  <svg xmlns="http://www.w3.org/2000/svg" width="18px" height="18px" viewBox="0 0 22 22" fill="none">
                    <path d="M21.6562 10.75C21.6562 16.6367 16.8438 21.4062 11 21.4062C5.11328 21.4062 0.34375 16.6367 0.34375 10.75C0.34375 4.90625 5.11328 0.09375 11 0.09375C16.8438 0.09375 21.6562 4.90625 21.6562 10.75ZM9.75391 16.4219L17.6602 8.51562C17.918 8.25781 17.918 7.78516 17.6602 7.52734L16.6719 6.58203C16.4141 6.28125 15.9844 6.28125 15.7266 6.58203L9.28125 13.0273L6.23047 10.0195C5.97266 9.71875 5.54297 9.71875 5.28516 10.0195L4.29688 10.9648C4.03906 11.2227 4.03906 11.6953 4.29688 11.9531L8.76562 16.4219C9.02344 16.6797 9.49609 16.6797 9.75391 16.4219Z" fill="#EF7221"/>
                  </svg>
                  <span>Showcase their technical skills to industry leaders.</span>
                </li>
                <li>
                  <svg xmlns="http://www.w3.org/2000/svg" width="18px" height="18px" viewBox="0 0 22 22" fill="none">
                    <path d="M21.6562 10.75C21.6562 16.6367 16.8438 21.4062 11 21.4062C5.11328 21.4062 0.34375 16.6367 0.34375 10.75C0.34375 4.90625 5.11328 0.09375 11 0.09375C16.8438 0.09375 21.6562 4.90625 21.6562 10.75ZM9.75391 16.4219L17.6602 8.51562C17.918 8.25781 17.918 7.78516 17.6602 7.52734L16.6719 6.58203C16.4141 6.28125 15.9844 6.28125 15.7266 6.58203L9.28125 13.0273L6.23047 10.0195C5.97266 9.71875 5.54297 9.71875 5.28516 10.0195L4.29688 10.9648C4.03906 11.2227 4.03906 11.6953 4.29688 11.9531L8.76562 16.4219C9.02344 16.6797 9.49609 16.6797 9.75391 16.4219Z" fill="#EF7221"/>
                  </svg>
                  <span>Network with mentors, peers, and recruiters.</span>
                </li>
              </ul>
            </div>
          </div>
          <div class="col-12 col-lg-5">
              <div class="innovation-slider">
                <div class="owl-carousel innovation-slider-area">
                  <?php if(have_rows('innovation_gallery_slide')):
                    while(have_rows('innovation_gallery_slide')): the_row();
                        $img1 = get_sub_field('gallery_image_1');
                        $img2 = get_sub_field('gallery_image_2');
                        $img3 = get_sub_field('gallery_image_3');
                    ?>
                        <div class="item">
                            <div class="row gx-3">
                            <div class="col-6 mb-3">
                                <img src="<?php echo $img1; ?>" class="image-size170 img-fluid" alt="" />
                            </div>
                            <div class="col-6 mb-3">
                                <img src="<?php echo $img2; ?>" class="image-size170 img-fluid" alt="" />
                            </div>
                            <div class="col-12">
                                <img src="<?php echo $img3; ?>" class="img-fluid" alt="" />
                            </div>
                            </div>
                        </div>
                  <?php endwhile; endif; ?>
                </div>
              </div>
          </div>
        </div>
      </div>
    </div>
    <!-- End Innovation Section -->

    <!-- Newslatter Section -->
    <div class="Newslatter-section wow fadeInUp section-padding py-0">
      <div class="container position-relative p-4 p-lg-0">
        <div class="row justify-content-center align-items-center">
          <div class="col-12 col-lg-5">
              <div class="Newslatter-image d-none d-lg-block">
                <img src="<?php echo get_field('section_left_image'); ?>" class="img-fluid" />
              </div>
          </div>
          <div class="col-12 col-lg-6">
            <div class="heading-area pt-lg-5">
              <?php echo get_field('section_right_content'); ?>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- End Newslatter Section -->
<?php 
get_footer();
?>