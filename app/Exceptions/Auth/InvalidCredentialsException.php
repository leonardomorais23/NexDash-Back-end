<?php
namespace App\Exceptions\Auth;

use Exception;

class InvalidCredentialsException extends Exception
{
    protected $message = 'Credenciais inválidas.';
    protected $code = 401;
}
