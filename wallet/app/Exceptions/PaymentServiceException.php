<?php

namespace App\Exceptions;

use Exception;

class PaymentServiceException extends Exception
{
    /*
    |--------------------------------
    | Payment exception error codes
    |--------------------------------
    |
    | Payment codes format 3***
    */

    public const COMMUNICATION_ERROR_CODE = 3000;
    public const COMPLETE_TRANSACTION_NOT_FOUND_CODE = 3004;
    public const INCORRECT_TRANSACTION_TYPE_CODE = 3022;

}
