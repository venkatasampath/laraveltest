<?php

namespace App\Http\Controllers;

use App\Accession;
use App\Dna;
use App\DnaAnalysisType;
use App\Lab;
use App\SkeletalBone;
use App\SkeletalElement;
use App\Tag;
use Illuminate\Http\Request;
use Log;
use Session;

/**
 * Class AnalyticsController
 * @package App\Http\Controllers
 */
class AnalyticsController extends Controller
{
    /**
     * AnalyticsController constructor.
     */
    public function __construct()
    {
        parent::__construct();

        $this->initialize();
    }

    /**
     * Initialize the controller with viewData and set the different lists
     */
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

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getIndividualNumbers() {
        $this->logInfo(__METHOD__);

        $this->viewData['skeletalelements'] = null;
        $this->viewData['initialshow'] = true;
        $this->viewData['list_an'] = Accession::where('project_id', $this->getLoginUserCurrentProject()->id )->orderBy('number')->pluck('number', 'number');
        $this->viewData['list_p1'] = Accession::where('project_id', $this->getLoginUserCurrentProject()->id )->orderBy('provenance1')->where('provenance1', '!=', null)->pluck('provenance1', 'provenance1')->unique();
        $this->viewData['list_p2'] = Accession::where('project_id', $this->getLoginUserCurrentProject()->id )->orderBy('provenance2')->where('provenance2', '!=', null)->pluck('provenance2', 'provenance2')->unique();
        $this->viewData['skeletal_bone'] = null;
        $this->viewData['skeletal_side'] = null;
        $this->viewData['list_se'] = array();
        $this->viewData['se'] = null;
        $this->viewData['list_depth'] = array(1=>1, 2=>2, 3=>3);
        $this->viewData['skeletal_depth'] = 1;

        return view('visualizations.pairs.search', $this->viewData);
    }

    /**
     * @param SkeletalElement $skeletalelement
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function getSpecimenCanvas(SkeletalElement $skeletalelement) {
        $this->logInfo(__METHOD__);

        $object = $skeletalelement;
        $this->logInfo(__METHOD__, $object->id.":".$object->key);
        if ($this->authorize( 'read',  [SkeletalElement::class, $object])) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            return view('analytics.specimen_canvas', $this->viewData);
        }
    }

    /**
     * @param SkeletalElement $skeletalelement
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function getProjectCanvas(SkeletalElement $skeletalelement) {
        $this->logInfo(__METHOD__);

        $object = $skeletalelement;
        $this->logInfo(__METHOD__, $object->id.":".$object->key);
        if ($this->authorize( 'read',  [SkeletalElement::class, $object])) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            return view('analytics.project_canvas', $this->viewData);
        }
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
}