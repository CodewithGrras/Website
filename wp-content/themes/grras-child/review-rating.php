<?php

/**
 * Template Name: Review Rating
 */
get_header();
?>


<!-- tech mid bg -->
<div class="techbg">
    <div class="teachcareer">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <h2 class="text-center"><?php echo get_field('tech_title') ?></h2>
                </div>

                <?php if (have_rows('tech_career')):
                    while (have_rows('tech_career')): the_row();
                        $percentage_and_lpa = get_sub_field('percentage_and_lpa');
                        $title = get_sub_field('title');
                        $icon = get_sub_field('icon');
                ?>
                        <div class="col-lg-3 col-sm-6 col-6">
                            <div class="lpabox">
                                <?php if ($icon): ?>
                                    <img src="<?php echo esc_url($icon); ?>" alt="<?php echo esc_attr($title); ?>">
                                <?php endif; ?>
                                <p><?php echo esc_html($percentage_and_lpa); ?><br><?php echo esc_html($title); ?></p>
                            </div>
                        </div>
                <?php endwhile;
                endif; ?>
            </div>
        </div>
    </div>
    <?php

    include 'components/voices.php';
    ?>
</div>

<!-- Let’s Rate GRRAS! -->
<?php
$rating_form = get_field('rating_form');
?>
<div class="letsrate">
    <div class="container">
        <div class="row justify-content-between">
            <div class="col-lg-5">
                <img src="<?php echo $rating_form["image"] ?>" class="img-fluid" alt="">
            </div>
            <div class="col-lg-6">
                <h2><?php echo esc_html($rating_form["title"]) ?></h2>
                <h4><?php echo esc_html($rating_form["short_description"]) ?></h4>

               <?php echo do_shortcode('[gravityform id="16" title="false"]') ?>


            </div>
        </div>
    </div>
</div>
<Style>
    .gform-theme--framework .gfield--type-choice .gfield_checkbox, .gform-theme--framework .gfield--type-choice .gfield_radio {

     flex-direction: row!important; 

}
</Style>

<?php include 'components/faq.php' ?>

<?php
get_footer();
