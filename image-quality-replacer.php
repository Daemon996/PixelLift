<?php
/**
 * Contributors: Nathan Courtney
 * Plugin Name: PixelLift
 * Version: 1.0
 * Requires at least: 5.0
 * Tested up to: 6.4
 * Requires PHP: 7.4
 * License: GPL-2.0+
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Tags: images, lazy loading, progressive loading, srcset, performance
 * Website: dev.nathancourtney.com
 */

if (!defined('ABSPATH')) exit; // Prevent direct access

// Register plugin settings
function iqr_register_settings() {
    add_option('iqr_image_quality', 'low');
    register_setting('iqr_options_group', 'iqr_image_quality');
}
add_action('admin_init', 'iqr_register_settings');

// Add plugin settings page
function iqr_plugin_menu() {
    add_options_page('Image Quality Replacer', 'Image Quality Replacer', 'manage_options', 'image-quality-replacer', 'iqr_settings_page');
}
add_action('admin_menu', 'iqr_plugin_menu');

// Display the settings page
function iqr_settings_page() {
    ?>
    <div class="wrap">
        <h1>Image Quality Replacer Settings</h1>
        <form method="post" action="options.php">
            <?php settings_fields('iqr_options_group'); ?>
            <table class="form-table">
                <tr valign="top">
                    <th scope="row">Starting Image Quality</th>
                    <td>
                        <select name="iqr_image_quality">
                            <option value="low" <?php selected(get_option('iqr_image_quality'), 'low'); ?>>Low Quality</option>
                            <option value="medium" <?php selected(get_option('iqr_image_quality'), 'medium'); ?>>Medium Quality</option>
                        </select>
                    </td>
                </tr>
            </table>
            <?php submit_button(); ?>
        </form>
    </div>
    <?php
}

// Modify image attributes to start with the lowest quality
function iqr_modify_image_attributes($attributes, $attachment, $size) {
    if (!isset($attributes['srcset'])) {
        return $attributes; // Skip if no srcset available
    }

    $srcset = wp_parse_srcset($attributes['srcset']);
    if (empty($srcset)) {
        return $attributes;
    }

    // Get available image sizes sorted by resolution (low to high)
    ksort($srcset);

    // Get the original image size requested by the author
    $original_src = $attributes['src'];

    // Identify the best matching size within the limit
    $available_sizes = array_values($srcset);
    $chosen_size = $available_sizes[0]['url']; // Start with the lowest

    foreach ($available_sizes as $size_option) {
        if (strpos($original_src, $size_option['url']) !== false) {
            $chosen_size = $size_option['url']; // Match the originally requested size
            break;
        }
    }

    // Set the initial image to the lowest available size
    $attributes['src'] = $chosen_size;
    $attributes['data-srcset'] = $attributes['srcset']; // Store the full srcset for JS
    $attributes['data-original'] = $original_src; // Preserve the original user-selected size
    $attributes['class'] .= ' iqr-lazy'; // Add a class for JS
    $attributes['loading'] = 'lazy'; // Enable lazy loading

    return $attributes;
}
add_filter('wp_get_attachment_image_attributes', 'iqr_modify_image_attributes', 10, 3);

// Enqueue the JavaScript file
function iqr_enqueue_scripts() {
    wp_enqueue_script('iqr-image-quality', plugin_dir_url(__FILE__) . 'js/image-quality-replacer.js', array(), '1.0', true);
}
add_action('wp_enqueue_scripts', 'iqr_enqueue_scripts');