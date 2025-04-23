
                  <div class="blog-content">
                    <div class="imgbox">
                      <?php
                      if (has_post_thumbnail()) {
                        the_post_thumbnail('medium', array('class' => 'img-fluid'));
                      } else {
                        echo '<img src="' . get_stylesheet_directory_uri() . '/images/default-image.jpg" class="img-fluid" alt="">';
                      }
                      ?>
                    </div>
                    <div class="contentbox">
                      <h4><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
                      <div class="admin"><span>By</span> <?php the_author(); ?></div>
                      <div class="date"><?php echo get_the_date(); ?></div>
                      <div class="read"><?php echo get_field('read_time') ? get_field('read_time') : 7 ?> Min Read</div>
                    </div>
                  </div>
           