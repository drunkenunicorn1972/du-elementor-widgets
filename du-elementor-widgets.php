<?php
/**
 * Plugin Name: Extra Elementor Widgets
 * Description: Extra Elementor Widgets for your website.
 * Plugin URI:  https://www.drunken-unicorn.eu
 * Version:     1.0.2
 * Author:      Drunken Unicorn
 * Author URI:  https://www.drunken-unicorn.eu
 * Text Domain: du-elem
 *
 * Elementor tested up to: 3.11.2
 * Elementor Pro tested up to: 3.11.2
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

define('DU_PLUGIN_URL', plugin_dir_url(__FILE__));
define('DU_PLUGIN_DIR', plugin_dir_path(__FILE__));

/**
 * Register Widgets.
 *
 * Include widget file and register widget class.
 *
 * @since 1.0.0
 * @param \Elementor\Widgets_Manager $widgets_manager Elementor widgets manager.
 * @return void
 */
function register_du_widgets( $widgets_manager ): void {

    require_once( __DIR__ . '/widgets/class-du-ctabtn.php' );
    require_once( __DIR__ . '/widgets/class-du-cta.php' );
    require_once( __DIR__ . '/widgets/class-du-buttons.php' );
    require_once( __DIR__ . '/widgets/class-du-quote.php' );
    require_once( __DIR__ . '/widgets/class-du-event.php' );
    require_once( __DIR__ . '/widgets/class-du-slider.php' );
    require_once( __DIR__ . '/widgets/class-du-newsslider.php' );
    require_once( __DIR__ . '/widgets/class-du-newslist.php' );
    require_once( __DIR__ . '/widgets/class-du-teammember.php' );
    require_once( __DIR__ . '/widgets/class-du-responsive-image.php' );

    $widgets_manager->register( new \Du_CTA_Button_Widget() );
    $widgets_manager->register( new \Du_Call_To_Action_Widget() );
    $widgets_manager->register( new \Du_Buttons_Widget() );
    $widgets_manager->register( new \Du_Quote_Widget() );
    $widgets_manager->register( new \Du_Event_Widget() );
    $widgets_manager->register( new \Du_Slider_Widget() );
    $widgets_manager->register( new \Du_NewsSlider_Widget() );
    $widgets_manager->register( new \Du_Newslist_Widget() );
    $widgets_manager->register( new \DU_Teammember_Widget() );
    $widgets_manager->register( new \DU_Responsive_Image_Widget() );

}
add_action( 'elementor/widgets/register', 'register_du_widgets' );

/**
 * Add the custom widget category
 * @param $elements_manager
 * @return void
 */
function add_elementor_widget_categories( $elements_manager ) {

    $elements_manager->add_category(
        'du_category',
        [
            'title' => esc_html__( 'DU Extra Elements', 'du-elem' ),
            'icon' => 'fa fa-plug',
        ]
    );

}

function du_widgets_load_translations() {
    load_plugin_textdomain('du-elem', false, dirname( plugin_basename( __FILE__ ) ) . '/languages');
}

function du_frontend_scripts() {
    wp_register_script( 'du-elm-widget-scripts', plugins_url( 'dist/js/app.js', __FILE__ ) );
    wp_register_script( 'du-elm-splide-scripts', 'https://cdn.jsdelivr.net/npm/@splidejs/splide@4.1.4/dist/js/splide.min.js' );
    wp_enqueue_script( 'du-elm-widget-scripts' );
    wp_enqueue_script( 'du-elm-splide-scripts' );
}

function du_frontend_stylesheets() {
    wp_register_style( 'du-elm-widget-styles', plugins_url( 'dist/css/style.css', __FILE__ ) );
    wp_register_style( 'du-elm-splide-styles', 'https://cdn.jsdelivr.net/npm/@splidejs/splide@4.1.4/dist/css/splide.min.css' );
    wp_enqueue_style( 'du-elm-widget-styles' );
    wp_enqueue_style( 'du-elm-splide-styles' );
}

add_action( 'elementor/frontend/before_enqueue_styles', 'du_frontend_stylesheets', 800 );
add_action( 'elementor/frontend/before_register_scripts', 'du_frontend_scripts', 800 );
add_action( 'elementor/elements/categories_registered', 'add_elementor_widget_categories' );
add_action( 'plugins_loaded', 'du_widgets_load_translations' );