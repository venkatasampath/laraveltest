<?php

/**
 * Cora Api BaseDataController
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
use App\Http\Resources\CoraResource as CoraResource;
use App\Http\Resources\CoraResourceCollection;
use App\Http\Resources\ListResource;
use App\Anomaly;
use App\Measurement;
use App\Method;
use App\MethodFeature;
use App\Pathology;
use App\ProjectStatus;
use App\SkeletalBone;
use App\BoneGroup;
use App\SkeletalElement;
use App\Taphonomy;
use App\Trauma;
use App\User;
use App\Role;
use App\Zone;
use App\Lab;
use App\DnaAnalysisType;
use App\Profile;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;

/**
 * Class CoraBaseDataController
 * @package App\Http\Controllers\Api
 * ToDo: and try-catch blocks as necessary
 */
class CoraBaseDataController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return CoraResource|CoraResourceCollection|JsonResponse|\Illuminate\Http\Resources\Json\AnonymousResourceCollection
     * @throws AuthorizationException
     */
    public function getBones(Request $request)
    {
        $this->logInfo(__METHOD__);
        if ($this->authorize('browse', [ SkeletalElement::class ])) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            if ($request->has('list')) {
                $list = SkeletalBone::orderBy('name')->get();
                return ListResource::collection($list)->additional(["status" => "success"]);
            } else if ($request->has('id')) {
                $object = SkeletalBone::find($request->query('id'));
                return new CoraResource($object, null, true);
            } else if ($request->has('name')) {
                $object = SkeletalBone::all()->where('search_name', strtolower($request->query('name')))->first();
                return new CoraResource($object, ['image_zones', 'image_measurements'],true);
            } else {
                $list = SkeletalBone::orderBy('name')->paginate($this::$pagination_length_large);
                return new CoraResourceCollection($list, ['image_zones', 'image_measurements'], true);
            }
        } else {
            return response()->json([ "data" => "Not Authorized to view all bones" ], 403);
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return JsonResponse|\Illuminate\Http\Resources\Json\AnonymousResourceCollection
     * @throws AuthorizationException
     */
    public function getBoneGroups(Request $request)
    {
        $this->logInfo(__METHOD__);
        if ($this->authorize('browse', [ SkeletalElement::class ])) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            if ($request->has('list')) {
                $list = DB::table('bone_groups')->select('group_name')->groupBy(['group_name'])
                    ->orderBy('group_name')->pluck('group_name');
                return response()->json([ "data" => $list, "status" => "success" ], 200);
            } else if ($request->has('name')) {
                $list = BoneGroup::where('group_name', $request->query('name'))->orderBy('display_order')->get();
                return ListResource::collection($list)->additional(["status" => "success"]);
            } else {
                $list = BoneGroup::orderBy('group_name')->orderBy('display_order')->get();
                return ListResource::collection($list)->additional(["status" => "success"]);
            }
        } else {
            return response()->json([ "data" => "Not Authorized to view all bones" ], 403);
        }
    }

    /**
     * Display a listing of the resource.
     * This will return all the bones belonging to a bone group
     * This will be called from the create specimens by group
     *
     * @param Request $request
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function getBonesInGroup( Request $request )
    {
        $this->logInfo(__METHOD__);
        if ($this->authorize('browse', [ SkeletalElement::class ])) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            $group = null;
            if ($request->has('bone_grouping') || $request->has('bone_group') || $request->has('group')) {
                $group = $request->has('bone_group') && !isset($group) ? $request['bone_group'] : $group;
                $group = $request->has('bone_grouping') && !isset($group) ? $request['bone_grouping'] : $group;
                $group = $request->has('group') && !isset($group) ? $request['group'] : $group;
            } else {
                $this->logInfo(__METHOD__, "Bad request: missing request parameters");
                return response()->json([ "data" => "Bad request: missing request parameters"], 400);
            }

            $this->logInfo(__METHOD__, "Group: ".$group);
            $bones = BoneGroup::where('group_name', $group)->join('skeletal_bones', 'bone_groups.sb_id', '=', 'skeletal_bones.id')->orderBy('display_order')->get();
            $bones_array = array();
            foreach ($bones as $bone) {
                if ($bone->side) {
                    $bones_array[$bone->name . ' - Left'] = $bone->name . ' - Left';
                    $bones_array[$bone->name . ' - Right'] = $bone->name . ' - Right';
                } else {
                    $bones_array[$bone->name] = $bone->name;
                }
            }
            return response()->json([ "data" => $bones_array ]);
        } else {
            return response()->json([ "data" => "Not authorized to view resource" ], 403);
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return CoraResourceCollection|JsonResponse|\Illuminate\Http\Resources\Json\AnonymousResourceCollection
     * @throws AuthorizationException
     */
    public function getAnomalies(Request $request)
    {
        $this->logInfo(__METHOD__);
        if ($this->authorize('browse', [ SkeletalElement::class ])) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            if ($request->has('id')) {
                $bone = SkeletalBone::find($request->query('id'));
                if ($request->has('list')) {
                    $list = Anomaly::where('sb_id', $bone->id)->get();
                    return ListResource::collection($list)->additional(["bone" => $bone, "status" => "success"]);
                } else {
                    $list = Anomaly::where('sb_id', $bone->id)->get();
                    return (new CoraResourceCollection($list))->additional(["bone" => $bone]);
                }
            } else if ($request->has('name')) {
                $bone = SkeletalBone::all()->where('search_name', strtolower($request->query('name')))->first();
                if ($request->has('list')) {
                    $list = Anomaly::where('sb_id', $bone->id)->get();
                    return ListResource::collection($list)->additional(["bone" => $bone, "status" => "success"]);
                } else {
                    $list = Anomaly::where('sb_id', $bone->id)->get();
                    return (new CoraResourceCollection($list))->additional(["bone" => $bone]);
                }
            } else {
                $list = Anomaly::paginate($this::$pagination_length_large);
                return new CoraResourceCollection($list, null, true);
            }
        } else {
            return response()->json([ "data" => "Not Authorized to view all anomalies" ], 403);
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return CoraResourceCollection|JsonResponse|\Illuminate\Http\Resources\Json\AnonymousResourceCollection
     * @throws AuthorizationException
     */
    public function getMeasurements(Request $request)
    {
        $this->logInfo(__METHOD__);
        if ($this->authorize('browse', [ SkeletalElement::class ])) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            if ($request->has('id')) {
                $bone = SkeletalBone::find($request->query('id'));
                if ($request->has('list')) {
                    $list = Measurement::where('sb_id', $bone->id)->orderBy('display_order')->get();
                    return ListResource::collection($list)->additional(["bone" => $bone, "status" => "success"]);
                } else {
                    $list = Measurement::where('sb_id', $bone->id)->orderBy('display_order')->get();
                    return (new CoraResourceCollection($list))->additional(["bone" => $bone]);
                }
            } else if ($request->has('name')) {
                $bone = SkeletalBone::all()->where('search_name', strtolower($request->query('name')))->first();
                if ($request->has('list')) {
                    $list = Measurement::where('sb_id', $bone->id)->orderBy('display_order')->get();
                    return ListResource::collection($list)->additional(["bone" => $bone, "status" => "success"]);
                } else {
                    $list = Measurement::where('sb_id', $bone->id)->orderBy('display_order')->get();
                    return (new CoraResourceCollection($list))->additional(["bone" => $bone]);
                }
            } else {
                $list = Measurement::orderBy('sb_id')->orderBy('display_order')->get();
                return new CoraResourceCollection($list, null, true);
            }
        } else {
            return response()->json([ "data" => "Not Authorized to view all measurements" ], 403);
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return CoraResourceCollection|JsonResponse|\Illuminate\Http\Resources\Json\AnonymousResourceCollection
     * @throws AuthorizationException
     */
    public function getZones(Request $request)
    {
        $this->logInfo(__METHOD__);
        if ($this->authorize('browse', [ SkeletalElement::class ])) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            if ($request->has('id')) {
                $bone = SkeletalBone::find($request->query('id'));
                if ($request->has('list')) {
                    $list = Zone::where('sb_id', $bone->id)->orderBy('display_order')->get();
                    return ListResource::collection($list)->additional(["bone" => $bone, "status" => "success"]);
                } else {
                    $list = Zone::where('sb_id', $bone->id)->orderBy('display_order')->get();
                    return (new CoraResourceCollection($list))->additional(["bone" => $bone]);
                }
            } else if ($request->has('name')) {
                $bone = SkeletalBone::all()->where('search_name', strtolower($request->query('name')))->first();
                if ($request->has('list')) {
                    $list = Zone::where('sb_id', $bone->id)->orderBy('display_order')->get();
                    return ListResource::collection($list)->additional(["bone" => $bone, "status" => "success"]);
                } else {
                    $list = Zone::where('sb_id', $bone->id)->orderBy('display_order')->get();
                    return (new CoraResourceCollection($list))->additional(["bone" => $bone]);
                }
            } else {
                $list = Zone::orderBy('sb_id')->orderBy('display_order')->get();
                return new CoraResourceCollection($list, null, true);
            }
        } else {
            return response()->json([ "data" => "Not Authorized to view all zones" ], 403);
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return CoraResourceCollection|JsonResponse|\Illuminate\Http\Resources\Json\AnonymousResourceCollection
     * @throws AuthorizationException
     */
    public function getMethods(Request $request)
    {
        $this->logInfo(__METHOD__);
        if ($this->authorize('browse', [ SkeletalElement::class ])) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            if ($request->has('id')) {
                $bone = SkeletalBone::find($request->query('id'));
                if ($request->has('list')) {
                    $list = Method::where('sb_id', $bone->id)->orderBy('type')->orderBy('name')->get();
                    return ListResource::collection($list)->additional(["bone" => $bone, "status" => "success"]);
                } else {
                    $list = Method::with(['features'])->where('sb_id', $bone->id)->orderBy('type')->orderBy('name')->get();
                    return (new CoraResourceCollection($list, ['display_help', 'help_url'], true))->additional(["bone" => $bone]);
                }
            } else if ($request->has('name')) {
                $bone = SkeletalBone::all()->where('search_name', strtolower($request->query('name')))->first();
                if ($request->has('list')) {
                    $list = Method::where('sb_id', $bone->id)->orderBy('type')->orderBy('name')->get();
                    return ListResource::collection($list)->additional(["bone" => $bone, "status" => "success"]);
                } else {
                    $list = Method::with(['features'])->where('sb_id', $bone->id)->orderBy('type')->orderBy('name')->get();
                    return (new CoraResourceCollection($list, ['display_help', 'help_url'], true))->additional(["bone" => $bone]);
                }
            } else {
                $list = Method::with(['features'])->orderBy('sb_id')->orderBy('type')->orderBy('name')->get();
                return new CoraResourceCollection($list, ['display_help', 'help_url'], true);
            }
        } else {
            return response()->json([ "data" => "Not Authorized to view all zones" ], 403);
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return CoraResourceCollection|JsonResponse|\Illuminate\Http\Resources\Json\AnonymousResourceCollection
     * @throws AuthorizationException
     */
    public function getTaphonomies(Request $request)
    {
        $this->logInfo(__METHOD__);
        if ($this->authorize('browse', [ SkeletalElement::class ])) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            if ($request->has('list')) {
                $list = Taphonomy::orderBy('category')->orderBy('type')->orderBy('subtype')->get();
                return ListResource::collection($list)->additional(["status" => "success"]);
            } else {
                $list = Taphonomy::orderBy('category')->orderBy('type')->orderBy('subtype')->get();
                return new CoraResourceCollection($list, null, true);
            }
        } else {
            return response()->json([ "data" => "Not Authorized to view all zones" ], 403);
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return CoraResourceCollection|JsonResponse|\Illuminate\Http\Resources\Json\AnonymousResourceCollection
     * @throws AuthorizationException
     */
    public function getTraumas(Request $request)
    {
        $this->logInfo(__METHOD__);
        if ($this->authorize('browse', [ SkeletalElement::class ])) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            if ($request->has('list')) {
                $list = Trauma::orderBy('timing')->get();
                return ListResource::collection($list)->additional(["status" => "success"]);
            } else {
                $list = Trauma::orderBy('timing')->get();
                return new CoraResourceCollection($list, null, true);
            }
        } else {
            return response()->json([ "data" => "Not Authorized to view all zones" ], 403);
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return CoraResourceCollection|JsonResponse|\Illuminate\Http\Resources\Json\AnonymousResourceCollection
     * @throws AuthorizationException
     */
    public function getPathologies(Request $request)
    {
        $this->logInfo(__METHOD__);
        if ($this->authorize('browse', [ SkeletalElement::class ])) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            if ($request->has('list')) {
                $list = Pathology::orderBy('abnormality_category')->get();
                return ListResource::collection($list)->additional(["status" => "success"]);
            } else {
                $list = Pathology::orderBy('abnormality_category')->get();
                return new CoraResourceCollection($list, null, true);
            }
        } else {
            return response()->json([ "data" => "Not Authorized to view all zones" ], 403);
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return CoraResource|CoraResourceCollection|JsonResponse|\Illuminate\Http\Resources\Json\AnonymousResourceCollection
     * @throws AuthorizationException
     */
    public function getBoneArticulations(Request $request)
    {
        $this->logInfo(__METHOD__);
        if ($this->authorize('browse', [ SkeletalElement::class ])) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            if ($request->has('list')) {
                $list = SkeletalBone::orderBy('name')->get();
                return ListResource::collection($list)->additional(["status" => "success"]);
            } else if ($request->has('id')) {
                $object = SkeletalBone::with(['articulations'])->find($request->query('id'));
                return new CoraResource($object, ['image_zones', 'image_measurements'],true);
            } else if ($request->has('name')) {
                $object = SkeletalBone::with(['articulations'])->where('search_name', strtolower($request->query('name')))->first();
                return new CoraResource($object, ['image_zones', 'image_measurements'],true);
            } else {
                $list = SkeletalBone::with(['articulations'])->orderBy('name')->get();
                return new CoraResourceCollection($list, ['image_zones', 'image_measurements'], true);
            }
        } else {
            return response()->json([ "data" => "Not Authorized to view all bones" ], 403);
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return CoraResource|CoraResourceCollection|JsonResponse|\Illuminate\Http\Resources\Json\AnonymousResourceCollection
     * @throws AuthorizationException
     */
    public function getBoneMorphologies(Request $request)
    {
        $this->logInfo(__METHOD__);
        if ($this->authorize('browse', [ SkeletalElement::class ])) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            if ($request->has('list')) {
                $list = SkeletalBone::orderBy('name')->get();
                return ListResource::collection($list)->additional(["status" => "success"]);
            } else if ($request->has('id')) {
                $object = SkeletalBone::with(['morphologys'])->find($request->query('id'));
                return new CoraResource($object, ['image_zones', 'image_measurements'],true);
            } else if ($request->has('name')) {
                $object = SkeletalBone::with(['morphologys'])->where('search_name', strtolower($request->query('name')))->first();
                return new CoraResource($object, ['image_zones', 'image_measurements'],true);
            } else {
                $list = SkeletalBone::with(['morphologys'])->orderBy('name')->get();
                return new CoraResourceCollection($list, ['image_zones', 'image_measurements'], true);
            }
        } else {
            return response()->json([ "data" => "Not Authorized to view all bones" ], 403);
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return CoraResource|CoraResourceCollection|JsonResponse|\Illuminate\Http\Resources\Json\AnonymousResourceCollection
     * @throws AuthorizationException
     */
    public function getLabs(Request $request)
    {
        $this->logInfo(__METHOD__);
        if ($this->authorize('browse', [ SkeletalElement::class ])) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            if ($request->has('list')) {
                if ($request->has('type')) {
                    $list = Lab::where('type', $request->query('type'))->orderBy('name')->get();
                } else {
                    $list = Lab::orderBy('name')->get();
                }
                return ListResource::collection($list)->additional(["status" => "success"]);
            } else if ($request->has('type')) {
                $list = Lab::where('type', $request->query('type'))->get();
                return new CoraResourceCollection($list, null,false);
            } else {
                $list = Lab::orderBy('name')->get();
                return new CoraResourceCollection($list, null, false);
            }
        } else {
            return response()->json([ "data" => "Not Authorized to view all labs" ], 403);
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return CoraResource|CoraResourceCollection|JsonResponse|\Illuminate\Http\Resources\Json\AnonymousResourceCollection
     * @throws AuthorizationException
     */
    public function getDnaAnalysisTypes(Request $request)
    {
        $this->logInfo(__METHOD__);
        if ($this->authorize('browse', [ SkeletalElement::class ])) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            if ($request->has('list')) {
                if ($request->has('type')) {
                    $list = DnaAnalysisType::where('type', $request->query('type'))->orderBy('name')->get();
                } else {
                    $list = DnaAnalysisType::orderBy('name')->get();
                }
                return ListResource::collection($list)->additional(["status" => "success"]);
            } else if ($request->has('type')) {
                $list = DnaAnalysisType::where('type', $request->query('type'))->get();
                return new CoraResourceCollection($list, null,false);
            } else {
                $list = DnaAnalysisType::orderBy('name')->get();
                return new CoraResourceCollection($list, null, false);
            }
        } else {
            return response()->json([ "data" => "Not Authorized to view all labs" ], 403);
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return CoraResource|CoraResourceCollection|JsonResponse|\Illuminate\Http\Resources\Json\AnonymousResourceCollection
     * @throws AuthorizationException
     */
    public function getProfiles(Request $request)
    {
        $this->logInfo(__METHOD__);
        if ($this->authorize('browse', [ SkeletalElement::class ])) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            if ($request->has('list')) {
                $list = Profile::orderBy('name')->get();
                return ListResource::collection($list)->additional(["status" => "success"]);
            } else if ($request->has('type')) {
                $list = Profile::where('type', $request->query('type'))->get();
                return new CoraResourceCollection($list, null,false);
            } else {
                $list = Profile::orderBy('name')->get();
                return new CoraResourceCollection($list, null, false);
            }
        } else {
            return response()->json([ "data" => "Not Authorized to view all labs" ], 403);
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
    public function getRolePermissions(Request $request)
    {
        $this->logInfo(__METHOD__);
        if ($this->authorize('browse', [ SkeletalElement::class ])) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            if ($request->has('role')) {
                $role = Role::where('name', $request->query('role'))->first();
                if ($role) {
                    $list = $role->permissions()->paginate($this::$pagination_length_large);
                    if ($request->has('list')) {
                        return ListResource::collection($list)->additional(["status" => "success"]);
                    }
                    return new CoraResourceCollection($list, null,false);
                } else {
                    return response()->json([ "data" => "Unknown role: " . $request->query('role') ], 404);
                }
            }
        } else {
            return response()->json([ "data" => "Not Authorized to view permissions for role" ], 403);
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return CoraResourceCollection|JsonResponse|\Illuminate\Http\Resources\Json\AnonymousResourceCollection
     * @throws AuthorizationException
     */
    public function getProjectStatuses(Request $request)
    {
        $this->logInfo(__METHOD__);
        if ($this->authorize('browse', [ SkeletalElement::class ])) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            if ($request->has('list')) {
                $list = ProjectStatus::orderBy('display_order')->get();
                return ListResource::collection($list)->additional(["status" => "success"]);
            } else {
                $list = ProjectStatus::orderBy('display_order')->get();
                return new CoraResourceCollection($list, null, true);
            }
        } else {
            return response()->json([ "data" => "Not Authorized to view all project status" ], 403);
        }
    }

    /**
     * Display a listing of all country, language and timezone codes.
     *
     * @param Request $request
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function getLocalizationCodes(Request $request)
    {
        $this->logInfo(__METHOD__);
        if ($this->authorize('browse', [ SkeletalElement::class ])) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            $country_codes = Config::get('countries');
            $language_codes = Config::get('language');
            $timezone_codes = Config::get('timezones');
            return response()->json(["data" => ["country"=>$country_codes, "language"=>$language_codes, "timezone"=>$timezone_codes],
                "status"=>"success", 'message'=>"Country Language and Timezones"],200);
        } else {
            return response()->json([ "data" => "Not Authorized to view all country, language and timezone codes" ], 403);
        }
    }

    public function getRoles(Request $request)
    {
        $this->logInfo(__METHOD__);
        if ($this->authorize('browse', [ SkeletalElement::class ])) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            $list = Role::all()->except(1);
            return new CoraResourceCollection($list, null, true);
        } else {
            return response()->json([ "data" => "Not Authorized to view all roles" ], 403);
        }
    }
}

