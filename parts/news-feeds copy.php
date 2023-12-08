<?php
$taxonomy = 'category';
$posts_per_page = 10;
$paged = ( get_query_var( 'pg' ) ) ? absint( get_query_var( 'pg' ) ) : 1;
$args = array(
  'posts_per_page'  => $posts_per_page,
  'post_type'       => 'post',
  'orderby'         => 'date',
  'order'           => 'desc',
  'post_status'     => 'publish',
  'paged'           => $paged
);

if( isset($featuredPosts) && $featuredPosts ) {
  $args['post__not_in'] = $featuredPosts;
}

if( isset($_GET['term']) && $_GET['term'] > 0 ) {
  $args['tax_query'] = array(
      array(
        'taxonomy' => $taxonomy,
        'field' => 'term_id',
        'terms' => $_GET['term']
      )
    );
}

if( isset($_GET['src']) && $_GET['src'] ) {
  $args['s'] = $_GET['src'];
}

$allTerms = get_terms([
  'taxonomy' => $taxonomy,
  'hide_empty' => true,
]);

$recentposts = new WP_Query($args);
if ( $recentposts->have_posts() ) {  
  $rpcount = $recentposts->found_posts;
?>

<div class="recents-posts-block total-posts-<?php echo $rpcount ?>">
  <div class="wrapper">

    <div class="filter-form">
      <form action="<?php echo get_permalink(); ?>" method="get" id="filterPosts">
        <?php if ($allTerms ) { ?>
        <div class="input-group">
           <select name="term" placeholder="Filter" class="modern-select">
              <option></option>
              <?php foreach($allTerms as $term) { 
                $catID = $term->term_id;
                $catName = $term->name;
                $catSlug = $term->slug;
                ?>
                <option value="<?php echo $catID ?>"><?php echo ucwords($catName) ?></option>
              <?php } ?>
           </select>
        </div>
        <?php } ?>

        <div class="input-group search-field">
          <input type="text" name="src" value="" placeholder="Search">
        </div>

        <div class="filter-form-reset" style="display:none">
          <a href="javascript:void(0)" class="reset-button">Reset</a>
        </div>
      </form>
    </div>

    <div class="recent-posts-content">
      <div id="recent-posts-page-<?php echo $paged ?>" class="recent-posts-inner">
        <?php $i=1; while ( $recentposts->have_posts() ) : $recentposts->the_post();  ?>
          <?php
            $resizerImage = get_template_directory_uri() . '/images/resizer-blog.png';    
            $postId   = get_the_ID();
            $postTitle = get_the_title();
            $content = get_the_content();
            $thumbId = get_post_thumbnail_id($postId);
            $imageSrc = wp_get_attachment_image_src($thumbId,'medium_large');
            $hasImage = ($imageSrc) ? 'has-image':'no-image';
            $imageStyle = ($imageSrc) ? ' style="background-image:url('.$imageSrc[0].')"':'';
            
            $post_terms = get_the_terms($postId,$taxonomy);
            $categoryName = '';
            $categoryLink = '';
            if( $post_terms ) {
              $singleCat = $post_terms[0];
              $categoryName = $singleCat->name;
              $categoryLink = get_term_link($singleCat,$taxonomy);
            }
            $post_date_text = get_the_date('m/d/Y',$postId);
          ?>
          <article class="postInfo animated fadeIn" id="post-<?php the_ID() ?>">
            <div class="inner <?php echo $hasImage?>">
            
              <figure class="imageCol">
                <div<?php echo $imageStyle?>>
                  <img src="<?php echo $resizerImage?>" alt="" />
                </div>
              </figure>

              <div class="textCol">
                <div class="post-meta">
                <?php if ($categoryName) { ?>
                  <a href="<?php echo $categoryLink ?>"><?php echo ucwords($categoryName) ?></a> | 
                <?php } ?>
                  <span class="post-date"><?php echo $post_date_text ?></span>
                </div>
                <h3 class="postTitle"><a href="<?php echo get_permalink(); ?>"><?php echo $postTitle?></a></h3>
                <?php if($content) { ?>
                <div class="text">
                  <?php echo shortenText( strip_tags($content), 150, ' ', '...'); ?>
                </div>
                <?php } ?>
              </div>

              <div class="readmore">
                <a href="<?php echo get_permalink() ?>">Read More</a>
              </div>
              
            </div>
          </article> 
        <?php $i++; endwhile; wp_reset_postdata(); ?>
      </div>
    </div>

    <?php  
    $total_pages = $recentposts->max_num_pages;
    if( $rpcount > $posts_per_page ) { ?>
    <div class="morelink">
      <a href="#" class="more-btn">View All Posts</a>
    </div>
    <?php } ?>

  </div>
</div>
<?php } ?>