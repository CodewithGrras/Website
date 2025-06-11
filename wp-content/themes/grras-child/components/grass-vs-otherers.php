	  

	     <?php 

	    $internship_detail_page = get_field('internship_detail_page','option');

	  $internship =  is_page('internship') ? 'pt-0' : ''

	    ?>

	    <div class="section-padding bglight-sm grrasint <?php echo $internship ?>">

	      <div class="container">

	        <div class="row justify-content-center">

	          <div class="col-lg-10 text-center">

	            <h2><?php echo $internship_detail_page['grras_vs_other_title']; ?></h2>

	            <p class="pb-4"><?php echo $internship_detail_page['grras_vs_other_description']; ?></p>

	          </div>

	          <div class="col-lg-10">

	            <table class="table">

	              <tr>

	                <th width="40%"></th>

	                <th width="18%">Video Courses</th>

	                <th width="18%">Bootcamps</th>

	                <th width="16%">Grras</th>

	              </tr>

	              <?php foreach($internship_detail_page['grras_vs_other_points'] as $item): ?>

	              <tr>

	                <td><?php echo $item['title'] ?></td>

	                <td align="center" valign="middle"><img src="<?php echo get_stylesheet_directory_uri() . (($item['video_courses'] == 1) ? '/images/check.png' : '/images/cross.png'); ?>" alt=""></td>

	                <td align="center" valign="middle"><img src="<?php echo get_stylesheet_directory_uri() . (($item['bootcamps'] == 1) ? '/images/check.png' : '/images/cross.png'); ?>" alt=""></td>

	                <td align="center" valign="middle"><img src="<?php echo get_stylesheet_directory_uri() . (($item['grras'] == 1) ? '/images/check.png' : '/images/cross.png'); ?>" alt=""></td>

	              </tr>

	              <?php endforeach; ?>

	            </table>

	            

	            <!--<div class="text-center mt-5"><a href="#" class="btn btn-primary text-14" data-bs-toggle="modal" data-bs-target="#exampleModal5">Register For Free Demo</a></div>-->

	          </div>

	        </div>

	      </div>

	    </div>

