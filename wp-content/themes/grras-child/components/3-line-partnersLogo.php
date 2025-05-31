  <div class="partnerind">
	      <div class="container-fluid">
	        <div class="row">
	          <div class="col-lg-12 text-center">
	            <h2><?php
	               $internship_detail_page = get_field('internship_detail_page','option');
	            echo $internship_detail_page['hiring_partners_title']; ?></h2>
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

	         
	            <div class="text-center mt-4"><a href="<?php echo site_url('aboutus?tab=partnerssection'); ?>" class="btn btn-primary text-14">See All Our Hiring Partners</a></div>

	          </div>
	        </div>
	      </div>
	    </div>