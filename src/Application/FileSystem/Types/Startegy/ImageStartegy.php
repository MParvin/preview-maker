<?php

namespace Module\Application\FileSystem\Types\Strategy;

use Module\Application\FileSystem\File;

class ImageStrategy implements StrategyInterface
{
    protected $file;

    private $validMimeTypes = [
        "image/png",
        "image/jpeg",
        "image/gif",
        "image/psd",
        "image/bmp",
    ];

    public function __construct(File $file)
    {
        $this->file = $file;
    }

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

    public function preview(): File
    {
        if (!$this->match()) {
            return $this->file->setPreview(null);
        }

        return $this->file->setPreview($this->file->getPath());
    }
}
