<?php
$filter_value = isset($_GET['workshop_filter']) ? $_GET['workshop_filter'] : '';
$loader = isset($_GET['loader']) ? $_GET['loader'] : 'khalid';

// Get the current date and time
$current_time = current_time('Y-m-d H:i:s');

// Set up query arguments
$args = array(
    'post_type' => 'workshops',
    'posts_per_page' => -1, // Get all posts or limit the number as needed
);

// Modify query based on the filter selected
if ($filter_value == 'live') {
    $args['meta_query'] = array(
        'relation' => 'AND',
        array(
            'key' => 'workshop_start_time',
            'value' => $current_time,
            'compare' => '<=',
            'type' => 'DATETIME'
        ),
        array(
            'key' => 'workshop_end_time',
            'value' => $current_time,
            'compare' => '>=',
            'type' => 'DATETIME'
        ),
    );
} elseif ($filter_value == 'upcoming') {
    $args['meta_query'] = array(
        array(
            'key' => 'workshop_start_time',
            'value' => $current_time,
            'compare' => '>',
            'type' => 'DATETIME'
        ),
    );
} elseif ($filter_value == 'past') {
    $args['meta_query'] = array(
        array(
            'key' => 'workshop_end_time',
            'value' => $current_time,
            'compare' => '<',
            'type' => 'DATETIME'
        ),
    );
}

// Create a new query
$custom_query = new WP_Query($args);

// Get the terms for the courses taxonomy
$terms = get_terms(array(
    'taxonomy' => 'courses',
    'hide_empty' => true,
));

$grass = get_field('grass');
?>

<!-- Signup for Our Upcoming Workshops -->
<div class="workshop workshopfilter wow fadeInUp">
    <div class="container">
        <h2><?php echo $grass['title'] ?></h2>
        <div class="subtext"><?php echo $grass['sub_title'] ?></div>

        <div class="filters filter-button-group text-center">
            <ul class="isolist">
                <li class="active" data-filter="*">All Students</li>
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
                }
                ?>
            </ul>
        </div>
        <div class="row">
            <div class="col-lg-3">
                <div class="my-2">
                    <select class="form-control" id="workshop-filter">
                        <option value="">All Workshops</option>
                        <option value="live" <?php echo $filter_value == "live" ? "selected" : "" ?>>Live</option>
                        <option value="upcoming" <?php echo $filter_value == "upcoming" ? "selected" : "" ?>>Upcoming</option>
                        <option value="past" <?php echo $filter_value == "past" ? "selected" : "" ?>>Past</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-8">
                <div class="isocontent grid">
                    <div class="row" id="row-container">
                        <?php
                        if ($custom_query->have_posts()) {
                            // Loop through the posts
                            while ($custom_query->have_posts()) {
                                $custom_query->the_post();
                                $terms = get_the_terms(get_the_ID(), 'courses');
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

                                // Determine the workshop status
                                $start_time = get_field('workshop_start_time'); // Make sure this is the correct field name
                                $end_time = get_field('workshop_end_time'); // Make sure this is the correct field name
                                $status = '';

                                if ($start_time && $end_time) {
                                    $start_date_time = DateTime::createFromFormat('Y-m-d H:i:s', $start_time);
                                    $end_date_time = DateTime::createFromFormat('Y-m-d H:i:s', $end_time);

                                    if ($start_date_time && $end_date_time) {
                                        if ($current_time >= $start_time && $current_time <= $end_time) {
                                            $status = 'live';
                                        } elseif ($current_time < $start_time) {
                                            $status = 'upcoming';
                                        } else {
                                            $status = 'past';
                                        }
                                    }
                                }
                                ?>
                                <div class="col-sm-6 single-content grid-item data <?php echo $term_string ?>">
                                    <div class="cousebox">
                                        <img src="<?php the_post_thumbnail_url() ?>" class="img-fluid" alt="">
										
										
                                        <div class="<?php echo $status; ?>">
                                            <?php echo ucfirst($status); ?>
                                        </div>
                                        <div class="content">
                                            <div class="detail">
                                                <h4 class="custom_contant" style="-webkit-line-clamp: 2!important;"><?php the_title(); ?></h4>
                                                <div class="date">
                                                    <?php
                                                    // Display formatted date
                                                    if ($start_date_time) {
                                                        echo $start_date_time->format('jS M, D');
                                                    } else {
                                                        echo 'Invalid start time';
                                                    }
                                                    ?>
                                                </div>
                                                <div class="time">
                                                    <?php
                                                    // Display formatted time range
                                                    if ($start_date_time && $end_date_time) {
                                                        echo $start_date_time->format('h:i A') . ' - ' . $end_date_time->format('h:i A');
                                                    } else {
                                                        echo 'Invalid time range';
                                                    }
                                                    ?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="botmcontent">
                                            <p><strong><?php the_field('register_people'); ?> people have registered</strong></p>
                                            <a href="<?php echo get_post_permalink(); ?>" class="btn btn-success"><?php echo $status == 'past' ? "View Past Event": "Register Now"?></a>
                                        </div>
                                    </div>
                                </div>
                        <?php
                            }
                        } else {
                            echo 'No workshops found.';
                        }
                        // Reset post data
                        wp_reset_postdata();
                        ?>
                    </div>
                </div>
                <?php if ($loader == 'khalid') : ?>
                    <div class="row">
                        <div class="col-sm-12 text-center mt-3"><a href="javascript:void(0)" class="btn btn-primary" id="loader-workshop">View More</a></div>
                    </div>
                <?php
                endif;
                ?>
            </div>

            <div class="col-lg-4">
                <div class="grasswork">

                    <h4><?php
                        $why_attend = get_field('why_attend');
                        echo $why_attend["title"];
                        ?>
                        <br> <span><?php echo $why_attend["sub_title"]; ?></span></h4>
                    <ul>
                        <?php foreach ($why_attend['points'] as $item) { ?>
                            <li>
                                <img src="<?php echo $item["icon"] ?>" alt="">
                                <p><strong><?php echo $item["title"] ?></strong><br><?php echo $item["sub_title"] ?></p>
                            </li>
                        <?php } ?>
                    </ul>
           
                    <div class="rabox">
                        <span class="text">Average User Rating</span>
                        <span><img src="<?php echo $why_attend["rating_image"]["url"]; ?>" class="img-fluid" alt=""> <?php echo $why_attend["average_user_rating"]; ?></span>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
<script>
document.addEventListener('DOMContentLoaded', function() {
showItems('loader-workshop','#row-container','.col-sm-6.single-content','program-count');
showDefault('loader-workshop','#row-container .col-sm-6.single-content','#row-container','.col-sm-6.single-content','program-count',4);
});
</script>