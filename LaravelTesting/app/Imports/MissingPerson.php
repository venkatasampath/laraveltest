<?php

namespace App\Imports;

use App\User;
use App\Missing_Person;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class MissingPerson extends CoraBaseImport
{
    public function __construct(User $user)
    {
        parent::__construct($user);
        Log::info(__METHOD__);
    }

    /**
     * @param Collection $collection
     * @return void
     */
    public function collection(Collection $collection)
    {
        Log::info(__METHOD__ . " collection size: ".$collection->count());
        foreach ($collection as $row) {
            if (!isset($row['id']) || !isset($row['org_id'])) {
                Log::error(__METHOD__ . 'Skeletal Element unique identification missing in the uploaded file. Skipping row');
//                continue;
                return null;
            }

            Missing_Person::updateOrCreate(
                [
                    'id'                     => $row['id'],
                ],
                [
                    'id'                                    => $row['id'],
                    'org_id'                                => $this->theOrg->id,
                    'project_id'                            => $row['project_id'],
                    'case_manager_id'                       => $row['case_manager_id'] ?? null,
                    'lab_project_manager_id'                => $row['lab_project_manager_id'] ?? null,
                    'case_number'                           => $row['case_number'] ?? null,
                    'conflict'                              => $row['conflict'] ?? null,
                    'serial_number'                         => $row['serial_number'] ?? null,
                    'incident'                              => $row['incident'] ?? null,
                    'case_status'                           => $row['case_status'] ?? null,
                    'field_grave'                           => $row['field_grave'] ?? null,
                    'temp_field_grave'                      => $row['temp_field_grave'] ?? null,
                    'lab_notes'                             => $row['lab_notes'] ?? null,
                    'case_notes'                            => $row['case_notes'] ?? null,
                    'case_manager'                          => $row['case_manager'] ?? null,
                    'case_assign_date'                      => $row['case_assign_date'] ?? null,
                    'case_complete_date'                    => $row['case_complete_date'] ?? null,
                    'case_partial_date'                     => $row['case_partial_date'] ?? null,
                    'case_exhausted_all_resources_date'     => $row['case_exhausted_all_resources_date'] ?? null,
                    'case_identification_date'              => $row['case_identification_date'] ?? null,
                    'case_remains_in_lab_date'              => $row['case_remains_in_lab_date'] ?? null,
                    'first_name'                            => $row['first_name'] ?? null,
                    'last_name'                             => $row['last_name'] ?? null,
                    'middle_name'                           => $row['middle_name'] ?? null,
                    'suffix'                                => $row['suffix'] ?? null,
                    'correct_name'                          => $row['correct_name'] ?? null,
                    'country'                               => $row['country'] ?? null,
                    'frs_xfile'                             => $row['frs_xfile'] ?? null,
                    'priority_dpaa'                         => $row['priority_dpaa'] ?? null,
                    'priority_pcrb'                         => $row['priority_pcrb'] ?? null,
                    'frs_request_mtdna_1'                   => $row['frs_request_mtdna_1'] ?? null,
                    'frs_request_mtdna_2'                   => $row['frs_request_mtdna_2'] ?? null,
                    'frs_request_mtdna_3'                   => $row['frs_request_mtdna_3'] ?? null,
                    'frs_request_ystr_1'                    => $row['frs_request_ystr_1'] ?? null,
                    'frs_request_ystr_2'                    => $row['frs_request_ystr_2'] ?? null,
                    'frs_request_austr_1'                   => $row['frs_request_austr_1'] ?? null,
                    'frs_request_austr_2'                   => $row['frs_request_austr_2'] ?? null,
                    'frs_request_mtdna_1_date'              => $row['frs_request_mtdna_1_date'] ?? null,
                    'frs_request_mtdna_2_date'              => $row['frs_request_mtdna_2_date'] ?? null,
                    'frs_request_mtdna_3_date'              => $row['frs_request_mtdna_3_date'] ?? null,
                    'frs_request_ystr_1_date'               => $row['frs_request_ystr_1_date'] ?? null,
                    'frs_request_ystr_2_date'               => $row['frs_request_ystr_2_date'] ?? null,
                    'frs_request_austr_1_date'              => $row['frs_request_austr_1_date'] ?? null,
                    'frs_request_austr_2_date'              => $row['frs_request_austr_2_date'] ?? null,
                    'lab_receive_mtdna_1'                   => $row['lab_receive_mtdna_1'] ?? null,
                    'lab_receive_request_mtdna_2'           => $row['lab_receive_request_mtdna_2'] ?? null,
                    'lab_receive_request_mtdna_3'           => $row['lab_receive_request_mtdna_3'] ?? null,
                    'lab_receive_request_ystr_1'            => $row['lab_receive_request_ystr_1'] ?? null,
                    'lab_receive_request_ystr_2'            => $row['lab_receive_request_ystr_2'] ?? null,
                    'lab_receive_request_austr_1'           => $row['lab_receive_request_austr_1'] ?? null,
                    'lab_receive_request_austr_2'           => $row['lab_receive_request_austr_2'] ?? null,
                    'lab_receive_mtdna_1_date'              => $row['lab_receive_mtdna_1_date'] ?? null,
                    'lab_receive_request_mtdna_2_date'      => $row['lab_receive_request_mtdna_2_date'] ?? null,
                    'lab_receive_request_mtdna_3_date'      => $row['lab_receive_request_mtdna_3_date'] ?? null,
                    'lab_receive_request_ystr_1_date'       => $row['lab_receive_request_ystr_1_date'] ?? null,
                    'lab_receive_request_ystr_2_date'       => $row['lab_receive_request_ystr_2_date'] ?? null,
                    'lab_receive_request_austr_1_date'      => $row['lab_receive_request_austr_1_date'] ?? null,
                    'lab_receive_request_austr_2_date'      => $row['lab_receive_request_austr_2_date'] ?? null,
                    'genealogy_request'                     => $row['genealogy_request'] ?? null,
                    'genealogy_sent'                        => $row['genealogy_sent'] ?? null,
                    'genealogy_receive'                     => $row['genealogy_receive'] ?? null,
                    'genealogy_not_required'                => $row['genealogy_not_required'] ?? null,
                    'genealogy_request_date'                => $row['genealogy_request_date'] ?? null,
                    'genealogy_sent_date'                   => $row['genealogy_sent_date'] ?? null,
                    'genealogy_receive_date'                => $row['genealogy_receive_date'] ?? null,
                    'genealogy_not_required_date'           => $row['genealogy_not_required_date'] ?? null,

                    'created_at'                            => $this->dt,
                    'updated_at'                            => $this->dt,
                    'deleted_at'                            => $this->dt,
                ]
            );
            $this->import_count++;
        }
        Log::info(__METHOD__ . " Imported ".$this->import_count. " of ".$collection->count());
    }
}
