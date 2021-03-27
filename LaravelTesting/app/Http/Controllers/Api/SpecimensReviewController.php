<?php

namespace App\Http\Controllers\Api;

use App\Dna;
use App\Http\Controllers\Controller;
use App\Http\Resources\CoraResource;
use App\Http\Resources\CoraResourceCollection;
use App\Http\Resources\ListResource;
use App\Measurement;
use App\Method;
use App\SkeletalElementReview;
use App\Zone;
use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use App\SkeletalElement;

class SpecimensReviewController extends Controller
{
    public static $allowed_types = ["general", "pairs", "articulations", "refits", "morphologys", "morphologies", "methods", "methodfeatures",
        "anomalys", "anomalies", "taphonomys", "taphonomies", "measurements", "zones", "pathologys", "pathologies", "traumas", 'instruments',
        "tags", "comments", "dna", "isotopes"];

    public function index()
    {
        $this->logInfo(__METHOD__);
        if ($this->authorize('browse', [ SkeletalElement::class ])) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            // all types
            $list = SkeletalElementReview::latest()->paginate($this::$pagination_length_large);
            return new CoraResourceCollection($list);
        }else{
            return response()->json([ "data" => "Not authorized to view all resources" ], 403);
        }
    }

    public function show(Request $request, SkeletalElement $specimen)
    {
        $this->logInfo(__METHOD__);
        if ($this->authorize('browse', [ SkeletalElement::class, $specimen->id ])) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            if ($request->has('type')) {
                $type = $request->query('type');

                // temp before we add subtype for the review record
                if (!strstr($type, 'dna')) {
                    $type = (!isset($type)) ? "" : strtolower($type);
                }

                // temp before we add subtype for the review record
                if (!strstr($type, 'dna')) {
                    if (!in_array($type, $this::$allowed_types)) {
                        return response()->json(["data" => "Bad request: unsupported review type"], 400);
                    }
                }

            } else {
                return response()->json([ "data" => "Bad request: missing review parameters"], 400);
            }
            $specimenReview = $specimen->reviewByType($type);
            return new CoraResource($specimenReview);
        } else {
            return response()->json([ "data" => "Not authorized to view resource" ], 403);
        }
    }

    public function store(Request $request) {
        $this->logInfo(__METHOD__);
        if ($this->authorize('add', SkeletalElement::class)) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            if ($request->has('type') || $request->input('type')) {
                $type = $request->query('type');
                $type = (!isset($type)) ? "" : strtolower($type);
                if (! in_array($type, $this::$allowed_types)) {
                    $type = $request->input('type');
                    $type = (!isset($type)) ? "" : strtolower($type);
                    if (! in_array($type, $this::$allowed_types)) {
                        return response()->json([ "data" => "Bad request: unsupported review type"], 400);
                    }
                }
            } else {
                return response()->json([ "data" => "Bad request: missing review parameters"], 400);
            }
            $this->logInfo(__METHOD__, "type: ".$type." specimen: ".$request->input('se_id'));

            if ($type === "dna") {
                $type = $type . "-" . $request->input('dna_id');
            }
            $specimen = SkeletalElement::where('id', '=', $request->input('se_id'))->firstOrFail();
            try {
                $object = SkeletalElementReview::create([
                    'se_id' => $request->input('se_id'),
                    'type' => $type,
                    'original' => json_encode($request->input('original')),
                    'review' => json_encode($request->input('review')),
                    'reviewer_id' => $this->theUser->id,
                ]);
                return new CoraResource($object);
            } catch (QueryException $ex) {
                return response()->json([ "data" => "Failed to create review for given Skeletal Element" ], 500);
            }
        }else {
            return response()->json([ "data" => "Not authorized to view resource" ], 403);
        }
    }

    // ToDo Work in progress
    // Internal function to create Review Records for the specimen by providing string(type)
    protected function createReviewRecord(SkeletalElement $specimen, $type, $original, $review, $accepted = null)
    {
        try {
            $object = SkeletalElementReview::create([
                'se_id' => $specimen->id,
                'type' => $type,
                'original' => json_encode($original),
                'review' => json_encode($review),
                'reviewer_id' => $this->theUser->id, // future when we add the migration change
                'accepted' => $accepted
            ]);
            return new CoraResource($object);
        } catch (QueryException $ex) {
            return response()->json(["data" => "Failed to create review for given Skeletal Element"], 500);
        }
    }

    public function getAssociationData(Request $request, SkeletalElement $specimen)
    {
        $this->logInfo(__METHOD__);
        if ($this->authorize('browse', [ SkeletalElement::class ])) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            if($request->input('type')) {
                switch ($request->input('type')) {
                    case 'articulations':
                        return $specimen->getAllPossibleArticulations()->pluck('key_bone_side', 'id');
                        break;
                    case 'refits':
                        return $specimen->getAllPossibleRefits()->pluck('key_bone_side', 'id');
                        break;
                    case 'pairs':
                        return $specimen->getAllPossiblePairMatches()->pluck('key_bone_side', 'id');
                        break;
                    case 'morphologys':
                        return $specimen->getAllPossibleMorphologysList()->pluck('key_bone_side', 'id');
                        break;
                }
            }
        }else{
            return response()->json([ "data" => "Not authorized to view resource" ], 403);
        }
    }

    // ToDo
    public function accept(Request $request, SkeletalElement $specimen){
        $this->logInfo(__METHOD__);
        if ($this->authorize('add', SkeletalElement::class)) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            if ($request->has('type') || $request->input('type')) {
                $type = $request->query('type');
                $type = (!isset($type)) ? "" : strtolower($type);
                if (! in_array($type, $this::$allowed_types)) {
                    $type = $request->input('type');
                    $type = (!isset($type)) ? "" : strtolower($type);
                    if (! in_array($type, $this::$allowed_types)) {
                        return response()->json([ "data" => "Bad request: unsupported review type"], 400);
                    }
                }
            } else {
                return response()->json([ "data" => "Bad request: missing review parameters"], 400);
            }


            $data = $request->input('review');
            switch ($type) {
                case('dna'):
                    $this->populateUpdateFields($data);
                    Dna::where('id', $data['id'])->update($data);
                    $this->createReviewRecord($specimen, 'dna' . '-' . $request->input('dna_id'), $data, $data, true);
                    break;
                case('general'):
//                    $specimenReview = $specimen->reviewByType('general');
//                    $specimen->accepted = true; // future when we add the migration change
                    $specimen->update($data);
                    break;
                case('methods'):
                    foreach ($data['methods'] as $method_id => $method) {
                        foreach ($method['features'] as $method_feature_id => $method_feature) {
                            $specimen->methodfeatures()->updateExistingPivot($method_feature_id, ['score' => $method_feature['score']]);
                        }
                    }
                    $this->createReviewRecord($specimen, 'methods', $data, $data, true);
                    break;
                case('dnaprofile'):
                    break;
                case "taphonomys":
                case "taphonomies":
                    $specimen->taphonomys()->sync($this->populateCreateFieldsOrgProjectFieldsForSyncWithIDs($data, $specimen));
                    break;
                case('measurements'):
                    $specimenMeasurements = Measurement::where('sb_id', $specimen->sb_id)->get();
                    $collection = collect($data);
                    $specimenReview = $collection->map(function ($measure, $id) {
                        return [
                            "id" => $id,
                            "measure" => $measure
                        ];
                    });
                    foreach ($specimenMeasurements as $specimenMeasurement) {
                        if (in_array($specimenMeasurement->id, array_keys($specimenReview->toArray()))) {
                            if ($specimen->measurements()->where('measurement_id', $specimenMeasurement->id)->exists()) {
                                $specimen->measurements()->updateExistingPivot($specimenMeasurement->id, ['measure' => (int)$specimenReview[$specimenMeasurement->id]["measure"], 'updated_by' => $this->theUser->name]);
                            } else {
                                $specimen->measurements()->attach($specimenMeasurement->id, ['measure' => (int)$specimenReview[$specimenMeasurement->id]["measure"], 'org_id' => $specimen->org_id, 'project_id' => $specimen->project_id, 'created_by' => $this->theUser->name, 'updated_by' => $this->theUser->name]);
                            }
                        } else {
                            $specimen->measurements()->where('measurement_id', $specimenMeasurement->id)->wherePivot('se_id', $specimen->id)->wherePivot('measurement_id', $specimenMeasurement->id)->detach();
                        }
                    }
                    $this->createReviewRecord($specimen, 'measurements', $data, $data, true);
                    break;
                case('articulations'):
                    $specimen->articulations()->sync($this->populateCreateFieldsOrgProjectFieldsForSyncWithIDs($data, $specimen));
                    break;
                case('pairs'):
                    $specimen->pairs()->sync($this->populateCreateFieldsOrgProjectFieldsForSyncWithIDs($data, $specimen));
                    break;
                case('refits'):
                    $specimen->refits()->sync($this->populateCreateFieldsOrgProjectFieldsForSyncWithIDs($data, $specimen));
                    break;
                case('pathologys'):
                    foreach ($data as $pathology) {
                        $syncData[$pathology['pathology_id']] = ['zone_id' => (int)$pathology['zone_id'], 'additional_information' => $pathology['additional_information'],
                            'org_id' => $specimen->org_id, 'project_id' => $specimen->project_id,
                            'created_by' => $this->theUser->name, 'updated_by' => $this->theUser->name];
                    }
                    $specimen->pathologys()->sync($syncData);
                    $this->createReviewRecord($specimen, 'pathologys', $data, $data, true);
                    break;
                case('traumas'):
                    foreach ($data as $trauma) {
                        $syncData[$trauma['trauma_id']] = ['zone_id' => (int)$trauma['zone_id'], 'additional_information' => $trauma['additional_information'],
                            'org_id' => $specimen->org_id, 'project_id' => $specimen->project_id,
                            'created_by' => $this->theUser->name, 'updated_by' => $this->theUser->name];
                    }
                    $specimen->traumas()->sync($syncData);
                    $this->createReviewRecord($specimen, 'traumas', $data, $data, true);
                    break;
                case('anomalys'):
                    $specimen->anomalys()->sync($this->populateCreateFieldsOrgProjectFieldsForSyncWithIDs($data, $specimen));
                    $this->createReviewRecord($specimen, 'anomalys', $data, $data, true);
                    break;
                case('zones'):
                    $zones = Zone::where('sb_id', $specimen->sb_id)->get(); //zones for this $skeletalelements

                    $this->logInfo(__METHOD__, $zones . "this");

                    foreach ($zones as $zone) {
                        if (in_array($zone->id, $data)) {
                            //if the zone ID is in the array we received
                            if ($specimen->zones()->where('zone_id', $zone->id)->exists()) {
                                // update $skeletalelements pivot table if the zone
                                $specimen->zones()->updateExistingPivot($zone->id, ['presence' => true]);
                            } else {
                                //if it's not present $skeletalelements->zones attach a new one
                                $specimen->zones()->attach($zone->id, ['presence' => true, 'org_id' => $specimen->org_id, 'project_id' => $specimen->project_id]);
                            }
                        } else {
                            if ($specimen->zones()->where('zone_id', $zone->id)->exists()) {
                                // if the zone already exists and it shows present, change the flag presence false
                                $specimen->zones()->updateExistingPivot($zone->id, ['presence' => false]);
                            }
                        }
                    }
                    $this->createReviewRecord($specimen, 'zones', $data, $data, true);
                    break;
                default:
                    return response()->json([ "data" => "Bad request: incorrect request parameters"], 400);
            }
            return response()->json([ 'data' => "Resource updated successfully" ], 200);
        }
    }

    public function complete(Request $request, SkeletalElement $specimen) {
        $this->logInfo(__METHOD__);
        if ($this->authorize('edit', SkeletalElement::class)) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            try {
                $specimen->reviewed = true;
                $specimen->reviewed_at = Carbon::now()->toDateString();
                $specimen->reviewer_id = $this->theUser->id;
                $specimen->save();
                return response()->json([ 'data' => "Resource updated successfully" ], 200);
            } catch (QueryException $ex) {
                return response()->json([ "data" => "Failed to update review complete for given Skeletal Element" ], 500);
            }
        }
    }

    public function notifyReviewReady(Request $request, SkeletalElement $specimen) {
        $this->logInfo(__METHOD__);
        if ($this->authorize('edit', SkeletalElement::class)) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            try {
                // Do logic to send notifications
                return response()->json([ 'data' => "Notification successfully sent" ], 200);
            } catch (QueryException $ex) {
                return response()->json([ "data" => "Failed to send notification" ], 500);
            }
        }
    }
}
