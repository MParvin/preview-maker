<?php

namespace Module\Application\FileSystem\Types\Strategy;

use Module\Application\FileSystem\InputFile;

class AbsractConvertor
{
    /**
     * @var InputFile
     */
    protected $file;

    public function __construct(InputFile $file)
    {
        $this->file = $file;
    }
}
