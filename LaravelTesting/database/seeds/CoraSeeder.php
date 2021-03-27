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

use App\Accession;
use App\Org;
use App\Profile;
use App\Project;
use App\Tag;
use App\User;
use App\Utility\Memory;
use DevDojo\Chatter\Models\Category;
use DevDojo\Chatter\Models\Discussion;
use DevDojo\Chatter\Models\Post;
use Illuminate\Database\Seeder;
use TCG\Voyager\Models\Role;

class CoraSeeder extends Seeder
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
        $this->command->info('      Start: Seeding CoRA Orgs, User, Roles and Permissions         !');
        $this->command->info('------------------------------------------------------------------------!');
        $this->createUsers();
        $this->command->info('User, Role and Permission tables seeded!');
        $this->command->info('------------------------------------------------------------------------!');
        $this->command->info('        End: Seeding CoRA Orgs, User, Roles and Permissions         !');
        $this->command->info('------------------------------------------------------------------------!');

        $this->command->info('------------------------------------------------------------------------!');
        $this->command->info('                     Start: Seeding Profile, Tags                       !');
        $this->command->info('------------------------------------------------------------------------!');
        $this->createProfiles();
        $this->createTags();
        $this->command->info('------------------------------------------------------------------------!');
        $this->command->info('                      End: Seeding Profile, Tags                        !');
        $this->command->info('------------------------------------------------------------------------!');

        $this->command->info('------------------------------------------------------------------------!');
        $this->command->info('          Start: Seeding ProjectStatus, Projects, & Accessions          !');
        $this->command->info('------------------------------------------------------------------------!');
        $this->createProjectStatus();
        $this->createProjects();
        $this->createProjectUsers();
        $this->createAccessions();
        $this->createAccessions();
        $this->command->info('Organization, Project and Accession tables seeded!');
        $this->command->info('------------------------------------------------------------------------!');
        $this->command->info('          End: Seeding ProjectStatus, Projects, & Accessions            !');
        $this->command->info('------------------------------------------------------------------------!');
        Memory::dump_usage(true);

        $this->command->info('------------------------------------------------------------------------!');
        $this->command->info('        Start: Seeding Forensic Anthropology Base data tables           !');
        $this->command->info('------------------------------------------------------------------------!');

        $this->createDnaRegionTypes();
        $this->createLabs();
        $this->command->info('Cora Labs tables seeded!');

        $this->call(SkeletalBonesTableSeeder::class); // Seed the Skeletal Bones data - name, type, group, paired
        $this->command->info('SkeletalBones tables seeded!');

        $this->call(TaphonomysTableSeeder::class); // Seed the Taphonomy data - branch, category, type, subtype
        $this->command->info('Taphonomys tables seeded!');

        $this->call(HaplogroupsTableSeeder::class); // Seed the Haplogroup data - letter, ancestry
        $this->command->info('Haplogroups tables seeded!');

        $this->call(ArticulationsTableSeeder::class); // Seed articulations data
        $this->command->info('Articulations table seeded!');
 
        $this->call(MeasurementsTableSeeder::class); // Seed the Measurements data - sb_id, name, display_name, description, length
        $this->command->info('Measurements tables seeded!');

        $this->call(ZonesTableSeeder::class); // Seed the Zones data - sb_id, name, display_name, description
        $this->command->info('Zones tables seeded!');

        $this->call(MethodsTableSeeder::class); // Seed the Methods data - sb_id, name, display_name, description
        $this->command->info('Method table seeded!');
      
        $this->call(MethodFeaturesTableSeeder::class);
        $this->command->info('Method_Feature table seeded!');
    
        $this->call(DentalTableSeeder::class);
        $this->command->info('Dental table seeded!');

        // Seed the PTA - Pathology, Trauma and Amonaly data tables
        $this->call(PathologysTableSeeder::class);
        $this->call(TraumasTableSeeder::class);
        $this->call(AnomalysTableSeeder::class);
        $this->command->info('Pathology, Trauma and Amonaly tables seeded!');

        $this->command->info('Start - Seeding Chatter/Forum related data - Categories, Discussions and Posts!');
        $this->createChatterCategories();
        $this->createChatterDiscussions();
        $this->createChatterPosts();
        $this->command->info('End - Seeding Chatter/Forum related data - Completed!');

        $this->command->info('------------------------------------------------------------------------!');
        $this->command->info('           End: Seeding Forensic Anthropology Base data tables          !');
        $this->command->info('------------------------------------------------------------------------!');

        Memory::dump_usage(true);
    }

    protected function createUsers()
    {
        $orgUNO = Org::where('acronym', '=', 'UNO')->first();
        $role_admin = Role::where('name', '=', 'admin')->firstOrFail();
        $role_orgadmin = Role::where('name', '=', 'orgadmin')->firstOrFail();
        $role_manager = Role::where('name', '=', 'manager')->firstOrFail();
        $role_anthro = Role::where('name', '=', 'anthropologist')->firstOrFail();

        $user = User::firstOrNew(['email' => 'nmcelroy@unomaha.edu']);
        if (!$user->exists) {
            $user->fill(['org_id' => $orgUNO->id, 'name' => 'Nicole McElroy', 'password' => '$2y$10$xGNVqISDs41Yp5Kcmsw3i./JmB0OydaUN7n.930eRJG7.kCogTO4W',
                'email' => 'nmcelroy@unomaha.edu', 'active' => true, 'role_id' => $role_admin->id,
                'created_by' => 'System', 'updated_by' => 'System'
            ])->save();
        }
        $user = User::firstOrNew(['email' => 'rpernst@unomaha.edu']);
        if (!$user->exists) {
            $user->fill(['org_id' => $orgUNO->id, 'name' => 'Ryan Ernst', 'password' => '$2y$10$xGNVqISDs41Yp5Kcmsw3i./JmB0OydaUN7n.930eRJG7.kCogTO4W',
                'email' => 'rpernst@unomaha.edu', 'active' => true, 'role_id' => $role_admin->id,
                'created_by' => 'System', 'updated_by' => 'System'
            ])->save();
        }

        // UNO Test Users
        $user = User::firstOrNew(['email' => 'testuno@unomaha.edu']);
        if (!$user->exists) {
            $user->fill(['org_id' => $orgUNO->id, 'name' => 'TestUser-UNO', 'password' => '$2y$10$xGNVqISDs41Yp5Kcmsw3i./JmB0OydaUN7n.930eRJG7.kCogTO4W',
                'email' => 'testuno@unomaha.edu', 'active' => true, 'role_id' => $role_anthro->id, 'created_by' => 'System', 'updated_by' => 'System'
            ])->save();
        }
        $user = User::firstOrNew(['email' => 'testmanageruno@unomaha.edu']);
        if (!$user->exists) {
            $user->fill(['org_id' => $orgUNO->id, 'name' => 'TestUserManager-UNO', 'password' => '$2y$10$xGNVqISDs41Yp5Kcmsw3i./JmB0OydaUN7n.930eRJG7.kCogTO4W',
                'email' => 'testmanageruno@unomaha.edu', 'active' => true, 'role_id' => $role_manager->id, 'created_by' => 'System', 'updated_by' => 'System'
            ])->save();
        }
        $user = User::firstOrNew(['email' => 'testorgadminuno@unomaha.edu']);
        if (!$user->exists) {
            $user->fill(['org_id' => $orgUNO->id, 'name' => 'TestUserOrgAdmin-UNO', 'password' => '$2y$10$xGNVqISDs41Yp5Kcmsw3i./JmB0OydaUN7n.930eRJG7.kCogTO4W',
                'email' => 'testorgadminuno@unomaha.edu', 'active' => true, 'role_id' => $role_orgadmin->id, 'created_by' => 'System', 'updated_by' => 'System'
            ])->save();
        }
    }

    protected function createProfiles() {

        $profile = Profile::firstOrNew(['name' => 'mru_list_skeletalelements']);
        if (!$profile->exists) {
            $profile->fill(['name' => 'mru_list_skeletalelements', 'description' => 'MRU Specimens', 'default_value' => '5', 'kind' => 'int',
                'display_type' => 'number', 'display_values' => '{"min":0, "max":20, "step":1}',
                'help' => 'Number of Most Recently Used/Accessed (MRU List) Specimens to keep track off',
                'type' => 'user', 'group' => 'ui', 'display_order' => 2001,
                'created_by' => 'System', 'updated_by' => 'System', 'created_at' => date_create(), 'updated_at' => date_create()
            ])->save();
        }

        $profile = Profile::firstOrNew(['name' => 'default_project']);
        if (!$profile->exists) {
            $profile->fill(['name' => 'default_project', 'description' => 'Default Project', 'default_value' => '1', 'kind' => 'model',
                'display_type' => 'select', 'display_values' => '{"model":"Project", "field":"name", "orgFilter":true, "publicFilter":true}',
                'help' => 'Set the default project to use when user logs into the application',
                'type' => 'user', 'group' => 'se', 'display_order' => 2002,
                'created_by' => 'System', 'updated_by' => 'System', 'created_at' => date_create(), 'updated_at' => date_create()
            ])->save();
        }

        $profile = Profile::firstOrNew(['name' => 'accession']);
        if (!$profile->exists) {
            $profile->fill(['name' => 'accession', 'description' => 'Accession Number', 'default_value' => '', 'kind' => 'string',
                'display_type' => 'text', 'display_values' => '',
                'help' => 'If set, the accession number will be auto-populated on New Specimen screen',
                'type' => 'user', 'group' => 'se', 'display_order' => 2003,
                'created_by' => 'System', 'updated_by' => 'System', 'created_at' => date_create(), 'updated_at' => date_create()
            ])->save();
        }

        $profile = Profile::firstOrNew(['name' => 'provenance1']);
        if (!$profile->exists) {
            $profile->fill(['name' => 'provenance1', 'description' => 'Provenance1', 'default_value' => '', 'kind' => 'string',
                'display_type' => 'text', 'display_values' => '',
                'help' => 'If set, the provenance1 will be auto-populated on New Specimen screen',
                'type' => 'user', 'group' => 'se', 'display_order' => 2004,
                'created_by' => 'System', 'updated_by' => 'System', 'created_at' => date_create(), 'updated_at' => date_create()
            ])->save();
        }

        $profile = Profile::firstOrNew(['name' => 'provenance2']);
        if (!$profile->exists) {
            $profile->fill(['name' => 'provenance2', 'description' => 'Provenance2', 'default_value' => '', 'kind' => 'string',
                'display_type' => 'text', 'display_values' => '',
                'help' => 'If set, the provenance2 will be auto-populated on New Specimen screen',
                'type' => 'user', 'group' => 'se', 'display_order' => 2005,
                'created_by' => 'System', 'updated_by' => 'System', 'created_at' => date_create(), 'updated_at' => date_create()
            ])->save();
        }

        $profile = Profile::firstOrNew(['name' => 'default_lab']);
        if (!$profile->exists) {
            $profile->fill(['name' => 'default_lab', 'description' => 'Default Laboratory', 'default_value' => '1', 'kind' => 'model',
                'display_type' => 'select', 'display_values' => '{"model":"Lab", "field":"name"}',
                'help' => 'If set, the lab will be auto-populated on DNA association screen for Specimen',
                'type' => 'user', 'group' => 'se', 'display_order' => 2006,
                'created_by' => 'System', 'updated_by' => 'System', 'created_at' => date_create(), 'updated_at' => date_create()
            ])->save();
        }
    }

    protected function createProjectStatus()
    {
        if (DB::table('project_status')->count() === 0) {
            $statuses = array(
                array('display_name' => "Open", 'display_order' => 1,
                    'created_by' => 'System', 'updated_by' => 'System', 'created_at' => date_create(), 'updated_at' => date_create()),
                array('display_name' => "WIP-Inventory", 'display_order' => 2,
                    'created_by' => 'System', 'updated_by' => 'System', 'created_at' => date_create(), 'updated_at' => date_create()),
                array('display_name' => "WIP-Analytics", 'display_order' => 3,
                    'created_by' => 'System', 'updated_by' => 'System', 'created_at' => date_create(), 'updated_at' => date_create()),
                array('display_name' => "Closed", 'display_order' => 4,
                    'created_by' => 'System', 'updated_by' => 'System', 'created_at' => date_create(), 'updated_at' => date_create()),
            );
            DB::table('project_status')->insert($statuses);
        }
    }

    protected function createProjects()
    {
        $org_uno = Org::where('acronym', '=', 'UNO')->first()->id;
        $projectmanager = User::where('name', '=', 'Sachin Pawaskar')->first();
        $project_status_open = 1;

        $project = Project::firstOrNew(['name' => 'CoRA Demo']);
        if (!$project->exists) {
            $project->fill(['org_id' => $org_uno, 'name' => 'CoRA Demo', 'description' => 'CoRA Demo Project', 'status_id' => $project_status_open, 'public' => true,
                'manager_id' => $projectmanager->id, 'created_by' => 'System', 'updated_by' => 'System', 'created_at' => date_create(), 'updated_at' => date_create()
            ])->save();
        }
    }

    protected function createProjectUsers()
    {
        // Load Project
        $project_corademo = Project::where('name', '=', 'CoRA Demo')->first()->id;

        // Sachin Pawaskar
        $user = User::where('name', '=', 'Sachin Pawaskar')->first();
        if ($user->exists) {
            $user->projects()->sync( array(
                $project_corademo => array( 'default' => true, 'created_by' => 'System', 'updated_by' => 'System', 'created_at' => date_create(), 'updated_at' => date_create() ),
            ));
        }

        // Nicole McElroy
        $user = User::where('name', '=', 'Nicole McElroy')->first();
        if ($user->exists) {
            $user->projects()->sync( array(
                $project_corademo => array( 'default' => true, 'created_by' => 'System', 'updated_by' => 'System', 'created_at' => date_create(), 'updated_at' => date_create() ),
            ));
        }

        // Ryan Ernst
        $user = User::where('name', '=', 'Ryan Ernst')->first();
        if ($user->exists) {
            $user->projects()->sync( array(
                $project_corademo => array( 'default' => true, 'created_by' => 'System', 'updated_by' => 'System', 'created_at' => date_create(), 'updated_at' => date_create() ),
            ));
        }

        // TestUser-UNO
        $user = User::where('name', '=', 'TestUser-UNO')->first();
        if ($user->exists) {
            $user->projects()->sync( array(
                $project_corademo => array( 'default' => true, 'created_by' => 'System', 'updated_by' => 'System', 'created_at' => date_create(), 'updated_at' => date_create() ),
            ));
        }

        // TestUserManager-UNO
        $user = User::where('name', '=', 'TestUserManager-UNO')->first();
        if ($user->exists) {
            $user->projects()->sync( array(
                $project_corademo => array( 'default' => true, 'created_by' => 'System', 'updated_by' => 'System', 'created_at' => date_create(), 'updated_at' => date_create() ),
            ));
        }

        // TestUserOrgAdmin-UNO
        $user = User::where('name', '=', 'TestUserOrgAdmin-UNO')->first();
        if ($user->exists) {
            $user->projects()->sync( array(
                $project_corademo => array( 'default' => true, 'created_by' => 'System', 'updated_by' => 'System', 'created_at' => date_create(), 'updated_at' => date_create() ),
            ));
        }
    }

    protected function createAccessions()
    {
        $org_uno = Org::where('acronym', '=', 'UNO')->first()->id;
        $project_uno = Project::where('name', '=', 'CoRA Demo')->first()->id;

        $accession = Accession::firstOrNew(['number' => 'UNO-2016-212']);
        if (!$accession->exists) {
            $accession->fill(['org_id' => $org_uno, 'project_id' => $project_uno, 'number' => 'UNO-2016-212', 'provenance1' => null, 'provenance2' => null,
                'created_by' => 'System', 'updated_by' => 'System', 'created_at' => date_create(), 'updated_at' => date_create()
            ])->save();
        }
    }

    protected function createTags()
    {
        $tag = Tag::firstOrNew(['name' => 'Inventoried']);
        if (!$tag->exists) {
            $tag->fill(['name' => 'Inventoried'])->save();
        }
        $tag = Tag::firstOrNew(['name' => 'Reviewed']);
        if (!$tag->exists) {
            $tag->fill(['name' => 'Reviewed'])->save();
        }
    }

    protected function createLabs()
    {
        $labs = array(
            array('name' => 'AFDIL', 'type' => 'Genomics', 'description' => 'Army Field DNA Identification Laboratory',
                'created_by' => 'System', 'updated_by' => 'System', 'created_at' => date_create(), 'updated_at' => date_create()),
            array('name' => 'Another Lab', 'type' => 'Toxicology', 'description' => 'A-LAB focused on Toxicology',
                'created_by' => 'System', 'updated_by' => 'System', 'created_at' => date_create(), 'updated_at' => date_create()),
        );
        DB::table('labs')->insert($labs);
    }

    protected function createChatterCategories()
    {
        // CREATE THE CATEGORIES
        $category = Category::firstOrNew(['name' => 'Introductions']);
        if (!$category->exists) {
            $category->fill([ 'parent_id' => null, 'order' => 1,
                'name' => 'Introductions', 'color' => '#3498DB', 'slug' => 'introductions',
                'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),
            ])->save();
        }
        $category = Category::firstOrNew(['name' => 'Anthro Guides']);
        if (!$category->exists) {
            $category->fill([ 'parent_id' => null, 'order' => 2,
                'name'       => 'Anthro Guides',
                'color'      => '#0EAFCC',
                'slug'       => 'anthro_guides',
                'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),
            ])->save();
        }
        $category = Category::firstOrNew(['name' => 'General']);
        if (!$category->exists) {
            $category->fill([ 'parent_id' => null, 'order' => 3,
                'name'       => 'General',
                'color'      => '#2ECC71',
                'slug'       => 'general',
                'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),
            ])->save();
        }
        $category = Category::firstOrNew(['name' => 'Feedback']);
        if (!$category->exists) {
            $category->fill([ 'parent_id' => null, 'order' => 4,
                'name'       => 'Feedback',
                'color'      => '#9B59B6',
                'slug'       => 'feedback',
                'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),
            ])->save();
        }
        $category = Category::firstOrNew(['name' => 'Random']);
        if (!$category->exists) {
            $category->fill([ 'parent_id' => null, 'order' => 5,
                'name'       => 'Random',
                'color'      => '#E67E22',
                'slug'       => 'random',
                'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),
            ])->save();
        }

        // Anthro Guide children
        $category = Category::firstOrNew(['name' => 'Measurements']);
        if (!$category->exists) {
            $category->fill([ 'parent_id' => 2, 'order' => 1,
                'name'       => 'Measurements',
                'color'      => '#227ab5',
                'slug'       => 'measurements',
                'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),
            ])->save();
        }
        $category = Category::firstOrNew(['name' => 'Methods']);
        if (!$category->exists) {
            $category->fill([ 'parent_id' => 2, 'order' => 2,
                'name'       => 'Methods',
                'color'      => '#227ab5',
                'slug'       => 'methods',
                'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),
            ])->save();
        }
        $category = Category::firstOrNew(['name' => 'Zones']);
        if (!$category->exists) {
            $category->fill([ 'parent_id' => 2, 'order' => 3,
                'name'       => 'Zones',
                'color'      => '#227ab5',
                'slug'       => 'zones',
                'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),
            ])->save();
        }

        // Introduction children
//        $category = Category::firstOrNew(['name' => 'Rules']);
//        if (!$category->exists) {
//            $category->fill([ 'parent_id' => 1, 'order' => 1,
//                'name'       => 'Rules',
//                'color'      => '#227ab5',
//                'slug'       => 'rules',
//                'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),
//            ])->save();
//        }
//        $category = Category::firstOrNew(['name' => 'Basics']);
//        if (!$category->exists) {
//            $category->fill([ 'parent_id' => 5, 'order' => 1,
//                'name'       => 'Basics',
//                'color'      => '#195a86',
//                'slug'       => 'basics',
//                'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),
//            ])->save();
//        }
//        $category = Category::firstOrNew(['name' => 'Contribution']);
//        if (!$category->exists) {
//            $category->fill([ 'parent_id' => 5, 'order' => 2,
//                'name'       => 'Contribution',
//                'color'      => '#195a86',
//                'slug'       => 'contribution',
//                'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),
//            ])->save();
//        }
//        $category = Category::firstOrNew(['name' => 'About']);
//        if (!$category->exists) {
//            $category->fill([ 'parent_id' => 1, 'order' => 2,
//                'name'       => 'About',
//                'color'      => '#227ab5',
//                'slug'       => 'about',
//                'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),
//            ])->save();
//        }
    }

    protected function createChatterDiscussions()
    {
        // CREATE THE DISCUSSIONS
        $user = User::where('name', '=', 'Sachin Pawaskar')->first()->id;
        $discussion = Discussion::firstOrNew(['title' => 'Hello Everyone, This is my Introduction']);
        if (!$discussion->exists) {
            $discussion->fill([ 'chatter_category_id' => 1, 'title' => 'Hello Everyone, This is my Introduction',
                'user_id' => $user, 'sticky' => 0, 'views' => 0, 'answered' => 0, 'color' => '#239900',
                'created_at' => Carbon::now(), 'updated_at' => Carbon::now(), 'slug' => 'hello-everyone-this-is-my-introduction',
            ])->save();
        }
        $discussion = Discussion::firstOrNew(['title' => 'Login Information for CoRA']);
        if (!$discussion->exists) {
            $discussion->fill([ 'chatter_category_id' => 3, 'title' => 'Login Information for CoRA',
                'user_id' => $user, 'sticky' => 0, 'views' => 0, 'answered' => 0, 'color' => '#1a1067',
                'created_at' => Carbon::now(), 'updated_at' => Carbon::now(), 'slug' => 'login-information-for-cora',
            ])->save();
        }
        $discussion = Discussion::firstOrNew(['title' => 'Leaving Feedback']);
        if (!$discussion->exists) {
            $discussion->fill([ 'chatter_category_id' => 4, 'title' => 'Leaving Feedback',
                'user_id' => $user, 'sticky' => 0, 'views' => 0, 'answered' => 0, 'color' => '#8e1869',
                'created_at' => Carbon::now(), 'updated_at' => Carbon::now(), 'slug' => 'leaving-feedback',
            ])->save();
        }
        $discussion = Discussion::firstOrNew(['title' => 'Just a random post']);
        if (!$discussion->exists) {
            $discussion->fill([ 'chatter_category_id' => 5, 'title' => 'Just a random post',
                'user_id' => $user, 'sticky' => 0, 'views' => 0, 'answered' => 0, 'color' => '',
                'created_at' => Carbon::now(), 'updated_at' => Carbon::now(), 'slug' => 'just-a-random-post',
            ])->save();
        }
        $discussion = Discussion::firstOrNew(['title' => 'Welcome to the CoRA Ecosystem']);
        if (!$discussion->exists) {
            $discussion->fill([ 'chatter_category_id' => 3, 'title' => 'Welcome to the CoRA Ecosystem',
                'user_id' => $user, 'sticky' => 0, 'views' => 0, 'answered' => 0, 'color' => '',
                'created_at' => Carbon::now(), 'updated_at' => Carbon::now(), 'slug' => 'welcome-to-the-cora-ecosystem',
            ])->save();
        }
    }

    protected function createChatterPosts()
    {
        // CREATE THE POSTS
        $user = User::where('name', '=', 'Sachin Pawaskar')->first()->id;
        $post = Post::find(1);
        if (!isset($post)) {
            Post::insert([ 'chatter_discussion_id' => 1, 'user_id' => $user, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),
                'body' => '<p>I\'m Sachin Pawaskar, PhD, MBA, MS, an IT Professional, Developer, Educator, Researcher, and Open Source Enthusiast. I was introduced to Forensic Anthropology by my now close friend Dr. Franklin Damann from the Department of Defense POW/MIA Accounting Agency (DPAA). I\'m a proud supporter of their mission in bringing our fallen heroes home, which led me to my collaborative work on the Commingled Remain Analytics (CoRA) Ecosystem, an Open Community project, you can read all about CoRA at <a href="https://cora-docs.readthedocs.io" target="_blank">https://cora-docs.readthedocs.io</a></p>
        <p>You can check me out on twitter at <a href="http://www.twitter.com/spaws4" target="_blank">http://www.twitter.com/spaws4</a></p>
        <p>or you can visit my personal website at <a href="https://SachinPawaskarUNO.github.io" target="_blank">https://SachinPawaskarUNO.github.io</a></p>
        <p>It is recommended that you post a You should add an can visit my personal website at <a href="https://SachinPawaskarUNO.github.io" target="_blank">https://SachinPawaskarUNO.github.io</a></p>',
            ]);
        }
        $post = Post::find(2);
        if (!isset($post)) {
            Post::insert([ 'chatter_discussion_id' => 2, 'user_id' => $user, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),
                'body' => '<p>Hey!</p>
        <p>Thanks again for checking out CoRA.</p>
        <p>If you really like CoRA and want your own account send us information about yourself and your affiliation, we will get you added in :)</p>',
            ]);
        }
        /*
        if (!isset($post)) {
            Post::insert([ 'chatter_discussion_id' => 2, 'user_id' => $user, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),
                'body' => '<p>Hey!</p>
        <p>Thanks again for checking out CoRA. If you want to login with the default user you can login with the following credentials:</p>
        <p><strong>email address</strong>: corademouser@unomaha.edu</p>
        <p><strong>password</strong>: Password!2</p>
        <p>If you really like CoRA and want your own account send us information about yourself and your affiliation, we will get you added in :)</p>',
            ]);
        }
        */
        $post = Post::find(3);
        if (!isset($post)) {
            Post::insert([ 'chatter_discussion_id' => 3, 'user_id' => $user, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),
                'body' => '<p>If you would like to leave some feedback or have any issues be sure to visit the github page here: <a href="https://github.com/spawaskar-cora/cora-docs" target="_blank">https://github.com/spawaskar-cora/cora-docs</a>&nbsp;and I\'m sure we can help out.</p>
        <p>Let\'s make CoRA the go to application in Forensic Anthroplogy. Feel free to contribute and share your ideas :)</p>',
            ]);
        }
        $post = Post::find(4);
        if (!isset($post)) {
            Post::insert([ 'chatter_discussion_id' => 4, 'user_id' => $user, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),
                'body'=> '<p>This is just a random post to show you some of the formatting that you can do in the WYSIWYG editor. You can make your text <strong>bold</strong>, <em>italic</em>, or <span style="text-decoration: underline;">underlined</span>.</p>
        <p style="text-align: center;">Additionally, you can center align text.</p>
        <p style="text-align: right;">You can align the text to the right!</p>
        <p>Or by default it will be aligned to the left.</p>
        <ul>
        <li>We can also</li>
        <li>add a bulleted</li>
        <li>list</li>
        </ul>
        <ol>
        <li><span style="line-height: 1.6;">or we can</span></li>
        <li><span style="line-height: 1.6;">add a numbered list</span></li>
        </ol>
        <p style="padding-left: 30px;"><span style="line-height: 1.6;">We can choose to indent our text</span></p>
        <p><span style="line-height: 1.6;">Post links: <a href="https://github.com/spawaskar-cora/cora-docs" target="_blank">https://github.com/spawaskar-cora/cora-docs</a></span></p>
        <p><span style="line-height: 1.6;">and add images:</span></p>
        <p><span style="line-height: 1.6;"><img src="/storage/images/measurements/humerus.png" alt="" width="300" height="300" /></span></p>',
            ]);
        }
        $post = Post::find(5);
        if (!isset($post)) {
            Post::insert([ 'chatter_discussion_id' => 4, 'user_id' => $user, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),
                'body' => '<p>CoRA - Bones!</p>
        <p><img src="/storage/images/zones/cranium.png" alt="" width="500" height="500" /></p>
        <p><img src="/storage/images/measurements/os%20coxa.png" alt="" width="500" height="500" /></p>',
            ]);
        }
        $post = Post::find(6);
        if (!isset($post)) {
            Post::insert([ 'chatter_discussion_id' => 5, 'user_id' => $user, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),
                'body' => '<p>Hey There!</p>
        <p>Thanks for checking out CoRA, if you have any questions or want to contribute be sure to checkout the GitHub repo here: <a href="https://github.com/spawaskar-cora/cora-docs" target="_blank">https://github.com/spawaskar-cora/cora-docs</a></p>
        <p>Happy Forensic Investigation!</p>',
            ]);
        }
    }

}

