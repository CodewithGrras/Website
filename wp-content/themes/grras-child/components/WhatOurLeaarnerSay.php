<!-- What our learners have to say about Grras -->
<div class="learner ==no-bg">
      <div class="container">
        <div class="row">
          <div class="col-lg-5 order-lg-2 wow fadeInRight">
            <h2>
                <?php
    $what_our_learners = get_field("what_our_learners",'option');
                    echo $what_our_learners["title"];
?>
                   <span>Grras</span>
</h2>
         <div class="subtext"><?php echo $what_our_learners["short_description"]; ?> </div>
              <?php
              if ($what_our_learners['companies_image']): ?>
         <?php foreach ($what_our_learners['companies_image'] as $item): ?>
    <div class="review">
          <a href="<?php echo $item['link']; ?>">
        <img src="<?php echo $item['image']; ?>" class="img-fluid" alt="">
        </a>
        </div>
                  <?php endforeach; ?>
<?php endif; ?>
          </div>
          <div class="col-lg-7 wow fadeInLeft">
            <div class="owl-carousel review-slid d-none d-lg-block">
           <?php
// The Loop to fetch the testimonials
$args = array(
    'post_type' => 'testimonials',
      'hide_empty' => true,
    'orderby'    => 'name',              // Order by term name
    'order'      => 'DESC',
    
);

$testimonials_query = new WP_Query($args);

    $arr = [];
if ($testimonials_query->have_posts()) :
    $i = 0;
    while ($testimonials_query->have_posts()) : $testimonials_query->the_post();
        // Get custom fields (ACF)
    
        $name = get_the_title(); // Assuming the title is the name
        
        $testimonial_text = get_the_content(); // The testimonial text (content field)
        $image = get_the_post_thumbnail_url(); // Featured image (testimonial photo)
// Add to array 
$arr[] = ['s' => $i, 'name' => $name, 'testimonial_text' => $testimonial_text, 'image' => $image, 'title' => get_field('title'), 'company' => get_field('company')];
        ?>
       
        <?php
    endwhile;
    $i++;
    wp_reset_postdata();
else :
    echo '<p>No testimonials found.</p>';
endif;
if ($arr):
    $n = count($arr);
    $mid = floor($n / 2);
    for ($i = 0; $i < $mid; $i++):
?>

<div class="item">
    <a href="/review-rating/" class="global-link">
    <div class="reviewbox">
        <!-- Displaying Image from the first half -->
        <img src="<?php echo esc_url($arr[$i]['image']); ?>" alt="Testimonial Image">
        <div class="content">
            <!-- Displaying Name and Designation -->
            <h4><?php echo esc_html($arr[$i]['name']); ?></h4>
            <p><?php echo esc_html($arr[$i]['title']); ?><?php echo esc_html($arr[$i]['company']); ?></p>
        </div>
        <!-- Displaying Testimonial Text -->
        <p class="custom_contant" style="-webkit-line-clamp: 5!important;"><small><?php echo esc_html(wp_trim_words($arr[$i]['testimonial_text'], 30)); ?></small></p>
    </div>
    
    <div class="reviewbox">
        <!-- Displaying Image from the second half -->
        <img src="<?php echo esc_url($arr[$n - 1 - $i]['image']); ?>" alt="Testimonial Image">
        <div class="content">
            <!-- Displaying Name and Designation -->
            <h4><?php echo esc_html($arr[$n - 1 - $i]['name']); ?></h4>
            <p><?php echo esc_html($arr[$n - 1 - $i]['title']); ?><?php echo esc_html($arr[$n - 1 - $i]['company']); ?></p>
        </div>
        <!-- Displaying Testimonial Text -->
        <p class="custom_contant" style="-webkit-line-clamp: 5!important;"><small><?php echo esc_html($arr[$n - 1 - $i]['testimonial_text']); ?></small></p>
    </div>
    </a>
</div>

<?php
    endfor;
endif;
?>


            </div>

            <!-- mobile slider -->
            <div class="owl-carousel mobile-review ">
			
			
			<?php 
					if ($testimonials_query->have_posts()) :
						while ($testimonials_query->have_posts()) : $testimonials_query->the_post();
							// Get custom fields (ACF)
							$name = get_the_title(); // Assuming the title is the name
							
							$testimonial_text = get_the_content(); // The testimonial text (content field)
							$image = get_the_post_thumbnail_url(); // Featured image (testimonial photo)

				?>
			
              <div class="item">
                   <a href="/review-rating/" class="global-link">
                <div class="reviewbox">
                  <img src="<?php echo esc_url($image); ?>" alt="Testimonial Image">
                  <div class="content">
                    <h4><?php echo esc_html($name); ?></h4>
                    <p><?php echo get_field('title'); ?><?php echo get_field('company'); ?></p>
                  </div>
                  <p class="custom_contant" style="-webkit-line-clamp: 5!important;"><small><?php echo esc_html(wp_trim_words($testimonial_text, 30)); ?></small></p>
                </div>
                </a>
              </div>
			  
			   <?php
    endwhile;
    wp_reset_postdata();
else :
    echo '<p>No testimonials found.</p>';
endif;
?>

            </div>
			
			
          </div>
        </div>
      </div>
    </div>
