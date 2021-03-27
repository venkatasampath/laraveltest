<?php
/**
 * Cora Test Data Seeder
 *
 * @category   Cora Test Data Seeder
 * @package    Seeder
 * @author     Sachin Pawaskar<spawaskar@unomaha.edu>
 * @copyright  2016-2019
 * @license    The MIT License (MIT)
 * @version    GIT: $Id$
 * @since      File available since Release 1.1.0
 */

use App\Org;
use App\User;
use App\Project;
use App\Utility\Memory;
use Illuminate\Database\Seeder;
use TCG\Voyager\Models\Role;

/**
 * Class CoraTestDataSeeder
 * This is the seeder class for version 1.1.0 changes
 */
class CoraTestDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (config('app.env') === 'production') {
            $this->command->info('------------------------------------------------------------------------!');
            $this->command->info('      ERROR: Cannot create test data in PRODUCTION Environment          !');
            $this->command->info('------------------------------------------------------------------------!');
            return;
        }

        Memory::dump_usage(true);
        ini_set("memory_limit","512M");

        $this->command->info('------------------------------------------------------------------------!');
        $this->command->info('      Start: Seeding CoRA Version 1.1.0 Data                            !');
        $this->command->info('------------------------------------------------------------------------!');

        // Call protected functions in class, that are relevant for this release.
        $this->createTestUsers();

        $this->command->info('------------------------------------------------------------------------!');
        $this->command->info('        End: Seeding CoRA Version 1.1.0 Data                            !');
        $this->command->info('------------------------------------------------------------------------!');

        Memory::dump_usage(true);
    }

    protected function createTestUsers()
    {
        $orgUNO = Org::where('acronym', '=', 'UNO')->first();
        $orgDPAA = Org::where('acronym', '=', 'DPAA')->first();
        $role_admin = Role::where('name', '=', 'admin')->firstOrFail();
        $role_orgadmin = Role::where('name', '=', 'orgadmin')->firstOrFail();
        $role_manager = Role::where('name', '=', 'manager')->firstOrFail();
        $role_anthro = Role::where('name', '=', 'anthropologist')->firstOrFail();
        $role_dna_analyst = Role::where('name', '=', 'dna-analyst')->firstOrFail();
        $role_iso_analyst = Role::where('name', '=', 'isotope-analyst')->firstOrFail();
        $projectUSSOklahoma = Project::where('name', '=', 'USS Oklahoma')->first();
        $projectBuna = Project::where('name', '=', 'Buna')->first();

        $user = User::firstOrNew(['email' => 'test.org.admin@unomaha.edu']);
        if (!$user->exists) {
            $user->fill(['org_id' => $orgDPAA->id, 'name' => 'Org Administrator', 'password' => '$2y$10$xGNVqISDs41Yp5Kcmsw3i./JmB0OydaUN7n.930eRJG7.kCogTO4W',
                'email' => 'test.org.admin@unomaha.edu', 'active' => true, 'role_id' => $role_orgadmin->id,
                'first_name' => 'test', 'last_name' => 'org admin', 'display_name' => 'test org admin',
                'avatar' => 'https://spawaskar-cora.s3.us-west-2.amazonaws.com/Users/Default/default.png',
                'api_token'=> 'QbUzD9OLwRwYXgZMuFQcUQLpkvpJBfTk3DkUQxGnxa0njBb67mJ69zBWI8hx',
                'created_by' => 'System', 'updated_by' => 'System'
            ])->save();

            $user->projects()->sync( array(
                $projectBuna->id => array( 'default' => true, 'created_by' => 'System', 'updated_by' => 'System', 'created_at' => date_create(), 'updated_at' => date_create() ),
                $projectUSSOklahoma->id => array( 'default' => false, 'created_by' => 'System', 'updated_by' => 'System', 'created_at' => date_create(), 'updated_at' => date_create() ),
            ));
        }
        $user = User::firstOrNew(['email' => 'test.org.manager@unomaha.edu']);
        if (!$user->exists) {
            $user->fill(['org_id' => $orgDPAA->id, 'name' => 'Org Manager', 'password' => '$2y$10$xGNVqISDs41Yp5Kcmsw3i./JmB0OydaUN7n.930eRJG7.kCogTO4W',
                'email' => 'test.org.manager@unomaha.edu', 'active' => true, 'role_id' => $role_manager->id,
                'first_name' => 'test', 'last_name' => 'org manager', 'display_name' => 'test org manager',
                'avatar' => 'https://spawaskar-cora.s3.us-west-2.amazonaws.com/Users/Default/default.png',
                'api_token'=> 'UNtZGa0nXdy00qb3ICdwjYYybmgR0l20nFc2By7okos7gsvInj2Z1E7RxM3a',
                'created_by' => 'System', 'updated_by' => 'System'
            ])->save();

            $user->projects()->sync( array(
                $projectBuna->id => array( 'default' => true, 'created_by' => 'System', 'updated_by' => 'System', 'created_at' => date_create(), 'updated_at' => date_create() ),
                $projectUSSOklahoma->id => array( 'default' => false, 'created_by' => 'System', 'updated_by' => 'System', 'created_at' => date_create(), 'updated_at' => date_create() ),
            ));
        }
        $user = User::firstOrNew(['email' => 'test.anthro.analyst.project.lead@unomaha.edu']);
        if (!$user->exists) {
            $user->fill(['org_id' => $orgDPAA->id, 'name' => 'Anthro Analyst Project Lead', 'password' => '$2y$10$xGNVqISDs41Yp5Kcmsw3i./JmB0OydaUN7n.930eRJG7.kCogTO4W',
                'email' => 'test.anthro.analyst.project.lead@unomaha.edu', 'active' => true, 'role_id' => $role_anthro->id,
                'first_name' => 'test', 'last_name' => 'anthro analyst project lead', 'display_name' => 'test anthro analyst project lead',
                'avatar' => 'https://spawaskar-cora.s3.us-west-2.amazonaws.com/Users/Default/default.png',
                'api_token'=> 'YB4fj5ApYDFNqN3JbiZCcohdvmH0imzS3gDT8CfKXXXPvzY0Rd4kDJ24YnHm',
                'created_by' => 'System', 'updated_by' => 'System'
            ])->save();

            $user->projects()->sync( array(
                $projectBuna->id => array( 'default' => true, 'created_by' => 'System', 'updated_by' => 'System', 'created_at' => date_create(), 'updated_at' => date_create() ),
                $projectUSSOklahoma->id => array( 'default' => false, 'created_by' => 'System', 'updated_by' => 'System', 'created_at' => date_create(), 'updated_at' => date_create() ),
            ));
            $projectBuna->update(['manager_id' => $user->id]);
        }
        $user = User::firstOrNew(['email' => 'test.anthro.analyst@unomaha.edu']);
        if (!$user->exists) {
            $user->fill(['org_id' => $orgDPAA->id, 'name' => 'Anthro Analyst', 'password' => '$2y$10$xGNVqISDs41Yp5Kcmsw3i./JmB0OydaUN7n.930eRJG7.kCogTO4W',
                'email' => 'test.anthro.analyst@unomaha.edu', 'active' => true, 'role_id' => $role_anthro->id,
                'first_name' => 'test', 'last_name' => 'anthro analyst', 'display_name' => 'test anthro analyst',
                'avatar' => 'https://spawaskar-cora.s3.us-west-2.amazonaws.com/Users/Default/default.png',
                'api_token'=> 'zijaNN5p3v250jSlA4XN9BpeRawTYXcT93kGgkptQMxGLamGwdDFyEGD3P5M',
                'created_by' => 'System', 'updated_by' => 'System'
            ])->save();

            $user->projects()->sync( array(
                $projectBuna->id => array( 'default' => true, 'created_by' => 'System', 'updated_by' => 'System', 'created_at' => date_create(), 'updated_at' => date_create() ),
                $projectUSSOklahoma->id => array( 'default' => false, 'created_by' => 'System', 'updated_by' => 'System', 'created_at' => date_create(), 'updated_at' => date_create() ),
            ));
        }
        $user = User::firstOrNew(['email' => 'test.dna.analyst@unomaha.edu']);
        if (!$user->exists) {
            $user->fill(['org_id' => $orgDPAA->id, 'name' => 'DNA Analyst', 'password' => '$2y$10$xGNVqISDs41Yp5Kcmsw3i./JmB0OydaUN7n.930eRJG7.kCogTO4W',
                'email' => 'test.dna.analyst@unomaha.edu', 'active' => true, 'role_id' => $role_dna_analyst->id,
                'first_name' => 'test', 'last_name' => 'dna analyst', 'display_name' => 'test dna analyst',
                'avatar' => 'https://spawaskar-cora.s3.us-west-2.amazonaws.com/Users/Default/default.png',
                'api_token'=> 'OXJBJ0dEgy5nbUVOaKQA0QCJHyPgU8xEKGXNH0XUw52RBGc93XyBY8CK5HQp',
                'created_by' => 'System', 'updated_by' => 'System'
            ])->save();

            $user->projects()->sync( array(
                $projectBuna->id => array( 'default' => true, 'created_by' => 'System', 'updated_by' => 'System', 'created_at' => date_create(), 'updated_at' => date_create() ),
                $projectUSSOklahoma->id => array( 'default' => false, 'created_by' => 'System', 'updated_by' => 'System', 'created_at' => date_create(), 'updated_at' => date_create() ),
            ));
        }
        $user = User::firstOrNew(['email' => 'test.isotope.analyst@unomaha.edu']);
        if (!$user->exists) {
            $user->fill(['org_id' => $orgDPAA->id, 'name' => 'Isotope Analyst', 'password' => '$2y$10$xGNVqISDs41Yp5Kcmsw3i./JmB0OydaUN7n.930eRJG7.kCogTO4W',
                'email' => 'test.isotope.analyst@unomaha.edu', 'active' => true, 'role_id' => $role_iso_analyst->id,
                'first_name' => 'test', 'last_name' => 'anthro isotope', 'display_name' => 'test isotope analyst',
                'avatar' => 'https://spawaskar-cora.s3.us-west-2.amazonaws.com/Users/Default/default.png',
                'api_token'=> 'Xe9wSS4mJBfBS6MWCxD3dhimDlUsiDqp3KWmiIe6mJzL9cDVoAdX6zqhBeUt',
                'created_by' => 'System', 'updated_by' => 'System'
            ])->save();

            $user->projects()->sync( array(
                $projectBuna->id => array( 'default' => true, 'created_by' => 'System', 'updated_by' => 'System', 'created_at' => date_create(), 'updated_at' => date_create() ),
                $projectUSSOklahoma->id => array( 'default' => false, 'created_by' => 'System', 'updated_by' => 'System', 'created_at' => date_create(), 'updated_at' => date_create() ),
            ));
        }

        // UNO Test Users
        $user = User::firstOrNew(['email' => 'testuno@unomaha.edu']);
        if (!$user->exists) {
            $user->fill(['org_id' => $orgUNO->id, 'name' => 'TestUser-UNO', 'password' => '$2y$10$xGNVqISDs41Yp5Kcmsw3i./JmB0OydaUN7n.930eRJG7.kCogTO4W',
                'email' => 'testuno@unomaha.edu', 'active' => true, 'role_id' => $role_anthro->id,
                'first_name' => 'test', 'last_name' => 'uno', 'display_name' => 'test uno',
                'avatar' => 'https://spawaskar-cora.s3.us-west-2.amazonaws.com/Users/Default/default.png',
                'api_token'=> 'zijaNN5p3v250jSlA4XN9BpeRawTYXcT93kGgkptQMxGLamGwdDFyEGD3PSP',
                'created_by' => 'System', 'updated_by' => 'System'
            ])->save();
        }
        $user = User::firstOrNew(['email' => 'testmanageruno@unomaha.edu']);
        if (!$user->exists) {
            $user->fill(['org_id' => $orgUNO->id, 'name' => 'TestUserManager-UNO', 'password' => '$2y$10$xGNVqISDs41Yp5Kcmsw3i./JmB0OydaUN7n.930eRJG7.kCogTO4W',
                'email' => 'testmanageruno@unomaha.edu', 'active' => true, 'role_id' => $role_manager->id,
                'first_name' => 'test', 'last_name' => 'manager uno', 'display_name' => 'test manager uno',
                'avatar' => 'https://spawaskar-cora.s3.us-west-2.amazonaws.com/Users/Default/default.png',
                'api_token'=> 'UNtZGa0nXdy00qb3ICdwjYYybmgR0l20nFc2By7okos7gsvInj2Z1E7RxMSP',
                'created_by' => 'System', 'updated_by' => 'System'
            ])->save();
        }
        $user = User::firstOrNew(['email' => 'testorgadminuno@unomaha.edu']);
        if (!$user->exists) {
            $user->fill(['org_id' => $orgUNO->id, 'name' => 'TestUserOrgAdmin-UNO', 'password' => '$2y$10$xGNVqISDs41Yp5Kcmsw3i./JmB0OydaUN7n.930eRJG7.kCogTO4W',
                'email' => 'testorgadminuno@unomaha.edu', 'active' => true, 'role_id' => $role_orgadmin->id,
                'first_name' => 'test', 'last_name' => 'org admin uno', 'display_name' => 'test org admin uno',
                'avatar' => 'https://spawaskar-cora.s3.us-west-2.amazonaws.com/Users/Default/default.png',
                'api_token'=> 'QbUzD9OLwRwYXgZMuFQcUQLpkvpJBfTk3DkUQxGnxa0njBb67mJ69zBWI8SP',
                'created_by' => 'System', 'updated_by' => 'System'
            ])->save();
        }

        $user = User::firstOrNew(['email' => 'nsundaragopalan@unomaha.edu']);
        if (!$user->exists) {
            $user->fill(['name' => 'Narahari Sundaragopalan', 'password' => '$2y$10$xGNVqISDs41Yp5Kcmsw3i./JmB0OydaUN7n.930eRJG7.kCogTO4W',
                'first_name' => 'Narahari', 'last_name' => 'Sundaragopalan', 'display_name' => 'Hari Sundaragopalan',
                'email' => 'nsundaragopalan@unomaha.edu', 'active' => true, 'role_id' => $role_anthro->id,
                'avatar' => 'https://spawaskar-cora.s3.us-west-2.amazonaws.com/Users/Default/default.png',
                'created_by' => 'System', 'updated_by' => 'System'
            ])->save();

            $user->projects()->sync( array(
                $projectBuna->id => array( 'default' => true, 'created_by' => 'System', 'updated_by' => 'System', 'created_at' => date_create(), 'updated_at' => date_create() ),
                $projectUSSOklahoma->id => array( 'default' => false, 'created_by' => 'System', 'updated_by' => 'System', 'created_at' => date_create(), 'updated_at' => date_create() ),
            ));
        }


        // Other UNO Student Users
        $user = User::firstOrNew(['email' => 'aavorthmann@unomaha.edu']);
        if (!$user->exists) {
            $user->fill(['org_id' => $orgDPAA->id, 'name' => 'Allison Vorthmann', 'password' => '$2y$10$xGNVqISDs41Yp5Kcmsw3i./JmB0OydaUN7n.930eRJG7.kCogTO4W',
                'first_name' => 'Allison', 'last_name' => 'Vorthmann', 'display_name' => 'Allison Vorthmann',
                'email' => 'aavorthmann@unomaha.edu', 'active' => true, 'role_id' => $role_anthro->id,
                'avatar' => 'https://spawaskar-cora.s3.us-west-2.amazonaws.com/Users/Default/default.png',
                'created_by' => 'System', 'updated_by' => 'System'
            ])->save();

            $user->projects()->sync( array(
                $projectBuna->id => array( 'default' => true, 'created_by' => 'System', 'updated_by' => 'System', 'created_at' => date_create(), 'updated_at' => date_create() ),
                $projectUSSOklahoma->id => array( 'default' => false, 'created_by' => 'System', 'updated_by' => 'System', 'created_at' => date_create(), 'updated_at' => date_create() ),
            ));
        }

        $user = User::firstOrNew(['email' => 'bisamov@unomaha.edu']);
        if (!$user->exists) {
            $user->fill(['org_id' => $orgDPAA->id, 'name' => 'Bobodzhon Isamov', 'password' => '$2y$10$xGNVqISDs41Yp5Kcmsw3i./JmB0OydaUN7n.930eRJG7.kCogTO4W',
                'first_name' => 'Bobodzhon', 'last_name' => 'Isamov', 'display_name' => 'Bobodzhon Isamov',
                'email' => 'bisamov@unomaha.edu', 'active' => true, 'role_id' => $role_anthro->id,
                'avatar' => 'https://spawaskar-cora.s3.us-west-2.amazonaws.com/Users/Default/default.png',
                'created_by' => 'System', 'updated_by' => 'System'
            ])->save();

            $user->projects()->sync( array(
                $projectBuna->id => array( 'default' => true, 'created_by' => 'System', 'updated_by' => 'System', 'created_at' => date_create(), 'updated_at' => date_create() ),
                $projectUSSOklahoma->id => array( 'default' => false, 'created_by' => 'System', 'updated_by' => 'System', 'created_at' => date_create(), 'updated_at' => date_create() ),
            ));
        }

        $user = User::firstOrNew(['email' => 'jasminesmit1@unomaha.edu']);
        if (!$user->exists) {
            $user->fill(['org_id' => $orgDPAA->id, 'name' => 'Jasmine Smith', 'password' => '$2y$10$xGNVqISDs41Yp5Kcmsw3i./JmB0OydaUN7n.930eRJG7.kCogTO4W',
                'first_name' => 'Jasmine', 'last_name' => 'Smith', 'display_name' => 'Jasmine Smith',
                'email' => 'jasminesmit1@unomaha.edu', 'active' => true, 'role_id' => $role_anthro->id,
                'avatar' => 'https://spawaskar-cora.s3.us-west-2.amazonaws.com/Users/Default/default.png',
                'created_by' => 'System', 'updated_by' => 'System'
            ])->save();

            $user->projects()->sync( array(
                $projectBuna->id => array( 'default' => true, 'created_by' => 'System', 'updated_by' => 'System', 'created_at' => date_create(), 'updated_at' => date_create() ),
                $projectUSSOklahoma->id => array( 'default' => false, 'created_by' => 'System', 'updated_by' => 'System', 'created_at' => date_create(), 'updated_at' => date_create() ),
            ));
        }

        $user = User::firstOrNew(['email' => 'kbellaryvijaya@unomaha.edu']);
        if (!$user->exists) {
            $user->fill(['org_id' => $orgDPAA->id, 'name' => 'Karthik Bellary', 'password' => '$2y$10$xGNVqISDs41Yp5Kcmsw3i./JmB0OydaUN7n.930eRJG7.kCogTO4W',
                'first_name' => 'Karthik', 'last_name' => 'Bellary', 'display_name' => 'Karthik Bellary',
                'email' => 'kbellaryvijaya@unomaha.edu', 'active' => true, 'role_id' => $role_anthro->id,
                'avatar' => 'https://spawaskar-cora.s3.us-west-2.amazonaws.com/Users/Default/default.png',
                'created_by' => 'System', 'updated_by' => 'System'
            ])->save();

            $user->projects()->sync( array(
                $projectBuna->id => array( 'default' => true, 'created_by' => 'System', 'updated_by' => 'System', 'created_at' => date_create(), 'updated_at' => date_create() ),
                $projectUSSOklahoma->id => array( 'default' => false, 'created_by' => 'System', 'updated_by' => 'System', 'created_at' => date_create(), 'updated_at' => date_create() ),
            ));
        }

        $user = User::firstOrNew(['email' => 'smakandar@unomaha.edu']);
        if (!$user->exists) {
            $user->fill(['org_id' => $orgDPAA->id, 'name' => 'Shamrose Makandar', 'password' => '$2y$10$xGNVqISDs41Yp5Kcmsw3i./JmB0OydaUN7n.930eRJG7.kCogTO4W',
                'first_name' => 'Shamrose', 'last_name' => 'Makandar', 'display_name' => 'Shamrose Makandar',
                'email' => 'smakandar@unomaha.edu', 'active' => true, 'role_id' => $role_anthro->id,
                'avatar' => 'https://spawaskar-cora.s3.us-west-2.amazonaws.com/Users/Default/default.png',
                'created_by' => 'System', 'updated_by' => 'System'
            ])->save();

            $user->projects()->sync( array(
                $projectBuna->id => array( 'default' => true, 'created_by' => 'System', 'updated_by' => 'System', 'created_at' => date_create(), 'updated_at' => date_create() ),
                $projectUSSOklahoma->id => array( 'default' => false, 'created_by' => 'System', 'updated_by' => 'System', 'created_at' => date_create(), 'updated_at' => date_create() ),
            ));
        }

        $user = User::firstOrNew(['email' => 'sraut@unomaha.edu']);
        if (!$user->exists) {
            $user->fill(['org_id' => $orgDPAA->id, 'name' => 'Stuti Raut', 'password' => '$2y$10$xGNVqISDs41Yp5Kcmsw3i./JmB0OydaUN7n.930eRJG7.kCogTO4W',
                'first_name' => 'Stuti', 'last_name' => 'Raut', 'display_name' => 'Stuti Raut',
                'email' => 'sraut@unomaha.edu', 'active' => true, 'role_id' => $role_anthro->id,
                'avatar' => 'https://spawaskar-cora.s3.us-west-2.amazonaws.com/Users/Default/default.png',
                'created_by' => 'System', 'updated_by' => 'System'
            ])->save();

            $user->projects()->sync( array(
                $projectBuna->id => array( 'default' => true, 'created_by' => 'System', 'updated_by' => 'System', 'created_at' => date_create(), 'updated_at' => date_create() ),
                $projectUSSOklahoma->id => array( 'default' => false, 'created_by' => 'System', 'updated_by' => 'System', 'created_at' => date_create(), 'updated_at' => date_create() ),
            ));
        }
    }
}
