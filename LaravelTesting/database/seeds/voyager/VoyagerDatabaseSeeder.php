<?php

use Illuminate\Database\Seeder;
use TCG\Voyager\Traits\Seedable;
use App\Utility\Memory;


class VoyagerDatabaseSeeder extends Seeder
{
    use Seedable;

    protected $seedersPath = __DIR__.'/voyager/';

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Memory::dump_usage(true);
        ini_set("memory_limit","512M");

        $this->seed('DataTypesTableSeeder');
        $this->seed('DataRowsTableSeeder');
        $this->seed('MenusTableSeeder');
        $this->seed('MenuItemsTableSeeder');
        $this->seed('RolesTableSeeder');
        $this->seed('PermissionsTableSeeder');
        $this->seed('PermissionRoleTableSeeder');

        Memory::dump_usage(true);
    }
}
