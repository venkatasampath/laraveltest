<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Http\Request;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Carbon;
use Webpatser\Uuid\Uuid;
use App\Notifications\SpecimenGroupCreated;
use App\SkeletalElement;
use App\SkeletalBone;
use App\BoneGroup;
use App\User;
use Log;

class SpecimenGroupCreation extends CoraBaseJob
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $tries = 3;
    protected $starting_de = "";
    protected $designator_num = "";
    protected $bone_group_id = "";
    protected $bone_group_name = "";
    protected $is_group_sided = false;

    public function __construct($user_id, $request, $count)
    {
        parent::__construct($user_id);
        $this->logInfo(__METHOD__);

        $this->request = $request;
        $this->notification_params['boneGroupName'] = $this->bone_group_name = $request['bone_grouping'];
        $this->notification_params['boneGroupCount'] = $count;
        $this->notification_params['an'] = $request['accession_number'];
        $this->notification_params['p1'] = $request['provenance1'];
        $this->notification_params['p2'] = $request['provenance2'];
        $this->notification_params['de'] = $this->designator_num = $this->starting_de = $request['designator'];
        $this->notification_params['bone_group_id'] = $this->bone_group_id = Uuid::generate(4)->string;
        $this->is_group_sided = BoneGroup::isGroupSided($this->bone_group_name);
        if ($this->is_group_sided) {
            $this->logInfo(__METHOD__, 'Bone Group - '. $request['bone_grouping']." has Left-Right sided bones");
        }
    }

    public function handle()
    {
        $this->logInfo(__METHOD__);
        $request = $this->request;
        $skeletalBones = $request['bone_select'];

        $skeletalElements = collect();
        foreach( $skeletalBones as $bone){
            if(substr_count($bone, '-') == 1) {
                $bone_name = explode(' - ', $bone)[0];
                $current_sb = SkeletalBone::where('name', $bone_name)->first();
                $side = explode(' - ', $bone)[1];
            } else {
                $current_sb = SkeletalBone::where('name', $bone)->first();
                $side = $request['side'];
            }

            $input = ['accession_number' => $request['accession_number'], 'provenance1' => $request['provenance1'],
                'provenance2' => $request['provenance2'], 'designator' => $this->designator_num,
                'sb_id' => $current_sb->id, 'side' => $side, 'completeness' => $request['completeness'] ,
                'bone_group' => $request['bone_grouping'], 'bone_group_id' => $this->bone_group_id ];

            $this->populateCreateFieldsWithUserAndOrgID($input);
            $this->populateBooleanFields($input);

            while(true){
                $an = $input['accession_number'];
                $p1 = $input['provenance1'];
                $p2 = $input['provenance2'];
                $de = $input['designator'];
                $se = SkeletalElement::firstOrNew(['accession_number'=>$an, 'provenance1'=>$p1, 'provenance2'=>$p2, 'designator'=>$de]);
                if ($se->exists) {
                    $this->designator_num++;
                    $input['designator'] = $this->designator_num;
                } else{
                    break;
                }
            }

            $input['project_id'] = $this->theProject->id;
            $object = SkeletalElement::create($input);
            $this->associateZonesOnSEUpdate($object, $request);
            if ( isset($request['trauma_select'])) {
                foreach ($request['trauma_select'] as $trauma) {
                    $syncData = [];
                    $syncData[$trauma] = ['zone_id' => null, 'additional_information' => null,
                        'org_id' => $object->org_id, 'project_id' => $object->project_id,
                        'created_by' => $this->theUser->name, 'updated_by' => $this->theUser->name];
                    $object->traumas()->attach($syncData);
                }
            }
            if ( isset($request['pathology_select'])) {
                foreach ($request['pathology_select'] as $pathology) {
                    $syncData = [];
                    $syncData[$pathology] = ['zone_id' => null, 'additional_information' => null,
                        'org_id' => $object->org_id, 'project_id' => $object->project_id,
                        'created_by' => $this->theUser->name, 'updated_by' => $this->theUser->name];
                    $object->pathologys()->attach($syncData);
                }
            }
            if( isset($request['taphonomy_select'])){
                $this->syncTaphomonys($object, $request['taphonomy_select']);
            }

            $this->findArticulationsInGroup($object, $skeletalElements);
            // Handle Pair Matching if any.
            if ($this->is_group_sided) {
                if (BoneGroup::isBoneInGroupSided($request['bone_grouping'], $current_sb->id)) {
                    $this->logInfo(__METHOD__, 'Bone Group - '. $this->bone_group_name. ' has Left-Right '. $current_sb->name);
                    $this->findPairsInGroup($object, $skeletalElements);
                }
            }
            $skeletalElements->push($object);
        }

        $this->notification_params['boneGroupCount'] = count($skeletalBones);
        $this->logInfo(__METHOD__, 'Sending SpecimenGroupCreated Notification');
        $this->theUser->notify((new SpecimenGroupCreated($this->theUser->id, $this->notification_params))->onQueue('notifications'));
    }

    public function failed(\Exception $exception)
    {
        Log::error(__METHOD__." ".$exception->getMessage());
        $this->notification_params['hasJobFailed'] = true;
        $this->theUser->notify((new SpecimenGroupCreated($this->theUser->id, $this->notification_params))->onQueue('notifications'));
    }

    /**
     * This method is used to find which elements in the list can be articulated with
     * the skeletalElement and then articulates those elements with the skeletalElement
     * @param SkeletalElement $skeletalElement
     * @param $skeletalElementsList
     */
    private function findArticulationsInGroup( SkeletalElement $skeletalElement, $skeletalElementsList)
    {
        $articulations = $skeletalElement->skeletalbone()->first()->articulations;
        $skeletalElements = $skeletalElementsList->whereIn('sb_id',$articulations->pluck('id') )->pluck('id')->toArray();
        if ( count($skeletalElements) != 0) {
            $this->syncArticulations($skeletalElement, $skeletalElements);
        }
    }

    /**
     * This method is used to find which elements in the list can be
     * pair matched and then pairs those specimens
     * @param SkeletalElement $skeletalElement
     * @param $specimenlist: Consists of specimens created thus far only
     *                       and does not contain the current specimen
     */
    private function findPairsInGroup( SkeletalElement $specimen, $specimenlist )
    {
        $bone_id = $specimen->sb_id;
        $specimens = $specimenlist->whereIn('sb_id', $bone_id)->pluck('id')->toArray();
        if ( count($specimens) != 0 ) {
            $this->logInfo(__METHOD__, 'Pair: '.$specimen->key);
            $this->syncPairs($specimen, $specimens);
        }
    }

    protected function populateBooleanFields(&$input)
    {
        $input['measured'] = false;
        $input['dna_sampled'] = false;
        $input['ct_scanned'] = false;
        $input['xray_scanned'] = false;
        $input['clavicle_triage'] = false;
        $input['inventoried'] = false;
        $input['reviewed'] = false;
        $input['isotope_sampled'] = false;
    }

    public function populateCreateFieldsWithUserAndOrgID(&$input)
    {
        $this->populateCreateFields($input);
        $input['user_id'] = $this->theUser->id;
        $input['org_id'] = $this->theOrg->id;
    }

    public function populateCreateFields(&$input)
    {
            $input['created_by'] = $this->theUser->name;
            $input['updated_by'] = $this->theUser->name;
    }

    protected function associateZonesOnSEUpdate(SkeletalElement $skeletalelement)
    {
        if ($skeletalelement->completeness === "Complete")
        {
            $sb = SkeletalBone::find($skeletalelement->sb_id);
            $zones = $sb->zones()->get();
            $arr_zones = [];
            foreach($zones as $zone) {
                $arr_zones[$zone->id]['id'] = $zone->id;
                $arr_zones[$zone->id]['presence'] = true;
            }
            $skeletalelement->zones()->sync($this->populateCreateFieldsOrgProjectFieldsForSyncWithData($arr_zones,"presence", $skeletalelement, 'boolean'));

        } else {
            $sb = SkeletalBone::find($skeletalelement->sb_id);
            $zones = $sb->zones()->get();
            $arr_zones = [];
            foreach($zones as $zone) {
                $arr_zones[$zone->id]['id'] = $zone->id;
                $arr_zones[$zone->id]['presence'] = false;
            }
            $skeletalelement->zones()->sync([]);
        }
    }

    /**
     * Sync up the list of taphomonys for the given skeletalelement record.
     *
     * @param  User $skeletalelement
     * @param  array $taphonomys (id)
     */
    private function syncTaphomonys(SkeletalElement $skeletalelement, array $taphonomys)
    {
        $skeletalelement->taphonomys()->sync($this->populateCreateFieldsOrgProjectFieldsForSyncWithIDs($taphonomys, $skeletalelement));
    }

    /**
     * Sync up the list of se - articulations for the given skeletalelement record.
     *
     * @param  User $skeletalelement
     * @param  array $articulations (id)
     */
    private function syncArticulations(SkeletalElement $skeletalelement, array $articulations)
    {
        $skeletalelement->articulations1()->detach();
        $skeletalelement->articulations2()->detach();
        $skeletalelement->articulations()->sync($this->populateCreateFieldsOrgProjectFieldsForSyncWithIDs($articulations, $skeletalelement));
    }

    /**
     * Sync up the list of se - pairs for the given skeletalelement record.
     *
     * @param  User $skeletalelement
     * @param  array $pairs (id)
     */
    private function syncPairs(SkeletalElement $skeletalelement, array $pairs)
    {
        $skeletalelement->pairs1()->detach();
        $skeletalelement->pairs2()->detach();
        $syncData = $this->populateCreateFieldsOrgProjectFieldsForSyncWithIDs($pairs, $skeletalelement);
        $skeletalelement->pairs()->sync($syncData);
    }

    public function populateCreateFieldsOrgProjectFieldsForSyncWithIDs($arr_ids, $model, $ts = false)
    {
        $syncData = [];
        foreach($arr_ids as $id)
        {
            if ($ts) {
                $syncData[$id] = [ 'created_by' => $this->theUser->name, 'updated_by' => $this->theUser->name,
                    'org_id' => $model->org_id, 'project_id' => $model->project_id,
                    'created_at' => date_create(), 'updated_at' => date_create()];
            } else {
                $syncData[$id] = [ 'created_by' => $this->theUser->name, 'updated_by' => $this->theUser->name,
                    'org_id' => $model->org_id, 'project_id' => $model->project_id ] ;
            }
        }
        return $syncData;
    }

    public function populateCreateFieldsOrgProjectFieldsForSyncWithData($arr_data, $field, $model, $type = 'string')
    {
        $syncData = [];
        foreach($arr_data as $data)
        {
            if ($type == 'boolean') {
                $syncData[$data['id']] = [ $field => true, 'org_id' => $model->org_id, 'project_id' => $model->project_id,
                    'created_by' => $this->theUser->name, 'updated_by' => $this->theUser->name ];
            } else { // assume string - default
                $syncData[$data['id']] = [ $field => $data[$field], 'org_id' => $model->org_id, 'project_id' => $model->project_id,
                    'created_by' => $this->theUser->name, 'updated_by' => $this->theUser->name ];
            }
        }
        return $syncData;
    }
}