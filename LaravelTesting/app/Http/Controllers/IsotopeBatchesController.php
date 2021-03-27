<?php

/**
 * IsotopeBatches Controller
 *
 * @category   IsotopeBatches
 * @package    CoRA-Controllers
 * @author     Sachin Pawaskar<spawaskar@unomaha.edu>
 * @copyright  2016-2019
 * @license    The MIT License (MIT)
 * @version    GIT: $Id$
 * @since      File available since Release 1.1.0
 */

namespace App\Http\Controllers;

use App\Http\Requests\IsotopeBatchRequest;
use App\Isotope;
use App\IsotopeBatch;
use App\Lab;
use App\Project;
use App\SkeletalBone;
use App\SkeletalElement;
use Auth;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\View\View;
use Session;

/**
 * Class IsotopeBatchesController
 * @package App\Http\Controllers
 */
class IsotopeBatchesController extends Controller
{
    /**
     * @var string
     */
    protected $currentSearchBy = "";
    /**
     * @var string
     */
    protected $currentSearchByName = "";
    /**
     * @var string
     */
    protected $currentSearchString = "";
    /**
     * @var array
     */
    protected $allowedSearch = ['SB' => 'Bone', 'AN' => 'Accession Number', 'SN' => 'Sample Number', 'MS' => 'Mito Sequence Number',
        'CK' => 'Composite Key', 'IN' => 'Individual Number', 'EN' => 'External Number', 'HG' => 'Haplogroup'];

    /**
     * IsotopeBatchesController constructor.
     */
    public function __construct()
    {
        parent::__construct();

        $this->initialize();
    }

    /**
     * initialize the viewData variables
     */
    protected function initialize()
    {
        $this->viewData['list_sb'] = $this->list_sb = SkeletalBone::orderBy('name', 'asc')->pluck('name', 'id');
        $this->viewData['list_side'] = $this->list_side = SkeletalElement::$side;
        $this->viewData['list_completeness'] = $this->list_completeness = SkeletalElement::$completeness;
        $this->viewData['list_lab'] = $this->list_lab = Lab::where('type', 'Isotope')->get()->pluck('full_name', 'id');
        $this->viewData['list_status'] = $this->list_status = IsotopeBatch::$status;
        $this->viewData['batchStatus'] = $this->batchStatus = 'Open';
        $this->viewData['initialshow'] = $this->initialshow = false;
    }

    /**
     * @return Factory|View
     * @throws AuthorizationException
     */
    public function index()
    {
        $this->logInfo(__METHOD__);
        if($this->authorize('browse', [IsotopeBatch::class])){
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            $this->setViewDataCrudFields(trans('labels.isotope_batches'), 'List', null, null);
            $this->viewData['isotopeBatches'] = IsotopeBatch::orderBy('created_at')->get();
            return view('isotopes.batch.index', $this->viewData);
        }
    }

    /**
     * @param $isotopeBatch
     * @return Factory|View
     * @throws AuthorizationException
     */
    public function show ($isotopeBatch)
    {
        $this->logInfo(__METHOD__);
        if($this->authorize('read', [IsotopeBatch::class])) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            $isotopeBatch = IsotopeBatch::where('id', $isotopeBatch)->first();
            $this->viewData['isotopes'] = $isotopeBatch->isotopes;
            $this->setViewDataCrudFields(trans('labels.view_model', ['model'=>'Isotope Batch']), 'View', $isotopeBatch);
            return view('isotopes.batch.show', $this->viewData);
        }
    }

    /**
     * @param $isotopeBatch
     * @return Factory|View
     * @throws AuthorizationException
     */
    public function edit ($isotopeBatch)
    {
        $this->logInfo(__METHOD__);
        if($this->authorize('edit', [IsotopeBatch::class])) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            $isotopeBatch = IsotopeBatch::where('id', $isotopeBatch)->first();
            $this->viewData['isotopes'] = $isotopeBatch->isotopes;
            $this->setViewDataCrudFields(trans('labels.edit_model', ['model'=>'Isotope Batch']), 'Edit', $isotopeBatch);
            return view('isotopes.batch.edit', $this->viewData);
        }
    }

    /**
     * @return Factory|View
     * @throws AuthorizationException
     */
    public function create ()
    {
        $this->logInfo(__METHOD__);
        if ($this->authorize('add', [IsotopeBatch::class])) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            $this->setViewDataCrudFields(trans('labels.create_model', ['model'=>'Isotope Batch']), 'Create', null);
            return view('isotopes.batch.create', $this->viewData);
        }
    }

    /**
     * @param Request $request
     * @return RedirectResponse|Redirector
     * @throws AuthorizationException
     */
    public function store (IsotopeBatchRequest $request)
    {
        $input = $request->all();
        $this->logInfo(__METHOD__);
        if ($this->authorize('add', [IsotopeBatch::class])) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            try {
                if($this->checkUniqueBatchNumber($request) == false) {
                    Session::flash('alert_message', trans('messages.model_add_unsuccessful', ['model'=>'Isotope'])." ".trans('Batch number already exists.'));
                    return redirect()->back();
                }

                // add associating individual isotopes section to batch
                $input['org_id'] = $this->theOrg->id;
                $input['project_id'] = $this->theProject->id; //take out after nullable
                $input['status'] = 'Open';
                $this->populateCreateFields($input);
                $isotopeBatch = IsotopeBatch::create($input);

                Session::flash('flash_message', trans('messages.model_add_successful', ['model'=>'Isotope Batch']));
                return redirect('/isotopebatch/'.$isotopeBatch->id.'/associateIsotopes');
            } catch (QueryException $ex) {
                $this->logQueryException(__METHOD__, $request, $ex);
                Session::flash('alert_message', trans('messages.model_add_unsuccessful', ['model'=>'Isotope Batch']));
                return redirect()->back();
            }
        }
        $this->logInfo(__METHOD__, "END");
        return redirect()->back();
    }

    /**
     * @param $isotopeBatch
     * @param Request $request
     * @return RedirectResponse|Redirector
     * @throws AuthorizationException
     */
    public function update ($isotopeBatch, IsotopeBatchRequest $request)
    {
        $this->logInfo(__METHOD__);
        if ($this->authorize('edit', [IsotopeBatch::class])) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            try {
                $isotopeBatch = IsotopeBatch::where('id', $isotopeBatch)->first();
                $input['org_id'] = $this->theOrg->id;
                $input['project_id'] = $this->theProject->id; //take out after nullable
                $this->populateUpdateFields($request);
                $this->processBatch($isotopeBatch, $request);
                $isotopeBatch->update($request->all());
                if(($request['demineralizing_treatment_start_date'] || $request['demineralizing_treatment_end_date']) != null) {
                    foreach($isotopeBatch->isotopes as $isotope){
                        $isotope->demineralizing_start_date = $request['demineralizing_treatment_start_date'];
                        $isotope->demineralizing_end_date = $request['demineralizing_treatment_end_date'];
                        $isotope->save();
                    }
                }
                Session::flash('flash_message', trans('messages.model_update_successful', ['model'=>'Isotope Batch']));
                return redirect('/isotopebatch/'.$isotopeBatch->id);
            } catch (QueryException $ex) {
                $this->logQueryException(__METHOD__, $request, $ex);
                Session::flash('alert_message', trans('messages.model_update_unsuccessful', ['model'=>'Isotope Batch']));
                return redirect()->back();
            }
        }
        $this->logInfo(__METHOD__, "END");
        return redirect()->back();
    }

    protected function processBatch($isotopeBatch, &$request) {
        $this->logInfo(__METHOD__, 'Batch Number:'.$isotopeBatch->batch_num);
        if ($request['status'] == 'Cleaning') {
            if($request['rsc'] == true && is_null($request['cleaning_start_date'])) {
                $request['cleaning_start_date'] = date_create();
            }
            if($request['sonicate_samples_dh2o_cycle1'] == true && is_null($request['sonicate_samples_dh2o_cycle1_start_date'])) {
                $request['sonicate_samples_dh2o_cycle1_start_date'] = date_create();
            }
            if($request['sonicate_samples_dh2o_cycle2'] == true && is_null($request['sonicate_samples_dh2o_cycle2_start_date'])) {
                $request['sonicate_samples_dh2o_cycle2_start_date'] = date_create();
            }
            if($request['sonicate_samples_ethanol95'] == true && is_null($request['sonicate_samples_ethanol95_start_date'])) {
                $request['sonicate_samples_ethanol95_start_date'] = date_create();
            }
            if($request['sonicate_samples_ethanol100'] == true && is_null($request['sonicate_samples_ethanol100_start_date'])) {
                $request['sonicate_samples_ethanol100_start_date'] = date_create();
            }
            if($request['dry_samples_start'] == true && is_null($request['dry_samples_start_date'])) {
                $request['dry_samples_start_date'] = date_create();
            }
            if($request['dry_samples_end'] == true && is_null($request['dry_samples_end_date'])) {
                $request['dry_samples_end_date'] = date_create();
            }
            if( $request['rsc'] == true && $request['rinse_samples'] == true &&
                $request['sonicate_samples_dh2o_cycle1'] == true && $request['sonicate_samples_dh2o_cycle2'] == true &&
                $request['sonicate_samples_ethanol95'] == true && $request['sonicate_samples_ethanol100'] == true &&
                $request['dry_samples_start'] == true && $request['dry_samples_end'] == true)
            {
                return $request['status'] = 'Demineralizing';
            }
        } else if ($request['status'] == 'Demineralizing') {
            if($request['demineralizing_treatment_start'] == true && is_null($request['demineralizing_treatment_start_date'])) {
                $request['demineralizing_treatment_start_date'] = date_create();
            }
            if($request['demineralizing_treatment_end'] == true && is_null($request['demineralizing_treatment_end_date'])) {
                $request['demineralizing_treatment_end_date'] = date_create();
            }
            if( $request['demineralizing_treatment_start'] == true && $request['demineralizing_treatment_end'] == true &&
                $request['rinse_demineralized_samples'] == true )
            {
                return $request['status'] = 'Removal Humic Acids';
            }
        } else if ($request['status'] == 'Removal Humic Acids') {
            if($request['rha_treatment_start'] == true && is_null($request['rha_treatment_start_date'])) {
                $request['rha_treatment_start_date'] = date_create();
            }
            if($request['rha_treatment_end'] == true && is_null($request['rha_treatment_end_date'])) {
                $request['rha_treatment_end_date'] = date_create();
            }
            if($request['rha_sample_rinse1_start'] == true && is_null($request['rha_sample_rinse1_start_date'])) {
                $request['rha_sample_rinse1_start_date'] = date_create();
            }
            if($request['rha_sample_rinse2_start'] == true && is_null($request['rha_sample_rinse2_start_date'])) {
                $request['rha_sample_rinse2_start_date'] = date_create();
            }
            if($request['rha_sample_rinse3_start'] == true && is_null($request['rha_sample_rinse3_start_date'])) {
                $request['rha_sample_rinse3_start_date'] = date_create();
            }
            if($request['rha_sample_rinse4_start'] == true && is_null($request['rha_sample_rinse4_start_date'])) {
                $request['rha_sample_rinse4_start_date'] = date_create();
            }
            if($request['rha_sample_rinse5_start'] == true && is_null($request['rha_sample_rinse5_start_date'])) {
                $request['rha_sample_rinse5_start_date'] = date_create();
            }
            if($request['rha_treatment_end'] == true && is_null($request['rha_treatment_end_date'])) {
                $request['rha_treatment_end_date'] = date_create();
            }
            if($request['rha_sample_rinse1_end'] == true && is_null($request['rha_sample_rinse1_end_date'])) {
                $request['rha_sample_rinse1_end_date'] = date_create();
            }
            if($request['rha_sample_rinse2_end'] == true && is_null($request['rha_sample_rinse2_end_date'])) {
                $request['rha_sample_rinse2_end_date'] = date_create();
            }
            if($request['rha_sample_rinse3_end'] == true && is_null($request['rha_sample_rinse3_end_date'])) {
                $request['rha_sample_rinse3_end_date'] = date_create();
            }
            if($request['rha_sample_rinse4_end'] == true && is_null($request['rha_sample_rinse4_end_date'])) {
                $request['rha_sample_rinse4_end_date'] = date_create();
            }
            if($request['rha_sample_rinse5_end'] == true && is_null($request['rha_sample_rinse5_end_date'])) {
                $request['rha_sample_rinse5_end_date'] = date_create();
            }

            if( $request['rha_treatment_start'] == true && $request['rha_treatment_end'] &&
                $request['rha_sample_rinse1_start'] == true && $request['rha_sample_rinse1_end'] &&
                $request['rha_sample_rinse2_start'] == true && $request['rha_sample_rinse2_end'] &&
                $request['rha_sample_rinse3_start'] == true && $request['rha_sample_rinse3_end'] &&
                $request['rha_sample_rinse4_start'] == true && $request['rha_sample_rinse4_end'] &&
                $request['rha_sample_rinse5_start'] == true && $request['rha_sample_rinse5_end'] )
            {
                return $request['status'] = 'Solubilizing';
            }
        } else if ($request['status'] == 'Solubilizing') {
            if($request['sc_clean_vials_and_lids'] == true && is_null($request['sc_clean_vials_and_lids_date'])) {
                $request['sc_clean_vials_and_lids_date'] = date_create();
            }
            if($request['sc_freeze_vials'] == true && is_null($request['sc_freeze_vials_date'])) {
                $request['sc_freeze_vials_date'] = date_create();
            }
            if($request['sc_clean_vials_and_lids'] == true && $request['sc_add_solubale'] == true && $request['sc_place_in_oven'] == true &&
                $request['sc_centrifuge_tubes'] == true && $request['sc_freeze_vials'] == true)
            {
                return $request['status'] = 'Freeze Drying Collagen';
            }
        } else if ($request['status'] == 'Freeze Drying Collagen') {
            if($request['fdc_samples_start'] == true && is_null($request['fdc_samples_start_date'])) {
                $request['fdc_samples_start_date'] = date_create();
            }
            if($request['fdc_samples_end'] == true && is_null($request['fdc_samples_end_date'])) {
                $request['fdc_samples_end_date'] = date_create();
            }
            if($request['fdc_on'] == true && $request['fdc_samples_start'] == true && $request['fdc_samples_end'] == true)
            {
                return $request['status'] = 'Determining Collagen Yield';
            }
        } else if ($request['status'] == 'Determining Collagen Yield') {
            if($request['combined_samples_weight'] == true ) {
                return $request['status'] = 'Completed';
            }
        }
        return $request['status'];
    }

    protected function processCheckboxAndDateFields(&$request, $cbfields, $datefields) {
        foreach($cbfields as $key=>$cbfields) {
            if ($request[$cbfields] == true && isset($request[$datefields[$key]])) {
                $request[$datefields[$key]] = date_create();
            }
        }
    }

    /**
     * @param $request
     * @return bool
     */
    public function checkUniqueBatchNumber($request) {
        $flag = true;
        $this->logInfo(__METHOD__, 'Batch Number:'.$request['batch_num']);
        try {
            $iso_batch = IsotopeBatch::where('batch_num', $request['batch_num'])->get();
            if (count($iso_batch) > 0) {
                $this->logInfo(__METHOD__, "Duplicate Isotope Batch Number:".$request['batch_num']);
                $flag = false;
            }
        } catch (QueryException $ex) {
            $this->logQueryException(__METHOD__, $request, $ex);
            return $flag;
        }
        return $flag;
    }

    /**
     * @param IsotopeBatch $isotopeBatch
     * @return Factory|View
     * @throws AuthorizationException
     */
    public function editIsotopes($isotopeBatch){
        $this->logInfo(__METHOD__);
        if($this->authorize('edit', [IsotopeBatch::class])) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            $isotopeBatch = IsotopeBatch::where('id', $isotopeBatch)->first();
            if ($isotopeBatch->status === 'Open' || $isotopeBatch->status === 'Associating Isotopes') {
                $this->viewData['list_isotopes'] = Isotope::where('project_id', Project::where('org_id', $this->theOrg->id)->orderBy('name')->first()->id)->whereNull('batch_id')->get()->pluck('key', 'id');
                $this->setViewDataCrudFields(trans('labels.associate_isotopes'), 'Edit', $isotopeBatch);
                return view('isotopes.batch.associateisotopes', $this->viewData);
            } else {
                return redirect()->action('IsotopeBatchesController@show', ['id' => $isotopeBatch->id]);
            }
        }
    }

    /**
     * @param IsotopeBatch $isotopeBatch
     * @param Request $request
     * @return Factory|RedirectResponse|View
     * @throws AuthorizationException
     */
    public function associateIsotopes($isotopeBatch, Request $request){
        $this->logInfo(__METHOD__);
        if ($this->authorize('edit', [IsotopeBatch::class])) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            try {
                $isotopeBatch = IsotopeBatch::where('id', $isotopeBatch)->first();
                //Check if user deleted any from list. Remove from batch if they did.
                $selected_isotopes = $request['isotopesassociatedlist'];
                if(isset($selected_isotopes) && $isotopeBatch->isotopes != null) {
                    foreach ($isotopeBatch->isotopes as $isotope) {
                        if (!in_array($isotope->id, $selected_isotopes)) {
                            $isotope->batch_id = null;
                            $isotope->save();
                        }
                    }
                }
                $isotopes = $request['isotopelist'];
                if (isset($isotopes)) {
                    foreach($isotopes as $isotope){
                        $iso = Isotope::where('id', $isotope)->first();
                        $iso->batch_id = $isotopeBatch->id;
                        $iso->save();
                    }
                }
                $isotopeBatch->update(['status'=>'Associating Isotopes']);
            } catch (QueryException $ex) {
                $this->logQueryException(__METHOD__, $request, $ex);
                Session::flash('alert_message', trans('messages.model_update_unsuccessful', ['model'=>'Isotope Batch']));
                return redirect()->back();
            }
        }
        $this->viewData['list_isotopes'] = Isotope::where('project_id', $request['project'])->whereNull('batch_id')->get()->pluck('key', 'id');
        $this->setViewDataCrudFields(trans('labels.associate_isotopes'), 'Edit', $isotopeBatch);
        $this->logInfo(__METHOD__, "END");
        return view('isotopes.batch.associateisotopes', $this->viewData);
    }

    public function startprocessing(IsotopeBatch $isotopeBatch, Request $request){
        $this->logInfo(__METHOD__);
        if ($this->authorize('edit', [IsotopeBatch::class])) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            try {
                //Check if user deleted any from list. Remove from batch if they did.
                $selected_isotopes = $request['isotopesassociatedlist'];
                if(isset($selected_isotopes) && $isotopeBatch->isotopes != null) {
                    foreach ($isotopeBatch->isotopes as $isotope) {
                        if (!in_array($isotope->id, $selected_isotopes)) {
                            $isotope->batch_id = null;
                            $isotope->save();
                        }
                    }
                }
                $isotopes = $request['isotopelist'];
                if (isset($isotopes)) {
                    foreach($isotopes as $isotope){
                        $iso = Isotope::where('id', $isotope)->first();
                        $iso->batch_id = $isotopeBatch->id;
                        $iso->save();
                    }
                }
                $isotopeBatch->update(['status'=>'Cleaning']);
            } catch (QueryException $ex) {
                $this->logQueryException(__METHOD__, $request, $ex);
                Session::flash('alert_message', trans('messages.model_update_unsuccessful', ['model'=>'Isotope Batch']));
                return redirect()->back();
            }
        }
        return redirect()->action('IsotopeBatchesController@show', ['id' => $isotopeBatch->id]);
    }

    /**
     * @param string $heading
     * @param string $crud
     * @param null $isotopeBatch
     */
    private function setViewDataCrudFields($heading="", $crud="", $isotopeBatch=null)
    {
        $this->viewData['heading'] = $heading;
        $this->viewData['CRUD_Action'] = $crud;
        $this->viewData['isotopeBatch'] = $isotopeBatch;
        $this->viewData['list_lab'] = Lab::where('type', 'Isotope')->get()->pluck('full_name', 'id');
        if ($isotopeBatch != null) {
            $this->viewData['list_associated_isotopes'] = Isotope::where('batch_id', $isotopeBatch->id)->get()->pluck('key', 'id');
            $this->viewData['batchStatus'] = $this->batchStatus = $isotopeBatch->status;
        }
        $this->viewData['list_projects'] = Project::where('org_id', $this->theOrg->id)->orderBy('name')->pluck('name', 'id');
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function isotopeArray(Request $request) {
        $this->logInfo(__METHOD__);
        if( $request['project'] != null) {
            $isotope = Isotope::where('project_id', $request['project'])->whereNull('batch_id')->get()->pluck('id', 'key');
        }
        return response()->json($isotope);
    }
}