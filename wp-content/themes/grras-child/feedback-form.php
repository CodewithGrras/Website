<?php
/**
 * Template Name: Feedback Form
 **/
 
// get_header();
?>
<html>
<body>

  <!--<button class="cta-button" onclick="showForm()">Enquire Now</button>-->

 
  <div id="enquiry-form" class="form-wrapper">
    <h2 style="text-align: center; color: #333;">Enquiry Form</h2>
    <div class="npf_wgts" data-height="400px" data-w="016278f0e8715a9db9bcf3c98e82a935"></div>
  </div>

  
  <script type="text/javascript">
    var s = document.createElement("script");
    s.type = "text/javascript";
    s.async = true;
    s.src = "https://widgets.in8.nopaperforms.com/emwgts.js";
    document.body.appendChild(s);
  </script>

 
  <script>
    function showForm() {
      document.getElementById("enquiry-form").style.display = "block";
      document.querySelector(".cta-button").scrollIntoView({ behavior: "smooth" });
    }
  </script>

</body>
</html>
<?php
// get_footer();