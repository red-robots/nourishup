<?php /* Accordion Layout */
if( get_row_layout() == 'accordion' ) { 
  $panels = get_sub_field('panels'); 
  if($panels) { ?>
  <div data-group="<?php echo get_row_layout() ?>" id="repeatable-<?php echo get_row_layout() ?>--<?php echo $i ?>" class="repeatable-accordion repeatable">
    <div class="wrapper" >
      <div class="accordions-section">

        <div class="accordions">
          <?php $i=1; foreach( $panels as $pan ) { 
            $expanded_text = $pan['expanded_text'];
		        $listNumCol = ( isset($pan['list_number_columns']) && $pan['list_number_columns'] ) ? $pan['list_number_columns'] : 1; 
            $is_first = ($i==1) ? ' first':'';
            $aria_expanded = 'false';
            if (strpos($expanded_text, 'accordion-is-collapsed') !== false) { 
              //Do nothing
            } else { 
              if($i==1) {
                $is_first .= ' active';
                $aria_expanded = 'true';
              }
            }?>
            <?php if ( $pan['panel_title'] && $pan['expanded_text'] ) { ?>
            <div class="accordion acc-item<?php echo $is_first ?>">
              <div class="title"><a href="javascript:void(0)" aria-expanded="<?php echo $aria_expanded;?>"><?php echo $pan['panel_title']; ?></a></div>
              <div class="text list-colnum-<?php echo $listNumCol;?>"><?php echo $expanded_text; ?></div>
            </div> 
            <?php $i++; } ?>
          <?php } ?>
          </div>
          
      </div>
    </div>
  </div>
  <?php } ?>
<?php } ?>