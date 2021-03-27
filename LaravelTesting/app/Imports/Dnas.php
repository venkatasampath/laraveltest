<?php

namespace App\Imports;

use App\Dna;
use App\Lab;
use App\SkeletalElement;
use App\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;

class Dnas extends CoraBaseImport
{
    public function __construct(User $user)
    {
        parent::__construct($user);
        Log::info(__METHOD__);
    }

    /**
    * @param Collection $collection
    *
    * @return void
    */
    public function collection(Collection $collection)
    {
        Log::info(__METHOD__ . " collection size: ".$collection->count());
        foreach ($collection as $row) {
            if (isset($row['accession']) && isset($row['provenance1']) && isset($row['provenance2']) && isset($row['designator'])) {
                $skeletalElement = SkeletalElement::where(
                    [
                        ['accession_number', $row['accession']],
                        ['provenance1', $row['provenance1']],
                        ['provenance2', $row['provenance2']],
                        ['designator', $row['designator']]
                    ]
                )->first();
                if (is_null($skeletalElement)) {
                    Log::error(__METHOD__ . 'Failed to retrieve skeletal element. Invalid info specified in uploaded file');
                    return null;
                }
                $seId = $skeletalElement->id;
            } elseif (isset($row['se_id'])) {
                $seId = $row['se_id'];
            } else {
                Log::error(__METHOD__ . 'Skeletal Element info missing in the uploaded file. Skipping row');
                return null;
            }

            if (isset($row['lab_name'])) {
                $lab = Lab::where('name', $row['lab_name'])->first();

                if (is_null($lab)) {
                    Log::error(__METHOD__ . 'Failed to retrieve lab information');
                    return null;
                }
                $labId = $lab->id;
            } else if (isset($row['lab_Id'])) {
                $labId = $row['lab_id'];
            } else {
                Log::error(__METHOD__ . 'No lab information present in file');
                $labId = null;
            }

            Dna::updateOrCreate(
                [
                    'se_id'                      => $seId
                ],
                [
                    'org_id'                     => $this->theOrg->id,
                    'project_id'                 => $this->theProject->id,
                    'se_id'                      => $seId,
                    'lab_id'                     => $labId,
                    'external_case_id'           => $row['external_case_id'],
                    'sample_number'              => $row['sample_number'],
                    'priority'                   => $row['priority'],
                    'resample_number'            => $row['resample_number'],
                    'mito_sequence_number'       => $row['mito_sequence_number'],
                    'mito_sequence_subgroup'     => $row['mito_sequence_subgroup'],
                    'mito_sequence_similar'      => $row['mito_sequence_similar'],
                    'mito_match_count'           => $row['mito_match_count'],
                    'mito_total_count'           => $row['mito_total_count'],
                    'mito_receive_date'          => $row['mito_receive_date'],
                    'mito_results_confidence'    => $row['mito_results_confidence'],
                    'mito_method'                => $row['mito_method'],
                    'external_sample_number'     => $row['external_sample_number'],
                    'disposition_of_evidence'    => $row['disposition_of_evidence'],
                    'mito_confirmed_regions'     => $row['mito_confirmed_regions'],
                    'mito_base_pairs'            => $row['mito_base_pairs'],
                    'num_bases'                  => $row['num_bases'],
                    'locus'                      => $row['locus'],
                    'mito_num_loci'              => $row['mito_num_loci'],
                    'mito_mcc_date'              => $row['mito_mcc_date'],
                    'additional_testing'         => $row['additional_testing'],
                    'priority_date'              => $row['priority_date'],
                    'btb_request_date'           => $row['btb_request_date'],
                    'btb_results_date'           => $row['btb_results_date'],
                    'disposition'                => $row['disposition'],
                    'sample_condition'           => $row['sample_condition'],
                    'weight_sample_remaining'    => $row['weight_sample_remaining'],
                    'mito_request_date'          => $row['mito_request_date'],
                    'mito_polymorphisms'         => $row['mito_polymorphisms'],
                    'mito_fasta_sequence'        => $row['mito_fasta_sequence'],
                    'mito_haplosubgroup'         => $row['mito_haplosubgroup'],
                    'austr_method'               => $row['austr_method'],
                    'austr_request_date'         => $row['austr_request_date'],
                    'austr_receive_date'         => $row['austr_receive_date'],
                    'austr_results_confidence'   => $row['austr_results_confidence'],
                    'austr_sequence_number'      => $row['austr_sequence_number'],
                    'austr_sequence_subgroup'    => $row['austr_sequence_subgroup'],
                    'austr_sequence_similar'     => $row['austr_sequence_similar'],
                    'austr_match_count'          => $row['austr_match_count'],
                    'austr_total_count'          => $row['austr_total_count'],
                    'austr_num_loci'             => $row['austr_num_loci'],
                    'austr_loci'                 => $row['austr_loci'],
                    'austr_mcc_date'             => $row['austr_mcc_date'],
                    'ystr_method'                => $row['ystr_method'],
                    'ystr_request_date'          => $row['ystr_request_date'],
                    'ystr_receive_date'          => $row['ystr_receive_date'],
                    'ystr_results_confidence'    => $row['ystr_results_confidence'],
                    'ystr_sequence_number'       => $row['ystr_sequence_number'],
                    'ystr_sequence_subgroup'     => $row['ystr_sequence_subgroup'],
                    'ystr_sequence_similar'      => $row['ystr_sequence_similar'],
                    'ystr_match_count'           => $row['ystr_match_count'],
                    'ystr_total_count'           => $row['ystr_total_count'],
                    'ystr_num_loci'              => $row['ystr_num_loci'],
                    'ystr_loci'                  => $row['ystr_loci'],
                    'ystr_haplogroup'            => $row['ystr_haplogroup'],
                    'ystr_haplosubgroup'         => $row['ystr_haplosubgroup'],
                    'ystr_mcc_date'              => $row['ystr_mcc_date'],
                    'created_by'                => $this->theUser->display_name." via Import",
                    'updated_by'                => $this->theUser->display_name." via Import",
                    'created_at'                => $this->dt,
                    'updated_at'                => $this->dt,
                ]
            );
            $this->import_count++;
        }
        Log::info(__METHOD__ . " Imported ".$this->import_count. " of ".$collection->count());
    }
}
