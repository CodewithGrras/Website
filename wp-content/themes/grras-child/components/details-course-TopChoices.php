<!-- Featured Courses -->
<?php
$highly_recommended_course = get_field('highly_recommended_course');
?>
<div class="topchoice intcourse coursesec serach-course">
  <div class="container">
    <div class="row">
      <div class="col-lg-12 text-center">
        <h2><?php echo get_field('top-choice_courses', 'option'); ?></h2>
      </div>
      <div class="col-lg-12">
        <div class="owl-carousel choice-course">
            <?php
            if ($highly_recommended_course && is_array($highly_recommended_course)) {
                // Loop through the recommended courses
                foreach ($highly_recommended_course as $course) {
                    // Fetch course terms (taxonomy)
                    $course_terms = get_the_terms($course->ID, 'course_types');
                    $term_classes = '';
                    $term_names = [];
                    if ($course_terms) {
                        foreach ($course_terms as $term) {
                            $term_classes .= ' ' . esc_attr($term->slug);
                            $term_names[] = $term->name;
                        }
                    }
            ?>
              <div class="item">
                <a href="<?php echo get_permalink($course->ID); ?>">
                  <div class="cobox">
                    <div class="imgbox">
                      <!-- Display the small background image -->
                      <img src="<?php echo get_field('small_background_image', $course->ID); ?>" class="img-fluid bigimg" alt="">
                      <div class="imgcontent">
                        <div class="icon">
                          <!-- Display the course thumbnail -->
                          <img src="<?php echo get_the_post_thumbnail_url($course->ID); ?>" class="img-fluid" alt="">
                        </div>
                        <h4 class="two_line">
                          <small><?php echo esc_html($term_names[0]); ?></small><br>
                          <?php echo esc_html(get_the_title($course->ID)); ?>
                        </h4>
                      </div>
                      <!-- Check for Best Seller and Discount -->
                      <?php if (get_field('best_seller', $course->ID)) : ?>
                        <div class="<?php echo esc_attr(get_field('best_seller_color', $course->ID)); ?>"><?php echo esc_html(get_field('best_seller', $course->ID)); ?></div>
                      <?php endif; ?>
                      <?php if (get_field('discount', $course->ID)) : ?>
                        <div class="offer"><?php echo esc_html(get_field('discount', $course->ID)); ?><span>%</span> OFF</div>
                      <?php endif; ?>
                    </div>
                    <div class="content">
                      <p class="two_line" style="-webkit-line-clamp: 2!important"><?php echo wp_kses_post(get_the_content(null, false, $course->ID)); ?></p>
                    </div>

                    <div class="content line">
                      <h5>Skills</h5>
                      <ul>
                        <?php
                        $tags = get_the_terms($course->ID, 'course-tags');
                        if (!empty($tags) && !is_wp_error($tags)) :
                            $tag_count = count($tags);
                            $display_count = 4;
                            $remaining_count = $tag_count - $display_count;
                            $counter = 0;
                            foreach ($tags as $tag) :
                                if ($counter < $display_count) :
                                    $image = get_field('image', 'course-tags_' . $tag->term_id);  // ACF field for tag image
                                    $image_url = $image ? $image : 'path_to_default_image.png'; // Fallback image
                                    ?>
                                    <li><?php echo esc_html(wp_trim_words($tag->name, 2, '...')); ?></li>
                                <?php
                                endif;
                                $counter++;
                            endforeach;
                            if ($remaining_count > 0) :
                                ?>
                                <li>More +<?php echo $remaining_count; ?></li>
                            <?php endif; ?>
                        <?php else : ?>
                            <li></li>
                        <?php endif; ?>
                      </ul>
                    </div>

                    <div class="content line">
                      <div class="row">
                        <div class="col-md-6 col-6">
                          <div class="star">
                            <?php 
                            $rating = get_field('rating', $course->ID);
                            for ($i = 1; $i <= $rating; $i++) {
                            ?>
                            <span class="star star-enabled">★</span>
                            <?php
                            }
                            ?>
                            &nbsp; <?php echo esc_html($rating); ?>/5 <span>(<?php echo esc_html(get_field('review_count', $course->ID)); ?>)</span>
                          </div>
                        </div>
                        <div class="col-md-6 col-6">
                          <div class="day"><img src="<?php echo esc_url(get_stylesheet_directory_uri() . '/images/days.svg'); ?>" alt=""> <?php echo esc_html(get_field('days', $course->ID)); ?> Day</div>
                        </div>
                      </div>
                    </div>
                  </div>
                </a>
              </div>
            <?php
                }
            } else {
                echo 'No Courses found.';
            }
            ?>
        </div>
      </div>
    </div>
    <div class="text-center mt-5"><a href="/course" class="btn btn-secondary">Explore More Courses</a></div>
  </div>
</div>
