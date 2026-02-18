<?php
global $post;
$current_post_id = $post->ID;
$posts_per_page = 10;

$args = array(
  'posts_per_page'  => $posts_per_page,
  'post_type'       => 'post',
  'orderby'         => 'date',
  'order'           => 'desc',
  'post_status'     => 'publish',
  'post__not_in'    => array($current_post_id),
);
$recentposts = new WP_Query($args);
if ( $recentposts->have_posts() ) {  
  $rpcount = $recentposts->found_posts;
  ?>
  <div class="recents-posts-widget">
    <h3>Recent Posts</h3>
    <ul class="recent-posts">
      <?php $i=1; while ( $recentposts->have_posts() ) : $recentposts->the_post();  ?>
        <li><a href="<?php echo get_permalink() ?>"><?php echo get_the_title()?></a></li>
      <?php $i++; endwhile; wp_reset_postdata(); ?>
    </ul>

    <?php  
    $total_pages = $recentposts->max_num_pages;
    if( $rpcount > $posts_per_page ) { ?>
    <div class="morelink">
      <a href="<?php echo get_site_url() ?>/news" class="more-btn">View All Posts</a>
    </div>
    <?php } ?>
  </div>
<?php } ?>