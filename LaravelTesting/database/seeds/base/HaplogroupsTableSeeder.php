<?php
/**
 * Haplogroup Seeder
 *
 * @category   Haplogroup
 * @package    Seeder
 * @author     Sachin Pawaskar<spawaskar@unomaha.edu>
 * @copyright  2016-2018
 * @license    The MIT License (MIT)
 * @version    GIT: $Id$
 * @since      File available since Release 1.0.0
 */

use Illuminate\Database\Seeder;
use App\Haplogroup;

class HaplogroupsTableSeeder extends Seeder
{
    public function run()
    {
        $dt = date_create();
        $sys = 'System';

        // Beginning of All Letters (A - Z)

        $hg = Haplogroup::firstOrNew(['type' => 'Mito', 'letter' => 'A', 'subgroup' => '', 'ancestry' => '']);
        $data = array('type' => 'Mito', 'letter' => 'A', 'subgroup' => '', 'ancestry' => '', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$hg->exists) ? $hg->fill($data)->save() : $hg->fill(array_except($data, ['created_at']))->save();

        $hg = Haplogroup::firstOrNew(['type' => 'Mito', 'letter' => 'B', 'subgroup' => '', 'ancestry' => '']);
        $data = array('type' => 'Mito', 'letter' => 'B', 'subgroup' => '', 'ancestry' => '', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$hg->exists) ? $hg->fill($data)->save() : $hg->fill(array_except($data, ['created_at']))->save();

        $hg = Haplogroup::firstOrNew(['type' => 'Mito', 'letter' => 'C', 'subgroup' => '', 'ancestry' => '']);
        $data = array('type' => 'Mito', 'letter' => 'C', 'subgroup' => '', 'ancestry' => '', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$hg->exists) ? $hg->fill($data)->save() : $hg->fill(array_except($data, ['created_at']))->save();

        $hg = Haplogroup::firstOrNew(['type' => 'Mito', 'letter' => 'D', 'subgroup' => '', 'ancestry' => '']);
        $data = array('type' => 'Mito', 'letter' => 'D', 'subgroup' => '', 'ancestry' => '', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$hg->exists) ? $hg->fill($data)->save() : $hg->fill(array_except($data, ['created_at']))->save();

        $hg = Haplogroup::firstOrNew(['type' => 'Mito', 'letter' => 'E', 'subgroup' => '', 'ancestry' => '']);
        $data = array('type' => 'Mito', 'letter' => 'E', 'subgroup' => '', 'ancestry' => '', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$hg->exists) ? $hg->fill($data)->save() : $hg->fill(array_except($data, ['created_at']))->save();

        $hg = Haplogroup::firstOrNew(['type' => 'Mito', 'letter' => 'F', 'subgroup' => '', 'ancestry' => '']);
        $data = array('type' => 'Mito', 'letter' => 'F', 'subgroup' => '', 'ancestry' => '', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$hg->exists) ? $hg->fill($data)->save() : $hg->fill(array_except($data, ['created_at']))->save();

        $hg = Haplogroup::firstOrNew(['type' => 'Mito', 'letter' => 'G', 'subgroup' => '', 'ancestry' => '']);
        $data = array('type' => 'Mito', 'letter' => 'G', 'subgroup' => '', 'ancestry' => '', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$hg->exists) ? $hg->fill($data)->save() : $hg->fill(array_except($data, ['created_at']))->save();

        $hg = Haplogroup::firstOrNew(['type' => 'Mito', 'letter' => 'H', 'subgroup' => '', 'ancestry' => '']);
        $data = array('type' => 'Mito', 'letter' => 'H', 'subgroup' => '', 'ancestry' => '', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$hg->exists) ? $hg->fill($data)->save() : $hg->fill(array_except($data, ['created_at']))->save();

        $hg = Haplogroup::firstOrNew(['type' => 'Mito', 'letter' => 'I', 'subgroup' => '', 'ancestry' => '']);
        $data = array('type' => 'Mito', 'letter' => 'I', 'subgroup' => '', 'ancestry' => '', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$hg->exists) ? $hg->fill($data)->save() : $hg->fill(array_except($data, ['created_at']))->save();

        $hg = Haplogroup::firstOrNew(['type' => 'Mito', 'letter' => 'J', 'subgroup' => '', 'ancestry' => '']);
        $data = array('type' => 'Mito', 'letter' => 'J', 'subgroup' => '', 'ancestry' => '', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$hg->exists) ? $hg->fill($data)->save() : $hg->fill(array_except($data, ['created_at']))->save();

        $hg = Haplogroup::firstOrNew(['type' => 'Mito', 'letter' => 'K', 'subgroup' => '', 'ancestry' => '']);
        $data = array('type' => 'Mito', 'letter' => 'K', 'subgroup' => '', 'ancestry' => '', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$hg->exists) ? $hg->fill($data)->save() : $hg->fill(array_except($data, ['created_at']))->save();

        $hg = Haplogroup::firstOrNew(['type' => 'Mito', 'letter' => 'L', 'subgroup' => '', 'ancestry' => '']);
        $data = array('type' => 'Mito', 'letter' => 'L', 'subgroup' => '', 'ancestry' => '', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$hg->exists) ? $hg->fill($data)->save() : $hg->fill(array_except($data, ['created_at']))->save();

        $hg = Haplogroup::firstOrNew(['type' => 'Mito', 'letter' => 'M', 'subgroup' => '', 'ancestry' => '']);
        $data = array('type' => 'Mito', 'letter' => 'M', 'subgroup' => '', 'ancestry' => '', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$hg->exists) ? $hg->fill($data)->save() : $hg->fill(array_except($data, ['created_at']))->save();

        $hg = Haplogroup::firstOrNew(['type' => 'Mito', 'letter' => 'N', 'subgroup' => '', 'ancestry' => '']);
        $data = array('type' => 'Mito', 'letter' => 'N', 'subgroup' => '', 'ancestry' => '', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$hg->exists) ? $hg->fill($data)->save() : $hg->fill(array_except($data, ['created_at']))->save();

        $hg = Haplogroup::firstOrNew(['type' => 'Mito', 'letter' => 'O', 'subgroup' => '', 'ancestry' => '']);
        $data = array('type' => 'Mito', 'letter' => 'O', 'subgroup' => '', 'ancestry' => '', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$hg->exists) ? $hg->fill($data)->save() : $hg->fill(array_except($data, ['created_at']))->save();

        $hg = Haplogroup::firstOrNew(['type' => 'Mito', 'letter' => 'P', 'subgroup' => '', 'ancestry' => '']);
        $data = array('type' => 'Mito', 'letter' => 'P', 'subgroup' => '', 'ancestry' => '', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$hg->exists) ? $hg->fill($data)->save() : $hg->fill(array_except($data, ['created_at']))->save();

        $hg = Haplogroup::firstOrNew(['type' => 'Mito', 'letter' => 'Q', 'subgroup' => '', 'ancestry' => '']);
        $data = array('type' => 'Mito', 'letter' => 'Q', 'subgroup' => '', 'ancestry' => '', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$hg->exists) ? $hg->fill($data)->save() : $hg->fill(array_except($data, ['created_at']))->save();

        $hg = Haplogroup::firstOrNew(['type' => 'Mito', 'letter' => 'R', 'subgroup' => '', 'ancestry' => '']);
        $data = array('type' => 'Mito', 'letter' => 'R', 'subgroup' => '', 'ancestry' => '', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$hg->exists) ? $hg->fill($data)->save() : $hg->fill(array_except($data, ['created_at']))->save();

        $hg = Haplogroup::firstOrNew(['type' => 'Mito', 'letter' => 'S', 'subgroup' => '', 'ancestry' => '']);
        $data = array('type' => 'Mito', 'letter' => 'S', 'subgroup' => '', 'ancestry' => '', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$hg->exists) ? $hg->fill($data)->save() : $hg->fill(array_except($data, ['created_at']))->save();

        $hg = Haplogroup::firstOrNew(['type' => 'Mito', 'letter' => 'T', 'subgroup' => '', 'ancestry' => '']);
        $data = array('type' => 'Mito', 'letter' => 'T', 'subgroup' => '', 'ancestry' => '', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$hg->exists) ? $hg->fill($data)->save() : $hg->fill(array_except($data, ['created_at']))->save();

        $hg = Haplogroup::firstOrNew(['type' => 'Mito', 'letter' => 'U', 'subgroup' => '', 'ancestry' => '']);
        $data = array('type' => 'Mito', 'letter' => 'U', 'subgroup' => '', 'ancestry' => '', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$hg->exists) ? $hg->fill($data)->save() : $hg->fill(array_except($data, ['created_at']))->save();

        $hg = Haplogroup::firstOrNew(['type' => 'Mito', 'letter' => 'V', 'subgroup' => '', 'ancestry' => '']);
        $data = array('type' => 'Mito', 'letter' => 'V', 'subgroup' => '', 'ancestry' => '', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$hg->exists) ? $hg->fill($data)->save() : $hg->fill(array_except($data, ['created_at']))->save();

        $hg = Haplogroup::firstOrNew(['type' => 'Mito', 'letter' => 'W', 'subgroup' => '', 'ancestry' => '']);
        $data = array('type' => 'Mito', 'letter' => 'W', 'subgroup' => '', 'ancestry' => '', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$hg->exists) ? $hg->fill($data)->save() : $hg->fill(array_except($data, ['created_at']))->save();

        $hg = Haplogroup::firstOrNew(['type' => 'Mito', 'letter' => 'X', 'subgroup' => '', 'ancestry' => '']);
        $data = array('type' => 'Mito', 'letter' => 'X', 'subgroup' => '', 'ancestry' => '', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$hg->exists) ? $hg->fill($data)->save() : $hg->fill(array_except($data, ['created_at']))->save();

        $hg = Haplogroup::firstOrNew(['type' => 'Mito', 'letter' => 'Y', 'subgroup' => '', 'ancestry' => '']);
        $data = array('type' => 'Mito', 'letter' => 'Y', 'subgroup' => '', 'ancestry' => '', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$hg->exists) ? $hg->fill($data)->save() : $hg->fill(array_except($data, ['created_at']))->save();

        $hg = Haplogroup::firstOrNew(['type' => 'Mito', 'letter' => 'Z', 'subgroup' => '', 'ancestry' => '']);
        $data = array('type' => 'Mito', 'letter' => 'Z', 'subgroup' => '', 'ancestry' => '', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$hg->exists) ? $hg->fill($data)->save() : $hg->fill(array_except($data, ['created_at']))->save();

        // End of All Letters (A - Z)

        // Others Combinations

        $hg = Haplogroup::firstOrNew(['type' => 'Mito', 'letter' => 'A', 'subgroup' => '', 'ancestry' => 'Asian']);
        $data = array('type' => 'Mito', 'letter' => 'A', 'subgroup' => '', 'ancestry' => 'Asian', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$hg->exists) ? $hg->fill($data)->save() : $hg->fill(array_except($data, ['created_at']))->save();

        $hg = Haplogroup::firstOrNew(['type' => 'Mito', 'letter' => 'A', 'subgroup' => '152+16362', 'ancestry' => 'Asian']);
        $data = array('type' => 'Mito', 'letter' => 'A', 'subgroup' => '152+16362', 'ancestry' => 'Asian', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$hg->exists) ? $hg->fill($data)->save() : $hg->fill(array_except($data, ['created_at']))->save();

        $hg = Haplogroup::firstOrNew(['type' => 'Mito', 'letter' => 'A', 'subgroup' => '4c', 'ancestry' => 'Asian']);
        $data = array('type' => 'Mito', 'letter' => 'A', 'subgroup' => '4c', 'ancestry' => 'Asian', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$hg->exists) ? $hg->fill($data)->save() : $hg->fill(array_except($data, ['created_at']))->save();

        $hg = Haplogroup::firstOrNew(['type' => 'Mito', 'letter' => 'A', 'subgroup' => '5a', 'ancestry' => 'Asian']);
        $data = array('type' => 'Mito', 'letter' => 'A', 'subgroup' => '5a', 'ancestry' => 'Asian', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$hg->exists) ? $hg->fill($data)->save() : $hg->fill(array_except($data, ['created_at']))->save();

        $hg = Haplogroup::firstOrNew(['type' => 'Mito', 'letter' => 'A', 'subgroup' => '5b', 'ancestry' => 'Asian']);
        $data = array('type' => 'Mito', 'letter' => 'A', 'subgroup' => '5b', 'ancestry' => 'Asian', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$hg->exists) ? $hg->fill($data)->save() : $hg->fill(array_except($data, ['created_at']))->save();

        $hg = Haplogroup::firstOrNew(['type' => 'Mito', 'letter' => 'B', 'subgroup' => '2+16278', 'ancestry' => 'Asian']);
        $data = array('type' => 'Mito', 'letter' => 'B', 'subgroup' => '2+16278', 'ancestry' => 'Asian', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$hg->exists) ? $hg->fill($data)->save() : $hg->fill(array_except($data, ['created_at']))->save();

        $hg = Haplogroup::firstOrNew(['type' => 'Mito', 'letter' => 'B', 'subgroup' => '4', 'ancestry' => 'Asian']);
        $data = array('type' => 'Mito', 'letter' => 'B', 'subgroup' => '4', 'ancestry' => 'Asian', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$hg->exists) ? $hg->fill($data)->save() : $hg->fill(array_except($data, ['created_at']))->save();

        $hg = Haplogroup::firstOrNew(['type' => 'Mito', 'letter' => 'B', 'subgroup' => '4a1a1h', 'ancestry' => 'Asian']);
        $data = array('type' => 'Mito', 'letter' => 'B', 'subgroup' => '4a1a1h', 'ancestry' => 'Asian', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$hg->exists) ? $hg->fill($data)->save() : $hg->fill(array_except($data, ['created_at']))->save();

        $hg = Haplogroup::firstOrNew(['type' => 'Mito', 'letter' => 'B', 'subgroup' => '4a1b1', 'ancestry' => 'Asian']);
        $data = array('type' => 'Mito', 'letter' => 'B', 'subgroup' => '4a1b1', 'ancestry' => 'Asian', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$hg->exists) ? $hg->fill($data)->save() : $hg->fill(array_except($data, ['created_at']))->save();

        $hg = Haplogroup::firstOrNew(['type' => 'Mito', 'letter' => 'B', 'subgroup' => '4b1b', 'ancestry' => 'Asian']);
        $data = array('type' => 'Mito', 'letter' => 'B', 'subgroup' => '4b1b', 'ancestry' => 'Asian', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$hg->exists) ? $hg->fill($data)->save() : $hg->fill(array_except($data, ['created_at']))->save();

        $hg = Haplogroup::firstOrNew(['type' => 'Mito', 'letter' => 'B', 'subgroup' => '4c1b1', 'ancestry' => 'East Asian']);
        $data = array('type' => 'Mito', 'letter' => 'B', 'subgroup' => '4c1b1', 'ancestry' => 'East Asian', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$hg->exists) ? $hg->fill($data)->save() : $hg->fill(array_except($data, ['created_at']))->save();

        $hg = Haplogroup::firstOrNew(['type' => 'Mito', 'letter' => 'B', 'subgroup' => '4f', 'ancestry' => 'Asian']);
        $data = array('type' => 'Mito', 'letter' => 'B', 'subgroup' => '4f', 'ancestry' => 'Asian', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$hg->exists) ? $hg->fill($data)->save() : $hg->fill(array_except($data, ['created_at']))->save();

        $hg = Haplogroup::firstOrNew(['type' => 'Mito', 'letter' => 'B', 'subgroup' => '5a', 'ancestry' => 'Asian']);
        $data = array('type' => 'Mito', 'letter' => 'B', 'subgroup' => '5a', 'ancestry' => 'Asian', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$hg->exists) ? $hg->fill($data)->save() : $hg->fill(array_except($data, ['created_at']))->save();

        $hg = Haplogroup::firstOrNew(['type' => 'Mito', 'letter' => 'B', 'subgroup' => '5a2', 'ancestry' => 'Asian']);
        $data = array('type' => 'Mito', 'letter' => 'B', 'subgroup' => '5a2', 'ancestry' => 'Asian', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$hg->exists) ? $hg->fill($data)->save() : $hg->fill(array_except($data, ['created_at']))->save();

        $hg = Haplogroup::firstOrNew(['type' => 'Mito', 'letter' => 'B', 'subgroup' => '5a2a1', 'ancestry' => 'Asian']);
        $data = array('type' => 'Mito', 'letter' => 'B', 'subgroup' => '5a2a1', 'ancestry' => 'Asian', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$hg->exists) ? $hg->fill($data)->save() : $hg->fill(array_except($data, ['created_at']))->save();

        $hg = Haplogroup::firstOrNew(['type' => 'Mito', 'letter' => 'B', 'subgroup' => '5b2a1a', 'ancestry' => 'Asian']);
        $data = array('type' => 'Mito', 'letter' => 'B', 'subgroup' => '5b2a1a', 'ancestry' => 'Asian', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$hg->exists) ? $hg->fill($data)->save() : $hg->fill(array_except($data, ['created_at']))->save();

        $hg = Haplogroup::firstOrNew(['type' => 'Mito', 'letter' => 'B', 'subgroup' => '5b3', 'ancestry' => 'Asian']);
        $data = array('type' => 'Mito', 'letter' => 'B', 'subgroup' => '5b3', 'ancestry' => 'Asian', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$hg->exists) ? $hg->fill($data)->save() : $hg->fill(array_except($data, ['created_at']))->save();

        $hg = Haplogroup::firstOrNew(['type' => 'Mito', 'letter' => 'C', 'subgroup' => '', 'ancestry' => 'Asian/Native American']);
        $data = array('type' => 'Mito', 'letter' => 'C', 'subgroup' => '', 'ancestry' => 'Asian/Native American', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$hg->exists) ? $hg->fill($data)->save() : $hg->fill(array_except($data, ['created_at']))->save();

        $hg = Haplogroup::firstOrNew(['type' => 'Mito', 'letter' => 'D', 'subgroup' => '4', 'ancestry' => 'Asian']);
        $data = array('type' => 'Mito', 'letter' => 'D', 'subgroup' => '4', 'ancestry' => 'Asian', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$hg->exists) ? $hg->fill($data)->save() : $hg->fill(array_except($data, ['created_at']))->save();

        $hg = Haplogroup::firstOrNew(['type' => 'Mito', 'letter' => 'D', 'subgroup' => '4a', 'ancestry' => 'Asian']);
        $data = array('type' => 'Mito', 'letter' => 'D', 'subgroup' => '4a', 'ancestry' => 'Asian', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$hg->exists) ? $hg->fill($data)->save() : $hg->fill(array_except($data, ['created_at']))->save();

        $hg = Haplogroup::firstOrNew(['type' => 'Mito', 'letter' => 'D', 'subgroup' => '4a+16294', 'ancestry' => 'Asian']);
        $data = array('type' => 'Mito', 'letter' => 'D', 'subgroup' => '4a+16294', 'ancestry' => 'Asian', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$hg->exists) ? $hg->fill($data)->save() : $hg->fill(array_except($data, ['created_at']))->save();

        $hg = Haplogroup::firstOrNew(['type' => 'Mito', 'letter' => 'D', 'subgroup' => '4a3', 'ancestry' => 'Asian']);
        $data = array('type' => 'Mito', 'letter' => 'D', 'subgroup' => '4a3', 'ancestry' => 'Asian', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$hg->exists) ? $hg->fill($data)->save() : $hg->fill(array_except($data, ['created_at']))->save();

        $hg = Haplogroup::firstOrNew(['type' => 'Mito', 'letter' => 'D', 'subgroup' => '4b2b', 'ancestry' => 'Asian']);
        $data = array('type' => 'Mito', 'letter' => 'D', 'subgroup' => '4b2b', 'ancestry' => 'Asian', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$hg->exists) ? $hg->fill($data)->save() : $hg->fill(array_except($data, ['created_at']))->save();

        $hg = Haplogroup::firstOrNew(['type' => 'Mito', 'letter' => 'D', 'subgroup' => '4i', 'ancestry' => 'Asian']);
        $data = array('type' => 'Mito', 'letter' => 'D', 'subgroup' => '4i', 'ancestry' => 'Asian', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$hg->exists) ? $hg->fill($data)->save() : $hg->fill(array_except($data, ['created_at']))->save();

        $hg = Haplogroup::firstOrNew(['type' => 'Mito', 'letter' => 'D', 'subgroup' => '4h1c1', 'ancestry' => 'Asian']);
        $data = array('type' => 'Mito', 'letter' => 'D', 'subgroup' => '4h1c1', 'ancestry' => 'Asian', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$hg->exists) ? $hg->fill($data)->save() : $hg->fill(array_except($data, ['created_at']))->save();

        $hg = Haplogroup::firstOrNew(['type' => 'Mito', 'letter' => 'D', 'subgroup' => '5c1a', 'ancestry' => 'Asian']);
        $data = array('type' => 'Mito', 'letter' => 'D', 'subgroup' => '5c1a', 'ancestry' => 'Asian', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$hg->exists) ? $hg->fill($data)->save() : $hg->fill(array_except($data, ['created_at']))->save();

        $hg = Haplogroup::firstOrNew(['type' => 'Mito', 'letter' => 'E', 'subgroup' => '', 'ancestry' => 'Asian']);
        $data = array('type' => 'Mito', 'letter' => 'E', 'subgroup' => '', 'ancestry' => 'Asian', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$hg->exists) ? $hg->fill($data)->save() : $hg->fill(array_except($data, ['created_at']))->save();

        $hg = Haplogroup::firstOrNew(['type' => 'Mito', 'letter' => 'E', 'subgroup' => '1b', 'ancestry' => 'Asian (Southeast)']);
        $data = array('type' => 'Mito', 'letter' => 'E', 'subgroup' => '1b', 'ancestry' => 'Asian (Southeast)', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$hg->exists) ? $hg->fill($data)->save() : $hg->fill(array_except($data, ['created_at']))->save();

        $hg = Haplogroup::firstOrNew(['type' => 'Mito', 'letter' => 'F', 'subgroup' => '', 'ancestry' => 'Asian']);
        $data = array('type' => 'Mito', 'letter' => 'F', 'subgroup' => '', 'ancestry' => 'Asian', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$hg->exists) ? $hg->fill($data)->save() : $hg->fill(array_except($data, ['created_at']))->save();

        $hg = Haplogroup::firstOrNew(['type' => 'Mito', 'letter' => 'F', 'subgroup' => '1a1', 'ancestry' => 'Asian']);
        $data = array('type' => 'Mito', 'letter' => 'F', 'subgroup' => '1a1', 'ancestry' => 'Asian', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$hg->exists) ? $hg->fill($data)->save() : $hg->fill(array_except($data, ['created_at']))->save();

        $hg = Haplogroup::firstOrNew(['type' => 'Mito', 'letter' => 'F', 'subgroup' => '1b', 'ancestry' => 'Asian']);
        $data = array('type' => 'Mito', 'letter' => 'F', 'subgroup' => '1b', 'ancestry' => 'Asian', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$hg->exists) ? $hg->fill($data)->save() : $hg->fill(array_except($data, ['created_at']))->save();

        $hg = Haplogroup::firstOrNew(['type' => 'Mito', 'letter' => 'F', 'subgroup' => '1b1-152', 'ancestry' => 'Asian']);
        $data = array('type' => 'Mito', 'letter' => 'F', 'subgroup' => '1b1-152', 'ancestry' => '', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$hg->exists) ? $hg->fill($data)->save() : $hg->fill(array_except($data, ['created_at']))->save();

        $hg = Haplogroup::firstOrNew(['type' => 'Mito', 'letter' => 'F', 'subgroup' => '1b1a', 'ancestry' => 'Asian']);
        $data = array('type' => 'Mito', 'letter' => 'F', 'subgroup' => '1b1a', 'ancestry' => 'Asian', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$hg->exists) ? $hg->fill($data)->save() : $hg->fill(array_except($data, ['created_at']))->save();

        $hg = Haplogroup::firstOrNew(['type' => 'Mito', 'letter' => 'F', 'subgroup' => '1c1', 'ancestry' => 'Asian']);
        $data = array('type' => 'Mito', 'letter' => 'F', 'subgroup' => '1c1', 'ancestry' => 'Asian', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$hg->exists) ? $hg->fill($data)->save() : $hg->fill(array_except($data, ['created_at']))->save();

        $hg = Haplogroup::firstOrNew(['type' => 'Mito', 'letter' => 'F', 'subgroup' => '2b1', 'ancestry' => 'Asian']);
        $data = array('type' => 'Mito', 'letter' => 'F', 'subgroup' => '2b1', 'ancestry' => 'Asian', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$hg->exists) ? $hg->fill($data)->save() : $hg->fill(array_except($data, ['created_at']))->save();

        $hg = Haplogroup::firstOrNew(['type' => 'Mito', 'letter' => 'G', 'subgroup' => '1a1a', 'ancestry' => 'Asian']);
        $data = array('type' => 'Mito', 'letter' => 'G', 'subgroup' => '1a1a', 'ancestry' => 'Asian', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$hg->exists) ? $hg->fill($data)->save() : $hg->fill(array_except($data, ['created_at']))->save();

        $hg = Haplogroup::firstOrNew(['type' => 'Mito', 'letter' => 'G', 'subgroup' => '1a3', 'ancestry' => 'Asian']);
        $data = array('type' => 'Mito', 'letter' => 'G', 'subgroup' => '1a3', 'ancestry' => 'Asian', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$hg->exists) ? $hg->fill($data)->save() : $hg->fill(array_except($data, ['created_at']))->save();

        $hg = Haplogroup::firstOrNew(['type' => 'Mito', 'letter' => 'G', 'subgroup' => '2', 'ancestry' => 'Asian']);
        $data = array('type' => 'Mito', 'letter' => 'G', 'subgroup' => '2', 'ancestry' => 'Asian', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$hg->exists) ? $hg->fill($data)->save() : $hg->fill(array_except($data, ['created_at']))->save();

        $hg = Haplogroup::firstOrNew(['type' => 'Mito', 'letter' => 'G', 'subgroup' => '2a1c', 'ancestry' => 'Asian']);
        $data = array('type' => 'Mito', 'letter' => 'G', 'subgroup' => '2a1c', 'ancestry' => 'Asian', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$hg->exists) ? $hg->fill($data)->save() : $hg->fill(array_except($data, ['created_at']))->save();

        $hg = Haplogroup::firstOrNew(['type' => 'Mito', 'letter' => 'G', 'subgroup' => '2a', 'ancestry' => 'Asian']);
        $data = array('type' => 'Mito', 'letter' => 'G', 'subgroup' => '2a', 'ancestry' => 'Asian', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$hg->exists) ? $hg->fill($data)->save() : $hg->fill(array_except($data, ['created_at']))->save();

        $hg = Haplogroup::firstOrNew(['type' => 'Mito', 'letter' => 'G', 'subgroup' => '2a1c1', 'ancestry' => 'Asian']);
        $data = array('type' => 'Mito', 'letter' => 'G', 'subgroup' => '2a1c1', 'ancestry' => 'Asian', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$hg->exists) ? $hg->fill($data)->save() : $hg->fill(array_except($data, ['created_at']))->save();

        $hg = Haplogroup::firstOrNew(['type' => 'Mito', 'letter' => 'G', 'subgroup' => '2a1d', 'ancestry' => 'Asian']);
        $data = array('type' => 'Mito', 'letter' => 'G', 'subgroup' => '2a1d', 'ancestry' => 'Asian', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$hg->exists) ? $hg->fill($data)->save() : $hg->fill(array_except($data, ['created_at']))->save();

        $hg = Haplogroup::firstOrNew(['type' => 'Mito', 'letter' => 'G', 'subgroup' => '2a4', 'ancestry' => 'Asian']);
        $data = array('type' => 'Mito', 'letter' => 'G', 'subgroup' => '2a4', 'ancestry' => 'Asian', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$hg->exists) ? $hg->fill($data)->save() : $hg->fill(array_except($data, ['created_at']))->save();

        $hg = Haplogroup::firstOrNew(['type' => 'Mito', 'letter' => 'G', 'subgroup' => '3a2a', 'ancestry' => 'Asian']);
        $data = array('type' => 'Mito', 'letter' => 'G', 'subgroup' => '3a2a', 'ancestry' => 'Asian', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$hg->exists) ? $hg->fill($data)->save() : $hg->fill(array_except($data, ['created_at']))->save();

        $hg = Haplogroup::firstOrNew(['type' => 'Mito', 'letter' => 'H', 'subgroup' => '', 'ancestry' => 'European']);
        $data = array('type' => 'Mito', 'letter' => 'H', 'subgroup' => '', 'ancestry' => 'European', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$hg->exists) ? $hg->fill($data)->save() : $hg->fill(array_except($data, ['created_at']))->save();

        $hg = Haplogroup::firstOrNew(['type' => 'Mito', 'letter' => 'H', 'subgroup' => '1', 'ancestry' => 'European']);
        $data = array('type' => 'Mito', 'letter' => 'H', 'subgroup' => '1', 'ancestry' => 'European', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$hg->exists) ? $hg->fill($data)->save() : $hg->fill(array_except($data, ['created_at']))->save();

        $hg = Haplogroup::firstOrNew(['type' => 'Mito', 'letter' => 'H', 'subgroup' => '1c', 'ancestry' => 'European']);
        $data = array('type' => 'Mito', 'letter' => 'H', 'subgroup' => '1c', 'ancestry' => 'European', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$hg->exists) ? $hg->fill($data)->save() : $hg->fill(array_except($data, ['created_at']))->save();

        $hg = Haplogroup::firstOrNew(['type' => 'Mito', 'letter' => 'H', 'subgroup' => '5h', 'ancestry' => 'European']);
        $data = array('type' => 'Mito', 'letter' => 'H', 'subgroup' => '5h', 'ancestry' => 'European', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$hg->exists) ? $hg->fill($data)->save() : $hg->fill(array_except($data, ['created_at']))->save();

        $hg = Haplogroup::firstOrNew(['type' => 'Mito', 'letter' => 'H', 'subgroup' => '15', 'ancestry' => 'European']);
        $data = array('type' => 'Mito', 'letter' => 'H', 'subgroup' => '15', 'ancestry' => 'European', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$hg->exists) ? $hg->fill($data)->save() : $hg->fill(array_except($data, ['created_at']))->save();

        $hg = Haplogroup::firstOrNew(['type' => 'Mito', 'letter' => 'H', 'subgroup' => '1a', 'ancestry' => 'European']);
        $data = array('type' => 'Mito', 'letter' => 'H', 'subgroup' => '1a', 'ancestry' => 'European', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$hg->exists) ? $hg->fill($data)->save() : $hg->fill(array_except($data, ['created_at']))->save();

        $hg = Haplogroup::firstOrNew(['type' => 'Mito', 'letter' => 'H', 'subgroup' => '1J', 'ancestry' => 'European']);
        $data = array('type' => 'Mito', 'letter' => 'H', 'subgroup' => '1J', 'ancestry' => 'European', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$hg->exists) ? $hg->fill($data)->save() : $hg->fill(array_except($data, ['created_at']))->save();

        $hg = Haplogroup::firstOrNew(['type' => 'Mito', 'letter' => 'H', 'subgroup' => '1a1', 'ancestry' => 'European']);
        $data = array('type' => 'Mito', 'letter' => 'H', 'subgroup' => '1a1', 'ancestry' => 'European', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$hg->exists) ? $hg->fill($data)->save() : $hg->fill(array_except($data, ['created_at']))->save();

        $hg = Haplogroup::firstOrNew(['type' => 'Mito', 'letter' => 'H', 'subgroup' => '6a1', 'ancestry' => 'European']);
        $data = array('type' => 'Mito', 'letter' => 'H', 'subgroup' => '6a1', 'ancestry' => 'European', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$hg->exists) ? $hg->fill($data)->save() : $hg->fill(array_except($data, ['created_at']))->save();

        $hg = Haplogroup::firstOrNew(['type' => 'Mito', 'letter' => 'H', 'subgroup' => '2a2a1', 'ancestry' => 'European']);
        $data = array('type' => 'Mito', 'letter' => 'H', 'subgroup' => '2a2a1', 'ancestry' => 'European', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$hg->exists) ? $hg->fill($data)->save() : $hg->fill(array_except($data, ['created_at']))->save();

        $hg = Haplogroup::firstOrNew(['type' => 'Mito', 'letter' => 'H', 'subgroup' => '2a', 'ancestry' => 'European']);
        $data = array('type' => 'Mito', 'letter' => 'H', 'subgroup' => '2a', 'ancestry' => 'European', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$hg->exists) ? $hg->fill($data)->save() : $hg->fill(array_except($data, ['created_at']))->save();

        $hg = Haplogroup::firstOrNew(['type' => 'Mito', 'letter' => 'H', 'subgroup' => 'V0', 'ancestry' => 'European']);
        $data = array('type' => 'Mito', 'letter' => 'H', 'subgroup' => 'V0', 'ancestry' => '', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$hg->exists) ? $hg->fill($data)->save() : $hg->fill(array_except($data, ['created_at']))->save();

        $hg = Haplogroup::firstOrNew(['type' => 'Mito', 'letter' => 'H', 'subgroup' => '1n1n', 'ancestry' => 'European']);
        $data = array('type' => 'Mito', 'letter' => 'H', 'subgroup' => '1n1n', 'ancestry' => 'European', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$hg->exists) ? $hg->fill($data)->save() : $hg->fill(array_except($data, ['created_at']))->save();

        $hg = Haplogroup::firstOrNew(['type' => 'Mito', 'letter' => 'H', 'subgroup' => '11a2a1', 'ancestry' => 'European']);
        $data = array('type' => 'Mito', 'letter' => 'H', 'subgroup' => '11a2a1', 'ancestry' => 'European', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$hg->exists) ? $hg->fill($data)->save() : $hg->fill(array_except($data, ['created_at']))->save();

        $hg = Haplogroup::firstOrNew(['type' => 'Mito', 'letter' => 'H', 'subgroup' => '14a', 'ancestry' => 'European']);
        $data = array('type' => 'Mito', 'letter' => 'H', 'subgroup' => '14a', 'ancestry' => 'European', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$hg->exists) ? $hg->fill($data)->save() : $hg->fill(array_except($data, ['created_at']))->save();

        $hg = Haplogroup::firstOrNew(['type' => 'Mito', 'letter' => 'H', 'subgroup' => '1a3', 'ancestry' => 'European']);
        $data = array('type' => 'Mito', 'letter' => 'H', 'subgroup' => '1a3', 'ancestry' => 'European', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$hg->exists) ? $hg->fill($data)->save() : $hg->fill(array_except($data, ['created_at']))->save();

        $hg = Haplogroup::firstOrNew(['type' => 'Mito', 'letter' => 'H', 'subgroup' => '1ab', 'ancestry' => 'European']);
        $data = array('type' => 'Mito', 'letter' => 'H', 'subgroup' => '1ab', 'ancestry' => 'European', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$hg->exists) ? $hg->fill($data)->save() : $hg->fill(array_except($data, ['created_at']))->save();

        $hg = Haplogroup::firstOrNew(['type' => 'Mito', 'letter' => 'H', 'subgroup' => '3am', 'ancestry' => 'European']);
        $data = array('type' => 'Mito', 'letter' => 'H', 'subgroup' => '3am', 'ancestry' => 'European', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$hg->exists) ? $hg->fill($data)->save() : $hg->fill(array_except($data, ['created_at']))->save();

        $hg = Haplogroup::firstOrNew(['type' => 'Mito', 'letter' => 'H', 'subgroup' => '3s', 'ancestry' => 'European']);
        $data = array('type' => 'Mito', 'letter' => 'H', 'subgroup' => '3s', 'ancestry' => 'European', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$hg->exists) ? $hg->fill($data)->save() : $hg->fill(array_except($data, ['created_at']))->save();

        $hg = Haplogroup::firstOrNew(['type' => 'Mito', 'letter' => 'H', 'subgroup' => '6', 'ancestry' => 'European']);
        $data = array('type' => 'Mito', 'letter' => 'H', 'subgroup' => '6', 'ancestry' => 'European', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$hg->exists) ? $hg->fill($data)->save() : $hg->fill(array_except($data, ['created_at']))->save();

        $hg = Haplogroup::firstOrNew(['type' => 'Mito', 'letter' => 'H', 'subgroup' => '6a1b3', 'ancestry' => 'European']);
        $data = array('type' => 'Mito', 'letter' => 'H', 'subgroup' => '6a1b3', 'ancestry' => 'European', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$hg->exists) ? $hg->fill($data)->save() : $hg->fill(array_except($data, ['created_at']))->save();

        $hg = Haplogroup::firstOrNew(['type' => 'Mito', 'letter' => 'H', 'subgroup' => '1+16239', 'ancestry' => 'European']);
        $data = array('type' => 'Mito', 'letter' => 'H', 'subgroup' => '1+16239', 'ancestry' => 'European', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$hg->exists) ? $hg->fill($data)->save() : $hg->fill(array_except($data, ['created_at']))->save();

        $hg = Haplogroup::firstOrNew(['type' => 'Mito', 'letter' => 'H', 'subgroup' => '100', 'ancestry' => 'European']);
        $data = array('type' => 'Mito', 'letter' => 'H', 'subgroup' => '100', 'ancestry' => 'European', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$hg->exists) ? $hg->fill($data)->save() : $hg->fill(array_except($data, ['created_at']))->save();

        $hg = Haplogroup::firstOrNew(['type' => 'Mito', 'letter' => 'H', 'subgroup' => '11a', 'ancestry' => 'European']);
        $data = array('type' => 'Mito', 'letter' => 'H', 'subgroup' => '11a', 'ancestry' => 'European', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$hg->exists) ? $hg->fill($data)->save() : $hg->fill(array_except($data, ['created_at']))->save();

        $hg = Haplogroup::firstOrNew(['type' => 'Mito', 'letter' => 'H', 'subgroup' => '1a6', 'ancestry' => 'European']);
        $data = array('type' => 'Mito', 'letter' => 'H', 'subgroup' => '1a6', 'ancestry' => 'European', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$hg->exists) ? $hg->fill($data)->save() : $hg->fill(array_except($data, ['created_at']))->save();

        $hg = Haplogroup::firstOrNew(['type' => 'Mito', 'letter' => 'H', 'subgroup' => '1b', 'ancestry' => 'European']);
        $data = array('type' => 'Mito', 'letter' => 'H', 'subgroup' => '1b', 'ancestry' => 'European', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$hg->exists) ? $hg->fill($data)->save() : $hg->fill(array_except($data, ['created_at']))->save();

        $hg = Haplogroup::firstOrNew(['type' => 'Mito', 'letter' => 'H', 'subgroup' => '2a3', 'ancestry' => 'European']);
        $data = array('type' => 'Mito', 'letter' => 'H', 'subgroup' => '2a3', 'ancestry' => 'European', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$hg->exists) ? $hg->fill($data)->save() : $hg->fill(array_except($data, ['created_at']))->save();

        $hg = Haplogroup::firstOrNew(['type' => 'Mito', 'letter' => 'H', 'subgroup' => '3ah', 'ancestry' => 'European']);
        $data = array('type' => 'Mito', 'letter' => 'H', 'subgroup' => '3ah', 'ancestry' => 'European', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$hg->exists) ? $hg->fill($data)->save() : $hg->fill(array_except($data, ['created_at']))->save();

        $hg = Haplogroup::firstOrNew(['type' => 'Mito', 'letter' => 'H', 'subgroup' => '5', 'ancestry' => 'European']);
        $data = array('type' => 'Mito', 'letter' => 'H', 'subgroup' => '5', 'ancestry' => 'European', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$hg->exists) ? $hg->fill($data)->save() : $hg->fill(array_except($data, ['created_at']))->save();

        $hg = Haplogroup::firstOrNew(['type' => 'Mito', 'letter' => 'H', 'subgroup' => '5s', 'ancestry' => 'European']);
        $data = array('type' => 'Mito', 'letter' => 'H', 'subgroup' => '5s', 'ancestry' => 'European', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$hg->exists) ? $hg->fill($data)->save() : $hg->fill(array_except($data, ['created_at']))->save();

        $hg = Haplogroup::firstOrNew(['type' => 'Mito', 'letter' => 'H', 'subgroup' => '13a1a1d1', 'ancestry' => 'European']);
        $data = array('type' => 'Mito', 'letter' => 'H', 'subgroup' => '13a1a1d1', 'ancestry' => 'European', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$hg->exists) ? $hg->fill($data)->save() : $hg->fill(array_except($data, ['created_at']))->save();

        $hg = Haplogroup::firstOrNew(['type' => 'Mito', 'letter' => 'I', 'subgroup' => '', 'ancestry' => 'European']);
        $data = array('type' => 'Mito', 'letter' => 'I', 'subgroup' => '', 'ancestry' => 'European', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$hg->exists) ? $hg->fill($data)->save() : $hg->fill(array_except($data, ['created_at']))->save();

        $hg = Haplogroup::firstOrNew(['type' => 'Mito', 'letter' => 'I', 'subgroup' => '1a1', 'ancestry' => 'European']);
        $data = array('type' => 'Mito', 'letter' => 'I', 'subgroup' => '1a1', 'ancestry' => 'European', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$hg->exists) ? $hg->fill($data)->save() : $hg->fill(array_except($data, ['created_at']))->save();

        $hg = Haplogroup::firstOrNew(['type' => 'Mito', 'letter' => 'J', 'subgroup' => '1c', 'ancestry' => 'European']);
        $data = array('type' => 'Mito', 'letter' => 'J', 'subgroup' => '1c', 'ancestry' => 'European', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$hg->exists) ? $hg->fill($data)->save() : $hg->fill(array_except($data, ['created_at']))->save();

        $hg = Haplogroup::firstOrNew(['type' => 'Mito', 'letter' => 'J', 'subgroup' => '1b1a1', 'ancestry' => 'European']);
        $data = array('type' => 'Mito', 'letter' => 'J', 'subgroup' => '1b1a1', 'ancestry' => 'European', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$hg->exists) ? $hg->fill($data)->save() : $hg->fill(array_except($data, ['created_at']))->save();

        $hg = Haplogroup::firstOrNew(['type' => 'Mito', 'letter' => 'J', 'subgroup' => '1c2r', 'ancestry' => 'European']);
        $data = array('type' => 'Mito', 'letter' => 'J', 'subgroup' => '1c2r', 'ancestry' => 'European', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$hg->exists) ? $hg->fill($data)->save() : $hg->fill(array_except($data, ['created_at']))->save();

        $hg = Haplogroup::firstOrNew(['type' => 'Mito', 'letter' => 'J', 'subgroup' => '2b1a', 'ancestry' => 'European']);
        $data = array('type' => 'Mito', 'letter' => 'J', 'subgroup' => '2b1a', 'ancestry' => 'European', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$hg->exists) ? $hg->fill($data)->save() : $hg->fill(array_except($data, ['created_at']))->save();

        $hg = Haplogroup::firstOrNew(['type' => 'Mito', 'letter' => 'J', 'subgroup' => '1', 'ancestry' => 'European']);
        $data = array('type' => 'Mito', 'letter' => 'J', 'subgroup' => '1', 'ancestry' => 'European', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$hg->exists) ? $hg->fill($data)->save() : $hg->fill(array_except($data, ['created_at']))->save();

        $hg = Haplogroup::firstOrNew(['type' => 'Mito', 'letter' => 'J', 'subgroup' => '1c2', 'ancestry' => 'European']);
        $data = array('type' => 'Mito', 'letter' => 'J', 'subgroup' => '1c2', 'ancestry' => 'European', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$hg->exists) ? $hg->fill($data)->save() : $hg->fill(array_except($data, ['created_at']))->save();

        $hg = Haplogroup::firstOrNew(['type' => 'Mito', 'letter' => 'J', 'subgroup' => '1c2b4', 'ancestry' => 'European']);
        $data = array('type' => 'Mito', 'letter' => 'J', 'subgroup' => '1c2b4', 'ancestry' => 'European', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$hg->exists) ? $hg->fill($data)->save() : $hg->fill(array_except($data, ['created_at']))->save();

        $hg = Haplogroup::firstOrNew(['type' => 'Mito', 'letter' => 'K', 'subgroup' => '', 'ancestry' => 'European']);
        $data = array('type' => 'Mito', 'letter' => 'K', 'subgroup' => '', 'ancestry' => 'European', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$hg->exists) ? $hg->fill($data)->save() : $hg->fill(array_except($data, ['created_at']))->save();

        $hg = Haplogroup::firstOrNew(['type' => 'Mito', 'letter' => 'K', 'subgroup' => '1a24a', 'ancestry' => 'European']);
        $data = array('type' => 'Mito', 'letter' => 'K', 'subgroup' => '1a24a', 'ancestry' => 'European', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$hg->exists) ? $hg->fill($data)->save() : $hg->fill(array_except($data, ['created_at']))->save();

        $hg = Haplogroup::firstOrNew(['type' => 'Mito', 'letter' => 'K', 'subgroup' => '1', 'ancestry' => 'European']);
        $data = array('type' => 'Mito', 'letter' => 'K', 'subgroup' => '1', 'ancestry' => 'European', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$hg->exists) ? $hg->fill($data)->save() : $hg->fill(array_except($data, ['created_at']))->save();

        $hg = Haplogroup::firstOrNew(['type' => 'Mito', 'letter' => 'K', 'subgroup' => '1a', 'ancestry' => 'European']);
        $data = array('type' => 'Mito', 'letter' => 'K', 'subgroup' => '1a', 'ancestry' => 'European', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$hg->exists) ? $hg->fill($data)->save() : $hg->fill(array_except($data, ['created_at']))->save();

        $hg = Haplogroup::firstOrNew(['type' => 'Mito', 'letter' => 'K', 'subgroup' => '1a1b2a', 'ancestry' => 'European']);
        $data = array('type' => 'Mito', 'letter' => 'K', 'subgroup' => '1a1b2a', 'ancestry' => 'European', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$hg->exists) ? $hg->fill($data)->save() : $hg->fill(array_except($data, ['created_at']))->save();

        $hg = Haplogroup::firstOrNew(['type' => 'Mito', 'letter' => 'K', 'subgroup' => '1d', 'ancestry' => 'European']);
        $data = array('type' => 'Mito', 'letter' => 'K', 'subgroup' => '1d', 'ancestry' => 'European', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$hg->exists) ? $hg->fill($data)->save() : $hg->fill(array_except($data, ['created_at']))->save();

        $hg = Haplogroup::firstOrNew(['type' => 'Mito', 'letter' => 'K', 'subgroup' => '1a4a1a3', 'ancestry' => 'European']);
        $data = array('type' => 'Mito', 'letter' => 'K', 'subgroup' => '1a4a1a3', 'ancestry' => 'European', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$hg->exists) ? $hg->fill($data)->save() : $hg->fill(array_except($data, ['created_at']))->save();

        $hg = Haplogroup::firstOrNew(['type' => 'Mito', 'letter' => 'K', 'subgroup' => '2a8', 'ancestry' => 'European']);
        $data = array('type' => 'Mito', 'letter' => 'K', 'subgroup' => '2a8', 'ancestry' => 'European', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$hg->exists) ? $hg->fill($data)->save() : $hg->fill(array_except($data, ['created_at']))->save();

        $hg = Haplogroup::firstOrNew(['type' => 'Mito', 'letter' => 'L', 'subgroup' => '1c2', 'ancestry' => 'African']);
        $data = array('type' => 'Mito', 'letter' => 'L', 'subgroup' => '1c2', 'ancestry' => 'African', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$hg->exists) ? $hg->fill($data)->save() : $hg->fill(array_except($data, ['created_at']))->save();

        $hg = Haplogroup::firstOrNew(['type' => 'Mito', 'letter' => 'L', 'subgroup' => '2c4', 'ancestry' => 'African']);
        $data = array('type' => 'Mito', 'letter' => 'L', 'subgroup' => '2c4', 'ancestry' => 'African', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$hg->exists) ? $hg->fill($data)->save() : $hg->fill(array_except($data, ['created_at']))->save();

        $hg = Haplogroup::firstOrNew(['type' => 'Mito', 'letter' => 'L', 'subgroup' => '3b1a', 'ancestry' => 'African']);
        $data = array('type' => 'Mito', 'letter' => 'L', 'subgroup' => '3b1a', 'ancestry' => 'African', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$hg->exists) ? $hg->fill($data)->save() : $hg->fill(array_except($data, ['created_at']))->save();

        $hg = Haplogroup::firstOrNew(['type' => 'Mito', 'letter' => 'L', 'subgroup' => '3e1e', 'ancestry' => 'African']);
        $data = array('type' => 'Mito', 'letter' => 'L', 'subgroup' => '3e1e', 'ancestry' => 'African', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$hg->exists) ? $hg->fill($data)->save() : $hg->fill(array_except($data, ['created_at']))->save();

        $hg = Haplogroup::firstOrNew(['type' => 'Mito', 'letter' => 'L', 'subgroup' => '3e2', 'ancestry' => 'African']);
        $data = array('type' => 'Mito', 'letter' => 'L', 'subgroup' => '3e2', 'ancestry' => 'African', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$hg->exists) ? $hg->fill($data)->save() : $hg->fill(array_except($data, ['created_at']))->save();

        $hg = Haplogroup::firstOrNew(['type' => 'Mito', 'letter' => 'L', 'subgroup' => '3e2b', 'ancestry' => 'African']);
        $data = array('type' => 'Mito', 'letter' => 'L', 'subgroup' => '3e2b', 'ancestry' => 'African', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$hg->exists) ? $hg->fill($data)->save() : $hg->fill(array_except($data, ['created_at']))->save();

        $hg = Haplogroup::firstOrNew(['type' => 'Mito', 'letter' => 'L', 'subgroup' => '3k1', 'ancestry' => 'African']);
        $data = array('type' => 'Mito', 'letter' => 'L', 'subgroup' => '3k1', 'ancestry' => 'African', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$hg->exists) ? $hg->fill($data)->save() : $hg->fill(array_except($data, ['created_at']))->save();

        $hg = Haplogroup::firstOrNew(['type' => 'Mito', 'letter' => 'L', 'subgroup' => '4b2b1', 'ancestry' => 'African']);
        $data = array('type' => 'Mito', 'letter' => 'L', 'subgroup' => '4b2b1', 'ancestry' => 'African', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$hg->exists) ? $hg->fill($data)->save() : $hg->fill(array_except($data, ['created_at']))->save();

        $hg = Haplogroup::firstOrNew(['type' => 'Mito', 'letter' => 'M', 'subgroup' => '', 'ancestry' => 'Asian']);
        $data = array('type' => 'Mito', 'letter' => 'M', 'subgroup' => '', 'ancestry' => 'Asian', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$hg->exists) ? $hg->fill($data)->save() : $hg->fill(array_except($data, ['created_at']))->save();

        $hg = Haplogroup::firstOrNew(['type' => 'Mito', 'letter' => 'M', 'subgroup' => '', 'ancestry' => 'Native American']);
        $data = array('type' => 'Mito', 'letter' => 'M', 'subgroup' => '', 'ancestry' => 'Native American', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$hg->exists) ? $hg->fill($data)->save() : $hg->fill(array_except($data, ['created_at']))->save();

        $hg = Haplogroup::firstOrNew(['type' => 'Mito', 'letter' => 'M', 'subgroup' => '5c1', 'ancestry' => 'Asian']);
        $data = array('type' => 'Mito', 'letter' => 'M', 'subgroup' => '5c1', 'ancestry' => 'Asian', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$hg->exists) ? $hg->fill($data)->save() : $hg->fill(array_except($data, ['created_at']))->save();

        $hg = Haplogroup::firstOrNew(['type' => 'Mito', 'letter' => 'M', 'subgroup' => '13a1a', 'ancestry' => 'Asian']);
        $data = array('type' => 'Mito', 'letter' => 'M', 'subgroup' => '13a1a', 'ancestry' => 'Asian', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$hg->exists) ? $hg->fill($data)->save() : $hg->fill(array_except($data, ['created_at']))->save();

        $hg = Haplogroup::firstOrNew(['type' => 'Mito', 'letter' => 'M', 'subgroup' => '7a1a2', 'ancestry' => 'East Asian']);
        $data = array('type' => 'Mito', 'letter' => 'M', 'subgroup' => '7a1a2', 'ancestry' => 'East Asian', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$hg->exists) ? $hg->fill($data)->save() : $hg->fill(array_except($data, ['created_at']))->save();

        $hg = Haplogroup::firstOrNew(['type' => 'Mito', 'letter' => 'M', 'subgroup' => '7a1a7', 'ancestry' => 'Asian']);
        $data = array('type' => 'Mito', 'letter' => 'M', 'subgroup' => '7a1a7', 'ancestry' => 'Asian', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$hg->exists) ? $hg->fill($data)->save() : $hg->fill(array_except($data, ['created_at']))->save();

        $hg = Haplogroup::firstOrNew(['type' => 'Mito', 'letter' => 'M', 'subgroup' => '7a1a8', 'ancestry' => 'Asian']);
        $data = array('type' => 'Mito', 'letter' => 'M', 'subgroup' => '7a1a8', 'ancestry' => 'Asian', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$hg->exists) ? $hg->fill($data)->save() : $hg->fill(array_except($data, ['created_at']))->save();

        $hg = Haplogroup::firstOrNew(['type' => 'Mito', 'letter' => 'M', 'subgroup' => '7a2a', 'ancestry' => 'Asian']);
        $data = array('type' => 'Mito', 'letter' => 'M', 'subgroup' => '7a2a', 'ancestry' => 'Asian', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$hg->exists) ? $hg->fill($data)->save() : $hg->fill(array_except($data, ['created_at']))->save();

        $hg = Haplogroup::firstOrNew(['type' => 'Mito', 'letter' => 'M', 'subgroup' => '7b1a1a1', 'ancestry' => 'Asian']);
        $data = array('type' => 'Mito', 'letter' => 'M', 'subgroup' => '7b1a1a1', 'ancestry' => 'Asian', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$hg->exists) ? $hg->fill($data)->save() : $hg->fill(array_except($data, ['created_at']))->save();

        $hg = Haplogroup::firstOrNew(['type' => 'Mito', 'letter' => 'M', 'subgroup' => '7b2', 'ancestry' => 'Asian']);
        $data = array('type' => 'Mito', 'letter' => 'M', 'subgroup' => '7b2', 'ancestry' => 'Asian', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$hg->exists) ? $hg->fill($data)->save() : $hg->fill(array_except($data, ['created_at']))->save();

        $hg = Haplogroup::firstOrNew(['type' => 'Mito', 'letter' => 'M', 'subgroup' => '8', 'ancestry' => 'Asian']);
        $data = array('type' => 'Mito', 'letter' => 'M', 'subgroup' => '8', 'ancestry' => 'Asian', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$hg->exists) ? $hg->fill($data)->save() : $hg->fill(array_except($data, ['created_at']))->save();

        $hg = Haplogroup::firstOrNew(['type' => 'Mito', 'letter' => 'M', 'subgroup' => '9a1a', 'ancestry' => 'Asian']);
        $data = array('type' => 'Mito', 'letter' => 'M', 'subgroup' => '9a1a', 'ancestry' => 'Asian', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$hg->exists) ? $hg->fill($data)->save() : $hg->fill(array_except($data, ['created_at']))->save();

        $hg = Haplogroup::firstOrNew(['type' => 'Mito', 'letter' => 'M', 'subgroup' => '9a1a1', 'ancestry' => 'Asian']);
        $data = array('type' => 'Mito', 'letter' => 'M', 'subgroup' => '9a1a1', 'ancestry' => 'Asian', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$hg->exists) ? $hg->fill($data)->save() : $hg->fill(array_except($data, ['created_at']))->save();

        $hg = Haplogroup::firstOrNew(['type' => 'Mito', 'letter' => 'M', 'subgroup' => '9a1a1b', 'ancestry' => 'Asian']);
        $data = array('type' => 'Mito', 'letter' => 'M', 'subgroup' => '9a1a1b', 'ancestry' => 'Asian', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$hg->exists) ? $hg->fill($data)->save() : $hg->fill(array_except($data, ['created_at']))->save();

        $hg = Haplogroup::firstOrNew(['type' => 'Mito', 'letter' => 'N', 'subgroup' => '9a', 'ancestry' => 'Asian']);
        $data = array('type' => 'Mito', 'letter' => 'N', 'subgroup' => '9a', 'ancestry' => 'Asian', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$hg->exists) ? $hg->fill($data)->save() : $hg->fill(array_except($data, ['created_at']))->save();

        $hg = Haplogroup::firstOrNew(['type' => 'Mito', 'letter' => 'N', 'subgroup' => '9a1', 'ancestry' => 'Asian']);
        $data = array('type' => 'Mito', 'letter' => 'N', 'subgroup' => '9a1', 'ancestry' => 'Asian', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$hg->exists) ? $hg->fill($data)->save() : $hg->fill(array_except($data, ['created_at']))->save();

        $hg = Haplogroup::firstOrNew(['type' => 'Mito', 'letter' => 'N', 'subgroup' => '9a1\'3', 'ancestry' => 'Asian']);
        $data = array('type' => 'Mito', 'letter' => 'N', 'subgroup' => '9a1\'3', 'ancestry' => 'Asian', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$hg->exists) ? $hg->fill($data)->save() : $hg->fill(array_except($data, ['created_at']))->save();

        $hg = Haplogroup::firstOrNew(['type' => 'Mito', 'letter' => 'N', 'subgroup' => '9a2\'4\'5\'11', 'ancestry' => 'Asian']);
        $data = array('type' => 'Mito', 'letter' => 'N', 'subgroup' => '9a2\'4\'5\'11', 'ancestry' => 'Asian', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$hg->exists) ? $hg->fill($data)->save() : $hg->fill(array_except($data, ['created_at']))->save();

        $hg = Haplogroup::firstOrNew(['type' => 'Mito', 'letter' => 'N', 'subgroup' => '9a2c', 'ancestry' => 'Asian']);
        $data = array('type' => 'Mito', 'letter' => 'N', 'subgroup' => '9a2c', 'ancestry' => 'Asian', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$hg->exists) ? $hg->fill($data)->save() : $hg->fill(array_except($data, ['created_at']))->save();

        $hg = Haplogroup::firstOrNew(['type' => 'Mito', 'letter' => 'R', 'subgroup' => '1a', 'ancestry' => 'European']);
        $data = array('type' => 'Mito', 'letter' => 'R', 'subgroup' => '1a', 'ancestry' => 'European', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$hg->exists) ? $hg->fill($data)->save() : $hg->fill(array_except($data, ['created_at']))->save();

        $hg = Haplogroup::firstOrNew(['type' => 'Mito', 'letter' => 'R', 'subgroup' => '0', 'ancestry' => 'European/Middle East']);
        $data = array('type' => 'Mito', 'letter' => 'R', 'subgroup' => '0', 'ancestry' => 'European/Middle East', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$hg->exists) ? $hg->fill($data)->save() : $hg->fill(array_except($data, ['created_at']))->save();

        $hg = Haplogroup::firstOrNew(['type' => 'Mito', 'letter' => 'T', 'subgroup' => '2b6b', 'ancestry' => 'European']);
        $data = array('type' => 'Mito', 'letter' => 'T', 'subgroup' => '2b6b', 'ancestry' => 'European', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$hg->exists) ? $hg->fill($data)->save() : $hg->fill(array_except($data, ['created_at']))->save();

        $hg = Haplogroup::firstOrNew(['type' => 'Mito', 'letter' => 'T', 'subgroup' => '1a', 'ancestry' => 'European']);
        $data = array('type' => 'Mito', 'letter' => 'T', 'subgroup' => '1a', 'ancestry' => 'European', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$hg->exists) ? $hg->fill($data)->save() : $hg->fill(array_except($data, ['created_at']))->save();

        $hg = Haplogroup::firstOrNew(['type' => 'Mito', 'letter' => 'T', 'subgroup' => '2', 'ancestry' => 'European']);
        $data = array('type' => 'Mito', 'letter' => 'T', 'subgroup' => '2', 'ancestry' => 'European', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$hg->exists) ? $hg->fill($data)->save() : $hg->fill(array_except($data, ['created_at']))->save();

        $hg = Haplogroup::firstOrNew(['type' => 'Mito', 'letter' => 'T', 'subgroup' => '2a1b1a', 'ancestry' => 'European']);
        $data = array('type' => 'Mito', 'letter' => 'T', 'subgroup' => '2a1b1a', 'ancestry' => 'European', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$hg->exists) ? $hg->fill($data)->save() : $hg->fill(array_except($data, ['created_at']))->save();

        $hg = Haplogroup::firstOrNew(['type' => 'Mito', 'letter' => 'T', 'subgroup' => '2b', 'ancestry' => 'European']);
        $data = array('type' => 'Mito', 'letter' => 'T', 'subgroup' => '2b', 'ancestry' => 'European', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$hg->exists) ? $hg->fill($data)->save() : $hg->fill(array_except($data, ['created_at']))->save();

        $hg = Haplogroup::firstOrNew(['type' => 'Mito', 'letter' => 'T', 'subgroup' => '2c1+146', 'ancestry' => 'European']);
        $data = array('type' => 'Mito', 'letter' => 'T', 'subgroup' => '2c1+146', 'ancestry' => 'European', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$hg->exists) ? $hg->fill($data)->save() : $hg->fill(array_except($data, ['created_at']))->save();

        $hg = Haplogroup::firstOrNew(['type' => 'Mito', 'letter' => 'U', 'subgroup' => '1a1a', 'ancestry' => 'Westeurasian']);
        $data = array('type' => 'Mito', 'letter' => 'U', 'subgroup' => '1a1a', 'ancestry' => 'Westeurasian', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$hg->exists) ? $hg->fill($data)->save() : $hg->fill(array_except($data, ['created_at']))->save();

        $hg = Haplogroup::firstOrNew(['type' => 'Mito', 'letter' => 'U', 'subgroup' => '5a', 'ancestry' => 'European']);
        $data = array('type' => 'Mito', 'letter' => 'U', 'subgroup' => '5a', 'ancestry' => 'European', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$hg->exists) ? $hg->fill($data)->save() : $hg->fill(array_except($data, ['created_at']))->save();

        $hg = Haplogroup::firstOrNew(['type' => 'Mito', 'letter' => 'U', 'subgroup' => '1b', 'ancestry' => 'European']);
        $data = array('type' => 'Mito', 'letter' => 'U', 'subgroup' => '1b', 'ancestry' => 'European', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$hg->exists) ? $hg->fill($data)->save() : $hg->fill(array_except($data, ['created_at']))->save();

        $hg = Haplogroup::firstOrNew(['type' => 'Mito', 'letter' => 'U', 'subgroup' => '2e1a1b', 'ancestry' => 'European']);
        $data = array('type' => 'Mito', 'letter' => 'U', 'subgroup' => '2e1a1b', 'ancestry' => 'European', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$hg->exists) ? $hg->fill($data)->save() : $hg->fill(array_except($data, ['created_at']))->save();

        $hg = Haplogroup::firstOrNew(['type' => 'Mito', 'letter' => 'U', 'subgroup' => '3a', 'ancestry' => 'European']);
        $data = array('type' => 'Mito', 'letter' => 'U', 'subgroup' => '3a', 'ancestry' => 'European', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$hg->exists) ? $hg->fill($data)->save() : $hg->fill(array_except($data, ['created_at']))->save();

        $hg = Haplogroup::firstOrNew(['type' => 'Mito', 'letter' => 'U', 'subgroup' => '4a1', 'ancestry' => 'European']);
        $data = array('type' => 'Mito', 'letter' => 'U', 'subgroup' => '4a1', 'ancestry' => 'European', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$hg->exists) ? $hg->fill($data)->save() : $hg->fill(array_except($data, ['created_at']))->save();

        $hg = Haplogroup::firstOrNew(['type' => 'Mito', 'letter' => 'U', 'subgroup' => '4a1b1', 'ancestry' => 'European']);
        $data = array('type' => 'Mito', 'letter' => 'U', 'subgroup' => '4a1b1', 'ancestry' => 'European', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$hg->exists) ? $hg->fill($data)->save() : $hg->fill(array_except($data, ['created_at']))->save();

        $hg = Haplogroup::firstOrNew(['type' => 'Mito', 'letter' => 'U', 'subgroup' => '4c1a', 'ancestry' => 'European']);
        $data = array('type' => 'Mito', 'letter' => 'U', 'subgroup' => '4c1a', 'ancestry' => 'European', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$hg->exists) ? $hg->fill($data)->save() : $hg->fill(array_except($data, ['created_at']))->save();

        $hg = Haplogroup::firstOrNew(['type' => 'Mito', 'letter' => 'U', 'subgroup' => '5a1a1d', 'ancestry' => 'European']);
        $data = array('type' => 'Mito', 'letter' => 'U', 'subgroup' => '5a1a1d', 'ancestry' => 'European', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$hg->exists) ? $hg->fill($data)->save() : $hg->fill(array_except($data, ['created_at']))->save();

        $hg = Haplogroup::firstOrNew(['type' => 'Mito', 'letter' => 'U', 'subgroup' => '5a2b3', 'ancestry' => 'European']);
        $data = array('type' => 'Mito', 'letter' => 'U', 'subgroup' => '5a2b3', 'ancestry' => 'European', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$hg->exists) ? $hg->fill($data)->save() : $hg->fill(array_except($data, ['created_at']))->save();

        $hg = Haplogroup::firstOrNew(['type' => 'Mito', 'letter' => 'U', 'subgroup' => '5b', 'ancestry' => 'European']);
        $data = array('type' => 'Mito', 'letter' => 'U', 'subgroup' => '5b', 'ancestry' => 'European', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$hg->exists) ? $hg->fill($data)->save() : $hg->fill(array_except($data, ['created_at']))->save();

        $hg = Haplogroup::firstOrNew(['type' => 'Mito', 'letter' => 'U', 'subgroup' => '5b2a1a1', 'ancestry' => 'European']);
        $data = array('type' => 'Mito', 'letter' => 'U', 'subgroup' => '5b2a1a1', 'ancestry' => 'European', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$hg->exists) ? $hg->fill($data)->save() : $hg->fill(array_except($data, ['created_at']))->save();

        $hg = Haplogroup::firstOrNew(['type' => 'Mito', 'letter' => 'U', 'subgroup' => '2e', 'ancestry' => 'Westeurasian/European']);
        $data = array('type' => 'Mito', 'letter' => 'U', 'subgroup' => '2e', 'ancestry' => 'Westeurasian/European', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$hg->exists) ? $hg->fill($data)->save() : $hg->fill(array_except($data, ['created_at']))->save();

        $hg = Haplogroup::firstOrNew(['type' => 'Mito', 'letter' => 'U', 'subgroup' => '2e1f1', 'ancestry' => 'European']);
        $data = array('type' => 'Mito', 'letter' => 'U', 'subgroup' => '2e1f1', 'ancestry' => 'European', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$hg->exists) ? $hg->fill($data)->save() : $hg->fill(array_except($data, ['created_at']))->save();

        $hg = Haplogroup::firstOrNew(['type' => 'Mito', 'letter' => 'U', 'subgroup' => '4', 'ancestry' => 'European']);
        $data = array('type' => 'Mito', 'letter' => 'U', 'subgroup' => '4', 'ancestry' => 'European', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$hg->exists) ? $hg->fill($data)->save() : $hg->fill(array_except($data, ['created_at']))->save();

        $hg = Haplogroup::firstOrNew(['type' => 'Mito', 'letter' => 'U', 'subgroup' => '4a2d', 'ancestry' => 'European']);
        $data = array('type' => 'Mito', 'letter' => 'U', 'subgroup' => '4a2d', 'ancestry' => 'European', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$hg->exists) ? $hg->fill($data)->save() : $hg->fill(array_except($data, ['created_at']))->save();

        $hg = Haplogroup::firstOrNew(['type' => 'Mito', 'letter' => 'U', 'subgroup' => '5a1b1', 'ancestry' => 'European']);
        $data = array('type' => 'Mito', 'letter' => 'U', 'subgroup' => '5a1b1', 'ancestry' => 'European', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$hg->exists) ? $hg->fill($data)->save() : $hg->fill(array_except($data, ['created_at']))->save();

        $hg = Haplogroup::firstOrNew(['type' => 'Mito', 'letter' => 'U', 'subgroup' => '5a1d2a', 'ancestry' => 'European']);
        $data = array('type' => 'Mito', 'letter' => 'U', 'subgroup' => '5a1d2a', 'ancestry' => 'European', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$hg->exists) ? $hg->fill($data)->save() : $hg->fill(array_except($data, ['created_at']))->save();

        $hg = Haplogroup::firstOrNew(['type' => 'Mito', 'letter' => 'U', 'subgroup' => '5b1b2', 'ancestry' => 'European']);
        $data = array('type' => 'Mito', 'letter' => 'U', 'subgroup' => '5b1b2', 'ancestry' => 'European', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$hg->exists) ? $hg->fill($data)->save() : $hg->fill(array_except($data, ['created_at']))->save();

        $hg = Haplogroup::firstOrNew(['type' => 'Mito', 'letter' => 'U', 'subgroup' => '5b1c1', 'ancestry' => 'European']);
        $data = array('type' => 'Mito', 'letter' => 'U', 'subgroup' => '5b1c1', 'ancestry' => 'European', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$hg->exists) ? $hg->fill($data)->save() : $hg->fill(array_except($data, ['created_at']))->save();

        $hg = Haplogroup::firstOrNew(['type' => 'Mito', 'letter' => 'U', 'subgroup' => '6a', 'ancestry' => 'European']);
        $data = array('type' => 'Mito', 'letter' => 'U', 'subgroup' => '6a', 'ancestry' => 'European', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$hg->exists) ? $hg->fill($data)->save() : $hg->fill(array_except($data, ['created_at']))->save();

        $hg = Haplogroup::firstOrNew(['type' => 'Mito', 'letter' => 'V', 'subgroup' => '1a1a1', 'ancestry' => 'European']);
        $data = array('type' => 'Mito', 'letter' => 'V', 'subgroup' => '1a1a1', 'ancestry' => 'European', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$hg->exists) ? $hg->fill($data)->save() : $hg->fill(array_except($data, ['created_at']))->save();

        $hg = Haplogroup::firstOrNew(['type' => 'Mito', 'letter' => 'V', 'subgroup' => '3c', 'ancestry' => 'European']);
        $data = array('type' => 'Mito', 'letter' => 'V', 'subgroup' => '3c', 'ancestry' => 'European', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$hg->exists) ? $hg->fill($data)->save() : $hg->fill(array_except($data, ['created_at']))->save();

        $hg = Haplogroup::firstOrNew(['type' => 'Mito', 'letter' => 'W', 'subgroup' => '9', 'ancestry' => 'European']);
        $data = array('type' => 'Mito', 'letter' => 'W', 'subgroup' => '9', 'ancestry' => 'European', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$hg->exists) ? $hg->fill($data)->save() : $hg->fill(array_except($data, ['created_at']))->save();

        $hg = Haplogroup::firstOrNew(['type' => 'Mito', 'letter' => 'W', 'subgroup' => '1e1a', 'ancestry' => 'European']);
        $data = array('type' => 'Mito', 'letter' => 'W', 'subgroup' => '1e1a', 'ancestry' => 'European', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$hg->exists) ? $hg->fill($data)->save() : $hg->fill(array_except($data, ['created_at']))->save();

        $hg = Haplogroup::firstOrNew(['type' => 'Mito', 'letter' => 'W', 'subgroup' => '4a1', 'ancestry' => 'European']);
        $data = array('type' => 'Mito', 'letter' => 'W', 'subgroup' => '4a1', 'ancestry' => 'European', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$hg->exists) ? $hg->fill($data)->save() : $hg->fill(array_except($data, ['created_at']))->save();

        $hg = Haplogroup::firstOrNew(['type' => 'Mito', 'letter' => 'W', 'subgroup' => '6a', 'ancestry' => 'European']);
        $data = array('type' => 'Mito', 'letter' => 'W', 'subgroup' => '6a', 'ancestry' => 'European', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$hg->exists) ? $hg->fill($data)->save() : $hg->fill(array_except($data, ['created_at']))->save();

        $hg = Haplogroup::firstOrNew(['type' => 'Mito', 'letter' => 'X', 'subgroup' => '2', 'ancestry' => 'European']);
        $data = array('type' => 'Mito', 'letter' => 'X', 'subgroup' => '2', 'ancestry' => 'European', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$hg->exists) ? $hg->fill($data)->save() : $hg->fill(array_except($data, ['created_at']))->save();

        $hg = Haplogroup::firstOrNew(['type' => 'Mito', 'letter' => 'X', 'subgroup' => '2b', 'ancestry' => 'European']);
        $data = array('type' => 'Mito', 'letter' => 'X', 'subgroup' => '2b', 'ancestry' => 'European', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$hg->exists) ? $hg->fill($data)->save() : $hg->fill(array_except($data, ['created_at']))->save();

        $hg = Haplogroup::firstOrNew(['type' => 'Mito', 'letter' => 'X', 'subgroup' => '2c1c1', 'ancestry' => 'European']);
        $data = array('type' => 'Mito', 'letter' => 'X', 'subgroup' => '2c1c1', 'ancestry' => 'European', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$hg->exists) ? $hg->fill($data)->save() : $hg->fill(array_except($data, ['created_at']))->save();

        $hg = Haplogroup::firstOrNew(['type' => 'Mito', 'letter' => 'X', 'subgroup' => '2e2b', 'ancestry' => 'European']);
        $data = array('type' => 'Mito', 'letter' => 'X', 'subgroup' => '2e2b', 'ancestry' => 'European', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$hg->exists) ? $hg->fill($data)->save() : $hg->fill(array_except($data, ['created_at']))->save();

        $hg = Haplogroup::firstOrNew(['type' => 'Mito', 'letter' => 'X', 'subgroup' => '2i', 'ancestry' => 'European']);
        $data = array('type' => 'Mito', 'letter' => 'X', 'subgroup' => '2i', 'ancestry' => 'European', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$hg->exists) ? $hg->fill($data)->save() : $hg->fill(array_except($data, ['created_at']))->save();

        $hg = Haplogroup::firstOrNew(['type' => 'Mito', 'letter' => 'Y', 'subgroup' => '1', 'ancestry' => 'Asian']);
        $data = array('type' => 'Mito', 'letter' => 'Y', 'subgroup' => '1', 'ancestry' => 'Asian', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$hg->exists) ? $hg->fill($data)->save() : $hg->fill(array_except($data, ['created_at']))->save();

        $hg = Haplogroup::firstOrNew(['type' => 'Mito', 'letter' => 'Z', 'subgroup' => '', 'ancestry' => 'Asian']);
        $data = array('type' => 'Mito', 'letter' => 'Z', 'subgroup' => '', 'ancestry' => 'Asian', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$hg->exists) ? $hg->fill($data)->save() : $hg->fill(array_except($data, ['created_at']))->save();
    }
}