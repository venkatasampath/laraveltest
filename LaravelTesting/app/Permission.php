<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Permission extends \TCG\Voyager\Models\Permission
{
    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['created_at, updated_at'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['key', 'table_name', 'created_at', 'updated_at', 'permission_group_id'];

}
