<?php
get_header();
$banner = get_field('banner');
?>
<style>
.workbanner {
    background: url(<?php echo $banner['background_image'] ?>) no-repeat center top;
    background-size: cover;
    padding: 30px 0 0;
}
    
</style>
<div style="position: relative">
<!-- work banner -->
<div class="workbanner wow fadeInUp">
      <div class="container">
        <div class="row justify-content-between">
          <div class="col-lg-6">
            <div class="leftcontent">
          <?php echo $banner['content'] ?>
              <div class="bluebar">
                <ul>
                  <li><?php echo $banner["mastercall"] ?></li>
                  <li><?php echo $banner["teacher"] ?></li>
                  <li>
                      
                <?php
// Get the workshop start and end times from ACF
$start_date = get_field('workshop_start_time'); // Make sure this is the correct field name
$end_date = get_field('workshop_end_time'); // Make sure this is the correct field name

// Check if the start time is not empty
if ($start_date && $end_date) {
    // Create DateTime objects from the strings
    $start_date_time = DateTime::createFromFormat('Y-m-d H:i:s', $start_date);
    $end_date_time = DateTime::createFromFormat('Y-m-d H:i:s', $end_date);

    // Check if the DateTime objects were created successfully
    if ($start_date_time && $end_date_time) {
        // Format the date as "dS M, D"
        $day = strtoupper($start_date_time->format('l')); // e.g., MONDAY
        $month_day = $start_date_time->format('j<\s\u\p>S</\s\u\p> M'); // e.g., 27<sup>th</sup> APR

        // Format the times as "h:i A"
        $start_time = $start_date_time->format('h:i A'); // e.g., 7:30 PM
        $end_time = $end_date_time->format('h:i A'); // e.g., 10:00 PM

        // Output the formatted date and time
        echo "<span class='day'>{$day}</span><br>";
        echo "<span class='month'>{$month_day}</span><br>";
        echo "<span class='time'>{$start_time} - {$end_time}</span>";
    } else {
        echo 'Invalid date format'; // Handle parsing errors
    }
} else {
    echo 'Start time or end time not provided'; // Handle empty date
}
?>
 </ul>
              </div>
              <div class="lapi"><img src="<?php echo $banner["image"] ?>" class="img-fluid" alt=""></div>
            </div>
          </div>
          <div class="col-lg-4 d-none d-md-block" style="position: absolute;
    
    left: 66%;"
    id="topfixed"
    >
              
          <div class="col-lg-4 top-fixed" style="width: 80% !important;">
            <div class="regback">
              <div class="content">
                <h3>Register NOW!</h3>
                <div class="subtext">
                    <?php
                      $date_string = get_field('workshop_start_time'); // Use the correct field name

                     $workshop_start_time = DateTime::createFromFormat('Y-m-d H:i:s', $date_string);

                            // Get the current time
                            $now = new DateTime();
                    if ($workshop_start_time < $now) {

                                 echo 'Couldn’t Attend? No Worries! Get the Workshop Recording.';
                             }else{
                                 echo '';
                            }
                            ?>
                    </div>
            <?php
               
                        // Check if the date is not empty
                        if ($date_string) {
                            // Create a DateTime object from the string
                           

                            // Calculate the difference
                            $interval = $now->diff($workshop_start_time);

                            // Prepare the countdown values
                            $days = $interval->days; // Total days
                            $hours = $interval->h; // Remaining hours
                            $minutes = $interval->i; // Remaining minutes

                            // If the event has already started, you might want to show "" instead
                            // if ($workshop_start_time < $now) {

                            //     echo '<p>Registration Closed</p>';
                            // }else{
                     echo do_shortcode('[gravityform id="7" title="false"]');           
                            // }
                            
                        }
                                ?>
               
                <div class="row">
                  <div class="col-6">
                    <!--<a href="#" class="btn btn-dark">Register Now</a>-->
                  </div>
                  <div class="col-6">
                    <div class="peoplereg"><big><?php the_field('register_people'); ?></big><br>People Registered</div>
                  </div>
                </div>
                <!-- <p>By clicking Register, I have read and agree to Grras <a href="#">Terms</a> and <a href="#">Privacy Policy</a></p> -->
              </div>
              <div class="startin">
                   <?php
                        // Get the workshop start time from ACF
               
                        // Check if the date is not empty
                        if ($date_string) {
                            // Create a DateTime object from the string
                            $workshop_start_time = DateTime::createFromFormat('Y-m-d H:i:s', $date_string);

                            // Get the current time
                            $now = new DateTime();

                            // Calculate the difference
                            $interval = $now->diff($workshop_start_time);

                            // Prepare the countdown values
                            $days = $interval->days; // Total days
                            $hours = $interval->h; // Remaining hours
                            $minutes = $interval->i; // Remaining minutes

                            // If the event has already started, you might want to show "" instead
                            if ($workshop_start_time < $now) {
                                echo '<ul><li></li></ul>';
                            } else {
                                // Output the countdown
                                echo '<ul>';
                                echo '<li>Starts in</li>';
                                echo '<li><div class="number">' . str_pad($days, 2, '0', STR_PAD_LEFT) . ' d</div></li>';
                                echo '<li><div class="number">' . str_pad($hours, 2, '0', STR_PAD_LEFT) . ' h</div></li>';
                                echo '<li><div class="number">' . str_pad($minutes, 2, '0', STR_PAD_LEFT) . ' m</div></li>';
                                echo '</ul>';
                            }
                        } else {
                            echo '<ul><li>No start time provided</li></ul>'; // Handle empty date
                        }
                        ?>
             
              </div>
            </div>
          </div>
          </div>
          <div class="col-lg-4 d-block d-md-none">
            <div class="regback">
              <div class="content">
                <h3>Register NOW!</h3>
                <div class="subtext">
                    <?php
                      $date_string = get_field('workshop_start_time'); // Use the correct field name

                     $workshop_start_time = DateTime::createFromFormat('Y-m-d H:i:s', $date_string);

                            // Get the current time
                            $now = new DateTime();
                    if ($workshop_start_time < $now) {

                                 echo 'Couldn’t Attend? No Worries! Get the Workshop Recording.';
                             }else{
                                 echo '';
                            }
                            ?>
                    </div>
            <?php
               
                        // Check if the date is not empty
                        if ($date_string) {
                            // Create a DateTime object from the string
                           

                            // Calculate the difference
                            $interval = $now->diff($workshop_start_time);

                            // Prepare the countdown values
                            $days = $interval->days; // Total days
                            $hours = $interval->h; // Remaining hours
                            $minutes = $interval->i; // Remaining minutes

                            // If the event has already started, you might want to show "" instead
                            // if ($workshop_start_time < $now) {

                            //     echo '<p>Registration Closed</p>';
                            // }else{
                     echo do_shortcode('[gravityform id="7" title="false"]');           
                            // }
                            
                        }
                                ?>
               
                <div class="row">
                  <div class="col-6">
                    <!--<a href="#" class="btn btn-dark">Register Now</a>-->
                  </div>
                  <div class="col-6">
                    <div class="peoplereg"><big><?php the_field('register_people'); ?></big><br>People Registered</div>
                  </div>
                </div>
                <!-- <p>By clicking Register, I have read and agree to Grras <a href="#">Terms</a> and <a href="#">Privacy Policy</a></p> -->
              </div>
              <div class="startin">
                   <?php
                        // Get the workshop start time from ACF
               
                        // Check if the date is not empty
                        if ($date_string) {
                            // Create a DateTime object from the string
                            $workshop_start_time = DateTime::createFromFormat('Y-m-d H:i:s', $date_string);

                            // Get the current time
                            $now = new DateTime();

                            // Calculate the difference
                            $interval = $now->diff($workshop_start_time);

                            // Prepare the countdown values
                            $days = $interval->days; // Total days
                            $hours = $interval->h; // Remaining hours
                            $minutes = $interval->i; // Remaining minutes

                            // If the event has already started, you might want to show "" instead
                            if ($workshop_start_time < $now) {
                                echo '<ul><li></li></ul>';
                            } else {
                                // Output the countdown
                                echo '<ul>';
                                echo '<li>Starts in</li>';
                                echo '<li><div class="number">' . str_pad($days, 2, '0', STR_PAD_LEFT) . ' d</div></li>';
                                echo '<li><div class="number">' . str_pad($hours, 2, '0', STR_PAD_LEFT) . ' h</div></li>';
                                echo '<li><div class="number">' . str_pad($minutes, 2, '0', STR_PAD_LEFT) . ' m</div></li>';
                                echo '</ul>';
                            }
                        } else {
                            echo '<ul><li>No start time provided</li></ul>'; // Handle empty date
                        }
                        ?>
             
              </div>
            </div>
          </div>
          </div>
        </div>
      </div>
    


<!-- work detail -->
<div class="workdetail wow fadeInUp">
    <div class="container">
        <div class="row">
            <div class="col-sm-8" id="divh"> 
                <div class="workleft">
                    <h3><?php the_title(); ?></h3>
                    <div class="date"><strong> STARTS ON:</strong>
                        <?php
                        // Get the workshop start time from ACF
                        $date = get_field('workshop_start_time'); // Make sure this is the correct field name

                        // Check if the date is not empty
                        if ($date) {
                            // Create a DateTime object from the string
                            $date_time = DateTime::createFromFormat('Y-m-d H:i:s', $date);

                            // Check if the DateTime object was created successfully
                            if ($date_time) {
                                // Format the date as "F j, Y g:i a"
                                echo $date_time->format('F j, Y g:i a'). "(IST)";
                            } else {
                                echo 'Invalid date format'; // Handle parsing errors
                            }
                        } else {
                            echo 'No start time provided'; // Handle empty date
                        }
                        ?>
                        <span><strong> ENDS ON:</strong>
                            <?php
                            // Get the workshop start time from ACF
                            $date = get_field('workshop_end_time'); // Make sure this is the correct field name

                            // Check if the date is not empty
                            if ($date) {
                                // Create a DateTime object from the string
                                $date_time = DateTime::createFromFormat('Y-m-d H:i:s', $date);

                                // Check if the DateTime object was created successfully
                                if ($date_time) {
                                    // Format the date as "F j, Y g:i a"
                                    echo $date_time->format('F j, Y g:i a')."(IST)";
                                } else {
                                    echo 'Invalid date format'; // Handle parsing errors
                                }
                            } else {
                                echo 'No start time provided'; // Handle empty date
                            }
                            ?></span> <span>VENUE: <?php echo get_field('book_status') ?></span>
                    </div>

                    <br>
                    <?php the_content(); ?>
                </div>

 </div>
                <!-- Upcoming Workshop -->
                <?php include 'components/upcomingworkshop.php'; ?>
                <!-- Discover -->
                <!-- Discover -->
                <div class="recentplacement recentarrow wow fadeInLeft">
                    <h2>Discover successful alumni who had the same profile as you before joining Scaler</h2>
                    <div class="owl-carousel featured-course owl-loaded owl-drag">
                     <?php
$args = array(
    'post_type' => 'placements', // Ensure we are querying the 'placements' post type
    'posts_per_page' => -1 // Get all posts
);

$query = new WP_Query($args);

if ($query->have_posts()):
    while ($query->have_posts()): $query->the_post();
       
                ?>
               <?php get_template_part('template-parts/single', 'placements');  ?>
                <?php
       
    endwhile;
    wp_reset_postdata();
endif;
?>

                    </div>

                </div>
           
        </div>
    </div>
</div>

 <script>
    document.addEventListener("DOMContentLoaded", function() {
      // Get the target div and topfixed elements
      const targetDiv = document.getElementById("divh");
      const topfixed = document.getElementById("topfixed");

      // Calculate target height
      const targetHeight = targetDiv.clientHeight;

      // Set the height of topfixed
      topfixed.style.height = `${targetHeight + 500}px`;
    });
</script>

<?php 
include 'components/faq.php';
?>
</div>
<?php
get_footer();
