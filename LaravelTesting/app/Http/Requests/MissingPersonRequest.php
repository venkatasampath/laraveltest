<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class MissingPersonRequest extends FormRequest
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
            'org_id' => 'sometimes|required|exists:orgs,id',
            'project_id' => 'sometimes|required|exists:projects,id',
            'case_manager_id' => 'sometimes|required|exists:users,id',
            'lab_project_manager_id' => 'sometimes|required|exists:users,id',
            'case_number' => 'required|max:10',
            'conflict' => 'nullable|max:20',
            'serial_number' => 'nullable|max:10',
            'incident' => 'nullable|max:20',
            'case_status' => 'nullable|max:20',
            'field_grave'=>'nullable|max:50',
            'temp_field_grave'=>'nullable|max:50',
            'lab_notes'=>'nullable|max:255',
            'case_notes'=>'nullable|max:255',
            'case_manager'=>'nullable|max:50',
            'case_assign_date'=>'nullable|date',
            'case_complete_date'=>'nullable|date',
            'case_partial_date'=>'nullable|date',
            'case_exhausted_all_resources_date'=>'nullable|date',
            'case_identification_date'=>'nullable|date',
            'case_remains_in_lab_date'=>'nullable|date',
            'first_name'=>'nullable|max:50',
            'last_name'=>'nullable|max:50',
            'middle_name'=>'nullable|max:50',
            'suffix'=>'nullable|max:3',
            'correct_name'=>'nullable|max:255',
            'country'=>'nullable|max:25',
            'frs_xfile'=>'nullable|max:25',
            'priority_dpaa'=>'nullable|max:25',
            'priority_pcrb'=>'nullable|max:25',
            'frs_request_mtdna_1' => 'nullable|boolean',
            'frs_request_mtdna_1' => 'nullable|boolean',
            'frs_request_mtdna_1' => 'nullable|boolean',
            'frs_request_ystr_1' => 'nullable|boolean',
            'frs_request_ystr_1' => 'nullable|boolean',
            'frs_request_austr_1' => 'nullable|boolean',
            'frs_request_austr_1' => 'nullable|boolean',
            'frs_request_mtdna_1_date'=>'nullable|date',
            'frs_request_mtdna_2_date'=>'nullable|date',
            'frs_request_mtdna_3_date'=>'nullable|date',
            'frs_request_ystr_1_date'=>'nullable|date',
            'frs_request_ystr_2_date'=>'nullable|date',
            'frs_request_austr_1_date'=>'nullable|date',
            'frs_request_austr_2_date'=>'nullable|date',
            'lab_receive_mtdna_1' => 'nullable|boolean',
            'lab_receive_request_mtdna_2' => 'nullable|boolean',
            'lab_receive_request_mtdna_3' => 'nullable|boolean',
            'lab_receive_request_ystr_1' => 'nullable|boolean',
            'lab_receive_request_ystr_2' => 'nullable|boolean',
            'lab_receive_request_austr_1' => 'nullable|boolean',
            'lab_receive_request_austr_2' => 'nullable|boolean',
            'lab_receive_mtdna_1_date'=>'nullable|date',
            'lab_receive_request_mtdna_2_date'=>'nullable|date',
            'lab_receive_request_mtdna_3_date'=>'nullable|date',
            'lab_receive_request_ystr_1_date'=>'nullable|date',
            'lab_receive_request_ystr_2_date'=>'nullable|date',
            'lab_receive_request_austr_1_date'=>'nullable|date',
            'lab_receive_request_austr_2_date'=>'nullable|date',
            'genealogy_request' => 'nullable|boolean',
            'genealogy_sent'=>'nullable|boolean',
            'genealogy_receive'=>'nullable|boolean',
            'genealogy_not_required'=>'nullable|boolean',
            'genealogy_request_date'=>'nullable|date',
            'genealogy_sent_date'=>'nullable|date',
            'genealogy_receive_date'=>'nullable|date',
            'genealogy_not_required_date'=>'nullable|date',
        ];

    }
}
