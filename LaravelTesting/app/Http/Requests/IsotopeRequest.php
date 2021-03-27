<?php

/**
 * Isotope Request
 *
 * @category   IsotopeElement
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


class IsotopeRequest extends FormRequest
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
            'se_id' => 'sometimes|required|exists:skeletal_elements,id',
            'sb_id' => 'sometimes|required|exists:skeletal_elements,sb_id',
            'org_id' => 'sometimes|required|exists:orgs,id',
            'project_id' => 'sometimes|required|exists:projects,id',
            'lab_id' => 'sometimes|required|exists:labs,id',
            'batch_id' => 'sometimes|required|exists:isotope_batches,id',
            'sample_number' => 'sometimes|required|regex:/^[a-zA-Z0-9.-]+$/i',
            'external_case_id' => 'nullable| alpha_num',
            'results_confidence' => ['nullable', Rule::in(['Pending', 'Reportable', 'Inconclusive', 'Unable to Assign', 'Cancelled', 'No Results'])],
            'weight_sample_cleaned' => 'nullable|numeric',
            'weight_vial_lid' => 'nullable|numeric',
            'weight_sample_vial_lid' => 'nullable|numeric',
            'weight_collagen' => 'nullable|numeric',
            'yield_collagen' => 'nullable|numeric',
            'demineralizing_start_date' => 'nullable|date',
            'demineralizing_end_date' => 'nullable|date',
            'analysis_requested' => 'nullable|alpha_num',
            'well_location' => 'nullable|alpha_num',
            'collagen_weight_used_for_analysis' => 'nullable|numeric',
            'c_weight' => 'nullable|numeric',
            'n_weight' => 'nullable|numeric',
            'o_weight' => 'nullable|numeric',
            's_weight' => 'nullable|numeric',
            'c_delta' => 'nullable|numeric',
            'n_delta' => 'nullable|numeric',
            'o_delta' => 'nullable|numeric',
            's_delta' => 'nullable|numeric',
            'c_percent' => 'nullable|numeric',
            'n_percent' => 'nullable|numeric',
            'o_percent' => 'nullable|numeric',
            's_percent' => 'nullable|numeric',
            'c_to_n_ratio' => 'nullable|numeric',
            'c_to_o_ratio' => 'nullable|numeric',
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
            'sample_number.regex' => trans('validation.alpha_num_dash_space_dot'),

        ];
    }
}
