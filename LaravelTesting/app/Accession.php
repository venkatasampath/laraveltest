<?php

/**
 * Accession Model
 *
 * @category   Accession
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
use App\Scopes\ProjectScope;

class Accession extends Model
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
    protected $table = 'accessions';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['org_id', 'project_id', 'number', 'provenance1', 'provenance2', 'consolidated_an', 'created_by', 'updated_by'];

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

    public function getKeyAttribute()
    {
        return $this->number .'-'. $this->provenance1 .'-'. $this->provenance2;
    }

    public function getANP1Attribute()
    {
        if ($this->provenance1 == null || $this->provenance1 == '') {
            return $this->number;
        } else {
            return $this->number .'-'. $this->provenance1;
        }
    }

    public function getANP1P2Attribute()
    {
        if ($this->provenance2 == null || $this->provenance2 == '') {
            return $this->getANP1Attribute();
        } else {
            return $this->number .'-'. $this->provenance1 .'-'. $this->provenance2;
        }
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
}
