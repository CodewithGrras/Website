<?php
$loader = isset($_GET['loader']) ? $_GET['loader'] : 'demo';
 $args = array(
    'post_type' => 'placements',
    'posts_per_page' => $loader !== 'demo' ? -1 : 6, 
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
    'order'      => 'ASC',               
));

?>
<div class="col-lg-8">
    <div class="row">
        <div class="col-lg-12">
            <div class="filters filter-button-group">
                <ul class="isolist">
                     <li data-filter="*" class="active">All</li>
                    <?php
                    // Check if there are terms to display
                    if (!empty($terms) && !is_wp_error($terms)) {
                        foreach ($terms as $term) {
                    ?>
                            <li data-filter=".<?php echo $term->slug ?>"><?php echo esc_html($term->name) ?></li>
                    <?php
                        }
                    } else {
                        echo 'No categories found.';
                    } ?>
                </ul>
            </div>
        </div>
    </div>

    <div class="isocontent grid" id="placement_items" style="position: relative !important;">
        <div class="row">
            <?php
            if ($custom_query->have_posts()) {
                // Loop through the posts
                while ($custom_query->have_posts()) {
                    $custom_query->the_post();
                    $terms = get_the_terms(get_the_ID(), 'placement_types');
            ?>
                    <?php
                    if ($terms && !is_wp_error($terms)) {
                        $term_names = []; // Initialize an array to hold term names
                        foreach ($terms as $term) {
                            // Assuming $term is an object and you want its name
                            $term_names[] = $term->slug; // Collect term names
                        }
                        $term_string = implode(' ', $term_names);
                    }

                    ?>
                    <div class="col-lg-4 g-3 col-md-6 single-content grid-item bais <?php echo $term_string ?> ">
<a href="<?php echo get_permalink() ?>">
                        <div class="cousebox">
                            <div class="employ"><img src="<?php the_post_thumbnail_url() ?>" class="img-fluid" alt=""></div>
                            <div class="name">
                                <h4><?php the_title(); ?></h4>
                                <div class="subtxt"><?php the_field('designation'); ?></div>
                            </div>
                            <div class="coname"><img src="<?php the_field('company'); ?>" alt=""></div>
                            <div class="content">
                                <p><?php the_field('course_undertaken'); ?></p>
                                <p><?php the_content(); ?></p>
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
    </div>
    <div class="clearfix mt-4"></div>
    <?php if($loader == 'demo'): ?>
        <div class="col-lg-12 text-center mt-3" ><a href="javascript:void(0)" class="readmore"  >Read More</a></div>
                <?php 
               else:
               ?>
               <div class="col-lg-12 text-center mt-3" ><a href="/placement-support" class="readmore"  >Less More</a></div>
               <?php 
               endif;
               ?>

</div>
