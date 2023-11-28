<?php get_header(); ?>
<div id="primary">
  <main class="main-content">
  <?php while ( have_posts() ) : the_post(); ?>
    <?php the_content(); ?>
  <?php endwhile; ?>
  </main>
</div>
<?php
get_footer();