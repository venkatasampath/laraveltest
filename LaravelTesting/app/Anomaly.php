<?php

/**
 * Anomalys Model
 *
 * @category   Anomaly
 * @package    CoRA-Models
 * @author     Sachin Pawaskar<spawaskar@unomaha.edu>>
 * @copyright  2016-2018
 * @license    The MIT License (MIT)
 * @version    GIT: $Id$
 * @since      File available since Release 1.0.0
 */

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Anomaly extends Model
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
    protected $table = 'anomalys';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['sb_id', 'individuating_trait', 'color','icon', 'created_by', 'updated_by'];

    public function getTraitAttribute()
    {
        return $this->individuating_trait;
    }
    public function skeletalbone()
    {
        return $this->belongsTo('App\SkeletalBone', 'sb_id');
    }
    /**
     * Get all of the skeletalelements that are assigned this anomaly.
     */
    public function skeletalelements()
    {
        return $this->belongsToMany('App\SkeletalElement', 'se_anomaly', 'anomaly_id', 'se_id');
    }

}
