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
$hero = get_field('stories_hero','option');
$heading = get_field('stories_title','option');
get_header(); ?>

<div id="primary" class="content-area-full content-default page-default-template <?php echo $has_banner ?>">
  <?php if($hero) { ?>
    <div class="repeatable-hero repeatable">
      <div class="heroText">
        <div class="wrapper">
        <?php if($heading) { ?>
        <h1 class="big-title"><?php echo $heading; ?></h1>
        <?php } ?>
        </div>
      </div>
    <span class="overlay-background"></span>
    <img src="https://nourishup.flywheelsites.com/wp-content/uploads/2023/11/banner2.jpg" alt="banner2" class="hero-image">
    </div>
  <?php } ?>

  <main id="main" class="site-main wrapper" role="main">
		<?php while ( have_posts() ) : the_post(); ?>
      <?php if( has_post_thumbnail() ) { ?>
        
        <div class="flexwrap twocol">
          <div class="fxcol full">
          <?php if( get_page_template_slug( get_the_ID() ) ) { ?>
            <div class="titlediv is-template">
              <?php if($heading) { ?>
                <h1 class="page-title"><?php the_title(); ?></h1>
              <?php } ?>
            </div>
          <?php } else { ?>
            <!-- <div class="titlediv typical">
              <h1 class="page-title"><span><?php //the_title(); ?></span></h1>
            </div> -->
          <?php } ?>
          </div>
          <div class="fxcol left">
          <?php if ( get_the_content() ) { ?>
          <div class="entry-content padtop">
            <?php the_content(); ?>
          </div>
          <?php } ?>
          </div>

          <div class="fxcol right">
            <figure class="wp-featured-img"><?php the_post_thumbnail() ?></figure>
          </div>
        </div>

      <?php } else { ?>

        <?php if( get_page_template_slug( get_the_ID() ) ) { ?>
          <div class="titlediv is-template">
            <h1 class="page-title"><?php the_title(); ?></h1>
          </div>
        <?php } else { ?>
          <div class="titlediv typical">
            <h1 class="page-title"><span><?php the_title(); ?></span></h1>
          </div>
        <?php } ?>

        <?php if ( get_the_content() ) { ?>
        <div class="entry-content padtop">
          <?php the_content(); ?>
        </div>
        <?php } ?>

      <?php } ?>

			

		<?php endwhile; ?>

	</main><!-- #main -->
</div><!-- #primary -->

<?php
get_footer();
