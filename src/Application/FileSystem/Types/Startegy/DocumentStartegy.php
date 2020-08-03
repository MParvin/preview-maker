<?php

namespace Module\Application\FileSystem\Types\Strategy;

use Module\Application\FileSystem\InputFile;
use Module\Application\Service\PdfService as Pdf;
use Symfony\Component\Console\Exception\RuntimeException;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

class DocumentStrategy implements StrategyInterface
{
    protected $file;

    private $validMimeTypes = [
        "application/vnd.openxmlformats-officedocument.wordprocessingml.document",
        "application/vnd.ms-excel",
        "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet",
        "application/vnd.ms-powerpoint",
        "application/vnd.openxmlformats-officedocument.presentationml.presentation",
        "application/vnd.oasis.opendocument.text",
    ];

    public function __construct(InputFile $file)
    {
        $this->file = $file;
    }

    public function getType()
    {
        return self::TYPE_DOCUMENT;
    }

    public function match(): bool
    {
        if (in_array($this->file->getMetadata()->getMimeType(), $this->validMimeTypes)) {
            return true;
        }

        return false;
    }

    public function preview($output = null): InputFile
    {
        if (!$this->match()) {
            return $this->file;
        }

        $tmp     = $this->file->getTmpDir() . time();
        $command = 'libreoffice --headless --invisible --convert-to pdf ' . $this->file->getPath() . ' --outdir '. $tmp;
        $process = Process::fromShellCommandline($command);
        $process->run();
        
        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }
        
        if ($process->getErrorOutput()) {
            throw new RuntimeException($process->getErrorOutput());
        }
        
        if (!$output) {
            $output = $this->file->getTmpDir();
        }
        
        $pdf     = new Pdf($tmp . DIRECTORY_SEPARATOR . $this->file->getName() . '.pdf');
        $preview = $pdf->saveImage($output);
        
        return  $this->file->setPreview($preview ? $preview : null);
    }
}
