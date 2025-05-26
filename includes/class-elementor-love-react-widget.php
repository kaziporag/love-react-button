<?php
/**
 * Elementor Widget – makes a drag-and-drop “Love React” block
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Register only if Elementor is active
 */
add_action( 'plugins_loaded', function () {

    if ( ! did_action( 'elementor/loaded' ) ) {
        return;
    }

    add_action( 'elementor/widgets/register', function ( $widgets_manager ) {
        $widgets_manager->register( new \Love_Reaction_Elementor_Widget() );
    } );
} );

/**
 * Widget Class
 */
class Love_Reaction_Elementor_Widget extends \Elementor\Widget_Base {

    public function get_name()         { return 'love_react'; }
    public function get_title()        { return esc_html__( 'Love React', 'love-react' ); }
    public function get_icon()         { return 'eicon-heart-o'; } // Elementor’s default icon set
    public function get_categories()   { return [ 'general' ]; }

    public function render() {
        echo do_shortcode( '[love_react]' );
    }

    // Feel free to add style/content controls here later
}
