<?php

namespace Module\Application\FileSystem\Types\Strategy;

use Module\Application\FileSystem\OutputFile;
use Module\Application\Service\PdfService as Pdf;

class PdfStrategy extends AbsractConvertor implements StrategyInterface
{
    private $validMimeTypes = [
        "application/pdf",
    ];

    public function getType()
    {
        return self::TYPE_PDF;
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

        $pdf     = new Pdf($this->file->getPath());
        $preview = $pdf->saveImage($output);

        return $preview ? new OutputFile($preview) : null;
    }

    public function toPdf($output): ?OutputFile
    {
        return new OutputFile($this->file->getPath());
    }
}
