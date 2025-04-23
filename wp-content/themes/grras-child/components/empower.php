	       <?php 
	    $internship_detail_page = get_field('internship_detail_page','option');
	    ?>
	    
	    <div class="empower">
	      <div class="container">
	        <div class="row">
	          <div class="col-lg-6">
	            <h2><?php echo $internship_detail_page['empowering_learners']['title']; ?></h2>
	            <p><?php echo $internship_detail_page['empowering_learners']['description']; ?></p>
	            <div class="row">
	              <div class="col-6">
	                <div class="iconbox">
	                  <div class="icon"><img src="<?php echo get_stylesheet_directory_uri() ?>/images/e1.png" class="img-fluid" alt=""></div>
	                  <div class="subtext"><strong><?php echo $internship_detail_page['empowering_learners']['partners']; ?></strong> Partners</div>
	                </div>
	              </div>
	              <div class="col-6">
	                <div class="iconbox">
	                  <div class="icon"><img src="<?php echo get_stylesheet_directory_uri() ?>/images/e2.png" class="img-fluid" alt=""></div>
	                  <div class="subtext"><strong><?php echo $internship_detail_page['empowering_learners']['students']; ?></strong> Students <br>Impacted <br>Annually</div>
	                  <div class="clearfix"></div>
	                </div>
	              </div>
	              <div class="col-12">
	                <div class="checktext"><img src="<?php echo get_stylesheet_directory_uri() ?>/images/ocheck.png" alt=""> <?php echo $internship_detail_page['empowering_learners']['visuals_of_collaborations']; ?></div>
	              </div>
	            </div>
	          </div>
	          <div class="col-lg-6 order-md-first">
	            <div class="row">
	                <?php foreach($internship_detail_page['university'] as $item):?>
	              <div class="col-4">
	                <div class="imgbox">
	                  <img src="<?php echo $item['image']; ?>" alt="">
	                  <div class="text"><?php echo $item['title']; ?></div>
	                </div>
	              </div>
	              <?php endforeach; ?>
	              <div class="col-12 text-center"><a href="#" class="link-primary">and more</a></div>
	            </div>
	          </div>
	        </div>
	      </div>
	    </div>
