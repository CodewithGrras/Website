<!-- Our Recent Placements -->
<?php
$args = array(
    'post_type' => 'placements',
    'posts_per_page' => 10,
    'order_by' => 'desc',
  
    
);

// Create a new query
$custom_query = new WP_Query($args);

// Fetch all terms from the 'story_categories' taxonomy
$terms = get_terms(array(
    'taxonomy' => 'placement_types',
    'hide_empty' => true,
    'orderby'    => 'name',              // Order by term name
    'order'      => 'DESC',
   
));
?>

                    <div class="owl-carousel realimpect">
            <?php
            if ($custom_query->have_posts()) {
                // Loop through the posts
                while ($custom_query->have_posts()) {
                    $custom_query->the_post();
                    $terms = get_the_terms(get_the_ID(), 'placement_types');
            ?>
                    <div class="item">
            <a href="/placement-support/" class="global-link">
                        <div class="cousebox">
                            <div class="employ">
                            <img src="<?php echo get_the_post_thumbnail_url() ?>" class="img-fluid" alt="">
                                
                            <!-- <img src="<?php echo get_stylesheet_directory_uri() ?>/images/raghav-bahad.png" class="img-fluid" alt=""> -->
                        </div>
                            <div class="name">
                                <h4><?php the_title() ?></h4>
                                <div class="subtxt"><?php echo get_field('designation') ?></div>
                            </div>
                            <div class="coname"><img src="<?php echo get_field('company') ?>" alt=""></div>
                            <div class="content">
                                <h5><?php echo get_field('course_undertaken') ?></h5>
                                <p><?php the_content() ?></p>
                            </div>
                        </div>
                    </a>
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