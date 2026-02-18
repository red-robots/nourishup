<?php
$announcement = get_field('announcement_bar','option');
$visibility = get_field('announcement_bar_visibility','option');
if($visibility=='on') { ?>
<div id="announcementbar" class="announcement show">
  <div class="announcementInner">
    <div class="announcementText"><?php echo $announcement ?></div>
    <a href="javascript:void(0)" role="button" id="announcementBarClose"><span class="sr">Close</span></a>
  </div>
</div>
<?php } ?>