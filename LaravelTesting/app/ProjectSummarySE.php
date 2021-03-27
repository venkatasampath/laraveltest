<?php

/**
 * Project Model
 *
 * @category   Project
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
use App\Scopes\OrgScope;

/**
 * Class ProjectSummarySE
 * @package App
 */
class ProjectSummarySE extends Model
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
    protected $table = 'project_se_summary';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['project_id', 'se_total', 'num_complete', 'num_measured', 'num_dna_sampled', 'num_isotope_sampled',
        'num_ct_scanned', 'num_xray_scanned', 'num_clavicle', 'num_clavicle_triage', 'num_inventoried', 'num_reviewed',
        'num_individuals', 'num_unique_individuals', 'created_by', 'updated_by'];

    public function project()
    {
        return $this->belongsTo('App\Project', 'project_id');
    }
}
