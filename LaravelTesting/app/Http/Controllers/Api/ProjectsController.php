<?php

/**
 * Cora Api ProjectsController
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

use App\Http\Resources\ListResource;
use App\Http\Resources\SpecimenListResource;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Scopes\ProjectScope;
use App\SkeletalBone;
use App\SkeletalElement;
use App\Dna;
use App\Haplogroup;
use App\Project;
use App\Accession;
use App\Tag;

use App\Http\Resources\CoraResource;
use App\Http\Resources\CoraResourceCollection;

/**
 * Class ProjectsController
 * @package App\Http\Controllers\Api
 */
class ProjectsController extends Controller
{
    /**
     * @var array
     */
    public static $allowed_association_types = ["users", "instruments"];

    /**
     * @var array
     */
    protected $allowedSearch = ['SB'=>'Bone', 'AN'=>'Accession Number', 'P1'=>'Provenance1', 'P2'=>'Provenance2', 'DN'=>'Designator',
        'CK'=>'Composite Key', 'IN'=>'Individual Number', 'EN'=>'External Number', 'TAGS'=>"Tags", 'DC'=>'Dental Codes'];
    /**
     * @var string
     */
    protected $search_results_by_string = "";
    /**
     * @var null
     */
    protected $specimens = null;
    /**
     * @var null
     */
    protected $dnas = null;
    /**
     * @var null
     */
    protected $isotopes = null;
    /**
     * @var null
     */
    protected $tags = null;
    /**
     * @var
     */
    protected $today;
    /**
     * @var array
     */
    protected $criteriaData = [];
    /**
     * @var string
     */
    protected $criteriaSelections = "";

    /**
     * Display a listing of the resource.
     *
     * @return CoraResourceCollection|\Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index()
    {
        $this->logInfo(__METHOD__);
        if ($this->authorize('browse', [ Project::class ])) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            if ($this->theUser->isAdmin()) {
                $list = Project::with(['manager', 'status', 'users'])->paginate($this::$pagination_length_large);
            } else if ($this->theUser->isOrgAdmin()) {
                $list = Project::where('org_id', $this->theOrg->id)->with(['manager', 'status', 'users'])->paginate($this::$pagination_length_large);
            } else {
                $list = $this->theUser->projects()->with(['manager', 'status', 'users'])->paginate($this::$pagination_length_large);
            }
            return new CoraResourceCollection($list);
        } else {
            return response()->json([ "data" => "Not Authorized to view all projects" ], 403);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return CoraResource|\Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(Request $request)
    {
        $this->logInfo(__METHOD__);
        if ($this->authorize('add', Project::class)) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            try {
                if (!$this->hasInput($request)) {
                    return response()->json([ "data" => "Request is empty" ], 400);
                }
                $request['org_id'] = $this->theOrg->id; // Set the org id.
                $object = Project::create($request->all());
                return new CoraResource($object);
            } catch (QueryException $ex) {
                $this->logQueryException(__METHOD__, $request, $ex);
                return response()->json([ 'data' => trans('messages.model_add_unsuccessful', ['model'=>'Projects']) ], 422);
            }
        } else {
            return response()->json([ "data" => "Not authorized to create resource" ], 403);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param Request $request
     * @param Project|null $project
     * @return CoraResource|\Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function show(Request $request, Project $project = null)
    {
        $this->logInfo(__METHOD__);
        // If $project is null, it means that user has not passed the optional route segment
        // We need to check the request query parameters to see if additional project
        // search criteria have been passed.
        if (!isset($project)) {
            if ($request->query('id')) {
                $project = Project::where('id', $request->query('id'))->first();
            } else if ($request->query('name')) {
                $project = Project::where('name', $request->query('name'))->first();
            }

            if (!isset($project)) {
                return response()->json([ "data"=>"Project not found", "request"=>$request->all() ], 404);
            }
        }

        if ($this->authorize('read', [ Project::class, $project ])) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            return new CoraResource($project);
        } else {
            return response()->json([ "data" => "Not authorized to view resource" ], 403);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Project $project
     * @return CoraResource|\Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(Request $request, Project $project)
    {
        $this->logInfo(__METHOD__);
        if ($this->authorize('edit', [Project::class, $project])) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            try {
                if (!$this->hasInput($request)) {
                    return response()->json([ "data" => "Request is empty" ], 400);
                }
                $project->update($request->all());
                return new CoraResource($project);
            } catch (QueryException $ex) {
                $this->logQueryException(__METHOD__, $request, $ex);
                return response()->json([ 'data' => trans('messages.model_update_unsuccessful', ['model'=>'Projects']) ], 422);
            }
        } else {
            return response()->json([ "data" => "Not authorized to edit resource" ], 403);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Request $request
     * @param Project $project
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function delete(Request $request, Project $project)
    {
        $this->logInfo(__METHOD__);
        if ($this->authorize('delete', [Project::class, $project])) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            try {
                $project->delete();
                return response()->json([ 'data' => "Resource deleted successfully" ], 200);
            } catch (QueryException $ex) {
                $this->logQueryException(__METHOD__, $request, $ex);
                return response()->json([ 'data' => trans('messages.model_delete_unsuccessful', ['model'=>'Projects']) ], 422);
            }
        } else {
            return response()->json([ "data" => "Not authorized to delete resource" ], 403);
        }
    }

    /**
     * Display a listing of the project accessions resource.
     *
     * @param Request $request
     * @param Project $project
     * @return CoraResourceCollection|\Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function getAccessions(Request $request, Project $project)
    {
        $this->logInfo(__METHOD__);
        if ($this->authorize('browse', [ SkeletalElement::class ])) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            try {
                if ($request->query('list')) {
                    $list = DB::table('accessions')->where('project_id', $project->id)
                        ->select('number')->groupBy(['number'])
                        ->whereNotNull('number')
                        ->orderBy('number')
                        ->pluck('number');
                    return response()->json([ "data" => $list ], 200);
                } else {
                    $list = Accession::withoutGlobalScopes([ProjectScope::class])
                        ->where('project_id', $project->id)
                        ->orderBy('number')
                        ->paginate($this::$pagination_length_large);
                    return new CoraResourceCollection($list);
                }
            } catch (QueryException $ex) {
                $this->logQueryException(__METHOD__, $request, $ex);
                return response()->json([ 'data' => trans('messages.model_index_view_unsuccessful', ['model'=>'Project Accessions']) ], 422);
            }
        } else {
            return response()->json([ "data" => "Not authorized to view all resources" ], 403);
        }
    }

    /**
     * Display a listing of the project provenance1 resource.
     *
     * @param Request $request
     * @param Project $project
     * @return CoraResourceCollection|\Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function getProvenance1(Request $request, Project $project)
    {
        $this->logInfo(__METHOD__);
        if ($this->authorize('browse', [ SkeletalElement::class ])) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            try {
                if ($request->query('list')) {
                    $list = DB::table('accessions')->where('project_id', $project->id)
                        ->select('provenance1')->groupBy(['provenance1'])
                        ->whereNotNull('provenance1')
                        ->orderBy('provenance1')
                        ->pluck('provenance1');
                    return response()->json([ "data" => $list ], 200);
                } else {
                    $list = Accession::withoutGlobalScopes([ProjectScope::class])
                        ->where('project_id', $project->id)
                        ->orderBy('provenance1')
                        ->paginate($this::$pagination_length_large);
                    return new CoraResourceCollection($list);
                }
            } catch (QueryException $ex) {
                $this->logQueryException(__METHOD__, $request, $ex);
                return response()->json([ 'data' => trans('messages.model_index_view_unsuccessful', ['model'=>'Project Provenance1']) ], 422);
            }
        } else {
            return response()->json([ "data" => "Not authorized to view all resources" ], 403);
        }
    }

    /**
     * Display a listing of the project provenance2 resource.
     *
     * @param Request $request
     * @param Project $project
     * @return CoraResourceCollection|\Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function getProvenance2(Request $request, Project $project)
    {
        $this->logInfo(__METHOD__);
        if ($this->authorize('browse', [ SkeletalElement::class ])) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            try {
                if ($request->query('list')) {
                    $list = DB::table('accessions')->where('project_id', $project->id)
                        ->select('provenance2')->groupBy(['provenance2'])
                        ->whereNotNull('provenance2')
                        ->orderBy('provenance2')
                        ->pluck('provenance2');
                    return response()->json([ "data" => $list ], 200);
                } else {
                    $list = Accession::withoutGlobalScopes([ProjectScope::class])
                        ->where('project_id', $project->id)
                        ->orderBy('provenance2')
                        ->paginate($this::$pagination_length_large);
                    return new CoraResourceCollection($list);
                }
            } catch (QueryException $ex) {
                $this->logQueryException(__METHOD__, $request, $ex);
                return response()->json([ 'data' => trans('messages.model_index_view_unsuccessful', ['model'=>'Project Provenance2']) ], 422);
            }
        } else {
            return response()->json([ "data" => "Not authorized to view all resources" ], 403);
        }
    }

    /**
     * Display a listing of the project anp1p2 resource.
     *
     * @param Request $request
     * @param Project $project
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function getAnP1P2(Request $request, Project $project)
    {
        $this->logInfo(__METHOD__);
        if ($this->authorize('browse', [ SkeletalElement::class ])) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            try {
                $list = DB::table('accessions')->where('project_id', $project->id)
                    ->select('number', 'provenance1', 'provenance2')->groupBy(['number', 'provenance1', 'provenance2'])
                    ->whereNotNull('number')
                    ->orderBy('number')
                    ->get();
                return response()->json([ "data" => $list ], 200);
            } catch (QueryException $ex) {
                $this->logQueryException(__METHOD__, $request, $ex);
                return response()->json([ 'data' => trans('messages.model_index_view_unsuccessful', ['model'=>'Project AnP1P2']) ], 422);
            }
        } else {
            return response()->json([ "data" => "Not authorized to view all resources" ], 403);
        }
    }

    /**
     * Display a listing of the users assigned to the specified project.
     *
     * @param Request $request
     * @param Project $project
     * @return CoraResourceCollection|\Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function getUsers(Request $request, Project $project)
    {
        $this->logInfo(__METHOD__);
        if ($this->authorize('read', [ Project::class, $project ])) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            try {
                $list = $project->users()->paginate($this::$pagination_length_large);
                return new CoraResourceCollection($list);
            } catch (QueryException $ex) {
                $this->logQueryException(__METHOD__, $request, $ex);
                return response()->json([ 'data' => trans('messages.model_index_view_unsuccessful', ['model'=>'Project Users']) ], 422);
            }
        } else {
            return response()->json([ "data" => "Not authorized to view all resources" ], 403);
        }
    }

    /**
     * Display a listing of the users assigned to the specified project.
     *
     * @param Request $request
     * @param Project $project
     * @return CoraResourceCollection|\Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function getInstruments(Request $request, Project $project)
    {
        $this->logInfo(__METHOD__);
        if ($this->authorize('read', [ Project::class, $project ])) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            try {
                $list = $project->instruments();
                return new CoraResourceCollection($list);
            } catch (QueryException $ex) {
                $this->logQueryException(__METHOD__, $request, $ex);
                return response()->json([ 'data' => trans('messages.model_index_view_unsuccessful', ['model'=>'Project Users']) ], 422);
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
    public function getIndividualNumbers(Request $request, Project $project)
    {
        $this->logInfo(__METHOD__);
        if ($this->authorize('browse', [ SkeletalElement::class ])) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            try {
                if ($request->query('list')) {
                    $list = DB::table('skeletal_elements')->where('project_id', $project->id)
                        ->select('individual_number')->groupBy(['individual_number'])
                        ->whereNotNull('individual_number')
                        ->orderBy('individual_number')
                        ->pluck('individual_number');
                    return response()->json([ "data" => $list, "meta" => ["count" => $list->count()] ], 200);
                } else {
                    $list = SkeletalElement::withoutGlobalScopes([ProjectScope::class])
                        ->where('project_id', $project->id)
                        ->whereNotNull('individual_number')
                        ->orderBy('individual_number')
                        ->paginate($this::$pagination_length_large);
                    return new CoraResourceCollection($list);
                }
            } catch (QueryException $ex) {
                $this->logQueryException(__METHOD__, $request, $ex);
                return response()->json([ 'data' => trans('messages.model_index_view_unsuccessful', ['model'=>'Project Individual Numbers']) ], 422);
            }
        } else {
            return response()->json([ "data" => "Not authorized to view all resources" ], 403);
        }
    }

    /**
     * Display a listing of the tags belonging to the specified project.
     *
     * @param Request $request
     * @param Project $project
     * @return CoraResourceCollection|\Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function getTags(Request $request, Project $project)
    {
        $this->logInfo(__METHOD__);
        if ($this->authorize('browse', [ SkeletalElement::class ])) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            try {
                $list = Tag::where(function ($query) use ($project) {
                    $query->where("org_id", "=", $this->theOrg->id)->where("project_id", "=", $project->id);
                })->orWhere(function ($query) {
                    $query->where("org_id", "=", $this->theOrg->id)->whereNull("project_id");
                })->orWhere(function ($query) {
                    $query->whereNull("org_id")->whereNull("project_id");
                })->get();
                return new CoraResourceCollection($list);
            } catch (QueryException $ex) {
                $this->logQueryException(__METHOD__, $request, $ex);
                return response()->json([ 'data' => trans('messages.model_index_view_unsuccessful', ['model'=>'Project Individual Numbers']) ], 422);
            }
        } else {
            return response()->json([ "data" => "Not authorized to view all resources" ], 403);
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
    public function getSpecimens(Request $request, Project $project)
    {
        $this->logInfo(__METHOD__);
        if ($this->authorize('browse', [ SkeletalElement::class ])) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            try {
                if ($request->query('list')) {
                    if ($request->has('an') || $request->has('p1')  || $request->has('p2')) {
                        $an = $request->query('an') ? $request->query('an') : null;
                        $p1 = $request->query('p1') ? $request->query('p1') : null;
                        $p2 = $request->query('p2') ? $request->query('p2') : null;
                        $this->logInfo(__METHOD__,"An:".$an." P1:".$p1." P2:".$p2);
                        $query = SkeletalElement::withoutGlobalScopes([ProjectScope::class])->where('project_id', $project->id);
                        $query = isset($an) ? $query->where('accession_number', $an) : $query;
                        $query = isset($p1) ? $query->where('provenance1', $p1) : $query;
                        $query = isset($p2) ? $query->where('provenance2', $p2) : $query;
                        $list = $query->get();
                        $this->logInfo(__METHOD__,"Specimen list coount:".$list->count());
                        if ($list->count() > 3000) {
                            return response()->json([ "data" => "Data set too large: ".count($list)], 404);
                        }
                        return SpecimenListResource::collection($list);
//                        return new CoraResourceCollection($list);
                    } else {
                        return response()->json([ "data" => "Invalid or missing search parameters an, p1, p2"], 404);
                    }
                } else {
                    $list = SkeletalElement::withoutGlobalScopes([ProjectScope::class])
                        ->where('project_id', $project->id)
                        ->paginate($this::$pagination_length_large);
                    return new CoraResourceCollection($list);
                }
            } catch (QueryException $ex) {
                $this->logQueryException(__METHOD__, $request, $ex);
                return response()->json([ 'data' => trans('messages.model_index_view_unsuccessful', ['model'=>'Project Specimens']) ], 422);
            }
        } else {
            return response()->json([ "data" => "Not authorized to view all resources" ], 403);
        }
    }

    /**
     * Display a listing of the specimens belonging to the specified project
     * for the given search criteria which include searchby such as Bone,
     * Accession, Provenance1, Designator etc and the search string.
     *
     * For a full listing of search by criteria, see $allowedSearch
     *
     * @param Request $request
     * @param Project $project
     * @return CoraResourceCollection|\Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function searchSpecimens(Request $request, Project $project)
    {
        $this->logInfo(__METHOD__);
        if ($request->has('searchby') && $request->has('searchstring')) {
            $searchBy = $request->query('searchby');
            $searchString = $request->query('searchstring');
            $this->logInfo(__METHOD__,"SearchBy:".$searchBy." SearchString:".$searchString);
        } else {
            return response()->json([ "data" => "Invalid or missing search parameters"], 404);
        }

        if (!isset($searchBy) || !isset($searchString)) {
            return response()->json([ "data" => "Invalid or missing search parameters"], 404);
        }

        if ($this->authorize('browse', [ SkeletalElement::class ])) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            try {
                if (Project::where('id', $project->id)->exists()) {
                    $specimens = null;
                    $query = SkeletalElement::withoutGlobalScopes([ProjectScope::class])->where('project_id', $project->id)
                        ->with(['skeletalbone','dnas','tags'])->withCount(['pairs', 'articulations', 'refits', 'morphologys', 'methods', 'pathologys', 'traumas','anomalys']);

                    if($this->buildSpecimenCriteriaData($request, $query)){
                        $specimens = $query->paginate($this->per_page);
                        $this->logInfo(__METHOD__,"Specimen Search count:". (isset($specimens) ? $specimens->count() : 0));
                        return new CoraResourceCollection($specimens);
                    } else{
                        return response()->json([ "data" => "Invalid or missing search parameters"], 404);

                    }

                } else {
                    return response()->json([ "data" => "Project not found" ], 404);
                }
            } catch (QueryException $ex) {
                $this->logQueryException(__METHOD__, $request, $ex);
                return response()->json([ 'data' => trans('messages.model_index_view_unsuccessful', ['model'=>'Project Specimen Search']) ], 422);
            }
        } else {
            return response()->json([ "data" => "Not Authorized to view Project" ], 403);
        }
    }

    /**
     * @param $request
     * @param $query
     * @return bool
     */
    private function buildSpecimenCriteriaData($request, &$query)
    {
        $this->logInfo(__METHOD__);
        $searchBy = $request->query('searchby');
        $searchString = $request->query('searchstring');
        $this->currentSearchByName = $this->allowedSearch[$searchBy];

        $executequery = true;
        if ($searchBy == 'AN') {
            $query->where('accession_number', $searchString);
        } else if ($searchBy == 'P1') {
            $query->where('provenance1', $searchString);
        } else if ($searchBy == 'P2') {
            $query->where('provenance2', $searchString);
        } else if ($searchBy == 'DN') {
            $query->where('designator', $searchString);
        } else if ($searchBy == 'EN') {
            $query->where('external_id', $searchString);
        } else if ($searchBy == 'IN') {
            $query->where('individual_number', $searchString);
        } else if ($searchBy == 'SB') {
            $bones = SkeletalBone::where('search_name', strtolower($searchString))->get();
            if ($bones->isEmpty()) {
                $executequery = false;
            } else {
                $query->where('sb_id', $bones->first()->id);
            }
        } else if ($searchBy == 'CK') {
            $values = array_map('trim', explode(SkeletalElement::$key_delimiter, $searchString));
            if (strpos($searchString, ',') !== false) {
                $values = array_map('trim', explode(',', $searchString));
            }
            $accession = (isset($values[0]) && !empty($values[0])) ? $values[0] : null;
            $prov1 = (isset($values[1]) && !empty($values[1])) ? $values[1] : null;
            $prov2 = (isset($values[2]) && !empty($values[2])) ? $values[2] : null;
            $designator = (isset($values[3]) && !empty($values[3])) ? $values[3] : null;

            if(isset($accession)) { $query = $query->where('accession_number', $accession); }
            if(isset($prov1)) { $query = $query->where('provenance1', $prov1); }
            if(isset($prov2)) { $query = $query->where('provenance2', $prov2); }
            if(isset($designator)) { $query = $query->where('designator', $designator);}
        } else if ($searchBy == 'TAGS') { // Tags
            $query->whereHas('tags', function (Builder $query) use($searchString) {
                $in = explode(",", $searchString);
                $query->whereIn('id', $in);
            });
            $this->search_results_by_string = trans('messages.search_results_by_string', ['model' => 'Specimen', 'searchby' => 'Tags', 'searchstring' => $searchString]);
        } else if ($searchBy == 'DC') {
            $dentalSpecimens = null;
            if (DB::table('se_dental_code')->where('dc_id', $searchString)->exists()) {
                $dentalSpecimens = DB::table('se_dental_code')->where('dc_id', $searchString)->pluck('se_id');
            }
            $query->find($dentalSpecimens, 'id');
        }
        else {
            $executequery = false;
        }

        return $executequery;
    }

    /**
     * Display a listing of the dnas belonging to the specified project.
     *
     * @param Request $request
     * @param Project $project
     * @return CoraResourceCollection|\Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function getDnas(Request $request, Project $project)
    {
        $this->logInfo(__METHOD__);
        if ($this->authorize('browse', [ Dna::class ])) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            try {
                $list = Dna::withoutGlobalScopes([ProjectScope::class])->where('project_id', $project->id)
                    ->paginate($this::$pagination_length_large);
                return new CoraResourceCollection($list);
            } catch (QueryException $ex) {
                $this->logQueryException(__METHOD__, $request, $ex);
                return response()->json([ 'data' => trans('messages.model_index_view_unsuccessful', ['model'=>'Project Dnas']) ], 422);
            }
        } else {
            return response()->json([ "data" => "Not authorized to view all resources" ], 403);
        }
    }

    /**
     * Display a listing of the dna sample numbers belonging to the specified project.
     *
     * @param Request $request
     * @param Project $project
     * @return CoraResourceCollection|\Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function getDnaSampleNumbers(Request $request, Project $project)
    {
        $this->logInfo(__METHOD__);
        if ($this->authorize('browse', [ Dna::class ])) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            try {
                if ($request->query('list')) {
                    $list = DB::table('dnas')->where('project_id', $project->id)
                        ->select('sample_number')->groupBy(['sample_number'])
                        ->whereNotNull('sample_number')
                        ->orderBy('sample_number')
                        ->pluck('sample_number');
                    return response()->json([ "data" => $list, "meta" => ["count" => $list->count()] ], 200);
                } else {
                    $list = Dna::withoutGlobalScopes([ProjectScope::class])->where('project_id', $project->id)
                        ->whereNotNull('sample_number')
                        ->orderBy('sample_number')
                        ->paginate($this::$pagination_length_large);
                    return new CoraResourceCollection($list);
                }
            } catch (QueryException $ex) {
                $this->logQueryException(__METHOD__, $request, $ex);
                return response()->json([ 'data' => trans('messages.model_index_view_unsuccessful', ['model'=>'Project Dna Sample Numbers']) ], 422);
            }
        } else {
            return response()->json([ "data" => "Not authorized to view all resources" ], 403);
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
    public function getDnaMitoSequenceNumbers(Request $request, Project $project = null)
    {
        $this->logInfo(__METHOD__);
        if ($this->authorize('browse', [ Dna::class ])) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            try {
                if ($request->query('list')) {
                    $list = DB::table('dnas')->where('project_id', $project->id)
                        ->select('mito_sequence_number')->groupBy(['mito_sequence_number'])
                        ->whereNotNull('mito_sequence_number')
                        ->orderBy('mito_sequence_number')
                        ->pluck('mito_sequence_number');
                    return response()->json([ "data" => $list, "meta" => ["count" => $list->count()] ], 200);
                } else {
                    $list = Dna::withoutGlobalScopes([ProjectScope::class])->where('project_id', $project->id)
                        ->whereNotNull('mito_sequence_number')
                        ->orderBy('mito_sequence_number')
                        ->paginate($this::$pagination_length_large);
                    return new CoraResourceCollection($list);
                }
            } catch (QueryException $ex) {
                $this->logQueryException(__METHOD__, $request, $ex);
                return response()->json([ 'data' => trans('messages.model_index_view_unsuccessful', ['model'=>'Project Dna Mito Sequence Numbers']) ], 422);
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
    public function getDnaYstrSequenceNumbers(Request $request, Project $project = null)
    {
        $this->logInfo(__METHOD__);
        if ($this->authorize('browse', [ Dna::class ])) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            try {
                if ($request->query('list')) {
                    $list = DB::table('dnas')->where('project_id', $project->id)
                        ->select('ystr_sequence_number')->groupBy(['ystr_sequence_number'])
                        ->whereNotNull('ystr_sequence_number')
                        ->orderBy('ystr_sequence_number')
                        ->pluck('ystr_sequence_number');
                    return response()->json([ "data" => $list, "meta" => ["count" => $list->count()] ], 200);
                } else {
                    $list = Dna::withoutGlobalScopes([ProjectScope::class])->where('project_id', $project->id)
                        ->whereNotNull('ystr_sequence_number')
                        ->orderBy('ystr_sequence_number')
                        ->paginate($this::$pagination_length_large);
                    return new CoraResourceCollection($list);
                }
            } catch (QueryException $ex) {
                $this->logQueryException(__METHOD__, $request, $ex);
                return response()->json([ 'data' => trans('messages.model_index_view_unsuccessful', ['model'=>'Project Dna Ystr Sequence Numbers']) ], 422);
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
    public function getDnaAustrSequenceNumbers(Request $request, Project $project = null)
    {
        $this->logInfo(__METHOD__);
        if ($this->authorize('browse', [ Dna::class ])) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            try {
                if ($request->query('list')) {
                    $list = DB::table('dnas')->where('project_id', $project->id)
                        ->select('austr_sequence_number')->groupBy(['austr_sequence_number'])
                        ->whereNotNull('austr_sequence_number')
                        ->orderBy('austr_sequence_number')
                        ->pluck('austr_sequence_number');
                    return response()->json([ "data" => $list, "meta" => ["count" => $list->count()] ], 200);
                } else {
                    $list = Dna::withoutGlobalScopes([ProjectScope::class])->where('project_id', $project->id)
                        ->whereNotNull('austr_sequence_number')
                        ->orderBy('austr_sequence_number')
                        ->paginate($this::$pagination_length_large);
                    return new CoraResourceCollection($list);
                }
            } catch (QueryException $ex) {
                $this->logQueryException(__METHOD__, $request, $ex);
                return response()->json([ 'data' => trans('messages.model_index_view_unsuccessful', ['model'=>'Project Dna Austr Sequence Numbers']) ], 422);
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
    public function getDnaMitoSequenceSubgroups(Request $request, Project $project = null)
    {
        $this->logInfo(__METHOD__);
        if ($this->authorize('browse', [ Dna::class ])) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            try {
                if ($request->query('list')) {
                    $list = DB::table('dnas')->where('project_id', $project->id)
                        ->select('mito_sequence_subgroup')->groupBy(['mito_sequence_subgroup'])
                        ->whereNotNull('mito_sequence_subgroup')
                        ->orderBy('mito_sequence_subgroup')
                        ->pluck('mito_sequence_subgroup');
                    return response()->json([ "data" => $list, "meta" => ["count" => $list->count()] ], 200);
                } else {
                    $list = Dna::withoutGlobalScopes([ProjectScope::class])->where('project_id', $project->id)
                        ->whereNotNull('mito_sequence_subgroup')
                        ->orderBy('mito_sequence_subgroup')
                        ->paginate($this::$pagination_length_large);
                    return new CoraResourceCollection($list);
                }
            } catch (QueryException $ex) {
                $this->logQueryException(__METHOD__, $request, $ex);
                return response()->json([ 'data' => trans('messages.model_index_view_unsuccessful', ['model'=>'Project Dna Mito Sequence Subgroups']) ], 422);
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
    public function getDnaYstrSequenceSubgroups(Request $request, Project $project = null)
    {
        $this->logInfo(__METHOD__);
        if ($this->authorize('browse', [ Dna::class ])) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            try {
                if ($request->query('list')) {
                    $list = DB::table('dnas')->where('project_id', $project->id)
                        ->select('ystr_sequence_subgroup')->groupBy(['ystr_sequence_subgroup'])
                        ->whereNotNull('ystr_sequence_subgroup')
                        ->orderBy('ystr_sequence_subgroup')
                        ->pluck('ystr_sequence_subgroup');
                    return response()->json([ "data" => $list, "meta" => ["count" => $list->count()] ], 200);
                } else {
                    $list = Dna::withoutGlobalScopes([ProjectScope::class])->where('project_id', $project->id)
                        ->whereNotNull('ystr_sequence_subgroup')
                        ->orderBy('ystr_sequence_subgroup')
                        ->paginate($this::$pagination_length_large);
                    return new CoraResourceCollection($list);
                }
            } catch (QueryException $ex) {
                $this->logQueryException(__METHOD__, $request, $ex);
                return response()->json([ 'data' => trans('messages.model_index_view_unsuccessful', ['model'=>'Project Dna Ystr Sequence Subgroups']) ], 422);
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
    public function getDnaAustrSequenceSubgroups(Request $request, Project $project = null)
    {
        $this->logInfo(__METHOD__);
        if ($this->authorize('browse', [ Dna::class ])) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            try {
                if ($request->query('list')) {
                    $list = DB::table('dnas')->where('project_id', $project->id)
                        ->select('austr_sequence_subgroup')->groupBy(['austr_sequence_subgroup'])
                        ->whereNotNull('austr_sequence_subgroup')
                        ->orderBy('austr_sequence_subgroup')
                        ->pluck('austr_sequence_subgroup');
                    return response()->json([ "data" => $list, "meta" => ["count" => $list->count()] ], 200);
                } else {
                    $list = Dna::withoutGlobalScopes([ProjectScope::class])->where('project_id', $project->id)
                        ->whereNotNull('austr_sequence_subgroup')
                        ->orderBy('austr_sequence_subgroup')
                        ->paginate($this::$pagination_length_large);
                    return new CoraResourceCollection($list);
                }
            } catch (QueryException $ex) {
                $this->logQueryException(__METHOD__, $request, $ex);
                return response()->json([ 'data' => trans('messages.model_index_view_unsuccessful', ['model'=>'Project Dna Austr Sequence Subgroups']) ], 422);
            }
        } else {
            return response()->json([ "data" => "Not authorized to view all resources" ], 403);
        }
    }

    /**
     * Display a listing of the dnas belonging to the specified project
     * for the given search criteria which include searchby such as
     * Bone, Accession, Sample Number, etc and the search string.
     *
     * For a full listing of search by criteria, see $allowedSearch
     *
     * @param Request $request
     * @param Project $project
     * @return CoraResourceCollection|\Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function searchDnas(Request $request, Project $project)
    {
        $this->logInfo(__METHOD__);
        if ($request->has('searchby') && $request->has('searchby')) {
            $searchBy = $request->query('searchby');
            $searchString = $request->query('searchstring');
            $this->logInfo(__METHOD__,"SearchBy:".$searchBy." SearchString:".$searchString);
        } else {
            return response()->json([ "data" => "Invalid or missing search parameters"], 404);
        }

        if (!isset($searchBy) || !isset($searchString)) {
            return response()->json([ "data" => "Invalid or missing search parameters"], 404);
        }

        if ($this->authorize('browse', [ Dna::class ])) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            try {
                if (Project::where('id', $project->id)->exists()) {
                    $is_DNA_Records = $this->buildDnaCriteriaData($request);
                    if ($is_DNA_Records) {
                        $this->logInfo(__METHOD__,"DNA Search count:". (isset($this->dnas) ? $this->dnas->count() : 0));
                        return new CoraResourceCollection($this->dnas->paginate($this->per_page));
                    } else { // it is returning SE records
                        $this->logInfo(__METHOD__,"DNA-SE Search count:". (isset($this->specimens) ? $this->specimens->count() : 0));
                        return new CoraResourceCollection($this->specimens->paginate($this->per_page));
                    }
                } else {
                    return response()->json([ "data" => "Project not found" ], 404);
                }
            } catch (QueryException $ex) {
                $this->logQueryException(__METHOD__, $request, $ex);
                return response()->json([ 'data' => trans('messages.model_index_view_unsuccessful', ['model'=>'Project Dna Search']) ], 422);
            }
        } else {
            return response()->json([ "data" => "Not authorized to view all resources" ], 403);
        }
    }

    /**
     * @param Request $request
     * @return bool
     */
    private function buildDnaCriteriaData(Request $request)
    {
        $this->logInfo(__METHOD__);
        $is_DNA_Records = true;
        $searchBy = $request->query('searchby');
        $searchString = $request->query('searchstring');

        try {
            $query = null;
            if ($searchBy == 'EN') {
                $this->dnas = Dna::with(['skeletalelement','tags'])->where('external_case_id', $searchString);
                $this->search_results_by_string = trans('messages.search_results_by_string', ['model' => 'DNA', 'searchby' => 'External Number', 'searchstring' => $searchString]);
            } else if ($searchBy == 'MS') {
                $this->search_results_by_string = trans('messages.search_results_by_string', ['model' => 'DNA', 'searchby' => 'Mito Sequence Number', 'searchstring' => $searchString]);
                if (is_numeric($searchString)) {
                    $this->dnas = Dna::with(['skeletalelement','tags'])->where('mito_sequence_number', $searchString);
                } else {
                    // User has entered something like 29b, where 29 is mito_sequence_number and b is mito_sequence_subgroup
                    // Split the string to get the individual components
                    $split = preg_split('#(?<=\d)(?=[a-z])#i', $searchString);
                    $this->dnas = Dna::with(['skeletalelement','tags'])->where('mito_sequence_number', $split[0])->where('mito_sequence_subgroup', $split[1]);
                }
            } else if ($searchBy == 'SN') {
                $query = Dna::with(['skeletalelement','tags'])->where('sample_number', $searchString);
                $this->dnas = $query;
                $this->search_results_by_string = trans('messages.search_results_by_string', ['model' => 'DNA', 'searchby' => 'Sample Number', 'searchstring' => $searchString]);
            } else if ($searchBy == 'HG') {
                $hg = Haplogroup::where('letter', $searchString)->get();
                $this->dnas = null;
                $this->search_results_by_string = trans('messages.search_results_by_string', ['model' => 'DNA', 'searchby' => 'Haplogroup', 'searchstring' => $searchString]);
                if (!$hg->isEmpty()) {
                    $query = Dna::with(['skeletalelement','tags'])->where('mito_haplogroup_id', $hg->first()->id)->get();
                    $this->dnas = $query;
                }
            } else if ($searchBy == 'IN') {
                $this->specimens = SkeletalElement::with(['dnas','tags'])
                    ->withCount(['pairs', 'articulations', 'refits', 'morphologys', 'methods', 'pathologys', 'traumas','anomalys'])
                    ->where('individual_number', $searchString);
                $this->search_results_by_string = trans('messages.search_results_by_string', ['model' => 'DNA', 'searchby' => 'Individual Number', 'searchstring' => $searchString]);
                $is_DNA_Records = false;
            } else if ($searchBy == 'AN') {
                $this->specimens = SkeletalElement::with(['dnas','tags'])
                    ->withCount(['pairs', 'articulations', 'refits', 'morphologys', 'methods', 'pathologys', 'traumas','anomalys'])
                    ->where('accession_number', $searchString);
                $this->search_results_by_string = trans('messages.search_results_by_string', ['model' => 'DNA', 'searchby' => 'Accession Number', 'searchstring' => $searchString]);
                $is_DNA_Records = false;
            } else if ($searchBy == 'P1') {
                $this->specimens = SkeletalElement::with(['dnas','tags'])
                    ->withCount(['pairs', 'articulations', 'refits', 'morphologys', 'methods', 'pathologys', 'traumas','anomalys'])
                    ->where('provenance1', $searchString);
                $this->search_results_by_string = trans('messages.search_results_by_string', ['model' => 'DNA', 'searchby' => 'Provenance1', 'searchstring' => $searchString]);
                $is_DNA_Records = false;
            } else if ($searchBy == 'P2') {
                $this->specimens = SkeletalElement::with(['dnas','tags'])
                    ->withCount(['pairs', 'articulations', 'refits', 'morphologys', 'methods', 'pathologys', 'traumas','anomalys'])
                    ->where('provenance2', $searchString);
                $this->search_results_by_string = trans('messages.search_results_by_string', ['model' => 'DNA', 'searchby' => 'Provenance2', 'searchstring' => $searchString]);
                $is_DNA_Records = false;
            } else if ($searchBy == 'DN') {
                $this->specimens = SkeletalElement::with(['dnas','tags'])
                    ->withCount(['pairs', 'articulations', 'refits', 'morphologys', 'methods', 'pathologys', 'traumas','anomalys'])
                    ->where('designator', $searchString);
                $this->search_results_by_string = trans('messages.search_results_by_string', ['model' => 'DNA', 'searchby' => 'Designator', 'searchstring' => $searchString]);
                $is_DNA_Records = false;
            } else if ($searchBy == 'SB') {
                $bone = SkeletalBone::where('search_name', strtolower($searchString))->get();
                $this->search_results_by_string = trans('messages.search_results_by_string', ['model' => 'DNA', 'searchby' => 'Bone', 'searchstring' => $searchString]);
                if (!$bone->isEmpty()) {
                    $this->specimens = SkeletalElement::with(['dnas','tags'])
                        ->withCount(['pairs', 'articulations', 'refits', 'morphologys', 'methods', 'pathologys', 'traumas','anomalys'])
                        ->where('sb_id', $bone->first()->id);
                    $is_DNA_Records = false;
                }
            } else if ($searchBy == 'CK') {
                $values = array_map('trim', explode(SkeletalElement::$key_delimiter, $searchString));
                if (strpos($searchString, ',') !== false) {
                    $values = array_map('trim', explode(',', $searchString));
                }
                $accession = (isset($values[0]) && !empty($values[0])) ? $values[0] : null;
                $prov1 = (isset($values[1]) && !empty($values[1])) ? $values[1] : null;
                $prov2 = (isset($values[2]) && !empty($values[2])) ? $values[2] : null;
                $designator = (isset($values[3]) && !empty($values[3])) ? $values[3] : null;

                $query = SkeletalElement::with(['dnas','tags'])->withCount(['pairs', 'articulations', 'refits', 'morphologys', 'methods', 'pathologys', 'traumas','anomalys']);
                if(isset($accession)) { $query = $query->where('accession_number', $accession); }
                if(isset($prov1)) { $query = $query->where('provenance1', $prov1); }
                if(isset($prov2)) { $query = $query->where('provenance2', $prov2); }
                if(isset($designator)) { $query = $query->where('designator', $designator);}

                $this->search_results_by_string = trans('messages.search_results_by_string', ['model' => 'DNA', 'searchby' => 'Composite Key', 'searchstring' => $searchString]);
                $this->specimens = $query;
                $is_DNA_Records = false;
            }else {
                $is_DNA_Records = false;
            }

            return $is_DNA_Records;
        } catch(QueryException $ex){
            $this->logQueryException(__METHOD__, $request, $ex);
            return $is_DNA_Records;
        }
    }

    /*
     * Display a listing of the project association resource for the specified association type
     *
     * For a full listing of association type, see $allowed_association_types
     *
     * @param Request $request
     * @param Project $project
     * @return CoraResourceCollection|JsonResponse|\Illuminate\Http\Resources\Json\AnonymousResourceCollection
     * @throws AuthorizationException
     */
    /**
     * @param Request $request
     * @param Project $project
     * @return JsonResponse|\Illuminate\Http\Resources\Json\AnonymousResourceCollection
     * @throws AuthorizationException
     */
    public function getAssociations(Request $request, Project $project)
    {
        $this->logInfo(__METHOD__);
        if ($this->authorize('read', [Project::class, $project])) {
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
                    case "instruments":
                        $list = $project->instruments();
//                        return new CoraResourceCollection($list);
                        break;
                    case "users":
                        $list = $project->users()->paginate($this::$pagination_length_large);
                        break;
                    default: // should never get here.
                        return response()->json([ "data" => "Bad request: missing request parameters"], 400);
                }

                return ListResource::collection($list)->additional(["project" => $project,
                    "status"=>"success", 'message'=>"Project associations get successful"]);
            } catch (QueryException $ex) {
                $this->logQueryException(__METHOD__, $request, $ex);
                return response()->json([ 'data' => trans('messages.model_update_unsuccessful', ['model'=>'Project']) ], 422);
            }
        } else {
            return response()->json([ "data" => "Not Authorized to read project" ], 403);
        }
    }

    /**
     * Update the specified user association resource for the specified association type
     *
     * For a full listing of association type, see $allowed_association_types
     *
     * @param Request $request
     * @param Project $project
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function updateAssociations(Request $request, Project $project)
    {
        $this->logInfo(__METHOD__);
        if ($this->authorize('edit', [Project::class, $project])) {
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

                $response_data = $this->syncAssociations($project, $request, $listIds, $type);
                return response()->json(["data"=>$response_data, "project"=>$project,
                    "status"=>"success", 'message'=>"Project associations updated successful"],200);
            } catch (QueryException $ex) {
                $this->logQueryException(__METHOD__, $request, $ex);
                return response()->json([ 'data' => trans('messages.model_update_unsuccessful', ['model'=>'Project']) ], 422);
            }
        } else {
            return response()->json([ "data" => "Not Authorized to edit project" ], 403);
        }
    }

    /**
     * @param Project $project
     * @param Request $request
     * @param $listIds
     * @param $type
     * @return array|\Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    protected function syncAssociations(Project $project, Request $request, $listIds, $type) {
        $this->logInfo(__METHOD__);
        $listIds = isset($listIds) ? $listIds : [];
        $list = null;
        switch ($type) {
            case "instruments":
                return [ "data" => "Bad request: unsupported association type - update project instruments not allowed" ];
                break;
            case "users":
                $project->users()->sync($this->populateCreateFieldsForSyncWithIDs($listIds));
                $list = $project->users()->paginate($this::$pagination_length_large);
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

    // New Api for multiple selection criteria for Specimens and DNA

    /**
     * @param Request $request
     * @param Project $project
     * @return CoraResourceCollection|JsonResponse|\Illuminate\Http\RedirectResponse|\Illuminate\Http\Resources\Json\AnonymousResourceCollection
     * @throws AuthorizationException
     */
    public function getProjectSpecimens(Request $request, Project $project)
    {
        $this->logInfo(__METHOD__);
        if ($this->authorize('browse', [SkeletalElement::class])) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            if ($project->id !== $this->theProject->id) {
                $this->logInfo(__METHOD__, "Not Authorized to view Project data for ".$project->name);
                return response()->json([ "data" => "Not Authorized to view Project data for ".$project->name ], 403);
            }

            // $this->logInfo(__METHOD__, "Request". json_encode($request->all()));
            try {
                if ($request->query('list')) {
                    $query = SkeletalElement::withoutGlobalScope(ProjectScope::class)
                        ->select('dnas.*', 'skeletal_bones.*', 'skeletal_elements.*')
                        ->where('skeletal_elements.org_id', '=', $this->theOrg->id)
                        ->where('skeletal_elements.project_id', $this->theProject->id)
                        ->join('skeletal_bones', 'skeletal_bones.id', '=', 'skeletal_elements.sb_id')
                        ->leftJoin('dnas', 'skeletal_elements.id', '=', 'dnas.se_id');
                    $query = $this->whereANP1P2($request, $query,'skeletal_elements.accession_number','skeletal_elements.provenance1','skeletal_elements.provenance2');
                    $query = $this->whereBoneSide($request, $query,'skeletal_elements.sb_id','skeletal_elements.side');
                    $results = $query->get();

                    $this->logInfo(__METHOD__, $this->criteriaSelections . " Report record count:" . count($results));
                    return SpecimenListResource::collection($results)->additional(["count"=>count($results), "criteria"=>$request->all(),
                        "criteriaSelection"=>$this->criteriaSelections, "request"=>$request, "query"=>$query]);
                } else {
                    $query = SkeletalElement::withoutGlobalScope(ProjectScope::class)
                        ->select('dnas.*', 'skeletal_bones.*', 'skeletal_elements.*')
                        ->where('skeletal_elements.org_id', '=', $this->theOrg->id)
                        ->where('skeletal_elements.project_id', $this->theProject->id)
                        ->join('skeletal_bones', 'skeletal_bones.id', '=', 'skeletal_elements.sb_id')
                        ->leftJoin('dnas', 'skeletal_elements.id', '=', 'dnas.se_id');
                    $query = $this->whereANP1P2($request, $query,'skeletal_elements.accession_number','skeletal_elements.provenance1','skeletal_elements.provenance2');
                    $query = $this->whereBoneSide($request, $query,'skeletal_elements.sb_id','skeletal_elements.side');
                    $results = $query->paginate($this::$pagination_length_large);

                    $this->logInfo(__METHOD__, $this->criteriaSelections . " Report record count:" . count($results));
                    return (new CoraResourceCollection($results))->additional(["count"=>count($results), "criteria"=>$request->all(),
                        "criteriaSelection"=>$this->criteriaSelections, "request"=>$request, "query"=>$query]);
                }
            } catch (QueryException $ex) {
                $this->logQueryException(__METHOD__, $ex);
                return redirect()->back();
            }
        }
    }

    /**
     * @param Request $request
     * @param Project $project
     * @return CoraResourceCollection|JsonResponse|\Illuminate\Http\RedirectResponse
     * @throws AuthorizationException
     */
    public function getProjectDnas(Request $request, Project $project)
    {
        $this->logInfo(__METHOD__);
        if ($this->authorize('browse', [Dna::class])) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            if ($project->id !== $this->theProject->id) {
                $this->logInfo(__METHOD__, "Not Authorized to view Project data for ".$project->name);
                return response()->json([ "data" => "Not Authorized to view Project data for ".$project->name ], 403);
            }

            try {
                $query = Dna::withoutGlobalScope(ProjectScope::class)
                    ->where('dnas.org_id', '=', $this->theOrg->id)
                    ->where('dnas.project_id', $this->theProject->id)
                    ->join('skeletal_elements', 'skeletal_elements.id', '=', 'dnas.se_id')
                    ->join('skeletal_bones', 'skeletal_bones.id', '=', 'skeletal_elements.sb_id');
                $query = $this->whereANP1P2($request, $query,'skeletal_elements.accession_number','skeletal_elements.provenance1','skeletal_elements.provenance2');
                $query = $this->whereDnaMitoCriteria($request, $query);
                $query = $this->whereDnaYstrCriteria($request, $query);
                $query = $this->whereDnaAustrCriteria($request, $query);
                $results = $query->paginate($this::$pagination_length_large);

                $this->logInfo(__METHOD__, $this->criteriaSelections . " Report record count:" . count($results));
                return (new CoraResourceCollection($results))->additional(["count"=>count($results), "criteria"=>$request->all(),
                    "criteriaSelection"=>$this->criteriaSelections, "request"=>$request, "query"=>$query]);
            } catch (QueryException $ex) {
                $this->logQueryException(__METHOD__, $ex);
                return redirect()->back();
            }
        }
    }

    /**
     * @param Request $request
     * @param $query
     * @param string $an
     * @param string $p1
     * @param string $p2
     * @return mixed
     */
    private function whereANP1P2(Request $request, $query, $an='accession_number', $p1='provenance1', $p2='provenance2')
    {
        $query = $request['an'] ? $query->whereIn($an, $request['an']) : $query;
        $this->criteriaSelections .= ($request['an']) ? " Accession Number:" . json_encode($request['an']) : "";

        $query = $request['p1'] ? $query->whereIn($p1, $request['p1']) : $query;
        $this->criteriaSelections .= ($request['p1']) ? " Provenance1:" . json_encode($request['p1']) : "";

        $query = $request['p2'] ? $query->whereIn($p2, $request['p2']) : $query;
        $this->criteriaSelections .= ($request['p2']) ? " Provenance2:" . json_encode($request['p2']) : "";

        return $query;
    }

    /**
     * @param Request $request
     * @param $query
     * @param string $an
     * @param string $p1
     * @param string $p2
     * @return mixed
     */
    private function whereBoneSide(Request $request, $query, $bone='skeletal_elements.sb_id', $side='skeletal_elements.side')
    {
        $query = $request['bone'] ? $query->whereIn($bone, $request['bone']) : $query;
        $this->criteriaSelections .= ($request['bone']) ? " Bone id:" . json_encode($request['bone']) : "";

        $query = $request['side'] ? $query->whereIn($side, $request['side']) : $query;
        $this->criteriaSelections .= ($request['side']) ? " Side:" . json_encode($request['side']) : "";

        return $query;
    }

    /**
     * @param Request $request
     * @param $query
     * @return mixed
     */
    private function whereDnaMitoCriteria(Request $request, $query)
    {
        $query = $request['mito_sequence_number_list'] ? $query->whereIn("mito_sequence_number", $request['mito_sequence_number_list']) : $query;
        $this->criteriaSelections .= ($request['mito_sequence_number_list']) ? " Mito Sequence Number:" . json_encode($request['mito_sequence_number_list']) : "";

        $query = $request['mito_sequence_subgroup_list'] ? $query->whereIn("mito_sequence_subgroup", $request['mito_sequence_subgroup_list']) : $query;
        $this->criteriaSelections .= ($request['mito_sequence_subgroup_list']) ? " Mito Sequence Subgroup:" . json_encode($request['mito_sequence_subgroup_list']) : "";

        $query = $request['mito_results_confidence_list'] ? $query->whereIn("mito_results_confidence", $request['mito_results_confidence_list']) : $query;
        $this->criteriaSelections .= ($request['mito_results_confidence_list']) ? " Mito Results Confidence:" . json_encode($request['mito_results_confidence_list']) : "";

        // Handle Request & Receive Start and End Dates
        if ($request['mito_request_date_start'] && $request['mito_request_date_end']) {
            $query = $query->whereBetween('mito_request_date', [$request['mito_request_date_start'], $request['mito_request_date_end']]);
            $this->criteriaSelections .= " Request Dates From:" . json_encode($request['mito_request_date_start']);
            $this->criteriaSelections .= " Request Dates To:" . json_encode($request['mito_request_date_end']);
        }
        if ($request['mito_receive_date_start'] && $request['mito_receive_date_end']) {
            $query = $query->whereBetween('mito_receive_date', [$request['mito_receive_date_start'], $request['mito_receive_date_end']]);
            $this->criteriaSelections .= " Receive Dates From:" . json_encode($request['mito_receive_date_start']);
            $this->criteriaSelections .= " Receive Dates To:" . json_encode($request['mito_receive_date_end']);
        }

        return $query;
    }

    /**
     * @param Request $request
     * @param $query
     * @return mixed
     */
    private function whereDnaYstrCriteria(Request $request, $query)
    {
        $query = $request['ystr_sequence_number_list'] ? $query->whereIn("ystr_sequence_number", $request['ystr_sequence_number_list']) : $query;
        $this->criteriaSelections .= ($request['ystr_sequence_number_list']) ? " Mito Sequence Number:" . json_encode($request['ystr_sequence_number_list']) : "";

        $query = $request['ystr_sequence_subgroup_list'] ? $query->whereIn("ystr_sequence_subgroup", $request['ystr_sequence_subgroup_list']) : $query;
        $this->criteriaSelections .= ($request['ystr_sequence_subgroup_list']) ? " Mito Sequence Subgroup:" . json_encode($request['ystr_sequence_subgroup_list']) : "";

        $query = $request['ystr_results_confidence_list'] ? $query->whereIn("ystr_results_confidence", $request['ystr_results_confidence_list']) : $query;
        $this->criteriaSelections .= ($request['ystr_results_confidence_list']) ? " Mito Results Confidence:" . json_encode($request['ystr_results_confidence_list']) : "";

        // Handle Request & Receive Start and End Dates
        if ($request['ystr_request_date_start'] && $request['ystr_request_date_end']) {
            $query = $query->whereBetween('ystr_request_date', [$request['ystr_request_date_start'], $request['ystr_request_date_end']]);
            $this->criteriaSelections .= " Request Dates From:" . json_encode($request['ystr_request_date_start']);
            $this->criteriaSelections .= " Request Dates To:" . json_encode($request['ystr_request_date_end']);
        }
        if ($request['ystr_receive_date_start'] && $request['ystr_receive_date_end']) {
            $query = $query->whereBetween('ystr_receive_date', [$request['ystr_receive_date_start'], $request['ystr_receive_date_end']]);
            $this->criteriaSelections .= " Receive Dates From:" . json_encode($request['ystr_receive_date_start']);
            $this->criteriaSelections .= " Receive Dates To:" . json_encode($request['ystr_receive_date_end']);
        }

        return $query;
    }

    /**
     * @param Request $request
     * @param $query
     * @return mixed
     */
    private function whereDnaAustrCriteria(Request $request, $query)
    {
        $query = $request['austr_sequence_number_list'] ? $query->whereIn("austr_sequence_number", $request['austr_sequence_number_list']) : $query;
        $this->criteriaSelections .= ($request['austr_sequence_number_list']) ? " Mito Sequence Number:" . json_encode($request['austr_sequence_number_list']) : "";

        $query = $request['austr_sequence_subgroup_list'] ? $query->whereIn("austr_sequence_subgroup", $request['austr_sequence_subgroup_list']) : $query;
        $this->criteriaSelections .= ($request['austr_sequence_subgroup_list']) ? " Mito Sequence Subgroup:" . json_encode($request['austr_sequence_subgroup_list']) : "";

        $query = $request['austr_results_confidence_list'] ? $query->whereIn("austr_results_confidence", $request['austr_results_confidence_list']) : $query;
        $this->criteriaSelections .= ($request['austr_results_confidence_list']) ? " Mito Results Confidence:" . json_encode($request['austr_results_confidence_list']) : "";

        // Handle Request & Receive Start and End Dates
        if ($request['austr_request_date_start'] && $request['austr_request_date_end']) {
            $query = $query->whereBetween('austr_request_date', [$request['austr_request_date_start'], $request['austr_request_date_end']]);
            $this->criteriaSelections .= " Request Dates From:" . json_encode($request['austr_request_date_start']);
            $this->criteriaSelections .= " Request Dates To:" . json_encode($request['austr_request_date_end']);
        }
        if ($request['austr_receive_date_start'] && $request['austr_receive_date_end']) {
            $query = $query->whereBetween('austr_receive_date', [$request['austr_receive_date_start'], $request['austr_receive_date_end']]);
            $this->criteriaSelections .= " Receive Dates From:" . json_encode($request['austr_receive_date_start']);
            $this->criteriaSelections .= " Receive Dates To:" . json_encode($request['austr_receive_date_end']);
        }

        return $query;
    }
}
