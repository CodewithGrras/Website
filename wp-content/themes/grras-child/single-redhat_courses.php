
<?php
get_header();
$banner = get_field('banner');
?>
<style>
    input#gform_submit_button_18 {
    background: #ee0000;
}
</style>
    <!-- banner -->
    <div class="redbanner-detail">
      <div class="container">
        <div class="row">
          <div class="col-lg-8 relative">
            <!--<div class="share"><span><?php echo $banner['red_hat_certifcation_tag_text']; ?></span> <a href="#"><img src="<?php echo get_stylesheet_directory_uri() ?>/images/red-share.svg" alt=""></a></div>-->
            <h1><?php echo $banner['title']; ?></h1>
            <ul>
                <?php foreach($banner['points'] as $item): ?>
              <li><img src="<?php echo $item['icon'] ?>" alt=""><?php echo $item['title']; ?></li>
                <?php endforeach; ?>
            </ul>
            <div class="subtext"><?php echo $banner['sub_text']; ?></div>
            <p><?php echo $banner['short_description']; ?></p>
            <div class="btndiv">
              <a href="<?php echo $banner['download_brochure_url']; ?>" target="_blank" download="true" class="btn btn-outline-dark">Download Brochure</a>
              <a href="<?php echo $banner['verify_url']; ?>" target="_blank" class="btn btn-red">Red hat Verify</a>
              <img src="<?php echo $banner['red_hat_image'] ?>" class="img-fluid hatimg" alt="">
            </div>
          </div>
          <div class="col-lg-4">
            <div class="whbox">
              <?php /* ?><form>
                <div class="row">
                  <div class="col">
                    <div class="mb-3">
                      <label>Full Name <span>*</span></label>
                      <input type="text" class="form-control" placeholder="Your Name">
                    </div>
                  </div>
                  <div class="col">
                    <div class="mb-3">
                      <label>Phone Number <span>*</span></label>
                      <input type="phone" class="form-control" placeholder="Enter Phone Number">
                    </div>
                  </div>
                </div>
                <div class="mb-3">
                  <label>Email <span>*</span></label>
                  <input type="phone" class="form-control" placeholder="Email ID">
                </div>
                <div class="mb-3">
                  <label class="fomtext form-check-inline">Training For*</label>
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio1" value="option1">
                    <label class="form-check-label" for="inlineRadio1">My Team</label>
                  </div>
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio2" value="option2">
                    <label class="form-check-label" for="inlineRadio2">Myself</label>
                  </div>
                </div>
                <div class="mb-3">
                  <label>Message</label>
                  <textarea name="message" cols="10" rows="5" class="form-control" placeholder="Your Message"></textarea>
                </div>
                <a href="#" class="btn btn-outline-primary d-block">Enquire Now</a>
              </form><?php */ ?>
              <?php echo do_shortcode('[gravityform id="18" title="true"]'); ?>
              
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- counter -->
    <div class="turnover grabg">
      <div class="container">
        <div class="row">
           <?php if(have_rows('after_banner_rows', 'option')):
            while(have_rows('after_banner_rows', 'option')): the_row();
           ?>
          <div class="col-md-3 col-6 g-3">
            <div class="icon"><img src="<?php echo get_sub_field('icon'); ?>" class="img-fluid" alt=""></div>
            <p><big><?php echo get_sub_field('count_text'); ?></big><?php echo get_sub_field('title'); ?></p>
          </div>
          <?php endwhile; endif; ?>
        </div>
      </div>
    </div>

    <!-- Available Delivery -->
    <div class="container wow fadeInLeft">
      <div class="available-del">
        <h2><?php echo get_field('available_delivery_methods_title', 'option'); ?></h2>
        <ul>
            <?php if(have_rows('available_delivery_methods_rows', 'option')):
            while(have_rows('available_delivery_methods_rows', 'option')): the_row();
           ?>
          <!--<li>
            <div class="icon"><img src="<?php echo get_sub_field('icon'); ?>" class="img-fluid" alt=""></div>
            <h5><?php echo get_sub_field('title'); ?></h5>
          </li>-->
          <li>
            <div class="icon"><img src="<?php echo get_sub_field('icon'); ?>" class="img-fluid" alt=""></div>
            <h5><?php echo get_sub_field('title'); ?></h5>
          </li>
          <?php endwhile; endif; ?>
        </ul>
      </div>
    </div>

    <!-- Our Recent Placements -->
    <div class="overview topbodr">
      <div class="tabbed-content">
        <div class="container">
          <nav class="tabs nav navtab d-none d-md-block">
            <ul>
              <li><a href="#" data-scroll="overview" class="active">Overview</a></li>
              <li><a href="#" data-scroll="curriculum">Curriculum</a></li>
              <li><a href="#" data-scroll="certification">Certification</a></li>
              <li><a href="#" data-scroll="placement">Placement Partners</a></li>
              <li><a href="#" data-scroll="testimoni">Testimonials</a></li>
              <li><a href="#" data-scroll="awardrec">Awards & Recognition</a></li>
              <li><a href="#" data-scroll="faqsec">FAQ</a></li>
            </ul>
          </nav>
        </div>
        <div class="overbg redhatbg section-padding">
          <div class="container">
            <section class="scroller" id="overview" data-anchor="overview">
              <div class="item-content">
                <div class="row justify-content-between align-items-center">
                  <div class="col-lg-6">
                    <h2><?php $over_view = get_field('over_view');
              echo $over_view['title'];
              ?></h2>
                    <?php /* ?><p>15+ Years of Transforming Careers xxxx Students aced their interviews and landed dream roles at top companies XXX LPA Highest CTC after completing our course.By 2026, the Indian Data and Business Analytics industry is expected to grow to US$118.7 billion. This big increase shows how important data analytics will be for different parts of India’s economy.This also means that if you gain skills and comprehensive knowledge ofAnalytics today, you can be part of this growing job market. You canfast-track your career and be the most in-demand data or business analyst that companies are looking for!<br><a href="#">Explore more</a></p>
                    <div class="mt-5">
                      <a href="#" class="btn btn-red">Enquire Now</a>
                    </div>
                    <?php */ ?>
                    <div class="readmoretext looklikep"><?php echo limitTextHtml($over_view['description'], 650); ?></div>
                  </div>
                  <div class="col-lg-5">
                    <div class="videobox">
                        <?php if(!empty($over_view["youtube_url"])) { ?>
                        <iframe width="100%" height="315" src="<?php echo $over_view["youtube_url"] ?>" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
                    <?php } elseif(!empty($over_view["background_image_placeholder"])) { ?>
                        <img src="<?php echo $over_view["background_image_placeholder"]; ?>" class="img-responsive w-100" />
                    <?php } ?>
                    </div>
                  </div>
                </div>                
              </div>
            </section>
          </div>
        </div>
      </div>
    </div>

    <!-- Full Stack -->
    <div class="fullstack whitebg scroller" id="curriculum" data-anchor="curriculum">
      <div class="container">
        <div class="row">
          <div class="col-lg-12">
            <h2>Course Curriculum Excel in MERN <br><small>(MongoDB, Express.js, React.js, and Node.js)</small></h2>
            <div class="subtext mb-3">Curated and designed by experts, our Full Stack MERN We  Development Course covers every topic and tool in detail from basics to advanced concepts. Dive into tailored problem-solving techniques for a comprehensive, practical learning experience.</div>
          </div>
          <div class="col-lg-8">
            <div class="coursetab">
              <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                  <a class="nav-link active" id="overview-tab" data-bs-toggle="tab" data-bs-target="#overview-tab-pane" role="tab" aria-controls="overview-tab-pane" aria-selected="true">Overview</a>
                </li>
                <?php if (have_rows('course_curriculum_curriculum_sections')): ?>
                <li class="nav-item" role="presentation">
                  <a class="nav-link" id="curriculum-tab" data-bs-toggle="tab" data-bs-target="#curriculum-tab-pane" role="tab" aria-controls="curriculum-tab-pane" aria-selected="false">Curriculum</a>
                </li>
                <?php endif; ?>
              </ul>
              <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="overview-tab-pane" role="tabpanel" aria-labelledby="overview-tab" tabindex="0">
                  <h3>Course Description</h3>
                  <?php echo get_field('course_curriculum_overview_description'); ?>
                </div>
                <div class="tab-pane fade" id="curriculum-tab-pane" role="tabpanel" aria-labelledby="curriculum-tab" tabindex="0">
                    <div class="accordion" id="accordionExample2">
                    <?php
                    $count = 0;
                    if (have_rows('course_curriculum_curriculum_sections')):
                        while (have_rows('course_curriculum_curriculum_sections')): the_row();
                            $count++;
                            $title = get_sub_field('title');
                            $slug = create_slug($title) . '-' . $count;
                            $is_multiple = get_sub_field('is_multiple') == 'True';
                            $multiple = get_sub_field('multiple');
                            $has_video = false;

                            // Check if any item has a YouTube video link
                            if ($is_multiple) {
                                foreach ($multiple as $item) {
                                    if (!empty($item['youtube_video_link'])) {
                                        $has_video = true;
                                        break;
                                    }
                                }
                            }
                    ?>
                    <div class="accordion-item<?php echo ($count > 14) ? ' hidden-item' : ''; ?>">
                        <h4 class="accordion-header d-flex justify-content-between align-items-center" id="heading-<?php echo $slug; ?>">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-<?php echo $slug; ?>" aria-expanded="false" aria-controls="collapse-<?php echo $slug; ?>">
                                <?php echo $title; ?>
                            </button>
                            <?php if ($has_video): ?>
                                <span class="small text-theme-orange me-3">Preview</span>
                            <?php endif; ?>
                        </h4>
                        <div id="collapse-<?php echo $slug; ?>" class="accordion-collapse collapse" aria-labelledby="heading-<?php echo $slug; ?>" data-bs-parent="#accordionExample2">
                            <div class="accordion-body">
                                <?php echo wpautop(get_sub_field('content')); ?>
                                <?php if ($is_multiple): ?>
                                    <div class="accordion" id="accordionExample4">
                                        <?php foreach ($multiple as $i => $item):
                                            $item_slug = $slug . '-' . $i;
                                            $youtube_link = $item['youtube_video_link'];
                                            preg_match('/(?:youtube\.com\/watch\?v=|youtu\.be\/)([^&]+)/', $youtube_link, $matches);
                                            $youtube_id = $matches[1] ?? '';
                                        ?>
                                        <div class="accordion-item">
                                            <h4 class="accordion-header d-flex justify-content-between align-items-center" id="heading-<?php echo $item_slug; ?>">
                                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-<?php echo $item_slug; ?>" aria-expanded="false" aria-controls="collapse-<?php echo $item_slug; ?>">
                                                    <?php echo $item["title"]; ?>
                                                </button>
                                                <?php if (!empty($youtube_id)): ?>
                                                <div class="d-flex align-items-center">
                                                    <button class="btn btn-link p-0 me-2 play-video-btn" data-video-id="<?php echo $youtube_id; ?>">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="#ef721f" viewBox="0 0 16 16">
                                                            <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM6.271 5.055a.5.5 0 0 0-.771.423v5.044a.5.5 0 0 0 .771.423l4.276-2.522a.5.5 0 0 0 0-.846L6.271 5.055z"/>
                                                        </svg>
                                                    </button>
                                                    <span class="text-theme-orange fw-medium small f-14" id="duration-<?php echo $youtube_id; ?>">Loading...</span>
                                                </div>
                                                <?php endif; ?>
                                            </h4>
                                            <div id="collapse-<?php echo $item_slug; ?>" class="accordion-collapse collapse" aria-labelledby="heading-<?php echo $item_slug; ?>" data-bs-parent="#accordionExample4">
                                                <div class="accordion-body">
                                                    <?php echo $item['content']; ?>
                                                </div>
                                            </div>
                                        </div>
                                        <?php endforeach; ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <?php endwhile; endif; ?>
                </div>
                    <script>
                document.addEventListener("DOMContentLoaded", function() {
                    const API_KEY = 'AIzaSyDp6GjV0wmZ2IXdTADrQ2m3ix7eIZ8PrY8';
                    const playButtons = document.querySelectorAll('.play-video-btn');

                    playButtons.forEach(btn => {
                        const videoId = btn.getAttribute('data-video-id');
                        if (videoId) {
                            fetch(`https://www.googleapis.com/youtube/v3/videos?part=contentDetails&id=${videoId}&key=${API_KEY}`)
                                .then(response => response.json())
                                .then(data => {
                                    const isoDuration = data.items[0].contentDetails.duration;
                                    const duration = iso8601DurationToTime(isoDuration);
                                    document.getElementById(`duration-${videoId}`).textContent = duration;
                                })
                                .catch(() => {
                                    document.getElementById(`duration-${videoId}`).textContent = 'N/A';
                                });
                        }
                    });

                    function iso8601DurationToTime(duration) {
                        const match = duration.match(/PT(\d+H)?(\d+M)?(\d+S)?/);
                        const hours = (parseInt(match[1]) || 0);
                        const minutes = (parseInt(match[2]) || 0);
                        const seconds = (parseInt(match[3]) || 0);
                        return [hours, minutes, seconds]
                            .map(v => v < 10 ? "0" + v : v)
                            .filter((v, i) => i > 0 || v !== "00")
                            .join(':');
                    }

                    // Play video on click
                    playButtons.forEach(btn => {
                        btn.addEventListener('click', function() {
                            const videoId = this.getAttribute('data-video-id');
                            const modalBody = document.getElementById('videoModalBody');
                            modalBody.innerHTML = `<iframe class="youtubeIframe" width="100%" height="400" src="https://www.youtube.com/embed/${videoId}?autoplay=1" frameborder="0" allowfullscreen></iframe>`;
                            const modal = new bootstrap.Modal(document.getElementById('videoModal'));
                            modal.show();
                        });
                    });
                });
                </script>

                <div class="youtubeModal modal fade" id="videoModal" tabindex="-1" aria-labelledby="videoModalLabel" aria-hidden="true">
                  <div class="modal-dialog modal-lg modal-dialog-centered">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="videoModalLabel">Video Preview</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>
                      <div class="modal-body" id="videoModalBody">
                      </div>
                    </div>
                  </div>
                </div>
                </div>
              </div>
            </div>
          </div>

          <div class="col-lg-4">
            <div class="excel">
              <ul>
                <li><img src="<?php echo get_stylesheet_directory_uri() ?>/images/ci1red.png" alt=""> Live classes (Online & Classroom)</li>
                <li><img src="<?php echo get_stylesheet_directory_uri() ?>/images/ci2red.png" alt=""> led by industry experts</li>
                <li><img src="<?php echo get_stylesheet_directory_uri() ?>/images/ci3red.png" alt=""> hands-on experience</li>
                <li class="separater"></li>
                <li><img src="<?php echo get_stylesheet_directory_uri() ?>/images/ci4.png" alt=""> 50+ sessions</li>
                <li><img src="<?php echo get_stylesheet_directory_uri() ?>/images/ci5.png" alt=""> 218 Hours</li>
                <li><img src="<?php echo get_stylesheet_directory_uri() ?>/images/ci6.png" alt=""> 4 Month</li>
                <li><img src="<?php echo get_stylesheet_directory_uri() ?>/images/ci7.png" alt=""> Online / Clsseoom</li>
              </ul>
              <a href="#" class="btn btn-primary d-block">Download Brochure</a>
            </div>
          </div>
        </div>
      </div>
    </div>


    <!-- Our Certification Holders -->
    <?php 
    $cert_data = get_field('our_certification_holders');
    ?>

    <div class="redcartiholder scroller" id="certification" data-anchor="certification">
        <div class="container">

            <?php if (!empty($cert_data['title'])): ?>
              <h2><?php echo esc_html($cert_data['title']); ?></h2>
            <?php endif; ?>
        
            <?php if (!empty($cert_data['short_description'])): ?>
              <p><?php echo esc_html($cert_data['short_description']); ?></p>
            <?php endif; ?>

            <?php if (!empty($cert_data) && !empty($cert_data['images'])): ?>
              <div class="owl-carousel rec-certi">
                <?php foreach ($cert_data['images'] as $image): ?>
                  <div class="item">
                    <img 
                      src="<?php echo esc_url($image); ?>" 
                      class="img-fluid bigimg"
                    />
                  </div>
                <?php endforeach; ?>
              </div>
            <?php endif; ?>

  </div>
    </div>


    <!-- Why enrol for GRRAS -->
    <div class="yourgoal whyenroll ">
      <div class="container">
        <div class="row">
          <div class="col-12">
            <?php 
            $whyEnrolSection = get_field('why_enrol_for_grras_red_hat_course');
            ?>
            <h2><?php echo $whyEnrolSection['title']; ?></h2>
          </div>
          
          <?php if(have_rows('why_enrol_for_grras_red_hat_course_points')): ?>
            <?php while(have_rows('why_enrol_for_grras_red_hat_course_points')): the_row(); ?>
                  <div class="col-lg-3 col-sm-6 col-6 g-3">
                    <div class="goalbox">
                      <img src="<?php echo get_sub_field('icon') ?>" class="img-fluid" alt="">
                      <h4><?php echo get_sub_field('title') ?></h4>
                      <?php echo get_sub_field('content') ?>
                    </div>
                  </div>
          <?php endwhile; endif; ?>
          </div>
          
          
        </div>
      </div>
    </div>

    <!-- Hiring Partners -->
<?php
	  include('components/3-line-partnersLogo.php');
?>
    <!-- Happy Student -->
    <section class="studentsay no-bg scroller" id="testimoni" data-anchor="testimoni">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <h2>Our Satisfied & Happy Students</h2>
          </div>
        </div>
        <div class="row">
          <div class="col-lg-6">
            <?php
$args = array(
  'post_type'      => 'testimonials',
  'posts_per_page' => -1,
  'post_status'    => 'publish'
);

$testimonials = new WP_Query($args);

if ($testimonials->have_posts()) :
?>
<div class="owl-carousel student-carousel">
  <?php while ($testimonials->have_posts()) : $testimonials->the_post(); 
    $designation = get_field('title');
    $company     = get_field('company');
    $content     = get_field('testimonial_content'); // optional field, else use get_the_content()
    $image_url   = get_the_post_thumbnail_url(get_the_ID(), 'medium');
    if (!$image_url) {
      $image_url = get_stylesheet_directory_uri() . '/images/student.jpg'; // fallback image
    }
  ?>
  <div class="item">
    <div class="whbox">
      <img src="<?php echo esc_url($image_url); ?>" class="img-fluid" alt="<?php echo esc_attr(get_the_title()); ?>">
      <div class="student">
        <h5><?php echo esc_html(get_the_title()); ?></h5>
        <div class="subtext"><?php echo esc_html($designation); ?> @<?php echo esc_html($company); ?></div>
      </div>
      <p class="more"><?php echo esc_html($content ? $content : get_the_content()); ?></p>
    </div>
  </div>
  <?php endwhile; wp_reset_postdata(); ?>
</div>
<?php endif; ?>

          </div>
          <div class="col-lg-6">
            <?php if(!empty(get_field('testimonial_youtube_url'))) { ?>
            <div class="videobox"><iframe width="100%" height="315" src="<?php echo get_field('testimonial_youtube_url'); ?>" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe></div>
            <?php } ?>
          </div>
        </div>
      </div>
    </section>

    


<?php
	  include('components/details-course-TopChoices.php');
	  include('components/award.php');
	  include('components/faq.php');
get_footer();
