<?php

namespace App\Http\Requests\Dashboard;

use Illuminate\Foundation\Http\FormRequest;

class UpdateDashRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->hasRole('admin') ?? false;
    }

    public function rules(): array
    {
        return [
            'name'  => ['required', 'string', 'max:255'],
            'status' => ['required', 'string', 'in:ativo,inativo'],
        ];
    }
}
