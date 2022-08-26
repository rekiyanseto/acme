<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class EquipmentUpdateRequest extends FormRequest
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
            'sub_area_id' => ['required', 'exists:sub_areas,id'],
            'equipment_code' => [
                'required',
                Rule::unique('equipment', 'equipment_code')->ignore(
                    $this->equipment
                ),
                'max:255',
                'string',
            ],
            'equipment_name' => ['required', 'max:255', 'string'],
            'maintenance_by' => ['nullable', 'max:255', 'string'],
            'equipment_description' => ['nullable', 'max:255', 'string'],
        ];
    }
}
