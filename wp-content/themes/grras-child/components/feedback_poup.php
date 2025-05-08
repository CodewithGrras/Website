

        <div class="modal fade show" id="exampleModal5" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" style="display: block">
      <div class="modal-dialog reqcallback" >
        <div class="modal-content" style="background: #ffe7d8;">
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="window.location.href = '/'"></button>
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
                  <h4>Workshop Feedback , For <strong>Free!</strong></h4>
 <?php
$post_id     = get_the_ID();
$post        = get_post($post_id);
$author_id   = $post->post_author;
$author_name = get_the_author_meta('display_name', $author_id);

// Output the Gravity Form
echo do_shortcode('[gravityform id="28" title="false" ajax="true"]');
?>

<script>
document.addEventListener('DOMContentLoaded', function () {
    // Wait for Gravity Form to fully load (especially with AJAX enabled)
    function fillHiddenFields() {
        const workshopUserField    = document.querySelector('input[name="input_7"]');
        const workshopIdField      = document.querySelector('input[name="input_8"]');
        const workshopUserIdField  = document.querySelector('input[name="input_9"]');

        if (workshopUserField && workshopIdField && workshopUserIdField) {
            workshopUserField.value    = "<?php echo esc_js($author_name); ?>";
            workshopUserIdField.value  = "<?php echo esc_js($author_id); ?>";
            workshopIdField.value      = "<?php echo esc_js($post_id); ?>";
        } else {
            // Retry if not found yet
            setTimeout(fillHiddenFields, 100);
        }
    }

    fillHiddenFields();
});
</script>


              </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>