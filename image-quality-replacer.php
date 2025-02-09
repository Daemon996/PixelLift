<?php
/**
 * Plugin Name: Image Quality Replacer
 * Description: Dynamically replaces images from low to high quality with lazy loading.
 * Version: 1.0
 * Author: Nathan Courtney
 * License: GPL2
 */

// Ensure direct access is blocked
if ( !defined( 'ABSPATH' ) ) exit;

// Register settings page and options
function iqr_register_settings() {
    add_option( 'iqr_image_quality', 'low' ); // default quality setting
    register_setting( 'iqr_options_group', 'iqr_image_quality' );
}
add_action( 'admin_init', 'iqr_register_settings' );

// Add plugin menu in the admin dashboard
function iqr_plugin_menu() {
    add_options_page( 'Image Quality Replacer', 'Image Quality Replacer', 'manage_options', 'image-quality-replacer', 'iqr_settings_page' );
}
add_action( 'admin_menu', 'iqr_plugin_menu' );

// Settings page to select the starting image quality
function iqr_settings_page() {
    ?>
    <div class="wrap">
        <h1>Image Quality Replacer Settings</h1>
        <form method="post" action="options.php">
            <?php settings_fields( 'iqr_options_group' ); ?>
            <table class="form-table">
                <tr valign="top">
                    <th scope="row">Starting Image Quality</th>
                    <td>
                        <select name="iqr_image_quality">
                            <option value="low" <?php selected( get_option('iqr_image_quality'), 'low' ); ?>>Low Quality</option>
                            <option value="medium" <?php selected( get_option('iqr_image_quality'), 'medium' ); ?>>Medium Quality</option>
                        </select>
                    </td>
                </tr>
            </table>
            <?php submit_button(); ?>
        </form>
    </div>
    <?php
}

// Modify the content of posts to replace image sources with low quality first
function iqr_replace_image_quality( $content ) {
    // Get the starting image quality from settings
    $start_quality = get_option( 'iqr_image_quality', 'low' );

    // Define the image sizes based on quality
    $image_sizes = array(
        'low' => 'thumbnail',   // low-quality size
        'medium' => 'medium',   // medium-quality size
        'high' => 'full',       // full-quality size
    );

    // Use regex to find all image tags
    preg_match_all( '/<img [^>]+>/', $content, $matches );

    foreach ( $matches[0] as $img_tag ) {
        // Modify the image tags to change the source based on the selected quality
        if ( strpos( $img_tag, 'class="wp-image' ) !== false ) {
            $img_tag = preg_replace_callback( '/src="([^"]+)"/', function( $matches ) use ( $start_quality, $image_sizes ) {
                $image_url = $matches[1];
                $path_parts = pathinfo( $image_url );
                // Replace the image filename with the corresponding quality size
                $new_url = str_replace( $path_parts['basename'], $image_sizes[$start_quality] . '-' . $path_parts['basename'], $image_url );
                return 'src="' . $new_url . '"';
            }, $img_tag );

            // Add lazy-loading to the image
            $img_tag = preg_replace( '/<img /', '<img loading="lazy" ', $img_tag );

            // Replace the image tag in content
            $content = str_replace( $matches[0], $img_tag, $content );
        }
    }

    return $content;
}
add_filter( 'the_content', 'iqr_replace_image_quality' );
add_filter( 'wp_get_attachment_image', 'iqr_replace_image_quality' );

// Add the necessary JavaScript for dynamically loading medium and high-quality images
function iqr_enqueue_scripts() {
    wp_enqueue_script( 'iqr-image-quality', plugin_dir_url( __FILE__ ) . 'js/image-quality-replacer.js', array(), '1.0', true );
}
add_action( 'wp_footer', 'iqr_enqueue_scripts' );

// Add inline script to make sure images are replaced after page load
function iqr_inline_js() {
    ?>
    <script type="text/javascript">
        document.addEventListener('DOMContentLoaded', function() {
            let images = document.querySelectorAll('img[loading="lazy"]');
            images.forEach(function(img) {
                let lowQualitySrc = img.src;
                let mediumQualitySrc = lowQualitySrc.replace('low', 'medium');
                let highQualitySrc = lowQualitySrc.replace('low', 'full');
                
                // Load medium quality after a brief delay
                setTimeout(function() {
                    img.src = mediumQualitySrc;
                    setTimeout(function() {
                        img.src = highQualitySrc;
                    }, 1000); // Change to high quality after a brief delay
                }, 500); // Change to medium quality after a brief delay
            });
        });
    </script>
    </script>
    <?php
}
add_action( 'wp_footer', 'iqr_inline_js' );<?php
/**
 * Plugin Name: Image Quality Replacer
 * Description: Dynamically replaces images from low to high quality with lazy loading.
 * Version: 1.0
 * Author: Your Name
 * License: GPL2
 */

// Ensure direct access is blocked
if ( !defined( 'ABSPATH' ) ) exit;

// Register settings page and options
function iqr_register_settings() {
    add_option( 'iqr_image_quality', 'low' ); // default quality setting
    register_setting( 'iqr_options_group', 'iqr_image_quality' );
}
add_action( 'admin_init', 'iqr_register_settings' );

// Add plugin menu in the admin dashboard
function iqr_plugin_menu() {
    add_options_page( 'Image Quality Replacer', 'Image Quality Replacer', 'manage_options', 'image-quality-replacer', 'iqr_settings_page' );
}
add_action( 'admin_menu', 'iqr_plugin_menu' );

// Settings page to select the starting image quality
function iqr_settings_page() {
    ?>
    <div class="wrap">
        <h1>Image Quality Replacer Settings</h1>
        <form method="post" action="options.php">
            <?php settings_fields( 'iqr_options_group' ); ?>
            <table class="form-table">
                <tr valign="top">
                    <th scope="row">Starting Image Quality</th>
                    <td>
                        <select name="iqr_image_quality">
                            <option value="low" <?php selected( get_option('iqr_image_quality'), 'low' ); ?>>Low Quality</option>
                            <option value="medium" <?php selected( get_option('iqr_image_quality'), 'medium' ); ?>>Medium Quality</option>
                        </select>
                    </td>
                </tr>
            </table>
            <?php submit_button(); ?>
        </form>
    </div>
    <?php
}

// Modify the content of posts to replace image sources with low quality first
function iqr_replace_image_quality( $content ) {
    // Get the starting image quality from settings
    $start_quality = get_option( 'iqr_image_quality', 'low' );

    // Define the image sizes based on quality
    $image_sizes = array(
        'low' => 'thumbnail',   // low-quality size
        'medium' => 'medium',   // medium-quality size
        'high' => 'full',       // full-quality size
    );

    // Use regex to find all image tags
    preg_match_all( '/<img [^>]+>/', $content, $matches );

    foreach ( $matches[0] as $img_tag ) {
        // Modify the image tags to change the source based on the selected quality
        if ( strpos( $img_tag, 'class="wp-image' ) !== false ) {
            $img_tag = preg_replace_callback( '/src="([^"]+)"/', function( $matches ) use ( $start_quality, $image_sizes ) {
                $image_url = $matches[1];
                $path_parts = pathinfo( $image_url );
                // Replace the image filename with the corresponding quality size
                $new_url = str_replace( $path_parts['basename'], $image_sizes[$start_quality] . '-' . $path_parts['basename'], $image_url );
                return 'src="' . $new_url . '"';
            }, $img_tag );

            // Add lazy-loading to the image
            $img_tag = preg_replace( '/<img /', '<img loading="lazy" ', $img_tag );

            // Replace the image tag in content
            $content = str_replace( $matches[0], $img_tag, $content );
        }
    }

    return $content;
}
add_filter( 'the_content', 'iqr_replace_image_quality' );
add_filter( 'wp_get_attachment_image', 'iqr_replace_image_quality' );

// Add the necessary JavaScript for dynamically loading medium and high-quality images
function iqr_enqueue_scripts() {
    wp_enqueue_script( 'iqr-image-quality', plugin_dir_url( __FILE__ ) . 'js/image-quality-replacer.js', array(), '1.0', true );
}
add_action( 'wp_footer', 'iqr_enqueue_scripts' );

// Add inline script to make sure images are replaced after page load
function iqr_inline_js() {
    ?>
    <script type="text/javascript">
        document.addEventListener('DOMContentLoaded', function() {
            let images = document.querySelectorAll('img[loading="lazy"]');
            images.forEach(function(img) {
                let lowQualitySrc = img.src;
                let mediumQualitySrc = lowQualitySrc.replace('low', 'medium');
                let highQualitySrc = lowQualitySrc.replace('low', 'full');
                
                // Load medium quality after a brief delay
                setTimeout(function() {
                    img.src = mediumQualitySrc;
                    setTimeout(function() {
                        img.src = highQualitySrc;
                    }, 1000); // Change to high quality after a brief delay
                }, 500); // Change to medium quality after a brief delay
            });
        });
    </script>
    </script>
    <?php
}
add_action( 'wp_footer', 'iqr_inline_js' );