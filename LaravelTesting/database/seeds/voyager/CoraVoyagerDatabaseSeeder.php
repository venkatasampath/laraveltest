<?php

/**
 * Cora Voyager Database Seeder
 *
 * @category   Cora Voyager Database
 * @package    Seeder
 * @author     Sachin Pawaskar<spawaskar@unomaha.edu>
 * @copyright  2016-2018
 * @license    The MIT License (MIT)
 * @version    GIT: $Id$
 * @since      File available since Release 1.0.0
 */

use Illuminate\Database\Seeder;
use App\Utility\Memory;
use TCG\Voyager\Models\DataType;
use TCG\Voyager\Models\DataRow;
use TCG\Voyager\Models\Menu;
use TCG\Voyager\Models\MenuItem;
use TCG\Voyager\Models\Permission;
use TCG\Voyager\Models\Role;
use TCG\Voyager\Models\Setting;
use TCG\Voyager\Models\User;

class CoraVoyagerDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Memory::dump_usage(true);
        ini_set("memory_limit","512M");

        $this->command->info('------------------------------------------------------------------------!');
        $this->command->info('            Start: CoRA Voyager Admin Tables                                  !');
        $this->command->info('------------------------------------------------------------------------!');
        $this->call(CoraRolesTableSeeder::class);
        $this->call(CoraDataTypesTableSeeder::class);
        $this->call(CoraDataRowsTableSeeder::class);
        $this->call(CoraMenusTableSeeder::class);
        $this->call(CoraMenuItemsTableSeeder::class);
        $this->call(CoraPermissionsTableSeeder::class);
        $this->call(CoraPermissionRoleTableSeeder::class);
        $this->command->info('------------------------------------------------------------------------!');
        $this->command->info('             End: CoRA Voyager Admin Tables                                   !');
        $this->command->info('------------------------------------------------------------------------!');

        $this->command->info('------------------------------------------------------------------------!');
        $this->command->info('                Updating CoRA Settings                                  !');
        $this->command->info('------------------------------------------------------------------------!');
        $this->updateCoraSettings();
        $this->command->info('------------------------------------------------------------------------!');
        $this->command->info('                Updating CoRA Settings - Done                           !');
        $this->command->info('------------------------------------------------------------------------!');

        $adminUser =  User::firstOrNew(['name' => 'Sachin Pawaskar']);
        if ($adminUser->exists) {
            $adminUser->fill(['avatar' => 'users/sachin-color.png'])->save();
        }

        Memory::dump_usage(true);
    }

    protected function updateCoraSettings()
    {
        $setting = $this->findSetting('site.title');
        if ($setting->exists) {
            $setting->fill(['value' => 'CoRA'])->save();
        }

        $setting = $this->findSetting('site.description');
        if ($setting->exists) {
            // ToDo: Image Attribution [Image: by Cristian Grecu]
            $setting->fill(['value' => 'Welcome to CoRA (Commingled Remains Analytics)'])->save();
        }

//        $setting = $this->findSetting('site.logo');
//        if ($setting->exists) {
//            $setting->fill(['value' => ''])->save();
//        }

        // Add new CoRA Site settings
        $setting = $this->findSetting('site.welcome_image');
        if (!$setting->exists) {
            $setting->fill([ 'display_name' => 'Site Welcome Image',
                'details' => '', 'type' => 'image', 'order' => 4, 'group' => 'Site',
                'value'=>   'storage/images/cora-welcome-artwork.jpg',
            ])->save();
        }

        $setting = $this->findSetting('site.url_online_help');
        if (!$setting->exists) {
            $setting->fill([ 'display_name' => 'Site Online Help URL',
                'details' => '', 'type' => 'text', 'order' => 5, 'group' => 'Site',
                'value'=>   'https://cora-docs.readthedocs.io',
            ])->save();
        }

        $setting = $this->findSetting('site.seo_keywords');
        if (!$setting->exists) {
            $setting->fill([ 'display_name' => 'Site Search Engine Optimization (SEO) Keywords',
                'details' => '', 'type' => 'text_area', 'order' => 6, 'group' => 'Site',
                'value'=>   'Commingled Remains, Human Remains, Commingled Human Remains, Forensics, Anthropology, Bones, Skeletal, Inventory,
Taphonomy, Data Science, Data Analytics, Data Visualization, Articulations, Pairs, Biological Profile, DNA, Haplogroup,
Pathology, Trauma, Anomaly, Osteology, Osteosort, Homunculus, Ancentry, Genealogy',
            ])->save();
        }

        $setting = $this->findSetting('site.google_analytics_tracking_id');
        if ($setting->exists) {
            $setting->fill(['value' => '520399104952-t4q4nr66rskhahq8qsp4sfn4l36sk9nq.apps.googleusercontent.com', 'order' => 6,])->save();
        }

        $setting = $this->findSetting('admin.google_analytics_client_id');
        if ($setting->exists) {
            $setting->fill(['value' => '520399104952-t4q4nr66rskhahq8qsp4sfn4l36sk9nq.apps.googleusercontent.com'])->save();
        }

        $setting = $this->findSetting('admin.title');
        if ($setting->exists) {
            $setting->fill(['value' => 'CoRA Admin'])->save();
        }

        $setting = $this->findSetting('admin.description');
        if ($setting->exists) {
            $setting->fill(['value' => 'Welcome to CoRA (Commingled Remains Analytics)'])->save();
        }

        $setting = $this->findSetting('admin.bg_image');
        if ($setting->exists) {
            $setting->fill(['value' => 'images/cora-bg.jpg'])->save();
        }

//        $setting = $this->findSetting('admin.icon_image');
//        if ($setting->exists) {
//            $setting->fill(['value' => ''])->save();
//        }

//        $setting = $this->findSetting('admin.loader');
//        if ($setting->exists) {
//            $setting->fill(['value' => ''])->save();
//        }

    }

    /**
     * [setting description].
     *
     * @param [type] $key [description]
     *
     * @return [type] [description]
     */
    protected function findSetting($key)
    {
        return Setting::firstOrNew(['key' => $key]);
    }
}

class CoraRolesTableSeeder extends Seeder {

    public function run()
    {
        // First remove the default "Normal User" that comes with Voyager Seeding
        $role = Role::firstOrNew(['name' => 'user']);
        if ($role->exists) {
            $role->forceDelete();
        }

        $role = Role::firstOrNew(['name' => 'manager']);
        if (!$role->exists) {
            $role->fill(['display_name' => 'Manager',
                'description' => 'Manager is allowed to manage their Org and objects for that org such as users, projects, and specimens and related data'
            ])->save();
        }

        $role = Role::firstOrNew(['name' => 'anthropologist']);
        if (!$role->exists) {
            $role->fill(['display_name' => 'Anthropologist',
                'description' => 'Anthropologist is allowed full Read/Write access to specimens and related data'
            ])->save();
        }

        $role = Role::firstOrNew(['name' => 'dna-analyst']);
        if (!$role->exists) {
            $role->fill(['display_name' => 'DNA Analyst',
                'description' => 'DNA Analyst is allowed Read access to specimens and Read/Write access to DNA data'
            ])->save();
        }

        $role = Role::firstOrNew(['name' => 'historian']);
        if (!$role->exists) {
            $role->fill(['display_name' => 'Historian',
                'description' => 'Historian is allowed Read access to specimens and Read/Write access to Antemortem data'
            ])->save();
        }

        $role = Role::firstOrNew(['name' => 'dentist']);
        if (!$role->exists) {
            $role->fill(['display_name' => 'Dentist',
                'description' => 'Dentist is allowed Read access to specimens and Read/Write access to Dental elements data'
            ])->save();
        }

        $role = Role::firstOrNew(['name' => 'intern']);
        if (!$role->exists) {
            $role->fill(['display_name' => 'Intern',
                'description' => 'Intern is allowed Read access to specimens and related data'
            ])->save();
        }
    }
}

class CoraDataTypesTableSeeder extends Seeder
{
    /**
     * Auto generated seed file.
     */
    public function run()
    {
        // First fix the model_names/policy for User and Roles that comes with Voyager Seeding
        $dataType = $this->dataType('slug', 'users');
        if ($dataType->exists) {
            $dataType->fill([ 'model_name' => 'App\\User', 'policy_name' => 'App\\Policies\\UserPolicy',])->save();
        }
        $dataType = $this->dataType('slug', 'roles');
        if ($dataType->exists) {
            $dataType->fill([ 'model_name' => 'App\\Role',])->save();
        }

        $dataType = $this->dataType('slug', 'orgs');
        if (!$dataType->exists) {
            $dataType->fill([ 'name' => 'orgs', 'display_name_singular' => 'Org', 'display_name_plural' => 'Orgs',
                'icon' => 'voyager-company', 'model_name' => 'App\\Org', 'policy_name' => 'App\\Policies\\OrgPolicy',
                'controller' => '', 'generate_permissions' => 1, 'description' => '',
            ])->save();
        }

        $dataType = $this->dataType('slug', 'sb');
        if (!$dataType->exists) {
            $dataType->fill([ 'name' => 'skeletal_bones', 'display_name_singular' => 'Bone', 'display_name_plural' => 'Bones',
                'icon' => 'voyager-skull', 'model_name' => 'App\\SkeletalBone', 'policy_name' => '',
                'controller' => '', 'generate_permissions' => 1, 'description' => '',
            ])->save();
        }

        $dataType = $this->dataType('slug', 'se');
        if (!$dataType->exists) {
            $dataType->fill([ 'name' => 'skeletal_elements', 'display_name_singular' => 'Specimen', 'display_name_plural' => 'Specimens',
                'icon' => 'voyager-skull', 'model_name' => 'App\\SkeletalElement', 'policy_name' => 'App\\Policies\\SkeletalElementPolicy',
                'controller' => '', 'generate_permissions' => 1, 'description' => '',
            ])->save();
        }

        $dataType = $this->dataType('slug', 'accessions');
        if (!$dataType->exists) {
            $dataType->fill([ 'name' => 'accessions', 'display_name_singular' => 'Accession', 'display_name_plural' => 'Accessions',
                'icon' => 'voyager-character', 'model_name' => 'App\\Accession', 'policy_name' => '',
                'controller' => '', 'generate_permissions' => 1, 'description' => '',
            ])->save();
        }

        $dataType = $this->dataType('slug', 'anomalys');
        if (!$dataType->exists) {
            $dataType->fill([ 'name' => 'anomalys', 'display_name_singular' => 'Anomaly', 'display_name_plural' => 'Anomalys',
                'icon' => 'voyager-company', 'model_name' => 'App\\Anomaly', 'policy_name' => '',
                'controller' => '', 'generate_permissions' => 1, 'description' => '',
            ])->save();
        }

        $dataType = $this->dataType('slug', 'articulations');
        if (!$dataType->exists) {
            $dataType->fill([ 'name' => 'articulations', 'display_name_singular' => 'Articulation', 'display_name_plural' => 'Articulations',
                'icon' => 'voyager-company', 'model_name' => 'App\\Articulation', 'policy_name' => '',
                'controller' => '', 'generate_permissions' => 1, 'description' => '',
            ])->save();
        }

        $dataType = $this->dataType('slug', 'dnas');
        if (!$dataType->exists) {
            $dataType->fill([ 'name' => 'dnas', 'display_name_singular' => 'DNA', 'display_name_plural' => 'DNA',
                'icon' => 'voyager-company', 'model_name' => 'App\\Dna', 'policy_name' => '',
                'controller' => '', 'generate_permissions' => 1, 'description' => '',
            ])->save();
        }

        $dataType = $this->dataType('slug', 'dna_analysis_types');
        if (!$dataType->exists) {
            $dataType->fill([ 'name' => 'dna_analysis_types', 'display_name_singular' => 'DNA Analysis Type', 'display_name_plural' => 'DNA Analysis Types',
                'icon' => 'voyager-company', 'model_name' => 'App\\DnaAnalysisType', 'policy_name' => '',
                'controller' => '', 'generate_permissions' => 1, 'description' => '',
            ])->save();
        }

        $dataType = $this->dataType('slug', 'eulas');
        if (!$dataType->exists) {
            $dataType->fill([ 'name' => 'eulas', 'display_name_singular' => 'EULA', 'display_name_plural' => 'EULAs',
                'icon' => 'voyager-receipt', 'model_name' => 'App\\Eula', 'policy_name' => 'App\\Policies\\EulaPolicy',
                'controller' => '', 'generate_permissions' => 1, 'description' => '',
            ])->save();
        }

        $dataType = $this->dataType('slug', 'haplogroups');
        if (!$dataType->exists) {
            $dataType->fill([ 'name' => 'haplogroups', 'display_name_singular' => 'Haplogroup', 'display_name_plural' => 'Haplogroups',
                'icon' => 'voyager-tree', 'model_name' => 'App\\Haplogroup', 'policy_name' => '',
                'controller' => '', 'generate_permissions' => 1, 'description' => '',
            ])->save();
        }

        $dataType = $this->dataType('slug', 'incidents');
        if (!$dataType->exists) {
            $dataType->fill([ 'name' => 'incidents', 'display_name_singular' => 'Incident', 'display_name_plural' => 'Incidents',
                'icon' => 'voyager-company', 'model_name' => 'App\\Incident', 'policy_name' => '',
                'controller' => '', 'generate_permissions' => 1, 'description' => '',
            ])->save();
        }

        $dataType = $this->dataType('slug', 'instruments');
        if (!$dataType->exists) {
            $dataType->fill([ 'name' => 'instruments', 'display_name_singular' => 'Instrument', 'display_name_plural' => 'Instruments',
                'icon' => 'voyager-hammer', 'model_name' => 'App\\Instrument', 'policy_name' => '',
                'controller' => '', 'generate_permissions' => 1, 'description' => '',
            ])->save();
        }

        $dataType = $this->dataType('slug', 'measurements');
        if (!$dataType->exists) {
            $dataType->fill([ 'name' => 'measurements', 'display_name_singular' => 'Measurement', 'display_name_plural' => 'Measurements',
                'icon' => 'voyager-company', 'model_name' => 'App\\Measurement', 'policy_name' => '',
                'controller' => '', 'generate_permissions' => 1, 'description' => '',
            ])->save();
        }

        $dataType = $this->dataType('slug', 'method_features');
        if (!$dataType->exists) {
            $dataType->fill([ 'name' => 'method_features', 'display_name_singular' => 'Method_feature', 'display_name_plural' => 'Method_features',
                'icon' => 'voyager-facebook', 'model_name' => 'App\\MethodFeature', 'policy_name' => '',
                'controller' => '', 'generate_permissions' => 1, 'description' => '',
            ])->save();
        }

        $dataType = $this->dataType('slug', 'methods');
        if (!$dataType->exists) {
            $dataType->fill([ 'name' => 'methods', 'display_name_singular' => 'Method', 'display_name_plural' => 'Methods',
                'icon' => 'voyager-company', 'model_name' => 'App\\Method', 'policy_name' => '',
                'controller' => '', 'generate_permissions' => 1, 'description' => '',
            ])->save();
        }

        $dataType = $this->dataType('slug', 'pathologys');
        if (!$dataType->exists) {
            $dataType->fill([ 'name' => 'pathologys', 'display_name_singular' => 'Pathology', 'display_name_plural' => 'Pathologys',
                'icon' => 'voyager-lab', 'model_name' => 'App\\Pathology', 'policy_name' => '',
                'controller' => '', 'generate_permissions' => 1, 'description' => '',
            ])->save();
        }

        $dataType = $this->dataType('slug', 'profiles');
        if (!$dataType->exists) {
            $dataType->fill([ 'name' => 'profiles', 'display_name_singular' => 'Profile', 'display_name_plural' => 'Profiles',
                'icon' => 'voyager-company', 'model_name' => 'App\\Profile', 'policy_name' => 'App\\Policies\\ProfilePolicy',
                'controller' => '', 'generate_permissions' => 1, 'description' => '',
            ])->save();
        }

        $dataType = $this->dataType('slug', 'project_status');
        if (!$dataType->exists) {
            $dataType->fill([ 'name' => 'project_status', 'display_name_singular' => 'Project Status', 'display_name_plural' => 'Project Statuses',
                'icon' => 'voyager-company', 'model_name' => 'App\\ProjectStatus', 'policy_name' => '',
                'controller' => '', 'generate_permissions' => 1, 'description' => '',
            ])->save();
        }

        $dataType = $this->dataType('slug', 'projects');
        if (!$dataType->exists) {
            $dataType->fill([ 'name' => 'projects', 'display_name_singular' => 'Project', 'display_name_plural' => 'Projects',
                'icon' => 'voyager-bolt', 'model_name' => 'App\\Project', 'policy_name' => 'App\\Policies\\ProjectPolicy',
                'controller' => '', 'generate_permissions' => 1, 'description' => '',
            ])->save();
        }

        $dataType = $this->dataType('slug', 'sites');
        if (!$dataType->exists) {
            $dataType->fill([ 'name' => 'sites', 'display_name_singular' => 'Site', 'display_name_plural' => 'Sites',
                'icon' => 'voyager-company', 'model_name' => 'App\\Site', 'policy_name' => '',
                'controller' => '', 'generate_permissions' => 1, 'description' => '',
            ])->save();
        }

        $dataType = $this->dataType('slug', 'tags');
        if (!$dataType->exists) {
            $dataType->fill([ 'name' => 'tags', 'display_name_singular' => 'Tag', 'display_name_plural' => 'Tags',
                'icon' => 'voyager-tag', 'model_name' => 'App\\Tag', 'policy_name' => '',
                'controller' => '', 'generate_permissions' => 1, 'description' => '',
            ])->save();
        }

        $dataType = $this->dataType('slug', 'taphonomys');
        if (!$dataType->exists) {
            $dataType->fill([ 'name' => 'taphonomys', 'display_name_singular' => 'Taphonomy', 'display_name_plural' => 'Taphonomys',
                'icon' => 'voyager-character', 'model_name' => 'App\\Taphonomy', 'policy_name' => '',
                'controller' => '', 'generate_permissions' => 1, 'description' => '',
            ])->save();
        }

        $dataType = $this->dataType('slug', 'traumas');
        if (!$dataType->exists) {
            $dataType->fill([ 'name' => 'traumas', 'display_name_singular' => 'Trauma', 'display_name_plural' => 'Traumas',
                'icon' => 'voyager-fire', 'model_name' => 'App\\Trauma', 'policy_name' => '',
                'controller' => '', 'generate_permissions' => 1, 'description' => '',
            ])->save();
        }

        $dataType = $this->dataType('slug', 'zones');
        if (!$dataType->exists) {
            $dataType->fill([ 'name' => 'zones', 'display_name_singular' => 'Zone', 'display_name_plural' => 'Zones',
                'icon' => 'voyager-crop', 'model_name' => 'App\\Zone', 'policy_name' => '',
                'controller' => '', 'generate_permissions' => 1, 'description' => '',
            ])->save();
        }
    }

    /**
     * [dataType description].
     *
     * @param [type] $field [description]
     * @param [type] $for   [description]
     *
     * @return [type] [description]
     */
    protected function dataType($field, $for)
    {
        return DataType::firstOrNew([$field => $for]);
    }
}

class CoraDataRowsTableSeeder extends Seeder
{
    /**
     * Auto generated seed file.
     */
    public function run()
    {
        $this->dataRowUsers();
        $this->dataRowOrgs();
        $this->dataRowSkeletalBones();
        $this->dataRowSkeletalElements();
        $this->dataRowAccessions();
        $this->dataRowAnomaly();
        $this->dataRowArticulations();
        $this->dataRowDnaAnalysisTypes();
        $this->dataRowEulas();
        $this->dataRowHaplogroups();
        $this->dataRowEulas();
        $this->dataRowInstruments();
        $this->dataRowMethods();
        $this->dataRowMeasurements();
        $this->dataRowMethodFeatures();
        $this->dataRowPathologys();
        $this->dataRowProjectStatuses();
        $this->dataRowProjects();
        $this->dataRowTaphonomys();
        $this->dataRowTraumas();
        $this->dataRowZones();
    }

//        Permission::generateFor('incidents');
//        Permission::generateFor('profiles');
//        Permission::generateFor('sites');
//        Permission::generateFor('tags');

    protected function dataRowUsers()
    {
        $userDataType = DataType::where('slug', 'users')->firstOrFail();

        $dataRow = $this->dataRow($userDataType, 'org_id');
        if (!$dataRow->exists) {
            $dataRow->fill(['type' => 'number', 'display_name' => 'Org', 'details' => '', 'order' => 10,
                'required' => 1, 'browse' => 1, 'read' => 1, 'edit' => 1, 'add' => 1, 'delete' => 1,
            ])->save();
        }

        $dataRow = $this->dataRow($userDataType, 'project_belongsto_org_relationship');
        if (!$dataRow->exists) {
            $dataRow->fill(['type' => 'relationship', 'display_name' => 'Org',
                'required' => 0, 'browse' => 1, 'read' => 1, 'edit' => 1, 'add' => 1, 'delete' => 0,
                'details' => '{"model":"App\\\Org","table":"orgs","type":"belongsTo","column":"org_id","key":"id","label":"name","pivot_table":"orgs","pivot":"0"}',
                'order' => 12,
            ])->save();
        }
    }

    protected function dataRowOrgs()
    {
        $orgDataType = DataType::where('slug', 'orgs')->firstOrFail();

        $dataRow = $this->dataRow($orgDataType, 'id');
        if (!$dataRow->exists) {
            $dataRow->fill(['type' => 'number', 'display_name' => 'ID', 'details' => '', 'order' => 1,
                'required' => 1, 'browse' => 0, 'read' => 0, 'edit' => 0, 'add' => 0, 'delete' => 0,
            ])->save();
        }

        $dataRow = $this->dataRow($orgDataType, 'name');
        if (!$dataRow->exists) {
            $dataRow->fill([ 'type' => 'text', 'display_name' => 'Name', 'details' => '', 'order'=> 2,
                'required' => 1, 'browse' => 1, 'read' => 1, 'edit' => 1, 'add' => 1, 'delete' => 1,
            ])->save();
        }

        $dataRow = $this->dataRow($orgDataType, 'address');
        if (!$dataRow->exists) {
            $dataRow->fill([ 'type' => 'text', 'display_name' => 'Address', 'details' => '', 'order'=> 3,
                'required' => 0, 'browse' => 0, 'read' => 1, 'edit' => 1, 'add' => 1, 'delete' => 1,
            ])->save();
        }

        $dataRow = $this->dataRow($orgDataType, 'city');
        if (!$dataRow->exists) {
            $dataRow->fill([ 'type' => 'text', 'display_name' => 'City', 'details' => '', 'order'=> 4,
                'required' => 0, 'browse' => 0, 'read' => 1, 'edit' => 1, 'add' => 1, 'delete' => 1,
            ])->save();
        }

        $dataRow = $this->dataRow($orgDataType, 'state');
        if (!$dataRow->exists) {
            $dataRow->fill([ 'type' => 'text', 'display_name' => 'State', 'details' => '', 'order'=> 5,
                'required' => 0, 'browse' => 0, 'read' => 1, 'edit' => 1, 'add' => 1, 'delete' => 1,
            ])->save();
        }

        $dataRow = $this->dataRow($orgDataType, 'zip');
        if (!$dataRow->exists) {
            $dataRow->fill([ 'type' => 'text', 'display_name' => 'Zip', 'details' => '', 'order'=> 6,
                'required' => 0, 'browse' => 0, 'read' => 1, 'edit' => 1, 'add' => 1, 'delete' => 1,
            ])->save();
        }

        $dataRow = $this->dataRow($orgDataType, 'description');
        if (!$dataRow->exists) {
            $dataRow->fill([ 'type' => 'text', 'display_name' => 'Description', 'details' => '', 'order'=> 7,
                'required' => 0, 'browse' => 0, 'read' => 1, 'edit' => 1, 'add' => 1, 'delete' => 1,
            ])->save();
        }

        $dataRow = $this->dataRow($orgDataType, 'acronym');
        if (!$dataRow->exists) {
            $dataRow->fill([ 'type' => 'text', 'display_name' => 'Acronym', 'details' => '', 'order'=> 8,
                'required' => 0, 'browse' => 1, 'read' => 1, 'edit' => 1, 'add' => 1, 'delete' => 1,
            ])->save();
        }

        $dataRow = $this->dataRow($orgDataType, 'geo_lat');
        if (!$dataRow->exists) {
            $dataRow->fill([ 'type' => 'text', 'display_name' => 'Geo Lat', 'details' => '', 'order'=> 9,
                'required' => 0, 'browse' => 0, 'read' => 1, 'edit' => 1, 'add' => 1, 'delete' => 1,
            ])->save();
        }

        $dataRow = $this->dataRow($orgDataType, 'geo_long');
        if (!$dataRow->exists) {
            $dataRow->fill([ 'type' => 'text', 'display_name' => 'Geo Lon', 'details' => '', 'order'=> 10,
                'required' => 0, 'browse' => 0, 'read' => 1, 'edit' => 1, 'add' => 1, 'delete' => 1,
            ])->save();
        }

        $dataRow = $this->dataRow($orgDataType, 'website');
        if (!$dataRow->exists) {
            $dataRow->fill([ 'type' => 'text', 'display_name' => 'Website', 'details' => '', 'order'=> 11,
                'required' => 0, 'browse' => 0, 'read' => 1, 'edit' => 1, 'add' => 1, 'delete' => 1,
            ])->save();
        }

        $dataRow = $this->dataRow($orgDataType, 'phone');
        if (!$dataRow->exists) {
            $dataRow->fill([ 'type' => 'text', 'display_name' => 'Phone', 'details' => '', 'order'=> 12,
                'required' => 0, 'browse' => 0, 'read' => 1, 'edit' => 1, 'add' => 1, 'delete' => 1,
            ])->save();
        }

        $dataRow = $this->dataRow($orgDataType, 'toll_free');
        if (!$dataRow->exists) {
            $dataRow->fill([ 'type' => 'text', 'display_name' => 'Toll Free', 'details' => '', 'order'=> 13,
                'required' => 0, 'browse' => 0, 'read' => 1, 'edit' => 1, 'add' => 1, 'delete' => 1,
            ])->save();
        }

        $dataRow = $this->dataRow($orgDataType, 'fax');
        if (!$dataRow->exists) {
            $dataRow->fill([ 'type' => 'text', 'display_name' => 'Fax', 'details' => '', 'order'=> 14,
                'required' => 0, 'browse' => 0, 'read' => 1, 'edit' => 1, 'add' => 1, 'delete' => 1,
            ])->save();
        }

        $dataRow = $this->dataRow($orgDataType, 'contact_name');
        if (!$dataRow->exists) {
            $dataRow->fill([ 'type' => 'text', 'display_name' => 'Contact Name', 'details' => '', 'order'=> 15,
                'required' => 0, 'browse' => 0, 'read' => 1, 'edit' => 1, 'add' => 1, 'delete' => 1,
            ])->save();
        }

        $dataRow = $this->dataRow($orgDataType, 'contact_email');
        if (!$dataRow->exists) {
            $dataRow->fill([ 'type' => 'text', 'display_name' => 'Contact Email', 'details' => '', 'order'=> 16,
                'required' => 0, 'browse' => 0, 'read' => 1, 'edit' => 1, 'add' => 1, 'delete' => 1,
            ])->save();
        }

        $dataRow = $this->dataRow($orgDataType, 'created_by');
        if (!$dataRow->exists) {
            $dataRow->fill(['type' => 'text', 'display_name' => 'Created By', 'details' => '', 'order'=> 6,
                'required' => 0, 'browse' => 0, 'read' => 0, 'edit' => 0, 'add' => 0, 'delete' => 0,
            ])->save();
        }

        $dataRow = $this->dataRow($orgDataType, 'updated_by');
        if (!$dataRow->exists) {
            $dataRow->fill(['type' => 'text', 'display_name' => 'Updated By', 'details' => '', 'order'=> 7,
                'required' => 0, 'browse' => 0, 'read' => 0, 'edit' => 0, 'add' => 0, 'delete' => 0,
            ])->save();
        }

        $dataRow = $this->dataRow($orgDataType, 'created_at');
        if (!$dataRow->exists) {
            $dataRow->fill([ 'type' => 'text', 'display_name' => 'Created At', 'details' => '', 'order'=> 19,
                'required' => 0, 'browse' => 1, 'read' => 1, 'edit' => 0, 'add' => 0, 'delete' => 0,
            ])->save();
        }

        $dataRow = $this->dataRow($orgDataType, 'updated_at');
        if (!$dataRow->exists) {
            $dataRow->fill([ 'type' => 'text', 'display_name' => 'Updated At', 'details' => '', 'order'=> 20,
                'required' => 0, 'browse' => 0, 'read' => 0, 'edit' => 0, 'add' => 0, 'delete' => 0,
            ])->save();
        }

        $dataRow = $this->dataRow($orgDataType, 'deleted_at');
        if (!$dataRow->exists) {
            $dataRow->fill([ 'type' => 'text', 'display_name' => 'Deleted At', 'details' => '', 'order'=> 21,
                'required' => 0, 'browse' => 0, 'read' => 1, 'edit' => 0, 'add' => 0, 'delete' => 0,
            ])->save();
        }
    }

    protected function dataRowSkeletalBones()
    {
        $sbDataType = DataType::where('slug', 'sb')->firstOrFail();

        $dataRow = $this->dataRow($sbDataType, 'id');
        if (!$dataRow->exists) {
            $dataRow->fill(['type' => 'number', 'display_name' => 'ID', 'details' => '', 'order' => 1,
                'required' => 1, 'browse' => 0, 'read' => 0, 'edit' => 0, 'add' => 0, 'delete' => 0,
            ])->save();
        }

        $dataRow = $this->dataRow($sbDataType, 'name');
        if (!$dataRow->exists) {
            $dataRow->fill([ 'type' => 'text', 'display_name' => 'Name', 'details' => '', 'order'=> 2,
                'required' => 1, 'browse' => 1, 'read' => 1, 'edit' => 1, 'add' => 1, 'delete' => 1,
            ])->save();
        }

        $dataRow = $this->dataRow($sbDataType, 'category');
        if (!$dataRow->exists) {
            $dataRow->fill([ 'type' => 'text', 'display_name' => 'Category', 'details' => '', 'order'=> 3,
                'required' => 0, 'browse' => 1, 'read' => 1, 'edit' => 1, 'add' => 1, 'delete' => 1,
            ])->save();
        }

        $dataRow = $this->dataRow($sbDataType, 'type');
        if (!$dataRow->exists) {
            $dataRow->fill([ 'type' => 'text', 'display_name' => 'Type', 'details' => '', 'order'=> 4,
                'required' => 0, 'browse' => 1, 'read' => 1, 'edit' => 1, 'add' => 1, 'delete' => 1,
            ])->save();
        }

        $dataRow = $this->dataRow($sbDataType, 'group');
        if (!$dataRow->exists) {
            $dataRow->fill([ 'type' => 'text', 'display_name' => 'Group', 'details' => '', 'order'=> 5,
                'required' => 0, 'browse' => 1, 'read' => 1, 'edit' => 1, 'add' => 1, 'delete' => 1,
            ])->save();
        }

        $dataRow = $this->dataRow($sbDataType, 'description');
        if (!$dataRow->exists) {
            $dataRow->fill([ 'type' => 'text', 'display_name' => 'Description', 'details' => '', 'order'=> 6,
                'required' => 0, 'browse' => 0, 'read' => 1, 'edit' => 1, 'add' => 1, 'delete' => 1,
            ])->save();
        }

        $dataRow = $this->dataRow($sbDataType, 'paired');
        if (!$dataRow->exists) {
            $dataRow->fill([ 'type' => 'checkbox', 'display_name' => 'Paired', 'details' => '', 'order'=> 7,
                'required' => 0, 'browse' => 1, 'read' => 1, 'edit' => 1, 'add' => 1, 'delete' => 1,
            ])->save();
        }

        $dataRow = $this->dataRow($sbDataType, 'articulated');
        if (!$dataRow->exists) {
            $dataRow->fill([ 'type' => 'checkbox', 'display_name' => 'Articulated', 'details' => '', 'order'=> 8,
                'required' => 0, 'browse' => 1, 'read' => 1, 'edit' => 1, 'add' => 1, 'delete' => 1,
            ])->save();
        }

        $dataRow = $this->dataRow($sbDataType, 'zones');
        if (!$dataRow->exists) {
            $dataRow->fill([ 'type' => 'checkbox', 'display_name' => 'Zones', 'details' => '', 'order'=> 9,
                'required' => 0, 'browse' => 0, 'read' => 1, 'edit' => 1, 'add' => 1, 'delete' => 1,
            ])->save();
        }

        $dataRow = $this->dataRow($sbDataType, 'measurements');
        if (!$dataRow->exists) {
            $dataRow->fill([ 'type' => 'checkbox', 'display_name' => 'Measurements', 'details' => '', 'order'=> 10,
                'required' => 0, 'browse' => 0, 'read' => 1, 'edit' => 1, 'add' => 1, 'delete' => 1,
            ])->save();
        }

        $dataRow = $this->dataRow($sbDataType, 'dental');
        if (!$dataRow->exists) {
            $dataRow->fill([ 'type' => 'checkbox', 'display_name' => 'Dental', 'details' => '', 'order'=> 11,
                'required' => 0, 'browse' => 0, 'read' => 1, 'edit' => 1, 'add' => 1, 'delete' => 1,
            ])->save();
        }

        $dataRow = $this->dataRow($sbDataType, 'image_zones');
        if (!$dataRow->exists) {
            $dataRow->fill([ 'type' => 'text', 'display_name' => 'Image Zones', 'details' => '', 'order'=> 12,
                'required' => 0, 'browse' => 0, 'read' => 1, 'edit' => 1, 'add' => 1, 'delete' => 1,
            ])->save();
        }

        $dataRow = $this->dataRow($sbDataType, 'image_measurements');
        if (!$dataRow->exists) {
            $dataRow->fill([ 'type' => 'text', 'display_name' => 'Image Measurements', 'details' => '', 'order'=> 12,
                'required' => 0, 'browse' => 0, 'read' => 1, 'edit' => 1, 'add' => 1, 'delete' => 1,
            ])->save();
        }

        $dataRow = $this->dataRow($sbDataType, 'created_by');
        if (!$dataRow->exists) {
            $dataRow->fill(['type' => 'text', 'display_name' => 'Created By', 'details' => '', 'order'=> 12,
                'required' => 0, 'browse' => 0, 'read' => 0, 'edit' => 0, 'add' => 0, 'delete' => 0,
            ])->save();
        }

        $dataRow = $this->dataRow($sbDataType, 'updated_by');
        if (!$dataRow->exists) {
            $dataRow->fill(['type' => 'text', 'display_name' => 'Updated By', 'details' => '', 'order'=> 13,
                'required' => 0, 'browse' => 0, 'read' => 0, 'edit' => 0, 'add' => 0, 'delete' => 0,
            ])->save();
        }

        $dataRow = $this->dataRow($sbDataType, 'created_at');
        if (!$dataRow->exists) {
            $dataRow->fill([ 'type' => 'text', 'display_name' => 'Created At', 'details' => '', 'order'=> 14,
                'required' => 0, 'browse' => 1, 'read' => 1, 'edit' => 0, 'add' => 0, 'delete' => 0,
            ])->save();
        }

        $dataRow = $this->dataRow($sbDataType, 'updated_at');
        if (!$dataRow->exists) {
            $dataRow->fill([ 'type' => 'text', 'display_name' => 'Updated At', 'details' => '', 'order'=> 15,
                'required' => 0, 'browse' => 0, 'read' => 0, 'edit' => 0, 'add' => 0, 'delete' => 0,
            ])->save();
        }

        $dataRow = $this->dataRow($sbDataType, 'deleted_at');
        if (!$dataRow->exists) {
            $dataRow->fill([ 'type' => 'text', 'display_name' => 'Deleted At', 'details' => '', 'order'=> 16,
                'required' => 0, 'browse' => 0, 'read' => 1, 'edit' => 0, 'add' => 0, 'delete' => 0,
            ])->save();
        }
    }

    protected function dataRowSkeletalElements()
    {
        $seDataType = DataType::where('slug', 'se')->firstOrFail();

        $dataRow = $this->dataRow($seDataType, 'id');
        if (!$dataRow->exists) {
            $dataRow->fill(['type' => 'number', 'display_name' => 'ID', 'details' => '', 'order' => 1,
                'required' => 1, 'browse' => 0, 'read' => 0, 'edit' => 0, 'add' => 0, 'delete' => 0,
            ])->save();
        }

        $dataRow = $this->dataRow($seDataType, 'accession');
        if (!$dataRow->exists) {
            $dataRow->fill([ 'type' => 'text', 'display_name' => 'Accession', 'details' => '', 'order'=> 2,
                'required' => 1, 'browse' => 1, 'read' => 1, 'edit' => 1, 'add' => 1, 'delete' => 1,
            ])->save();
        }

        $dataRow = $this->dataRow($seDataType, 'provenance1');
        if (!$dataRow->exists) {
            $dataRow->fill([ 'type' => 'text', 'display_name' => 'Provenance1', 'details' => '', 'order'=> 3,
                'required' => 0, 'browse' => 1, 'read' => 1, 'edit' => 1, 'add' => 1, 'delete' => 1,
            ])->save();
        }

        $dataRow = $this->dataRow($seDataType, 'provenance2');
        if (!$dataRow->exists) {
            $dataRow->fill([ 'type' => 'text', 'display_name' => 'Provenance2', 'details' => '', 'order'=> 4,
                'required' => 0, 'browse' => 1, 'read' => 1, 'edit' => 1, 'add' => 1, 'delete' => 1,
            ])->save();
        }

        $dataRow = $this->dataRow($seDataType, 'designator');
        if (!$dataRow->exists) {
            $dataRow->fill([ 'type' => 'text', 'display_name' => 'Designator', 'details' => '', 'order'=> 5,
                'required' => 0, 'browse' => 1, 'read' => 1, 'edit' => 1, 'add' => 1, 'delete' => 1,
            ])->save();
        }
/*
        $dataRow = $this->dataRow($seDataType, 'description');
        if (!$dataRow->exists) {
            $dataRow->fill([ 'type' => 'text', 'display_name' => 'Description', 'details' => '', 'order'=> 6,
                'required' => 0, 'browse' => 0, 'read' => 1, 'edit' => 1, 'add' => 1, 'delete' => 1,
            ])->save();
        }

        $dataRow = $this->dataRow($seDataType, 'paired');
        if (!$dataRow->exists) {
            $dataRow->fill([ 'type' => 'checkbox', 'display_name' => 'Paired', 'details' => '', 'order'=> 7,
                'required' => 0, 'browse' => 1, 'read' => 1, 'edit' => 1, 'add' => 1, 'delete' => 1,
            ])->save();
        }

        $dataRow = $this->dataRow($seDataType, 'articulated');
        if (!$dataRow->exists) {
            $dataRow->fill([ 'type' => 'checkbox', 'display_name' => 'Articulated', 'details' => '', 'order'=> 8,
                'required' => 0, 'browse' => 1, 'read' => 1, 'edit' => 1, 'add' => 1, 'delete' => 1,
            ])->save();
        }

        $dataRow = $this->dataRow($seDataType, 'zones');
        if (!$dataRow->exists) {
            $dataRow->fill([ 'type' => 'checkbox', 'display_name' => 'Zones', 'details' => '', 'order'=> 9,
                'required' => 0, 'browse' => 0, 'read' => 1, 'edit' => 1, 'add' => 1, 'delete' => 1,
            ])->save();
        }

        $dataRow = $this->dataRow($seDataType, 'measurements');
        if (!$dataRow->exists) {
            $dataRow->fill([ 'type' => 'checkbox', 'display_name' => 'Measurements', 'details' => '', 'order'=> 10,
                'required' => 0, 'browse' => 0, 'read' => 1, 'edit' => 1, 'add' => 1, 'delete' => 1,
            ])->save();
        }

        $dataRow = $this->dataRow($seDataType, 'dental');
        if (!$dataRow->exists) {
            $dataRow->fill([ 'type' => 'checkbox', 'display_name' => 'Dental', 'details' => '', 'order'=> 11,
                'required' => 0, 'browse' => 0, 'read' => 1, 'edit' => 1, 'add' => 1, 'delete' => 1,
            ])->save();
        }

        $dataRow = $this->dataRow($seDataType, 'image_zones');
        if (!$dataRow->exists) {
            $dataRow->fill([ 'type' => 'text', 'display_name' => 'Image Zones', 'details' => '', 'order'=> 12,
                'required' => 0, 'browse' => 0, 'read' => 1, 'edit' => 1, 'add' => 1, 'delete' => 1,
            ])->save();
        }

        $dataRow = $this->dataRow($seDataType, 'image_measurements');
        if (!$dataRow->exists) {
            $dataRow->fill([ 'type' => 'text', 'display_name' => 'Image Measurements', 'details' => '', 'order'=> 12,
                'required' => 0, 'browse' => 0, 'read' => 1, 'edit' => 1, 'add' => 1, 'delete' => 1,
            ])->save();
        }
*/
        $dataRow = $this->dataRow($seDataType, 'created_by');
        if (!$dataRow->exists) {
            $dataRow->fill(['type' => 'text', 'display_name' => 'Created By', 'details' => '', 'order'=> 12,
                'required' => 0, 'browse' => 0, 'read' => 0, 'edit' => 0, 'add' => 0, 'delete' => 0,
            ])->save();
        }

        $dataRow = $this->dataRow($seDataType, 'updated_by');
        if (!$dataRow->exists) {
            $dataRow->fill(['type' => 'text', 'display_name' => 'Updated By', 'details' => '', 'order'=> 13,
                'required' => 0, 'browse' => 0, 'read' => 0, 'edit' => 0, 'add' => 0, 'delete' => 0,
            ])->save();
        }

        $dataRow = $this->dataRow($seDataType, 'created_at');
        if (!$dataRow->exists) {
            $dataRow->fill([ 'type' => 'text', 'display_name' => 'Created At', 'details' => '', 'order'=> 14,
                'required' => 0, 'browse' => 1, 'read' => 1, 'edit' => 0, 'add' => 0, 'delete' => 0,
            ])->save();
        }

        $dataRow = $this->dataRow($seDataType, 'updated_at');
        if (!$dataRow->exists) {
            $dataRow->fill([ 'type' => 'text', 'display_name' => 'Updated At', 'details' => '', 'order'=> 15,
                'required' => 0, 'browse' => 0, 'read' => 0, 'edit' => 0, 'add' => 0, 'delete' => 0,
            ])->save();
        }

        $dataRow = $this->dataRow($seDataType, 'deleted_at');
        if (!$dataRow->exists) {
            $dataRow->fill([ 'type' => 'text', 'display_name' => 'Deleted At', 'details' => '', 'order'=> 16,
                'required' => 0, 'browse' => 0, 'read' => 1, 'edit' => 0, 'add' => 0, 'delete' => 0,
            ])->save();
        }
    }

    protected function dataRowAccessions()
    {
        $accessionDataType = DataType::where('slug', 'accessions')->firstOrFail();

        $dataRow = $this->dataRow($accessionDataType, 'id');
        if (!$dataRow->exists) {
            $dataRow->fill(['type' => 'number', 'display_name' => 'ID', 'details' => '', 'order' => 1,
                'required' => 1, 'browse' => 0, 'read' => 0, 'edit' => 0, 'add' => 0, 'delete' => 0,
            ])->save();
        }

        $dataRow = $this->dataRow($accessionDataType, 'org_id');
        if (!$dataRow->exists) {
            $dataRow->fill(['type' => 'number', 'display_name' => 'Org', 'details' => '', 'order' => 2,
                'required' => 1, 'browse' => 1, 'read' => 1, 'edit' => 1, 'add' => 1, 'delete' => 1,
            ])->save();
        }

        $dataRow = $this->dataRow($accessionDataType, 'project_id');
        if (!$dataRow->exists) {
            $dataRow->fill(['type' => 'number', 'display_name' => 'Project', 'details' => '', 'order' => 3,
                'required' => 1, 'browse' => 1, 'read' => 1, 'edit' => 1, 'add' => 1, 'delete' => 1,
            ])->save();
        }

        $dataRow = $this->dataRow($accessionDataType, 'number');
        if (!$dataRow->exists) {
            $dataRow->fill(['type' => 'text', 'display_name' => 'Name', 'details' => '', 'order' => 4,
                'required' => 1, 'browse' => 1, 'read' => 1, 'edit' => 1, 'add' => 1, 'delete' => 1,
            ])->save();
        }

        $dataRow = $this->dataRow($accessionDataType, 'provenance1');
        if (!$dataRow->exists) {
            $dataRow->fill(['type' => 'text', 'display_name' => 'Provenance1', 'details' => '', 'order' => 5,
                'required' => 1, 'browse' => 1, 'read' => 1, 'edit' => 1, 'add' => 1, 'delete' => 1,
            ])->save();
        }

        $dataRow = $this->dataRow($accessionDataType, 'provenance2');
        if (!$dataRow->exists) {
            $dataRow->fill(['type' => 'text', 'display_name' => 'Provenance1', 'details' => '', 'order' => 6,
                'required' => 1, 'browse' => 1, 'read' => 1, 'edit' => 1, 'add' => 1, 'delete' => 1,
            ])->save();
        }

        $dataRow = $this->dataRow($accessionDataType, 'created_by');
        if (!$dataRow->exists) {
            $dataRow->fill(['type' => 'text', 'display_name' => 'Created By', 'details' => '', 'order'=> 7,
                'required' => 0, 'browse' => 0, 'read' => 0, 'edit' => 0, 'add' => 0, 'delete' => 0,
            ])->save();
        }

        $dataRow = $this->dataRow($accessionDataType, 'updated_by');
        if (!$dataRow->exists) {
            $dataRow->fill(['type' => 'text', 'display_name' => 'Updated By', 'details' => '', 'order'=> 8,
                'required' => 0, 'browse' => 0, 'read' => 0, 'edit' => 0, 'add' => 0, 'delete' => 0,
            ])->save();
        }

        $dataRow = $this->dataRow($accessionDataType, 'created_at');
        if (!$dataRow->exists) {
            $dataRow->fill(['type' => 'timestamp', 'display_name' => 'Created At', 'details' => '', 'order'=> 9,
                'required' => 0, 'browse' => 1, 'read' => 1, 'edit' => 0, 'add' => 0, 'delete' => 0,
            ])->save();
        }

        $dataRow = $this->dataRow($accessionDataType, 'updated_at');
        if (!$dataRow->exists) {
            $dataRow->fill(['type' => 'timestamp', 'display_name' => 'Updated At', 'details' => '', 'order'=> 10,
                'required' => 0, 'browse' => 0, 'read' => 0, 'edit' => 0, 'add' => 0, 'delete' => 0,
            ])->save();
        }

        $dataRow = $this->dataRow($accessionDataType, 'deleted_at');
        if (!$dataRow->exists) {
            $dataRow->fill(['type' => 'timestamp', 'display_name' => 'Deleted At', 'details' => '', 'order'=> 11,
                'required' => 0, 'browse' => 0, 'read' => 0, 'edit' => 0, 'add' => 0, 'delete' => 0,
            ])->save();
        }

        $dataRow = $this->dataRow($accessionDataType, 'accession_belongsto_org_relationship');
        if (!$dataRow->exists) {
            $dataRow->fill(['type' => 'relationship', 'display_name' => 'Org',
                'required' => 0, 'browse' => 1, 'read' => 1, 'edit' => 1, 'add' => 1, 'delete' => 0,
                'details' => '{"model":"App\\\Org","table":"orgs","type":"belongsTo","column":"org_id","key":"id","label":"name","pivot_table":"orgs","pivot":"0"}',
                'order' => 12,
            ])->save();
        }

        $dataRow = $this->dataRow($accessionDataType, 'accession_belongsto_project_relationship');
        if (!$dataRow->exists) {
            $dataRow->fill(['type' => 'relationship', 'display_name' => 'Project',
                'required' => 0, 'browse' => 1, 'read' => 1, 'edit' => 1, 'add' => 1, 'delete' => 0,
                'details' => '{"model":"App\\\Project","table":"projects","type":"belongsTo","column":"project_id","key":"id","label":"name","pivot_table":"projects","pivot":"0"}',
                'order' => 13,
            ])->save();
        }
    }

    protected function dataRowAnomaly()
    {
        $anomalyDataType = DataType::where('slug', 'anomalys')->firstOrFail();

        $dataRow = $this->dataRow($anomalyDataType, 'id');
        if (!$dataRow->exists) {
            $dataRow->fill(['type' => 'number', 'display_name' => 'ID', 'details' => '', 'order' => 1,
                'required' => 1, 'browse' => 0, 'read' => 0, 'edit' => 0, 'add' => 0, 'delete' => 0,
            ])->save();
        }

        $dataRow = $this->dataRow($anomalyDataType, 'sb_id');
        if (!$dataRow->exists) {
            $dataRow->fill(['type' => 'number', 'display_name' => 'Bone', 'details' => '', 'order' => 2,
                'required' => 1, 'browse' => 1, 'read' => 1, 'edit' => 1, 'add' => 1, 'delete' => 1,
            ])->save();
        }

        $dataRow = $this->dataRow($anomalyDataType, 'individuating_trait');
        if (!$dataRow->exists) {
            $dataRow->fill(['type' => 'text', 'display_name' => 'Individuating Trait', 'details' => '', 'order' => 3,
                'required' => 1, 'browse' => 1, 'read' => 1, 'edit' => 1, 'add' => 1, 'delete' => 1,
            ])->save();
        }

        $dataRow = $this->dataRow($anomalyDataType, 'created_by');
        if (!$dataRow->exists) {
            $dataRow->fill(['type' => 'text', 'display_name' => 'Created By', 'details' => '', 'order'=> 4,
                'required' => 0, 'browse' => 0, 'read' => 0, 'edit' => 0, 'add' => 0, 'delete' => 0,
            ])->save();
        }

        $dataRow = $this->dataRow($anomalyDataType, 'updated_by');
        if (!$dataRow->exists) {
            $dataRow->fill(['type' => 'text', 'display_name' => 'Updated By', 'details' => '', 'order'=> 5,
                'required' => 0, 'browse' => 0, 'read' => 0, 'edit' => 0, 'add' => 0, 'delete' => 0,
            ])->save();
        }

        $dataRow = $this->dataRow($anomalyDataType, 'created_at');
        if (!$dataRow->exists) {
            $dataRow->fill(['type' => 'timestamp', 'display_name' => 'Created At', 'details' => '', 'order'=> 6,
                'required' => 0, 'browse' => 1, 'read' => 1, 'edit' => 0, 'add' => 0, 'delete' => 0,
            ])->save();
        }

        $dataRow = $this->dataRow($anomalyDataType, 'updated_at');
        if (!$dataRow->exists) {
            $dataRow->fill(['type' => 'timestamp', 'display_name' => 'Updated At', 'details' => '', 'order'=> 7,
                'required' => 0, 'browse' => 0, 'read' => 0, 'edit' => 0, 'add' => 0, 'delete' => 0,
            ])->save();
        }

        $dataRow = $this->dataRow($anomalyDataType, 'deleted_at');
        if (!$dataRow->exists) {
            $dataRow->fill(['type' => 'timestamp', 'display_name' => 'Deleted At', 'details' => '', 'order'=> 8,
                'required' => 0, 'browse' => 0, 'read' => 0, 'edit' => 0, 'add' => 0, 'delete' => 0,
            ])->save();
        }

        $dataRow = $this->dataRow($anomalyDataType, 'anomaly_belongsto_sb_relationship');
        if (!$dataRow->exists) {
            $dataRow->fill(['type' => 'relationship', 'display_name' => 'Bone',
                'required' => 0, 'browse' => 1, 'read' => 1, 'edit' => 1, 'add' => 1, 'delete' => 0,
                'details' => '{"model":"App\\\SkeletalBone","table":"skeletal_bones","type":"belongsTo","column":"sb_id","key":"id","label":"name","pivot_table":"skeletal_bones","pivot":"0"}',
                'order' => 9,
            ])->save();
        }
    }

    protected function dataRowArticulations()
    {
        $articulationDataType = DataType::where('slug', 'articulations')->firstOrFail();

        $dataRow = $this->dataRow($articulationDataType, 'sb_id');
        if (!$dataRow->exists) {
            $dataRow->fill(['type' => 'number', 'display_name' => 'Bone', 'details' => '', 'order' => 1,
                'required' => 1, 'browse' => 1, 'read' => 1, 'edit' => 1, 'add' => 1, 'delete' => 1,
            ])->save();
        }

        $dataRow = $this->dataRow($articulationDataType, 'articulation_id');
        if (!$dataRow->exists) {
            $dataRow->fill(['type' => 'number', 'display_name' => 'Articulated with Bone', 'details' => '', 'order' => 2,
                'required' => 1, 'browse' => 1, 'read' => 1, 'edit' => 1, 'add' => 1, 'delete' => 1,
            ])->save();
        }

        $dataRow = $this->dataRow($articulationDataType, 'created_by');
        if (!$dataRow->exists) {
            $dataRow->fill(['type' => 'text', 'display_name' => 'Created By', 'details' => '', 'order'=> 3,
                'required' => 0, 'browse' => 0, 'read' => 0, 'edit' => 0, 'add' => 0, 'delete' => 0,
            ])->save();
        }

        $dataRow = $this->dataRow($articulationDataType, 'updated_by');
        if (!$dataRow->exists) {
            $dataRow->fill(['type' => 'text', 'display_name' => 'Updated By', 'details' => '', 'order'=> 4,
                'required' => 0, 'browse' => 0, 'read' => 0, 'edit' => 0, 'add' => 0, 'delete' => 0,
            ])->save();
        }

        $dataRow = $this->dataRow($articulationDataType, 'created_at');
        if (!$dataRow->exists) {
            $dataRow->fill([ 'type' => 'text', 'display_name' => 'Created At', 'details' => '', 'order'=> 5,
                'required' => 0, 'browse' => 1, 'read' => 1, 'edit' => 0, 'add' => 0, 'delete' => 0,
            ])->save();
        }

        $dataRow = $this->dataRow($articulationDataType, 'updated_at');
        if (!$dataRow->exists) {
            $dataRow->fill([ 'type' => 'text', 'display_name' => 'Updated At', 'details' => '', 'order'=> 6,
                'required' => 0, 'browse' => 0, 'read' => 0, 'edit' => 0, 'add' => 0, 'delete' => 0,
            ])->save();
        }

        $dataRow = $this->dataRow($articulationDataType, 'deleted_at');
        if (!$dataRow->exists) {
            $dataRow->fill([ 'type' => 'text', 'display_name' => 'Deleted At', 'details' => '', 'order'=> 7,
                'required' => 0, 'browse' => 0, 'read' => 1, 'edit' => 0, 'add' => 0, 'delete' => 0,
            ])->save();
        }

        $dataRow = $this->dataRow($articulationDataType, 'sb_belongsto_sb_relationship');
        if (!$dataRow->exists) {
            $dataRow->fill(['type' => 'relationship', 'display_name' => 'Bone',
                'required' => 0, 'browse' => 1, 'read' => 1, 'edit' => 1, 'add' => 1, 'delete' => 0,
                'details' => '{"model":"App\\\SkeletalBone","table":"skeletal_bones","type":"belongsTo","column":"sb_id","key":"id","label":"name","pivot_table":"skeletal_bones","pivot":"0"}',
                'order' => 8,
            ])->save();
        }
        $dataRow = $this->dataRow($articulationDataType, 'sb_articulated_belongsto_sb_relationship');
        if (!$dataRow->exists) {
            $dataRow->fill(['type' => 'relationship', 'display_name' => 'Articulated with Bone',
                'required' => 0, 'browse' => 1, 'read' => 1, 'edit' => 1, 'add' => 1, 'delete' => 0,
                'details' => '{"model":"App\\\SkeletalBone","table":"skeletal_bones","type":"belongsTo","column":"articulation_id","key":"id","label":"name","pivot_table":"skeletal_bones","pivot":"0"}',
                'order' => 9,
            ])->save();
        }
    }

    protected function dataRowDnaAnalysisTypes()
    {
        $dnaanalysistypeDataType = DataType::where('slug', 'dna_analysis_types')->firstOrFail();

        $dataRow = $this->dataRow($dnaanalysistypeDataType, 'id');
        if (!$dataRow->exists) {
            $dataRow->fill(['type' => 'number', 'display_name' => 'ID', 'details' => '', 'order' => 1,
                'required' => 1, 'browse' => 0, 'read' => 0, 'edit' => 0, 'add' => 0, 'delete' => 0,
            ])->save();
        }

        $dataRow = $this->dataRow($dnaanalysistypeDataType, 'name');
        if (!$dataRow->exists) {
            $dataRow->fill(['type' => 'text', 'display_name' => 'Name', 'details' => '', 'order' => 2,
                'required' => 1, 'browse' => 1, 'read' => 1, 'edit' => 1, 'add' => 1, 'delete' => 1,
            ])->save();
        }

        $dataRow = $this->dataRow($dnaanalysistypeDataType, 'description');
        if (!$dataRow->exists) {
            $dataRow->fill(['type' => 'text', 'display_name' => 'Description', 'details' => '', 'order' => 3,
                'required' => 1, 'browse' => 1, 'read' => 1, 'edit' => 1, 'add' => 1, 'delete' => 1,
            ])->save();
        }

        $dataRow = $this->dataRow($dnaanalysistypeDataType, 'created_at');
        if (!$dataRow->exists) {
            $dataRow->fill(['type' => 'timestamp', 'display_name' => 'Created At', 'details' => '', 'order'=> 4,
                'required' => 0, 'browse' => 1, 'read' => 1, 'edit' => 0, 'add' => 0, 'delete' => 0,
            ])->save();
        }

        $dataRow = $this->dataRow($dnaanalysistypeDataType, 'updated_at');
        if (!$dataRow->exists) {
            $dataRow->fill(['type' => 'timestamp', 'display_name' => 'Updated At', 'details' => '', 'order'=> 5,
                'required' => 0, 'browse' => 0, 'read' => 0, 'edit' => 0, 'add' => 0, 'delete' => 0,
            ])->save();
        }

        $dataRow = $this->dataRow($dnaanalysistypeDataType, 'deleted_at');
        if (!$dataRow->exists) {
            $dataRow->fill(['type' => 'timestamp', 'display_name' => 'Deleted At', 'details' => '', 'order'=> 6,
                'required' => 0, 'browse' => 0, 'read' => 0, 'edit' => 0, 'add' => 0, 'delete' => 0,
            ])->save();
        }
    }

    protected function dataRowEulas()
    {
        $eulaDataType = DataType::where('slug', 'eulas')->firstOrFail();

        $dataRow = $this->dataRow($eulaDataType, 'id');
        if (!$dataRow->exists) {
            $dataRow->fill(['type' => 'number', 'display_name' => 'ID', 'details' => '', 'order' => 1,
                'required' => 1, 'browse' => 0, 'read' => 0, 'edit' => 0, 'add' => 0, 'delete' => 0,
            ])->save();
        }

        $dataRow = $this->dataRow($eulaDataType, 'org_id');
        if (!$dataRow->exists) {
            $dataRow->fill(['type' => 'number', 'display_name' => 'Org', 'details' => '', 'order' => 2,
                'required' => 1, 'browse' => 1, 'read' => 1, 'edit' => 1, 'add' => 1, 'delete' => 1,
            ])->save();
        }

        $dataRow = $this->dataRow($eulaDataType, 'version');
        if (!$dataRow->exists) {
            $dataRow->fill(['type' => 'text', 'display_name' => 'Version', 'details' => '', 'order' => 3,
                'required' => 1, 'browse' => 1, 'read' => 1, 'edit' => 1, 'add' => 1, 'delete' => 1,
            ])->save();
        }

        $dataRow = $this->dataRow($eulaDataType, 'agreement');
        if (!$dataRow->exists) {
            $dataRow->fill(['type' => 'text', 'display_name' => 'Agreement', 'details' => '', 'order' => 4,
                'required' => 1, 'browse' => 1, 'read' => 1, 'edit' => 1, 'add' => 1, 'delete' => 1,
            ])->save();
        }

        $dataRow = $this->dataRow($eulaDataType, 'language');
        if (!$dataRow->exists) {
            $dataRow->fill(['type' => 'text', 'display_name' => 'Language', 'details' => '', 'order' => 5,
                'required' => 1, 'browse' => 1, 'read' => 1, 'edit' => 1, 'add' => 1, 'delete' => 1,
            ])->save();
        }

        $dataRow = $this->dataRow($eulaDataType, 'country');
        if (!$dataRow->exists) {
            $dataRow->fill(['type' => 'text', 'display_name' => 'Country', 'details' => '', 'order' => 6,
                'required' => 1, 'browse' => 1, 'read' => 1, 'edit' => 1, 'add' => 1, 'delete' => 1,
            ])->save();
        }

        $dataRow = $this->dataRow($eulaDataType, 'status');
        if (!$dataRow->exists) {
            $dataRow->fill(['type' => 'checkbox', 'display_name' => 'Status', 'details' => '', 'order' => 7,
                'required' => 1, 'browse' => 1, 'read' => 1, 'edit' => 1, 'add' => 1, 'delete' => 1,
            ])->save();
        }

        $dataRow = $this->dataRow($eulaDataType, 'file_type');
        if (!$dataRow->exists) {
            $dataRow->fill(['type' => 'text', 'display_name' => 'File Type', 'details' => '', 'order' => 8,
                'required' => 1, 'browse' => 1, 'read' => 1, 'edit' => 1, 'add' => 1, 'delete' => 1,
            ])->save();
        }

        $dataRow = $this->dataRow($eulaDataType, 'effective_at');
        if (!$dataRow->exists) {
            $dataRow->fill(['type' => 'timestamp', 'display_name' => 'Effective At', 'details' => '', 'order' => 9,
                'required' => 1, 'browse' => 1, 'read' => 1, 'edit' => 1, 'add' => 1, 'delete' => 1,
            ])->save();
        }

        $dataRow = $this->dataRow($eulaDataType, 'created_by');
        if (!$dataRow->exists) {
            $dataRow->fill(['type' => 'text', 'display_name' => 'Created By', 'details' => '', 'order'=> 10,
                'required' => 0, 'browse' => 0, 'read' => 0, 'edit' => 0, 'add' => 0, 'delete' => 0,
            ])->save();
        }

        $dataRow = $this->dataRow($eulaDataType, 'updated_by');
        if (!$dataRow->exists) {
            $dataRow->fill(['type' => 'text', 'display_name' => 'Updated By', 'details' => '', 'order'=> 11,
                'required' => 0, 'browse' => 0, 'read' => 0, 'edit' => 0, 'add' => 0, 'delete' => 0,
            ])->save();
        }

        $dataRow = $this->dataRow($eulaDataType, 'created_at');
        if (!$dataRow->exists) {
            $dataRow->fill(['type' => 'timestamp', 'display_name' => 'Created At', 'details' => '', 'order'=> 12,
                'required' => 0, 'browse' => 1, 'read' => 1, 'edit' => 0, 'add' => 0, 'delete' => 0,
            ])->save();
        }

        $dataRow = $this->dataRow($eulaDataType, 'updated_at');
        if (!$dataRow->exists) {
            $dataRow->fill(['type' => 'timestamp', 'display_name' => 'Updated At', 'details' => '', 'order'=> 13,
                'required' => 0, 'browse' => 0, 'read' => 0, 'edit' => 0, 'add' => 0, 'delete' => 0,
            ])->save();
        }

        $dataRow = $this->dataRow($eulaDataType, 'deleted_at');
        if (!$dataRow->exists) {
            $dataRow->fill(['type' => 'timestamp', 'display_name' => 'Deleted At', 'details' => '', 'order'=> 14,
                'required' => 0, 'browse' => 0, 'read' => 0, 'edit' => 0, 'add' => 0, 'delete' => 0,
            ])->save();
        }

        $dataRow = $this->dataRow($eulaDataType, 'eula_belongsto_org_relationship');
        if (!$dataRow->exists) {
            $dataRow->fill(['type' => 'relationship', 'display_name' => 'Org',
                'required' => 0, 'browse' => 1, 'read' => 1, 'edit' => 1, 'add' => 1, 'delete' => 0,
                'details' => '{"model":"App\\\Org","table":"orgs","type":"belongsTo","column":"org_id","key":"id","label":"name","pivot_table":"orgs","pivot":"0"}',
                'order' => 15,
            ])->save();
        }
    }

    protected function dataRowHaplogroups()
    {
        $haplogroupDataType = DataType::where('slug', 'haplogroups')->firstOrFail();

        $dataRow = $this->dataRow($haplogroupDataType, 'id');
        if (!$dataRow->exists) {
            $dataRow->fill(['type' => 'number', 'display_name' => 'ID', 'details' => '', 'order' => 1,
                'required' => 1, 'browse' => 0, 'read' => 0, 'edit' => 0, 'add' => 0, 'delete' => 0,
            ])->save();
        }

        $dataRow = $this->dataRow($haplogroupDataType, 'letter');
        if (!$dataRow->exists) {
            $dataRow->fill(['type' => 'text', 'display_name' => 'Letter', 'details' => '', 'order' => 2,
                'required' => 1, 'browse' => 1, 'read' => 1, 'edit' => 1, 'add' => 1, 'delete' => 1,
            ])->save();
        }

        $dataRow = $this->dataRow($haplogroupDataType, 'ancestry');
        if (!$dataRow->exists) {
            $dataRow->fill(['type' => 'text', 'display_name' => 'Category', 'details' => '', 'order' => 3,
                'required' => 1, 'browse' => 1, 'read' => 1, 'edit' => 1, 'add' => 1, 'delete' => 1,
            ])->save();
        }

        $dataRow = $this->dataRow($haplogroupDataType, 'created_by');
        if (!$dataRow->exists) {
            $dataRow->fill(['type' => 'text', 'display_name' => 'Created By', 'details' => '', 'order'=> 4,
                'required' => 0, 'browse' => 0, 'read' => 0, 'edit' => 0, 'add' => 0, 'delete' => 0,
            ])->save();
        }

        $dataRow = $this->dataRow($haplogroupDataType, 'updated_by');
        if (!$dataRow->exists) {
            $dataRow->fill(['type' => 'text', 'display_name' => 'Updated By', 'details' => '', 'order'=> 5,
                'required' => 0, 'browse' => 0, 'read' => 0, 'edit' => 0, 'add' => 0, 'delete' => 0,
            ])->save();
        }

        $dataRow = $this->dataRow($haplogroupDataType, 'created_at');
        if (!$dataRow->exists) {
            $dataRow->fill(['type' => 'timestamp', 'display_name' => 'Created At', 'details' => '', 'order'=> 6,
                'required' => 0, 'browse' => 1, 'read' => 1, 'edit' => 0, 'add' => 0, 'delete' => 0,
            ])->save();
        }

        $dataRow = $this->dataRow($haplogroupDataType, 'updated_at');
        if (!$dataRow->exists) {
            $dataRow->fill(['type' => 'timestamp', 'display_name' => 'Updated At', 'details' => '', 'order'=> 7,
                'required' => 0, 'browse' => 0, 'read' => 0, 'edit' => 0, 'add' => 0, 'delete' => 0,
            ])->save();
        }

        $dataRow = $this->dataRow($haplogroupDataType, 'deleted_at');
        if (!$dataRow->exists) {
            $dataRow->fill(['type' => 'timestamp', 'display_name' => 'Deleted At', 'details' => '', 'order'=> 8,
                'required' => 0, 'browse' => 0, 'read' => 0, 'edit' => 0, 'add' => 0, 'delete' => 0,
            ])->save();
        }
    }

    protected function dataRowInstruments()
    {
        $instrumentDataType = DataType::where('slug', 'instruments')->firstOrFail();

        $dataRow = $this->dataRow($instrumentDataType, 'id');
        if (!$dataRow->exists) {
            $dataRow->fill(['type' => 'number', 'display_name' => 'ID', 'details' => '', 'order' => 1,
                'required' => 1, 'browse' => 0, 'read' => 0, 'edit' => 0, 'add' => 0, 'delete' => 0,
            ])->save();
        }

        $dataRow = $this->dataRow($instrumentDataType, 'org_id');
        if (!$dataRow->exists) {
            $dataRow->fill(['type' => 'number', 'display_name' => 'Org', 'details' => '', 'order' => 2,
                'required' => 1, 'browse' => 1, 'read' => 1, 'edit' => 1, 'add' => 1, 'delete' => 1,
            ])->save();
        }

        $dataRow = $this->dataRow($instrumentDataType, 'code');
        if (!$dataRow->exists) {
            $dataRow->fill(['type' => 'text', 'display_name' => 'Code', 'details' => '', 'order' => 3,
                'required' => 1, 'browse' => 1, 'read' => 1, 'edit' => 1, 'add' => 1, 'delete' => 1,
            ])->save();
        }

        $dataRow = $this->dataRow($instrumentDataType, 'category');
        if (!$dataRow->exists) {
            $dataRow->fill(['type' => 'text', 'display_name' => 'Category', 'details' => '', 'order' => 4,
                'required' => 1, 'browse' => 1, 'read' => 1, 'edit' => 1, 'add' => 1, 'delete' => 1,
            ])->save();
        }

        $dataRow = $this->dataRow($instrumentDataType, 'module');
        if (!$dataRow->exists) {
            $dataRow->fill(['type' => 'text', 'display_name' => 'Module', 'details' => '', 'order' => 5,
                'required' => 1, 'browse' => 1, 'read' => 1, 'edit' => 1, 'add' => 1, 'delete' => 1,
            ])->save();
        }

        $dataRow = $this->dataRow($instrumentDataType, 'reference');
        if (!$dataRow->exists) {
            $dataRow->fill(['type' => 'text', 'display_name' => 'Reference', 'details' => '', 'order' => 6,
                'required' => 0, 'browse' => 1, 'read' => 1, 'edit' => 1, 'add' => 1, 'delete' => 1,
            ])->save();
        }

        $dataRow = $this->dataRow($instrumentDataType, 'created_by');
        if (!$dataRow->exists) {
            $dataRow->fill(['type' => 'text', 'display_name' => 'Created By', 'details' => '', 'order'=> 7,
                'required' => 0, 'browse' => 0, 'read' => 0, 'edit' => 0, 'add' => 0, 'delete' => 0,
            ])->save();
        }

        $dataRow = $this->dataRow($instrumentDataType, 'updated_by');
        if (!$dataRow->exists) {
            $dataRow->fill(['type' => 'text', 'display_name' => 'Updated By', 'details' => '', 'order'=> 8,
                'required' => 0, 'browse' => 0, 'read' => 0, 'edit' => 0, 'add' => 0, 'delete' => 0,
            ])->save();
        }

        $dataRow = $this->dataRow($instrumentDataType, 'created_at');
        if (!$dataRow->exists) {
            $dataRow->fill(['type' => 'timestamp', 'display_name' => 'Created At', 'details' => '', 'order'=>9,
                'required' => 0, 'browse' => 1, 'read' => 1, 'edit' => 0, 'add' => 0, 'delete' => 0,
            ])->save();
        }

        $dataRow = $this->dataRow($instrumentDataType, 'updated_at');
        if (!$dataRow->exists) {
            $dataRow->fill(['type' => 'timestamp', 'display_name' => 'Updated At', 'details' => '', 'order'=> 10,
                'required' => 0, 'browse' => 0, 'read' => 0, 'edit' => 0, 'add' => 0, 'delete' => 0,
            ])->save();
        }

        $dataRow = $this->dataRow($instrumentDataType, 'deleted_at');
        if (!$dataRow->exists) {
            $dataRow->fill(['type' => 'timestamp', 'display_name' => 'Deleted At', 'details' => '', 'order'=> 11,
                'required' => 0, 'browse' => 0, 'read' => 0, 'edit' => 0, 'add' => 0, 'delete' => 0,
            ])->save();
        }

        $dataRow = $this->dataRow($instrumentDataType, 'instrument_belongsto_org_relationship');
        if (!$dataRow->exists) {
            $dataRow->fill(['type' => 'relationship', 'display_name' => 'Org',
                'required' => 1, 'browse' => 1, 'read' => 1, 'edit' => 1, 'add' => 1, 'delete' => 0,
                'details' => '{"model":"App\\\Org","table":"orgs","type":"belongsTo","column":"org_id","key":"id","label":"name","pivot_table":"orgs","pivot":"0"}',
                'order' => 12,
            ])->save();
        }
    }

    protected function dataRowMeasurements()
    {
        $measurementDataType = DataType::where('slug', 'measurements')->firstOrFail();

        $dataRow = $this->dataRow($measurementDataType, 'id');
        if (!$dataRow->exists) {
            $dataRow->fill(['type' => 'number', 'display_name' => 'ID', 'details' => '', 'order' => 1,
                'required' => 1, 'browse' => 0, 'read' => 0, 'edit' => 0, 'add' => 0, 'delete' => 0,
            ])->save();
        }

        $dataRow = $this->dataRow($measurementDataType, 'sb_id');
        if (!$dataRow->exists) {
            $dataRow->fill(['type' => 'number', 'display_name' => 'Bone', 'details' => '', 'order' => 2,
                'required' => 1, 'browse' => 1, 'read' => 1, 'edit' => 1, 'add' => 1, 'delete' => 1,
            ])->save();
        }

        $dataRow = $this->dataRow($measurementDataType, 'name');
        if (!$dataRow->exists) {
            $dataRow->fill(['type' => 'text', 'display_name' => 'Name', 'details' => '', 'order' => 3,
                'required' => 1, 'browse' => 1, 'read' => 1, 'edit' => 1, 'add' => 1, 'delete' => 1,
            ])->save();
        }

        $dataRow = $this->dataRow($measurementDataType, 'display_name');
        if (!$dataRow->exists) {
            $dataRow->fill(['type' => 'text', 'display_name' => 'Display Name', 'details' => '', 'order' => 4,
                'required' => 1, 'browse' => 1, 'read' => 1, 'edit' => 1, 'add' => 1, 'delete' => 1,
            ])->save();
        }

        $dataRow = $this->dataRow($measurementDataType, 'description');
        if (!$dataRow->exists) {
            $dataRow->fill(['type' => 'text', 'display_name' => 'Description', 'details' => '', 'order' => 5,
                'required' => 1, 'browse' => 0, 'read' => 1, 'edit' => 1, 'add' => 1, 'delete' => 1,
            ])->save();
        }

        $dataRow = $this->dataRow($measurementDataType, 'stature');
        if (!$dataRow->exists) {
            $dataRow->fill(['type' => 'checkbox', 'display_name' => 'Stature', 'details' => '', 'order' => 6,
                'required' => 1, 'browse' => 1, 'read' => 1, 'edit' => 1, 'add' => 1, 'delete' => 1,
            ])->save();
        }

        $dataRow = $this->dataRow($measurementDataType, 'sex');
        if (!$dataRow->exists) {
            $dataRow->fill(['type' => 'checkbox', 'display_name' => 'Sex', 'details' => '', 'order' => 7,
                'required' => 1, 'browse' => 1, 'read' => 1, 'edit' => 1, 'add' => 1, 'delete' => 1,
            ])->save();
        }

        $dataRow = $this->dataRow($measurementDataType, 'created_by');
        if (!$dataRow->exists) {
            $dataRow->fill(['type' => 'text', 'display_name' => 'Created By', 'details' => '', 'order'=> 8,
                'required' => 0, 'browse' => 0, 'read' => 0, 'edit' => 0, 'add' => 0, 'delete' => 0,
            ])->save();
        }

        $dataRow = $this->dataRow($measurementDataType, 'updated_by');
        if (!$dataRow->exists) {
            $dataRow->fill(['type' => 'text', 'display_name' => 'Updated By', 'details' => '', 'order'=> 9,
                'required' => 0, 'browse' => 0, 'read' => 0, 'edit' => 0, 'add' => 0, 'delete' => 0,
            ])->save();
        }

        $dataRow = $this->dataRow($measurementDataType, 'created_at');
        if (!$dataRow->exists) {
            $dataRow->fill(['type' => 'timestamp', 'display_name' => 'Created At', 'details' => '', 'order'=> 10,
                'required' => 0, 'browse' => 1, 'read' => 1, 'edit' => 0, 'add' => 0, 'delete' => 0,
            ])->save();
        }

        $dataRow = $this->dataRow($measurementDataType, 'updated_at');
        if (!$dataRow->exists) {
            $dataRow->fill(['type' => 'timestamp', 'display_name' => 'Updated At', 'details' => '', 'order'=> 11,
                'required' => 0, 'browse' => 0, 'read' => 0, 'edit' => 0, 'add' => 0, 'delete' => 0,
            ])->save();
        }

        $dataRow = $this->dataRow($measurementDataType, 'deleted_at');
        if (!$dataRow->exists) {
            $dataRow->fill(['type' => 'timestamp', 'display_name' => 'Deleted At', 'details' => '', 'order'=> 12,
                'required' => 0, 'browse' => 0, 'read' => 0, 'edit' => 0, 'add' => 0, 'delete' => 0,
            ])->save();
        }

        $dataRow = $this->dataRow($measurementDataType, 'measurement_belongsto_sb_relationship');
        if (!$dataRow->exists) {
            $dataRow->fill(['type' => 'relationship', 'display_name' => 'Bone',
                'required' => 0, 'browse' => 1, 'read' => 1, 'edit' => 1, 'add' => 1, 'delete' => 0,
                'details' => '{"model":"App\\\SkeletalBone","table":"skeletal_bones","type":"belongsTo","column":"sb_id","key":"id","label":"name","pivot_table":"skeletal_bones","pivot":"0"}',
                'order' => 13,
            ])->save();
        }
    }

    protected function dataRowMethods()
    {
        $methodDataType = DataType::where('slug', 'methods')->firstOrFail();

        $dataRow = $this->dataRow($methodDataType, 'id');
        if (!$dataRow->exists) {
            $dataRow->fill(['type' => 'number', 'display_name' => 'ID', 'details' => '', 'order' => 1,
                'required' => 1, 'browse' => 0, 'read' => 0, 'edit' => 0, 'add' => 0, 'delete' => 0,
            ])->save();
        }

        $dataRow = $this->dataRow($methodDataType, 'sb_id');
        if (!$dataRow->exists) {
            $dataRow->fill(['type' => 'number', 'display_name' => 'Bone', 'details' => '', 'order' => 2,
                'required' => 1, 'browse' => 1, 'read' => 1, 'edit' => 1, 'add' => 1, 'delete' => 1,
            ])->save();
        }

        $dataRow = $this->dataRow($methodDataType, 'name');
        if (!$dataRow->exists) {
            $dataRow->fill(['type' => 'text', 'display_name' => 'Name', 'details' => '', 'order' => 3,
                'required' => 1, 'browse' => 1, 'read' => 1, 'edit' => 1, 'add' => 1, 'delete' => 1,
            ])->save();
        }

        $dataRow = $this->dataRow($methodDataType, 'reference');
        if (!$dataRow->exists) {
            $dataRow->fill(['type' => 'text', 'display_name' => 'Reference', 'details' => '', 'order' => 4,
                'required' => 1, 'browse' => 0, 'read' => 1, 'edit' => 1, 'add' => 1, 'delete' => 1,
            ])->save();
        }

        $dataRow = $this->dataRow($methodDataType, 'type');
        if (!$dataRow->exists) {
            $dataRow->fill(['type' => 'text', 'display_name' => 'Type', 'details' => '', 'order' => 5,
                'required' => 1, 'browse' => 1, 'read' => 1, 'edit' => 1, 'add' => 1, 'delete' => 1,
            ])->save();
        }

        $dataRow = $this->dataRow($methodDataType, 'submethod');
        if (!$dataRow->exists) {
            $dataRow->fill(['type' => 'text', 'display_name' => 'Sub Method', 'details' => '', 'order' => 6,
                'required' => 1, 'browse' => 1, 'read' => 1, 'edit' => 1, 'add' => 1, 'delete' => 1,
            ])->save();
        }

        $dataRow = $this->dataRow($methodDataType, 'description');
        if (!$dataRow->exists) {
            $dataRow->fill(['type' => 'text', 'display_name' => 'Description', 'details' => '', 'order' => 7,
                'required' => 1, 'browse' => 0, 'read' => 1, 'edit' => 1, 'add' => 1, 'delete' => 1,
            ])->save();
        }

        $dataRow = $this->dataRow($methodDataType, 'uses_feature_scoring');
        if (!$dataRow->exists) {
            $dataRow->fill(['type' => 'checkbox', 'display_name' => 'Uses Feature Scoring', 'details' => '', 'order' => 8,
                'required' => 1, 'browse' => 1, 'read' => 1, 'edit' => 1, 'add' => 1, 'delete' => 1,
            ])->save();
        }

        $dataRow = $this->dataRow($methodDataType, 'created_by');
        if (!$dataRow->exists) {
            $dataRow->fill(['type' => 'text', 'display_name' => 'Created By', 'details' => '', 'order'=> 9,
                'required' => 0, 'browse' => 0, 'read' => 0, 'edit' => 0, 'add' => 0, 'delete' => 0,
            ])->save();
        }

        $dataRow = $this->dataRow($methodDataType, 'updated_by');
        if (!$dataRow->exists) {
            $dataRow->fill(['type' => 'text', 'display_name' => 'Updated By', 'details' => '', 'order'=> 10,
                'required' => 0, 'browse' => 0, 'read' => 0, 'edit' => 0, 'add' => 0, 'delete' => 0,
            ])->save();
        }

        $dataRow = $this->dataRow($methodDataType, 'created_at');
        if (!$dataRow->exists) {
            $dataRow->fill(['type' => 'timestamp', 'display_name' => 'Created At', 'details' => '', 'order'=> 11,
                'required' => 0, 'browse' => 1, 'read' => 1, 'edit' => 0, 'add' => 0, 'delete' => 0,
            ])->save();
        }

        $dataRow = $this->dataRow($methodDataType, 'updated_at');
        if (!$dataRow->exists) {
            $dataRow->fill(['type' => 'timestamp', 'display_name' => 'Updated At', 'details' => '', 'order'=> 12,
                'required' => 0, 'browse' => 0, 'read' => 0, 'edit' => 0, 'add' => 0, 'delete' => 0,
            ])->save();
        }

        $dataRow = $this->dataRow($methodDataType, 'deleted_at');
        if (!$dataRow->exists) {
            $dataRow->fill(['type' => 'timestamp', 'display_name' => 'Deleted At', 'details' => '', 'order'=> 13,
                'required' => 0, 'browse' => 0, 'read' => 0, 'edit' => 0, 'add' => 0, 'delete' => 0,
            ])->save();
        }

        $dataRow = $this->dataRow($methodDataType, 'method_belongsto_sb_relationship');
        if (!$dataRow->exists) {
            $dataRow->fill(['type' => 'relationship', 'display_name' => 'Bone',
                'required' => 0, 'browse' => 1, 'read' => 1, 'edit' => 1, 'add' => 1, 'delete' => 0,
                'details' => '{"model":"App\\\SkeletalBone","table":"skeletal_bones","type":"belongsTo","column":"sb_id","key":"id","label":"name","pivot_table":"skeletal_bones","pivot":"0"}',
                'order' => 14,
            ])->save();
        }
    }

    protected function dataRowMethodFeatures()
    {
        $methodfeatureDataType = DataType::where('slug', 'method_features')->firstOrFail();

        $dataRow = $this->dataRow($methodfeatureDataType, 'id');
        if (!$dataRow->exists) {
            $dataRow->fill(['type' => 'number', 'display_name' => 'ID', 'details' => '', 'order' => 1,
                'required' => 1, 'browse' => 0, 'read' => 0, 'edit' => 0, 'add' => 0, 'delete' => 0,
            ])->save();
        }

        $dataRow = $this->dataRow($methodfeatureDataType, 'method_id');
        if (!$dataRow->exists) {
            $dataRow->fill(['type' => 'number', 'display_name' => 'Method', 'details' => '', 'order' => 2,
                'required' => 1, 'browse' => 1, 'read' => 1, 'edit' => 1, 'add' => 1, 'delete' => 1,
            ])->save();
        }

        $dataRow = $this->dataRow($methodfeatureDataType, 'feature');
        if (!$dataRow->exists) {
            $dataRow->fill(['type' => 'text', 'display_name' => 'Feature', 'details' => '', 'order' => 3,
                'required' => 1, 'browse' => 1, 'read' => 1, 'edit' => 1, 'add' => 1, 'delete' => 1,
            ])->save();
        }

        $dataRow = $this->dataRow($methodfeatureDataType, 'display_name');
        if (!$dataRow->exists) {
            $dataRow->fill(['type' => 'text', 'display_name' => 'Display Name', 'details' => '', 'order' => 4,
                'required' => 1, 'browse' => 0, 'read' => 1, 'edit' => 1, 'add' => 1, 'delete' => 1,
            ])->save();
        }

        $dataRow = $this->dataRow($methodfeatureDataType, 'created_by');
        if (!$dataRow->exists) {
            $dataRow->fill(['type' => 'text', 'display_name' => 'Created By', 'details' => '', 'order'=> 5,
                'required' => 0, 'browse' => 0, 'read' => 0, 'edit' => 0, 'add' => 0, 'delete' => 0,
            ])->save();
        }

        $dataRow = $this->dataRow($methodfeatureDataType, 'updated_by');
        if (!$dataRow->exists) {
            $dataRow->fill(['type' => 'text', 'display_name' => 'Updated By', 'details' => '', 'order'=> 6,
                'required' => 0, 'browse' => 0, 'read' => 0, 'edit' => 0, 'add' => 0, 'delete' => 0,
            ])->save();
        }

        $dataRow = $this->dataRow($methodfeatureDataType, 'created_at');
        if (!$dataRow->exists) {
            $dataRow->fill(['type' => 'timestamp', 'display_name' => 'Created At', 'details' => '', 'order'=> 7,
                'required' => 0, 'browse' => 1, 'read' => 1, 'edit' => 0, 'add' => 0, 'delete' => 0,
            ])->save();
        }

        $dataRow = $this->dataRow($methodfeatureDataType, 'updated_at');
        if (!$dataRow->exists) {
            $dataRow->fill(['type' => 'timestamp', 'display_name' => 'Updated At', 'details' => '', 'order'=> 8,
                'required' => 0, 'browse' => 0, 'read' => 0, 'edit' => 0, 'add' => 0, 'delete' => 0,
            ])->save();
        }

        $dataRow = $this->dataRow($methodfeatureDataType, 'deleted_at');
        if (!$dataRow->exists) {
            $dataRow->fill(['type' => 'timestamp', 'display_name' => 'Deleted At', 'details' => '', 'order'=> 9,
                'required' => 0, 'browse' => 0, 'read' => 0, 'edit' => 0, 'add' => 0, 'delete' => 0,
            ])->save();
        }

        $dataRow = $this->dataRow($methodfeatureDataType, 'methodfeatore_belongsto_method_relationship');
        if (!$dataRow->exists) {
            $dataRow->fill(['type' => 'relationship', 'display_name' => 'Method',
                'required' => 0, 'browse' => 1, 'read' => 1, 'edit' => 1, 'add' => 1, 'delete' => 0,
                'details' => '{"model":"App\\\Method","table":"methods","type":"belongsTo","column":"method_id","key":"id","label":"name","pivot_table":"methods","pivot":"0"}',
                'order' => 10,
            ])->save();
        }

        $dataRow = $this->dataRow($methodfeatureDataType, 'methodfeature_belongsto_sb_relationship');
        if (!$dataRow->exists) {
            $dataRow->fill(['type' => 'relationship', 'display_name' => 'Bone',
                'required' => 0, 'browse' => 1, 'read' => 1, 'edit' => 1, 'add' => 1, 'delete' => 0,
                'details' => '{"model":"App\\\SkeletalBone","table":"skeletal_bones","type":"belongsTo","column":"method_id","key":"sb_id","label":"name","pivot_table":"methods","pivot":"0"}',
                'order' => 11,
            ])->save();
        }
    }

    protected function dataRowPathologys()
    {
        $pathologyDataType = DataType::where('slug', 'pathologys')->firstOrFail();

        $dataRow = $this->dataRow($pathologyDataType, 'id');
        if (!$dataRow->exists) {
            $dataRow->fill(['type' => 'number', 'display_name' => 'ID', 'details' => '', 'order' => 1,
                'required' => 1, 'browse' => 0, 'read' => 0, 'edit' => 0, 'add' => 0, 'delete' => 0,
            ])->save();
        }

        $dataRow = $this->dataRow($pathologyDataType, 'abnormality_category');
        if (!$dataRow->exists) {
            $dataRow->fill(['type' => 'text', 'display_name' => 'Letter', 'details' => '', 'order' => 2,
                'required' => 1, 'browse' => 1, 'read' => 1, 'edit' => 1, 'add' => 1, 'delete' => 1,
            ])->save();
        }

        $dataRow = $this->dataRow($pathologyDataType, 'characteristics');
        if (!$dataRow->exists) {
            $dataRow->fill(['type' => 'text', 'display_name' => 'Category', 'details' => '', 'order' => 3,
                'required' => 1, 'browse' => 1, 'read' => 1, 'edit' => 1, 'add' => 1, 'delete' => 1,
            ])->save();
        }

        $dataRow = $this->dataRow($pathologyDataType, 'created_by');
        if (!$dataRow->exists) {
            $dataRow->fill(['type' => 'text', 'display_name' => 'Created By', 'details' => '', 'order'=> 4,
                'required' => 0, 'browse' => 0, 'read' => 0, 'edit' => 0, 'add' => 0, 'delete' => 0,
            ])->save();
        }

        $dataRow = $this->dataRow($pathologyDataType, 'updated_by');
        if (!$dataRow->exists) {
            $dataRow->fill(['type' => 'text', 'display_name' => 'Updated By', 'details' => '', 'order'=> 5,
                'required' => 0, 'browse' => 0, 'read' => 0, 'edit' => 0, 'add' => 0, 'delete' => 0,
            ])->save();
        }

        $dataRow = $this->dataRow($pathologyDataType, 'created_at');
        if (!$dataRow->exists) {
            $dataRow->fill(['type' => 'timestamp', 'display_name' => 'Created At', 'details' => '', 'order'=> 6,
                'required' => 0, 'browse' => 1, 'read' => 1, 'edit' => 0, 'add' => 0, 'delete' => 0,
            ])->save();
        }

        $dataRow = $this->dataRow($pathologyDataType, 'updated_at');
        if (!$dataRow->exists) {
            $dataRow->fill(['type' => 'timestamp', 'display_name' => 'Updated At', 'details' => '', 'order'=> 7,
                'required' => 0, 'browse' => 0, 'read' => 0, 'edit' => 0, 'add' => 0, 'delete' => 0,
            ])->save();
        }

        $dataRow = $this->dataRow($pathologyDataType, 'deleted_at');
        if (!$dataRow->exists) {
            $dataRow->fill(['type' => 'timestamp', 'display_name' => 'Deleted At', 'details' => '', 'order'=> 8,
                'required' => 0, 'browse' => 0, 'read' => 0, 'edit' => 0, 'add' => 0, 'delete' => 0,
            ])->save();
        }
    }

    protected function dataRowProjectStatuses()
    {
        $projectstatusDataType = DataType::where('slug', 'project_status')->firstOrFail();

        $dataRow = $this->dataRow($projectstatusDataType, 'id');
        if (!$dataRow->exists) {
            $dataRow->fill(['type' => 'number', 'display_name' => 'ID', 'details' => '', 'order' => 1,
                'required' => 1, 'browse' => 0, 'read' => 0, 'edit' => 0, 'add' => 0, 'delete' => 0,
            ])->save();
        }

        $dataRow = $this->dataRow($projectstatusDataType, 'display_name');
        if (!$dataRow->exists) {
            $dataRow->fill(['type' => 'text', 'display_name' => 'Display Name', 'details' => '', 'order' => 2,
                'required' => 1, 'browse' => 1, 'read' => 1, 'edit' => 1, 'add' => 1, 'delete' => 1,
            ])->save();
        }

        $dataRow = $this->dataRow($projectstatusDataType, 'display_order');
        if (!$dataRow->exists) {
            $dataRow->fill(['type' => 'text', 'display_name' => 'Display Order', 'details' => '', 'order' => 3,
                'required' => 1, 'browse' => 1, 'read' => 1, 'edit' => 1, 'add' => 1, 'delete' => 1,
            ])->save();
        }

        $dataRow = $this->dataRow($projectstatusDataType, 'created_by');
        if (!$dataRow->exists) {
            $dataRow->fill(['type' => 'text', 'display_name' => 'Created By', 'details' => '', 'order'=> 4,
                'required' => 0, 'browse' => 0, 'read' => 0, 'edit' => 0, 'add' => 0, 'delete' => 0,
            ])->save();
        }

        $dataRow = $this->dataRow($projectstatusDataType, 'updated_by');
        if (!$dataRow->exists) {
            $dataRow->fill(['type' => 'text', 'display_name' => 'Updated By', 'details' => '', 'order'=> 5,
                'required' => 0, 'browse' => 0, 'read' => 0, 'edit' => 0, 'add' => 0, 'delete' => 0,
            ])->save();
        }

        $dataRow = $this->dataRow($projectstatusDataType, 'created_at');
        if (!$dataRow->exists) {
            $dataRow->fill(['type' => 'timestamp', 'display_name' => 'Created At', 'details' => '', 'order'=> 6,
                'required' => 0, 'browse' => 1, 'read' => 1, 'edit' => 0, 'add' => 0, 'delete' => 0,
            ])->save();
        }

        $dataRow = $this->dataRow($projectstatusDataType, 'updated_at');
        if (!$dataRow->exists) {
            $dataRow->fill(['type' => 'timestamp', 'display_name' => 'Updated At', 'details' => '', 'order'=> 7,
                'required' => 0, 'browse' => 0, 'read' => 0, 'edit' => 0, 'add' => 0, 'delete' => 0,
            ])->save();
        }

        $dataRow = $this->dataRow($projectstatusDataType, 'deleted_at');
        if (!$dataRow->exists) {
            $dataRow->fill(['type' => 'timestamp', 'display_name' => 'Deleted At', 'details' => '', 'order'=> 8,
                'required' => 0, 'browse' => 0, 'read' => 0, 'edit' => 0, 'add' => 0, 'delete' => 0,
            ])->save();
        }
    }

    protected function dataRowProjects()
    {
        $projectDataType = DataType::where('slug', 'projects')->firstOrFail();

        $dataRow = $this->dataRow($projectDataType, 'id');
        if (!$dataRow->exists) {
            $dataRow->fill(['type' => 'number', 'display_name' => 'ID', 'details' => '', 'order' => 1,
                'required' => 1, 'browse' => 0, 'read' => 0, 'edit' => 0, 'add' => 0, 'delete' => 0,
            ])->save();
        }

        $dataRow = $this->dataRow($projectDataType, 'org_id');
        if (!$dataRow->exists) {
            $dataRow->fill(['type' => 'number', 'display_name' => 'Org', 'details' => '', 'order' => 2,
                'required' => 1, 'browse' => 1, 'read' => 1, 'edit' => 1, 'add' => 1, 'delete' => 1,
            ])->save();
        }

        $dataRow = $this->dataRow($projectDataType, 'name');
        if (!$dataRow->exists) {
            $dataRow->fill(['type' => 'text', 'display_name' => 'Name', 'details' => '', 'order' => 3,
                'required' => 1, 'browse' => 1, 'read' => 1, 'edit' => 1, 'add' => 1, 'delete' => 1,
            ])->save();
        }

        $dataRow = $this->dataRow($projectDataType, 'status_id');
        if (!$dataRow->exists) {
            $dataRow->fill(['type' => 'number', 'display_name' => 'Status', 'details' => '', 'order' => 4,
                'required' => 1, 'browse' => 1, 'read' => 1, 'edit' => 1, 'add' => 1, 'delete' => 1,
            ])->save();
        }

        $dataRow = $this->dataRow($projectDataType, 'public');
        if (!$dataRow->exists) {
            $dataRow->fill(['type' => 'checkbox', 'display_name' => 'Public', 'details' => '', 'order' => 5,
                'required' => 1, 'browse' => 1, 'read' => 1, 'edit' => 1, 'add' => 1, 'delete' => 1,
            ])->save();
        }

        $dataRow = $this->dataRow($projectDataType, 'description');
        if (!$dataRow->exists) {
            $dataRow->fill(['type' => 'text', 'display_name' => 'Description', 'details' => '', 'order' => 6,
                'required' => 1, 'browse' => 1, 'read' => 1, 'edit' => 1, 'add' => 1, 'delete' => 1,
            ])->save();
        }

        $dataRow = $this->dataRow($projectDataType, 'created_by');
        if (!$dataRow->exists) {
            $dataRow->fill(['type' => 'text', 'display_name' => 'Created By', 'details' => '', 'order'=> 7,
                'required' => 0, 'browse' => 0, 'read' => 0, 'edit' => 0, 'add' => 0, 'delete' => 0,
            ])->save();
        }

        $dataRow = $this->dataRow($projectDataType, 'updated_by');
        if (!$dataRow->exists) {
            $dataRow->fill(['type' => 'text', 'display_name' => 'Updated By', 'details' => '', 'order'=> 8,
                'required' => 0, 'browse' => 0, 'read' => 0, 'edit' => 0, 'add' => 0, 'delete' => 0,
            ])->save();
        }

        $dataRow = $this->dataRow($projectDataType, 'created_at');
        if (!$dataRow->exists) {
            $dataRow->fill(['type' => 'timestamp', 'display_name' => 'Created At', 'details' => '', 'order'=> 9,
                'required' => 0, 'browse' => 1, 'read' => 1, 'edit' => 0, 'add' => 0, 'delete' => 0,
            ])->save();
        }

        $dataRow = $this->dataRow($projectDataType, 'updated_at');
        if (!$dataRow->exists) {
            $dataRow->fill(['type' => 'timestamp', 'display_name' => 'Updated At', 'details' => '', 'order'=> 10,
                'required' => 0, 'browse' => 0, 'read' => 0, 'edit' => 0, 'add' => 0, 'delete' => 0,
            ])->save();
        }

        $dataRow = $this->dataRow($projectDataType, 'deleted_at');
        if (!$dataRow->exists) {
            $dataRow->fill(['type' => 'timestamp', 'display_name' => 'Deleted At', 'details' => '', 'order'=> 11,
                'required' => 0, 'browse' => 0, 'read' => 0, 'edit' => 0, 'add' => 0, 'delete' => 0,
            ])->save();
        }

        $dataRow = $this->dataRow($projectDataType, 'project_belongsto_org_relationship');
        if (!$dataRow->exists) {
            $dataRow->fill(['type' => 'relationship', 'display_name' => 'Org',
                'required' => 0, 'browse' => 1, 'read' => 1, 'edit' => 1, 'add' => 1, 'delete' => 0,
                'details' => '{"model":"App\\\Org","table":"orgs","type":"belongsTo","column":"org_id","key":"id","label":"name","pivot_table":"orgs","pivot":"0"}',
                'order' => 12,
            ])->save();
        }

        $dataRow = $this->dataRow($projectDataType, 'project_belongsto_projectstatus_relationship');
        if (!$dataRow->exists) {
            $dataRow->fill(['type' => 'relationship', 'display_name' => 'Status',
                'required' => 0, 'browse' => 1, 'read' => 1, 'edit' => 1, 'add' => 1, 'delete' => 0,
                'details' => '{"model":"App\\\ProjectStatus","table":"project_status","type":"belongsTo","column":"status_id","key":"id","label":"display_name","pivot_table":"project_status","pivot":"0"}',
                'order' => 13,
            ])->save();
        }
    }

    protected function dataRowTaphonomys()
    {
        $taphonomyDataType = DataType::where('slug', 'taphonomys')->firstOrFail();

        $dataRow = $this->dataRow($taphonomyDataType, 'id');
        if (!$dataRow->exists) {
            $dataRow->fill(['type' => 'number', 'display_name' => 'ID', 'details' => '', 'order' => 1,
                'required' => 1, 'browse' => 0, 'read' => 0, 'edit' => 0, 'add' => 0, 'delete' => 0,
            ])->save();
        }

        $dataRow = $this->dataRow($taphonomyDataType, 'branch');
        if (!$dataRow->exists) {
            $dataRow->fill(['type' => 'text', 'display_name' => 'Branch', 'details' => '', 'order' => 2,
                'required' => 1, 'browse' => 1, 'read' => 1, 'edit' => 1, 'add' => 1, 'delete' => 1,
            ])->save();
        }

        $dataRow = $this->dataRow($taphonomyDataType, 'category');
        if (!$dataRow->exists) {
            $dataRow->fill(['type' => 'text', 'display_name' => 'Category', 'details' => '', 'order' => 3,
                'required' => 1, 'browse' => 1, 'read' => 1, 'edit' => 1, 'add' => 1, 'delete' => 1,
            ])->save();
        }

        $dataRow = $this->dataRow($taphonomyDataType, 'type');
        if (!$dataRow->exists) {
            $dataRow->fill(['type' => 'text', 'display_name' => 'Type', 'details' => '', 'order' => 4,
                'required' => 1, 'browse' => 1, 'read' => 1, 'edit' => 1, 'add' => 1, 'delete' => 1,
            ])->save();
        }

        $dataRow = $this->dataRow($taphonomyDataType, 'subtype');
        if (!$dataRow->exists) {
            $dataRow->fill(['type' => 'text', 'display_name' => 'SubType', 'details' => '', 'order' => 5,
                'required' => 1, 'browse' => 1, 'read' => 1, 'edit' => 1, 'add' => 1, 'delete' => 1,
            ])->save();
        }

        $dataRow = $this->dataRow($taphonomyDataType, 'created_by');
        if (!$dataRow->exists) {
            $dataRow->fill(['type' => 'text', 'display_name' => 'Created By', 'details' => '', 'order'=> 6,
                'required' => 0, 'browse' => 0, 'read' => 0, 'edit' => 0, 'add' => 0, 'delete' => 0,
            ])->save();
        }

        $dataRow = $this->dataRow($taphonomyDataType, 'updated_by');
        if (!$dataRow->exists) {
            $dataRow->fill(['type' => 'text', 'display_name' => 'Updated By', 'details' => '', 'order'=> 7,
                'required' => 0, 'browse' => 0, 'read' => 0, 'edit' => 0, 'add' => 0, 'delete' => 0,
            ])->save();
        }

        $dataRow = $this->dataRow($taphonomyDataType, 'created_at');
        if (!$dataRow->exists) {
            $dataRow->fill(['type' => 'timestamp', 'display_name' => 'Created At', 'details' => '', 'order'=> 8,
                'required' => 0, 'browse' => 1, 'read' => 1, 'edit' => 0, 'add' => 0, 'delete' => 0,
            ])->save();
        }

        $dataRow = $this->dataRow($taphonomyDataType, 'updated_at');
        if (!$dataRow->exists) {
            $dataRow->fill(['type' => 'timestamp', 'display_name' => 'Updated At', 'details' => '', 'order'=> 9,
                'required' => 0, 'browse' => 0, 'read' => 0, 'edit' => 0, 'add' => 0, 'delete' => 0,
            ])->save();
        }

        $dataRow = $this->dataRow($taphonomyDataType, 'deleted_at');
        if (!$dataRow->exists) {
            $dataRow->fill(['type' => 'timestamp', 'display_name' => 'Deleted At', 'details' => '', 'order'=> 10,
                'required' => 0, 'browse' => 0, 'read' => 0, 'edit' => 0, 'add' => 0, 'delete' => 0,
            ])->save();
        }
    }

    protected function dataRowTraumas()
    {
        $traumaDataType = DataType::where('slug', 'traumas')->firstOrFail();

        $dataRow = $this->dataRow($traumaDataType, 'id');
        if (!$dataRow->exists) {
            $dataRow->fill(['type' => 'number', 'display_name' => 'ID', 'details' => '', 'order' => 1,
                'required' => 1, 'browse' => 0, 'read' => 0, 'edit' => 0, 'add' => 0, 'delete' => 0,
            ])->save();
        }

        $dataRow = $this->dataRow($traumaDataType, 'timing');
        if (!$dataRow->exists) {
            $dataRow->fill(['type' => 'text', 'display_name' => 'Letter', 'details' => '', 'order' => 2,
                'required' => 1, 'browse' => 1, 'read' => 1, 'edit' => 1, 'add' => 1, 'delete' => 1,
            ])->save();
        }

        $dataRow = $this->dataRow($traumaDataType, 'type');
        if (!$dataRow->exists) {
            $dataRow->fill(['type' => 'text', 'display_name' => 'Category', 'details' => '', 'order' => 3,
                'required' => 1, 'browse' => 1, 'read' => 1, 'edit' => 1, 'add' => 1, 'delete' => 1,
            ])->save();
        }

        $dataRow = $this->dataRow($traumaDataType, 'created_by');
        if (!$dataRow->exists) {
            $dataRow->fill(['type' => 'text', 'display_name' => 'Created By', 'details' => '', 'order'=> 4,
                'required' => 0, 'browse' => 0, 'read' => 0, 'edit' => 0, 'add' => 0, 'delete' => 0,
            ])->save();
        }

        $dataRow = $this->dataRow($traumaDataType, 'updated_by');
        if (!$dataRow->exists) {
            $dataRow->fill(['type' => 'text', 'display_name' => 'Updated By', 'details' => '', 'order'=> 5,
                'required' => 0, 'browse' => 0, 'read' => 0, 'edit' => 0, 'add' => 0, 'delete' => 0,
            ])->save();
        }

        $dataRow = $this->dataRow($traumaDataType, 'created_at');
        if (!$dataRow->exists) {
            $dataRow->fill(['type' => 'timestamp', 'display_name' => 'Created At', 'details' => '', 'order'=> 6,
                'required' => 0, 'browse' => 1, 'read' => 1, 'edit' => 0, 'add' => 0, 'delete' => 0,
            ])->save();
        }

        $dataRow = $this->dataRow($traumaDataType, 'updated_at');
        if (!$dataRow->exists) {
            $dataRow->fill(['type' => 'timestamp', 'display_name' => 'Updated At', 'details' => '', 'order'=> 7,
                'required' => 0, 'browse' => 0, 'read' => 0, 'edit' => 0, 'add' => 0, 'delete' => 0,
            ])->save();
        }

        $dataRow = $this->dataRow($traumaDataType, 'deleted_at');
        if (!$dataRow->exists) {
            $dataRow->fill(['type' => 'timestamp', 'display_name' => 'Deleted At', 'details' => '', 'order'=> 8,
                'required' => 0, 'browse' => 0, 'read' => 0, 'edit' => 0, 'add' => 0, 'delete' => 0,
            ])->save();
        }
    }

    protected function dataRowZones()
    {
        $zoneDataType = DataType::where('slug', 'zones')->firstOrFail();

        $dataRow = $this->dataRow($zoneDataType, 'id');
        if (!$dataRow->exists) {
            $dataRow->fill(['type' => 'number', 'display_name' => 'ID', 'details' => '', 'order' => 1,
                'required' => 1, 'browse' => 0, 'read' => 0, 'edit' => 0, 'add' => 0, 'delete' => 0,
            ])->save();
        }

        $dataRow = $this->dataRow($zoneDataType, 'sb_id');
        if (!$dataRow->exists) {
            $dataRow->fill(['type' => 'number', 'display_name' => 'Org', 'details' => '', 'order' => 2,
                'required' => 1, 'browse' => 1, 'read' => 1, 'edit' => 1, 'add' => 1, 'delete' => 1,
            ])->save();
        }

        $dataRow = $this->dataRow($zoneDataType, 'name');
        if (!$dataRow->exists) {
            $dataRow->fill(['type' => 'text', 'display_name' => 'Name', 'details' => '', 'order' => 3,
                'required' => 1, 'browse' => 1, 'read' => 1, 'edit' => 1, 'add' => 1, 'delete' => 1,
            ])->save();
        }

        $dataRow = $this->dataRow($zoneDataType, 'display_name');
        if (!$dataRow->exists) {
            $dataRow->fill(['type' => 'text', 'display_name' => 'Display Name', 'details' => '', 'order' => 4,
                'required' => 1, 'browse' => 1, 'read' => 1, 'edit' => 1, 'add' => 1, 'delete' => 1,
            ])->save();
        }

        $dataRow = $this->dataRow($zoneDataType, 'description');
        if (!$dataRow->exists) {
            $dataRow->fill(['type' => 'text', 'display_name' => 'Description', 'details' => '', 'order' => 5,
                'required' => 1, 'browse' => 0, 'read' => 1, 'edit' => 1, 'add' => 1, 'delete' => 1,
            ])->save();
        }

        $dataRow = $this->dataRow($zoneDataType, 'created_by');
        if (!$dataRow->exists) {
            $dataRow->fill(['type' => 'text', 'display_name' => 'Created By', 'details' => '', 'order'=> 6,
                'required' => 0, 'browse' => 0, 'read' => 0, 'edit' => 0, 'add' => 0, 'delete' => 0,
            ])->save();
        }

        $dataRow = $this->dataRow($zoneDataType, 'updated_by');
        if (!$dataRow->exists) {
            $dataRow->fill(['type' => 'text', 'display_name' => 'Updated By', 'details' => '', 'order'=> 7,
                'required' => 0, 'browse' => 0, 'read' => 0, 'edit' => 0, 'add' => 0, 'delete' => 0,
            ])->save();
        }

        $dataRow = $this->dataRow($zoneDataType, 'created_at');
        if (!$dataRow->exists) {
            $dataRow->fill(['type' => 'timestamp', 'display_name' => 'Created At', 'details' => '', 'order'=> 8,
                'required' => 0, 'browse' => 1, 'read' => 1, 'edit' => 0, 'add' => 0, 'delete' => 0,
            ])->save();
        }

        $dataRow = $this->dataRow($zoneDataType, 'updated_at');
        if (!$dataRow->exists) {
            $dataRow->fill(['type' => 'timestamp', 'display_name' => 'Updated At', 'details' => '', 'order'=> 9,
                'required' => 0, 'browse' => 0, 'read' => 0, 'edit' => 0, 'add' => 0, 'delete' => 0,
            ])->save();
        }

        $dataRow = $this->dataRow($zoneDataType, 'deleted_at');
        if (!$dataRow->exists) {
            $dataRow->fill(['type' => 'timestamp', 'display_name' => 'Deleted At', 'details' => '', 'order'=> 10,
                'required' => 0, 'browse' => 0, 'read' => 0, 'edit' => 0, 'add' => 0, 'delete' => 0,
            ])->save();
        }

        $dataRow = $this->dataRow($zoneDataType, 'zone_belongsto_sb_relationship');
        if (!$dataRow->exists) {
            $dataRow->fill(['type' => 'relationship', 'display_name' => 'Bone',
                'required' => 0, 'browse' => 1, 'read' => 1, 'edit' => 1, 'add' => 1, 'delete' => 0,
                'details' => '{"model":"App\\\SkeletalBone","table":"skeletal_bones","type":"belongsTo","column":"sb_id","key":"id","label":"name","pivot_table":"skeletal_bones","pivot":"0"}',
                'order' => 11,
            ])->save();
        }
    }

    /**
     * [dataRow description].
     *
     * @param [type] $type  [description]
     * @param [type] $field [description]
     *
     * @return [type] [description]
     */
    protected function dataRow($type, $field)
    {
        return DataRow::firstOrNew([
                'data_type_id' => $type->id,
                'field'        => $field,
            ]);
    }
}

class CoraMenusTableSeeder extends Seeder
{
    /**
     * Auto generated seed file.
     *
     * @return void
     */
    public function run()
    {
        Menu::firstOrCreate([ 'name' => 'main', ]);
        Menu::firstOrCreate([ 'name' => 'org_admin', ]);
    }
}

class CoraMenuItemsTableSeeder extends Seeder
{
    /**
     * Auto generated seed file.
     *
     * @return void
     */
    public function run()
    {
        $this->menuItemsAdmin();
        $this->menuItemsMain();
        $this->menuItemsOrgAdmin();
    }

    protected function menuItemsAdmin()
    {
        Menu::firstOrCreate(['name' => 'temp']);

        if (file_exists(base_path('routes/web.php'))) {
            require base_path('routes/web.php');

            $menu = Menu::where('name', 'temp')->firstOrFail();

            $menuItem = MenuItem::firstOrNew(['menu_id' => $menu->id, 'title' => 'Dashboard', 'url' => '', 'route' => 'voyager.dashboard',]);
            if (!$menuItem->exists) {
                $menuItem->fill(['target' => '_self', 'icon_class' => 'voyager-boat',
                    'color' => null, 'parent_id' => null, 'order' => 1, ])->save();
            }

            $usermgmtMenuItem = MenuItem::firstOrNew(['menu_id' => $menu->id, 'title' => 'User Management', 'url' => '', ]);
            if (!$usermgmtMenuItem->exists) {
                $usermgmtMenuItem->fill(['target' => '_self', 'icon_class' => 'voyager-people',
                    'color' => null, 'parent_id' => null, 'order' => 2, ])->save();
            }

            $menuItem = MenuItem::firstOrNew(['menu_id' => $menu->id, 'title' => 'Roles', 'url' => '', 'route' => 'voyager.roles.index',]);
            if (!$menuItem->exists) {
                $menuItem->fill(['target' => '_self', 'icon_class' => 'voyager-lock',
                    'color' => null, 'parent_id' => $usermgmtMenuItem->id, 'order' => 3, ])->save();
            }

            $menuItem = MenuItem::firstOrNew(['menu_id' => $menu->id, 'title' => 'Users', 'url' => '', 'route' => 'voyager.users.index',]);
            if (!$menuItem->exists) {
                $menuItem->fill([ 'target' => '_self', 'icon_class' => 'voyager-person',
                    'color' => null, 'parent_id' => $usermgmtMenuItem->id, 'order' => 4, ])->save();
            }

            $orgsMenuItem = MenuItem::firstOrNew(['menu_id' => $menu->id, 'title' => 'Org Management', 'url' => '']);
            if (!$orgsMenuItem->exists) {
                $orgsMenuItem->fill(['target' => '_self', 'icon_class' => 'voyager-company',
                    'color' => null, 'parent_id' => null, 'order'=> 10, ])->save();
            }

            $menuItem = MenuItem::firstOrNew(['menu_id' => $menu->id, 'title' => 'Orgs', 'url' => '', 'route' => 'voyager.orgs.index',]);
            if (!$menuItem->exists) {
                $menuItem->fill(['target' => '_self', 'icon_class' => 'voyager-company',
                    'color' => null, 'parent_id' => $orgsMenuItem->id, 'order'=> 11, ])->save();
            }

            $menuItem = MenuItem::firstOrNew(['menu_id' => $menu->id, 'title' => 'Project', 'url' => '', 'route' => 'voyager.projects.index',]);
            if (!$menuItem->exists) {
                $menuItem->fill(['target' => '_self', 'icon_class' => 'voyager-bag',
                    'color' => null, 'parent_id' => $orgsMenuItem->id, 'order' => 12,])->save();
            }

            $menuItem = MenuItem::firstOrNew(['menu_id' => $menu->id, 'title' => 'Accession', 'url' => '', 'route' => 'voyager.accessions.index',]);
            if (!$menuItem->exists) {
                $menuItem->fill(['target' => '_self', 'icon_class' => 'voyager-character',
                    'color' => null, 'parent_id' => $orgsMenuItem->id, 'order' => 13,])->save();
            }

            $menuItem = MenuItem::firstOrNew(['menu_id' => $menu->id, 'title' => 'Instruments', 'url' => '', 'route' => 'voyager.instruments.index',]);
            if (!$menuItem->exists) {
                $menuItem->fill([ 'target' => '_self', 'icon_class' => 'voyager-hammer',
                    'color' => null, 'parent_id' => $orgsMenuItem->id, 'order' => 14, ])->save();
            }

            $menuItem = MenuItem::firstOrNew(['menu_id' => $menu->id, 'title' => 'EULA', 'url' => '', 'route' => 'voyager.eulas.index',]);
            if (!$menuItem->exists) {
                $menuItem->fill(['target' => '_self', 'icon_class' => 'voyager-receipt',
                    'color' => null, 'parent_id' => $orgsMenuItem->id, 'order' => 15,])->save();
            }

            $bonesMenuItem = MenuItem::firstOrNew(['menu_id' => $menu->id, 'title' => 'Bone Management', 'url' => '', ]);
            if (!$bonesMenuItem->exists) {
                $bonesMenuItem->fill(['target' => '_self', 'icon_class' => 'voyager-skull',
                    'color' => null, 'parent_id' => null, 'order' => 20, ])->save();
            }

            $menuItem = MenuItem::firstOrNew(['menu_id' => $menu->id, 'title' => 'Bones', 'url' => '', 'route' => 'voyager.sb.index',]);
            if (!$menuItem->exists) {
                $menuItem->fill(['target' => '_self', 'icon_class' => 'voyager-skull',
                    'color' => null, 'parent_id' => $bonesMenuItem->id, 'order' => 21,])->save();
            }

            $menuItem = MenuItem::firstOrNew(['menu_id' => $menu->id, 'title' => 'Zones', 'url' => '', 'route' => 'voyager.zones.index',]);
            if (!$menuItem->exists) {
                $menuItem->fill(['target' => '_self', 'icon_class' => 'voyager-crop',
                    'color' => null, 'parent_id' => $bonesMenuItem->id, 'order' => 22,])->save();
            }

            $menuItem = MenuItem::firstOrNew(['menu_id' => $menu->id, 'title' => 'Measurements', 'url' => '', 'route' => 'voyager.measurements.index',]);
            if (!$menuItem->exists) {
                $menuItem->fill(['target' => '_self', 'icon_class' => 'voyager-star',
                    'color' => null, 'parent_id' => $bonesMenuItem->id, 'order' => 23,])->save();
            }

            $menuItem = MenuItem::firstOrNew(['menu_id' => $menu->id, 'title' => 'Articulations', 'url' => '', 'route' => 'voyager.articulations.index',]);
            if (!$menuItem->exists) {
                $menuItem->fill(['target' => '_self', 'icon_class' => 'voyager-star',
                    'color' => null, 'parent_id' => $bonesMenuItem->id, 'order' => 24,])->save();
            }

            $menuItem = MenuItem::firstOrNew(['menu_id' => $menu->id, 'title' => 'Taphonomy', 'url' => '', 'route' => 'voyager.taphonomys.index',]);
            if (!$menuItem->exists) {
                $menuItem->fill(['target' => '_self', 'icon_class' => 'voyager-character',
                    'color' => null, 'parent_id' => $bonesMenuItem->id, 'order' => 25,])->save();
            }

            $bioProfileItem = MenuItem::firstOrNew(['menu_id' => $menu->id, 'title' => 'Biological Profile', 'url' => '',]);
            if (!$bioProfileItem->exists) {
                $bioProfileItem->fill(['target' => '_self', 'icon_class' => 'voyager-params',
                    'color' => null, 'parent_id' => null, 'order' => 30,])->save();
            }

            $menuItem = MenuItem::firstOrNew(['menu_id' => $menu->id, 'title' => 'Method', 'url' => '', 'route' => 'voyager.methods.index',]);
            if (!$menuItem->exists) {
                $menuItem->fill(['target' => '_self', 'icon_class' => 'voyager-markdown',
                    'color' => null, 'parent_id' => $bioProfileItem->id, 'order' => 31,])->save();
            }

            $menuItem = MenuItem::firstOrNew(['menu_id' => $menu->id, 'title' => 'MethodFeature', 'url' => '', 'route' => 'voyager.method_features.index',]);
            if (!$menuItem->exists) {
                $menuItem->fill(['target' => '_self', 'icon_class' => 'voyager-facebook',
                    'color' => null, 'parent_id' => $bioProfileItem->id, 'order' => 32,])->save();
            }

            $menuItem = MenuItem::firstOrNew(['menu_id' => $menu->id, 'title' => 'Haplogroup', 'url' => '', 'route' => 'voyager.haplogroups.index',]);
            if (!$menuItem->exists) {
                $menuItem->fill(['target' => '_self', 'icon_class' => 'voyager-tree',
                    'color' => null, 'parent_id' => $bioProfileItem->id, 'order' => 33,])->save();
            }

            $pathologyItem = MenuItem::firstOrNew(['menu_id' => $menu->id, 'title' => 'Pathology', 'url' => '',]);
            if (!$pathologyItem->exists) {
                $pathologyItem->fill(['target' => '_self', 'icon_class' => 'voyager-lab',
                    'color' => null, 'parent_id' => null, 'order' => 40,])->save();
            }

            $menuItem = MenuItem::firstOrNew(['menu_id' => $menu->id, 'title' => 'Pathology', 'url' => '', 'route' => 'voyager.pathologys.index',]);
            if (!$menuItem->exists) {
                $menuItem->fill(['target' => '_self', 'icon_class' => 'voyager-lab',
                    'color' => null, 'parent_id' => $pathologyItem->id, 'order' => 41,])->save();
            }

            $menuItem = MenuItem::firstOrNew(['menu_id' => $menu->id, 'title' => 'Anomaly', 'url' => '', 'route' => 'voyager.anomalys.index',]);
            if (!$menuItem->exists) {
                $menuItem->fill(['target' => '_self', 'icon_class' => 'voyager-bolt',
                    'color' => null, 'parent_id' => $pathologyItem->id, 'order' => 42,])->save();
            }

            $menuItem = MenuItem::firstOrNew(['menu_id' => $menu->id, 'title' => 'Tramua', 'url' => '', 'route' => 'voyager.traumas.index',]);
            if (!$menuItem->exists) {
                $menuItem->fill(['target' => '_self', 'icon_class' => 'voyager-fire',
                    'color' => null, 'parent_id' => $pathologyItem->id, 'order' => 43,])->save();
            }

            $systemMenuItem = MenuItem::firstOrNew(['menu_id' => $menu->id, 'title' => 'System', 'url' => '',]);
            if (!$systemMenuItem->exists) {
                $systemMenuItem->fill(['target' => '_self', 'icon_class' => 'voyager-laptop',
                    'color' => null, 'parent_id' => null, 'order'=> 50, ])->save();
            }

            $menuItem = MenuItem::firstOrNew(['menu_id' => $menu->id, 'title' => 'Project Status', 'url' => '', 'route' => 'voyager.project_status.index',]);
            if (!$menuItem->exists) {
                $menuItem->fill(['target' => '_self', 'icon_class' => 'voyager-star',
                    'color' => null, 'parent_id' => $systemMenuItem->id, 'order' => 51,])->save();
            }

            $menuItem = MenuItem::firstOrNew(['menu_id' => $menu->id, 'title' => 'DNA Analysis Type', 'url' => '', 'route' => 'voyager.dna_analysis_types.index',]);
            if (!$menuItem->exists) {
                $menuItem->fill(['target' => '_self', 'icon_class' => 'voyager-star',
                    'color' => null, 'parent_id' => $systemMenuItem->id, 'order' => 52,])->save();
            }

            $menuItem = MenuItem::firstOrNew(['menu_id' => $menu->id, 'title' => 'Media', 'url' => '', 'route' => 'voyager.media.index',]);
            if (!$menuItem->exists) {
                $menuItem->fill(['target' => '_self', 'icon_class' => 'voyager-images',
                    'color' => null, 'parent_id' => null, 'order' => 60, ])->save();
            }

            $toolsMenuItem = MenuItem::firstOrNew(['menu_id' => $menu->id, 'title' => 'Tools', 'url' => '', ]);
            if (!$toolsMenuItem->exists) {
                $toolsMenuItem->fill(['target' => '_self', 'icon_class' => 'voyager-tools',
                    'color' => null, 'parent_id' => null, 'order' => 70, ])->save();
            }

            $menuItem = MenuItem::firstOrNew(['menu_id' => $menu->id, 'title' => 'Menu Builder', 'url' => '', 'route' => 'voyager.menus.index',]);
            if (!$menuItem->exists) {
                $menuItem->fill(['target' => '_self', 'icon_class' => 'voyager-list',
                    'color' => null, 'parent_id' => $toolsMenuItem->id, 'order' => 71,])->save();
            }

            $menuItem = MenuItem::firstOrNew(['menu_id' => $menu->id, 'title' => 'Database', 'url' => '', 'route' => 'voyager.database.index',]);
            if (!$menuItem->exists) {
                $menuItem->fill(['target' => '_self', 'icon_class' => 'voyager-data',
                    'color' => null, 'parent_id' => $toolsMenuItem->id, 'order' => 72,])->save();
            }

            $menuItem = MenuItem::firstOrNew(['menu_id' => $menu->id, 'title' => 'Compass', 'url' => route('voyager.compass.index', [], false),]);
            if (!$menuItem->exists) {
                $menuItem->fill(['target' => '_self', 'icon_class' => 'voyager-compass',
                    'color' => null, 'parent_id' => $toolsMenuItem->id, 'order' => 73,])->save();
            }

            $menuItem = MenuItem::firstOrNew(['menu_id' => $menu->id, 'title' => 'Hooks', 'url' => route('voyager.hooks', [], false),]);
            if (!$menuItem->exists) {
                $menuItem->fill(['target' => '_self', 'icon_class' => 'voyager-hook',
                    'color' => null, 'parent_id' => $toolsMenuItem->id, 'order' => 74,])->save();
            }

            $menuItem = MenuItem::firstOrNew(['menu_id' => $menu->id, 'title' => 'Settings', 'url' => '', 'route' => 'voyager.settings.index',]);
            if (!$menuItem->exists) {
                $menuItem->fill(['target' => '_self', 'icon_class' => 'voyager-settings',
                    'color' => null, 'parent_id' => null, 'order' => 80, ])->save();
            }

            $tempmenu = Menu::where('name', 'temp')->firstOrFail();
            $adminmenu = Menu::where('name', 'admin')->firstOrFail();
            $adminmenu->name = "admin-old";
            $adminmenu->save();
            $tempmenu->name = "admin";
            $tempmenu->save();
        }
    }

    protected function menuItemsMain()
    {
        if (file_exists(base_path('routes/web.php'))) {
            require base_path('routes/web.php');

            $menu = Menu::where('name', 'main')->firstOrFail();

            $menuItem = MenuItem::firstOrNew(['menu_id' => $menu->id, 'title' => 'Dashboard', 'url' => '', 'route' => 'home',]);
            if (!$menuItem->exists) {
                $menuItem->fill(['target' => '_self', 'icon_class' => 'voyager-boat',
                    'color' => null, 'parent_id' => null, 'order' => 1, ])->save();
            }

            // Specimens Module
            $seMenuItem = MenuItem::firstOrNew(['menu_id' => $menu->id, 'title' => 'Specimens', 'url' => '', ]);
            if (!$seMenuItem->exists) {
                $seMenuItem->fill(['target' => '_self', 'icon_class' => 'voyager-skull',
                    'color' => null, 'parent_id' => null, 'order' => 10, ])->save();
            }

            $menuItem = MenuItem::firstOrNew(['menu_id' => $menu->id, 'title' => 'Search', 'url' => '', 'route' => 'skeletalelements.search',]);
            if (!$menuItem->exists) {
                $menuItem->fill([ 'target' => '_self', 'icon_class' => 'voyager-search',
                    'color' => null, 'parent_id' => $seMenuItem->id, 'order' => 11, ])->save();
            }

            $menuItem = MenuItem::firstOrNew(['menu_id' => $menu->id, 'title' => 'New', 'url' => '', 'route' => 'skeletalelements.create',]);
            if (!$menuItem->exists) {
                $menuItem->fill(['target' => '_self', 'icon_class' => 'voyager-new',
                    'color' => null, 'parent_id' => $seMenuItem->id, 'order' => 12,])->save();
            }

            $menuItem = MenuItem::firstOrNew(['menu_id' => $menu->id, 'title' => 'Reports Dashboard', 'url' => '', 'route' => 'reports.dashboard',]);
            if (!$menuItem->exists) {
                $menuItem->fill([ 'target' => '_self', 'icon_class' => 'voyager-list',
                    'color' => null, 'parent_id' => $seMenuItem->id, 'order' => 13, ])->save();
            }

            // DNA Module
            $dnaMenuItem = MenuItem::firstOrNew(['menu_id' => $menu->id, 'title' => 'DNA', 'url' => '', ]);
            if (!$dnaMenuItem->exists) {
                $dnaMenuItem->fill(['target' => '_self', 'icon_class' => 'voyager-skull',
                    'color' => null, 'parent_id' => null, 'order' => 20, ])->save();
            }

            $menuItem = MenuItem::firstOrNew(['menu_id' => $menu->id, 'title' => 'Search', 'url' => '', 'route' => 'dnas.search',]);
            if (!$menuItem->exists) {
                $menuItem->fill([ 'target' => '_self', 'icon_class' => 'voyager-search',
                    'color' => null, 'parent_id' => $dnaMenuItem->id, 'order' => 21, ])->save();
            }

            $menuItem = MenuItem::firstOrNew(['menu_id' => $menu->id, 'title' => 'mtDNA Report', 'url' => '', 'route' => 'reports.mtdna.search',]);
            if (!$menuItem->exists) {
                $menuItem->fill([ 'target' => '_self', 'icon_class' => 'voyager-list',
                    'color' => null, 'parent_id' => $dnaMenuItem->id, 'order' => 22, ])->save();
            }
        }
    }

    protected function menuItemsOrgAdmin()
    {
        if (file_exists(base_path('routes/web.php'))) {
            require base_path('routes/web.php');

            $menu = Menu::where('name', 'org_admin')->firstOrFail();

            $adminMenuItem = MenuItem::firstOrNew(['menu_id' => $menu->id, 'title' => 'Administration', 'url' => '', ]);
            if (!$adminMenuItem->exists) {
                $adminMenuItem->fill(['target' => '_self', 'icon_class' => 'voyager-cog',
                    'color' => null, 'parent_id' => null, 'order' => 90, ])->save();
            }

            $menuItem = MenuItem::firstOrNew(['menu_id' => $menu->id, 'title' => 'User Management', 'url' => '', 'route' => 'users.index',]);
            if (!$menuItem->exists) {
                $menuItem->fill([ 'target' => '_self', 'icon_class' => 'voyager-users',
                    'color' => null, 'parent_id' => $adminMenuItem->id, 'order' => 91, ])->save();
            }

            $menuItem = MenuItem::firstOrNew(['menu_id' => $menu->id, 'title' => 'Project Management', 'url' => '', 'route' => 'projects.index',]);
            if (!$menuItem->exists) {
                $menuItem->fill(['target' => '_self', 'icon_class' => 'voyager-bolt',
                    'color' => null, 'parent_id' => $adminMenuItem->id, 'order' => 92,])->save();
            }

            $menuItem = MenuItem::firstOrNew(['menu_id' => $menu->id, 'title' => 'Accession Management', 'url' => '', 'route' => 'accessions.index',]);
            if (!$menuItem->exists) {
                $menuItem->fill(['target' => '_self', 'icon_class' => 'voyager-key',
                    'color' => null, 'parent_id' => $adminMenuItem->id, 'order' => 93,])->save();
            }

            $menuItem = MenuItem::firstOrNew(['menu_id' => $menu->id, 'title' => 'Instrument Management', 'url' => '', 'route' => 'instruments.index',]);
            if (!$menuItem->exists) {
                $menuItem->fill(['target' => '_self', 'icon_class' => 'voyager-compass',
                    'color' => null, 'parent_id' => $adminMenuItem->id, 'order' => 93,])->save();
            }
        }
    }
}

class CoraPermissionsTableSeeder extends Seeder
{
    /**
     * Auto generated seed file.
     */
    public function run()
    {
        Permission::generateFor('orgs');
        Permission::generateFor('skeletal_bones');
        Permission::generateFor('skeletal_elements');
        Permission::generateFor('accessions');
        Permission::generateFor('anomalys');
        Permission::generateFor('articulations');
        Permission::generateFor('dnas');
        Permission::generateFor('dna_analysis_types');
        Permission::generateFor('eulas');
        Permission::generateFor('haplogroups');
        Permission::generateFor('incidents');
        Permission::generateFor('instruments');
        Permission::generateFor('measurements');
        Permission::generateFor('method_features');
        Permission::generateFor('methods');
        Permission::generateFor('pathologys');
        Permission::generateFor('profiles');
        Permission::generateFor('project_status');
        Permission::generateFor('projects');
        Permission::generateFor('sites');
        Permission::generateFor('tags');
        Permission::generateFor('taphonomys');
        Permission::generateFor('traumas');
        Permission::generateFor('zones');
    }
}

class CoraPermissionRoleTableSeeder extends Seeder
{
    /**
     * Auto generated seed file.
     *
     * @return void
     */
    public function run()
    {
        $this->permissionsforRoleAdmin();
        $this->permissionsforRoleOrgAdmin();
        $this->permissionsforRoleManager();
        $this->permissionsforRoleAnthropologist();
        $this->permissionsforRoleDnaAnalyst();
    }

    protected function permissionsforRoleAdmin()
    {
        $role = Role::where('name', 'admin')->firstOrFail();
        $permissions = Permission::all();

        $role->permissions()->sync(
            $permissions->pluck('id')->all()
        );
    }

    protected function permissionsforRoleOrgAdmin()
    {
        $role = Role::where('name', 'orgadmin')->firstOrFail();
        $permissions = Permission::all();

        $role->permissions()->attach($permissions->where('key', '=', 'browse_admin')->pluck('id')->all());
        $role->permissions()->attach($permissions->where('key', '=', 'read_orgs')->pluck('id')->all());
        $role->permissions()->attach($permissions->where('table_name', '=', 'users')->pluck('id')->all());
        $role->permissions()->detach($permissions->where('key', '=', 'delete_users')->pluck('id')->all());
        $role->permissions()->attach($permissions->where('table_name', '=', 'projects')->pluck('id')->all());
        $role->permissions()->detach($permissions->where('key', '=', 'delete_projects')->pluck('id')->all());

        $role->permissions()->attach($permissions->where('table_name', '=', 'accessions')->pluck('id')->all());
        $role->permissions()->attach($permissions->where('table_name', '=', 'incidents')->pluck('id')->all());
        $role->permissions()->attach($permissions->where('table_name', '=', 'instruments')->pluck('id')->all());
        $role->permissions()->attach($permissions->where('table_name', '=', 'sites')->pluck('id')->all());

        $role->permissions()->attach($permissions->where('table_name', '=', 'skeletal_elements')->pluck('id')->all());
        $role->permissions()->attach($permissions->where('table_name', '=', 'dnas')->pluck('id')->all());
    }

    protected function permissionsforRoleManager()
    {
        $role = Role::where('name', 'manager')->firstOrFail();
        $permissions = Permission::all();

        $role->permissions()->attach($permissions->where('key', '=', 'browse_admin')->pluck('id')->all());
        $role->permissions()->attach($permissions->where('key', '=', 'browse_users')->pluck('id')->all());
        $role->permissions()->attach($permissions->where('key', '=', 'read_orgs')->pluck('id')->all());

        $role->permissions()->attach($permissions->where('table_name', '=', 'accessions')->pluck('id')->all());
        $role->permissions()->attach($permissions->where('table_name', '=', 'incidents')->pluck('id')->all());
        $role->permissions()->attach($permissions->where('table_name', '=', 'instruments')->pluck('id')->all());
        $role->permissions()->attach($permissions->where('table_name', '=', 'projects')->pluck('id')->all());
        $role->permissions()->attach($permissions->where('table_name', '=', 'sites')->pluck('id')->all());

        $role->permissions()->attach($permissions->where('table_name', '=', 'skeletal_elements')->pluck('id')->all());
        $role->permissions()->attach($permissions->where('table_name', '=', 'dnas')->pluck('id')->all());
    }

    protected function permissionsforRoleAnthropologist()
    {
        $role = Role::where('name', 'anthropologist')->firstOrFail();
        $permissions = Permission::all();

        $role->permissions()->attach($permissions->where('table_name', '=', 'skeletal_elements')->pluck('id')->all());
        $role->permissions()->attach($permissions->where('table_name', '=', 'dnas')->pluck('id')->all());
    }

    protected function permissionsforRoleDnaAnalyst()
    {
        $role = Role::where('name', 'dna-analyst')->firstOrFail();
        $permissions = Permission::all();

        $role->permissions()->attach($permissions->where('key', '=', 'browse_skeletal_elements')->pluck('id')->all());
        $role->permissions()->attach($permissions->where('key', '=', 'read_skeletal_elements')->pluck('id')->all());
        $role->permissions()->attach($permissions->where('table_name', '=', 'dnas')->pluck('id')->all());
    }
}
