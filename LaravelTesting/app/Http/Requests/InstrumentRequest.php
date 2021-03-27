<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InstrumentRequest extends FormRequest
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
            'org_id' => 'sometimes|required|exists:orgs,id',
            'code' => 'required|max:255',
            'category' => 'required|max:255',
            'module'  => 'required|max:255',
            'reference'  => 'max:255',
            'active' => 'boolean',
            'userlist' => 'nullable|exists:users,id'
        ];

        return $rules;
    }
}