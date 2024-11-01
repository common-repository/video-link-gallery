<?php

namespace Coderey\VideoLinkGallery\Lightbox;

use Coderey\VideoLinkGallery\Lightbox\LightboxInterface;
use Coderey\VideoLinkGallery\VideoProvider\VideoProviderInterface;

/**
 * Lightbox-Interface
 */
interface LightboxInterface
{
    public function addVideo(VideoProviderInterface $video);
    public function getHtml();
    public function init();
}
