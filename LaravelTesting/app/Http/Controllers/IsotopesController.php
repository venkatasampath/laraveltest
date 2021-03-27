<?php

/**
 * Isotopes Controller
 *
 * @category   Isotopes
 * @package    CoRA-Controllers
 * @author     Sachin Pawaskar<spawaskar@unomaha.edu>
 * @copyright  2016-2019
 * @license    The MIT License (MIT)
 * @version    GIT: $Id$
 * @since      File available since Release 1.1.0
 */

namespace App\Http\Controllers;

use App\Haplogroup;
use App\Http\Requests\IsotopeRequest;
use App\Isotope;
use App\IsotopeBatch;
use App\Lab;
use App\SkeletalBone;
use App\SkeletalElement;
use Auth;
use Illuminate\Http\Request;
use Session;

/**
 * Class IsotopesController
 * @package App\Http\Controllers
 */
class IsotopesController extends Controller
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
    protected $allowedSearch = ['SB'=>'Bone', 'AN'=>'Accession Number', 'SN'=>'Sample Number', 'MS'=>'Mito Sequence Number',
        'CK'=>'Composite Key', 'IN'=>'Individual Number', 'EN'=>'External Number', 'HG'=>'Haplogroup' ];

    /**
     * IsotopesController constructor.
     */
    public function __construct()
    {
        parent::__construct();

        $this->initialize();
    }

    /**
     * Initialize the viewData variables
     */
    protected function initialize()
    {
        $this->viewData['list_sb'] = $this->list_sb = SkeletalBone::orderBy('name', 'asc')->pluck('name', 'id');
        $this->viewData['list_side'] = $this->list_side = SkeletalElement::$side;
        $this->viewData['list_completeness'] = $this->list_completeness = SkeletalElement::$completeness;
        $this->viewData['list_lab'] = $this->list_lab = Lab::where('type', 'Isotope')->get()->pluck('full_name', 'id');
        $this->viewData['list_isotope_batches'] = $this->list_isotope_batches = IsotopeBatch::all()->pluck('batch_num', 'id');
        $this->viewData['list_confidence'] = Isotope::$results_confidence;
        $this->viewData['initialshow'] = $this->initialshow = false;
    }

    /**
     * We have multiple searchtype mechanism such as Sequence,
     * External Case ID, Sample Number, Accession Number
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function search()
    {
        $this->logInfo(__METHOD__);
        $this->viewData['isotopes'] = null;
        $this->viewData['searchstring'] = '';
        $this->viewData['searchby'] = 'SB';
        $this->viewData['initialshow'] = true;
        $this->viewData['heading'] = trans('labels.model_search', ['model'=>'Isotope']);
        $this->viewData['open_result_new_tab'] = ( $this->theUser->getProfileValue('se_search_open_in_new_browser_tab') == true ? true : false );
        $this->viewData['view'] = '';
        return view('isotopes.search', $this->viewData);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function searchgo(Request $request)
    {
        $this->logInfo(__METHOD__,"SearchBy:".$request['searchby']." SearchString:".$request['searchstring']);

        $is_Isotope_Records = $this->buildCriteriaData($request);
        if ($is_Isotope_Records) {
            $isotopes = $this->viewData['isotopes'];
            Session::put('isotopes', $isotopes); //Store data in Session Storage for loading Search page in breadcrumbs
            $this->logInfo(__METHOD__,"Isotope Search count:". (isset($isotopes) ? $isotopes->count() : 0));
        } else { // it is returning SE records
            $skeletalelements = $this->viewData['skeletalelements'];
            Session::put('skeletalelements', $skeletalelements); //Store data in Session Storage for loading Search page in breadcrumbs
            $this->logInfo(__METHOD__,"Isotope-SE Search count:". (isset($skeletalelements) ? $skeletalelements->count() : 0));
        }

        $this->viewData['is_Isotope_Records'] = $is_Isotope_Records;
        $this->viewData['initialshow'] = false;
        $this->viewData['open_result_new_tab'] = ( $this->theUser->getProfileValue('se_search_open_in_new_browser_tab') == true ? true : false );
        $this->viewData['search_results_by_string'] = trans('messages.search_results_by_string', ['model'=>'Specimen', 'searchby'=>$this->currentSearchByName, 'searchstring' => $this->currentSearchString]);
        $this->viewData['heading'] = trans('labels.model_search', ['model'=>'Isotope'])." by ".$this->currentSearchByName ." ". $this->currentSearchString;

        return view('isotopes.search', $this->viewData);
    }

    /**
     * This will fill in the viewData array with the appropriate collections for
     * either isotopes or skeletalelements, This depends on the SeacrhBy parameters
     * ToDo: This needs further cleanup/refactoring.
     *
     * @param Request $request
     * @return boolean is_Isotope_Records
     */
    private function buildCriteriaData(Request $request)
    {
        $is_Isotope_Records = true;
        $this->viewData['searchstring'] = $this->currentSearchString = $request['searchstring'];
        $this->viewData['searchby'] = $this->currentSearchBy = $request['searchby'];
        $this->currentSearchByName = $this->allowedSearch[$this->currentSearchBy];

        try {
            $query = null;
            if ($this->currentSearchBy == 'EN') {
                $query = Isotope::with('skeletalelement')->where('external_case_id', $this->currentSearchString)->get();
                $this->viewData['isotopes'] = $query;
            } else if ($this->currentSearchBy == 'MS') {
                if (is_numeric($this->currentSearchString)) {
                    $query = Isotope::with('skeletalelement')->where('mito_sequence_number', $this->currentSearchString)->get();
                    $this->viewData['isotopes'] = $query;
                } else {
                    // User has entered something like 29b, where 29 is mito_sequence_number and b is mito_sequence_subgroup
                    // Split the string to get the individual components
                    $split = preg_split('#(?<=\d)(?=[a-z])#i', $this->currentSearchString);
                    $query = Isotope::with('skeletalelement')->where('mito_sequence_number', $split[0])->where('mito_sequence_subgroup', $split[1])->get();
                    $this->viewData['isotopes'] = $query;
                }
            } else if ($this->currentSearchBy == 'SN') {
                $query = Isotope::with('skeletalelement')->where('sample_number', $this->currentSearchString)->get();
                $this->viewData['isotopes'] = $query;
            } else if ($this->currentSearchBy == 'HG') {
                $hg = Haplogroup::where('letter', $this->currentSearchString)->get();
                $this->viewData['isotopes'] = null;
                if (!$hg->isEmpty()) {
                    $query = Isotope::with('skeletalelement')->where('mito_haplogroup_id', $hg->first()->id)->get();
                    $this->viewData['isotopes'] = $query;
                }
            } else if ($this->currentSearchBy == 'IN') {
                $skeletalelements = SkeletalElement::with('isotopes')->where('individual_number', $this->currentSearchString)->get();
                $this->viewData['skeletalelements'] = $skeletalelements;
                $is_Isotope_Records = false;
            } else if ($this->currentSearchBy == 'AN') {
                $skeletalelements = SkeletalElement::with('isotopes')->where('accession_number', $this->currentSearchString)->get();
                $this->viewData['skeletalelements'] = $skeletalelements;
                $is_Isotope_Records = false;
            } else if ($this->currentSearchBy == 'SB') {
                $bone = SkeletalBone::where('search_name', strtolower($this->currentSearchString))->get();
                if (!$bone->isEmpty()) {
                    $skeletalelements = SkeletalElement::with('isotopes')->where('sb_id', $bone->first()->id)->get();
                    $this->viewData['skeletalelements'] = $skeletalelements;
                    $is_Isotope_Records = false;
                }
            } else if ($this->currentSearchBy == 'CK') {
                $values = array_map('trim', explode(',', $this->currentSearchString));
                $accession = isset($values[0]) ? $values[0] : null;
                $prov1 = isset($values[1]) ? $values[1] : null;
                $prov2 = isset($values[2]) ? $values[2] : null;
                $designator = isset($values[3]) ? $values[3] : null;

                if (isset($designator)) {
                    $skeletalelements = SkeletalElement::with('isotopes')->where('accession_number', $accession)->where('provenance1', $prov1)->where('provenance2', $prov2)->where('designator', $designator)->get();
                } elseif (isset($prov2)) {
                    $skeletalelements = SkeletalElement::with('isotopes')->where('accession_number', $accession)->where('provenance1', $prov1)->where('provenance2', $prov2)->get();
                } elseif (isset($prov1)) {
                    $skeletalelements = SkeletalElement::with('isotopes')->where('accession_number', $accession)->where('provenance1', $prov1)->get();
                } else {
                    $skeletalelements = SkeletalElement::with('isotopes')->where('accession_number', $accession)->get();
                }
                $this->viewData['skeletalelements'] = $skeletalelements;
                $is_Isotope_Records = false;
            }
            return $is_Isotope_Records;
        } catch(QueryException $ex){
            $this->logQueryException(__METHOD__, $request, $ex);
            return $is_Isotope_Records;
        }
    }

    /**
     * @param SkeletalElement $skeletalelement
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index(SkeletalElement $skeletalelement)
    {
        $this->logInfo(__METHOD__);
        if($this->authorize('browse', [Isotope::class])){
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            $this->setViewDataCrudFields(trans('labels.isotopes'), 'List', $skeletalelement, null);
            $this->viewData['isotopes'] = $skeletalelement->isotopes;
            return view('isotopes.index', $this->viewData);
        }
    }

    /**
     * @param SkeletalElement $skeletalelement
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function create(SkeletalElement $skeletalelement)
    {
        $this->logInfo(__METHOD__);
        if ($this->authorize('add', [Isotope::class])) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            $this->setViewDataCrudFields(trans('labels.create_model', ['model'=>'Isotope']), 'Create', $skeletalelement, null);
            return view('isotopes.create', $this->viewData);
        }
    }

    /**
     * @param $skeletalelement
     * @param Isotope $isotope
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit($skeletalelement, Isotope $isotope)
    {
        $this->logInfo(__METHOD__);
        if ($this->authorize('edit', [Isotope::class, $isotope])) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            $skeletalelement = $isotope->specimen;
            $this->setViewDataCrudFields(trans('labels.edit_model', ['model'=>'Isotope']), 'Edit', $skeletalelement, $isotope);
            return view('isotopes.edit', $this->viewData);
        }
    }

    /**
     * @param $skeletalelement
     * @param Isotope $isotope
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function show($skeletalelement, Isotope $isotope)
    {
        $this->logInfo(__METHOD__, $isotope->se->id.":".$isotope->se->key." Sample Number:".$isotope->sample_number);
        if($this->authorize('read', [Isotope::class, $isotope])) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            $skeletalelement = $isotope->specimen;
            $this->setViewDataCrudFields(trans('labels.view_model', ['model'=>'Isotope']), 'View', $skeletalelement, $isotope);
            return view('isotopes.show', $this->viewData);
        }
    }

    /**
     * @param IsotopeRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(IsotopeRequest $request)
    {
        $input = $request->all();
        $object = SkeletalElement::find($input['se_id']);
        $this->logInfo(__METHOD__, $object->id.":".$object->key);
        if ($this->authorize('add', [Isotope::class])) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
                try {
                    if($this->checkUniqueIsotopeSampleNumber($request, $object) == false) {
                        Session::flash('alert_message', trans('messages.model_add_unsuccessful', ['model'=>'Isotope'])." ".trans('Sample number already exists within the accession.'));
                        return redirect()->back();
                    }
                    $this->populateCreateFieldsWithUserOrgProjectIDs($input, $object);
                    $input['sb_id'] = $object->sb_id;
                    $input['results_confidence'] = 'Pending';
                    $isotope = Isotope::create($input);
                    $skeletalelement = $isotope->specimen;
                    // If Isotope is successfully created then mark the SE as being Isotope Sampled.
                    $isotope->skeletalelement->fill(['isotope_sampled' => true])->save();
                    Session::flash('flash_message', trans('messages.model_add_successful', ['model'=>'Isotope']));
                    return redirect('/isotopes/'.$skeletalelement->id.'/'.$isotope->id);
                } catch (QueryException $ex) {
                    $this->logQueryException(__METHOD__, $request, $ex);
                    Session::flash('alert_message', trans('messages.model_add_unsuccessful', ['model'=>'Isotope']));
                    return redirect()->back();
                }
        }
            $this->logInfo(__METHOD__, "END");
            return redirect()->back();
    }

    /**
     * @param Isotope $isotope
     * @param IsotopeRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(Isotope $isotope, IsotopeRequest $request)
    {
        $se = $isotope->se;
        $this->logInfo(__METHOD__, $isotope->se->id.":".$isotope->se->key." Sample Number:".$isotope->sample_number);
        $input = $request->all();
        $input['se_id'] = $se->id;
        if ($this->authorize('edit', [Isotope::class, $isotope])) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            try {
                $isotope = $isotope;
                $this->populateUpdateFields($input);
                $isotope->calcWeightCollagen($input);
                $isotope->calcYieldCollagen($input);
                $isotope->update($input);
                Session::flash('flash_message', trans('messages.model_update_successful', ['model'=>'Isotope']));
                $skeletalelement = $isotope->specimen;
                return redirect('/isotopes/'.$skeletalelement->id.'/'.$isotope->id);
            } catch (QueryException $ex) {
                $this->logQueryException(__METHOD__, $request, $ex);
                Session::flash('alert_message', trans('messages.model_update_unsuccessful', ['model'=>'Isotope']));
                return redirect()->back();
            }
        }
        $this->logInfo(__METHOD__, ' - End: '.$se->id.":".$se->key.' Isotope-id='.$isotope->id);
        return redirect()->back();
    }

    /**
     * @param Request $request
     * @param SkeletalElement $skeletalelement
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(SkeletalElement $skeletalelement, Isotope $isotope, Request $request)
    {
        $object = $isotope;
        $this->logInfo(__METHOD__, $skeletalelement->id.":".$skeletalelement->key." Sample Number:".$isotope->sample_number);
        if ($this->authorize('delete', [Isotope::class, $object])) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            try {
                $object->delete();
                Session::flash('flash_message', trans('messages.model_delete_successful', ['model'=>'Isotope']));
                return redirect('skeletalelements/'.$skeletalelement->id);
            } catch (QueryException $ex) {
                $this->logQueryException(__METHOD__, $request, $ex);
                Session::flash('alert_message', trans('messages.model_delete_unsuccessful', ['model'=>'Isotope']));
                return redirect()->back();
            }
        }
        $this->logInfo(__METHOD__, "End");
        return redirect()->back();
    }

    /**
     * @param $request
     * @param $se
     * @return bool
     */
    public function checkUniqueIsotopeSampleNumber($request, $se) {
        $flag = true;
        $this->logInfo(__METHOD__, $se->id.":".$se->key);
        try {
            $Isotopes = Isotope::where('sample_number', $request['sample_number'])->get();
            foreach ($Isotopes as $isotope) {
                $dup_se = $isotope->skeletalelement;
                if(isset($dup_se) && ($dup_se->accession_number == $se->accession_number)) {
                    $this->logInfo(__METHOD__, "Duplicate Isotope Sample Number:".$request['sample_number'].", New Record ".$se->id.":".$se->key ." Existing Record ".$dup_se->id.":".$dup_se->key);
                    $flag = false;
                }
            }
        } catch (QueryException $ex) {
            $this->logQueryException(__METHOD__, $request, $ex);
            return $flag;
        }
        return $flag;
    }

    /**
     * set the common CRUD fields of the viewData array
     *
     * @param string $heading
     * @param string $crud
     * @param null $skeletalelement
     * @param null $cr
     */
    private function setViewDataCrudFields($heading="", $crud="", $skeletalelement=null, $isotope=null)
    {
        $this->viewData['heading'] = $heading;
        $this->viewData['CRUD_Action'] = $crud;
        $this->viewData['skeletalelement'] = $skeletalelement;
        $this->viewData['isotope'] = $isotope;
        $this->viewData['list_lab'] = Lab::where('type', 'Isotope')->get()->pluck('full_name', 'id');
        $this->viewData['list_haplogroup'] = Haplogroup::orderBy('letter')->get()->pluck('hg', 'id');
        $this->viewData['list_batch'] = IsotopeBatch::all()->pluck('external_case_id', 'id');
    }
}
