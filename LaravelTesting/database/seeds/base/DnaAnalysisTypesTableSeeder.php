<?php
/**
 * Dna Analysis Types Seeder
 *
 * @category   Dna Analysis Types
 * @package    Seeder
 * @author     Sachin Pawaskar<spawaskar@unomaha.edu>
 * @copyright  2016-2018
 * @license    The MIT License (MIT)
 * @version    GIT: $Id$
 * @since      File available since Release 1.0.0
 */

use App\DnaAnalysisType;
use Illuminate\Database\Seeder;

class DnaAnalysisTypesTableSeeder extends Seeder
{
    public function run()
    {
        $dt = date_create();

//        $testtype = DnaAnalysisType::firstOrNew(['name' => 'VR1']);
//        $data = array('name' =>'VR1', 'description' =>'Mito Variable Region 1', 'display_name' => 'VR1 - Mito Variable Region 1', 'created_at' => $dt, 'updated_at' => $dt);
//        (!$testtype->exists) ? $testtype->fill($data)->save() : $testtype->fill(array_except($data, ['created_at']))->save();
//
//        $testtype = DnaAnalysisType::firstOrNew(['name' => 'VR2']);
//        $data = array('name' =>'VR2', 'description' =>'Mito Variable Region 2', 'display_name' => 'VR2 - Mito Variable Region 2', 'created_at' => $dt, 'updated_at' => $dt);
//        (!$testtype->exists) ? $testtype->fill($data)->save() : $testtype->fill(array_except($data, ['created_at']))->save();
//
//        $testtype = DnaAnalysisType::firstOrNew(['name' => 'AuSTR']);
//        $data = array('name' =>'AuSTR', 'description' =>'Autosomal DNA testing', 'display_name' => 'AuSTR - Autosomal DNA testing', 'created_at' => $dt, 'updated_at' => $dt);
//        (!$testtype->exists) ? $testtype->fill($data)->save() : $testtype->fill(array_except($data, ['created_at']))->save();
//
//        $testtype = DnaAnalysisType::firstOrNew(['name' => 'YSTR']);
//        $data = array('name' =>'YSTR', 'description' =>'Y-STR - short tandem repeat (STR) on the Y-chromosome', 'display_name' => 'YSTR - Short Tandem Repeat on Y',  'created_at' => $dt, 'updated_at' => $dt);
//        (!$testtype->exists) ? $testtype->fill($data)->save() : $testtype->fill(array_except($data, ['created_at']))->save();
//
//        $testtype = DnaAnalysisType::firstOrNew(['name' => 'PS5']);
//        $data = array('name' =>'PS5', 'description' =>'PS5 - Nuclear Microsatellite Loci of which there are several', 'display_name' => 'PS5 - Nuclear Microsatellite Loci',  'created_at' => $dt, 'updated_at' => $dt);
//        (!$testtype->exists) ? $testtype->fill($data)->save() : $testtype->fill(array_except($data, ['created_at']))->save();
//
//        $testtype = DnaAnalysisType::firstOrNew(['name' => 'NGS']);
//        $data = array('name' =>'NGS', 'description' =>'Next Generation Sequencing', 'display_name' => 'NGS - Next Generation Sequencing', 'created_at' => $dt, 'updated_at' => $dt);
//        (!$testtype->exists) ? $testtype->fill($data)->save() : $testtype->fill(array_except($data, ['created_at']))->save();

        DB::table('dna_analysis_types')->delete();

        $testtype = DnaAnalysisType::firstOrNew(['name' => 'Sanger', 'type' => 'mito']);
        $data = array('name' =>'Sanger', 'description' =>'Sanger', 'display_name' => 'Sanger', 'type' => 'mito', 'created_at' => $dt, 'updated_at' => $dt);
        (!$testtype->exists) ? $testtype->fill($data)->save() : $testtype->fill(array_except($data, ['created_at']))->save();

        $testtype = DnaAnalysisType::firstOrNew(['name' => 'NGS']);
        $data = array('name' =>'NGS', 'description' =>'Next Generation Sequencing', 'display_name' => 'NGS - Next Generation Sequencing', 'type' => 'mito', 'created_at' => $dt, 'updated_at' => $dt);
        (!$testtype->exists) ? $testtype->fill($data)->save() : $testtype->fill(array_except($data, ['created_at']))->save();

        $testtype = DnaAnalysisType::firstOrNew(['name' => 'Y filer']);
        $data = array('name' =>'Y filer', 'description' =>'Y filer', 'display_name' => 'Y filer', 'type' => 'y', 'created_at' => $dt, 'updated_at' => $dt);
        (!$testtype->exists) ? $testtype->fill($data)->save() : $testtype->fill(array_except($data, ['created_at']))->save();

        $testtype = DnaAnalysisType::firstOrNew(['name' => 'AmpFLSTR Minifiler']);
        $data = array('name' =>'AmpFLSTR Minifiler', 'description' =>'AmpFLSTR Minifiler', 'display_name' => 'AmpFLSTR Minifiler', 'type' => 'auto', 'created_at' => $dt, 'updated_at' => $dt);
        (!$testtype->exists) ? $testtype->fill($data)->save() : $testtype->fill(array_except($data, ['created_at']))->save();

        $testtype = DnaAnalysisType::firstOrNew(['name' => 'AmpFLSTR Identifiler']);
        $data = array('name' =>'AmpFLSTR Identifiler', 'description' =>'AmpFLSTR Identifiler', 'display_name' => 'AmpFLSTR Identifiler', 'type' => 'auto', 'created_at' => $dt, 'updated_at' => $dt);
        (!$testtype->exists) ? $testtype->fill($data)->save() : $testtype->fill(array_except($data, ['created_at']))->save();

        $testtype = DnaAnalysisType::firstOrNew(['name' => 'Power Plex Fusion']);
        $data = array('name' =>'Power Plex Fusion', 'description' =>'Power Plex Fusion', 'display_name' => 'Power Plex Fusion', 'type' => 'auto', 'created_at' => $dt, 'updated_at' => $dt);
        (!$testtype->exists) ? $testtype->fill($data)->save() : $testtype->fill(array_except($data, ['created_at']))->save();
    }
}

