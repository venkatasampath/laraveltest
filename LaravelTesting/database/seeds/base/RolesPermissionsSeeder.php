<?php

/**
 * RolesPermissionsSeeder
 *
 * @category   Roles Permissions Seeder
 * @package    Seeder
 * @author     Sachin Pawaskar<spawaskar@unomaha.edu>
 * @copyright  2016-2019
 * @license    The MIT License (MIT)
 * @version    GIT: $Id$
 * @since      File available since Release 1.0.0
 */

use Illuminate\Database\Seeder;
use TCG\Voyager\Models\DataType;
use TCG\Voyager\Models\Permission;
use TCG\Voyager\Models\Role;

class RolesPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->seedRoles();
        $this->seedPermissions();
    }

    protected function seedRoles()
    {
        $dt = date_create();

        $role = Role::firstOrNew(['name' => 'manager']);
        $data = array('name' => 'manager', 'display_name' => 'Manager', 'created_at' => $dt, 'updated_at' => $dt,
            'description' => 'Manager is allowed to manage their Org and objects for that org such as users, projects, and specimens and related data');
        (!$role->exists) ? $role->fill($data)->save() : $role->fill(array_except($data, ['created_at']))->save();

        $role = Role::firstOrNew(['name' => 'anthropologist']);
        $data = array('name' => 'anthropologist', 'display_name' => 'Anthropologist', 'created_at' => $dt, 'updated_at' => $dt,
            'description' => 'Anthropologist is allowed full Read/Write access to specimens and related data');
        (!$role->exists) ? $role->fill($data)->save() : $role->fill(array_except($data, ['created_at']))->save();

        $role = Role::firstOrNew(['name' => 'dna-analyst']);
        $data = array('name' => 'dna-analyst', 'display_name' => 'DNA Analyst', 'created_at' => $dt, 'updated_at' => $dt,
            'description' => 'DNA Analyst is allowed Read access to specimens and Read/Write access to DNA data');
        (!$role->exists) ? $role->fill($data)->save() : $role->fill(array_except($data, ['created_at']))->save();

        $role = Role::firstOrNew(['name' => 'historian']);
        $data = array('name' => 'historian', 'display_name' => 'Historian', 'created_at' => $dt, 'updated_at' => $dt,
            'description' => 'Historian is allowed Read access to specimens and Read/Write access to Antemortem data');
        (!$role->exists) ? $role->fill($data)->save() : $role->fill(array_except($data, ['created_at']))->save();

        $role = Role::firstOrNew(['name' => 'dentist']);
        $data = array('name' => 'dentist', 'display_name' => 'Dentist', 'created_at' => $dt, 'updated_at' => $dt,
            'description' => 'Dentist is allowed Read access to specimens and Read/Write access to Dental elements data');
        (!$role->exists) ? $role->fill($data)->save() : $role->fill(array_except($data, ['created_at']))->save();

        $role = Role::firstOrNew(['name' => 'intern']);
        $data = array('name' => 'intern', 'display_name' => 'Intern', 'created_at' => $dt, 'updated_at' => $dt,
            'description' => 'Intern is allowed Read access to specimens and related data');
        (!$role->exists) ? $role->fill($data)->save() : $role->fill(array_except($data, ['created_at']))->save();

        $role = Role::firstOrNew(['name' => 'isotope-analyst']);
        $data = array('name' => 'isotope-analyst', 'display_name' => 'Isotope Analyst', 'created_at' => $dt, 'updated_at' => $dt,
            'description' => 'Isotope Analyst is allowed Read access to specimens and Read/Write access to Isotope data');
        (!$role->exists) ? $role->fill($data)->save() : $role->fill(array_except($data, ['created_at']))->save();
    }

    protected function seedPermissions()
    {
        // Get the roles we want to add permissions to.
        $adminrole = Role::where('name', 'admin')->firstOrFail();
        $orgadminrole = Role::where('name', 'orgadmin')->firstOrFail();
        $managerrole = Role::where('name', 'manager')->firstOrFail();
        $anthrorole = Role::where('name', 'anthropologist')->firstOrFail();
        $dnaanalystrole = Role::where('name', 'dna-analyst')->firstOrFail();
        $historian = Role::where('name', 'historian')->firstOrFail();
        $dentist = Role::where('name', 'dentist')->firstOrFail();
        $intern = Role::where('name', 'intern')->firstOrFail();
        $isoanalystrole = Role::where('name', 'isotope-analyst')->firstOrFail();

        // First create any new permissions for Models/Tables

        // Isotopes Roles and Permissions
        $dataType = $this->dataType('slug', 'isotopes');
        if (!$dataType->exists) {
            $dataType->fill([ 'name' => 'isotopes', 'display_name_singular' => 'Isotopes', 'display_name_plural' => 'Isotopes',
                'icon' => 'voyager-company', 'model_name' => 'App\\Isotope', 'policy_name' => 'App\\Policies\\IsotopePolicy',
                'controller' => '', 'generate_permissions' => 1, 'description' => '',
            ])->save();
        }
        $permissions = Permission::firstOrNew(['table_name' => 'isotopes']);
        if (!$permissions->exists) {
            Permission::generateFor('isotopes');
        }
        // Add permissions for admin
        $adminrole->permissions()->syncWithoutDetaching($permissions->where('table_name', '=', 'isotopes')->pluck('id')->all());
        // Add permissions for orgadmin
        $orgadminrole->permissions()->syncWithoutDetaching($permissions->where('table_name', '=', 'isotopes')->pluck('id')->all());
        // Add permissions for manager
        $managerrole->permissions()->syncWithoutDetaching($permissions->where('table_name', '=', 'isotopes')->pluck('id')->all());
        // Add permissions for anthropologist
        $anthrorole->permissions()->syncWithoutDetaching($permissions->where('table_name', '=', 'isotopes')->pluck('id')->all());
        // Add permissions for isotope-analyst
        $isoanalystrole->permissions()->syncWithoutDetaching($permissions->where('table_name', '=', 'isotopes')->pluck('id')->all());

        // Isotopes Batches Roles and Permissions
        $dataType = $this->dataType('slug', 'isotope_batches');
        if (!$dataType->exists) {
            $dataType->fill([ 'name' => 'isotope_batches', 'display_name_singular' => 'Isotope Batch', 'display_name_plural' => 'Isotope Batches',
                'icon' => 'voyager-company', 'model_name' => 'App\\IsotopeBatch', 'policy_name' => 'App\\Policies\\IsotopeBatchPolicy',
                'controller' => '', 'generate_permissions' => 1, 'description' => '',
            ])->save();
        }
        $permissions = Permission::firstOrNew(['table_name' => 'isotope_batches']);
        if (!$permissions->exists) {
            Permission::generateFor('isotope_batches');
        }
        // Add permissions for admin
        $adminrole->permissions()->syncWithoutDetaching($permissions->where('table_name', '=', 'isotope_batches')->pluck('id')->all());
        // Add permissions for orgadmin
        $orgadminrole->permissions()->syncWithoutDetaching($permissions->where('table_name', '=', 'isotope_batches')->pluck('id')->all());
        // Add permissions for manager
        $managerrole->permissions()->syncWithoutDetaching($permissions->where('table_name', '=', 'isotope_batches')->pluck('id')->all());
        // Add permissions for isotope-analyst
        $isoanalystrole->permissions()->syncWithoutDetaching($permissions->where('table_name', '=', 'isotope_batches')->pluck('id')->all());

        // Export Files Roles and Permissions
        $dataType = $this->dataType('slug', 'export_file_details');
        if (!$dataType->exists) {
            $dataType->fill([ 'name' => 'export_file_details', 'display_name_singular' => 'Export File', 'display_name_plural' => 'Export Files',
                'icon' => 'voyager-company', 'model_name' => '', 'policy_name' => '',
                'controller' => '', 'generate_permissions' => 1, 'description' => '',
            ])->save();
        }
        $permissions = Permission::firstOrNew(['table_name' => 'export_file_details']);
        if (!$permissions->exists) {
            Permission::generateFor('export_file_details');
        }
        // Add permissions for admin
        $adminrole->permissions()->syncWithoutDetaching($permissions->where('table_name', '=', 'export_file_details')->pluck('id')->all());
        // Add permissions for orgadmin
        $orgadminrole->permissions()->syncWithoutDetaching($permissions->where('table_name', '=', 'export_file_details')->pluck('id')->all());
        // Add permissions for manager
        $managerrole->permissions()->syncWithoutDetaching($permissions->where('table_name', '=', 'export_file_details')->pluck('id')->all());
        // Add permissions for anthropologist
        $anthrorole->permissions()->syncWithoutDetaching($permissions->where('table_name', '=', 'export_file_details')->pluck('id')->all());

        // Import Files Roles and Permissions
        $dataType = $this->dataType('slug', 'import_file_details');
        if (!$dataType->exists) {
            $dataType->fill([ 'name' => 'import_file_details', 'display_name_singular' => 'Import File', 'display_name_plural' => 'Import Files',
                'icon' => 'voyager-company', 'model_name' => '', 'policy_name' => '',
                'controller' => '', 'generate_permissions' => 1, 'description' => '',
            ])->save();
        }
        $permissions = Permission::firstOrNew(['table_name' => 'import_file_details']);
        if (!$permissions->exists) {
            Permission::generateFor('import_file_details');
        }
        // Add permissions for admin
        $adminrole->permissions()->syncWithoutDetaching($permissions->where('table_name', '=', 'import_file_details')->pluck('id')->all());
        // Add permissions for orgadmin
        $orgadminrole->permissions()->syncWithoutDetaching($permissions->where('table_name', '=', 'import_file_details')->pluck('id')->all());

        // Haplogroups Roles and Permissions
        $dataType = $this->dataType('slug', 'haplogroups');
        if (!$dataType->exists) {
            $dataType->fill([ 'name' => 'haplogroups', 'display_name_singular' => 'Haplogroup', 'display_name_plural' => 'Haplogroups',
                'icon' => 'voyager-company', 'model_name' => 'App\\Haplogroup', 'policy_name' => 'App\\Policies\\HaplogroupPolicy',
                'controller' => '', 'generate_permissions' => 1, 'description' => '',
            ])->save();
        }
        $permissions = Permission::firstOrNew(['table_name' => 'haplogroups']);
        if (!$permissions->exists) {
            Permission::generateFor('haplogroups');
        }
        // Add permissions for admin
        $adminrole->permissions()->syncWithoutDetaching($permissions->where('table_name', '=', 'haplogroups')->pluck('id')->all());
        // Add permissions for orgadmin
        $orgadminrole->permissions()->syncWithoutDetaching($permissions->where('table_name', '=', 'haplogroups')->pluck('id')->all());
        // Add permissions for manager
        $managerrole->permissions()->syncWithoutDetaching($permissions->where('table_name', '=', 'haplogroups')->pluck('id')->all());

        $role = Role::where('name', 'isotope-analyst')->firstOrFail();
        $permissions = Permission::firstOrNew(['table_name' => 'skeletal_elements']);
        // Add permissions for isotope-analyst
        $role->permissions()->syncWithoutDetaching($permissions->where('key', '=', 'browse_skeletal_elements')->pluck('id')->all());
        $role->permissions()->syncWithoutDetaching($permissions->where('key', '=', 'read_skeletal_elements')->pluck('id')->all());

        // Tags Roles and Permissions
        $dataType = $this->dataType('slug', 'tags');
        if (!$dataType->exists) {
            $dataType->fill([ 'name' => 'tags', 'display_name_singular' => 'Tag', 'display_name_plural' => 'Tags',
                'icon' => 'voyager-tag', 'model_name' => 'App\\Tag', 'policy_name' => 'App\\Policies\\TagPolicy',
                'controller' => '', 'generate_permissions' => 1, 'description' => '',
            ])->save();
        }
        $permissions = Permission::firstOrNew(['table_name' => 'tags']);
        if (!$permissions->exists) {
            Permission::generateFor('tags');
        }
        // Add permissions for admin
        $adminrole->permissions()->syncWithoutDetaching($permissions->where('table_name', '=', 'tags')->pluck('id')->all());
        // Add permissions for orgadmin
        $orgadminrole->permissions()->syncWithoutDetaching($permissions->where('table_name', '=', 'tags')->pluck('id')->all());
        // Add permissions for manager
        $managerrole->permissions()->syncWithoutDetaching($permissions->where('table_name', '=', 'tags')->pluck('id')->all());
        // Add permissions for anthropologist
        $anthrorole->permissions()->syncWithoutDetaching($permissions->where('table_name', '=', 'tags')->pluck('id')->all());
        // Add permissions for dna-analyst
        $dnaanalystrole->permissions()->syncWithoutDetaching($permissions->where('table_name', '=', 'tags')->pluck('id')->all());
        // Add permissions for isotope-analyst
        $isoanalystrole->permissions()->syncWithoutDetaching($permissions->where('table_name', '=', 'tags')->pluck('id')->all());

        // Comments Roles and Permissions
        $dataType = $this->dataType('slug', 'comments');
        if (!$dataType->exists) {
            $dataType->fill([ 'name' => 'comments', 'display_name_singular' => 'Comment', 'display_name_plural' => 'Comments',
                'icon' => 'voyager-comment', 'model_name' => 'App\\Comment', 'policy_name' => 'App\\Policies\\CommentPolicy',
                'controller' => '', 'generate_permissions' => 1, 'description' => '',
            ])->save();
        }
        $permissions = Permission::firstOrNew(['table_name' => 'comments']);
        if (!$permissions->exists) {
            Permission::generateFor('comments');
        }
        // Add permissions for admin
        $adminrole->permissions()->syncWithoutDetaching($permissions->where('table_name', '=', 'comments')->pluck('id')->all());
        // Add permissions for orgadmin
        $orgadminrole->permissions()->syncWithoutDetaching($permissions->where('table_name', '=', 'comments')->pluck('id')->all());
        // Add permissions for manager
        $managerrole->permissions()->syncWithoutDetaching($permissions->where('table_name', '=', 'comments')->pluck('id')->all());
        // Add permissions for anthropologist
        $anthrorole->permissions()->syncWithoutDetaching($permissions->where('table_name', '=', 'comments')->pluck('id')->all());
        // Add permissions for dna-analyst
        $dnaanalystrole->permissions()->syncWithoutDetaching($permissions->where('table_name', '=', 'comments')->pluck('id')->all());
        // Add permissions for isotope-analyst
        $isoanalystrole->permissions()->syncWithoutDetaching($permissions->where('table_name', '=', 'comments')->pluck('id')->all());

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
