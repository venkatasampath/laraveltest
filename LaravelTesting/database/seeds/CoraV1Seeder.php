<?php
/**
 * Cora Database Seeder
 *
 * @category   Cora Database
 * @package    Seeder
 * @author     Sachin Pawaskar<spawaskar@unomaha.edu>
 * @copyright  2016-2018
 * @license    The MIT License (MIT)
 * @version    GIT: $Id$
 * @since      File available since Release 1.0.0
 */

use App\Media;
use App\Profile;
use App\Project;
use App\Utility\Memory;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use TCG\Voyager\Models\DataRow;
use TCG\Voyager\Models\DataType;
use TCG\Voyager\Models\Menu;
use TCG\Voyager\Models\MenuItem;
use TCG\Voyager\Models\Permission;
use TCG\Voyager\Models\Role;

class CoraV1Seeder extends Seeder
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
        $this->command->info('      Start: Seeding CoRA Version 1 Data                                !');
        $this->command->info('------------------------------------------------------------------------!');
        $this->createImportFileTypes();
        $this->createProjectSESummaries();
        $this->createProjectDNASummaries();
        $this->createExportMaps();
        $this->createProfiles();
        $this->createImportCSVFileTableMaps();
        $this->createMedias();
        $this->updateProjectsGeoLatLong();

        // Perform Voyager upgrade from 1.0 to 1.1
        $this->voyager1dot1Upgrade();

        // Call seeder outside this file/class.
        $this->call(SkeletalBonesTableSeeder::class);
        $this->call(ArticulationsTableSeeder::class);
        $this->call(BoneGroupsTableSeeder::class);
        $this->call(MeasurementsTableSeeder::class);
        $this->call(MethodsTableSeeder::class);
        $this->call(MethodFeaturesTableSeeder::class);
        $this->call(ZonesTableSeeder::class);

        $this->command->info('------------------------------------------------------------------------!');
        $this->command->info('        End: Seeding CoRA Version 1 Data                                !');
        $this->command->info('------------------------------------------------------------------------!');

        Memory::dump_usage(true);
    }

    protected function voyager1dot1Upgrade()
    {
        $userDataType = DataType::where('slug', 'users')->firstOrFail();
        $dataRow = DataRow::firstOrNew(['data_type_id' => $userDataType->id, 'field' => 'user_belongstomany_role_relationship']);
        if (!$dataRow->exists) {
            $dataRow->fill([
                'type'         => 'relationship',
                'display_name' => 'Roles',
                'required'     => 0,
                'browse'       => 1,
                'read'         => 1,
                'edit'         => 1,
                'add'          => 1,
                'delete'       => 0,
                'details'      => '{"model":"TCG\\Voyager\\Models\\Role","table":"roles","type":"belongsToMany","column":"id","key":"id","label":"display_name","pivot_table":"user_roles","pivot":"1"}',
                'order'        => 10,
            ])->save();
        }

        // Create 'browse_bread' permission if it does not exist
        Permission::firstOrCreate(['key' => 'browse_bread', 'table_name' => null,]);
        Permission::firstOrCreate(['key' => 'browse_hooks', 'table_name' => null,]);

        // Sync the permissions for role "admin"
        $role = Role::where('name', 'admin')->firstOrFail();
        $permissions = Permission::all();
        $role->permissions()->sync( $permissions->pluck('id')->all() );


        // Create 'BREAD' menuitem for admin menu
        $menu = Menu::where('name', 'admin')->firstOrFail();
        $toolsMenuItem = MenuItem::firstOrNew(['menu_id' => $menu->id, 'title' => 'Tools', 'url'  => '',]);
        $menuItem = MenuItem::firstOrNew([
            'menu_id'    => $menu->id,
            'title'      => 'BREAD',
            'url'        => '',
            'route'      => 'voyager.bread.index',
        ]);
        if (!$menuItem->exists) {
            $menuItem->fill([
                'target'     => '_self',
                'icon_class' => 'voyager-bread',
                'color'      => null,
                'parent_id'  => $toolsMenuItem->id,
                'order'      => 5,
            ])->save();
        }
    }

    protected function createImportFileTypes()
    {
        DB::table('import_file_types')->delete();
        $dt = date_create();
        $sys = 'System';

        DB::table('import_file_types')->insert(array(array('name'=>'se', 'table_names'=>'skeletal_elements', 'display_name'=>'Specimens', 'template_location' => 'assets/templates/se_sample_template.csv', 'created_by'=>$sys, 'updated_by'=>$sys, 'created_at'=>$dt, 'updated_at'=>$dt )));
        DB::table('import_file_types')->insert(array(array('name'=>'zones', 'table_names'=>'se_zone', 'display_name'=>'Zones', 'template_location' => 'assets/templates/se_zone_sample_template.csv', 'created_by'=>$sys, 'updated_by'=>$sys, 'created_at'=>$dt, 'updated_at'=>$dt )));
        DB::table('import_file_types')->insert(array(array('name'=>'measurements', 'table_names'=>'se_measurements', 'display_name'=>'Measurements', 'template_location' => 'assets/templates/se_measurement_sample_template.csv', 'created_by'=>$sys, 'updated_by'=>$sys, 'created_at'=>$dt, 'updated_at'=>$dt )));
        DB::table('import_file_types')->insert(array(array('name'=>'dna', 'table_names'=>'dnas', 'display_name'=>'DNA', 'template_location' => 'assets/templates/dna_sample_template.csv', 'created_by'=>$sys, 'updated_by'=>$sys, 'created_at'=>$dt, 'updated_at'=>$dt )));
        DB::table('import_file_types')->insert(array(array('name'=>'pairs', 'table_names'=>'se_pair', 'display_name'=>'Pairs', 'template_location' => 'assets/templates/se_pair_sample_template.csv', 'created_by'=>$sys, 'updated_by'=>$sys, 'created_at'=>$dt, 'updated_at'=>$dt )));
        DB::table('import_file_types')->insert(array(array('name'=>'articulations', 'table_names'=>'se_articulation', 'display_name'=>'Articulations', 'template_location' => 'assets/templates/se_articulation_sample_template.csv', 'created_by'=>$sys, 'updated_by'=>$sys, 'created_at'=>$dt, 'updated_at'=>$dt )));
    }

    protected function createProjectSESummaries()
    {
        $dt = Carbon::now();
        $sys = 'System';

        DB::table('project_se_summary')->insert(array(array('project_id'=>1, 'se_total'=>75, 'num_complete'=>50, 'num_measured'=>60, 'num_dna_sampled'=>40, 'num_isotope_sampled'=>30, 'num_ct_scanned'=>6, 'num_xray_scanned'=>6,
            'num_clavicle_triage'=>6, 'num_inventoried'=>50, 'num_reviewed'=>20, 'num_individuals'=>12, 'num_unique_individuals'=>3, 'created_by'=>$sys, 'updated_by'=>$sys, 'created_at'=>$dt , 'updated_at'=>$dt )));
        $dt = $dt->subDay(1);
        DB::table('project_se_summary')->insert(array(array('project_id'=>1, 'se_total'=>55, 'num_complete'=>45, 'num_measured'=>40, 'num_dna_sampled'=>25, 'num_isotope_sampled'=>20, 'num_ct_scanned'=>6, 'num_xray_scanned'=>6,
            'num_clavicle_triage'=>6, 'num_inventoried'=>35, 'num_reviewed'=>15, 'num_individuals'=>6, 'num_unique_individuals'=>2, 'created_by'=>$sys, 'updated_by'=>$sys, 'created_at'=>$dt , 'updated_at'=>$dt )));
        $dt = $dt->subDay(1);
        DB::table('project_se_summary')->insert(array(array('project_id'=>1, 'se_total'=>45, 'num_complete'=>35, 'num_measured'=>30, 'num_dna_sampled'=>15, 'num_isotope_sampled'=>12, 'num_ct_scanned'=>3, 'num_xray_scanned'=>3,
            'num_clavicle_triage'=>3, 'num_inventoried'=>25, 'num_reviewed'=>10, 'num_individuals'=>3, 'num_unique_individuals'=>1, 'created_by'=>$sys, 'updated_by'=>$sys, 'created_at'=>$dt , 'updated_at'=>$dt )));
        $dt = $dt->subDay(1);
        DB::table('project_se_summary')->insert(array(array('project_id'=>1, 'se_total'=>35, 'num_complete'=>25, 'num_measured'=>20, 'num_dna_sampled'=>10, 'num_isotope_sampled'=>8, 'num_ct_scanned'=>3, 'num_xray_scanned'=>3,
            'num_clavicle_triage'=>3, 'num_inventoried'=>15, 'num_reviewed'=>3, 'num_individuals'=>3, 'num_unique_individuals'=>1, 'created_by'=>$sys, 'updated_by'=>$sys, 'created_at'=>$dt, 'updated_at'=>$dt )));
        $dt = $dt->subDay(1);
        DB::table('project_se_summary')->insert(array(array('project_id'=>1, 'se_total'=>25, 'num_complete'=>15, 'num_measured'=>10, 'num_dna_sampled'=>5, 'num_isotope_sampled'=>2, 'num_ct_scanned'=>3, 'num_xray_scanned'=>3,
            'num_clavicle_triage'=>3, 'num_inventoried'=>5, 'num_reviewed'=>3, 'num_individuals'=>3, 'num_unique_individuals'=>1, 'created_by'=>$sys, 'updated_by'=>$sys, 'created_at'=>$dt, 'updated_at'=>$dt )));
    }

    protected function createProjectDNASummaries()
    {
        $dt = Carbon::now();
        $sys = 'System';

        DB::table('project_dna_summary')->insert(array(array('project_id'=>1, 'se_total'=>75, 'num_sampled'=>40, 'num_results_received'=>30, 'num_results_reportable'=>15, 'num_results_inconclusive'=>6,
            'num_results_unable_to_assign'=>6, 'num_results_cancelled'=>3, 'num_mito_sequences'=>20, 'created_by'=>$sys, 'updated_by'=>$sys, 'created_at'=>$dt , 'updated_at'=>$dt )));
        $dt = $dt->subDay(1);
        DB::table('project_dna_summary')->insert(array(array('project_id'=>1, 'se_total'=>55, 'num_sampled'=>35, 'num_results_received'=>25, 'num_results_reportable'=>13, 'num_results_inconclusive'=>3,
            'num_results_unable_to_assign'=>6, 'num_results_cancelled'=>3, 'num_mito_sequences'=>18, 'created_by'=>$sys, 'updated_by'=>$sys, 'created_at'=>$dt , 'updated_at'=>$dt )));
        $dt = $dt->subDay(1);
        DB::table('project_dna_summary')->insert(array(array('project_id'=>1, 'se_total'=>45, 'num_sampled'=>30, 'num_results_received'=>20, 'num_results_reportable'=>11, 'num_results_inconclusive'=>3,
            'num_results_unable_to_assign'=>3, 'num_results_cancelled'=>3, 'num_mito_sequences'=>15, 'created_by'=>$sys, 'updated_by'=>$sys, 'created_at'=>$dt , 'updated_at'=>$dt )));
        $dt = $dt->subDay(1);
        DB::table('project_dna_summary')->insert(array(array('project_id'=>1, 'se_total'=>35, 'num_sampled'=>25, 'num_results_received'=>15, 'num_results_reportable'=>10, 'num_results_inconclusive'=>3,
            'num_results_unable_to_assign'=>2, 'num_results_cancelled'=>1, 'num_mito_sequences'=>10, 'created_by'=>$sys, 'updated_by'=>$sys, 'created_at'=>$dt , 'updated_at'=>$dt )));
        $dt = $dt->subDay(1);
        DB::table('project_dna_summary')->insert(array(array('project_id'=>1, 'se_total'=>25, 'num_sampled'=>15, 'num_results_received'=>10, 'num_results_reportable'=>6, 'num_results_inconclusive'=>2,
            'num_results_unable_to_assign'=>1, 'num_results_cancelled'=>1, 'num_mito_sequences'=>5, 'created_by'=>$sys, 'updated_by'=>$sys, 'created_at'=>$dt , 'updated_at'=>$dt )));
    }

    protected function createExportMaps()
    {
        DB::table('export_maps')->delete();
        $dt = date_create();
        $sys = 'System';

        DB::table('export_maps')->insert(array(array('name'=>'Base - All', 'group'=>'Base', 'description'=>'Base tables that hold descriptive data for CoRA', 'table_names'=>'skeletal_bones, anomalys, articulations, bone_groups, dna_analysis_types, haplogroups, labs, measurements, methods, method_features, orgs, projects, pathologys, profiles, taphonomys, traumas, zones', 'created_by'=>$sys, 'updated_by'=>$sys, 'created_at'=>$dt, 'updated_at'=>$dt )));
        DB::table('export_maps')->insert(array(array('name'=>'All', 'group'=>'Project', 'description'=>'Specimens and all its associations', 'table_names'=>'skeletal_bones, skeletal_elements, dnas, dna_analysis, dna_resamples, se_measurement, se_zone, se_pair, se_articulation, se_refit, se_taphonomy, se_pathology, se_trauma, se_anomaly, se_method, se_method_feature', 'created_by'=>$sys, 'updated_by'=>$sys, 'created_at'=>$dt, 'updated_at'=>$dt )));
        DB::table('export_maps')->insert(array(array('name'=>'DNA', 'group'=>'Project', 'description'=>'Specimens, DNA and all DNA associations', 'table_names'=>'skeletal_elements, dnas, dna_analysis, dna_resamples', 'created_by'=>$sys, 'updated_by'=>$sys, 'created_at'=>$dt, 'updated_at'=>$dt )));
        DB::table('export_maps')->insert(array(array('name'=>'Measurements', 'group'=>'Project', 'description'=>'Specimens and all its measurements', 'table_names'=>'skeletal_elements, se_measurement', 'created_by'=>$sys, 'updated_by'=>$sys, 'created_at'=>$dt, 'updated_at'=>$dt )));
        DB::table('export_maps')->insert(array(array('name'=>'Zones', 'group'=>'Project', 'description'=>'Specimens and all its zones', 'table_names'=>'skeletal_elements, se_zone', 'created_by'=>$sys, 'updated_by'=>$sys, 'created_at'=>$dt, 'updated_at'=>$dt )));
        DB::table('export_maps')->insert(array(array('name'=>'Associations', 'group'=>'Project', 'description'=>'Specimens and its pair, articualtion and refit associations', 'table_names'=>'skeletal_elements, se_pair, se_articulation, se_refit', 'created_by'=>$sys, 'updated_by'=>$sys, 'created_at'=>$dt, 'updated_at'=>$dt )));
        DB::table('export_maps')->insert(array(array('name'=>'Pairs', 'group'=>'Project', 'description'=>'Specimens and all its pairs', 'table_names'=>'skeletal_elements, se_pair', 'created_by'=>$sys, 'updated_by'=>$sys, 'created_at'=>$dt, 'updated_at'=>$dt )));
        DB::table('export_maps')->insert(array(array('name'=>'Articulations', 'group'=>'Project', 'description'=>'Specimens and all its articulations', 'table_names'=>'skeletal_elements, se_articulation', 'created_by'=>$sys, 'updated_by'=>$sys, 'created_at'=>$dt, 'updated_at'=>$dt )));
        DB::table('export_maps')->insert(array(array('name'=>'Refits', 'group'=>'Project', 'description'=>'Specimens and all its refits', 'table_names'=>'skeletal_elements, se_refit', 'created_by'=>$sys, 'updated_by'=>$sys, 'created_at'=>$dt, 'updated_at'=>$dt )));
        DB::table('export_maps')->insert(array(array('name'=>'Taphonomies', 'group'=>'Project', 'description'=>'Specimens and all its taphonomies', 'table_names'=>'skeletal_elements, se_taphonomy', 'created_by'=>$sys, 'updated_by'=>$sys, 'created_at'=>$dt, 'updated_at'=>$dt )));
        DB::table('export_maps')->insert(array(array('name'=>'Pathology All', 'group'=>'Project', 'description'=>'Specimens and all its pathology, trauma and anomaly associations', 'table_names'=>'skeletal_elements, se_pathology, se_trauma, se_anomaly', 'created_by'=>$sys, 'updated_by'=>$sys, 'created_at'=>$dt, 'updated_at'=>$dt )));
        DB::table('export_maps')->insert(array(array('name'=>'Pathology', 'group'=>'Project', 'description'=>'Specimens and all its pathologies', 'table_names'=>'skeletal_elements, se_pathology', 'created_by'=>$sys, 'updated_by'=>$sys, 'created_at'=>$dt, 'updated_at'=>$dt )));
        DB::table('export_maps')->insert(array(array('name'=>'Trauma', 'group'=>'Project', 'description'=>'Specimens and all its traumas', 'table_names'=>'skeletal_elements, se_trauma', 'created_by'=>$sys, 'updated_by'=>$sys, 'created_at'=>$dt, 'updated_at'=>$dt )));
        DB::table('export_maps')->insert(array(array('name'=>'Anomaly', 'group'=>'Project', 'description'=>'Specimens and all its anomalies', 'table_names'=>'skeletal_elements, se_anomaly', 'created_by'=>$sys, 'updated_by'=>$sys, 'created_at'=>$dt, 'updated_at'=>$dt )));
        DB::table('export_maps')->insert(array(array('name'=>'Methods', 'group'=>'Project', 'description'=>'Specimens and all its method and method features', 'table_names'=>'skeletal_elements, se_method, se_method_feature', 'created_by'=>$sys, 'updated_by'=>$sys, 'created_at'=>$dt, 'updated_at'=>$dt )));
        DB::table('export_maps')->insert(array(array('name'=>'Measurements', 'group'=>'Project-Join', 'description'=>'Specimens and all its measurements', 'query'=>"select sem.measurement_id, m.name, m.display_name, sem.measure, sb.name, se.* FROM skeletal_elements se JOIN se_measurement sem ON se.id = sem.se_id JOIN measurements m ON sem.measurement_id = m.id JOIN skeletal_bones sb ON se.sb_id = sb.id", 'created_by'=>$sys, 'updated_by'=>$sys, 'created_at'=>$dt, 'updated_at'=>$dt )));
        DB::table('export_maps')->insert(array(array('name'=>'Zones', 'group'=>'Project-Join', 'description'=>'Specimens and all its zones', 'query'=>"select sez.zone_id, z.name, z.display_name, sez.presence, sez.element_complete, sb.name, se.* FROM skeletal_elements se JOIN se_zone sez ON se.id = sez.se_id JOIN zones z ON sez.zone_id = z.id JOIN skeletal_bones sb ON se.sb_id = sb.id", 'created_by'=>$sys, 'updated_by'=>$sys, 'created_at'=>$dt, 'updated_at'=>$dt )));
        DB::table('export_maps')->insert(array(array('name'=>'Anomaly', 'group'=>'Project-Join', 'description'=>'Specimens and all its anomalies', 'query'=>"select sea.anomaly_id, a.individuating_trait, sb.name, se.* FROM skeletal_elements se JOIN se_anomaly sea ON se.id = sea.se_id JOIN anomalys a ON sea.anomaly_id = a.id JOIN skeletal_bones sb ON se.sb_id = sb.id", 'created_by'=>$sys, 'updated_by'=>$sys, 'created_at'=>$dt, 'updated_at'=>$dt )));
        DB::table('export_maps')->insert(array(array('name'=>'Pathology', 'group'=>'Project-Join', 'description'=>'Specimens and all its pathologies', 'query'=>"select sep.pathology_id, p.abnormality_category, p.characteristics, sb.name, se.* FROM skeletal_elements se JOIN se_pathology sep ON se.id = sep.se_id JOIN pathologys p ON sep.pathology_id = p.id JOIN skeletal_bones sb ON se.sb_id = sb.id", 'created_by'=>$sys, 'updated_by'=>$sys, 'created_at'=>$dt, 'updated_at'=>$dt )));
        DB::table('export_maps')->insert(array(array('name'=>'Taphonomies', 'group'=>'Project-Join', 'description'=>'Specimens and all its taphonomies', 'query'=>"select seta.taphonomy_id, t.branch, t.category, t.type, t.subtype, sb.name, se.* FROM skeletal_elements se JOIN se_taphonomy seta ON se.id = seta.se_id JOIN taphonomys t ON seta.taphonomy_id = t.id JOIN skeletal_bones sb ON se.sb_id = sb.id", 'created_by'=>$sys, 'updated_by'=>$sys, 'created_at'=>$dt, 'updated_at'=>$dt )));
        DB::table('export_maps')->insert(array(array('name'=>'Trauma', 'group'=>'Project-Join', 'description'=>'Specimens and all its traumas', 'query'=>"select setr.trauma_id, setr.additional_information, tr.timing, tr.type, sb.name, se.* FROM skeletal_elements se JOIN se_trauma setr ON se.id = setr.se_id JOIN traumas tr ON setr.trauma_id = tr.id JOIN skeletal_bones sb ON se.sb_id = sb.id", 'created_by'=>$sys, 'updated_by'=>$sys, 'created_at'=>$dt, 'updated_at'=>$dt )));
        DB::table('export_maps')->insert(array(array('name'=>'Osteometric Sorting', 'group'=>'Project-Join', 'description'=>'Bones and all its measurements', 'query'=>"select se.accession_number, se.provenance1, se.provenance2, se.designator, sb.name as Bone, se.side, me.name, sem.measure from se_measurement as sem JOIN skeletal_elements as se on sem.se_id = se.id JOIN skeletal_bones as sb on se.sb_id = sb.id JOIN measurements as me on me.id = sem.measurement_id where sb.name = 'Clavicle';", 'created_by'=>$sys, 'updated_by'=>$sys, 'created_at'=>$dt, 'updated_at'=>$dt )));

    }

    protected function createProfiles() {
        // System API Keys
        $profile = Profile::firstOrNew(['name'=>'system_api_google_maps']);
        $data = array('name'=>'system_api_google_maps', 'description'=>'System API Key for Google Maps', 'default_value'=>'', 'kind'=>'string',
            'display_type'=>'text', 'display_values'=>'', 'type'=>'system', 'group'=>'api', 'display_order'=>1100,
            'help'=>'Enter the System API Key for Google Maps, this is required to display project information on a map',
            'created_by'=>'System', 'updated_by'=>'System', 'created_at'=>date_create(), 'updated_at'=>date_create());
        (!$profile->exists) ? $profile->fill($data)->save() : $profile->fill(array_except($data, ['created_at']))->save();

        $profile = Profile::firstOrNew(['name'=>'system_api_slack_webhook']);
        $data = array('name'=>'system_api_slack_webhook', 'description'=>'System API URL for slack messages', 'default_value'=>'', 'kind'=>'string',
            'display_type'=>'text', 'display_values'=>'', 'type'=>'system', 'group'=>'api', 'display_order'=>1101,
            'help'=>'Enter the System API URL for Slack Webhook, this is required to send messages via slack',
            'created_by'=>'System', 'updated_by'=>'System', 'created_at'=>date_create(), 'updated_at'=>date_create());
        (!$profile->exists) ? $profile->fill($data)->save() : $profile->fill(array_except($data, ['created_at']))->save();

        $profile = Profile::firstOrNew(['name'=>'system_api_slack_channel']);
        $data = array('name'=>'system_api_slack_channel', 'description'=>'System slack channel to send messages to', 'default_value'=>'', 'kind'=>'string',
            'display_type'=>'text', 'display_values'=>'', 'type'=>'system', 'group'=>'api', 'display_order'=>1102,
            'help'=>'Enter the System Slack Channel, this is the channel that the slack messages will be sent to',
            'created_by'=>'System', 'updated_by'=>'System', 'created_at'=>date_create(), 'updated_at'=>date_create());
        (!$profile->exists) ? $profile->fill($data)->save() : $profile->fill(array_except($data, ['created_at']))->save();


        // Org profiles
        $profile = Profile::firstOrNew(['name'=>'add_cora_demo_project_for_new_users']);
        $data = array('name'=>'add_cora_demo_project_for_new_users', 'description'=>'Add Project CoRA Demo for New Users', 'default_value'=>'true', 'kind'=>'bool',
            'display_type'=>'checkbox', 'display_values'=>'', 'type'=>'org', 'group'=>'user', 'display_order'=>2000,
            'help'=>'Checking this box will automatically add the CoRA Demo project for new users created in this organization.',
            'created_by'=>'System', 'updated_by'=>'System', 'created_at'=>date_create(), 'updated_at'=>date_create());
        (!$profile->exists) ? $profile->fill($data)->save() : $profile->fill(array_except($data, ['created_at']))->save();

        $profile = Profile::firstOrNew(['name'=>'org_mass_unit_of_measure']);
        $data = array('name'=>'org_mass_unit_of_measure', 'description'=>'Mass - Unit of Measure', 'default_value'=>'grams', 'kind'=>'string',
            'display_type'=>'select', 'display_values'=>'{"grams":"grams", "ounces":"ounces"}', 'type'=>'org', 'group'=>'project', 'display_order'=>2001,
            'help'=>'Unit of measure used for mass/weight fields within all projects in this organization',
            'created_by'=>'System', 'updated_by'=>'System', 'created_at'=>date_create(), 'updated_at'=>date_create());
        (!$profile->exists) ? $profile->fill($data)->save() : $profile->fill(array_except($data, ['created_at']))->save();

        $profile = Profile::firstOrNew(['name'=>'org_length_unit_of_measure']);
        $data = array('name'=>'org_length_unit_of_measure', 'description'=>'Length - Unit of Measure', 'default_value'=>'cm', 'kind'=>'string',
            'display_type'=>'select', 'display_values'=>'{"cm":"cm", "mm":"mm", "inches":"inches"}', 'type'=>'org', 'group'=>'project', 'display_order'=>2002,
            'help'=>'Unit of measure used for length/measurement fields within all projects in this organization',
            'created_by'=>'System', 'updated_by'=>'System', 'created_at'=>date_create(), 'updated_at'=>date_create());
        (!$profile->exists) ? $profile->fill($data)->save() : $profile->fill(array_except($data, ['created_at']))->save();

        // Org API Keys
        $profile = Profile::firstOrNew(['name'=>'org_api_google_maps']);
        $data = array('name'=>'org_api_google_maps', 'description'=>'Organization API Key for Google Maps', 'default_value'=>'', 'kind'=>'string',
            'display_type'=>'text', 'display_values'=>'', 'type'=>'org', 'group'=>'api', 'display_order'=>2020,
            'help'=>'Enter the Organization API Key for Google Maps, this is required to display project information on a map',
            'created_by'=>'System', 'updated_by'=>'System', 'created_at'=>date_create(), 'updated_at'=>date_create());
        (!$profile->exists) ? $profile->fill($data)->save() : $profile->fill(array_except($data, ['created_at']))->save();

        $profile = Profile::firstOrNew(['name'=>'org_api_slack_webhook']);
        $data = array('name'=>'org_api_slack_webhook', 'description'=>'Organization API URL for slack messages', 'default_value'=>'', 'kind'=>'string',
            'display_type'=>'text', 'display_values'=>'', 'type'=>'org', 'group'=>'api', 'display_order'=>2021,
            'help'=>'Enter the Organization API URL for Slack Webhook, this is required to send messages via slack',
            'created_by'=>'System', 'updated_by'=>'System', 'created_at'=>date_create(), 'updated_at'=>date_create());
        (!$profile->exists) ? $profile->fill($data)->save() : $profile->fill(array_except($data, ['created_at']))->save();

        $profile = Profile::firstOrNew(['name'=>'org_api_slack_channel']);
        $data = array('name'=>'org_api_slack_channel', 'description'=>'Organization slack channel to send messages to', 'default_value'=>'', 'kind'=>'string',
            'display_type'=>'text', 'display_values'=>'', 'type'=>'org', 'group'=>'api', 'display_order'=>2022,
            'help'=>'Enter the Organization Slack Channel, this is the channel that the org slack messages will be sent to',
            'created_by'=>'System', 'updated_by'=>'System', 'created_at'=>date_create(), 'updated_at'=>date_create());
        (!$profile->exists) ? $profile->fill($data)->save() : $profile->fill(array_except($data, ['created_at']))->save();


        // User profiles
        $profile = Profile::firstOrNew(['name'=>'se_search_open_in_new_browser_tab']);
        $data = array('name'=>'se_search_open_in_new_browser_tab', 'description'=>'Search Open SE in New Browser Tab', 'default_value'=>'true', 'kind'=>'bool',
            'display_type'=>'checkbox', 'display_values'=>'', 'type'=>'user', 'group'=>'se', 'display_order'=>2100,
            'help'=>'Clicking a Specimen on Search screen are opened in a new tab.',
            'created_by'=>'System', 'updated_by'=>'System', 'created_at'=>date_create(), 'updated_at'=>date_create());
        (!$profile->exists) ? $profile->fill($data)->save() : $profile->fill(array_except($data, ['created_at']))->save();

        $profile = Profile::firstOrNew(['name'=>'se_new_redirect_url']);
        $data = array('name'=>'se_new_redirect_url', 'description'=>'New SE redirect URL', 'default_value'=>'None', 'kind'=>'string',
            'display_type'=>'select', 'display_values'=>'{"None":"None", "Zones":"Zones", "Measurements":"Measurements", "Taphonomy":"Taphonomy", "Pathology":"Pathology", "Trauma":"Trauma", "Anomaly":"Anomaly"}', 'type'=>'user', 'group'=>'se', 'display_order'=>2101,
            'help'=>'After the creation of new SE redirect to URL to a specific SE association',
            'created_by'=>'System', 'updated_by'=>'System', 'created_at'=>date_create(), 'updated_at'=>date_create());
        (!$profile->exists) ? $profile->fill($data)->save() : $profile->fill(array_except($data, ['created_at']))->save();

        $profile = Profile::firstOrNew(['name'=>'default_search_option']);
        $data = array('name'=>'default_search_option', 'description'=>'Default search option to use for quick search', 'default_value'=>'SE-SB', 'kind'=>'string',
            'display_type'=>'select', 'display_values'=>'{"SE-SB":"Bone", "SE-CK":"Composite Key", "SE-AN":"Accession", "SE-P1":"Provenance 1", "SE-P2":"Provenance 2", "SE-DN":"Designator", "SE-EN":"External ID", "SE-IN":"Individual Number",
                    "DNA-SB":"DNA:Bone", "DNA-CK":"DNA:Composite Key", "DNA-AN":"DNA:Accession", "DNA-SN":"DNA:Sample Number", "DNA-MS":"DNA:Mito Seq Number", "DNA-HG":"DNA:Haplogroup", "DNA-EN":"DNA:External ID", "DNA-IN":"DNA:Individual Number"}',
            'type'=>'user', 'group'=>'project', 'display_order'=>2102,
            'help'=>'User configurable default search option to use for quick search',
            'created_by'=>'System', 'updated_by'=>'System', 'created_at'=>date_create(), 'updated_at'=>date_create());
        (!$profile->exists) ? $profile->fill($data)->save() : $profile->fill(array_except($data, ['created_at']))->save();

        $profile = Profile::firstOrNew(['name'=>'default_dna_method']);
        $data = array('name'=>'default_dna_method', 'description'=>'Default DNA Method', 'default_value'=>'Sanger', 'kind'=>'string',
            'display_type'=>'select', 'display_values'=>'{"NGS":"NGS", "Sanger":"Sanger"}', 'type'=>'user', 'group'=>'dna', 'display_order'=>2103,
            'help'=>'The DNA method will be auto-populated on DNA association screen for Specimen',
            'created_by'=>'System', 'updated_by'=>'System', 'created_at'=>date_create(), 'updated_at'=>date_create());
        (!$profile->exists) ? $profile->fill($data)->save() : $profile->fill(array_except($data, ['created_at']))->save();

        // User Notifications
        $profile = Profile::firstOrNew(['name'=>'notify_export_import_completion']);
        $data = array('name'=>'notify_export_import_completion', 'description'=>'Export/Import Job Completion', 'default_value'=>'true', 'kind'=>'bool',
            'display_type'=>'checkbox', 'display_values'=>'', 'type'=>'user', 'group'=>'se', 'display_order'=>2100,
            'help'=>'Notify the user when either and export or import job is completed that was initiated by that user',
            'created_by'=>'System', 'updated_by'=>'System', 'created_at'=>date_create(), 'updated_at'=>date_create());
        (!$profile->exists) ? $profile->fill($data)->save() : $profile->fill(array_except($data, ['created_at']))->save();

        $profile = Profile::firstOrNew(['name'=>'notify_se_review_completion']);
        $data = array('name'=>'notify_se_review_completion', 'description'=>'Specimen Review Completion', 'default_value'=>'true', 'kind'=>'bool',
            'display_type'=>'checkbox', 'display_values'=>'', 'type'=>'user', 'group'=>'se', 'display_order'=>2101,
            'help'=>'Notify the user/project manager when a specimen has been marked as reviewed',
            'created_by'=>'System', 'updated_by'=>'System', 'created_at'=>date_create(), 'updated_at'=>date_create());
        (!$profile->exists) ? $profile->fill($data)->save() : $profile->fill(array_except($data, ['created_at']))->save();

        $profile = Profile::firstOrNew(['name'=>'notify_via_email']);
        $data = array('name'=>'notify_via_email', 'description'=>'Notify via Email', 'default_value'=>'true', 'kind'=>'bool',
            'display_type'=>'checkbox', 'display_values'=>'', 'type'=>'user', 'group'=>'se', 'display_order'=>2102,
            'help'=>'Notify the user via Email',
            'created_by'=>'System', 'updated_by'=>'System', 'created_at'=>date_create(), 'updated_at'=>date_create());
        (!$profile->exists) ? $profile->fill($data)->save() : $profile->fill(array_except($data, ['created_at']))->save();

        $profile = Profile::firstOrNew(['name'=>'notify_via_sms']);
        $data = array('name'=>'notify_via_sms', 'description'=>'Notify via SMS', 'default_value'=>'true', 'kind'=>'bool',
            'display_type'=>'checkbox', 'display_values'=>'', 'type'=>'user', 'group'=>'se', 'display_order'=>2103,
            'help'=>'Notify the user via SMS',
            'created_by'=>'System', 'updated_by'=>'System', 'created_at'=>date_create(), 'updated_at'=>date_create());
        (!$profile->exists) ? $profile->fill($data)->save() : $profile->fill(array_except($data, ['created_at']))->save();

        $profile = Profile::firstOrNew(['name'=>'notify_via_slack']);
        $data = array('name'=>'notify_via_slack', 'description'=>'Notify via Slack', 'default_value'=>'true', 'kind'=>'bool',
            'display_type'=>'checkbox', 'display_values'=>'', 'type'=>'user', 'group'=>'se', 'display_order'=>2104,
            'help'=>'Notify the user via Slack channel',
            'created_by'=>'System', 'updated_by'=>'System', 'created_at'=>date_create(), 'updated_at'=>date_create());
        (!$profile->exists) ? $profile->fill($data)->save() : $profile->fill(array_except($data, ['created_at']))->save();

        // User UI Layout and Skin option
        $profile = Profile::firstOrNew(['name'=>'ui_fixed_layout']);
        $data = array('name'=>'ui_fixed_layout', 'description'=>'Fixed Layout', 'default_value'=>'true', 'kind'=>'bool',
            'display_type'=>'checkbox', 'display_values'=>'', 'type'=>'user', 'group'=>'ui', 'display_order'=>2120,
            'help'=>'Activate the fixed layout. You can\'t use fixed and boxed layouts together',
            'created_by'=>'System', 'updated_by'=>'System', 'created_at'=>date_create(), 'updated_at'=>date_create());
        (!$profile->exists) ? $profile->fill($data)->save() : $profile->fill(array_except($data, ['created_at']))->save();

        $profile = Profile::firstOrNew(['name'=>'ui_boxed_layout']);
        $data = array('name'=>'ui_boxed_layout', 'description'=>'Boxed Layout', 'default_value'=>'true', 'kind'=>'bool',
            'display_type'=>'checkbox', 'display_values'=>'', 'type'=>'user', 'group'=>'ui', 'display_order'=>2121,
            'help'=>'Activate the boxed layout. You can\'t use fixed and boxed layouts together',
            'created_by'=>'System', 'updated_by'=>'System', 'created_at'=>date_create(), 'updated_at'=>date_create());
        (!$profile->exists) ? $profile->fill($data)->save() : $profile->fill(array_except($data, ['created_at']))->save();

        $profile = Profile::firstOrNew(['name'=>'ui_toggle_left_sidebar']);
        $data = array('name'=>'ui_toggle_left_sidebar', 'description'=>'Toggle Sidebar', 'default_value'=>'true', 'kind'=>'bool',
            'display_type'=>'checkbox', 'display_values'=>'', 'type'=>'user', 'group'=>'ui', 'display_order'=>2122,
            'help'=>'Toggle the left sidebar\'s state (open or collapse)',
            'created_by'=>'System', 'updated_by'=>'System', 'created_at'=>date_create(), 'updated_at'=>date_create());
        (!$profile->exists) ? $profile->fill($data)->save() : $profile->fill(array_except($data, ['created_at']))->save();

        $profile = Profile::firstOrNew(['name'=>'ui_left_sidebar_expand_on_hover']);
        $data = array('name'=>'ui_left_sidebar_expand_on_hover', 'description'=>'Left Sidebar Expand on Hover', 'default_value'=>'true', 'kind'=>'bool',
            'display_type'=>'checkbox', 'display_values'=>'', 'type'=>'user', 'group'=>'ui', 'display_order'=>2123,
            'help'=>'Let the left sidebar mini expand on hover',
            'created_by'=>'System', 'updated_by'=>'System', 'created_at'=>date_create(), 'updated_at'=>date_create());
        (!$profile->exists) ? $profile->fill($data)->save() : $profile->fill(array_except($data, ['created_at']))->save();

        $profile = Profile::firstOrNew(['name'=>'ui_toggle_right_sidebar_slide']);
        $data = array('name'=>'ui_toggle_right_sidebar_slide', 'description'=>'Toggle Right Sidebar Slide', 'default_value'=>'true', 'kind'=>'bool',
            'display_type'=>'checkbox', 'display_values'=>'', 'type'=>'user', 'group'=>'ui', 'display_order'=>2124,
            'help'=>'Toggle between slide over content and push content effects',
            'created_by'=>'System', 'updated_by'=>'System', 'created_at'=>date_create(), 'updated_at'=>date_create());
        (!$profile->exists) ? $profile->fill($data)->save() : $profile->fill(array_except($data, ['created_at']))->save();

        $profile = Profile::firstOrNew(['name'=>'ui_toggle_right_sidebar_skin']);
        $data = array('name'=>'ui_toggle_right_sidebar_skin', 'description'=>'Toggle Right Sidebar Skin', 'default_value'=>'true', 'kind'=>'bool',
            'display_type'=>'checkbox', 'display_values'=>'', 'type'=>'user', 'group'=>'ui', 'display_order'=>2125,
            'help'=>'Toggle between dark and light skins for the right sidebar',
            'created_by'=>'System', 'updated_by'=>'System', 'created_at'=>date_create(), 'updated_at'=>date_create());
        (!$profile->exists) ? $profile->fill($data)->save() : $profile->fill(array_except($data, ['created_at']))->save();

        $profile = Profile::firstOrNew(['name'=>'ui_skin_color']);
        $data = array('name'=>'ui_skin_color', 'description'=>'Skin or Theme Color', 'default_value'=>'#343a40', 'kind'=>'string',
            'display_type'=>'text', 'display_values'=>'', 'type'=>'user', 'group'=>'ui', 'display_order'=>2126,
            'help'=>'Choose the skin or theme color to apply',
            'created_by'=>'System', 'updated_by'=>'System', 'created_at'=>date_create(), 'updated_at'=>date_create());
        (!$profile->exists) ? $profile->fill($data)->save() : $profile->fill(array_except($data, ['created_at']))->save();

        $profile = Profile::firstOrNew(['name'=>'ui_right_sidebar_slideout_help']);
        $data = array('name'=>'ui_right_sidebar_slideout_help', 'description'=>'Slideout the right sidebar for help', 'default_value'=>'true', 'kind'=>'bool',
            'display_type'=>'checkbox', 'display_values'=>'', 'type'=>'user', 'group'=>'ui', 'display_order'=>2127,
            'help'=>'Slideout the right sidebar with help on screens such as Specimens measurements, zones and methods',
            'created_by'=>'System', 'updated_by'=>'System', 'created_at'=>date_create(), 'updated_at'=>date_create());
        (!$profile->exists) ? $profile->fill($data)->save() : $profile->fill(array_except($data, ['created_at']))->save();

        $profile = Profile::firstOrNew(['name'=>'user_dashboard_components']);
        $data = array('name'=>'user_dashboard_components', 'description'=>'User Dashboard Components', 'default_value'=>'', 'kind'=>'string',
            'display_type'=>'text', 'display_values'=>'', 'type'=>'user', 'group'=>'ui', 'display_order'=>2130,
            'help'=>'This will store the user dashboard component preferences as a json string',
            'created_by'=>'System', 'updated_by'=>'System', 'created_at'=>date_create(), 'updated_at'=>date_create());
        (!$profile->exists) ? $profile->fill($data)->save() : $profile->fill(array_except($data, ['created_at']))->save();

        $profile = Profile::firstOrNew(['name'=>'project_dashboard_components']);
        $data = array('name'=>'project_dashboard_components', 'description'=>'Project Dashboard Components', 'default_value'=>'', 'kind'=>'string',
            'display_type'=>'text', 'display_values'=>'', 'type'=>'user', 'group'=>'ui', 'display_order'=>2131,
            'help'=>'This will store the project dashboard component preferences as a json string',
            'created_by'=>'System', 'updated_by'=>'System', 'created_at'=>date_create(), 'updated_at'=>date_create());
        (!$profile->exists) ? $profile->fill($data)->save() : $profile->fill(array_except($data, ['created_at']))->save();

        $profile = Profile::firstOrNew(['name'=>'orgadmin_dashboard_components']);
        $data = array('name'=>'orgadmin_dashboard_components', 'description'=>'Org Admin Dashboard Components', 'default_value'=>'', 'kind'=>'string',
            'display_type'=>'text', 'display_values'=>'', 'type'=>'user', 'group'=>'ui', 'display_order'=>2132,
            'help'=>'This will store the org admin dashboard component preferences as a json string',
            'created_by'=>'System', 'updated_by'=>'System', 'created_at'=>date_create(), 'updated_at'=>date_create());
        (!$profile->exists) ? $profile->fill($data)->save() : $profile->fill(array_except($data, ['created_at']))->save();
    }

    protected function createImportCSVFileTableMaps()
    {
        $dt = date_create();
        $sys = 'System';

        DB::table('import_csv_file_table_map')->insert(array(array('csv_column_name'=>'accession_number', 'table_column_name'=>'accession_number', 'table_name'=>'skeletal_elements', 'created_by'=>$sys, 'updated_by'=>$sys, 'created_at'=>$dt, 'updated_at'=>$dt )));
        DB::table('import_csv_file_table_map')->insert(array(array('csv_column_name'=>'provenance1', 'table_column_name'=>'provenance1', 'table_name'=>'skeletal_elements', 'created_by'=>$sys, 'updated_by'=>$sys, 'created_at'=>$dt, 'updated_at'=>$dt )));
        DB::table('import_csv_file_table_map')->insert(array(array('csv_column_name'=>'provenance2', 'table_column_name'=>'provenance2', 'table_name'=>'skeletal_elements', 'created_by'=>$sys, 'updated_by'=>$sys, 'created_at'=>$dt, 'updated_at'=>$dt )));
        DB::table('import_csv_file_table_map')->insert(array(array('csv_column_name'=>'designator', 'table_column_name'=>'designator', 'table_name'=>'skeletal_elements', 'created_by'=>$sys, 'updated_by'=>$sys, 'created_at'=>$dt, 'updated_at'=>$dt )));
        DB::table('import_csv_file_table_map')->insert(array(array('csv_column_name'=>'side', 'table_column_name'=>'side', 'table_name'=>'skeletal_elements', 'created_by'=>$sys, 'updated_by'=>$sys, 'created_at'=>$dt, 'updated_at'=>$dt )));
        DB::table('import_csv_file_table_map')->insert(array(array('csv_column_name'=>'completeness', 'table_column_name'=>'completeness', 'table_name'=>'skeletal_elements', 'created_by'=>$sys, 'updated_by'=>$sys, 'created_at'=>$dt, 'updated_at'=>$dt )));
        DB::table('import_csv_file_table_map')->insert(array(array('csv_column_name'=>'measured', 'table_column_name'=>'measured', 'table_name'=>'skeletal_elements', 'created_by'=>$sys, 'updated_by'=>$sys, 'created_at'=>$dt, 'updated_at'=>$dt )));
        DB::table('import_csv_file_table_map')->insert(array(array('csv_column_name'=>'dna_sampled', 'table_column_name'=>'dna_sampled', 'table_name'=>'skeletal_elements', 'created_by'=>$sys, 'updated_by'=>$sys, 'created_at'=>$dt, 'updated_at'=>$dt )));
        DB::table('import_csv_file_table_map')->insert(array(array('csv_column_name'=>'ct_scanned', 'table_column_name'=>'ct_scanned', 'table_name'=>'skeletal_elements', 'created_by'=>$sys, 'updated_by'=>$sys, 'created_at'=>$dt, 'updated_at'=>$dt )));
        DB::table('import_csv_file_table_map')->insert(array(array('csv_column_name'=>'xray_scanned', 'table_column_name'=>'xray_scanned', 'table_name'=>'skeletal_elements', 'created_by'=>$sys, 'updated_by'=>$sys, 'created_at'=>$dt, 'updated_at'=>$dt )));
        DB::table('import_csv_file_table_map')->insert(array(array('csv_column_name'=>'clavicle_triage', 'table_column_name'=>'clavicle_triage', 'table_name'=>'skeletal_elements', 'created_by'=>$sys, 'updated_by'=>$sys, 'created_at'=>$dt, 'updated_at'=>$dt )));
        DB::table('import_csv_file_table_map')->insert(array(array('csv_column_name'=>'inventoried', 'table_column_name'=>'inventoried', 'table_name'=>'skeletal_elements', 'created_by'=>$sys, 'updated_by'=>$sys, 'created_at'=>$dt, 'updated_at'=>$dt )));
        DB::table('import_csv_file_table_map')->insert(array(array('csv_column_name'=>'reviewed', 'table_column_name'=>'reviewed', 'table_name'=>'skeletal_elements', 'created_by'=>$sys, 'updated_by'=>$sys, 'created_at'=>$dt, 'updated_at'=>$dt )));
        DB::table('import_csv_file_table_map')->insert(array(array('csv_column_name'=>'external_id', 'table_column_name'=>'external_id', 'table_name'=>'skeletal_elements', 'created_by'=>$sys, 'updated_by'=>$sys, 'created_at'=>$dt, 'updated_at'=>$dt )));
        DB::table('import_csv_file_table_map')->insert(array(array('csv_column_name'=>'individual_number', 'table_column_name'=>'individual_number', 'table_name'=>'skeletal_elements', 'created_by'=>$sys, 'updated_by'=>$sys, 'created_at'=>$dt, 'updated_at'=>$dt )));
        DB::table('import_csv_file_table_map')->insert(array(array('csv_column_name'=>'inventoried_at', 'table_column_name'=>'inventoried_at', 'table_name'=>'skeletal_elements', 'created_by'=>$sys, 'updated_by'=>$sys, 'created_at'=>$dt, 'updated_at'=>$dt )));
        DB::table('import_csv_file_table_map')->insert(array(array('csv_column_name'=>'reviewed_at', 'table_column_name'=>'reviewed_at', 'table_name'=>'skeletal_elements', 'created_by'=>$sys, 'updated_by'=>$sys, 'created_at'=>$dt, 'updated_at'=>$dt )));
        DB::table('import_csv_file_table_map')->insert(array(array('csv_column_name'=>'consolidated_an', 'table_column_name'=>'consolidated_an', 'table_name'=>'skeletal_elements', 'created_by'=>$sys, 'updated_by'=>$sys, 'created_at'=>$dt, 'updated_at'=>$dt )));
        DB::table('import_csv_file_table_map')->insert(array(array('csv_column_name'=>'isotope_sampled', 'table_column_name'=>'isotope_sampled', 'table_name'=>'skeletal_elements', 'created_by'=>$sys, 'updated_by'=>$sys, 'created_at'=>$dt, 'updated_at'=>$dt )));
        DB::table('import_csv_file_table_map')->insert(array(array('csv_column_name'=>'count', 'table_column_name'=>'count', 'table_name'=>'skeletal_elements', 'created_by'=>$sys, 'updated_by'=>$sys, 'created_at'=>$dt, 'updated_at'=>$dt )));
        DB::table('import_csv_file_table_map')->insert(array(array('csv_column_name'=>'mass', 'table_column_name'=>'mass', 'table_name'=>'skeletal_elements', 'created_by'=>$sys, 'updated_by'=>$sys, 'created_at'=>$dt, 'updated_at'=>$dt )));
        DB::table('import_csv_file_table_map')->insert(array(array('csv_column_name'=>'bone_group', 'table_column_name'=>'bone_group', 'table_name'=>'skeletal_elements', 'created_by'=>$sys, 'updated_by'=>$sys, 'created_at'=>$dt, 'updated_at'=>$dt )));
        DB::table('import_csv_file_table_map')->insert(array(array('csv_column_name'=>'sb_id', 'table_column_name'=>'sb_id', 'table_name'=>'skeletal_elements', 'created_by'=>$sys, 'updated_by'=>$sys, 'created_at'=>$dt, 'updated_at'=>$dt )));
    }

    protected function createMedias()
    {
        $dt = date_create();
        $sys = 'System';
        $media = Media::firstOrNew(['type'=>'Video', 'url'=>'https://www.youtube.com/watch?v=NgbrqzgyWRo&index=2&list=PLcJSkbOhx_uiOQDhJXvA3UcQj0_KAZI7i']);
        $data = array('type'=>'Video', 'url'=>'https://www.youtube.com/watch?v=NgbrqzgyWRo&index=2&list=PLcJSkbOhx_uiOQDhJXvA3UcQj0_KAZI7i',
            'archived'=>false, 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$media->exists) ? $media->fill($data)->save() : $media->fill(array_except($data, ['created_at']))->save();

        $media = Media::firstOrNew(['type'=>'Video', 'url'=>'https://www.youtube.com/watch?v=YcZta_GmEyA&index=3&list=PLcJSkbOhx_uiOQDhJXvA3UcQj0_KAZI7i']);
        $data = array('type'=>'Video', 'url'=>'https://www.youtube.com/watch?v=YcZta_GmEyA&index=3&list=PLcJSkbOhx_uiOQDhJXvA3UcQj0_KAZI7i',
            'archived'=>false, 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$media->exists) ? $media->fill($data)->save() : $media->fill(array_except($data, ['created_at']))->save();
    }

    protected function updateProjectsGeoLatLong()
    {
        $dt = Carbon::now();
        $dt = $dt->subDay(30);

        $project = Project::firstOrNew(['name' => 'CoRA Demo']);
        if ($project->exists) {
            $project->fill(['name' => 'CoRA Demo', 'geo_lat' => 41.247382, 'geo_long' => -96.016799, 'start_date' => $dt,])->save();
        }

        $project = Project::firstOrNew(['name' => 'Tarawa']);
        if ($project->exists) {
            $project->fill(['name' => 'Tarawa', 'geo_lat' => 1.469820, 'geo_long' => 172.972902, 'start_date' => $dt,])->save();
        }

        $project = Project::firstOrNew(['name' => 'Hamburger Hill']);
        if ($project->exists) {
            $project->fill(['name' => 'Hamburger Hill', 'geo_lat' => 16.251613, 'geo_long' => 107.177875, 'start_date' => $dt,])->save();
        }

        $project = Project::firstOrNew(['name' => 'Chosin Reservoir']);
        if ($project->exists) {
            $project->fill(['name' => 'Chosin Reservoir', 'geo_lat' => 40.483321, 'geo_long' => 127.199999, 'start_date' => $dt,])->save();
        }

        $project = Project::firstOrNew(['name' => 'USS Oklahoma']);
        if ($project->exists) {
            $project->fill(['name' => 'USS Oklahoma', 'geo_lat' => 21.359044, 'geo_long' => -157.950960, 'start_date' => $dt,])->save();
        }

        $project = Project::firstOrNew(['name' => 'USS West Virginia']);
        if ($project->exists) {
            $project->fill(['name' => 'USS West Virginia', 'geo_lat' => 21.363761, 'geo_long' => -157.946668, 'start_date' => $dt,])->save();
        }

        $project = Project::firstOrNew(['name' => 'USS California']);
        if ($project->exists) {
            $project->fill(['name' => 'USS California', 'geo_lat' => 21.358675, 'geo_long' => -157.959114, 'start_date' => $dt,])->save();
        }

        $project = Project::firstOrNew(['name' => 'Ploesti']);
        if ($project->exists) {
            $project->fill(['name' => 'Ploesti', 'geo_lat' => 44.942019, 'geo_long' => 26.016758, 'start_date' => $dt,])->save();
        }
    }
}
