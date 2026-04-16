<?php

namespace App\Services\Register;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class RegisterService
{
    public function execute(array $data): User
    {
        return DB::transaction(function () use ($data) {
            $data['password'] = Hash::make($data['password']);
            $user = User::create($data);
            $user->assignRole('colaborador');

            return $user;
        });
    }
}
