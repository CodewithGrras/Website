<?php
$terms = get_the_terms(get_the_ID(), 'placement_types');
?>

<div class="item">
            <a href="/placement-support/" class="global-link">
                        <div class="cousebox">
                            <div class="employ">
                            <img src="<?php echo get_the_post_thumbnail_url() ?>" class="img-fluid" alt="">
                                
                            <!-- <img src="<?php echo get_stylesheet_directory_uri() ?>/images/raghav-bahad.png" class="img-fluid" alt=""> -->
                        </div>
                            <div class="name">
                                <h4><?php the_title() ?></h4>
                                <div class="subtxt"><?php echo get_field('designation') ?></div>
                            </div>
                            <div class="coname"><img src="<?php echo get_field('company') ?>" alt=""></div>
                            <div class="content">
                                <h5><?php echo get_field('course_undertaken') ?></h5>
                                <p><?php the_content() ?></p>
                            </div>
                        </div>
                    </a>
                    </div>