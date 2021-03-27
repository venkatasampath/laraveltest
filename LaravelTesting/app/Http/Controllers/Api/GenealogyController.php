<?php

namespace App\Http\Controllers\Api;

use App\Genealogy;
use App\Http\Controllers\Controller;
use App\Http\Requests\GenealogyRequest;
use App\Http\Requests\MissingPersonRequest;
use App\Http\Resources\CoraResource;
use App\MissingPerson;
use App\Scopes\ProjectScope;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class GenealogyController extends Controller
{
    public function update(GenealogyRequest $request, Genealogy $gn)
    {
        try {
            if (!$this->hasInput($request)) {
                return response()->json([ "data" => "Request is empty" ], 400);
            }
            $gn = Genealogy::withoutGlobalScope(ProjectScope::class)
                ->where('id',$gn->id)
                ->first();
            $this->populateUpdateFields($request);
            $gn->update($request->all());
            return (new CoraResource($gn));
        } catch (QueryException $ex) {
            $this->logQueryException(__METHOD__, $request, $ex);
            return response()->json([ 'message' => trans('messages.model_update_unsuccessful', ['model'=>'Genealogy']) ], 404);
        }
    }

    public function store(GenealogyRequest  $request)
    {
        try {
            if (!$this->hasInput($request)) {
                return response()->json([ "data" => "Request is empty" ], 400);
            }
            $gn = Genealogy::create($request->all());
            return new CoraResource($gn);
        } catch (QueryException $ex) {
            $this->logQueryException(__METHOD__, $request, $ex);
            return response()->json([ 'data' => trans('messages.model_add_unsuccessful', ['model'=>'Genealogy']) ], 422);
        }
    }

}
