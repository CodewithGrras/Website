<?php
?>
  <div class="ourhire wow fadeInUp" id="placement" data-anchor="placement">
    <div class="container">
      <div class="whbox">
        <h2>Our Hiring Partners</h2>

        <div class="owl-carousel ourpartner">
<?php 
if (have_rows('our_hiring_partners', 'option')):
    while (have_rows('our_hiring_partners', 'option')): the_row();
?>

<div class="item">
    <div class="imgbox">
        <img src="<?php echo esc_url(get_sub_field('image')); ?>" alt="">
    </div>
</div>

<?php 
    endwhile;
endif;
?>

        </div>

      </div>
    </div>
  </div>
