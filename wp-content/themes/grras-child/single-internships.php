	<?php
	get_header();
	$banner = get_field('banner');
	?>
	<!--start from here-->


		<!-- breadcrumb -->
		<nav aria-label="breadcrumb" class="breadcrumb bglight2">
		  <div class="container">
		    <ol class="breadcrumb override">
		      <li class="breadcrumb-item"><a href="<?php echo site_url(); ?>">Home</a></li>
		      <li class="breadcrumb-item"><a href="<?php echo site_url('internship'); ?>">Interships</a></li>
		      <li class="breadcrumb-item active" aria-current="page"><?php echo get_the_title(); ?></li>
		    </ol>
		  </div>
		</nav>

		<!-- Learn today -->
	    <div class="inten-banner academy-section bg-theme-light section-padding"  style="padding-bottom: 150px; background-image: url('<?php echo get_stylesheet_directory_uri(); ?>/images/academy-vector.png');">
	      <div class="container">
	        <div class="row justify-content-between">
	          <div class="col-lg-6 wow fadeInLeft">
        <?php if(have_rows('banner_banner_tags')): ?>
          <ul class="list-unstyled">
            <?php while(have_rows('banner_banner_tags')): the_row();
              $tag = get_sub_field('tag');
            ?>
            <li class="list-inline-item">
              <span class="bg-white-sm p-2 rounded-1 theme-text-primary fw-semibold">
                <?php echo $tag; ?>
              </span>
            </li>
            <?php endwhile; ?>
          </ul>
        <?php endif; ?>
	            <h1 class="fw-bold"><?php echo $banner['title']; ?></h1>
	            <p><?php echo $banner['short_description']; ?></p>

	            <div class="my-4 my-lg-5">
					<div class="lang float-start me-2"><?php echo $banner['sub_tiltle']; ?> </div>
					<div class="owl-carousel intslid">
						<?php foreach($banner['points'] as $item): ?>
						<div class="item"><div class="subtext text-gradient-2 text-start"><?php echo $item['point']; ?></div></div>
						<?php endforeach; ?>
					</div>
				</div>
				<div class="clearfix"></div>
	            <a href="#" class="align-items-center btn btn-primary btnwith-icon-sm d-inline-flex justify-content-center p-2 rounded-2 text-center" data-bs-toggle="modal" data-bs-target="#exampleModal5">
					<span class="pe-3 ps-2">Register For Free Demo</span>
					<span class="btn-icon d-inline-flex justify-content-center align-items-center">
						<svg xmlns="http://www.w3.org/2000/svg" width="20px" height="20px" viewBox="0 0 23 23" fill="none">
						<path d="M6.21305 7.32844V6.23463C6.23791 5.76231 6.6108 5.38942 7.05827 5.38942L16.7285 5.36456C17.2008 5.38942 17.5737 5.76231 17.5737 6.20977V15.9049C17.5737 16.3523 17.2008 16.7252 16.7285 16.7501H15.6347C15.1624 16.7252 14.7895 16.3523 14.7646 15.88L14.9138 10.0132L7.77919 17.1478C7.43116 17.4959 6.93397 17.4959 6.58594 17.1478L5.79045 16.3523C5.46728 16.0292 5.44242 15.5071 5.79045 15.1591L12.925 8.0245L7.08313 8.19851C6.6108 8.17365 6.21305 7.82563 6.21305 7.32844Z" fill="CurrentColor"></path>
						</svg>
					</span>
				</a>
	          </div>
	         
	                <div class="col-lg-5 col-lg-offset-1 wow fadeInRight pattern position-relative">
	                    <div class="banner-image-area position-relative text-center text-md-start ">
							<div class="d-none d-md-block avatar-area bg-white theme-box-shadow py-3 px-3 px-md-4 position-absolute text-start" style="bottom: -60px; border-radius: 40px;">
								<div class="d-flex gap-3">
								<div>
									<span class="theme-color-text d-block fw-bold lh-1" style="font-size: 32px;">2K+</span>Students
								</div>
								<div class="userimage">
								<img src="<?php echo get_stylesheet_directory_uri() ?>/images/student.png" class="img-fluid">
								</div>
								</div>
							</div>
						</div>
						<div class="owl-carousel owl-loaded owl-drag custom-coursal-internship nodots" >
              <?php 
              $bannerGallery = $banner['banner_student_gallery'];
              if(!empty($bannerGallery)):
                foreach($bannerGallery as $imageId):
                  $imageUrl = wp_get_attachment_image_url($imageId, 'full');
              ?>
                <div class="item">
                <img src="<?php echo $imageUrl; ?>" class="img-fluid" alt="">
                </div>
                <?php endforeach; ?>
							<?php endif; ?>

						</div>
            
						<div class="d-none d-md-block avatar-area bg-white theme-box-shadow py-3 px-3 px-md-4 end-0 position-absolute text-start" style="bottom: -55px; border-radius: 40px;">
							<div class="d-flex gap-3">
							<div>
								<span class="theme-color-text d-block fw-bold lh-1" style="font-size: 32px;"><?php echo $banner['student_corsouse_']; ?></span>Success Courses
							</div>
							</div>
						</div>
          			</div>
	        </div>
	      </div>
	    </div>

<style>
    .owl-nav.disabled {
    display: none;
}
.inten-banner .wid160 {
    width: 160px;
}


</style>

	    <!-- turnover -->
	    <?php 
	    $internship_detail_page = get_field('internship_detail_page','option');
	    ?>
	    <div class="turnover pt-0">
	      <div class="container">
	        <div class="row p-4 rounded-2 theme-box-shadowdark bg-white" style="margin-top: -50px;">
	            <?php foreach($internship_detail_page['showcase_points'] as $item): ?>
	          <div class="col-md-3 col-6 g-3">
	            <div class="icon border brd-theme me-3 bg-theme-light"><img src="<?php echo $item['icon']; ?>" class="img-fluid" alt=""></div>
	            <?php echo wpautop($item['content']); ?>
	          </div>
	        <?php endforeach; ?>
	          
	        </div>
	      </div>
	    </div>

	    <!-- about inter -->
		 <div class="aboutinter section-padding">
			<div class="container">
				<div class="row">
				<div class="col-12 col-lg-6 mb-4 mb-lg-0">
					<div class="heading-area">
						<h2 class="mb-3"><?php echo get_field('about_the_internship_title'); ?></h2>
						<?php
						$full_text = get_field('about_the_internship_content');
						$short_text = mb_substr($full_text, 0, 200);
						$is_long = mb_strlen($full_text) > 200;

						$attachment_id = get_field('download_button_attachment');
						$attachment_url = $attachment_id ? wp_get_attachment_url($attachment_id) : 'javascript:void(0)';
						$download_attr = $attachment_id ? 'download' : '';
						?>
						<p class="mb-1">
							<span class="short-text"><?php echo wp_kses_post($short_text); ?></span>
							<?php if ($is_long): ?>
								<span class="dots">...</span>
								<span class="more-text d-none"><?php echo wp_kses_post(mb_substr($full_text, 100)); ?></span>
								<a href="javascript:void(0);" class="theme-text-primary fw-semibold text-decoration-none toggle-more">Read more</a>
							<?php endif; ?>
						</p>
					</div>
					<a href="#" class="btn btn-primary mt-4">Download Brochure</a>
				</div>
				<div class="col-12 col-lg-6">
					<iframe width="100%" height="315" src="<?php echo get_field('youtube_url'); ?>" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
				</div>
				</div>
			</div>
    	</div>
	    

	    <!-- certificate -->
	    <div class="certificate-full p-0">
	      <div class="container">
	        <div class="intcert">
	          <div class="row justify-content-between align-items-center">
	            <div class="col-lg-6">
	              <h2><?php 
	              $certificate = get_field('certificate');
	              echo $certificate['title'];
	              ?></h2>
	              <?php echo wpautop($certificate['description']);?>
	              <div class="d-none d-md-block"><a href="#" class="btn btn-primary">Apply for Intermship</a></div>
	            </div>
	            <div class="col-lg-6 order-md-first">
	              <div class="certibox d-block">
	                <img src="<?php echo get_stylesheet_directory_uri() ?>/images/cartificate-2.jpg" class="img-fluid w-100" alt="">
	              </div>
	              <div class="text-center d-block d-md-none mt-5"><a href="#" class="btn btn-primary">Apply for Intermship</a></div>
	            </div>
	          </div>
	        </div>
	      </div>
	    </div>

		<!-- Benefits -->
		<div class="benefits scroller pb-0" id="whythis" data-anchor="whythis">
			<div class="tabbed-content">
				<div class="container d-none d-md-block">
					<div class="row">
						<div class="col-lg-12">
						<h2 class="text-center">Top career options in Full Stack</h2>
						<p class="text-center">full stack is the most popular programming language and works across all computer and mobile platforms without needing to be recompiled. It is one of the top-paying jobs in software development</p>
						</div>
						<div class="col-lg-4">
						<h4>Designation</h4>
						</div>
						<div class="col-lg-4">
						<h4>Annual Salary</h4>
						</div>
						<div class="col-lg-4">
						<h4>Hiring Companies</h4>
						</div>
					</div>
					<div class="taborder">
						<div class="row">
						<div class="col-lg-4 d-none d-md-block">
							<nav class="tabs">
							<ul>
								<?php 
								if(have_rows('top_career_options_tabs')) :
									while(have_rows('top_career_options_tabs')): the_row();
										$tab_title = get_sub_field('tab_title');
										$tab_id = 'tab' . get_row_index();
								?>
								<li><a href="#<?php echo $tab_id; ?>" class="<?php echo (get_row_index() == 1) ? 'active' : ''; ?>"><?php echo $tab_title; ?></a></li>
								<?php
									endwhile; endif;
								?>
							</ul>
							</nav>
						</div>
						<div class="col-lg-8">
							<?php 
								if(have_rows('top_career_options_tabs')) :
									while(have_rows('top_career_options_tabs')): the_row();
										$tab_title = get_sub_field('tab_title');
										$tab_id = 'tab' . get_row_index();
										$annualSalaryImageId = get_sub_field('annual_salary_image');
										$annualSalaryImageUrl = $annualSalaryImageId ? wp_get_attachment_url($annualSalaryImageId) : null;

										$hiringCompanyImageId = get_sub_field('hiring_company_image');
										$hiringCompanyImageUrl = $hiringCompanyImageId ? wp_get_attachment_url($hiringCompanyImageId) : null;
							?>
							<section id="<?php echo $tab_id; ?>" class="item <?php echo (get_row_index() == 1) ? 'active' : ''; ?>" data-title="<?php echo $tab_title; ?>">
								<div class="item-content">
									<div class="row">
									<div class="col-lg-6 text-center">
										<h5>Annual Salary</h5>
										<div class="imgbox"><img src="<?php echo $annualSalaryImageUrl; ?>" class="img-fluid" alt="annual-image"></div>
									</div>
									<div class="col-lg-6 text-center">
										<h5>Hiring Companies</h5>
										<div class="imgbox"><img src="<?php echo $hiringCompanyImageUrl; ?>" class="img-fluid" alt="hiring-companies"></div>
									</div>
									</div>
								</div>
							</section>
							<?php endwhile; endif; ?>
						</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<!-- Full Stack -->
  <div class="fullstack no-bg pb -0">
    <div class="container">
        <div class="row" style="position: relative!important;">
            <div class="col-lg-8 " style="position: relative;">
                <style>
                    .hidden-item {
    display: none;
}

                </style>
                <h2><?php echo get_field("course_curriculum_heading"); ?></h2>
                <div class="subtext"><?php echo get_field("course_curriculum_description"); ?></div>
            <div class="accordion" id="accordionExample2">
    <?php
    $count = 0;
    if (have_rows('course_learning')):
        while (have_rows('course_learning')): the_row();
            $count++;
            $title = get_sub_field('title');
            $slug = create_slug($title) .'-'. $count;
            $is_multiple = get_sub_field('is_multiple') == 'True';
            $multiple = get_sub_field('multiple');
    ?>
    <div class="accordion-item<?php echo ($count > 14) ? ' hidden-item' : ''; ?>">
        <h4 class="accordion-header acdd" id="heading-<?php echo $slug; ?>">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-<?php echo $slug; ?>" aria-expanded="false" aria-controls="collapse-<?php echo $slug; ?>">
                <?php echo $title; ?> <span>Preview</span>
            </button>
        </h4>
        <div id="collapse-<?php echo $slug; ?>" class="accordion-collapse collapse" aria-labelledby="heading-<?php echo $slug; ?>" data-bs-parent="#accordionExample2">
            <div class="accordion-body">
                <?php echo wpautop(get_sub_field('content')); ?>
                <?php if ($is_multiple): ?>
                    <div class="accordion" id="accordionExample4">
                        <?php foreach ($multiple as $i => $item): ?>
                            <div class="accordion-item">
                                <h4 class="accordion-header" id="heading-<?php echo $slug . '-' . $i; ?>">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-<?php echo $slug . '-' . $i; ?>" aria-expanded="false" aria-controls="collapse-<?php echo $slug . '-' . $i; ?>">
                                        <?php echo $item["title"]; ?>
                                    </button>
                                </h4>
                                <div id="collapse-<?php echo $slug . '-' . $i; ?>" class="accordion-collapse collapse" aria-labelledby="heading-<?php echo $slug . '-' . $i; ?>" data-bs-parent="#accordionExample4">
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
    <?php
        endwhile;
    endif;
    ?>
</div>
<script>
    document.addEventListener("DOMContentLoaded", function() {
    const viewMoreBtn = document.getElementById('view-more-btn');
    const hiddenItems = document.querySelectorAll('.hidden-item');

    viewMoreBtn.addEventListener('click', function(e) {
        e.preventDefault();
        hiddenItems.forEach(function(item) {
            item.style.display = 'block';
        });
        if(viewMoreBtn.textContent == 'Show Less'){
        viewMoreBtn.textContent = 'Show More';
        hiddenItems.forEach(function(item) {
            item.style.display = 'none';
        });
        }else{
        viewMoreBtn.textContent = 'Show Less'; 
        }
    });
});

</script>
<?php if($count > 13): ?>
<div class="my-3 text-center"><a href="javascript:void(0)" id="view-more-btn" class="link-primary">View More</a></div>
<?php endif; ?>

                <!--<a href="#" class="btn btn-secondary">Download Brochure</a>-->
            </div>
            <div class="col-lg-4 d-none d-sm-block top-fixed">
                <div class="excel">
                    <ul>
                        <?php
                        if (have_rows('live_classes')):
                            $i = 0;
                            while (have_rows('live_classes')): the_row();
                                if ($i == 3):
                        ?>
                        <li class="separater"></li>
                        <?php
                                endif;
                        ?>
                        <li><img src="<?php echo get_sub_field('icon'); ?>" alt=""> <?php echo get_sub_field('name'); ?></li>
                        <?php
                                $i++;
                            endwhile;
                        endif;
                        ?>
                    </ul>
                    <!--<a href="<?php echo get_field('download_brochure') ?>" class="btn btn-primary d-block">Download Brochure</a>-->
					<a href="#" class="btn btn-primary d-block" data-bs-toggle="modal" data-bs-target="#exampleModal6">Download Brochure</a>
                </div>
            </div>
        </div>
    </div>
</div>

		<!-- Help Section -->
    <div class="tools-section help-section bg-image-hide wow fadeInUp bg-theme-light py-5 position-relative">
      <div class="container">
        <div class="row justify-content-center mb-3">
          <div class="col-12 col-lg-12">
            <div class="heading-area">
              <h2 class="">Get ahead in your career by learning top AI tools</h2>
            </div>
          </div>
        </div>
        <div class="row justify-content-center">
          <div class="col-12 col-sm-12 col-lg-12">
            <div class="card border brd-theme rounded-4 h-100">
              <div class="card-body p-lg-4">
                  <div class="d-flex gap-3 align-items-center mb-2">
                      <div class="cardicon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18" fill="none">
                          <path d="M9 1.49268C8 1.49268 7.0625 1.68018 6.1875 2.05518C5.29688 2.43018 4.52344 2.9458 3.86719 3.60205C3.21094 4.2583 2.69531 5.03174 2.32031 5.92236C1.94531 6.79736 1.75781 7.73486 1.75781 8.73486C1.75781 9.73486 1.94531 10.6724 2.32031 11.5474C2.69531 12.438 3.21094 13.2114 3.86719 13.8677C4.52344 14.5239 5.29688 15.0396 6.1875 15.4146C7.0625 15.7896 8 15.9771 9 15.9771C10 15.9771 10.9375 15.7896 11.8125 15.4146C12.7031 15.0396 13.4766 14.5239 14.1328 13.8677C14.7891 13.2114 15.3047 12.438 15.6797 11.5474C16.0547 10.6724 16.2422 9.73486 16.2422 8.73486C16.2422 7.73486 16.0547 6.79736 15.6797 5.92236C15.3047 5.03174 14.7891 4.2583 14.1328 3.60205C13.4766 2.9458 12.7031 2.43018 11.8125 2.05518C10.9375 1.68018 10 1.49268 9 1.49268ZM0.257812 8.73486C0.257812 7.53174 0.484375 6.39893 0.9375 5.33643C1.39062 4.27393 2.01562 3.34424 2.8125 2.54736C3.60938 1.75049 4.53906 1.12549 5.60156 0.672363C6.66406 0.219238 7.79688 -0.00732422 9 -0.00732422C10.2031 -0.00732422 11.3359 0.219238 12.3984 0.672363C13.4609 1.12549 14.3906 1.75049 15.1875 2.54736C15.9844 3.34424 16.6094 4.27393 17.0625 5.33643C17.5156 6.39893 17.7422 7.53174 17.7422 8.73486C17.7422 9.93799 17.5156 11.0708 17.0625 12.1333C16.6094 13.1958 15.9844 14.1255 15.1875 14.9224C14.3906 15.7192 13.4609 16.3442 12.3984 16.7974C11.3359 17.2505 10.2031 17.4771 9 17.4771C7.79688 17.4771 6.66406 17.2505 5.60156 16.7974C4.53906 16.3442 3.60938 15.7192 2.8125 14.9224C2.01562 14.1255 1.39062 13.1958 0.9375 12.1333C0.484375 11.0708 0.257812 9.93799 0.257812 8.73486ZM12.5391 6.20361C12.6797 6.35986 12.75 6.53955 12.75 6.74268C12.75 6.9458 12.6719 7.12549 12.5156 7.28174L8.39062 11.2661C8.25 11.4067 8.07812 11.4771 7.875 11.4771C7.67188 11.4771 7.5 11.4067 7.35938 11.2661L5.48438 9.46143C5.32812 9.3208 5.25 9.14502 5.25 8.93408C5.25 8.72314 5.32031 8.53955 5.46094 8.3833C5.60156 8.24268 5.77734 8.17236 5.98828 8.17236C6.19922 8.17236 6.375 8.24268 6.51562 8.3833L7.875 9.6958L11.4844 6.20361C11.625 6.04736 11.8008 5.97314 12.0117 5.98096C12.2227 5.98877 12.3984 6.06299 12.5391 6.20361Z" fill="#EF7220"/>
                        </svg>
                      </div>
                      <p class="theme-text-light mb-0"><span class="fw-medium">ChatGPT & Gemini</span> to explore datasets, analyse data, generate code, and develop models</p>
                  </div>
                  <div class="d-flex gap-3 align-items-center">
                      <div class="cardicon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18" fill="none">
                          <path d="M9 1.49268C8 1.49268 7.0625 1.68018 6.1875 2.05518C5.29688 2.43018 4.52344 2.9458 3.86719 3.60205C3.21094 4.2583 2.69531 5.03174 2.32031 5.92236C1.94531 6.79736 1.75781 7.73486 1.75781 8.73486C1.75781 9.73486 1.94531 10.6724 2.32031 11.5474C2.69531 12.438 3.21094 13.2114 3.86719 13.8677C4.52344 14.5239 5.29688 15.0396 6.1875 15.4146C7.0625 15.7896 8 15.9771 9 15.9771C10 15.9771 10.9375 15.7896 11.8125 15.4146C12.7031 15.0396 13.4766 14.5239 14.1328 13.8677C14.7891 13.2114 15.3047 12.438 15.6797 11.5474C16.0547 10.6724 16.2422 9.73486 16.2422 8.73486C16.2422 7.73486 16.0547 6.79736 15.6797 5.92236C15.3047 5.03174 14.7891 4.2583 14.1328 3.60205C13.4766 2.9458 12.7031 2.43018 11.8125 2.05518C10.9375 1.68018 10 1.49268 9 1.49268ZM0.257812 8.73486C0.257812 7.53174 0.484375 6.39893 0.9375 5.33643C1.39062 4.27393 2.01562 3.34424 2.8125 2.54736C3.60938 1.75049 4.53906 1.12549 5.60156 0.672363C6.66406 0.219238 7.79688 -0.00732422 9 -0.00732422C10.2031 -0.00732422 11.3359 0.219238 12.3984 0.672363C13.4609 1.12549 14.3906 1.75049 15.1875 2.54736C15.9844 3.34424 16.6094 4.27393 17.0625 5.33643C17.5156 6.39893 17.7422 7.53174 17.7422 8.73486C17.7422 9.93799 17.5156 11.0708 17.0625 12.1333C16.6094 13.1958 15.9844 14.1255 15.1875 14.9224C14.3906 15.7192 13.4609 16.3442 12.3984 16.7974C11.3359 17.2505 10.2031 17.4771 9 17.4771C7.79688 17.4771 6.66406 17.2505 5.60156 16.7974C4.53906 16.3442 3.60938 15.7192 2.8125 14.9224C2.01562 14.1255 1.39062 13.1958 0.9375 12.1333C0.484375 11.0708 0.257812 9.93799 0.257812 8.73486ZM12.5391 6.20361C12.6797 6.35986 12.75 6.53955 12.75 6.74268C12.75 6.9458 12.6719 7.12549 12.5156 7.28174L8.39062 11.2661C8.25 11.4067 8.07812 11.4771 7.875 11.4771C7.67188 11.4771 7.5 11.4067 7.35938 11.2661L5.48438 9.46143C5.32812 9.3208 5.25 9.14502 5.25 8.93408C5.25 8.72314 5.32031 8.53955 5.46094 8.3833C5.60156 8.24268 5.77734 8.17236 5.98828 8.17236C6.19922 8.17236 6.375 8.24268 6.51562 8.3833L7.875 9.6958L11.4844 6.20361C11.625 6.04736 11.8008 5.97314 12.0117 5.98096C12.2227 5.98877 12.3984 6.06299 12.5391 6.20361Z" fill="#EF7220"/>
                        </svg>
                      </div>
                      <p class="theme-text-light mb-0"><span class="fw-medium">Debugcode.ai</span> to solve any coding problem within seconds</p>
                  </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- End Help Section -->

	    <!-- Course -->
    <div class="endcareer endcareer2 wow fadeInUp section-padding bg-image-hide bg-white mb-0">
      <div class="container">
        <div class="row">
          <div class="col-lg-12 text-center">
            <h2 class="mb-0">Essential Full Stack Development Tools Covered in This Course</h2>
          </div>
          <div class="col-lg-4 col-sm-6 col-6 g-3">
            <div class="endcareer2-area align-items-center d-flex gap-3 p-3 border rounded-2 brd-theme-light">
              <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/python1.jpg" alt="">
              <h6 class="mb-0">Python</h6>
            </div>
          </div>
          <div class="col-lg-4 col-sm-6 col-6 g-3">
            <div class="endcareer2-area align-items-center d-flex gap-3 p-3 border rounded-2 brd-theme-light">
              <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/area1.jpg" alt="">
              <h6 class="mb-0">Power BI</h6>
            </div>
          </div>
          <div class="col-lg-4 col-sm-6 col-6 g-3">
            <div class="endcareer2-area align-items-center d-flex gap-3 p-3 border rounded-2 brd-theme-light">
              <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/mysql1.jpg" alt="">
              <h6 class="mb-0">MySQL</h6>
            </div>
          </div>
          <div class="col-lg-4 col-sm-6 col-6 g-3">
            <div class="endcareer2-area align-items-center d-flex gap-3 p-3 border rounded-2 brd-theme-light">
              <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/chart1.jpg" alt="">
              <h6 class="mb-0">Data Analysis</h6>
            </div>
          </div>
          <div class="col-lg-4 col-sm-6 col-6 g-3">
            <div class="endcareer2-area align-items-center d-flex gap-3 p-3 border rounded-2 brd-theme-light">
              <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/machine1.jpg" alt="">
              <h6 class="mb-0">Machine Learning</h6>
            </div>
          </div>
          <div class="col-lg-4 col-sm-6 col-6 g-3">
            <div class="endcareer2-area align-items-center d-flex gap-3 p-3 border rounded-2 brd-theme-light">
              <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/excel1.jpg" alt="">
              <h6 class="mb-0">Excel</h6>
            </div>
          </div>
          <div class="col-lg-4 col-sm-6 col-6 g-3">
            <div class="endcareer2-area align-items-center d-flex gap-3 p-3 border rounded-2 brd-theme-light">
              <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/AI1.jpg" alt="">
              <h6 class="mb-0">Latest gen AI tools</h6>
            </div>
          </div>
          <div class="col-lg-4 col-sm-6 col-6 g-3">
            <div class="endcareer2-area align-items-center d-flex gap-3 p-3 border rounded-2 brd-theme-light">
              <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/loom1.jpg" alt="">
              <h6 class="mb-0">ChatGPT</h6>
            </div>
          </div>
          <div class="col-lg-4 col-sm-6 col-6 g-3">
            <div class="endcareer2-area align-items-center d-flex gap-3 p-3 border rounded-2 brd-theme-light">
              <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/jira1.jpg" alt="">
              <h6 class="mb-0">Git</h6>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- End Course -->

	    <!-- industry project -->
	   <?php include_once('components/internship-details-projects.php'); ?>
	    <!-- From Training to Placement -->
	   <!-- Roadmap Section -->
    <section class="faqs faq-section py-5">
      <div class="container wow fadeInUp">
        <div class="row justify-content-center">
          <div class="col-md-12">
            <div class="heading-area mb-4">
              <h2 class="fw-bold">From <span class="theme-text-primary">Training to Placement</span> <br/> A Roadmap to Success</h2>
              <p></p>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-12  col-md-4">
            <ul class="nav left-tab my-0 theme-default-tab" id="myTab" role="tablist">
              <li class="nav-item" role="presentation">
                <a href="#" class="nav-link active bg-white border rounded-1" data-bs-toggle="tab" data-bs-target="#Foundation">Building Strong Foundation</a>
                <div class="mobile-view-tab d-none p-2">
                  <div class="row">
                    <div class="col-12 col-sm-6 col-lg-6 mb-3">
                      <div class="card h-100 roadmap-block border-0 bg-theme-light">
                        <div class="card-body p-lg-4">
                            <div class="cardicon mb-3 d-flex justify-content-center align-items-center">
                              <svg xmlns="http://www.w3.org/2000/svg" width="41" height="38" viewBox="0 0 41 38" fill="none">
                                <path d="M26.7028 19.1634H25.819C25.819 16.2347 23.4447 13.8604 20.5159 13.8604C17.5872 13.8604 15.2129 16.2347 15.2129 19.1634H14.3291C14.3291 15.7465 17.099 12.9766 20.5159 12.9766C23.9327 12.9766 26.7028 15.7465 26.7028 19.1634Z" fill="#EF7221"/>
                                <path d="M18.748 32.8633H22.2834V33.7471H18.748V32.8633Z" fill="#EF7221"/>
                                <path d="M28.1875 34.6973H12.8125V35.8758H28.1875V34.6973Z" fill="#EF7221"/>
                                <path d="M28.1875 2.87891H12.8125V4.05739H28.1875V2.87891Z" fill="#EF7221"/>
                                <path d="M28.1875 24.0918H16.6562V25.2703H28.1875V24.0918Z" fill="#EF7221"/>
                                <path d="M15.375 24.0918H12.8125V25.2703H15.375V24.0918Z" fill="#EF7221"/>
                                <path d="M28.1875 27.627H16.6562V28.8054H28.1875V27.627Z" fill="#EF7221"/>
                                <path d="M15.375 27.627H12.8125V28.8054H15.375V27.627Z" fill="#EF7221"/>
                                <path d="M32.0312 7.5924V31.1621H33.3125V7.5924H32.0312Z" fill="#EF7221"/>
                                <path d="M28.1875 2.87891V4.05739H30.75C31.0898 4.05739 31.4157 4.18155 31.656 4.40256C31.8963 4.62357 32.0312 4.92332 32.0312 5.23588V7.59285H33.3125V5.23588C33.3125 4.61077 33.0425 4.01126 32.562 3.56925C32.0814 3.12723 31.4296 2.87891 30.75 2.87891H28.1875Z" fill="#EF7221"/>
                                <path d="M7.6875 7.5924L7.6875 31.1621H8.96875L8.96875 7.5924H7.6875Z" fill="#EF7221"/>
                                <path d="M12.8125 2.87891V4.05739H10.25C9.91019 4.05739 9.5843 4.18155 9.34402 4.40256C9.10374 4.62357 8.96875 4.92332 8.96875 5.23588V7.59285H7.6875V5.23588C7.6875 4.61077 7.95748 4.01126 8.43804 3.56925C8.9186 3.12723 9.57038 2.87891 10.25 2.87891H12.8125Z" fill="#EF7221"/>
                                <path d="M28.1875 35.8761V34.6976H30.75C31.0898 34.6976 31.4157 34.5734 31.656 34.3524C31.8963 34.1314 32.0312 33.8316 32.0312 33.5191V31.1621H33.3125V33.5191C33.3125 34.1442 33.0425 34.7437 32.562 35.1857C32.0814 35.6277 31.4296 35.8761 30.75 35.8761H28.1875Z" fill="#EF7221"/>
                                <path d="M12.8125 35.8761V34.6976H10.25C9.91019 34.6976 9.5843 34.5734 9.34402 34.3524C9.10374 34.1314 8.96875 33.8316 8.96875 33.5191V31.1621H7.6875V33.5191C7.6875 34.1442 7.95748 34.7437 8.43804 35.1857C8.9186 35.6277 9.57038 35.8761 10.25 35.8761H12.8125Z" fill="#EF7221"/>
                                <path d="M20.5 8.94922C19.9932 8.94922 19.4978 9.08745 19.0764 9.34644C18.655 9.60543 18.3265 9.97354 18.1326 10.4042C17.9386 10.8349 17.8879 11.3088 17.9867 11.766C18.0856 12.2232 18.3297 12.6432 18.688 12.9728C19.0464 13.3024 19.503 13.5269 20.0001 13.6179C20.4972 13.7088 21.0124 13.6621 21.4806 13.4837C21.9489 13.3054 22.3491 13.0033 22.6306 12.6157C22.9122 12.2281 23.0625 11.7724 23.0625 11.3062C23.0625 10.6811 22.7925 10.0816 22.312 9.63956C21.8314 9.19754 21.1796 8.94922 20.5 8.94922ZM20.5 12.4847C20.2466 12.4847 19.9989 12.4156 19.7882 12.2861C19.5775 12.1566 19.4133 11.9725 19.3163 11.7572C19.2193 11.5418 19.1939 11.3049 19.2434 11.0763C19.2928 10.8477 19.4148 10.6377 19.594 10.4729C19.7732 10.3081 20.0015 10.1958 20.25 10.1503C20.4986 10.1049 20.7562 10.1282 20.9903 10.2174C21.2244 10.3066 21.4245 10.4577 21.5653 10.6515C21.7061 10.8453 21.7813 11.0731 21.7813 11.3062C21.7813 11.6187 21.6463 11.9185 21.406 12.1395C21.1657 12.3605 20.8398 12.4847 20.5 12.4847Z" fill="#EF7221"/>
                              </svg>
                            </div>
                            <h5 class="fw-semibold">Expert Training sessions</h5>
                            <p class="mb-0 p-0">Focus on industry-relevant skills</p>
                        </div>
                      </div>
                    </div>
                    <div class="col-12 col-sm-6 col-lg-6 mb-3">
                      <div class="card h-100 roadmap-block border-0 bg-theme-light">
                        <div class="card-body p-lg-4">
                            <div class="cardicon mb-3 d-flex justify-content-center align-items-center">
                              <svg xmlns="http://www.w3.org/2000/svg" width="41" height="38" viewBox="0 0 41 38" fill="none">
                                <path d="M26.7028 19.1634H25.819C25.819 16.2347 23.4447 13.8604 20.5159 13.8604C17.5872 13.8604 15.2129 16.2347 15.2129 19.1634H14.3291C14.3291 15.7465 17.099 12.9766 20.5159 12.9766C23.9327 12.9766 26.7028 15.7465 26.7028 19.1634Z" fill="#EF7221"/>
                                <path d="M18.748 32.8633H22.2834V33.7471H18.748V32.8633Z" fill="#EF7221"/>
                                <path d="M28.1875 34.6973H12.8125V35.8758H28.1875V34.6973Z" fill="#EF7221"/>
                                <path d="M28.1875 2.87891H12.8125V4.05739H28.1875V2.87891Z" fill="#EF7221"/>
                                <path d="M28.1875 24.0918H16.6562V25.2703H28.1875V24.0918Z" fill="#EF7221"/>
                                <path d="M15.375 24.0918H12.8125V25.2703H15.375V24.0918Z" fill="#EF7221"/>
                                <path d="M28.1875 27.627H16.6562V28.8054H28.1875V27.627Z" fill="#EF7221"/>
                                <path d="M15.375 27.627H12.8125V28.8054H15.375V27.627Z" fill="#EF7221"/>
                                <path d="M32.0312 7.5924V31.1621H33.3125V7.5924H32.0312Z" fill="#EF7221"/>
                                <path d="M28.1875 2.87891V4.05739H30.75C31.0898 4.05739 31.4157 4.18155 31.656 4.40256C31.8963 4.62357 32.0312 4.92332 32.0312 5.23588V7.59285H33.3125V5.23588C33.3125 4.61077 33.0425 4.01126 32.562 3.56925C32.0814 3.12723 31.4296 2.87891 30.75 2.87891H28.1875Z" fill="#EF7221"/>
                                <path d="M7.6875 7.5924L7.6875 31.1621H8.96875L8.96875 7.5924H7.6875Z" fill="#EF7221"/>
                                <path d="M12.8125 2.87891V4.05739H10.25C9.91019 4.05739 9.5843 4.18155 9.34402 4.40256C9.10374 4.62357 8.96875 4.92332 8.96875 5.23588V7.59285H7.6875V5.23588C7.6875 4.61077 7.95748 4.01126 8.43804 3.56925C8.9186 3.12723 9.57038 2.87891 10.25 2.87891H12.8125Z" fill="#EF7221"/>
                                <path d="M28.1875 35.8761V34.6976H30.75C31.0898 34.6976 31.4157 34.5734 31.656 34.3524C31.8963 34.1314 32.0312 33.8316 32.0312 33.5191V31.1621H33.3125V33.5191C33.3125 34.1442 33.0425 34.7437 32.562 35.1857C32.0814 35.6277 31.4296 35.8761 30.75 35.8761H28.1875Z" fill="#EF7221"/>
                                <path d="M12.8125 35.8761V34.6976H10.25C9.91019 34.6976 9.5843 34.5734 9.34402 34.3524C9.10374 34.1314 8.96875 33.8316 8.96875 33.5191V31.1621H7.6875V33.5191C7.6875 34.1442 7.95748 34.7437 8.43804 35.1857C8.9186 35.6277 9.57038 35.8761 10.25 35.8761H12.8125Z" fill="#EF7221"/>
                                <path d="M20.5 8.94922C19.9932 8.94922 19.4978 9.08745 19.0764 9.34644C18.655 9.60543 18.3265 9.97354 18.1326 10.4042C17.9386 10.8349 17.8879 11.3088 17.9867 11.766C18.0856 12.2232 18.3297 12.6432 18.688 12.9728C19.0464 13.3024 19.503 13.5269 20.0001 13.6179C20.4972 13.7088 21.0124 13.6621 21.4806 13.4837C21.9489 13.3054 22.3491 13.0033 22.6306 12.6157C22.9122 12.2281 23.0625 11.7724 23.0625 11.3062C23.0625 10.6811 22.7925 10.0816 22.312 9.63956C21.8314 9.19754 21.1796 8.94922 20.5 8.94922ZM20.5 12.4847C20.2466 12.4847 19.9989 12.4156 19.7882 12.2861C19.5775 12.1566 19.4133 11.9725 19.3163 11.7572C19.2193 11.5418 19.1939 11.3049 19.2434 11.0763C19.2928 10.8477 19.4148 10.6377 19.594 10.4729C19.7732 10.3081 20.0015 10.1958 20.25 10.1503C20.4986 10.1049 20.7562 10.1282 20.9903 10.2174C21.2244 10.3066 21.4245 10.4577 21.5653 10.6515C21.7061 10.8453 21.7813 11.0731 21.7813 11.3062C21.7813 11.6187 21.6463 11.9185 21.406 12.1395C21.1657 12.3605 20.8398 12.4847 20.5 12.4847Z" fill="#EF7221"/>
                              </svg>
                            </div>
                            <h5 class="fw-semibold">Hands on projects & Assignments</h5>
                            <p class="mb-0 p-0">Real-world projects to implement learned concepts.</p>
                        </div>
                      </div>
                    </div>
                    <div class="col-12 col-sm-6 col-lg-6 mb-3">
                      <div class="card h-100 roadmap-block border-0 bg-theme-light">
                        <div class="card-body p-lg-4">
                            <div class="cardicon mb-3 d-flex justify-content-center align-items-center">
                              <svg xmlns="http://www.w3.org/2000/svg" width="41" height="38" viewBox="0 0 41 38" fill="none">
                                <path d="M26.7028 19.1634H25.819C25.819 16.2347 23.4447 13.8604 20.5159 13.8604C17.5872 13.8604 15.2129 16.2347 15.2129 19.1634H14.3291C14.3291 15.7465 17.099 12.9766 20.5159 12.9766C23.9327 12.9766 26.7028 15.7465 26.7028 19.1634Z" fill="#EF7221"/>
                                <path d="M18.748 32.8633H22.2834V33.7471H18.748V32.8633Z" fill="#EF7221"/>
                                <path d="M28.1875 34.6973H12.8125V35.8758H28.1875V34.6973Z" fill="#EF7221"/>
                                <path d="M28.1875 2.87891H12.8125V4.05739H28.1875V2.87891Z" fill="#EF7221"/>
                                <path d="M28.1875 24.0918H16.6562V25.2703H28.1875V24.0918Z" fill="#EF7221"/>
                                <path d="M15.375 24.0918H12.8125V25.2703H15.375V24.0918Z" fill="#EF7221"/>
                                <path d="M28.1875 27.627H16.6562V28.8054H28.1875V27.627Z" fill="#EF7221"/>
                                <path d="M15.375 27.627H12.8125V28.8054H15.375V27.627Z" fill="#EF7221"/>
                                <path d="M32.0312 7.5924V31.1621H33.3125V7.5924H32.0312Z" fill="#EF7221"/>
                                <path d="M28.1875 2.87891V4.05739H30.75C31.0898 4.05739 31.4157 4.18155 31.656 4.40256C31.8963 4.62357 32.0312 4.92332 32.0312 5.23588V7.59285H33.3125V5.23588C33.3125 4.61077 33.0425 4.01126 32.562 3.56925C32.0814 3.12723 31.4296 2.87891 30.75 2.87891H28.1875Z" fill="#EF7221"/>
                                <path d="M7.6875 7.5924L7.6875 31.1621H8.96875L8.96875 7.5924H7.6875Z" fill="#EF7221"/>
                                <path d="M12.8125 2.87891V4.05739H10.25C9.91019 4.05739 9.5843 4.18155 9.34402 4.40256C9.10374 4.62357 8.96875 4.92332 8.96875 5.23588V7.59285H7.6875V5.23588C7.6875 4.61077 7.95748 4.01126 8.43804 3.56925C8.9186 3.12723 9.57038 2.87891 10.25 2.87891H12.8125Z" fill="#EF7221"/>
                                <path d="M28.1875 35.8761V34.6976H30.75C31.0898 34.6976 31.4157 34.5734 31.656 34.3524C31.8963 34.1314 32.0312 33.8316 32.0312 33.5191V31.1621H33.3125V33.5191C33.3125 34.1442 33.0425 34.7437 32.562 35.1857C32.0814 35.6277 31.4296 35.8761 30.75 35.8761H28.1875Z" fill="#EF7221"/>
                                <path d="M12.8125 35.8761V34.6976H10.25C9.91019 34.6976 9.5843 34.5734 9.34402 34.3524C9.10374 34.1314 8.96875 33.8316 8.96875 33.5191V31.1621H7.6875V33.5191C7.6875 34.1442 7.95748 34.7437 8.43804 35.1857C8.9186 35.6277 9.57038 35.8761 10.25 35.8761H12.8125Z" fill="#EF7221"/>
                                <path d="M20.5 8.94922C19.9932 8.94922 19.4978 9.08745 19.0764 9.34644C18.655 9.60543 18.3265 9.97354 18.1326 10.4042C17.9386 10.8349 17.8879 11.3088 17.9867 11.766C18.0856 12.2232 18.3297 12.6432 18.688 12.9728C19.0464 13.3024 19.503 13.5269 20.0001 13.6179C20.4972 13.7088 21.0124 13.6621 21.4806 13.4837C21.9489 13.3054 22.3491 13.0033 22.6306 12.6157C22.9122 12.2281 23.0625 11.7724 23.0625 11.3062C23.0625 10.6811 22.7925 10.0816 22.312 9.63956C21.8314 9.19754 21.1796 8.94922 20.5 8.94922ZM20.5 12.4847C20.2466 12.4847 19.9989 12.4156 19.7882 12.2861C19.5775 12.1566 19.4133 11.9725 19.3163 11.7572C19.2193 11.5418 19.1939 11.3049 19.2434 11.0763C19.2928 10.8477 19.4148 10.6377 19.594 10.4729C19.7732 10.3081 20.0015 10.1958 20.25 10.1503C20.4986 10.1049 20.7562 10.1282 20.9903 10.2174C21.2244 10.3066 21.4245 10.4577 21.5653 10.6515C21.7061 10.8453 21.7813 11.0731 21.7813 11.3062C21.7813 11.6187 21.6463 11.9185 21.406 12.1395C21.1657 12.3605 20.8398 12.4847 20.5 12.4847Z" fill="#EF7221"/>
                              </svg>
                            </div>
                            <h5 class="fw-semibold">Performance Tracking</h5>
                            <p class="mb-0 p-0">Weekly tests to assess progress</p>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </li>
              <li class="nav-item" role="presentation">
                <a href="#" class="nav-link bg-white border rounded-1" data-bs-toggle="tab" data-bs-target="#Science">Sharpening InterviewReadiness</a>
                <div class="mobile-view-tab d-none p-2">
                  <div class="row">
                    <div class="col-12 col-sm-6 col-lg-6 mb-3">
                      <div class="card h-100 roadmap-block border-0 bg-theme-light">
                        <div class="card-body p-lg-4">
                            <div class="cardicon mb-3 d-flex justify-content-center align-items-center">
                              <svg xmlns="http://www.w3.org/2000/svg" width="41" height="38" viewBox="0 0 41 38" fill="none">
                                <path d="M26.7028 19.1634H25.819C25.819 16.2347 23.4447 13.8604 20.5159 13.8604C17.5872 13.8604 15.2129 16.2347 15.2129 19.1634H14.3291C14.3291 15.7465 17.099 12.9766 20.5159 12.9766C23.9327 12.9766 26.7028 15.7465 26.7028 19.1634Z" fill="#EF7221"/>
                                <path d="M18.748 32.8633H22.2834V33.7471H18.748V32.8633Z" fill="#EF7221"/>
                                <path d="M28.1875 34.6973H12.8125V35.8758H28.1875V34.6973Z" fill="#EF7221"/>
                                <path d="M28.1875 2.87891H12.8125V4.05739H28.1875V2.87891Z" fill="#EF7221"/>
                                <path d="M28.1875 24.0918H16.6562V25.2703H28.1875V24.0918Z" fill="#EF7221"/>
                                <path d="M15.375 24.0918H12.8125V25.2703H15.375V24.0918Z" fill="#EF7221"/>
                                <path d="M28.1875 27.627H16.6562V28.8054H28.1875V27.627Z" fill="#EF7221"/>
                                <path d="M15.375 27.627H12.8125V28.8054H15.375V27.627Z" fill="#EF7221"/>
                                <path d="M32.0312 7.5924V31.1621H33.3125V7.5924H32.0312Z" fill="#EF7221"/>
                                <path d="M28.1875 2.87891V4.05739H30.75C31.0898 4.05739 31.4157 4.18155 31.656 4.40256C31.8963 4.62357 32.0312 4.92332 32.0312 5.23588V7.59285H33.3125V5.23588C33.3125 4.61077 33.0425 4.01126 32.562 3.56925C32.0814 3.12723 31.4296 2.87891 30.75 2.87891H28.1875Z" fill="#EF7221"/>
                                <path d="M7.6875 7.5924L7.6875 31.1621H8.96875L8.96875 7.5924H7.6875Z" fill="#EF7221"/>
                                <path d="M12.8125 2.87891V4.05739H10.25C9.91019 4.05739 9.5843 4.18155 9.34402 4.40256C9.10374 4.62357 8.96875 4.92332 8.96875 5.23588V7.59285H7.6875V5.23588C7.6875 4.61077 7.95748 4.01126 8.43804 3.56925C8.9186 3.12723 9.57038 2.87891 10.25 2.87891H12.8125Z" fill="#EF7221"/>
                                <path d="M28.1875 35.8761V34.6976H30.75C31.0898 34.6976 31.4157 34.5734 31.656 34.3524C31.8963 34.1314 32.0312 33.8316 32.0312 33.5191V31.1621H33.3125V33.5191C33.3125 34.1442 33.0425 34.7437 32.562 35.1857C32.0814 35.6277 31.4296 35.8761 30.75 35.8761H28.1875Z" fill="#EF7221"/>
                                <path d="M12.8125 35.8761V34.6976H10.25C9.91019 34.6976 9.5843 34.5734 9.34402 34.3524C9.10374 34.1314 8.96875 33.8316 8.96875 33.5191V31.1621H7.6875V33.5191C7.6875 34.1442 7.95748 34.7437 8.43804 35.1857C8.9186 35.6277 9.57038 35.8761 10.25 35.8761H12.8125Z" fill="#EF7221"/>
                                <path d="M20.5 8.94922C19.9932 8.94922 19.4978 9.08745 19.0764 9.34644C18.655 9.60543 18.3265 9.97354 18.1326 10.4042C17.9386 10.8349 17.8879 11.3088 17.9867 11.766C18.0856 12.2232 18.3297 12.6432 18.688 12.9728C19.0464 13.3024 19.503 13.5269 20.0001 13.6179C20.4972 13.7088 21.0124 13.6621 21.4806 13.4837C21.9489 13.3054 22.3491 13.0033 22.6306 12.6157C22.9122 12.2281 23.0625 11.7724 23.0625 11.3062C23.0625 10.6811 22.7925 10.0816 22.312 9.63956C21.8314 9.19754 21.1796 8.94922 20.5 8.94922ZM20.5 12.4847C20.2466 12.4847 19.9989 12.4156 19.7882 12.2861C19.5775 12.1566 19.4133 11.9725 19.3163 11.7572C19.2193 11.5418 19.1939 11.3049 19.2434 11.0763C19.2928 10.8477 19.4148 10.6377 19.594 10.4729C19.7732 10.3081 20.0015 10.1958 20.25 10.1503C20.4986 10.1049 20.7562 10.1282 20.9903 10.2174C21.2244 10.3066 21.4245 10.4577 21.5653 10.6515C21.7061 10.8453 21.7813 11.0731 21.7813 11.3062C21.7813 11.6187 21.6463 11.9185 21.406 12.1395C21.1657 12.3605 20.8398 12.4847 20.5 12.4847Z" fill="#EF7221"/>
                              </svg>
                            </div>
                            <h5 class="fw-semibold">Mock Interviews</h5>
                            <p class="mb-0 p-0">mock sessions with real-time feedback from experts</p>
                        </div>
                      </div>
                    </div>
                    <div class="col-12 col-sm-6 col-lg-6 mb-3">
                      <div class="card h-100 roadmap-block border-0 bg-theme-light">
                        <div class="card-body p-lg-4">
                            <div class="cardicon mb-3 d-flex justify-content-center align-items-center">
                              <svg xmlns="http://www.w3.org/2000/svg" width="41" height="38" viewBox="0 0 41 38" fill="none">
                                <path d="M26.7028 19.1634H25.819C25.819 16.2347 23.4447 13.8604 20.5159 13.8604C17.5872 13.8604 15.2129 16.2347 15.2129 19.1634H14.3291C14.3291 15.7465 17.099 12.9766 20.5159 12.9766C23.9327 12.9766 26.7028 15.7465 26.7028 19.1634Z" fill="#EF7221"/>
                                <path d="M18.748 32.8633H22.2834V33.7471H18.748V32.8633Z" fill="#EF7221"/>
                                <path d="M28.1875 34.6973H12.8125V35.8758H28.1875V34.6973Z" fill="#EF7221"/>
                                <path d="M28.1875 2.87891H12.8125V4.05739H28.1875V2.87891Z" fill="#EF7221"/>
                                <path d="M28.1875 24.0918H16.6562V25.2703H28.1875V24.0918Z" fill="#EF7221"/>
                                <path d="M15.375 24.0918H12.8125V25.2703H15.375V24.0918Z" fill="#EF7221"/>
                                <path d="M28.1875 27.627H16.6562V28.8054H28.1875V27.627Z" fill="#EF7221"/>
                                <path d="M15.375 27.627H12.8125V28.8054H15.375V27.627Z" fill="#EF7221"/>
                                <path d="M32.0312 7.5924V31.1621H33.3125V7.5924H32.0312Z" fill="#EF7221"/>
                                <path d="M28.1875 2.87891V4.05739H30.75C31.0898 4.05739 31.4157 4.18155 31.656 4.40256C31.8963 4.62357 32.0312 4.92332 32.0312 5.23588V7.59285H33.3125V5.23588C33.3125 4.61077 33.0425 4.01126 32.562 3.56925C32.0814 3.12723 31.4296 2.87891 30.75 2.87891H28.1875Z" fill="#EF7221"/>
                                <path d="M7.6875 7.5924L7.6875 31.1621H8.96875L8.96875 7.5924H7.6875Z" fill="#EF7221"/>
                                <path d="M12.8125 2.87891V4.05739H10.25C9.91019 4.05739 9.5843 4.18155 9.34402 4.40256C9.10374 4.62357 8.96875 4.92332 8.96875 5.23588V7.59285H7.6875V5.23588C7.6875 4.61077 7.95748 4.01126 8.43804 3.56925C8.9186 3.12723 9.57038 2.87891 10.25 2.87891H12.8125Z" fill="#EF7221"/>
                                <path d="M28.1875 35.8761V34.6976H30.75C31.0898 34.6976 31.4157 34.5734 31.656 34.3524C31.8963 34.1314 32.0312 33.8316 32.0312 33.5191V31.1621H33.3125V33.5191C33.3125 34.1442 33.0425 34.7437 32.562 35.1857C32.0814 35.6277 31.4296 35.8761 30.75 35.8761H28.1875Z" fill="#EF7221"/>
                                <path d="M12.8125 35.8761V34.6976H10.25C9.91019 34.6976 9.5843 34.5734 9.34402 34.3524C9.10374 34.1314 8.96875 33.8316 8.96875 33.5191V31.1621H7.6875V33.5191C7.6875 34.1442 7.95748 34.7437 8.43804 35.1857C8.9186 35.6277 9.57038 35.8761 10.25 35.8761H12.8125Z" fill="#EF7221"/>
                                <path d="M20.5 8.94922C19.9932 8.94922 19.4978 9.08745 19.0764 9.34644C18.655 9.60543 18.3265 9.97354 18.1326 10.4042C17.9386 10.8349 17.8879 11.3088 17.9867 11.766C18.0856 12.2232 18.3297 12.6432 18.688 12.9728C19.0464 13.3024 19.503 13.5269 20.0001 13.6179C20.4972 13.7088 21.0124 13.6621 21.4806 13.4837C21.9489 13.3054 22.3491 13.0033 22.6306 12.6157C22.9122 12.2281 23.0625 11.7724 23.0625 11.3062C23.0625 10.6811 22.7925 10.0816 22.312 9.63956C21.8314 9.19754 21.1796 8.94922 20.5 8.94922ZM20.5 12.4847C20.2466 12.4847 19.9989 12.4156 19.7882 12.2861C19.5775 12.1566 19.4133 11.9725 19.3163 11.7572C19.2193 11.5418 19.1939 11.3049 19.2434 11.0763C19.2928 10.8477 19.4148 10.6377 19.594 10.4729C19.7732 10.3081 20.0015 10.1958 20.25 10.1503C20.4986 10.1049 20.7562 10.1282 20.9903 10.2174C21.2244 10.3066 21.4245 10.4577 21.5653 10.6515C21.7061 10.8453 21.7813 11.0731 21.7813 11.3062C21.7813 11.6187 21.6463 11.9185 21.406 12.1395C21.1657 12.3605 20.8398 12.4847 20.5 12.4847Z" fill="#EF7221"/>
                              </svg>
                            </div>
                            <h5 class="fw-semibold">Skill Refinement Tasks</h5>
                            <p class="mb-0 p-0">Focus on problem-solving, critical thinking, and domain expertise.</p>
                        </div>
                      </div>
                    </div>
                    <div class="col-12 col-sm-6 col-lg-6 mb-3">
                      <div class="card h-100 roadmap-block border-0 bg-theme-light">
                        <div class="card-body p-lg-4">
                            <div class="cardicon mb-3 d-flex justify-content-center align-items-center">
                              <svg xmlns="http://www.w3.org/2000/svg" width="41" height="38" viewBox="0 0 41 38" fill="none">
                                <path d="M26.7028 19.1634H25.819C25.819 16.2347 23.4447 13.8604 20.5159 13.8604C17.5872 13.8604 15.2129 16.2347 15.2129 19.1634H14.3291C14.3291 15.7465 17.099 12.9766 20.5159 12.9766C23.9327 12.9766 26.7028 15.7465 26.7028 19.1634Z" fill="#EF7221"/>
                                <path d="M18.748 32.8633H22.2834V33.7471H18.748V32.8633Z" fill="#EF7221"/>
                                <path d="M28.1875 34.6973H12.8125V35.8758H28.1875V34.6973Z" fill="#EF7221"/>
                                <path d="M28.1875 2.87891H12.8125V4.05739H28.1875V2.87891Z" fill="#EF7221"/>
                                <path d="M28.1875 24.0918H16.6562V25.2703H28.1875V24.0918Z" fill="#EF7221"/>
                                <path d="M15.375 24.0918H12.8125V25.2703H15.375V24.0918Z" fill="#EF7221"/>
                                <path d="M28.1875 27.627H16.6562V28.8054H28.1875V27.627Z" fill="#EF7221"/>
                                <path d="M15.375 27.627H12.8125V28.8054H15.375V27.627Z" fill="#EF7221"/>
                                <path d="M32.0312 7.5924V31.1621H33.3125V7.5924H32.0312Z" fill="#EF7221"/>
                                <path d="M28.1875 2.87891V4.05739H30.75C31.0898 4.05739 31.4157 4.18155 31.656 4.40256C31.8963 4.62357 32.0312 4.92332 32.0312 5.23588V7.59285H33.3125V5.23588C33.3125 4.61077 33.0425 4.01126 32.562 3.56925C32.0814 3.12723 31.4296 2.87891 30.75 2.87891H28.1875Z" fill="#EF7221"/>
                                <path d="M7.6875 7.5924L7.6875 31.1621H8.96875L8.96875 7.5924H7.6875Z" fill="#EF7221"/>
                                <path d="M12.8125 2.87891V4.05739H10.25C9.91019 4.05739 9.5843 4.18155 9.34402 4.40256C9.10374 4.62357 8.96875 4.92332 8.96875 5.23588V7.59285H7.6875V5.23588C7.6875 4.61077 7.95748 4.01126 8.43804 3.56925C8.9186 3.12723 9.57038 2.87891 10.25 2.87891H12.8125Z" fill="#EF7221"/>
                                <path d="M28.1875 35.8761V34.6976H30.75C31.0898 34.6976 31.4157 34.5734 31.656 34.3524C31.8963 34.1314 32.0312 33.8316 32.0312 33.5191V31.1621H33.3125V33.5191C33.3125 34.1442 33.0425 34.7437 32.562 35.1857C32.0814 35.6277 31.4296 35.8761 30.75 35.8761H28.1875Z" fill="#EF7221"/>
                                <path d="M12.8125 35.8761V34.6976H10.25C9.91019 34.6976 9.5843 34.5734 9.34402 34.3524C9.10374 34.1314 8.96875 33.8316 8.96875 33.5191V31.1621H7.6875V33.5191C7.6875 34.1442 7.95748 34.7437 8.43804 35.1857C8.9186 35.6277 9.57038 35.8761 10.25 35.8761H12.8125Z" fill="#EF7221"/>
                                <path d="M20.5 8.94922C19.9932 8.94922 19.4978 9.08745 19.0764 9.34644C18.655 9.60543 18.3265 9.97354 18.1326 10.4042C17.9386 10.8349 17.8879 11.3088 17.9867 11.766C18.0856 12.2232 18.3297 12.6432 18.688 12.9728C19.0464 13.3024 19.503 13.5269 20.0001 13.6179C20.4972 13.7088 21.0124 13.6621 21.4806 13.4837C21.9489 13.3054 22.3491 13.0033 22.6306 12.6157C22.9122 12.2281 23.0625 11.7724 23.0625 11.3062C23.0625 10.6811 22.7925 10.0816 22.312 9.63956C21.8314 9.19754 21.1796 8.94922 20.5 8.94922ZM20.5 12.4847C20.2466 12.4847 19.9989 12.4156 19.7882 12.2861C19.5775 12.1566 19.4133 11.9725 19.3163 11.7572C19.2193 11.5418 19.1939 11.3049 19.2434 11.0763C19.2928 10.8477 19.4148 10.6377 19.594 10.4729C19.7732 10.3081 20.0015 10.1958 20.25 10.1503C20.4986 10.1049 20.7562 10.1282 20.9903 10.2174C21.2244 10.3066 21.4245 10.4577 21.5653 10.6515C21.7061 10.8453 21.7813 11.0731 21.7813 11.3062C21.7813 11.6187 21.6463 11.9185 21.406 12.1395C21.1657 12.3605 20.8398 12.4847 20.5 12.4847Z" fill="#EF7221"/>
                              </svg>
                            </div>
                            <h5 class="fw-semibold">Expert Sessions</h5>
                            <p class="mb-0 p-0">Host industry experts for advanced technical guidance</p>
                        </div>
                      </div>
                    </div>
                    
                  </div>
                </div>
              </li>
              <li class="nav-item" role="presentation">
                <a href="#" class="nav-link bg-white border rounded-1" data-bs-toggle="tab" data-bs-target="#Development">Communication Skill Development</a>
                <div class="mobile-view-tab d-none p-2">
                  <div class="row">
                    <div class="col-12 col-sm-6 col-lg-6 mb-3">
                      <div class="card h-100 roadmap-block border-0 bg-theme-light">
                        <div class="card-body p-lg-4">
                            <div class="cardicon mb-3 d-flex justify-content-center align-items-center">
                              <svg xmlns="http://www.w3.org/2000/svg" width="41" height="38" viewBox="0 0 41 38" fill="none">
                                <path d="M26.7028 19.1634H25.819C25.819 16.2347 23.4447 13.8604 20.5159 13.8604C17.5872 13.8604 15.2129 16.2347 15.2129 19.1634H14.3291C14.3291 15.7465 17.099 12.9766 20.5159 12.9766C23.9327 12.9766 26.7028 15.7465 26.7028 19.1634Z" fill="#EF7221"/>
                                <path d="M18.748 32.8633H22.2834V33.7471H18.748V32.8633Z" fill="#EF7221"/>
                                <path d="M28.1875 34.6973H12.8125V35.8758H28.1875V34.6973Z" fill="#EF7221"/>
                                <path d="M28.1875 2.87891H12.8125V4.05739H28.1875V2.87891Z" fill="#EF7221"/>
                                <path d="M28.1875 24.0918H16.6562V25.2703H28.1875V24.0918Z" fill="#EF7221"/>
                                <path d="M15.375 24.0918H12.8125V25.2703H15.375V24.0918Z" fill="#EF7221"/>
                                <path d="M28.1875 27.627H16.6562V28.8054H28.1875V27.627Z" fill="#EF7221"/>
                                <path d="M15.375 27.627H12.8125V28.8054H15.375V27.627Z" fill="#EF7221"/>
                                <path d="M32.0312 7.5924V31.1621H33.3125V7.5924H32.0312Z" fill="#EF7221"/>
                                <path d="M28.1875 2.87891V4.05739H30.75C31.0898 4.05739 31.4157 4.18155 31.656 4.40256C31.8963 4.62357 32.0312 4.92332 32.0312 5.23588V7.59285H33.3125V5.23588C33.3125 4.61077 33.0425 4.01126 32.562 3.56925C32.0814 3.12723 31.4296 2.87891 30.75 2.87891H28.1875Z" fill="#EF7221"/>
                                <path d="M7.6875 7.5924L7.6875 31.1621H8.96875L8.96875 7.5924H7.6875Z" fill="#EF7221"/>
                                <path d="M12.8125 2.87891V4.05739H10.25C9.91019 4.05739 9.5843 4.18155 9.34402 4.40256C9.10374 4.62357 8.96875 4.92332 8.96875 5.23588V7.59285H7.6875V5.23588C7.6875 4.61077 7.95748 4.01126 8.43804 3.56925C8.9186 3.12723 9.57038 2.87891 10.25 2.87891H12.8125Z" fill="#EF7221"/>
                                <path d="M28.1875 35.8761V34.6976H30.75C31.0898 34.6976 31.4157 34.5734 31.656 34.3524C31.8963 34.1314 32.0312 33.8316 32.0312 33.5191V31.1621H33.3125V33.5191C33.3125 34.1442 33.0425 34.7437 32.562 35.1857C32.0814 35.6277 31.4296 35.8761 30.75 35.8761H28.1875Z" fill="#EF7221"/>
                                <path d="M12.8125 35.8761V34.6976H10.25C9.91019 34.6976 9.5843 34.5734 9.34402 34.3524C9.10374 34.1314 8.96875 33.8316 8.96875 33.5191V31.1621H7.6875V33.5191C7.6875 34.1442 7.95748 34.7437 8.43804 35.1857C8.9186 35.6277 9.57038 35.8761 10.25 35.8761H12.8125Z" fill="#EF7221"/>
                                <path d="M20.5 8.94922C19.9932 8.94922 19.4978 9.08745 19.0764 9.34644C18.655 9.60543 18.3265 9.97354 18.1326 10.4042C17.9386 10.8349 17.8879 11.3088 17.9867 11.766C18.0856 12.2232 18.3297 12.6432 18.688 12.9728C19.0464 13.3024 19.503 13.5269 20.0001 13.6179C20.4972 13.7088 21.0124 13.6621 21.4806 13.4837C21.9489 13.3054 22.3491 13.0033 22.6306 12.6157C22.9122 12.2281 23.0625 11.7724 23.0625 11.3062C23.0625 10.6811 22.7925 10.0816 22.312 9.63956C21.8314 9.19754 21.1796 8.94922 20.5 8.94922ZM20.5 12.4847C20.2466 12.4847 19.9989 12.4156 19.7882 12.2861C19.5775 12.1566 19.4133 11.9725 19.3163 11.7572C19.2193 11.5418 19.1939 11.3049 19.2434 11.0763C19.2928 10.8477 19.4148 10.6377 19.594 10.4729C19.7732 10.3081 20.0015 10.1958 20.25 10.1503C20.4986 10.1049 20.7562 10.1282 20.9903 10.2174C21.2244 10.3066 21.4245 10.4577 21.5653 10.6515C21.7061 10.8453 21.7813 11.0731 21.7813 11.3062C21.7813 11.6187 21.6463 11.9185 21.406 12.1395C21.1657 12.3605 20.8398 12.4847 20.5 12.4847Z" fill="#EF7221"/>
                              </svg>
                            </div>
                            <h5 class="fw-semibold">Presentation skills</h5>
                            <p class="mb-0 p-0">Teach students to present ideas concisely and effectively.</p>
                        </div>
                      </div>
                    </div>
                    <div class="col-12 col-sm-6 col-lg-6 mb-3">
                      <div class="card h-100 roadmap-block border-0 bg-theme-light">
                        <div class="card-body p-lg-4">
                            <div class="cardicon mb-3 d-flex justify-content-center align-items-center">
                              <svg xmlns="http://www.w3.org/2000/svg" width="41" height="38" viewBox="0 0 41 38" fill="none">
                                <path d="M26.7028 19.1634H25.819C25.819 16.2347 23.4447 13.8604 20.5159 13.8604C17.5872 13.8604 15.2129 16.2347 15.2129 19.1634H14.3291C14.3291 15.7465 17.099 12.9766 20.5159 12.9766C23.9327 12.9766 26.7028 15.7465 26.7028 19.1634Z" fill="#EF7221"/>
                                <path d="M18.748 32.8633H22.2834V33.7471H18.748V32.8633Z" fill="#EF7221"/>
                                <path d="M28.1875 34.6973H12.8125V35.8758H28.1875V34.6973Z" fill="#EF7221"/>
                                <path d="M28.1875 2.87891H12.8125V4.05739H28.1875V2.87891Z" fill="#EF7221"/>
                                <path d="M28.1875 24.0918H16.6562V25.2703H28.1875V24.0918Z" fill="#EF7221"/>
                                <path d="M15.375 24.0918H12.8125V25.2703H15.375V24.0918Z" fill="#EF7221"/>
                                <path d="M28.1875 27.627H16.6562V28.8054H28.1875V27.627Z" fill="#EF7221"/>
                                <path d="M15.375 27.627H12.8125V28.8054H15.375V27.627Z" fill="#EF7221"/>
                                <path d="M32.0312 7.5924V31.1621H33.3125V7.5924H32.0312Z" fill="#EF7221"/>
                                <path d="M28.1875 2.87891V4.05739H30.75C31.0898 4.05739 31.4157 4.18155 31.656 4.40256C31.8963 4.62357 32.0312 4.92332 32.0312 5.23588V7.59285H33.3125V5.23588C33.3125 4.61077 33.0425 4.01126 32.562 3.56925C32.0814 3.12723 31.4296 2.87891 30.75 2.87891H28.1875Z" fill="#EF7221"/>
                                <path d="M7.6875 7.5924L7.6875 31.1621H8.96875L8.96875 7.5924H7.6875Z" fill="#EF7221"/>
                                <path d="M12.8125 2.87891V4.05739H10.25C9.91019 4.05739 9.5843 4.18155 9.34402 4.40256C9.10374 4.62357 8.96875 4.92332 8.96875 5.23588V7.59285H7.6875V5.23588C7.6875 4.61077 7.95748 4.01126 8.43804 3.56925C8.9186 3.12723 9.57038 2.87891 10.25 2.87891H12.8125Z" fill="#EF7221"/>
                                <path d="M28.1875 35.8761V34.6976H30.75C31.0898 34.6976 31.4157 34.5734 31.656 34.3524C31.8963 34.1314 32.0312 33.8316 32.0312 33.5191V31.1621H33.3125V33.5191C33.3125 34.1442 33.0425 34.7437 32.562 35.1857C32.0814 35.6277 31.4296 35.8761 30.75 35.8761H28.1875Z" fill="#EF7221"/>
                                <path d="M12.8125 35.8761V34.6976H10.25C9.91019 34.6976 9.5843 34.5734 9.34402 34.3524C9.10374 34.1314 8.96875 33.8316 8.96875 33.5191V31.1621H7.6875V33.5191C7.6875 34.1442 7.95748 34.7437 8.43804 35.1857C8.9186 35.6277 9.57038 35.8761 10.25 35.8761H12.8125Z" fill="#EF7221"/>
                                <path d="M20.5 8.94922C19.9932 8.94922 19.4978 9.08745 19.0764 9.34644C18.655 9.60543 18.3265 9.97354 18.1326 10.4042C17.9386 10.8349 17.8879 11.3088 17.9867 11.766C18.0856 12.2232 18.3297 12.6432 18.688 12.9728C19.0464 13.3024 19.503 13.5269 20.0001 13.6179C20.4972 13.7088 21.0124 13.6621 21.4806 13.4837C21.9489 13.3054 22.3491 13.0033 22.6306 12.6157C22.9122 12.2281 23.0625 11.7724 23.0625 11.3062C23.0625 10.6811 22.7925 10.0816 22.312 9.63956C21.8314 9.19754 21.1796 8.94922 20.5 8.94922ZM20.5 12.4847C20.2466 12.4847 19.9989 12.4156 19.7882 12.2861C19.5775 12.1566 19.4133 11.9725 19.3163 11.7572C19.2193 11.5418 19.1939 11.3049 19.2434 11.0763C19.2928 10.8477 19.4148 10.6377 19.594 10.4729C19.7732 10.3081 20.0015 10.1958 20.25 10.1503C20.4986 10.1049 20.7562 10.1282 20.9903 10.2174C21.2244 10.3066 21.4245 10.4577 21.5653 10.6515C21.7061 10.8453 21.7813 11.0731 21.7813 11.3062C21.7813 11.6187 21.6463 11.9185 21.406 12.1395C21.1657 12.3605 20.8398 12.4847 20.5 12.4847Z" fill="#EF7221"/>
                              </svg>
                            </div>
                            <h5 class="fw-semibold">Interactive classes</h5>
                            <p class="mb-0 p-0">Focus on improving verbal and non-verbal communication.</p>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </li>
              <li class="nav-item" role="presentation">
                <a href="#" class="nav-link bg-white border rounded-1" data-bs-toggle="tab" data-bs-target="#Resume">Resume building masterclasses</a>
                <div class="mobile-view-tab d-none p-2">
                  <div class="row">
                    <div class="col-12 col-sm-6 col-lg-6 mb-3">
                      <div class="card h-100 roadmap-block border-0 bg-theme-light">
                        <div class="card-body p-lg-4">
                            <div class="cardicon mb-3 d-flex justify-content-center align-items-center">
                              <svg xmlns="http://www.w3.org/2000/svg" width="41" height="38" viewBox="0 0 41 38" fill="none">
                                <path d="M26.7028 19.1634H25.819C25.819 16.2347 23.4447 13.8604 20.5159 13.8604C17.5872 13.8604 15.2129 16.2347 15.2129 19.1634H14.3291C14.3291 15.7465 17.099 12.9766 20.5159 12.9766C23.9327 12.9766 26.7028 15.7465 26.7028 19.1634Z" fill="#EF7221"/>
                                <path d="M18.748 32.8633H22.2834V33.7471H18.748V32.8633Z" fill="#EF7221"/>
                                <path d="M28.1875 34.6973H12.8125V35.8758H28.1875V34.6973Z" fill="#EF7221"/>
                                <path d="M28.1875 2.87891H12.8125V4.05739H28.1875V2.87891Z" fill="#EF7221"/>
                                <path d="M28.1875 24.0918H16.6562V25.2703H28.1875V24.0918Z" fill="#EF7221"/>
                                <path d="M15.375 24.0918H12.8125V25.2703H15.375V24.0918Z" fill="#EF7221"/>
                                <path d="M28.1875 27.627H16.6562V28.8054H28.1875V27.627Z" fill="#EF7221"/>
                                <path d="M15.375 27.627H12.8125V28.8054H15.375V27.627Z" fill="#EF7221"/>
                                <path d="M32.0312 7.5924V31.1621H33.3125V7.5924H32.0312Z" fill="#EF7221"/>
                                <path d="M28.1875 2.87891V4.05739H30.75C31.0898 4.05739 31.4157 4.18155 31.656 4.40256C31.8963 4.62357 32.0312 4.92332 32.0312 5.23588V7.59285H33.3125V5.23588C33.3125 4.61077 33.0425 4.01126 32.562 3.56925C32.0814 3.12723 31.4296 2.87891 30.75 2.87891H28.1875Z" fill="#EF7221"/>
                                <path d="M7.6875 7.5924L7.6875 31.1621H8.96875L8.96875 7.5924H7.6875Z" fill="#EF7221"/>
                                <path d="M12.8125 2.87891V4.05739H10.25C9.91019 4.05739 9.5843 4.18155 9.34402 4.40256C9.10374 4.62357 8.96875 4.92332 8.96875 5.23588V7.59285H7.6875V5.23588C7.6875 4.61077 7.95748 4.01126 8.43804 3.56925C8.9186 3.12723 9.57038 2.87891 10.25 2.87891H12.8125Z" fill="#EF7221"/>
                                <path d="M28.1875 35.8761V34.6976H30.75C31.0898 34.6976 31.4157 34.5734 31.656 34.3524C31.8963 34.1314 32.0312 33.8316 32.0312 33.5191V31.1621H33.3125V33.5191C33.3125 34.1442 33.0425 34.7437 32.562 35.1857C32.0814 35.6277 31.4296 35.8761 30.75 35.8761H28.1875Z" fill="#EF7221"/>
                                <path d="M12.8125 35.8761V34.6976H10.25C9.91019 34.6976 9.5843 34.5734 9.34402 34.3524C9.10374 34.1314 8.96875 33.8316 8.96875 33.5191V31.1621H7.6875V33.5191C7.6875 34.1442 7.95748 34.7437 8.43804 35.1857C8.9186 35.6277 9.57038 35.8761 10.25 35.8761H12.8125Z" fill="#EF7221"/>
                                <path d="M20.5 8.94922C19.9932 8.94922 19.4978 9.08745 19.0764 9.34644C18.655 9.60543 18.3265 9.97354 18.1326 10.4042C17.9386 10.8349 17.8879 11.3088 17.9867 11.766C18.0856 12.2232 18.3297 12.6432 18.688 12.9728C19.0464 13.3024 19.503 13.5269 20.0001 13.6179C20.4972 13.7088 21.0124 13.6621 21.4806 13.4837C21.9489 13.3054 22.3491 13.0033 22.6306 12.6157C22.9122 12.2281 23.0625 11.7724 23.0625 11.3062C23.0625 10.6811 22.7925 10.0816 22.312 9.63956C21.8314 9.19754 21.1796 8.94922 20.5 8.94922ZM20.5 12.4847C20.2466 12.4847 19.9989 12.4156 19.7882 12.2861C19.5775 12.1566 19.4133 11.9725 19.3163 11.7572C19.2193 11.5418 19.1939 11.3049 19.2434 11.0763C19.2928 10.8477 19.4148 10.6377 19.594 10.4729C19.7732 10.3081 20.0015 10.1958 20.25 10.1503C20.4986 10.1049 20.7562 10.1282 20.9903 10.2174C21.2244 10.3066 21.4245 10.4577 21.5653 10.6515C21.7061 10.8453 21.7813 11.0731 21.7813 11.3062C21.7813 11.6187 21.6463 11.9185 21.406 12.1395C21.1657 12.3605 20.8398 12.4847 20.5 12.4847Z" fill="#EF7221"/>
                              </svg>
                            </div>
                            <h5 class="fw-semibold">Step by step guidance</h5>
                            <p class="mb-0 p-0">Help students structure professional, impactful resumes</p>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </li>
              <li class="nav-item" role="presentation">
                <a href="#" class="nav-link bg-white border rounded-1" data-bs-toggle="tab" data-bs-target="#Bridging">Bridging the Gap</a>
                <div class="mobile-view-tab d-none p-2">
                  <div class="row">
                    <div class="col-12 col-sm-6 col-lg-6 mb-3">
                      <div class="card h-100 roadmap-block border-0 bg-theme-light">
                        <div class="card-body p-lg-4">
                            <div class="cardicon mb-3 d-flex justify-content-center align-items-center">
                              <svg xmlns="http://www.w3.org/2000/svg" width="41" height="38" viewBox="0 0 41 38" fill="none">
                                <path d="M26.7028 19.1634H25.819C25.819 16.2347 23.4447 13.8604 20.5159 13.8604C17.5872 13.8604 15.2129 16.2347 15.2129 19.1634H14.3291C14.3291 15.7465 17.099 12.9766 20.5159 12.9766C23.9327 12.9766 26.7028 15.7465 26.7028 19.1634Z" fill="#EF7221"/>
                                <path d="M18.748 32.8633H22.2834V33.7471H18.748V32.8633Z" fill="#EF7221"/>
                                <path d="M28.1875 34.6973H12.8125V35.8758H28.1875V34.6973Z" fill="#EF7221"/>
                                <path d="M28.1875 2.87891H12.8125V4.05739H28.1875V2.87891Z" fill="#EF7221"/>
                                <path d="M28.1875 24.0918H16.6562V25.2703H28.1875V24.0918Z" fill="#EF7221"/>
                                <path d="M15.375 24.0918H12.8125V25.2703H15.375V24.0918Z" fill="#EF7221"/>
                                <path d="M28.1875 27.627H16.6562V28.8054H28.1875V27.627Z" fill="#EF7221"/>
                                <path d="M15.375 27.627H12.8125V28.8054H15.375V27.627Z" fill="#EF7221"/>
                                <path d="M32.0312 7.5924V31.1621H33.3125V7.5924H32.0312Z" fill="#EF7221"/>
                                <path d="M28.1875 2.87891V4.05739H30.75C31.0898 4.05739 31.4157 4.18155 31.656 4.40256C31.8963 4.62357 32.0312 4.92332 32.0312 5.23588V7.59285H33.3125V5.23588C33.3125 4.61077 33.0425 4.01126 32.562 3.56925C32.0814 3.12723 31.4296 2.87891 30.75 2.87891H28.1875Z" fill="#EF7221"/>
                                <path d="M7.6875 7.5924L7.6875 31.1621H8.96875L8.96875 7.5924H7.6875Z" fill="#EF7221"/>
                                <path d="M12.8125 2.87891V4.05739H10.25C9.91019 4.05739 9.5843 4.18155 9.34402 4.40256C9.10374 4.62357 8.96875 4.92332 8.96875 5.23588V7.59285H7.6875V5.23588C7.6875 4.61077 7.95748 4.01126 8.43804 3.56925C8.9186 3.12723 9.57038 2.87891 10.25 2.87891H12.8125Z" fill="#EF7221"/>
                                <path d="M28.1875 35.8761V34.6976H30.75C31.0898 34.6976 31.4157 34.5734 31.656 34.3524C31.8963 34.1314 32.0312 33.8316 32.0312 33.5191V31.1621H33.3125V33.5191C33.3125 34.1442 33.0425 34.7437 32.562 35.1857C32.0814 35.6277 31.4296 35.8761 30.75 35.8761H28.1875Z" fill="#EF7221"/>
                                <path d="M12.8125 35.8761V34.6976H10.25C9.91019 34.6976 9.5843 34.5734 9.34402 34.3524C9.10374 34.1314 8.96875 33.8316 8.96875 33.5191V31.1621H7.6875V33.5191C7.6875 34.1442 7.95748 34.7437 8.43804 35.1857C8.9186 35.6277 9.57038 35.8761 10.25 35.8761H12.8125Z" fill="#EF7221"/>
                                <path d="M20.5 8.94922C19.9932 8.94922 19.4978 9.08745 19.0764 9.34644C18.655 9.60543 18.3265 9.97354 18.1326 10.4042C17.9386 10.8349 17.8879 11.3088 17.9867 11.766C18.0856 12.2232 18.3297 12.6432 18.688 12.9728C19.0464 13.3024 19.503 13.5269 20.0001 13.6179C20.4972 13.7088 21.0124 13.6621 21.4806 13.4837C21.9489 13.3054 22.3491 13.0033 22.6306 12.6157C22.9122 12.2281 23.0625 11.7724 23.0625 11.3062C23.0625 10.6811 22.7925 10.0816 22.312 9.63956C21.8314 9.19754 21.1796 8.94922 20.5 8.94922ZM20.5 12.4847C20.2466 12.4847 19.9989 12.4156 19.7882 12.2861C19.5775 12.1566 19.4133 11.9725 19.3163 11.7572C19.2193 11.5418 19.1939 11.3049 19.2434 11.0763C19.2928 10.8477 19.4148 10.6377 19.594 10.4729C19.7732 10.3081 20.0015 10.1958 20.25 10.1503C20.4986 10.1049 20.7562 10.1282 20.9903 10.2174C21.2244 10.3066 21.4245 10.4577 21.5653 10.6515C21.7061 10.8453 21.7813 11.0731 21.7813 11.3062C21.7813 11.6187 21.6463 11.9185 21.406 12.1395C21.1657 12.3605 20.8398 12.4847 20.5 12.4847Z" fill="#EF7221"/>
                              </svg>
                            </div>
                            <h5 class="fw-semibold">Placement coordination</h5>
                            <ul class="list-unstyled">
                              <li>Connect candidates to aligned opportunities</li>
                              <li>Organize hiring events and recruitment drives.</li>
                            </ul>
                        </div>
                      </div>
                    </div>
                    <div class="col-12 col-sm-6 col-lg-6 mb-3">
                      <div class="card h-100 roadmap-block border-0 bg-theme-light">
                        <div class="card-body p-lg-4">
                            <div class="cardicon mb-3 d-flex justify-content-center align-items-center">
                              <svg xmlns="http://www.w3.org/2000/svg" width="41" height="38" viewBox="0 0 41 38" fill="none">
                                <path d="M26.7028 19.1634H25.819C25.819 16.2347 23.4447 13.8604 20.5159 13.8604C17.5872 13.8604 15.2129 16.2347 15.2129 19.1634H14.3291C14.3291 15.7465 17.099 12.9766 20.5159 12.9766C23.9327 12.9766 26.7028 15.7465 26.7028 19.1634Z" fill="#EF7221"/>
                                <path d="M18.748 32.8633H22.2834V33.7471H18.748V32.8633Z" fill="#EF7221"/>
                                <path d="M28.1875 34.6973H12.8125V35.8758H28.1875V34.6973Z" fill="#EF7221"/>
                                <path d="M28.1875 2.87891H12.8125V4.05739H28.1875V2.87891Z" fill="#EF7221"/>
                                <path d="M28.1875 24.0918H16.6562V25.2703H28.1875V24.0918Z" fill="#EF7221"/>
                                <path d="M15.375 24.0918H12.8125V25.2703H15.375V24.0918Z" fill="#EF7221"/>
                                <path d="M28.1875 27.627H16.6562V28.8054H28.1875V27.627Z" fill="#EF7221"/>
                                <path d="M15.375 27.627H12.8125V28.8054H15.375V27.627Z" fill="#EF7221"/>
                                <path d="M32.0312 7.5924V31.1621H33.3125V7.5924H32.0312Z" fill="#EF7221"/>
                                <path d="M28.1875 2.87891V4.05739H30.75C31.0898 4.05739 31.4157 4.18155 31.656 4.40256C31.8963 4.62357 32.0312 4.92332 32.0312 5.23588V7.59285H33.3125V5.23588C33.3125 4.61077 33.0425 4.01126 32.562 3.56925C32.0814 3.12723 31.4296 2.87891 30.75 2.87891H28.1875Z" fill="#EF7221"/>
                                <path d="M7.6875 7.5924L7.6875 31.1621H8.96875L8.96875 7.5924H7.6875Z" fill="#EF7221"/>
                                <path d="M12.8125 2.87891V4.05739H10.25C9.91019 4.05739 9.5843 4.18155 9.34402 4.40256C9.10374 4.62357 8.96875 4.92332 8.96875 5.23588V7.59285H7.6875V5.23588C7.6875 4.61077 7.95748 4.01126 8.43804 3.56925C8.9186 3.12723 9.57038 2.87891 10.25 2.87891H12.8125Z" fill="#EF7221"/>
                                <path d="M28.1875 35.8761V34.6976H30.75C31.0898 34.6976 31.4157 34.5734 31.656 34.3524C31.8963 34.1314 32.0312 33.8316 32.0312 33.5191V31.1621H33.3125V33.5191C33.3125 34.1442 33.0425 34.7437 32.562 35.1857C32.0814 35.6277 31.4296 35.8761 30.75 35.8761H28.1875Z" fill="#EF7221"/>
                                <path d="M12.8125 35.8761V34.6976H10.25C9.91019 34.6976 9.5843 34.5734 9.34402 34.3524C9.10374 34.1314 8.96875 33.8316 8.96875 33.5191V31.1621H7.6875V33.5191C7.6875 34.1442 7.95748 34.7437 8.43804 35.1857C8.9186 35.6277 9.57038 35.8761 10.25 35.8761H12.8125Z" fill="#EF7221"/>
                                <path d="M20.5 8.94922C19.9932 8.94922 19.4978 9.08745 19.0764 9.34644C18.655 9.60543 18.3265 9.97354 18.1326 10.4042C17.9386 10.8349 17.8879 11.3088 17.9867 11.766C18.0856 12.2232 18.3297 12.6432 18.688 12.9728C19.0464 13.3024 19.503 13.5269 20.0001 13.6179C20.4972 13.7088 21.0124 13.6621 21.4806 13.4837C21.9489 13.3054 22.3491 13.0033 22.6306 12.6157C22.9122 12.2281 23.0625 11.7724 23.0625 11.3062C23.0625 10.6811 22.7925 10.0816 22.312 9.63956C21.8314 9.19754 21.1796 8.94922 20.5 8.94922ZM20.5 12.4847C20.2466 12.4847 19.9989 12.4156 19.7882 12.2861C19.5775 12.1566 19.4133 11.9725 19.3163 11.7572C19.2193 11.5418 19.1939 11.3049 19.2434 11.0763C19.2928 10.8477 19.4148 10.6377 19.594 10.4729C19.7732 10.3081 20.0015 10.1958 20.25 10.1503C20.4986 10.1049 20.7562 10.1282 20.9903 10.2174C21.2244 10.3066 21.4245 10.4577 21.5653 10.6515C21.7061 10.8453 21.7813 11.0731 21.7813 11.3062C21.7813 11.6187 21.6463 11.9185 21.406 12.1395C21.1657 12.3605 20.8398 12.4847 20.5 12.4847Z" fill="#EF7221"/>
                              </svg>
                            </div>
                            <h5 class="fw-semibold">Industry networking</h5>
                            <ul class="list-unstyled">
                              <li>Partner with top companies for hiring pipelines</li>
                              <li>Conduct webinars and sessions with recruiters</li>
                            </ul>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </li>
              <li class="nav-item" role="presentation">
                <a href="#" class="nav-link bg-white border rounded-1" data-bs-toggle="tab" data-bs-target="#Advance">Advance interview boot camp</a>
                <div class="mobile-view-tab d-none p-2">
                  <div class="row">
                    <div class="col-12 col-sm-6 col-lg-6 mb-3">
                      <div class="card h-100 roadmap-block border-0 bg-theme-light">
                        <div class="card-body p-lg-4">
                            <div class="cardicon mb-3 d-flex justify-content-center align-items-center">
                              <svg xmlns="http://www.w3.org/2000/svg" width="41" height="38" viewBox="0 0 41 38" fill="none">
                                <path d="M26.7028 19.1634H25.819C25.819 16.2347 23.4447 13.8604 20.5159 13.8604C17.5872 13.8604 15.2129 16.2347 15.2129 19.1634H14.3291C14.3291 15.7465 17.099 12.9766 20.5159 12.9766C23.9327 12.9766 26.7028 15.7465 26.7028 19.1634Z" fill="#EF7221"/>
                                <path d="M18.748 32.8633H22.2834V33.7471H18.748V32.8633Z" fill="#EF7221"/>
                                <path d="M28.1875 34.6973H12.8125V35.8758H28.1875V34.6973Z" fill="#EF7221"/>
                                <path d="M28.1875 2.87891H12.8125V4.05739H28.1875V2.87891Z" fill="#EF7221"/>
                                <path d="M28.1875 24.0918H16.6562V25.2703H28.1875V24.0918Z" fill="#EF7221"/>
                                <path d="M15.375 24.0918H12.8125V25.2703H15.375V24.0918Z" fill="#EF7221"/>
                                <path d="M28.1875 27.627H16.6562V28.8054H28.1875V27.627Z" fill="#EF7221"/>
                                <path d="M15.375 27.627H12.8125V28.8054H15.375V27.627Z" fill="#EF7221"/>
                                <path d="M32.0312 7.5924V31.1621H33.3125V7.5924H32.0312Z" fill="#EF7221"/>
                                <path d="M28.1875 2.87891V4.05739H30.75C31.0898 4.05739 31.4157 4.18155 31.656 4.40256C31.8963 4.62357 32.0312 4.92332 32.0312 5.23588V7.59285H33.3125V5.23588C33.3125 4.61077 33.0425 4.01126 32.562 3.56925C32.0814 3.12723 31.4296 2.87891 30.75 2.87891H28.1875Z" fill="#EF7221"/>
                                <path d="M7.6875 7.5924L7.6875 31.1621H8.96875L8.96875 7.5924H7.6875Z" fill="#EF7221"/>
                                <path d="M12.8125 2.87891V4.05739H10.25C9.91019 4.05739 9.5843 4.18155 9.34402 4.40256C9.10374 4.62357 8.96875 4.92332 8.96875 5.23588V7.59285H7.6875V5.23588C7.6875 4.61077 7.95748 4.01126 8.43804 3.56925C8.9186 3.12723 9.57038 2.87891 10.25 2.87891H12.8125Z" fill="#EF7221"/>
                                <path d="M28.1875 35.8761V34.6976H30.75C31.0898 34.6976 31.4157 34.5734 31.656 34.3524C31.8963 34.1314 32.0312 33.8316 32.0312 33.5191V31.1621H33.3125V33.5191C33.3125 34.1442 33.0425 34.7437 32.562 35.1857C32.0814 35.6277 31.4296 35.8761 30.75 35.8761H28.1875Z" fill="#EF7221"/>
                                <path d="M12.8125 35.8761V34.6976H10.25C9.91019 34.6976 9.5843 34.5734 9.34402 34.3524C9.10374 34.1314 8.96875 33.8316 8.96875 33.5191V31.1621H7.6875V33.5191C7.6875 34.1442 7.95748 34.7437 8.43804 35.1857C8.9186 35.6277 9.57038 35.8761 10.25 35.8761H12.8125Z" fill="#EF7221"/>
                                <path d="M20.5 8.94922C19.9932 8.94922 19.4978 9.08745 19.0764 9.34644C18.655 9.60543 18.3265 9.97354 18.1326 10.4042C17.9386 10.8349 17.8879 11.3088 17.9867 11.766C18.0856 12.2232 18.3297 12.6432 18.688 12.9728C19.0464 13.3024 19.503 13.5269 20.0001 13.6179C20.4972 13.7088 21.0124 13.6621 21.4806 13.4837C21.9489 13.3054 22.3491 13.0033 22.6306 12.6157C22.9122 12.2281 23.0625 11.7724 23.0625 11.3062C23.0625 10.6811 22.7925 10.0816 22.312 9.63956C21.8314 9.19754 21.1796 8.94922 20.5 8.94922ZM20.5 12.4847C20.2466 12.4847 19.9989 12.4156 19.7882 12.2861C19.5775 12.1566 19.4133 11.9725 19.3163 11.7572C19.2193 11.5418 19.1939 11.3049 19.2434 11.0763C19.2928 10.8477 19.4148 10.6377 19.594 10.4729C19.7732 10.3081 20.0015 10.1958 20.25 10.1503C20.4986 10.1049 20.7562 10.1282 20.9903 10.2174C21.2244 10.3066 21.4245 10.4577 21.5653 10.6515C21.7061 10.8453 21.7813 11.0731 21.7813 11.3062C21.7813 11.6187 21.6463 11.9185 21.406 12.1395C21.1657 12.3605 20.8398 12.4847 20.5 12.4847Z" fill="#EF7221"/>
                              </svg>
                            </div>
                            <h5 class="fw-semibold">Scenario-Based Training</h5>
                            <p class="mb-0 p-0">Prepare students for various interview formats, including case studies, coding rounds, and group discussions.</p>
                        </div>
                      </div>
                    </div>
                    <div class="col-12 col-sm-6 col-lg-6 mb-3">
                      <div class="card h-100 roadmap-block border-0 bg-theme-light">
                        <div class="card-body p-lg-4">
                            <div class="cardicon mb-3 d-flex justify-content-center align-items-center">
                              <svg xmlns="http://www.w3.org/2000/svg" width="41" height="38" viewBox="0 0 41 38" fill="none">
                                <path d="M26.7028 19.1634H25.819C25.819 16.2347 23.4447 13.8604 20.5159 13.8604C17.5872 13.8604 15.2129 16.2347 15.2129 19.1634H14.3291C14.3291 15.7465 17.099 12.9766 20.5159 12.9766C23.9327 12.9766 26.7028 15.7465 26.7028 19.1634Z" fill="#EF7221"/>
                                <path d="M18.748 32.8633H22.2834V33.7471H18.748V32.8633Z" fill="#EF7221"/>
                                <path d="M28.1875 34.6973H12.8125V35.8758H28.1875V34.6973Z" fill="#EF7221"/>
                                <path d="M28.1875 2.87891H12.8125V4.05739H28.1875V2.87891Z" fill="#EF7221"/>
                                <path d="M28.1875 24.0918H16.6562V25.2703H28.1875V24.0918Z" fill="#EF7221"/>
                                <path d="M15.375 24.0918H12.8125V25.2703H15.375V24.0918Z" fill="#EF7221"/>
                                <path d="M28.1875 27.627H16.6562V28.8054H28.1875V27.627Z" fill="#EF7221"/>
                                <path d="M15.375 27.627H12.8125V28.8054H15.375V27.627Z" fill="#EF7221"/>
                                <path d="M32.0312 7.5924V31.1621H33.3125V7.5924H32.0312Z" fill="#EF7221"/>
                                <path d="M28.1875 2.87891V4.05739H30.75C31.0898 4.05739 31.4157 4.18155 31.656 4.40256C31.8963 4.62357 32.0312 4.92332 32.0312 5.23588V7.59285H33.3125V5.23588C33.3125 4.61077 33.0425 4.01126 32.562 3.56925C32.0814 3.12723 31.4296 2.87891 30.75 2.87891H28.1875Z" fill="#EF7221"/>
                                <path d="M7.6875 7.5924L7.6875 31.1621H8.96875L8.96875 7.5924H7.6875Z" fill="#EF7221"/>
                                <path d="M12.8125 2.87891V4.05739H10.25C9.91019 4.05739 9.5843 4.18155 9.34402 4.40256C9.10374 4.62357 8.96875 4.92332 8.96875 5.23588V7.59285H7.6875V5.23588C7.6875 4.61077 7.95748 4.01126 8.43804 3.56925C8.9186 3.12723 9.57038 2.87891 10.25 2.87891H12.8125Z" fill="#EF7221"/>
                                <path d="M28.1875 35.8761V34.6976H30.75C31.0898 34.6976 31.4157 34.5734 31.656 34.3524C31.8963 34.1314 32.0312 33.8316 32.0312 33.5191V31.1621H33.3125V33.5191C33.3125 34.1442 33.0425 34.7437 32.562 35.1857C32.0814 35.6277 31.4296 35.8761 30.75 35.8761H28.1875Z" fill="#EF7221"/>
                                <path d="M12.8125 35.8761V34.6976H10.25C9.91019 34.6976 9.5843 34.5734 9.34402 34.3524C9.10374 34.1314 8.96875 33.8316 8.96875 33.5191V31.1621H7.6875V33.5191C7.6875 34.1442 7.95748 34.7437 8.43804 35.1857C8.9186 35.6277 9.57038 35.8761 10.25 35.8761H12.8125Z" fill="#EF7221"/>
                                <path d="M20.5 8.94922C19.9932 8.94922 19.4978 9.08745 19.0764 9.34644C18.655 9.60543 18.3265 9.97354 18.1326 10.4042C17.9386 10.8349 17.8879 11.3088 17.9867 11.766C18.0856 12.2232 18.3297 12.6432 18.688 12.9728C19.0464 13.3024 19.503 13.5269 20.0001 13.6179C20.4972 13.7088 21.0124 13.6621 21.4806 13.4837C21.9489 13.3054 22.3491 13.0033 22.6306 12.6157C22.9122 12.2281 23.0625 11.7724 23.0625 11.3062C23.0625 10.6811 22.7925 10.0816 22.312 9.63956C21.8314 9.19754 21.1796 8.94922 20.5 8.94922ZM20.5 12.4847C20.2466 12.4847 19.9989 12.4156 19.7882 12.2861C19.5775 12.1566 19.4133 11.9725 19.3163 11.7572C19.2193 11.5418 19.1939 11.3049 19.2434 11.0763C19.2928 10.8477 19.4148 10.6377 19.594 10.4729C19.7732 10.3081 20.0015 10.1958 20.25 10.1503C20.4986 10.1049 20.7562 10.1282 20.9903 10.2174C21.2244 10.3066 21.4245 10.4577 21.5653 10.6515C21.7061 10.8453 21.7813 11.0731 21.7813 11.3062C21.7813 11.6187 21.6463 11.9185 21.406 12.1395C21.1657 12.3605 20.8398 12.4847 20.5 12.4847Z" fill="#EF7221"/>
                              </svg>
                            </div>
                            <h5 class="fw-semibold">Stress Management Techniques</h5>
                            <p class="mb-0 p-0">Equip students to handle high-pressure interview situations.</p>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </li>
              <li class="nav-item" role="presentation">
                <a href="#" class="nav-link bg-white border rounded-1" data-bs-toggle="tab" data-bs-target="#guidance">Personalized 1:1 guidance</a>
                <div class="mobile-view-tab d-none p-2">
                  <div class="row">
                    <div class="col-12 col-sm-6 col-lg-6 mb-3">
                      <div class="card h-100 roadmap-block border-0 bg-theme-light">
                        <div class="card-body p-lg-4">
                            <div class="cardicon mb-3 d-flex justify-content-center align-items-center">
                              <svg xmlns="http://www.w3.org/2000/svg" width="41" height="38" viewBox="0 0 41 38" fill="none">
                                <path d="M26.7028 19.1634H25.819C25.819 16.2347 23.4447 13.8604 20.5159 13.8604C17.5872 13.8604 15.2129 16.2347 15.2129 19.1634H14.3291C14.3291 15.7465 17.099 12.9766 20.5159 12.9766C23.9327 12.9766 26.7028 15.7465 26.7028 19.1634Z" fill="#EF7221"/>
                                <path d="M18.748 32.8633H22.2834V33.7471H18.748V32.8633Z" fill="#EF7221"/>
                                <path d="M28.1875 34.6973H12.8125V35.8758H28.1875V34.6973Z" fill="#EF7221"/>
                                <path d="M28.1875 2.87891H12.8125V4.05739H28.1875V2.87891Z" fill="#EF7221"/>
                                <path d="M28.1875 24.0918H16.6562V25.2703H28.1875V24.0918Z" fill="#EF7221"/>
                                <path d="M15.375 24.0918H12.8125V25.2703H15.375V24.0918Z" fill="#EF7221"/>
                                <path d="M28.1875 27.627H16.6562V28.8054H28.1875V27.627Z" fill="#EF7221"/>
                                <path d="M15.375 27.627H12.8125V28.8054H15.375V27.627Z" fill="#EF7221"/>
                                <path d="M32.0312 7.5924V31.1621H33.3125V7.5924H32.0312Z" fill="#EF7221"/>
                                <path d="M28.1875 2.87891V4.05739H30.75C31.0898 4.05739 31.4157 4.18155 31.656 4.40256C31.8963 4.62357 32.0312 4.92332 32.0312 5.23588V7.59285H33.3125V5.23588C33.3125 4.61077 33.0425 4.01126 32.562 3.56925C32.0814 3.12723 31.4296 2.87891 30.75 2.87891H28.1875Z" fill="#EF7221"/>
                                <path d="M7.6875 7.5924L7.6875 31.1621H8.96875L8.96875 7.5924H7.6875Z" fill="#EF7221"/>
                                <path d="M12.8125 2.87891V4.05739H10.25C9.91019 4.05739 9.5843 4.18155 9.34402 4.40256C9.10374 4.62357 8.96875 4.92332 8.96875 5.23588V7.59285H7.6875V5.23588C7.6875 4.61077 7.95748 4.01126 8.43804 3.56925C8.9186 3.12723 9.57038 2.87891 10.25 2.87891H12.8125Z" fill="#EF7221"/>
                                <path d="M28.1875 35.8761V34.6976H30.75C31.0898 34.6976 31.4157 34.5734 31.656 34.3524C31.8963 34.1314 32.0312 33.8316 32.0312 33.5191V31.1621H33.3125V33.5191C33.3125 34.1442 33.0425 34.7437 32.562 35.1857C32.0814 35.6277 31.4296 35.8761 30.75 35.8761H28.1875Z" fill="#EF7221"/>
                                <path d="M12.8125 35.8761V34.6976H10.25C9.91019 34.6976 9.5843 34.5734 9.34402 34.3524C9.10374 34.1314 8.96875 33.8316 8.96875 33.5191V31.1621H7.6875V33.5191C7.6875 34.1442 7.95748 34.7437 8.43804 35.1857C8.9186 35.6277 9.57038 35.8761 10.25 35.8761H12.8125Z" fill="#EF7221"/>
                                <path d="M20.5 8.94922C19.9932 8.94922 19.4978 9.08745 19.0764 9.34644C18.655 9.60543 18.3265 9.97354 18.1326 10.4042C17.9386 10.8349 17.8879 11.3088 17.9867 11.766C18.0856 12.2232 18.3297 12.6432 18.688 12.9728C19.0464 13.3024 19.503 13.5269 20.0001 13.6179C20.4972 13.7088 21.0124 13.6621 21.4806 13.4837C21.9489 13.3054 22.3491 13.0033 22.6306 12.6157C22.9122 12.2281 23.0625 11.7724 23.0625 11.3062C23.0625 10.6811 22.7925 10.0816 22.312 9.63956C21.8314 9.19754 21.1796 8.94922 20.5 8.94922ZM20.5 12.4847C20.2466 12.4847 19.9989 12.4156 19.7882 12.2861C19.5775 12.1566 19.4133 11.9725 19.3163 11.7572C19.2193 11.5418 19.1939 11.3049 19.2434 11.0763C19.2928 10.8477 19.4148 10.6377 19.594 10.4729C19.7732 10.3081 20.0015 10.1958 20.25 10.1503C20.4986 10.1049 20.7562 10.1282 20.9903 10.2174C21.2244 10.3066 21.4245 10.4577 21.5653 10.6515C21.7061 10.8453 21.7813 11.0731 21.7813 11.3062C21.7813 11.6187 21.6463 11.9185 21.406 12.1395C21.1657 12.3605 20.8398 12.4847 20.5 12.4847Z" fill="#EF7221"/>
                              </svg>
                            </div>
                            <h5 class="fw-semibold">Individual Sessions</h5>
                            <ul class="list-unstyled">
                              <li>Address specific weaknesses and barriers to success</li>
                              <li>Develop personalized improvement plans</li>
                            </ul>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </li>
            </ul>
          </div>
          <div class="col-12 col-md-8">
            <div class="tab-content d-none d-md-block" id="myTabContent">
              <div class="tab-pane fade show active" id="Foundation">
                <div class="row">
                  <div class="col-12 col-sm-6 col-lg-6 mb-3">
                    <div class="card h-100 roadmap-block border-0 bg-theme-light">
                      <div class="card-body p-lg-4">
                          <div class="cardicon mb-3 d-flex justify-content-center align-items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" width="41" height="38" viewBox="0 0 41 38" fill="none">
                              <path d="M26.7028 19.1634H25.819C25.819 16.2347 23.4447 13.8604 20.5159 13.8604C17.5872 13.8604 15.2129 16.2347 15.2129 19.1634H14.3291C14.3291 15.7465 17.099 12.9766 20.5159 12.9766C23.9327 12.9766 26.7028 15.7465 26.7028 19.1634Z" fill="#EF7221"/>
                              <path d="M18.748 32.8633H22.2834V33.7471H18.748V32.8633Z" fill="#EF7221"/>
                              <path d="M28.1875 34.6973H12.8125V35.8758H28.1875V34.6973Z" fill="#EF7221"/>
                              <path d="M28.1875 2.87891H12.8125V4.05739H28.1875V2.87891Z" fill="#EF7221"/>
                              <path d="M28.1875 24.0918H16.6562V25.2703H28.1875V24.0918Z" fill="#EF7221"/>
                              <path d="M15.375 24.0918H12.8125V25.2703H15.375V24.0918Z" fill="#EF7221"/>
                              <path d="M28.1875 27.627H16.6562V28.8054H28.1875V27.627Z" fill="#EF7221"/>
                              <path d="M15.375 27.627H12.8125V28.8054H15.375V27.627Z" fill="#EF7221"/>
                              <path d="M32.0312 7.5924V31.1621H33.3125V7.5924H32.0312Z" fill="#EF7221"/>
                              <path d="M28.1875 2.87891V4.05739H30.75C31.0898 4.05739 31.4157 4.18155 31.656 4.40256C31.8963 4.62357 32.0312 4.92332 32.0312 5.23588V7.59285H33.3125V5.23588C33.3125 4.61077 33.0425 4.01126 32.562 3.56925C32.0814 3.12723 31.4296 2.87891 30.75 2.87891H28.1875Z" fill="#EF7221"/>
                              <path d="M7.6875 7.5924L7.6875 31.1621H8.96875L8.96875 7.5924H7.6875Z" fill="#EF7221"/>
                              <path d="M12.8125 2.87891V4.05739H10.25C9.91019 4.05739 9.5843 4.18155 9.34402 4.40256C9.10374 4.62357 8.96875 4.92332 8.96875 5.23588V7.59285H7.6875V5.23588C7.6875 4.61077 7.95748 4.01126 8.43804 3.56925C8.9186 3.12723 9.57038 2.87891 10.25 2.87891H12.8125Z" fill="#EF7221"/>
                              <path d="M28.1875 35.8761V34.6976H30.75C31.0898 34.6976 31.4157 34.5734 31.656 34.3524C31.8963 34.1314 32.0312 33.8316 32.0312 33.5191V31.1621H33.3125V33.5191C33.3125 34.1442 33.0425 34.7437 32.562 35.1857C32.0814 35.6277 31.4296 35.8761 30.75 35.8761H28.1875Z" fill="#EF7221"/>
                              <path d="M12.8125 35.8761V34.6976H10.25C9.91019 34.6976 9.5843 34.5734 9.34402 34.3524C9.10374 34.1314 8.96875 33.8316 8.96875 33.5191V31.1621H7.6875V33.5191C7.6875 34.1442 7.95748 34.7437 8.43804 35.1857C8.9186 35.6277 9.57038 35.8761 10.25 35.8761H12.8125Z" fill="#EF7221"/>
                              <path d="M20.5 8.94922C19.9932 8.94922 19.4978 9.08745 19.0764 9.34644C18.655 9.60543 18.3265 9.97354 18.1326 10.4042C17.9386 10.8349 17.8879 11.3088 17.9867 11.766C18.0856 12.2232 18.3297 12.6432 18.688 12.9728C19.0464 13.3024 19.503 13.5269 20.0001 13.6179C20.4972 13.7088 21.0124 13.6621 21.4806 13.4837C21.9489 13.3054 22.3491 13.0033 22.6306 12.6157C22.9122 12.2281 23.0625 11.7724 23.0625 11.3062C23.0625 10.6811 22.7925 10.0816 22.312 9.63956C21.8314 9.19754 21.1796 8.94922 20.5 8.94922ZM20.5 12.4847C20.2466 12.4847 19.9989 12.4156 19.7882 12.2861C19.5775 12.1566 19.4133 11.9725 19.3163 11.7572C19.2193 11.5418 19.1939 11.3049 19.2434 11.0763C19.2928 10.8477 19.4148 10.6377 19.594 10.4729C19.7732 10.3081 20.0015 10.1958 20.25 10.1503C20.4986 10.1049 20.7562 10.1282 20.9903 10.2174C21.2244 10.3066 21.4245 10.4577 21.5653 10.6515C21.7061 10.8453 21.7813 11.0731 21.7813 11.3062C21.7813 11.6187 21.6463 11.9185 21.406 12.1395C21.1657 12.3605 20.8398 12.4847 20.5 12.4847Z" fill="#EF7221"/>
                            </svg>
                          </div>
                          <h5 class="fw-semibold">Expert Training sessions</h5>
                          <p class="mb-0 p-0">Focus on industry-relevant skills</p>
                      </div>
                    </div>
                  </div>
                  <div class="col-12 col-sm-6 col-lg-6 mb-3">
                    <div class="card h-100 roadmap-block border-0 bg-theme-light">
                      <div class="card-body p-lg-4">
                          <div class="cardicon mb-3 d-flex justify-content-center align-items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" width="41" height="38" viewBox="0 0 41 38" fill="none">
                              <path d="M26.7028 19.1634H25.819C25.819 16.2347 23.4447 13.8604 20.5159 13.8604C17.5872 13.8604 15.2129 16.2347 15.2129 19.1634H14.3291C14.3291 15.7465 17.099 12.9766 20.5159 12.9766C23.9327 12.9766 26.7028 15.7465 26.7028 19.1634Z" fill="#EF7221"/>
                              <path d="M18.748 32.8633H22.2834V33.7471H18.748V32.8633Z" fill="#EF7221"/>
                              <path d="M28.1875 34.6973H12.8125V35.8758H28.1875V34.6973Z" fill="#EF7221"/>
                              <path d="M28.1875 2.87891H12.8125V4.05739H28.1875V2.87891Z" fill="#EF7221"/>
                              <path d="M28.1875 24.0918H16.6562V25.2703H28.1875V24.0918Z" fill="#EF7221"/>
                              <path d="M15.375 24.0918H12.8125V25.2703H15.375V24.0918Z" fill="#EF7221"/>
                              <path d="M28.1875 27.627H16.6562V28.8054H28.1875V27.627Z" fill="#EF7221"/>
                              <path d="M15.375 27.627H12.8125V28.8054H15.375V27.627Z" fill="#EF7221"/>
                              <path d="M32.0312 7.5924V31.1621H33.3125V7.5924H32.0312Z" fill="#EF7221"/>
                              <path d="M28.1875 2.87891V4.05739H30.75C31.0898 4.05739 31.4157 4.18155 31.656 4.40256C31.8963 4.62357 32.0312 4.92332 32.0312 5.23588V7.59285H33.3125V5.23588C33.3125 4.61077 33.0425 4.01126 32.562 3.56925C32.0814 3.12723 31.4296 2.87891 30.75 2.87891H28.1875Z" fill="#EF7221"/>
                              <path d="M7.6875 7.5924L7.6875 31.1621H8.96875L8.96875 7.5924H7.6875Z" fill="#EF7221"/>
                              <path d="M12.8125 2.87891V4.05739H10.25C9.91019 4.05739 9.5843 4.18155 9.34402 4.40256C9.10374 4.62357 8.96875 4.92332 8.96875 5.23588V7.59285H7.6875V5.23588C7.6875 4.61077 7.95748 4.01126 8.43804 3.56925C8.9186 3.12723 9.57038 2.87891 10.25 2.87891H12.8125Z" fill="#EF7221"/>
                              <path d="M28.1875 35.8761V34.6976H30.75C31.0898 34.6976 31.4157 34.5734 31.656 34.3524C31.8963 34.1314 32.0312 33.8316 32.0312 33.5191V31.1621H33.3125V33.5191C33.3125 34.1442 33.0425 34.7437 32.562 35.1857C32.0814 35.6277 31.4296 35.8761 30.75 35.8761H28.1875Z" fill="#EF7221"/>
                              <path d="M12.8125 35.8761V34.6976H10.25C9.91019 34.6976 9.5843 34.5734 9.34402 34.3524C9.10374 34.1314 8.96875 33.8316 8.96875 33.5191V31.1621H7.6875V33.5191C7.6875 34.1442 7.95748 34.7437 8.43804 35.1857C8.9186 35.6277 9.57038 35.8761 10.25 35.8761H12.8125Z" fill="#EF7221"/>
                              <path d="M20.5 8.94922C19.9932 8.94922 19.4978 9.08745 19.0764 9.34644C18.655 9.60543 18.3265 9.97354 18.1326 10.4042C17.9386 10.8349 17.8879 11.3088 17.9867 11.766C18.0856 12.2232 18.3297 12.6432 18.688 12.9728C19.0464 13.3024 19.503 13.5269 20.0001 13.6179C20.4972 13.7088 21.0124 13.6621 21.4806 13.4837C21.9489 13.3054 22.3491 13.0033 22.6306 12.6157C22.9122 12.2281 23.0625 11.7724 23.0625 11.3062C23.0625 10.6811 22.7925 10.0816 22.312 9.63956C21.8314 9.19754 21.1796 8.94922 20.5 8.94922ZM20.5 12.4847C20.2466 12.4847 19.9989 12.4156 19.7882 12.2861C19.5775 12.1566 19.4133 11.9725 19.3163 11.7572C19.2193 11.5418 19.1939 11.3049 19.2434 11.0763C19.2928 10.8477 19.4148 10.6377 19.594 10.4729C19.7732 10.3081 20.0015 10.1958 20.25 10.1503C20.4986 10.1049 20.7562 10.1282 20.9903 10.2174C21.2244 10.3066 21.4245 10.4577 21.5653 10.6515C21.7061 10.8453 21.7813 11.0731 21.7813 11.3062C21.7813 11.6187 21.6463 11.9185 21.406 12.1395C21.1657 12.3605 20.8398 12.4847 20.5 12.4847Z" fill="#EF7221"/>
                            </svg>
                          </div>
                          <h5 class="fw-semibold">Hands on projects & Assignments</h5>
                          <p class="mb-0 p-0">Real-world projects to implement learned concepts.</p>
                      </div>
                    </div>
                  </div>
                  <div class="col-12 col-sm-6 col-lg-6 mb-3">
                    <div class="card h-100 roadmap-block border-0 bg-theme-light">
                      <div class="card-body p-lg-4">
                          <div class="cardicon mb-3 d-flex justify-content-center align-items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" width="41" height="38" viewBox="0 0 41 38" fill="none">
                              <path d="M26.7028 19.1634H25.819C25.819 16.2347 23.4447 13.8604 20.5159 13.8604C17.5872 13.8604 15.2129 16.2347 15.2129 19.1634H14.3291C14.3291 15.7465 17.099 12.9766 20.5159 12.9766C23.9327 12.9766 26.7028 15.7465 26.7028 19.1634Z" fill="#EF7221"/>
                              <path d="M18.748 32.8633H22.2834V33.7471H18.748V32.8633Z" fill="#EF7221"/>
                              <path d="M28.1875 34.6973H12.8125V35.8758H28.1875V34.6973Z" fill="#EF7221"/>
                              <path d="M28.1875 2.87891H12.8125V4.05739H28.1875V2.87891Z" fill="#EF7221"/>
                              <path d="M28.1875 24.0918H16.6562V25.2703H28.1875V24.0918Z" fill="#EF7221"/>
                              <path d="M15.375 24.0918H12.8125V25.2703H15.375V24.0918Z" fill="#EF7221"/>
                              <path d="M28.1875 27.627H16.6562V28.8054H28.1875V27.627Z" fill="#EF7221"/>
                              <path d="M15.375 27.627H12.8125V28.8054H15.375V27.627Z" fill="#EF7221"/>
                              <path d="M32.0312 7.5924V31.1621H33.3125V7.5924H32.0312Z" fill="#EF7221"/>
                              <path d="M28.1875 2.87891V4.05739H30.75C31.0898 4.05739 31.4157 4.18155 31.656 4.40256C31.8963 4.62357 32.0312 4.92332 32.0312 5.23588V7.59285H33.3125V5.23588C33.3125 4.61077 33.0425 4.01126 32.562 3.56925C32.0814 3.12723 31.4296 2.87891 30.75 2.87891H28.1875Z" fill="#EF7221"/>
                              <path d="M7.6875 7.5924L7.6875 31.1621H8.96875L8.96875 7.5924H7.6875Z" fill="#EF7221"/>
                              <path d="M12.8125 2.87891V4.05739H10.25C9.91019 4.05739 9.5843 4.18155 9.34402 4.40256C9.10374 4.62357 8.96875 4.92332 8.96875 5.23588V7.59285H7.6875V5.23588C7.6875 4.61077 7.95748 4.01126 8.43804 3.56925C8.9186 3.12723 9.57038 2.87891 10.25 2.87891H12.8125Z" fill="#EF7221"/>
                              <path d="M28.1875 35.8761V34.6976H30.75C31.0898 34.6976 31.4157 34.5734 31.656 34.3524C31.8963 34.1314 32.0312 33.8316 32.0312 33.5191V31.1621H33.3125V33.5191C33.3125 34.1442 33.0425 34.7437 32.562 35.1857C32.0814 35.6277 31.4296 35.8761 30.75 35.8761H28.1875Z" fill="#EF7221"/>
                              <path d="M12.8125 35.8761V34.6976H10.25C9.91019 34.6976 9.5843 34.5734 9.34402 34.3524C9.10374 34.1314 8.96875 33.8316 8.96875 33.5191V31.1621H7.6875V33.5191C7.6875 34.1442 7.95748 34.7437 8.43804 35.1857C8.9186 35.6277 9.57038 35.8761 10.25 35.8761H12.8125Z" fill="#EF7221"/>
                              <path d="M20.5 8.94922C19.9932 8.94922 19.4978 9.08745 19.0764 9.34644C18.655 9.60543 18.3265 9.97354 18.1326 10.4042C17.9386 10.8349 17.8879 11.3088 17.9867 11.766C18.0856 12.2232 18.3297 12.6432 18.688 12.9728C19.0464 13.3024 19.503 13.5269 20.0001 13.6179C20.4972 13.7088 21.0124 13.6621 21.4806 13.4837C21.9489 13.3054 22.3491 13.0033 22.6306 12.6157C22.9122 12.2281 23.0625 11.7724 23.0625 11.3062C23.0625 10.6811 22.7925 10.0816 22.312 9.63956C21.8314 9.19754 21.1796 8.94922 20.5 8.94922ZM20.5 12.4847C20.2466 12.4847 19.9989 12.4156 19.7882 12.2861C19.5775 12.1566 19.4133 11.9725 19.3163 11.7572C19.2193 11.5418 19.1939 11.3049 19.2434 11.0763C19.2928 10.8477 19.4148 10.6377 19.594 10.4729C19.7732 10.3081 20.0015 10.1958 20.25 10.1503C20.4986 10.1049 20.7562 10.1282 20.9903 10.2174C21.2244 10.3066 21.4245 10.4577 21.5653 10.6515C21.7061 10.8453 21.7813 11.0731 21.7813 11.3062C21.7813 11.6187 21.6463 11.9185 21.406 12.1395C21.1657 12.3605 20.8398 12.4847 20.5 12.4847Z" fill="#EF7221"/>
                            </svg>
                          </div>
                          <h5 class="fw-semibold">Performance Tracking</h5>
                          <p class="mb-0 p-0">Weekly tests to assess progress</p>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="tab-pane fade" id="Science">
                <div class="row">
                  <div class="col-12 col-sm-6 col-lg-6 mb-3">
                    <div class="card h-100 roadmap-block border-0 bg-theme-light">
                      <div class="card-body p-lg-4">
                          <div class="cardicon mb-3 d-flex justify-content-center align-items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" width="41" height="38" viewBox="0 0 41 38" fill="none">
                              <path d="M26.7028 19.1634H25.819C25.819 16.2347 23.4447 13.8604 20.5159 13.8604C17.5872 13.8604 15.2129 16.2347 15.2129 19.1634H14.3291C14.3291 15.7465 17.099 12.9766 20.5159 12.9766C23.9327 12.9766 26.7028 15.7465 26.7028 19.1634Z" fill="#EF7221"/>
                              <path d="M18.748 32.8633H22.2834V33.7471H18.748V32.8633Z" fill="#EF7221"/>
                              <path d="M28.1875 34.6973H12.8125V35.8758H28.1875V34.6973Z" fill="#EF7221"/>
                              <path d="M28.1875 2.87891H12.8125V4.05739H28.1875V2.87891Z" fill="#EF7221"/>
                              <path d="M28.1875 24.0918H16.6562V25.2703H28.1875V24.0918Z" fill="#EF7221"/>
                              <path d="M15.375 24.0918H12.8125V25.2703H15.375V24.0918Z" fill="#EF7221"/>
                              <path d="M28.1875 27.627H16.6562V28.8054H28.1875V27.627Z" fill="#EF7221"/>
                              <path d="M15.375 27.627H12.8125V28.8054H15.375V27.627Z" fill="#EF7221"/>
                              <path d="M32.0312 7.5924V31.1621H33.3125V7.5924H32.0312Z" fill="#EF7221"/>
                              <path d="M28.1875 2.87891V4.05739H30.75C31.0898 4.05739 31.4157 4.18155 31.656 4.40256C31.8963 4.62357 32.0312 4.92332 32.0312 5.23588V7.59285H33.3125V5.23588C33.3125 4.61077 33.0425 4.01126 32.562 3.56925C32.0814 3.12723 31.4296 2.87891 30.75 2.87891H28.1875Z" fill="#EF7221"/>
                              <path d="M7.6875 7.5924L7.6875 31.1621H8.96875L8.96875 7.5924H7.6875Z" fill="#EF7221"/>
                              <path d="M12.8125 2.87891V4.05739H10.25C9.91019 4.05739 9.5843 4.18155 9.34402 4.40256C9.10374 4.62357 8.96875 4.92332 8.96875 5.23588V7.59285H7.6875V5.23588C7.6875 4.61077 7.95748 4.01126 8.43804 3.56925C8.9186 3.12723 9.57038 2.87891 10.25 2.87891H12.8125Z" fill="#EF7221"/>
                              <path d="M28.1875 35.8761V34.6976H30.75C31.0898 34.6976 31.4157 34.5734 31.656 34.3524C31.8963 34.1314 32.0312 33.8316 32.0312 33.5191V31.1621H33.3125V33.5191C33.3125 34.1442 33.0425 34.7437 32.562 35.1857C32.0814 35.6277 31.4296 35.8761 30.75 35.8761H28.1875Z" fill="#EF7221"/>
                              <path d="M12.8125 35.8761V34.6976H10.25C9.91019 34.6976 9.5843 34.5734 9.34402 34.3524C9.10374 34.1314 8.96875 33.8316 8.96875 33.5191V31.1621H7.6875V33.5191C7.6875 34.1442 7.95748 34.7437 8.43804 35.1857C8.9186 35.6277 9.57038 35.8761 10.25 35.8761H12.8125Z" fill="#EF7221"/>
                              <path d="M20.5 8.94922C19.9932 8.94922 19.4978 9.08745 19.0764 9.34644C18.655 9.60543 18.3265 9.97354 18.1326 10.4042C17.9386 10.8349 17.8879 11.3088 17.9867 11.766C18.0856 12.2232 18.3297 12.6432 18.688 12.9728C19.0464 13.3024 19.503 13.5269 20.0001 13.6179C20.4972 13.7088 21.0124 13.6621 21.4806 13.4837C21.9489 13.3054 22.3491 13.0033 22.6306 12.6157C22.9122 12.2281 23.0625 11.7724 23.0625 11.3062C23.0625 10.6811 22.7925 10.0816 22.312 9.63956C21.8314 9.19754 21.1796 8.94922 20.5 8.94922ZM20.5 12.4847C20.2466 12.4847 19.9989 12.4156 19.7882 12.2861C19.5775 12.1566 19.4133 11.9725 19.3163 11.7572C19.2193 11.5418 19.1939 11.3049 19.2434 11.0763C19.2928 10.8477 19.4148 10.6377 19.594 10.4729C19.7732 10.3081 20.0015 10.1958 20.25 10.1503C20.4986 10.1049 20.7562 10.1282 20.9903 10.2174C21.2244 10.3066 21.4245 10.4577 21.5653 10.6515C21.7061 10.8453 21.7813 11.0731 21.7813 11.3062C21.7813 11.6187 21.6463 11.9185 21.406 12.1395C21.1657 12.3605 20.8398 12.4847 20.5 12.4847Z" fill="#EF7221"/>
                            </svg>
                          </div>
                          <h5 class="fw-semibold">Mock Interviews</h5>
                          <p class="mb-0 p-0">mock sessions with real-time feedback from experts</p>
                      </div>
                    </div>
                  </div>
                  <div class="col-12 col-sm-6 col-lg-6 mb-3">
                    <div class="card h-100 roadmap-block border-0 bg-theme-light">
                      <div class="card-body p-lg-4">
                          <div class="cardicon mb-3 d-flex justify-content-center align-items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" width="41" height="38" viewBox="0 0 41 38" fill="none">
                              <path d="M26.7028 19.1634H25.819C25.819 16.2347 23.4447 13.8604 20.5159 13.8604C17.5872 13.8604 15.2129 16.2347 15.2129 19.1634H14.3291C14.3291 15.7465 17.099 12.9766 20.5159 12.9766C23.9327 12.9766 26.7028 15.7465 26.7028 19.1634Z" fill="#EF7221"/>
                              <path d="M18.748 32.8633H22.2834V33.7471H18.748V32.8633Z" fill="#EF7221"/>
                              <path d="M28.1875 34.6973H12.8125V35.8758H28.1875V34.6973Z" fill="#EF7221"/>
                              <path d="M28.1875 2.87891H12.8125V4.05739H28.1875V2.87891Z" fill="#EF7221"/>
                              <path d="M28.1875 24.0918H16.6562V25.2703H28.1875V24.0918Z" fill="#EF7221"/>
                              <path d="M15.375 24.0918H12.8125V25.2703H15.375V24.0918Z" fill="#EF7221"/>
                              <path d="M28.1875 27.627H16.6562V28.8054H28.1875V27.627Z" fill="#EF7221"/>
                              <path d="M15.375 27.627H12.8125V28.8054H15.375V27.627Z" fill="#EF7221"/>
                              <path d="M32.0312 7.5924V31.1621H33.3125V7.5924H32.0312Z" fill="#EF7221"/>
                              <path d="M28.1875 2.87891V4.05739H30.75C31.0898 4.05739 31.4157 4.18155 31.656 4.40256C31.8963 4.62357 32.0312 4.92332 32.0312 5.23588V7.59285H33.3125V5.23588C33.3125 4.61077 33.0425 4.01126 32.562 3.56925C32.0814 3.12723 31.4296 2.87891 30.75 2.87891H28.1875Z" fill="#EF7221"/>
                              <path d="M7.6875 7.5924L7.6875 31.1621H8.96875L8.96875 7.5924H7.6875Z" fill="#EF7221"/>
                              <path d="M12.8125 2.87891V4.05739H10.25C9.91019 4.05739 9.5843 4.18155 9.34402 4.40256C9.10374 4.62357 8.96875 4.92332 8.96875 5.23588V7.59285H7.6875V5.23588C7.6875 4.61077 7.95748 4.01126 8.43804 3.56925C8.9186 3.12723 9.57038 2.87891 10.25 2.87891H12.8125Z" fill="#EF7221"/>
                              <path d="M28.1875 35.8761V34.6976H30.75C31.0898 34.6976 31.4157 34.5734 31.656 34.3524C31.8963 34.1314 32.0312 33.8316 32.0312 33.5191V31.1621H33.3125V33.5191C33.3125 34.1442 33.0425 34.7437 32.562 35.1857C32.0814 35.6277 31.4296 35.8761 30.75 35.8761H28.1875Z" fill="#EF7221"/>
                              <path d="M12.8125 35.8761V34.6976H10.25C9.91019 34.6976 9.5843 34.5734 9.34402 34.3524C9.10374 34.1314 8.96875 33.8316 8.96875 33.5191V31.1621H7.6875V33.5191C7.6875 34.1442 7.95748 34.7437 8.43804 35.1857C8.9186 35.6277 9.57038 35.8761 10.25 35.8761H12.8125Z" fill="#EF7221"/>
                              <path d="M20.5 8.94922C19.9932 8.94922 19.4978 9.08745 19.0764 9.34644C18.655 9.60543 18.3265 9.97354 18.1326 10.4042C17.9386 10.8349 17.8879 11.3088 17.9867 11.766C18.0856 12.2232 18.3297 12.6432 18.688 12.9728C19.0464 13.3024 19.503 13.5269 20.0001 13.6179C20.4972 13.7088 21.0124 13.6621 21.4806 13.4837C21.9489 13.3054 22.3491 13.0033 22.6306 12.6157C22.9122 12.2281 23.0625 11.7724 23.0625 11.3062C23.0625 10.6811 22.7925 10.0816 22.312 9.63956C21.8314 9.19754 21.1796 8.94922 20.5 8.94922ZM20.5 12.4847C20.2466 12.4847 19.9989 12.4156 19.7882 12.2861C19.5775 12.1566 19.4133 11.9725 19.3163 11.7572C19.2193 11.5418 19.1939 11.3049 19.2434 11.0763C19.2928 10.8477 19.4148 10.6377 19.594 10.4729C19.7732 10.3081 20.0015 10.1958 20.25 10.1503C20.4986 10.1049 20.7562 10.1282 20.9903 10.2174C21.2244 10.3066 21.4245 10.4577 21.5653 10.6515C21.7061 10.8453 21.7813 11.0731 21.7813 11.3062C21.7813 11.6187 21.6463 11.9185 21.406 12.1395C21.1657 12.3605 20.8398 12.4847 20.5 12.4847Z" fill="#EF7221"/>
                            </svg>
                          </div>
                          <h5 class="fw-semibold">Skill Refinement Tasks</h5>
                          <p class="mb-0 p-0">Focus on problem-solving, critical thinking, and domain expertise.</p>
                      </div>
                    </div>
                  </div>
                  <div class="col-12 col-sm-6 col-lg-6 mb-3">
                    <div class="card h-100 roadmap-block border-0 bg-theme-light">
                      <div class="card-body p-lg-4">
                          <div class="cardicon mb-3 d-flex justify-content-center align-items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" width="41" height="38" viewBox="0 0 41 38" fill="none">
                              <path d="M26.7028 19.1634H25.819C25.819 16.2347 23.4447 13.8604 20.5159 13.8604C17.5872 13.8604 15.2129 16.2347 15.2129 19.1634H14.3291C14.3291 15.7465 17.099 12.9766 20.5159 12.9766C23.9327 12.9766 26.7028 15.7465 26.7028 19.1634Z" fill="#EF7221"/>
                              <path d="M18.748 32.8633H22.2834V33.7471H18.748V32.8633Z" fill="#EF7221"/>
                              <path d="M28.1875 34.6973H12.8125V35.8758H28.1875V34.6973Z" fill="#EF7221"/>
                              <path d="M28.1875 2.87891H12.8125V4.05739H28.1875V2.87891Z" fill="#EF7221"/>
                              <path d="M28.1875 24.0918H16.6562V25.2703H28.1875V24.0918Z" fill="#EF7221"/>
                              <path d="M15.375 24.0918H12.8125V25.2703H15.375V24.0918Z" fill="#EF7221"/>
                              <path d="M28.1875 27.627H16.6562V28.8054H28.1875V27.627Z" fill="#EF7221"/>
                              <path d="M15.375 27.627H12.8125V28.8054H15.375V27.627Z" fill="#EF7221"/>
                              <path d="M32.0312 7.5924V31.1621H33.3125V7.5924H32.0312Z" fill="#EF7221"/>
                              <path d="M28.1875 2.87891V4.05739H30.75C31.0898 4.05739 31.4157 4.18155 31.656 4.40256C31.8963 4.62357 32.0312 4.92332 32.0312 5.23588V7.59285H33.3125V5.23588C33.3125 4.61077 33.0425 4.01126 32.562 3.56925C32.0814 3.12723 31.4296 2.87891 30.75 2.87891H28.1875Z" fill="#EF7221"/>
                              <path d="M7.6875 7.5924L7.6875 31.1621H8.96875L8.96875 7.5924H7.6875Z" fill="#EF7221"/>
                              <path d="M12.8125 2.87891V4.05739H10.25C9.91019 4.05739 9.5843 4.18155 9.34402 4.40256C9.10374 4.62357 8.96875 4.92332 8.96875 5.23588V7.59285H7.6875V5.23588C7.6875 4.61077 7.95748 4.01126 8.43804 3.56925C8.9186 3.12723 9.57038 2.87891 10.25 2.87891H12.8125Z" fill="#EF7221"/>
                              <path d="M28.1875 35.8761V34.6976H30.75C31.0898 34.6976 31.4157 34.5734 31.656 34.3524C31.8963 34.1314 32.0312 33.8316 32.0312 33.5191V31.1621H33.3125V33.5191C33.3125 34.1442 33.0425 34.7437 32.562 35.1857C32.0814 35.6277 31.4296 35.8761 30.75 35.8761H28.1875Z" fill="#EF7221"/>
                              <path d="M12.8125 35.8761V34.6976H10.25C9.91019 34.6976 9.5843 34.5734 9.34402 34.3524C9.10374 34.1314 8.96875 33.8316 8.96875 33.5191V31.1621H7.6875V33.5191C7.6875 34.1442 7.95748 34.7437 8.43804 35.1857C8.9186 35.6277 9.57038 35.8761 10.25 35.8761H12.8125Z" fill="#EF7221"/>
                              <path d="M20.5 8.94922C19.9932 8.94922 19.4978 9.08745 19.0764 9.34644C18.655 9.60543 18.3265 9.97354 18.1326 10.4042C17.9386 10.8349 17.8879 11.3088 17.9867 11.766C18.0856 12.2232 18.3297 12.6432 18.688 12.9728C19.0464 13.3024 19.503 13.5269 20.0001 13.6179C20.4972 13.7088 21.0124 13.6621 21.4806 13.4837C21.9489 13.3054 22.3491 13.0033 22.6306 12.6157C22.9122 12.2281 23.0625 11.7724 23.0625 11.3062C23.0625 10.6811 22.7925 10.0816 22.312 9.63956C21.8314 9.19754 21.1796 8.94922 20.5 8.94922ZM20.5 12.4847C20.2466 12.4847 19.9989 12.4156 19.7882 12.2861C19.5775 12.1566 19.4133 11.9725 19.3163 11.7572C19.2193 11.5418 19.1939 11.3049 19.2434 11.0763C19.2928 10.8477 19.4148 10.6377 19.594 10.4729C19.7732 10.3081 20.0015 10.1958 20.25 10.1503C20.4986 10.1049 20.7562 10.1282 20.9903 10.2174C21.2244 10.3066 21.4245 10.4577 21.5653 10.6515C21.7061 10.8453 21.7813 11.0731 21.7813 11.3062C21.7813 11.6187 21.6463 11.9185 21.406 12.1395C21.1657 12.3605 20.8398 12.4847 20.5 12.4847Z" fill="#EF7221"/>
                            </svg>
                          </div>
                          <h5 class="fw-semibold">Expert Sessions</h5>
                          <p class="mb-0 p-0">Host industry experts for advanced technical guidance</p>
                      </div>
                    </div>
                  </div>
                  
                </div>
              </div>
              <div class="tab-pane fade" id="Development">
                <div class="row">
                  <div class="col-12 col-sm-6 col-lg-6 mb-3">
                    <div class="card h-100 roadmap-block border-0 bg-theme-light">
                      <div class="card-body p-lg-4">
                          <div class="cardicon mb-3 d-flex justify-content-center align-items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" width="41" height="38" viewBox="0 0 41 38" fill="none">
                              <path d="M26.7028 19.1634H25.819C25.819 16.2347 23.4447 13.8604 20.5159 13.8604C17.5872 13.8604 15.2129 16.2347 15.2129 19.1634H14.3291C14.3291 15.7465 17.099 12.9766 20.5159 12.9766C23.9327 12.9766 26.7028 15.7465 26.7028 19.1634Z" fill="#EF7221"/>
                              <path d="M18.748 32.8633H22.2834V33.7471H18.748V32.8633Z" fill="#EF7221"/>
                              <path d="M28.1875 34.6973H12.8125V35.8758H28.1875V34.6973Z" fill="#EF7221"/>
                              <path d="M28.1875 2.87891H12.8125V4.05739H28.1875V2.87891Z" fill="#EF7221"/>
                              <path d="M28.1875 24.0918H16.6562V25.2703H28.1875V24.0918Z" fill="#EF7221"/>
                              <path d="M15.375 24.0918H12.8125V25.2703H15.375V24.0918Z" fill="#EF7221"/>
                              <path d="M28.1875 27.627H16.6562V28.8054H28.1875V27.627Z" fill="#EF7221"/>
                              <path d="M15.375 27.627H12.8125V28.8054H15.375V27.627Z" fill="#EF7221"/>
                              <path d="M32.0312 7.5924V31.1621H33.3125V7.5924H32.0312Z" fill="#EF7221"/>
                              <path d="M28.1875 2.87891V4.05739H30.75C31.0898 4.05739 31.4157 4.18155 31.656 4.40256C31.8963 4.62357 32.0312 4.92332 32.0312 5.23588V7.59285H33.3125V5.23588C33.3125 4.61077 33.0425 4.01126 32.562 3.56925C32.0814 3.12723 31.4296 2.87891 30.75 2.87891H28.1875Z" fill="#EF7221"/>
                              <path d="M7.6875 7.5924L7.6875 31.1621H8.96875L8.96875 7.5924H7.6875Z" fill="#EF7221"/>
                              <path d="M12.8125 2.87891V4.05739H10.25C9.91019 4.05739 9.5843 4.18155 9.34402 4.40256C9.10374 4.62357 8.96875 4.92332 8.96875 5.23588V7.59285H7.6875V5.23588C7.6875 4.61077 7.95748 4.01126 8.43804 3.56925C8.9186 3.12723 9.57038 2.87891 10.25 2.87891H12.8125Z" fill="#EF7221"/>
                              <path d="M28.1875 35.8761V34.6976H30.75C31.0898 34.6976 31.4157 34.5734 31.656 34.3524C31.8963 34.1314 32.0312 33.8316 32.0312 33.5191V31.1621H33.3125V33.5191C33.3125 34.1442 33.0425 34.7437 32.562 35.1857C32.0814 35.6277 31.4296 35.8761 30.75 35.8761H28.1875Z" fill="#EF7221"/>
                              <path d="M12.8125 35.8761V34.6976H10.25C9.91019 34.6976 9.5843 34.5734 9.34402 34.3524C9.10374 34.1314 8.96875 33.8316 8.96875 33.5191V31.1621H7.6875V33.5191C7.6875 34.1442 7.95748 34.7437 8.43804 35.1857C8.9186 35.6277 9.57038 35.8761 10.25 35.8761H12.8125Z" fill="#EF7221"/>
                              <path d="M20.5 8.94922C19.9932 8.94922 19.4978 9.08745 19.0764 9.34644C18.655 9.60543 18.3265 9.97354 18.1326 10.4042C17.9386 10.8349 17.8879 11.3088 17.9867 11.766C18.0856 12.2232 18.3297 12.6432 18.688 12.9728C19.0464 13.3024 19.503 13.5269 20.0001 13.6179C20.4972 13.7088 21.0124 13.6621 21.4806 13.4837C21.9489 13.3054 22.3491 13.0033 22.6306 12.6157C22.9122 12.2281 23.0625 11.7724 23.0625 11.3062C23.0625 10.6811 22.7925 10.0816 22.312 9.63956C21.8314 9.19754 21.1796 8.94922 20.5 8.94922ZM20.5 12.4847C20.2466 12.4847 19.9989 12.4156 19.7882 12.2861C19.5775 12.1566 19.4133 11.9725 19.3163 11.7572C19.2193 11.5418 19.1939 11.3049 19.2434 11.0763C19.2928 10.8477 19.4148 10.6377 19.594 10.4729C19.7732 10.3081 20.0015 10.1958 20.25 10.1503C20.4986 10.1049 20.7562 10.1282 20.9903 10.2174C21.2244 10.3066 21.4245 10.4577 21.5653 10.6515C21.7061 10.8453 21.7813 11.0731 21.7813 11.3062C21.7813 11.6187 21.6463 11.9185 21.406 12.1395C21.1657 12.3605 20.8398 12.4847 20.5 12.4847Z" fill="#EF7221"/>
                            </svg>
                          </div>
                          <h5 class="fw-semibold">Presentation skills</h5>
                          <p class="mb-0 p-0">Teach students to present ideas concisely and effectively.</p>
                      </div>
                    </div>
                  </div>
                  <div class="col-12 col-sm-6 col-lg-6 mb-3">
                    <div class="card h-100 roadmap-block border-0 bg-theme-light">
                      <div class="card-body p-lg-4">
                          <div class="cardicon mb-3 d-flex justify-content-center align-items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" width="41" height="38" viewBox="0 0 41 38" fill="none">
                              <path d="M26.7028 19.1634H25.819C25.819 16.2347 23.4447 13.8604 20.5159 13.8604C17.5872 13.8604 15.2129 16.2347 15.2129 19.1634H14.3291C14.3291 15.7465 17.099 12.9766 20.5159 12.9766C23.9327 12.9766 26.7028 15.7465 26.7028 19.1634Z" fill="#EF7221"/>
                              <path d="M18.748 32.8633H22.2834V33.7471H18.748V32.8633Z" fill="#EF7221"/>
                              <path d="M28.1875 34.6973H12.8125V35.8758H28.1875V34.6973Z" fill="#EF7221"/>
                              <path d="M28.1875 2.87891H12.8125V4.05739H28.1875V2.87891Z" fill="#EF7221"/>
                              <path d="M28.1875 24.0918H16.6562V25.2703H28.1875V24.0918Z" fill="#EF7221"/>
                              <path d="M15.375 24.0918H12.8125V25.2703H15.375V24.0918Z" fill="#EF7221"/>
                              <path d="M28.1875 27.627H16.6562V28.8054H28.1875V27.627Z" fill="#EF7221"/>
                              <path d="M15.375 27.627H12.8125V28.8054H15.375V27.627Z" fill="#EF7221"/>
                              <path d="M32.0312 7.5924V31.1621H33.3125V7.5924H32.0312Z" fill="#EF7221"/>
                              <path d="M28.1875 2.87891V4.05739H30.75C31.0898 4.05739 31.4157 4.18155 31.656 4.40256C31.8963 4.62357 32.0312 4.92332 32.0312 5.23588V7.59285H33.3125V5.23588C33.3125 4.61077 33.0425 4.01126 32.562 3.56925C32.0814 3.12723 31.4296 2.87891 30.75 2.87891H28.1875Z" fill="#EF7221"/>
                              <path d="M7.6875 7.5924L7.6875 31.1621H8.96875L8.96875 7.5924H7.6875Z" fill="#EF7221"/>
                              <path d="M12.8125 2.87891V4.05739H10.25C9.91019 4.05739 9.5843 4.18155 9.34402 4.40256C9.10374 4.62357 8.96875 4.92332 8.96875 5.23588V7.59285H7.6875V5.23588C7.6875 4.61077 7.95748 4.01126 8.43804 3.56925C8.9186 3.12723 9.57038 2.87891 10.25 2.87891H12.8125Z" fill="#EF7221"/>
                              <path d="M28.1875 35.8761V34.6976H30.75C31.0898 34.6976 31.4157 34.5734 31.656 34.3524C31.8963 34.1314 32.0312 33.8316 32.0312 33.5191V31.1621H33.3125V33.5191C33.3125 34.1442 33.0425 34.7437 32.562 35.1857C32.0814 35.6277 31.4296 35.8761 30.75 35.8761H28.1875Z" fill="#EF7221"/>
                              <path d="M12.8125 35.8761V34.6976H10.25C9.91019 34.6976 9.5843 34.5734 9.34402 34.3524C9.10374 34.1314 8.96875 33.8316 8.96875 33.5191V31.1621H7.6875V33.5191C7.6875 34.1442 7.95748 34.7437 8.43804 35.1857C8.9186 35.6277 9.57038 35.8761 10.25 35.8761H12.8125Z" fill="#EF7221"/>
                              <path d="M20.5 8.94922C19.9932 8.94922 19.4978 9.08745 19.0764 9.34644C18.655 9.60543 18.3265 9.97354 18.1326 10.4042C17.9386 10.8349 17.8879 11.3088 17.9867 11.766C18.0856 12.2232 18.3297 12.6432 18.688 12.9728C19.0464 13.3024 19.503 13.5269 20.0001 13.6179C20.4972 13.7088 21.0124 13.6621 21.4806 13.4837C21.9489 13.3054 22.3491 13.0033 22.6306 12.6157C22.9122 12.2281 23.0625 11.7724 23.0625 11.3062C23.0625 10.6811 22.7925 10.0816 22.312 9.63956C21.8314 9.19754 21.1796 8.94922 20.5 8.94922ZM20.5 12.4847C20.2466 12.4847 19.9989 12.4156 19.7882 12.2861C19.5775 12.1566 19.4133 11.9725 19.3163 11.7572C19.2193 11.5418 19.1939 11.3049 19.2434 11.0763C19.2928 10.8477 19.4148 10.6377 19.594 10.4729C19.7732 10.3081 20.0015 10.1958 20.25 10.1503C20.4986 10.1049 20.7562 10.1282 20.9903 10.2174C21.2244 10.3066 21.4245 10.4577 21.5653 10.6515C21.7061 10.8453 21.7813 11.0731 21.7813 11.3062C21.7813 11.6187 21.6463 11.9185 21.406 12.1395C21.1657 12.3605 20.8398 12.4847 20.5 12.4847Z" fill="#EF7221"/>
                            </svg>
                          </div>
                          <h5 class="fw-semibold">Interactive classes</h5>
                          <p class="mb-0 p-0">Focus on improving verbal and non-verbal communication.</p>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="tab-pane fade" id="Resume">
                <div class="row">
                  <div class="col-12 col-sm-6 col-lg-6 mb-3">
                    <div class="card h-100 roadmap-block border-0 bg-theme-light">
                      <div class="card-body p-lg-4">
                          <div class="cardicon mb-3 d-flex justify-content-center align-items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" width="41" height="38" viewBox="0 0 41 38" fill="none">
                              <path d="M26.7028 19.1634H25.819C25.819 16.2347 23.4447 13.8604 20.5159 13.8604C17.5872 13.8604 15.2129 16.2347 15.2129 19.1634H14.3291C14.3291 15.7465 17.099 12.9766 20.5159 12.9766C23.9327 12.9766 26.7028 15.7465 26.7028 19.1634Z" fill="#EF7221"/>
                              <path d="M18.748 32.8633H22.2834V33.7471H18.748V32.8633Z" fill="#EF7221"/>
                              <path d="M28.1875 34.6973H12.8125V35.8758H28.1875V34.6973Z" fill="#EF7221"/>
                              <path d="M28.1875 2.87891H12.8125V4.05739H28.1875V2.87891Z" fill="#EF7221"/>
                              <path d="M28.1875 24.0918H16.6562V25.2703H28.1875V24.0918Z" fill="#EF7221"/>
                              <path d="M15.375 24.0918H12.8125V25.2703H15.375V24.0918Z" fill="#EF7221"/>
                              <path d="M28.1875 27.627H16.6562V28.8054H28.1875V27.627Z" fill="#EF7221"/>
                              <path d="M15.375 27.627H12.8125V28.8054H15.375V27.627Z" fill="#EF7221"/>
                              <path d="M32.0312 7.5924V31.1621H33.3125V7.5924H32.0312Z" fill="#EF7221"/>
                              <path d="M28.1875 2.87891V4.05739H30.75C31.0898 4.05739 31.4157 4.18155 31.656 4.40256C31.8963 4.62357 32.0312 4.92332 32.0312 5.23588V7.59285H33.3125V5.23588C33.3125 4.61077 33.0425 4.01126 32.562 3.56925C32.0814 3.12723 31.4296 2.87891 30.75 2.87891H28.1875Z" fill="#EF7221"/>
                              <path d="M7.6875 7.5924L7.6875 31.1621H8.96875L8.96875 7.5924H7.6875Z" fill="#EF7221"/>
                              <path d="M12.8125 2.87891V4.05739H10.25C9.91019 4.05739 9.5843 4.18155 9.34402 4.40256C9.10374 4.62357 8.96875 4.92332 8.96875 5.23588V7.59285H7.6875V5.23588C7.6875 4.61077 7.95748 4.01126 8.43804 3.56925C8.9186 3.12723 9.57038 2.87891 10.25 2.87891H12.8125Z" fill="#EF7221"/>
                              <path d="M28.1875 35.8761V34.6976H30.75C31.0898 34.6976 31.4157 34.5734 31.656 34.3524C31.8963 34.1314 32.0312 33.8316 32.0312 33.5191V31.1621H33.3125V33.5191C33.3125 34.1442 33.0425 34.7437 32.562 35.1857C32.0814 35.6277 31.4296 35.8761 30.75 35.8761H28.1875Z" fill="#EF7221"/>
                              <path d="M12.8125 35.8761V34.6976H10.25C9.91019 34.6976 9.5843 34.5734 9.34402 34.3524C9.10374 34.1314 8.96875 33.8316 8.96875 33.5191V31.1621H7.6875V33.5191C7.6875 34.1442 7.95748 34.7437 8.43804 35.1857C8.9186 35.6277 9.57038 35.8761 10.25 35.8761H12.8125Z" fill="#EF7221"/>
                              <path d="M20.5 8.94922C19.9932 8.94922 19.4978 9.08745 19.0764 9.34644C18.655 9.60543 18.3265 9.97354 18.1326 10.4042C17.9386 10.8349 17.8879 11.3088 17.9867 11.766C18.0856 12.2232 18.3297 12.6432 18.688 12.9728C19.0464 13.3024 19.503 13.5269 20.0001 13.6179C20.4972 13.7088 21.0124 13.6621 21.4806 13.4837C21.9489 13.3054 22.3491 13.0033 22.6306 12.6157C22.9122 12.2281 23.0625 11.7724 23.0625 11.3062C23.0625 10.6811 22.7925 10.0816 22.312 9.63956C21.8314 9.19754 21.1796 8.94922 20.5 8.94922ZM20.5 12.4847C20.2466 12.4847 19.9989 12.4156 19.7882 12.2861C19.5775 12.1566 19.4133 11.9725 19.3163 11.7572C19.2193 11.5418 19.1939 11.3049 19.2434 11.0763C19.2928 10.8477 19.4148 10.6377 19.594 10.4729C19.7732 10.3081 20.0015 10.1958 20.25 10.1503C20.4986 10.1049 20.7562 10.1282 20.9903 10.2174C21.2244 10.3066 21.4245 10.4577 21.5653 10.6515C21.7061 10.8453 21.7813 11.0731 21.7813 11.3062C21.7813 11.6187 21.6463 11.9185 21.406 12.1395C21.1657 12.3605 20.8398 12.4847 20.5 12.4847Z" fill="#EF7221"/>
                            </svg>
                          </div>
                          <h5 class="fw-semibold">Step by step guidance</h5>
                          <p class="mb-0 p-0">Help students structure professional, impactful resumes</p>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="tab-pane fade" id="Bridging">
                <div class="row">
                  <div class="col-12 col-sm-6 col-lg-6 mb-3">
                    <div class="card h-100 roadmap-block border-0 bg-theme-light">
                      <div class="card-body p-lg-4">
                          <div class="cardicon mb-3 d-flex justify-content-center align-items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" width="41" height="38" viewBox="0 0 41 38" fill="none">
                              <path d="M26.7028 19.1634H25.819C25.819 16.2347 23.4447 13.8604 20.5159 13.8604C17.5872 13.8604 15.2129 16.2347 15.2129 19.1634H14.3291C14.3291 15.7465 17.099 12.9766 20.5159 12.9766C23.9327 12.9766 26.7028 15.7465 26.7028 19.1634Z" fill="#EF7221"/>
                              <path d="M18.748 32.8633H22.2834V33.7471H18.748V32.8633Z" fill="#EF7221"/>
                              <path d="M28.1875 34.6973H12.8125V35.8758H28.1875V34.6973Z" fill="#EF7221"/>
                              <path d="M28.1875 2.87891H12.8125V4.05739H28.1875V2.87891Z" fill="#EF7221"/>
                              <path d="M28.1875 24.0918H16.6562V25.2703H28.1875V24.0918Z" fill="#EF7221"/>
                              <path d="M15.375 24.0918H12.8125V25.2703H15.375V24.0918Z" fill="#EF7221"/>
                              <path d="M28.1875 27.627H16.6562V28.8054H28.1875V27.627Z" fill="#EF7221"/>
                              <path d="M15.375 27.627H12.8125V28.8054H15.375V27.627Z" fill="#EF7221"/>
                              <path d="M32.0312 7.5924V31.1621H33.3125V7.5924H32.0312Z" fill="#EF7221"/>
                              <path d="M28.1875 2.87891V4.05739H30.75C31.0898 4.05739 31.4157 4.18155 31.656 4.40256C31.8963 4.62357 32.0312 4.92332 32.0312 5.23588V7.59285H33.3125V5.23588C33.3125 4.61077 33.0425 4.01126 32.562 3.56925C32.0814 3.12723 31.4296 2.87891 30.75 2.87891H28.1875Z" fill="#EF7221"/>
                              <path d="M7.6875 7.5924L7.6875 31.1621H8.96875L8.96875 7.5924H7.6875Z" fill="#EF7221"/>
                              <path d="M12.8125 2.87891V4.05739H10.25C9.91019 4.05739 9.5843 4.18155 9.34402 4.40256C9.10374 4.62357 8.96875 4.92332 8.96875 5.23588V7.59285H7.6875V5.23588C7.6875 4.61077 7.95748 4.01126 8.43804 3.56925C8.9186 3.12723 9.57038 2.87891 10.25 2.87891H12.8125Z" fill="#EF7221"/>
                              <path d="M28.1875 35.8761V34.6976H30.75C31.0898 34.6976 31.4157 34.5734 31.656 34.3524C31.8963 34.1314 32.0312 33.8316 32.0312 33.5191V31.1621H33.3125V33.5191C33.3125 34.1442 33.0425 34.7437 32.562 35.1857C32.0814 35.6277 31.4296 35.8761 30.75 35.8761H28.1875Z" fill="#EF7221"/>
                              <path d="M12.8125 35.8761V34.6976H10.25C9.91019 34.6976 9.5843 34.5734 9.34402 34.3524C9.10374 34.1314 8.96875 33.8316 8.96875 33.5191V31.1621H7.6875V33.5191C7.6875 34.1442 7.95748 34.7437 8.43804 35.1857C8.9186 35.6277 9.57038 35.8761 10.25 35.8761H12.8125Z" fill="#EF7221"/>
                              <path d="M20.5 8.94922C19.9932 8.94922 19.4978 9.08745 19.0764 9.34644C18.655 9.60543 18.3265 9.97354 18.1326 10.4042C17.9386 10.8349 17.8879 11.3088 17.9867 11.766C18.0856 12.2232 18.3297 12.6432 18.688 12.9728C19.0464 13.3024 19.503 13.5269 20.0001 13.6179C20.4972 13.7088 21.0124 13.6621 21.4806 13.4837C21.9489 13.3054 22.3491 13.0033 22.6306 12.6157C22.9122 12.2281 23.0625 11.7724 23.0625 11.3062C23.0625 10.6811 22.7925 10.0816 22.312 9.63956C21.8314 9.19754 21.1796 8.94922 20.5 8.94922ZM20.5 12.4847C20.2466 12.4847 19.9989 12.4156 19.7882 12.2861C19.5775 12.1566 19.4133 11.9725 19.3163 11.7572C19.2193 11.5418 19.1939 11.3049 19.2434 11.0763C19.2928 10.8477 19.4148 10.6377 19.594 10.4729C19.7732 10.3081 20.0015 10.1958 20.25 10.1503C20.4986 10.1049 20.7562 10.1282 20.9903 10.2174C21.2244 10.3066 21.4245 10.4577 21.5653 10.6515C21.7061 10.8453 21.7813 11.0731 21.7813 11.3062C21.7813 11.6187 21.6463 11.9185 21.406 12.1395C21.1657 12.3605 20.8398 12.4847 20.5 12.4847Z" fill="#EF7221"/>
                            </svg>
                          </div>
                          <h5 class="fw-semibold">Placement coordination</h5>
                          <ul class="list-unstyled">
                            <li>Connect candidates to aligned opportunities</li>
                            <li>Organize hiring events and recruitment drives.</li>
                          </ul>
                      </div>
                    </div>
                  </div>
                  <div class="col-12 col-sm-6 col-lg-6 mb-3">
                    <div class="card h-100 roadmap-block border-0 bg-theme-light">
                      <div class="card-body p-lg-4">
                          <div class="cardicon mb-3 d-flex justify-content-center align-items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" width="41" height="38" viewBox="0 0 41 38" fill="none">
                              <path d="M26.7028 19.1634H25.819C25.819 16.2347 23.4447 13.8604 20.5159 13.8604C17.5872 13.8604 15.2129 16.2347 15.2129 19.1634H14.3291C14.3291 15.7465 17.099 12.9766 20.5159 12.9766C23.9327 12.9766 26.7028 15.7465 26.7028 19.1634Z" fill="#EF7221"/>
                              <path d="M18.748 32.8633H22.2834V33.7471H18.748V32.8633Z" fill="#EF7221"/>
                              <path d="M28.1875 34.6973H12.8125V35.8758H28.1875V34.6973Z" fill="#EF7221"/>
                              <path d="M28.1875 2.87891H12.8125V4.05739H28.1875V2.87891Z" fill="#EF7221"/>
                              <path d="M28.1875 24.0918H16.6562V25.2703H28.1875V24.0918Z" fill="#EF7221"/>
                              <path d="M15.375 24.0918H12.8125V25.2703H15.375V24.0918Z" fill="#EF7221"/>
                              <path d="M28.1875 27.627H16.6562V28.8054H28.1875V27.627Z" fill="#EF7221"/>
                              <path d="M15.375 27.627H12.8125V28.8054H15.375V27.627Z" fill="#EF7221"/>
                              <path d="M32.0312 7.5924V31.1621H33.3125V7.5924H32.0312Z" fill="#EF7221"/>
                              <path d="M28.1875 2.87891V4.05739H30.75C31.0898 4.05739 31.4157 4.18155 31.656 4.40256C31.8963 4.62357 32.0312 4.92332 32.0312 5.23588V7.59285H33.3125V5.23588C33.3125 4.61077 33.0425 4.01126 32.562 3.56925C32.0814 3.12723 31.4296 2.87891 30.75 2.87891H28.1875Z" fill="#EF7221"/>
                              <path d="M7.6875 7.5924L7.6875 31.1621H8.96875L8.96875 7.5924H7.6875Z" fill="#EF7221"/>
                              <path d="M12.8125 2.87891V4.05739H10.25C9.91019 4.05739 9.5843 4.18155 9.34402 4.40256C9.10374 4.62357 8.96875 4.92332 8.96875 5.23588V7.59285H7.6875V5.23588C7.6875 4.61077 7.95748 4.01126 8.43804 3.56925C8.9186 3.12723 9.57038 2.87891 10.25 2.87891H12.8125Z" fill="#EF7221"/>
                              <path d="M28.1875 35.8761V34.6976H30.75C31.0898 34.6976 31.4157 34.5734 31.656 34.3524C31.8963 34.1314 32.0312 33.8316 32.0312 33.5191V31.1621H33.3125V33.5191C33.3125 34.1442 33.0425 34.7437 32.562 35.1857C32.0814 35.6277 31.4296 35.8761 30.75 35.8761H28.1875Z" fill="#EF7221"/>
                              <path d="M12.8125 35.8761V34.6976H10.25C9.91019 34.6976 9.5843 34.5734 9.34402 34.3524C9.10374 34.1314 8.96875 33.8316 8.96875 33.5191V31.1621H7.6875V33.5191C7.6875 34.1442 7.95748 34.7437 8.43804 35.1857C8.9186 35.6277 9.57038 35.8761 10.25 35.8761H12.8125Z" fill="#EF7221"/>
                              <path d="M20.5 8.94922C19.9932 8.94922 19.4978 9.08745 19.0764 9.34644C18.655 9.60543 18.3265 9.97354 18.1326 10.4042C17.9386 10.8349 17.8879 11.3088 17.9867 11.766C18.0856 12.2232 18.3297 12.6432 18.688 12.9728C19.0464 13.3024 19.503 13.5269 20.0001 13.6179C20.4972 13.7088 21.0124 13.6621 21.4806 13.4837C21.9489 13.3054 22.3491 13.0033 22.6306 12.6157C22.9122 12.2281 23.0625 11.7724 23.0625 11.3062C23.0625 10.6811 22.7925 10.0816 22.312 9.63956C21.8314 9.19754 21.1796 8.94922 20.5 8.94922ZM20.5 12.4847C20.2466 12.4847 19.9989 12.4156 19.7882 12.2861C19.5775 12.1566 19.4133 11.9725 19.3163 11.7572C19.2193 11.5418 19.1939 11.3049 19.2434 11.0763C19.2928 10.8477 19.4148 10.6377 19.594 10.4729C19.7732 10.3081 20.0015 10.1958 20.25 10.1503C20.4986 10.1049 20.7562 10.1282 20.9903 10.2174C21.2244 10.3066 21.4245 10.4577 21.5653 10.6515C21.7061 10.8453 21.7813 11.0731 21.7813 11.3062C21.7813 11.6187 21.6463 11.9185 21.406 12.1395C21.1657 12.3605 20.8398 12.4847 20.5 12.4847Z" fill="#EF7221"/>
                            </svg>
                          </div>
                          <h5 class="fw-semibold">Industry networking</h5>
                          <ul class="list-unstyled">
                            <li>Partner with top companies for hiring pipelines</li>
                            <li>Conduct webinars and sessions with recruiters</li>
                          </ul>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="tab-pane fade" id="Advance">
                <div class="row">
                  <div class="col-12 col-sm-6 col-lg-6 mb-3">
                    <div class="card h-100 roadmap-block border-0 bg-theme-light">
                      <div class="card-body p-lg-4">
                          <div class="cardicon mb-3 d-flex justify-content-center align-items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" width="41" height="38" viewBox="0 0 41 38" fill="none">
                              <path d="M26.7028 19.1634H25.819C25.819 16.2347 23.4447 13.8604 20.5159 13.8604C17.5872 13.8604 15.2129 16.2347 15.2129 19.1634H14.3291C14.3291 15.7465 17.099 12.9766 20.5159 12.9766C23.9327 12.9766 26.7028 15.7465 26.7028 19.1634Z" fill="#EF7221"/>
                              <path d="M18.748 32.8633H22.2834V33.7471H18.748V32.8633Z" fill="#EF7221"/>
                              <path d="M28.1875 34.6973H12.8125V35.8758H28.1875V34.6973Z" fill="#EF7221"/>
                              <path d="M28.1875 2.87891H12.8125V4.05739H28.1875V2.87891Z" fill="#EF7221"/>
                              <path d="M28.1875 24.0918H16.6562V25.2703H28.1875V24.0918Z" fill="#EF7221"/>
                              <path d="M15.375 24.0918H12.8125V25.2703H15.375V24.0918Z" fill="#EF7221"/>
                              <path d="M28.1875 27.627H16.6562V28.8054H28.1875V27.627Z" fill="#EF7221"/>
                              <path d="M15.375 27.627H12.8125V28.8054H15.375V27.627Z" fill="#EF7221"/>
                              <path d="M32.0312 7.5924V31.1621H33.3125V7.5924H32.0312Z" fill="#EF7221"/>
                              <path d="M28.1875 2.87891V4.05739H30.75C31.0898 4.05739 31.4157 4.18155 31.656 4.40256C31.8963 4.62357 32.0312 4.92332 32.0312 5.23588V7.59285H33.3125V5.23588C33.3125 4.61077 33.0425 4.01126 32.562 3.56925C32.0814 3.12723 31.4296 2.87891 30.75 2.87891H28.1875Z" fill="#EF7221"/>
                              <path d="M7.6875 7.5924L7.6875 31.1621H8.96875L8.96875 7.5924H7.6875Z" fill="#EF7221"/>
                              <path d="M12.8125 2.87891V4.05739H10.25C9.91019 4.05739 9.5843 4.18155 9.34402 4.40256C9.10374 4.62357 8.96875 4.92332 8.96875 5.23588V7.59285H7.6875V5.23588C7.6875 4.61077 7.95748 4.01126 8.43804 3.56925C8.9186 3.12723 9.57038 2.87891 10.25 2.87891H12.8125Z" fill="#EF7221"/>
                              <path d="M28.1875 35.8761V34.6976H30.75C31.0898 34.6976 31.4157 34.5734 31.656 34.3524C31.8963 34.1314 32.0312 33.8316 32.0312 33.5191V31.1621H33.3125V33.5191C33.3125 34.1442 33.0425 34.7437 32.562 35.1857C32.0814 35.6277 31.4296 35.8761 30.75 35.8761H28.1875Z" fill="#EF7221"/>
                              <path d="M12.8125 35.8761V34.6976H10.25C9.91019 34.6976 9.5843 34.5734 9.34402 34.3524C9.10374 34.1314 8.96875 33.8316 8.96875 33.5191V31.1621H7.6875V33.5191C7.6875 34.1442 7.95748 34.7437 8.43804 35.1857C8.9186 35.6277 9.57038 35.8761 10.25 35.8761H12.8125Z" fill="#EF7221"/>
                              <path d="M20.5 8.94922C19.9932 8.94922 19.4978 9.08745 19.0764 9.34644C18.655 9.60543 18.3265 9.97354 18.1326 10.4042C17.9386 10.8349 17.8879 11.3088 17.9867 11.766C18.0856 12.2232 18.3297 12.6432 18.688 12.9728C19.0464 13.3024 19.503 13.5269 20.0001 13.6179C20.4972 13.7088 21.0124 13.6621 21.4806 13.4837C21.9489 13.3054 22.3491 13.0033 22.6306 12.6157C22.9122 12.2281 23.0625 11.7724 23.0625 11.3062C23.0625 10.6811 22.7925 10.0816 22.312 9.63956C21.8314 9.19754 21.1796 8.94922 20.5 8.94922ZM20.5 12.4847C20.2466 12.4847 19.9989 12.4156 19.7882 12.2861C19.5775 12.1566 19.4133 11.9725 19.3163 11.7572C19.2193 11.5418 19.1939 11.3049 19.2434 11.0763C19.2928 10.8477 19.4148 10.6377 19.594 10.4729C19.7732 10.3081 20.0015 10.1958 20.25 10.1503C20.4986 10.1049 20.7562 10.1282 20.9903 10.2174C21.2244 10.3066 21.4245 10.4577 21.5653 10.6515C21.7061 10.8453 21.7813 11.0731 21.7813 11.3062C21.7813 11.6187 21.6463 11.9185 21.406 12.1395C21.1657 12.3605 20.8398 12.4847 20.5 12.4847Z" fill="#EF7221"/>
                            </svg>
                          </div>
                          <h5 class="fw-semibold">Scenario-Based Training</h5>
                          <p class="mb-0 p-0">Prepare students for various interview formats, including case studies, coding rounds, and group discussions.</p>
                      </div>
                    </div>
                  </div>
                  <div class="col-12 col-sm-6 col-lg-6 mb-3">
                    <div class="card h-100 roadmap-block border-0 bg-theme-light">
                      <div class="card-body p-lg-4">
                          <div class="cardicon mb-3 d-flex justify-content-center align-items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" width="41" height="38" viewBox="0 0 41 38" fill="none">
                              <path d="M26.7028 19.1634H25.819C25.819 16.2347 23.4447 13.8604 20.5159 13.8604C17.5872 13.8604 15.2129 16.2347 15.2129 19.1634H14.3291C14.3291 15.7465 17.099 12.9766 20.5159 12.9766C23.9327 12.9766 26.7028 15.7465 26.7028 19.1634Z" fill="#EF7221"/>
                              <path d="M18.748 32.8633H22.2834V33.7471H18.748V32.8633Z" fill="#EF7221"/>
                              <path d="M28.1875 34.6973H12.8125V35.8758H28.1875V34.6973Z" fill="#EF7221"/>
                              <path d="M28.1875 2.87891H12.8125V4.05739H28.1875V2.87891Z" fill="#EF7221"/>
                              <path d="M28.1875 24.0918H16.6562V25.2703H28.1875V24.0918Z" fill="#EF7221"/>
                              <path d="M15.375 24.0918H12.8125V25.2703H15.375V24.0918Z" fill="#EF7221"/>
                              <path d="M28.1875 27.627H16.6562V28.8054H28.1875V27.627Z" fill="#EF7221"/>
                              <path d="M15.375 27.627H12.8125V28.8054H15.375V27.627Z" fill="#EF7221"/>
                              <path d="M32.0312 7.5924V31.1621H33.3125V7.5924H32.0312Z" fill="#EF7221"/>
                              <path d="M28.1875 2.87891V4.05739H30.75C31.0898 4.05739 31.4157 4.18155 31.656 4.40256C31.8963 4.62357 32.0312 4.92332 32.0312 5.23588V7.59285H33.3125V5.23588C33.3125 4.61077 33.0425 4.01126 32.562 3.56925C32.0814 3.12723 31.4296 2.87891 30.75 2.87891H28.1875Z" fill="#EF7221"/>
                              <path d="M7.6875 7.5924L7.6875 31.1621H8.96875L8.96875 7.5924H7.6875Z" fill="#EF7221"/>
                              <path d="M12.8125 2.87891V4.05739H10.25C9.91019 4.05739 9.5843 4.18155 9.34402 4.40256C9.10374 4.62357 8.96875 4.92332 8.96875 5.23588V7.59285H7.6875V5.23588C7.6875 4.61077 7.95748 4.01126 8.43804 3.56925C8.9186 3.12723 9.57038 2.87891 10.25 2.87891H12.8125Z" fill="#EF7221"/>
                              <path d="M28.1875 35.8761V34.6976H30.75C31.0898 34.6976 31.4157 34.5734 31.656 34.3524C31.8963 34.1314 32.0312 33.8316 32.0312 33.5191V31.1621H33.3125V33.5191C33.3125 34.1442 33.0425 34.7437 32.562 35.1857C32.0814 35.6277 31.4296 35.8761 30.75 35.8761H28.1875Z" fill="#EF7221"/>
                              <path d="M12.8125 35.8761V34.6976H10.25C9.91019 34.6976 9.5843 34.5734 9.34402 34.3524C9.10374 34.1314 8.96875 33.8316 8.96875 33.5191V31.1621H7.6875V33.5191C7.6875 34.1442 7.95748 34.7437 8.43804 35.1857C8.9186 35.6277 9.57038 35.8761 10.25 35.8761H12.8125Z" fill="#EF7221"/>
                              <path d="M20.5 8.94922C19.9932 8.94922 19.4978 9.08745 19.0764 9.34644C18.655 9.60543 18.3265 9.97354 18.1326 10.4042C17.9386 10.8349 17.8879 11.3088 17.9867 11.766C18.0856 12.2232 18.3297 12.6432 18.688 12.9728C19.0464 13.3024 19.503 13.5269 20.0001 13.6179C20.4972 13.7088 21.0124 13.6621 21.4806 13.4837C21.9489 13.3054 22.3491 13.0033 22.6306 12.6157C22.9122 12.2281 23.0625 11.7724 23.0625 11.3062C23.0625 10.6811 22.7925 10.0816 22.312 9.63956C21.8314 9.19754 21.1796 8.94922 20.5 8.94922ZM20.5 12.4847C20.2466 12.4847 19.9989 12.4156 19.7882 12.2861C19.5775 12.1566 19.4133 11.9725 19.3163 11.7572C19.2193 11.5418 19.1939 11.3049 19.2434 11.0763C19.2928 10.8477 19.4148 10.6377 19.594 10.4729C19.7732 10.3081 20.0015 10.1958 20.25 10.1503C20.4986 10.1049 20.7562 10.1282 20.9903 10.2174C21.2244 10.3066 21.4245 10.4577 21.5653 10.6515C21.7061 10.8453 21.7813 11.0731 21.7813 11.3062C21.7813 11.6187 21.6463 11.9185 21.406 12.1395C21.1657 12.3605 20.8398 12.4847 20.5 12.4847Z" fill="#EF7221"/>
                            </svg>
                          </div>
                          <h5 class="fw-semibold">Stress Management Techniques</h5>
                          <p class="mb-0 p-0">Equip students to handle high-pressure interview situations.</p>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="tab-pane fade" id="guidance">
                <div class="row">
                  <div class="col-12 col-sm-6 col-lg-6 mb-3">
                    <div class="card h-100 roadmap-block border-0 bg-theme-light">
                      <div class="card-body p-lg-4">
                          <div class="cardicon mb-3 d-flex justify-content-center align-items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" width="41" height="38" viewBox="0 0 41 38" fill="none">
                              <path d="M26.7028 19.1634H25.819C25.819 16.2347 23.4447 13.8604 20.5159 13.8604C17.5872 13.8604 15.2129 16.2347 15.2129 19.1634H14.3291C14.3291 15.7465 17.099 12.9766 20.5159 12.9766C23.9327 12.9766 26.7028 15.7465 26.7028 19.1634Z" fill="#EF7221"/>
                              <path d="M18.748 32.8633H22.2834V33.7471H18.748V32.8633Z" fill="#EF7221"/>
                              <path d="M28.1875 34.6973H12.8125V35.8758H28.1875V34.6973Z" fill="#EF7221"/>
                              <path d="M28.1875 2.87891H12.8125V4.05739H28.1875V2.87891Z" fill="#EF7221"/>
                              <path d="M28.1875 24.0918H16.6562V25.2703H28.1875V24.0918Z" fill="#EF7221"/>
                              <path d="M15.375 24.0918H12.8125V25.2703H15.375V24.0918Z" fill="#EF7221"/>
                              <path d="M28.1875 27.627H16.6562V28.8054H28.1875V27.627Z" fill="#EF7221"/>
                              <path d="M15.375 27.627H12.8125V28.8054H15.375V27.627Z" fill="#EF7221"/>
                              <path d="M32.0312 7.5924V31.1621H33.3125V7.5924H32.0312Z" fill="#EF7221"/>
                              <path d="M28.1875 2.87891V4.05739H30.75C31.0898 4.05739 31.4157 4.18155 31.656 4.40256C31.8963 4.62357 32.0312 4.92332 32.0312 5.23588V7.59285H33.3125V5.23588C33.3125 4.61077 33.0425 4.01126 32.562 3.56925C32.0814 3.12723 31.4296 2.87891 30.75 2.87891H28.1875Z" fill="#EF7221"/>
                              <path d="M7.6875 7.5924L7.6875 31.1621H8.96875L8.96875 7.5924H7.6875Z" fill="#EF7221"/>
                              <path d="M12.8125 2.87891V4.05739H10.25C9.91019 4.05739 9.5843 4.18155 9.34402 4.40256C9.10374 4.62357 8.96875 4.92332 8.96875 5.23588V7.59285H7.6875V5.23588C7.6875 4.61077 7.95748 4.01126 8.43804 3.56925C8.9186 3.12723 9.57038 2.87891 10.25 2.87891H12.8125Z" fill="#EF7221"/>
                              <path d="M28.1875 35.8761V34.6976H30.75C31.0898 34.6976 31.4157 34.5734 31.656 34.3524C31.8963 34.1314 32.0312 33.8316 32.0312 33.5191V31.1621H33.3125V33.5191C33.3125 34.1442 33.0425 34.7437 32.562 35.1857C32.0814 35.6277 31.4296 35.8761 30.75 35.8761H28.1875Z" fill="#EF7221"/>
                              <path d="M12.8125 35.8761V34.6976H10.25C9.91019 34.6976 9.5843 34.5734 9.34402 34.3524C9.10374 34.1314 8.96875 33.8316 8.96875 33.5191V31.1621H7.6875V33.5191C7.6875 34.1442 7.95748 34.7437 8.43804 35.1857C8.9186 35.6277 9.57038 35.8761 10.25 35.8761H12.8125Z" fill="#EF7221"/>
                              <path d="M20.5 8.94922C19.9932 8.94922 19.4978 9.08745 19.0764 9.34644C18.655 9.60543 18.3265 9.97354 18.1326 10.4042C17.9386 10.8349 17.8879 11.3088 17.9867 11.766C18.0856 12.2232 18.3297 12.6432 18.688 12.9728C19.0464 13.3024 19.503 13.5269 20.0001 13.6179C20.4972 13.7088 21.0124 13.6621 21.4806 13.4837C21.9489 13.3054 22.3491 13.0033 22.6306 12.6157C22.9122 12.2281 23.0625 11.7724 23.0625 11.3062C23.0625 10.6811 22.7925 10.0816 22.312 9.63956C21.8314 9.19754 21.1796 8.94922 20.5 8.94922ZM20.5 12.4847C20.2466 12.4847 19.9989 12.4156 19.7882 12.2861C19.5775 12.1566 19.4133 11.9725 19.3163 11.7572C19.2193 11.5418 19.1939 11.3049 19.2434 11.0763C19.2928 10.8477 19.4148 10.6377 19.594 10.4729C19.7732 10.3081 20.0015 10.1958 20.25 10.1503C20.4986 10.1049 20.7562 10.1282 20.9903 10.2174C21.2244 10.3066 21.4245 10.4577 21.5653 10.6515C21.7061 10.8453 21.7813 11.0731 21.7813 11.3062C21.7813 11.6187 21.6463 11.9185 21.406 12.1395C21.1657 12.3605 20.8398 12.4847 20.5 12.4847Z" fill="#EF7221"/>
                            </svg>
                          </div>
                          <h5 class="fw-semibold">Individual Sessions</h5>
                          <ul class="list-unstyled">
                            <li>Address specific weaknesses and barriers to success</li>
                            <li>Develop personalized improvement plans</li>
                          </ul>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="border rounded-2 brd-theme-light mt-4">
          <div class="row">
            <div class="col-12 col-lg-8 order-2 order-lg-1">
              <div class="dataarea p-3">
                <span>Our mission revolves around our learners</span>
                <h4 class="fw-bold my-md-3">Promising 100% <span class="theme-text-primary">#CareerSuccess!</span></h4>
                <a href="javascript:void(0);" class="align-items-center btn btn-primary btnwith-icon-sm d-inline-flex justify-content-center p-2 rounded-2 text-center">
                  <span class="pe-3 ps-2">Download Placement Report</span>
                  <span class="btn-icon d-inline-flex justify-content-center align-items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="21" viewBox="0 0 20 21" fill="none">
                      <path d="M5.39062 9.46533C5.50781 9.33512 5.6543 9.27002 5.83008 9.27002C6.00586 9.27002 6.15234 9.33512 6.26953 9.46533L10 13.1763L13.7305 9.46533C13.8477 9.33512 13.9941 9.27002 14.1699 9.27002C14.3457 9.27002 14.4922 9.33512 14.6094 9.46533C14.7266 9.58252 14.7852 9.729 14.7852 9.90479C14.7852 10.0806 14.7266 10.2271 14.6094 10.3442L10.4492 14.5044C10.319 14.6346 10.1693 14.6997 10 14.6997C9.83073 14.6997 9.68099 14.6346 9.55078 14.5044L5.39062 10.3442C5.27344 10.2271 5.21484 10.0806 5.21484 9.90479C5.21484 9.729 5.27344 9.58252 5.39062 9.46533ZM10 4.27002C10.1693 4.27002 10.3158 4.33187 10.4395 4.45557C10.5632 4.57926 10.625 4.72575 10.625 4.89502V13.2349C10.625 13.4041 10.5632 13.5506 10.4395 13.6743C10.3158 13.798 10.1693 13.8599 10 13.8599C9.83073 13.8599 9.68424 13.798 9.56055 13.6743C9.43685 13.5506 9.375 13.4041 9.375 13.2349V4.89502C9.375 4.72575 9.43685 4.57926 9.56055 4.45557C9.68424 4.33187 9.83073 4.27002 10 4.27002ZM3.53516 17.395C3.53516 17.2257 3.59701 17.0793 3.7207 16.9556C3.8444 16.8319 3.99089 16.77 4.16016 16.77H15.8398C16.0091 16.77 16.1556 16.8319 16.2793 16.9556C16.403 17.0793 16.4648 17.2257 16.4648 17.395C16.4648 17.5773 16.403 17.7271 16.2793 17.8442C16.1556 17.9614 16.0091 18.02 15.8398 18.02H4.16016C3.99089 18.02 3.8444 17.9614 3.7207 17.8442C3.59701 17.7271 3.53516 17.5773 3.53516 17.395Z" fill="white"/>
                    </svg>
                  </span>
                </a>
              </div>
            </div>
            <div class="col-12 col-lg-4 order-1 order-lg-2">
              <div class="image-area text-end">
                <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/graph1.png" class="img-fluid" alt="">
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- End Roadmap Section -->

	    <!-- Hiring Partners -->
	    <div class="partnerind">
	      <div class="container-fluid">
	        <div class="row">
	          <div class="col-lg-12 text-center">
	            <h2><?php echo $internship_detail_page['hiring_partners_title']; ?></h2>
	            <p><?php echo $internship_detail_page['hiring_partners_description']; ?></p>
<?php
// Split the array into three parts
$items = $internship_detail_page['hiring_partners_images'];
$split1 = array_slice($items, 0, ceil(count($items)/3));
$split2 = array_slice($items, 1,ceil(count($items)/3), ceil(count($items)/3));
$split3 = array_slice($items, 2 * ceil(count($items)/3));

// Function to create carousel items
function createCarouselItems($split, $carouselClass) {
        echo '<div class="owl-carousel ' . $carouselClass . '">';
    foreach ($split as $item) {
        echo '<div class="item"><img src="' . $item . '" class="img-fluid" alt=""></div>';
    }
        echo '</div>';
}

// Create carousels
createCarouselItems($split1, 'across-slid1');
createCarouselItems($split2, 'across-slid2');
createCarouselItems($split3, 'across-slid1');
?>

	         
	            <div class="text-center mt-5"><a href="#" class="btn btn-primary text-14">See All Our Hiring Partners</a></div>

	          </div>
	        </div>
	      </div>
	    </div>

	    <!-- Hear From -->
	    <div class="hearform">
	      <div class="container-fluid">
	        <div class="row">
	          <div class="col-md-6">
	            <h2><?php echo $internship_detail_page['hear_from_our_students_title']; ?></h2>
	          </div>
	          <div class="col-md-6">
	            <div class="subtext"><?php echo $internship_detail_page['hear_from_our_students_description']; ?></div>
	          </div>
	        </div>
	        <div class="row mt-80 d-flex align-items-center">
	          <div class="col-md-2">
	            <div class="nav" id="v-pills-tab" role="tablist">
	              <a href="#" class="nav-link" id="video-tab" data-bs-toggle="pill" data-bs-target="#video" role="tab" aria-controls="video" aria-selected="false">Video<br>Review</a>
	              <a href="#" class="nav-link active" id="review-tab" data-bs-toggle="pill" data-bs-target="#review" role="tab" aria-controls="review" aria-selected="true">Review</a>
	              <a href="#" class="nav-link" id="college-tab" data-bs-toggle="pill" data-bs-target="#college" role="tab" aria-controls="college" aria-selected="false">College <br>Collaboration</a>
	            </div>
	          </div>
	          <div class="col-md-10">
	            <div class="tab-content" id="v-pills-tabContent">
	              <div class="tab-pane fade" id="video" role="tabpanel" aria-labelledby="video-tab" tabindex="0">
	                <div class="owl-carousel video-review">
	                    <?php
$choose_video_review = get_field('choose_video_review');
if ($choose_video_review):
    foreach ($choose_video_review as $choose):
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
	                <div class="owl-carousel video-review">
	                    <?php
$choose_reviews= get_field('choose_reviews');
if($choose_reviews):

    foreach ($choose_reviews as $choose):
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
	                <div class="owl-carousel video-review">
	                     <?php
$choose_placments = get_field('choose_placments');
if ($choose_placments):
    foreach ($choose_placments as $choose):
   
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

	    <!-- Why grras -->
	    <div class="whygrras beint no-bg p-0">
	      <div class="container">
	        <div class="row">
	          <div class="col-md-12 text-center">
	            <h2><?php echo $internship_detail_page['benefits_of_interning_title']; ?></h2>
	            <div class="subtext"><?php echo $internship_detail_page['benefits_of_interning_description']; ?></div>
	          </div>
	        </div>
	        <div class="row align-items-center">
	            <?php foreach($internship_detail_page['benefits_of_interning_points'] as $item ): ?>
	          <div class="col-lg-4 col-md-6 col-6 g-3">
	            <div class="iconbox">
	              <img style="widht: 70px; height: 70px;" src="<?php echo $item['icon']; ?>" alt="">
	              <h4><?php echo $item['title']; ?></h4>
	              <p><?php echo $item['description']; ?></p>
	            </div>
	          </div>
	          <?php endforeach; ?>
	        </div>
	        
	      </div>
	    </div>


	    <!-- Faq -->
	    <!-- Faq -->


	<?php
	   // <!-- Grras vs Other Internships -->
	  include('components/grass-vs-otherers.php');
	?>
	<div class="container">
		<div class="bg-theme-light p-3 mt-4 mb-4">
				<div class="row justify-content-center align-items-center">

				<div class="col-12 col-lg-9 mb-3 mb-lg-0">
					<p class="mb-0">Have doubts about Full Stack Placement Course? Reach out to our counsellors by filling this form.</p>
				</div>
				<div class="col-12 col-lg-3">
					<a href="#" class="btn btn-primary d-block">Speak to a counsellor</a>
				</div>
			</div>  
		</div>
	</div>
	<?php
	  include('components/faq.php');
	get_footer();