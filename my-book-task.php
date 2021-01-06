<?php
/**
 * Plugin Name:       My Book Task
 * Plugin URI:        https://themespassion.com/
 * Description:       Create Custom Post Type, Shortcode, Widgets, Dashboard Widgets by this plugin.
 * Version:           1.0
 * Author:            Hasnat Masum
 * Author URI:        https://themespassion.com/
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       my-book-task
 * Domain Path:       /languages
 */

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) {
    exit;
}

// require file
require_once plugin_dir_path( __FILE__ ) . 'inc/book-post-type.php';
require_once plugin_dir_path( __FILE__ ) . 'inc/book-meta-box.php';
require_once plugin_dir_path( __FILE__ ) . 'inc/widgets/class-bookwidget.php';
require_once plugin_dir_path( __FILE__ ) . 'inc/widgets/mbt-dashboard-widget.php';
require_once plugin_dir_path( __FILE__ ) . 'inc/shortcode/book-shortcode.php';

// Load Textdomain
function mbt_load_textdomain() {
    load_plugin_textdomain( 'my-book-task', FALSE, basename( dirname( __FILE__ ) ) . '/languages/' );
}

add_action( 'plugins_loaded', 'mbt_load_textdomain' );

// Post Type Init
add_action( 'init', 'mbt_register_post_type_book' );

// Book meta Init
add_action( 'add_meta_boxes', 'mbt_book_metabox' );
add_action( 'save_post', 'mbt_save_book_metabox' );

// Widget Init
add_action( 'widgets_init', 'mbt_register_bookwidget' );
add_action( 'wp_dashboard_setup', 'mbt_dashboard_widget' );

// Shortcode Init
add_action( 'init', 'mbt_book_shortcode' );

// Load assets
function mbt_load_assets() {
    wp_enqueue_style( 'mbt-book-style', plugin_dir_url( __FILE__ ) . "/assets/css/book.css", null, 1.0 );
}
add_action( 'wp_enqueue_scripts', 'mbt_load_assets' );
