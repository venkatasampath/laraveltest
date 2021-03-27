<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\IsotopeBatchRequest;
use App\Http\Resources\CoraResource;
use App\Http\Resources\CoraResourceCollection;
use App\IsotopeBatch;
use App\Isotope;
use App\Project;
use App\Scopes\ProjectScope;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\View\Factory;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class IsotopeBatchesController extends Controller
{
    /**
     * @param Request $request
     * @param Project $project
     * @return CoraResourceCollection|\Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index(Request $request)
    {
        $this->logInfo(__METHOD__);
        if ($this->authorize('browse', [IsotopeBatch::class])) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            try {
                $query = IsotopeBatch::withoutGlobalScope(ProjectScope::class)
                    ->with('isotopes')
                    ->orderBy('created_at');
                $results = $request['per_page'] ? $query->paginate($request['per_page']) : $query->paginate($this::$pagination_length_large);
                return (new CoraResourceCollection($results))->additional(["count" => count($results), "criteria" => $request->all(), "request" => $request, "query" => $query]);
            } catch (QueryException $ex) {
                $this->logQueryException(__METHOD__, $ex);
                return redirect()->back();
            }
        }
    }

    /**
     * @param IsotopeBatchRequest $request
     * @return CoraResource|\Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(IsotopeBatchRequest $request)
    {
        $this->logInfo(__METHOD__);
        if ($this->authorize('add', [IsotopeBatch::class])) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            try {
                if (!$this->hasInput($request)) {
                    return response()->json([ "data" => "Request is empty" ], 400);
                }
                if($this->checkUniqueBatchNumber($request) == false) {
                    return response()->json([ 'data' => "Isotope add unsuccessful. Batch number already exists." ], 422);
                }
                $isotopeBatch = IsotopeBatch::create($request->all());

                return new CoraResource($isotopeBatch);
            } catch (QueryException $ex) {
                $this->logQueryException(__METHOD__, $request, $ex);
                return response()->json([ 'data' => trans('messages.model_add_unsuccessful', ['model'=>'IsotopeBatch']) ], 422);
            }
        }
        else {
            return response()->json([ "data" => "Not authorized to create resource" ], 403);
        }
    }

    /**
     * @param $isotopeBatch
     * @return CoraResource|\Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function show($isotopeBatch)
    {
        $this->logInfo(__METHOD__);
        if ($this->authorize('read', [IsotopeBatch::class])) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            try{
                $isotopeBatch = IsotopeBatch::withoutGlobalScope(ProjectScope::class)
                ->where('id', $isotopeBatch)
                ->with(['isotopes'=> function($isotopes){
                    $isotopes->with('se');}])
                ->first();
                return (new CoraResource($isotopeBatch))->additional(['count_samples' => $isotopeBatch->count_samples,
                    'count_weight_samples_cleaned' => $isotopeBatch->count_weight_samples_cleaned,
                    'count_weight_collagen' => $isotopeBatch->count_weight_collagen]);
            } catch (QueryException $ex) {
                $this->logQueryException(__METHOD__, $ex);
                return redirect()->back();
            }
        }
    }

    /**
     * @param $isotopeBatch
     * @param IsotopeBatchRequest $request
     * @return RedirectResponse|\Illuminate\Routing\Redirector
     * @throws AuthorizationException
     */

    public function update($isotopeBatch, IsotopeBatchRequest $request)
    {
        $this->logInfo(__METHOD__);
        if ($this->authorize('edit', [IsotopeBatch::class])) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            try {
                $isotopeBatch = IsotopeBatch::where('id', $isotopeBatch)->first();
                $this->populateUpdateFields($request);
                $this->processBatch($isotopeBatch, $request);
                $isotopeBatch->update($request->all());
                if(($request['demineralizing_treatment_start_date'] || $request['demineralizing_treatment_end_date']) != null) {
                    foreach($isotopeBatch->isotopes as $isotope){
                        $isotope->demineralizing_start_date = $request['demineralizing_treatment_start_date'];
                        $isotope->demineralizing_end_date = $request['demineralizing_treatment_end_date'];
                        $isotope->save();
                    }
                }
                return response()->json([ 'data' => trans('messages.model_update_successful', ['model'=>'IsotopeBatch']), 'isotopebatch' =>$isotopeBatch,
                    'count_samples' => $isotopeBatch->count_samples, 'count_weight_samples_cleaned' => $isotopeBatch->count_weight_samples_cleaned,
                    'count_weight_collagen' => $isotopeBatch->count_weight_collagen], 200
                    );
            } catch (QueryException $ex) {
                $this->logQueryException(__METHOD__, $request, $ex);
                return response()->json([ 'data' => trans('messages.model_add_unsuccessful', ['model'=>'IsotopeBatch']) ], 422);
            }
        }
        $this->logInfo(__METHOD__, "END");
        return redirect()->back();
    }

    protected function processBatch($isotopeBatch, $request) {
        $this->logInfo(__METHOD__, 'Batch Number:'.$isotopeBatch->batch_num);
        if ($request['status'] == 'Cleaning') {
            if($request['rsc'] == true && is_null($request['cleaning_start_date'])) {
                $request['cleaning_start_date'] = date_create();
            }
            if($request['sonicate_samples_dh2o_cycle1'] == true && is_null($request['sonicate_samples_dh2o_cycle1_start_date'])) {
                $request['sonicate_samples_dh2o_cycle1_start_date'] = date_create();
            }
            if($request['sonicate_samples_dh2o_cycle2'] == true && is_null($request['sonicate_samples_dh2o_cycle2_start_date'])) {
                $request['sonicate_samples_dh2o_cycle2_start_date'] = date_create();
            }
            if($request['sonicate_samples_ethanol95'] == true && is_null($request['sonicate_samples_ethanol95_start_date'])) {
                $request['sonicate_samples_ethanol95_start_date'] = date_create();
            }
            if($request['sonicate_samples_ethanol100'] == true && is_null($request['sonicate_samples_ethanol100_start_date'])) {
                $request['sonicate_samples_ethanol100_start_date'] = date_create();
            }
            if($request['dry_samples_start'] == true && is_null($request['dry_samples_start_date'])) {
                $request['dry_samples_start_date'] = date_create();
            }
            if($request['dry_samples_end'] == true && is_null($request['dry_samples_end_date'])) {
                $request['dry_samples_end_date'] = date_create();
            }
            if( $request['rsc'] == true && $request['rinse_samples'] == true &&
                $request['sonicate_samples_dh2o_cycle1'] == true && $request['sonicate_samples_dh2o_cycle2'] == true &&
                $request['sonicate_samples_ethanol95'] == true && $request['sonicate_samples_ethanol100'] == true &&
                $request['dry_samples_start'] == true && $request['dry_samples_end'] == true)
            {
                return $request['status'] = 'Demineralizing';
            }
        } else if ($request['status'] == 'Demineralizing') {
            if($request['demineralizing_treatment_start'] == true && is_null($request['demineralizing_treatment_start_date'])) {
                $request['demineralizing_treatment_start_date'] = date_create();
            }
            if($request['demineralizing_treatment_end'] == true && is_null($request['demineralizing_treatment_end_date'])) {
                $request['demineralizing_treatment_end_date'] = date_create();
            }
            if( $request['demineralizing_treatment_start'] == true && $request['demineralizing_treatment_end'] == true &&
                $request['rinse_demineralized_samples'] == true )
            {
                return $request['status'] = 'Removal Humic Acids';
            }
        } else if ($request['status'] == 'Removal Humic Acids') {
            if($request['rha_treatment_start'] == true && is_null($request['rha_treatment_start_date'])) {
                $request['rha_treatment_start_date'] = date_create();
            }
            if($request['rha_treatment_end'] == true && is_null($request['rha_treatment_end_date'])) {
                $request['rha_treatment_end_date'] = date_create();
            }
            if($request['rha_sample_rinse1_start'] == true && is_null($request['rha_sample_rinse1_start_date'])) {
                $request['rha_sample_rinse1_start_date'] = date_create();
            }
            if($request['rha_sample_rinse2_start'] == true && is_null($request['rha_sample_rinse2_start_date'])) {
                $request['rha_sample_rinse2_start_date'] = date_create();
            }
            if($request['rha_sample_rinse3_start'] == true && is_null($request['rha_sample_rinse3_start_date'])) {
                $request['rha_sample_rinse3_start_date'] = date_create();
            }
            if($request['rha_sample_rinse4_start'] == true && is_null($request['rha_sample_rinse4_start_date'])) {
                $request['rha_sample_rinse4_start_date'] = date_create();
            }
            if($request['rha_sample_rinse5_start'] == true && is_null($request['rha_sample_rinse5_start_date'])) {
                $request['rha_sample_rinse5_start_date'] = date_create();
            }
            if($request['rha_treatment_end'] == true && is_null($request['rha_treatment_end_date'])) {
                $request['rha_treatment_end_date'] = date_create();
            }
            if($request['rha_sample_rinse1_end'] == true && is_null($request['rha_sample_rinse1_end_date'])) {
                $request['rha_sample_rinse1_end_date'] = date_create();
            }
            if($request['rha_sample_rinse2_end'] == true && is_null($request['rha_sample_rinse2_end_date'])) {
                $request['rha_sample_rinse2_end_date'] = date_create();
            }
            if($request['rha_sample_rinse3_end'] == true && is_null($request['rha_sample_rinse3_end_date'])) {
                $request['rha_sample_rinse3_end_date'] = date_create();
            }
            if($request['rha_sample_rinse4_end'] == true && is_null($request['rha_sample_rinse4_end_date'])) {
                $request['rha_sample_rinse4_end_date'] = date_create();
            }
            if($request['rha_sample_rinse5_end'] == true && is_null($request['rha_sample_rinse5_end_date'])) {
                $request['rha_sample_rinse5_end_date'] = date_create();
            }

            if( $request['rha_treatment_start'] == true && $request['rha_treatment_end'] &&
                $request['rha_sample_rinse1_start'] == true && $request['rha_sample_rinse1_end'] &&
                $request['rha_sample_rinse2_start'] == true && $request['rha_sample_rinse2_end'] &&
                $request['rha_sample_rinse3_start'] == true && $request['rha_sample_rinse3_end'] &&
                $request['rha_sample_rinse4_start'] == true && $request['rha_sample_rinse4_end'] &&
                $request['rha_sample_rinse5_start'] == true && $request['rha_sample_rinse5_end'] )
            {
                return $request['status'] = 'Solubilizing';
            }
        } else if ($request['status'] == 'Solubilizing') {
            if($request['sc_clean_vials_and_lids'] == true && is_null($request['sc_clean_vials_and_lids_date'])) {
                $request['sc_clean_vials_and_lids_date'] = date_create();
            }
            if($request['sc_freeze_vials'] == true && is_null($request['sc_freeze_vials_date'])) {
                $request['sc_freeze_vials_date'] = date_create();
            }
            if($request['sc_clean_vials_and_lids'] == true && $request['sc_add_solubale'] == true && $request['sc_place_in_oven'] == true &&
                $request['sc_centrifuge_tubes'] == true && $request['sc_freeze_vials'] == true)
            {
                return $request['status'] = 'Freeze Drying Collagen';
            }
        } else if ($request['status'] == 'Freeze Drying Collagen') {
            if($request['fdc_samples_start'] == true && is_null($request['fdc_samples_start_date'])) {
                $request['fdc_samples_start_date'] = date_create();
            }
            if($request['fdc_samples_end'] == true && is_null($request['fdc_samples_end_date'])) {
                $request['fdc_samples_end_date'] = date_create();
            }
            if($request['fdc_on'] == true && $request['fdc_samples_start'] == true && $request['fdc_samples_end'] == true)
            {
                return $request['status'] = 'Determining Collagen Yield';
            }
        } else if ($request['status'] == 'Determining Collagen Yield') {
            if($request['combined_samples_weight'] == true ) {
                return $request['status'] = 'Completed';
            }
        }
        return $request['status'];
    }

    /**
     * @param $request
     * @return bool
     */
    public function checkUniqueBatchNumber($request) {
        $flag = true;
        $this->logInfo(__METHOD__, 'Batch Number:'.$request['batch_num']);
        try {
            $iso_batch = IsotopeBatch::where('batch_num', $request['batch_num'])->get();
            if (count($iso_batch) > 0) {
                $this->logInfo(__METHOD__, "Duplicate Isotope Batch Number:".$request['batch_num']);
                $flag = false;
            }
        } catch (QueryException $ex) {
            $this->logQueryException(__METHOD__, $request, $ex);
            return $flag;
        }
        return $flag;
    }
    /**
     * @param IsotopeBatch $isotopeBatch
     * @param Request $request
     * @return Factory|RedirectResponse|View
     * @throws AuthorizationException
     */
    public function associateIsotopes($isotopeBatch, Request $request){
        $this->logInfo(__METHOD__);
        if ($this->authorize('edit', [IsotopeBatch::class])) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            try {
                $isotopeBatch = IsotopeBatch::where('id', $isotopeBatch)->first();
                //Check if user deleted any from list. Remove from batch if they did.
                $selected_isotopes = $request['isotopesassociatedlist'];
                if(isset($selected_isotopes) && $isotopeBatch->isotopes != null) {
                    foreach ($isotopeBatch->isotopes as $isotope) {
                        if (!in_array($isotope->id, $selected_isotopes)) {
                            $isotope->batch_id = null;
                            $isotope->save();
                        }
                    }
                }
                $isotopes = $request['isotopelist'];
                if (isset($isotopes)) {
                    foreach($isotopes as $isotope){
                        $iso = Isotope::where('id', $isotope)->first();
                        $iso->batch_id = $isotopeBatch->id;
                        $iso->save();
                    }
                }
                $isotopeBatch->update(['status'=>'Associating Isotopes']);
            } catch (QueryException $ex) {
                $this->logQueryException(__METHOD__, $request, $ex);
                return response()->json([ 'data' => trans('messages.model_add_unsuccessful', ['model'=>'IsotopeBatch']) ], 422);
            }
        }
        $isotopes = Isotope::where('batch_id', $isotopeBatch->id)->get()->pluck('id','key');
        $this->logInfo(__METHOD__, "END");
        return response()->json([ 'data' => trans('messages.model_update_successful', ['model'=>'IsotopeBatch']),
            'results' => $isotopeBatch,'isotopes' => $isotopes ], 200);
    }


    /**
     * @param IsotopeBatch $isotopeBatch
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws AuthorizationException
     */
    public function startProcessing($isotopeBatch, Request $request){
        $this->logInfo(__METHOD__);
        if ($this->authorize('edit', [IsotopeBatch::class])) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            try {
                $isotopeBatch = IsotopeBatch::where('id', $isotopeBatch)->first();
                $isotopeBatch->update(['status'=>'Cleaning']);
            } catch (QueryException $ex) {
                $this->logQueryException(__METHOD__, $request, $ex);
                return response()->json([ 'data' => trans('messages.model_update_unsuccessful', ['model'=>'IsotopeBatch']), ], 422);
            }
        }
        return response()->json([ 'data' => trans('messages.model_update_successful', ['model'=>'IsotopeBatch']),'isotopebatch' =>$isotopeBatch ], 200);
    }

    /**
     * @param Request $request
     * @return CoraResource
     */
    public function getProjectIsotopeList(Request $request) {
        $this->logInfo(__METHOD__);
        $isotopes = Isotope::where('project_id', $request['project_id'])->whereNull('batch_id')->get()->pluck('id', 'key');
        return new CoraResource($isotopes);
    }
    public function getAssociatedIsotopeList(Request $request) {
        $this->logInfo(__METHOD__);
        $isotopes = Isotope::where('batch_id', $request['isotopebatch_id'])->get()->pluck('id','key');
        return new CoraResource($isotopes);
    }
}
