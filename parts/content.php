<?php
/**
 * Template part for displaying posts.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package bellaworks
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<?php
			if ( is_single() ) {
				the_title( '<h1 class="entry-title">', '</h1>' );
			} else {
				the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
			}

		if ( 'post' === get_post_type() ) : ?>
		<div class="entry-meta">
			<?php bellaworks_posted_on(); ?>
		</div><!-- .entry-meta -->
		<?php
		endif; ?>
	</header><!-- .entry-header -->

	<div class="entry-content post-info">
    <?php 
      $content = get_the_content();
      if( get_field('intro') ) {
        $content = get_field('intro');
      } else if ( get_field('intro_content') ) {
        $content = get_field('intro_content'); 
      }

      if( $content ) {
        $content = strip_tags($content);
        $content = strip_shortcodes($content);
        echo shortenText($content,300,' ','...');
      }

			wp_link_pages( array(
				'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'bellaworks' ),
				'after'  => '</div>',
			) );
		?>

    <?php if ( is_search() && ( get_the_title() || $content ) ) { ?>
    <div class="buttondiv">
      <a href="<?php echo get_permalink() ?>" class="button">Read More &raquo;</a>
    </div>  
    <?php } ?>
	</div><!-- .entry-content -->

</article><!-- #post-## -->
