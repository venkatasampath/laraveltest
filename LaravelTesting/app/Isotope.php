<?php

/**
 * Isotope Model
 *
 * @category   Isotope
 * @package    CoRA-Models
 * @author     Sachin Pawaskar<spawaskar@unomaha.edu>
 * @copyright  2016-2019
 * @license    The MIT License (MIT)
 * @version    GIT: $Id$
 * @since      File available since Release 1.1.0
 */

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Scopes\ProjectScope;
use OwenIt\Auditing\Contracts\Auditable;

/**
 * Class Isotope
 * @package App
 */
class Isotope extends Model implements Auditable
{
    use SoftDeletes;
    use \OwenIt\Auditing\Auditable;

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at', 'demineralizing_start_date', 'demineralizing_end_date'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['uuid', 'org_id', 'project_id', 'sb_id', 'se_id', 'user_id', 'lab_id', 'batch_id', 'external_case_id', 'sample_number',
        'weight_sample_cleaned', 'weight_vial_lid', 'weight_sample_vial_lid', 'weight_collagen', 'yield_collagen',
        'demineralizing_start_date', 'demineralizing_end_date', 'results_confidence', 'analysis_requested', 'well_location', 'collagen_weight_used_for_analysis',
        'c_weight', 'n_weight', 'o_weight', 's_weight', 'c_delta', 'n_delta', 'o_delta', 's_delta', 'c_percent', 'n_percent', 'o_percent', 's_percent',
        'c_to_n_ratio', 'c_to_o_ratio',
        'created_by', 'updated_by'];

    /**
     * The results confidence array for Isotopes.
     *
     * @var array
     */
    static public $results_confidence = ['Pending' => 'Pending', 'Reportable' => 'Reportable', 'Inconclusive' => 'Inconclusive', 'Unable to Assign' => 'Unable to Assign', 'Cancelled' => 'Cancelled'];

    /**
     * @return string
     */
    public function getKeyAttribute()
    {
        return $this->project->name .':'. $this->specimen->key .':'. $this->sample_number;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function org()
    {
        return $this->belongsTo('App\Org', 'org_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function project()
    {
        return $this->belongsTo('App\Project', 'project_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function skeletalelement()
    {
        return $this->belongsTo('App\SkeletalElement', 'se_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function se()
    {
        return $this->skeletalelement()->withoutGlobalScope(ProjectScope::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function specimen()
    {
        return $this->skeletalelement()->withoutGlobalScope(ProjectScope::class);
    }

    public function batch()
    {
        return $this->belongsTo('App\IsotopeBatch', 'batch_id');
    }

    /**
     * Get all of the tags for the dna.
     */
    public function tags()
    {
        return $this->morphToMany('App\Tag', 'taggable');
    }

    /**
     * @param $value
     * @return string|null
     */
    public function getDemineralizingStartDateAttribute($value)
    {
        return ($value != "") ? Carbon::parse($value)->format('Y-m-d') : null;
    }

    /**
     * @param $value
     * @return string|null
     */
    public function getDemineralizingEndDateAttribute($value)
    {
        return ($value != "") ? Carbon::parse($value)->format('Y-m-d') : null;
    }

    /**
     * @param $value
     * @return string|null
     */
    public function calcWeightCollagen(& $input = null)
    {
        if (isset($input)) {
            if (isset($input['weight_sample_vial_lid']) &&  isset($input['weight_vial_lid'])) {
                return $input['weight_collagen'] = $input['weight_sample_vial_lid'] - $input['weight_vial_lid'];
            }
        } else {
            if (isset($this->weight_sample_vial_lid) &&  isset($this->weight_vial_lid)) {
                return $this->weight_collagen = $this->weight_sample_vial_lid - $this->weight_vial_lid;
            }
        }
    }

    /**
     * @param $value
     * @return string|null
     */
    public function calcYieldCollagen(& $input = null)
    {
        if (isset($input)) {
            if (isset($input['weight_sample_cleaned']) && isset($input['weight_sample_vial_lid']) &&  isset($input['weight_vial_lid'])) {
                return $input['yield_collagen'] = ($input['weight_sample_vial_lid'] - $input['weight_vial_lid']) / $input['weight_sample_cleaned'];
            }
        } else {
            if (isset($this->weight_sample_cleaned) && isset($this->weight_sample_vial_lid) &&  isset($this->weight_vial_lid)) {
                return $this->yield_collagen = ($this->weight_sample_vial_lid - $this->weight_vial_lid) / $this->weight_sample_cleaned;
            }
        }
    }
}
