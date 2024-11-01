<?php

namespace Coderey\VideoLinkGallery\VideoProvider;

/**
 * Generating Video-Embed-Code for direct linked video
 */
class Link extends VideoProviderAbstract implements VideoProviderInterface
{
    protected $videoUrl   = '';
    protected $previewUrl = '';
    protected $options    = [];

    /**
     * @param string $videoId
     */
    public function setVideoId($videoId)
    {
        $data = explode('|', $videoId);
        $this->videoUrl   = $data[0];
        $this->previewUrl = $data[1];
    }

    /**
     * @return string HTML
     */
    public function getEmbedCode()
    {
        return '<video class="' . $this->cssClass . '" src="' . $this->videoUrl . '" controls></video>';
    }

    /**
     * @return string URL to preview-image
     */
    public function getPreviewImage()
    {
        return $this->previewUrl;
    }

    /**
     * @return array shortcodes that should be registered for this video-provider
     */
    public function getShortcodes()
    {
        return ['link'];
    }

}
