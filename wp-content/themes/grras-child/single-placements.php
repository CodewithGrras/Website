<?php 
get_header();
	$banner = get_field('banner');
	$about_the_placement = get_field('about_the_placement');
	$highlight_package = get_field('highlight_package');

?>

<!--start from here-->


<!-- breadcrumb -->
    <nav aria-label="breadcrumb" class="breadcrumb">
      <div class="container">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="/">Home</a></li>
          <li class="breadcrumb-item"><a href="/placement-support">Placement</a></li>
          <li class="breadcrumb-item active" aria-current="page"><?php the_title(); ?></li>
        </ol>
      </div>
    </nav>



    <!-- Learning to Placement -->
    <div class="plac-banner">
      <div class="container">
        <div class="row align-items-center">
          <div class="col-lg-7 wow fadeInLeft">
            <h1><?php echo $banner['title']; ?></h1>
            <p><?php echo $banner['short_description']; ?></p>

            <div class="lang"><?php echo $banner['sub_title']; ?> </div>
            <div class="owl-carousel intslid">
                <?php foreach($banner['points'] as $item): ?>
              <div class="item"><div class="subtext"><?php echo $item['name'] ?></div></div>
            <?php endforeach; ?>
            </div>
            <div class="clearfix"></div>
            <a href="#" class="btn btn-primary">Explore Placement Opportunities</a> <img src="<?php echo get_stylesheet_directory_uri() ?>/images/blueline.png" class="img-fluid mt-2" alt="">
          </div>
          <div class="col-lg-5 wow fadeInRight pattern">
            <iframe width="100%" height="315" src="https://www.youtube.com/embed/H4qNaVl9XO8?si=SdO6l7ekaOP5q9Cw" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
          </div>
        </div>
      </div>
    </div>    


    <!-- turnover -->
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
    <div class="aboutplace">
      <div class="container">
        <div class="row align-items-center">
          <div class="col-md-6">
            <div class="subtext">About the</div>
            <h2><?php echo $about_the_placement['title']; ?></h2>
            <p><?php echo $about_the_placement['content']; ?>
            <!--<br><a href="#">Read more</a>-->
            </p>
          </div>
          <div class="col-md-6">
            <iframe width="100%" height="315" src="<?php echo $about_the_placement['youtube_url'] ?>" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
          </div>
        </div>
      </div>
    </div>


    <!-- From Training to Placement -->
     <div class="trainplace">
	      <div class="container">
	        <div class="row">
	          <div class="col-lg-5">
	            <h2><?php echo $internship_detail_page['training_to_placement_title']; ?></h2>
	            <div class="d-none d-md-block"><a href="#" class="btn btn-primary text-14" data-bs-toggle="modal" data-bs-target="#exampleModal5">Register For Free Demo</a></div>
	          </div>
	          <div class="col-lg-7">
	            <ul class="iconlist">
	              <?php
	              $idfs = 0;
	              foreach($internship_detail_page['training_to_placement_points'] as $item): 
	              $idfs++;
	              ?>
	              <li>
	                <div class="number"><?php echo $idfs; ?></div>
	                <div class="imgbox">
	                  <img src="<?php echo $item['icon'] ?>" class="img-fluid" alt="">
	                  <h5><?php echo $item['title'] ?></h5>
	                </div>
	               <?php echo $item['description'] ?>
	              </li>
	              <?php endforeach; ?>
	            </ul>
	          </div>
	        </div>
	        <div class="row">
	          <div class="col-lg-12">
	            <div class="d-block d-md-none text-center"><a href="#" class="btn btn-primary text-14" data-bs-toggle="modal" data-bs-target="#exampleModal5">Register For Free Demo</a></div>
	            <div class="flag d-none d-sm-block"><img src="<?php echo get_stylesheet_directory_uri() ?>/images/flag.png" class="img-fluid" alt=""></div>
	            <div class="flag d-block d-sm-none"><img src="<?php echo get_stylesheet_directory_uri() ?>/images/flag-small.png" class="img-fluid" alt=""></div>
	          </div>
	        </div>
	      </div>
	    </div>

    <!-- Your Dream Job Starts with Grras Solutions -->
    <div class="dreamjob">
      <div class="container">
        <div class="row">
          <div class="col-lg-12">
            <h2><?php $dream_job = get_field('dream_job');
            echo $dream_job['title'];
            ?></h2>
          </div>
        <?php 
        $i = 0;
        foreach($dream_job['points'] as $item): 
        $i++;
        ?>
          <div class="col-md-4">
            <div class="djbox b<?php echo $i; ?>">
              <img src="<?php echo $item['icon']; ?>" class="img-fluid" alt="">
              <h4><?php echo $item['title'] ?></h4>
              <p><?php echo $item['short_description']; ?></p>
            </div>
          </div>
          <?php endforeach; ?>
        </div>
      </div>
    </div>



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
          <div class="col-md-7">
            <h2>Real Stories, Real Impact<br>Hear from our Alumni Across the Globe</h2>
          </div>
          <div class="col-md-5">
            <div class="subtext">Grras is transforming lives and careers while <br>strengthening the industry ecosystem. <br>Real opportunities, real growth – that's the Grras impact.</div>
          </div>
        </div>
        <div class="row mt-80 d-flex align-items-center">
          <div class="col-md-2">
            <div class="nav" id="v-pills-tab" role="tablist">
              <a href="#" class="nav-link" id="video-tab" data-bs-toggle="pill" data-bs-target="#video" role="tab" aria-controls="video" aria-selected="true">Video<br>Review</a>
              <a href="#" class="nav-link" id="review-tab" data-bs-toggle="pill" data-bs-target="#review" role="tab" aria-controls="review" aria-selected="false">Review</a>
              <a href="#" class="nav-link topgap active" id="college-tab" data-bs-toggle="pill" data-bs-target="#college" role="tab" aria-controls="college" aria-selected="false">Placements</a>
            </div>
          </div>
          <div class="col-md-10">
            <div class="tab-content" id="v-pills-tabContent">
              <div class="tab-pane fade" id="video" role="tabpanel" aria-labelledby="video-tab" tabindex="0">
               <?php include 'components/placment-details-stories.php'; ?>
              </div>
              <div class="tab-pane fade" id="review" role="tabpanel" aria-labelledby="review-tab" tabindex="0">
                 <?php include 'components/placment-details-review.php'; ?>
              </div>
              <div class="tab-pane fade show active" id="college" role="tabpanel" aria-labelledby="college-tab" tabindex="0">
               <?php include 'components/placement-details-placement.php'; ?>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>


    <!-- highlight package -->
    <div class="package">
      <div class="container">
        <div class="row">
            <?php foreach($highlight_package as $item): ?>
          <div class="col-md-3 col-6">
            <div class="box"><?php echo $item['name'] ?></div>
          </div>
   <?php endforeach;?>
        </div>
      </div>
    </div>
    

    <!-- Grras vs Other Internships -->
    <div class="grrasint">
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-lg-8 text-center">
              
            <h2><?php 
            $grras_vs_free_resources = get_field('grras_vs_free_resources');
            echo $grras_vs_free_resources['title'];
            ?></h2>
            <p><?php echo $grras_vs_free_resources['description'] ?></p>
          </div>
          <div class="col-lg-10">
            <table class="table">
              <tr>
                <th width="25%"></th>
                <th width="10%">Video Courses</th>
                <th width="20%">Other Providers</th>
                <th width="20%">Grras</th>
              </tr>
              <?php foreach($grras_vs_free_resources["resources"] as $item): ?>
              <tr>
                <td><?php echo $item['title']; ?></td>
                <td align="center" valign="middle"><img src="<?php echo get_stylesheet_directory_uri() . (($item['video_courses'] == 1) ? '/images/check.png' : '/images/cross.png'); ?>" alt=""><?php echo $item['video_courses_text']; ?></td>
                <td align="center" valign="middle"><img src="<?php echo get_stylesheet_directory_uri() . (($item['other_providers'] == 1) ? '/images/check.png' : '/images/cross.png'); ?>" alt=""> <?php echo $item['other_providers_text']; ?></td>
                <td align="center" valign="middle"><img src="<?php echo get_stylesheet_directory_uri() . (($item['grras'] == 1) ? '/images/check.png' : '/images/cross.png'); ?>" alt=""> <?php echo $item['grras_text']; ?></td>
              </tr>
<?php  endforeach;         ?>
            </table>
            <div class="text-center mt-5"><a href="#" class="btn btn-primary text-14">Register For Free Demo</a></div>
          </div>
        </div>
      </div>
    </div>



<?php
	  include('components/faq.php');
get_footer();