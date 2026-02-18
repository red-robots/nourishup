<?php if( get_row_layout() == 'fullwidth_image_text' ) { 
  $bgcolor = get_sub_field('bgcolor');
  $bgcolor = ($bgcolor) ? $bgcolor : '#32845C';

  $textcolor = get_sub_field('textcolor');
  $textcolor = ($textcolor) ? $textcolor : '#FFF';
  $image = get_sub_field('image');
  $image_position = get_sub_field('image_position');
  $image_position = ($image_position) ? ' ' . $image_position : ' img_left';
  $title = get_sub_field('title');
  $content = get_sub_field('content');
  $btn = get_sub_field('button'); 
  $btnTarget = (isset($btn['target']) && $btn['target']) ? $btn['target'] : '_self';
  $btnLink = (isset($btn['url']) && $btn['url']) ? $btn['url'] : '';
  $btnName = (isset($btn['title']) && $btn['title']) ? $btn['title'] : '';
  $colClass = ($image && ($title||$content)) ? 'half':'full';

  $blockWidth = get_sub_field('block_type');
  $block_type = $blockWidth;
  $block_type .= $image_position;
  ?>
  <div data-group="<?php echo get_row_layout() ?>" id="repeatable-<?php echo get_row_layout() ?>--<?php echo $i ?>" class="repeatable-image-text-block repeatable-block-<?php echo $i?>  repeatable block-type-<?php echo $block_type?>" data-textcolor="<?php echo $textcolor?>">
    <style>
      .repeatable-block-<?php echo $i?> .textCol p,
      .repeatable-block-<?php echo $i?> .textCol *,
      .repeatable-block-<?php echo $i?> .textCol a,
      .repeatable-block-<?php echo $i?> .textCol .item-link a,
      .repeatable-block-<?php echo $i?> .textCol h2,
      .repeatable-block-<?php echo $i?> .textCol h3,
      .repeatable-block-<?php echo $i?> .textCol h4,
      .repeatable-block-<?php echo $i?> .textCol h5,
      .repeatable-block-<?php echo $i?> .textCol h6,
      .repeatable-block-<?php echo $i?> .textCol li {
        color: <?php echo $textcolor?>!important;
      }
      .repeatable-block-<?php echo $i?> .textCol .item-link a:after {
        border-left-color: <?php echo $textcolor?>!important;
      }
      .repeatable-block-<?php echo $i?> .textCol .item-link a {
        border-block-color: <?php echo $textcolor?>!important;
      }
      .repeatable-image-text-block .item-link a {
        color: <?php echo $textcolor?>!important;
        border-bottom-color: <?php echo $textcolor?>!important;
      }
      .repeatable-image-text-block .item-link a:after {
        border-left-color: <?php echo $textcolor?>!important;
      }
      .repeatable-image-text-block .item-link a:hover {
        color:#FEBC11!important;
        border-bottom-color:#FEBC11!important;
      }
      .repeatable-image-text-block .item-link a:hover:after {
        border-left-color:#FEBC11!important;
      }
    </style>
    <?php if($blockWidth=='full') { ?>
      <div class="wrapper">
        <div class="inner-block" style="background-color:<?php echo $bgcolor?>">
          <div class="flexwrap <?php echo $colClass?>">
            <?php if($image) { ?>
              <figure class="imageCol">
                <img src="<?php echo $image['url'] ?>" alt="<?php echo $image['title'] ?>">
              </figure>
            <?php } ?>
            <?php if($title||$content) { ?>
              <div class="textCol">
                <div class="inside">
                  <?php if($title) { ?><h2 class="item-title"><?php echo anti_email_spam($title)?></h2><?php } ?>  
                  <?php if($content) { ?><div class="item-text"><?php echo anti_email_spam($content)?></div><?php } ?>  
                  <?php if($btnLink && $btnName) { ?><div class="item-link"><a href="<?php echo $btnLink?>" target="<?php echo $btnTarget?>"><?php echo $btnName?></a></div><?php } ?>  
                </div>
              </div>
            <?php } ?>
          </div>
        </div>
      </div>
    <?php } else { ?>
      <div class="wrapper">
        <div class="inner-block" style="background-color:<?php echo $bgcolor?>">
          <div class="flexwrap <?php echo $colClass?>">
            <?php if($image) { ?>
              <figure class="imageCol">
                <img src="<?php echo $image['url'] ?>" alt="<?php echo $image['title'] ?>">
              </figure>
            <?php } ?>
            <?php if($title||$content) { ?>
              <div class="textCol">
                <div class="inside">
                  <?php if($title) { ?><h2 class="item-title"><?php echo $title?></h2><?php } ?>  
                  <?php if($content) { ?><div class="item-text"><?php echo $content?></div><?php } ?>  
                  <?php if($btnLink && $btnName) { ?><div class="item-link"><a href="<?php echo $btnLink?>" target="<?php echo $btnTarget?>"><?php echo $btnName?></a></div><?php } ?>  
                </div>
              </div>
            <?php } ?>
          </div>
        </div>
      </div>
    <?php } ?>
  </div>
<?php } ?>
