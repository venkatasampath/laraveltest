<?php

/**
 * Measurement Model
 *
 * @category   Measurement
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

class Measurement extends Model
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
    protected $fillable = ['sb_id', 'name', 'display_name', 'display_order', 'description', 'stature', 'sex',
        'min_value', 'max_value', 'step_value', 'min_threshold', 'max_threshold',
        'instrument', 'display_help', 'help_url', 'comment', 'created_by', 'updated_by'];

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
        return $this->belongsToMany('App\SkeletalElement', 'se_measurement', 'measurement_id', 'se_id');
    }

    public function getRollOverHelpAttribute()
    {
        $help = "";
        if (isset($this->instrument) && !empty($this->instrument)) {
            $help = $help . "<p style='text-align:left'><strong>Instrument: </strong>" . $this->instrument . "</p>";
        }
        if (isset($this->display_help) && !empty($this->display_help)) {
            $help = $help . "<p style='text-align:left'><strong>Help: </strong>" . $this->display_help . "</p>";
        }
        if (isset($this->comment) && !empty($this->comment)) {
            $help = $help . "<p style='text-align:left'><strong>Comment: </strong>" . $this->comment . "</p>";
        }
        if (isset($this->min_threshold) && !empty($this->min_threshold)) {
            $help = $help . "<p style='text-align:left'><strong>Min Threshold: </strong>" . $this->min_threshold . "</p>";
        }
        if (isset($this->max_threshold) && !empty($this->max_threshold)) {
            $help = $help . "<p style='text-align:left'><strong>Max Threshold: </strong>" . $this->max_threshold . "</p>";
        }
        return $help;
    }
}
