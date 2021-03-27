<?php
/**
 * Cora Demo Data Seeder
 *
 * @category   Cora Demo Data
 * @package    Seeder
 * @author     Sachin Pawaskar<spawaskar@unomaha.edu>
 * @copyright  2016-2018
 * @license    The MIT License (MIT)
 * @version    GIT: $Id$
 * @since      File available since Release 1.0.0
 */

use Illuminate\Database\Seeder;
use App\Utility\Memory;
use App\Utility\StopWatch;

class CoraDemoDataSeeder extends Seeder
{
    protected $swTimerName = 'CoraDemo-Data-Seeding';

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ini_set("memory_limit","512M");
        StopWatch::start($this->swTimerName);

        $this->command->info('------------------------------------------------------------------------!');
        $this->command->info('              Start: Seeding Cora Demo Project Specimens                !');
        $this->command->info('------------------------------------------------------------------------!');
        $this->seedSE();
        $this->command->info('------------------------------------------------------------------------!');
        $this->command->info('             End: Seeding Cora Demo Project Specimens                   !');
        $this->command->info('------------------------------------------------------------------------!');

        $this->command->info('------------------------------------------------------------------------!');
        $this->command->info('      Start: Seeding Cora Demo Project - Associations for Specimens     !');
        $this->command->info('------------------------------------------------------------------------!');

        $this->seedSEAnomaly();
        $this->seedSEArticulation();
        $this->seedSEDna();
        $this->seedSEMeasurement();
        $this->seedSEMethod();
        $this->seedSEMethodFeature();
        $this->seedSEPair();
        $this->seedSEPathology();
        $this->seedSETaphonomy();
        $this->seedSETrauma();
        $this->seedSEZone();

        $this->command->info('------------------------------------------------------------------------!');
        $this->command->info('      End: Seeding Cora Demo Project - Associations for Specimens       !');
        $this->command->info('------------------------------------------------------------------------!');

        Memory::dump_usage(true);
        StopWatch::clearTimers();
    }

    protected function seedSE()
    {
        Memory::dump_usage(true);
        $this->call(SEPartialTableSeeder::class);

        // This will load data for CoRA Another Demo Project
        // Should be removed once we verify that Project switching works correctly.
//        $this->call(SEPartial2TableSeeder::class);
        $this->command->info('Elasped time: ' . StopWatch::elapsed($this->swTimerName));
    }

    protected function seedSEAnomaly()
    {
        $this->call(SEAnamolyPartialTableSeeder::class);
        $this->command->info('Elasped time: ' . StopWatch::elapsed($this->swTimerName));
    }

    protected function seedSEArticulation()
    {
        $this->call(SEArticulationPartialTableSeeder::class);
        $this->command->info('Elasped time: ' . StopWatch::elapsed($this->swTimerName));
    }

    protected function seedSEDna()
    {
        Memory::dump_usage(true);
        $this->call(SEDnaPartialTableSeeder::class);
        $this->command->info('Elasped time: ' . StopWatch::elapsed($this->swTimerName));
    }

    protected function seedSEMeasurement()
    {
        Memory::dump_usage(true);
        $this->call(SEMeasurementPartialTableSeeder::class);
        $this->call(SEMeasurementPartialSubpart1TableSeeder::class);
        $this->command->info('Elasped time: ' . StopWatch::elapsed($this->swTimerName));
    }

    protected function seedSEMethod()
    {
        Memory::dump_usage(true);
        $this->call(SEMethodPartialTableSeeder::class);
        $this->command->info('Elasped time: ' . StopWatch::elapsed($this->swTimerName));
    }

    protected function seedSEMethodFeature()
    {
        Memory::dump_usage(true);
        $this->call(SEMethodFeaturePartialTableSeeder::class);
        $this->command->info('Elasped time: ' . StopWatch::elapsed($this->swTimerName));
    }

    protected function seedSEPair()
    {
        $this->call(SEPairPartialTableSeeder::class);
        $this->command->info('Elasped time: ' . StopWatch::elapsed($this->swTimerName));
    }

    protected function seedSEPathology()
    {
        $this->call(SEPathologyPartialTableSeeder::class);
        $this->command->info('Elasped time: ' . StopWatch::elapsed($this->swTimerName));
    }

    protected function seedSETaphonomy()
    {
        $this->call(SETaphonomyPartialTableSeeder::class);
        $this->command->info('Elasped time: ' . StopWatch::elapsed($this->swTimerName));
    }

    protected function seedSETrauma()
    {
        $this->call(SETraumaPartialTableSeeder::class);
        $this->command->info('Elasped time: ' . StopWatch::elapsed($this->swTimerName));
    }

    protected function seedSEZone()
    {
        Memory::dump_usage(true);
        $this->call(SEZonePartialTableSeeder::class);
        $this->command->info('Elasped time: ' . StopWatch::elapsed($this->swTimerName));
    }
}

