<?php if( get_row_layout() == 'intro' ) { 
  $title = get_sub_field('title');
  $content = get_sub_field('content');
  $buttons = get_sub_field('buttons');
  if($title || $content) { ?>
  <div data-group="<?php echo get_row_layout() ?>" id="repeatable-<?php echo get_row_layout() ?>--<?php echo $i ?>" class="repeatable-intro repeatable">
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