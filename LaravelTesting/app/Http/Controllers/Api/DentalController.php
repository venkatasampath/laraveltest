<?php

/**
 * Cora Api DentalController
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

use App\DentalCode;
use App\Http\Controllers\Controller;
use App\Http\Resources\CoraResourceCollection;
use App\SkeletalElement;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * Class DentalController
 * @package App\Http\Controllers\Api
 */
class DentalController extends Controller
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
        if ($this->authorize('browse', [ SkeletalElement::class ])) {
            $this->logInfo(__METHOD__, Controller::$log_msg_auth_success);
            $type = $request->query('type');
            $this->logInfo(__METHOD__, "Type: ".$type);
            $list = DentalCode::orderBy('type')->orderBy('category')->orderBy('code')->paginate($this::$pagination_length_large);
            return new CoraResourceCollection($list);
        } else {
            return response()->json([ "data" => "Not authorized to view all resources" ], 403);
        }
    }
}