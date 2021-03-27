<?php
/**
 * Trauma Seeder
 *
 * @category   Trauma
 * @package    Seeder
 * @author     Sachin Pawaskar<spawaskar@unomaha.edu>
 * @copyright  2016-2018
 * @license    The MIT License (MIT)
 * @version    GIT: $Id$
 * @since      File available since Release 1.0.0
 */

use Illuminate\Database\Seeder;
use App\Trauma;

class TraumasTableSeeder extends Seeder {

    public function run()
    {
        $dt = date_create();
        $sys = 'System';

        // Trauma - Antemortem
        $trauma = Trauma::firstOrNew(['timing' => 'Antemortem', 'type' => '']);
        $data = array('timing' => 'Antemortem', 'type' => '', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$trauma->exists) ? $trauma->fill($data)->save() : $trauma->fill(array_except($data, ['created_at']))->save();

        $trauma = Trauma::firstOrNew(['timing' => 'Antemortem', 'type' => 'Blunt force']);
        $data = array('timing' => 'Antemortem', 'type' => 'Blunt force', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$trauma->exists) ? $trauma->fill($data)->save() : $trauma->fill(array_except($data, ['created_at']))->save();

        $trauma = Trauma::firstOrNew(['timing' => 'Antemortem', 'type' => 'Projectile']);
        $data = array('timing' => 'Antemortem', 'type' => 'Projectile', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$trauma->exists) ? $trauma->fill($data)->save() : $trauma->fill(array_except($data, ['created_at']))->save();

        $trauma = Trauma::firstOrNew(['timing' => 'Antemortem', 'type' => 'Sharp force']);
        $data = array('timing' => 'Antemortem', 'type' => 'Sharp force', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$trauma->exists) ? $trauma->fill($data)->save() : $trauma->fill(array_except($data, ['created_at']))->save();

        $trauma = Trauma::firstOrNew(['timing' => 'Antemortem', 'type' => 'Treatment']);
        $data = array('timing' => 'Antemortem', 'type' => 'Treatment', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$trauma->exists) ? $trauma->fill($data)->save() : $trauma->fill(array_except($data, ['created_at']))->save();

        // Trauma - Perimortem
        $trauma = Trauma::firstOrNew(['timing' => 'Perimortem', 'type' => '']);
        $data = array('timing' => 'Perimortem', 'type' => '', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$trauma->exists) ? $trauma->fill($data)->save() : $trauma->fill(array_except($data, ['created_at']))->save();

        $trauma = Trauma::firstOrNew(['timing' => 'Perimortem', 'type' => 'Blunt force']);
        $data = array('timing' => 'Perimortem', 'type' => 'Blunt force', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$trauma->exists) ? $trauma->fill($data)->save() : $trauma->fill(array_except($data, ['created_at']))->save();

        $trauma = Trauma::firstOrNew(['timing' => 'Perimortem', 'type' => 'Projectile']);
        $data = array('timing' => 'Perimortem', 'type' => 'Projectile', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$trauma->exists) ? $trauma->fill($data)->save() : $trauma->fill(array_except($data, ['created_at']))->save();

        $trauma = Trauma::firstOrNew(['timing' => 'Perimortem', 'type' => 'Sharp force']);
        $data = array('timing' => 'Perimortem', 'type' => 'Sharp force', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$trauma->exists) ? $trauma->fill($data)->save() : $trauma->fill(array_except($data, ['created_at']))->save();

        // New Possible Trauma seed data - Antemorten
        $trauma = Trauma::firstOrNew(['timing' => 'Possible antemortem', 'type' => '']);
        $data = array('timing' => 'Possible antemortem', 'type' => '', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$trauma->exists) ? $trauma->fill($data)->save() : $trauma->fill(array_except($data, ['created_at']))->save();

        $trauma = Trauma::firstOrNew(['timing' => 'Possible antemortem', 'type' => 'Blunt force']);
        $data = array('timing' => 'Possible antemortem', 'type' => 'Blunt force', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$trauma->exists) ? $trauma->fill($data)->save() : $trauma->fill(array_except($data, ['created_at']))->save();

        $trauma = Trauma::firstOrNew(['timing' => 'Possible antemortem', 'type' => 'Projectile']);
        $data = array('timing' => 'Possible antemortem', 'type' => 'Projectile', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$trauma->exists) ? $trauma->fill($data)->save() : $trauma->fill(array_except($data, ['created_at']))->save();

        $trauma = Trauma::firstOrNew(['timing' => 'Possible antemortem', 'type' => 'Sharp force']);
        $data = array('timing' => 'Possible antemortem', 'type' => 'Sharp force', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$trauma->exists) ? $trauma->fill($data)->save() : $trauma->fill(array_except($data, ['created_at']))->save();

        $trauma = Trauma::firstOrNew(['timing' => 'Possible antemortem', 'type' => 'Treatment']);
        $data = array('timing' => 'Possible antemortem', 'type' => 'Treatment', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$trauma->exists) ? $trauma->fill($data)->save() : $trauma->fill(array_except($data, ['created_at']))->save();

        // New Possible Trauma seed data - Perimortem
        $trauma = Trauma::firstOrNew(['timing' => 'Possible perimortem', 'type' => '']);
        $data = array('timing' => 'Possible perimortem', 'type' => '', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$trauma->exists) ? $trauma->fill($data)->save() : $trauma->fill(array_except($data, ['created_at']))->save();

        $trauma = Trauma::firstOrNew(['timing' => 'Possible perimortem', 'type' => 'Blunt force']);
        $data = array('timing' => 'Possible perimortem', 'type' => 'Blunt force', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$trauma->exists) ? $trauma->fill($data)->save() : $trauma->fill(array_except($data, ['created_at']))->save();

        $trauma = Trauma::firstOrNew(['timing' => 'Possible perimortem', 'type' => 'Projectile']);
        $data = array('timing' => 'Possible perimortem', 'type' => 'Projectile', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$trauma->exists) ? $trauma->fill($data)->save() : $trauma->fill(array_except($data, ['created_at']))->save();

        $trauma = Trauma::firstOrNew(['timing' => 'Possible perimortem', 'type' => 'Sharp force']);
        $data = array('timing' => 'Possible perimortem', 'type' => 'Sharp force', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$trauma->exists) ? $trauma->fill($data)->save() : $trauma->fill(array_except($data, ['created_at']))->save();
    }
}