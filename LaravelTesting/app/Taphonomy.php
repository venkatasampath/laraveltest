<?php

/**
 * Taphonomy Model
 *
 * @category   Taphonomy
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

class Taphonomy extends Model
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
    protected $table = 'taphonomys';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['branch', 'category', 'type', 'subtype', 'color','icon', 'created_by', 'updated_by'];

    public function getNameAttribute()
    {
        if ($this->subtype == null || $this->subtype == '') {
            return $this->branch .'-'. $this->category .'-'. $this->type;
        } else {
            return $this->branch .'-'. $this->category .'-'. $this->type .'-'. $this->subtype;
        }
    }

    public function getNameWithoutBranchAttribute()
    {
        if ($this->subtype == null || $this->subtype == '') {
            return $this->category .'-'. $this->type;
        } else {
            return $this->category .'-'. $this->type .'-'. $this->subtype;
        }
    }

    /**
     * Get all of the skeletalelements that are assigned this taphonomy.
     */
    public function skeletalelements()
    {
        return $this->belongsToMany('App\SkeletalElement', 'se_taphonomy', 'taphonomy_id', 'se_id');
    }
}
