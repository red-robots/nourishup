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

$date = new DateTime();
$date->setTimezone(new DateTimeZone('America/Detroit'));
$fdate = $date->format('Y-m-d H:i:s');
define('WP_CURRENT_TIME', $fdate);
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



// add_action( 'save_post', 'save_post_with_acf');
// function save_post_with_acf( $post_id) {
// 	global $wpdb;
// 	$posttype = get_post_type($post_id);
// 	if ( $posttype=='post' ) {
// 		$val = get_field('featured_story', $post_id);
// 		if($val) {
// 			$query = "SELECT meta.meta_id, meta.post_id FROM ".$wpdb->prefix."postmeta meta WHERE meta.meta_key LIKE '%featured_story%' AND meta.post_id!=" . $post_id;
// 			$result = $wpdb->get_results($query);
// 			if($result) {
// 				foreach($result as $row) {
// 					if($post_id!=$row->post_id) {
// 						delete_post_meta($row->post_id, 'featured_story');
// 						delete_post_meta($row->post_id, '_featured_story');
// 					}
// 				}
// 			}
// 		}
// 	}
// }


add_shortcode( 'featured_story', 'featured_story_func' );
function featured_story_func( $atts ) {
  global $wpdb;
  $query = "SELECT p.*, pm.post_id, pm.meta_id FROM ".$wpdb->prefix."posts p, ".$wpdb->prefix."postmeta pm WHERE p.ID=pm.post_id AND p.post_status='publish' AND p.post_type='post' AND pm.meta_key='featured_story' AND pm.meta_value='1'";
  $result = $wpdb->get_row($query);
  $output = '';
//   print_r($result);

  if($result) {
    $postid = $result->post_id;
    ob_start();
    include( locate_template('parts/featured_story.php') ); 
    $output = ob_get_contents();
    ob_end_clean();
  }
  return $output;
}


add_shortcode( 'recent_news', 'recent_news_func' );
function recent_news_func( $atts ) {
  $a = shortcode_atts( array(
      'show' => 3,
  ), $atts );
  $perpage = (isset($a['show']) && $a['show']) ? $a['show'] : 3;
  $output = '';
  ob_start();
  include( locate_template('parts/recent-news-home.php') ); 
  $output = ob_get_contents();
  ob_end_clean();
  return $output;
}

add_shortcode( 'newsfeeds', 'newsfeeds_func' );
function newsfeeds_func( $atts ) {
  $a = shortcode_atts( array(
    'perpage' => 3,
  ), $atts );
  $perpage = (isset($a['perpage']) && $a['perpage']) ? $a['perpage'] : 3;
  $output = '';
  ob_start();
  include( locate_template('parts/news-feeds.php') ); 
  $output = ob_get_contents();
  ob_end_clean();
  return $output;
}

add_shortcode( 'events-feeds', 'events_feeds_func' );
function events_feeds_func( $atts ) {
  $a = shortcode_atts( array(
    'perpage' => 3,
  ), $atts );
  $perpage = (isset($a['perpage']) && $a['perpage']) ? $a['perpage'] : 3;
  $output = '';
  ob_start();
  include( locate_template('parts/events-feeds.php') ); 
  $output = ob_get_contents();
  ob_end_clean();
  return $output;
}


add_shortcode( 'eventsfeeds', 'eventsfeeds_func' );
function eventsfeeds_func( $atts ) {
  $a = shortcode_atts( array(
    'perpage' => 3,
  ), $atts );
  $perpage = (isset($a['perpage']) && $a['perpage']) ? $a['perpage'] : 3;
  $output = '';
  ob_start();
  include( locate_template('parts/events-feeds.php') ); 
  $output = ob_get_contents();
  ob_end_clean();
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

    $exclude_posttypes = array('team','events');
    $ptype = get_post_type($_GET['post']);
  
    if( ! ( is_admin() && !empty( $_GET['post'] ) ) )
      return $can_edit;
  
    if( ea_disable_editor( $_GET['post'] ) )
      $can_edit = false;
    
    if( in_array($ptype, $exclude_posttypes) )
      $can_edit = false;

    // if( get_post_type($_GET['post'])=='team' )
    //   $can_edit = false;
  
    // if( $_GET['post']==15 ) /* Contact page */
    //   $can_edit = false;
  
    return $can_edit;
  
  }
  add_filter( 'gutenberg_can_edit_post_type', 'ea_disable_gutenberg', 10, 2 );
  add_filter( 'use_block_editor_for_post_type', 'ea_disable_gutenberg', 10, 2 );

  add_filter('use_block_editor_for_post_type', 'prefix_disable_gutenberg', 10, 2);
  function prefix_disable_gutenberg($current_status, $post_type)
  {
      // Use your post type key instead of 'product'
      if ($post_type === 'events') return false;
      return $current_status;
  }



// add new buttons
add_filter( 'mce_buttons', 'myplugin_register_buttons' );

function myplugin_register_buttons( $buttons ) {
	array_push( $buttons, '|', 'custom_class');

	return $buttons;
}
 
// Load the TinyMCE plugin : editor_plugin.js (wp2.5)
add_filter( 'mce_external_plugins', 'myplugin_register_tinymce_javascript' );

function myplugin_register_tinymce_javascript( $plugin_array ) {

   $plugin_array['checklistbutton'] = get_stylesheet_directory_uri() . '/assets/js/custom/custom-tinymce.js';

   return $plugin_array;
}



function getParagraph($content, $num=0) {
    $post_content = apply_filters('the_content', $content);
    $post_content = str_replace('</p>', '', $post_content);
    $paras = explode('<p>', $post_content);
    array_shift($paras);
    $output = '';
    if($num) {
        for($i=0; $i<$num; $i++) {
            $output .= '<p>'. $paras[$i] .'</p>';
        }
    }
    return $output; 
}

add_action('rest_api_init', function () {
    register_rest_route( 'myquery/v1', 'latest-posts',array(
        'methods'  => 'GET',
        'callback' => 'get_latest_posts'
    ));
});
function get_latest_posts($request) {
    $postType = $request['ptype'];
    $posts_per_page = -1;
    $args = array(
        'posts_per_page'  => $posts_per_page,
        'post_type'       => $postType,
        'orderby'         => 'date',
        'order'           => 'desc',
        'post_status'     => 'publish'
    );
    
    if (empty($postType)) {
    return new WP_Error( 'post_type', 'No post type indicated', array('status' => 404) );
    }

    $posts = get_posts($args);
    $extractedImages = array();
    if($posts) {
        foreach($posts as $row) {
            $id = $row->ID;
            $imageUrl = get_the_post_thumbnail_url($id);
            $row->featured_image = $imageUrl;
            $content = $row->post_content;
            // $htmlDom = new DOMDocument;
            // $htmlDom->loadHTML($content);
            // $imageTags = $htmlDom->getElementsByTagName('img');
            // $extractedImages = array();
            // foreach($imageTags as $imageTag){
            //     $extractedImages[] = $imageTag->getAttribute('src');
            // }
            preg_match_all('~<img.*?src=["\']+(.*?)["\']+~', $content, $urls);
            $extractedImages = $urls[1];
            //$extractedImages[] = $urls;

        }
    }

    $res['count'] = ($posts) ? count($posts) : 0;
    $res['posts'] = $posts;

    $response = new WP_REST_Response($extractedImages);
    $response->set_status(200);

    return $response;
}

// if( isset($_GET['test']) && $_GET['test']='query' ) {
//     $upload =  wp_upload_dir();
//     $upload_abspath = $upload['basedir'];
//     $upload_url = $upload['baseurl'];
//     $temp_folder = $upload_abspath . '/allposts/'; 
//     if (!file_exists($temp_folder)) {
//         // mkdir($temp_folder, 0777, true);
//         mkdir($temp_folder, 0755, true);
//     }

//     // $json = file_get_contents('https://nourishup.test/wp-json/myquery/v1/latest-posts/?ptype=post');
//     // $object = json_decode($json);
//     // echo "<pre>";
//     // print_r($object);
//     // echo "</pre>";
//     //copy('http://www.google.co.in/intl/en_com/images/srpr/logo1w.png', '/tmp/file.png');

//     $url = 'https://loavesandfishes.org/wp-content/uploads/2023/12/Scrooge-300x300.png';
//     $fileName = basename($url);
//     $dir = $temp_folder . $baseName;
//     $parts = explode('wp-content/uploads/', $url);
//     if($parts && count($parts)>1) {
//         $path = $parts[1];
//         $folders = str_replace('/'.$fileName,'', $path);
//         $strings = explode('/', $folders);
//         $storage = $temp_folder . $folders;
//         if (!file_exists($storage)) {
//             mkdir($storage, 0755, true);
//         }
//         $tmp = $storage . '/' . $fileName;
//         if( copy($url, $tmp) ) {
//             echo "SUCCESS!";
//         }
//     }
   
// }   

if( isset($_GET['runquery']) && $_GET['runquery']='yes' ) {
    // $perpage = $_GET['perpage'];
    // $paged = $_GET['page'];
    // $url = 'https://loavesandfishes.org/wp-json/wp/v2/posts/?per_page='.$perpage.'&page='.$paged;
    $url = 'https://loavesandfishes.org/wp-json/wp/v2/posts/?per_page=100&page=4';
    //https://loavesandfishes.org/wp-json/wp/v2/posts/?per_page=100
    $json = file_get_contents($url);
    if($json) {
        $obj = json_decode($json);
        $extractedImages = array();
        $entries = array();
        $entries_test = array();

        $upload =  wp_upload_dir();
        $upload_abspath = $upload['basedir'];
        $upload_url = $upload['baseurl'];
        $temp_folder = $upload_abspath . '/allposts/'; 


        if( $json ) {
            $items = json_decode($json);
            foreach($items as $item) {
                $content = $item->content;
                $rendered = $content->rendered;
                preg_match_all('~<img.*?src=["\']+(.*?)["\']+~', $rendered, $urls);
                // $extractedImages[] = $urls[1];
                foreach($urls[1] as $img) {
                    $extractedImages[] = $img;
                }
                $guid = $item->guide;
                $arg = array(
                    'ID'=> $item->id,
                    'post_date'=>$item->date,
                    'post_date_gmt'=>$item->date_gmt,
                    'post_title'=>$item->title,
                    'post_content'=>$rendered,
                    'post_excerpt'=>$item->excerpt,
                    'post_author'=>$item->author,
                    'post_modified'=>$item->modified,
                    'post_modified_gmt'=>$item->modified_gmt,
                    'post_type'=>$item->type,
                    'post_status'=>$item->status,
                    'post_name '=>$item->slug,
                    'guid'=>$item->guid,
                );
                $entries[] = $arg;
                $entries_test[] = $item->title;
                
            }

            
        }


        // if( $entries ) {
        //     $content = json_encode($entries);
        //     $dirPath = $temp_folder . 'posts.json';
        //     $fp = fopen($dirPath, "a");
        //     fwrite($fp, $content);
        //     fclose($fp);
        // }

        //Extract Images
    // if($extractedImages) {
    //     foreach($extractedImages as $imgUrl) {
    //         copyImage($imgUrl);
    //     }
    // }
    }

    
}



function copyImage($url) {
    $upload =  wp_upload_dir();
    $upload_abspath = $upload['basedir'];
    $upload_url = $upload['baseurl'];
    $temp_folder = $upload_abspath . '/allposts/'; 
    if (!file_exists($temp_folder)) {
        mkdir($temp_folder, 0755, true);
    }

    $fileName = basename($url);
    $parts = explode('wp-content/uploads/', $url);
    if($parts && count($parts)>1) {
        $path = $parts[1];
        $folders = str_replace('/'.$fileName,'', $path);
        $storage = $temp_folder . $folders;
        if (!file_exists($storage)) {
            mkdir($storage, 0755, true);
        }
        $tmp = $storage . '/' . $fileName;
        if( copy($url, $tmp) ) {
            return true;
        }
    }
}



// function get_events_list() {
// 	global $wpdb;
// 	$now = WP_CURRENT_TIME;
// 	$query = "SELECT p.* FROM ".$wpdb->prefix."posts p WHERE p.post_type='events' AND p.post_status='publish'";
// }


add_action('wp_footer', 'bellaworks_script_footer'); 
function bellaworks_script_footer() { 
  get_template_part('parts/content-popup');
}


function bella_acf_input_admin_footer() { ?>
<script type="text/javascript">
(function($) {
  acf.add_filter('color_picker_args', function( args, $field ){
    // do something to args
    args.palettes = ['#3D5588','#F26522','#81C674','#FEBC11','#FAF1DB','#32845C','#00B2CD']
    return args;
  });
})(jQuery); 
</script>
<?php
}
add_action('acf/input/admin_footer', 'bella_acf_input_admin_footer');

