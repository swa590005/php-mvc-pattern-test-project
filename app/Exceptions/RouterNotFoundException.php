<?php

namespace App\Exceptions;

class RouterNotFoundException extends \Exception
{
   protected $message = "404 Route not found";
}