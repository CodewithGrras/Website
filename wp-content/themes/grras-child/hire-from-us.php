<?php



/**

 * Template Name: Hire From Us

 */

get_header();

$banner = get_field('banner');

$candidates = get_field('candidates');



?>

<!-- job ready banner -->

<div class="jobready pb-0">

    <div class="container">

        <div class="row">

            <div class="col-lg-6 relative">

                <h2><?php echo $banner["title"] ?> <br><span><?php echo $banner["sub_title"] ?></span></h2>

                <div class="imgbox"><img src="<?php echo $banner["image"] ?>" class="img-fluid" alt=""></div>

            </div>

            <div class="col-lg-6">

                <style>

                    div#gform_confirmation_message_4 {

    color: blac !important

}

                </style>

                <div class="formbox">

                    <h3><?php echo $banner["form_heading"] ?> <span><?php echo $banner["form_sub_heading"] ?> </span></h3>

                   <?php echo do_shortcode('[gravityform id="4" title="false" ajax="true"]') ?>

                  

                </div>

            </div>

        </div>

    </div>

</div>

<!-- work detail -->

<div class="getjob">

    <div class="container">

        <div class="row justify-content-center">

            <div class="col-lg-10 text-center">

                <h2><?php echo $candidates["title"] ?> </h2>

                <div class="subtext"><?php echo $candidates["description"] ?></div>

            </div>

            <div class="col-lg-12">

                <ul>

                    <?php if (have_rows('skill_set')): ?>

                        <?php while (have_rows('skill_set')): the_row(); ?>

                            <li>

                                <img src="<?php echo get_sub_field('icon') ?>" alt="">

                                <p><?php echo get_sub_field('title') ?></p>

                            </li>

                        <?php endwhile; ?>

                    <?php endif; ?>

                </ul>

            </div>

        </div>

    </div>

</div>

<!-- hire us -->

<div class="whyhire">

    <div class="container">

        <div class="row">

            <div class="col-lg-12 text-center">

                <h2><?php echo get_field('why_hire_title') ?></h2>

            </div>

            <?php if (have_rows('why_hire')): ?>

                <?php while (have_rows('why_hire')): the_row(); ?>

                    <div class="col-lg-3 col-sm-6 col-6 g-3">

                        <div class="whycont">

                        <div class="iconbox"><img src="<?php echo get_sub_field("icon"); ?>" class="img-fluid" alt=""></div>

                        <h4><?php echo get_sub_field("title"); ?></h4>

                        <?php echo get_sub_field("content"); ?>

                        <a href="javascript:void(0);" class="theme-text-primary fw-semibold text-decoration-none toggle-more">Read More</a>

                        </div>

                    </div>

                <?php endwhile; ?>

            <?php endif; ?>

        </div>

    </div>

</div>

<!-- Where Our Alumni Work -->

<div class="ourwork">

    <div class="container">

        <h2><?php echo get_field('alumni_work_title'); ?></h2>

        <ul>

            <?php if (have_rows('where_our_alumni_work')): ?>

                <?php while (have_rows('where_our_alumni_work')): the_row(); ?>

                    <li><img src="<?php echo get_sub_field("image"); ?>" class="img-fluid" alt=""></li>

                <?php endwhile; ?>

            <?php endif; ?>

        </ul>

        <div class="text-center"><a href="/contact-us/" class="btn btn-primary">Get in Touch</a></div>

    </div>

</div>

<!-- Hear from our Hiring Partners -->

<div class="hirepartner wow fadeInRight">

    <div class="container">

        <div class="text-center">

            <h2><?php echo get_field('hiring_partners_title'); ?></h2>

        </div>

        <div class="owl-carousel hire-partner">

            <?php if (have_rows('hear_from_our_hiring_partners')): ?>

                <?php while (have_rows('hear_from_our_hiring_partners')): the_row(); ?>

                    <div class="item">

                        <div class="content">
                            <div class="d-flex align-items-center">
                            <div class="imgbox me-2"><img src="<?php echo get_sub_field("image"); ?>" class="img-fluid" alt=""></div>
                            <div>
                            <h4><?php echo get_sub_field("title"); ?></h4>

                            <div class="degtext"><?php echo get_sub_field("position"); ?></div>
                            </div>
                            </div>

                            <p><?php echo get_sub_field("description"); ?></p>

                        </div>

                    </div>

                <?php endwhile; ?>

            <?php endif; ?>

        </div>

    </div>

</div>

<?php

include 'components/faq.php';

get_footer();

