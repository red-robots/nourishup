<?php /* Flippible Card Layout */
if( get_row_layout() == 'card_section' ) { 
$cards = get_sub_field('cards'); ?>
<div data-group="<?php echo get_row_layout() ?>" id="repeatable-<?php echo get_row_layout() ?>--<?php echo $i ?>" class="repeatable-card-layout  repeatable ">
  <div class="wrapper" >
    <div class="flexwrap-cards">
      <?php foreach( $cards as $cs ) { 
        // $front_image = $cs['front_image']['sizes']['medium'];
        $front_image = $cs['front_image']['url'];
        $hover_text = $cs['hover_text'];
        ?>
        <div class="card">
          <div class="card-hover">
            <?php echo $hover_text; ?>
          </div>
          <img src="<?php echo $front_image; ?>">
        </div>
      <?php } ?>
    </div>
  </div>
</div>
<?php } ?>