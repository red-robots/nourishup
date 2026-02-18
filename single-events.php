<?php
/**
 * The template for displaying all pages.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package bellaworks
 */

$placeholder = THEMEURI . 'images/rectangle.png';
$banner = get_field("banner_image");
$has_banner = ($banner) ? 'hasbanner':'nobanner';
global $post;
$postType = get_post_type();
$hero = get_field('stories_hero','option');
$heading = get_field('stories_title','option');
get_header(); ?>

<div id="primary" class="content-area-full content-default page-default-template post-type-<?php echo $postType ?> <?php echo $has_banner ?>">
  
  <main id="main" class="site-main wrapper" role="main">
		<?php while ( have_posts() ) : the_post(); 
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

      $end_date = get_field('end_date', $post_id); 
      $end_date = ($end_date) ? date('F d, Y', strtotime($end_date)) : '';

      if($start_date && $end_date) {
        $stDate = strtotime($start_date);
        $endDateStr = strtotime($end_date);
        $nowTime = strtotime(WP_CURRENT_TIME);
        $event_date = date('F d, Y', strtotime($start_date));
        $event_date .= ' to ' . $end_date;

        if($nowTime < $endDateStr) {
          $event_date = 'Now through ' . $end_date;
        }
        
        if($is_past_events) {
          if($stDate < $nowTime) {
            if($time_range) {
              $event_date = date('l, F d, Y', strtotime($start_date))  . ' | ' . $time_range;
            } else {
              $event_date = date('l, F d, Y', strtotime($start_date));
            }
          }
        }

        if($stDate==$endDateStr) {
          if($time_range) {
            $event_date = date('l, F d, Y', strtotime($start_date)) . ' | ' . $time_range;
          } else {
            $event_date = date('l, F d, Y', strtotime($start_date));
          }
        }

      }

      //Uncomment this to display event date
      $event_date = '';
      ?>
      
      <div class="flexwrap full">
        <?php if( get_page_template_slug( get_the_ID() ) ) { ?>
          <div class="titlediv is-template">
            <h1 class="page-title"><?php the_title(); ?></h1>
          </div>
        <?php } else { ?>

          <?php if( get_post_type()!="post" ) { ?>
            <div class="titlediv typical">
              <h1 class="page-title"><span><?php the_title(); ?></span></h1>
              <?php if($event_date) { ?>
                <div class="event-date"><?php echo $event_date?></div>
              <?php } ?>
            </div>
          <?php } ?>

        <?php } ?>

        <?php if ( get_the_content() ) { ?>
        <div class="entry-content padtop">
          <?php the_content(); ?>
        </div>
        <?php } ?>
      </div>

		<?php endwhile; ?>

	</main><!-- #main -->

  <aside id="single-post-widget">
    <?php get_template_part('parts/recent-events-widget'); ?>
  </aside>
</div><!-- #primary -->

<?php
get_footer();
