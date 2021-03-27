<?php

use Illuminate\Database\Seeder;
use TCG\Voyager\Traits\Seedable;
use App\Utility\Memory;

class VoyagerDummyDatabaseSeeder extends Seeder
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

        $this->seed('CategoriesTableSeeder');
        $this->seed('UsersTableSeeder');
        $this->seed('PostsTableSeeder');
        $this->seed('PagesTableSeeder');
        $this->seed('SettingsTableSeeder');
        $this->seed('TranslationsTableSeeder');

        Memory::dump_usage(true);
    }
}
