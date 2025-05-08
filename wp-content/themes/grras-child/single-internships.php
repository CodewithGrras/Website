	<?php
	get_header();
	$banner = get_field('banner');
	?>
	<!--start from here-->


		<!-- breadcrumb -->
		<nav aria-label="breadcrumb" class="breadcrumb">
		  <div class="container">
		    <ol class="breadcrumb">
		      <li class="breadcrumb-item"><a href="/">Home</a></li>
		      <li class="breadcrumb-item"><a href="/">Library</a></li>
		      <li class="breadcrumb-item active" aria-current="page">Full-Stack Web Development</li>
		    </ol>
		  </div>
		</nav>

		<!-- Learn today -->
	    <div class="inten-banner">
	      <div class="container">
	        <div class="row justify-content-between">
	          <div class="col-lg-7 wow fadeInLeft">
	            <h1><?php echo $banner['title']; ?></h1>
	            <p><?php echo $banner['short_description']; ?></p>

	            <div class="lang"><?php 
	            
	            echo $banner['sub_tiltle']; ?> </div>
	            <div class="owl-carousel intslid">
	              <?php foreach($banner['points'] as $item): ?>
	              <div class="item"><div class="subtext"><?php echo $item['point']; ?></div></div>
	            <?php endforeach; ?>
	            </div>
	            <div class="clearfix"></div>
	            <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal5">Register For Free Demo</a>
	          </div>
	          <!--<div class="col-lg-5 wow fadeInRight pattern">-->
	          <!--  <div class="row">-->
	          <!--    <div class="col-6">-->
	          <!--      <div class="story mt-5">-->
	          <!--        <div class="student wid160">-->
	          <!--          <div class="text"><?php echo $banner['student_counts']; ?> <small>Student</small></div> <img src="<?php echo get_stylesheet_directory_uri() ?>/images/student.png" class="img-fluid" alt="">-->
	          <!--        </div>-->
	          <!--        <img src="<?php echo get_stylesheet_directory_uri() ?>/images/intb1.png" class="img-fluid intgirl" alt="">-->
	          <!--      </div>-->
	          <!--    </div>-->
	          <!--    <div class="col-6">-->
	          <!--      <div class="story">-->
	          <!--        <img src="<?php echo get_stylesheet_directory_uri() ?>/images/intb2.png" class="img-fluid" alt="">-->
	          <!--        <div class="student intboy">-->
	          <!--          <?php echo $banner['student_corsouse_']; ?> <small>Success Courses</small>-->
	          <!--        </div>-->
	          <!--      </div>-->
	          <!--    </div>-->
	          <!--  </div>-->
	          <!--</div>-->
	                <div class="col-lg-5 wow fadeInRight pattern">
	                      <div class="student wid160">
	                    <div class="text"><?php echo $banner['student_counts']; ?> <small>Student</small></div> <img src="<?php echo get_stylesheet_directory_uri() ?>/images/student.png" class="img-fluid" alt="">
	          </div>
	          <div class="owl-carousel owl-loaded owl-drag custom-coursal-internship" >
            <div class="item">
              <img src="<?php echo get_stylesheet_directory_uri() ?>/images/intb2.png" class="img-fluid" alt="">
            </div>
            <div class="item">
              <img src="<?php echo get_stylesheet_directory_uri() ?>/images/intb1.png" class="img-fluid" alt="">
            </div>
            <div class="item">
              <img src="<?php echo get_stylesheet_directory_uri() ?>/images/intb2.png" class="img-fluid" alt="">
            </div>
            <div class="item">
              <img src="<?php echo get_stylesheet_directory_uri() ?>/images/intb1.png" class="img-fluid" alt="">
            </div>
            <div class="item">
              <img src="<?php echo get_stylesheet_directory_uri() ?>/images/intb2.png" class="img-fluid" alt="">
            </div>
            <div class="item">
              <img src="<?php echo get_stylesheet_directory_uri() ?>/images/intb1.png" class="img-fluid" alt="">
            </div>

            </div>
            <div class="student intboy">
	                    <?php echo $banner['student_corsouse_']; ?> <small>Success Courses</small>
	          </div>
          </div>
	        </div>
	      </div>
	    </div>

<style>
    .owl-nav.disabled {
    display: none;
}
.inten-banner .wid160 {
    width: 160px;
}


</style>

	    <!-- turnover -->
	    <?php 
	    $internship_detail_page = get_field('internship_detail_page','option');
	    ?>
	    <div class="turnover">
	      <div class="container">
	        <div class="row">
	            <?php foreach($internship_detail_page['showcase_points'] as $item): ?>
	          <div class="col-md-3 col-6 g-3">
	            <div class="icon"><img src="<?php echo $item['icon']; ?>" class="img-fluid" alt=""></div>
	            <?php echo wpautop($item['content']); ?>
	          </div>
	        <?php endforeach; ?>
	          
	        </div>
	      </div>
	    </div>

	    <!-- about inter -->
	    <div class="aboutinter">
	      <div class="container">
	        <div class="row">
	          <div class="col-md-7">
	            <div class="row">
	              <div class="col-md-6">
	                <div class="subtext">About the</div>
	                <h2><?php $about_the_internship =  get_field('about_the_internship');
	                echo $about_the_internship['title']?></h2>
	                <p><?php echo $about_the_internship['content']; ?>
	                <!--<a href="#">Read more</a>-->
	                </p>
	              </div>
	              <div class="col-md-6">
	                <div class="monybox">
	                  <big>₹ <?php echo get_field('average_annual_ctc'); ?></big>
	                  Average annual CTC
	                </div>
	                <div class="secret">
	                  <big>Secret insights</big>
	                  <?php echo get_field('secret_insights'); ?>
	                </div>
	              </div>
	            </div>
	          </div>
	          <div class="col-md-5">
	            <iframe width="100%" height="315" src="<?php echo get_field('youtube_url'); ?>" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
	          </div>
	        </div>
	      </div>
	    </div>

	    <!-- certificate -->
	    <div class="certificate-full p-0">
	      <div class="container">
	        <div class="intcert">
	          <div class="row justify-content-between align-items-center">
	            <div class="col-lg-6">
	              <h2><?php 
	              $certificate = get_field('certificate');
	              echo $certificate['title'];
	              ?></h2>
	              <?php echo wpautop($certificate['description']);?>
	              <div class="d-none d-md-block"><a href="#" class="btn btn-primary">Apply for Intermship</a></div>
	            </div>
	            <div class="col-lg-6 order-md-first">
	              <div class="certibox d-block">
	                <img src="<?php echo get_stylesheet_directory_uri() ?>/images/cartificate-2.jpg" class="img-fluid w-100" alt="">
	              </div>
	              <div class="text-center d-block d-md-none mt-5"><a href="#" class="btn btn-primary">Apply for Intermship</a></div>
	            </div>
	          </div>
	        </div>
	      </div>
	    </div>

	    <!-- Tolls -->
	    <div class="tools enttool">
	      <div class="container">
	        <h2><?php echo $internship_detail_page['tags_title']; ?></h2>
	        <ul>
	          <li>
	            <div class="imgbox"> <img src="<?php echo get_stylesheet_directory_uri() ?>/images/tool1.png" class="img-fluid" alt=""> </div>
	            <h4>HTML</h4>
	          </li>
	          <li>
	            <div class="imgbox"> <img src="<?php echo get_stylesheet_directory_uri() ?>/images/tool2.png" class="img-fluid" alt=""> </div>
	            <h4>CSS</h4>
	          </li>
	          <li>
	            <div class="imgbox"> <img src="<?php echo get_stylesheet_directory_uri() ?>/images/tool3.png" class="img-fluid" alt=""> </div>
	            <h4>Bootstrap</h4>
	          </li>
	          <li>
	            <div class="imgbox"> <img src="<?php echo get_stylesheet_directory_uri() ?>/images/tool4.png" class="img-fluid" alt=""> </div>
	            <h4>JavaScript</h4>
	          </li>
	          <li>
	            <div class="imgbox"> <img src="<?php echo get_stylesheet_directory_uri() ?>/images/tool5.png" class="img-fluid" alt=""> </div>
	            <h4>Node Js</h4>
	          </li>
	          <li>
	            <div class="imgbox"> <img src="<?php echo get_stylesheet_directory_uri() ?>/images/tool6.png" class="img-fluid" alt=""> </div>
	            <h4>React Js</h4>
	          </li>
	          <li>
	            <div class="imgbox"> <img src="<?php echo get_stylesheet_directory_uri() ?>/images/tool7.png" class="img-fluid" alt=""> </div>
	            <h4>Mongo DB</h4>
	          </li>
	          <li>
	            <div class="imgbox"> <img src="<?php echo get_stylesheet_directory_uri() ?>/images/tool8.png" class="img-fluid" alt=""> </div>
	            <h4>EXPRESS-JS</h4>
	          </li>
	          <li>
	            <div class="imgbox"> <img src="<?php echo get_stylesheet_directory_uri() ?>/images/tool9.png" class="img-fluid" alt=""> </div>
	            <h4>Git</h4>
	          </li>
	          <li>
	            <div class="imgbox"> <img src="<?php echo get_stylesheet_directory_uri() ?>/images/tool10.png" class="img-fluid" alt=""> </div>
	            <h4>Git-Hub</h4>
	          </li>
	          <li>
	            <div class="imgbox"> <img src="<?php echo get_stylesheet_directory_uri() ?>/images/tool11.png" class="img-fluid" alt=""> </div>
	            <h4>Next JS</h4>
	          </li>
	          <li>
	            <div class="imgbox"> <img src="<?php echo get_stylesheet_directory_uri() ?>/images/tool12.png" class="img-fluid" alt=""> </div>
	            <h4>Node-JS</h4>
	          </li>
	          <li>
	            <div class="imgbox"> <img src="<?php echo get_stylesheet_directory_uri() ?>/images/tool3.png" class="img-fluid" alt=""> </div>
	            <h4>Restfull-API</h4>
	          </li>
	          <li>
	            <div class="imgbox"> <img src="<?php echo get_stylesheet_directory_uri() ?>/images/tool4.png" class="img-fluid" alt=""> </div>
	            <h4>Tailwind</h4>
	          </li>
	          <li>
	            <div class="imgbox"> <img src="<?php echo get_stylesheet_directory_uri() ?>/images/tool5.png" class="img-fluid" alt=""> </div>
	            <h4>Vercel</h4>
	          </li>
	        </ul>
	        
	      </div>
	    </div>

	    <!-- Full Stack -->
  <div class="fullstack no-bg pb -0">
    <div class="container">
        <div class="row" style="position: relative!important;">
            <div class="col-lg-8 " style="position: relative;">
                <style>
                    .hidden-item {
    display: none;
}

                </style>
                <h2><?php echo get_field("course_curriculum_heading"); ?></h2>
                <div class="subtext"><?php echo get_field("course_curriculum_description"); ?></div>
            <div class="accordion" id="accordionExample2">
    <?php
    $count = 0;
    if (have_rows('course_learning')):
        while (have_rows('course_learning')): the_row();
            $count++;
            $title = get_sub_field('title');
            $slug = create_slug($title) .'-'. $count;
            $is_multiple = get_sub_field('is_multiple') == 'True';
            $multiple = get_sub_field('multiple');
    ?>
    <div class="accordion-item<?php echo ($count > 14) ? ' hidden-item' : ''; ?>">
        <h4 class="accordion-header acdd" id="heading-<?php echo $slug; ?>">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-<?php echo $slug; ?>" aria-expanded="false" aria-controls="collapse-<?php echo $slug; ?>">
                <?php echo $title; ?> <span>Preview</span>
            </button>
        </h4>
        <div id="collapse-<?php echo $slug; ?>" class="accordion-collapse collapse" aria-labelledby="heading-<?php echo $slug; ?>" data-bs-parent="#accordionExample2">
            <div class="accordion-body">
                <?php echo wpautop(get_sub_field('content')); ?>
                <?php if ($is_multiple): ?>
                    <div class="accordion" id="accordionExample4">
                        <?php foreach ($multiple as $i => $item): ?>
                            <div class="accordion-item">
                                <h4 class="accordion-header" id="heading-<?php echo $slug . '-' . $i; ?>">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-<?php echo $slug . '-' . $i; ?>" aria-expanded="false" aria-controls="collapse-<?php echo $slug . '-' . $i; ?>">
                                        <?php echo $item["title"]; ?>
                                    </button>
                                </h4>
                                <div id="collapse-<?php echo $slug . '-' . $i; ?>" class="accordion-collapse collapse" aria-labelledby="heading-<?php echo $slug . '-' . $i; ?>" data-bs-parent="#accordionExample4">
                                    <div class="accordion-body">
                                        <?php echo $item['content']; ?>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <?php
        endwhile;
    endif;
    ?>
</div>
<script>
    document.addEventListener("DOMContentLoaded", function() {
    const viewMoreBtn = document.getElementById('view-more-btn');
    const hiddenItems = document.querySelectorAll('.hidden-item');

    viewMoreBtn.addEventListener('click', function(e) {
        e.preventDefault();
        hiddenItems.forEach(function(item) {
            item.style.display = 'block';
        });
        if(viewMoreBtn.textContent == 'Show Less'){
        viewMoreBtn.textContent = 'Show More';
        hiddenItems.forEach(function(item) {
            item.style.display = 'none';
        });
        }else{
        viewMoreBtn.textContent = 'Show Less'; 
        }
    });
});

</script>
<?php if($count > 13): ?>
<div class="my-3 text-center"><a href="javascript:void(0)" id="view-more-btn" class="link-primary">View More</a></div>
<?php endif; ?>

                <!--<a href="#" class="btn btn-secondary">Download Brochure</a>-->
            </div>
            <div class="col-lg-4 d-none d-sm-block top-fixed">
                <div class="excel">
                    <ul>
                        <?php
                        if (have_rows('live_classes')):
                            $i = 0;
                            while (have_rows('live_classes')): the_row();
                                if ($i == 3):
                        ?>
                        <li class="separater"></li>
                        <?php
                                endif;
                        ?>
                        <li><img src="<?php echo get_sub_field('icon'); ?>" alt=""> <?php echo get_sub_field('name'); ?></li>
                        <?php
                                $i++;
                            endwhile;
                        endif;
                        ?>
                    </ul>
                    <!--<a href="<?php echo get_field('download_brochure') ?>" class="btn btn-primary d-block">Download Brochure</a>-->
					<a href="#" class="btn btn-primary d-block" data-bs-toggle="modal" data-bs-target="#exampleModal6">Download Brochure</a>
                </div>
            </div>
        </div>
    </div>
</div>

	    <!-- industry project -->
	   <?php include_once('components/internship-details-projects.php'); ?>
	    <!-- From Training to Placement -->
	   <?php include_once('components/trainining-to-placement.php'); ?>

	    <!-- empower -->
	   <?php include_once('components/empower.php'); ?>

	    <!-- Hiring Partners -->
	    <div class="partnerind">
	      <div class="container-fluid">
	        <div class="row">
	          <div class="col-lg-12 text-center">
	            <h2><?php echo $internship_detail_page['hiring_partners_title']; ?></h2>
	            <p><?php echo $internship_detail_page['hiring_partners_description']; ?></p>
<?php
// Split the array into three parts
$items = $internship_detail_page['hiring_partners_images'];
$split1 = array_slice($items, 0, ceil(count($items)/3));
$split2 = array_slice($items, 1,ceil(count($items)/3), ceil(count($items)/3));
$split3 = array_slice($items, 2 * ceil(count($items)/3));

// Function to create carousel items
function createCarouselItems($split, $carouselClass) {
        echo '<div class="owl-carousel ' . $carouselClass . '">';
    foreach ($split as $item) {
        echo '<div class="item"><img src="' . $item . '" class="img-fluid" alt=""></div>';
    }
        echo '</div>';
}

// Create carousels
createCarouselItems($split1, 'across-slid1');
createCarouselItems($split2, 'across-slid2');
createCarouselItems($split3, 'across-slid1');
?>

	         
	            <div class="text-center mt-5"><a href="#" class="btn btn-primary text-14">See All Our Hiring Partners</a></div>

	          </div>
	        </div>
	      </div>
	    </div>

	    <!-- Hear From -->
	    <div class="hearform">
	      <div class="container">
	        <div class="row">
	          <div class="col-md-6">
	            <h2><?php echo $internship_detail_page['hear_from_our_students_title']; ?></h2>
	          </div>
	          <div class="col-md-6">
	            <div class="subtext"><?php echo $internship_detail_page['hear_from_our_students_description']; ?></div>
	          </div>
	        </div>
	        <div class="row mt-80 d-flex align-items-center">
	          <div class="col-md-2">
	            <div class="nav" id="v-pills-tab" role="tablist">
	              <a href="#" class="nav-link" id="video-tab" data-bs-toggle="pill" data-bs-target="#video" role="tab" aria-controls="video" aria-selected="false">Video<br>Review</a>
	              <a href="#" class="nav-link active" id="review-tab" data-bs-toggle="pill" data-bs-target="#review" role="tab" aria-controls="review" aria-selected="true">Review</a>
	              <a href="#" class="nav-link" id="college-tab" data-bs-toggle="pill" data-bs-target="#college" role="tab" aria-controls="college" aria-selected="false">College <br>Collaboration</a>
	            </div>
	          </div>
	          <div class="col-md-10">
	            <div class="tab-content" id="v-pills-tabContent">
	              <div class="tab-pane fade" id="video" role="tabpanel" aria-labelledby="video-tab" tabindex="0">
	                <div class="owl-carousel video-review">
	                    <?php
$choose_video_review = get_field('choose_video_review');
if ($choose_video_review):
    foreach ($choose_video_review as $choose):
        $permalink = get_permalink($choose->ID);
        $image = wp_get_attachment_image_src(get_post_thumbnail_id($choose->ID), 'single-post-thumbnail');
        $title = get_the_title($choose->ID);
        $content = wp_trim_words(get_the_content($choose->ID), 20);
?>
    <div class="item">
        <div class="carbox">
            <div class="bigimg">
                <?php if (!empty($image[0])): ?>
                    <img src="<?php echo htmlspecialchars($image[0]); ?>" class="img-fluid" alt="">
                <?php endif; ?>
            </div>
            <a href="#" class="play" data-bs-toggle="modal" data-bs-target="#exampleModal">
                <img src="<?php echo get_stylesheet_directory_uri() ?>/images/caree-play1.png" alt="">
            </a>
            <div class="company">
                <img src="<?php echo get_stylesheet_directory_uri() ?>/images/gpc.png" class="img-fluid" alt="">
            </div>
            <div class="coname">
                <h4><?php echo htmlspecialchars($title); ?></h4>
                <p><?php echo htmlspecialchars(get_field('post_designation', $choose->ID)); ?></p>
            </div>
        </div>
    </div>
<?php 
    endforeach;
else:
?>
    <p>No projects found.</p>
<?php
endif;
?>

	                </div>
	              </div>
	              <div class="tab-pane fade show active" id="review" role="tabpanel" aria-labelledby="review-tab" tabindex="0">
	                <div class="owl-carousel video-review">
	                    <?php
$choose_reviews= get_field('choose_reviews');
if($choose_reviews):

    foreach ($choose_reviews as $choose):
        $permalink = get_permalink($choose->ID);
        $image = wp_get_attachment_image_src(get_post_thumbnail_id($choose->ID), 'single-post-thumbnail');
        $title = get_the_title($choose->ID);
        $content = wp_trim_words(get_the_content($choose->ID), 20);
?>
<div class="item">
	                    <div class="orangebox">
	                      <div class="content">
	                        <div class="row">
	                          <div class="col-4"><img src="<?php echo get_stylesheet_directory_uri() ?>/images/orange-quote.jpg" class="img-fluid" alt=""></div>
	                          <div class="col-8 text-right">
	                              <div class="star">
                                        <span class="star star-enabled">★</span>
                                        <span class="star star-enabled">★</span>
                                        <span class="star star-enabled">★</span>
                                        <span class="star star-enabled">★</span>
                                        <span class="star star-enabled">★</span>
                                    </div>
	                          </div>
	                        </div>
	                        <p>“ <?php echo wp_trim_words($choose->post_content,30); ?></p>
	                      </div>
	                      <div class="blackbg">
	                         <?php if (!empty($image[0])): ?>
                    <img src="<?php echo htmlspecialchars($image[0]); ?>" class="img-fluid" alt="">
                <?php endif; ?>
	                        <h5><?php echo htmlspecialchars($title); ?></h5>
	                      </div>
	                    </div>
	                  </div>

<?php 
    endforeach;
else:
?>
    <p>No projects found.</p>
<?php
endif;
?>

	                  
	                </div>
	              </div>
	              <div class="tab-pane fade" id="college" role="tabpanel" aria-labelledby="college-tab" tabindex="0">
	                <div class="owl-carousel video-review">
	                     <?php
$choose_placments = get_field('choose_placments');
if ($choose_placments):
    foreach ($choose_placments as $choose):
   
        // $permalink = get_permalink($choose->ID);
        $image = wp_get_attachment_image_src(get_post_thumbnail_id($choose->ID), 'single-post-thumbnail');
 
?>
 <div class="item">
	                    <div class="reviewbox">
		                  <img src="<?php echo $image[0] ?>" alt="" style="width: 63px; height: 63px">
		                  </br>
		                  <div class="content">
		                    <h4><?php echo $choose->post_title; ?></h4>
		                    <p><?php echo get_field('designation',$choose->ID) ?> @ <?php echo get_field('course_undertaken',$choose->ID) ?></p>
		                  </div>
		                  <p><small><?php echo $choose->post_content ?></small></p>
		                </div>
	                  </div>
	               
	                  <?php 
    endforeach;
else:
?>
    <p>No projects found.</p>
<?php
endif;
?>
	                </div>
	              </div>
	            </div>
	          </div>
	        </div>
	      </div>
	    </div>

	    <!-- Why grras -->
	    <div class="whygrras beint no-bg p-0">
	      <div class="container">
	        <div class="row">
	          <div class="col-md-12 text-center">
	            <h2><?php echo $internship_detail_page['benefits_of_interning_title']; ?></h2>
	            <div class="subtext"><?php echo $internship_detail_page['benefits_of_interning_description']; ?></div>
	          </div>
	        </div>
	        <div class="row align-items-center">
	            <?php foreach($internship_detail_page['benefits_of_interning_points'] as $item ): ?>
	          <div class="col-lg-4 col-md-6 col-6 g-3">
	            <div class="iconbox">
	              <img src="<?php echo $item['icon']; ?>" alt="">
	              <h4><?php echo $item['title']; ?></h4>
	              <p><?php echo $item['description']; ?></p>
	            </div>
	          </div>
	          <?php endforeach; ?>
	        </div>
	        
	      </div>
	    </div>


	    <!-- Faq -->
	    <!-- Faq -->


	<?php
	   // <!-- Grras vs Other Internships -->
	  include('components/grass-vs-otherers.php');
	  include('components/faq.php');
	get_footer();