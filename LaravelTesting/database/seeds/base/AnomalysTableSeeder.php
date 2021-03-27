<?php
/**
 * Anomaly Seeder
 *
 * @category   Anomaly
 * @package    Seeder
 * @author     Sachin Pawaskar<spawaskar@unomaha.edu>
 * @copyright  2016-2018
 * @license    The MIT License (MIT)
 * @version    GIT: $Id$
 * @since      File available since Release 1.0.0
 */

use Illuminate\Database\Seeder;
use App\SkeletalBone;
use App\Anomaly;

class AnomalysTableSeeder extends Seeder {

    public function run()
    {
        $dt = date_create();
        $sys = 'System';

        $sb_id = SkeletalBone::where('name', '=', 'Calcaneus')->first()->id;
        $anomaly = Anomaly::firstOrNew(['sb_id' => $sb_id, 'individuating_trait' =>'Anterior facet double']);
        $data = array('sb_id' => $sb_id, 'individuating_trait' =>'Anterior facet double', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$anomaly->exists) ? $anomaly->fill($data)->save() : $anomaly->fill(array_except($data, ['created_at']))->save();

        $anomaly = Anomaly::firstOrNew(['sb_id' => $sb_id, 'individuating_trait' =>'Shape of talar articular surface']);
        $data = array('sb_id' => $sb_id, 'individuating_trait' =>'Shape of talar articular surface', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$anomaly->exists) ? $anomaly->fill($data)->save() : $anomaly->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name', '=', 'Cervical vertebra 1')->first()->id;
        $anomaly = Anomaly::firstOrNew(['sb_id' => $sb_id, 'individuating_trait' =>'Bifurcate foramen transversarium']);
        $data = array('sb_id' => $sb_id, 'individuating_trait' =>'Bifurcate foramen transversarium', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$anomaly->exists) ? $anomaly->fill($data)->save() : $anomaly->fill(array_except($data, ['created_at']))->save();

        $anomaly = Anomaly::firstOrNew(['sb_id' => $sb_id, 'individuating_trait' =>'Incomplete foramen transversarium']);
        $data = array('sb_id' => $sb_id, 'individuating_trait' =>'Incomplete foramen transversarium', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$anomaly->exists) ? $anomaly->fill($data)->save() : $anomaly->fill(array_except($data, ['created_at']))->save();

        $anomaly = Anomaly::firstOrNew(['sb_id' => $sb_id, 'individuating_trait' =>'Retroarticular bridge']);
        $data = array('sb_id' => $sb_id, 'individuating_trait' =>'Retroarticular bridge', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$anomaly->exists) ? $anomaly->fill($data)->save() : $anomaly->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name', '=', 'Cervical vertebra 2')->first()->id;
        $anomaly = Anomaly::firstOrNew(['sb_id' => $sb_id, 'individuating_trait' =>'Bifurcate foramen transversarium']);
        $data = array('sb_id' => $sb_id, 'individuating_trait' =>'Bifurcate foramen transversarium', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$anomaly->exists) ? $anomaly->fill($data)->save() : $anomaly->fill(array_except($data, ['created_at']))->save();

        $anomaly = Anomaly::firstOrNew(['sb_id' => $sb_id, 'individuating_trait' =>'Open foramen transversarium']);
        $data = array('sb_id' => $sb_id, 'individuating_trait' =>'Open foramen transversarium', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$anomaly->exists) ? $anomaly->fill($data)->save() : $anomaly->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name', '=', 'Cervical vertebra 3')->first()->id;
        $anomaly = Anomaly::firstOrNew(['sb_id' => $sb_id, 'individuating_trait' =>'Accessory transverse foramen']);
        $data = array('sb_id' => $sb_id, 'individuating_trait' =>'Accessory transverse foramen', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$anomaly->exists) ? $anomaly->fill($data)->save() : $anomaly->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name', '=', 'Cervical vertebra 4')->first()->id;
        $anomaly = Anomaly::firstOrNew(['sb_id' => $sb_id, 'individuating_trait' =>'Accessory transverse foramen']);
        $data = array('sb_id' => $sb_id, 'individuating_trait' =>'Accessory transverse foramen', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$anomaly->exists) ? $anomaly->fill($data)->save() : $anomaly->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name', '=', 'Cervical vertebra 5')->first()->id;
        $anomaly = Anomaly::firstOrNew(['sb_id' => $sb_id, 'individuating_trait' =>'Accessory transverse foramen']);
        $data = array('sb_id' => $sb_id, 'individuating_trait' =>'Accessory transverse foramen', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$anomaly->exists) ? $anomaly->fill($data)->save() : $anomaly->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name', '=', 'Cervical vertebra 6')->first()->id;
        $anomaly = Anomaly::firstOrNew(['sb_id' => $sb_id, 'individuating_trait' =>'Accessory transverse foramen']);
        $data = array('sb_id' => $sb_id, 'individuating_trait' =>'Accessory transverse foramen', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$anomaly->exists) ? $anomaly->fill($data)->save() : $anomaly->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name', '=', 'Cervical vertebra 7')->first()->id;
        $anomaly = Anomaly::firstOrNew(['sb_id' => $sb_id, 'individuating_trait' =>'Accessory transverse foramen']);
        $data = array('sb_id' => $sb_id, 'individuating_trait' =>'Accessory transverse foramen', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$anomaly->exists) ? $anomaly->fill($data)->save() : $anomaly->fill(array_except($data, ['created_at']))->save();

        $anomaly = Anomaly::firstOrNew(['sb_id' => $sb_id, 'individuating_trait' =>'Vertebral shift']);
        $data = array('sb_id' => $sb_id, 'individuating_trait' =>'Vertebral shift', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$anomaly->exists) ? $anomaly->fill($data)->save() : $anomaly->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name', '=', 'Clavicle')->first()->id;
        $anomaly = Anomaly::firstOrNew(['sb_id' => $sb_id, 'individuating_trait' =>'Rhomboid fossa']);
        $data = array('sb_id' => $sb_id, 'individuating_trait' =>'Rhomboid fossa', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$anomaly->exists) ? $anomaly->fill($data)->save() : $anomaly->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name', '=', 'Cranium')->first()->id;
        $anomaly = Anomaly::firstOrNew(['sb_id' => $sb_id, 'individuating_trait' =>'Accessory infra-orbital foramen']);
        $data = array('sb_id' => $sb_id, 'individuating_trait' =>'Accessory infra-orbital foramen', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$anomaly->exists) ? $anomaly->fill($data)->save() : $anomaly->fill(array_except($data, ['created_at']))->save();

        $anomaly = Anomaly::firstOrNew(['sb_id' => $sb_id, 'individuating_trait' =>'Accessory lesser palatine foramen']);
        $data = array('sb_id' => $sb_id, 'individuating_trait' =>'Accessory lesser palatine foramen', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$anomaly->exists) ? $anomaly->fill($data)->save() : $anomaly->fill(array_except($data, ['created_at']))->save();

        $anomaly = Anomaly::firstOrNew(['sb_id' => $sb_id, 'individuating_trait' =>'Anterior ethmoid foramen']);
        $data = array('sb_id' => $sb_id, 'individuating_trait' =>'Anterior ethmoid foramen', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$anomaly->exists) ? $anomaly->fill($data)->save() : $anomaly->fill(array_except($data, ['created_at']))->save();

        $anomaly = Anomaly::firstOrNew(['sb_id' => $sb_id, 'individuating_trait' =>'Asterion ossicle']);
        $data = array('sb_id' => $sb_id, 'individuating_trait' =>'Asterion ossicle', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$anomaly->exists) ? $anomaly->fill($data)->save() : $anomaly->fill(array_except($data, ['created_at']))->save();

        $anomaly = Anomaly::firstOrNew(['sb_id' => $sb_id, 'individuating_trait' =>'Auditory torus']);
        $data = array('sb_id' => $sb_id, 'individuating_trait' =>'Auditory torus', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$anomaly->exists) ? $anomaly->fill($data)->save() : $anomaly->fill(array_except($data, ['created_at']))->save();

        $anomaly = Anomaly::firstOrNew(['sb_id' => $sb_id, 'individuating_trait' =>'Bregmatic bone']);
        $data = array('sb_id' => $sb_id, 'individuating_trait' =>'Bregmatic bone', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$anomaly->exists) ? $anomaly->fill($data)->save() : $anomaly->fill(array_except($data, ['created_at']))->save();

        $anomaly = Anomaly::firstOrNew(['sb_id' => $sb_id, 'individuating_trait' =>'Condylar facet']);
        $data = array('sb_id' => $sb_id, 'individuating_trait' =>'Condylar facet', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$anomaly->exists) ? $anomaly->fill($data)->save() : $anomaly->fill(array_except($data, ['created_at']))->save();

        $anomaly = Anomaly::firstOrNew(['sb_id' => $sb_id, 'individuating_trait' =>'Coronal ossicle']);
        $data = array('sb_id' => $sb_id, 'individuating_trait' =>'Coronal ossicle', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$anomaly->exists) ? $anomaly->fill($data)->save() : $anomaly->fill(array_except($data, ['created_at']))->save();

        $anomaly = Anomaly::firstOrNew(['sb_id' => $sb_id, 'individuating_trait' =>'Deviated nasal septum']);
        $data = array('sb_id' => $sb_id, 'individuating_trait' =>'Deviated nasal septum', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$anomaly->exists) ? $anomaly->fill($data)->save() : $anomaly->fill(array_except($data, ['created_at']))->save();

        $anomaly = Anomaly::firstOrNew(['sb_id' => $sb_id, 'individuating_trait' =>'Epipteric bone']);
        $data = array('sb_id' => $sb_id, 'individuating_trait' =>'Epipteric bone', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$anomaly->exists) ? $anomaly->fill($data)->save() : $anomaly->fill(array_except($data, ['created_at']))->save();

        $anomaly = Anomaly::firstOrNew(['sb_id' => $sb_id, 'individuating_trait' =>'Foramen ovale incomplete']);
        $data = array('sb_id' => $sb_id, 'individuating_trait' =>'Foramen ovale incomplete', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$anomaly->exists) ? $anomaly->fill($data)->save() : $anomaly->fill(array_except($data, ['created_at']))->save();

        $anomaly = Anomaly::firstOrNew(['sb_id' => $sb_id, 'individuating_trait' =>'Foramen of Huschke']);
        $data = array('sb_id' => $sb_id, 'individuating_trait' =>'Foramen of Huschke', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$anomaly->exists) ? $anomaly->fill($data)->save() : $anomaly->fill(array_except($data, ['created_at']))->save();

        $anomaly = Anomaly::firstOrNew(['sb_id' => $sb_id, 'individuating_trait' =>'Foramen spinosum open']);
        $data = array('sb_id' => $sb_id, 'individuating_trait' =>'Foramen spinosum open', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$anomaly->exists) ? $anomaly->fill($data)->save() : $anomaly->fill(array_except($data, ['created_at']))->save();

        $anomaly = Anomaly::firstOrNew(['sb_id' => $sb_id, 'individuating_trait' =>'Frontal foramen']);
        $data = array('sb_id' => $sb_id, 'individuating_trait' =>'Frontal foramen', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$anomaly->exists) ? $anomaly->fill($data)->save() : $anomaly->fill(array_except($data, ['created_at']))->save();

        $anomaly = Anomaly::firstOrNew(['sb_id' => $sb_id, 'individuating_trait' =>'Fronto-temporal articulation']);
        $data = array('sb_id' => $sb_id, 'individuating_trait' =>'Fronto-temporal articulation', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$anomaly->exists) ? $anomaly->fill($data)->save() : $anomaly->fill(array_except($data, ['created_at']))->save();

        $anomaly = Anomaly::firstOrNew(['sb_id' => $sb_id, 'individuating_trait' =>'Lambda ossicle']);
        $data = array('sb_id' => $sb_id, 'individuating_trait' =>'Lambda ossicle', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$anomaly->exists) ? $anomaly->fill($data)->save() : $anomaly->fill(array_except($data, ['created_at']))->save();

        $anomaly = Anomaly::firstOrNew(['sb_id' => $sb_id, 'individuating_trait' =>'Lambdoidal suture ossicle']);
        $data = array('sb_id' => $sb_id, 'individuating_trait' =>'Lambdoidal suture ossicle', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$anomaly->exists) ? $anomaly->fill($data)->save() : $anomaly->fill(array_except($data, ['created_at']))->save();

        $anomaly = Anomaly::firstOrNew(['sb_id' => $sb_id, 'individuating_trait' =>'Mastoid foramen exsutural']);
        $data = array('sb_id' => $sb_id, 'individuating_trait' =>'Mastoid foramen exsutural', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$anomaly->exists) ? $anomaly->fill($data)->save() : $anomaly->fill(array_except($data, ['created_at']))->save();

        $anomaly = Anomaly::firstOrNew(['sb_id' => $sb_id, 'individuating_trait' =>'Maxillary torus']);
        $data = array('sb_id' => $sb_id, 'individuating_trait' =>'Maxillary torus', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$anomaly->exists) ? $anomaly->fill($data)->save() : $anomaly->fill(array_except($data, ['created_at']))->save();

        $anomaly = Anomaly::firstOrNew(['sb_id' => $sb_id, 'individuating_trait' =>'Metopism']);
        $data = array('sb_id' => $sb_id, 'individuating_trait' =>'Metopism', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$anomaly->exists) ? $anomaly->fill($data)->save() : $anomaly->fill(array_except($data, ['created_at']))->save();

        $anomaly = Anomaly::firstOrNew(['sb_id' => $sb_id, 'individuating_trait' =>'Palatine torus']);
        $data = array('sb_id' => $sb_id, 'individuating_trait' =>'Palatine torus', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$anomaly->exists) ? $anomaly->fill($data)->save() : $anomaly->fill(array_except($data, ['created_at']))->save();

        $anomaly = Anomaly::firstOrNew(['sb_id' => $sb_id, 'individuating_trait' =>'Parietal foramen']);
        $data = array('sb_id' => $sb_id, 'individuating_trait' =>'Parietal foramen', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$anomaly->exists) ? $anomaly->fill($data)->save() : $anomaly->fill(array_except($data, ['created_at']))->save();

        $anomaly = Anomaly::firstOrNew(['sb_id' => $sb_id, 'individuating_trait' =>'Parietal notch']);
        $data = array('sb_id' => $sb_id, 'individuating_trait' =>'Parietal notch', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$anomaly->exists) ? $anomaly->fill($data)->save() : $anomaly->fill(array_except($data, ['created_at']))->save();

        $anomaly = Anomaly::firstOrNew(['sb_id' => $sb_id, 'individuating_trait' =>'Posterior condylar canal']);
        $data = array('sb_id' => $sb_id, 'individuating_trait' =>'Posterior condylar canal', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$anomaly->exists) ? $anomaly->fill($data)->save() : $anomaly->fill(array_except($data, ['created_at']))->save();

        $anomaly = Anomaly::firstOrNew(['sb_id' => $sb_id, 'individuating_trait' =>'Posterior ethmoid foramen']);
        $data = array('sb_id' => $sb_id, 'individuating_trait' =>'Posterior ethmoid foramen', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$anomaly->exists) ? $anomaly->fill($data)->save() : $anomaly->fill(array_except($data, ['created_at']))->save();

        $anomaly = Anomaly::firstOrNew(['sb_id' => $sb_id, 'individuating_trait' =>'Precondylar tubercle']);
        $data = array('sb_id' => $sb_id, 'individuating_trait' =>'Precondylar tubercle', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$anomaly->exists) ? $anomaly->fill($data)->save() : $anomaly->fill(array_except($data, ['created_at']))->save();

        $anomaly = Anomaly::firstOrNew(['sb_id' => $sb_id, 'individuating_trait' =>'Supra-orbital foramen']);
        $data = array('sb_id' => $sb_id, 'individuating_trait' =>'Supra-orbital foramen', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$anomaly->exists) ? $anomaly->fill($data)->save() : $anomaly->fill(array_except($data, ['created_at']))->save();

        $anomaly = Anomaly::firstOrNew(['sb_id' => $sb_id, 'individuating_trait' =>'Zygomatico-facial foramen']);
        $data = array('sb_id' => $sb_id, 'individuating_trait' =>'Zygomatico-facial foramen', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$anomaly->exists) ? $anomaly->fill($data)->save() : $anomaly->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name', '=', 'Ethmoid')->first()->id;
        $anomaly = Anomaly::firstOrNew(['sb_id' => $sb_id, 'individuating_trait' =>'Posterior ethmoid foramen']);
        $data = array('sb_id' => $sb_id, 'individuating_trait' =>'Posterior ethmoid foramen', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$anomaly->exists) ? $anomaly->fill($data)->save() : $anomaly->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name', '=', 'Femur')->first()->id;
        $anomaly = Anomaly::firstOrNew(['sb_id' => $sb_id, 'individuating_trait' =>'Allens fossa']);
        $data = array('sb_id' => $sb_id, 'individuating_trait' =>'Allens fossa', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$anomaly->exists) ? $anomaly->fill($data)->save() : $anomaly->fill(array_except($data, ['created_at']))->save();

        $anomaly = Anomaly::firstOrNew(['sb_id' => $sb_id, 'individuating_trait' =>'Poiriers facet']);
        $data = array('sb_id' => $sb_id, 'individuating_trait' =>'Poiriers facet', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$anomaly->exists) ? $anomaly->fill($data)->save() : $anomaly->fill(array_except($data, ['created_at']))->save();

        $anomaly = Anomaly::firstOrNew(['sb_id' => $sb_id, 'individuating_trait' =>'Third trochanter']);
        $data = array('sb_id' => $sb_id, 'individuating_trait' =>'Third trochanter', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$anomaly->exists) ? $anomaly->fill($data)->save() : $anomaly->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name', '=', 'Frontal')->first()->id;
        $anomaly = Anomaly::firstOrNew(['sb_id' => $sb_id, 'individuating_trait' =>'Anterior ethmoid foramen']);
        $data = array('sb_id' => $sb_id, 'individuating_trait' =>'Anterior ethmoid foramen', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$anomaly->exists) ? $anomaly->fill($data)->save() : $anomaly->fill(array_except($data, ['created_at']))->save();

        $anomaly = Anomaly::firstOrNew(['sb_id' => $sb_id, 'individuating_trait' =>'Frontal foramen']);
        $data = array('sb_id' => $sb_id, 'individuating_trait' =>'Frontal foramen', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$anomaly->exists) ? $anomaly->fill($data)->save() : $anomaly->fill(array_except($data, ['created_at']))->save();

        $anomaly = Anomaly::firstOrNew(['sb_id' => $sb_id, 'individuating_trait' =>'Metopism']);
        $data = array('sb_id' => $sb_id, 'individuating_trait' =>'Metopism', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$anomaly->exists) ? $anomaly->fill($data)->save() : $anomaly->fill(array_except($data, ['created_at']))->save();

        $anomaly = Anomaly::firstOrNew(['sb_id' => $sb_id, 'individuating_trait' =>'Supra-orbital foramen']);
        $data = array('sb_id' => $sb_id, 'individuating_trait' =>'Supra-orbital foramen', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$anomaly->exists) ? $anomaly->fill($data)->save() : $anomaly->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name', '=', 'Humerus')->first()->id;
        $anomaly = Anomaly::firstOrNew(['sb_id' => $sb_id, 'individuating_trait' =>'Septal aperture']);
        $data = array('sb_id' => $sb_id, 'individuating_trait' =>'Septal aperture', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$anomaly->exists) ? $anomaly->fill($data)->save() : $anomaly->fill(array_except($data, ['created_at']))->save();

        $anomaly = Anomaly::firstOrNew(['sb_id' => $sb_id, 'individuating_trait' =>'Supracondylar process']);
        $data = array('sb_id' => $sb_id, 'individuating_trait' =>'Supracondylar process', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$anomaly->exists) ? $anomaly->fill($data)->save() : $anomaly->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name', '=', 'Lumbar vertebra 1')->first()->id;
        $anomaly = Anomaly::firstOrNew(['sb_id' => $sb_id, 'individuating_trait' =>'Vertebral shift']);
        $data = array('sb_id' => $sb_id, 'individuating_trait' =>'Vertebral shift', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$anomaly->exists) ? $anomaly->fill($data)->save() : $anomaly->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name', '=', 'Lumbar vertebra 5')->first()->id;
        $anomaly = Anomaly::firstOrNew(['sb_id' => $sb_id, 'individuating_trait' =>'Vertebral shift']);
        $data = array('sb_id' => $sb_id, 'individuating_trait' =>'Vertebral shift', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$anomaly->exists) ? $anomaly->fill($data)->save() : $anomaly->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name', '=', 'Maxilla')->first()->id;
        $anomaly = Anomaly::firstOrNew(['sb_id' => $sb_id, 'individuating_trait' =>'Accessory infra-orbital foramen']);
        $data = array('sb_id' => $sb_id, 'individuating_trait' =>'Accessory infra-orbital foramen', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$anomaly->exists) ? $anomaly->fill($data)->save() : $anomaly->fill(array_except($data, ['created_at']))->save();

        $anomaly = Anomaly::firstOrNew(['sb_id' => $sb_id, 'individuating_trait' =>'Maxillary torus']);
        $data = array('sb_id' => $sb_id, 'individuating_trait' =>'Maxillary torus', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$anomaly->exists) ? $anomaly->fill($data)->save() : $anomaly->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name', '=', 'Nasal')->first()->id;
        $anomaly = Anomaly::firstOrNew(['sb_id' => $sb_id, 'individuating_trait' =>'Deviated nasal septum']);
        $data = array('sb_id' => $sb_id, 'individuating_trait' =>'Deviated nasal septum', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$anomaly->exists) ? $anomaly->fill($data)->save() : $anomaly->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name', '=', 'Occipital')->first()->id;
        $anomaly = Anomaly::firstOrNew(['sb_id' => $sb_id, 'individuating_trait' =>'Condylar facet']);
        $data = array('sb_id' => $sb_id, 'individuating_trait' =>'Condylar facet', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$anomaly->exists) ? $anomaly->fill($data)->save() : $anomaly->fill(array_except($data, ['created_at']))->save();

        $anomaly = Anomaly::firstOrNew(['sb_id' => $sb_id, 'individuating_trait' =>'Posterior condylar canal']);
        $data = array('sb_id' => $sb_id, 'individuating_trait' =>'Posterior condylar canal', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$anomaly->exists) ? $anomaly->fill($data)->save() : $anomaly->fill(array_except($data, ['created_at']))->save();

        $anomaly = Anomaly::firstOrNew(['sb_id' => $sb_id, 'individuating_trait' =>'Precondylar tubercle']);
        $data = array('sb_id' => $sb_id, 'individuating_trait' =>'Precondylar tubercle', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$anomaly->exists) ? $anomaly->fill($data)->save() : $anomaly->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name', '=', 'Os coxa')->first()->id;
        $anomaly = Anomaly::firstOrNew(['sb_id' => $sb_id, 'individuating_trait' =>'Accessory sacroiliac articulation']);
        $data = array('sb_id' => $sb_id, 'individuating_trait' =>'Accessory sacroiliac articulation', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$anomaly->exists) ? $anomaly->fill($data)->save() : $anomaly->fill(array_except($data, ['created_at']))->save();

        $anomaly = Anomaly::firstOrNew(['sb_id' => $sb_id, 'individuating_trait' =>'Acetabulum crease']);
        $data = array('sb_id' => $sb_id, 'individuating_trait' =>'Acetabulum crease', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$anomaly->exists) ? $anomaly->fill($data)->save() : $anomaly->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name', '=', 'Palatine')->first()->id;
        $anomaly = Anomaly::firstOrNew(['sb_id' => $sb_id, 'individuating_trait' =>'Accessory lesser palatine foramen']);
        $data = array('sb_id' => $sb_id, 'individuating_trait' =>'Accessory lesser palatine foramen', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$anomaly->exists) ? $anomaly->fill($data)->save() : $anomaly->fill(array_except($data, ['created_at']))->save();

        $anomaly = Anomaly::firstOrNew(['sb_id' => $sb_id, 'individuating_trait' =>'Palatine torus']);
        $data = array('sb_id' => $sb_id, 'individuating_trait' =>'Palatine torus', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$anomaly->exists) ? $anomaly->fill($data)->save() : $anomaly->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name', '=', 'Patella')->first()->id;
        $anomaly = Anomaly::firstOrNew(['sb_id' => $sb_id, 'individuating_trait' =>'Emarginate patella']);
        $data = array('sb_id' => $sb_id, 'individuating_trait' =>'Emarginate patella', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$anomaly->exists) ? $anomaly->fill($data)->save() : $anomaly->fill(array_except($data, ['created_at']))->save();

        $anomaly = Anomaly::firstOrNew(['sb_id' => $sb_id, 'individuating_trait' =>'Vastus notch']);
        $data = array('sb_id' => $sb_id, 'individuating_trait' =>'Vastus notch', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$anomaly->exists) ? $anomaly->fill($data)->save() : $anomaly->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name', '=', 'Parietal')->first()->id;
        $anomaly = Anomaly::firstOrNew(['sb_id' => $sb_id, 'individuating_trait' =>'Parietal foramen']);
        $data = array('sb_id' => $sb_id, 'individuating_trait' =>'Parietal foramen', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$anomaly->exists) ? $anomaly->fill($data)->save() : $anomaly->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name', '=', 'Sacrum')->first()->id;
        $anomaly = Anomaly::firstOrNew(['sb_id' => $sb_id, 'individuating_trait' =>'Accessory sacroiliac articulation']);
        $data = array('sb_id' => $sb_id, 'individuating_trait' =>'Accessory sacroiliac articulation', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$anomaly->exists) ? $anomaly->fill($data)->save() : $anomaly->fill(array_except($data, ['created_at']))->save();

        $anomaly = Anomaly::firstOrNew(['sb_id' => $sb_id, 'individuating_trait' =>'Vertebral shift']);
        $data = array('sb_id' => $sb_id, 'individuating_trait' =>'Vertebral shift', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$anomaly->exists) ? $anomaly->fill($data)->save() : $anomaly->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name', '=', 'Scapula')->first()->id;
        $anomaly = Anomaly::firstOrNew(['sb_id' => $sb_id, 'individuating_trait' =>'Accessory acromion articular facet']);
        $data = array('sb_id' => $sb_id, 'individuating_trait' =>'Accessory acromion articular facet', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$anomaly->exists) ? $anomaly->fill($data)->save() : $anomaly->fill(array_except($data, ['created_at']))->save();

        $anomaly = Anomaly::firstOrNew(['sb_id' => $sb_id, 'individuating_trait' =>'Circumflex sulcus']);
        $data = array('sb_id' => $sb_id, 'individuating_trait' =>'Circumflex sulcus', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$anomaly->exists) ? $anomaly->fill($data)->save() : $anomaly->fill(array_except($data, ['created_at']))->save();

        $anomaly = Anomaly::firstOrNew(['sb_id' => $sb_id, 'individuating_trait' =>'Glenoid fossa extension']);
        $data = array('sb_id' => $sb_id, 'individuating_trait' =>'Glenoid fossa extension', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$anomaly->exists) ? $anomaly->fill($data)->save() : $anomaly->fill(array_except($data, ['created_at']))->save();

        $anomaly = Anomaly::firstOrNew(['sb_id' => $sb_id, 'individuating_trait' =>'Scapular foramen']);
        $data = array('sb_id' => $sb_id, 'individuating_trait' =>'Scapular foramen', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$anomaly->exists) ? $anomaly->fill($data)->save() : $anomaly->fill(array_except($data, ['created_at']))->save();

        $anomaly = Anomaly::firstOrNew(['sb_id' => $sb_id, 'individuating_trait' =>'Unfused acromion process']);
        $data = array('sb_id' => $sb_id, 'individuating_trait' =>'Unfused acromion process', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$anomaly->exists) ? $anomaly->fill($data)->save() : $anomaly->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name', '=', 'Sphenoid')->first()->id;
        $anomaly = Anomaly::firstOrNew(['sb_id' => $sb_id, 'individuating_trait' =>'Foramen of Huschke']);
        $data = array('sb_id' => $sb_id, 'individuating_trait' =>'Foramen of Huschke', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$anomaly->exists) ? $anomaly->fill($data)->save() : $anomaly->fill(array_except($data, ['created_at']))->save();

        $anomaly = Anomaly::firstOrNew(['sb_id' => $sb_id, 'individuating_trait' =>'Foramen ovale incomplete']);
        $data = array('sb_id' => $sb_id, 'individuating_trait' =>'Foramen ovale incomplete', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$anomaly->exists) ? $anomaly->fill($data)->save() : $anomaly->fill(array_except($data, ['created_at']))->save();

        $anomaly = Anomaly::firstOrNew(['sb_id' => $sb_id, 'individuating_trait' =>'Foramen spinosum open']);
        $data = array('sb_id' => $sb_id, 'individuating_trait' =>'Foramen spinosum open', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$anomaly->exists) ? $anomaly->fill($data)->save() : $anomaly->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name', '=', 'Sternum')->first()->id;
        $anomaly = Anomaly::firstOrNew(['sb_id' => $sb_id, 'individuating_trait' =>'Sternal aperture']);
        $data = array('sb_id' => $sb_id, 'individuating_trait' =>'Sternal aperture', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$anomaly->exists) ? $anomaly->fill($data)->save() : $anomaly->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name', '=', 'Sternal body')->first()->id;
        $anomaly = Anomaly::firstOrNew(['sb_id' => $sb_id, 'individuating_trait' =>'Sternal aperture']);
        $data = array('sb_id' => $sb_id, 'individuating_trait' =>'Sternal aperture', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$anomaly->exists) ? $anomaly->fill($data)->save() : $anomaly->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name', '=', 'Talus')->first()->id;
        $anomaly = Anomaly::firstOrNew(['sb_id' => $sb_id, 'individuating_trait' =>'Os trigonum']);
        $data = array('sb_id' => $sb_id, 'individuating_trait' =>'Os trigonum', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$anomaly->exists) ? $anomaly->fill($data)->save() : $anomaly->fill(array_except($data, ['created_at']))->save();

        $anomaly = Anomaly::firstOrNew(['sb_id' => $sb_id, 'individuating_trait' =>'Squatting facets']);
        $data = array('sb_id' => $sb_id, 'individuating_trait' =>'Squatting facets', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$anomaly->exists) ? $anomaly->fill($data)->save() : $anomaly->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name', '=', 'Temporal')->first()->id;
        $anomaly = Anomaly::firstOrNew(['sb_id' => $sb_id, 'individuating_trait' =>'Auditory torus']);
        $data = array('sb_id' => $sb_id, 'individuating_trait' =>'Auditory torus', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$anomaly->exists) ? $anomaly->fill($data)->save() : $anomaly->fill(array_except($data, ['created_at']))->save();

        $anomaly = Anomaly::firstOrNew(['sb_id' => $sb_id, 'individuating_trait' =>'Mastoid foramen exsutural']);
        $data = array('sb_id' => $sb_id, 'individuating_trait' =>'Mastoid foramen exsutural', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$anomaly->exists) ? $anomaly->fill($data)->save() : $anomaly->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name', '=', 'Thoracic vertebra 1')->first()->id;
        $anomaly = Anomaly::firstOrNew(['sb_id' => $sb_id, 'individuating_trait' =>'Vertebral shift']);
        $data = array('sb_id' => $sb_id, 'individuating_trait' =>'Vertebral shift', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$anomaly->exists) ? $anomaly->fill($data)->save() : $anomaly->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name', '=', 'Thoracic vertebra 11')->first()->id;
        $anomaly = Anomaly::firstOrNew(['sb_id' => $sb_id, 'individuating_trait' =>'Vertebral shift']);
        $data = array('sb_id' => $sb_id, 'individuating_trait' =>'Vertebral shift', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$anomaly->exists) ? $anomaly->fill($data)->save() : $anomaly->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name', '=', 'Thoracic vertebra 12')->first()->id;
        $anomaly = Anomaly::firstOrNew(['sb_id' => $sb_id, 'individuating_trait' =>'Vertebral shift']);
        $data = array('sb_id' => $sb_id, 'individuating_trait' =>'Vertebral shift', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$anomaly->exists) ? $anomaly->fill($data)->save() : $anomaly->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name', '=', 'Tibia')->first()->id;
        $anomaly = Anomaly::firstOrNew(['sb_id' => $sb_id, 'individuating_trait' =>'Squatting facets']);
        $data = array('sb_id' => $sb_id, 'individuating_trait' =>'Squatting facets', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$anomaly->exists) ? $anomaly->fill($data)->save() : $anomaly->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name', '=', 'Ulna')->first()->id;
        $anomaly = Anomaly::firstOrNew(['sb_id' => $sb_id, 'individuating_trait' =>'Divided trochlear notch']);
        $data = array('sb_id' => $sb_id, 'individuating_trait' =>'Divided trochlear notch', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$anomaly->exists) ? $anomaly->fill($data)->save() : $anomaly->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name', '=', 'Unseriated cervical vertebra')->first()->id;
        $anomaly = Anomaly::firstOrNew(['sb_id' => $sb_id, 'individuating_trait' =>'Accessory transverse foramen']);
        $data = array('sb_id' => $sb_id, 'individuating_trait' =>'Accessory transverse foramen', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$anomaly->exists) ? $anomaly->fill($data)->save() : $anomaly->fill(array_except($data, ['created_at']))->save();

        $anomaly = Anomaly::firstOrNew(['sb_id' => $sb_id, 'individuating_trait' =>'Bifurcate foramen transversarium']);
        $data = array('sb_id' => $sb_id, 'individuating_trait' =>'Bifurcate foramen transversarium', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$anomaly->exists) ? $anomaly->fill($data)->save() : $anomaly->fill(array_except($data, ['created_at']))->save();

        $anomaly = Anomaly::firstOrNew(['sb_id' => $sb_id, 'individuating_trait' =>'Incomplete foramen transversarium']);
        $data = array('sb_id' => $sb_id, 'individuating_trait' =>'Incomplete foramen transversarium', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$anomaly->exists) ? $anomaly->fill($data)->save() : $anomaly->fill(array_except($data, ['created_at']))->save();

        $anomaly = Anomaly::firstOrNew(['sb_id' => $sb_id, 'individuating_trait' =>'Open foramen transversarium']);
        $data = array('sb_id' => $sb_id, 'individuating_trait' =>'Open foramen transversarium', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$anomaly->exists) ? $anomaly->fill($data)->save() : $anomaly->fill(array_except($data, ['created_at']))->save();

        $anomaly = Anomaly::firstOrNew(['sb_id' => $sb_id, 'individuating_trait' =>'Retroarticular bridge']);
        $data = array('sb_id' => $sb_id, 'individuating_trait' =>'Retroarticular bridge', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$anomaly->exists) ? $anomaly->fill($data)->save() : $anomaly->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name', '=', 'Zygomatic')->first()->id;
        $anomaly = Anomaly::firstOrNew(['sb_id' => $sb_id, 'individuating_trait' =>'Zygomatico-facial foramen']);
        $data = array('sb_id' => $sb_id, 'individuating_trait' =>'Zygomatico-facial foramen', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$anomaly->exists) ? $anomaly->fill($data)->save() : $anomaly->fill(array_except($data, ['created_at']))->save();
    }
}