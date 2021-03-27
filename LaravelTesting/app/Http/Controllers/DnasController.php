<?php

/**
 * Dnas Controller
 *
 * @category   Dnas
 * @package    CoRA-Controllers
 * @author     Sachin Pawaskar<spawaskar@unomaha.edu>
 * @copyright  2016-2018
 * @license    The MIT License (MIT)
 * @version    GIT: $Id$
 * @since      File available since Release 1.0.0
 */

namespace App\Http\Controllers;

use App\Dna;
use App\DnaAnalysisType;
use App\Haplogroup;
use App\Http\Requests\DnaRequest;
use App\Lab;
use App\SkeletalBone;
use App\SkeletalElement;
use Auth;
use Illuminate\Http\Request;
use Session;

class DnasController extends Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->list_sb = SkeletalBone::pluck('name', 'id');
        $this->list_side = SkeletalElement::$side;
        $this->list_confidence = Dna::$results_confidence;
        $this->list_disposition = Dna::$disposition;
        $this->list_sample_condition = Dna::$sample_condition;
        $this->list_completeness = SkeletalElement::$completeness;
        $this->list_test = DnaAnalysisType::orderby('display_name')->pluck('display_name', 'id');
        $this->initialshow = false;

        $this->viewData = ['list_sb' => $this->list_sb, 'list_side' => $this->list_side, 'list_confidence' => $this->list_confidence, 'list_completeness' => $this->list_completeness,
            'list_test' => $this->list_test, 'initialshow' => $this->initialshow, 'list_disposition' => $this->list_disposition, 'list_sample_condition' => $this->list_sample_condition];
    }

    // DNA Search
    // We have multiple searchtype mechanism such as
    // Sequence, External Case ID, Sample Number, Haplogroup, Accession Number
    public function search()
    {
        $this->logInfo(__METHOD__);
        $this->viewData['dnas'] = null;
        $this->viewData['searchstring'] = '';
        $this->viewData['searchby'] = 'SB';
        $this->viewData['heading'] = trans('labels.dna_search');
        $this->viewData['initialshow'] = true;
        $this->viewData['open_result_new_tab'] = ( $this->theUser->getProfileValue('se_search_open_in_new_browser_tab') == true ? true : false );
        $this->viewData['view'] = '';
        return view('dnas.search', $this->viewData);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function searchgo(Request $request)
    {
        $this->logInfo(__METHOD__);
        $is_DNA_Records = $this->buildCriteriaData($request);
        if ($is_DNA_Records) {
            $dnas = $this->viewData['dnas'];
            Session::put('dnas', $dnas); //Store data in Session Storage for loading Search page in breadcrumbs
            $this->logInfo(__METHOD__,"DNA Search count:". (isset($dnas) ? $dnas->count() : 0));
        } else { // it is returning SE records
            $skeletalelements = $this->viewData['skeletalelements'];
            Session::put('skeletalelements', $skeletalelements); //Store data in Session Storage for loading Search page in breadcrumbs
            $this->logInfo(__METHOD__,"DNA-SE Search count:". (isset($skeletalelements) ? $skeletalelements->count() : 0));
        }

        $this->viewData['is_DNA_Records'] = $is_DNA_Records;
        $this->viewData['heading'] = trans('labels.dna');
        $this->viewData['initialshow'] = false;
        $this->viewData['open_result_new_tab'] = ( $this->theUser->getProfileValue('se_search_open_in_new_browser_tab') == true ? true : false );
        return view('dnas.search', $this->viewData);
    }

    /**
     * This will fill in the viewData array with the appropriate collections for
     * either dnas or skeletalelements, This depends on the SeacrhBy parameters
     * ToDo: This needs further cleanup/refactoring.
     *
     * @param Request $request
     * @return boolean is_DNA_Records
     */
    private function buildCriteriaData(Request $request)
    {
        $is_DNA_Records = true;
        $searchstring = $request['searchstring'];
        $searchby = $request['searchby'];
        $this->viewData['searchstring'] = $searchstring;
        $this->viewData['searchby'] = $searchby;
        $this->logInfo(__METHOD__,"SearchBy:".$searchby." SearchString:".$searchstring);

        try {
            $query = null;
            if ($searchby == 'EN') {
                $query = Dna::with('skeletalelement')->where('external_case_id', $searchstring)->get();
                $this->viewData['dnas'] = $query;
                $this->viewData['search_results_by_string'] = trans('messages.search_results_by_string', ['model' => 'DNA', 'searchby' => 'External Number', 'searchstring' => $searchstring]);
            } else if ($searchby == 'MS') {
                $this->viewData['search_results_by_string'] = trans('messages.search_results_by_string', ['model' => 'DNA', 'searchby' => 'Mito Sequence Number', 'searchstring' => $searchstring]);
                if (is_numeric($searchstring)) {
                    $query = Dna::with('skeletalelement')->where('mito_sequence_number', $searchstring)->get();
                    $this->viewData['dnas'] = $query;
                } else {
                    // User has entered something like 29b, where 29 is mito_sequence_number and b is mito_sequence_subgroup
                    // Split the string to get the individual components
                    $split = preg_split('#(?<=\d)(?=[a-z])#i', $searchstring);
                    $query = Dna::with('skeletalelement')->where('mito_sequence_number', $split[0])->where('mito_sequence_subgroup', $split[1])->get();
                    $this->viewData['dnas'] = $query;
                }
            } else if ($searchby == 'SN') {
                $query = Dna::with('skeletalelement')->where('sample_number', $searchstring)->get();
                $this->viewData['dnas'] = $query;
                $this->viewData['search_results_by_string'] = trans('messages.search_results_by_string', ['model' => 'DNA', 'searchby' => 'Sample Number', 'searchstring' => $searchstring]);
            } else if ($searchby == 'HG') {
                $hg = Haplogroup::where('letter', $searchstring)->get();
                $this->viewData['dnas'] = null;
                $this->viewData['search_results_by_string'] = trans('messages.search_results_by_string', ['model' => 'DNA', 'searchby' => 'Haplogroup', 'searchstring' => $searchstring]);
                if (!$hg->isEmpty()) {
                    $query = Dna::with('skeletalelement')->where('mito_haplogroup_id', $hg->first()->id)->get();
                    $this->viewData['dnas'] = $query;
                }
            } else if ($searchby == 'IN') {
                $skeletalelements = SkeletalElement::with('dnas')->where('individual_number', $searchstring)->get();
                $this->viewData['skeletalelements'] = $skeletalelements;
                $this->viewData['search_results_by_string'] = trans('messages.search_results_by_string', ['model' => 'DNA', 'searchby' => 'Individual Number', 'searchstring' => $searchstring]);
                $is_DNA_Records = false;
            } else if ($searchby == 'AN') {
                $skeletalelements = SkeletalElement::with('dnas')->where('accession_number', $searchstring)->get();
                $this->viewData['skeletalelements'] = $skeletalelements;
                $this->viewData['search_results_by_string'] = trans('messages.search_results_by_string', ['model' => 'DNA', 'searchby' => 'Accession Number', 'searchstring' => $searchstring]);
                $is_DNA_Records = false;
            } else if ($searchby == 'SB') {
                $bone = SkeletalBone::where('search_name', strtolower($searchstring))->get();
                $this->viewData['search_results_by_string'] = trans('messages.search_results_by_string', ['model' => 'DNA', 'searchby' => 'Bone', 'searchstring' => $searchstring]);
                if (!$bone->isEmpty()) {
                    $skeletalelements = SkeletalElement::with('dnas')->where('sb_id', $bone->first()->id)->get();
                    $this->viewData['skeletalelements'] = $skeletalelements;
                    $is_DNA_Records = false;
                }
            } else if ($searchby == 'CK') {
                $values = array_map('trim', explode(SkeletalElement::$key_delimiter, $searchstring));
                if (strpos($searchstring, ',') !== false) {
                    $values = array_map('trim', explode(',', $searchstring));
                }
                $accession = (isset($values[0]) && !empty($values[0])) ? $values[0] : null;
                $prov1 = (isset($values[1]) && !empty($values[1])) ? $values[1] : null;
                $prov2 = (isset($values[2]) && !empty($values[2])) ? $values[2] : null;
                $designator = (isset($values[3]) && !empty($values[3])) ? $values[3] : null;

                $query = SkeletalElement::with('dnas');
                if(isset($accession)) { $query = $query->where('accession_number', $accession); }
                if(isset($prov1)) { $query = $query->where('provenance1', $prov1); }
                if(isset($prov2)) { $query = $query->where('provenance2', $prov2); }
                if(isset($designator)) { $query = $query->where('designator', $designator);}
                $skeletalelements = $query->get();

                $this->viewData['search_results_by_string'] = trans('messages.search_results_by_string', ['model' => 'DNA', 'searchby' => 'Composite Key', 'searchstring' => $searchstring]);
                $this->viewData['skeletalelements'] = $skeletalelements;
                $is_DNA_Records = false;
            }
            return $is_DNA_Records;
        } catch(QueryException $ex){
            $this->logQueryException(__METHOD__, $request, $ex);
            return $is_DNA_Records;
        }
    }

    public function index(SkeletalElement $skeletalelement)
    {
        $this->logInfo(__METHOD__);
        if($this->authorize('browse', [Dna::class])){
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            $this->setViewDataCrudFields(trans('labels.dnas'), 'List', $skeletalelement, null);
            $this->viewData['dna'] = $skeletalelement->dnas;
            $countdna = count($this->viewData['dna']);
            if($countdna == 0){
                return redirect('/skeletalelements/'.$skeletalelement->id.'/dnas/create');
            }else{
                $this->viewData['consensus_dna'] = $skeletalelement->ConsensusDna;
                return view('dnas.index', $this->viewData);
            }
        }
    }

    public function create(SkeletalElement $skeletalelement)
    {
        $this->logInfo(__METHOD__);
        if ($this->authorize('add', [Dna::class])) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            $this->setViewDataCrudFields(trans('labels.create_model', ['model'=>'DNA']), 'Create', $skeletalelement, null);
            return view('dnas.create', $this->viewData);
        }
    }

    public function edit(SkeletalElement $skeletalelement, Dna $dna)
    {
        $this->logInfo(__METHOD__);
        if ($this->authorize('edit', [Dna::class])) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            $this->setViewDataCrudFields(trans('labels.edit_model', ['model'=>'DNA']), 'Edit', $skeletalelement, $dna);
            return view('dnas.edit', $this->viewData);
        }
    }

    public function show(SkeletalElement $skeletalelement, Dna $dna)
    {
        $this->logInfo(__METHOD__, $dna->se->id.":".$dna->se->key." Sample Number:".$dna->sample_number);
        if($this->authorize('browse', [Dna::class])) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            $this->setViewDataCrudFields(trans('labels.view_model', ['model'=>'DNA']), 'View', $skeletalelement, $dna);
            return view('dnas.show', $this->viewData);
        }
    }

    public function store(DnaRequest $request)
    {
        $input = $request->all();
        $object = SkeletalElement::find($input['se_id']);
        $this->logInfo(__METHOD__, $object->id.":".$object->key);
        if ($this->authorize('add', [Dna::class])) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
                try {
                    if($this->checkUniqueDnaSampleNumber($request, $object) == false) {
                        Session::flash('alert_message', trans('messages.model_add_unsuccessful', ['model'=>'DNA'])." ".trans('Sample number already exists within the accession.'));
                        return redirect()->back();
                    }
                    $this->populateCreateFieldsWithUserOrgProjectIDs($input, $object);
                    $input['sb_id'] = $object->bone->id;
                    $dna = Dna::create($input);

                    // If DNA is successfully created then mark the SE as being DNA Sampled.
                    $dna->skeletalelement->fill(['dna_sampled' => true])->save();
                    Session::flash('flash_message', trans('messages.model_add_successful', ['model'=>'DNA']));
                    return redirect('/skeletalelements/'.$dna->skeletalelement->id.'/dnas/'.$dna->id);
                } catch (QueryException $ex) {
                    $this->logQueryException(__METHOD__, $request, $ex);
                    Session::flash('alert_message', trans('messages.model_add_unsuccessful', ['model'=>'DNA']));
                    return redirect()->back();
                }
        }
            $this->logInfo(__METHOD__, "END");
            return redirect()->back();
    }

    public function update(Dna $dna, DnaRequest $request)
    {
        $se = $dna->se;
        $this->logInfo(__METHOD__, $dna->se->id.":".$dna->se->key." Sample Number:".$dna->sample_number);
        $input = $request->all();
        $input['se_id'] = $se->id;
        if ($this->authorize('edit', [Dna::class])) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            try {
                $dna = $dna;
                $this->populateUpdateFields($input);
                $dna->update($input);
                Session::flash('flash_message', trans('messages.model_update_successful', ['model'=>'DNA']));
                return redirect('/skeletalelements/'.$dna->skeletalelement->id.'/dnas/'.$dna->id);
            } catch (QueryException $ex) {
                $this->logQueryException(__METHOD__, $request, $ex);
                Session::flash('alert_message', trans('messages.model_update_unsuccessful', ['model'=>'DNA']));
                return redirect()->back();
            }
        }
        $this->logInfo(__METHOD__, ' - End: '.$se->id.":".$se->key.' DNA-id='.$dna->id);
        return redirect()->back();
    }

    /**
     * @param Request $request
     * @param SkeletalElement $skeletalelement
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(SkeletalElement $skeletalelement, Dna $dna, Request $request)
    {
        $object = $dna;
        $this->logInfo(__METHOD__, $skeletalelement->id.":".$skeletalelement->key." Sample Number:".$dna->sample_number);
        if ($this->authorize('delete', [Dna::class, $object])) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            try {
                $object->delete();
                Session::flash('flash_message', trans('messages.model_delete_successful', ['model'=>'DNA']));
                return redirect('skeletalelements/'.$skeletalelement->id);
            } catch (QueryException $ex) {
                $this->logQueryException(__METHOD__, $request, $ex);
                Session::flash('alert_message', trans('messages.model_delete_unsuccessful', ['model'=>'DNA']));
                return redirect()->back();
            }
        }
        $this->logInfo(__METHOD__, "End");
        return redirect()->back();
    }

    public function checkUniqueDnaSampleNumber($request, $se) {
        $flag = true;
        $this->logInfo(__METHOD__, $se->id.":".$se->key);
        try {
            $Dnas = Dna::where('sample_number', $request['sample_number'])->get();
            foreach ($Dnas as $dna) {
                $dup_se = $dna->skeletalelement;
                if(isset($dup_se) && ($dup_se->accession_number == $se->accession_number)) {
                    $this->logInfo(__METHOD__, "Duplicate DNA Sample Number:".$request['sample_number'].", New Record ".$se->id.":".$se->key ." Existing Record ".$dup_se->id.":".$dup_se->key);
                    $flag = false;
                }
            }
        } catch (QueryException $ex) {
            $this->logQueryException(__METHOD__, $request, $ex);
            return $flag;
        }
        return $flag;
    }

//    private function consensusDNA(SkeletalElement $skeletalelement)
//    {
//        $this->logInfo(__METHOD__);
//        if ($this->authorize('read', [Dna::class])) {
//            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
//            $dnas = collect();
//            foreach($skeletalelement->dna as $dna){
//                $dnas = $dnas->merge($dna);
//            }
//            // need to change id/sample number?
//            $consensusDna = Dna::create((array)$dnas);
//            return $consensusDna;
//        }
//    }

    /**
     * set the common CRUD fields of the viewData array
     *
     * @param string $heading
     * @param string $crud
     * @param null $skeletalelement
     * @param null $dna
     */
    private function setViewDataCrudFields($heading="", $crud="", $skeletalelement=null, $dna=null)
    {
        $this->viewData['heading'] = $heading;
        $this->viewData['CRUD_Action'] = $crud;
        $this->viewData['skeletalelement'] = $skeletalelement;
        $this->viewData['dna'] = $dna;
        $this->viewData['list_lab'] = Lab::where('type', 'Genomics')->pluck('name', 'id');
        $this->viewData['list_mito_haplogroup'] = Haplogroup::orderBy('letter')->where('type', 'Mito')->get()->pluck('key','id');
        $this->viewData['list_y_haplogroup'] = Haplogroup::orderBy('letter')->where('type', 'Ystr')->get()->pluck('key', 'id');
        $this->viewData['list_auto_method'] = DnaAnalysisType::where('type', 'auto')->get()->pluck('name', 'name');
        $this->viewData['list_y_method'] = DnaAnalysisType::where('type', 'y')->get()->pluck('name', 'name');
        $this->viewData['list_mito_method'] = DnaAnalysisType::where('type', 'mito')->get()->pluck('name', 'name');
    }
}
