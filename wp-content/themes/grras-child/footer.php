
<?php
include 'components/enquire-now.php';
include 'components/download-brochure.php';
?>



<script src="https://unpkg.com/@dotlottie/player-component@2.7.12/dist/dotlottie-player.mjs" type="module"></script>
<!-- Thank you -->




<script>

 var closeBtn = document.getElementById('close-btnsh');
            if (closeBtn) {
                closeBtn.addEventListener('click', function() {
                    exampleModal3sd.classList.remove('show');
                    exampleModal3sd.style.display = 'none';
                });
            }

    jQuery(document).ready(function($) {
        // Trigger search when the button is clicked
        $('#search-button').on('click', function() {
            let searchinput = $('#search-input').val();
          
            return window.location.href = '/search?q=' + encodeURIComponent(searchinput);
        });

        // Trigger search when Enter key is pressed
        $('#search-input').on('keypress', function(e) {
            if (e.which === 13) { // 13 is the Enter key code
                let searchinput = $('#search-input').val();
                return window.location.href = '/search?q=' + encodeURIComponent(searchinput);
            }
        });
    });
    jQuery(document).ready(function($) {
        // Trigger search when the button is clicked
        $('#button-addon2').on('click', function() {
            let searchinput = $('#mobile-search').val();
          
            return window.location.href = '/search?q=' + encodeURIComponent(searchinput);
        });

        // Trigger search when Enter key is pressed
        $('#search-input').on('keypress', function(e) {
            if (e.which === 13) { // 13 is the Enter key code
                let searchinput = $('#search-input').val();
                return window.location.href = '/search?q=' + encodeURIComponent(searchinput);
            }
        });
    });
</script>
<script>
function hideProShow(name, btn_name) {
    const exploreBtns = document.getElementById(btn_name); // Corrected 'getElementsById' to 'getElementById'
    const custom_contant = document.getElementById(name); // Corrected 'getElementsById' to 'getElementById'
    
    if (custom_contant.style.display === '-webkit-box') { // Corrected the comparison operator to '==='
        custom_contant.style.display = 'block';
        exploreBtns.textContent = 'Show Less';
    } else {
        custom_contant.style.display = '-webkit-box'; // Fixed the unclosed quote in '-webkit-box'
        exploreBtns.textContent = 'Read More';
    }
}

  document.addEventListener("DOMContentLoaded", function() {
    const exploreBtns = document.getElementsByClassName('hide_custom');
    const contents = document.getElementsByClassName('custom_contant');

    // Iterate over all buttons and add click event listeners
    for (let i = 0; i < contents.length; i++) {
        exploreBtns[i].addEventListener('click', function(e) {
      
            e.preventDefault();
            if (contents[i].style.display == '-webkit-box') {
                contents[i].style.display = 'block';
                exploreBtns[i].textContent = 'Show Less';
            } else {
                contents[i].style.display = '-webkit-box';
                      <?php if (is_page('home')): ?>
            exploreBtns[i].textContent = 'Read More';
        <?php else: ?>
            exploreBtns[i].textContent = 'Read More';
        <?php endif; ?>
            }
        });
    }
});
  document.addEventListener("DOMContentLoaded", function() {
    const exploreBtns = document.getElementsByClassName('placement_show');
    const contents = document.getElementsByClassName('placement_contant');
    // Iterate over all buttons and add click event listeners
    for (let i = 0; i < contents.length; i++) {
        exploreBtns[i].addEventListener('click', function(e) {

            e.preventDefault();
            if (contents[i].style.display === '-webkit-box') {
                contents[i].style.display = 'block !important';
                exploreBtns[i].textContent = 'Show Less';
            } else {
                contents[i].style.display = '-webkit-box';
                exploreBtns[i].textContent = 'Explore';
            }
        });
    }
});
// for the show more 
function showItems(button, mainRow,rowContainerClass, countClass) {
    document.getElementById(button).addEventListener('click', function() {
        // Get the row container
        var rowContainer = document.querySelector(mainRow);
       
        // Count the number of divs inside the row
        var divCount = rowContainer.querySelectorAll(rowContainerClass).length;
        // Display the count
        document.getElementById(countClass).textContent = '';
        // alert('Number of divs: ' + divCount);
    });
}
function showDefault(button,courseItem ,mainRow,rowContainerClass, countClass, showCount){
     var courseViewButton = document.getElementById(button);
  var courseItems = document.querySelectorAll(courseItem);
  var rowContainer = document.querySelector(mainRow);
  var itemsToShow = showCount;
  var divCount = rowContainer.querySelectorAll(rowContainerClass).length - showCount;
        // Display the count

if(divCount <= 0){
    courseViewButton.style.display = 'none'
}
  // Hide items beyond the initial display count
  courseItems.forEach(function(item, index) {
    if (index >= itemsToShow) {
      item.style.display = 'none';
    }
  });

  courseViewButton.addEventListener('click', function(e) {
    e.preventDefault();
    courseItems.forEach(function(item) {

      item.style.display = 'block';
          jQuery(document).ready(function($) {
              $('.grid').isotope({
  itemSelector: '.grid-item',
});
          });
    });
    if(courseViewButton.textContent == 'Show Less'){
    courseViewButton.textContent = 'Show More';
      // Hide items beyond the initial display count
  courseItems.forEach(function(item, index) {
    if (index >= itemsToShow) {
      item.style.display = 'none';
    }
  });
    }else{
    courseViewButton.textContent = 'Show Less'; 
    }
        document.getElementById(countClass).textContent = divCount + ' more programs available';
  }); 
}

</script>

    <div class="modal fade" id="exampleModal2" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog reqcallback">
        <div class="modal-content">
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          <div class="modal-body">
            <div class="row">
              <div class="col-lg-6">
                <div class="imgbox"><img src="<?php 
                $request_call_back_images = get_field('request_call_back_images','option');
                echo $request_call_back_images['desktop_image']; ?>" class="img-fluid d-none d-lg-block" alt=""></div>
                <div class="imgbox"><img src="<?php echo $request_call_back_images['mobile_image']; ?>" class="img-fluid d-block d-lg-none" alt=""></div>
              </div>
              <div class="col-lg-6">
              <div class="formbox">
                  <h3>Talk to Our Advisor!</h3>
                  <?php echo do_shortcode('[gravityform id="17" title="false" ajax="true"]'); ?>
              </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
<!--<div class="chetimg"><img src="<?php echo get_stylesheet_directory_uri() ?>/images/talk.png" class="img-fluid" alt=""></div>-->
<div class="footerfix">

      <div class="container d-none d-md-block"> 
        <strong>Need Help?</strong> Talk to us at +91 90019 97178 or <a href="#" class="callback" data-bs-toggle="modal" data-bs-target="#exampleModal2">REQUEST CALLBACK</a> 
      </div>
        <div class="container d-block d-md-none">
          <div class="btn-group">
          <button type="button" class="btn btn-talk dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
            <img src="<?php echo get_stylesheet_directory_uri();?>/images/talktous.svg" alt="">  Talk to us
          </button>
          <div class="dropdown-menu">
            <li><a class="dropdown-item" href="#"><img src="<?php echo get_stylesheet_directory_uri();?>/images/wp.svg" alt="">  Whatsapp us</a></li>
            <li><a class="dropdown-item" href="#"><img src="<?php echo get_stylesheet_directory_uri();?>/images/callus.svg" alt="">  Call us</a></li>
          </div>
        </div>
        <a href="#" class="btn btn-enquire" data-bs-toggle="modal" data-bs-target="#exampleModal2"><img src="<?php echo get_stylesheet_directory_uri();?>/images/chat-icon.svg" alt=""> Enquire Now</a>
      </div>
    </div>
   
<div class="footer wow fadeInUp">
<?php
include 'components/city-footer.php';
include 'components/city-footer-courses.php';
?>
      <div class="container">
        <div class="row">
          <div class="col-md-2">
            <div class="footlogo"><img src="<?php echo get_stylesheet_directory_uri() ?>/images/footer-logo.png" class="img-fluid" alt=""></div>
            <ul class="social">
              <li><a href="#"><img src="<?php echo get_stylesheet_directory_uri() ?>/images/facebook.svg" alt=""></a></li>
              <li><a href="#"><img src="<?php echo get_stylesheet_directory_uri() ?>/images/twtter.svg" alt=""></a></li>
              <li><a href="#"><img src="<?php echo get_stylesheet_directory_uri() ?>/images/linkedin.svg" alt=""></a></li>
              <li><a href="#"><img src="<?php echo get_stylesheet_directory_uri() ?>/images/instagram.svg" alt=""></a></li>
              <li><a href="#"><img src="<?php echo get_stylesheet_directory_uri() ?>/images/youtube.svg" alt=""></a></li>
            </ul>
            <!--<h5>Quora Reivew</h5>-->
            <!--<div class="mb-3"><img src="<?php echo get_stylesheet_directory_uri() ?>/images/quote-review.png" class="img-fluid" alt=""></div>-->
            <div class="mb-3"><img src="<?php echo get_stylesheet_directory_uri() ?>/images/google-review.png" class="img-fluid" alt=""></div>
          </div>
          <div class="col-md-10">
            <div class="row">
      <?php 
    // Predefined parent menu items
    $menus = [
        'Popular Courses' => 'popular-courses',
        'Internship Courses' => 'internship-courses',
        'Career Oriented Courses' => 'career-oriented-courses',
        'Popular Workshops' => 'popular-workshops',
    ];
            $i=0;

    foreach ($menus as $title => $slug) :
        // Get all menu items (parent + children) for each menu
        $menu_items = wp_get_nav_menu_items('Footer Menu');  // Use the name of the registered menu here

        // Filter the parent item
        $parent_item = null;
        foreach ($menu_items as $item) {
            if ($item->title === $title) {
                $parent_item = $item;
                break;  // Found the parent item
            }
        }

        if ($parent_item) {
            // Now filter out the child items for this parent item
            $children = [];
            foreach ($menu_items as $item) {
                if ($item->menu_item_parent == $parent_item->ID) {  // Child items have menu_item_parent set to the parent's ID
                    $children[] = $item;
                }
            }

            // If there are child items, display them
            if (!empty($children)) :
?>
    <div class="col-md-3 col-sm-6 d-none d-sm-block">
        <h4><?php echo esc_html($title); ?></h4>
        <ul class="footmenu">
            <?php
            // Loop through child items and display them
            foreach ($children as $child) :
                // Output the child item
                ?>
                <li><a href="<?php echo esc_url($child->url); ?>"><?php echo esc_html($child->title); ?></a></li>
                <?php
            endforeach;
            ?>
        </ul>
    </div>
     <div class="accordion d-block d-sm-none" id="accordionExample">
              <div class="accordion-item">
                <h4 class="accordion-header">
                  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse<?php echo $i ?>" aria-expanded="false" aria-controls="collapse<?php echo $i ?>">
                    <?php echo esc_html($title); ?>
                  </button>
                </h4>
                <div id="collapse<?php echo $i;
                $i++;
                ?>" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                  <div class="accordion-body">
                    <ul class="footmenu">
                      <?php
            // Loop through child items and display them
            foreach ($children as $child) :
                // Output the child item
                ?>
                <li><a href="<?php echo esc_url($child->url); ?>"><?php echo esc_html($child->title); ?></a></li>
                <?php
            endforeach;
            ?>
                    </ul>
                  </div>
                </div>
              </div>
             
            </div>
<?php 
            endif; // End check for children
        }
    endforeach;
?>

    </div>         
          </div>
          
          
        </div>

        <!-- copyright -->
        <div class="copyright">
          <div class="row">
            <div class="col-lg-10">
              <ul>
                <li><a href="<?php get_link_custom('aboutus') ?>">About Us</a></li>
                <li><a href="<?php get_link_custom('hire-from-us') ?>">Hire From Us</a></li>
                <li><a href="<?php get_link_custom('careers') ?>">Careers</a></li>
                <!--<li><a href="<?php get_link_custom('blog') ?>">Become a Mentor</a></li>-->
                <li><a href="<?php get_link_custom('blog') ?>">Blogs</a></li>
                <li><a href="<?php get_link_custom('review-rating') ?>">Sucess Stories</a></li>
                <li><a href="<?php get_link_custom('contact-us') ?>">Contact Us</a></li>
                <li><a href="/gallery">Gallery</a></li>
              </ul>
              <p>Copyright © <?php echo date('Y'); ?> GRRAS Solutions Pvt. Ltd.</p>
            </div>
            <div class="col-lg-2">
              <!--<div class="mt-4 text-right"><img src="<?php echo get_stylesheet_directory_uri() ?>/images/qrcode.png" class="img-fluid" alt=""></div>-->
            </div>
          </div>
        </div>
      </div>
    </div>


<?php wp_footer(); ?>
<script>
      wow = new WOW(
        {
          animateClass: 'animated',
          offset:       100,
          callback:     function(box) {
            console.log("WOW: animating <" + box.tagName.toLowerCase() + ">")
          }
        }
      );
      wow.init();
      console.log(typeof jQuery); // This should log "function"

    </script><?php if(!is_home() || !is_front_page()): ?>
    <script type="text/javascript">
  /*document.getElementById('workshop-filter').addEventListener('change', function() {
    var filterValue = this.value; // Get selected value
 
    // Get the current URL and add the selected filter as a query parameter
    var url = new URL(window.location.href);
    url.searchParams.set('workshop_filter', filterValue); // Add filter to the URL
    window.location.href = url; // Redirect to the updated URL
  });*/
//   document.getElementById('loader-workshop').addEventListener('click', function() {
    

//     var url = new URL(window.location.href);
//     url.searchParams.set('loader', true); // Add filter to the URL
//     window.location.href = url; // Redirect to the updated URL
//   });
  function placement_viewmore() {
    var url = new URL(window.location.href);
    url.searchParams.set('loader', true); // Add filter to the URL
    window.location.href = url; // Redirect to the updated URL
  }
  function gallary_loader() {
    var url = new URL(window.location.href);
    url.searchParams.set('loader', 1000); // Add filter to the URL
    window.location.href = url; // Redirect to the updated URL
  }
</script><?php endif; ?>


    <!--featured-course -->
    <script>      
    jQuery(document).ready(function($) {
        
        
      $('.review-slid').owlCarousel({
        items: 4,
        autoplay: true,
        margin: 0,
        nav: false,
        dots: false,
        loop: true,
        smartSpeed: 450,
        navText : ["<img src='<?php echo get_stylesheet_directory_uri();?>/images/fe-arrow-left.png' class='fa-flip-horizontal' alt=''>","<img src='<?php echo get_stylesheet_directory_uri();?>/images/fe-arrow-right.png' alt=''>"],
        responsiveClass:true,
        responsive:{
            0:{
                items:1,
            },
            500:{
                items:2,
            },
            768:{
                items:2,
            },
            1100:{
                items:2,
            },
            1400:{
                items:2,
            }
        }
      });
     
$('.custom-coursal-internship').owlCarousel({
  items: 2,
  autoplay: true,
  margin: 5,
  nav: false,
  dots: false,
  loop: true,
  smartSpeed: 450,
  slideTransition: 'linear',
  autoplaySpeed: 5000,
  navText: [
    "<img src='<?php echo get_stylesheet_directory_uri();?>/images/fe-arrow-left.png' class='fa-flip-horizontal' alt=''>",
    "<img src='<?php echo get_stylesheet_directory_uri();?>/images/fe-arrow-right.png' alt=''>"
  ],
  responsiveClass: true,
  responsive: {
    0: {
      items: 1,
    },
    500: {
      items: 2,
    }
  },
  animateOut: 'fadeOut',
  animateIn: 'fadeIn',
  onInitialized: addClasses,
  onTranslated: addClasses,
  rtl: true
});

function addClasses() {
  const items = document.querySelectorAll('.custom-coursal-internship .item');
  console.log(items.length)
  items.forEach((item, index) => {
    if (index % 2 === 0) {
      item.classList.remove('wid160');
      item.classList.add('story');
    } else {
      item.classList.remove('story');
      item.classList.add('wid160');
    }
  });
}

     
      $('.mobile-review').owlCarousel({
        items: 4,
        autoplay: true,
        margin: 0,
        nav: true,
        dots: false,
        loop: true,
        smartSpeed: 450,
        navText : ["<img src='./images/fe-arrow-left.png' class='fa-flip-horizontal' alt=''>","<img src='./images/fe-arrow-right.png' alt=''>"],
        responsiveClass:true,
        responsive:{
            0:{
                items:1.5,
            },
            500:{
                items:2,
            },
            768:{
                items:3,
            },
            1100:{
                items:4,
            },
            1400:{
                items:4,
            }
        }
      });
      
      
      $('.realimpect').owlCarousel({
        items: 4,
        autoplay: true,
        margin: 30,
        nav: true,
        dots: false,
        loop: true,
        smartSpeed: 250,
        navText : false,
        responsiveClass:true,
        responsive:{
            0:{
                items:1.2,
            },
            500:{
                items:2,
            },
            768:{
                items:3,
            },
            1100:{
                items:3,
            },
            1400:{
                items:3,
            }
        }
      });

    
  $('.success-story').owlCarousel({
        items: 3,
        autoplay: true,
        margin: 5,
        nav: true,
        dots: false,
        loop: true,
        smartSpeed: 450,

        slideTransition: 'linear',
        autoplaySpeed: 5000,
        // autoplayTimeout:1e3,
        autoplayHoverPause: false,

        navText : ["<img src='<?php echo get_stylesheet_directory_uri() ?>/images/fe-arrow-left.png' class='fa-flip-horizontal' alt=''>","<img src='<?php echo get_stylesheet_directory_uri() ?>/images/fe-arrow-right.png' alt=''>"],
        responsiveClass:true,
        responsive:{
            0:{
                items:1.5,
            },
            500:{
                items:2,
            },
            768:{
                items:3,
            },
            1100:{
                items:4,
            },
            1400:{
                items:4,
            }
        }
      });


      $('.hire-partner').owlCarousel({
        items: 4,
        autoplay: true,
        margin: 0,
        nav: true,
        dots: false,
        loop: true,
        smartSpeed: 450,
        navText : ["<img src='<?php echo get_stylesheet_directory_uri() ?>/images/fe-arrow-left.png' class='fa-flip-horizontal' alt=''>","<img src='<?php echo get_stylesheet_directory_uri() ?>/images/fe-arrow-right.png' alt=''>"],
        responsiveClass:true,
        responsive:{
            0:{
                items:1.5,
            },
            500:{
                items:2,
            },
            768:{
                items:3,
            },
            1100:{
                items:4,
            },
            1400:{
                items:4,
            }
        }
      });


      $('.partner-logo').owlCarousel({
        items: 4,
        autoplay: true,
        margin: 0,
        nav: true,
        dots: false,
        loop: true,
        smartSpeed: 450,
        navText : ["<img src='<?php echo get_stylesheet_directory_uri() ?>/images/fe-arrow-left.png' class='fa-flip-horizontal' alt=''>","<img src='<?php echo get_stylesheet_directory_uri() ?>/images/fe-arrow-right.png' alt=''>"],
        responsiveClass:true,
        responsive:{
            0:{
                items:2,
            },
            500:{
                items:3,
            },
            768:{
                items:4,
            },
            1100:{
                items:5,
            },
            1400:{
                items:6,
            }
        }
      });

   
      $('.exclusive-course').owlCarousel({
        items: 3,
        autoplay: true,
        margin: 0,
        nav: true,
        dots: false,
        loop: true,
        smartSpeed: 450,
          navText : ["<img src='<?php echo get_stylesheet_directory_uri() ?>/images/fe-arrow-left.png' class='fa-flip-horizontal' alt=''>","<img src='<?php echo get_stylesheet_directory_uri() ?>/images/fe-arrow-right.png' alt=''>"],
      responsiveClass:true,
        responsive:{
            0:{
                items:1.4,
            },
            500:{
                items:2,
            },
            768:{
                items:3,
            },
            1100:{
                items:3,
            },
            1400:{
                items:3,
            }
        }
      });

      $('.elate-slid').owlCarousel({
        items: 1,
        autoplay: true,
        margin: 0,
        nav: true,
        dots: false,
        loop: true,
        smartSpeed: 450,
        navText : ["<img src='<?php echo get_stylesheet_directory_uri() ?>/images/fe-arrow-left.png' class='fa-flip-horizontal' alt=''>","<img src='<?php echo get_stylesheet_directory_uri() ?>/images/fe-arrow-right.png' alt=''>"],
        responsiveClass:true,
        responsive:{
            0:{
                items:1,
            },
            500:{
                items:1,
            },
            768:{
                items:1,
            },
            1100:{
                items:1,
            },
            1400:{
                items:1,
            }
        }
      });

    
      $('.featured-course').owlCarousel({
        items: 4,
        autoplay: false,
        margin: 0,
        nav: true,
        dots: false,
        loop: true,
        smartSpeed: 250,
        navText : ["<img src='<?php echo get_stylesheet_directory_uri() ?>/images/fe-arrow-left.png' class='fa-flip-horizontal' alt=''>","<img src='<?php echo get_stylesheet_directory_uri() ?>/images/fe-arrow-right.png' alt=''>"],
        responsiveClass:true,
        responsive:{
            0:{
                items:1.2,
            },
            500:{
                items:2,
            },
            768:{
                items:3,
            },
            1100:{
                items:4,
            },
            1400:{
                items:4,
            }
        }
      });
      $('.our_placement').owlCarousel({
        items: 4,
        margin: 0,
        nav: true,
        dots: false,
        loop: true,
        autoplay: false,
      
        // autoplaySpeed: 5000,
        // autoplayTimeout:1e3,
        // autoplayHoverPause: false,
       navText : ["<img src='<?php echo get_stylesheet_directory_uri() ?>/images/fe-arrow-left.png' class='fa-flip-horizontal' alt=''>","<img src='<?php echo get_stylesheet_directory_uri() ?>/images/fe-arrow-right.png' alt=''>"],
        responsiveClass:true,
        responsive:{
            0:{
                items:1.5,
            },
            500:{
                items:2,
            },
            768:{
                items:4,
            },
            1100:{
                items:4,
            },
            1400:{
                items:4,
            }
        }
      });

    

  
      $('.blog-slid').owlCarousel({
        items: 4,
        autoplay: false,
        margin: 16,
        nav: true,
        dots: false,
        loop: true,
        smartSpeed: 450,
        navText : ["<img src='<?php echo get_stylesheet_directory_uri() ?>/images/fe-arrow-left.png' class='fa-flip-horizontal' alt=''>","<img src='<?php echo get_stylesheet_directory_uri() ?>/images/fe-arrow-right.png' alt=''>"],
        responsiveClass:true,
        responsive:{
            0:{
                items:2,
                margin: 6,
            },
            500:{
                items:2,
            },
            768:{
                items:3,
            },
            1100:{
                items:3,
            },
            1400:{
                items:3,
            }
        }
      });
      
      $('.award-reco').owlCarousel({
        items: 3,
        margin: 0,
        nav: true,
        dots: false,
        loop: true,
        autoplay: true,
        slideTransition: 'linear',
        autoplaySpeed: 5000,
        // autoplayTimeout:1e3,
        autoplayHoverPause: false,
       navText : ["<img src='<?php echo get_stylesheet_directory_uri() ?>/images/fe-arrow-left.png' class='fa-flip-horizontal' alt=''>","<img src='<?php echo get_stylesheet_directory_uri() ?>/images/fe-arrow-right.png' alt=''>"],
        responsiveClass:true,
        responsive:{
            0:{
                items:1.5,
            },
            500:{
                items:2,
            },
            768:{
                items:4,
            },
            1100:{
                items:4,
            },
            1400:{
                items:4,
            }
        }
      });

   
      $('.workshop-course').owlCarousel({
        items: 3,
        autoplay: false,
        margin: 0,
        nav: true,
        dots: false,
        loop: true,
        smartSpeed: 450,
       navText : ["<img src='<?php echo get_stylesheet_directory_uri() ?>/images/fe-arrow-left.png' class='fa-flip-horizontal' alt=''>","<img src='<?php echo get_stylesheet_directory_uri() ?>/images/fe-arrow-right.png' alt=''>"],
        responsiveClass:true,
        responsive:{
            0:{
                items:1.5,
            },
            500:{
                items:2,
            },
            768:{
                items:3,
            },
            1100:{
                items:3,
            },
            1400:{
                items:3,
            }
        }
      });

    jQuery('.top-company').owlCarousel({
        items: 2,
        loop: true,
        margin: 20,
        autoplay: true,             lazyLoad: true,
        slideTransition: 'linear',
        autoplaySpeed: 5000,
        // autoplayTimeout:1e3,
        autoplayHoverPause: false,

        navText : ["<img src='<?php echo get_stylesheet_directory_uri() ?>/images/fe-arrow-left.png' class='fa-flip-horizontal' alt=''>","<img src='<?php echo get_stylesheet_directory_uri() ?>/images/fe-arrow-right.png' alt=''>"],
        responsiveClass:true,
        responsive:{
            0:{
                items:3,
            },
            500:{
                items:3,
            },
            768:{
                items:4,
            },
            1100:{
                items:6,
            },
            1400:{
                items:8,
            }
        }
      });
      
      
      jQuery('.about-banner').owlCarousel({
        items: 1,
        loop: true,
        margin: 20,
        nav: false,
        dots: true,
        loop: true,
        smartSpeed: 450,
        animateOut: 'fadeOut',
        animateIn: 'fadeIn',
        responsiveClass:true,
        navText : ["<img src='<?php echo get_stylesheet_directory_uri() ?>/images/fe-arrow-left.png' class='fa-flip-horizontal' alt=''>","<img src='<?php echo get_stylesheet_directory_uri() ?>/images/fe-arrow-right.png' alt=''>"],
        responsive:{
            0:{
                items:1,
            },
            500:{
                items:1,
            },
            768:{
                items:1,
            },
            1100:{
                items:1,
            },
            1400:{
                items:1,
            }
        }
      });


      $('.choice-course').owlCarousel({
        items: 4,
        autoplay: true,
        margin: 15,
        nav: true,
        dots: true,
        loop: true,
        smartSpeed: 450,
        navText : ["<img src='<?php echo get_stylesheet_directory_uri() ?>/images/fe-arrow-left.png' class='fa-flip-horizontal' alt=''>","<img src='<?php echo get_stylesheet_directory_uri() ?>/images/fe-arrow-right.png' alt=''>"],
        responsiveClass:true,
        responsive:{
            0:{
                items:1.4,
            },
            500:{
                items:2,
            },
            768:{
                items:3,
            },
            1100:{
                items:4,
            },
            1400:{
                items:4,
            }
        }
      });
      
      
      $('.rec-certi').owlCarousel({
        items: 3,
        autoplay: true,
        margin: 15,
        //nav: true,
        dots: true,
        loop: true,
        smartSpeed: 450,
        //navText : ["<img src='<?php echo get_stylesheet_directory_uri() ?>/images/fe-arrow-left.png' class='fa-flip-horizontal' alt=''>","<img src='<?php echo get_stylesheet_directory_uri() ?>/images/fe-arrow-right.png' alt=''>"],
        responsiveClass:true,
        responsive:{
            0:{
                items:1.3,
            },
            500:{
                items:2,
            },
            768:{
                items:3,
            },
            1100:{
                items:3,
            },
            1400:{
                items:3,
            }
        }
      });
     
     
         
      $('.ourpartner').owlCarousel({
        items: 6,
        autoplay: true,
        margin: 0,
        nav: false,
        dots: false,
        loop: true,
        smartSpeed: 450,
        navText : false,
        responsiveClass:true,
        responsive:{
            0:{
                items:3,
            },
            500:{
                items:3,
            },
            768:{
                items:4,
            },
            1100:{
                items:6,
            },
            1400:{
                items:6,
            }
        }
      });



      $('.project-work').owlCarousel({
        items: 3,
        autoplay: true,
        margin: 20,
        nav: true,
        dots: false,
        loop: true,
        smartSpeed: 450,
        navText : ["<img src='<?php echo get_stylesheet_directory_uri() ?>/images/fe-arrow-left.png' class='fa-flip-horizontal' alt=''>","<img src='<?php echo get_stylesheet_directory_uri() ?>/images/fe-arrow-right.png' alt=''>"],
        responsiveClass:true,
        responsive:{
            0:{
                items:1.5,
                margin: 5,
            },
            500:{
                items:2,
            },
            768:{
                items:3,
            },
            1100:{
                items:3,
            },
           
        }
      });


    

    
        $('.top-company-course').owlCarousel({
  
          items: 2,
        loop: true,
        margin: 20,
        autoplay: true,
        autoplay: true,
        slideTransition: 'linear',
        autoplaySpeed: 5000,
        // autoplayTimeout:1e3,
        autoplayHoverPause: false,

        navText : false,
        responsiveClass:true,
        responsive:{
            0:{
                items:4,
            },
            500:{
                items:4,
            },
            768:{
                items:4,
            },
            1100:{
                items:5,
            },
            1400:{
                items:5,
            }
        }
        
      });
  



         $('.homeslid').owlCarousel({
        items: 1,
        loop: true,
        margin: 0,
        autoplay: true,
        slideTransition: 'linear',
        autoplaySpeed: 5000,
        autoplayHoverPause: false,
        autoplayTimeout:2e3,
        animateOut: 'fadeOut',
        animateIn: 'fadeIn',
        // animateOut: 'slideOutUp',
        // animateIn: 'slideInUp',
        navText : false,
        responsiveClass:true,
        responsive:{
            0:{
                items:1,
            },
            500:{
                items:1,
            },
            768:{
                items:1,
            },
            1100:{
                items:1,
            },
            1400:{
                items:1,
            }
        }
      });

      $('.student-carousel').owlCarousel({
        items: 1,
        autoplay: true,
        margin: 0,
        nav: false,
        dots: false,
        loop: true,
        smartSpeed: 650,
        navText : ["<img src='<?php echo get_stylesheet_directory_uri() ?>/images/fe-arrow-left.png' class='fa-flip-horizontal' alt=''>","<img src='<?php echo get_stylesheet_directory_uri() ?>/images/fe-arrow-right.png' alt=''>"],
        responsiveClass:true,
        responsive:{
            0:{
                items:1,
            },
            500:{
                items:1,
            },
            768:{
                items:1,
            },
            1100:{
                items:1,
            },
            1400:{
                items:1,
            }
        }
      });


      $('.intslid').owlCarousel({
        items: 1,
        loop: true,
        margin: 0,
        autoplay: true,
        slideTransition: 'linear',
        autoplaySpeed: 5000,
        autoplayHoverPause: false,
        autoplayTimeout:4e3,
        animateOut: 'fadeOut',
        animateIn: 'fadeIn',
        // animateOut: 'slideOutUp',
        // animateIn: 'slideInUp',
        navText : false,
        responsiveClass:true,
        responsive:{
            0:{
                items:1,
            },
            500:{
                items:1,
            },
            768:{
                items:1,
            },
            1100:{
                items:1,
            },
            1400:{
                items:1,
            }
        }
      });

      $('.project-works').owlCarousel({
        items: 4,
        autoplay: true,
        margin: 20,
        nav: true,
        dots: true,
        loop: true,
        smartSpeed: 450,
        navText : ["<img src='<?php echo get_stylesheet_directory_uri() ?>/images/fe-arrow-left.png' class='fa-flip-horizontal' alt=''>","<img src='<?php echo get_stylesheet_directory_uri() ?>/images/fe-arrow-right.png' alt=''>"],
        responsiveClass:true,
        responsive:{
            0:{
                items:1.5,
                margin: 5,
            },
            500:{
                items:2,
            },
            768:{
                items:3,
            },
            1100:{
                items:3,
            },
            1400:{
                items:3,
            }
        }
      });

      $('.red-logo').owlCarousel({
        items: 6,
        autoplay: true,
        margin: 0,
        nav: true,
        dots: false,
        loop: true,
        smartSpeed: 450,
        navText : false,
        responsiveClass:true,
        slideTransition: 'linear',
        autoplaySpeed: 5000,
        autoplayHoverPause: false,
        responsive:{
            0:{
                items:4,
            },
            500:{
                items:4,
            },
            768:{
                items:5,
            },
            1100:{
                items:6,
            },
            1400:{
                items:6,
            }
        }
      });


      $('.across-slid1').owlCarousel({
        items: 4,
        autoplay: true,
        margin: 0,
        nav: true,
        dots: false,
        loop: true,
        smartSpeed: 450,
        navText : false,
        responsiveClass:true,
        slideTransition: 'linear',
        autoplaySpeed: 5000,
        autoplayHoverPause: false,
        responsive:{
            0:{
                items:4,
            },
            500:{
                items:4,
            },
            768:{
                items:8,
            },
            1100:{
                items:13,
            },
            1400:{
                items:13,
            }
        }
      });

      $('.across-slid2').owlCarousel({
        items: 4,
        autoplay: true,
        margin: 0,
        nav: true,
        dots: false,
        loop: true,
        rtl: true,
        smartSpeed: 450,
        navText : false,
        responsiveClass:true,
        slideTransition: 'linear',
        autoplaySpeed: 5000,
        autoplayHoverPause: false,
        responsive:{
            0:{
                items:4,
            },
            500:{
                items:4,
            },
            768:{
                items:8,
            },
            1100:{
                items:13,
            },
            1400:{
                items:13,
            }
        }
      });


      $('.video-review').owlCarousel({
        items: 3,
        autoplay: true,
        margin: 20,
        nav: false,
        dots: false,
        loop: true,
        smartSpeed: 450,
        navText : false,
        responsiveClass:true,
        responsive:{
            0:{
                items:1,
            },
            500:{
                items:2,
            },
            768:{
                items:2,
            },
            1100:{
                items:3,
            },
            1400:{
                items:3,
            }
        }
      });

    
    $('.owl-carousel').owlCarousel({
        items: 4, // Adjust the number of items
        loop: true,
        margin: 10,
        nav: true,
        autoplay: true,
        autoplayTimeout: 3000,
        autoplayHoverPause: true
    });

    $('.innovation-slider-area').owlCarousel({
            autoplay: true,
            margin: 20,
            nav: false,
            dots: true,
            loop: true,
            items:1,
            smartSpeed: 450,
            navText : false,        
    });

    $("#toggle").click(function() {
          
            var elem = $("#toggle").text();
            if (elem == "Read More") {
              //Stuff to do when btn is in the read more state
              $("#toggle").text("Read Less");
              $("#text").slideDown();
            } else {
              //Stuff to do when btn is in the read less state
              $("#toggle").text("Read More");
              $("#text").slideUp();
            }
    });

    

          $(document).ready( function() {   

$('.grid').isotope({
  itemSelector: '.grid-item',
});

// filter items on button click
$('.filter-button-group').on( 'click', 'li', function() {
  var filterValue = $(this).attr('data-filter');
  $('.grid').isotope({ filter: filterValue });
  $('.filter-button-group li').removeClass('active');
  $(this).addClass('active');
});
  $('.navtab a').on('click', function() {
      var scrollAnchor = $(this).attr('data-scroll'),
          scrollPoint = $('div[data-anchor="' + scrollAnchor + '"], footer[data-anchor="' + scrollAnchor + '"]')?.offset()?.top-1;
          // scrollPoint = $().offset().top - 28;    
      $('body,html').animate({
            scrollTop: scrollPoint
        }, 500);

        return false;

      })

      $(window).scroll(function() {
          var windscroll = $(window).scrollTop();
          if (windscroll >= 0) {
              // $('navtab').addClass('fixed');
              $('.scroller').each(function(i) {
                  if ($(this).position().top <= windscroll + 500) {
                      $('.navtab a.active').removeClass('active');
                      $('.navtab a').eq(i).addClass('active');
                  }
              });

          } else {

              // $('navtab').removeClass('fixed');
              $('.navtab a.active').removeClass('active');
              $('.navtab a:first').addClass('active');
          }

      }).scroll();
})
});
    
   

    </script>




    <!--featured-course -->



    <!-- tabs link scroll-->
   

    <!-- header fix -->
    <script>
      // cache the element
      var $navBar = jQuery('.nav');

      // find original navigation bar position
      var navPos = $navBar.offset().top;

      // on scroll
      jQuery(window).scroll(function() {

          // get scroll position from top of the page
          var scrollPos = jQuery(this).scrollTop();

          // check if scroll position is >= the nav position
          if (scrollPos >= navPos) {
              $navBar.addClass('fixed');
          } else {
              $navBar.removeClass('fixed');
          }

      });
    </script>

    <!-- tab change to acordian -->
    <script>
        jQuery(document).ready(function($) {
            tabControl();

            /*
            We also apply the switch when a viewport change is detected on the fly
            (e.g. when you resize the browser window or flip your device from 
            portrait mode to landscape). We set a timer with a small delay to run 
            it only once when the resizing ends. It's not perfect, but it's better
            than have it running constantly during the action of resizing.
            */
            var resizeTimer;
            $(window).on('resize', function(e) {
            clearTimeout(resizeTimer);
            resizeTimer = setTimeout(function() {
                tabControl();
            }, 250);
            });

            /*
            The function below is responsible for switching the tabs when clicked.
            It switches both the tabs and the accordion buttons even if 
            only the one or the other can be visible on a screen. We prefer
            that in order to have a consistent selection in case the viewport
            changes (e.g. when you esize the browser window or flip your 
            device from portrait mode to landscape).
            */
            function tabControl() {
                var tabs = $('.tabbed-content').find('.tabs');
                if(tabs.is(':visible')) {
                    tabs.find('a').on('click', function(event) {
                        event.preventDefault();
                        var target = $(this).attr('href'),
                            tabs = $(this).parents('.tabs'),
                            buttons = tabs.find('a'),
                            item = tabs.parents('.tabbed-content').find('.item');
                        buttons.removeClass('active');
                        item.removeClass('active');
                        $(this).addClass('active');
                        $(target).addClass('active');
                    });
                } else {
                    $('.item').on('click', function() {
                        var container = $(this).parents('.tabbed-content'),
                        currId = $(this).attr('id'),
                        items = container.find('.item');
                        container.find('.tabs a').removeClass('active');
                        items.removeClass('active');
                        $(this).addClass('active');
                        container.find('.tabs a[href$="#'+ currId +'"]').addClass('active');
                    });
                } 
            }
        });
    </script>

<script>
document.addEventListener("DOMContentLoaded", (event) => {
  document.querySelectorAll('#custom-showsjdfk').forEach(function(element) {
    element.style.setProperty('display', 'block', 'important');
  });
});

document.addEventListener('DOMContentLoaded', function() {
  const menu = document.getElementById('collapseExample');

  document.addEventListener('click', function(event) {
    const isClickInside = menu.contains(event.target);
    const isButton = event.target.closest('[data-bs-toggle="collapse"]');

    // Check if click is outside the menu and not on the toggle button
    if (!isClickInside && !isButton && menu.classList.contains('show')) {
      const bsCollapse = bootstrap.Collapse.getInstance(menu);
      if (bsCollapse) {
        bsCollapse.hide();
      }
    }
  });
});

// When modal is fully shown
jQuery('.youtubeModal').on('shown.bs.modal', function () {
    console.log('Modal is open');
    var carousel = jQuery(this).attr('data-owl-carousel');
    if(carousel) {
        jQuery(carousel).trigger('stop.owl.autoplay');
    }
});

// When modal is fully hidden
jQuery('.youtubeModal').on('hidden.bs.modal', function () {
    var ele = jQuery(this);
    var iframeLink = ele.find(".youtubeIframe").attr('src');
    ele.find(".youtubeIframe").attr('src', '');
    setTimeout(() => {
        ele.find(".youtubeIframe").attr('src', iframeLink);
    }, 100);
    var carousel = jQuery(this).attr('data-owl-carousel');
    if(carousel) {
        jQuery(carousel).trigger('play.owl.autoplay', [3000]);
    }
});

const menuItems = document.querySelectorAll('.menu li');
const contents = document.querySelectorAll('.contentarea');

menuItems.forEach(item => {
    item.addEventListener('click', () => {
        // Remove active from all menu items
        menuItems.forEach(i => i.classList.remove('active'));
        item.classList.add('active');

        // Hide all content
        contents.forEach(c => c.classList.remove('active'));

        // Show target content
        const targetId = item.getAttribute('data-target');
        document.getElementById(targetId).classList.add('active');
    });
});

document.addEventListener("DOMContentLoaded", function () {
    const toggleLink = document.querySelector(".toggle-more");
    if (!toggleLink) return;

    toggleLink.addEventListener("click", function () {
      const moreText = document.querySelector(".more-text");
      const dots = document.querySelector(".dots");

      if (moreText.classList.contains("d-none")) {
        moreText.classList.remove("d-none");
        dots.style.display = "none";
        this.textContent = "Read less";
      } else {
        moreText.classList.add("d-none");
        dots.style.display = "inline";
        this.textContent = "Read more";
      }
    });
});
</script>




 <script src="https://www.google.com/recaptcha/api.js" async defer></script>
   
    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="<?php echo get_stylesheet_directory_uri() ?>/https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
    <script src="<?php echo get_stylesheet_directory_uri() ?>/https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
    -->
  </body>
</html>
