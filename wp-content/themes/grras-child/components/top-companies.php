      <?php $id = get_the_ID(); ?>
  <div class="<?php echo ($id == 16765 ? 'container-fluid wow fadeInUp' : 'container wow fadeInLeft'); ?>">
     <div class="<?php echo ($id == 16765 ? 'cologo homecologo talentbox' : 'cologo'); ?>">
<?php echo get_field('top_company_heading', 'options'); ?>
        <div class="owl-carousel top-company owl-loaded owl-drag">
          <?php if (have_rows('top_companies')): ?>
                <?php while (have_rows('top_companies')): the_row(); ?>
                    <div class="item"><img src="<?php echo get_sub_field('image'); ?>" class="img-fluid" alt=""></div>
                <?php endwhile; ?>
                <?php else:
                while (have_rows('top_companies', 'option')): the_row(); ?>
                    <div class="item"><img src="<?php echo get_sub_field('image'); ?>" class="img-fluid" alt=""></div>
                <?php endwhile; ?>
            <?php endif; ?>
        </div>
      </div>
    </div>