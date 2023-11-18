<!-- wp:template-part {"slug":"header","tagName":"header"} /-->

<?php
/**
 * Template Name: Repeatable Blocks
 */
?>
<div id="primary" class="content-area-full repeatable-layout ">
	<main id="main" class="site-main" role="main" data-pagetitle="<?php echo get_the_title()?>">
		<?php while ( have_posts() ) : the_post(); ?>

    <?php if( have_rows('repeatable_blocks') ) { ?>
    <div class="repeatable-blocks">
      <?php $n=1; while( have_rows('repeatable_blocks') ): the_row(); ?>
        <?php if( get_row_layout() == 'banner' ) { 
          $image = get_sub_field('image');
          $small_text = get_sub_field('small_text');
          $large_text = get_sub_field('large_text');
          $page_title = ($large_text) ? $large_text : get_the_title();
          if($image) { ?>
          <div class="fullwidth-hero repeatable-item">
            <?php if($small_text || $large_text) { ?>
            <div class="heroText">
              <div class="inside">
                <?php if($small_text) { ?>
                <div class="sm-title"><?php echo $small_text; ?></div>
                <?php } ?>

                <?php if($large_text) { ?>
                <h1 class="big-title"><?php echo $large_text; ?></h1>
                <?php } ?>
              </div>
            </div>
            <?php } ?>
            <span class="overlay-background"></span>
            <img src="<?php echo $image['url']; ?>" alt="<?php echo $image['title']; ?>" />
          </div>
          <?php } ?>
        <?php } ?>

      <?php endwhile; ?>
    </div>
    <?php } ?>

		<?php endwhile; ?>
	</main><!-- #main -->
</div><!-- #primary -->


<!-- wp:template-part {"slug":"footer","tagName":"footer"} /-->
