<?php 
    $internship_detail_page = get_field('internship_detail_page','option');
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

	    

	    <div class="empower p-0">

	      <div class="container">

	        <div class="row">
                <div class="col-12">
                    <!-- Academic Partners Section -->
        <div class="trackrecord partner-section wow fadeInLeft section-padding">
            <div class="container">
                <div class="row">
                    <div class="col-12 col-lg-12 mb-4">
                        <div class="heading-area text-center">
                            <h1 class="fw-bold">Academic Partners</h1>
                            <p class="theme-text-light">At Grras Solutions, we collaborate with 45+ academic institutions and industry leaders to ensure our programs align with real-world demands. By integrating professional training, certifications, and hands-on experiences, we empower students to excel in today’s competitive job market.</p>
                        </div>
                    </div>

                    <div id="academic-partners" class="row">
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
                    </div>

                    <?php if ($academic_total > 8): ?>
                        <div class="col-12 text-center mt-3">
                          <div id="remaining-count" class="text-secondary fw-medium mb-3">
                              <?php echo esc_html($academic_total - 8); ?> more academic partners available
                          </div>
                          <button id="load-more-partners"
                                  class="btn btn-outline-primary rounded-pill btn-sm"
                                  data-offset="8"
                                  data-total="<?php echo esc_attr($academic_total); ?>"
                                  data-slug="<?php echo esc_attr($academic_slug); ?>">
                            Load More
                          </button>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
                </div>
	        </div>

	      </div>

	    </div>

