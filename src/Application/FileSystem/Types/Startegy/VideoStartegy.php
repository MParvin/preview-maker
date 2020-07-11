<?php

namespace Module\Application\FileSystem\Types\Strategy;

use Module\Application\FileSystem\File;

class VideoStartegy implements StrategyInterface
{
    protected $file;

    public function __construct(File $file)
    {
        $this->file = $file;
    }

    public function getType()
    {
        return self::TYPE_VIDEO;
    }

    public function match(): bool
    {
        return false;
    }

    public function preview(): ?string
    {
        if (!$this->match()) {
            return null;
        }
    }
}
