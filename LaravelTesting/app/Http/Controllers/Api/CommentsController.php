<?php

/**
 * Cora Api CommentsController
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
use App\Http\Requests\CommentRequest;
use App\Http\Resources\CoraResource;
use App\Http\Resources\CoraResourceCollection;
use App\Comment;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * Class CommentsController
 * @package App\Http\Controllers\Api
 */
class CommentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return CoraResourceCollection|array|JsonResponse
     * @throws AuthorizationException
     */
    public function index(Request $request)
    {
        $this->logInfo(__METHOD__);
        if ($this->authorize('browse', [ Comment::class ])) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            $commentable_id = $request->query('commentable_id');
            if (isset($commentable_id)) {
                $list = Comment::where('commentable_id', "=", $commentable_id)
                    ->paginate($this::$pagination_length_large);
            } else {
                return [ "data" => "Bad request: missing request parameters" ];
            }

            return new CoraResourceCollection($list);
        } else {
            return response()->json([ "data" => "Not authorized to view all resources" ], 403);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CommentRequest $request
     * @return CoraResource|JsonResponse
     * @throws AuthorizationException
     */
    public function store(CommentRequest $request)
    {
        $this->logInfo(__METHOD__);
        if ($this->authorize('add', Comment::class)) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            try {
                if (!$this->hasInput($request)) {
                    return response()->json([ "data" => "Request is empty" ], 400);
                } else {
                    if (!$request->has('text') || !$request->has('commentable_id') || !$request->has('commentable_type') ) {
                        return response()->json([ "data" => "Bad request: missing request parameters"], 400);
                    }
                }
                $request['user_id'] = $this->theUser->id;
                $request['created_by'] = $this->theUser->name;
                $request['updated_by'] = $this->theUser->name;
                $object = Comment::create($request->all());
                return new CoraResource($object);
            } catch (QueryException $ex) {
                $this->logQueryException(__METHOD__, $request, $ex);
                return response()->json([ 'data' => trans('messages.model_add_unsuccessful', ['model'=>'Comments']) ], 422);
            }
        } else {
            return response()->json([ "data" => "Not authorized to create resource" ], 403);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param Request $request
     * @param Comment|null $comment
     * @return CoraResource|JsonResponse
     * @throws AuthorizationException
     */
    public function show(Request $request, Comment $comment = null)
    {
        $this->logInfo(__METHOD__);
        if (!isset($comment)) {
            if ($request->query('id')) {
                $comment = Comment::where('id', $request->query('id'))->first();
            }

            if (!isset($comment)) {
                return response()->json([ "data" => "Comment not found" ], 404);
            }
        }

        // Check if user is authorized to perform the action
        if ($this->authorize('read', [ Comment::class, $comment ])) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            return new CoraResource($comment);
        } else {
            return response()->json([ "data" => "Not authorized to view resource" ], 403);
        }
    }

    /**
     * Update an existing comment
     *
     * @param CommentRequest $request
     * @param Comment $comment
     * @return CoraResource|JsonResponse
     * @throws AuthorizationException
     */
    public function update(CommentRequest $request, Comment $comment)
    {
        $this->logInfo(__METHOD__);
        if ($this->authorize('edit', [Comment::class, $comment])) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            try {
                if (!$this->hasInput($request)) {
                    return response()->json([ "data" => "Request is empty" ], 400);
                } else {
                    if (!$request->has('text')) {
                        return response()->json([ "data" => "Bad request: missing request parameters"], 400);
                    }
                }
                $request['user_id'] = $this->theUser->id;
                $request['updated_by'] = $this->theUser->name;
                $comment->update($request->all());
                return new CoraResource($comment);
            } catch (QueryException $ex) {
                $this->logQueryException(__METHOD__, $request, $ex);
                return response()->json([ 'data' => trans('messages.model_update_unsuccessful', ['model'=>'Comments']) ], 422);
            }
        } else {
            return response()->json([ "data" => "Not authorized to update resource" ], 403);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Request $request
     * @param Comment $comment
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function destroy(Request $request, Comment $comment)
    {
        $this->logInfo(__METHOD__);
        if ($this->authorize('delete', [Comment::class, $comment])) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            try {
                $comment->delete();
                return response()->json([ 'data' => "Resource deleted successfully" ], 200);
            } catch (QueryException $ex) {
                $this->logQueryException(__METHOD__, $request, $ex);
                return response()->json([ 'data' => trans('messages.model_delete_unsuccessful', ['model'=>'Comments']) ], 422);
            }
        } else {
            return response()->json([ "data" => "Not authorized to delete resource" ], 403);
        }
    }
}
