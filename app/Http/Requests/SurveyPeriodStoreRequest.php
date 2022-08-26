<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class SurveyPeriodStoreRequest extends FormRequest
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
            'periode_name' => [
                'required',
                'unique:survey_periods,periode_name',
                'max:255',
                'string',
            ],
            'periode_description' => ['required', 'max:255', 'string'],
            'periode_status' => ['required', 'max:255', 'string'],
        ];
    }
}
