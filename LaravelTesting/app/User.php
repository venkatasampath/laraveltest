<?php

/**
 * User Model
 *
 * @category   User
 * @package    Models
 * @author     Sachin Pawaskar<spawaskar@unomaha.edu>
 * @copyright  2016-2018
 * @license    The MIT License (MIT)
 * @version    GIT: $Id$
 * @since      File available since Release 1.0.0
 */

namespace App;

use App\Http\Traits\ProfilesTrait;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Log;
use OwenIt\Auditing\Contracts\Auditable;
use Session;


/**
 * Class User
 * @package App
 * @author  Sachin Pawaskar<spawaskar@unomaha.edu>
 * @since   File available since Release 1.0.0
 */
class User extends \TCG\Voyager\Models\User implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use Notifiable;
    use SoftDeletes;
    use ProfilesTrait;

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at', 'last_login_at', 'expiration_at', 'password_updated_at'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [ 'uuid', 'org_id', 'role_id', 'name', 'first_name', 'last_name', 'display_name', 'email', 'password', 'active',
        'avatar', 'phone', 'cell_phone', 'slack_channel', 'default_language', 'default_country', 'default_timezone',
        'last_login_ip_address', 'last_login_device', 'number_of_logins', 'last_login_at', 'expiration_at', 'password_updated_at',
        'created_by', 'updated_by',
    ];

    protected $table = 'users';

    /**
     * The "booting" method of the model.
     *
     * @return void
     */
//    protected static function boot()
//    {
//        parent::boot();
//        static::addGlobalScope(new OrgScope);
//    }

    // Wizard related
    public $wizard = array('mode' => 'false', 'displaytabs' => 'false', 'modal' => 'true', 'heading' => 'Welcome to SPawaskar Wizard');
    public $wizardHelp = array('mode' => 'false', 'displaytabs' => 'true', 'modal' => 'false', 'heading' => 'Application Help Wizard');
    public $wizardTabs = array('Eula' => ['name' => 'Eula', 'active' => true], 'Welcome' => ['name' => 'Welcome', 'active' => false]);
    public $wizardHelpTabs = array('Eula' => ['name' => 'Eula', 'active' => true], 'Welcome' => ['name' => 'Welcome', 'active' => false]);
    public $wizardStartup = array('mode' => 'false', 'displaytabs' => 'false', 'modal' => 'true', 'heading' => 'Application Help Wizard');
    public $wizardStartupTabs = array('Eula' => ['name' => 'Eula', 'active' => true], 'Welcome' => ['name' => 'Welcome', 'active' => false]);
    public $showStartupWizard = false;

    // Eula related
    public $eulaProcessing = false;
    public $eulaAccepted = false;
    public static $eulaActiveSystemList = [];
    public $userAcceptedEula = null;

    // Misc
    public $passwordChangeRequested = false;

    // Project related
    public $currentProject = null;

    // helper logOrgUserProject string used for logging
    public $logOrgUserProject = null;

    /**
     * This is where we initialize the User properties, flags and session related information
     * such as $wizardXXX related, setting of flag such as eulaProcessing, setting of
     * current project for user and profiles.
     */
    public function initialize()
    {
        Log::info(__METHOD__." - ".$this->name);
//        $this->buildWizardHelp();
//        $this->buildWizardStartup();
        $this->getCurrentProject();
        session(['user' => $this, 'org' => $this->org, 'currentProject' => $this->currentProject]);
    }

    /**
     * Get a List of roles ids associated with the current user.
     *
     * @return array
     */
    public function getRoleListAttribute()
    {
        return $this->roles->pluck('id')->all();
    }

    /**
     * Get Accessor method for email attribute to convert to lowercase.
     * This is in case we have emails that have mixed case in the DB.
     *
     * @param $value
     * @return string
     */
    public function getEmailAttribute($value)
    {
        return strtolower($value);
    }

    /**
     * Set Mutator for email attribute to convert to lowercase.
     * This will store all emails to the DB in lowercase.
     *
     * @param $value
     * @return string
     */
    public function setEmailAttribute($value)
    {
        $this->attributes['email'] = strtolower($value);
    }

    /**
     * Get the last user activity in days, meaning the number of days since user last logged in.
     *
     * @return string
     */
    public function getDaysSinceLastActivityAttribute()
    {
        return isset($this->last_login_at) ? Carbon::parse($this->last_login_at)->diffInDays(Carbon::now()) : 0;
    }

    /**
     * Return true if the User has an Administration Role, false otherwise
     *
     * @return bool
     */
    public function isAdmin()
    {
        return $this->hasRole('admin');
    }

    public function isOrgAdmin()
    {
        return $this->hasRole('orgadmin');
    }

    public function isAdminOrOrgAdmin()
    {
        return $this->isAdmin() || $this->isOrgAdmin();
    }

    public function isManager()
    {
        return $this->hasRole('manager');
    }

    /**
     * If a project instance is passed, this function will return true if the user is the project manager for it.
     * Else this function will return true if the user is a project manager on any project that they are on.
     *
     * @param null $project
     * @return bool
     */
    public function isProjectManager($project = null)
    {
        if (isset($project)) {
            if ($project->manager->id === $this->id) {
                return true;
            }
        } else {
            // This will return true if the user is a project manager on any project that they are on.
            $projects = $this->projects;
            foreach ($projects as $p) {
                if ($p->manager->id === $this->id) {
                    return true;
                }
            }
        }
        return false;
    }

    /**
     * Return true if the User has an Administration Role, false otherwise
     *
     * @return bool
     */
    public function isAdministrator()
    {
        return $this->isAdmin();
    }

    /**
     * Return true if the User is Active, false otherwise
     *
     * @return mixed
     */
    public function isActive()
    {
        return $this->active;
    }

    /**
     * Get the password security for this user.
     */
    public function passwordSecurity()
    {
        return $this->hasOne('App\PasswordSecurity');
    }

    /**
     * Get the password histories for this user.
     */
    public function passwordHistories()
    {
        return $this->hasMany('App\PasswordHistory')->orderByDesc('created_at');
    }

    /**
     * Scope a query to only include users of a given org.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param mixed $org
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeForOrg($query, $org)
    {
        return $query->where('org_id', $org->id);
    }

    /**
     * Get the org that this user belongs to.
     */
    public function org()
    {
        return $this->belongsTo('App\Org', 'org_id');
    }

    /**
     * Get the instruments that this user has.
     */
    public function instruments()
    {
        return $this->belongsToMany('App\Instrument', 'instrument_user', 'user_id', 'instrument_id')
            ->withPivot('user_id', 'instrument_id', 'created_by', 'updated_by')
            ->withTimestamps();
    }

    /**
     * Get all of the skeletalelements that are assigned to this user.
     */
    public function skeletalelements()
    {
        return $this->HasMany('App\SkeletalElement', 'user_id');
    }
    /**
     * Get all of the dnas that are assigned to this user.
     */
    public function dnas()
    {
        return $this->HasMany('App\Dna', 'user_id');
    }
    /**
     * Get all of the isotopes that are assigned this project.
     */
    public function isotopes()
    {
        return $this->HasMany('App\Isotope', 'user_id');
    }
    /**
     * Get the project that this user belongs to.
     */
    public function projects()
    {
        if ($this->isOrgAdmin() || $this->isAdministrator()) {
            return $this->org->projects();
        } else {
            return $this->belongsToMany('App\Project', 'project_user', 'user_id', 'project_id')
                ->withPivot('user_id', 'project_id', 'default', 'created_by', 'updated_by')
                ->withTimestamps();
        }
    }

    /**
     * Get the currentProject for this user.
     *
     * Note that the currentProject gets set during initialize and
     * anytime the switchProject method is called
     */
    public function currentProject()
    {
        return $this->currentProject;
    }

    public function getProjectDetailsArray()
    {
        $projects=$this->projects;
        $projectDetailsArray = array();
        foreach ($projects as $project) {
            $projectDetailsArray[] = array(
                'latitude' => $project->geo_lat,
                'longitude' => $project->geo_long,
                'project_name' => $project->name,
                'project_manager' => $project->manager->name,
                'project_description' => $project->description,
                'project_status' => $project->status->display_name,
                'project_id' => $project->id,
            );
        }
        return collect($projectDetailsArray);
    }

    public function getProjectSummaryArraySE()
    {
        $projects=$this->projects;
        $projectSummaryArray = array();
        foreach ($projects as $project) {
            $projectSummary = $project->latest_se_summary_record();
            $projectSummary["projectName"]=$project->getAcronymNameAttribute();
            $projectSummary["link"]=$project->id;
            $projectSummaryArray[] = $projectSummary;
        }
        $projectSummaryArray = collect($projectSummaryArray);
        return $projectSummaryArray;
    }

    public function getProjectSummaryArrayDNA()
    {
        $projects=$this->projects;
        $projectSummaryArray = array();
        foreach ($projects as $project) {
            $projectSummary = $project->latest_dna_summary_record();
            $projectSummary["projectName"]=$project->getAcronymNameAttribute();
            $projectSummary["link"]=$project->id;
            $projectSummaryArray[] = $projectSummary;
        }
         $projectSummaryArray = collect($projectSummaryArray);
        return $projectSummaryArray;
    }

    public function getUserNotifications()
    {
        return $this->notifications;
    }

    public function getUnreadNotificationCount()
    {
        return sizeof($this->unreadNotifications);
    }

    public function getUnreadNotifications()
    {
        return $this->unreadNotifications;
    }

    /**
     * Get the defaultProject that this user belongs to.
     */
    public function defaultProject()
    {
        return $this->belongsToMany('App\Project', 'project_user', 'user_id', 'project_id')
            ->where('default', '=', true)
            ->withPivot('user_id', 'project_id', 'default', 'created_by', 'updated_by')
            ->withTimestamps();
    }

    /**
     * Get a List of project ids associated with the current user.
     *
     * @return array
     */
    public function getProjectListAttribute()
    {
        return $this->projects->pluck('id')->all();
    }

    /**
     *Get a list of the instrument ids associated with the user
     *
     * @return array
     */
    public function getInstrumentListAttribute()
    {
        return $this->instruments()->pluck('id')->all();
    }

    public function getLastLoginAtAttribute($value)
    {
        return ($value != "") ? Carbon::parse($value)->format('Y-m-d h:i:s A') : null;
    }

    /**
     * Get a default project associated with the current user. if one is not
     * set this method will set the default project to the first project
     * in the project_user list if one exists
     *
     * @return object
     */
    public function getCurrentProject()
    {
        $defaultProjectID = $this->getProfileValue('default_project');
        $defaultProject = $this->projects->find($defaultProjectID);
        if (!isset($defaultProject)) {
            $defaultProject = $this->projects->first();
            if (isset($defaultProject)) {
                $this->setProfile('default_project', $defaultProject->id);
                Log::info(__METHOD__." - No Default Project available in project_user, but able to set new default project to [".$defaultProject->name."]");
            } else {
                // This condition should not occur. Org Admin is supposed to assign atleast one project after creation of user.
                Log::info(__METHOD__." - No Default Project available in project_user, and NONE available. [Org:" . $this->org->nane ."]");
            }
        }

        if (isset($defaultProject->name)) {
            $this->logOrgUserProject = "[" . $this->org->acronym . ":" . $this->name . ":" . $defaultProject->name . "]";
        } else {
            $this->logOrgUserProject = "[" . $this->org->acronym . ":" . $this->name . ":" . " No Default Project available in project_user, and NONE available.]";
        }
        session(['user' => $this, 'currentProject' => $this->currentProject]);
        return ($this->currentProject = $defaultProject);
    }

    /**
     * This method will switch the project for the current user to the $to project
     * @param Project $from
     * @param Project $to
     * @return Project|null
     */
    public function switchProject(Project $from, Project $to)
    {
        if ($this->org->id != $to->org->id) {
            return null;
        }

        // First check if you are the orgAdmin for the $to project
        if ($this->isOrgAdmin() ) {
            $this->setProfile("default_project", $to->id);
            $this->initialize();
            return $to;
        } else {
            // if you are anyone other than orgAdmin for the $to project
            $project = $this->projects->find($to->id);
            if (isset($project)) {
                $this->setProfile("default_project", $to->id);
                $this->initialize();
                return $to;
            }
        }

        return null;
    }

    /**
     * Get the helper string logOrgUserProject used for logging
     */
    public function getLogOrgUserProject()
    {
        return $this->logOrgUserProject;
    }

    /**
     * Get all of the profiles that belong to this user.
     */
    public function profiles()
    {
        return $this->morphToMany('App\Profile', 'profileable')
            ->withPivot('profileable_id', 'profileable_type', 'profile_id', 'value', 'json_values', 'created_by', 'updated_by')
            ->withTimestamps();
    }

    /**
     * Get all of the eulas for this user.
     */
    public function eulas()
    {
        return $this->belongsToMany('App\Eula', 'eula_user', 'user_id', 'eula_id')
            ->withPivot('user_id', 'eula_id', 'signature', 'accepted_at', 'created_by', 'updated_by')
            ->withTimestamps();
    }

    /**
     * Get the latest accepted eula for this user.
     */
    public function getActiveEula()
    {
        return $this->eulas()->orderBy('pivot_accepted_at', 'desc')->get()->first();
    }

    /**
     * The checkEula function sets the eulaProcessing and eulaAccepted flags for this user.
     * This function is called to check if Eula processing is required for this user
     * once the user logs into the system.
     * @return bool
     */
    public function checkEula()
    {
        if (!isset($this->org)) {
            $this->eulaProcessing = false;
            return;
        }

        if ($this->org->getProfileValue('eula_processing')) {
            $this->eulaProcessing = true;
            $orgEula = $this->org->getActiveEulaForUser($this);
            $currentlyAcceptedEula = $this->getActiveEula();

            if (!isset($currentlyAcceptedEula) || !isset($orgEula)) {
    //            dd(['true',$orgEula, $currentlyAcceptedEula, $this]);
                return ($this->eulaAccepted = false);
            } else if ($orgEula->id != $currentlyAcceptedEula->id) {
                return ($this->eulaAccepted = false);
            } else {
                return ($this->eulaAccepted = true);
            }
        } else {
            $this->eulaProcessing = false;
        }
    }

    /**
     * check if wizard should be displayed on startup
     */
    public function buildWizardStartup() {
        $modal = 'true';
        $this->wizardStartup = $this->wizardStartupTabs = [];

        $this->checkEula(); // sets the eulaProcessing && eulaAccepted flags

        // First check to see if we need to display EULA
        if ($this->eulaProcessing && !$this->eulaAccepted) {
            if ($this->org->getActiveEulaForUser($this) != null) {
                $this->wizardStartupTabs = array_merge($this->wizardStartupTabs,
                    array('Eula' => ['key' => 'Eula', 'name' => trans('labels.eula'), 'src' => '\eula']));
            }
        }
        count($this->wizardStartupTabs) ? $modal = 'true' : $modal = 'false'; // which mean we have Eula tab
        $startTab = (count($this->wizardStartupTabs) == 1) ? 'Eula' : ''; // which mean we have Eula tab

        // Second check to see if we need to display Change Password
        if ($this->passwordChangeRequested) {
            $this->wizardStartupTabs = array_merge($this->wizardStartupTabs,
                array('ChangePassword' => ['key' => 'ChangePassword', 'name' => trans('labels.change_password'), 'src' => '\passwordChangeOnLogin']));
            if (empty($startTab)) { $startTab = 'ChangePassword'; }
        }

        if ($this->getProfileValue('welcome_screen_on_startup'))
        {
            $this->wizardStartupTabs = array_merge($this->wizardStartupTabs,
                array('Welcome' => ['key' => 'Welcome', 'name' => trans('labels.welcome'), 'src' => $this->org->getProfileValue('welcome_screen_url')]));
            if (empty($startTab)) { $startTab = 'Welcome'; }
        }

        if (count($this->wizardStartupTabs)) {
            $this->wizardStartup = array('wizardType'=>'Startup', 'mode'=>'false', 'displaytabs'=>'false',
                'startTab'=>$startTab, 'modal'=>$modal, 'heading'=>trans('messages.welcome_user', ['name'=>$this->name]));
        }
        $this->showStartupWizard = count($this->wizardStartupTabs) ? true:false;

        Log::info(__METHOD__.' - wizardStartupTabs='.json_encode($this->wizardStartupTabs));
        Log::info(__METHOD__.' - wizardStartup='.json_encode($this->wizardStartup));
        return count($this->wizardStartupTabs);
    }

    /**
     * check if wizard should be displayed on startup
     */
    public function buildWizardHelp() {
        $this->wizardHelp = $this->wizardHelpTabs = [];

        $this->wizardHelpTabs = array_merge($this->wizardHelpTabs, array('About' => ['key' => 'About', 'name' => trans('labels.about'), 'src' => '\about']));
        $this->wizardHelpTabs = array_merge($this->wizardHelpTabs, array('AboutBrowser' => ['key' => 'AboutBrowser', 'name' => trans('labels.aboutbrowser'), 'src' => '\aboutbrowser']));
        $this->wizardHelpTabs = array_merge($this->wizardHelpTabs, array('Welcome' => ['key' => 'Welcome', 'name' => trans('labels.welcome'), 'src' => $this->org->getProfileValue('welcome_screen_url')]));

        if ($this->eulaProcessing && $this->eulaAccepted) {
            if ($this->org->getActiveEulaForUser($this) != null) {
                $this->wizardHelpTabs = array_merge($this->wizardHelpTabs, array('Eula' => ['key' => 'Eula', 'name' => trans('labels.eula'), 'src' => '\eula']));
            }
        }

        if (count($this->wizardHelpTabs)) {
            $this->wizardHelp = array('wizardType'=>'Help', 'mode'=>'false', 'displaytabs'=>'true',
                'startTab'=>'About', 'modal'=>'false', 'heading'=>config('app.name', 'CoRA') .' - '. trans('labels.help'));
        }
        Log::info(__METHOD__.' - wizardHelpTabs='.json_encode($this->wizardHelpTabs));
        Log::info(__METHOD__.' - wizardHelp='.json_encode($this->wizardHelp));
        return count($this->wizardHelpTabs);
    }

    public function onProfileChange()
    {
        // $this->buildWizardHelp();
        Session::put('user', $this);
    }

    /**
     * Route notifications for the Slack channel.
     *
     * @return string
     */
    public function routeNotificationForSlack()
    {
        return env('SLACK_WEBHOOK', '');
    }

    public function generateSESummary()
    {
        $summary = ['se_total' => 0, 'num_complete' => 0, 'num_measured' => 0, 'num_dna_sampled' => 0, 'num_isotope_sampled' => 0, 'num_ct_scanned' => 0,
            'num_xray_scanned' => 0, 'num_clavicle' => 0, 'num_clavicle_triage' => 0, 'num_inventoried' => 0, 'num_reviewed' => 0,
            'num_individuals' => 0, 'num_unique_individuals' => 0, 'num_consolidated_an' => 0, 'num_count' => 0, 'num_mass' => 0, 'num_bone_group' => 0,
            'num_unique_bone_group' => 0, 'num_remains_status' => 0, 'num_inlab'=>0, 'num_released'=>0, 'num_3D_scanned' => 0, 'num_accessions'=>0, 'num_provenance1'=>0,
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

        $summary['org_id'] = $this->org_id;
        $summary['user_id'] = $this->id;
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
            'num_austr_method'=>0, 'num_austr_request_date'=>0, 'num_austr_received'=>0, 'num_austr_reportable'=>0,
            'num_austr_inconclusive'=>0, 'num_austr_unable_to_assign'=>0,'num_austr_cancelled'=>0, 'num_austr_sequences'=>0,
            'num_austr_subgroup'=>0, 'num_austr_similar'=>0, 'num_austr_match_count'=> 0, 'num_austr_total_count'=>0, 'num_austr_loci'=>0, 'num_austr_mcc_date'=>0,
            'num_ystr_method'=>0, 'num_ystr_request_date'=>0, 'num_ystr_received'=>0, 'num_ystr_reportable'=>0,
            'num_ystr_inconclusive'=>0, 'num_ystr_unable_to_assign'=>0,'num_ystr_cancelled'=>0, 'num_ystr_sequences'=>0,
            'num_ystr_subgroup'=>0, 'num_ystr_similar'=>0, 'num_ystr_match_count'=> 0, 'num_ystr_total_count'=>0, 'num_ystr_loci'=>0, 'num_ystr_mcc_date'=>0,
        ];
        $dnas = $this->dnas;
        $summary['num_dna_samples'] = $dnas->count();
        $summary['num_resampled'] = $dnas->where('resample_indicator', true)->count();
        $summary['num_mito_received'] = $dnas->where('mito_receive_date', '!=', null)->count();
        $summary['num_mito_pending'] = $dnas->where('mito_results_confidence', '=', 'Pending')->count();
        $summary['num_mito_reportable'] = $dnas->where('mito_results_confidence', '=', 'Reportable')->count();
        $summary['num_mito_inconclusive'] = $dnas->where('mito_results_confidence', '=', 'Inconclusive')->count();
        $summary['num_mito_unable_to_assign'] = $dnas->where('mito_results_confidence', '=', 'Unable to Assign')->count();
        $summary['num_mito_cancelled'] = $dnas->where('mito_results_confidence', '=', 'Cancelled')->count();
        $summary['num_mito_sequences'] = $dnas->where('mito_sequence_number', '!=', null)->groupBy('mito_sequence_number')->count();
        //Additional attributes
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

        $summary['user_id'] = $this->id;
        $summary['org_id'] = $this->org_id;
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

        $summary['org_id'] = $this->org_id;
        $summary['user_id'] = $this->id;
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

        $summary['org_id'] = $this->org_id;
        $summary['user_id'] = $this->id;
        return $summary;
    }
}
