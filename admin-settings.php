<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

function myslideshow_admin_menu() {
    error_log('MySlideshow: Adding admin menu.');
    add_menu_page(
        'My Slideshow Settings',  // Page title
        'Slideshow',              // Menu title
        'manage_options',         // Capability
        'myslideshow-settings',   // Menu slug
        'myslideshow_settings_page', // Function to display the settings page
        'dashicons-images-alt2',  // Icon URL
        6                         // Position
    );
}
add_action('admin_menu', 'myslideshow_admin_menu');


function myslideshow_settings_page() {
    ?>
    <div class="wrap">
        <h1>My Slideshow Settings</h1>
        <form method="post" action="options.php">
            <?php
            settings_fields('myslideshow-settings-group');
            do_settings_sections('myslideshow-settings');
            ?>
            <button id="myslideshow-add-images" class="button">Add Images</button>
            <ul id="myslideshow-image-list">
                <?php
                $images = get_option('myslideshow_images', []);
                if (!is_array($images)) {
                    $images = explode(',', $images); // Convert the string to an array
                }
                foreach ($images as $image) {
                    if (!empty($image)) {
                        echo '<li><img src="' . esc_url($image) . '" style="max-width:100px; height:auto;"/><button class="remove-image">Remove</button></li>';
                    }
                }
                ?>
            </ul>
            <input type="hidden" name="myslideshow_images" id="myslideshow-images-input" value="<?php echo esc_attr(implode(',', $images)); ?>">
            <?php submit_button(); ?>
        </form>
    </div>
    <?php
}




function myslideshow_enqueue_admin_scripts($hook) {
    if ($hook != 'toplevel_page_myslideshow-settings') {
        return;
    }
    wp_enqueue_script('jquery-ui-sortable');
    wp_enqueue_script('myslideshow-admin-script', plugins_url('assets/js/admin-script.js', __FILE__), array('jquery', 'jquery-ui-sortable'), null, true);
    wp_enqueue_style('myslideshow-admin-style', plugins_url('assets/css/admin-style.css', __FILE__));
}
add_action('admin_enqueue_scripts', 'myslideshow_enqueue_admin_scripts');

function myslideshow_register_settings() {
    register_setting('myslideshow-settings-group', 'myslideshow_images');
}
add_action('admin_init', 'myslideshow_register_settings');
