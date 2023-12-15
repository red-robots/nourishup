<?php
$postType = get_post_type();
$obj = get_queried_object();
$is_tribe_events = (isset($obj->name) && $obj->name=='tribe_events') ? true : false;
$taxonomy = (isset($obj->taxonomy) && $obj->taxonomy) ? $obj->taxonomy : '';
$termTitle = (isset($obj->name) && $obj->name) ? $obj->name : '';
$is_tribe_taxonomy = ($taxonomy=='tribe_events_cat') ? true : false;

if($is_tribe_events || $is_tribe_taxonomy) {

  $hero = get_field('pantries_hero_image','option');  
  $pageTitle = ''; 
  if($is_tribe_events) {
    $pageTitle = get_field('pantries_page_title','option'); 
  } else if($is_tribe_taxonomy) {
    $pageTitle = $termTitle;
  }
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

<?php if( $is_tribe_events || $is_tribe_taxonomy ) { ?>
<div class="filterWrapper<?php echo ($is_tribe_taxonomy) ? ' tribe-tax-page':'';?>">
  <div class="filterInner">
    <div class="custom-calendar-filter"></div>
    <div class="otherFilters"></div>
  </div>
</div>
<?php } ?>

<?php //Default Page
if( (is_page() || is_single()) && !is_front_page() ) { 
  if( !get_field('repeatable_blocks') ) {
    $focalX = get_field('focal_point_x');
    $focalY = get_field('focal_point_y');
    $x = ($focalX) ? $focalX : 0;
    $y = ($focalY) ? $focalY : 0;
    if( $focalX || $focalY) { 
      echo '<style>.subpageHero img{object-position:'.$x.'% '.$y.'%!important;}</style>';
    }

    if( is_single() ) {
      $img = get_field('large_image');
      $imageUrl = ($img) ? $img['url'] : '';
      $imgAlt = ($img) ? $img['title'] : '';
    } else {
      $imageUrl = get_the_post_thumbnail_url();
      $imgAlt = ($imageUrl) ? get_post(get_post_thumbnail_id())->post_title : '';
    }
    ?>
    <div class="subpageHero single-hero">
      <div class="heroText">
        <div class="wrapper">
        <h1 class="big-title"><?php echo get_the_title()?></h1>
        </div>
      </div>
      <span class="overlay-background"></span>
      <?php if($imageUrl) { ?>
        <img src="<?php echo $imageUrl?>" alt="<?php echo $imgAlt?>" class="hero-image"/>
      <?php } ?>
    </div>
  
  <?php } ?>
<?php } ?>




