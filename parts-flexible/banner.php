<?php if( get_row_layout() == 'banner' ) { 
  $image = get_sub_field('image');
  $small_text = get_sub_field('small_text');
  $large_text = get_sub_field('large_text');
  $page_title = ($large_text) ? $large_text : get_the_title($post_id); 
  if($image) { ?>
  <div data-group="<?php echo get_row_layout() ?>" id="repeatable-<?php echo get_row_layout() ?>--<?php echo $i ?>" class="repeatable-hero repeatable">
    <?php if($small_text || $large_text) { ?>
    <div class="heroText">
      <div class="wrapper">
        <?php if($small_text) { ?>
        <div class="sm-title"><?php echo anti_email_spam($small_text); ?></div>
        <?php } ?>

        <?php if($large_text) { ?>
        <h1 class="big-title"><?php echo anti_email_spam($large_text); ?></h1>
        <?php } ?>
      </div>
    </div>
    <?php } ?>
    <span class="overlay-background"></span>
    <img src="<?php echo $image['url']; ?>" alt="<?php echo $image['title']; ?>" class="hero-image" />
  </div>
  <?php } ?>
<?php } ?>