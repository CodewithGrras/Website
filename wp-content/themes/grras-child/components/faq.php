<?php 
  $faq_category_id = get_field('acf_faq_category');
  if ($faq_category_id):
    $faq_query = new WP_Query([
      'post_type' => 'faqs',
      'posts_per_page' => -1,
      'tax_query' => [
        [
          'taxonomy' => 'faq-category',
          'field' => 'term_id',
          'terms' => $faq_category_id,
        ]
      ]
    ]);
    if($faq_query->have_posts()):
?>

<section class="faqs scroller" id="faqsec" data-anchor="faqsec">
  <div class="container wow fadeInUp">
    <div class="row justify-content-center">
      <div class="col-md-12">
        <h2>Frequently Asked Questions</h2>
      </div>
    </div>

    <div class="row">
      <!-- Sidebar (Desktop) -->
      <div class="col-lg-4 d-none d-md-block">
        <ul class="nav left-tab mt-0" id="myTab" role="tablist">
          <?php 
            $count = 0;
            while ($faq_query->have_posts()): $faq_query->the_post();
              $faq_id = get_the_ID();
              $faq_slug = sanitize_title(get_the_title());
              $accordion_data = get_field('faq_accordions_data', $faq_id);
          ?>
          <li class="nav-item" role="presentation">
            <a href="#" class="nav-link <?php echo $count === 0 ? 'active' : ''; ?>"
              id="<?php echo $faq_slug; ?>-tab"
              data-bs-toggle="tab"
              data-bs-target="#<?php echo $faq_slug; ?>-tab-pane"
              role="tab"
              aria-controls="<?php echo $faq_slug; ?>-tab-pane"
              aria-selected="<?php echo $count === 0 ? 'true' : 'false'; ?>">
              <?php the_title(); ?> (<?php echo is_array($accordion_data) ? count($accordion_data) : 0; ?>)
            </a>
          </li>
          <?php 
            $count++;
            endwhile;
            wp_reset_postdata();
          ?>
        </ul>
      </div>

      <!-- Accordion Content (Desktop) -->
      <div class="col-lg-8 d-none d-md-block">
        <div class="tab-content" id="myTabContent">
          <?php 
            $count = 0;
            $faq_query->rewind_posts();
            while ($faq_query->have_posts()): $faq_query->the_post();
              $faq_id = get_the_ID();
              $faq_slug = sanitize_title(get_the_title());
              $accordion_data = get_field('faq_accordions_data', $faq_id);
          ?>
          <div class="tab-pane fade show <?php echo $count === 0 ? 'active' : ''; ?>"
            id="<?php echo $faq_slug; ?>-tab-pane"
            role="tabpanel"
            aria-labelledby="<?php echo $faq_slug; ?>-tab">
            <div class="accordion" id="accordion<?php echo $count; ?>">
              <?php if ($accordion_data): ?>
                <?php foreach ($accordion_data as $index => $item): ?>
                <div class="accordion-item">
                  <h4 class="accordion-header" id="heading-<?php echo $count . '-' . $index; ?>">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                      data-bs-target="#collapse-<?php echo $count . '-' . $index; ?>"
                      aria-expanded="false"
                      aria-controls="collapse-<?php echo $count . '-' . $index; ?>">
                      <?php echo esc_html($item['accordion_title']); ?>
                    </button>
                  </h4>
                  <div id="collapse-<?php echo $count . '-' . $index; ?>"
                    class="accordion-collapse collapse"
                    aria-labelledby="heading-<?php echo $count . '-' . $index; ?>"
                    data-bs-parent="#accordion<?php echo $count; ?>">
                    <div class="accordion-body">
                      <p><?php echo wp_kses_post($item['accordion_description']); ?></p>
                    </div>
                  </div>
                </div>
                <?php endforeach; ?>
              <?php endif; ?>
            </div>
          </div>
          <?php 
            $count++;
            endwhile;
            wp_reset_postdata();
          ?>
        </div>
      </div>

      <!-- Mobile Accordion View -->
      <div class="col-lg-12 d-block d-md-none">
        <div class="accordion" id="mobileFAQ">
          <?php 
            $faq_query->rewind_posts();
            $count = 0;
            while ($faq_query->have_posts()): $faq_query->the_post();
              $faq_id = get_the_ID();
              $faq_title = get_the_title();
              $accordion_data = get_field('faq_accordions_data', $faq_id);
          ?>
          <div class="accordion-item">
            <h4 class="accordion-header" id="mobileHeading<?php echo $count; ?>">
              <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                data-bs-target="#mobileCollapse<?php echo $count; ?>" aria-expanded="false"
                aria-controls="mobileCollapse<?php echo $count; ?>">
                <?php echo esc_html($faq_title); ?> (<?php echo is_array($accordion_data) ? count($accordion_data) : 0; ?>)
              </button>
            </h4>
            <div id="mobileCollapse<?php echo $count; ?>" class="accordion-collapse collapse"
              aria-labelledby="mobileHeading<?php echo $count; ?>" data-bs-parent="#mobileFAQ">
              <div class="accordion-body">
                <div class="accordion" id="nestedMobileAccordion<?php echo $count; ?>">
                  <?php if ($accordion_data): ?>
                    <?php foreach ($accordion_data as $index => $item): ?>
                    <div class="accordion-item">
                      <h4 class="accordion-header" id="nestedMobileHeading<?php echo $count . '-' . $index; ?>">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                          data-bs-target="#nestedMobileCollapse<?php echo $count . '-' . $index; ?>"
                          aria-expanded="false"
                          aria-controls="nestedMobileCollapse<?php echo $count . '-' . $index; ?>">
                          <?php echo esc_html($item['accordion_title']); ?>
                        </button>
                      </h4>
                      <div id="nestedMobileCollapse<?php echo $count . '-' . $index; ?>"
                        class="accordion-collapse collapse"
                        aria-labelledby="nestedMobileHeading<?php echo $count . '-' . $index; ?>"
                        data-bs-parent="#nestedMobileAccordion<?php echo $count; ?>">
                        <div class="accordion-body">
                          <p><?php echo esc_html($item['accordion_description']); ?></p>
                        </div>
                      </div>
                    </div>
                    <?php endforeach; ?>
                  <?php endif; ?>
                </div>
              </div>
            </div>
          </div>
          <?php 
            $count++;
            endwhile;
            wp_reset_postdata();
          ?>
        </div>
      </div>

    </div>
  </div>
</section>

<?php endif; endif; ?>
