<?php

/**
 * HaplogroupsController
 *
 * @category   Haplogroups
 * @package    CoRA-Controllers
 * @copyright  2016-2018
 * @license    The MIT License (MIT)
 * @version    GIT: $Id$
 * @since      File available since Release 1.0.0
 */

namespace App\Http\Controllers;

use App\Haplogroup;
use App\Http\Requests\HaplogroupRequest;
use Doctrine\DBAL\Query\QueryException;
use Illuminate\Http\Request;
use Session;

class HaplogroupsController extends Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->list_type = Haplogroup::$type;
        $this->list_ancestry = Haplogroup::$ancestry;
        $this->viewData = ['list_type'=> $this->list_type, 'list_ancestry' => $this->list_ancestry];
    }

    public function index()
    {
        $this->logInfo(__METHOD__);
        if ($this->authorize('browse', [Haplogroup::class])) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            try {
                $this->viewData['heading'] = trans('labels.haplogroups');
                $this->viewData['haplogroups'] = Haplogroup::all();
                return view('haplogroups.index', $this->viewData);
            } catch (QueryException $ex) {
                $this->logQueryException(__METHOD__, $ex);
                Session::flash('alert_message', trans('messages.model_index_view_unsuccessful', ['model' => $this->model_name]));
                return redirect()->back();
            }
        }
    }

    public function show(Haplogroup $haplogroup)
    {
        $object = $haplogroup;
        $this->logInfo(__METHOD__, $object->id.":");
        if ($this->authorize('read', [Haplogroup::class, $object])) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            try {
                $this->viewData['haplogroup'] = $object;
                $this->viewData['heading'] = trans('labels.view_model', ['model' => 'Haplogroup']);
                return view('haplogroups.show', $this->viewData);
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
        if ($this->authorize('add', [Haplogroup::class])) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            try {
                $this->viewData['heading'] = trans('labels.create_model', ['model' => 'Haplogroup']);
                return view('haplogroups.create', $this->viewData);
            } catch (QueryException $ex) {
                $this->logQueryException(__METHOD__, $ex);
                Session::flash('alert_message', trans('messages.model_create_view_unsuccessful', ['model' => $this->model_name]));
                return redirect()->back();
            }
        }
    }

    public function edit(Haplogroup $haplogroup)
    {
        $object = $haplogroup;
        $this->logInfo(__METHOD__, $object->id.":");
        if (($this->authorize('edit', [Haplogroup::class, $haplogroup]))) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            try {
                $this->viewData['haplogroup'] = $haplogroup;
                $this->viewData['heading'] = trans('labels.edit_model', ['model' => 'Haplogroup']);
                return view('haplogroups.edit', $this->viewData);
            } catch (QueryException $ex) {
                $this->logQueryException(__METHOD__, $ex);
                Session::flash('alert_message', trans('messages.model_edit_view_unsuccessful', ['model' => $this->model_name]));
                return redirect()->back();
            }
        }
    }

    public function store(HaplogroupRequest $request)
    {
        $this->logInfo(__METHOD__);
        if (($this->authorize('add', [Haplogroup::class]))) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            try {
                $input = $request->all();
                $this->populateCreateFields($input);
                $haplogroup= Haplogroup::firstOrNew(['type'=>$input['type'], 'letter'=>$input['letter'], 'subgroup'=>$input['subgroup']]);
                if ($haplogroup->exists) {
                    Session::flash('alert_message', trans('messages.model_add_unsuccessful', ['model'=>'Haplogroup'])." ".trans('Combination already exists.'));
                    return redirect()->back();
                }
                Haplogroup::create($input);
                Session::flash('flash_message', trans('messages.model_add_successful', ['model'=>'Haplogroup']));
                return redirect('/haplogroups');
            } catch (QueryException $ex) {
                $this->logQueryException(__METHOD__, $request, $ex);
                Session::flash('alert_message', trans('messages.model_add_unsuccessful', ['model'=>'Happlogroup']));
                return redirect()->back();
            }
        }
        $this->logInfo(__METHOD__, "End");
        return redirect()->back();
    }

    public function update(Haplogroup $haplogroup, HaplogroupRequest $request)
    {
        $object = $haplogroup;
        $this->logInfo(__METHOD__, " - Start: ".$object->id.":");
        if (($this->authorize('edit', [Haplogroup::class, $object]))) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            try {

                $this->populateUpdateFields($request);
                $haplogroup= Haplogroup::firstOrNew(['type'=>$request['type'], 'letter'=>$request['letter'], 'subgroup'=>$request['subgroup'], 'ancestry'=>$request['ancestry']]);
                if ($haplogroup->exists) {
                    Session::flash('alert_message', trans('messages.model_update_unsuccessful', ['model'=>'Haplogroup'])." ".trans('Combination already exists.'));
                    return redirect()->back();
                }
                $object->update($request->all());
                Session::flash('flash_message', trans('messages.model_update_successful', ['model'=>'Haplogroup']));
                $this->logInfo(__METHOD__, " - End: ".$object->id.":");
                return redirect('/haplogroups');
            } catch (QueryException $ex) {
                $this->logQueryException(__METHOD__, $request, $ex);
                Session::flash('alert_message', trans('messages.model_update_unsuccessful', ['model'=>'Haplogroup']));
                return redirect()->back();
            }
        }
        $this->logInfo(__METHOD__, ' - End: Haplogroup-id='.$haplogroup->id);
        return redirect()->back();
    }

    public function destroy(Request $request, Haplogroup $haplogroup)
    {
        $object = $haplogroup;
        $this->logInfo(__METHOD__, " - Start Delete: ".$object->id);
        if ($this->authorize('delete', [Haplogroup::class, $object])) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            try {
                $object->delete();
                Session::flash('flash_message', trans('messages.model_delete_successful', ['model'=>'Haplogroup']));
                return redirect('/haplogroups');
            } catch (QueryException $ex) {
                $this->logQueryException(__METHOD__, $request, $ex);
                Session::flash('alert_message', trans('messages.model_delete_unsuccessful', ['model'=>'Haplogroup']));
                return redirect()->back();
            }
        }
        $this->logInfo(__METHOD__, "End");
        return redirect('/haplogroups');
    }
}
