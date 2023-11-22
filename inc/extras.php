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


/* Fixed Gravity Form Conflict Js */
add_filter("gform_init_scripts_footer", "init_scripts");
function init_scripts() {
    return true;
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

/* Disabling Gutenberg on certain templates */
function ea_disable_editor( $id = false ) {

    $excluded_templates = array(
      'page-repeatable.php',
      'Flexible-Content'
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
        'twitter'   => 'fa-brands fa-x-twitter',
        'linkedin'  => 'fab fa-linkedin',
        'instagram' => 'fab fa-instagram',
        'youtube'   => 'fab fa-youtube',
        'vimeo'     => 'fab fa-vimeo',
        'amazon'    => 'fa-brands fa-amazon'
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

function get_images_dir($fileName=null) {
    return get_bloginfo('template_url') . '/images/' . $fileName;
}

/* Remove richtext editor on specific page */
// function remove_pages_editor(){
//     global $wpdb;
//     $post_id = ( isset($_GET['post']) && $_GET['post'] ) ? $_GET['post'] : '';
//     $disable_editor = array();
//     if($post_id) {        
//         $page_ids_disable = get_field("disable_editor_on_pages","option");
//         if( $page_ids_disable && in_array($post_id,$page_ids_disable) ) {
//             remove_post_type_support( 'page', 'editor' );
//         }
//     }
// }   
// add_action( 'init', 'remove_pages_editor' );


/* Add richtext editor to category description */
// remove the html filtering
remove_filter( 'pre_term_description', 'wp_filter_kses' );
remove_filter( 'term_description', 'wp_kses_data' );


/* Remove description column in the wp table list */
// add_filter('manage_edit-divisions_columns', function ( $columns ) {
//   if( isset( $columns['description'] ) )
//       unset( $columns['description'] );   
//   return $columns;
// } );


/* ACF CUSTOM OPTIONS TABS */
// if( function_exists('acf_add_options_page') ) {
//   acf_add_options_sub_page(array(
//     'page_title'  => 'Divisions Options',
//     'menu_title'  => 'Divisions Options',
//     'parent_slug' => 'edit.php?post_type=team'
//   ));
//   acf_add_options_sub_page(array(
//     'page_title'  => 'Projects Options',
//     'menu_title'  => 'Options',
//     'parent_slug' => 'edit.php?post_type=project'
//   ));
// }

add_action('admin_enqueue_scripts', 'bellaworks_admin_style');
function bellaworks_admin_style() {
  wp_enqueue_style('admin-dashicons', get_template_directory_uri().'/css/dashicons.min.css');
  wp_enqueue_style('admin-styles', get_template_directory_uri().'/css/admin.css');
}

add_action( 'wp_head', 'custom__header__scripts', 100 );
function custom__header__scripts() {
  include_once( get_template_directory() . '/header-scripts.php' );
}

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

add_shortcode( 'footer_partners', 'footer_partners_func' );
function footer_partners_func( $atts ) {
    $out = '';
    $partners = get_field('partners','option');
    if($partners) { ob_start(); ?>
    <div class="FOOTER_PARTNERS">
        <div class="footerInner">
        <?php foreach($partners as $p) { 
            $id = $p['ID'];    
            $website = get_field('image_website_url',$id);
            if($website) { ?>
                <a href="<?php echo $website ?>" target="_blank"><img src="<?php echo $p['url']?>" alt="<?php echo $p['title']?>"></a>
            <?php } else {  ?>
                <img src="<?php echo $p['url']?>" alt="<?php echo $p['title']?>">
            <?php } ?>
        <?php } ?>
        </div>
    </div>
    <?php
    $out = ob_get_contents();
    ob_end_clean();
    }
    return $out;
}

add_shortcode( 'footer_navigation', 'footer_navigation_func' );
function footer_navigation_func( $atts ) {
    $out = '';
    $footerNav = get_field('footernav','option');
    if($footerNav) { ob_start(); ?>
    <div class="FOOTER_NAV">
        <div class="footerInner">
        <?php foreach($footerNav as $n) { 
            $e = $n['footlink'];
            $target = (isset($e['target']) && $e['target']) ? $e['target'] : '_self';
            $linkName = ($e['title']) ? $e['title'] : '';
            $link = ($e['url']) ? $e['url'] : '';
            if($linkName && $link) { ?>
                <a href="<?php echo $link?>" target="<?php echo $target?>"><?php echo $linkName?></a>
            <?php } ?>
        <?php } ?>
        </div>
    </div>
    <?php
    $out = ob_get_contents();
    ob_end_clean();
    }
    return $out;
}

add_shortcode( 'footer_contact', 'footer_contact_func' );
function footer_contact_func( $atts ) {
    // $atts = shortcode_atts( array(
	// 	'foo' => 'no foo',
	// 	'baz' => 'default baz'
	// ), $atts, 'bartag' );
    $address = get_field('office_address','option');
    $pobox = get_field('pobox','option');
    $phone = get_field('phone','option');
    $email = get_field('email','option');
    $mail = get_field('mailing_list_link','option');
    
    $output = '';
    $result = '';
    if($address) {
        $output .= '<span class="address"><i class="fa-solid fa-location-dot"></i> '.$address.'</span>';
    }
    if($pobox) {
        $output .= '<span class="pobox"><i class="fa-solid fa-envelope"></i> '.$pobox.'</span>';
    }
    if($phone) {
        $output .= '<span class="phone"><i class="fa-solid fa-phone"></i><a href="tel:'.$phone.'">'.$phone.'</a></span>';
    }
    if($email) {
        $output .= '<span class="email"><a href="mailto:'.antispambot($email,1).'">'.antispambot($email).'</a></span>';
    }
    if($mail) {
        $target = (isset($mail['target']) && $mail['target']) ? $mail['target'] : '_self';
        $LinkName = (isset($mail['title']) && $mail['title']) ? $mail['title'] : '';
        $url = (isset($mail['url']) && $mail['url']) ? $mail['url'] : '';
        if($LinkName && $url) {
            $output .= '<span class="maillist"><a href="href'.$url.'" target="'.$target.'">'.$LinkName.'</a></span>';
        }
    }

    if($output) {
        return '<div class="FOOTER_CONTACT_INFO"><div class="footerInner">'.$output.'</div></div>';
    }
}

add_shortcode( 'footer_social_media', 'footer_social_media_func' );
function footer_social_media_func( $atts ) {
    $social_media = get_social_media();
    $output = '';
    if ($social_media) { ob_start(); ?>
    <div class="FOOTER_SOCIAL_MEDIA">
        <div class="footerInner">
        <?php foreach ($social_media as $icon) { ?>
        <a href="<?php echo $icon['url'] ?>" target="_blank" arial-label="<?php echo ucwords($icon['type']) ?>"><i class="<?php echo $icon['icon'] ?>"></i></a> 
        <?php } ?>
        </div>
    </div> 
    <?php } 
        $output = ob_get_contents();
        ob_end_clean();
    return $output;
}

add_shortcode( 'footer_privacy_policy', 'footer_privacy_policy_func' );
function footer_privacy_policy_func( $atts ) {
    $privacy = get_field('privacy_link','option');
    $output = '';
    if($privacy) {
        $target = (isset($privacy['target']) && $privacy['target']) ? $privacy['target'] : '_self';
        $LinkName = (isset($privacy['title']) && $privacy['title']) ? $privacy['title'] : '';
        $url = (isset($privacy['url']) && $privacy['url']) ? $privacy['url'] : '';
        if($LinkName && $url) {
            $output .= '<span class="privacy-policy"><a href="href'.$url.'" target="'.$target.'">'.$LinkName.'</a></span>';
        }
    }
    $output .= '<span class="poweredby"><a href="https://bellaworksweb.com/" target="_blank">Site by Bellaworks</a></span>';
    if($output) {
        return '<div class="FOOTER_PRIVACY"><div class="footerInner">'.$output.'</div></div>';
    }
}


