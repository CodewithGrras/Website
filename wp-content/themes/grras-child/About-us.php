<?php

/**
 * Template Name: About Us
 * 
 *  */
get_header();
$banner = get_field('banner');
$mobile_banner = get_field('mobile_banner');
$what_is_grras = get_field('what_is_grras');
$join_india = get_field('join_india');
$partner_with_us = get_field('partner_with_us');
?>
<!-- job ready banner -->
<!--<div class="aboubanner wow fadeInUp">
    <h2><?php //echo $banner["title"] ?></h2>
    <img src="<?php //echo $banner["image"] ?>" class="img-fluid d-none d-sm-block" alt="">
    <img src="<?php //echo $mobile_banner["image"] ?>" class="img-fluid d-block d-sm-none" alt="">
</div>-->
<div class="aboubanner wow fadeInUp">    
    <div class="owl-carousel about-banner">
        <?php 
        if(have_rows('banner')):
            while(have_rows('banner')): the_row();
        ?>
        <div class="item">
          <h2><?php echo get_sub_field("title") ?></h2>
          <img src="<?php echo get_sub_field("image"); ?>" class="img-fluid d-none d-sm-block" alt="">
          <img src="<?php echo get_sub_field("mobile_image"); ?>" class="img-fluid d-block d-sm-none" alt="">
        </div>
      <?php
        endwhile;
      endif;
      ?>
    </div>
</div>


<!-- what is grass -->
<div class="whatgrass">
    <div class="container">
        <div class="row justify-content-between align-items-center">
            <div class="col-lg-6 wow fadeInLeft">
                <h2><?php echo $what_is_grras["title"] ?></h2>
                <p><?php echo $what_is_grras["description"] ?></p>
                <div class="row">
                    <?php if (have_rows('grass_points')): ?>
                        <?php while (have_rows('grass_points')): the_row();
                        ?>
                            <div class="col-md-4 col">
                                <div class="whatexp">
                                    <img src="<?php echo get_sub_field('icon') ?>" alt="">
                                    <div class="subtext"><?php echo get_sub_field('title') ?></div>
                                </div>
                            </div>
                        <?php endwhile; ?>

                    <?php endif; ?>
                </div>
            </div>
            <div class="col-lg-5 wow fadeInLeft">
            <div class="aboutvideo"><iframe width="100%" height="315" src="<?php echo $what_is_grras['video_url']?>" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen=""></iframe></div>
          </div>
            <!--<div class="col-lg-5 wow fadeInLeft">-->
            <!--    <div class="aboutvideo">-->
            <!--        <img src="<?php echo $what_is_grras["image"] ?>" class="img-fluid" alt="">-->
            <!--    </div>-->
            <!--</div>-->
        </div>
    </div>
</div>

<!-- join india -->
<div class="joinindia wow fadeInUp">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-5">
                <h2><?php echo $join_india["title"] ?></h2>
                <div class="subtext"><?php echo $join_india["sub_title"] ?></div>
                <a href="<?php echo $join_india["learn_more"] ?>" class="btn btn-primary">Learn More</a>
            </div>
            <div class="col-lg-7">
                <ul>
                    <?php if (have_rows('join_india_points')): ?>

                        <?php while (have_rows('join_india_points')): the_row();
                        ?>

                            <li>
                                <img src="<?php echo get_sub_field('icon'); ?>" class="img-fluid" alt="">
                                <div class="content">
                                    <h4><?php echo get_sub_field('title'); ?></h4>
                                    <p><?php echo get_sub_field('deacription'); ?></p>
                                </div>
                            </li>
                        <?php endwhile; ?>

                    <?php endif; ?>

                </ul>
            </div>
        </div>
    </div>
</div>

<!-- Board of Directors Profile -->
<div class="boardof wow fadeInLeft">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h2 class="text-center"><?php echo get_field('directors_profile_title') ?></h2>
            </div>
            <?php if (have_rows('board_of_directors')): ?>

                <?php while (have_rows('board_of_directors')): the_row();
                ?>
                    <div class="col-lg-3 col-md-6 col-6 g-3">
                        <div class="bordbox">
                            <div class="imgbox"><img src="<?php echo get_sub_field('image'); ?>" class="img-fluid" alt=""></div>
                            <h4>
                                <a href="<?php echo get_sub_field('linkedinlink') ?>" target="_blank" style="text-decoration:none;">
                                <img src="<?php echo get_sub_field('icon'); ?>" alt=""> <span><?php echo get_sub_field('name'); ?></span>
                                </a>
                                </h4>
                            <p><?php echo get_sub_field('short_description'); ?></p>
                        </div>
                    </div>
                <?php endwhile; ?>

            <?php endif; ?>
        </div>
    </div>
</div>

<!-- What we do -->
<?php if (have_rows('what_we_do')):
    $i = 1;
    while (have_rows('what_we_do')): the_row();
        $i++;
        if ($i % 2 == 0):
?>
            <div class="whatdo wow fadeInLeft">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-5">
                            <div class="d-none d-lg-block"><img src="<?php echo get_sub_field('image'); ?>" class="img-fluid rounded" alt=""></div>
                            
                        </div>
                        <div class="col-lg-7">
                            <h2><?php echo get_sub_field('title'); ?></h2>
                            <div class="my-3 d-block d-lg-none"><img src="<?php echo get_sub_field('image'); ?>" class="img-fluid rounded" alt=""> </div>
                            <div class="custom_contant" style="display: -webkit-box;"><?php echo wpautop(get_sub_field('content')); ?></div>
                             <div class="my-1 text-left-ms" style="     text-align: left;">
        <a href="javascript:void(0)" class="link-primary hide_custom "style="    color: #ef7220;
    font-weight: bold;
    text-decoration: none;" >Read More</a>
        </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php
        else:
        ?>
            <!-- Why do we do ? -->
            <div class="whydo wow fadeInRight">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-7">
                            <h2><?php echo get_sub_field('title'); ?></h2>
                            <?php echo wpautop(get_sub_field('content')); ?>
                        </div>
                        <div class="col-lg-5">
                            <img src="<?php echo get_sub_field('image'); ?>" class="img-fluid rounded" alt="">
                        </div>
                    </div>
                </div>
            </div>
    <?php
        endif;
    endwhile; ?>
<?php endif; ?>

<!-- The Grras’s way to Transform your Career -->
<div class="thegrras">
    <div class="container">
        <div class="col-lg-12">
            <h2 class="text-center">The Grras’s way to Transform your Career</h2>
        </div>
        <?php if (have_rows('the_grras’s_way')):
            $i = 0;
            while (have_rows('the_grras’s_way')): the_row();
                $i++;

        ?>
                <div class="row gap-6 wow <?php
                                    if ($i == 1) {
                                        echo 'fadeInLeft';
                                    } elseif ($i == 2) {
                                        echo 'fadeInRight';
                                    } elseif ($i == 3) {
                                        echo 'fadeInLeft ';
                                    } else {
                                        echo 'fadeInRight'; // If $i is something other than 1, 2, or 3, leave empty.
                                    }
                                    ?>">
                    <div class="col-lg-6 
                    <?php
                    if ($i == 1) {
                        echo '';
                    } elseif ($i == 2) {
                        echo 'order-lg-2';
                    } elseif ($i == 3) {
                        echo '';
                    } else {
                        echo 'order-lg-2'; // If $i is something other than 1, 2, or 3, leave empty.
                    }
                    ?>
                    ">
                        <div class="<?php
                                    if ($i == 1) {
                                        echo 'grrasred';
                                    } elseif ($i == 2) {
                                        echo 'grrasco';
                                    } elseif ($i == 3) {
                                        echo 'grrasind';
                                    } else {
                                        echo 'grrasred'; // If $i is something other than 1, 2, or 3, leave empty.
                                    }
                                    ?>">
                            <iframe width="100%" height="290" src="<?php echo get_sub_field('video_link'); ?>" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <h4 class="<?php
                                    if ($i == 1) {
                                        echo 'gred';
                                    } elseif ($i == 2) {
                                        echo 'gco';
                                    } elseif ($i == 3) {
                                        echo 'gind';
                                    } else {
                                        echo 'gred'; // If $i is something other than 1, 2, or 3, leave empty.
                                    }
                                    ?>">
                            <?php echo get_sub_field('title'); ?>
                        </h4>
                       <div class="custom_contant" style="display: -webkit-box;"> <?php echo wpautop(get_sub_field('content')); ?></div>
                         <div class="my-1 text-left-ms" style="     text-align: left;">
        <a href="javascript:void(0)" class="link-primary hide_custom "style="    color: #ef7220;
    font-weight: bold;
    text-decoration: none;" >Read More</a>
        </div>
                    </div>
                </div>

            <?php
            endwhile; ?>

        <?php endif; ?>



    </div>
</div>

<!-- hire us -->
<div class="endcareer wow fadeInUp">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <h2><?php echo get_field('career_solutions_title') ?> </h2>
            </div>
            <?php if (have_rows('career_solutions')): ?>
                <?php while (have_rows('career_solutions')): the_row();
                ?>
                    <div class="col-lg-4 col-sm-6 col-6 g-3">
                        <div class="contbox">
                            <img src="<?php echo get_sub_field('icon') ?>" alt="">
                            <h4><?php echo get_sub_field('title') ?></h4>
                            <p><?php echo get_sub_field('description'); ?></p>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Partner with Us -->
<div class="container wow fadeInUp">
    <div class="partnerwith m-0">
        <div class="row d-flex align-items-center">
            <div class="col-lg-4">
                <h2><?php echo $partner_with_us["title"]; ?></h2>
                <a href="<?php echo $partner_with_us["apply_url"]; ?>" class="btn btn-dark d-none d-md-block">apply now</a>
            </div>
            <div class="col-lg-8">
                <p><?php echo $partner_with_us["description"]; ?></p>
                <a href="<?php echo $partner_with_us["apply_url"]; ?>" class="btn btn-dark d-block d-md-none mt-3">apply now</a>
            </div>
        </div>
    </div>
</div>


    <?php
    include "components/award.php";
    include "components/faq.php";
    get_footer();
