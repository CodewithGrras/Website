 
 <!-- Featured Courses -->
<?php
$args = array(
    'post_type' => 'courses',
    'tax_query' => array(
        array(
            'taxonomy' => 'course_types',
            'field'    => 'slug',
            'terms'    => 'top-choices',
        ),
    ),
);
$custom_query = new WP_Query($args);
?>
    <div class="topchoice intcourse coursesec serach-course">
      <div class="container">
        <div class="row">
          <div class="col-lg-12 text-center">
            <h2><?php echo get_field('top-choice_courses','option'); ?></h2>
            <!--<p class="pt-2">Learning tech skills from experts. Live tech  online classes to kickstart or accelerate your career</p>            -->
          </div>
          <div class="col-lg-12">
            <div class="owl-carousel choice-course">
                <?php
                    if ($custom_query->have_posts()) {
                        // Loop through the posts
                        while ($custom_query->have_posts()) {
                            $custom_query->the_post();
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
              <div class="item">
                    <?php get_template_part('template-parts/details', 'course');  ?>
              </div>
              <div class="item">
                    <?php get_template_part('template-parts/details', 'course');  ?>
              </div>
              <div class="item">
                    <?php get_template_part('template-parts/details', 'course');  ?>
              </div>
              <div class="item">
                    <?php get_template_part('template-parts/details', 'course');  ?>
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
          </div>
        </div>
        <div class="text-center mt-3"><a href="/course" class="btn btn-secondary">Explore More Courses</a></div>
      </div>
    </div>
      
