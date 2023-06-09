<?php

function get_posts_info() {
	global $wpdb;
	$keyword = '%' . sanitize_text_field( $_POST['keyword'] ) . '%';
    $lang = sanitize_text_field( $_POST['lang'] );

    $results = $wpdb->get_results(
        $wpdb->prepare(
           "SELECT ID, post_title FROM {$wpdb->prefix}posts
           JOIN {$wpdb->prefix}icl_translations ON element_id = ID
           WHERE post_title LIKE '%s' AND language_code = '%s' AND post_status = 'publish'",
           $keyword,
           $lang
        ), ARRAY_A
    );
    
    echo json_encode($results);

    wp_die();
}

add_action( 'wp_ajax_get_posts_info', 'get_posts_info' );