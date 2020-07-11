<?php

namespace Module\Application\FileSystem\Types\Strategy;

use Module\Application\FileSystem\File;

interface StrategyInterface
{
    const TYPE_DOCUMENT = 'doc';
    const TYPE_PDF      = 'pdf';
    const TYPE_IMAGE    = 'image';
    const TYPE_AUDIO    = 'audio';
    const TYPE_VIDEO    = 'video';

    public function __construct(File $file);

    public function getType();

    public function match(): bool;

    public function preview(): File;
}
