<?php
// Get the current date and time
$current_time = current_time('Y-m-d H:i:s');

// Set up query arguments
$args = array(
    'post_type' => 'workshops',
    'posts_per_page' => -1, // Get all posts
    'meta_query' => array(
        array(
            'key' => 'workshop_start_time',
            'value' => $current_time,
            'compare' => '>',
            'type' => 'DATETIME'
        ),
    ),
);

// Create a new query
$custom_query = new WP_Query($args);
?>


<div class="workshop workshopfilter upcomming wow fadeInLeft">
                    <h2>Upcoming Workshop</h2>
                    <div class="isocontent">
                        <div class="row">

                           						   
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

                                    ?>
                                <div class="col-sm-4">
                                        <div class="cousebox">
                                        <img src="<?php the_post_thumbnail_url() ?>" class="img-fluid" alt="">
                                          
                                                   <div class="upcoming">upcoming</div>
                                         
                                            <div class="content">
                                                 <div class="detail">
                                                   <h4><?php echo get_the_title(); ?></h4>
                                                   <div class="date"> <?php
// Get the workshop start time from ACF
$date = get_field('workshop_start_time'); // Make sure this is the correct field name

// Check if the date is not empty
if ($date) {
    // Create a DateTime object from the string
    $date_time = DateTime::createFromFormat('Y-m-d H:i:s', $date);

    // Check if the DateTime object was created successfully
    if ($date_time) {
        // Format the date as "dS M, D"
        echo $date_time->format('jS M, D');
    } else {
        echo 'Invalid date format'; // Handle parsing errors
    }
} else {
    echo 'No start time provided'; // Handle empty date
}
?>

                                                                    </div>
                                                           
                          <div class="time">
                                                      <?php
// Get the workshop start and end times from ACF
$start_time = get_field('workshop_start_time'); // Make sure this is the correct field name
$end_time = get_field('workshop_end_time'); // Make sure this is the correct field name

// Check if both times are not empty
if ($start_time && $end_time) {
    // Create DateTime objects from the strings
    $start_date_time = DateTime::createFromFormat('Y-m-d H:i:s', $start_time);
    $end_date_time = DateTime::createFromFormat('Y-m-d H:i:s', $end_time);

    // Check if the DateTime objects were created successfully
    if ($start_date_time && $end_date_time) {
        // Format the times as "h:i A"
        $start_formatted = $start_date_time->format('h:i A');
        $end_formatted = $end_date_time->format('h:i A');

        // Output the formatted time range
        echo $start_formatted . ' - ' . $end_formatted;
    } else {
        echo 'Invalid date format'; // Handle parsing errors
    }
} else {
    echo 'Start time or end time not provided'; // Handle empty date
}
?>

                                                   </div>
                                               </div>
                                            </div>
                                            <div class="botmcontent">
                                               <p><strong><?php the_field('register_people'); ?> people have registered</strong></p>
                                               <a href="<?php echo get_post_permalink(); ?>" class="btn btn-success">Register Now</a>
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
