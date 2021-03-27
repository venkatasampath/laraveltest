<?php

/**
 * Accessions Controller
 *
 * @category   Accessions
 * @package    CoRA-Controllers
 * @copyright  2016-2018
 * @license    The MIT License (MIT)
 * @version    GIT: $Id$
 * @since      File available since Release 1.0.0
 */

namespace App\Http\Controllers;

use App\Accession;
use App\Http\Requests\AccessionRequest;
use App\Project;
use App\Scopes\ProjectScope;
use App\SkeletalElement;
use Doctrine\DBAL\Query\QueryException;
use Illuminate\Http\Request;
use Session;

class AccessionsController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $this->logInfo(__METHOD__);
        if ($this->authorize('browse', [Accession::class])) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            try {
                $this->viewData['heading'] = trans('labels.accessions');
                $this->viewData['accessions'] = Accession::
                with('project') //load project details in accessions
                ->where('org_id', $this->theOrg->id)->get();
                return view('accessions.index', $this->viewData);
            } catch (QueryException $ex) {
                $this->logQueryException(__METHOD__, $ex);
                Session::flash('alert_message', trans('messages.model_index_view_unsuccessful', ['model' => $this->model_name]));
                return redirect()->back();
            }
        }
    }

    public function show(Accession $accession)
    {
        $object = $accession;
        $this->logInfo(__METHOD__, $object->id.":".$object->getANP1P2Attribute());
        if (($this->theProject->manager_id == $this->theUser->id) || ($this->authorize('read', [Accession::class, $object]))) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            try {
                $this->viewData['accession'] = $object;
                $this->viewData['heading'] = trans('labels.view_accessions', ['name' => $object->number]);
                $skeletalelements = SkeletalElement::withoutGlobalScope(ProjectScope::class)->where('accession_number', $object->number)->where('provenance1', $object->provenance1)->where('provenance2', $object->provenance2)->get();
                if (count($skeletalelements) != 0) {
                    $this->viewData['currentlyUsed'] = 'true';
                }
                return view('accessions.show', $this->viewData);
            } catch (QueryException $ex) {
                $this->logQueryException(__METHOD__, $ex);
                Session::flash('alert_message', trans('messages.model_show_view_unsuccessful', ['model' => $this->model_name]));
                return redirect()->back();
            }
        }
    }

    public function create()
    {
        $this->logInfo(__METHOD__);
        if ($this->authorize('add', [Accession::class])) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            try {
                $this->viewData['projectList'] = Project::where('org_id', $this->theOrg->id)->pluck('name', 'id');
                $this->viewData['heading'] = trans('labels.create_model', ['model' => 'Accession']);
                $this->viewData['accession'] = 0;
                return view('accessions.create', $this->viewData);
            } catch (QueryException $ex) {
                $this->logQueryException(__METHOD__, $ex);
                Session::flash('alert_message', trans('messages.model_create_view_unsuccessful', ['model' => $this->model_name]));
                return redirect()->back();
            }
        }
    }

    public function edit(Accession $accession)
    {
        $object = $accession;
        $this->logInfo(__METHOD__, $object->id.":".$object->getANP1P2Attribute());
        if (($this->theProject->manager_id == $this->theUser->id) || ($this->authorize('edit', [Accession::class, $accession]))) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            try {
                $this->viewData['accession'] = $accession;
                $this->viewData['heading'] = trans('labels.edit_accession', ['name' => $accession->number]);
                $skeletalelements = SkeletalElement::withoutGlobalScope(ProjectScope::class)->where('accession_number', $object->number)->where('provenance1', $object->provenance1)->where('provenance2', $object->provenance2)->get();
                if (count($skeletalelements) != 0) {
                    $this->viewData['currentlyUsed'] = 'true';
                }
                return view('accessions.edit', $this->viewData);
            } catch (QueryException $ex) {
                $this->logQueryException(__METHOD__, $ex);
                Session::flash('alert_message', trans('messages.model_edit_view_unsuccessful', ['model' => $this->model_name]));
                return redirect()->back();
            }
        }
    }

    public function store(AccessionRequest $request)
    {
        $this->logInfo(__METHOD__);
        if (($this->theProject->manager_id == $this->theUser->id) || ($this->authorize('add', [Accession::class]))) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            try {
                if($request->consolidated_an == null){
                    $request['consolidated_an'] = false;
                }
                $input = $request->all();
                $input['project_id'] = $request['project_id'];
                $this->populateCreateFields($input);
                $input['org_id'] = $this->theOrg->id;
                $accession= Accession::firstOrNew(['number'=>$input['number'], 'provenance1'=>$input['provenance1'], 'provenance2'=>$input['provenance2']]);
                if ($accession->exists) {
                    Session::flash('alert_message', trans('messages.model_add_unsuccessful', ['model'=>'Accession'])." ".trans('messages.model_key_exists', ['model'=>'Accession', 'key'=>$accession->key]));
                    return redirect()->back();
                }
                Accession::create($input);
                Session::flash('flash_message', trans('messages.model_add_successful', ['model'=>'Accession']));
                return redirect('/accessions');
            } catch (QueryException $ex) {
                $this->logQueryException(__METHOD__, $request, $ex);
                Session::flash('alert_message', trans('messages.model_add_unsuccessful', ['model'=>'Accession']));
                return redirect()->back();
            }
        }
        $this->logInfo(__METHOD__, "End");
        return redirect()->back();
    }

    public function update(Accession $accession, AccessionRequest $request)
    {
        $object = $accession;
        $this->logInfo(__METHOD__, " - Start: ".$object->id.":".$object->getANP1P2Attribute());
        if (($this->theProject->manager_id == $this->theUser->id) || ($this->authorize('edit', [Accession::class, $object]))) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            try {
                if($request->consolidated_an == null){
                    $request['consolidated_an'] = false;
                }
                $this->populateUpdateFields($request);
                $accession= Accession::firstOrNew(['number'=>$request['number'], 'provenance1'=>$request['provenance1'], 'provenance2'=>$request['provenance2']]);
                if ($accession->exists) {
                    Session::flash('alert_message', trans('messages.model_update_unsuccessful', ['model'=>'Accession'])." ".trans('Combination already exists.'));
                    return redirect()->back();
                }
                $object->update($request->all());
                Session::flash('flash_message', trans('messages.model_update_successful', ['model'=>'Accession']));
                $this->logInfo(__METHOD__, " - End: ".$object->id.":".$object->getANP1P2Attribute());
                return redirect('/accessions');
            } catch (QueryException $ex) {
                $this->logQueryException(__METHOD__, $request, $ex);
                Session::flash('alert_message', trans('messages.model_update_unsuccessful', ['model'=>'Accession']));
                return redirect()->back();
            }
        }
        $this->logInfo(__METHOD__, ' - End: Accession-id='.$accession->id);
        return redirect()->back();
    }

    public function destroy(Request $request, Accession $accession)
    {
        $object = $accession;
        $this->logInfo(__METHOD__, " - Start Delete: ".$object->id.":".$object->getANP1P2Attribute());
        if ($this->authorize('delete', [Accession::class, $object])) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            try {
                $skeletalelements = SkeletalElement::withoutGlobalScope(ProjectScope::class)->where('accession_number',$object->number)->where('provenance1',$object->provenance1)->where('provenance2', $object->provenance2)->get();
                if(count($skeletalelements) != 0) {
                    Session::flash('alert_message', trans('messages.model_in_use', ['model'=>'Accession']));
                    return redirect('/accessions/'.$object->id);
                }
                $object->delete();
                Session::flash('flash_message', trans('messages.model_delete_successful', ['model'=>'Accession']));
                return redirect('/accessions');
            } catch (QueryException $ex) {
                $this->logQueryException(__METHOD__, $request, $ex);
                Session::flash('alert_message', trans('messages.model_delete_unsuccessful', ['model'=>'Accession']));
                return redirect()->back();
            }
        }
        $this->logInfo(__METHOD__, "End");
        return redirect('/accessions');
    }
}
