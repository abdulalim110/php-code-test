<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class IndexUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'search' => ['nullable', 'string', 'max:100'],
            'page'   => ['nullable', 'integer', 'min:1'],
            
            'sortBy' => [
                'nullable', 
                'string', 
                Rule::in(['name', 'email', 'created_at'])
            ],
            
            'sortDirection' => ['nullable', 'string', Rule::in(['asc', 'desc'])],
        ];
    }
}