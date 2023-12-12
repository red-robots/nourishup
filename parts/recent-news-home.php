<?php
$args = array(
  'posts_per_page'  => $perpage,
  'post_type'       => 'post',
  'orderby'         => 'date',
  'order'           => 'desc',
  'post_status'     => 'publish'
);
$recentposts = new WP_Query($args);
if ( $recentposts->have_posts() ) {  
  $rpcount = $recentposts->found_posts;
  ?>
  <div class="recents-posts-feeds feeds-wrapper">
    <ul class="feeds recent-posts">
      <?php $i=1; while ( $recentposts->have_posts() ) : $recentposts->the_post();  
        $img = get_field('thumbnail_image');
        $imageUrl = ($img) ? $img['url'] : '';
        $imgAlt = ($img) ? $img['title'] : '';
        ?>
        <li class="feed">
          <div class="inside">
            <div class="text">
              <figure>
                <?php if($imageUrl) { ?>
                  <a href="<?php echo get_permalink() ?>">
                    <img src="<?php echo $imageUrl?>" alt="<?php echo $imgAlt?>" class="feat-image" />
                    <img src="<?php echo get_stylesheet_directory_uri()?>/assets/img/square.png" alt="" class="resizer" />
                  </a>
                <?php } else { ?>
                  <img src="<?php echo get_stylesheet_directory_uri()?>/assets/img/square.png" alt="" />
                <?php } ?>
              </figure>
              <p class="posttitle"><?php echo get_the_title()?></p>
            </div>
            <div class="readmore"><a href="<?php echo get_permalink() ?>" class="morelink">Read More</a></div>
          </div>
        </li>
      <?php $i++; endwhile; wp_reset_postdata(); ?>
    </ul>
  </div>
<?php } ?>