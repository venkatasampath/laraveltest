<?php

/**
 * Dental Controller
 *
 * @category   Dental
 * @package    CoRA-Controllers
 * @author     Sachin Pawaskar<spawaskar@unomaha.edu>
 * @copyright  2016-2018
 * @license    The MIT License (MIT)
 * @version    GIT: $Id$
 * @since      File available since Release 1.0.0
 */

namespace App\Http\Controllers;

use App\Accession;
use App\SkeletalElement;

class DentalController extends Controller
{
    public function create()
    {
        $this->logInfo(__METHOD__);
        if ($this->authorize('add', [SkeletalElement::class])) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            $this->setViewDataCommonFields(trans('labels.new_dental_specimen'));

            return view('dental.create', $this->viewData);
        }
    }

    public function createByChart()
    {
        $this->logInfo(__METHOD__);
        if ($this->authorize('add', [SkeletalElement::class])) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            $this->setViewDataCommonFields(trans('labels.new_dental_specimen'));

            return view('dental.create_by_chart', $this->viewData);
        }
    }

    /**
     * set the common fields of the viewData array
     *
     * @param string $heading
     * @param bool $initialshow
     */
    private function setViewDataCommonFields($heading = "", $initialshow = true)
    {
        $this->viewData['heading'] = $heading;
        $this->viewData['initialshow'] = $initialshow;
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function createByGroup()
    {
        $this->logInfo(__METHOD__);
        if ($this->authorize('add', [SkeletalElement::class])) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            $this->viewData['bone_group_filter'] = "Dentition";
            return view('skeletalelements.create_by_grouping', $this->viewData);
        }
    }

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
            $this->viewData['heading'] = trans('labels.dental_search');
            $this->viewData['initialshow'] = true;
            $this->viewData['open_result_new_tab'] = ( $this->theUser->getProfileValue('se_search_open_in_new_browser_tab') == true ? true : false );

            return view('dental.search', $this->viewData);
        }
    }
}