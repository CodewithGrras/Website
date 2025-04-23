<!doctype html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="<?php bloginfo('charset'); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title><?php wp_title(''); 
   $header_ads_banner = get_field('header_ads_banner','option');
  ?></title>
<link rel='stylesheet' href='<?php echo get_stylesheet_directory_uri();?>/css/bootstrap.min.css' media='all' /><link rel='stylesheet' href='<?php echo get_stylesheet_directory_uri();?>/css/owl.carousel.min.css' media='all' /><link rel='stylesheet' href='<?php echo get_stylesheet_directory_uri();?>/css/animate.css' media='all' /><link rel='stylesheet' href='<?php echo get_stylesheet_directory_uri();?>/css/style-new.css' media='all' /><link rel='stylesheet' href='https://fonts.googleapis.com/css2?family=Merriweather:wght@400;700;900&#038;family=Poppins:wght@300;400;500;600;700&#038;display=swap' media='all' />
  <?php wp_head(); // This is where scripts and styles are enqueued 
  ?>

</head>

<body <?php body_class(); ?>>

  <!-- header -->
  
  <?php


// Get the term object for 'top-choices'
$top_choices_term = get_term_by('slug', 'top-choices', 'course_types');

// Get the terms, excluding 'top-choices' using its term ID
$terms = get_terms(array(
    'taxonomy' => 'course_types',
    'hide_empty' => true, // Change to true if you want to hide empty terms
    'exclude' => $top_choices_term ? $top_choices_term->term_id : null, // Exclude 'top-choices' term by ID
));

?>

  <div class="header wow fadeInUp d-none d-sm-block">
    <nav class="navbar navbar-expand-lg">
      <div class="container">
        <a class="navbar-brand logo" href="<?php echo get_site_url(); ?>"><img src="<?php echo get_stylesheet_directory_uri() ?>/images/logo.png" class="img-fluid" alt=""></a>
        <form class="d-flex" role="search">
          <div class="megamenu">
            <a class="btn btn-primary" data-bs-toggle="collapse" data-bs-backdrop="true" href="#collapseCourseMenu" role="button" aria-expanded="false" aria-controls="collapseCourseMenu"> Courses </a>
            <div class="collapse menuopen" id="collapseCourseMenu" sytle="position: fixed; top: 0px;">
              <div class="card">
                <div class="row">
                  <div class="col-lg-3">
                    <div class="brows">Browse by Domains</div>
                    <ul class="nav nav-pills" id="pills-tab" role="tablist">
                      <?php
                      // Check if there are terms to display
                      if (!empty($terms) && !is_wp_error($terms)) {
                        $i = 0;
                        foreach ($terms as $term) {
                          $i++;

                      ?>
                          <li class="nav-item" role="presentation">
                            <a href="#" class="<?php echo ($i == 1 ? "active" : '') ?>" id="pills-<?php echo $term->slug ?>-tab" data-bs-toggle="pill" data-bs-target="#pills-<?php echo $term->slug ?>" role="tab" aria-controls="pills-<?php echo $term->slug ?>" aria-selected="<?php echo ($i == 1 ? "true" : 'false') ?>"><?php echo esc_html($term->name) ?></a>
                          </li>
                      <?php

                        }
                      } else {
                        echo 'No categories found.';
                      }
                      ?>

                    </ul>
                  </div>
                  <div class="col-lg-6">
                    <div class="tab-content" id="pills-tabContent">
                      <?php
                      if ($terms && !is_wp_error($terms)) {
                        $term_names = []; // Initialize an array to hold term names
                        $i = 0;

                        foreach ($terms as $term) {
                          $i++;
                      ?>
                          <div class="tab-pane fade show <?php echo ($i == 1 ? 'active' : ''); ?>" id="pills-<?php echo $term->slug ?>" role="tabpanel" aria-labelledby="pills-<?php echo $term->slug ?>-tab" tabindex="0">
                            <h3><?php echo esc_html($term->name) ?></h3>
                            <div class="row">
                              <?php
                              // Custom query to get 'career_success_story' posts with 'story_types' term 'rating-page'
                              $args = array(
                                'post_type' => 'courses',
                                'hide_empty' => true,

                                'tax_query' => array(
                                           array(
            'taxonomy' => 'city', // The taxonomy name
            'field'    => 'term_id', // You can use 'slug' if needed
            'terms'    => get_terms(array( // Fetch all terms in the 'city' taxonomy
                'taxonomy' => 'city',
                'fields'   => 'ids',
            )),
            'operator' => 'NOT IN', // Exclude all terms in the taxonomy
        ),
                                  array(
                                    'taxonomy' => 'course_types',
                                    'field'    => 'slug',
                                    'terms'    => $term->slug,
                                  ),

                                ),
                              );

                              // Create a new query
                              $custom_query = new WP_Query($args);
                              if ($custom_query->have_posts()) {


                                // Loop through the posts
                                while ($custom_query->have_posts()) {
                                  $custom_query->the_post();
                      $course_terms = get_the_terms(get_the_ID(), 'course_types');
             $term_names = [];    
            if ($course_terms) {
              foreach ($course_terms as $term) {
                $term_classes .= ' ' . esc_attr($term->slug);
                $term_names[] = $term->name;    
              }
            }
            ?>
                                  <div class="col-lg-6">

             <a href="<?php the_permalink(); ?>">
             <div class="cobox">
                    <div class="imgbox">
                      <img src="<?php echo get_field('mobile_background_image')?>" class="img-fluid bigimg" alt="">
                      <div class="imgcontent">
                        <div class="icon"><img src="<?php the_post_thumbnail_url(); ?>" class="img-fluid" alt=""></div>
                      </div>
                      <?php if (get_field('discount')) : ?>
                          <div class="offer"><?php echo get_field('discount'); ?><span>%</span> OFF</div>               
                        <?php endif; ?>
                    </div>
                    <div class="right-content">
                      <div class="<?php echo get_field('best_seller_color'); ?>"><?php echo get_field('best_seller'); ?></div>
                      <h4> <small><?php echo $term_names[0]?></small><br><?php the_title(); ?></h4>
<?php the_content()?>
                      <div class="content">
                        <div class="row">
                          <div class="col-md-7 col-7">
                            <div class="star">
                                <?php 
                                $rating = get_field('rating');
                                for($i = 1; $i <= $rating; $i++){
?>
                                <span class="star star-enabled">★</span>
<?php
                                }
                                ?>

                                &nbsp; <?php echo $rating?>/5 <span>(<?php echo get_field('review_count')?>)</span>
                              </div>
                          </div>
                          <div class="col-md-5 col-5">
                            <div class="day"><img src="<?php echo get_stylesheet_directory_uri() ?>/images/days.svg" alt=""> <?php echo get_field('days'); ?> Day</div>
                          </div>
                        </div>
                      </div>              
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

                      <?php
                        }
                      }

                      ?>


                    </div>
                  </div>
                  <div class="col-lg-3">
                 <div class="addbox">
                      <h3><?php
                      echo $header_ads_banner['title'];
                      ?></h3>
                      <p><?php echo $header_ads_banner['sub_title'];?></p>
                      <img src="<?php echo $header_ads_banner['image'];?>" class="img-fluid" alt="">
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="input-group desk-search">
            <input type="text" id="search-input" class="form-control" placeholder="What do you want to learn?" aria-label="Search">
            <button type="button" id="search-button">
                <img src="<?php echo get_stylesheet_directory_uri() ?>/images/btn-search.svg" alt="">
            </button>

             <!-- This will display the search results -->
            <div id="search-results"></div>
          </div>
        
        </form>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <?php
            // Get the menu items for the 'primary' menu
            $menu_name = 'primary-menu'; // This should match your registered menu location
            $locations = get_nav_menu_locations();
            $menu_id = $locations[$menu_name];
            $menu_items = wp_get_nav_menu_items($menu_id);

            // Check if the menu items were retrieved
            if ($menu_items) {

              foreach ($menu_items as $item) {
                // Display each item
                echo '<li class="nav-item">';
                echo '<a class="nav-link" href="' . esc_url($item->url) . '">' . esc_html($item->title) . '</a>';
                echo '</li>';
              }
            } else {
              echo '<p>No menu items found.</p>';
            }
            ?>


            <li class="nav-item"> 
            <a class="btn btn-primary" href="<?php  get_link_custom("Placement Support"); ?>">Placement</a> </li>
          </ul>
        </div>
      </div>
    </nav>
  </div>
  <div class="header wow fadeInUp d-block d-sm-none">
        <style>
  .modal-header-1 {
    border-bottom: 1px solid #dee2e6;
    /* Optional separator */
    /* padding: 1rem; */
    /* Adjust padding if needed */
    padding: 10px;
    margin-left: 10px;
    margin-right: 10px;
    background-color: #ffead4;

  }

  .modal-header-secondary-1 {
    margin-top: 7%;
  }

  .modal-header-1 button {
    font-size: 1rem;
    font-weight: bold;
    color: #007bff;
  }

  .modal-header-1 button:hover {
    text-decoration: underline;
    /* Highlight on hover */
  }

  .model-header-button-1 {
    border: none;
    background-color: transparent;
    color: black !important;
    font-size: 15px !important;
  }

  .model-header-heading-1 {
    margin: 0;
  }

  .modal-dialog-1 {
    margin: 0 !important;
    background-color: white !important;
    border: none !important;
    height: 100vh;
  }

  .modal-content-1 {
    border: none;

  }

  .modal-backdrop-1 {
    display: none !important;
  }

  #customModal {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.5);
  }

  #customModal-dialoge {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    background: white;
    border-radius: 8px;
    width: 100vw;
    height: 100vh;
    text-align: center;
  }
</style>

  <nav class="navbar navbar-expand-lg">
    <div class="container">
      <a class="navbar-brand logo" href="/"><img src="<?php echo get_stylesheet_directory_uri() ?>/images/logo.png" class="img-fluid" alt=""></a>
      <form class="d-flex" role="search">
        <div class="megamenu">
          <a class="btn btn-primary" data-bs-toggle="collapse" href="#collapseExample222" role="button"
            aria-expanded="false" aria-controls="collapseExample"> Courses </a>
          <div class="collapse menuopen" id="collapseExample222" style="    position: fixed;
    top: 0px;">
            <div class="card">
              <div class="row">
                <div class="col-lg-3">
                  <div class="brows"><!-- Custom Header -->
                    <div class="modal-header modal-header-1  d-flex justify-content-between align-items-center">
                      <!-- Back Button -->
                      <button type="button" class="model-header-button model-header-button-1"
                        onclick="handleBackButton('collapseExample222', null)" aria-label="Back">
                          <img src="<?php echo get_stylesheet_directory_uri() ?>/images/Group 48097106.svg"/>
                        </button>
                          <h5 class="model-header-heading model-header-heading-1">Courses</h5>
                          <!-- Close Button -->
                          <button type="button" class="model-header-button model-header-button-1" onclick="closeAllModals()">
                              <img src="<?php echo get_stylesheet_directory_uri() ?>/images/ccccc.svg"/></button>
                    </div>
                  </div>
                  <!-- Navigation Pills -->
                  
                  <ul class="nav nav-pills" id="pills-tab" role="tablist">

                      <?php
                      // Check if there are terms to display
                      if (!empty($terms) && !is_wp_error($terms)) {
                        $i = 0;
                        foreach ($terms as $term) {
                          $i++;

                      ?>
                        <li class="nav-item" role="presentation">
                      <a class="<?php echo ($i == 1 ? "active" : '') ?>" href="#" id="pills-<?php echo $term->slug ?>-tab" data-bs-toggle="modal" data-bs-target="#dynamicModal<?php echo $term->slug ?>"
onclick="showModal('pillsdfdfs-<?php echo $term->slug?>')"
><?php echo esc_html($term->name) ?></a>
                    </li>
                          
                      <?php

                        }
                      } else {
                        echo 'No categories found.';
                      }
                      ?>

                    
                  
                 
                  </ul>


  <div class="col-lg-12">

                      <div class="addbox">
                      <h3><?php $header_ads_banner = get_field('header_ads_banner','option');
                      echo $header_ads_banner['title'];
                      ?></h3>
                      <p><?php echo $header_ads_banner['sub_title'];?></p>
                      <img src="<?php echo $header_ads_banner['image'];?>" class="img-fluid" alt="">
                    </div>      
                  </div>

                </div>

              </div>
            </div>
          </div>
          <!-- --------------- -->

          <!-- Modal -->
          <div id="customModal">
            <div id="customModal-dialoge">
              <div class="modal-header modal-header-1 modal-header-secondary modal-header-secondary-1 d-flex justify-content-between align-items-center">
                <!-- Back Button -->
                <button type="button" class="model-header-button model-header-button-1" id="secondaryModalBackButton"
                  onclick="closeModal()">
                     <img src="<?php echo get_stylesheet_directory_uri() ?>/images/Group 48097106.svg"/>
                   </button>
                    <h5 class="model-header-heading model-header-heading-1">Courses</h5>
                    <!-- Close Button -->
                    <button type="button" class="model-header-button model-header-button-1" onclick="closeAllModals()"><img src="<?php echo get_stylesheet_directory_uri() ?>/images/ccccc.svg"/></button>
                </button>
              </div>

              <div class="modal-content-secondary modal-content-secondary-1">


                <div class="modal-body" id="modalContent">
                  <!-- Dynamic content will appear here -->
                   <?php
                      if ($terms && !is_wp_error($terms)) {
                        $term_names = []; // Initialize an array to hold term names
                        $i = 0;

                        foreach ($terms as $term) {
                          $i++;
                      ?>
                          <div id="pillsdfdfs-<?php echo $term->slug ?>" style="display: none" class="hide_allmodel">
                            <h3><?php echo esc_html($term->name) ?></h3>
                            <div class="row">
                              <?php
                              // Custom query to get 'career_success_story' posts with 'story_types' term 'rating-page'
                              $args = array(
                                'post_type' => 'courses',
                                'hide_empty' => true,

                                'tax_query' => array(
                                  array(
                                    'taxonomy' => 'course_types',
                                    'field'    => 'slug',
                                    'terms'    => $term->slug,
                                  ),

                                ),
                              );

                              // Create a new query
                              $custom_query = new WP_Query($args);
                              if ($custom_query->have_posts()) {


                                // Loop through the posts
                                while ($custom_query->have_posts()) {
                                  $custom_query->the_post();
                      $course_terms = get_the_terms(get_the_ID(), 'course_types');
             $term_names = [];    
            if ($course_terms) {
              foreach ($course_terms as $term) {
                $term_classes .= ' ' . esc_attr($term->slug);
                $term_names[] = $term->name;    
              }
            }
            ?>
                                  <div class="col-lg-6">

             <a href="<?php the_permalink(); ?>">
             <div class="cobox">
                    <div class="imgbox">
                      <img src="<?php echo get_field('mobile_background_image')?>" class="img-fluid bigimg" alt="">
                      <div class="imgcontent">
                        <div class="icon"><img src="<?php the_post_thumbnail_url(); ?>" class="img-fluid" alt=""></div>
                      </div>
                      <?php if (get_field('discount')) : ?>
                          <div class="offer"><?php echo get_field('discount'); ?><span>%</span> OFF</div>               
                        <?php endif; ?>
                    </div>
                    <div class="right-content">
                      <div class="<?php echo get_field('best_seller_color'); ?>"><?php echo get_field('best_seller'); ?></div>
                      <h4> <small><?php echo $term_names[0]?></small><br><?php the_title(); ?></h4>
<?php the_content()?>
                      <div class="content">
                        <div class="row">
                          <div class="col-md-7 col-7">
                            <div class="star">
                                <?php 
                                $rating = get_field('rating');
                                for($i = 1; $i <= $rating; $i++){
?>
                                <span class="star star-enabled">★</span>
<?php
                                }
                                ?>

                                &nbsp; <?php echo $rating?>/5 <span>(<?php echo get_field('review_count')?>)</span>
                              </div>
                          </div>
                          <div class="col-md-5 col-5">
                            <div class="day"><img src="<?php echo get_stylesheet_directory_uri() ?>/images/days.svg" alt=""> <?php echo get_field('days'); ?> Day</div>
                          </div>
                        </div>
                      </div>              
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

                      <?php
                        }
                      }

                      ?>
                      <div>
                          
    <a href="course" class="btn btn-outline-primary" style="width: auto">Explore All Courses</a>
                      </div>

                </div>
                <!-- <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
              </div> -->
              </div>
            </div>
          </div>
          <!-- JavaScript -->
          <script>
function showModal(modelid) {

document.getElementsByClassName("navbar-toggler-icon")[0].style.display = "none"
document.getElementById("button-addon2").style.display = "none";
const elements = document.querySelectorAll('.hide_allmodel');

elements.forEach(element => {
    element.style.display = 'none';
});

document.getElementById(modelid).style.display = "block";
document.getElementsByClassName("input-group")[0].style.display = "none";
  // Hide the collapse content properly
  const collapse = document.getElementById('collapseExample222');
  if (collapse.classList.contains("show")) {
      let collapseInstance = bootstrap.Collapse.getInstance(collapse);
      if (collapseInstance) {
          collapseInstance.hide();
      }
  }

  // Show the modal
  const modal = document.getElementById('customModal');
  if (modal) {
      modal.style.display = 'block'; // Show modal
  }
}

function closeModal() {
  // Hide the modal
  const modal = document.getElementById('customModal');
  if (modal) {
      modal.style.display = 'none'; // Hide modal
  }

  // Show the collapse content properly
  const collapse = document.getElementById('collapseExample222');
  let collapseInstance = bootstrap.Collapse.getInstance(collapse);
  if (!collapseInstance) {
      collapseInstance = new bootstrap.Collapse(collapse, { toggle: false });
  }
  collapseInstance.show();
  document.getElementsByClassName("navbar-toggler-icon")[0].style.display = "block"
document.getElementById("button-addon2").style.display = "block";
document.getElementsByClassName("input-group")[0].style.display = "back";
}

function handleBackButton(currentModalId) {
  console.log("Back Button Clicked");

  const collapse = document.getElementById('collapseExample222');

  if (collapse.classList.contains("show")) {
      console.log("Collapse is Visible, Hiding Now...");

      // Collapse ko hide karo
      let collapseInstance = bootstrap.Collapse.getInstance(collapse);
      if (collapseInstance) {
          collapseInstance.hide();
      }

      console.log("Collapse Hidden and Reset");

      // **🔴 Important:** Reinitialize after some delay
      setTimeout(() => {
          console.log("Reinitializing Collapse...");
          new bootstrap.Collapse(collapse, { toggle: false });
      }, 100); // 🔥 Delay ensures Bootstrap initializes properly

  } else {
      console.log("Navigating Back in History");
      window.history.back();
  }
}

function showModalContent(courseName) {
  // Ensure collapseExample222 is closed
  
  const collapseExample222 = document.getElementById('collapseExample222');
  let collapseInstance = bootstrap.Collapse.getInstance(collapseExample222);

  if (collapseInstance) {
      collapseInstance.hide();
  }

  // Show dynamicModal
  const dynamicModal = new bootstrap.Modal(document.getElementById('dynamicModal'), {
      backdrop: 'static', // Prevent background click from closing modal
      keyboard: false, // Prevent ESC from closing modal
  });

  dynamicModal.show();
}

function closeDynamicModal() {
  console.log("Hello");

  const dynamicModal = bootstrap.Modal.getInstance(document.getElementById('dynamicModal'));
  if (dynamicModal) {
      dynamicModal.hide();
  }

  // Reopen collapseExample222 properly
  const collapseExample222 = document.getElementById('collapseExample222');
  let collapseInstance = bootstrap.Collapse.getInstance(collapseExample222);
  if (!collapseInstance) {
      collapseInstance = new bootstrap.Collapse(collapseExample222, { toggle: false });
  }
  collapseInstance.show();
}

function closeAllModals() {
const modal = document.getElementById('customModal');
  if (modal) {
      modal.style.display = 'none'; // Hide modal
  }
  document.getElementsByClassName("navbar-toggler-icon")[0].style.display = "block"
document.getElementById("button-addon2").style.display = "block";
document.getElementsByClassName("input-group")[0].style.display = "block";
  // Close collapseExample222 if open
  const collapseExample222 = document.getElementById('collapseExample222');
  let collapseInstance = bootstrap.Collapse.getInstance(collapseExample222);
  if (collapseInstance) {
      collapseInstance.hide();
  }

  // Close dynamicModal if open
  const dynamicModal = bootstrap.Modal.getInstance(document.getElementById('dynamicModal'));
  if (dynamicModal) {
      dynamicModal.hide();
  }
}


          </script>




          <!-- ************* -->
        </div>
 <div class=" d-block d-sm-none">
            <button type="button" class="msearch" id="button-addon4" data-bs-toggle="collapse" href="#collapseExample1" role="button" aria-expanded="false" aria-controls="collapseExample1"><img src="<?php echo get_stylesheet_directory_uri() ?>/images/btn-search.svg" width="32" alt=""></button>
            <div class="collapse mobile-search" id="collapseExample1">
              <div class="card card-body">
                <div class="input-group">
                  <input type="text" id="mobile-search"class="form-control" placeholder="What do you want to learn?" aria-label="Recipient's username" aria-describedby="button-addon4">
                  <button type="button" id="button-addon2"><img src="<?php echo get_stylesheet_directory_uri() ?>/images/btn-search.svg" width="32" alt=""></button>
                  <button type="button" id="button-addon3"><img src="<?php echo get_stylesheet_directory_uri() ?>/images/ccccc.svg" alt=""></button>
                </div>
              </div>
            </div>
          </div>
        </form>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <?php
            // Get the menu items for the 'primary' menu
            $menu_name = 'primary-menu'; // This should match your registered menu location
            $locations = get_nav_menu_locations();
            $menu_id = $locations[$menu_name];
            $menu_items = wp_get_nav_menu_items($menu_id);

            // Check if the menu items were retrieved
            if ($menu_items) {

              foreach ($menu_items as $item) {
                // Display each item
                echo '<li class="nav-item">';
                echo '<a class="nav-link" href="' . esc_url($item->url) . '">' . esc_html($item->title) . '</a>';
                echo '</li>';
              }
            } else {
              echo '<p>No menu items found.</p>';
            }
            ?>


            <li class="nav-item"> 
            <a class="btn btn-primary" href="<?php  get_link_custom("Placement Support"); ?>">Placement</a> </li>
          </ul>
        </div>
    </div>
  </nav>
  </div>

      <script>
        document.getElementById('button-addon3').addEventListener('click', function() {
            document.getElementById('collapseExample1').classList.remove('show');
        });
    </script>
  <style>
  .gform-theme--framework .gform_validation_errors {

    display: none!important;
    
}
      div#gform_1_validation_container {
    display: none;
}
  </style>