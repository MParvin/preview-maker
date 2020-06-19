<?php

namespace Module\Application\Service;

use Module\Application\FileSystem\File;
use Module\Application\FileSystem\Types\Strategy;

class PreviewService
{
    private $types;

    private $filePath;

    private $file;

    protected $startegy;

    public function  __construct($filePath = null)
    {
        if ($filePath)
        {
            $this->read($filePath);
        }
        
        $this->types = [
            Strategy\ImageStrategy::class,
            Strategy\DocumentStrategy::class,
            Strategy\PdfStrategy::class,
            Strategy\AudioStrategy::class,
            Strategy\VideoStartegy::class,
        ]; 
    }

    public function read($filePath = null)
    {
        if ($filePath) {
            $this->filePath = $filePath;
        }

        if (!is_readable($this->filePath)) {
            throw new \InvalidArgumentException(sprintf("The file '%s' is not readable.", $this->filePath));
        }

        $this->file = new File($this->filePath);

        return $this;
    }

    public function getFile(): File
    {
        return $this->file;
    }

    public function preview()
    {
        if (!$this->file instanceof File) {
            throw new \Exception("No file has been selected.");
        }

        foreach ($this->types as $strategy)
        {
            $this->strategy = new $strategy($this->file);

            if ($this->strategy->match()) {
                return $this->strategy->preview();
            }
        }

        throw new \Exception("The file type is not supported.");
    }
}
