<?php

namespace Coderey\VideoLinkGallery\VideoProvider;

/**
 * @class VideoProviderAbstract
 *
 * Common methods that should be equal for nearly all video-providers
 */
abstract class VideoProviderAbstract implements VideoProviderInterface
{
    protected $videoId     = '';
    protected $cssClass    = '';
    protected $title       = '';
    protected $options     = [];
    protected $optionsType = [];

    /**
     * @param array $options
     */
    public function setOptions(array $options)
    {
        foreach ($options as $key => $val) {
            if (array_key_exists($key, $this->options)) {
                $this->options[$key] = $this->_sanitizeOption($key, $val);
            }
        }
    }

    /**
     * @param string $key
     * @param mixed  $value
     *
     * @return mixed casted value
     */
    protected function _sanitizeOption($key, $value)
    {
        if (array_key_exists($key, $this->optionsType)) {
            switch($this->optionsType[$key]) {
                case 'bool':
                case 'boolean':
                    $value = (bool)$value;
                    break;
                case 'int':
                case 'integer':
                    $value = (int)$value;
                    break;
                case 'float':
                    $value = (float)$value;
                    break;
                case 'string':
                    $value = (string)$value;
                    break;
            }
        }

        return $value;
    }

    /**
     * @param string $videoId
     */
    public function setVideoId($videoId)
    {
        $this->videoId = $videoId;
    }

    /**
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @return string video-title
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $cssClass
     */
    public function setCssClass($cssClass)
    {
        $this->cssClass = $cssClass;
    }

    /**
     * @return string HTML
     */
    abstract public function getEmbedCode();
    
    /**
     * @return string URL to preview-image
     */
    abstract public function getPreviewImage();

    /**
     * @return array shortcodes that should be registered for this video-provider
     */
    abstract public function getShortcodes();
}
