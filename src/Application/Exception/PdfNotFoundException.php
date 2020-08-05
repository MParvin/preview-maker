<?php

namespace Module\Application\Exception;

use Exception;

class PdfNotFoundException extends Exception
{
    protected $message = 'The PDF file does not exist.';
}
