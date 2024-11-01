<?php

namespace Coderey\VideoLinkGallery\Lightbox;

use Coderey\VideoLinkGallery\Lightbox\LightboxInterface;
use Coderey\VideoLinkGallery\VideoProvider\VideoProviderInterface;

/**
 * Video-Lightbox using PhotoSwipe
 */
class PhotoSwipe implements LightboxInterface
{
    const PHOTOSWIPE_VERSION = '4.1.3';

    protected $videos = [];

    public function addVideo(VideoProviderInterface $video)
    {
        $video->setCssClass('pswp__video');
        $this->videos[] = $video;
    }

    public function getHtml()
    {
        $html = '
            <div class="container">
              <div class="photoswipe-wrapper">
                <div class="row">
        ';
        foreach ($this->videos as $video) {
            $title = $video->getTitle();
            $html .= '
                  <div class="col-md-3">
                      <figure class="photoswipe-item" role="group">
                      <a href="#" data-type="video" data-video=\'<div class="wrapper"><div class="video-wrapper">' . $video->getEmbedCode() . '</div></div>\'>
                        <img src="' . $video->getPreviewImage() . '" class="img-responsive">
                      </a>
                      ' . ($title ? '<figcaption>' . $title . '</figcaption>' : '' ) . '
                      </figure>
                  </div>
            ';
        }
        $html .= '
                </div>
              </div>
            </div>


            <div class="pswp" tabindex="-1" role="dialog" aria-hidden="true">

              <!-- Background of PhotoSwipe.
                         It\'s a separate element as animating opacity is faster than rgba(). -->
              <div class="pswp__bg"></div>

              <!-- Slides wrapper with overflow:hidden. -->
              <div class="pswp__scroll-wrap">

                <!-- Container that holds slides.
                            PhotoSwipe keeps only 3 of them in the DOM to save memory.
                            Don\'t modify these 3 pswp__item elements, data is added later on. -->
                <div class="pswp__container">
                  <div class="pswp__item"></div>
                  <div class="pswp__item"></div>
                  <div class="pswp__item"></div>
                </div>

                <!-- Default (PhotoSwipeUI_Default) interface on top of sliding area. Can be changed. -->
                <div class="pswp__ui pswp__ui--hidden">
                  <div class="pswp__top-bar">
                    <!--  Controls are self-explanatory. Order can be changed. -->
                    <div class="pswp__counter"></div>
                    <button class="pswp__button pswp__button--close" title="Close (Esc)"></button>
                    <button class="pswp__button pswp__button--share" title="Share"></button>
                    <button class="pswp__button pswp__button--fs" title="Toggle fullscreen"></button>
                    <button class="pswp__button pswp__button--zoom" title="Zoom in/out"></button>

                    <!-- Preloader demo https://codepen.io/dimsemenov/pen/yyBWoR -->
                    <!-- element will get class pswp__preloader--active when preloader is running -->
                    <div class="pswp__preloader">
                      <div class="pswp__preloader__icn">
                        <div class="pswp__preloader__cut">
                          <div class="pswp__preloader__donut"></div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="pswp__share-modal pswp__share-modal--hidden pswp__single-tap">
                    <div class="pswp__share-tooltip"></div>
                  </div>
                  <button class="pswp__button pswp__button--arrow--left" title="Previous (arrow left)">
                            </button>
                  <button class="pswp__button pswp__button--arrow--right" title="Next (arrow right)">
                            </button>
                  <div class="pswp__caption">
                    <div class="pswp__caption__center"></div>
                  </div>
                </div>
              </div>
            </div>
        ';
        
        return $html;
    }

    public function init()
    {
                wp_enqueue_script(
                    'photoswipe-lib',
                    plugin_dir_url( dirname(dirname(__FILE__)) ) . 'photoswipe/photoswipe.min.js',
                    array(),
                    self::PHOTOSWIPE_VERSION
                );
                wp_enqueue_script(
                    'photoswipe-ui-default',
                    plugin_dir_url( dirname(dirname(__FILE__)) ) . 'photoswipe/photoswipe-ui-default.min.js',
                    array('photoswipe-lib'),
                    self::PHOTOSWIPE_VERSION
                );
                wp_enqueue_script(
                    'photoswipe-video',
                    plugin_dir_url( dirname(dirname(__FILE__)) ) . 'photoswipe/photoswipe-video-loader.js',
                    array('photoswipe-lib'),
                    self::PHOTOSWIPE_VERSION
                );
                wp_enqueue_style(
                    'photoswipe-lib',
                    plugin_dir_url( dirname(dirname(__FILE__)) ) . 'photoswipe/photoswipe.css',
                    false,
                    self::PHOTOSWIPE_VERSION
                );
                wp_enqueue_style(
                    'photoswipe-video-css',
                    plugin_dir_url( dirname(dirname(__FILE__)) ) . 'photoswipe/photoswipe-video.css',
                    false,
                    self::PHOTOSWIPE_VERSION
                );
                wp_enqueue_style(
                    'photoswipe-default-skin',
                    plugin_dir_url( dirname(dirname(__FILE__)) ) . 'photoswipe/default-skin/default-skin.css',
                    false,
                    self::PHOTOSWIPE_VERSION
                );
    }
}
