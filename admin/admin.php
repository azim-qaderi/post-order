<?php 

require PLUGIN_PATH . '/inc/sorting/manage-orders.php';
require PLUGIN_PATH . '/inc/sorting/data_ajax.php';
/**
 * Init Styles & scripts
 *
 * @return void
 */
function post_order_admin_styles_scripts() {

    wp_enqueue_style( 'post-order-admin-style', PLUGIN_URL . 'admin/css/admin.css', '', rand());

    wp_enqueue_script( 'post-order-admin-script', PLUGIN_URL . 'admin/js/admin.js', array('jquery'), rand(), true );

    wp_localize_script( 'post-order-admin-script', 'ajax_object', array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ) );

}
add_action( 'admin_enqueue_scripts', 'post_order_admin_styles_scripts' );


/**
 * Custom Admin Menu
 */
function post_order_custom_admin_menu() {
    add_menu_page(
        __( 'Posts Order', 'post-order' ),
        __( 'Posts Order', 'post-order' ),
        'publish_posts',
        'posts-order',
        'post_order_custom_submenu_template_callback',
        'dashicons-sort',
        10
    );
}
add_action( 'admin_menu', 'post_order_custom_admin_menu' );

/**
 * Custom Submenu Callback Function
 */
function post_order_custom_submenu_template_callback() {

    global $wpdb;
    $table_name = $wpdb->prefix . 'posts_order';

    $active_tab = isset( $_GET[ 'item' ] ) ? $_GET[ 'item' ] : '';
    $section_title = '';
    $section_id = '';
    $section_url = '';
    $numberOfPosts = '';

    $message = '';
    $action = '';

    
    
    if( isset( $_POST['add_item'] ) && !empty( $_POST['title'] ) && !empty( $_POST['number_of_posts'] ) && $_POST['number_of_posts'] > 0 ){

        $title = sanitize_text_field( $_POST['title'] );
        $section = str_replace(' ', '_', strtolower($title));
        $number_of_posts = intval( $_POST['number_of_posts'] );
        
        $wpdb->insert( 
            $table_name, 
            array( 
                'section_title'     => $title,
                'post_section'      => $section,
                'number_of_posts'   => $number_of_posts,
                'post_order'        => '',
                'time'              => current_time( 'mysql' ),  
            ) 
        );
        
    } else if ( isset( $_POST['delete']) && current_user_can( 'administrator' ) ) {

        $wpdb->delete( $table_name, array( 'post_section' => $active_tab ) );
        $message = "Section deleted successfully.";
        $action = 'delete';
        
    }
    else {
        $message =  "Something went wrong, try again.";
    }

    // Get Data    
    $results = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}posts_order");

    echo "<h2>Manage Posts Order</h2>";
    if ( current_user_can( 'administrator' ) ) :
    
?>

    <div class="new-item">
        <form action="" method="post">
            <input type="text" class="title-input" name="title" placeholder="Section Title..." require>
            <input type="number" class="number_input" name="number_of_posts" placeholder="Number of posts" required>
            <input type="submit" name="add_item" class="new-item-submit" value="Add">
        </form>
    </div>

    <div class="message"><?php !empty($message) ? $message : ''; ?></div>
    <hr>

    <?php endif; ?>

    <div class="items-wrapper"> <!-- Section Wrapper -->
        <div class="menu-tabs">
            <?php foreach($results as $result) : ?>

                <?php 
                    if ( $active_tab == $result->post_section ) {

                        $section_title = $result->section_title; 
                        $section_id = $result->id;
                        $section_url = $result->post_section;
                        $numberOfPosts = $result->number_of_posts; 
                    }

                ?>
                <a href="?page=posts-order&item=<?php echo $result->post_section; ?>" class="<?php echo $active_tab == $result->post_section ? 'active' : ''; ?>"><?php echo $result->section_title; ?></a>
            
            <?php endforeach; ?>

        </div>

        <div class="posts-list">
            <?php 
                if ( $message != '' && $action == 'delete' ){
                    echo $message;
                    exit;
                }
            ?>
            <?php if ( $active_tab == $section_url && $active_tab != '' ) : ?>
                <?php update_post_order( $section_id, $section_title, $numberOfPosts ); ?>
            <?php elseif ( $active_tab == '' ) : ?>
                Select a section.
            <?php else : ?>
                Section not found, please use another section.
            <?php endif; ?>
        </div>

    </div> <!-- Section Wrapper -->

<?php
}


