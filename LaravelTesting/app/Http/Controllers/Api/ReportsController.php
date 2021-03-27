<?php

/**
 * Cora Api ReportsController
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

use App\BoneGroup;
use App\Http\Resources\SpecimenListResource;
use App\Org;
use App\Project;
use App\Dna;
use App\Isotope;
use App\Anomaly;
use App\Http\Controllers\Controller;
use App\Http\Resources\CoraResource;
use App\Http\Resources\CoraResourceCollection;
use App\Http\Resources\ListResource;
use App\Haplogroup;
use App\Method;
use App\MethodFeature;
use App\Scopes\ProjectScope;
use App\SkeletalBone;
use App\SkeletalElement;
use Carbon\Carbon;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Measurement;
use App\Pathology;
use App\Trauma;

/**
 * Class ReportsController
 * @package App\Http\Controllers\Api
 */
class ReportsController extends Controller
{
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
     * ReportsController constructor.
     */
    public function __construct()
    {
        parent::__construct();

        $this->initialize();
    }

    /**
     *
     */
    protected function initialize()
    {
        $this->today = Carbon::now();
        $this->criteriaData = ['sb_id' => "", 'side' => "", 'completeness' => "", 'measured' => false, 'dna_sampled' => false,
            'ystr' => false, 'astr' => false, 'ct_scanned' => false, 'xray_scanned' => false, 'clavicle_triage' => false,
            'inventoried' => false, 'reviewed' => false, 'taphonomy_id' => "", 'measurement_id' => "",
            'inventoried_by_user' => 0, 'reviewed_by_user' => 0,
            'heading' => "", 'groupby_sb_id' => "", 'groupby_taphonomy_id' => "", 'groupby' => ""
        ];
    }

    /**
     * @param Request $request
     * @param Org $org
     * @return CoraResourceCollection|JsonResponse|\Illuminate\Http\RedirectResponse
     * @throws AuthorizationException
     */
    public function getOrgDna(Request $request, Org $org)
    {
        $this->logInfo(__METHOD__);
        if ($this->authorize('browse', [SkeletalElement::class])) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            if ($org->id !== $this->theOrg->id) {
                $this->logInfo(__METHOD__, "Not Authorized to view Org data for ".$org->acronym);
                return response()->json([ "data" => "Not Authorized to view Org data for ".$org->acronym ], 403);
            }
            $type = null;
            if ($request->has('type')) {
                $type = $request['type'];
            } else {
                $this->logInfo(__METHOD__, "Missing request parameter dna type ");
                return response()->json([ "data" => "Bad request: missing request parameter: type"], 400);
            }

            try {
                $query = Dna::withoutGlobalScope(ProjectScope::class)
                    ->where('dnas.org_id', '=', $this->theOrg->id)
                    ->join('skeletal_elements', 'skeletal_elements.id', '=', 'dnas.se_id')
                    ->join('skeletal_bones', 'skeletal_bones.id', '=', 'skeletal_elements.sb_id');
                if ($type === "mito") {
                    $query = $this->whereDnaMitoCriteria($request, $query);
                } else if ($type === "ystr") {
                    $query = $this->whereDnaYstrCriteria($request, $query);
                } else if ($type === "austr") {
                    $query = $this->whereDnaAustrCriteria($request, $query);
                }
                else{
                    $this->logInfo(__METHOD__, "Invalid parameter dna type ");
                }
                $query = $this->whereProjectANP1P2($request, $query,'dnas.project_id','skeletal_elements.accession_number','skeletal_elements.provenance1','skeletal_elements.provenance2');
                $results = $request['per_page'] ? $query->paginate($request['per_page']) : $query->paginate($this::$pagination_length_large);

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
     * @param Project $project
     * @return CoraResourceCollection|JsonResponse|\Illuminate\Http\RedirectResponse
     * @throws AuthorizationException
     */
    public function getProjectDna(Request $request, Project $project)
    {
        $this->logInfo(__METHOD__);
        if ($this->authorize('browse', [SkeletalElement::class])) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            if ($project->id !== $this->theProject->id) {
                $this->logInfo(__METHOD__, "Not Authorized to view Project data for ".$project->name);
                return response()->json([ "data" => "Not Authorized to view Project data for ".$project->name ], 403);
            }
            $type = null;
            if ($request->has('type')) {
                $type = $request['type'];
            } else {
                $this->logInfo(__METHOD__, "Missing request parameter dna type ");
                return response()->json([ "data" => "Bad request: missing request parameter: type"], 400);
            }

            try {
                $query = Dna::withoutGlobalScope(ProjectScope::class)
                    ->where('dnas.org_id', '=', $this->theOrg->id)
                    ->where('dnas.project_id', $this->theProject->id)
                    ->join('skeletal_elements', 'skeletal_elements.id', '=', 'dnas.se_id')
                    ->join('skeletal_bones', 'skeletal_bones.id', '=', 'skeletal_elements.sb_id');
                if ($type === "mito") {
                    $query = $this->whereDnaMitoCriteria($request, $query);
                } else if ($type === "ystr") {
                    $query = $this->whereDnaYstrCriteria($request, $query);
                } else if ($type === "austr") {
                    $query = $this->whereDnaAustrCriteria($request, $query);
                }
                $query = $this->whereProjectANP1P2($request, $query,'dnas.project_id','skeletal_elements.accession_number','skeletal_elements.provenance1','skeletal_elements.provenance2');
                $results = $request['per_page'] ? $query->paginate($request['per_page']) : $query->paginate($this::$pagination_length_large);

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
     * @param string $project_id
     * @param string $an
     * @param string $p1
     * @param string $p2
     * @return mixed
     */
    private function whereProjectANP1P2(Request $request, $query, $project_id='project_id', $an='accession_number', $p1='provenance1', $p2='provenance2')
    {
        $query = $request['project_id'] ? $query->whereIn($project_id, $request['project_id']) : $query;
        $this->criteriaSelections .= ($request['project_id']) ? " Project Id:" . json_encode($request['project_id']) : "";

        $query = $this->whereANP1P2($request, $query, $an, $p1, $p2);
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
     * @param Request $requestmito_sequence_number_list
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
            $query = $query->whereBetween('mito_request_date', [$request['mitor_request_date_start'], $request['mito_request_date_end']]);
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
        $this->criteriaSelections .= ($request['austr_sequence_number_list']) ? " Austr Sequence Number:" . json_encode($request['austr_sequence_number_list']) : "";

        $query = $request['austr_sequence_subgroup_list'] ? $query->whereIn("austr_sequence_subgroup", $request['austr_sequence_subgroup_list']) : $query;
        $this->criteriaSelections .= ($request['austr_sequence_subgroup_list']) ? " Austr Sequence Subgroup:" . json_encode($request['austr_sequence_subgroup_list']) : "";

        $query = $request['austr_results_confidence_list'] ? $query->whereIn("austr_results_confidence", $request['austr_results_confidence_list']) : $query;
        $this->criteriaSelections .= ($request['austr_results_confidence_list']) ? " Austr Results Confidence:" . json_encode($request['austr_results_confidence_list']) : "";

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

    /**
     * @param Request $request
     * @param Project $project
     * @return CoraResourceCollection|JsonResponse|\Illuminate\Http\RedirectResponse
     * @throws AuthorizationException
     */
    public function getProjectSpecimenComparison(Request $request, Project $project)
    {
        $this->logInfo(__METHOD__);
        if ($this->authorize('browse', [SkeletalElement::class])) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            if ($project->id !== $this->theProject->id) {
                $this->logInfo(__METHOD__, "Not Authorized to view Project data for ".$project->name);
                return response()->json([ "data" => "Not Authorized to view Project data for ".$project->name ], 403);
            }
            $listIds = null;
            if ($request->has('listIds')) {
                $listIds = $request['listIds'];
            } else {
                $this->logInfo(__METHOD__, "Missing request parameter listIds ");
                return response()->json([ "data" => "Bad request: missing request parameter: listIds"], 400);
            }

            try {
                $results = SkeletalElement::with(["dnas", "measurements", "zones", "traumas", "pathologys", "taphonomys", "methods"])
                    ->whereIn("id", $listIds)->get();

                $this->logInfo(__METHOD__, "ListIds: " . json_encode($listIds) . " Report record count:" . count($results));
                return (new CoraResourceCollection($results))->additional(["count"=>count($results), "criteria"=>$request->all()]);
            } catch (QueryException $ex) {
                $this->logQueryException(__METHOD__, $ex);
                return redirect()->back();
            }
        }
    }

    /**
     * @param Request $request
     * @param Project $project
     * @return CoraResourceCollection|JsonResponse|\Illuminate\Http\RedirectResponse|string[]
     * @throws AuthorizationException
     */
    public function getProjectAnomaly(Request $request, Project $project)
    {
        $this->logInfo(__METHOD__);
        $skeletal_anomaly = null;
        if ($this->authorize('browse', [SkeletalElement::class])) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            if ($project->id !== $this->theProject->id) {
                $this->logInfo(__METHOD__, "Not Authorized to view Project data for ".$project->name);
                return response()->json([ "data" => "Not Authorized to view Project data for ".$project->name ], 403);
            }
            try {
                if ($request->input('anomaly_select')) {
                    $query = SkeletalElement::withoutGlobalScope(ProjectScope::class)
                        ->with(['anomalys', 'skeletalbone'])
                        ->join('se_anomaly', 'skeletal_elements.id', '=', 'se_anomaly.se_id')
                        ->where('skeletal_elements.project_id', $this->theProject->id)
                        ->whereIn('anomaly_id', $request['anomaly_select'])
                        ->select('skeletal_elements.*','se_anomaly.anomaly_id');
                }
                else {
                    $query = SkeletalElement::withoutGlobalScope(ProjectScope::class)
                        ->join('se_anomaly', 'skeletal_elements.id', '=', 'se_anomaly.se_id')
                        ->where('skeletal_elements.project_id', $this->theProject->id)
                        ->select('skeletal_elements.*','se_anomaly.anomaly_id');
                    $this->criteriaSelections .= " Anomaly:[None selected]";
                }
                $query = $this->whereProjectANP1P2($request, $query, 'skeletal_elements.project_id', 'skeletal_elements.accession_number','skeletal_elements.provenance1','skeletal_elements.provenance2');
                $query = $this->whereBoneSide($request, $query);
                $results = $request['per_page'] ? $query->paginate($request['per_page']): $query->paginate($this::$pagination_length_large);
                if ($request['anomaly_select'] == "") {
                    $skeletal_anomaly = Anomaly::groupBy('individuating_trait', 'id')->orderBy('individuating_trait')->where('sb_id', $request['sb_select'])->pluck('individuating_trait', 'id');
                }
                $this->logInfo(__METHOD__, $this->criteriaSelections . " Report record count:" . count($results));
                return (new CoraResourceCollection($results))->additional(["count"=>count($results), "criteria"=>$request->all(),
                    "skeletal_anomaly"=> $skeletal_anomaly, "criteriaSelection"=>$this->criteriaSelections, "request"=>$request, "query"=>$query]);
            } catch (QueryException $ex) {
                $this->logQueryException(__METHOD__, $ex);
                return redirect()->back();
            }
        }
    }

    /**
     * @param Request $request
     * @param $query
     * @return mixed
     */
    private function whereBoneSide(Request $request, $query)
    {
        $query = $this->whereBone($request, $query);
        $query = $this->whereSide($request, $query);
        return $query;
    }

    /**
     * @param Request $request
     * @param $query
     * @return mixed
     */
    private function whereBone(Request $request, $query)
    {
        if ($request['sb_select'] != "") {
            $query->where('sb_id', $request['sb_select']);
            $this->criteriaSelections .= " Bone:" . json_encode($request['sb_select']);
        }
        return $query;
    }

    /**
     * @param Request $request
     * @param $query
     * @return mixed
     */
    private function whereSide(Request $request, $query)
    {
        if ($request['side_select'] != "") {
            $query->where('side', $request['side_select']);
            $this->criteriaSelections .= " Side:" . json_encode($request['side_select']);
        }
        return $query;
    }

    /**
     * @param Request $request
     * @param Project $project
     * @return CoraResourceCollection|JsonResponse|\Illuminate\Http\RedirectResponse
     * @throws AuthorizationException
     */
    public function getProjectTrauma( Request $request, Project $project )
    {
        $this->logInfo(__METHOD__);
        if ($this->authorize('browse', [SkeletalElement::class])) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            if ($project->id !== $this->theProject->id) {
                $this->logInfo(__METHOD__, "Not Authorized to view Project data for " . $project->name);
                return response()->json(["data" => "Not Authorized to view Project data for " . $project->name], 403);
            }
            try{
                if ($request->input('trauma_select')){
                    $query = SkeletalElement::withoutGlobalScope(ProjectScope::class)
                        ->with(['dnas', 'skeletalbone']) // Swetha: Eager load dnas and skeletalbone
                        ->join('se_trauma', 'skeletal_elements.id', '=', 'se_trauma.se_id')
                        ->where('skeletal_elements.project_id', $this->theProject->id)
                        ->whereIn('trauma_id',$request['trauma_select'] )
                        ->select('skeletal_elements.*', 'se_trauma.zone_id', 'se_trauma.trauma_id');
                }
                $query = $this->whereProjectANP1P2($request, $query, 'skeletal_elements.project_id', 'skeletal_elements.accession_number','skeletal_elements.provenance1','skeletal_elements.provenance2');
                $query = $this->whereBoneSide($request, $query);
                $queryCollect = collect($query->get()->unique());
                $skeletalelements = $queryCollect->all();
                $results = $request['per_page'] ? $query->paginate($request['per_page']): $query->paginate($this::$pagination_length_large);

                $traumas = Trauma::orderBy('timing')->orderBy('type')->whereIn('id', $request['trauma_select'])->get();
                // Get Traumas by zones list
                $traumas_by_zones_list = collect([]);
                collect($skeletalelements)->each(function($skeletalelement) use($traumas, $traumas_by_zones_list) {
                    $zones_list = [];
                    foreach ($traumas as $trauma) {
                        $zones_list[$trauma->name] = $skeletalelement->traumasByZonesList($trauma->id);
                    }
                    $traumas_by_zones_list[$skeletalelement->id] = $zones_list;
                });

                $this->logInfo(__METHOD__, $this->criteriaSelections . " Report record count:" . count($results));
                return (new CoraResourceCollection($results))->additional(["count"=>count($results),
                    "traumas" => $traumas, 'traumas_by_zones_list' => $traumas_by_zones_list, "criteria"=>$request->all(),
                    "criteriaSelection"=>$this->criteriaSelections, "request"=>$request, "query"=>$query]);
            }catch (QueryException $ex) {
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
    public function getProjectAdvanced(Request $request, Project $project)
    {
        $this->logInfo(__METHOD__);
        if ($this->authorize('browse', [SkeletalElement::class])) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            if ($project->id !== $this->theProject->id) {
                $this->logInfo(__METHOD__, "Not Authorized to view Project data for " . $project->name);
                return response()->json(["data" => "Not Authorized to view Project data for " . $project->name], 403);
            }
            try {
                $query = SkeletalElement::with('user', 'skeletalbone', 'reviewer'); // Load User and Reveiewer relations
                $query = $this->buildCriteriaData($request, $query);
                $query = $this->whereProjectANP1P2($request, $query, 'skeletal_elements.project_id', 'skeletal_elements.accession_number','skeletal_elements.provenance1','skeletal_elements.provenance2');
                $results = $request['per_page'] ? $query->paginate($request['per_page']): $query->paginate($this::$pagination_length_large);
                $this->logInfo(__METHOD__, $this->criteriaSelections . " Report record count:" . count($results));
                return (new CoraResourceCollection($results))->additional(["count"=>count($results), "criteria"=>$request->all(),
                    "criteriaSelection"=>$this->criteriaSelections, "request"=>$request, "query"=>$query]);
            } catch (QueryException $ex) {
                $this->logQueryException(__METHOD__, $ex);
                return redirect()->back();
            }
        }
    }

    private function buildCriteriaData($request, &$query)
    {
        // Specimen
        if ($request['sb_id'] != "") {
            $query->where('sb_id',$request['sb_id']);
            $this->criteriaSelections .= " Bone Id:" . $this->criteriaData['sb_id'];
        }
        if ($request['side'] != "") {
            $query->where('side', $request['side']);
            $this->criteriaSelections .= " Side:" . $this->criteriaData['side'];
        }
        if ($request['completeness'] != "") {
            $query->where('completeness', $request['completeness']);
            $this->criteriaSelections .= " Completeness:" . $this->criteriaData['completeness'];
        }
        if ($request['inventoried_by_user'] != "") {
            $query->where('user_id', $request['inventoried_by_user']);
            $this->criteriaSelections .= " InventoriedByUser:" . $this->criteriaData['inventoried_by_user'];
        }
        if ($request['reviewed_by_user'] != "") {
            $query->where('reviewer_id', $request['reviewed_by_user']);
            $this->criteriaSelections .= " ReviewedByUser:" . $this->criteriaData['reviewed_by_user'];
        }
        if ($request['measured'] != "") {
            $query->where('measured', true);
            $this->criteriaSelections .= " Measured:true";
        }
        if ($request['dna_sampled'] != "") {
            $query->where('dna_sampled', true);
            $this->criteriaSelections .= " DNASampled:true";
        }
        if ($request['ystr'] != "") {
            $query->where('ystr', true);
        }
        if ($request['astr'] != "") {
            $query->where('astr', true);
        }
        if ($request['ct_scanned'] != "") {
            $query->where('ct_scanned', true);
            $this->criteriaSelections .= " CTScanned:true";
        }
        if ($request['xray_scanned'] != "") {
            $query->where('xray_scanned', true);
            $this->criteriaSelections .= " XRayScanned:true";
        }
        if ($request['clavicle_triage'] != "") {
            $query->where('clavicle_triage', true);
            $this->criteriaSelections .= " ClavicleTriage:true";
        }
        if ($request['inventoried'] != "") {
            $query->where('inventoried', true);
            $this->criteriaSelections .= " Inventoried:true";
        }
        if ($request['reviewed'] != "") {
            $query->where('reviewed', true);
            $this->criteriaSelections .= " Reviewed:true";
        }

        // Taphonomy
        if ($request['taphonomy_id'] != "") {
            $query->where('taphonomy_id', $request['taphonomy_id']);
        }
        if ($request['measurement_id'] != "") {
            $query->where('measurement_id', $request['measurement_id']);
        }

        if ($request['remains_status']) {
            $query = $query->where('remains_status', $request['remains_status']);
        }
        if ($request['remains_release_date_start'] && $request['remains_release_date_end']) {
            $query = $query->whereBetween('remains_release_date', [$request['remains_release_date_start'], $request['remains_release_date_end']]);
        }
        return $query;
    }

    /**
     * @param Request $request
     * @param Project $project
     * @return CoraResourceCollection|JsonResponse|\Illuminate\Http\RedirectResponse
     * @throws AuthorizationException
     */
    public function getProjectMeasurements ( Request $request, Project $project)
    {
        $this->logInfo(__METHOD__);
        if ($this->authorize('browse', [SkeletalElement::class])) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            if ($project->id !== $this->theProject->id) {
                $this->logInfo(__METHOD__, "Not Authorized to view Project data for " . $project->name);
                return response()->json(["data" => "Not Authorized to view Project data for " . $project->name], 403);
            }
            try {
                $query = SkeletalElement::withoutGlobalScope(ProjectScope::class)
                    ->with('skeletalbone','measurements')   // Load bone and measurements data
                    ->where('skeletal_elements.project_id', $this->theProject->id);

                if ($request->input('individual_number_select')) {
                    foreach($request['individual_number_select'] as $individualnumber) {
                        $query->Where('individual_number', 'LIKE', $individualnumber . '%');
                    }
                }
                if ($request->input('side_select_INumber')) {
                    $query->where('side', $request['side_select_INumber']);
                }
                $query = $this->whereProjectANP1P2($request, $query, 'skeletal_elements.project_id', 'skeletal_elements.accession_number','skeletal_elements.provenance1','skeletal_elements.provenance2');
                $query = $this->whereBoneSide($request, $query);
                $results = $request['per_page'] ? $query->paginate($request['per_page']): $query->paginate($this::$pagination_length_large);
                $queryCollect = collect($query->get());
                $skeletalelements = $queryCollect->all();
                $list_individual_number = SkeletalElement::where('individual_number', '!=', null)->orderBy('individual_number', 'asc')->pluck('individual_number', 'individual_number')->unique();
                $sb_ids = array();
                foreach ($skeletalelements as $skeletalelement) {
                    $sb_ids[] = $skeletalelement->sb_id;
                }
                if ($list_individual_number) {
                    $measurements = Measurement::whereIn('sb_id', $sb_ids)->orderBy('sb_id', 'asc')->orderBy('display_order', 'asc')->get();
                } else {
                    $measurements = Measurement::where('sb_id', $request['sb_select'])->orderBy('display_order', 'asc')->get();
                }
                $this->logInfo(__METHOD__, $this->criteriaSelections . " Report record count:" . count($results));
                return (new CoraResourceCollection($results))->additional(["count"=>count($results), "criteria"=>$request->all(),
                    "measurements" => $measurements, "criteriaSelection"=>$this->criteriaSelections, "request"=>$request, "query"=>$query]);
            } catch (QueryException $ex) {
                $this->logQueryException(__METHOD__, $ex);
                return redirect()->back();
            }
        }
    }
    /**
     * @param Request $request
     * @param Org $org
     * @return CoraResourceCollection|JsonResponse|\Illuminate\Http\RedirectResponse
     * @throws AuthorizationException
     */
    public function getOrgIsotope(Request $request, Org $org)
    {
        $this->logInfo(__METHOD__);
        if ($this->authorize('browse', [SkeletalElement::class])) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            if ($org->id !== $this->theOrg->id) {
                $this->logInfo(__METHOD__, "Not Authorized to view Org data for " . $org->acronym);
                return response()->json(["data" => "Not Authorized to view Org data for " . $org->acronym], 403);
            }
            try{
                $query = Isotope::withoutGlobalScope(ProjectScope::class)
                    ->where('isotopes.org_id', $this->theOrg->id)
                    ->join('skeletal_elements', 'skeletal_elements.id', '=', 'isotopes.se_id');
                if ($request->has('results_confidence')) {
                    $query->whereIn('results_confidence', $request['results_confidence']);
                }
                if($request->has('lab_id')){
                    $query->whereIn('lab_id', $request['lab_id']);
                }
                if($request->has('batch_id')){
                    $query->whereIn('batch_id', $request['batch_id']);
                }
                if($request->has('weight_collagen_from')&& $request->has('weight_collagen_to')){
                    $query->whereBetween('weight_collagen',[$request['weight_collagen_from'],$request['weight_collagen_to']]);
                }
                if($request->has('yield_collagen_from')&& $request->has('yield_collagen_to')){
                    $query->whereBetween('yield_collagen',[$request['yield_collagen_from'],$request['yield_collagen_to']]);
                }
                if($request->has('c_weight_from')&& $request->has('c_weight_to')){
                    $query->whereBetween('c_weight',[$request['c_weight_from'],$request['c_weight_to']]);
                }
                if($request->has('n_weight_from')&& $request->has('n_weight_to')){
                    $query->whereBetween('n_weight',[$request['n_weight_from'],$request['n_weight_to']]);
                }
                if($request->has('o_weight_from')&& $request->has('o_weight_to')){
                    $query->whereBetween('o_weight',[$request['o_weight_from'],$request['o_weight_to']]);
                }
                if($request->has('s_weight_from')&& $request->has('s_weight_to')){
                    $query->whereBetween('s_weight',[$request['s_weight_from'],$request['s_weight_to']]);
                }
                if($request->has('c_percent_from')&& $request->has('c_percent_to')){
                    $query->whereBetween('c_percent',[$request['c_percent_from'],$request['c_percent_to']]);
                }
                if($request->has('n_percent_from')&& $request->has('n_percent_to')){
                    $query->whereBetween('n_percent',[$request['n_percent_from'],$request['n_percent_to']]);
                }
                if($request->has('o_percent_from')&& $request->has('o_percent_to')){
                    $query->whereBetween('o_percent',[$request['o_percent_from'],$request['o_percent_to']]);
                }
                if($request->has('s_percent_from')&& $request->has('s_percent_to')){
                    $query->whereBetween('s_percent',[$request['s_percent_from'],$request['s_percent_to']]);
                }
                if($request->has('c_to_n_ratio_from')&& $request->has('c_to_n_ratio_to')){
                    $query->whereBetween('c_to_n_ratio',[$request['c_to_n_ratio_from'],$request['c_to_n_ratio_to']]);
                }
                if($request->has('c_to_o_ratio_from')&& $request->has('c_to_o_ratio_to')){
                    $query->whereBetween('c_to_o_ratio',[$request['c_to_o_ratio_from'],$request['c_to_o_ratio_to']]);
                }

                $query = $this->whereProjectANP1P2($request, $query, 'isotopes.project_id','skeletal_elements.accession_number', 'skeletal_elements.provenance1', 'skeletal_elements.provenance2');
                $results = $request['per_page'] ? $query->paginate($request['per_page']) : $query->paginate($this::$pagination_length_large);
                $this->logInfo(__METHOD__, $this->criteriaSelections . " Report record count:" . count($results));
                return (new CoraResourceCollection($results))->additional(["count" => count($results), "criteria" => $request->all(),
                    "criteriaSelection" => $this->criteriaSelections, "request" => $request, "query" => $query]);
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
    public function getProjectIsotope(Request $request, Project $project)
    {
        $this->logInfo(__METHOD__);
        if ($this->authorize('browse', [SkeletalElement::class])) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            if ($project->id !== $this->theProject->id) {
                $this->logInfo(__METHOD__, "Not Authorized to view Project data for " . $project->name);
                return response()->json(["data" => "Not Authorized to view Project data for " . $project->name], 403);
            }
            try{
                $query = Isotope::withoutGlobalScope(ProjectScope::class)
                    ->where('isotopes.org_id', $this->theOrg->id)
                    ->where('isotopes.project_id', $this->theProject->id)
                    ->join('skeletal_elements', 'skeletal_elements.id', '=', 'isotopes.se_id');
                if ($request->has('results_confidence')) {
                        $query->whereIn('results_confidence', $request['results_confidence']);
                    }
                if($request->has('lab_id')){
                    $query->whereIn('lab_id', $request['lab_id']);
                }
                if($request->has('batch_id')){
                    $query->whereIn('batch_id', $request['batch_id']);
                }
                if($request->has('weight_collagen_from')&& $request->has('weight_collagen_to')){
                    $query->whereBetween('weight_collagen',[$request['weight_collagen_from'],$request['weight_collagen_to']]);
                }
                if($request->has('yield_collagen_from')&& $request->has('yield_collagen_to')){
                    $query->whereBetween('yield_collagen',[$request['yield_collagen_from'],$request['yield_collagen_to']]);
                }
                if($request->has('c_weight_from')&& $request->has('c_weight_to')){
                    $query->whereBetween('c_weight',[$request['c_weight_from'],$request['c_weight_to']]);
                }
                if($request->has('n_weight_from')&& $request->has('n_weight_to')){
                    $query->whereBetween('n_weight',[$request['n_weight_from'],$request['n_weight_to']]);
                }
                if($request->has('o_weight_from')&& $request->has('o_weight_to')){
                    $query->whereBetween('o_weight',[$request['o_weight_from'],$request['o_weight_to']]);
                }
                if($request->has('s_weight_from')&& $request->has('s_weight_to')){
                    $query->whereBetween('s_weight',[$request['s_weight_from'],$request['s_weight_to']]);
                }
                if($request->has('c_percent_from')&& $request->has('c_percent_to')){
                    $query->whereBetween('c_percent',[$request['c_percent_from'],$request['c_percent_to']]);
                }
                if($request->has('n_percent_from')&& $request->has('n_percent_to')){
                    $query->whereBetween('n_percent',[$request['n_percent_from'],$request['n_percent_to']]);
                }
                if($request->has('o_percent_from')&& $request->has('o_percent_to')){
                    $query->whereBetween('o_percent',[$request['o_percent_from'],$request['o_percent_to']]);
                }
                if($request->has('s_percent_from')&& $request->has('s_percent_to')){
                    $query->whereBetween('s_percent',[$request['s_percent_from'],$request['s_percent_to']]);
                }
                if($request->has('c_to_n_ratio_from')&& $request->has('c_to_n_ratio_to')){
                    $query->whereBetween('c_to_n_ratio',[$request['c_to_n_ratio_from'],$request['c_to_n_ratio_to']]);
                }
                if($request->has('c_to_o_ratio_from')&& $request->has('c_to_o_ratio_to')){
                    $query->whereBetween('c_to_o_ratio',[$request['c_to_o_ratio_from'],$request['c_to_o_ratio_to']]);
                }

                $query = $this->whereProjectANP1P2($request, $query, 'isotopes.project_id','skeletal_elements.accession_number', 'skeletal_elements.provenance1', 'skeletal_elements.provenance2');
                $results = $request['per_page'] ? $query->paginate($request['per_page']) : $query->paginate($this::$pagination_length_large);
                $this->logInfo(__METHOD__, $this->criteriaSelections . " Report record count:" . count($results));
                return (new CoraResourceCollection($results))->additional(["count" => count($results), "criteria" => $request->all(),
                    "criteriaSelection" => $this->criteriaSelections, "request" => $request, "query" => $query]);
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
    public function getSpecimensForArticulation(Request $request, Project $project)
    {
        $this->logInfo(__METHOD__);
        if ($this->authorize('browse', [SkeletalElement::class])) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            if ($project->id !== $this->theProject->id) {
                $this->logInfo(__METHOD__, "Not Authorized to view Project data for " . $project->name);
                return response()->json(["data" => "Not Authorized to view Project data for " . $project->name], 403);
            }
            try{
                //establish select values
                $side = $request['side_select'] ? $request['side_select']: null;
                $group_side = $request['group_side_select'] ? $request['group_side_select']: null;
                $group = $request['group_select'];
                $skeletalbone = $request['sb_select'];
                $query = null;
                $skeletalelements = SkeletalElement::withoutGlobalScope(ProjectScope::class)
                    ->where('skeletal_elements.org_id', $this->theOrg->id)
                    ->where('skeletal_elements.project_id', $this->theProject->id);
                // check if doing bone & side search OR group & side search
                if (isset($skeletalbone)) {
                    if (isset($side)) {
                        $query = $skeletalelements->where('sb_id', $skeletalbone)->where('side', $side);
                        $this->criteriaSelections .= " Skeletal Bone:" . json_encode($skeletalbone);
                        $this->criteriaSelections .= " Side:" . json_encode($side);
                    } else {
                        $query = $skeletalelements->where('sb_id', $skeletalbone);
                        $this->criteriaSelections .= " Skeletal Bone:" . json_encode($skeletalbone);
                    }
                    $query = $this->whereANP1P2($request, $query, 'skeletal_elements.accession_number','skeletal_elements.provenance1','skeletal_elements.provenance2');
                    $query = $query->get();
                } elseif (isset($group)) {
                    $skeletalbones = BoneGroup::where('group_name', $group)->pluck('sb_id');
                    if (isset($group_side)) {
                        $query = $skeletalelements->whereIn('sb_id', $skeletalbones)->where('side', $group_side)->get();
                        $this->criteriaSelections .= " Specimen Group:" . json_encode($group);
                        $this->criteriaSelections .= " Specimen Group Side:" . json_encode($group_side);
                    } else {
                        $query = $skeletalelements->whereIn('sb_id', $skeletalbones)->get();
                        $this->criteriaSelections .= " Specimen Group:" . json_encode($group);
                    }
                }
              $results = $query->pluck('key_bone_side', 'id');
              return response()->json($results);
              $this->logInfo(__METHOD__, $this->criteriaSelections . " Report record count:" . count($results));
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
    public function getProjectArticulations(Request $request, Project $project)
    {
        $this->logInfo(__METHOD__);
        if ($this->authorize('browse', [SkeletalElement::class])) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            if ($project->id !== $this->theProject->id) {
                $this->logInfo(__METHOD__, "Not Authorized to view Project data for " . $project->name);
                return response()->json(["data" => "Not Authorized to view Project data for " . $project->name], 403);
            }
            try {
                //establish select values
                $side = $request['side_select'] ? $request['side_select']: null;
                $group_side = $request['group_side_select'] ? $request['group_side_select']: null;
                $group = $request['group_select'];
                $skeletalbone = $request['sb_select'];
                $skeletalelement =$request['skeletalelement_select'];

                if (isset($skeletalelement)) {
                    // check if doing bone search OR group search
                    $skeletalSelected = SkeletalElement::with('skeletalbone')->where('id', $skeletalelement)->first();
                    $result = collect();
                    if (isset($skeletalbone)) {
                        $articulation_ids = $skeletalSelected->getArticulationListAttribute();
                        foreach ($articulation_ids as $articulation_id) {
                            $result->push(SkeletalElement::with('skeletalbone')->where('id', $articulation_id)->first());
                        }
                    } elseif (isset($group)) {
                        $addlist = collect();
                        $addlist->push($skeletalSelected->getArticulationListAttribute());
                        if (isset($group_side)) {
                            while ($addlist->count() != 0) {
                                $articulations = collect();
                                foreach ($addlist as $add) {
                                    foreach (array_keys($add) as $k) {
                                        $v = $add[$k];
                                        $se = SkeletalElement::with('skeletalbone')->where('id', $v)->first();
                                        if (($se->skeletalbone->bonegroups->contains('group_name', $group)) && (!$result->contains('id', $v) && ($v != $skeletalSelected->id)) && ($se->side === $group_side)) {
                                            $articulations->push(SkeletalElement::where('id', $v)->first());
                                            $result->push(SkeletalElement::with('skeletalbone')->where('id', $v)->first());
                                        }
                                    }
                                }
                                $addlist = collect();
                                foreach ($articulations as $articulation) {
                                    $addlist->push($articulation->getArticulationListAttribute());
                                }
                            }
                        } else {
                            while ($addlist->count() != 0) {
                                $articulations = collect();
                                foreach ($addlist as $add) {
                                    foreach (array_keys($add) as $k) {
                                        $v = $add[$k];
                                        $se = SkeletalElement::with('skeletalbone')->where('id', $v)->first();
                                        if (($se->skeletalbone->bonegroups->contains('group_name', $group)) && (!$result->contains('id', $v) && ($v != $skeletalSelected->id))) {
                                            $articulations->push(SkeletalElement::where('id', $v)->first());
                                            $result->push(SkeletalElement::with('skeletalbone')->where('id', $v)->first());

                                        }
                                    }
                                }
                                $addlist = collect();
                                foreach ($articulations as $articulation) {
                                    $addlist->push($articulation->getArticulationListAttribute());
                                }
                            }
                        }
                    }
                    $results['se'] = $skeletalSelected; //bone selected
                    $results['skeletalelements'] = $result;
                    $this->logInfo("Specimen Chosen:" . $skeletalSelected->id . "Report record count articulations:" . count($results));
                    return (new CoraResourceCollection($results))->additional(["count" => count($results), "criteria" => $request->all(),
                        "criteriaSelection" => $this->criteriaSelections, "request" => $request, "query" => $results]);
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
    public function getProjectIndividualNumberDetails(Request $request, Project $project)
    {
        $this->logInfo(__METHOD__);
        if ($this->authorize('browse', [SkeletalElement::class])) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            if ($project->id !== $this->theProject->id) {
                $this->logInfo(__METHOD__, "Not Authorized to view Project data for " . $project->name);
                return response()->json(["data" => "Not Authorized to view Project data for " . $project->name], 403);
            }
            try {
                if ($request->has('individual_number')) {
                    $query = SkeletalElement::withoutGlobalScope(ProjectScope::class)
                        ->with('skeletalbone')
                        ->where('skeletal_elements.org_id', '=', $this->theOrg->id)
                        ->where('skeletal_elements.project_id', $this->theProject->id);
                    foreach($request['individual_number'] as $individualnumber) {
                        $query->Where('individual_number', 'LIKE', $individualnumber . '%');
                    }
                    $this->criteriaSelections .= " Individual Number:" . json_encode($request['individual_number']);
                } else {
                    $query = SkeletalElement::withoutGlobalScope(ProjectScope::class)
                        ->with('skeletalbone')
                        ->where('skeletal_elements.org_id', '=', $this->theOrg->id)
                        ->where('skeletal_elements.project_id', $this->theProject->id)
                        ->whereNotNull('individual_number')
                        ->whereIn('sb_id', $request['sb_select']);
                    $query = $this->whereSide($request, $query);
                    $this->criteriaSelections .= " Bone:" . json_encode($request['sb_select']);
                }
                $query = $this->whereProjectANP1P2($request, $query, 'skeletal_elements.project_id', 'skeletal_elements.accession_number', 'skeletal_elements.provenance1', 'skeletal_elements.provenance2');
                $results = $request['per_page'] ? $query->paginate($request['per_page']) : $query->paginate($this::$pagination_length_large);
                $skeletalelements = $results->all();
                $skeletalelements = collect($skeletalelements)->map(function($skeletalelement) {
                    $skeletalelement->uniquetraumaslist = $skeletalelement->uniquetraumaslist;
                    $skeletalelement->uniquepathologyslist = $skeletalelement->uniquepathologyslist;
                    $skeletalelement->uniqueanomalyslist = $skeletalelement->uniqueanomalyslist;
                    return $skeletalelement;
                });
                $this->logInfo(__METHOD__, $this->criteriaSelections . " Report record count:" . count($results ));
                return (new CoraResourceCollection($results ))->additional(["count" => count($results ), "criteria" => $request->all(),
                    "criteriaSelection" => $this->criteriaSelections, "request" => $request, "query" => $query]);
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
    public function getOrgIndividualNumberDetails(Request $request, Org $org)
    {
        $this->logInfo(__METHOD__);
        if ($this->authorize('browse', [SkeletalElement::class])) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            if ($org->id !== $this->theOrg->id) {
                $this->logInfo(__METHOD__, "Not Authorized to view Org data for " . $org->acronym);
                return response()->json(["data" => "Not Authorized to view Org data for " . $org->acronym], 403);
            }
            try {
                if ($request->has('individual_number')) {
                    $query = SkeletalElement::withoutGlobalScope(ProjectScope::class)
                        ->with('skeletalbone')
                        ->where('skeletal_elements.org_id', $this->theOrg->id);
                    foreach($request['individual_number'] as $individualnumber) {
                        $query->Where('individual_number', 'LIKE', $individualnumber . '%');
                    }
                    $this->criteriaSelections .= " Individual Number:" . json_encode($request['individual_number']);
                } else {
                    $query = SkeletalElement::withoutGlobalScope(ProjectScope::class)
                        ->with('skeletalbone')
                        ->where('skeletal_elements.org_id', $this->theOrg->id)
                        ->whereNotNull('individual_number')
                        ->whereIn('sb_id', $request['sb_select']);
                    $query = $this->whereSide($request, $query);
                    $this->criteriaSelections .= " Bone:" . json_encode($request['sb_select']);
                }
                $query = $this->whereProjectANP1P2($request, $query, 'skeletal_elements.project_id', 'skeletal_elements.accession_number', 'skeletal_elements.provenance1', 'skeletal_elements.provenance2');
                $results = $request['per_page'] ? $query->paginate($request['per_page']) : $query->paginate($this::$pagination_length_large);
                $skeletalelements = $results->all();
                $skeletalelements = collect($skeletalelements)->map(function($skeletalelement) {
                    $skeletalelement->uniquetraumaslist = $skeletalelement->uniquetraumaslist;
                    $skeletalelement->uniquepathologyslist = $skeletalelement->uniquepathologyslist;
                    $skeletalelement->uniqueanomalyslist = $skeletalelement->uniqueanomalyslist;
                    return $skeletalelement;
                });
                $this->logInfo(__METHOD__, $this->criteriaSelections . " Report record count:" . count($results ));
                return (new CoraResourceCollection($results ))->additional(["count" => count($results ), "criteria" => $request->all(),
                    "criteriaSelection" => $this->criteriaSelections, "request" => $request, "query" => $query]);
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
    public function getProjectIndividualNumbers(Request $request, Project $project)
    {
        $this->logInfo(__METHOD__);
        if ($this->authorize('browse', [SkeletalElement::class])) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            if ($project->id !== $this->theProject->id) {
                $this->logInfo(__METHOD__, "Not Authorized to view Project data for " . $project->name);
                return response()->json(["data" => "Not Authorized to view Project data for " . $project->name], 403);
            }
            try {
                $paginateby = $request['per_page'] ? $request['per_page'] : $this::$pagination_length_large;

                $getInumbers = SkeletalElement::withoutGlobalScope(ProjectScope::class)->where('org_id', '=', $this->theOrg->id)
                ->where('project_id', $this->theProject->id)->where('individual_number', '<>', null);
                $query = $getInumbers->paginate($paginateby);
                $individual_numbers= $query->pluck('individual_number')->unique();
                $skeletal_elements_count = array();
                $skeletal_elements_array_by_INumber = array();
                $mito_sequence_counts_by_INumber = array();
                $mito_sequence_numbers_by_INumber = array();

                foreach ($individual_numbers as $individual_number) {
                    $skeletal_elements_array_by_INumber[$individual_number] = array();
                    $mito_sequence_numbers_by_INumber[$individual_number] = array();
                    $skeletal_elements = SkeletalElement::where('individual_number', $individual_number)->with('dnas')->get();
                    $skeletal_elements_count[$individual_number] = $skeletal_elements->count();
                    foreach ($skeletal_elements as $skeletal_element) {
                        $skeletal_elements_array_by_INumber[$individual_number][] = $skeletal_element;
                        $mito_numbers = $skeletal_element->dnas->pluck('mito_sequence_number')
                            ->unique() != null ? $skeletal_element->dnas
                            ->where('mito_sequence_number', '!=', null)
                            ->pluck('mito_sequence_number')->unique()->all() : array();
                        $mito_sequence_numbers_by_INumber[$individual_number] = array_merge($mito_sequence_numbers_by_INumber[$individual_number], $mito_numbers);
                    }
                    $skeletal_elements_array_by_INumber[$individual_number] = collect($skeletal_elements_array_by_INumber[$individual_number])->sortBy('key');
                    $mito_sequence_numbers_by_INumber[$individual_number] = array_unique($mito_sequence_numbers_by_INumber[$individual_number]);
                    $mito_sequence_counts_by_INumber[$individual_number] = count($mito_sequence_numbers_by_INumber[$individual_number]);
                }
                return (new CoraResourceCollection($query))->additional(["count" => count($query), "se_count" => $skeletal_elements_count,
                    "se_by_inum" => $skeletal_elements_array_by_INumber,"mitoSeq_countBy_inum" =>  $mito_sequence_counts_by_INumber,
                    "mitSeqNum_inum" => $mito_sequence_numbers_by_INumber, "inumbers" => $individual_numbers, "criteria" => $request->all(),
                    "criteriaSelection" => $this->criteriaSelections, "request" => $request, "query" => $query]);
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
    public function getProjectMethod( Request $request, Project $project )
    {
        $this->logInfo(__METHOD__);
        if ($this->authorize('browse', [SkeletalElement::class])) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            if ($project->id !== $this->theProject->id) {
                $this->logInfo(__METHOD__, "Not Authorized to view Project data for " . $project->name);
                return response()->json(["data" => "Not Authorized to view Project data for " . $project->name], 403);
            }
            try {
                $query = SkeletalElement::withoutGlobalScope(ProjectScope::class)
                    ->with('skeletalbone', 'methods', 'methodfeatures')// Load bone data, methods and method features
                    ->join('se_method_feature', 'skeletal_elements.id', '=', 'se_method_feature.se_id')
                    ->where('skeletal_elements.project_id', $this->theProject->id);
                if ($request['method_select'] != "") {
                    $this->criteriaData['method_id'] = $request['method_select'];
                    $query->where('method_id', $request['method_select']);
                    $this->criteriaSelections .= " Method:" . json_encode($request['method_select']);
                }
                if ($request['method_feature_select'] != "") {
                    $this->criteriaData['method_feature_id'] = $request['method_feature_select'];
                    $query->where('method_feature_id', $request['method_feature_select']);
                    $this->criteriaSelections .= " Method Feature:" . json_encode($request['method_feature_select']);
                }
                if ($request['score_select'] != "") {
                    $this->criteriaData['score'] = $request['score_select'];
                    $this->criteriaSelections .= " Score:" . json_encode($request['score_select']);
                    if(is_numeric($request['score_select'])){
                        if ($request['range_select'] != "" and $request['range_select'] != "0") {
                            $this->criteriaData['range'] = $request['range_select'];
                            $this->criteriaSelections .= " Range:" . json_encode($request['range_select']);
                            $score = $this->criteriaData['score'];
                            $range = $this->criteriaData['range'];
                            foreach (range($score - $range, $score + $range) as $array_element) {
                                $range_list[] = $array_element;
                            }
                            $query->whereIn('score', $range_list);
                        } else {
                            $query->where('score', $this->criteriaData['score']);
                        }
                    } else {
                        $query->where('score', $this->criteriaData['score']);
                    }
                }
                $query = $this->whereANP1P2($request, $query);
                $query = $this->whereBone($request, $query);
                $results = $request['per_page'] ? $query->paginate($request['per_page']) : $query->paginate($this::$pagination_length_large);
                return (new CoraResourceCollection($results))->additional(["count" => count($results), "criteria" => $request->all(),
                    "criteriaSelection" => $this->criteriaSelections, "request" => $request, "query" => $query]);
            }catch (QueryException $ex) {
                $this->logQueryException(__METHOD__, $ex);
                return redirect()->back();
            }
        }
    }
    public function getMethodFeatures( Request $request )
    {
        $this->logInfo(__METHOD__);
        $method = $request['method_select'];
        $method = Method::where('id', $method)->first();
        $method_feature = $method->features()->pluck('display_name', 'id')->all();
        $this->logInfo(__METHOD__, "Json count:".count($method_feature));
        return response()->json($method_feature);
    }
    public function getMethodFeatureScores( Request $request )
    {
        $this->logInfo(__METHOD__);
        $method_feature = $request['method_feature_select'];
        $score_list = $this->findScoreArray($method_feature);
        $this->logInfo(__METHOD__, "Json count:".count($score_list));
        return response()->json($score_list);
    }
    public function getMethodFeatureScoreRanges( Request $request )
    {
        $this->logInfo(__METHOD__);
        $method_feature = $request['method_feature_select'];
        $range = $this->findRangeArray($method_feature);
        $this->logInfo(__METHOD__, "Json count:".count($range));
        return response()->json($range);
    }

    public function findScoreArray( $method_feature )
    {
        $this->logInfo(__METHOD__);
        $method_feature = MethodFeature::where('id', $method_feature)->first();
        $score = $method_feature->display_values;
        $char_remove = array("{", "}", "\"", " ");
        $score = str_replace($char_remove, "", $score);
        $score = str_replace(",", ":", $score);
        $score = explode(":", $score);
        $num = 0;
        $score_list = array();
        while ( $num < count($score))
        {
            $score_list[$score[$num]] = $score[$num+1];
            $num +=2;
        }
        return $score_list;
    }
    public function findRangeArray( $method_feature )
    {
        $this->logInfo(__METHOD__);
        $method_feature = MethodFeature::where('id', $method_feature)->first();
        $score = $method_feature->display_values;
        $char_remove = array("{", "}", "\"", " ");
        $score = str_replace($char_remove, "", $score);
        $score = str_replace(",", ":", $score);
        $score = explode(":", $score);
        $range = array();
        if ( is_numeric($score[0])) {
            $range[1] = "+/- 1";
            $range[2] = "+/- 2";
            $range[3] = "+/- 3";
        } else{
            $range[trans('messages.range_unavailable')] = 0;
        }
        return $range;
    }
    /**
     * @param Request $request
     * @param Project $project
     * @return CoraResourceCollection|JsonResponse|\Illuminate\Http\RedirectResponse
     * @throws AuthorizationException
     */
    public function getProjectZones( Request $request, Project  $project)
    {
        $this->logInfo(__METHOD__);
        if ($this->authorize('browse', [SkeletalElement::class])) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            if ($project->id !== $this->theProject->id) {
                $this->logInfo(__METHOD__, "Not Authorized to view Project data for " . $project->name);
                return response()->json(["data" => "Not Authorized to view Project data for " . $project->name], 403);
            }
            try {
                if($request['search_type_select']=="Inclusive"){
                    $query = $this->inclusiveZonesResults($request);
                }
                elseif($request['search_type_select']=="Exclusive"){
                    $query = $this->exclusiveZonesResults($request);
                }
                elseif($request['search_type_select']=="Inclusive Only") {
                    $query = $this->inclusiveOnlyZonesResults($request);
                }
                elseif($request['search_type_select']=="Exclusive Only") {
                    $query = $this->exclusiveOnlyZonesResults($request);
                }
                elseif($request['search_type_select']=="Exclusive Or") {
                    $query = $this->exclusiveOrZonesResults($request);
                }
                elseif($request['search_type_select']=="Not Present") {
                    $query = $this->notPresentZonesResults($request);
                }
                $zones = SkeletalBone::where('id', $request['sb_select'])->first()->zones()->orderBy('display_order')->get();
                $results = $query;
                $this->logInfo(__METHOD__, $this->criteriaSelections . " Report record count:" . count($results));
                return (new CoraResourceCollection($results))->additional(["count"=>count($results), "criteria"=>$request->all(),
                    "criteriaSelection"=>$this->criteriaSelections, "zones"=>$zones, "request"=>$request, "query"=>$query]);
            }  catch (QueryException $ex) {
                $this->logQueryException(__METHOD__, $ex);
                return redirect()->back();
            }
        }
    }

    private function zonesQuerySetup( $request )
    {
        if ($request['sb_select'] != "") {
            $query = SkeletalElement::withoutGlobalScope(ProjectScope::class)
                ->where('sb_id', $request['sb_select'])
                ->where('skeletal_elements.project_id', $this->theProject->id)
                ->join('se_zone', 'skeletal_elements.id', '=', 'se_zone.se_id');
            $this->criteriaSelections .= " Bone Id:" . $request['sb_select'];
        }
        if ($request['side_select'] != "") {
            $query->where('side', $request['side_select']);
            $this->criteriaSelections .= " Side:" . $request['side_select'];
        }
        $query = $this->whereProjectANP1P2($request, $query, 'skeletal_elements.project_id', 'skeletal_elements.accession_number','skeletal_elements.provenance1','skeletal_elements.provenance2');
        return $query;
    }

    private function inclusiveZonesResults( $request )
    {
        $this->logInfo(__METHOD__);
        $query = $this->zonesQuerySetup($request);
        $skeletalelementslist = array();
        if ($request['zone_select'] != "") {
            $zones = $request['zone_select'];
            $numOfZones = count($zones);
            $skeletalelements = $query->whereIn('zone_id', $zones)->where('presence', 'true')->get()->sortBy('id');
            $count = 0;
            $current = $skeletalelements->first();
            foreach ($skeletalelements as $skeletalelement) {
                if ($skeletalelement->id == $current->id) {
                    $count += 1;
                } else {
                    $current = $skeletalelement;
                    $count = 1;
                }
                if ($count == $numOfZones) {
                    $skeletalelementslist[] =  $current->id;
                }
            }
        }
        $skeletalelements = SkeletalElement::whereIn('skeletal_elements.id', $skeletalelementslist)
            ->with('skeletalbone','zones') // Load bone data, zones
            ->get()->unique('id');
        return $skeletalelements;
    }

    private function exclusiveZonesResults( $request )
    {
        $query = $this->zonesQuerySetup($request);
        if ($request['zone_select'] != "") {
            $zones = $request['zone_select'];
            $skeletalelements = $query->whereIn('zone_id', $zones)->where('presence', 'true')
                ->with('skeletalbone','zones');   // Load bone data, zones
        }
        return $skeletalelements->get()->unique('id');
    }

    private function inclusiveOnlyZonesResults( $request )
    {
        $query = $this->zonesQuerySetup($request);
        $query_duplicate = clone $query;
        $query_BonesWithOtherZones = clone $query;
        if ($request['zone_select'] != "") {
            $skeletalelements_list = array();
            $zones = $request['zone_select'];
            $zones_list = SkeletalBone::where('id', $request['sb_select'])->first()->zones()->get();
            $zones = $zones_list->whereNotIn('id', $zones)->pluck('id');
            $query_BonesWithOtherZones = $query_BonesWithOtherZones->whereIn('zone_id', $zones)->where('presence', 'true');
            $query_BonesWithOtherZones = $query_BonesWithOtherZones->pluck('skeletal_elements.id')->all();
            $zones = $request['zone_select'];
            $numOfZones = count($zones);
            $skeletalelements = $query->whereIn('zone_id', $zones)->where('presence', 'true')->get()->sortBy('id');
            $count = 0;
            $current = $skeletalelements->first();
            foreach ($skeletalelements as $skeletalelement) {
                if ($skeletalelement->id == $current->id) {
                    $count += 1;
                } else {
                    $current = $skeletalelement;
                    $count = 1;
                }
                if ($count == $numOfZones) {
                    $skeletalelements_list[] =  $current->id;
                }
            }
        }
        $skeletalelements = $query_duplicate
            ->with('skeletalbone','zones')   // Load bone data, zones
            ->whereIn('skeletal_elements.id', $skeletalelements_list)
            ->whereNotIn('skeletal_elements.id', $query_BonesWithOtherZones)
            ->where('presence', 'true')->get()->unique('id');
        return $skeletalelements;
    }

    private function exclusiveOnlyZonesResults( $request )
    {
        $query = $this->zonesQuerySetup($request);
        $query_BonesWithOtherZones = clone $query;
        if ($request['zone_select'] != "") {
            $zones = $request['zone_select'];
            $zones_list = SkeletalBone::where('id', $request['sb_select'])->first()->zones()->get();
            $zones = $zones_list->whereNotIn('id', $zones)->pluck('id');
            $query_BonesWithOtherZones = $query_BonesWithOtherZones->whereIn('zone_id', $zones)->where('presence', 'true');
            $query_BonesWithOtherZones = $query_BonesWithOtherZones->pluck('skeletal_elements.id')->all();
            $query = $query->whereIn('zone_id', $request['zone_select'])->where('presence', 'true');
            $skeletalelements = $query->whereNotIn('skeletal_elements.id', $query_BonesWithOtherZones)
                ->with('skeletalbone','zones');        // Load bone data, zones
        }
        return $skeletalelements->get()->unique('id');
    }

    private function exclusiveOrZonesResults( $request )
    {
        $query = $this->zonesQuerySetup($request);
        $query_duplicate = clone $query;
        $query_BonesWithOtherZones = clone $query;
        if ($request['zone_select'] != "") {
            $skeletalelements_list = array();
            $zones = $request['zone_select'];
            $zones_list = SkeletalBone::where('id', $request['sb_select'])->first()->zones()->get();
            $zones = $zones_list->whereNotIn('id', $zones)->pluck('id');
            $query_BonesWithOtherZones = $query_BonesWithOtherZones->whereIn('zone_id', $zones)->where('presence', 'true');
            $query_BonesWithOtherZones = $query_BonesWithOtherZones->pluck('skeletal_elements.id')->all();
            $zones = $request['zone_select'];
            $numOfZones = count($zones);
            $skeletalelements = $query->whereIn('zone_id', $zones)->where('presence', 'true')->get()->sortBy('id');
            $count = 0;
            $current = $skeletalelements->first();
            foreach ($skeletalelements as $skeletalelement) {
                if ($skeletalelement->id == $current->id) {
                    $count += 1;
                } else {
                    if ($count != $numOfZones) {
                        $skeletalelements_list[] = $current->id;
                    }
                    $current = $skeletalelement;
                    $count = 1;
                }
            }
        }
        $skeletalelements = $query_duplicate
            ->with('skeletalbone','zones')   // Load bone data, zones
            ->whereIn('skeletal_elements.id', $skeletalelements_list)->whereNotIn('skeletal_elements.id', $query_BonesWithOtherZones)->where('presence', 'true')->get()->unique('id');
        return $skeletalelements;
    }

    private function notPresentZonesResults( $request )
    {
        $zones = $request['zone_select'];
        $zones_list = SkeletalBone::where('id', $request['sb_select'])->first()->zones()->get();
        $zones_not_present = $zones_list->whereNotIn('id', $zones)->pluck('id');
        $request['zone_select'] = $zones_not_present;
        $skeletalelements = $this->exclusiveOnlyZonesResults($request);
        $request['zone_select'] = $zones;
        return $skeletalelements;
    }

    /**
     * @param Request $request
     * @param Project $project
     * @return CoraResourceCollection|JsonResponse|\Illuminate\Http\RedirectResponse
     * @throws AuthorizationException
     */
    public function getProjectPathology( Request $request, Project $project )
    {
        $this->logInfo(__METHOD__);
        if ($this->authorize('browse', [SkeletalElement::class])) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            if ($project->id !== $this->theProject->id) {
                $this->logInfo(__METHOD__, "Not Authorized to view Project data for " . $project->name);
                return response()->json(["data" => "Not Authorized to view Project data for " . $project->name], 403);
            }
            try {
                if ($request->input('pathology_select')){
                    $query = SkeletalElement::withoutGlobalScope(ProjectScope::class)
                        ->with('skeletalbone')
                        ->join('se_pathology', 'skeletal_elements.id', '=', 'se_pathology.se_id')
                        ->where('skeletal_elements.project_id', $this->theProject->id)
                        ->whereIn('pathology_id', $request['pathology_select'] )
                        ->select('skeletal_elements.*', 'se_pathology.zone_id', 'se_pathology.pathology_id');
                    $this->criteriaSelections .= " Traumas:" . json_encode($request['pathology_select']);
                }
                $query = $this->whereProjectANP1P2($request, $query, 'skeletal_elements.project_id', 'skeletal_elements.accession_number','skeletal_elements.provenance1','skeletal_elements.provenance2');
                $query = $this->whereBoneSide($request, $query);
                $queryCollect = collect($query->get()->unique());
                $skeletalelements = $queryCollect->all();
                $pathologies = Pathology::whereIn('id', $request['pathology_select'])->get();
                $pathology_by_zones_list = collect([]);

                collect($skeletalelements)->each(function($skeletalelement) use($pathologies, $pathology_by_zones_list) {
                    $zones_list = [];
                    foreach ($pathologies as $pathology) {
                        $zones_list[$pathology->name] = $skeletalelement->pathologysByZonesList($pathology->id);
                    }
                    $pathology_by_zones_list[$skeletalelement->id] = $zones_list;
                });
                $results = $request['per_page'] ? $query->paginate($request['per_page']): $query->paginate($this::$pagination_length_large);
                $this->logInfo(__METHOD__, $this->criteriaSelections . " Report record count:" . count($results));
                return (new CoraResourceCollection($results))->additional(["count"=>count($results), "criteria"=>$request->all(),
                    "pathologies" => $pathologies, 'pathology_by_zones_list' => $pathology_by_zones_list,"criteriaSelection"=>$this->criteriaSelections, "request"=>$request, "query"=>$query]);

            } catch (QueryException $ex) {
                $this->logQueryException(__METHOD__, $ex);
                return redirect()->back();
            }
        }
    }

    /**
     * @param Request $request
     * @return CoraResourceCollection|\Illuminate\Http\RedirectResponse
     * @throws AuthorizationException
     */
    public function getProjectBoneGroup(Request $request)
    {
        if ($this->authorize('browse', [SkeletalElement::class])) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            try {
                $skeletalelements = SkeletalElement::withoutGlobalScope(ProjectScope::class)
                    ->where('bone_group_id','=', $request['bone_group_id']);
                $results = $request['per_page'] ? $skeletalelements->paginate($request['per_page']): $skeletalelements->paginate($this::$pagination_length_large);
                return (new CoraResourceCollection($results))->additional(["count"=>count($results), "criteria"=>$request->all(),
                    "request"=>$request, "query"=>$skeletalelements]);            } catch (QueryException $ex) {
                $this->logQueryException(__METHOD__, $ex);
                return redirect()->back();
            }
        }
    }

    public function getProjectDental(Request $request, Project $project)
    {
        if ($this->authorize('browse', [SkeletalElement::class])) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            if ($project->id !== $this->theProject->id) {
                $this->logInfo(__METHOD__, "Not Authorized to view Project data for " . $project->name);
                return response()->json(["data" => "Not Authorized to view Project data for " . $project->name], 403);
            }
            try {
                if (DB::table('se_dental_code')->whereIn('dc_id',$request['dc_id'])->whereIn('sb_id',$request['sb_id'])->exists()) {
                    $query = SkeletalElement::withoutGlobalScope(ProjectScope::class)
                        ->with(['dental_codes' => function($query) use ($request) {
                            $query->whereIn('dc_id', $request['dc_id']);
                            $query->orWhereNotNull('dc_id');
                        }])->whereIn('skeletal_elements.sb_id', $request['sb_id']);
                }
                else {
                    return response()->json(["data" => []], 200);
                }
                $query = $this->whereProjectANP1P2($request, $query, $this->theProject->id, 'skeletal_elements.accession_number', 'skeletal_elements.provenance1', 'skeletal_elements.provenance2');
                $results = $request['per_page'] ? $query->paginate($request['per_page']) : $query->paginate($this::$pagination_length_large);
                return (new CoraResourceCollection($results))->additional(["count" => count($results), "criteria" => $request->all(),
                    "request" => $request, "query" => $query]);
            } catch (QueryException $ex) {
                $this->logQueryException(__METHOD__, $ex);
                return redirect()->back();
            }
        }
    }
}

