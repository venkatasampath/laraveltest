<?php

/**
 * Cora Api TagsController
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
use App\Http\Requests\TagRequest;
use App\Http\Resources\CoraResource;
use App\Http\Resources\CoraResourceCollection;
use App\Project;
use App\Tag;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * Class TagsController
 * @package App\Http\Controllers\Api
 */
class TagsController extends Controller
{
    /**
     * Display a listing of the resource.
     * @param Request $request
     * @return CoraResourceCollection|JsonResponse
     * @throws AuthorizationException
     */
    public function index(Request $request)
    {
        $this->logInfo(__METHOD__);
        if ($this->authorize('browse', [ Tag::class ])) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            $type = $request->query('type');
            if (isset($type)) {
                $this->logInfo(__METHOD__, "Type: ".$type);
                $list = Tag::where(function ($query) use ($type) {
                    $query->where("org_id", "=", $this->theOrg->id)->where("project_id", "=", $this->theProject->id)->where("type", "=", $type);
                })->orWhere(function ($query) use ($type) {
                    $query->where("org_id", "=", $this->theOrg->id)->whereNull("project_id")->where("type", "=", $type);
                })->orWhere(function ($query) use ($type) {
                    $query->whereNull("org_id")->WhereNull("project_id")->where("type", "=", $type);
                })->paginate($this::$pagination_length_large);
            } else {
                if ($this->theUser->isAdmin()) {
                    $list = Tag::paginate($this::$pagination_length_large);
                } else if ($this->theUser->isOrgAdmin()) {
                    $list = Tag::where('org_id', $this->theOrg->id)->paginate($this::$pagination_length_large);
                } else {
                    return response()->json([ "data" => "Not authorized to view resource" ], 403);
                }
            }
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
    public function store(Request $request)
    {
        $this->logInfo(__METHOD__);
        if ($this->authorize('add', Tag::class)) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            try {
                if (!$this->hasInput($request)) {
                    return response()->json([ "data" => "Request is empty" ], 400);
                }
                $object = Tag::create($request->all());
                return new CoraResource($object);
            } catch (QueryException $ex) {
                $this->logQueryException(__METHOD__, $request, $ex);
                return response()->json([ 'data' => trans('messages.model_add_unsuccessful', ['model'=>'Tags']) ], 422);
            }
        } else {
            return response()->json([ "data" => "Not authorized to create resource" ], 403);
        }
    }

    /**
     * Display the specified resource.
     * @param Request $request
     * @param Tag|null $tag
     * @return CoraResource|JsonResponse
     * @throws AuthorizationException
     */
    public function show(Request $request, Tag $tag = null)
    {
        $this->logInfo(__METHOD__);

        // Check if user is authorized to perform the action
        if ($this->authorize('read', [ Tag::class, $tag ])) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            if (!isset($tag)) {
                if ($request->query('id')) {
                    $tag = Tag::where('id', $request->query('id'))->first();
                }
                if (!isset($tag)) {
                    return response()->json([ "data" => "Tag not found" ], 404);
                }
            }
            return new CoraResource($tag);
        } else {
            return response()->json([ "data" => "Not authorized to view resource" ], 403);
        }
    }

    /**
     * Update an existing tag
     * @param TagRequest $request
     * @param Tag $tag
     * @return CoraResource|JsonResponse
     * @throws AuthorizationException
     */
    public function update(TagRequest $request, Tag $tag)
    {
        $this->logInfo(__METHOD__);
        if ($this->authorize('edit', [Tag::class, $tag])) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            try {
                if (!$this->hasInput($request)) {
                    return response()->json([ "data" => "Request is empty" ], 400);
                }
                $this->logInfo(__METHOD__, "Request: ".$request);
                $tag->update($request->all());
                return new CoraResource($tag);
            } catch (QueryException $ex) {
                $this->logQueryException(__METHOD__, $request, $ex);
                return response()->json([ 'data' => trans('messages.model_update_unsuccessful', ['model'=>'Tags']) ], 422);
            }
        } else {
            return response()->json([ "data" => "Not authorized to update resource" ], 403);
        }
    }

    /**
     * Remove the specified resource from storage.
     * @param Request $request
     * @param Tag $tag
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function destroy(Request $request, Tag $tag)
    {
        $this->logInfo(__METHOD__);
        if ($this->authorize('delete', [Tag::class, $tag])) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            try {
                $tag->delete();
                return response()->json([ 'data' => "Resource deleted successfully" ], 200);
            } catch (QueryException $ex) {
                $this->logQueryException(__METHOD__, $request, $ex);
                return response()->json([ 'data' => trans('messages.model_delete_unsuccessful', ['model'=>'Tags']) ], 422);
            }
        } else {
            return response()->json([ "data" => "Not authorized to delete resource" ], 403);
        }
    }
}
