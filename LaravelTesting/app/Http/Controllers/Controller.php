<?php

/**
 * Controller Class derived from BaseController
 *
 * @category   Controller
 * @package    Controllers
 * @author     Sachin Pawaskar<spawaskar@unomaha.edu>
 * @copyright  2016-2018
 * @license    The MIT License (MIT)
 * @version    GIT: $Id$
 * @since      File available since Release 1.0.0
 */

namespace App\Http\Controllers;

use Auth;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Log;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected $viewData = [];
    protected $theUser = null;
    protected $theOrg = null;
    protected $theProject = null;
    protected $heading = null;
    static protected $log_msg_auth_success = "Auth success";
    static protected $plural = 10;
//    static protected $pagination_length_small = ['x-small'=>25, 'small'=>50, 'medium'=>100, 'large'=>250, 'x-large'=>500];
    static protected $pagination_length_xsmall = 25;
    static protected $pagination_length_small = 50;
    static protected $pagination_length_medium = 100;
    static protected $pagination_length = 100;
    static protected $pagination_length_large = 250;
    static protected $pagination_length_xlarge = 500;
    protected $per_page = 250;

    public function __construct()
    {
        $this->viewData = [ 'heading' => 'No Heading' ];
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            $this->populateViewDataWithOrgAndUser(Auth::user());
            $this->per_page = ($request->has('per_page')) ? $request->query('per_page') : $this::$pagination_length_large;

            return $next($request);
        });
    }

    public function populateViewDataWithOrgAndUser($user = null)
    {
        if (isset($user)) {
            $this->viewData['theOrg'] = $this->theOrg = $user->org;
            $this->viewData['theUser'] = $this->theUser = $user;
            $this->viewData['theProject'] = $this->theProject = $user->getCurrentProject();
        } else {
            if (Auth::check())
            {
                $user = Auth::user();
                $this->viewData['theOrg'] = $this->theOrg = $user->org;
                $this->viewData['theUser'] = $this->theUser = $user;
                $this->viewData['theProject'] = $this->theProject = $user->getCurrentProject();
            }
        }
    }

    public function populateViewData($field, $value)
    {
        $this->viewData[$field] = $value;
    }

    public function populateCreateFields(&$input)
    {
        if (Auth::check() && $input != null)
        {
            $input['created_by'] = Auth::user()->name;
            $input['updated_by'] = Auth::user()->name;
        }
    }

    public function populateCreateFieldsWithUserID(&$input)
    {
        $this->populateCreateFields($input);
        if (Auth::check() && $input != null)
        {
            $input['user_id'] = Auth::user()->id;
        }
    }

    public function populateCreateFieldsWithOrgID(&$input)
    {
        $this->populateCreateFields($input);
        if (Auth::check() && $input != null)
        {
            $user = Auth::user();
            $input['org_id'] = $user->org->id;
        }
    }

    public function populateCreateFieldsWithUserAndOrgID(&$input)
    {
        $this->populateCreateFields($input);
        if (Auth::check() && $input != null)
        {
            $user = Auth::user();
            $input['user_id'] = Auth::user()->id;
            $input['org_id'] = $user->org->id;
        }
    }

    public function populateCreateFieldsWithOrgProjectIDs(&$input, $model)
    {
        $this->populateCreateFields($input);
        if (Auth::check() && $input != null)
        {
            $input['org_id'] = $model->org_id;
            $input['project_id'] = $model->project_id;
        }
    }

    public function populateCreateFieldsWithUserOrgProjectIDs(&$input, $model)
    {
        $this->populateCreateFields($input);
        if (Auth::check() && $input != null)
        {
            $user = Auth::user();
            $input['user_id'] = Auth::user()->id;
            $input['org_id'] = $user->org->id;
            $input['project_id'] = $model->project_id;
        }
    }

    public function populateUpdateFields(&$input)
    {
        if (Auth::check() && $input != null)
        {
            $input['updated_by'] = Auth::user()->name;
        }
    }

    public function populateCreateFieldsForSyncWithIDs($arr_ids, $ts = false)
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

    public function populateCreateFieldsOrgProjectFieldsForSyncWithIDs($arr_ids, $model, $ts = false)
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

    public function populateCreateFieldsOrgProjectUserFieldsForSyncWithIDs($arr_ids, $model, $ts = false)
    {
        $syncData = [];
        foreach($arr_ids as $id)
        {
            if (Auth::check())
            {
                if ($ts) {
                    $syncData[$id] = [ 'created_by' => Auth::user()->name, 'updated_by' => Auth::user()->name,
                        'org_id' => $model->org_id, 'project_id' => $model->project_id, 'user_id' => Auth::user()->id,
                        'created_at' => date_create(), 'updated_at' => date_create()];
                } else {
                    $syncData[$id] = [ 'created_by' => Auth::user()->name, 'updated_by' => Auth::user()->name,
                        'org_id' => $model->org_id, 'project_id' => $model->project_id, 'user_id' => Auth::user()->id,];
                }
            }
        }
        return $syncData;
    }

    public function populateTsFieldsForSyncWithIDs($arr_ids)
    {
        $syncData = [];
        foreach($arr_ids as $id)
        {
            $syncData[$id] = [ 'created_at' => date_create(), 'updated_at' => date_create() ];
        }
        return $syncData;
    }

    public function populateCreateFieldsForSyncWithData($arr_data, $field, $type = 'string')
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

    public function populateCreateFieldsOrgProjectFieldsForSyncWithData($arr_data, $field, $model, $type = 'string')
    {
        $syncData = [];
        foreach($arr_data as $data)
        {
            if (Auth::check())
            {
                if ($type == 'boolean') {
                    $syncData[$data['id']] = [ $field => true, 'org_id' => $model->org_id, 'project_id' => $model->project_id,
                        'created_by' => Auth::user()->name, 'updated_by' => Auth::user()->name ];
                } else { // assume string - default
                    $syncData[$data['id']] = [ $field => $data[$field], 'org_id' => $model->org_id, 'project_id' => $model->project_id,
                        'created_by' => Auth::user()->name, 'updated_by' => Auth::user()->name ];
                }
            }
        }
        return $syncData;
    }

    public function getArrayCreateFields()
    {
        $input = [];
        if (Auth::check() && $input != null)
        {
            $input['created_by'] = Auth::user()->name;
            $input['updated_by'] = Auth::user()->name;
        }
        return $input;
    }

    public function getLoginUser()
    {
        if (Auth::check()) {
            return Auth::user();
        }
        return null;
    }

    public function getLoginUserId()
    {
        if (Auth::check()) {
            return Auth::user()->id;
        }
        return 1; // by default return Administrator user id.
    }

    public function getListofIdsFromModelCollection($objects)
    {
        $list = [];
        $count = 0;
        foreach ($objects as $obj) {
            $list[$count++] = $obj->id;
        }
        return $list;
    }

    public function isAdmin()
    {
        $user = $this->getLoginUser();
        return (isset($user)) ? $user->isAdmin() : false;
    }

    public function isOrgAdmin()
    {
        $user = $this->getLoginUser();
        return (isset($user)) ? $user->isOrgAdmin() : false;
    }

    protected function isAdminOrOrgAdmin()
    {
        $user = $this->getLoginUser();
        return (isset($user)) ? ($user->isAdmin() || $user->isOrgAdmin()) : false;
    }

    protected function getLoginUserCurrentProject()
    {
        if (Auth::check()) {
            return Auth::user()->getCurrentProject();
        }
        return null;
    }

    protected function getLoginUserOrg()
    {
        if(Auth::check()){
            return Auth::user()->org();
        }
        return null;
    }

    protected function logQueryException($method, Request $request, QueryException $queryException)
    {
        $user = session('user');
        if (!isset($user)) {
            $user = $this->getLoginUser();
        }
        Log::error($method . $user->getLogOrgUserProject() . " IP=".$request->getClientIp());
        Log::error($method ." ". $queryException->getMessage());
    }

    protected function logInfo($method, $msg = null)
    {
        $user = session('user');
        if (!isset($user)) {
            $user = $this->getLoginUser();
        }
        Log::info($method ." ". $user->getLogOrgUserProject() ." ".trim($msg));
    }

    /**
     * @param Request $request
     * @return bool
     */
    public function hasInput(Request $request)
    {
        return count($request->all()) > 0;
    }
}
