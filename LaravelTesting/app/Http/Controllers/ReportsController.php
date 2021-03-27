<?php

/**
 * Reports Controller
 *
 * @category   Reports
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
use App\Isotope;
use App\Measurement;
use App\Method;
use App\MethodFeature;
use App\Pathology;
use App\Repository\ReportsRepository;
use App\Scopes\ProjectScope;
use App\SkeletalBone;
use App\SkeletalElement;
use App\Trauma;
use App\User;
use Auth;
use Carbon\Carbon;
use DB;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\View\View;
use Log;
use OwenIt\Auditing\Models\Audit;
use Session;

class ReportsController extends Controller
{
    protected $today;
    protected $criteriaData = [];
    protected $criteriaSelections = "";

    /**
     * $repo is injected into the Controller via framework service container
     * 
     * @var ReportsRepository
     */
    protected $repo;

    public function __construct(ReportsRepository $repo)
    {
        parent::__construct();

        $this->initialize();

        $this->repo = $repo;
        $this->today = Carbon::now();
        $this->criteriaData = ['sb_id' => "", 'side' => "", 'completeness' => "", 'measured' => false, 'dna_sampled' => false,
            'ystr' => false, 'astr' => false, 'ct_scanned' => false, 'xray_scanned' => false, 'clavicle_triage' => false,
            'inventoried' => false, 'reviewed' => false, 'taphonomy_id' => "", 'measurement_id' => "",
            'inventoried_by_user' => 0, 'reviewed_by_user' => 0,
            'heading' => "", 'groupby_sb_id' => "", 'groupby_taphonomy_id' => "", 'groupby' => ""
        ];
    }

    protected function initialize()
    {
        $this->viewData['list_sb'] = $this->list_sb = SkeletalBone::orderBy('name', 'asc')->pluck('name', 'id');
        $this->viewData['list_side'] = $this->list_side = SkeletalElement::$side;
        $this->viewData['list_completeness'] = $this->list_completeness = SkeletalElement::$completeness;
        $this->viewData['initialshow'] = $this->initialshow = false;
        $this->viewData['skeletal_an'] = $this->skeletal_an = null;
        $this->viewData['skeletal_p1'] = $this->skeletal_p1 = null;
        $this->viewData['skeletal_p2'] = $this->skeletal_p2 = null;
        $this->viewData['list_se'] = array();
        $this->viewData['se'] = null;
    }

    public function search()
    {
        $this->logInfo(__METHOD__);

        $this->setViewDataCommonFields( trans('labels.se_association_report') );
        $this->viewData['searchstring'] = '';
        $this->viewData['reporttype'] = '';
        $this->viewData['searchby'] = 'AN';

        return view('reports.search', $this->viewData);
    }
    
    public function searchGo(Request $request) 
    {
        $this->logInfo(__METHOD__, " SearchBy:" . $request->searchby . " SearchString:" . $request->searchstring);
        if ($this->authorize('browse', [SkeletalElement::class])) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            try {
                $this->setViewDataCommonFields(trans('labels.se_association_report'), false);
                $this->viewData['searchstring'] = $request->searchstring;
                $this->viewData['searchby'] = $request->searchby;
                $this->viewData['reporttype'] = $request->reporttype;

                switch ($request->searchby) {
                    case 'AN':
                        $searchParams = $this->repo->getSearchParams(ReportsRepository::ACCESSIONNUM, $request->searchstring);
                        break;
                    case 'P1':
                        $searchParams = $this->repo->getSearchParams(ReportsRepository::PROV1, $request->searchstring);
                        break;
                    case 'P2':
                        $searchParams = $this->repo->getSearchParams(ReportsRepository::PROV2, $request->searchstring);
                        break;
                    case 'DN':
                        $searchParams = $this->repo->getSearchParams(ReportsRepository::DESIGNATOR, $request->searchstring);
                        break;
                    default:
                        $searchParams = $this->repo->getSearchParams(ReportsRepository::ACCESSIONNUM, $request->searchstring);
                        break;
                }
                // dd($searchParams);
                switch ($request->reporttype) {
                    case 'methods':
                        $results = $this->repo->doMethodsSearch($searchParams);
                        break;
                    case 'measurements':
                        $this->viewData['measurement_headers'] = array('Cra_01', 'Cra_02', 'Cra_03', 'Cra_04', 'Cra_05', 'Cra_06', 'Cra_07', 'Cra_08', 'Cra_09', 'Cra_10', 'Cra_11', 'Cra_12', 'Cra_13', 'Cra_14', 'Cra_15', 'Cra_16', 'Cra_17', 'Cra_18', 'Cra_19', 'Cra_20', 'Cra_21', 'Cra_22', 'Cra_23', 'Cra_24', 'Cra_25', 'Cra_26', 'Cra_27', 'Cra_28', 'Man_01', 'Man_02', 'Man_03', 'Man_04', 'Man_05', 'Man_06', 'Man_07', 'Man_08', 'Man_09', 'Man_10', 'Cla_01', 'Cla_02', 'Cla_03', 'Cla_04', 'Cla_05', 'Cla_06', 'Cla_07', 'Cla_08', 'Cla_09', 'Sca_01', 'Sca_02', 'Sca_03', 'Sca_04', 'Sca_05', 'Hum_01', 'Hum_02', 'Hum_06', 'Hum_03', 'Hum_07', 'Hum_04', 'Hum_05', 'Hum_08', 'Hum_09', 'Rad_01', 'Rad_02', 'Rad_03', 'Rad_05', 'Rad_06', 'Rad_07', 'Rad_08', 'Rad_09', 'Rad_04', 'Rad_10', 'Uln_01', 'Uln_02', 'Uln_03', 'Uln_04', 'Uln_05', 'Uln_06', 'Uln_09', 'Uln_10', 'Uln_11', 'Uln_07', 'Uln_08', 'MC1_01', 'MC2_01', 'MC3_01', 'MC4_01', 'MC5_01', 'Scp_01', 'Lun_01', 'Tri_01', 'Pis_01', 'Tzm_01', 'Tzd_01', 'Cap_01', 'Ham_01', 'Sac_01', 'Sac_02', 'Sac_03', 'Sac_04', 'Sac_05', 'Osc_01', 'Osc_02', 'Osc_03', 'Osc_04', 'Osc_05', 'Osc_06', 'Osc_07', 'Osc_08', 'Osc_09', 'Osc_10', 'Osc_11', 'Osc_12', 'Osc_13', 'Osc_14', 'Osc_15', 'Osc_04', 'Osc_16', 'Fem_01', 'Fem_02', 'Fem_03', 'Fem_04', 'Fem_05', 'Fem_06', 'Fem_07', 'Fem_08', 'Fem_11', 'Fem_14', 'Fem_15', 'Fem_16', 'Fem_17', 'Fem_18', 'Fem_19', 'Fem_09', 'Fem_10', 'Fem_12', 'Fem_13', 'Tib_01', 'Tib_02', 'Tib_03', 'Tib_04', 'Tib_05', 'Tib_06', 'Tib_07', 'Tib_08', 'Tib_09', 'Tib_10', 'Tib_11', 'Tib_12', 'Tib_13', 'Tib_14', 'Tib_15', 'Tib_16', 'Fib_01', 'Fib_02', 'Fib_03', 'Fib_04', 'Fib_05', 'Cal_01', 'Cal_02', 'Cal_03', 'Cal_04', 'Cal_05', 'Tal_01', 'Tal_03', 'Tal_02', 'MT1_01', 'MT2_01', 'MT3_01', 'MT4_01', 'MT5_01', 'Cub_01', 'Nav_01', 'Cf1_01', 'Cf2_01', 'Cf3_01', 'Pat_01', 'Pat_02', 'Pat_03', 'Cer1_01', 'Cer1_03', 'Cer2_01', 'Cer1_02', 'Cer1_04', 'Cer2_02');
                        $results = $this->repo->doMeasurementsSearch($searchParams);
                        break;
                    case 'dna':
                        $results = $this->repo->doDNASearch($searchParams);
                        break;
                    default:
                        $results = $this->repo->doMethodsSearch($searchParams);
                        break;
                }

                $this->viewData['results'] = $results;
                return view('reports.search', $this->viewData);
            } catch (QueryException $ex) {
                $this->logQueryException(__METHOD__, $ex);
                Session::flash('alert_message', trans('messages.search_failed', ['model'=>'Specimens']));
                return redirect()->back();
            }
        }
    }

    public function advanced()
    {
        $this->logInfo(__METHOD__);
        if ($this->authorize('browse', [SkeletalElement::class])) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            $this->setViewDataCommonFields(trans('labels.advanced_report'));
            $this->viewData['list_user'] = $this->list_user = User::where('org_id', '=', $this->theUser->org_id)->pluck('name', 'id');
            return view('reports.advanced.search', $this->viewData, $this->criteriaData);
        }
    }

    public function advancedGo(Request $request)
    {
        if ($this->authorize('browse', [SkeletalElement::class])) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            try {
                $query = SkeletalElement::with('user', 'skeletalbone', 'reviewer'); // Load User and Reveiewer relations
                $this->buildCriteriaData($request, $query);
                $skeletalelements = $query->get();
                $this->setViewDataCommonFields(trans('labels.advanced_report'), false, $request, $skeletalelements);
                $this->viewData['list_user'] = $this->list_user = User::where('org_id', '=', $this->theUser->org_id)->pluck('name', 'id');
                $skeletalelements = $this->whereANP1P2($request, $skeletalelements);

                //Store data in Session Storage for loading Search page in breadcrumbs
                Session::put('seAdvancedSearch', $skeletalelements);
                $this->logInfo(__METHOD__, $this->criteriaSelections . " Report record count:" . count($skeletalelements));
                return view('reports.advanced.search', $this->viewData, $this->criteriaData);
            } catch (QueryException $ex) {
                $this->logQueryException(__METHOD__, $ex);
                Session::flash('alert_message', trans('messages.search_failed', ['model'=>'Advanced Specimen']));
                return redirect()->back();
            }
        }
    }

    public function chainofcustody()
    {
        $this->logInfo(__METHOD__);
        if ($this->authorize('browse', [SkeletalElement::class])) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            $this->setViewDataCommonFields(trans('labels.chain_of_custody_report'));
            $this->viewData['skeletal_bone'] = null;
            $this->viewData['skeletal_side'] = 'Left';

            return view('reports.chainofcustody.search', $this->viewData);
        }
    }

    public function chainofcustodyGo( Request $request )
    {
        $this->logInfo(__METHOD__);
        if ($this->authorize('browse', [SkeletalElement::class])) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            try {
                $query = SkeletalElement::whereIn('id', $request['skeletal_elements']);
                $skeletalelements = $query->get();
                $this->viewData['skeletalelements'] = $skeletalelements;
                $skeletalelements = $this->whereANP1P2($request, $skeletalelements);
                $query = Audit::where('audits.auditable_id', $request['skeletal_elements'])->latest('created_at');
                $audit = $query->get();
                $this->viewData['audit'] = $audit;
                $this->setViewDataCommonFields(trans('labels.chain_of_custody_report'), false, $request, $skeletalelements);
                $this->viewData['skeletal_bone'] = null;
                $this->viewData['skeletal_side'] = null;
                $this->viewData['list_se'] = $skeletalelements->pluck('key_bone_side', 'id');

                $this->logInfo(__METHOD__, $this->criteriaSelections . " Report record count:" . count($skeletalelements));
                return view('reports.chainofcustody.search', $this->viewData);
            } catch (QueryException $ex) {
                $this->logQueryException(__METHOD__, $ex);
                Session::flash('alert_message', trans('messages.search_failed', ['model'=>'SkeletalElement']));
                return redirect()->back();
            }
        }
    }

    public function showsepairs()
    {
        if ($this->authorize('browse', [SkeletalElement::class])) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            $this->setViewDataCommonFields(trans('labels.pair_matching_data_visualization'));
            $this->viewData['rightside'] = null;
            $this->viewData['leftside'] = null;
            $this->criteriaData['heading'] = trans('labels.pair_matching_data_visualization');

            return view('reports.sepairs', $this->viewData, $this->criteriaData);
        }
    }

    public function sepairs(Request $request)
    {
        if ($this->authorize('browse', [SkeletalElement::class])) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            try {
                $sb_id = $request['sb_id'];
                $query = DB::table('se_pair')
                    ->select('se_id', 'pair_id', 'skeletal_elements.sb_id', 'skeletal_elements.side', 'skeletal_elements.completeness', DB::raw('COUNT(*) as count'))
                    ->where('sb_id', $sb_id)
                    ->join('skeletal_elements', 'se_pair.se_id', '=', 'skeletal_elements.id')
                    ->groupby('se_id', 'pair_id', 'sb_id', 'side', 'completeness');

                $rightside = $query->get();
                $leftside = $rightside;

                $this->setViewDataCommonFields(trans('labels.pair_matching_data_visualization'), false, $request);
                $this->viewData['rightside'] = $rightside;
                $this->viewData['leftside'] = $leftside;
                $this->criteriaData['sb_id'] = $sb_id;
                $this->criteriaData['heading'] = trans('labels.pair_matching_data_visualization');

                return view('reports.sepairs', $this->viewData, $this->criteriaData);
            } catch (QueryException $ex) {
                $this->logQueryException(__METHOD__, $ex);
                Session::flash('alert_message', trans('messages.search_failed', ['model'=>'SE Pairs']));
                return redirect()->back();
            }
        }
    }

    public function secomp(Request $request)
    {
        if ($this->authorize('browse', [SkeletalElement::class])) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            try {
                $sb_id = $request['sb_id'];
                $query = DB::table('skeletal_elements')->select('sb_id', DB::raw('COUNT(*) as count'))->groupby('sb_id');
                $se_groupby_sb = $query->get();

                $query = DB::table('skeletal_elements')->select('sb_id', DB::raw('COUNT(*) as count'))->groupby('sb_id');
                $se_groupby_sb = $query->get();

//        dd([$rightside, $leftside]);
                $this->setViewDataCommonFields(trans('labels.pair_matching_data_visualization'), false, $request);
                $this->criteriaData['sb_id'] = $sb_id;
                $this->criteriaData['heading'] = trans('labels.pair_matching_data_visualization');

                return view('reports.sepairs', $this->viewData, $this->criteriaData);
            } catch (QueryException $ex) {
                $this->logQueryException(__METHOD__, $ex);
                Session::flash('alert_message', trans('messages.search_failed', ['model'=>'Pair Matching']));
                return redirect()->back();
            }
        }
    }

    private function buildCriteriaData($request, &$query)
    {
        $this->logInfo(__METHOD__);
        $this->criteriaData['sb_id'] = "";
        $this->criteriaData['side'] = "";
        $this->criteriaData['completeness'] = "";
        $this->criteriaData['taphonomy_id'] = "";
        $this->criteriaData['measurement_id'] = "";

        $this->criteriaData['groupby_sb_id'] = "";
        $this->criteriaData['groupby_taphonomy_id'] = "";
        $this->criteriaData['groupby'] = "";

        // Specimen
        if ($request['sb_id'] != "") {
            $this->criteriaData['sb_id'] = $request['sb_id'];
            $query->where('sb_id', $this->criteriaData['sb_id']);
            $this->criteriaSelections .= " Bone Id:" . $this->criteriaData['sb_id'];
        }
        if ($request['side'] != "") {
            $this->criteriaData['side'] = $request['side'];
            $query->where('side', $this->criteriaData['side']);
            $this->criteriaSelections .= " Side:" . $this->criteriaData['side'];
        }
        if ($request['completeness'] != "") {
            $this->criteriaData['completeness'] = $request['completeness'];
            $query->where('completeness', $this->criteriaData['completeness']);
            $this->criteriaSelections .= " Completeness:" . $this->criteriaData['completeness'];
        }
        if ($request['inventoried_by_user'] != "") {
            $this->criteriaData['inventoried_by_user'] = $request['inventoried_by_user'];
            $query->where('user_id', $this->criteriaData['inventoried_by_user']);
            $this->criteriaSelections .= " InventoriedByUser:" . $this->criteriaData['inventoried_by_user'];
        }
        if ($request['reviewed_by_user'] != "") {
            $this->criteriaData['reviewed_by_user'] = $request['reviewed_by_user'];
            $query->where('reviewer_id', $this->criteriaData['reviewed_by_user']);
            $this->criteriaSelections .= " ReviewedByUser:" . $this->criteriaData['reviewed_by_user'];
        }
        if ($request['measured'] != "") {
            $this->criteriaData['measured'] = true;
            $query->where('measured', true);
            $this->criteriaSelections .= " Measured:true";
        }
        if ($request['dna_sampled'] != "") {
            $this->criteriaData['dna_sampled'] = true;
            $query->where('dna_sampled', true);
            $this->criteriaSelections .= " DNASampled:true";
        }
        if ($request['ystr'] != "") {
            $this->criteriaData['ystr'] = true;
            $query->where('ystr', true);
        }
        if ($request['astr'] != "") {
            $this->criteriaData['astr'] = true;
            $query->where('astr', true);
        }
        if ($request['ct_scanned'] != "") {
            $this->criteriaData['ct_scanned'] = true;
            $query->where('ct_scanned', true);
            $this->criteriaSelections .= " CTScanned:true";
        }
        if ($request['xray_scanned'] != "") {
            $this->criteriaData['xray_scanned'] = true;
            $query->where('xray_scanned', true);
            $this->criteriaSelections .= " XRayScanned:true";
        }
        if ($request['clavicle_triage'] != "") {
            $this->criteriaData['clavicle_triage'] = true;
            $query->where('clavicle_triage', true);
            $this->criteriaSelections .= " ClavicleTriage:true";
        }
        if ($request['inventoried'] != "") {
            $this->criteriaData['inventoried'] = true;
            $query->where('inventoried', true);
            $this->criteriaSelections .= " Inventoried:true";
        }
        if ($request['reviewed'] != "") {
            $this->criteriaData['reviewed'] = true;
            $query->where('reviewed', true);
            $this->criteriaSelections .= " Reviewed:true";
        }

        // Taphonomy
        if ($request['taphonomy_id'] != "") {
            $this->criteriaData['taphonomy_id'] = $request['taphonomy_id'];
            $query->where('taphonomy_id', $this->criteriaData['taphonomy_id']);
        }
        if ($request['measurement_id'] != "") {
            $this->criteriaData['measurement_id'] = $request['measurement_id'];
            $query->where('measurement_id', $this->criteriaData['measurement_id']);
        }

        if ($request['groupby'] != "") {
            $this->criteriaData['groupby'] = $request['groupby'];
        }

        // Tags
        if ($request['taggable'] != "") {
            $this->criteriaData['taggable'] = $request['taggable'];
        }
        if ($request['taglist'] != "") {
            $this->criteriaData['taglist'] = $request['taglist'];
        }
    }

    public function mtdna()
    {
        $this->logInfo(__METHOD__);
        if ($this->authorize('browse', [Dna::class])) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            $this->setViewDataCommonFields(trans('labels.mitochondrial_dna_report'));
            $this->setViewDataMtDnaFields();
            return view('reports.dna.mito.search', $this->viewData);
        }
    }

    private function setViewDataMtDnaFields(Request $request = null)
    {
        $mitolist =  Dna::groupBy('mito_sequence_number')->orderby('mito_sequence_number')->pluck('mito_sequence_number','mito_sequence_number');
        $mitosubgrouplist = Dna::groupBy('mito_sequence_subgroup')->orderby('mito_sequence_subgroup')->pluck('mito_sequence_subgroup', 'mito_sequence_subgroup');
        $filteredmitolist = $mitolist->filter(function ($value, $key) { return $value != ''; });
        $filteredmitosubgrouplist = $mitosubgrouplist->filter(function ($value, $key) { return $value != ''; });

        $this->viewData['request_date_start'] = isset($request) ? $request->input('request_date_start'): null;
        $this->viewData['request_date_end'] = isset($request) ? $request->input('request_date_end'): null;
        $this->viewData['receive_date_start'] = isset($request) ? $request->input('receive_date_start'): null;
        $this->viewData['receive_date_end'] = isset($request) ? $request->input('receive_date_end'): null;

        $this->viewData['list_mito'] = $filteredmitolist;
        $this->viewData['list_mitosubgroup'] = $filteredmitosubgrouplist;
        $this->viewData['list_confidence'] = Dna::$results_confidence;
        $this->viewData['mito'] = isset($request) ? $request->input('mitosequencelist') : null;
    }

    public function mtdnaGo(Request $request)
    {
        $request->validate([
            'request_date_start' => 'nullable|date| before:request_date_end',
            'receive_date_start' => 'nullable|date| before:receive_date_end',
        ]);
        $this->logInfo(__METHOD__);
        if ($this->authorize('browse', [SkeletalElement::class])) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            try {
                $this->setViewDataCommonFields(trans('labels.mitochondrial_dna_report'), false, $request);
                $this->setViewDataMtDnaFields($request);
                $mitolist = $request->input('mitosequencelist');
                $mitosubgrouplist = $request->input('mitosequencesubgrouplist');
                $resultsconfidence = $request->input('resultsconfidencelist');
                $request_start = $request->input('request_date_start');
                $request_end = $request->input('request_date_end');
                $receive_start = $request->input('receive_date_start');
                $receive_end = $request->input('receive_date_end');

                $finalresults = Dna::withoutGlobalScope(ProjectScope::class)
                    ->where('skeletal_elements.project_id', $this->theProject->id)
                    ->join('skeletal_elements', 'skeletal_elements.id', '=', 'dnas.se_id');
                if (isset($mitolist)) {
                    $finalresults = $finalresults->whereIn('mito_sequence_number', $mitolist);
                    $this->criteriaSelections .= " Mito Sequence Number:" . json_encode($mitolist);
                }
                if (isset($mitosubgrouplist) && $mitosubgrouplist[0] != null) {
                    $finalresults = $finalresults->where('mito_sequence_subgroup', $mitosubgrouplist[0]);
                    $this->criteriaSelections .= " Mito Sequence Subgroup:" . json_encode($mitosubgrouplist[0]);
                }
                if (isset($resultsconfidence) && $resultsconfidence[0] != null) {
                    $finalresults = $finalresults->where('mito_results_confidence', $resultsconfidence[0]);
                    $this->criteriaSelections .= " Results Confidence:" . json_encode($resultsconfidence[0]);
                }
                if ($request_start != null && $request_end != null) {
                    $finalresults = $finalresults->whereBetween('mito_request_date', [$request_start, $request_end]);
                    $this->criteriaSelections .= " Request Dates From:" . json_encode($request_start);
                    $this->criteriaSelections .= " Request Dates To:" . json_encode($request_end);
                }
                if ($receive_start != null && $receive_end != null) {
                    $finalresults = $finalresults->whereBetween('mito_receive_date', [$receive_start, $receive_end]);
                    $this->criteriaSelections .= " Receive Dates From:" . json_encode($receive_start);
                    $this->criteriaSelections .= " Receive Dates To:" . json_encode($receive_end);
                }
                $finalresults = $this->whereANP1P2($request, $finalresults, 'skeletal_elements.accession_number', 'skeletal_elements.provenance1', 'skeletal_elements.provenance2');
                $finalresults = $finalresults->pluck('dnas.id');
                $finalresults = Dna::with(['skeletalelement'])->whereIn('id', $finalresults)->get();
                $this->viewData['dnas'] = $finalresults;
                $this->logInfo(__METHOD__, $this->criteriaSelections . " Report record count:" . count($finalresults));
//                return view('reports.dna.mito.search', $this->viewData);
                return response()->json($this->viewData);    // To fetch the response in the component
            } catch (QueryException $ex) {
                $this->logQueryException(__METHOD__, $ex);
                Session::flash('alert_message', trans('messages.search_failed', ['model'=>'MtDNA']));
                return redirect()->back();
            }
        }
    }

    public function mtdnaQuickLink($mitosequencelist) {
        $request = new Request();
        $request->replace(['mitosequencelist' => $mitosequencelist,
            'sb_select' => null, 'side_select' => null, 'p1_select' => null, 'p2_select' => null,
            'an_select' => null, 'mitosequencesubgrouplist' => null, 'resultsconfidencelist' => null
        ]);
        $this->viewData['mito'] =$request['mitosequencelist'];
        return view('reports.dna.mito.search', $this->viewData);
    }
    public function austrdna()
    {
        $this->logInfo(__METHOD__);
        if ($this->authorize('browse', [Dna::class])) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            $this->setViewDataCommonFields(trans('labels.austr_dna_report'));
            $this->setViewDataAuSTRDnaFields();
            return view('reports.dna.auSTR.search', $this->viewData);
        }
    }

    private function setViewDataAuSTRDnaFields(Request $request = null)
    {
        $austrlist =  Dna::groupBy('austr_sequence_number')->orderby('austr_sequence_number')->pluck('austr_sequence_number','austr_sequence_number');
        $filteredaustrlist = $austrlist->filter(function ($value, $key) { return $value != ''; });
        $austrsubgrouplist = Dna::groupBy('austr_sequence_subgroup')->orderby('austr_sequence_subgroup')->pluck('austr_sequence_subgroup', 'austr_sequence_subgroup');
        $filteredaustrsubgrouplist = $austrsubgrouplist->filter(function ($value, $key) { return $value != ''; });
        $this->viewData['request_date_start'] = isset($request) ? $request->input('request_date_start'): null;
        $this->viewData['request_date_end'] = isset($request) ? $request->input('request_date_end'): null;
        $this->viewData['receive_date_start'] = isset($request) ? $request->input('receive_date_start'): null;
        $this->viewData['receive_date_end'] = isset($request) ? $request->input('receive_date_end'): null;

        $this->viewData['list_austr'] = $filteredaustrlist;
        $this->viewData['list_austrsubgroup'] = $filteredaustrsubgrouplist;
        $this->viewData['list_confidence'] = Dna::$results_confidence;
        $this->viewData['austr'] = isset($request) ? $request->input('austrsequencelist') : null;
    }

    public function austrdnaGo(Request $request)
    {
        $request->validate([
            'request_date_start' => 'nullable|date| before:request_date_end',
            'receive_date_start' => 'nullable|date| before:receive_date_end',
        ]);
        $this->logInfo(__METHOD__);
        if ($this->authorize('browse', [SkeletalElement::class])) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            try {
                $this->setViewDataCommonFields(trans('labels.austr_dna_report'), false, $request);
                $this->setViewDataAuSTRDnaFields($request);
                $austrlist = $request->input('austrsequencelist');
                $austrsubgrouplist = $request->input('austrsequencesubgrouplist');
                $resultsconfidence = $request->input('resultsconfidencelist');
                $request_start = $request->input('request_date_start');
                $request_end = $request->input('request_date_end');
                $receive_start = $request->input('receive_date_start');
                $receive_end = $request->input('receive_date_end');


                $finalresults = Dna::withoutGlobalScope(ProjectScope::class)
                    ->where('skeletal_elements.project_id', $this->theProject->id)
                    ->join('skeletal_elements', 'skeletal_elements.id', '=', 'dnas.se_id');
                if ($austrlist != null) {
                    $finalresults = $finalresults->whereIn('austr_sequence_number', $austrlist);
                    $this->criteriaSelections .= " AuSTR Sequence Number:" . json_encode($austrlist);
                }

                if ($resultsconfidence[0] != null) {
                    $finalresults = $finalresults->where('austr_results_confidence', $resultsconfidence[0]);
                    $this->criteriaSelections .= " Results Confidence:" . json_encode($resultsconfidence[0]);
                }
                if ($request_start != null && $request_end != null) {
                    $finalresults = $finalresults->whereBetween('austr_request_date', [$request_start, $request_end]);
                    $this->criteriaSelections .= " Request Dates From:" . json_encode($request_start);
                    $this->criteriaSelections .= " Request Dates To:" . json_encode($request_end);
                }
                if ($receive_start != null && $receive_end != null) {
                    $finalresults = $finalresults->whereBetween('austr_receive_date', [$receive_start, $receive_end]);
                    $this->criteriaSelections .= " Receive Dates From:" . json_encode($receive_start);
                    $this->criteriaSelections .= " Receive Dates To:" . json_encode($receive_end);
                }
                $finalresults = $this->whereANP1P2($request, $finalresults, 'skeletal_elements.accession_number', 'skeletal_elements.provenance1', 'skeletal_elements.provenance2');
                $finalresults = $finalresults->pluck('dnas.id');
                $finalresults = Dna::with(['skeletalelement'])->whereIn('id', $finalresults)->get();
                $this->viewData['dnas'] = $finalresults;
                $this->logInfo(__METHOD__, $this->criteriaSelections . " Report record count:" . count($finalresults));
                return response()->json($this->viewData);
            } catch (QueryException $ex) {
                $this->logQueryException(__METHOD__, $ex);
                Session::flash('alert_message', trans('messages.search_failed', ['model'=>'austrDNA']));
                return redirect()->back();
            }
        }
    }

    public function austrdnaQuickLink($austrsequencelist)
    {
        $request = new Request();
        $request->replace(['austrsequencelist' => $austrsequencelist,
            'sb_select' => null, 'side_select' => null, 'p1_select' => null, 'p2_select' => null,
            'an_select' => null, 'resultsconfidencelist' => null
        ]);
        $this->viewData['austr'] =$request['austrsequencelist'];
        return view('reports.dna.auSTR.search', $this->viewData);
    }
    public function ystrdna()
    {
        $this->logInfo(__METHOD__);
        if ($this->authorize('browse', [Dna::class])) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            $this->setViewDataCommonFields(trans('labels.ystr_dna_report'));
            $this->setViewDataySTRDnaFields();
            return view('reports.dna.ySTR.search', $this->viewData);
        }
    }

    private function setViewDataySTRDnaFields(Request $request = null)
    {
        $ystrlist =  Dna::groupBy('ystr_sequence_number')->orderby('ystr_sequence_number')->pluck('ystr_sequence_number','ystr_sequence_number');
        $filteredystrlist = $ystrlist->filter(function ($value, $key) { return $value != ''; });
        $ystrsubgrouplist = Dna::groupBy('ystr_sequence_subgroup')->orderby('ystr_sequence_subgroup')->pluck('ystr_sequence_subgroup', 'ystr_sequence_subgroup');
        $filteredystrsubgrouplist = $ystrsubgrouplist->filter(function ($value, $key) { return $value != ''; });
        $this->viewData['request_date_start'] = isset($request) ? $request->input('request_date_start'): null;
        $this->viewData['request_date_end'] = isset($request) ? $request->input('request_date_end'): null;
        $this->viewData['receive_date_start'] = isset($request) ? $request->input('receive_date_start'): null;
        $this->viewData['receive_date_end'] = isset($request) ? $request->input('receive_date_end'): null;

        $this->viewData['list_ystr'] = $filteredystrlist;
        $this->viewData['list_ystrsubgroup'] = $filteredystrsubgrouplist;
        $this->viewData['list_confidence'] = Dna::$results_confidence;
        $this->viewData['ystr'] = isset($request) ? $request->input('ystrsequencelist') : null;
    }

    public function ystrdnaGo(Request $request)
    {
        $request->validate([
            'request_date_start' => 'nullable|date| before:request_date_end',
            'receive_date_start' => 'nullable|date| before:receive_date_end',
        ]);
        $this->logInfo(__METHOD__);
        if ($this->authorize('browse', [SkeletalElement::class])) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            try {
                $this->setViewDataCommonFields(trans('labels.ystr_dna_report'), false, $request);
                $this->setViewDataySTRDnaFields($request);
                $ystrlist = $request->input('ystrsequencelist');
                $ystrsubgrouplist = $request->input('ystrsequencesubgrouplist');
                $resultsconfidence = $request->input('resultsconfidencelist');
                $request_start = $request->input('request_date_start');
                $request_end = $request->input('request_date_end');
                $receive_start = $request->input('receive_date_start');
                $receive_end = $request->input('receive_date_end');

                $finalresults = Dna::withoutGlobalScope(ProjectScope::class)
                    ->where('skeletal_elements.project_id', $this->theProject->id)
                    ->join('skeletal_elements', 'skeletal_elements.id', '=', 'dnas.se_id');
                if ($ystrlist != null) {
                    $finalresults = $finalresults->whereIn('ystr_sequence_number', $ystrlist);
                    $this->criteriaSelections .= " Y-STR Sequence Number:" . json_encode($ystrlist);
                }
                if ($resultsconfidence[0] != null) {
                    $finalresults = $finalresults->where('ystr_results_confidence', $resultsconfidence[0]);
                    $this->criteriaSelections .= " Results Confidence:" . json_encode($resultsconfidence[0]);
                }
                if ($request_start != null && $request_end != null) {
                    $finalresults = $finalresults->whereBetween('ystr_request_date', [$request_start, $request_end]);
                    $this->criteriaSelections .= " Request Dates From:" . json_encode($request_start);
                    $this->criteriaSelections .= " Request Dates To:" . json_encode($request_end);
                }
                if ($receive_start != null && $receive_end != null) {
                    $finalresults = $finalresults->whereBetween('ystr_receive_date', [$receive_start, $receive_end]);
                    $this->criteriaSelections .= " Receive Dates From:" . json_encode($receive_start);
                    $this->criteriaSelections .= " Receive Dates To:" . json_encode($receive_end);
                }
                $finalresults = $this->whereANP1P2($request, $finalresults, 'skeletal_elements.accession_number', 'skeletal_elements.provenance1', 'skeletal_elements.provenance2');
                $finalresults = $finalresults->pluck('dnas.id');
                $finalresults = Dna::with(['skeletalelement'])->whereIn('id', $finalresults)->get();
                $this->viewData['dnas'] = $finalresults;
                $this->logInfo(__METHOD__, $this->criteriaSelections . " Report record count:" . count($finalresults));
                return response()->json($this->viewData);
            } catch (QueryException $ex) {
                $this->logQueryException(__METHOD__, $ex);
                Session::flash('alert_message', trans('messages.search_failed', ['model'=>'ystrDNA']));
                return redirect()->back();
            }
        }
    }

    public function ystrdnaQuickLink($ystrsequencelist) {
        $request = new Request();
        $request->replace(['ystrsequencelist' => $ystrsequencelist,
            'sb_select' => null, 'side_select' => null, 'p1_select' => null, 'p2_select' => null,
            'an_select' => null, 'resultsconfidencelist' => null
        ]);
        $this->viewData['ystr'] =$request['ystrsequencelist'];
        return view('reports.dna.ySTR.search', $this->viewData);
    }

    public function consolidatedANsearch()
    {
        $this->logInfo(__METHOD__);
        if ($this->authorize('browse', [SkeletalElement::class])) {
            $this->setViewDataCommonFields(trans('labels.consolidatedAN_report'));
            $this->viewData['list_accessions'] = Accession::where('consolidated_an', true)->pluck('number', 'number');

            return view('reports.consolidatedAccession.search', $this->viewData);
        }
    }

    public function consolidatedANsearchgo(Request $request)
    {
        $this->logInfo(__METHOD__);
        if ($this->authorize('browse', [SkeletalElement::class])) {
            try {
                $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
                $this->setViewDataCommonFields(trans('labels.consolidatedAN_report'), false, $request);
                $this->viewData['list_accessions'] = Accession::where('project_id', $this->theProject->id)->orderby('number')->pluck('number', 'number');
                $ANlist = $request['consolidatedAccessions'];
                $finalresults = SkeletalElement::whereIn('consolidated_an', $ANlist)->get();
                $this->viewData['results'] = $finalresults;

                return view('reports.consolidatedAccession.search', $this->viewData);
            } catch (QueryException $ex) {
                $this->logQueryException(__METHOD__, $ex);
                Session::flash('alert_message', trans('messages.search_failed', ['model'=>'Consolidated AN']));
                return redirect()->back();
            }
        }
    }

    public function articulations()
    {
        if ($this->authorize('browse', [SkeletalElement::class])) {
            $this->logInfo(__METHOD__);
            $this->setViewDataCommonFields(trans('labels.articulations_report'));
            $this->setViewDataArticulations();

            return view('reports.articulation.search', $this->viewData);
        }
    }

    private function setViewDataArticulations($show = false, Request $request = null)
    {
        $this->viewData['list_group'] = BoneGroup::orderBy('group_name')->pluck('group_name', 'group_name');
        $this->viewData['list_group_side'] = SkeletalElement::$side;
        $this->viewData['list_sb'] = SkeletalBone::pluck('name', 'id');
        $this->viewData['list_side'] = SkeletalElement::$side;
        $this->viewData['show'] = $show;
        $this->viewData['group'] = isset($request) ? $request->group : null;
        $this->viewData['group_side'] = isset($request) ? $request->group_side : null;
        $this->viewData['skeletal_bone'] = isset($request) ? $request->skeletal_bone : null;
        $this->viewData['side'] = isset($request) ? $request->side : null;
    }

    public function articulationsGo(Request $request)
    {
        $this->logInfo(__METHOD__);
        if ($this->authorize('browse', [SkeletalElement::class])) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            try {
                $this->setViewDataCommonFields(trans('labels.articulations_report'), false, $request);
                $this->setViewDataArticulations(true, $request);

                //establish select values
                if (isset($request->side_select)) {
                    $side = $request->side_select;
                    $this->criteriaSelections .= " Side:" . json_encode($side);
                } else {
                    $side = null;
                }
                $group = $request->group_select;
                $this->criteriaSelections .= " Specimen Group:" . json_encode($group);

                if (isset($request->group_side_select)) {
                    $group_side = $request->group_side_select;
                    $this->criteriaSelections .= " Specimen Group Side:" . json_encode($group_side);
                } else {
                    $group_side = null;
                }
                $skeletalbone = $request->sb_select;
                $this->criteriaSelections .= " Skeletal Bone:" . json_encode($skeletalbone);

                //if searching for specimens
                if (!isset($request->finalsearch)) {
                    $this->viewData['skeletalelements'] = null;
                    $this->viewData['skeletalelement'] = null;
                    $this->viewData['initialshow'] = true;

                    // check if doing bone & side search OR group & side search
                    if (isset($skeletalbone)) {
                        if (isset($side)) {
                            $skeletalelements = SkeletalElement::where('sb_id', $skeletalbone)->where('side', $side);
                        } else {
                            $skeletalelements = SkeletalElement::where('sb_id', $skeletalbone);
                        }
                        $skeletalelements = $this->whereANP1P2($request, $skeletalelements);
                        $skeletalelements = $skeletalelements->get();
                    } elseif (isset($group)) {
                        if (isset($group_side)) {
                            $skeletalbones = BoneGroup::where('group_name', $group)->pluck('sb_id');
                            $skeletalelements = SkeletalElement::whereIn('sb_id', $skeletalbones)->where('side', $group_side)->get();
                        } else {
                            $skeletalbones = BoneGroup::where('group_name', $group)->pluck('sb_id');
                            $skeletalelements = SkeletalElement::whereIn('sb_id', $skeletalbones)->get();
                        }
                    } else {
                        Session::flash('alert_message', 'Choose either bone group or skeletal bone');
                        $this->viewData['show'] = false;

                        return response()->json($this->viewData);
                        // return view('reports.articulation.search', $this->viewData);
                    }

                    $this->logInfo(__METHOD__, $this->criteriaSelections . " Report record count:" . count($skeletalelements));
                    if ($skeletalelements->isEmpty()) {
                        Session::flash('alert_message', trans('messages.no_records_found_refine_search', ['model' => 'Specimen']));
                        $this->viewData['show'] = false;

                        return response()->json($this->viewData);
                        // return view('reports.articulation.search', $this->viewData);
                    }
                    $this->viewData['list_skeletalelement'] = $skeletalelements->pluck('key', 'id');

                    return response()->json($this->viewData);
                    // return view('reports.articulation.search', $this->viewData);
                }

                //if searching for articulations
                if (isset($request->finalsearch)) {
                    $this->viewData['results'] = null;
                    $this->viewData['initialshow'] = false;
                    $this->viewData['skeletalelement'] = $request->skeletalelement;
                    $skeletalelement = $request->skeletalelement_select;

                    if (isset($skeletalelement)) {
                        // check if doing bone search OR group search
                        if (isset($skeletalbone)) {
                            $skeletalSelected = SkeletalElement::with('skeletalbone')->where('id', $skeletalelement)->first();
                            $articulation_ids = $skeletalSelected->getArticulationListAttribute();
                            $result = collect();
                            foreach ($articulation_ids as $articulation_id) {
                                $result->push(SkeletalElement::with('skeletalbone')->where('id', $articulation_id)->first());
                            }
                            if (isset($side)) {
                                $viewSkelEl = SkeletalElement::where('sb_id', $skeletalbone)->where('side', $side)->get();
                                $this->viewData['list_skeletalelement'] = $viewSkelEl->pluck('key', 'id');
                            } else {
                                $viewSkelEl = SkeletalElement::where('sb_id', $skeletalbone)->get();
                                $this->viewData['list_skeletalelement'] = $viewSkelEl->pluck('key', 'id');
                            }
                        } elseif (isset($group)) {
                            $skeletalSelected = SkeletalElement::with('skeletalbone')->where('id', $skeletalelement)->first();
                            $result = collect();
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
                                $skeletalbones = BoneGroup::where('group_name', $group)->pluck('sb_id');
                                $viewSkelEl = SkeletalElement::wherein('sb_id', $skeletalbones)->get();
                                $this->viewData['list_skeletalelement'] = $viewSkelEl->pluck('key', 'id');
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
                                $skeletalbones = BoneGroup::where('group_name', $group)->pluck('sb_id');
                                $viewSkelEl = SkeletalElement::wherein('sb_id', $skeletalbones)->get();
                                $this->viewData['list_skeletalelement'] = $viewSkelEl->pluck('key', 'id');
                            }
                        } else {
                            // Session::flash('alert_message', 'Choose either bone group or skeletal bone');
                            $this->viewData['show'] = false;

                            return response()->json([
                                $this->viewData,
                                'alert_message' => 'Choose either bone group or skeletal bone'
                            ]);
                            // return view('reports.articulation.search', $this->viewData);
                        }
                        $this->viewData['se'] = $skeletalSelected;
                        $this->viewData['skeletalelements'] = $result;
                        $this->logInfo("Specimen Chosen:" . $skeletalSelected->id . "Report record count articulations:" . count($result));

                        return response()->json($this->viewData);
                        // return view('reports.articulation.search', $this->viewData);
                    } else {
                        // Session::flash('alert_message', 'Choose a skeletal element');
                        $this->viewData['show'] = false;

                        return response()->json([
                            $this->viewData,
                            'alert_message' => 'Choose a skeletal element'
                        ]);
                        // return view('reports.articulation.search', $this->viewData);
                    }
                }
            } catch (QueryException $ex) {
                $this->logQueryException(__METHOD__, $ex);
                Session::flash('alert_message', trans('messages.search_failed', ['model'=>'Articulation']));
                return redirect()->back();
            }
        }
    }

    public function anomalys()
    {
        $this->logInfo(__METHOD__);
        if ($this->authorize('browse', [SkeletalElement::class])) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            $this->setViewDataCommonFields(trans('labels.anomaly_report'));
            $this->setViewDataAnomaly();

            return view('reports.anomaly.search', $this->viewData);
        }
    }

    private function setViewDataAnomaly(Request $request = null)
    {
        $this->viewData['list_anomaly'] = Anomaly::groupBy('individuating_trait')->orderBy('individuating_trait')->pluck('individuating_trait', 'individuating_trait');
        $this->viewData['skeletal_bone'] = isset($request) ? $request['sb_select'] : null;
        $this->viewData['skeletal_side'] = isset($request) ? $request['side_select'] : null;
        $this->viewData['skeletal_anomaly'] = isset($request) ? $request['anomaly_select'] : null;
    }

    public function anomalysGo(Request $request)
    {
        $this->logInfo(__METHOD__);
        if ($this->authorize('browse', [SkeletalElement::class])) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            try {
                $query = $this->buildCriteriaAnomalyData($request);
                $skeletalelements = $query->all();
                $anomalys = Anomaly::groupBy('individuating_trait')->orderBy('individuating_trait')->pluck('individuating_trait', 'individuating_trait');

                $this->setViewDataCommonFields(trans('labels.anomaly_report'), false, $request, $skeletalelements);
                $this->setViewDataAnomaly($request);
                if ($request['anomaly_select'] == "") {
                    $this->viewData['skeletal_anomaly'] = Anomaly::groupBy('individuating_trait')->orderBy('individuating_trait')->where('sb_id', $request['sb_select'])->pluck('individuating_trait', 'individuating_trait');
                }
                $this->viewData['anomalys'] = $anomalys;
                $this->viewData['skeletalelements'] = $skeletalelements;
                $this->logInfo(__METHOD__, $this->criteriaSelections . " Report record count:" . count($skeletalelements));

                return view('reports.anomaly.search', $this->viewData);
            } catch (QueryException $ex) {
                $this->logQueryException(__METHOD__, $ex);
                Session::flash('alert_message', trans('messages.search_failed', ['model'=>'Anomaly']));
                return redirect()->back();
            }
        }
    }

    public function buildCriteriaAnomalyData( $request )
    {
        $this->criteriaData['sb_id'] = "";
        $this->criteriaData['side'] = "";
        $this->criteriaData['anomaly'] = "";
        $this->logInfo(__METHOD__);

        if ($request['anomaly_select'] != ""){
            $request['anomaly_select'] = explode(',', $request['anomaly_select']); // converting string of ids to array (Ex: "1,2,3" => [1,2,3])
            $this->criteriaData['anomaly'] = $request['anomaly_select'];
            $anomalys = $this->criteriaData['anomaly'];
            $anomCollection1 = new Collection();
            foreach($anomalys as $anomaly){
                $anomCollection1->push(Anomaly::where('individuating_trait', $anomaly)->get());
            }
            $anomCollection2 = new Collection();
            foreach($anomCollection1 as $an){
                foreach($an as $a){
                    $anomCollection2->push($a->id);
                }
            }
            $query = SkeletalElement::withoutGlobalScope(ProjectScope::class)
                ->with(['anomalys', 'skeletalbone']) // Swetha: Eager load anomalys
                ->join('se_anomaly', 'skeletal_elements.id', '=', 'se_anomaly.se_id')
                ->where('skeletal_elements.project_id', $this->theProject->id)
                ->whereIn('anomaly_id', $anomCollection2 )
                ->select('skeletal_elements.*','se_anomaly.anomaly_id');
            $this->criteriaSelections .= " Anomaly:" . json_encode($request['anomaly_select']);
        }

        if ($request['anomaly_select'] == ""){
            $query = SkeletalElement::withoutGlobalScope(ProjectScope::class)
                ->join('se_anomaly', 'skeletal_elements.id', '=', 'se_anomaly.se_id')
                ->where('skeletal_elements.project_id', $this->theProject->id)
                ->select('skeletal_elements.*','se_anomaly.anomaly_id');
            $this->criteriaSelections .= " Anomaly:[None selected]";
        }

        $query = $this->whereANP1P2($request, $query);
        $query = $this->whereBoneSide($request, $query);
        $query = collect($query->get()->unique());
        return $query;
    }
    //This is for dental report
    public function dental()
    {

        $this->logInfo(__METHOD__);
        if ($this->authorize('browse', [SkeletalElement::class])) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            $this->setViewDataCommonFields(trans('labels.skeletal_elements'));
        //    $this->setViewDataDental();
            return view('reports.dental.search', $this->viewData);
        }
    }




    //This is the first zone search method
    /**
     * This is the method for the view screen for the zone search
     * @return Factory|View
     */
    public function zones()
    {
        $this->logInfo(__METHOD__);
        if ($this->authorize('browse', [SkeletalElement::class])) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            $this->setViewDataCommonFields(trans('labels.zones_report'));
            $this->setViewDataZoneSearchTypeHelp();
            $this->setViewDataZones();
            $this->viewData['skeletal_bone'] = null;
            $this->viewData['skeletal_side'] = null;
            $this->viewData['skeletal_zones'] = null;
            $this->viewData['search_type'] = trans('labels.inclusive');
            $this->viewData['list_zones'] = [''];

            return view('reports.zone.search', $this->viewData);
        }
    }

    private function setViewDataZones(Request $request = null)
    {
        $this->viewData['list_zone_search_type'] = [trans('labels.inclusive'), trans('labels.exclusive'), trans('labels.inclusive_only'), trans('labels.exclusive_only'), trans('labels.exclusive_or'), trans('labels.not_present')];
        $this->viewData['skeletal_bone'] = isset($request) ? $request['sb_select'] : null;
        $this->viewData['skeletal_side'] = isset($request) ? $request['side_select'] : null;
        $this->viewData['skeletal_zones'] = isset($request) ? $request['zone_select'] : null;
    }

    /**
     * This is the method that will return the results
     * of the zone search screen
     * @param Request $request
     * @return Factory|View
     */
    public function zonesGo( Request $request )
    {
        $this->logInfo(__METHOD__);
        if ($this->authorize('browse', [SkeletalElement::class])) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            try {
                switch ($request['search_type_select']) {
                    case '0':
                        $this->criteriaSelections .= " Search Type:Inclusive";
                        $query = $this->inclusiveZonesResults($request);
                        break;
                    case '1':
                        $this->criteriaSelections .= " Search Type:Exclusive";
                        $query = $this->exclusiveZonesResults($request);
                        break;
                    case '2':
                        $this->criteriaSelections .= " Search Type:Inclusive Only";
                        $query = $this->inclusiveOnlyZonesResults($request);
                        break;
                    case '3':
                        $this->criteriaSelections .= " Search Type:Exclusive Only";
                        $query = $this->exclusiveOnlyZonesResults($request);
                        break;
                    case '4':
                        $this->criteriaSelections .= " Search Type:Exclusive Or";
                        $query = $this->exclusiveOrZonesResults($request);
                        break;
                    case '5':
                        $this->criteriaSelections .= " Search Type:Not Present";
                        $query = $this->notPresentZonesResults($request);
                        break;
                }
                $skeletalelements = $query;

                $this->setViewDataCommonFields(trans('labels.zones_report'), false, $request, $skeletalelements);
                $this->setViewDataZoneSearchTypeHelp();
                $this->setViewDataZones($request);
                $this->viewData['zones'] = SkeletalBone::where('id', $request['sb_select'])->first()->zones()->orderBy('display_order')->get();
                $this->viewData['list_zones'] = SkeletalBone::where('id', $request['sb_select'])->first()->zones()->orderBy('display_order')->pluck('display_name', 'id')->all();
                $this->viewData['search_type'] = $request['search_type_select'];
                $this->logInfo(__METHOD__, $this->criteriaSelections . " Report record count:" . count($skeletalelements));

//                return view('reports.zone.search', $this->viewData);
                return response()->json($this->viewData);    // To fetch the response in the component
            }  catch (QueryException $ex) {
                $this->logQueryException(__METHOD__, $ex);
                Session::flash('alert_message', trans('messages.search_failed', ['model'=>'Zones']));
                return redirect()->back();
            }
        }
    }

    private function zonesQuerySetup( $request )
    {
        $this->criteriaData['sb_id'] = "";
        $this->criteriaData['zones'] = "";
        $this->criteriaData['side'] = "";
        $this->logInfo(__METHOD__);
        if ($request['sb_select'] != "") {
            $this->criteriaData['sb_id'] = $request['sb_select'];
            $query = SkeletalElement::withoutGlobalScope(ProjectScope::class)
                ->where('sb_id', $this->criteriaData['sb_id'])
                ->where('skeletal_elements.project_id', $this->theProject->id)
                ->join('se_zone', 'skeletal_elements.id', '=', 'se_zone.se_id');
            $this->criteriaSelections .= " Bone Id:" . $this->criteriaData['sb_id'];
        }
        if ($request['side_select'] != "") {
            $this->criteriaData['side'] = $request['side_select'];
            $query->where('side', $this->criteriaData['side']);
            $this->criteriaSelections .= " Side:" . $this->criteriaData['side'];
        }
        $query = $this->whereANP1P2($request, $query);
        $this->criteriaSelections .= " Zone Ids:" . json_encode($request['zone_select']);
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
            ->with('skeletalbone','zones')   // Load bone data, zones
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
    //This is the end of the zone search methods

    //This is the first method of method search
    public function methods()
    {
        $this->logInfo(__METHOD__);
        if ($this->authorize('browse', [SkeletalElement::class])) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            $this->setViewDataCommonFields(trans('labels.methods_report'));
            $this->setViewDataMethods();

            return view('reports.method.search', $this->viewData);
        }
    }

    private function setViewDataMethods(Request $request = null)
    {
        $this->viewData['list_method_type'] = ['Age' => 'Age', 'Ancestry' => 'Ancestry', 'Sex' => 'Sex'];
        $this->viewData['list_method'] = [''];
        $this->viewData['list_method_feature'] =[''];
        $this->viewData['list_score'] = [''];
        $this->viewData['list_range'] = [''];
        $this->viewData['skeletal_bone'] = isset($request) ? $request['sb_select'] : null;
        $this->viewData['skeletal_method_type'] = isset($request) ? $request['method_type_select'] : null;
        $this->viewData['skeletal_method'] = isset($request) ? $request['method_select'] : null;
        $this->viewData['skeletal_method_feature'] = isset($request) ? $request['method_feature_select'] : null;
        $this->viewData['skeletal_score'] = isset($request) ? $request['score_select'] : null;
        $this->viewData['skeletal_range'] = isset($request) ? $request['method_range'] : null;
    }

    public function methodsGo( Request $request )
    {
        $this->logInfo(__METHOD__);
        if ($this->authorize('browse', [SkeletalElement::class])) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            try {
                $query = $this->buildCriteriaMethodData($request);
                $skeletalelements = $query->all();

                $this->setViewDataCommonFields(trans('labels.methods_report'), false, $request, $skeletalelements);
                $this->setViewDataMethods($request);
                $this->viewData['list_method'] = $this->findMethod($request['sb_select'], $request['method_type_select']);
                $this->viewData['list_method_feature'] = Method::where('id', $request['method_select'])->first()->features()->pluck('display_name', 'id')->all();
                if ($request['method_feature_select'] != "") {
                    $this->viewData['list_score'] = $this->findScoreArray($request['method_feature_select']);
                    $this->viewData['list_range'] = $this->findRangeArray($request['method_feature_select']);
                }
                $this->logInfo(__METHOD__, $this->criteriaSelections . " Report record count:" . count($skeletalelements));

//                return view('reports.method.search', $this->viewData);
                return response()->json($this->viewData);    // To fetch the response in the component
            }  catch (QueryException $ex) {
                $this->logQueryException(__METHOD__, $ex);
                Session::flash('alert_message', trans('messages.search_failed', ['model'=>'Method']));
                return redirect()->back();
            }
        }
    }

    public function buildCriteriaMethodData( $request )
    {
        $this->logInfo(__METHOD__);
        $this->criteriaData['sb_id'] = "";
        $this->criteriaData['method_type'] = "";
        $this->criteriaData['method_id'] = "";
        $this->criteriaData['method_feature_id'] = "";
        $this->criteriaData['score'] = "";
        $this->criteriaData['range'] = "";
        $query = SkeletalElement::withoutGlobalScope(ProjectScope::class)
            ->with('skeletalbone','methods','methodfeatures')   // Load bone data, methods and method features
            ->join('se_method_feature', 'skeletal_elements.id', '=', 'se_method_feature.se_id')
            ->where('skeletal_elements.project_id', $this->theProject->id);
        if ( $request['method_select'] != "" )
        {
            $this->criteriaData['method_id'] = $request['method_select'];
            $query->where('method_id', $request['method_select']);
            $this->criteriaSelections .= " Method:" . $request['method_select'];
        }
        if ( $request['method_feature_select'] != "" )
        {
            $this->criteriaData['method_feature_id'] = $request['method_feature_select'];
            $query->where('method_feature_id', $request['method_feature_select']);
            $this->criteriaSelections .= " Method Feature:" . $request['method_feature_select'];
        }
        if ( $request['score_select'] != "" )
        {
            $this->criteriaData['score'] = $request['score_select'];
            $this->criteriaSelections .= " Score:" . $request['score_select'];
            if ( $request['range_select'] != "" and $request['range_select'] != "0" )
            {
                $this->criteriaData['range'] = $request['range_select'];
                $this->criteriaSelections .= " Range:" . $request['range_select'];
                $score = $this->criteriaData['score'];
                $range = $this->criteriaData['range'];
                foreach(range($score-$range, $score+$range) as $array_element) {
                    $range_list[] = $array_element;
                }
                $query->whereIn('score', $range_list);
            } else {
                $query->where('score', $this->criteriaData['score'] );
            }
        }
        $query = $this->whereANP1P2($request, $query);
        $query = $this->whereBone($request, $query);
        return collect($query->get());
    }

    public function findMethod( $sb, $method_type )
    {
        $this->logInfo(__METHOD__);
        $bone = SkeletalBone::where('id', $sb)->first();
        if ($method_type != '')
        {
            $methods = $bone->methods()->where('type', $method_type)->get();
        } else {
            $methods = $bone->methods()->get();
        }
        $method_list = array();
        foreach( $methods as $method ){
            $method_list[$method->id] = $method->NameWithSubmethod;
        }
        return $method_list;
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
    //This ends the methods for method search

    /**
     * This is the method for the view screen for the measurement search
     * @return Factory|View
     */
    public function measurements()
    {
        $this->logInfo(__METHOD__);
        if ($this->authorize('browse', [SkeletalElement::class])) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            $this->setViewDataCommonFields(trans('labels.measurements_report'));
            $this->setViewDataMeasurements();

            return view('reports.measurement.search', $this->viewData);
        }
    }

    private function setViewDataMeasurements(Request $request = null)
    {
        $this->viewData['list_individual_number'] = SkeletalElement::where('individual_number', '!=', null)->orderBy('individual_number', 'asc')->pluck('individual_number', 'individual_number')->unique();
        $this->viewData['skeletal_bone'] = isset($request) ? $request['sb_select'] : null;
        $this->viewData['skeletal_side'] = isset($request) ? $request['side_select'] : null;
        $this->viewData['skeletal_side_INumber'] = isset($request) ? $request['side_select_INumber'] : null;
        $this->viewData['skeletal_individual_number'] = isset($request) ? $request['individual_number_select'] : null;
        $this->viewData['individual_number_search'] = false;
        if (isset($request)) {
            $this->viewData['individual_number_search'] = $request['individual_number_select'] != "" ? true : false;
        }
    }

    /**
     * This is the method that will return the results
     * of the measurement search screen
     * @param Request $request
     * @return Factory|View
     */
    public function measurementsGo ( Request $request )
    {
        if ($this->authorize('browse', [SkeletalElement::class])) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            try {
                $query = $this->buildCriteriaMeasurementData($request);
                $skeletalelements = $query->all();
                $this->setViewDataCommonFields(trans('labels.measurements_report'), false, $request, $skeletalelements);
                $this->setViewDataMeasurements($request);
                $sb_ids = array();
                foreach ($skeletalelements as $skeletalelement) {
                    $sb_ids[] = $skeletalelement->sb_id;
                }
                if ($this->viewData['individual_number_search']) {
                    $this->viewData['measurements'] = Measurement::whereIn('sb_id', $sb_ids)->orderBy('sb_id', 'asc')->orderBy('display_order', 'asc')->get();
                } else {
                    $this->viewData['measurements'] = Measurement::where('sb_id', $request['sb_select'])->orderBy('display_order', 'asc')->get();
                }
                $this->logInfo(__METHOD__, $this->criteriaSelections . " Report record count:" . count($skeletalelements));

                return response()->json($this->viewData);    // To fetch the response in the component
//                return view('reports.measurement.search', $this->viewData);
            } catch (QueryException $ex) {
                $this->logQueryException(__METHOD__, $ex);
                Session::flash('alert_message', trans('messages.search_failed', ['model'=>'Measurement']));
                return redirect()->back();
            }
        }
    }

    /**
     * This method takes the parameters from the search screen and finds the results
     * @param $request
     * @return Collection
     */
    private function buildCriteriaMeasurementData( $request )
    {
//        $this->criteriaData['sb_id'] = "";
//        $this->criteriaData['side'] = "";
//        $this->criteriaData['individual_number'] = "";
        $this->logInfo(__METHOD__);

        $query = SkeletalElement::withoutGlobalScope(ProjectScope::class)
            ->with('skeletalbone','measurements')   // Load bone and measurements data
            ->where('skeletal_elements.project_id', $this->theProject->id);

        if ($request['individual_number_select'] != "") {
            $this->criteriaData['individual_number'] = $request['individual_number_select'];
            $query->where('individual_number', $this->criteriaData['individual_number']);
            $this->criteriaSelections .= " IndividualNumber:" . $this->criteriaData['individual_number'];
        }
        if ($request['side_select_INumber'] != "") {
            $this->criteriaData['side'] = $request['side_select_INumber'];
            $query->where('side', $this->criteriaData['side']);
            $this->criteriaSelections .= " IndividualNumber Side:" . $this->criteriaData['side'];
        }
        $query = $this->whereANP1P2($request, $query);
        $query = $this->whereBoneSide($request, $query);
        $query = collect($query->get());
        return $query;
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|Factory|\Illuminate\Http\RedirectResponse|View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function individualNumbers()
    {
        $this->logInfo(__METHOD__);
        if($this->authorize('browse', [ SkeletalElement::class ])) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            try {
                $this->viewData['heading'] = trans('labels.individual_numbers');
                $this->viewData['open_result_new_tab'] = ($this->theUser->getProfileValue('se_search_open_in_new_browser_tab') == true ? true : false);
                return view('reports.individualNumber.search', $this->viewData);
            } catch (QueryException $ex) {
                $this->logQueryException(__METHOD__, $ex);
                Session::flash('alert_message', trans('messages.search_failed', ['model'=>'Individual Number']));
                return redirect()->back();
            }
        }
    }

    /**
     * @return Factory|View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function individualNumberDetails()
    {
        $this->logInfo(__METHOD__);
        if ($this->authorize('browse', [SkeletalElement::class])) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            $this->setViewDataCommonFields(trans('labels.individual_number_report'));
            $this->setViewDataIndividualNumber();

            return view('reports.individualNumber.details', $this->viewData);
        }
    }

    private function setViewDataIndividualNumber(Request $request = null)
    {
        $this->viewData['list_individual_number'] = SkeletalElement::where('individual_number', '!=', null)->orderBy('individual_number', 'asc')->pluck('individual_number', 'individual_number')->unique();
        $this->viewData['skeletal_bone'] = isset($request) ? $request['sb_select'] : null;
        $this->viewData['skeletal_side'] = isset($request) ? $request['side_select'] : null;
        $this->viewData['skeletal_individual_number'] = isset($request) ? $request['individual_number_select'] : null;
    }

    public function individualNumbersGo( Request $request )
    {
        $this->logInfo(__METHOD__);
        if ($this->authorize('browse', [SkeletalElement::class])) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            try {
                if (($request['individual_number_select'] == "") && ($request['sb_select'] == "")) {
                    Session::flash('alert_message', 'Choose either an individual number or skeletal bone');
                    return redirect()->back();
                }

                $query = $this->buildCriteriaIndividualNumberData($request);
                $skeletalelements = $query->all();
                $skeletalelements = collect($skeletalelements)->map(function($skeletalelement) {
                    $skeletalelement->uniquetraumaslist = $skeletalelement->uniquetraumaslist;
                    $skeletalelement->uniquepathologyslist = $skeletalelement->uniquepathologyslist;
                    $skeletalelement->uniqueanomalyslist = $skeletalelement->uniqueanomalyslist;

                    return $skeletalelement;
                });

                $this->setViewDataCommonFields(trans('labels.individual_number_report'), false, $request, $skeletalelements);
                $this->setViewDataIndividualNumber($request);
                $this->logInfo(__METHOD__, $this->criteriaSelections . " Report record count:" . count($skeletalelements));

                return view('reports.individualNumber.search', $this->viewData);
            } catch (QueryException $ex) {
                $this->logQueryException(__METHOD__, $ex);
                Session::flash('alert_message', trans('messages.search_failed', ['model'=>'Individual Number']));
                return redirect()->back();
            }
        }
    }

    public function individualNumbersQuickLink ($individualnumber)
    {
        $this->logInfo(__METHOD__);
        $request = new Request();
        $request->replace(['individual_number_select' => urldecode($individualnumber),
            'sb_select' => null, 'side_select' => null, 'p1_select' => null, 'p2_select' => null,
            'an_select' => null
            ]);
        $this->viewData['skeletal_individual_number'] =$request['individual_number_select'];
        return view('reports.individualNumber.details', $this->viewData);
//        return $this->individualNumbersGo($request);
    }

    public function buildCriteriaIndividualNumberData( $request )
    {
        $this->criteriaData['sb_id'] = "";
        $this->criteriaData['side'] = "";
        $this->criteriaData['individual_number'] = "";
        $this->logInfo(__METHOD__);
        if ($request['individual_number_select'] != "") {
            $this->criteriaData['individual_number'] = $request['individual_number_select'];
            $query = SkeletalElement::withoutGlobalScope(ProjectScope::class)
                ->with('skeletalbone')
                ->where('skeletal_elements.project_id', $this->theProject->id)
                ->where('individual_number', $request['individual_number_select']);

            $this->criteriaSelections .= " Individual Number:" . json_encode($request['individual_number_select']);
            $query = $this->whereSide($request, $query);
        }
        else {
            $this->criteriaData['sb_id'] = $request['sb_select'];
            $query = SkeletalElement::withoutGlobalScope(ProjectScope::class)
                ->with('skeletalbone')
                ->where('skeletal_elements.project_id', $this->theProject->id)
                ->whereNotNull('individual_number')
                ->where('sb_id', $request['sb_select']);
            $this->criteriaSelections .= " Bone:" . $request['sb_select'];
        }
        $query = $this->whereANP1P2($request, $query);
        $query = $this->whereSide($request, $query);
        $query = collect($query->get());
        return $query;
    }

    public function traumas()
    {
        $this->logInfo(__METHOD__);
        if ($this->authorize('browse', [SkeletalElement::class])) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            $this->setViewDataCommonFields(trans('labels.trauma_report'));
            $this->setViewDataTrauma();

            return view('reports.trauma.search', $this->viewData);
        }
    }

    private function setViewDataTrauma(Request $request = null)
    {
        $this->viewData['skeletal_bone'] = isset($request) ? $request['sb_select'] : null;
        $this->viewData['skeletal_side'] = isset($request) ? $request['side_select'] : null;
        $this->viewData['skeletal_trauma'] = isset($request) ? $request['trauma_select'] : null;
        $traumas = Trauma::orderBy('timing')->orderBy('type')->get();
        foreach ($traumas as $trauma) {
            $trauma_list[$trauma->id] = $trauma->name;
        }
        $this->viewData['list_trauma'] = $trauma_list;
    }

    public function traumasGo( Request $request )
    {
        $this->logInfo(__METHOD__);
        if ($this->authorize('browse', [SkeletalElement::class])) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            try {
                $query = $this->buildCriteriaTraumaData($request);
                $skeletalelements = $query->all();
                $this->setViewDataCommonFields(trans('labels.trauma_report'), false, $request, $skeletalelements);
                $this->setViewDataTrauma($request);
                $this->viewData['traumas'] = Trauma::orderBy('timing')->orderBy('type')->whereIn('id', $request['trauma_select'])->get();
                $this->logInfo(__METHOD__, $this->criteriaSelections . " Report record count:" . count($skeletalelements));

                // Swetha: Get Traumas by zones list
                $traumas_by_zones_list = collect([]);

                collect($skeletalelements)->each(function($skeletalelement) use($traumas_by_zones_list) {
                    $zones_list = [];
                    foreach ($this->viewData['traumas'] as $trauma) {
                        $zones_list[$trauma->name] = $skeletalelement->traumasByZonesList($trauma->id);
                    }
                    $traumas_by_zones_list[$skeletalelement->id] = $zones_list;
                });

                $this->viewData['traumas_by_zones_list'] = $traumas_by_zones_list;

                return view('reports.trauma.search', $this->viewData);
            } catch (QueryException $ex) {
                $this->logQueryException(__METHOD__, $ex);
                Session::flash('alert_message', trans('messages.search_failed', ['model'=>'Trauma']));
                return redirect()->back();
            }
        }
    }

    public function buildCriteriaTraumaData( $request )
    {
        $this->criteriaData['sb_id'] = "";
        $this->criteriaData['side'] = "";
        $this->criteriaData['trauma'] = "";
        $this->logInfo(__METHOD__);
        if ($request['trauma_select'] != ""){
            $request['trauma_select'] = explode(',', $request['trauma_select']); // converting string of ids to array (Ex: "1,2,3" => [1,2,3])
            $this->criteriaData['trauma'] = $request['trauma_select'];
            $traumas = $this->criteriaData['trauma'];
            $query = SkeletalElement::withoutGlobalScope(ProjectScope::class)
                ->with(['dnas', 'skeletalbone']) // Swetha: Eager load dnas and skeletalbone
                ->join('se_trauma', 'skeletal_elements.id', '=', 'se_trauma.se_id')
                ->where('skeletal_elements.project_id', $this->theProject->id)
                ->whereIn('trauma_id', $traumas )
                ->select('skeletal_elements.*', 'se_trauma.zone_id', 'se_trauma.trauma_id');
            $this->criteriaSelections .= " Traumas:" . json_encode($request['trauma_select']);
        }
        $query = $this->whereANP1P2($request, $query);
        $query = $this->whereBoneSide($request, $query);
        $query = collect($query->get()->unique());
        return $query;
    }

    public function pathologys()
    {
        $this->logInfo(__METHOD__);
        if ($this->authorize('browse', [SkeletalElement::class])) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            $this->setViewDataCommonFields(trans('labels.pathology_report'));
            $this->setViewDataPathology();

            return view('reports.pathology.search', $this->viewData);
        }
    }

    private function setViewDataPathology(Request $request = null)
    {
        $this->viewData['skeletal_bone'] = isset($request) ? $request['sb_select'] : null;
        $this->viewData['skeletal_side'] = isset($request) ? $request['side_select'] : null;
        $this->viewData['skeletal_pathology'] = isset($request) ? $request['pathology_select'] : null;
        $pathologies = Pathology::all();
        foreach ($pathologies as $pathology) {
            $pathology_list[$pathology->id] = $pathology->name;
        }
        $this->viewData['list_pathology'] = $pathology_list;
    }

    public function pathologysGo( Request $request )
    {
        $this->logInfo(__METHOD__);
        if ($this->authorize('browse', [SkeletalElement::class])) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            try {
                $query = $this->buildCriteriaPathologyData($request);
                $skeletalelements = $query->all();
                $this->setViewDataCommonFields(trans('labels.pathology_report'), false, $request, $skeletalelements);
                $this->setViewDataPathology($request);
                $this->viewData['pathologies'] = Pathology::whereIn('id', $request['pathology_select'])->get();
                $this->logInfo(__METHOD__, $this->criteriaSelections . " Report record count:" . count($skeletalelements));

                // Swetha: Get Patholgys by zones list
                $pathology_by_zones_list = collect([]);

                collect($skeletalelements)->each(function($skeletalelement) use($pathology_by_zones_list) {
                    $zones_list = [];
                    foreach ($this->viewData['pathologies'] as $pathology) {
                        $zones_list[$pathology->name] = $skeletalelement->pathologysByZonesList($pathology->id);
                    }
                    $pathology_by_zones_list[$skeletalelement->id] = $zones_list;
                });

                $this->viewData['pathology_by_zones_list'] = $pathology_by_zones_list;

                return view('reports.pathology.search', $this->viewData);
            } catch (QueryException $ex) {
                $this->logQueryException(__METHOD__, $ex);
                Session::flash('alert_message', trans('messages.search_failed', ['model'=>'Pathology']));
                return redirect()->back();
            }
        }
    }

    public function buildCriteriaPathologyData( $request )
    {
        $this->criteriaData['sb_id'] = "";
        $this->criteriaData['side'] = "";
        $this->criteriaData['pathology'] = "";
        $this->logInfo(__METHOD__);
        if ($request['pathology_select'] != ""){
            $request['pathology_select'] = explode(',', $request['pathology_select']); // converting string of ids to array (Ex: "1,2,3" => [1,2,3])
            $this->criteriaData['pathology'] = $request['pathology_select'];
            $pathologies = $this->criteriaData['pathology'];
            $query = SkeletalElement::withoutGlobalScope(ProjectScope::class)
                ->with('skeletalbone') // Swetha: Eager load 'skeletalbone' relation
                ->join('se_pathology', 'skeletal_elements.id', '=', 'se_pathology.se_id')
                ->where('skeletal_elements.project_id', $this->theProject->id)
                ->whereIn('pathology_id', $pathologies )
                ->select('skeletal_elements.*', 'se_pathology.zone_id', 'se_pathology.pathology_id');
            $this->criteriaSelections .= " Traumas:" . json_encode($request['pathology_select']);
        }
        $query = $this->whereANP1P2($request, $query);
        $query = $this->whereBoneSide($request, $query);
        $query = collect($query->get()->unique());
        return $query;
    }

    public function searchgoBoneGroup($bone_group_id)
    {
        if ($this->authorize('browse', [SkeletalElement::class])) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            try {
                $skeletalelements = SkeletalElement::where('bone_group_id', $bone_group_id)->get();
                $this->setViewDataCommonFields(trans('labels.bone_group_report'), false, null, $skeletalelements);
                $this->viewData['skeletalelements'] = $skeletalelements;
                $this->viewData['bonegroup'] = $bone_group_id;
                $this->logInfo(__METHOD__, $this->criteriaSelections . " Report record count:" . count($skeletalelements));
                return view('reports.boneGroup.search', $this->viewData);
            } catch (QueryException $ex) {
                $this->logQueryException(__METHOD__, $ex);
                Session::flash('alert_message', trans('messages.search_failed', ['model'=>'Bone Group']));
                return redirect()->back();
            }
        }
    }

    public function isotopes()
    {
        $this->logInfo(__METHOD__);
        if ($this->authorize('browse', [SkeletalElement::class])) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            $this->setViewDataCommonFields(trans('labels.isotopes_report'));
            $this->setViewDataIsotopesFields();

            return view('reports.isotopes.search', $this->viewData);
        }
    }

    public function orgIsotopes()
    {
        $this->logInfo(__METHOD__);

        if ($this->authorize('browse', [SkeletalElement::class])) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            $this->setViewDataCommonFields(trans('labels.isotopes_report'));

            return view('reports.orgs.isotope', $this->viewData);
        }
    }

    private function setViewDataIsotopesFields(Request $request = null)
    {
        $this->viewData['list_confidence'] = Isotope::$results_confidence;
    }

    public function IsotopesGo(Request $request)
    {
        $this->logInfo(__METHOD__);
        if ($this->authorize('browse', [SkeletalElement::class])) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            try {
                $this->setViewDataCommonFields(trans('labels.isotopes_report'), false, $request);
                $this->setViewDataIsotopesFields($request);
                $resultsconfidence = $request->input('resultsconfidencelist');

                $finalresults = Isotope::withoutGlobalScope(ProjectScope::class)
                    ->where('skeletal_elements.project_id', $this->theProject->id)
                    ->join('skeletal_elements', 'skeletal_elements.id', '=', 'isotopes.se_id');

                if ($resultsconfidence != null) {
                    $finalresults = $finalresults->where('results_confidence', $resultsconfidence);
                    $this->criteriaSelections .= " Results Confidence:" . json_encode($resultsconfidence);
                }
                $finalresults = $this->whereANP1P2($request, $finalresults, 'skeletal_elements.accession_number', 'skeletal_elements.provenance1', 'skeletal_elements.provenance2');
                $finalresults = $finalresults->pluck('isotopes.id');
                $finalresults = Isotope::with(['skeletalelement'])->whereIn('id', $finalresults)->get();
                $this->viewData['isotopes'] = $finalresults;
                $this->logInfo(__METHOD__, $this->criteriaSelections . " Report record count:" . count($finalresults));

                return response()->json($this->viewData);
            } catch (QueryException $ex) {
                $this->logQueryException(__METHOD__, $ex);
                Session::flash('alert_message', trans('messages.search_failed', ['model'=>'Isotope']));
                return redirect()->back();
            }
        }
    }



    public function secomparisons()
    {
        $this->logInfo(__METHOD__);
        if ($this->authorize('browse', [SkeletalElement::class])) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            $this->setViewDataCommonFields(trans('labels.se_comparisons_report'));
            $this->viewData['skeletal_bone'] = null;
            $this->viewData['skeletal_side'] = null;
            $this->viewData['list_se'] = array();
            $this->viewData['se'] = null;

            return view('reports.secomparisons.search', $this->viewData);
        }
    }

    public function secomparisonsgo( Request $request )
    {
        $this->logInfo(__METHOD__);
        if ($this->authorize('browse', [SkeletalElement::class])) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            try {
                $query = SkeletalElement::whereIn('id', $request['skeletal_elements']);
                $skeletalelements = $query->get();
                $this->viewData['measurements'] = Measurement::where('sb_id', $request['sb_select'])->orderBy('display_order', 'asc')->get();
                //$this->viewData['skeletalelements'] = $skeletalelements;
                $this->setViewDataCommonFields(trans('labels.se_comparisons_report'), false, $request, $skeletalelements);
                $this->viewData['skeletal_bone'] = null;
                $this->viewData['skeletal_side'] = null;
                $this->viewData['list_se'] = array();
                $this->viewData['se'] = null;


                $this->logInfo(__METHOD__, $this->criteriaSelections . " Report record count:" . count($skeletalelements));

                return view('reports.secomparisons.search', $this->viewData);
            } catch (QueryException $ex) {
                $this->logQueryException(__METHOD__, $ex);
                Session::flash('alert_message', trans('messages.search_failed', ['model'=>'Pathology']));
                return redirect()->back();
            }
        }
    }


    // ToDo create permissions to view org reports

    public function orgReportsDashboard() {
        $this->logInfo(__METHOD__);
        if ($this->authorize('browse', [SkeletalElement::class])) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            $this->viewData['heading'] = trans('labels.reports_dashboard');

            return view('reports.org_dashboard', $this->viewData);
        }
    }

    public function orgDnaMito() {
        $this->logInfo(__METHOD__);
        if ($this->authorize('browse', [SkeletalElement::class])) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            $this->viewData['heading'] = trans('labels.mitochondrial_dna_report');

            return view('reports.orgs.dna_mito', $this->viewData);
        }
    }

    public function orgDnaYstr() {
        $this->logInfo(__METHOD__);
        if ($this->authorize('browse', [SkeletalElement::class])) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            $this->viewData['heading'] = trans('labels.ystr_dna_report');

            return view('reports.orgs.dna_ystr', $this->viewData);
        }
    }

    public function orgDnaAustr() {
        $this->logInfo(__METHOD__);
        if ($this->authorize('browse', [SkeletalElement::class])) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            $this->viewData['heading'] = trans('labels.austr_dna_report');

            return view('reports.orgs.dna_austr', $this->viewData);
        }
    }

    public function orgUserRpt()
    {
        $this->logInfo(__METHOD__);
        if ($this->authorize('browse', [SkeletalElement::class])) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            $this->viewData['heading'] = trans('labels.user_report');
            return view('reports.orgs.UserReport', $this->viewData);
        }
    }

    public function orgIndividualNumberDetails() {
        $this->logInfo(__METHOD__);
        if ($this->authorize('browse', [SkeletalElement::class])) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            $this->viewData['heading'] = trans('labels.individual_number_details_report');
            return view('reports.orgs.individual_number_details', $this->viewData);
        }
    }

    public function projectReportsDashboard() {
//        $reports = collect([
//            [
//                'name' => trans('labels.mtdna_report'),
//                'description' => trans('messages.mtdna_report_description'),
//                'route' => route('reports.mtdna'),
//                'tags'=>'DNA, mtDNA'
//            ],
//            [
//                'name' => trans('labels.austr_dna_report'),
//                'description' => trans('messages.austr_report_description'),
//                'route' => route('reports.austrdna'),
//                'tags'=>'DNA, austrdna'
//            ],
//            [
//                'name' => trans('labels.ystr_dna_report'),
//                'description' => trans('messages.ystr_report_description'),
//                'route' => route('reports.ystrdna'),
//                'tags'=>'DNA, ystrdna'
//            ],
//            [
//                'name' => trans('labels.zones_report'),
//                'description' => trans('messages.zones_report_description'),
//                'route' => route('reports.zones'),
//                'tags'=>'Specimens, Zones'
//            ],
//            [
//                'name' => trans('labels.methods_report'),
//                'description' => trans('messages.methods_report_description'),
//                'route' => route('reports.methods'),
//                'tags'=>'Specimens, Methods'
//            ],
//            [
//                'name' => trans('labels.measurements_report'),
//                'description' => trans('messages.measurements_report_description'),
//                'route' => route('reports.measurements'),
//                'tags'=>'Specimens, Measurements'
//            ],
//            [
//                'name' => trans('labels.articulations_report'),
//                'description' => trans('messages.articulations_report_description'),
//                'route' => route('reports.articulation.search'),
//                'tags'=>'Specimens, Articulations'
//            ],
//            [
//                'name' => trans('labels.se_by_inumber'),
//                'description' => trans('messages.se_by_inumber_description'),
//                'route' => route('reports.individualnumber'),
//                'tags'=>'Specimens, Individual Number'
//            ],
//            [
//                'name' => trans('labels.trauma_report'),
//                'description' => trans('messages.trauma_report_description'),
//                'route' => route('reports.traumas'),
//                'tags' => 'Specimens, Traumas'
//            ],
//            [
//                'name' => trans('labels.anomaly_report'),
//                'description' => trans('messages.anomaly_report_description'),
//                'route' => route('reports.anomalys'),
//                'tags' => 'Specimens, Anomalys'
//            ],
//            [
//                'name' => trans('labels.pathology_report'),
//                'description' => trans('messages.pathology_report_description'),
//                'route' => route('reports.pathologys'),
//                'tags' => 'Specimens, Pathologys'
//            ],
//            [
//                'name' => trans('labels.individual_number_report'),
//                'description' => trans('messages.individual_number_report_description'),
//                'route' => route('reports.individualnumberdetails'),
//                'tags' => 'Specimens, Individual Numbers'
//            ],
//            [
//                'name' => trans('labels.advanced_report'),
//                'description' => trans('messages.advanced_report_description'),
//                'route' => route('reports.advanced.search'),
//                'tags' => 'Specimens'
//            ],
//            [
//                'name' => trans('labels.isotopes_report'),
//                'description' => trans('messages.isotopes_report_description'),
//                'route' => route('reports.isotopes'),
//                'tags'=>'Specimens, Isotopes'
//            ],
//            [
//                'name' => trans('labels.se_comparisons_report'),
//                'description' => trans('messages.se_comparisons_report_description'),
//                'route' => route('reports.secomparisons'),
//                'tags' => 'Specimens'
//            ],
//        ]);

        $reports = collect([]);
        $this->viewData['reports'] = $reports;
        $this->viewData['heading'] = trans('labels.reports_dashboard');
        $this->logInfo(__METHOD__, "Reports Available:".count($reports));

        return view('reports.dashboard', $this->viewData);
    }

    /**
     * set the common fields of the viewData array
     *
     * @param string $heading
     * @param bool $initialshow
     * @param Request|null $request
     * @param null $skeletalelements
     */
    private function setViewDataCommonFields($heading = "", $initialshow = true, Request $request = null, $skeletalelements = null)
    {
        $users_current_project = $this->theProject;
        $this->viewData['heading'] = $heading;
        $this->viewData['initialshow'] = $initialshow;
        $this->viewData['skeletalelements'] = $skeletalelements;
        $this->viewData['open_result_new_tab'] = ($this->theUser->getProfileValue('se_search_open_in_new_browser_tab') == true ? true : false);
        $this->viewData['list_an'] = Accession::where('project_id', $users_current_project->id)->orderby('number')->pluck('number', 'number');
        $this->viewData['list_p1'] = Accession::where('project_id', $users_current_project->id)->where('provenance1', '!=', null)->orderby('provenance1')->pluck('provenance1', 'provenance1')->unique();
        $this->viewData['list_p2'] = Accession::where('project_id', $users_current_project->id)->where('provenance2', '!=', null)->orderby('provenance2')->pluck('provenance2', 'provenance2')->unique();

        if ($request != null) {
            $this->viewData['skeletal_an'] = $request['an_select'];
            $this->viewData['skeletal_p1'] = $request['p1_select'];
            $this->viewData['skeletal_p2'] = $request['p2_select'];
        }

        if ($initialshow) {
            $this->criteriaSelections = "";
        }
    }

    /**
     * @param Request $request
     * @param $skeletalelements
     * @return mixed
     */
    private function whereANP1P2(Request $request, $skeletalelements, $an='accession_number', $p1='provenance1', $p2='provenance2')
    {
        if ($request['an_select'] != "") {
            $skeletalelements = $skeletalelements->where($an, $request['an_select']);
            $this->criteriaSelections .= " Accession Number:" . $request['an_select'];
        }
        if ($request['p1_select'] != "") {
            $skeletalelements = $skeletalelements->where($p1, $request['p1_select']);
            $this->criteriaSelections .= " Provenance1:" . $request['p1_select'];
        }
        if ($request['p2_select'] != "") {
            $skeletalelements = $skeletalelements->where($p2, $request['p2_select']);
            $this->criteriaSelections .= " Provenance2:" . $request['p2_select'];
        }
        return $skeletalelements;
    }

    /**
     * @param Request $request
     * @param $query
     * @return mixed
     */
    private function whereBone(Request $request, $query)
    {
        if ($request['sb_select'] != "") {
            $this->criteriaData['sb_id'] = $request['sb_select'];
            $query->where('sb_id', $request['sb_select']);
            $this->criteriaSelections .= " Bone:" . $request['sb_select'];
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
            $this->criteriaData['side'] = $request['side_select'];
            $query->where('side', $request['side_select']);
            $this->criteriaSelections .= " Side:" . $request['side_select'];
        }
        return $query;
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
     * This method first sets the viewData['zone_search_type_help'] and return it as a string.
     * @return string
     */
    private function setViewDataZoneSearchTypeHelp()
    {
//        "<p><strong>" . trans('labels.inclusive') .":</strong> " . trans('messages.zones_inclusive') . "</p>" .
//        "<p><strong>" . trans('labels.exclusive')  .":</strong> " . trans('messages.zones_exclusive') . "</p>" .
//        "<p><strong>" . trans('labels.inclusive_only') .":</strong> " . trans('messages.zones_inclusive_only') . "</p>" .
//        "<p><strong>" . trans('labels.exclusive_only') .":</strong> " . trans('messages.zones_exclusive_only') . "</p>" .
//        "<p><strong>" . trans('labels.exclusive_or')   .":</strong> " . trans('messages.zones_exclusive_or')   . "</p>" .

        return $this->viewData['zone_search_type_help'] =
            trans('messages.zones_help_table_text') . "<p></p>" .
            '<table class= "table-bordered">
                <tr> <th>Records</th><th>Inclusive</th><th>Exclusive</th><th>Inclusive Only</th><th>Exclusive Only</th><th>Exclusive Or</th><th>Not Present</th></tr>
                <tr><th>1</th><th></th><th>X</th><th></th><th>X</th><th>X</th><th></th></tr>
                <tr><th>2</th><th></th><th>X</th><th></th><th>X</th><th>X</th><th></th></tr>
                <tr><th>3</th><th></th><th></th><th></th><th></th><th></th><th>X</th></tr>
                <tr><th>1,2</th><th>X</th><th>X</th><th>X</th><th>X</th><th></th><th></th></tr>
                <tr><th>1,2,3</th><th>X</th><th>X</th><th></th><th></th><th></th><th></th></tr>
                <tr><th>1,3</th><th></th><th>X</th><th></th><th></th><th></th><th></th></tr>
            </table>';
    }

    //////////////////////////////////////////
    // All my json response methods go HERE //
    //////////////////////////////////////////

    /**
     * This is the method for the ajax call for the zones
     * This method will be called after a bone has been chosen
     * @param Request $request
     * @return JsonResponse
     */
    public function jsonZonesArray( Request $request )
    {
        $this->logInfo(__METHOD__);
        $bone = $request['sb_select'];
        $bone = SkeletalBone::where('id', $bone)->first();
        $zone = $bone->zones()->orderBy('display_order')->pluck('id', 'display_name')->all();
        $this->logInfo(__METHOD__, "Json count:".count($zone));
        return response()->json($zone);
    }

    public function jsonMethodsArray( Request $request )
    {
        $this->logInfo(__METHOD__);
        $method = $this->findMethod($request['sb_select'], $request['method_type_select']);
        $this->logInfo(__METHOD__, "Json count:".count($method));
        return response()->json($method);
    }
    public function jsonMethodFeaturesArray( Request $request )
    {
        $this->logInfo(__METHOD__);
        $method = $request['method_select'];
        $method = Method::where('id', $method)->first();
        $method_feature = $method->features()->pluck('display_name', 'id')->all();
        $this->logInfo(__METHOD__, "Json count:".count($method_feature));
        return response()->json($method_feature);
    }
    public function jsonScoresArray( Request $request )
    {
        $this->logInfo(__METHOD__);
        $method_feature = $request['method_feature_select'];
        $score_list = $this->findScoreArray($method_feature);
        $this->logInfo(__METHOD__, "Json count:".count($score_list));
        return response()->json($score_list);
    }
    public function jsonRangesArray( Request $request )
    {
        $this->logInfo(__METHOD__);
        $method_feature = $request['method_feature_select'];
        $range = $this->findRangeArray($method_feature);
        $this->logInfo(__METHOD__, "Json count:".count($range));
        return response()->json($range);
    }

    public function jsonANArray( Request $request ){
        $this->logInfo(__METHOD__);
        $project = $this->theProject;
        if( $request['p1_select'] != null) {
            $an = Accession::where('project_id', $project->id )->where('provenance1', $request['p1_select'])->orderby('number')->pluck('number', 'number')->unique();
            $this->logInfo(__METHOD__, "P1=".$request['p1_select']);
        }elseif( $request['p2_select'] != null){
            $an = Accession::where('project_id', $project->id )->where('provenance2', $request['p2_select'])->orderby('number')->pluck('number', 'number')->unique();
            $this->logInfo(__METHOD__, "P2=".$request['p2_select']);
        }else{
            $an = Accession::where('project_id', $project->id )->orderby('number')->pluck('number', 'number');
            $this->logInfo(__METHOD__, "Returning All AN for Project ".$project->name.", P1 and P2 are NULL");
        }
        $this->logInfo(__METHOD__, "Json count:".count($an));
        return response()->json($an);
    }

    public function jsonP1Array( Request $request){
        $this->logInfo(__METHOD__);
        if( $request['an_select'] != null) {
            $p1 = Accession::where('number', $request['an_select'])->where('provenance1', '!=', null)->orderby('provenance1')->pluck('provenance1', 'provenance1')->unique();
            $this->logInfo(__METHOD__, "AN:".$request['an_select']);
        }else{
            $p1 = Accession::where('project_id', $this->theProject->id )->where('provenance1', '!=', null)->orderby('provenance1')->pluck('provenance1', 'provenance1')->unique();
            $this->logInfo(__METHOD__, "AN is NULL");
        }
        $this->logInfo(__METHOD__, "Json count:".count($p1));
        return response()->json($p1);
    }

    public function jsonP2Array( Request $request){
        $this->logInfo(__METHOD__);
        if( $request['an_select'] != null) {
            $p2 = Accession::where('number', $request['an_select'])->orderby('provenance2')->pluck('provenance2', 'provenance2')->unique();
            $this->logInfo(__METHOD__, "AN:".$request['an_select']);
        }else{
            $p2 = Accession::where('project_id', $this->theProject->id )->where('provenance2', '!=', null)->orderby('provenance2')->pluck('provenance2', 'provenance2')->unique();
            $this->logInfo(__METHOD__, "AN is NULL");
        }
        $this->logInfo(__METHOD__, "Json count:".count($p2));
        return response()->json($p2);
    }

    public function jsonDNAArray( Request $request ){
        $this->logInfo(__METHOD__);
        $dna = Dna::withoutGlobalScope(ProjectScope::class)
            ->where('skeletal_elements.project_id', $this->theProject->id)
            ->join('skeletal_elements', 'skeletal_elements.id', '=', 'dnas.se_id');
        if( $request['an_select'] != null) {
            $dna = $dna->where('skeletal_elements.accession_number', $request['an_select']);
            $this->logInfo(__METHOD__, "AN:".$request['an_select']);
        }
        if( $request['p1_select'] != null){
            $dna = $dna->where('skeletal_elements.provenance1', $request['p1_select']);
            $this->logInfo(__METHOD__, "P1:".$request['p1_select']);
        }
        if( $request['p2_select'] != null) {
            $dna = $dna->where('skeletal_elements.provenance2', $request['p2_select']);
            $this->logInfo(__METHOD__, "P2:".$request['p2_select']);
        }
        $dna_type = $request['dna'];
        switch($dna_type){
            case "mito":
                $dna = $dna->orderby('mito_sequence_number')->where('mito_sequence_number', '!=', null)->pluck('mito_sequence_number', 'mito_sequence_number')->unique();
                $this->logInfo(__METHOD__, "Json count:".count($dna));
                return response()->json($dna);
            case "austr":
                $dna = $dna->orderby('austr_sequence_number')->where('austr_sequence_number', '!=', null)->pluck('austr_sequence_number', 'austr_sequence_number')->unique();
                $this->logInfo(__METHOD__, "Json count:".count($dna));
                return response()->json($dna);
            case "ystr":
                $dna = $dna->orderby('ystr_sequence_number')->where('ystr_sequence_number', '!=', null)->pluck('ystr_sequence_number', 'ystr_sequence_number')->unique();
                $this->logInfo(__METHOD__, "Json count:".count($dna));
                return response()->json($dna);
        }

    }

}
