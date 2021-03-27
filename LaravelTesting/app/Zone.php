<?php

/**
 * Zone Model
 *
 * @category   Zone
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

class Zone extends Model
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
    protected $fillable = ['sb_id', 'name', 'display_name', 'display_order', 'description', 'display_help', 'help_url', 'created_by', 'updated_by'];

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
        return $this->belongsToMany('App\SkeletalElement', 'se_zone', 'zone_id', 'se_id');
    }

    public function getRollOverHelpAttribute()
    {
        $help = "";
        $help = $help . "<p><strong>" . trans('labels.zone_number'). ":</strong> " . $this->name . "</p>";
        $help = $help . "<p><strong>" . trans('labels.help') . ":</strong> " . $this->description. "</p>";
        return $help;
    }
}
