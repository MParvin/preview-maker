<?php

namespace Module\Application\FileSystem\Types\Strategy;

use Module\Application\FileSystem\InputFile;
use Module\Application\FileSystem\OutputFile;

class AudioStrategy extends AbsractConvertor implements StrategyInterface
{
    private $validMimeTypes = [
        "audio/mp4",
        "audio/mpeg",
        "audio/ogg",
        "audio/wav",
        "audio/webm",
        "audio/x-ms-wma"
    ];

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

    public function preview($output): ?OutputFile
    {
        if (!$this->match()) {
            return null;
        }

        return null;
    }

    public function toPdf($output): ?OutputFile
    {
        return null;
    }
}
