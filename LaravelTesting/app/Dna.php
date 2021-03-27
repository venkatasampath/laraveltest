<?php

/**
 * Dna Model
 *
 * @category   Dna
 * @package    CoRA-Models
 * @author     Sachin Pawaskar<spawaskar@unomaha.edu>
 * @copyright  2016-2019
 * @license    The MIT License (MIT)
 * @version    GIT: $Id$
 * @since      File available since Release 1.0.0
 */

namespace App;

use App\Scopes\ProjectScope;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class Dna extends Model implements Auditable
{
    use SoftDeletes;
    use \OwenIt\Auditing\Auditable;

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at', 'ystr_request_date', 'ystr_receive_date', 'astr_request_date', 'astr_receive_date',
        'btb_request_date', 'btb_results_date', 'mito_receive_date', 'mito_request_date', 'mcc_date'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $fillable = ['uuid', 'se_id', 'org_id', 'project_id', 'lab_id', 'sb_id', 'user_id', 'external_case_id', 'btb_request_date', 'btb_results_date', 'sample_number', 'resample_indicator', 'mito_method',
        'mito_sequence_number', 'mito_sequence_subgroup', 'mito_sequence_similar', 'mito_match_count', 'mito_total_count', 'disposition', 'sample_condition', 'weight_sample_remaining',
        'mito_base_pairs','mito_receive_date', 'mito_request_date', 'mito_haplogroup_id', 'mito_haplosubgroup', 'mito_results_confidence', 'mito_confirmed_regions', 'mito_mcc_date',
        'mito_fasta_sequence', 'mito_polymorphisms', 'austr_method', 'austr_receive_date', 'austr_request_date', 'austr_results_confidence', 'austr_sequence_number', 'austr_sequence_similar', 'austr_sequence_subgroup','austr_num_loci',
        'austr_loci', 'austr_mcc_date', 'ystr_method', 'ystr_receive_date', 'ystr_request_date', 'ystr_results_confidence', 'ystr_sequence_number','ystr_sequence_subgroup',
        'ystr_sequence_similar', 'ystr_match_count', 'ystr_total_count', 'ystr_num_loci', 'ystr_loci', 'ystr_haplogroup', 'ystr_haplosubgroup', 'ystr_mcc_date', 'created_by', 'updated_by'];

    /**
     * The methods array for DNA.
     *
     * @var array
     */
    static public $method = ['NGS' => 'NGS', 'Sanger' => 'Sanger'];

    /**
     * The results confidence array for SkeletalElements.
     *
     * @var array
     */
    static public $results_confidence = ['Pending' => 'Pending', 'Reportable' => 'Reportable', 'Inconclusive' => 'Inconclusive', 'Unable to Assign' => 'Unable to Assign', 'Cancelled' => 'Cancelled', 'No Results' => 'No Results',];

    /**
     * The disposition array for SkeletalElements.
     *
     * @var array
     */
    static public $disposition = ['Stored' => 'Stored', 'Consumed' => 'Consumed', 'Returned' => 'Returned'];

    /**
     * The sample condition array for SkeletalElements.
     *
     * @var array
     */
    static public $sample_condition = ['Stored' => 'Stored', 'Consumed' => 'Consumed', 'Returned' => 'Returned'];

    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope(new ProjectScope);
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
        return $this->skeletalelement();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function specimen()
    {
        return $this->skeletalelement();
    }

    /**
     * Get all of the comments for the dna.
     */
    public function comments()
    {
        return $this->morphMany('App\Comment', 'commentable');
    }

    /**
     * Get all of the tags for the dna.
     */
    public function tags()
    {
        return $this->morphToMany('App\Tag', 'taggable');
    }

    public function getMitoRequestDateAttribute($value)
    {
        return ($value != "") ? Carbon::parse($value)->format('Y-m-d') : null;
    }
    public function getYstrRequestDateAttribute($value)
    {
        return ($value != "") ? Carbon::parse($value)->format('Y-m-d') : null;
    }
    public function getYstrReceiveDateAttribute($value)
    {
        return ($value != "") ? Carbon::parse($value)->format('Y-m-d') : null;
    }
    public function getAustrRequestDateAttribute($value)
    {
        return ($value != "") ? Carbon::parse($value)->format('Y-m-d') : null;
    }
    public function getAustrReceiveDateAttribute($value)
    {
        return ($value != "") ? Carbon::parse($value)->format('Y-m-d') : null;
    }

    public function setYstrRequestDateAttribute($date)
    {
        $this->attributes['ystr_request_date'] = ($date != "") ? Carbon::parse($date) : null;
    }

    public function setYstrReceiveDateAttribute($date)
    {
        $this->attributes['ystr_receive_date'] = ($date != "") ? Carbon::parse($date) : null;
    }

    public function setAstrRequestDateAttribute($date)
    {
        $this->attributes['astr_request_date'] = ($date != "") ? Carbon::parse($date) : null;
    }

    public function setAstrReceiveDateAttribute($date)
    {
        $this->attributes['astr_receive_date'] = ($date != "") ? Carbon::parse($date) : null;
    }

    public function setMitoHaplogroupIdAttribute($value)
    {
        $this->attributes['mito_haplogroup_id'] = $value ?: null;
    }

    public function getMitoReceiveDateAttribute($value)
    {
        return ($value != "") ? Carbon::parse($value)->format('Y-m-d') : null;
    }

    public function getMitoMCCDateAttribute($value)
    {
        return ($value != "") ? Carbon::parse($value)->format('Y-m-d') : null;
    }

    public function getYstrMCCDateAttribute($value)
    {
        return ($value != "") ? Carbon::parse($value)->format('Y-m-d') : null;
    }

    public function getAustrMCCDateAttribute($value)
    {
        return ($value != "") ? Carbon::parse($value)->format('Y-m-d') : null;
    }

    public function setbtbRequestDateAttribute($date)
    {
        $this->attributes['btb_request_date'] = ($date != "") ? Carbon::parse($date) : null;
    }

    public function getbtbRequestDateAttribute($value)
    {
        return ($value != "") ? Carbon::parse($value)->format('Y-m-d') : null;
    }

    public function setbtbResultsDateAttribute($date)
    {
        $this->attributes['btb_results_date'] = ($date != "") ? Carbon::parse($date) : null;
    }

    public function getbtbResultsDateAttribute($value)
    {
        return ($value != "") ? Carbon::parse($value)->format('Y-m-d') : null;
    }

}
