<?php

namespace Module\Application\FileSystem;

use Symfony\Component\Mime\MimeTypes;

class InputFile
{
    private $name;

    private $extension;

    private $path;

    private $dir;

    private $metadata;

    private $preview;

    private $tmpDir = '/tmp/preview-maker/';

    public function __construct($filePath = null)
    {
        if (!is_file($filePath)) {
            throw new \Exception("Invalid file path");
        }
        
        $this->readFile($filePath);     // Extract file data
        $this->setTmpDir();             // Create default temp directory 
    }

    private function readFile($filePath)
    {
        $mimeTypes = new MimeTypes();
        $mimeType  = $mimeTypes->guessMimeType($filePath);
        $pathInfo  = pathinfo($filePath);

        $this->setName($pathInfo['filename']);
        $this->setExtension($pathInfo['extension']);
        $this->setDir($pathInfo['dirname']);
        $this->setPath($filePath);

        $metadata = $this->getMetadata();
        $metadata
            ->setMimeType($mimeType)
            ->setSize(filesize($filePath));
        $this->setMetadata($metadata);
    }

    /**
     * Get the value of name
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set the value of name
     *
     * @return self
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get the value of extension
     */
    public function getExtension()
    {
        return $this->extension;
    }

    /**
     * Set the value of extension
     *
     * @return self
     */
    public function setExtension($extension)
    {
        $this->extension = $extension;

        return $this;
    }

    /**
     * Get the value of path
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * Set the value of path
     *
     * @return self
     */
    public function setPath($path)
    {
        $this->path = $path;

        return $this;
    }

    /**
     * Get the value of dir
     */
    public function getDir()
    {
        return $this->dir;
    }

    /**
     * Set the value of dir
     *
     * @return self
     */
    public function setDir($dir)
    {
        $this->dir = $dir;

        return $this;
    }

    /**
     * Get the value of metadata
     */
    public function getMetadata(): Metadata
    {
        if ($this->metadata instanceof Metadata) {
            return $this->metadata;
        }

        return new Metadata;
    }

    /**
     * Set the value of metadata
     *
     * @return self
     */
    public function setMetadata(Metadata $metadata)
    {
        $this->metadata = $metadata;

        return $this;
    }

    /**
     * Get the value of preview
     */
    public function getPreview()
    {
        return $this->preview;
    }

    /**
     * Set the value of preview
     *
     * @return self
     */
    public function setPreview($preview)
    {
        $this->preview = $preview;

        return $this;
    }

    /**
     * Get the value of tmpDir
     */ 
    public function getTmpDir()
    {
        if ($this->tmpDir) {
            $this->tmpDir = rtrim($this->tmpDir, '\/') . DIRECTORY_SEPARATOR;
        }
        
        return $this->tmpDir;
    }

    /**
     * Set the value of tmpDir
     *
     * @return  self
     */ 
    public function setTmpDir($tmpDir = null)
    {
        if (is_null($tmpDir)) {
            $tmpDir = $this->tmpDir;
        }

        $tmpDir = rtrim($tmpDir, '\/') . DIRECTORY_SEPARATOR;
        if (!is_dir($tmpDir)) {
            if (mkdir($tmpDir)) {
                $this->tmpDir = $tmpDir;
            } else {
                throw new \Exception(sprintf("Cannot create temp directory at %s", $tmpDir));
            }
        }

        return $this;
    }
}