<?php

namespace Module\Application\FileSystem\Types\Strategy;

use Module\Application\FileSystem\File;

class DocumentStrategy implements StrategyInterface
{
    protected $file;

    private $validMimeTypes = [
        "application/vnd.openxmlformats-officedocument.wordprocessingml.document",
        "application/vnd.ms-excel",
        "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet",
        "application/vnd.ms-powerpoint",
        "application/vnd.openxmlformats-officedocument.presentationml.presentation",
    ];

    public function __construct(File $file)
    {
        $this->file = $file;
    }

    public function getType()
    {
        return self::TYPE_DOCUMENT;
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
