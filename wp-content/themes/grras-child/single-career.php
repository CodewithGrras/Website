   <!-- REMOTE INSTRUCTOR (DEVOPS) -->
   <?php 
   get_header();
   ?>
   
   <div class="remote">
      <div class="container">
        <div class="row">
          <div class="col-lg-12">
            <h2 class="text-center"><?php the_title(); ?></h2>
            <?php the_content();?>
        </div>
        </div>
          <div class="formbox">   
              <!-- step 1 -->
            <?php echo do_shortcode('[gravityform id="6" title="false"]') ?>
                  
          </div>
      </div>
    </div>

<?php
include 'components/faq.php';
get_footer();