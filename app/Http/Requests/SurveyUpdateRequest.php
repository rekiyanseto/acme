<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SurveyUpdateRequest extends FormRequest
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
            'survey_period_id' => ['required', 'exists:survey_periods,id'],
            'sub_category_id' => ['required', 'exists:sub_categories,id'],
            'sub_area_id' => ['nullable', 'exists:sub_areas,id'],
            'equipment_id' => ['nullable', 'exists:equipment,id'],
        ];
    }
}
