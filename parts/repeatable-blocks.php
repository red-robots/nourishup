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


    <?php /* INTRO */
    if( get_row_layout() == 'intro' ) { 
      $title = get_sub_field('title');
      $content = get_sub_field('content');
      $buttons = get_sub_field('buttons');
      if($title || $content) { ?>
      <div class="repeatable-intro repeatable">
        <div class="wrapper">
          <?php if ($title) { ?>
          <h2><?php echo $title ?></h2>
          <?php } ?>
          <?php if ($content) { ?>
          <div class="textwrap"><?php echo anti_email_spam($content) ?></div>
          <?php } ?>
          <?php if ($buttons) { ?>
          <div class="buttons">
            <?php foreach($buttons as $b) { 
              $btn = $b['button'];
              $btnTarget = (isset($btn['target']) && $btn['target']) ? $btn['target'] : '_self';
              $btnTitle = (isset($btn['title']) && $btn['title']) ? $btn['title'] : '';
              $btnLink = (isset($btn['url']) && $btn['url']) ? $btn['url'] : '';

              $bgcolor = (isset($b['bgcolor']) && $b['bgcolor']) ? $b['bgcolor'] : '#f26522';
              $textcolor = (isset($b['textcolor']) && $b['textcolor']) ? $b['textcolor'] : '#FFFFFF';

              if( $btnTitle && $btnLink ) { ?>
                <a href="<?php echo $btnLink ?>" target="<?php echo $btnTarget ?>" class="repeatable-button" style="background:<?php echo $bgcolor ?>;color:<?php echo $textcolor ?>"><?php echo $btnTitle ?></a>
              <?php } ?>
            <?php } ?>
          </div>
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
            $icon_type = get_sub_field('icon_type');
            $icon_type = ($icon_type) ? $icon_type : 'icon';
            $bgcolor = get_sub_field('icon_bgcolor');
            $title = get_sub_field('title');
            $content = get_sub_field('content');
            $btn = get_sub_field('button');
            $btnTarget = (isset($btn['target']) && $btn['target']) ? $btn['target'] : '_self';
            $btnName = (isset($btn['title']) && $btn['title']) ? $btn['title'] : '';
            $btnLink = (isset($btn['url']) && $btn['url']) ? $btn['url'] : '';
            $styleColor = ($bgcolor) ? $bgcolor : '#81C674';
            ?>
            <div class="rcolumn feat-<?php echo $icon_type?>">
              <div class="inside">
                <?php if($icon) { ?>
                <div class="icondiv" style="background:<?php echo $styleColor?>"><span style="background-image:url('<?php echo $icon['url']?>')"></span></div>
                <?php } ?>
                <?php if($title || $content) { ?>
                <div class="textwrap">
                  <?php if($title) { ?>
                  <h3 class="coltitle"><?php echo $title?></h3>
                  <?php } ?>
                  <div class="text"><?php echo anti_email_spam($content)?></div>
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
      <div class="repeatable-image-text-block repeatable-block-<?php echo $i?>  repeatable block-type-<?php echo $block_type?>" data-textcolor="<?php echo $textcolor?>">
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


    <?php /* FULLWIDTH TEXT BLOCK */
    if( get_row_layout() == 'fullwidth_textblock' ) { 
      $text_content = get_sub_field('text_content');
      $bgcolor = get_sub_field('section_bgcolor');
      $bgcolor = ($bgcolor) ? $bgcolor : '#32845c';
      $textcolor = get_sub_field('textcolor');
      $textcolor = ($textcolor) ? $textcolor : '#FFF';
      $buttons = get_sub_field('buttons');
      if($text_content) { ?>
      <style>
        .repeatable-fullwidth-text-block-<?php echo $i?> a.link-arrow {
          color:<?php echo $textcolor?>;
          border-bottom-color:<?php echo $textcolor?>;
        }
        .repeatable-fullwidth-text-block-<?php echo $i?> a.link-arrow:after {
          border-left-color:<?php echo $textcolor?>;
        }
      </style>
      <div class="repeatable-fullwidth-text-block repeatable-fullwidth-text-block-<?php echo $i?>  repeatable">
        <div class="wrapper">
          <div class="inside" style="background:<?php echo $bgcolor?>;color:<?php echo $textcolor?>">
            <?php if($text_content) {?>
            <div class="textwrap"><?php echo anti_email_spam($text_content); ?></div>
            <?php } ?>
            <?php if($buttons) { ?>
            <div class="buttons">
              <?php foreach($buttons as $b) { 
                  $color = $b['color'];
                  $btn = $b['button'];
                  $btnTarget = (isset($btn['target']) && $btn['target']) ? $btn['target'] : '_self';
                  $btnTitle = (isset($btn['title']) && $btn['title']) ? $btn['title'] : '';
                  $btnLink = (isset($btn['url']) && $btn['url']) ? $btn['url'] : '';
                  if($btnLink && $btnTitle) { ?>
                    <a href="<?php echo $btnLink; ?>" target="<?php echo $btnTarget; ?>" class="link-arrow"><?php echo $btnTitle; ?></a>
                  <?php } ?>
              <?php } ?>
            </div>
            <?php } ?>
          </div>
        </div>
      </div>
      <?php } ?>
    <?php } ?>


    <?php /* 2-COLUMN TEXT BLOCK */
    if( get_row_layout() == 'two_column_textblock' ) { 
      $textLeft = get_sub_field('text_left');
      $textRight = get_sub_field('text_right');
      $textcolor = get_sub_field('textcolor');
      $bgcolor = get_sub_field('bgcolor'); 
      $custom_class = get_sub_field('custom_class'); 
      $bclass = ( $textLeft && $textRight ) ? 'half':'full';
      $hasVerticalDivider = (get_sub_field('vertical_divider')) ? true : false; 
      if($hasVerticalDivider) {
        $bclass .= ' hasVerticalDivider';
      }
      $bclass .= ($custom_class) ? ' '.$custom_class:'';
      ?>
      <div class="repeatable-twocol-text-block repeatable-twocol-text-block-<?php echo $i?>  repeatable <?php echo $bclass?>">
        <div class="wrapper" style="background:<?php echo $bgcolor?>;color:<?php echo $textcolor?>">
          <div class="flexwrap">
            <?php if($textLeft) { ?>
              <div class="textLeft fxcol"><?php echo anti_email_spam($textLeft)?></div>
            <?php } ?>
            <?php if($textRight) { ?>
              <div class="textRight fxcol"><?php echo anti_email_spam($textRight)?></div>
            <?php } ?>
          </div>
        </div>
      </div>
    <?php } ?>


    <?php if( get_row_layout() == 'flexible_blocks' ) { 
      $flexible = get_sub_field('flexible');
      $textcolor = get_sub_field('textcolor');
      $bgcolor = get_sub_field('bgcolor'); 
      if($flexible) { ?>
      <style>
        .repeatable-flexible-blocks<?php echo $i?> ul.check li:before {
          border-bottom-color: #3A5788;
          border-right-color: #3A5788;
        }
      </style>
      <div class="repeatable-flexible-blocks repeatable-flexible-blocks<?php echo $i?> repeatable">
        <div class="wrapper" style="background:<?php echo $bgcolor?>;color:<?php echo $textcolor?>;">
        <?php foreach($flexible as $a) { 
          $layout = $a['acf_fc_layout'];
          $fullwidth = (isset($a['fullwidth_content']) && $a['fullwidth_content']) ? $a['fullwidth_content'] : '';
          $leftcol = (isset($a['leftcol']) && $a['leftcol']) ? $a['leftcol'] : '';
          $rightcol = (isset($a['rightcol']) && $a['rightcol']) ? $a['rightcol'] : '';
          if($layout=='fullwidth' && $fullwidth) { ?>
          <div class="fullwidth"><?php echo $fullwidth; ?></div>
          <?php } ?>

          <?php if($layout=='twocolumn' && ($leftcol || $rightcol) ) { 
            $colClass = ($leftcol && $rightcol) ? 'twocol' : 'onecol';
          ?>
          <div class="twocolumn <?php echo $colClass?>">
            <div class="flexwrap">
              <?php if($leftcol) { ?>
                <div class="leftcol fxcol"><?php echo anti_email_spam($leftcol)?></div>
              <?php } ?>

              <?php if($rightcol) { ?>
                <div class="rightcol fxcol"><?php echo anti_email_spam($rightcol)?></div>
              <?php } ?>
            </div>
          </div>
          <?php } ?>

        <?php } ?>
        </div>
      </div>
      <?php } ?>
    <?php } ?>
  <?php $i++; endwhile; ?>
<?php } ?>