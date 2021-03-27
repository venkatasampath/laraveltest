<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AccessionRequest extends FormRequest
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
     * Validation rules for Project fields
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'org_id' => 'sometimes|required| exists:orgs,id',
            'project_id' => 'sometimes|required|exists:projects,id',
            'number' => 'required|regex:/^[a-zA-Z0-9 -]+$/i',
            'provenance1' => 'nullable|regex:/^[a-zA-Z0-9 -]+$/i',
            'provenance2' => 'nullable|regex:/^[a-zA-Z0-9 -]+$/i',
            'consolidated_an' => 'nullable|boolean',
            'geo_lat' => 'nullable|numeric',
            'geo_long' => 'nullable|numeric',
            'event_date' => 'nullable|date'
        ];

        return $rules;
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'number.regex' => trans('validation.alpha_num_dash_space'),
            'provenance1.regex' => trans('validation.alpha_num_dash_space'),
            'provenance2.regex' => trans('validation.alpha_num_dash_space'),
        ];
    }
}