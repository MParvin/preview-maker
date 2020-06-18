<?php

namespace Module\Application\FileSystem;

class Metadata
{
    private $mimeType;

    private $size;
    
    /**
     * Get the value of mimeType
     */ 
    public function getMimeType()
    {
        return $this->mimeType;
    }

    /**
     * Set the value of mimeType
     *
     * @return  self
     */ 
    public function setMimeType($mimeType)
    {
        $this->mimeType = $mimeType;

        return $this;
    }

    /**
     * Get the value of size
     */ 
    public function getSize()
    {
        return $this->size;
    }

    /**
     * Set the value of size
     *
     * @return  self
     */ 
    public function setSize($size)
    {
        $this->size = $size;

        return $this;
    }
}
