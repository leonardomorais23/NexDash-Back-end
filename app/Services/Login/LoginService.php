<?php

namespace App\Services\Login;

use App\Exceptions\Auth\InvalidCredentialsException;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class LoginService
{
    /**
     * @param array $credentials
     * @return User
     * @throws InvalidCredentialsException
     */
    public function execute(array $credentials): User
    {
        if (!Auth::attempt($credentials)) {
            throw new InvalidCredentialsException();
        }

        /** @var User $user */
        $user = Auth::user();

        return $user;
    }
}
