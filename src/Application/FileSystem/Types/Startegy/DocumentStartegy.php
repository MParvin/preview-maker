<?php

namespace Module\Application\FileSystem\Types\Strategy;

use Module\Application\FileSystem\OutputFile;
use Module\Application\Service\PdfService as Pdf;
use Symfony\Component\Console\Exception\RuntimeException;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

class DocumentStrategy extends AbsractConvertor implements StrategyInterface
{
    private $validMimeTypes = [
        "application/msword",
        "application/vnd.openxmlformats-officedocument.wordprocessingml.document",
        "application/vnd.ms-excel",
        "application/vnd.ms-powerpoint",
        "application/vnd.oasis.opendocument.spreadsheet",
        "application/vnd.oasis.opendocument.text",
        "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet",
        "application/vnd.openxmlformats-officedocument.presentationml.presentation",
    ];

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

    public function preview($output): ?OutputFile
    {
        if (!$this->match()) {
            return null;
        }

        $outputFile = $this->toPdf($output);
        $pdf        = new Pdf($outputFile->getPath());
        $preview    = $pdf->saveImage($output);

        $outputFile->unlink();  // Remove PDF file

        return $preview ? new OutputFile($preview) : null;
    }

    public function toPdf($output): ?OutputFile
    {
        $output = rtrim($output, '\/') . DIRECTORY_SEPARATOR;

        $command = 'libreoffice --headless --invisible --convert-to pdf ' . $this->file->getPath() . ' --outdir '. $output;
        $process = Process::fromShellCommandline($command);
        $process->run();

        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }

        if ($process->getErrorOutput()) {
            throw new RuntimeException($process->getErrorOutput());
        }

        return new OutputFile($output . $this->file->getName() . '.pdf');
    }
}
