<?php

namespace Module\Application\FileSystem\Types\Strategy;

use Module\Application\FileSystem\File;

class ImageStrategy implements StrategyInterface
{
    protected $file;

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
        $mimeType = $this->file->getMetadata()->getMimeType();
        
        return false;
    }

    public function preview(): ?string
    {
        if (!$this->match()) {
            return null;
        }

        
    }
}
