<?php

namespace App\Exceptions;

class ViewNotFoundException extends \Exception
{
    protected $message = "404 View not found";
}