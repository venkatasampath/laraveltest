<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;


class IsotopeBatchRequest extends FormRequest
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
            'lab_id' => 'sometimes|required|exists:labs,id',
            'batch_num' => 'sometimes|required|alpha_num',
            'status' => ['nullable', Rule::in(['Open', 'Associating Isotopes', 'Cleaning', 'Demineralizing', 'Removal Humic Acids',
                'Solubilizing', 'Freeze Drying Collagen', 'Determining Collagen Yield', 'Closed', 'Completed'])],
            'cleaning_start_date' => 'nullable|date',
            'labeling_tubes' => 'nullable|boolean',
            'rsc' => 'nullable|boolean',
            'rinse_samples' => 'nullable|boolean',
            'sonicate_samples_dh2o_cycle1' => 'nullable|boolean',
            'sonicate_samples_dh2o_cycle1_start_date' => 'nullable|date',
            'sonicate_samples_dh2o_cycle2' => 'nullable|boolean',
            'sonicate_samples_dh2o_cycle2_start_date' => 'nullable|date',
            'sonicate_samples_ethanol95' => 'nullable|boolean',
            'sonicate_samples_ethanol95_start_date' => 'nullable|date',
            'sonicate_samples_ethanol100' => 'nullable|boolean',
            'sonicate_samples_ethanol100_start_date' => 'nullable|date',
            'dry_samples_start' => 'nullable|boolean',
            'dry_samples_start_date' => 'nullable|date',
            'dry_samples_end' => 'nullable|boolean',
            'dry_samples_end_date' => 'nullable|date',
            'cleaning_initials' => 'nullable|alpha_num',
            'demineralizing_treatment_start' => 'nullable|boolean',
            'demineralizing_treatment_end' => 'nullable|boolean',
            'demineralizing_treatment_start_date' => 'nullable|date',
            'demineralizing_treatment_end_date' => 'nullable|date',
            'rinse_demineralized_samples' => 'nullable|boolean',
            'rha_treatment_start' => 'nullable|boolean',
            'rha_treatment_end' => 'nullable|boolean',
            'rha_treatment_start_date' => 'nullable|date',
            'rha_treatment_end_date' => 'nullable|date',
            'rha_sample_rinse1_start' => 'nullable|boolean',
            'rha_sample_rinse1_end' => 'nullable|boolean',
            'rha_sample_rinse1_start_date' => 'nullable|date',
            'rha_sample_rinse1_end_date' => 'nullable|date',
            'rha_sample_rinse2_start' => 'nullable|boolean',
            'rha_sample_rinse2_end' => 'nullable|boolean',
            'rha_sample_rinse2_start_date' => 'nullable|date',
            'rha_sample_rinse2_end_date' => 'nullable|date',
            'rha_sample_rinse3_start' => 'nullable|boolean',
            'rha_sample_rinse3_end' => 'nullable|boolean',
            'rha_sample_rinse3_start_date' => 'nullable|date',
            'rha_sample_rinse3_end_date' => 'nullable|date',
            'rha_sample_rinse4_start' => 'nullable|boolean',
            'rha_sample_rinse4_end' => 'nullable|boolean',
            'rha_sample_rinse4_start_date' => 'nullable|date',
            'rha_sample_rinse4_end_date' => 'nullable|date',
            'rha_sample_rinse5_start' => 'nullable|boolean',
            'rha_sample_rinse5_end' => 'nullable|boolean',
            'rha_sample_rinse5_start_date' => 'nullable|date',
            'rha_sample_rinse5_end_date' => 'nullable|date',
            'sc_clean_vials_and_lids' => 'nullable|boolean',
            'sc_clean_vials_and_lids_date' => 'nullable|date',
            'sc_add_solubale' => 'nullable|boolean',
            'sc_place_in_oven' => 'nullable|boolean',
            'sc_centrifuge_tubes' => 'nullable|boolean',
            'sc_num_acid_heat_treatment' => 'nullable|numeric',
            'sc_num_collagen_transfers' => 'nullable|numeric',
            'sc_freeze_vials' => 'nullable|boolean',
            'sc_freeze_vials_date' => 'nullable|date',
            'fdc_on' => 'nullable|boolean',
            'fdc_samples_start' => 'nullable|boolean',
            'fdc_samples_end' => 'nullable|boolean',
            'fdc_samples_start_date' => 'nullable|date',
            'fdc_samples_end_date' => 'nullable|date',
            'combined_samples_weight' => 'nullable|boolean',
            'notes' => 'nullable|string',
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

        ];
    }
}
