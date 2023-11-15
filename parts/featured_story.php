<?php if( isset($featured) && $featured ) { ?>
<div class="featured-story-wrap">
  <?php
    $pid = $featured->ID;
    $title =  $featured->post_title;;
    $excerpt = get_field('excerpt', $pid);
    $image = get_the_post_thumbnail($pid);
    $column_class = ($excerpt && $image) ? 'half' : 'full';
  ?>

  <div class="inner flexwrap <?php echo $column_class ?>">
    <div class="col textcol">
      <h2><?php echo $title ?></h2>
      <?php if($excerpt) { ?>
      <div class="excerpt"><?php echo $excerpt ?></div>
      <div class="readmore"><a href="<?php echo get_permalink($pid); ?>" class="more">Read More</a></div>
      <?php } ?>
    </div>
    
    <?php if($image ) { ?>
    <div class="col imagecol">
      <figure><?php echo $image ?></figure>
    </div>
    <?php } ?>
  </div>

</div>
<?php } ?>