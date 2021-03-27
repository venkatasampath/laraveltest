<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;


class HaplogroupRequest extends FormRequest
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
            'type' => ['required', Rule::exists('haplogroups', 'type')],
            'letter' => 'required|regex:/^[A-Z{1}]$/',
            'subgroup' => 'nullable',
            'ancestry' => ['nullable', Rule::exists('haplogroups', 'ancestry')],
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
            'letter.regex' => trans('validation.letterOnly'),
        ];
    }
}