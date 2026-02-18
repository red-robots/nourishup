<?php if( get_row_layout() == 'gallery_grid_layout' ) { 
  $intro = get_sub_field('intro');
  $images = get_sub_field('gallery');
  $numcol = get_sub_field('numcol');
  if($intro || $images) { ?>
  <div data-group="<?php echo get_row_layout() ?>" id="repeatable-<?php echo get_row_layout() ?>--<?php echo $i ?>" class="repeatable repeatable-<?php echo get_row_layout() ?>">
    <div class="wrapper">
      <?php if ($intro) { ?>
      <div class="section-intro">
        <?php echo anti_email_spam($intro)?>
      </div>
      <?php } ?>
      <?php if ($images) { ?>
      <div class="section-gallery">
        <div class="items count-<?php echo $numcol ?>">
          <?php foreach ($images as $info) { 
            $img = $info['image'];
            $title = $info['title'];
            $description = $info['description'];
            $link = $info['link'];
            $target = (isset($link['target']) && $link['target']) ? ' target="'.$link['target'].'"' : '';
            $imgLink = (isset($link['url']) && $link['url']) ? $link['url'] : '';
            $imgText = (isset($link['title']) && $link['title']) ? $link['title'] : '';
            if($img) { ?>
            <figure class="item">
              <div class="inside">
                <?php if ($imgLink) { ?>
                <a class="image-link" href="<?php echo $imgLink ?>"<?php echo $target ?>>
                  <div class="img">
                    <img src="<?php echo $img['url'] ?>" alt="<?php echo $img['title'] ?>" />
                  </div>
                  <?php if ($title || $description) { ?>
                    <?php if ($title) { ?>
                    <div class="title"><?php echo $title ?></div>
                    <?php } ?>
                    <?php if ($description) { ?>
                    <div class="text"><?php echo anti_email_spam($description)?></div>
                    <?php } ?>
                  <?php } ?>
                </a>  
                <?php } else { ?>
                  <div class="img">
                    <img src="<?php echo $img['url'] ?>" alt="<?php echo $img['title'] ?>" />
                  </div>
                  <?php if ($title || $description) { ?>
                    <?php if ($title) { ?>
                    <div class="title"><?php echo $title ?></div>
                    <?php } ?>
                    <?php if ($description) { ?>
                    <div class="text"><?php echo anti_email_spam($description)?></div>
                    <?php } ?>
                  <?php } ?>
                <?php } ?>
              </div>    
            </figure>
            <?php } ?>
          <?php } ?>
        </div>
      </div>
      <?php } ?>
    </div>
  </div>
  <?php } ?>
<?php } ?>