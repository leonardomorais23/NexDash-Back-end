<?php

namespace App\Http\Requests\User;

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
            'id'            => ['required', 'int', 'exists:users,id'],
            'name'          => ['required', 'string', 'max:255'],
            'email'         => ['required', 'email', 'max:255', 'unique:users,email,' . $this->id],
            'roles'         => ['required', 'array'],
            'roles.*'       => ['string', 'exists:roles,name'],
            'permissions'   => ['array'],
            'permissions.*' => ['string', 'exists:permissions,name'],
        ];
    }
}
