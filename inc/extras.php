<?php
/**
 * Custom functions that act independently of the theme templates.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package bellaworks
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
define('THEMEURI',get_template_directory_uri() . '/');

function bellaworks_body_classes( $classes ) {
    // Adds a class of group-blog to blogs with more than 1 published author.
   global $post;
    if ( is_multi_author() ) {
        $classes[] = 'group-blog';
    }

    // Adds a class of hfeed to non-singular pages.
    if ( ! is_singular() ) {
        $classes[] = 'hfeed';
    }

    if ( is_front_page() || is_home() ) {
        $classes[] = 'homepage';
    } else {
        $classes[] = 'subpage';
    }
    if(is_page() && $post) {
      $classes[] = $post->post_name;
    }

    $browsers = ['is_iphone', 'is_chrome', 'is_safari', 'is_NS4', 'is_opera', 'is_macIE', 'is_winIE', 'is_gecko', 'is_lynx', 'is_IE', 'is_edge'];
    $classes[] = join(' ', array_filter($browsers, function ($browser) {
        return $GLOBALS[$browser];
    }));

    return $classes;
}
add_filter( 'body_class', 'bellaworks_body_classes' );


function add_query_vars_filter( $vars ) {
  $vars[] = "pg";
  return $vars;
}
add_filter( 'query_vars', 'add_query_vars_filter' );


function shortenText($string, $limit, $break=".", $pad="...") {
  // return with no change if string is shorter than $limit
  if(strlen($string) <= $limit) return $string;

  // is $break present between $limit and the end of the string?
  if(false !== ($breakpoint = strpos($string, $break, $limit))) {
    if($breakpoint < strlen($string) - 1) {
      $string = substr($string, 0, $breakpoint) . $pad;
    }
  }

  return $string;
}


add_action('admin_enqueue_scripts', 'bellaworks_admin_style');
function bellaworks_admin_style() {
  wp_enqueue_style('admin-dashicons', get_template_directory_uri().'/css/dashicons.min.css');
  wp_enqueue_style('admin-styles', get_template_directory_uri().'/css/admin.css');
}

function get_page_id_by_template($fileName) {
    $page_id = 0;
    if($fileName) {
        $pages = get_pages(array(
            'post_type' => 'page',
            'meta_key' => '_wp_page_template',
            'meta_value' => $fileName.'.php'
        ));

        if($pages) {
            $row = $pages[0];
            $page_id = $row->ID;
        }
    }
    return $page_id;
}

function string_cleaner($str) {
    if($str) {
        $str = str_replace(' ', '', $str); 
        $str = preg_replace('/\s+/', '', $str);
        $str = preg_replace('/[^A-Za-z0-9\-]/', '', $str);
        $str = strtolower($str);
        $str = trim($str);
        return $str;
    }
}

function format_phone_number($string) {
    if(empty($string)) return '';
    $append = '';
    if (strpos($string, '+') !== false) {
        $append = '+';
    }
    $string = preg_replace("/[^0-9]/", "", $string );
    $string = preg_replace('/\s+/', '', $string);
    return $append.$string;
}

function get_social_media() {
    $options = get_field("social_media_links","option");
    $icons = social_icons();
    $list = array();
    if($options) {
        foreach($options as $i=>$opt) {
            if( isset($opt['link']) && $opt['link'] ) {
                $url = $opt['link'];
                $parts = parse_url($url);
                $host = ( isset($parts['host']) && $parts['host'] ) ? $parts['host'] : '';
                if($host) {
                    foreach($icons as $type=>$icon) {
                        if (strpos($host, $type) !== false) {
                            $list[$i] = array('url'=>$url,'icon'=>$icon,'type'=>$type);
                        }
                    }
                }
            }
        }
    }

    return ($list) ? $list : '';
}

// function get_social_links() {
//     $social_types = social_icons();
//     $social = array();
//     foreach($social_types as $k=>$icon) {
//         if( $value = get_field($k,'option') ) {
//             $social[$k] = array('link'=>$value,'icon'=>$icon);
//         }
//     }
//     return $social;
// }

function social_icons() {
    $social_types = array(
        'facebook'  => 'fab fa-facebook-square',
        'twitter'   => 'fab fa-twitter',
        'linkedin'  => 'fab fa-linkedin',
        'instagram' => 'fab fa-instagram',
        'youtube'   => 'fab fa-youtube',
        'vimeo'  => 'fab fa-vimeo',
    );
    return $social_types;
}

function parse_external_url( $url = '', $internal_class = 'internal-link', $external_class = 'external-link') {

    $url = trim($url);

    // Abort if parameter URL is empty
    if( empty($url) ) {
        return false;
    }

    //$home_url = parse_url( $_SERVER['HTTP_HOST'] );     
    $home_url = parse_url( home_url() );  // Works for WordPress

    $target = '_self';
    $class = $internal_class;

    if( $url!='#' ) {
        if (filter_var($url, FILTER_VALIDATE_URL)) {

            $link_url = parse_url( $url );

            // Decide on target
            if( empty($link_url['host']) ) {
                // Is an internal link
                $target = '_self';
                $class = $internal_class;

            } elseif( $link_url['host'] == $home_url['host'] ) {
                // Is an internal link
                $target = '_self';
                $class = $internal_class;

            } else {
                // Is an external link
                $target = '_blank';
                $class = $external_class;
            }
        } 
    }

    // Return array
    $output = array(
        'class'     => $class,
        'target'    => $target,
        'url'       => $url
    );

    return $output;
}


/* Remove richtext editor on specific page */
function remove_pages_editor(){
    global $wpdb;
    $post_id = ( isset($_GET['post']) && $_GET['post'] ) ? $_GET['post'] : '';
    $disable_editor = array();
    if($post_id) {        
        $page_ids_disable = get_field("disable_editor_on_pages","option");
        if( $page_ids_disable && in_array($post_id,$page_ids_disable) ) {
            remove_post_type_support( 'page', 'editor' );
        }
    }
}   
add_action( 'init', 'remove_pages_editor' );


add_action('acf/save_post', 'my_acf_save_post');
function my_acf_save_post( $post_id ) {
  global $wpdb;
  $posttype = get_post_type($post_id);
  if($posttype=='stories') {
      //$values = get_fields( $post_id );
      $val = get_field('featured_story', $post_id);
      $query = "SELECT meta_id, post_id FROM ".$wpdb->prefix."postmeta WHERE meta_key='featured_story' AND meta_value='1'";
      $result = $wpdb->get_results($query);
      if($result) {
          foreach($result as $row) {
              $meta_postid = $row->post_id;
              if($meta_postid!=$post_id) {
                  //update_post_meta($meta_postid,'featured_story','','1');
                  delete_post_meta($meta_postid, 'featured_story');
              } 
          }
      }
  }
}


add_shortcode( 'featured_story', 'featured_story_func' );
function featured_story_func( $atts ) {
  global $wpdb;
  $query = "SELECT meta_id, post_id FROM ".$wpdb->prefix."postmeta WHERE meta_key='featured_story' AND meta_value='1'";
  $result = $wpdb->get_row($query);
  $output = '';
  if($result) {
      $postid = $result->post_id;
      if( $featured = get_post($postid) ) {            
          ob_start();
          include( locate_template('parts/featured_story.php') ); 
          $output = ob_get_contents();
          ob_end_clean();
      }
  }
  return $output;
}

// add_filter('wp_nav_menu_objects', 'my_wp_nav_menu_objects', 10, 2);
// function my_wp_nav_menu_objects( $items, $args ) {
//   foreach( $items as &$item ) {
//     $target = get_field('link_target', $item);
//     // if( $icon ) {
//     //   $item->title .= ' <i class="fa fa-'.$icon.'"></i>';  
//     // }
//   }
//   return $items;
// }

/* Disabling Gutenberg on certain templates */
function ea_disable_editor( $id = false ) {
    $excluded_templates = array(
      'page-repeatable.php'
    );
  
    // $excluded_ids = array(
    //   //get_option( 'page_on_front' ) /* Home page */
    // );
  
    if( empty( $id ) )
      return false;
  
    $id = intval( $id );
    $template = get_page_template_slug( $id );
  
    return in_array( $template, $excluded_templates );
  }
    
  /**
   * Disable Gutenberg by template
   *
   */
  function ea_disable_gutenberg( $can_edit, $post_type ) {
  
    if( ! ( is_admin() && !empty( $_GET['post'] ) ) )
      return $can_edit;
  
    if( ea_disable_editor( $_GET['post'] ) )
      $can_edit = false;
  
    if( get_post_type($_GET['post'])=='team' )
      $can_edit = false;
  
    // if( $_GET['post']==15 ) /* Contact page */
    //   $can_edit = false;
  
    return $can_edit;
  
  }
  add_filter( 'gutenberg_can_edit_post_type', 'ea_disable_gutenberg', 10, 2 );
  add_filter( 'use_block_editor_for_post_type', 'ea_disable_gutenberg', 10, 2 );

