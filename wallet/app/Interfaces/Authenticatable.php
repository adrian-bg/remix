<?php

namespace App\Interfaces;

use Illuminate\Http\Request;
use App\Helpers\AuthenticatedUserData;

interface Authenticatable
{
    public function authenticate(Request $request);

    public function setUserData(array $data);

    public function getUserData(): ?AuthenticatedUserData;
}
