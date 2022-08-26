<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class AreaStoreRequest extends FormRequest
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
            'functional_location_id' => [
                'required',
                'exists:functional_locations,id',
            ],
            'area_code' => [
                'required',
                'unique:areas,area_code',
                'max:255',
                'string',
            ],
            'area_name' => ['required', 'max:255', 'string'],
            'area_site_plan' => ['nullable', 'mimes:jpg,jpeg,png'],
        ];
    }
}
