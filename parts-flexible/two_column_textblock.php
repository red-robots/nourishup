<?php if( get_row_layout() == 'two_column_textblock' ) { 
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
  <div data-group="<?php echo get_row_layout() ?>" id="repeatable-<?php echo get_row_layout() ?>--<?php echo $i ?>" class="repeatable-twocol-text-block repeatable-twocol-text-block-<?php echo $i?>  repeatable <?php echo $bclass?>">
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