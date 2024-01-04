<?php
$paged = ( get_query_var( 'pg' ) ) ? absint( get_query_var( 'pg' ) ) : 1;
$args = array(
  'posts_per_page'  => $perpage,
  'post_type'       => 'post',
  'orderby'         => 'date',
  'order'           => 'desc',
  'post_status'     => 'publish',
  'paged'			      => $paged
);
$news = new WP_Query($args);
if ( $news->have_posts() ) {  
  $rpcount = $news->found_posts;
  ?>
  <div class="newsfeeds-wrapper">
    <div class="news">
      <?php $i=1; while ( $news->have_posts() ) : $news->the_post();  
        $img = get_field('thumbnail_image');
        $imageUrl = ($img) ? $img['url'] : '';
        $imgAlt = ($img) ? $img['title'] : '';
        $content = get_the_content();
        $content = ($content) ? strip_tags(strip_shortcodes($content))  : '';
        $excerpt = ($content) ? shortenText( $content, 600, ".", "...") : "";
        ?>
        <article class="post-item">
          <div class="inside">
            <div class="textcol fxcol">
              <h2 class="post-title"><?php echo get_the_title()?></h2>
              <div class="excerpt"><?php echo $excerpt ?></div>
              <div class="readmore"><a href="<?php echo get_permalink() ?>" class="morelink">Read More</a></div>
            </div>

            <figure class="imagecol fxcol">
              <?php if($imageUrl) { ?>
                <a href="<?php echo get_permalink() ?>">
                  <img src="<?php echo $imageUrl?>" alt="<?php echo $imgAlt?>" class="post-image" />
                  <img src="<?php echo get_stylesheet_directory_uri()?>/assets/img/square.png" alt="" class="resizer" />
                </a>
              <?php } else { ?>
                <img src="<?php echo get_stylesheet_directory_uri()?>/assets/img/square.png" alt="" />
              <?php } ?>
            </figure>
          </div>
        </article>
      <?php $i++; endwhile; wp_reset_postdata(); ?>
    </div>

    <?php
    $total_pages = $news->max_num_pages;
    if ($total_pages > 1) { ?>
    <div id="pagination" class="pagination-wrapper clear">
      <?php
      $pagination = array(
          'base' => @add_query_arg('pg','%#%'),
          'format' => '?paged=%#%',
          'current' => $paged,
          'total' => $total_pages,
          'prev_text' => __( '&laquo;', 'red_partners' ),
          'next_text' => __( '&raquo;', 'red_partners' ),
          'type' => 'plain'
      );
      echo paginate_links($pagination);
      ?>
    </div>
    <?php } ?>
  </div>
<?php } ?>