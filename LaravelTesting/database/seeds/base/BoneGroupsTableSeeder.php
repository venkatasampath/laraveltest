<?php
use Illuminate\Database\Seeder;
use App\SkeletalBone;
use App\BoneGroup;

class BoneGroupsTableSeeder extends Seeder
{
    protected $dt = null;
    protected $sys = 'System';

    public function run()
    {
        $this->dt = date_create();

        $this->createArmGroup();
        $this->createShoulderGroup();
        $this->createArmAndShoulderGroup();
        $this->createHandGroup();
        $this->createRibsGroup();
        $this->createCervicalVertebraeGroup();
        $this->createThoracicVertebraeGroup();
        $this->createLumbarVertebraeGroup();
        $this->createThoraxGroup();
        $this->createPelvicGirdleGroup();
        $this->createLegGroup();
        $this->createFootGroup();
        $this->createMaxillaryDentitionGroup();
        $this->createMandibularDentitionGroup();
        $this->createVertebralColumnGroup();
//        $this->createSkullGroup();
//        $this->createSkeletonGroup();
    }

    protected function createArmGroup($group = null, $side = false, $middle = false)
    {
        if (!isset($group)) {
            $group = 'Arm';
        }
        
        $this->command->info($group . ' group seeding!');
        $sb_id = SkeletalBone::where('name', '=', 'Humerus')->first()->id;
        $bone_group = BoneGroup::firstOrNew(['group_name' => $group, 'sb_id' => $sb_id]);
        $data = array('group_name' => $group, 'sb_id' => $sb_id, 'middle' => $middle, 'side' => $side, 'display_order' => 1, 'for_articulation' => false, 'for_inventory' => true, 'created_by' => $this->sys, 'updated_by' => $this->sys, 'created_at' => $this->dt, 'updated_at' => $this->dt);
        (!$bone_group->exists) ? $bone_group->fill($data)->save() : $bone_group->fill(array_except($data, ['created_at']))->save();
        $sb_id = SkeletalBone::where('name', '=', 'Radius')->first()->id;
        $bone_group = BoneGroup::firstOrNew(['group_name' => $group, 'sb_id' => $sb_id]);
        $data = array('group_name' => $group, 'sb_id' => $sb_id, 'middle' => $middle, 'side' => $side, 'display_order' => 2, 'for_articulation' => false, 'for_inventory' => true, 'created_by' => $this->sys, 'updated_by' => $this->sys, 'created_at' => $this->dt, 'updated_at' => $this->dt);
        (!$bone_group->exists) ? $bone_group->fill($data)->save() : $bone_group->fill(array_except($data, ['created_at']))->save();
        $sb_id = SkeletalBone::where('name', '=', 'Ulna')->first()->id;
        $bone_group = BoneGroup::firstOrNew(['group_name' => $group, 'sb_id' => $sb_id]);
        $data = array('group_name' => $group, 'sb_id' => $sb_id, 'middle' => $middle, 'side' => $side, 'display_order' => 3, 'for_articulation' => false, 'for_inventory' => true, 'created_by' => $this->sys, 'updated_by' => $this->sys, 'created_at' => $this->dt, 'updated_at' => $this->dt);
        (!$bone_group->exists) ? $bone_group->fill($data)->save() : $bone_group->fill(array_except($data, ['created_at']))->save();
    }

    protected function createShoulderGroup($group = null, $side = false, $middle = false)
    {
        if (!isset($group)) {
            $group = 'Shoulder';
        }

        $this->command->info($group . ' group seeding!');
        $sb_id = SkeletalBone::where('name', '=', 'Scapula')->first()->id;
        $bone_group = BoneGroup::firstOrNew(['group_name' => $group, 'sb_id' => $sb_id]);
        $data = array('group_name' => $group, 'sb_id' => $sb_id, 'middle' => $middle, 'side' => $side, 'display_order' => 1, 'for_articulation' => false, 'for_inventory' => true, 'created_by' => $this->sys, 'updated_by' => $this->sys, 'created_at' => $this->dt, 'updated_at' => $this->dt);
        (!$bone_group->exists) ? $bone_group->fill($data)->save() : $bone_group->fill(array_except($data, ['created_at']))->save();
        $sb_id = SkeletalBone::where('name', '=', 'Clavicle')->first()->id;
        $bone_group = BoneGroup::firstOrNew(['group_name' => $group, 'sb_id' => $sb_id]);
        $data = array('group_name' => $group, 'sb_id' => $sb_id, 'middle' => $middle, 'side' => $side, 'display_order' => 2, 'for_articulation' => false, 'for_inventory' => true, 'created_by' => $this->sys, 'updated_by' => $this->sys, 'created_at' => $this->dt, 'updated_at' => $this->dt);
        (!$bone_group->exists) ? $bone_group->fill($data)->save() : $bone_group->fill(array_except($data, ['created_at']))->save();
    }

    protected function createArmAndShoulderGroup($group = null, $side = false, $middle = false)
    {
        if (!isset($group)) {
            $group = 'Arm and Shoulder';
        }

        $this->command->info($group . ' group seeding!');
        // The Arm and Shoulder group consists of bones from the Arm and Shoulder groups
        $this->createArmGroup($group, $side, $middle);
        $this->createShoulderGroup($group, $side, $middle);
    }

    protected function createHandGroup($group = null, $side = false, $middle = false)
    {
        if (!isset($group)) {
            $group = 'Hand';
        }

        $this->command->info($group . ' group seeding!');
        $sb_id = SkeletalBone::where('name', '=', 'Scaphoid')->first()->id;
        $bone_group = BoneGroup::firstOrNew(['group_name' => $group, 'sb_id' => $sb_id]);
        $data = array('group_name' => $group, 'sb_id' => $sb_id, 'middle' => $middle, 'side' => $side, 'display_order' => 1, 'for_articulation' => true, 'for_inventory' => true, 'created_by' => $this->sys, 'updated_by' => $this->sys, 'created_at' => $this->dt, 'updated_at' => $this->dt);
        (!$bone_group->exists) ? $bone_group->fill($data)->save() : $bone_group->fill(array_except($data, ['created_at']))->save();
        $sb_id = SkeletalBone::where('name', '=', 'Lunate')->first()->id;
        $bone_group = BoneGroup::firstOrNew(['group_name' => $group, 'sb_id' => $sb_id]);
        $data = array('group_name' => $group, 'sb_id' => $sb_id, 'middle' => $middle, 'side' => $side, 'display_order' => 2, 'for_articulation' => true, 'for_inventory' => true, 'created_by' => $this->sys, 'updated_by' => $this->sys, 'created_at' => $this->dt, 'updated_at' => $this->dt);
        (!$bone_group->exists) ? $bone_group->fill($data)->save() : $bone_group->fill(array_except($data, ['created_at']))->save();
        $sb_id = SkeletalBone::where('name', '=', 'Triquetral')->first()->id;
        $bone_group = BoneGroup::firstOrNew(['group_name' => $group, 'sb_id' => $sb_id]);
        $data = array('group_name' => $group, 'sb_id' => $sb_id, 'middle' => $middle, 'side' => $side, 'display_order' => 3, 'for_articulation' => true, 'for_inventory' => true, 'created_by' => $this->sys, 'updated_by' => $this->sys, 'created_at' => $this->dt, 'updated_at' => $this->dt);
        (!$bone_group->exists) ? $bone_group->fill($data)->save() : $bone_group->fill(array_except($data, ['created_at']))->save();
        $sb_id = SkeletalBone::where('name', '=', 'Pisiform')->first()->id;
        $bone_group = BoneGroup::firstOrNew(['group_name' => $group, 'sb_id' => $sb_id]);
        $data = array('group_name' => $group, 'sb_id' => $sb_id, 'middle' => $middle, 'side' => $side, 'display_order' => 4, 'for_articulation' => true, 'for_inventory' => true, 'created_by' => $this->sys, 'updated_by' => $this->sys, 'created_at' => $this->dt, 'updated_at' => $this->dt);
        (!$bone_group->exists) ? $bone_group->fill($data)->save() : $bone_group->fill(array_except($data, ['created_at']))->save();
        $sb_id = SkeletalBone::where('name', '=', 'Trapezium')->first()->id;
        $bone_group = BoneGroup::firstOrNew(['group_name' => $group, 'sb_id' => $sb_id]);
        $data = array('group_name' => $group, 'sb_id' => $sb_id, 'middle' => $middle, 'side' => $side, 'display_order' => 5, 'for_articulation' => true, 'for_inventory' => true, 'created_by' => $this->sys, 'updated_by' => $this->sys, 'created_at' => $this->dt, 'updated_at' => $this->dt);
        (!$bone_group->exists) ? $bone_group->fill($data)->save() : $bone_group->fill(array_except($data, ['created_at']))->save();
        $sb_id = SkeletalBone::where('name', '=', 'Trapezoid')->first()->id;
        $bone_group = BoneGroup::firstOrNew(['group_name' => $group, 'sb_id' => $sb_id]);
        $data = array('group_name' => $group, 'sb_id' => $sb_id, 'middle' => $middle, 'side' => $side, 'display_order' => 6, 'for_articulation' => true, 'for_inventory' => true, 'created_by' => $this->sys, 'updated_by' => $this->sys, 'created_at' => $this->dt, 'updated_at' => $this->dt);
        (!$bone_group->exists) ? $bone_group->fill($data)->save() : $bone_group->fill(array_except($data, ['created_at']))->save();
        $sb_id = SkeletalBone::where('name', '=', 'Capitate')->first()->id;
        $bone_group = BoneGroup::firstOrNew(['group_name' => $group, 'sb_id' => $sb_id]);
        $data = array('group_name' => $group, 'sb_id' => $sb_id, 'middle' => $middle, 'side' => $side, 'display_order' => 7, 'for_articulation' => true, 'for_inventory' => true, 'created_by' => $this->sys, 'updated_by' => $this->sys, 'created_at' => $this->dt, 'updated_at' => $this->dt);
        (!$bone_group->exists) ? $bone_group->fill($data)->save() : $bone_group->fill(array_except($data, ['created_at']))->save();
        $sb_id = SkeletalBone::where('name', '=', 'Hamate')->first()->id;
        $bone_group = BoneGroup::firstOrNew(['group_name' => $group, 'sb_id' => $sb_id]);
        $data = array('group_name' => $group, 'sb_id' => $sb_id, 'middle' => $middle, 'side' => $side, 'display_order' => 8, 'for_articulation' => true, 'for_inventory' => true, 'created_by' => $this->sys, 'updated_by' => $this->sys, 'created_at' => $this->dt, 'updated_at' => $this->dt);
        (!$bone_group->exists) ? $bone_group->fill($data)->save() : $bone_group->fill(array_except($data, ['created_at']))->save();
        $sb_id = SkeletalBone::where('name', '=', 'Metacarpal 1')->first()->id;
        $bone_group = BoneGroup::firstOrNew(['group_name' => $group, 'sb_id' => $sb_id]);
        $data = array('group_name' => $group, 'sb_id' => $sb_id, 'middle' => $middle, 'side' => $side, 'display_order' => 9, 'for_articulation' => true, 'for_inventory' => true, 'created_by' => $this->sys, 'updated_by' => $this->sys, 'created_at' => $this->dt, 'updated_at' => $this->dt);
        (!$bone_group->exists) ? $bone_group->fill($data)->save() : $bone_group->fill(array_except($data, ['created_at']))->save();
        $sb_id = SkeletalBone::where('name', '=', 'Metacarpal 2')->first()->id;
        $bone_group = BoneGroup::firstOrNew(['group_name' => $group, 'sb_id' => $sb_id]);
        $data = array('group_name' => $group, 'sb_id' => $sb_id, 'middle' => $middle, 'side' => $side, 'display_order' => 10, 'for_articulation' => true, 'for_inventory' => true, 'created_by' => $this->sys, 'updated_by' => $this->sys, 'created_at' => $this->dt, 'updated_at' => $this->dt);
        (!$bone_group->exists) ? $bone_group->fill($data)->save() : $bone_group->fill(array_except($data, ['created_at']))->save();
        $sb_id = SkeletalBone::where('name', '=', 'Metacarpal 3')->first()->id;
        $bone_group = BoneGroup::firstOrNew(['group_name' => $group, 'sb_id' => $sb_id]);
        $data = array('group_name' => $group, 'sb_id' => $sb_id, 'middle' => $middle, 'side' => $side, 'display_order' => 11, 'for_articulation' => true, 'for_inventory' => true, 'created_by' => $this->sys, 'updated_by' => $this->sys, 'created_at' => $this->dt, 'updated_at' => $this->dt);
        (!$bone_group->exists) ? $bone_group->fill($data)->save() : $bone_group->fill(array_except($data, ['created_at']))->save();
        $sb_id = SkeletalBone::where('name', '=', 'Metacarpal 4')->first()->id;
        $bone_group = BoneGroup::firstOrNew(['group_name' => $group, 'sb_id' => $sb_id]);
        $data = array('group_name' => $group, 'sb_id' => $sb_id, 'middle' => $middle, 'side' => $side, 'display_order' => 12, 'for_articulation' => true, 'for_inventory' => true, 'created_by' => $this->sys, 'updated_by' => $this->sys, 'created_at' => $this->dt, 'updated_at' => $this->dt);
        (!$bone_group->exists) ? $bone_group->fill($data)->save() : $bone_group->fill(array_except($data, ['created_at']))->save();
        $sb_id = SkeletalBone::where('name', '=', 'Metacarpal 5')->first()->id;
        $bone_group = BoneGroup::firstOrNew(['group_name' => $group, 'sb_id' => $sb_id]);
        $data = array('group_name' => $group, 'sb_id' => $sb_id, 'middle' => $middle, 'side' => $side, 'display_order' => 13, 'for_articulation' => true, 'for_inventory' => true, 'created_by' => $this->sys, 'updated_by' => $this->sys, 'created_at' => $this->dt, 'updated_at' => $this->dt);
        (!$bone_group->exists) ? $bone_group->fill($data)->save() : $bone_group->fill(array_except($data, ['created_at']))->save();
        $sb_id = SkeletalBone::where('name', '=', 'Proximal manual phalanx 1')->first()->id;
        $bone_group = BoneGroup::firstOrNew(['group_name' => $group, 'sb_id' => $sb_id]);
        $data = array('group_name' => $group, 'sb_id' => $sb_id, 'middle' => $middle, 'side' => $side, 'display_order' => 14, 'for_articulation' => true, 'for_inventory' => true, 'created_by' => $this->sys, 'updated_by' => $this->sys, 'created_at' => $this->dt, 'updated_at' => $this->dt);
        (!$bone_group->exists) ? $bone_group->fill($data)->save() : $bone_group->fill(array_except($data, ['created_at']))->save();
        $sb_id = SkeletalBone::where('name', '=', 'Proximal manual phalanx 2')->first()->id;
        $bone_group = BoneGroup::firstOrNew(['group_name' => $group, 'sb_id' => $sb_id]);
        $data = array('group_name' => $group, 'sb_id' => $sb_id, 'middle' => $middle, 'side' => $side, 'display_order' => 15, 'for_articulation' => true, 'for_inventory' => true, 'created_by' => $this->sys, 'updated_by' => $this->sys, 'created_at' => $this->dt, 'updated_at' => $this->dt);
        (!$bone_group->exists) ? $bone_group->fill($data)->save() : $bone_group->fill(array_except($data, ['created_at']))->save();
        $sb_id = SkeletalBone::where('name', '=', 'Proximal manual phalanx 3')->first()->id;
        $bone_group = BoneGroup::firstOrNew(['group_name' => $group, 'sb_id' => $sb_id]);
        $data = array('group_name' => $group, 'sb_id' => $sb_id, 'middle' => $middle, 'side' => $side, 'display_order' => 16, 'for_articulation' => true, 'for_inventory' => true, 'created_by' => $this->sys, 'updated_by' => $this->sys, 'created_at' => $this->dt, 'updated_at' => $this->dt);
        (!$bone_group->exists) ? $bone_group->fill($data)->save() : $bone_group->fill(array_except($data, ['created_at']))->save();
        $sb_id = SkeletalBone::where('name', '=', 'Proximal manual phalanx 4')->first()->id;
        $bone_group = BoneGroup::firstOrNew(['group_name' => $group, 'sb_id' => $sb_id]);
        $data = array('group_name' => $group, 'sb_id' => $sb_id, 'middle' => $middle, 'side' => $side, 'display_order' => 17, 'for_articulation' => true, 'for_inventory' => true, 'created_by' => $this->sys, 'updated_by' => $this->sys, 'created_at' => $this->dt, 'updated_at' => $this->dt);
        (!$bone_group->exists) ? $bone_group->fill($data)->save() : $bone_group->fill(array_except($data, ['created_at']))->save();
        $sb_id = SkeletalBone::where('name', '=', 'Proximal manual phalanx 5')->first()->id;
        $bone_group = BoneGroup::firstOrNew(['group_name' => $group, 'sb_id' => $sb_id]);
        $data = array('group_name' => $group, 'sb_id' => $sb_id, 'middle' => $middle, 'side' => $side, 'display_order' => 18, 'for_articulation' => true, 'for_inventory' => true, 'created_by' => $this->sys, 'updated_by' => $this->sys, 'created_at' => $this->dt, 'updated_at' => $this->dt);
        (!$bone_group->exists) ? $bone_group->fill($data)->save() : $bone_group->fill(array_except($data, ['created_at']))->save();
        $sb_id = SkeletalBone::where('name', '=', 'Intermediate manual phalanx 2')->first()->id;
        $bone_group = BoneGroup::firstOrNew(['group_name' => $group, 'sb_id' => $sb_id]);
        $data = array('group_name' => $group, 'sb_id' => $sb_id, 'middle' => $middle, 'side' => $side, 'display_order' => 19, 'for_articulation' => true, 'for_inventory' => true, 'created_by' => $this->sys, 'updated_by' => $this->sys, 'created_at' => $this->dt, 'updated_at' => $this->dt);
        (!$bone_group->exists) ? $bone_group->fill($data)->save() : $bone_group->fill(array_except($data, ['created_at']))->save();
        $sb_id = SkeletalBone::where('name', '=', 'Intermediate manual phalanx 3')->first()->id;
        $bone_group = BoneGroup::firstOrNew(['group_name' => $group, 'sb_id' => $sb_id]);
        $data = array('group_name' => $group, 'sb_id' => $sb_id, 'middle' => $middle, 'side' => $side, 'display_order' => 20, 'for_articulation' => true, 'for_inventory' => true, 'created_by' => $this->sys, 'updated_by' => $this->sys, 'created_at' => $this->dt, 'updated_at' => $this->dt);
        (!$bone_group->exists) ? $bone_group->fill($data)->save() : $bone_group->fill(array_except($data, ['created_at']))->save();
        $sb_id = SkeletalBone::where('name', '=', 'Intermediate manual phalanx 4')->first()->id;
        $bone_group = BoneGroup::firstOrNew(['group_name' => $group, 'sb_id' => $sb_id]);
        $data = array('group_name' => $group, 'sb_id' => $sb_id, 'middle' => $middle, 'side' => $side, 'display_order' => 21, 'for_articulation' => true, 'for_inventory' => true, 'created_by' => $this->sys, 'updated_by' => $this->sys, 'created_at' => $this->dt, 'updated_at' => $this->dt);
        (!$bone_group->exists) ? $bone_group->fill($data)->save() : $bone_group->fill(array_except($data, ['created_at']))->save();
        $sb_id = SkeletalBone::where('name', '=', 'Intermediate manual phalanx 5')->first()->id;
        $bone_group = BoneGroup::firstOrNew(['group_name' => $group, 'sb_id' => $sb_id]);
        $data = array('group_name' => $group, 'sb_id' => $sb_id, 'middle' => $middle, 'side' => $side, 'display_order' => 22, 'for_articulation' => true, 'for_inventory' => true, 'created_by' => $this->sys, 'updated_by' => $this->sys, 'created_at' => $this->dt, 'updated_at' => $this->dt);
        (!$bone_group->exists) ? $bone_group->fill($data)->save() : $bone_group->fill(array_except($data, ['created_at']))->save();
        $sb_id = SkeletalBone::where('name', '=', 'Distal manual phalanx 1')->first()->id;
        $bone_group = BoneGroup::firstOrNew(['group_name' => $group, 'sb_id' => $sb_id]);
        $data = array('group_name' => $group, 'sb_id' => $sb_id, 'middle' => $middle, 'side' => $side, 'display_order' => 23, 'for_articulation' => true, 'for_inventory' => true, 'created_by' => $this->sys, 'updated_by' => $this->sys, 'created_at' => $this->dt, 'updated_at' => $this->dt);
        (!$bone_group->exists) ? $bone_group->fill($data)->save() : $bone_group->fill(array_except($data, ['created_at']))->save();
        $sb_id = SkeletalBone::where('name', '=', 'Distal manual phalanx 2')->first()->id;
        $bone_group = BoneGroup::firstOrNew(['group_name' => $group, 'sb_id' => $sb_id]);
        $data = array('group_name' => $group, 'sb_id' => $sb_id, 'middle' => $middle, 'side' => $side, 'display_order' => 24, 'for_articulation' => true, 'for_inventory' => true, 'created_by' => $this->sys, 'updated_by' => $this->sys, 'created_at' => $this->dt, 'updated_at' => $this->dt);
        (!$bone_group->exists) ? $bone_group->fill($data)->save() : $bone_group->fill(array_except($data, ['created_at']))->save();
        $sb_id = SkeletalBone::where('name', '=', 'Distal manual phalanx 3')->first()->id;
        $bone_group = BoneGroup::firstOrNew(['group_name' => $group, 'sb_id' => $sb_id]);
        $data = array('group_name' => $group, 'sb_id' => $sb_id, 'middle' => $middle, 'side' => $side, 'display_order' => 25, 'for_articulation' => true, 'for_inventory' => true, 'created_by' => $this->sys, 'updated_by' => $this->sys, 'created_at' => $this->dt, 'updated_at' => $this->dt);
        (!$bone_group->exists) ? $bone_group->fill($data)->save() : $bone_group->fill(array_except($data, ['created_at']))->save();
        $sb_id = SkeletalBone::where('name', '=', 'Distal manual phalanx 4')->first()->id;
        $bone_group = BoneGroup::firstOrNew(['group_name' => $group, 'sb_id' => $sb_id]);
        $data = array('group_name' => $group, 'sb_id' => $sb_id, 'middle' => $middle, 'side' => $side, 'display_order' => 26, 'for_articulation' => true, 'for_inventory' => true, 'created_by' => $this->sys, 'updated_by' => $this->sys, 'created_at' => $this->dt, 'updated_at' => $this->dt);
        (!$bone_group->exists) ? $bone_group->fill($data)->save() : $bone_group->fill(array_except($data, ['created_at']))->save();
        $sb_id = SkeletalBone::where('name', '=', 'Distal manual phalanx 5')->first()->id;
        $bone_group = BoneGroup::firstOrNew(['group_name' => $group, 'sb_id' => $sb_id]);
        $data = array('group_name' => $group, 'sb_id' => $sb_id, 'middle' => $middle, 'side' => $side, 'display_order' => 27, 'for_articulation' => true, 'for_inventory' => true, 'created_by' => $this->sys, 'updated_by' => $this->sys, 'created_at' => $this->dt, 'updated_at' => $this->dt);
        (!$bone_group->exists) ? $bone_group->fill($data)->save() : $bone_group->fill(array_except($data, ['created_at']))->save();
    }

    protected function createSkullGroup($group = null)
    {
        if (!isset($group)) {
            $group = 'Skull';
        }

        $this->command->info($group . ' group seeding!');
        $sb_id = SkeletalBone::where('name', '=', 'Frontal')->first()->id;
        $bone_group = BoneGroup::firstOrNew(['group_name' => $group, 'sb_id' => $sb_id]);
        $data = array('group_name' => $group, 'sb_id' => $sb_id, 'middle' => true, 'side' => false, 'display_order' => 1, 'for_articulation' => true, 'for_inventory' => true, 'created_by' => $this->sys, 'updated_by' => $this->sys, 'created_at' => $this->dt, 'updated_at' => $this->dt);
        (!$bone_group->exists) ? $bone_group->fill($data)->save() : $bone_group->fill(array_except($data, ['created_at']))->save();
        $sb_id = SkeletalBone::where('name', '=', 'Parietal')->first()->id;
        $bone_group = BoneGroup::firstOrNew(['group_name' => $group, 'sb_id' => $sb_id]);
        $data = array('group_name' => $group, 'sb_id' => $sb_id, 'middle' => true, 'side' => false, 'display_order' => 2, 'for_articulation' => true, 'for_inventory' => true, 'created_by' => $this->sys, 'updated_by' => $this->sys, 'created_at' => $this->dt, 'updated_at' => $this->dt);
        (!$bone_group->exists) ? $bone_group->fill($data)->save() : $bone_group->fill(array_except($data, ['created_at']))->save();
        $sb_id = SkeletalBone::where('name', '=', 'Occipital')->first()->id;
        $bone_group = BoneGroup::firstOrNew(['group_name' => $group, 'sb_id' => $sb_id]);
        $data = array('group_name' => $group, 'sb_id' => $sb_id, 'middle' => true, 'side' => false, 'display_order' => 3, 'for_articulation' => true, 'for_inventory' => true, 'created_by' => $this->sys, 'updated_by' => $this->sys, 'created_at' => $this->dt, 'updated_at' => $this->dt);
        (!$bone_group->exists) ? $bone_group->fill($data)->save() : $bone_group->fill(array_except($data, ['created_at']))->save();
        $sb_id = SkeletalBone::where('name', '=', 'Temporal')->first()->id;
        $bone_group = BoneGroup::firstOrNew(['group_name' => $group, 'sb_id' => $sb_id]);
        $data = array('group_name' => $group, 'sb_id' => $sb_id, 'middle' => true, 'side' => false, 'display_order' => 4, 'for_articulation' => true, 'for_inventory' => true, 'created_by' => $this->sys, 'updated_by' => $this->sys, 'created_at' => $this->dt, 'updated_at' => $this->dt);
        (!$bone_group->exists) ? $bone_group->fill($data)->save() : $bone_group->fill(array_except($data, ['created_at']))->save();
        $sb_id = SkeletalBone::where('name', '=', 'Zygomatic')->first()->id;
        $bone_group = BoneGroup::firstOrNew(['group_name' => $group, 'sb_id' => $sb_id]);
        $data = array('group_name' => $group, 'sb_id' => $sb_id, 'middle' => true, 'side' => false, 'display_order' => 5, 'for_articulation' => true, 'for_inventory' => true, 'created_by' => $this->sys, 'updated_by' => $this->sys, 'created_at' => $this->dt, 'updated_at' => $this->dt);
        (!$bone_group->exists) ? $bone_group->fill($data)->save() : $bone_group->fill(array_except($data, ['created_at']))->save();
        $sb_id = SkeletalBone::where('name', '=', 'Palatine')->first()->id;
        $bone_group = BoneGroup::firstOrNew(['group_name' => $group, 'sb_id' => $sb_id]);
        $data = array('group_name' => $group, 'sb_id' => $sb_id, 'middle' => true, 'side' => false, 'display_order' => 6, 'for_articulation' => true, 'for_inventory' => true, 'created_by' => $this->sys, 'updated_by' => $this->sys, 'created_at' => $this->dt, 'updated_at' => $this->dt);
        (!$bone_group->exists) ? $bone_group->fill($data)->save() : $bone_group->fill(array_except($data, ['created_at']))->save();
        $sb_id = SkeletalBone::where('name', '=', 'Maxilla')->first()->id;
        $bone_group = BoneGroup::firstOrNew(['group_name' => $group, 'sb_id' => $sb_id]);
        $data = array('group_name' => $group, 'sb_id' => $sb_id, 'middle' => true, 'side' => false, 'display_order' => 7, 'for_articulation' => true, 'for_inventory' => true,  'created_by' => $this->sys, 'updated_by' => $this->sys, 'created_at' => $this->dt, 'updated_at' => $this->dt);
        (!$bone_group->exists) ? $bone_group->fill($data)->save() : $bone_group->fill(array_except($data, ['created_at']))->save();
        $sb_id = SkeletalBone::where('name', '=', 'Nasal')->first()->id;
        $bone_group = BoneGroup::firstOrNew(['group_name' => $group, 'sb_id' => $sb_id]);
        $data = array('group_name' => $group, 'sb_id' => $sb_id, 'middle' => true, 'side' => false, 'display_order' => 8, 'for_articulation' => true, 'for_inventory' => true,  'created_by' => $this->sys, 'updated_by' => $this->sys, 'created_at' => $this->dt, 'updated_at' => $this->dt);
        (!$bone_group->exists) ? $bone_group->fill($data)->save() : $bone_group->fill(array_except($data, ['created_at']))->save();
        $sb_id = SkeletalBone::where('name', '=', 'Sphenoid')->first()->id;
        $bone_group = BoneGroup::firstOrNew(['group_name' => $group, 'sb_id' => $sb_id]);
        $data = array('group_name' => $group, 'sb_id' => $sb_id, 'middle' => true, 'side' => false, 'display_order' => 9, 'for_articulation' => true, 'for_inventory' => true,  'created_by' => $this->sys, 'updated_by' => $this->sys, 'created_at' => $this->dt, 'updated_at' => $this->dt);
        (!$bone_group->exists) ? $bone_group->fill($data)->save() : $bone_group->fill(array_except($data, ['created_at']))->save();
        $sb_id = SkeletalBone::where('name', '=', 'Lacrimal')->first()->id;
        $bone_group = BoneGroup::firstOrNew(['group_name' => $group, 'sb_id' => $sb_id]);
        $data = array('group_name' => $group, 'sb_id' => $sb_id, 'middle' => true, 'side' => false, 'display_order' => 10, 'for_articulation' => true, 'for_inventory' => true, 'created_by' => $this->sys, 'updated_by' => $this->sys, 'created_at' => $this->dt, 'updated_at' => $this->dt);
        (!$bone_group->exists) ? $bone_group->fill($data)->save() : $bone_group->fill(array_except($data, ['created_at']))->save();
        $sb_id = SkeletalBone::where('name', '=', 'Mandible')->first()->id;
        $bone_group = BoneGroup::firstOrNew(['group_name' => $group, 'sb_id' => $sb_id]);
        $data = array('group_name' => $group, 'sb_id' => $sb_id, 'middle' => true, 'side' => false, 'display_order' => 11, 'for_articulation' => true, 'for_inventory' => true,  'created_by' => $this->sys, 'updated_by' => $this->sys, 'created_at' => $this->dt, 'updated_at' => $this->dt);
        (!$bone_group->exists) ? $bone_group->fill($data)->save() : $bone_group->fill(array_except($data, ['created_at']))->save();
        $sb_id = SkeletalBone::where('name', '=', 'Vomer')->first()->id;
        $bone_group = BoneGroup::firstOrNew(['group_name' => $group, 'sb_id' => $sb_id]);
        $data = array('group_name' => $group, 'sb_id' => $sb_id, 'middle' => true, 'side' => false, 'display_order' => 12, 'for_articulation' => true, 'for_inventory' => true,  'created_by' => $this->sys, 'updated_by' => $this->sys, 'created_at' => $this->dt, 'updated_at' => $this->dt);
        (!$bone_group->exists) ? $bone_group->fill($data)->save() : $bone_group->fill(array_except($data, ['created_at']))->save();
        $sb_id = SkeletalBone::where('name', '=', 'Inferior nasal concha')->first()->id;
        $bone_group = BoneGroup::firstOrNew(['group_name' => $group, 'sb_id' => $sb_id]);
        $data = array('group_name' => $group, 'sb_id' => $sb_id, 'middle' => true, 'side' => false, 'display_order' => 13, 'for_articulation' => true, 'for_inventory' => true, 'created_by' => $this->sys, 'updated_by' => $this->sys, 'created_at' => $this->dt, 'updated_at' => $this->dt);
        (!$bone_group->exists) ? $bone_group->fill($data)->save() : $bone_group->fill(array_except($data, ['created_at']))->save();
        $sb_id = SkeletalBone::where('name', '=', 'Stapes')->first()->id;
        $bone_group = BoneGroup::firstOrNew(['group_name' => $group, 'sb_id' => $sb_id]);
        $data = array('group_name' => $group, 'sb_id' => $sb_id, 'middle' => true, 'side' => false, 'display_order' => 14, 'for_articulation' => true, 'for_inventory' => true,  'created_by' => $this->sys, 'updated_by' => $this->sys, 'created_at' => $this->dt, 'updated_at' => $this->dt);
        (!$bone_group->exists) ? $bone_group->fill($data)->save() : $bone_group->fill(array_except($data, ['created_at']))->save();
        $sb_id = SkeletalBone::where('name', '=', 'Incus')->first()->id;
        $bone_group = BoneGroup::firstOrNew(['group_name' => $group, 'sb_id' => $sb_id]);
        $data = array('group_name' => $group, 'sb_id' => $sb_id, 'middle' => true, 'side' => false, 'display_order' => 15, 'for_articulation' => true, 'for_inventory' => true,  'created_by' => $this->sys, 'updated_by' => $this->sys, 'created_at' => $this->dt, 'updated_at' => $this->dt);
        (!$bone_group->exists) ? $bone_group->fill($data)->save() : $bone_group->fill(array_except($data, ['created_at']))->save();
        $sb_id = SkeletalBone::where('name', '=', 'Malleus')->first()->id;
        $bone_group = BoneGroup::firstOrNew(['group_name' => $group, 'sb_id' => $sb_id]);
        $data = array('group_name' => $group, 'sb_id' => $sb_id, 'middle' => true, 'side' => false, 'display_order' => 16, 'for_articulation' => true, 'for_inventory' => true,  'created_by' => $this->sys, 'updated_by' => $this->sys, 'created_at' => $this->dt, 'updated_at' => $this->dt);
        (!$bone_group->exists) ? $bone_group->fill($data)->save() : $bone_group->fill(array_except($data, ['created_at']))->save();
        $sb_id = SkeletalBone::where('name', '=', 'Ethmoid')->first()->id;
        $bone_group = BoneGroup::firstOrNew(['group_name' => $group, 'sb_id' => $sb_id]);
        $data = array('group_name' => $group, 'sb_id' => $sb_id, 'middle' => true, 'side' => false, 'display_order' => 17, 'for_articulation' => true, 'for_inventory' => true, 'created_by' => $this->sys, 'updated_by' => $this->sys, 'created_at' => $this->dt, 'updated_at' => $this->dt);
        (!$bone_group->exists) ? $bone_group->fill($data)->save() : $bone_group->fill(array_except($data, ['created_at']))->save();
        $sb_id = SkeletalBone::where('name', '=', 'Tooth 1')->first()->id;
        $bone_group = BoneGroup::firstOrNew(['group_name' => $group, 'sb_id' => $sb_id]);
        $data = array('group_name' => $group, 'sb_id' => $sb_id, 'middle' => true, 'side' => false, 'display_order' => 18, 'for_articulation' => true, 'for_inventory' => true, 'created_by' => $this->sys, 'updated_by' => $this->sys, 'created_at' => $this->dt, 'updated_at' => $this->dt);
        (!$bone_group->exists) ? $bone_group->fill($data)->save() : $bone_group->fill(array_except($data, ['created_at']))->save();
        $sb_id = SkeletalBone::where('name', '=', 'Tooth 2')->first()->id;
        $bone_group = BoneGroup::firstOrNew(['group_name' => $group, 'sb_id' => $sb_id]);
        $data = array('group_name' => $group, 'sb_id' => $sb_id, 'middle' => true, 'side' => false, 'display_order' => 19, 'for_articulation' => true, 'for_inventory' => true, 'created_by' => $this->sys, 'updated_by' => $this->sys, 'created_at' => $this->dt, 'updated_at' => $this->dt);
        (!$bone_group->exists) ? $bone_group->fill($data)->save() : $bone_group->fill(array_except($data, ['created_at']))->save();
        $sb_id = SkeletalBone::where('name', '=', 'Tooth 3')->first()->id;
        $bone_group = BoneGroup::firstOrNew(['group_name' => $group, 'sb_id' => $sb_id]);
        $data = array('group_name' => $group, 'sb_id' => $sb_id, 'middle' => true, 'side' => false, 'display_order' => 20, 'for_articulation' => true, 'for_inventory' => true, 'created_by' => $this->sys, 'updated_by' => $this->sys, 'created_at' => $this->dt, 'updated_at' => $this->dt);
        (!$bone_group->exists) ? $bone_group->fill($data)->save() : $bone_group->fill(array_except($data, ['created_at']))->save();
        $sb_id = SkeletalBone::where('name', '=', 'Tooth 4')->first()->id;
        $bone_group = BoneGroup::firstOrNew(['group_name' => $group, 'sb_id' => $sb_id]);
        $data = array('group_name' => $group, 'sb_id' => $sb_id, 'middle' => true, 'side' => false, 'display_order' => 21, 'for_articulation' => true, 'for_inventory' => true, 'created_by' => $this->sys, 'updated_by' => $this->sys, 'created_at' => $this->dt, 'updated_at' => $this->dt);
        (!$bone_group->exists) ? $bone_group->fill($data)->save() : $bone_group->fill(array_except($data, ['created_at']))->save();
        $sb_id = SkeletalBone::where('name', '=', 'Tooth 5')->first()->id;
        $bone_group = BoneGroup::firstOrNew(['group_name' => $group, 'sb_id' => $sb_id]);
        $data = array('group_name' => $group, 'sb_id' => $sb_id, 'middle' => true, 'side' => false, 'display_order' => 22, 'for_articulation' => true, 'for_inventory' => true, 'created_by' => $this->sys, 'updated_by' => $this->sys, 'created_at' => $this->dt, 'updated_at' => $this->dt);
        (!$bone_group->exists) ? $bone_group->fill($data)->save() : $bone_group->fill(array_except($data, ['created_at']))->save();
        $sb_id = SkeletalBone::where('name', '=', 'Tooth 6')->first()->id;
        $bone_group = BoneGroup::firstOrNew(['group_name' => $group, 'sb_id' => $sb_id]);
        $data = array('group_name' => $group, 'sb_id' => $sb_id, 'middle' => true, 'side' => false, 'display_order' => 23, 'for_articulation' => true, 'for_inventory' => true, 'created_by' => $this->sys, 'updated_by' => $this->sys, 'created_at' => $this->dt, 'updated_at' => $this->dt);
        (!$bone_group->exists) ? $bone_group->fill($data)->save() : $bone_group->fill(array_except($data, ['created_at']))->save();
        $sb_id = SkeletalBone::where('name', '=', 'Tooth 7')->first()->id;
        $bone_group = BoneGroup::firstOrNew(['group_name' => $group, 'sb_id' => $sb_id]);
        $data = array('group_name' => $group, 'sb_id' => $sb_id, 'middle' => true, 'side' => false, 'display_order' => 24, 'for_articulation' => true, 'for_inventory' => true, 'created_by' => $this->sys, 'updated_by' => $this->sys, 'created_at' => $this->dt, 'updated_at' => $this->dt);
        (!$bone_group->exists) ? $bone_group->fill($data)->save() : $bone_group->fill(array_except($data, ['created_at']))->save();
        $sb_id = SkeletalBone::where('name', '=', 'Tooth 8')->first()->id;
        $bone_group = BoneGroup::firstOrNew(['group_name' => $group, 'sb_id' => $sb_id]);
        $data = array('group_name' => $group, 'sb_id' => $sb_id, 'middle' => true, 'side' => false, 'display_order' => 25, 'for_articulation' => true, 'for_inventory' => true, 'created_by' => $this->sys, 'updated_by' => $this->sys, 'created_at' => $this->dt, 'updated_at' => $this->dt);
        (!$bone_group->exists) ? $bone_group->fill($data)->save() : $bone_group->fill(array_except($data, ['created_at']))->save();
        $sb_id = SkeletalBone::where('name', '=', 'Tooth 9')->first()->id;
        $bone_group = BoneGroup::firstOrNew(['group_name' => $group, 'sb_id' => $sb_id]);
        $data = array('group_name' => $group, 'sb_id' => $sb_id, 'middle' => true, 'side' => false, 'display_order' => 26, 'for_articulation' => true, 'for_inventory' => true, 'created_by' => $this->sys, 'updated_by' => $this->sys, 'created_at' => $this->dt, 'updated_at' => $this->dt);
        (!$bone_group->exists) ? $bone_group->fill($data)->save() : $bone_group->fill(array_except($data, ['created_at']))->save();
        $sb_id = SkeletalBone::where('name', '=', 'Tooth 10')->first()->id;
        $bone_group = BoneGroup::firstOrNew(['group_name' => $group, 'sb_id' => $sb_id]);
        $data = array('group_name' => $group, 'sb_id' => $sb_id, 'middle' => true, 'side' => false, 'display_order' => 27, 'for_articulation' => true, 'for_inventory' => true, 'created_by' => $this->sys, 'updated_by' => $this->sys, 'created_at' => $this->dt, 'updated_at' => $this->dt);
        (!$bone_group->exists) ? $bone_group->fill($data)->save() : $bone_group->fill(array_except($data, ['created_at']))->save();
        $sb_id = SkeletalBone::where('name', '=', 'Tooth 11')->first()->id;
        $bone_group = BoneGroup::firstOrNew(['group_name' => $group, 'sb_id' => $sb_id]);
        $data = array('group_name' => $group, 'sb_id' => $sb_id, 'middle' => true, 'side' => false, 'display_order' => 28, 'for_articulation' => true, 'for_inventory' => true, 'created_by' => $this->sys, 'updated_by' => $this->sys, 'created_at' => $this->dt, 'updated_at' => $this->dt);
        (!$bone_group->exists) ? $bone_group->fill($data)->save() : $bone_group->fill(array_except($data, ['created_at']))->save();
        $sb_id = SkeletalBone::where('name', '=', 'Tooth 12')->first()->id;
        $bone_group = BoneGroup::firstOrNew(['group_name' => $group, 'sb_id' => $sb_id]);
        $data = array('group_name' => $group, 'sb_id' => $sb_id, 'middle' => true, 'side' => false, 'display_order' => 29, 'for_articulation' => true, 'for_inventory' => true, 'created_by' => $this->sys, 'updated_by' => $this->sys, 'created_at' => $this->dt, 'updated_at' => $this->dt);
        (!$bone_group->exists) ? $bone_group->fill($data)->save() : $bone_group->fill(array_except($data, ['created_at']))->save();
        $sb_id = SkeletalBone::where('name', '=', 'Tooth 13')->first()->id;
        $bone_group = BoneGroup::firstOrNew(['group_name' => $group, 'sb_id' => $sb_id]);
        $data = array('group_name' => $group, 'sb_id' => $sb_id, 'middle' => true, 'side' => false, 'display_order' => 30, 'for_articulation' => true, 'for_inventory' => true, 'created_by' => $this->sys, 'updated_by' => $this->sys, 'created_at' => $this->dt, 'updated_at' => $this->dt);
        (!$bone_group->exists) ? $bone_group->fill($data)->save() : $bone_group->fill(array_except($data, ['created_at']))->save();
        $sb_id = SkeletalBone::where('name', '=', 'Tooth 14')->first()->id;
        $bone_group = BoneGroup::firstOrNew(['group_name' => $group, 'sb_id' => $sb_id]);
        $data = array('group_name' => $group, 'sb_id' => $sb_id, 'middle' => true, 'side' => false, 'display_order' => 31, 'for_articulation' => true, 'for_inventory' => true, 'created_by' => $this->sys, 'updated_by' => $this->sys, 'created_at' => $this->dt, 'updated_at' => $this->dt);
        (!$bone_group->exists) ? $bone_group->fill($data)->save() : $bone_group->fill(array_except($data, ['created_at']))->save();
        $sb_id = SkeletalBone::where('name', '=', 'Tooth 15')->first()->id;
        $bone_group = BoneGroup::firstOrNew(['group_name' => $group, 'sb_id' => $sb_id]);
        $data = array('group_name' => $group, 'sb_id' => $sb_id, 'middle' => true, 'side' => false, 'display_order' => 32, 'for_articulation' => true, 'for_inventory' => true, 'created_by' => $this->sys, 'updated_by' => $this->sys, 'created_at' => $this->dt, 'updated_at' => $this->dt);
        (!$bone_group->exists) ? $bone_group->fill($data)->save() : $bone_group->fill(array_except($data, ['created_at']))->save();
        $sb_id = SkeletalBone::where('name', '=', 'Tooth 16')->first()->id;
        $bone_group = BoneGroup::firstOrNew(['group_name' => $group, 'sb_id' => $sb_id]);
        $data = array('group_name' => $group, 'sb_id' => $sb_id, 'middle' => true, 'side' => false, 'display_order' => 33, 'for_articulation' => true, 'for_inventory' => true, 'created_by' => $this->sys, 'updated_by' => $this->sys, 'created_at' => $this->dt, 'updated_at' => $this->dt);
        (!$bone_group->exists) ? $bone_group->fill($data)->save() : $bone_group->fill(array_except($data, ['created_at']))->save();
        $sb_id = SkeletalBone::where('name', '=', 'Tooth 17')->first()->id;
        $bone_group = BoneGroup::firstOrNew(['group_name' => $group, 'sb_id' => $sb_id]);
        $data = array('group_name' => $group, 'sb_id' => $sb_id, 'middle' => true, 'side' => false, 'display_order' => 34, 'for_articulation' => true, 'for_inventory' => true, 'created_by' => $this->sys, 'updated_by' => $this->sys, 'created_at' => $this->dt, 'updated_at' => $this->dt);
        (!$bone_group->exists) ? $bone_group->fill($data)->save() : $bone_group->fill(array_except($data, ['created_at']))->save();
        $sb_id = SkeletalBone::where('name', '=', 'Tooth 18')->first()->id;
        $bone_group = BoneGroup::firstOrNew(['group_name' => $group, 'sb_id' => $sb_id]);
        $data = array('group_name' => $group, 'sb_id' => $sb_id, 'middle' => true, 'side' => false, 'display_order' => 35, 'for_articulation' => true, 'for_inventory' => true, 'created_by' => $this->sys, 'updated_by' => $this->sys, 'created_at' => $this->dt, 'updated_at' => $this->dt);
        (!$bone_group->exists) ? $bone_group->fill($data)->save() : $bone_group->fill(array_except($data, ['created_at']))->save();
        $sb_id = SkeletalBone::where('name', '=', 'Tooth 19')->first()->id;
        $bone_group = BoneGroup::firstOrNew(['group_name' => $group, 'sb_id' => $sb_id]);
        $data = array('group_name' => $group, 'sb_id' => $sb_id, 'middle' => true, 'side' => false, 'display_order' => 36, 'for_articulation' => true, 'for_inventory' => true, 'created_by' => $this->sys, 'updated_by' => $this->sys, 'created_at' => $this->dt, 'updated_at' => $this->dt);
        (!$bone_group->exists) ? $bone_group->fill($data)->save() : $bone_group->fill(array_except($data, ['created_at']))->save();
        $sb_id = SkeletalBone::where('name', '=', 'Tooth 20')->first()->id;
        $bone_group = BoneGroup::firstOrNew(['group_name' => $group, 'sb_id' => $sb_id]);
        $data = array('group_name' => $group, 'sb_id' => $sb_id, 'middle' => true, 'side' => false, 'display_order' => 37, 'for_articulation' => true, 'for_inventory' => true, 'created_by' => $this->sys, 'updated_by' => $this->sys, 'created_at' => $this->dt, 'updated_at' => $this->dt);
        (!$bone_group->exists) ? $bone_group->fill($data)->save() : $bone_group->fill(array_except($data, ['created_at']))->save();
        $sb_id = SkeletalBone::where('name', '=', 'Tooth 21')->first()->id;
        $bone_group = BoneGroup::firstOrNew(['group_name' => $group, 'sb_id' => $sb_id]);
        $data = array('group_name' => $group, 'sb_id' => $sb_id, 'middle' => true, 'side' => false, 'display_order' => 38, 'for_articulation' => true, 'for_inventory' => true, 'created_by' => $this->sys, 'updated_by' => $this->sys, 'created_at' => $this->dt, 'updated_at' => $this->dt);
        (!$bone_group->exists) ? $bone_group->fill($data)->save() : $bone_group->fill(array_except($data, ['created_at']))->save();
        $sb_id = SkeletalBone::where('name', '=', 'Tooth 22')->first()->id;
        $bone_group = BoneGroup::firstOrNew(['group_name' => $group, 'sb_id' => $sb_id]);
        $data = array('group_name' => $group, 'sb_id' => $sb_id, 'middle' => true, 'side' => false, 'display_order' => 39, 'for_articulation' => true, 'for_inventory' => true, 'created_by' => $this->sys, 'updated_by' => $this->sys, 'created_at' => $this->dt, 'updated_at' => $this->dt);
        (!$bone_group->exists) ? $bone_group->fill($data)->save() : $bone_group->fill(array_except($data, ['created_at']))->save();
        $sb_id = SkeletalBone::where('name', '=', 'Tooth 23')->first()->id;
        $bone_group = BoneGroup::firstOrNew(['group_name' => $group, 'sb_id' => $sb_id]);
        $data = array('group_name' => $group, 'sb_id' => $sb_id, 'middle' => true, 'side' => false, 'display_order' => 40, 'for_articulation' => true, 'for_inventory' => true, 'created_by' => $this->sys, 'updated_by' => $this->sys, 'created_at' => $this->dt, 'updated_at' => $this->dt);
        (!$bone_group->exists) ? $bone_group->fill($data)->save() : $bone_group->fill(array_except($data, ['created_at']))->save();
        $sb_id = SkeletalBone::where('name', '=', 'Tooth 24')->first()->id;
        $bone_group = BoneGroup::firstOrNew(['group_name' => $group, 'sb_id' => $sb_id]);
        $data = array('group_name' => $group, 'sb_id' => $sb_id, 'middle' => true, 'side' => false, 'display_order' => 41, 'for_articulation' => true, 'for_inventory' => true, 'created_by' => $this->sys, 'updated_by' => $this->sys, 'created_at' => $this->dt, 'updated_at' => $this->dt);
        (!$bone_group->exists) ? $bone_group->fill($data)->save() : $bone_group->fill(array_except($data, ['created_at']))->save();
        $sb_id = SkeletalBone::where('name', '=', 'Tooth 25')->first()->id;
        $bone_group = BoneGroup::firstOrNew(['group_name' => $group, 'sb_id' => $sb_id]);
        $data = array('group_name' => $group, 'sb_id' => $sb_id, 'middle' => true, 'side' => false, 'display_order' => 42, 'for_articulation' => true, 'for_inventory' => true, 'created_by' => $this->sys, 'updated_by' => $this->sys, 'created_at' => $this->dt, 'updated_at' => $this->dt);
        (!$bone_group->exists) ? $bone_group->fill($data)->save() : $bone_group->fill(array_except($data, ['created_at']))->save();
        $sb_id = SkeletalBone::where('name', '=', 'Tooth 26')->first()->id;
        $bone_group = BoneGroup::firstOrNew(['group_name' => $group, 'sb_id' => $sb_id]);
        $data = array('group_name' => $group, 'sb_id' => $sb_id, 'middle' => true, 'side' => false, 'display_order' => 43, 'for_articulation' => true, 'for_inventory' => true, 'created_by' => $this->sys, 'updated_by' => $this->sys, 'created_at' => $this->dt, 'updated_at' => $this->dt);
        (!$bone_group->exists) ? $bone_group->fill($data)->save() : $bone_group->fill(array_except($data, ['created_at']))->save();
        $sb_id = SkeletalBone::where('name', '=', 'Tooth 27')->first()->id;
        $bone_group = BoneGroup::firstOrNew(['group_name' => $group, 'sb_id' => $sb_id]);
        $data = array('group_name' => $group, 'sb_id' => $sb_id, 'middle' => true, 'side' => false, 'display_order' => 44, 'for_articulation' => true, 'for_inventory' => true, 'created_by' => $this->sys, 'updated_by' => $this->sys, 'created_at' => $this->dt, 'updated_at' => $this->dt);
        (!$bone_group->exists) ? $bone_group->fill($data)->save() : $bone_group->fill(array_except($data, ['created_at']))->save();
        $sb_id = SkeletalBone::where('name', '=', 'Tooth 28')->first()->id;
        $bone_group = BoneGroup::firstOrNew(['group_name' => $group, 'sb_id' => $sb_id]);
        $data = array('group_name' => $group, 'sb_id' => $sb_id, 'middle' => true, 'side' => false, 'display_order' => 45, 'for_articulation' => true, 'for_inventory' => true, 'created_by' => $this->sys, 'updated_by' => $this->sys, 'created_at' => $this->dt, 'updated_at' => $this->dt);
        (!$bone_group->exists) ? $bone_group->fill($data)->save() : $bone_group->fill(array_except($data, ['created_at']))->save();
        $sb_id = SkeletalBone::where('name', '=', 'Tooth 29')->first()->id;
        $bone_group = BoneGroup::firstOrNew(['group_name' => $group, 'sb_id' => $sb_id]);
        $data = array('group_name' => $group, 'sb_id' => $sb_id, 'middle' => true, 'side' => false, 'display_order' => 46, 'for_articulation' => true, 'for_inventory' => true, 'created_by' => $this->sys, 'updated_by' => $this->sys, 'created_at' => $this->dt, 'updated_at' => $this->dt);
        (!$bone_group->exists) ? $bone_group->fill($data)->save() : $bone_group->fill(array_except($data, ['created_at']))->save();
        $sb_id = SkeletalBone::where('name', '=', 'Tooth 30')->first()->id;
        $bone_group = BoneGroup::firstOrNew(['group_name' => $group, 'sb_id' => $sb_id]);
        $data = array('group_name' => $group, 'sb_id' => $sb_id, 'middle' => true, 'side' => false, 'display_order' => 47, 'for_articulation' => true, 'for_inventory' => true, 'created_by' => $this->sys, 'updated_by' => $this->sys, 'created_at' => $this->dt, 'updated_at' => $this->dt);
        (!$bone_group->exists) ? $bone_group->fill($data)->save() : $bone_group->fill(array_except($data, ['created_at']))->save();
        $sb_id = SkeletalBone::where('name', '=', 'Tooth 31')->first()->id;
        $bone_group = BoneGroup::firstOrNew(['group_name' => $group, 'sb_id' => $sb_id]);
        $data = array('group_name' => $group, 'sb_id' => $sb_id, 'middle' => true, 'side' => false, 'display_order' => 48, 'for_articulation' => true, 'for_inventory' => true, 'created_by' => $this->sys, 'updated_by' => $this->sys, 'created_at' => $this->dt, 'updated_at' => $this->dt);
        (!$bone_group->exists) ? $bone_group->fill($data)->save() : $bone_group->fill(array_except($data, ['created_at']))->save();
        $sb_id = SkeletalBone::where('name', '=', 'Tooth 32')->first()->id;
        $bone_group = BoneGroup::firstOrNew(['group_name' => $group, 'sb_id' => $sb_id]);
        $data = array('group_name' => $group, 'sb_id' => $sb_id, 'middle' => true, 'side' => false, 'display_order' => 49, 'for_articulation' => true, 'for_inventory' => true, 'created_by' => $this->sys, 'updated_by' => $this->sys, 'created_at' => $this->dt, 'updated_at' => $this->dt);
        (!$bone_group->exists) ? $bone_group->fill($data)->save() : $bone_group->fill(array_except($data, ['created_at']))->save();
    }

    protected function createRibsGroup($group = null, $side = false, $middle = false)
    {
        if (!isset($group)) {
            $group = 'Ribs';
        }

        $this->command->info($group . ' group seeding!');
        $sb_id = SkeletalBone::where('name', '=', 'Rib 1')->first()->id;
        $bone_group = BoneGroup::firstOrNew(['group_name' => $group, 'sb_id' => $sb_id, 'side' => $side]);
        $data = array('group_name' => $group, 'sb_id' => $sb_id, 'middle' => $middle, 'side' => $side, 'display_order' => 1, 'for_articulation' => false, 'for_inventory' => true, 'created_by' => $this->sys, 'updated_by' => $this->sys, 'created_at' => $this->dt, 'updated_at' => $this->dt);
        (!$bone_group->exists) ? $bone_group->fill($data)->save() : $bone_group->fill(array_except($data, ['created_at']))->save();
        $sb_id = SkeletalBone::where('name', '=', 'Rib 2')->first()->id;
        $bone_group = BoneGroup::firstOrNew(['group_name' => $group, 'sb_id' => $sb_id, 'side' => $side]);
        $data = array('group_name' => $group, 'sb_id' => $sb_id, 'middle' => $middle, 'side' => $side, 'display_order' => 2, 'for_articulation' => false, 'for_inventory' => true, 'created_by' => $this->sys, 'updated_by' => $this->sys, 'created_at' => $this->dt, 'updated_at' => $this->dt);
        (!$bone_group->exists) ? $bone_group->fill($data)->save() : $bone_group->fill(array_except($data, ['created_at']))->save();
        $sb_id = SkeletalBone::where('name', '=', 'Rib 3')->first()->id;
        $bone_group = BoneGroup::firstOrNew(['group_name' => $group, 'sb_id' => $sb_id, 'side' => $side]);
        $data = array('group_name' => $group, 'sb_id' => $sb_id, 'middle' => $middle, 'side' => $side, 'display_order' => 3, 'for_articulation' => false, 'for_inventory' => true, 'created_by' => $this->sys, 'updated_by' => $this->sys, 'created_at' => $this->dt, 'updated_at' => $this->dt);
        (!$bone_group->exists) ? $bone_group->fill($data)->save() : $bone_group->fill(array_except($data, ['created_at']))->save();
        $sb_id = SkeletalBone::where('name', '=', 'Rib 4')->first()->id;
        $bone_group = BoneGroup::firstOrNew(['group_name' => $group, 'sb_id' => $sb_id, 'side' => $side]);
        $data = array('group_name' => $group, 'sb_id' => $sb_id, 'middle' => $middle, 'side' => $side, 'display_order' => 4, 'for_articulation' => false, 'for_inventory' => true, 'created_by' => $this->sys, 'updated_by' => $this->sys, 'created_at' => $this->dt, 'updated_at' => $this->dt);
        (!$bone_group->exists) ? $bone_group->fill($data)->save() : $bone_group->fill(array_except($data, ['created_at']))->save();
        $sb_id = SkeletalBone::where('name', '=', 'Rib 5')->first()->id;
        $bone_group = BoneGroup::firstOrNew(['group_name' => $group, 'sb_id' => $sb_id, 'side' => $side]);
        $data = array('group_name' => $group, 'sb_id' => $sb_id, 'middle' => $middle, 'side' => $side, 'display_order' => 5, 'for_articulation' => false, 'for_inventory' => true, 'created_by' => $this->sys, 'updated_by' => $this->sys, 'created_at' => $this->dt, 'updated_at' => $this->dt);
        (!$bone_group->exists) ? $bone_group->fill($data)->save() : $bone_group->fill(array_except($data, ['created_at']))->save();
        $sb_id = SkeletalBone::where('name', '=', 'Rib 6')->first()->id;
        $bone_group = BoneGroup::firstOrNew(['group_name' => $group, 'sb_id' => $sb_id, 'side' => $side]);
        $data = array('group_name' => $group, 'sb_id' => $sb_id, 'middle' => $middle, 'side' => $side, 'display_order' => 6, 'for_articulation' => false, 'for_inventory' => true, 'created_by' => $this->sys, 'updated_by' => $this->sys, 'created_at' => $this->dt, 'updated_at' => $this->dt);
        (!$bone_group->exists) ? $bone_group->fill($data)->save() : $bone_group->fill(array_except($data, ['created_at']))->save();
        $sb_id = SkeletalBone::where('name', '=', 'Rib 7')->first()->id;
        $bone_group = BoneGroup::firstOrNew(['group_name' => $group, 'sb_id' => $sb_id, 'side' => $side]);
        $data = array('group_name' => $group, 'sb_id' => $sb_id, 'middle' => $middle, 'side' => $side, 'display_order' => 7, 'for_articulation' => false, 'for_inventory' => true, 'created_by' => $this->sys, 'updated_by' => $this->sys, 'created_at' => $this->dt, 'updated_at' => $this->dt);
        (!$bone_group->exists) ? $bone_group->fill($data)->save() : $bone_group->fill(array_except($data, ['created_at']))->save();
        $sb_id = SkeletalBone::where('name', '=', 'Rib 8')->first()->id;
        $bone_group = BoneGroup::firstOrNew(['group_name' => $group, 'sb_id' => $sb_id, 'side' => $side]);
        $data = array('group_name' => $group, 'sb_id' => $sb_id, 'middle' => $middle, 'side' => $side, 'display_order' => 8, 'for_articulation' => false, 'for_inventory' => true, 'created_by' => $this->sys, 'updated_by' => $this->sys, 'created_at' => $this->dt, 'updated_at' => $this->dt);
        (!$bone_group->exists) ? $bone_group->fill($data)->save() : $bone_group->fill(array_except($data, ['created_at']))->save();
        $sb_id = SkeletalBone::where('name', '=', 'Rib 9')->first()->id;
        $bone_group = BoneGroup::firstOrNew(['group_name' => $group, 'sb_id' => $sb_id, 'side' => $side]);
        $data = array('group_name' => $group, 'sb_id' => $sb_id, 'middle' => $middle, 'side' => $side, 'display_order' => 9, 'for_articulation' => false, 'for_inventory' => true, 'created_by' => $this->sys, 'updated_by' => $this->sys, 'created_at' => $this->dt, 'updated_at' => $this->dt);
        (!$bone_group->exists) ? $bone_group->fill($data)->save() : $bone_group->fill(array_except($data, ['created_at']))->save();
        $sb_id = SkeletalBone::where('name', '=', 'Rib 10')->first()->id;
        $bone_group = BoneGroup::firstOrNew(['group_name' => $group, 'sb_id' => $sb_id, 'side' => $side]);
        $data = array('group_name' => $group, 'sb_id' => $sb_id, 'middle' => $middle, 'side' => $side, 'display_order' => 10, 'for_articulation' => false, 'for_inventory' => true, 'created_by' => $this->sys, 'updated_by' => $this->sys, 'created_at' => $this->dt, 'updated_at' => $this->dt);
        (!$bone_group->exists) ? $bone_group->fill($data)->save() : $bone_group->fill(array_except($data, ['created_at']))->save();
        $sb_id = SkeletalBone::where('name', '=', 'Rib 11')->first()->id;
        $bone_group = BoneGroup::firstOrNew(['group_name' => $group, 'sb_id' => $sb_id, 'side' => $side]);
        $data = array('group_name' => $group, 'sb_id' => $sb_id, 'middle' => $middle, 'side' => $side, 'display_order' => 11, 'for_articulation' => false, 'for_inventory' => true, 'created_by' => $this->sys, 'updated_by' => $this->sys, 'created_at' => $this->dt, 'updated_at' => $this->dt);
        (!$bone_group->exists) ? $bone_group->fill($data)->save() : $bone_group->fill(array_except($data, ['created_at']))->save();
        $sb_id = SkeletalBone::where('name', '=', 'Rib 12')->first()->id;
        $bone_group = BoneGroup::firstOrNew(['group_name' => $group, 'sb_id' => $sb_id, 'side' => $side]);
        $data = array('group_name' => $group, 'sb_id' => $sb_id, 'middle' => $middle, 'side' => $side, 'display_order' => 12, 'for_articulation' => false, 'for_inventory' => true, 'created_by' => $this->sys, 'updated_by' => $this->sys, 'created_at' => $this->dt, 'updated_at' => $this->dt);
        (!$bone_group->exists) ? $bone_group->fill($data)->save() : $bone_group->fill(array_except($data, ['created_at']))->save();
    }

    protected function createCervicalVertebraeGroup($group = null)
    {
        if (!isset($group)) {
            $group = 'Cervical vertebrae';
        }

        $this->command->info($group . ' group seeding!');
        $sb_id = SkeletalBone::where('name', '=', 'Cervical vertebra 1')->first()->id;
        $bone_group = BoneGroup::firstOrNew(['group_name' => $group, 'sb_id' => $sb_id]);
        $data = array('group_name' => $group, 'sb_id' => $sb_id, 'middle' => true, 'side' => false, 'display_order' => 1, 'for_articulation' => false, 'for_inventory' => true, 'created_by' => $this->sys, 'updated_by' => $this->sys, 'created_at' => $this->dt, 'updated_at' => $this->dt);
        (!$bone_group->exists) ? $bone_group->fill($data)->save() : $bone_group->fill(array_except($data, ['created_at']))->save();
        $sb_id = SkeletalBone::where('name', '=', 'Cervical vertebra 2')->first()->id;
        $bone_group = BoneGroup::firstOrNew(['group_name' => $group, 'sb_id' => $sb_id]);
        $data = array('group_name' => $group, 'sb_id' => $sb_id, 'middle' => true, 'side' => false, 'display_order' => 2, 'for_articulation' => false, 'for_inventory' => true, 'created_by' => $this->sys, 'updated_by' => $this->sys, 'created_at' => $this->dt, 'updated_at' => $this->dt);
        (!$bone_group->exists) ? $bone_group->fill($data)->save() : $bone_group->fill(array_except($data, ['created_at']))->save();
        $sb_id = SkeletalBone::where('name', '=', 'Cervical vertebra 3')->first()->id;
        $bone_group = BoneGroup::firstOrNew(['group_name' => $group, 'sb_id' => $sb_id]);
        $data = array('group_name' => $group, 'sb_id' => $sb_id, 'middle' => true, 'side' => false, 'display_order' => 3, 'for_articulation' => false, 'for_inventory' => true, 'created_by' => $this->sys, 'updated_by' => $this->sys, 'created_at' => $this->dt, 'updated_at' => $this->dt);
        (!$bone_group->exists) ? $bone_group->fill($data)->save() : $bone_group->fill(array_except($data, ['created_at']))->save();
        $sb_id = SkeletalBone::where('name', '=', 'Cervical vertebra 4')->first()->id;
        $bone_group = BoneGroup::firstOrNew(['group_name' => $group, 'sb_id' => $sb_id]);
        $data = array('group_name' => $group, 'sb_id' => $sb_id, 'middle' => true, 'side' => false, 'display_order' => 4, 'for_articulation' => false, 'for_inventory' => true, 'created_by' => $this->sys, 'updated_by' => $this->sys, 'created_at' => $this->dt, 'updated_at' => $this->dt);
        (!$bone_group->exists) ? $bone_group->fill($data)->save() : $bone_group->fill(array_except($data, ['created_at']))->save();
        $sb_id = SkeletalBone::where('name', '=', 'Cervical vertebra 5')->first()->id;
        $bone_group = BoneGroup::firstOrNew(['group_name' => $group, 'sb_id' => $sb_id]);
        $data = array('group_name' => $group, 'sb_id' => $sb_id, 'middle' => true, 'side' => false, 'display_order' => 5, 'for_articulation' => false, 'for_inventory' => true, 'created_by' => $this->sys, 'updated_by' => $this->sys, 'created_at' => $this->dt, 'updated_at' => $this->dt);
        (!$bone_group->exists) ? $bone_group->fill($data)->save() : $bone_group->fill(array_except($data, ['created_at']))->save();
        $sb_id = SkeletalBone::where('name', '=', 'Cervical vertebra 6')->first()->id;
        $bone_group = BoneGroup::firstOrNew(['group_name' => $group, 'sb_id' => $sb_id]);
        $data = array('group_name' => $group, 'sb_id' => $sb_id, 'middle' => true, 'side' => false, 'display_order' => 6, 'for_articulation' => false, 'for_inventory' => true, 'created_by' => $this->sys, 'updated_by' => $this->sys, 'created_at' => $this->dt, 'updated_at' => $this->dt);
        (!$bone_group->exists) ? $bone_group->fill($data)->save() : $bone_group->fill(array_except($data, ['created_at']))->save();
        $sb_id = SkeletalBone::where('name', '=', 'Cervical vertebra 7')->first()->id;
        $bone_group = BoneGroup::firstOrNew(['group_name' => $group, 'sb_id' => $sb_id]);
        $data = array('group_name' => $group, 'sb_id' => $sb_id, 'middle' => true, 'side' => false, 'display_order' => 7, 'for_articulation' => false, 'for_inventory' => true, 'created_by' => $this->sys, 'updated_by' => $this->sys, 'created_at' => $this->dt, 'updated_at' => $this->dt);
        (!$bone_group->exists) ? $bone_group->fill($data)->save() : $bone_group->fill(array_except($data, ['created_at']))->save();
    }

    protected function createThoracicVertebraeGroup($group = null)
    {
        if (!isset($group)) {
            $group = 'Thoracic vertebrae';
        }

        $this->command->info($group . ' group seeding!');
        $sb_id = SkeletalBone::where('name', '=', 'Thoracic vertebra 1')->first()->id;
        $bone_group = BoneGroup::firstOrNew(['group_name' => $group, 'sb_id' => $sb_id]);
        $data = array('group_name' => $group, 'sb_id' => $sb_id, 'middle' => true, 'side' => false, 'display_order' => 1, 'for_articulation' => false, 'for_inventory' => true, 'created_by' => $this->sys, 'updated_by' => $this->sys, 'created_at' => $this->dt, 'updated_at' => $this->dt);
        (!$bone_group->exists) ? $bone_group->fill($data)->save() : $bone_group->fill(array_except($data, ['created_at']))->save();
        $sb_id = SkeletalBone::where('name', '=', 'Thoracic vertebra 2')->first()->id;
        $bone_group = BoneGroup::firstOrNew(['group_name' => $group, 'sb_id' => $sb_id]);
        $data = array('group_name' => $group, 'sb_id' => $sb_id, 'middle' => true, 'side' => false, 'display_order' => 2, 'for_articulation' => false, 'for_inventory' => true, 'created_by' => $this->sys, 'updated_by' => $this->sys, 'created_at' => $this->dt, 'updated_at' => $this->dt);
        (!$bone_group->exists) ? $bone_group->fill($data)->save() : $bone_group->fill(array_except($data, ['created_at']))->save();
        $sb_id = SkeletalBone::where('name', '=', 'Thoracic vertebra 3')->first()->id;
        $bone_group = BoneGroup::firstOrNew(['group_name' => $group, 'sb_id' => $sb_id]);
        $data = array('group_name' => $group, 'sb_id' => $sb_id, 'middle' => true, 'side' => false, 'display_order' => 3, 'for_articulation' => false, 'for_inventory' => true, 'created_by' => $this->sys, 'updated_by' => $this->sys, 'created_at' => $this->dt, 'updated_at' => $this->dt);
        (!$bone_group->exists) ? $bone_group->fill($data)->save() : $bone_group->fill(array_except($data, ['created_at']))->save();
        $sb_id = SkeletalBone::where('name', '=', 'Thoracic vertebra 4')->first()->id;
        $bone_group = BoneGroup::firstOrNew(['group_name' => $group, 'sb_id' => $sb_id]);
        $data = array('group_name' => $group, 'sb_id' => $sb_id, 'middle' => true, 'side' => false, 'display_order' => 4, 'for_articulation' => false, 'for_inventory' => true, 'created_by' => $this->sys, 'updated_by' => $this->sys, 'created_at' => $this->dt, 'updated_at' => $this->dt);
        (!$bone_group->exists) ? $bone_group->fill($data)->save() : $bone_group->fill(array_except($data, ['created_at']))->save();
        $sb_id = SkeletalBone::where('name', '=', 'Thoracic vertebra 5')->first()->id;
        $bone_group = BoneGroup::firstOrNew(['group_name' => $group, 'sb_id' => $sb_id]);
        $data = array('group_name' => $group, 'sb_id' => $sb_id, 'middle' => true, 'side' => false, 'display_order' => 5, 'for_articulation' => false, 'for_inventory' => true, 'created_by' => $this->sys, 'updated_by' => $this->sys, 'created_at' => $this->dt, 'updated_at' => $this->dt);
        (!$bone_group->exists) ? $bone_group->fill($data)->save() : $bone_group->fill(array_except($data, ['created_at']))->save();
        $sb_id = SkeletalBone::where('name', '=', 'Thoracic vertebra 6')->first()->id;
        $bone_group = BoneGroup::firstOrNew(['group_name' => $group, 'sb_id' => $sb_id]);
        $data = array('group_name' => $group, 'sb_id' => $sb_id, 'middle' => true, 'side' => false, 'display_order' => 6, 'for_articulation' => false, 'for_inventory' => true, 'created_by' => $this->sys, 'updated_by' => $this->sys, 'created_at' => $this->dt, 'updated_at' => $this->dt);
        (!$bone_group->exists) ? $bone_group->fill($data)->save() : $bone_group->fill(array_except($data, ['created_at']))->save();
        $sb_id = SkeletalBone::where('name', '=', 'Thoracic vertebra 7')->first()->id;
        $bone_group = BoneGroup::firstOrNew(['group_name' => $group, 'sb_id' => $sb_id]);
        $data = array('group_name' => $group, 'sb_id' => $sb_id, 'middle' => true, 'side' => false, 'display_order' => 7, 'for_articulation' => false, 'for_inventory' => true, 'created_by' => $this->sys, 'updated_by' => $this->sys, 'created_at' => $this->dt, 'updated_at' => $this->dt);
        (!$bone_group->exists) ? $bone_group->fill($data)->save() : $bone_group->fill(array_except($data, ['created_at']))->save();
        $sb_id = SkeletalBone::where('name', '=', 'Thoracic vertebra 8')->first()->id;
        $bone_group = BoneGroup::firstOrNew(['group_name' => $group, 'sb_id' => $sb_id]);
        $data = array('group_name' => $group, 'sb_id' => $sb_id, 'middle' => true, 'side' => false, 'display_order' => 8, 'for_articulation' => false, 'for_inventory' => true, 'created_by' => $this->sys, 'updated_by' => $this->sys, 'created_at' => $this->dt, 'updated_at' => $this->dt);
        (!$bone_group->exists) ? $bone_group->fill($data)->save() : $bone_group->fill(array_except($data, ['created_at']))->save();
        $sb_id = SkeletalBone::where('name', '=', 'Thoracic vertebra 9')->first()->id;
        $bone_group = BoneGroup::firstOrNew(['group_name' => $group, 'sb_id' => $sb_id]);
        $data = array('group_name' => $group, 'sb_id' => $sb_id, 'middle' => true, 'side' => false, 'display_order' => 9, 'for_articulation' => false, 'for_inventory' => true, 'created_by' => $this->sys, 'updated_by' => $this->sys, 'created_at' => $this->dt, 'updated_at' => $this->dt);
        (!$bone_group->exists) ? $bone_group->fill($data)->save() : $bone_group->fill(array_except($data, ['created_at']))->save();
        $sb_id = SkeletalBone::where('name', '=', 'Thoracic vertebra 10')->first()->id;
        $bone_group = BoneGroup::firstOrNew(['group_name' => $group, 'sb_id' => $sb_id]);
        $data = array('group_name' => $group, 'sb_id' => $sb_id, 'middle' => true, 'side' => false, 'display_order' => 10, 'for_articulation' => false, 'for_inventory' => true, 'created_by' => $this->sys, 'updated_by' => $this->sys, 'created_at' => $this->dt, 'updated_at' => $this->dt);
        (!$bone_group->exists) ? $bone_group->fill($data)->save() : $bone_group->fill(array_except($data, ['created_at']))->save();
        $sb_id = SkeletalBone::where('name', '=', 'Thoracic vertebra 11')->first()->id;
        $bone_group = BoneGroup::firstOrNew(['group_name' => $group, 'sb_id' => $sb_id]);
        $data = array('group_name' => $group, 'sb_id' => $sb_id, 'middle' => true, 'side' => false, 'display_order' => 11, 'for_articulation' => false, 'for_inventory' => true, 'created_by' => $this->sys, 'updated_by' => $this->sys, 'created_at' => $this->dt, 'updated_at' => $this->dt);
        (!$bone_group->exists) ? $bone_group->fill($data)->save() : $bone_group->fill(array_except($data, ['created_at']))->save();
        $sb_id = SkeletalBone::where('name', '=', 'Thoracic vertebra 12')->first()->id;
        $bone_group = BoneGroup::firstOrNew(['group_name' => $group, 'sb_id' => $sb_id]);
        $data = array('group_name' => $group, 'sb_id' => $sb_id, 'middle' => true, 'side' => false, 'display_order' => 12, 'for_articulation' => false, 'for_inventory' => true, 'created_by' => $this->sys, 'updated_by' => $this->sys, 'created_at' => $this->dt, 'updated_at' => $this->dt);
        (!$bone_group->exists) ? $bone_group->fill($data)->save() : $bone_group->fill(array_except($data, ['created_at']))->save();
    }

    protected function createLumbarVertebraeGroup($group = null)
    {
        if (!isset($group)) {
            $group = 'Lumbar vertebrae';
        }

        $this->command->info($group . ' group seeding!');
        $sb_id = SkeletalBone::where('name', '=', 'Lumbar vertebra 1')->first()->id;
        $bone_group = BoneGroup::firstOrNew(['group_name' => $group, 'sb_id' => $sb_id]);
        $data = array('group_name' => $group, 'sb_id' => $sb_id, 'middle' => true, 'side' => false, 'display_order' => 1, 'for_articulation' => false, 'for_inventory' => true, 'created_by' => $this->sys, 'updated_by' => $this->sys, 'created_at' => $this->dt, 'updated_at' => $this->dt);
        (!$bone_group->exists) ? $bone_group->fill($data)->save() : $bone_group->fill(array_except($data, ['created_at']))->save();
        $sb_id = SkeletalBone::where('name', '=', 'Lumbar vertebra 2')->first()->id;
        $bone_group = BoneGroup::firstOrNew(['group_name' => $group, 'sb_id' => $sb_id]);
        $data = array('group_name' => $group, 'sb_id' => $sb_id, 'middle' => true, 'side' => false, 'display_order' => 2, 'for_articulation' => false, 'for_inventory' => true, 'created_by' => $this->sys, 'updated_by' => $this->sys, 'created_at' => $this->dt, 'updated_at' => $this->dt);
        (!$bone_group->exists) ? $bone_group->fill($data)->save() : $bone_group->fill(array_except($data, ['created_at']))->save();
        $sb_id = SkeletalBone::where('name', '=', 'Lumbar vertebra 3')->first()->id;
        $bone_group = BoneGroup::firstOrNew(['group_name' => $group, 'sb_id' => $sb_id]);
        $data = array('group_name' => $group, 'sb_id' => $sb_id, 'middle' => true, 'side' => false, 'display_order' => 3, 'for_articulation' => false, 'for_inventory' => true, 'created_by' => $this->sys, 'updated_by' => $this->sys, 'created_at' => $this->dt, 'updated_at' => $this->dt);
        (!$bone_group->exists) ? $bone_group->fill($data)->save() : $bone_group->fill(array_except($data, ['created_at']))->save();
        $sb_id = SkeletalBone::where('name', '=', 'Lumbar vertebra 4')->first()->id;
        $bone_group = BoneGroup::firstOrNew(['group_name' => $group, 'sb_id' => $sb_id]);
        $data = array('group_name' => $group, 'sb_id' => $sb_id, 'middle' => true, 'side' => false, 'display_order' => 4, 'for_articulation' => false, 'for_inventory' => true, 'created_by' => $this->sys, 'updated_by' => $this->sys, 'created_at' => $this->dt, 'updated_at' => $this->dt);
        (!$bone_group->exists) ? $bone_group->fill($data)->save() : $bone_group->fill(array_except($data, ['created_at']))->save();
        $sb_id = SkeletalBone::where('name', '=', 'Lumbar vertebra 5')->first()->id;
        $bone_group = BoneGroup::firstOrNew(['group_name' => $group, 'sb_id' => $sb_id]);
        $data = array('group_name' => $group, 'sb_id' => $sb_id, 'middle' => true, 'side' => false, 'display_order' => 5, 'for_articulation' => false, 'for_inventory' => true, 'created_by' => $this->sys, 'updated_by' => $this->sys, 'created_at' => $this->dt, 'updated_at' => $this->dt);
        (!$bone_group->exists) ? $bone_group->fill($data)->save() : $bone_group->fill(array_except($data, ['created_at']))->save();
    }

    protected function createThoraxGroup($group = null)
    {
        if (!isset($group)) {
            $group = 'Thorax';
        }

        $this->command->info($group . ' group seeding!');
        // The Thorax group consists of bones from the Ribs and ThoracicVertebrae groups and the Sternum
        $this->createRibsGroup($group, true, true);
        $this->createThoracicVertebraeGroup($group);
        
        $sb_id = SkeletalBone::where('name', '=', 'Sternum')->first()->id;
        $bone_group = BoneGroup::firstOrNew(['group_name' => $group, 'sb_id' => $sb_id]);
        $data = array('group_name' => $group, 'sb_id' => $sb_id, 'middle' => true, 'side' => false, 'display_order' => 25, 'for_articulation' => true, 'for_inventory' => false, 'created_by' => $this->sys, 'updated_by' => $this->sys, 'created_at' => $this->dt, 'updated_at' => $this->dt);
        (!$bone_group->exists) ? $bone_group->fill($data)->save() : $bone_group->fill(array_except($data, ['created_at']))->save();
    }
    
    protected function createPelvicGirdleGroup($group = null)
    {
        if (!isset($group)) {
            $group = 'Pelvic Girdle';
        }

        $this->command->info($group . ' group seeding!');
        $sb_id = SkeletalBone::where('name', '=', 'Sacrum')->first()->id;
        $bone_group = BoneGroup::firstOrNew(['group_name' => $group, 'sb_id' => $sb_id]);
        $data = array('group_name' => $group, 'sb_id' => $sb_id, 'middle' => true, 'side' => false, 'display_order' => 1, 'for_articulation' => true, 'for_inventory' => true, 'created_by' => $this->sys, 'updated_by' => $this->sys, 'created_at' => $this->dt, 'updated_at' => $this->dt);
        (!$bone_group->exists) ? $bone_group->fill($data)->save() : $bone_group->fill(array_except($data, ['created_at']))->save();
        $sb_id = SkeletalBone::where('name', '=', 'Coccyx')->first()->id;
        $bone_group = BoneGroup::firstOrNew(['group_name' => $group, 'sb_id' => $sb_id]);
        $data = array('group_name' => $group, 'sb_id' => $sb_id, 'middle' => true, 'side' => false, 'display_order' => 2, 'for_articulation' => true, 'for_inventory' => true, 'created_by' => $this->sys, 'updated_by' => $this->sys, 'created_at' => $this->dt, 'updated_at' => $this->dt);
        (!$bone_group->exists) ? $bone_group->fill($data)->save() : $bone_group->fill(array_except($data, ['created_at']))->save();
        $sb_id = SkeletalBone::where('name', '=', 'Os coxa')->first()->id;
        $bone_group = BoneGroup::firstOrNew(['group_name' => $group, 'sb_id' => $sb_id, 'side' => true]);
        $data = array('group_name' => $group, 'sb_id' => $sb_id, 'middle' => true, 'side' => true, 'display_order' => 3, 'for_articulation' => true, 'for_inventory' => true, 'created_by' => $this->sys, 'updated_by' => $this->sys, 'created_at' => $this->dt, 'updated_at' => $this->dt);
        (!$bone_group->exists) ? $bone_group->fill($data)->save() : $bone_group->fill(array_except($data, ['created_at']))->save();
    }

    protected function createLegGroup($group = null, $side = false, $middle = false)
    {
        if (!isset($group)) {
            $group = 'Leg';
        }

        $this->command->info($group . ' group seeding!');
        $sb_id = SkeletalBone::where('name', '=', 'Femur')->first()->id;
        $bone_group = BoneGroup::firstOrNew(['group_name' => $group, 'sb_id' => $sb_id]);
        $data = array('group_name' => $group, 'sb_id' => $sb_id, 'middle' => $middle, 'side' => $side, 'display_order' => 1, 'for_articulation' => true, 'for_inventory' => true, 'created_by' => $this->sys, 'updated_by' => $this->sys, 'created_at' => $this->dt, 'updated_at' => $this->dt);
        (!$bone_group->exists) ? $bone_group->fill($data)->save() : $bone_group->fill(array_except($data, ['created_at']))->save();
        $sb_id = SkeletalBone::where('name', '=', 'Tibia')->first()->id;
        $bone_group = BoneGroup::firstOrNew(['group_name' => $group, 'sb_id' => $sb_id]);
        $data = array('group_name' => $group, 'sb_id' => $sb_id, 'middle' => $middle, 'side' => $side, 'display_order' => 2, 'for_articulation' => true, 'for_inventory' => true, 'created_by' => $this->sys, 'updated_by' => $this->sys, 'created_at' => $this->dt, 'updated_at' => $this->dt);
        (!$bone_group->exists) ? $bone_group->fill($data)->save() : $bone_group->fill(array_except($data, ['created_at']))->save();
        $sb_id = SkeletalBone::where('name', '=', 'Fibula')->first()->id;
        $bone_group = BoneGroup::firstOrNew(['group_name' => $group, 'sb_id' => $sb_id]);
        $data = array('group_name' => $group, 'sb_id' => $sb_id, 'middle' => $middle, 'side' => $side, 'display_order' => 3, 'for_articulation' => true, 'for_inventory' => true, 'created_by' => $this->sys, 'updated_by' => $this->sys, 'created_at' => $this->dt, 'updated_at' => $this->dt);
        (!$bone_group->exists) ? $bone_group->fill($data)->save() : $bone_group->fill(array_except($data, ['created_at']))->save();
        $sb_id = SkeletalBone::where('name', '=', 'Patella')->first()->id;
        $bone_group = BoneGroup::firstOrNew(['group_name' => $group, 'sb_id' => $sb_id]);
        $data = array('group_name' => $group, 'sb_id' => $sb_id, 'middle' => $middle, 'side' => $side, 'display_order' => 4, 'for_articulation' => true, 'for_inventory' => true, 'created_by' => $this->sys, 'updated_by' => $this->sys, 'created_at' => $this->dt, 'updated_at' => $this->dt);
        (!$bone_group->exists) ? $bone_group->fill($data)->save() : $bone_group->fill(array_except($data, ['created_at']))->save();
    }

    protected function createFootGroup($group = null, $side = false, $middle = false)
    {
        if (!isset($group)) {
            $group = 'Foot';
        }

        $this->command->info($group . ' group seeding!');
        $sb_id = SkeletalBone::where('name', '=', 'Calcaneus')->first()->id;
        $bone_group = BoneGroup::firstOrNew(['group_name' => $group, 'sb_id' => $sb_id]);
        $data = array('group_name' => $group, 'sb_id' => $sb_id, 'middle' => $middle, 'side' => $side, 'display_order' => 1, 'for_articulation' => true, 'for_inventory' => true, 'created_by' => $this->sys, 'updated_by' => $this->sys, 'created_at' => $this->dt, 'updated_at' => $this->dt);
        (!$bone_group->exists) ? $bone_group->fill($data)->save() : $bone_group->fill(array_except($data, ['created_at']))->save();
        $sb_id = SkeletalBone::where('name', '=', 'Cuboid')->first()->id;
        $bone_group = BoneGroup::firstOrNew(['group_name' => $group, 'sb_id' => $sb_id]);
        $data = array('group_name' => $group, 'sb_id' => $sb_id, 'middle' => $middle, 'side' => $side, 'display_order' => 2, 'for_articulation' => true, 'for_inventory' => true, 'created_by' => $this->sys, 'updated_by' => $this->sys, 'created_at' => $this->dt, 'updated_at' => $this->dt);
        (!$bone_group->exists) ? $bone_group->fill($data)->save() : $bone_group->fill(array_except($data, ['created_at']))->save();
        $sb_id = SkeletalBone::where('name', '=', 'Talus')->first()->id;
        $bone_group = BoneGroup::firstOrNew(['group_name' => $group, 'sb_id' => $sb_id]);
        $data = array('group_name' => $group, 'sb_id' => $sb_id, 'middle' => $middle, 'side' => $side, 'display_order' => 3, 'for_articulation' => true, 'for_inventory' => true, 'created_by' => $this->sys, 'updated_by' => $this->sys, 'created_at' => $this->dt, 'updated_at' => $this->dt);
        (!$bone_group->exists) ? $bone_group->fill($data)->save() : $bone_group->fill(array_except($data, ['created_at']))->save();
        $sb_id = SkeletalBone::where('name', '=', 'Navicular')->first()->id;
        $bone_group = BoneGroup::firstOrNew(['group_name' => $group, 'sb_id' => $sb_id]);
        $data = array('group_name' => $group, 'sb_id' => $sb_id, 'middle' => $middle, 'side' => $side, 'display_order' => 4, 'for_articulation' => true, 'for_inventory' => true, 'created_by' => $this->sys, 'updated_by' => $this->sys, 'created_at' => $this->dt, 'updated_at' => $this->dt);
        (!$bone_group->exists) ? $bone_group->fill($data)->save() : $bone_group->fill(array_except($data, ['created_at']))->save();
        $sb_id = SkeletalBone::where('name', '=', 'First (Medial) cuneiform')->first()->id;
        $bone_group = BoneGroup::firstOrNew(['group_name' => $group, 'sb_id' => $sb_id]);
        $data = array('group_name' => $group, 'sb_id' => $sb_id, 'middle' => $middle, 'side' => $side, 'display_order' => 5, 'for_articulation' => true, 'for_inventory' => true, 'created_by' => $this->sys, 'updated_by' => $this->sys, 'created_at' => $this->dt, 'updated_at' => $this->dt);
        (!$bone_group->exists) ? $bone_group->fill($data)->save() : $bone_group->fill(array_except($data, ['created_at']))->save();
        $sb_id = SkeletalBone::where('name', '=', 'Second (Intermediate) cuneiform')->first()->id;
        $bone_group = BoneGroup::firstOrNew(['group_name' => $group, 'sb_id' => $sb_id]);
        $data = array('group_name' => $group, 'sb_id' => $sb_id, 'middle' => $middle, 'side' => $side, 'display_order' => 6, 'for_articulation' => true, 'for_inventory' => true, 'created_by' => $this->sys, 'updated_by' => $this->sys, 'created_at' => $this->dt, 'updated_at' => $this->dt);
        (!$bone_group->exists) ? $bone_group->fill($data)->save() : $bone_group->fill(array_except($data, ['created_at']))->save();
        $sb_id = SkeletalBone::where('name', '=', 'Third (Lateral) cuneiform')->first()->id;
        $bone_group = BoneGroup::firstOrNew(['group_name' => $group, 'sb_id' => $sb_id]);
        $data = array('group_name' => $group, 'sb_id' => $sb_id, 'middle' => $middle, 'side' => $side, 'display_order' => 7, 'for_articulation' => true, 'for_inventory' => true, 'created_by' => $this->sys, 'updated_by' => $this->sys, 'created_at' => $this->dt, 'updated_at' => $this->dt);
        (!$bone_group->exists) ? $bone_group->fill($data)->save() : $bone_group->fill(array_except($data, ['created_at']))->save();
        $sb_id = SkeletalBone::where('name', '=', 'Metatarsal 1')->first()->id;
        $bone_group = BoneGroup::firstOrNew(['group_name' => $group, 'sb_id' => $sb_id]);
        $data = array('group_name' => $group, 'sb_id' => $sb_id, 'middle' => $middle, 'side' => $side, 'display_order' => 8, 'for_articulation' => true, 'for_inventory' => true, 'created_by' => $this->sys, 'updated_by' => $this->sys, 'created_at' => $this->dt, 'updated_at' => $this->dt);
        (!$bone_group->exists) ? $bone_group->fill($data)->save() : $bone_group->fill(array_except($data, ['created_at']))->save();
        $sb_id = SkeletalBone::where('name', '=', 'Metatarsal 2')->first()->id;
        $bone_group = BoneGroup::firstOrNew(['group_name' => $group, 'sb_id' => $sb_id]);
        $data = array('group_name' => $group, 'sb_id' => $sb_id, 'middle' => $middle, 'side' => $side, 'display_order' => 9, 'for_articulation' => true, 'for_inventory' => true, 'created_by' => $this->sys, 'updated_by' => $this->sys, 'created_at' => $this->dt, 'updated_at' => $this->dt);
        (!$bone_group->exists) ? $bone_group->fill($data)->save() : $bone_group->fill(array_except($data, ['created_at']))->save();
        $sb_id = SkeletalBone::where('name', '=', 'Metatarsal 3')->first()->id;
        $bone_group = BoneGroup::firstOrNew(['group_name' => $group, 'sb_id' => $sb_id]);
        $data = array('group_name' => $group, 'sb_id' => $sb_id, 'middle' => $middle, 'side' => $side, 'display_order' => 10, 'for_articulation' => true, 'for_inventory' => true, 'created_by' => $this->sys, 'updated_by' => $this->sys, 'created_at' => $this->dt, 'updated_at' => $this->dt);
        (!$bone_group->exists) ? $bone_group->fill($data)->save() : $bone_group->fill(array_except($data, ['created_at']))->save();
        $sb_id = SkeletalBone::where('name', '=', 'Metatarsal 4')->first()->id;
        $bone_group = BoneGroup::firstOrNew(['group_name' => $group, 'sb_id' => $sb_id]);
        $data = array('group_name' => $group, 'sb_id' => $sb_id, 'middle' => $middle, 'side' => $side, 'display_order' => 11, 'for_articulation' => true, 'for_inventory' => true, 'created_by' => $this->sys, 'updated_by' => $this->sys, 'created_at' => $this->dt, 'updated_at' => $this->dt);
        (!$bone_group->exists) ? $bone_group->fill($data)->save() : $bone_group->fill(array_except($data, ['created_at']))->save();
        $sb_id = SkeletalBone::where('name', '=', 'Metatarsal 5')->first()->id;
        $bone_group = BoneGroup::firstOrNew(['group_name' => $group, 'sb_id' => $sb_id]);
        $data = array('group_name' => $group, 'sb_id' => $sb_id, 'middle' => $middle, 'side' => $side, 'display_order' => 12, 'for_articulation' => true, 'for_inventory' => true, 'created_by' => $this->sys, 'updated_by' => $this->sys, 'created_at' => $this->dt, 'updated_at' => $this->dt);
        (!$bone_group->exists) ? $bone_group->fill($data)->save() : $bone_group->fill(array_except($data, ['created_at']))->save();
        $sb_id = SkeletalBone::where('name', '=', 'Proximal pedal phalanx 1')->first()->id;
        $bone_group = BoneGroup::firstOrNew(['group_name' => $group, 'sb_id' => $sb_id]);
        $data = array('group_name' => $group, 'sb_id' => $sb_id, 'middle' => $middle, 'side' => $side, 'display_order' => 13, 'for_articulation' => true, 'for_inventory' => true, 'created_by' => $this->sys, 'updated_by' => $this->sys, 'created_at' => $this->dt, 'updated_at' => $this->dt);
        (!$bone_group->exists) ? $bone_group->fill($data)->save() : $bone_group->fill(array_except($data, ['created_at']))->save();
        $sb_id = SkeletalBone::where('name', '=', 'Proximal pedal phalanx 2')->first()->id;
        $bone_group = BoneGroup::firstOrNew(['group_name' => $group, 'sb_id' => $sb_id]);
        $data = array('group_name' => $group, 'sb_id' => $sb_id, 'middle' => $middle, 'side' => $side, 'display_order' => 14, 'for_articulation' => true, 'for_inventory' => true, 'created_by' => $this->sys, 'updated_by' => $this->sys, 'created_at' => $this->dt, 'updated_at' => $this->dt);
        (!$bone_group->exists) ? $bone_group->fill($data)->save() : $bone_group->fill(array_except($data, ['created_at']))->save();
        $sb_id = SkeletalBone::where('name', '=', 'Proximal pedal phalanx 3')->first()->id;
        $bone_group = BoneGroup::firstOrNew(['group_name' => $group, 'sb_id' => $sb_id]);
        $data = array('group_name' => $group, 'sb_id' => $sb_id, 'middle' => $middle, 'side' => $side, 'display_order' => 15, 'for_articulation' => true, 'for_inventory' => true, 'created_by' => $this->sys, 'updated_by' => $this->sys, 'created_at' => $this->dt, 'updated_at' => $this->dt);
        (!$bone_group->exists) ? $bone_group->fill($data)->save() : $bone_group->fill(array_except($data, ['created_at']))->save();
        $sb_id = SkeletalBone::where('name', '=', 'Proximal pedal phalanx 4')->first()->id;
        $bone_group = BoneGroup::firstOrNew(['group_name' => $group, 'sb_id' => $sb_id]);
        $data = array('group_name' => $group, 'sb_id' => $sb_id, 'middle' => $middle, 'side' => $side, 'display_order' => 16, 'for_articulation' => true, 'for_inventory' => true, 'created_by' => $this->sys, 'updated_by' => $this->sys, 'created_at' => $this->dt, 'updated_at' => $this->dt);
        (!$bone_group->exists) ? $bone_group->fill($data)->save() : $bone_group->fill(array_except($data, ['created_at']))->save();
        $sb_id = SkeletalBone::where('name', '=', 'Proximal pedal phalanx 5')->first()->id;
        $bone_group = BoneGroup::firstOrNew(['group_name' => $group, 'sb_id' => $sb_id]);
        $data = array('group_name' => $group, 'sb_id' => $sb_id, 'middle' => $middle, 'side' => $side, 'display_order' => 17, 'for_articulation' => true, 'for_inventory' => true, 'created_by' => $this->sys, 'updated_by' => $this->sys, 'created_at' => $this->dt, 'updated_at' => $this->dt);
        (!$bone_group->exists) ? $bone_group->fill($data)->save() : $bone_group->fill(array_except($data, ['created_at']))->save();
        $sb_id = SkeletalBone::where('name', '=', 'Intermediate pedal phalanx 2')->first()->id;
        $bone_group = BoneGroup::firstOrNew(['group_name' => $group, 'sb_id' => $sb_id]);
        $data = array('group_name' => $group, 'sb_id' => $sb_id, 'middle' => $middle, 'side' => $side, 'display_order' => 18, 'for_articulation' => true, 'for_inventory' => true, 'created_by' => $this->sys, 'updated_by' => $this->sys, 'created_at' => $this->dt, 'updated_at' => $this->dt);
        (!$bone_group->exists) ? $bone_group->fill($data)->save() : $bone_group->fill(array_except($data, ['created_at']))->save();
        $sb_id = SkeletalBone::where('name', '=', 'Intermediate pedal phalanx 3')->first()->id;
        $bone_group = BoneGroup::firstOrNew(['group_name' => $group, 'sb_id' => $sb_id]);
        $data = array('group_name' => $group, 'sb_id' => $sb_id, 'middle' => $middle, 'side' => $side, 'display_order' => 19, 'for_articulation' => true, 'for_inventory' => true, 'created_by' => $this->sys, 'updated_by' => $this->sys, 'created_at' => $this->dt, 'updated_at' => $this->dt);
        (!$bone_group->exists) ? $bone_group->fill($data)->save() : $bone_group->fill(array_except($data, ['created_at']))->save();
        $sb_id = SkeletalBone::where('name', '=', 'Intermediate pedal phalanx 4')->first()->id;
        $bone_group = BoneGroup::firstOrNew(['group_name' => $group, 'sb_id' => $sb_id]);
        $data = array('group_name' => $group, 'sb_id' => $sb_id, 'middle' => $middle, 'side' => $side, 'display_order' => 20, 'for_articulation' => true, 'for_inventory' => true, 'created_by' => $this->sys, 'updated_by' => $this->sys, 'created_at' => $this->dt, 'updated_at' => $this->dt);
        (!$bone_group->exists) ? $bone_group->fill($data)->save() : $bone_group->fill(array_except($data, ['created_at']))->save();
        $sb_id = SkeletalBone::where('name', '=', 'Intermediate pedal phalanx 5')->first()->id;
        $bone_group = BoneGroup::firstOrNew(['group_name' => $group, 'sb_id' => $sb_id]);
        $data = array('group_name' => $group, 'sb_id' => $sb_id, 'middle' => $middle, 'side' => $side, 'display_order' => 21, 'for_articulation' => true, 'for_inventory' => true, 'created_by' => $this->sys, 'updated_by' => $this->sys, 'created_at' => $this->dt, 'updated_at' => $this->dt);
        (!$bone_group->exists) ? $bone_group->fill($data)->save() : $bone_group->fill(array_except($data, ['created_at']))->save();
        $sb_id = SkeletalBone::where('name', '=', 'Distal pedal phalanx 1')->first()->id;
        $bone_group = BoneGroup::firstOrNew(['group_name' => $group, 'sb_id' => $sb_id]);
        $data = array('group_name' => $group, 'sb_id' => $sb_id, 'middle' => $middle, 'side' => $side, 'display_order' => 22, 'for_articulation' => true, 'for_inventory' => true, 'created_by' => $this->sys, 'updated_by' => $this->sys, 'created_at' => $this->dt, 'updated_at' => $this->dt);
        (!$bone_group->exists) ? $bone_group->fill($data)->save() : $bone_group->fill(array_except($data, ['created_at']))->save();
        $sb_id = SkeletalBone::where('name', '=', 'Distal pedal phalanx 2')->first()->id;
        $bone_group = BoneGroup::firstOrNew(['group_name' => $group, 'sb_id' => $sb_id]);
        $data = array('group_name' => $group, 'sb_id' => $sb_id, 'middle' => $middle, 'side' => $side, 'display_order' => 23, 'for_articulation' => true, 'for_inventory' => true, 'created_by' => $this->sys, 'updated_by' => $this->sys, 'created_at' => $this->dt, 'updated_at' => $this->dt);
        (!$bone_group->exists) ? $bone_group->fill($data)->save() : $bone_group->fill(array_except($data, ['created_at']))->save();
        $sb_id = SkeletalBone::where('name', '=', 'Distal pedal phalanx 3')->first()->id;
        $bone_group = BoneGroup::firstOrNew(['group_name' => $group, 'sb_id' => $sb_id]);
        $data = array('group_name' => $group, 'sb_id' => $sb_id, 'middle' => $middle, 'side' => $side, 'display_order' => 24, 'for_articulation' => true, 'for_inventory' => true, 'created_by' => $this->sys, 'updated_by' => $this->sys, 'created_at' => $this->dt, 'updated_at' => $this->dt);
        (!$bone_group->exists) ? $bone_group->fill($data)->save() : $bone_group->fill(array_except($data, ['created_at']))->save();
        $sb_id = SkeletalBone::where('name', '=', 'Distal pedal phalanx 4')->first()->id;
        $bone_group = BoneGroup::firstOrNew(['group_name' => $group, 'sb_id' => $sb_id]);
        $data = array('group_name' => $group, 'sb_id' => $sb_id, 'middle' => $middle, 'side' => $side, 'display_order' => 25, 'for_articulation' => true, 'for_inventory' => true, 'created_by' => $this->sys, 'updated_by' => $this->sys, 'created_at' => $this->dt, 'updated_at' => $this->dt);
        (!$bone_group->exists) ? $bone_group->fill($data)->save() : $bone_group->fill(array_except($data, ['created_at']))->save();
        $sb_id = SkeletalBone::where('name', '=', 'Distal pedal phalanx 5')->first()->id;
        $bone_group = BoneGroup::firstOrNew(['group_name' => $group, 'sb_id' => $sb_id]);
        $data = array('group_name' => $group, 'sb_id' => $sb_id, 'middle' => $middle, 'side' => $side, 'display_order' => 26, 'for_articulation' => true, 'for_inventory' => true, 'created_by' => $this->sys, 'updated_by' => $this->sys, 'created_at' => $this->dt, 'updated_at' => $this->dt);
        (!$bone_group->exists) ? $bone_group->fill($data)->save() : $bone_group->fill(array_except($data, ['created_at']))->save();
    }

    protected function createMaxillaryDentitionGroup($group = null)
    {
        if (!isset($group)) {
            $group = 'Maxillary dentition';
        }

        $this->command->info($group . ' group seeding!');
        $sb_id = SkeletalBone::where('name', '=', 'Tooth 1')->first()->id;
        $bone_group = BoneGroup::firstOrNew(['group_name' => $group, 'sb_id' => $sb_id]);
        $data = array('group_name' => $group, 'sb_id' => $sb_id, 'middle' => true, 'side' => false, 'display_order' => 1, 'for_articulation' => true, 'for_inventory' => true, 'created_by' => $this->sys, 'updated_by' => $this->sys, 'created_at' => $this->dt, 'updated_at' => $this->dt);
        (!$bone_group->exists) ? $bone_group->fill($data)->save() : $bone_group->fill(array_except($data, ['created_at']))->save();
        $sb_id = SkeletalBone::where('name', '=', 'Tooth 2')->first()->id;
        $bone_group = BoneGroup::firstOrNew(['group_name' => $group, 'sb_id' => $sb_id]);
        $data = array('group_name' => $group, 'sb_id' => $sb_id, 'middle' => true, 'side' => false, 'display_order' => 2, 'for_articulation' => true, 'for_inventory' => true, 'created_by' => $this->sys, 'updated_by' => $this->sys, 'created_at' => $this->dt, 'updated_at' => $this->dt);
        (!$bone_group->exists) ? $bone_group->fill($data)->save() : $bone_group->fill(array_except($data, ['created_at']))->save();
        $sb_id = SkeletalBone::where('name', '=', 'Tooth 3')->first()->id;
        $bone_group = BoneGroup::firstOrNew(['group_name' => $group, 'sb_id' => $sb_id]);
        $data = array('group_name' => $group, 'sb_id' => $sb_id, 'middle' => true, 'side' => false, 'display_order' => 3, 'for_articulation' => true, 'for_inventory' => true, 'created_by' => $this->sys, 'updated_by' => $this->sys, 'created_at' => $this->dt, 'updated_at' => $this->dt);
        (!$bone_group->exists) ? $bone_group->fill($data)->save() : $bone_group->fill(array_except($data, ['created_at']))->save();
        $sb_id = SkeletalBone::where('name', '=', 'Tooth 4')->first()->id;
        $bone_group = BoneGroup::firstOrNew(['group_name' => $group, 'sb_id' => $sb_id]);
        $data = array('group_name' => $group, 'sb_id' => $sb_id, 'middle' => true, 'side' => false, 'display_order' => 4, 'for_articulation' => true, 'for_inventory' => true, 'created_by' => $this->sys, 'updated_by' => $this->sys, 'created_at' => $this->dt, 'updated_at' => $this->dt);
        (!$bone_group->exists) ? $bone_group->fill($data)->save() : $bone_group->fill(array_except($data, ['created_at']))->save();
        $sb_id = SkeletalBone::where('name', '=', 'Tooth 5')->first()->id;
        $bone_group = BoneGroup::firstOrNew(['group_name' => $group, 'sb_id' => $sb_id]);
        $data = array('group_name' => $group, 'sb_id' => $sb_id, 'middle' => true, 'side' => false, 'display_order' => 5, 'for_articulation' => true, 'for_inventory' => true, 'created_by' => $this->sys, 'updated_by' => $this->sys, 'created_at' => $this->dt, 'updated_at' => $this->dt);
        (!$bone_group->exists) ? $bone_group->fill($data)->save() : $bone_group->fill(array_except($data, ['created_at']))->save();
        $sb_id = SkeletalBone::where('name', '=', 'Tooth 6')->first()->id;
        $bone_group = BoneGroup::firstOrNew(['group_name' => $group, 'sb_id' => $sb_id]);
        $data = array('group_name' => $group, 'sb_id' => $sb_id, 'middle' => true, 'side' => false, 'display_order' => 6, 'for_articulation' => true, 'for_inventory' => true, 'created_by' => $this->sys, 'updated_by' => $this->sys, 'created_at' => $this->dt, 'updated_at' => $this->dt);
        (!$bone_group->exists) ? $bone_group->fill($data)->save() : $bone_group->fill(array_except($data, ['created_at']))->save();
        $sb_id = SkeletalBone::where('name', '=', 'Tooth 7')->first()->id;
        $bone_group = BoneGroup::firstOrNew(['group_name' => $group, 'sb_id' => $sb_id]);
        $data = array('group_name' => $group, 'sb_id' => $sb_id, 'middle' => true, 'side' => false, 'display_order' => 7, 'for_articulation' => true, 'for_inventory' => true, 'created_by' => $this->sys, 'updated_by' => $this->sys, 'created_at' => $this->dt, 'updated_at' => $this->dt);
        (!$bone_group->exists) ? $bone_group->fill($data)->save() : $bone_group->fill(array_except($data, ['created_at']))->save();
        $sb_id = SkeletalBone::where('name', '=', 'Tooth 8')->first()->id;
        $bone_group = BoneGroup::firstOrNew(['group_name' => $group, 'sb_id' => $sb_id]);
        $data = array('group_name' => $group, 'sb_id' => $sb_id, 'middle' => true, 'side' => false, 'display_order' => 8, 'for_articulation' => true, 'for_inventory' => true, 'created_by' => $this->sys, 'updated_by' => $this->sys, 'created_at' => $this->dt, 'updated_at' => $this->dt);
        (!$bone_group->exists) ? $bone_group->fill($data)->save() : $bone_group->fill(array_except($data, ['created_at']))->save();
        $sb_id = SkeletalBone::where('name', '=', 'Tooth 9')->first()->id;
        $bone_group = BoneGroup::firstOrNew(['group_name' => $group, 'sb_id' => $sb_id]);
        $data = array('group_name' => $group, 'sb_id' => $sb_id, 'middle' => true, 'side' => false, 'display_order' => 9, 'for_articulation' => true, 'for_inventory' => true, 'created_by' => $this->sys, 'updated_by' => $this->sys, 'created_at' => $this->dt, 'updated_at' => $this->dt);
        (!$bone_group->exists) ? $bone_group->fill($data)->save() : $bone_group->fill(array_except($data, ['created_at']))->save();
        $sb_id = SkeletalBone::where('name', '=', 'Tooth 10')->first()->id;
        $bone_group = BoneGroup::firstOrNew(['group_name' => $group, 'sb_id' => $sb_id]);
        $data = array('group_name' => $group, 'sb_id' => $sb_id, 'middle' => true, 'side' => false, 'display_order' => 10, 'for_articulation' => true, 'for_inventory' => true, 'created_by' => $this->sys, 'updated_by' => $this->sys, 'created_at' => $this->dt, 'updated_at' => $this->dt);
        (!$bone_group->exists) ? $bone_group->fill($data)->save() : $bone_group->fill(array_except($data, ['created_at']))->save();
        $sb_id = SkeletalBone::where('name', '=', 'Tooth 11')->first()->id;
        $bone_group = BoneGroup::firstOrNew(['group_name' => $group, 'sb_id' => $sb_id]);
        $data = array('group_name' => $group, 'sb_id' => $sb_id, 'middle' => true, 'side' => false, 'display_order' => 11, 'for_articulation' => true, 'for_inventory' => true, 'created_by' => $this->sys, 'updated_by' => $this->sys, 'created_at' => $this->dt, 'updated_at' => $this->dt);
        (!$bone_group->exists) ? $bone_group->fill($data)->save() : $bone_group->fill(array_except($data, ['created_at']))->save();
        $sb_id = SkeletalBone::where('name', '=', 'Tooth 12')->first()->id;
        $bone_group = BoneGroup::firstOrNew(['group_name' => $group, 'sb_id' => $sb_id]);
        $data = array('group_name' => $group, 'sb_id' => $sb_id, 'middle' => true, 'side' => false, 'display_order' => 12, 'for_articulation' => true, 'for_inventory' => true, 'created_by' => $this->sys, 'updated_by' => $this->sys, 'created_at' => $this->dt, 'updated_at' => $this->dt);
        (!$bone_group->exists) ? $bone_group->fill($data)->save() : $bone_group->fill(array_except($data, ['created_at']))->save();
        $sb_id = SkeletalBone::where('name', '=', 'Tooth 13')->first()->id;
        $bone_group = BoneGroup::firstOrNew(['group_name' => $group, 'sb_id' => $sb_id]);
        $data = array('group_name' => $group, 'sb_id' => $sb_id, 'middle' => true, 'side' => false, 'display_order' => 13, 'for_articulation' => true, 'for_inventory' => true, 'created_by' => $this->sys, 'updated_by' => $this->sys, 'created_at' => $this->dt, 'updated_at' => $this->dt);
        (!$bone_group->exists) ? $bone_group->fill($data)->save() : $bone_group->fill(array_except($data, ['created_at']))->save();
        $sb_id = SkeletalBone::where('name', '=', 'Tooth 14')->first()->id;
        $bone_group = BoneGroup::firstOrNew(['group_name' => $group, 'sb_id' => $sb_id]);
        $data = array('group_name' => $group, 'sb_id' => $sb_id, 'middle' => true, 'side' => false, 'display_order' => 14, 'for_articulation' => true, 'for_inventory' => true, 'created_by' => $this->sys, 'updated_by' => $this->sys, 'created_at' => $this->dt, 'updated_at' => $this->dt);
        (!$bone_group->exists) ? $bone_group->fill($data)->save() : $bone_group->fill(array_except($data, ['created_at']))->save();
        $sb_id = SkeletalBone::where('name', '=', 'Tooth 15')->first()->id;
        $bone_group = BoneGroup::firstOrNew(['group_name' => $group, 'sb_id' => $sb_id]);
        $data = array('group_name' => $group, 'sb_id' => $sb_id, 'middle' => true, 'side' => false, 'display_order' => 15, 'for_articulation' => true, 'for_inventory' => true, 'created_by' => $this->sys, 'updated_by' => $this->sys, 'created_at' => $this->dt, 'updated_at' => $this->dt);
        (!$bone_group->exists) ? $bone_group->fill($data)->save() : $bone_group->fill(array_except($data, ['created_at']))->save();
        $sb_id = SkeletalBone::where('name', '=', 'Tooth 16')->first()->id;
        $bone_group = BoneGroup::firstOrNew(['group_name' => $group, 'sb_id' => $sb_id]);
        $data = array('group_name' => $group, 'sb_id' => $sb_id, 'middle' => true, 'side' => false, 'display_order' => 16, 'for_articulation' => true, 'for_inventory' => true, 'created_by' => $this->sys, 'updated_by' => $this->sys, 'created_at' => $this->dt, 'updated_at' => $this->dt);
        (!$bone_group->exists) ? $bone_group->fill($data)->save() : $bone_group->fill(array_except($data, ['created_at']))->save();
        $sb_id = SkeletalBone::where('name', '=', 'Maxilla')->first()->id;
        $bone_group = BoneGroup::firstOrNew(['group_name' => $group, 'sb_id' => $sb_id, 'side' => true]);
        $data = array('group_name' => $group, 'sb_id' => $sb_id, 'middle' => true, 'side' => true, 'display_order' => 17, 'for_articulation' => true, 'for_inventory' => true, 'created_by' => $this->sys, 'updated_by' => $this->sys, 'created_at' => $this->dt, 'updated_at' => $this->dt);
        (!$bone_group->exists) ? $bone_group->fill($data)->save() : $bone_group->fill(array_except($data, ['created_at']))->save();
        $sb_id = SkeletalBone::where('name', '=', 'Cranium')->first()->id;
        $bone_group = BoneGroup::firstOrNew(['group_name' => $group, 'sb_id' => $sb_id]);
        $data = array('group_name' => $group, 'sb_id' => $sb_id, 'middle' => true, 'side' => false, 'display_order' => 18, 'for_articulation' => true, 'for_inventory' => true, 'created_by' => $this->sys, 'updated_by' => $this->sys, 'created_at' => $this->dt, 'updated_at' => $this->dt);
        (!$bone_group->exists) ? $bone_group->fill($data)->save() : $bone_group->fill(array_except($data, ['created_at']))->save();
    }

    protected function createMandibularDentitionGroup($group = null)
    {
        if (!isset($group)) {
            $group = 'Mandibular dentition';
        }

        $this->command->info($group . ' group seeding!');
        $sb_id = SkeletalBone::where('name', '=', 'Tooth 17')->first()->id;
        $bone_group = BoneGroup::firstOrNew(['group_name' => $group, 'sb_id' => $sb_id]);
        $data = array('group_name' => $group, 'sb_id' => $sb_id, 'middle' => true, 'side' => false, 'display_order' => 1, 'for_articulation' => true, 'for_inventory' => true, 'created_by' => $this->sys, 'updated_by' => $this->sys, 'created_at' => $this->dt, 'updated_at' => $this->dt);
        (!$bone_group->exists) ? $bone_group->fill($data)->save() : $bone_group->fill(array_except($data, ['created_at']))->save();
        $sb_id = SkeletalBone::where('name', '=', 'Tooth 18')->first()->id;
        $bone_group = BoneGroup::firstOrNew(['group_name' => $group, 'sb_id' => $sb_id]);
        $data = array('group_name' => $group, 'sb_id' => $sb_id, 'middle' => true, 'side' => false, 'display_order' => 2, 'for_articulation' => true, 'for_inventory' => true, 'created_by' => $this->sys, 'updated_by' => $this->sys, 'created_at' => $this->dt, 'updated_at' => $this->dt);
        (!$bone_group->exists) ? $bone_group->fill($data)->save() : $bone_group->fill(array_except($data, ['created_at']))->save();
        $sb_id = SkeletalBone::where('name', '=', 'Tooth 19')->first()->id;
        $bone_group = BoneGroup::firstOrNew(['group_name' => $group, 'sb_id' => $sb_id]);
        $data = array('group_name' => $group, 'sb_id' => $sb_id, 'middle' => true, 'side' => false, 'display_order' => 3, 'for_articulation' => true, 'for_inventory' => true, 'created_by' => $this->sys, 'updated_by' => $this->sys, 'created_at' => $this->dt, 'updated_at' => $this->dt);
        (!$bone_group->exists) ? $bone_group->fill($data)->save() : $bone_group->fill(array_except($data, ['created_at']))->save();
        $sb_id = SkeletalBone::where('name', '=', 'Tooth 20')->first()->id;
        $bone_group = BoneGroup::firstOrNew(['group_name' => $group, 'sb_id' => $sb_id]);
        $data = array('group_name' => $group, 'sb_id' => $sb_id, 'middle' => true, 'side' => false, 'display_order' => 4, 'for_articulation' => true, 'for_inventory' => true, 'created_by' => $this->sys, 'updated_by' => $this->sys, 'created_at' => $this->dt, 'updated_at' => $this->dt);
        (!$bone_group->exists) ? $bone_group->fill($data)->save() : $bone_group->fill(array_except($data, ['created_at']))->save();
        $sb_id = SkeletalBone::where('name', '=', 'Tooth 21')->first()->id;
        $bone_group = BoneGroup::firstOrNew(['group_name' => $group, 'sb_id' => $sb_id]);
        $data = array('group_name' => $group, 'sb_id' => $sb_id, 'middle' => true, 'side' => false, 'display_order' => 5, 'for_articulation' => true, 'for_inventory' => true, 'created_by' => $this->sys, 'updated_by' => $this->sys, 'created_at' => $this->dt, 'updated_at' => $this->dt);
        (!$bone_group->exists) ? $bone_group->fill($data)->save() : $bone_group->fill(array_except($data, ['created_at']))->save();
        $sb_id = SkeletalBone::where('name', '=', 'Tooth 22')->first()->id;
        $bone_group = BoneGroup::firstOrNew(['group_name' => $group, 'sb_id' => $sb_id]);
        $data = array('group_name' => $group, 'sb_id' => $sb_id, 'middle' => true, 'side' => false, 'display_order' => 6, 'for_articulation' => true, 'for_inventory' => true, 'created_by' => $this->sys, 'updated_by' => $this->sys, 'created_at' => $this->dt, 'updated_at' => $this->dt);
        (!$bone_group->exists) ? $bone_group->fill($data)->save() : $bone_group->fill(array_except($data, ['created_at']))->save();
        $sb_id = SkeletalBone::where('name', '=', 'Tooth 23')->first()->id;
        $bone_group = BoneGroup::firstOrNew(['group_name' => $group, 'sb_id' => $sb_id]);
        $data = array('group_name' => $group, 'sb_id' => $sb_id, 'middle' => true, 'side' => false, 'display_order' => 7, 'for_articulation' => true, 'for_inventory' => true, 'created_by' => $this->sys, 'updated_by' => $this->sys, 'created_at' => $this->dt, 'updated_at' => $this->dt);
        (!$bone_group->exists) ? $bone_group->fill($data)->save() : $bone_group->fill(array_except($data, ['created_at']))->save();
        $sb_id = SkeletalBone::where('name', '=', 'Tooth 24')->first()->id;
        $bone_group = BoneGroup::firstOrNew(['group_name' => $group, 'sb_id' => $sb_id]);
        $data = array('group_name' => $group, 'sb_id' => $sb_id, 'middle' => true, 'side' => false, 'display_order' => 8, 'for_articulation' => true, 'for_inventory' => true, 'created_by' => $this->sys, 'updated_by' => $this->sys, 'created_at' => $this->dt, 'updated_at' => $this->dt);
        (!$bone_group->exists) ? $bone_group->fill($data)->save() : $bone_group->fill(array_except($data, ['created_at']))->save();
        $sb_id = SkeletalBone::where('name', '=', 'Tooth 25')->first()->id;
        $bone_group = BoneGroup::firstOrNew(['group_name' => $group, 'sb_id' => $sb_id]);
        $data = array('group_name' => $group, 'sb_id' => $sb_id, 'middle' => true, 'side' => false, 'display_order' => 9, 'for_articulation' => true, 'for_inventory' => true, 'created_by' => $this->sys, 'updated_by' => $this->sys, 'created_at' => $this->dt, 'updated_at' => $this->dt);
        (!$bone_group->exists) ? $bone_group->fill($data)->save() : $bone_group->fill(array_except($data, ['created_at']))->save();
        $sb_id = SkeletalBone::where('name', '=', 'Tooth 26')->first()->id;
        $bone_group = BoneGroup::firstOrNew(['group_name' => $group, 'sb_id' => $sb_id]);
        $data = array('group_name' => $group, 'sb_id' => $sb_id, 'middle' => true, 'side' => false, 'display_order' => 10, 'for_articulation' => true, 'for_inventory' => true, 'created_by' => $this->sys, 'updated_by' => $this->sys, 'created_at' => $this->dt, 'updated_at' => $this->dt);
        (!$bone_group->exists) ? $bone_group->fill($data)->save() : $bone_group->fill(array_except($data, ['created_at']))->save();
        $sb_id = SkeletalBone::where('name', '=', 'Tooth 27')->first()->id;
        $bone_group = BoneGroup::firstOrNew(['group_name' => $group, 'sb_id' => $sb_id]);
        $data = array('group_name' => $group, 'sb_id' => $sb_id, 'middle' => true, 'side' => false, 'display_order' => 11, 'for_articulation' => true, 'for_inventory' => true, 'created_by' => $this->sys, 'updated_by' => $this->sys, 'created_at' => $this->dt, 'updated_at' => $this->dt);
        (!$bone_group->exists) ? $bone_group->fill($data)->save() : $bone_group->fill(array_except($data, ['created_at']))->save();
        $sb_id = SkeletalBone::where('name', '=', 'Tooth 28')->first()->id;
        $bone_group = BoneGroup::firstOrNew(['group_name' => $group, 'sb_id' => $sb_id]);
        $data = array('group_name' => $group, 'sb_id' => $sb_id, 'middle' => true, 'side' => false, 'display_order' => 12, 'for_articulation' => true, 'for_inventory' => true, 'created_by' => $this->sys, 'updated_by' => $this->sys, 'created_at' => $this->dt, 'updated_at' => $this->dt);
        (!$bone_group->exists) ? $bone_group->fill($data)->save() : $bone_group->fill(array_except($data, ['created_at']))->save();
        $sb_id = SkeletalBone::where('name', '=', 'Tooth 29')->first()->id;
        $bone_group = BoneGroup::firstOrNew(['group_name' => $group, 'sb_id' => $sb_id]);
        $data = array('group_name' => $group, 'sb_id' => $sb_id, 'middle' => true, 'side' => false, 'display_order' => 13, 'for_articulation' => true, 'for_inventory' => true, 'created_by' => $this->sys, 'updated_by' => $this->sys, 'created_at' => $this->dt, 'updated_at' => $this->dt);
        (!$bone_group->exists) ? $bone_group->fill($data)->save() : $bone_group->fill(array_except($data, ['created_at']))->save();
        $sb_id = SkeletalBone::where('name', '=', 'Tooth 30')->first()->id;
        $bone_group = BoneGroup::firstOrNew(['group_name' => $group, 'sb_id' => $sb_id]);
        $data = array('group_name' => $group, 'sb_id' => $sb_id, 'middle' => true, 'side' => false, 'display_order' => 14, 'for_articulation' => true, 'for_inventory' => true, 'created_by' => $this->sys, 'updated_by' => $this->sys, 'created_at' => $this->dt, 'updated_at' => $this->dt);
        (!$bone_group->exists) ? $bone_group->fill($data)->save() : $bone_group->fill(array_except($data, ['created_at']))->save();
        $sb_id = SkeletalBone::where('name', '=', 'Tooth 31')->first()->id;
        $bone_group = BoneGroup::firstOrNew(['group_name' => $group, 'sb_id' => $sb_id]);
        $data = array('group_name' => $group, 'sb_id' => $sb_id, 'middle' => true, 'side' => false, 'display_order' => 15, 'for_articulation' => true, 'for_inventory' => true, 'created_by' => $this->sys, 'updated_by' => $this->sys, 'created_at' => $this->dt, 'updated_at' => $this->dt);
        (!$bone_group->exists) ? $bone_group->fill($data)->save() : $bone_group->fill(array_except($data, ['created_at']))->save();
        $sb_id = SkeletalBone::where('name', '=', 'Tooth 32')->first()->id;
        $bone_group = BoneGroup::firstOrNew(['group_name' => $group, 'sb_id' => $sb_id]);
        $data = array('group_name' => $group, 'sb_id' => $sb_id, 'middle' => true, 'side' => false, 'display_order' => 16, 'for_articulation' => true, 'for_inventory' => true, 'created_by' => $this->sys, 'updated_by' => $this->sys, 'created_at' => $this->dt, 'updated_at' => $this->dt);
        (!$bone_group->exists) ? $bone_group->fill($data)->save() : $bone_group->fill(array_except($data, ['created_at']))->save();
        $sb_id = SkeletalBone::where('name', '=', 'Mandible')->first()->id;
        $bone_group = BoneGroup::firstOrNew(['group_name' => $group, 'sb_id' => $sb_id]);
        $data = array('group_name' => $group, 'sb_id' => $sb_id, 'middle' => true, 'side' => false, 'display_order' => 17, 'for_articulation' => true, 'for_inventory' => true, 'created_by' => $this->sys, 'updated_by' => $this->sys, 'created_at' => $this->dt, 'updated_at' => $this->dt);
        (!$bone_group->exists) ? $bone_group->fill($data)->save() : $bone_group->fill(array_except($data, ['created_at']))->save();
    }

    protected function createVertebralColumnGroup($group = null)
    {
        if (!isset($group)) {
            $group = 'Vertebral Column';
        }

        $this->command->info($group . ' group seeding!');
        // The Vertebral Column group consists of bones from the Cervical, Thoracic and Lumbar vertebrae groups and the Sacrum and Coccyx bones
        $this->createCervicalVertebraeGroup($group);
        $this->createThoracicVertebraeGroup($group);
        $this->createLumbarVertebraeGroup($group);

        $sb_id = SkeletalBone::where('name', '=', 'Sacrum')->first()->id;
        $bone_group = BoneGroup::firstOrNew(['group_name' => $group, 'sb_id' => $sb_id]);
        $data = array('group_name' => $group, 'sb_id' => $sb_id, 'middle' => true, 'side' => false, 'display_order' => 25, 'for_articulation' => true, 'for_inventory' => false, 'created_by' => $this->sys, 'updated_by' => $this->sys, 'created_at' => $this->dt, 'updated_at' => $this->dt);
        (!$bone_group->exists) ? $bone_group->fill($data)->save() : $bone_group->fill(array_except($data, ['created_at']))->save();
        $sb_id = SkeletalBone::where('name', '=', 'Coccyx')->first()->id;
        $bone_group = BoneGroup::firstOrNew(['group_name' => $group, 'sb_id' => $sb_id]);
        $data = array('group_name' => $group, 'sb_id' => $sb_id, 'middle' => true, 'side' => false, 'display_order' => 26, 'for_articulation' => true, 'for_inventory' => false, 'created_by' => $this->sys, 'updated_by' => $this->sys, 'created_at' => $this->dt, 'updated_at' => $this->dt);
        (!$bone_group->exists) ? $bone_group->fill($data)->save() : $bone_group->fill(array_except($data, ['created_at']))->save();
    }

    protected function createSkeletonGroup($group = null)
    {
        if (!isset($group)) {
            $group = 'Skeleton';
        }

        $this->command->info($group . ' group seeding!');
        // The Vertebral Column group consists of bones from the Vertebral Column, Ribs and Lumbar vertebrae groups
        $this->createArmAndShoulderGroup($group, true, true);
        $this->createHandGroup($group, true, true);
        $this->createCervicalVertebraeGroup($group);
        $this->createThoraxGroup($group);
        $this->createLumbarVertebraeGroup($group);
        $this->createPelvicGirdleGroup($group);
        $this->createLegGroup($group, true, true);
        $this->createFootGroup($group, true, true);
        $this->createMaxillaryDentitionGroup($group);
        $this->createMandibularDentitionGroup($group);

        // Other bones not create above that are part of the Skeleton Group.
//        $sb_id = SkeletalBone::where('name', '=', 'Sacrum')->first()->id;
//        $bone_group = BoneGroup::firstOrNew(['group_name' => $group, 'sb_id' => $sb_id]);
//        $data = array('group_name' => $group, 'sb_id' => $sb_id, 'middle' => true, 'side' => false, 'display_order' => 25, 'for_articulation' => true, 'for_inventory' => false, 'created_by' => $this->sys, 'updated_by' => $this->sys, 'created_at' => $this->dt, 'updated_at' => $this->dt);
//        (!$bone_group->exists) ? $bone_group->fill($data)->save() : $bone_group->fill(array_except($data, ['created_at']))->save();
    }
}
