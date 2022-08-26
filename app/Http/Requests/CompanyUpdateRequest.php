<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class CompanyUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'company_code' => [
                'required',
                Rule::unique('companies', 'company_code')->ignore(
                    $this->company
                ),
                'max:255',
                'string',
            ],
            'company_name' => ['nullable', 'max:255', 'string'],
            'company_site_plan' => ['required', 'mimes:jpg,jpeg,png'],
        ];
    }
}
