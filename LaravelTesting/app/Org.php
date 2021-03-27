<?php

/**
 * Org Model
 *
 * @category   Org
 * @package    Models
 * @author     Sachin Pawaskar<spawaskar@unomaha.edu>
 * @copyright  2016-2018
 * @license    The MIT License (MIT)
 * @version    GIT: $Id$
 * @since      File available since Release 1.0.0
 */

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Http\Traits\ProfilesTrait;

class Org extends Model
{
    use ProfilesTrait;
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
    protected $fillable = ['uuid', 'name', 'address', 'city', 'state', 'zip', 'geo_lat', 'geo_long',
        'description', 'acronym', 'website', 'phone', 'toll_free', 'fax', 'contact_name', 'contact_email',
        'default_language', 'default_country', 'default_timezone', 'active',
        'created_by', 'updated_by',];

    /**
     * Get the full address, which is concatenation of address, city, state and zip fields.
     *
     * @return string
     */
    public function getFullAddressAttribute()
    {
        $full_address = $this->address;
        $full_address .= !empty($this->city) ? ', ' . $this->city : "";
        $full_address .= !empty($this->state) ? ', ' . $this->state : "";
        $full_address .= !empty($this->zip) ? ' ' . $this->zip : "";
        return $full_address;
    }

    /**
     * Get all of the users that are assigned to this org.
     */
    public function users()
    {
        return $this->hasMany('App\User');
    }

    /**
     * Get all of the projects that are assigned to this org.
     */
    public function projects()
    {
        return $this->hasMany('App\Project');
    }

    /**
     * Get all of the eulas that are assigned this org.
     */
    public function eulas()
    {
        return $this->hasMany('App\Eula');
    }

    /**
     * Get all of the profiles that are assigned this org.
     */
    public function profiles()
    {
        return $this->morphToMany('App\Profile', 'profileable')
            ->withPivot('profileable_id', 'profileable_type', 'profile_id', 'value', 'json_values', 'created_by', 'updated_by')
            ->withTimestamps();
    }

    public function getActiveEula($language, $country)
    {
        $eula = $this->eulas()->where(['status' => 'Active', 'language' => $language, 'country' => $country])->first();
        return $eula;
    }

    public function getActiveEulaForUser($user)
    {
        return $this->getActiveEula($user->default_language, $user->default_country);
    }

    public function onProfileChange()
    {
        // Special processing, if any
    }

    public function getSECount()
    {
        $count = 0;
        foreach($this->projects() as $project) {
            $count += $project->skeletalelements->withoutGlobalScopes()->count();
        }
        return $count;
    }

    /**
     * Get all of the users that are assigned to this org.
     */
    public function instruments()
    {
        return $this->hasMany('App\Instrument');
    }

    public function accessions()
    {
        return $this->HasMany('App\Accession', 'org_id');
    }

    /**
     * Get all of the skeletalelements that are assigned to this Org.
     */
    public function skeletalelements()
    {
        return $this->HasMany('App\SkeletalElement', 'org_id');
    }

    /**
     * Get all of the dnas that are assigned this Org.
     */
    public function dnas()
    {
        return $this->HasMany('App\Dna', 'org_id');
    }

    /**
     * Get all of the isotopes that are assigned this Org.
     */
    public function isotopes()
    {
        return $this->HasMany('App\Isotope', 'org_id');
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
        $summary['num_bone_group'] = $this->skeletalelements->where('bone_group', '!=', null)->count();
        $summary['num_unique_bone_group'] = $this->skeletalelements->where('bone_group', '!=', null)->groupBy('bone_group')->count(); //distinct bone group
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


        $summary['org_id'] = $this->id;
        return $summary;
    }

    public function generateDNASummary()
    {
       $summary = ['num_dna_samples'=> 0, 'num_resampled'=>0, 'num_mito_received'=>0, 'num_mito_pending'=>0, 'num_mito_reportable'=>0, 'num_mito_inconclusive'=>0, 'num_mito_unable_to_assign'=>0,
            'num_mito_cancelled'=>0, 'num_mito_sequences'=>0, 'num_mito_subgroup'=>0, 'num_mito_similar'=>0, 'num_mito_haplogroup'=>0, 'num_mito_method_ngs'=> 0,
            'num_mito_method_sanger'=>0, 'num_mito_confirmed_regions'=>0, 'num_mito_base_pairs'=>0, 'num_mito_request_date'=>0, 'num_mito_polymorphisms'=>0, 'num_mito_fasta_sequence'=>0,
            'num_mito_haplosubgroup'=>0, 'num_mito_loci'=>0,'num_mito_mcc_date'=>0, 'num_mito_match_count'=>0, 'num_mito_total_count'=>0, 'num_locus'=>0,
            'num_additional_testing'=>0, 'num_priority'=>0, 'num_priority_date'=>0, 'num_btb_request_date'=>0, 'num_btb_results_date'=>0,
            'num_dispo_stored'=>0, 'num_dispo_consumed'=>0, 'num_dispo_returned'=>0,
            'num_sample_cond_stored'=>0, 'num_sample_cond_consumed'=>0, 'num_sample_cond_returned'=>0, 'num_weight_sample_remaining'=> 0,
            'num_austr_method'=>0, 'num_austr_request_date'=>0, 'num_austr_received'=>0, 'num_austr_received'=>0, 'num_austr_reportable'=>0,
            'num_austr_inconclusive'=>0, 'num_austr_unable_to_assign'=>0,'num_austr_cancelled'=>0, 'num_austr_sequences'=>0,
            'num_austr_subgroup'=>0, 'num_austr_similar'=>0, 'num_austr_match_count'=> 0, 'num_austr_total_count'=>0, 'num_austr_loci'=>0, 'num_austr_mcc_date'=>0,
            'num_ystr_method'=>0, 'num_ystr_request_date'=>0, 'num_ystr_received'=>0, 'num_ystr_received'=>0, 'num_ystr_reportable'=>0,
            'num_ystr_inconclusive'=>0, 'num_ystr_unable_to_assign'=>0,'num_ystr_cancelled'=>0, 'num_ystr_sequences'=>0,
            'num_ystr_subgroup'=>0, 'num_ystr_similar'=>0, 'num_ystr_match_count'=> 0, 'num_ystr_total_count'=>0, 'num_ystr_loci'=>0, 'num_ystr_mcc_date'=>0,
        ];

        $summary['num_dna_samples'] = $this->dnas->count();
        $summary['num_resampled'] = $this->dnas->where('resample_indicator', true)->count();
        $summary['num_mito_received'] = $this->dnas->where('mito_receive_date', '!=', null)->count();
        $summary['num_mito_pending'] = $this->dnas->where('mito_results_confidence', '=', 'Pending')->count();
        $summary['num_mito_reportable'] = $this->dnas->where('mito_results_confidence', '=', 'Reportable')->count();
        $summary['num_mito_inconclusive'] = $this->dnas->where('mito_results_confidence', '=', 'Inconclusive')->count();
        $summary['num_mito_unable_to_assign'] = $this->dnas->where('mito_results_confidence', '=', 'Unable to Assign')->count();
        $summary['num_mito_cancelled'] = $this->dnas->where('mito_results_confidence', '=', 'Cancelled')->count();
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

        $summary['num_austr_method'] = $this->dnas->where('austr_method', '!=', null)->groupBy('austr_method')->count();
        $summary['num_austr_request_date'] = $this->dnas->where('austr_request_date', '!=', null)->count();
        $summary['num_austr_received'] = $this->dnas->where('austr_receive_date', '!=', null)->count();
        $summary['num_austr_reportable'] = $this->dnas->where('austr_results_confidence', '=', 'Reportable')->count();
        $summary['num_austr_inconclusive'] = $this->dnas->where('austr_results_confidence', '=', 'Inconclusive')->count();
        $summary['num_austr_unable_to_assign'] = $this->dnas->where('austr_results_confidence', '=', 'Unable to Assign')->count();
        $summary['num_austr_cancelled'] = $this->dnas->where('austr_results_confidence', '=', 'Cancelled')->count();
        $summary['num_austr_sequences'] = $this->dnas->where('austr_sequence_num', '!=', null)->groupBy('austr_sequence_num')->count();
        $summary['num_austr_subgroup'] = $this->dnas->where('austr_sequence_subgroup', '!=', null)->groupBy('austr_sequence_subgroup')->count();;
        $summary['num_austr_similar'] = $this->dnas->where('austr_sequence_similar', '!=', null)->groupBy('austr_sequence_similar')->count();
        $summary['num_austr_match_count'] = $this->dnas->where('austr_match_count', '=', '!=', null)->count();
        $summary['num_austr_total_count'] = $this->dnas->where('austr_total_count', '!=', null)->count();
        $summary['num_austr_loci'] = $this->dnas->where('austr_num_loci', '!=', null)->groupBy('austr_num_loci')->count();
        $summary['num_austr_mcc_date'] = $this->dnas->where('austr_mcc_date', '!=', null)->count();

        $summary['num_ystr_method'] = $this->dnas->where('ystr_method', '!=', null)->count();
        $summary['num_ystr_request_date'] = $this->dnas->where('ystr_request_date', '!=', null)->count();
        $summary['num_ystr_received'] = $this->dnas->where('ystr_receive_date', '!=', null)->count();
        $summary['num_ystr_reportable'] = $this->dnas->where('ystr_results_confidence', '=', 'Reportable')->count();
        $summary['num_ystr_inconclusive'] = $this->dnas->where('ystr_results_confidence', '=', 'Inconclusive')->count();
        $summary['num_ystr_unable_to_assign'] = $this->dnas->where('ystr_results_confidence', '=', 'Unable to Assign')->count();
        $summary['num_ystr_cancelled'] = $this->dnas->where('ystr_results_confidence', '=', 'Cancelled')->count();
        $summary['num_ystr_sequences'] = $this->dnas->where('ystr_sequence_num', '!=', null)->groupBy('ystr_sequence_num')->count();
        $summary['num_ystr_subgroup'] = $this->dnas->where('ystr_sequence_subgroup', '!=', null)->groupBy('ystr_sequence_subgroup')->count();
        $summary['num_ystr_similar'] = $this->dnas->where('ystr_sequence_similar', '!=', null)->groupBy('ystr_sequence_similar')->count();
        $summary['num_ystr_match_count'] = $this->dnas->where('ystr_match_count', '!=', null)->count();
        $summary['num_ystr_total_count'] = $this->dnas->where('ystr_total_count', '!=', null)->count();
        $summary['num_ystr_loci'] = $this->dnas->where('ystr_num_loci', '!=', '!=', null)->groupBy('ystr_num_loci')->count();
        $summary['num_ystr_mcc_date'] = $this->dnas->where('ystr_mcc_date', '!=', null)->count();

        $summary['org_id'] = $this->id;
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

        $summary['org_id'] = $this->id;
        return $summary;
    }

    public function generateProjectSummary()
    {
        $summary = ['num_project_total'=>0, 'num_closed'=>0, 'num_open'=>0, 'num_wip_inventory'=>0,
                    'num_wip_analytics'=>0, 'num_public'=>0,'num_managers'=>0, 'num_allow_user_accession'=>0,
                    'num_slack_channel'=>0, 'num_uses_isotope_analysis'=>0, 'num_zones_autocomplete'=>0, 'num_latest_mcc_date'=>0,];

        $summary['num_project_total'] = $this->projects->count();
        $summary['num_closed'] = $this->projects->where('status_id', '!=', 4)->count();
        $summary['num_open'] = $this->projects->where('status_id', '!=', 1)->count();
        $summary['num_wip_inventory'] = $this->projects->where('status_id', '!=', 2)->count();
        $summary['num_wip_analytics'] = $this->projects->where('status_id', '!=', 3)->count();
        $summary['num_public'] = $this->projects->where('public', true)->count();
        $summary['num_managers'] = $this->projects->where('manager_id', '!=', null)->groupby('manager_id')->count();
        $summary['num_allow_user_accession'] = $this->projects->where('allow_user_accession_create', true)->count();
        $summary['num_slack_channel'] = $this->projects->where('slack_channel', '!=', null)->count();
        $summary['num_uses_isotope_analysis'] = $this->projects->where('uses_isotope_analysis', '!=', null)->count();
        $summary['num_zones_autocomplete'] = $this->projects->where('zones_autocomplete', true)->count();
        $summary['num_latest_mcc_date'] = $this->projects->where('latest_mcc_date', '!=', null)->count();

        $summary['org_id'] = $this->id;
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

        $summary['org_id'] = $this->id;
        return $summary;
    }
}
