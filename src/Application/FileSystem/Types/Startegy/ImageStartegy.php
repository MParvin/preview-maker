<?php

namespace Module\Application\FileSystem\Types\Strategy;

use Module\Application\FileSystem\InputFile;

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

    public function __construct(InputFile $file)
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

    public function preview($output = null): InputFile
    {
        if (!$this->match()) {
            return $this->file->setPreview(null);
        }

        return $this->file->setPreview($this->file->getPath());
    }
}
