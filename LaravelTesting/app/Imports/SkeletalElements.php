<?php

namespace App\Imports;

use App\SkeletalBone;
use App\SkeletalElement;
use App\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;

class SkeletalElements extends CoraBaseImport
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
            if (!isset($row['accession']) || !isset($row['provenance1']) || !isset($row['provenance2']) || !isset($row['designator'])) {
                Log::error(__METHOD__ . 'Skeletal Element unique identification missing in the uploaded file. Skipping row');
                return null;
            } elseif (isset($row['sb_id'])) {
                $sbId = $row['sb_id'];
            } elseif (isset($row['bone'])) {
                $skeletalBone = SkeletalBone::where('name', $row['bone'])->first();

                if (is_null($skeletalBone)) {
                    Log::error(__METHOD__ . 'Failed to retrieve skeletal bone. Invalid Bone specified in uploaded file');
                    return null;
                }

                $sbId = $skeletalBone->id;
            } else {
                Log::error(__METHOD__ . 'Bone information missing in the uploaded file. Skipping row');
                return null;
            }

            SkeletalElement::updateOrCreate(
                [   'accession_number'          => $row['accession'],
                    'provenance1'               => $row['provenance1'],
                    'provenance2'               => $row['provenance2'],
                    'designator'                => $row['designator']
                ],
                [
                    'user_id'                   => $this->theUser->id,
                    'org_id'                    => $this->theOrg->id,
                    'project_id'                => $this->theProject->id,
                    'accession_number'          => $row['accession'],
                    'provenance1'               => $row['provenance1'],
                    'provenance2'               => $row['provenance2'],
                    'designator'                => $row['designator'],
                    'side'                      => $row['side'],
                    'sb_id'                     => $sbId,
                    'completeness'              => $row['completeness'],
                    'measured'                  => $row['measured'],
                    'dna_sampled'               => $row['dna_sampled'],
                    'ct_scanned'                => $row['ct_scanned'],
                    'xray_scanned'              => $row['xray_scanned'],
                    'clavicle_triage'           => $row['clavicle_triage'],
                    'inventoried'               => $row['inventoried'],
                    'reviewed'                  => $row['reviewed'],
                    'external_id'               => $row['external_id'],
                    'individual_number'         => $row['individual_number'],
                    'inventoried_at'            => $row['inventoried_at'],
                    'reviewed_at'               => $row['reviewed_at'],
                    'consolidated_an'           => $row['consolidated_an'],
                    'isotope_sampled'           => $row['isotope_sampled'],
                    'count'                     => $row['count'],
                    'mass'                      => $row['mass'],
                    'bone_group'                => $row['bone_group'],
                    'created_by'                => $this->theUser->display_name." via Import",
                    'updated_by'                => $this->theUser->display_name." via Import",
                    'created_at'                => $this->dt,
                    'updated_at'                => $this->dt,
            ]);
            $this->import_count++;
        }
        Log::info(__METHOD__ . " Imported ".$this->import_count. " of ".$collection->count());
    }
}
