<?php

namespace Module\Application\Service;

use Module\Application\FileSystem\File;
use Module\Application\FileSystem\Types\Strategy;
use Module\Application\FileSystem\Types\Strategy\StrategyInterface;

class PreviewService
{
    /**
     * @var array
     */
    private $types = [
        Strategy\ImageStrategy::class,
        Strategy\DocumentStrategy::class,
        Strategy\PdfStrategy::class,
        Strategy\VideoStartegy::class,
    ];
    
    /**
     * @var string
     */
    private $filePath;
    
    /**
     * @var File
     */
    private $file;
    
    /**
     * @var StrategyInterface
     */
    protected $startegy;

    public function __construct($filePath = null)
    {
        if ($filePath) {
            $this->read($filePath);
        }
    }
    
    /**
     * Given a file it creates a File object holding the file metadata 
     *
     * @param  mixed $filePath
     * @return self
     */
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
    
    /**
     * Returns the file object
     *
     * @return File
     */
    public function getFile(): File
    {
        return $this->file;
    }
    
    /**
     * Create an image preview from the given file
     *
     * @return File
     * @throws Exception
     */
    public function preview($output = null)
    {
        if (!$this->file instanceof File) {
            throw new \Exception("No file has been selected.");
        }

        foreach ($this->types as $strategy) {
            $this->strategy = new $strategy($this->file);

            if ($this->strategy->match()) {
                return $this->strategy->preview($output);
            }
        }

        throw new \Exception("The file type is not supported.");
    }
}
