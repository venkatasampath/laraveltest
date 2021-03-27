<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;


class ProjectRequest extends FormRequest
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
        return [
            'name' => 'sometimes|required|min:3|max:50|regex:/^[a-zA-Z0-9 -]+$/i',
            'status_id' => 'required|numeric',
            'description'  => 'required|min:3|max:255',
            'public' => 'nullable|boolean',
            'manager_id' => 'required|numeric',
            'geo_lat' => 'required|numeric',
            'geo_long' => 'required|numeric',
            'start_date' => 'required|date',
            'allow_user_accession_create' => 'nullable|boolean',
            'slack_channel' => 'nullable|alpha_num',
            'uses_isotope_analysis' => 'nullable|boolean',
            'zones_autocomplete' => 'nullable|boolean',
            'latest_mcc_date' => 'nullable|date'
        ];
    }
}