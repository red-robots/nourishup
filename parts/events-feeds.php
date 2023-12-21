<?php
$paged = ( get_query_var( 'pg' ) ) ? absint( get_query_var( 'pg' ) ) : 1;

$is_passed_events = ( isset($_GET['status']) && $_GET['status']=='passed-events' ) ? true : false;
$current_date = date('Y-m-d', strtotime(WP_CURRENT_TIME));
$current_time = date('H:i:s', strtotime(WP_CURRENT_TIME));
$args = array(
  'post_type'         => 'events',
  'posts_per_page'    => $perpage,
  'post_status'       => 'publish',
  'paged'			        => $paged,
  'meta_query'        => array(
    [
      'key'       => 'start_date',
      'compare'   => '>=',
      'value'     => $current_date,
      'type'      => 'DATE',
    ],
  ),
  'meta_key'=>'start_date',
  'orderby'=>'meta_value_num',
  'order'=>'DESC'
);

if( $is_passed_events ) {
  $args['meta_query'] = array(
    [
      'key'       => 'start_date',
      'compare'   => '<',
      'value'     => $current_date,
      'type'      => 'DATE',
    ],
  );
}
$news = new WP_Query($args);
if ( $news->have_posts() ) {  
  $rpcount = $news->found_posts;
  ?>
  <div class="newsfeeds-wrapper events-feeds">
    <div class="news">
      <?php $i=1; while ( $news->have_posts() ) : $news->the_post();  
        //$img = get_field('thumbnail_image');
        $post_id = get_the_ID();
        $thumbnail_id = get_post_thumbnail_id($post_id);
        $thumbnailAlt = get_the_title($thumbnail_id);
        $img = wp_get_attachment_image_src($thumbnail_id,'large');
        $imageUrl = ($img) ? $img[0] : '';
        $imgAlt = ($thumbnailAlt) ? $thumbnailAlt : '';
        $content = get_the_content();
        $content = ($content) ? strip_tags(strip_shortcodes($content))  : '';
        $excerpt = ($content) ? shortenText( $content, 100, ".", "...") : "";

        $today = date('Y-m-d', strtotime(WP_CURRENT_TIME));
        $start_date = get_field('start_date', $post_id);  
        $event_date = '';
        if($start_date) {
          $sDate = date('Y-m-d', strtotime($start_date));
          if($sDate==$today) {
            $event_date = "Now - " . date('F d, Y', strtotime($start_date));
          } else {
            $event_date = date('l, F d, Y', strtotime($start_date));
          }
        }

      

        $timings = array();
        if( $start_time = get_field('start_time', $post_id) ) {
          $stime = date('g:ia', strtotime($start_time));
          if (strpos($stime, ':00') !== false) {
            $stime = str_replace(':00','',$stime);
          }
          $timings[] = $stime;
        }
        if( $end_time = get_field('end_time', $post_id) ) {
          $etime = date('g:ia', strtotime($end_time));
          if (strpos($etime, ':00') !== false) {
            $etime = str_replace(':00','',$etime);
          }
          $timings[] = $etime;
        }
        $time_range = '';
        if($timings) {
          $time_range = implode(' - ', $timings);
          if($event_date) {
            $event_date .= ' <b>|</b> ' . $time_range;
          }
        }
        ?>
        <article class="post-item event-item">
          <div class="inside">
            <div class="textcol fxcol">
              <div class="event-title">
                <h2 class="post-title"><?php echo get_the_title()?></h2>
                <?php if($event_date) { ?>
                <div class="event-date"><?php echo $event_date?></div>
                <?php } ?>
              </div>
              
              <div class="excerpt"><?php echo $excerpt ?></div>
              <div class="readmore"><a href="<?php echo get_permalink() ?>" class="morelink">Read More</a></div>
            </div>

            <figure class="imagecol fxcol">
              <?php if($imageUrl) { ?>
                <a href="<?php echo get_permalink() ?>">
                  <img src="<?php echo $imageUrl?>" alt="<?php echo $imgAlt?>" class="post-image" />
                  <img src="<?php echo get_stylesheet_directory_uri()?>/assets/img/rectangle-lg.png" alt="" class="resizer" />
                </a>
              <?php } else { ?>
                <img src="<?php echo get_stylesheet_directory_uri()?>/assets/img/rectangle-lg.png" alt="" />
              <?php } ?>
            </figure>
          </div>
        </article>
      <?php $i++; endwhile; wp_reset_postdata(); ?>
    </div>

    <div id="pagination" class="pagination-wrapper clear<?php echo ($is_passed_events) ? ' passed-events':'' ?>">
      <?php
      $total_pages = $news->max_num_pages;
      if ($total_pages > 1) { ?>
        <?php
        $pagination = array(
            'base' => @add_query_arg('pg','%#%'),
            'format' => '?paged=%#%',
            'current' => $paged,
            'total' => $total_pages,
            'prev_text' => __( '&laquo;', 'red_partners' ),
            'next_text' => __( '&raquo;', 'red_partners' ),
            'type' => 'plain'
        );
        echo paginate_links($pagination);
        ?>
      <?php } ?>
      <?php if( $is_passed_events ) { ?>
        <a href="<?php echo get_permalink()?>" class="morelink current-events">Upcoming Events</a>
      <?php } ?>
    </div>
  </div>
<?php } ?>


<?php
if( !$is_passed_events ) {
  $args2 = array(
    'post_type'         => 'events',
    'posts_per_page'    => 1,
    'post_status'       => 'publish',
    'meta_query'        => array(
      [
        'key'       => 'start_date',
        'compare'   => '<',
        'value'     => $current_date,
        'type'      => 'DATE',
      ],
    ),
  );

  $old_posts = get_posts($args2);
  $currentLink = get_permalink() . '?status=passed-events';
  if($old_posts) { ?>
  <div class="old-posts"><a class="morelink prev-post" href="<?php echo $currentLink?>">Previous Events</a></div>
  <?php } 
}
?>