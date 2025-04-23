  <div class="container wow fadeInLeft">
    <div class="available">
      <h2><?php echo get_field("learning_modes_heading",'option') ?></h2>
      <ul>
        <?php 
if( have_rows('learning_modes_repeater','option') ):

    // Loop through rows.
    while( have_rows('learning_modes_repeater','option') ) : the_row();
        ?>
        <li>
          <div class="icon"><img src="<?php echo get_sub_field('image'); ?>" class="img-fluid" alt=""></div>
          <h5><?php echo get_sub_field('title') ?></h5>
        </li>
       
        <?php
endwhile;
endif;
?>
        
      </ul>
    </div>
  </div>
