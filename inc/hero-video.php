<?php
/**
 * Hero video enhancements for core Cover blocks that use a video background.
 *
 * 1. Poster image
 *    Set a Featured Image on the video attachment (Media Library > edit the
 *    video > Featured Image). It is output as the <video poster> so the hero
 *    paints immediately and gives the browser an LCP candidate.
 *
 * 2. Mobile source
 *    Upload a second, smaller encode with the same filename plus "-mobile"
 *    (e.g. hero.mp4 and hero-mobile.mp4). Viewports up to 768px swap to it
 *    before the desktop file starts downloading.
 *
 * 3. Reduced motion
 *    Visitors with prefers-reduced-motion get the poster instead of autoplay.
 */

if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Find a "-mobile" companion for a video attachment. Cached for 12 hours.
 */
function bellaworks_hero_video_mobile_url( $video_id ) {
  $video_id = (int) $video_id;
  if ( ! $video_id ) return '';

  $cache_key = 'bw_hero_mobile_' . $video_id;
  $cached    = get_transient( $cache_key );
  if ( false !== $cached ) return $cached;

  $url  = '';
  $file = get_post_meta( $video_id, '_wp_attached_file', true ); // e.g. 2026/09/hero.mp4
  if ( $file ) {
    $info        = pathinfo( $file );
    $mobile_file = ( '.' === $info['dirname'] ? '' : $info['dirname'] . '/' )
                 . $info['filename'] . '-mobile.' . $info['extension'];
    global $wpdb;
    $mobile_id = $wpdb->get_var( $wpdb->prepare(
      "SELECT post_id FROM {$wpdb->postmeta} WHERE meta_key = '_wp_attached_file' AND meta_value = %s LIMIT 1",
      $mobile_file
    ) );
    if ( $mobile_id ) {
      $url = (string) wp_get_attachment_url( (int) $mobile_id );
    }
  }

  set_transient( $cache_key, $url, 12 * HOUR_IN_SECONDS );
  return $url;
}

/**
 * Clear the mobile lookup cache whenever media is added or removed.
 */
function bellaworks_hero_video_flush_cache() {
  global $wpdb;
  $wpdb->query( "DELETE FROM {$wpdb->options} WHERE option_name LIKE '_transient_bw_hero_mobile_%' OR option_name LIKE '_transient_timeout_bw_hero_mobile_%'" );
}
add_action( 'add_attachment', 'bellaworks_hero_video_flush_cache' );
add_action( 'delete_attachment', 'bellaworks_hero_video_flush_cache' );

/**
 * Add poster, mobile source and reduced-motion handling to Cover block videos.
 */
function bellaworks_hero_video_cover_block( $block_content, $block ) {
  if ( empty( $block['attrs']['backgroundType'] ) || 'video' !== $block['attrs']['backgroundType'] ) {
    return $block_content;
  }
  $video_id = ! empty( $block['attrs']['id'] ) ? (int) $block['attrs']['id'] : 0;
  if ( ! $video_id || ! class_exists( 'WP_HTML_Tag_Processor' ) ) {
    return $block_content;
  }

  $processor = new WP_HTML_Tag_Processor( $block_content );
  if ( ! $processor->next_tag( array( 'tag_name' => 'video', 'class_name' => 'wp-block-cover__video-background' ) ) ) {
    return $block_content;
  }

  $poster_id = get_post_thumbnail_id( $video_id );
  if ( $poster_id ) {
    $poster = wp_get_attachment_image_url( $poster_id, 'full' );
    if ( $poster ) {
      $processor->set_attribute( 'poster', esc_url( $poster ) );
    }
  }

  $mobile = bellaworks_hero_video_mobile_url( $video_id );
  if ( $mobile ) {
    $processor->set_attribute( 'data-mobile-src', esc_url( $mobile ) );
  }

  if ( null === $processor->get_attribute( 'playsinline' ) ) {
    $processor->set_attribute( 'playsinline', true );
  }

  $html = $processor->get_updated_html();

  // Runs the moment the parser reaches it, before the desktop file is committed to.
  $script = '<script>(function(){var s=document.currentScript,v=s&&s.previousElementSibling;if(!v||v.tagName!=="VIDEO")return;'
          . 'var m=v.getAttribute("data-mobile-src");if(m&&window.matchMedia("(max-width: 768px)").matches){v.setAttribute("src",m);v.load();}'
          . 'if(window.matchMedia("(prefers-reduced-motion: reduce)").matches){v.removeAttribute("autoplay");v.pause();}})();</script>';

  $pos = strpos( $html, '</video>' );
  if ( false !== $pos ) {
    $html = substr_replace( $html, '</video>' . $script, $pos, strlen( '</video>' ) );
  }

  return $html;
}
add_filter( 'render_block_core/cover', 'bellaworks_hero_video_cover_block', 10, 2 );
