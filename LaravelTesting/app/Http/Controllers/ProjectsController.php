<?php

/**
 * Projects Controller
 *
 * @category   Projects
 * @package    CoRA-Controllers
 * @author     Sachin Pawaskar<spawaskar@unomaha.edu>
 * @copyright  2016-2018
 * @license    The MIT License (MIT)
 * @version    GIT: $Id$
 * @since      File available since Release 1.0.0
 */

namespace App\Http\Controllers;

use App\Http\Requests\ProjectRequest;
use App\Instrument;
use App\Project;
use App\ProjectStatus;
use App\User;
use Illuminate\Http\Request;
use Log;
use Session;

class ProjectsController extends Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->viewData['list_projectstatus'] = $this->list_projectstatus = ProjectStatus::pluck('display_name', 'id');
    }

    public function index()
    {
        $this->logInfo(__METHOD__);
        if($this->authorize('browse', [ Project::class ])){
            try {
                $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
                $this->viewData['projects'] = Project::where('org_id', $this->theOrg->id)->get();
                $this->viewData['heading'] = trans('labels.projects');
                $this->viewData['list_manager'] = User::where('org_id', $this->theOrg->id)->pluck('name', 'id');
                $this->viewData['list_instrument'] = Instrument::where('org_id', $this->theOrg->id)->get()->pluck('name', 'id');
                $this->viewData['list_user'] = User::where('org_id', $this->theOrg->id)->pluck('name', 'id');
//                $p = Project::where('name', '=', 'Cabanatuan')->first();
//                dd($p->p1_by_an());
//                dd($p->an_by_p1());
//                dd($p->mni_by_mito_bones_and_side());
//                $p->an_by_p1();
                return view('projects.index', $this->viewData);
            } catch (QueryException $ex) {
                $this->logQueryException(__METHOD__, $ex);
                Session::flash('alert_message', trans('messages.model_index_view_unsuccessful', ['model' => $this->model_name]));
                return redirect()->back();
            }
        }
    }

    public function show(Project $project)
    {
        $object = $project;
        $this->logInfo(__METHOD__, $object->id.":".$object->name);
       if (($this->theProject->manager_id == $this->theUser->id) || ($this->authorize( 'read', [Project::class, $object]))) {
           $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
           try {
               $this->viewData['project'] = $object;
               $this->viewData['heading'] = trans('labels.view_project', ['name' => $object->name]);
               $this->viewData['list_instrument'] = Instrument::where('org_id', $this->theOrg->id)->get()->pluck('name', 'id');
               $this->viewData['list_user'] = User::where('org_id', $this->theOrg->id)->pluck('name', 'id');
               $this->viewData['list_manager'] = User::where('org_id', $this->theOrg->id)->pluck('name', 'id');
               $this->viewData['isAdminOrOrgAdmin'] = $this->isAdminOrOrgAdmin();
               return view('projects.show', $this->viewData);
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
        if ( $this->authorize('add', [Project::class])) {
            try {
                $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
                $this->viewData['heading'] = trans('labels.create_model', ['model' => 'Project']);
                $this->viewData['list_user'] = User::where('org_id', $this->theOrg->id)->pluck('name', 'id');
                $this->viewData['list_manager'] = User::where('org_id', $this->theOrg->id)->pluck('name', 'id');
                return view('projects.create', $this->viewData);
            } catch (QueryException $ex) {
                $this->logQueryException(__METHOD__, $ex);
                Session::flash('alert_message', trans('messages.model_create_view_unsuccessful', ['model' => $this->model_name]));
                return redirect()->back();
            }
        }
    }

    public function store(ProjectRequest $request)
    {
        $this->logInfo(__METHOD__, " - Start");
        if ($this->authorize('add', [Project::class])) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            try {
                $input = $request->all();
                $this->populateCreateFieldsWithOrgID($input);
                $input['public'] = $request['public'] == '' ? false : true;
                if (Project::where('name', $input['name'])->first() != null) {
                    Session::flash('alert_message', trans('messages.model_add_unsuccessful', ['model' => 'Project']) . " " . trans('messages.project_name_exists'));
                    return redirect()->back();
                }
                $input['org_id'] = $this->theOrg->id;
                if ($request->allow_user_accession_create == null) {
                    $input['allow_user_accession_create'] = false;
                }
                $object = Project::create($input);
                $this->syncUsers($object, array($request->input('manager_id')));
                $userlist = ( $request->input('userlist') == null ? [] : $request->input('userlist'));
                $this->syncUsers($object, $userlist);
                Session::flash('flash_message', trans('messages.model_add_successful', ['model' => 'Project']));
                return redirect('/projects/' . $object->id);
            } catch (QueryException $ex) {
                $this->logQueryException(__METHOD__, $request, $ex);
                Session::flash('alert_message', trans('messages.model_add_unsuccessful', ['model' => 'Project']));
                return redirect()->back();
            }
        }
        $this->logInfo(__METHOD__, "End");
        return redirect()->back();
    }

    public function edit(Project $project)
    {
        $object = $project;
        $this->logInfo(__METHOD__, $object->id.":".$object->name);
        if ( ($this->theProject->manager_id == $this->theUser->id) || ($this->authorize('edit', [Project::class, $object]))) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            try {
                $this->viewData['project'] = $object;
                $this->viewData['heading'] = trans('labels.edit_project', ['name' => $object->name]);
                $this->viewData['list_user'] = User::where('org_id', $this->theOrg->id)->pluck('name', 'id');
                $this->viewData['list_manager'] = User::where('org_id', $this->theOrg->id)->pluck('name', 'id');
                $this->viewData['list_instrument'] = Instrument::where('org_id', $this->theOrg->id)->get()->pluck('name', 'id');
                $this->viewData['isAdminOrOrgAdmin'] = $this->isAdminOrOrgAdmin();
                return view('projects.edit', $this->viewData);
            } catch (QueryException $ex) {
                $this->logQueryException(__METHOD__, $ex);
                Session::flash('alert_message', trans('messages.model_edit_view_unsuccessful', ['model' => $this->model_name]));
                return redirect()->back();
            }
        }
    }

    public function update(Project $project, ProjectRequest $request)
    {
        $object = $project;
        $this->logInfo(__METHOD__, " - Start: " . $object->id . ":" . $object->name);
        if (($this->theProject->manager_id == $this->theUser->id) || ($this->authorize('edit', [Project::class, $object]))) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            try {
                $input = $request->all();
                if ($request->allow_user_accession_create == null) {
                    $input['allow_user_accession_create'] = false;
                }
                $this->populateUpdateFields($input);
                $input['public'] = $request['public'] == '' ? false : true;
                $object->update($input);
                if ($object->users()->where('id', $request->input('manager_id'))->first() == null) {
                    $object->users()->attach($request->input('manager_id'));
                }
                $userlist = ( $request->input('userlist') == null ? [] : $request->input('userlist'));
                $this->syncUsers($object, $userlist);
                Session::flash('flash_message', trans('messages.model_update_successful', ['model' => 'Project']));
                return redirect('/projects/' . $object->id );
            } catch (QueryException $ex) {
                $this->logQueryException(__METHOD__, $request, $ex);
                Session::flash('alert_message', trans('messages.model_update_unsuccessful', ['model' => 'Project']));
                return redirect()->back();
            }
        }
        $this->logInfo(__METHOD__, " - End: ".$object->id.":".$object->name);
        return redirect()->back();
    }

    public function destroy(Request $request, Project $project)
    {
        $object = $project;
        $this->logInfo(__METHOD__, " - Start: ".$object->id.":".$object->name);
        if ($this->authorize('delete', [Project::class, $object])) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            try {
                $object->delete();
                Session::flash('alert_message', trans('messages.model_delete_successful', ['model'=>'Project']));
                return redirect('/projects');
            } catch (QueryException $ex) {
                $this->logQueryException(__METHOD__, $request, $ex);
                Session::flash('alert_message', trans('messages.model_delete_unsuccessful', ['model' => 'Project']));
                return redirect()->back();
            }
        }
        $this->logInfo(__METHOD__, "End");
        return redirect('/projects');
    }

    private function syncUsers(Project $project, array $users)
    {
        $this->logInfo(__METHOD__, $project->id.":".$project->name);
        $project->users()->sync($this->populateCreateFieldsForSyncWithIDs($users));
    }

}