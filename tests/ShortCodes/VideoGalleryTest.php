<?php

class VideoGalleryTest extends TestCase
{
    public function testInitVideoProviders()
    {
        $videoGallery = $this->createPartialMock(Coderey\VideoLinkGallery\Shortcodes\VideoGallery::class, []);
        $this->invokeMethod($videoGallery, '_initVideoProviders');
        $videoProviders = $videoGallery->getVideoProviders();
        
        $this->assertArrayHasKey('yt', $videoProviders);
        $this->assertArrayHasKey('youtube', $videoProviders);
        $this->assertArrayHasKey('vimeo', $videoProviders);
        $this->assertArrayHasKey('link', $videoProviders);
    }
}
