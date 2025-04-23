<div class="container d-none d-md-block mb-4">
    <h4 class="text-white">Trending Courses in Other Cities</h4>

    <div class="courses-list">
       <?php
$cities = get_terms('city');
foreach ($cities as $city) {
    // Get posts for each city
    $args = array(
        'post_type' => 'courses',
        'tax_query' => array(
            array(
                'taxonomy' => 'city',
                'field'    => 'slug',
                'terms'    => $city->slug,
            ),
        ),
    );
    $courses = new WP_Query($args);

    // Display course titles and permalinks
    if ($courses->have_posts()) {
        while ($courses->have_posts()) {
            $courses->the_post();
            ?>
            <a href="<?php the_permalink(); ?>"><?php the_title(); ?> |</a>
            <?php
        }
        wp_reset_postdata();
    }
}
?>
    </div>
<p style="border-top: 1px #3b3b3b solid;
"></p>
</div>


