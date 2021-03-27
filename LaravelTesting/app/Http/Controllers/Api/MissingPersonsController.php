<?php

namespace App\Http\Controllers\Api;
use App\Genealogy;
use App\Http\Requests\MissingPersonRequest;
use App\MissingPerson;
use App\Http\Controllers\Controller;
use App\Http\Resources\CoraResource;
use App\Http\Resources\CoraResourceCollection;
use App\Scopes\ProjectScope;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class MissingPersonsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->logInfo(__METHOD__);
//        if ($this->authorize('browse', [MissingPerson::class])) {
        $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
        try {
            $query = MissingPerson::withoutGlobalScope(ProjectScope::class);
            $results = $request['per_page'] ? $query->paginate($request['per_page']) : $query->paginate($this::$pagination_length_large);
            return (new CoraResourceCollection($results))->additional(["count" => count($results), "criteria" => $request->all(), "request" => $request, "query" => $query]);
        } catch (QueryException $ex) {
            $this->logQueryException(__METHOD__, $ex);
            return redirect()->back();
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(MissingPersonRequest  $request)
    {
            try {
                if (!$this->hasInput($request)) {
                    return response()->json([ "data" => "Request is empty" ], 400);
                }
                if($this->checkUniquemissingpersoncasenumber($request) == false) {
                    return response()->json([ 'data' => "Missing Person add unsuccessful. Case number already exists." ], 422);
                }
                $missingperson = MissingPerson::create($request->all());
                return new CoraResource($missingperson);
            } catch (QueryException $ex) {
                $this->logQueryException(__METHOD__, $request, $ex);
                return response()->json([ 'data' => trans('messages.model_add_unsuccessful', ['model'=>'Missing_Persons']) ], 422);
            }
    }

    public function checkUniquemissingpersoncasenumber($request) {
        $flag = true;
        try {
            $case_num = MissingPerson::where('case_number', $request['case_number'])->get();
            if (count($case_num) > 0) {
                $this->logInfo(__METHOD__, "Duplicate Missing Person Case Number:".$request['case_number']);
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
    public function show(MissingPerson $missing_person)
    {
        $this->logInfo(__METHOD__);
        $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
        try{
            $dcipsCases = MissingPerson::withoutGlobalScope(ProjectScope::class)
                ->where('id', $missing_person->id)
                ->first();
            $gnns= Genealogy::withoutGlobalScope(ProjectScope::class)
                ->where('mp_id', $missing_person->id)
                ->first();
            return (new CoraResource($dcipsCases))->additional(['gnns'=>$gnns]);
        } catch (QueryException $ex) {
            $this->logQueryException(__METHOD__, $ex);
            return redirect()->back();
        }
    }

    public function update(MissingPersonRequest $request, MissingPerson $missing_person)
    {
        try {
            if (!$this->hasInput($request)) {
                return response()->json([ "data" => "Request is empty" ], 400);
            }
            $missing_person = MissingPerson::withoutGlobalScope(ProjectScope::class)
                ->where('id',$missing_person->id)
                ->first();
            $this->populateUpdateFields($request);
            $this->processBatch($missing_person, $request);
            $missing_person->update($request->all());
            return (new CoraResource($missing_person));
        } catch (QueryException $ex) {
            $this->logQueryException(__METHOD__, $request, $ex);
            return response()->json([ 'message' => trans('messages.model_update_unsuccessful', ['model'=>'Missing_Person']) ], 404);
        }
    }

    protected function processBatch($missing_person, $request)
    {
        if ($request['genealogy_request'] == true && is_null($request['genealogy_request_date']))
        {
            $request['genealogy_request_date'] = date_create();
        }
        if ($request['genealogy_sent'] == true && is_null($request['genealogy_sent_date']))
        {
            $request['genealogy_sent_date'] = date_create();
        }
        if ($request['genealogy_receive'] == true && is_null($request['genealogy_receive_date']))
        {
            $request['genealogy_receive_date'] = date_create();
        }
        if ($request['genealogy_not_required'] == true && is_null($request['genealogy_not_required_date']))
        {
            $request['genealogy_not_required_date'] = date_create();
        }
        if ($request['frs_request_mtdna_1'] == true && is_null($request['frs_request_mtdna_1_date']))
        {
            $request['frs_request_mtdna_1_date'] = date_create();
        }
        if ($request['lab_receive_mtdna_1'] == true && is_null($request['lab_receive_mtdna_1_date']))
        {
            $request['lab_receive_mtdna_1_date'] = date_create();
        }
        if ($request['frs_request_mtdna_2'] == true && is_null($request['frs_request_mtdna_2_date']))
        {
            $request['frs_request_mtdna_2_date'] = date_create();
        }
        if ($request['lab_receive_request_mtdna_2'] == true && is_null($request['lab_receive_request_mtdna_2_date']))
        {
            $request['lab_receive_request_mtdna_2_date'] = date_create();
        }
        if ($request['frs_request_mtdna_3'] == true && is_null($request['frs_request_mtdna_3_date']))
        {
            $request['frs_request_mtdna_3_date'] = date_create();
        }
        if ($request['lab_receive_request_mtdna_3'] == true && is_null($request['lab_receive_request_mtdna_3_date']))
        {
            $request['lab_receive_request_mtdna_3_date'] = date_create();
        }
        if ($request['frs_request_ystr_1'] == true && is_null($request['frs_request_ystr_1_date']))
        {
            $request['frs_request_ystr_1_date'] = date_create();
        }
        if ($request['frs_request_ystr_2'] == true && is_null($request['frs_request_ystr_2_date']))
        {
            $request['frs_request_ystr_2_date'] = date_create();
        }
        if ($request['lab_receive_request_ystr_2'] == true && is_null($request['lab_receive_request_ystr_2_date']))
        {
            $request['lab_receive_request_ystr_2_date'] = date_create();
        }
        if ($request['frs_request_austr_1'] == true && is_null($request['frs_request_austr_1_date']))
        {
            $request['frs_request_austr_1_date'] = date_create();
        }
        if ($request['lab_receive_request_austr_1'] == true && is_null($request['lab_receive_request_austr_1_date']))
        {
            $request['lab_receive_request_austr_1_date'] = date_create();
        }
        if ($request['frs_request_austr_2'] == true && is_null($request['frs_request_austr_2_date']))
        {
            $request['frs_request_austr_2_date'] = date_create();
        }
        if ($request['lab_receive_request_austr_2'] == true && is_null($request['lab_receive_request_austr_2_date']))
        {
            $request['lab_receive_request_austr_2_date'] = date_create();
        }

    }
}
