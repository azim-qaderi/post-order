<?php
/**
 * Plugin Name: Posts Order
 * Author: Azim Qaderi
 * Author URI: 
 * Version: 1.0.1
 * Text Domain: post-order
 * Description: Defines custom post order to sections of the website
 */

if( !defined('ABSPATH') ) : exit(); endif;

/**
 * Define plugin constants
 */
define( 'PLUGIN_PATH', trailingslashit( plugin_dir_path(__FILE__) ) );
define( 'PLUGIN_URL', trailingslashit( plugins_url('/', __FILE__) ) );

/**
 *  Include database table
 */

require PLUGIN_PATH . '/inc/database/tables.php';
register_activation_hook( __FILE__, 'posts_order_install' );

/**
 * Include admin.php
 */
if( is_admin() ) {
    require_once PLUGIN_PATH . '/admin/admin.php';
}

/**
 * Include public.php 
 */
if( !is_admin() ) {
    require_once PLUGIN_PATH . '/public/public.php';
}