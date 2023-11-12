<?php

namespace App\Exceptions;

use Exception;

class CardRepositoryException extends Exception
{
    /*
    |--------------------------------
    | Card exception error codes
    |--------------------------------
    |
    | Card codes format 2***
    */

    public const CARD_NOT_FOUND_CODE = 2004;
}
