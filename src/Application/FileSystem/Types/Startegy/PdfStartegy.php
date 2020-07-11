<?php

namespace Module\Application\FileSystem\Types\Strategy;

use Module\Application\FileSystem\File;

class PdfStrategy implements StrategyInterface
{
    protected $file;

    private $validMimeTypes = [
        "application/pdf",
    ];

    public function __construct(File $file)
    {
        $this->file = $file;
    }

    public function getType()
    {
        return self::TYPE_PDF;
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
