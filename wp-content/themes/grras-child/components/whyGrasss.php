<!-- Why grras -->
 
<div class="whygrras wow fadeInLeft">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2><?php
                    $why_grras = get_field("why_grras",'option');
                    $certificate = get_field("certificate");
                    $work_shop = get_field("work_shop");
                    echo $why_grras["title"];
                    ?></h2>
                <div class="subtext"><?php echo $why_grras["short_description"]; ?></div>
            </div>
            
                    <?php if (have_rows('icons','option')): ?>
            <div class="col-md-6">
                <ul>
                        <?php while (have_rows('icons','option')): the_row(); ?>
                            <li><img src="<?php echo get_sub_field('icon'); ?>" alt=""></li>
                        <?php endwhile; ?>
                </ul>
            </div>
                    <?php endif; ?>
        </div>
        <div class="row">
            <div class="col-md-3">
            <div class="imgbox">
              <iframe width="100%" height="454" src="<?php echo $why_grras['video_url'] ?>" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen=""></iframe>
            </div>
          </div>
            <!--<div class="col-md-3">-->
            <!--    <div class="imgbox">-->
            <!--        <div class="play"><a href="#exampleModal" data-bs-toggle="modal" data-bs-target="#exampleModal"><img src="<?php echo get_stylesheet_directory_uri() ?>/images/why-play.png" alt=""></a></div>-->
            <!--        <img src="<?php echo $why_grras['image']; ?>" class="img-fluid" alt="">-->
            <!--    </div>-->
            <!--</div>-->
            <div class="col-md-9">
                <div class="row">
                    <?php if (have_rows('opportunities','option')): ?>
                        <?php while (have_rows('opportunities','option')): the_row(); ?>
                             <?php
                            $full_text = get_sub_field('short_description');
                            $short_text = mb_substr($full_text, 0, 100);
                            $is_long = mb_strlen($full_text) > 100;

                            ?>
                            <div class="col-lg-4 col-md-6 col-6 g-3">
                                <div class="iconbox">
                                    <img src="<?php echo get_sub_field('icon'); ?>" alt="">
                                    <h4><?php echo get_sub_field('title'); ?></h4>
                                    <div class="mb-1 readmoretext">
                                        <span class="short-text"><?php echo wp_kses_post($short_text); ?></span>
                                        <?php if ($is_long): ?>
                                            <span class="dots">...</span>
                                            <span class="more-text d-none"><?php echo wp_kses_post(mb_substr($full_text, 100)); ?></span>
                                            <a href="javascript:void(0);" class="theme-text-primary fw-semibold text-decoration-none toggle-more">Read more</a>
                                        <?php endif; ?>
                                        </div>
                                </div>
                            </div>
                        <?php endwhile; ?>
                    <?php endif; ?>


                </div>
            </div>
        </div>

    </div>
</div>
<!--<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">-->
<!--    <div class="modal-dialog">-->
<!--        <div class="modal-content">-->
<!--            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>-->
<!--            <div class="modal-body">-->
<!--                <iframe width="100%" height="315" src="<?php echo get_field('video_url','option') ?>" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>-->
<!--            </div>-->
<!--        </div>-->
<!--    </div>-->
<!--</div>-->