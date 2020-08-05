<?php

namespace Module\Application\Service;

use Module\Application\FileSystem\InputFile;
use Module\Application\FileSystem\Types\Strategy;
use Module\Application\FileSystem\Types\Strategy\StrategyInterface;
use Symfony\Component\Console\Exception\RuntimeException;

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
     * @var InputFile
     */
    private $file;
    
    /**
     * @var StrategyInterface
     */
    protected $startegy;

    /**
     * @var array
     */
    protected $options;

    public function __construct($options = [])
    {
        $this->options = $options;
    }

    public function setFile($filePath)
    {
        if ($filePath) {
            $this->read($filePath);
        }

        return $this;
    }
    
    /**
     * Given a file it creates an InputFile object holding the file metadata 
     *
     * @param  mixed $filePath
     * @return self
     */
    public function read($filePath)
    {
        $this->file = new InputFile($filePath);

        return $this;
    }
    
    /**
     * Returns the file object
     *
     * @return InputFile
     */
    public function getFile(): InputFile
    {
        return $this->file;
    }
    
    /**
     * Create an image preview from the given file
     *
     * @return InputFile
     * @throws RuntimeException
     */
    public function preview($output = null)
    {
        if (!$this->file instanceof InputFile) {
            throw new RuntimeException("Error: No file has been selected.");
        }

        $output = !$output && isset($this->options['TmpDir']) ? $this->options['TmpDir'] : $output;
        
        if (!$output) {
            throw new RuntimeException("Error: Invalid output path.");
        }

        foreach ($this->types as $strategy) {
            $this->strategy = new $strategy($this->file);

            if ($this->strategy->match()) {
                return $this->strategy->preview($output);
            }
        }

        throw new RuntimeException(sprintf("Error: Unsupported file type! The mime type %s is not supported.", $this->file->getMetadata()->getMimeType()));
    }
}
