   <div class="industryproject ent-pro bg-theme-light-gradient-md">
	      <div class="container">
	        <div class="text-center">
	          <h2><?php echo $internship_detail_page['project_title']; ?></h2>
	          <div class="subtext"><?php echo $internship_detail_page['project_description']; ?></div>
	        </div>
        <div class="owl-carousel project-works">
            <?php
			
			$choose_projects = get_field('choose_projects');			
			//echo "<pre>"; print_r($choose_projects); exit;
			if($choose_projects):
				foreach( $choose_projects as $project ):
					$permalink = get_permalink( $project->ID );
					//echo $project->ID. "testing". $permalink;
					//$permalink = get_permalink( $project->ID );
					$image = wp_get_attachment_image_src( get_post_thumbnail_id( $project->ID ), 'single-post-thumbnail' );
					$title = get_the_title( $project->ID );
					
			$curse_tags = get_field('course_tags', $project->ID);			
					
					$content = wp_trim_words(get_the_content($project->ID), 20);
				
					?>
					<div class="item project-btn" data-id="<?php echo $project->ID; ?>" data-bs-toggle="modal" data-bs-target="#projectModal-<?php echo $project->ID; ?>">

                        <div class="content">

                            <img src="<?php echo $image[0]; ?>" class="img-fluid" alt="" />

                            <h4><?php echo $title; ?></h4>

                            <p><?php echo $content; ?></p>
                            <?php 
                            if($curse_tags):
                             echo '<ul>';
                                foreach($curse_tags as $item):
                                    
                            ?>
	                <li><?php echo $item->name;?></li>

                            <?php 
                                endforeach;
	              echo '</ul>';
                            endif;
                            ?>

                            <!-- Trigger button for modal -->

                           

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




           <?php
            $choose_projects = get_field('choose_projects');            
            if($choose_projects):
                foreach($choose_projects as $project):
                    $image = wp_get_attachment_image_src(get_post_thumbnail_id($project->ID), 'single-post-thumbnail');
                    $title = get_the_title($project->ID);
                    $content = get_the_content($project->ID);
                    $queried_post = get_post($project->ID);

                  
                    $icon_image = wp_get_attachment_url(get_post_thumbnail_id($project->ID)); // Get thumbnail URL as icon
                    ?>


    
                    
                      <div class="modal fade" id="projectModal-<?php echo $project->ID; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog promodal">
        <div class="modal-content">
          <div class="modal-header" >
            <div class="iconbox"><img src="<?php echo esc_url($icon_image); ?>" class="img-fluid" alt=""></div>
            <h1 class="modal-title" id="exampleModalLabel"><?php echo $title; ?></h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/close.svg" class="img-fluid" alt=""></button>
          </div>
              
          <div class="modal-body">
            <p><?php echo $queried_post->post_content; ?></p>
            <a href="<?php echo get_field('link',$project->ID); ?>" class="btn btn-outline-primary" target="_blank">Explore More</a>
          </div>
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



