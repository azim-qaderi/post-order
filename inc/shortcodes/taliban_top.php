<?php

$main_post = new WP_Query(
    array(
        'post_type'         => 'post',
        'post_status'       => 'publish',
        'posts_per_page'    => 1,
        'post__in'          => array( $post_ids[4], $post_ids[5] ),
        'post__not_in'      => get_option( 'sticky_posts' )
    )
);

$side_posts_left = new WP_Query(
    array(
        'post_type'         => 'post',
        'post_status'       => 'publish',
        'posts_per_page'    => 2,
        'post__in'          => array( $post_ids[0], $post_ids[1], $post_ids[2], $post_ids[3] ),
        'post__not_in'      => get_option( 'sticky_posts' ),
        'orderby'           => 'post__in' 
    )
);

$side_posts_right = new WP_Query(
    array(
        'post_type'         => 'post',
        'post_status'       => 'publish',
        'posts_per_page'    => 2,
        'post__in'          => array( $post_ids[6], $post_ids[7], $post_ids[8], $post_ids[9] ),
        'post__not_in'      => get_option( 'sticky_posts' ),
        'orderby'           => 'post__in' 
    )
);

ob_start();

?>

<div class="taliban-row">
		
		<div class="main-section-article">

            <?php if ( $main_post->have_posts() ) : ?>
                <?php while ( $main_post->have_posts() ) : $main_post->the_post(); ?>

                    <div class="post-wrapper">
                        <div class="post-image">
                            <a href="<?php echo get_the_permalink(); ?>"><?php echo get_the_post_thumbnail( '', $thumb_size, array( 'loading' => 'eager' ) ); ?></a>
                        </div>
                        <div class="post-content">
                            <div class="post-category"><?php echo the_category( get_locale() == 'en_US' ? ', ' : '، ', '' );  ?></div>
                            <h3 class="post-title"><a href="<?php echo get_the_permalink(); ?>"><?php echo get_the_title(); ?></a></h3>
							<div class="post-excerpt"><p><?php echo get_the_excerpt(); ?><p></div>
                            <ul class="post-meta">
                                <li class="post-date"><?php echo date_now_format( get_the_ID() ); ?></li>
                            </ul>
                        </div>
                    </div>

                <?php endwhile; ?>
            <?php endif; wp_reset_postdata(); ?>

        </div>
	
        <div class="section-side-articles left">
                
            <?php if ( $side_posts_left->have_posts() ) : ?>
                <?php while ( $side_posts_left->have_posts() ) : $side_posts_left->the_post(); ?>

                    <div class="post-item">
                        <div class="post-image">
                            <a href="<?php echo get_the_permalink(); ?>"><?php echo get_the_post_thumbnail( '', $thumb_size, array( 'loading' => 'eager' ) ); ?></a>
                        </div>
                        <ul class="post-meta">
                            <li class="post-date"><?php echo date_now_format( get_the_ID() ); ?></li>
                        </ul>
                        <h3 class="post-title"><a href="<?php echo get_the_permalink(); ?>"><?php echo get_the_title(); ?></a></h3>
                        <div class="post-category"><?php echo the_category( get_locale() == 'en_US' ? ', ' : '، ', '', '' ); ?></div>
                    </div>

                <?php endwhile; ?>
            <?php endif; wp_reset_postdata(); ?>

        </div>
		
        <div class="section-side-articles right">
                
            <?php if ( $side_posts_right->have_posts() ) : ?>
                <?php while ( $side_posts_right->have_posts() ) : $side_posts_right->the_post(); ?>

                    <div class="post-item">
                        <div class="post-image">
                            <a href="<?php echo get_the_permalink(); ?>"><?php echo get_the_post_thumbnail( '', $thumb_size, array( 'loading' => 'eager' ) ); ?></a>
                        </div>
                        <ul class="post-meta">
                            <li class="post-date"><?php echo date_now_format( get_the_ID() ); ?></li>
                        </ul>
                        <h3 class="post-title"><a href="<?php echo get_the_permalink(); ?>"><?php echo get_the_title(); ?></a></h3>
                        <div class="post-category"><?php echo the_category( get_locale() == 'en_US' ? ', ' : '، ', '', '' ); ?></div>
                    </div>

                <?php endwhile; ?>
            <?php endif; wp_reset_postdata(); ?>

        </div>

    </div>