<?php 
get_header();
?>
  <div class="solution">
      <div class="container">
        <div class="row align-items-center">
          <div class="col-6">
            <h2>Oops.... </h2>
            <h3>Page  not found </h3>
            <p>This Page doesn`t exist or was removed!<br>We suggest you  back to home.</p>
            <a href="/" class="btn btn-primary">Back to home</a>
          </div>
          <div class="col-6">
            <img src="<?php echo get_stylesheet_directory_uri() ?>/images/404.png" class="img-fluid" alt="">
          </div>
        </div>
      </div>
    </div>

<?php 
get_footer();