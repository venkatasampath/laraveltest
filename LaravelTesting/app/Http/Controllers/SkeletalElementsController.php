<?php

/**
 * SkeletalElements Controller
 *
 * @category   SkeletalElements
 * @package    CoRA-Controllers
 * @author     Sachin Pawaskar<spawaskar@unomaha.edu>
 * @copyright  2016-2018
 * @license    The MIT License (MIT)
 * @version    GIT: $Id$
 * @since      File available since Release 1.0.0
 */

namespace App\Http\Controllers;

use App\Accession;
use App\Anomaly;
use App\BoneGroup;
use App\Dna;
use App\DnaAnalysisType;
use App\Haplogroup;
use App\Http\Requests\SkeletalElementRequest;
use App\Jobs\SpecimenGroupCreation;
use App\Lab;
use App\Measurement;
use App\Method;
use App\Notifications\SpecimenReviewed;
use App\Pathology;
use App\SkeletalBone;
use App\SkeletalElement;
use App\SkeletalElementReview;
use App\Tag;
use App\Taphonomy;
use App\Trauma;
use App\User;
use App\Zone;
use Auth;
use Carbon\Carbon;
use DB;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Log;
use Notification;
use Session;

class SkeletalElementsController extends Controller
{
    protected $currentSearchBy = "";
    protected $currentSearchByName = "";
    protected $currentSearchString = "";
    protected $allowedSearch = ['SB'=>'Bone', 'AN'=>'Accession Number', 'P1'=>'Provenance1', 'P2'=>'Provenance2', 'DN'=>'Designator',
        'CK'=>'Composite Key', 'IN'=>'Individual Number', 'EN'=>'External Number'];

    public function __construct()
    {
        parent::__construct();

        $this->initialize();
    }

    protected function initialize()
    {
        $this->viewData['list_sb'] = $this->list_sb = SkeletalBone::orderBy('name', 'asc')->pluck('name', 'id');
        $this->viewData['list_side'] = $this->list_side = SkeletalElement::$side;
        $this->viewData['list_completeness'] = $this->list_completeness = SkeletalElement::$completeness;
        $this->viewData['list_remains_status'] = $this->list_remains_status = SkeletalElement::$remains_status;
        $this->viewData['list_lab'] = $this->list_lab = Lab::all()->pluck('name', 'id');
        $this->viewData['list_confidence'] = $this->list_confidence = Dna::$results_confidence;
        $this->viewData['list_method'] = $this->list_method = Dna::$method;
        $this->viewData['list_test'] = $this->list_test = DnaAnalysisType::orderby('display_name')->pluck('display_name', 'id');
        $this->viewData['list_tag'] = $this->list_tag = Tag::ofType('Specimen')->pluck('name', 'id');
        $this->viewData['list_accession'] = $this->list_accession = null;
        $this->viewData['list_provenance1'] = $this->list_provenance1 = null;
        $this->viewData['list_provenance2'] = $this->list_provenance2 = null;
        $this->viewData['list_consolidated'] = $this->list_consolidated = null;
        $this->viewData['initialshow'] = $this->initialshow = false;
    }

    public function index()
    {
        $this->logInfo(__METHOD__);
        if($this->authorize('browse', [ SkeletalElement::class ])) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            $skeletalelements = SkeletalElement::with('skeletalbone')->get();
            $this->setViewDataCommonFields(trans('labels.skeletal_elements'), false);
            $this->viewData['skeletalelements'] = $skeletalelements;

            return view('skeletalelements.index', $this->viewData);
        }
    }

    public function show(SkeletalElement $skeletalelement)
    {
        $object = $skeletalelement;
        $this->logInfo(__METHOD__, $object->id.":".$object->key);
        if ($this->authorize( 'read',  [SkeletalElement::class, $object])) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            $this->setViewDataCommonFields(trans('labels.view_skeletal_element', ['name' => $object->name]),true, $object);
            $this->viewData['isAdminOrOrgAdmin'] = $this->isAdminOrOrgAdmin();

//            Auth::user()->addProfileJsonValue('mru_list_skeletalelements', $object);
            return view('skeletalelements.show', $this->viewData);
        }
    }

    public function create()
    {
        $this->logInfo(__METHOD__);
        if ($this->authorize('add', [SkeletalElement::class])) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            $this->setViewDataCommonFields(trans('labels.new_skeletal_element'));

            return view('skeletalelements.create', $this->viewData);
        }
    }

    public function store(SkeletalElementRequest $request)
    {
        $this->logInfo(__METHOD__, "Start");
        $input = $request->all();
//        dd(["Hi there", $input, $request]);
        $this->populateCreateFieldsWithUserAndOrgID($input);
        $this->populateBooleanFields($input, $request);
        if ($this->authorize('add', [SkeletalElement::class])) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            try {
                if($this->checkUniqueANP1P2DN($request) == false) {
                    Session::flash('alert_message', trans('messages.model_add_unsuccessful', ['model'=>'Specimen'])." ".trans('messages.error_duplicate_composite_key'));
                    return redirect()->back();
                }
                $input['project_id'] = $this->theProject->id;
                if((Accession::where('number',$request['accession_number'])->where('provenance1', $input['provenance1'])->where('provenance2', $input['provenance2'])->first()) == null) {
                    $input['org_id'] = $this->theOrg->id;
                    $input['project_id'] = $this->theProject->id;
                    $input['consolidated_an'] = false;
                    $input['number'] = $input['accession_number'];
                    $this->populateCreateFields($input);
                    Accession::create($input);
                }
                $object = SkeletalElement::create($input);
                $this->associateZonesOnSEUpdate($object, $request);
            } catch (QueryException $ex) {
                $this->logQueryException(__METHOD__, $request, $ex);
                Session::flash('alert_message', trans('messages.model_add_unsuccessful', ['model'=>'Specimen']));
                return redirect()->back();
            }
        }

        Session::flash('flash_message', trans('messages.model_add_successful', ['model'=>'Specimen']));
        $this->logInfo(__METHOD__, "End: ".$object->id.":".$object->key);

        switch($this->theUser->getProfileValue('se_new_redirect_url') == 'Measurements'){
            case 'Measurements':
                return $this->editMeasurements($object);
                break;
            case 'Zones':
                return $this->editZones($object);
                break;
            case 'Taphonomy':
                return $this->edittaphonomys($object);
                break;
            case 'Pathology':
                return $this->pathologys($object);
                break;
            case 'Trauma':
                return $this->traumas($object);
                break;
            case 'Anomaly':
                return $this->editAnomalys($object);
                break;
            case 'None':
            default:
                return $this->show($object);
        }
    }

    public function edit(SkeletalElement $skeletalelement)
    {
        $object = $skeletalelement;
        $this->logInfo(__METHOD__, $object->id.":".$object->key);
        if ( $this->authorize('edit', [SkeletalElement::class, $object])) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            $this->setViewDataCommonFields(trans('labels.edit_skeletal_element', ['name' => $object->key]), true, $object);
            $this->viewData['isAdminOrOrgAdmin'] = $this->isAdminOrOrgAdmin();

//            Auth::user()->addProfileJsonValue('mru_list_skeletalelements', $object);
            return view('skeletalelements.edit', $this->viewData);
        }
    }

    public function update(SkeletalElement $skeletalelement, SkeletalElementRequest $request)
    {
        $object = $skeletalelement;
        $this->logInfo(__METHOD__, "Start ".$object->id.":".$object->key);
        if ($this->authorize('edit', [SkeletalElement::class, $object])) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            try {
                if($this->checkUniqueANP1P2DN($request, $skeletalelement) == false) {
                    Session::flash('alert_message', trans('messages.model_update_unsuccessful', ['model'=>'Specimen'])." ".trans('messages.error_duplicate_composite_key'));
                    return redirect()->back();
                }
                $input = $request->all();
                $input['project_id'] = $this->theProject->id;
                if((Accession::where('number',$request['accession_number'])->where('provenance1', $request['provenance1'])->where('provenance2', $request['provenance2'])->first()) == null) {
                    $input['org_id'] = $this->theOrg->id;
                    $input['project_id'] = $this->theProject->id;
                    $input['consolidated_an'] = false;
                    $input['number'] = $input['accession_number'];
                    $this->populateCreateFields($input);
                    Accession::create($input);
                }
                $this->populateUpdateFields($input);
                $this->populateBooleanFields($input, $request);
                $this->populateDateFields($input, $object);
                $previous_value_completeness = $object->completeness;
                $notify_reviewed = ($input['reviewed'] === true && $object->getOriginal('reviewed') === false) ? true:false;
                $object->reviewer_id = $this->theUser->id;
                $object->update($input);

                if ($notify_reviewed){
                    $creator = User::where('id', $object->user_id)->first();
                    $reviewer = $object->reviewer;
                    $projectmanager = $object->project->manager;
                    $notify_users = collect([$creator, $reviewer, $projectmanager])->unique();
                    $notification_params = ['specimen_id'=>$object->id, 'creator_id'=>$creator->id, 'reviewer_id'=>$reviewer->id];
                    Notification::send($notify_users, new SpecimenReviewed($this->theUser->id, $notification_params));
                }

                // ToDo: check why isDirty is not working
                if($previous_value_completeness !== $input['completeness']) {
                    $this->associateZonesOnSEUpdate($object, $request);
                }
            } catch (QueryException $ex) {
                $this->logQueryException(__METHOD__, $request, $ex);
                Session::flash('alert_message', trans('messages.model_update_unsuccessful', ['model'=>'Specimen']));
                return redirect()->back();
            }
        }
        $this->logInfo(__METHOD__, "End: ".$object->id.":".$object->key);
        Session::flash('flash_message', trans('messages.model_update_successful', ['model'=>'Specimen']));
        return $this->show($object);
    }

    /**
     * @param Request $request
     * @param SkeletalElement $skeletalelement
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(Request $request, SkeletalElement $skeletalelement)
    {
        $object = $skeletalelement;
        $this->logInfo(__METHOD__, "Start ".$object->id.":".$object->key);
        if ($this->authorize('delete', [SkeletalElement::class, $object])) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            try {
                $object->delete();
            } catch (QueryException $ex) {
                $this->logQueryException(__METHOD__, $request, $ex);
                Session::flash('alert_message', trans('messages.model_delete_unsuccessful', ['model'=>'Specimen']));
                return redirect()->back();
            }
        }
        Session::flash('flash_message', trans('messages.model_delete_successful', ['model'=>'Specimen']));
        $this->logInfo(__METHOD__, "End");
        return redirect('/');
    }

    public function checkUniqueANP1P2DN($request, $specimen = null) {
        $flag = true;
        $an = $request['accession_number'];
        $p1 = $request['provenance1'];
        $p2 = $request['provenance2'];
        $de = $request['designator'];
        if (!isset($specimen)) { // on insert/store
            try {
                $se = SkeletalElement::firstOrNew(['accession_number'=>$an, 'provenance1'=>$p1, 'provenance2'=>$p2, 'designator'=>$de]);
                if ($se->exists) {
                    $this->logInfo(__METHOD__, "Duplicate: ". $an."-".$p1."-".$p2."-".$de);
                    $flag = false;
                }
            } catch (QueryException $ex) {
                $this->logQueryException(__METHOD__, $request, $ex);
                return $flag;
            }
        } else { // update
            try {
                // Has any part of the key changed
                if ($an != $specimen->accession_number || $p1 != $specimen->provenance1 || $p2 != $specimen->provenance2 || $de != $specimen->designator) {
                    $se = SkeletalElement::firstOrNew(['accession_number'=>$an, 'provenance1'=>$p1, 'provenance2'=>$p2, 'designator'=>$de]);
                    if ($se->exists) {
                        $this->logInfo(__METHOD__, "Duplicate: ". $an."-".$p1."-".$p2."-".$de);
                        $flag = false;
                    }
                }
            } catch (QueryException $ex) {
                $this->logQueryException(__METHOD__, $request, $ex);
                return $flag;
            }
        }
        return $flag;
    }

    public function createByGroup()
    {
        $this->logInfo(__METHOD__);
        if ($this->authorize('add', [SkeletalElement::class])) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            $this->setViewDataCommonFields(trans('labels.new_bone_group'));
            $this->setViewDataByBoneGroup();
            $this->viewData['bone_group_filter'] = '';
            return view('skeletalelements.create_by_grouping', $this->viewData);
        }
    }

    private function setViewDataByBoneGroup(Request $request = null)
    {
        $this->viewData['list_grouping'] = BoneGroup::orderBy('group_name')->pluck('group_name', 'group_name')->unique();
        $this->viewData['list_trauma'] = Trauma::all()->pluck('name', 'id');
        $this->viewData['list_pathology'] = Pathology::all()->pluck('name', 'id');
        $this->viewData['list_taphonomy'] = Taphonomy::all()->pluck('name', 'id');
        $this->viewData['list_bones'] = [''];
        $this->viewData['accession_number'] = isset($request) ? $request['accession_number'] : "";
        $this->viewData['skeletal_grouping'] = isset($request) ? $request['bone_grouping'] : null;
        $this->viewData['skeletal_bones'] = isset($request) ? $request['bone_select'] : null;
        $this->viewData['skeletal_trauma'] = isset($request) ? $request['trauma_select'] : null;
        $this->viewData['skeletal_pathology'] = isset($request) ? $request['pathology_select'] : null;
        $this->viewData['skeletal_taphonomy'] = isset($request) ? $request['taphonomy_select'] : null;
        $this->viewData['bone_group_type'] = "";
    }

    public function storeByGroup(Request $request)
    {
        $this->logInfo(__METHOD__);
        if ($this->authorize('add', [SkeletalElement::class])) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            $request['bone_select'] = explode(',', $request['bone_select']);
            $request['trauma_select'] = explode(',', $request['trauma_select']);
            $request['pathology_select'] = explode(',', $request['pathology_select']);
            $request['taphonomy_select'] = explode(',', $request['taphonomy_select']);
            $numberOfSEs = count($request['bone_select']);
            $designator_num = range($request['designator'], ($request['designator']+$numberOfSEs));
            $an = $request['accession_number'];
            $p1 = $request['provenance1'];
            $p2 = $request['provenance2'];
            if((Accession::where('number',$an)->where('provenance1', $p1)->where('provenance2', $p2)->first()) == null) {
                $input['org_id'] = $this->theOrg->id;
                $input['project_id'] = $this->theProject->id;
                $input['consolidated_an'] = false;
                $input['number'] = $an;
                $input['provenance1'] = $p1;
                $input['provenance2'] = $p2;
                $this->populateCreateFields($input);
                Accession::create($input);
            }
            $se = SkeletalElement::where('accession_number', $an)->where('provenance1', $p1)->where('provenance2', $p2)->whereIn('designator', $designator_num)->first();
            if ($se == null) {
                $requestData = $request->all();
                $this->logInfo(__METHOD__, "BoneGroup:".$request['bone_grouping']." BoneGroup Count:".$numberOfSEs);
                $this->dispatch((new SpecimenGroupCreation($this->theUser->id, $requestData, $numberOfSEs))->onQueue('high'));
                Session::flash('flash_message', trans('messages.se_by_group_job_start'));
            }else{
                Session::flash('alert_message', trans('messages.duplicate_designator_number'));
            }
            $this->setViewDataCommonFields(trans('labels.new_bone_group'));
            $this->setViewDataByBoneGroup($request);
            $group = $request['bone_grouping'];
            $bones_array = $this->getBonesInBoneGroup($group);
            $this->viewData['list_bones'] = $bones_array;
            return view('skeletalelements.create_by_grouping', $this->viewData);
        }
    }

    /**
     * This is the method for the ajax call for the bones by group
     * This method will be called after a bone group has been chosen
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function jsonBonesByGroupArray( Request $request )
    {
        $group = $request['bone_grouping'];
        $bones_array = $this->getBonesInBoneGroup($group);
        return response()->json($bones_array);
    }

    /**
     * Get all the bones in a given bone group.
     *
     * @param $group
     * @return array
     */
    protected function getBonesInBoneGroup($group): array
    {
        $bones = BoneGroup::where('group_name', $group)->join('skeletal_bones', 'bone_groups.sb_id', '=', 'skeletal_bones.id')->orderBy('display_order')->get();
        $bones_array = array();
        foreach ($bones as $bone) {
            if ($bone->side) {
                $bones_array[$bone->name . '- Left'] = $bone->name . ' - Left';
                $bones_array[$bone->name . '- Right'] = $bone->name . ' - Right';
            } else {
                $bones_array[$bone->name] = $bone->name;
            }
        }
        return $bones_array;
    }

    protected function associateZonesOnSEUpdate(SkeletalElement $skeletalelement, $request)
    {
        $this->logInfo(__METHOD__, $skeletalelement->id.":".$skeletalelement->key);

        if ($skeletalelement->completeness === "Complete")
        {
            try {
                $sb = SkeletalBone::find($skeletalelement->sb_id);
                $zones = $sb->zones()->get();
                $arr_zones = [];
                foreach($zones as $zone) {
                    $arr_zones[$zone->id]['id'] = $zone->id;
                    $arr_zones[$zone->id]['presence'] = true;
                }
                $skeletalelement->zones()->sync($this->populateCreateFieldsOrgProjectFieldsForSyncWithData($arr_zones,"presence", $skeletalelement, 'boolean'));
                $this->logInfo(__METHOD__, "Complete Successful ".$skeletalelement->id.":".$skeletalelement->key);
            } catch (QueryException $ex) {
                $this->logQueryException(__METHOD__, $request, $ex);
                Session::flash('alert_message', trans('messages.model_add_unsuccessful', ['model'=>'Zone']));
                return redirect()->back();
            }

            Session::flash('flash_message', trans('messages.success_new_zone'));
        } else {
            try {
                $sb = SkeletalBone::find($skeletalelement->sb_id);
                $zones = $sb->zones()->get();
                $arr_zones = [];
                foreach($zones as $zone) {
                    $arr_zones[$zone->id]['id'] = $zone->id;
                    $arr_zones[$zone->id]['presence'] = false;
                }
                $skeletalelement->zones()->sync([]);
                $this->logInfo(__METHOD__, "Not Complete Successful ".$skeletalelement->id.":".$skeletalelement->key);
            } catch (QueryException $ex) {
                $this->logQueryException(__METHOD__, $request, $ex);
                Session::flash('alert_message', trans('messages.model_update_unsuccessful', ['model'=>'Zone']));
                return redirect()->back();
            }

            Session::flash('flash_message', trans('messages.model_update_successful', ['model'=>'Zone']));
        }
    }

    protected function populateBooleanFields(&$input, $request)
    {
        $this->logInfo(__METHOD__);
        $input['measured'] = ($request['measured'] === null || empty($request['measured'])) ? false : true;
        $input['dna_sampled'] = ($request['dna_sampled'] === null || empty($request['dna_sampled'])) ? false : true;
        $input['ct_scanned'] = ($request['ct_scanned'] === null || empty($request['ct_scanned'])) ? false : true;
        $input['xray_scanned'] = ($request['xray_scanned'] === null || empty($request['xray_scanned'])) ? false : true;
        $input['3D_scanned'] = ($request['3D_scanned'] === null || empty($request['3D_scanned'])) ? false : true;
        $input['clavicle_triage'] = ($request['clavicle_triage'] === null || empty($request['clavicle_triage'])) ? false : true;
        $input['inventoried'] = ($request['inventoried'] === null || empty($request['inventoried'])) ? false : true;
        $input['reviewed'] = ($request['reviewed'] === null || empty($request['reviewed'])) ? false : true;
        $input['isotope_sampled'] = ($request['isotope_sampled'] === null || empty($request['isotope_sampled'])) ? false :true;
    }

    protected function populateDateFields(&$input, $object)
    {
        $this->logInfo(__METHOD__);
        // Handle Inventoried and Inventoried_At
        if ($input['inventoried'] == true and $object->getOriginal('inventoried') == false) {
            $input['inventoried_at'] = Carbon::now()->toDateString();
        } elseif ($input['inventoried'] == false and $object->getOriginal('inventoried') == true) {
            $input['inventoried_at'] = null;
        } else {
            // Don't do anything.
        }

        // Handle Reviewed and Reviewed_At
        if ($input['reviewed'] == true and $object->getOriginal('reviewed') == false) {
            $input['reviewed_at'] = Carbon::now()->toDateString();
        } elseif ($input['reviewed'] == false and $object->getOriginal('reviewed') == true) {
            $input['reviewed_at'] = null;
        } else {
            // Don't do anything.
        }

        // 3d scanned at
        if ($input['3D_scanned'] == true and $object->getOriginal('3D_scanned') == false) {
            $input['3D_scanned_date'] = Carbon::now()->toDateString();
        } elseif ($input['3D_scanned'] == false and $object->getOriginal('3D_scanned') == true) {
            $input['3D_scanned_date'] = null;
        } else {
            // Don't do anything.
        }

        // ct scanned at
        if ($input['ct_scanned'] == true and $object->getOriginal('ct_scanned') == false) {
            $input['ct_scanned_date'] = Carbon::now()->toDateString();
        } elseif ($input['ct_scanned'] == false and $object->getOriginal('ct_scanned') == true) {
            $input['ct_scanned_date'] = null;
        } else {
            // Don't do anything.
        }

        // xray scanned at
        if ($input['xray_scanned'] == true and $object->getOriginal('xray_scanned') == false) {
            $input['xray_scanned_date'] = Carbon::now()->toDateString();
        } elseif ($input['xray_scanned'] == false and $object->getOriginal('xray_scanned') == true) {
            $input['xray_scanned_date'] = null;
        } else {
            // Don't do anything.
        }
    }

    // Specimens Search
    // We have multiple searchtype mechanism such as
    // Accession Number, G-Number, X-Number, Bone
    public function search()
    {
        $this->logInfo(__METHOD__);

        if($this->authorize('browse', [ SkeletalElement::class ])) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            $this->viewData['skeletalelements'] = null;
            $this->viewData['searchstring'] = '';
            $this->viewData['searchby'] = 'SB';
            $this->viewData['list_accession'] = Accession::where('project_id', $this->theProject->id)->where('consolidated_an', false)->pluck('number', 'number');
            $this->viewData['list_provenance1'] = Accession::where('project_id', $this->theProject->id)->where('provenance1','!=' , null)->pluck('provenance1', 'provenance1');
            $this->viewData['list_provenance2'] = Accession::where('project_id', $this->theProject->id)->where('provenance2','!=' , null)->pluck('provenance2', 'provenance2');
            $this->viewData['list_consolidated'] = Accession::where('project_id', $this->theProject->id)->where('consolidated_an', true)->pluck('number', 'number');
            $this->viewData['heading'] = trans('labels.model_search', ['model'=>'Specimen']);
            $this->viewData['initialshow'] = true;
            $this->viewData['open_result_new_tab'] = ( $this->theUser->getProfileValue('se_search_open_in_new_browser_tab') == true ? true : false );

            return view('skeletalelements.search', $this->viewData);
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function searchgo(Request $request)
    {
        $this->logInfo(__METHOD__,"SearchBy:".$request['searchby']." SearchString:".$request['searchstring']);

        try {
            if($this->authorize('browse', [ SkeletalElement::class ])) {
                $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
                $skeletalelements = null;
                $query = SkeletalElement::with(['skeletalbone', 'dnas']);

                $executequery = $this->buildCriteriaData($request, $query);
                if ($executequery) {
                    $limit = config('app.ui.search_size_limit');
                    $skeletalelements = $query->offset(0)->limit($limit)->get();
                }
                $this->viewData['skeletalelements'] = $skeletalelements;
                $this->viewData['list_accession'] = Accession::where('project_id', $this->theProject->id)->where('consolidated_an', false)->pluck('number', 'number');
                $this->viewData['list_provenance1'] = Accession::where('project_id', $this->theProject->id)->where('provenance1','!=' , null)->pluck('provenance1', 'provenance1');
                $this->viewData['list_provenance2'] = Accession::where('project_id', $this->theProject->id)->where('provenance2','!=' , null)->pluck('provenance2', 'provenance2');
                $this->viewData['list_consolidated'] = Accession::where('project_id', $this->theProject->id)->where('consolidated_an', true)->pluck('number', 'number');
                $this->viewData['initialshow'] = false;
                $this->viewData['open_result_new_tab'] = ( $this->theUser->getProfileValue('se_search_open_in_new_browser_tab') == true ? true : false );
                $this->viewData['search_results_by_string'] = trans('messages.search_results_by_string', ['model'=>'Specimen', 'searchby'=>$this->currentSearchByName, 'searchstring' => $this->currentSearchString]);
                $this->viewData['heading'] = trans('labels.model_search', ['model'=>'Specimen'])." by ".$this->currentSearchByName ." ". $this->currentSearchString;

                //Store data in Session Storage for loading Search page in breadcrumbs
                Session::put('skeletalelements', $skeletalelements);
                $this->logInfo(__METHOD__,"SE Search count:". (isset($skeletalelements) ? $skeletalelements->count() : 0));
            }
        } catch (QueryException $ex) {
            $this->logQueryException(__METHOD__, $request, $ex);
            Session::flash('alert_message', trans('messages.search_failed', ['model'=>'Specimens', 'searchby'=> $request['searchby'], 'searchstring'=>$request['searchstring']]));
            return redirect()->back();
        }

        return view('skeletalelements.search', $this->viewData);
    }

    private function buildCriteriaData($request, &$query)
    {
        $this->viewData['searchstring'] = $this->currentSearchString = $request['searchstring'];
        $this->viewData['searchby'] = $this->currentSearchBy = $request['searchby'];
        $this->currentSearchByName = $this->allowedSearch[$this->currentSearchBy];

        $executequery = true;
        if ($this->currentSearchBy == 'AN') {
            $query->where('accession_number', $this->currentSearchString);
        } else if ($this->currentSearchBy == 'P1') {
            $query->where('provenance1', $this->currentSearchString);
        } else if ($this->currentSearchBy == 'P2') {
            $query->where('provenance2', $this->currentSearchString);
        } else if ($this->currentSearchBy == 'DN') {
            $query->where('designator', $this->currentSearchString);
        } else if ($this->currentSearchBy == 'EN') {
            $query->where('external_id', $this->currentSearchString);
        } else if ($this->currentSearchBy == 'IN') {
            $query->where('individual_number', $this->currentSearchString);
        } else if ($this->currentSearchBy == 'SB') {
            $bones = SkeletalBone::where('search_name', strtolower($this->currentSearchString))->get();
            if ($bones->isEmpty()) {
                $executequery = false;
            } else {
                $query->where('sb_id', $bones->first()->id);
            }
        } else if ($this->currentSearchBy == 'CK') {
            $values = array_map('trim', explode(SkeletalElement::$key_delimiter, $this->currentSearchString));
            if (strpos($this->currentSearchString, ',') !== false) {
                $values = array_map('trim', explode(',', $this->currentSearchString));
            }
            $accession = (isset($values[0]) && !empty($values[0])) ? $values[0] : null;
            $prov1 = (isset($values[1]) && !empty($values[1])) ? $values[1] : null;
            $prov2 = (isset($values[2]) && !empty($values[2])) ? $values[2] : null;
            $designator = (isset($values[3]) && !empty($values[3])) ? $values[3] : null;

            if(isset($accession)) { $query = $query->where('accession_number', $accession); }
            if(isset($prov1)) { $query = $query->where('provenance1', $prov1); }
            if(isset($prov2)) { $query = $query->where('provenance2', $prov2); }
            if(isset($designator)) { $query = $query->where('designator', $designator);}
        }

        return $executequery;
    }

    // We will have multiple associations for this Specimen Model
    // such as Taphonomies, Measurements, Age, Zonal Classifications
    // Pair Matching, Articulation, etc

    public function taphonomys(SkeletalElement $skeletalelements)
    {
        $object = $skeletalelements;
        $this->logInfo(__METHOD__, $object->id.":".$object->key);
        if($this->authorize('browse', [ SkeletalElement::class ])) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            $this->viewData['skeletalelement'] = $object;
            $this->viewData['heading'] = trans('labels.taphonomies');
            $this->viewData['list_taphonomy'] = Taphonomy::all()->pluck('name_without_branch', 'id');
            $this->viewData['CRUD_Action'] = 'View';

            return view('skeletalelements.associations.taphonomys', $this->viewData);
        }
    }

    public function edittaphonomys(SkeletalElement $skeletalelements)
    {
        $object = $skeletalelements;
        $this->logInfo(__METHOD__, $object->id.":".$object->key);
        if($this->authorize('edit', $object)) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            $this->viewData['skeletalelement'] = $object;
            $this->viewData['heading'] = trans('labels.taphonomies');
            $this->viewData['list_taphonomy'] = Taphonomy::all()->pluck('name_without_branch', 'id');
            $this->viewData['CRUD_Action'] = 'Update';

            return view('skeletalelements.associations.taphonomys', $this->viewData);
        }
    }

    public function associatetaphonomys(SkeletalElement $skeletalelements, Request $request)
    {
        $object = $skeletalelements;
        $this->logInfo(__METHOD__, $object->id.":".$object->key);
        if ($this->authorize('edit', $object)) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            try {
                $taphonomys = $request->input('taphonomylist');
                $taphonomys = isset($taphonomys) ? $taphonomys : [];
                $this->syncTaphomonys($object, $taphonomys);
            } catch (QueryException $ex) {
                $this->logQueryException(__METHOD__, $request, $ex);
                Session::flash('alert_message', trans('messages.taphonomies_unsuccessful'));
                return redirect()->back();
            }

            Session::flash('flash_message', trans('messages.taphonomies_success'));
            return $this->taphonomys($object);
        }
        return redirect()->back();
    }

    public function pairs(SkeletalElement $skeletalelements)
    {
        $object = $skeletalelements;
        $this->logInfo(__METHOD__, $object->id.":".$object->key);
        if($this->authorize('browse', [ SkeletalElement::class ])) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            $this->viewData['skeletalelement'] = $object;
            $this->viewData['heading'] = trans('labels.pair_matches');

            $this->viewData['list_se'] = $object->getAllPossiblePairMatchesList();
            $this->viewData['skeletalelements'] = $skeletalelements->AllPairs;
            $this->viewData['potential_pairs'] = $object->PotentialPairList;
            $this->viewData['elimination_reasons'] = SkeletalElement::$pair_elimination_reasons;
            $this->viewData['open_result_new_tab'] = false;
            $this->viewData['initialshow'] = true;
            $this->viewData['CRUD_Action'] = 'View';
            $this->viewData['pair_match_lock'] = true;

            return view('skeletalelements.associations.pairs', $this->viewData);
        }
    }

    public function editpairs(SkeletalElement $skeletalelements)
    {
        $object = $skeletalelements;
        $this->logInfo(__METHOD__, $object->id.":".$object->key);
        if($this->authorize('edit', $object)) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            $this->viewData['skeletalelement'] = $object;
            $this->viewData['heading'] = trans('labels.pair_matches');

            $this->viewData['list_se'] = $object->getAllPossiblePairMatchesList();
            $this->viewData['skeletalelements'] = $skeletalelements->AllPairs;
            $this->viewData['potential_pairs'] = $object->PotentialPairList;
            $this->viewData['elimination_reasons'] = SkeletalElement::$pair_elimination_reasons;
            $this->viewData['open_result_new_tab'] = ( $this->theUser->getProfileValue('se_search_open_in_new_browser_tab') == true ? true : false );
            $this->viewData['initialshow'] = true;
            $this->viewData['CRUD_Action'] = 'Update';
            $this->viewData['pair_match_lock'] = false;
            foreach($object->AllPairs as $pair)
            {
                if($pair->pivot->compare_method != 'Visual') {
                    $this->viewData['pair_match_lock'] = true;
                    break;
                }
            }

            return view('skeletalelements.associations.pairs', $this->viewData);
        }
    }

    public function associatepairs(SkeletalElement $skeletalelements, Request $request)
    {
        $object = $skeletalelements;
        $this->logInfo(__METHOD__, $object->id.":".$object->key);
        if ($this->authorize('edit', $object)) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            try {
                $pairlist = $request->input('pairlist');
                $pairlist = isset($pairlist) ? $pairlist : [];
                $this->syncPairs($object, $pairlist);
            } catch (QueryException $ex) {
                $this->logQueryException(__METHOD__, $request, $ex);
                Session::flash('alert_message', trans('messages.pair_matching_unsuccessful'));
                return redirect('/skeletalelements/'.$skeletalelements->id.'/pairs');
            }
        }

        Session::flash('flash_message', trans('messages.pair_matching_success'));
        return $this->pairs($object);
    }

    public function viewpair(SkeletalElement $skeletalelements, SkeletalElement $pair)
    {
        $this->viewData['skeletalelement'] = $skeletalelements;
        $this->viewData['pair'] = $pair;
        $this->viewData['heading'] = $skeletalelements->key. ' - ' . $pair->key;
        $this->viewData['pairInfo'] = $skeletalelements->AllPairs->where('id', $pair->id)->first();
        $this->viewData['elimination_reasons'] = SkeletalElement::$pair_elimination_reasons;

        return view('pairs.show', $this->viewData);
    }

    public function editpair(SkeletalElement $skeletalelements, SkeletalElement $pair)
    {
        $this->viewData['skeletalelement'] = $skeletalelements;
        $this->viewData['pair'] = $pair;
        $this->viewData['heading'] = $skeletalelements->key. ' - ' . $pair->key;
        $this->viewData['pairInfo'] = $skeletalelements->AllPairs->where('id', $pair->id)->first();
        $this->viewData['elimination_reasons'] = SkeletalElement::$pair_elimination_reasons;
        return view('pairs.edit', $this->viewData);
    }

    public function updatepair(SkeletalElement $skeletalelements, SkeletalElement $pair, Request $request)
    {
        $requestFields = $request->only(  'exclusion_reason');
        $pair = $skeletalelements->getAllPairsAttribute()->where('id', $pair->id)->first();

        if( $pair->elimination_reason != $request['elimination_reason']){
            $requestFields['elimination_date'] = ($request['elimination_reason'] == null) ? null : Carbon::now();
        }

        if($skeletalelements->pairs1()->where('id', $pair->id)->first() != null){
            $skeletalelements->pairs1()->updateExistingPivot($pair->id, $requestFields);
        }
        if($skeletalelements->pairs2()->where('id', $pair->id)->first() != null){
            $skeletalelements->pairs2()->updateExistingPivot($pair->id, $requestFields);
        }
        $skeletalelements = SkeletalElement::find($skeletalelements->id);
        return redirect('/skeletalelements/'.$skeletalelements->id.'/pairs');
    }

    public function jsonpairseliminationreason( Request $request )
    {
        $this->logInfo(__Method__, 'pairs id' . $request['pairs_id']);
        $skeletalelement_ids = explode('-', $request['pairs_id']);
        $skeletalelement = SkeletalElement::where('id', $skeletalelement_ids[0])->first();
        $elimination_date = ($request['value'] == null) ? null : Carbon::now();

        if($skeletalelement->pairs1()->where('id', $skeletalelement_ids[1])->first() != null){
            $skeletalelement->pairs1()->updateExistingPivot($skeletalelement_ids[1], array('elimination_reason' => $request['value'], 'elimination_date' => $elimination_date));
        }
        if($skeletalelement->pairs2()->where('id', $skeletalelement_ids[1])->first() != null) {
            $skeletalelement->pairs2()->updateExistingPivot($skeletalelement_ids[1], array('elimination_reason' => $request['value'], 'elimination_date' => $elimination_date));
        }
    }

    public function articulations(SkeletalElement $skeletalelements)
    {
        $object = $skeletalelements;
        $this->logInfo(__METHOD__, $object->id.":".$object->key);
        if($this->authorize('browse', [ SkeletalElement::class ])) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            $this->viewData['skeletalelement'] = $object;
            $this->viewData['list_se'] = $object->getAllPossibleArticulationsList();
            $this->viewData['heading'] = trans('labels.articulations');
            $this->viewData['skeletalelements'] = $skeletalelements->AllArticulations;
            $this->viewData['open_result_new_tab'] = ( $this->theUser->getProfileValue('se_search_open_in_new_browser_tab') == true ? true : false );
            $this->viewData['initialshow'] = true;
            $this->viewData['CRUD_Action'] = 'View';

            return view('skeletalelements.associations.articulations', $this->viewData);
        }
    }

    public function editarticulations(SkeletalElement $skeletalelements)
    {
        $object = $skeletalelements;
        $this->logInfo(__METHOD__, $object->id.":".$object->key);
        if($this->authorize('edit', $object)) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            $this->viewData['skeletalelement'] = $object;
            $this->viewData['list_se'] = $object->getAllPossibleArticulationsList();
            $this->viewData['heading'] = trans('labels.articulations');
            $this->viewData['skeletalelements'] = $skeletalelements->AllArticulations;
            $this->viewData['open_result_new_tab'] = ( $this->theUser->getProfileValue('se_search_open_in_new_browser_tab') == true ? true : false );
            $this->viewData['initialshow'] = true;
            $this->viewData['CRUD_Action'] = 'Update';

            return view('skeletalelements.associations.articulations', $this->viewData);
        }
    }

    public function associatearticulations(SkeletalElement $skeletalelements, Request $request)
    {
        $object = $skeletalelements;
        $this->logInfo(__METHOD__, $object->id.":".$object->key);
        if ($this->authorize('edit', $object)) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            try {
                $articulationlist = $request->input('articulationlist');
                $articulationlist = isset($articulationlist) ? $articulationlist : [];
                $this->syncArticulations($object, $articulationlist);
            } catch (QueryException $ex) {
                $this->logQueryException(__METHOD__, $request, $ex);
                Session::flash('alert_message', trans('messages.articulations_unsuccessful'));
                return redirect()->back();
            }

            Session::flash('flash_message', trans('messages.articulations_success'));
            return $this->articulations($object);
        }
        return redirect()->back();
    }

    public function refits(SkeletalElement $skeletalelements)
    {
        $object = $skeletalelements;
        $this->logInfo(__METHOD__, $object->id.":".$object->key);
        if($this->authorize('browse', [ SkeletalElement::class ])) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            $this->viewData['skeletalelement'] = $object;
            $this->viewData['heading'] = trans('labels.refits');
            $this->viewData['list_se'] = $object->getAllPossibleRefitsList();
            $this->viewData['skeletalelements'] = $skeletalelements->AllRefits;
            $this->viewData['open_result_new_tab'] = ( $this->theUser->getProfileValue('se_search_open_in_new_browser_tab') == true ? true : false );
            $this->viewData['initialshow'] = true;
            $this->viewData['CRUD_Action'] = 'View';

            return view('skeletalelements.associations.refits', $this->viewData);
        }
    }

    public function editrefits(SkeletalElement $skeletalelements)
    {
        $object = $skeletalelements;
        $this->logInfo(__METHOD__, $object->id.":".$object->key);
        if($this->authorize('edit', $object)) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            $this->viewData['skeletalelement'] = $object;
            $this->viewData['heading'] = trans('labels.refits');
            $this->viewData['list_se'] = $object->getAllPossibleRefitsList();
            $this->viewData['skeletalelements'] = $skeletalelements->AllRefits;
            $this->viewData['open_result_new_tab'] = ( $this->theUser->getProfileValue('se_search_open_in_new_browser_tab') == true ? true : false );
            $this->viewData['initialshow'] = true;
            $this->viewData['CRUD_Action'] = 'Update';

            return view('skeletalelements.associations.refits', $this->viewData);
        }
    }

    public function associaterefits(SkeletalElement $skeletalelements, Request $request)
    {
        $object = $skeletalelements;
        $this->logInfo(__METHOD__, $object->id.":".$object->key);
        if ($this->authorize('edit', $object)) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            try {
                $refitlist = $request->input('refitlist');
                $refitlist = isset($refitlist) ? $refitlist : [];
                $this->syncRefits($object, $refitlist);
            } catch (QueryException $ex) {
                $this->logQueryException(__METHOD__, $request, $ex);
                Session::flash('alert_message', trans('messages.refits_unsuccessful'));
                return redirect()->back();
            }

            Session::flash('flash_message', trans('messages.refits_success'));
        }
        return $this->refits($object);
    }

    public function morphologys(SkeletalElement $skeletalelements)
    {
        $object = $skeletalelements;
        $this->logInfo(__METHOD__, $object->id.":".$object->key);
        if($this->authorize('browse', [ SkeletalElement::class ])) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            $this->viewData['skeletalelement'] = $object;
            $this->viewData['heading'] = trans('labels.morphologies');
            $this->viewData['list_se'] = $object->getAllPossibleMorphologysList();
            $this->viewData['skeletalelements'] = $skeletalelements->AllMorphologys;
            $this->viewData['open_result_new_tab'] = ( $this->theUser->getProfileValue('se_search_open_in_new_browser_tab') == true ? true : false );
            $this->viewData['initialshow'] = true;
            $this->viewData['CRUD_Action'] = 'View';

            return view('skeletalelements.associations.morphology', $this->viewData);
        }
    }

    public function editmorphologys(SkeletalElement $skeletalelements)
    {
        $object = $skeletalelements;
        $this->logInfo(__METHOD__, $object->id.":".$object->key);
        if($this->authorize('edit', $object)) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            $this->viewData['skeletalelement'] = $object;
            $this->viewData['heading'] = trans('labels.morphologies');
            $this->viewData['list_se'] = $object->getAllPossibleMorphologysList();
            $this->viewData['skeletalelements'] = $skeletalelements->AllMorphologys;
            $this->viewData['open_result_new_tab'] = ( $this->theUser->getProfileValue('se_search_open_in_new_browser_tab') == true ? true : false );
            $this->viewData['initialshow'] = true;
            $this->viewData['CRUD_Action'] = 'Update';

            return view('skeletalelements.associations.morphology', $this->viewData);
        }
    }

    public function associatemorphologys(SkeletalElement $skeletalelements, Request $request)
    {
        $object = $skeletalelements;
        $this->logInfo(__METHOD__, $object->id.":".$object->key);
        if ($this->authorize('edit', $object)) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            try {
                $morphologylist = $request->input('morphologylist');
                $morphologylist = isset($morphologylist) ? $morphologylist : [];
                $this->syncMorphologys($object, $morphologylist);
            } catch (QueryException $ex) {
                $this->logQueryException(__METHOD__, $request, $ex);
                Session::flash('alert_message', trans('messages.morphologyies_unsuccessful'));
                return redirect()->back();
            }

            Session::flash('flash_message', trans('messages.morphologies_success'));
        }
        return $this->morphologys($object);
    }


    /**
     * Sync up the list of taphomonys for the given skeletalelement record.
     *
     * @param  User $skeletalelement
     * @param  array $taphonomys (id)
     */
    private function syncTaphomonys(SkeletalElement $skeletalelement, array $taphonomys)
    {
        $this->logInfo(__METHOD__, "Start ".$skeletalelement->id.":".$skeletalelement->key);
        $skeletalelement->taphonomys()->sync($this->populateCreateFieldsOrgProjectFieldsForSyncWithIDs($taphonomys, $skeletalelement));
    }

    /**
     * Sync up the list of se - pairs for the given skeletalelement record.
     *
     * @param  User $skeletalelement
     * @param  array $pairs (id)
     */
    private function syncPairs(SkeletalElement $skeletalelement, array $pairs)
    {
        $this->logInfo(__METHOD__, "Start ".$skeletalelement->id.":".$skeletalelement->key);
        $skeletalelement->pairs1()->detach();
        $skeletalelement->pairs2()->detach();
        $skeletalelement->pairs()->sync($this->populateCreateFieldsOrgProjectFieldsForSyncWithIDs($pairs, $skeletalelement));
    }

    /**
     * Sync up the list of se - articulations for the given skeletalelement record.
     *
     * @param  User $skeletalelement
     * @param  array $articulations (id)
     */
    private function syncArticulations(SkeletalElement $skeletalelement, array $articulations)
    {
        $this->logInfo(__METHOD__, "Start ".$skeletalelement->id.":".$skeletalelement->key);
        $skeletalelement->articulations1()->detach();
        $skeletalelement->articulations2()->detach();
        $skeletalelement->articulations()->sync($this->populateCreateFieldsOrgProjectFieldsForSyncWithIDs($articulations, $skeletalelement));
    }

    /**
     * Sync up the list of se - refits for the given skeletalelement record.
     *
     * @param  User $skeletalelement
     * @param  array $refits (id)
     */
    private function syncRefits(SkeletalElement $skeletalelement, array $refits)
    {
        $this->logInfo(__METHOD__, "Start ".$skeletalelement->id.":".$skeletalelement->key);
        $skeletalelement->refits1()->detach();
        $skeletalelement->refits2()->detach();
        $skeletalelement->refits()->sync($this->populateCreateFieldsOrgProjectFieldsForSyncWithIDs($refits, $skeletalelement));
    }

    /**
     * Sync up the list of se - morphologys for the given skeletalelement record.
     *
     * @param  User $skeletalelement
     * @param  array $morphologys (id)
     */
    private function syncMorphologys(SkeletalElement $skeletalelement, array $morphologys)
    {
        $this->logInfo(__METHOD__, "Start ".$skeletalelement->id.":".$skeletalelement->key);
        $skeletalelement->morphologys1()->detach();
        $skeletalelement->morphologys2()->detach();
        $skeletalelement->morphologys()->sync($this->populateCreateFieldsOrgProjectFieldsForSyncWithIDs($morphologys, $skeletalelement));
    }

    public function measurements(SkeletalElement $skeletalelements)
    {
        $object = $skeletalelements;
        $this->logInfo(__METHOD__, $object->id.":".$object->key);
        if($this->authorize('browse', [ SkeletalElement::class ])) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            $this->viewData['skeletalelement'] = $object;
            $this->viewData['heading'] = trans('labels.view_measurements');
            $this->viewData['measurements'] = Measurement::where('sb_id', $object->sb_id)->orderBy('display_order')->get();
            $this->viewData['CRUD_Action'] = "View";

            return view('skeletalelements.associations.measurements', $this->viewData);
        }
    }

    public function editMeasurements(SkeletalElement $skeletalelements)
    {
        $object = $skeletalelements;
        $this->logInfo(__METHOD__, $object->id.":".$object->key);
        if ($this->authorize('edit', $object)) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            $this->viewData['skeletalelement'] = $object;
            $this->viewData['heading'] = trans('labels.edit_measurements');
            $this->viewData['measurements'] = Measurement::where('sb_id', $object->sb_id)->orderBy('display_order')->get();
            $this->viewData['CRUD_Action'] = "Update";

            return view('skeletalelements.associations.measurements', $this->viewData);
        }
    }

    public function associatemeasurements(SkeletalElement $skeletalelements, Request $request)
    {
        $object = $skeletalelements;
        $this->logInfo(__METHOD__, $object->id.":".$object->key);
        if ($this->authorize('edit', $object)) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            try {
                $arr_measurements = Input::get('measurements', array());
                $arr_measurements = $this->removeElementWithValue($arr_measurements, "measure", "");
                $object->measurements()->sync($this->populateCreateFieldsOrgProjectFieldsForSyncWithData($arr_measurements,"measure", $skeletalelements));
                if (count($arr_measurements) > 0) {
                    $object->fill(['measured' => true])->save(); // indicate that SE measurements has been performed/completed.
                } else {
                    $object->fill(['measured' => false])->save(); // indicate that SE measurements has not been performed/completed.
                }
            } catch (QueryException $ex) {
                $this->logQueryException(__METHOD__, $request, $ex);
                Session::flash('alert_message', trans('messages.measurements_unsuccessful'));
                return redirect()->back();
            }

            Session::flash('flash_message', trans('messages.measurements_success'));
        }
        return redirect('/skeletalelements/'.$skeletalelements->id.'/measurements');
    }

    public function viewZones(SkeletalElement $skeletalelements)
    {
        $object = $skeletalelements;
        $this->logInfo(__METHOD__, $object->id.":".$object->key);
        if($this->authorize('browse', [ SkeletalElement::class ])) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            $this->viewData['skeletalelement'] = $object;
            $this->viewData['heading'] = trans('labels.zones');
            $this->viewData['zones'] = Zone::where('sb_id', $object->sb_id)->orderBy('display_order')->get();
            $this->viewData['CRUD_Action'] = 'View';

            return view('skeletalelements.associations.zones', $this->viewData);
        }
    }

    public function editZones(SkeletalElement $skeletalelements)
    {
        $object = $skeletalelements;
        $this->logInfo(__METHOD__, $object->id.":".$object->key);
        if($this->authorize('edit', $object)) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            $this->viewData['skeletalelement'] = $object;
            $this->viewData['heading'] = trans('labels.zones');
            $this->viewData['zones'] = Zone::where('sb_id', $object->sb_id)->orderBy('display_order')->get();
            $this->viewData['CRUD_Action'] = 'Update';

            return view('skeletalelements.associations.zones', $this->viewData);
        }
    }

    public function associatezones(SkeletalElement $skeletalelements, Request $request)
    {
        $object = $skeletalelements;
        $this->logInfo(__METHOD__, $object->id.":".$object->key);
        if ($this->authorize('edit', $object)) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            try {
                $sb = SkeletalBone::find($skeletalelements->sb_id);
                $zones = $sb->zones()->get();
                $arr_zones = [];
                foreach($zones as $zone) {
                    $arr_zones[$zone->id]['id'] = $zone->id;
                    $arr_zones[$zone->id]['presence'] = true;
                }

                $arr_zones = Input::get('zones', array());
                $arr_zones = $this->removeElementWithValue($arr_zones, "presence", "");
                $object->zones()->sync($this->populateCreateFieldsOrgProjectFieldsForSyncWithData($arr_zones,"presence", $skeletalelements, 'boolean'));
                if ($object->project()->zones_autocomplete) {
                    if ($request['select_all'] == true) {
                        $object->fill(['completeness' => 'Complete'])->save();
                    }else {
                        $object->fill(['completeness' => 'Incomplete'])->save();
                    }
                }
            } catch (QueryException $ex) {
                $this->logQueryException(__METHOD__, $request, $ex);
                Session::flash('alert_message', trans('messages.model_add_unsuccessful', ['model'=>'Zone']));
                return redirect()->back();
            }

            Session::flash('flash_message', trans('messages.model_add_successful', ['model'=>'Zone']));
        }
        return redirect()->route('skeletalelements.viewzones', [$object->id]);
    }

    // ToDo: This function can be removed.
    protected function populateDNAFields(&$input, $request)
    {
        $this->logInfo(__METHOD__);
        $input['ystr'] = $request['ystr'] == '' ? false : true;
        $input['astr'] = $request['astr'] == '' ? false : true;
        $input['mito_vr1'] = $request['mito_vr1'] == '' ? false : true;
        $input['mito_vr2'] = $request['mito_vr2'] == '' ? false : true;

        // ToDo: This needs to be fixed - related to Dates
//        array_pull($input, 'ystr_request_date');
//        array_pull($input, 'ystr_receive_date');
//        array_pull($input, 'astr_request_date');
//        array_pull($input, 'astr_receive_date');
    }

    public function methods(SkeletalElement $skeletalelements, $type)
    {
        $object = $skeletalelements;
        $this->logInfo(__METHOD__, $object->id.":".$object->key." Type: " . $type);
        if($this->authorize('browse', [ SkeletalElement::class ])) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            $this->viewData['skeletalelement'] = $object;
            $this->viewData['heading'] = $type;
            $this->viewData['methodType'] = $type;
            $this->viewData['methods'] = $object->methodsAvailableByType($type);
            $this->viewData['list_method'] = $object->methodsAvailableByType($type)->pluck('name_with_submethod', 'id');

            // This was added for vue component, should be removed once component is self sufficient
            $this->viewData['se_methods'] = $object->methods()->get();
            $this->viewData['se_methodfeatures'] = $object->methodfeatures()->get();
            return view('skeletalelements.associations.listmethod', $this->viewData);
        }
    }

    public function associatemethod(SkeletalElement $skeletalelements, Method $method, Request $request) {
        $object = $skeletalelements;
        $type = $method->type;
        $this->logInfo(__METHOD__, $object->id.":".$object->key);
        if ($this->authorize('edit', $object)) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            // First check if this SE has this method association in se_method
            // or if this is a new method assoication
            if ($object->methods()->find($method->id) == null) {
                // This Method does not exist for this SE, so create this new method
                $object->methods()->attach($this->populateCreateFieldsOrgProjectFieldsForSyncWithIDs([$method->id], $skeletalelements));
                Session::flash('flash_message', trans('messages.success_method'));
                $this->logInfo(__METHOD__, 'New Method association created '.$method->id);

                // Check which models/tables need to be updated
                if ($method->uses_feature_score) {
                    $this->logInfo(__METHOD__, 'Method uses Feature Score Mechanism');
                    $arr_methodfeatures = Input::get('features', array());
                    $this->calculateAllCompositeScores($skeletalelements, $method, $arr_methodfeatures);
                    $arr_methodfeatures = $this->removeElementWithValue($arr_methodfeatures, "score", "");

                    // Attach the methodfeatures for the SE
                    $attachlist = $this->getSyncArrayForMethodFeatures($arr_methodfeatures, $object);
                    $object->methodfeatures()->attach($attachlist);
                    Session::flash('flash_message', trans('messages.success_method_features'));
                    $this->logInfo(__METHOD__, 'Method Features associated');
                }
            } else {
                $this->logInfo(__METHOD__, 'Method association already exist');
                // First check the method and see which models/tables need to be updated
                if ($method->uses_feature_score) {
                    $this->logInfo(__METHOD__, 'Method uses Feature Score Mechanism');
                    $arr_methodfeatures = Input::get('features', array());
                    $this->calculateAllCompositeScores($skeletalelements, $method, $arr_methodfeatures);
                    $arr_methodfeatures = $this->removeElementWithValue($arr_methodfeatures, "score", "");
                    // First detach the methodfeatures for the SE
                    $detachlist = $this->getListofIdsFromModelCollection($object->methodfeaturesByMethod($method->id));
                    $object->methodfeatures()->detach($detachlist);

                    // Then attach the methodfeatures for the SE
                    $attachlist = $this->getSyncArrayForMethodFeatures($arr_methodfeatures, $object);
                    $object->methodfeatures()->attach($attachlist);
                    Session::flash('flash_message', trans('messages.success_method_features'));
                    $this->logInfo(__METHOD__, 'Method Features associated');
                }
            }
        }
        return redirect()->route('skeletalelements.viewmethod', [$skeletalelements->id, $method->id]);
    }

    private function calculateAllCompositeScores($skeletalelements, $method, &$arr_methodfeatures)
    {
        $this->logInfo(__METHOD__, $skeletalelements->id. ' Method: '.$method->name);
        if ($method->uses_composite_score) {
            $computed_methodfeatures = $method->features->where('computed', '=', true);
            foreach ($computed_methodfeatures as $computed_feature) {
                if ($computed_feature->feature) {
                    $this->calculateCompositeScoreForFeature($skeletalelements, $method, $arr_methodfeatures, $computed_feature, $computed_feature->id);
                }
            }
        }
    }

    private function calculateCompositeScoreForFeature($skeletalelements, $method, &$arr_methodfeatures, $computed_feature, $computed_feature_id) {
        $total = 0; $all_scored = true;
        $this->logInfo(__METHOD__, $skeletalelements->id. ' MethodFeature: '.$computed_feature->feature);
        foreach(explode(",", $computed_feature->compute_rule) as $featurename) {
            $feature = $method->features->where('feature', '=', $featurename)->first();
            $element = array_get($arr_methodfeatures, $feature->id);
            if (is_numeric($element["score"])) {
                $total += $element["score"];
            } else {
                $all_scored = false;
                break;
            }
        }

        foreach($arr_methodfeatures as &$methodfeature) {
            if ($methodfeature["method_feature_id"] == $computed_feature_id) {
                $this->logInfo(__METHOD__, $skeletalelements->id. ' Calculated Feature Score: '.$total);
                return $methodfeature["score"] = ($all_scored) ? strval($total) : null;
            }
        }
    }

    public function viewMethod(SkeletalElement $skeletalelements, Method $methods)
    {
        $object = $skeletalelements;
        $this->logInfo(__METHOD__, $object->id.":".$object->key.' Method: '.$methods->name);
        if ($this->authorize('browse', [ SkeletalElement::class ])) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            $this->viewData['skeletalelement'] = $object;
            $this->viewData['heading'] = trans('labels.edit_method');
            $this->viewData['methodType'] = $methods->type;
            $this->viewData['method'] = $methods;
            $this->viewData['list_method'] = Method::where('sb_id', $object->sb_id)->where('type', $methods->type)->get()->pluck('name_with_submethod', 'id');
            $this->viewData['CRUD_Action'] = 'View';

            return view('skeletalelements.associations.method', $this->viewData);
        }
    }

    public function editmethod(SkeletalElement $skeletalelements, Method $methods)
    {
        $object = $skeletalelements;
        $this->logInfo(__METHOD__, $object->id.":".$object->key.' Method: '.$methods->name);
        if ($this->authorize('edit', $object)) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            $this->viewData['skeletalelement'] = $object;
            $this->viewData['heading'] = trans('labels.edit_method');
            $this->viewData['methodType'] = $methods->type;
            $this->viewData['method'] = $methods;
            $this->viewData['list_method'] = Method::where('sb_id', $object->sb_id)->where('type', $methods->type)->get()->pluck('name_with_submethod', 'id');
            $this->viewData['CRUD_Action'] = 'Update';

            return view('skeletalelements.associations.method', $this->viewData);
        }
    }

    public function createmethod(SkeletalElement $skeletalelements, Request $request)
    {
        $object = $skeletalelements;
        $methodId = $request['methodlist'][0];
        $method = Method::find($methodId);
        $this->logInfo(__METHOD__, $object->id.":".$object->key);
        if ($this->authorize('add', [SkeletalElement::class])) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            $this->viewData['skeletalelement'] = $object;
            $this->viewData['heading'] = trans('labels.create_method');
            $this->viewData['methodType'] = $method->type;
            $this->viewData['method'] = $method;
            $this->viewData['CRUD_Action'] = 'Create';

            return view('skeletalelements.associations.method', $this->viewData);
        }
    }

    public function deletemethod(SkeletalElement $skeletalelements, $id)
    {
        $object = $skeletalelements;
        $this->logInfo(__METHOD__, $object->id.":".$object->key.' Method ID: '.$id);
        if ($this->authorize('delete', $object)) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            try {
                $object->methodfeatures()->where('method_id', '=', $id)->sync([]);
                $object->methods()->detach([$id]);
            } catch (QueryException $ex) {
                $this->logInfo(__METHOD__, 'SE DELETE unsuccessful, se-id:' . $object->id. ' Method id:'. $id);
                Session::flash('alert_message', 'Specimen Method DELETE unsuccessfull');
                return redirect()->back();
            }
        }
        Session::flash('flash_message', 'Specimen Method successfully deleted!');
        $this->logInfo(__METHOD__, 'End');
        return redirect()->back();
    }

    public function age(SkeletalElement $skeletalelements)
    {
        $this->logInfo(__METHOD__, $skeletalelements->id.":".$skeletalelements->key);
        if($this->authorize('browse', [ SkeletalElement::class ])) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            return $this->methods($skeletalelements, "Age");
        }
    }

    public function sex(SkeletalElement $skeletalelements)
    {
        $this->logInfo(__METHOD__, $skeletalelements->id.":".$skeletalelements->key);
        if($this->authorize('browse', [ SkeletalElement::class ])) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            return $this->methods($skeletalelements, "Sex");
        }
    }

    public function stature(SkeletalElement $skeletalelements)
    {
        $this->logInfo(__METHOD__, $skeletalelements->id.":".$skeletalelements->key);
        if($this->authorize('browse', [ SkeletalElement::class ])) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            return $this->methods($skeletalelements, "Stature");
        }
    }

    public function ancestry(SkeletalElement $skeletalelements)
    {
        $this->logInfo(__METHOD__, $skeletalelements->id.":".$skeletalelements->key);
        if($this->authorize('browse', [ SkeletalElement::class ])) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            return $this->methods($skeletalelements, "Ancestry");
        }
    }

    public function anomalys(SkeletalElement $skeletalelements)
    {
        $object = $skeletalelements;
        $this->logInfo(__METHOD__, $object->id.":".$object->key);
        if($this->authorize('browse', [ SkeletalElement::class ])) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            $this->viewData['skeletalelement'] = $object;
            $this->viewData['heading'] = trans('labels.anomalies');
            $this->viewData['list_anomaly'] = Anomaly::where('sb_id', $object->sb_id)->get()->pluck('trait', 'id');
            $this->viewData['CRUD_Action'] = 'View';

            return view('skeletalelements.associations.anomalys', $this->viewData);
        }
    }

    public function editAnomalys(SkeletalElement $skeletalelements)
    {
        $object = $skeletalelements;
        $this->logInfo(__METHOD__, $object->id.":".$object->key);
        if($this->authorize('edit', $object)) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            $this->viewData['skeletalelement'] = $object;
            $this->viewData['heading'] = trans('labels.anomalies');
            $this->viewData['list_anomaly'] = Anomaly::where('sb_id', $object->sb_id)->get()->pluck('trait', 'id');
            $this->viewData['CRUD_Action'] = 'Update';

            return view('skeletalelements.associations.anomalys', $this->viewData);
        }
    }

    public function associateanomalys(SkeletalElement $skeletalelements, Request $request) {
        $object = $skeletalelements;
        $this->logInfo(__METHOD__, $object->id.":".$object->key);
        if ($this->authorize('edit', $object)) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            try {
                $anomalylist = $request->input('anomalylist');
                $anomalylist = isset($anomalylist) ? $anomalylist : [];
                $this->syncAnomalys($object, $anomalylist);
            } catch (QueryException $ex) {
                $this->logQueryException(__METHOD__, $request, $ex);
                Session::flash('alert_message', trans('messages.anomalys_unsuccessful'));
                return redirect()->back();
            }

            Session::flash('flash_message', trans('messages.success_anomalys'));
        }
        return $this->anomalys($object);
    }

    /**
     * Sync up the list of anomalys for the given skeletalelement record.
     *
     * @param  User  $skeletalelement
     * @param  array  $anomalys (id)
     */
    private function syncAnomalys(SkeletalElement $skeletalelement, array $anomalys)
    {
        $this->logInfo(__METHOD__, "Start ".$skeletalelement->id.":".$skeletalelement->key);
        $skeletalelement->anomalys()->sync($this->populateCreateFieldsOrgProjectFieldsForSyncWithIDs($anomalys, $skeletalelement));
    }

    public function traumas(SkeletalElement $skeletalelements)
    {
        $object = $skeletalelements;
        $this->logInfo(__METHOD__, $object->id.":".$object->key);
        if($this->authorize('browse', [ SkeletalElement::class ])) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            $this->viewData['skeletalelement'] = $object;
            $this->viewData['heading'] = trans('labels.traumas');
            $this->viewData['zones'] = Zone::where('sb_id', $object->sb_id)->orderBy('display_order')->get();
            $this->viewData['traumas'] = Trauma::orderBy('timing')->orderBy('type')->get();

            return view('skeletalelements.associations.listtrauma', $this->viewData);
        }
    }

    public function showPat(SkeletalElement $skeletalelements)
    {
        $this->logInfo(__METHOD__, $skeletalelements->id.":".$skeletalelements->key);
        if($this->authorize('add', [ SkeletalElement::class ])) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);

            // specimen info
            $this->viewData['skeletalelements'] = $skeletalelements;
            $this->viewData['CRUD_Action'] = "View";

            //list of traumas, anomalies, and pathology for autocomplete
            $this->viewData['list_trauma'] = Trauma::orderBy('timing')->orderBy('type')->get()->pluck('name', 'id');
            $this->viewData['list_anomaly'] = Anomaly::where('sb_id', $skeletalelements->sb_id)->get()->pluck('trait', 'id');
            $this->viewData['list_pathology'] = Pathology::orderBy('abnormality_category')->orderBy('characteristics')->get()->pluck('name', 'id');
            $this->viewData['list_zone'] = Zone::where('sb_id', $skeletalelements->sb_id)->orderBy('display_order')->get()->pluck('display_name', 'id');

            //traumas, anomalies, pathologies
            $this->viewData['traumas'] = $skeletalelements->traumas()->get();
            $this->viewData['pathologies'] = $skeletalelements->pathologys()->get();
            $this->viewData['anomaly'] = $skeletalelements->anomalys()->get();

            return view('skeletalelements.associations.pat', $this->viewData);
        }
    }

    public function associatetrauma(SkeletalElement $skeletalelements, Request $request) {
        $object = $skeletalelements;
        $this->logInfo(__METHOD__, $object->id.":".$object->key);

        $zones = ($request->input('zonelist') == "") ? null : $request->input('zonelist');
        $trauma_id = $request['trauma_id'];
        $additional_information = $request['additional_information'];

        if($zones == null) {
            $zones = [0];
        }
        foreach ($zones as $value) {
            if($value == 0) {
                $value = null;
            }
                $trauma = $object->traumas()->wherePivot('zone_id', $value)->wherePivot('trauma_id', $trauma_id)->get()->first();
                if ($trauma == null) { // Create a new trauma
                    if ($this->authorize('add', [SkeletalElement::class])) {
                        $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
                        try {
                            if (Auth::check()) {
                                $syncData = [];
                                $syncData[$trauma_id] = ['zone_id' => $value, 'additional_information' => $additional_information,
                                    'org_id' => $skeletalelements->org_id, 'project_id' => $skeletalelements->project_id,
                                    'created_by' => $this->theUser->name, 'updated_by' => $this->theUser->name];
                                $object->traumas()->attach($syncData);
                                Session::flash('flash_message', trans('messages.success_trauma'));
                            }
                        } catch (QueryException $ex) {
                            $this->logQueryException(__METHOD__, $request, $ex);
                            Session::flash('alert_message', trans('messages.trauma_add_unsuccessful'));
                            return redirect()->back();
                        }
                    }
                } else { // update existing trauma
                    if ($this->authorize('edit', $object)) {
                        $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
                        try {
                            if (Auth::check()) {
                                DB::table('se_trauma')->where('se_id', $object->id)->where('zone_id', $value)->where('trauma_id', $trauma_id)
                                    ->update(['additional_information' => $additional_information, 'updated_by' => $this->theUser->name]);
                                Session::flash('flash_message', trans('messages.success_trauma'));
                            }
                        } catch (QueryException $ex) {
                            $this->logQueryException(__METHOD__, $request, $ex);
                            Session::flash('alert_message', trans('messages.trauma_update_unsuccessful'));
                            return redirect()->back();
                        }
                    }
                }
            }
        return redirect()->route('skeletalelements.traumas', [$skeletalelements]);
    }

    public function createtrauma(SkeletalElement $skeletalelements, Request $request)
    {
        $object = $skeletalelements;
        $this->logInfo(__METHOD__, $object->id.":".$object->key);
        if ($this->authorize('add', [SkeletalElement::class])) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            $this->viewData['skeletalelement'] = $object;
            $this->viewData['trauma'] = null;
            $this->viewData['heading'] = trans('labels.create_trauma');
            $this->viewData['CRUD_Action'] = "Create";
            $this->viewData['list_zone'] = Zone::where('sb_id', $object->sb_id)->orderBy('display_order')->get()->pluck('display_name', 'id');
            $this->viewData['list_trauma'] = Trauma::orderBy('timing')->orderBy('type')->get()->pluck('name', 'id');

            return view('skeletalelements.associations.trauma', $this->viewData);
        }
    }

    public function viewtrauma(SkeletalElement $skeletalelements, $id)
    {
        $object = $skeletalelements;
        $this->logInfo(__METHOD__, $object->id.":".$object->key." ID=".$id);
        if ($this->authorize('browse', [ SkeletalElement::class ])) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            $trauma = $object->traumas()->wherePivot('id', $id)->get()->first();
            $this->viewData['skeletalelement'] = $object;
            $this->viewData['trauma'] = $trauma;
            $this->viewData['heading'] = trans('labels.view_trauma');
            $this->viewData['CRUD_Action'] = "View";
            $this->viewData['list_zone'] = Zone::where('sb_id', $object->sb_id)->orderBy('display_order')->get()->pluck('display_name', 'id');
            $this->viewData['list_trauma'] = Trauma::orderBy('timing')->orderBy('type')->get()->pluck('name', 'id');

            return view('skeletalelements.associations.trauma', $this->viewData);
        }
    }

    public function edittrauma(SkeletalElement $skeletalelements, $id)
    {
        $object = $skeletalelements;
        $this->logInfo(__METHOD__, $object->id.":".$object->key." ID=".$id);
        if ($this->authorize('edit', $object)) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            $trauma = $object->traumas()->wherePivot('id', $id)->get()->first();
            $this->viewData['skeletalelement'] = $object;
            $this->viewData['trauma'] = $trauma;
            $this->viewData['heading'] = trans('labels.edit_trauma');
            $this->viewData['CRUD_Action'] = "Update";
            $this->viewData['list_zone'] = Zone::where('sb_id', $object->sb_id)->orderBy('display_order')->get()->pluck('display_name', 'id');
            $this->viewData['list_trauma'] = Trauma::orderBy('timing')->orderBy('type')->get()->pluck('name', 'id');

            return view('skeletalelements.associations.trauma', $this->viewData);
        }
    }

    public function deletetrauma(SkeletalElement $skeletalelements, $id)
    {
        $object = $skeletalelements;
        $this->logInfo(__METHOD__, $object->id.":".$object->key." ID=".$id);
        if ($this->authorize('delete', $object)) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            try {
                $trauma = $object->traumas()->wherePivot('id', $id)->get()->first();
                $object->traumas()->newPivotStatementForId($trauma->id)->where('id', $id)->delete();
            } catch (QueryException $ex) {
                $this->logInfo(__METHOD__, 'SE delete unsuccessful, se-id:' . $object->id. ' Trauma id:'. $id);
                Session::flash('alert_message', 'Specimen Trauma DELETE unsuccessfull');
                return redirect()->back();
            }
        }
        Session::flash('flash_message', 'Specimen Trauma successfully deleted!');
        $this->logInfo(__METHOD__, 'End');
        return redirect()->back();
    }

    public function pathologys(SkeletalElement $skeletalelements)
    {
        $object = $skeletalelements;
        $this->logInfo(__METHOD__, $object->id.":".$object->key);
        if($this->authorize('browse', [ SkeletalElement::class ])) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            $this->viewData['skeletalelement'] = $object;
            $this->viewData['heading'] = trans('labels.pathologies');
            $this->viewData['zones'] = Zone::where('sb_id', $object->sb_id)->orderBy('display_order')->get();
            $this->viewData['pathologys'] = Pathology::orderBy('abnormality_category')->orderBy('characteristics')->get();

            return view('skeletalelements.associations.listpathology', $this->viewData);
        }
    }

    public function associatepathology(SkeletalElement $skeletalelements, Request $request)
    {
        $object = $skeletalelements;
        $this->logInfo(__METHOD__, $object->id.":".$object->key);

        $zones = ($request->input('zonelist') == "") ? null : $request->input('zonelist');
        $pathology_id = $request['pathology_id'];
        $additional_information = $request['additional_information'];

        if($zones == null){
            $zones = [0];
        }

        foreach ($zones as $value) {
                if($value == 0){
                    $value = null;
                }
                $pathology = $object->pathologys()->wherePivot('zone_id', $value)->wherePivot('pathology_id', $pathology_id)->get()->first();
                if ($pathology == null) { // Create a new pathology
                    if ($this->authorize('add', [SkeletalElement::class])) {
                        $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
                        try {
                            if (Auth::check()) {
                                $syncData = [];
                                $syncData[$pathology_id] = ['zone_id' => $value, 'additional_information' => $additional_information,
                                    'org_id' => $skeletalelements->org_id, 'project_id' => $skeletalelements->project_id,
                                    'created_by' => $this->theUser->name, 'updated_by' => $this->theUser->name];
                                $object->pathologys()->attach($syncData);
                            }
                            Session::flash('flash_message', trans('messages.success_pathology'));
                        } catch (QueryException $ex) {
                            $this->logQueryException(__METHOD__, $request, $ex);
                            Session::flash('alert_message', trans('messages.pathology_add_unsuccessful'));
                            return redirect()->back();
                        }
                    }
                } else { // update existing pathology
                    if ($this->authorize('edit', $object)) {
                        $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
                        try {
                            if (Auth::check()) {
                                if (Auth::check()) {
                                    DB::table('se_pathology')->where('se_id', $object->id)->where('zone_id', $value)->where('pathology_id', $pathology_id)
                                        ->update(['additional_information' => $additional_information, 'updated_by' => $this->theUser->name]);
                                    Session::flash('flash_message', trans('messages.success_pathology'));
                                }
                            }
                        } catch (QueryException $ex) {
                            $this->logQueryException(__METHOD__, $request, $ex);
                            Session::flash('alert_message', trans('messages.pathology_update_unsuccessful'));
                            return redirect()->back();
                        }
                    }
                }
            }
        return redirect()->route('skeletalelements.pathologys', [$skeletalelements]);
    }

    public function createpathology(SkeletalElement $skeletalelements, Request $request)
    {
        $object = $skeletalelements;
        $this->logInfo(__METHOD__, $object->id.":".$object->key);
        if ($this->authorize('add', [SkeletalElement::class])) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            $this->viewData['skeletalelement'] = $object;
            $this->viewData['pathology'] = null;
            $this->viewData['heading'] = trans('labels.create_pathology');
            $this->viewData['CRUD_Action'] = "Create";
            $this->viewData['list_zone'] = Zone::where('sb_id', $object->sb_id)->orderBy('display_order')->get()->pluck('display_name', 'id');
            $this->viewData['list_pathology'] = Pathology::orderBy('abnormality_category')->orderBy('characteristics')->get()->pluck('name', 'id');

            return view('skeletalelements.associations.pathology', $this->viewData);
        }
    }

    public function viewpathology(SkeletalElement $skeletalelements, $id)
    {
        $object = $skeletalelements;
        $this->logInfo(__METHOD__, $object->id.":".$object->key." ID=".$id);
        if ($this->authorize('browse', [ SkeletalElement::class ])) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            $pathology = $object->pathologys()->wherePivot('id', $id)->get()->first();
            $this->viewData['skeletalelement'] = $object;
            $this->viewData['pathology'] = $pathology;
            $this->viewData['heading'] = trans('labels.view_pathology');
            $this->viewData['CRUD_Action'] = "View";
            $this->viewData['list_zone'] = Zone::where('sb_id', $object->sb_id)->orderBy('display_order')->get()->pluck('display_name', 'id');
            $this->viewData['list_pathology'] = Pathology::orderBy('abnormality_category')->orderBy('characteristics')->get()->pluck('name', 'id');

            return view('skeletalelements.associations.pathology', $this->viewData);
        }
    }

    public function editpathology(SkeletalElement $skeletalelements, $id)
    {
        $object = $skeletalelements;
        $this->logInfo(__METHOD__, $object->id.":".$object->key." ID=".$id);
        if ($this->authorize('edit', $object)) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            $pathology = $object->pathologys()->wherePivot('id', $id)->get()->first();
            $this->viewData['skeletalelement'] = $object;
            $this->viewData['pathology'] = $pathology;
            $this->viewData['heading'] = trans('labels.edit_pathology');
            $this->viewData['CRUD_Action'] = "Update";
            $this->viewData['list_zone'] = Zone::where('sb_id', $object->sb_id)->orderBy('display_order')->get()->pluck('display_name', 'id');
            $this->viewData['list_pathology'] = Pathology::orderBy('abnormality_category')->orderBy('characteristics')->get()->pluck('name', 'id');

            return view('skeletalelements.associations.pathology', $this->viewData);
        }
    }

    public function deletepathology(SkeletalElement $skeletalelements, $id)
    {
        $object = $skeletalelements;
        $this->logInfo(__METHOD__, $object->id.":".$object->key." ID=".$id);
        if ($this->authorize('delete', $object)) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            try {
                $pathology = $object->pathologys()->wherePivot('id', $id)->get()->first();
                $object->pathologys()->newPivotStatementForId($pathology->id)->where('id', $id)->delete();
            } catch (QueryException $ex) {
                $this->logInfo(__METHOD__, 'SE DELETE unsuccessful, se-id:' . $object->id. ' Pathology id:'. $id);
                Session::flash('alert_message', 'Specimen Pathology DELETE unsuccessfull');
                return redirect()->back();
            }
        }
        Session::flash('flash_message', 'Specimen Pathology successfully deleted!');
        $this->logInfo(__METHOD__, 'End');
        return redirect()->back();
    }

    public function review(SkeletalElement $skeletalelements, Request $request)
    {
        $this->logInfo(__METHOD__, $skeletalelements->id.":".$skeletalelements->key);
        if($this->authorize('browse', [ SkeletalElement::class ])) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            $this->viewData['skeletalelement'] = $skeletalelements;
            $this->viewData['heading'] = trans('labels.review');
            $this->viewData['request'] = $request;
            $user = $this->theUser;
            $this->viewData['zones_base_data'] = Zone::where('sb_id', $skeletalelements->sb_id)->orderBy('display_order')->get();
            $this->viewData['list_zones'] = Zone::where('sb_id', $skeletalelements->sb_id)->orderBy('display_order')->get()->pluck('display_name', 'id');
            $this->viewData['list_pathology'] = Pathology::orderBy('abnormality_category')->orderBy('characteristics')->get()->pluck('name', 'id');
            $this->viewData['list_trauma'] = Trauma::orderBy('timing')->orderBy('type')->get()->pluck('name', 'id');
            $this->viewData['list_anomaly'] = Anomaly::where('sb_id', $skeletalelements->sb_id)->get()->pluck('trait', 'id');
            $this->viewData["list_disposition"] = Dna::$disposition;
            $this->viewData["list_sample_condition"] = Dna::$sample_condition;
            $this->viewData['list_y_haplogroup'] = Haplogroup::orderBy('letter')->where('type', 'Ystr')->get()->pluck('key', 'id');
            $this->viewData['list_y_method'] = DnaAnalysisType::where('type', 'y')->get()->pluck('name', 'name');
            $this->viewData['list_auto_method'] = DnaAnalysisType::where('type', 'auto')->get()->pluck('name', 'name');
            $this->viewData['list_mito_haplogroup'] = Haplogroup::orderBy('letter')->where('type', 'Mito')->get()->pluck('key', 'id');
            $this->viewData['list_mito_method'] = DnaAnalysisType::where('type', 'mito')->get()->pluck('name', 'name');
            $this->viewData['list_confidence'] = Dna::$results_confidence;





            if ($skeletalelements->user_id == $user->id or $user->isAdmin() or $user->isOrgAdmin() or $user->isProjectManager($skeletalelements->project)) {
                $this->viewData['AcceptButton'] = true;
            }

            /* generals: bone, completeness, side */
            $seGeneralReview = $skeletalelements->reviewByType('general');
            $this->viewData['generalSummary'] = $this->viewGeneralsSummary($skeletalelements, $seGeneralReview);

            /* methods */
            $seMethodReview = $skeletalelements->reviewByType('methods');
            $this->viewData['methodsSummary'] = $this->reviewMethodsSummary($skeletalelements, $seMethodReview);

            /* DNA */
            $seDnaReview = $skeletalelements->reviewByType('dna');
            $this->viewData['dnaSummary'] = $this->reviewDnaSummary($skeletalelements, $seDnaReview);

            /* Taphonomys */
            $seTaphonomyReview = $skeletalelements->reviewByType('taphonomys');
            $this->viewData['taphonomySummary'] = $this->reviewTaphonomySummary($skeletalelements, $seTaphonomyReview);

            /* Zones */
            $seZoneReview = $skeletalelements->reviewByType('zones');
            $this->viewData['zoneSummary'] = $this->reviewZoneSummary($skeletalelements, $seZoneReview);

            /* Measurements */
            $seMeasurementReview = $skeletalelements->reviewByType('measurements');
            $this->viewData['measurementSummary'] = $this->reviewMeasurementSummary($skeletalelements, $seMeasurementReview);

            /* Articulations */
            $seArticulationReview = $skeletalelements->reviewByType('articulations');
            $this->viewData['articulationSummary'] = $this->reviewArticulationSummary($skeletalelements, $seArticulationReview);

            /* Pathology */
            $sePathologyReview = $skeletalelements->reviewByType('pathologys');
            $this->viewData['pathologySummary'] = $this->reviewPathologySummary($skeletalelements, $sePathologyReview);

            $this->ReviewState($skeletalelements);

            if(session()->get('review_tab') == null) {
                if (!$this->viewData['generalSummary']['reviewed']) {
                    $this->viewData['review_tab'] = 'general';
                    $this->viewData['tab_url'] = 'general';
                } elseif (!$this->viewData['methodsSummary']['reviewed']) {
                    $this->viewData['review_tab'] = 'biological';
                    $this->viewData['tab_url'] = 'biologicalprofile';
                } elseif (!$this->viewData['dnaSummary']['reviewed']) {
                    $this->viewData['review_tab'] = 'dna';
                    $this->viewData['tab_url'] = 'dna';
                } elseif (!$this->viewData['taphonomySummary']['reviewed']) {
                    $this->viewData['review_tab'] = 'taphonomy';
                    $this->viewData['tab_url'] = 'taphonomys';
                } elseif (!$this->viewData['zoneSummary']['reviewed']) {
                    $this->viewData['review_tab'] = 'zones';
                    $this->viewData['tab_url'] = 'zones';
                } elseif (!$this->viewData['measurementSummary']['reviewed']) {
                    $this->viewData['review_tab'] = 'measurements';
                    $this->viewData['tab_url'] = 'measurements';
                } elseif (!$this->viewData['articulationSummary']['reviewed']) {
                    $this->viewData['review_tab'] = 'associations';
                    $this->viewData['tab_url'] = 'associations';
                } elseif (!$this->viewData['pathologySummary']['reviewed']) {
                    $this->viewData['review_tab'] = 'pathology';
                    $this->viewData['tab_url'] = 'pathologys';
                } else {
                    $this->viewData['review_tab'] = 'general';
                    $this->viewData['tab_url'] = 'general';
                }
            }else{
                $this->viewData['review_tab'] = session()->get('review_tab');
                $this->viewData['tab_url'] = session()->get('tab_url');
            }

            return view('skeletalelements.review.main', $this->viewData);
        }
    }

    public function reviewGeneral(SkeletalElement $skeletalelements)
    {
        $this->logInfo(__METHOD__, $skeletalelements->id.":".$skeletalelements->key);
        if($this->authorize('browse', [ SkeletalElement::class ])) {
            $this->viewData['skeletalelement'] = $skeletalelements;

            $seGeneralReview = $skeletalelements->reviewByType('general');
            $this->viewData['reviewGenerals'] = !empty($seGeneralReview) ? json_decode($seGeneralReview->review, true) : array();
            $this->viewData['generalSummary'] = $this->viewGeneralsSummary($skeletalelements, $seGeneralReview);

            $this->viewData['AcceptButton'] = false;
            $user = $this->theUser;
            if ($skeletalelements->user_id == $user->id or $user->isAdmin() or $user->isOrgAdmin() or $user->isProjectManager($skeletalelements->project)) {
                $this->viewData['AcceptButton'] = true;
            }
            $this->viewData['SaveButton'] = false;
            if ($skeletalelements->user_id != $user->id or $user->isAdmin() or $user->isOrgAdmin() or $user->isProjectManager($skeletalelements->project)) {
                $this->viewData['SaveButton'] = true;
            }
            $this->viewData['ReviewComplete'] = false;
            if($this->ReviewState($skeletalelements)){
                if ($skeletalelements->user_id != $user->id or $user->isAdmin() or $user->isOrgAdmin() or $user->isProjectManager($skeletalelements->project)) {
                       $this->viewData['ReviewComplete'] = true;
                }
            }
            return view('skeletalelements.review.general', $this->viewData);
        }
    }

    public function storeReviewGeneral(SkeletalElement $skeletalelements, Request $request) 
    {
        $this->logInfo(__METHOD__, $skeletalelements->id.":".$skeletalelements->key);
        if ($this->authorize('add', [SkeletalElement::class])) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            $requestFields = $request->all();
            $originalData = array('sb_id' => $skeletalelements->sb_id, 'side' => $skeletalelements->side, 'completeness' => $skeletalelements->completeness, 'count' => $skeletalelements->count, 'mass' => $skeletalelements->mass);
            $reviewData = array();

            foreach ($originalData as $field => $value) {
                if (array_key_exists($field . '_review', $requestFields)
                    && !empty($requestFields[$field . '_review'])
                    && $value != $requestFields[$field . '_review']) {
                    $reviewData[$field . '_review'] = $requestFields[$field . '_review'];
                }
            }
            try {
                SkeletalElementReview::create([
                    'se_id' => $skeletalelements->id,
                    'type' => 'general',
                    'original' => json_encode($originalData),
                    'review' => json_encode($reviewData)
                ]);
            } catch (QueryException $ex) {
                $this->logQueryException(__METHOD__, $request, $ex);
                Session::flash('alert_message', trans('messages.review_general_unsuccessful'));
                return redirect()->back();
            }

            return redirect('/skeletalelements/' . $skeletalelements->id . '/review')->with('review_tab', 'biological')->with('tab_url', 'biologicalprofile');
        }
    }

    public function storeAcceptReviewGeneral( SkeletalElement $skeletalelements )
    {
        $this->logInfo(__METHOD__, $skeletalelements->id.":".$skeletalelements->key);
        if ($this->authorize('add', [SkeletalElement::class])) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            $seGeneralReview = $skeletalelements->reviewByType('general');
            $reviewGenerals = !empty($seGeneralReview) ? json_decode($seGeneralReview->review, true) : array();
            $generalUpdate = array();
            if( !empty($reviewGenerals['sb_id_review'])){
                $generalUpdate['sb_id'] = $reviewGenerals['sb_id_review'];
            }
            if( !empty($reviewGenerals['side_review'])){
                $generalUpdate['side'] = $reviewGenerals['side_review'];
            }
            if( !empty($reviewGenerals['completeness_review'])){
                $generalUpdate['completeness'] = $reviewGenerals['completeness_review'];
            }
            if( !empty($reviewGenerals['count_review'])){
                $generalUpdate['count'] = $reviewGenerals['count_review'];
            }
            if( !empty($reviewGenerals['mass_review'])){
                $generalUpdate['mass'] = $reviewGenerals['mass_review'];
            }

            $skeletalelements->update($generalUpdate);
            $originalData = array('sb_id' => $skeletalelements->sb_id, 'side' => $skeletalelements->side, 'completeness' => $skeletalelements->completeness, 'count'=>$skeletalelements->count, 'mass'=>$skeletalelements->mass);
            $reviewData = array();
            try {
                SkeletalElementReview::create([
                    'se_id' => $skeletalelements->id,
                    'type' => 'general',
                    'original' => json_encode($originalData),
                    'review' => json_encode($reviewData)
                ]);
            } catch (QueryException $ex) {
                Session::flash('alert_message', trans('messages.review_general_unsuccessful'));
                return redirect()->back();
            }
        }
        return redirect()->back()->with('review_tab', 'biological')->with('tab_url', 'biologicalprofile');
    }

    public function reviewPathology(SkeletalElement $skeletalelements)
    {
        $this->logInfo(__METHOD__, $skeletalelements->id.":".$skeletalelements->key);
        if($this->authorize('browse', [ SkeletalElement::class ])) {
            $this->viewData['skeletalelement'] = $skeletalelements;

            $sePathologyReview = $skeletalelements->reviewByType('pathologys');
            $this->viewData['pathologyReview'] = !empty($sePathologyReview) ? json_decode($sePathologyReview->review, true) : array();
            $this->viewData['pathologySummary'] = $this->reviewPathologySummary($skeletalelements, $sePathologyReview);
            $this->viewData['list_zone'] = Zone::where('sb_id', $skeletalelements->sb_id)->orderBy('display_order')->get()->pluck('display_name', 'id');
            $this->viewData['list_pathology'] = Pathology::orderBy('abnormality_category')->orderBy('characteristics')->get()->pluck('name', 'id');
            $this->viewData['pathologys'] = $skeletalelements->pathologys;
            $this->viewData['list_trauma'] = Trauma::orderBy('timing')->orderBy('type')->get()->pluck('name', 'id');
            $this->viewData['traumas'] = $skeletalelements->traumas;
            $this->viewData['list_anomaly'] = Anomaly::where('sb_id', $skeletalelements->sb_id)->get()->pluck('trait', 'id');

            $this->viewData['AcceptButton'] = false;
            $user = $this->theUser;
            if ($skeletalelements->user_id == $user->id or $user->isAdmin() or $user->isOrgAdmin() or $user->isProjectManager($skeletalelements->project)) {
                $this->viewData['AcceptButton'] = true;
            }
            $this->viewData['SaveButton'] = false;
            if ($skeletalelements->user_id != $user->id or $user->isAdmin() or $user->isOrgAdmin() or $user->isProjectManager($skeletalelements->project)) {
                $this->viewData['SaveButton'] = true;
            }
            $this->viewData['ReviewComplete'] = false;
            if($this->ReviewState($skeletalelements)){
                if ($skeletalelements->user_id != $user->id or $user->isAdmin() or $user->isOrgAdmin() or $user->isProjectManager($skeletalelements->project)) {
                    $this->viewData['ReviewComplete'] = true;
                }
            }
            return view('skeletalelements.review.bonemarkings', $this->viewData);
        }
    }

    public function storeReviewPathology(SkeletalElement $skeletalelements, Request $request)
    {
        $this->logInfo(__METHOD__, $skeletalelements->id.":".$skeletalelements->key);
        if ($this->authorize('add', [SkeletalElement::class])) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            $storageArray = array('original' => array(), 'review' => array());
            $requestFields = $request->all();
            if (!empty($requestFields['pathologys']['original']['se_pathology_id'])) {
                foreach ($requestFields['pathologys']['original']['se_pathology_id'] as $id => $original) {
                    $originalZone = $original['zone'];
                    $reviewZone = !empty($requestFields['pathologys']['review']['se_pathology_id'][$id]['zone']) ? $requestFields['pathologys']['review']['se_pathology_id'][$id]['zone'] : null;
                    if (!empty($originalZone) && !empty($reviewZone) && $originalZone != $reviewZone) {
                        $storageArray['original']['pathology'] = $requestFields['pathologys']['original'];
                        $storageArray['review']['pathology'] = $requestFields['pathologys']['review'];
                        break;
                    }
                    $originalPathology = $original['pathologyid'];
                    $reviewPathology = !empty($requestFields['pathologys']['review']['se_pathology_id'][$id]['pathologyid']) ? $requestFields['pathologys']['review']['se_pathology_id'][$id]['pathologyid'] : null;
                    if (!empty($originalPathology) && !empty($reviewPathology) && $originalPathology != $reviewPathology) {
                        $storageArray['original']['pathology'] = $requestFields['pathologys']['original'];
                        $storageArray['review']['pathology'] = $requestFields['pathologys']['review'];
                        break;
                    }
                    $originalInfo = $original['additionalinfo'];
                    $reviewInfo = !empty($requestFields['pathologys']['review']['se_pathology_id'][$id]['additionalinfo']) ? $requestFields['pathologys']['review']['se_pathology_id'][$id]['additionalinfo'] : null;
                    if (!empty($originalInfo) && !empty($reviewInfo) && $originalInfo != $reviewInfo) {
                        $storageArray['original']['pathology'] = $requestFields['pathologys']['original'];
                        $storageArray['review']['pathology'] = $requestFields['pathologys']['review'];
                        break;
                    }
                }
            }

            if (!empty($requestFields['traumas']['original']['se_trauma_id'])) {
                foreach ($requestFields['traumas']['original']['se_trauma_id'] as $id => $original) {
                    $originalZone = $original['zone'];
                    $reviewZone = !empty($requestFields['traumas']['review']['se_trauma_id'][$id]['zone']) ? $requestFields['traumas']['review']['se_trauma_id'][$id]['zone'] : null;
                    if (!empty($originalZone) && !empty($reviewZone) && $originalZone != $reviewZone) {
                        $storageArray['original']['trauma'] = $requestFields['traumas']['original'];
                        $storageArray['review']['trauma'] = $requestFields['traumas']['review'];
                        break;
                    }
                    $originalTrauma = $original['traumaid'];
                    $reviewTrauma = !empty($requestFields['traumas']['review']['se_trauma_id'][$id]['traumaid']) ? $requestFields['traumas']['review']['se_trauma_id'][$id]['traumaid'] : null;
                    if (!empty($originalTrauma) && !empty($reviewTrauma) && $originalTrauma != $reviewTrauma) {
                        $storageArray['original']['trauma'] = $requestFields['traumas']['original'];
                        $storageArray['review']['trauma'] = $requestFields['traumas']['review'];
                        break;
                    }
                    $originalInfo = $original['additionalinfo'];
                    $reviewInfo = !empty($requestFields['traumas']['review']['se_trauma_id'][$id]['additionalinfo']) ? $requestFields['traumas']['review']['se_trauma_id'][$id]['additionalinfo'] : null;
                    if (!empty($originalInfo) && !empty($reviewInfo) && $originalInfo != $reviewInfo) {
                        $storageArray['original']['trauma'] = $requestFields['traumas']['original'];
                        $storageArray['review']['trauma'] = $requestFields['traumas']['review'];
                        break;
                    }
                }
            }

            $anomalysOriginalList = array();
            $anomalysOriginal = $skeletalelements->anomalys;
            if (count($anomalysOriginal) > 0) {
                foreach ($anomalysOriginal as $a) {
                    $anomalysOriginalList[] = $a->id;
                }
            }

            $anomalysreviewList = !empty($request->input('anomalylistreview')) ? $request->input('anomalylistreview') : array();

            $anomalysReviewList = array_map('intval', $anomalysreviewList);

            sort($anomalysOriginalList);
            sort($anomalysReviewList);

            if ($anomalysOriginalList != $anomalysReviewList) {
                $storageArray['original']['anomaly'] = $anomalysOriginalList;
                $storageArray['review']['anomaly'] = $anomalysReviewList;
            }

            try {
                SkeletalElementReview::create([
                    'se_id' => $skeletalelements->id,
                    'type' => 'pathologys',
                    'original' => json_encode($storageArray['original']),
                    'review' => json_encode($storageArray['review'])
                ]);
            } catch (QueryException $ex) {
                $this->logQueryException(__METHOD__, $request, $ex);
                Session::flash('alert_message', trans('messages.review_pathology_unsuccessful'));
                return redirect()->back();
            }

            return redirect('/skeletalelements/' . $skeletalelements->id . '/review')->with('review_tab', 'general')->with('tab_url', 'general');
        }
    }

    public function storeAcceptReviewPathology( SkeletalElement $skeletalelements)
    {
        $this->logInfo(__METHOD__, $skeletalelements->id.":".$skeletalelements->key);
        if ($this->authorize('add', [SkeletalElement::class])) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);


            $seGeneralReview = $skeletalelements->reviewByType('general');
            $reviewGenerals = !empty($seGeneralReview) ? json_decode($seGeneralReview->review, true) : array();

            $sePathologyReview = $skeletalelements->reviewByType('pathologys');
            $pathologyReview = !empty($sePathologyReview) ? json_decode($sePathologyReview->review, true) : array();

            if ( !empty($pathologyReview['pathology'])){
                foreach($pathologyReview['pathology']['se_pathology_id'] as $pathology_id => $pathology){
                    $skeletalelements->pathologys()->updateExistingPivot($pathology_id, ['zone_id' => $pathology['zone'], 'pathology_id' => $pathology['pathologyid'], 'additional_information' => $pathology['additionalinfo']]);
                }
            }
            if ( !empty($pathologyReview['trauma'])){
                foreach($pathologyReview['trauma']['se_trauma_id'] as $trauma_id => $trauma){
                    $skeletalelements->traumas()->updateExistingPivot($trauma_id, ['zone_id' => $trauma['zone'], 'trauma_id' => $trauma['traumaid'], 'additional_information' => $trauma['additionalinfo']]);
                }
            }
            if ( !empty($pathologyReview['anomaly'])){
                $this->syncAnomalys($skeletalelements, $pathologyReview['anomaly']);
            }

            $originalData = array('pathology' => array(), 'trauma' => array());

            $originalData['pathology']['se_pathology_id'] = array();
            foreach( $skeletalelements->pathologys()->get() as $pathology)
            {
                $originalData['pathology']['se_pathology_id'][$pathology->id] = array('zone' => $pathology->zone_id, 'pathologyid' => $pathology->pathology_id, 'additionalinfo' => $pathology->additional_infomation);

            }
            $originalData['trauma']['se_trauma_id'] = array();
            foreach( $skeletalelements->traumas()->get() as $trauma)
            {
                $originalData['trauma']['se_trauma_id'][$trauma->id] = array('zone' => $pathology->zone_id, 'pathologyid' => $pathology->pathology_id, 'additionalinfo' => $pathology->additional_infomation);
            }
            $originalData['anomaly'] = array($skeletalelements->getAnomalyListAttribute());

            try {
                SkeletalElementReview::create([
                    'se_id' => $skeletalelements->id,
                    'type' => 'pathologys',
                    'original' => json_encode($originalData),
                    'review' => json_encode(array())
                ]);
            } catch (QueryException $ex) {
                Session::flash('alert_message', trans('messages.review_general_unsuccessful'));
                return redirect()->back();
            }
        }
        return redirect()->back()->with('review_tab', 'general')->with('tab_url', 'general');
    }

    public function reviewBiologicalProfile(SkeletalElement $skeletalelements)
    {
        $this->logInfo(__METHOD__, $skeletalelements->id.":".$skeletalelements->key);
        if($this->authorize('browse', [ SkeletalElement::class ])) {
            $this->viewData['skeletalelement'] = $skeletalelements;

            $origAgeMethods = $skeletalelements->methodsByType('Age');
            $origSexMethods = $skeletalelements->methodsByType('Sex');
            $origDnaMethods = $skeletalelements->methodsByType('Dna');
            $origAncestryMethods = $skeletalelements->methodsByType('Ancestry');
            $this->viewData['origAgeMethods'] = !empty($origAgeMethods) ? $origAgeMethods : array();
            $this->viewData['origSexMethods'] = !empty($origSexMethods) ? $origSexMethods : array();
            $this->viewData['origDnaMethods'] = !empty($origDnaMethods) ? $origDnaMethods : array();
            $this->viewData['origAncestryMethods'] = !empty($origAncestryMethods) ? $origAncestryMethods : array();
            $seMethodReview = $skeletalelements->reviewByType('methods');
            $this->viewData['methodsSummary'] = $this->reviewMethodsSummary($skeletalelements, $seMethodReview);
            $this->viewData['reviewMethods'] = !empty($seMethodReview) ? json_decode($seMethodReview->review, true) : array();


            $this->viewData['AcceptButton'] = false;
            $user = $this->theUser;
            if ($skeletalelements->user_id == $user->id or $user->isAdmin() or $user->isOrgAdmin() or $user->isProjectManager($skeletalelements->project)) {
                $this->viewData['AcceptButton'] = true;
            }
            $this->viewData['SaveButton'] = false;
            if ($skeletalelements->user_id != $user->id or $user->isAdmin() or $user->isOrgAdmin() or $user->isProjectManager($skeletalelements->project)) {
                $this->viewData['SaveButton'] = true;
            }
            $this->viewData['ReviewComplete'] = false;
            if($this->ReviewState($skeletalelements)){
                if ($skeletalelements->user_id != $user->id or $user->isAdmin() or $user->isOrgAdmin() or $user->isProjectManager($skeletalelements->project)) {
                    $this->viewData['ReviewComplete'] = true;
                }
            }
            return view('skeletalelements.review.biological', $this->viewData);
        }

    }

    public function storeReviewBiologicalProfile(SkeletalElement $skeletalelements, Request $request)
    {
        $this->logInfo(__METHOD__, $skeletalelements->id.":".$skeletalelements->key);
        if ($this->authorize('add', [SkeletalElement::class])) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);

            $reviewMethodFeatures = Input::get('featurereview', array());
            $storageArray = array('original' => array('methods' => array()), 'review' => array('methods' => array()));

            $origAgeMethods = $skeletalelements->methodsByType('Age');
            if (!empty($origAgeMethods)) {
                $this->originalMethodsToArray($origAgeMethods, $skeletalelements, $reviewMethodFeatures, $storageArray);
            }

            $origSexMethods = $skeletalelements->methodsByType('Sex');
            if (!empty($origSexMethods)) {
                $this->originalMethodsToArray($origSexMethods, $skeletalelements, $reviewMethodFeatures, $storageArray);
            }

            $origAncestryMethods = $skeletalelements->methodsByType('Ancestry');
            if (!empty($origAncestryMethods)) {
                $this->originalMethodsToArray($origAncestryMethods, $skeletalelements, $reviewMethodFeatures, $storageArray);
            }

            try {
                SkeletalElementReview::create([
                    'se_id' => $skeletalelements->id,
                    'type' => 'methods',
                    'original' => json_encode($storageArray['original']),
                    'review' => json_encode($storageArray['review'])
                ]);
            } catch (QueryException $ex) {
                Session::flash('alert_message', trans('messages.review_biological_unsuccessful'));
                return redirect()->back();
            }

            return redirect('/skeletalelements/' . $skeletalelements->id . '/review')->with('review_tab', 'dna')->with('tab_url', 'dna');
        }
    }

    public function storeAcceptReviewBiologicalProfile( SkeletalElement $skeletalelements)
    {
        $this->logInfo(__METHOD__, $skeletalelements->id.":".$skeletalelements->key);
        if ($this->authorize('add', [SkeletalElement::class])) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            $seMethodReview = $skeletalelements->reviewByType('methods');
            $reviewMethods = !empty($seMethodReview) ? json_decode($seMethodReview->review, true) : array();

            foreach( $reviewMethods['methods'] as $method_id=>$method )
            {
                foreach($method['features'] as $method_feature_id=>$method_feature)
                {
                    $skeletalelements->methodfeatures()->updateExistingPivot($method_feature_id, $method_feature);
                }
            }

            $storageArray = array('methods' => array());
            foreach($skeletalelements->methods()->get() as $method)
            {
                $storageArray['methods'][$method->id] = array('features' => array());
                foreach($skeletalelements->methodfeaturesByMethod($method->id) as $method_feature){
                    $storageArray['methods'][$method->id]['features'][$method_feature->id] = array('score' => $method_feature->score);
                }
            }

            try {
                SkeletalElementReview::create([
                    'se_id' => $skeletalelements->id,
                    'type' => 'methods',
                    'original' => json_encode($storageArray),
                    'review' => json_encode(array() )
                ]);
            } catch (QueryException $ex) {
                Session::flash('alert_message', trans('messages.review_biological_unsuccessful'));
                return redirect()->back()->with('review_tab', 'dna')->with('tab_url', 'dna');
            }
        }
        return redirect()->back();
    }

    public function reviewTaphonomys(SkeletalElement $skeletalelements)
    {
        $this->logInfo(__METHOD__, $skeletalelements->id.":".$skeletalelements->key);
        if($this->authorize('browse', [ SkeletalElement::class ])) {
            $this->viewData['skeletalelement'] = $skeletalelements;

            $this->viewData['list_taphonomy'] = Taphonomy::all()->pluck('name_without_branch', 'id');
            $seTaphonomyReview = $skeletalelements->reviewByType('taphonomys');
            $this->viewData['taphonomyreviewlist'] = !empty($seTaphonomyReview) ? json_decode($seTaphonomyReview->review, true) : array();
            $this->viewData['taphonomySummary'] = $this->reviewTaphonomySummary($skeletalelements, $seTaphonomyReview);

            $this->viewData['AcceptButton'] = false;
            $user = $this->theUser;
            if ($skeletalelements->user_id == $user->id or $user->isAdmin() or $user->isOrgAdmin() or $user->isProjectManager($skeletalelements->project)) {
                $this->viewData['AcceptButton'] = true;
            }
            $this->viewData['SaveButton'] = false;
            if ($skeletalelements->user_id != $user->id or $user->isAdmin() or $user->isOrgAdmin() or $user->isProjectManager($skeletalelements->project)) {
                $this->viewData['SaveButton'] = true;
            }
            $this->viewData['ReviewComplete'] = false;
            if($this->ReviewState($skeletalelements)){
                if ($skeletalelements->user_id != $user->id or $user->isAdmin() or $user->isOrgAdmin() or $user->isProjectManager($skeletalelements->project)) {
                    $this->viewData['ReviewComplete'] = true;
                }
            }
            return view('skeletalelements.review.taphonomys', $this->viewData);
        }
    }
    
    public function storeReviewTaphonomys(SkeletalElement $skeletalelements, Request $request) 
    {
        $this->logInfo(__METHOD__, $skeletalelements->id.":".$skeletalelements->key);
        if ($this->authorize('add', [SkeletalElement::class])) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);

            $taphonomyOriginalList = collect($skeletalelements->taphonomys->pluck('id')->all());
            $taphonomyreviewList = !empty($request->input('taphonomyreviewlist')) ? $request->input('taphonomyreviewlist') : array();

            $taphonomyReviewList = collect(array_map('intval', $taphonomyreviewList));
            $diff = $taphonomyOriginalList->diff($taphonomyReviewList);

            if (count($diff->all()) > 0) {
                SkeletalElementReview::create([
                    'se_id' => $skeletalelements->id,
                    'type' => 'taphonomys',
                    'original' => $taphonomyOriginalList->toJson(),
                    'review' => $taphonomyReviewList->toJson()
                ]);
            }
            try {
                SkeletalElementReview::create([
                    'se_id' => $skeletalelements->id,
                    'type' => 'taphonomys',
                    'original' => $taphonomyOriginalList->toJson(),
                    'review' => $taphonomyReviewList->toJson()
                ]);
            } catch (QueryException $ex) {
                $this->logQueryException(__METHOD__, $request, $ex);
                Session::flash('alert_message', trans('messages.review_taphonomies_unsuccessful'));
                return redirect()->back();
            }
            return redirect('/skeletalelements/' . $skeletalelements->id . '/review')->with('review_tab', 'zones')->with('tab_url', 'zones');
        }
    }

    public function storeAcceptReviewTaphonomys( SkeletalElement $skeletalelements)
    {
        $this->logInfo(__METHOD__, $skeletalelements->id.":".$skeletalelements->key);
        if ($this->authorize('add', [SkeletalElement::class]))
        {
            $seTaphonomyReview = $skeletalelements->reviewByType('taphonomys');
            $taphonomyreviewlist = !empty($seTaphonomyReview) ? json_decode($seTaphonomyReview->review, true) : array();
            $this->syncTaphomonys($skeletalelements, $taphonomyreviewlist);

            $taphonomys = $skeletalelements->taphonomys->pluck('id')->all();
            try {
                SkeletalElementReview::create([
                    'se_id' => $skeletalelements->id,
                    'type' => 'taphonomys',
                    'original' => json_encode($taphonomys),
                    'review' => json_encode(array())
                ]);
            } catch (QueryException $ex) {
                Session::flash('alert_message', trans('messages.review_taphonomies_unsuccessful'));
                return redirect()->back();
            }
        }

        return redirect()->back()->with('review_tab', 'zones')->with('tab_url', 'zones');
    }

    public function reviewDNA(SkeletalElement $skeletalelements)
    {
        $this->logInfo(__METHOD__, $skeletalelements->id.":".$skeletalelements->key);
        if($this->authorize('browse', [ SkeletalElement::class ])) {
            $this->viewData['skeletalelement'] = $skeletalelements;

            $this->viewData['list_haplogroup'] = Haplogroup::orderBy('letter')->get()->pluck('hg', 'id');
            $seDnaReview = $skeletalelements->reviewByType('dna');
            $this->viewData['dnaSummary'] = $this->reviewDnaSummary($skeletalelements, $seDnaReview);
            $this->viewData['dnas'] = $skeletalelements->dnas;
            $this->viewData['dnaReview'] = !empty($seDnaReview) ? json_decode($seDnaReview->review, true) : array();


            $this->viewData['AcceptButton'] = false;
            $user = $this->theUser;
            if ($skeletalelements->user_id == $user->id or $user->isAdmin() or $user->isOrgAdmin() or $user->isProjectManager($skeletalelements->project)) {
                $this->viewData['AcceptButton'] = true;
            }
            $this->viewData['SaveButton'] = false;
            if ($skeletalelements->user_id != $user->id or $user->isAdmin() or $user->isOrgAdmin() or $user->isProjectManager($skeletalelements->project)) {
                $this->viewData['SaveButton'] = true;
            }
            $this->viewData['ReviewComplete'] = false;
            if($this->ReviewState($skeletalelements)){
                if ($skeletalelements->user_id != $user->id or $user->isAdmin() or $user->isOrgAdmin() or $user->isProjectManager($skeletalelements->project)) {
                    $this->viewData['ReviewComplete'] = true;
                }
            }
            return view('skeletalelements.review.dna', $this->viewData);
        }
    }
    
    public function storeReviewDNA(SkeletalElement $skeletalelements, Request $request) 
    {
        $this->logInfo(__METHOD__, $skeletalelements->id.":".$skeletalelements->key);
        if ($this->authorize('add', [SkeletalElement::class])) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            $requestFields = $request->all();
            $originalData = array();
            $reviewData = array();


            if(!empty($requestFields['dnas']['original']['se_dna_id']))
            {
                foreach( $requestFields['dnas']['original']['se_dna_id'] as $id => $original)
                {
                    foreach( $requestFields['dnas']['original']['se_dna_id'][$id] as $field => $value)
                    {
                        $originalData[$id][$field] = $value;
                        if($requestFields['dnas']['review']['se_dna_id'][$id][$field] != null) {
                            $reviewData[$id][$field] = $requestFields['dnas']['review']['se_dna_id'][$id][$field];
                        }
                    }
                }
            }

            try {
                SkeletalElementReview::create([
                    'se_id' => $skeletalelements->id,
                    'type' => 'dna',
                    'original' => json_encode($originalData),
                    'review' => json_encode($reviewData)
                ]);
            } catch (QueryException $ex) {
                $this->logQueryException(__METHOD__, $request, $ex);
                Session::flash('alert_message', trans('messages.review_dna_unsuccessful'));
                return redirect()->back();
            }

            return redirect('/skeletalelements/' . $skeletalelements->id . '/review')->with('review_tab', 'taphonomy')->with('tab_url', 'taphonomys');
        }
    }

    public function storeAcceptReviewDNA( SkeletalElement $skeletalelements)
    {
        $this->logInfo(__METHOD__, $skeletalelements->id.":".$skeletalelements->key);
        if ($this->authorize('add', [SkeletalElement::class]))
        {
            $seDnaReview = $skeletalelements->reviewByType('dna');
            $dnaReview = array();
            if (!empty($seDnaReview)) {
                $dnaData = json_decode($seDnaReview->review, true);
                foreach ($dnaData as $k => $v) {
                    $dnaReview[$k] = $v;
                    $skeletalelements->dnas()->where('id', $k)->update($v);
                }
            }

            $originalData = array();
            foreach( $skeletalelements->dnas() as $dna_id => $dna )
            {
                $originalData[$dna_id] = array('lab_id' => $dna->lab_id, 'external_case_id' => $dna->external_case_id, 'mito_sequence_number' => $dna->mito_sequence_number,
                    'mito_sequence_subgroup' => $dna->mito_sequence_subgroup, 'mito_sequence_similar' => $dna->mito_sequence_similar,
                    'mito_match_count' => $dna->mito_match_count, 'mito_total_count' => $dna->mito_total_count, 'mito_receive_date' => $dna->mito_receive_date,
                    'mito_haplogroup_id' => $dna->mito_haplogroup_id, 'mito_results_confidence' => $dna->mito_results_confidence, 'num_loci' => $dna->num_loci,
                    'mcc_date' => $dna->mcc_date, 'method' => $dna->method, 'sample_number' => $dna->sample_number);
            }


            try {
                SkeletalElementReview::create([
                    'se_id' => $skeletalelements->id,
                    'type' => 'dna',
                    'original' => json_encode($originalData),
                    'review' => json_encode(array())
                ]);
            } catch (QueryException $ex) {
                Session::flash('alert_message', trans('messages.review_dna_unsuccessful'));
                return redirect()->back();
            }

        }
        return redirect()->back()->with('review_tab', 'taphonomy')->with('tab_url', 'taphonomys');
    }

    public function reviewAssociations(SkeletalElement $skeletalelements)
    {
        $object = $skeletalelements;
        $this->logInfo(__METHOD__, $skeletalelements->id.":".$skeletalelements->key);
        if($this->authorize('browse', [ SkeletalElement::class ])) {
            $this->viewData['skeletalelement'] = $skeletalelements;

            $this->viewData['list_se'] = SkeletalElement::all()->except($skeletalelements->id)->pluck('key_bone_side', 'id'); // ToDo: What is this line of code.
            $list = $object->getAllPossiblePairMatches();
            if (isset($list)) {
                $this->viewData['list_se_pair_matches'] = $list->pluck('key_bone_side', 'id');
            }
            $list = $object->getAllPossibleArticulations();
            if (isset($list)) {
                $this->viewData['list_se_articulations'] = $list->pluck('key_bone_side', 'id');
            }
            $list = $object->getAllPossibleRefits();
            if (isset($list)) {
                $this->viewData['list_se_refits'] = $list->pluck('key_bone_side', 'id');
            }

            $seArticulationReview = $skeletalelements->reviewByType('articulations');
            $sePairMatchesReview = $skeletalelements->reviewByType('pairmatches');
            $seRefitsReview = $skeletalelements->reviewByType('refits');


            $this->viewData['articulationsReviewList'] = !empty($seArticulationReview) ? json_decode($seArticulationReview->review, true) : array();
            $this->viewData['paiMatchesReviewList'] = !empty($sePairMatchesReview) ? json_decode($sePairMatchesReview->review, true) : array();
            $this->viewData['refitsReviewList'] = !empty($seRefitsReview) ? json_decode($seRefitsReview->review, true) : array();
            $this->viewData['articulationSummary'] = $this->reviewArticulationSummary($skeletalelements, $seArticulationReview);
            $this->viewData['pair_matches'] = $skeletalelements->AllPairs->pluck('id');
            $this->viewData['refits'] = $skeletalelements->refits()->pluck('id');

            $this->viewData['AcceptButton'] = false;
            $user = $this->theUser;
            if ($skeletalelements->user_id == $user->id or $user->isAdmin() or $user->isOrgAdmin() or $user->isProjectManager($skeletalelements->project)) {
                $this->viewData['AcceptButton'] = true;
            }
            $this->viewData['SaveButton'] = false;
            if ($skeletalelements->user_id != $user->id or $user->isAdmin() or $user->isOrgAdmin() or $user->isProjectManager($skeletalelements->project)) {
                $this->viewData['SaveButton'] = true;
            }
            $this->viewData['ReviewComplete'] = false;
            if($this->ReviewState($skeletalelements)){
                if ($skeletalelements->user_id != $user->id or $user->isAdmin() or $user->isOrgAdmin() or $user->isProjectManager($skeletalelements->project)) {
                    $this->viewData['ReviewComplete'] = true;
                }
            }
            return view('skeletalelements.review.associations', $this->viewData);
        }
    }
    
    public function storeReviewAssociations(SkeletalElement $skeletalelements, Request $request)
    {
        $this->logInfo(__METHOD__, $skeletalelements->id.":".$skeletalelements->key);
        if ($this->authorize('add', [SkeletalElement::class])) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);


            $originalArray = array();
            $reviewArray = array();
            $type = null;

            switch ($request->input('action')) {
                case 'acceptArticulation':
                case 'acceptPairMatching':
                case 'acceptRefits':
                    $this->storeAcceptReviewAssociations($skeletalelements, $request);
                    break;
                case 'saveArticulation':
                    $originalArticulations = $skeletalelements->articulations->pluck('id')->toArray();
                    $reviewArticulations = array_map('intval', Input::get('articulationreviewlist', array()));
                    sort($originalArticulations);
                    sort($reviewArticulations);
                    $originalArray = $originalArticulations;
                    $reviewArray = $reviewArticulations;
                    $type='articulations';
                    break;
                case 'savePairMatching':
                    $originalPairMatches = $skeletalelements->pairs()->pluck('id')->toArray();
                    $reviewPairMatches = array_map('intval', Input::get('pairmatchingreviewlist', array()));
                    sort($originalPairMatches);
                    sort($reviewPairMatches);
                    $originalArray = $originalPairMatches;
                    $reviewArray = $reviewPairMatches;
                    $type='pairmatches';
                    break;
                case 'saveRefits':
                    $originalRefits = $skeletalelements->refits()->pluck('id')->toArray();
                    $reviewRefits = array_map('intval', Input::get('refitsreviewlist', array()));
                    sort($originalRefits);
                    sort($reviewRefits);
                    $originalArray = $originalRefits;
                    $reviewArray = $reviewRefits;
                    $type='refits';
                    break;
            }

            if($type){
                $this->createSkeletalElementReview($skeletalelements, $type, $originalArray, $reviewArray);
            }

            return redirect('/skeletalelements/' . $skeletalelements->id . '/review')->with('review_tab', 'pathology')->with('tab_url', 'pathologys');
        }
    }

    // internal function to create Skeletal Element Review
    protected function createSkeletalElementReview(SkeletalElement $skeletalElement, $type, $originalArray, $reviewArray){
        try {
            SkeletalElementReview::create([
                'se_id' => $skeletalElement->id,
                'type' => $type,
                'original' => json_encode($originalArray),
                'review' => json_encode($reviewArray)
            ]);
        } catch (QueryException $ex) {
            Session::flash('alert_message', trans('messages.review_articulations_unsuccessful'));
        }
    }

    public function storeAcceptReviewAssociations( SkeletalElement $skeletalelements, Request $request)
    {
        $this->logInfo(__METHOD__, $skeletalelements->id.":".$skeletalelements->key);
        if ($this->authorize('add', [SkeletalElement::class]))
        {
            //check where the request is coming from e.g Articulation, Refits, Pair Matching
            switch ($request->input('action')) {
                case 'acceptArticulation':
                    $type = 'articulations';
                    $seArticulationReview = $skeletalelements->reviewByType('articulations');
                    $articulationsReviewList = !empty($seArticulationReview) ? json_decode($seArticulationReview->review, true) : array();
                    if( !empty($articulationsReviewList)) {
                        $this->syncArticulations($skeletalelements, $articulationsReviewList);
                    }
                    $originalArray = $skeletalelements->articulations->pluck('id')->toArray();
                    sort($originalArray);
                    $this->createSkeletalElementReview($skeletalelements, $type, $originalArray, array());
                    break;
                case 'acceptPairMatching':
                    $type = 'pairmatches';
                    $sePairMatchesReview = $skeletalelements->reviewByType('pairmatches');
                    $pairMatchesReviewList = !empty($sePairMatchesReview) ? json_decode($sePairMatchesReview->review, true) : array();
                    if( !empty($pairMatchesReviewList)){
                        $this->syncPairs($skeletalelements, $pairMatchesReviewList);
                    }
                    $originalArray = $skeletalelements->pairs()->pluck('id')->toArray();
                    sort($originalArray);
                    $this->createSkeletalElementReview($skeletalelements, $type, $originalArray, array());
                    break;
                case 'acceptRefits':
                    $type = 'refits';
                    $seRefitsReview = $skeletalelements->reviewByType('refits');
                    $refitsReviewList = !empty($seRefitsReview) ? json_decode($seRefitsReview->review, true) : array();
                    if( !empty($refitsReviewList)){
                        $this->syncRefits($skeletalelements, $refitsReviewList);
                    }
                    $originalArray = $skeletalelements->refits()->pluck('id')->toArray();
                    sort($originalArray);
                    $this->createSkeletalElementReview($skeletalelements, $type, $originalArray, array());
                    break;
            }

        }
        return redirect()->back()->with('review_tab', 'pathology')->with('tab_url', 'pathologys');
    }

    public function reviewZones(SkeletalElement $skeletalelements)
    {
        $this->logInfo(__METHOD__, $skeletalelements->id.":".$skeletalelements->key);
        if($this->authorize('browse', [ SkeletalElement::class ])) {
            $this->viewData['skeletalelement'] = $skeletalelements;

            $seZoneReview = $skeletalelements->reviewByType('zones');
            $this->viewData['zonesreview'] = !empty($seZoneReview) ? json_decode($seZoneReview->review, true) : array();
            $this->viewData['zones'] = Zone::where('sb_id', $skeletalelements->sb_id)->orderBy('display_order')->get();
            $this->viewData['zoneSummary'] = $this->reviewZoneSummary($skeletalelements, $seZoneReview);

            $this->viewData['AcceptButton'] = false;
            $user = $this->theUser;
            if ($skeletalelements->user_id == $user->id or $user->isAdmin() or $user->isOrgAdmin() or $user->isProjectManager($skeletalelements->project)) {
                $this->viewData['AcceptButton'] = true;
            }
            $this->viewData['SaveButton'] = false;
            if ($skeletalelements->user_id != $user->id or $user->isAdmin() or $user->isOrgAdmin() or $user->isProjectManager($skeletalelements->project)) {
                $this->viewData['SaveButton'] = true;
            }
            $this->viewData['ReviewComplete'] = false;
            if($this->ReviewState($skeletalelements)){
                if ($skeletalelements->user_id != $user->id or $user->isAdmin() or $user->isOrgAdmin() or $user->isProjectManager($skeletalelements->project)) {
                    $this->viewData['ReviewComplete'] = true;
                }
            }
            return view('skeletalelements.review.zone', $this->viewData);
        }
    }

    public function storeReviewZones(SkeletalElement $skeletalelements, Request $request)
    {
        $this->logInfo(__METHOD__, $skeletalelements->id.":".$skeletalelements->key);
        if ($this->authorize('add', [SkeletalElement::class])) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);

            // check if request is for save or accept; if accept call Accept function, otherwise continue
            switch ($request->input('action')) {
                case 'Accept':
                    $this->storeAcceptReviewZones($skeletalelements, $request);
                    break;
                case 'Save':
                    break;
            }

            $originalZones = $skeletalelements->zones->pluck('id')->all();
            $reviewZones = Input::get('zonesreview', array());
            $reviewZones = array_keys($this->removeElementWithValue($reviewZones, "presence", ""));

            sort($originalZones);
            sort($reviewZones);

//        if ($originalZones != $reviewZones) {
//            SkeletalElementReview::create([
//                'se_id'=>$skeletalelements->id, 
//                'type'=>'zones', 
//                'original'=>json_encode($originalZones),
//                'review'=>json_encode($reviewZones)
//            ]);
//        }
            SkeletalElementReview::create([
                'se_id' => $skeletalelements->id,
                'type' => 'zones',
                'original' => json_encode($originalZones),
                'review' => json_encode($reviewZones)
            ]);
            return redirect('/skeletalelements/' . $skeletalelements->id . '/review')->with('review_tab', 'measurements')->with('tab_url', 'measurements');
        }
    }

    public function storeAcceptReviewZones( SkeletalElement $skeletalelements, Request $request )
    {
        $this->logInfo(__METHOD__, $skeletalelements->id.":".$skeletalelements->key);
        if ($this->authorize('add', [SkeletalElement::class]))
        {
            $zones = Zone::where('sb_id', $skeletalelements->sb_id)->get(); //zones for this $skeletalelements

           // This will select the values from request where name is zonesreview
           $zonesreview = $request->input('zonesreview');
           // Removes the values that present => false
           $zonesreview = array_keys($this->removeElementWithValue($zonesreview, "presence", ""));


            foreach($zones as $zone)
            {
                 if(in_array($zone->id, $zonesreview))
                 {

                     //if the zone ID is in the array we received
                     if($skeletalelements->zones()->where('zone_id', $zone->id)->exists()){
                         // update $skeletalelements pivot table if the zone
                         $skeletalelements->zones()->updateExistingPivot($zone->id, ['presence' => true]);
                     }else{
                         //if it's not present $skeletalelements->zones attach a new one
                         $skeletalelements->zones()->attach($zone->id,['presence' => true, 'org_id' =>$skeletalelements->org_id, 'project_id' => $skeletalelements->project_id]);
                     }
                 }else{
                     if($skeletalelements->zones()->where('zone_id', $zone->id)->exists()){
                         // if the zone already exists and it shows present, change the flag presence false
                         $skeletalelements->zones()->updateExistingPivot($zone->id, ['presence' => false]);
                     }
                 }
            }

            try {
                SkeletalElementReview::create([
                    'se_id' => $skeletalelements->id,
                    'type' => 'zones',
                    'original' => json_encode($zonesreview),
                    'review' => json_encode($zonesreview)
                ]);
            } catch (QueryException $ex) {
                Session::flash('alert_message', trans('messages.review_zones_unsuccessful'));
                return redirect()->back();
            }
        }
        return redirect()->back()->with('review_tab', 'measurements')->with('tab_url', 'measurements');
    }

    public function reviewMeasurements(SkeletalElement $skeletalelements)
    {
        $this->logInfo(__METHOD__, $skeletalelements->id.":".$skeletalelements->key);
        if($this->authorize('browse', [ SkeletalElement::class ])) {
            $this->viewData['skeletalelement'] = $skeletalelements;

            $this->viewData['measurements'] = Measurement::where('sb_id', $skeletalelements->sb_id)->orderBy('display_order')->get();
            $seMeasurementReview = $skeletalelements->reviewByType('measurements');
            $this->viewData['reviewMeasurements'] = !empty($seMeasurementReview) ? json_decode($seMeasurementReview->review, true) : array();
            $this->viewData['measurementSummary'] = $this->reviewMeasurementSummary($skeletalelements, $seMeasurementReview);

            $this->viewData['AcceptButton'] = false;
            $user = $this->theUser;
            if ($skeletalelements->user_id == $user->id or $user->isAdmin() or $user->isOrgAdmin() or $user->isProjectManager($skeletalelements->project)) {
                $this->viewData['AcceptButton'] = true;
            }
            $this->viewData['SaveButton'] = false;
            if ($skeletalelements->user_id != $user->id or $user->isAdmin() or $user->isOrgAdmin() or $user->isProjectManager($skeletalelements->project)) {
                $this->viewData['SaveButton'] = true;
            }
            $this->viewData['ReviewComplete'] = false;
            if($this->ReviewState($skeletalelements)){
                if ($skeletalelements->user_id != $user->id or $user->isAdmin() or $user->isOrgAdmin() or $user->isProjectManager($skeletalelements->project)) {
                    $this->viewData['ReviewComplete'] = true;
                }
            }
            return view('skeletalelements.review.measurements', $this->viewData);
        }
    }
    
    public function storeReviewMeasurements(SkeletalElement $skeletalelements, Request $request)
    {
        $this->logInfo(__METHOD__, $skeletalelements->id.":".$skeletalelements->key);
        if ($this->authorize('add', [SkeletalElement::class])) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);

            // check if request is for save or accept; if accept call Accept function, otherwise continue
            switch ($request->input('action')) {
                case 'Accept':
                    $this->storeAcceptReviewMeasurements($skeletalelements, $request);
                    break;
                case 'Save':
                    break;
            }

            $originalMeasurementsIds = $skeletalelements->measurements->pluck('id')->all();
            $originalMeasurements = array();
            foreach ($originalMeasurementsIds as $id) {
                $originalMeasurements[$id] = $skeletalelements->getMeasure($id);
            }

            $reviewMeasurementsInput = Input::get('measurementsreview', array());
            $reviewMeasurements = array();
            foreach ($reviewMeasurementsInput as $measureId => $value) {
                if (!empty($value['measure'])) {
                    $reviewMeasurements[$measureId] = $value['measure'];
                }
            }

            SkeletalElementReview::create([
                'se_id' => $skeletalelements->id,
                'type' => 'measurements',
                'original' => json_encode($originalMeasurements),
                'review' => json_encode($reviewMeasurements)
            ]);

            return redirect('/skeletalelements/' . $skeletalelements->id . '/review')->with('review_tab', 'associations')->with('tab_url', 'associations');
        }
    }

    public function storeAcceptReviewMeasurements( SkeletalElement $skeletalelements, Request $request)
    {
        $this->logInfo(__METHOD__, $skeletalelements->id.":".$skeletalelements->key);
        if ($this->authorize('add', [SkeletalElement::class])) {
            $seMeasurementReview = $skeletalelements->reviewByType('measurements');
            $reviewMeasurements = !empty($seMeasurementReview) ? json_decode($seMeasurementReview->review, true) : array();
            $seMeasurements = Measurement::where('sb_id', $skeletalelements->sb_id)->get();

            // Take the measurement values from the review
            $measurementReviewInput = $request->input('measurementsreview');
            $measurementReviewInput = $this->removeElementWithValue($measurementReviewInput, "measure", null);


            foreach($measurementReviewInput as $measureId => $value){
                if(!empty($value['measure'])){
                    $reviewMeasurements[$measureId] = $value['measure'];
                }
            }

            foreach($seMeasurements as $seMeasurement)
            {
                if(in_array($seMeasurement->id, array_keys($measurementReviewInput))) {
                    if($skeletalelements->measurements()->where('measurement_id', $seMeasurement->id)->exists()){
                        // if the measurements with this id already exists update it
                        $skeletalelements->measurements()->updateExistingPivot($seMeasurement->id, ['measure' => $reviewMeasurements[$seMeasurement->id]]);
                    }else{
                        //if the measurement not present measurements attach a new one
                        $skeletalelements->measurements()->attach($seMeasurement->id,['measure' => $reviewMeasurements[$seMeasurement->id], 'org_id' =>$skeletalelements->org_id, 'project_id' => $skeletalelements->project_id]);
                    }
                }else{
                    if($skeletalelements->measurements()->where('measurement_id', $seMeasurement->id)->exists()){
                        // if the measurement value exist, detach it from the skelementalelements
                        $skeletalelements->measurements()->where('measurement_id', $seMeasurement->id)->detach();
                    }
                }
            }

            $originalMeasurementsIds = $skeletalelements->measurements->pluck('id')->all();
            $originalMeasurements = array();
            foreach ($originalMeasurementsIds as $id) {
                $originalMeasurements[$id] = $skeletalelements->getMeasure($id);
            }

            SkeletalElementReview::create([
                'se_id' => $skeletalelements->id,
                'type' => 'measurements',
                'original' => json_encode($originalMeasurements),
                'review' => json_encode(array())
            ]);

        }

        return redirect()->back()->with('review_tab', 'associations')->with('tab_url', 'articulations');
    }
    
    // Helper methods for Specimens
    public function getSyncArrayForMethodFeatures($arr_data, $model)
    {
        $syncData = [];
        foreach($arr_data as $data) {
            if (Auth::check()) {
                $syncData[$data['method_feature_id']] = [ 'score' => $data['score'], 'method_id' => $data['method_id'],
                    'org_id' => $model->org_id, 'project_id' => $model->project_id,
                    'created_by' => $this->theUser->name, 'updated_by' => $this->theUser->name ];
            }
        }
        return $syncData;
    }

    private function removeElementWithValue($array, $key, $value) {
        foreach($array as $subKey => $subArray){
            if($subArray[$key] == $value){
                unset($array[$subKey]);
            }
        }
        return $array;
    }
    
    private function originalMethodsToArray($originalCollection, SkeletalElement $skeletalelement, $reviewMethodFeatures, &$storageArray)
    {
        foreach($originalCollection as $method) {
            $mId = $method->id;
            $methodFeature = array('features'=>array());
            $methodFeatureReview = array('features'=>array());
            foreach($method->features as $feature) {
                $featureId = $feature->id;
                $seFeature = $skeletalelement->methodfeaturesById($featureId);
                if (!empty($seFeature)) {
                    $score = $seFeature->pivot->score;
                    $methodFeature['features'][$featureId] = array('score'=>$score);

                    $reviewScore = $reviewMethodFeatures['methods'][$mId]['features'][$featureId]['score'];
                    if ($score != $reviewScore && !empty($reviewScore)) {
                        $methodFeatureReview['features'][$featureId] = array('score'=>$reviewScore);
                        $storageArray['review']['methods'][$mId] = $methodFeatureReview;
                        $storageArray['original']['methods'][$mId] = $methodFeature;
                    }
                }
            }
        }
    }
    
    private function viewGeneralsSummary(SkeletalElement $se, SkeletalElementReview $seReview = null) 
    {
        $summary = array('differences'=>0, 'reviewed'=>false);
        if(empty($seReview->created_at)) {
            return $summary;
        } else {
            $summary['reviewed'] = true;
        }
        
        $seReviewArray = json_decode($seReview->review, true);
        $originalData = array('sb_id' => $se->sb_id, 'side' => $se->side, 'completeness' => $se->completeness);
        
        foreach($originalData as $field => $value) {
            if (array_key_exists($field.'_review', $seReviewArray) 
                    && $value != $seReviewArray[$field.'_review']) {
                $summary['differences'] += 1;
            }
        }
        return $summary;
    }

    private function reviewPathologySummary(SkeletalElement $se, SkeletalElementReview $seReview = null)
    {
        $summary = array('differences'=>0, 'reviewed'=>false);
        if(empty($seReview->created_at)) {
            return $summary;
        } else {
            $summary['reviewed'] = true;
        }
        $reviewArray = json_decode($seReview->review, true);
        
        foreach($se->pathologys as $pathology) {
            $origSePathologyId = $pathology->pivot->id;
            $origZone = $pathology->pivot->zone_id;
            $origPathology = $pathology->pivot->pathology_id;
            $origInfo = $pathology->pivot->additional_information;
            
            if(!empty($reviewArray['pathology']['se_pathology_id'][$origSePathologyId])){
                $review = $reviewArray['pathology']['se_pathology_id'][$origSePathologyId];
                
                if ($origZone != $review['zone']) {
                    $summary['differences'] += 1;
                }
                
                if ($origPathology != $review['pathologyid']) {
                    $summary['differences'] += 1;
                }
                
                if ($origInfo != $review['additionalinfo']) {
                    $summary['differences'] += 1;
                }
            }
        }
        
        foreach($se->traumas as $trauma) {
            $origSeTraumaId = $trauma->pivot->id;
            $origZone = $trauma->pivot->zone_id;
            $origTrauma = $trauma->pivot->trauma_id;
            $origInfo = $trauma->pivot->additional_information;
            
            if(!empty($reviewArray['trauma']['se_trauma_id'][$origSeTraumaId])){
                $review = $reviewArray['trauma']['se_trauma_id'][$origSeTraumaId];
                if ($origZone != $review['zone']) {
                    $summary['differences'] += 1;
                }
            }
            
            if(!empty($reviewArray['trauma']['se_trauma_id'][$origSeTraumaId])){
                $review = $reviewArray['trauma']['se_trauma_id'][$origSeTraumaId];
                if ($origTrauma != $review['traumaid']) {
                    $summary['differences'] += 1;
                }
            }
            
            if(!empty($reviewArray['trauma']['se_trauma_id'][$origSeTraumaId])){
                $review = $reviewArray['trauma']['se_trauma_id'][$origSeTraumaId];
                if ($origInfo != $review['additionalinfo']) {
                    $summary['differences'] += 1;
                }
            }
            
        }
        $originalAnomolys = array();
        $origAnomoly = $se->anomalys;
        if(count($origAnomoly) > 0) {
            foreach($origAnomoly as $a){
                $originalAnomolys[] = $a->id;
            }
        }

        // $originalAnomolys = $se->anomalys()->pluck('id')->toArray();
        if (!empty($reviewArray['anomaly']) 
                && count($reviewArray['anomaly']) != 0) {
            foreach($reviewArray['anomaly'] as $idx => $id) {
                if(!in_array($id, $originalAnomolys)) {  
                    $summary['differences'] += 1;
                }
            }

            foreach($originalAnomolys as $idx => $id) {
                if(!in_array($id, $reviewArray['anomaly'])) {  
                    $summary['differences'] += 1;
                }
            }
        }
        return $summary;
    }

    private function reviewMethodsSummary(SkeletalElement $se, SkeletalElementReview $seReview = null)
    {
        $summary = array('differences'=>0, 'reviewed'=>false);
        if(empty($seReview->created_at)) {
            return $summary;
        } else {
            $summary['reviewed'] = true;
        }
        
        $seReviewArray = json_decode($seReview->review, true);
        if( !empty($seReviewArray['methods'])) {
            foreach ($seReviewArray['methods'] as $methodId => $features) {
                foreach ($features['features'] as $featureId => $feature) {
                    $seFeature = $se->methodfeaturesById($featureId);
                    if (!empty($seFeature) && $seFeature->pivot->score != $feature['score']) {
                        $summary['differences'] += 1;
                    }
                }
            }
        }
        return $summary;
    }
    
    private function reviewDnaSummary(SkeletalElement $se, SkeletalElementReview $seReview = null)
    {
        $summary = array('differences'=>0, 'reviewed'=>false);
        if(empty($seReview->created_at)) {
            return $summary;
        } else {
            $summary['reviewed'] = true;
        }
        
        $seReviewArray = json_decode($seReview->review, true);
        if (!empty($se->dnas)) {
            foreach($se->dnas as $dna) {
                if(array_key_exists($dna->id, $seReviewArray))
                {
                    foreach ($dna->getAttributes() as $original_field => $original_value) {
                        $review_field = $original_field;
                        if (array_key_exists($review_field, $seReviewArray[$dna->id])
                            && !empty($seReviewArray[$dna->id][$review_field])
                            && $original_value != $seReviewArray[$dna->id][$review_field]) {

                            $summary['differences'] += 1;
                        }
                    }
                }
            }
        }
        
        $originals = array();
        if (!empty($se->dnas)) {
            foreach($se->dnas as $dna){
                $originals = $dna->getAttributes();
            }
        }
        
        foreach($seReviewArray as $reviewField => $reviewValue) {
            if (preg_match('/review$/', $reviewField)) {
                $originalField = str_replace('_review', '', $reviewField);

                if(!array_key_exists($originalField,$originals) || $reviewValue != $originals[$originalField]) {
                    $summary['differences'] += 1;
                }
            }
        }
        
        return $summary;
    }
    
    private function reviewTaphonomySummary(SkeletalElement $se, SkeletalElementReview $seReview = null)
    {
        $summary = array('differences'=>0, 'reviewed'=>false);
        if(empty($seReview->created_at)) {
            return $summary;
        } else {
            $summary['reviewed'] = true;
        }
        
        $seReviewArray = json_decode($seReview->review, true);
        $originalArray = $se->taphonomys->pluck('id')->all();
        
        if (count($seReviewArray) != 0) {
            foreach($seReviewArray as $idx => $id) {
                if(!in_array($id, $originalArray)) {  
                    $summary['differences'] += 1;
                }
            }

            foreach($originalArray as $idx => $id) {
                if(!in_array($id, $seReviewArray)) {  
                    $summary['differences'] += 1;
                }
            }
        }

        return $summary;
    }
    
    private function reviewZoneSummary(SkeletalElement $se, SkeletalElementReview $seReview = null)
    {
        $summary = array('differences'=>0, 'reviewed'=>false);
        if(empty($seReview->created_at)) {
            return $summary;
        } else {
            $summary['reviewed'] = true;
        }
        
        $seReviewArray = json_decode($seReview->review, true);
        $originalArray = $se->getZonesPresent->pluck('id')->all();


        if($difference = array_diff($originalArray, $seReviewArray)) {
            $summary['differences'] += count($difference);
        }

        if($difference=array_diff($seReviewArray,$originalArray)){
            $summary['differences'] += count($difference);
        }

        return $summary;
    }
    
    private function reviewMeasurementSummary(SkeletalElement $se, SkeletalElementReview $seReview = null)
    {
        $summary = array('differences'=>0, 'reviewed'=>false);
        if(empty($seReview->created_at)) {
            return $summary;
        } else {
            $summary['reviewed'] = true;
        }

        $originalMeasurementIds = $se->measurements->pluck('id')->all();
        $originalArray = array();
        foreach($originalMeasurementIds as $id) {
            $originalArray[$id] = $se->getMeasure($id);
        }
        
        $seReviewArray = json_decode($seReview->review, true);
        foreach($seReviewArray as $id => $measure) {
            if(!array_key_exists($id, $originalArray) 
                    || (array_key_exists($id, $originalArray) && $measure != $originalArray[$id] )) {  
                $summary['differences'] += 1;
            }
        }

        return $summary;
    }
    
    private function reviewArticulationSummary(SkeletalElement $se, SkeletalElementReview $seReview = null)
    {
        $summary = array('differences'=>0, 'reviewed'=>false);
        if(empty($seReview->created_at)) {
            return $summary;
        } else {
            $summary['reviewed'] = true;
        }



        $articulationOriginal = $se->articulations->pluck('id')->all();
        $pairMatchesOriginal = $se->AllPairs->pluck('id')->all();
        $refitsOriginal = $se->refits()->pluck('id')->all();

        // check articulations differences
//        if($articulationOriginal){
//            if($se->reviewByType('articulations')->review){
//                $articulationReview = json_decode($se->reviewByType('articulations')->review);
//                $difference = array_diff($articulationOriginal, $articulationReview) + array_diff($articulationReview, $articulationOriginal);
//                $summary['differences'] += count($difference);
//            }
//        }
//
//        // check pairmatches array differences
//        if($pairMatchesOriginal) {
//            if(isset($se->reviewByType('pairmatches')->review)){
//                $pairMatchesReview = json_decode($se->reviewByType('pairmatches')->review);
//                $difference = array_diff($pairMatchesOriginal, $pairMatchesReview) + array_diff($pairMatchesReview, $pairMatchesOriginal);
//                $summary['differences'] += count($difference);
//            }
//        }
//        // check refits array differences
//        if($refitsOriginal) {
//            if(isset($se->reviewByType('refits')->review)){
//                $refitsReview = json_decode($se->reviewByType('refits')->review);
//                $difference = array_diff($refitsOriginal, $refitsReview) + array_diff($refitsReview, $refitsOriginal);
//                $summary['differences'] += count($difference);
//            }
//        }

        return $summary;
    }
    
    private function updateReviewState(SkeletalElement $se) // $this->viewData['generalSummary']
    {
        if (($this->viewData['methodsSummary']['reviewed'] && $this->viewData['methodsSummary']['differences'] == 0)
               && ($this->viewData['dnaSummary']['reviewed'] && $this->viewData['dnaSummary']['differences'] == 0) 
               && ($this->viewData['taphonomySummary']['reviewed'] && $this->viewData['taphonomySummary']['differences'] == 0)
               && ($this->viewData['zoneSummary']['reviewed'] && $this->viewData['zoneSummary']['differences'] == 0)
               && ($this->viewData['measurementSummary']['reviewed'] && $this->viewData['measurementSummary']['differences'] == 0)
               && ($this->viewData['articulationSummary']['reviewed'] && $this->viewData['articulationSummary']['differences'] == 0)
               && ($this->viewData['generalSummary']['reviewed'] && $this->viewData['generalSummary']['differences'] == 0)
               && ($this->viewData['pathologySummary']['reviewed'] && $this->viewData['pathologySummary']['differences'] == 0)) {

            $se->reviewed = true;
            $se->setReviewedAtAttribute(date('Y-m-d'));
            $se->save();
        }
    }

    // This function checks if all the tabs are reviewed and no differences exist
    public function ReviewState(SkeletalElement $se)
    {
        $seGeneralReview = $se->reviewByType('general');
        $this->viewData['generalSummary'] = $this->viewGeneralsSummary($se, $seGeneralReview);

        $seMethodReview = $se->reviewByType('methods');
        $this->viewData['methodsSummary'] = $this->reviewMethodsSummary($se, $seMethodReview);

        /* DNA */
        $seDnaReview = $se->reviewByType('dna');
        $this->viewData['dnaSummary'] = $this->reviewDnaSummary($se, $seDnaReview);

        /* Taphonomys */
        $seTaphonomyReview = $se->reviewByType('taphonomys');
        $this->viewData['taphonomySummary'] = $this->reviewTaphonomySummary($se, $seTaphonomyReview);

        /* Zones */
        $seZoneReview = $se->reviewByType('zones');
        $this->viewData['zoneSummary'] = $this->reviewZoneSummary($se, $seZoneReview);

        /* Measurements */
        $seMeasurementReview = $se->reviewByType('measurements');
        $this->viewData['measurementSummary'] = $this->reviewMeasurementSummary($se, $seMeasurementReview);

        /* Articulations */
        $seArticulationReview = $se->reviewByType('articulations');
        $this->viewData['articulationSummary'] = $this->reviewArticulationSummary($se, $seArticulationReview);

        /* Pathology */
        $sePathologyReview = $se->reviewByType('pathologys');
        $this->viewData['pathologySummary'] = $this->reviewPathologySummary($se, $sePathologyReview);

        if (($this->viewData['methodsSummary']['reviewed'] && $this->viewData['methodsSummary']['differences'] == 0)
            && ($this->viewData['dnaSummary']['reviewed'] && $this->viewData['dnaSummary']['differences'] == 0)
            && ($this->viewData['taphonomySummary']['reviewed'] && $this->viewData['taphonomySummary']['differences'] == 0)
            && ($this->viewData['zoneSummary']['reviewed'] && $this->viewData['zoneSummary']['differences'] == 0)
            && ($this->viewData['measurementSummary']['reviewed'] && $this->viewData['measurementSummary']['differences'] == 0)
            && ($this->viewData['articulationSummary']['reviewed'] && $this->viewData['articulationSummary']['differences'] == 0)
            && ($this->viewData['generalSummary']['reviewed'] && $this->viewData['generalSummary']['differences'] == 0)
            && ($this->viewData['pathologySummary']['reviewed'] && $this->viewData['pathologySummary']['differences'] == 0)) {

            return true;
        }
        return false;
    }

    /**
     * set the common fields of the viewData array
     *
     * @param string $heading
     * @param bool $initialshow
     * @param null $skeletalelement
     */
    private function setViewDataCommonFields($heading="", $initialshow=true, $skeletalelement=null)
    {
        $this->viewData['heading'] = $heading;
        $this->viewData['initialshow'] = $initialshow;
        $this->viewData['skeletalelement'] = $skeletalelement;
        $this->viewData['open_result_new_tab'] = ($this->theUser->getProfileValue('se_search_open_in_new_browser_tab') == true ? true : false);
        $this->setViewDataANP1P2();
    }

    /**
     * set the viewData array with lists of Accession Number, Provenance1 and Provenance2
     */
    private function setViewDataANP1P2()
    {
        $this->viewData['list_accession'] = Accession::where('project_id', $this->theProject->id)->where('consolidated_an', false)->pluck('number', 'number');
        $this->viewData['list_provenance1'] = Accession::where('project_id', $this->theProject->id)->where('provenance1', '!=', null)->pluck('provenance1', 'provenance1');
        $this->viewData['list_provenance2'] = Accession::where('project_id', $this->theProject->id)->where('provenance2', '!=', null)->pluck('provenance2', 'provenance2');
        $this->viewData['list_consolidated'] = Accession::where('project_id', $this->theProject->id)->where('consolidated_an', true)->pluck('number', 'number');
    }

    // This function is used in the Review section to mark as Review Completed or Undo Review
    public function ReviewCompleteStateButton(SkeletalElement $skeletalelements)
    {
        $this->logInfo(__METHOD__, $skeletalelements->id.":".$skeletalelements->key);
        if($this->authorize('edit', $skeletalelements)) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            $skeletalelements = SkeletalElement::find($skeletalelements->id);

            // If it's reviewed then UNDO
            if($skeletalelements->reviewed == 1){
                $skeletalelements->reviewed=false;
                $skeletalelements->setReviewedAtAttribute();
                $skeletalelements->save();
            }else{ //if it's not been marked Reviewed then mark it as Reviewed
                $skeletalelements->reviewed=true;
                $skeletalelements->setReviewedAtAttribute(date('Y-m-d'));
                $skeletalelements->save();
            }
            return redirect()->back();
        }
    }
}
