<?php if( get_row_layout() == 'flexible_blocks' ) { 
  $flexible = get_sub_field('flexible');
  $textcolor = get_sub_field('textcolor');
  $bgcolor = get_sub_field('bgcolor'); 
  if($flexible) { ?>
  <div data-group="<?php echo get_row_layout() ?>" id="repeatable-<?php echo get_row_layout() ?>--<?php echo $i ?>" class="repeatable-flexible-blocks repeatable-flexible-blocks<?php echo $i?> repeatable">
    <style>
      .repeatable-flexible-blocks<?php echo $i?> ul.check li:before {
        border-bottom-color: #3A5788;
        border-right-color: #3A5788;
      }
    </style>
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