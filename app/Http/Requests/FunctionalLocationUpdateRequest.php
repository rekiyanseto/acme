<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class FunctionalLocationUpdateRequest extends FormRequest
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
            'business_unit_id' => ['required', 'exists:business_units,id'],
            'functional_location_code' => [
                'required',
                Rule::unique(
                    'functional_locations',
                    'functional_location_code'
                )->ignore($this->functional_location),
                'max:255',
                'string',
            ],
            'functional_location_name' => ['required', 'max:255', 'string'],
            'functional_location_site_plan' => [
                'nullable',
                'mimes:jpg,jpeg,png',
            ],
        ];
    }
}
