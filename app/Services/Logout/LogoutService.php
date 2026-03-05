<?php

namespace App\Services\Logout;

use Illuminate\Support\Facades\Auth;

class LogoutService
{
    public function execute(): void
    {
        Auth::guard('web')->logout();
    }
}
