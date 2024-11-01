<?php

namespace Coderey\VideoLinkGallery\VideoProvider;

/**
 * @interface VideoProvider-Interface
 */
interface VideoProviderInterface
{
    /**
     * @param string $videoId
     */
    public function setVideoId($videoId);

    /**
     * @param string $cssClass
     */
    public function setCssClass($cssClass);

    /**
     * @param string $title
     */
    public function setTitle($title);

    /**
     * @return string video-title
     */
    public function getTitle();

    /**
     * @param array $options
     */
    public function setOptions(array $options);

    /**
     * @return string HTML
     */
    public function getEmbedCode();
    
    /**
     * @return string URL to preview-image
     */
    public function getPreviewImage();

    /**
     * @return array shortcodes that should be registered for this video-provider
     */
    public function getShortcodes();
}
