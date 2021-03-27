<?php

/**
 * Cora Api DashboardController
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
use App\Http\Resources\CoraResourceCollection;
use App\Org;
use App\Project;
use App\Dna;
use App\SkeletalBone;
use App\SkeletalElement;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

/**
 * Class DashboardController
 * @package App\Http\Controllers\Api
 */
class DashboardController extends Controller
{
    /**
     * @var array
     */
    public static $allowed_mni_by = ["all", "bones", "bones_and_side", "zones", "bones_side_zones", "mito_bones_and_side"];

    /**
     * @var array
     */
    public static $allowed_activity_by = ["all", "specimen", "dna", "isotope"];

    protected $criteriaData = [];
    /**
     * @var string
     */
    protected $criteriaSelections = "";

    /**
     * Display project highlights.
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function getOrgHighlights(Request $request, Org $org)
    {
        $this->logInfo(__METHOD__);
        if ($this->authorize('browse', [ SkeletalElement::class ])) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            $projects = $org->projects()->count();
            $users = $org->users()->count();
            $specimens = $org->skeletalelements()->withoutGlobalScopes()->count();
            $dnas = $org->dnas()->withoutGlobalScopes()->count();
            $isotopes = $org->isotopes()->withoutGlobalScopes()->count();
            $instruments = $org->instruments()->count();
            return response()->json([
                "data" => ["projects"=>$projects, "users"=>$users, "specimens"=>$specimens, "dnas"=>$dnas,
                    "isotopes"=>$isotopes, "instruments"=>$instruments],
                "last_updated_at"=>now()
            ], 200);
        } else {
            return response()->json([
                "data" => "Not Authorized to view Dashboard"
            ], 403);
        }
    }

    /**
     * Display project highlights.
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function getProjectHighlights(Request $request, Project $project)
    {
        $this->logInfo(__METHOD__);
        if ($this->authorize('browse', [ SkeletalElement::class ])) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            $specimens = SkeletalElement::all()->count();
            $accessions = $project->accessions()->distinct('number')->count();
            $provenance1 = $project->provenance1()->distinct('provenance1')->count();
            $provenance2 = $project->provenance2()->distinct('provenance2')->count();
            $bone_groups = SkeletalElement::whereNotNull('bone_group_id')->distinct('bone_group_id')->count();
            $individual_number = SkeletalElement::whereNotNull('individual_number')->distinct('individual_number')->count();
            return response()->json([
                "data" => ["specimens"=>$specimens, "accessions"=>$accessions, "provenance1"=>$provenance1, "provenance2"=>$provenance2,
                    "bone_groups"=>$bone_groups, "individual_number"=>$individual_number],
                "last_updated_at"=>now()
            ], 200);
        } else {
            return response()->json([
                "data" => "Not Authorized to view Dashboard"
            ], 403);
        }
    }

    /**
     * Display project highlights.
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function getProjectSummary(Request $request, Project $project)
    {
        $this->logInfo(__METHOD__);

        if ($this->authorize('browse', [ SkeletalElement::class ])) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            try {
                $latest = false;
                if ($request->has('latest')) {
                    $latest = $request->query('latest');
                }

                $list = null;
                if ($latest) {
                    $list = $project->latest_summary_record();
                    return response()->json([ "data" => $list, "project" => $project,
                        "status"=>"success", 'message'=>"Project activity get successful"], 200);
                } else {
                    $top = ($request->has('top')) ? $request->query('top') : 0;
                    $latest = $project->latest_summary_record();
                    $list = $project->summary_records($top)->get();
                    return response()->json([ "data" => ["latest"=>$latest, "records" => $list, "count" => count($list), "project" => $project,],
                        "status"=>"success", 'message'=>"Project activity get successful"], 200);
                }

            } catch (QueryException $ex) {
                $this->logQueryException(__METHOD__, $request, $ex);
                return response()->json([ 'data' => trans('messages.model_view_unsuccessful', ['model'=>'Project MNI']) ], 422);
            }
        } else {
            return response()->json([ "data" => "Not Authorized to view Dashboard"], 403);
        }
    }

    /**
     * Display all projects summary for this user.
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function getAllProjectSummary(Request $request)
    {
        $this->logInfo(__METHOD__);

        if ($this->authorize('browse', [ SkeletalElement::class ])) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            try {
                if ($request->has('by')) {
                    $by = $request->query('by');
                    $this->logInfo(__METHOD__, "By: ".$by);
                } else {
                    return response()->json([ "data" => "Bad request: missing request parameters"], 400);
                }

                $list = $projectlist = $specimenlist = $dnalist = null;
                switch ($by) {
                    case "all":
                        $projectlist = $this->theUser->getProjectDetailsArray();
                        $specimenlist = $this->theUser->getProjectSummaryArraySE();
                        $dnalist = $this->theUser->getProjectSummaryArrayDNA();
                        break;
                    case "project":
                        $list = $projectlist = $this->theUser->getProjectDetailsArray();
                        break;
                    case "specimen":
                        $list = $specimenlist = $this->theUser->getProjectSummaryArraySE();
                        break;
                    case "dna":
                        $list = $dnalist = $this->theUser->getProjectSummaryArrayDNA();
                        break;
                    case "isotope":
                        // do this when we have the isotopes dones.
                        break;
                    default: // should never get here.
                        return response()->json([ "data" => "Bad request: missing request parameters"], 400);
                }

                return response()->json([ "data" => [ "projects" => $projectlist, "specimens" => $specimenlist, "dnas" => $dnalist, "by" => $by, "projects-count" => $this->theUser->projects->count() ],
                    "org" => $this->theOrg, "status"=>"success", 'message'=>"Project activity get successful"], 200);
            } catch (QueryException $ex) {
                $this->logQueryException(__METHOD__, $request, $ex);
                return response()->json([ 'data' => trans('messages.model_view_unsuccessful', ['model'=>'Project MNI']) ], 422);
            }
        } else {
            return response()->json([ "data" => "Not Authorized to view Dashboard"], 403);
        }
    }

    /**
     * Display all counts or details of specimen data fields such.
     * "Complete",
     *
     * @param Request $request
     * @return CoraResourceCollection|\Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function getSpecimensAll(Request $request)
    {
        $this->logInfo(__METHOD__);
        if ($this->authorize('browse', [ SkeletalElement::class ])) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            $data = [];
            // Complete
            $total = SkeletalElement::all()->count();
            $complete = SkeletalElement::where('completeness', "=", "Complete")->count();
            $individual_assigned = SkeletalElement::whereNotNull('individual_number')->count();
            $measured = SkeletalElement::where('measured', true)->count();
            $ct_scanned = SkeletalElement::where('ct_scanned', true)->count();
            $xray_scanned = SkeletalElement::where('xray_scanned', true)->count();
            $scanned_3d = SkeletalElement::where('3D_scanned', true)->count();
            $dna_sampled = SkeletalElement::where('dna_sampled', true)->count();
            $isotope_sampled = SkeletalElement::where('isotope_sampled', true)->count();
            // clavicle_triage
            $clavicle_id = SkeletalBone::where('name', 'Clavicle')->first()->id;
            $clavicle_triage_total = SkeletalElement::where('sb_id', $clavicle_id)->count();
            $clavicle_triage = SkeletalElement::where('clavicle_triage', true)->count();

            return response()->json([ "data" => [ "total" => $total, "complete" => $complete, "incomplete" => ($total - $complete),
                "individual_assigned" => $individual_assigned, "individual_unassigned" => ($total - $individual_assigned),
                "measured" => $measured, "unmeasured" => ($total - $measured),
                "ct_scanned" => $ct_scanned, "not_ct_scanned" => ($total - $ct_scanned),
                "xray_scanned" => $xray_scanned, "not_xray_scanned" => ($total - $xray_scanned),
                "3D_scanned" => $scanned_3d, "not_3D_scanned" => ($total - $scanned_3d),
                "dna_sampled" => $dna_sampled, "not_dna_sampled" => ($total - $dna_sampled),
                "isotope_sampled" => $isotope_sampled, "not_isotope_sampled" => ($total - $isotope_sampled),
                "clavicle_triage" => $clavicle_triage, "not_clavicle_triage" => ($clavicle_triage_total - $clavicle_triage),
            ], "last_updated_at"=>now() ], 200);
        } else {
            return response()->json([
                "data" => "Not Authorized to view Dashboard"
            ], 403);
        }
    }

    /**
     * Display counts or details of specimens that have completeness as "Complete".
     *
     * @param Request $request
     * @return CoraResourceCollection|\Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function getSpecimensComplete(Request $request)
    {
        $this->logInfo(__METHOD__);
        if ($this->authorize('browse', [ SkeletalElement::class ])) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            if ($request->has('details')) {
                $this->logInfo(__METHOD__,"details:".$request->query('details'));
                $list = SkeletalElement::where('completeness', "=", "Complete")->paginate($this::$pagination_length_large);
                return new CoraResourceCollection($list);
            } else {
                $total = SkeletalElement::all()->count();
                $complete = SkeletalElement::where('completeness', "=", "Complete")->count();
                return response()->json([ "data" => ["complete" => $complete, "incomplete" => ($total - $complete), "total" => $total], "last_updated_at"=>now() ], 200);
            }
        } else {
            return response()->json([
                "data" => "Not Authorized to view Dashboard"
            ], 403);
        }
    }

    /**
     * Display counts or details of specimens that have an individual number.
     *
     * @param Request $request
     * @return CoraResourceCollection|\Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function getSpecimensIndividual(Request $request)
    {
        $this->logInfo(__METHOD__);
        if ($this->authorize('browse', [ SkeletalElement::class ])) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            if ($request->has('details')) {
                $this->logInfo(__METHOD__,"details:".$request->query('details'));
                $list = SkeletalElement::whereNotNull('individual_number')->paginate($this::$pagination_length_large);
                return new CoraResourceCollection($list);
            } else {
                $total = SkeletalElement::all()->count();
                $individual_assigned = SkeletalElement::whereNotNull('individual_number')->count();
                return response()->json([ "data" => ["individual_assigned" => $individual_assigned, "individual_unassigned" => ($total - $individual_assigned), "total" => $total], "last_updated_at"=>now() ], 200);
            }
        } else {
            return response()->json([
                "data" => "Not Authorized to view Dashboard"
            ], 403);
        }
    }

    /**
     * Display counts or details of specimens that have been measured.
     *
     * @param Request $request
     * @return CoraResourceCollection|\Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function getSpecimensMeasured(Request $request)
    {
        $this->logInfo(__METHOD__);
        if ($this->authorize('browse', [ SkeletalElement::class ])) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            if ($request->has('details')) {
                $this->logInfo(__METHOD__,"details:".$request->query('details'));
                $list = SkeletalElement::where('measured', true)->paginate($this::$pagination_length_large);
                return new CoraResourceCollection($list);
            } else {
                $total = SkeletalElement::all()->count();
                $measured = SkeletalElement::where('measured', true)->count();
                return response()->json([ "data" => ["measured" => $measured, "unmeasured" => ($total - $measured), "total" => $total], "last_updated_at"=>now() ], 200);
            }
        } else {
            return response()->json([
                "data" => "Not Authorized to view Dashboard"
            ], 403);
        }
    }

    /**
     * Display counts or details of specimens that have been CT scanned.
     *
     * @param Request $request
     * @return CoraResourceCollection|\Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function getSpecimensCTScanned(Request $request)
    {
        $this->logInfo(__METHOD__);
        if ($this->authorize('browse', [ SkeletalElement::class ])) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            if ($request->has('details')) {
                $this->logInfo(__METHOD__,"details:".$request->query('details'));
                $list = SkeletalElement::where('ct_scanned', true)->paginate($this::$pagination_length_large);
                return new CoraResourceCollection($list);
            } else {
                $total = SkeletalElement::all()->count();
                $scanned = SkeletalElement::where('ct_scanned', true)->count();
                return response()->json([ "data" => ["ct_scanned" => $scanned, "not_ct_scanned" => ($total - $scanned), "total" => $total], "last_updated_at" => now() ], 200);
            }
        } else {
            return response()->json([
                "data" => "Not Authorized to view Dashboard"
            ], 403);
        }
    }

    /**
     * Display counts or details of specimens that have been Xray scanned.
     *
     * @param Request $request
     * @return CoraResourceCollection|\Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function getSpecimensXrayScanned(Request $request)
    {
        $this->logInfo(__METHOD__);
        if ($this->authorize('browse', [ SkeletalElement::class ])) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            if ($request->has('details')) {
                $this->logInfo(__METHOD__,"details:".$request->query('details'));
                $list = SkeletalElement::where('xray_scanned', true)->paginate($this::$pagination_length_large);
                return new CoraResourceCollection($list);
            } else {
                $total = SkeletalElement::all()->count();
                $scanned = SkeletalElement::where('xray_scanned', true)->count();
                return response()->json([ "data" => ["xray_scanned" => $scanned, "not_xray_scanned" => ($total - $scanned), "total" => $total], "last_updated_at"=>now() ], 200);
            }
        } else {
            return response()->json([
                "data" => "Not Authorized to view Dashboard"
            ], 403);
        }
    }

    /**
     * Display counts or details of specimens that have been 3D scanned.
     *
     * @param Request $request
     * @return CoraResourceCollection|\Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function getSpecimens3DScanned(Request $request)
    {
        $this->logInfo(__METHOD__);
        if ($this->authorize('browse', [ SkeletalElement::class ])) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            if ($request->has('details')) {
                $this->logInfo(__METHOD__,"details:".$request->query('details'));
                $list = SkeletalElement::where('3D_scanned', true)->paginate($this::$pagination_length_large);
                return new CoraResourceCollection($list);
            } else {
                $total = SkeletalElement::all()->count();
                $scanned = SkeletalElement::where('3D_scanned', true)->count();
                return response()->json([ "data" => ["3D_scanned" => $scanned, "not_3D_scanned" => ($total - $scanned), "total" => $total], "last_updated_at"=>now() ], 200);
            }
        } else {
            return response()->json([
                "data" => "Not Authorized to view Dashboard"
            ], 403);
        }
    }

    /**
     * Display counts or details of specimens that are Clavicle for which Clavicle triage has been done.
     *
     * @param Request $request
     * @return CoraResourceCollection|\Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function getSpecimensClavicleTriage(Request $request)
    {
        $this->logInfo(__METHOD__);
        if ($this->authorize('browse', [ SkeletalElement::class ])) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            if ($request->has('details')) {
                $this->logInfo(__METHOD__,"details:".$request->query('details'));
                $clavicle_id = SkeletalBone::where('name', 'Clavicle')->first()->id;
                $list = SkeletalElement::where('sb_id', $clavicle_id)->paginate($this::$pagination_length_large);
                return new CoraResourceCollection($list);
            } else {
                $clavicle_id = SkeletalBone::where('name', 'Clavicle')->first()->id;
                $total = SkeletalElement::where('sb_id', $clavicle_id)->count();
                $clavicle_triage = SkeletalElement::where('clavicle_triage', true)->count();
                return response()->json([ "data" => ["clavicle_triage" => $clavicle_triage, "not_clavicle_triage" => ($total - $clavicle_triage), "total" => $total], "last_updated_at"=>now() ], 200);
            }
        } else {
            return response()->json([
                "data" => "Not Authorized to view Dashboard"
            ], 403);
        }
    }

    /**
     * Display counts or details of specimens that have been DNA sampled.
     *
     * @param Request $request
     * @return CoraResourceCollection|\Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function getSpecimensDnaSampled(Request $request)
    {
        $this->logInfo(__METHOD__);
        if ($this->authorize('browse', [ SkeletalElement::class ])) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            if ($request->has('details')) {
                $this->logInfo(__METHOD__,"details:".$request->query('details'));
                $list = SkeletalElement::where('dna_sampled', true)->paginate($this::$pagination_length_large);
                return new CoraResourceCollection($list);
            } else {
                $total = SkeletalElement::all()->count();
                $sampled = SkeletalElement::where('dna_sampled', true)->count();
                return response()->json([ "data" => ["dna_sampled" => $sampled, "not_dna_sampled" => ($total - $sampled), "total" => $total], "last_updated_at"=>now() ], 200);
            }
        } else {
            return response()->json([
                "data" => "Not Authorized to view Dashboard"
            ], 403);
        }
    }

    /**
     * Display counts or details of specimens that have been Isotope sampled.
     *
     * @param Request $request
     * @return CoraResourceCollection|\Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function getSpecimensIsotopeSampled(Request $request)
    {
        $this->logInfo(__METHOD__);
        if ($this->authorize('browse', [ SkeletalElement::class ])) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            if ($request->has('details')) {
                $this->logInfo(__METHOD__,"details:".$request->query('details'));
                $list = SkeletalElement::where('isotope_sampled', true)->paginate($this::$pagination_length_large);
                return new CoraResourceCollection($list);
            } else {
                $total = SkeletalElement::all()->count();
                $sampled = SkeletalElement::where('isotope_sampled', true)->count();
                return response()->json([ "data" => ["isotope_sampled" => $sampled, "not_isotope_sampled" => ($total - $sampled), "total" => $total], "last_updated_at"=>now() ], 200);
            }
        } else {
            return response()->json([
                "data" => "Not Authorized to view Dashboard"
            ], 403);
        }
    }

    /**
     * Display MNI for a project.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Resources\Json\AnonymousResourceCollection
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function getMni(Request $request)
    {
        $this->logInfo(__METHOD__);
        if ($this->authorize('browse', [ SkeletalElement::class ])) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            try {
                if ($request->has('by')) {
                    $by = $request->query('by');
                    $by = (!isset($by)) ? "" : strtolower($by);
                    if (! in_array($by, $this::$allowed_mni_by)) {
                        return response()->json([ "data" => "Bad request: unsupported mni by"], 400);
                    }
                } else {
                    return response()->json([ "data" => "Bad request: missing request parameters"], 400);
                }

                $top = ($request->has('top')) ? $request->query('top') : 0;

                $list = $list_mni_by_bones = $list_mni_by_bones_and_side = $list_mni_by_zones = null;
                $list_mni_by_bones_side_zones = $list_mni_by_mito_bones_and_side = $list_mito_sequences = null;
                $project = $this->theProject;
                switch ($by) {
                    case "all":
                        $list_mni_by_bones = $project->mni_by_bones($top);
                        $list_mni_by_bones_and_side = $project->mni_by_bones_and_side($top);
                        $list_mni_by_zones = $project->mni_by_zones($top);
                        $list_mni_by_bones_side_zones = $project->mni_by_bones_side_zones($top);
                        $list_mni_by_mito_bones_and_side = $project->mni_by_mito_bones_and_side($top);
                        $list_mito_sequences = $project->mito_sequences($top);
                        break;
                    case "bones":
                        $list = $list_mni_by_bones = $project->mni_by_bones($top);
                        break;
                    case "bones_and_side":
                        $list = $list_mni_by_bones_and_side = $project->mni_by_bones_and_side($top);
                        break;
                    case "zones":
                        $list = $list_mni_by_zones = $project->mni_by_zones($top);
                        break;
                    case "bones_side_zones":
                        $list = $list_mni_by_bones_side_zones = $project->mni_by_bones_side_zones($top);
                        break;
                    case "mito_bones_and_side":
                        $list = $list_mni_by_mito_bones_and_side = $project->mni_by_mito_bones_and_side($top);
                        $list_mito_sequences = $project->mito_sequences($top);
                        break;
                    default: // should never get here.
                        return response()->json([ "data" => "Bad request: missing request parameters"], 400);
                }

                if ($by === "all") {
                    return response()->json([ "data" => [ "by" => $by, "mni_by_bones" => $list_mni_by_bones, "mni_by_bones_and_side" => $list_mni_by_bones_and_side,  "mni_by_zones" => $list_mni_by_zones,
                        "mni_by_bones_side_zones" => $list_mni_by_bones_side_zones, "mni_by_mito_bones_and_side" => $list_mni_by_mito_bones_and_side, 'mito_sequences'=>$list_mito_sequences, ],
                        "project" => $project, "status"=>"success", 'message'=>"Project all MNI get successful"], 200);
                } else {
                    return response()->json([ "data" => $list, 'mito_sequences'=>$list_mito_sequences, "count" => count($list), "project" => $project, "status"=>"success", 'message'=>"Project MNI get successful"], 200);
                }
            } catch (QueryException $ex) {
                $this->logQueryException(__METHOD__, $request, $ex);
                return response()->json([ 'data' => trans('messages.model_view_unsuccessful', ['model'=>'Project MNI']) ], 422);
            }
        } else {
            return response()->json([ "data" => "Not Authorized to view Dashboard" ], 403);
        }
    }

    /**
     * Display Activity for a project.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Resources\Json\AnonymousResourceCollection
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function getActivity(Request $request)
    {
        $this->logInfo(__METHOD__);
        if ($this->authorize('browse', [ SkeletalElement::class ])) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            try {
                if ($request->has('by')) {
                    $by = $request->query('by');
                    $by = (!isset($by)) ? "" : strtolower($by);
                    if (! in_array($by, $this::$allowed_activity_by)) {
                        return response()->json([ "data" => "Bad request: unsupported activity by"], 400);
                    }
                } else {
                    return response()->json([ "data" => "Bad request: missing request parameters"], 400);
                }

                $top = ($request->has('top')) ? $request->query('top') : 0;
                $forUser = false;
                if ($request->has('forUser')) {
                    $forUser = ($request->query('forUser') === "true") ? true : false;
                }

                $list = $list_specimens = $list_dnas = null;
                $user = $this->theUser;
                $project = $this->theProject;
                switch ($by) {
                    case "all":
                        $list_specimens = ($forUser) ? $project->se_activities_by_user($user, $top) : $project->se_activities($top);
                        $list_dnas = ($forUser) ? $project->dna_activities_by_user($user, $top) : $project->dna_activities($top);
                        break;
                    case "specimen":
                        $list = $list_specimens = ($forUser) ? $project->se_activities_by_user($user, $top) : $project->se_activities($top);
                        break;
                    case "dna":
                        $list = $list_dnas = ($forUser) ? $project->dna_activities_by_user($user, $top) : $project->dna_activities($top);
                        break;
                    case "isotope":
                        // do this when we have the isotopes dones.
                        break;
                    default: // should never get here.
                        return response()->json([ "data" => "Bad request: missing request parameters"], 400);
                }

                if ($by === "all") {
                    return response()->json([ "data" => [ "specimens" => $list_specimens, "dnas" => $list_dnas, "by" => $by, ],
                        "project" => $project, "status"=>"success", 'message'=>"Project all MNI get successful"], 200);
                } else {
                    return response()->json([ "data" => $list, "count" => count($list), "project" => $project, "status"=>"success", 'message'=>"Project activity get successful"], 200);
                }
            } catch (QueryException $ex) {
                $this->logQueryException(__METHOD__, $request, $ex);
                return response()->json([ 'data' => trans('messages.model_view_unsuccessful', ['model'=>'Project MNI']) ], 422);
            }
        } else {
            return response()->json([ "data" => "Not Authorized to view Dashboard" ], 403);
        }
    }

    /**
     * Display counts or details of dnas with Mito results.
     *
     * @param Request $request
     * @return CoraResourceCollection|\Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function getDnaMitoResults(Request $request)
    {
        $this->logInfo(__METHOD__);
        if ($this->authorize('browse', [ Dna::class ])) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            if ($request->has('details')) {
                $this->logInfo(__METHOD__,"details:".$request->query('details'));
                $list = Dna::whereNotNull('mito_results_confidence')->paginate($this::$pagination_length_large);
                return new CoraResourceCollection($list);
            } else {
                $total = Dna::all()->count();
                $mito_results_total = Dna::whereNotNull('mito_results_confidence')->count();
                $mito_results_reportable = Dna::where('mito_results_confidence', "=", "Reportable")->count();
                $mito_results_inconclusive = Dna::where('mito_results_confidence', "=", "Inconclusive")->count();
                $mito_results_unable_to_assign = Dna::where('mito_results_confidence', "=", "Unable to Assign")->count();
                $mito_results_cancelled = Dna::where('mito_results_confidence', "=", "Cancelled")->count();
                $mito_results_pending = Dna::where('mito_results_confidence', "=", "Pending")->count();
                $mito_no_results = Dna::where('mito_results_confidence', '=', 'No Results')->count();
                return response()->json([
                    "data" => ["mito_results_reportable" => $mito_results_reportable, "mito_results_inconclusive" => $mito_results_inconclusive,
                        "mito_results_unable_to_assign" => $mito_results_unable_to_assign, "mito_results_cancelled" => $mito_results_cancelled,
                        "mito_no_results" => $mito_no_results, "mito_results_pending" => $mito_results_pending,
                        "mito_results_total" => $mito_results_total, "total" => $total],
                    "last_updated_at"=>now()
                ], 200);
            }
        } else {
            return response()->json([ "data" => "Not Authorized to view Dashboard" ], 403);
        }
    }

    /**
     * Display counts or details of dnas with Austr results.
     *
     * @param Request $request
     * @return CoraResourceCollection|\Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function getDnaAustrResults(Request $request)
    {
        $this->logInfo(__METHOD__);
        if ($this->authorize('browse', [ Dna::class ])) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            if ($request->has('details')) {
                $this->logInfo(__METHOD__,"details:".$request->query('details'));
                $list = Dna::whereNotNull('austr_results_confidence')->paginate($this::$pagination_length_large);
                return new CoraResourceCollection($list);
            } else {
                $total = Dna::all()->count();
                $austr_results_total = Dna::whereNotNull('austr_results_confidence')->count();
                $austr_results_reportable = Dna::where('austr_results_confidence', "=", "Reportable")->count();
                $austr_results_inconclusive = Dna::where('austr_results_confidence', "=", "Inconclusive")->count();
                $austr_results_unable_to_assign = Dna::where('austr_results_confidence', "=", "Unable to Assign")->count();
                $austr_results_cancelled = Dna::where('austr_results_confidence', "=", "Cancelled")->count();
                $austr_results_pending = Dna::where('austr_results_confidence', "=", "Pending")->count();
                $austr_no_results = Dna::where('austr_results_confidence', '=', 'No Results')->count();

                return response()->json([
                    "data" => ["austr_results_reportable" => $austr_results_reportable, "austr_results_inconclusive" => $austr_results_inconclusive,
                        "austr_results_unable_to_assign" => $austr_results_unable_to_assign, "austr_results_cancelled" => $austr_results_cancelled,
                        "austr_no_results" => $austr_no_results, "austr_results_pending" => $austr_results_pending,
                        "austr_results_total" => $austr_results_total, "total" => $total],
                    "last_updated_at"=>now()
                ], 200);
            }
        } else {
            return response()->json([ "data" => "Not Authorized to view Dashboard" ], 403);
        }
    }

    /**
     * Display counts or details of dnas with Ystr results.
     *
     * @param Request $request
     * @return CoraResourceCollection|\Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function getDnaYstrResults(Request $request)
    {
        $this->logInfo(__METHOD__);
        if ($this->authorize('browse', [ Dna::class ])) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            if ($request->has('details')) {
                $this->logInfo(__METHOD__,"details:".$request->query('details'));
                $list = Dna::whereNotNull('ystr_results_confidence')->paginate($this::$pagination_length_large);
                return new CoraResourceCollection($list);
            } else {
                $total = Dna::all()->count();
                $ystr_results_total = Dna::whereNotNull('ystr_results_confidence')->count();
                $ystr_results_reportable = Dna::where('ystr_results_confidence', "=", "Reportable")->count();
                $ystr_results_inconclusive = Dna::where('ystr_results_confidence', "=", "Inconclusive")->count();
                $ystr_results_unable_to_assign = Dna::where('ystr_results_confidence', "=", "Unable to Assign")->count();
                $ystr_results_cancelled = Dna::where('ystr_results_confidence', "=", "Cancelled")->count();
                $ystr_results_pending = Dna::where('ystr_results_confidence', "=", "Pending")->count();
                $ystr_no_results = Dna::where('ystr_results_confidence', '=', 'No Results')->count();

                return response()->json([
                    "data" => ["ystr_results_reportable" => $ystr_results_reportable, "ystr_results_inconclusive" => $ystr_results_inconclusive,
                        "ystr_results_unable_to_assign" => $ystr_results_unable_to_assign, "ystr_results_cancelled" => $ystr_results_cancelled,
                        "ystr_no_results" => $ystr_no_results, "ystr_results_pending" => $ystr_results_pending, "ystr_results_total" => $ystr_results_total,
                        "total" => $total],
                    "last_updated_at"=>now()
                ], 200);
            }
        } else {
            return response()->json([ "data" => "Not Authorized to view Dashboard" ], 403);
        }
    }

    /**
     * Display DNA Mito Sequences for a project.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Resources\Json\AnonymousResourceCollection
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function getMitoSequence(Request $request)
    {
        $this->logInfo(__METHOD__);
        if ($this->authorize('browse', [ SkeletalElement::class ])) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            try {
                $top = 0;
                if ($request->has('top')) {
                    $top = $request->query('top');
                }

                $list = null;
                $project = $this->theProject;
                $list = $project->mito_sequences($top);

                return response()->json([ "data" => $list, "count" => count($list), "project" => $project,
                    "status"=>"success", 'message'=>"Project DNA Mito sequence get successful"], 200);
            } catch (QueryException $ex) {
                $this->logQueryException(__METHOD__, $request, $ex);
                return response()->json([ 'data' => trans('messages.model_view_unsuccessful', ['model'=>'Project MNI']) ], 422);
            }
        } else {
            return response()->json([ "data" => "Not Authorized to view Dashboard" ], 403);
        }
    }

    /**
     * @param Request $request
     * @param Project $project
     * @return CoraResourceCollection|\Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function getDrilldownDetails(Request $request, Project $project)
    {
        $this->logInfo(__METHOD__);
        if ($this->authorize('browse', [SkeletalElement::class])||$this->authorize('browse', [Dna::class]) ) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            if ($project->id !== $this->theProject->id) {
                $this->logInfo(__METHOD__, "Not Authorized to view Project data for " . $project->name);
                return response()->json(["data" => "Not Authorized to view Project data for " . $project->name], 403);
            }
            try {
                $type = $request['type'];
                $filter = $request['filter'];
                if ($type != null) {
                    if ($type === "specimen") {
                        $query = SkeletalElement::where('project_id', $project->id)
                            ->with(['skeletalbone','dnas','tags'])->withCount(['pairs', 'articulations', 'refits', 'morphologys', 'methods', 'pathologys', 'traumas','anomalys']);
                        switch ($filter) {
                            case "complete":
                                $query->where('completeness', "=", "Complete");
                                break;
                            case "individual_assigned":
                                $query->whereNotNull('individual_number');
                                break;
                            case "dna_sampled":
                                $query->where('dna_sampled', true);
                                break;
                            case "measured":
                                $query->where('measured', true);
                                break;
                            case "ct_scanned":
                                $query->where('ct_scanned', true);
                                break;
                            case "xray_scanned":
                                $query->where('xray_scanned', true);
                                break;
                            case "clavicle_triage":
                                $query->where('clavicle_triage', true);
                                break;
                            case "isotope_sampled":
                                $query->where('isotope_sampled', true);
                                break;
                            default:
                                $this->logInfo(__METHOD__, "Unknown Drilldown - Should never get here");
                                break;
                        }
                    } elseif($type === "dna"){
                        $query = $project->dnas();
                        switch ($filter) {
                            case "dna_mito_results":
                                $query->whereNotNull('mito_results_confidence')->with('skeletalelement');
                                break;
                            case "dna_ystr_results":
                                $query->whereNotNull('ystr_results_confidence')->with('skeletalelement');
                                break;
                            case "dna_austr_results":
                                $query->whereNotNull('austr_results_confidence')->with('skeletalelement');
                                break;
                            default:
                                $this->logInfo(__METHOD__, "Unknown Drilldown - Should never get here");
                                break;
                        }
                    }else{
                        $this->logInfo(__METHOD__, "Unknown Drilldown - Should never get here");
                    }
            }
                $results = $request['per_page'] ? $query->paginate($request['per_page']): $query->paginate($this::$pagination_length_large);
                $this->logInfo(__METHOD__, $this->criteriaSelections . " Report record count:" . count($results));
                return (new CoraResourceCollection($results))->additional(["count"=>count($results), "criteria"=>$request->all(),
                    "request"=>$request, "query"=>$query]);
            }catch (QueryException $ex) {
                $this->logQueryException(__METHOD__, $ex);
                return redirect()->back();
            }
        }

    }
}
