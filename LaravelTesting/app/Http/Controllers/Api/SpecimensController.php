<?php

/**
 * Cora Api SpecimensController
 *
 * @category
 * @package    CoRA-Api-Controller
 * @author     Sachin Pawaskar<spawaskar@unomaha.edu>
 * @copyright  2016-2020, Sachin Pawaskar, All rights reserved.
 * @license    Proprietary software, All rights reserved.
 * @version    GIT: $Id$
 * @since      File available since Release 3.0.0
 */

namespace App\Http\Controllers\Api;

use App\Accession;
use App\Http\Controllers\Controller;
use App\Http\Requests\SkeletalElementRequest;
use App\Http\Resources\ListResource;
use App\SkeletalBone;
use App\SkeletalElement;
use App\Method;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use App\Http\Resources\CoraResource;
use App\Http\Resources\CoraResourceCollection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * Class SpecimensController
 * @package App\Http\Controllers\Api
 */
class SpecimensController extends Controller
{
    /**
     * @var array
     */
    public static $allowed_association_types = ["pairs", "articulations", "refits", "morphologys", "morphologies", "methods", "methodfeatures",
        "anomalys", "anomalies", "taphonomys", "taphonomies", "measurements", "zones", "pathologys", "pathologies", "traumas", 'instruments',
        "tags", "comments", "dnas", "isotopes", "audits", "dentalcodes"];

    /**
     * Display a listing of the resource.
     *
     * @return CoraResourceCollection|JsonResponse
     * @throws AuthorizationException
     */
    public function index()
    {
        $this->logInfo(__METHOD__);
        if ($this->authorize('browse', [ SkeletalElement::class ])) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            $list = SkeletalElement::paginate($this::$pagination_length_large);

            return new CoraResourceCollection($list);
        } else {
            return response()->json([ "data" => "Not authorized to view all resources" ], 403);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param SkeletalElement $specimen
     * @return CoraResource|JsonResponse
     * @throws AuthorizationException
     */
    public function show(SkeletalElement $specimen)
    {
        $this->logInfo(__METHOD__);
        if ($this->authorize('read', [ SkeletalElement::class, $specimen ])) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            return new CoraResource($specimen);
        } else {
            return response()->json([ "data" => "Not authorized to view resource" ], 403);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param SkeletalElementRequest $request
     * @return CoraResource|JsonResponse
     * @throws AuthorizationException
     */
    public function store(SkeletalElementRequest $request)
    {
        $this->logInfo(__METHOD__);
        if ($this->authorize('add', SkeletalElement::class)) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            try {
                if (!$this->hasInput($request)) {
                    return response()->json([ "data" => "Request is empty" ], 400);
                }
                // set org, user and project id fields
                $request['org_id'] = $this->theOrg->id;
                $request['user_id'] = $this->theUser->id;
                $request['project_id'] = $this->theProject->id;
                // Set boolean fields to false
                $request['measured'] = $request['dna_sampled'] = $request['isotope_sampled'] = false;
                $request['ct_scanned'] = $request['xray_scanned'] = $request['3D_scanned'] = false;
                $request['clavicle_triage'] = $request['inventoried'] = $request['reviewed'] = false;

                $this->logInfo(__METHOD__, "data: ".json_encode($request->all()));

                // Check if the project uses_auto_incrementing_designator
                if ($this->theProject->uses_auto_increment_designator) {
                    // Find the next designator to use and set it in request object.
                    $max_designator = $this->getMaxDesignator();
                    $request["designator"] = $max_designator + 1;
                    $this->logInfo(__METHOD__, "next_designator: ".$request["designator"]);
                    $this->logInfo(__METHOD__, "data: ".json_encode($request->all()));
                }

                // Check that the Composite Key passed is unique
                if($this->checkUniqueANP1P2DN($request) == false) {
                    return response()->json([ "data" => [ "message"=>trans('messages.model_add_unsuccessful', ['model'=>'Specimen'])." ".trans('messages.error_duplicate_composite_key'),
                        "request" => $request, ]], 422);
                }

                // If necessary, add new Accession, Provenance1 and Provenance2 combination to Accessions table.
                $this->addNewAccessionIfNecessary($request);

                $this->logInfo(__METHOD__, "data: ".json_encode($request->all()));
//                return response()->json([ 'data' => ["message" => "Specimen created successfully",
//                    "redirect_url"=>$this->theUser->getProfileValue('se_new_redirect_url') ]], 200);
                $specimen = SkeletalElement::create($request->all());
                $this->associateZonesOnSEUpdate($specimen, $request);
                return (new CoraResource($specimen))->additional(["message" => "Specimen created successfully",
                    "redirect_url"=>$this->theUser->getProfileValue('se_new_redirect_url') ]);
            } catch (QueryException $ex) {
                $this->logQueryException(__METHOD__, $request, $ex);
                return response()->json([ "data" => [  "message" => trans('messages.model_add_unsuccessful', ['model'=>'Specimens']),
                    "request" => $request, "exception" => $ex ]], 422);
            }
        } else {
            return response()->json([ "data" => [ "message"=>"Not authorized to create resource" ]], 403);
        }
    }

    /**
     * This function checks to see if the specimen being inserted or updated has unique composite key
     * Unique composite key consists of Accession, Provenance1, Provenance2 and Designator.
     * This function must be called before creating a new specimen or updating existing.
     *
     * @param Request $request
     * @param SkeletalElement|null $specimen
     * @return bool
     */
    public function checkUniqueANP1P2DN(Request $request, SkeletalElement $specimen = null) {
        $flag = true;
        $an = $request['accession_number'];
        $p1 = $request['provenance1'];
        $p2 = $request['provenance2'];
        $de = $request['designator'];
        if (!isset($specimen)) { // on insert/store
            try {
                $se = SkeletalElement::firstOrNew(['accession_number'=>$an, 'provenance1'=>$p1, 'provenance2'=>$p2, 'designator'=>$de]);
                if ($se->exists) {
                    $this->logInfo(__METHOD__, "Duplicate: ". $an."-".$p1."-".$p2."-".$de);
                    $flag = false;
                }
            } catch (QueryException $ex) {
                $this->logQueryException(__METHOD__, $request, $ex);
                return $flag;
            }
        } else { // update
            try {
                // Has any part of the key changed
                if ($an != $specimen->accession_number || $p1 != $specimen->provenance1 || $p2 != $specimen->provenance2 || $de != $specimen->designator) {
                    $se = SkeletalElement::firstOrNew(['accession_number'=>$an, 'provenance1'=>$p1, 'provenance2'=>$p2, 'designator'=>$de]);
                    if ($se->exists) {
                        $this->logInfo(__METHOD__, "Duplicate: ". $an."-".$p1."-".$p2."-".$de);
                        $flag = false;
                    }
                }
            } catch (QueryException $ex) {
                $this->logQueryException(__METHOD__, $request, $ex);
                return $flag;
            }
        }
        return $flag;
    }

    /**
     * If necessary, this function will add new Accession, Provenance1 and Provenance2 combination to Accessions table.
     * This is needed to show the appropriate lists for Accessions, Provenance1 and Provenance2
     *
     * @param Request $request
     */
    public function addNewAccessionIfNecessary(Request $request) {
        $this->logInfo(__METHOD__, "AnP1P2: ". $request['accession_number']."-".$request['provenance1']."-".$request['provenance2']);

        try {
            if(Accession::where('number',$request['accession_number'])->where('provenance1', $request['provenance1'])->where('provenance2', $request['provenance2'])->first() == null) {
                $input['org_id'] = $this->theOrg->id;
                $input['project_id'] = $this->theProject->id;
                $input['consolidated_an'] = false;
                $input['number'] = $request['accession_number'];
                $input['provenance1'] = $request['provenance1'];
                $input['provenance2'] = $request['provenance2'];
                $this->populateCreateFields($input);
                Accession::create($input);
            }
        } catch (QueryException $ex) {
            $this->logQueryException(__METHOD__, $request, $ex);
        }
    }

    /**
     * Get the max designator currently being used.
     * @return mixed
     */
    public function getMaxDesignator() {
        $max_results = DB::table("skeletal_elements")
            ->selectRaw('MAX(CAST(designator AS Int))')
            ->where("org_id", "=", $this->theOrg->id)
            ->where("project_id", "=", $this->theProject->id)
            ->where("designator", "~", '^[0-9]*$')
            ->get();

        $this->logInfo(__METHOD__, "max_designator: ".$max_results[0]->max);
        return $max_results[0]->max;
    }

    /**
     * This method will automatically set the zones for the given Specimen based on the completeness.
     * This should be called when the specimen is created or updated
     *
     * @param SkeletalElement $skeletalelement
     * @param $request
     * @return bool
     */
    protected function associateZonesOnSEUpdate(SkeletalElement $skeletalelement, $request)
    {
        $this->logInfo(__METHOD__, $skeletalelement->id.":".$skeletalelement->key);
        if ($skeletalelement->completeness === "Complete")
        {
            try {
                $sb = SkeletalBone::find($skeletalelement->sb_id);
                $zones = $sb->zones()->get();
                $arr_zones = [];
                foreach($zones as $zone) {
                    $arr_zones[$zone->id]['id'] = $zone->id;
                    $arr_zones[$zone->id]['presence'] = true;
                }
                $skeletalelement->zones()->sync($this->populateCreateFieldsOrgProjectFieldsForSyncWithData($arr_zones,"presence", $skeletalelement, 'boolean'));
                $this->logInfo(__METHOD__, "Complete Successful ".$skeletalelement->id.":".$skeletalelement->key);
                return true;
            } catch (QueryException $ex) {
                $this->logQueryException(__METHOD__, $request, $ex);
            }
        } else {
            try {
                $sb = SkeletalBone::find($skeletalelement->sb_id);
                $zones = $sb->zones()->get();
                $arr_zones = [];
                foreach($zones as $zone) {
                    $arr_zones[$zone->id]['id'] = $zone->id;
                    $arr_zones[$zone->id]['presence'] = false;
                }
                $skeletalelement->zones()->sync([]);
                $this->logInfo(__METHOD__, "Not Complete Successful ".$skeletalelement->id.":".$skeletalelement->key);
                return true;
            } catch (QueryException $ex) {
                $this->logQueryException(__METHOD__, $request, $ex);
            }
        }
        return false;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param SkeletalElementRequest $request
     * @param SkeletalElement $specimen
     * @return CoraResource|JsonResponse
     * @throws AuthorizationException
     */
    public function update(SkeletalElementRequest $request, SkeletalElement $specimen)
    {
        $this->logInfo(__METHOD__);
        if ($this->authorize('edit', [SkeletalElement::class, $specimen])) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            try {
                if (!$this->hasInput($request)) {
                    return response()->json([ "data" => "Request is empty" ], 400);
                }
                $specimen->update($request->all());
                return new CoraResource($specimen);
            } catch (QueryException $ex) {
                $this->logQueryException(__METHOD__, $request, $ex);
                return response()->json([ 'data' => trans('messages.model_add_unsuccessful', ['model'=>'Specimens']) ], 422);
            }
        } else {
            return response()->json([ "data" => "Not authorized to edit resource" ], 403);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Request $request
     * @param SkeletalElement $specimen
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function destroy(Request $request, SkeletalElement $specimen)
    {
        $this->logInfo(__METHOD__);
        if ($this->authorize('delete', [SkeletalElement::class, $specimen])) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            try {
                $specimen->delete();
                return response()->json([ 'data' => "Resource deleted successfully" ], 200);
            } catch (QueryException $ex) {
                $this->logQueryException(__METHOD__, $request, $ex);
                return response()->json([ 'data' => trans('messages.model_delete_unsuccessful', ['model'=>'Specimens']) ], 422);
            }
        } else {
            return response()->json([ "data" => "Not authorized to delete resource" ], 403);
        }
    }

    /**
     * Display a listing of the specimen association resource for the specified association type
     *
     * For a full listing of association type, see $allowed_association_types
     *
     * @param Request $request
     * @param SkeletalElement $specimen
     * @return JsonResponse|\Illuminate\Http\Resources\Json\AnonymousResourceCollection
     * @throws AuthorizationException
     */
    public function getAssociations(Request $request, SkeletalElement $specimen)
    {
        $this->logInfo(__METHOD__);
        if ($this->authorize('read', [SkeletalElement::class, $specimen])) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            try {
                if ($request->has('type')) {
                    $type = $request->query('type');
                    $type = (!isset($type)) ? "" : strtolower($type);
                    if (! in_array($type, $this::$allowed_association_types)) {
                        return response()->json([ "data" => "Bad request: unsupported association type"], 400);
                    }
                } else {
                    return response()->json([ "data" => "Bad request: missing request parameters"], 400);
                }

                $list = null;
                switch ($type) {
                    case "articulations":
                        $list = $specimen->articulations()->paginate($this::$pagination_length_large);
                        break;
                    case "pairs":
                        $list = $specimen->pairs()->paginate($this::$pagination_length_large);
                        break;
                    case "refits":
                        $list = $specimen->refits()->paginate($this::$pagination_length_large);
                        break;
                    case "morphologys":
                    case "morphologies":
                        $list = $specimen->morphologys()->paginate($this::$pagination_length_large);
                        break;
                    case "methods":
                        $list = $specimen->methods()->paginate($this::$pagination_length_large);
                        break;
                    case "methodfeatures":
                        if ($request->has('method_id')) {
                            $method_id = $request->query('method_id');
                            $method_id = (!isset($type)) ? "" : strtolower($method_id);
                            $list = $specimen->methodfeaturesByMethod($method_id);
                        } else {
                            $list = $specimen->methodfeatures()->paginate($this::$pagination_length_large);
                        }
                        break;
                    case "taphonomys":
                    case "taphonomies":
                        $list = $specimen->taphonomys()->paginate($this::$pagination_length_large);
                        break;
                    case "anomalys":
                    case "anomalies":
                        $list = $specimen->anomalys()->paginate($this::$pagination_length_large);
                        break;
                    case "measurements":
                        $list = $specimen->measurements()->paginate($this::$pagination_length_large);
                        break;
                    case "zones":
                        $list = $specimen->zones()->paginate($this::$pagination_length_large);
                        break;
                    case "pathologys":
                    case "pathologies":
                        $list = $specimen->pathologys()->paginate($this::$pagination_length_large);
                        break;
                    case "traumas":
                        $list = $specimen->traumas()->paginate($this::$pagination_length_large);
                        break;
                    case "tags":
                        $list = $specimen->tags()->paginate($this::$pagination_length_large);
                        break;
                    case "comments":
                        $list = $specimen->comments()->paginate($this::$pagination_length_large);
                        break;
                    case "dnas":
                        $list = $specimen->dnas()->paginate($this::$pagination_length_large);
                        break;
                    case "isotopes":
                        $list = $specimen->isotopes()->paginate($this::$pagination_length_large);
                        break;
                    case "instruments":
                        $list = $specimen->instruments()->paginate($this::$pagination_length_large);
                        break;
                    case "audits":
                        $list = $specimen->audits()->paginate($this::$pagination_length_large);
                        break;
                    case "dentalcodes":
                        $list = $specimen->dental_codes()->paginate($this::$pagination_length_large);
                        break;
                    default: // should never get here.
                        return response()->json([ "data" => "Bad request: missing request parameters"], 400);
                }

                return ListResource::collection($list)->additional(["specimen" => $specimen,
                    "status"=>"success", 'message'=>"Specimen associations get successful"]);
//                return new CoraResourceCollection($list);
            } catch (QueryException $ex) {
                $this->logQueryException(__METHOD__, $request, $ex);
                return response()->json([ 'data' => trans('messages.model_update_unsuccessful', ['model'=>'Specimens']) ], 422);
            }
        } else {
            return response()->json([ "data" => "Not Authorized to edit specimen" ], 403);
        }
    }

    /**
     * Update the specified specimen association resource for the specified association type
     *
     * For a full listing of association type, see $allowed_association_types
     *
     * @param Request $request
     * @param SkeletalElement $specimen
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function updateAssociations(Request $request, SkeletalElement $specimen)
    {
        $this->logInfo(__METHOD__);
        if ($this->authorize('edit', [SkeletalElement::class, $specimen])) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            try {
                if ($request->has('type')) {
                    $type = $request->input('type');
                    $type = (!isset($type)) ? "" : strtolower($type);
                    if (! in_array($type, $this::$allowed_association_types)) {
                        return response()->json([ "data" => "Bad request: unsupported association type"], 400);
                    }
                } else {
                    return response()->json([ "data" => "Bad request: missing request parameters"], 400);
                }

                if ($request->has('id')) {
                    $ids = $request->input('id');
                    $listIds = (!isset($ids)) ? [] : array_map('trim', explode(',', $request->input('id')));
                } else if ($request->has('listIds')) {
                    $listIds = $request->input('listIds');
                } else {
                    return response()->json([ "data" => "Bad request: missing request parameters"], 400);
                }

                $response_data = $this->syncAssociations($specimen, $request, $listIds, $type);
                return response()->json(["data"=>$response_data, "specimen"=>$specimen,
                    "status"=>"success", 'message'=>"Specimen associations updated successful"],200);
            } catch (QueryException $ex) {
                $this->logQueryException(__METHOD__, $request, $ex);
                return response()->json([ 'data' => trans('messages.model_update_unsuccessful', ['model'=>'Specimens']) ], 422);
            }
        } else {
            return response()->json([ "data" => "Not Authorized to edit specimen" ], 403);
        }
    }

    /**
     * @param SkeletalElement $specimen
     * @param Request $request
     * @param $listIds
     * @param $type
     * @return array|\Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    protected function syncAssociations(SkeletalElement $specimen, Request $request, $listIds, $type) {
        $this->logInfo(__METHOD__);
        $listIds = isset($listIds) ? $listIds : [];
        $list = null;
        switch ($type) {
            case "articulations":
                $specimen->articulations()->sync($this->populateCreateFieldsOrgProjectFieldsForSyncWithIDs($listIds, $specimen));
                $list = $specimen->articulations()->paginate($this::$pagination_length_large);
                break;
            case "pairs":
                $specimen->pairs()->sync($this->populateCreateFieldsOrgProjectFieldsForSyncWithIDs($listIds, $specimen));
                $list = $specimen->pairs()->paginate($this::$pagination_length_large);
                break;
            case "refits":
                $specimen->refits()->sync($this->populateCreateFieldsOrgProjectFieldsForSyncWithIDs($listIds, $specimen));
                $list = $specimen->refits()->paginate($this::$pagination_length_large);
                break;
            case "morphologys":
            case "morphologies":
                $specimen->morphologys()->sync($this->populateCreateFieldsOrgProjectFieldsForSyncWithIDs($listIds, $specimen));
                $list = $specimen->morphologys()->paginate($this::$pagination_length_large);
                break;
            case "methods":
                $specimen->methods()->sync($this->populateCreateFieldsOrgProjectFieldsForSyncWithIDs($listIds, $specimen));
                $list = $specimen->methods()->paginate($this::$pagination_length_large);
                break;
            case "methodfeatures":
                if ($request->has('method_id')) {
                    $method_id = $request->input('method_id');
                    $this->logInfo(__METHOD__, "Method_id: ".$method_id);
                    $method = $specimen->methods()->where('id', $method_id)->first();
                    if ($method == null) {
                        $method = Method::find($method_id);
                        $specimen->methods()->attach($method->id, ['org_id' => $this->theOrg->id, 'project_id' => $this->theProject->id]);
                    }
                }
                $specimen->associateMethodFeatures($listIds);
                $list = $specimen->methodfeatures()->paginate($this::$pagination_length_large);
                break;
            case "taphonomys":
            case "taphonomies":
                $specimen->taphonomys()->sync($this->populateCreateFieldsOrgProjectFieldsForSyncWithIDs($listIds, $specimen));
                $list = $specimen->taphonomys()->paginate($this::$pagination_length_large);
                break;
            case "anomalys":
            case "anomalies":
                $specimen->anomalys()->sync($this->populateCreateFieldsOrgProjectFieldsForSyncWithIDs($listIds, $specimen));
                $list = $specimen->anomalys()->paginate($this::$pagination_length_large);
                break;
            case "measurements":
                $specimen->associateMeasurements($listIds);
                $list = $specimen->measurements()->paginate($this::$pagination_length_large);
                break;
            case "zones":
                $specimen->associateZones($listIds);
                $list = $specimen->zones()->paginate($this::$pagination_length_large);
                break;
            case "pathologys":
            case "pathologies":
                if ($request->has('pathology_id')) {
                    $pathology_id = $request->input('pathology_id');
                    $specimen->associatePathologys($pathology_id, $listIds);
                    $list = $specimen->pathologys()->paginate($this::$pagination_length_large);
                } else {
                    return [ "data" => "Bad request: missing request parameters" ];
                }
                break;
            case "traumas":
                if ($request->has('trauma_id')) {
                    $trauma_id = $request->input('trauma_id');
                    $specimen->associateTraumas($trauma_id, $listIds);
                    $list = $specimen->traumas()->paginate($this::$pagination_length_large);
                } else {
                    return [ "data" => "Bad request: missing request parameters" ];
                }
                break;
            case "tags":
                $specimen->tags()->sync($this->populateTsFieldsForSyncWithIDs($listIds));
                $list = $specimen->tags()->paginate($this::$pagination_length_large);
                break;
            case "instruments":
                $specimen->instruments()->syncWithoutDetaching($listIds);
                $list = $specimen->instruments()->paginate($this::$pagination_length_large);
                break;
            case "dentalcodes":
                $specimen->associateDentalCodes($listIds);
                $list = $specimen->dental_codes()->paginate($this::$pagination_length_large);
                break;
            default: // should never get here.
                return [ "data" => "Bad request: unsupported association type" ];
        }

        if (isset($list)) {
            return ListResource::collection($list);
        } else {
            return [ "data" => "Bad request: missing request parameters" ];
        }
//        return ListResource::collection($list)->additional(["specimen" => $specimen,
//            "status"=>"success", 'message'=>"Specimen associations updated successful"]);
    }

    /**
     * Update the specimen resources that have the same individual number
     * Request must contain the individual_number
     *
     * fields updated are
     * identification_date, remains_status, and remains_release_date
     *
     * @param SkeletalElementRequest $request
     * @param SkeletalElement $specimen
     * @return CoraResourceCollection|JsonResponse
     * @throws AuthorizationException
     */
    public function updateIndividualNumberFields(SkeletalElementRequest $request, SkeletalElement $specimen)
    {
        $this->logInfo(__METHOD__);
        if ($this->authorize('edit', [SkeletalElement::class, $specimen])) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            try {
                if ($request->has('individual_number')) {
                    $individual_number = $request->input('individual_number');
                } else {
                    return response()->json([ "data" => "Bad request: missing request parameters"], 400);
                }

                if (!$request->has('identification_date') && !$request->has('remains_status') && !$request->has('remains_release_date')) {
                    return response()->json([ "data" => "Bad request: missing request parameters"], 400);
                }

                SkeletalElement::where('individual_number', '=', $individual_number)->where('project_id', '=', $this->theProject->id)
                    ->update($request->only('identification_date', 'remains_status', 'remains_release_date'));
                $list = SkeletalElement::where('individual_number', '=', $individual_number)->where('project_id', '=', $this->theProject->id)
                    ->paginate($this::$pagination_length_large);
                return new CoraResourceCollection($list);
            } catch (QueryException $ex) {
                $this->logQueryException(__METHOD__, $request, $ex);
                return response()->json([ 'data' => trans('messages.model_update_unsuccessful', ['model'=>'Specimens']) ], 422);
            }
        } else {
            return response()->json([ "data" => "Not authorized to edit multiple resources" ], 403);
        }
    }

    /**
     * Get the specimen association methods and methodfeatures
     * ToDo: This is not being used currently, verify and remove if not used
     *
     * @param SkeletalElementRequest $request
     * @param SkeletalElement $specimen
     * @return CoraResource|JsonResponse
     * @throws AuthorizationException
     */
    public function getMethods(SkeletalElementRequest $request, SkeletalElement $specimen)
    {
        $this->logInfo(__METHOD__);
        if ($this->authorize('edit', [SkeletalElement::class, $specimen])) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            try {
                $specimen = SkeletalElement::where('id', '=', $specimen->id)->with('methods.features')->get();
                return new CoraResource($specimen);
            } catch (QueryException $ex) {
                $this->logQueryException(__METHOD__, $request, $ex);
                return response()->json([ 'data' => trans('messages.model_update_unsuccessful', ['model'=>'Specimens']) ], 422);
            }
        } else {
            return response()->json([ "data" => "Not authorized to edit multiple resources" ], 403);
        }
    }

    /**
     * Delete the specified specimen association resource for the specified association type
     *
     * For a full listing of association type, see $allowed_association_types
     *
     * @param Request $request
     * @param SkeletalElement $specimen
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function deleteAssociations(Request $request, SkeletalElement $specimen)
    {
        $this->logInfo(__METHOD__);
        if ($this->authorize('edit', [SkeletalElement::class, $specimen])) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            try {
                if ($request->has('type')) {
                    $type = $request->input('type');
                    $type = (!isset($type)) ? "" : strtolower($type);
                    if (! in_array($type, $this::$allowed_association_types)) {
                        return response()->json([ "data" => "Bad request: unsupported association type"], 400);
                    }
                } else {
                    return response()->json([ "data" => "Bad request: missing request parameters"], 400);
                }

                if ($request->has('id')) {
                    $ids = $request->input('id');
                    $listIds = (!isset($ids)) ? [] : array_map('trim', explode(',', $request->input('id')));
                } else if ($request->has('listIds')) {
                    $listIds = $request->input('listIds');
                } else {
                    return response()->json([ "data" => "Bad request: missing request parameters"], 400);
                }

                $response_data = $this->syncDeleteAssociations($specimen, $request, $listIds, $type);
                return response()->json(["data"=>$response_data, "specimen"=>$specimen,
                    "status"=>"success", 'message'=>"Specimen associations updated successful"],200);
            } catch (QueryException $ex) {
                $this->logQueryException(__METHOD__, $request, $ex);
                return response()->json([ 'data' => trans('messages.model_update_unsuccessful', ['model'=>'Specimens']) ], 422);
            }
        } else {
            return response()->json([ "data" => "Not Authorized to edit specimen" ], 403);
        }
    }

    /**
     * @param SkeletalElement $specimen
     * @param Request $request
     * @param $listIds
     * @param $type
     * @return JsonResponse|\Illuminate\Http\Resources\Json\AnonymousResourceCollection|string[]
     */
    protected function syncDeleteAssociations(SkeletalElement $specimen, Request $request, $listIds, $type) {
        $this->logInfo(__METHOD__);
        $listIds = isset($listIds) ? $listIds : [];
        $list = null;
        switch ($type) {
            case "methods":
                if ($request->has('method_id')) {
                    $method_id = $request->input('method_id');
                    $this->logInfo(__METHOD__, "Method_id: ".$method_id);
                    $method = $specimen->methods()->where('id', $method_id)->first();
                    if ($method != null) {
                        $methodfeatures = $specimen->methodfeatures()->get();
                        foreach ($methodfeatures as $feature) {
                            if ($feature->method_id == $method_id) {
                                $specimen->methodfeatures()->detach($feature->id);
                            }
                        }
                        $specimen->methods()->detach($method->id);
                    }
                } else {
                    return response()->json([ "data" => "Bad request: missing request parameters (method_id)"], 400);
                }
                $list = $specimen->methodfeatures()->paginate($this::$pagination_length_large);
                break;
            case "pathologys":
            case "pathologies":
                if ($request->has('pathology_id')) {
                    $pathology_id = $request->input('pathology_id');
                    $this->logInfo(__METHOD__, "Pathology_id: ".$pathology_id);
                    $pathology = $specimen->pathologys()->where('pathologys.id', $pathology_id)->first();
                    if ($pathology != null) {
                        $specimen->pathologys()->detach($pathology->id);
                    }
                } else {
                    return response()->json([ "data" => "Bad request: missing request parameters (pathology_id)"], 400);
                }
                $list = $specimen->pathologys()->paginate($this::$pagination_length_large);
                break;
            case "traumas":
                if ($request->has('trauma_id')) {
                    $trauma_id = $request->input('trauma_id');
                    $this->logInfo(__METHOD__, "Trauma_id: ".$trauma_id);
                    $trauma = $specimen->traumas()->where('traumas.id', $trauma_id)->first();
                    if ($trauma != null) {
                        $specimen->traumas()->detach($trauma->id);
                    }
                } else {
                    return response()->json([ "data" => "Bad request: missing request parameters (trauma_id)"], 400);
                }
                $list = $specimen->traumas()->paginate($this::$pagination_length_large);
                break;
            default: // should never get here.
                return [ "data" => "Bad request: unsupported association type" ];
        }

        if (isset($list)) {
            return ListResource::collection($list);
        } else {
            return [ "data" => "Bad request: missing request parameters" ];
        }
    }

    public function getAllAssociations(SkeletalElementRequest $request, SkeletalElement $specimen)
    {
        $this->logInfo(__METHOD__);
        if ($this->authorize('edit', [SkeletalElement::class, $specimen])) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            try {
                $specimen = SkeletalElement::where('id', '=', $specimen->id)->with(['articulations', 'pairs', 'refits', 'morphologys'])->get();
                return new CoraResource($specimen);
            } catch (QueryException $ex) {
                $this->logQueryException(__METHOD__, $request, $ex);
                return response()->json([ 'data' => trans('messages.model_update_unsuccessful', ['model'=>'Specimens']) ], 422);
            }
        } else {
            return response()->json([ "data" => "Not authorized to edit multiple resources" ], 403);
        }
    }

    public function getPat(SkeletalElementRequest $request, SkeletalElement $specimen)
    {
        $this->logInfo(__METHOD__);
        if ($this->authorize('edit', [SkeletalElement::class, $specimen])) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            try {
                $specimen = SkeletalElement::where('id', '=', $specimen->id)->with(['pathologys', 'anomalys', 'traumas'])->get();
                return new CoraResource($specimen);
            } catch (QueryException $ex) {
                $this->logQueryException(__METHOD__, $request, $ex);
                return response()->json([ 'data' => trans('messages.model_update_unsuccessful', ['model'=>'Specimens']) ], 422);
            }
        } else {
            return response()->json([ "data" => "Not authorized to edit multiple resources" ], 403);
        }
    }
}