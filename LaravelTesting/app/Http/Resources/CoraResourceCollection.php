<?php

/**
 * Cora ResourceCollection
 *
 * @category
 * @package    CoRA-Resources
 * @author     Sachin Pawaskar<spawaskar@unomaha.edu>
 * @copyright  2016-2020, Sachin Pawaskar, All rights reserved.
 * @license    Proprietary software, All rights reserved.
 * @version    GIT: $Id$
 * @since      File available since Release 3.0.0
 */

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class CoraResourceCollection extends ResourceCollection
{
    static protected $crud_keys =  array("created_at", "updated_at", "deleted_at", "created_by", "updated_by");
    protected $no_crud_ts = false;
    protected $remove_keys = null;

    /**
     * @var array
     */
    static protected $meta = ['meta' => [
        'api_version' => '1.0',
        'author' => 'Sachin Pawaskar',
        'copyright' => 'Copyright © 2016 - 2020 Sachin Pawaskar. All Rights Reserved.',
    ]];

    /**
     * The resource that this resource collects.
     *
     * @var string
     */
    public $collects = 'App\Http\Resources\CoraResource';

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
     * Transform the resource collection into an array.
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

    protected function remove_fields($collection) {
//        dd($this->remove_keys);
        $result = array_map(function ($item) {
            array_forget($item, $this->remove_keys);
            return $item;
        }, $collection);

        return $result;

//        $result = array_map(function($item) {
//            foreach ($this->remove_keys as $key) {
//                unset($item[$key]);
//            }
//            return $item;
//        }, $collection);
//
//        return $result;
    }
}
