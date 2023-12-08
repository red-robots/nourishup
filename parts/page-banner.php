<?php
$postType = get_post_type();
$obj = get_queried_object();
$is_tribe_events = (isset($obj->name) && $obj->name=='tribe_events') ? true : false;
if($is_tribe_events) { 
  $hero = get_field('pantries_hero_image','option');  
  $pageTitle = get_field('pantries_page_title','option');  
  if($hero) { ?>
  <div class="subpageHero">
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

<?php //Default Page
if( is_page() || is_single() ) { 
  $focalX = get_field('focal_point_x');
  $focalY = get_field('focal_point_y');
  $x = ($focalX) ? $focalX : 0;
  $y = ($focalY) ? $focalY : 0;
  if( $focalX || $focalY) { 
    echo '<style>.subpageHero img{object-position:'.$x.'% '.$y.'%!important;}</style>';
  }
  if(get_the_post_thumbnail()) { 
    $imageUrl = get_the_post_thumbnail_url();
    ?>

    <div class="subpageHero">
      <div class="heroText">
        <div class="wrapper">
        <h1 class="big-title"><?php echo get_the_title()?></h1>
        </div>
      </div>
      <span class="overlay-background"></span>
      <?php the_post_thumbnail(); ?>
    </div>
  <?php } ?>
<?php } ?>



