 <div class="container wow fadeInUp">
    <div class="buildicon">
      <div class="row">
        <?php
        if (have_rows('stack','option')):
          while (have_rows('stack','option')): the_row();
        ?>
            <div class="col-lg-3 col-md-3 g-2 col">
              <div class="iconbox">
                <img src="<?php echo get_sub_field('icon') ?>" alt="">
                <p><?php echo get_sub_field('title') ?></p>
              </div>
            </div>


        <?php
          endwhile;

        endif;
        ?>

      </div>
    </div>
  </div>