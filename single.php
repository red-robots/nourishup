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
$posttypes_exceptions = ["tribe_event_series"];
get_header(); 
?>

<div id="primary" class="content-area-full content-default page-default-template post-type-<?php echo $postType ?> <?php echo $has_banner ?>">
  
  <main id="main" class="site-main wrapper" role="main">
		<?php while ( have_posts() ) : the_post(); ?>
      
      <div class="flexwrap full">
        <?php if( get_page_template_slug( get_the_ID() ) ) { ?>
          <div class="titlediv is-template">
            <h1 class="page-title"><?php the_title(); ?></h1>
          </div>
        <?php } else { ?>

          <?php if( !in_array($postType, $posttypes_exceptions) ) { ?>
            <div class="titlediv typical">
              <h1 class="page-title"><span><?php the_title(); ?></span></h1>
            </div>
          <?php } ?>

        <?php } ?>

        <?php if ( get_the_content() ) { ?>
        <div class="entry-content padtop">
          <?php the_content(); ?>
        </div>
        <?php } ?>


        <?php if ($postType=="tribe_event_series") { ?>
          <div class="tribe-event-content-wrap"><?php the_content(); ?></div>
        <?php } ?>
      </div>



		<?php endwhile; ?>

	</main><!-- #main -->

  <?php if($postType=='post' || $postType=='stories') { ?>
  <aside id="single-post-widget">
    <?php get_template_part('parts/recent-news-widget'); ?>
  </aside>
  <?php } ?>			
</div><!-- #primary -->

<?php
get_footer();
