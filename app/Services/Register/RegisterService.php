<?php

namespace App\Services\Register;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RegisterService
{
    public function execute(array $data): User
    {
        $data['password'] = Hash::make($data['password']);

        return User::create($data);
    }

}
