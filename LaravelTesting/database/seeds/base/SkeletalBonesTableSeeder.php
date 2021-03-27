<?php
/**
 * SkeletalBone Seeder
 *
 * @category   SkeletalBone
 * @package    Seeder
 * @author     Sachin Pawaskar<spawaskar@unomaha.edu>
 * @copyright  2016-2018
 * @license    The MIT License (MIT)
 * @version    GIT: $Id$
 * @since      File available since Release 1.0.0
 */

use App\SkeletalBone;
use Illuminate\Database\Seeder;

class SkeletalBonesTableSeeder extends Seeder
{
    public function run()
    {
        $dt = date_create();
        $sys = 'System';

        $bone = SkeletalBone::firstOrNew(['name' => 'Accessory rib']);
        $data = array('name' => 'Accessory rib',  'search_name' => 'accessory rib', 'category'=> 'Thoracic Cage', 'type' => 'Flat', 'group' => 'Axial',
            'description' => 'Rib', 'middle' => 'false', 'paired' => false, 'articulated' => true, 'refit' => false, 'morphology' => false,  'zones' => true, 'measurements' => false,  'methods' => true, 'mni' => false, 'dental' => false,
            'image_zones' => 'ribs_500.png', 'image_measurements' => null, 'measurements_help_url' => '', 'zones_help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/zones/#ribs-2-1',
            'methods_age' => true, 'methods_sex' => false, 'methods_ancestry' => false, 'methods_stature' => false,
            'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
		(!$bone->exists) ? $bone->fill($data)->save() : $bone->fill(array_except($data, ['created_at']))->save();

        $bone = SkeletalBone::firstOrNew(['name' => 'Calcaneus']);
        $data = array('name' => 'Calcaneus',  'search_name' => 'calcaneus', 'category'=> 'Lower Extremity', 'type' => 'Irregular', 'group' => 'Appendicular',
            'description' => 'Ankle', 'middle' => 'false', 'paired' => true, 'articulated' => true, 'refit' => false, 'morphology' => true,  'zones' => true, 'measurements' => true,  'methods' => true, 'mni' => true, 'dental' => false,
            'image_zones' => 'foot_right_500.png', 'image_measurements' => 'calcaneus_500.png', 'measurements_help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/measurements/#calcaneus', 'zones_help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/zones/#foot',
            'methods_age' => true, 'methods_sex' => false, 'methods_ancestry' => false, 'methods_stature' => false,
            'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
		(!$bone->exists) ? $bone->fill($data)->save() : $bone->fill(array_except($data, ['created_at']))->save();

        $bone = SkeletalBone::firstOrNew(['name' => 'Capitate']);
        $data = array('name' => 'Capitate',  'search_name' => 'capitate', 'category'=> 'Upper Extremity', 'type' => 'Irregular', 'group' => 'Appendicular', 
            'description' => 'Wrist', 'middle' => 'false', 'paired' => true, 'articulated' => true, 'refit' => false, 'morphology' => false,  'zones' => true, 'measurements' => true,  'methods' => true, 'mni' => true, 'dental' => false, 
            'image_zones' => 'hand_left_500.png', 'image_measurements' => 'hand_500.png', 'measurements_help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/measurements/#hands', 'zones_help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/zones/#hand',
            'methods_age' => true, 'methods_sex' => false, 'methods_ancestry' => false, 'methods_stature' => false,
            'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
		(!$bone->exists) ? $bone->fill($data)->save() : $bone->fill(array_except($data, ['created_at']))->save();

        $bone = SkeletalBone::firstOrNew(['name' => 'Cervical vertebra 1']);
        $data = array('name' => 'Cervical vertebra 1',  'search_name' => 'cervical vertebra 1', 'category'=> 'Vertebral Column', 'type' => 'Irregular', 'group' => 'Axial',
            'description' => 'Vertebral', 'middle' => 'true', 'paired' => false, 'articulated' => true, 'refit' => false, 'morphology' => true,  'zones' => true, 'measurements' => true,  'methods' => true, 'mni' => true, 'dental' => false,
            'image_zones' => 'cervical_500.png', 'image_measurements' => 'vertebrae_500.png', 'measurements_help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/measurements/#vertebrae', 'zones_help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/zones/#cervical-vertebrae',
            'methods_age' => true, 'methods_sex' => false, 'methods_ancestry' => false, 'methods_stature' => false,
            'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
		(!$bone->exists) ? $bone->fill($data)->save() : $bone->fill(array_except($data, ['created_at']))->save();

        $bone = SkeletalBone::firstOrNew(['name' => 'Cervical vertebra 2']);
        $data = array('name' => 'Cervical vertebra 2',  'search_name' => 'cervical vertebra 2', 'category'=> 'Vertebral Column', 'type' => 'Irregular', 'group' => 'Axial', 
            'description' => 'Vertebral', 'middle' => 'true', 'paired' => false, 'articulated' => true, 'refit' => false, 'morphology' => true,  'zones' => true, 'measurements' => true,  'methods' => true, 'mni' => true, 'dental' => false,
            'image_zones' => 'cervical_500.png', 'image_measurements' => 'vertebrae_500.png', 'measurements_help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/measurements/#vertebrae', 'zones_help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/zones/#cervical-vertebrae',
            'methods_age' => true, 'methods_sex' => false, 'methods_ancestry' => false, 'methods_stature' => false,
            'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
		(!$bone->exists) ? $bone->fill($data)->save() : $bone->fill(array_except($data, ['created_at']))->save();

        $bone = SkeletalBone::firstOrNew(['name' => 'Cervical vertebra 3']);
        $data = array('name' => 'Cervical vertebra 3',  'search_name' => 'cervical vertebra 3', 'category'=> 'Vertebral Column', 'type' => 'Irregular', 'group' => 'Axial', 
            'description' => 'Vertebral', 'middle' => 'true', 'paired' => false, 'articulated' => true, 'refit' => false, 'morphology' => true,  'zones' => true, 'measurements' => false,  'methods' => true, 'mni' => true, 'dental' => false,
            'image_zones' => 'cervical_500.png', 'image_measurements' => null, 'measurements_help_url' => '', 'zones_help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/zones/#cervical-vertebrae',
            'methods_age' => true, 'methods_sex' => false, 'methods_ancestry' => false, 'methods_stature' => false,
            'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
		(!$bone->exists) ? $bone->fill($data)->save() : $bone->fill(array_except($data, ['created_at']))->save();

        $bone = SkeletalBone::firstOrNew(['name' => 'Cervical vertebra 4']);
        $data = array('name' => 'Cervical vertebra 4',  'search_name' => 'cervical vertebra 4', 'category'=> 'Vertebral Column', 'type' => 'Irregular', 'group' => 'Axial', 
            'description' => 'Vertebral', 'middle' => 'true', 'paired' => false, 'articulated' => true, 'refit' => false, 'morphology' => true,  'zones' => true, 'measurements' => false,  'methods' => true, 'mni' => true, 'dental' => false,
            'image_zones' => 'cervical_500.png', 'image_measurements' => null, 'measurements_help_url' => '', 'zones_help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/zones/#cervical-vertebrae',
            'methods_age' => true, 'methods_sex' => false, 'methods_ancestry' => false, 'methods_stature' => false,
            'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
		(!$bone->exists) ? $bone->fill($data)->save() : $bone->fill(array_except($data, ['created_at']))->save();

        $bone = SkeletalBone::firstOrNew(['name' => 'Cervical vertebra 5']);
        $data = array('name' => 'Cervical vertebra 5',  'search_name' => 'cervical vertebra 5', 'category'=> 'Vertebral Column', 'type' => 'Irregular', 'group' => 'Axial', 
            'description' => 'Vertebral', 'middle' => 'true', 'paired' => false, 'articulated' => true, 'refit' => false, 'morphology' => true,  'zones' => true, 'measurements' => false,  'methods' => true, 'mni' => true, 'dental' => false,
            'image_zones' => 'cervical_500.png', 'image_measurements' => null, 'measurements_help_url' => '', 'zones_help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/zones/#cervical-vertebrae',
            'methods_age' => true, 'methods_sex' => false, 'methods_ancestry' => false, 'methods_stature' => false,
            'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
		(!$bone->exists) ? $bone->fill($data)->save() : $bone->fill(array_except($data, ['created_at']))->save();

        $bone = SkeletalBone::firstOrNew(['name' => 'Cervical vertebra 6']);
        $data = array('name' => 'Cervical vertebra 6',  'search_name' => 'cervical vertebra 6', 'category'=> 'Vertebral Column', 'type' => 'Irregular', 'group' => 'Axial', 
            'description' => 'Vertebral', 'middle' => 'true', 'paired' => false, 'articulated' => true, 'refit' => false, 'morphology' => true,  'zones' => true, 'measurements' => false,  'methods' => true, 'mni' => true, 'dental' => false,
            'image_zones' => 'cervical_500.png', 'image_measurements' => null, 'measurements_help_url' => '', 'zones_help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/zones/#cervical-vertebrae',
            'methods_age' => true, 'methods_sex' => false, 'methods_ancestry' => false, 'methods_stature' => false,
            'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
		(!$bone->exists) ? $bone->fill($data)->save() : $bone->fill(array_except($data, ['created_at']))->save();

        $bone = SkeletalBone::firstOrNew(['name' => 'Cervical vertebra 6/7']);
        $data = array('name' => 'Cervical vertebra 6/7',  'search_name' => 'cervical vertebra 6/7', 'category'=> 'Vertebral Column', 'type' => 'Irregular', 'group' => 'Axial', 
            'description' => 'Vertebral', 'middle' => 'true', 'paired' => false, 'articulated' => true, 'refit' => false, 'morphology' => true,  'zones' => true, 'measurements' => false,  'methods' => true, 'mni' => false, 'dental' => false,
            'image_zones' => 'cervical_500.png', 'image_measurements' => null, 'measurements_help_url' => '', 'zones_help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/zones/#cervical-vertebrae',
            'methods_age' => true, 'methods_sex' => false, 'methods_ancestry' => false, 'methods_stature' => false,
            'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
		(!$bone->exists) ? $bone->fill($data)->save() : $bone->fill(array_except($data, ['created_at']))->save();

        $bone = SkeletalBone::firstOrNew(['name' => 'Cervical vertebra 7']);
        $data = array('name' => 'Cervical vertebra 7',  'search_name' => 'cervical vertebra 7', 'category'=> 'Vertebral Column', 'type' => 'Irregular', 'group' => 'Axial', 
            'description' => 'Vertebral', 'middle' => 'true', 'paired' => false, 'articulated' => true, 'refit' => false, 'morphology' => true,  'zones' => true, 'measurements' => false,  'methods' => true, 'mni' => true, 'dental' => false,
            'image_zones' => 'cervical_500.png', 'image_measurements' => null, 'measurements_help_url' => '', 'zones_help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/zones/#cervical-vertebrae',
            'methods_age' => true, 'methods_sex' => false, 'methods_ancestry' => false, 'methods_stature' => false,
            'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
		(!$bone->exists) ? $bone->fill($data)->save() : $bone->fill(array_except($data, ['created_at']))->save();

        $bone = SkeletalBone::firstOrNew(['name' => 'Clavicle']);
        $data = array('name' => 'Clavicle',  'search_name' => 'clavicle', 'category'=> 'Pectoral Girdle', 'type' => 'Long bone', 'group' => 'Appendicular', 
            'description' => 'Shoulder', 'middle' => 'false', 'paired' => true, 'articulated' => true, 'refit' => false, 'morphology' => true,  'zones' => true, 'measurements' => true,  'methods' => true, 'mni' => true, 'dental' => false,
            'image_zones' => 'clavicle_left_500.png', 'image_measurements' => 'clavicle_500.png', 'measurements_help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/measurements/#clavicle', 'zones_help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/zones/#clavicle',
            'methods_age' => true, 'methods_sex' => true, 'methods_ancestry' => false, 'methods_stature' => false,
            'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
		(!$bone->exists) ? $bone->fill($data)->save() : $bone->fill(array_except($data, ['created_at']))->save();

        $bone = SkeletalBone::firstOrNew(['name' => 'Coccygeal vertebra 1']);
        $data = array('name' => 'Coccygeal vertebra 1',  'search_name' => 'coccygeal vertebra 1', 'category'=> 'Vertebral Column', 'type' => 'Irregular', 'group' => 'Axial', 
            'description' => 'Vertebral', 'middle' => 'false', 'paired' => false, 'articulated' => true, 'refit' => false, 'morphology' => true,  'zones' => false, 'measurements' => false,  'methods' => true, 'mni' => true, 'dental' => false,
            'image_zones' => 'sacrum_500.png', 'image_measurements' => null, 'measurements_help_url' => '', 'zones_help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/zones/#sacrum',
            'methods_age' => true, 'methods_sex' => false, 'methods_ancestry' => false, 'methods_stature' => false,
            'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
		(!$bone->exists) ? $bone->fill($data)->save() : $bone->fill(array_except($data, ['created_at']))->save();

        $bone = SkeletalBone::firstOrNew(['name' => 'Coccygeal vertebra 2']);
        $data = array('name' => 'Coccygeal vertebra 2',  'search_name' => 'coccygeal vertebra 2', 'category'=> 'Vertebral Column', 'type' => 'Irregular', 'group' => 'Axial', 
            'description' => 'Vertebral', 'middle' => 'false', 'paired' => false, 'articulated' => true, 'refit' => false, 'morphology' => true,  'zones' => false, 'measurements' => false,  'methods' => true, 'mni' => true, 'dental' => false,
            'image_zones' => 'sacrum_500.png', 'image_measurements' => null, 'measurements_help_url' => '', 'zones_help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/zones/#sacrum',
            'methods_age' => true, 'methods_sex' => false, 'methods_ancestry' => false, 'methods_stature' => false,
            'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
		(!$bone->exists) ? $bone->fill($data)->save() : $bone->fill(array_except($data, ['created_at']))->save();

        $bone = SkeletalBone::firstOrNew(['name' => 'Coccygeal vertebra 3']);
        $data = array('name' => 'Coccygeal vertebra 3',  'search_name' => 'coccygeal vertebra 3', 'category'=> 'Vertebral Column', 'type' => 'Irregular', 'group' => 'Axial', 
			'description' => 'Vertebral', 'middle' => 'false', 'paired' => false, 'articulated' => true, 'refit' => false, 'morphology' => true,  'zones' => false, 'measurements' => false,  'methods' => true, 'mni' => true, 'dental' => false,
			'image_zones' => 'sacrum_500.png', 'image_measurements' => null, 'measurements_help_url' => '', 'zones_help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/zones/#sacrum',
            'methods_age' => true, 'methods_sex' => false, 'methods_ancestry' => false, 'methods_stature' => false,
            'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
		(!$bone->exists) ? $bone->fill($data)->save() : $bone->fill(array_except($data, ['created_at']))->save();

        $bone = SkeletalBone::firstOrNew(['name' => 'Coccygeal vertebra 4']);
        $data = array('name' => 'Coccygeal vertebra 4',  'search_name' => 'coccygeal vertebra 4', 'category'=> 'Vertebral Column', 'type' => 'Irregular', 'group' => 'Axial', 
			'description' => 'Vertebral', 'middle' => 'false', 'paired' => false, 'articulated' => true, 'refit' => false, 'morphology' => true,  'zones' => false, 'measurements' => false,  'methods' => true, 'mni' => true, 'dental' => false,
			'image_zones' => 'sacrum_500.png', 'image_measurements' => null, 'measurements_help_url' => '', 'zones_help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/zones/#sacrum',
            'methods_age' => true, 'methods_sex' => false, 'methods_ancestry' => false, 'methods_stature' => false,
            'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
		(!$bone->exists) ? $bone->fill($data)->save() : $bone->fill(array_except($data, ['created_at']))->save();

        $bone = SkeletalBone::firstOrNew(['name' => 'Coccyx']);
        $data = array('name' => 'Coccyx',  'search_name' => 'coccyx', 'category'=> 'Vertebral Column', 'type' => 'Irregular', 'group' => 'Axial', 
			'description' => 'Vertebral', 'middle' => 'true', 'paired' => false, 'articulated' => true, 'refit' => false, 'morphology' => true,  'zones' => true, 'measurements' => false,  'methods' => false, 'mni' => true, 'dental' => false,
			'image_zones' => 'sacrum_500.png', 'image_measurements' => null, 'measurements_help_url' => '', 'zones_help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/zones/#sacrum',
            'methods_age' => false, 'methods_sex' => false, 'methods_ancestry' => false, 'methods_stature' => false, 
            'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
		(!$bone->exists) ? $bone->fill($data)->save() : $bone->fill(array_except($data, ['created_at']))->save();

        $bone = SkeletalBone::firstOrNew(['name' => 'Cranium']);
        $data = array('name' => 'Cranium',  'search_name' => 'cranium', 'category'=> 'Cranial', 'type' => 'Irregular', 'group' => 'Axial', 
			'description' => 'Cranial', 'middle' => 'true', 'paired' => false, 'articulated' => true, 'refit' => false, 'morphology' => true,  'zones' => true, 'measurements' => true,  'methods' => true, 'mni' => true, 'dental' => true,
            'image_zones' => 'cranium_zones_composite_500.png', 'image_measurements' => 'cranium_measurements_composite_500.png', 'measurements_help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/measurements/#cranium', 'zones_help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/zones/#cranium',
            'methods_age' => true, 'methods_sex' => true, 'methods_ancestry' => true, 'methods_stature' => false,
            'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
		(!$bone->exists) ? $bone->fill($data)->save() : $bone->fill(array_except($data, ['created_at']))->save();

        $bone = SkeletalBone::firstOrNew(['name' => 'Cuboid']);
        $data = array('name' => 'Cuboid',  'search_name' => 'cuboid', 'category'=> 'Lower Extremity', 'type' => 'Irregular', 'group' => 'Appendicular', 
			'description' => 'Ankle', 'middle' => 'false', 'paired' => true, 'articulated' => true, 'refit' => false, 'morphology' => false,  'zones' => true, 'measurements' => true,  'methods' => true, 'mni' => true, 'dental' => false, 
			'image_zones' => 'foot_right_500.png', 'image_measurements' => 'foot_500.png', 'measurements_help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/measurements/#feet', 'zones_help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/zones/#foot',
            'methods_age' => true, 'methods_sex' => false, 'methods_ancestry' => false, 'methods_stature' => false,
            'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
		(!$bone->exists) ? $bone->fill($data)->save() : $bone->fill(array_except($data, ['created_at']))->save();

        $bone = SkeletalBone::firstOrNew(['name' => 'Distal manual phalanx 1']);
        $data = array('name' => 'Distal manual phalanx 1',  'search_name' => 'distal manual phalanx 1', 'category'=> 'Upper Extremity', 'type' => 'Short bone', 'group' => 'Appendicular', 
			'description' => 'Hand', 'middle' => 'false', 'paired' => true, 'articulated' => true, 'refit' => false, 'morphology' => false,  'zones' => true, 'measurements' => false,  'methods' => true, 'mni' => true, 'dental' => false, 
			'image_zones' => 'hand_left_500.png', 'image_measurements' => null, 'measurements_help_url' => '', 'zones_help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/zones/#hand',
            'methods_age' => true, 'methods_sex' => false, 'methods_ancestry' => false, 'methods_stature' => false,
            'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
		(!$bone->exists) ? $bone->fill($data)->save() : $bone->fill(array_except($data, ['created_at']))->save();

        $bone = SkeletalBone::firstOrNew(['name' => 'Distal manual phalanx 2']);
        $data = array('name' => 'Distal manual phalanx 2',  'search_name' => 'distal manual phalanx 2', 'category'=> 'Upper Extremity', 'type' => 'Short bone', 'group' => 'Appendicular', 
			'description' => 'Hand', 'middle' => 'false', 'paired' => true, 'articulated' => true, 'refit' => false, 'morphology' => false,  'zones' => true, 'measurements' => false,  'methods' => true, 'mni' => true, 'dental' => false, 
			'image_zones' => 'hand_left_500.png', 'image_measurements' => null, 'measurements_help_url' => '', 'zones_help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/zones/#hand',
            'methods_age' => true, 'methods_sex' => false, 'methods_ancestry' => false, 'methods_stature' => false,
            'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
		(!$bone->exists) ? $bone->fill($data)->save() : $bone->fill(array_except($data, ['created_at']))->save();

        $bone = SkeletalBone::firstOrNew(['name' => 'Distal manual phalanx 3']);
        $data = array('name' => 'Distal manual phalanx 3',  'search_name' => 'distal manual phalanx 3', 'category'=> 'Upper Extremity', 'type' => 'Short bone', 'group' => 'Appendicular', 
			'description' => 'Hand', 'middle' => 'false', 'paired' => true, 'articulated' => true, 'refit' => false, 'morphology' => false,  'zones' => true, 'measurements' => false,  'methods' => true, 'mni' => true, 'dental' => false, 
			'image_zones' => 'hand_left_500.png', 'image_measurements' => null, 'measurements_help_url' => '', 'zones_help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/zones/#hand',
            'methods_age' => true, 'methods_sex' => false, 'methods_ancestry' => false, 'methods_stature' => false,
            'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
		(!$bone->exists) ? $bone->fill($data)->save() : $bone->fill(array_except($data, ['created_at']))->save();

        $bone = SkeletalBone::firstOrNew(['name' => 'Distal manual phalanx 4']);
        $data = array('name' => 'Distal manual phalanx 4',  'search_name' => 'distal manual phalanx 4', 'category'=> 'Upper Extremity', 'type' => 'Short bone', 'group' => 'Appendicular', 
			'description' => 'Hand', 'middle' => 'false', 'paired' => true, 'articulated' => true, 'refit' => false, 'morphology' => false,  'zones' => true, 'measurements' => false,  'methods' => true, 'mni' => true, 'dental' => false, 
			'image_zones' => 'hand_left_500.png', 'image_measurements' => null, 'measurements_help_url' => '', 'zones_help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/zones/#hand',
            'methods_age' => true, 'methods_sex' => false, 'methods_ancestry' => false, 'methods_stature' => false,
            'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
		(!$bone->exists) ? $bone->fill($data)->save() : $bone->fill(array_except($data, ['created_at']))->save();

        $bone = SkeletalBone::firstOrNew(['name' => 'Distal manual phalanx 5']);
        $data = array('name' => 'Distal manual phalanx 5',  'search_name' => 'distal manual phalanx 5', 'category'=> 'Upper Extremity', 'type' => 'Short bone', 'group' => 'Appendicular', 
			'description' => 'Hand', 'middle' => 'false', 'paired' => true, 'articulated' => true, 'refit' => false, 'morphology' => false,  'zones' => true, 'measurements' => false,  'methods' => true, 'mni' => true, 'dental' => false, 
			'image_zones' => 'hand_left_500.png', 'image_measurements' => null, 'measurements_help_url' => '', 'zones_help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/zones/#hand',
            'methods_age' => true, 'methods_sex' => false, 'methods_ancestry' => false, 'methods_stature' => false,
            'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
		(!$bone->exists) ? $bone->fill($data)->save() : $bone->fill(array_except($data, ['created_at']))->save();

        $bone = SkeletalBone::firstOrNew(['name' => 'Distal pedal phalanx 1']);
        $data = array('name' => 'Distal pedal phalanx 1',  'search_name' => 'distal pedal phalanx 1', 'category'=> 'Lower Extremity', 'type' => 'Short bone', 'group' => 'Appendicular', 
			'description' => 'Foot', 'middle' => 'false', 'paired' => true, 'articulated' => true, 'refit' => false, 'morphology' => false,  'zones' => true, 'measurements' => false,  'methods' => true, 'mni' => true, 'dental' => false, 
			'image_zones' => 'foot_right_500.png', 'image_measurements' => null, 'measurements_help_url' => '', 'zones_help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/zones/#foot',
            'methods_age' => true, 'methods_sex' => false, 'methods_ancestry' => false, 'methods_stature' => false,
            'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
		(!$bone->exists) ? $bone->fill($data)->save() : $bone->fill(array_except($data, ['created_at']))->save();

        $bone = SkeletalBone::firstOrNew(['name' => 'Distal pedal phalanx 2']);
        $data = array('name' => 'Distal pedal phalanx 2',  'search_name' => 'distal pedal phalanx 2', 'category'=> 'Lower Extremity', 'type' => 'Short bone', 'group' => 'Appendicular', 
			'description' => 'Foot', 'middle' => 'false', 'paired' => true, 'articulated' => true, 'refit' => false, 'morphology' => false,  'zones' => true, 'measurements' => false,  'methods' => true, 'mni' => true, 'dental' => false, 
			'image_zones' => 'foot_right_500.png', 'image_measurements' => null, 'measurements_help_url' => '', 'zones_help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/zones/#foot',
            'methods_age' => true, 'methods_sex' => false, 'methods_ancestry' => false, 'methods_stature' => false,
            'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
		(!$bone->exists) ? $bone->fill($data)->save() : $bone->fill(array_except($data, ['created_at']))->save();

        $bone = SkeletalBone::firstOrNew(['name' => 'Distal pedal phalanx 3']);
        $data = array('name' => 'Distal pedal phalanx 3',  'search_name' => 'distal pedal phalanx 3', 'category'=> 'Lower Extremity', 'type' => 'Short bone', 'group' => 'Appendicular', 
			'description' => 'Foot', 'middle' => 'false', 'paired' => true, 'articulated' => true, 'refit' => false, 'morphology' => false,  'zones' => true, 'measurements' => false,  'methods' => true, 'mni' => true, 'dental' => false, 
			'image_zones' => 'foot_right_500.png', 'image_measurements' => null, 'measurements_help_url' => '', 'zones_help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/zones/#foot',
            'methods_age' => true, 'methods_sex' => false, 'methods_ancestry' => false, 'methods_stature' => false,
            'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
		(!$bone->exists) ? $bone->fill($data)->save() : $bone->fill(array_except($data, ['created_at']))->save();

        $bone = SkeletalBone::firstOrNew(['name' => 'Distal pedal phalanx 4']);
        $data = array('name' => 'Distal pedal phalanx 4',  'search_name' => 'distal pedal phalanx 4', 'category'=> 'Lower Extremity', 'type' => 'Short bone', 'group' => 'Appendicular', 
			'description' => 'Foot', 'middle' => 'false', 'paired' => true, 'articulated' => true, 'refit' => false, 'morphology' => false,  'zones' => true, 'measurements' => false,  'methods' => true, 'mni' => true, 'dental' => false, 
			'image_zones' => 'foot_right_500.png', 'image_measurements' => null, 'measurements_help_url' => '', 'zones_help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/zones/#foot',
            'methods_age' => true, 'methods_sex' => false, 'methods_ancestry' => false, 'methods_stature' => false,
            'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
		(!$bone->exists) ? $bone->fill($data)->save() : $bone->fill(array_except($data, ['created_at']))->save();

        $bone = SkeletalBone::firstOrNew(['name' => 'Distal pedal phalanx 5']);
        $data = array('name' => 'Distal pedal phalanx 5',  'search_name' => 'distal pedal phalanx 5', 'category'=> 'Lower Extremity', 'type' => 'Short bone', 'group' => 'Appendicular', 
			'description' => 'Foot', 'middle' => 'false', 'paired' => true, 'articulated' => true, 'refit' => false, 'morphology' => false,  'zones' => true, 'measurements' => false,  'methods' => true, 'mni' => true, 'dental' => false, 
			'image_zones' => 'foot_right_500.png', 'image_measurements' => null, 'measurements_help_url' => '', 'zones_help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/zones/#foot',
            'methods_age' => true, 'methods_sex' => false, 'methods_ancestry' => false, 'methods_stature' => false,
            'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
		(!$bone->exists) ? $bone->fill($data)->save() : $bone->fill(array_except($data, ['created_at']))->save();

        $bone = SkeletalBone::firstOrNew(['name' => 'Ethmoid']);
        $data = array('name' => 'Ethmoid',  'search_name' => 'ethmoid', 'category'=> 'Cranial', 'type' => 'Irregular', 'group' => 'Axial', 
			'description' => 'Cranial', 'middle' => 'false', 'paired' => false, 'articulated' => true, 'refit' => false, 'morphology' => false,  'zones' => false, 'measurements' => false,  'methods' => true, 'mni' => true, 'dental' => false,
			'image_zones' => null, 'image_measurements' => null, 'measurements_help_url' => '', 'zones_help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/zones/#cranium',
            'methods_age' => true, 'methods_sex' => false, 'methods_ancestry' => false, 'methods_stature' => false,
            'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
		(!$bone->exists) ? $bone->fill($data)->save() : $bone->fill(array_except($data, ['created_at']))->save();

        $bone = SkeletalBone::firstOrNew(['name' => 'Extra vertebra']);
        $data = array('name' => 'Extra vertebra',  'search_name' => 'extra vertebra', 'category'=> 'Vertebral Column', 'type' => 'N/A', 'group' => 'Axial', 
			'description' => 'Vertebral', 'middle' => 'false', 'paired' => false, 'articulated' => true, 'refit' => false, 'morphology' => false,  'zones' => true, 'measurements' => false,  'methods' => true, 'mni' => false, 'dental' => false,
			'image_zones' => 'thoracic_500.png', 'image_measurements' => null, 'measurements_help_url' => '', 'zones_help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/zones/#vertebrae',
            'methods_age' => true, 'methods_sex' => false, 'methods_ancestry' => false, 'methods_stature' => false,
            'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
		(!$bone->exists) ? $bone->fill($data)->save() : $bone->fill(array_except($data, ['created_at']))->save();

        $bone = SkeletalBone::firstOrNew(['name' => 'Femur']);
        $data = array('name' => 'Femur',  'search_name' => 'femur', 'category'=> 'Lower Extremity', 'type' => 'Long bone', 'group' => 'Appendicular', 
			'description' => 'Leg', 'middle' => 'false', 'paired' => true, 'articulated' => true, 'refit' => false, 'morphology' => true,  'zones' => true, 'measurements' => true,  'methods' => true, 'mni' => true, 'dental' => false,
            'image_zones' => 'femur3_500.png', 'image_measurements' => 'femur_500.png', 'measurements_help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/measurements/#femur', 'zones_help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/zones/#femur',
            'methods_age' => true, 'methods_sex' => false, 'methods_ancestry' => false, 'methods_stature' => false,
            'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
		(!$bone->exists) ? $bone->fill($data)->save() : $bone->fill(array_except($data, ['created_at']))->save();

        $bone = SkeletalBone::firstOrNew(['name' => 'Fibula']);
        $data = array('name' => 'Fibula',  'search_name' => 'fibula', 'category'=> 'Lower Extremity', 'type' => 'Long bone', 'group' => 'Appendicular', 
			'description' => 'Leg', 'middle' => 'false', 'paired' => true, 'articulated' => true, 'refit' => false, 'morphology' => true,  'zones' => true, 'measurements' => true,  'methods' => true, 'mni' => true, 'dental' => false,
            'image_zones' => 'fibula_500.png', 'image_measurements' => 'fibula_500.png', 'measurements_help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/measurements/#fibula', 'zones_help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/zones/#fibula',
            'methods_age' => true, 'methods_sex' => false, 'methods_ancestry' => false, 'methods_stature' => false,
            'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt); 
		(!$bone->exists) ? $bone->fill($data)->save() : $bone->fill(array_except($data, ['created_at']))->save();

        $bone = SkeletalBone::firstOrNew(['name' => 'First (Medial) cuneiform']);
        $data = array('name' => 'First (Medial) cuneiform',  'search_name' => 'first (medial) cuneiform', 'category'=> 'Lower Extremity', 'type' => 'Irregular', 'group' => 'Appendicular', 
			'description' => 'Ankle', 'middle' => 'false', 'paired' => true, 'articulated' => true, 'refit' => false, 'morphology' => false,  'zones' => true, 'measurements' => true,  'methods' => true, 'mni' => true, 'dental' => false, 
			'image_zones' => 'foot_right_500.png', 'image_measurements' => 'foot_500.png', 'measurements_help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/measurements/#feet', 'zones_help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/zones/#foot',
            'methods_age' => true, 'methods_sex' => false, 'methods_ancestry' => false, 'methods_stature' => false,
            'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
		(!$bone->exists) ? $bone->fill($data)->save() : $bone->fill(array_except($data, ['created_at']))->save();

        $bone = SkeletalBone::firstOrNew(['name' => 'Frontal']);
        $data = array('name' => 'Frontal',  'search_name' => 'frontal', 'category'=> 'Cranial', 'type' => 'Flat', 'group' => 'Axial', 
			'description' => 'Cranial', 'middle' => 'false', 'paired' => false, 'articulated' => true, 'refit' => false, 'morphology' => true,  'zones' => true, 'measurements' => false,  'methods' => true, 'mni' => true, 'dental' => false,
			'image_zones' => 'cranium_zones_composite_500.png', 'image_measurements' => null, 'measurements_help_url' => '', 'zones_help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/zones/#cranium',
            'methods_age' => true, 'methods_sex' => true, 'methods_ancestry' => false, 'methods_stature' => false,
            'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
		(!$bone->exists) ? $bone->fill($data)->save() : $bone->fill(array_except($data, ['created_at']))->save();

        $bone = SkeletalBone::firstOrNew(['name' => 'Hamate']);
        $data = array('name' => 'Hamate',  'search_name' => 'hamate', 'category'=> 'Upper Extremity', 'type' => 'Irregular', 'group' => 'Appendicular', 
			'description' => 'Wrist', 'middle' => 'false', 'paired' => true, 'articulated' => true, 'refit' => false, 'morphology' => false,  'zones' => true, 'measurements' => true,  'methods' => true, 'mni' => true, 'dental' => false, 
			'image_zones' => 'hand_left_500.png', 'image_measurements' => 'hand_500.png', 'measurements_help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/measurements/#hands', 'zones_help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/zones/#hand',
            'methods_age' => true, 'methods_sex' => false, 'methods_ancestry' => false, 'methods_stature' => false,
            'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
		(!$bone->exists) ? $bone->fill($data)->save() : $bone->fill(array_except($data, ['created_at']))->save();

        $bone = SkeletalBone::firstOrNew(['name' => 'Humerus']);
        $data = array('name' => 'Humerus',  'search_name' => 'humerus', 'category'=> 'Upper Extremity', 'type' => 'Long bone', 'group' => 'Appendicular', 
			'description' => 'Arm', 'middle' => 'false', 'paired' => true, 'articulated' => true, 'refit' => false, 'morphology' => true,  'zones' => true, 'measurements' => true,  'methods' => true, 'mni' => true, 'dental' => false,
            'image_zones' => 'humerus_left_500.png', 'image_measurements' => 'humerus_500.png', 'measurements_help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/measurements/#humerus', 'zones_help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/zones/#humerus',
            'methods_age' => true, 'methods_sex' => true, 'methods_ancestry' => false, 'methods_stature' => false,
            'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
		(!$bone->exists) ? $bone->fill($data)->save() : $bone->fill(array_except($data, ['created_at']))->save();

        $bone = SkeletalBone::firstOrNew(['name' => 'Hyoid']);
        $data = array('name' => 'Hyoid',  'search_name' => 'hyoid', 'category'=> 'Cranial', 'type' => 'Flat', 'group' => 'Axial', 
			'description' => 'Hyoid', 'middle' => 'false', 'paired' => false, 'articulated' => true, 'refit' => false, 'morphology' => true,  'zones' => true, 'measurements' => false,  'methods' => true, 'mni' => true, 'dental' => false, 
			'image_zones' => 'hyoid_500.png', 'image_measurements' => null, 'measurements_help_url' => '', 'zones_help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/zones/#vertebrae-and-hyoid',
            'methods_age' => true, 'methods_sex' => false, 'methods_ancestry' => false, 'methods_stature' => false,
            'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
		(!$bone->exists) ? $bone->fill($data)->save() : $bone->fill(array_except($data, ['created_at']))->save();

        $bone = SkeletalBone::firstOrNew(['name' => 'Incus']);
        $data = array('name' => 'Incus',  'search_name' => 'incus', 'category'=> 'Cranial', 'type' => 'Irregular', 'group' => 'Axial', 
			'description' => 'Ear ossicle', 'middle' => 'false', 'paired' => true, 'articulated' => true, 'refit' => false, 'morphology' => false,  'zones' => true, 'measurements' => false,  'methods' => false, 'mni' => true, 'dental' => false,
			'image_zones' => 'ossicles_500.png', 'image_measurements' => null, 'measurements_help_url' => '', 'zones_help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/zones/#cranium',
            'methods_age' => false, 'methods_sex' => false, 'methods_ancestry' => false, 'methods_stature' => false, 
            'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
		(!$bone->exists) ? $bone->fill($data)->save() : $bone->fill(array_except($data, ['created_at']))->save();

        $bone = SkeletalBone::firstOrNew(['name' => 'Inferior nasal concha']);
        $data = array('name' => 'Inferior nasal concha',  'search_name' => 'inferior nasal concha', 'category'=> 'Cranial', 'type' => 'Irregular', 'group' => 'Axial', 
			'description' => 'Cranial', 'middle' => 'false', 'paired' => true, 'articulated' => true, 'refit' => false, 'morphology' => false,  'zones' => false, 'measurements' => false,  'methods' => true, 'mni' => true, 'dental' => false,
			'image_zones' => null, 'image_measurements' => null, 'measurements_help_url' => '', 'zones_help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/zones/#cranium',
            'methods_age' => true, 'methods_sex' => false, 'methods_ancestry' => false, 'methods_stature' => false,
            'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
		(!$bone->exists) ? $bone->fill($data)->save() : $bone->fill(array_except($data, ['created_at']))->save();

        $bone = SkeletalBone::firstOrNew(['name' => 'Intermediate manual phalanx 2']);
        $data = array('name' => 'Intermediate manual phalanx 2',  'search_name' => 'intermediate manual phalanx 2', 'category'=> 'Upper Extremity', 'type' => 'Short bone', 'group' => 'Appendicular', 
			'description' => 'Hand', 'middle' => 'false', 'paired' => true, 'articulated' => true, 'refit' => false, 'morphology' => false,  'zones' => true, 'measurements' => false,  'methods' => true, 'mni' => true, 'dental' => false, 
			'image_zones' => 'hand_left_500.png', 'image_measurements' => null, 'measurements_help_url' => '', 'zones_help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/zones/#hand',
            'methods_age' => true, 'methods_sex' => false, 'methods_ancestry' => false, 'methods_stature' => false,
            'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
		(!$bone->exists) ? $bone->fill($data)->save() : $bone->fill(array_except($data, ['created_at']))->save();

        $bone = SkeletalBone::firstOrNew(['name' => 'Intermediate manual phalanx 3']);
        $data = array('name' => 'Intermediate manual phalanx 3',  'search_name' => 'intermediate manual phalanx 3', 'category'=> 'Upper Extremity', 'type' => 'Short bone', 'group' => 'Appendicular', 
			'description' => 'Hand', 'middle' => 'false', 'paired' => true, 'articulated' => true, 'refit' => false, 'morphology' => false,  'zones' => true, 'measurements' => false,  'methods' => true, 'mni' => true, 'dental' => false, 
			'image_zones' => 'hand_left_500.png', 'image_measurements' => null, 'measurements_help_url' => '', 'zones_help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/zones/#hand',
            'methods_age' => true, 'methods_sex' => false, 'methods_ancestry' => false, 'methods_stature' => false,
            'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
		(!$bone->exists) ? $bone->fill($data)->save() : $bone->fill(array_except($data, ['created_at']))->save();

        $bone = SkeletalBone::firstOrNew(['name' => 'Intermediate manual phalanx 4']);
        $data = array('name' => 'Intermediate manual phalanx 4',  'search_name' => 'intermediate manual phalanx 4', 'category'=> 'Upper Extremity', 'type' => 'Short bone', 'group' => 'Appendicular', 
			'description' => 'Hand', 'middle' => 'false', 'paired' => true, 'articulated' => true, 'refit' => false, 'morphology' => false,  'zones' => true, 'measurements' => false,  'methods' => true, 'mni' => true, 'dental' => false, 
			'image_zones' => 'hand_left_500.png', 'image_measurements' => null, 'measurements_help_url' => '', 'zones_help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/zones/#hand',
            'methods_age' => true, 'methods_sex' => false, 'methods_ancestry' => false, 'methods_stature' => false,
            'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
		(!$bone->exists) ? $bone->fill($data)->save() : $bone->fill(array_except($data, ['created_at']))->save();

        $bone = SkeletalBone::firstOrNew(['name' => 'Intermediate manual phalanx 5']);
        $data = array('name' => 'Intermediate manual phalanx 5',  'search_name' => 'intermediate manual phalanx 5', 'category'=> 'Upper Extremity', 'type' => 'Short bone', 'group' => 'Appendicular', 
			'description' => 'Hand', 'middle' => 'false', 'paired' => true, 'articulated' => true, 'refit' => false, 'morphology' => false,  'zones' => true, 'measurements' => false,  'methods' => true, 'mni' => true, 'dental' => false, 
			'image_zones' => 'hand_left_500.png', 'image_measurements' => null, 'measurements_help_url' => '', 'zones_help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/zones/#hand',
            'methods_age' => true, 'methods_sex' => false, 'methods_ancestry' => false, 'methods_stature' => false,
            'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
		(!$bone->exists) ? $bone->fill($data)->save() : $bone->fill(array_except($data, ['created_at']))->save();

        $bone = SkeletalBone::firstOrNew(['name' => 'Intermediate pedal phalanx 2']);
        $data = array('name' => 'Intermediate pedal phalanx 2',  'search_name' => 'intermediate pedal phalanx 2', 'category'=> 'Lower Extremity', 'type' => 'Short bone', 'group' => 'Appendicular', 
			'description' => 'Foot', 'middle' => 'false', 'paired' => true, 'articulated' => true, 'refit' => false, 'morphology' => false,  'zones' => true, 'measurements' => false,  'methods' => true, 'mni' => true, 'dental' => false, 
			'image_zones' => 'foot_right_500.png', 'image_measurements' => null, 'measurements_help_url' => '', 'zones_help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/zones/#foot',
            'methods_age' => true, 'methods_sex' => false, 'methods_ancestry' => false, 'methods_stature' => false,
            'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
		(!$bone->exists) ? $bone->fill($data)->save() : $bone->fill(array_except($data, ['created_at']))->save();

        $bone = SkeletalBone::firstOrNew(['name' => 'Intermediate pedal phalanx 3']);
        $data = array('name' => 'Intermediate pedal phalanx 3',  'search_name' => 'intermediate pedal phalanx 3', 'category'=> 'Lower Extremity', 'type' => 'Short bone', 'group' => 'Appendicular', 
			'description' => 'Foot', 'middle' => 'false', 'paired' => true, 'articulated' => true, 'refit' => false, 'morphology' => false,  'zones' => true, 'measurements' => false,  'methods' => true, 'mni' => true, 'dental' => false, 
			'image_zones' => 'foot_right_500.png', 'image_measurements' => null, 'measurements_help_url' => '', 'zones_help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/zones/#foot',
            'methods_age' => true, 'methods_sex' => false, 'methods_ancestry' => false, 'methods_stature' => false,
            'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
		(!$bone->exists) ? $bone->fill($data)->save() : $bone->fill(array_except($data, ['created_at']))->save();

        $bone = SkeletalBone::firstOrNew(['name' => 'Intermediate pedal phalanx 4']);
        $data = array('name' => 'Intermediate pedal phalanx 4',  'search_name' => 'intermediate pedal phalanx 4', 'category'=> 'Lower Extremity', 'type' => 'Short bone', 'group' => 'Appendicular', 
			'description' => 'Foot', 'middle' => 'false', 'paired' => true, 'articulated' => true, 'refit' => false, 'morphology' => false,  'zones' => true, 'measurements' => false,  'methods' => true, 'mni' => true, 'dental' => false, 
			'image_zones' => 'foot_right_500.png', 'image_measurements' => null, 'measurements_help_url' => '', 'zones_help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/zones/#foot',
            'methods_age' => true, 'methods_sex' => false, 'methods_ancestry' => false, 'methods_stature' => false,
            'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
		(!$bone->exists) ? $bone->fill($data)->save() : $bone->fill(array_except($data, ['created_at']))->save();

        $bone = SkeletalBone::firstOrNew(['name' => 'Intermediate pedal phalanx 5']);
        $data = array('name' => 'Intermediate pedal phalanx 5',  'search_name' => 'intermediate pedal phalanx 5', 'category'=> 'Lower Extremity', 'type' => 'Short bone', 'group' => 'Appendicular', 
			'description' => 'Foot', 'middle' => 'false', 'paired' => true, 'articulated' => true, 'refit' => false, 'morphology' => false,  'zones' => true, 'measurements' => false,  'methods' => true, 'mni' => true, 'dental' => false, 
			'image_zones' => 'foot_right_500.png', 'image_measurements' => null, 'measurements_help_url' => '', 'zones_help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/zones/#foot',
            'methods_age' => true, 'methods_sex' => false, 'methods_ancestry' => false, 'methods_stature' => false,
            'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
		(!$bone->exists) ? $bone->fill($data)->save() : $bone->fill(array_except($data, ['created_at']))->save();

        $bone = SkeletalBone::firstOrNew(['name' => 'Lacrimal']);
        $data = array('name' => 'Lacrimal',  'search_name' => 'lacrimal', 'category'=> 'Cranial', 'type' => 'Flat', 'group' => 'Axial', 
			'description' => 'Cranial', 'middle' => 'false', 'paired' => true, 'articulated' => true, 'refit' => false, 'morphology' => false,  'zones' => false, 'measurements' => false,  'methods' => true, 'mni' => true, 'dental' => false,
			'image_zones' => null, 'image_measurements' => null, 'measurements_help_url' => '', 'zones_help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/zones/#cranium',
            'methods_age' => true, 'methods_sex' => false, 'methods_ancestry' => false, 'methods_stature' => false,
            'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
		(!$bone->exists) ? $bone->fill($data)->save() : $bone->fill(array_except($data, ['created_at']))->save();

        $bone = SkeletalBone::firstOrNew(['name' => 'Lumbar vertebra 1']);
        $data = array('name' => 'Lumbar vertebra 1',  'search_name' => 'lumbar vertebra 1', 'category'=> 'Vertebral Column', 'type' => 'Irregular', 'group' => 'Axial', 
			'description' => 'Vertebral', 'middle' => 'true', 'paired' => false, 'articulated' => true, 'refit' => false, 'morphology' => true,  'zones' => true, 'measurements' => false,  'methods' => true, 'mni' => true, 'dental' => false, 
			'image_zones' => 'thoracic_500.png', 'image_measurements' => null, 'measurements_help_url' => '', 'zones_help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/zones/#thoracic-and-lumbar-vertebrae',
            'methods_age' => true, 'methods_sex' => false, 'methods_ancestry' => false, 'methods_stature' => false,
            'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
		(!$bone->exists) ? $bone->fill($data)->save() : $bone->fill(array_except($data, ['created_at']))->save();

        $bone = SkeletalBone::firstOrNew(['name' => 'Lumbar vertebra 1/2']);
        $data = array('name' => 'Lumbar vertebra 1/2',  'search_name' => 'lumbar vertebra 1/2', 'category'=> 'Vertebral Column', 'type' => 'Irregular', 'group' => 'Axial', 
			'description' => 'Vertebral', 'middle' => 'true', 'paired' => false, 'articulated' => true, 'refit' => false, 'morphology' => true,  'zones' => true, 'measurements' => false,  'methods' => true, 'mni' => false, 'dental' => false,
			'image_zones' => 'thoracic_500.png', 'image_measurements' => null, 'measurements_help_url' => '', 'zones_help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/zones/#thoracic-and-lumbar-vertebrae',
            'methods_age' => true, 'methods_sex' => false, 'methods_ancestry' => false, 'methods_stature' => false,
            'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
		(!$bone->exists) ? $bone->fill($data)->save() : $bone->fill(array_except($data, ['created_at']))->save();

        $bone = SkeletalBone::firstOrNew(['name' => 'Lumbar vertebra 2']);
        $data = array('name' => 'Lumbar vertebra 2',  'search_name' => 'lumbar vertebra 2', 'category'=> 'Vertebral Column', 'type' => 'Irregular', 'group' => 'Axial', 
			'description' => 'Vertebral', 'middle' => 'true', 'paired' => false, 'articulated' => true, 'refit' => false, 'morphology' => true,  'zones' => true, 'measurements' => false,  'methods' => true, 'mni' => true, 'dental' => false, 
			'image_zones' => 'thoracic_500.png', 'image_measurements' => null, 'measurements_help_url' => '', 'zones_help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/zones/#thoracic-and-lumbar-vertebrae',
            'methods_age' => true, 'methods_sex' => false, 'methods_ancestry' => false, 'methods_stature' => false,
            'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
		(!$bone->exists) ? $bone->fill($data)->save() : $bone->fill(array_except($data, ['created_at']))->save();

        $bone = SkeletalBone::firstOrNew(['name' => 'Lumbar vertebra 2/3']);
        $data = array('name' => 'Lumbar vertebra 2/3',  'search_name' => 'lumbar vertebra 2/3', 'category'=> 'Vertebral Column', 'type' => 'Irregular', 'group' => 'Axial', 
			'description' => 'Vertebral', 'middle' => 'true', 'paired' => false, 'articulated' => true, 'refit' => false, 'morphology' => true,  'zones' => true, 'measurements' => false,  'methods' => true, 'mni' => false, 'dental' => false,
			'image_zones' => 'thoracic_500.png', 'image_measurements' => null, 'measurements_help_url' => '', 'zones_help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/zones/#thoracic-and-lumbar-vertebrae',
            'methods_age' => true, 'methods_sex' => false, 'methods_ancestry' => false, 'methods_stature' => false,
            'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
		(!$bone->exists) ? $bone->fill($data)->save() : $bone->fill(array_except($data, ['created_at']))->save();

        $bone = SkeletalBone::firstOrNew(['name' => 'Lumbar vertebra 3']);
        $data = array('name' => 'Lumbar vertebra 3',  'search_name' => 'lumbar vertebra 3', 'category'=> 'Vertebral Column', 'type' => 'Irregular', 'group' => 'Axial', 
			'description' => 'Vertebral', 'middle' => 'true', 'paired' => false, 'articulated' => true, 'refit' => false, 'morphology' => true,  'zones' => true, 'measurements' => false,  'methods' => true, 'mni' => true, 'dental' => false, 
			'image_zones' => 'thoracic_500.png', 'image_measurements' => null, 'measurements_help_url' => '', 'zones_help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/zones/#thoracic-and-lumbar-vertebrae',
            'methods_age' => true, 'methods_sex' => false, 'methods_ancestry' => false, 'methods_stature' => false,
            'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
		(!$bone->exists) ? $bone->fill($data)->save() : $bone->fill(array_except($data, ['created_at']))->save();

        $bone = SkeletalBone::firstOrNew(['name' => 'Lumbar vertebra 3/4']);
        $data = array('name' => 'Lumbar vertebra 3/4',  'search_name' => 'lumbar vertebra 3/4', 'category'=> 'Vertebral Column', 'type' => 'Irregular', 'group' => 'Axial', 
			'description' => 'Vertebral', 'middle' => 'true', 'paired' => false, 'articulated' => true, 'refit' => false, 'morphology' => true,  'zones' => true, 'measurements' => false,  'methods' => true, 'mni' => false, 'dental' => false,
			'image_zones' => 'thoracic_500.png', 'image_measurements' => null, 'measurements_help_url' => '', 'zones_help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/zones/#thoracic-and-lumbar-vertebrae',
            'methods_age' => true, 'methods_sex' => false, 'methods_ancestry' => false, 'methods_stature' => false,
            'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
		(!$bone->exists) ? $bone->fill($data)->save() : $bone->fill(array_except($data, ['created_at']))->save();

        $bone = SkeletalBone::firstOrNew(['name' => 'Lumbar vertebra 4']);
        $data = array('name' => 'Lumbar vertebra 4',  'search_name' => 'lumbar vertebra 4', 'category'=> 'Vertebral Column', 'type' => 'Irregular', 'group' => 'Axial', 
			'description' => 'Vertebral', 'middle' => 'true', 'paired' => false, 'articulated' => true, 'refit' => false, 'morphology' => true,  'zones' => true, 'measurements' => false,  'methods' => true, 'mni' => true, 'dental' => false, 
			'image_zones' => 'thoracic_500.png', 'image_measurements' => null, 'measurements_help_url' => '', 'zones_help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/zones/#thoracic-and-lumbar-vertebrae',
            'methods_age' => true, 'methods_sex' => false, 'methods_ancestry' => false, 'methods_stature' => false,
            'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
		(!$bone->exists) ? $bone->fill($data)->save() : $bone->fill(array_except($data, ['created_at']))->save();

        $bone = SkeletalBone::firstOrNew(['name' => 'Lumbar vertebra 4/5']);
        $data = array('name' => 'Lumbar vertebra 4/5',  'search_name' => 'lumbar vertebra 4/5', 'category'=> 'Vertebral Column', 'type' => 'Irregular', 'group' => 'Axial', 
			'description' => 'Vertebral', 'middle' => 'true', 'paired' => false, 'articulated' => true, 'refit' => false, 'morphology' => true,  'zones' => true, 'measurements' => false,  'methods' => true, 'mni' => false, 'dental' => false,
			'image_zones' => 'thoracic_500.png', 'image_measurements' => null, 'measurements_help_url' => '', 'zones_help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/zones/#thoracic-and-lumbar-vertebrae',
            'methods_age' => true, 'methods_sex' => false, 'methods_ancestry' => false, 'methods_stature' => false,
            'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
		(!$bone->exists) ? $bone->fill($data)->save() : $bone->fill(array_except($data, ['created_at']))->save();

        $bone = SkeletalBone::firstOrNew(['name' => 'Lumbar vertebra 5']);
        $data = array('name' => 'Lumbar vertebra 5',  'search_name' => 'lumbar vertebra 5', 'category'=> 'Vertebral Column', 'type' => 'Irregular', 'group' => 'Axial', 
			'description' => 'Vertebral', 'middle' => 'true', 'paired' => false, 'articulated' => true, 'refit' => false, 'morphology' => true,  'zones' => true, 'measurements' => false,  'methods' => true, 'mni' => true, 'dental' => false, 
			'image_zones' => 'thoracic_500.png', 'image_measurements' => null, 'measurements_help_url' => '', 'zones_help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/zones/#thoracic-and-lumbar-vertebrae',
            'methods_age' => true, 'methods_sex' => false, 'methods_ancestry' => false, 'methods_stature' => false,
            'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
		(!$bone->exists) ? $bone->fill($data)->save() : $bone->fill(array_except($data, ['created_at']))->save();

        $bone = SkeletalBone::firstOrNew(['name' => 'Lumbar vertebra 5/Sacral vertebra 1']);
        $data = array('name' => 'Lumbar vertebra 5/Sacral vertebra 1',  'search_name' => 'lumbar vertebra 5/sacral vertebra 1', 'category'=> 'Vertebral Column', 'type' => 'Irregular', 'group' => 'Axial',
            'description' => 'Vertebral', 'middle' => 'true', 'paired' => false, 'articulated' => true, 'refit' => false, 'morphology' => false,  'zones' => true, 'measurements' => false,  'methods' => false, 'mni' => true, 'dental' => false,
            'image_zones' => 'thoracic_500.png', 'image_measurements' => null, 'measurements_help_url' => '', 'zones_help_url' => '',
            'methods_age' => false, 'methods_sex' => false, 'methods_ancestry' => false, 'methods_stature' => false, 
            'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$bone->exists) ? $bone->fill($data)->save() : $bone->fill(array_except($data, ['created_at']))->save();

        $bone = SkeletalBone::firstOrNew(['name' => 'Lunate']);
        $data = array('name' => 'Lunate',  'search_name' => 'lunate', 'category'=> 'Upper Extremity', 'type' => 'Irregular', 'group' => 'Appendicular', 
			'description' => 'Wrist', 'middle' => 'false', 'paired' => true, 'articulated' => true, 'refit' => false, 'morphology' => false,  'zones' => true, 'measurements' => true,  'methods' => true, 'mni' => true, 'dental' => false, 
			'image_zones' => 'hand_left_500.png', 'image_measurements' => 'hand_500.png', 'measurements_help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/measurements/#hands', 'zones_help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/zones/#hand',
            'methods_age' => true, 'methods_sex' => false, 'methods_ancestry' => false, 'methods_stature' => false,
            'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
		(!$bone->exists) ? $bone->fill($data)->save() : $bone->fill(array_except($data, ['created_at']))->save();

        $bone = SkeletalBone::firstOrNew(['name' => 'Malleus']);
        $data = array('name' => 'Malleus',  'search_name' => 'malleus', 'category'=> 'Cranial', 'type' => 'Irregular', 'group' => 'Axial', 
			'description' => 'Ear ossicle', 'middle' => 'false', 'paired' => true, 'articulated' => true, 'refit' => false, 'morphology' => false,  'zones' => true, 'measurements' => false,  'methods' => false, 'mni' => true, 'dental' => false,
			'image_zones' => 'ossicles_500.png', 'image_measurements' => null, 'measurements_help_url' => '', 'zones_help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/zones/#cranium',
            'methods_age' => false, 'methods_sex' => false, 'methods_ancestry' => false, 'methods_stature' => false, 
            'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
		(!$bone->exists) ? $bone->fill($data)->save() : $bone->fill(array_except($data, ['created_at']))->save();

        $bone = SkeletalBone::firstOrNew(['name' => 'Mandible']);
        $data = array('name' => 'Mandible',  'search_name' => 'mandible', 'category'=> 'Cranial', 'type' => 'Flat', 'group' => 'Axial', 
			'description' => 'Cranial', 'middle' => 'false', 'paired' => false, 'articulated' => true, 'refit' => false, 'morphology' => true,  'zones' => true, 'measurements' => true,  'methods' => true, 'mni' => true, 'dental' => true,
            'image_zones' => 'mandible_500.png', 'image_measurements' => 'mandible_500.png', 'measurements_help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/measurements/#mandible', 'zones_help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/zones/#mandible',
            'methods_age' => true, 'methods_sex' => true, 'methods_ancestry' => true, 'methods_stature' => false,
            'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt); 
		(!$bone->exists) ? $bone->fill($data)->save() : $bone->fill(array_except($data, ['created_at']))->save();

        $bone = SkeletalBone::firstOrNew(['name' => 'Manubrium']);
        $data = array('name' => 'Manubrium',  'search_name' => 'manubrium', 'category'=> 'Thoracic Cage', 'type' => 'Flat', 'group' => 'Axial', 
			'description' => 'Sternum', 'middle' => 'false', 'paired' => false, 'articulated' => true, 'refit' => false, 'morphology' => true,  'zones' => true, 'measurements' => false,  'methods' => true, 'mni' => true, 'dental' => false, 
			'image_zones' => 'sternum_500.png', 'image_measurements' => null, 'measurements_help_url' => '', 'zones_help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/zones/#sternum',
            'methods_age' => true, 'methods_sex' => false, 'methods_ancestry' => false, 'methods_stature' => false,
            'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
		(!$bone->exists) ? $bone->fill($data)->save() : $bone->fill(array_except($data, ['created_at']))->save();

        $bone = SkeletalBone::firstOrNew(['name' => 'Maxilla']);
        $data = array('name' => 'Maxilla',  'search_name' => 'maxilla', 'category'=> 'Cranial', 'type' => 'Irregular', 'group' => 'Axial', 
			'description' => 'Cranial', 'middle' => 'false', 'paired' => true, 'articulated' => true, 'refit' => false, 'morphology' => true,  'zones' => false, 'measurements' => false,  'methods' => true, 'mni' => true, 'dental' => true,
			'image_zones' => null, 'image_measurements' => null, 'measurements_help_url' => '', 'zones_help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/zones/#cranium',
            'methods_age' => true, 'methods_sex' => false, 'methods_ancestry' => false, 'methods_stature' => false,
            'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
		(!$bone->exists) ? $bone->fill($data)->save() : $bone->fill(array_except($data, ['created_at']))->save();

        $bone = SkeletalBone::firstOrNew(['name' => 'Metacarpal 1']);
        $data = array('name' => 'Metacarpal 1',  'search_name' => 'metacarpal 1', 'category'=> 'Upper Extremity', 'type' => 'Short bone', 'group' => 'Appendicular', 
			'description' => 'Hand', 'middle' => 'false', 'paired' => true, 'articulated' => true, 'refit' => false, 'morphology' => true,  'zones' => true, 'measurements' => true,  'methods' => true, 'mni' => true, 'dental' => false, 
			'image_zones' => 'hand_left_500.png', 'image_measurements' => 'hand_500.png', 'measurements_help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/measurements/#hands', 'zones_help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/zones/#hand',
            'methods_age' => true, 'methods_sex' => false, 'methods_ancestry' => false, 'methods_stature' => false,
            'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
		(!$bone->exists) ? $bone->fill($data)->save() : $bone->fill(array_except($data, ['created_at']))->save();

        $bone = SkeletalBone::firstOrNew(['name' => 'Metacarpal 2']);
        $data = array('name' => 'Metacarpal 2',  'search_name' => 'metacarpal 2', 'category'=> 'Upper Extremity', 'type' => 'Short bone', 'group' => 'Appendicular', 
			'description' => 'Hand', 'middle' => 'false', 'paired' => true, 'articulated' => true, 'refit' => false, 'morphology' => true,  'zones' => true, 'measurements' => true,  'methods' => true, 'mni' => true, 'dental' => false, 
			'image_zones' => 'hand_left_500.png', 'image_measurements' => 'hand_500.png', 'measurements_help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/measurements/#hands', 'zones_help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/zones/#hand',
            'methods_age' => true, 'methods_sex' => false, 'methods_ancestry' => false, 'methods_stature' => false,
            'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
		(!$bone->exists) ? $bone->fill($data)->save() : $bone->fill(array_except($data, ['created_at']))->save();

        $bone = SkeletalBone::firstOrNew(['name' => 'Metacarpal 3']);
        $data = array('name' => 'Metacarpal 3',  'search_name' => 'metacarpal 3', 'category'=> 'Upper Extremity', 'type' => 'Short bone', 'group' => 'Appendicular', 
			'description' => 'Hand', 'middle' => 'false', 'paired' => true, 'articulated' => true, 'refit' => false, 'morphology' => true,  'zones' => true, 'measurements' => true,  'methods' => true, 'mni' => true, 'dental' => false, 
			'image_zones' => 'hand_left_500.png', 'image_measurements' => 'hand_500.png', 'measurements_help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/measurements/#hands', 'zones_help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/zones/#hand',
            'methods_age' => true, 'methods_sex' => false, 'methods_ancestry' => false, 'methods_stature' => false,
            'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
		(!$bone->exists) ? $bone->fill($data)->save() : $bone->fill(array_except($data, ['created_at']))->save();

        $bone = SkeletalBone::firstOrNew(['name' => 'Metacarpal 4']);
        $data = array('name' => 'Metacarpal 4',  'search_name' => 'metacarpal 4', 'category'=> 'Upper Extremity', 'type' => 'Short bone', 'group' => 'Appendicular', 
			'description' => 'Hand', 'middle' => 'false', 'paired' => true, 'articulated' => true, 'refit' => false, 'morphology' => true,  'zones' => true, 'measurements' => true,  'methods' => true, 'mni' => true, 'dental' => false, 
			'image_zones' => 'hand_left_500.png', 'image_measurements' => 'hand_500.png', 'measurements_help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/measurements/#hands', 'zones_help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/zones/#hand',
            'methods_age' => true, 'methods_sex' => false, 'methods_ancestry' => false, 'methods_stature' => false,
            'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
		(!$bone->exists) ? $bone->fill($data)->save() : $bone->fill(array_except($data, ['created_at']))->save();

        $bone = SkeletalBone::firstOrNew(['name' => 'Metacarpal 5']);
        $data = array('name' => 'Metacarpal 5',  'search_name' => 'metacarpal 5', 'category'=> 'Upper Extremity', 'type' => 'Short bone', 'group' => 'Appendicular', 
			'description' => 'Hand', 'middle' => 'false', 'paired' => true, 'articulated' => true, 'refit' => false, 'morphology' => true,  'zones' => true, 'measurements' => true,  'methods' => true, 'mni' => true, 'dental' => false, 
			'image_zones' => 'hand_left_500.png', 'image_measurements' => 'hand_500.png', 'measurements_help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/measurements/#hands', 'zones_help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/zones/#hand',
            'methods_age' => true, 'methods_sex' => false, 'methods_ancestry' => false, 'methods_stature' => false,
            'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
		(!$bone->exists) ? $bone->fill($data)->save() : $bone->fill(array_except($data, ['created_at']))->save();

        $bone = SkeletalBone::firstOrNew(['name' => 'Metatarsal 1']);
        $data = array('name' => 'Metatarsal 1',  'search_name' => 'metatarsal 1', 'category'=> 'Lower Extremity', 'type' => 'Short bone', 'group' => 'Appendicular', 
			'description' => 'Foot', 'middle' => 'false', 'paired' => true, 'articulated' => true, 'refit' => false, 'morphology' => true,  'zones' => true, 'measurements' => true,  'methods' => true, 'mni' => true, 'dental' => false, 
			'image_zones' => 'foot_right_500.png', 'image_measurements' => 'foot_500.png', 'measurements_help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/measurements/#feet', 'zones_help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/zones/#foot',
            'methods_age' => true, 'methods_sex' => false, 'methods_ancestry' => false, 'methods_stature' => false,
            'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
		(!$bone->exists) ? $bone->fill($data)->save() : $bone->fill(array_except($data, ['created_at']))->save();

        $bone = SkeletalBone::firstOrNew(['name' => 'Metatarsal 2']);
        $data = array('name' => 'Metatarsal 2',  'search_name' => 'metatarsal 2', 'category'=> 'Lower Extremity', 'type' => 'Short bone', 'group' => 'Appendicular', 
			'description' => 'Foot', 'middle' => 'false', 'paired' => true, 'articulated' => true, 'refit' => false, 'morphology' => true,  'zones' => true, 'measurements' => true,  'methods' => true, 'mni' => true, 'dental' => false, 
			'image_zones' => 'foot_right_500.png', 'image_measurements' => 'foot_500.png', 'measurements_help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/measurements/#feet', 'zones_help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/zones/#foot',
            'methods_age' => true, 'methods_sex' => false, 'methods_ancestry' => false, 'methods_stature' => false,
            'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
		(!$bone->exists) ? $bone->fill($data)->save() : $bone->fill(array_except($data, ['created_at']))->save();

        $bone = SkeletalBone::firstOrNew(['name' => 'Metatarsal 3']);
        $data = array('name' => 'Metatarsal 3',  'search_name' => 'metatarsal 3', 'category'=> 'Lower Extremity', 'type' => 'Short bone', 'group' => 'Appendicular', 
			'description' => 'Foot', 'middle' => 'false', 'paired' => true, 'articulated' => true, 'refit' => false, 'morphology' => true,  'zones' => true, 'measurements' => true,  'methods' => true, 'mni' => true, 'dental' => false, 
			'image_zones' => 'foot_right_500.png', 'image_measurements' => 'foot_500.png', 'measurements_help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/measurements/#feet', 'zones_help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/zones/#foot',
            'methods_age' => true, 'methods_sex' => false, 'methods_ancestry' => false, 'methods_stature' => false,
            'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
		(!$bone->exists) ? $bone->fill($data)->save() : $bone->fill(array_except($data, ['created_at']))->save();

        $bone = SkeletalBone::firstOrNew(['name' => 'Metatarsal 4']);
        $data = array('name' => 'Metatarsal 4',  'search_name' => 'metatarsal 4', 'category'=> 'Lower Extremity', 'type' => 'Short bone', 'group' => 'Appendicular', 
			'description' => 'Foot', 'middle' => 'false', 'paired' => true, 'articulated' => true, 'refit' => false, 'morphology' => true,  'zones' => true, 'measurements' => true,  'methods' => true, 'mni' => true, 'dental' => false, 
			'image_zones' => 'foot_right_500.png', 'image_measurements' => 'foot_500.png', 'measurements_help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/measurements/#feet', 'zones_help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/zones/#foot',
            'methods_age' => true, 'methods_sex' => false, 'methods_ancestry' => false, 'methods_stature' => false,
            'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
		(!$bone->exists) ? $bone->fill($data)->save() : $bone->fill(array_except($data, ['created_at']))->save();

        $bone = SkeletalBone::firstOrNew(['name' => 'Metatarsal 5']);
        $data = array('name' => 'Metatarsal 5',  'search_name' => 'metatarsal 5', 'category'=> 'Lower Extremity', 'type' => 'Short bone', 'group' => 'Appendicular', 
			'description' => 'Foot', 'middle' => 'false', 'paired' => true, 'articulated' => true, 'refit' => false, 'morphology' => true,  'zones' => true, 'measurements' => true,  'methods' => true, 'mni' => true, 'dental' => false, 
			'image_zones' => 'foot_right_500.png', 'image_measurements' => 'foot_500.png', 'measurements_help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/measurements/#feet', 'zones_help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/zones/#foot',
            'methods_age' => true, 'methods_sex' => false, 'methods_ancestry' => false, 'methods_stature' => false,
            'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
		(!$bone->exists) ? $bone->fill($data)->save() : $bone->fill(array_except($data, ['created_at']))->save();

        $bone = SkeletalBone::firstOrNew(['name' => 'Nasal']);
        $data = array('name' => 'Nasal',  'search_name' => 'nasal', 'category'=> 'Cranial', 'type' => 'Flat', 'group' => 'Axial', 
			'description' => 'Cranial', 'middle' => 'false', 'paired' => true, 'articulated' => true, 'refit' => false, 'morphology' => false,  'zones' => false, 'measurements' => false,  'methods' => true, 'mni' => true, 'dental' => false,
			'image_zones' => null, 'image_measurements' => null, 'measurements_help_url' => '', 'zones_help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/zones/#cranium',
            'methods_age' => true, 'methods_sex' => false, 'methods_ancestry' => false, 'methods_stature' => false,
            'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
		(!$bone->exists) ? $bone->fill($data)->save() : $bone->fill(array_except($data, ['created_at']))->save();

        $bone = SkeletalBone::firstOrNew(['name' => 'Navicular']);
        $data = array('name' => 'Navicular',  'search_name' => 'navicular', 'category'=> 'Lower Extremity', 'type' => 'Irregular', 'group' => 'Appendicular', 
			'description' => 'Ankle', 'middle' => 'false', 'paired' => true, 'articulated' => true, 'refit' => false, 'morphology' => false,  'zones' => true, 'measurements' => true,  'methods' => true, 'mni' => true, 'dental' => false, 
			'image_zones' => 'foot_right_500.png', 'image_measurements' => 'foot_500.png', 'measurements_help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/measurements/#feet', 'zones_help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/zones/#foot',
            'methods_age' => true, 'methods_sex' => false, 'methods_ancestry' => false, 'methods_stature' => false,
            'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
		(!$bone->exists) ? $bone->fill($data)->save() : $bone->fill(array_except($data, ['created_at']))->save();

        $bone = SkeletalBone::firstOrNew(['name' => 'Occipital']);
        $data = array('name' => 'Occipital',  'search_name' => 'occipital', 'category'=> 'Cranial', 'type' => 'Flat', 'group' => 'Axial', 
			'description' => 'Cranial', 'middle' => 'false', 'paired' => false, 'articulated' => true, 'refit' => false, 'morphology' => true,  'zones' => false, 'measurements' => false,  'methods' => true, 'mni' => true, 'dental' => false,
			'image_zones' => null, 'image_measurements' => null, 'measurements_help_url' => '', 'zones_help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/zones/#cranium',
            'methods_age' => true, 'methods_sex' => true, 'methods_ancestry' => false, 'methods_stature' => false,
            'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
		(!$bone->exists) ? $bone->fill($data)->save() : $bone->fill(array_except($data, ['created_at']))->save();

        $bone = SkeletalBone::firstOrNew(['name' => 'Os coxa']);
        $data = array('name' => 'Os coxa',  'search_name' => 'os coxa', 'category'=> 'Pelvic Girdle', 'type' => 'Irregular', 'group' => 'Axial', 
			'description' => 'Pelvis', 'middle' => 'false', 'paired' => true, 'articulated' => true, 'refit' => false, 'morphology' => true,  'zones' => true, 'measurements' => true,  'methods' => true, 'mni' => true, 'dental' => false,
            'image_zones' => 'oscoxa_left_500.png', 'image_measurements' => 'oscoxa_500.png', 'measurements_help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/measurements/#os-coxa', 'zones_help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/zones/#os-coxa',
            'methods_age' => true, 'methods_sex' => true, 'methods_ancestry' => false, 'methods_stature' => false,
            'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
		(!$bone->exists) ? $bone->fill($data)->save() : $bone->fill(array_except($data, ['created_at']))->save();

        $bone = SkeletalBone::firstOrNew(['name' => 'Ossified cartilage']);
        $data = array('name' => 'Ossified cartilage',  'search_name' => 'ossified cartilage', 'category'=> 'Other', 'type' => 'N/A', 'group' => 'Axial', 
			'description' => 'N/A', 'middle' => 'false', 'paired' => false, 'articulated' => false, 'refit' => false, 'morphology' => false,  'zones' => false, 'measurements' => false,  'methods' => false, 'mni' => false, 'dental' => false,
			'image_zones' => null, 'image_measurements' => null, 'measurements_help_url' => '', 'zones_help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/zones/#postcranial-remains',
            'methods_age' => false, 'methods_sex' => false, 'methods_ancestry' => false, 'methods_stature' => false, 
            'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
		(!$bone->exists) ? $bone->fill($data)->save() : $bone->fill(array_except($data, ['created_at']))->save();

        $bone = SkeletalBone::firstOrNew(['name' => 'Palatine']);
        $data = array('name' => 'Palatine',  'search_name' => 'palatine', 'category'=> 'Cranial', 'type' => 'Flat', 'group' => 'Axial', 
			'description' => 'Cranial', 'middle' => 'false', 'paired' => true, 'articulated' => true, 'refit' => false, 'morphology' => false,  'zones' => false, 'measurements' => false,  'methods' => true, 'mni' => true, 'dental' => false,
			'image_zones' => null, 'image_measurements' => null, 'measurements_help_url' => '', 'zones_help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/zones/#cranium',
            'methods_age' => true, 'methods_sex' => false, 'methods_ancestry' => false, 'methods_stature' => false,
            'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
		(!$bone->exists) ? $bone->fill($data)->save() : $bone->fill(array_except($data, ['created_at']))->save();

        $bone = SkeletalBone::firstOrNew(['name' => 'Parietal']);
        $data = array('name' => 'Parietal',  'search_name' => 'parietal', 'category'=> 'Cranial', 'type' => 'Flat', 'group' => 'Axial', 
			'description' => 'Cranial', 'middle' => 'false', 'paired' => true, 'articulated' => true, 'refit' => false, 'morphology' => true,  'zones' => false, 'measurements' => false,  'methods' => true, 'mni' => true, 'dental' => false,
			'image_zones' => null, 'image_measurements' => null, 'measurements_help_url' => '', 'zones_help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/zones/#cranium',
            'methods_age' => true, 'methods_sex' => false, 'methods_ancestry' => false, 'methods_stature' => false,
            'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
		(!$bone->exists) ? $bone->fill($data)->save() : $bone->fill(array_except($data, ['created_at']))->save();

        $bone = SkeletalBone::firstOrNew(['name' => 'Patella']);
        $data = array('name' => 'Patella',  'search_name' => 'patella', 'category'=> 'Lower Extremity', 'type' => 'Irregular', 'group' => 'Appendicular', 
			'description' => 'Knee', 'middle' => 'false', 'paired' => true, 'articulated' => true, 'refit' => false, 'morphology' => true,  'zones' => true, 'measurements' => true,  'methods' => true, 'mni' => true, 'dental' => false,
            'image_zones' => 'patella_500.png', 'image_measurements' => 'patella_500.png', 'measurements_help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/measurements/#patella', 'zones_help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/zones/#patella',
            'methods_age' => true, 'methods_sex' => false, 'methods_ancestry' => false, 'methods_stature' => false,
            'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
		(!$bone->exists) ? $bone->fill($data)->save() : $bone->fill(array_except($data, ['created_at']))->save();

        $bone = SkeletalBone::firstOrNew(['name' => 'Pisiform']);
        $data = array('name' => 'Pisiform',  'search_name' => 'pisiform', 'category'=> 'Upper Extremity', 'type' => 'Irregular', 'group' => 'Appendicular', 
			'description' => 'Wrist', 'middle' => 'false', 'paired' => true, 'articulated' => true, 'refit' => false, 'morphology' => false,  'zones' => true, 'measurements' => true,  'methods' => true, 'mni' => true, 'dental' => false, 
			'image_zones' => 'hand_left_500.png', 'image_measurements' => 'hand_500.png', 'measurements_help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/measurements/#hands', 'zones_help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/zones/#hand',
            'methods_age' => true, 'methods_sex' => false, 'methods_ancestry' => false, 'methods_stature' => false,
            'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
		(!$bone->exists) ? $bone->fill($data)->save() : $bone->fill(array_except($data, ['created_at']))->save();

        $bone = SkeletalBone::firstOrNew(['name' => 'Proximal manual phalanx 1']);
        $data = array('name' => 'Proximal manual phalanx 1',  'search_name' => 'proximal manual phalanx 1', 'category'=> 'Upper Extremity', 'type' => 'Short bone', 'group' => 'Appendicular', 
			'description' => 'Hand', 'middle' => 'false', 'paired' => true, 'articulated' => true, 'refit' => false, 'morphology' => false,  'zones' => true, 'measurements' => false,  'methods' => true, 'mni' => true, 'dental' => false, 
			'image_zones' => 'hand_left_500.png', 'image_measurements' => null, 'measurements_help_url' => '', 'zones_help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/zones/#hand',
            'methods_age' => true, 'methods_sex' => false, 'methods_ancestry' => false, 'methods_stature' => false,
            'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
		(!$bone->exists) ? $bone->fill($data)->save() : $bone->fill(array_except($data, ['created_at']))->save();

        $bone = SkeletalBone::firstOrNew(['name' => 'Proximal manual phalanx 2']);
        $data = array('name' => 'Proximal manual phalanx 2',  'search_name' => 'proximal manual phalanx 2', 'category'=> 'Upper Extremity', 'type' => 'Short bone', 'group' => 'Appendicular', 
			'description' => 'Hand', 'middle' => 'false', 'paired' => true, 'articulated' => true, 'refit' => false, 'morphology' => false,  'zones' => true, 'measurements' => false,  'methods' => true, 'mni' => true, 'dental' => false, 
			'image_zones' => 'hand_left_500.png', 'image_measurements' => null, 'measurements_help_url' => '', 'zones_help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/zones/#hand',
            'methods_age' => true, 'methods_sex' => false, 'methods_ancestry' => false, 'methods_stature' => false,
            'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
		(!$bone->exists) ? $bone->fill($data)->save() : $bone->fill(array_except($data, ['created_at']))->save();

        $bone = SkeletalBone::firstOrNew(['name' => 'Proximal manual phalanx 3']);
        $data = array('name' => 'Proximal manual phalanx 3',  'search_name' => 'proximal manual phalanx 3', 'category'=> 'Upper Extremity', 'type' => 'Short bone', 'group' => 'Appendicular', 
			'description' => 'Hand', 'middle' => 'false', 'paired' => true, 'articulated' => true, 'refit' => false, 'morphology' => false,  'zones' => true, 'measurements' => false,  'methods' => true, 'mni' => true, 'dental' => false, 
			'image_zones' => 'hand_left_500.png', 'image_measurements' => null, 'measurements_help_url' => '', 'zones_help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/zones/#hand',
            'methods_age' => true, 'methods_sex' => false, 'methods_ancestry' => false, 'methods_stature' => false,
            'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
		(!$bone->exists) ? $bone->fill($data)->save() : $bone->fill(array_except($data, ['created_at']))->save();

        $bone = SkeletalBone::firstOrNew(['name' => 'Proximal manual phalanx 4']);
        $data = array('name' => 'Proximal manual phalanx 4',  'search_name' => 'proximal manual phalanx 4', 'category'=> 'Upper Extremity', 'type' => 'Short bone', 'group' => 'Appendicular', 
			'description' => 'Hand', 'middle' => 'false', 'paired' => true, 'articulated' => true, 'refit' => false, 'morphology' => false,  'zones' => true, 'measurements' => false,  'methods' => true, 'mni' => true, 'dental' => false, 
			'image_zones' => 'hand_left_500.png', 'image_measurements' => null, 'measurements_help_url' => '', 'zones_help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/zones/#hand',
            'methods_age' => true, 'methods_sex' => false, 'methods_ancestry' => false, 'methods_stature' => false,
            'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
		(!$bone->exists) ? $bone->fill($data)->save() : $bone->fill(array_except($data, ['created_at']))->save();

        $bone = SkeletalBone::firstOrNew(['name' => 'Proximal manual phalanx 5']);
        $data = array('name' => 'Proximal manual phalanx 5',  'search_name' => 'proximal manual phalanx 5', 'category'=> 'Upper Extremity', 'type' => 'Short bone', 'group' => 'Appendicular', 
			'description' => 'Hand', 'middle' => 'false', 'paired' => true, 'articulated' => true, 'refit' => false, 'morphology' => false,  'zones' => true, 'measurements' => false,  'methods' => true, 'mni' => true, 'dental' => false, 
			'image_zones' => 'hand_left_500.png', 'image_measurements' => null, 'measurements_help_url' => '', 'zones_help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/zones/#hand',
            'methods_age' => true, 'methods_sex' => false, 'methods_ancestry' => false, 'methods_stature' => false,
            'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
		(!$bone->exists) ? $bone->fill($data)->save() : $bone->fill(array_except($data, ['created_at']))->save();

        $bone = SkeletalBone::firstOrNew(['name' => 'Proximal pedal phalanx 1']);
        $data = array('name' => 'Proximal pedal phalanx 1',  'search_name' => 'proximal pedal phalanx 1', 'category'=> 'Lower Extremity', 'type' => 'Short bone', 'group' => 'Appendicular', 
			'description' => 'Foot', 'middle' => 'false', 'paired' => true, 'articulated' => true, 'refit' => false, 'morphology' => false,  'zones' => true, 'measurements' => false,  'methods' => true, 'mni' => true, 'dental' => false, 
			'image_zones' => 'foot_right_500.png', 'image_measurements' => null, 'measurements_help_url' => '', 'zones_help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/zones/#foot',
            'methods_age' => true, 'methods_sex' => false, 'methods_ancestry' => false, 'methods_stature' => false,
            'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
		(!$bone->exists) ? $bone->fill($data)->save() : $bone->fill(array_except($data, ['created_at']))->save();

        $bone = SkeletalBone::firstOrNew(['name' => 'Proximal pedal phalanx 2']);
        $data = array('name' => 'Proximal pedal phalanx 2',  'search_name' => 'proximal pedal phalanx 2', 'category'=> 'Lower Extremity', 'type' => 'Short bone', 'group' => 'Appendicular', 
			'description' => 'Foot', 'middle' => 'false', 'paired' => true, 'articulated' => true, 'refit' => false, 'morphology' => false,  'zones' => true, 'measurements' => false,  'methods' => true, 'mni' => true, 'dental' => false, 
			'image_zones' => 'foot_right_500.png', 'image_measurements' => null, 'measurements_help_url' => '', 'zones_help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/zones/#foot',
            'methods_age' => true, 'methods_sex' => false, 'methods_ancestry' => false, 'methods_stature' => false,
            'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
		(!$bone->exists) ? $bone->fill($data)->save() : $bone->fill(array_except($data, ['created_at']))->save();

        $bone = SkeletalBone::firstOrNew(['name' => 'Proximal pedal phalanx 3']);
        $data = array('name' => 'Proximal pedal phalanx 3',  'search_name' => 'proximal pedal phalanx 3', 'category'=> 'Lower Extremity', 'type' => 'Short bone', 'group' => 'Appendicular', 
			'description' => 'Foot', 'middle' => 'false', 'paired' => true, 'articulated' => true, 'refit' => false, 'morphology' => false,  'zones' => true, 'measurements' => false,  'methods' => true, 'mni' => true, 'dental' => false, 
			'image_zones' => 'foot_right_500.png', 'image_measurements' => null, 'measurements_help_url' => '', 'zones_help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/zones/#foot',
            'methods_age' => true, 'methods_sex' => false, 'methods_ancestry' => false, 'methods_stature' => false,
            'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
		(!$bone->exists) ? $bone->fill($data)->save() : $bone->fill(array_except($data, ['created_at']))->save();

        $bone = SkeletalBone::firstOrNew(['name' => 'Proximal pedal phalanx 4']);
        $data = array('name' => 'Proximal pedal phalanx 4',  'search_name' => 'proximal pedal phalanx 4', 'category'=> 'Lower Extremity', 'type' => 'Short bone', 'group' => 'Appendicular', 
			'description' => 'Foot', 'middle' => 'false', 'paired' => true, 'articulated' => true, 'refit' => false, 'morphology' => false,  'zones' => true, 'measurements' => false,  'methods' => true, 'mni' => true, 'dental' => false, 
			'image_zones' => 'foot_right_500.png', 'image_measurements' => null, 'measurements_help_url' => '', 'zones_help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/zones/#foot',
            'methods_age' => true, 'methods_sex' => false, 'methods_ancestry' => false, 'methods_stature' => false,
            'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
		(!$bone->exists) ? $bone->fill($data)->save() : $bone->fill(array_except($data, ['created_at']))->save();

        $bone = SkeletalBone::firstOrNew(['name' => 'Proximal pedal phalanx 5']);
        $data = array('name' => 'Proximal pedal phalanx 5',  'search_name' => 'proximal pedal phalanx 5', 'category'=> 'Lower Extremity', 'type' => 'Short bone', 'group' => 'Appendicular', 
			'description' => 'Foot', 'middle' => 'false', 'paired' => true, 'articulated' => true, 'refit' => false, 'morphology' => false,  'zones' => true, 'measurements' => false,  'methods' => true, 'mni' => true, 'dental' => false, 
			'image_zones' => 'foot_right_500.png', 'image_measurements' => null, 'measurements_help_url' => '', 'zones_help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/zones/#foot',
            'methods_age' => true, 'methods_sex' => false, 'methods_ancestry' => false, 'methods_stature' => false,
            'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
		(!$bone->exists) ? $bone->fill($data)->save() : $bone->fill(array_except($data, ['created_at']))->save();

        $bone = SkeletalBone::firstOrNew(['name' => 'Radius']);
        $data = array('name' => 'Radius',  'search_name' => 'radius', 'category'=> 'Upper Extremity', 'type' => 'Long bone', 'group' => 'Appendicular', 
			'description' => 'Arm', 'middle' => 'false', 'paired' => true, 'articulated' => true, 'refit' => false, 'morphology' => true,  'zones' => true, 'measurements' => true,  'methods' => true, 'mni' => true, 'dental' => false,
            'image_zones' => 'radius_left_500.png', 'image_measurements' => 'radius_500.png', 'measurements_help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/measurements/#radius', 'zones_help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/zones/#radius',
            'methods_age' => true, 'methods_sex' => false, 'methods_ancestry' => false, 'methods_stature' => false,
            'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
		(!$bone->exists) ? $bone->fill($data)->save() : $bone->fill(array_except($data, ['created_at']))->save();

        $bone = SkeletalBone::firstOrNew(['name' => 'Rib 1']);
        $data = array('name' => 'Rib 1',  'search_name' => 'rib 1', 'category'=> 'Thoracic Cage', 'type' => 'Flat', 'group' => 'Axial', 
			'description' => 'Rib', 'middle' => 'false', 'paired' => true, 'articulated' => true, 'refit' => false, 'morphology' => true,  'zones' => true, 'measurements' => false,  'methods' => true, 'mni' => true, 'dental' => false,
            'image_zones' => 'rib01_500.png', 'image_measurements' => null, 'measurements_help_url' => '', 'zones_help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/zones/#rib-1',
            'methods_age' => true, 'methods_sex' => false, 'methods_ancestry' => false, 'methods_stature' => false,
            'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
		(!$bone->exists) ? $bone->fill($data)->save() : $bone->fill(array_except($data, ['created_at']))->save();

        $bone = SkeletalBone::firstOrNew(['name' => 'Rib 10']);
        $data = array('name' => 'Rib 10',  'search_name' => 'rib 10', 'category'=> 'Thoracic Cage', 'type' => 'Flat', 'group' => 'Axial', 
			'description' => 'Rib', 'middle' => 'false', 'paired' => true, 'articulated' => true, 'refit' => false, 'morphology' => true,  'zones' => true, 'measurements' => false,  'methods' => true, 'mni' => true, 'dental' => false, 
			'image_zones' => 'ribs_500.png', 'image_measurements' => null, 'measurements_help_url' => '', 'zones_help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/zones/#ribs-2-12',
            'methods_age' => true, 'methods_sex' => false, 'methods_ancestry' => false, 'methods_stature' => false,
            'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
		(!$bone->exists) ? $bone->fill($data)->save() : $bone->fill(array_except($data, ['created_at']))->save();

        $bone = SkeletalBone::firstOrNew(['name' => 'Rib 10/11']);
        $data = array('name' => 'Rib 10/11',  'search_name' => 'rib 10/11', 'category'=> 'Thoracic Cage', 'type' => 'Flat', 'group' => 'Axial', 
			'description' => 'Rib', 'middle' => 'false', 'paired' => true, 'articulated' => true, 'refit' => false, 'morphology' => true,  'zones' => true, 'measurements' => false,  'methods' => true, 'mni' => false, 'dental' => false,
			'image_zones' => 'ribs_500.png', 'image_measurements' => null, 'measurements_help_url' => '', 'zones_help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/zones/#ribs-2-12',
            'methods_age' => true, 'methods_sex' => false, 'methods_ancestry' => false, 'methods_stature' => false,
            'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
		(!$bone->exists) ? $bone->fill($data)->save() : $bone->fill(array_except($data, ['created_at']))->save();

        $bone = SkeletalBone::firstOrNew(['name' => 'Rib 11']);
        $data = array('name' => 'Rib 11',  'search_name' => 'rib 11', 'category'=> 'Thoracic Cage', 'type' => 'Flat', 'group' => 'Axial', 
			'description' => 'Rib', 'middle' => 'false', 'paired' => true, 'articulated' => true, 'refit' => false, 'morphology' => true,  'zones' => true, 'measurements' => false,  'methods' => true, 'mni' => true, 'dental' => false, 
			'image_zones' => 'ribs_500.png', 'image_measurements' => null, 'measurements_help_url' => '', 'zones_help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/zones/#ribs-2-12',
            'methods_age' => true, 'methods_sex' => false, 'methods_ancestry' => false, 'methods_stature' => false,
            'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
		(!$bone->exists) ? $bone->fill($data)->save() : $bone->fill(array_except($data, ['created_at']))->save();

        $bone = SkeletalBone::firstOrNew(['name' => 'Rib 11/12']);
        $data = array('name' => 'Rib 11/12',  'search_name' => 'rib 11/12', 'category'=> 'Thoracic Cage', 'type' => 'Flat', 'group' => 'Axial', 
			'description' => 'Rib', 'middle' => 'false', 'paired' => true, 'articulated' => true, 'refit' => false, 'morphology' => true,  'zones' => true, 'measurements' => false,  'methods' => true, 'mni' => false, 'dental' => false,
			'image_zones' => 'ribs_500.png', 'image_measurements' => null, 'measurements_help_url' => '', 'zones_help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/zones/#ribs-2-12',
            'methods_age' => true, 'methods_sex' => false, 'methods_ancestry' => false, 'methods_stature' => false,
            'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
		(!$bone->exists) ? $bone->fill($data)->save() : $bone->fill(array_except($data, ['created_at']))->save();

        $bone = SkeletalBone::firstOrNew(['name' => 'Rib 12']);
        $data = array('name' => 'Rib 12',  'search_name' => 'rib 12', 'category'=> 'Thoracic Cage', 'type' => 'Flat', 'group' => 'Axial', 
			'description' => 'Rib', 'middle' => 'false', 'paired' => true, 'articulated' => true, 'refit' => false, 'morphology' => true,  'zones' => true, 'measurements' => false,  'methods' => true, 'mni' => true, 'dental' => false, 
			'image_zones' => 'ribs_500.png', 'image_measurements' => null, 'measurements_help_url' => '', 'zones_help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/zones/#ribs-2-12',
            'methods_age' => true, 'methods_sex' => false, 'methods_ancestry' => false, 'methods_stature' => false,
            'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
		(!$bone->exists) ? $bone->fill($data)->save() : $bone->fill(array_except($data, ['created_at']))->save();

        $bone = SkeletalBone::firstOrNew(['name' => 'Rib 2']);
        $data = array('name' => 'Rib 2',  'search_name' => 'rib 2', 'category'=> 'Thoracic Cage', 'type' => 'Flat', 'group' => 'Axial', 
			'description' => 'Rib', 'middle' => 'false', 'paired' => true, 'articulated' => true, 'refit' => false, 'morphology' => true,  'zones' => true, 'measurements' => false,  'methods' => true, 'mni' => true, 'dental' => false,
            'image_zones' => 'ribs_500.png', 'image_measurements' => null, 'measurements_help_url' => '', 'zones_help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/zones/#ribs-2-12',
            'methods_age' => true, 'methods_sex' => false, 'methods_ancestry' => false, 'methods_stature' => false,
            'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
		(!$bone->exists) ? $bone->fill($data)->save() : $bone->fill(array_except($data, ['created_at']))->save();

        $bone = SkeletalBone::firstOrNew(['name' => 'Rib 2/3']);
        $data = array('name' => 'Rib 2/3',  'search_name' => 'rib 2/3', 'category'=> 'Thoracic Cage', 'type' => 'Flat', 'group' => 'Axial', 
			'description' => 'Rib', 'middle' => 'false', 'paired' => true, 'articulated' => true, 'refit' => false, 'morphology' => true,  'zones' => true, 'measurements' => false,  'methods' => true, 'mni' => false, 'dental' => false,
			'image_zones' => 'ribs_500.png', 'image_measurements' => null, 'measurements_help_url' => '', 'zones_help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/zones/#ribs-2-12',
            'methods_age' => true, 'methods_sex' => false, 'methods_ancestry' => false, 'methods_stature' => false,
            'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
		(!$bone->exists) ? $bone->fill($data)->save() : $bone->fill(array_except($data, ['created_at']))->save();

        $bone = SkeletalBone::firstOrNew(['name' => 'Rib 3']);
        $data = array('name' => 'Rib 3',  'search_name' => 'rib 3', 'category'=> 'Thoracic Cage', 'type' => 'Flat', 'group' => 'Axial', 
			'description' => 'Rib', 'middle' => 'false', 'paired' => true, 'articulated' => true, 'refit' => false, 'morphology' => true,  'zones' => true, 'measurements' => false,  'methods' => true, 'mni' => true, 'dental' => false, 
			'image_zones' => 'ribs_500.png', 'image_measurements' => null, 'measurements_help_url' => '', 'zones_help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/zones/#ribs-2-12',
            'methods_age' => true, 'methods_sex' => false, 'methods_ancestry' => false, 'methods_stature' => false,
            'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
		(!$bone->exists) ? $bone->fill($data)->save() : $bone->fill(array_except($data, ['created_at']))->save();

        $bone = SkeletalBone::firstOrNew(['name' => 'Rib 3/4']);
        $data = array('name' => 'Rib 3/4',  'search_name' => 'rib 3/4', 'category'=> 'Thoracic Cage', 'type' => 'Flat', 'group' => 'Axial', 
			'description' => 'Rib', 'middle' => 'false', 'paired' => true, 'articulated' => true, 'refit' => false, 'morphology' => true,  'zones' => true, 'measurements' => false,  'methods' => true, 'mni' => false, 'dental' => false,
			'image_zones' => 'ribs_500.png', 'image_measurements' => null, 'measurements_help_url' => '', 'zones_help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/zones/#ribs-2-12',
            'methods_age' => true, 'methods_sex' => false, 'methods_ancestry' => false, 'methods_stature' => false,
            'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
		(!$bone->exists) ? $bone->fill($data)->save() : $bone->fill(array_except($data, ['created_at']))->save();

        $bone = SkeletalBone::firstOrNew(['name' => 'Rib 4']);
        $data = array('name' => 'Rib 4',  'search_name' => 'rib 4', 'category'=> 'Thoracic Cage', 'type' => 'Flat', 'group' => 'Axial', 
			'description' => 'Rib', 'middle' => 'false', 'paired' => true, 'articulated' => true, 'refit' => false, 'morphology' => true,  'zones' => true, 'measurements' => false,  'methods' => true, 'mni' => true, 'dental' => false, 
			'image_zones' => 'ribs_500.png', 'image_measurements' => null, 'measurements_help_url' => '', 'zones_help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/zones/#ribs-2-12',
            'methods_age' => true, 'methods_sex' => false, 'methods_ancestry' => false, 'methods_stature' => false,
            'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
		(!$bone->exists) ? $bone->fill($data)->save() : $bone->fill(array_except($data, ['created_at']))->save();

        $bone = SkeletalBone::firstOrNew(['name' => 'Rib 5']);
        $data = array('name' => 'Rib 5',  'search_name' => 'rib 5', 'category'=> 'Thoracic Cage', 'type' => 'Flat', 'group' => 'Axial', 
			'description' => 'Rib', 'middle' => 'false', 'paired' => true, 'articulated' => true, 'refit' => false, 'morphology' => true,  'zones' => true, 'measurements' => false,  'methods' => true, 'mni' => true, 'dental' => false, 
			'image_zones' => 'ribs_500.png', 'image_measurements' => null, 'measurements_help_url' => '', 'zones_help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/zones/#ribs-2-12',
            'methods_age' => true, 'methods_sex' => false, 'methods_ancestry' => false, 'methods_stature' => false,
            'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
		(!$bone->exists) ? $bone->fill($data)->save() : $bone->fill(array_except($data, ['created_at']))->save();

        $bone = SkeletalBone::firstOrNew(['name' => 'Rib 6']);
        $data = array('name' => 'Rib 6',  'search_name' => 'rib 6', 'category'=> 'Thoracic Cage', 'type' => 'Flat', 'group' => 'Axial', 
			'description' => 'Rib', 'middle' => 'false', 'paired' => true, 'articulated' => true, 'refit' => false, 'morphology' => true,  'zones' => true, 'measurements' => false,  'methods' => true, 'mni' => true, 'dental' => false, 
			'image_zones' => 'ribs_500.png', 'image_measurements' => null, 'measurements_help_url' => '', 'zones_help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/zones/#ribs-2-12',
            'methods_age' => true, 'methods_sex' => false, 'methods_ancestry' => false, 'methods_stature' => false,
            'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
		(!$bone->exists) ? $bone->fill($data)->save() : $bone->fill(array_except($data, ['created_at']))->save();

        $bone = SkeletalBone::firstOrNew(['name' => 'Rib 7']);
        $data = array('name' => 'Rib 7',  'search_name' => 'rib 7', 'category'=> 'Thoracic Cage', 'type' => 'Flat', 'group' => 'Axial', 
			'description' => 'Rib', 'middle' => 'false', 'paired' => true, 'articulated' => true, 'refit' => false, 'morphology' => true,  'zones' => true, 'measurements' => false,  'methods' => true, 'mni' => true, 'dental' => false, 
			'image_zones' => 'ribs_500.png', 'image_measurements' => null, 'measurements_help_url' => '', 'zones_help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/zones/#ribs-2-12',
            'methods_age' => true, 'methods_sex' => false, 'methods_ancestry' => false, 'methods_stature' => false,
            'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
		(!$bone->exists) ? $bone->fill($data)->save() : $bone->fill(array_except($data, ['created_at']))->save();

        $bone = SkeletalBone::firstOrNew(['name' => 'Rib 8']);
        $data = array('name' => 'Rib 8',  'search_name' => 'rib 8', 'category'=> 'Thoracic Cage', 'type' => 'Flat', 'group' => 'Axial', 
			'description' => 'Rib', 'middle' => 'false', 'paired' => true, 'articulated' => true, 'refit' => false, 'morphology' => true,  'zones' => true, 'measurements' => false,  'methods' => true, 'mni' => true, 'dental' => false, 
			'image_zones' => 'ribs_500.png', 'image_measurements' => null, 'measurements_help_url' => '', 'zones_help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/zones/#ribs-2-12',
            'methods_age' => true, 'methods_sex' => false, 'methods_ancestry' => false, 'methods_stature' => false,
            'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
		(!$bone->exists) ? $bone->fill($data)->save() : $bone->fill(array_except($data, ['created_at']))->save();

        $bone = SkeletalBone::firstOrNew(['name' => 'Rib 9']);
        $data = array('name' => 'Rib 9',  'search_name' => 'rib 9', 'category'=> 'Thoracic Cage', 'type' => 'Flat', 'group' => 'Axial', 
			'description' => 'Rib', 'middle' => 'false', 'paired' => true, 'articulated' => true, 'refit' => false, 'morphology' => true,  'zones' => true, 'measurements' => false,  'methods' => true, 'mni' => true, 'dental' => false, 
			'image_zones' => 'ribs_500.png', 'image_measurements' => null, 'measurements_help_url' => '', 'zones_help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/zones/#ribs-2-12',
            'methods_age' => true, 'methods_sex' => false, 'methods_ancestry' => false, 'methods_stature' => false,
            'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
		(!$bone->exists) ? $bone->fill($data)->save() : $bone->fill(array_except($data, ['created_at']))->save();

        $bone = SkeletalBone::firstOrNew(['name' => 'Sacral vertebra 1']);
        $data = array('name' => 'Sacral vertebra 1',  'search_name' => 'sacral vertebra 1', 'category'=> 'Vertebral Column', 'type' => 'Irregular', 'group' => 'Axial', 
			'description' => 'Vertebral', 'middle' => 'false', 'paired' => false, 'articulated' => true, 'refit' => false, 'morphology' => true,  'zones' => true, 'measurements' => false,  'methods' => true, 'mni' => true, 'dental' => false, 
			'image_zones' => 'sacrum_500.png', 'image_measurements' => null, 'measurements_help_url' => '', 'zones_help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/zones/#sacrum',
            'methods_age' => true, 'methods_sex' => false, 'methods_ancestry' => false, 'methods_stature' => false,
            'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
		(!$bone->exists) ? $bone->fill($data)->save() : $bone->fill(array_except($data, ['created_at']))->save();

        $bone = SkeletalBone::firstOrNew(['name' => 'Sacral vertebra 2']);
        $data = array('name' => 'Sacral vertebra 2',  'search_name' => 'sacral vertebra 2', 'category'=> 'Vertebral Column', 'type' => 'Irregular', 'group' => 'Axial', 
			'description' => 'Vertebral', 'middle' => 'false', 'paired' => false, 'articulated' => true, 'refit' => false, 'morphology' => true,  'zones' => true, 'measurements' => false,  'methods' => true, 'mni' => true, 'dental' => false, 
			'image_zones' => 'sacrum_500.png', 'image_measurements' => null, 'measurements_help_url' => '', 'zones_help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/zones/#sacrum',
            'methods_age' => true, 'methods_sex' => false, 'methods_ancestry' => false, 'methods_stature' => false,
            'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
		(!$bone->exists) ? $bone->fill($data)->save() : $bone->fill(array_except($data, ['created_at']))->save();

        $bone = SkeletalBone::firstOrNew(['name' => 'Sacral vertebra 3']);
        $data = array('name' => 'Sacral vertebra 3',  'search_name' => 'sacral vertebra 3', 'category'=> 'Vertebral Column', 'type' => 'Irregular', 'group' => 'Axial', 
			'description' => 'Vertebral', 'middle' => 'false', 'paired' => false, 'articulated' => true, 'refit' => false, 'morphology' => true,  'zones' => true, 'measurements' => false,  'methods' => true, 'mni' => true, 'dental' => false, 
			'image_zones' => 'sacrum_500.png', 'image_measurements' => null, 'measurements_help_url' => '', 'zones_help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/zones/#sacrum',
            'methods_age' => true, 'methods_sex' => false, 'methods_ancestry' => false, 'methods_stature' => false,
            'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
		(!$bone->exists) ? $bone->fill($data)->save() : $bone->fill(array_except($data, ['created_at']))->save();

        $bone = SkeletalBone::firstOrNew(['name' => 'Sacral vertebra 4']);
        $data = array('name' => 'Sacral vertebra 4',  'search_name' => 'sacral vertebra 4', 'category'=> 'Vertebral Column', 'type' => 'Irregular', 'group' => 'Axial', 
			'description' => 'Vertebral', 'middle' => 'false', 'paired' => false, 'articulated' => true, 'refit' => false, 'morphology' => true,  'zones' => true, 'measurements' => false,  'methods' => true, 'mni' => true, 'dental' => false, 
			'image_zones' => 'sacrum_500.png', 'image_measurements' => null, 'measurements_help_url' => '', 'zones_help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/zones/#sacrum',
            'methods_age' => true, 'methods_sex' => false, 'methods_ancestry' => false, 'methods_stature' => false,
            'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
		(!$bone->exists) ? $bone->fill($data)->save() : $bone->fill(array_except($data, ['created_at']))->save();

        $bone = SkeletalBone::firstOrNew(['name' => 'Sacral vertebra 5']);
        $data = array('name' => 'Sacral vertebra 5',  'search_name' => 'sacral vertebra 5', 'category'=> 'Vertebral Column', 'type' => 'Irregular', 'group' => 'Axial', 
			'description' => 'Vertebral', 'middle' => 'false', 'paired' => false, 'articulated' => true, 'refit' => false, 'morphology' => true,  'zones' => true, 'measurements' => false,  'methods' => true, 'mni' => true, 'dental' => false, 
			'image_zones' => 'sacrum_500.png', 'image_measurements' => null, 'measurements_help_url' => '', 'zones_help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/zones/#sacrum',
            'methods_age' => true, 'methods_sex' => false, 'methods_ancestry' => false, 'methods_stature' => false,
            'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
		(!$bone->exists) ? $bone->fill($data)->save() : $bone->fill(array_except($data, ['created_at']))->save();

        $bone = SkeletalBone::firstOrNew(['name' => 'Sacrum']);
        $data = array('name' => 'Sacrum',  'search_name' => 'sacrum', 'category'=> 'Vertebral Column', 'type' => 'Irregular', 'group' => 'Axial', 
			'description' => 'Vertebral', 'middle' => 'true', 'paired' => false, 'articulated' => true, 'refit' => false, 'morphology' => true,  'zones' => true, 'measurements' => true,  'methods' => true, 'mni' => true, 'dental' => false,
            'image_zones' => 'sacrum_500.png', 'image_measurements' => 'sacrum_500.png', 'measurements_help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/measurements/#sacrum', 'zones_help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/zones/#sacrum',
            'methods_age' => true, 'methods_sex' => false, 'methods_ancestry' => false, 'methods_stature' => false,
            'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt); 
		(!$bone->exists) ? $bone->fill($data)->save() : $bone->fill(array_except($data, ['created_at']))->save();

        $bone = SkeletalBone::firstOrNew(['name' => 'Scaphoid']);
        $data = array('name' => 'Scaphoid',  'search_name' => 'scaphoid', 'category'=> 'Upper Extremity', 'type' => 'Irregular', 'group' => 'Appendicular', 
			'description' => 'Wrist', 'middle' => 'false', 'paired' => true, 'articulated' => true, 'refit' => false, 'morphology' => false,  'zones' => true, 'measurements' => true,  'methods' => true, 'mni' => true, 'dental' => false,
			'image_zones' => 'hand_left_500.png', 'image_measurements' => 'hand_500.png', 'measurements_help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/measurements/#hands', 'zones_help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/zones/#hand',
            'methods_age' => true, 'methods_sex' => false, 'methods_ancestry' => false, 'methods_stature' => false,
            'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
		(!$bone->exists) ? $bone->fill($data)->save() : $bone->fill(array_except($data, ['created_at']))->save();

        $bone = SkeletalBone::firstOrNew(['name' => 'Scapula']);
        $data = array('name' => 'Scapula',  'search_name' => 'scapula', 'category'=> 'Pectoral Girdle', 'type' => 'Flat', 'group' => 'Appendicular', 
			'description' => 'Shoulder', 'middle' => 'false', 'paired' => true, 'articulated' => true, 'refit' => false, 'morphology' => true,  'zones' => true, 'measurements' => true,  'methods' => true, 'mni' => true, 'dental' => false,
            'image_zones' => 'scapula_left_500.png', 'image_measurements' => 'scapula_500.png', 'measurements_help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/measurements/#scapula', 'zones_help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/zones/#scapula',
            'methods_age' => true, 'methods_sex' => false, 'methods_ancestry' => false, 'methods_stature' => false,
            'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
		(!$bone->exists) ? $bone->fill($data)->save() : $bone->fill(array_except($data, ['created_at']))->save();

        $bone = SkeletalBone::firstOrNew(['name' => 'Second (Intermediate) cuneiform']);
        $data = array('name' => 'Second (Intermediate) cuneiform',  'search_name' => 'second (intermediate) cuneiform', 'category'=> 'Lower Extremity', 'type' => 'Irregular', 'group' => 'Appendicular', 
			'description' => 'Ankle', 'middle' => 'false', 'paired' => true, 'articulated' => true, 'refit' => false, 'morphology' => false,  'zones' => true, 'measurements' => true,  'methods' => true, 'mni' => true, 'dental' => false, 
			'image_zones' => 'foot_right_500.png', 'image_measurements' => 'foot_500.png', 'measurements_help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/measurements/#feet', 'zones_help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/zones/#foot',
            'methods_age' => true, 'methods_sex' => false, 'methods_ancestry' => false, 'methods_stature' => false,
            'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
		(!$bone->exists) ? $bone->fill($data)->save() : $bone->fill(array_except($data, ['created_at']))->save();

        $bone = SkeletalBone::firstOrNew(['name' => 'Sesamoid']);
        $data = array('name' => 'Sesamoid',  'search_name' => 'sesamoid', 'category'=> 'Other', 'type' => 'Irregular', 'group' => 'Appendicular', 
			'description' => 'Hand/foot', 'middle' => 'false', 'paired' => false, 'articulated' => true, 'refit' => false, 'morphology' => false,  'zones' => false, 'measurements' => false,  'methods' => false, 'mni' => false, 'dental' => false, 'countable' => true,
			'image_zones' => null, 'image_measurements' => null, 'measurements_help_url' => '', 'zones_help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/zones/#hands-and-feet',
            'methods_age' => false, 'methods_sex' => false, 'methods_ancestry' => false, 'methods_stature' => false, 
            'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
		(!$bone->exists) ? $bone->fill($data)->save() : $bone->fill(array_except($data, ['created_at']))->save();

        $bone = SkeletalBone::firstOrNew(['name' => 'Sphenoid']);
        $data = array('name' => 'Sphenoid',  'search_name' => 'sphenoid', 'category'=> 'Cranial', 'type' => 'Irregular', 'group' => 'Axial', 
			'description' => 'Cranial', 'middle' => 'false', 'paired' => false, 'articulated' => true, 'refit' => false, 'morphology' => true,  'zones' => true, 'measurements' => false,  'methods' => true, 'mni' => true, 'dental' => false,
			'image_zones' => 'cranium_zones_composite_500.png', 'image_measurements' => null, 'measurements_help_url' => '', 'zones_help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/zones/#cranium',
            'methods_age' => true, 'methods_sex' => false, 'methods_ancestry' => false, 'methods_stature' => false,
            'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
		(!$bone->exists) ? $bone->fill($data)->save() : $bone->fill(array_except($data, ['created_at']))->save();

        $bone = SkeletalBone::firstOrNew(['name' => 'Stapes']);
        $data = array('name' => 'Stapes',  'search_name' => 'stapes', 'category'=> 'Cranial', 'type' => 'Irregular', 'group' => 'Axial', 
			'description' => 'Ear ossicle', 'middle' => 'false', 'paired' => true, 'articulated' => true, 'refit' => false, 'morphology' => false,  'zones' => true, 'measurements' => false,  'methods' => false, 'mni' => true, 'dental' => false,
			'image_zones' => 'ossicles_500.png', 'image_measurements' => null, 'measurements_help_url' => '', 'zones_help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/zones/#cranium',
            'methods_age' => false, 'methods_sex' => false, 'methods_ancestry' => false, 'methods_stature' => false, 
            'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
		(!$bone->exists) ? $bone->fill($data)->save() : $bone->fill(array_except($data, ['created_at']))->save();

        $bone = SkeletalBone::firstOrNew(['name' => 'Sternal body']);
        $data = array('name' => 'Sternal body',  'search_name' => 'sternal body', 'category'=> 'Thoracic Cage', 'type' => 'Flat', 'group' => 'Axial', 
			'description' => 'Sternum', 'middle' => 'false', 'paired' => false, 'articulated' => true, 'refit' => false, 'morphology' => false,  'zones' => true, 'measurements' => false,  'methods' => true, 'mni' => true, 'dental' => false, 
			'image_zones' => 'sternum_500.png', 'image_measurements' => null, 'measurements_help_url' => '', 'zones_help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/zones/#sternum',
            'methods_age' => true, 'methods_sex' => false, 'methods_ancestry' => false, 'methods_stature' => false,
            'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
		(!$bone->exists) ? $bone->fill($data)->save() : $bone->fill(array_except($data, ['created_at']))->save();

        $bone = SkeletalBone::firstOrNew(['name' => 'Sternum']);
        $data = array('name' => 'Sternum',  'search_name' => 'sternum', 'category'=> 'Thoracic Cage', 'type' => 'Flat', 'group' => 'Axial', 
			'description' => 'Sternum', 'middle' => 'false', 'paired' => false, 'articulated' => true, 'refit' => false, 'morphology' => true,  'zones' => true, 'measurements' => false,  'methods' => true, 'mni' => true, 'dental' => false,
            'image_zones' => 'sternum_500.png', 'image_measurements' => null, 'measurements_help_url' => '', 'zones_help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/zones/#sternum',
            'methods_age' => true, 'methods_sex' => false, 'methods_ancestry' => false, 'methods_stature' => false,
            'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt); 
		(!$bone->exists) ? $bone->fill($data)->save() : $bone->fill(array_except($data, ['created_at']))->save();

        $bone = SkeletalBone::firstOrNew(['name' => 'Talus']);
        $data = array('name' => 'Talus',  'search_name' => 'talus', 'category'=> 'Lower Extremity', 'type' => 'Irregular', 'group' => 'Appendicular', 
			'description' => 'Ankle', 'middle' => 'false', 'paired' => true, 'articulated' => true, 'refit' => false, 'morphology' => true,  'zones' => true, 'measurements' => true,  'methods' => true, 'mni' => true, 'dental' => false, 
			'image_zones' => 'foot_right_500.png', 'image_measurements' => 'talus_500.png', 'measurements_help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/measurements/#talus', 'zones_help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/zones/#foot',
            'methods_age' => true, 'methods_sex' => false, 'methods_ancestry' => false, 'methods_stature' => false,
            'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
		(!$bone->exists) ? $bone->fill($data)->save() : $bone->fill(array_except($data, ['created_at']))->save();

        $bone = SkeletalBone::firstOrNew(['name' => 'Temporal']);
        $data = array('name' => 'Temporal',  'search_name' => 'temporal', 'category'=> 'Cranial', 'type' => 'Irregular', 'group' => 'Axial', 
			'description' => 'Cranial', 'middle' => 'false', 'paired' => true, 'articulated' => true, 'refit' => false, 'morphology' => true,  'zones' => false, 'measurements' => false,  'methods' => true, 'mni' => true, 'dental' => false,
			'image_zones' => null, 'image_measurements' => null, 'measurements_help_url' => '', 'zones_help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/zones/#cranium',
            'methods_age' => true, 'methods_sex' => true, 'methods_ancestry' => false, 'methods_stature' => false,
            'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
		(!$bone->exists) ? $bone->fill($data)->save() : $bone->fill(array_except($data, ['created_at']))->save();

        $bone = SkeletalBone::firstOrNew(['name' => 'Third (Lateral) cuneiform']);
        $data = array('name' => 'Third (Lateral) cuneiform',  'search_name' => 'third (lateral) cuneiform', 'category'=> 'Lower Extremity', 'type' => 'Irregular', 'group' => 'Appendicular', 
			'description' => 'Ankle', 'middle' => 'false', 'paired' => true, 'articulated' => true, 'refit' => false, 'morphology' => false,  'zones' => true, 'measurements' => true,  'methods' => true, 'mni' => true, 'dental' => false, 
			'image_zones' => 'foot_right_500.png', 'image_measurements' => 'foot_500.png', 'measurements_help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/measurements/#feet', 'zones_help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/zones/#foot',
            'methods_age' => true, 'methods_sex' => false, 'methods_ancestry' => false, 'methods_stature' => false,
            'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
		(!$bone->exists) ? $bone->fill($data)->save() : $bone->fill(array_except($data, ['created_at']))->save();

        $bone = SkeletalBone::firstOrNew(['name' => 'Thoracic vertebra 1']);
        $data = array('name' => 'Thoracic vertebra 1',  'search_name' => 'thoracic vertebra 1', 'category'=> 'Vertebral Column', 'type' => 'Irregular', 'group' => 'Axial', 
			'description' => 'Vertebral', 'middle' => 'true', 'paired' => false, 'articulated' => true, 'refit' => false, 'morphology' => true,  'zones' => true, 'measurements' => false,  'methods' => true, 'mni' => true, 'dental' => false, 
			'image_zones' => 'thoracic_500.png', 'image_measurements' => null, 'measurements_help_url' => '', 'zones_help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/zones/#thoracic-and-lumbar-vertebrae',
            'methods_age' => true, 'methods_sex' => false, 'methods_ancestry' => false, 'methods_stature' => false,
            'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
		(!$bone->exists) ? $bone->fill($data)->save() : $bone->fill(array_except($data, ['created_at']))->save();

        $bone = SkeletalBone::firstOrNew(['name' => 'Thoracic vertebra 1/2']);
        $data = array('name' => 'Thoracic vertebra 1/2',  'search_name' => 'thoracic vertebra 1/2', 'category'=> 'Vertebral Column', 'type' => 'Irregular', 'group' => 'Axial', 
			'description' => 'Vertebral', 'middle' => 'true', 'paired' => false, 'articulated' => true, 'refit' => false, 'morphology' => true,  'zones' => true, 'measurements' => false,  'methods' => true, 'mni' => false, 'dental' => false,
			'image_zones' => 'thoracic_500.png', 'image_measurements' => null, 'measurements_help_url' => '', 'zones_help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/zones/#thoracic-and-lumbar-vertebrae',
            'methods_age' => true, 'methods_sex' => false, 'methods_ancestry' => false, 'methods_stature' => false,
            'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
		(!$bone->exists) ? $bone->fill($data)->save() : $bone->fill(array_except($data, ['created_at']))->save();

        $bone = SkeletalBone::firstOrNew(['name' => 'Thoracic vertebra 10']);
        $data = array('name' => 'Thoracic vertebra 10',  'search_name' => 'thoracic vertebra 10', 'category'=> 'Vertebral Column', 'type' => 'Irregular', 'group' => 'Axial', 
			'description' => 'Vertebral', 'middle' => 'true', 'paired' => false, 'articulated' => true, 'refit' => false, 'morphology' => true,  'zones' => true, 'measurements' => false,  'methods' => true, 'mni' => true, 'dental' => false, 
			'image_zones' => 'thoracic_500.png', 'image_measurements' => null, 'measurements_help_url' => '', 'zones_help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/zones/#thoracic-and-lumbar-vertebrae',
            'methods_age' => true, 'methods_sex' => false, 'methods_ancestry' => false, 'methods_stature' => false,
            'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
		(!$bone->exists) ? $bone->fill($data)->save() : $bone->fill(array_except($data, ['created_at']))->save();

        $bone = SkeletalBone::firstOrNew(['name' => 'Thoracic vertebra 10/11']);
        $data = array('name' => 'Thoracic vertebra 10/11',  'search_name' => 'thoracic vertebra 10/11', 'category'=> 'Vertebral Column', 'type' => 'Irregular', 'group' => 'Axial', 
			'description' => 'Vertebral', 'middle' => 'true', 'paired' => false, 'articulated' => true, 'refit' => false, 'morphology' => true,  'zones' => true, 'measurements' => false,  'methods' => true, 'mni' => false, 'dental' => false,
			'image_zones' => 'thoracic_500.png', 'image_measurements' => null, 'measurements_help_url' => '', 'zones_help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/zones/#thoracic-and-lumbar-vertebrae',
            'methods_age' => true, 'methods_sex' => false, 'methods_ancestry' => false, 'methods_stature' => false,
            'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
		(!$bone->exists) ? $bone->fill($data)->save() : $bone->fill(array_except($data, ['created_at']))->save();

        $bone = SkeletalBone::firstOrNew(['name' => 'Thoracic vertebra 10/11/12']);
        $data = array('name' => 'Thoracic vertebra 10/11/12',  'search_name' => 'thoracic vertebra 10/11/12', 'category'=> 'Vertebral Column', 'type' => 'Irregular', 'group' => 'Axial', 
			'description' => 'Vertebral', 'middle' => 'true', 'paired' => false, 'articulated' => true, 'refit' => false, 'morphology' => true,  'zones' => true, 'measurements' => false,  'methods' => true, 'mni' => false, 'dental' => false,
			'image_zones' => 'thoracic_500.png', 'image_measurements' => null, 'measurements_help_url' => '', 'zones_help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/zones/#thoracic-and-lumbar-vertebrae',
            'methods_age' => true, 'methods_sex' => false, 'methods_ancestry' => false, 'methods_stature' => false,
            'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
		(!$bone->exists) ? $bone->fill($data)->save() : $bone->fill(array_except($data, ['created_at']))->save();

        $bone = SkeletalBone::firstOrNew(['name' => 'Thoracic vertebra 11']);
        $data = array('name' => 'Thoracic vertebra 11',  'search_name' => 'thoracic vertebra 11', 'category'=> 'Vertebral Column', 'type' => 'Irregular', 'group' => 'Axial', 
			'description' => 'Vertebral', 'middle' => 'true', 'paired' => false, 'articulated' => true, 'refit' => false, 'morphology' => true,  'zones' => true, 'measurements' => false,  'methods' => true, 'mni' => true, 'dental' => false, 
			'image_zones' => 'thoracic_500.png', 'image_measurements' => null, 'measurements_help_url' => '', 'zones_help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/zones/#thoracic-and-lumbar-vertebrae',
            'methods_age' => true, 'methods_sex' => false, 'methods_ancestry' => false, 'methods_stature' => false,
            'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
		(!$bone->exists) ? $bone->fill($data)->save() : $bone->fill(array_except($data, ['created_at']))->save();

        $bone = SkeletalBone::firstOrNew(['name' => 'Thoracic vertebra 11/12']);
        $data = array('name' => 'Thoracic vertebra 11/12',  'search_name' => 'thoracic vertebra 11/12', 'category'=> 'Vertebral Column', 'type' => 'Irregular', 'group' => 'Axial', 
			'description' => 'Vertebral', 'middle' => 'true', 'paired' => false, 'articulated' => true, 'refit' => false, 'morphology' => true,  'zones' => true, 'measurements' => false,  'methods' => true, 'mni' => false, 'dental' => false,
			'image_zones' => 'thoracic_500.png', 'image_measurements' => null, 'measurements_help_url' => '', 'zones_help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/zones/#thoracic-and-lumbar-vertebrae',
            'methods_age' => true, 'methods_sex' => false, 'methods_ancestry' => false, 'methods_stature' => false,
            'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
		(!$bone->exists) ? $bone->fill($data)->save() : $bone->fill(array_except($data, ['created_at']))->save();

        $bone = SkeletalBone::firstOrNew(['name' => 'Thoracic vertebra 12']);
        $data = array('name' => 'Thoracic vertebra 12',  'search_name' => 'thoracic vertebra 12', 'category'=> 'Vertebral Column', 'type' => 'Irregular', 'group' => 'Axial', 
			'description' => 'Vertebral', 'middle' => 'true', 'paired' => false, 'articulated' => true, 'refit' => false, 'morphology' => true,  'zones' => true, 'measurements' => false,  'methods' => true, 'mni' => true, 'dental' => false, 
			'image_zones' => 'thoracic_500.png', 'image_measurements' => null, 'measurements_help_url' => '', 'zones_help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/zones/#thoracic-and-lumbar-vertebrae',
            'methods_age' => true, 'methods_sex' => false, 'methods_ancestry' => false, 'methods_stature' => false,
            'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
		(!$bone->exists) ? $bone->fill($data)->save() : $bone->fill(array_except($data, ['created_at']))->save();

        $bone = SkeletalBone::firstOrNew(['name' => 'Thoracic vertebra 12/Lumbar vertebra 1']);
        $data = array('name' => 'Thoracic vertebra 12/Lumbar vertebra 1',  'search_name' => 'thoracic vertebra 12/lumbar vertebra 1', 'category'=> 'Vertebral Column', 'type' => 'Irregular', 'group' => 'Axial', 
			'description' => 'Vertebral', 'middle' => 'true', 'paired' => false, 'articulated' => true, 'refit' => false, 'morphology' => true,  'zones' => true, 'measurements' => false,  'methods' => false, 'mni' => false, 'dental' => false,
			'image_zones' => 'thoracic_500.png', 'image_measurements' => null, 'measurements_help_url' => '', 'zones_help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/zones/#thoracic-and-lumbar-vertebrae',
            'methods_age' => false, 'methods_sex' => false, 'methods_ancestry' => false, 'methods_stature' => false,
            'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
		(!$bone->exists) ? $bone->fill($data)->save() : $bone->fill(array_except($data, ['created_at']))->save();

        $bone = SkeletalBone::firstOrNew(['name' => 'Thoracic vertebra 2']);
        $data = array('name' => 'Thoracic vertebra 2',  'search_name' => 'thoracic vertebra 2', 'category'=> 'Vertebral Column', 'type' => 'Irregular', 'group' => 'Axial', 
			'description' => 'Vertebral', 'middle' => 'true', 'paired' => false, 'articulated' => true, 'refit' => false, 'morphology' => true,  'zones' => true, 'measurements' => false,  'methods' => true, 'mni' => true, 'dental' => false, 
			'image_zones' => 'thoracic_500.png', 'image_measurements' => null, 'measurements_help_url' => '', 'zones_help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/zones/#thoracic-and-lumbar-vertebrae',
            'methods_age' => true, 'methods_sex' => false, 'methods_ancestry' => false, 'methods_stature' => false,
            'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
		(!$bone->exists) ? $bone->fill($data)->save() : $bone->fill(array_except($data, ['created_at']))->save();

        $bone = SkeletalBone::firstOrNew(['name' => 'Thoracic vertebra 3']);
        $data = array('name' => 'Thoracic vertebra 3',  'search_name' => 'thoracic vertebra 3', 'category'=> 'Vertebral Column', 'type' => 'Irregular', 'group' => 'Axial', 
			'description' => 'Vertebral', 'middle' => 'true', 'paired' => false, 'articulated' => true, 'refit' => false, 'morphology' => true,  'zones' => true, 'measurements' => false,  'methods' => true, 'mni' => true, 'dental' => false, 
			'image_zones' => 'thoracic_500.png', 'image_measurements' => null, 'measurements_help_url' => '', 'zones_help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/zones/#thoracic-and-lumbar-vertebrae',
            'methods_age' => true, 'methods_sex' => false, 'methods_ancestry' => false, 'methods_stature' => false,
            'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
		(!$bone->exists) ? $bone->fill($data)->save() : $bone->fill(array_except($data, ['created_at']))->save();

        $bone = SkeletalBone::firstOrNew(['name' => 'Thoracic vertebra 4']);
        $data = array('name' => 'Thoracic vertebra 4',  'search_name' => 'thoracic vertebra 4', 'category'=> 'Vertebral Column', 'type' => 'Irregular', 'group' => 'Axial', 
			'description' => 'Vertebral', 'middle' => 'true', 'paired' => false, 'articulated' => true, 'refit' => false, 'morphology' => true,  'zones' => true, 'measurements' => false,  'methods' => true, 'mni' => true, 'dental' => false, 
			'image_zones' => 'thoracic_500.png', 'image_measurements' => null, 'measurements_help_url' => '', 'zones_help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/zones/#thoracic-and-lumbar-vertebrae',
            'methods_age' => true, 'methods_sex' => false, 'methods_ancestry' => false, 'methods_stature' => false,
            'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
		(!$bone->exists) ? $bone->fill($data)->save() : $bone->fill(array_except($data, ['created_at']))->save();

        $bone = SkeletalBone::firstOrNew(['name' => 'Thoracic vertebra 5']);
        $data = array('name' => 'Thoracic vertebra 5',  'search_name' => 'thoracic vertebra 5', 'category'=> 'Vertebral Column', 'type' => 'Irregular', 'group' => 'Axial', 
			'description' => 'Vertebral', 'middle' => 'true', 'paired' => false, 'articulated' => true, 'refit' => false, 'morphology' => true,  'zones' => true, 'measurements' => false,  'methods' => true, 'mni' => true, 'dental' => false, 
			'image_zones' => 'thoracic_500.png', 'image_measurements' => null, 'measurements_help_url' => '', 'zones_help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/zones/#thoracic-and-lumbar-vertebrae',
            'methods_age' => true, 'methods_sex' => false, 'methods_ancestry' => false, 'methods_stature' => false,
            'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
		(!$bone->exists) ? $bone->fill($data)->save() : $bone->fill(array_except($data, ['created_at']))->save();

        $bone = SkeletalBone::firstOrNew(['name' => 'Thoracic vertebra 6']);
        $data = array('name' => 'Thoracic vertebra 6',  'search_name' => 'thoracic vertebra 6', 'category'=> 'Vertebral Column', 'type' => 'Irregular', 'group' => 'Axial', 
			'description' => 'Vertebral', 'middle' => 'true', 'paired' => false, 'articulated' => true, 'refit' => false, 'morphology' => true,  'zones' => true, 'measurements' => false,  'methods' => true, 'mni' => true, 'dental' => false, 
			'image_zones' => 'thoracic_500.png', 'image_measurements' => null, 'measurements_help_url' => '', 'zones_help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/zones/#thoracic-and-lumbar-vertebrae',
            'methods_age' => true, 'methods_sex' => false, 'methods_ancestry' => false, 'methods_stature' => false,
            'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
		(!$bone->exists) ? $bone->fill($data)->save() : $bone->fill(array_except($data, ['created_at']))->save();

        $bone = SkeletalBone::firstOrNew(['name' => 'Thoracic vertebra 7']);
        $data = array('name' => 'Thoracic vertebra 7',  'search_name' => 'thoracic vertebra 7', 'category'=> 'Vertebral Column', 'type' => 'Irregular', 'group' => 'Axial', 
			'description' => 'Vertebral', 'middle' => 'true', 'paired' => false, 'articulated' => true, 'refit' => false, 'morphology' => true,  'zones' => true, 'measurements' => false,  'methods' => true, 'mni' => true, 'dental' => false, 
			'image_zones' => 'thoracic_500.png', 'image_measurements' => null, 'measurements_help_url' => '', 'zones_help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/zones/#thoracic-and-lumbar-vertebrae',
            'methods_age' => true, 'methods_sex' => false, 'methods_ancestry' => false, 'methods_stature' => false,
            'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
		(!$bone->exists) ? $bone->fill($data)->save() : $bone->fill(array_except($data, ['created_at']))->save();

        $bone = SkeletalBone::firstOrNew(['name' => 'Thoracic vertebra 8']);
        $data = array('name' => 'Thoracic vertebra 8',  'search_name' => 'thoracic vertebra 8', 'category'=> 'Vertebral Column', 'type' => 'Irregular', 'group' => 'Axial', 
			'description' => 'Vertebral', 'middle' => 'true', 'paired' => false, 'articulated' => true, 'refit' => false, 'morphology' => true,  'zones' => true, 'measurements' => false,  'methods' => true, 'mni' => true, 'dental' => false, 
			'image_zones' => 'thoracic_500.png', 'image_measurements' => null, 'measurements_help_url' => '', 'zones_help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/zones/#thoracic-and-lumbar-vertebrae',
            'methods_age' => true, 'methods_sex' => false, 'methods_ancestry' => false, 'methods_stature' => false,
            'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
		(!$bone->exists) ? $bone->fill($data)->save() : $bone->fill(array_except($data, ['created_at']))->save();

        $bone = SkeletalBone::firstOrNew(['name' => 'Thoracic vertebra 9']);
        $data = array('name' => 'Thoracic vertebra 9',  'search_name' => 'thoracic vertebra 9', 'category'=> 'Vertebral Column', 'type' => 'Irregular', 'group' => 'Axial', 
			'description' => 'Vertebral', 'middle' => 'true', 'paired' => false, 'articulated' => true, 'refit' => false, 'morphology' => true,  'zones' => true, 'measurements' => false,  'methods' => true, 'mni' => true, 'dental' => false, 
			'image_zones' => 'thoracic_500.png', 'image_measurements' => null, 'measurements_help_url' => '', 'zones_help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/zones/#thoracic-and-lumbar-vertebrae',
            'methods_age' => true, 'methods_sex' => false, 'methods_ancestry' => false, 'methods_stature' => false,
            'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
		(!$bone->exists) ? $bone->fill($data)->save() : $bone->fill(array_except($data, ['created_at']))->save();

        $bone = SkeletalBone::firstOrNew(['name' => 'Tibia']);
        $data = array('name' => 'Tibia',  'search_name' => 'tibia', 'category'=> 'Lower Extremity', 'type' => 'Long bone', 'group' => 'Appendicular',
			'description' => 'Leg', 'middle' => 'false', 'paired' => true, 'articulated' => true, 'refit' => false, 'morphology' => true,  'zones' => true, 'measurements' => true,  'methods' => true, 'mni' => true, 'dental' => false,
            'image_zones' => 'tibia_left_500.png', 'image_measurements' => 'tibia_500.png', 'measurements_help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/measurements/#tibia', 'zones_help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/zones/#tibia',
            'methods_age' => true, 'methods_sex' => false, 'methods_ancestry' => false, 'methods_stature' => false,
            'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
		(!$bone->exists) ? $bone->fill($data)->save() : $bone->fill(array_except($data, ['created_at']))->save();

        $bone = SkeletalBone::firstOrNew(['name' => 'Trapezium']);
        $data = array('name' => 'Trapezium',  'search_name' => 'trapezium', 'category'=> 'Upper Extremity', 'type' => 'Irregular', 'group' => 'Appendicular', 
			'description' => 'Wrist', 'middle' => 'false', 'paired' => true, 'articulated' => true, 'refit' => false, 'morphology' => false,  'zones' => true, 'measurements' => true,  'methods' => true, 'mni' => true, 'dental' => false, 
			'image_zones' => 'hand_left_500.png', 'image_measurements' => 'hand_500.png', 'measurements_help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/measurements/#hands', 'zones_help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/zones/#hand',
            'methods_age' => true, 'methods_sex' => false, 'methods_ancestry' => false, 'methods_stature' => false,
            'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
		(!$bone->exists) ? $bone->fill($data)->save() : $bone->fill(array_except($data, ['created_at']))->save();

        $bone = SkeletalBone::firstOrNew(['name' => 'Trapezoid']);
        $data = array('name' => 'Trapezoid',  'search_name' => 'trapezoid', 'category'=> 'Upper Extremity', 'type' => 'Irregular', 'group' => 'Appendicular', 
			'description' => 'Wrist', 'middle' => 'false', 'paired' => true, 'articulated' => true, 'refit' => false, 'morphology' => false,  'zones' => true, 'measurements' => true,  'methods' => true, 'mni' => true, 'dental' => false, 
			'image_zones' => 'hand_left_500.png', 'image_measurements' => 'hand_500.png', 'measurements_help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/measurements/#hands', 'zones_help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/zones/#hand',
            'methods_age' => true, 'methods_sex' => false, 'methods_ancestry' => false, 'methods_stature' => false,
            'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
		(!$bone->exists) ? $bone->fill($data)->save() : $bone->fill(array_except($data, ['created_at']))->save();

        $bone = SkeletalBone::firstOrNew(['name' => 'Triquetral']);
        $data = array('name' => 'Triquetral',  'search_name' => 'triquetral', 'category'=> 'Upper Extremity', 'type' => 'Irregular', 'group' => 'Appendicular', 
			'description' => 'Wrist', 'middle' => 'false', 'paired' => true, 'articulated' => true, 'refit' => false, 'morphology' => false,  'zones' => true, 'measurements' => true,  'methods' => true, 'mni' => true, 'dental' => false, 
			'image_zones' => 'hand_left_500.png', 'image_measurements' => 'hand_500.png', 'measurements_help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/measurements/#hands', 'zones_help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/zones/#hand',
            'methods_age' => true, 'methods_sex' => false, 'methods_ancestry' => false, 'methods_stature' => false,
            'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
		(!$bone->exists) ? $bone->fill($data)->save() : $bone->fill(array_except($data, ['created_at']))->save();

        $bone = SkeletalBone::firstOrNew(['name' => 'Ulna']);
        $data = array('name' => 'Ulna',  'search_name' => 'ulna', 'category'=> 'Upper Extremity', 'type' => 'Long bone', 'group' => 'Appendicular', 
			'description' => 'Arm', 'middle' => 'false', 'paired' => true, 'articulated' => true, 'refit' => false, 'morphology' => true,  'zones' => true, 'measurements' => true,  'methods' => true, 'mni' => true, 'dental' => false,
            'image_zones' => 'ulna_left_500.png', 'image_measurements' => 'ulna_500.png', 'measurements_help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/measurements/#ulna', 'zones_help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/zones/#ulna',
            'methods_age' => true, 'methods_sex' => false, 'methods_ancestry' => false, 'methods_stature' => false,
            'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
		(!$bone->exists) ? $bone->fill($data)->save() : $bone->fill(array_except($data, ['created_at']))->save();

        $bone = SkeletalBone::firstOrNew(['name' => 'Unidentified cranium']);
        $data = array('name' => 'Unidentified cranium',  'search_name' => 'unidentified cranium', 'category'=> 'Cranial', 'type' => 'Irregular', 'group' => 'Axial', 
			'description' => 'Cranial', 'middle' => 'false', 'paired' => false, 'articulated' => true, 'refit' => true, 'morphology' => true,  'zones' => false, 'measurements' => false,  'methods' => false, 'mni' => false, 'dental' => false, 'countable' => true,
			'image_zones' => null, 'image_measurements' => null, 'measurements_help_url' => '', 'zones_help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/zones/#cranium',
            'methods_age' => false, 'methods_sex' => false, 'methods_ancestry' => false, 'methods_stature' => false, 
            'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
		(!$bone->exists) ? $bone->fill($data)->save() : $bone->fill(array_except($data, ['created_at']))->save();

        $bone = SkeletalBone::firstOrNew(['name' => 'Unidentified fragments']);
        $data = array('name' => 'Unidentified fragments',  'search_name' => 'unidentified fragments', 'category'=> 'Other', 'type' => 'N/A', 'group' => 'N/A', 
			'description' => 'N/A', 'middle' => 'false', 'paired' => false, 'articulated' => true, 'refit' => true, 'morphology' => false,  'zones' => false, 'measurements' => false,  'methods' => false, 'mni' => false, 'dental' => false, 'countable' => true,
			'image_zones' => null, 'image_measurements' => null, 'measurements_help_url' => '', 'zones_help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/zones/#hands-and-feet',
            'methods_age' => false, 'methods_sex' => false, 'methods_ancestry' => false, 'methods_stature' => false, 
            'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
		(!$bone->exists) ? $bone->fill($data)->save() : $bone->fill(array_except($data, ['created_at']))->save();

        $bone = SkeletalBone::firstOrNew(['name' => 'Unidentified rib fragments']);
        $data = array('name' => 'Unidentified rib fragments',  'search_name' => 'unidentified rib fragments', 'category'=> 'Thoracic Cage', 'type' => 'Flat', 'group' => 'Axial',
            'description' => 'Rib', 'middle' => 'false', 'paired' => false, 'articulated' => false, 'refit' => false, 'morphology' => false,  'zones' => false, 'measurements' => false,  'methods' => false, 'mni' => false, 'dental' => false, 'countable' => true,
            'image_zones' => null, 'image_measurements' => null, 'measurements_help_url' => '', 'zones_help_url' => '',
            'methods_age' => false, 'methods_sex' => false, 'methods_ancestry' => false, 'methods_stature' => false, 
            'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$bone->exists) ? $bone->fill($data)->save() : $bone->fill(array_except($data, ['created_at']))->save();

        $bone = SkeletalBone::firstOrNew(['name' => 'Unidentified long bone']);
        $data = array('name' => 'Unidentified long bone',  'search_name' => 'unidentified long bone', 'category'=> 'Other', 'type' => 'Long bone', 'group' => 'Appendicular', 
			'description' => 'N/A', 'middle' => 'false', 'paired' => false, 'articulated' => true, 'refit' => true, 'morphology' => true,  'zones' => false, 'measurements' => false,  'methods' => false, 'mni' => false, 'dental' => false, 'countable' => true,
			'image_zones' => null, 'image_measurements' => null, 'measurements_help_url' => '', 'zones_help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/zones/#postcranial-remains',
            'methods_age' => false, 'methods_sex' => false, 'methods_ancestry' => false, 'methods_stature' => false, 
            'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
		(!$bone->exists) ? $bone->fill($data)->save() : $bone->fill(array_except($data, ['created_at']))->save();

        $bone = SkeletalBone::firstOrNew(['name' => 'Unidentified metacarpal/tarsal']);
        $data = array('name' => 'Unidentified metacarpal/tarsal',  'search_name' => 'unidentified metacarpal/tarsal', 'category'=> 'Other', 'type' => 'Short bone', 'group' => 'Appendicular', 
			'description' => 'N/A', 'middle' => 'false', 'paired' => false, 'articulated' => true, 'refit' => true, 'morphology' => false,  'zones' => false, 'measurements' => false,  'methods' => false, 'mni' => false, 'dental' => false,  'countable' => true,
			'image_zones' => null, 'image_measurements' => null, 'measurements_help_url' => '', 'zones_help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/zones/#hands-and-feet',
            'methods_age' => false, 'methods_sex' => false, 'methods_ancestry' => false, 'methods_stature' => false, 
            'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
		(!$bone->exists) ? $bone->fill($data)->save() : $bone->fill(array_except($data, ['created_at']))->save();

        $bone = SkeletalBone::firstOrNew(['name' => 'Unidentified phalanx']);
        $data = array('name' => 'Unidentified phalanx',  'search_name' => 'unidentified phalanx', 'category'=> 'Other', 'type' => 'Short bone', 'group' => 'Appendicular', 
			'description' => 'N/A', 'middle' => 'false', 'paired' => false, 'articulated' => true, 'refit' => true, 'morphology' => false,  'zones' => false, 'measurements' => false,  'methods' => false, 'mni' => false, 'dental' => false, 'countable' => true,
			'image_zones' => null, 'image_measurements' => null, 'measurements_help_url' => '', 'zones_help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/zones/#hands-and-feet',
            'methods_age' => false, 'methods_sex' => false, 'methods_ancestry' => false, 'methods_stature' => false, 
            'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
		(!$bone->exists) ? $bone->fill($data)->save() : $bone->fill(array_except($data, ['created_at']))->save();

        $bone = SkeletalBone::firstOrNew(['name' => 'Unidentified vertebra']);
        $data = array('name' => 'Unidentified vertebra',  'search_name' => 'unidentified vertebra', 'category'=> 'Vertebral Column', 'type' => 'Irregular', 'group' => 'Axial', 
			'description' => 'Vertebral', 'middle' => 'false', 'paired' => false, 'articulated' => true, 'refit' => true, 'morphology' => true,  'zones' => false, 'measurements' => false,  'methods' => true, 'mni' => false, 'dental' => false, 'countable' => true,
			'image_zones' => null, 'image_measurements' => null, 'measurements_help_url' => '', 'zones_help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/zones/#vertebrae',
            'methods_age' => true, 'methods_sex' => false, 'methods_ancestry' => false, 'methods_stature' => false,
            'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
		(!$bone->exists) ? $bone->fill($data)->save() : $bone->fill(array_except($data, ['created_at']))->save();

        $bone = SkeletalBone::firstOrNew(['name' => 'Unseriated cervical vertebra']);
        $data = array('name' => 'Unseriated cervical vertebra',  'search_name' => 'unseriated cervical vertebra', 'category'=> 'Vertebral Column', 'type' => 'Irregular', 'group' => 'Axial', 
			'description' => 'Vertebral', 'middle' => 'false', 'paired' => false, 'articulated' => true, 'refit' => true, 'morphology' => true,  'zones' => true, 'measurements' => false,  'methods' => true, 'mni' => false, 'dental' => false, 'countable' => true,
			'image_zones' => 'cervical_500.png', 'image_measurements' => null, 'measurements_help_url' => '', 'zones_help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/zones/#cervical-vertebrae',
            'methods_age' => true, 'methods_sex' => false, 'methods_ancestry' => false, 'methods_stature' => false,
            'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
		(!$bone->exists) ? $bone->fill($data)->save() : $bone->fill(array_except($data, ['created_at']))->save();

        $bone = SkeletalBone::firstOrNew(['name' => 'Unseriated distal manual phalanx']);
        $data = array('name' => 'Unseriated distal manual phalanx',  'search_name' => 'unseriated distal manual phalanx', 'category'=> 'Upper Extremity', 'type' => 'Short bone', 'group' => 'Appendicular', 
			'description' => 'Hand', 'middle' => 'false', 'paired' => true, 'articulated' => true, 'refit' => false, 'morphology' => true,  'zones' => true, 'measurements' => false,  'methods' => true, 'mni' => false, 'dental' => false, 'countable' => true,
			'image_zones' => 'hand_left_500.png', 'image_measurements' => null, 'measurements_help_url' => '', 'zones_help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/zones/#hand',
            'methods_age' => true, 'methods_sex' => false, 'methods_ancestry' => false, 'methods_stature' => false,
            'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
		(!$bone->exists) ? $bone->fill($data)->save() : $bone->fill(array_except($data, ['created_at']))->save();

        $bone = SkeletalBone::firstOrNew(['name' => 'Unseriated distal pedal phalanx']);
        $data = array('name' => 'Unseriated distal pedal phalanx',  'search_name' => 'unseriated distal pedal phalanx', 'category'=> 'Lower Extremity', 'type' => 'Short bone', 'group' => 'Appendicular', 
			'description' => 'Foot', 'middle' => 'false', 'paired' => true, 'articulated' => true, 'refit' => false, 'morphology' => true,  'zones' => true, 'measurements' => false,  'methods' => true, 'mni' => false, 'dental' => false, 'countable' => true,
			'image_zones' => 'foot_right_500.png', 'image_measurements' => null, 'measurements_help_url' => '', 'zones_help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/zones/#foot',
            'methods_age' => true, 'methods_sex' => false, 'methods_ancestry' => false, 'methods_stature' => false,
            'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
		(!$bone->exists) ? $bone->fill($data)->save() : $bone->fill(array_except($data, ['created_at']))->save();

        $bone = SkeletalBone::firstOrNew(['name' => 'Unseriated intermediate manual phalanx']);
        $data = array('name' => 'Unseriated intermediate manual phalanx',  'search_name' => 'unseriated intermediate manual phalanx', 'category'=> 'Upper Extremity', 'type' => 'Short bone', 'group' => 'Appendicular', 
			'description' => 'Hand', 'middle' => 'false', 'paired' => true, 'articulated' => true, 'refit' => false, 'morphology' => true,  'zones' => true, 'measurements' => false,  'methods' => true, 'mni' => false, 'dental' => false, 'countable' => true,
			'image_zones' => 'hand_left_500.png', 'image_measurements' => null, 'measurements_help_url' => '', 'zones_help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/zones/#hand',
            'methods_age' => true, 'methods_sex' => false, 'methods_ancestry' => false, 'methods_stature' => false,
            'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
		(!$bone->exists) ? $bone->fill($data)->save() : $bone->fill(array_except($data, ['created_at']))->save();

        $bone = SkeletalBone::firstOrNew(['name' => 'Unseriated intermediate pedal phalanx']);
        $data = array('name' => 'Unseriated intermediate pedal phalanx',  'search_name' => 'unseriated intermediate pedal phalanx', 'category'=> 'Lower Extremity', 'type' => 'Short bone', 'group' => 'Appendicular', 
			'description' => 'Foot', 'middle' => 'false', 'paired' => true, 'articulated' => true, 'refit' => false, 'morphology' => true,  'zones' => true, 'measurements' => false,  'methods' => true, 'mni' => false, 'dental' => false, 'countable' => true,
			'image_zones' => 'foot_right_500.png', 'image_measurements' => null, 'measurements_help_url' => '', 'zones_help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/zones/#foot',
            'methods_age' => true, 'methods_sex' => false, 'methods_ancestry' => false, 'methods_stature' => false,
            'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
		(!$bone->exists) ? $bone->fill($data)->save() : $bone->fill(array_except($data, ['created_at']))->save();

        $bone = SkeletalBone::firstOrNew(['name' => 'Unseriated lumbar vertebra']);
        $data = array('name' => 'Unseriated lumbar vertebra',  'search_name' => 'unseriated lumbar vertebra', 'category'=> 'Vertebral Column', 'type' => 'Irregular', 'group' => 'Axial', 
			'description' => 'Vertebral', 'middle' => 'false', 'paired' => false, 'articulated' => true, 'refit' => true, 'morphology' => true,  'zones' => true, 'measurements' => false,  'methods' => true, 'mni' => false, 'dental' => false, 'countable' => true,
			'image_zones' => 'thoracic_500.png', 'image_measurements' => null, 'measurements_help_url' => '', 'zones_help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/zones/#thoracic-and-lumbar-vertebrae',
            'methods_age' => true, 'methods_sex' => false, 'methods_ancestry' => false, 'methods_stature' => false,
            'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
		(!$bone->exists) ? $bone->fill($data)->save() : $bone->fill(array_except($data, ['created_at']))->save();

        $bone = SkeletalBone::firstOrNew(['name' => 'Unseriated metacarpal']);
        $data = array('name' => 'Unseriated metacarpal',  'search_name' => 'unseriated metacarpal', 'category'=> 'Upper Extremity', 'type' => 'Short bone', 'group' => 'Appendicular', 
			'description' => 'Hand', 'middle' => 'false', 'paired' => true, 'articulated' => true, 'refit' => false, 'morphology' => true,  'zones' => true, 'measurements' => false,  'methods' => true, 'mni' => false, 'dental' => false, 'countable' => true,
			'image_zones' => 'hand_left_500.png', 'image_measurements' => null, 'measurements_help_url' => '', 'zones_help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/zones/#hand',
            'methods_age' => true, 'methods_sex' => false, 'methods_ancestry' => false, 'methods_stature' => false,
            'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
		(!$bone->exists) ? $bone->fill($data)->save() : $bone->fill(array_except($data, ['created_at']))->save();

        $bone = SkeletalBone::firstOrNew(['name' => 'Unseriated metatarsal']);
        $data = array('name' => 'Unseriated metatarsal',  'search_name' => 'unseriated metatarsal', 'category'=> 'Lower Extremity', 'type' => 'Short bone', 'group' => 'Appendicular', 
			'description' => 'Foot', 'middle' => 'false', 'paired' => true, 'articulated' => true, 'refit' => false, 'morphology' => true,  'zones' => true, 'measurements' => false,  'methods' => true, 'mni' => false, 'dental' => false, 'countable' => true,
			'image_zones' => 'foot_right_500.png', 'image_measurements' => null, 'measurements_help_url' => '', 'zones_help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/zones/#foot',
            'methods_age' => true, 'methods_sex' => false, 'methods_ancestry' => false, 'methods_stature' => false,
            'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
		(!$bone->exists) ? $bone->fill($data)->save() : $bone->fill(array_except($data, ['created_at']))->save();

        $bone = SkeletalBone::firstOrNew(['name' => 'Unseriated proximal manual phalanx']);
        $data = array('name' => 'Unseriated proximal manual phalanx',  'search_name' => 'unseriated proximal manual phalanx', 'category'=> 'Upper Extremity', 'type' => 'Short bone', 'group' => 'Appendicular', 
			'description' => 'Hand', 'middle' => 'false', 'paired' => true, 'articulated' => true, 'refit' => false, 'morphology' => true,  'zones' => true, 'measurements' => false,  'methods' => true, 'mni' => false, 'dental' => false, 'countable' => true,
			'image_zones' => 'hand_left_500.png', 'image_measurements' => null, 'measurements_help_url' => '', 'zones_help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/zones/#hand',
            'methods_age' => true, 'methods_sex' => false, 'methods_ancestry' => false, 'methods_stature' => false,
            'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
		(!$bone->exists) ? $bone->fill($data)->save() : $bone->fill(array_except($data, ['created_at']))->save();

        $bone = SkeletalBone::firstOrNew(['name' => 'Unseriated proximal pedal phalanx']);
        $data = array('name' => 'Unseriated proximal pedal phalanx',  'search_name' => 'unseriated proximal pedal phalanx', 'category'=> 'Lower Extremity', 'type' => 'Short bone', 'group' => 'Appendicular', 
			'description' => 'Foot', 'middle' => 'false', 'paired' => true, 'articulated' => true, 'refit' => false, 'morphology' => true,  'zones' => true, 'measurements' => false,  'methods' => true, 'mni' => false, 'dental' => false, 'countable' => true,
			'image_zones' => 'foot_right_500.png', 'image_measurements' => null, 'measurements_help_url' => '', 'zones_help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/zones/#foot',
            'methods_age' => true, 'methods_sex' => false, 'methods_ancestry' => false, 'methods_stature' => false,
            'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
		(!$bone->exists) ? $bone->fill($data)->save() : $bone->fill(array_except($data, ['created_at']))->save();

        $bone = SkeletalBone::firstOrNew(['name' => 'Unseriated rib']);
        $data = array('name' => 'Unseriated rib',  'search_name' => 'unseriated rib', 'category'=> 'Thoracic Cage', 'type' => 'Flat', 'group' => 'Axial', 
			'description' => 'Rib', 'middle' => 'false', 'paired' => true, 'articulated' => true, 'refit' => false, 'morphology' => true,  'zones' => true, 'measurements' => false,  'methods' => true, 'mni' => false, 'dental' => false, 'countable' => true,
			'image_zones' => 'ribs_500.png', 'image_measurements' => null, 'measurements_help_url' => '', 'zones_help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/zones/#ribs-2-12',
            'methods_age' => true, 'methods_sex' => false, 'methods_ancestry' => false, 'methods_stature' => false,
            'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
		(!$bone->exists) ? $bone->fill($data)->save() : $bone->fill(array_except($data, ['created_at']))->save();

        $bone = SkeletalBone::firstOrNew(['name' => 'Unseriated thoracic vertebra']);
        $data = array('name' => 'Unseriated thoracic vertebra',  'search_name' => 'unseriated thoracic vertebra', 'category'=> 'Vertebral Column', 'type' => 'Irregular', 'group' => 'Axial', 
			'description' => 'Vertebral', 'middle' => 'false', 'paired' => false, 'articulated' => true, 'refit' => true, 'morphology' => true,  'zones' => true, 'measurements' => false,  'methods' => true, 'mni' => false, 'dental' => false, 'countable' => true,
			'image_zones' => 'thoracic_500.png', 'image_measurements' => null, 'measurements_help_url' => '', 'zones_help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/zones/#thoracic-and-lumbar-vertebrae',
            'methods_age' => true, 'methods_sex' => false, 'methods_ancestry' => false, 'methods_stature' => false,
            'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
		(!$bone->exists) ? $bone->fill($data)->save() : $bone->fill(array_except($data, ['created_at']))->save();

        $bone = SkeletalBone::firstOrNew(['name' => 'Vomer']);
        $data = array('name' => 'Vomer',  'search_name' => 'vomer', 'category'=> 'Cranial', 'type' => 'Flat', 'group' => 'Axial', 
			'description' => 'Cranial', 'middle' => 'false', 'paired' => false, 'articulated' => true, 'refit' => false, 'morphology' => false,  'zones' => false, 'measurements' => false,  'methods' => true, 'mni' => true, 'dental' => false,
			'image_zones' => null, 'image_measurements' => null, 'measurements_help_url' => '', 'zones_help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/zones/#cranium',
            'methods_age' => true, 'methods_sex' => false, 'methods_ancestry' => false, 'methods_stature' => false,
            'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
		(!$bone->exists) ? $bone->fill($data)->save() : $bone->fill(array_except($data, ['created_at']))->save();

        $bone = SkeletalBone::firstOrNew(['name' => 'Xiphoid process']);
        $data = array('name' => 'Xiphoid process',  'search_name' => 'xiphoid process', 'category'=> 'Thoracic Cage', 'type' => 'Flat', 'group' => 'Axial', 
			'description' => 'Sternum', 'middle' => 'false', 'paired' => false, 'articulated' => true, 'refit' => false, 'morphology' => false,  'zones' => false, 'measurements' => false,  'methods' => true, 'mni' => true, 'dental' => false,
			'image_zones' => null, 'image_measurements' => null, 'measurements_help_url' => '', 'zones_help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/zones/#sternum',
            'methods_age' => true, 'methods_sex' => false, 'methods_ancestry' => false, 'methods_stature' => false,
            'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
		(!$bone->exists) ? $bone->fill($data)->save() : $bone->fill(array_except($data, ['created_at']))->save();

        $bone = SkeletalBone::firstOrNew(['name' => 'Zygomatic']);
        $data = array('name' => 'Zygomatic',  'search_name' => 'zygomatic', 'category'=> 'Cranial', 'type' => 'Flat', 'group' => 'Axial', 
			'description' => 'Cranial', 'middle' => 'false', 'paired' => true, 'articulated' => true, 'refit' => false, 'morphology' => true,  'zones' => false, 'measurements' => false,  'methods' => true, 'mni' => true, 'dental' => false,
			'image_zones' => null, 'image_measurements' => null, 'measurements_help_url' => '', 'zones_help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/zones/#cranium',
            'methods_age' => true, 'methods_sex' => false, 'methods_ancestry' => false, 'methods_stature' => false,
            'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
		(!$bone->exists) ? $bone->fill($data)->save() : $bone->fill(array_except($data, ['created_at']))->save();

        $bone = SkeletalBone::firstOrNew(['name' => 'Tooth']);
        $data = array('name' => 'Tooth',  'search_name' => 'tooth', 'category'=> 'Cranial', 'type' => 'Tooth', 'group' => 'Tooth',
            'description' => 'Tooth', 'middle' => 'false', 'paired' => false, 'articulated' => true, 'refit' => false, 'morphology' => true,  'zones' => true, 'measurements' => false,  'methods' => false, 'mni' => false, 'dental' => true, 'countable' => true,
            'image_zones' => null, 'image_measurements' => null, 'measurements_help_url' => '', 'zones_help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/zones/#tooth',
            'methods_age' => false, 'methods_sex' => false, 'methods_ancestry' => false, 'methods_stature' => false, 
            'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$bone->exists) ? $bone->fill($data)->save() : $bone->fill(array_except($data, ['created_at']))->save();

        $bone = SkeletalBone::firstOrNew(['name' => 'Tooth 1']);
        $data = array('name' => 'Tooth 1',  'search_name' => 'tooth 1', 'category'=> 'teeth', 'type' => 'Tooth', 'group' => 'Tooth',
            'description' => 'Tooth', 'middle' => 'false', 'paired' => false, 'articulated' => true, 'refit' => false, 'morphology' => true,  'zones' => true, 'measurements' => false,  'methods' => false, 'mni' => true, 'dental' => true,
            'image_zones' => null, 'image_measurements' => null, 'measurements_help_url' => '', 'zones_help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/zones/#tooth',
            'methods_age' => true, 'methods_sex' => false, 'methods_ancestry' => false, 'methods_stature' => false,
            'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$bone->exists) ? $bone->fill($data)->save() : $bone->fill(array_except($data, ['created_at']))->save();

        $bone = SkeletalBone::firstOrNew(['name' => 'Tooth 2']);
        $data = array('name' => 'Tooth 2',  'search_name' => 'tooth 2', 'category'=> 'teeth', 'type' => 'Tooth', 'group' => 'Tooth',
            'description' => 'Tooth', 'middle' => 'false', 'paired' => false, 'articulated' => true, 'refit' => false, 'morphology' => true,  'zones' => true, 'measurements' => false,  'methods' => false, 'mni' => true, 'dental' => true,
            'image_zones' => null, 'image_measurements' => null, 'measurements_help_url' => '', 'zones_help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/zones/#tooth',
            'methods_age' => false, 'methods_sex' => false, 'methods_ancestry' => false, 'methods_stature' => false, 
            'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$bone->exists) ? $bone->fill($data)->save() : $bone->fill(array_except($data, ['created_at']))->save();

        $bone = SkeletalBone::firstOrNew(['name' => 'Tooth 3']);
        $data = array('name' => 'Tooth 3',  'search_name' => 'tooth 3', 'category'=> 'teeth', 'type' => 'Tooth', 'group' => 'Tooth',
            'description' => 'Tooth', 'middle' => 'false', 'paired' => false, 'articulated' => true, 'refit' => false, 'morphology' => true,  'zones' => true, 'measurements' => false,  'methods' => false, 'mni' => true, 'dental' => true,
            'image_zones' => null, 'image_measurements' => null, 'measurements_help_url' => '', 'zones_help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/zones/#tooth',
            'methods_age' => false, 'methods_sex' => false, 'methods_ancestry' => false, 'methods_stature' => false, 
            'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$bone->exists) ? $bone->fill($data)->save() : $bone->fill(array_except($data, ['created_at']))->save();

        $bone = SkeletalBone::firstOrNew(['name' => 'Tooth 4']);
        $data = array('name' => 'Tooth 4',  'search_name' => 'tooth 4', 'category'=> 'teeth', 'type' => 'Tooth', 'group' => 'Tooth',
            'description' => 'Tooth', 'middle' => 'false', 'paired' => false, 'articulated' => true, 'refit' => false, 'morphology' => true,  'zones' => true, 'measurements' => false,  'methods' => false, 'mni' => true, 'dental' => true,
            'image_zones' => null, 'image_measurements' => null, 'measurements_help_url' => '', 'zones_help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/zones/#tooth',
            'methods_age' => false, 'methods_sex' => false, 'methods_ancestry' => false, 'methods_stature' => false, 
            'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$bone->exists) ? $bone->fill($data)->save() : $bone->fill(array_except($data, ['created_at']))->save();

        $bone = SkeletalBone::firstOrNew(['name' => 'Tooth 5']);
        $data = array('name' => 'Tooth 5',  'search_name' => 'tooth 5', 'category'=> 'teeth', 'type' => 'Tooth', 'group' => 'Tooth',
            'description' => 'Tooth', 'middle' => 'false', 'paired' => false, 'articulated' => true, 'refit' => false, 'morphology' => true,  'zones' => true, 'measurements' => false,  'methods' => false, 'mni' => true, 'dental' => true,
            'image_zones' => null, 'image_measurements' => null, 'measurements_help_url' => '', 'zones_help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/zones/#tooth',
            'methods_age' => false, 'methods_sex' => false, 'methods_ancestry' => false, 'methods_stature' => false, 
            'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$bone->exists) ? $bone->fill($data)->save() : $bone->fill(array_except($data, ['created_at']))->save();

        $bone = SkeletalBone::firstOrNew(['name' => 'Tooth 6']);
        $data = array('name' => 'Tooth 6',  'search_name' => 'tooth 6', 'category'=> 'teeth', 'type' => 'Tooth', 'group' => 'Tooth',
            'description' => 'Tooth', 'middle' => 'false', 'paired' => false, 'articulated' => true, 'refit' => false, 'morphology' => true,  'zones' => true, 'measurements' => false,  'methods' => false, 'mni' => true, 'dental' => true,
            'image_zones' => null, 'image_measurements' => null, 'measurements_help_url' => '', 'zones_help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/zones/#tooth',
            'methods_age' => false, 'methods_sex' => false, 'methods_ancestry' => false, 'methods_stature' => false, 
            'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$bone->exists) ? $bone->fill($data)->save() : $bone->fill(array_except($data, ['created_at']))->save();

        $bone = SkeletalBone::firstOrNew(['name' => 'Tooth 7']);
        $data = array('name' => 'Tooth 7',  'search_name' => 'tooth 7', 'category'=> 'teeth', 'type' => 'Tooth', 'group' => 'Tooth',
            'description' => 'Tooth', 'middle' => 'false', 'paired' => false, 'articulated' => true, 'refit' => false, 'morphology' => true,  'zones' => true, 'measurements' => false,  'methods' => false, 'mni' => true, 'dental' => true,
            'image_zones' => null, 'image_measurements' => null, 'measurements_help_url' => '', 'zones_help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/zones/#tooth',
            'methods_age' => false, 'methods_sex' => false, 'methods_ancestry' => false, 'methods_stature' => false, 
            'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$bone->exists) ? $bone->fill($data)->save() : $bone->fill(array_except($data, ['created_at']))->save();

        $bone = SkeletalBone::firstOrNew(['name' => 'Tooth 8']);
        $data = array('name' => 'Tooth 8',  'search_name' => 'tooth 8', 'category'=> 'teeth', 'type' => 'Tooth', 'group' => 'Tooth',
            'description' => 'Tooth', 'middle' => 'false', 'paired' => false, 'articulated' => true, 'refit' => false, 'morphology' => true,  'zones' => true, 'measurements' => false,  'methods' => false, 'mni' => true, 'dental' => true,
            'image_zones' => null, 'image_measurements' => null, 'measurements_help_url' => '', 'zones_help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/zones/#tooth',
            'methods_age' => false, 'methods_sex' => false, 'methods_ancestry' => false, 'methods_stature' => false, 
            'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$bone->exists) ? $bone->fill($data)->save() : $bone->fill(array_except($data, ['created_at']))->save();

        $bone = SkeletalBone::firstOrNew(['name' => 'Tooth 9']);
        $data = array('name' => 'Tooth 9',  'search_name' => 'tooth 9', 'category'=> 'teeth', 'type' => 'Tooth', 'group' => 'Tooth',
            'description' => 'Tooth', 'middle' => 'false', 'paired' => false, 'articulated' => true, 'refit' => false, 'morphology' => true,  'zones' => true, 'measurements' => false,  'methods' => false, 'mni' => true, 'dental' => true,
            'image_zones' => null, 'image_measurements' => null, 'measurements_help_url' => '', 'zones_help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/zones/#tooth',
            'methods_age' => false, 'methods_sex' => false, 'methods_ancestry' => false, 'methods_stature' => false, 
            'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$bone->exists) ? $bone->fill($data)->save() : $bone->fill(array_except($data, ['created_at']))->save();

        $bone = SkeletalBone::firstOrNew(['name' => 'Tooth 10']);
        $data = array('name' => 'Tooth 10',  'search_name' => 'tooth 10', 'category'=> 'teeth', 'type' => 'Tooth', 'group' => 'Tooth',
            'description' => 'Tooth', 'middle' => 'false', 'paired' => false, 'articulated' => true, 'refit' => false, 'morphology' => true,  'zones' => true, 'measurements' => false,  'methods' => false, 'mni' => true, 'dental' => true,
            'image_zones' => null, 'image_measurements' => null, 'measurements_help_url' => '', 'zones_help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/zones/#tooth',
            'methods_age' => false, 'methods_sex' => false, 'methods_ancestry' => false, 'methods_stature' => false, 
            'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$bone->exists) ? $bone->fill($data)->save() : $bone->fill(array_except($data, ['created_at']))->save();

        $bone = SkeletalBone::firstOrNew(['name' => 'Tooth 11']);
        $data = array('name' => 'Tooth 11',  'search_name' => 'tooth 11', 'category'=> 'teeth', 'type' => 'Tooth', 'group' => 'Tooth',
            'description' => 'Tooth', 'middle' => 'false', 'paired' => false, 'articulated' => true, 'refit' => false, 'morphology' => true,  'zones' => true, 'measurements' => false,  'methods' => false, 'mni' => true, 'dental' => true,
            'image_zones' => null, 'image_measurements' => null, 'measurements_help_url' => '', 'zones_help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/zones/#tooth',
            'methods_age' => false, 'methods_sex' => false, 'methods_ancestry' => false, 'methods_stature' => false, 
            'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$bone->exists) ? $bone->fill($data)->save() : $bone->fill(array_except($data, ['created_at']))->save();

        $bone = SkeletalBone::firstOrNew(['name' => 'Tooth 12']);
        $data = array('name' => 'Tooth 12',  'search_name' => 'tooth 12', 'category'=> 'teeth', 'type' => 'Tooth', 'group' => 'Tooth',
            'description' => 'Tooth', 'middle' => 'false', 'paired' => false, 'articulated' => true, 'refit' => false, 'morphology' => true,  'zones' => true, 'measurements' => false,  'methods' => false, 'mni' => true, 'dental' => true,
            'image_zones' => null, 'image_measurements' => null, 'measurements_help_url' => '', 'zones_help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/zones/#tooth',
            'methods_age' => false, 'methods_sex' => false, 'methods_ancestry' => false, 'methods_stature' => false, 
            'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$bone->exists) ? $bone->fill($data)->save() : $bone->fill(array_except($data, ['created_at']))->save();

        $bone = SkeletalBone::firstOrNew(['name' => 'Tooth 13']);
        $data = array('name' => 'Tooth 13',  'search_name' => 'tooth 13', 'category'=> 'teeth', 'type' => 'Tooth', 'group' => 'Tooth',
            'description' => 'Tooth', 'middle' => 'false', 'paired' => false, 'articulated' => true, 'refit' => false, 'morphology' => true,  'zones' => true, 'measurements' => false,  'methods' => false, 'mni' => true, 'dental' => true,
            'image_zones' => null, 'image_measurements' => null, 'measurements_help_url' => '', 'zones_help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/zones/#tooth',
            'methods_age' => false, 'methods_sex' => false, 'methods_ancestry' => false, 'methods_stature' => false, 
            'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$bone->exists) ? $bone->fill($data)->save() : $bone->fill(array_except($data, ['created_at']))->save();

        $bone = SkeletalBone::firstOrNew(['name' => 'Tooth 14']);
        $data = array('name' => 'Tooth 14',  'search_name' => 'tooth 14', 'category'=> 'teeth', 'type' => 'Tooth', 'group' => 'Tooth',
            'description' => 'Tooth', 'middle' => 'false', 'paired' => false, 'articulated' => true, 'refit' => false, 'morphology' => true,  'zones' => true, 'measurements' => false,  'methods' => false, 'mni' => true, 'dental' => true,
            'image_zones' => null, 'image_measurements' => null, 'measurements_help_url' => '', 'zones_help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/zones/#tooth',
            'methods_age' => false, 'methods_sex' => false, 'methods_ancestry' => false, 'methods_stature' => false, 
            'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$bone->exists) ? $bone->fill($data)->save() : $bone->fill(array_except($data, ['created_at']))->save();

        $bone = SkeletalBone::firstOrNew(['name' => 'Tooth 15']);
        $data = array('name' => 'Tooth 15',  'search_name' => 'tooth 15', 'category'=> 'teeth', 'type' => 'Tooth', 'group' => 'Tooth',
            'description' => 'Tooth', 'middle' => 'false', 'paired' => false, 'articulated' => true, 'refit' => false, 'morphology' => true,  'zones' => true, 'measurements' => false,  'methods' => false, 'mni' => true, 'dental' => true,
            'image_zones' => null, 'image_measurements' => null, 'measurements_help_url' => '', 'zones_help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/zones/#tooth',
            'methods_age' => false, 'methods_sex' => false, 'methods_ancestry' => false, 'methods_stature' => false, 
            'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$bone->exists) ? $bone->fill($data)->save() : $bone->fill(array_except($data, ['created_at']))->save();

        $bone = SkeletalBone::firstOrNew(['name' => 'Tooth 16']);
        $data = array('name' => 'Tooth 16',  'search_name' => 'tooth 16', 'category'=> 'teeth', 'type' => 'Tooth', 'group' => 'Tooth',
            'description' => 'Tooth', 'middle' => 'false', 'paired' => false, 'articulated' => true, 'refit' => false, 'morphology' => true,  'zones' => true, 'measurements' => false,  'methods' => false, 'mni' => true, 'dental' => true,
            'image_zones' => null, 'image_measurements' => null, 'measurements_help_url' => '', 'zones_help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/zones/#tooth',
            'methods_age' => true, 'methods_sex' => false, 'methods_ancestry' => false, 'methods_stature' => false,
            'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$bone->exists) ? $bone->fill($data)->save() : $bone->fill(array_except($data, ['created_at']))->save();

        $bone = SkeletalBone::firstOrNew(['name' => 'Tooth 17']);
        $data = array('name' => 'Tooth 17',  'search_name' => 'tooth 17', 'category'=> 'teeth', 'type' => 'Tooth', 'group' => 'Tooth',
            'description' => 'Tooth', 'middle' => 'false', 'paired' => false, 'articulated' => true, 'refit' => false, 'morphology' => true,  'zones' => true, 'measurements' => false,  'methods' => false, 'mni' => true, 'dental' => true,
            'image_zones' => null, 'image_measurements' => null, 'measurements_help_url' => '', 'zones_help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/zones/#tooth',
            'methods_age' => true, 'methods_sex' => false, 'methods_ancestry' => false, 'methods_stature' => false,
            'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$bone->exists) ? $bone->fill($data)->save() : $bone->fill(array_except($data, ['created_at']))->save();

        $bone = SkeletalBone::firstOrNew(['name' => 'Tooth 18']);
        $data = array('name' => 'Tooth 18',  'search_name' => 'tooth 18', 'category'=> 'teeth', 'type' => 'Tooth', 'group' => 'Tooth',
            'description' => 'Tooth', 'middle' => 'false', 'paired' => false, 'articulated' => true, 'refit' => false, 'morphology' => true,  'zones' => true, 'measurements' => false,  'methods' => false, 'mni' => true, 'dental' => true,
            'image_zones' => null, 'image_measurements' => null, 'measurements_help_url' => '', 'zones_help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/zones/#tooth',
            'methods_age' => false, 'methods_sex' => false, 'methods_ancestry' => false, 'methods_stature' => false, 
            'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$bone->exists) ? $bone->fill($data)->save() : $bone->fill(array_except($data, ['created_at']))->save();

        $bone = SkeletalBone::firstOrNew(['name' => 'Tooth 19']);
        $data = array('name' => 'Tooth 19',  'search_name' => 'tooth 19', 'category'=> 'teeth', 'type' => 'Tooth', 'group' => 'Tooth',
            'description' => 'Tooth', 'middle' => 'false', 'paired' => false, 'articulated' => true, 'refit' => false, 'morphology' => true,  'zones' => true, 'measurements' => false,  'methods' => false, 'mni' => true, 'dental' => true,
            'image_zones' => null, 'image_measurements' => null, 'measurements_help_url' => '', 'zones_help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/zones/#tooth',
            'methods_age' => false, 'methods_sex' => false, 'methods_ancestry' => false, 'methods_stature' => false, 
            'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$bone->exists) ? $bone->fill($data)->save() : $bone->fill(array_except($data, ['created_at']))->save();

        $bone = SkeletalBone::firstOrNew(['name' => 'Tooth 20']);
        $data = array('name' => 'Tooth 20',  'search_name' => 'tooth 20', 'category'=> 'teeth', 'type' => 'Tooth', 'group' => 'Tooth',
            'description' => 'Tooth', 'middle' => 'false', 'paired' => false, 'articulated' => true, 'refit' => false, 'morphology' => true,  'zones' => true, 'measurements' => false,  'methods' => false, 'mni' => true, 'dental' => true,
            'image_zones' => null, 'image_measurements' => null, 'measurements_help_url' => '', 'zones_help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/zones/#tooth',
            'methods_age' => false, 'methods_sex' => false, 'methods_ancestry' => false, 'methods_stature' => false, 
            'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$bone->exists) ? $bone->fill($data)->save() : $bone->fill(array_except($data, ['created_at']))->save();

        $bone = SkeletalBone::firstOrNew(['name' => 'Tooth 21']);
        $data = array('name' => 'Tooth 21',  'search_name' => 'tooth 21', 'category'=> 'teeth', 'type' => 'Tooth', 'group' => 'Tooth',
            'description' => 'Tooth', 'middle' => 'false', 'paired' => false, 'articulated' => true, 'refit' => false, 'morphology' => true,  'zones' => true, 'measurements' => false,  'methods' => false, 'mni' => true, 'dental' => true,
            'image_zones' => null, 'image_measurements' => null, 'measurements_help_url' => '', 'zones_help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/zones/#tooth',
            'methods_age' => false, 'methods_sex' => false, 'methods_ancestry' => false, 'methods_stature' => false, 
            'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$bone->exists) ? $bone->fill($data)->save() : $bone->fill(array_except($data, ['created_at']))->save();

        $bone = SkeletalBone::firstOrNew(['name' => 'Tooth 22']);
        $data = array('name' => 'Tooth 22',  'search_name' => 'tooth 22', 'category'=> 'teeth', 'type' => 'Tooth', 'group' => 'Tooth',
            'description' => 'Tooth', 'middle' => 'false', 'paired' => false, 'articulated' => true, 'refit' => false, 'morphology' => true,  'zones' => true, 'measurements' => false,  'methods' => false, 'mni' => true, 'dental' => true,
            'image_zones' => null, 'image_measurements' => null, 'measurements_help_url' => '', 'zones_help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/zones/#tooth',
            'methods_age' => false, 'methods_sex' => false, 'methods_ancestry' => false, 'methods_stature' => false, 
            'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$bone->exists) ? $bone->fill($data)->save() : $bone->fill(array_except($data, ['created_at']))->save();

        $bone = SkeletalBone::firstOrNew(['name' => 'Tooth 23']);
        $data = array('name' => 'Tooth 23',  'search_name' => 'tooth 23', 'category'=> 'teeth', 'type' => 'Tooth', 'group' => 'Tooth',
            'description' => 'Tooth', 'middle' => 'false', 'paired' => false, 'articulated' => true, 'refit' => false, 'morphology' => true,  'zones' => true, 'measurements' => false,  'methods' => false, 'mni' => true, 'dental' => true,
            'image_zones' => null, 'image_measurements' => null, 'measurements_help_url' => '', 'zones_help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/zones/#tooth',
            'methods_age' => false, 'methods_sex' => false, 'methods_ancestry' => false, 'methods_stature' => false, 
            'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$bone->exists) ? $bone->fill($data)->save() : $bone->fill(array_except($data, ['created_at']))->save();

        $bone = SkeletalBone::firstOrNew(['name' => 'Tooth 24']);
        $data = array('name' => 'Tooth 24',  'search_name' => 'tooth 24', 'category'=> 'teeth', 'type' => 'Tooth', 'group' => 'Tooth',
            'description' => 'Tooth', 'middle' => 'false', 'paired' => false, 'articulated' => true, 'refit' => false, 'morphology' => true,  'zones' => true, 'measurements' => false,  'methods' => false, 'mni' => true, 'dental' => true,
            'image_zones' => null, 'image_measurements' => null, 'measurements_help_url' => '', 'zones_help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/zones/#tooth',
            'methods_age' => false, 'methods_sex' => false, 'methods_ancestry' => false, 'methods_stature' => false, 
            'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$bone->exists) ? $bone->fill($data)->save() : $bone->fill(array_except($data, ['created_at']))->save();

        $bone = SkeletalBone::firstOrNew(['name' => 'Tooth 25']);
        $data = array('name' => 'Tooth 25',  'search_name' => 'tooth 25', 'category'=> 'teeth', 'type' => 'Tooth', 'group' => 'Tooth',
            'description' => 'Tooth', 'middle' => 'false', 'paired' => false, 'articulated' => true, 'refit' => false, 'morphology' => true,  'zones' => true, 'measurements' => false,  'methods' => false, 'mni' => true, 'dental' => true,
            'image_zones' => null, 'image_measurements' => null, 'measurements_help_url' => '', 'zones_help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/zones/#tooth',
            'methods_age' => false, 'methods_sex' => false, 'methods_ancestry' => false, 'methods_stature' => false, 
            'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$bone->exists) ? $bone->fill($data)->save() : $bone->fill(array_except($data, ['created_at']))->save();

        $bone = SkeletalBone::firstOrNew(['name' => 'Tooth 26']);
        $data = array('name' => 'Tooth 26',  'search_name' => 'tooth 26', 'category'=> 'teeth', 'type' => 'Tooth', 'group' => 'Tooth',
            'description' => 'Tooth', 'middle' => 'false', 'paired' => false, 'articulated' => true, 'refit' => false, 'morphology' => true,  'zones' => true, 'measurements' => false,  'methods' => false, 'mni' => true, 'dental' => true,
            'image_zones' => null, 'image_measurements' => null, 'measurements_help_url' => '', 'zones_help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/zones/#tooth',
            'methods_age' => false, 'methods_sex' => false, 'methods_ancestry' => false, 'methods_stature' => false, 
            'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$bone->exists) ? $bone->fill($data)->save() : $bone->fill(array_except($data, ['created_at']))->save();

        $bone = SkeletalBone::firstOrNew(['name' => 'Tooth 27']);
        $data = array('name' => 'Tooth 27',  'search_name' => 'tooth 27', 'category'=> 'teeth', 'type' => 'Tooth', 'group' => 'Tooth',
            'description' => 'Tooth', 'middle' => 'false', 'paired' => false, 'articulated' => true, 'refit' => false, 'morphology' => true,  'zones' => true, 'measurements' => false,  'methods' => false, 'mni' => true, 'dental' => true,
            'image_zones' => null, 'image_measurements' => null, 'measurements_help_url' => '', 'zones_help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/zones/#tooth',
            'methods_age' => false, 'methods_sex' => false, 'methods_ancestry' => false, 'methods_stature' => false, 
            'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$bone->exists) ? $bone->fill($data)->save() : $bone->fill(array_except($data, ['created_at']))->save();

        $bone = SkeletalBone::firstOrNew(['name' => 'Tooth 28']);
        $data = array('name' => 'Tooth 28',  'search_name' => 'tooth 28', 'category'=> 'teeth', 'type' => 'Tooth', 'group' => 'Tooth',
            'description' => 'Tooth', 'middle' => 'false', 'paired' => false, 'articulated' => true, 'refit' => false, 'morphology' => true,  'zones' => true, 'measurements' => false,  'methods' => false, 'mni' => true, 'dental' => true,
            'image_zones' => null, 'image_measurements' => null, 'measurements_help_url' => '', 'zones_help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/zones/#tooth',
            'methods_age' => false, 'methods_sex' => false, 'methods_ancestry' => false, 'methods_stature' => false, 
            'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$bone->exists) ? $bone->fill($data)->save() : $bone->fill(array_except($data, ['created_at']))->save();

        $bone = SkeletalBone::firstOrNew(['name' => 'Tooth 29']);
        $data = array('name' => 'Tooth 29',  'search_name' => 'tooth 29', 'category'=> 'teeth', 'type' => 'Tooth', 'group' => 'Tooth',
            'description' => 'Tooth', 'middle' => 'false', 'paired' => false, 'articulated' => true, 'refit' => false, 'morphology' => true,  'zones' => true, 'measurements' => false,  'methods' => false, 'mni' => true, 'dental' => true,
            'image_zones' => null, 'image_measurements' => null, 'measurements_help_url' => '', 'zones_help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/zones/#tooth',
            'methods_age' => false, 'methods_sex' => false, 'methods_ancestry' => false, 'methods_stature' => false, 
            'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$bone->exists) ? $bone->fill($data)->save() : $bone->fill(array_except($data, ['created_at']))->save();

        $bone = SkeletalBone::firstOrNew(['name' => 'Tooth 30']);
        $data = array('name' => 'Tooth 30',  'search_name' => 'tooth 30', 'category'=> 'teeth', 'type' => 'Tooth', 'group' => 'Tooth',
            'description' => 'Tooth', 'middle' => 'false', 'paired' => false, 'articulated' => true, 'refit' => false, 'morphology' => true,  'zones' => true, 'measurements' => false,  'methods' => false, 'mni' => true, 'dental' => true,
            'image_zones' => null, 'image_measurements' => null, 'measurements_help_url' => '', 'zones_help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/zones/#tooth',
            'methods_age' => false, 'methods_sex' => false, 'methods_ancestry' => false, 'methods_stature' => false, 
            'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$bone->exists) ? $bone->fill($data)->save() : $bone->fill(array_except($data, ['created_at']))->save();

        $bone = SkeletalBone::firstOrNew(['name' => 'Tooth 31']);
        $data = array('name' => 'Tooth 31',  'search_name' => 'tooth 31', 'category'=> 'teeth', 'type' => 'Tooth', 'group' => 'Tooth',
            'description' => 'Tooth', 'middle' => 'false', 'paired' => false, 'articulated' => true, 'refit' => false, 'morphology' => true,  'zones' => true, 'measurements' => false,  'methods' => false, 'mni' => true, 'dental' => true,
            'image_zones' => null, 'image_measurements' => null, 'measurements_help_url' => '', 'zones_help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/zones/#tooth',
            'methods_age' => false, 'methods_sex' => false, 'methods_ancestry' => false, 'methods_stature' => false, 
            'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$bone->exists) ? $bone->fill($data)->save() : $bone->fill(array_except($data, ['created_at']))->save();

        $bone = SkeletalBone::firstOrNew(['name' => 'Tooth 32']);
        $data = array('name' => 'Tooth 32',  'search_name' => 'tooth 32', 'category'=> 'teeth', 'type' => 'Tooth', 'group' => 'Tooth',
            'description' => 'Tooth', 'middle' => 'false', 'paired' => false, 'articulated' => true, 'refit' => false, 'morphology' => true,  'zones' => true, 'measurements' => false,  'methods' => false, 'mni' => true, 'dental' => true,
            'image_zones' => null, 'image_measurements' => null, 'measurements_help_url' => '', 'zones_help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/zones/#tooth',
            'methods_age' => true, 'methods_sex' => false, 'methods_ancestry' => false, 'methods_stature' => false,
            'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$bone->exists) ? $bone->fill($data)->save() : $bone->fill(array_except($data, ['created_at']))->save();

        $bone = SkeletalBone::firstOrNew(['name' => 'Tissue']);
        $data = array('name' => 'Tissue',  'search_name' => 'tissue', 'category'=> 'tissue', 'type' => 'Tissue', 'group' => 'Tissue',
            'description' => 'Tissue', 'middle' => 'false', 'paired' => false, 'articulated' => false, 'refit' => false, 'morphology' => false,  'zones' => false, 'measurements' => false,  'methods' => false, 'mni' => false, 'dental' => false, 'countable' => true,
            'image_zones' => null, 'image_measurements' => null, 'measurements_help_url' => '', 'zones_help_url' => '',
            'methods_age' => false, 'methods_sex' => false, 'methods_ancestry' => false, 'methods_stature' => false, 
            'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$bone->exists) ? $bone->fill($data)->save() : $bone->fill(array_except($data, ['created_at']))->save();

        $bone = SkeletalBone::firstOrNew(['name' => 'Hair']);
        $data = array('name' => 'Hair',  'search_name' => 'hair', 'category'=> 'hair', 'type' => 'Hair', 'group' => 'Hair',
            'description' => 'Hair', 'middle' => 'false', 'paired' => false, 'articulated' => false, 'refit' => false, 'morphology' => false,  'zones' => false, 'measurements' => false,  'methods' => false, 'mni' => false, 'dental' => false, 'countable' => true,
            'image_zones' => null, 'image_measurements' => null, 'measurements_help_url' => '', 'zones_help_url' => '',
            'methods_age' => false, 'methods_sex' => false, 'methods_ancestry' => false, 'methods_stature' => false, 
            'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$bone->exists) ? $bone->fill($data)->save() : $bone->fill(array_except($data, ['created_at']))->save();

        $bone = SkeletalBone::firstOrNew(['name' => 'Maxillary Tooth']);
        $data = array('name' => 'Maxillary Tooth',  'search_name' => 'maxillary tooth', 'category'=> 'Cranial', 'type' => 'Tooth', 'group' => 'Tooth',
            'description' => 'Maxillary Tooth', 'middle' => 'false', 'paired' => false, 'articulated' => true, 'refit' => false, 'morphology' => true,  'zones' => true, 'measurements' => false,  'methods' => false, 'mni' => false, 'dental' => true, 'countable' => true,
            'image_zones' => null, 'image_measurements' => null, 'measurements_help_url' => '', 'zones_help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/zones/#tooth',
            'methods_age' => false, 'methods_sex' => false, 'methods_ancestry' => false, 'methods_stature' => false, 
            'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$bone->exists) ? $bone->fill($data)->save() : $bone->fill(array_except($data, ['created_at']))->save();

        $bone = SkeletalBone::firstOrNew(['name' => 'Mandibular Tooth']);
        $data = array('name' => 'Mandibular Tooth',  'search_name' => 'mandibular tooth', 'category'=> 'Cranial', 'type' => 'Tooth', 'group' => 'Tooth',
            'description' => 'Mandibular Tooth', 'middle' => 'false', 'paired' => false, 'articulated' => true, 'refit' => false, 'morphology' => true,  'zones' => true, 'measurements' => false,  'methods' => false, 'mni' => false, 'dental' => true, 'countable' => true,
            'image_zones' => null, 'image_measurements' => null, 'measurements_help_url' => '', 'zones_help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/zones/#tooth',
            'methods_age' => false, 'methods_sex' => false, 'methods_ancestry' => false, 'methods_stature' => false, 
            'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$bone->exists) ? $bone->fill($data)->save() : $bone->fill(array_except($data, ['created_at']))->save();

        $bone = SkeletalBone::firstOrNew(['name' => 'Incisor']);
        $data = array('name' => 'Incisor',  'search_name' => 'incisor', 'category'=> 'teeth', 'type' => 'Tooth', 'group' => 'Tooth',
            'description' => 'Incisor Tooth', 'middle' => 'false', 'paired' => false, 'articulated' => true, 'refit' => false, 'morphology' => true,  'zones' => true, 'measurements' => false,  'methods' => false, 'mni' => false, 'dental' => true,
            'image_zones' => null, 'image_measurements' => null, 'measurements_help_url' => '', 'zones_help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/zones/#tooth',
            'methods_age' => false, 'methods_sex' => false, 'methods_ancestry' => false, 'methods_stature' => false, 
            'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$bone->exists) ? $bone->fill($data)->save() : $bone->fill(array_except($data, ['created_at']))->save();

        $bone = SkeletalBone::firstOrNew(['name' => 'Canine']);
        $data = array('name' => 'Canine',  'search_name' => 'canine', 'category'=> 'teeth', 'type' => 'Tooth', 'group' => 'Tooth',
            'description' => 'Canine Tooth', 'middle' => 'false', 'paired' => false, 'articulated' => true, 'refit' => false, 'morphology' => true,  'zones' => true, 'measurements' => false,  'methods' => false, 'mni' => false, 'dental' => true,
            'image_zones' => null, 'image_measurements' => null, 'measurements_help_url' => '', 'zones_help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/zones/#tooth',
            'methods_age' => false, 'methods_sex' => false, 'methods_ancestry' => false, 'methods_stature' => false, 
            'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$bone->exists) ? $bone->fill($data)->save() : $bone->fill(array_except($data, ['created_at']))->save();

        $bone = SkeletalBone::firstOrNew(['name' => 'Premolar']);
        $data = array('name' => 'Premolar',  'search_name' => 'premolar', 'category'=> 'teeth', 'type' => 'Tooth', 'group' => 'Tooth',
            'description' => 'Premolar Tooth', 'middle' => 'false', 'paired' => false, 'articulated' => true, 'refit' => false, 'morphology' => true,  'zones' => true, 'measurements' => false,  'methods' => false, 'mni' => false, 'dental' => true,
            'image_zones' => null, 'image_measurements' => null, 'measurements_help_url' => '', 'zones_help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/zones/#tooth',
            'methods_age' => false, 'methods_sex' => false, 'methods_ancestry' => false, 'methods_stature' => false, 
            'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$bone->exists) ? $bone->fill($data)->save() : $bone->fill(array_except($data, ['created_at']))->save();

        $bone = SkeletalBone::firstOrNew(['name' => 'Molar']);
        $data = array('name' => 'Molar',  'search_name' => 'molar', 'category'=> 'teeth', 'type' => 'Tooth', 'group' => 'Tooth',
            'description' => 'Molar Tooth', 'middle' => 'false', 'paired' => false, 'articulated' => true, 'refit' => false, 'morphology' => true,  'zones' => true, 'measurements' => false,  'methods' => false, 'mni' => false, 'dental' => true,
            'image_zones' => null, 'image_measurements' => null, 'measurements_help_url' => '', 'zones_help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/zones/#tooth',
            'methods_age' => false, 'methods_sex' => false, 'methods_ancestry' => false, 'methods_stature' => false, 
            'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$bone->exists) ? $bone->fill($data)->save() : $bone->fill(array_except($data, ['created_at']))->save();

        $bone = SkeletalBone::firstOrNew(['name' => 'Anterior Tooth']);
        $data = array('name' => 'Anterior Tooth',  'search_name' => 'anterior tooth', 'category'=> 'teeth', 'type' => 'Tooth', 'group' => 'Tooth',
            'description' => 'Anterior Tooth', 'middle' => 'false', 'paired' => false, 'articulated' => true, 'refit' => false, 'morphology' => true,  'zones' => true, 'measurements' => false,  'methods' => false, 'mni' => false, 'dental' => true,
            'image_zones' => null, 'image_measurements' => null, 'measurements_help_url' => '', 'zones_help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/zones/#tooth',
            'methods_age' => false, 'methods_sex' => false, 'methods_ancestry' => false, 'methods_stature' => false, 
            'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$bone->exists) ? $bone->fill($data)->save() : $bone->fill(array_except($data, ['created_at']))->save();

        $bone = SkeletalBone::firstOrNew(['name' => 'Posterior Tooth']);
        $data = array('name' => 'Posterior Tooth',  'search_name' => 'posterior tooth', 'category'=> 'teeth', 'type' => 'Tooth', 'group' => 'Tooth',
            'description' => 'Posterior Tooth', 'middle' => 'false', 'paired' => false, 'articulated' => true, 'refit' => false, 'morphology' => true,  'zones' => true, 'measurements' => false,  'methods' => false, 'mni' => false, 'dental' => true,
            'image_zones' => null, 'image_measurements' => null, 'measurements_help_url' => '', 'zones_help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/zones/#tooth',
            'methods_age' => false, 'methods_sex' => false, 'methods_ancestry' => false, 'methods_stature' => false, 
            'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$bone->exists) ? $bone->fill($data)->save() : $bone->fill(array_except($data, ['created_at']))->save();
    }
}