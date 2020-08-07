<?php

namespace Module\Application\FileSystem;

interface FileInterface 
{
    public function getName();

    public function getExtension();

    public function getPath();

    public function getDir();

    public function getMetadata(): Metadata;

    public function unlink();
}