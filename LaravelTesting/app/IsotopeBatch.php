<?php

/**
 * IsotopeBatch Model
 *
 * @category   IsotopeBatch
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
use OwenIt\Auditing\Contracts\Auditable;

/**
 * Class IsotopeBatch
 * @package App
 */
class IsotopeBatch extends Model implements Auditable
{
    use SoftDeletes;
    use \OwenIt\Auditing\Auditable;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'isotope_batches';

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['cleaning_start_date', 'sonicate_samples_dh2o_cycle1_start_date','sonicate_samples_dh2o_cycle2_start_date',
        'sonicate_samples_ethanol95_start_date', 'sonicate_samples_ethanol100_start_date',
        'dry_samples_start_date', 'dry_samples_end_date', 'demineralizing_start_date', 'demineralizing_end_date',
        'demineralizing_treatment_start_date', 'demineralizing_treatment_end_date', 'rha_treatment_start_date', 'rha_treatment_end_date',
        'rha_sample_rinse1_start_date', 'rha_sample_rinse1_end_date', 'rha_sample_rinse2_start_date', 'rha_sample_rinse2_end_date',
        'rha_sample_rinse3_start_date', 'rha_sample_rinse3_end_date', 'rha_sample_rinse4_start_date', 'rha_sample_rinse4_end_date',
        'rha_sample_rinse5_start_date', 'rha_sample_rinse5_end_date',
        'sc_clean_vials_and_lids_date', 'sc_freeze_vials_date', 'fdc_samples_start_date', 'fdc_samples_end_date',
        'deleted_at'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['org_id', 'project_id', 'lab_id', 'external_case_id', 'batch_num', 'status', 'labeling_tubes',
        'rsc', 'rinse_samples', 'cleaning_start_date',
        'sonicate_samples_dh2o_cycle1', 'sonicate_samples_dh2o_cycle1_start_date', 'sonicate_samples_dh2o_cycle2', 'sonicate_samples_dh2o_cycle2_start_date',
        'sonicate_samples_ethanol95', 'sonicate_samples_ethanol95_start_date', 'sonicate_samples_ethanol100', 'sonicate_samples_ethanol100_start_date',
        'dry_samples_start', 'dry_samples_end', 'dry_samples_start_date', 'dry_samples_end_date',
        'cleaning_initials', 'demineralizing_treatment_start', 'demineralizing_treatment_end', 'demineralizing_treatment_start_date', 'demineralizing_treatment_end_date', 'rinse_demineralized_samples',
        'rha_treatment_start', 'rha_treatment_end', 'rha_treatment_start_date', 'rha_treatment_end_date',
        'rha_sample_rinse1_start', 'rha_sample_rinse1_end', 'rha_sample_rinse1_start_date', 'rha_sample_rinse1_end_date',
        'rha_sample_rinse2_start', 'rha_sample_rinse2_end', 'rha_sample_rinse2_start_date', 'rha_sample_rinse2_end_date',
        'rha_sample_rinse3_start', 'rha_sample_rinse3_end', 'rha_sample_rinse3_start_date', 'rha_sample_rinse3_end_date',
        'rha_sample_rinse4_start', 'rha_sample_rinse4_end', 'rha_sample_rinse4_start_date', 'rha_sample_rinse4_end_date',
        'rha_sample_rinse5_start', 'rha_sample_rinse5_end', 'rha_sample_rinse5_start_date', 'rha_sample_rinse5_end_date',
        'sc_clean_vials_and_lids', 'sc_clean_vials_and_lids_date', 'sc_add_solubale', 'sc_place_in_oven',
        'sc_centrifuge_tubes', 'sc_num_acid_heat_treatment', 'sc_num_collagen_transfers', 'sc_freeze_vials', 'sc_freeze_vials_date',
        'fdc_on', 'fdc_samples_start', 'fdc_samples_end', 'fdc_samples_start_date', 'fdc_samples_end_date',
        'combined_samples_weight', 'notes',
        'created_by', 'updated_by'];

    /**
     * The side array for SkeletalElements.
     *
     * @var array
     */
    static public $status = ['Open' => 'Open', 'Associating Isotopes' => 'Associating Isotopes', 'Cleaning' => 'Cleaning', 'Demineralizing' => 'Demineralizing', 'Removal Humic Acids' => 'Removal Humic Acids',
        'Solubilizing' => 'Solubilizing', 'Freeze Drying Collagen' => 'Freeze Drying Collagen', 'Determining Collagen Yield' => 'Determining Collagen Yield', 'Closed' => 'Closed'];

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
     * Get all of the isotopes that are assigned this isotope batch.
     */
    public function isotopes()
    {
        return $this->HasMany('App\Isotope', 'batch_id');
    }

    public function getCountSamplesAttribute()
    {
        return $this->isotopes()->count();
    }

    public function getCountWeightSamplesCleanedAttribute()
    {
        $isotopes = $this->isotopes;
        $count = 0;
        foreach ($isotopes as $isotope) {
            if (isset($isotope->weight_sample_cleaned)) {
                $count++;
            }
        }
        return $count;
    }

    public function getCountWeightCollagenAttribute()
    {
        $isotopes = $this->isotopes;
        $count = 0;
        foreach ($isotopes as $isotope) {
            if (isset($isotope->weight_collagen)) {
                $count++;
            }
        }
        return $count;
    }

    public function getCleaningStartDateAttribute($value)
    {
        return ($value != "") ? Carbon::parse($value)->format('Y-m-d') : null;
    }

    public function getSonicateSamplesDh2oCycle1StartDateAttribute($value)
    {
        return ($value != "") ? Carbon::parse($value)->format('Y-m-d') : null;
    }

    public function getSonicateSamplesDh2oCycle2StartDateAttribute($value)
    {
        return ($value != "") ? Carbon::parse($value)->format('Y-m-d') : null;
    }

    public function getSonicateSamplesEthanol95StartDateAttribute($value)
    {
        return ($value != "") ? Carbon::parse($value)->format('Y-m-d') : null;
    }

    public function getSonicateSamplesEthanol100StartDateAttribute($value)
    {
        return ($value != "") ? Carbon::parse($value)->format('Y-m-d') : null;
    }

    public function getDrySamplesStartDateAttribute($value)
    {
        return ($value != "") ? Carbon::parse($value)->format('Y-m-d') : null;
    }

    public function getDrySamplesEndDateAttribute($value)
    {
        return ($value != "") ? Carbon::parse($value)->format('Y-m-d') : null;
    }

    public function getDemineralizingTreatmentStartDateAttribute($value)
    {
        return ($value != "") ? Carbon::parse($value)->format('Y-m-d') : null;
    }

    public function getDemineralizingTreatmentEndDateAttribute($value)
    {
        return ($value != "") ? Carbon::parse($value)->format('Y-m-d') : null;
    }

    public function getRhaTreatmentStartDateAttribute($value)
    {
        return ($value != "") ? Carbon::parse($value)->format('Y-m-d') : null;
    }

    public function getRhaTreatmentEndDateAttribute($value)
    {
        return ($value != "") ? Carbon::parse($value)->format('Y-m-d') : null;
    }

    public function getRhaSampleRinse1StartDateAttribute($value)
    {
        return ($value != "") ? Carbon::parse($value)->format('Y-m-d') : null;
    }

    public function getRhaSampleRinse1EndDateAttribute($value)
    {
        return ($value != "") ? Carbon::parse($value)->format('Y-m-d') : null;
    }

    public function getRhaSampleRinse2StartDateAttribute($value)
    {
        return ($value != "") ? Carbon::parse($value)->format('Y-m-d') : null;
    }

    public function getRhaSampleRinse2EndDateAttribute($value)
    {
        return ($value != "") ? Carbon::parse($value)->format('Y-m-d') : null;
    }

    public function getRhaSampleRinse3StartDateAttribute($value)
    {
        return ($value != "") ? Carbon::parse($value)->format('Y-m-d') : null;
    }

    public function getRhaSampleRinse3EndDateAttribute($value)
    {
        return ($value != "") ? Carbon::parse($value)->format('Y-m-d') : null;
    }

    public function getRhaSampleRinse4StartDateAttribute($value)
    {
        return ($value != "") ? Carbon::parse($value)->format('Y-m-d') : null;
    }

    public function getRhaSampleRinse4EndDateAttribute($value)
    {
        return ($value != "") ? Carbon::parse($value)->format('Y-m-d') : null;
    }

    public function getRhaSampleRinse5StartDateAttribute($value)
    {
        return ($value != "") ? Carbon::parse($value)->format('Y-m-d') : null;
    }

    public function getRhaSampleRinse5EndDateAttribute($value)
    {
        return ($value != "") ? Carbon::parse($value)->format('Y-m-d') : null;
    }

    public function getScCleanVialsAndLidsDateAttribute($value)
    {
        return ($value != "") ? Carbon::parse($value)->format('Y-m-d') : null;
    }

    public function getScFreezeVialsDateAttribute($value)
    {
        return ($value != "") ? Carbon::parse($value)->format('Y-m-d') : null;
    }

    public function getFdcSamplesStartDateAttribute($value)
    {
        return ($value != "") ? Carbon::parse($value)->format('Y-m-d') : null;
    }

    public function getFdcSamplesEndDateAttribute($value)
    {
        return ($value != "") ? Carbon::parse($value)->format('Y-m-d') : null;
    }
}
