
<?php
get_header();
$banner = get_field('banner');
?>
    <!-- banner -->
    <div class="redbanner-detail">
      <div class="container">
        <div class="row">
          <div class="col-lg-8 relative">
            <div class="share"><span>Red Hat Certification</span> <a href="#"><img src="<?php echo get_stylesheet_directory_uri() ?>/images/red-share.svg" alt=""></a></div>
            <h1><?php echo $banner['title']; ?></h1>
            <ul>
                <?php foreach($banner['points'] as $item): ?>
              <li><img src="<?php echo $item['icon'] ?>" alt=""><?php echo $item['title']; ?></li>
                <?php endforeach; ?>
            </ul>
            <div class="subtext"><?php echo $banner['sub_text']; ?></div>
            <p><?php echo $banner['short_description']; ?></p>
            <div class="btndiv">
              <a href="#" class="btn btn-outline-dark">Download Brochure</a>
              <a href="#" class="btn btn-red">Red hat Verify</a>
              <img src="<?php echo $banner['red_hat_image'] ?>" class="img-fluid hatimg" alt="">
            </div>
          </div>
          <div class="col-lg-4">
            <div class="whbox">
              <h4>Need help finding the right training?</h4>
              <form>
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
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- counter -->
    <div class="turnover grabg">
      <div class="container">
        <div class="row">
          <div class="col-md-3 col-6 g-3">
            <div class="icon"><img src="https://webnew.grras.com/wp-content/themes/grras-child/images/t1-red.png" class="img-fluid" alt=""></div>
            <p><big><span id="count1">3</span>K+</big>Successfully Trained</p>
          </div>
          <div class="col-md-3 col-6 g-3">
            <div class="icon"><img src="https://webnew.grras.com/wp-content/themes/grras-child/images/t2-red.png" class="img-fluid" alt=""></div>
            <p><big><span id="count2">15</span>K+</big>Classes Completed</p>
          </div>
          <div class="col-md-3 col-6 g-3">
            <div class="icon"><img src="https://webnew.grras.com/wp-content/themes/grras-child/images/t3-red.png" class="img-fluid" alt=""></div>
            <p><big><span id="count3">97</span>K+</big>Satisfaction Rate</p>
          </div>
          <div class="col-md-3 col-6 g-3">
            <div class="icon"><img src="https://webnew.grras.com/wp-content/themes/grras-child/images/t1-red.png" class="img-fluid" alt=""></div>
            <p><big><span id="count4">102</span>K+</big>Students Community</p>
          </div>
        </div>
      </div>
    </div>

    <!-- Available Delivery -->
    <div class="container wow fadeInLeft">
      <div class="available-del">
        <h2>Available<br> Delivery<br> Methods</h2>
        <ul>
          <li>
            <div class="icon"><img src="<?php echo get_stylesheet_directory_uri() ?>/images/m1.png" class="img-fluid" alt=""></div>
            <h5>Classroom<br>Training</h5>
          </li>
          <li>
            <div class="icon"><img src="<?php echo get_stylesheet_directory_uri() ?>/images/m2.png" class="img-fluid" alt=""></div>
            <h5>Online Instructor-Led<br>Training</h5>
          </li>
          <li>
            <div class="icon"><img src="<?php echo get_stylesheet_directory_uri() ?>/images/m3.png" class="img-fluid" alt=""></div>
            <h5>Online Self-Paced<br>Training</h5>
          </li>
          <li>
            <div class="icon"><img src="<?php echo get_stylesheet_directory_uri() ?>/images/m4.png" class="img-fluid" alt=""></div>
            <h5>Onsite<br>Training</h5>
          </li>          
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
        <div class="overbg redhatbg">
          <div class="container">
            <section class="scroller" id="overview" data-anchor="overview">
              <div class="item-content">
                <div class="row justify-content-between align-items-center">
                  <div class="col-lg-6">
                    <h2><?php $over_view = get_field('over_view');
              echo $over_view['title'];
              ?></h2>
                    <p>15+ Years of Transforming Careers xxxx Students aced their interviews and landed dream roles at top companies XXX LPA Highest CTC after completing our course.By 2026, the Indian Data and Business Analytics industry is expected to grow to US$118.7 billion. This big increase shows how important data analytics will be for different parts of India’s economy.This also means that if you gain skills and comprehensive knowledge ofAnalytics today, you can be part of this growing job market. You canfast-track your career and be the most in-demand data or business analyst that companies are looking for!<br><a href="#">Explore more</a></p>
                    <div class="my-5">
                      <a href="#" class="btn btn-red">Enquire Now</a>
                    </div>
                  </div>
                  <div class="col-lg-5">
                    <div class="videobox">
                      <iframe width="100%" height="315" src="https://www.youtube.com/embed/zR8aEcEVInM?si=xj5_ZoscnuaxvgyX" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
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
                <li class="nav-item" role="presentation">
                  <a class="nav-link" id="curriculum-tab" data-bs-toggle="tab" data-bs-target="#curriculum-tab-pane" role="tab" aria-controls="curriculum-tab-pane" aria-selected="false">Curriculum</a>
                </li>
              </ul>
              <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="overview-tab-pane" role="tabpanel" aria-labelledby="overview-tab" tabindex="0">
                  <h3>Course Description</h3>
                  <p><strong>What is RHCSA -Red Hat Certified System Administrator</strong></p>
                  <p><strong>The Red Hat Certified System Administrator (RHCSA)</strong> is a foundational certification exam for those looking to start a career in Linux system administration. <strong>RHCSA certification</strong> is offered by Red Hat that validates essential skills in Red Hat Enterprise Linux (RHEL 9 ) systems administration.To prepare for this certification, Red Hat offers two official training courses: <strong>RH124</strong> and <strong>RH134</strong>.</p>
                  <p><strong>RH124 (Red Hat System Administration I):</strong></p>
                  <ul>
                    <li>This is the foundational course in the RHCSA track.</li>
                    <li>It covers the basics of Linux system administration, including command-line basics, managing files and directories, configuring simple network settings, and basic user administration.</li>
                    <li>The course is aimed at absolute beginners to Linux or those with minimal experience in Linux administration.</li>
                  </ul>
                  <p><strong>RH134 (Red Hat System Administration II):</strong></p>
                  <ul>
                    <li>RH134 is generally taken after completing RH124, as it builds directly on the foundational knowledge from that course.</li>
                    <li>This course builds on the knowledge acquired in RH124 and delves into more advanced topics necessary for RHCSA.</li>
                    <li>It covers more complex tasks like storage management (including LVM and filesystem configurations), advanced networking configurations, basic firewall management, and system maintenance tasks.</li>
                  </ul>
                  <p>The performance-based Red Hat Certified System Administrator (RHCSA) exam (EX200) tests your knowledge in areas of system administration common across a wide range of environments and deployment scenarios. The skills tested in this exam are the foundation for system administration across all Red Hat® products.</p>
                  <p><strong>Who Should Enroll in the RHCSA EX200 Training?</strong></p>
                  <p>The Red Hat Certified System Administrator (RHCSA) Exam EX200 training is an associate-level course tailored for junior system administrators. This course is designed for IT professionals with around a year of experience in any Linux distribution. This course is also beneficial for junior system admins who want to validate and expand their Linux skills.</p>
                  <p>By passing this exam, you become a Red Hat Certified System Administrator. If you choose to continue your learning journey beyond RHCSA, the credential can also serve as a foundational step on your path toward our highest level of certification—Red Hat Certified Architect.</p>
                  <h3>What you’ll learn</h3>
                  <ul>
                    <li>Use essential tools for Linux system administration.</li>
                    <li>Manage basic networking, security, containers, and user groups.</li>
                    <li>Deploy, configure, and maintain systems effectively.</li>
                    <li>Configure and manage local storage options.</li>
                    <li>Set up and maintain various file systems.</li>
                  </ul>
                </div>
                <div class="tab-pane fade" id="curriculum-tab-pane" role="tabpanel" aria-labelledby="curriculum-tab" tabindex="0">...</div>
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
    <div class="redcartiholder scroller" id="certification" data-anchor="certification">
      <div class="container">
        <h2>Our Certification Holders </h2>
        <p> Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard .</p>
          <div class="owl-carousel rec-certi">
            <div class="item"><img src="https://webnew.grras.com/wp-content/uploads/2024/04/redhat-certificate.webp" class="img-fluid bigimg" alt=""> </div>
            <div class="item"><img src="https://webnew.grras.com/wp-content/uploads/2024/04/redhat-certificate.webp" class="img-fluid bigimg" alt=""> </div>
            <div class="item"><img src="https://webnew.grras.com/wp-content/uploads/2024/04/redhat-certificate.webp" class="img-fluid bigimg" alt=""> </div>
            <div class="item"><img src="https://webnew.grras.com/wp-content/uploads/2024/04/redhat-certificate.webp" class="img-fluid bigimg" alt=""> </div>
            <div class="item"><img src="https://webnew.grras.com/wp-content/uploads/2024/04/redhat-certificate.webp" class="img-fluid bigimg" alt=""> </div>
            <div class="item"><img src="https://webnew.grras.com/wp-content/uploads/2024/04/redhat-certificate.webp" class="img-fluid bigimg" alt=""> </div>
            <div class="item"><img src="https://webnew.grras.com/wp-content/uploads/2024/04/redhat-certificate.webp" class="img-fluid bigimg" alt=""> </div>
          </div>
      </div>
    </div>

    <!-- Why enrol for GRRAS -->
    <div class="yourgoal whyenroll ">
      <div class="container">
        <div class="row">
          <div class="col-12">
            <h2>Why Enrol for GRRAS Red Hat Course?</h2>
          </div>
          <div class="col-lg-3 col-sm-6 col-6 g-3">
            <div class="goalbox">
              <img src="<?php echo get_stylesheet_directory_uri() ?>/images/course1.jpg" class="img-fluid" alt="">
              <h4>Industry Co-Created<br> Curriculum</h4>
              <ul>
                <li>Get set for success with our full-</li>
                <li>stack MERN web development</li>
                <li>course, equipping you with critical</li>
                <li>problem-solving skills.</li>
              </ul>
            </div>
          </div>
          <div class="col-lg-3 col-sm-6 col-6 g-3">
            <div class="goalbox">
              <img src="<?php echo get_stylesheet_directory_uri() ?>/images/course2.jpg" class="img-fluid" alt="">
              <h4>Versatile <br>Expertise</h4>
              <ul>
                <li>Acquire versatile skills, mastering</li>
                <li>both front-end and back-end</li>
                <li>frameworks for dynamic career</li>
                <li>opportunities.</li>
              </ul>
            </div>
          </div>
          <div class="col-lg-3 col-sm-6 col-6 g-3">
            <div class="goalbox">
              <img src="<?php echo get_stylesheet_directory_uri() ?>/images/course3.jpg" class="img-fluid" alt="">
              <h4>In-Demand <br>Jobs</h4>
              <ul>
                <li>Tech sector to offer 65M jobs by</li>
                <li>2025 with top-demand for full-stack</li>
                <li>web developers. Average salary</li>
                <li>starts from ₹6LPA.</li>
              </ul>
            </div>
          </div>
          <div class="col-lg-3 col-sm-6 col-6 g-3">
            <div class="goalbox">
              <img src="<?php echo get_stylesheet_directory_uri() ?>/images/course4.jpg" class="img-fluid" alt="">
              <h4>Flexibility and<br>Adaptability</h4>
              <ul>
                <li>This course will teach you the ins</li>
                <li>and outs of both front-end</li>
                <li>frameworks and backend.</li>
              </ul>
            </div>
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
            <div class="owl-carousel student-carousel">
              <div class="item">
                <div class="whbox">
                  <img src="<?php echo get_stylesheet_directory_uri() ?>/images/student.jpg" class="img-fluid" alt="">
                  <div class="student">
                    <h5>Rohan Tiwari</h5>
                    <div class="subtext">Cloudops Engineer @NUTANIX</div>
                  </div>
                  <p class="more">Well, when I first heard about the Full stack MERN development from of my friends , I had no idea what exactly this is, what were the prerequisites but then God has some other plans for me. I searched alot about it and eventually after trying I landed up enrolling myself with GRRAS SOLUTIONS. I had questions like anything in my mind</p>
                </div>
              </div>
              <div class="item">
                <div class="whbox">
                  <img src="<?php echo get_stylesheet_directory_uri() ?>/images/student.jpg" class="img-fluid" alt="">
                  <div class="student">
                    <h5>Rohan Tiwari</h5>
                    <div class="subtext">Cloudops Engineer @NUTANIX</div>
                  </div>
                  <p class="more">Well, when I first heard about the Full stack MERN development from of my friends , I had no idea what exactly this is, what were the prerequisites but then God has some other plans for me. I searched alot about it and eventually after trying I landed up enrolling myself with GRRAS SOLUTIONS. I had questions like anything in my mind</p>
                </div>
              </div>
              <div class="item">
                <div class="whbox">
                  <img src="<?php echo get_stylesheet_directory_uri() ?>/images/student.jpg" class="img-fluid" alt="">
                  <div class="student">
                    <h5>Rohan Tiwari</h5>
                    <div class="subtext">Cloudops Engineer @NUTANIX</div>
                  </div>
                  <p class="more">Well, when I first heard about the Full stack MERN development from of my friends , I had no idea what exactly this is, what were the prerequisites but then God has some other plans for me. I searched alot about it and eventually after trying I landed up enrolling myself with GRRAS SOLUTIONS. I had questions like anything in my mind</p>
                </div>
              </div>
              <div class="item">
                <div class="whbox">
                  <img src="<?php echo get_stylesheet_directory_uri() ?>/images/student.jpg" class="img-fluid" alt="">
                  <div class="student">
                    <h5>Rohan Tiwari</h5>
                    <div class="subtext">Cloudops Engineer @NUTANIX</div>
                  </div>
                  <p class="more">Well, when I first heard about the Full stack MERN development from of my friends , I had no idea what exactly this is, what were the prerequisites but then God has some other plans for me. I searched alot about it and eventually after trying I landed up enrolling myself with GRRAS SOLUTIONS. I had questions like anything in my mind</p>
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-6">
            <div class="videobox"><iframe width="100%" height="315" src="https://www.youtube.com/embed/b5VOVNHtIe0?si=PGieEgzxPrPW15U6" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe></div>
          </div>
        </div>
      </div>
    </section>

    


<?php
	  include('components/details-course-TopChoices.php');
	  include('components/award.php');
	  include('components/faq.php');
get_footer();
