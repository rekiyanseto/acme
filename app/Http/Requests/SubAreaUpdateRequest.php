<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class SubAreaUpdateRequest extends FormRequest
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
            'area_id' => ['required', 'exists:areas,id'],
            'sub_area_code' => [
                'required',
                Rule::unique('sub_areas', 'sub_area_code')->ignore(
                    $this->sub_area
                ),
                'max:255',
                'string',
            ],
            'sub_area_name' => ['required', 'max:255', 'string'],
            'maintenance_by' => ['nullable', 'max:255', 'string'],
            'sub_area_description' => ['nullable', 'max:255', 'string'],
            'sub_area_site_plan' => ['nullable', 'mimes:jpg,jpeg,png'],
        ];
    }
}
