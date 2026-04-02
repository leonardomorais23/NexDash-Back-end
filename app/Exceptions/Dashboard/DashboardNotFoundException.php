<?php

namespace App\Exceptions\Dashboard;
use Symfony\Component\HttpKernel\Exception\HttpException;

class DashboardNotFoundException extends HttpException
{
    public function __construct($message = null, \Throwable $previous = null, array $headers = [], $code = 0)
    {
        parent::__construct(404, $message, $previous, $headers, $code);
    }
}
