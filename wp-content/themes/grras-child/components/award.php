<div class="award wow fadeInUp">

  <div class="container">

    <h2 class="text-center mb-lg-3">

        <?php 

        if(get_field('award_title')):

        echo get_field('award_title');

        else:

            echo "Awards & Recognition";

        endif;

        ?>

        </h2>

    <div class="owl-carousel award-reco">

      <?php if (have_rows('awards_&_recognition','option')) : ?>

        <?php while (have_rows('awards_&_recognition','option')): the_row();

          $title = get_sub_field('title'); // Adjust this to match your subfield name

          $sub_text = get_sub_field('sub_text'); // Adjust this to match your subfield name

          $icon = get_sub_field('image'); // Adjust this to match your subfield name

        ?>

          <div class="item">

            <div class="cousebox">

              <a href="<?php echo site_url('aboutus?tab=awardsection'); ?>" class="text-decoration-none">
                  <img src="<?php echo $icon ?>" class="img-fluid" alt="">
    
                  <?php echo $title; ?>
    
                  <p><?php echo $sub_text; ?></p>
              </a>

            </div>

          </div>

        <?php endwhile; ?>

      <?php endif; ?>

    </div>

  </div>

</div>