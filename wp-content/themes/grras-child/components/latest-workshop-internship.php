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

        <h2><?php echo $work_shop["title"] ?></h2>

        <div class="subtext"><?php echo $work_shop["short_descripton"] ?></div>

        <div class="owl-carousel workshop-course">

            <?php

            if ($custom_query->have_posts()) {

                // Loop through the posts

                while ($custom_query->have_posts()) {

                    $custom_query->the_post();

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

                    <div class="item">

                        <div class="cousebox">

                            <img src="<?php the_post_thumbnail_url() ?>" class="img-fluid" alt="">

                            <div class="<?php echo $status ?>"><?php echo $status; ?></div>

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

                                <p><strong><?php echo get_field('register_people'); ?> people have registered</strong></p>

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

        <div class="mt-4 text-center"><a href="<?php get_link_custom('workshop'); ?>" class="btn btn-primary">Explore All Workshops</a></div>

    </div>

</div>