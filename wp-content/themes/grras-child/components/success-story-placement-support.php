
<!-- success-storybox html -->
<div class="filters filter-button-group">
<?php
// Custom query to get 'career_success_story' posts with 'story_types' term 'rating-page'

// Create a new query
$terms = get_terms(array(
    'taxonomy' => 'story_categories',
    'hide_empty' => true
));


?>
<ul class="isolist mb-3">
    <li data-filter="*" class="active">All</li>
    <?php
    if (!empty($terms) && !is_wp_error($terms)) :
        foreach ($terms as $term) : ?>
            <li data-filter=".<?php echo esc_attr($term->slug); ?>"><?php echo esc_html($term->name); ?></li>
        <?php
        endforeach;
    endif;
    ?>
</ul>
</div>
<div class="success-storybox isocontent grid">
  <div class="row" id="row-container">
        <?php
    // Custom query to get 'career_success_story' posts with 'story_types' term 'rating-page'
    $args = array(
        'post_type' => 'career_success_story',
        'tax_query' => array(
            array(
                'taxonomy' => 'story_types',
                'field'    => 'slug',
                'terms'    => 'rating-page',
            ),
        ),
    );

    // Create a new query
    $custom_query = new WP_Query($args);

    // Check if there are posts to display

    // Fetch all terms from the 'story_categories' taxonomy
    $terms = get_terms(array(
        'taxonomy' => 'story_categories',
        'hide_empty' => false, // Change to true if you want to hide empty terms
    ));

    ?>
         <?php
                if ($custom_query->have_posts()) {

                    $i = 0;
                    // Loop through the posts
                    while ($custom_query->have_posts()) {
                        $custom_query->the_post();
                        $i++;
                        $terms = get_the_terms(get_the_ID(), 'story_categories');
                       if ($terms && !is_wp_error($terms)) {
                            $term_names = []; // Initialize an array to hold term names
                            foreach ($terms as $term) {
                                // Assuming $term is an object and you want its name
                                $term_names[] = $term->slug; // Collect term names
                            }
                            $term_string = implode(' ', $term_names);
                        }
                               
                ?>

    <div class="col-lg-3 col-md-4 col-6 single-content grid-item <?php echo $term_string ?>">
 <div class="carbox">
                            <div class="bigimg"><img src="<?php the_post_thumbnail_url(); ?>" class="img-fluid" alt=""></div>
                            <a href="#exampleModal-<?php echo $i; ?>" class="play" data-bs-toggle="modal" data-bs-target="#exampleModal-<?php echo $i; ?>"><img src="<?php echo get_stylesheet_directory_uri() ?>/images/caree-play1.png" alt=""></a>
                            <div class="company"><img src="<?php echo get_field('company_name') ?>" alt=""></div>
                            <div class="coname">
                                <h4><?php the_title(); ?></h4>
                                <p><?php echo get_field('post_designation')?> - <?php echo get_field('location'); ?></p>
                            </div>
                        </div>
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

<div class="mt-5 text-center">
    <a href="#" class="btn btn-outline-primary" id='view-more'>More Videos Reviews</a>
    <a href="<?php get_link_custom('review-rating') ?>" class="btn btn-primary">View All Success Stories</a>
</div>
</div>

</div>
 <?php
    if ($custom_query->have_posts()) {
        // Loop through the posts
        $i = 0;
        while ($custom_query->have_posts()) {
            $i++;
            $custom_query->the_post();

            $video_link = get_field('video_link');
    ?>
            <div class="modal fade" id="exampleModal-<?php echo $i; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        <div class="modal-body">
                            <iframe width="100%" height="315" src="<?php echo esc_url($video_link); ?>" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
                        </div>
                    </div>
                </div>
            </div>
    <?php
        }
    } else {
        echo 'No success stories found.';
    }
    // Reset post data
    wp_reset_postdata();
    ?>
    

<script>
document.addEventListener('DOMContentLoaded', function() {
showItems('view-more','#row-container','.col-lg-3.col-md-4.col-6.single-content.grid-item','program-count');
showDefault('view-more','#row-container .col-lg-3.col-md-4.col-6.single-content.grid-item','#row-container','.col-lg-3.col-md-4.col-6.single-content.grid-item','program-count',4);
});
</script>