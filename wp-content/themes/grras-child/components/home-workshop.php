<!-- Signup for Our Upcoming Workshops -->

<?php
$args = array(
    'post_type' => 'workshops',
    'posts_per_page' => 6, // Number of posts to show
    'post_status' => 'publish', // Only published posts
    'cat'            => '-1'
);
// Create a new query
$custom_query = new WP_Query($args);
$current_time = current_time('Y-m-d H:i:s');
?>
<div class="workshop wow fadeInLeft">
    <div class="container">
        <h2><?php echo get_field('workshop')["title"] ?></h2>
        <div class="subtext"><?php echo get_field('workshop')["short_description"] ?></div>
        <div class="owl-carousel exclusive-course owl-loaded owl-drag">
            <?php
            if ($custom_query->have_posts()) {
                // Loop through the posts
                while ($custom_query->have_posts()) {
                    $custom_query->the_post();
                      
                      get_template_part('template-parts/solo', 'workshop');
        
                }
            } else {
                echo 'No success stories found.';
            }
            // Reset post data
            wp_reset_postdata();
            ?>
        </div>
        <div class="mt-4 text-center"><a href="<?php get_link_custom('workshop'); ?>" class="btn btn-primary"><strong>Explore All Workshops</strong></a></div>
    </div>
</div>