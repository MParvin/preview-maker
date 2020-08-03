<?php

namespace Module\Application\FileSystem\Types\Strategy;

use Module\Application\FileSystem\InputFile;

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

    public function __construct(InputFile $file)
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

    public function preview($output = null): InputFile
    {
        if (!$this->match()) {
            return $this->file;
        }
    }
}
