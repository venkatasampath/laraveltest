<?php

/**
 * Cora Api AccessionsController
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
use App\Http\Requests\AccessionRequest;
use App\Http\Resources\CoraResource;
use App\Http\Resources\CoraResourceCollection;
use App\Accession;
use App\Http\Resources\SpecimenListResource;
use App\Project;
use App\Scopes\ProjectScope;
use App\SkeletalElement;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * Class AccessionsController
 * @package App\Http\Controllers\Api
 */
class AccessionsController extends Controller
{
    /**
     * Display a listing of the resource.
     * @param Request $request
     * @return CoraResourceCollection|JsonResponse
     * @throws AuthorizationException
     */
    public function index(Request $request)
    {
        $this->logInfo(__METHOD__);
        if ($this->authorize('browse', [ Accession::class ])) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            if ($this->theUser->isAdmin()) {
                $list = Accession::paginate($this::$pagination_length_large);
            } else if ($this->theUser->isOrgAdmin()) {
                $list = Accession::where('org_id', $this->theOrg->id)->paginate($this::$pagination_length_large);
            } else if ($this->theUser->id === $this->theProject->manager_id) {
                $list = Accession::where('org_id', $this->theOrg->id)->where('project_id', $this->theProject->id)->paginate($this::$pagination_length_large);
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
        if ($this->authorize('add', Accession::class)) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            try {
                if (!$this->hasInput($request)) {
                    return response()->json([ "data" => "Request is empty" ], 400);
                }
                $request['org_id'] = $this->theOrg->id; // Set the org id.
                $object = Accession::create($request->all());
                return new CoraResource($object);
            } catch (QueryException $ex) {
                $this->logQueryException(__METHOD__, $request, $ex);
                return response()->json([ 'data' => trans('messages.model_add_unsuccessful', ['model'=>'Accessions']) ], 422);
            }
        } else {
            return response()->json([ "data" => "Not authorized to create resource" ], 403);
        }
    }

    /**
     * Display the specified resource.
     * @param Request $request
     * @param Accession|null $accession
     * @return CoraResource|JsonResponse
     * @throws AuthorizationException
     */
    public function show(Request $request, Accession $accession = null)
    {
        $this->logInfo(__METHOD__);

        // Check if user is authorized to perform the action
        if ($this->authorize('read', [ Accession::class, $accession ])) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            if (!isset($accession)) {
                if ($request->query('id')) {
                    $accession = Accession::where('id', $request->query('id'))->first();
                }
                if (!isset($accession)) {
                    return response()->json([ "data" => "Accession not found" ], 404);
                }
            }
            return new CoraResource($accession);
        } else {
            return response()->json([ "data" => "Not authorized to view resource" ], 403);
        }
    }

    /**
     * Update an existing accession
     * @param AccessionRequest $request
     * @param Accession $accession
     * @return CoraResource|JsonResponse
     * @throws AuthorizationException
     */
    public function update(AccessionRequest $request, Accession $accession)
    {
        $this->logInfo(__METHOD__);
        if ($this->authorize('edit', [Accession::class, $accession])) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            try {
                if (!$this->hasInput($request)) {
                    return response()->json([ "data" => "Request is empty" ], 400);
                }
                $this->logInfo(__METHOD__, "Request: ".$request);
                $accession->update($request->all());
                return new CoraResource($accession);
            } catch (QueryException $ex) {
                $this->logQueryException(__METHOD__, $request, $ex);
                return response()->json([ 'data' => trans('messages.model_update_unsuccessful', ['model'=>'Accessions']) ], 422);
            }
        } else {
            return response()->json([ "data" => "Not authorized to update resource" ], 403);
        }
    }

    /**
     * Remove the specified resource from storage.
     * @param Request $request
     * @param Accession $accession
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function destroy(Request $request, Accession $accession)
    {
        $this->logInfo(__METHOD__);
        if ($this->authorize('delete', [Accession::class, $accession])) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            try {
                $accession->delete();
                return response()->json([ 'data' => "Resource deleted successfully" ], 200);
            } catch (QueryException $ex) {
                $this->logQueryException(__METHOD__, $request, $ex);
                return response()->json([ 'data' => trans('messages.model_delete_unsuccessful', ['model'=>'Accessions']) ], 422);
            }
        } else {
            return response()->json([ "data" => "Not authorized to delete resource" ], 403);
        }
    }

    /**
     * Display a listing of the specimens belonging to the specified project.
     *
     * @param Request $request
     * @param Project $project
     * @return CoraResourceCollection|\Illuminate\Http\JsonResponse|\Illuminate\Http\Resources\Json\AnonymousResourceCollection
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function getSpecimens(Request $request, Accession $accession)
    {
        $this->logInfo(__METHOD__);
        if ($this->authorize('browse', [ SkeletalElement::class ])) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            try {
                $this->logInfo(__METHOD__,"An:".$accession->number." P1:".$accession->provenance1." P2:".$accession->provenance2);
                $query = SkeletalElement::withoutGlobalScopes([ProjectScope::class])->where('project_id', $this->theProject->id);
                $query = isset($accession->number) ? $query->where('accession_number', $accession->number) : $query;
                $query = isset($accession->provenance1) ? $query->where('provenance1', $accession->provenance1) : $query;
                $query = isset($accession->provenance2) ? $query->where('provenance2', $accession->provenance2) : $query;
                $list = $query->paginate($this::$pagination_length_large);
                $this->logInfo(__METHOD__,"Specimen list coount:".$list->count());
                return new CoraResourceCollection($list);
            } catch (QueryException $ex) {
                $this->logQueryException(__METHOD__, $request, $ex);
                return response()->json([ 'data' => trans('messages.model_index_view_unsuccessful', ['model'=>'Project Specimens']) ], 422);
            }
        } else {
            return response()->json([ "data" => "Not authorized to view all resources" ], 403);
        }
    }
}
