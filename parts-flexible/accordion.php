<?php /* Accordion Layout */
if( get_row_layout() == 'accordion' ) { 
  $panels = get_sub_field('panels'); ?>
  <div data-group="<?php echo get_row_layout() ?>" id="repeatable-<?php echo get_row_layout() ?>--<?php echo $i ?>" class="repeatable-accordion repeatable">
    <div class="wrapper" >
      <div class="accordions-section">

        <div class="accordions">
          <?php $i=1; foreach( $panels as $pan ) { ?>
            <?php if ( $pan['panel_title'] && $pan['expanded_text'] ) { ?>
            <div class="accordion acc-item<?php echo ($i==1) ? ' active first':'' ?>">
              <div class="title"><a href="javascript:void(0)"><?php echo $pan['panel_title']; ?></a></div>
              <div class="text"><?php echo $pan['expanded_text']; ?></div>
            </div> 
            <?php $i++; } ?>
          <?php } ?>
          </div>
          
      </div>
    </div>
  </div>
<?php } ?>