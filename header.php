<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<?php if ( is_singular(array('post')) ) { 
global $post;
$post_id = $post->ID;
$thumbId = get_post_thumbnail_id($post_id); 
$featImg = wp_get_attachment_image_src($thumbId,'full'); ?>
<!-- SOCIAL MEDIA META TAGS -->
<meta property="og:site_name" content="<?php bloginfo('name'); ?>"/>
<meta property="og:url"   content="<?php echo get_permalink(); ?>" />
<meta property="og:type"  content="article" />
<meta property="og:title" content="<?php echo get_the_title(); ?>" />
<meta property="og:description" content="<?php echo (get_the_excerpt()) ? strip_tags(get_the_excerpt()):''; ?>" />
<?php if ($featImg) { ?>
<meta property="og:image" content="<?php echo $featImg[0] ?>" />
<?php } ?>
<!-- end of SOCIAL MEDIA META TAGS -->
<?php } ?>

<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<?php
$homepageLogo = get_field('homepage_logo','option');
$subPageLogo = get_field('subpage_logo','option');
?>
<script>
const homepageLogo = '<?php echo ($homepageLogo) ? $homepageLogo['url']:''?>';
const subpageLogo = '<?php echo ($subPageLogo) ? $subPageLogo['url']:''?>';
const siteName = '<?php echo get_bloginfo('name') ?>';
const assetsDir = '<?php echo get_stylesheet_directory_uri() ?>/assets/img';
const siteURL = '<?php echo get_site_url() ?>';
const currentPageId = <?php echo (is_page()) ? get_the_ID():"''"?>;
const params={};location.search.replace(/[?&]+([^=&]+)=([^&]*)/gi,function(s,k,v){params[k]=v});
</script>
<?php wp_head(); ?>
<?php
$terms = get_terms( [
  'taxonomy' => 'tribe_events_cat',
  'hide_empty' => false,
] );
?>
<script>const tribeCategories = <?php echo ($terms) ? json_encode($terms) : '' ?>;</script>
<style>
  .filterInner .custom-calendar-filter {
    position: relative;   
  }
  .filterInner .custom-calendar-filter a.resetLink {
    display: inline-block;
    position: absolute;
    top: -35px;
    right: 2px;
  }
  @media screen and (max-width:768px) {
    .filterWrapper {
      padding-top: 20px;
    }
    .filterInner .custom-calendar-filter {
      text-align: center;
    }
    .filterInner .custom-calendar-filter a.resetLink {
      position: relative;
      top: -15px;
      right: 0;
      margin-bottom: 10px;
    }
  }
</style>
</head>
<body <?php body_class(); ?>>

<?php get_template_part('parts/announcement'); ?>

<div id="page" class="site cf">
  <div id="overlay"></div>
  <a class="skip-link sr" href="#content"><?php esc_html_e( 'Skip to content', 'bellaworks' ); ?></a>
  <header id="masthead" class="site-header">
    <div class="wrapper cf">
      
      <a href="#" id="menu-toggle" class="menu-toggle" aria-label="Menu Toggle"><span class="sr">Menu</span><span class="bar"></span></a>

      <div class="head-inner">

        <?php 
          $horizontalLogo =  get_field('subpage_logo','option');
          if( is_front_page() || is_home() ) {
            $siteLogo = get_field('homepage_logo','option'); 
          } else {
            $siteLogo = get_field('subpage_logo','option'); 
          }
          $hb = get_field('header_button','option');
          $btnTarget = (isset($hb['target']) && $hb['target']) ? $hb['target'] : '_self';
          $btnName = (isset($hb['title']) && $hb['title']) ? $hb['title'] : '';
          $btnLink = (isset($hb['url']) && $hb['url']) ? $hb['url'] : '';
          $headerButtons = '';
          if ($btnName && $btnLink) {
            $headerButtons = '<a href="'.$btnLink.'" target="'.$btnTarget.'" class="button-round">'.$btnName.'</a>';
          }
        ?>

        <?php if( $siteLogo ) { ?>
        <span class="site-logo">
          <a href="<?php echo get_site_url() ?>">
            <!-- <img src="<?php //echo get_stylesheet_directory_uri() ?>/assets/img/logo-plain.png" alt="<?php //echo get_bloginfo('name') ?>" class="logo-shrink"> -->
            <img src="<?php echo $siteLogo['url'] ?>" alt="<?php echo get_bloginfo('name') ?>" class="logo-full">
            <?php if( (is_front_page() || is_home())  && $horizontalLogo ) { ?>
            <img src="<?php echo $horizontalLogo['url'] ?>" alt="<?php echo get_bloginfo('name') ?>" class="logo-full logo-sticky" style="display:none">
            <?php } ?>
          </a>
        </span>
        <?php } ?>

        <nav id="site-navigation" class="main-navigation" role="navigation">
          <?php wp_nav_menu( array( 'theme_location' => 'primary', 'menu_id' => 'primary-menu','link_before'=>'<span>','link_after'=>'</span>','container_class'=>'menu-wrapper', 'items_wrap'=>'<ul id="%1$s" class="%2$s">%3$s<li class="header-buttons">'.$headerButtons.'</li></ul>') ); ?>
        </nav>
        
      </div>
    </div>
  </header>


  <div id="content" class="site-content">

  <?php get_template_part('parts/page-banner'); ?>