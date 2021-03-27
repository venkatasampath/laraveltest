<?php

/**
 * Haplogroup Model
 *
 * @category   Haplogroup
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

class Haplogroup extends Model
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
    protected $table = 'haplogroups';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['type', 'letter', 'subgroup', 'ancestry', 'created_by', 'updated_by'];

    static public $type = ['Mito' => 'Mito', 'Ystr' => 'Ystr'];

    static public $ancestry = ['Asian' => 'Asian', 'African' => 'African', 'European' => 'European', 'Native American' => 'Native American',
        'Pacific' => 'Pacific'];

    public function getHgAttribute()
    {
        if ($this->ancestry == null || $this->ancestry == '') {
            return $this->letter;
        } else {
            return $this->letter .'-'. $this->ancestry;
        }

    }

    public function getKeyAttribute()
    {
        if ($this->subgroup == null || $this->subgroup == '') {
            if ($this->ancestry == null || $this->ancestry == '') {
                return $this->letter;
            } else {
                return $this->letter .'-'. $this->ancestry;
            }
        } else {
            if ($this->ancestry == null || $this->ancestry == '') {
                return $this->letter .'-'. $this->subgroup;
            } else {
                return $this->letter .'-'. $this->subgroup .'-'. $this->ancestry;
            }
        }
    }

    /**
     * Get all of the DNA's that have this haplogroup.
     */
    public function dnas()
    {
        return $this->belongsToMany('App\Dna', 'mito_haplogroup_id');
    }

}
