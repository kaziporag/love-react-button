<?php
/**
 * Plugin Name: Love React Button
 * Description : Adds a circular heart-and-count “Love React” button (Elementor-compatible via shortcode [love_react]).
 * Plugin URI  : https://kazirabiul.com
 * Version     : 1.0.0
 * Author      : Kazi Rabiul Islam
 * Author URI  : https://kazirabiul.com
 * License     : GPLv2 or later
 * Text Domain : love-react
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/*--------------------------------------------------------------
# 1. CONSTANTS
--------------------------------------------------------------*/
define( 'LOVE_REACT_DIR',  plugin_dir_path( __FILE__ ) );
define( 'LOVE_REACT_URL',  plugin_dir_url(  __FILE__ ) );
define( 'LOVE_REACT_VER',  '1.0.0' );

/*--------------------------------------------------------------
# 2. ASSET ENQUEUE   (সবার জন্য — সিঙ্গেল, আর্কাইভ, হোম)
--------------------------------------------------------------*/
add_action( 'wp_enqueue_scripts', function () {

    // Admin-এ চালানোর দরকার নেই
    if ( is_admin() && ! wp_doing_ajax() ) {
        return;
    }

    wp_enqueue_style(
        'love-react-css',
        LOVE_REACT_URL . 'assets/css/love-react.css',
        [],
        LOVE_REACT_VER
    );

    wp_enqueue_script(
        'love-react-js',
        LOVE_REACT_URL . 'assets/js/love-react.js',
        [ 'jquery' ],
        LOVE_REACT_VER,
        true
    );

    // ⬇️ সব পেজেই ajaxUrl + nonce পাঠান
    wp_localize_script( 'love-react-js', 'LoveReactSettings', [
        'ajaxUrl' => admin_url( 'admin-ajax.php' ),
        'nonce'   => wp_create_nonce( 'love-react' ),
    ] );
} );


/*--------------------------------------------------------------
# 3. SHORTCODE  [love_react id="123"]
--------------------------------------------------------------*/
function love_react_shortcode( $atts = [] ) {

    // ➊ id অ্যাট্রিবিউট নিন, fallback = current loop ID
    $atts     = shortcode_atts( [ 'id' => 0 ], $atts, 'love_react' );
    $post_id  = (int) $atts['id'] ?: get_the_ID();
    if ( ! $post_id ) {
        return '';                       // ID না পেলে কিছুই রেন্ডার করবেন না
    }

    $count     = (int) get_post_meta( $post_id, '_love_react_count', true );
    $userLiked = isset( $_COOKIE[ 'loved_' . $post_id ] ) ? ' loved' : '';

    ob_start(); ?>
    <button class="love-react-btn<?php echo esc_attr( $userLiked ); ?>"
            data-post="<?php echo esc_attr( $post_id ); ?>"
            aria-label="<?php esc_attr_e( 'Love react', 'love-react' ); ?>">
        <span class="heart">
            <!-- outlined heart svg -->
            <svg viewBox="0 0 24 24" width="22" height="22" fill="none"
                 stroke="currentColor" stroke-width="2"
                 stroke-linecap="round" stroke-linejoin="round">
                <path d="M20.8 4.6a5.5 5.5 0 0 0-7.8 0L12 5.6l-1-1a5.5 5.5 0 0 0-7.8 7.8l1 1L12 21l7.8-7.6 1-1a5.5 5.5 0 0 0 0-7.8z"/>
            </svg>
        </span>
        <span class="count"><?php echo esc_html( $count ); ?></span>
    </button>
    <?php
    return ob_get_clean();
}
add_shortcode( 'love_react', 'love_react_shortcode' );

/*--------------------------------------------------------------
# 4. AJAX HANDLER  (increase count + set cookie)
--------------------------------------------------------------*/
add_action( 'wp_ajax_love_react_toggle',        'love_react_toggle' );
add_action( 'wp_ajax_nopriv_love_react_toggle', 'love_react_toggle' );

function love_react_toggle() {

    check_ajax_referer( 'love-react', 'nonce' );

    $post_id = isset( $_POST['postId'] ) ? absint( $_POST['postId'] ) : 0;
    if ( ! $post_id || 'trash' === get_post_status( $post_id ) ) {
        wp_send_json_error();
    }

    $count = (int) get_post_meta( $post_id, '_love_react_count', true );

    /* Cookie-based single react per browser  */
    if ( isset( $_COOKIE[ 'loved_' . $post_id ] ) ) {
        // already liked – just return current count
        wp_send_json_success( [ 'count' => $count, 'already' => true ] );
    }

    // add new react
    $count++;
    update_post_meta( $post_id, '_love_react_count', $count );
    setcookie( 'loved_' . $post_id, 1, time() + WEEK_IN_SECONDS, COOKIEPATH, COOKIE_DOMAIN );

    wp_send_json_success( [ 'count' => $count, 'already' => false ] );
}

// /* ----------------------------------------------------------
//  *  Elementor drag-and-drop widget – load only if Elementor is active
//  * ---------------------------------------------------------- */
// add_action( 'plugins_loaded', function () {
//     if ( did_action( 'elementor/loaded' ) ) {           // ✅ Elementor loaded
//         require_once LOVE_REACT_DIR . 'includes/class-elementor-love-react-widget.php';
//     }
// } );