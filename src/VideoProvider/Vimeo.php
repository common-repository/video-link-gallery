<?php

namespace Coderey\VideoLinkGallery\VideoProvider;

/**
 * Generating Video-Embed-Code for vimeo-videos
 */
class Vimeo extends VideoProviderAbstract implements VideoProviderInterface
{
    protected $options  = [];
    protected $previewImage = '';

    public function setVideoId($videoId)
    {
        parent::setVideoId($videoId);
        if ($videoInfos = $this->_resolveVideoInformation($videoId)) {
            $this->previewImage = $videoInfos[0]['thumbnail_large'];
            $this->title        = $videoInfos[0]['title'];
        }
    }

    protected function _resolveVideoInformation($videoId)
    {
        if (!function_exists('curl_init')) {
            return false;
        }
        $apiUrl = "https://vimeo.com/api/v2/video/" . $videoId . ".json";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $apiUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch); 

        if ($httpCode != 200) {
            return false;
        }

        return json_decode($response, true);
    }

    /**
     * @return string HTML
     */
    public function getEmbedCode()
    {
        return '<iframe class="' . $this->cssClass . '" src="https://player.vimeo.com/video/' . $this->videoId . '?title=0&byline=0&portrait=0" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>';
    }

    /**
     * @return string URL to preview-image
     */
    public function getPreviewImage()
    {
        return $this->previewImage;
    }

    /**
     * @return array shortcodes that should be registered for this video-provider
     */
    public function getShortcodes()
    {
        return ['vimeo'];
    }
}
