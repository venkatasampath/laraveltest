<?php

/**
 * Cora Api InstrumentsController
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

use App\Http\Controllers\Controller;
use App\Http\Requests\InstrumentRequest;
use App\Http\Resources\CoraResource;
use App\Http\Resources\CoraResourceCollection;
use App\Http\Resources\ListResource;
use App\Instrument;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * Class InstrumentsController
 * @package App\Http\Controllers\Api
 */
class InstrumentsController extends Controller
{
    /**
     * @var array
     */
    public static $allowed_association_types = ["users", "specimens"];

    /**
     * Display a listing of the resource.
     * @param Request $request
     * @return CoraResourceCollection|JsonResponse
     * @throws AuthorizationException
     */
    public function index(Request $request)
    {
        $this->logInfo(__METHOD__);
        if ($this->authorize('browse', [ Instrument::class ])) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            if ($this->theUser->isAdmin()) {
                $list = Instrument::paginate($this::$pagination_length_large);
            } else if ($this->theUser->isOrgAdmin()) {
                $list = Instrument::where('org_id', $this->theOrg->id)->paginate($this::$pagination_length_large);
            } else {
                return response()->json([ "data" => "Not authorized to view resource" ], 403);
            }
            return new CoraResourceCollection($list);
        } else {
            return response()->json([ "data" => "Not authorized to view all resources" ], 403);
        }
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return CoraResource|JsonResponse
     * @throws AuthorizationException
     */
    public function store(Request $request)
    {
        $this->logInfo(__METHOD__);
        if ($this->authorize('add', Instrument::class)) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            try {
                if (!$this->hasInput($request)) {
                    return response()->json([ "data" => "Request is empty" ], 400);
                }
                $request['org_id'] = $this->theOrg->id; // Set the org id.
                $object = Instrument::create($request->all());
                return new CoraResource($object);
            } catch (QueryException $ex) {
                $this->logQueryException(__METHOD__, $request, $ex);
                return response()->json([ 'data' => trans('messages.model_add_unsuccessful', ['model'=>'Instruments']) ], 422);
            }
        } else {
            return response()->json([ "data" => "Not authorized to create resource" ], 403);
        }
    }

    /**
     * Display the specified resource.
     * @param Request $request
     * @param Instrument|null $instrument
     * @return CoraResource|JsonResponse
     * @throws AuthorizationException
     */
    public function show(Request $request, Instrument $instrument = null)
    {
        $this->logInfo(__METHOD__);

        // Check if user is authorized to perform the action
        if ($this->authorize('read', [ Instrument::class, $instrument ])) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            if (!isset($instrument)) {
                if ($request->query('id')) {
                    $instrument = Instrument::where('id', $request->query('id'))->first();
                }
                if (!isset($instrument)) {
                    return response()->json([ "data" => "Instrument not found" ], 404);
                }
            }
            return new CoraResource($instrument);
        } else {
            return response()->json([ "data" => "Not authorized to view resource" ], 403);
        }
    }

    /**
     * Update an existing instrument
     * @param InstrumentRequest $request
     * @param Instrument $instrument
     * @return CoraResource|JsonResponse
     * @throws AuthorizationException
     */
    public function update(InstrumentRequest $request, Instrument $instrument)
    {
        $this->logInfo(__METHOD__);
        if ($this->authorize('edit', [Instrument::class, $instrument])) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            try {
                if (!$this->hasInput($request)) {
                    return response()->json([ "data" => "Request is empty" ], 400);
                }
                $this->logInfo(__METHOD__, "Request: ".$request);
                $instrument->update($request->all());
                return new CoraResource($instrument);
            } catch (QueryException $ex) {
                $this->logQueryException(__METHOD__, $request, $ex);
                return response()->json([ 'data' => trans('messages.model_update_unsuccessful', ['model'=>'Instruments']) ], 422);
            }
        } else {
            return response()->json([ "data" => "Not authorized to update resource" ], 403);
        }
    }

    /**
     * Remove the specified resource from storage.
     * @param Request $request
     * @param Instrument $instrument
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function destroy(Request $request, Instrument $instrument)
    {
        $this->logInfo(__METHOD__);
        if ($this->authorize('delete', [Instrument::class, $instrument])) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            try {
                $instrument->delete();
                return response()->json([ 'data' => "Resource deleted successfully" ], 200);
            } catch (QueryException $ex) {
                $this->logQueryException(__METHOD__, $request, $ex);
                return response()->json([ 'data' => trans('messages.model_delete_unsuccessful', ['model'=>'Instruments']) ], 422);
            }
        } else {
            return response()->json([ "data" => "Not authorized to delete resource" ], 403);
        }
    }

    /**
     * Display a listing of the users assigned to the specified instrument.
     *
     * @param Request $request
     * @param Instrument $instrument
     * @return CoraResourceCollection|\Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function getUsers(Request $request, Instrument $instrument)
    {
        $this->logInfo(__METHOD__);
        if ($this->authorize('read', [ Instrument::class, $instrument ])) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            try {
                $list = $instrument->users()->paginate($this::$pagination_length_large);
                return new CoraResourceCollection($list);
            } catch (QueryException $ex) {
                $this->logQueryException(__METHOD__, $request, $ex);
                return response()->json([ 'data' => trans('messages.model_index_view_unsuccessful', ['model'=>'Instrument Users']) ], 422);
            }
        } else {
            return response()->json([ "data" => "Not authorized to view all resources" ], 403);
        }
    }

    /**
     * Display a listing of the instrument association resource for the specified association type
     *
     * For a full listing of association type, see $allowed_association_types
     *
     * @param Request $request
     * @param Instrument $instrument
     * @return JsonResponse|\Illuminate\Http\Resources\Json\AnonymousResourceCollection
     * @throws AuthorizationException
     */
    public function getAssociations(Request $request, Instrument $instrument)
    {
        $this->logInfo(__METHOD__);
        if ($this->authorize('read', [Instrument::class, $instrument])) {
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
                    case "users":
                        $list = $instrument->users()->paginate($this::$pagination_length_large);
                        break;
                    default: // should never get here.
                        return response()->json([ "data" => "Bad request: missing request parameters"], 400);
                }

                return ListResource::collection($list)->additional(["instrument" => $instrument,
                    "status"=>"success", 'message'=>"Instrument associations get successful"]);
            } catch (QueryException $ex) {
                $this->logQueryException(__METHOD__, $request, $ex);
                return response()->json([ 'data' => trans('messages.model_update_unsuccessful', ['model'=>'Instrument']) ], 422);
            }
        } else {
            return response()->json([ "data" => "Not Authorized to edit instrument" ], 403);
        }
    }

    /**
     * Update the specified instrument association resource for the specified association type
     *
     * For a full listing of association type, see $allowed_association_types
     *
     * @param Request $request
     * @param Instrument $instrument
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function updateAssociations(Request $request, Instrument $instrument)
    {
        $this->logInfo(__METHOD__);
        if ($this->authorize('edit', [Instrument::class, $instrument])) {
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

                $response_data = $this->syncAssociations($instrument, $request, $listIds, $type);
                return response()->json(["data"=>$response_data, "instrument"=>$instrument,
                    "status"=>"success", 'message'=>"Instrument associations updated successful"],200);
            } catch (QueryException $ex) {
                $this->logQueryException(__METHOD__, $request, $ex);
                return response()->json([ 'data' => trans('messages.model_update_unsuccessful', ['model'=>'Instrument']) ], 422);
            }
        } else {
            return response()->json([ "data" => "Not Authorized to edit instrument" ], 403);
        }
    }

    /**
     * @param Instrument $instrument
     * @param Request $request
     * @param $listIds
     * @param $type
     * @return array|\Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    protected function syncAssociations(Instrument $instrument, Request $request, $listIds, $type) {
        $this->logInfo(__METHOD__);
        $listIds = isset($listIds) ? $listIds : [];
        $list = null;
        switch ($type) {
            case "users":
                $instrument->users()->sync($this->populateCreateFieldsForSyncWithIDs($listIds));
                $list = $instrument->users()->paginate($this::$pagination_length_large);
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
}
