<?php
$postType = get_post_type();
$obj = get_queried_object();
$is_tribe_events = (isset($obj->name) && $obj->name=='tribe_events') ? true : false;
$taxonomy = (isset($obj->taxonomy) && $obj->taxonomy) ? $obj->taxonomy : '';
$termTitle = (isset($obj->name) && $obj->name) ? $obj->name : '';
$is_tribe_taxonomy = ($taxonomy=='tribe_events_cat') ? true : false;
$is_past_events = ( isset($_GET['status']) && $_GET['status']=='past-events' ) ? true : false;

$solidBlueBanner = array('post','events');

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
    $page_title = trim(get_the_title());
    if($page_title=='Events' && $is_past_events) {
      $page_title = 'Past ' . $page_title;
    }

    $banner_image = get_field('banner_image');
    if($banner_image) {
      $imgAlt = $banner_image['title'];
      $imageUrl = $banner_image['url'];
    }

    $solidBlueBg = ( in_array($postType, $solidBlueBanner) ) ? ' bluebg':'';
    $is_parent_title = false;
    if($postType=='events') {
      $page_title='Events';
      $is_parent_title = true;
    } elseif($postType=='post') {
      $terms = get_the_terms(get_the_ID(),'category');
      $is_client_story = '';
      if($terms) {
        foreach($terms as $term) {
          if($term->slug=='client-stories') {
            $is_client_story = true;
            $page_title = $term->name;
          } else {
            $page_title = 'News';
          }
        }
      }
    }
    ?>
    <div class="subpageHero single-hero<?php echo $solidBlueBg ?>">
      <div class="heroText">
        <div class="wrapper">
          <?php if($is_parent_title) { ?>
            <div class="big-title"><?php echo $page_title ?></div>
          <?php } else { ?>
            <h1 class="big-title"><?php echo $page_title ?></h1>
          <?php } ?>
        </div>
      </div>
      <?php if(!$solidBlueBg) { ?>
        <span class="overlay-background"></span>
        <?php if($imageUrl) { ?>
          <img src="<?php echo $imageUrl?>" alt="<?php echo $imgAlt?>" class="hero-image"/>
        <?php } ?>
      <?php } ?>
    </div>
  
  <?php } ?>
<?php } ?>




