<?php
/**
 * Report Seeder
 *
 * @category   Report
 * @package    Seeder
 * @author     Sachin Pawaskar<spawaskar@unomaha.edu>
 * @copyright  2016-2018
 * @license    The MIT License (MIT)
 * @version    GIT: $Id$
 * @since      File available since Release 1.0.0
 */


use Illuminate\Database\Seeder;

class ReportsTableSeeder extends Seeder {

    public function run()
    {
        DB::table('reports')->delete();
        $dt = date_create();
        $sys = 'System';

        $reports = array(
            array('name' => 'measurements', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt),
            array('name' => 'methods', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt),
            array('' => '', 'methods', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt)
        );
        DB::table('reports')->insert($reports);        
    }
}

class ReportColumnsTableSeeder extends Seeder {

    public function run()
    {
       
        
    }
}

