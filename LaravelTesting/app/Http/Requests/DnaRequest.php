<?php

/**
 * Dna Request
 *
 * @category   DnaElement
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

class DnaRequest extends FormRequest
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
            'external_case_id' => 'nullable| alpha_num',
            'sample_number' => 'required|regex:/^[a-zA-Z0-9.-]+$/i',
            'priority' => 'nullable|alpha_num_dash_space_dot',
            'analysis_type_id' => 'nullable|exists:dna_analysis_types,id',
            'external_sample_number' => 'nullable|alpha_num_dash_space',
            'dispostion_of_evidence' => 'nullable|alpha_num',
            'additional_testing' => 'nullable|boolean',
            'priority_date' => 'nullable|date',
            'btb_request_date' => 'nullable|date',
            'btb_results_date' => 'nullable|date',
            'disposition' => ['nullable', Rule::in(['Stored', 'Consumed', 'Returned'])],
            'sample_condition' => ['nullable', Rule::in(['Stored', 'Consumed', 'Returned'])],
            'weight_sample_remaining' => 'nullable|numeric',
            'resample_indicator' => 'nullable|boolean',
            'notes' => 'nullable',
//            Mito DNA
            'mito_method' => ['sometimes','required', Rule::exists('dna_analysis_types','name' )->where('type','mito')],
            'mito_request_date' => 'nullable|date',
            'mito_receive_date' => 'nullable|date',
            'mito_results_confidence' => ['nullable', Rule::in(['Pending', 'Reportable', 'Inconclusive', 'Unable to Assign', 'Cancelled', 'No Results'])],
            'mito_sequence_number' => 'nullable| alpha_num_dash_space',
            'mito_sequence_subgroup' => 'nullable| alpha_num_dash_space',
            'mito_sequence_similar' => 'nullable| alpha_num_dash_space',
            'mito_match_count' => 'nullable| numeric',
            'mito_total_count' => 'nullable| numeric',
            'mito_base_pairs' => 'nullable|alpha_num_dash_space',
            'mito_confirmed_regions' => 'nullable|regex:/^[a-zA-Z0-9,.!? \-\/]*$/i',
            'mito_polymorphisms' => 'nullable|regex:/^[a-zA-Z0-9,.!? \-\/]*$/i',
            'mito_haplogroup_id' => 'nullable|numeric',
            'mito_mcc_date' => 'nullable|date',
            'mito_fasta_sequence' => 'nullable|alpha_num_dash_space',
            'mito_haplosubgroup' => 'nullable|alpha_num_dash_space',
            'locus' => 'nullable|regex:/^[a-zA-Z0-9,.!? ]*$/i',
            'mito_num_loci' => 'nullable| numeric',
//            Austr DNA
            'austr_method' => ['sometimes','required', Rule::exists('dna_analysis_types','name' )->where('type','auto')],
            'austr_request_date' => 'nullable|date',
            'austr_receive_date' => 'nullable|date',
            'austr_results_confidence' => ['nullable', Rule::in(['Pending', 'Reportable', 'Inconclusive', 'Unable to Assign', 'Cancelled', 'No Results'])],
            'austr_sequence_number' => 'nullable| alpha_num_dash_space',
            'austr_sequence_subgroup' => 'nullable| alpha_num_dash_space',
            'austr_sequence_similar' => 'nullable| alpha_num_dash_space',
            'austr_match_count' => 'nullable| numeric',
            'austr_total_count' => 'nullable| numeric',
            'austr_loci' => 'nullable|regex:/^[a-zA-Z0-9,.!? \-\/]*$/i',
            'austr_num_loci' => 'nullable| numeric',
            'austr_mcc_date' => 'nullable|date',
//            Ystr DNA
            'ystr_method' => ['sometimes','required', Rule::exists('dna_analysis_types','name')->where('type','y')],
            'ystr_request_date' => 'nullable|date',
            'ystr_receive_date' => 'nullable|date',
            'ystr_results_confidence' => ['nullable', Rule::in(['Pending', 'Reportable', 'Inconclusive', 'Unable to Assign', 'Cancelled', 'No Results'])],
            'ystr_sequence_number' => 'nullable| alpha_num_dash_space',
            'ystr_sequence_subgroup' => 'nullable| alpha_num_dash_space',
            'ystr_sequence_similar' => 'nullable| alpha_num_dash_space',
            'ystr_match_count' => 'nullable| numeric',
            'ystr_total_count' => 'nullable| numeric',
            'ystr_loci' => 'nullable|regex:/^[a-zA-Z0-9,.!? \-\/]*$/i',
            'ystr_num_loci' => 'nullable| numeric',
            'ystr_mcc_date' => 'nullable|date',
            'ystr_haplogroup' => 'nullable|numeric',
            'ystr_haplosubgroup' => 'nullable|alpha_num_dash_space',

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
            'mito_total_count.numeric' => 'The mito population frequency must be a number.',
            'austr_total_count.numeric' => 'The austr population frequency must be a number.',
            'ystr_total_count.numeric' => 'The ystr population frequency must be a number.',
            'locus.regex' => trans('validation.no_special_characters'),
            'austr_loci.regex' => trans('validation.no_special_characters'),
            'ystr_loci.regex' => trans('validation.no_special_characters'),
        ];
    }
}
