<?php

namespace App\Http\Requests\CompanyRequests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCompanyRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        $companyId = $this->route('id');

        return [
            'name'    => ['sometimes', 'string', 'max:255', "unique:companies,name,{$companyId}"],
            'email'   => ['sometimes', 'email', "unique:companies,email,{$companyId}"],
            'phone'   => ['nullable', 'string', 'max:20'],
            'address' => ['nullable', 'string', 'max:500'],
        ];
    }
}