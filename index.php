<?php
/*
 * Video-Link-Gallery
 *
 * Video-link-gallery supporting youtube, vimeo and direct Video-URLs - showing videos in PhotoSwipe-Lightbox of Dmitry Semenov
 *
 * @author    Martin Bergann
 * @license   GPL-2.0+
 * @link      https://www.coderey.de/wordpress-plugins/video-link-gallery/
 * @copyright 2020  Martin Bergann
 *
 * @wordpress-plugin
 * Plugin Name: Video-Link-Gallery
 * Plugin URI: https://www.coderey.de/wordpress-plugins/video-link-gallery/
 * Description: Video-link-gallery supporting youtube, vimeo and direct Video-URLs - showing videos in PhotoSwipe-Lightbox of Dmitry Semenov
 * Version:     1.0.2
 * Author:      Martin Bergann
 * Author URI:  https://www.coderey.de
 * License:     GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 */

defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

include __DIR__ . '/autoload.php';

coderey_autoload("Coderey\VideoLinkGallery", __DIR__ . DIRECTORY_SEPARATOR . 'src');

if (!is_admin()) {
    add_action( 'init', function() {
        $shortcode = new Coderey\VideoLinkGallery\Shortcodes\VideoGallery();
        $shortcode->init();
    });
    wp_enqueue_style(
        'bootstrap-grid',
        plugin_dir_url( __FILE__ ) . 'css/bootstrap-grid.min.css',
        false,
        '4.3.1'
    );

}
