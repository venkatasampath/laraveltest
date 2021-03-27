<?php

/**
 * CoraModel Model
 *
 * @category   CoraModel
 * @package    CoRA-Models
 * @author     Sachin Pawaskar<spawaskar@unomaha.edu>
 * @copyright  2016-2019
 * @license    The MIT License (MIT)
 * @version    GIT: $Id$
 * @since      File available since Release 3.0.0
 */

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use OwenIt\Auditing\Contracts\Auditable;

/**
 * This is an abstract base class for Models in Cora
 * Implements the Auditing for the Model and
 * Uses the Soft Deletes Traits
 *
 * Class CoraModel
 * @package App
 */
abstract class CoraModel extends Model implements Auditable
{
    use SoftDeletes;
    use \OwenIt\Auditing\Auditable;

    protected function populateCreateFieldsForSyncWithIDs($arr_ids, $ts = false)
    {
        $syncData = [];
        foreach($arr_ids as $id)
        {
            if (Auth::check())
            {
                if ($ts) {
                    $syncData[$id] = [ 'created_by' => Auth::user()->name, 'updated_by' => Auth::user()->name,
                        'created_at' => date_create(), 'updated_at' => date_create()];
                } else {
                    $syncData[$id] = [ 'created_by' => Auth::user()->name, 'updated_by' => Auth::user()->name ];
                }
            }
        }
        return $syncData;
    }

    protected function populateCreateFieldsOrgProjectFieldsForSyncWithIDs($arr_ids, $model, $ts = false)
    {
        $syncData = [];
        foreach($arr_ids as $id)
        {
            if (Auth::check())
            {
                if ($ts) {
                    $syncData[$id] = [ 'created_by' => Auth::user()->name, 'updated_by' => Auth::user()->name,
                        'org_id' => $model->org_id, 'project_id' => $model->project_id,
                        'created_at' => date_create(), 'updated_at' => date_create()];
                } else {
                    $syncData[$id] = [ 'created_by' => Auth::user()->name, 'updated_by' => Auth::user()->name,
                        'org_id' => $model->org_id, 'project_id' => $model->project_id ];
                }
            }
        }
        return $syncData;
    }

    protected function populateCreateFieldsForSyncWithData($arr_data, $field, $type = 'string')
    {
        $syncData = [];
        foreach($arr_data as $data)
        {
            if (Auth::check())
            {
                if ($type == 'boolean') {
                    $syncData[$data['id']] = [ $field => true, 'created_by' => Auth::user()->name, 'updated_by' => Auth::user()->name ];
                } else { // assume string - default
                    $syncData[$data['id']] = [ $field => $data[$field], 'created_by' => Auth::user()->name, 'updated_by' => Auth::user()->name ];
                }
            }
        }
        return $syncData;
    }

    protected function populateCreateFieldsOrgProjectFieldsForSyncWithData($arr_data, $field, $model, $type = 'string')
    {
        $syncData = [];
        foreach($arr_data as $data)
        {
            if (Auth::check())
            {
                if ($type == 'boolean') {
                    $syncData[$data['id']] = [ $field => true, 'org_id' => $model->org_id, 'project_id' => $model->project_id,
                        'created_by' => Auth::user()->name, 'updated_by' => Auth::user()->name ];
                } else { // assume string/integer - default
                    $syncData[$data['id']] = [ $field => $data[$field], 'org_id' => $model->org_id, 'project_id' => $model->project_id,
                        'created_by' => Auth::user()->name, 'updated_by' => Auth::user()->name ];
                }
            }
        }
        return $syncData;
    }

    protected function removeElementWithValue($array, $key, $value) {
        foreach($array as $subKey => $subArray){
            if($subArray[$key] == $value){
                unset($array[$subKey]);
            }
        }
        return $array;
    }
}