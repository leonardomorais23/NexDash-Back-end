<?php

namespace App\Http\Requests\Dashboard;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class ShowDashboardRequest extends FormRequest
{
    public function authorize(): bool
    {
        $id = $this->route('id');

        return Auth::user()?->can("dashboard:{$id}:read") ?? false;
    }

    public function rules(): array
    {
        return [];
    }
}
