<?php

$main_post = new WP_Query(
    array(
        'post_type'         => 'post',
        'post_status'       => 'publish',
        'posts_per_page'    => 1,
        'post__in'          => array( $post_ids[0] ),
        'post__not_in'      => get_option( 'sticky_posts' )
    )
);

$side_posts = new WP_Query(
    array(
        'post_type'         => 'post',
        'post_status'       => 'publish',
        'posts_per_page'    => 2,
        'post__in'          => array( $post_ids[1], $post_ids[2] ),
        'post__not_in'      => get_option( 'sticky_posts' ),
        'orderby'           => 'post__in' 
    )
);

$second_row_posts = new WP_Query(
    array(
        'post_type'         => 'post',
        'post_status'       => 'publish',
        'posts_per_page'    => 4,
        'post__in'          => array( $post_ids[3], $post_ids[4], $post_ids[5], $post_ids[6] ),
        'post__not_in'      => get_option( 'sticky_posts' ),
        'orderby'           => 'post__in' 
    )
);

ob_start();

?>

<div class="home-row home-row-one">
    
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
                            <?php 
								$categories = get_the_category( get_the_ID() );
								$objIterator = new ArrayIterator($categories);
								$cat_id = $objIterator->current()->term_id;
	
								$main_post_single = new WP_Query(
									array(
										'post_type'         => 'post',
										'post_status'       => 'publish',
										'posts_per_page'    => 1,
										'cat'				=> $cat_id,
										'post__not_in'      => array_merge( get_option( 'sticky_posts' ), $post_ids )
									)
								);

							?>
                            <?php if ( $main_post_single->have_posts() ) : ?>
                                <?php while ( $main_post_single->have_posts() ) : $main_post_single->the_post(); ?>

                                <div class="single-sub-post">
									<ul>
										<li><h4 class="post-title"><a href="<?php echo get_the_permalink(); ?>"><?php echo get_the_title(); ?></a></h4></li>
									</ul>
                                </div>
                                    
                                <?php endwhile; ?>
                            <?php endif; wp_reset_postdata(); ?>

                        </div>
                    </div>

                <?php endwhile; ?>
            <?php endif; wp_reset_postdata(); ?>

        </div>
		
        <div class="section-side-articles">
            <div class="side-article-wrapper">
				
            <?php if ( $side_posts->have_posts() ) : ?>
                <?php while ( $side_posts->have_posts() ) : $side_posts->the_post(); ?>

					<div class="post-item">
						<div class="post-image">
							<a href="<?php echo get_the_permalink(); ?>"><?php echo get_the_post_thumbnail( '', 'neeon-size10', array( 'loading' => 'eager' ) ); ?></a>
							<?php if( get_post_format() == "video" ) : ?>
							<a class="rt-play play-btn-transparent rt-video-popup" href="<?php echo get_post_meta( get_the_ID(), 'neeon_youtube_link', true ); ?>"><i class="fas fa-play"></i></a>
							<?php endif; ?>
						</div>
						<div class="side-post-meta">
							<h3 class="post-title"><a href="<?php echo get_the_permalink(); ?>"><?php echo get_the_title(); ?></a></h3>
							<ul class="post-meta">
								<li class="post-date"><?php echo date_now_format( get_the_ID() ); ?></li>
							</ul>
						</div>
						
					</div>

                <?php endwhile; ?>
            <?php endif; wp_reset_postdata(); ?>
			</div>
        </div>

    </div>

    <hr class="section-separator">

    <div class="home-row home-row-two">
        
        <div class="section-article-columns">
            
            <?php if ( $second_row_posts->have_posts() ) : ?>
                <?php while ( $second_row_posts->have_posts() ) : $second_row_posts->the_post(); ?>

                    <div class="post-item-wrapper">
                        <div class="post-image">
                            <a href="<?php echo get_the_permalink(); ?>"><?php echo get_the_post_thumbnail( '', $thumb_size, array( 'loading' => 'eager' ) ); ?></a>
                        </div>
                        <div class="post-content">
                            <div class="post-category"><?php echo the_category( get_locale() == 'en_US' ? ', ' : '، ', '', '' ); ?></div>
                            <h3 class="post-title"><a href="<?php echo get_the_permalink(); ?>"><?php echo get_the_title(); ?></a></h3>
                            <ul class="post-meta">
                                <li class="post-date"><?php echo date_now_format( get_the_ID() ); ?></li>
                            </ul>
                        </div>
                    </div>

                <?php endwhile; ?>
            <?php endif; wp_reset_postdata(); ?>

        </div>

    </div>