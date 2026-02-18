<?php
if ( ! defined( 'ABSPATH' ) ) {
  exit; // Exit if accessed directly 
}

//https://sitedomain.com/wp-json/repeatable/v1/post/25
add_action('rest_api_init','bellaworks_register_rest_fields');
function bellaworks_register_rest_fields(){
  register_rest_route( 'repeatable/v1', '/post/(?P<id>\d+)', array(
    'methods' => 'GET',
    'callback' => 'get_repeatable_content'
  ) );
}

function get_repeatable_content(WP_REST_Request $request) {
  $post_id = $request['id'];
  //$param = $request['tmp'];
  $result = '';
  ob_start(); 
  include( locate_template('parts/repeatable-blocks.php') ); 
  $result = ob_get_contents();
  ob_end_clean();
  ob_flush();
  return ($result) ? trim($result) : '';
}
