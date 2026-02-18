<?php if( have_rows('repeatable_blocks', $post_id) ) { ?>
  <?php $i=1; while( have_rows('repeatable_blocks',$post_id) ): the_row(); ?>
    
    <?php
      include( locate_template('parts-flexible/banner.php') );
      include( locate_template('parts-flexible/intro.php') );
      include( locate_template('parts-flexible/multiple_columns.php') );
      include( locate_template('parts-flexible/fullwidth_image_text.php') );
      include( locate_template('parts-flexible/fullwidth_textblock.php') );
      include( locate_template('parts-flexible/two_column_textblock.php') );
      include( locate_template('parts-flexible/card_section.php') );
      include( locate_template('parts-flexible/accordion.php') );
      include( locate_template('parts-flexible/flexible_blocks.php') );
      include( locate_template('parts-flexible/gallery_grid_layout.php') );
    ?>

  <?php $i++; endwhile; ?>
<?php } ?>
<script>
jQuery(document).ready(function($){
  if( $('.repeatable').length ) {
    $('.repeatable').each(function(k){
      let ctr =  k+1;
      $(this).addClass('repeatable--'+ctr);
    });
  }
});

var handles = document.querySelectorAll('.acc-item .title');
for (var i = 0; i < handles.length; i++) {
  handles[i].addEventListener('click', function(e) {
    var textPanel = e.target.parentNode.nextElementSibling;
    var wrap = e.target.parentNode.parentNode;
    wrap.classList.toggle("active");
  });
}
</script>