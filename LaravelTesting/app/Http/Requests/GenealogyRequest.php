<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GenealogyRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */

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
            'mp_id' => 'sometimes|required|exists:missing_persons,id',
            'priority' => 'nullable|max:50',
            'notes' => 'nullable|max:255',
            'enclosed_documents' => 'nullable|max:50',
            'company' => 'nullable|max:50',
            'funded_by' => 'nullable|max:50',
            'request_date' => 'nullable|date',
            'receive_date' => 'nullable|date'

        ];
    }
}
