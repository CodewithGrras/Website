<?php

/**
 * Template Name: About Us Template
 *
 *  */
get_header();
$banner = get_field('banner');
$mobile_banner = get_field('mobile_banner');
$what_is_grras = get_field('what_is_grras');
$join_india = get_field('join_india');
$partner_with_us = get_field('partner_with_us');
?>

<!-- contact form -->
<div class="contactform refer-section image-position-right position-relative wow fadeInUp bg-theme-light section-padding overflow-hidden">
    <div class="container">
        <div class="row">
            <div class="col-12 col-md-7 wow fadeInLeft">
                <div class="banner-content">
                    <h1 class="fw-bold mb-3">
                        <?php the_field("left_section_heading"); ?>
                    </h1>

                    <p>
                        <?php the_field("left_section_description"); ?>
                    </p>

                    <?php if (have_rows("left_section_industry_tags")): ?>
                        <ul class="list-unstyled mb-0 banner-tags">
                            <?php while (
                                have_rows("left_section_industry_tags")
                            ):
                                the_row(); ?>
                                <li>#<?php the_sub_field("tag"); ?></li>
                            <?php
                            endwhile; ?>
                        </ul>
                    <?php endif; ?>

                    <hr class="w-75"/>

                    <?php
                    $button_label = get_field(
                        "left_section_download_button_label"
                    );
                    $button_file = get_field(
                        "left_section_download_button_file"
                    );
                    $button_file_url = $button_file
                        ? wp_get_attachment_url($button_file)
                        : "";
                    if ($button_label && $button_file_url): ?>
                    <a href="<?php echo esc_url(
                        $button_file_url
                    ); ?>" class="align-items-center btn btn-primary btn-sm btnwith-icon-sm d-inline-flex justify-content-center p-2 rounded-2 text-center" download>
                        <span class="pe-3 ps-2"><?php echo esc_html(
                            $button_label
                        ); ?></span>
                        <span class="btn-icon d-inline-flex justify-content-center align-items-center rounded-1 bg-white">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20px" height="20px" viewBox="0 0 23 23" fill="none">
                                <path d="M6.21305 7.32844V6.23463C6.23791 5.76231 6.6108 5.38942 7.05827 5.38942L16.7285 5.36456C17.2008 5.38942 17.5737 5.76231 17.5737 6.20977V15.9049C17.5737 16.3523 17.2008 16.7252 16.7285 16.7501H15.6347C15.1624 16.7252 14.7895 16.3523 14.7646 15.88L14.9138 10.0132L7.77919 17.1478C7.43116 17.4959 6.93397 17.4959 6.58594 17.1478L5.79045 16.3523C5.46728 16.0292 5.44242 15.5071 5.79045 15.1591L12.925 8.0245L7.08313 8.19851C6.6108 8.17365 6.21305 7.82563 6.21305 7.32844Z" fill="black"/>
                            </svg>
                        </span>
                    </a>
                    <?php endif;
                    ?>
                </div>
            </div>

            <div class="col-12 col-md-5 position-relative">
                <div class="aboutvideo position-relative">
                    <?php
                    $iframe_code = get_field("right_section_youtube_iframe");
                    if ($iframe_code):
                        echo $iframe_code; // already contains iframe
                    endif;
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="container position-relative ">
    
    <div class="mobildbtn position-relative d-lg-none p-0">
    <button id="prevBtn" type="button" class="px-2 bg-white p-0 border-0 position-absolute">
        <svg xmlns="http://www.w3.org/2000/svg" width="9" height="16" viewBox="0 0 9 16" fill="none">
        <path d="M8.99923 13.7422L7.37989 15.5L0.470703 8L7.37989 0.5L8.99923 2.25781L3.70938 8L8.99923 13.7422Z" fill="#EF7220"/>
        </svg>
    </button>
    <div class="mobildbtn position-relative d-lg-none p-0">
        <button id="nextBtn" type="button" class="px-2 bg-white p-0 border-0 position-absolute">
        <svg xmlns="http://www.w3.org/2000/svg" width="9" height="16" viewBox="0 0 9 16" fill="none">
            <path d="M0.000768682 13.7422L1.62011 15.5L8.5293 8L1.62011 0.5L0.000768819 2.25781L5.29062 8L0.000768682 13.7422Z" fill="#EF7220"/>
        </svg>
        </button>
    </div>
    </div>
    <ul id="menu" class="menu list-unstyled mb-0 bg-white p-2 d-flex position-relative justify-content-center">
    <li class="menu-item <?php echo (isset($_GET['tab']) ? $_GET['tab'] === 'overviewsection' : true) ? 'active' : ''; ?>" data-target="overviewsection" >Overview</li>
    <li class="menu-item <?php echo (isset($_GET['tab']) ? $_GET['tab'] === 'solutionsection' : true) ? 'active' : ''; ?>" data-target="solutionsection">Our Solutions</li>
    <li class="menu-item <?php echo (isset($_GET['tab']) ? $_GET['tab'] === 'partnerssection' : true) ? 'active' : ''; ?>" data-target="partnerssection">Our Partners</li>
    <li class="menu-item <?php echo (isset($_GET['tab']) ? $_GET['tab'] === 'industrysection' : true) ? 'active' : ''; ?>" data-target="industrysection">Industry Certification</li>
    <li class="menu-item <?php echo (isset($_GET['tab']) ? $_GET['tab'] === 'awardsection' : true) ? 'active' : ''; ?>"  data-target="awardsection">Awards & Recognitions</li>
    <li class="menu-item <?php echo (isset($_GET['tab']) ? $_GET['tab'] === 'eventssection' : true) ? 'active' : ''; ?>" data-target="eventssection">Events</li>
    </ul>
</div>

<div class="menu-area">
    <div id="overviewsection" class="contentarea <?php echo (isset($_GET['tab']) ? $_GET['tab'] === 'overviewsection' : true) ? 'active' : ''; ?>">

<!-- what is grass -->
<div class="whatgrass">
    <div class="container">
        <div class="row justify-content-between align-items-center">
            <div class="col-lg-6 wow fadeInLeft">
                <h2><?php echo $what_is_grras["title"]; ?></h2>
                <p><?php echo $what_is_grras["description"]; ?></p>
                <div class="row">
                    <?php if (have_rows("grass_points")): ?>
                        <?php while (have_rows("grass_points")):
                            the_row(); ?>
                            <div class="col-md-4 col">
                                <div class="whatexp">
                                    <img src="<?php echo get_sub_field(
                                        "icon"
                                    ); ?>" alt="">
                                    <div class="subtext"><?php echo get_sub_field(
                                        "title"
                                    ); ?></div>
                                </div>
                            </div>
                        <?php
                        endwhile; ?>

                    <?php endif; ?>
                </div>
            </div>
            <div class="col-lg-5 wow fadeInLeft">
            <div class="aboutvideo"><iframe width="100%" height="315" src="<?php echo $what_is_grras[
                "video_url"
            ]; ?>" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen=""></iframe></div>
          </div>
            <!--<div class="col-lg-5 wow fadeInLeft">-->
            <!--    <div class="aboutvideo">-->
            <!--        <img src="<?php echo $what_is_grras[
                "image"
            ]; ?>" class="img-fluid" alt="">-->
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
                <h2><?php echo $join_india["title"]; ?></h2>
                <div class="subtext"><?php echo $join_india[
                    "sub_title"
                ]; ?></div>
                <a href="<?php echo $join_india[
                    "learn_more"
                ]; ?>" class="btn btn-primary">Learn More</a>
            </div>
            <div class="col-lg-7">
                <ul>
                    <?php if (have_rows("join_india_points")): ?>

                        <?php while (have_rows("join_india_points")):
                            the_row(); ?>

                            <li>
                                <img src="<?php echo get_sub_field(
                                    "icon"
                                ); ?>" class="img-fluid" alt="">
                                <div class="content">
                                    <h4><?php echo get_sub_field(
                                        "title"
                                    ); ?></h4>
                                    <p><?php echo get_sub_field(
                                        "deacription"
                                    ); ?></p>
                                </div>
                            </li>
                        <?php
                        endwhile; ?>

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
                <h2 class="text-center"><?php echo get_field(
                    "directors_profile_title"
                ); ?></h2>
            </div>
            <?php if (have_rows("board_of_directors")): ?>

                <?php while (have_rows("board_of_directors")):
                    the_row(); ?>
                    <div class="col-lg-3 col-md-6 col-6 g-3">
                        <div class="bordbox">
                            <div class="imgbox"><img src="<?php echo get_sub_field(
                                "image"
                            ); ?>" class="img-fluid" alt=""></div>
                            <h4>
                                <a href="<?php echo get_sub_field(
                                    "linkedinlink"
                                ); ?>" target="_blank" style="text-decoration:none;">
                                <img src="<?php echo get_sub_field(
                                    "icon"
                                ); ?>" alt=""> <span><?php echo get_sub_field(
    "name"
); ?></span>
                                </a>
                                </h4>
                            <p><?php echo get_sub_field(
                                "short_description"
                            ); ?></p>
                        </div>
                    </div>
                <?php
                endwhile; ?>

            <?php endif; ?>
        </div>
    </div>
</div>
        <!-- What we do -->
<?php if (have_rows("what_we_do")):

    $i = 1;
    while (have_rows("what_we_do")):
        the_row();
        $i++;
        if ($i % 2 == 0): ?>
            <div class="whatdo wow fadeInLeft">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-5">
                            <div class="d-none d-lg-block"><img src="<?php echo get_sub_field(
                                "image"
                            ); ?>" class="img-fluid rounded" alt=""></div>
                            
                        </div>
                        <div class="col-lg-7">
                            <h2><?php echo get_sub_field("title"); ?></h2>
                            <div class="my-3 d-block d-lg-none"><img src="<?php echo get_sub_field(
                                "image"
                            ); ?>" class="img-fluid rounded" alt=""> </div>
                            <div class="custom_contant" style="display: -webkit-box;"><?php echo wpautop(
                                get_sub_field("content")
                            ); ?></div>
                             <div class="my-1 text-left-ms" style="     text-align: left;">
        <a href="javascript:void(0)" class="link-primary hide_custom "style="    color: #ef7220;
    font-weight: bold;
    text-decoration: none;" >Read More</a>
        </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php else: ?>
            <!-- Why do we do ? -->
            <div class="whydo wow fadeInRight">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-7">
                            <h2><?php echo get_sub_field("title"); ?></h2>
                            <?php echo wpautop(get_sub_field("content")); ?>
                        </div>
                        <div class="col-lg-5">
                            <img src="<?php echo get_sub_field(
                                "image"
                            ); ?>" class="img-fluid rounded" alt="">
                        </div>
                    </div>
                </div>
            </div>
    <?php endif;
    endwhile;
    ?>
<?php
endif; ?>

<!-- The Grras’s way to Transform your Career -->
<div class="thegrras">
    <div class="container">
        <div class="col-lg-12">
            <h2 class="text-center">The Grras’s way to Transform your Career</h2>
        </div>
        <?php if (have_rows("the_grras’s_way")):

            $i = 0;
            while (have_rows("the_grras’s_way")):

                the_row();
                $i++;
                ?>
                <div class="row gap-6 wow <?php if ($i == 1) {
                    echo "fadeInLeft";
                } elseif ($i == 2) {
                    echo "fadeInRight";
                } elseif ($i == 3) {
                    echo "fadeInLeft ";
                } else {
                    echo "fadeInRight"; // If $i is something other than 1, 2, or 3, leave empty.
                } ?>">
                    <div class="col-lg-6 
                    <?php if ($i == 1) {
                        echo "";
                    } elseif ($i == 2) {
                        echo "order-lg-2";
                    } elseif ($i == 3) {
                        echo "";
                    } else {
                        echo "order-lg-2"; // If $i is something other than 1, 2, or 3, leave empty.
                    } ?>
                    ">
                        <div class="<?php if ($i == 1) {
                            echo "grrasred";
                        } elseif ($i == 2) {
                            echo "grrasco";
                        } elseif ($i == 3) {
                            echo "grrasind";
                        } else {
                            echo "grrasred"; // If $i is something other than 1, 2, or 3, leave empty.
                        } ?>">
                            <iframe width="100%" height="290" src="<?php echo get_sub_field(
                                "video_link"
                            ); ?>" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <h4 class="<?php if ($i == 1) {
                            echo "gred";
                        } elseif ($i == 2) {
                            echo "gco";
                        } elseif ($i == 3) {
                            echo "gind";
                        } else {
                            echo "gred"; // If $i is something other than 1, 2, or 3, leave empty.
                        } ?>">
                            <?php echo get_sub_field("title"); ?>
                        </h4>
                       <div class="custom_contant" style="display: -webkit-box;"> <?php echo wpautop(
                           get_sub_field("content")
                       ); ?></div>
                         <div class="my-1 text-left-ms" style="     text-align: left;">
        <a href="javascript:void(0)" class="link-primary hide_custom "style="    color: #ef7220;
    font-weight: bold;
    text-decoration: none;" >Read More</a>
        </div>
                    </div>
                </div>

            <?php
            endwhile;
            ?>

        <?php
        endif; ?>



    </div>
</div>

<!-- hire us -->
<div class="endcareer wow fadeInUp">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <h2><?php echo get_field("career_solutions_title"); ?> </h2>
            </div>
            <?php if (have_rows("career_solutions")): ?>
                <?php while (have_rows("career_solutions")):
                    the_row(); ?>
                    <div class="col-lg-4 col-sm-6 col-6 g-3">
                        <div class="contbox">
                            <img src="<?php echo get_sub_field(
                                "icon"
                            ); ?>" alt="">
                            <h4><?php echo get_sub_field("title"); ?></h4>
                            <p><?php echo get_sub_field("description"); ?></p>
                        </div>
                    </div>
                <?php
                endwhile; ?>
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
                <a href="<?php echo $partner_with_us[
                    "apply_url"
                ]; ?>" class="btn btn-dark d-none d-md-block">apply now</a>
            </div>
            <div class="col-lg-8">
                <p><?php echo $partner_with_us["description"]; ?></p>
                <a href="<?php echo $partner_with_us[
                    "apply_url"
                ]; ?>" class="btn btn-dark d-block d-md-none mt-3">apply now</a>
            </div>
        </div>
    </div>
</div>

        <!-- Faq -->
        <section class="faqs">
        <div class="container wow fadeInUp">
            <div class="row justify-content-center">
            <div class="col-md-12">
                <h2>Frequently Asked Questions</h2>
            </div>
            </div>
            <!-- faqs -->
            <div class="row">
            <div class="col-md-8">
                <div class="accordion" id="accordionExample2">
                    <div class="accordion-item">
                    <h4 class="accordion-header" id="heading1">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse1" aria-expanded="false" aria-controls="collapse1">
                        Why Learn Full Stack Web Development?
                        </button>
                    </h4>
                    <div id="collapse1" class="accordion-collapse collapse" aria-labelledby="heading1" data-bs-parent="#accordionExample2">
                        <div class="accordion-body">
                        <p>You need to have successfully completed your 12th standard.</p>
                        </div>
                    </div>
                    </div>
                    <div class="accordion-item">
                    <h4 class="accordion-header" id="heading2">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse2" aria-expanded="false" aria-controls="collapse2">
                        What Does Full Stack Web Development Entail?
                        </button>
                    </h4>
                    <div id="collapse2" class="accordion-collapse collapse" aria-labelledby="heading2" data-bs-parent="#accordionExample2">
                        <div class="accordion-body">
                        <p>You need to have successfully completed your 12th standard.</p>
                        </div>
                    </div>
                    </div>
                    <div class="accordion-item">
                    <h4 class="accordion-header" id="heading3">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse3" aria-expanded="false" aria-controls="collapse3">
                        Is GRRAS Full Stack Web Development a Beginner-level Course?
                        </button>
                    </h4>
                    <div id="collapse3" class="accordion-collapse collapse" aria-labelledby="heading3" data-bs-parent="#accordionExample2">
                        <div class="accordion-body">
                        <p>You need to have successfully completed your 12th standard.</p>
                        </div>
                    </div>
                    </div>

                <div id="text">
                    <div class="accordion-item">
                    <h4 class="accordion-header" id="heading4">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse4" aria-expanded="false" aria-controls="collapse4">
                        Where will you be placed? 
                        </button>
                    </h4>
                    <div id="collapse4" class="accordion-collapse collapse" aria-labelledby="heading4" data-bs-parent="#accordionExample2">
                        <div class="accordion-body">
                        <p>You need to have successfully completed your 12th standard.</p>
                        </div>
                    </div>
                    </div>
                    <div class="accordion-item">
                    <h4 class="accordion-header" id="heading5">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse5" aria-expanded="false" aria-controls="collapse5">
                        Are there any tie ups with the companies? 
                        </button>
                    </h4>
                    <div id="collapse5" class="accordion-collapse collapse" aria-labelledby="heading5" data-bs-parent="#accordionExample2">
                        <div class="accordion-body">
                        <p>You need to have successfully completed your 12th standard.</p>
                        </div>
                    </div>
                    </div>
                    <div class="accordion-item">
                    <h4 class="accordion-header" id="heading6">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse6" aria-expanded="false" aria-controls="collapse6">
                        If you get placed, will your job will be permanent? 
                        </button>
                    </h4>
                    <div id="collapse6" class="accordion-collapse collapse" aria-labelledby="heading6" data-bs-parent="#accordionExample2">
                        <div class="accordion-body">
                        <p>You need to have successfully completed your 12th standard.</p>
                        </div>
                    </div>
                    </div>
                    <div class="accordion-item">
                    <h4 class="accordion-header" id="heading7">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse7" aria-expanded="false" aria-controls="collapse7">
                        What salary package you will get? 
                        </button>
                    </h4>
                    <div id="collapse7" class="accordion-collapse collapse" aria-labelledby="heading7" data-bs-parent="#accordionExample2">
                        <div class="accordion-body">
                        <p>You need to have successfully completed your 12th standard.</p>
                        </div>
                    </div>
                    </div>
                </div>

                <button id="toggle" class="btn btn-primary">Read More</button>
                </div>
            </div>
                <div class="col-md-4">
                <div class="morequestion">
                    More Questions<br>
                    <a href="#">Visit the learner help center</a>
                </div>
                <div class="havemore">
                    <h4>Have More Queries</h4>
                    <div class="subtext">If You're confused, which track to chose?</div>
                    <a href="#" class="btn btn-primary">Apply for Internship</a>
                </div>
                </div>
            </div>
        </div>
        </section>
    </div>
    <div id="solutionsection" class="contentarea <?php echo (isset($_GET['tab']) ? $_GET['tab'] === 'solutionsection' : true) ? 'active' : ''; ?>">
        <div class="container">
            <div class="heading-area text-center py-4 py-md-5">
                <h1 class="fw-bold">Your Career, Our <span class="theme-text-primary">Commitment</span></h1>
            </div>
            <div class="timeline">
                <?php
                $args = [
                    'post_type'      => 'our-solution',
                    'post_status'    => 'publish',
                    'posts_per_page' => -1,
                ];

                $query = new WP_Query($args);
                $index = 0;

                if ($query->have_posts()):
                    while ($query->have_posts()):
                        $query->the_post();
                        $index++;
                        $is_odd = $index % 2 !== 0;
                        $img_url = get_the_post_thumbnail_url(get_the_ID(), 'full');
                        $features = get_field('features'); // ACF repeater
                ?>
                    <div class="timeline-item pb-4">
                        <div class="row">
                            <?php if ($is_odd): ?>
                                <div class="col-12 col-md-6 order-2 order-md-1">
                                    <h2 class="mb-3"><?php the_title(); ?></h2>
                                    <p><?php echo get_the_content(); ?></p>
                                    <?php if ($features): ?>
                                        <h5>Key Features</h5>
                                        <ul class="list-unstyled">
                                            <?php foreach ($features as $feature): ?>
                                                <li>
                                                    <span>
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="15" height="11" fill="none"><path d="M5.15561 10.5982L0.686503 6.12911C0.41728..." fill="black"/></svg>
                                                    </span>
                                                    <span class="ms-2"><?php echo esc_html($feature['text']); ?></span>
                                                </li>
                                            <?php endforeach; ?>
                                        </ul>
                                    <?php endif; ?>
                                    <a href="javascript:void(0);" class="theme-text-primary text-decoration-none">
                                        <span class="me-1">Explore More</span>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="none"><rect y="0.5" width="25" height="24" rx="12" fill="#EF7221"/><path d="M15.5 6.74023L20.5..." stroke="white"/></svg>
                                    </a>
                                </div>
                                <div class="col-12 col-md-5 text-center ms-auto order-1 order-md-2">
                                    <?php if ($img_url): ?>
                                        <div class="timeline-image">
                                            <img src="<?php echo esc_url($img_url); ?>" class="img-fluid" />
                                        </div>
                                    <?php endif; ?>
                                </div>
                            <?php else: ?>
                                <div class="col-12 col-md-6 text-center pb-4 pb-md-0">
                                    <?php if ($img_url): ?>
                                        <div class="timeline-image">
                                            <img src="<?php echo esc_url($img_url); ?>" class="img-fluid" />
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <div class="col-12 col-md-5 ms-auto">
                                    <h2 class="mb-3"><?php the_title(); ?></h2>
                                    <p><?php echo get_the_content(); ?></p>
                                    <?php if ($features): ?>
                                        <h5>Key Features</h5>
                                        <ul class="list-unstyled">
                                            <?php foreach ($features as $feature): ?>
                                                <li>
                                                    <span>
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="15" height="11" fill="none"><path d="M5.15561 10.5982L0.686503 6.12911C0.41728..." fill="black"/></svg>
                                                    </span>
                                                    <span class="ms-2"><?php echo esc_html($feature['text']); ?></span>
                                                </li>
                                            <?php endforeach; ?>
                                        </ul>
                                    <?php endif; ?>
                                    <a href="javascript:void(0);" class="theme-text-primary text-decoration-none">
                                        <span class="me-1">Explore More</span>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="none"><rect y="0.5" width="25" height="24" rx="12" fill="#EF7221"/><path d="M15.5 6.74023L20.5..." stroke="white"/></svg>
                                    </a>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php
                endwhile;
                wp_reset_postdata();
                endif;
                ?>
            </div>
        </div>
    </div>
    <div id="partnerssection" class="contentarea <?php echo (isset($_GET['tab']) ? $_GET['tab'] === 'partnerssection' : true) ? 'active' : ''; ?>">

        <!-- Academic Partners Section -->
        <?php
        $academic_slug = 'academic-partner';
        $academic_total = get_total_partner_count($academic_slug);

        $academic_query = new WP_Query([
            'post_type'      => 'partners',
            'post_status'    => 'publish',
            'posts_per_page' => 8,
            'tax_query'      => [[
                'taxonomy' => 'partner-type',
                'field'    => 'slug',
                'terms'    => $academic_slug,
            ]],
        ]);
        ?>
        <div class="trackrecord partner-section wow fadeInLeft section-padding">
            <div class="container">
                <div class="row">
                    <div class="col-12 col-lg-12 mb-4">
                        <div class="heading-area text-center">
                            <h1 class="fw-bold">Academic Partners</h1>
                            <p class="theme-text-light">At Grras Solutions, we collaborate with 45+ academic institutions and industry leaders to ensure our programs align with real-world demands. By integrating professional training, certifications, and hands-on experiences, we empower students to excel in today’s competitive job market.</p>
                        </div>
                    </div>

                    <?php if ($academic_query->have_posts()): ?>
                        <?php while ($academic_query->have_posts()): $academic_query->the_post(); ?>
                            <div class="col-6 col-md-4 col-lg-3 col-xl-3 mb-4">
                                <div class="trackbox text-center p-4 border-0">
                                    <?php if (has_post_thumbnail()): ?>
                                        <img src="<?php echo esc_url(get_the_post_thumbnail_url(get_the_ID(), 'medium')); ?>" alt="<?php the_title_attribute(); ?>" class="img-fluid">
                                    <?php endif; ?>
                                    <p><?php the_title(); ?></p>
                                    <button type="button">Verify Authorisation</button>
                                </div>
                            </div>
                        <?php endwhile; wp_reset_postdata(); ?>
                    <?php endif; ?>

                    <?php if ($academic_total > 8): ?>
                        <div class="col-12 col-lg-12 text-center">
                            <div class="text-secondary fw-medium mb-3"><?php echo esc_html($academic_total - 8); ?> more programs available</div>
                            <a href="<?php echo esc_url(get_term_link($academic_slug, 'partner-type')); ?>" class="btn btn-outline-primary rounded-pill btn-sm">View More</a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Corporate Partners Section -->
        <?php
        $corporate_slug = 'corporate-partner';
        $corporate_total = get_total_partner_count($corporate_slug);

        $corporate_query = new WP_Query([
            'post_type'      => 'partners',
            'post_status'    => 'publish',
            'posts_per_page' => 10,
            'tax_query'      => [[
                'taxonomy' => 'partner-type',
                'field'    => 'slug',
                'terms'    => $corporate_slug,
            ]],
        ]);
        ?>
        <div class="learner-section corporate-section wow fadeInUp section-padding bg-theme-dark-gradient">
            <div class="container">
                <div class="row">
                    <div class="col-12 col-lg-12">
                        <div class="heading-area text-center">
                            <h1 class="fw-bold">Corporate Partner</h1>
                            <p>At Grras Solutions, we team up with leading universities and organizations to deliver industry-aligned training, real-world exposure, and future-ready skills — empowering learners to excel in today’s competitive job market.</p>
                        </div>
                    </div>
                </div>

                <div class="learner-grid mt-4">
                    <?php if ($corporate_query->have_posts()): ?>
                        <?php while ($corporate_query->have_posts()): $corporate_query->the_post(); ?>
                            <div class="imgbox text-center bg-white">
                                <?php if (has_post_thumbnail()): ?>
                                    <img src="<?php echo esc_url(get_the_post_thumbnail_url(get_the_ID(), 'medium')); ?>" alt="<?php the_title_attribute(); ?>" class="img-fluid p-3">
                                <?php endif; ?>
                                <div class="fw-semibold name p-3"><?php the_title(); ?></div>
                            </div>
                        <?php endwhile; wp_reset_postdata(); ?>
                    <?php endif; ?>
                </div>

                <?php if ($corporate_total > 8): ?>
                    <div class="row mt-4">
                        <div class="col-12 col-lg-12 text-center">
                            <div class="text-secondary fw-medium mb-3"><?php echo esc_html($corporate_total - 8); ?> more programs available</div>
                            <a href="<?php echo esc_url(get_term_link($corporate_slug, 'partner-type')); ?>" class="btn btn-outline-primary rounded-pill btn-sm">View More</a>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div id="industrysection" class="contentarea <?php echo (isset($_GET['tab']) ? $_GET['tab'] === 'industrysection' : true) ? 'active' : ''; ?>">
    <!-- Partner Section -->
    <div class="trackrecord industry-section wow fadeInLeft section-padding">
        <div class="container">
            <div class="row">
                <div class="col-12 col-lg-12 mb-4">
                    <div class="heading-area text-center">
                        <h2 class="fw-bold mb-2">Get Globally Recognized. Get Certified with Grras Solutions.</h2>
                        <h4>Official Training Partner for Red Hat, AWS, Microsoft, EC-Council, Salesforce, Oracle, ITIL & More.</h4>
                        <p class="theme-text-light">Unlock Global Opportunities with the Power of Industry Certifications In today’s fast-paced world, certifications are more than achievements — they are your ticket to career growth, credibility, and global recognition. At Grras Solutions, we bring you official, globally trusted certifications from the biggest names in tech — helping you stand out and succeed.</p>
                    </div>
                </div>
            </div>
            <div class="bglight p-md-3 industryarea">
                <div class="row">
                    <?php
                    $cert_query = new WP_Query([
                        'post_type'      => 'certifications',
                        'post_status'    => 'publish',
                        'posts_per_page' => -1,
                        'tax_query'      => [[
                            'taxonomy' => 'certification-type',
                            'field'    => 'slug',
                            'terms'    => 'industry-certification',
                        ]],
                    ]);

                    if ($cert_query->have_posts()):
                        while ($cert_query->have_posts()): $cert_query->the_post();
                            $thumb_url = get_the_post_thumbnail_url(get_the_ID(), 'medium');
                            $title     = get_the_title();
                            $content   = get_the_content();
                            $auth_link = get_post_meta(get_the_ID(), 'auth_link', true);
                            
                            // Extract first 3 lines or list items from content
                            $content_lines = explode(PHP_EOL, strip_tags(get_the_content()));
                            $list_items = array_filter(array_map('trim', $content_lines));
                            $list_items = array_slice($list_items, 0, 3);
                    ?>
                            <div class="col-12 col-md-6 col-lg-4">
                                <div class="cousebox p-3 bg-white mb-4">
                                    <div class="employ d-flex align-items-center border-bottom pb-3 mb-3">
                                        <div class="image-box p-2 d-flex align-items-center me-3">
                                            <?php if ($thumb_url): ?>
                                                <img src="<?php echo esc_url($thumb_url); ?>" class="img-fluid" alt="<?php echo esc_attr($title); ?>">
                                            <?php endif; ?>
                                        </div>
                                        <div class="name">
                                            <h4 class="mb-0"><?php echo esc_html($title); ?></h4>
                                        </div>
                                    </div>
                                    <div class="content">
                                        <?php echo wp_kses_post($content); ?>
                                        <a href="<?php the_permalink(); ?>" class="theme-text-primary fw-medium text-decoration-none">Learn more</a>
                                    </div>
                                </div>
                                <?php if ($auth_link): ?>
                                    <a href="<?php echo esc_url($auth_link); ?>" class="w-100 d-block text-center btn btndefault">Verify Authorisation</a>
                                <?php else: ?>
                                    <a href="javascript:void(0);" class="w-100 d-block text-center btn btndefault">Verify Authorisation</a>
                                <?php endif; ?>
                            </div>
                    <?php
                        endwhile;
                        wp_reset_postdata();
                    endif;
                    ?>
                </div>
            </div>
        </div>
    </div>
    <!-- End Partner Section -->
    </div>
    <div id="awardsection" class="contentarea <?php echo (isset($_GET['tab']) ? $_GET['tab'] === 'awardsection' : true) ? 'active' : ''; ?>">
    <!-- Award Section -->
    <div class="trackrecord award-section wow fadeInUps section-padding">
        <div class="container">
            <?php
            $current_year = date('Y');
            $selected_year = isset($_GET['year']) ? (int) $_GET['year'] : $current_year;

            // Fetch awards for selected year
            $award_query = new WP_Query([
                'post_type'      => 'awards',
                'post_status'    => 'publish',
                'posts_per_page' => -1,
                'date_query'     => [[
                    'year' => $selected_year,
                ]],
                'posts_per_page' => 9
            ]);

            $total_awards = $award_query->found_posts;
            ?>

            <div class="row">
                <div class="col-12 col-lg-12 mb-4">
                    <div class="heading-area d-flex justify-content-between align-items-center border-bottom border-dark">
                        <h4 class="fw-semibold color-black">All Awards (<?php echo esc_html($total_awards); ?>)</h4>
                        <form method="get">
                            <label class="fw-bold me-2">Year:</label>
                            <select name="year" class="border-0" onchange="this.form.submit()">
                                <?php
                                $years = range($current_year, $current_year - 5);
                                foreach ($years as $year) {
                                    $selected = $selected_year === $year ? 'selected' : '';
                                    echo "<option value=\"{$year}\" {$selected}>{$year}</option>";
                                }
                                ?>
                            </select>
                        </form>
                    </div>
                </div>
            </div>

            <div class="row">
                <?php if ($award_query->have_posts()): ?>
                    <?php while ($award_query->have_posts()): $award_query->the_post(); ?>
                        <div class="col-12 col-md-6 col-lg-4">
                            <div class="awardbox p-3 text-center mb-4">
                                <div class="image-box pb-md-3 mb-md-3 border-bottom">
                                    <?php if (has_post_thumbnail()): ?>
                                        <img src="<?php echo esc_url(get_the_post_thumbnail_url(get_the_ID(), 'medium')); ?>" class="img-fluid" alt="<?php the_title_attribute(); ?>">
                                    <?php endif; ?>
                                </div>
                                <div class="content">
                                    <h5 class="color-black fw-bold"><?php the_title(); ?></h5>
                                    <p><?php echo wp_kses_post(get_the_excerpt()); ?></p>
                                    <a href="<?php the_permalink(); ?>" class="theme-text-primary fw-medium text-decoration-none">Learn more</a>
                                </div>
                            </div>
                        </div>
                    <?php endwhile; wp_reset_postdata(); ?>
                <?php else: ?>
                    <div class="col-12 text-center">
                        <p>No awards found for <?php echo esc_html($selected_year); ?>.</p>
                    </div>
                <?php endif; ?>

                <?php if ($total_awards > 9): ?>
                    <div class="col-12 col-lg-12 text-center">
                        <a href="<?php echo get_post_type_archive_link('awards'); ?>" class="btn btn-outline-primary rounded-pill btn-sm">Load More</a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <!-- End Award Section -->

    <!-- Media Section -->
     <?php
    $current_year = date('Y');
    $selected_year = isset($_GET['media_coverage_year']) ? (int) $_GET['media_coverage_year'] : $current_year;

    // Query media coverage posts based on publish year
    $media_query = new WP_Query([
        'post_type'      => 'media-coverage',
        'post_status'    => 'publish',
        'posts_per_page' => -1,
        'date_query'     => [[ 'year' => $selected_year ]],
    ]);

    $total_media = $media_query->found_posts;
    if($total_media > 0) {
    ?>
    <div class="trackrecord award-section wow fadeInUps">
        <div class="container">
            <div class="row">
                <div class="col-12 col-lg-12 mb-4">
                    <div class="heading-area d-flex justify-content-between align-items-center border-bottom border-dark">
                        <h4 class="fw-semibold color-black">All Media Coverage (<?php echo esc_html($total_media); ?>)</h4>
                        <form method="get">
                            <label class="fw-bold me-2">Year:</label>
                            <select name="media_coverage_year" class="border-0" onchange="this.form.submit()">
                                <?php
                                $years = range($current_year, $current_year - 5);
                                foreach ($years as $year) {
                                    $selected = $selected_year === $year ? 'selected' : '';
                                    echo "<option value=\"{$year}\" {$selected}>{$year}</option>";
                                }
                                ?>
                            </select>
                        </form>
                    </div>
                </div>
            </div>

            <div class="row">
                <?php if ($media_query->have_posts()): ?>
                    <?php while ($media_query->have_posts()): $media_query->the_post(); ?>
                        <div class="col-12 col-md-6 col-lg-4">
                            <div class="awardbox p-3 text-center mb-4 d-block">
                                <div class="image-box pb-3">
                                    <?php if (has_post_thumbnail()): ?>
                                        <img src="<?php echo esc_url(get_the_post_thumbnail_url(get_the_ID(), 'medium')); ?>" class="img-fluid" alt="<?php the_title_attribute(); ?>">
                                    <?php endif; ?>
                                </div>
                                <div class="content text-center">
                                    <h5 class="color-black fw-bold pb-2 pb-md-3 mb-md-3 border-bottom"><?php the_title(); ?></h5>
                                    <p><?php echo wp_kses_post(get_the_excerpt()); ?></p>
                                    <a href="<?php the_permalink(); ?>" class="theme-text-primary fw-medium text-decoration-none">Learn more</a>
                                </div>
                            </div>
                        </div>
                    <?php endwhile; wp_reset_postdata(); ?>
                <?php else: ?>
                    <div class="col-12 text-center">
                        <p>No media coverage found for <?php echo esc_html($selected_year); ?>.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <?php } ?>
    <!-- End Media Section -->

    <!-- Innovation Section -->
    <div class="innovation wow fadeInUp section-padding bg-theme-light">
        <div class="container">
        <div class="row justify-content-center align-items-center">
            <div class="col-12 col-lg-12 mb-4">
            <div class="heading-area text-center">
                <h1 class="fw-bold">Defining Moments in Our Journey</h1>
                <div class="linearea">
                <img src="images/gradient-line.png" class="image-size170 img-fluid" alt="" />
                </div>
            </div>
            </div>
            <div class="col-12 col-lg-12">
                <div class="innovation-slider">
                <div class="owl-carousel innovation-slider-area">
                    <div class="item">
                    <div class="row gx-3">
                        <div class="col-6 col-sm-6 col-md-4 col-lg-3 mb-3">
                        <img src="images/define1.jpg" class="img-fluid rounded-1 image-size170 w-100" alt="" />
                        </div>
                        <div class="col-6 col-sm-6 col-md-4 col-lg-3 mb-3">
                        <img src="images/define2.jpg" class="img-fluid rounded-1 image-size170 w-100" alt="" />
                        </div>
                        <div class="col-6 col-sm-6 col-md-4 col-lg-3 mb-3">
                        <img src="images/define3.jpg" class="img-fluid rounded-1 image-size170 w-100" alt="" />
                        </div>
                        <div class="col-6 col-sm-6 col-md-4 col-lg-3 mb-3">
                        <img src="images/define4.jpg" class="img-fluid rounded-1 image-size170 w-100" alt="" />
                        </div>
                        <div class="col-6 col-sm-6 col-md-4 col-lg-3 mb-3">
                        <img src="images/define5.jpg" class="img-fluid rounded-1 image-size170 w-100" alt="" />
                        </div>
                        <div class="col-6 col-sm-6 col-md-4 col-lg-3 mb-3">
                        <img src="images/define6.jpg" class="img-fluid rounded-1 image-size170 w-100" alt="" />
                        </div>
                        <div class="col-6 col-sm-6 col-md-4 col-lg-3 mb-3">
                        <img src="images/define7.jpg" class="img-fluid rounded-1 image-size170 w-100" alt="" />
                        </div>
                        <div class="col-6 col-sm-6 col-md-4 col-lg-3 mb-3">
                        <img src="images/define8.jpg" class="img-fluid rounded-1 image-size170 w-100" alt="" />
                        </div>
                        <div class="col-6 col-sm-6 col-md-4 col-lg-3 mb-3">
                        <img src="images/define9.jpg" class="img-fluid rounded-1 image-size170 w-100" alt="" />
                        </div>
                        <div class="col-6 col-sm-6 col-md-4 col-lg-3 mb-3">
                        <img src="images/define10.jpg" class="img-fluid rounded-1 image-size170 w-100" alt="" />
                        </div>
                        <div class="col-6 col-sm-6 col-md-4 col-lg-3 mb-3">
                        <img src="images/define11.jpg" class="img-fluid rounded-1 image-size170 w-100" alt="" />
                        </div>
                        <div class="col-6 col-sm-6 col-md-4 col-lg-3 mb-3">
                        <img src="images/define12.jpg" class="img-fluid rounded-1 image-size170 w-100" alt="" />
                        </div>
                    </div>
                    </div>
                </div>
                </div>
                <ul class="pagination justify-content-center">
                <li class="page-item">
                    <a class="page-link prev" href="#" aria-label="Previous">
                    <svg xmlns="http://www.w3.org/2000/svg" width="10" height="12" viewBox="0 0 10 12" fill="none">
                        <path d="M6.60156 11.9403L0.576563 6.19033L6.60156 0.465331H9.47656L3.42656 6.19033L9.47656 11.9403H6.60156Z" fill="black"/>
                    </svg>
                    </a>
                </li>
                <li class="page-item active"><a class="page-link" href="#">1</a></li>
                <li class="page-item"><a class="page-link" href="#">2</a></li>
                <li class="page-item"><a class="page-link" href="#">3</a></li>
                <li class="page-item">
                    <a class="page-link next" href="#" aria-label="Next">
                    <svg xmlns="http://www.w3.org/2000/svg" width="10" height="12" viewBox="0 0 10 12" fill="none">
                        <path d="M0.201563 0.465331H3.07656L9.12656 6.19033L3.07656 11.9403H0.201563L6.25156 6.19033L0.201563 0.465331Z" fill="black"/>
                    </svg>
                    </a>
                </li>
                </ul>
            </div>
        </div>
        </div>
    </div>
    <!-- End Innovation Section -->

    </div>
    <div id="eventssection" class="contentarea <?php echo (isset($_GET['tab']) ? $_GET['tab'] === 'eventssection' : true) ? 'active' : ''; ?>">

    <!-- Exam Section -->
    

<div class="exam-section section-padding">
  <div class="container">
    <div class="row">
      <div class="col-12 col-md-8">
        <div class="heading-area">
          <h1 class="fw-bold">Events</h1>
          <p class="theme-text-light">Get exam-ready with concepts and questions as per the latest pattern</p>
        </div>
      </div>
      <div class="col-12 col-md-4">
        <form method="get" class="Exam-form d-flex">
          <input type="text" name="s" class="form-control" value="<?php echo get_search_query(); ?>" placeholder="Find events" />
          <input type="hidden" name="post_type" value="events" />
          <button type="submit" class="btn btn-dark btn-sm py-1 px-3 rounded-1 fw-normal ms-2">Search</button>
        </form>
      </div>
    </div>

    <div class="bglight p-2 rounded-2 mt-4 mt-md-0">
      <div class="row gx-2">
        <div class="col-12 col-md-3">
          <ul class="nav left-tab mt-0 tab-big" id="eventTab" role="tablist">
            <?php
            $terms = get_terms([
              'taxonomy' => 'event-type',
              'hide_empty' => false,
            ]);
            if (!empty($terms)) :
              foreach ($terms as $index => $term) :
                $active = ($index === 0) ? 'active' : '';
                $image_id = get_term_meta($term->term_id, 'event_icon', true);
                $image_url = wp_get_attachment_image_url($image_id, 'thumbnail');

                echo '<li class="nav-item block" role="presentation">';
                echo '<a href="#tab-' . esc_attr($term->slug) . '" class="nav-link ' . $active . '" data-bs-toggle="tab" role="tab">';
                echo '<div class="iconarea">';
                if ($image_url) {
                    echo '<img src="' . esc_url($image_url) . '" class="img-fluid" />';
                } else {
                    echo '<img src="' . get_template_directory_uri() . '/images/placeholder.png" class="img-fluid" />';
                }
                echo '<span class="ms-1">' . esc_html($term->name) . '</span>';
                echo '<div class="collapseicon-mobile d-md-none">
                    <svg xmlns="http://www.w3.org/2000/svg" width="12" height="8" viewBox="0 0 12 8" fill="none">
                        <path d="M10.7458 1.16726C10.5584 0.981006 10.305 0.876465 10.0408 0.876465C9.77661 0.876465 9.52316 0.981006 9.3358 1.16726L5.7458 4.70726L2.2058 1.16726C2.01844 0.981006 1.76498 0.876465 1.5008 0.876465C1.23661 0.876465 0.983161 0.981006 0.795798 1.16726C0.70207 1.26022 0.627675 1.37082 0.576907 1.49268C0.526138 1.61454 0.5 1.74525 0.5 1.87726C0.5 2.00927 0.526138 2.13997 0.576907 2.26183C0.627675 2.38369 0.70207 2.49429 0.795798 2.58726L5.0358 6.82726C5.12876 6.92099 5.23936 6.99538 5.36122 7.04615C5.48308 7.09692 5.61379 7.12306 5.7458 7.12306C5.87781 7.12306 6.00852 7.09692 6.13037 7.04615C6.25223 6.99538 6.36283 6.92099 6.4558 6.82726L10.7458 2.58726C10.8395 2.49429 10.9139 2.38369 10.9647 2.26183C11.0155 2.13997 11.0416 2.00927 11.0416 1.87726C11.0416 1.74525 11.0155 1.61454 10.9647 1.49268C10.9139 1.37082 10.8395 1.26022 10.7458 1.16726Z" fill="#181818"/>
                    </svg>
                </div>';
                echo '</div>'; // iconarea
                echo '</a>';

            // START EVENT BLOCK for mobile
            echo '<div class="eventblock d-md-none">';
            echo '<div class="row">';

            $event_args = [
                'post_type' => 'events',
                'posts_per_page' => 6, // You can paginate or load more
                'tax_query' => [
                    [
                        'taxonomy' => 'event-type',
                        'field'    => 'term_id',
                        'terms'    => $term->term_id,
                    ],
                ],
            ];

            $event_query = new WP_Query($event_args);

            if ($event_query->have_posts()) {
                while ($event_query->have_posts()) {
                        $event_query->the_post();
                        $img_url = get_the_post_thumbnail_url(get_the_ID(), 'medium') ?: get_template_directory_uri() . '/images/media.jpg';
                        echo '<div class="col-12 col-md-6 col-xl-4 intcourse pt-0 pb-3 px-2">';
                        echo '<div class="awardbox p-3 text-center d-block">';
                        echo '<div class="image-box pb-3">';
                        echo '<img src="' . esc_url($img_url) . '" class="img-fluid" alt="">';
                        echo '</div>';
                        echo '<div class="content text-center">';
                        echo '<h5 class="color-black fw-bold pb-2 md-2 pb-md-3 mb-md-3 border-bottom">' . get_the_title() . '</h5>';
                        echo '<p>' . wp_trim_words(get_the_excerpt(), 20, '...') . '</p>';
                        echo '<a href="' . get_permalink() . '" class="theme-text-primary fw-medium text-decoration-none">Learn more</a>';
                        echo '</div>';
                        echo '</div>';
                        echo '</div>';
                    }
                    wp_reset_postdata();
                }

                // Optional Pagination
                /*echo '<div class="col-12">';
                echo '<ul class="pagination justify-content-center">';
                echo '<li class="page-item"><a class="page-link prev" href="#"><svg width="10" height="12"><path d="M6.6 11.94L0.576 6.19 6.6 0.465h2.875L3.426 6.19l6.05 5.75H6.6Z" fill="black"/></svg></a></li>';
                echo '<li class="page-item active"><a class="page-link" href="#">1</a></li>';
                echo '<li class="page-item"><a class="page-link" href="#">2</a></li>';
                echo '<li class="page-item"><a class="page-link" href="#">3</a></li>';
                echo '<li class="page-item"><a class="page-link next" href="#"><svg width="10" height="12"><path d="M0.202 0.465h2.875l6.05 5.725-6.05 5.75H0.202L6.252 6.19 0.202 0.465Z" fill="black"/></svg></a></li>';
                echo '</ul>';
                echo '</div>';*/

                echo '</div>'; // row
                echo '</div>'; // eventblock
                echo '</li>';
                endforeach;
                endif;
            ?>
          </ul>
        </div>

        <div class="col-12 col-md-9">
          <div class="exam-course-area coursesec p-4 d-none d-md-block bglight">
            <div class="tab-content" id="eventTabContent">
              <?php
              foreach ($terms as $index => $term) :
                $active = ($index === 0) ? 'show active' : '';
                ?>
                <div class="tab-pane fade <?php echo $active; ?>" id="tab-<?php echo esc_attr($term->slug); ?>">
                  <div class="row">
                    <?php
                    $args = array(
                      'post_type' => 'events',
                      //'posts_per_page' => 6,
                      //'paged' => (get_query_var('paged')) ? get_query_var('paged') : 1,
                      'tax_query' => array(
                        array(
                          'taxonomy' => 'event-type',
                          'field' => 'slug',
                          'terms' => $term->slug
                        )
                      )
                    );
                    $query = new WP_Query($args);
                    if ($query->have_posts()) :
                      while ($query->have_posts()) : $query->the_post(); ?>
                        <div class="col-12 col-md-6 col-xl-4 intcourse pt-0 pb-3 px-2">
                          <div class="awardbox p-3 text-center d-block">
                            <div class="image-box pb-3">
                              <?php if (has_post_thumbnail()) : ?>
                                <img src="<?php the_post_thumbnail_url('medium'); ?>" class="img-fluid" alt="">
                              <?php else : ?>
                                <img src="<?php echo get_template_directory_uri(); ?>/images/media.jpg" class="img-fluid" alt="">
                              <?php endif; ?>
                            </div>
                            <div class="content text-center">
                              <h5 class="color-black fw-bold pb-2 pb-md-3 mb-md-3 border-bottom"><?php the_title(); ?></h5>
                              <p><?php echo wp_trim_words(get_the_content(), 20); ?></p>
                              <a href="<?php the_permalink(); ?>" class="theme-text-primary fw-medium text-decoration-none">Learn more</a>
                            </div>
                          </div>
                        </div>
                      <?php endwhile; ?>
                      <div class="col-12">
                        <div class="pagination justify-content-center">
                          
                        </div>
                      </div>
                      <?php wp_reset_postdata(); ?>
                    <?php else : ?>
                      <p class="text-center">No events found in this category.</p>
                    <?php endif; ?>
                  </div>
                </div>
              <?php endforeach; ?>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

    <!-- End Exam Section -->
        
    </div>
</div>

<?php get_footer(); ?>
<script>
      const wrapper = document.getElementById('menu');
      const nextBtn = document.getElementById('nextBtn');
      const prevBtn = document.getElementById('prevBtn');

      let scrollAmount = 0;

      function getScrollStep() {
        // Scroll width of one item
        const firstItem = wrapper.querySelector('.menu-item');
        return firstItem ? firstItem.offsetWidth + 10 : 100; // item width + gap
      }

      nextBtn.addEventListener('click', () => {
        scrollAmount += getScrollStep();
        wrapper.scrollTo({ left: scrollAmount, behavior: 'smooth' });
      });

      prevBtn.addEventListener('click', () => {
        scrollAmount = Math.max(0, scrollAmount - getScrollStep());
        wrapper.scrollTo({ left: scrollAmount, behavior: 'smooth' });
      });
</script>
