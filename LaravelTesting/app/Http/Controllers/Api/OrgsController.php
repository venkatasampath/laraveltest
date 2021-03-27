<?php

/**
 * Cora Api OrgsController
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

use App\Dna;
use App\Http\Controllers\Controller;
use App\Http\Requests\OrgRequest;
use App\Http\Resources\ListResource;
use App\Profile;
use App\Project;
use App\Scopes\ProjectScope;
use App\SkeletalElement;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Org;
use App\Instrument;
use App\User;

use App\Http\Resources\CoraResource;
use App\Http\Resources\CoraResourceCollection;
use Illuminate\Support\Facades\DB;

/**
 * Class OrgsController
 * @package App\Http\Controllers\Api
 */
class OrgsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return CoraResourceCollection|JsonResponse
     * @throws AuthorizationException
     */
    public function index(Request $request)
    {
        $this->logInfo(__METHOD__);
        if ($this->authorize('browse', [ Org::class ]) && $this->theUser->isAdmin()) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            $list = Org::paginate($this::$pagination_length_large);

            return new CoraResourceCollection($list);
        } else {
            return response()->json([ "data" => "Not authorized to view all resources" ], 403);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param Request $request
     * @param Org|null $org
     * @return CoraResource|JsonResponse
     * @throws AuthorizationException
     */
    public function show(Request $request, Org $org = null)
    {
        $this->logInfo(__METHOD__);
        // If $org is null, it means that user has not passed the optional route segment
        // We need to check the request query parameters to see if additional org
        // search criteria have been passed.
        if (!isset($org)) {
            if ($request->query('id')) {
                $org = Org::where('id', $request->query('id'))->first();
            } else if ($request->query('acronym')) {
                $org = Org::where('acronym', $request->query('acronym'))->first();
            }

            if (!isset($org)) {
                return response()->json([ "data"=>"Org not found", "request"=>$request->all() ], 404);
            }
        }

        if ($this->authorize('read', [ Org::class, $org ])) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            return (new CoraResource($org))->additional(['request' => $request->all()]);
        } else {
            return response()->json([ "data" => "Not authorized to view resource" ], 403);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param OrgRequest $request
     * @return CoraResource|JsonResponse
     * @throws AuthorizationException
     */
    public function store(OrgRequest $request)
    {
        $this->logInfo(__METHOD__);
        if ($this->authorize('add', Org::class)) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            try {
                if (!$this->hasInput($request)) {
                    return response()->json([ "data" => "Request is empty" ], 400);
                }
                $request['created_by'] = $this->theUser->name;
                $request['updated_by'] = $this->theUser->name;
                $object = Org::create($request->all());
                return new CoraResource($object);
            } catch (QueryException $ex) {
                $this->logQueryException(__METHOD__, $request, $ex);
                return response()->json([ 'data' => trans('messages.model_add_unsuccessful', ['model'=>'Orgs']) ], 422);
            }
        } else {
            return response()->json([ "data" => "Not authorized to create resource" ], 403);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param OrgRequest $request
     * @param Org $org
     * @return CoraResource|JsonResponse
     * @throws AuthorizationException
     */
    public function update(OrgRequest $request, Org $org)
    {
        $this->logInfo(__METHOD__);
        if ($this->authorize('edit', [Org::class, $org])) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            try {
                if (!$this->hasInput($request)) {
                    return response()->json([ "data" => "Request is empty" ], 400);
                }
                $request['updated_by'] = $this->theUser->name;
                $org->update($request->all());
                return new CoraResource($org);
            } catch (QueryException $ex) {
                $this->logQueryException(__METHOD__, $request, $ex);
                return response()->json([ 'data' => trans('messages.model_update_unsuccessful', ['model'=>'Orgs']) ], 422);
            }
        } else {
            return response()->json([ "data" => "Not authorized to edit resource" ], 403);
        }
    }

    /**
     * Display a listing of the org profile resource.
     *
     * @param Request $request
     * @param Org|null $org
     * @return CoraResourceCollection|JsonResponse
     * @throws AuthorizationException
     */
    public function getProfiles(Request $request, Org $org)
    {
        $this->logInfo(__METHOD__);
        if ($this->authorize('read', [ Org::class, $org ])) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            try {
                $list = $org->profiles()->paginate($this::$pagination_length_large);
                return new CoraResourceCollection($list);
            } catch (QueryException $ex) {
                $this->logQueryException(__METHOD__, $request, $ex);
                return response()->json([ 'data'=> "Org not found" ], 404);
            }
        } else {
            return response()->json([ "data" => "Not authorized to view resource" ], 403);
        }
    }

    /**
     * Retrieve a specific user profile by name
     *
     * @param Request $request
     * @param Org|null $org
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function getProfile(Request $request, Org $org)
    {
        $this->logInfo(__METHOD__);
        if (!$request->has('name')) {
            return response()->json([ "data" => "Missing request query parameter", "request"=>$request->all() ], 404);
        } else {
            $profile_name = $request->query('name', null);
        }

        if ($this->authorize('read', [ Org::class, $org ])) {
           $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            try {
                $profile = $org->getProfile($profile_name);
                if (isset($profile)) {
                    $responseObject['name'] = $profile_name;
                    $responseObject['value'] = $org->getProfileValue($profile_name);
                    return response()->json([ 'data' => $responseObject ], 200);
                } else {
                    $responseObject['error'] = "profile not found ".$profile_name;
                    return response()->json([ 'data' => $responseObject ], 404);
                }
            } catch (QueryException $ex) {
                $this->logQueryException(__METHOD__, $request, $ex);
                return response()->json([ 'data'=> "Org profile not found" ], 404);
            }
        } else {
            return response()->json([ "data" => "Not authorized to view resource" ], 403);
        }
    }

    /**
     * Update a specific user profile by name
     *
     * @param Request $request
     * @param Org|null $org
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function updateProfile(Request $request, Org $org)
    {
        $this->logInfo(__METHOD__);
        if (!$request->has('name') || !$request->has('value')) {
            return response()->json([ "data" => "Missing request query parameter: name", "request"=>$request->all() ], 404);
        } else {
            $profile_name = $request->query('name', null);
            $profile_value = $request->query('value', null);
        }

        if ($this->authorize('read', [ Org::class, $org ])) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            try {
                $profile = $org->getProfile($profile_name);
                if (isset($profile)) {
                    $org->setProfile($profile_name, $profile_value);
                    $responseObject['name'] = $profile_name;
                    $responseObject['value'] = $org->getProfileValue($profile_name);
                    return response()->json([ 'data' => $responseObject ], 200);
                } else {
                    $profile = Profile::where(['name' => $profile_name])->first();
                    if (isset($profile)) {
                        $org->setProfile($profile_name, $profile_value);
                        $responseObject['name'] = $profile_name;
                        $responseObject['value'] = $org->getProfileValue($profile_name);
                        return response()->json([ 'data' => $responseObject ], 200);
                    } else {
                        $responseObject['error'] = "profile not found ".$profile_name;
                        return response()->json([ 'data' => $responseObject ], 404);
                    }
                }
            } catch (QueryException $ex) {
                $this->logQueryException(__METHOD__, $request, $ex);
                return response()->json([ 'data'=> "Org profile update unsuccessful" ], 404);
            }
        } else {
            return response()->json([ "data" => "Not authorized to view resource" ], 403);
        }
    }

    /**
     * Display a listing of all projects that belong to the specified org
     *
     * @param Request $request
     * @param Org $org
     * @return CoraResourceCollection|JsonResponse
     * @throws AuthorizationException
     */
    public function getProjects(Request $request, Org $org)
    {
        $this->logInfo(__METHOD__);
        if ($this->authorize('read', [ Org::class, $org ])) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            try {
                $list = $org->projects()->paginate($this::$pagination_length_large);
                return new CoraResourceCollection($list);
            } catch (QueryException $ex) {
                $this->logQueryException(__METHOD__, $request, $ex);
                return response()->json([ 'data' => trans('messages.model_index_view_unsuccessful', ['model'=>'Org Projects']) ], 422);
            }
        } else {
            return response()->json([ "data" => "Not authorized to view resource" ], 403);
        }
    }

    /**
     * Display a listing of all users that belong to the specified org
     *
     * @param Request $request
     * @param Org $org
     * @return CoraResourceCollection|JsonResponse
     * @throws AuthorizationException
     */
    public function getUsers(Request $request, Org $org)
    {
        $this->logInfo(__METHOD__);
        if ($this->authorize('read', [ Org::class, $org ])) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            try {
                if ($request->query('list')) {
                    $list = DB::table('users')->where('org_id', $org->id)
                        ->select('first_name', 'last_name', 'display_name', 'email', 'avatar', 'role_id', 'id')
                        ->where('active', "=", true)
                        ->orderBy('display_name')
                        ->get();
                    return response()->json([ "data" => $list ], 200);
                } else {
                    $list = $org->users()->paginate($this::$pagination_length_large);
                    return new CoraResourceCollection($list, null, true);
                }
            } catch (QueryException $ex) {
                $this->logQueryException(__METHOD__, $request, $ex);
                return response()->json([ 'data' => trans('messages.model_index_view_unsuccessful', ['model'=>'Org Users']) ], 422);
            }
        } else {
            return response()->json([ "data" => "Not authorized to view resource" ], 403);
        }
    }

    /**
     * Display a listing of all instruments that belong to the specified org
     *
     * @param Request $request
     * @param Org $org
     * @return CoraResourceCollection|JsonResponse|\Illuminate\Http\Resources\Json\AnonymousResourceCollection
     * @throws AuthorizationException
     */
    public function getInstruments(Request $request, Org $org)
    {
        $this->logInfo(__METHOD__);
        if ($this->authorize('read', [ Org::class, $org ])) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            try {
                if ($request->query('list')) {
                    $list = Instrument::where('org_id', "=", $org->id)->orderBy('code')->get();
                    return ListResource::collection($list)->additional(["status" => "success"]);
                } else {
                    $list = $org->instruments()->paginate($this::$pagination_length_large);
                    return new CoraResourceCollection($list, null, true);
                }
            } catch (QueryException $ex) {
                $this->logQueryException(__METHOD__, $request, $ex);
                return response()->json([ 'data' => trans('messages.model_index_view_unsuccessful', ['model'=>'Org Users']) ], 422);
            }
        } else {
            return response()->json([ "data" => "Not authorized to view resource" ], 403);
        }

    }
    /**
     * Display a listing of the dna mito sequence numbers belonging to the specified project.
     *
     * @param Request $request
     * @param Project|null $project
     * @return CoraResourceCollection|\Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function getDnaMitoSequenceNumbers(Request $request, Org $org = null)
    {
        $this->logInfo(__METHOD__);
        if ($this->authorize('browse', [ Dna::class ])) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            try {
                if ($request->query('list')) {
                    $list = DB::table('dnas')->where('org_id', $org->id)
                        ->select('mito_sequence_number')->groupBy(['mito_sequence_number'])
                        ->whereNotNull('mito_sequence_number')
                        ->orderBy('mito_sequence_number')
                        ->pluck('mito_sequence_number');
                    return response()->json([ "data" => $list, "meta" => ["count" => $list->count()] ], 200);
                } else {
                    $list = Dna::withoutGlobalScopes([OrgScope::class])->where('org_id', $org->id)
                        ->whereNotNull('mito_sequence_number')
                        ->orderBy('mito_sequence_number')
                        ->paginate($this::$pagination_length_large);
                    return new CoraResourceCollection($list);
                }
            } catch (QueryException $ex) {
                $this->logQueryException(__METHOD__, $request, $ex);
                return response()->json([ 'data' => trans('messages.model_index_view_unsuccessful', ['model'=>'Org Dna Mito Sequence Numbers']) ], 422);
            }
        } else {
            return response()->json([ "data" => "Not authorized to view all resources" ], 403);
        }
    }

    /**
     * Display a listing of the dna ystr sequence numbers belonging to the specified project.
     *
     * @param Request $request
     * @param Project|null $project
     * @return CoraResourceCollection|\Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function getDnaYstrSequenceNumbers(Request $request, Org $org = null)
    {
        $this->logInfo(__METHOD__);
        if ($this->authorize('browse', [ Dna::class ])) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            try {
                if ($request->query('list')) {
                    $list = DB::table('dnas')->where('org_id', $org->id)
                        ->select('ystr_sequence_number')->groupBy(['ystr_sequence_number'])
                        ->whereNotNull('ystr_sequence_number')
                        ->orderBy('ystr_sequence_number')
                        ->pluck('ystr_sequence_number');
                    return response()->json([ "data" => $list, "meta" => ["count" => $list->count()] ], 200);
                } else {
                    $list = Dna::withoutGlobalScopes([OrgScope::class])->where('org_id', $org->id)
                        ->whereNotNull('ystr_sequence_number')
                        ->orderBy('ystr_sequence_number')
                        ->paginate($this::$pagination_length_large);
                    return new CoraResourceCollection($list);
                }
            } catch (QueryException $ex) {
                $this->logQueryException(__METHOD__, $request, $ex);
                return response()->json([ 'data' => trans('messages.model_index_view_unsuccessful', ['model'=>'Org Dna Ystr Sequence Numbers']) ], 422);
            }
        } else {
            return response()->json([ "data" => "Not authorized to view all resources" ], 403);
        }
    }

    /**
     * Display a listing of the dna austr sequence numbers belonging to the specified project.
     *
     * @param Request $request
     * @param Project|null $project
     * @return CoraResourceCollection|\Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function getDnaAustrSequenceNumbers(Request $request, Org $org = null)
    {
        $this->logInfo(__METHOD__);
        if ($this->authorize('browse', [ Dna::class ])) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            try {
                if ($request->query('list')) {
                    $list = DB::table('dnas')->where('org_id', $org->id)
                        ->select('austr_sequence_number')->groupBy(['austr_sequence_number'])
                        ->whereNotNull('austr_sequence_number')
                        ->orderBy('austr_sequence_number')
                        ->pluck('austr_sequence_number');
                    return response()->json([ "data" => $list, "meta" => ["count" => $list->count()] ], 200);
                } else {
                    $list = Dna::withoutGlobalScopes([OrgScope::class])->where('org_id', $org->id)
                        ->whereNotNull('austr_sequence_number')
                        ->orderBy('austr_sequence_number')
                        ->paginate($this::$pagination_length_large);
                    return new CoraResourceCollection($list);
                }
            } catch (QueryException $ex) {
                $this->logQueryException(__METHOD__, $request, $ex);
                return response()->json([ 'data' => trans('messages.model_index_view_unsuccessful', ['model'=>'Org Dna Austr Sequence Numbers']) ], 422);
            }
        } else {
            return response()->json([ "data" => "Not authorized to view all resources" ], 403);
        }
    }

    /**
     * Display a listing of the dna mito sequence subgroup belonging to the specified project.
     *
     * @param Request $request
     * @param Project|null $project
     * @return CoraResourceCollection|\Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function getDnaMitoSequenceSubgroups(Request $request, Org $org = null)
    {
        $this->logInfo(__METHOD__);
        if ($this->authorize('browse', [ Dna::class ])) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            try {
                if ($request->query('list')) {
                    $list = DB::table('dnas')->where('org_id', $org->id)
                        ->select('mito_sequence_subgroup')->groupBy(['mito_sequence_subgroup'])
                        ->whereNotNull('mito_sequence_subgroup')
                        ->orderBy('mito_sequence_subgroup')
                        ->pluck('mito_sequence_subgroup');
                    return response()->json([ "data" => $list, "meta" => ["count" => $list->count()] ], 200);
                } else {
                    $list = Dna::withoutGlobalScopes([OrgScope::class])->where('org_id', $org->id)
                        ->whereNotNull('mito_sequence_subgroup')
                        ->orderBy('mito_sequence_subgroup')
                        ->paginate($this::$pagination_length_large);
                    return new CoraResourceCollection($list);
                }
            } catch (QueryException $ex) {
                $this->logQueryException(__METHOD__, $request, $ex);
                return response()->json([ 'data' => trans('messages.model_index_view_unsuccessful', ['model'=>'Org Dna Mito Sequence Subgroups']) ], 422);
            }
        } else {
            return response()->json([ "data" => "Not authorized to view all resources" ], 403);
        }
    }

    /**
     * Display a listing of the dna ystr sequence subgroup belonging to the specified project.
     *
     * @param Request $request
     * @param Project|null $project
     * @return CoraResourceCollection|\Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function getDnaYstrSequenceSubgroups(Request $request, Org $org = null)
    {
        $this->logInfo(__METHOD__);
        if ($this->authorize('browse', [ Dna::class ])) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            try {
                if ($request->query('list')) {
                    $list = DB::table('dnas')->where('org_id', $org->id)
                        ->select('ystr_sequence_subgroup')->groupBy(['ystr_sequence_subgroup'])
                        ->whereNotNull('ystr_sequence_subgroup')
                        ->orderBy('ystr_sequence_subgroup')
                        ->pluck('ystr_sequence_subgroup');
                    return response()->json([ "data" => $list, "meta" => ["count" => $list->count()] ], 200);
                } else {
                    $list = Dna::withoutGlobalScopes([OrgScope::class])->where('org_id', $org->id)
                        ->whereNotNull('ystr_sequence_subgroup')
                        ->orderBy('ystr_sequence_subgroup')
                        ->paginate($this::$pagination_length_large);
                    return new CoraResourceCollection($list);
                }
            } catch (QueryException $ex) {
                $this->logQueryException(__METHOD__, $request, $ex);
                return response()->json([ 'data' => trans('messages.model_index_view_unsuccessful', ['model'=>'Org Dna Ystr Sequence Subgroups']) ], 422);
            }
        } else {
            return response()->json([ "data" => "Not authorized to view all resources" ], 403);
        }
    }

    /**
     * Display a listing of the dna austr sequence subgroup belonging to the specified project.
     *
     * @param Request $request
     * @param Project|null $project
     * @return CoraResourceCollection|\Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function getDnaAustrSequenceSubgroups(Request $request, Org $org = null)
    {
        $this->logInfo(__METHOD__);
        if ($this->authorize('browse', [ Dna::class ])) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            try {
                if ($request->query('list')) {
                    $list = DB::table('dnas')->where('org_id', $org->id)
                        ->select('austr_sequence_subgroup')->groupBy(['austr_sequence_subgroup'])
                        ->whereNotNull('austr_sequence_subgroup')
                        ->orderBy('austr_sequence_subgroup')
                        ->pluck('austr_sequence_subgroup');
                    return response()->json([ "data" => $list, "meta" => ["count" => $list->count()] ], 200);
                } else {
                    $list = Dna::withoutGlobalScopes([OrgScope::class])->where('org_id', $org->id)
                        ->whereNotNull('austr_sequence_subgroup')
                        ->orderBy('austr_sequence_subgroup')
                        ->paginate($this::$pagination_length_large);
                    return new CoraResourceCollection($list);
                }
            } catch (QueryException $ex) {
                $this->logQueryException(__METHOD__, $request, $ex);
                return response()->json([ 'data' => trans('messages.model_index_view_unsuccessful', ['model'=>'Org Dna Austr Sequence Subgroups']) ], 422);
            }
        } else {
            return response()->json([ "data" => "Not authorized to view all resources" ], 403);
        }
    }
    /**
     * Display a listing of the individual numbers belonging to the specified project.
     *
     * @param Request $request
     * @param Project $project
     * @return CoraResourceCollection|\Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function getIndividualNumbers(Request $request, Org $org = null)
    {
        $this->logInfo(__METHOD__);
        if ($this->authorize('browse', [ SkeletalElement::class ])) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            try {
                if ($request->query('list')) {
                    $list = DB::table('skeletal_elements')->where('org_id', $org->id)
                        ->select('individual_number')->groupBy(['individual_number'])
                        ->whereNotNull('individual_number')
                        ->orderBy('individual_number')
                        ->pluck('individual_number');
                    return response()->json([ "data" => $list, "meta" => ["count" => $list->count()] ], 200);
                } else {
                    $list = SkeletalElement::withoutGlobalScopes([ProjectScope::class])
                        ->where('org_id', $org->id)
                        ->whereNotNull('individual_number')
                        ->orderBy('individual_number')
                        ->paginate($this::$pagination_length_large);
                    return new CoraResourceCollection($list);
                }
            } catch (QueryException $ex) {
                $this->logQueryException(__METHOD__, $request, $ex);
                return response()->json([ 'data' => trans('messages.model_index_view_unsuccessful', ['model'=>'Org Individual Numbers']) ], 422);
            }
        } else {
            return response()->json([ "data" => "Not authorized to view all resources" ], 403);
        }
    }
}