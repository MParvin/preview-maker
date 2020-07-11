<?php

namespace Module\Application\Service;

use FFMpeg\FFMpeg;

class ffmpegService
{
    protected $file;

    public function open($filePath)
    {
        $ffmpeg     = FFMpeg::create();
        $this->file = $ffmpeg->open($filePath);

        return $this;
    }

    public function isVideo()
    {
    }

    public function isAudio()
    {
    }
}
