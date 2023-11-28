<?php
$footblock = get_field('footer_feature_block','option');
$feature_content = ( isset($footblock['feature_content']) && $footblock['feature_content'] ) ? $footblock['feature_content'] : '';
$fbutton = ( isset($footblock['feature_button']) && $footblock['feature_button'] ) ? $footblock['feature_button'] : '';
$fbTarget = ( isset($fbutton['target']) && $fbutton['target'] ) ? $fbutton['target'] : '_self';
$fbLink = ( isset($fbutton['url']) && $fbutton['url'] ) ? $fbutton['url'] : '';
$fbTitle = ( isset($fbutton['title']) && $fbutton['title'] ) ? $fbutton['title'] : '';

if($feature_content) { ?>
<div class="footerTextBlock">
  <div class="wrapper">
    <div class="flexwrap">
    <?php if ($feature_content) { ?>
      <div class="textwrap"><?php echo $feature_content ?></div>
    <?php } ?>
    <?php if ($fbTitle && $fbLink) { ?>
      <div class="buttonwrap"><a href="<?php echo $fbLink ?>" target="<?php echo $fbTarget ?>"><?php echo $fbTitle ?></a></div>
    <?php } ?>
    </div>
  </div>
</div>
<?php } ?>