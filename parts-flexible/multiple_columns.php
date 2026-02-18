<?php if( get_row_layout() == 'multiple_columns' ) { 
  $columns = get_sub_field('columns');
  if( have_rows('columns') ) { ?>
  <div data-group="<?php echo get_row_layout() ?>" id="repeatable-<?php echo get_row_layout() ?>--<?php echo $i ?>" class="repeatable-columns repeatable">
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