<?php

/**
 * Trauma Model
 *
 * @category   Trauma
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

class Trauma extends Model
{
    use SoftDeletes;

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['name'];

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
    protected $table = 'traumas';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['timing', 'type', 'color','icon', 'created_by', 'updated_by'];

    public function getNameAttribute()
    {
        if ($this->type == null || $this->type == '') {
            return $this->timing;
        } else {
            return $this->timing .'-'. $this->type;
        }
    }

    /**
     * Get all of the skeletalelements that are assigned this trauma.
     */
    public function skeletalelements()
    {
        return $this->belongsToMany('App\SkeletalElement', 'se_trauma', 'trauma_id', 'se_id');
    }

}
