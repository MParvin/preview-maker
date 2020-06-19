<?php

namespace Module\Application\FileSystem\Types\Strategy;

use Module\Application\FileSystem\File;

class AudioStrategy implements StrategyInterface
{
    protected $file;

    private $validMimeTypes = [
        "audio/mp4",
        "audio/mpeg",
        "audio/ogg",
        "audio/wav",
        "audio/webm",
        "audio/x-ms-wma"    
    ];

    public function __construct(File $file)
    {
        $this->file = $file;
    }
    
    public function getType()
    {
        return self::TYPE_AUDIO;
    }

    public function match(): bool
    {
        if (in_array($this->file->getMetadata()->getMimeType(), $this->validMimeTypes)) {
            return true;
        }

        return false;
    }

    public function preview(): File
    {
        if (!$this->match()) {
            return $this->file;
        }

        
    }
}
