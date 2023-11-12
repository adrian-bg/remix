<?php

namespace App\Exceptions;

use Exception;

class AccountRepositoryException extends Exception
{

    /*
    |--------------------------------
    | Account exception error codes
    |--------------------------------
    |
    | Account codes format 1***
    */

    public const INSUFFICIENT_FUNDS_CODE = 1000;
    public const ACCOUNT_NOT_FOUND_CODE = 1004;
}
