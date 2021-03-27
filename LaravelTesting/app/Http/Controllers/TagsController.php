<?php

/**
 * Tags Controller
 *
 * @category   Tags
 * @package    CoRA-Controllers
 * @author     Sachin Pawaskar<spawaskar@unomaha.edu>
 * @copyright  2016-2018
 * @license    The MIT License (MIT)
 * @version    GIT: $Id$
 * @since      File available since Release 1.0.0
 */

namespace App\Http\Controllers;

use App\Instrument;
use App\Project;
use App\Role;
use App\User;
use Auth;
use DB;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Log;
use Session;


class TagsController extends Controller
{
    public function tags(Request $request)
    {
        $this->logInfo(__METHOD__);
        $users = User::where('org_id', $this->theOrg->id)->get()->except([$this->theUser->id]);
        if($this->authorize('browse', [ User::class ])){
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            try {
                $this->viewData['users'] = $users;
                $this->viewData['heading'] = trans('labels.users');
                $this->list_role = Role::all()->pluck('display_name', 'id');
                $this->viewData['list_role'] = $this->list_role;
                $this->viewData['list_projects'] = Project::where('org_id', $this->theOrg->id)->get()->pluck('name', 'id');
            }catch(QueryException $ex){
                $this->logQueryException(__METHOD__, $request, $ex);
                Session::flash('alert_message', trans('messages.model_index_view_unsuccessful', ['model' => 'User']));
                return redirect()->back();
            }
            return view('tags.index', $this->viewData);
        }
    }
}
