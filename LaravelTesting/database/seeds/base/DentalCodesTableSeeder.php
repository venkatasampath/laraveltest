<?php
/**
 * Dental Codes Seeder
 *
 * @category   Dental Codes
 * @package    Seeder
 * @author     Sachin Pawaskar<spawaskar@unomaha.edu>
 * @copyright  2016-2018
 * @license    The MIT License (MIT)
 * @version    GIT: $Id$
 * @since      File available since Release 1.0.0
 */

use Illuminate\Database\Seeder;
use App\DentalCode;

class DentalCodesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $dt = date_create();
        $sys = 'System';

        $dental = DentalCode::firstOrNew(['code' => 'V', 'type' =>'Primary']);
        $data = array('code' => 'V', 'description' =>'Present', 'type' =>'Primary', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$dental->exists) ? $dental->fill($data)->save() : $dental->fill(array_except($data, ['created_at']))->save();
        $dental = DentalCode::firstOrNew(['code' => 'X', 'type' =>'Primary']);
        $data = array('code' => 'X', 'description' =>'Missing Socket', 'type' =>'Primary', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$dental->exists) ? $dental->fill($data)->save() : $dental->fill(array_except($data, ['created_at']))->save();
        $dental = DentalCode::firstOrNew(['code' => 'U', 'type' =>'Primary']);
        $data = array('code' => 'U', 'description' =>'Unerupted', 'type' =>'Primary', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$dental->exists) ? $dental->fill($data)->save() : $dental->fill(array_except($data, ['created_at']))->save();
        $dental = DentalCode::firstOrNew(['code' => 'Z', 'type' =>'Primary']);
        $data = array('code' => 'Z', 'description' =>'Carious', 'type' =>'Primary', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$dental->exists) ? $dental->fill($data)->save() : $dental->fill(array_except($data, ['created_at']))->save();
        $dental = DentalCode::firstOrNew(['code' => 'R', 'type' =>'Primary']);
        $data = array('code' => 'R', 'description' =>'Restored','type' =>'Primary', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$dental->exists) ? $dental->fill($data)->save() : $dental->fill(array_except($data, ['created_at']))->save();
        $dental = DentalCode::firstOrNew(['code' => 'M', 'type' =>'Primary']);
        $data = array('code' => 'M', 'description' =>'Missing Postmortem', 'type' =>'Primary', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$dental->exists) ? $dental->fill($data)->save() : $dental->fill(array_except($data, ['created_at']))->save();
        $dental = DentalCode::firstOrNew(['code' => 'A', 'type' =>'Secondary']);
        $data = array('code' => 'A', 'description' =>'Anomaly', 'type' =>'Secondary', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$dental->exists) ? $dental->fill($data)->save() : $dental->fill(array_except($data, ['created_at']))->save();
        $dental = DentalCode::firstOrNew(['code' => 'G', 'type' =>'Secondary']);
        $data = array('code' => 'G', 'description' =>'Cast Metal Restoration', 'type' =>'Secondary', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$dental->exists) ? $dental->fill($data)->save() : $dental->fill(array_except($data, ['created_at']))->save();
        $dental = DentalCode::firstOrNew(['code' => 'B', 'type' =>'Secondary']);
        $data = array('code' => 'B', 'description' =>'Deciduous', 'type' =>'Secondary', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$dental->exists) ? $dental->fill($data)->save() : $dental->fill(array_except($data, ['created_at']))->save();
        $dental = DentalCode::firstOrNew(['code' => 'P', 'type' =>'Secondary']);
        $data = array('code' => 'P', 'description' =>'Replaced w/Fixed Prosthetic Pontic', 'type' =>'Secondary', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$dental->exists) ? $dental->fill($data)->save() : $dental->fill(array_except($data, ['created_at']))->save();
        $dental = DentalCode::firstOrNew(['code' => 'Q', 'type' =>'Secondary']);
        $data = array('code' => 'Q', 'description' =>'3/4 Crown', 'type' =>'Secondary', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$dental->exists) ? $dental->fill($data)->save() : $dental->fill(array_except($data, ['created_at']))->save();
        $dental = DentalCode::firstOrNew(['code' => 'E', 'type' =>'Secondary']);
        $data = array('code' => 'E', 'description' =>'Endodontic Treatment', 'type' =>'Secondary', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$dental->exists) ? $dental->fill($data)->save() : $dental->fill(array_except($data, ['created_at']))->save();
        $dental = DentalCode::firstOrNew(['code' => 'S', 'type' =>'Secondary']);
        $data = array('code' => 'S', 'description' =>'Silver Amalgam Restoration', 'type' =>'Secondary', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$dental->exists) ? $dental->fill($data)->save() : $dental->fill(array_except($data, ['created_at']))->save();
        $dental = DentalCode::firstOrNew(['code' => 'N', 'type' =>'Secondary']);
        $data = array('code' => 'N', 'description' =>'Non Metallic  Containing Restorations', 'type' =>'Secondary', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$dental->exists) ? $dental->fill($data)->save() : $dental->fill(array_except($data, ['created_at']))->save();
        $dental = DentalCode::firstOrNew(['code' => 'T', 'type' =>'Secondary']);
        $data = array('code' => 'T', 'description' =>'Replaced w/Denture tooth', 'type' =>'Secondary', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$dental->exists) ? $dental->fill($data)->save() : $dental->fill(array_except($data, ['created_at']))->save();
    }
}