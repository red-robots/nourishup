<?php if( get_row_layout() == 'fullwidth_textblock' ) { 
  $text_content = get_sub_field('text_content');
  $bgcolor = get_sub_field('section_bgcolor');
  $bgcolor = ($bgcolor) ? $bgcolor : '#32845c';
  $textcolor = get_sub_field('textcolor');
  $textcolor = ($textcolor) ? $textcolor : '#FFF';
  $buttons = get_sub_field('buttons');
  if($text_content) { ?>
  <div data-group="<?php echo get_row_layout() ?>" id="repeatable-<?php echo get_row_layout() ?>--<?php echo $i ?>" class="repeatable-fullwidth-text-block repeatable-fullwidth-text-block-<?php echo $i?>  repeatable">
    <style>
      .repeatable-fullwidth-text-block-<?php echo $i?> a.link-arrow {
        color:<?php echo $textcolor?>;
        border-bottom-color:<?php echo $textcolor?>;
      }
      .repeatable-fullwidth-text-block-<?php echo $i?> a.link-arrow:after {
        border-left-color:<?php echo $textcolor?>;
      }
    </style>
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