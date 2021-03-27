<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use App\User;
use Illuminate\Support\Facades\DB;

class SeArticulations extends CoraBaseImport
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
            if (!isset($row['se_id']) || !isset($row['articulation_id'])) {
                Log::error(__METHOD__ . 'SE Articulation unique identification missing in the uploaded file. Skipping row');
                return null;
            }

            DB::table('se_articulation')->updateOrInsert(
                [
                    'se_id'                     => $row['se_id'],
                    'articulation_id'           => $row['articulation_id']
                ],
                [
                    'se_id'                     => $row['se_id'],
                    'articulation_id'           => $row['articulation_id'],
                    'org_id'                    => $this->theOrg->id,
                    'project_id'                => $this->theProject->id,

                    'compare_method'            => $row['compare_method'] ?? $row['method'] ?? null,
                    'compare_method_settings'   => $row['compare_method_settings'] ?? $row['method_settings'] ?? null,
                    'measurements_used'         => $row['measurements_used'] ?? null,
                    'num_measurements'          => $row['num_measurements'] ?? null,
                    'sample_size'               => $row['sample_size'] ?? null,
                    'pvalue'                    => $row['pvalue'] ?? null,
                    'mean'                      => $row['mean'] ?? null,
                    'sd'                        => $row['sd'] ?? null,
                    'elimination_reason'        => $row['elimination_reason'] ?? null,
                    'elimination_date'          => $row['elimination_date'] ?? null,
                    'measurement_means'         => $row['measurement_means'] ?? null,
                    'measurement_sd'            => $row['measurement_sd'] ?? null,

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
