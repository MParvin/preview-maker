<?php

namespace Module\Application\Exception;

use Exception;

class InvalidFormatException extends Exception
{
    protected $message = 'The file format is not supported.';
}