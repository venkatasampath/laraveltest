<?php

/**
 * Cora Api HaplogroupsController
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
use App\Http\Requests\HaplogroupRequest;
use App\Http\Resources\CoraResource;
use App\Http\Resources\CoraResourceCollection;
use App\Haplogroup;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * Class HaplogroupsController
 * @package App\Http\Controllers\Api
 */
class HaplogroupsController extends Controller
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
        if ($this->authorize('browse', [ Haplogroup::class ])) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            if ($this->theUser->isAdmin()) {
                $list = Haplogroup::paginate($this::$pagination_length_large);
            } else if ($this->theUser->isOrgAdmin()) {
                $list = Haplogroup::paginate($this::$pagination_length_large);
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
        if ($this->authorize('add', Haplogroup::class)) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            try {
                if (!$this->hasInput($request)) {
                    return response()->json([ "data" => "Request is empty" ], 400);
                }
                $object = Haplogroup::create($request->all());
                return new CoraResource($object);
            } catch (QueryException $ex) {
                $this->logQueryException(__METHOD__, $request, $ex);
                return response()->json([ 'data' => trans('messages.model_add_unsuccessful', ['model'=>'Haplogroups']) ], 422);
            }
        } else {
            return response()->json([ "data" => "Not authorized to create resource" ], 403);
        }
    }

    /**
     * Display the specified resource.
     * @param Request $request
     * @param Haplogroup|null $haplogroup
     * @return CoraResource|JsonResponse
     * @throws AuthorizationException
     */
    public function show(Request $request, Haplogroup $haplogroup = null)
    {
        $this->logInfo(__METHOD__);

        // Check if user is authorized to perform the action
        if ($this->authorize('read', [ Haplogroup::class, $haplogroup ])) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            if (!isset($haplogroup)) {
                if ($request->query('id')) {
                    $haplogroup = Haplogroup::where('id', $request->query('id'))->first();
                }
                if (!isset($haplogroup)) {
                    return response()->json([ "data" => "Haplogroup not found" ], 404);
                }
            }
            return new CoraResource($haplogroup);
        } else {
            return response()->json([ "data" => "Not authorized to view resource" ], 403);
        }
    }

    /**
     * Update an existing haplogroup
     * @param HaplogroupRequest $request
     * @param Haplogroup $haplogroup
     * @return CoraResource|JsonResponse
     * @throws AuthorizationException
     */
    public function update(HaplogroupRequest $request, Haplogroup $haplogroup)
    {
        $this->logInfo(__METHOD__);
        if ($this->authorize('edit', [Haplogroup::class, $haplogroup])) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            try {
                if (!$this->hasInput($request)) {
                    return response()->json([ "data" => "Request is empty" ], 400);
                }
                $this->logInfo(__METHOD__, "Request: ".$request);
                $haplogroup->update($request->all());
                return new CoraResource($haplogroup);
            } catch (QueryException $ex) {
                $this->logQueryException(__METHOD__, $request, $ex);
                return response()->json([ 'data' => trans('messages.model_update_unsuccessful', ['model'=>'Haplogroups']) ], 422);
            }
        } else {
            return response()->json([ "data" => "Not authorized to update resource" ], 403);
        }
    }

    /**
     * Remove the specified resource from storage.
     * @param Request $request
     * @param Haplogroup $haplogroup
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function destroy(Request $request, Haplogroup $haplogroup)
    {
        $this->logInfo(__METHOD__);
        if ($this->authorize('delete', [Haplogroup::class, $haplogroup])) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            try {
                $haplogroup->delete();
                return response()->json([ 'data' => "Resource deleted successfully" ], 200);
            } catch (QueryException $ex) {
                $this->logQueryException(__METHOD__, $request, $ex);
                return response()->json([ 'data' => trans('messages.model_delete_unsuccessful', ['model'=>'Haplogroups']) ], 422);
            }
        } else {
            return response()->json([ "data" => "Not authorized to delete resource" ], 403);
        }
    }
}
