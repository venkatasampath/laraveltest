<?php

namespace App\Http\Controllers;

use App\Accession;
use App\SkeletalBone;
use App\SkeletalElement;
use Illuminate\Http\Request;
use Log;
use Session;


class VisualizationsController extends Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->list_sb = SkeletalBone::orderBy('name')->pluck('name', 'id');
        $this->list_side = SkeletalElement::$side;
        $this->initialshow = false;
        $this->skeletal_an = null;
        $this->skeletal_p1 = null;
        $this->skeletal_p2 = null;

        $this->viewData = [ 'list_sb' => $this->list_sb, 'list_side' => $this->list_side, 'initialshow' => $this->initialshow,
            'skeletal_an' => $this->skeletal_an, 'skeletal_p1' => $this->skeletal_p1, 'skeletal_p2' => $this->skeletal_p2];
    }

    public function searchPairs() {
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

    public function jsonskeletalelements(Request $request) {

        $skeletalelements = $this->SkeletalElementsArrayByParams($request)->pluck( 'id', 'key_bone_side');
        if($request['sb_select'] == null) {
            $skeletalelements = array();
        }
        return response()->json($skeletalelements);
    }

    public function SkeletalElementsArrayByParams($params)
    {
        $skeletalelements = SkeletalElement::all();
        if($params['an_select'] != null) {
            $skeletalelements = $skeletalelements->where('accession_number', $params['an_select']);
        }
        if($params['p1_select'] != null) {
            $skeletalelements = $skeletalelements->where('provenance1', $params['p1_select']);
        }
        if($params['p2_select'] != null) {
            $skeletalelements = $skeletalelements->where('provenance2', $params['p2_select']);
        }
        if($params['sb_select'] != null) {
            $skeletalelements = $skeletalelements->where('sb_id', $params['sb_select']);
        }
        if($params['side_select'] != null) { 
            $skeletalelements = $skeletalelements->where('side', $params['side_select']);
        }
        return $skeletalelements;
    }

    public function graphPairs(Request $request) {
        $this->logInfo(__METHOD__);
        $this->viewData['list_an'] = Accession::where('project_id', $this->getLoginUserCurrentProject()->id )->orderBy('number')->pluck('number', 'number');
        $this->viewData['list_p1'] = Accession::where('project_id', $this->getLoginUserCurrentProject()->id )->orderBy('provenance1')->where('provenance1', '!=', null)->pluck('provenance1', 'provenance1')->unique();
        $this->viewData['list_p2'] = Accession::where('project_id', $this->getLoginUserCurrentProject()->id )->orderBy('provenance2')->where('provenance2', '!=', null)->pluck('provenance2', 'provenance2')->unique();
        $this->viewData['skeletal_an'] = $request['an_select'];
        $this->viewData['skeletal_p1'] = $request['p1_select'];
        $this->viewData['skeletal_p2'] = $request['p2_select'];
        $this->viewData['skeletal_bone'] = $request['sb_select'];
        $this->viewData['skeletal_side'] = $request['side_select'];
        $this->viewData['list_se'] = $this->SkeletalElementsArrayByParams($request)->pluck( 'key', 'id');
        $this->viewData['se'] = $request['skeletal_elements'];
        $this->viewData['list_depth'] = array(1=>1, 2=>2, 3=>3);
        $this->viewData['skeletal_depth'] = $request['depth_select'];

        $skeletalelements = $request['skeletal_elements'];
        $data = array();
        $depth = $request['depth_select'];
        $newSkeletalElements = $skeletalelements;
        $oldSkeletalElements = array();
        while($depth != 0) {
            foreach ($newSkeletalElements as $skeletalelement) {
                //$this->logInfo('the SE ID' . $skeletalelement);
                $skeletalelementPairs = array();
                $skeletalelement = SkeletalElement::find($skeletalelement);
                $left = ($skeletalelement->side == 'Left' ? true : false);
                $pairs = $skeletalelement->AllPairs;

                foreach ($pairs as $pair) {
                    //$this->logInfo('the pair id' . $pair->id);
                    if( !(in_array($pair->id, $oldSkeletalElements))){
                        //$this->logInfo('pair made it');
                        if ($left) {
                            $pairArray = array($skeletalelement->key, $pair->key, 1);
                            array_push($data, $pairArray);
                        } else {
                            $pairArray = array($pair->key, $skeletalelement->key, 1);
                            array_push($data, $pairArray);
                        }
                        array_push($skeletalelementPairs, $pair->id);
                    }
                }
                array_push($oldSkeletalElements, $skeletalelement->id);
            }
            $newSkeletalElements = $skeletalelementPairs;
            $depth -= 1;
        }
        $this->viewData['data'] = $data;

        return view('visualizations.pairs.search', $this->viewData);

    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function dashboard(Request $request) {
        $this->logInfo(__METHOD__);

        if($this->authorize('browse', [ SkeletalElement::class ])) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            $this->viewData["heading"] = "Visualizations";
            return view('visualizations.dashboard', $this->viewData);
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function getViz(Request $request) {
        $this->logInfo(__METHOD__, "type: ".$request["type"]);
        if($this->authorize('browse', [ SkeletalElement::class ])) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            $this->viewData["heading"] = "Visualization - Taphonomy";
            $this->viewData["type"] = $request["type"];
            return view('visualizations.main', $this->viewData);
        }
    }
}