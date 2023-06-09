<?php
function update_post_order( $section_id, $section_title, $numberOfPosts ){

    global $wpdb;
    $table_name = $wpdb->prefix . 'posts_order';

    if ( isset( $_POST['update'] ) ){
        $english_posts = $_POST['post_id_en'];
        $farsi_posts = $_POST['post_id_fa'];
        $pashto_posts = $_POST['post_id_ps'];
        $table_name = $wpdb->prefix . 'posts_order';

        $data = array(
            'en'    => $english_posts,
            'fa'    => $farsi_posts,
            'ps'    => $pashto_posts
        );

        $wpdb->update( 
            $table_name, 
            array( 
                'post_order'        => serialize( $data ),
                'time'              => current_time( 'mysql' ),  
            ),
            array(
                'id'    => $section_id,
            )
        );
    }

    $posts = $wpdb->get_results( $wpdb->prepare("SELECT post_order FROM {$wpdb->prefix}posts_order WHERE id = '%d'", $section_id) );
    
    $post_data = unserialize( $posts[0]->post_order );

?>

    <h3><?php echo "Sort " . $section_title . " section articles"; ?></h3>

    <div class="posts-wrapper">

        <form action="" method="post">

            <div class="col-3">
                <div class="english">
                    <h4>English Articles</h4> 

                    <?php for ($i=0; $i < $numberOfPosts; $i++) : ?>
                        
                        <?php echo $i >0 && $i < 3 ? "<label>Side Videos</label>" : ""; ?>
                        <div class="form-group">
                            <input type="text" class="input-text post-title" name="post_title" data-lang="en" autocomplete="off" value="<?php echo !empty( $post_data ) ? get_the_title( $post_data['en'][$i] ) : ''; ?>">
                            <input type="hidden" class="post-id" name="post_id_en[]" value="<?php echo !empty( $post_data ) ? $post_data['en'][$i] : ''; ?>">
                        </div>

                    <?php endfor; ?>

                </div>
            </div>

            <div class="col-3">
                <div class="farsi">
                    <h4>Farsi Articles</h4>
                    
                    <?php for ($i=0; $i < $numberOfPosts; $i++) : ?>
                        <?php echo $i >0 && $i < 3 ? "<label>Side Videos</label>" : ""; ?>
                        <div class="form-group">
                            <input type="text" class="input-text post-title" name="post_title" data-lang="fa" autocomplete="off" value="<?php echo !empty( $post_data ) ? get_the_title( $post_data['fa'][$i] ) : ''; ?>">
                            <input type="hidden" class="post-id" name="post_id_fa[]" value="<?php echo !empty( $post_data ) ? $post_data['fa'][$i] : ''; ?>">
                        </div>

                    <?php endfor; ?>

                </div>
            </div>

            <div class="col-3">
                <div class="pashto">
                    <h4>Pashto Articles</h4>
                    
                    <?php for ($i=0; $i < $numberOfPosts; $i++) : ?>
                        <?php echo $i >0 && $i < 3 ? "<label>Side Videos</label>" : ""; ?>
                        <div class="form-group">
                            <input type="text" class="input-text post-title" name="post_title" data-lang="ps" autocomplete="off" value="<?php echo !empty( $post_data ) ? get_the_title( $post_data['ps'][$i] ) : ''; ?>">
                            <input type="hidden" class="post-id" name="post_id_ps[]" value="<?php echo !empty( $post_data ) ? $post_data['ps'][$i] : ''; ?>">
                        </div>

                    <?php endfor; ?>

                </div>
            </div>
            
            <div class="col-12 form-submit-wrapper">
                <input type="submit" name="update" class="sort-submit-button" value="Update">

                <?php if ( current_user_can( 'administrator' ) ) : ?>

                    <input type="submit" name="delete" class="sort-submit-button delete" value="Delete">
                
                <?php endif; ?>
            </div>
        </form>

    </div>

<?php
}