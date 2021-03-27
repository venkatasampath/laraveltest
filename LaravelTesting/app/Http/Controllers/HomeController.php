<?php

namespace App\Http\Controllers;

/**
 * Home Controller
 *
 * @category   Home
 * @package    CoRA-Controllers
 * @author     Sachin Pawaskar<spawaskar@unomaha.edu>
 * @copyright  2016-2018
 * @license    The MIT License (MIT)
 * @version    GIT: $Id$
 * @since      File available since Release 1.0.0
 */

use Auth;
use Illuminate\Http\Request;
use App\Project;

/**
 * Class HomeController
 * @package App\Http\Controllers
 */
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function home(Request $request)
    {
        if (Auth::check())
        {
            $this->logInfo(__METHOD__);
            return view('welcome', $this->viewData);
        }
    }

    /**
     * Show the application dashboard for the current user based on their user role.
     * Depending on role the following dashboard will be displayed.
     * OrgAdmin/Admin -> OrgAdmin Dashboard with Google maps, Specimen/DNA Summaries for all projects.
     * Project Manager -> Project Dashboard with Specimen, DNA, MNI and counts for current project.
     * Anthropologist/User -> User Dashboard with current project stats and user activity info.
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        if (Auth::check())
        {
            $user_projects_count = $this->theUser->projects->count();
            $this->viewData['heading'] = trans('labels.role_dashboard', ['role'=>trans('labels.'.$this->theUser->role->name)]);
            if ($user_projects_count == 0) {
                $request->session()->flash('alert_message', trans('messages.no_projects'));
                $this->logInfo(__METHOD__, "Role:". $this->theUser->role->name ." OrgProjects:". count($this->theOrg->projects) ." AssignedProjects:".$user_projects_count);
                return view('home', $this->viewData);
            } else {
                if ($this->theUser->isOrgAdmin() || $this->theUser->isAdmin()){
                    $this->logInfo(__METHOD__, "Role:OrgAdmin OrgProjects:". count($this->theOrg->projects) ." AssignedProjects:".$user_projects_count);
                    $this->viewData['heading'] = trans('labels.role_dashboard', ['role'=>$this->theOrg->acronym." ".trans('labels.administrator')]);
                    return view('dashboard.org_admin', $this->viewData);
                }
                if($this->theUser->isManager() || $this->theUser->isProjectManager($this->theProject))
                {
                    $this->logInfo(__METHOD__, "Role:Manager/ProjectManager OrgProjects:". count($this->theOrg->projects) ." AssignedProjects:".$user_projects_count);
                    $this->viewData['heading'] = trans('labels.role_dashboard', ['role'=>'Project Manager']);
                    return view('dashboard.manager', $this->viewData);
                }
                else {
                    $this->logInfo(__METHOD__, "Role:". $this->theUser->role->name ." OrgProjects:". count($this->theOrg->projects) ." AssignedProjects:".$user_projects_count);
                    return view('dashboard.user', $this->viewData);
                }
            }
        }
    }

    /**
     * Show the project dashboard for the $project
     *
     * @param Project $project
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showProjectDashboard(Project $project)
    {
        $this->logInfo(__METHOD__, "Start ".$project->id.":".$project->name);
        if ($this->theProject->id != $project->id)
        {
            $this->logInfo(__METHOD__, "Switch Project ".$project->id.":".$project->name);
            $this->theUser->switchProject($this->theProject, $project);
            $this->viewData['theProject'] = $this->theUser->getCurrentProject();
        }
        $this->viewData['heading'] = trans('labels.role_dashboard', ['role'=>$project->name." ".trans('labels.project')]);
        return view('dashboard.manager', $this->viewData);
    }

    /**
     *  Show the Specimen inventory drilldown view based on inventory filters
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function inventory_filter(Request $request)
    {
        $this->logInfo(__METHOD__, "Start");
        $currentProject = $this->theProject;
        $queryResults = $currentProject->skeletalelements()->leftJoin('skeletal_bones', 'sb_id', '=', 'skeletal_bones.id')->select('*', 'skeletal_bones.name as sb_name')->whereBetween('skeletal_bones.updated_at', array($request['startDate'], $request['endDate']))->get();
        $currentProject->skeletalelements()->
            leftJoin('skeletal_bones', 'sb_id', '=', 'skeletal_bones.id')->
            leftJoin('users', 'user_id', '=', 'users.id')->
            leftJoin('users as reviewers', 'reviewer_id', '=', 'users.id')->
            select('*', 'skeletal_bones.name as sb_name', 'users.name as user_name', 'reviewers.name as reviewer_name')->
            whereBetween('skeletal_bones.updated_at', array($request['startDate'], $request['endDate']))->get();

        $this->viewData['queryResults'] = $queryResults;
        $this->viewData['currentProject'] = $currentProject;
        $this->logInfo(__METHOD__, "End");
        return view('dashboard.drilldowns.inventory', $this->viewData);
    }

    /**
     * Show the Specimen inventory drilldown view
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function inventory_drill()
    {
        $this->logInfo(__METHOD__, "Start");
        $currentProject = $this->theProject;
        $queryResults = $currentProject->skeletalelements()->
                        leftJoin('skeletal_bones', 'sb_id', '=', 'skeletal_bones.id')->
                        leftJoin('users', 'user_id', '=', 'users.id')->
                        leftJoin('users as reviewers', 'reviewer_id', '=', 'users.id')->
                        select('*', 'skeletal_bones.name as sb_name', 'users.name as user_name', 'reviewers.name as reviewer_name')->get();

        $this->viewData['queryResults'] = $queryResults;
        $this->viewData['currentProject'] = $currentProject;
        $this->logInfo(__METHOD__, "End");
        return view( 'dashboard.drilldowns.inventory', $this->viewData);

    }

    /**
     * Show the appropriate dashboard/component drilldowns
     * depending on the drilldown selected chart
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function drilldown($type)
    {
        switch ($type) {
            case 'complete':
                $this->logInfo(__METHOD__, "Complete");
                $this->viewData['heading'] = trans('labels.complete');
                $this->viewData['chartType'] = 'complete';
                return view('dashboard.drilldowns.complete', $this->viewData);
                break;
            case 'individual_assigned':
                $this->logInfo(__METHOD__, "SpecimensAssociated");
                $this->viewData['heading'] = trans('labels.individuals_associated');
                $this->viewData['chartType'] = 'individual_assigned';
                return view('dashboard.drilldowns.skeletal_elements_associated', $this->viewData);
                break;
            case 'dna_sampled':
                $this->logInfo(__METHOD__, "DnaSampled");
                $this->viewData['heading'] = trans('labels.dna_sampled');
                $this->viewData['chartType'] = 'dna_sampled';
                return view('dashboard.drilldowns.dna_sampled', $this->viewData);
                break;
            case 'mito_sequence_number':
                $this->logInfo(__METHOD__, "MitoSequences");
                $this->viewData['heading'] = trans('labels.mito_sequences');
                $this->viewData['chartType'] = 'mito_sequence_number';
                return view('dashboard.drilldowns.mito_sequences', $this->viewData);
                break;
            case 'mni_bones':
                $this->logInfo(__METHOD__, "MNIBones");
                $this->viewData['heading'] = trans('labels.mni_bones');
                $this->viewData['chartType'] = 'mni_bones';
                return view('dashboard.drilldowns.mni_bones', $this->viewData);
                break;
            case 'mni_zones':
                $this->logInfo(__METHOD__, "MNIZones");
                $this->viewData['heading'] = trans('labels.mni_zones');
                $this->viewData['chartType'] = 'mni_zones';
                return view('dashboard.drilldowns.mni_zones', $this->viewData);
                break;
//            case 7:
//                $this->logInfo(__METHOD__, "SpecimensInventoried");
//                $this->viewData['heading'] = trans('labels.specimens_inventoried');
//                return $this->inventory_drill();
//                break;
            case 'measured':
                $this->logInfo(__METHOD__, "Measured");
                $this->viewData['heading'] = trans('labels.measured');
                $this->viewData['chartType'] = 'measured';
                return view('dashboard.drilldowns.measured', $this->viewData);
                break;
            case 'ct_scanned':
                $this->logInfo(__METHOD__, "CTScanned");
                $this->viewData['heading'] = trans('labels.ct_scanned');
                $this->viewData['chartType'] = 'ct_scanned';
                return view('dashboard.drilldowns.ct_scanned', $this->viewData);
                break;
            case 'xray_scanned':
                $this->logInfo(__METHOD__, "XrayScanned");
                $this->viewData['heading'] = trans('labels.xray_scanned');
                $this->viewData['chartType'] = 'xray_scanned';
                return view('dashboard.drilldowns.xray_scanned', $this->viewData);
                break;
            case 'clavicle_triage':
                $this->logInfo(__METHOD__, "ClavileTriaged");
                $this->viewData['heading'] = trans('labels.clavicle_triage');
                $this->viewData['chartType'] = 'clavicle_triage';
                return view('dashboard.drilldowns.clavicle_triaged', $this->viewData);
                break;
            case 'isotope_sampled':
                $this->logInfo(__METHOD__, "IsotopeSampled");
                $this->viewData['heading'] = trans('labels.isotope_sampled');
                $this->viewData['chartType'] = 'isotope_sampled';
                return view('dashboard.drilldowns.isotope_sampled', $this->viewData);
                break;
            case 'mni_bones_side':
                $this->logInfo(__METHOD__, "MNIBonesSide");
                $this->viewData['heading'] = trans('labels.mni_bones_side');
                $this->viewData['chartType'] = 'mni_bones_side';
                return view('dashboard.drilldowns.mni_bones_side', $this->viewData);
                break;
            case 'mni_zones_side':
                $this->logInfo(__METHOD__, "MNIZonesSide");
                $this->viewData['heading'] = trans('labels.mni_zones_side');
                $this->viewData['chartType'] = 'mni_zones_side';
                return view('dashboard.drilldowns.mni_zones_side', $this->viewData);
                break;
            case 'mni_mito_bones_side':
                $this->logInfo(__METHOD__, "MNIMitoBonesSide");
                $this->viewData['heading'] = trans('labels.mito_bones_side');
                $this->viewData['chartType'] = 'mni_mito_bones_side';
                return view('dashboard.drilldowns.mito_bones_side', $this->viewData);
                break;
            case 'dna_mito_results':
                $this->logInfo(__METHOD__, "MitoDNA");
                $this->viewData['heading'] = trans('labels.mito');
                return view('dashboard.drilldowns.mito_dna', $this->viewData);
                break;
            case 'dna_austr_results':
                $this->logInfo(__METHOD__, "AustrDNA");
                $this->viewData['heading'] = trans('labels.auto');
                return view('dashboard.drilldowns.austr_dna', $this->viewData);
                break;
            case 'dna_ystr_results':
                $this->logInfo(__METHOD__, "YstrDNA");
                $this->viewData['heading'] = trans('labels.y');
                return view('dashboard.drilldowns.ystr_dna', $this->viewData);
            case 'ua_specimens':
                $this->logInfo(__METHOD__, "UserActivity-Specimens");
                $this->viewData['heading'] = trans('labels.user_activity_feed_skel');
                return view('dashboard.drilldowns.ua_specimens', $this->viewData);
            case 'ua_dnas':
                $this->logInfo(__METHOD__, "UserActivity-DNAs");
                $this->viewData['heading'] = trans('labels.user_activity_feed_DNA');
                return view('dashboard.drilldowns.ua_dnas', $this->viewData);
            break;
            default:
                $this->logInfo(__METHOD__, "Unknown Drilldown - Should never get here");
                break;
        }
    }

    /**
     * Show the system EULA.
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function eula(Request $request)
    {
        $this->logInfo(__METHOD__, "Start");
        if (Auth::check())
        {
            return view('eula', $this->viewData);
        }
    }

    /**
     * Show the system About.
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function about(Request $request)
    {
        $this->logInfo(__METHOD__, "Start ".$request->getRequestUri());
        if (Auth::check())
        {
            $aboutbrowser = ($request->query->has('aboutbrowser')) ? true : false;
            $welcome = ($request->query->has('welcome')) ? true : false;
            $about = ($aboutbrowser || $welcome) ? false : true;
            $this->viewData['about'] = $about;
            $this->viewData['aboutbrowser'] = $aboutbrowser;
            $this->viewData['welcome'] = $welcome;
            $this->viewData['heading'] = trans('labels.about');
            return view('about.main', $this->viewData);
        }
    }
}
