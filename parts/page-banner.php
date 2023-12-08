<?php
$postType = get_post_type();
$obj = get_queried_object();
$is_tribe_events = (isset($obj->name) && $obj->name=='tribe_events') ? true : false;
if($is_tribe_events) { 
  $hero = get_field('pantries_hero_image','option');  
  $pageTitle = get_field('pantries_page_title','option');  
  if($hero) { ?>
  <div class="repeatable-hero repeatable">
    <?php if($pageTitle) { ?>
    <div class="heroText">
      <div class="wrapper">
      <h1 class="big-title"><?php echo $pageTitle?></h1>
      </div>
    </div>
    <?php } ?>
    <span class="overlay-background"></span>
    <img src="<?php echo $hero['url'] ?>" alt="<?php echo $hero['title'] ?>" class="hero-image">
  </div>
<?php } ?>
<?php } ?>