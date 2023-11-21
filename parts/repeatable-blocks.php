<?php if( have_rows('repeatable_blocks', $post_id) ) { ?>
  <?php $i=1; while( have_rows('repeatable_blocks',$post_id) ): the_row(); ?>
    
    <?php /* HERO */
    if( get_row_layout() == 'banner' ) { 
      $image = get_sub_field('image');
      $small_text = get_sub_field('small_text');
      $large_text = get_sub_field('large_text');
      $page_title = ($large_text) ? $large_text : get_the_title($post_id); 
      if($image) { ?>
      <div class="repeatable-hero repeatable">
        <?php if($small_text || $large_text) { ?>
        <div class="heroText">
          <div class="wrapper">
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
        <img src="<?php echo $image['url']; ?>" alt="<?php echo $image['title']; ?>" class="hero-image" />
      </div>
      <?php } ?>
    <?php } ?>


    <?php /* INTRO */
    if( get_row_layout() == 'intro' ) { 
      $title = get_sub_field('title');
      $content = get_sub_field('content');
      if($title || $content) { ?>
      <div class="repeatable-intro repeatable">
        <div class="wrapper">
          <?php if ($title) { ?>
          <h2><?php echo $title ?></h2>
          <?php } ?>
          <?php if ($content) { ?>
          <div class="textwrap"><?php echo $content ?></div>
          <?php } ?>
        </div>
      </div>
      <?php } ?>
    <?php } ?>


    <?php /* 3-COLUMNS ROW */
    if( get_row_layout() == 'multiple_columns' ) { 
      $columns = get_sub_field('columns');
      if( have_rows('columns') ) { ?>
      <div class="repeatable-columns repeatable">
        <div class="wrapper">
          <div class="rcolumns">
          <?php while( have_rows('columns') ) : the_row(); 
            $icon = get_sub_field('icon');
            $bgcolor = get_sub_field('icon_bgcolor');
            $title = get_sub_field('title');
            $content = get_sub_field('content');
            $btn = get_sub_field('button');
            $btnTarget = (isset($btn['target']) && $btn['target']) ? $btn['target'] : '_self';
            $btnName = (isset($btn['title']) && $btn['title']) ? $btn['title'] : '';
            $btnLink = (isset($btn['url']) && $btn['url']) ? $btn['url'] : '';
            $styleColor = ($bgcolor) ? $bgcolor : '#81C674';
            ?>
            <div class="rcolumn">
              <div class="inside">
                <?php if($icon) { ?>
                <div class="icondiv" style="background:<?php echo $styleColor?>"><span style="background-image:url('<?php echo $icon['url']?>')"></span></div>
                <?php } ?>
                <?php if($title || $content) { ?>
                <div class="textwrap">
                  <?php if($title) { ?>
                  <h3 class="coltitle"><?php echo $title?></h3>
                  <?php } ?>
                  <div class="text"><?php echo $content?></div>
                  <?php if($btnName && $btnLink) { ?>
                  <div class="morelink"><a href="<?php echo $btnLink?>" target="<?php echo $btnTarget?>"><?php echo $btnName?></a></div>
                  <?php } ?>
                </div>
                <?php } ?>
              </div>
            </div>
          <?php endwhile; ?>
          </div>
        </div>
      </div>
      <?php } ?>
    <?php } ?>


    <?php /* FULLWIDTH BLOCK WITH IMAGE AND TEXT */
    if( get_row_layout() == 'fullwidth_image_text' ) { 
      $bgcolor = get_sub_field('bgcolor');
      $bgcolor = ($bgcolor) ? $bgcolor : '#32845C';

      $textcolor = get_sub_field('textcolor');
      $textcolor = ($textcolor) ? $textcolor : '#FFFFFF';
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
      <style>
        .repeatable-image-text-block h2,
        .repeatable-image-text-block p,
        .repeatable-image-text-block *,
        .repeatable-image-text-block a {
          color: <?php echo $textcolor?>!important;
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
      <div class="repeatable-image-text-block repeatable block-type-<?php echo $block_type?>">
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
                      <?php if($title) { ?><h2 class="item-title"><?php echo $title?></h2><?php } ?>  
                      <?php if($content) { ?><div class="item-text"><?php echo $content?></div><?php } ?>  
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


  <?php $i++; endwhile; ?>
<?php } ?>