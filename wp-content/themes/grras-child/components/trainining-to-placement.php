	    <div class="trainplace">
	      <div class="container">
	        <div class="row">
	          <div class="col-lg-5 top-fixed d-none d-lg-block" style='width: 40%;'>
	          <?php 
	    $internship_detail_page = get_field('internship_detail_page','option');
	    ?>
	            <h2><?php echo $internship_detail_page['training_to_placement_title']; ?></h2>
	            <div class="d-none d-md-block"><a href="#" class="btn btn-primary text-14" data-bs-toggle="modal" data-bs-target="#exampleModal5">Register For Free Demo</a></div>
	   
	          </div>
	          <div class="col-lg-5 d-block d-md-none">
	       
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
	            <div class="flag d-none d-sm-block"><img src="<?php echo get_stylesheet_directory_uri() ?>/images/flag.svg" class="img-fluid" alt=""></div>
	            <div class="flag d-block d-sm-none"><img src="<?php echo get_stylesheet_directory_uri() ?>/images/flag-small.png" class="img-fluid" alt=""></div>
	          </div>
	        </div>
	      </div>
	    </div>
