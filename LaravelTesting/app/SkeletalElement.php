<?php

/**
 * SkeletalElement Model
 *
 * @category   SkeletalElement
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
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

/**
 * This is the main Model for the Specimen/SE/SkeletalElements Module
 * Class SkeletalElement
 * @package App
 */
class SkeletalElement extends CoraModel
{
    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['mito_sequence_number', 'key', 'key_bone_side'];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at', 'inventoried_at', 'reviewed_at', 'identification_date', 'remains_release_date'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['uuid', 'sb_id', 'user_id', 'org_id', 'project_id', 'reviewer_id', 'inventoried_by_id',
        'accession_number', 'provenance1', 'provenance2', 'designator', 'side', 'completeness', 'consolidated_an',
        'inventoried', 'reviewed', 'measured', 'dna_sampled', 'isotope_sampled', 'clavicle_triage',
        'ct_scanned', 'xray_scanned', '3D_scanned', 'ct_scanned_date', 'xray_scanned_date', '3D_scanned_date',
        'external_id', 'individual_number', 'count', 'mass', 'bone_group', 'bone_group_id', 'remains_status',
        'identification_date', 'remains_release_date', 'inventoried_at', 'reviewed_at', 'created_by', 'updated_by'];

    /**
     * All of the relationships to be touched.
     *
     * @var array
     */
    protected $touches = ['pairs', 'articulations', 'refits', 'morphologys', 'measurements', 'zones', 'methods',
        'dnas', 'isotopes', 'pathologys', 'traumas', 'anomalys', 'taphonomys', 'anomalys','dental_codes'];

    /**
     * The side array for SkeletalElements.
     *
     * @var array
     */
    static public $side = ['Left' => 'Left', 'Right' => 'Right', 'Middle' => 'Middle', 'Unsided' => 'Unsided'];

    /**
     * The completeness array for SkeletalElements.
     *
     * @var array
     */
    static public $completeness = ['Complete' => 'Complete', 'Incomplete' => 'Incomplete'];

    /**
     * The remains_status array for SkeletalElements.
     *
     * @var array
     */
    static public $remains_status = ['In Lab' => 'In Lab', 'Released' => 'Released'];

    /**
     * The elimination_reasons array for SkeletalElement Pairs.
     *
     * @var array
     */
    static public $pair_elimination_reasons = ['mtDNA' => 'mtDNA', 'Fragmentary'=>'Fragmentary', 'Morphology'=>'Morphology', 'Age'=>'Age', 'mtDNA and Morphology' => 'mtDNA and Morphology'];

    /**
     * The delimiter for Specimen composite key attribute.
     *
     * @var array
     */
    static public $key_delimiter = ":";

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
     * @return string
     */
    public function getKeyAttribute()
    {
        return $this->accession_number . SkeletalElement::$key_delimiter . $this->provenance1 . SkeletalElement::$key_delimiter . $this->provenance2 . SkeletalElement::$key_delimiter . $this->designator;
    }

    /**
     * @return string
     */
    public function getNameAttribute()
    {
        return $this->getKeyAttribute();
    }

    /**
     * @return string
     */
    public function getKeyBoneSideAttribute()
    {
        return $this->getKeyAttribute() . ' :: ' . (isset($this->sb) ? $this->sb->name : "") . '-' . $this->side;
    }

    /**
     * @return string
     */
    public function getAccessionIndividualNumberAttribute()
    {
        return '['. $this->accession_number .'] - '. $this->individual_number;
    }

    /**
     * helper function to get the opposite side for any given Specimen
     * This works only if the current SE is either "Left" or "Right".
     *
     * @return string or null
     */
    public function getOppositeSide()
    {
        if ($this->side === 'Left') {
            return 'Right';
        }
        if ($this->side === 'Right') {
            return 'Left';
        }
        return null;
    }

    /**
     * Get all of the comments for the skeletalelement.
     */
    public function comments()
    {
        return $this->morphMany('App\Comment', 'commentable');
    }

    /**
     * Get all of the tags for the skeletalelement.
     */
    public function tags()
    {
        return $this->morphToMany('App\Tag', 'taggable');
    }

    /**
     * Get a List of tag ids associated with the skeletalelement.
     *
     * @return array
     */
    public function getTagListAttribute()
    {
        return $this->tags->pluck('id')->all();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function skeletalbone()
    {
        return $this->belongsTo('App\SkeletalBone', 'sb_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function bone()
    {
        return $this->skeletalbone();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function sb()
    {
        return $this->skeletalbone();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
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
    public function org()
    {
        return $this->belongsTo('App\Org', 'org_id');
    }

    /**
     * Get the instruments that this specimen has.
     */
    public function instruments()
    {
        return $this->belongsToMany('App\Instrument', 'se_instrument_user', 'se_id', 'instrument_id')
            ->withPivot('user_id', 'instrument_id', 'org_id', 'project_id', 'type', 'created_by', 'updated_by')
            ->withTimestamps();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function reviewer()
    {
        return $this->belongsTo('App\User', 'reviewer_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function reviewedBy()
    {
        return $this->reviewer();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function inventoriedBy()
    {
        return $this->belongsTo('App\User', 'inventoried_by_id');
    }

    /**
     * @param $value
     * @return string|null
     */
    public function getInventoriedAtAttribute($value)
    {
        return ($value != "") ? Carbon::parse($value)->format('Y-m-d') : null;
    }

    /**
     * @param $value
     * @return string|null
     */
    public function getReviewedAtAttribute($value)
    {
        return ($value != "") ? Carbon::parse($value)->format('Y-m-d') : null;
    }

    /**
     * @param null $date
     */
    public function setInventoriedAtAttribute($date = null)
    {
        $this->attributes['inventoried_at'] = !empty($date) ? Carbon::createFromFormat('Y-m-d', $date) : $date;
//
//        if ($this->inventoried) {
//            if ($this->original['inventoried']) {
//                $this->attributes['inventoried_at'] = $this->original['inventoried_at'];
//            } else {
//                $this->attributes['inventoried_at'] = ($date != "") ? Carbon::createFromFormat('Y-m-d', $date) : null;
//            }
//        } else {
//            $this->attributes['inventoried_at'] = null;
//        }
    }

    /**
     * @param null $date
     */
    public function setReviewedAtAttribute($date = null)
    {
        $this->attributes['reviewed_at'] = !empty($date) ? Carbon::createFromFormat('Y-m-d', $date) : $date;
    }

    // Associations
    /**
     * Get all of the dental_codes that are assigned this skeletalelement.
     */
    public function dental_codes()
    {
        return $this->belongsToMany('App\DentalCode', 'se_dental_code', 'se_id', 'dc_id')
            ->withPivot('se_id', 'dc_id', 'sb_id', 'type', 'created_by', 'updated_by')
            ->withTimestamps();
    }

    /**
     * Get all of the taphonomies that are assigned this skeletalelement.
     */
    public function taphonomys()
    {
        return $this->belongsToMany('App\Taphonomy', 'se_taphonomy', 'se_id', 'taphonomy_id')
            ->withPivot('se_id', 'taphonomy_id', 'created_by', 'updated_by')
            ->withTimestamps();
    }

    /**
     * Get a List of taphonomy ids associated with the skeletalelement.
     *
     * @return array
     */
    public function getTaphonomyListAttribute()
    {
        return $this->taphonomys->pluck('id')->all();
    }

    /**
     * Returns true if the Specimen has any associations for
     * pair-match, articulation refit or morphology
     * @return bool
     */
    public function hasAssociations()
    {
        return ($this->pairs->count() || $this->articulations->count() ||
                $this->refits->count() || $this->morphologys->count()) ? true : false;
    }

    /**
     * Returns true if the Specimen has any associations for pair-match
     * @return bool
     */
    public function hasPairs()
    {
        return ($this->pairs->count()) ? true : false;
    }

    /**
     * Returns true if the Specimen has any associations for articulation
     * @return bool
     */
    public function hasArticulations()
    {
        return ($this->articulations->count()) ? true : false;
    }

    /**
     * Returns true if the Specimen has any associations for refit
     * @return bool
     */
    public function hasRefits()
    {
        return ($this->refits->count()) ? true : false;
    }

    /**
     * Returns true if the Specimen has any associations for morphologys
     * @return bool
     */
    public function hasMorphologys()
    {
        return ($this->morphologys->count()) ? true : false;
    }

    public function getAssociationLinks($associationtype = 'all')
    {
        $linktext = " ";
        if ($associationtype == 'pair' || $associationtype == 'all') {
            $linktext = $linktext . $this->pairs->count() . "P" . " ";
        }
        if ($associationtype == 'articulation' || $associationtype == 'all') {
            $linktext = $linktext .  $this->articulations->count() . "A" . " ";
        }
        if ($associationtype == 'refit' || $associationtype == 'all') {
            $linktext = $linktext .  $this->refits->count() . "R". " ";
        }
        if ($associationtype == 'morphology' || $associationtype == 'all') {
            $linktext = $linktext .  $this->morphologys->count() . "M". " ";
        }
        return trim($linktext);
    }

    /**
     * Get all of the se (pairs) that are assigned this skeletalelement.
     */
    public function pairs()
    {
        return $this->belongsToMany('App\SkeletalElement', 'se_pair', 'pair_id', 'se_id')
            ->withoutGlobalScope(ProjectScope::class)
            ->withPivot('se_id', 'pair_id', 'org_id', 'project_id', 'created_by', 'updated_by',
                'compare_method', 'compare_method_settings', 'measurements_used', 'num_measurements', 'sample_size',
                'pvalue', 'mean', 'sd', 'elimination_reason', 'elimination_date')
            ->withTimestamps();
    }

    /**
     * Get all of the se pair1 that are assigned this skeletalelement.
     */
    public function pairs1()
    {
        return $this->belongsToMany('App\SkeletalElement', 'se_pair', 'se_id', 'pair_id')
            ->withoutGlobalScope(ProjectScope::class)
            ->withPivot('se_id', 'pair_id', 'org_id', 'project_id', 'created_by', 'updated_by',
                'compare_method', 'compare_method_settings', 'measurements_used', 'num_measurements', 'sample_size',
                'pvalue', 'mean', 'sd', 'elimination_reason', 'elimination_date')
            ->withTimestamps();
    }

    /**
     * Get all of the se pair2 that are assigned this skeletalelement.
     */
    public function pairs2()
    {
        return $this->belongsToMany('App\SkeletalElement', 'se_pair', 'pair_id', 'se_id')
            ->withoutGlobalScope(ProjectScope::class)
            ->withPivot('se_id', 'pair_id', 'org_id', 'project_id', 'created_by', 'updated_by',
                'compare_method', 'compare_method_settings', 'measurements_used', 'num_measurements', 'sample_size',
                'pvalue', 'mean', 'sd', 'elimination_reason', 'elimination_date')
            ->withTimestamps();
    }

    /**
     * Get all of the se pairs that are assigned this skeletalelement.
     * This will return the merged collection (pairs1 and pairs2)
     * @return mixed
     */
    public function getAllPairsAttribute()
    {
        // There two calls return collections as defined in relations.
        $p1 = $this->pairs1;
        $p2 = $this->pairs2;

        // Merge collections and return single collection.
        return $p1->merge($p2);
    }

    /**
     * Get a List of pair ids associated with the skeletalelement.
     *
     * @return array
     */
    public function getPairListAttribute()
    {
        return $this->allpairs->pluck('id')->all();
    }

    /**
     * Get a list of pair ids without an elimination reason.
     *
     * @return array
     */
    public function getPotentialPairListAttribute()
    {
        $potential_pairs = array();
        foreach($this->allpairs as $pair)
        {
            if($pair->pivot->elimination_reason == null){
                $potential_pairs[] = $pair->id;
            }
        }
        return $potential_pairs;
    }

    /**
     * This method returns all possible pair matches for a Specimen
     * e.g. if specimen is left humerus, then only right humeri
     * will be returned.
     * @return mixed
     */
    public function getAllPossiblePairMatches()
    {

        $opp_side = ($this->side == 'Left') ? 'Right' : 'Left';
        return SkeletalElement::where('sb_id', $this->sb_id)->where('side', $opp_side)->get();
    }

    /**
     * This method returns all possible articulations for a Specimen
     * e.g. if specimen is left humerus, then only left/unsided
     * ulna, radius and scapula will be returned.
     * @return |null
     */
    public function getAllPossibleArticulations()
    {
        // Get the SEs filtered by Permissible Articulations for that appropriate Bone type
        $sb = $this->skeletalbone()->first();
        $sb_articluations = $sb->articulations;
        $articluations_list = null;
        if ($sb_articluations->count()) {
            $query = SkeletalElement::whereIn("sb_id", $sb_articluations->pluck('id'))
                ->where("side", "!=", $this->getOppositeSide())   // not opposite side
                ->where("id", "!=", $this->id);   // not the same se (for bones that can articulate to themselves such as unseriated cervical vertebra)
            $articluations_list = $query->latest()->get();
        }
        return $articluations_list;
    }

    /**
     * This method returns all possible refits for a Specimen, as well as
     * Specimens that are incomplete and of the same skeletal_bone
     * e.g. if specimen is left humerus, then all humeri that
     * are incomplete and all specimens that have the
     * skeletal_bone flag as true will be returned.
     * @return mixed
     */
    public function getAllPossibleRefits()
    {
        // Get the SEs filtered by Permissible Refits, or same SB and are Incomplete
        $sb_list = SkeletalBone::where('refit' ,'=' , true)->orWhere('id', $this->sb_id)->pluck('id')->toArray();
        return SkeletalElement::whereIn('sb_id', $sb_list)->where('completeness', '=', 'Incomplete')->get();
    }

    public function getAllPossibleMorphologys()
    {
        // Get the SEs filtered by Permissible Morphologys for that appropriate Bone type
        $sb = $this->skeletalbone()->first();
        $sb_morphologys = $sb->morphologys;
        $morphologys_list = null;
        if ($sb_morphologys->count()) {
            $query = SkeletalElement::whereIn("sb_id", $sb_morphologys->pluck('id'))
                ->where("side", "!=", $this->getOppositeSide())   // not opposite side
                ->where("id", "!=", $this->id);   // not the same se (for bones that can morphology to themselves such as unseriated cervical vertebra)
            $morphologys_list = $query->latest()->get();
        }
        return $morphologys_list;
    }

    public function getAllPossiblePairMatchesList()
    {
        $list = $this->getAllPossiblePairMatches();
        return (isset($list)) ? $list->pluck('key_bone_side', 'id') : null;
    }

    public function getAllPossibleArticulationsList()
    {
        $list = $this->getAllPossibleArticulations();
        return (isset($list)) ? $list->pluck('key_bone_side', 'id') : null;
    }

    public function getAllPossibleRefitsList()
    {
        $list = $this->getAllPossibleRefits();
        return (isset($list)) ? $list->pluck('key_bone_side', 'id') : null;
    }

    public function getAllPossibleMorphologysList()
    {
        $list = $this->getAllPossibleMorphologys();
        return (isset($list)) ? $list->pluck('key_bone_side', 'id') : null;
    }

    /**
     * Get all of the se (articulations) that are assigned this skeletalelement.
     */
    public function articulations()
    {
        return $this->belongsToMany('App\SkeletalElement', 'se_articulation', 'articulation_id', 'se_id')
            ->withoutGlobalScope(ProjectScope::class)
            ->withPivot('se_id', 'articulation_id', 'org_id', 'project_id', 'created_by', 'updated_by',
            'compare_method', 'compare_method_settings', 'measurements_used', 'num_measurements', 'sample_size',
            'pvalue', 'mean', 'sd', 'elimination_reason', 'elimination_date')
            ->withTimestamps();
    }

    /**
     * Get all of the se articulation1 that are assigned this skeletalelement.
     */
    public function articulations1()
    {
        return $this->belongsToMany('App\SkeletalElement', 'se_articulation', 'se_id', 'articulation_id')
            ->withoutGlobalScope(ProjectScope::class)
            ->withPivot('se_id', 'articulation_id', 'org_id', 'project_id', 'created_by', 'updated_by',
                'compare_method', 'compare_method_settings', 'measurements_used', 'num_measurements', 'sample_size',
                'pvalue', 'mean', 'sd', 'elimination_reason', 'elimination_date')
            ->withTimestamps();
    }

    /**
     * Get all of the se articulation2 that are assigned this skeletalelement.
     */
    public function articulations2()
    {
        return $this->belongsToMany('App\SkeletalElement', 'se_articulation', 'articulation_id', 'se_id')
            ->withoutGlobalScope(ProjectScope::class)
            ->withPivot('se_id', 'articulation_id', 'org_id', 'project_id', 'created_by', 'updated_by',
                'compare_method', 'compare_method_settings', 'measurements_used', 'num_measurements', 'sample_size',
                'pvalue', 'mean', 'sd', 'elimination_reason', 'elimination_date')
            ->withTimestamps();
    }

    /**
     * Get all of the se articulations that are assigned this skeletalelement.
     * This will return the merged collection (articulation1 and articulation2)
     * @return mixed
     */
    public function getAllArticulationsAttribute()
    {
        // There two calls return collections as defined in relations.
        $a1 = $this->articulations1;
        $a2 = $this->articulations2;

        // Merge collections and return single collection.
        return $a1->merge($a2);
    }

    /**
     * Get a List of articulation ids associated with the skeletalelement.
     *
     * @return array
     */
    public function getArticulationListAttribute()
    {
        return $this->allarticulations->pluck('id')->all();
    }

    /**
     * Get all of the se (refits) that are assigned this skeletalelement.
     */
    public function refits()
    {
        return $this->belongsToMany('App\SkeletalElement', 'se_refit', 'refit_id', 'se_id')
            ->withoutGlobalScope(ProjectScope::class)
            ->withPivot('se_id', 'refit_id', 'org_id', 'project_id', 'created_by', 'updated_by')
            ->withTimestamps();
    }

    /**
     * Get all of the se refits1 that are assigned this skeletalelement.
     */
    public function refits1()
    {
        return $this->belongsToMany('App\SkeletalElement', 'se_refit', 'se_id', 'refit_id')
            ->withoutGlobalScope(ProjectScope::class)
            ->withPivot('se_id', 'refit_id', 'org_id', 'project_id', 'created_by', 'updated_by')
            ->withTimestamps();
    }

    /**
     * Get all of the se refits2 that are assigned this skeletalelement.
     */
    public function refits2()
    {
        return $this->belongsToMany('App\SkeletalElement', 'se_refit', 'refit_id', 'se_id')
            ->withoutGlobalScope(ProjectScope::class)
            ->withPivot('se_id', 'refit_id', 'org_id', 'project_id', 'created_by', 'updated_by')
            ->withTimestamps();
    }

    /**
     * Get all of the se refits that are assigned this skeletalelement.
     * This will return the merged collection (refits1 and refits2)
     * @return mixed
     */
    public function getAllRefitsAttribute()
    {
        // There two calls return collections as defined in relations.
        $r1 = $this->refits1;
        $r2 = $this->refits2;

        // Merge collections and return single collection.
        return $r1->merge($r2);
    }

    /**
     * Get a List of refit ids associated with the skeletalelement.
     *
     * @return array
     */
    public function getRefitListAttribute()
    {
        return $this->allrefits->pluck('id')->all();
    }

    /**
     * Get all of the se (morphologys) that are assigned this skeletalelement.
     */
    public function morphologys()
    {
        return $this->belongsToMany('App\SkeletalElement', 'se_morphology', 'morphology_id', 'se_id')
            ->withoutGlobalScope(ProjectScope::class)
            ->withPivot('se_id', 'morphology_id', 'org_id', 'project_id', 'created_by', 'updated_by')
            ->withTimestamps();
    }

    /**
     * Get all of the se morphologys1 that are assigned this skeletalelement.
     */
    public function morphologys1()
    {
        return $this->belongsToMany('App\SkeletalElement', 'se_morphology', 'se_id', 'morphology_id')
            ->withoutGlobalScope(ProjectScope::class)
            ->withPivot('se_id', 'morphology_id', 'org_id', 'project_id', 'created_by', 'updated_by')
            ->withTimestamps();
    }

    /**
     * Get all of the se morphologys2 that are assigned this skeletalelement.
     */
    public function morphologys2()
    {
        return $this->belongsToMany('App\SkeletalElement', 'se_morphology', 'morphology_id', 'se_id')
            ->withoutGlobalScope(ProjectScope::class)
            ->withPivot('se_id', 'morphology_id', 'org_id', 'project_id', 'created_by', 'updated_by')
            ->withTimestamps();
    }

    /**
     * Get all of the se morphologys that are assigned this skeletalelement.
     * This will return the merged collection (morphologys1 and morphologys2)
     * @return mixed
     */
    public function getAllMorphologysAttribute()
    {
        // There two calls return collections as defined in relations.
        $r1 = $this->morphologys1;
        $r2 = $this->morphologys2;

        // Merge collections and return single collection.
        return $r1->merge($r2);
    }

    /**
     * Get a List of morphology ids associated with the skeletalelement.
     *
     * @return array
     */
    public function getMorphologyListAttribute()
    {
        return $this->allmorphologys->pluck('id')->all();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function measurements()
    {
        return $this->belongsToMany('App\Measurement', 'se_measurement', 'se_id', 'measurement_id')
            ->withPivot('se_id', 'measurement_id', 'measure', 'created_by', 'updated_by')
            ->withTimestamps();
    }

    /**
     * This will return the measurement object/model for a given measurement_id
     * @param $measurement_id
     * @return mixed
     */
    public function getMeasurement($measurement_id) {
        return $this->measurements()->where('measurement_id', $measurement_id)->get()->first();
    }

    /**
     * This will return the measurement value for a given measurement_id
     * @param $measurement_id
     * @return mixed
     */
    public function getMeasure($measurement_id) {
        $measurement = $this->getMeasurement($measurement_id);
        return (isset($measurement)) ? $measurement->pivot->measure : "";
    }

    /**
     * This will return the measurement value for a given measurement name
     * Or return '' if the measurement name is empty.
     * @param $measurementName
     * @return string
     */
    public function getMeasureByName($measurementName)
    {
        $measurement = $this->measurements()->where('name', $measurementName)->get()->first();
        return (isset($measurement)) ? $measurement->pivot->measure : "";
    }

    public function associateMeasurements($arr_measurements)
    {
        $arr_measurements = $this->removeElementWithValue($arr_measurements, "measure", "");
        $this->measurements()->sync($this->populateCreateFieldsOrgProjectFieldsForSyncWithData($arr_measurements,"measure", $this));

        // Update the measured flag on the specimen (true/false)
        $this->fill(['measured' => (count($arr_measurements) > 0)])->save();
    }

    public function associateZones($arr_zones)
    {
        $arr_zones = $this->removeElementWithValue($arr_zones, "presence", "");
        $this->zones()->sync($this->populateCreateFieldsOrgProjectFieldsForSyncWithData($arr_zones,"presence", $this, 'boolean'));

//        // Update the measured flag on the specimen (true/false)
//        $this->fill(['measured' => (count($arr_zones) > 0)])->save();
    }

    public function associatePathologys($pathology_id, $arr_data)
    {
        foreach($arr_data as $data)
        {
            $pathology = $this->pathologys()->wherePivot('zone_id', $data['zone_id'])
                ->wherePivot('pathology_id', $pathology_id)->get()->first();
            $basePathology = Pathology::find($pathology_id);
            if ($pathology == null) { // Create a new pathology
                $syncData[$pathology_id] = [ 'zone_id' => $data['zone_id'], 'additional_information' => $data['additional_information'],
                    'abnormality_category' => $basePathology->abnormality_category, 'characteristics' => $basePathology->characteristics,
                    'org_id' => $this->org_id, 'project_id' => $this->project_id,
                    'created_by' => Auth::user()->name, 'updated_by' => Auth::user()->name ];

                $this->pathologys()->attach($syncData);
            } else { // Update existing pathology
                DB::table('se_pathology')->where('se_id', $this->id)->where('zone_id', $data['zone_id'])->where('pathology_id', $pathology_id)
                    ->update(['additional_information' => $data['additional_information'],
                        'abnormality_category' => $basePathology->abnormality_category, 'characteristics' => $basePathology->characteristics,
                        'updated_by' => Auth::user()->name]);
            }
        }
    }

    public function associateDentalCodes($arr_data)
    {
        $syncData = [];
        foreach($arr_data as $data)
        {
            $syncData[$data['dc_id']] = [ 'dc_id' => $data['dc_id'], 'type' => $data['dc_type'],
                'org_id' => $this->org_id, 'project_id' => $this->project_id, 'sb_id' => $this->sb_id,
                'created_by' => Auth::user()->name, 'updated_by' => Auth::user()->name ];
        }
        $this->dental_codes()->sync($syncData);
    }

    public function associateTraumas($trauma_id, $arr_data)
    {
        foreach($arr_data as $data)
        {
            $traumas = $this->traumas()->wherePivot('zone_id', $data['zone_id'])
                ->wherePivot('trauma_id', $trauma_id)->get()->first();
            if ($traumas == null) { // Create a new trauma
                $syncData[$trauma_id] = [ 'zone_id' => $data['zone_id'], 'additional_information' => $data['additional_information'],
                    'org_id' => $this->org_id, 'project_id' => $this->project_id,
                    'created_by' => Auth::user()->name, 'updated_by' => Auth::user()->name ];

                $this->traumas()->attach($syncData);
            } else { // Update existing trauma
                DB::table('se_trauma')->where('se_id', $this->id)->where('zone_id', $data['zone_id'])->where('trauma_id', $trauma_id)
                    ->update(['additional_information' => $data['additional_information'], 'updated_by' => Auth::user()->name]);
            }
        }
    }

    public function associateMethodFeatures($arr_data)
    {
        // First remove features with no score values, if any
        $arr_data = $this->removeElementWithValue($arr_data, "score", "");

        $syncData = [];
        foreach($arr_data as $data)
        {
            $syncData[$data['id']] = [ 'method_id' => $data['method_id'], 'score' => $data['score'],
                'org_id' => $this->org_id, 'project_id' => $this->project_id,
                'created_by' => Auth::user()->name, 'updated_by' => Auth::user()->name ];
        }
        // We need to calculate composite score if necessary.
        $this->methodfeatures()->syncWithoutDetaching($syncData);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function zones()
    {
        return $this->belongsToMany('App\Zone', 'se_zone', 'se_id', 'zone_id')
            ->withPivot('se_id', 'zone_id', 'presence', 'created_by', 'updated_by')
            ->withTimestamps();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function getZonesPresent()
    {
        return $this->belongsToMany('App\Zone', 'se_zone', 'se_id', 'zone_id')
            ->where('presence', '=', true)
            ->withPivot('se_id', 'zone_id', 'presence', 'created_by', 'updated_by')
            ->withTimestamps();
    }

    /**
     * This will return the zone object/model for a given zone_id
     * @param $zone_id
     * @return mixed
     */
    public function getZone($zone_id) {
        return $this->zones()->where('zone_id', $zone_id)->get()->first();
    }

    /**
     * This will return a list of the names of the zones that are present
     * @return mixed
     */
    public function getZoneListAttribute() {
        $zones = $this->zones()->orderBy('display_order')->pluck('display_name')->all();
        $zoneList = "";
        foreach($zones as $zone)
        {
            $zoneList = $zoneList . $zone . ", ";
        }
        return substr($zoneList, 0, -2);
    }

    /**
     * This will return the presence of a zone (boolean) for a given zone_id
     * @param $zone_id
     * @return bool
     */
    public function getPresence($zone_id) {
        $zone = $this->getZone($zone_id);
        if( $zone != null ) {
            return $zone->pivot->presence;
        } elseif( $this->completeness == 'Complete') {
            return true;
        } else {
            return false;
        }
    }

    /**
     * This method will automatically set the zones for the given Specimen based on the completeness.
     * This should be called when the specimen is created or updated.
     *
     * @param $request
     * @return bool
     */
    protected function associateZonesOnCompletenessChange($request)
    {
        $this->logInfo(__METHOD__, $this->id.":".$this->key);
        if ($this->completeness === "Complete")
        {
            try {
                $sb = SkeletalBone::find($this->sb_id);
                $zones = $sb->zones()->get();
                $arr_zones = [];
                foreach($zones as $zone) {
                    $arr_zones[$zone->id]['id'] = $zone->id;
                    $arr_zones[$zone->id]['presence'] = true;
                }
                $this->zones()->sync($this->populateCreateFieldsOrgProjectFieldsForSyncWithData($arr_zones,"presence", $this, 'boolean'));
                $this->logInfo(__METHOD__, "Complete Successful ".$this->id.":".$this->key);
                return true;
            } catch (QueryException $ex) {
                $this->logQueryException(__METHOD__, $request, $ex);
            }
        } else {
            try {
                $sb = SkeletalBone::find($this->sb_id);
                $zones = $sb->zones()->get();
                $arr_zones = [];
                foreach($zones as $zone) {
                    $arr_zones[$zone->id]['id'] = $zone->id;
                    $arr_zones[$zone->id]['presence'] = false;
                }
                $this->zones()->sync([]);
                $this->logInfo(__METHOD__, "Not Complete Successful ".$this->id.":".$this->key);
                return true;
            } catch (QueryException $ex) {
                $this->logQueryException(__METHOD__, $request, $ex);
            }
        }
        return false;
    }

    public function populateCreateFieldsOrgProjectFieldsForSyncWithData($arr_data, $field, $model, $type = 'string')
    {
        $syncData = [];
        foreach($arr_data as $data)
        {
            if (Auth::check())
            {
                if ($type == 'boolean') {
                    $syncData[$data['id']] = [ $field => true, 'org_id' => $model->org_id, 'project_id' => $model->project_id,
                        'created_by' => Auth::user()->name, 'updated_by' => Auth::user()->name ];
                } else { // assume string - default
                    $syncData[$data['id']] = [ $field => $data[$field], 'org_id' => $model->org_id, 'project_id' => $model->project_id,
                        'created_by' => Auth::user()->name, 'updated_by' => Auth::user()->name ];
                }
            }
        }
        return $syncData;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function methods()
    {
        return $this->belongsToMany('App\Method', 'se_method', 'se_id', 'method_id')
            ->withPivot('se_id', 'method_id', 'created_by', 'updated_by')
            ->withTimestamps();
    }

    /**
     * This will return the method object/model for a given method_id
     * @param $method_id
     * @return mixed
     */
    public function methodsById($method_id) {
        return $this->methods()->where('method_id', $method_id)->get()->first();
    }

    /**
     * This will return the method object/models for a given method_type
     * @param $type
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function methodsByType($type)
    {
        return $this->methods()->where('type', $type)->orderBy('name')->get();
    }

    /**
     * This will return the all available method object/models for a given method_type for that bone (sb_id)
     * @param $type
     * @return mixed
     */
    public function methodsAvailableByType($type)
    {
        $allmethodsfortype = Method::where('sb_id', $this->sb_id)->where('type', $type)->orderBy('name')->get();
        $methods = $this->methodsByType($type);
        return $diff = $allmethodsfortype->diff($methods);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function methodfeatures()
    {
        return $this->belongsToMany('App\MethodFeature', 'se_method_feature', 'se_id', 'method_feature_id')
            ->withPivot('se_id', 'method_id', 'method_feature_id', 'score', 'created_by', 'updated_by')
            ->withTimestamps();
    }

    /**
     * This will return the methodfeature object/model for a given feature_id
     * @param $feature_id
     * @return mixed
     */
    public function methodfeaturesById($feature_id) {
        return $this->methodfeatures()->where('se_method_feature.method_feature_id', $feature_id)->get()->first();
    }

    /**
     * This will return the all methodfeatures object/model for a given method_id
     * @param $method_id
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function methodfeaturesByMethod($method_id) {
        return $this->methodfeatures()->where('se_method_feature.method_id', $method_id)->get();
    }

    ///////////////////////////////////
    /// Specimen DNA related methods
    ///////////////////////////////////

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function dnas()
    {
        return $this->hasMany('App\Dna', 'se_id');
    }

    /**
     * This will return the consolidated DNA information for the Specimen.
     * It is also called as Consensus DNA. It combines the information
     * from all DNA samples records to provide a holistic view.
     * @return mixed
     */
    public function getConsensusDnaAttribute()
    {
        // First get the dnas by oldest dna information and then override with newer information
        $first = Dna::where('se_id', $this->id)->orderBy('created_at', 'ASC')->first();
        $c1 = $first->replicate();
        foreach ($this->dnas as $dna) {
            foreach ($dna->toArray() as $key => $value) {
                if ($value != null) {
                    $c1[$key] = $value;
                } else {
                    if ($first[$key] != null && (Auth::user()->getProfileValue("consensus_dna_use_old") == false)) {
                        $c1[$key] = null;
                    }
                }
            }
            return $c1;
        }
    }

    /**
     * This returns an array of all the dna sample numbers for this Specimen.
     * @return array
     */
    public function getDnaSampleNumbersAttribute()
    {
        $dnasamplenumlist = [];
        foreach ($this->dnas as $dna) {
            array_add($dnasamplenumlist, $dna->sample_number);
        }

        return $dnasamplenumlist;
    }

    /**
     * This returns the mito sequence number for this specimen
     * @return |null
     */
    public function getMitoSequenceNumberAttribute()
    {
        $mitoseqnum = null;
        foreach ($this->dnas as $dna) {
            $mitoseqnum = $dna->mito_sequence_number;

            // We will find the first dna record that has a mito sequence number associated with it.
            // Note if there are multiple dna records that have mito sequence numbers, they must all be the same mito seq number.
            // Otherwise it is a data integrity issue.
            // ToDo: Possible Data integrity issue, Probably should throw an exception or prevent that scenario for happening
            if (isset($mitoseqnum)) {
                break;
            }
        }
        return $mitoseqnum;
    }

    public function dnaanalysis()
    {
        return $this->hasMany('App\DnaAnalysis', 'se_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function isotopes()
    {
        return $this->hasMany('App\Isotope', 'se_id');
    }

    /**
     * This returns an array of all the isotope sample numbers for this Specimen.
     * @return array
     */
    public function getIsotopeSampleNumbersAttribute()
    {
        $list = [];
        foreach ($this->isotopes as $isotope) {
            array_add($list, $isotope->sample_number);
        }

        return $list;
    }

    /**
     * Get all of the anomalies that are assigned this skeletalelement.
     */
    public function anomalys()
    {
        return $this->belongsToMany('App\Anomaly', 'se_anomaly', 'se_id', 'anomaly_id')
            ->withPivot('se_id', 'anomaly_id', 'created_by', 'updated_by')
            ->withTimestamps();
    }

    /**
     * Get a List of anomaly ids associated with the skeletalelement.
     *
     * @return array
     */
    public function getAnomalyListAttribute()
    {
        return $this->anomalys->pluck('id')->all();
    }

    /**
     * @return bool|string
     */
    public function getUniqueAnomalysListAttribute()
    {
        $anomalyList = "";
        foreach ( $this->anomalys as $anomaly)
        {
            $anomalyList = $anomalyList . $anomaly->individuating_trait . ", ";
        }
        return substr($anomalyList, 0, -2);
    }

    /**
     * Get all of the anomalies that are assigned this skeletalelement.
     */
    public function traumas()
    {
        return $this->belongsToMany('App\Trauma', 'se_trauma', 'se_id', 'trauma_id')
            ->withPivot('id', 'se_id', 'zone_id', 'trauma_id', 'additional_information', 'created_by', 'updated_by')
            ->withTimestamps();
    }

    /**
     * @return bool|string
     */
    public function getUniqueTraumasListAttribute()
    {
        $traumaList = "";
        foreach ( $this->traumas->unique() as $trauma)
        {
            $traumaList = $traumaList . $trauma->name . ", ";
        }
        return substr($traumaList, 0, -2);
    }

    /**
     * This method takes a trauma id and returns a string with the zones that this trauma
     * affects, if this SE does not have this trauma it will return an empty string, if the
     * trauma is not associated with any zones, it will return "N/A"
     *
     * @param $trauma_id
     * @return array|bool|\Illuminate\Contracts\Translation\Translator|null|string
     */
    public function traumasByZonesList($trauma_id)
    {
        if ( $this->traumas()->where('trauma_id', $trauma_id)->count() == 0) {
            return "";
        }
        $zones = $this->traumas()->where('trauma_id', $trauma_id)->pluck('zone_id', 'zone_id');
        $zoneList = "";
        foreach ($zones as $zone_id) {
            if( $zone_id != null) {
                $zone = Zone::where('id', $zone_id)->first();
                if ( $zone != null) {
                    $zoneList = $zoneList . $zone->display_name . ", ";
                }
            }
        }
        if ( $zoneList == "") {
            return trans('labels.n/a');
        }
        return substr($zoneList, 0,-2);
    }

    /**
     * Get all of the anomalies that are assigned this skeletalelement.
     */
    public function pathologys()
    {
        return $this->belongsToMany('App\Pathology', 'se_pathology', 'se_id', 'pathology_id')
            ->withPivot('id', 'se_id', 'zone_id', 'pathology_id', 'additional_information', 'created_by', 'updated_by')
            ->withTimestamps();
    }

    /**
     * @return bool|string
     */
    public function getUniquePathologysListAttribute()
    {
        $pathologyList = "";
        foreach ( $this->pathologys->unique() as $pathology)
        {
            $pathologyList = $pathologyList . $pathology->name . ", ";
        }
        return substr($pathologyList, 0, -2);
    }

    public function pathologysByZonesList($pathology_id)
    {
        if ( $this->pathologys()->where('pathology_id', $pathology_id)->count() == 0) {
            return "";
        }
        $zones = $this->pathologys()->where('pathology_id', $pathology_id)->pluck('zone_id', 'zone_id');
        $zoneList = "";
        foreach ($zones as $zone_id) {
            if( $zone_id != null) {
                $zone = Zone::where('id', $zone_id)->first();
                if ( $zone != null) {
                    $zoneList = $zoneList . $zone->display_name . ", ";
                }
            }
        }
        if ( $zoneList == "") {
            return trans('labels.n/a');
        }
        return substr($zoneList, 0,-2);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function reviews()
    {
        return $this->hasMany('App\SkeletalElementReview', 'se_id');
    }

    /**
     * Gets the most recent skeletal_element_reviews by type
     *
     * @param string $type
     * @return SkeletalElementReview
     */
    public function reviewByType($type)
    {
        return $this->reviews()->where('skeletal_element_reviews.type', $type)->orderBy('skeletal_element_reviews.id', 'desc')->first();
    }

    /**
     * This returns the list of column names for the table associated with this model (Specimens/SkeletalElements).
     * @return array
     */
    public function getTableColumns()
    {
        $tableColumns = $this->getConnection()->getSchemaBuilder()->getColumnListing($this->getTable());
        return $tableColumns;
    }

    /**
     * Returns true if the specimen's bone name matches $name.
     * @param $name
     * @return bool
     */
    public function isBone($name)
    {
        return ($this->bone->name === $name);
    }

    /**
     * Returns true if the specimen is a Clavicle bone.
     * @return bool
     */
    public function isClavicle()
    {
        return $this->isBone("Clavicle");
    }

    ///////////////////////////////////
    /// SKELETAL ELEMENTS QUERY SCOPES
    ///////////////////////////////////
    /**
     * Scope a query to only include skeletalelements which have the provided accession number.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param mixed $org
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeAN($query, $an)
    {
        return $query->where('accession_number', '=', $an);
    }

    /**
     * Scope a query to only include skeletalelements which have the provided consolidated accession number.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param mixed $org
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeConsolidatedAN($query, $c_an)
    {
        return $query->where('consolidated_an', '=', $c_an);
    }

    /**
     * Scope a query to only include skeletalelements which have the provided individual number.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param mixed $org
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeIndividualNumber($query, $ind_num)
    {
        return $query->where('individual_number', '=', $ind_num);
    }

    /**
     * Scope a query to only include skeletalelements that are complete.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param mixed $org
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeComplete($query)
    {
        return $query->where('completeness', '=', 'Complete');
    }

    /**
     * Scope a query to only include skeletalelements that are measured.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param mixed $org
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeMeasured($query)
    {
        return $query->where('measured', '=', true);
    }

    /**
     * Scope a query to only include skeletalelements that are dna sampled.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param mixed $org
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeDNASampled($query)
    {
        return $query->where('dna_sampled', '=', true);
    }

    /**
     * Scope a query to only include skeletalelements that are clavicle triaged.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param mixed $org
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeClavicleTriaged($query)
    {
        return $query->where('clavicle_triaged', '=', true);
    }

    /**
     * Scope a query to only include skeletalelements that have a specific bone name.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param mixed $org
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeBoneName($query, $name)
    {
        $sb = SkeletalBone::where('name', $name)->first();
        return $query->where('sb_id', '=', $sb->id);
    }

    /**
     * Scope a query to only include skeletalelements that have a specific bone name.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param mixed $org
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeBoneNameSide($query, $name, $side)
    {
        $sb = SkeletalBone::where('name', $name)->first();
        return $query->where('sb_id', '=', $sb->id)->where('side', '=', $side);
    }

    /**
     * Scope a query to only include skeletalelements that have been inventoried.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param mixed $org
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeInventoried($query)
    {
        return $query->where('inventoried', '=', true);
    }

    /**
     * Scope a query to only include skeletalelements that have been reviewed.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param mixed $org
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeReviewed($query)
    {
        return $query->where('reviewed', '=', true);
    }

    ////////////////////////////////////////
    // Specimen Date Attribute fields
    ////////////////////////////////////////

    public function setIdentificationDateAttribute($date)
    {
        $this->attributes['identification_date'] = ($date != "") ? Carbon::parse($date) : null;
    }

    public function getIdentificationDateAttribute($value)
    {
        return ($value != "") ? Carbon::parse($value)->format('Y-m-d') : null;
    }

    public function setRemainsReleaseDateAttribute($date)
    {
        $this->attributes['remains_release_date'] = ($date != "") ? Carbon::parse($date) : null;
    }

    public function getRemainsReleaseDateAttribute($value)
    {
        return ($value != "") ? Carbon::parse($value)->format('Y-m-d') : null;
    }
}
