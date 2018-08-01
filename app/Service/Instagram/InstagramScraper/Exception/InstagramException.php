<?php

namespace App\Service\Instagram\InstagramScraper\Exception;

class InstagramException extends \Exception
{
    public function __construct($message = "", $code = 500, $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}