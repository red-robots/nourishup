<?php if( $popup_content = get_field('popup_content','option') ) { ?>
  <div id="poupContainer" class="popUpWrapper">
    <div class="popupContent animated fadeIn">
      <a href="javascript:void(0)" id="popupClose"><span class="sr">Close</span></a>
      <div class="popupText">
        <?php echo anti_email_spam($popup_content); ?>
      </div>
    </div>
  </div>
<?php } ?>