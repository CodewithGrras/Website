<?php

/**
 * Template Name: Services Page Template
 *
 *  */
get_header();
?>
<div class="contactform refer-section image-position-right position-relative wow fadeInUp bg-theme-light section-padding overflow-hidden">
        <div class="container">
          <div class="row align-items-center">
            <div class="col-12 col-md-7 wow fadeInLeft  mb-4 mb-md-0">
              <div class="banner-content text-center text-md-start">
                <h1 class="fw-bold mb-3 pb-0"><?php echo get_field('banner_title'); ?></h1>
                <?php
                $full_text = get_field('banner_description');
                $short_text = mb_substr($full_text, 0, 100);
                $is_long = mb_strlen($full_text) > 100;

                $attachment_id = get_field('download_button_attachment');
                $attachment_url = $attachment_id ? wp_get_attachment_url($attachment_id) : 'javascript:void(0)';
                $download_attr = $attachment_id ? 'download' : '';
                ?>

                <p class="mb-0">
                <span class="short-text"><?php echo esc_html($short_text); ?></span>
                <?php if ($is_long): ?>
                    <span class="dots">...</span>
                    <span class="more-text d-none"><?php echo esc_html(mb_substr($full_text, 100)); ?></span>
                    <a href="javascript:void(0);" class="theme-text-primary fw-semibold text-decoration-none toggle-more">Read more</a>
                <?php endif; ?>
                </p>
                <hr class="w-75 w-75 my-lg-5"/>
                <a 
                    href="<?php echo $attachment_url; ?>" 
                    class="align-items-center btn btn-primary btn-sm btnwith-icon-sm d-inline-flex justify-content-center p-2 rounded-2 text-center"
                    target="_blank"
                    rel="noopener"
                    <?php echo $download_attr; ?>
                >
                  <span class="pe-3 ps-2">Download Services Brochure</span>
                  <span class="btn-icon d-inline-flex justify-content-center align-items-center rounded-1 bg-white">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20px" height="20px" viewBox="0 0 23 23" fill="none">
                      <path d="M6.21305 7.32844V6.23463C6.23791 5.76231 6.6108 5.38942 7.05827 5.38942L16.7285 5.36456C17.2008 5.38942 17.5737 5.76231 17.5737 6.20977V15.9049C17.5737 16.3523 17.2008 16.7252 16.7285 16.7501H15.6347C15.1624 16.7252 14.7895 16.3523 14.7646 15.88L14.9138 10.0132L7.77919 17.1478C7.43116 17.4959 6.93397 17.4959 6.58594 17.1478L5.79045 16.3523C5.46728 16.0292 5.44242 15.5071 5.79045 15.1591L12.925 8.0245L7.08313 8.19851C6.6108 8.17365 6.21305 7.82563 6.21305 7.32844Z" fill="black"/>
                      </svg>
                  </span>
                </a>
              </div>
            </div>
            <div class="col-12 col-md-5 position-relative">
              <div class="aboutvideo position-relative">
                  <div class="coform wow fadeInLeft rounded-2 bg-white position-relative">
                    <h5 class="text-start fw-semibold mb-3 text-center">Contact Us</h5>
                    <?php echo do_shortcode('[gravityform id="31" title="false" ajax="true"]') ?>
                  </div>
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
          <button id="nextBtn" type="button" class="px-2 bg-white p-0 border-0 position-absolute">
            <svg xmlns="http://www.w3.org/2000/svg" width="9" height="16" viewBox="0 0 9 16" fill="none">
              <path d="M0.000768682 13.7422L1.62011 15.5L8.5293 8L1.62011 0.5L0.000768819 2.25781L5.29062 8L0.000768682 13.7422Z" fill="#EF7220"/>
            </svg>
          </button>
        </div>
        <div id="scrollingMenu" class="menu bg-white p-2">
            <ul class="list-unstyled mb-0  d-flex position-relative justify-content-center">
              <li class="menu-item active" data-target="overviewsection" >Corporate Trainings</li>
              <li class="menu-item" data-target="solutionsection">Training Programs</li>
              <li class="menu-item" data-target="partnerssection">Internship</li>
              <li class="menu-item" data-target="industrysection">Academic Collaborations</li>
              <li class="menu-item" data-target="awardsection">Masterclasses</li>
              <!-- <li id="lastdiv" class="menu-item" data-target="eventssection">Industry Certification</li> -->
            </ul>
        </div>
      </div>
      
      <div class="menu-area">
        <div id="overviewsection" class="contentarea active">

            
            <!-- company logo -->
            <div class="container-fluid wow fadeInUp">
              <div class="cologo homecologo talentbox">
                <p class="fw-medium"><?php echo get_field('corporate_training_trusted_heading'); ?></p>
                <?php
                $galleries = get_field('corporate_training_trusted_gallery'); // Array of attachment IDs
                if ($galleries && is_array($galleries)) : ?>
                <div class="owl-carousel top-company">
                    <?php foreach ($galleries as $image_id) : 
                    $img_url = wp_get_attachment_image_url($image_id, 'full'); // You can choose other sizes like 'medium'
                    $alt_text = get_post_meta($image_id, '_wp_attachment_image_alt', true);
                    ?>
                    <div class="item">
                        <img src="<?php echo esc_url($img_url); ?>" class="img-fluid" alt="<?php echo esc_attr($alt_text ?: ''); ?>">
                    </div>
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>
              </div>
            </div>
            <!-- End company logo -->

            <!-- Turnover -->
            <div class="turnover wow fadeInUp">
              <div class="container">
                <div class="rounded-4 p-4 p-lg-5 bg-theme-light-gradient">
                  <div class="row">
                    <div class="col-12 col-lg-5  text-center text-md-start">
                      <h2 class="mb-3"><?php echo get_field('corporate_training_that_drives_success_heading'); ?></h2>
                      <p><?php echo get_field('corporate_training_that_drives_success_description'); ?></p>
                    </div>
                    <div class="col-12 col-lg-7">
                      <div class="row">
                        <div class="col-md-4 col-4 g-3 text-center bold-counter">
                          <div class="icon float-none w-auto h-auto pt-0 ">
                            <svg xmlns="http://www.w3.org/2000/svg" width="41" height="41" viewBox="0 0 41 41" fill="none">
                                <g clip-path="url(#clip0_567_4025)">
                                <path d="M28.5893 12.419L26.7549 14.2533C27.0596 14.8319 27.3164 15.4344 27.5228 16.0548C28.2937 15.9201 29.0749 15.8531 29.8575 15.8546H30.0749C29.7287 14.6506 29.2294 13.4959 28.5893 12.419ZM0.650391 20.0237C0.653522 22.1745 1.11825 24.2995 2.01319 26.2552C2.90812 28.2109 4.2124 29.9517 5.8379 31.36C7.4634 32.7683 9.37226 33.8113 11.4355 34.4186C13.4987 35.0258 15.6682 35.1831 17.7975 34.8799C17.4239 34.1073 17.1279 33.2995 16.9139 32.4685C16.4986 32.5158 16.0809 32.5383 15.6629 32.5357C12.3447 32.5357 9.16244 31.2176 6.81614 28.8713C4.46983 26.525 3.15169 23.3427 3.15169 20.0245C3.15169 16.7063 4.46983 13.5241 6.81614 11.1778C9.16244 8.83146 12.3447 7.51332 15.6629 7.51332C17.6797 7.51186 19.6662 8.0042 21.449 8.94733L23.2833 7.11299C20.9804 5.7351 18.3465 5.00865 15.6629 5.01124C11.6831 5.01703 7.86798 6.60056 5.05385 9.41469C2.23971 12.2288 0.656182 16.044 0.650391 20.0237Z" fill="#EF7221"/>
                                <path d="M6.48633 20.0238C6.49046 22.456 7.45837 24.7874 9.17804 26.5074C10.8977 28.2274 13.229 29.1957 15.6612 29.2002C15.9455 29.1999 16.2295 29.1832 16.5119 29.1502C16.508 28.2914 16.5898 27.4344 16.7558 26.5918C16.3949 26.6595 16.0284 26.693 15.6612 26.6919C13.8914 26.6919 12.1942 25.9889 10.9428 24.7375C9.69143 23.4861 8.98841 21.7889 8.98841 20.0191C8.98841 18.2494 9.69143 16.5522 10.9428 15.3008C12.1942 14.0494 13.8914 13.3464 15.6612 13.3464C16.082 13.3388 16.5021 13.3829 16.9122 13.4778L18.9311 11.4589C17.8901 11.0469 16.7807 10.8347 15.6612 10.8334C13.2269 10.8392 10.8943 11.8098 9.17445 13.5325C7.45464 15.2553 6.48798 17.5896 6.48633 20.0238Z" fill="#EF7221"/>
                                <path d="M15.6618 16.6897C15.002 16.6897 14.357 16.8854 13.8084 17.252C13.2599 17.6185 12.8323 18.1396 12.5799 18.7492C12.3275 19.3588 12.2615 20.0295 12.3904 20.6766C12.5192 21.3237 12.8371 21.918 13.3037 22.3845C13.7703 22.8509 14.3648 23.1684 15.012 23.297C15.6591 23.4255 16.3299 23.3592 16.9393 23.1065C17.5488 22.8538 18.0696 22.426 18.436 21.8773C18.8023 21.3286 18.9977 20.6835 18.9974 20.0237C18.9945 19.1401 18.6421 18.2935 18.0171 17.6688C17.3921 17.0442 16.5454 16.6922 15.6618 16.6897ZM15.6618 20.8588C15.4969 20.8588 15.3358 20.8099 15.1987 20.7183C15.0616 20.6267 14.9548 20.4966 14.8917 20.3443C14.8286 20.192 14.8121 20.0244 14.8443 19.8627C14.8764 19.701 14.9558 19.5525 15.0724 19.4359C15.189 19.3193 15.3375 19.24 15.4992 19.2078C15.6608 19.1756 15.8284 19.1921 15.9807 19.2552C16.133 19.3183 16.2632 19.4251 16.3548 19.5622C16.4464 19.6993 16.4953 19.8604 16.4953 20.0253C16.4963 20.135 16.4755 20.2439 16.434 20.3455C16.3924 20.4471 16.3311 20.5394 16.2535 20.617C16.1759 20.6946 16.0836 20.756 15.982 20.7975C15.8804 20.839 15.7715 20.8598 15.6618 20.8588Z" fill="#EF7221"/>
                                <path d="M15.6759 21.2748C15.4285 21.275 15.1866 21.2018 14.9808 21.0646C14.7749 20.9273 14.6144 20.7321 14.5195 20.5037C14.4246 20.2752 14.3996 20.0237 14.4476 19.781C14.4956 19.5384 14.6145 19.3153 14.7892 19.1402L25.631 8.29524C25.8675 8.07052 26.1825 7.9471 26.5087 7.95127C26.8349 7.95545 27.1466 8.0869 27.3773 8.31759C27.608 8.54829 27.7395 8.85997 27.7436 9.1862C27.7478 9.51242 27.6244 9.82737 27.3997 10.0639L16.5578 20.9057C16.3243 21.1407 16.0071 21.2734 15.6759 21.2748Z" fill="#FB5607"/>
                                <path d="M31.1077 10.0153H26.9371C26.6053 10.0153 26.2871 9.8835 26.0525 9.64888C25.8178 9.41426 25.686 9.09606 25.686 8.76426V4.59516C25.6863 4.26322 25.8172 3.94471 26.0504 3.70849L29.386 0.372896C29.561 0.197736 29.784 0.0784276 30.0268 0.0300743C30.2696 -0.0182789 30.5213 0.00649751 30.75 0.101267C30.9787 0.196037 31.1742 0.356538 31.3116 0.562451C31.4491 0.768365 31.5223 1.01043 31.5221 1.25801V4.17919H34.4433C34.6909 4.179 34.933 4.25226 35.1389 4.38972C35.3448 4.52717 35.5053 4.72263 35.6001 4.95135C35.6948 5.18007 35.7196 5.43176 35.6713 5.67457C35.6229 5.91738 35.5036 6.14038 35.3284 6.31535L31.9928 9.65094C31.7578 9.88492 31.4394 10.016 31.1077 10.0153ZM29.8567 18.3566C27.712 18.3563 25.6154 18.992 23.832 20.1833C22.0486 21.3746 20.6585 23.068 19.8376 25.0494C19.0166 27.0307 18.8017 29.211 19.2199 31.3145C19.6381 33.418 20.6707 35.3503 22.1871 36.8669C23.7035 38.3836 25.6357 39.4164 27.7391 39.835C29.8426 40.2535 32.0229 40.0388 34.0044 39.2182C35.9858 38.3975 37.6794 37.0077 38.871 35.2245C40.0625 33.4412 40.6985 31.3447 40.6985 29.2C40.6961 26.3252 39.553 23.5688 37.5204 21.5359C35.4877 19.5029 32.7315 18.3595 29.8567 18.3566ZM34.5278 27.1311L29.1108 32.9688C28.8909 33.2068 28.5873 33.3502 28.2638 33.3689C27.9404 33.3876 27.6223 33.28 27.3765 33.0689L24.4569 30.5668C24.331 30.4602 24.2274 30.3299 24.1521 30.1831C24.0768 30.0364 24.0312 29.8762 24.018 29.7118C24.0049 29.5474 24.0243 29.382 24.0753 29.2252C24.1263 29.0683 24.2077 28.9231 24.3151 28.7979C24.4224 28.6726 24.5534 28.5698 24.7006 28.4954C24.8477 28.421 25.0082 28.3764 25.1727 28.3642C25.3371 28.352 25.5024 28.3725 25.6589 28.4244C25.8155 28.4763 25.9602 28.5587 26.0848 28.6668L28.0927 30.387L32.6966 25.4313C32.9222 25.1878 33.2353 25.044 33.567 25.0313C33.8986 25.0187 34.2218 25.1384 34.4652 25.364C34.7087 25.5896 34.8525 25.9027 34.8651 26.2344C34.8778 26.5661 34.7581 26.8892 34.5325 27.1327L34.5278 27.1311Z" fill="#FB5607"/>
                                </g>
                                <defs>
                                <clipPath id="clip0_567_4025">
                                <rect width="40.049" height="40.049" fill="white" transform="translate(0.650391)"/>
                                </clipPath>
                                </defs>
                            </svg>
                          </div>
                          <p><big class="d-block my-2"><?php echo get_field('companies_trained'); ?></big>Companies Trained</p>
                        </div>
                        <div class="col-md-4 col-4 g-3 text-center bold-counter">
                          <div class="icon float-none w-auto h-auto pt-0">
                            <svg xmlns="http://www.w3.org/2000/svg" width="41" height="41" viewBox="0 0 41 41" fill="none">
                              <g clip-path="url(#clip0_567_4034)">
                              <path d="M5.59379 17.5215C5.25439 17.5224 4.92277 17.4199 4.64313 17.2275C4.3635 17.0352 4.14915 16.7621 4.02866 16.4449C3.90816 16.1276 3.88725 15.7811 3.96872 15.4516C4.05018 15.1221 4.23015 14.8253 4.48462 14.6007L11.9938 7.92536C12.1704 7.76801 12.3786 7.65019 12.6044 7.57977C12.8302 7.50936 13.0685 7.48797 13.3032 7.51705L26.2879 9.09241L33.6406 2.12139C33.9624 1.81602 34.3922 1.65097 34.8357 1.66256C35.2791 1.67415 35.6998 1.86142 36.0052 2.18318C36.3106 2.50494 36.4756 2.93484 36.464 3.37829C36.4524 3.82174 36.2652 4.24242 35.9434 4.54779L28.0165 12.057C27.8382 12.2251 27.6252 12.3522 27.3925 12.4292C27.1598 12.5062 26.913 12.5314 26.6696 12.5028L13.649 10.9243L6.70296 17.1038C6.39793 17.3765 6.00294 17.5269 5.59379 17.5262V17.5215Z" fill="#EF7221"/>
                              <path d="M36.0495 9.17857C35.8848 9.1789 35.7217 9.14674 35.5695 9.08392C35.4173 9.0211 35.279 8.92886 35.1625 8.81249L29.3241 2.97097C29.149 2.79603 29.0296 2.57309 28.9812 2.33033C28.9328 2.08757 28.9574 1.83591 29.0521 1.60716C29.1467 1.37842 29.307 1.18287 29.5127 1.04524C29.7185 0.907618 29.9604 0.834099 30.208 0.833984H36.0479C36.3799 0.833984 36.6982 0.965842 36.9329 1.20055C37.1676 1.43526 37.2995 1.75359 37.2995 2.08552V7.92547C37.2993 8.17318 37.2256 8.41526 37.0878 8.62106C36.9499 8.82687 36.7541 8.98713 36.5251 9.08157C36.3748 9.146 36.213 9.17901 36.0495 9.17857Z" fill="#EF7221"/>
                              <path d="M12.272 29.6192V34.2076H2.25977V29.6192C2.25977 29.0661 2.47947 28.5357 2.87055 28.1446C3.26164 27.7536 3.79206 27.5339 4.34513 27.5339H10.1851C10.7383 27.5339 11.2689 27.7535 11.6602 28.1445C12.0515 28.5356 12.2716 29.066 12.272 29.6192ZM25.6211 19.607V34.2076H15.6089V19.607C15.6089 19.0539 15.8286 18.5235 16.2197 18.1324C16.6108 17.7413 17.1412 17.5216 17.6943 17.5216H23.5342C23.8082 17.5214 24.0795 17.5752 24.3327 17.6799C24.5859 17.7846 24.816 17.9382 25.0098 18.1318C25.2036 18.3255 25.3574 18.5555 25.4623 18.8086C25.5672 19.0617 25.6211 19.333 25.6211 19.607ZM38.9703 22.9454V34.2092H28.958V22.9454C28.9576 22.6714 29.0113 22.4 29.1159 22.1467C29.2205 21.8934 29.3741 21.6632 29.5678 21.4694C29.7615 21.2755 29.9916 21.1218 30.2448 21.017C30.498 20.9121 30.7694 20.8583 31.0434 20.8585H36.8849C37.159 20.8581 37.4305 20.9118 37.6838 21.0165C37.9371 21.1213 38.1672 21.275 38.361 21.4689C38.5547 21.6628 38.7083 21.8931 38.8128 22.1464C38.9174 22.3998 38.9709 22.6713 38.9703 22.9454Z" fill="#FB5607"/>
                              <path d="M39.3853 39.2152H1.83942C1.50749 39.2152 1.18916 39.0834 0.954455 38.8487C0.719748 38.6139 0.587891 38.2956 0.587891 37.9637C0.587891 37.6318 0.719748 37.3134 0.954455 37.0787C1.18916 36.844 1.50749 36.7122 1.83942 36.7122H39.3853C39.7173 36.7122 40.0356 36.844 40.2703 37.0787C40.505 37.3134 40.6369 37.6318 40.6369 37.9637C40.6369 38.2956 40.505 38.6139 40.2703 38.8487C40.0356 39.0834 39.7173 39.2152 39.3853 39.2152Z" fill="#EF7221"/>
                              </g>
                              <defs>
                              <clipPath id="clip0_567_4034">
                              <rect width="40.049" height="40.049" fill="white" transform="translate(0.587891)"/>
                              </clipPath>
                              </defs>
                            </svg>
                          </div>
                          <p><big class="d-block my-2"><?php echo get_field('skill_improvement_reported'); ?></big>Skill Improvement Reported</p>
                        </div>
                        <div class="col-md-4 col-4 g-3 text-center bold-counter">
                          <div class="icon float-none w-auto h-auto pt-0">
                            <svg xmlns="http://www.w3.org/2000/svg" width="41" height="41" viewBox="0 0 41 41" fill="none">
                              <g clip-path="url(#clip0_567_4042)">
                              <path d="M11.808 13.5338L11.2574 10.2485L11.4779 10.0295L10.7959 9.32863C10.3088 8.83597 9.96683 8.21875 9.80734 7.54461C9.64784 6.87047 9.677 6.16543 9.89163 5.50677C9.90884 5.45671 9.92292 5.42385 9.94169 5.37379L9.72267 5.34094L8.3147 2.38733C8.21382 2.17189 8.05362 1.98966 7.85288 1.862C7.65214 1.73435 7.41918 1.66655 7.18129 1.66655C6.94339 1.66655 6.71043 1.73435 6.50969 1.862C6.30895 1.98966 6.14875 2.17189 6.04787 2.38733L4.65867 5.35971L1.57834 5.83999C1.35207 5.87801 1.1406 5.97751 0.96706 6.1276C0.793516 6.27769 0.664573 6.4726 0.594323 6.69103C0.521891 6.90957 0.511622 7.14394 0.564662 7.36798C0.617702 7.59201 0.731963 7.7969 0.894691 7.95977L3.16465 10.2798L2.62962 13.5651C2.60228 13.7438 2.61364 13.9263 2.66293 14.1002C2.71222 14.2741 2.79829 14.4355 2.91532 14.5732C3.03235 14.711 3.17761 14.8221 3.34127 14.8989C3.50493 14.9757 3.68317 15.0164 3.86395 15.0184C4.08235 15.0195 4.29753 14.9657 4.48971 14.862L7.22587 13.3273L9.97924 14.8291C10.1864 14.9416 10.4205 14.9948 10.6559 14.9829C10.8913 14.9711 11.1189 14.8946 11.3137 14.7618C11.5051 14.6243 11.6539 14.4354 11.7427 14.2171C11.8316 13.9987 11.8569 13.7597 11.8159 13.5275L11.808 13.5338ZM40.5088 6.64097C40.4369 6.42205 40.3049 6.22777 40.1279 6.08032C39.9508 5.93287 39.7358 5.8382 39.5075 5.80714L36.421 5.33781L35.013 2.3842C34.9123 2.16832 34.7521 1.98567 34.5512 1.8577C34.3502 1.72972 34.117 1.66174 33.8788 1.66174C33.6406 1.66174 33.4073 1.72972 33.2064 1.8577C33.0055 1.98567 32.8453 2.16832 32.7446 2.3842L31.3585 5.35658L31.1755 5.38944C31.1755 5.40665 31.1927 5.42229 31.1927 5.4395C31.417 6.09028 31.4563 6.79058 31.306 7.46236C31.1557 8.13413 30.8219 8.75097 30.3416 9.24415L29.5954 10.0123L29.8629 10.2798L29.3295 13.5651C29.3021 13.7438 29.3135 13.9263 29.3628 14.1002C29.4121 14.2741 29.4981 14.4355 29.6152 14.5732C29.7322 14.711 29.8774 14.8221 30.0411 14.8989C30.2048 14.9757 30.383 15.0164 30.5638 15.0184C30.7822 15.0195 30.9974 14.9657 31.1896 14.862L33.9257 13.3273L36.6791 14.8291C36.8862 14.9416 37.1203 14.9948 37.3558 14.9829C37.5912 14.9711 37.8187 14.8946 38.0135 14.7618C38.2039 14.6233 38.3516 14.4343 38.4401 14.2162C38.5286 13.998 38.5542 13.7595 38.5141 13.5275L37.9635 10.2422L40.2334 7.90814C40.3915 7.74174 40.5014 7.53549 40.5513 7.31145C40.6011 7.08741 40.5892 6.85402 40.5166 6.63627L40.5088 6.64097Z" fill="#EF7221"/>
                              <path d="M16.1981 16.6876C16.0171 16.6878 15.8382 16.6487 15.6738 16.5731C15.5094 16.4974 15.3633 16.387 15.2457 16.2495C15.128 16.1119 15.0416 15.9504 14.9924 15.7763C14.9432 15.6021 14.9324 15.4193 14.9607 15.2405L15.6819 10.735L12.5718 7.56707C12.4106 7.40305 12.2977 7.1978 12.2455 6.97383C12.1934 6.74986 12.2039 6.51585 12.276 6.29747C12.3481 6.0791 12.4789 5.88481 12.6542 5.73593C12.8295 5.58706 13.0424 5.48935 13.2695 5.45355L17.5075 4.79336L19.402 0.725888C19.5017 0.510573 19.6605 0.328014 19.8599 0.199495C20.0593 0.0709749 20.2912 0.00178823 20.5284 0C20.7655 6.28997e-05 20.9976 0.0674361 21.1978 0.19428C21.3981 0.321123 21.5582 0.502222 21.6595 0.716501L23.5822 4.76833L27.8248 5.40192C28.0524 5.43546 28.2664 5.5311 28.4432 5.67831C28.62 5.82553 28.7528 6.01863 28.827 6.2364C28.9012 6.45417 28.914 6.68818 28.8638 6.91272C28.8137 7.13726 28.7027 7.34364 28.5429 7.50918L25.4485 10.6975L26.1994 15.1983C26.2384 15.4301 26.2114 15.6683 26.1213 15.8855C26.0312 16.1027 25.8817 16.2901 25.6901 16.4263C25.4984 16.5625 25.2722 16.6419 25.0374 16.6555C24.8027 16.669 24.5689 16.6162 24.3628 16.503L20.5785 14.4301L16.8051 16.5296C16.6195 16.6328 16.4105 16.6866 16.1981 16.686V16.6876Z" fill="#FB5607"/>
                              <path d="M7.20408 28.3675C9.047 28.3675 10.541 26.8735 10.541 25.0306C10.541 23.1877 9.047 21.6937 7.20408 21.6937C5.36117 21.6937 3.86719 23.1877 3.86719 25.0306C3.86719 26.8735 5.36117 28.3675 7.20408 28.3675Z" fill="#EF7221"/>
                              <path d="M11.6581 30.7047C10.7924 31.3569 10.09 32.2013 9.6065 33.1713C9.12297 34.1414 8.8715 35.2105 8.87192 36.2944V36.7121H1.77888C1.44771 36.7096 1.1308 36.577 0.896624 36.3428C0.662447 36.1086 0.529801 35.7917 0.527345 35.4606V34.6267C0.526934 34.024 0.645325 33.4271 0.87575 32.8701C1.10617 32.3131 1.44412 31.807 1.87025 31.3808C2.29639 30.9545 2.80236 30.6164 3.35925 30.3857C3.91614 30.1551 4.51302 30.0365 5.11577 30.0367H9.28806C10.1244 30.0377 10.9444 30.2688 11.6581 30.7047Z" fill="#EF7221"/>
                              <path d="M33.9013 28.3675C35.7443 28.3675 37.2382 26.8735 37.2382 25.0306C37.2382 23.1877 35.7443 21.6937 33.9013 21.6937C32.0584 21.6937 30.5645 23.1877 30.5645 25.0306C30.5645 26.8735 32.0584 28.3675 33.9013 28.3675Z" fill="#EF7221"/>
                              <path d="M40.5765 34.6252V35.459C40.5736 35.79 40.4409 36.1067 40.2068 36.3408C39.9727 36.5749 39.656 36.7077 39.325 36.7105H32.2335V36.2944C32.2342 35.2105 31.9828 34.1412 31.4992 33.1712C31.0157 32.2011 30.3132 31.3567 29.4473 30.7047C30.1604 30.2686 30.9799 30.0375 31.8158 30.0367H35.9881C36.5907 30.0365 37.1874 30.1551 37.7442 30.3856C38.301 30.6161 38.8069 30.9541 39.233 31.3802C39.6592 31.8063 39.9971 32.3122 40.2276 32.869C40.4582 33.4258 40.5767 34.0225 40.5765 34.6252Z" fill="#EF7221"/>
                              <path d="M20.553 29.203C23.3178 29.203 25.5591 26.9617 25.5591 24.1969C25.5591 21.4321 23.3178 19.1908 20.553 19.1908C17.7882 19.1908 15.5469 21.4321 15.5469 24.1969C15.5469 26.9617 17.7882 29.203 20.553 29.203Z" fill="#FB5607"/>
                              <path d="M25.1399 31.7059H15.9615C14.7448 31.7068 13.5782 32.1904 12.7179 33.0508C11.8576 33.9111 11.3739 35.0777 11.373 36.2944V38.7974C11.373 39.1293 11.5049 39.4477 11.7396 39.6824C11.9743 39.9171 12.2927 40.0489 12.6246 40.0489H28.4768C28.8087 40.0489 29.127 39.9171 29.3617 39.6824C29.5964 39.4477 29.7283 39.1293 29.7283 38.7974V36.2944C29.7275 35.0777 29.2438 33.9111 28.3835 33.0508C27.5232 32.1904 26.3566 31.7068 25.1399 31.7059Z" fill="#FB5607"/>
                              </g>
                              <defs>
                              <clipPath id="clip0_567_4042">
                              <rect width="40.049" height="40.049" fill="white" transform="translate(0.527344)"/>
                              </clipPath>
                              </defs>
                            </svg>
                          </div>
                          <p><big class="d-block my-2"><?php echo get_field('years_of_corporate_training_expertise'); ?></big>Years of Corporate Training Expertise</p>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!-- End Turnover -->

            <!-- List Section -->
            <div class="jobopen bg-image-none pt-5 wow fadeInUp bg-transparent">
              <div class="container">
                <div class="row mb-4 mb-lg-5 heading-area">
                  <div class="col-12 col-lg-5">
                    <h2 class="fw-bold fw-semibold mb-2"><?php echo get_field('unlock_team_potential_with_real-world_learning_heading'); ?></h2>
                  </div>
                  <div class="col-12 col-lg-7">
                    <div class="subtext"><p><?php echo get_field('unlock_team_potential_with_real-world_learning_description'); ?></p></div>
                  </div>
                </div>
                <?php
                $unlock_team_rows = get_field('unlock_team_rows'); 
                if(!empty($unlock_team_rows)) {
                    foreach($unlock_team_rows as $key=>$row) {
                ?>
                <div class="jobox bg-transparent">
                  <div class="row align-items-center">
                    <div class="col-12 col-lg-5">
                      <h4 class="text-capitalize"><?php echo $row['title']; ?></h4>
                    </div>
                    <div class="col-12 col-lg-7">
                      <div class="theme-text-light text-start"><?php echo $row['description']; ?></div>
                    </div>
                  </div>
                </div>
                <?php } } ?>
              </div>
            </div>
            <!-- End List Section -->

            <!-- Help Section -->
            <div class="help-section bg-image-hide wow fadeInUp bg-theme-light section-padding position-relative">
              <div class="container">
                <div class="row justify-content-center">
                  <div class="col-12 col-lg-12 col-xl-10">
                    <div class="heading-area text-center">
                      <h2 class="fw-bold mb-3 mb-md-4"><?php echo get_field('custom_programs_heading'); ?></h2>
                      <p><?php echo get_field('custom_programs_description'); ?></p>
                    </div>
                  </div>
                </div>
                <div class="row justify-content-center mt-4 mt-lg-5">
                  <?php 
                  $custom_programs_rows = get_field('custom_programs_rows');
                    if(!empty($custom_programs_rows)) {
                        foreach($custom_programs_rows as $key=>$row) {
                  ?>
                  <div class="col-6 col-sm-6 col-lg-3 mb-3 mb-lg-0">
                    <div class="card border brd-theme rounded-4 h-100">
                      <div class="card-body p-lg-4">
                          <div class="cardicon mb-2">
                            <?php echo $row['svg_code']; ?>
                          </div>
                          <h5><?php echo $row['program_title']; ?></h5>
                          <p class="mb-0 theme-text-light"><?php echo $row['program_description']; ?></p>
                      </div>
                    </div>
                  </div>
                  <?php } } ?>
                </div>
              </div>
            </div>
            <!-- End Help Section -->


            <!-- The Summer Training program 2023 Provides -->
            <div class="thesummer wow fadeInUp bg-transparent bg-image-none">
              <div class="container">
                <div class="row">
                  <div class="col-lg-12">
                    <div class="heading-area text-center mb-4 mb-lg-5">
                      <h2 class="fw-semibold mb-3"><?php echo get_field('explore_our_corporate_heading'); ?></h2>
                      <p><?php echo get_field('explore_our_corporate_description'); ?></p>
                    </div>
                  </div>
                </div>
                <div class="row g-3">
                  <?php
                $args = array(
                'post_type'      => 'training-program',
                'post_status'    => 'publish',
                'posts_per_page' => 6,
                );

                $query = new WP_Query($args);

                if ($query->have_posts()) :
                    $count = 1;
                while ($query->have_posts()) : $query->the_post();
                    $svg_code = get_post_meta(get_the_ID(), 'svg_code', true);
                    ?>
                    
                    <div class="col-6 col-sm-6 col-lg-4">
                    <div class="d-flex align-items-center gap-1 gap-md-3 p-2 p-md-3 explorearea explore-<?php echo $count; ?>">
                        <div class="iconarea d-flex align-items-center justify-content-center">
                        <?php
                        if ($svg_code) {
                            echo $svg_code;
                        }
                        ?>
                        </div>
                        <div>
                        <h6 class="mb-1 fw-semibold"><?php echo get_the_title(); ?></h6>
                        </div>
                    </div>
                    </div>
                    
                    <?php
                    $count++;
                endwhile;
                wp_reset_postdata();
                endif;
                ?>

                  
                  <div class="col-12 col-sm-12 text-center">
                    <a href="<?php echo get_post_type_archive_link('training-program'); ?>" class="text-decoration-none theme-color-text">View All Training Programs</a>
                    <div class="d-flex jus mx-auto w-50 mt-4 btn-area justify-content-center">
                      <button data-bs-toggle="modal" data-bs-target="#exampleModal2" type="button" class="btn btn-primary f16">Download full course list</button>
                      <button data-bs-toggle="modal" data-bs-target="#exampleModal2" type="button" class="btn btn-outline-primary f16 me-0 ms-2 ms-lg-3 fw-medium theme-text-dark">Looking for Something Specific? We can build it.</button>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Collaborating Section -->
            <div class="help-section bg-theme-light collaborate-section wow fadeInUp section-padding pb-0">
              <div class="container">
                <div class="row justify-content-center">
                  <div class="col-12 col-lg-6">
                    <div class="d-flex flex-column justify-content-between h-100">
                      <div class="heading-area mt-lg-5">
                        <h2 class="fw-semibold mb-3"><?php echo get_field('why_top_companies_choose_grras_heading'); ?></h2>
                        <p class="theme-text-light"><?php echo get_field('why_top_companies_choose_grras_description'); ?></p>
                      </div>
                      <div class="vector-image d-none d-md-block">
                        <?php
                        $attachment_id = get_post_meta(get_the_ID(), 'why_top_companies_choose_grras_bottom_image', true);
                        $vectorImage = $attachment_id ? wp_get_attachment_url($attachment_id) : '';

                        if ($vectorImage): ?>
                            <img src="<?php echo esc_url($vectorImage); ?>" class="img-fluid" />
                        <?php endif; ?>
                      </div>
                    </div>
                  </div>
                  <div class="col-12 col-lg-6 mb-4">
                    <div class="info-card p-3 bg-white mb-3 rounded theme-box-shadow wow fadeInUp mb-3">
                      <div class="d-flex">
                        <div class="card-icon theme-color-text bg-theme-light p-2 rounded-pill me-3 card-icon-sm d-flex justify-content-center align-items-center">1</div>
                        <div class="card-data">
                            <h5>15+ Years of Industry Expertise</h5>
                            <p class="mb-0">Backed by over a decade of experience delivering impactful tech training to businesses across sectors.</p>
                        </div>
                      </div>
                    </div>
                    <div class="info-card p-3 bg-white mb-3 rounded theme-box-shadow wow fadeInUp mb-3">
                      <div class="d-flex">
                        <div class="card-icon theme-color-text bg-theme-light p-2 rounded-pill me-3 card-icon-sm d-flex justify-content-center align-items-center">2</div>
                        <div class="card-data">
                            <h5>Certified Trainers & Industry Mentors</h5>
                            <p class="mb-0">Learn from professionals who hold global certifications and real-world industry knowledge.</p>
                        </div>
                      </div>
                    </div>
                    <div class="info-card p-3 bg-white mb-3 rounded theme-box-shadow wow fadeInUp">
                      <div class="d-flex">
                        <div class="card-icon theme-color-text bg-theme-light p-2 rounded-pill me-3 card-icon-sm d-flex justify-content-center align-items-center">3</div>
                        <div class="card-data">
                            <h5>Hands-On, Practical Learning Format</h5>
                            <p class="mb-0">Training programs are focused on real-world applications, not just theory.</p>
                        </div>
                      </div>
                    </div>
                    <div class="info-card p-3 bg-white mb-3 rounded theme-box-shadow wow fadeInUp mb-3">
                      <div class="d-flex">
                        <div class="card-icon theme-color-text bg-theme-light p-2 rounded-pill me-3 card-icon-sm d-flex justify-content-center align-items-center">4</div>
                        <div class="card-data">
                            <h5>24x7 Support & Post-training Access</h5>
                            <p class="mb-0">Ongoing assistance and access to learning resources even after the training ends.</p>
                        </div>
                      </div>
                    </div>
                    <div class="info-card p-3 bg-white mb-3 rounded theme-box-shadow wow fadeInUp mb-3">
                      <div class="d-flex">
                        <div class="card-icon theme-color-text bg-theme-light p-2 rounded-pill me-3 card-icon-sm d-flex justify-content-center align-items-center">5</div>
                        <div class="card-data">
                            <h5>Employer Reports & Feedback</h5>
                            <p class="mb-0">Receive structured performance reports and insights to measure training ROI.</p>
                        </div>
                      </div>
                    </div>
                    <div class="info-card p-3 bg-white mb-3 rounded theme-box-shadow wow fadeInUp">
                      <div class="d-flex">
                        <div class="card-icon theme-color-text bg-theme-light p-2 rounded-pill me-3 card-icon-sm d-flex justify-content-center align-items-center">5</div>
                        <div class="card-data">
                            <h5>Colaborative Learning Environment</h5>
                            <p class="mb-0">Interactive, peer-driven sessions that enhance knowledge retention and teamwork.</p>
                        </div>
                      </div>
                    </div>
                    <div class="info-card p-3 bg-white mb-3 rounded theme-box-shadow wow fadeInUp">
                      <div class="d-flex">
                        <div class="card-icon theme-color-text bg-theme-light p-2 rounded-pill me-3 card-icon-sm d-flex justify-content-center align-items-center">7</div>
                        <div class="card-data">
                            <h5>Red Hat, AWS, Microsoft Certified Delivery</h5>
                            <p class="mb-0">Training backed by global tech leaders, ensuring quality and recognition.</p>
                            <ul class="list-inline mb-0 info-card-hover-item mt-3">
                              <li class="list-inline-item"><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/redhat-sm.png" class="img-fluid" /></li>
                              <li class="list-inline-item"><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/microsoft.png" class="img-fluid" /></li>
                              <li class="list-inline-item"><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/EC.png" class="img-fluid" /></li>
                              <li class="list-inline-item"><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/aws-sm.png" class="img-fluid" /></li>
                            </ul>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!-- End Collaborating Section -->

            <!-- Hear Section -->
            <div class="hearform wow fadeInUp section-padding">
              <div class="container">
                <div class="row">
                    <div class="col-md-6">
                        <h2><?php echo get_field('testimonial_section_heading'); ?></h2>
                    </div> 
                    <div class="col-md-6">
                        <div class="subtext"><?php echo get_field('testimonial_section_subheading'); ?></div>
                    </div>
                </div>
              </div>
              <div class="container-fluid">
                <div class="row mt-80 d-flex align-items-center">
                  <div class="col-md-2">
                    <div class="nav" id="v-pills-tab" role="tablist">
                      <a href="#" class="nav-link" id="video-tab" data-bs-toggle="pill" data-bs-target="#video" role="tab" aria-controls="video" aria-selected="false">Student</a>
                      <a href="#" class="nav-link active" id="review-tab" data-bs-toggle="pill" data-bs-target="#review" role="tab" aria-controls="review" aria-selected="true">College Collaboration</a>
                      <a href="#" class="nav-link" id="college-tab" data-bs-toggle="pill" data-bs-target="#college" role="tab" aria-controls="college" aria-selected="false">Corporate Success</a>
                    </div>
                  </div>
                  <div class="col-md-10">
                    <div class="tab-content" id="v-pills-tabContent">
                      <div class="tab-pane fade" id="video" role="tabpanel" aria-labelledby="video-tab" tabindex="0">
                        <div class="owl-carousel video-review-2">
                            <?php
                  $choose_student_review = get_field('choose_student_review');
                  if ($choose_student_review):
                    foreach ($choose_student_review as $choose):
                      $permalink = get_permalink($choose->ID);
                      $image = wp_get_attachment_image_src(get_post_thumbnail_id($choose->ID), 'single-post-thumbnail');
                      $title = get_the_title($choose->ID);
                      $content = wp_trim_words(get_the_content($choose->ID), 20);
                  ?>
                  <div class="item">
                    <div class="carbox">
                      <div class="bigimg">
                        <?php if (!empty($image[0])): ?>
                          <img src="<?php echo htmlspecialchars($image[0]); ?>" class="img-fluid" alt="">
                        <?php endif; ?>
                      </div>
                      <a href="#" class="play" data-bs-toggle="modal" data-bs-target="#exampleModal">
                        <img src="<?php echo get_stylesheet_directory_uri() ?>/images/caree-play1.png" alt="">
                      </a>
                      <div class="company">
                        <img src="<?php echo get_stylesheet_directory_uri() ?>/images/gpc.png" class="img-fluid" alt="">
                      </div>
                      <div class="coname">
                        <h4><?php echo htmlspecialchars($title); ?></h4>
                        <p><?php echo htmlspecialchars(get_field('post_designation', $choose->ID)); ?></p>
                      </div>
                    </div>
                  </div>
                  <?php 
                    endforeach;
                  else:
                  ?>
                    <p>No projects found.</p>
                  <?php
                  endif;
                  ?>

                        </div>
                      </div>
                      <div class="tab-pane fade show active" id="review" role="tabpanel" aria-labelledby="review-tab" tabindex="0">
                        <div class="owl-carousel video-review-2">
                            <?php
                  $choose_collage_collaboration_review= get_field('choose_collage_collaboration_review');
                  if($choose_collage_collaboration_review):

                    foreach ($choose_collage_collaboration_review as $choose):
                      $permalink = get_permalink($choose->ID);
                      $image = wp_get_attachment_image_src(get_post_thumbnail_id($choose->ID), 'single-post-thumbnail');
                      $title = get_the_title($choose->ID);
                      $content = wp_trim_words(get_the_content($choose->ID), 20);
                  ?>
                  <div class="item">
                    <div class="orangebox">
                      <div class="content">
                        <div class="row">
                        <div class="col-4"><img src="<?php echo get_stylesheet_directory_uri() ?>/images/orange-quote.jpg" class="img-fluid" alt=""></div>
                        <div class="col-8 text-right">
                          <div class="star">
                              <span class="star star-enabled">★</span>
                              <span class="star star-enabled">★</span>
                              <span class="star star-enabled">★</span>
                              <span class="star star-enabled">★</span>
                              <span class="star star-enabled">★</span>
                            </div>
                        </div>
                        </div>
                        <p>“ <?php echo wp_trim_words($choose->post_content,30); ?></p>
                      </div>
                      <div class="blackbg">
                        <?php if (!empty($image[0])): ?>
                          <img src="<?php echo htmlspecialchars($image[0]); ?>" class="img-fluid" alt="">
                        <?php endif; ?>
                        <h5><?php echo htmlspecialchars($title); ?></h5>
                      </div>
                    </div>
                            </div>

                  <?php 
                    endforeach;
                  else:
                  ?>
                    <p>No projects found.</p>
                  <?php
                  endif;
                  ?>

                          
                        </div>
                      </div>
                      <div class="tab-pane fade" id="college" role="tabpanel" aria-labelledby="college-tab" tabindex="0">
                        <div class="owl-carousel video-review-2">
                            <?php
                  $choose_corporate_success_review = get_field('choose_corporate_success_review');
                  if ($choose_corporate_success_review):
                    foreach ($choose_corporate_success_review as $choose):
                  
                      // $permalink = get_permalink($choose->ID);
                      $image = wp_get_attachment_image_src(get_post_thumbnail_id($choose->ID), 'single-post-thumbnail');
                  
                  ?>
                  <div class="item">
                    <div class="reviewbox">
                      <img src="<?php echo $image[0] ?>" alt="" style="width: 63px; height: 63px">
                      </br>
                      <div class="content">
                        <h4><?php echo $choose->post_title; ?></h4>
                        <p><?php echo get_field('designation',$choose->ID) ?> @ <?php echo get_field('course_undertaken',$choose->ID) ?></p>
                      </div>
                      <p><small><?php echo $choose->post_content ?></small></p>
                    </div>
                            </div>
                      
                            <?php 
                    endforeach;
                  else:
                  ?>
                    <p>No projects found.</p>
                  <?php
                  endif;
                  ?>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
	          </div>
            <!-- End Hear Section -->

            <!-- Help Section -->
            <div class="process-section wow fadeInUp bg-theme-light section-padding position-relative" style="background-image: url('<?php echo esc_url( get_stylesheet_directory_uri() . '/images/bg-image.png' ); ?>');">
              <div class="container">
                <div class="row justify-content-center">
                  <div class="col-12 col-lg-12 col-xl-10">
                    <div class="heading-area text-lg-center">
                      <h2 class="fw-semibold mb-3">
                        <?php the_field('help_section_heading'); // Set via ACF ?>
                      </h2>
                    </div>
                  </div>
                </div>
                
                <?php if( have_rows('help_section_rows') ): ?>
                <div class="row justify-content-center mt-4 mt-lg-5">
                  <?php while( have_rows('help_section_rows') ): the_row(); 
                    $icon_svg = get_sub_field('svg_code'); // raw SVG code or icon HTML
                    $title = get_sub_field('title');
                    $description = get_sub_field('description');
                  ?>
                  <div class="col-6 col-sm-6 col-lg-3 mb-3 mb-lg-0">
                    <div class="card rounded-2 h-100 shape-card">
                      <div class="card-body p-4 pt-0">
                        <div class="cardicon mb-2 mb-md-4">
                          <?php echo $icon_svg; ?>
                        </div>
                        <h5><?php echo esc_html($title); ?></h5>
                        <p class="mb-0 theme-text-light"><?php echo esc_html($description); ?></p>
                      </div>
                    </div>
                  </div>
                  <?php endwhile; ?>
                </div>
                <?php endif; ?>
              </div>
            </div>

            <!-- End Help Section -->

            <!-- Innovation Section -->
            <div class="innovation wow fadeInUp section-padding">
              <div class="container">
                <div class="row justify-content-center align-items-center">
                  <div class="col-12 col-lg-12 mb-4">
                    <div class="heading-area text-center">
                      <h2 class="fw-semibold mb-3">Defining Moments in Our Journey</h2>
                      <div class="linearea">
                        <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/gradient-line.png" class="image-size170 img-fluid" alt="gradient-line.png" />
                      </div>
                    </div>
                  </div>
                  <div class="col-12 col-lg-12">
                      <div class="innovation-slider">
                        <div class="owl-carousel innovation-slider-area">
                          <div class="item">
                            <div class="row gx-3">
                              <div class="col-6 col-sm-6 col-md-4 col-lg-3 mb-3">
                                <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/define1.jpg" class="img-fluid rounded-1 image-size170 w-100" alt="" />
                              </div>
                              <div class="col-6 col-sm-6 col-md-4 col-lg-3 mb-3">
                                <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/define2.jpg" class="img-fluid rounded-1 image-size170 w-100" alt="" />
                              </div>
                              <div class="col-6 col-sm-6 col-md-4 col-lg-3 mb-3">
                                <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/define3.jpg" class="img-fluid rounded-1 image-size170 w-100" alt="" />
                              </div>
                              <div class="col-6 col-sm-6 col-md-4 col-lg-3 mb-3">
                                <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/define4.jpg" class="img-fluid rounded-1 image-size170 w-100" alt="" />
                              </div>
                              <div class="col-6 col-sm-6 col-md-4 col-lg-3 mb-3">
                                <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/define5.jpg" class="img-fluid rounded-1 image-size170 w-100" alt="" />
                              </div>
                              <div class="col-6 col-sm-6 col-md-4 col-lg-3 mb-3">
                                <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/define6.jpg" class="img-fluid rounded-1 image-size170 w-100" alt="" />
                              </div>
                              <div class="col-6 col-sm-6 col-md-4 col-lg-3 mb-3">
                                <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/define7.jpg" class="img-fluid rounded-1 image-size170 w-100" alt="" />
                              </div>
                              <div class="col-6 col-sm-6 col-md-4 col-lg-3 mb-3">
                                <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/define8.jpg" class="img-fluid rounded-1 image-size170 w-100" alt="" />
                              </div>
                              <div class="col-6 col-sm-6 col-md-4 col-lg-3 mb-3">
                                <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/define9.jpg" class="img-fluid rounded-1 image-size170 w-100" alt="" />
                              </div>
                              <div class="col-6 col-sm-6 col-md-4 col-lg-3 mb-3">
                                <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/define10.jpg" class="img-fluid rounded-1 image-size170 w-100" alt="" />
                              </div>
                              <div class="col-6 col-sm-6 col-md-4 col-lg-3 mb-3">
                                <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/define11.jpg" class="img-fluid rounded-1 image-size170 w-100" alt="" />
                              </div>
                              <div class="col-6 col-sm-6 col-md-4 col-lg-3 mb-3">
                                <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/define12.jpg" class="img-fluid rounded-1 image-size170 w-100" alt="" />
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

            <!-- Award -->
            <div class="award wow fadeInUp bg-theme-light">
              <div class="container">
                <h2>Awards & Recognition</h2>
                <div class="owl-carousel workshop-course">
                  <?php
                  $awards = new WP_Query(array(
                    'post_type'      => 'awards',
                    'posts_per_page' => -1,
                    'orderby'        => 'date',
                    'order'          => 'DESC'
                  ));

                  if ($awards->have_posts()) :
                    while ($awards->have_posts()) : $awards->the_post();
                      $year = get_the_date('Y'); // Extract year from post date
                      $image_url = get_the_post_thumbnail_url(get_the_ID(), 'medium');
                  ?>
                      <div class="item">
                        <div class="cousebox">
                          <?php if ($image_url): ?>
                            <a href="<?php echo home_url('aboutus?tab=awardsection'); ?>">
                              <img src="<?php echo esc_url($image_url); ?>" class="img-fluid" alt="<?php the_title_attribute(); ?>">
                            </a>
                          <?php endif; ?>
                          <h4>
                            <strong><?php echo esc_html($year); ?></strong><br>
                            <?php echo nl2br(esc_html(get_the_title())); ?>
                          </h4>
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

            <!-- End Award -->

            <!-- FAQ Section -->
            <?php
            include('components/faq.php'); 
            ?>
            <!-- End FAQ Section -->
            
        </div>
        <div id="solutionsection" class="contentarea">
          <!-- The Summer Training program 2023 Provides -->
          <div class="thesummer wow fadeInUp bg-transparent bg-image-none">
            <div class="container">
              <div class="row">
                <div class="col-lg-12">
                  <div class="heading-area text-center mb-4 mb-lg-5">
                    <h2 class="fw-semibold mb-3">Top Categories We Offer</h2>
                    <p>We offer training across diverse technologies and domains, ensuring your teams gain skills that matter.</p>
                  </div>
                </div>
              </div>
              <div class="row g-3">
                <?php 
                $terms = get_terms(array(
                    'taxonomy' => 'course_types',
                    'hide_empty' => true,
                    'exclude' => $top_choices_term ? $top_choices_term->term_id : null, // Exclude 'top-choices' term by ID
                ));
                if (!empty($terms) && !is_wp_error($terms)) {
                  $count = 1;
                  foreach ($terms as $term) {
                ?>
                  <div class="col-6 col-sm-6 col-lg-4">
                      <div class="d-flex align-items-center gap-1 gap-md-3 p-2 p-md-3 explorearea explore-<?php echo $count; ?>">
                        <div class="iconarea d-flex align-items-center justify-content-center">
                          <?php
                          $svgCode = get_term_meta($term->term_id, 'svg_icon_code', true);
                          if ($svgCode) {
                              echo $svgCode; // Output the SVG code directly
                          }
                          ?>
                        </div>
                        <div class="headarea">
                          <h6 class="mb-0"><?php echo esc_html($term->name); ?></h6>
                        </div>
                      </div>
                  </div>
                <?php $count++; } } ?>
                <div class="col-12 col-sm-12 text-center pt-md-4">
                  <a href="<?php echo home_url('course'); ?>"  class="btn btn-primary">Browse All Courses</a>
                </div>
              </div>
            </div>
          </div>

          <!-- Career Section -->
          <div class="career-section bg-theme-light collaborate-section wow fadeInUp section-padding py-5">
            <div class="container">
              
              <!-- Heading Area -->
              <div class="row">
                <div class="col-lg-12">
                  <div class="heading-area text-center mb-4">
                    <?php if ($heading = get_field('more_than_just_learning_heading')): ?>
                      <h2 class="fw-semibold mb-3"><?php echo wp_kses_post($heading); ?></h2>
                    <?php endif; ?>
                    
                    <?php if ($subheading = get_field('more_than_just_learning_subheading')): ?>
                      <p><?php echo esc_html($subheading); ?></p>
                    <?php endif; ?>
                  </div>
                </div>
              </div>

              <!-- Repeater Boxes -->
              <?php if (have_rows('more_than_just_learning_rows')): ?>
                <div class="row">
                  <?php while (have_rows('more_than_just_learning_rows')): the_row(); 
                    $title = get_sub_field('title');
                    $desc = get_sub_field('description');
                    $icon_svg = get_sub_field('icon_svg_code'); // raw SVG HTML
                  ?>
                    <div class="col-12 col-md-6 mb-4">
                      <div class="careerarea bg-white p-3 d-flex rounded-2 theme-box-shadow">
                        
                        <div class="careerarea-text">
                          <?php if ($title): ?>
                            <h5><?php echo esc_html($title); ?></h5>
                          <?php endif; ?>
                          
                          <?php if ($desc): ?>
                            <p><?php echo esc_html($desc); ?></p>
                          <?php endif; ?>
                        </div>

                        <div class="careerarea-icon">
                          <?php if ($icon_svg): ?>
                            <div class="img-fluid"><?php echo $icon_svg; // Render SVG HTML ?></div>
                          <?php endif; ?>
                        </div>

                      </div>
                    </div>
                  <?php endwhile; ?>
                </div>
              <?php endif; ?>

            </div>
          </div>

          <!-- End Career Section -->

          <!-- FAQ Section -->
          <?php
            include('components/faq.php'); 
          ?>
          <!-- End FAQ Section -->
        </div>
        <div id="partnerssection" class="contentarea">
          <!-- Curious -->
          <div class="thesummer wow fadeInUp bg-transparent bg-image-none">
            <div class="container">
              <div class="row">
                <div class="col-lg-12">
                  <div class="heading-area text-center mb-4">
                    <h2 class="fw-semibold mb-3"><?php echo get_field('open_to_all_curious_minds_heading'); ?></h2>
                    <p><?php echo get_field('open_to_all_curious_minds_subheading'); ?></p>
                  </div>
                </div>
              </div>
              <div class="row g-3 justify-content-center">
                <?php
                if(have_rows('intership_streams')): 
                  while(have_rows('intership_streams')): the_row();
                    $stream = get_sub_field('stream_name');
                ?>
                <div class="col-6 col-sm-6 col-lg-3">
                    <div class="curious-block h-100">
                      <button type="button" class="btn btn-primary h-100 w-100"><?php echo $stream; ?></button>
                    </div>
                </div>
                <?php endwhile; endif; ?>
              </div>
            </div>
          </div>
          <!-- End Curious -->

          <!-- Collaborating Section -->
          <div class="help-section pb-lg-4  pb-3 bg-theme-light collaborate-section wow fadeInUp section-padding">
            <div class="container">
              <div class="row">
                <div class="col-lg-12">
                  <div class="heading-area text-center mb-4 mb-lg-5">
                    <h2 class="fw-semibold mb-3"><?php echo get_field('your_time_your_learning_pace_heading'); ?></h1>
                    <p><?php echo get_field('your_time_your_learning_pace_description'); ?></p>
                  </div>
                </div>
              </div>
              <?php 
              $yourTimeLeftImageId = get_field('your_time_your_learning_pace_heading_left_image');
              $yourTimeLeftImage = $yourTimeLeftImageId ? wp_get_attachment_url($yourTimeLeftImageId) : null;
              ?>
              <div class="row justify-content-center">
                <div class="col-12 col-lg-6">
                  <?php if(!empty($yourTimeLeftImage)): ?>
                    <img src="<?php echo esc_url($yourTimeLeftImage); ?>" class="img-fluid" alt="Your Time, Your Learning Pace">
                  <?php endif; ?>
                </div>
                <div class="col-12 col-lg-5 mb-4 ms-auto">
                  <?php
                  $terms = get_terms(array(
                      'taxonomy' => 'internship_types',
                      'hide_empty' => false, // Change to true if you want to hide empty terms
                  ));
                  if (!empty($terms) && !is_wp_error($terms)):
                    foreach ($terms as $term):
                      if($term->slug === 'all') continue; // Skip 'top-choices' term
                  ?>
                  <div class="info-card p-3 bg-white mb-3 rounded theme-box-shadow wow fadeInUp mb-3">
                    <div class="d-flex">
                      <div class="card-icon theme-color-text bg-theme-light p-2 rounded-pill me-3 card-icon-sm d-flex justify-content-center align-items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 32 32" fill="none">
                          <path d="M11.9998 16.0001L14.6665 18.6667L20.6665 12.6667M23.8681 6.66476C24.1426 7.32879 24.6696 7.85661 25.3332 8.13218L27.6602 9.09605C28.3242 9.37112 28.8518 9.89874 29.1269 10.5628C29.4019 11.2269 29.4019 11.9731 29.1269 12.6372L28.1637 14.9625C27.8885 15.6269 27.8882 16.3738 28.1646 17.0378L29.1261 19.3625C29.2624 19.6914 29.3326 20.0439 29.3327 20.4C29.3328 20.7561 29.2627 21.1087 29.1264 21.4376C28.9902 21.7666 28.7904 22.0655 28.5386 22.3172C28.2868 22.5689 27.9879 22.7686 27.6589 22.9047L25.3336 23.8679C24.6696 24.1425 24.1418 24.6695 23.8663 25.3331L22.9024 27.6601C22.6274 28.3242 22.0998 28.8518 21.4357 29.1269C20.7717 29.402 20.0255 29.402 19.3615 29.1269L17.0362 28.1637C16.3721 27.8893 15.6263 27.8899 14.9626 28.1653L12.6357 29.1278C11.972 29.4022 11.2265 29.402 10.563 29.1271C9.89947 28.8523 9.37217 28.3253 9.09692 27.6619L8.1328 25.3342C7.85824 24.6702 7.33123 24.1423 6.66763 23.8668L4.34072 22.9029C3.67695 22.628 3.14951 22.1007 2.87435 21.437C2.59918 20.7733 2.59881 20.0275 2.87331 19.3635L3.83646 17.0381C4.11084 16.374 4.11028 15.6281 3.8349 14.9645L2.87313 12.6358C2.73677 12.3069 2.66656 11.9543 2.6665 11.5983C2.66645 11.2422 2.73655 10.8896 2.8728 10.5607C3.00905 10.2317 3.20879 9.93282 3.46059 9.68108C3.7124 9.42935 4.01134 9.22971 4.34032 9.09355L6.66557 8.13037C7.329 7.85604 7.85648 7.32968 8.13224 6.66682L9.09608 4.33983C9.37114 3.67574 9.89874 3.14813 10.5628 2.87305C11.2269 2.59798 11.973 2.59798 12.6371 2.87305L14.9623 3.83624C15.6264 4.11063 16.3722 4.11007 17.0359 3.83468L19.3638 2.87455C20.0278 2.59963 20.7737 2.59968 21.4377 2.8747C22.1016 3.14972 22.6291 3.67719 22.9042 4.3411L23.8684 6.66879L23.8681 6.66476Z" stroke="#D76013" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                      </div>
                      <div class="card-data">
                          <h5><?php echo $term->name; ?></h5>
                          <p><?php echo $term->description; ?></p>
                      </div>
                    </div>
                  </div>
                  <?php endforeach; endif; ?>
                </div>
                <div class="col-12 col-lg-12 text-center">
                  <p><?php echo get_field('your_time_your_learning_pace_heading_bottom_line'); ?></p>
                </div>
              </div>
            </div>
          </div>
          <!-- End Collaborating Section -->

          <!-- Curious -->
          <div class="thesummer wow fadeInUp bg-transparent bg-image-none">
            <div class="container">
              <div class="row">
                <div class="col-lg-12">
                  <div class="heading-area text-center mb-4 mb-lg-5">
                    <h2 class="fw-semibold mb-3"><?php echo get_field('choose_your_track_heading'); ?></h2>
                    <p><?php echo get_field('choose_your_track_subheading'); ?></p>
                  </div>
                </div>
              </div>
              <div class="row g-3">
                <?php
                $intershipQry = new WP_Query([
                    'post_type'      => 'internships',
                    'post_status'    => 'publish',
                    'posts_per_page' => 9
                ]);

                if ($intershipQry->have_posts()) :
                    $intCount = 0; 
                    while ($intershipQry->have_posts()) : $intershipQry->the_post();
                        $postTitle = get_the_title();
                        
                ?>
                <div class="col-6 col-sm-6 col-lg-4">
                    <div class="d-flex align-items-center gap-1 gap-md-3 p-2 p-md-3 explorearea explore-<?php echo $intCount; ?>">
                      <div class="iconarea d-flex align-items-center justify-content-center">
                        <?php echo get_field('internship_svg_code'); ?>
                      </div>
                      <div class="headarea">
                        <h6 class="mb-0"><?php echo $postTitle; ?></h6>
                      </div>
                    </div>
                </div>
                <?php $intCount++; endwhile; endif; wp_reset_postdata(); ?>
                
                <div class="col-12 col-sm-12 text-center pt-md-4">
                  <a href="<?php echo home_url('internship'); ?>" class="btn btn-primary">Explore all internships</a>
                </div>
              </div>
            </div>
          </div>
          <!-- End Curious -->

          <!-- Career Section -->
          <div class="career-section bg-theme-light collaborate-section wow fadeInUp section-padding py-5">
            <div class="container">
              <div class="row">
                <div class="col-lg-12 ">
                  <div class="heading-area text-center mb-4">
                    <h2 class="fw-semibold mb-3">More Than a Certificate It’s a Launchpad</h2>
                  </div>
                </div>
              </div>
                <div class="row">
                  <div class="col-12 col-md-6 col-lg-4 mb-4">
                      <div class="careerarea1 bg-white p-3 d-flex rounded-2 theme-box-shadow gap-3 align-items-center">
                        <div class="careerarea-icon">
                          <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/more1.png" class="img-fluid" />
                        </div>
                        <div class="careerarea-text">
                          <h6 class="fw-normal">Opportunity to transition into full-time training or job support programs</h6>
                        </div>
                      </div>
                  </div>
                  <div class="col-12 col-md-6 col-lg-4 mb-4">
                      <div class="careerarea1 bg-white p-3 d-flex rounded-2 theme-box-shadow gap-3 align-items-center">
                        <div class="careerarea-icon">
                          <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/more2.png" class="img-fluid" />
                        </div>
                        <div class="careerarea-text">
                          <h6 class="fw-normal">Add credibility to your resume and LinkedIn</h6>
                        </div>
                      </div>
                  </div>
                  <div class="col-12 col-md-6 col-lg-4 mb-4">
                      <div class="careerarea1 bg-white p-3 d-flex rounded-2 theme-box-shadow gap-3 align-items-center">
                        <div class="careerarea-icon">
                          <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/more3.png" class="img-fluid" />
                        </div>
                        <div class="careerarea-text">
                          <h6 class="fw-normal">Certified internship letter + performance evaluation</h6>
                        </div>
                      </div>
                  </div>
                  <div class="col-12 col-md-12 col-lg-12 text-center">
                    <h6>Ready to Begin Your Internship Journey?</h6>
                    <a href="<?php echo home_url('internship'); ?>" class="btn btn-primary mt-2">Apply for Internship</a>
                  </div>
                </div>
            </div>
          </div>
          <!-- End Career Section -->

          <!-- FAQ Section -->
          <?php
            include('components/faq.php'); 
          ?>
          <!-- End FAQ Section -->
        </div>
        <div id="industrysection" class="contentarea">
            <!-- Partner Section -->
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
                                <h1 class="fw-bold mb-3"><?php echo get_field('empowering_learners_through_strong_alliances_heading'); ?></h1>
                                <p class="theme-text-light"><?php echo get_field('empowering_learners_through_strong_alliances_description'); ?></p>
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
            <!-- End Partner Section -->

            <!-- Industry Section -->
            <div class="industry-section wow fadeInUp bg-theme-light section-padding">
              <div class="container">
                <div class="row justify-content-center">
                  <div class="col-12 col-lg-12 col-xl-10">
                    <div class="heading-area text-lg-center">
                      <h2 class="fw-bold mb-3 ">Bringing Industry-Relevant Training to Classrooms</h2>
                      <p>"We collaborate with colleges and universities to provide specialized programs that go beyond the traditional academic curriculum, empowering students with technical skills, certifications, and real-world exposure</p>
                    </div>
                  </div>
                </div>
                <div class="row justify-content-center py-4 py-lg-5">
                  <div class="col-12 col-lg-6 mb-3 mb-lg-0">
                      <div class="content-area">
                        <h4 class="mb-2 mb-lg-3 fw-semibold">Customized Training Programs</h4>
                        <p>Every institution has unique goals and timelines. Grras Solutions customizes its programs to suit specific academic needs, offering</p>
                        <div class="info-card p-3 bg-white mb-3 rounded theme-box-shadow wow fadeInUp">
                            <div class="d-flex align-items-center">
                              <div class="card-icon bg-theme-light p-2 rounded-pill me-3">
                                <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/calendar.png" class="img-fluid" />
                              </div>
                              <div class="card-data">
                                  <h5>Flexible Timeframes</h5>
                                  <p class="mb-0">From intensive one-week boot camps to in-depth, multi-month programs.</p>
                              </div>
                            </div>
                        </div>
                        <div class="info-card p-3 bg-white rounded theme-box-shadow wow fadeInUp">
                            <div class="d-flex align-items-center">
                              <div class="card-icon bg-theme-light p-2 rounded-pill me-3">
                                <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/teams.png" class="img-fluid" />
                              </div>
                              <div class="card-data">
                                  <h5>Industry-Aligned Training</h5>
                                  <p class="mb-0">Our courses seamlessly integrate with traditional syllabi, equipping students with practical, job-ready skills.</p>
                              </div>
                            </div>
                        </div>
                      </div>
                  </div>
                  <div class="col-12 col-lg-6">
                    <div class="img-area">
                      <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/figure-1.png" class="img-fluid" />
                    </div>
                  </div>
                </div>
                <div class="row justify-content-center py-4 py-lg-5">
                  <div class="col-12 col-lg-6 order-2 order-lg-1">
                    <div class="img-area">
                      <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/figure-2.png" class="img-fluid" />
                    </div>
                  </div>
                  <div class="col-12 col-lg-6 order-1 order-lg-2">
                      <div class="content-area">
                        <h4 class="mb-2 mb-lg-3 fw-semibold">Partnering for Long-Term Growth</h4>
                        <p>We go beyond individual sessions or workshops, fostering long-term partnerships with academic institutions for mutual growth.</p>
                        <div class="info-card p-3 bg-white mb-3 rounded theme-box-shadow wow fadeInUp">
                            <div class="d-flex align-items-center">
                              <div class="card-icon bg-theme-light p-2 rounded-pill me-3">
                                <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/learning.png" class="img-fluid" />
                              </div>
                              <div class="card-data">
                                  <h5>Joint Curriculum Development</h5>
                                  <p class="mb-0">Co-creating curricula that balance academic goals with industry requirements.</p>
                              </div>
                            </div>
                        </div>
                        <div class="info-card p-3 bg-white rounded theme-box-shadow wow fadeInUp">
                            <div class="d-flex align-items-center">
                              <div class="card-icon bg-theme-light p-2 rounded-pill me-3">
                                <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/desk.png" class="img-fluid" />
                              </div>
                              <div class="card-data">
                                  <h5>Faculty Development Programs</h5>
                                  <p class="mb-0">Helping educators stay updated with emerging technologies and modern teaching methodologies.</p>
                              </div>
                            </div>
                        </div>
                      </div>
                  </div>
                </div>
                <div class="row justify-content-center align-items-center">
                  <div class="col-12 col-lg-6 order-1 order-lg-2">
                      <div class="content-area">
                        <h4 class="mb-2 mb-lg-3 fw-semibold">Engagement Beyond the Classroom</h4>
                        <p>Our partnerships extend beyond textbooks. Through hackathons, competitions, and live projects, we provide students with platforms to test their skills, solve real-world challenges, and showcase their talent.</p>
                      </div>
                  </div>
                  <div class="col-12 col-lg-6 order-2 order-lg-2">
                    <div class="img-area">
                      <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/figure-3.png" class="img-fluid" />
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!-- End Industry Section -->

            <!-- Collaborating Section -->
            <div class="collaborate-section wow fadeInUp section-padding">
              <div class="container">
                <div class="row justify-content-center align-items-center">
                  <div class="col-12 col-lg-6">
                    <div class="heading-area">
                      <h2 class="fw-semibold mb-3">Collaborating With Leading Tech Innovators</h2>
                      <p class="theme-text-light">Our partnerships with industry giants ensure students have access to globally recognized certifications, the latest tools, and real-world projects, enabling them to stand out in their careers.</p>
                    </div>
                  </div>
                  <div class="col-12 col-lg-6">
                    <div class="info-card p-3 bg-white mb-3 rounded theme-box-shadow wow fadeInUp mb-3">
                      <div class="d-flex">
                        <div class="card-icon theme-color-text bg-theme-light p-2 rounded-pill me-3 card-icon-sm d-flex justify-content-center align-items-center">1</div>
                        <div class="card-data">
                            <h5>Global Certifications</h5>
                            <p class="mb-0">Collaborations with Red Hat, Microsoft, EC-Council, and  AWS ensure students gain credentials that are recognized worldwide.</p>
                            <ul class="list-inline mb-0 info-card-hover-item mt-3">
                              <li class="list-inline-item"><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/redhat-sm.png" class="img-fluid" /></li>
                              <li class="list-inline-item"><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/microsoft.png" class="img-fluid" /></li>
                              <li class="list-inline-item"><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/EC.png" class="img-fluid" /></li>
                              <li class="list-inline-item"><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/aws-sm.png" class="img-fluid" /></li>
                            </ul>
                        </div>
                      </div>
                    </div>
                    <div class="info-card p-3 bg-white mb-3 rounded theme-box-shadow wow fadeInUp mb-3">
                      <div class="d-flex">
                        <div class="card-icon theme-color-text bg-theme-light p-2 rounded-pill me-3 card-icon-sm d-flex justify-content-center align-items-center">2</div>
                        <div class="card-data">
                            <h5>Cutting-Edge Technology</h5>
                            <p class="mb-0">Learn with industry-approved tools and platforms.</p>
                        </div>
                      </div>
                    </div>
                    <div class="info-card p-3 bg-white mb-3 rounded theme-box-shadow wow fadeInUp">
                      <div class="d-flex">
                        <div class="card-icon theme-color-text bg-theme-light p-2 rounded-pill me-3 card-icon-sm d-flex justify-content-center align-items-center">3</div>
                        <div class="card-data">
                            <h5>Practical Learning</h5>
                            <p class="mb-0">Hands-on projects guided by industry experts.</p>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!-- End Collaborating Section -->

            <!-- Help Section -->
            <div class="help-section pt-3 pt-lg-5 wow fadeInUp bg-theme-light section-padding position-relative">
              <div class="container">
                <div class="row justify-content-center">
                  <div class="col-12 col-lg-12 col-xl-10">
                    <div class="heading-area text-lg-center">
                      <h2 class="fw-semibold mb-3">How Our Collaborations Help You Succeed</h2>
                    </div>
                  </div>
                </div>
                <div class="row justify-content-center mt-4 mt-lg-5">
                  <div class="col-6 col-sm-6 col-lg-3 mb-3 mb-lg-0">
                    <div class="card border brd-theme rounded-4 h-100">
                      <div class="card-body p-lg-4">
                          <div class="cardicon mb-2">
                            <svg xmlns="http://www.w3.org/2000/svg" width="55" height="55" viewBox="0 0 55 55" fill="none">
                              <path d="M23.8438 34.7775C23.8438 32.1907 25.9407 30.0937 28.5275 30.0937H39.5984C45.7955 30.3065 45.7997 39.2472 39.5983 39.4613H28.5275C25.9407 39.4613 23.8438 37.3643 23.8438 34.7775Z" fill="#EF7221"/>
                              <path d="M39.5973 40.3129H28.5265C21.1961 40.036 21.1924 29.5204 28.5265 29.2421H39.5973C46.9276 29.5191 46.9313 40.0347 39.5973 40.3129ZM28.5265 30.9453C23.4651 31.1048 23.4604 38.4488 28.5266 38.6097H39.5973C44.6587 38.4502 44.6633 31.1062 39.5972 30.9453H28.5265Z" fill="#EF7221"/>
                              <path d="M46.8382 10.5069C46.8599 9.38821 48.5199 9.3883 48.5414 10.5069C48.5197 11.6255 46.8597 11.6253 46.8382 10.5069ZM43.4318 10.5069C43.4535 9.38821 45.1135 9.3883 45.135 10.5069C45.1133 11.6255 43.4533 11.6253 43.4318 10.5069ZM40.0254 10.5069C40.0471 9.38821 41.7071 9.3883 41.7286 10.5069C41.7069 11.6255 40.0469 11.6253 40.0254 10.5069Z" fill="#EF7221"/>
                              <path d="M22.9913 13.9133H19.5849C16.217 14.0012 16.2159 18.9348 19.585 19.0229H22.9913C26.3591 18.9349 26.3603 14.0013 22.9913 13.9133Z" fill="#EF7221"/>
                              <path d="M33.2101 13.9133H29.8037C26.4358 14.0012 26.4347 18.9348 29.8037 19.0229H33.2101C36.5778 18.9349 36.579 14.0013 33.2101 13.9133Z" fill="#EF7221"/>
                              <path d="M45.9855 13.9133H40.0243C36.6572 14.0009 36.6547 18.9348 40.0244 19.0229H45.9855C49.3526 18.9352 49.3551 14.0014 45.9855 13.9133Z" fill="#EF7221"/>
                              <path d="M31.5078 22.4292H17.8822C16.767 22.412 16.7594 20.7448 17.8822 20.726H31.5078C32.623 20.7432 32.6307 22.4104 31.5078 22.4292Z" fill="#EF7221"/>
                              <path d="M47.6881 22.4292H34.9141C34.4434 22.4292 34.0625 22.0483 34.0625 21.5776C34.0625 21.1069 34.4434 20.726 34.9141 20.726H47.6881C48.8036 20.7433 48.8107 22.4104 47.6881 22.4292Z" fill="#EF7221"/>
                              <path d="M31.5078 25.8357H17.8822C16.767 25.8185 16.7594 24.1513 17.8822 24.1325H31.5078C32.623 24.1497 32.6307 25.8169 31.5078 25.8357Z" fill="#EF7221"/>
                              <path d="M47.6881 25.8357H34.9141C34.4434 25.8357 34.0625 25.4548 34.0625 24.9841C34.0625 24.5134 34.4434 24.1325 34.9141 24.1325H47.6881C48.8036 24.1498 48.8107 25.8169 47.6881 25.8357Z" fill="#EF7221"/>
                              <path d="M22.992 29.2422H17.8824C16.7645 29.2241 16.7618 27.5575 17.8824 27.539H22.992C24.1099 27.5571 24.1126 29.2237 22.992 29.2422Z" fill="#EF7221"/>
                              <path d="M47.6895 6.24896H6.81272C3.99513 6.24896 1.70312 8.54097 1.70312 11.3586V38.6097C1.70312 41.4273 3.99513 43.7193 6.81272 43.7193H47.6895C50.5071 43.7193 52.7991 41.4273 52.7991 38.6097V11.3586C52.7991 8.54097 50.5071 6.24896 47.6895 6.24896ZM11.9223 31.7969H7.66432C6.5461 31.7789 6.54395 30.1123 7.66436 30.0937H11.9223C13.0405 30.1119 13.0427 31.7784 11.9223 31.7969ZM11.9223 28.3906H5.10952C3.99209 28.3727 3.9885 26.7059 5.10956 26.6874H11.9223C13.0398 26.7052 13.0433 28.372 11.9223 28.3906ZM11.9223 24.9842H5.10952C3.99209 24.9663 3.9885 23.2995 5.10956 23.281H11.9223C13.0398 23.2988 13.0433 24.9656 11.9223 24.9842ZM8.51592 21.5778C6.1682 21.5778 4.25792 19.6674 4.25792 17.3198C4.45805 11.6843 12.5746 11.6858 12.7739 17.3198C12.7739 19.6674 10.8636 21.5778 8.51592 21.5778ZM51.0959 38.6097C51.0959 40.4884 49.5682 42.0161 47.6895 42.0161H16.1803V7.95216H47.6895C49.5682 7.95216 51.0959 9.47986 51.0959 11.3586V38.6097Z" fill="#EF7221"/>
                              <path d="M48.3893 44.2131L46.583 42.406L48.1365 40.8525C49.5214 39.5582 48.8616 37.0348 47.0188 36.5861L36.2266 33.564C34.9998 33.1804 33.7415 34.4331 34.1276 35.663L37.1498 46.4552C37.599 48.2968 40.1211 48.9588 41.416 47.5729L42.9695 46.0195L44.7767 47.8258C45.1086 48.1576 45.5451 48.3239 45.9809 48.3239C46.8999 48.4213 47.7893 47.1601 48.3893 46.6215C49.0538 45.9579 49.0538 44.8767 48.3893 44.2131Z" fill="#FFBE94"/>
                            </svg>
                          </div>
                          <h5>Industry-Aligned Learning</h5>
                          <p class="mb-0 theme-text-light">Gain job-ready skills aligned with current market demands.</p>
                      </div>
                    </div>
                  </div>
                  <div class="col-6 col-sm-6 col-lg-3 mb-3 mb-lg-0">
                    <div class="card border brd-theme rounded-4 h-100">
                      <div class="card-body p-lg-4">
                          <div class="cardicon mb-2">
                            <svg xmlns="http://www.w3.org/2000/svg" width="56" height="55" viewBox="0 0 56 55" fill="none">
                              <g clip-path="url(#clip0_6517_111420)">
                              <g clip-path="url(#clip1_6517_111420)">
                              <path d="M48.3457 5.48248H7.46897C4.65138 5.48248 2.35938 7.77449 2.35938 10.5921V35.2885C2.35938 38.1061 4.65138 40.3981 7.46897 40.3981H23.6494V42.9529H21.9462C20.0675 42.9529 18.5398 44.4806 18.5398 46.3593C18.5398 48.238 20.0675 49.7657 21.9462 49.7657H33.8686C35.7473 49.7657 37.275 48.238 37.275 46.3593C37.275 44.4806 35.7473 42.9529 33.8686 42.9529H32.1654V40.3981H48.3457C51.1633 40.3981 53.4553 38.1061 53.4553 35.2885V10.5921C53.4553 7.77449 51.1633 5.48248 48.3457 5.48248ZM7.46897 7.18568H48.3457C50.2244 7.18568 51.7521 8.71341 51.7521 10.5921V33.561C50.9758 34.6036 49.7446 35.2885 48.3457 35.2885H7.46897C6.07005 35.2885 4.83896 34.6036 4.06257 33.561V10.5921C4.06257 8.71341 5.5903 7.18568 7.46897 7.18568ZM33.8686 44.6561C36.1103 44.7136 36.1173 48.0029 33.8685 48.0625H21.9462C19.7034 48.0044 19.6983 44.7155 21.9463 44.6561H24.0103C25.4313 48.0291 30.3845 48.0274 31.8045 44.6561H33.8686Z" fill="#EF7221"/>
                              <path d="M24.5003 19.1082H21.0939C19.6829 19.1082 18.5391 20.252 18.5391 21.663V31.0305C18.5391 32.4415 19.6829 33.5853 21.0939 33.5853H24.5003C25.9112 33.5853 27.0551 32.4415 27.0551 31.0305V21.663C27.0551 20.252 25.9112 19.1082 24.5003 19.1082Z" fill="#EF7221"/>
                              <path d="M14.2815 24.2178H10.8751C9.46414 24.2178 8.32031 25.3616 8.32031 26.7726V31.0306C8.32031 32.4415 9.46414 33.5854 10.8751 33.5854H14.2815C15.6925 33.5854 16.8363 32.4415 16.8363 31.0306V26.7726C16.8363 25.3616 15.6925 24.2178 14.2815 24.2178Z" fill="#EF7221"/>
                              <path d="M44.9397 14.85H41.5333C40.1223 14.85 38.9785 15.9939 38.9785 17.4048V31.0304C38.9785 32.4414 40.1223 33.5852 41.5333 33.5852H44.9397C46.3507 33.5852 47.4945 32.4414 47.4945 31.0304V17.4048C47.4945 15.9939 46.3507 14.85 44.9397 14.85Z" fill="#EF7221"/>
                              <path d="M31.3134 33.5854H34.7198C38.0876 33.4975 38.0888 28.5639 34.7197 28.4758H31.3134C27.9455 28.5638 27.9445 33.4974 31.3134 33.5854Z" fill="#EF7221"/>
                              <path d="M44.6905 10.8417L42.9873 9.1385C42.1965 8.35442 40.9988 9.55214 41.7831 10.3428L42.0326 10.5922H39.8303C37.4826 10.5922 35.5723 12.5024 35.5723 14.8502V21.663C35.4819 25.0315 30.5523 25.0323 30.4627 21.6629V19.1082C30.4627 16.7604 28.5525 14.8502 26.2047 14.8502H17.6887C15.341 14.8502 13.4307 16.7604 13.4307 19.1082C13.4307 19.5781 13.049 19.9598 12.5791 19.9598H9.17277C8.06325 19.9744 8.04555 21.6444 9.1728 21.663H12.5791C13.988 21.663 15.1339 20.517 15.1339 19.1082C15.1339 17.6994 16.2799 16.5534 17.6887 16.5534H26.2047C27.6136 16.5534 28.7595 17.6994 28.7595 19.1082V21.663C28.9574 27.2956 37.0763 27.2991 37.2755 21.6629V14.8502C37.2755 13.4414 38.4215 12.2954 39.8303 12.2954H42.0326L41.783 12.5449C40.9991 13.3355 42.1964 14.5334 42.9873 13.7491L44.6905 12.0459C45.0231 11.7133 45.0231 11.1743 44.6905 10.8417Z" fill="#FFBE94"/>
                              </g>
                              </g>
                              </svg>
                          </div>
                          <h5>Exclusive Certifications</h5>
                          <p class="mb-0 theme-text-light">Stand out with global certifications from leading organizations.</p>
                      </div>
                    </div>
                  </div>
                  <div class="col-6 col-sm-6 col-lg-3 mb-3 mb-sm-0">
                    <div class="card border brd-theme rounded-4 h-100">
                      <div class="card-body p-lg-4">
                          <div class="cardicon mb-2">
                            <svg xmlns="http://www.w3.org/2000/svg" width="55" height="55" viewBox="0 0 55 55" fill="none">
                              <g clip-path="url(#clip0_6517_111435)">
                              <g clip-path="url(#clip1_6517_111435)">
                              <path d="M44.8939 36.6569C42.3409 36.5068 40.3237 35.3839 39.4757 33.2505H24.6975C21.8799 33.2505 19.5879 30.9585 19.5879 28.1409V11.9605C19.5879 9.14296 21.8799 6.85095 24.6975 6.85095H47.6907C50.5083 6.85095 52.8003 9.14296 52.8003 11.9605V28.1409C52.8003 30.9585 50.5083 33.2505 47.6907 33.2505H44.8457C44.7392 33.9782 44.9662 34.6893 45.4869 35.1941C46.0377 35.6931 45.6351 36.6824 44.8939 36.6569ZM24.6975 8.55415C22.8188 8.55415 21.2911 10.0819 21.2911 11.9605V28.1409C21.2911 30.0196 22.8188 31.5473 24.6975 31.5473H40.1111C40.5128 31.5473 40.8604 31.8285 40.9436 32.221C41.2019 33.4019 42.0673 34.1802 43.2431 34.6177C43.0364 33.8 42.943 31.6237 44.1927 31.5473H47.6907C49.5694 31.5473 51.0971 30.0196 51.0971 28.1409V11.9605C51.0971 10.0819 49.5694 8.55415 47.6907 8.55415H24.6975Z" fill="#EF7221"/>
                              <path d="M45.1351 13.6637H40.0255C38.1442 13.6637 36.6191 15.1888 36.6191 17.0701V22.1797C36.6191 24.061 38.1442 25.5861 40.0255 25.5861H45.1351C47.0165 25.5861 48.5415 24.061 48.5415 22.1797V17.0701C48.5415 15.1888 47.0165 13.6637 45.1351 13.6637Z" fill="#EF7221"/>
                              <path d="M29.8059 17.9218H6.81272C3.99513 17.9218 1.70312 20.2138 1.70312 23.0314V39.2117C1.70312 42.0293 3.99513 44.3213 6.81272 44.3213H9.65775C9.76421 45.049 9.53721 45.7601 9.01657 46.2649C8.76126 46.5127 8.68641 46.8928 8.82945 47.2188C8.97175 47.5442 9.30584 47.7478 9.65856 47.7261C12.2027 47.5562 14.1802 46.4426 15.0277 44.3213H29.8059C32.6235 44.3213 34.9155 42.0293 34.9155 39.2117V23.0314C34.9155 20.2138 32.6235 17.9218 29.8059 17.9218ZM11.9223 36.6569C8.63567 36.6569 5.96112 33.9824 5.96112 30.6957C6.26129 22.7984 17.5846 22.8005 17.8835 30.6958C17.8835 33.9824 15.209 36.6569 11.9223 36.6569Z" fill="#EF7221"/>
                              <path d="M30.6587 25.5861H19.5879C19.1173 25.5861 18.7363 25.2052 18.7363 24.7345C18.7363 24.2638 19.1173 23.8829 19.5879 23.8829H28.603L27.5019 22.7819C26.7183 21.992 27.9149 20.7929 28.7061 21.5777L31.2609 24.1325C31.7985 24.6349 31.3951 25.6113 30.6587 25.5861Z" fill="#FFBE94"/>
                              <path d="M22.142 31.5474C21.9241 31.5474 21.7062 31.4643 21.5399 31.298L18.9851 28.7432C18.448 28.2405 18.8505 27.2644 19.5873 27.2894H30.658C31.7736 27.3069 31.7806 28.9737 30.658 28.9926H21.643L22.7441 30.0937C23.2873 30.5996 22.8703 31.5732 22.142 31.5474Z" fill="#FFBE94"/>
                              </g>
                              </g>
                              <defs>
                              <clipPath id="clip0_6517_111435">
                              <rect width="54.5024" height="54.5024" fill="white" transform="translate(0 0.0378418)"/>
                              </clipPath>
                              <clipPath id="clip1_6517_111435">
                              <rect width="54.5024" height="54.5024" fill="white" transform="translate(0 0.0379028)"/>
                              </clipPath>
                              </defs>
                            </svg>
                          </div>
                          <h5>Real-World Experience</h5>
                          <p class="mb-0 theme-text-light">Build confidence through hands-on projects, hackathons, and competitions.</p>
                      </div>
                    </div>
                  </div>
                  <div class="col-6 col-sm-6 col-lg-3">
                    <div class="card border brd-theme rounded-4 h-100">
                      <div class="card-body p-lg-4">
                          <div class="cardicon mb-2">
                            <svg xmlns="http://www.w3.org/2000/svg" width="56" height="55" viewBox="0 0 56 55" fill="none">
                              <g clip-path="url(#clip0_6517_111450)">
                              <path d="M44.0798 15.5256H11.719C8.90138 15.5256 6.60938 17.8176 6.60938 20.6352V24.8932C6.60938 27.7108 8.90138 30.0028 11.719 30.0028V28.2996C9.84028 28.2996 8.31257 26.7718 8.31257 24.8932V20.6352C8.31257 18.7565 9.84028 17.2288 11.719 17.2288H44.0798C45.9585 17.2288 47.4862 18.7565 47.4862 20.6352V24.8932C47.4862 26.7718 45.9585 28.2996 44.0798 28.2996V30.0028C46.8973 30.0028 49.1894 27.7108 49.1894 24.8932V20.6352C49.1894 17.8176 46.8973 15.5256 44.0798 15.5256Z" fill="#EF7221"/>
                              <path d="M48.3379 4.45483H7.46116C4.64357 4.45483 2.35156 6.74684 2.35156 9.56448V36.8157C2.35156 39.6333 4.64357 41.9253 7.46116 41.9253H12.369C12.1252 41.3887 11.9459 40.8184 11.8391 40.2221H7.46116C5.58249 40.2221 4.05476 38.6943 4.05476 36.8157V11.2677H51.7443V36.8157C51.7443 38.6943 50.2166 40.2221 48.3379 40.2221H43.96C43.8532 40.8184 43.6739 41.3887 43.4301 41.9253H48.3379C51.1555 41.9253 53.4475 39.6333 53.4475 36.8157V9.56448C53.4475 6.74684 51.1555 4.45483 48.3379 4.45483ZM6.60956 9.56448C5.49089 9.54277 5.49105 7.88275 6.6096 7.86123C7.72823 7.88292 7.72807 9.54295 6.60956 9.56448ZM10.016 9.56448C8.89729 9.54277 8.89745 7.88275 10.016 7.86123C11.1346 7.88292 11.1344 9.54295 10.016 9.56448ZM13.4224 9.56448C12.3037 9.54277 12.3039 7.88275 13.4224 7.86123C14.541 7.88292 14.5408 9.54295 13.4224 9.56448Z" fill="#EF7221"/>
                              <path d="M36.8409 22.3386H18.9572C15.9052 22.3386 13.4219 24.8218 13.4219 27.874V38.9448C13.4219 41.9969 15.9052 44.4802 18.9572 44.4802H36.8409C39.8929 44.4802 42.3763 41.9969 42.3763 38.9448V27.874C42.3763 24.8218 39.8929 22.3386 36.8409 22.3386ZM31.6465 28.9809C30.7578 28.3114 31.7752 26.9532 32.6678 27.6187L36.0741 30.1734C36.5233 30.4918 36.524 31.2173 36.0741 31.5357L32.6677 34.0905C32.5147 34.2052 32.3358 34.261 32.1579 34.261C31.3733 34.2902 30.9869 33.1861 31.6465 32.7282L34.1439 30.8546L31.6465 28.9809ZM30.3932 26.9126L26.9868 35.4286C26.5501 36.4626 25.0072 35.8401 25.405 34.7965L28.8113 26.2805C29.244 25.2499 30.7915 25.865 30.3932 26.9126ZM24.1517 32.7282C25.0412 33.399 24.0211 34.7562 23.1304 34.0904L19.7241 31.5357C19.2748 31.2174 19.2742 30.4917 19.7241 30.1734L23.1305 27.6186C24.0217 26.9547 25.0418 28.3086 24.1517 28.9809L21.6543 30.8545L24.1517 32.7282Z" fill="#EF7221"/>
                              <path d="M40.5221 46.677L38.7158 44.8699L40.2693 43.3164C41.6542 42.0221 40.9944 39.4988 39.1515 39.0501L28.3593 36.0279C27.132 35.6444 25.8746 36.897 26.2604 38.127L29.2825 48.9191C29.7319 50.7606 32.254 51.4233 33.5488 50.0368L35.1023 48.4834L36.9095 50.2897C37.2413 50.6215 37.6779 50.7878 38.1136 50.7878C39.0326 50.8852 39.922 49.624 40.5221 49.0854C41.1866 48.4218 41.1866 47.3406 40.5221 46.677Z" fill="#FFBE94"/>
                              </g>
                              <defs>
                              <clipPath id="clip0_6517_111450">
                              <rect width="54.5024" height="54.5024" fill="white" transform="translate(0.648438 0.372803)"/>
                              </clipPath>
                              </defs>
                            </svg>
                          </div>
                          <h5>Placement Opportunities</h5>
                          <p class="mb-0 theme-text-light">Connect with 600+ hiring partners for direct career opportunities</p>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!-- End Help Section -->

            <!-- Hear Section -->
            <div class="hearform wow fadeInUp section-padding">
              <div class="container">
                <div class="row">
                    <div class="col-md-6">
                        <h2><?php echo get_field('testimonial_section_heading'); ?></h2>
                    </div> 
                    <div class="col-md-6">
                        <div class="subtext"><?php echo get_field('testimonial_section_subheading'); ?></div>
                    </div>
                </div>
              </div>
              <div class="container-fluid">
                <div class="row mt-80 d-flex align-items-center">
                  <div class="col-md-2">
                    <div class="nav" id="v-pills-tab" role="tablist">
                      <a href="#" class="nav-link" id="video-tab" data-bs-toggle="pill" data-bs-target="#video" role="tab" aria-controls="video" aria-selected="false">Student</a>
                      <a href="#" class="nav-link active" id="review-tab" data-bs-toggle="pill" data-bs-target="#review" role="tab" aria-controls="review" aria-selected="true">College Collaboration</a>
                      <a href="#" class="nav-link" id="college-tab" data-bs-toggle="pill" data-bs-target="#college" role="tab" aria-controls="college" aria-selected="false">Corporate Success</a>
                    </div>
                  </div>
                  <div class="col-md-10">
                    <div class="tab-content" id="v-pills-tabContent">
                      <div class="tab-pane fade" id="video" role="tabpanel" aria-labelledby="video-tab" tabindex="0">
                        <div class="owl-carousel video-review-2">
                            <?php
                  $choose_student_review = get_field('choose_student_review');
                  if ($choose_student_review):
                    foreach ($choose_student_review as $choose):
                      $permalink = get_permalink($choose->ID);
                      $image = wp_get_attachment_image_src(get_post_thumbnail_id($choose->ID), 'single-post-thumbnail');
                      $title = get_the_title($choose->ID);
                      $content = wp_trim_words(get_the_content($choose->ID), 20);
                  ?>
                  <div class="item">
                    <div class="carbox">
                      <div class="bigimg">
                        <?php if (!empty($image[0])): ?>
                          <img src="<?php echo htmlspecialchars($image[0]); ?>" class="img-fluid" alt="">
                        <?php endif; ?>
                      </div>
                      <a href="#" class="play" data-bs-toggle="modal" data-bs-target="#exampleModal">
                        <img src="<?php echo get_stylesheet_directory_uri() ?>/images/caree-play1.png" alt="">
                      </a>
                      <div class="company">
                        <img src="<?php echo get_stylesheet_directory_uri() ?>/images/gpc.png" class="img-fluid" alt="">
                      </div>
                      <div class="coname">
                        <h4><?php echo htmlspecialchars($title); ?></h4>
                        <p><?php echo htmlspecialchars(get_field('post_designation', $choose->ID)); ?></p>
                      </div>
                    </div>
                  </div>
                  <?php 
                    endforeach;
                  else:
                  ?>
                    <p>No projects found.</p>
                  <?php
                  endif;
                  ?>

                        </div>
                      </div>
                      <div class="tab-pane fade show active" id="review" role="tabpanel" aria-labelledby="review-tab" tabindex="0">
                        <div class="owl-carousel video-review-2">
                            <?php
                  $choose_collage_collaboration_review= get_field('choose_collage_collaboration_review');
                  if($choose_collage_collaboration_review):

                    foreach ($choose_collage_collaboration_review as $choose):
                      $permalink = get_permalink($choose->ID);
                      $image = wp_get_attachment_image_src(get_post_thumbnail_id($choose->ID), 'single-post-thumbnail');
                      $title = get_the_title($choose->ID);
                      $content = wp_trim_words(get_the_content($choose->ID), 20);
                  ?>
                  <div class="item">
                    <div class="orangebox">
                      <div class="content">
                        <div class="row">
                        <div class="col-4"><img src="<?php echo get_stylesheet_directory_uri() ?>/images/orange-quote.jpg" class="img-fluid" alt=""></div>
                        <div class="col-8 text-right">
                          <div class="star">
                              <span class="star star-enabled">★</span>
                              <span class="star star-enabled">★</span>
                              <span class="star star-enabled">★</span>
                              <span class="star star-enabled">★</span>
                              <span class="star star-enabled">★</span>
                            </div>
                        </div>
                        </div>
                        <p>“ <?php echo wp_trim_words($choose->post_content,30); ?></p>
                      </div>
                      <div class="blackbg">
                        <?php if (!empty($image[0])): ?>
                          <img src="<?php echo htmlspecialchars($image[0]); ?>" class="img-fluid" alt="">
                        <?php endif; ?>
                        <h5><?php echo htmlspecialchars($title); ?></h5>
                      </div>
                    </div>
                            </div>

                  <?php 
                    endforeach;
                  else:
                  ?>
                    <p>No projects found.</p>
                  <?php
                  endif;
                  ?>

                          
                        </div>
                      </div>
                      <div class="tab-pane fade" id="college" role="tabpanel" aria-labelledby="college-tab" tabindex="0">
                        <div class="owl-carousel video-review-2">
                            <?php
                  $choose_corporate_success_review = get_field('choose_corporate_success_review');
                  if ($choose_corporate_success_review):
                    foreach ($choose_corporate_success_review as $choose):
                  
                      // $permalink = get_permalink($choose->ID);
                      $image = wp_get_attachment_image_src(get_post_thumbnail_id($choose->ID), 'single-post-thumbnail');
                  
                  ?>
                  <div class="item">
                    <div class="reviewbox">
                      <img src="<?php echo $image[0] ?>" alt="" style="width: 63px; height: 63px">
                      </br>
                      <div class="content">
                        <h4><?php echo $choose->post_title; ?></h4>
                        <p><?php echo get_field('designation',$choose->ID) ?> @ <?php echo get_field('course_undertaken',$choose->ID) ?></p>
                      </div>
                      <p><small><?php echo $choose->post_content ?></small></p>
                    </div>
                            </div>
                      
                            <?php 
                    endforeach;
                  else:
                  ?>
                    <p>No projects found.</p>
                  <?php
                  endif;
                  ?>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
	          </div>
            <!-- End Hear Section -->

            <!-- Innovation Section -->
            <div class="innovation wow fadeInUp section-padding pt-0">
              <div class="container">
                <div class="row justify-content-center align-items-center">
                  <div class="col-12 col-lg-7 mb-4 mb-lg-0">
                    <div class="heading-area">
                      <h2 class="fw-semibold mb-3">Innovation in Action Hackathons and Competitions</h2>
                      <p>Our industry-academic collaborations bring learning to life through exciting hackathons and competitions. These platforms allow students to</p>
                      <ul class="list-unstyled mb-0 theme-text-light">
                        <li class="mb-2">
                          <svg xmlns="http://www.w3.org/2000/svg" width="18px" height="18px" viewBox="0 0 22 22" fill="none">
                            <path d="M21.6562 10.75C21.6562 16.6367 16.8438 21.4062 11 21.4062C5.11328 21.4062 0.34375 16.6367 0.34375 10.75C0.34375 4.90625 5.11328 0.09375 11 0.09375C16.8438 0.09375 21.6562 4.90625 21.6562 10.75ZM9.75391 16.4219L17.6602 8.51562C17.918 8.25781 17.918 7.78516 17.6602 7.52734L16.6719 6.58203C16.4141 6.28125 15.9844 6.28125 15.7266 6.58203L9.28125 13.0273L6.23047 10.0195C5.97266 9.71875 5.54297 9.71875 5.28516 10.0195L4.29688 10.9648C4.03906 11.2227 4.03906 11.6953 4.29688 11.9531L8.76562 16.4219C9.02344 16.6797 9.49609 16.6797 9.75391 16.4219Z" fill="#EF7221"/>
                          </svg>
                          <span>Solve real-world challenges.</span>
                        </li>
                        <li class="mb-2">
                          <svg xmlns="http://www.w3.org/2000/svg" width="18px" height="18px" viewBox="0 0 22 22" fill="none">
                            <path d="M21.6562 10.75C21.6562 16.6367 16.8438 21.4062 11 21.4062C5.11328 21.4062 0.34375 16.6367 0.34375 10.75C0.34375 4.90625 5.11328 0.09375 11 0.09375C16.8438 0.09375 21.6562 4.90625 21.6562 10.75ZM9.75391 16.4219L17.6602 8.51562C17.918 8.25781 17.918 7.78516 17.6602 7.52734L16.6719 6.58203C16.4141 6.28125 15.9844 6.28125 15.7266 6.58203L9.28125 13.0273L6.23047 10.0195C5.97266 9.71875 5.54297 9.71875 5.28516 10.0195L4.29688 10.9648C4.03906 11.2227 4.03906 11.6953 4.29688 11.9531L8.76562 16.4219C9.02344 16.6797 9.49609 16.6797 9.75391 16.4219Z" fill="#EF7221"/>
                          </svg>
                          <span>Showcase their technical skills to industry leaders.</span>
                        </li>
                        <li>
                          <svg xmlns="http://www.w3.org/2000/svg" width="18px" height="18px" viewBox="0 0 22 22" fill="none">
                            <path d="M21.6562 10.75C21.6562 16.6367 16.8438 21.4062 11 21.4062C5.11328 21.4062 0.34375 16.6367 0.34375 10.75C0.34375 4.90625 5.11328 0.09375 11 0.09375C16.8438 0.09375 21.6562 4.90625 21.6562 10.75ZM9.75391 16.4219L17.6602 8.51562C17.918 8.25781 17.918 7.78516 17.6602 7.52734L16.6719 6.58203C16.4141 6.28125 15.9844 6.28125 15.7266 6.58203L9.28125 13.0273L6.23047 10.0195C5.97266 9.71875 5.54297 9.71875 5.28516 10.0195L4.29688 10.9648C4.03906 11.2227 4.03906 11.6953 4.29688 11.9531L8.76562 16.4219C9.02344 16.6797 9.49609 16.6797 9.75391 16.4219Z" fill="#EF7221"/>
                          </svg>
                          <span>Network with mentors, peers, and recruiters.</span>
                        </li>
                      </ul>
                    </div>
                  </div>
                  <div class="col-12 col-lg-5">
                      <div class="innovation-slider">
                        <div class="owl-carousel innovation-slider-area">
                          <div class="item">
                            <div class="row gx-3">
                              <div class="col-6 mb-3">
                                <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/img2.jpg" class="image-size170 img-fluid" alt="" />
                              </div>
                              <div class="col-6 mb-3">
                                <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/img1.jpg" class="image-size170 img-fluid" alt="" />
                              </div>
                              <div class="col-12">
                                <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/img3.jpg" class="img-fluid" alt="" />
                              </div>
                            </div>
                          </div>
                          <div class="item">
                            <div class="row gx-3">
                              <div class="col-6 mb-3">
                                <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/img2.jpg" class="image-size170 img-fluid" alt="" />
                              </div>
                              <div class="col-6 mb-3">
                                <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/img1.jpg" class="image-size170 img-fluid" alt="" />
                              </div>
                              <div class="col-12">
                                <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/img3.jpg" class="img-fluid" alt="" />
                              </div>
                            </div>
                          </div>
                          <div class="item">
                            <div class="row gx-3">
                              <div class="col-6 mb-3">
                                <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/img2.jpg" class="image-size170 img-fluid" alt="" />
                              </div>
                              <div class="col-6 mb-3">
                                <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/img1.jpg" class="image-size170 img-fluid" alt="" />
                              </div>
                              <div class="col-12">
                                <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/img3.jpg" class="img-fluid" alt="" />
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                  </div>
                </div>
              </div>
            </div>
            <!-- End Innovation Section -->

            <!-- Newslatter Section -->
            <div class="Newslatter-section wow fadeInUp section-padding py-0 bg-theme-light">
              <div class="container position-relative p-4 p-lg-0">
                <div class="row justify-content-center align-items-center">
                  <div class="col-12 col-lg-5">
                      <div class="Newslatter-image d-none d-lg-block">
                        <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/man.png" class="img-fluid" />
                      </div>
                  </div>
                  <div class="col-12 col-lg-6">
                    <div class="heading-area pt-lg-5">
                      <h2 class="fw-semibold mb-3">Partner With Us to Shape Future Leaders</h2>
                      <p>Together, let’s bridge the gap between education and industry, empowering students for tomorrow’s challenges.</p>
                      <a href="javascript:void(0);" class="mt-lg-4 align-items-center btn btn-primary btn-sm btnwith-icon d-inline-flex justify-content-center p-0 rounded-pill text-center">
                        <span class="px-3">Contact Our Team</span>
                        <span class="btn-icon d-inline-flex justify-content-center align-items-center rounded-pill">
                          <svg xmlns="http://www.w3.org/2000/svg" width="14" height="12" viewBox="0 0 14 12" fill="none">
                            <path d="M9.35547 1.30713L13.1609 5.87369L9.35547 10.4402" stroke="CurrentColor" stroke-width="1.14164" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"></path>
                            <path d="M1.74414 5.87354H13.1605" stroke="CurrentColor" stroke-width="1.14164" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"></path>
                          </svg>
                        </span>
                      </a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!-- End Newslatter Section -->

            <!-- FAQ Section -->
            <?php
            include('components/faq.php'); 
            ?>
            <!-- End FAQ Section -->
        </div>
        <div id="awardsection" class="contentarea">
          <!-- The Summer Training program 2023 Provides -->
          <div class="thesummer wow fadeInUp bg-transparent bg-image-none">
            <div class="container">
              <div class="row">
                <div class="col-lg-12">
                  <div class="heading-area text-center mb-4">
                    <h2 class="fw-semibold mb-3">Master New Tech, Every Week</h2>
                    <p>Each week, we organize a diverse range of masterclasses covering high-demand technologies and real-world applications. These sessions help learners go beyond the curriculum and gain advanced knowledge that keeps them industry-ready.</p>
                    <h5 class="fw-semibold">Ready to Begin Your Internship Journey?</h5>
                  </div>
                </div>
              </div>
              <div class="row g-3">
                <div class="col-6 col-sm-6 col-lg-4">
                    <div class="d-flex align-items-center gap-1 gap-md-3 p-2 p-md-3 explorearea explore-1">
                      <div class="iconarea d-flex align-items-center justify-content-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="36" height="37" viewBox="0 0 36 37" fill="none">
                          <path d="M32.3628 20.1904V19.0086C32.689 19.0086 32.9538 18.7441 32.9538 18.4177V14.8722C32.9538 14.5458 32.689 14.2813 32.3628 14.2813H29.1719L29.0575 13.8374C28.7962 12.8223 28.3904 11.8498 27.8519 10.9503L27.6156 10.5549L29.881 8.28544C30.1091 8.05693 30.1091 7.68668 29.881 7.45817L27.3715 4.94497C27.1398 4.72407 26.7758 4.72407 26.544 4.94497L24.2743 7.21465L23.8792 6.97828C22.9783 6.43954 22.0049 6.03376 20.9883 5.77224L20.5447 5.65682V2.46316C20.5447 2.13677 20.2802 1.87224 19.9538 1.87224H16.4084C16.0819 1.87224 15.8174 2.13677 15.8174 2.46316V5.65406L15.3736 5.76877C14.3584 6.02983 13.386 6.43563 12.486 6.97344L12.0905 7.21003L9.82155 4.94497C9.58958 4.72222 9.22328 4.72222 8.99131 4.94497L6.4811 7.45447C6.37076 7.56458 6.30867 7.71415 6.30867 7.86996C6.30867 8.02599 6.37076 8.17534 6.4811 8.28544L8.75078 10.5549L8.51443 10.9503C7.97615 11.8498 7.57012 12.8223 7.30906 13.8374L7.19319 14.2813H3.99929C3.6729 14.2813 3.40838 14.5458 3.40838 14.8722V18.4177C3.40838 18.7441 3.6729 19.0086 3.99929 19.0086V20.1904C3.02036 20.1904 2.22656 19.3966 2.22656 18.4177V14.8722C2.22656 13.8933 3.02036 13.0995 3.99929 13.0995H6.28559C6.52934 12.2824 6.85896 11.4934 7.2689 10.746L5.6439 9.12102C5.31152 8.78933 5.12478 8.33923 5.12478 7.86996C5.12478 7.4007 5.31152 6.95059 5.6439 6.61913L8.15526 4.10777C8.85489 3.43815 9.95796 3.43815 10.6577 4.10777L12.2822 5.73208C13.0296 5.32236 13.8188 4.99344 14.6357 4.74992V2.46316C14.6357 1.48423 15.4294 0.69043 16.4084 0.69043H19.9538C20.9327 0.69043 21.7266 1.48423 21.7266 2.46316V4.74992C22.5436 4.99344 23.3324 5.32305 24.08 5.73277L25.705 4.10777C26.4049 3.43815 27.5077 3.43815 28.2076 4.10777L30.7185 6.61844C31.0507 6.95012 31.2372 7.39977 31.2372 7.86927C31.2372 8.33876 31.0507 8.78887 30.7185 9.12033L29.0935 10.7453C29.5032 11.4932 29.8325 12.2824 30.0766 13.0995H32.3628C33.3418 13.0995 34.1356 13.8933 34.1356 14.8722V18.4177C34.1356 19.3966 33.3418 20.1904 32.3628 20.1904Z" fill="#1B75E8"/>
                          <path d="M26.4556 16.6443H25.2738C25.2738 12.7281 22.099 9.5534 18.1829 9.5534C14.2667 9.5534 11.0919 12.7281 11.0919 16.6443H9.91016C9.91016 12.0754 13.6139 8.37158 18.1829 8.37158C22.7515 8.37158 26.4556 12.0754 26.4556 16.6443Z" fill="#1B75E8"/>
                          <path d="M18.1822 21.3726C16.2241 21.3726 14.6367 19.785 14.6367 17.8272C14.6367 15.8691 16.2241 14.2817 18.1822 14.2817C20.1405 14.2817 21.7276 15.8691 21.7276 17.8272C21.7255 19.7845 20.1395 21.3705 18.1822 21.3726ZM18.1822 15.4635C16.8768 15.4635 15.8185 16.5218 15.8185 17.8272C15.8185 19.1325 16.8768 20.1908 18.1822 20.1908C19.4874 20.1908 20.5458 19.1325 20.5458 17.8272C20.5458 16.5218 19.4874 15.4635 18.1822 15.4635Z" fill="#1B75E8"/>
                          <path d="M28.2251 23.7359C26.2671 23.7359 24.6797 22.1483 24.6797 20.1905C24.6797 18.2324 26.2671 16.645 28.2251 16.645C30.1832 16.645 31.7706 18.2324 31.7706 20.1905C31.7685 22.1478 30.1825 23.7338 28.2251 23.7359ZM28.2251 17.8268C26.9198 17.8268 25.8615 18.8851 25.8615 20.1905C25.8615 21.4957 26.9198 22.5541 28.2251 22.5541C29.5305 22.5541 30.5888 21.4957 30.5888 20.1905C30.5888 18.8851 29.5305 17.8268 28.2251 17.8268Z" fill="#1B75E8"/>
                          <path d="M8.13529 23.7359C6.17721 23.7359 4.58984 22.1483 4.58984 20.1905C4.58984 18.2324 6.17721 16.645 8.13529 16.645C10.0936 16.645 11.6808 18.2324 11.6808 20.1905C11.6786 22.1478 10.0927 23.7338 8.13529 23.7359ZM8.13529 17.8268C6.82999 17.8268 5.77166 18.8851 5.77166 20.1905C5.77166 21.4957 6.82999 22.5541 8.13529 22.5541C9.44057 22.5541 10.4989 21.4957 10.4989 20.1905C10.4989 18.8851 9.44057 17.8268 8.13529 17.8268Z" fill="#1B75E8"/>
                          <path d="M33.5847 25.2519C32.7041 24.6467 31.6601 24.3238 30.5914 24.3268H25.8641C25.5767 24.3294 25.2898 24.3555 25.0066 24.4047C24.6285 23.8133 24.1367 23.3032 23.5596 22.9032C23.4731 22.8378 23.3821 22.7784 23.2872 22.7261C22.4607 22.2254 21.5122 21.9618 20.5459 21.9632H15.8187C14.0116 21.9567 12.3277 22.8789 11.3597 24.4047C11.0758 24.3555 10.7883 24.3294 10.5005 24.3268H5.77325C4.70546 24.3238 3.66168 24.6463 2.78154 25.2508C1.3269 26.2406 0.456001 27.8857 0.455078 29.645V32.0086C0.457156 33.6221 1.39592 35.0874 2.86141 35.7632C3.40246 36.0181 3.9936 36.1484 4.59144 36.145H10.5005V34.9632H5.18234V28.4632H4.00052V34.9038C3.77801 34.8593 3.56196 34.7873 3.35699 34.6901C2.3102 34.2075 1.6392 33.1611 1.63689 32.0086V29.645C1.63828 28.2758 2.31667 26.9959 3.44863 26.2258C4.13256 25.7564 4.94344 25.5063 5.77325 25.5086H10.5005C10.6047 25.5086 10.705 25.5197 10.8066 25.5266C10.6067 26.0903 10.5031 26.6835 10.5005 27.2814V33.1905C10.5026 34.8215 11.8243 36.1429 13.455 36.145H15.2277V26.6905H14.046V34.9632H13.455C12.4761 34.9632 11.6823 34.1694 11.6823 33.1905V27.2814C11.6823 24.9967 13.5344 23.145 15.8187 23.145H20.5459C21.3062 23.1455 22.0514 23.356 22.6998 23.753C22.7598 23.7858 22.8175 23.8228 22.8722 23.8634C23.4259 24.2425 23.8804 24.7493 24.1971 25.3406C24.5154 25.938 24.6823 26.6043 24.6823 27.2814V33.1905C24.6823 34.1694 23.8885 34.9632 22.9096 34.9632H22.3187V26.6905H21.1369V36.145H22.9096C24.5406 36.1429 25.8621 34.8215 25.8641 33.1905V27.2814C25.8614 26.6835 25.7582 26.0905 25.5585 25.5266C25.6603 25.5197 25.7607 25.5086 25.8641 25.5086H30.5914C31.4216 25.5063 32.2333 25.757 32.9176 26.2269C34.0486 26.9974 34.7262 28.2765 34.7277 29.645V32.0086C34.7256 33.1653 34.0496 34.2146 32.9977 34.6947C32.7957 34.7903 32.5829 34.8605 32.3641 34.9038V28.4632H31.1823V34.9632H25.8641V36.145H31.7732C32.3675 36.1487 32.9553 36.0199 33.4933 35.7678C34.9636 35.094 35.9072 33.626 35.9095 32.0086V29.645C35.9086 27.8864 35.0384 26.242 33.5847 25.2519Z" fill="#1B75E8"/>
                          <path d="M15.8164 34.9624H20.5436V36.1442H15.8164V34.9624Z" fill="#1B75E8"/>
                        </svg>
                      </div>
                      <div class="headarea">
                        <h6 class="mb-0">Data Science & Machine Learning</h6>
                      </div>
                    </div>
                </div>
                <div class="col-6 col-sm-6 col-lg-4">
                    <div class="d-flex align-items-center gap-1 gap-md-3 p-2 p-md-3 explorearea explore-2">
                      <div class="iconarea d-flex align-items-center justify-content-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="36" height="37" viewBox="0 0 36 37" fill="none">
                          <path d="M31.1277 26.6905C31.3154 25.6942 31.3106 24.6713 31.1136 23.6769L33.8199 17.1456C33.8202 17.1413 33.8202 17.1369 33.8199 17.1326C34.2585 15.9319 34.9012 14.8161 35.7196 13.8341C35.9233 13.619 36.0052 13.316 35.9377 13.0275L34.828 8.23533C34.8148 8.18523 34.7949 8.13713 34.7689 8.09233C34.7641 8.08346 34.7624 8.07283 34.7577 8.06455C34.753 8.05628 34.7322 8.03619 34.7204 8.02083C34.6962 7.98542 34.6683 7.95273 34.6371 7.92333C34.6166 7.90887 34.595 7.89584 34.5727 7.88433C34.5439 7.86312 34.5133 7.84453 34.4811 7.82879C34.4366 7.81195 34.3902 7.80064 34.3429 7.7951C34.3293 7.7951 34.3174 7.78624 34.3039 7.78505C34.1906 7.77751 34.0776 7.80274 33.9783 7.85773C33.9694 7.86247 33.9588 7.86424 33.9499 7.86956H33.944L29.7716 10.4737C29.5189 10.6301 29.3621 10.9034 29.3544 11.2005C29.2386 12.4763 28.9024 13.7225 28.3611 14.8836V14.8901L27.0085 18.1596C26.3447 17.8066 25.634 17.55 24.8979 17.3973C25.1765 15.4739 25.279 13.5291 25.2039 11.5869C26.3039 10.2671 26.8318 8.56308 26.6706 6.85261C26.3012 3.40881 23.1889 0.921688 23.056 0.817098C22.8561 0.659735 22.5781 0.6479 22.3656 0.787718C22.1531 0.927535 22.054 1.18763 22.1194 1.43341C22.4237 2.57622 22.1601 3.78226 19.9123 6.26229C18.9024 7.23746 18.5823 8.72643 19.1022 10.0305C19.301 10.5292 19.5858 10.9893 19.9437 11.3895C19.8006 12.3025 19.6884 13.1671 19.611 14.0091C19.4777 15.4018 19.4433 16.8022 19.5081 18.1997C18.981 18.4856 18.4875 18.8294 18.0369 19.225L15.1709 6.96961C15.1709 6.9572 15.1591 6.94833 15.1556 6.9371C15.146 6.89771 15.1321 6.85947 15.1142 6.82306L12.1869 1.41687C11.8939 0.875758 11.275 0.597699 10.6759 0.738017C10.0768 0.878334 9.64575 1.4023 9.6235 2.01723L9.40133 8.15969C9.40148 8.20402 9.40643 8.2482 9.41609 8.29146C9.41609 8.30092 9.41609 8.30919 9.41609 8.31805L12.3399 20.7962C11.8787 20.8166 11.4208 20.8849 10.9737 21L7.75743 13.2327C7.49953 12.6389 6.81549 12.3587 6.21517 12.6009L1.29943 14.636C0.697807 14.8871 0.411899 15.577 0.659476 16.1801L5.02154 26.7029C2.46499 26.8371 0.480534 28.9832 0.546521 31.5424C0.612507 34.1016 2.70493 36.1427 5.26499 36.145H31.2649C32.9537 36.1205 34.5012 35.1968 35.3245 33.722C36.1477 32.2471 36.1216 30.4451 35.2559 28.9948C34.3903 27.5444 32.8166 26.666 31.1277 26.6905ZM30.5256 11.3955L33.0027 9.84967L32.1258 11.9675C32.0008 12.269 32.144 12.6148 32.4455 12.7398C32.747 12.8648 33.0928 12.7217 33.2178 12.4201L34.0947 10.3023L34.7512 13.1463C34.0488 14.0033 33.4718 14.9557 33.0376 15.975C32.4215 16.2606 31.7141 16.2754 31.0865 16.0158C30.4591 15.7563 29.9687 15.2461 29.7344 14.6088C30.1494 13.5807 30.4158 12.4987 30.5256 11.3955ZM29.1665 16.0347C29.5575 16.5126 30.0647 16.882 30.6396 17.1072C31.0966 17.3037 31.5881 17.4074 32.0856 17.4121C32.2053 17.4117 32.3249 17.4043 32.4437 17.3902L30.5581 21.9402C29.9935 20.6953 29.12 19.6154 28.0208 18.8031L29.1665 16.0347ZM21.0712 11.8145L24.0399 11.9958C24.0581 12.5478 24.0516 13.1186 24.0333 13.6983C23.0444 13.7689 22.0505 13.7209 21.0729 13.5553C20.9985 13.5447 20.9258 13.5363 20.8519 13.5263C20.911 12.9697 20.983 12.4059 21.0699 11.8145H21.0712ZM20.7893 7.05588C22.3582 5.32512 23.1712 3.99381 23.3603 2.74226C24.488 3.90254 25.2324 5.38099 25.4929 6.97788C25.617 8.36804 25.1872 9.75093 24.2969 10.8258C23.1296 10.7549 21.9752 10.684 20.8336 10.6131C20.343 10.1546 20.0609 9.51566 20.0523 8.8442C20.0437 8.17275 20.3094 7.52685 20.788 7.05588H20.7893ZM20.7444 14.7039L20.9157 14.7264C21.6772 14.8441 22.4457 14.9096 23.2162 14.922C23.4608 14.922 23.7184 14.9025 23.9766 14.8824C23.9229 15.6429 23.8347 16.4371 23.7231 17.2579C23.5772 17.2502 23.4342 17.236 23.2876 17.236C22.3955 17.2376 21.51 17.3901 20.6687 17.6869C20.6414 16.692 20.6664 15.6963 20.7432 14.7039H20.7444ZM16.1737 21.614L14.4831 14.4127C14.4041 14.1002 14.0893 13.9088 13.7755 13.9823C13.4617 14.0557 13.2647 14.3671 13.3327 14.6821L14.8518 21.1637C14.4342 21.0144 14.0027 20.9069 13.5637 20.8429L10.9702 9.77521C11.3335 9.94061 11.728 10.0265 12.1272 10.0269C12.1644 10.0269 12.204 10.0216 12.2418 10.0199L12.6596 11.8038C12.7046 12.0126 12.8588 12.1809 13.0629 12.2439C13.267 12.3069 13.4892 12.2548 13.6441 12.1078C13.799 11.9606 13.8624 11.7414 13.8101 11.5344L13.3917 9.74924C13.7926 9.5717 14.1463 9.30254 14.424 8.96332L17.0606 20.2372C16.7182 20.6643 16.421 21.1257 16.1737 21.614ZM12.5633 8.79137C11.8076 8.93793 11.0359 8.62897 10.5903 8.00133L10.6652 5.92016C10.8709 5.95856 11.0795 5.97833 11.2887 5.97925C11.4907 5.9801 11.6922 5.95769 11.889 5.91248C12.2876 5.80779 12.6605 5.62235 12.9846 5.36766L13.9797 7.20419C13.8611 7.96618 13.3068 8.58783 12.5633 8.79255V8.79137ZM10.9448 1.88841C11.0253 1.86976 11.1083 1.90695 11.148 1.97941L12.4149 4.32235C12.1864 4.5291 11.9135 4.68071 11.6172 4.76553C11.3144 4.82111 11.0029 4.80636 10.7066 4.72239L10.803 2.05977C10.8062 1.9772 10.8642 1.90701 10.9448 1.88841ZM6.66839 13.6905L7.11984 14.7814L4.93349 15.6866C4.6743 15.7955 4.52767 16.0719 4.58289 16.3475C4.6381 16.6232 4.87988 16.8217 5.161 16.8223C5.23863 16.8222 5.31549 16.8069 5.38731 16.7775L7.57366 15.8716L8.02571 16.9636L6.93193 17.4168C6.67126 17.5247 6.5232 17.8018 6.57842 18.0785C6.63364 18.3551 6.87672 18.5542 7.15884 18.5538C7.23628 18.5534 7.31293 18.5382 7.38457 18.5088L8.47834 18.0556L8.93038 19.1476L6.74226 20.0546C6.48158 20.1625 6.33352 20.4396 6.38873 20.7163C6.44396 20.9929 6.68705 21.1919 6.96916 21.1915C7.0466 21.1913 7.12326 21.1761 7.19489 21.1466L9.38124 20.2413L9.85927 21.3954C7.93376 22.2743 6.52179 23.9928 6.03317 26.0523L1.75029 15.7256L6.66839 13.6905ZM31.2649 34.9632H5.26499C3.3069 34.9632 1.71956 33.3758 1.71956 31.4177C1.71956 29.4597 3.3069 27.8723 5.26499 27.8723C5.60738 27.8711 5.94806 27.9205 6.27603 28.0189C6.45321 28.0723 6.64523 28.0398 6.79483 27.9308C6.94443 27.8218 7.03433 27.649 7.03771 27.464C7.07974 25.358 8.29716 23.4529 10.1906 22.5299C12.084 21.607 14.3347 21.8217 16.0195 23.086C16.1683 23.1968 16.3607 23.2312 16.5387 23.1789C16.7168 23.1267 16.86 22.9937 16.9254 22.8201C18.0798 19.7433 21.2705 17.9336 24.5036 18.5216C27.7368 19.1097 30.0859 21.927 30.083 25.2132C30.0841 25.889 29.9835 26.5611 29.7846 27.207C29.7225 27.4079 29.7719 27.6267 29.9142 27.7814C30.0567 27.9363 30.2705 28.0037 30.476 27.9586C30.7351 27.9015 30.9996 27.8726 31.2649 27.8723C33.2229 27.8723 34.8102 29.4597 34.8102 31.4177C34.8102 33.3758 33.2229 34.9632 31.2649 34.9632Z" fill="#FF6881"/>
                          <path d="M23.3999 9.96718C23.5853 9.96789 23.7604 9.88147 23.8726 9.73371C24.6103 8.73526 24.8954 7.47313 24.6585 6.25449C24.6081 6.04613 24.4488 5.8814 24.2422 5.82404C24.0357 5.76669 23.8143 5.82572 23.6637 5.97828C23.5131 6.13084 23.4569 6.353 23.5169 6.55881C23.6583 7.42474 23.4472 8.31127 22.9307 9.02052C22.7964 9.19958 22.7748 9.43914 22.8749 9.63931C22.975 9.83954 23.1796 9.96594 23.4034 9.96594L23.3999 9.96718Z" fill="#FF6881"/>
                          <path d="M22.6194 27.8717C22.1799 27.8731 21.7466 27.9741 21.3519 28.1672C20.2889 26.7126 18.304 26.2865 16.7377 27.1766C15.1713 28.0667 14.5215 29.9899 15.2271 31.6476C15.32 31.8655 15.534 32.007 15.7708 32.0069C15.8504 32.0071 15.9292 31.991 16.0024 31.9596C16.1466 31.8982 16.2604 31.782 16.319 31.6366C16.3775 31.4913 16.3758 31.3285 16.3144 31.1843C16.1858 30.8845 16.1194 30.5616 16.1194 30.2354C16.1194 28.9299 17.1776 27.8717 18.483 27.8717C19.3998 27.8672 20.2349 28.3985 20.6191 29.2309C20.632 29.2501 20.6457 29.2686 20.6605 29.2863C20.6698 29.3066 20.6803 29.3263 20.6918 29.3455C20.7024 29.3585 20.7178 29.3643 20.7296 29.3768C20.7574 29.4056 20.788 29.4313 20.8212 29.4536C20.8507 29.4763 20.8824 29.4961 20.9158 29.5127C20.9501 29.5271 20.9857 29.5382 21.0221 29.5458C21.0585 29.5554 21.0957 29.561 21.1332 29.5629C21.21 29.5623 21.2862 29.5495 21.359 29.5251C21.3747 29.5222 21.3902 29.5185 21.4057 29.5139C21.4248 29.5015 21.4432 29.4878 21.4606 29.4731C21.4819 29.4636 21.5025 29.453 21.5227 29.4412C21.833 29.1902 22.2201 29.0533 22.6194 29.0536C23.3103 29.0546 23.9376 29.4571 24.2266 30.0847C24.362 30.3816 24.7126 30.5126 25.0095 30.3772C25.3066 30.2418 25.4375 29.8912 25.302 29.5943C24.8209 28.5454 23.7732 27.8728 22.6194 27.8717Z" fill="#FF6881"/>
                          <path d="M10.9894 23.7658C10.9002 23.7947 8.8125 24.5168 8.8125 26.6901C8.8125 27.0165 9.07705 27.2811 9.4034 27.2811C9.72971 27.2811 9.99429 27.0165 9.99429 26.6901C10.0425 25.8658 10.5849 25.1527 11.3664 24.8861C11.6764 24.782 11.8433 24.4463 11.7393 24.1363C11.6351 23.8262 11.2995 23.6593 10.9894 23.7634V23.7658Z" fill="#FF6881"/>
                          <path d="M19.3029 23.1278C19.3498 23.1397 19.3981 23.1456 19.4465 23.1456C19.7173 23.1452 19.9533 22.9609 20.019 22.6982C20.2911 21.5948 21.2678 20.8099 22.404 20.7819C22.7303 20.7811 22.9942 20.5159 22.9934 20.1895C22.9925 19.8632 22.7273 19.5993 22.401 19.6001C20.7215 19.6223 19.2701 20.7789 18.8733 22.411C18.794 22.7275 18.9863 23.0485 19.3029 23.1278Z" fill="#FF6881"/>
                        </svg>
                      </div>
                      <div class="headarea">
                        <h6 class="mb-0">UI/UX Design</h6>
                      </div>
                    </div>
                </div>
                <div class="col-6 col-sm-6 col-lg-4">
                    <div class="d-flex align-items-center gap-1 gap-md-3 p-2 p-md-3 explorearea explore-3">
                      <div class="iconarea d-flex align-items-center justify-content-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="42" height="37" viewBox="0 0 42 37" fill="none">
                          <path d="M16.8327 26.483C16.681 26.483 16.528 26.4308 16.4033 26.3246L12.1102 22.669C11.962 22.5428 11.877 22.3584 11.877 22.1637C11.877 21.9693 11.9625 21.785 12.1102 21.6587L16.4033 18.0031C16.682 17.7655 17.1007 17.7992 17.3385 18.0779C17.5757 18.357 17.5424 18.7757 17.2633 19.0131L13.5636 22.1637L17.2633 25.3143C17.5424 25.5519 17.5757 25.9706 17.3385 26.2494C17.207 26.4038 17.0204 26.483 16.8327 26.483Z" fill="#00BC65"/>
                          <path d="M25.3083 26.483C25.1206 26.483 24.934 26.4038 24.8029 26.2494C24.5653 25.9706 24.599 25.5519 24.8777 25.3143L28.5773 22.1637L24.8777 19.0131C24.599 18.7757 24.5653 18.357 24.8029 18.0779C25.0403 17.7992 25.4593 17.7655 25.7378 18.0031L30.0308 21.6587C30.1789 21.785 30.2641 21.9693 30.2641 22.1637C30.2641 22.3584 30.1789 22.5428 30.0308 22.669L25.7378 26.3246C25.613 26.4308 25.4601 26.483 25.3083 26.483Z" fill="#00BC65"/>
                          <path d="M19.5493 29.2249C19.5037 29.2249 19.4578 29.2201 19.4115 29.2104C19.0532 29.1349 18.8236 28.7828 18.8991 28.4245L21.5747 15.7211C21.6502 15.3628 22.0019 15.1332 22.3607 15.2087C22.7191 15.2842 22.9487 15.6359 22.8732 15.9946L20.1975 28.6981C20.1316 29.0105 19.8561 29.2249 19.5493 29.2249Z" fill="#00BC65"/>
                          <path d="M36.7073 36.145H5.43105C2.97501 36.145 0.976562 34.1469 0.976562 31.6905V5.14492C0.976562 2.68888 2.97501 0.69043 5.43105 0.69043H36.7073C39.1633 0.69043 41.1618 2.68888 41.1618 5.14492V31.6905C41.1618 34.1469 39.1633 36.145 36.7073 36.145ZM5.43105 2.0173C3.70657 2.0173 2.30343 3.42044 2.30343 5.14492V31.6905C2.30343 33.415 3.70657 34.8181 5.43105 34.8181H36.7073C38.4318 34.8181 39.8349 33.415 39.8349 31.6905V5.14492C39.8349 3.42044 38.4318 2.0173 36.7073 2.0173H5.43105Z" fill="#00BC65"/>
                          <path d="M40.4984 11.3137H1.64C1.27348 11.3137 0.976562 11.0168 0.976562 10.6503C0.976562 10.2841 1.27348 9.98682 1.64 9.98682H40.4984C40.8649 9.98682 41.1618 10.2841 41.1618 10.6503C41.1618 11.0168 40.8649 11.3137 40.4984 11.3137Z" fill="#00BC65"/>
                          <path d="M12.3124 8.13898C11.1551 8.13898 10.2129 7.19677 10.2129 6.03946C10.2129 4.88178 11.1551 3.93994 12.3124 3.93994C13.4701 3.93994 14.4119 4.88178 14.4119 6.03946C14.4119 7.19677 13.4701 8.13898 12.3124 8.13898ZM12.3124 5.26681C11.8867 5.26681 11.5398 5.61333 11.5398 6.03946C11.5398 6.46558 11.8867 6.81211 12.3124 6.81211C12.7386 6.81211 13.0851 6.46558 13.0851 6.03946C13.0851 5.61333 12.7386 5.26681 12.3124 5.26681Z" fill="#00BC65"/>
                          <path d="M5.86319 8.11799C4.70551 8.11799 3.76367 7.17615 3.76367 6.01847C3.76367 4.86079 4.70551 3.91895 5.86319 3.91895C7.02087 3.91895 7.96271 4.86079 7.96271 6.01847C7.96271 7.17615 7.02087 8.11799 5.86319 8.11799ZM5.86319 5.24581C5.43744 5.24581 5.09054 5.59271 5.09054 6.01847C5.09054 6.44459 5.43744 6.79112 5.86319 6.79112C6.28931 6.79112 6.63584 6.44459 6.63584 6.01847C6.63584 5.59271 6.28931 5.24581 5.86319 5.24581Z" fill="#00BC65"/>
                          <path d="M18.7632 8.15913C17.6059 8.15913 16.6641 7.21729 16.6641 6.05961C16.6641 4.90229 17.6059 3.96045 18.7632 3.96045C19.9209 3.96045 20.8628 4.90229 20.8628 6.05961C20.8628 7.21729 19.9209 8.15913 18.7632 8.15913ZM18.7632 5.28695C18.3375 5.28695 17.9909 5.63348 17.9909 6.05961C17.9909 6.48573 18.3375 6.83225 18.7632 6.83225C19.1894 6.83225 19.5359 6.48573 19.5359 6.05961C19.5359 5.63348 19.1894 5.28695 18.7632 5.28695Z" fill="#00BC65"/>
                        </svg>
                      </div>
                      <div class="headarea">
                        <h6 class="mb-0">Cybersecurity & Ethical Hacking</h6>
                      </div>
                    </div>
                </div>
                <div class="col-6 col-sm-6 col-lg-4">
                  <div class="d-flex align-items-center gap-1 gap-md-3 p-2 p-md-3 explorearea explore-4">
                    <div class="iconarea d-flex align-items-center justify-content-center">
                      <svg xmlns="http://www.w3.org/2000/svg" width="35" height="37" viewBox="0 0 35 37" fill="none">
                        <path d="M30.6539 6.33925C31.3577 6.33925 31.9271 5.76983 31.9271 5.06612C31.9271 4.3624 31.3577 3.79297 30.6539 3.79297C29.9503 3.79297 29.3809 4.3624 29.3809 5.06612C29.3809 5.76983 29.9557 6.33925 30.6539 6.33925ZM30.6539 4.70082C30.8581 4.70082 31.0246 4.86735 31.0246 5.07149C31.0246 5.27562 30.8581 5.44215 30.6539 5.44215C30.4445 5.44215 30.2834 5.28099 30.2834 5.07149C30.2834 4.86198 30.4498 4.70082 30.6539 4.70082Z" fill="#F2A700"/>
                        <path d="M32.0683 1.73535H5.89632C4.90252 1.73535 4.09136 2.5465 4.09136 3.54031V6.2961H2.29715C1.30334 6.2961 0.492188 7.10725 0.492188 8.10105V30.7328C0.492188 31.7266 1.30334 32.5378 2.29715 32.5378H14.2926V35.1485C14.2926 35.3957 14.4967 35.5998 14.7438 35.5998H23.2207C23.4678 35.5998 23.6719 35.3957 23.6719 35.1485V32.5378H28.4691C29.4629 32.5378 30.274 31.7266 30.274 30.7328V27.9771H32.0683C33.062 27.9771 33.8732 27.1659 33.8732 26.1722V3.54031C33.8732 2.5465 33.062 1.73535 32.0683 1.73535ZM4.99384 3.54031C4.99384 3.04072 5.40211 2.63783 5.89632 2.63783H32.0683C32.5678 2.63783 32.9707 3.04609 32.9707 3.54031V7.4994H15.8451L13.8306 5.40973C13.6748 5.24857 13.4599 5.15725 13.2397 5.15725H8.80252C8.35128 5.15725 7.98062 5.52791 7.98062 5.97915V7.4994H4.99384V3.54031ZM2.29715 31.6408C1.79756 31.6408 1.39466 31.2325 1.39466 30.7383V8.10105C1.39466 7.60146 1.80293 7.19858 2.29715 7.19858H4.09136V26.1775C4.09136 27.1713 4.90252 27.9825 5.89632 27.9825H15.6946C15.8719 28.3263 15.9525 28.713 15.9203 29.1105H15.2219C14.7063 29.1105 14.2926 29.5295 14.2926 30.0399V31.6408H2.29715ZM18.5364 22.1916C18.6277 22.0304 18.7942 21.9283 18.9822 21.9283C19.2616 21.9283 19.4872 22.1539 19.4872 22.4333C19.4872 22.6159 19.3905 22.7824 19.2348 22.8738C19.0628 22.9758 18.8587 22.9651 18.6492 22.847C18.6224 22.8308 18.5955 22.8093 18.5847 22.7824C18.4128 22.5085 18.4827 22.2936 18.5364 22.1916ZM18.531 21.1118C18.2033 21.2247 17.924 21.4448 17.7522 21.7565C17.4942 22.2184 17.5265 22.7824 17.8273 23.2659C17.924 23.4164 18.0529 23.5399 18.2087 23.6312C18.4558 23.7709 18.7244 23.8461 18.9877 23.8461C19.2348 23.8461 19.4765 23.7816 19.6913 23.6581C20.1211 23.4056 20.3897 22.9383 20.3897 22.4386C20.3897 21.8209 19.9869 21.2998 19.4335 21.1118V18.7911L23.4248 25.9949C23.4195 26.0002 23.4141 26.011 23.3979 26.0163C21.9852 26.3816 21.0612 27.7031 21.1364 29.1105H16.8335C16.9141 27.6978 15.9847 26.3763 14.5451 25.9733L18.531 18.7911V21.1118ZM22.7695 34.6974H15.1951L15.2219 30.0076H22.7426C22.7587 30.0076 22.7695 30.0184 22.7695 30.0345V34.6974ZM29.3715 30.7328C29.3715 31.2325 28.9632 31.6353 28.4691 31.6353H23.6719V30.0345C23.6719 29.5188 23.2529 29.1052 22.7426 29.1052H22.0443C22.012 28.7077 22.098 28.3209 22.2699 27.9771H29.3715V30.7328ZM32.0683 27.08H23.1455C23.2905 26.9994 23.4463 26.9296 23.6182 26.8866C23.9029 26.8114 24.1339 26.6126 24.2521 26.344C24.365 26.0808 24.3488 25.7853 24.2091 25.5329L19.5893 17.2118C19.4711 16.9916 19.2401 16.8519 18.9877 16.8519C18.7298 16.8573 18.4988 16.9861 18.3753 17.2064L13.75 25.5329C13.6104 25.7853 13.5996 26.0862 13.7125 26.3494C13.8252 26.618 14.0563 26.8114 14.341 26.8866C14.5128 26.9296 14.6633 26.9994 14.8137 27.08H5.89632C5.39674 27.08 4.99384 26.6717 4.99384 26.1775V8.40188H8.05583C8.50707 8.40188 8.87773 8.03122 8.87773 7.57998V6.05973H13.2021L15.2165 8.1494C15.3724 8.31056 15.5872 8.40188 15.8075 8.40188H32.9707V26.1722C32.9707 26.6717 32.5678 27.08 32.0683 27.08Z" fill="#F2A700"/>
                        <path d="M27.5817 6.33925C28.2855 6.33925 28.8549 5.76983 28.8549 5.06612C28.8549 4.3624 28.2855 3.79297 27.5817 3.79297C26.878 3.79297 26.3086 4.3624 26.3086 5.06612C26.3086 5.76983 26.878 6.33925 27.5817 6.33925ZM27.5817 4.70082C27.7858 4.70082 27.9524 4.86735 27.9524 5.07149C27.9524 5.27562 27.7858 5.44215 27.5817 5.44215C27.3722 5.44215 27.211 5.28099 27.211 5.07149C27.211 4.86198 27.3775 4.70082 27.5817 4.70082Z" fill="#F2A700"/>
                        <path d="M24.5036 6.33925C25.2073 6.33925 25.7767 5.76983 25.7767 5.06612C25.7767 4.3624 25.2073 3.79297 24.5036 3.79297C23.7999 3.79297 23.2305 4.3624 23.2305 5.06612C23.2305 5.76983 23.7999 6.33925 24.5036 6.33925ZM24.5036 4.70082C24.7078 4.70082 24.8743 4.86735 24.8743 5.07149C24.8743 5.27562 24.7078 5.44215 24.5036 5.44215C24.2941 5.44215 24.133 5.28099 24.133 5.07149C24.133 4.86198 24.2995 4.70082 24.5036 4.70082Z" fill="#F2A700"/>
                        <path d="M27.6793 12.334C27.4161 12.5973 27.2496 12.9303 27.1852 13.2848H20.8731V12.5757C20.8731 12.0923 20.481 11.7002 19.9975 11.7002H17.9616C17.4781 11.7002 17.0859 12.0923 17.0859 12.5757V13.2848H10.7794C10.7202 12.9357 10.5537 12.6026 10.2851 12.3287C9.6029 11.6572 8.43719 11.6679 7.77107 12.334C7.43264 12.6724 7.25 13.1184 7.25 13.5911C7.25 14.0692 7.43802 14.5204 7.77107 14.8481C8.1095 15.1973 8.56074 15.3745 9.0281 15.3745C9.32351 15.3745 9.62435 15.3047 9.90905 15.1597C10.2153 15.0038 10.4677 14.746 10.6181 14.429C10.6558 14.3485 10.688 14.2679 10.7148 14.1873H15.0929C12.7132 15.3477 10.919 17.5287 10.2959 20.1609H9.59749C9.11404 20.1609 8.7219 20.553 8.7219 21.0365V23.0725C8.7219 23.5559 9.11404 23.9481 9.59749 23.9481H11.6335C12.117 23.9481 12.5091 23.5559 12.5091 23.0725V21.0365C12.5091 20.553 12.117 20.1609 11.6335 20.1609H11.2252C11.9773 17.3245 14.2496 15.1006 17.1021 14.413V14.6063C17.1021 15.0898 17.4942 15.482 17.9777 15.482H20.0136C20.4971 15.482 20.8892 15.0898 20.8892 14.6063V14.413C23.7363 15.1006 26.0087 17.3245 26.7661 20.1609H26.3954C25.912 20.1609 25.5199 20.553 25.5199 21.0365V23.0725C25.5199 23.5559 25.912 23.9481 26.3954 23.9481H28.4314C28.9149 23.9481 29.307 23.5559 29.307 23.0725V21.0365C29.307 20.553 28.9149 20.1609 28.4314 20.1609H27.6954C27.0669 17.5287 25.2727 15.3424 22.8983 14.1873H27.2872C27.3732 14.4344 27.5128 14.6601 27.7008 14.8481C28.0393 15.1973 28.4905 15.3745 28.9579 15.3745C29.2533 15.3745 29.5541 15.3047 29.8388 15.1597C30.145 15.0038 30.3975 14.746 30.5479 14.429C30.8971 13.6931 30.7735 12.8927 30.2202 12.3287C29.5166 11.6625 28.3508 11.6679 27.6793 12.334ZM9.7963 14.0476C9.73177 14.1766 9.62435 14.2894 9.49547 14.3539C9.0281 14.5903 8.6252 14.4399 8.40496 14.2089C8.23843 14.0476 8.14711 13.8275 8.14711 13.5911C8.14711 13.3601 8.23843 13.1398 8.40496 12.968C8.57148 12.8014 8.79173 12.7101 9.0281 12.7101C9.25908 12.7101 9.48474 12.8014 9.64588 12.9626C9.92518 13.2527 9.97889 13.6555 9.7963 14.0476ZM11.6227 23.0456L9.61362 23.0725L9.58676 21.0634H11.5959L11.6227 23.0456ZM28.4153 23.0456L26.4062 23.0725L26.3794 21.0634H28.3884L28.4153 23.0456ZM17.9938 14.6117L17.983 13.9349C17.9938 13.8865 17.9938 13.8382 17.9884 13.7845V13.7791C17.9884 13.7629 17.9992 13.7522 17.9992 13.7361C17.9992 13.7092 17.9884 13.6878 17.983 13.6662L17.967 12.608H19.976L19.9921 13.6662C19.9867 13.6931 19.976 13.7146 19.976 13.7415C19.976 13.7576 19.9814 13.7683 19.9867 13.7845V13.7898C19.976 13.8596 19.9814 13.9242 19.9975 13.9832L20.0083 14.5903L17.9938 14.6117ZM29.7099 14.0476C29.6454 14.1766 29.538 14.2894 29.409 14.3539C28.9418 14.5903 28.5388 14.4399 28.3186 14.2089C28.1521 14.0476 28.0607 13.8275 28.0607 13.5911C28.0607 13.3601 28.1521 13.1398 28.3186 12.968C28.4851 12.8014 28.7054 12.7101 28.9418 12.7101C29.1727 12.7101 29.3983 12.8014 29.5595 12.9626C29.8388 13.2527 29.8926 13.6555 29.7099 14.0476Z" fill="#F2A700"/>
                      </svg>
                    </div>
                    <div class="headarea">
                      <h6 class="mb-0">Full Stack Development (MERN/MEAN)</h6>
                    </div>
                  </div>
                </div>
                <div class="col-6 col-sm-6 col-lg-4">
                    <div class="d-flex align-items-center gap-1 gap-md-3 p-2 p-md-3 explorearea explore-5">
                      <div class="iconarea d-flex align-items-center justify-content-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="36" height="37" viewBox="0 0 36 37" fill="none">
                          <path d="M35.6908 26.737L32.0577 24.9205L29.7456 18.9061C29.7183 18.835 29.6768 18.7703 29.6234 18.7159C29.5701 18.6616 29.5061 18.6189 29.4355 18.5904L15.089 12.8556C14.9887 12.8158 14.8789 12.806 14.7731 12.8276C14.6674 12.8493 14.5702 12.9014 14.4936 12.9775L12.5802 14.8909C12.5051 14.9676 12.4538 15.0644 12.4327 15.1696C12.4116 15.2748 12.4215 15.3838 12.4612 15.4835L18.1959 29.83C18.2243 29.9006 18.2671 29.9646 18.3214 30.018C18.3757 30.0713 18.4404 30.1129 18.5115 30.1401L24.5259 32.4523L26.3425 36.0853C26.3807 36.1654 26.4376 36.2352 26.5085 36.2886C26.5793 36.3422 26.662 36.3778 26.7495 36.3927C26.779 36.3954 26.8086 36.3954 26.8381 36.3927C26.9847 36.3921 27.1251 36.3333 27.2285 36.2293L35.8348 27.6231C35.8981 27.5619 35.9459 27.4866 35.9744 27.4033C36.0028 27.3199 36.0109 27.2311 35.9981 27.144C35.9833 27.0565 35.9476 26.9738 35.8941 26.903C35.8406 26.8322 35.7709 26.7752 35.6908 26.737ZM13.6214 15.4116L13.9288 15.1069L21.0702 22.2484C20.5995 22.9153 20.3963 23.7344 20.5005 24.544C20.6048 25.3536 21.0091 26.0946 21.6335 26.6203C22.2577 27.1461 23.0567 27.4186 23.8722 27.3838C24.6877 27.3488 25.4604 27.0093 26.0376 26.4321C26.6147 25.855 26.9544 25.0822 26.9892 24.2667C27.0241 23.4512 26.7517 22.6523 26.2258 22.028C25.7 21.4036 24.959 20.9994 24.1495 20.8951C23.3399 20.7907 22.5207 20.9941 21.8538 21.4647L14.7124 14.3233L15.017 14.0159L28.7986 19.5291L30.9723 25.1835L24.789 31.3668L19.1345 29.1931L13.6214 15.4116ZM23.7312 21.9742C24.2289 21.9749 24.711 22.1482 25.0953 22.4645C25.4797 22.7808 25.7424 23.2206 25.8388 23.7089C25.9353 24.1972 25.8594 24.7038 25.6241 25.1425C25.389 25.5812 25.0089 25.9246 24.5489 26.1146C24.0888 26.3044 23.5771 26.329 23.1009 26.1839C22.6249 26.0388 22.2137 25.7332 21.9377 25.319C21.6617 24.9049 21.5377 24.4078 21.587 23.9125C21.6364 23.4172 21.8559 22.9543 22.2083 22.6027C22.6125 22.1997 23.1603 21.9737 23.7312 21.9742ZM26.9904 34.9029L25.6059 32.1339L31.7338 26.0059L34.5028 27.3904L26.9904 34.9029Z" fill="#4500D0"/>
                          <path d="M11.1448 30.5779C11.0388 30.4778 10.8986 30.422 10.7529 30.422C10.6072 30.422 10.4671 30.4778 10.3611 30.5779L9.6578 31.2813C7.78084 28.7339 6.74541 25.6644 6.69577 22.5006C6.64614 19.3368 7.58478 16.2363 9.38086 13.6313C9.91893 13.9274 10.5386 14.0412 11.1467 13.9554C11.7549 13.8698 12.319 13.5894 12.7544 13.1561C13.1898 12.7229 13.4731 12.1603 13.5618 11.5526C13.6505 10.9448 13.5398 10.3246 13.2464 9.78508C15.8514 7.98899 18.9519 7.05036 22.1157 7.09999C25.2795 7.14963 28.349 8.18506 30.8964 10.062L30.182 10.757C30.079 10.8609 30.0213 11.0012 30.0214 11.1474C30.0209 11.2203 30.035 11.2926 30.0625 11.3601C30.0901 11.4275 30.1307 11.4889 30.182 11.5406L32.6243 13.9636C32.7281 14.0668 32.8685 14.1246 33.0147 14.1246C33.1611 14.1246 33.3014 14.0668 33.4052 13.9636L35.8336 11.5351C35.8851 11.4837 35.926 11.4226 35.9538 11.3554C35.9817 11.2881 35.9961 11.216 35.9961 11.1433C35.9961 11.0705 35.9817 10.9984 35.9538 10.9313C35.926 10.864 35.8851 10.8029 35.8336 10.7515L33.4052 8.32301C33.3014 8.21987 33.1611 8.16197 33.0147 8.16197C32.8685 8.16197 32.7281 8.21987 32.6243 8.32301L31.6856 9.25619C29.372 7.51527 26.6369 6.4215 23.7608 6.08718C20.8848 5.75286 17.9716 6.19005 15.3205 7.35385L18.5132 4.16943C18.8752 4.34241 19.2868 4.38157 19.675 4.27995C20.0631 4.17833 20.4027 3.94253 20.6335 3.61435C20.8643 3.28617 20.9713 2.88685 20.9357 2.48721C20.9002 2.08759 20.7241 1.71349 20.4389 1.43129C20.1538 1.14909 19.7779 0.977027 19.3778 0.945636C18.9778 0.914244 18.5797 1.02555 18.2539 1.2598C17.9282 1.49406 17.696 1.83612 17.5985 2.2253C17.501 2.61448 17.5445 3.02563 17.7212 3.38579L12.3327 8.78268C11.7855 8.41567 11.128 8.25 10.4723 8.31399C9.81655 8.37797 9.20343 8.66763 8.73757 9.13348C8.27172 9.59933 7.98206 10.2125 7.91809 10.8681C7.8541 11.5239 8.01976 12.1815 8.38677 12.7286L2.98989 18.1172C2.62831 17.941 2.21597 17.8987 1.82616 17.9978C1.43635 18.0969 1.09429 18.331 0.860785 18.6585C0.627275 18.986 0.517433 19.3857 0.550777 19.7865C0.58412 20.1874 0.75849 20.5634 1.0429 20.8478C1.32731 21.1322 1.70335 21.3066 2.10418 21.3399C2.50501 21.3732 2.90469 21.2634 3.23218 21.0299C3.55968 20.7964 3.79378 20.4543 3.89289 20.0645C3.99201 19.6747 3.94971 19.2624 3.77353 18.9008L6.96625 15.7164C5.80128 18.3669 5.36272 21.2796 5.69557 24.1556C6.02843 27.0316 7.12071 29.7672 8.86028 32.0815L7.92434 33.0202C7.82119 33.1239 7.76329 33.2643 7.76329 33.4107C7.76329 33.5569 7.82119 33.6973 7.92434 33.8011L10.3528 36.2296C10.4562 36.3335 10.5966 36.3923 10.7432 36.3929C10.8163 36.3929 10.8887 36.3786 10.9562 36.3506C11.0237 36.3225 11.0849 36.2813 11.1364 36.2296L13.5676 33.8011C13.6708 33.6973 13.7287 33.5569 13.7287 33.4107C13.7287 33.2643 13.6708 33.1239 13.5676 33.0202L11.1448 30.5779ZM33.0203 9.49156L34.6651 11.1364L33.0203 12.7812L31.3755 11.1364L33.0203 9.49156ZM18.8288 2.2311C18.9112 2.14813 19.0163 2.09148 19.1308 2.06833C19.2453 2.04518 19.3642 2.05658 19.4722 2.10109C19.5803 2.14558 19.6727 2.22118 19.7377 2.31827C19.8027 2.41537 19.8374 2.5296 19.8374 2.64645C19.8374 2.76331 19.8027 2.87753 19.7377 2.97463C19.6727 3.07173 19.5803 3.14732 19.4722 3.19182C19.3642 3.23632 19.2453 3.24772 19.1308 3.22457C19.0163 3.20143 18.9112 3.14478 18.8288 3.06181C18.7743 3.00729 18.731 2.94255 18.7015 2.87128C18.6719 2.8 18.6567 2.72361 18.6567 2.64645C18.6567 2.5693 18.6719 2.4929 18.7015 2.42163C18.731 2.35036 18.7743 2.28562 18.8288 2.2311ZM9.52485 9.9208C9.68564 9.75917 9.87683 9.63095 10.0873 9.54346C10.2978 9.45597 10.5236 9.41093 10.7516 9.41093C10.9795 9.41093 11.2052 9.45597 11.4157 9.54346C11.6262 9.63095 11.8174 9.75917 11.9782 9.9208C12.2213 10.1635 12.3869 10.4728 12.4542 10.8096C12.5214 11.1466 12.4872 11.4958 12.3558 11.8132C12.2245 12.1306 12.002 12.4019 11.7164 12.5928C11.4308 12.7838 11.095 12.8856 10.7516 12.8856C10.408 12.8856 10.0723 12.7838 9.78668 12.5928C9.5011 12.4019 9.27856 12.1306 9.14724 11.8132C9.01592 11.4958 8.9817 11.1466 9.04891 10.8096C9.11613 10.4728 9.28176 10.1635 9.52485 9.9208ZM2.66868 20.0555C2.55561 20.1498 2.41137 20.1984 2.26431 20.1917C2.11723 20.1851 1.97797 20.1236 1.87387 20.0196C1.76977 19.9155 1.70836 19.7762 1.70172 19.6291C1.69508 19.4821 1.74367 19.3379 1.83796 19.2248C1.94878 19.1158 2.09794 19.0549 2.25332 19.0549C2.4087 19.0549 2.55785 19.1158 2.66868 19.2248C2.72326 19.2793 2.76657 19.3441 2.79612 19.4153C2.82566 19.4866 2.84087 19.563 2.84087 19.6401C2.84087 19.7173 2.82566 19.7936 2.79612 19.865C2.76657 19.9363 2.72326 20.001 2.66868 20.0555ZM10.7516 35.0444L9.10672 33.3996L10.7516 31.7548L12.3964 33.3996L10.7516 35.0444Z" fill="#4500D0"/>
                        </svg>
                      </div>
                      <div class="headarea">
                        <h6 class="mb-0">Java Development</h6>
                      </div>
                    </div>
                </div>
                <div class="col-6 col-sm-6 col-lg-4">
                    <div class="d-flex align-items-center gap-1 gap-md-3 p-2 p-md-3 explorearea explore-6">
                      <div class="iconarea d-flex align-items-center justify-content-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="37" height="37" viewBox="0 0 37 37" fill="none">
                          <path d="M10.1208 23.254C10.4519 23.063 10.5653 22.6392 10.3743 22.308C10.1831 21.9773 9.75946 21.8636 9.42836 22.0546C9.09728 22.2458 8.98366 22.6697 9.17491 23.0006C9.36588 23.3316 9.78978 23.4452 10.1208 23.254Z" fill="#BB0064"/>
                          <path d="M7.28336 28.0337L10.7706 34.0742C11.5231 35.379 13.2159 35.8622 14.5546 35.0883C15.8792 34.3228 16.3345 32.6302 15.5681 31.3046L13.4907 27.7059L15.2898 26.6671C15.6209 26.4757 15.7345 26.0524 15.5432 25.7212L14.6428 24.1616C14.7501 24.1407 15.4562 24.0022 27.9063 21.5599C29.4454 21.4763 30.3676 19.793 29.5901 18.4473L27.2888 14.4613L28.7594 12.2337C28.9039 12.0147 28.9125 11.7331 28.7813 11.5058L27.3964 9.10706C27.2652 8.87985 27.0161 8.74676 26.755 8.76218L24.091 8.92204L21.5361 4.49672C21.1661 3.85564 20.5031 3.46747 19.763 3.45828C19.7541 3.45801 19.7454 3.45801 19.7365 3.45801C19.0213 3.45801 18.3721 3.81398 17.9875 4.41584L8.9415 15.9396L3.06063 19.3348C0.747611 20.6697 -0.0536001 23.637 1.28644 25.9563C2.51071 28.077 5.09179 28.9112 7.28336 28.0337ZM14.369 31.9973C14.7515 32.659 14.5251 33.5056 13.8615 33.8889C13.1959 34.2738 12.3482 34.0374 11.9699 33.382L8.50762 27.3842L10.9064 25.9993C14.9136 32.9408 14.3046 31.8861 14.369 31.9973ZM12.7982 26.5062L12.1057 25.3068L13.3052 24.6143L13.9976 25.8138L12.7982 26.5062ZM26.411 10.1701L27.368 11.8277L26.5145 13.1201L24.8651 10.2629L26.411 10.1701ZM19.1457 5.17512C19.3315 4.87108 19.6264 4.83971 19.7459 4.84295C19.8642 4.84431 20.1587 4.88109 20.3364 5.18892L28.3907 19.1398C28.6532 19.594 28.3343 20.165 27.8081 20.178C27.7137 20.1801 27.6702 20.1971 27.4283 20.2423L18.9085 5.48538C19.0873 5.25546 19.1103 5.23328 19.1457 5.17512ZM17.9869 6.65934L25.9917 20.5242L13.9108 22.8937L10.2375 16.5314L17.9869 6.65934ZM2.48582 25.2639C2.18178 24.7377 2.02111 24.1405 2.02111 23.5362C2.02111 22.3011 2.68491 21.151 3.7531 20.5342L9.15032 17.418L12.6126 23.415L7.21546 26.5314C5.56191 27.4857 3.4404 26.9171 2.48582 25.2639Z" fill="#BB0064"/>
                          <path d="M7.97529 23.6935C7.78405 23.3624 7.36045 23.2488 7.02936 23.4401L5.82998 24.1325C5.49943 24.3235 5.07503 24.2096 4.88405 23.8791C4.69281 23.5479 4.26921 23.4344 3.93812 23.6256C3.60704 23.8169 3.49343 24.2405 3.68467 24.5715C4.25461 25.5588 5.52595 25.907 6.52245 25.3319L7.72183 24.6394C8.05292 24.4482 8.16653 24.0249 7.97529 23.6935Z" fill="#BB0064"/>
                          <path d="M35.0621 4.93917L31.2035 7.08637C30.8695 7.27247 30.7491 7.69418 30.9352 8.02824C31.1207 8.36204 31.5422 8.48294 31.8771 8.29658L35.7354 6.14937C36.0698 5.96327 36.1899 5.54156 36.0037 5.2075C35.8179 4.87317 35.3962 4.75306 35.0621 4.93917Z" fill="#BB0064"/>
                          <path d="M34.6569 12.1107L31.9814 11.3939C31.612 11.2949 31.2321 11.514 31.1331 11.8835C31.0341 12.2531 31.2535 12.6325 31.623 12.7315L34.2988 13.4483C34.6704 13.5481 35.0483 13.3256 35.1468 12.9588C35.2458 12.5893 35.0264 12.2094 34.6569 12.1107Z" fill="#BB0064"/>
                          <path d="M27.9347 2.42329L27.2171 5.09905C27.1181 5.46855 27.3372 5.84805 27.7067 5.94733C28.0759 6.04606 28.4557 5.8275 28.555 5.45773L29.2724 2.78197C29.3714 2.41247 29.1523 2.0327 28.7827 1.93369C28.4136 1.8347 28.0338 2.0538 27.9347 2.42329Z" fill="#BB0064"/>
                        </svg>
                      </div>
                      <div class="headarea">
                        <h6 class="mb-0">Cloud & DevOps (AWS, Azure, GCP)</h6>
                      </div>
                    </div>
                </div>
                <div class="col-6 col-sm-6 col-lg-4">
                  <div class="d-flex align-items-center gap-1 gap-md-3 p-2 p-md-3 explorearea explore-7">
                    <div class="iconarea d-flex align-items-center justify-content-center">
                      <svg xmlns="http://www.w3.org/2000/svg" width="35" height="37" viewBox="0 0 35 37" fill="none">
                        <path d="M30.6539 6.33925C31.3577 6.33925 31.9271 5.76983 31.9271 5.06612C31.9271 4.3624 31.3577 3.79297 30.6539 3.79297C29.9503 3.79297 29.3809 4.3624 29.3809 5.06612C29.3809 5.76983 29.9557 6.33925 30.6539 6.33925ZM30.6539 4.70082C30.8581 4.70082 31.0246 4.86735 31.0246 5.07149C31.0246 5.27562 30.8581 5.44215 30.6539 5.44215C30.4445 5.44215 30.2834 5.28099 30.2834 5.07149C30.2834 4.86198 30.4498 4.70082 30.6539 4.70082Z" fill="#F2A700"/>
                        <path d="M32.0683 1.73535H5.89632C4.90252 1.73535 4.09136 2.5465 4.09136 3.54031V6.2961H2.29715C1.30334 6.2961 0.492188 7.10725 0.492188 8.10105V30.7328C0.492188 31.7266 1.30334 32.5378 2.29715 32.5378H14.2926V35.1485C14.2926 35.3957 14.4967 35.5998 14.7438 35.5998H23.2207C23.4678 35.5998 23.6719 35.3957 23.6719 35.1485V32.5378H28.4691C29.4629 32.5378 30.274 31.7266 30.274 30.7328V27.9771H32.0683C33.062 27.9771 33.8732 27.1659 33.8732 26.1722V3.54031C33.8732 2.5465 33.062 1.73535 32.0683 1.73535ZM4.99384 3.54031C4.99384 3.04072 5.40211 2.63783 5.89632 2.63783H32.0683C32.5678 2.63783 32.9707 3.04609 32.9707 3.54031V7.4994H15.8451L13.8306 5.40973C13.6748 5.24857 13.4599 5.15725 13.2397 5.15725H8.80252C8.35128 5.15725 7.98062 5.52791 7.98062 5.97915V7.4994H4.99384V3.54031ZM2.29715 31.6408C1.79756 31.6408 1.39466 31.2325 1.39466 30.7383V8.10105C1.39466 7.60146 1.80293 7.19858 2.29715 7.19858H4.09136V26.1775C4.09136 27.1713 4.90252 27.9825 5.89632 27.9825H15.6946C15.8719 28.3263 15.9525 28.713 15.9203 29.1105H15.2219C14.7063 29.1105 14.2926 29.5295 14.2926 30.0399V31.6408H2.29715ZM18.5364 22.1916C18.6277 22.0304 18.7942 21.9283 18.9822 21.9283C19.2616 21.9283 19.4872 22.1539 19.4872 22.4333C19.4872 22.6159 19.3905 22.7824 19.2348 22.8738C19.0628 22.9758 18.8587 22.9651 18.6492 22.847C18.6224 22.8308 18.5955 22.8093 18.5847 22.7824C18.4128 22.5085 18.4827 22.2936 18.5364 22.1916ZM18.531 21.1118C18.2033 21.2247 17.924 21.4448 17.7522 21.7565C17.4942 22.2184 17.5265 22.7824 17.8273 23.2659C17.924 23.4164 18.0529 23.5399 18.2087 23.6312C18.4558 23.7709 18.7244 23.8461 18.9877 23.8461C19.2348 23.8461 19.4765 23.7816 19.6913 23.6581C20.1211 23.4056 20.3897 22.9383 20.3897 22.4386C20.3897 21.8209 19.9869 21.2998 19.4335 21.1118V18.7911L23.4248 25.9949C23.4195 26.0002 23.4141 26.011 23.3979 26.0163C21.9852 26.3816 21.0612 27.7031 21.1364 29.1105H16.8335C16.9141 27.6978 15.9847 26.3763 14.5451 25.9733L18.531 18.7911V21.1118ZM22.7695 34.6974H15.1951L15.2219 30.0076H22.7426C22.7587 30.0076 22.7695 30.0184 22.7695 30.0345V34.6974ZM29.3715 30.7328C29.3715 31.2325 28.9632 31.6353 28.4691 31.6353H23.6719V30.0345C23.6719 29.5188 23.2529 29.1052 22.7426 29.1052H22.0443C22.012 28.7077 22.098 28.3209 22.2699 27.9771H29.3715V30.7328ZM32.0683 27.08H23.1455C23.2905 26.9994 23.4463 26.9296 23.6182 26.8866C23.9029 26.8114 24.1339 26.6126 24.2521 26.344C24.365 26.0808 24.3488 25.7853 24.2091 25.5329L19.5893 17.2118C19.4711 16.9916 19.2401 16.8519 18.9877 16.8519C18.7298 16.8573 18.4988 16.9861 18.3753 17.2064L13.75 25.5329C13.6104 25.7853 13.5996 26.0862 13.7125 26.3494C13.8252 26.618 14.0563 26.8114 14.341 26.8866C14.5128 26.9296 14.6633 26.9994 14.8137 27.08H5.89632C5.39674 27.08 4.99384 26.6717 4.99384 26.1775V8.40188H8.05583C8.50707 8.40188 8.87773 8.03122 8.87773 7.57998V6.05973H13.2021L15.2165 8.1494C15.3724 8.31056 15.5872 8.40188 15.8075 8.40188H32.9707V26.1722C32.9707 26.6717 32.5678 27.08 32.0683 27.08Z" fill="#F2A700"/>
                        <path d="M27.5817 6.33925C28.2855 6.33925 28.8549 5.76983 28.8549 5.06612C28.8549 4.3624 28.2855 3.79297 27.5817 3.79297C26.878 3.79297 26.3086 4.3624 26.3086 5.06612C26.3086 5.76983 26.878 6.33925 27.5817 6.33925ZM27.5817 4.70082C27.7858 4.70082 27.9524 4.86735 27.9524 5.07149C27.9524 5.27562 27.7858 5.44215 27.5817 5.44215C27.3722 5.44215 27.211 5.28099 27.211 5.07149C27.211 4.86198 27.3775 4.70082 27.5817 4.70082Z" fill="#F2A700"/>
                        <path d="M24.5036 6.33925C25.2073 6.33925 25.7767 5.76983 25.7767 5.06612C25.7767 4.3624 25.2073 3.79297 24.5036 3.79297C23.7999 3.79297 23.2305 4.3624 23.2305 5.06612C23.2305 5.76983 23.7999 6.33925 24.5036 6.33925ZM24.5036 4.70082C24.7078 4.70082 24.8743 4.86735 24.8743 5.07149C24.8743 5.27562 24.7078 5.44215 24.5036 5.44215C24.2941 5.44215 24.133 5.28099 24.133 5.07149C24.133 4.86198 24.2995 4.70082 24.5036 4.70082Z" fill="#F2A700"/>
                        <path d="M27.6793 12.334C27.4161 12.5973 27.2496 12.9303 27.1852 13.2848H20.8731V12.5757C20.8731 12.0923 20.481 11.7002 19.9975 11.7002H17.9616C17.4781 11.7002 17.0859 12.0923 17.0859 12.5757V13.2848H10.7794C10.7202 12.9357 10.5537 12.6026 10.2851 12.3287C9.6029 11.6572 8.43719 11.6679 7.77107 12.334C7.43264 12.6724 7.25 13.1184 7.25 13.5911C7.25 14.0692 7.43802 14.5204 7.77107 14.8481C8.1095 15.1973 8.56074 15.3745 9.0281 15.3745C9.32351 15.3745 9.62435 15.3047 9.90905 15.1597C10.2153 15.0038 10.4677 14.746 10.6181 14.429C10.6558 14.3485 10.688 14.2679 10.7148 14.1873H15.0929C12.7132 15.3477 10.919 17.5287 10.2959 20.1609H9.59749C9.11404 20.1609 8.7219 20.553 8.7219 21.0365V23.0725C8.7219 23.5559 9.11404 23.9481 9.59749 23.9481H11.6335C12.117 23.9481 12.5091 23.5559 12.5091 23.0725V21.0365C12.5091 20.553 12.117 20.1609 11.6335 20.1609H11.2252C11.9773 17.3245 14.2496 15.1006 17.1021 14.413V14.6063C17.1021 15.0898 17.4942 15.482 17.9777 15.482H20.0136C20.4971 15.482 20.8892 15.0898 20.8892 14.6063V14.413C23.7363 15.1006 26.0087 17.3245 26.7661 20.1609H26.3954C25.912 20.1609 25.5199 20.553 25.5199 21.0365V23.0725C25.5199 23.5559 25.912 23.9481 26.3954 23.9481H28.4314C28.9149 23.9481 29.307 23.5559 29.307 23.0725V21.0365C29.307 20.553 28.9149 20.1609 28.4314 20.1609H27.6954C27.0669 17.5287 25.2727 15.3424 22.8983 14.1873H27.2872C27.3732 14.4344 27.5128 14.6601 27.7008 14.8481C28.0393 15.1973 28.4905 15.3745 28.9579 15.3745C29.2533 15.3745 29.5541 15.3047 29.8388 15.1597C30.145 15.0038 30.3975 14.746 30.5479 14.429C30.8971 13.6931 30.7735 12.8927 30.2202 12.3287C29.5166 11.6625 28.3508 11.6679 27.6793 12.334ZM9.7963 14.0476C9.73177 14.1766 9.62435 14.2894 9.49547 14.3539C9.0281 14.5903 8.6252 14.4399 8.40496 14.2089C8.23843 14.0476 8.14711 13.8275 8.14711 13.5911C8.14711 13.3601 8.23843 13.1398 8.40496 12.968C8.57148 12.8014 8.79173 12.7101 9.0281 12.7101C9.25908 12.7101 9.48474 12.8014 9.64588 12.9626C9.92518 13.2527 9.97889 13.6555 9.7963 14.0476ZM11.6227 23.0456L9.61362 23.0725L9.58676 21.0634H11.5959L11.6227 23.0456ZM28.4153 23.0456L26.4062 23.0725L26.3794 21.0634H28.3884L28.4153 23.0456ZM17.9938 14.6117L17.983 13.9349C17.9938 13.8865 17.9938 13.8382 17.9884 13.7845V13.7791C17.9884 13.7629 17.9992 13.7522 17.9992 13.7361C17.9992 13.7092 17.9884 13.6878 17.983 13.6662L17.967 12.608H19.976L19.9921 13.6662C19.9867 13.6931 19.976 13.7146 19.976 13.7415C19.976 13.7576 19.9814 13.7683 19.9867 13.7845V13.7898C19.976 13.8596 19.9814 13.9242 19.9975 13.9832L20.0083 14.5903L17.9938 14.6117ZM29.7099 14.0476C29.6454 14.1766 29.538 14.2894 29.409 14.3539C28.9418 14.5903 28.5388 14.4399 28.3186 14.2089C28.1521 14.0476 28.0607 13.8275 28.0607 13.5911C28.0607 13.3601 28.1521 13.1398 28.3186 12.968C28.4851 12.8014 28.7054 12.7101 28.9418 12.7101C29.1727 12.7101 29.3983 12.8014 29.5595 12.9626C29.8388 13.2527 29.8926 13.6555 29.7099 14.0476Z" fill="#F2A700"/>
                      </svg>
                    </div>
                    <div class="headarea">
                      <h6 class="mb-0">Python Programming</h6>
                    </div>
                  </div>
                </div>
                <div class="col-6 col-sm-6 col-lg-4">
                    <div class="d-flex align-items-center gap-1 gap-md-3 p-2 p-md-3 explorearea explore-8">
                      <div class="iconarea d-flex align-items-center justify-content-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="36" height="37" viewBox="0 0 36 37" fill="none">
                          <path d="M35.6908 26.737L32.0577 24.9205L29.7456 18.9061C29.7183 18.835 29.6768 18.7703 29.6234 18.7159C29.5701 18.6616 29.5061 18.6189 29.4355 18.5904L15.089 12.8556C14.9887 12.8158 14.8789 12.806 14.7731 12.8276C14.6674 12.8493 14.5702 12.9014 14.4936 12.9775L12.5802 14.8909C12.5051 14.9676 12.4538 15.0644 12.4327 15.1696C12.4116 15.2748 12.4215 15.3838 12.4612 15.4835L18.1959 29.83C18.2243 29.9006 18.2671 29.9646 18.3214 30.018C18.3757 30.0713 18.4404 30.1129 18.5115 30.1401L24.5259 32.4523L26.3425 36.0853C26.3807 36.1654 26.4376 36.2352 26.5085 36.2886C26.5793 36.3422 26.662 36.3778 26.7495 36.3927C26.779 36.3954 26.8086 36.3954 26.8381 36.3927C26.9847 36.3921 27.1251 36.3333 27.2285 36.2293L35.8348 27.6231C35.8981 27.5619 35.9459 27.4866 35.9744 27.4033C36.0028 27.3199 36.0109 27.2311 35.9981 27.144C35.9833 27.0565 35.9476 26.9738 35.8941 26.903C35.8406 26.8322 35.7709 26.7752 35.6908 26.737ZM13.6214 15.4116L13.9288 15.1069L21.0702 22.2484C20.5995 22.9153 20.3963 23.7344 20.5005 24.544C20.6048 25.3536 21.0091 26.0946 21.6335 26.6203C22.2577 27.1461 23.0567 27.4186 23.8722 27.3838C24.6877 27.3488 25.4604 27.0093 26.0376 26.4321C26.6147 25.855 26.9544 25.0822 26.9892 24.2667C27.0241 23.4512 26.7517 22.6523 26.2258 22.028C25.7 21.4036 24.959 20.9994 24.1495 20.8951C23.3399 20.7907 22.5207 20.9941 21.8538 21.4647L14.7124 14.3233L15.017 14.0159L28.7986 19.5291L30.9723 25.1835L24.789 31.3668L19.1345 29.1931L13.6214 15.4116ZM23.7312 21.9742C24.2289 21.9749 24.711 22.1482 25.0953 22.4645C25.4797 22.7808 25.7424 23.2206 25.8388 23.7089C25.9353 24.1972 25.8594 24.7038 25.6241 25.1425C25.389 25.5812 25.0089 25.9246 24.5489 26.1146C24.0888 26.3044 23.5771 26.329 23.1009 26.1839C22.6249 26.0388 22.2137 25.7332 21.9377 25.319C21.6617 24.9049 21.5377 24.4078 21.587 23.9125C21.6364 23.4172 21.8559 22.9543 22.2083 22.6027C22.6125 22.1997 23.1603 21.9737 23.7312 21.9742ZM26.9904 34.9029L25.6059 32.1339L31.7338 26.0059L34.5028 27.3904L26.9904 34.9029Z" fill="#4500D0"/>
                          <path d="M11.1448 30.5779C11.0388 30.4778 10.8986 30.422 10.7529 30.422C10.6072 30.422 10.4671 30.4778 10.3611 30.5779L9.6578 31.2813C7.78084 28.7339 6.74541 25.6644 6.69577 22.5006C6.64614 19.3368 7.58478 16.2363 9.38086 13.6313C9.91893 13.9274 10.5386 14.0412 11.1467 13.9554C11.7549 13.8698 12.319 13.5894 12.7544 13.1561C13.1898 12.7229 13.4731 12.1603 13.5618 11.5526C13.6505 10.9448 13.5398 10.3246 13.2464 9.78508C15.8514 7.98899 18.9519 7.05036 22.1157 7.09999C25.2795 7.14963 28.349 8.18506 30.8964 10.062L30.182 10.757C30.079 10.8609 30.0213 11.0012 30.0214 11.1474C30.0209 11.2203 30.035 11.2926 30.0625 11.3601C30.0901 11.4275 30.1307 11.4889 30.182 11.5406L32.6243 13.9636C32.7281 14.0668 32.8685 14.1246 33.0147 14.1246C33.1611 14.1246 33.3014 14.0668 33.4052 13.9636L35.8336 11.5351C35.8851 11.4837 35.926 11.4226 35.9538 11.3554C35.9817 11.2881 35.9961 11.216 35.9961 11.1433C35.9961 11.0705 35.9817 10.9984 35.9538 10.9313C35.926 10.864 35.8851 10.8029 35.8336 10.7515L33.4052 8.32301C33.3014 8.21987 33.1611 8.16197 33.0147 8.16197C32.8685 8.16197 32.7281 8.21987 32.6243 8.32301L31.6856 9.25619C29.372 7.51527 26.6369 6.4215 23.7608 6.08718C20.8848 5.75286 17.9716 6.19005 15.3205 7.35385L18.5132 4.16943C18.8752 4.34241 19.2868 4.38157 19.675 4.27995C20.0631 4.17833 20.4027 3.94253 20.6335 3.61435C20.8643 3.28617 20.9713 2.88685 20.9357 2.48721C20.9002 2.08759 20.7241 1.71349 20.4389 1.43129C20.1538 1.14909 19.7779 0.977027 19.3778 0.945636C18.9778 0.914244 18.5797 1.02555 18.2539 1.2598C17.9282 1.49406 17.696 1.83612 17.5985 2.2253C17.501 2.61448 17.5445 3.02563 17.7212 3.38579L12.3327 8.78268C11.7855 8.41567 11.128 8.25 10.4723 8.31399C9.81655 8.37797 9.20343 8.66763 8.73757 9.13348C8.27172 9.59933 7.98206 10.2125 7.91809 10.8681C7.8541 11.5239 8.01976 12.1815 8.38677 12.7286L2.98989 18.1172C2.62831 17.941 2.21597 17.8987 1.82616 17.9978C1.43635 18.0969 1.09429 18.331 0.860785 18.6585C0.627275 18.986 0.517433 19.3857 0.550777 19.7865C0.58412 20.1874 0.75849 20.5634 1.0429 20.8478C1.32731 21.1322 1.70335 21.3066 2.10418 21.3399C2.50501 21.3732 2.90469 21.2634 3.23218 21.0299C3.55968 20.7964 3.79378 20.4543 3.89289 20.0645C3.99201 19.6747 3.94971 19.2624 3.77353 18.9008L6.96625 15.7164C5.80128 18.3669 5.36272 21.2796 5.69557 24.1556C6.02843 27.0316 7.12071 29.7672 8.86028 32.0815L7.92434 33.0202C7.82119 33.1239 7.76329 33.2643 7.76329 33.4107C7.76329 33.5569 7.82119 33.6973 7.92434 33.8011L10.3528 36.2296C10.4562 36.3335 10.5966 36.3923 10.7432 36.3929C10.8163 36.3929 10.8887 36.3786 10.9562 36.3506C11.0237 36.3225 11.0849 36.2813 11.1364 36.2296L13.5676 33.8011C13.6708 33.6973 13.7287 33.5569 13.7287 33.4107C13.7287 33.2643 13.6708 33.1239 13.5676 33.0202L11.1448 30.5779ZM33.0203 9.49156L34.6651 11.1364L33.0203 12.7812L31.3755 11.1364L33.0203 9.49156ZM18.8288 2.2311C18.9112 2.14813 19.0163 2.09148 19.1308 2.06833C19.2453 2.04518 19.3642 2.05658 19.4722 2.10109C19.5803 2.14558 19.6727 2.22118 19.7377 2.31827C19.8027 2.41537 19.8374 2.5296 19.8374 2.64645C19.8374 2.76331 19.8027 2.87753 19.7377 2.97463C19.6727 3.07173 19.5803 3.14732 19.4722 3.19182C19.3642 3.23632 19.2453 3.24772 19.1308 3.22457C19.0163 3.20143 18.9112 3.14478 18.8288 3.06181C18.7743 3.00729 18.731 2.94255 18.7015 2.87128C18.6719 2.8 18.6567 2.72361 18.6567 2.64645C18.6567 2.5693 18.6719 2.4929 18.7015 2.42163C18.731 2.35036 18.7743 2.28562 18.8288 2.2311ZM9.52485 9.9208C9.68564 9.75917 9.87683 9.63095 10.0873 9.54346C10.2978 9.45597 10.5236 9.41093 10.7516 9.41093C10.9795 9.41093 11.2052 9.45597 11.4157 9.54346C11.6262 9.63095 11.8174 9.75917 11.9782 9.9208C12.2213 10.1635 12.3869 10.4728 12.4542 10.8096C12.5214 11.1466 12.4872 11.4958 12.3558 11.8132C12.2245 12.1306 12.002 12.4019 11.7164 12.5928C11.4308 12.7838 11.095 12.8856 10.7516 12.8856C10.408 12.8856 10.0723 12.7838 9.78668 12.5928C9.5011 12.4019 9.27856 12.1306 9.14724 11.8132C9.01592 11.4958 8.9817 11.1466 9.04891 10.8096C9.11613 10.4728 9.28176 10.1635 9.52485 9.9208ZM2.66868 20.0555C2.55561 20.1498 2.41137 20.1984 2.26431 20.1917C2.11723 20.1851 1.97797 20.1236 1.87387 20.0196C1.76977 19.9155 1.70836 19.7762 1.70172 19.6291C1.69508 19.4821 1.74367 19.3379 1.83796 19.2248C1.94878 19.1158 2.09794 19.0549 2.25332 19.0549C2.4087 19.0549 2.55785 19.1158 2.66868 19.2248C2.72326 19.2793 2.76657 19.3441 2.79612 19.4153C2.82566 19.4866 2.84087 19.563 2.84087 19.6401C2.84087 19.7173 2.82566 19.7936 2.79612 19.865C2.76657 19.9363 2.72326 20.001 2.66868 20.0555ZM10.7516 35.0444L9.10672 33.3996L10.7516 31.7548L12.3964 33.3996L10.7516 35.0444Z" fill="#4500D0"/>
                        </svg>
                      </div>
                      <div class="headarea">
                        <h6 class="mb-0">Red Hat Linux & Server Administration</h6>
                      </div>
                    </div>
                </div>
                <div class="col-6 col-sm-6 col-lg-4">
                    <div class="d-flex align-items-center gap-1 gap-md-3 p-2 p-md-3 explorearea explore-9">
                      <div class="iconarea d-flex align-items-center justify-content-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="37" height="37" viewBox="0 0 37 37" fill="none">
                          <path d="M10.1208 23.254C10.4519 23.063 10.5653 22.6392 10.3743 22.308C10.1831 21.9773 9.75946 21.8636 9.42836 22.0546C9.09728 22.2458 8.98366 22.6697 9.17491 23.0006C9.36588 23.3316 9.78978 23.4452 10.1208 23.254Z" fill="#BB0064"/>
                          <path d="M7.28336 28.0337L10.7706 34.0742C11.5231 35.379 13.2159 35.8622 14.5546 35.0883C15.8792 34.3228 16.3345 32.6302 15.5681 31.3046L13.4907 27.7059L15.2898 26.6671C15.6209 26.4757 15.7345 26.0524 15.5432 25.7212L14.6428 24.1616C14.7501 24.1407 15.4562 24.0022 27.9063 21.5599C29.4454 21.4763 30.3676 19.793 29.5901 18.4473L27.2888 14.4613L28.7594 12.2337C28.9039 12.0147 28.9125 11.7331 28.7813 11.5058L27.3964 9.10706C27.2652 8.87985 27.0161 8.74676 26.755 8.76218L24.091 8.92204L21.5361 4.49672C21.1661 3.85564 20.5031 3.46747 19.763 3.45828C19.7541 3.45801 19.7454 3.45801 19.7365 3.45801C19.0213 3.45801 18.3721 3.81398 17.9875 4.41584L8.9415 15.9396L3.06063 19.3348C0.747611 20.6697 -0.0536001 23.637 1.28644 25.9563C2.51071 28.077 5.09179 28.9112 7.28336 28.0337ZM14.369 31.9973C14.7515 32.659 14.5251 33.5056 13.8615 33.8889C13.1959 34.2738 12.3482 34.0374 11.9699 33.382L8.50762 27.3842L10.9064 25.9993C14.9136 32.9408 14.3046 31.8861 14.369 31.9973ZM12.7982 26.5062L12.1057 25.3068L13.3052 24.6143L13.9976 25.8138L12.7982 26.5062ZM26.411 10.1701L27.368 11.8277L26.5145 13.1201L24.8651 10.2629L26.411 10.1701ZM19.1457 5.17512C19.3315 4.87108 19.6264 4.83971 19.7459 4.84295C19.8642 4.84431 20.1587 4.88109 20.3364 5.18892L28.3907 19.1398C28.6532 19.594 28.3343 20.165 27.8081 20.178C27.7137 20.1801 27.6702 20.1971 27.4283 20.2423L18.9085 5.48538C19.0873 5.25546 19.1103 5.23328 19.1457 5.17512ZM17.9869 6.65934L25.9917 20.5242L13.9108 22.8937L10.2375 16.5314L17.9869 6.65934ZM2.48582 25.2639C2.18178 24.7377 2.02111 24.1405 2.02111 23.5362C2.02111 22.3011 2.68491 21.151 3.7531 20.5342L9.15032 17.418L12.6126 23.415L7.21546 26.5314C5.56191 27.4857 3.4404 26.9171 2.48582 25.2639Z" fill="#BB0064"/>
                          <path d="M7.97529 23.6935C7.78405 23.3624 7.36045 23.2488 7.02936 23.4401L5.82998 24.1325C5.49943 24.3235 5.07503 24.2096 4.88405 23.8791C4.69281 23.5479 4.26921 23.4344 3.93812 23.6256C3.60704 23.8169 3.49343 24.2405 3.68467 24.5715C4.25461 25.5588 5.52595 25.907 6.52245 25.3319L7.72183 24.6394C8.05292 24.4482 8.16653 24.0249 7.97529 23.6935Z" fill="#BB0064"/>
                          <path d="M35.0621 4.93917L31.2035 7.08637C30.8695 7.27247 30.7491 7.69418 30.9352 8.02824C31.1207 8.36204 31.5422 8.48294 31.8771 8.29658L35.7354 6.14937C36.0698 5.96327 36.1899 5.54156 36.0037 5.2075C35.8179 4.87317 35.3962 4.75306 35.0621 4.93917Z" fill="#BB0064"/>
                          <path d="M34.6569 12.1107L31.9814 11.3939C31.612 11.2949 31.2321 11.514 31.1331 11.8835C31.0341 12.2531 31.2535 12.6325 31.623 12.7315L34.2988 13.4483C34.6704 13.5481 35.0483 13.3256 35.1468 12.9588C35.2458 12.5893 35.0264 12.2094 34.6569 12.1107Z" fill="#BB0064"/>
                          <path d="M27.9347 2.42329L27.2171 5.09905C27.1181 5.46855 27.3372 5.84805 27.7067 5.94733C28.0759 6.04606 28.4557 5.8275 28.555 5.45773L29.2724 2.78197C29.3714 2.41247 29.1523 2.0327 28.7827 1.93369C28.4136 1.8347 28.0338 2.0538 27.9347 2.42329Z" fill="#BB0064"/>
                        </svg>
                      </div>
                      <div class="headarea">
                        <h6 class="mb-0">Data Analytics & Visualization</h6>
                      </div>
                    </div>
                </div>
                <div class="col-12 col-sm-12 text-center pt-md-4">
                  <button type="button" class="btn btn-primary">Browse All Courses</button>
                </div>
              </div>
              <div class="row g-3">
                  <div class="col-12 col-sm-12 col-lg-12 text-center pt-4">
                    <h5 class="fw-semibold mobilefont">Why Attend?</h5>
                  </div>
                  <div class="col-12 col-lg-4">
                      <div class="border brd-dark careerarea1 bg-white p-2 p-lg-4 rounded-2 theme-box-shadow gap-3 align-items-center">
                        <div class="careerarea-text">
                          <h6 class="fw-normal mb-0">Interactive sessions with Q&A, live demos, and hands-on exercises</h6>
                        </div>
                      </div>
                  </div>
                  <div class="col-12 col-lg-4">
                      <div class="border brd-dark careerarea1 bg-white p-2 p-lg-4 rounded-2 theme-box-shadow gap-3 align-items-center">
                        <div class="careerarea-text">
                          <h6 class="fw-normal mb-0">Flexible scheduling to suit different learning preferences</h6>
                        </div>
                      </div>
                  </div>
                  <div class="col-12 col-lg-4">
                      <div class=" border brd-dark careerarea1 bg-white p-2 p-lg-4 rounded-2 theme-box-shadow gap-3 align-items-center">
                        <div class="careerarea-text">
                          <h6 class="fw-normal mb-0">Curated topics based on student interests and market demand</h6>
                        </div>
                      </div>
                  </div>
              </div>
            </div>
          </div>

          <!-- Career Section -->
          <div class="career-section bg-theme-light collaborate-section wow fadeInUp section-padding py-5">
            <div class="container">
              <div class="row">
                <div class="col-lg-12">
                  <div class="heading-area mb-4">
                    <h2 class="fw-semibold mb-3">Develop the Human Side of Tech</h2>
                    <p>Great tech skills mean little without the soft skills to lead, communicate, and adapt. That’s why we regularly conduct soft skill workshops to prepare our students for real-world work environments and career growth.</p>
                  </div>
                </div>
              </div>
                <div class="row">
                  <div class="col-12 col-md-6 col-lg-4 mb-3 mb-lg-4">
                      <div class="border brd-dark careerarea1 bg-white p-2 p-md-3 d-flex rounded-2 theme-box-shadow gap-3 align-items-center">
                        <div class="careerarea-icon">
                          <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/more4.png" class="img-fluid" />
                        </div>
                        <div class="careerarea-text">
                          <h6 class="fw-normal">Communication & Public Speaking</h6>
                        </div>
                      </div>
                  </div>
                  <div class="col-12 col-md-6 col-lg-4 mb-3 mb-lg-4">
                      <div class="border brd-dark careerarea1 bg-white p-2 p-md-3 d-flex rounded-2 theme-box-shadow gap-3 align-items-center">
                        <div class="careerarea-icon">
                          <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/more5.png" class="img-fluid" />
                        </div>
                        <div class="careerarea-text">
                          <h6 class="fw-normal">Leadership & Teamwork</h6>
                        </div>
                      </div>
                  </div>
                  <div class="col-12 col-md-6 col-lg-4 mb-3 mb-lg-4">
                      <div class="border brd-dark careerarea1 bg-white p-2 p-md-3 d-flex rounded-2 theme-box-shadow gap-3 align-items-center">
                        <div class="careerarea-icon">
                          <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/more6.png" class="img-fluid" />
                        </div>
                        <div class="careerarea-text">
                          <h6 class="fw-normal">Time Management & Productivity</h6>
                        </div>
                      </div>
                  </div>
                  <div class="col-12 col-md-6 col-lg-4 mb-3 mb-lg-4">
                      <div class="border brd-dark careerarea1 bg-white p-2 p-md-3 d-flex rounded-2 theme-box-shadow gap-3 align-items-center">
                        <div class="careerarea-icon">
                          <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/more1.png" class="img-fluid" />
                        </div>
                        <div class="careerarea-text">
                          <h6 class="fw-normal">Problem-Solving & Critical Thinking</h6>
                        </div>
                      </div>
                  </div>
                  <div class="col-12 col-md-6 col-lg-4 mb-3 mb-lg-4">
                      <div class="border brd-dark careerarea1 bg-white p-2 p-md-3 d-flex rounded-2 theme-box-shadow gap-3 align-items-center">
                        <div class="careerarea-icon">
                          <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/more2.png" class="img-fluid" />
                        </div>
                        <div class="careerarea-text">
                          <h6 class="fw-normal">Emotional Intelligence & Workplace Etiquette</h6>
                        </div>
                      </div>
                  </div>
                  <div class="col-12 col-md-12 col-lg-12">
                    <p>These sessions empower our learners to not only succeed in interviews but to thrive in their professional journeys.</p>
                  </div>
                </div>
            </div>
          </div>
          <!-- End Career Section -->

          <!-- Industry Section -->
          <div class="industry-section wow fadeInUp section-padding pb-0">
            <div class="container">
              <div class="row justify-content-center">
                <div class="col-12 col-lg-8 mb-3 mb-lg-0">
                    <div class="content-area">
                      <h2 class="mb-2 mb-lg-3">Learn from the Best in the Business</h2>
                      <p>We regularly invite top-tier industry professionals and domain experts to conduct exclusive sessions for our students. These guest speakers bring valuable insights, career advice, and knowledge of cutting-edge industry practices.</p>
                      <div class="row g-2">
                        <div class="col-6 col-sm-6 col-lg-3">
                            <div class="border careerarea1 bg-white p-2 rounded-2 theme-box-shadow gap-3 align-items-center">
                              <div class="careerarea-text">
                                <p class="fw-normal mb-0 f14">Expert Talks from professionals at leading companies</p>
                              </div>
                            </div>
                        </div>
                        <div class="col-6 col-sm-6 col-lg-3">
                            <div class="border careerarea1 bg-white p-2 rounded-2 theme-box-shadow gap-3 align-items-center">
                              <div class="careerarea-text">
                                <p class="fw-normal mb-0 f14">Exposure to current industry trends and technologies</p>
                              </div>
                            </div>
                        </div>
                        <div class="col-6 col-sm-6 col-lg-3">
                            <div class="border careerarea1 bg-white p-2 rounded-2 theme-box-shadow gap-3 align-items-center">
                              <div class="careerarea-text">
                                <p class="fw-normal mb-0 f14">Networking opportunities and real-world case studies</p>
                              </div>
                            </div>
                        </div>
                        <div class="col-6 col-sm-6 col-lg-3">
                            <div class="border careerarea1 bg-white p-2 rounded-2 theme-box-shadow gap-3 align-items-center">
                              <div class="careerarea-text">
                                <p class="fw-normal mb-0 f14">Learn what recruiters and CTOs actually look for</p>
                              </div>
                            </div>
                        </div>
                        <div class="col-12 mt-4">
                          <button type="button" class="btn btn-primary d-none d-lg-block">See Upcoming Masterclasses</button>
                        </div>
                      </div>
                    </div>
                </div>
                <div class="col-12 col-lg-4">
                  <div class="img-area">
                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/card.png" class="img-fluid" />
                  </div>
                  <button type="button" class="mobbtn-100 btn btn-primary mt-3 d-lg-none">See Upcoming Masterclasses</button>
                </div>
              </div>
            </div>
          </div>
          <!-- End Industry Section -->

          <!-- FAQ Section -->
          <?php
            include('components/faq.php'); 
          ?>
          <!-- End FAQ Section -->

        </div>
        <!-- <div id="eventssection" class="contentarea">
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
                    <form class="Exam-form d-flex">
                      <input type="text" class="form-control" value="Find courses & exams" />
                      <button type="button" class="btn btn-dark btn-sm py-1 px-3 rounded-1 fw-normal ms-2">Search</button>
                    </form>
                </div>
              </div>
              <div class="bglight p-2 rounded-2 mt-4 mt-md-0">
                <div class="row gx-2">
                  <div class="col-12 col-md-3">
                    <ul class="nav left-tab mt-0 tab-big" id="myTab" role="tablist">
                      <li class="nav-item" role="presentation">
                        <a href="#" class="nav-link active" id="all-tab" data-bs-toggle="tab" data-bs-target="#all-tab-pane">
                          <div class="iconarea">
                            <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/workshope.png" class="img-fluid" />
                            <span class="ms-1">College workshop</span>
                            <div class="collapseicon-mobile d-md-none">
                              <svg xmlns="http://www.w3.org/2000/svg" width="12" height="8" viewBox="0 0 12 8" fill="none">
                                <path d="M10.7458 1.16726C10.5584 0.981006 10.305 0.876465 10.0408 0.876465C9.77661 0.876465 9.52316 0.981006 9.3358 1.16726L5.7458 4.70726L2.2058 1.16726C2.01844 0.981006 1.76498 0.876465 1.5008 0.876465C1.23661 0.876465 0.983161 0.981006 0.795798 1.16726C0.70207 1.26022 0.627675 1.37082 0.576907 1.49268C0.526138 1.61454 0.5 1.74525 0.5 1.87726C0.5 2.00927 0.526138 2.13997 0.576907 2.26183C0.627675 2.38369 0.70207 2.49429 0.795798 2.58726L5.0358 6.82726C5.12876 6.92099 5.23936 6.99538 5.36122 7.04615C5.48308 7.09692 5.61379 7.12306 5.7458 7.12306C5.87781 7.12306 6.00852 7.09692 6.13037 7.04615C6.25223 6.99538 6.36283 6.92099 6.4558 6.82726L10.7458 2.58726C10.8395 2.49429 10.9139 2.38369 10.9647 2.26183C11.0155 2.13997 11.0416 2.00927 11.0416 1.87726C11.0416 1.74525 11.0155 1.61454 10.9647 1.49268C10.9139 1.37082 10.8395 1.26022 10.7458 1.16726Z" fill="#181818"/>
                              </svg>
                            </div>
                          </div>
                        </a>
                        <div class="eventblock d-md-none">
                          <div class="row">
                            <div class="col-12 col-md-6 col-xl-4 intcourse pt-0 pb-3 px-2">
                              <div class="awardbox p-3 text-center d-block">
                                <div class="image-box pb-3">
                                  <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/media.jpg" class="img-fluid" alt="">
                                </div>
                                <div class="content text-center">
                                  <h5 class="color-black fw-bold pb-2 md-2 pb-md-3 mb-md-3 border-bottom">3-day hands-on workshop on Generative AI at Sangam University</h5>
                                  <p>An insightful day at SOET as students explored the world of cyber safety and digital awareness.Learning, curiosity, and technology came together...</p>
                                  <a href="javascript:void(0);" class="theme-text-primary fw-medium text-decoration-none">Learn more</a>
                                </div>
                              </div>
                            </div>
                            <div class="col-12 col-md-6 col-xl-4 intcourse pt-0 pb-3 px-2">
                              <div class="awardbox p-3 text-center d-block">
                                <div class="image-box pb-3">
                                  <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/media.jpg" class="img-fluid" alt="">
                                </div>
                                <div class="content text-center">
                                  <h5 class="color-black fw-bold pb-2 md-2 pb-md-3 mb-md-3 border-bottom">3-day hands-on workshop on Generative AI at Sangam University</h5>
                                  <p>An insightful day at SOET as students explored the world of cyber safety and digital awareness.Learning, curiosity, and technology came together...</p>
                                  <a href="javascript:void(0);" class="theme-text-primary fw-medium text-decoration-none">Learn more</a>
                                </div>
                              </div>
                            </div>
                            <div class="col-12 col-md-6 col-xl-4 intcourse pt-0 pb-3 px-2">
                              <div class="awardbox p-3 text-center d-block">
                                <div class="image-box pb-3">
                                  <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/media.jpg" class="img-fluid" alt="">
                                </div>
                                <div class="content text-center">
                                  <h5 class="color-black fw-bold pb-2 md-2 pb-md-3 mb-md-3 border-bottom">3-day hands-on workshop on Generative AI at Sangam University</h5>
                                  <p>An insightful day at SOET as students explored the world of cyber safety and digital awareness.Learning, curiosity, and technology came together...</p>
                                  <a href="javascript:void(0);" class="theme-text-primary fw-medium text-decoration-none">Learn more</a>
                                </div>
                              </div>
                            </div>
                            <div class="col-12 col-md-6 col-xl-4 intcourse pt-0 pb-3 px-2">
                              <div class="awardbox p-3 text-center d-block">
                                <div class="image-box pb-3">
                                  <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/media.jpg" class="img-fluid" alt="">
                                </div>
                                <div class="content text-center">
                                  <h5 class="color-black fw-bold pb-2 md-2 pb-md-3 mb-md-3 border-bottom">3-day hands-on workshop on Generative AI at Sangam University</h5>
                                  <p>An insightful day at SOET as students explored the world of cyber safety and digital awareness.Learning, curiosity, and technology came together...</p>
                                  <a href="javascript:void(0);" class="theme-text-primary fw-medium text-decoration-none">Learn more</a>
                                </div>
                              </div>
                            </div>
                            <div class="col-12 col-md-6 col-xl-4 intcourse pt-0 pb-3 px-2">
                              <div class="awardbox p-3 text-center d-block">
                                <div class="image-box pb-3">
                                  <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/media.jpg" class="img-fluid" alt="">
                                </div>
                                <div class="content text-center">
                                  <h5 class="color-black fw-bold pb-2 md-2 pb-md-3 mb-md-3 border-bottom">3-day hands-on workshop on Generative AI at Sangam University</h5>
                                  <p>An insightful day at SOET as students explored the world of cyber safety and digital awareness.Learning, curiosity, and technology came together...</p>
                                  <a href="javascript:void(0);" class="theme-text-primary fw-medium text-decoration-none">Learn more</a>
                                </div>
                              </div>
                            </div>
                            <div class="col-12 col-md-6 col-xl-4 intcourse pt-0 pb-3 px-2">
                              <div class="awardbox p-3 text-center d-block">
                                <div class="image-box pb-3">
                                  <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/media.jpg" class="img-fluid" alt="">
                                </div>
                                <div class="content text-center">
                                  <h5 class="color-black fw-bold pb-2 md-2 pb-md-3 mb-md-3 border-bottom">3-day hands-on workshop on Generative AI at Sangam University</h5>
                                  <p>An insightful day at SOET as students explored the world of cyber safety and digital awareness.Learning, curiosity, and technology came together...</p>
                                  <a href="javascript:void(0);" class="theme-text-primary fw-medium text-decoration-none">Learn more</a>
                                </div>
                              </div>
                            </div>
                            <div class="col-12 col-md-6 col-xl-4 intcourse pt-0 pb-3 px-2">
                              <div class="awardbox p-3 text-center d-block">
                                <div class="image-box pb-3">
                                  <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/media.jpg" class="img-fluid" alt="">
                                </div>
                                <div class="content text-center">
                                  <h5 class="color-black fw-bold pb-2 md-2 pb-md-3 mb-md-3 border-bottom">3-day hands-on workshop on Generative AI at Sangam University</h5>
                                  <p>An insightful day at SOET as students explored the world of cyber safety and digital awareness.Learning, curiosity, and technology came together...</p>
                                  <a href="javascript:void(0);" class="theme-text-primary fw-medium text-decoration-none">Learn more</a>
                                </div>
                              </div>
                            </div>
                            <div class="col-12 col-md-6 col-xl-4 intcourse pt-0 pb-3 px-2">
                              <div class="awardbox p-3 text-center d-block">
                                <div class="image-box pb-3">
                                  <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/media.jpg" class="img-fluid" alt="">
                                </div>
                                <div class="content text-center">
                                  <h5 class="color-black fw-bold pb-2 md-2 pb-md-3 mb-md-3 border-bottom">3-day hands-on workshop on Generative AI at Sangam University</h5>
                                  <p>An insightful day at SOET as students explored the world of cyber safety and digital awareness.Learning, curiosity, and technology came together...</p>
                                  <a href="javascript:void(0);" class="theme-text-primary fw-medium text-decoration-none">Learn more</a>
                                </div>
                              </div>
                            </div>
                            <div class="col-12 col-md-6 col-xl-4 intcourse pt-0 pb-3 px-2">
                              <div class="awardbox p-3 text-center d-block">
                                <div class="image-box pb-3">
                                  <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/media.jpg" class="img-fluid" alt="">
                                </div>
                                <div class="content text-center">
                                  <h5 class="color-black fw-bold pb-2 md-2 pb-md-3 mb-md-3 border-bottom">3-day hands-on workshop on Generative AI at Sangam University</h5>
                                  <p>An insightful day at SOET as students explored the world of cyber safety and digital awareness.Learning, curiosity, and technology came together...</p>
                                  <a href="javascript:void(0);" class="theme-text-primary fw-medium text-decoration-none">Learn more</a>
                                </div>
                              </div>
                            </div>
                            <div class="col-12">
                              <ul class="pagination justify-content-center">
                                <li class="page-item">
                                  <a class="page-link prev" href="#" aria-label="Previous">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="10" height="12" viewBox="0 0 10 12" fill="none">
                                      <path d="M6.60156 11.9403L0.576563 6.19033L6.60156 0.465331H9.47656L3.42656 6.19033L9.47656 11.9403H6.60156Z" fill="black"></path>
                                    </svg>
                                  </a>
                                </li>
                                <li class="page-item active"><a class="page-link" href="#">1</a></li>
                                <li class="page-item"><a class="page-link" href="#">2</a></li>
                                <li class="page-item"><a class="page-link" href="#">3</a></li>
                                <li class="page-item">
                                  <a class="page-link next" href="#" aria-label="Next">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="10" height="12" viewBox="0 0 10 12" fill="none">
                                      <path d="M0.201563 0.465331H3.07656L9.12656 6.19033L3.07656 11.9403H0.201563L6.25156 6.19033L0.201563 0.465331Z" fill="black"></path>
                                    </svg>
                                  </a>
                                </li>
                              </ul>
                            </div>
                          </div>
                        </div>
                      </li>
                      <li class="nav-item" role="presentation">
                        <a href="#" class="nav-link" id="programming-tab" data-bs-toggle="tab" data-bs-target="#programming-tab-pane">
                          <div class="iconarea">
                            <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/banking.png" class="img-fluid" />
                            <span class="ms-1"> Corporate workshop</span>
                            <div class="collapseicon-mobile d-md-none">
                              <svg xmlns="http://www.w3.org/2000/svg" width="12" height="8" viewBox="0 0 12 8" fill="none">
                                <path d="M10.7458 1.16726C10.5584 0.981006 10.305 0.876465 10.0408 0.876465C9.77661 0.876465 9.52316 0.981006 9.3358 1.16726L5.7458 4.70726L2.2058 1.16726C2.01844 0.981006 1.76498 0.876465 1.5008 0.876465C1.23661 0.876465 0.983161 0.981006 0.795798 1.16726C0.70207 1.26022 0.627675 1.37082 0.576907 1.49268C0.526138 1.61454 0.5 1.74525 0.5 1.87726C0.5 2.00927 0.526138 2.13997 0.576907 2.26183C0.627675 2.38369 0.70207 2.49429 0.795798 2.58726L5.0358 6.82726C5.12876 6.92099 5.23936 6.99538 5.36122 7.04615C5.48308 7.09692 5.61379 7.12306 5.7458 7.12306C5.87781 7.12306 6.00852 7.09692 6.13037 7.04615C6.25223 6.99538 6.36283 6.92099 6.4558 6.82726L10.7458 2.58726C10.8395 2.49429 10.9139 2.38369 10.9647 2.26183C11.0155 2.13997 11.0416 2.00927 11.0416 1.87726C11.0416 1.74525 11.0155 1.61454 10.9647 1.49268C10.9139 1.37082 10.8395 1.26022 10.7458 1.16726Z" fill="#181818"/>
                              </svg>
                            </div>
                          </div>
                        </a>
                        <div class="eventblock d-md-none">
                          <div class="row">
                            <div class="col-12 col-md-6 col-xl-4 intcourse pt-0 pb-3 px-2">
                              <div class="awardbox p-3 text-center d-block">
                                <div class="image-box pb-3">
                                  <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/media.jpg" class="img-fluid" alt="">
                                </div>
                                <div class="content text-center">
                                  <h5 class="color-black fw-bold pb-2 md-2 pb-md-3 mb-md-3 border-bottom">3-day hands-on workshop on Generative AI at Sangam University</h5>
                                  <p>An insightful day at SOET as students explored the world of cyber safety and digital awareness.Learning, curiosity, and technology came together...</p>
                                  <a href="javascript:void(0);" class="theme-text-primary fw-medium text-decoration-none">Learn more</a>
                                </div>
                              </div>
                            </div>
                            <div class="col-12 col-md-6 col-xl-4 intcourse pt-0 pb-3 px-2">
                              <div class="awardbox p-3 text-center d-block">
                                <div class="image-box pb-3">
                                  <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/media.jpg" class="img-fluid" alt="">
                                </div>
                                <div class="content text-center">
                                  <h5 class="color-black fw-bold pb-2 md-2 pb-md-3 mb-md-3 border-bottom">3-day hands-on workshop on Generative AI at Sangam University</h5>
                                  <p>An insightful day at SOET as students explored the world of cyber safety and digital awareness.Learning, curiosity, and technology came together...</p>
                                  <a href="javascript:void(0);" class="theme-text-primary fw-medium text-decoration-none">Learn more</a>
                                </div>
                              </div>
                            </div>
                            <div class="col-12 col-md-6 col-xl-4 intcourse pt-0 pb-3 px-2">
                              <div class="awardbox p-3 text-center d-block">
                                <div class="image-box pb-3">
                                  <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/media.jpg" class="img-fluid" alt="">
                                </div>
                                <div class="content text-center">
                                  <h5 class="color-black fw-bold pb-2 md-2 pb-md-3 mb-md-3 border-bottom">3-day hands-on workshop on Generative AI at Sangam University</h5>
                                  <p>An insightful day at SOET as students explored the world of cyber safety and digital awareness.Learning, curiosity, and technology came together...</p>
                                  <a href="javascript:void(0);" class="theme-text-primary fw-medium text-decoration-none">Learn more</a>
                                </div>
                              </div>
                            </div>
                            <div class="col-12 col-md-6 col-xl-4 intcourse pt-0 pb-3 px-2">
                              <div class="awardbox p-3 text-center d-block">
                                <div class="image-box pb-3">
                                  <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/media.jpg" class="img-fluid" alt="">
                                </div>
                                <div class="content text-center">
                                  <h5 class="color-black fw-bold pb-2 md-2 pb-md-3 mb-md-3 border-bottom">3-day hands-on workshop on Generative AI at Sangam University</h5>
                                  <p>An insightful day at SOET as students explored the world of cyber safety and digital awareness.Learning, curiosity, and technology came together...</p>
                                  <a href="javascript:void(0);" class="theme-text-primary fw-medium text-decoration-none">Learn more</a>
                                </div>
                              </div>
                            </div>
                            <div class="col-12 col-md-6 col-xl-4 intcourse pt-0 pb-3 px-2">
                              <div class="awardbox p-3 text-center d-block">
                                <div class="image-box pb-3">
                                  <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/media.jpg" class="img-fluid" alt="">
                                </div>
                                <div class="content text-center">
                                  <h5 class="color-black fw-bold pb-2 md-2 pb-md-3 mb-md-3 border-bottom">3-day hands-on workshop on Generative AI at Sangam University</h5>
                                  <p>An insightful day at SOET as students explored the world of cyber safety and digital awareness.Learning, curiosity, and technology came together...</p>
                                  <a href="javascript:void(0);" class="theme-text-primary fw-medium text-decoration-none">Learn more</a>
                                </div>
                              </div>
                            </div>
                            <div class="col-12 col-md-6 col-xl-4 intcourse pt-0 pb-3 px-2">
                              <div class="awardbox p-3 text-center d-block">
                                <div class="image-box pb-3">
                                  <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/media.jpg" class="img-fluid" alt="">
                                </div>
                                <div class="content text-center">
                                  <h5 class="color-black fw-bold pb-2 md-2 pb-md-3 mb-md-3 border-bottom">3-day hands-on workshop on Generative AI at Sangam University</h5>
                                  <p>An insightful day at SOET as students explored the world of cyber safety and digital awareness.Learning, curiosity, and technology came together...</p>
                                  <a href="javascript:void(0);" class="theme-text-primary fw-medium text-decoration-none">Learn more</a>
                                </div>
                              </div>
                            </div>
                            <div class="col-12 col-md-6 col-xl-4 intcourse pt-0 pb-3 px-2">
                              <div class="awardbox p-3 text-center d-block">
                                <div class="image-box pb-3">
                                  <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/media.jpg" class="img-fluid" alt="">
                                </div>
                                <div class="content text-center">
                                  <h5 class="color-black fw-bold pb-2 md-2 pb-md-3 mb-md-3 border-bottom">3-day hands-on workshop on Generative AI at Sangam University</h5>
                                  <p>An insightful day at SOET as students explored the world of cyber safety and digital awareness.Learning, curiosity, and technology came together...</p>
                                  <a href="javascript:void(0);" class="theme-text-primary fw-medium text-decoration-none">Learn more</a>
                                </div>
                              </div>
                            </div>
                            <div class="col-12 col-md-6 col-xl-4 intcourse pt-0 pb-3 px-2">
                              <div class="awardbox p-3 text-center d-block">
                                <div class="image-box pb-3">
                                  <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/media.jpg" class="img-fluid" alt="">
                                </div>
                                <div class="content text-center">
                                  <h5 class="color-black fw-bold pb-2 md-2 pb-md-3 mb-md-3 border-bottom">3-day hands-on workshop on Generative AI at Sangam University</h5>
                                  <p>An insightful day at SOET as students explored the world of cyber safety and digital awareness.Learning, curiosity, and technology came together...</p>
                                  <a href="javascript:void(0);" class="theme-text-primary fw-medium text-decoration-none">Learn more</a>
                                </div>
                              </div>
                            </div>
                            <div class="col-12 col-md-6 col-xl-4 intcourse pt-0 pb-3 px-2">
                              <div class="awardbox p-3 text-center d-block">
                                <div class="image-box pb-3">
                                  <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/media.jpg" class="img-fluid" alt="">
                                </div>
                                <div class="content text-center">
                                  <h5 class="color-black fw-bold pb-2 md-2 pb-md-3 mb-md-3 border-bottom">3-day hands-on workshop on Generative AI at Sangam University</h5>
                                  <p>An insightful day at SOET as students explored the world of cyber safety and digital awareness.Learning, curiosity, and technology came together...</p>
                                  <a href="javascript:void(0);" class="theme-text-primary fw-medium text-decoration-none">Learn more</a>
                                </div>
                              </div>
                            </div>
                            <div class="col-12">
                              <ul class="pagination justify-content-center">
                                <li class="page-item">
                                  <a class="page-link prev" href="#" aria-label="Previous">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="10" height="12" viewBox="0 0 10 12" fill="none">
                                      <path d="M6.60156 11.9403L0.576563 6.19033L6.60156 0.465331H9.47656L3.42656 6.19033L9.47656 11.9403H6.60156Z" fill="black"></path>
                                    </svg>
                                  </a>
                                </li>
                                <li class="page-item active"><a class="page-link" href="#">1</a></li>
                                <li class="page-item"><a class="page-link" href="#">2</a></li>
                                <li class="page-item"><a class="page-link" href="#">3</a></li>
                                <li class="page-item">
                                  <a class="page-link next" href="#" aria-label="Next">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="10" height="12" viewBox="0 0 10 12" fill="none">
                                      <path d="M0.201563 0.465331H3.07656L9.12656 6.19033L3.07656 11.9403H0.201563L6.25156 6.19033L0.201563 0.465331Z" fill="black"></path>
                                    </svg>
                                  </a>
                                </li>
                              </ul>
                            </div>
                          </div>
                        </div>
                      </li>
                      <li class="nav-item" role="presentation">
                        <a href="#" class="nav-link" id="webdevelopment-tab" data-bs-toggle="tab" data-bs-target="#webdevelopment-tab-pane">
                          <div class="iconarea">
                            <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/code.png" class="img-fluid" />
                            <span class="ms-1">Hackathon</span>
                            <div class="collapseicon-mobile d-md-none">
                              <svg xmlns="http://www.w3.org/2000/svg" width="12" height="8" viewBox="0 0 12 8" fill="none">
                                <path d="M10.7458 1.16726C10.5584 0.981006 10.305 0.876465 10.0408 0.876465C9.77661 0.876465 9.52316 0.981006 9.3358 1.16726L5.7458 4.70726L2.2058 1.16726C2.01844 0.981006 1.76498 0.876465 1.5008 0.876465C1.23661 0.876465 0.983161 0.981006 0.795798 1.16726C0.70207 1.26022 0.627675 1.37082 0.576907 1.49268C0.526138 1.61454 0.5 1.74525 0.5 1.87726C0.5 2.00927 0.526138 2.13997 0.576907 2.26183C0.627675 2.38369 0.70207 2.49429 0.795798 2.58726L5.0358 6.82726C5.12876 6.92099 5.23936 6.99538 5.36122 7.04615C5.48308 7.09692 5.61379 7.12306 5.7458 7.12306C5.87781 7.12306 6.00852 7.09692 6.13037 7.04615C6.25223 6.99538 6.36283 6.92099 6.4558 6.82726L10.7458 2.58726C10.8395 2.49429 10.9139 2.38369 10.9647 2.26183C11.0155 2.13997 11.0416 2.00927 11.0416 1.87726C11.0416 1.74525 11.0155 1.61454 10.9647 1.49268C10.9139 1.37082 10.8395 1.26022 10.7458 1.16726Z" fill="#181818"/>
                              </svg>
                            </div>
                          </div>
                        </a>
                        <div class="eventblock d-md-none">
                          <div class="row">
                            <div class="col-12 col-md-6 col-xl-4 intcourse pt-0 pb-3 px-2">
                              <div class="awardbox p-3 text-center d-block">
                                <div class="image-box pb-3">
                                  <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/media.jpg" class="img-fluid" alt="">
                                </div>
                                <div class="content text-center">
                                  <h5 class="color-black fw-bold pb-2 md-2 pb-md-3 mb-md-3 border-bottom">3-day hands-on workshop on Generative AI at Sangam University</h5>
                                  <p>An insightful day at SOET as students explored the world of cyber safety and digital awareness.Learning, curiosity, and technology came together...</p>
                                  <a href="javascript:void(0);" class="theme-text-primary fw-medium text-decoration-none">Learn more</a>
                                </div>
                              </div>
                            </div>
                            <div class="col-12 col-md-6 col-xl-4 intcourse pt-0 pb-3 px-2">
                              <div class="awardbox p-3 text-center d-block">
                                <div class="image-box pb-3">
                                  <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/media.jpg" class="img-fluid" alt="">
                                </div>
                                <div class="content text-center">
                                  <h5 class="color-black fw-bold pb-2 md-2 pb-md-3 mb-md-3 border-bottom">3-day hands-on workshop on Generative AI at Sangam University</h5>
                                  <p>An insightful day at SOET as students explored the world of cyber safety and digital awareness.Learning, curiosity, and technology came together...</p>
                                  <a href="javascript:void(0);" class="theme-text-primary fw-medium text-decoration-none">Learn more</a>
                                </div>
                              </div>
                            </div>
                            <div class="col-12 col-md-6 col-xl-4 intcourse pt-0 pb-3 px-2">
                              <div class="awardbox p-3 text-center d-block">
                                <div class="image-box pb-3">
                                  <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/media.jpg" class="img-fluid" alt="">
                                </div>
                                <div class="content text-center">
                                  <h5 class="color-black fw-bold pb-2 md-2 pb-md-3 mb-md-3 border-bottom">3-day hands-on workshop on Generative AI at Sangam University</h5>
                                  <p>An insightful day at SOET as students explored the world of cyber safety and digital awareness.Learning, curiosity, and technology came together...</p>
                                  <a href="javascript:void(0);" class="theme-text-primary fw-medium text-decoration-none">Learn more</a>
                                </div>
                              </div>
                            </div>
                            <div class="col-12 col-md-6 col-xl-4 intcourse pt-0 pb-3 px-2">
                              <div class="awardbox p-3 text-center d-block">
                                <div class="image-box pb-3">
                                  <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/media.jpg" class="img-fluid" alt="">
                                </div>
                                <div class="content text-center">
                                  <h5 class="color-black fw-bold pb-2 md-2 pb-md-3 mb-md-3 border-bottom">3-day hands-on workshop on Generative AI at Sangam University</h5>
                                  <p>An insightful day at SOET as students explored the world of cyber safety and digital awareness.Learning, curiosity, and technology came together...</p>
                                  <a href="javascript:void(0);" class="theme-text-primary fw-medium text-decoration-none">Learn more</a>
                                </div>
                              </div>
                            </div>
                            <div class="col-12 col-md-6 col-xl-4 intcourse pt-0 pb-3 px-2">
                              <div class="awardbox p-3 text-center d-block">
                                <div class="image-box pb-3">
                                  <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/media.jpg" class="img-fluid" alt="">
                                </div>
                                <div class="content text-center">
                                  <h5 class="color-black fw-bold pb-2 md-2 pb-md-3 mb-md-3 border-bottom">3-day hands-on workshop on Generative AI at Sangam University</h5>
                                  <p>An insightful day at SOET as students explored the world of cyber safety and digital awareness.Learning, curiosity, and technology came together...</p>
                                  <a href="javascript:void(0);" class="theme-text-primary fw-medium text-decoration-none">Learn more</a>
                                </div>
                              </div>
                            </div>
                            <div class="col-12 col-md-6 col-xl-4 intcourse pt-0 pb-3 px-2">
                              <div class="awardbox p-3 text-center d-block">
                                <div class="image-box pb-3">
                                  <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/media.jpg" class="img-fluid" alt="">
                                </div>
                                <div class="content text-center">
                                  <h5 class="color-black fw-bold pb-2 md-2 pb-md-3 mb-md-3 border-bottom">3-day hands-on workshop on Generative AI at Sangam University</h5>
                                  <p>An insightful day at SOET as students explored the world of cyber safety and digital awareness.Learning, curiosity, and technology came together...</p>
                                  <a href="javascript:void(0);" class="theme-text-primary fw-medium text-decoration-none">Learn more</a>
                                </div>
                              </div>
                            </div>
                            <div class="col-12 col-md-6 col-xl-4 intcourse pt-0 pb-3 px-2">
                              <div class="awardbox p-3 text-center d-block">
                                <div class="image-box pb-3">
                                  <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/media.jpg" class="img-fluid" alt="">
                                </div>
                                <div class="content text-center">
                                  <h5 class="color-black fw-bold pb-2 md-2 pb-md-3 mb-md-3 border-bottom">3-day hands-on workshop on Generative AI at Sangam University</h5>
                                  <p>An insightful day at SOET as students explored the world of cyber safety and digital awareness.Learning, curiosity, and technology came together...</p>
                                  <a href="javascript:void(0);" class="theme-text-primary fw-medium text-decoration-none">Learn more</a>
                                </div>
                              </div>
                            </div>
                            <div class="col-12 col-md-6 col-xl-4 intcourse pt-0 pb-3 px-2">
                              <div class="awardbox p-3 text-center d-block">
                                <div class="image-box pb-3">
                                  <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/media.jpg" class="img-fluid" alt="">
                                </div>
                                <div class="content text-center">
                                  <h5 class="color-black fw-bold pb-2 md-2 pb-md-3 mb-md-3 border-bottom">3-day hands-on workshop on Generative AI at Sangam University</h5>
                                  <p>An insightful day at SOET as students explored the world of cyber safety and digital awareness.Learning, curiosity, and technology came together...</p>
                                  <a href="javascript:void(0);" class="theme-text-primary fw-medium text-decoration-none">Learn more</a>
                                </div>
                              </div>
                            </div>
                            <div class="col-12 col-md-6 col-xl-4 intcourse pt-0 pb-3 px-2">
                              <div class="awardbox p-3 text-center d-block">
                                <div class="image-box pb-3">
                                  <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/media.jpg" class="img-fluid" alt="">
                                </div>
                                <div class="content text-center">
                                  <h5 class="color-black fw-bold pb-2 md-2 pb-md-3 mb-md-3 border-bottom">3-day hands-on workshop on Generative AI at Sangam University</h5>
                                  <p>An insightful day at SOET as students explored the world of cyber safety and digital awareness.Learning, curiosity, and technology came together...</p>
                                  <a href="javascript:void(0);" class="theme-text-primary fw-medium text-decoration-none">Learn more</a>
                                </div>
                              </div>
                            </div>
                            <div class="col-12">
                              <ul class="pagination justify-content-center">
                                <li class="page-item">
                                  <a class="page-link prev" href="#" aria-label="Previous">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="10" height="12" viewBox="0 0 10 12" fill="none">
                                      <path d="M6.60156 11.9403L0.576563 6.19033L6.60156 0.465331H9.47656L3.42656 6.19033L9.47656 11.9403H6.60156Z" fill="black"></path>
                                    </svg>
                                  </a>
                                </li>
                                <li class="page-item active"><a class="page-link" href="#">1</a></li>
                                <li class="page-item"><a class="page-link" href="#">2</a></li>
                                <li class="page-item"><a class="page-link" href="#">3</a></li>
                                <li class="page-item">
                                  <a class="page-link next" href="#" aria-label="Next">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="10" height="12" viewBox="0 0 10 12" fill="none">
                                      <path d="M0.201563 0.465331H3.07656L9.12656 6.19033L3.07656 11.9403H0.201563L6.25156 6.19033L0.201563 0.465331Z" fill="black"></path>
                                    </svg>
                                  </a>
                                </li>
                              </ul>
                            </div>
                          </div>
                        </div>
                      </li>
                      <li class="nav-item" role="presentation">
                        <a href="#" class="nav-link" id="analytics-tab" data-bs-toggle="tab" data-bs-target="#analytics-tab-pane">
                          <div class="iconarea">
                            <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/Civil.png" class="img-fluid" />
                            <span class="ms-1">Redhat event </span>
                            <div class="collapseicon-mobile d-md-none">
                              <svg xmlns="http://www.w3.org/2000/svg" width="12" height="8" viewBox="0 0 12 8" fill="none">
                                <path d="M10.7458 1.16726C10.5584 0.981006 10.305 0.876465 10.0408 0.876465C9.77661 0.876465 9.52316 0.981006 9.3358 1.16726L5.7458 4.70726L2.2058 1.16726C2.01844 0.981006 1.76498 0.876465 1.5008 0.876465C1.23661 0.876465 0.983161 0.981006 0.795798 1.16726C0.70207 1.26022 0.627675 1.37082 0.576907 1.49268C0.526138 1.61454 0.5 1.74525 0.5 1.87726C0.5 2.00927 0.526138 2.13997 0.576907 2.26183C0.627675 2.38369 0.70207 2.49429 0.795798 2.58726L5.0358 6.82726C5.12876 6.92099 5.23936 6.99538 5.36122 7.04615C5.48308 7.09692 5.61379 7.12306 5.7458 7.12306C5.87781 7.12306 6.00852 7.09692 6.13037 7.04615C6.25223 6.99538 6.36283 6.92099 6.4558 6.82726L10.7458 2.58726C10.8395 2.49429 10.9139 2.38369 10.9647 2.26183C11.0155 2.13997 11.0416 2.00927 11.0416 1.87726C11.0416 1.74525 11.0155 1.61454 10.9647 1.49268C10.9139 1.37082 10.8395 1.26022 10.7458 1.16726Z" fill="#181818"/>
                              </svg>
                            </div>
                          </div>
                        </a>
                        <div class="eventblock d-md-none">
                          <div class="row">
                            <div class="col-12 col-md-6 col-xl-4 intcourse pt-0 pb-3 px-2">
                              <div class="awardbox p-3 text-center d-block">
                                <div class="image-box pb-3">
                                  <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/media.jpg" class="img-fluid" alt="">
                                </div>
                                <div class="content text-center">
                                  <h5 class="color-black fw-bold pb-2 md-2 pb-md-3 mb-md-3 border-bottom">3-day hands-on workshop on Generative AI at Sangam University</h5>
                                  <p>An insightful day at SOET as students explored the world of cyber safety and digital awareness.Learning, curiosity, and technology came together...</p>
                                  <a href="javascript:void(0);" class="theme-text-primary fw-medium text-decoration-none">Learn more</a>
                                </div>
                              </div>
                            </div>
                            <div class="col-12 col-md-6 col-xl-4 intcourse pt-0 pb-3 px-2">
                              <div class="awardbox p-3 text-center d-block">
                                <div class="image-box pb-3">
                                  <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/media.jpg" class="img-fluid" alt="">
                                </div>
                                <div class="content text-center">
                                  <h5 class="color-black fw-bold pb-2 md-2 pb-md-3 mb-md-3 border-bottom">3-day hands-on workshop on Generative AI at Sangam University</h5>
                                  <p>An insightful day at SOET as students explored the world of cyber safety and digital awareness.Learning, curiosity, and technology came together...</p>
                                  <a href="javascript:void(0);" class="theme-text-primary fw-medium text-decoration-none">Learn more</a>
                                </div>
                              </div>
                            </div>
                            <div class="col-12 col-md-6 col-xl-4 intcourse pt-0 pb-3 px-2">
                              <div class="awardbox p-3 text-center d-block">
                                <div class="image-box pb-3">
                                  <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/media.jpg" class="img-fluid" alt="">
                                </div>
                                <div class="content text-center">
                                  <h5 class="color-black fw-bold pb-2 md-2 pb-md-3 mb-md-3 border-bottom">3-day hands-on workshop on Generative AI at Sangam University</h5>
                                  <p>An insightful day at SOET as students explored the world of cyber safety and digital awareness.Learning, curiosity, and technology came together...</p>
                                  <a href="javascript:void(0);" class="theme-text-primary fw-medium text-decoration-none">Learn more</a>
                                </div>
                              </div>
                            </div>
                            <div class="col-12 col-md-6 col-xl-4 intcourse pt-0 pb-3 px-2">
                              <div class="awardbox p-3 text-center d-block">
                                <div class="image-box pb-3">
                                  <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/media.jpg" class="img-fluid" alt="">
                                </div>
                                <div class="content text-center">
                                  <h5 class="color-black fw-bold pb-2 md-2 pb-md-3 mb-md-3 border-bottom">3-day hands-on workshop on Generative AI at Sangam University</h5>
                                  <p>An insightful day at SOET as students explored the world of cyber safety and digital awareness.Learning, curiosity, and technology came together...</p>
                                  <a href="javascript:void(0);" class="theme-text-primary fw-medium text-decoration-none">Learn more</a>
                                </div>
                              </div>
                            </div>
                            <div class="col-12 col-md-6 col-xl-4 intcourse pt-0 pb-3 px-2">
                              <div class="awardbox p-3 text-center d-block">
                                <div class="image-box pb-3">
                                  <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/media.jpg" class="img-fluid" alt="">
                                </div>
                                <div class="content text-center">
                                  <h5 class="color-black fw-bold pb-2 md-2 pb-md-3 mb-md-3 border-bottom">3-day hands-on workshop on Generative AI at Sangam University</h5>
                                  <p>An insightful day at SOET as students explored the world of cyber safety and digital awareness.Learning, curiosity, and technology came together...</p>
                                  <a href="javascript:void(0);" class="theme-text-primary fw-medium text-decoration-none">Learn more</a>
                                </div>
                              </div>
                            </div>
                            <div class="col-12 col-md-6 col-xl-4 intcourse pt-0 pb-3 px-2">
                              <div class="awardbox p-3 text-center d-block">
                                <div class="image-box pb-3">
                                  <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/media.jpg" class="img-fluid" alt="">
                                </div>
                                <div class="content text-center">
                                  <h5 class="color-black fw-bold pb-2 md-2 pb-md-3 mb-md-3 border-bottom">3-day hands-on workshop on Generative AI at Sangam University</h5>
                                  <p>An insightful day at SOET as students explored the world of cyber safety and digital awareness.Learning, curiosity, and technology came together...</p>
                                  <a href="javascript:void(0);" class="theme-text-primary fw-medium text-decoration-none">Learn more</a>
                                </div>
                              </div>
                            </div>
                            <div class="col-12 col-md-6 col-xl-4 intcourse pt-0 pb-3 px-2">
                              <div class="awardbox p-3 text-center d-block">
                                <div class="image-box pb-3">
                                  <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/media.jpg" class="img-fluid" alt="">
                                </div>
                                <div class="content text-center">
                                  <h5 class="color-black fw-bold pb-2 md-2 pb-md-3 mb-md-3 border-bottom">3-day hands-on workshop on Generative AI at Sangam University</h5>
                                  <p>An insightful day at SOET as students explored the world of cyber safety and digital awareness.Learning, curiosity, and technology came together...</p>
                                  <a href="javascript:void(0);" class="theme-text-primary fw-medium text-decoration-none">Learn more</a>
                                </div>
                              </div>
                            </div>
                            <div class="col-12 col-md-6 col-xl-4 intcourse pt-0 pb-3 px-2">
                              <div class="awardbox p-3 text-center d-block">
                                <div class="image-box pb-3">
                                  <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/media.jpg" class="img-fluid" alt="">
                                </div>
                                <div class="content text-center">
                                  <h5 class="color-black fw-bold pb-2 md-2 pb-md-3 mb-md-3 border-bottom">3-day hands-on workshop on Generative AI at Sangam University</h5>
                                  <p>An insightful day at SOET as students explored the world of cyber safety and digital awareness.Learning, curiosity, and technology came together...</p>
                                  <a href="javascript:void(0);" class="theme-text-primary fw-medium text-decoration-none">Learn more</a>
                                </div>
                              </div>
                            </div>
                            <div class="col-12 col-md-6 col-xl-4 intcourse pt-0 pb-3 px-2">
                              <div class="awardbox p-3 text-center d-block">
                                <div class="image-box pb-3">
                                  <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/media.jpg" class="img-fluid" alt="">
                                </div>
                                <div class="content text-center">
                                  <h5 class="color-black fw-bold pb-2 md-2 pb-md-3 mb-md-3 border-bottom">3-day hands-on workshop on Generative AI at Sangam University</h5>
                                  <p>An insightful day at SOET as students explored the world of cyber safety and digital awareness.Learning, curiosity, and technology came together...</p>
                                  <a href="javascript:void(0);" class="theme-text-primary fw-medium text-decoration-none">Learn more</a>
                                </div>
                              </div>
                            </div>
                            <div class="col-12">
                              <ul class="pagination justify-content-center">
                                <li class="page-item">
                                  <a class="page-link prev" href="#" aria-label="Previous">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="10" height="12" viewBox="0 0 10 12" fill="none">
                                      <path d="M6.60156 11.9403L0.576563 6.19033L6.60156 0.465331H9.47656L3.42656 6.19033L9.47656 11.9403H6.60156Z" fill="black"></path>
                                    </svg>
                                  </a>
                                </li>
                                <li class="page-item active"><a class="page-link" href="#">1</a></li>
                                <li class="page-item"><a class="page-link" href="#">2</a></li>
                                <li class="page-item"><a class="page-link" href="#">3</a></li>
                                <li class="page-item">
                                  <a class="page-link next" href="#" aria-label="Next">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="10" height="12" viewBox="0 0 10 12" fill="none">
                                      <path d="M0.201563 0.465331H3.07656L9.12656 6.19033L3.07656 11.9403H0.201563L6.25156 6.19033L0.201563 0.465331Z" fill="black"></path>
                                    </svg>
                                  </a>
                                </li>
                              </ul>
                            </div>
                          </div>
                        </div>
                      </li>
                      <li class="nav-item" role="presentation">
                        <a href="#" class="nav-link" id="devops-tab" data-bs-toggle="tab" data-bs-target="#devops-tab-pane">
                          <div class="iconarea">
                            <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/Railways.png" class="img-fluid" />
                            <span class="ms-1">Interview drive</span>
                            <div class="collapseicon-mobile d-md-none">
                              <svg xmlns="http://www.w3.org/2000/svg" width="12" height="8" viewBox="0 0 12 8" fill="none">
                                <path d="M10.7458 1.16726C10.5584 0.981006 10.305 0.876465 10.0408 0.876465C9.77661 0.876465 9.52316 0.981006 9.3358 1.16726L5.7458 4.70726L2.2058 1.16726C2.01844 0.981006 1.76498 0.876465 1.5008 0.876465C1.23661 0.876465 0.983161 0.981006 0.795798 1.16726C0.70207 1.26022 0.627675 1.37082 0.576907 1.49268C0.526138 1.61454 0.5 1.74525 0.5 1.87726C0.5 2.00927 0.526138 2.13997 0.576907 2.26183C0.627675 2.38369 0.70207 2.49429 0.795798 2.58726L5.0358 6.82726C5.12876 6.92099 5.23936 6.99538 5.36122 7.04615C5.48308 7.09692 5.61379 7.12306 5.7458 7.12306C5.87781 7.12306 6.00852 7.09692 6.13037 7.04615C6.25223 6.99538 6.36283 6.92099 6.4558 6.82726L10.7458 2.58726C10.8395 2.49429 10.9139 2.38369 10.9647 2.26183C11.0155 2.13997 11.0416 2.00927 11.0416 1.87726C11.0416 1.74525 11.0155 1.61454 10.9647 1.49268C10.9139 1.37082 10.8395 1.26022 10.7458 1.16726Z" fill="#181818"/>
                              </svg>
                            </div>
                          </div>
                        </a>
                        <div class="eventblock d-md-none">
                          <div class="row">
                            <div class="col-12 col-md-6 col-xl-4 intcourse pt-0 pb-3 px-2">
                              <div class="awardbox p-3 text-center d-block">
                                <div class="image-box pb-3">
                                  <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/media.jpg" class="img-fluid" alt="">
                                </div>
                                <div class="content text-center">
                                  <h5 class="color-black fw-bold pb-2 md-2 pb-md-3 mb-md-3 border-bottom">3-day hands-on workshop on Generative AI at Sangam University</h5>
                                  <p>An insightful day at SOET as students explored the world of cyber safety and digital awareness.Learning, curiosity, and technology came together...</p>
                                  <a href="javascript:void(0);" class="theme-text-primary fw-medium text-decoration-none">Learn more</a>
                                </div>
                              </div>
                            </div>
                            <div class="col-12 col-md-6 col-xl-4 intcourse pt-0 pb-3 px-2">
                              <div class="awardbox p-3 text-center d-block">
                                <div class="image-box pb-3">
                                  <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/media.jpg" class="img-fluid" alt="">
                                </div>
                                <div class="content text-center">
                                  <h5 class="color-black fw-bold pb-2 md-2 pb-md-3 mb-md-3 border-bottom">3-day hands-on workshop on Generative AI at Sangam University</h5>
                                  <p>An insightful day at SOET as students explored the world of cyber safety and digital awareness.Learning, curiosity, and technology came together...</p>
                                  <a href="javascript:void(0);" class="theme-text-primary fw-medium text-decoration-none">Learn more</a>
                                </div>
                              </div>
                            </div>
                            <div class="col-12 col-md-6 col-xl-4 intcourse pt-0 pb-3 px-2">
                              <div class="awardbox p-3 text-center d-block">
                                <div class="image-box pb-3">
                                  <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/media.jpg" class="img-fluid" alt="">
                                </div>
                                <div class="content text-center">
                                  <h5 class="color-black fw-bold pb-2 md-2 pb-md-3 mb-md-3 border-bottom">3-day hands-on workshop on Generative AI at Sangam University</h5>
                                  <p>An insightful day at SOET as students explored the world of cyber safety and digital awareness.Learning, curiosity, and technology came together...</p>
                                  <a href="javascript:void(0);" class="theme-text-primary fw-medium text-decoration-none">Learn more</a>
                                </div>
                              </div>
                            </div>
                            <div class="col-12 col-md-6 col-xl-4 intcourse pt-0 pb-3 px-2">
                              <div class="awardbox p-3 text-center d-block">
                                <div class="image-box pb-3">
                                  <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/media.jpg" class="img-fluid" alt="">
                                </div>
                                <div class="content text-center">
                                  <h5 class="color-black fw-bold pb-2 md-2 pb-md-3 mb-md-3 border-bottom">3-day hands-on workshop on Generative AI at Sangam University</h5>
                                  <p>An insightful day at SOET as students explored the world of cyber safety and digital awareness.Learning, curiosity, and technology came together...</p>
                                  <a href="javascript:void(0);" class="theme-text-primary fw-medium text-decoration-none">Learn more</a>
                                </div>
                              </div>
                            </div>
                            <div class="col-12 col-md-6 col-xl-4 intcourse pt-0 pb-3 px-2">
                              <div class="awardbox p-3 text-center d-block">
                                <div class="image-box pb-3">
                                  <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/media.jpg" class="img-fluid" alt="">
                                </div>
                                <div class="content text-center">
                                  <h5 class="color-black fw-bold pb-2 md-2 pb-md-3 mb-md-3 border-bottom">3-day hands-on workshop on Generative AI at Sangam University</h5>
                                  <p>An insightful day at SOET as students explored the world of cyber safety and digital awareness.Learning, curiosity, and technology came together...</p>
                                  <a href="javascript:void(0);" class="theme-text-primary fw-medium text-decoration-none">Learn more</a>
                                </div>
                              </div>
                            </div>
                            <div class="col-12 col-md-6 col-xl-4 intcourse pt-0 pb-3 px-2">
                              <div class="awardbox p-3 text-center d-block">
                                <div class="image-box pb-3">
                                  <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/media.jpg" class="img-fluid" alt="">
                                </div>
                                <div class="content text-center">
                                  <h5 class="color-black fw-bold pb-2 md-2 pb-md-3 mb-md-3 border-bottom">3-day hands-on workshop on Generative AI at Sangam University</h5>
                                  <p>An insightful day at SOET as students explored the world of cyber safety and digital awareness.Learning, curiosity, and technology came together...</p>
                                  <a href="javascript:void(0);" class="theme-text-primary fw-medium text-decoration-none">Learn more</a>
                                </div>
                              </div>
                            </div>
                            <div class="col-12 col-md-6 col-xl-4 intcourse pt-0 pb-3 px-2">
                              <div class="awardbox p-3 text-center d-block">
                                <div class="image-box pb-3">
                                  <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/media.jpg" class="img-fluid" alt="">
                                </div>
                                <div class="content text-center">
                                  <h5 class="color-black fw-bold pb-2 md-2 pb-md-3 mb-md-3 border-bottom">3-day hands-on workshop on Generative AI at Sangam University</h5>
                                  <p>An insightful day at SOET as students explored the world of cyber safety and digital awareness.Learning, curiosity, and technology came together...</p>
                                  <a href="javascript:void(0);" class="theme-text-primary fw-medium text-decoration-none">Learn more</a>
                                </div>
                              </div>
                            </div>
                            <div class="col-12 col-md-6 col-xl-4 intcourse pt-0 pb-3 px-2">
                              <div class="awardbox p-3 text-center d-block">
                                <div class="image-box pb-3">
                                  <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/media.jpg" class="img-fluid" alt="">
                                </div>
                                <div class="content text-center">
                                  <h5 class="color-black fw-bold pb-2 md-2 pb-md-3 mb-md-3 border-bottom">3-day hands-on workshop on Generative AI at Sangam University</h5>
                                  <p>An insightful day at SOET as students explored the world of cyber safety and digital awareness.Learning, curiosity, and technology came together...</p>
                                  <a href="javascript:void(0);" class="theme-text-primary fw-medium text-decoration-none">Learn more</a>
                                </div>
                              </div>
                            </div>
                            <div class="col-12 col-md-6 col-xl-4 intcourse pt-0 pb-3 px-2">
                              <div class="awardbox p-3 text-center d-block">
                                <div class="image-box pb-3">
                                  <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/media.jpg" class="img-fluid" alt="">
                                </div>
                                <div class="content text-center">
                                  <h5 class="color-black fw-bold pb-2 md-2 pb-md-3 mb-md-3 border-bottom">3-day hands-on workshop on Generative AI at Sangam University</h5>
                                  <p>An insightful day at SOET as students explored the world of cyber safety and digital awareness.Learning, curiosity, and technology came together...</p>
                                  <a href="javascript:void(0);" class="theme-text-primary fw-medium text-decoration-none">Learn more</a>
                                </div>
                              </div>
                            </div>
                            <div class="col-12">
                              <ul class="pagination justify-content-center">
                                <li class="page-item">
                                  <a class="page-link prev" href="#" aria-label="Previous">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="10" height="12" viewBox="0 0 10 12" fill="none">
                                      <path d="M6.60156 11.9403L0.576563 6.19033L6.60156 0.465331H9.47656L3.42656 6.19033L9.47656 11.9403H6.60156Z" fill="black"></path>
                                    </svg>
                                  </a>
                                </li>
                                <li class="page-item active"><a class="page-link" href="#">1</a></li>
                                <li class="page-item"><a class="page-link" href="#">2</a></li>
                                <li class="page-item"><a class="page-link" href="#">3</a></li>
                                <li class="page-item">
                                  <a class="page-link next" href="#" aria-label="Next">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="10" height="12" viewBox="0 0 10 12" fill="none">
                                      <path d="M0.201563 0.465331H3.07656L9.12656 6.19033L3.07656 11.9403H0.201563L6.25156 6.19033L0.201563 0.465331Z" fill="black"></path>
                                    </svg>
                                  </a>
                                </li>
                              </ul>
                            </div>
                          </div>
                      </li>
                    </ul>
                  </div>
                  <div class="col-12 col-md-9">
                      <div class="exam-course-area coursesec p-4 d-none d-md-block bglight">
                        <div class="tab-content " id="myTabContent">
                          <div class="tab-pane fade show active" id="all-tab-pane">
                            <div class="row">
                              <div class="col-12 col-md-6 col-xl-4 intcourse pt-0 pb-3 px-2">
                                <div class="awardbox p-3 text-center d-block">
                                  <div class="image-box pb-3">
                                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/media.jpg" class="img-fluid" alt="">
                                  </div>
                                  <div class="content text-center">
                                    <h5 class="color-black fw-bold pb-2 md-2 pb-md-3 mb-md-3 border-bottom">3-day hands-on workshop on Generative AI at Sangam University</h5>
                                    <p>An insightful day at SOET as students explored the world of cyber safety and digital awareness.Learning, curiosity, and technology came together...</p>
                                    <a href="javascript:void(0);" class="theme-text-primary fw-medium text-decoration-none">Learn more</a>
                                  </div>
                                </div>
                              </div>
                              <div class="col-12 col-md-6 col-xl-4 intcourse pt-0 pb-3 px-2">
                                <div class="awardbox p-3 text-center d-block">
                                  <div class="image-box pb-3">
                                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/media.jpg" class="img-fluid" alt="">
                                  </div>
                                  <div class="content text-center">
                                    <h5 class="color-black fw-bold pb-2 md-2 pb-md-3 mb-md-3 border-bottom">3-day hands-on workshop on Generative AI at Sangam University</h5>
                                    <p>An insightful day at SOET as students explored the world of cyber safety and digital awareness.Learning, curiosity, and technology came together...</p>
                                    <a href="javascript:void(0);" class="theme-text-primary fw-medium text-decoration-none">Learn more</a>
                                  </div>
                                </div>
                              </div>
                              <div class="col-12 col-md-6 col-xl-4 intcourse pt-0 pb-3 px-2">
                                <div class="awardbox p-3 text-center d-block">
                                  <div class="image-box pb-3">
                                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/media.jpg" class="img-fluid" alt="">
                                  </div>
                                  <div class="content text-center">
                                    <h5 class="color-black fw-bold pb-2 md-2 pb-md-3 mb-md-3 border-bottom">3-day hands-on workshop on Generative AI at Sangam University</h5>
                                    <p>An insightful day at SOET as students explored the world of cyber safety and digital awareness.Learning, curiosity, and technology came together...</p>
                                    <a href="javascript:void(0);" class="theme-text-primary fw-medium text-decoration-none">Learn more</a>
                                  </div>
                                </div>
                              </div>
                              <div class="col-12 col-md-6 col-xl-4 intcourse pt-0 pb-3 px-2">
                                <div class="awardbox p-3 text-center d-block">
                                  <div class="image-box pb-3">
                                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/media.jpg" class="img-fluid" alt="">
                                  </div>
                                  <div class="content text-center">
                                    <h5 class="color-black fw-bold pb-2 md-2 pb-md-3 mb-md-3 border-bottom">3-day hands-on workshop on Generative AI at Sangam University</h5>
                                    <p>An insightful day at SOET as students explored the world of cyber safety and digital awareness.Learning, curiosity, and technology came together...</p>
                                    <a href="javascript:void(0);" class="theme-text-primary fw-medium text-decoration-none">Learn more</a>
                                  </div>
                                </div>
                              </div>
                              <div class="col-12 col-md-6 col-xl-4 intcourse pt-0 pb-3 px-2">
                                <div class="awardbox p-3 text-center d-block">
                                  <div class="image-box pb-3">
                                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/media.jpg" class="img-fluid" alt="">
                                  </div>
                                  <div class="content text-center">
                                    <h5 class="color-black fw-bold pb-2 md-2 pb-md-3 mb-md-3 border-bottom">3-day hands-on workshop on Generative AI at Sangam University</h5>
                                    <p>An insightful day at SOET as students explored the world of cyber safety and digital awareness.Learning, curiosity, and technology came together...</p>
                                    <a href="javascript:void(0);" class="theme-text-primary fw-medium text-decoration-none">Learn more</a>
                                  </div>
                                </div>
                              </div>
                              <div class="col-12 col-md-6 col-xl-4 intcourse pt-0 pb-3 px-2">
                                <div class="awardbox p-3 text-center d-block">
                                  <div class="image-box pb-3">
                                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/media.jpg" class="img-fluid" alt="">
                                  </div>
                                  <div class="content text-center">
                                    <h5 class="color-black fw-bold pb-2 md-2 pb-md-3 mb-md-3 border-bottom">3-day hands-on workshop on Generative AI at Sangam University</h5>
                                    <p>An insightful day at SOET as students explored the world of cyber safety and digital awareness.Learning, curiosity, and technology came together...</p>
                                    <a href="javascript:void(0);" class="theme-text-primary fw-medium text-decoration-none">Learn more</a>
                                  </div>
                                </div>
                              </div>
                              <div class="col-12 col-md-6 col-xl-4 intcourse pt-0 pb-3 px-2">
                                <div class="awardbox p-3 text-center d-block">
                                  <div class="image-box pb-3">
                                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/media.jpg" class="img-fluid" alt="">
                                  </div>
                                  <div class="content text-center">
                                    <h5 class="color-black fw-bold pb-2 md-2 pb-md-3 mb-md-3 border-bottom">3-day hands-on workshop on Generative AI at Sangam University</h5>
                                    <p>An insightful day at SOET as students explored the world of cyber safety and digital awareness.Learning, curiosity, and technology came together...</p>
                                    <a href="javascript:void(0);" class="theme-text-primary fw-medium text-decoration-none">Learn more</a>
                                  </div>
                                </div>
                              </div>
                              <div class="col-12 col-md-6 col-xl-4 intcourse pt-0 pb-3 px-2">
                                <div class="awardbox p-3 text-center d-block">
                                  <div class="image-box pb-3">
                                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/media.jpg" class="img-fluid" alt="">
                                  </div>
                                  <div class="content text-center">
                                    <h5 class="color-black fw-bold pb-2 md-2 pb-md-3 mb-md-3 border-bottom">3-day hands-on workshop on Generative AI at Sangam University</h5>
                                    <p>An insightful day at SOET as students explored the world of cyber safety and digital awareness.Learning, curiosity, and technology came together...</p>
                                    <a href="javascript:void(0);" class="theme-text-primary fw-medium text-decoration-none">Learn more</a>
                                  </div>
                                </div>
                              </div>
                              <div class="col-12 col-md-6 col-xl-4 intcourse pt-0 pb-3 px-2">
                                <div class="awardbox p-3 text-center d-block">
                                  <div class="image-box pb-3">
                                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/media.jpg" class="img-fluid" alt="">
                                  </div>
                                  <div class="content text-center">
                                    <h5 class="color-black fw-bold pb-2 md-2 pb-md-3 mb-md-3 border-bottom">3-day hands-on workshop on Generative AI at Sangam University</h5>
                                    <p>An insightful day at SOET as students explored the world of cyber safety and digital awareness.Learning, curiosity, and technology came together...</p>
                                    <a href="javascript:void(0);" class="theme-text-primary fw-medium text-decoration-none">Learn more</a>
                                  </div>
                                </div>
                              </div>
                              <div class="col-12">
                                <ul class="pagination justify-content-center">
                                  <li class="page-item">
                                    <a class="page-link prev" href="#" aria-label="Previous">
                                      <svg xmlns="http://www.w3.org/2000/svg" width="10" height="12" viewBox="0 0 10 12" fill="none">
                                        <path d="M6.60156 11.9403L0.576563 6.19033L6.60156 0.465331H9.47656L3.42656 6.19033L9.47656 11.9403H6.60156Z" fill="black"></path>
                                      </svg>
                                    </a>
                                  </li>
                                  <li class="page-item active"><a class="page-link" href="#">1</a></li>
                                  <li class="page-item"><a class="page-link" href="#">2</a></li>
                                  <li class="page-item"><a class="page-link" href="#">3</a></li>
                                  <li class="page-item">
                                    <a class="page-link next" href="#" aria-label="Next">
                                      <svg xmlns="http://www.w3.org/2000/svg" width="10" height="12" viewBox="0 0 10 12" fill="none">
                                        <path d="M0.201563 0.465331H3.07656L9.12656 6.19033L3.07656 11.9403H0.201563L6.25156 6.19033L0.201563 0.465331Z" fill="black"></path>
                                      </svg>
                                    </a>
                                  </li>
                                </ul>
                              </div>
                            </div>
                          </div>
                          <div class="tab-pane fade" id="programming-tab-pane">
                            <div class="row">
                              <div class="col-12 col-md-6 col-xl-4 intcourse pt-0 pb-3 px-2">
                                <div class="awardbox p-3 text-center d-block">
                                  <div class="image-box pb-3">
                                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/media.jpg" class="img-fluid" alt="">
                                  </div>
                                  <div class="content text-center">
                                    <h5 class="color-black fw-bold pb-2 md-2 pb-md-3 mb-md-3 border-bottom">3-day hands-on workshop on Generative AI at Sangam University</h5>
                                    <p>An insightful day at SOET as students explored the world of cyber safety and digital awareness.Learning, curiosity, and technology came together...</p>
                                    <a href="javascript:void(0);" class="theme-text-primary fw-medium text-decoration-none">Learn more</a>
                                  </div>
                                </div>
                              </div>
                              <div class="col-12 col-md-6 col-xl-4 intcourse pt-0 pb-3 px-2">
                                <div class="awardbox p-3 text-center d-block">
                                  <div class="image-box pb-3">
                                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/media.jpg" class="img-fluid" alt="">
                                  </div>
                                  <div class="content text-center">
                                    <h5 class="color-black fw-bold pb-2 md-2 pb-md-3 mb-md-3 border-bottom">3-day hands-on workshop on Generative AI at Sangam University</h5>
                                    <p>An insightful day at SOET as students explored the world of cyber safety and digital awareness.Learning, curiosity, and technology came together...</p>
                                    <a href="javascript:void(0);" class="theme-text-primary fw-medium text-decoration-none">Learn more</a>
                                  </div>
                                </div>
                              </div>
                              <div class="col-12 col-md-6 col-xl-4 intcourse pt-0 pb-3 px-2">
                                <div class="awardbox p-3 text-center d-block">
                                  <div class="image-box pb-3">
                                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/media.jpg" class="img-fluid" alt="">
                                  </div>
                                  <div class="content text-center">
                                    <h5 class="color-black fw-bold pb-2 md-2 pb-md-3 mb-md-3 border-bottom">3-day hands-on workshop on Generative AI at Sangam University</h5>
                                    <p>An insightful day at SOET as students explored the world of cyber safety and digital awareness.Learning, curiosity, and technology came together...</p>
                                    <a href="javascript:void(0);" class="theme-text-primary fw-medium text-decoration-none">Learn more</a>
                                  </div>
                                </div>
                              </div>
                              <div class="col-12 col-md-6 col-xl-4 intcourse pt-0 pb-3 px-2">
                                <div class="awardbox p-3 text-center d-block">
                                  <div class="image-box pb-3">
                                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/media.jpg" class="img-fluid" alt="">
                                  </div>
                                  <div class="content text-center">
                                    <h5 class="color-black fw-bold pb-2 md-2 pb-md-3 mb-md-3 border-bottom">3-day hands-on workshop on Generative AI at Sangam University</h5>
                                    <p>An insightful day at SOET as students explored the world of cyber safety and digital awareness.Learning, curiosity, and technology came together...</p>
                                    <a href="javascript:void(0);" class="theme-text-primary fw-medium text-decoration-none">Learn more</a>
                                  </div>
                                </div>
                              </div>
                              <div class="col-12 col-md-6 col-xl-4 intcourse pt-0 pb-3 px-2">
                                <div class="awardbox p-3 text-center d-block">
                                  <div class="image-box pb-3">
                                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/media.jpg" class="img-fluid" alt="">
                                  </div>
                                  <div class="content text-center">
                                    <h5 class="color-black fw-bold pb-2 md-2 pb-md-3 mb-md-3 border-bottom">3-day hands-on workshop on Generative AI at Sangam University</h5>
                                    <p>An insightful day at SOET as students explored the world of cyber safety and digital awareness.Learning, curiosity, and technology came together...</p>
                                    <a href="javascript:void(0);" class="theme-text-primary fw-medium text-decoration-none">Learn more</a>
                                  </div>
                                </div>
                              </div>
                              <div class="col-12 col-md-6 col-xl-4 intcourse pt-0 pb-3 px-2">
                                <div class="awardbox p-3 text-center d-block">
                                  <div class="image-box pb-3">
                                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/media.jpg" class="img-fluid" alt="">
                                  </div>
                                  <div class="content text-center">
                                    <h5 class="color-black fw-bold pb-2 md-2 pb-md-3 mb-md-3 border-bottom">3-day hands-on workshop on Generative AI at Sangam University</h5>
                                    <p>An insightful day at SOET as students explored the world of cyber safety and digital awareness.Learning, curiosity, and technology came together...</p>
                                    <a href="javascript:void(0);" class="theme-text-primary fw-medium text-decoration-none">Learn more</a>
                                  </div>
                                </div>
                              </div>
                              <div class="col-12 col-md-6 col-xl-4 intcourse pt-0 pb-3 px-2">
                                <div class="awardbox p-3 text-center d-block">
                                  <div class="image-box pb-3">
                                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/media.jpg" class="img-fluid" alt="">
                                  </div>
                                  <div class="content text-center">
                                    <h5 class="color-black fw-bold pb-2 md-2 pb-md-3 mb-md-3 border-bottom">3-day hands-on workshop on Generative AI at Sangam University</h5>
                                    <p>An insightful day at SOET as students explored the world of cyber safety and digital awareness.Learning, curiosity, and technology came together...</p>
                                    <a href="javascript:void(0);" class="theme-text-primary fw-medium text-decoration-none">Learn more</a>
                                  </div>
                                </div>
                              </div>
                              <div class="col-12 col-md-6 col-xl-4 intcourse pt-0 pb-3 px-2">
                                <div class="awardbox p-3 text-center d-block">
                                  <div class="image-box pb-3">
                                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/media.jpg" class="img-fluid" alt="">
                                  </div>
                                  <div class="content text-center">
                                    <h5 class="color-black fw-bold pb-2 md-2 pb-md-3 mb-md-3 border-bottom">3-day hands-on workshop on Generative AI at Sangam University</h5>
                                    <p>An insightful day at SOET as students explored the world of cyber safety and digital awareness.Learning, curiosity, and technology came together...</p>
                                    <a href="javascript:void(0);" class="theme-text-primary fw-medium text-decoration-none">Learn more</a>
                                  </div>
                                </div>
                              </div>
                              <div class="col-12 col-md-6 col-xl-4 intcourse pt-0 pb-3 px-2">
                                <div class="awardbox p-3 text-center d-block">
                                  <div class="image-box pb-3">
                                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/media.jpg" class="img-fluid" alt="">
                                  </div>
                                  <div class="content text-center">
                                    <h5 class="color-black fw-bold pb-2 md-2 pb-md-3 mb-md-3 border-bottom">3-day hands-on workshop on Generative AI at Sangam University</h5>
                                    <p>An insightful day at SOET as students explored the world of cyber safety and digital awareness.Learning, curiosity, and technology came together...</p>
                                    <a href="javascript:void(0);" class="theme-text-primary fw-medium text-decoration-none">Learn more</a>
                                  </div>
                                </div>
                              </div>
                              <div class="col-12">
                                <ul class="pagination justify-content-center">
                                  <li class="page-item">
                                    <a class="page-link prev" href="#" aria-label="Previous">
                                      <svg xmlns="http://www.w3.org/2000/svg" width="10" height="12" viewBox="0 0 10 12" fill="none">
                                        <path d="M6.60156 11.9403L0.576563 6.19033L6.60156 0.465331H9.47656L3.42656 6.19033L9.47656 11.9403H6.60156Z" fill="black"></path>
                                      </svg>
                                    </a>
                                  </li>
                                  <li class="page-item active"><a class="page-link" href="#">1</a></li>
                                  <li class="page-item"><a class="page-link" href="#">2</a></li>
                                  <li class="page-item"><a class="page-link" href="#">3</a></li>
                                  <li class="page-item">
                                    <a class="page-link next" href="#" aria-label="Next">
                                      <svg xmlns="http://www.w3.org/2000/svg" width="10" height="12" viewBox="0 0 10 12" fill="none">
                                        <path d="M0.201563 0.465331H3.07656L9.12656 6.19033L3.07656 11.9403H0.201563L6.25156 6.19033L0.201563 0.465331Z" fill="black"></path>
                                      </svg>
                                    </a>
                                  </li>
                                </ul>
                              </div>
                            </div>
                          </div>
                          <div class="tab-pane fade" id="webdevelopment-tab-pane">
                            <div class="row">
                              <div class="col-12 col-md-6 col-xl-4 intcourse pt-0 pb-3 px-2">
                                <div class="awardbox p-3 text-center d-block">
                                  <div class="image-box pb-3">
                                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/media.jpg" class="img-fluid" alt="">
                                  </div>
                                  <div class="content text-center">
                                    <h5 class="color-black fw-bold pb-2 md-2 pb-md-3 mb-md-3 border-bottom">3-day hands-on workshop on Generative AI at Sangam University</h5>
                                    <p>An insightful day at SOET as students explored the world of cyber safety and digital awareness.Learning, curiosity, and technology came together...</p>
                                    <a href="javascript:void(0);" class="theme-text-primary fw-medium text-decoration-none">Learn more</a>
                                  </div>
                                </div>
                              </div>
                              <div class="col-12 col-md-6 col-xl-4 intcourse pt-0 pb-3 px-2">
                                <div class="awardbox p-3 text-center d-block">
                                  <div class="image-box pb-3">
                                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/media.jpg" class="img-fluid" alt="">
                                  </div>
                                  <div class="content text-center">
                                    <h5 class="color-black fw-bold pb-2 md-2 pb-md-3 mb-md-3 border-bottom">3-day hands-on workshop on Generative AI at Sangam University</h5>
                                    <p>An insightful day at SOET as students explored the world of cyber safety and digital awareness.Learning, curiosity, and technology came together...</p>
                                    <a href="javascript:void(0);" class="theme-text-primary fw-medium text-decoration-none">Learn more</a>
                                  </div>
                                </div>
                              </div>
                              <div class="col-12 col-md-6 col-xl-4 intcourse pt-0 pb-3 px-2">
                                <div class="awardbox p-3 text-center d-block">
                                  <div class="image-box pb-3">
                                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/media.jpg" class="img-fluid" alt="">
                                  </div>
                                  <div class="content text-center">
                                    <h5 class="color-black fw-bold pb-2 md-2 pb-md-3 mb-md-3 border-bottom">3-day hands-on workshop on Generative AI at Sangam University</h5>
                                    <p>An insightful day at SOET as students explored the world of cyber safety and digital awareness.Learning, curiosity, and technology came together...</p>
                                    <a href="javascript:void(0);" class="theme-text-primary fw-medium text-decoration-none">Learn more</a>
                                  </div>
                                </div>
                              </div>
                              <div class="col-12 col-md-6 col-xl-4 intcourse pt-0 pb-3 px-2">
                                <div class="awardbox p-3 text-center d-block">
                                  <div class="image-box pb-3">
                                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/media.jpg" class="img-fluid" alt="">
                                  </div>
                                  <div class="content text-center">
                                    <h5 class="color-black fw-bold pb-2 md-2 pb-md-3 mb-md-3 border-bottom">3-day hands-on workshop on Generative AI at Sangam University</h5>
                                    <p>An insightful day at SOET as students explored the world of cyber safety and digital awareness.Learning, curiosity, and technology came together...</p>
                                    <a href="javascript:void(0);" class="theme-text-primary fw-medium text-decoration-none">Learn more</a>
                                  </div>
                                </div>
                              </div>
                              <div class="col-12 col-md-6 col-xl-4 intcourse pt-0 pb-3 px-2">
                                <div class="awardbox p-3 text-center d-block">
                                  <div class="image-box pb-3">
                                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/media.jpg" class="img-fluid" alt="">
                                  </div>
                                  <div class="content text-center">
                                    <h5 class="color-black fw-bold pb-2 md-2 pb-md-3 mb-md-3 border-bottom">3-day hands-on workshop on Generative AI at Sangam University</h5>
                                    <p>An insightful day at SOET as students explored the world of cyber safety and digital awareness.Learning, curiosity, and technology came together...</p>
                                    <a href="javascript:void(0);" class="theme-text-primary fw-medium text-decoration-none">Learn more</a>
                                  </div>
                                </div>
                              </div>
                              <div class="col-12 col-md-6 col-xl-4 intcourse pt-0 pb-3 px-2">
                                <div class="awardbox p-3 text-center d-block">
                                  <div class="image-box pb-3">
                                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/media.jpg" class="img-fluid" alt="">
                                  </div>
                                  <div class="content text-center">
                                    <h5 class="color-black fw-bold pb-2 md-2 pb-md-3 mb-md-3 border-bottom">3-day hands-on workshop on Generative AI at Sangam University</h5>
                                    <p>An insightful day at SOET as students explored the world of cyber safety and digital awareness.Learning, curiosity, and technology came together...</p>
                                    <a href="javascript:void(0);" class="theme-text-primary fw-medium text-decoration-none">Learn more</a>
                                  </div>
                                </div>
                              </div>
                              <div class="col-12 col-md-6 col-xl-4 intcourse pt-0 pb-3 px-2">
                                <div class="awardbox p-3 text-center d-block">
                                  <div class="image-box pb-3">
                                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/media.jpg" class="img-fluid" alt="">
                                  </div>
                                  <div class="content text-center">
                                    <h5 class="color-black fw-bold pb-2 md-2 pb-md-3 mb-md-3 border-bottom">3-day hands-on workshop on Generative AI at Sangam University</h5>
                                    <p>An insightful day at SOET as students explored the world of cyber safety and digital awareness.Learning, curiosity, and technology came together...</p>
                                    <a href="javascript:void(0);" class="theme-text-primary fw-medium text-decoration-none">Learn more</a>
                                  </div>
                                </div>
                              </div>
                              <div class="col-12 col-md-6 col-xl-4 intcourse pt-0 pb-3 px-2">
                                <div class="awardbox p-3 text-center d-block">
                                  <div class="image-box pb-3">
                                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/media.jpg" class="img-fluid" alt="">
                                  </div>
                                  <div class="content text-center">
                                    <h5 class="color-black fw-bold pb-2 md-2 pb-md-3 mb-md-3 border-bottom">3-day hands-on workshop on Generative AI at Sangam University</h5>
                                    <p>An insightful day at SOET as students explored the world of cyber safety and digital awareness.Learning, curiosity, and technology came together...</p>
                                    <a href="javascript:void(0);" class="theme-text-primary fw-medium text-decoration-none">Learn more</a>
                                  </div>
                                </div>
                              </div>
                              <div class="col-12 col-md-6 col-xl-4 intcourse pt-0 pb-3 px-2">
                                <div class="awardbox p-3 text-center d-block">
                                  <div class="image-box pb-3">
                                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/media.jpg" class="img-fluid" alt="">
                                  </div>
                                  <div class="content text-center">
                                    <h5 class="color-black fw-bold pb-2 md-2 pb-md-3 mb-md-3 border-bottom">3-day hands-on workshop on Generative AI at Sangam University</h5>
                                    <p>An insightful day at SOET as students explored the world of cyber safety and digital awareness.Learning, curiosity, and technology came together...</p>
                                    <a href="javascript:void(0);" class="theme-text-primary fw-medium text-decoration-none">Learn more</a>
                                  </div>
                                </div>
                              </div>
                              <div class="col-12">
                                <ul class="pagination justify-content-center">
                                  <li class="page-item">
                                    <a class="page-link prev" href="#" aria-label="Previous">
                                      <svg xmlns="http://www.w3.org/2000/svg" width="10" height="12" viewBox="0 0 10 12" fill="none">
                                        <path d="M6.60156 11.9403L0.576563 6.19033L6.60156 0.465331H9.47656L3.42656 6.19033L9.47656 11.9403H6.60156Z" fill="black"></path>
                                      </svg>
                                    </a>
                                  </li>
                                  <li class="page-item active"><a class="page-link" href="#">1</a></li>
                                  <li class="page-item"><a class="page-link" href="#">2</a></li>
                                  <li class="page-item"><a class="page-link" href="#">3</a></li>
                                  <li class="page-item">
                                    <a class="page-link next" href="#" aria-label="Next">
                                      <svg xmlns="http://www.w3.org/2000/svg" width="10" height="12" viewBox="0 0 10 12" fill="none">
                                        <path d="M0.201563 0.465331H3.07656L9.12656 6.19033L3.07656 11.9403H0.201563L6.25156 6.19033L0.201563 0.465331Z" fill="black"></path>
                                      </svg>
                                    </a>
                                  </li>
                                </ul>
                              </div>
                            </div>
                          </div>
                          <div class="tab-pane fade" id="analytics-tab-pane">
                            <div class="row">
                              <div class="col-12 col-md-6 col-xl-4 intcourse pt-0 pb-3 px-2">
                                <div class="awardbox p-3 text-center d-block">
                                  <div class="image-box pb-3">
                                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/media.jpg" class="img-fluid" alt="">
                                  </div>
                                  <div class="content text-center">
                                    <h5 class="color-black fw-bold pb-2 md-2 pb-md-3 mb-md-3 border-bottom">3-day hands-on workshop on Generative AI at Sangam University</h5>
                                    <p>An insightful day at SOET as students explored the world of cyber safety and digital awareness.Learning, curiosity, and technology came together...</p>
                                    <a href="javascript:void(0);" class="theme-text-primary fw-medium text-decoration-none">Learn more</a>
                                  </div>
                                </div>
                              </div>
                              <div class="col-12 col-md-6 col-xl-4 intcourse pt-0 pb-3 px-2">
                                <div class="awardbox p-3 text-center d-block">
                                  <div class="image-box pb-3">
                                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/media.jpg" class="img-fluid" alt="">
                                  </div>
                                  <div class="content text-center">
                                    <h5 class="color-black fw-bold pb-2 md-2 pb-md-3 mb-md-3 border-bottom">3-day hands-on workshop on Generative AI at Sangam University</h5>
                                    <p>An insightful day at SOET as students explored the world of cyber safety and digital awareness.Learning, curiosity, and technology came together...</p>
                                    <a href="javascript:void(0);" class="theme-text-primary fw-medium text-decoration-none">Learn more</a>
                                  </div>
                                </div>
                              </div>
                              <div class="col-12 col-md-6 col-xl-4 intcourse pt-0 pb-3 px-2">
                                <div class="awardbox p-3 text-center d-block">
                                  <div class="image-box pb-3">
                                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/media.jpg" class="img-fluid" alt="">
                                  </div>
                                  <div class="content text-center">
                                    <h5 class="color-black fw-bold pb-2 md-2 pb-md-3 mb-md-3 border-bottom">3-day hands-on workshop on Generative AI at Sangam University</h5>
                                    <p>An insightful day at SOET as students explored the world of cyber safety and digital awareness.Learning, curiosity, and technology came together...</p>
                                    <a href="javascript:void(0);" class="theme-text-primary fw-medium text-decoration-none">Learn more</a>
                                  </div>
                                </div>
                              </div>
                              <div class="col-12 col-md-6 col-xl-4 intcourse pt-0 pb-3 px-2">
                                <div class="awardbox p-3 text-center d-block">
                                  <div class="image-box pb-3">
                                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/media.jpg" class="img-fluid" alt="">
                                  </div>
                                  <div class="content text-center">
                                    <h5 class="color-black fw-bold pb-2 md-2 pb-md-3 mb-md-3 border-bottom">3-day hands-on workshop on Generative AI at Sangam University</h5>
                                    <p>An insightful day at SOET as students explored the world of cyber safety and digital awareness.Learning, curiosity, and technology came together...</p>
                                    <a href="javascript:void(0);" class="theme-text-primary fw-medium text-decoration-none">Learn more</a>
                                  </div>
                                </div>
                              </div>
                              <div class="col-12 col-md-6 col-xl-4 intcourse pt-0 pb-3 px-2">
                                <div class="awardbox p-3 text-center d-block">
                                  <div class="image-box pb-3">
                                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/media.jpg" class="img-fluid" alt="">
                                  </div>
                                  <div class="content text-center">
                                    <h5 class="color-black fw-bold pb-2 md-2 pb-md-3 mb-md-3 border-bottom">3-day hands-on workshop on Generative AI at Sangam University</h5>
                                    <p>An insightful day at SOET as students explored the world of cyber safety and digital awareness.Learning, curiosity, and technology came together...</p>
                                    <a href="javascript:void(0);" class="theme-text-primary fw-medium text-decoration-none">Learn more</a>
                                  </div>
                                </div>
                              </div>
                              <div class="col-12 col-md-6 col-xl-4 intcourse pt-0 pb-3 px-2">
                                <div class="awardbox p-3 text-center d-block">
                                  <div class="image-box pb-3">
                                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/media.jpg" class="img-fluid" alt="">
                                  </div>
                                  <div class="content text-center">
                                    <h5 class="color-black fw-bold pb-2 md-2 pb-md-3 mb-md-3 border-bottom">3-day hands-on workshop on Generative AI at Sangam University</h5>
                                    <p>An insightful day at SOET as students explored the world of cyber safety and digital awareness.Learning, curiosity, and technology came together...</p>
                                    <a href="javascript:void(0);" class="theme-text-primary fw-medium text-decoration-none">Learn more</a>
                                  </div>
                                </div>
                              </div>
                              <div class="col-12 col-md-6 col-xl-4 intcourse pt-0 pb-3 px-2">
                                <div class="awardbox p-3 text-center d-block">
                                  <div class="image-box pb-3">
                                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/media.jpg" class="img-fluid" alt="">
                                  </div>
                                  <div class="content text-center">
                                    <h5 class="color-black fw-bold pb-2 md-2 pb-md-3 mb-md-3 border-bottom">3-day hands-on workshop on Generative AI at Sangam University</h5>
                                    <p>An insightful day at SOET as students explored the world of cyber safety and digital awareness.Learning, curiosity, and technology came together...</p>
                                    <a href="javascript:void(0);" class="theme-text-primary fw-medium text-decoration-none">Learn more</a>
                                  </div>
                                </div>
                              </div>
                              <div class="col-12 col-md-6 col-xl-4 intcourse pt-0 pb-3 px-2">
                                <div class="awardbox p-3 text-center d-block">
                                  <div class="image-box pb-3">
                                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/media.jpg" class="img-fluid" alt="">
                                  </div>
                                  <div class="content text-center">
                                    <h5 class="color-black fw-bold pb-2 md-2 pb-md-3 mb-md-3 border-bottom">3-day hands-on workshop on Generative AI at Sangam University</h5>
                                    <p>An insightful day at SOET as students explored the world of cyber safety and digital awareness.Learning, curiosity, and technology came together...</p>
                                    <a href="javascript:void(0);" class="theme-text-primary fw-medium text-decoration-none">Learn more</a>
                                  </div>
                                </div>
                              </div>
                              <div class="col-12 col-md-6 col-xl-4 intcourse pt-0 pb-3 px-2">
                                <div class="awardbox p-3 text-center d-block">
                                  <div class="image-box pb-3">
                                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/media.jpg" class="img-fluid" alt="">
                                  </div>
                                  <div class="content text-center">
                                    <h5 class="color-black fw-bold pb-2 md-2 pb-md-3 mb-md-3 border-bottom">3-day hands-on workshop on Generative AI at Sangam University</h5>
                                    <p>An insightful day at SOET as students explored the world of cyber safety and digital awareness.Learning, curiosity, and technology came together...</p>
                                    <a href="javascript:void(0);" class="theme-text-primary fw-medium text-decoration-none">Learn more</a>
                                  </div>
                                </div>
                              </div>
                              <div class="col-12">
                                <ul class="pagination justify-content-center">
                                  <li class="page-item">
                                    <a class="page-link prev" href="#" aria-label="Previous">
                                      <svg xmlns="http://www.w3.org/2000/svg" width="10" height="12" viewBox="0 0 10 12" fill="none">
                                        <path d="M6.60156 11.9403L0.576563 6.19033L6.60156 0.465331H9.47656L3.42656 6.19033L9.47656 11.9403H6.60156Z" fill="black"></path>
                                      </svg>
                                    </a>
                                  </li>
                                  <li class="page-item active"><a class="page-link" href="#">1</a></li>
                                  <li class="page-item"><a class="page-link" href="#">2</a></li>
                                  <li class="page-item"><a class="page-link" href="#">3</a></li>
                                  <li class="page-item">
                                    <a class="page-link next" href="#" aria-label="Next">
                                      <svg xmlns="http://www.w3.org/2000/svg" width="10" height="12" viewBox="0 0 10 12" fill="none">
                                        <path d="M0.201563 0.465331H3.07656L9.12656 6.19033L3.07656 11.9403H0.201563L6.25156 6.19033L0.201563 0.465331Z" fill="black"></path>
                                      </svg>
                                    </a>
                                  </li>
                                </ul>
                              </div>
                            </div>
                          </div>
                          <div class="tab-pane fade" id="devops-tab-pane">
                            <div class="row">
                              <div class="col-12 col-md-6 col-xl-4 intcourse pt-0 pb-3 px-2">
                                <div class="awardbox p-3 text-center d-block">
                                  <div class="image-box pb-3">
                                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/media.jpg" class="img-fluid" alt="">
                                  </div>
                                  <div class="content text-center">
                                    <h5 class="color-black fw-bold pb-2 md-2 pb-md-3 mb-md-3 border-bottom">3-day hands-on workshop on Generative AI at Sangam University</h5>
                                    <p>An insightful day at SOET as students explored the world of cyber safety and digital awareness.Learning, curiosity, and technology came together...</p>
                                    <a href="javascript:void(0);" class="theme-text-primary fw-medium text-decoration-none">Learn more</a>
                                  </div>
                                </div>
                              </div>
                              <div class="col-12 col-md-6 col-xl-4 intcourse pt-0 pb-3 px-2">
                                <div class="awardbox p-3 text-center d-block">
                                  <div class="image-box pb-3">
                                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/media.jpg" class="img-fluid" alt="">
                                  </div>
                                  <div class="content text-center">
                                    <h5 class="color-black fw-bold pb-2 md-2 pb-md-3 mb-md-3 border-bottom">3-day hands-on workshop on Generative AI at Sangam University</h5>
                                    <p>An insightful day at SOET as students explored the world of cyber safety and digital awareness.Learning, curiosity, and technology came together...</p>
                                    <a href="javascript:void(0);" class="theme-text-primary fw-medium text-decoration-none">Learn more</a>
                                  </div>
                                </div>
                              </div>
                              <div class="col-12 col-md-6 col-xl-4 intcourse pt-0 pb-3 px-2">
                                <div class="awardbox p-3 text-center d-block">
                                  <div class="image-box pb-3">
                                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/media.jpg" class="img-fluid" alt="">
                                  </div>
                                  <div class="content text-center">
                                    <h5 class="color-black fw-bold pb-2 md-2 pb-md-3 mb-md-3 border-bottom">3-day hands-on workshop on Generative AI at Sangam University</h5>
                                    <p>An insightful day at SOET as students explored the world of cyber safety and digital awareness.Learning, curiosity, and technology came together...</p>
                                    <a href="javascript:void(0);" class="theme-text-primary fw-medium text-decoration-none">Learn more</a>
                                  </div>
                                </div>
                              </div>
                              <div class="col-12 col-md-6 col-xl-4 intcourse pt-0 pb-3 px-2">
                                <div class="awardbox p-3 text-center d-block">
                                  <div class="image-box pb-3">
                                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/media.jpg" class="img-fluid" alt="">
                                  </div>
                                  <div class="content text-center">
                                    <h5 class="color-black fw-bold pb-2 md-2 pb-md-3 mb-md-3 border-bottom">3-day hands-on workshop on Generative AI at Sangam University</h5>
                                    <p>An insightful day at SOET as students explored the world of cyber safety and digital awareness.Learning, curiosity, and technology came together...</p>
                                    <a href="javascript:void(0);" class="theme-text-primary fw-medium text-decoration-none">Learn more</a>
                                  </div>
                                </div>
                              </div>
                              <div class="col-12 col-md-6 col-xl-4 intcourse pt-0 pb-3 px-2">
                                <div class="awardbox p-3 text-center d-block">
                                  <div class="image-box pb-3">
                                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/media.jpg" class="img-fluid" alt="">
                                  </div>
                                  <div class="content text-center">
                                    <h5 class="color-black fw-bold pb-2 md-2 pb-md-3 mb-md-3 border-bottom">3-day hands-on workshop on Generative AI at Sangam University</h5>
                                    <p>An insightful day at SOET as students explored the world of cyber safety and digital awareness.Learning, curiosity, and technology came together...</p>
                                    <a href="javascript:void(0);" class="theme-text-primary fw-medium text-decoration-none">Learn more</a>
                                  </div>
                                </div>
                              </div>
                              <div class="col-12 col-md-6 col-xl-4 intcourse pt-0 pb-3 px-2">
                                <div class="awardbox p-3 text-center d-block">
                                  <div class="image-box pb-3">
                                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/media.jpg" class="img-fluid" alt="">
                                  </div>
                                  <div class="content text-center">
                                    <h5 class="color-black fw-bold pb-2 md-2 pb-md-3 mb-md-3 border-bottom">3-day hands-on workshop on Generative AI at Sangam University</h5>
                                    <p>An insightful day at SOET as students explored the world of cyber safety and digital awareness.Learning, curiosity, and technology came together...</p>
                                    <a href="javascript:void(0);" class="theme-text-primary fw-medium text-decoration-none">Learn more</a>
                                  </div>
                                </div>
                              </div>
                              <div class="col-12 col-md-6 col-xl-4 intcourse pt-0 pb-3 px-2">
                                <div class="awardbox p-3 text-center d-block">
                                  <div class="image-box pb-3">
                                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/media.jpg" class="img-fluid" alt="">
                                  </div>
                                  <div class="content text-center">
                                    <h5 class="color-black fw-bold pb-2 md-2 pb-md-3 mb-md-3 border-bottom">3-day hands-on workshop on Generative AI at Sangam University</h5>
                                    <p>An insightful day at SOET as students explored the world of cyber safety and digital awareness.Learning, curiosity, and technology came together...</p>
                                    <a href="javascript:void(0);" class="theme-text-primary fw-medium text-decoration-none">Learn more</a>
                                  </div>
                                </div>
                              </div>
                              <div class="col-12 col-md-6 col-xl-4 intcourse pt-0 pb-3 px-2">
                                <div class="awardbox p-3 text-center d-block">
                                  <div class="image-box pb-3">
                                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/media.jpg" class="img-fluid" alt="">
                                  </div>
                                  <div class="content text-center">
                                    <h5 class="color-black fw-bold pb-2 md-2 pb-md-3 mb-md-3 border-bottom">3-day hands-on workshop on Generative AI at Sangam University</h5>
                                    <p>An insightful day at SOET as students explored the world of cyber safety and digital awareness.Learning, curiosity, and technology came together...</p>
                                    <a href="javascript:void(0);" class="theme-text-primary fw-medium text-decoration-none">Learn more</a>
                                  </div>
                                </div>
                              </div>
                              <div class="col-12 col-md-6 col-xl-4 intcourse pt-0 pb-3 px-2">
                                <div class="awardbox p-3 text-center d-block">
                                  <div class="image-box pb-3">
                                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/media.jpg" class="img-fluid" alt="">
                                  </div>
                                  <div class="content text-center">
                                    <h5 class="color-black fw-bold pb-2 md-2 pb-md-3 mb-md-3 border-bottom">3-day hands-on workshop on Generative AI at Sangam University</h5>
                                    <p>An insightful day at SOET as students explored the world of cyber safety and digital awareness.Learning, curiosity, and technology came together...</p>
                                    <a href="javascript:void(0);" class="theme-text-primary fw-medium text-decoration-none">Learn more</a>
                                  </div>
                                </div>
                              </div>
                              <div class="col-12">
                                <ul class="pagination justify-content-center">
                                  <li class="page-item">
                                    <a class="page-link prev" href="#" aria-label="Previous">
                                      <svg xmlns="http://www.w3.org/2000/svg" width="10" height="12" viewBox="0 0 10 12" fill="none">
                                        <path d="M6.60156 11.9403L0.576563 6.19033L6.60156 0.465331H9.47656L3.42656 6.19033L9.47656 11.9403H6.60156Z" fill="black"></path>
                                      </svg>
                                    </a>
                                  </li>
                                  <li class="page-item active"><a class="page-link" href="#">1</a></li>
                                  <li class="page-item"><a class="page-link" href="#">2</a></li>
                                  <li class="page-item"><a class="page-link" href="#">3</a></li>
                                  <li class="page-item">
                                    <a class="page-link next" href="#" aria-label="Next">
                                      <svg xmlns="http://www.w3.org/2000/svg" width="10" height="12" viewBox="0 0 10 12" fill="none">
                                        <path d="M0.201563 0.465331H3.07656L9.12656 6.19033L3.07656 11.9403H0.201563L6.25156 6.19033L0.201563 0.465331Z" fill="black"></path>
                                      </svg>
                                    </a>
                                  </li>
                                </ul>
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
        </div> -->
      </div>
<?php
get_footer();
?>