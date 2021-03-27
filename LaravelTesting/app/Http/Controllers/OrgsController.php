<?php

/**
 * Orgs Controller
 *
 * @category   Orgs
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
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Input;
use Log;
use Session;
use App\Org;


class OrgsController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index(Request $request)
    {
        $this->logInfo(__METHOD__);
        $orgs = Org::all();
        if($this->authorize('browse', [ Org::class ])){
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            try {
                $this->viewData['orgs'] = $orgs;
                $this->viewData['heading'] = trans('labels.orgs');
            }catch(QueryException $ex){
                $this->logQueryException(__METHOD__, $request, $ex);
                Session::flash('alert_message', trans('messages.model_index_view_unsuccessful', ['model' => 'Org']));
                return redirect()->back();
            }
            return view('orgs.index', $this->viewData);
        }
    }
}
