<?php
/**
 * Enqueue scripts and styles.
 */
function bellaworks_scripts() {
  wp_enqueue_style( 'swiper-style', 'https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.css' );
  wp_enqueue_style('bellaworks-style', get_stylesheet_directory_uri() .'/style.min.css', array(), '2.7' );  

  wp_deregister_script('jquery');
  wp_register_script('jquery', get_stylesheet_directory_uri() . '/assets/js/jquery.min.js', false, '3.6.3', false);
  wp_enqueue_script('jquery');

  wp_enqueue_script( 
    'jquery-migrate','https://code.jquery.com/jquery-migrate-1.4.1.min.js', 
    array(), '20200713', 
    false 
  );
  
  wp_enqueue_script( 
    'bellaworks-waypoint', 
    get_template_directory_uri() . '/assets/js/vendor.min.js', 
    array(), '4.0.1', true 
  );

  wp_enqueue_script( 
    'bellaworks-custom', 
    get_template_directory_uri() . '/assets/js/custom.min.js', 
    array(), '20230808', true 
  );

	wp_localize_script( 'bellaworks-custom', 'frontajax', array(
		'ajaxurl' => admin_url( 'admin-ajax.php' )
	));

	
	wp_enqueue_script( 
		'font-awesome', 
		'https://use.fontawesome.com/8f931eabc1.js', 
		array(), '20180424', 
		true 
	);

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'bellaworks_scripts' );




