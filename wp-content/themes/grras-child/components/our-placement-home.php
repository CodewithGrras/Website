<!-- Our Recent Placements -->
<?php
$args = array(
    'post_type' => 'placements',
    'posts_per_page' => 10,
    array(
        'taxonomy' => 'placement_types',
        'field'    => 'slug',
    ),
    'hide_empty'     => true,
    
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
<div class="recentplacement recentarrow wow fadeInLeft section-padding">
    <div class="container">
        <h2> <?php 
        if(get_field('our_recent_placements')):
        echo get_field('our_recent_placements');
        else:
            echo "Our Recent Placements";
        endif;
        ?></h2>
        <div class="owl-carousel our_placement">
            <?php
            if ($custom_query->have_posts()) {
                // Loop through the posts
                while ($custom_query->have_posts()) {
                    $custom_query->the_post();
                    
            ?>
                    
 <?php get_template_part('template-parts/single', 'placements');  ?>
            <?php
                }
            } else {
                echo 'No success stories found.';
            }
            // Reset post data
            wp_reset_postdata();
            ?>
        </div>
        <div class="text-center mt-4">
            
            <!--<a href="<?php echo get_field('placement_report_url') ?>" class="btn btn-primary">Download our Placement Report</a>-->
            <a href="javascript:void(0)" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal6" >Download our Placement Report</a>
            <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#exampleModal5"class="btn btn-dark" >Enquire Now</a>
        </div>
    </div>
</div>