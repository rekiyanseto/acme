<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class BusinessUnitUpdateRequest extends FormRequest
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
            'company_id' => ['required', 'exists:companies,id'],
            'business_unit_code' => [
                'required',
                Rule::unique('business_units', 'business_unit_code')->ignore(
                    $this->business_unit
                ),
                'max:255',
                'string',
            ],
            'business_unit_name' => ['required', 'max:255', 'string'],
            'business_unit_site_plan' => ['nullable', 'mimes:jpg,jpeg,png'],
        ];
    }
}
