<?php

/**
 * Method Model
 *
 * @category   Method
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

class Method extends Model
{
    use SoftDeletes;

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['sb_id', 'name', 'type', 'submethod', 'reference', 'description', 'display_help', 'help_url',
        'uses_feature_score', 'uses_composite_score', 'feature_groups', 'created_by', 'updated_by'];

    public function getNameWithSubmethodAttribute()
    {
        if(empty($this->submethod)){
            return $this->name;
        }
        return $this->name .'-'. $this->submethod;
    }

    public function getFullNameAttribute()
    {
        if(empty($this->submethod)){
            return $this->type." : ".$this->name;
        }
        return $this->name .'-'. $this->submethod;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function skeletalbone()
    {
        return $this->belongsTo('App\SkeletalBone', 'sb_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function skeletalelements()
    {
        return $this->belongsToMany('App\SkeletalElement', 'se_method', 'method_id', 'se_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function features()
    {
        return $this->hasMany('App\MethodFeature', 'method_id')->orderBy('display_order');
    }
}
