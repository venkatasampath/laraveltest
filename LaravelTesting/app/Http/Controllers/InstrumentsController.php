<?php

/**
 * Instruments Controller
 *
 * @category   Instruments
 * @package    CoRA-Controllers
 * @author     Ryan Ernst<rpernst@unomaha.edu>
 * @copyright  2016-2018
 * @license    The MIT License (MIT)
 * @version    GIT: $Id$
 * @since      File available since Release 1.0.0
 */

namespace App\Http\Controllers;

use App\Http\Requests\InstrumentRequest;
use App\Instrument;
use App\User;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Log;
use Session;

class InstrumentsController extends Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->model_name = trans('labels.instrument');
    }

    public function index(Request $request)
    {
        $this->logInfo(__METHOD__);
//        $this->logInfo(__METHOD__, (new \ReflectionClass(Instrument::class))->getShortName());
        if($this->authorize('browse', [ Instrument::class ])){
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            try {
                $instruments = Instrument::where('org_id', $this->theOrg->id)->with('users')->get();
                $this->viewData['instruments'] = $instruments;
                $this->viewData['heading'] = trans_choice('labels.instruments', Controller::$plural);
                $this->viewData['model_name'] = $this->model_name;
                $this->viewData['list_user'] = User::where('org_id', $this->theOrg->id)->pluck('name', 'id');
            }catch(QueryException $ex){
                $this->logQueryException(__METHOD__, $request, $ex);
                Session::flash('alert_message', trans('messages.model_index_view_unsuccessful', ['model' => $this->model_name]));
                return redirect()->back();
            }
            return view('instruments.index', $this->viewData);
        }
    }

    public function show(Instrument $instrument, Request $request)
    {
        $object = $instrument;
        $this->logInfo(__METHOD__, $object->id.":".$object->getNameAttribute());
        if ( $this->authorize( 'read', [Instrument::class, $object] )) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            try {
                $this->viewData['instrument'] = $object;
                $this->viewData['heading'] = trans('labels.view_instrument', ['name' => $object->code]);
                $this->viewData['list_user'] = User::where('org_id', $this->theOrg->id)->pluck('name', 'id');
            }catch(QueryException $ex){
                $this->logQueryException(__METHOD__, $request, $ex);
                Session::flash('alert_message', trans('messages.model_show_view_unsuccessful', ['model' => $this->model_name]));
                return redirect()->back();
            }
        }
        return view('instruments.show', $this->viewData);
    }

    public function create(Request $request)
    {
        $this->logInfo(__METHOD__);
        if ( $this->authorize('add', [Instrument::class])) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            try {
                $this->viewData['heading'] = trans('labels.new_instrument');
                $this->viewData['list_user'] = User::where('org_id', $this->theOrg->id)->pluck('name', 'id');
            }catch(QueryException $ex){
                $this->logQueryException(__METHOD__, $request, $ex);
                Session::flash('alert_message', trans('messages.model_create_view_unsuccessful', ['model' => $this->model_name]));
                return redirect()->back();
            }
            return view('instruments.create', $this->viewData);
        }
    }

    public function store(InstrumentRequest $request)
    {
        $this->logInfo(__METHOD__, " - Start");
        $input = $request->all();
        $this->populateCreateFieldsWithOrgID($input);
        if ( $input['reference'] == null )
            $input['reference'] = '';
        if ($this->authorize('add', [Instrument::class])) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            try {
                $input['org_id'] = $this->theOrg->id;
                $object = Instrument::create($input);
                $userlist = ( $request->input('userlist') == null ? [] : explode(",", $request->input('userlist')));
                $this->syncUsers($object, $userlist);
            } catch (QueryException $ex) {
                $this->logQueryException(__METHOD__, $request, $ex);
                Session::flash('alert_message', trans('messages.model_add_unsuccessful', ['model' => $this->model_name]));
                return redirect()->back();
            }
            Session::flash('flash_message', trans('messages.model_add_successful', ['model' => $this->model_name]));
            $this->logInfo(__METHOD__, " - End: ".$object->id.":".$object->getNameAttribute());
            return redirect('/instruments/' . $object->id  );
        }
    }

    public function edit(Instrument $instrument, Request $request)
    {
        $object = $instrument;
        $this->logInfo(__METHOD__, $object->id.":".$object->getNameAttribute());
        if ( $this->authorize('edit', [Instrument::class, $object])) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            try {
                $this->viewData['instrument'] = $object;
                $this->viewData['heading'] = trans('labels.edit_instrument', ['name' => $object->code]);
                $this->viewData['list_user'] = User::where('org_id', $this->theOrg->id)->pluck('name', 'id');
            }catch(QueryException $ex){
                $this->logQueryException(__METHOD__, $request, $ex);
                Session::flash('alert_message', trans('messages.model_edit_view_unsuccessful', ['model' => $this->model_name]));
                return redirect()->back();
            }
            return view('instruments.edit', $this->viewData);
        }
    }

    public function update(Instrument $instrument, InstrumentRequest $request)
    {
        $object = $instrument;
        $this->logInfo(__METHOD__, " - Start: ".$object->id.":".$object->getNameAttribute());
        if ($this->authorize('edit', [Instrument::class, $object])) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            try {
                $input = $request->all();
                $this->populateUpdateFields($input);
                if ( $input['reference'] == null )
                    $input['reference'] = '';
                $object->update($input);
                $userlist = ( $request->input('userlist') == null ? [] : explode(",", $request->input('userlist')));
                $this->syncUsers($object, $userlist);
            } catch (QueryException $ex) {
                $this->logQueryException(__METHOD__, $request, $ex);
                Session::flash('alert_message', trans('messages.model_update_unsuccesful', ['model' => $this->model_name]));
                return redirect()->back();
            }
            Session::flash('flash_message', trans('messages.model_update_successful', ['model' => $this->model_name]));
            $this->logInfo(__METHOD__, " - End: ".$object->id.":".$object->getNameAttribute());
            return redirect('/instruments/' . $object->id );
        }
    }

    public function destroy( Request $request, Instrument $instrument)
    {
        $object = $instrument;
        $this->logInfo(__METHOD__, " - Start: ".$object->id.":".$object->getNameAttribute());
        if ($this->authorize('delete', [Instrument::class, $object])) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            try {
                $object->delete();
            }catch (QueryException $ex){
                $this->logQueryException(__METHOD__, $request, $ex);
                Session::flash('alert_message', trans('messages.model_destroy_unsuccessful', ['model' => $this->model_name]));
                return redirect()->back();
            }
        }
        $this->logInfo(__METHOD__, "End");
        return redirect('/instruments');
    }

    private function syncUsers(Instrument $instrument, array $users)
    {
        $this->logInfo(__METHOD__, "- Start: ".$instrument->id.":".$instrument->getNameAttribute());
        $instrument->users()->sync($this->populateCreateFieldsForSyncWithIDs($users));
    }
}