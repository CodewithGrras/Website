<div class="voice">
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

    <div class="container">
        <h2 class="text-center"><?php echo the_field('voices_of_trust_title') ?></h2>

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

        <div class="isocontent grid">
            <div class="row">
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

                                <div class="col-lg-4 col-md-6 col-sm-6 single-content grid-item <?php echo $term_string ?>">
                          
                            <div class="voicebox">
                                <div class="voicecontent">
                                    <div class="vioceimg"><img src="<?php the_post_thumbnail_url() ?>" class="img-fluid" alt=""></div>
                                    <div class="voicetitle">
                                        <h4><?php the_title(); ?></h4>
                                        <div class="special"><?php echo the_field('post_designation'); ?></div>
                                        <div class="location"><?php echo the_field('location'); ?></div>
                                    </div>
                                    <div class="clearfix">
                                    </div>
                                    <p><?php the_excerpt() ?></p>
                                    <a href="#" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar-<?php echo $i ?>"  aria-controls="offcanvasNavbar-<?php echo $i ?>" aria-label="Toggle navigation" class="playbar">Click to know more about <?php echo wp_trim_words(get_the_title(), 1) ?></a>
                                </div>
                                <hr>
                                <div class="text-right"><a href="#" class="readstory navbar-toggler" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar-<?php echo $i ?>"  aria-controls="offcanvasNavbar-<?php echo $i ?>" aria-label="Toggle navigation">Read full story</a></div>
                            </div>
                                </div>
                                <!-- form popup -->
                                <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar-<?php echo $i ?>" aria-labelledby="offcanvasNavbar-<?php echo $i ?>Label">
                                    <div class="offcanvas-body">
                                        <div class="reviewpop">
                                            <div class="reviewimg"><img src="<?php the_post_thumbnail_url() ?>" class="img-fluid" alt=""></div>
                                            <div class="reviewcont">
                                                <h3><?php the_title(); ?></h3>
                                                <div class="degi"><?php echo the_field('post_designation'); ?></div>
                                                <div class="backend"></div>
                                                <div class="location"><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/marker.png" alt=""><?php echo the_field('location'); ?></div>
                                                <div class="uni"><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/home.png" alt=""> <?php echo the_field('university'); ?></div>
                                                <div class="edu"><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/cap.png" alt=""> <?php echo the_field('degree'); ?></div>
                                                <div class="exp"><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/case.png" alt=""> <?php echo the_field('experience_line'); ?></div>
                                            </div>
                                            <div class="clearfix"></div>
                                            <ul class="pregrass">
                                                
                                               <?php if( have_rows('pre_post_grass') ): ?>

        <?php while( have_rows('pre_post_grass') ): the_row(); 
            // Get the sub fields
            $title = get_sub_field('title'); 
            $logo = get_sub_field('logo'); 
            $post_content = get_sub_field('post'); 
        ?>
            <li>
                <p><?php echo esc_html($title); ?></p>
                <?php if($logo): ?>
                    <img src="<?php echo esc_url($logo); ?>" class="img-fluid" >
                <?php endif; ?>
                <p><?php echo esc_html($post_content); ?></p>
            </li>
        <?php endwhile; ?>
    
<?php else: ?>
    <p>No entries found.</p>
<?php endif; ?>

                                            </ul>
                                            <div class="salary">
                                                <span><?php echo the_field('salary_hike_line'); ?></span>
                                            </div>
                                            <ul class="share">
                                                <li>
<a href="javascript:void(0)" onclick="navigator.share({ url: window.location.pathname + '?offcanvasNavbar=<?php echo $i; ?>' })">


                                                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/share.png" class="img-fluid" alt=""> Share Profile
                                                    </li>
</a>
                                                <li>
  <a href="<?php echo get_field('linkedin_url'); ?>" target="_blank">
                                                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/linkin.png" class="img-fluid" alt=""> Linkedin
</a>
                                                    </li>
                                            </ul>
                                            <h4>Reviews and Blogs</h4>
                                            <div class="subtext"><?php the_content() ?></div>
                                            <div class="linkd">
                                                
  <a href="<?php echo get_field('read_review_on_linkedin_url'); ?>" target="_blank"> 
                                                <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/inreview.png" alt=""> Read review on Linkedin</div>
  </a>
                                            <h4>Reviews by Madhav Singh on <span>YouTube</span></h4>
                                           
              <iframe width="100%" height="270px" src="<?php echo get_field('video_link'); ?>" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen=""></iframe>
     
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
</div>
<script>
    // Function to get the value of a query parameter by name
function getParameterByName(name, url = window.location.href) {
    name = name.replace(/[

\[\]

]/g, '\\$&');
    var regex = new RegExp('[?&]' + name + '(=([^&#]*)|&|#|$)'),
        results = regex.exec(url);
    if (!results) return null;
    if (!results[2]) return '';
    return decodeURIComponent(results[2].replace(/\+/g, ' '));
}

// Get the 'offcanvasNavbar' parameter from the URL
var offcanvasNavbar = getParameterByName('offcanvasNavbar');

// Log the value to the console
let showModel = document.getElementById('offcanvasNavbar-'+offcanvasNavbar)

showModel.classList.add('show');
showModel.style.visibility = 'visible';


</script>