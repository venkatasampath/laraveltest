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
 * Class ProjectSummaryDNA
 * @package App
 */
class ProjectSummaryDNA extends Model
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
    protected $table = 'project_dna_summary';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['project_id', 'se_total', 'num_sampled', 'num_results_received',
        'num_results_reportable', 'num_results_inconclusive', 'num_results_unable_to_assign', 'num_results_cancelled',
        'num_mito_sequences', 'created_by', 'updated_by'];

    public function project()
    {
        return $this->belongsTo('App\Project', 'project_id');
    }
}
