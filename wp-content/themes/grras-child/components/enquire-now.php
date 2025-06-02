
      
      
        <div class="modal fade" id="exampleModal5" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog reqcallback" >
        <div class="modal-content" style="background: #ffe7d8;">
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          <div class="modal-body">
            <div class="row">
              <div class="col-lg-6">
                <div class="imgbox"><img src="<?php 
                $request_call_back_images = get_field('enquiry_now_form','option');
                echo $request_call_back_images['desktop_image']; ?>" class="img-fluid d-none d-lg-block" alt=""></div>
                <div class="imgbox"><img src="<?php echo $request_call_back_images['mobile_image']; ?>" class="img-fluid d-block d-lg-none" alt=""></div>
              </div>
              <div class="col-lg-6">
              <div class="formbox">
                  <h4>Book a Demo Class, For <strong>Free!</strong> </h4>
                  <?php
                  if (is_singular('internships')) {
                      $form_id = 21; // Default form ID for internships
                  } else {
                      $form_id = 20; // Default form ID for other pages 
                  }
                  echo do_shortcode('[gravityform id="' . $form_id . '" title="false" ajax="true"]');
                  ?>
              </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>