<?php

namespace App\Exceptions;

use Exception;

class PaymentException extends Exception
{

    /*
    |--------------------------------
    | Payment exception error codes
    |--------------------------------
    |
    | Payment codes format 1***
    */

    public const INCORRECT_TRANSACTION_TYPE = 1000;
}
