  <?php
  $banner = get_field('banner','17246');
  ?>
   <style>
       
   .coursebanner {
 
    background: url(<?php echo $banner['background_image'] ?>) no-repeat center center;
}
   </style>
    <div class="coursebanner">
      <div class="container">
        <div class="row d-flex align-items-center justify-content-between">
          <div class="col-lg-7">
            <h1><?php 
            
            echo $banner['title'];
            ?><span><?php echo $banner['sub_title'] ?></span></h1>
            <p><?php echo $banner['short_description'] ?></p>
          </div>
          <div class="col-lg-4">
            <img src="<?php echo $banner['image'] ?>" class="img-fluid d-none d-sm-block" alt="">
          </div>
        </div>
      </div>
    </div>
