<?php

namespace Module\Application\Exception;

use Exception;

class PageDoesNotExistException extends Exception
{
    protected $message = 'Invalid page number.';
}