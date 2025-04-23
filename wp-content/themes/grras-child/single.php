<?php
get_header();
?>
<!-- blog detail -->

<div class="blogdetail">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <div class="detail-left">
                    <?php
                    if (have_posts()) :
                        while (have_posts()) : the_post();
                    ?>
                            <!-- Post Tags -->
                            <div class="tags">
                                <?php the_tags('Tags: ', ', ', ''); ?>
                            </div>
                            <!-- Post Date -->
                            <div class="date">
                                Uploaded on <?php echo get_the_date(); ?>
                            </div>
                            <!-- Post Title -->
                            <h2><?php the_title(); ?></h2>
                            <!-- Author Info -->
                            <div class="author">
                                Author: <?php the_author(); ?>
                            </div>
                            <!-- Post Featured Image -->
                            <div class="blogimg">
                                <?php if (has_post_thumbnail()) {
                                    echo '<img src="' . get_the_post_thumbnail_url() . '" class="img-fluid" alt="Default image">';

                                } else {
                                    echo '<img src="' . get_template_directory_uri() . '/images/default-image.jpg" class="img-fluid" alt="Default Image">';
                                } ?>
                            </div>

                            <!-- Post Content -->
                            <div class="post-content" id="divh">
                                <?php the_content(); ?>
                            </div>

                            <!-- Related Images in Content (Optional) -->
                           
<?php if( get_post_meta(get_the_ID(), 'conclusion_text', true)){?>
                            <!-- Post Conclusion, FAQ, etc -->
                            <h3>Conclusion:</h3>
                            <p><?php echo get_post_meta(get_the_ID(), 'conclusion_text', true); ?></p>
<?php }?>
                          
                    <?php
                        endwhile;
                    else :
                        echo '<p>No content found.</p>';
                    endif;
                    ?>
                </div>
            </div>

            <!-- Sidebar Section (Recent Posts, Categories, Career Counseling) -->
            <div class="col-lg-4">
                <div class="recentpost">
                    <h3>RECENT POSTS</h3>
                    <ul>
                        <?php
                        $recent_posts = wp_get_recent_posts(['numberposts' => 5, 'post_status' => 'publish', 'cat' => -1]);
                        foreach ($recent_posts as $post) :
                        ?>
                            <li>
                                <h4><a href="<?php echo get_permalink($post['ID']); ?>"><?php echo $post['post_title']; ?></a></h4>
                                <p><?php echo wp_trim_words($post['post_content'], 15); ?></p>
                                <!-- <div class="tags"><?php echo get_the_category_list(', ', '', $post['ID']); ?></div> -->
                                <div class="date"><?php echo get_the_date('', $post['ID']); ?></div>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>

                <!-- Categories Section -->
                <div class="cate-gory">
                    <h3>CATEGORIES</h3>
                    <ul>
                        <?php
                        $categories = get_categories();
                        foreach ($categories as $category) :
                        ?>
                            <li>
                                <img src="<?php echo get_field('category_image', 'category_' . $category->term_id)["url"];
                                            ?>" alt="">
                                 <a href="<?php echo get_category_link($category->term_id); ?>"> 
                                     <?php echo $category->name; ?>
                                     </a> 
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
 <div class="row">
            <div class="col-lg-12 d-none d-lg-block" id="topfixed">
    
                <div class="getfree" style="    position: sticky;
    top: 4rem;
    z-index: 10;">
                    <h3>Get Free Career Counselling</h3>
                    <?php echo do_shortcode('[gravityform id="19" title="false" ajax="true"]'); ?>
                </div>
        
                <!-- Career Counseling Section -->
</div>
            <div class="col-lg-12 d-lg-none">
    
                <div class="getfree" >
                    <h3>Get Free Career Counselling</h3>
                    <?php echo do_shortcode('[gravityform id="19" title="false" ajax="true"]'); ?>
                </div>
        
                <!-- Career Counseling Section -->
</div>
</div>
            </div>
        </div>
    </div>
</div>
 <script>
    document.addEventListener("DOMContentLoaded", function() {
      // Get the target div and topfixed elements
      const targetDiv = document.getElementById("divh");
      const topfixed = document.getElementById("topfixed");

      // Calculate target height
      const targetHeight = targetDiv.clientHeight;

      // Set the height of topfixed
      topfixed.style.height = `${targetHeight - 200}px`;
    });
</script>
<?php
get_footer();
