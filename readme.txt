=== Video-Link-Gallery ===
Contributors: mbergann
Donate link: https://www.paypal.me/MartinBergann/
Tags: video-gallery, photoswipe, lightbox, youtube, vimeo
Requires at least: 4.7
Tested up to: 5.3.2
Stable tag: 1.0.2
Requires PHP: 7.1
License: GPL-2.0+
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Video-Gallery defined by shortcodes for youtube, vimeo and direct links, opening videos in a lightbox (default-lightbox: "PhotoSwipe")

== Description ==

This plugin creates a video-gallery for youtube- or vimeo-videos or direct video-file-links by simply defining the gallery with shortcodes.
The Videos will be opened in a lightbox.

By default the "[PhotoSwipe](https://photoswipe.com/)"-Lightbox of Dmitry Semenov is used.
(at the moment it is the only one)

This plugin is really simple and clean designed to be easily extendable.
* there is a "src/VideoProvider"-directory where every Video-Platform (like youtube or vimeo) is defined in an own php-class implementing a class-interface.
* there is a "src/Lightbox"-directory where every lightbox is defined in an own php-class, implementing a class-interface
* there is a "src/Shortcodes"-directory where the "[video-gallery]"-Shortcode is defined - that is where the magic happenes - but there is no need to edit this file.

= Parameters and video-provider-specific specials =

All parameters - general parameters and also video-provider-specific parameters are set directly in the [[video-gallery]]-Shortcode.

#### general ####
| parameter | description | default |
| --------- | ----------- | ------- |
| lightbox  | name of the lightbox-class that should be used | PhotoSwipe |


#### Youtube ####

| parameter | description | default |
| --------- | ----------- | ------- |
| yt_nocookie  | use youtube-nocookie.com instead of youtube.com in video-links to be GDPR(DSGVO)-save | true |

#### Vimeo ####

In vimeo the preview-image-URL doesn't use the video-ID - so you need to make an API-request to get the image-URL.
In this API-call we also get the original title of the video.
For this reason we need the php CURL extension.
The thumbnail will be taken from the API-response.
When no manual video-title is defined, the video-provider-class uses also the original video-title from API-response automaticly.


== Installation ==

1. Upload this plugin files to the `/wp-content/plugins/video-link-gallery` directory, or install the plugin through the WordPress plugins screen directly.
1. Activate the plugin through the 'Plugins' screen in WordPress
1. now you can use the [video-gallery]-Shortcode as descripted!

== Extending the Plugin ==

You can easily extend the Plugin by writing your own classes for Video-Platforms or other Lightboxes - you just have to implement the Interfaces.

== Frequently Asked Questions ==

= My Video is not listed in the thumb-gallery - what am I doing wrong? =
Let me take my crystal ball:
 - Maybe you have a typo in your video-definition?
 - Or you might have a closing square bracket in your video-title that is confusing my regular-expression?!

= How can I extend the plugin to support more video-plattforms? =

You just have to copy-and-edit a given (or create a new) VideoProvider-Class. The VideoProvider-Class MUST implement the VideoProviderInterface.
To get a faster and more clean result you SHOULD also use the VideoProviderAbstract class to extend from that
 - so you don't have to write some methods that are identical in most cases a second time.

= How can I extend the plugin to support more lightboxes? =

You just have to copy-and-edit a given (or create a new) Lightbox-Class. The Lightbox-Class MUST implement the LightboxInterface.
The Lightbox-Class creates the html-code for thumbnails and also the lightbox itself.

In future versions it's also planned to decouple this a little bit... but at the moment it was the simplest way to implement the lightbox.

= How can I change the lightbox =

There is a parameter "lightbox" - for more details: see Parameters-section in description

== Screenshots ==

1. gallery-view / thumbnails
2. PhotoSwipe-Lightbox with Youtube-Video
3. PhotoSwipe-Lightbox with Vimeo-Video
4. PhotoSwipe-Lightbox with local hosted video
5. class- and directory-structure - designed to extend easily

== Changelog ==

= 1.0.2 (2020-02-23) =
 - de-couple VideoGallery-Shortcode from VideoProviders
 - make plugin ready for wordpress-plugin-directory

= 1.0.1 (2020-02-17) =
 - small bugfix in Youtube-VideoProvider: choosen PreviewImage-URL was not always available.

= 1.0.0 (2020-02-17) =
 - initial released version after a few days of development

== Upgrade Notice ==
no special infos yet
