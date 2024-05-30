<?php
if (!defined('ABSPATH')) {
    exit;
}

function myslideshow_shortcode() {
    $images = get_option('myslideshow_images', []);
    if (empty($images)) {
        return '<p>No images found for the slideshow.</p>';
    }

    $output = '<div class="myslideshow">';
    foreach ($images as $image) {
        $output .= '<div><img src="' . esc_url($image) . '" alt="Slideshow Image"></div>';
    }
    $output .= '</div>';

    return $output;
}
add_shortcode('myslideshow', 'myslideshow_shortcode');
?>
