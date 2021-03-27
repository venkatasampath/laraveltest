<?php

/**
 * Users Controller
 *
 * @category   Users
 * @package    CoRA-Controllers
 * @author     Sachin Pawaskar<spawaskar@unomaha.edu>
 * @copyright  2016-2018
 * @license    The MIT License (MIT)
 * @version    GIT: $Id$
 * @since      File available since Release 1.0.0
 */

namespace App\Http\Controllers;

use App\Events\EulaAccepted;
use App\Events\ProfilesChanged;
use App\Http\Requests\PasswordResetRequest;
use App\Http\Requests\UserRequest;
use App\Instrument;
use App\Profile;
use App\Project;
use App\Role;
use App\User;
use Auth;
use Carbon\Carbon;
use Complex\Exception;
use DB;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Input;
use Log;
use Session;

class UsersController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->viewData['list_role'] = $this->list_role = Role::all()->except(1)->pluck('display_name', 'id');
        $this->setViewDataCountryLanguageTz();
    }

    protected function setViewDataCountryLanguageTz()
    {
        $this->viewData['country_array'] = $this->country_array = Config::get('countries');
        $this->viewData['language_codes'] = $this->language_codes = Config::get('language');
        $this->viewData['timezone_array'] = $this->timezone_array = Config::get('timezones');
    }

    public function index(Request $request)
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
                $this->viewData['list_instrument'] = Instrument::where('org_id', $this->theOrg->id)->get()->pluck('name', 'id');
            }catch(QueryException $ex){
                $this->logQueryException(__METHOD__, $request, $ex);
                Session::flash('alert_message', trans('messages.model_index_view_unsuccessful', ['model' => 'User']));
                return redirect()->back();
            }
            return view('users.index', $this->viewData);
        }
    }

    public function show(User $user, Request $request)
    {
        $object = $user;
        $this->logInfo(__METHOD__, $object->id.":".$object->name);
        if($this->authorize('read', [ User::class, $object ])){
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            try {
                $this->viewData['user'] = $object;
                $this->viewData['heading'] = trans('labels.view_user', ['name' => $object->name]);
                $this->viewData['list_instrument'] = Instrument::where('org_id', $this->theOrg->id)->get()->pluck('name', 'id');
                $this->viewData['list_projects'] = Project::where('org_id', $this->theOrg->id)->get()->pluck('name', 'id');
                $this->viewData['last_user_activity_in_days'] = $user->days_since_last_activity;
            }catch(QueryException $ex){
                $this->logQueryException(__METHOD__, $request, $ex);
                Session::flash('alert_message', trans('messages.model_show_view_unsuccessful', ['model' => 'User']));
                return redirect()->back();
            }
            return view('users.show', $this->viewData);
        }
    }

    public function create(Request $request)
    {
        $this->logInfo(__METHOD__);
        if ($this->authorize('add', [User::class])){
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            try {
                $this->viewData['heading'] = trans('labels.new_user');
            }catch(QueryException $ex){
                $this->logQueryException(__METHOD__, $request, $ex);
                Session::flash('alert_message', trans('messages.model_create_view_unsuccessful', ['model' => 'User']));
                return redirect()->back();
            }
            return view('users.create', $this->viewData);
        }
    }

    public function store(UserRequest $request)
    {
        $this->logInfo(__METHOD__, "Start");

        if ( $this->authorize('add', [User::class])) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            try {
                $input = $request->all();
                $this->populateCreateFieldsWithOrgID($input);
                $input['name'] = $request['first_name'] . ' ' . $request['last_name'];
                $input['display_name'] = $request['first_name'] . ' ' . $request['last_name'];
                $input['password'] = bcrypt($request['password']);
                $input['email'] = strtolower($request['email']);
                $input['active'] = $request['active'] == '' ? false : true;
                $org = $this->theOrg;
                $input['default_language'] = $org->default_language != null ? $org->default_language : 'en';
                $input['default_country'] = $org->default_country != null ? $org->default_country : 'US';
                $input['default_timezone'] = $org->default_timezone != null ? $org->default_timezone : 'America/Chicago';
                $object = User::create($input);
//                if($org->getProfileValue('add_cora_demo_project_for_new_users')) {
//                    $project = Project::where('name', 'CoRA Demo')->get()->first();
//                    $object->projects()->attach($project, ['default' => true, 'created_by' => $this->theUser->name, 'updated_by' => $this->theUser->name]);
//                }
            } catch(QueryException $ex) {
                $this->logQueryException(__METHOD__, $request, $ex);
                Session::flash('alert_message', trans('messages.model_add_unsuccessful', ['model' => 'User']));
                return redirect()->back();
            }
            Session::flash('flash_message', trans('messages.model_add_successful', ['model' => 'User']));
            $this->logInfo(__METHOD__, "End ".$object->id.":".$object->name);
            return redirect()->back();
       }
    }

    public function edit(User $user, Request $request)
    {
        $object = $user;
        $this->logInfo(__METHOD__, $object->id.":".$object->name);
        if ($this->authorize('edit', [User::class, $object])){
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            try {
                $this->viewData['user'] = $object;
                $this->viewData['heading'] = trans('labels.edit_user', ['name' => $object->name]);
                $this->viewData['list_instrument'] = Instrument::where('org_id', $this->theOrg->id)->get()->pluck('name', 'id');
                $this->viewData['list_projects'] = Project::where('org_id', $this->theOrg->id)->get()->pluck('name', 'id');
                $this->viewData['last_user_activity_in_days'] = $user->days_since_last_activity;
            }catch(QueryException $ex){
                $this->logQueryException(__METHOD__, $request, $ex);
                Session::flash('alert_message', trans('messages.model_edit_view_unsuccessful', ['model' => 'User']));
                return redirect()->back();
            }
            return view('users.edit', $this->viewData);
        }
    }

    public function update(User $user, UserRequest $request)
    {
        $object = $user;
        $this->logInfo(__METHOD__, "Start ".$object->id.":".$object->name);
        if ($this->authorize('edit', [User::class, $object])) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            try {
                $this->populateUpdateFields($request);
                $request['active'] = $request['active'] == '' ? false : true;
                $request['name'] = $request['first_name'] . ' ' . $request['last_name'];
                $request['display_name'] = $request['first_name'] . ' ' . $request['last_name'];
                $object->update($request->all());
                $instrumentlist = ( $request->input('instrumentlist') == null ? [] : $request->input('instrumentlist'));
                $object->instruments()->sync($this->populateCreateFieldsForSyncWithIDs($instrumentlist));
                $projectlist = ( $request->input('projectlist') == null ? [] : $request->input('projectlist'));
                $object->projects()->sync($this->populateCreateFieldsForSyncWithIDs($projectlist));
            } catch(QueryException $ex) {
                $this->logQueryException(__METHOD__, $request, $ex);
                Session::flash('alert_message', trans('messages.model_update_unsuccesful', ['model' => 'User']));
                return redirect()->back();
            }
            Session::flash('flash_message', trans('messages.model_update_successful', ['model' => 'User']));
            $this->logInfo(__METHOD__, "End ".$object->id.":".$object->name);
            return redirect('/users/' . $object->id);
        }
    }

    public function destroy(Request $request, User $user)
    {
        $object = $user;
        $this->logInfo(__METHOD__, "Start ".$object->id.":".$object->name);
        if ($this->authorize('destroy', [User::class, $object])) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            try {
                $object->delete();
            }catch(QueryException $ex){
                $this->logQueryException(__METHOD__, $request, $ex);
                Session::flash('alert_message', trans('messages.model_destroy_unsuccessful', ['model' => 'User']));
                return redirect()->back();
            }
            $this->logInfo(__METHOD__, "End");
            return redirect('/users');
        }
    }

    public function passwordViewByAdmin(User $user, Request $request)
    {
        $this->logInfo(__METHOD__);
        $object = $user;
        if ($this->authorize('edit', [User::class, $object])) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            try {
                $this->viewData['user'] = $object;
                $this->viewData['heading'] = trans('labels.reset_password', ['name' => $object->name]);
            }catch(QueryException $ex){
                $this->logQueryException(__METHOD__, $request, $ex);
                Session::flash('alert_message', trans('messages.password_view_unsuccessful'));
                return redirect()->back();
            }
            return view( 'users.password', $this->viewData);
        }

    }

    public function passwordResetByAdmin(User $user, PasswordResetRequest $request)
    {
        $object = $user;
        $this->logInfo(__METHOD__, "Start ".$object->id.":".$object->name);
        if ($this->authorize('edit', [User::class, $object])) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            try {
                $password = bcrypt($request['password']);
                $object->fill(['password' => $password])->save();
            }catch(QueryException $ex) {
                $this->logQueryException(__METHOD__, $request, $ex);
                Session::flash('alert_message', trans('messages.password_reset_unsuccessful'));
                return redirect()->back();
            }
            Session::flash('flash_message', trans('messages.success_password_reset'));
            return $this->show($object, $request);
        }
    }

    public function inactivityResetByAdmin(User $user, Request $request)
    {
        $object = $user;
        $this->logInfo(__METHOD__, "Start ".$object->id.":".$object->name);
        if ($this->authorize('edit', [User::class, $object])) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            try {
                $user->last_login_at = Carbon::now();
                $user->save();
            }catch(QueryException $ex){
                $this->logQueryException(__METHOD__, $request, $ex);
                Session::flash('alert_message', trans('messages.inactivity_reset_unsuccessful'));
                return redirect()->back();
            }
            Session::flash('flash_message', trans('messages.success_inactivity_reset'));
        }
        return redirect('/users/'.$user->id);
    }

    /**
     * Sync up the list of roles for the given user record.
     * Defunct not being used
     *
     * @param  User  $user
     * @param  array  $roles (id)
     */
    private function syncRoles(User $user, array $roles)
    {
        $this->logInfo(__METHOD__, "Start ".$user->name);
        $this->populateCreateFieldsForSyncWithIDs($roles, true);
    }

    public function showProfiles(User $user)
    {
        $object = $user;
        $this->logInfo(__METHOD__, "Start ".$object->id.":".$object->name);
        if ($this->authorize('showProfiles', $object)) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            $this->viewData['user'] = $object;
            $this->viewData['the_user_profiles'] = Profile::all()->where('type', '=', 'user');
            $this->viewData['heading'] = trans('labels.edit_user_profiles', ['name' => $object->name]);

            return view('users.profiles', $this->viewData);
        }
    }

    public function updateProfiles(User $user, Request $request)
    {
        $object = $user;
        $this->logInfo(__METHOD__, "Start ".$object->id.":".$object->name);
        if ($this->authorize('updateProfiles', $object)) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            $user->setFireProfileChanged(false);
            $fireProfilesChanged = false;
            foreach (Input::get('userprofiles', array()) as $userprofile) {
                $name = $userprofile['name'];
                $value = $userprofile['value'] == '' ? $userprofile['default_value'] : $userprofile['value'];
                if ($userprofile['kind'] == 'bool' && $userprofile['value'] == '') {
                    $value = false;
                }

                try {
                    $user->setProfile($name, $value);
                    $fireProfilesChanged = true;
                    $this->logInfo(__METHOD__, 'User profile updated: '.$name.' with value '.$value);
                } catch (Exception $e) {
                    $this->logInfo(__METHOD__, 'Error updating user profile ' . $name);
                    return redirect('users.profiles')->withErrors(trans('messages.error_edit_user_profile', ['name' => $name]));
                }
            }
            $user->setFireProfileChanged(true);
            Session::flash('flash_message', trans('messages.success_edit_user_profiles'));
            $this->logInfo(__METHOD__, "End ".$object->id.":".$object->name);
            if ($fireProfilesChanged) {
                event(new ProfilesChanged($user));
            }
            return back()->withInput();
        }
    }

    public function acceptEula(User $user, Request $request)
    {
        $object = $user;
        $this->logInfo(__METHOD__, "Start ".$object->id.":".$object->name);
        if ($this->authorize('acceptEula', $object)) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            $accept = $request['accept'];
            $this->logInfo(__METHOD__, 'accept=' . $accept);
            if ($accept) {
                $this->logInfo(__METHOD__, "success");
                // Check user language/country and make sure that it matches the language/country for the latest system EULA.
                $eula = $user->org->getActiveEulaForUser($user);
                $user->eulas()->save($eula, ['accepted_at' => Carbon::now(), 'created_by' => $user->name, 'updated_by' => $user->name]);
                $response = json_encode(array('success' => '1', 'msg' => trans('messages.success_eula_accepted') . ' - ' . trans('labels.thank_you')));

                event(new EulaAccepted($eula, $user));
            } else {
                $response = json_encode(array('success' => '0', 'msg' => trans('messages.error_eula_accepted')));
            }

            return $response;
        }
    }

    public function isValidDefaultProject(User $user, Request $request)
    {
        $value = $request['profilevalue'];
        $project = Project::find($value);
        $this->logInfo(__METHOD__, ' User:'.$user->name . ' Role:'.$user->role->name .' Project:'.$project->name);
        if ($user->isAdmin()) {
            $this->logInfo(__METHOD__, ' Success - Admin User');
            return true;
        }
        if (isset($project)) {
            if ($project->public) {
                $this->logInfo(__METHOD__, ' Success - Public Project:'.$project->name);
                return true;
            }
            if ($user->org->id === $project->org->id) {
                $this->logInfo(__METHOD__, ' Success - Org Admin'.$user->org->acronym.'Project:'.$project->name);
                return true;
            }
        }
        $this->logInfo(__METHOD__, ' Failed - Project:'.$project->name);
        return false;
    }

    public function refreshDashboard(User $user, Request $request)
    {
        $object = $user;
        $this->logInfo(__METHOD__, "Start ".$object->id.":".$object->name);
        if ($this->authorize('updateProfile', $object)) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            try {
                $error = false;
                $value = $request['currentProject'];
                $request['profilename'] = "default_project";
                $request['profilevalue'] = $request['currentProject'];
                $profilename= $request['profilename'];
                if (!$this->isValidDefaultProject($user, $request)) {
                    $error = true;
                    Session::flash('flash_message', trans('messages.error_edit_user_profile'));
                    $this->logInfo(__METHOD__, 'Error [' . $profilename . '=' . $value . ']');
                    $response = json_encode(array('error' => '1', 'msg' => trans('messages.error_edit_user_profile')));
                }
                if (!$error) {
                    $user->setProfile($profilename, $value);
                    $user->initialize();
                    Session::flash('flash_message', trans('messages.success_edit_user_profile'));
                    $this->logInfo(__METHOD__, '[' . $profilename . '=' . $value . ']');
                    return redirect('/');
                }
            } catch (Exception $e) {
                Session::flash('flash_message', trans('messages.error_edit_user_profile'));
                $this->logInfo(__METHOD__, 'Error: Updating user profile' . $profilename);
            }

            return back()->withInput();
        }
    }

    public function getProfile(User $user, Request $request)
    {
        $this->logInfo(__METHOD__, 'Start '. $user->name);

        if ($this->authorize('updateProfile', [User::class, $user])) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            try {
                $this->viewData['heading'] = trans('labels.my_profile') . " - ". $this->theUser->display_name;
                $this->viewData['list_projects'] = Project::where('org_id', $this->theOrg->id)->get()->pluck('name', 'id');
                $this->setViewDataCountryLanguageTz();
            } catch(QueryException $ex) {
                $this->logQueryException(__METHOD__, $request, $ex);
                Session::flash('alert_message', trans('messages.model_show_view_unsuccessful', ['model' => 'User Profile']));
                return redirect()->back();
            }
            return view('users.profile.main', $this->viewData);
        }
    }

    public function uploadProfileImage(Request $request, User $user)
    {
        $this->logInfo(__METHOD__, 'Start '. $user->name);
        $this->validate($request, ['image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',]);

        $image = $request->file('image');
        $input['imagename'] = time().'_'.$image->getClientOriginalName();


        if (!Storage::disk('s3')->exists('Users/'.$user->id)) {
            Storage::makeDirectory('Users/'.$user->id);
        }

        $this->logInfo(__METHOD__, "Storing file at: Users/".$user->id);
        $avatarPath = Storage::putFileAs('Users/'.$user->id, $image, $input['imagename']);

        if ($this->theUser->id === $user->id) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            $user->avatar = Storage::url($avatarPath);
            $user->save();
        }

        $this->logInfo(__METHOD__, 'End');
        return redirect()->action('UsersController@getProfile', $user->id);
    }

    public function updateProjects(Request $request, User $user)
    {
        $this->logInfo(__METHOD__, 'Start '. $user->name);
        if ($this->theUser->id === $user->id) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            foreach ($request->all() as $key => $value) {
                $this->theUser->setProfile($key, $value);
            }
        }
        $this->logInfo(__METHOD__, 'End');
        return response(array('success' => true));
    }

    public function updateProfile(Request $request, User $user)
    {
        $this->logInfo(__METHOD__, 'Start'. $user->name);
        if ($this->theUser->id === $user->id) {
            try {
                $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
                $user->display_name = $request['display_name'];
                $user->phone = $request['phone'];
                $user->cell_phone = $request['cell_phone'];
                $user->slack_channel = $request['slack_channel'];
                $user->save();
            } catch(Exception $e) {
                Log::error(__METHOD__ . 'User profile update failed: ' . $e->getMessage());
            }
        }
        $this->logInfo(__METHOD__, 'End');
        return response(array('success' => true));
    }

    public function updateGeneral(Request $request, User $user)
    {
        $this->logInfo(__METHOD__, 'Start '. $user->name);
        if ($this->theUser->id === $user->id) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            $this->theUser->setProfile('ui_right_sidebar_slideout_help', $request['ui_right_sidebar_slideout_help']);
            $this->theUser->setProfile('lines_per_page', $request['lines_per_page']);
            $this->theUser->setProfile('welcome_screen_on_startup', $request['welcome_screen_on_startup']);
        }

        $this->logInfo(__METHOD__, 'End');
        return response(array('success' => true));
    }

    public function updateLocalization(Request $request, User $user)
    {
        $this->logInfo(__METHOD__, 'Start '. $user->name);
        if ($this->theUser->id === $user->id) {
            try {
                $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
                $user->default_country = $request['default_country'];
                $user->default_language = $request['default_language'];
                $user->default_timezone = $request['default_timezone'];
                $user->save();
            } catch(Exception $e) {
                Log::error(__METHOD__ . 'User localization update failed: ' . $e->getMessage());
            }
        }

        $this->logInfo(__METHOD__, 'End');
        return response(array('success' => true));
    }

    public function updateNotifications(Request $request, User $user)
    {
        $this->logInfo(__METHOD__, 'Start '. $user->name);
        if ($this->theUser->id === $user->id) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            $this->theUser->setProfile('notify_export_import_completion', $request['notify_export_import_completion']);
            $this->theUser->setProfile('notify_se_review_completion', $request['notify_se_review_completion']);
            $this->theUser->setProfile('notify_via_email', $request['notify_via_email']);
            $this->theUser->setProfile('notify_via_sms', $request['notify_via_sms']);
            $this->theUser->setProfile('notify_via_slack', $request['notify_via_slack']);
        }

        $this->logInfo(__METHOD__, 'End');
        return response(array('success' => true));
    }

    public function getOrgProfile(User $user, Request $request)
    {
        $this->logInfo(__METHOD__, 'User: '. $user->name. ' Org: '. $this->theOrg);

        if ($this->authorize('editOrgProfile', [User::class, $this->theOrg])) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            try {
                $this->viewData['heading'] = trans('labels.organization_profiles') . " - ". $this->theOrg->acronym;
                $this->viewData['list_projects'] = Project::where('org_id', $this->theOrg->id)->get()->pluck('name', 'id');
                $this->setViewDataCountryLanguageTz();
            } catch(QueryException $ex) {
                $this->logQueryException(__METHOD__, $request, $ex);
                Session::flash('alert_message', trans('messages.model_show_view_unsuccessful', ['model' => 'Org Profile']));
                return redirect()->back();
            }
            return view('orgs.profile.main', $this->viewData);
        }
    }

    public function updateOrgGeneral(Request $request)
    {
        $this->logInfo(__METHOD__, 'Start '.$this->theOrg->id.':'.$this->theOrg->name);
        if ($this->authorize('editOrgProfile', [User::class, $this->theOrg])) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            $this->theOrg->setProfile('welcome_screen_url', $request['welcome_screen_url']);
            $this->theOrg->setProfile('add_cora_demo_project_for_new_users', $request['add_cora_demo_project_for_new_users']);
        }

        $this->logInfo(__METHOD__, 'End');
        return response(array('success' => true));
    }

    public function updateOrgAbout(Request $request)
    {
        $this->logInfo(__METHOD__, 'Start '.$this->theOrg->id.':'.$this->theOrg->name);
        if ($this->authorize('editOrgProfile', [User::class, $this->theOrg])) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            try {
                $org = $this->theOrg;
                $this->logInfo(__METHOD__, "Start " . $org->id . ":" . $org->name);
                $org->name = $request['org_name'];
                $org->description = $request['org_description'];
                $org->address = $request['address'];
                $org->city = $request['city'];
                $org->state = $request['state'];
                $org->zip = $request['zip'];
                $org->geo_lat = $request['lat'];
                $org->geo_long = $request['long'];
                $org->website = $request['website'];
                $org->phone = $request['phone'];
                $org->toll_free = $request['tfphone'];
                $org->fax = $request['fax'];
                $org->contact_name = $request['contact_name'];
                $org->contact_email = $request['contact_email'];
                $org->save();
            } catch (\Exception $e) {
                Log::error(__METHOD__ . 'Org About update failed: ' . $e->getMessage());
            }
        }

        $this->logInfo(__METHOD__, 'End');
        return response(array('success' => true));
    }

    public function updateOrgMeasurements(Request $request)
    {
        $this->logInfo(__METHOD__, 'Start '.$this->theOrg->id.':'.$this->theOrg->name);
        if ($this->authorize('editOrgProfile', [User::class, $this->theOrg])) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            $this->theOrg->setProfile('org_mass_unit_of_measure', $request['org_mass_unit_of_measure']);
            $this->theOrg->setProfile('org_length_unit_of_measure', $request['org_length_unit_of_measure']);
        }

        $this->logInfo(__METHOD__, 'End');
        return response(array('success' => true));
    }

    public function updateOrgLocalization(Request $request)
    {
        $this->logInfo(__METHOD__, 'Start '.$this->theOrg->id.':'.$this->theOrg->name);
        if ($this->authorize('editOrgProfile', [User::class, $this->theOrg])) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            try {
                $org = $this->theOrg;
                $org->default_country = $request['default_country'];
                $org->default_language = $request['default_language'];
                $org->default_timezone = $request['default_timezone'];
                $this->logInfo(__METHOD__, ' Update Org country: ' . $org->default_country . ', language: ' . $org->default_language . ', timezone: ' . $org->default_timezone);
                $org->save();
            } catch (\Exception $e) {
                Log::error(__METHOD__ . ' Org Localization update failed: ' . $e->getMessage());
            }
        }

        $this->logInfo(__METHOD__, 'End');
        return response(array('success' => true));
    }

    public function updateOrgApiKeys(Request $request)
    {
        $this->logInfo(__METHOD__, 'Start '.$this->theOrg->id.':'.$this->theOrg->name);
        if ($this->authorize('editOrgProfile', [User::class, $this->theOrg])) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            $this->theOrg->setProfile('org_api_google_maps', $request['org_api_google_maps']);
            $this->theOrg->setProfile('org_api_slack_channel', $request['org_api_slack_channel']);
            $this->theOrg->setProfile('org_api_slack_webhook', $request['org_api_slack_webhook']);
        }

        $this->logInfo(__METHOD__, 'End');
        return response(array('success' => true));
    }
}
