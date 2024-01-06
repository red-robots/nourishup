<?php if( isset($result) && $result ) { ?>
<div class="featured-story-wrap">
  <?php
    $pid = $result->ID;
    $title =  $result->post_title;
    //$excerpt = get_field('excerpt', $pid);
    //$image = get_the_post_thumbnail($pid);
    $image = get_field('thumbnail_image', $pid);
    $content = $result->post_content;
    $numpara = 2;
    $excerpt = getParagraph($content, $numpara);

    

    if( get_field('excerpt', $pid) ) {
      $excerpt = get_field('excerpt', $pid);
    } 

    $column_class = ($excerpt && $image) ? 'half' : 'full';
    $heading = get_field('stories_title','option');
  ?>

  <div class="inner flexwrap <?php echo $column_class ?>">
    <div class="col textcol">
      <?php if($heading) { ?>
      <h2 class="storytitle"><?php echo $heading; ?></h2>
      <?php } ?>

      <div class="featuredSectionTitle"></div>
      <?php if($excerpt) { ?>
        <div class="excerpt">
        <?php if($title) { ?>
        <h3 class="title"><?php echo $title; ?></h3>
        <?php } ?>  
        <?php echo anti_email_spam($excerpt); ?>
        </div>
        <div class="readmore"><a href="<?php echo get_permalink($pid); ?>" class="more">Read More</a></div>
      <?php } ?>
    </div>
    
    <?php if($image ) { ?>
    <div class="col imagecol">
      <figure class="post-image">
        <img src="<?php echo $image['url'] ?>" title="<?php echo $image['title'] ?>" class="custom-image">
        <img src="<?php echo get_stylesheet_directory_uri() ?>/assets/img/square.png" alt="" class="resizer" />
      </figure>
    </div>
    <?php } ?>
  </div>

</div>
<?php } ?>