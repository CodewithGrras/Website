<!-- new desing -->
<div class="intcourse coursesec wow fadeInUp">
      <div class="container">
        <div class="row">
          <div class="col-lg-12 d-none d-sm-block">
             <?php if(is_front_page()): ?>
  <h2 class="mt-0 mb-3"><?php echo get_field('grras_courses','option')['title']; ?></h2>
                      <p><?php echo get_field('grras_courses','option')['short_description']; ?></p>
<?php else: ?>
  <h2 class="mt-0 mb-3">Courses</h2>
            <p>Learning tech skills from experts. Live tech  online classes to kickstart or accelerate your career</p>
<?php endif; ?>

               
          
          </div>
        </div>
        <div class="row">
          <div class="col-lg-3 d-none d-sm-block top-fixed2">
          <ul class="nav left-tab mt-3" id="myTab" role="tablist">
              <li class="nav-item" role="presentation">
                <a href="#" class="nav-link active" id="all-tab" data-bs-toggle="tab" data-bs-target="#all-tab-pane" role="tab" aria-controls="all-tab-pane" aria-selected="true">ALL</a>
              </li>
          <?php
            $terms = get_terms(array(
              'taxonomy' => 'course_types',
              'orderby' => 'name',
              'order' => 'ASC',
              
            ));

            if (!empty($terms) && !is_wp_error($terms)) :
              foreach ($terms as $term) : ?>
               <li class="nav-item" role="presentation">
                <a href="#" class="nav-link" id="<?php echo esc_attr($term->slug); ?>" data-bs-toggle="tab" data-bs-target="#<?php echo esc_attr($term->slug); ?>-tab-pane" role="tab" aria-controls="<?php echo esc_attr($term->slug); ?>-tab-pane" aria-selected="false"><?php echo esc_html($term->name); ?> (<?php echo $term->count?>)</a>
              </li>
                
              <?php endforeach;
            endif;
            ?>
           
             
             
            </ul>
            <style>
              .top-fixed2 {

    position: sticky;
    top: 0rem;
    /* width: 30%; */
    height: 100%;
    z-index: 10;
              }
            </style>
          </div>
          <div class="col-lg-9 d-none d-sm-block">
            <div class="tab-content" id="myTabContent">
    
            
              <div class="tab-pane fade show active serach-course" id="all-tab-pane" role="tabpanel" aria-labelledby="all-tab" tabindex="0">
                  
                <div class="row" id="row-container">
                <?php
    $args = array(
    'post_type'      => 'courses',
    'posts_per_page' => -1,
    'tax_query'      => array(
        array(
            'taxonomy' => 'city', // The taxonomy name
            'field'    => 'term_id', // You can use 'slug' if needed
            'terms'    => get_terms(array(
                'taxonomy'   => 'city',
                'fields'     => 'ids', // Fetch all term IDs
                'hide_empty' => false, // Include terms even if no posts are associated
            )),
            'operator' => 'NOT IN', // Exclude all terms in the taxonomy
        ),
    ),
);
        $courses_query = new WP_Query($args);

        if ($courses_query->have_posts()) :
          while ($courses_query->have_posts()) : $courses_query->the_post();
          
            ?>
                  <div class="col-lg-4 col-md-4 col-sm-6 col-6 g-3">
                                       <?php get_template_part('template-parts/details', 'course');  ?>
                  </div>
                  <?php endwhile;
        else :
          echo '<p>No courses found.</p>';
        endif;

        wp_reset_postdata();
        ?>
                  <div class="col-md-12 g-3 text-center">
                    <p><span id="program-count">8 more programs available</span></p>
                    <a href="#" class="btn btn-outline-primary mt-3 rounded-pill" id="course-view">View More</a>
                  </div>
                </div>
              </div>
              <?php
            $terms = get_terms(array(
              'taxonomy' => 'course_types',
              'orderby' => 'name',
              'order' => 'ASC',
            ));

            if (!empty($terms) && !is_wp_error($terms)) :
              foreach ($terms as $term) : ?>
             
              <div class="tab-pane fade serach-course" id="<?php echo esc_attr($term->slug); ?>-tab-pane" role="tabpanel" aria-labelledby="<?php echo esc_attr($term->slug); ?>-tab" tabindex="0">
                <div class="row">
                <?php
        $args = array(
            'post_type' => 'courses',
            'posts_per_page' => -1,
            'tax_query' => array(
        array(
            'taxonomy' => 'city', // The taxonomy name
            'field'    => 'term_id', // You can use 'slug' if needed
            'terms'    => get_terms(array( // Fetch all terms in the 'city' taxonomy
                'taxonomy' => 'city',
                'fields'   => 'ids',
            )),
            'operator' => 'NOT IN', // Exclude all terms in the taxonomy
        ),
        array(
            
            'taxonomy' => 'course_types', // Replace with your actual taxonomy
            'field' => 'slug',
            'terms' => $term->slug,
        ),
        
        ),
        );
        $courses_query = new WP_Query($args);

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
                  <div class="col-lg-4 col-md-4 col-sm-6 col-6 g-3">
                                       <?php get_template_part('template-parts/details', 'course');  ?>
                  </div>
                  <?php endwhile;
        else :
          echo '<p>No courses found.</p>';
        endif;

        wp_reset_postdata();
        ?>
          
                  <!-- <div class="col-md-12 g-3 text-center">
                    <p><span>8 more programs available</span></p>
                    <a href="#" class="btn btn-outline-primary mt-3 rounded-pill">View More</a>
                  </div> -->
                </div>
              </div>

              <?php endforeach;
            endif;
            ?>
            
            </div>
          </div>
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

<!-- new desing -->


<script>
    document.getElementById('course-view').addEventListener('click', function() {
        // Get the row container
        var rowContainer = document.querySelector('#row-container');
        // Count the number of divs inside the row
        var divCount = rowContainer.querySelectorAll('.col-lg-4.col-md-4.col-sm-6.col-6.g-3').length;
        // Display the count
        document.getElementById('program-count').textContent = '';
        // alert('Number of divs: ' + divCount);
    });
</script>
<script>
document.addEventListener('DOMContentLoaded', function() {
  var courseViewButton = document.getElementById('course-view');
  var courseItems = document.querySelectorAll('#row-container .col-lg-4.col-md-4.col-sm-6.col-6.g-3');
  var rowContainer = document.querySelector('#row-container');
  var itemsToShow = 9;
  var divCount = rowContainer.querySelectorAll('.col-lg-4.col-md-4.col-sm-6.col-6.g-3').length - 9;
        // Display the count
        document.getElementById('program-count').textContent = divCount + ' more programs available';
  // Hide items beyond the initial display count
  courseItems.forEach(function(item, index) {
    if (index >= itemsToShow) {
      item.style.display = 'none';
    }
  });

  courseViewButton.addEventListener('click', function(e) {
    e.preventDefault();
    courseItems.forEach(function(item) {
      item.style.display = 'block';
    });
    if(courseViewButton.textContent == 'Show Less'){
        courseItems.forEach(function(item, index) {
    if (index >= itemsToShow) {
      item.style.display = 'none';
    }
  });
    courseViewButton.textContent = 'Show More'; // Hide the button after showing all items
      document.getElementById('program-count').textContent = divCount + ' more programs available';
    }else{
    courseViewButton.textContent = 'Show Less'; // Hide the button after showing all items
    }
  });
});
</script>