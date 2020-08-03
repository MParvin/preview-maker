<?php

namespace Module\Application\FileSystem\Types\Strategy;

use FFMpeg\Coordinate\TimeCode;
use FFMpeg\FFMpeg;
use Module\Application\FileSystem\InputFile;

class VideoStartegy implements StrategyInterface
{
    protected $file;

    private $validMimeTypes = [
        "video/3gpp",
        "video/mp4",
        "video/mpeg",
        "video/ogg",
        "video/quicktime",
        "video/webm",
        "video/x-m4v",
        "video/ms-asf",
        "video/x-ms-asf",
        "video/x-ms-wmv",
        "video/x-msvideo"
    ];

    public function __construct(InputFile $file)
    {
        $this->file = $file;
    }

    public function getType()
    {
        return self::TYPE_VIDEO;
    }

    public function match(): bool
    {
        if (in_array($this->file->getMetadata()->getMimeType(), $this->validMimeTypes)) {
            return true;
        }

        return false;
    }

    public function preview($output = null): InputFile
    {
        if (!$this->match()) {
            return $this->file;
        }

        if (!$output) {
            $output = $this->file->getTmpDir();
        }
        
        $output = rtrim($output, '\/') . DIRECTORY_SEPARATOR . time() . '.jpg';
        $ffmpeg = FFMpeg::create();
        $video  = $ffmpeg->open($this->file->getPath());
        
        try {
            $result = $video->frame(TimeCode::fromSeconds(1))->save($output);

            $this->file->setPreview($output);
        } catch (\Throwable $th) {
            $this->file->setPreview(null);
        }

        return $this->file;
    }
}
