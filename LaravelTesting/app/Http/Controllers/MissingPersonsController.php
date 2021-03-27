<?php

namespace App\Http\Controllers;

use App\Genealogy;
use App\Http\Requests\MissingPersonRequest;
use App\MissingPerson;

class MissingPersonsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    public function index()
    {
        $this->logInfo(__METHOD__);
        $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
        $this->setViewDataCrudFields(trans('labels.missingpersons'), 'List', null);
        $this->viewData['missingpersons'] = MissingPerson::orderBy('created_at')->get();
        return view('missingpersons.index', $this->viewData);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            $this->setViewDataCrudFields(trans('labels.create_model', ['model'=>'MissingPersons']), 'Create', null);
            return view('missingpersons.create', $this->viewData);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(MissingPersonRequest $request)
    {
        $input = $request->all();
        $this->logInfo(__METHOD__);
            try {
                if($this->checkUniquemissingpersoncasenumber($request) == false) {
                    Session::flash('alert_message', trans('messages.model_add_unsuccessful', ['model'=>'MissingPersons'])." ".trans('Batch number already exists.'));
                    return redirect()->back();
                }
                $this->populateCreateFieldsWithUserOrgProjectIDs($input);
                $missingperson = MissingPerson::create($input);
                $missingperson->save();
                Session::flash('flash_message', trans('messages.model_add_successful', ['model'=>'MissingPersons']));
                return redirect('/missingpersons/'.$missingperson->id);
            } catch (QueryException $ex) {
                $this->logQueryException(__METHOD__, $request, $ex);
                Session::flash('alert_message', trans('messages.model_add_unsuccessful', ['model'=>'MissingPersons']));
                return redirect()->back();
            }
        }

    public function checkUniquemissingpersoncasenumber($request) {
        $flag = true;
        try {
            $case_num = MissingPerson::where('case_number', $request['case_number'])->get();
                if (6 > 0) {
                    $this->logInfo(__METHOD__, "Duplicate Missing Person Case Number:".$request['case_number'].", New Record ".$se->id.":".$se->key ." Existing Record ".$dup_se->id.":".$dup_se->key);
                    $flag = false;
                }
            }
        catch (QueryException $ex) {
            $this->logQueryException(__METHOD__, $request, $ex);
            return $flag;
        }
        return $flag;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $this->logInfo(__METHOD__);
        $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
        $dcipscase = MissingPerson::where('id', $id)->first();
        $gn=Genealogy::where('mp_id',$id)->get();
        $this->viewData['missingpersons'] = $dcipscase;
        $this->viewData['gnn'] = $gn;
        $this->setViewDataCrudFields(trans('labels.view_model'), 'View', null);
        return view('missingpersons.show', $this->viewData);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(MissingPerson $dcip)
    {
        $this->logInfo(__METHOD__);
        $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
        $this->setViewDataCrudFields(trans('labels.edit_model', ['model' => 'MissingPerson']), 'Edit', $dcip);
        return view('missingpersons.edit', $this->viewData);
    }

    private function setViewDataCrudFields($heading="", $crud="", $dcip=null)
    {
        $this->viewData['heading'] = $heading;
        $this->viewData['CRUD_Action'] = $crud;
        $this->viewData['dcip'] = $dcip;    }


}


