<?php


// Get the term object for 'top-choices'
$top_choices_term = get_term_by('slug', 'top-choices', 'course_types');

// Get the terms, excluding 'top-choices' using its term ID
$terms = get_terms(array(
    'taxonomy' => 'course_types',
    'hide_empty' => true, // Change to true if you want to hide empty terms
    'exclude' => $top_choices_term ? $top_choices_term->term_id : null, // Exclude 'top-choices' term by ID
));
//echo "<pre>"; print_r($terms); exit;/*$terms[0]->term_id = 174    [3] => WP_Term Object        (            [term_id] => 174            [name] => Cyber Security            [slug] => cyber-security            [term_group] => 0            [term_taxonomy_id] => 174            [taxonomy] => course_types            [description] =>             [parent] => 0            [count] => 1            [filter] => raw        )*/
?>



<div class="intcourse allcourse coursesec">
        
        <div class="tabbed-content">
            <div class="container">
                <div class="row justify-content-center text-center">
                    <div class="col-12 col-sm-8">
                      <h2><?php echo get_field('grras_courses','option')['title']; ?></h2>
                      <p><?php echo get_field('grras_courses','option')['short_description']; ?></p>
                    </div>
                </div>
          
                <div class="d-none d-sm-block">
                     <nav class="tabs mobile-tab-hide text-center">
                         
                        <ul>
                                           <li><a href="#all" class="active">All</a></li>
                  
                       <?php
                    // Check if there are terms to display
                    if (!empty($terms) && !is_wp_error($terms)) {
                        $ik = 0;
                        foreach ($terms as $term) {
                                $ik++;
                            if ($term->slug !== 'top-choices'):
                    ?>
                                <li><a href="#<?php echo $term->slug . $ik ?>" class=""><?php echo esc_html($term->name) ?></a></li>
                    <?php
                            endif;
                        }
                    } else {
                        echo 'No categories found.';
                    }
                    ?>
                        </ul>
                    </nav>
                     <section id="all" class="item active" data-title="all">
                        <div class="item-content">
                            <div class="owl-carousel featured-course">
                                 <?php
                                // Custom query to get 'career_success_story' posts with 'story_types' term 'rating-page'
                                $args = array(
                                    'post_type' => 'courses',
                                    'hide_empty' => true,
                                    'posts_per_page' => -1, // Ensure all posts are retrieved
        'nopaging' => true // Disable pagination
                                );

                                // Create a new query
                                $custom_query = new WP_Query($args);
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
                                <div class="item <?php echo get_the_ID(); ?>">
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
                            <div class="text-center"><a href="/course" class="btn btn-secondary">Explore More Courses</a></div>
                        </div>
                    </section>
               <?php
            if ($terms && !is_wp_error($terms)) {
                $term_names = []; // Initialize an array to hold term names
                $ij = 0;

                foreach ($terms as $term) {
                    $ij++;
                ?>
                    <section id="<?php echo $term->slug . $ij?>" class="item" data-title="<?php echo $term->name ?>">
                        <div class="item-content">
                            <div class="owl-carousel featured-course">
                                 <?php
                                // Custom query to get 'career_success_story' posts with 'story_types' term 'rating-page'
                                $args = array(
                                    'post_type' => 'courses',
                                    'hide_empty' => true,

                                    'tax_query' => array(
                                        array(
                                            'taxonomy' => 'course_types',
                                            'field'    => 'slug',
                                            'terms'    => $term->slug,
                                        ),
                                        
                                    ),
                                );

                                // Create a new query
                                $custom_query = new WP_Query($args);
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
                                  <?php
                                    }
                                } else {
                                    echo 'No success stories found.';
                                }
                                // Reset post data
                                wp_reset_postdata();
                                ?>
                            </div>
                            <div class="text-center"><a href="/course" class="btn btn-secondary">Explore More Courses</a></div>
                        </div>
                    </section>
   <?php
                }
            }

            ?>
                </div>

                <!-- course mobile -->
             <div class="course-mobile d-block d-sm-none">
  <h6>Domains</h6>
  <div class="btn-group">
    <button type="button" class="btn btn-light dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
      All Course Domain
    </button>
    <ul class="dropdown-menu" id="category-filter">
        <li><a class="dropdown-item" href="" data-category=""> All </a></li>
      <?php
      if (!empty($terms) && !is_wp_error($terms)) {
         
          foreach ($terms as $term) {
              if ($term->slug !== 'top-choices') {
                  echo '<li><a class="dropdown-item" href="#" data-category="' . $term->slug . '">' . esc_html($term->name) . '</a></li>';
              }
          }
      } else {
          echo '<li>No categories found.</li>';
      }
      ?>
    </ul>
  </div>

  <div id="course-container-mobile">
    <!-- Courses will be loaded here via AJAX -->
  </div>

  <div class="text-center" id="pagination-container">
    <!-- Pagination will be loaded here via AJAX -->
  </div>
</div>

            </div>
        </div>
</div>