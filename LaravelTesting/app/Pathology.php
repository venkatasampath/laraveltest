<?php

/**
 * Pathology Model
 *
 * @category   Pathology
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

class Pathology extends Model
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
    protected $table = 'pathologys';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['abnormality_category', 'characteristics', 'color','icon', 'created_by', 'updated_by'];

    public function getNameAttribute()
    {
        if ($this->characteristics == null || $this->characteristics == '') {
            return $this->abnormality_category;
        } else {
            return $this->abnormality_category .'-'. $this->characteristics;
        }
    }
	
	public function getNameWithoutBranchAttribute()
    {
        if ($this->characteristics == null || $this->characteristics == '') {
            return $this->abnormality_category;
        } else {
            return $this->abnormality_category .'-'. $this->characteristics;
        }
    }

    /**
     * Get all of the skeletalelements that are assigned this pathology.
     */
    public function skeletalelements()
    {
        return $this->belongsToMany('App\SkeletalElement', 'se_pathology', 'pathology_id', 'se_id');
    }
}
