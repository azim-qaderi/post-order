<?php 
/**
 * Init Styles & scripts
 *
 * @return void
 */
function post_order_public_styles_scripts() {

    wp_enqueue_style( 'post-order-public-style', PLUGIN_URL . 'public/css/public.css', '', rand());
    
}
add_action( 'wp_enqueue_scripts', 'post_order_public_styles_scripts' );



/**
 * Include Shortcodes
 */
require_once PLUGIN_PATH . '/inc/shortcodes/shortcodes.php';