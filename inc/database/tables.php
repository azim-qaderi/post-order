<?php
function posts_order_install() {
	global $wpdb;
	global $posts_order_db_version;
	$posts_order_db_version = '1.0';

	$table_name = $wpdb->prefix . 'posts_order';
	
	$charset_collate = $wpdb->get_charset_collate();

	$sql = "CREATE TABLE $table_name (
		id mediumint(9) NOT NULL AUTO_INCREMENT,
		section_title varchar(100) NOT NULL,
		post_section tinytext NOT NULL,
		number_of_posts mediumint(9) NOT NULL,
        post_order longtext NOT NULL,
        time datetime NOT NULL,
		PRIMARY KEY  (id)
	) $charset_collate;";

	require_once ABSPATH . 'wp-admin/includes/upgrade.php';
	dbDelta( $sql );

	add_option( 'posts_order_install', $posts_order_db_version );
}