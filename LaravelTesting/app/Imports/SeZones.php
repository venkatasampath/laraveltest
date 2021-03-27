<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use App\User;

class SeZones extends CoraBaseImport
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
            if (!isset($row['se_id']) || !isset($row['zone_id'])) {
                Log::error(__METHOD__ . 'SE Zone unique identification missing in the uploaded file. Skipping row');
                return null;
            }

            DB::table('se_zone')->updateOrInsert(
                [
                    'se_id'                     => $row['se_id'],
                    'zone_id'                   => $row['zone_id']
                ],
                [
                    'se_id'                     => $row['se_id'],
                    'zone_id'                   => $row['zone_id'],
                    'org_id'                    => $this->theOrg->id,
                    'project_id'                => $this->theProject->id,
                    'presence'                  => $row['presence'],
                    'element_complete'          => $row['element_complete'],
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
