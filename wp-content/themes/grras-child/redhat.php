<?php

/**

 * Template Name: Red Hat

 * */

 $banner = get_field('banner');

get_header();

?>

    <!-- Learn today -->

    <div class="redhatbanner">

      <div class="container">

        <div class="row align-items-center">

          <div class="col-md-7">

            <h1><?php echo $banner['title'] ?></h1>

            <div class="invest"><?php echo $banner['sub_title'] ?></div>

            <div class="realword"><?php echo $banner['short_description'] ?></div>

            <div class="mt-5">

              <a href="#" class="btn btn-dark">Enroll Now</a>

              <a href="#" class="btn btn-red">Red Hat Verify</a>

            </div>

          </div>

          <div class="col-md-5"><div class="bannerhero"><img src="<?php echo $banner['right_image'] ?>" class="img-fluid" alt=""></div></div>

        </div>

      </div>

    </div>



    <!-- turnover -->

    <div class="turnover whbg">

      <div class="container">

        <div class="row">

          <div class="col-md-3 col-6 g-3">

            <div class="icon"><img src="<?php echo get_stylesheet_directory_uri() ?>/images/t1-red.png" class="img-fluid" alt=""></div>

            <p><big><span id="count1">3</span>K+</big>Successfully Trained</p>

          </div>

          <div class="col-md-3 col-6 g-3">

            <div class="icon"><img src="<?php echo get_stylesheet_directory_uri() ?>/images/t2-red.png" class="img-fluid" alt=""></div>

            <p><big><span id="count2">15</span>K+</big>Classes Completed</p>

          </div>

          <div class="col-md-3 col-6 g-3">

            <div class="icon"><img src="<?php echo get_stylesheet_directory_uri() ?>/images/t3-red.png" class="img-fluid" alt=""></div>

            <p><big><span id="count3">97</span>K+</big>Satisfaction Rate</p>

          </div>

          <div class="col-md-3 col-6 g-3">

            <div class="icon"><img src="<?php echo get_stylesheet_directory_uri() ?>/images/t1-red.png" class="img-fluid" alt=""></div>

            <p><big><span id="count4">102</span>K+</big>Students Community</p>

          </div>

        </div>

      </div>

    </div>



    <!-- Redhat Training Course -->

    <div class="trainingcourse">

      <div class="container">

        <div class="row">

          <div class="col-lg-7 wow fadeInLeft">

           <?php echo get_field('redhat_training')['content']; ?>

           <div class="d-block d-sm-none"><a href="#" class="btn btn-red">Apply Today</a></div>

          </div>

          <div class="col-lg-5 wow fadeInRight">

            <div class="videobox"><iframe width="100%" height="315" src="<?php echo get_field('redhat_training')['youtube_url']; ?>" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe></div>

            <div class="d-none d-sm-block"><a href="#" class="btn btn-red">Apply Today</a></div>

          </div>

        </div>

      </div>

    </div>



    <!-- course desktop -->

    <div class="intcourse coursesec redcourse">

      <div class="container">

        <div class="row">

          <div class="col-lg-8 d-none d-sm-block">

            <h2 class="mt-0">Rad Hat Courses</h2>

            <p>Learning tech skills from experts. Live tech  online classes to kickstart or accelerate your career</p>

          </div>

          <div class="col-lg-4 d-none d-sm-block">

            <div class="input-group mb-3">

              <input type="text" class="form-control" placeholder="Find courses & exams" aria-label="Recipient's username" aria-describedby="button-addon2">

              <button class="btn btn-dark py-2 px-3 fw-normal btn-sm" type="button" id="button-addon2">Search</button>

            </div>

          </div>

        </div>

<div class="row">

    <div class="col-lg-3 d-none d-sm-block">

        <div class="accordion" id="accordionExample">

            <!-- Types of Offerings -->

            <div class="accordion-item">

                <div class="accordion-header">

                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">

                        Types of Offerings

                    </button>

                </div>

                <div id="collapseOne" class="accordion-collapse collapse show" data-bs-parent="#accordionExample">

                    <div class="accordion-body">

                        <table width="100%">

                            <?php

                            $types_of_offerings = get_terms('types_of_offerings');

                            if ($types_of_offerings) {

                                foreach ($types_of_offerings as $offering) {

                                    ?>

                                    <tr>

                                        <td>

                                            <input type="checkbox" id="offering-<?php echo $offering->term_id; ?>" name="offering[]" value="<?php echo $offering->term_id; ?>">

                                            <label for="offering-<?php echo $offering->term_id; ?>"><?php echo $offering->name; ?></label>

                                        </td>

                                        <td><?php echo $offering->count; ?></td>

                                    </tr>

                                    <?php

                                }

                            }

                            ?>

                        </table>

                    </div>

                </div>

            </div>



            <!-- Certification Path -->

            <div class="accordion-item">

                <div class="accordion-header">

                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">

                        Certification Path

                    </button>

                </div>

                <div id="collapseTwo" class="accordion-collapse collapse" data-bs-parent="#accordionExample">

                    <div class="accordion-body">

                        <table width="100%">

                            <?php

                            $certification_path = get_terms('certification_path');

                            if ($certification_path) {

                                foreach ($certification_path as $path) {

                                    ?>

                                    <tr>

                                        <td>

                                            <input type="checkbox" id="certification-<?php echo $path->term_id; ?>" name="certification[]" value="<?php echo $path->term_id; ?>">

                                            <label for="certification-<?php echo $path->term_id; ?>"><?php echo $path->name; ?></label>

                                        </td>

                                        <td><?php echo $path->count; ?></td>

                                    </tr>

                                    <?php

                                }

                            }

                            ?>

                        </table>

                    </div>

                </div>

            </div>



            <!-- Product Lines -->

            <div class="accordion-item">

                <div class="accordion-header">

                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">

                        Product Lines

                    </button>

                </div>

                <div id="collapseThree" class="accordion-collapse collapse" data-bs-parent="#accordionExample">

                    <div class="accordion-body">

                        <table width="100%">

                            <?php

                            $product_lines = get_terms('product_lines');

                            if ($product_lines) {

                                foreach ($product_lines as $line) {

                                    ?>

                                    <tr>

                                        <td>

                                            <input type="checkbox" id="productline-<?php echo $line->term_id; ?>" name="productline[]" value="<?php echo $line->term_id; ?>">

                                            <label for="productline-<?php echo $line->term_id; ?>"><?php echo $line->name; ?></label>

                                        </td>

                                        <td><?php echo $line->count; ?></td>

                                    </tr>

                                    <?php

                                }

                            }

                            ?>

                        </table>

                    </div>

                </div>

            </div>



            <!-- Products -->

            <div class="accordion-item">

                <div class="accordion-header">

                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseproduct" aria-expanded="false" aria-controls="collapseproduct">

                        Products

                    </button>

                </div>

                <div id="collapseproduct" class="accordion-collapse collapse" data-bs-parent="#accordionExample">

                    <div class="accordion-body">

                        <table width="100%">

                            <?php

                            $products = get_terms('products');

                            if ($products) {

                                foreach ($products as $product) {

                                    ?>

                                    <tr>

                                        <td>

                                            <input type="checkbox" id="product-<?php echo $product->term_id; ?>" name="product[]" value="<?php echo $product->term_id; ?>">

                                            <label for="product-<?php echo $product->term_id; ?>"><?php echo $product->name; ?></label>

                                        </td>

                                        <td><?php echo $product->count; ?></td>

                                    </tr>

                                    <?php

                                }

                            }

                            ?>

                        </table>

                    </div>

                </div>

            </div>

        </div>

    </div>



    <div class="col-lg-9 d-none d-sm-block">

        <div class="tab-content" id="myTabContent">

            <div class="tab-pane fade show active serach-course" id="all-tab-pane" role="tabpanel" aria-labelledby="all-tab" tabindex="0">

                <div class="row">

                    <?php

                    $args = array(

                        'post_type' => 'redhat_courses',

                        'posts_per_page' => 6,

                    );

                    $courses = new WP_Query($args);

                    if ($courses->have_posts()) {

                        while ($courses->have_posts()) {

                            $courses->the_post();

                            $course_id = get_the_ID();

                            $course_image = get_the_post_thumbnail_url();

                            $course_title = get_the_title();

                            $content = get_the_content();

                            $course_description = get_the_excerpt();

                            $course_duration = get_field('days', $course_id);  // Custom Field for Duration

                            $course_skills = get_field('skills', $course_id);      // Custom Field for Skills

                             $course_terms = get_the_terms(get_the_ID(), 'red_hat_category');

            $term_classes = '';

            $term_names = [];    

            if ($course_terms) {

              foreach ($course_terms as $term) {

                $term_classes .= ' ' . esc_attr($term->slug);

                $term_names[] = $term->name;    

              }

            }

                            ?>

                            <div class="col-lg-4 col-md-4 col-sm-6 col-6 g-3">

                                <div class="cobox">

                                    <div class="imgbox">

                                        <img src="<?php echo get_field('mobile_background_image'); ?>" class="img-fluid bigimg" alt="">

                                        <div class="imgcontent">

                                            <div class="icon"><img src="<?php echo $course_image; ?>" class="img-fluid" alt=""></div>

                                            <h4><small><?php echo $term_names[0];?></small><br><?php echo $course_title;?></h4>  <!-- Custom Field for Course Code -->

                                        </div>

                                         <?php if (get_field('best_seller')) : ?>

                        <div class="<?php echo get_field('best_seller_color'); ?>"><?php echo get_field('best_seller'); ?></div>                      

                        <?php endif; ?>

                        <?php if (get_field('discount')) : ?>

                          <div class="offer"><?php echo get_field('discount'); ?><span>%</span> OFF</div>               

                        <?php endif; ?>

                                    </div>

                                    <div class="content">

                                        <p><a href="<?php the_permalink(); ?>" class="two_line" style="display: -webkit-box;"><?php echo $content; ?></a></p>

                                    </div>

                                    <div class="content line">

                                        <h5>Skills</h5>

                                        <ul>

                                             <?php

  

  $post_id = get_the_ID(); // This gets the current post ID.

  $taxonomy = 'skills'; // We're looking for categories here. 

  $tags = get_the_terms($post_id, $taxonomy);

  

  if ( ! empty( $tags ) && ! is_wp_error( $tags ) ) :

      

    $tag_count = count($tags);

    $display_count = 4;

    $remaining_count = $tag_count - $display_count;

    $counter = 0;

  

    foreach ( $tags as $tag ) :

      if ($counter < $display_count) :

        // Get ACF Image Field for each tag (assuming 'tag_image' is the ACF field name)

        $image = get_field('image', 'skills_' . $tag->term_id);  // 'course-tags_' . $tag->term_id is the ACF field key for the taxonomy

  

        if ( $image ) : // Check if the image exists

          $image_url = $image;

          $image_alt =  $tag->name;

        else :

          $image_url = 'path_to_default_image.png'; // Fallback image if no image is set

          $image_alt = $tag->name;

        endif;

        $tag_permalink = get_term_link( $tag );

        ?>

        <li>

        <?php echo  wp_trim_words($tag->name, 2, '...');  ?></li>

      <?php

      endif;

      $counter++;

    endforeach;

  

    if ($remaining_count > 0) :

      ?>

      <li>More +<?php echo $remaining_count; ?></li>

    <?php

    endif;

  else : ?>

    <li></li>

  <?php endif; ?>

                                        </ul>

                                    </div>

                                    <div class="content line">

                                        <div class="row">

                                            <div class="col-md-6 col-6">

                                                <div class="star"><a href="#"><img src="<?php echo get_stylesheet_directory_uri() ?>/images/star.svg" alt=""></a> 5/5 <span>(21)</span></div>

                                            </div>

                                            <div class="col-md-6 col-6">

                                                <div class="day"><img src="<?php echo get_stylesheet_directory_uri() ?>/images/days.svg" alt=""> <?php echo $course_duration; ?> Days</div>

                                            </div>

                                        </div>

                                    </div>

                                </div>

                            </div>

                            <?php

                        }

                    }

                    wp_reset_postdata();

                    ?>

                    <div class="col-md-12 g-3 text-center">

                        <p><span>8 more programs available</span></p>

                        <a href="#" class="btn btn-outline-primary mt-3 rounded-pill">View More</a>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>





        <!-- course mobile -->

        <div class="course-mobile d-block d-sm-none">

          <h6>Domanis</h6>

          <div class="btn-group">

            <button type="button" class="btn btn-light dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">

              All Course Domain

            </button>

            <ul class="dropdown-menu">

              <li><a class="dropdown-item" href="#">Programming language</a></li>

              <li><a class="dropdown-item" href="#">Another action</a></li>

              <li><a class="dropdown-item" href="#">Web development</a></li>

              <li><a class="dropdown-item" href="#">Data analytics & visualization</a></li>

              <li><a class="dropdown-item" href="#">DevOps</a></li>

              <li><a class="dropdown-item" href="#">Cloud Computing</a></li>

              <li><a class="dropdown-item" href="#">Data science</a></li>

              <li><a class="dropdown-item" href="#">Cyber security</a></li>

              <li><a class="dropdown-item" href="#">Graphic designing</a></li>

              <li><a class="dropdown-item" href="#">DSA</a></li>

              <li><a class="dropdown-item" href="#">Red hat training &certification</a></li>

            </ul>

          </div>



          <div class="cobox mt-3">

            <div class="imgbox">

              <img src="<?php echo get_stylesheet_directory_uri() ?>/images/red-coursem.png" class="img-fluid bigimg" alt="">

              <div class="imgcontent">

                <div class="icon"><img src="<?php echo get_stylesheet_directory_uri() ?>/images/red-icon.png" class="img-fluid" alt=""></div>

              </div>

            </div>

            <div class="right-content">

              <h4><small>Rad Hat</small><br>AD082</h4>

              <p><a href="#">with Specialization in REACT and Rest API</a></p>

              <div class="content">

                <div class="row">

                  <div class="col-md-6 col-6">

                    <div class="star"><a href="#"><img src="<?php echo get_stylesheet_directory_uri() ?>/images/star.svg" alt=""></a> 5/5 <span>(21)</span></div>

                  </div>

                  <div class="col-md-6 col-6">

                    <div class="day"><img src="<?php echo get_stylesheet_directory_uri() ?>/images/days.svg" alt=""> 30 Day</div>

                  </div>

                </div>

              </div>

              

            </div>

          </div>



          <div class="cobox">

            <div class="imgbox">

              <img src="<?php echo get_stylesheet_directory_uri() ?>/images/red-coursem.png" class="img-fluid bigimg" alt="">

              <div class="imgcontent">

                <div class="icon"><img src="<?php echo get_stylesheet_directory_uri() ?>/images/red-icon.png" class="img-fluid" alt=""></div>

              </div>

            </div>

            <div class="right-content">

              <h4><small>Rad Hat</small><br>AD082</h4>

              <p><a href="#">with Specialization in REACT and Rest API</a></p>

              <div class="content">

                <div class="row">

                  <div class="col-md-6 col-6">

                    <div class="star"><a href="#"><img src="<?php echo get_stylesheet_directory_uri() ?>/images/star.svg" alt=""></a> 5/5 <span>(21)</span></div>

                  </div>

                  <div class="col-md-6 col-6">

                    <div class="day"><img src="<?php echo get_stylesheet_directory_uri() ?>/images/days.svg" alt=""> 30 Day</div>

                  </div>

                </div>

              </div>

              

            </div>

          </div>



          <div class="cobox">

            <div class="imgbox">

              <img src="<?php echo get_stylesheet_directory_uri() ?>/images/red-coursem.png" class="img-fluid bigimg" alt="">

              <div class="imgcontent">

                <div class="icon"><img src="<?php echo get_stylesheet_directory_uri() ?>/images/red-icon.png" class="img-fluid" alt=""></div>

              </div>

              <div class="offer">50<span>%</span> OFF</div>

            </div>

            <div class="right-content">

              <div class="bestseller">Best Seller</div>

              <h4><small>Rad Hat</small><br>AD082</h4>

              <p><a href="#">with Specialization in REACT and Rest API</a></p>

              <div class="content">

                <div class="row">

                  <div class="col-md-6 col-6">

                    <div class="star"><a href="#"><img src="<?php echo get_stylesheet_directory_uri() ?>/images/star.svg" alt=""></a> 5/5 <span>(21)</span></div>

                  </div>

                  <div class="col-md-6 col-6">

                    <div class="day"><img src="<?php echo get_stylesheet_directory_uri() ?>/images/days.svg" alt=""> 30 Day</div>

                  </div>

                </div>

              </div>              

            </div>

          </div>



          <div class="cobox">

            <div class="imgbox">

              <img src="<?php echo get_stylesheet_directory_uri() ?>/images/red-coursem.png" class="img-fluid bigimg" alt="">

              <div class="imgcontent">

                <div class="icon"><img src="<?php echo get_stylesheet_directory_uri() ?>/images/red-icon.png" class="img-fluid" alt=""></div>

              </div>

            </div>

            <div class="right-content">

              <h4><small>Rad Hat</small><br>AD082</h4>

              <p><a href="#">with Specialization in REACT and Rest API</a></p>

              <div class="content">

                <div class="row">

                  <div class="col-md-6 col-6">

                    <div class="star"><a href="#"><img src="<?php echo get_stylesheet_directory_uri() ?>/images/star.svg" alt=""></a> 5/5 <span>(21)</span></div>

                  </div>

                  <div class="col-md-6 col-6">

                    <div class="day"><img src="<?php echo get_stylesheet_directory_uri() ?>/images/days.svg" alt=""> 30 Day</div>

                  </div>

                </div>

              </div>              

            </div>

          </div>



          <div class="cobox">

            <div class="imgbox">

              <img src="<?php echo get_stylesheet_directory_uri() ?>/images/red-coursem.png" class="img-fluid bigimg" alt="">

              <div class="imgcontent">

                <div class="icon"><img src="<?php echo get_stylesheet_directory_uri() ?>/images/red-icon.png" class="img-fluid" alt=""></div>

              </div>

            </div>

            <div class="right-content">

              <h4><small>Rad Hat</small><br>AD082</h4>

              <p><a href="#">with Specialization in REACT and Rest API</a></p>

              <div class="content">

                <div class="row">

                  <div class="col-md-6 col-6">

                    <div class="star"><a href="#"><img src="<?php echo get_stylesheet_directory_uri() ?>/images/star.svg" alt=""></a> 5/5 <span>(21)</span></div>

                  </div>

                  <div class="col-md-6 col-6">

                    <div class="day"><img src="<?php echo get_stylesheet_directory_uri() ?>/images/days.svg" alt=""> 30 Day</div>

                  </div>

                </div>

              </div>              

            </div>

          </div>



          <div class="cobox">

            <div class="imgbox">

              <img src="<?php echo get_stylesheet_directory_uri() ?>/images/red-coursem.png" class="img-fluid bigimg" alt="">

              <div class="imgcontent">

                <div class="icon"><img src="<?php echo get_stylesheet_directory_uri() ?>/images/red-icon.png" class="img-fluid" alt=""></div>

              </div>

            </div>

            <div class="right-content">

              <h4><small>Rad Hat</small><br>AD082</h4>

              <p><a href="#">with Specialization in REACT and Rest API</a></p>

              <div class="content">

                <div class="row">

                  <div class="col-md-6 col-6">

                    <div class="star"><a href="#"><img src="<?php echo get_stylesheet_directory_uri() ?>/images/star.svg" alt=""></a> 5/5 <span>(21)</span></div>

                  </div>

                  <div class="col-md-6 col-6">

                    <div class="day"><img src="<?php echo get_stylesheet_directory_uri() ?>/images/days.svg" alt=""> 30 Day</div>

                  </div>

                </div>

              </div>              

            </div>

          </div>



          <div class="cobox">

            <div class="imgbox">

              <img src="<?php echo get_stylesheet_directory_uri() ?>/images/red-coursem.png" class="img-fluid bigimg" alt="">

              <div class="imgcontent">

                <div class="icon"><img src="<?php echo get_stylesheet_directory_uri() ?>/images/red-icon.png" class="img-fluid" alt=""></div>

              </div>

            </div>

            <div class="right-content">

              <h4><small>Rad Hat</small><br>AD082</h4>

              <p><a href="#">with Specialization in REACT and Rest API</a></p>

              <div class="content">

                <div class="row">

                  <div class="col-md-6 col-6">

                    <div class="star"><a href="#"><img src="<?php echo get_stylesheet_directory_uri() ?>/images/star.svg" alt=""></a> 5/5 <span>(21)</span></div>

                  </div>

                  <div class="col-md-6 col-6">

                    <div class="day"><img src="<?php echo get_stylesheet_directory_uri() ?>/images/days.svg" alt=""> 30 Day</div>

                  </div>

                </div>

              </div>              

            </div>

          </div>



          <div class="text-cente">

            <nav aria-label="Page navigation example">

              <ul class="pagination justify-content-center">

                <li class="page-item">

                  <a class="page-link" href="#" aria-label="Previous">

                    <span aria-hidden="true">«</span>

                  </a>

                </li>

                <li class="page-item active"><a class="page-link" href="#">1</a></li>

                <li class="page-item"><a class="page-link" href="#">2</a></li>

                <li class="page-item"><a class="page-link" href="#">3</a></li>

                <li class="page-item">

                  <a class="page-link" href="#" aria-label="Next">

                    <span aria-hidden="true">»</span>

                  </a>

                </li>

              </ul>

            </nav>

          </div>

        </div>



      </div>

    </div>



    <!-- topchoice -->

    <div class="topchoice intcourse coursesec serach-course redtopchoice">

      <div class="container">

        <div class="row">

          <div class="col-lg-12 text-center">

            <h2>Most Popular Courses</h2>

          </div>

          <div class="col-lg-12">

            <div class="owl-carousel choice-course">

              <div class="item">

                <div class="cobox">

                  <div class="imgbox">

                    <img src="<?php echo get_stylesheet_directory_uri() ?>/images/red-course.png" class="img-fluid bigimg" alt="">

                    <div class="imgcontent">

                      <div class="icon"><img src="<?php echo get_stylesheet_directory_uri() ?>/images/red-icon.png" class="img-fluid" alt=""></div>

                      <h4><small>Rad Hat</small><br>AD082</h4>

                    </div>

                  </div>

                  <div class="content">

                    <p><a href="#">with Specialization in REACT and Rest API Development</a></p>

                  </div>

                  <div class="content line">

                    <h5>Skills</h5>

                    <ul>

                      <li>Python</li>

                      <li>Data Structue</li>

                      <li>About R</li>

                      <li>Management System</li>

                      <li>More +9</li>

                    </ul>

                  </div>

                  <div class="content line">

                    <div class="row">

                      <div class="col-md-6 col-6">

                        <div class="star"><a href="#"><img src="<?php echo get_stylesheet_directory_uri() ?>/images/star.svg" alt=""></a> 5/5 <span>(21)</span></div>

                      </div>

                      <div class="col-md-6 col-6">

                        <div class="day"><img src="<?php echo get_stylesheet_directory_uri() ?>/images/days.svg" alt=""> 30 Day</div>

                      </div>

                    </div>

                  </div>

                </div>

              </div>

              <div class="item">

                <div class="cobox">

                  <div class="imgbox">

                    <img src="<?php echo get_stylesheet_directory_uri() ?>/images/red-course.png" class="img-fluid bigimg" alt="">

                    <div class="imgcontent">

                      <div class="icon"><img src="<?php echo get_stylesheet_directory_uri() ?>/images/red-icon.png" class="img-fluid" alt=""></div>

                      <h4><small>Rad Hat</small><br>AD082</h4>

                    </div>

                    <div class="bestseller">Best Seller</div>

                    <div class="offer">50<span>%</span> OFF</div>

                  </div>

                  <div class="content">

                    <p><a href="#">with Specialization in REACT and Rest API Development</a></p>

                  </div>

                  <div class="content line">

                    <h5>Skills</h5>

                    <ul>

                      <li>Python</li>

                      <li>Data Structue</li>

                      <li>About R</li>

                      <li>Management System</li>

                      <li>More +9</li>

                    </ul>

                  </div>

                  <div class="content line">

                    <div class="row">

                      <div class="col-md-6 col-6">

                        <div class="star"><a href="#"><img src="<?php echo get_stylesheet_directory_uri() ?>/images/star.svg" alt=""></a> 5/5 <span>(21)</span></div>

                      </div>

                      <div class="col-md-6 col-6">

                        <div class="day"><img src="<?php echo get_stylesheet_directory_uri() ?>/images/days.svg" alt=""> 30 Day</div>

                      </div>

                    </div>

                  </div>

                </div>

              </div>

              <div class="item">

                <div class="cobox">

                  <div class="imgbox">

                    <img src="<?php echo get_stylesheet_directory_uri() ?>/images/red-course.png" class="img-fluid bigimg" alt="">

                    <div class="imgcontent">

                      <div class="icon"><img src="<?php echo get_stylesheet_directory_uri() ?>/images/red-icon.png" class="img-fluid" alt=""></div>

                      <h4><small>Rad Hat</small><br>AD082</h4>

                    </div>

                  </div>

                  <div class="content">

                    <p><a href="#">with Specialization in REACT and Rest API Development</a></p>

                  </div>

                  <div class="content line">

                    <h5>Skills</h5>

                    <ul>

                      <li>Python</li>

                      <li>Data Structue</li>

                      <li>About R</li>

                      <li>Management System</li>

                      <li>More +9</li>

                    </ul>

                  </div>

                  <div class="content line">

                    <div class="row">

                      <div class="col-md-6 col-6">

                        <div class="star"><a href="#"><img src="<?php echo get_stylesheet_directory_uri() ?>/images/star.svg" alt=""></a> 5/5 <span>(21)</span></div>

                      </div>

                      <div class="col-md-6 col-6">

                        <div class="day"><img src="<?php echo get_stylesheet_directory_uri() ?>/images/days.svg" alt=""> 30 Day</div>

                      </div>

                    </div>

                  </div>

                </div>

              </div>

              <div class="item">

                <div class="cobox">

                  <div class="imgbox">

                    <img src="<?php echo get_stylesheet_directory_uri() ?>/images/red-course.png" class="img-fluid bigimg" alt="">

                    <div class="imgcontent">

                      <div class="icon"><img src="<?php echo get_stylesheet_directory_uri() ?>/images/red-icon.png" class="img-fluid" alt=""></div>

                      <h4><small>Rad Hat</small><br>AD082</h4>

                    </div>

                  </div>

                  <div class="content">

                    <p><a href="#">with Specialization in REACT and Rest API Development</a></p>

                  </div>

                  <div class="content line">

                    <h5>Skills</h5>

                    <ul>

                      <li>Python</li>

                      <li>Data Structue</li>

                      <li>About R</li>

                      <li>Management System</li>

                      <li>More +9</li>

                    </ul>

                  </div>

                  <div class="content line">

                    <div class="row">

                      <div class="col-md-6 col-6">

                        <div class="star"><a href="#"><img src="<?php echo get_stylesheet_directory_uri() ?>/images/star.svg" alt=""></a> 5/5 <span>(21)</span></div>

                      </div>

                      <div class="col-md-6 col-6">

                        <div class="day"><img src="<?php echo get_stylesheet_directory_uri() ?>/images/days.svg" alt=""> 30 Day</div>

                      </div>

                    </div>

                  </div>

                </div>

              </div>

              <div class="item">

                <div class="cobox">

                  <div class="imgbox">

                    <img src="<?php echo get_stylesheet_directory_uri() ?>/images/red-course.png" class="img-fluid bigimg" alt="">

                    <div class="imgcontent">

                      <div class="icon"><img src="<?php echo get_stylesheet_directory_uri() ?>/images/red-icon.png" class="img-fluid" alt=""></div>

                      <h4><small>Rad Hat</small><br>AD082</h4>

                    </div>

                    <div class="bestseller">Best Seller</div>

                    <div class="offer">50<span>%</span> OFF</div>

                  </div>

                  <div class="content">

                    <p><a href="#">with Specialization in REACT and Rest API Development</a></p>

                  </div>

                  <div class="content line">

                    <h5>Skills</h5>

                    <ul>

                      <li>Python</li>

                      <li>Data Structue</li>

                      <li>About R</li>

                      <li>Management System</li>

                      <li>More +9</li>

                    </ul>

                  </div>

                  <div class="content line">

                    <div class="row">

                      <div class="col-md-6 col-6">

                        <div class="star"><a href="#"><img src="<?php echo get_stylesheet_directory_uri() ?>/images/star.svg" alt=""></a> 5/5 <span>(21)</span></div>

                      </div>

                      <div class="col-md-6 col-6">

                        <div class="day"><img src="<?php echo get_stylesheet_directory_uri() ?>/images/days.svg" alt=""> 30 Day</div>

                      </div>

                    </div>

                  </div>

                </div>

              </div>

              <div class="item">

                <div class="cobox">

                  <div class="imgbox">

                    <img src="<?php echo get_stylesheet_directory_uri() ?>/images/red-course.png" class="img-fluid bigimg" alt="">

                    <div class="imgcontent">

                      <div class="icon"><img src="<?php echo get_stylesheet_directory_uri() ?>/images/red-icon.png" class="img-fluid" alt=""></div>

                      <h4><small>Rad Hat</small><br>AD082</h4>

                    </div>

                  </div>

                  <div class="content">

                    <p><a href="#">with Specialization in REACT and Rest API Development</a></p>

                  </div>

                  <div class="content line">

                    <h5>Skills</h5>

                    <ul>

                      <li>Python</li>

                      <li>Data Structue</li>

                      <li>About R</li>

                      <li>Management System</li>

                      <li>More +9</li>

                    </ul>

                  </div>

                  <div class="content line">

                    <div class="row">

                      <div class="col-md-6 col-6">

                        <div class="star"><a href="#"><img src="<?php echo get_stylesheet_directory_uri() ?>/images/star.svg" alt=""></a> 5/5 <span>(21)</span></div>

                      </div>

                      <div class="col-md-6 col-6">

                        <div class="day"><img src="<?php echo get_stylesheet_directory_uri() ?>/images/days.svg" alt=""> 30 Day</div>

                      </div>

                    </div>

                  </div>

                </div>

              </div>

              <div class="item">

                <div class="cobox">

                  <div class="imgbox">

                    <img src="<?php echo get_stylesheet_directory_uri() ?>/images/red-course.png" class="img-fluid bigimg" alt="">

                    <div class="imgcontent">

                      <div class="icon"><img src="<?php echo get_stylesheet_directory_uri() ?>/images/red-icon.png" class="img-fluid" alt=""></div>

                      <h4><small>Rad Hat</small><br>AD082</h4>

                    </div>

                  </div>

                  <div class="content">

                    <p><a href="#">with Specialization in REACT and Rest API Development</a></p>

                  </div>

                  <div class="content line">

                    <h5>Skills</h5>

                    <ul>

                      <li>Python</li>

                      <li>Data Structue</li>

                      <li>About R</li>

                      <li>Management System</li>

                      <li>More +9</li>

                    </ul>

                  </div>

                  <div class="content line">

                    <div class="row">

                      <div class="col-md-6 col-6">

                        <div class="star"><a href="#"><img src="<?php echo get_stylesheet_directory_uri() ?>/images/star.svg" alt=""></a> 5/5 <span>(21)</span></div>

                      </div>

                      <div class="col-md-6 col-6">

                        <div class="day"><img src="<?php echo get_stylesheet_directory_uri() ?>/images/days.svg" alt=""> 30 Day</div>

                      </div>

                    </div>

                  </div>

                </div>

              </div>

            </div>

          </div>

        </div>

      </div>

    </div>



    <!-- talent -->

    <div class="talent wow fadeInLeft">

      <div class="container">

        <div class="row justify-content-center">

          <div class="col-md-9">

            <h2><?php $take_control_section = get_field('take_control_section'); 

            echo $take_control_section['title'];

            ?></span></h2>

          </div>

          <div class="col-md-12">

            <ul>

             <?php foreach($take_control_section['item'] as $item): ?>

              <li><img src="<?php echo $item['icon']; ?>" alt=""><h5><?php echo $item['name']; ?> </h5></li>

              <?php endforeach; ?>

            </ul>

          </div>

        </div>

      </div>

    </div>



    <!-- benifit -->

    <div class="benifit">

      <div class="container wow fadeInRight">

        <div class="row align-items-center">

          <div class="col-lg-7">

            <h3>Benefits</h3>

            <h2><?php 

            $benefits_section = get_field('benefits_section'); 

            $certification_section = get_field('certification_section'); 

            $red_hat_academy_section = get_field('red_hat_academy_section'); 

            $red_hat_learning_section = get_field('red_hat_learning_section'); 

            $quantifying_section = get_field('quantifying_section'); 

            $career_path = get_field('career_path'); 

            $retake_policy = get_field('retake_policy'); 

            echo $benefits_section['title'];

            ?></h2>

            <div class="row">

               <?php echo $benefits_section['content']; ?>

            </div>

          </div>

          <div class="col-lg-5 text-right">

            <div class="benifitredhat"><img src="<?php echo $benefits_section['left_image']; ?>" class="img-fluid" alt=""></div>

          </div>

        </div>

      </div>

    </div>







    <!-- Red Hat Training Certification -->

    <div class="redhatcertifi">

      <div class="container wow fadeInUp">

        <div class="row align-items-center">

          <div class="col-lg-7">

         <?php echo $certification_section['content']; ?>

          </div>

          <div class="col-lg-5">

            <img src="<?php echo get_stylesheet_directory_uri() ?>/images/red-certificate.jpg" class="img-fluid" alt="">

          </div>

        </div>

      </div>

    </div>



    <!-- Our Certification Holders -->

    <div class="redcartiholder">

      <div class="container">

        <h2><?php $our_certification_holders = get_field('our_certification_holders'); 

        echo $our_certification_holders['title'];

        ?>

        

        </h2>

        <p> <?php echo $our_certification_holders['short_description'];?></p>

          <div class="owl-carousel rec-certi">

              <?php foreach( $our_certification_holders['image'] as $item): ?>

            <div class="item">

              <img src="<?php echo $item; ?>" class="img-fluid bigimg" alt="">

            </div>

              <?php endforeach; ?>

           

          </div>

      </div>

    </div>





    <!-- A Peek Into Our -->

    <div class="peekinto">

      <div class="container wow fadeInLeft">

        <div class="row align-items-center">

          <div class="col-lg-12 mb-3">

            <h2 class="text-center mb-5"><?php echo $red_hat_academy_section['title']; ?></h2>

          </div>

          <div class="col-lg-7">

            <img src="<?php echo $red_hat_academy_section['image']; ?>" class="img-fluid" alt="">

          </div>

          <div class="col-lg-5">

            <?php echo $red_hat_academy_section['content']; ?>

             <a href="#" class="btn btn-red">Contact Us</a>

          </div>

        </div>

      </div>

    </div>



    <!-- red logo -->

    <div class="container">

      <div class="redlogo">

        <div class="owl-carousel red-logo">

            <?php foreach(get_field('universities_logo') as $item): ?>

          <div class="item"><img src="<?php echo $item; ?>" class="img-fluid" alt=""> </div>

     <?php endforeach; ?>

        </div>

      </div>

    </div>



    <!-- red hat programme -->

    <div class="redhatpro">

      <div class="container">

        <div class="row">

          <div class="col-lg-12">

              <?php $red_hat_program_features = get_field('red_hat_program_features'); ?>

            <h3><span><?php echo $red_hat_program_features['title']; ?></span><?php echo $red_hat_program_features['sub_title']; ?></h3>

            <div class="subtext"><?php echo $red_hat_program_features['short_description']; ?></div>

          </div>

          <ul>

              <?php foreach($red_hat_program_features['points'] as $item): ?>

            <li>

              <div class="iconbox">

                <img src="<?php echo $item['image'] ?>" alt="">

                <h4><?php echo $item['title'] ?></h4>

                <p><?php echo $item['short_description'] ?></p>

              </div>

            </li>

          <?php endforeach; ?>

          </ul>

        </div>

      </div>

    </div>



    <!-- A peek into Our Red Hat  -->

    <div class="grabg">

      <div class="peekinto peekgray">

        <div class="container wow fadeInRight">

          <div class="row align-items-center">

            <div class="col-lg-12 mb-2">

              <h2 class="text-center mb-5"><?php echo get_field('redhat_training_section'); ?></h2>

            </div>

            <div class="col-lg-7 order-lg-last">

              <img src="<?php echo $red_hat_learning_section['image']; ?>" class="img-fluid" alt="">

            </div>

            <div class="col-lg-5">

              <h2><?php echo $red_hat_learning_section['title']; ?></h2>

              <p><?php echo $red_hat_learning_section['short_description']; ?></p>

              <a href="#" class="btn btn-red">Start Free Trial</a>

            </div>

          </div>

        </div>

      </div>



      <!-- Chart Your Career Path -->

      <div class="careerpath">

        <div class="container wow fadeInLeft">

          <div class="row">

            <div class="col-lg-12">

              <h2><?php echo $career_path['title']; ?></h2>

              <div class="subtext"><?php echo $career_path['short_description']; ?></div>

              <ul>

                  <?php foreach($career_path['item'] as $item): ?>

                <li>

                  <img src="<?php echo $item['image']; ?>" alt="">

                  <h5><?php echo $item['title']; ?></h5>

                  <p><?php echo $item['detail']; ?></p>

                </li>

               <?php endforeach; ?>

              </ul>

            </div>

          </div>

        </div>

      </div>



      <!-- Grras vs Other Internships -->

      <div class="bestfor">

        <div class="container">

          <div class="row justify-content-center">

            <div class="col-lg-8 text-center">

              <h2><?php 

              $grras_vs_other_internships = get_field('grras_vs_other_internships');

              echo $grras_vs_other_internships['title']  ?></h2>

              <p><?php echo $grras_vs_other_internships['short_description'] ?></p>

            </div>

            <div class="col-lg-10">

              <div class="table-responsive">

                <table class="table">

                  <tr>

                    <th width="30%"></th>

                    <th width="20%"><?php echo $grras_vs_other_internships['1_st_sec'] ?></th>

                    <th width="20%"><?php echo $grras_vs_other_internships['2_st_sec'] ?></th>

                    <th width="20%"><?php echo $grras_vs_other_internships['3_st_sec'] ?></th>

                  </tr>

                  <?php foreach($grras_vs_other_internships['points'] as $item): ?>

                  <tr>

                    <td><?php echo $item['title']; ?></td>

                    <td align="center" valign="middle"><img src="<?php echo get_stylesheet_directory_uri() ?>/images/<?php echo $item['1_st_sec'] == 1 ? 'check' : 'cross'  ?>.png" alt=""></td>

                    <td align="center" valign="middle"><img src="<?php echo get_stylesheet_directory_uri() ?>/images/<?php echo $item['2_st_sec'] == 1 ? 'check' : 'cross'  ?>.png" alt=""></td>

                    <td align="center" valign="middle"><img src="<?php echo get_stylesheet_directory_uri() ?>/images/<?php echo $item['3_st_sec'] == 1 ?'check' : 'cross'  ?>.png" alt=""></td>

                  </tr>

                  <?php endforeach; ?>

                 

                </table>

              </div>

            </div>

          </div>

        </div>

      </div>

    </div>



    



    <!-- FREE Exam Retake Policy -->

    <div class="exam">

      <div class="container wow fadeInLeft">

        <div class="row align-items-center">

          <div class="col-lg-4">

            <h2><?php echo $retake_policy['title']; ?></h2>

          </div>

          <div class="col-lg-5">

            <p><?php echo $retake_policy['short_description']; ?></p>

          </div>

          <div class="col-lg-3">

            <a href="#" class="btn btn-red">Start Today</a>

          </div>

        </div>

      </div>

    </div>



<?php

include 'components/faq.php';

?>



    <!-- need more -->

    <div class="needmore">

      <div class="contaier">

        <h2>Need more information?</h2>

        <a href="#" class="btn btn-outline-dark">FAQs</a>

        <a href="#" class="btn btn-red">Talk to a Red Hatter</a>

      </div>

    </div>





<?php

get_footer();