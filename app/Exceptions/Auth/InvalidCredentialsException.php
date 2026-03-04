<?php

namespace App\Exceptions\Auth;

use Symfony\Component\HttpKernel\Exception\HttpException;

class InvalidCredentialsException extends HttpException
{
    public function __construct(
        string $message = 'Credenciais inválidas.'
    ) {
        parent::__construct(401, $message);
    }
}
