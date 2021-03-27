<?php

/**
 * Cora Api AnalyticsController
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
use App\Taphonomy;
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
 * Class AnalyticsController
 * @package App\Http\Controllers\Api
 */
class AnalyticsController extends Controller
{
    protected $today;
    /**
     * @var array
     */
    protected $criteriaData = [];
    /**
     * @var string
     */
    protected $criteriaSelections = "";

    public function getSpecimen(Request $request, SkeletalElement $specimen, $degree)
    {
        $this->logInfo(__METHOD__, "Key: ".$specimen->key_bone_side . " Degree: ".$degree);
        if ($this->authorize('browse', [SkeletalElement::class])) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            if ($specimen->project->id !== $this->theProject->id) {
                $this->logInfo(__METHOD__, "Not Authorized to view Project data for ". $this->theProject->name);
                return response()->json([ "data" => "Not Authorized to view Project data for ". $this->theProject->name ], 403);
            }

            // $this->logInfo(__METHOD__, "Request". json_encode($request->all()));
            try {
                $nodes = array();
                $links = array();
                $indexedNodes = array();
                $this->buildNodesAndLinks($specimen, "dna", $nodes, $links, $indexedNodes);
                $this->buildNodesAndLinks($specimen, "pairs", $nodes, $links, $indexedNodes);
                $this->buildNodesAndLinks($specimen, "articulations", $nodes, $links, $indexedNodes);
                $this->buildNodesAndLinks($specimen, "refits", $nodes, $links, $indexedNodes);
                return response()->json([ "data" => [ "nodes"=>$nodes, "links"=>$links, "count_nodes"=>count($nodes), "count_links"=>count($links), "specimen"=>$specimen ] ], 200);
            } catch (QueryException $ex) {
                $this->logQueryException(__METHOD__, $ex);
                return redirect()->back();
            }
        }
    }

    public function buildNodesAndLinks($specimen, $relationship, &$nodes, &$links, &$indexedNodes)
    {
        if ($relationship == "dna") {
            $objects = $this->getSpecimensRelatedByMitoSequenceNumber($specimen);
            $this->logInfo(__METHOD__, "obj: ". json_encode($objects));
        } else if ($relationship == "pairs") {
            $objects = $specimen->pairs()->get();
            $this->logInfo(__METHOD__, "obj: ". json_encode($objects));
        } else if ($relationship == "articulations") {
            $objects = $specimen->articulations()->get();
            $this->logInfo(__METHOD__, "obj: ". json_encode($objects));
        } else if ($relationship == "refits") {
            $objects = $specimen->refits()->get();
            $this->logInfo(__METHOD__, "obj: ". json_encode($objects));
        }

        // Add the specimen to nodes list if not already in list
        if (!isset($indexedNodes[$specimen->id])) {
            $group = $specimen->accession_number.":".$specimen->provenance1.":".$specimen->provenance2;
            $nodes[] = json_decode(json_encode(["id"=>$specimen->id, "key"=>$specimen->key, "key_bone_side"=>$specimen->key_bone_side, "group"=>$group]));
        }

        foreach ($objects as $obj) {
            // Add the specimen to nodes list if not already in list
            if (!isset($indexedNodes[$obj->id])) {
                $group = $obj->accession_number.":".$obj->provenance1.":".$obj->provenance2;
                $key = ($obj->key) ?? $group . $obj->designator;
                $key_bone_side = ($obj->key_bone_side) ?? $key . " :: " . $obj->name.":".$obj->side;
                $nodes[] = json_decode(json_encode(["id"=>$obj->id, "key"=>$key, "key_bone_side"=>$key_bone_side, "group"=>$group]));
            }

            if ($relationship == "dna") {
                $links[] = json_decode(json_encode(["source"=>$specimen->id, "target"=>$obj->id, "relation"=>"dna-mito", "mito_sequence_number"=>$obj->mito_sequence_number, "value"=>10]));
            } else if ($relationship == "pairs") {
                $p_value = rand(1, 9);
                $links[] = json_decode(json_encode(["source"=>$specimen->id, "target"=>$obj->id, "relation"=>"pairs", "p_value"=>"0.33", "value"=>$p_value]));
            } else if ($relationship == "articulations") {
                $p_value = rand(1, 9);
                $links[] = json_decode(json_encode(["source"=>$specimen->id, "target"=>$obj->id, "relation"=>"articulations", "p_value"=>"0.33", "value"=>$p_value]));
            } else if ($relationship == "refits") {
                $p_value = rand(1, 9);
                $links[] = json_decode(json_encode(["source"=>$specimen->id, "target"=>$obj->id, "relation"=>"refits", "p_value"=>"0.33", "value"=>$p_value]));
            }
        }

        // prepare indexed nodes
        foreach ($nodes as $node) {
            $indexedNodes[$node->id] = $node;
        }
    }

    public function getSpecimensForAnP1P2(Request $request)
    {
        $this->logInfo(__METHOD__);
        if ($this->authorize('browse', [SkeletalElement::class])) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
//            if ($specimen->project->id !== $this->theProject->id) {
//                $this->logInfo(__METHOD__, "Not Authorized to view Project data for ". $this->theProject->name);
//                return response()->json([ "data" => "Not Authorized to view Project data for ". $this->theProject->name ], 403);
//            }

//            $query = SkeletalElement::withoutGlobalScope(ProjectScope::class)
//                ->select('dnas.*', 'skeletal_bones.*', 'skeletal_elements.*')
//                ->where('skeletal_elements.org_id', '=', $this->theOrg->id)
//                ->where('skeletal_elements.project_id', $this->theProject->id)
//                ->join('skeletal_bones', 'skeletal_bones.id', '=', 'skeletal_elements.sb_id')
//                ->leftJoin('dnas', 'skeletal_elements.id', '=', 'dnas.se_id');
            $query = SkeletalElement::withoutGlobalScope(ProjectScope::class)
                ->where('skeletal_elements.org_id', '=', $this->theOrg->id)
                ->where('skeletal_elements.project_id', $this->theProject->id);
            $query = $this->whereANP1P2($request, $query,'skeletal_elements.accession_number','skeletal_elements.provenance1','skeletal_elements.provenance2');
            $specimens = $query->get();

            try {
                $nodes = array();
                $links = array();
                $indexedNodes = array();
                foreach ($specimens as $specimen) {
                    // $this->buildNodesAndLinks($specimen, "dna", $nodes, $links, $indexedNodes);
                    $this->buildNodesAndLinks($specimen, "pairs", $nodes, $links, $indexedNodes);
                    $this->buildNodesAndLinks($specimen, "articulations", $nodes, $links, $indexedNodes);
                    $this->buildNodesAndLinks($specimen, "refits", $nodes, $links, $indexedNodes);
                }
                return response()->json([ "data" => [ "nodes"=>$nodes, "links"=>$links, "count_nodes"=>count($nodes), "count_links"=>count($links), "specimens"=>count($specimens) ] ], 200);
            } catch (QueryException $ex) {
                $this->logQueryException(__METHOD__, $ex);
                return redirect()->back();
            }
        }
    }

    public function getSpecimensRelatedByMitoSequenceNumber(SkeletalElement $specimen)
    {
        $this->logInfo(__METHOD__);
        if ($this->authorize('browse', [SkeletalElement::class])) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            try {
                $dnas = $specimen->dnas()->get();
                $mito = null;
                foreach ($dnas as $dna) {
                    if (isset($dna->mito_sequence_number)) {
                        $mito = $dna->mito_sequence_number;
                    }
                }

                if (isset($mito)) {
                    $query = Dna::withoutGlobalScope(ProjectScope::class)
                        ->select('dnas.*', 'skeletal_bones.*', 'skeletal_elements.*')
                        ->where('dnas.org_id', '=', $this->theOrg->id)
                        ->where('dnas.project_id', $this->theProject->id)
                        ->where('dnas.mito_sequence_number', $mito)
                        ->join('skeletal_elements', 'skeletal_elements.id', '=', 'dnas.se_id')
                        ->join('skeletal_bones', 'skeletal_bones.id', '=', 'skeletal_elements.sb_id');
                    return $specimens = $query->get();
                } else {
                    return collect();
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

    public function getTaphonomy(Request $request)
    {
        $this->logInfo(__METHOD__);
        if ($this->authorize('browse', [SkeletalElement::class])) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            $query = DB::table('se_taphonomy')
                ->select('se_id', 'taphonomy_id', 'se_taphonomy.org_id', 'se_taphonomy.project_id',
                    'taphonomys.branch', 'taphonomys.category', 'taphonomys.type','taphonomys.subtype', 'taphonomys.icon', 'taphonomys.color',
                    'se.accession_number', 'se.provenance1','se.provenance2','se.designator','se.sb_id', 'se.side', 'sb.name')
                ->where('se_taphonomy.org_id', '=', $this->theOrg->id)
                ->where('se_taphonomy.project_id', $this->theProject->id)
                ->join('skeletal_elements as se', 'se.id', '=', 'se_taphonomy.se_id')
                ->join('skeletal_bones as sb', 'sb.id', '=', 'se.sb_id')
                ->join('taphonomys', 'taphonomys.id', '=', 'se_taphonomy.taphonomy_id');
            $query = $this->whereANP1P2($request, $query,'se.accession_number','se.provenance1','se.provenance2');
            $list = $query->get();

            $this->logInfo(__METHOD__, $this->criteriaSelections . " Report record count:" . count($list));

            try {
                $nodes = array();
                $links = array();
                $indexedNodes = array();
                foreach ($list as $obj) {
                    $group = $obj->accession_number.":".$obj->provenance1.":".$obj->provenance2;
                    $tapgroup = $obj->category.":".$obj->type.":".$obj->subtype;
                    $key = ($obj->key) ?? $obj->accession_number.":".$obj->provenance1.":".$obj->provenance2.":".$obj->designator;
                    $key_bone_side = ($obj->key_bone_side) ?? $key . " :: " . $obj->name.":".$obj->side;
                    $nodes[] = json_decode(json_encode(["id"=>$obj->se_id, "type"=>"specimen", "key"=>$key, "key_bone_side"=>$key_bone_side, "group"=>$group]));
                    $links[] = json_decode(json_encode(["source"=>$obj->taphonomy_id, "target"=>$obj->se_id, "relation"=>"taphonomy::".$tapgroup, "taphonomy"=>$tapgroup, "value"=>10]));
                    // Add the Taphonomy as a node itself if not already present.
                    if (!isset($indexedNodes[$obj->taphonomy_id])) {
                        $nodes[] = json_decode(json_encode(["id"=>$obj->taphonomy_id, "type"=>"taphonomy", "key"=>$tapgroup, "key_bone_side"=>$tapgroup, "group"=>$tapgroup]));
                    }
                    $indexedNodes[$obj->taphonomy_id] = $obj->taphonomy_id;
                }
                return response()->json([ "data" => [ "nodes"=>$nodes, "links"=>$links, "count_nodes"=>count($nodes), "count_links"=>count($links), "count_specimens"=>count($list) ] ], 200);
            } catch (QueryException $ex) {
                $this->logQueryException(__METHOD__, $ex);
                return redirect()->back();
            }
        }
    }

    public function getPairs(Request $request)
    {
        $this->logInfo(__METHOD__);
        if ($this->authorize('browse', [SkeletalElement::class])) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            $query = SkeletalElement::with(['pairs','sb'])
                ->where('org_id', '=', $this->theOrg->id)->where('project_id', $this->theProject->id)
                ->where('sb_id', '=', $request["bone"]);
//            $query = $this->whereANP1P2($request, $query,'se.accession_number','se.provenance1','se.provenance2');
//            $query = $this->whereBoneSide($request, $query,'se.sb_id','se.side');
            $list = $query->get();
            $this->logInfo(__METHOD__, $this->criteriaSelections . " Report record count:" . count($list));
//            return response()->json([ "data" => [ "list"=>$list, "count_pairs"=>count($list) ] ], 200);

            try {
                $nodes = array();
                $links = array();
                $indexedNodes = array();
                foreach ($list as $obj) {
                    $group = $obj->accession_number.":".$obj->provenance1.":".$obj->provenance2;
                    $key = ($obj->key) ?? $obj->accession_number.":".$obj->provenance1.":".$obj->provenance2.":".$obj->designator;
                    $key_bone_side = ($obj->key_bone_side) ?? $key . " :: " . $obj->name.":".$obj->side;
                    $add_node_se_id = false;
                    $add_node_pair_id = false;
//                    $this->logInfo(__METHOD__, "obj: " . json_encode($obj));

                    if (!isset($indexedNodes[$obj->id])) {
                        $nodes[] = json_decode(json_encode(["id"=>$obj->id, "type"=>"specimen", "key"=>$key, "key_bone_side"=>$key_bone_side, "group"=>$group]));
                        $add_node_se_id = true;
                    }
                    foreach ($obj->pairs as $pair) {
                        if (!isset($indexedNodes[$pair->id])) {
                            $nodes[] = json_decode(json_encode(["id"=>$pair->id, "type"=>"specimen", "key"=>$pair->key, "key_bone_side"=>$pair->key_bone_side, "group"=>$pair->key]));
                            $add_node_pair_id = true;
                        }
                        // Add link, in either one of the se_id or pair_id was added, otherwise both were already present
                        // and hence link would already be there.
                        $links[] = json_decode(json_encode(["source"=>$obj->id, "target"=>$pair->id, "relation"=>"pair::".$obj->pvalue, "value"=>($obj->pvalue) ? $obj->pvalue * 10 : 15]));
                    }
                }
                return response()->json([ "data" => [ "nodes"=>$nodes, "links"=>$links, "count_nodes"=>count($nodes), "count_links"=>count($links), "count_pairs"=>count($list) ] ], 200);
            } catch (QueryException $ex) {
                $this->logQueryException(__METHOD__, $ex);
                return redirect()->back();
            }
        }
    }
}
