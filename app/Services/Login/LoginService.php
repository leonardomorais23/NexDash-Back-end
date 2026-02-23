<?php

namespace App\Services\Login;

use App\Exceptions\Auth\InvalidCredentialsException;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Facades\Auth;

class LoginService
{
    /**
     * @throws InvalidCredentialsException
     */
    public function execute(array $credentials): ?Authenticatable
    {
        if (!Auth::attempt($credentials)) {
            throw new InvalidCredentialsException();
        }

        return Auth::user();
    }
}
