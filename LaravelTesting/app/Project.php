<?php

/**
 * Project Model
 *
 * @category   Project
 * @package    CoRA-Models
 * @author     Sachin Pawaskar<spawaskar@unomaha.edu>
 * @copyright  2016-2019
 * @license    The MIT License (MIT)
 * @version    GIT: $Id$
 * @since      File available since Release 1.0.0
 */

namespace App;

use App\Scopes\OrgScope;
use Carbon\Carbon;
use DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Project
 * @package App
 */
class Project extends Model
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
    protected $table = 'projects';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['uuid', 'org_id', 'name', 'description', 'manager_id', 'status_id', 'public', 'allow_user_accession_create',
        'geo_lat', 'geo_long', 'start_date', 'slack_channel', 'latest_mcc_date', 'created_by', 'updated_by', 'uses_auto_increment_designator'];

    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope(new OrgScope);
    }

    /**
     * @return mixed|string
     */
    public function getAcronymNameAttribute()
    {
        if ($this->acronym == null || $this->acronym == '') {
            return $this->name;
        } else {
            return $this->acronym .'-'. $this->name;
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
     * Get all of the users that are assigned this project.
     */
    public function users()
    {
        return $this->belongsToMany('App\User', 'project_user', 'project_id', 'user_id')
            ->withPivot('user_id', 'project_id', 'default', 'created_by', 'updated_by')
            ->withTimestamps();
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function instruments()
    {
        $collect = collect();
        foreach($this->users as $user) {
            if ($user->instruments->count() > 0) {
                $collect = $collect->merge($user->instruments);
            }
        }
        return $collect;
    }

    /**
     * Get all of the users that have assigned this project as their default project.
     */
    public function userdefault()
    {
        return $this->belongsToMany('App\User', 'project_user', 'project_id', 'user_id')
            ->where('default', '=', true)
            ->withPivot('user_id', 'project_id', 'default', 'created_by', 'updated_by')
            ->withTimestamps();
    }

    /**
     * Get the user who is assigned as the project manager for this project.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function manager()
    {
        return $this->belongsTo('App\User', 'manager_id');
    }

    /**
     * Get a List of user ids associated with the current project.
     *
     * @return array
     */
    public function getUserListAttribute()
    {
        return $this->users->pluck('id')->all();
    }

    public function getInstrumentListAttribute()
    {
        return $this->instruments()->pluck('id')->all();
    }

    /**
     * Get all of the accessions that are assigned this project.
     */
    public function accessions()
    {
        return $this->HasMany('App\Accession', 'project_id');
    }

    /**
     * Get all of the accessions that are assigned this project.
     */
    public function provenance1()
    {
        return $this->HasMany('App\Accession', 'project_id')->where('provenance1', "!=", null)->distinct('provenance1');
    }

    /**
     * Get all of the accessions that are assigned this project.
     */
    public function provenance2()
    {
        return $this->HasMany('App\Accession', 'project_id')->where('provenance2', "!=", null)->distinct('provenance2');
    }

    /**
     * Get all of the accessions that are assigned this project.
     */
    public function listaccessions()
    {
        return $this->accessions()->orderBy('number')->pluck('number', 'number');
    }

    /**
     * Get all of the accessions that are assigned this project.
     */
    public function listprovenance1()
    {
        return $this->provenance1()->orderBy('provenance1')->pluck('provenance1', 'provenance1');
    }

    /**
     * Get all of the accessions that are assigned this project.
     */
    public function listprovenance2()
    {
        return $this->provenance2()->orderBy('provenance2')->pluck('provenance2', 'provenance2');
    }

    /**
     * Get all of the distinct/unique accession numbers that are used in this project via skeletalelements.
     */
    public function getAccessions()
    {
        return $this->skeletalelements()->groupBy('accession_number');
    }

    /**
     * Get all of the distinct/unique accession numbers that are used in this project.
     */
    public function getANList()
    {
        return $this->skeletalelements()->groupBy('accession_number')->pluck('accession_number', 'accession_number');
    }

    /**
     * Get all of the distinct/unique accession numbers that are used in this project.
     */
    public function getUniqueSEField($field)
    {
        return $this->skeletalelements()->groupBy($field);
    }

    /**
     * Get all of the distinct/unique accession numbers that are used in this project.
     */
    public function getUniqueANP1P2()
    {
        $results = DB::table('skeletal_elements')->where('skeletal_elements.org_id', $this->org_id)->where('skeletal_elements.project_id', $this->id)
            ->select('accession_number', 'provenance1', 'provenance2')
            ->groupBy('accession_number', 'provenance1', 'provenance2');

        return $results->get();
    }

    /**
     * Get all of the distinct/unique accession numbers that are used in this project.
     */
    public function getUniqueANP1()
    {
        $results = DB::table('skeletal_elements')->where('skeletal_elements.org_id', $this->org_id)->where('skeletal_elements.project_id', $this->id)
            ->select('provenance1', 'accession_number')
            ->groupBy('provenance1');

        return $results->get();
    }

    /**
     * Get all of the distinct/unique field (e.g. accession_number, provenance1, etc) that are used in this project.
     */
    public function getUniqueSEFieldList($field)
    {
        return $this->skeletalelements()->groupBy($field)->pluck($field, $field);
    }

    /**
     * Get all of the skeletalelements that are assigned to this project.
     */
    public function skeletalelements()
    {
        return $this->HasMany('App\SkeletalElement', 'project_id');
    }

    /**
     * Get all of the skeletalelements that are assigned to this project.
     */
    public function specimens()
    {
        return $this->skeletalelements();
    }

    /**
     * Get all of the dnas that are assigned to this project.
     */
    public function dnas()
    {
        return $this->HasMany('App\Dna', 'project_id');
    }

    /**
     * Get all of the accessions that are assigned this project.
     */
    public function status()
    {
        return $this->belongsTo('App\ProjectStatus', 'status_id');
    }
    /**
     * Get all of the isotopes that are assigned this project.
     */
    public function isotopes()
    {
        return $this->HasMany('App\Isotope', 'project_id');
    }

    /**
     * Get all of the summary records for this project.
     */
    public function summary_records($days=0)
    {
        if ($days==0) {
            return $this->HasMany('App\ProjectSummary', 'project_id')->orderBy('updated_at', 'desc');
        } else {
            $dt = Carbon::now();
            $results = $this->HasMany('App\ProjectSummary', 'project_id')->where('updated_at', ">=", $dt->subDays($days))->orderBy('updated_at', 'asc');
            return $results;
        }
    }

    /**
     * Get all of the summary SE records for this project.
     */
    public function summary_se_records($days=0)
    {
        if ($days==0) {
            return $this->HasMany('App\ProjectSummarySE', 'project_id')->orderBy('updated_at', 'desc');
        } else {
            $dt = Carbon::now();
            $results = $this->HasMany('App\ProjectSummarySE', 'project_id')->where('updated_at', ">=", $dt->subDays($days))->orderBy('updated_at', 'asc');
            return $results;
        }
    }

    /**
     * Get all of the summary DNA records for this project.
     */
    public function summary_dna_records($days=0)
    {
        if ($days==0) {
            return $this->HasMany('App\ProjectSummaryDNA', 'project_id')->orderBy('updated_at', 'desc');
        } else {
            $dt = Carbon::now();
            $results = $this->HasMany('App\ProjectSummaryDNA', 'project_id')->where('updated_at', ">=", $dt->subDays($days))->orderBy('updated_at', 'asc');
            return $results;
        }
    }

    public function array_convert($arrayObject, $column)
    {
        $newArray = array();

        foreach($arrayObject as $o) {
            if ($column== 'mito_sequence_number') {
                $newArray[] = 'Seq '. $o->$column;
            } else if ($column== 'display_name') {
                $newArray[] = $o->name.': '.$o->$column;
            } else if ($column== 'display_name_stacked') {
                $newArray[] = $o->display_name;
            } else if ($column== 'number') {
                $newArray[] = $o->number;
            } else if ($column== 'provenance1') {
                $newArray[] = $o->provenance1;
            } else {
                $newArray[] = $o->$column;
            }
        }
        return collect($newArray);
    }

    public function getStartDateAttribute($value)
    {
        return ($value != "") ? Carbon::parse($value)->format('Y-m-d') : null;
    }

    public function getLatestMCCDateAttribute($value)
    {
        return ($value != "") ? Carbon::parse($value)->format('Y-m-d') : null;
    }

    /**
     * Get the latest summary record for this project.
     */
    public function latest_summary_record()
    {
        return $this->summary_records()->orderBy('updated_at', 'desc')->first();
    }

    /**
     * Get all of the last or latest summary record for this project.
     */
    public function latest_se_summary_record()
    {
        return $this->summary_se_records()->orderBy('updated_at', 'desc')->first();
    }

    public function latest_dna_summary_record()
    {
        return $this->summary_dna_records()->orderBy('updated_at', 'desc')->first();
    }

    public function generateProjectSummary()
    {
        $summary = ['num_accessions'=>0,'num_provenance1'=>0,'num_provenance2'=> 0, 'num_unique_anp1p2'=> 0,
            'num_users'=> 0];

        $summary['num_accessions'] = $this->accessions->count();
        $summary['num_provenance1'] = $this->provenance1->count();
        $summary['num_provenance2'] = $this->provenance2->count();
        $summary['num_unique_anp1p2'] = $this->getUniqueANP1P2()->count();
        $summary['num_users'] = $this->users->count();

        $summary['project_id'] = $this->id;
        $summary['org_id'] = $this->org_id;
        return $summary;
    }

    public function generateSESummary()
    {
        $summary = ['se_total'=>0, 'num_complete'=>0,'num_measured'=>0,'num_dna_sampled'=> 0, 'num_isotope_sampled'=>0, 'num_ct_scanned'=>0,
            'num_xray_scanned'=>0, 'num_clavicle'=>0, 'num_clavicle_triage'=>0, 'num_inventoried'=>0, 'num_reviewed'=> 0,
            'num_individuals'=>0, 'num_unique_individuals'=>0, 'num_consolidated_an'=>0, 'num_count'=>0, 'num_mass'=>0, 'num_bone_group'=>0,
            'num_unique_bone_group'=>0, 'num_remains_status'=>0, 'num_inlab'=>0, 'num_released'=>0, 'num_3D_scanned'=>0, 'num_accessions'=>0, 'num_provenance1'=>0,
            'num_provenance2'=>0, 'num_designator'=>0, 'num_side'=>0];
        $clavicle = SkeletalBone::where('name', 'Clavicle')->first();

        $summary['se_total'] = $this->skeletalelements->count();
        $summary['num_complete'] = $this->skeletalelements->where('completeness', 'Complete')->count();
        $summary['num_measured'] = $this->skeletalelements->where('measured', true)->count();
        $summary['num_dna_sampled'] = $this->skeletalelements->where('dna_sampled', true)->count();
        $summary['num_isotope_sampled'] = $this->skeletalelements->where('isotope_sampled', true)->count();
        $summary['num_ct_scanned'] = $this->skeletalelements->where('ct_scanned', true)->count();
        $summary['num_xray_scanned'] = $this->skeletalelements->where('xray_scanned', true)->count();
        $summary['num_clavicle'] = $this->skeletalelements->where('sb_id', $clavicle->id)->count();
        $summary['num_clavicle_triage'] = $this->skeletalelements->where('clavicle_triage', true)->count();
        $summary['num_inventoried'] = $this->skeletalelements->where('inventoried', true)->count();
        $summary['num_reviewed'] = $this->skeletalelements->where('reviewed', true)->count();
        $summary['num_individuals'] = $this->skeletalelements->where('individual_number', '!=', null)->count();
        $summary['num_unique_individuals'] = $this->skeletalelements->where('individual_number', '!=', null)->groupBy('individual_number')->count();
        //Additional attributes
        $summary['num_consolidated_an'] = $this->skeletalelements->where('consolidated_an', '!=', null)->count();
        $summary['num_count'] = $this->skeletalelements->where('count', '!=', null)->count();
        $summary['num_mass'] = $this->skeletalelements->where('mass', '!=', null)->count();
        $summary['num_bone_group'] = $this->skeletalelements->where('bone_group_id', '!=', null)->count();
        $summary['num_unique_bone_groups'] = $this->skeletalelements->where('bone_group_id', '!=', null)->groupBy('bone_group_id')->count(); //distinct bone group
        $summary['num_remains_status'] = $this->skeletalelements->where('remains_status', '!=', null)->count();
        $summary['num_inlab'] = $this->skeletalelements->where('remains_status', '=', 'In Lab')->count();
        $summary['num_released'] = $this->skeletalelements->where('remains_status', '=', 'Released')->count();
        $summary['num_3D_scanned'] = $this->skeletalelements->where('3D_scanned', true)->count();
        //ToBeConfirmed
        $summary['num_accessions'] = $this->skeletalelements->where('accession_number', '!=', null)->groupBy('accession_number')->count();
        $summary['num_provenance1'] = $this->skeletalelements->where('provenance1', '!=', null)->groupBy('provenance1')->count();
        $summary['num_provenance2'] = $this->skeletalelements->where('provenance2', '!=', null)->groupBy('provenance2')->count();
        $summary['num_designator'] = $this->skeletalelements->where('designator', '!=', null)->groupBy('designator')->count();
        $summary['num_side'] = $this->skeletalelements->where('side', '!=', null)->groupBy('side')->count();

        $summary['project_id'] = $this->id;
        $summary['org_id'] = $this->org_id;
        return $summary;
    }

    public function generateDNASummary()
    {
        $summary = ['num_dna_samples'=> 0, 'num_resampled'=>0, 'num_mito_received'=>0,
            'num_mito_pending'=>0, 'num_mito_reportable'=>0, 'num_mito_inconclusive'=>0, 'num_mito_unable_to_assign'=>0, 'num_mito_cancelled'=>0, 'num_mito_no_results'=>0,
            'num_mito_sequences'=>0, 'num_mito_subgroup'=>0, 'num_mito_similar'=>0, 'num_mito_haplogroup'=>0, 'num_mito_method_ngs'=> 0,
            'num_mito_method_sanger'=>0, 'num_mito_confirmed_regions'=>0, 'num_mito_base_pairs'=>0, 'num_mito_request_date'=>0, 'num_mito_polymorphisms'=>0, 'num_mito_fasta_sequence'=>0,
            'num_mito_haplosubgroup'=>0, 'num_mito_loci'=>0,'num_mito_mcc_date'=>0, 'num_mito_match_count'=>0, 'num_mito_total_count'=>0, 'num_locus'=>0,
            'num_additional_testing'=>0, 'num_priority'=>0, 'num_priority_date'=>0, 'num_btb_request_date'=>0, 'num_btb_results_date'=>0,
            'num_dispo_stored'=>0, 'num_dispo_consumed'=>0, 'num_dispo_returned'=>0,
            'num_sample_cond_stored'=>0, 'num_sample_cond_consumed'=>0, 'num_sample_cond_returned'=>0, 'num_weight_sample_remaining'=> 0,
            'num_austr_method'=>0, 'num_austr_request_date'=>0, 'num_austr_received'=>0,
            'num_austr_pending'=>0, 'num_austr_reportable'=>0, 'num_austr_inconclusive'=>0, 'num_austr_unable_to_assign'=>0,'num_austr_cancelled'=>0, 'num_austr_no_results'=>0,
            'num_austr_sequences'=>0, 'num_austr_subgroup'=>0, 'num_austr_similar'=>0, 'num_austr_match_count'=> 0, 'num_austr_total_count'=>0, 'num_austr_loci'=>0, 'num_austr_mcc_date'=>0,
            'num_ystr_method'=>0, 'num_ystr_request_date'=>0, 'num_ystr_received'=>0,
            'num_ystr_pending'=>0, 'num_ystr_reportable'=>0, 'num_ystr_inconclusive'=>0, 'num_ystr_unable_to_assign'=>0,'num_ystr_cancelled'=>0, 'num_ystr_no_results'=>0,
            'num_ystr_sequences'=>0, 'num_ystr_subgroup'=>0, 'num_ystr_similar'=>0, 'num_ystr_match_count'=> 0, 'num_ystr_total_count'=>0, 'num_ystr_loci'=>0, 'num_ystr_mcc_date'=>0,
            ];

        $summary['num_dna_samples'] = $this->dnas->count();
        $summary['num_resampled'] = $this->dnas->where('resample_indicator', true)->count();
        $summary['num_mito_received'] = $this->dnas->where('mito_receive_date', '!=', null)->count();
        $summary['num_mito_pending'] = $this->dnas->where('mito_results_confidence', '=', 'Pending')->count();
        $summary['num_mito_reportable'] = $this->dnas->where('mito_results_confidence', '=', 'Reportable')->count();
        $summary['num_mito_inconclusive'] = $this->dnas->where('mito_results_confidence', '=', 'Inconclusive')->count();
        $summary['num_mito_unable_to_assign'] = $this->dnas->where('mito_results_confidence', '=', 'Unable to Assign')->count();
        $summary['num_mito_cancelled'] = $this->dnas->where('mito_results_confidence', '=', 'Cancelled')->count();
        $summary['num_mito_no_results'] = $this->dnas->where('mito_results_confidence', '=', 'No Results')->count();
        $summary['num_mito_sequences'] = $this->dnas->where('mito_sequence_number', '!=', null)->groupBy('mito_sequence_number')->count();
        //Additional attributes
        $summary['num_mito_subgroup'] = $this->dnas->where('mito_sequence_subgroup', '!=', null)->groupBy('mito_sequence_subgroup')->count();
        $summary['num_mito_similar'] = $this->dnas->where('mito_sequence_similar', '!=', null)->groupBy('mito_sequence_similar')->count();
        $summary['num_mito_haplogroup'] = $this->dnas->where('mito_haplogroup_id', '!=', null)->groupBy('mito_haplogroup_id')->count();
        $summary['num_mito_method_ngs'] = $this->dnas->where('mito_method', '=', 'NGS')->count();
        $summary['num_mito_method_sanger'] = $this->dnas->where('mito_method', '=', 'Sanger')->count();
        $summary['num_mito_confirmed_regions'] = $this->dnas->where('mito_confirmed_regions', '!=', null)->groupBy('mito_confirmed_regions')->count();
        $summary['num_mito_base_pairs'] = $this->dnas->where('mito_base_pairs', '!=', null)->groupBy('mito_base_pairs')->count();
        $summary['num_mito_request_date'] = $this->dnas->where('mito_request_date', '!=', null)->count();
        $summary['num_mito_polymorphisms'] = $this->dnas->where('mito_polymorphisms', '!=', null)->count();
        $summary['num_mito_fasta_sequence'] = $this->dnas->where('mito_fasta_sequence', '!=', null)->count();
        $summary['num_mito_haplosubgroup'] = $this->dnas->where('mito_haplosubgroup', '!=', null)->groupBy('mito_haplosubgroup')->count();
        $summary['num_mito_loci'] = $this->dnas->where('mito_num_loci', '!=', null)->groupBy('mito_num_loci')->count();
        $summary['num_mito_mcc_date'] = $this->dnas->where('mito_mcc_date', '!=', null)->count();
        $summary['num_mito_match_count'] = $this->dnas->where('mito_match_count', '=', '!=', null)->count();
        $summary['num_mito_total_count'] = $this->dnas->where('mito_total_count', '!=', null)->count();
        $summary['num_locus'] = $this->dnas->where('locus', '!=', null)->count();
        $summary['num_additional_testing'] = $this->dnas->where('additional_testing', true)->count();
        $summary['num_priority'] = $this->dnas->where('priority', '!=', null)->count();
        $summary['num_priority_date'] = $this->dnas->where('priority_date', '!=', null)->count();
        $summary['num_btb_request_date'] = $this->dnas->where('btb_request_date', '!=', null)->count();
        $summary['num_btb_results_date'] = $this->dnas->where('btb_results_date', '!=', null)->count();
        $summary['num_dispo_stored'] = $this->dnas->where('disposition', '=', 'Stored')->count();
        $summary['num_dispo_consumed'] = $this->dnas->where('disposition', '=', 'Consumed')->count();
        $summary['num_dispo_returned'] = $this->dnas->where('disposition', '=', 'Returned')->count();
        $summary['num_sample_cond_stored'] = $this->dnas->where('sample_condition', '=', 'Stored')->count();
        $summary['num_sample_cond_consumed'] = $this->dnas->where('sample_condition', '=', 'Consumed')->count();
        $summary['num_sample_cond_returned'] = $this->dnas->where('sample_condition', '=', 'Returned')->count();
        $summary['num_weight_sample_remaining'] = $this->dnas->where('weight_sample_remaining', '!=', null)->count();
        // Austr
        $summary['num_austr_method'] = $this->dnas->where('austr_method', '!=', null)->groupBy('austr_method')->count();
        $summary['num_austr_request_date'] = $this->dnas->where('austr_request_date', '!=', null)->count();
        $summary['num_austr_received'] = $this->dnas->where('austr_receive_date', '!=', null)->count();
        $summary['num_austr_pending'] = $this->dnas->where('austr_results_confidence', '=', 'Pending')->count();
        $summary['num_austr_reportable'] = $this->dnas->where('austr_results_confidence', '=', 'Reportable')->count();
        $summary['num_austr_inconclusive'] = $this->dnas->where('austr_results_confidence', '=', 'Inconclusive')->count();
        $summary['num_austr_unable_to_assign'] = $this->dnas->where('austr_results_confidence', '=', 'Unable to Assign')->count();
        $summary['num_austr_cancelled'] = $this->dnas->where('austr_results_confidence', '=', 'Cancelled')->count();
        $summary['num_austr_no_results'] = $this->dnas->where('austr_results_confidence', '=', 'No Results')->count();
        $summary['num_austr_sequences'] = $this->dnas->where('austr_sequence_num', '!=', null)->groupBy('austr_sequence_num')->count();
        $summary['num_austr_subgroup'] = $this->dnas->where('austr_sequence_subgroup', '!=', null)->groupBy('austr_sequence_subgroup')->count();;
        $summary['num_austr_similar'] = $this->dnas->where('austr_sequence_similar', '!=', null)->groupBy('austr_sequence_similar')->count();
        $summary['num_austr_match_count'] = $this->dnas->where('austr_match_count', '=', '!=', null)->count();
        $summary['num_austr_total_count'] = $this->dnas->where('austr_total_count', '!=', null)->count();
        $summary['num_austr_loci'] = $this->dnas->where('austr_num_loci', '!=', null)->groupBy('austr_num_loci')->count();
        $summary['num_austr_mcc_date'] = $this->dnas->where('austr_mcc_date', '!=', null)->count();
        // Ystr
        $summary['num_ystr_method'] = $this->dnas->where('ystr_method', '!=', null)->count();
        $summary['num_ystr_request_date'] = $this->dnas->where('ystr_request_date', '!=', null)->count();
        $summary['num_ystr_received'] = $this->dnas->where('ystr_receive_date', '!=', null)->count();
        $summary['num_ystr_pending'] = $this->dnas->where('ystr_results_confidence', '=', 'Pending')->count();
        $summary['num_ystr_reportable'] = $this->dnas->where('ystr_results_confidence', '=', 'Reportable')->count();
        $summary['num_ystr_inconclusive'] = $this->dnas->where('ystr_results_confidence', '=', 'Inconclusive')->count();
        $summary['num_ystr_unable_to_assign'] = $this->dnas->where('ystr_results_confidence', '=', 'Unable to Assign')->count();
        $summary['num_ystr_cancelled'] = $this->dnas->where('ystr_results_confidence', '=', 'Cancelled')->count();
        $summary['num_ystr_no_results'] = $this->dnas->where('ystr_results_confidence', '=', 'No Results')->count();
        $summary['num_ystr_sequences'] = $this->dnas->where('ystr_sequence_num', '!=', null)->groupBy('ystr_sequence_num')->count();
        $summary['num_ystr_subgroup'] = $this->dnas->where('ystr_sequence_subgroup', '!=', null)->groupBy('ystr_sequence_subgroup')->count();
        $summary['num_ystr_similar'] = $this->dnas->where('ystr_sequence_similar', '!=', null)->groupBy('ystr_sequence_similar')->count();
        $summary['num_ystr_match_count'] = $this->dnas->where('ystr_match_count', '!=', null)->count();
        $summary['num_ystr_total_count'] = $this->dnas->where('ystr_total_count', '!=', null)->count();
        $summary['num_ystr_loci'] = $this->dnas->where('ystr_num_loci', '!=', '!=', null)->groupBy('ystr_num_loci')->count();
        $summary['num_ystr_mcc_date'] = $this->dnas->where('ystr_mcc_date', '!=', null)->count();

        $summary['project_id'] = $this->id;
        $summary['org_id'] = $this->org_id;
        return $summary;
    }

    public function generateUserSummary()
    {
        $summary = ['num_user_total'=>0, 'num_active'=>0, 'num_default_language'=>0, 'num_default_country'=>0, 'num_role'=>0, 'num_unique_role'=>0,
            'num_timezone'=>0, 'num_phone'=>0,  'num_avatar'=>0, 'num_last_login_ip_address'=>0, 'num_last_login_device'=>0, 'num_loggedin'=>0,
            'num_slack_channel'=>0, 'num_password_updated'=>0, 'num_user_creator'=>0, 'num_logins'=>0];

        $summary['num_user_total'] = $this->users->count();
        $summary['num_active'] = $this->users->where('active', true)->count();
        $summary['num_default_language'] = $this->users->where('default_language', '!=', null)->groupBy('default_language')->count();
        $summary['num_default_country'] = $this->users->where('default_country', '!=', null)->groupBy('default_country')->count();
        $summary['num_role'] = $this->users->where('role_id', '!=', null)->count();
        $summary['num_unique_role'] = $this->users->where('role_id', '!=', null)->groupBy('role_id')->count();
        $summary['num_timezone'] = $this->users->where('default_timezone', '!=', null)->groupBy('default_timezone')->count();
        $summary['num_phone'] = $this->users->where('phone', '!=', null)->count();
        $summary['num_avatar'] = $this->users->where('avatar', '!=', null)->count();
        $summary['num_last_login_ip_address'] = $this->users->where('last_login_ip_address', '!=', null)->count();
        $summary['num_last_login_device'] = $this->users->where('last_login_device', '!=', null)->count();
        $summary['num_loggedin'] = $this->users->where('number_of_logins', '!=', 0)->count();
        $summary['num_slack_channel'] = $this->users->where('slack_channel', '!=', null)->count();
        $summary['num_password_updated'] = $this->users->where('password_updated_at', '!=', null)->count();
        $summary['num_user_creator'] = $this->users->where('created_by', '!=', null)->groupBy('created_by')->count();
        $summary['num_logins'] = $this->users->sum('number_of_logins');

        $summary['project_id'] = $this->id;
        $summary['org_id'] = $this->org_id;
        return $summary;
    }

    public function generateIsotopeSummary()
    {
        $summary = ['num_isotope_samples'=> 0, 'num_pending'=>0, 'num_reportable'=>0, 'num_inconclusive'=>0,
            'num_unable_to_assign'=>0, 'num_cancelled'=>0, 'num_weight_sample_cleaned'=> 0, 'num_weight_vial_lid'=>0, 'num_weight_sample_vial_lid'=>0, 'num_weight_collagen'=>0,
            'num_yield_collagen'=>0, 'num_demineralizing_start_date'=>0, 'num_demineralizing_end_date'=>0, 'num_analysis_request'=>0,
            'num_well_location'=>0, 'num_collagen_weight_used_for_analysis'=>0,
        ];

        $summary['num_isotope_samples'] = $this->isotopes->count();
        $summary['num_pending'] = $this->isotopes->where('results_confidence', '=', 'Pending')->count();
        $summary['num_reportable'] = $this->isotopes->where('results_confidence', '=', 'Reportable')->count();
        $summary['num_inconclusive'] = $this->isotopes->where('results_confidence', '=', 'Inconclusive')->count();
        $summary['num_unable_to_assign'] = $this->isotopes->where('results_confidence', '=', 'Unable to Assign')->count();
        $summary['num_cancelled'] = $this->isotopes->where('results_confidence', '=', 'Cancelled')->count();
        $summary['num_weight_sample_cleaned'] = $this->isotopes->where('weight_sample_cleaned',  '!=', null)->count();
        $summary['num_weight_vial_lid'] = $this->isotopes->where('weight_vial_lid',  '!=', null)->count();
        $summary['num_weight_sample_vial_lid'] = $this->isotopes->where('weight_sample_vial_lid',   '!=', null)->count();
        $summary['num_yield_collagen'] = $this->isotopes->where('yield_collagen', '!=', null)->count();
        $summary['num_demineralizing_start_date'] = $this->isotopes->where('demineralizing_start_date', '!=', null)->count();
        $summary['num_demineralizing_end_date'] = $this->isotopes->where('demineralizing_end_date', '!=', null)->count();
        $summary['num_analysis_requested'] = $this->isotopes->where('analysis_requested', '!=', null)->count();
        $summary['num_well_location'] = $this->isotopes->where('well_location', '!=', null)->count();
        $summary['num_collagen_weight_used_for_analysis'] = $this->isotopes->where('collagen_weight_used_for_analysis', '!=', null)->count();

        $summary['project_id'] = $this->id;
        $summary['org_id'] = $this->org_id;
        return $summary;
    }

    public function generateDailyWeeklyMonthlyProjectSummary($startDate, $endDate)
    {
        $summary = ['num_new_accessions'=>0,'num_new_provenance1'=>0,'num_new_provenance2'=> 0, 'num_new_unique_anp1p2'=> 0,
            'num_new_users'=> 0, 'num_updated_accessions'=>0,'num_updated_provenance1'=>0,'num_updated_provenance2'=> 0, 'num_updated_unique_anp1p2'=> 0,
            'num_updated_users'=> 0];

        $summary['num_new_accessions'] = $this->accessions->where('created_at', '>=', $startDate)->where('created_at', '<=', $endDate)->count();
        $summary['num_new_provenance1'] = $this->provenance1->where('created_at', '>=', $startDate)->where('created_at', '<=', $endDate)->count();
        $summary['num_new_provenance2'] = $this->provenance2->where('created_at', '>=', $startDate)->where('created_at', '<=', $endDate)->count();
        $summary['num_new_unique_anp1p2'] = $this->getUniqueANP1P2()->where('created_at', '>=', $startDate)->where('created_at', '<=', $endDate)->count();
        $summary['num_new_users'] = $this->users->where('created_at', '>=', $startDate)->where('created_at', '<=', $endDate)->count();
        $summary['num_updated_accessions'] = $this->accessions->where('created_at', '<=', $startDate)->where('updated_at', '>=', $startDate)->where('updated_at', '<=', $endDate)->count();
        $summary['num_updated_provenance1'] = $this->provenance1->where('created_at', '<=', $startDate)->where('updated_at', '>=', $startDate)->where('updated_at', '<=', $endDate)->count();
        $summary['num_updated_provenance2'] = $this->provenance2->where('created_at', '<=', $startDate)->where('updated_at', '>=', $startDate)->where('updated_at', '<=', $endDate)->count();
        $summary['num_updated_unique_anp1p2'] = $this->getUniqueANP1P2()->where('created_at', '<=', $startDate)->where('updated_at', '>=', $startDate)->where('updated_at', '<=', $endDate)->count();
        $summary['num_updated_users'] = $this->users->where('created_at', '<=', $startDate)->where('updated_at', '>=', $startDate)->where('updated_at', '<=', $endDate)->count();

        $summary['project_id'] = $this->id;
        $summary['org_id'] = $this->org_id;
        return $summary;
    }

    public function generateDailyWeeklyMonthlySESummary($startDate, $endDate)
    {
        $summary = ['se_total_new'=>0, 'se_total_updated'=> 0, 'num_complete'=>0,'num_measured'=>0,'num_dna_sampled'=> 0, 'num_isotope_sampled'=>0, 'num_ct_scanned'=>0,
            'num_xray_scanned'=>0, 'num_clavicle'=>0, 'num_clavicle_triage'=>0, 'num_inventoried'=>0, 'num_reviewed'=> 0,
            'num_individuals'=>0, 'num_unique_individuals'=>0, 'num_consolidated_an'=>0, 'num_count'=>0, 'num_mass'=>0, 'num_bone_group'=>0,
            'num_unique_bone_group'=>0, 'num_remains_status'=>0, 'num_inlab'=>0, 'num_released'=>0, 'num_3D_scanned'=>0, 'num_accessions'=>0, 'num_provenance1'=>0,
            'num_provenance2'=>0, 'num_designator'=>0, 'num_side'=>0, 'num_new_articulations'=>0, 'num_new_anomalys'=>0, 'num_new_methods'=>0, 'num_new_method_features'=>0, 'num_new_measurements'=>0,
            'num_new_morphologys'=>0, 'num_new_pairs'=>0, 'num_new_pathologys'=>0, 'num_new_refits'=>0, 'num_new_taphonomys'=>0,
            'num_new_traumas'=>0, 'num_new_zones'=>0,
        ];
        $clavicle = SkeletalBone::where('name', 'Clavicle')->first();

        $summary['se_total_new'] = $this->skeletalelements->where('created_at', '>=', $startDate)->where('created_at', '<=', $endDate)->count();
        $summary['se_total_updated'] = $this->skeletalelements->where('created_at', '<=', $startDate)->where('updated_at', '>=', $startDate)->where('updated_at', '<=', $endDate)->count();
        $se = $this->skeletalelements->where('updated_at', '>=', $startDate)->where('updated_at', '<=', $endDate);
        $summary['num_complete'] = $se->where('completeness', 'Complete')->count();
        $summary['num_measured'] = $se->where('measured', true)->count();
        $summary['num_dna_sampled'] = $se->where('dna_sampled', true)->count();
        $summary['num_isotope_sampled'] = $se->where('isotope_sampled', true)->count();
        $summary['num_ct_scanned'] = $se->where('ct_scanned', true)->count();
        $summary['num_xray_scanned'] = $se->where('xray_scanned', true)->count();
        $summary['num_clavicle'] = $se->where('sb_id', $clavicle->id)->count();
        $summary['num_clavicle_triage'] = $se->where('clavicle_triage', true)->count();
        $summary['num_inventoried'] = $se->where('inventoried', true)->count();
        $summary['num_reviewed'] = $se->where('reviewed', true)->count();
        $summary['num_individuals'] = $se->where('individual_number', '!=', null)->count();
        $summary['num_unique_individuals'] = $se->where('individual_number', '!=', null)->groupBy('individual_number')->count();
        $summary['num_consolidated_an'] = $se->where('consolidated_an', '!=', null)->count();
        $summary['num_count'] = $se->where('count', '!=', null)->count();
        $summary['num_mass'] = $se->where('mass', '!=', null)->count();
        $summary['num_bone_group'] = $se->where('bone_group', '!=', null)->count();
        $summary['num_unique_bone_group'] = $se->where('bone_group', '!=', null)->groupBy('bone_group')->count(); //distinct bone group
        $summary['num_inlab'] = $se->where('remains_status', '=', 'In Lab')->count();
        $summary['num_released'] = $se->where('remains_status', '=', 'Released')->count();
        $summary['num_3D_scanned'] = $se->where('3D_scanned', true)->count();
        $summary['num_accessions'] = $se->where('accession_number', '!=', null)->groupBy('accession_number')->count();
        $summary['num_provenance1'] = $se->where('provenance1', '!=', null)->groupBy('provenance1')->count();
        $summary['num_provenance2'] = $se->where('provenance2', '!=', null)->groupBy('provenance2')->count();
        $summary['num_designator'] = $se->where('designator', '!=', null)->groupBy('designator')->count();
        $summary['num_side'] = $se->where('side', '!=', null)->groupBy('side')->count();

        $summary['project_id'] = $this->id;
        $summary['org_id'] = $this->org_id;
        return $summary;
    }

    public function generateDailyWeeklyMonthlyDNASummary($startDate, $endDate)
    {
        $summary = ['dna_total_new'=> 0, 'dna_total_updated'=> 0, 'num_resampled'=>0, 'num_mito_received'=>0, 'num_mito_pending'=>0, 'num_mito_reportable'=>0, 'num_mito_inconclusive'=>0, 'num_mito_unable_to_assign'=>0,
            'num_mito_cancelled'=>0, 'num_mito_sequences'=>0, 'num_mito_subgroup'=>0, 'num_mito_similar'=>0, 'num_mito_haplogroup'=>0, 'num_mito_method_ngs'=> 0,
            'num_mito_method_sanger'=>0, 'num_mito_confirmed_regions'=>0, 'num_mito_base_pairs'=>0, 'num_mito_request_date'=>0, 'num_mito_polymorphisms'=>0, 'num_mito_fasta_sequence'=>0,
            'num_mito_haplosubgroup'=>0, 'num_mito_loci'=>0,'num_mito_mcc_date'=>0, 'num_mito_match_count'=>0, 'num_mito_total_count'=>0, 'num_locus'=>0,
            'num_additional_testing'=>0, 'num_priority'=>0, 'num_priority_date'=>0, 'num_btb_request_date'=>0, 'num_btb_results_date'=>0,
            'num_dispo_stored'=>0, 'num_dispo_consumed'=>0, 'num_dispo_returned'=>0,
            'num_sample_cond_stored'=>0, 'num_sample_cond_consumed'=>0, 'num_sample_cond_returned'=>0, 'num_weight_sample_remaining'=> 0,
            'num_austr_method'=>0, 'num_austr_request_date'=>0, 'num_austr_received'=>0, 'num_austr_reportable'=>0,
            'num_austr_inconclusive'=>0, 'num_austr_unable_to_assign'=>0,'num_austr_cancelled'=>0, 'num_austr_sequences'=>0,
            'num_austr_subgroup'=>0, 'num_austr_similar'=>0, 'num_austr_match_count'=> 0, 'num_austr_total_count'=>0, 'num_austr_loci'=>0, 'num_austr_mcc_date'=>0,
            'num_ystr_method'=>0, 'num_ystr_request_date'=>0, 'num_ystr_received'=>0, 'num_ystr_reportable'=>0,
            'num_ystr_inconclusive'=>0, 'num_ystr_unable_to_assign'=>0,'num_ystr_cancelled'=>0, 'num_ystr_sequences'=>0,
            'num_ystr_subgroup'=>0, 'num_ystr_similar'=>0, 'num_ystr_match_count'=> 0, 'num_ystr_total_count'=>0, 'num_ystr_loci'=>0, 'num_ystr_mcc_date'=>0,
        ];


        $summary['dna_total_new'] = $this->dnas->where('created_at', '>=', $startDate)->where('created_at', '<=', $endDate)->count();
        $summary['dna_total_updated'] = $this->dnas->where('created_at', '<=', $startDate)->where('updated_at', '>=', $startDate)->where('updated_at', '<=', $endDate)->count();
        $dnas = $this->dnas->where('updated_at', '>=', $startDate)->where('updated_at', '<=', $endDate);
        $summary['num_resampled'] = $dnas->where('resample_indicator', true)->count();
        $summary['num_mito_received'] = $dnas->where('mito_receive_date', '!=', null)->count();
        $summary['num_mito_pending'] = $dnas->where('mito_results_confidence', '=', 'Pending')->count();
        $summary['num_mito_reportable'] = $dnas->where('mito_results_confidence', '=', 'Reportable')->count();
        $summary['num_mito_inconclusive'] = $dnas->where('mito_results_confidence', '=', 'Inconclusive')->count();
        $summary['num_mito_unable_to_assign'] = $dnas->where('mito_results_confidence', '=', 'Unable to Assign')->count();
        $summary['num_mito_cancelled'] = $dnas->where('mito_results_confidence', '=', 'Cancelled')->count();
        $summary['num_mito_sequences'] = $dnas->where('mito_sequence_number', '!=', null)->groupBy('mito_sequence_number')->count();
        $summary['num_mito_subgroup'] = $dnas->where('mito_sequence_subgroup', '!=', null)->groupBy('mito_sequence_subgroup')->count();
        $summary['num_mito_similar'] = $dnas->where('mito_sequence_similar', '!=', null)->groupBy('mito_sequence_similar')->count();
        $summary['num_mito_haplogroup'] = $dnas->where('mito_haplogroup_id', '!=', null)->groupBy('mito_haplogroup_id')->count();
        $summary['num_mito_method_ngs'] = $dnas->where('mito_method', '=', 'NGS')->count();
        $summary['num_mito_method_sanger'] = $dnas->where('mito_method', '=', 'Sanger')->count();
        $summary['num_mito_confirmed_regions'] = $dnas->where('mito_confirmed_regions', '!=', null)->groupBy('mito_confirmed_regions')->count();
        $summary['num_mito_base_pairs'] = $dnas->where('mito_base_pairs', '!=', null)->groupBy('mito_base_pairs')->count();
        $summary['num_mito_request_date'] = $dnas->where('mito_request_date', '!=', null)->count();
        $summary['num_mito_polymorphisms'] = $dnas->where('mito_polymorphisms', '!=', null)->count();
        $summary['num_mito_fasta_sequence'] = $dnas->where('mito_fasta_sequence', '!=', null)->count();
        $summary['num_mito_haplosubgroup'] = $dnas->where('mito_haplosubgroup', '!=', null)->groupBy('mito_haplosubgroup')->count();
        $summary['num_mito_loci'] = $dnas->where('mito_num_loci', '!=', null)->groupBy('mito_num_loci')->count();
        $summary['num_mito_mcc_date'] = $dnas->where('mito_mcc_date', '!=', null)->count();
        $summary['num_mito_match_count'] = $dnas->where('mito_match_count', '=', '!=', null)->count();
        $summary['num_mito_total_count'] = $dnas->where('mito_total_count', '!=', null)->count();
        $summary['num_locus'] = $dnas->where('locus', '!=', null)->count();
        $summary['num_additional_testing'] = $dnas->where('additional_testing', true)->count();
        $summary['num_priority'] = $dnas->where('priority', '!=', null)->count();
        $summary['num_priority_date'] = $dnas->where('priority_date', '!=', null)->count();
        $summary['num_btb_request_date'] = $dnas->where('btb_request_date', '!=', null)->count();
        $summary['num_btb_results_date'] = $dnas->where('btb_results_date', '!=', null)->count();
        $summary['num_dispo_stored'] = $dnas->where('disposition', '=', 'Stored')->count();
        $summary['num_dispo_consumed'] = $dnas->where('disposition', '=', 'Consumed')->count();
        $summary['num_dispo_returned'] = $dnas->where('disposition', '=', 'Returned')->count();
        $summary['num_sample_cond_stored'] = $dnas->where('sample_condition', '=', 'Stored')->count();
        $summary['num_sample_cond_consumed'] = $dnas->where('sample_condition', '=', 'Consumed')->count();
        $summary['num_sample_cond_returned'] = $dnas->where('sample_condition', '=', 'Returned')->count();
        $summary['num_weight_sample_remaining'] = $dnas->where('weight_sample_remaining', '!=', null)->count();

        $summary['num_austr_method'] = $dnas->where('austr_method', '!=', null)->groupBy('austr_method')->count();
        $summary['num_austr_request_date'] = $dnas->where('austr_request_date', '!=', null)->count();
        $summary['num_austr_received'] = $dnas->where('austr_receive_date', '!=', null)->count();
        $summary['num_austr_reportable'] = $dnas->where('austr_results_confidence', '=', 'Reportable')->count();
        $summary['num_austr_inconclusive'] = $dnas->where('austr_results_confidence', '=', 'Inconclusive')->count();
        $summary['num_austr_unable_to_assign'] = $dnas->where('austr_results_confidence', '=', 'Unable to Assign')->count();
        $summary['num_austr_cancelled'] = $dnas->where('austr_results_confidence', '=', 'Cancelled')->count();
        $summary['num_austr_sequences'] = $dnas->where('austr_sequence_num', '!=', null)->groupBy('austr_sequence_num')->count();
        $summary['num_austr_subgroup'] = $dnas->where('austr_sequence_subgroup', '!=', null)->groupBy('austr_sequence_subgroup')->count();;
        $summary['num_austr_similar'] = $dnas->where('austr_sequence_similar', '!=', null)->groupBy('austr_sequence_similar')->count();
        $summary['num_austr_match_count'] = $dnas->where('austr_match_count', '=', '!=', null)->count();
        $summary['num_austr_total_count'] = $dnas->where('austr_total_count', '!=', null)->count();
        $summary['num_austr_loci'] = $dnas->where('austr_num_loci', '!=', null)->groupBy('austr_num_loci')->count();
        $summary['num_austr_mcc_date'] = $dnas->where('austr_mcc_date', '!=', null)->count();

        $summary['num_ystr_method'] = $dnas->where('ystr_method', '!=', null)->count();
        $summary['num_ystr_request_date'] = $dnas->where('ystr_request_date', '!=', null)->count();
        $summary['num_ystr_received'] = $dnas->where('ystr_receive_date', '!=', null)->count();
        $summary['num_ystr_reportable'] = $dnas->where('ystr_results_confidence', '=', 'Reportable')->count();
        $summary['num_ystr_inconclusive'] = $dnas->where('ystr_results_confidence', '=', 'Inconclusive')->count();
        $summary['num_ystr_unable_to_assign'] = $dnas->where('ystr_results_confidence', '=', 'Unable to Assign')->count();
        $summary['num_ystr_cancelled'] = $dnas->where('ystr_results_confidence', '=', 'Cancelled')->count();
        $summary['num_ystr_sequences'] = $dnas->where('ystr_sequence_num', '!=', null)->groupBy('ystr_sequence_num')->count();
        $summary['num_ystr_subgroup'] = $dnas->where('ystr_sequence_subgroup', '!=', null)->groupBy('ystr_sequence_subgroup')->count();
        $summary['num_ystr_similar'] = $dnas->where('ystr_sequence_similar', '!=', null)->groupBy('ystr_sequence_similar')->count();
        $summary['num_ystr_match_count'] = $dnas->where('ystr_match_count', '!=', null)->count();
        $summary['num_ystr_total_count'] = $dnas->where('ystr_total_count', '!=', null)->count();
        $summary['num_ystr_loci'] = $dnas->where('ystr_num_loci', '!=', '!=', null)->groupBy('ystr_num_loci')->count();
        $summary['num_ystr_mcc_date'] = $dnas->where('ystr_mcc_date', '!=', null)->count();

        $summary['project_id'] = $this->id;
        $summary['org_id'] = $this->org_id;
        return $summary;
    }

    public function generateDailyWeeklyMonthlyUserSummary($startDate, $endDate)
    {
        $summary = ['user_total_new'=>0, 'user_total_updated'=>0, 'num_active'=>0, 'num_default_language'=>0, 'num_default_country'=>0, 'num_role'=>0, 'num_unique_role'=>0,
            'num_timezone'=>0, 'num_phone'=>0,  'num_avatar'=>0, 'num_last_login_ip_address'=>0, 'num_last_login_device'=>0, 'num_loggedin'=>0,
            'num_slack_channel'=>0, 'num_password_updated'=>0, 'num_user_creator'=>0, 'num_logins'=>0];

        $summary['user_total_new'] = $this->users->where('created_at', '>=', $startDate)->where('created_at', '<=', $endDate)->count();
        $summary['user_total_updated'] = $this->users->where('created_at', '<=', $startDate)->where('updated_at', '>=', $startDate)->where('updated_at', '<=', $endDate)->count();
        $users = $this->users->where('updated_at', '>=', $startDate)->where('updated_at', '<=', $endDate);
        $summary['num_active'] = $users->where('active', true)->count();
        $summary['num_default_language'] = $users->where('default_language', '!=', null)->groupBy('default_language')->count();
        $summary['num_default_country'] = $users->where('default_country', '!=', null)->groupBy('default_country')->count();
        $summary['num_role'] = $users->where('role_id', '!=', null)->count();
        $summary['num_unique_role'] = $users->where('role_id', '!=', null)->groupBy('role_id')->count();
        $summary['num_timezone'] = $users->where('default_timezone', '!=', null)->groupBy('default_timezone')->count();
        $summary['num_phone'] = $users->where('phone', '!=', null)->count();
        $summary['num_avatar'] = $users->where('avatar', '!=', null)->count();
        $summary['num_last_login_ip_address'] = $users->where('last_login_ip_address', '!=', null)->count();
        $summary['num_loggedin'] = $users->where('number_of_logins', '!=', 0)->count();
        $summary['num_slack_channel'] = $users->where('slack_channel', '!=', null)->count();
        $summary['num_password_updated'] = $users->where('password_updated_at', '!=', null)->count();
        $summary['num_user_creator'] = $users->where('created_by', '!=', null)->groupBy('created_by')->count();

        $summary['project_id'] = $this->id;
        $summary['org_id'] = $this->org_id;
        return $summary;
    }

    public function generateDailyWeeklyMonthlyIsotopeSummary($startDate, $endDate)
    {
        $summary = ['isotope_total_new'=>0, 'isotope_total_updated'=> 0, 'num_pending'=>0, 'num_reportable'=>0, 'num_inconclusive'=>0,
            'num_unable_to_assign'=>0, 'num_cancelled'=>0, 'num_weight_sample_cleaned'=> 0, 'num_weight_vial_lid'=>0, 'num_weight_sample_vial_lid'=>0, 'num_weight_collagen'=>0,
            'num_yield_collagen'=>0, 'num_demineralizing_start_date'=>0, 'num_demineralizing_end_date'=>0, 'num_analysis_request'=>0,
            'num_well_location'=>0, 'num_collagen_weight_used_for_analysis'=>0,
        ];

        $summary['isotope_total_new'] = $this->isotopes->where('created_at', '>=', $startDate)->where('created_at', '<=', $endDate)->count();
        $summary['isotope_total_updated'] = $this->isotopes->where('created_at', '<=', $startDate)->where('updated_at', '>=', $startDate)->where('updated_at', '<=', $endDate)->count();
        $isotopes = $this->isotopes->where('updated_at', '>=', $startDate)->where('updated_at', '<=', $endDate);
        $summary['num_pending'] = $isotopes->where('results_confidence', '=', 'Pending')->count();
        $summary['num_reportable'] = $isotopes->where('results_confidence', '=', 'Reportable')->count();
        $summary['num_inconclusive'] = $isotopes->where('results_confidence', '=', 'Inconclusive')->count();
        $summary['num_unable_to_assign'] = $isotopes->where('results_confidence', '=', 'Unable to Assign')->count();
        $summary['num_cancelled'] = $isotopes->where('results_confidence', '=', 'Cancelled')->count();
        $summary['num_weight_sample_cleaned'] = $isotopes->where('weight_sample_cleaned',  '!=', null)->count();
        $summary['num_weight_vial_lid'] = $isotopes->where('weight_vial_lid',  '!=', null)->count();
        $summary['num_weight_sample_vial_lid'] = $isotopes->where('weight_sample_vial_lid',   '!=', null)->count();
        $summary['num_yield_collagen'] = $isotopes->where('updated_at', '>=', $startDate)->where('updated_at', '<=', $endDate)->where('yield_collagen', '!=', null)->count();
        $summary['num_demineralizing_start_date'] = $isotopes->where('demineralizing_start_date', '!=', null)->count();
        $summary['num_demineralizing_end_date'] = $isotopes->where('demineralizing_end_date', '!=', null)->count();
        $summary['num_analysis_requested'] = $isotopes->where('analysis_requested', '!=', null)->count();
        $summary['num_well_location'] = $isotopes->where('well_location', '!=', null)->count();
        $summary['num_collagen_weight_used_for_analysis'] = $isotopes->where('collagen_weight_used_for_analysis', '!=', null)->count();

        $summary['project_id'] = $this->id;
        $summary['org_id'] = $this->org_id;
        return $summary;
    }

    public function an_by_p1($top = 0)
    {
        $results = DB::table('skeletal_elements')->where('project_id', $this->id)->whereNull('skeletal_elements.deleted_at')
            ->select('accession_number', 'provenance1', DB::raw('count(*) as total'))
            ->groupBy('provenance1', 'accession_number')
            ->orderBy('total', 'desc')
            ->orderBy('provenance1');

//        dd($results->get());
        return ($top == 0) ? $results->get() : $results->take($top)->get();
    }

    public function p1_by_an($top = 0)
    {
        $results = DB::table('skeletal_elements')->where('project_id', $this->id)->whereNull('skeletal_elements.deleted_at')
            ->select('accession_number', 'provenance1', DB::raw('count(*) as total'))
            ->groupBy('accession_number', 'provenance1')
            ->orderBy('total', 'desc')
            ->orderBy('accession_number');

//        dd($results->get());
        return ($top == 0) ? $results->get() : $results->take($top)->get();
    }

    public function mni_by_bones($top = 0)
    {
        $results = DB::table('skeletal_elements')->where('project_id', $this->id)->whereNull('skeletal_elements.deleted_at')
            ->join('skeletal_bones', 'skeletal_elements.sb_id', '=', 'skeletal_bones.id')
            ->select('name', DB::raw('count(*) as total'))
            ->groupBy('name')
            ->orderBy('total', 'desc');

        return ($top == 0) ? $results->get() : $results->take($top)->get();
    }

    public function mni_by_bones_and_side($top = 0)
    {
        $results = DB::table('skeletal_elements')->where('project_id', $this->id)->whereNull('skeletal_elements.deleted_at')
            ->join('skeletal_bones', 'skeletal_elements.sb_id', '=', 'skeletal_bones.id')
            ->select('name', 'side', DB::raw('count(*) as total'))
            ->groupBy('name', 'side')
            ->orderBy('total', 'desc');

        return ($top == 0) ? $results->get() : $results->take($top)->get();
    }

    public function mni_by_zones($top = 0)
    {
        $results = DB::table('se_zone')->where('project_id', $this->id)->where('presence', "=", true)
            ->join('zones', 'se_zone.zone_id', '=', 'zones.id')
            ->join('skeletal_bones', 'zones.sb_id', '=', 'skeletal_bones.id')
            ->select('skeletal_bones.name', 'zones.display_name', DB::raw('count(*) as total'))
            ->groupBy('skeletal_bones.name', 'zones.display_name')
            ->orderBy('total', 'desc');

        return ($top == 0) ? $results->get() : $results->take($top)->get();
    }

    public function mni_by_bones_side_zones($top = 0)
    {
        $results = DB::table('se_zone')->where('se_zone.project_id', $this->id)->where('se_zone.presence', "=", true)
            ->join('zones', 'se_zone.zone_id', '=', 'zones.id')
            ->join('skeletal_bones', 'zones.sb_id', '=', 'skeletal_bones.id')
            ->join('skeletal_elements', 'se_zone.se_id', '=', 'skeletal_elements.id')
            ->select('skeletal_bones.name', 'skeletal_elements.side', 'zones.display_name as zone_display_name', DB::raw('count(*) as total'))
            ->groupBy('skeletal_bones.name', 'skeletal_elements.side', 'zone_display_name')
            ->orderBy('total', 'desc');

        return ($top == 0) ? $results->get() : $results->take($top)->get();
    }

    public function mito_sequences($top = 0)
    {
        $results = DB::table('dnas')->where('project_id', $this->id)->where('mito_sequence_number', "!=", null)->whereNull('deleted_at')
            ->select('mito_sequence_number', DB::raw('count(*) as total'))
            ->groupBy('mito_sequence_number')
            ->orderBy('total', 'desc')
            ->orderBy('mito_sequence_number');

        return ($top == 0) ? $results->get() : $results->take($top)->get();
    }

    public function mni_by_mito_bones_and_side($top = 0)
    {
        $results = DB::table('dnas')->where('dnas.project_id', $this->id)->where('dnas.mito_sequence_number', "!=", null)->whereNull('dnas.deleted_at')
            ->join('skeletal_elements', 'dnas.se_id', '=', 'skeletal_elements.id')
            ->join('skeletal_bones', 'skeletal_elements.sb_id', '=', 'skeletal_bones.id')
            ->select('dnas.mito_sequence_number', 'skeletal_bones.name', 'skeletal_elements.side', DB::raw('count(*) as total'))
            ->groupBy('dnas.mito_sequence_number', 'skeletal_bones.name', 'skeletal_elements.side')
            ->orderBy('total', 'desc')
            ->orderBy('mito_sequence_number');

        return ($top == 0) ? $results->get() : $results->take($top)->get();
    }

    public function se_activities($top = 0)
    {
        $results = DB::table('skeletal_elements')->where('skeletal_elements.project_id', $this->id)->whereNull('skeletal_elements.deleted_at')
            ->join('skeletal_bones', 'skeletal_elements.sb_id', '=', 'skeletal_bones.id')
            ->select('skeletal_elements.*', 'skeletal_bones.name')
            ->orderBy('skeletal_elements.updated_at', 'desc');

        return ($top == 0) ? $results->get() : $results->take($top)->get();
    }

    public function dna_activities($top = 0)
    {
        $results = DB::table('dnas')->where('dnas.project_id', $this->id)
            ->join('skeletal_elements', 'dnas.se_id', '=', 'skeletal_elements.id')->whereNull('dnas.deleted_at')
            ->select('dnas.*', 'skeletal_elements.id', 'skeletal_elements.accession_number', 'skeletal_elements.provenance1',
                'skeletal_elements.provenance2', 'skeletal_elements.designator', 'skeletal_elements.side')
            ->orderBy('dnas.updated_at', 'desc');

        return ($top == 0) ? $results->get() : $results->take($top)->get();
    }

    public function se_activities_by_user($user, $top = 10)
    {
        $results = DB::table('skeletal_elements')->where('skeletal_elements.project_id', $this->id)->where('skeletal_elements.updated_by', "=", $user->name)->whereNull('skeletal_elements.deleted_at')
            ->join('skeletal_bones', 'skeletal_elements.sb_id', '=', 'skeletal_bones.id')
            ->select('skeletal_elements.*', 'skeletal_bones.name')
            ->orderBy('skeletal_elements.updated_at', 'desc');

        return ($top == 0) ? $results->get() : $results->take($top)->get();
    }

    public function dna_activities_by_user($user, $top = 10)
    {
        $results = DB::table('dnas')->where('dnas.project_id', $this->id)->where('dnas.updated_by', "=", $user->name)->whereNull('dnas.deleted_at')
            ->join('skeletal_elements', 'dnas.se_id', '=', 'skeletal_elements.id')
            ->select('dnas.*', 'skeletal_elements.id', 'skeletal_elements.accession_number', 'skeletal_elements.provenance1',
                'skeletal_elements.provenance2', 'skeletal_elements.designator', 'skeletal_elements.side')
            ->orderBy('dnas.updated_at', 'desc');

        return ($top == 0) ? $results->get() : $results->take($top)->get();
    }

    // Dashboard Details Helpers
    public function dashboard_details_dna_sample()
    {
        $results = DB::table('skeletal_elements')->where('skeletal_elements.project_id', $this->id)->where('dna_sampled', true)->whereNull('skeletal_elements.deleted_at')
            ->join('dnas', 'skeletal_elements.id', '=', 'dnas.se_id')
            ->join('skeletal_bones', 'skeletal_elements.sb_id', '=', 'skeletal_bones.id')
            ->select('skeletal_elements.id', 'skeletal_elements.accession_number', 'skeletal_elements.provenance1', 'skeletal_elements.provenance2', 'skeletal_elements.designator', 'skeletal_elements.side', 'skeletal_elements.completeness', 'skeletal_elements.updated_at',
                'skeletal_bones.name', 'dnas.id as dna_id', 'dnas.sample_number', 'dnas.mito_sequence_number', 'dnas.mito_sequence_subgroup', 'dnas.mito_sequence_similar', 'dnas.mito_receive_date', 'dnas.results_confidence')
            ->orderBy('skeletal_elements.updated_at');

        return $results->get();
    }
}
