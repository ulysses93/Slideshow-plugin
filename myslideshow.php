<?php
/*
Plugin Name: My Slideshow
Description: A simple slideshow plugin.
Version: 1.0
Author: Your Name
*/

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

$includes_path = plugin_dir_path(__FILE__) . 'includes/';

if (file_exists($includes_path . 'admin-settings.php')) {
    include_once $includes_path . 'admin-settings.php';
    error_log('MySlideshow: admin-settings.php included successfully.');
} else {
    error_log('Error: admin-settings.php not found in includes directory.');
}

if (file_exists($includes_path . 'shortcode.php')) {
    include_once $includes_path . 'shortcode.php';
    error_log('MySlideshow: shortcode.php included successfully.');
} else {
    error_log('Error: shortcode.php not found in includes directory.');
}

// Enqueue necessary scripts and styles.
function myslideshow_enqueue_scripts() {
    wp_enqueue_style('myslideshow-style', plugins_url('assets/css/style.css', __FILE__));
    wp_enqueue_script('myslideshow-script', plugins_url('assets/js/script.js', __FILE__), array('jquery'), null, true);
    wp_enqueue_style('slick-style', plugins_url('assets/lib/slick/slick.css', __FILE__));
    wp_enqueue_script('slick-script', plugins_url('assets/lib/slick/slick.min.js', __FILE__), array('jquery'), null, true);
}
add_action('wp_enqueue_scripts', 'myslideshow_enqueue_scripts');

function myslideshow_admin_enqueue_scripts($hook_suffix) {
    if ($hook_suffix === 'toplevel_page_myslideshow-settings') {
        wp_enqueue_media();
        wp_enqueue_script('myslideshow-admin-script', plugins_url('assets/js/admin-script.js', __FILE__), array('jquery'), null, true);
    }
}
add_action('admin_enqueue_scripts', 'myslideshow_admin_enqueue_scripts');

