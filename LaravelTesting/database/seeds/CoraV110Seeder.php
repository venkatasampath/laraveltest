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

use App\Lab;
use App\Profile;
use App\Utility\Memory;
use Illuminate\Database\Seeder;

/**
 * Class CoraV101Seeder
 * This is the seeder class for version 1.0.1 changes
 */
class CoraV110Seeder extends Seeder
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
        $this->command->info('      Start: Seeding CoRA Version 1.1.0 Data                            !');
        $this->command->info('------------------------------------------------------------------------!');

        // Call protected functions in class, that are relevant for this release.
        $this->createProfiles();
        $this->createImportFileTypes();
        $this->createExportMaps();
        $this->createLabs();

        // Call seeder outside this file/class.
        $this->call(SkeletalBonesTableSeeder::class);
        $this->call(ArticulationsTableSeeder::class);
        $this->call(MeasurementsTableSeeder::class);
        $this->call(RolesPermissionsSeeder::class);
        $this->call(DnaAnalysisTypesTableSeeder::class);
        $this->call(HaplogroupsTableSeeder::class);
        $this->call(BoneGroupsTableSeeder::class);

        $this->command->info('------------------------------------------------------------------------!');
        $this->command->info('        End: Seeding CoRA Version 1.1.0 Data                            !');
        $this->command->info('------------------------------------------------------------------------!');

        Memory::dump_usage(true);
    }

    protected function createLabs()
    {
        $dt = date_create();
        $sys = 'System';

        $lab = Lab::firstOrNew(['name'=>'AFDIL']);
        $data = array('name'=>'AFDIL', 'type'=>'Genomics', 'description'=>'Armed Forces DNA Identification Laboratory',
            'created_by'=>$sys, 'updated_by'=>$sys, 'created_at'=>$dt, 'updated_at'=>$dt);
        (!$lab->exists) ? $lab->fill($data)->save() : $lab->fill(array_except($data, ['created_at']))->save();

        $lab = Lab::firstOrNew(['name'=>'HI-SIP']);
        $data = array('name'=>'HI-SIP', 'type'=>'Isotope', 'description'=>'Hawaii-Stable Isotope Preparation',
            'created_by'=>$sys, 'updated_by'=>$sys, 'created_at'=>$dt, 'updated_at'=>$dt);
        (!$lab->exists) ? $lab->fill($data)->save() : $lab->fill(array_except($data, ['created_at']))->save();

        $lab = Lab::firstOrNew(['name'=>'HI-SIA']);
        $data = array('name'=>'HI-SIA', 'type'=>'Isotope', 'description'=>'Hawaii-Stable Isotope Analysis',
            'created_by'=>$sys, 'updated_by'=>$sys, 'created_at'=>$dt, 'updated_at'=>$dt);
        (!$lab->exists) ? $lab->fill($data)->save() : $lab->fill(array_except($data, ['created_at']))->save();

        $lab = Lab::firstOrNew(['name'=>'CSU-Chico']);
        $data = array('name'=>'CSU-Chico', 'type'=>'Isotope', 'description'=>'Cal State University Chico',
            'created_by'=>$sys, 'updated_by'=>$sys, 'created_at'=>$dt, 'updated_at'=>$dt);
        (!$lab->exists) ? $lab->fill($data)->save() : $lab->fill(array_except($data, ['created_at']))->save();

        $lab = Lab::firstOrNew(['name'=>'IsoFor']);
        $data = array('name'=>'IsoFor', 'type'=>'Isotope', 'description'=>'IsoForensics Inc.',
            'created_by'=>$sys, 'updated_by'=>$sys, 'created_at'=>$dt, 'updated_at'=>$dt);
        (!$lab->exists) ? $lab->fill($data)->save() : $lab->fill(array_except($data, ['created_at']))->save();

        $lab = Lab::firstOrNew(['name'=>'UF']);
        $data = array('name'=>'UF', 'type'=>'Isotope', 'description'=>'University of Florida',
            'created_by'=>$sys, 'updated_by'=>$sys, 'created_at'=>$dt, 'updated_at'=>$dt);
        (!$lab->exists) ? $lab->fill($data)->save() : $lab->fill(array_except($data, ['created_at']))->save();

        $lab = Lab::firstOrNew(['name'=>'UU']);
        $data = array('name'=>'UU', 'type'=>'Isotope', 'description'=>'University of Utah',
            'created_by'=>$sys, 'updated_by'=>$sys, 'created_at'=>$dt, 'updated_at'=>$dt);
        (!$lab->exists) ? $lab->fill($data)->save() : $lab->fill(array_except($data, ['created_at']))->save();

        $lab = Lab::firstOrNew(['name'=>'ASU']);
        $data = array('name'=>'ASU', 'type'=>'Isotope', 'description'=>'Arizona State University',
            'created_by'=>$sys, 'updated_by'=>$sys, 'created_at'=>$dt, 'updated_at'=>$dt);
        (!$lab->exists) ? $lab->fill($data)->save() : $lab->fill(array_except($data, ['created_at']))->save();

        $lab = Lab::firstOrNew(['name'=>'Another Lab']);
        $data = array('name'=>'Another Lab', 'type'=>'Toxicology', 'description'=>'A-LAB focused on Toxicology',
            'created_by'=>$sys, 'updated_by'=>$sys, 'created_at'=>$dt, 'updated_at'=>$dt);
        (!$lab->exists) ? $lab->fill($data)->save() : $lab->fill(array_except($data, ['created_at']))->save();
    }

    protected function createProfiles()
    {
        // Org profiles
        $profile = Profile::firstOrNew(['name'=>'org_length_unit_of_measure']);
        $data = array('name'=>'org_length_unit_of_measure', 'description'=>'Length - Unit of Measure', 'default_value'=>'mm', 'kind'=>'string',
            'display_type'=>'select', 'display_values'=>'{"mm":"mm", "cm":"cm", "inches":"inches"}', 'type'=>'org', 'group'=>'project', 'display_order'=>2002,
            'help'=>'Unit of measure used for length/measurement fields within all projects in this organization',
            'created_by'=>'System', 'updated_by'=>'System', 'created_at'=>date_create(), 'updated_at'=>date_create());
        (!$profile->exists) ? $profile->fill($data)->save() : $profile->fill(array_except($data, ['created_at']))->save();

        // User profiles
        $profile = Profile::firstOrNew(['name'=>'user_default_search_by']);
        $data = array('name'=>'user_default_search_by', 'description'=>'Default Search By Criteria', 'default_value'=>'SE-SB', 'kind'=>'string', 'display_type'=>'select',
            'display_values'=>'{"SE-SB":"Specimens by Bone Name", "SE-CK":"Specimens by Composite Key", "SE-AN":"Specimens by Accession Number", "SE-P1":"Specimens by Provenance1"", SE-P2":"Specimens by Provenance2", SE-DN":"Specimens by Designator", SE-IN":"Specimens by Individual Number", "DNA-SB":"DNA by Bone Name", "DNA-CK":"DNA by Composite Key", "DNA-AN":"DNA by Accession Number", "DNA-SN":"DNA by Sample Number"", "DNA-MS":"DNA by Mito Sequence Number", "DNA-EN":"DNA by External Number", "DNA-IN":"DNA by Individual Number"}',
            'type'=>'user', 'group'=>'search', 'display_order'=>2140,
            'help'=>'The default Search By criteria that the application will default to for the current user',
            'created_by'=>'System', 'updated_by'=>'System', 'created_at'=>date_create(), 'updated_at'=>date_create());
        (!$profile->exists) ? $profile->fill($data)->save() : $profile->fill(array_except($data, ['created_at']))->save();

        $profile = Profile::firstOrNew(['name'=>'user_save_last_search_by']);
        $data = array('name'=>'user_save_last_search_by', 'description'=>'Save the last used Search By Criteria', 'default_value'=>'false', 'kind'=>'bool',
            'display_type'=>'checkbox', 'display_values'=>'', 'type'=>'user', 'group'=>'search', 'display_order'=>2141,
            'help'=>'Selecting this option will save the last used Search By criteria and the search will be defaulted to this saved Search By criteria.',
            'created_by'=>'System', 'updated_by'=>'System', 'created_at'=>date_create(), 'updated_at'=>date_create());
        (!$profile->exists) ? $profile->fill($data)->save() : $profile->fill(array_except($data, ['created_at']))->save();

        $profile = Profile::firstOrNew(['name'=>'default_mito_method']);
        $data = array('name'=>'default_mito_method', 'description'=>'Default Mito DNA Method', 'default_value'=>'Sanger', 'kind'=>'string',
            'display_type'=>'select', 'display_values'=>'{"NGS":"NGS", "Sanger":"Sanger"}', 'type'=>'user', 'group'=>'dna', 'display_order'=>2103,
            'help'=>'The DNA method will be auto-populated on Mito DNA associations for Specimen',
            'created_by'=>'System', 'updated_by'=>'System', 'created_at'=>date_create(), 'updated_at'=>date_create());
        (!$profile->exists) ? $profile->fill($data)->save() : $profile->fill(array_except($data, ['created_at']))->save();

        $profile = Profile::firstOrNew(['name'=>'default_y_method']);
        $data = array('name'=>'default_y_method', 'description'=>'Default Y-STR DNA Method', 'default_value'=>'Y filer', 'kind'=>'string',
            'display_type'=>'select', 'display_values'=>'{"Y filer":"Y filer"}', 'type'=>'user', 'group'=>'dna', 'display_order'=>2104,
            'help'=>'The DNA method will be auto-populated on Y-STR DNA associations for Specimen',
            'created_by'=>'System', 'updated_by'=>'System', 'created_at'=>date_create(), 'updated_at'=>date_create());
        (!$profile->exists) ? $profile->fill($data)->save() : $profile->fill(array_except($data, ['created_at']))->save();

        $profile = Profile::firstOrNew(['name'=>'default_auto_method']);
        $data = array('name'=>'default_auto_method', 'description'=>'Default auSTR DNA Method', 'default_value'=>'AmpFLSTR Minifiler', 'kind'=>'string',
            'display_type'=>'select', 'display_values'=>'{"AmpFLSTR Minifiler":"AmpFLSTR Minifiler", "AmpFLSTR Identifiler":"AmpFLSTR Identifiler", "Power Plex Fusion":"Power Plex Fusion"}', 'type'=>'user', 'group'=>'dna', 'display_order'=>2105,
            'help'=>'The DNA method will be auto-populated on auSTR DNA associations for Specimen',
            'created_by'=>'System', 'updated_by'=>'System', 'created_at'=>date_create(), 'updated_at'=>date_create());
        (!$profile->exists) ? $profile->fill($data)->save() : $profile->fill(array_except($data, ['created_at']))->save();

        // Project profiles
        $profile = Profile::firstOrNew(['name'=>'consensus_dna_use_old']);
        $data = array('name'=>'consensus_dna_use_old', 'description'=>'Use older DNA sample record information if new DNA sample record exists but has NULL values', 'default_value'=>'false', 'kind'=>'bool',
            'display_type'=>'checkbox', 'display_values'=>'', 'type'=>'user', 'group'=>'project', 'display_order'=>2142,
            'help'=>'Selecting this option will use older DNA sample record information if new DNA sample record exists but has NULL values.',
            'created_by'=>'System', 'updated_by'=>'System', 'created_at'=>date_create(), 'updated_at'=>date_create());
        (!$profile->exists) ? $profile->fill($data)->save() : $profile->fill(array_except($data, ['created_at']))->save();
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

    protected function createExportMaps()
    {
        DB::table('export_maps')->delete();
        $dt = date_create();
        $sys = 'System';

        DB::table('export_maps')->insert(array(array('name'=>'Base - All', 'group'=>'Base', 'description'=>'Base tables that hold descriptive data for CoRA', 'table_names'=>'skeletal_bones, anomalys, articulations, bone_groups, dna_analysis_types, haplogroups, labs, measurements, methods, method_features, orgs, projects, pathologys, profiles, taphonomys, traumas, zones', 'created_by'=>$sys, 'updated_by'=>$sys, 'created_at'=>$dt, 'updated_at'=>$dt )));
        DB::table('export_maps')->insert(array(array('name'=>'All', 'group'=>'Project', 'description'=>'Specimens and all its associations', 'table_names'=>'skeletal_bones, skeletal_elements, dnas, dna_analysis_types, se_measurement, se_zone, se_pair, se_articulation, se_refit, se_taphonomy, se_pathology, se_trauma, se_anomaly, se_method, se_method_feature', 'created_by'=>$sys, 'updated_by'=>$sys, 'created_at'=>$dt, 'updated_at'=>$dt )));
        DB::table('export_maps')->insert(array(array('name'=>'DNA', 'group'=>'Project', 'description'=>'Specimens, DNA and all DNA associations', 'table_names'=>'skeletal_elements, dnas, dna_analysis_types', 'created_by'=>$sys, 'updated_by'=>$sys, 'created_at'=>$dt, 'updated_at'=>$dt )));
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
        DB::table('export_maps')->insert(array(array('name'=>'Osteometric Sorting', 'group'=>'Project-Join', 'description'=>'Bones and all its measurements', 'query'=>"select se.id, se.accession_number, se.provenance1, se.provenance2, se.designator, sb.name as skeletal_bone, se.side, me.name, sem.measure from se_measurement as sem JOIN skeletal_elements as se on sem.se_id = se.id JOIN skeletal_bones as sb on se.sb_id = sb.id JOIN measurements as me on me.id = sem.measurement_id", 'created_by'=>$sys, 'updated_by'=>$sys, 'created_at'=>$dt, 'updated_at'=>$dt )));
    }
}
