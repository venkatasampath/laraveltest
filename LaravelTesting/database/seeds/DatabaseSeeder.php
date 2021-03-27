<?php
/**
 * Database Seeder
 *
 * @category   Database
 * @package    Seeder
 * @author     Sachin Pawaskar<spawaskar@unomaha.edu>
 * @copyright  2016-2018
 * @license    The MIT License (MIT)
 * @version    GIT: $Id$
 * @since      File available since Release 1.0.0
 */

use Illuminate\Database\Seeder;
use App\Utility\Memory;

class DatabaseSeeder extends Seeder
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
        $this->command->info('            Start: Seeding Orgs, User, Roles and Permissions            !');
        $this->command->info('------------------------------------------------------------------------!');
        $this->call(BaseOrgsTableSeeder::class);
        $this->call(VoyagerDatabaseSeeder::class);
        $this->call(VoyagerDummyDatabaseSeeder::class);
        $this->call(BaseRolesTableSeeder::class);
        $this->call(BaseUsersTableSeeder::class);
        $this->command->info('------------------------------------------------------------------------!');
        $this->command->info('             End: Seeding Orgs, User, Roles and Permissions             !');
        $this->command->info('------------------------------------------------------------------------!');
        Memory::dump_usage(true);

        $this->command->info('------------------------------------------------------------------------!');
        $this->command->info('                    Start: Seeding Profile, Eula                        !');
        $this->command->info('------------------------------------------------------------------------!');
        $this->call(BaseProfilesTableSeeder::class);
        $this->call(BaseEulasTableSeeder::class);
        $this->command->info('------------------------------------------------------------------------!');
        $this->command->info('                     End: Seeding Profile, Eula                         !');
        $this->command->info('------------------------------------------------------------------------!');

        Memory::dump_usage(true);
    }
}
