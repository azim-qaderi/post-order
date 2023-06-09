<?php

/**
 * Get Post data with a shortcode
 * @arg = post_section
 */

function date_now_format( $post_id ){
    
    $post = $post_id;
		
    $time_now  = current_time( 'timestamp' );
    $post_time = get_the_time( 'U', $post ) ;
    $since = sprintf( esc_html__( '%s ago' , 'post-order' ), human_time_diff( $post_time, $time_now ) );			

                                
    if ( $post_time >= strtotime('-1 day') ) {

        $post_time = '<i class="fas fa-clock"></i><span class="date meta-item"><span>'.$since.'</span></span>';

    } else {

        $post_time = '<i class="far fa-calendar-alt"></i>' . get_the_date();

    }

    return wp_kses( $post_time , 'alltext_allow' );

}

function posts_order_get_posts_shortcode( $post_section ) {

    global $wpdb;
    $thumb_size = 'neeon-size3';
    $posts = $wpdb->get_results( $wpdb->prepare("SELECT post_order FROM {$wpdb->prefix}posts_order WHERE post_section = '%s'", $post_section['section'] ) );
    $post_data = unserialize( $posts[0]->post_order );

    $current_lang = apply_filters( 'wpml_current_language', NULL );

    $post_ids = array();
    $return_html = '';

    for ( $i = 0; $i < count($post_data[$current_lang]); $i++ ) {
        
        if ( $post_data[$current_lang][$i] != '' ){

            array_push( $post_ids, $post_data[$current_lang][$i] );

        } else {

            $postslist = get_posts( array(
                'post_type'         => 'post',
                'post_status'       => 'publish',
                'numberposts'       => 1,
                'order'             => 'DESC',
                'orderby'           => 'date',
                'post__not_in'      => $post_ids,
				'tax_query' => array(
					array(
						'taxonomy' => 'post_format',
						'field' => 'slug',
						'operator'	=> 'NOT IN',
						'terms' => array( 'post-format-video' )
					)
				),
                'suppress_filters'  => 0
            ) );

            if( $i > 0 && $i < 3 ) {
                $postslist = get_posts( array(
                    'post_type'         => 'post',
                    'post_status'       => 'publish',
                    'numberposts'       => 1,
                    'order'             => 'DESC',
                    'orderby'           => 'date',
                    'post__not_in'      => $post_ids,
                    'tax_query' => array(
                        array(
                            'taxonomy' => 'post_format',
                            'field' => 'slug',
                            'terms' => array( 'post-format-video' )
                        )
                    ),
                    'suppress_filters'  => 0
                ) );

                if( empty( $postslist ) ) {
                    $postslist = get_posts( array(
                        'post_type'         => 'post',
                        'post_status'       => 'publish',
                        'numberposts'       => 1,
                        'order'             => 'DESC',
                        'orderby'           => 'date',
                        'post__not_in'      => $post_ids,
						'tax_query' => array(
							array(
								'taxonomy' => 'post_format',
								'field' => 'slug',
								'operator'	=> 'NOT IN',
								'terms' => array( 'post-format-video' )
							)
						),
                        'suppress_filters'  => 0
                    ) );
                }
            }
            
            array_push( $post_ids, $postslist[0]->ID );

        }

    }
    

    if ( $post_section['section'] == 'home_top' ) {
        require_once('home_top.php');
    } elseif ( $post_section['section'] == 'taliban_page_top' ) {
        require_once('taliban_top.php');
    } else {
		return;
	}

    $return_html = ob_get_contents();
    ob_end_clean();
    return $return_html;

}

add_shortcode( 'posts_order', 'posts_order_get_posts_shortcode' );

