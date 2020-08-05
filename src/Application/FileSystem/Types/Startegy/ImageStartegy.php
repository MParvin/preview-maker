<?php

namespace Module\Application\FileSystem\Types\Strategy;

use Module\Application\FileSystem\OutputFile;

class ImageStrategy extends AbsractConvertor implements StrategyInterface
{
    private $validMimeTypes = [
        "image/png",
        "image/jpeg",
        "image/gif",
        "image/psd",
        "image/bmp",
    ];

    public function getType()
    {
        return self::TYPE_IMAGE;
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

        return new OutputFile($this->file->getPath());
    }

    public function toPdf($output): ?OutputFile
    {
        return null;
    }
}
