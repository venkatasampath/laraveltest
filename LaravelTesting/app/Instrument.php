<?php

/**
 * Instruments Model
 *
 * @category   Instruments
 * @package    CoRA-Models
 * @author     Sachin Pawaskar<spawaskar@unomaha.edu>
 * @copyright  2016-2018
 * @license    The MIT License (MIT)
 * @version    GIT: $Id$
 * @since      File available since Release 1.0.0
 */

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Instrument
 * @package App
 */
class Instrument extends Model
{
    use SoftDeletes;

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'instruments';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [ 'org_id', 'code', 'category', 'module', 'reference', 'active', 'created_by', 'updated_by'];

    /**
     * @return string
     */
    public function getNameAttribute()
    {
        return $this->code . '-' . $this->module;
    }

    /**
     * @return string
     */
    public function getFullNameAttribute()
    {
        if ($this->category == null || $this->category == '') {
            return $this->code . '-' . $this->module;
        } else {
            return $this->code . '-' . $this->module .'-'. $this->category;
        }
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function org()
    {
        return $this->belongsTo('App\Org', 'org_id');
    }

    /**
     * Get all of the users that are assigned this instrument.
     */
    public function users()
    {
        return $this->belongsToMany('App\User', 'instrument_user', 'instrument_id', 'user_id')
            ->withPivot('user_id', 'instrument_id', 'created_by', 'updated_by')
            ->withTimestamps();
    }

    /**
     * Get all of the users that are assigned this instrument.
     */
    public function specimens()
    {
        return $this->belongsToMany('App\SkeletalElement', 'se_instrument_user', 'instrument_id', 'se_id')
            ->withPivot('user_id', 'instrument_id', 'org_id', 'project_id', 'type', 'created_by', 'updated_by')
            ->withTimestamps();
    }

    /**
     * Get a List of user ids associated with the current project.
     *
     * @return array
     */
    public function getUserListAttribute()
    {
        return $this->users->pluck('id')->all();
    }
}