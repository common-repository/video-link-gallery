<?php

namespace Coderey\VideoLinkGallery\Shortcodes;

use Coderey\VideoLinkGallery\Lightbox\LightboxInterface;
use Coderey\VideoLinkGallery\Lightbox\PhotoSwipe;
use Coderey\VideoLinkGallery\VideoProvider\VideoProviderInterface;
use Coderey\VideoLinkGallery\VideoProvider\Youtube;
use Coderey\VideoLinkGallery\VideoProvider\Vimeo;
use Coderey\VideoLinkGallery\VideoProvider\Link;

/**
 * VideoGallery Shortcode:
 * 
 * usage:
 * 
 * [video-gallery]
 *   [yt:ABC123] Optional Title
 *   [youtube:ABC123] Optional Title
 *   [vimeo:12345] Optional Title
 *   [link:https://example.com/video.mp4|https://example.com/preview.jpg] Optional Title
 * [/video-gallery]
 */
class VideoGallery
{
    protected $_shortcode = 'video-gallery';
    protected static $videoProviders = [];

    /**
     * add shortcode [video-gallery] to wordpress
     */
    public function init()
    {
        add_shortcode($this->_shortcode, [$this, 'renderShortcode']);
        if (empty(self::$videoProviders)) {
            $this->_initVideoProviders();
        }
    }

    /**
     * scan VideoProvider-directory and add the video-providers in an array
     */
    protected function _initVideoProviders()
    {
        $dir   = dirname(__DIR__) . '/VideoProvider';
        $files = scandir($dir);
        $ns    = str_replace('Shortcodes', 'VideoProvider', __NAMESPACE__);
        foreach ($files as $file) {
            if (preg_match('/^(.*)\.php/i', $file, $result) && strpos($file, 'VideoProvider') !== 0) {
                $className = $ns . '\\' . $result[1];
                if (class_exists($className)) {
                    /** @var $class VideoProviderInterface */
                    $class = new $className();
                    $shortcodes = $class->getShortcodes();
                    foreach ($shortcodes as $shortcode) {
                        self::$videoProviders[$shortcode] = $className;
                    }
                }
            }
        }
    }

    /**
     * @return array list of video-providers with array-key = video-provider-shortcode
     */
    public function getVideoProviders()
    {
        return self::$videoProviders;
    }

    /**
     * get the terms by attributes and render them with the given html-content
     *
     * @param array $attributes
     * @param $content code between opening and closing shortcode-tag
     *
     * @return string
     */
    public function renderShortcode($attributes, $content)
    {
        if (empty($attributes)) {
            $attributes = [];
        }

        $options  = $this->_sanitizeAttributes($attributes);
        $lightbox = 'coderey\VideoLinkGallery\Lightbox\\' . $options['lightbox'];
        if (!class_exists($lightbox)) {
            $lightbox = PhotoSwipe::class;
        }
        $lightbox = new $lightbox();
        $lightbox->init();

        $this->_parseVideos($lightbox, $content, $attributes);

        return '<div class="video-link-gallery">' . $lightbox->getHtml() . '</div>';
    }

    /**
     * @param LightboxInterface $lightbox
     * @param $content
     */
    protected function _parseVideos(LightboxInterface $lightbox, $content, array $attributes = [])
    {
        $content = preg_replace('/^<\/p>(.*)<p>$/is', '\\1', $content);

        //add videos
        if (preg_match_all('/^\[(?P<VideoProvider>yt|youtube|vimeo|link):(?P<VideoId>.+)\](?P<VideoTitle>[^\]]*)?$/im', $content, $result)) {
            foreach ($result[0] as $i => $fullMatch) {
                $title = $result['VideoTitle'][$i];
                $title = strip_tags($title);
                $video = $this->_getVideo($result['VideoProvider'][$i], $result['VideoId'][$i], $title);
                $video->setOptions($attributes);
                if ($video) {
                    $lightbox->addVideo($video);
                }
            }
        }
    }


    /**
     * get pre-configured instance of video-provider
     * 
     * @param string $videoProvider video-provider-shortcode
     * @param string $videoId
     * @param string $videoTitle
     * 
     * @return VideoProviderInterface
     */
    protected function _getVideo($videoProvider, $videoId, $videoTitle)
    {
        if (!array_key_exists($videoProvider, self::$videoProviders)) {
            return null;
        }
        $video = new self::$videoProviders[$videoProvider]();
        $video->setVideoId($videoId);
        $videoTitle = trim($videoTitle);

        if (!empty($videoTitle)) {
            $video->setTitle($videoTitle);
        }

        return $video;
    }

    /**
     * @param array $attributes
     *
     * @return array
     */
    protected function _sanitizeAttributes(array $attributes)
    {
        $options = [
            'lightbox' => 'PhotoSwipe'
        ];

        foreach ($attributes as $key => $value) {
            if (array_key_exists($key, $options)) {
                $options[$key] = trim($value);
            }
        }
        return $options;
    }
}
