<?php

/**
 * Cora Api UsersController
 *
 * @category
 * @package    CoRA-Api-Controller
 * @author     Sachin Pawaskar<spawaskar@unomaha.edu>
 * @copyright  2016-2020, Sachin Pawaskar, All rights reserved.
 * @license    Proprietary software, All rights reserved.
 * @version    GIT: $Id$
 * @since      File available since Release 3.0.0
 */

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\PasswordResetRequest;
use App\Http\Requests\UserRequest;
use App\Http\Resources\CoraResourceCollection;
use App\Http\Resources\ListResource;
use App\Instrument;
use App\Mail\ExportCompleted;
use App\Mail\ImportCompleted;
use App\Mail\SpecimenGroupCreated;
use App\Mail\SpecimenReviewed;
use App\Profile;
use App\SkeletalElement;
use Carbon\Carbon;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Str;

use App\Http\Resources\CoraResource;
use Illuminate\Notifications\Notifiable;
use OwenIt\Auditing\Models\Audit;

/**
 * Class UsersController
 * @package App\Http\Controllers\Api
 */
class UsersController extends Controller
{
    /**
     * @var array
     */
    public static $allowed_association_types = ["projects", "instruments", "notifications", "unread-notifications", "audits"];

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return CoraResourceCollection|JsonResponse
     * @throws AuthorizationException
     */
    public function index(Request $request)
    {
        $this->logInfo(__METHOD__);
        if ($this->authorize('browse', [ User::class ])) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            $list = User::where("org_id", $this->theOrg->id)
                ->where("role_id", "!=", 1)
                ->paginate($this::$pagination_length_large);

            return new CoraResourceCollection($list);
        } else {
            return response()->json([ "data" => "Not authorized to view all resources" ], 403);
        }
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return CoraResource|JsonResponse
     * @throws AuthorizationException
     */
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
                $org = $this->theOrg;
                $input['default_language'] = $org->default_language != null ? $org->default_language : 'en';
                $input['default_country'] = $org->default_country != null ? $org->default_country : 'US';
                $input['default_timezone'] = $org->default_timezone != null ? $org->default_timezone : 'America/Chicago';
                $object = User::create($input);
                return new CoraResource($object);
            } catch(QueryException $ex) {
                $this->logQueryException(__METHOD__, $request, $ex);
                return response()->json([ 'data' => trans('messages.model_add_unsuccessful', ['model'=>'Users']) ], 422);
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param Request $request
     * @param User|null $user
     * @return CoraResource|JsonResponse
     * @throws AuthorizationException
     */
    public function show(Request $request, User $user = null)
    {
        $this->logInfo(__METHOD__);
        // If $user is null, it means that user has not passed the optional route segment
        // We need to check the request query parameters to see if additional user
        // search criteria have been passed.
        if (!isset($user)) {
            if ($request->query('id')) {
                $user = User::where('id', $request->query('id'))->first();
            }
            if ($request->query('email')) {
                $user = User::where('email', $request->query('email'))->first();
            }

            if (!isset($user)) {
                return response()->json([ "data" => "User not found" ], 404);
            }
        }

        // Check if user is authorized to perform the action
        if ($this->authorize('read', [ User::class, $user ])) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            return new CoraResource($user);
        } else {
            return response()->json([ "data" => "Not authorized to view resource" ], 403);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param UserRequest $request
     * @return CoraResource|JsonResponse
     * @throws AuthorizationException
     */
    public function create(UserRequest $request)
    {
        $this->logInfo(__METHOD__);
        if ($this->authorize('add', User::class)) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            try {
                if (!$this->hasInput($request)) {
                    return response()->json([ "data" => "Request is empty" ], 400);
                }
                $request['created_by'] = $this->theUser->name;
                $request['updated_by'] = $this->theUser->name;
                $object = User::create($request->all());
                return new CoraResource($object);
            } catch (QueryException $ex) {
                $this->logQueryException(__METHOD__, $request, $ex);
                return response()->json([ 'data' => trans('messages.model_add_unsuccessful', ['model'=>'Users']) ], 422);
            }
        } else {
            return response()->json([ "data" => "Not authorized to create resource" ], 403);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UserRequest $request
     * @param User $user
     * @return CoraResource|JsonResponse
     * @throws AuthorizationException
     */
    public function update(UserRequest $request, User $user)
    {
        $this->logInfo(__METHOD__);
        if ($this->authorize('edit', [User::class, $user])) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            try {
                if (!$this->hasInput($request)) {
                    return response()->json([ "data" => "Request is empty" ], 400);
                }
                $request['updated_by'] = $this->theUser->name;
                $user->update($request->all());
                return new CoraResource($user);
            } catch (QueryException $ex) {
                $this->logQueryException(__METHOD__, $request, $ex);
                return response()->json([ 'data' => trans('messages.model_update_unsuccessful', ['model'=>'Users']) ], 422);
            }
        } else {
            return response()->json([ "data" => "Not authorized to edit resource" ], 403);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Request $request
     * @param User $user
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function delete(Request $request, User $user)
    {
        $this->logInfo(__METHOD__);
        if ($this->authorize('delete', [User::class, $user])) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            try {
                $user->delete();
                return response()->json([ 'data' => "Resource deleted successfully" ], 200);
            } catch (QueryException $ex) {
                $this->logQueryException(__METHOD__, $request, $ex);
                return response()->json([ 'data' => trans('messages.model_delete_unsuccessful', ['model'=>'Users']) ], 422);
            }
        } else {
            return response()->json([ "data" => "Not authorized to delete User" ], 403);
        }
    }

    /**
     * Display a listing of the user profile resource.
     *
     * @param Request $request
     * @param User $user
     * @return CoraResourceCollection|JsonResponse|\Illuminate\Http\Resources\Json\AnonymousResourceCollection
     * @throws AuthorizationException
     */
    public function getProfiles(Request $request, User $user)
    {
        $this->logInfo(__METHOD__);
        if ($this->authorize('read', [ User::class, $user ])) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            try {
                if ($request->has('list')) {
                    $list = $user->profiles()->get();
                    return ListResource::collection($list)->additional(["status" => "success"]);
                } else {
                    $list = $user->profiles()->paginate($this::$pagination_length_large);
                    return new CoraResourceCollection($list);
                }
            } catch (QueryException $ex) {
                $this->logQueryException(__METHOD__, $request, $ex);
                return response()->json([ 'data' => trans('messages.model_index_view_unsuccessful', ['model'=>'User Profiles']) ], 422);
            }
        } else {
            return response()->json([ "data" => "Not authorized to view resource" ], 403);
        }
    }

    /**
     * Retrieve a specific user profile by name
     *
     * @param Request $request
     * @param User $user
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function getProfile(Request $request, User $user)
    {
        $this->logInfo(__METHOD__);
        $profile_name = $request->query('name', null);
        if (!isset($profile_name)) {
            return response()->json([ "data" => "Missing request query parameter: name" ], 404);
        }

        if ($this->authorize('read', [ User::class, $user ])) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            try {
                $profile = $user->getProfile($profile_name);
                if (isset($profile)) {
                    $responseObject['name'] = $profile_name;
                    $responseObject['value'] = $user->getProfileValue($profile_name);
                    return response()->json([ 'data' => $responseObject ], 200);
                } else {
                    $responseObject['error'] = "profile not found ".$profile_name;
                    return response()->json([ 'data' => $responseObject ], 404);
                }
            } catch (QueryException $ex) {
                $this->logQueryException(__METHOD__, $request, $ex);
                return response()->json([ 'data' => trans('messages.model_show_view_unsuccessful', ['model'=>'User Profile']) ], 422);
            }
        } else {
            return response()->json([ "data" => "Not authorized to view resource" ], 403);
        }
    }

    /**
     * Update a specific user profile by name
     *
     * @param Request $request
     * @param User|null $user
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function updateProfile(Request $request, User $user)
    {
        $this->logInfo(__METHOD__);
        $profile_name = $request->query('name', null);
        if (!isset($profile_name)) {
            return response()->json([ "data" => "Missing request query parameter: name" ], 404);
        }
        $profile_value = $request->query('value', null);
        if (!isset($profile_value)) {
            return response()->json([ "data" => "Missing request query parameter: value" ], 404);
        }

        if ($this->authorize('read', [ User::class, $user ])) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            try {
                $profile = $user->getProfile($profile_name);
                if (isset($profile)) {
                    $user->setProfile($profile_name, $profile_value);
                    $responseObject['name'] = $profile_name;
                    $responseObject['value'] = $user->getProfileValue($profile_name);
                    return response()->json([ 'data' => $responseObject ], 200);
                } else {
                    $profile = Profile::where(['name' => $profile_name])->first();
                    if (isset($profile)) {
                        $user->setProfile($profile_name, $profile_value);
                        $responseObject['name'] = $profile_name;
                        $responseObject['value'] = $user->getProfileValue($profile_name);
                        return response()->json([ 'data' => $responseObject ], 200);
                    } else {
                        $responseObject['error'] = "profile not found ".$profile_name;
                        return response()->json([ 'data' => $responseObject ], 404);
                    }
                }
            } catch (QueryException $ex) {
                $this->logQueryException(__METHOD__, $request, $ex);
                return response()->json([ 'data' => trans('messages.model_update_unsuccessful', ['model'=>'User Profile']) ], 422);
            }
        } else {
            return response()->json([ "data" => "Not authorized to update resource" ], 403);
        }
    }

    /**
     * Display the specified user's current project
     *
     * @param Request $request
     * @param User|null $user
     * @return CoraResource|JsonResponse
     * @throws AuthorizationException
     */
    public function getCurrentProject(Request $request, User $user)
    {
        $this->logInfo(__METHOD__);
        if ($this->authorize('read', [ User::class, $user ])) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            try {
                return new CoraResource($user->getCurrentProject());
            } catch (QueryException $ex) {
                $this->logQueryException(__METHOD__, $request, $ex);
                return response()->json([ 'data' => trans('messages.model_index_view_unsuccessful', ['model'=>'User Current Project']) ], 422);
            }
        } else {
            return response()->json([ "data" => "Not authorized to view resource" ], 403);
        }
    }

    /**
     * Update the specified user's current project
     *
     * @param Request $request
     * @param User|null $user
     * @return CoraResource|JsonResponse
     * @throws AuthorizationException
     */
    public function updateCurrentProject(Request $request, User $user)
    {
        $this->logInfo(__METHOD__);
        $project_id = $request->query('id', null);
        if (!isset($project_id)) {
            return response()->json([ "data" => "Missing request query parameter: id" ], 404);
        }

        if ($this->authorize('read', [ User::class, $user ])) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            try {
                $project_from = $user->getCurrentProject();
                $project_to = $user->projects->find($project_id);

                $user->switchProject($project_from, $project_to);
                return new CoraResource($user->getCurrentProject());
            } catch (QueryException $ex) {
                $this->logQueryException(__METHOD__, $request, $ex);
                return response()->json([ 'data' => trans('messages.model_update_unsuccessful', ['model'=>'User Current Project']) ], 422);
            }
        } else {
            return response()->json([ "data" => "Not authorized to update resource" ], 403);
        }
    }

    /**
     * Display a listing of the projects the specified user belongs to
     *
     * @param Request $request
     * @param User|null $user
     * @return CoraResourceCollection|JsonResponse
     * @throws AuthorizationException
     */
    public function getProjects(Request $request, User $user)
    {
        $this->logInfo(__METHOD__);
        if ($this->authorize('read', [ User::class, $user ])) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            try {
                $list = $user->projects()->paginate($this::$pagination_length_large);
                return new CoraResourceCollection($list);
            } catch (QueryException $ex) {
                $this->logQueryException(__METHOD__, $request, $ex);
                return response()->json([ 'data' => trans('messages.model_index_view_unsuccessful', ['model'=>'User Projects']) ], 422);
            }
        } else {
            return response()->json([ "data" => "Not authorized to view resource" ], 403);
        }
    }

    /**
     * Display a listing of the projects the specified user belongs to
     *
     * @param Request $request
     * @param User|null $user
     * @return CoraResourceCollection|JsonResponse
     * @throws AuthorizationException
     */
    public function getRoles(Request $request, User $user)
    {
        $this->logInfo(__METHOD__);
        if ($this->authorize('read', [ User::class, $user ])) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            try {
                $roles = $user->roles;
                $list = $roles->push($user->role);
                return new CoraResourceCollection($list);
            } catch (QueryException $ex) {
                $this->logQueryException(__METHOD__, $request, $ex);
                return response()->json([ 'data' => trans('messages.model_index_view_unsuccessful', ['model'=>'User Roles']) ], 422);
            }
        } else {
            return response()->json([ "data" => "Not authorized to view resource" ], 403);
        }
    }

    /**
     * Display a listing of the projects the specified user belongs to
     *
     * @param Request $request
     * @param User|null $user
     * @return CoraResourceCollection|JsonResponse
     * @throws AuthorizationException
     */
    public function getPermissions(Request $request, User $user)
    {
        $this->logInfo(__METHOD__);
        if ($this->authorize('read', [ User::class, $user ])) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            try {
                $list = $user->role->permissions;
                return new CoraResourceCollection($list);
            } catch (QueryException $ex) {
                $this->logQueryException(__METHOD__, $request, $ex);
                return response()->json([ 'data' => trans('messages.model_index_view_unsuccessful', ['model'=>'User Roles']) ], 422);
            }
        } else {
            return response()->json([ "data" => "Not authorized to view resource" ], 403);
        }
    }

    /**
     * Display a listing of the instruments that are assigned to the specified user
     *
     * @param Request $request
     * @param User|null $user
     * @return CoraResourceCollection|JsonResponse
     * @throws AuthorizationException
     */
    public function getInstruments(Request $request, User $user)
    {
        $this->logInfo(__METHOD__);
        if ($this->authorize('read', [ User::class, $user ])) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            try {
                $list = $user->instruments()->paginate($this::$pagination_length_large);
                return new CoraResourceCollection($list);
            } catch (QueryException $ex) {
                $this->logQueryException(__METHOD__, $request, $ex);
                return response()->json([ 'data' => trans('messages.model_index_view_unsuccessful', ['model'=>'User Instruments']) ], 422);
            }
        } else {
            return response()->json([ "data" => "Not authorized to view resource" ], 403);
        }
    }

    /**
     * Display a listing of the user association resource for the specified association type
     * For a full listing of association type, see $allowed_association_types
     *
     * @param Request $request
     * @param User $user
     * @return CoraResourceCollection|JsonResponse|\Illuminate\Http\Resources\Json\AnonymousResourceCollection
     * @throws AuthorizationException
     */
    public function getAssociations(Request $request, User $user)
    {
        $this->logInfo(__METHOD__);
        if ($this->authorize('read', [User::class, $user])) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            try {
                if ($request->has('type')) {
                    $type = $request->query('type');
                    $type = (!isset($type)) ? "" : strtolower($type);
                    if (! in_array($type, $this::$allowed_association_types)) {
                        return response()->json([ "data" => "Bad request: unsupported association type"], 400);
                    }
                } else {
                    return response()->json([ "data" => "Bad request: missing request parameters"], 400);
                }

                $list = null;
                switch ($type) {
                    case "instruments":
                        $list = $user->instruments()->paginate($this::$pagination_length_large);
                        break;
                    case "notifications":
                        $list = $user->notifications()->paginate($this::$pagination_length_large);
                        return new CoraResourceCollection($list);
                        break;
                    case "unread-notifications":
                        $list = $user->unreadNotifications()->paginate($this::$pagination_length_large);
                        return new CoraResourceCollection($list);
                        break;
                    case "projects":
                        $list = $user->projects()->paginate($this::$pagination_length_large);
                        break;
                    case "audits":
                        $list = $user->audits()->paginate($this::$pagination_length_large);
                        break;
                    default: // should never get here.
                        return response()->json([ "data" => "Bad request: missing request parameters"], 400);
                }

                return ListResource::collection($list)->additional(["user" => $user,
                    "status"=>"success", 'message'=>"User associations get successful"]);
            } catch (QueryException $ex) {
                $this->logQueryException(__METHOD__, $request, $ex);
                return response()->json([ 'data' => trans('messages.model_update_unsuccessful', ['model'=>'User']) ], 422);
            }
        } else {
            return response()->json([ "data" => "Not Authorized to read user" ], 403);
        }
    }

    /**
     * Update the specified user association resource for the specified association type
     *
     * For a full listing of association type, see $allowed_association_types
     *
     * @param Request $request
     * @param User $user
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function updateAssociations(Request $request, User $user)
    {
        $this->logInfo(__METHOD__);
        if ($this->authorize('edit', [User::class, $user])) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            try {
                if ($request->has('type')) {
                    $type = $request->input('type');
                    $type = (!isset($type)) ? "" : strtolower($type);
                    if (! in_array($type, $this::$allowed_association_types)) {
                        return response()->json([ "data" => "Bad request: unsupported association type"], 400);
                    }
                } else {
                    return response()->json([ "data" => "Bad request: missing request parameters"], 400);
                }

                if ($request->has('id')) {
                    $ids = $request->input('id');
                    $listIds = (!isset($ids)) ? [] : array_map('trim', explode(',', $request->input('id')));
                } else if ($request->has('listIds')) {
                    $listIds = $request->input('listIds');
                } else {
                    return response()->json([ "data" => "Bad request: missing request parameters"], 400);
                }

                $response_data = $this->syncAssociations($user, $request, $listIds, $type);
                return response()->json(["data"=>$response_data, "user"=>$user,
                    "status"=>"success", 'message'=>"User associations updated successful"],200);
            } catch (QueryException $ex) {
                $this->logQueryException(__METHOD__, $request, $ex);
                return response()->json([ 'data' => trans('messages.model_update_unsuccessful', ['model'=>'User']) ], 422);
            }
        } else {
            return response()->json([ "data" => "Not Authorized to edit user" ], 403);
        }
    }

    /**
     * @param User $user
     * @param Request $request
     * @param $listIds
     * @param $type
     * @return array|\Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    protected function syncAssociations(User $user, Request $request, $listIds, $type) {
        $this->logInfo(__METHOD__);
        $listIds = isset($listIds) ? $listIds : [];
        $list = null;
        switch ($type) {
            case "instruments":
                $user->instruments()->sync($this->populateCreateFieldsForSyncWithIDs($listIds));
                $list = $user->instruments()->paginate($this::$pagination_length_large);
                break;
            case "projects":
                $user->projects()->sync($this->populateCreateFieldsForSyncWithIDs($listIds));
                $list = $user->projects()->paginate($this::$pagination_length_large);
                break;
            default: // should never get here.
                return [ "data" => "Bad request: unsupported association type" ];
        }

        if (isset($list)) {
            return ListResource::collection($list);
        } else {
            return [ "data" => "Bad request: missing request parameters" ];
        }
    }

    /**
     * @param Request $request
     * @param User $user
     * @return CoraResourceCollection|JsonResponse
     * @throws AuthorizationException
     */
    public function getNotifications(Request $request, User $user)
    {
        $this->logInfo(__METHOD__);
        // Check if user is authorized to perform the action
        if ($this->authorize('read', [ User::class, $user ])) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            $list = $user->notifications()->paginate($this::$pagination_length_large);
            return new CoraResourceCollection($list);
        } else {
            return response()->json([ "data" => "Not authorized to view resource" ], 403);
        }
    }

    /**
     * @param Request $request
     * @param User $user
     * @param $notificationId
     * @return CoraResource|JsonResponse
     * @throws AuthorizationException
     */
    public function notificationShow(Request $request, User $user, $notificationId)
    {
        $this->logInfo(__METHOD__);
        // Check if user is authorized to perform the action
        if ($this->authorize('read', [ User::class, $user ])) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            // find notification and mark it as read and then send the notification for display
            $notification = $user->notifications->where('id', $notificationId);
            $notification->markAsRead();
            return new CoraResource($notification);
        } else {
            return response()->json([ "data" => "Not authorized to view resource" ], 403);
        }
    }

    /**
     * @param Request $request
     * @param User $user
     * @param $notificationId
     * @return CoraResourceCollection|JsonResponse
     * @throws AuthorizationException
     */
    public function notificationMarkAsRead(Request $request, User $user, $notificationId)
    {
        $this->logInfo(__METHOD__);
        if ($this->authorize('edit', [User::class, $user])) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            try {
                // Mark the notification as read
                $this->logInfo(__METHOD__, "Notification id: ".$notificationId);
                $user->unreadNotifications->where('id', $notificationId)->markAsRead();
                $list = $user->notifications()->paginate($this::$pagination_length_large);
                return new CoraResourceCollection($list);
            } catch (QueryException $ex) {
                $this->logQueryException(__METHOD__, $request, $ex);
                return response()->json([ 'data' => trans('messages.model_update_unsuccessful', ['model'=>'Notifications']) ], 422);
            }
        } else {
            return response()->json([ "data" => "Not authorized to edit resource" ], 403);
        }
    }

    /**
     * @param Request $request
     * @param User $user
     * @return CoraResourceCollection|JsonResponse
     * @throws AuthorizationException
     */
    public function notificationMarkAllRead(Request $request, User $user)
    {
        $this->logInfo(__METHOD__);
        if ($this->authorize('edit', [User::class, $user])) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            try {
                // Mark all notifications as read
                $user->unreadNotifications->markAsRead();
                $list = $user->notifications()->paginate($this::$pagination_length_large);
                return new CoraResourceCollection($list);
            } catch (QueryException $ex) {
                $this->logQueryException(__METHOD__, $request, $ex);
                return response()->json([ 'data' => trans('messages.model_update_unsuccessful', ['model'=>'Notifications']) ], 422);
            }
        } else {
            return response()->json([ "data" => "Not authorized to edit resource" ], 403);
        }
    }

    /**
     * This method is typically called by the Org Administrator to reset a given users password.
     *
     * @param PasswordResetRequest $request
     * @param User $user
     * @return CoraResource|JsonResponse
     * @throws AuthorizationException
     */
    public function resetPassword(PasswordResetRequest $request, User $user)
    {
        $this->logInfo(__METHOD__, "Start ".$user->id.":".$user->name);
        if ($this->authorize('edit', [User::class, $user])) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            if ($this->theUser->isAdminOrOrgAdmin()) {
                try {
                     $this->logInfo(__METHOD__, "password: ".$request['password']);
                    $password = bcrypt($request['password']);
                    $user->fill(['password' => $password])->save();
                    return new CoraResource($user);
                } catch(QueryException $ex) {
                    $this->logQueryException(__METHOD__, $request, $ex);
                    return response()->json([ 'data' => trans('messages.model_update_unsuccessful', ['model'=>'User']) ], 422);
                }
            } else {
                return response()->json([ "data" => "Not authorized to edit resource" ], 403);
            }

        }
        return response()->json([ "data" => "Not authorized to edit resource" ], 403);
    }

    /**
     * This method is typically called by the Org Administrator to reset a users inactivity lock.
     *
     * @param Request $request
     * @param User $user
     * @return CoraResource|JsonResponse
     * @throws AuthorizationException
     */
    public function resetInactivityLock(Request $request, User $user)
    {
        $this->logInfo(__METHOD__, "Start ".$user->id.":".$user->name);
        if ($this->authorize('edit', [User::class, $user])) {
            if ($this->theUser->isAdminOrOrgAdmin()) {
                $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
                try {
                    $user->last_login_at = Carbon::now();
                    $user->save();
                    return new CoraResource($user);
                } catch(QueryException $ex) {
                    $this->logQueryException(__METHOD__, $request, $ex);
                    return response()->json([ 'data' => trans('messages.model_update_unsuccessful', ['model'=>'User']) ], 422);
                }
            } else {
                return response()->json([ "data" => "Not authorized to edit resource" ], 403);
            }
        }
    }

    /**
     * This method is typically called by the User or Org Administrator to reset a given users API token.
     *
     * @param Request $request
     * @param User $user
     * @return CoraResource|JsonResponse
     * @throws AuthorizationException
     */
    public function generateAPIToken(Request $request, User $user)
    {
        $this->logInfo(__METHOD__, "Start ".$user->id.":".$user->name);
        if ($this->authorize('edit', [User::class, $user])) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            try {
                $user->api_token = Str::random(60);
                $user->save();
                return new CoraResource($user);
            } catch(QueryException $ex) {
                $this->logQueryException(__METHOD__, $request, $ex);
                return response()->json([ 'data' => trans('messages.model_update_unsuccessful', ['model'=>'User']) ], 422);
            }
        }
    }

    /**
     * @param Request $request
     * @param User $user
     * @return CoraResourceCollection|JsonResponse
     * @throws AuthorizationException
     */
    public function getAudit(Request $request, User $user)
    {
        $this->logInfo(__METHOD__, "Start ".$user->id.":".$user->name);
        if ($this->authorize('edit', [User::class, $user])) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            try {
                $type = null;
                if ($request->has('type')) {
                    $type = $request->input('type');
                    $type = ($type === "Specimen") ? "App\\SkeletalElement" : "App\\".$type;
                }

                if (!isset($type)) {
                    $list = Audit::with(["user", "auditable"])->where("user_id", $user->id)->latest()->paginate($this::$pagination_length_large);
                } else {
                    $list = Audit::with(["user", "auditable"])->where("user_id", $user->id)->where("auditable_type", $type)->paginate($this::$pagination_length_large);
                }
                return (new CoraResourceCollection($list))->additional(["type"=>$type]);
            } catch(QueryException $ex) {
                $this->logQueryException(__METHOD__, $request, $ex);
                return response()->json([ 'data' => trans('messages.model_update_unsuccessful', ['model'=>'User']) ], 422);
            }
        }
    }
}