<?php get_header();
$term = get_queried_object();

?>

    <!-- search breadcumb -->
 <!-- new desing -->
   <?php
  $banner = get_field('banner','17246');
  ?>
   <style>
       
   .coursebanner {
 
    background: url(<?php echo $banner['background_image'] ?>) no-repeat center center;
}
   </style>
    <div class="coursebanner">
      <div class="container">
        <div class="row d-flex align-items-center justify-content-between">
          <div class="col-lg-7">
            <h1><?php 
            
            echo $banner['title'];
            ?><span> <?php echo $term->name ?></span></h1>
            <p><?php echo $banner['short_description'] ?></p>
          </div>
          <div class="col-lg-4">
            <img src="<?php echo $banner['image'] ?>" class="img-fluid d-none d-sm-block" alt="">
          </div>
        </div>
      </div>
    </div>

<div class="intcourse coursesec wow fadeInUp">
      <div class="container">
        <div class="row">
          <div class="col-lg-12 d-none d-sm-block">
            <h2 class="mt-0">Courses</h2>
            <p>Learning tech skills from experts. Live tech  online classes to kickstart or accelerate your career</p>
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
               if (have_posts()) :
          while (have_posts()) : the_post();
            $course_terms = get_the_terms(get_the_ID(), 'course_types');
            $term_classes = '';

               $term_name = [];
            if ($course_terms) {
              foreach ($course_terms as $term) {
                $term_classes .= ' ' . esc_attr($term->slug);
                $term_name[] = $term->name;
              }
            }
            ?>
                  <div class="col-lg-4 col-md-4 col-sm-6 col-6 g-3">
                    <a href="<?php the_permalink(); ?>">
                      <div class="cobox">
                        <div class="imgbox">
                          <img src="<?php echo get_field('small_background_image') ?>" class="img-fluid bigimg" alt="">
                          <div class="imgcontent">
                            <div class="icon"><img src="<?php the_post_thumbnail_url(); ?>" class="img-fluid" alt=""></div>
                            <h4>
                                   <small>
                                <?php echo $term_name[0] ?>
                                </small>
                                </br>
                                <?php the_title(); ?></h4>
                          </div>
                        <?php if (get_field('best_seller')) : ?>
                        <div class="bestseller"><?php echo get_field('best_seller'); ?></div>                      
                        <?php endif; ?>
                        <?php if (get_field('discount')) : ?>
                          <div class="offer"><?php echo get_field('discount'); ?><span>%</span> OFF</div>               
                        <?php endif; ?>
                        
                        
                        </div>
                        <div class="content">
                          <p><?php the_content()?></p>
                        </div>
                        <div class="content line">
                          <h5>Skills</h5>
                          <ul>
                          <?php
  
  $post_id = get_the_ID(); // This gets the current post ID.
  $taxonomy = 'course-tags'; // We're looking for categories here. 
  $tags = get_the_terms($post_id, $taxonomy);
  
  if ( ! empty( $tags ) && ! is_wp_error( $tags ) ) :
    $tag_count = count($tags);
    $display_count = 4;
    $remaining_count = $tag_count - $display_count;
    $counter = 0;
  
    foreach ( $tags as $tag ) :
      if ($counter < $display_count) :
        // Get ACF Image Field for each tag (assuming 'tag_image' is the ACF field name)
        $image = get_field('image', 'course-tags_' . $tag->term_id);  // 'course-tags_' . $tag->term_id is the ACF field key for the taxonomy
  
        if ( $image ) : // Check if the image exists
          $image_url = $image;
          $image_alt =  $tag->name;
        else :
          $image_url = 'path_to_default_image.png'; // Fallback image if no image is set
          $image_alt = $tag->name;
        endif;
        $tag_permalink = get_term_link( $tag );
        ?>
        <li><?php echo esc_html( $tag->name ); ?></li>
      <?php
      endif;
      $counter++;
    endforeach;
  
    if ($remaining_count > 0) :
      ?>
      <li>More +<?php echo $remaining_count; ?></li>
    <?php
    endif;
  else : ?>
    <li></li>
  <?php endif; ?>
                          </ul>
                        </div>
                        <div class="content line">
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
                    </a>
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
            $term_name = [];
            if ($course_terms) {
              foreach ($course_terms as $term) {
                $term_classes .= ' ' . esc_attr($term->slug);
                $term_name[] = $term->name;
              }
            }
            ?>
                  <div class="col-lg-4 col-md-4 col-sm-6 col-6 g-3">
                    <a href="<?php the_permalink(); ?>">
                      <div class="cobox">
                        <div class="imgbox">
                          <img src="<?php echo get_field('small_background_image') ?>" class="img-fluid bigimg" alt="">
                          <div class="imgcontent">
                            <div class="icon"><img src="<?php the_post_thumbnail_url(); ?>" class="img-fluid" alt=""></div>
                            <h4>
                                <small>
                                <?php echo $term_name[0] ?>
                                </small>
                                </br>
                                <?php the_title(); ?></h4>
                          </div>
                          <?php if (get_field('best_seller')) : ?>
                        <div class="bestseller"><?php echo get_field('best_seller'); ?></div>                      
                        <?php endif; ?>
                        <?php if (get_field('discount')) : ?>
                          <div class="offer"><?php echo get_field('discount'); ?><span>%</span> OFF</div>               
                        <?php endif; ?>
                        
                        </div>
                        <div class="content">
                          <p><?php the_content()?></p>
                        </div>
                        <div class="content line">
                          <h5>Skills</h5>
                          <ul>
                          <?php
  
  $post_id = get_the_ID(); // This gets the current post ID.
  $taxonomy = 'course-tags'; // We're looking for categories here. 
  $tags = get_the_terms($post_id, $taxonomy);
  
  if ( ! empty( $tags ) && ! is_wp_error( $tags ) ) :
    $tag_count = count($tags);
    $display_count = 4;
    $remaining_count = $tag_count - $display_count;
    $counter = 0;
  
    foreach ( $tags as $tag ) :
      if ($counter < $display_count) :
        // Get ACF Image Field for each tag (assuming 'tag_image' is the ACF field name)
        $image = get_field('image', 'course-tags_' . $tag->term_id);  // 'course-tags_' . $tag->term_id is the ACF field key for the taxonomy
  
        if ( $image ) : // Check if the image exists
          $image_url = $image;
          $image_alt =  $tag->name;
        else :
          $image_url = 'path_to_default_image.png'; // Fallback image if no image is set
          $image_alt = $tag->name;
        endif;
        $tag_permalink = get_term_link( $tag );
        ?>
        <li><?php echo esc_html( $tag->name ); ?></li>
      <?php
      endif;
      $counter++;
    endforeach;
  
    if ($remaining_count > 0) :
      ?>
      <li>More +<?php echo $remaining_count; ?></li>
    <?php
    endif;
  else : ?>
    <li></li>
  <?php endif; ?>
                          </ul>
                        </div>
                        <div class="content line">
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
                    </a>
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
        <ul class="dropdown-menu">
          <?php
          if (!empty($terms) && !is_wp_error($terms)) :
            foreach ($terms as $term) : ?>
              <li><a class="dropdown-item" href="#"><?php echo esc_html($term->name); ?></a></li>
            <?php endforeach;
          endif;
          ?>
        </ul>
      </div>

      <?php
      $args = array(
        'post_type' => 'courses',
        'posts_per_page' => 8,
      );
      $courses_query = new WP_Query($args);

      if ($courses_query->have_posts()) :
        while ($courses_query->have_posts()) : $courses_query->the_post();
      ?>
          <a href="<?php the_permalink(); ?>">
            <div class="cobox mt-3">
              <div class="imgbox">
                <img src="<?php echo get_stylesheet_directory_uri() ?>/images/csimgm.png" class="img-fluid bigimg" alt="">
                <div class="imgcontent">
                  <div class="icon"><img src="<?php echo get_stylesheet_directory_uri() ?>/images/c-icon.png" class="img-fluid" alt=""></div>
                </div>
                <?php if (get_field('best_seller')) : ?>
                        <div class="bestseller"><?php echo get_field('best_seller'); ?></div>                      
                        <?php endif; ?>
                        <?php if (get_field('discount')) : ?>
                          <div class="offer"><?php echo get_field('discount'); ?><span>%</span> OFF</div>               
                        <?php endif; ?>
                        
              </div>
              <div class="right-content">
                <h4><small><?php the_title(); ?></small><br><?php the_title(); ?></h4>
                <p><?php the_content(); ?></p>
                <div class="content">
                  <div class="row">
                    <div class="col-md-6 col-6">
                      <div class="star"><img src="<?php echo get_stylesheet_directory_uri() ?>/images/star.svg" alt=""> <?php echo get_field('rating'); ?>/5 <span>(<?php echo get_field('review_count'); ?>)</span></div>
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
      <div class="text-center">
        <nav aria-label="Page navigation example">
          <ul class="pagination justify-content-center">
            <li class="page-item">
              <a class="page-link" href="#" aria-label="Previous">
                <span aria-hidden="true">«</span>
              </a>
            </li>
            <li class="page-item active"><a class="page-link" href="#">1</a></li>
            <li class="page-item"><a class="page-link" href="#">2</a></li>
            <li class="page-item"><a class="page-link" href="#">3</a></li>
            <li class="page-item">
              <a class="page-link" href="#" aria-label="Next">
                <span aria-hidden="true">»</span>
              </a>
            </li>
          </ul>
        </nav>
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
  
  var divCount = rowContainer.querySelectorAll('.col-lg-4.col-md-4.col-sm-6.col-6.g-3').length > 9 ? rowContainer.querySelectorAll('.col-lg-4.col-md-4.col-sm-6.col-6.g-3').length - 9 : 0;
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
    courseViewButton.style.display = 'none'; // Hide the button after showing all items
  });
});
</script>


<?php get_footer(); ?>
