<?php

/**
 * Cora JsonResource
 *
 * @category
 * @package    CoRA-Resources
 * @author     Sachin Pawaskar<spawaskar@unomaha.edu>
 * @copyright  2016-2020, Sachin Pawaskar, All rights reserved.
 * @license    Proprietary software, All rights reserved.
 * @version    GIT: $Id$
 * @since      File available since Release 3.0.0
 */

/**
 * For APIs, correct errors are even more important than for web-only browser projects.
 * As people, we can understand the error from browser message and then decide what
 * to do, but for APIs – they are usually consumed by other software and not by
 * people, so returned result should be “readable by machines”. Therefore
 * HTTP status codes. Every request to the API returns some status code,
 * for successful requests it’s usually 200, or 2xx with XX as other.
 *
 * If you return a success response, it should contain 2xx code,
 * here are most popular ones for success:
 * Status Code	Meaning
 * 200	        Ok - The request has succeeded
 * 201	        Created - The request has been fulfilled and resulted in a new resource being created.
 * 202          Accepted - The request has been accepted for processing, but the processing has not been completed.
 * 204	        No Content
 *
 * If you return an error response, it should NOT contain 2xx code,
 * here are most popular ones for errors:
 * Status Code	Meaning
 * 400	        Bad request (something wrong with URL or parameters)
 * 401	        Not authorized (not logged in)
 * 403	        Logged in but access to requested area is forbidden
 * 404	        Not Found (page or other resource doesn’t exist)
 * 422	        Unprocessable Entity (validation failed)
 * 500	        General server error
 *
 * Here are some links to best practices for a pragmatic restful Api
 * https://github.com/paypal/api-standards/blob/master/api-style-guide.md
 * https://github.com/Microsoft/api-guidelines/blob/master/Guidelines.md#44-license
 * https://www.vinaysahni.com/best-practices-for-a-pragmatic-restful-api
 * https://opensource.zalando.com/restful-api-guidelines/
 * https://laraveldaily.com/laravel-api-errors-and-exceptions-how-to-return-responses/
 * https://www.restapitutorial.com/httpstatuscodes.html
 *
 */

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class CoraJsonResource
 * @package App\Http\Resources
 */
class CoraResource extends JsonResource
{
    static protected $crud_keys =  array("created_at", "updated_at", "deleted_at", "created_by", "updated_by");
    protected $no_crud_ts = false;
    protected $remove_keys = [];

    /**
     * @var array
     */
    static public $meta = ['meta' => [
        'api_version' => '1.0',
        'author' => 'Sachin Pawaskar',
        'copyright' => 'Copyright © 2016 - 2020 Sachin Pawaskar. All Rights Reserved.',
    ]];

    /**
     * Create a new resource instance.
     *
     * @param mixed $resource
     * @param null $remove_keys
     * @param bool $no_crud_ts
     */
    public function __construct($resource, $remove_keys = null, $no_crud_ts = false)
    {
        parent::__construct($resource);
        if (isset($remove_keys)) {
            $this->remove_keys = $remove_keys;
        }
        $this->no_crud_ts = $no_crud_ts;
        if ($this->no_crud_ts === true) {
            $this->remove_keys = isset($remove_keys) ? array_merge($remove_keys, $this::$crud_keys) : $this::$crud_keys;
        }
    }

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        if (isset($this->remove_keys)) {
            return $this->remove_fields( parent::toArray($request));
        }
        return parent::toArray($request);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function with($request)
    {
        return [ 'status' => 'success',
            'meta' => array_merge(['app' => config('app.name'), 'app_version' => config('app.version')], self::$meta['meta'])];
    }

    protected function remove_fields($array) {
        array_forget($array, $this->remove_keys);
        return $array;

//        foreach ($this->remove_keys as $key) {
//            unset($array[$key]);
//        }
//        return $array;
    }
}
