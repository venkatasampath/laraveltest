<?php
/**
 * Pathology Seeder
 *
 * @category   Pathology
 * @package    Seeder
 * @author     Sachin Pawaskar<spawaskar@unomaha.edu>
 * @copyright  2016-2018
 * @license    The MIT License (MIT)
 * @version    GIT: $Id$
 * @since      File available since Release 1.0.0
 */


use Illuminate\Database\Seeder;
use App\Pathology;

class PathologysTableSeeder extends Seeder {

    public function run()
    {
        $dt = date_create();
        $sys = 'System';

        $pathology = Pathology::firstOrNew(['abnormality_category' => 'Density', 'characteristics' => '']);
        $data = array('abnormality_category' => 'Density', 'characteristics' => '', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$pathology->exists) ? $pathology->fill($data)->save() : $pathology->fill(array_except($data, ['created_at']))->save();

        $pathology = Pathology::firstOrNew(['abnormality_category' => 'Density', 'characteristics' => 'Osteoporosis']);
        $data = array('abnormality_category' => 'Density', 'characteristics' => 'Osteoporosis', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$pathology->exists) ? $pathology->fill($data)->save() : $pathology->fill(array_except($data, ['created_at']))->save();

        $pathology = Pathology::firstOrNew(['abnormality_category' => 'Deformative', 'characteristics' => '']);
        $data = array('abnormality_category' => 'Deformative', 'characteristics' => '', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$pathology->exists) ? $pathology->fill($data)->save() : $pathology->fill(array_except($data, ['created_at']))->save();

        $pathology = Pathology::firstOrNew(['abnormality_category' => 'Deformative', 'characteristics' => 'Cribra orbitalia']);
        $data = array('abnormality_category' => 'Deformative', 'characteristics' => 'Cribra orbitalia', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$pathology->exists) ? $pathology->fill($data)->save() : $pathology->fill(array_except($data, ['created_at']))->save();

        $pathology = Pathology::firstOrNew(['abnormality_category' => 'Deformative', 'characteristics' => 'Osteomyelitis']);
        $data = array('abnormality_category' => 'Deformative', 'characteristics' => 'Osteomyelitis', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$pathology->exists) ? $pathology->fill($data)->save() : $pathology->fill(array_except($data, ['created_at']))->save();

        $pathology = Pathology::firstOrNew(['abnormality_category' => 'Deformative', 'characteristics' => 'Porotic hyperostosis']);
        $data = array('abnormality_category' => 'Deformative', 'characteristics' => 'Porotic hyperostosis', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$pathology->exists) ? $pathology->fill($data)->save() : $pathology->fill(array_except($data, ['created_at']))->save();

        $pathology = Pathology::firstOrNew(['abnormality_category' => 'Lytic', 'characteristics' => '']);
        $data = array('abnormality_category' => 'Lytic', 'characteristics' => '', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$pathology->exists) ? $pathology->fill($data)->save() : $pathology->fill(array_except($data, ['created_at']))->save();

        $pathology = Pathology::firstOrNew(['abnormality_category' => 'Lytic', 'characteristics' => 'Abscess']);
        $data = array('abnormality_category' => 'Lytic', 'characteristics' => 'Abscess', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$pathology->exists) ? $pathology->fill($data)->save() : $pathology->fill(array_except($data, ['created_at']))->save();

        $pathology = Pathology::firstOrNew(['abnormality_category' => 'Lytic', 'characteristics' => 'Cloaca']);
        $data = array('abnormality_category' => 'Lytic', 'characteristics' => 'Cloaca', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$pathology->exists) ? $pathology->fill($data)->save() : $pathology->fill(array_except($data, ['created_at']))->save();

        $pathology = Pathology::firstOrNew(['abnormality_category' => 'Lytic', 'characteristics' => 'Schmorls node']);
        $data = array('abnormality_category' => 'Lytic', 'characteristics' => 'Schmorls node', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$pathology->exists) ? $pathology->fill($data)->save() : $pathology->fill(array_except($data, ['created_at']))->save();

        $pathology = Pathology::firstOrNew(['abnormality_category' => 'Morphology', 'characteristics' => '']);
        $data = array('abnormality_category' => 'Morphology', 'characteristics' => '', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$pathology->exists) ? $pathology->fill($data)->save() : $pathology->fill(array_except($data, ['created_at']))->save();

        $pathology = Pathology::firstOrNew(['abnormality_category' => 'Morphology', 'characteristics' => 'Atrophy']);
        $data = array('abnormality_category' => 'Morphology', 'characteristics' => 'Atrophy', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$pathology->exists) ? $pathology->fill($data)->save() : $pathology->fill(array_except($data, ['created_at']))->save();

        $pathology = Pathology::firstOrNew(['abnormality_category' => 'Morphology', 'characteristics' => 'Cleft']);
        $data = array('abnormality_category' => 'Morphology', 'characteristics' => 'Cleft', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$pathology->exists) ? $pathology->fill($data)->save() : $pathology->fill(array_except($data, ['created_at']))->save();

        $pathology = Pathology::firstOrNew(['abnormality_category' => 'Morphology', 'characteristics' => 'Eburnation']);
        $data = array('abnormality_category' => 'Morphology', 'characteristics' => 'Eburnation', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$pathology->exists) ? $pathology->fill($data)->save() : $pathology->fill(array_except($data, ['created_at']))->save();

        $pathology = Pathology::firstOrNew(['abnormality_category' => 'Morphology', 'characteristics' => 'Kyphosis']);
        $data = array('abnormality_category' => 'Morphology', 'characteristics' => 'Kyphosis', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$pathology->exists) ? $pathology->fill($data)->save() : $pathology->fill(array_except($data, ['created_at']))->save();

        $pathology = Pathology::firstOrNew(['abnormality_category' => 'Morphology', 'characteristics' => 'Pseudoarthrosis']);
        $data = array('abnormality_category' => 'Morphology', 'characteristics' => 'Pseudoarthrosis', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$pathology->exists) ? $pathology->fill($data)->save() : $pathology->fill(array_except($data, ['created_at']))->save();

        $pathology = Pathology::firstOrNew(['abnormality_category' => 'Morphology', 'characteristics' => 'Scoliosis']);
        $data = array('abnormality_category' => 'Morphology', 'characteristics' => 'Scoliosis', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$pathology->exists) ? $pathology->fill($data)->save() : $pathology->fill(array_except($data, ['created_at']))->save();

        $pathology = Pathology::firstOrNew(['abnormality_category' => 'Morphology', 'characteristics' => 'Spina bifida']);
        $data = array('abnormality_category' => 'Morphology', 'characteristics' => 'Spina bifida', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$pathology->exists) ? $pathology->fill($data)->save() : $pathology->fill(array_except($data, ['created_at']))->save();

        $pathology = Pathology::firstOrNew(['abnormality_category' => 'Morphology', 'characteristics' => 'Spondylolysis']);
        $data = array('abnormality_category' => 'Morphology', 'characteristics' => 'Spondylolysis', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$pathology->exists) ? $pathology->fill($data)->save() : $pathology->fill(array_except($data, ['created_at']))->save();

        $pathology = Pathology::firstOrNew(['abnormality_category' => 'Proliferative', 'characteristics' => '']);
        $data = array('abnormality_category' => 'Proliferative', 'characteristics' => '', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$pathology->exists) ? $pathology->fill($data)->save() : $pathology->fill(array_except($data, ['created_at']))->save();

        $pathology = Pathology::firstOrNew(['abnormality_category' => 'Proliferative', 'characteristics' => 'Ankylosis']);
        $data = array('abnormality_category' => 'Proliferative', 'characteristics' => 'Ankylosis', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$pathology->exists) ? $pathology->fill($data)->save() : $pathology->fill(array_except($data, ['created_at']))->save();

        $pathology = Pathology::firstOrNew(['abnormality_category' => 'Proliferative', 'characteristics' => 'Enthesis']);
        $data = array('abnormality_category' => 'Proliferative', 'characteristics' => 'Enthesis', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$pathology->exists) ? $pathology->fill($data)->save() : $pathology->fill(array_except($data, ['created_at']))->save();

        $pathology = Pathology::firstOrNew(['abnormality_category' => 'Proliferative', 'characteristics' => 'Lipping']);
        $data = array('abnormality_category' => 'Proliferative', 'characteristics' => 'Lipping', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$pathology->exists) ? $pathology->fill($data)->save() : $pathology->fill(array_except($data, ['created_at']))->save();

        $pathology = Pathology::firstOrNew(['abnormality_category' => 'Proliferative', 'characteristics' => 'Osteophyte']);
        $data = array('abnormality_category' => 'Proliferative', 'characteristics' => 'Osteophyte', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$pathology->exists) ? $pathology->fill($data)->save() : $pathology->fill(array_except($data, ['created_at']))->save();

        $pathology = Pathology::firstOrNew(['abnormality_category' => 'Proliferative', 'characteristics' => 'Periostitis']);
        $data = array('abnormality_category' => 'Proliferative', 'characteristics' => 'Periostitis', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$pathology->exists) ? $pathology->fill($data)->save() : $pathology->fill(array_except($data, ['created_at']))->save();
    }
}