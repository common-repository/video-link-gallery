<?php

namespace Coderey\VideoLinkGallery\VideoProvider;

/**
 * Generating Video-Embed-Code for youtube-videos
 */
class Youtube extends VideoProviderAbstract implements VideoProviderInterface
{
    protected $options = [
        'yt_nocookie' => true,
    ];
    protected $optionsType = [
        'yt_nocookie' => 'bool',
    ];

    /**
     * @return string HTML
     */
    public function getEmbedCode()
    {
        $domain = 'www.youtube.com';
        if (array_key_exists('yt_nocookie', $this->options) && $this->options['yt_nocookie']) {
            $domain = 'www.youtube-nocookie.com';
        }
        return '<iframe class="' . $this->cssClass . '" src="https://' . $domain . '/embed/' . $this->videoId . '?rel=0" frameborder="0" allowfullscreen></iframe>';
    }

    /**
     * @return string URL to preview-image
     */
    public function getPreviewImage()
    {
        return 'https://i.ytimg.com/vi/' . $this->videoId . '/0.jpg';
    }

    /**
     * @return array shortcodes that should be registered for this video-provider
     */
    public function getShortcodes()
    {
        return ['youtube', 'yt'];
    }

}
