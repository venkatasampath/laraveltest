<?php

/**
 * SkeletalElement Request
 *
 * @category   SkeletalElement
 * @package    CoRA-Requests
 * @author     Sachin Pawaskar<spawaskar@unomaha.edu>
 * @copyright  2016-2018
 * @license    The MIT License (MIT)
 * @version    GIT: $Id$
 * @since      File available since Release 1.0.0
 */

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SkeletalElementRequest extends FormRequest
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
            'accession_number'          => 'required|min:3|regex:/^[a-zA-Z0-9 -]+$/i',
            'provenance1'               => 'nullable|regex:/^[a-zA-Z0-9 -]+$/i',
            'provenance2'               => 'nullable|regex:/^[a-zA-Z0-9 -]+$/i',
            'designator'                => 'required|alpha_num',
            'individual_number'         => 'nullable|regex:/^[a-zA-Z0-9\s.-]+$/i',
            'side'                      => ['required', Rule::in(['Left', 'Right', 'Middle', 'Unsided'])],
            'completeness'              =>  ['required', Rule::in(['Complete', 'Incomplete'])],
            'measured'                  =>  'nullable|boolean',
            'dna_sampled'               =>  'nullable|boolean',
            'ct_scanned'                =>  'nullable|boolean',
            'xray_scanned'              =>  'nullable|boolean',
            'clavicle_triage'           =>  'nullable|boolean',
            'inventoried'               =>  'nullable|boolean',
            'reviewed'                  =>  'nullable|boolean',
            'consolidated_an'           =>  'nullable|alpha',
            'isotope_sampled'           => 'nullable|boolean',
            'count'                     => 'nullable|integer',
            'mass'                      => 'nullable|numeric',
            'bone_group'                => 'nullable|alpha',
            'bone_group_id'             => 'nullable|uuid',
            'remains_status'            => ['nullable', Rule::in(['In Lab', 'Released'])],
            'inventoried_by_id'         => 'nullable|integer'
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'accession_number.regex' => trans('validation.alpha_num_dash_space'),
            'provenance1.regex' => trans('validation.alpha_num_dash_space'),
            'provenance2.regex' => trans('validation.alpha_num_dash_space'),
            'individual_number.regex' => trans('validation.alpha_num_dash_space')
        ];
    }
}
