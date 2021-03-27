<?php

/**
 * Cora Api DnasController
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
use App\Http\Requests\DnaRequest;
use App\Dna;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use App\Http\Resources\CoraResource;
use App\Http\Resources\CoraResourceCollection;
use Illuminate\Http\Request;

/**
 * Class DnasController
 * @package App\Http\Controllers\Api
 */
class DnasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return CoraResourceCollection|JsonResponse
     * @throws AuthorizationException
     */
    public function index(Request $request)
    {
        $this->logInfo(__METHOD__);
        if ($this->authorize('browse', [ Dna::class ])) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            $specimen_id = $request->input('se_id');
            if (isset($specimen_id)) {
                $list = Dna::where("se_id", "=", $specimen_id)->paginate($this::$pagination_length_large);
            } else {
                // Note ProjectScope is already applied.
                $list = Dna::paginate($this::$pagination_length_large);
            }

            return new CoraResourceCollection($list);
        } else {
            return response()->json([ "data" => "Not authorized to view all resources" ], 403);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param DnaRequest $request
     * @return CoraResource|JsonResponse
     * @throws AuthorizationException
     */
    public function store(DnaRequest $request)
    {
        $this->logInfo(__METHOD__);
        if ($this->authorize('add', Dna::class)) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            try {
                if (!$this->hasInput($request)) {
                    return response()->json([ "data" => "Request is empty" ], 400);
                }
                $object = Dna::create($request->all());
                return new CoraResource($object);
            } catch (QueryException $ex) {
                $this->logQueryException(__METHOD__, $request, $ex);
                return response()->json([ 'data' => trans('messages.model_add_unsuccessful', ['model'=>'Dnas']) ], 422);
            }
        } else {
            return response()->json([ "data" => "Not authorized to create resource" ], 403);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param Dna $dna
     * @return CoraResource|JsonResponse
     * @throws AuthorizationException
     */
    public function show(Dna $dna)
    {
        $this->logInfo(__METHOD__);
        if ($this->authorize('read', [ Dna::class, $dna ])) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            return new CoraResource($dna);
        } else {
            return response()->json([ "data" => "Not authorized to view resource" ], 403);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param DnaRequest $request
     * @param Dna $dna
     * @return CoraResource|JsonResponse
     * @throws AuthorizationException
     */
    public function update(DnaRequest $request, Dna $dna)
    {
        $this->logInfo(__METHOD__, $dna->se->id.":".$dna->se->key." Sample Number:".$dna->sample_number);
        if ($this->authorize('edit', [Dna::class, $dna])) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            try {
                if (!$this->hasInput($request)) {
                    return response()->json([ "data" => "Request is empty" ], 400);
                }
                $dna->update($request->all());
                return (new CoraResource($dna))->additional(['message' => trans('messages.model_update_successful', ['model'=>'Dnas']), 200]);
            } catch (QueryException $ex) {
                $this->logQueryException(__METHOD__, $request, $ex);
                return response()->json([ 'message' => trans('messages.model_update_unsuccessful', ['model'=>'Dna']) ], 404);
            }
        } else {
            return response()->json([ "data" => "Not Authorized to edit resource" ], 403);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Request $request
     * @param Dna $dna
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function delete(Request $request, Dna $dna)
    {
        $this->logInfo(__METHOD__);
        if ($this->authorize('delete', [Dna::class, $dna])) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            try {
                $dna->delete();
                return response()->json([ 'data' => "Resource deleted successfully" ], 200);
            } catch (QueryException $ex) {
                $this->logQueryException(__METHOD__, $request, $ex);
                return response()->json([ 'data' => trans('messages.model_delete_unsuccessful', ['model'=>'Dnas']) ], 422);
            }
        } else {
            return response()->json([ "data" => "Not authorized to delete resource" ], 403);
        }
    }
}