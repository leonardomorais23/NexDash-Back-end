<?php

namespace App\Http\Requests\Settings;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->hasRole('admin') ?? false;
    }

    public function rules(): array
    {
        return [
            'id' => ['required', 'integer', 'exists:users,id'],
            'name'  => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'role'  => ['required', 'string'],
        ];
    }
}
