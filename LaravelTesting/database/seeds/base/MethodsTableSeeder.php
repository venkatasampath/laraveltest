<?php
/**
 * Method and Method Feature Seeder
 *
 * @category   Method
 * @package    Seeder
 * @author     Sachin Pawaskar<spawaskar@unomaha.edu>
 * @copyright  2016-2018
 * @license    The MIT License (MIT)
 * @version    GIT: $Id$
 * @since      File available since Release 1.0.0
 */

use Illuminate\Database\Seeder;
use App\SkeletalBone;
use App\Method;

class MethodsTableSeeder extends Seeder {

    public function run()
    {
        $dt = date_create();
        $sys = 'System';

        $sb_id = SkeletalBone::where('name', '=', 'Thoracic vertebra 1')->first()->id;
        $method = Method::firstOrNew(['sb_id' => $sb_id, 'name' =>'Albert and Maples 1995', 'submethod' => '']);
		$data = array('sb_id' => $sb_id, 'name' => 'Albert and Maples 1995', 'submethod' => '', 'type' => 'Age', 'reference' => 'JFS 40(4):623-633', 'description' => 'Age estimate by scoring vertebral fusion', 'uses_feature_score' => true, 'uses_composite_score' => false,'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt, 'help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/methods/#albert-am-maples-wr-1995');
        (!$method->exists) ? $method->fill($data)->save() : $method->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name', '=', 'Thoracic vertebra 2')->first()->id;
        $method = Method::firstOrNew(['sb_id' => $sb_id, 'name' =>'Albert and Maples 1995', 'submethod' => '']);
		$data = array('sb_id' => $sb_id, 'name' => 'Albert and Maples 1995', 'submethod' => '', 'type' => 'Age', 'reference' => 'JFS 40(4):623-633', 'description' => 'Age estimate by scoring vertebral fusion', 'uses_feature_score' => true, 'uses_composite_score' => false,'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt, 'help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/methods/#albert-am-maples-wr-1995');
        (!$method->exists) ? $method->fill($data)->save() : $method->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name', '=', 'Thoracic vertebra 3')->first()->id;
        $method = Method::firstOrNew(['sb_id' => $sb_id, 'name' =>'Albert and Maples 1995', 'submethod' => '']);
		$data = array('sb_id' => $sb_id, 'name' => 'Albert and Maples 1995', 'submethod' => '', 'type' => 'Age', 'reference' => 'JFS 40(4):623-633', 'description' => 'Age estimate by scoring vertebral fusion', 'uses_feature_score' => true, 'uses_composite_score' => false,'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt, 'help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/methods/#albert-am-maples-wr-1995');
        (!$method->exists) ? $method->fill($data)->save() : $method->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name', '=', 'Thoracic vertebra 4')->first()->id;
        $method = Method::firstOrNew(['sb_id' => $sb_id, 'name' =>'Albert and Maples 1995', 'submethod' => '']);
		$data = array('sb_id' => $sb_id, 'name' => 'Albert and Maples 1995', 'submethod' => '', 'type' => 'Age', 'reference' => 'JFS 40(4):623-633', 'description' => 'Age estimate by scoring vertebral fusion', 'uses_feature_score' => true, 'uses_composite_score' => false,'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt, 'help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/methods/#albert-am-maples-wr-1995');
        (!$method->exists) ? $method->fill($data)->save() : $method->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name', '=', 'Thoracic vertebra 5')->first()->id;
        $method = Method::firstOrNew(['sb_id' => $sb_id, 'name' =>'Albert and Maples 1995', 'submethod' => '']);
		$data = array('sb_id' => $sb_id, 'name' => 'Albert and Maples 1995', 'submethod' => '', 'type' => 'Age', 'reference' => 'JFS 40(4):623-633', 'description' => 'Age estimate by scoring vertebral fusion', 'uses_feature_score' => true, 'uses_composite_score' => false,'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt, 'help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/methods/#albert-am-maples-wr-1995');
        (!$method->exists) ? $method->fill($data)->save() : $method->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name', '=', 'Thoracic vertebra 6')->first()->id;
        $method = Method::firstOrNew(['sb_id' => $sb_id, 'name' =>'Albert and Maples 1995', 'submethod' => '']);
		$data = array('sb_id' => $sb_id, 'name' => 'Albert and Maples 1995', 'submethod' => '', 'type' => 'Age', 'reference' => 'JFS 40(4):623-633', 'description' => 'Age estimate by scoring vertebral fusion', 'uses_feature_score' => true, 'uses_composite_score' => false,'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt, 'help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/methods/#albert-am-maples-wr-1995');
        (!$method->exists) ? $method->fill($data)->save() : $method->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name', '=', 'Thoracic vertebra 7')->first()->id;
        $method = Method::firstOrNew(['sb_id' => $sb_id, 'name' =>'Albert and Maples 1995', 'submethod' => '']);
		$data = array('sb_id' => $sb_id, 'name' => 'Albert and Maples 1995', 'submethod' => '', 'type' => 'Age', 'reference' => 'JFS 40(4):623-633', 'description' => 'Age estimate by scoring vertebral fusion', 'uses_feature_score' => true, 'uses_composite_score' => false,'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt, 'help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/methods/#albert-am-maples-wr-1995');
        (!$method->exists) ? $method->fill($data)->save() : $method->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name', '=', 'Thoracic vertebra 8')->first()->id;
        $method = Method::firstOrNew(['sb_id' => $sb_id, 'name' =>'Albert and Maples 1995', 'submethod' => '']);
		$data = array('sb_id' => $sb_id, 'name' => 'Albert and Maples 1995', 'submethod' => '', 'type' => 'Age', 'reference' => 'JFS 40(4):623-633', 'description' => 'Age estimate by scoring vertebral fusion', 'uses_feature_score' => true, 'uses_composite_score' => false,'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt, 'help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/methods/#albert-am-maples-wr-1995');
        (!$method->exists) ? $method->fill($data)->save() : $method->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name', '=', 'Thoracic vertebra 9')->first()->id;
        $method = Method::firstOrNew(['sb_id' => $sb_id, 'name' =>'Albert and Maples 1995', 'submethod' => '']);
		$data = array('sb_id' => $sb_id, 'name' => 'Albert and Maples 1995', 'submethod' => '', 'type' => 'Age', 'reference' => 'JFS 40(4):623-633', 'description' => 'Age estimate by scoring vertebral fusion', 'uses_feature_score' => true, 'uses_composite_score' => false,'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt, 'help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/methods/#albert-am-maples-wr-1995');
        (!$method->exists) ? $method->fill($data)->save() : $method->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name', '=', 'Thoracic vertebra 10')->first()->id;
        $method = Method::firstOrNew(['sb_id' => $sb_id, 'name' =>'Albert and Maples 1995', 'submethod' => '']);
		$data = array('sb_id' => $sb_id, 'name' => 'Albert and Maples 1995', 'submethod' => '', 'type' => 'Age', 'reference' => 'JFS 40(4):623-633', 'description' => 'Age estimate by scoring vertebral fusion', 'uses_feature_score' => true, 'uses_composite_score' => false,'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt, 'help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/methods/#albert-am-maples-wr-1995');
        (!$method->exists) ? $method->fill($data)->save() : $method->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name', '=', 'Thoracic vertebra 11')->first()->id;
        $method = Method::firstOrNew(['sb_id' => $sb_id, 'name' =>'Albert and Maples 1995', 'submethod' => '']);
		$data = array('sb_id' => $sb_id, 'name' => 'Albert and Maples 1995', 'submethod' => '', 'type' => 'Age', 'reference' => 'JFS 40(4):623-633', 'description' => 'Age estimate by scoring vertebral fusion', 'uses_feature_score' => true, 'uses_composite_score' => false,'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt, 'help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/methods/#albert-am-maples-wr-1995');
        (!$method->exists) ? $method->fill($data)->save() : $method->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name', '=', 'Thoracic vertebra 12')->first()->id;
        $method = Method::firstOrNew(['sb_id' => $sb_id, 'name' =>'Albert and Maples 1995', 'submethod' => '']);
		$data = array('sb_id' => $sb_id, 'name' => 'Albert and Maples 1995', 'submethod' => '', 'type' => 'Age', 'reference' => 'JFS 40(4):623-633', 'description' => 'Age estimate by scoring vertebral fusion', 'uses_feature_score' => true, 'uses_composite_score' => false,'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt, 'help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/methods/#albert-am-maples-wr-1995');
        (!$method->exists) ? $method->fill($data)->save() : $method->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name', '=', 'Thoracic vertebra 10/11/12')->first()->id;
		$method = Method::firstOrNew(['sb_id' => $sb_id, 'name' =>'Albert and Maples 1995', 'submethod' => '']);
		$data = array('sb_id' => $sb_id, 'name' => 'Albert and Maples 1995', 'submethod' => '', 'type' => 'Age', 'reference' => 'JFS 40(4):623-633', 'description' => 'Age estimate by scoring vertebral fusion', 'uses_feature_score' => true, 'uses_composite_score' => false,'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt, 'help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/methods/#albert-am-maples-wr-1995');
        (!$method->exists) ? $method->fill($data)->save() : $method->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name', '=', 'Thoracic vertebra 10/11')->first()->id;
		$method = Method::firstOrNew(['sb_id' => $sb_id, 'name' =>'Albert and Maples 1995', 'submethod' => '']);
		$data = array('sb_id' => $sb_id, 'name' => 'Albert and Maples 1995', 'submethod' => '', 'type' => 'Age', 'reference' => 'JFS 40(4):623-633', 'description' => 'Age estimate by scoring vertebral fusion', 'uses_feature_score' => true, 'uses_composite_score' => false,'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt, 'help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/methods/#albert-am-maples-wr-1995');
        (!$method->exists) ? $method->fill($data)->save() : $method->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name', '=', 'Thoracic vertebra 11/12')->first()->id;
		$method = Method::firstOrNew(['sb_id' => $sb_id, 'name' =>'Albert and Maples 1995', 'submethod' => '']);
		$data = array('sb_id' => $sb_id, 'name' => 'Albert and Maples 1995', 'submethod' => '', 'type' => 'Age', 'reference' => 'JFS 40(4):623-633', 'description' => 'Age estimate by scoring vertebral fusion', 'uses_feature_score' => true, 'uses_composite_score' => false,'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt, 'help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/methods/#albert-am-maples-wr-1995');
        (!$method->exists) ? $method->fill($data)->save() : $method->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name', '=', 'Thoracic vertebra 1/2')->first()->id;
		$method = Method::firstOrNew(['sb_id' => $sb_id, 'name' =>'Albert and Maples 1995', 'submethod' => '']);
		$data = array('sb_id' => $sb_id, 'name' => 'Albert and Maples 1995', 'submethod' => '', 'type' => 'Age', 'reference' => 'JFS 40(4):623-633', 'description' => 'Age estimate by scoring vertebral fusion', 'uses_feature_score' => true, 'uses_composite_score' => false,'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt, 'help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/methods/#albert-am-maples-wr-1995');
        (!$method->exists) ? $method->fill($data)->save() : $method->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name', '=', 'Unseriated thoracic vertebra')->first()->id;
		$method = Method::firstOrNew(['sb_id' => $sb_id, 'name' =>'Albert and Maples 1995', 'submethod' => '']);
		$data = array('sb_id' => $sb_id, 'name' => 'Albert and Maples 1995', 'submethod' => '', 'type' => 'Age', 'reference' => 'JFS 40(4):623-633', 'description' => 'Age estimate by scoring vertebral fusion', 'uses_feature_score' => true, 'uses_composite_score' => false,'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt, 'help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/methods/#albert-am-maples-wr-1995');
        (!$method->exists) ? $method->fill($data)->save() : $method->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name', '=', 'Unseriated lumbar vertebra')->first()->id;
		$method = Method::firstOrNew(['sb_id' => $sb_id, 'name' =>'Albert and Maples 1995', 'submethod' => '']);
		$data = array('sb_id' => $sb_id, 'name' => 'Albert and Maples 1995', 'submethod' => '', 'type' => 'Age', 'reference' => 'JFS 40(4):623-633', 'description' => 'Age estimate by scoring vertebral fusion', 'uses_feature_score' => true, 'uses_composite_score' => false,'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt, 'help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/methods/#albert-am-maples-wr-1995');
        (!$method->exists) ? $method->fill($data)->save() : $method->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name', '=', 'Lumbar vertebra 1')->first()->id;
		$method = Method::firstOrNew(['sb_id' => $sb_id, 'name' =>'Albert and Maples 1995', 'submethod' => '']);
		$data = array('sb_id' => $sb_id, 'name' => 'Albert and Maples 1995', 'submethod' => '', 'type' => 'Age', 'reference' => 'JFS 40(4):623-633', 'description' => 'Age estimate by scoring vertebral fusion', 'uses_feature_score' => true, 'uses_composite_score' => false,'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt, 'help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/methods/#albert-am-maples-wr-1995');
        (!$method->exists) ? $method->fill($data)->save() : $method->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name', '=', 'Lumbar vertebra 2')->first()->id;
		$method = Method::firstOrNew(['sb_id' => $sb_id, 'name' =>'Albert and Maples 1995', 'submethod' => '']);
		$data = array('sb_id' => $sb_id, 'name' => 'Albert and Maples 1995', 'submethod' => '', 'type' => 'Age', 'reference' => 'JFS 40(4):623-633', 'description' => 'Age estimate by scoring vertebral fusion', 'uses_feature_score' => true, 'uses_composite_score' => false,'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt, 'help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/methods/#albert-am-maples-wr-1995');
        (!$method->exists) ? $method->fill($data)->save() : $method->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name', '=', 'Lumbar vertebra 3')->first()->id;
		$method = Method::firstOrNew(['sb_id' => $sb_id, 'name' =>'Albert and Maples 1995', 'submethod' => '']);
		$data = array('sb_id' => $sb_id, 'name' => 'Albert and Maples 1995', 'submethod' => '', 'type' => 'Age', 'reference' => 'JFS 40(4):623-633', 'description' => 'Age estimate by scoring vertebral fusion', 'uses_feature_score' => true, 'uses_composite_score' => false,'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt, 'help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/methods/#albert-am-maples-wr-1995');
        (!$method->exists) ? $method->fill($data)->save() : $method->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name', '=', 'Lumbar vertebra 4')->first()->id;
		$method = Method::firstOrNew(['sb_id' => $sb_id, 'name' =>'Albert and Maples 1995', 'submethod' => '']);
		$data = array('sb_id' => $sb_id, 'name' => 'Albert and Maples 1995', 'submethod' => '', 'type' => 'Age', 'reference' => 'JFS 40(4):623-633', 'description' => 'Age estimate by scoring vertebral fusion', 'uses_feature_score' => true, 'uses_composite_score' => false,'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt, 'help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/methods/#albert-am-maples-wr-1995');
        (!$method->exists) ? $method->fill($data)->save() : $method->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name', '=', 'Lumbar vertebra 5')->first()->id;
		$method = Method::firstOrNew(['sb_id' => $sb_id, 'name' =>'Albert and Maples 1995', 'submethod' => '']);
		$data = array('sb_id' => $sb_id, 'name' => 'Albert and Maples 1995', 'submethod' => '', 'type' => 'Age', 'reference' => 'JFS 40(4):623-633', 'description' => 'Age estimate by scoring vertebral fusion', 'uses_feature_score' => true, 'uses_composite_score' => false,'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt, 'help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/methods/#albert-am-maples-wr-1995');
        (!$method->exists) ? $method->fill($data)->save() : $method->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name', '=', 'Lumbar vertebra 1/2')->first()->id;
		$method = Method::firstOrNew(['sb_id' => $sb_id, 'name' =>'Albert and Maples 1995', 'submethod' => '']);
		$data = array('sb_id' => $sb_id, 'name' => 'Albert and Maples 1995', 'submethod' => '', 'type' => 'Age', 'reference' => 'JFS 40(4):623-633', 'description' => 'Age estimate by scoring vertebral fusion', 'uses_feature_score' => true, 'uses_composite_score' => false,'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt, 'help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/methods/#albert-am-maples-wr-1995');
        (!$method->exists) ? $method->fill($data)->save() : $method->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name', '=', 'Lumbar vertebra 2/3')->first()->id;
		$method = Method::firstOrNew(['sb_id' => $sb_id, 'name' =>'Albert and Maples 1995', 'submethod' => '']);
		$data = array('sb_id' => $sb_id, 'name' => 'Albert and Maples 1995', 'submethod' => '', 'type' => 'Age', 'reference' => 'JFS 40(4):623-633', 'description' => 'Age estimate by scoring vertebral fusion', 'uses_feature_score' => true, 'uses_composite_score' => false,'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt, 'help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/methods/#albert-am-maples-wr-1995');
        (!$method->exists) ? $method->fill($data)->save() : $method->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name', '=', 'Lumbar vertebra 3/4')->first()->id;
		$method = Method::firstOrNew(['sb_id' => $sb_id, 'name' =>'Albert and Maples 1995', 'submethod' => '']);
		$data = array('sb_id' => $sb_id, 'name' => 'Albert and Maples 1995', 'submethod' => '', 'type' => 'Age', 'reference' => 'JFS 40(4):623-633', 'description' => 'Age estimate by scoring vertebral fusion', 'uses_feature_score' => true, 'uses_composite_score' => false,'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt, 'help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/methods/#albert-am-maples-wr-1995');
        (!$method->exists) ? $method->fill($data)->save() : $method->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name', '=', 'Lumbar vertebra 4/5')->first()->id;
		$method = Method::firstOrNew(['sb_id' => $sb_id, 'name' =>'Albert and Maples 1995', 'submethod' => '']);
		$data = array('sb_id' => $sb_id, 'name' => 'Albert and Maples 1995', 'submethod' => '', 'type' => 'Age', 'reference' => 'JFS 40(4):623-633', 'description' => 'Age estimate by scoring vertebral fusion', 'uses_feature_score' => true, 'uses_composite_score' => false,'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt, 'help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/methods/#albert-am-maples-wr-1995');
        (!$method->exists) ? $method->fill($data)->save() : $method->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name', '=', 'Os coxa')->first()->id;
		$method = Method::firstOrNew(['sb_id' => $sb_id, 'name' =>'Berg 2008', 'submethod' => '']);
		$data = array('sb_id' => $sb_id, 'name' => 'Berg 2008', 'submethod' => '', 'type' => 'Age', 'reference' => 'JFS 53(3):569-577', 'description' => 'Age estimate based on pubic symphysis morphology (for females)', 'uses_feature_score' => true, 'uses_composite_score' => false,'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt, 'help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/methods/#berg-ge-2008');
        (!$method->exists) ? $method->fill($data)->save() : $method->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name', '=', 'Cranium')->first()->id;
		$method = Method::firstOrNew(['sb_id' => $sb_id, 'name' =>'Blankenship et al 2007', 'submethod' => '']);
		$data = array('sb_id' => $sb_id, 'name' => 'Blankenship et al 2007', 'submethod' => '', 'type' => 'Age', 'reference' => 'JFS 52(2):428-433', 'description' => 'Age estimation of African American populations by scoring third molar development', 'uses_feature_score' => true, 'uses_composite_score' => false,'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt, 'help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/methods/#blankenship-ja-mincer-hh-anderson-km-woods-ma-burton-el-2007');
        (!$method->exists) ? $method->fill($data)->save() : $method->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name', '=', 'Mandible')->first()->id;
		$method = Method::firstOrNew(['sb_id' => $sb_id, 'name' =>'Blankenship et al 2007', 'submethod' => '']);
		$data = array('sb_id' => $sb_id, 'name' => 'Blankenship et al 2007', 'submethod' => '', 'type' => 'Age', 'reference' => 'JFS 52(2):428-433', 'description' => 'Age estimation of African American populations by scoring third molar development', 'uses_feature_score' => true, 'uses_composite_score' => false,'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt, 'help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/methods/#blankenship-ja-mincer-hh-anderson-km-woods-ma-burton-el-2007');
        (!$method->exists) ? $method->fill($data)->save() : $method->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name', '=', 'Maxilla')->first()->id;
		$method = Method::firstOrNew(['sb_id' => $sb_id, 'name' =>'Blankenship et al 2007', 'submethod' => '']);
		$data = array('sb_id' => $sb_id, 'name' => 'Blankenship et al 2007', 'submethod' => '', 'type' => 'Age', 'reference' => 'JFS 52(2):428-433', 'description' => '', 'uses_feature_score' => false, 'uses_composite_score' => false,'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt, 'help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/methods/#blankenship-ja-mincer-hh-anderson-km-woods-ma-burton-el-2007');
        (!$method->exists) ? $method->fill($data)->save() : $method->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name', '=', 'Os coxa')->first()->id;
		$method = Method::firstOrNew(['sb_id' => $sb_id, 'name' =>'Brooks and Suchey 1990', 'submethod' => '']);
		$data = array('sb_id' => $sb_id, 'name' => 'Brooks and Suchey 1990', 'submethod' => '', 'type' => 'Age', 'reference' => 'Human Evolution 5:227-238', 'description' => 'Age estimation based on pubic symphysis morphology (better for older individuals and females)', 'uses_feature_score' => true, 'uses_composite_score' => false,'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt, 'help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/methods/#brooks-s-suchey-jm-1990');
        (!$method->exists) ? $method->fill($data)->save() : $method->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name', '=', 'Os coxa')->first()->id;
		$method = Method::firstOrNew(['sb_id' => $sb_id, 'name' =>'Buckberry and Chamberlain 2002', 'submethod' => '']);
		$data = array('sb_id' => $sb_id, 'name' => 'Buckberry and Chamberlain 2002', 'submethod' => '', 'type' => 'Age', 'reference' => 'AJPA 119:231-239', 'description' => 'Age estimation by scoring auricular surface morphology', 'uses_feature_score' => true, 'uses_composite_score' => true,'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt, 'help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/methods/#buckberry-jl-chamberlain-at-2002');
        (!$method->exists) ? $method->fill($data)->save() : $method->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name', '=', 'Cranium')->first()->id;
		$method = Method::firstOrNew(['sb_id' => $sb_id, 'name' =>'Buikstra and Ubelaker 1994', 'submethod' => '']);
		$data = array('sb_id' => $sb_id, 'name' => 'Buikstra and Ubelaker 1994', 'submethod' => '', 'type' => 'Sex', 'reference' => 'Standards for Data Collection from Human Skeletal Remains.  Arkansas Archaeological Survey Research Series No. 44', 'description' => 'Sex estimation by scoring skeletal morphology', 'uses_feature_score' => true, 'uses_composite_score' => false,'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt, 'help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/methods/#buikstra-je-ubelaker-dh-1994');
        (!$method->exists) ? $method->fill($data)->save() : $method->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name', '=', 'Mandible')->first()->id;
        $method = Method::firstOrNew(['sb_id' => $sb_id, 'name' =>'Buikstra and Ubelaker 1994', 'submethod' => '']);
        $data = array('sb_id' => $sb_id, 'name' => 'Buikstra and Ubelaker 1994', 'submethod' => '', 'type' => 'Sex', 'reference' => 'Standards for Data Collection from Human Skeletal Remains.  Arkansas Archaeological Survey Research Series No. 44', 'description' => 'Sex estimation by scoring skeletal morphology', 'uses_feature_score' => true, 'uses_composite_score' => false,'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt, 'help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/methods/#buikstra-je-ubelaker-dh-1994');
        (!$method->exists) ? $method->fill($data)->save() : $method->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name', '=', 'Os coxa')->first()->id;
		$method = Method::firstOrNew(['sb_id' => $sb_id, 'name' =>'Buikstra and Ubelaker 1994', 'submethod' => '']);
		$data = array('sb_id' => $sb_id, 'name' => 'Buikstra and Ubelaker 1994', 'submethod' => '', 'type' => 'Sex', 'reference' => 'Standards for Data Collection from Human Skeletal Remains.  Arkansas Archaeological Survey Research Series No. 44', 'description' => 'Sex estimation by scoring skeletal morphology', 'uses_feature_score' => true, 'uses_composite_score' => false,'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt, 'help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/methods/#buikstra-je-ubelaker-dh-1994');
        (!$method->exists) ? $method->fill($data)->save() : $method->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name', '=', 'Cranium')->first()->id;
		$method = Method::firstOrNew(['sb_id' => $sb_id, 'name' =>'Edgar 2013', 'submethod' => '']);
		$data = array('sb_id' => $sb_id, 'name' => 'Edgar 2013', 'submethod' => '', 'type' => 'Ancestry', 'reference' => 'JFS 58:S3-S8', 'description' => 'Ancestry estimation based on dental morphology (African, Hispanic, European)', 'uses_feature_score' => true, 'uses_composite_score' => false,'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt, 'help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/methods/#edgar-hjh-2013');
        (!$method->exists) ? $method->fill($data)->save() : $method->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name', '=', 'Mandible')->first()->id;
		$method = Method::firstOrNew(['sb_id' => $sb_id, 'name' =>'Edgar 2013', 'submethod' => '']);
		$data = array('sb_id' => $sb_id, 'name' => 'Edgar 2013', 'submethod' => '', 'type' => 'Ancestry', 'reference' => 'JFS 58:S3-S8', 'description' => 'Ancestry estimation based on dental morphology (African, Hispanic, European)', 'uses_feature_score' => true, 'uses_composite_score' => false,'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt, 'help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/methods/#edgar-hjh-2013');
        (!$method->exists) ? $method->fill($data)->save() : $method->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name', '=', 'Clavicle')->first()->id;
		$method = Method::firstOrNew(['sb_id' => $sb_id, 'name' =>'Falys and Prangle 2015', 'submethod' => '']);
		$data = array('sb_id' => $sb_id, 'name' => 'Falys and Prangle 2015', 'submethod' => '', 'type' => 'Age', 'reference' => 'AJPA 156:203-214', 'description' => 'Age estimate based on clavicle morphology', 'uses_feature_score' => true, 'uses_composite_score' => true,'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt, 'help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/methods');
        (!$method->exists) ? $method->fill($data)->save() : $method->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name', '=', 'Cranium')->first()->id;
		$method = Method::firstOrNew(['sb_id' => $sb_id, 'name' =>'Gill 1998', 'submethod' => '']);
		$data = array('sb_id' => $sb_id, 'name' => 'Gill 1998', 'submethod' => '', 'type' => 'Ancestry', 'reference' => 'Forensic Osteology, edited by K. Reichs.  Charles C. Thomas.', 'description' => 'Ancestry estimation based on cranial morphology (American Indian, Black, East Asian, Polynesian, White)', 'uses_feature_score' => true, 'uses_composite_score' => false,'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt, 'help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/methods/#gill-gw-1998');
        (!$method->exists) ? $method->fill($data)->save() : $method->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name', '=', 'Cranium')->first()->id;
		$method = Method::firstOrNew(['sb_id' => $sb_id, 'name' =>'Hefner 2009', 'submethod' => '']);
		$data = array('sb_id' => $sb_id, 'name' => 'Hefner 2009', 'submethod' => '', 'type' => 'Ancestry', 'reference' => 'JFS 54(5):985-995', 'description' => 'Ancestry estimation by scoring cranial morphology (American Indian, Asian, Black, White)', 'uses_feature_score' => true, 'uses_composite_score' => false,'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt, 'help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/methods/#hefner-j-2009');
        (!$method->exists) ? $method->fill($data)->save() : $method->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name', '=', 'Cranium')->first()->id;
		$method = Method::firstOrNew(['sb_id' => $sb_id, 'name' =>'Hefner and Ousley 2014', 'submethod' => '']);
		$data = array('sb_id' => $sb_id, 'name' => 'Hefner and Ousley 2014', 'submethod' => '', 'type' => 'Ancestry', 'reference' => 'JFS 59(4):883-890', 'description' => 'Ancestry estimation by scoring cranial morphology (Black, Hispanic, White)', 'uses_feature_score' => true, 'uses_composite_score' => true,'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt, 'help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/methods/#hefner-j-ousley-sd-2014');
        (!$method->exists) ? $method->fill($data)->save() : $method->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name', '=', 'Rib 4')->first()->id;
		$method = Method::firstOrNew(['sb_id' => $sb_id, 'name' =>'Iscan et al 1984', 'submethod' => '']);
		$data = array('sb_id' => $sb_id, 'name' => 'Iscan et al 1984', 'submethod' => '', 'type' => 'Age', 'reference' => 'JFS 29:1094-1104', 'description' => 'Age estimation based on the morphology of the sternal end of the fourth rib (Males)', 'uses_feature_score' => true, 'uses_composite_score' => false,'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt, 'help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/methods/#iscan-my-loth-sr-wright-rk-1984');
        (!$method->exists) ? $method->fill($data)->save() : $method->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name', '=', 'Rib 4')->first()->id;
        $method = Method::firstOrNew(['sb_id' => $sb_id, 'name' =>'Iscan et al 1985', 'submethod' => '']);
		$data = array('sb_id' => $sb_id, 'name' => 'Iscan et al 1985', 'submethod' => '', 'type' => 'Age', 'reference' => 'JFS 30:853-863', 'description' => 'Age estimation based on the morphology of the sternal end of the fourth rib (Females)', 'uses_feature_score' => true, 'uses_composite_score' => false,'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt, 'help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/methods/#iscan-my-loth-sr-wright-rk-1985');
        (!$method->exists) ? $method->fill($data)->save() : $method->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name', '=', 'Cranium')->first()->id;
		$method = Method::firstOrNew(['sb_id' => $sb_id, 'name' =>'Kasper et al 2009', 'submethod' => '']);
		$data = array('sb_id' => $sb_id, 'name' => 'Kasper et al 2009', 'submethod' => '', 'type' => 'Age', 'reference' => 'JFS 54(3):651-657', 'description' => 'Age estimation of Hispanic populations by scoring third molar development', 'uses_feature_score' => true, 'uses_composite_score' => false,'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt, 'help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/methods/#kasper-ka-austin-d-kvanli-ah-rios-tr-senn-dr-2009');
        (!$method->exists) ? $method->fill($data)->save() : $method->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name', '=', 'Maxilla')->first()->id;
        $method = Method::firstOrNew(['sb_id' => $sb_id, 'name' =>'Kasper et al 2009', 'submethod' => '']);
        $data = array('sb_id' => $sb_id, 'name' => 'Kasper et al 2009', 'submethod' => '', 'type' => 'Age', 'reference' => 'JFS 54(3):651-657', 'description' => 'Age estimation of Hispanic populations by scoring third molar development', 'uses_feature_score' => true, 'uses_composite_score' => false,'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt, 'help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/methods/#kasper-ka-austin-d-kvanli-ah-rios-tr-senn-dr-2009');
        (!$method->exists) ? $method->fill($data)->save() : $method->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name', '=', 'Mandible')->first()->id;
		$method = Method::firstOrNew(['sb_id' => $sb_id, 'name' =>'Kasper et al 2009', 'submethod' => '']);
		$data = array('sb_id' => $sb_id, 'name' => 'Kasper et al 2009', 'submethod' => '', 'type' => 'Age', 'reference' => 'JFS 54(3):651-657', 'description' => 'Age estimation of Hispanic populations by scoring third molar development', 'uses_feature_score' => true, 'uses_composite_score' => false,'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt, 'help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/methods/#kasper-ka-austin-d-kvanli-ah-rios-tr-senn-dr-2009');
        (!$method->exists) ? $method->fill($data)->save() : $method->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name', '=', 'Clavicle')->first()->id;
		$method = Method::firstOrNew(['sb_id' => $sb_id, 'name' =>'Langley and Jantz 2010', 'submethod' => '']);
		$data = array('sb_id' => $sb_id, 'name' => 'Langley and Jantz 2010', 'submethod' => '', 'type' => 'Age', 'reference' => 'JFS 55(3):571-583', 'description' => 'Age estimate based on clavicle morphology', 'uses_feature_score' => true, 'uses_composite_score' => false,'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt, 'help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/methods/#langley-shirley-n-jantz-rl-2010');
        (!$method->exists) ? $method->fill($data)->save() : $method->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name', '=', 'Os coxa')->first()->id;
		$method = Method::firstOrNew(['sb_id' => $sb_id, 'name' =>'Lovejoy et al 1985', 'submethod' => '']);
		$data = array('sb_id' => $sb_id, 'name' => 'Lovejoy et al 1985', 'submethod' => '', 'type' => 'Age', 'reference' => 'AJPA 68:15-28', 'description' => 'Age estimate based on auricular surface morphology', 'uses_feature_score' => true, 'uses_composite_score' => false,'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt, 'help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/methods/#lovejoy-co-meindl-rs-pryzbeck-tr-mensforth-rp-1985');
        (!$method->exists) ? $method->fill($data)->save() : $method->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name', '=', 'Cranium')->first()->id;
		$method = Method::firstOrNew(['sb_id' => $sb_id, 'name' =>'Mann et al 1991', 'submethod' => '']);
		$data = array('sb_id' => $sb_id, 'name' => 'Mann et al 1991', 'submethod' => '', 'type' => 'Age', 'reference' => 'JFS 36:781-791', 'description' => 'Age estimation by assessing maxillary suture closure', 'uses_feature_score' => true, 'uses_composite_score' => false,'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt, 'help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/methods/#mann-rw-jantz-rl-bass-wm-willey-ps-1991');
        (!$method->exists) ? $method->fill($data)->save() : $method->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name', '=', 'Accessory rib')->first()->id;
		$method = Method::firstOrNew(['sb_id' => $sb_id, 'name' =>'McKern and Stewart 1957', 'submethod' => '']);
		$data = array('sb_id' => $sb_id, 'name' => 'McKern and Stewart 1957', 'submethod' => '', 'type' => 'Age', 'reference' => 'Skeletal Age Changes in Young American Males.  Quartermaster Research and Development Command Technical Report.', 'description' => 'Age estimation by scoring epiphyseal closures', 'uses_feature_score' => true, 'uses_composite_score' => false,'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt, 'help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/methods/#mckern-tw-stewart-td-1957');
        (!$method->exists) ? $method->fill($data)->save() : $method->fill(array_except($data, ['created_at']))->save();

//        $sb_id = SkeletalBone::where('name', '=', 'Cervical vertebra 1')->first()->id;
//		$method = Method::firstOrNew(['sb_id' => $sb_id, 'name' =>'McKern and Stewart 1957', 'submethod' => '']);
//		$data = array('sb_id' => $sb_id, 'name' => 'McKern and Stewart 1957', 'submethod' => '', 'type' => 'Age', 'reference' => 'Skeletal Age Changes in Young American Males.  Quartermaster Research and Development Command Technical Report.', 'description' => 'Age estimation by scoring epiphyseal closures', 'uses_feature_score' => true, 'uses_composite_score' => false,'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt, 'help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/methods/#mckern-tw-stewart-td-1957');
//        (!$method->exists) ? $method->fill($data)->save() : $method->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name', '=', 'Cervical vertebra 2')->first()->id;
		$method = Method::firstOrNew(['sb_id' => $sb_id, 'name' =>'McKern and Stewart 1957', 'submethod' => '']);
		$data = array('sb_id' => $sb_id, 'name' => 'McKern and Stewart 1957', 'submethod' => '', 'type' => 'Age', 'reference' => 'Skeletal Age Changes in Young American Males.  Quartermaster Research and Development Command Technical Report.', 'description' => 'Age estimation by scoring epiphyseal closures', 'uses_feature_score' => true, 'uses_composite_score' => false,'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt, 'help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/methods/#mckern-tw-stewart-td-1957');
        (!$method->exists) ? $method->fill($data)->save() : $method->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name', '=', 'Cervical vertebra 3')->first()->id;
		$method = Method::firstOrNew(['sb_id' => $sb_id, 'name' =>'McKern and Stewart 1957', 'submethod' => '']);
		$data = array('sb_id' => $sb_id, 'name' => 'McKern and Stewart 1957', 'submethod' => '', 'type' => 'Age', 'reference' => 'Skeletal Age Changes in Young American Males.  Quartermaster Research and Development Command Technical Report.', 'description' => 'Age estimation by scoring epiphyseal closures', 'uses_feature_score' => true, 'uses_composite_score' => false,'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt, 'help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/methods/#mckern-tw-stewart-td-1957');
        (!$method->exists) ? $method->fill($data)->save() : $method->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name', '=', 'Cervical vertebra 4')->first()->id;
		$method = Method::firstOrNew(['sb_id' => $sb_id, 'name' =>'McKern and Stewart 1957', 'submethod' => '']);
		$data = array('sb_id' => $sb_id, 'name' => 'McKern and Stewart 1957', 'submethod' => '', 'type' => 'Age', 'reference' => 'Skeletal Age Changes in Young American Males.  Quartermaster Research and Development Command Technical Report.', 'description' => 'Age estimation by scoring epiphyseal closures', 'uses_feature_score' => true, 'uses_composite_score' => false,'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt, 'help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/methods/#mckern-tw-stewart-td-1957');
        (!$method->exists) ? $method->fill($data)->save() : $method->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name', '=', 'Cervical vertebra 5')->first()->id;
		$method = Method::firstOrNew(['sb_id' => $sb_id, 'name' =>'McKern and Stewart 1957', 'submethod' => '']);
		$data = array('sb_id' => $sb_id, 'name' => 'McKern and Stewart 1957', 'submethod' => '', 'type' => 'Age', 'reference' => 'Skeletal Age Changes in Young American Males.  Quartermaster Research and Development Command Technical Report.', 'description' => 'Age estimation by scoring epiphyseal closures', 'uses_feature_score' => true, 'uses_composite_score' => false,'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt, 'help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/methods/#mckern-tw-stewart-td-1957');
        (!$method->exists) ? $method->fill($data)->save() : $method->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name', '=', 'Cervical vertebra 6')->first()->id;
		$method = Method::firstOrNew(['sb_id' => $sb_id, 'name' =>'McKern and Stewart 1957', 'submethod' => '']);
		$data = array('sb_id' => $sb_id, 'name' => 'McKern and Stewart 1957', 'submethod' => '', 'type' => 'Age', 'reference' => 'Skeletal Age Changes in Young American Males.  Quartermaster Research and Development Command Technical Report.', 'description' => 'Age estimation by scoring epiphyseal closures', 'uses_feature_score' => true, 'uses_composite_score' => false,'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt, 'help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/methods/#mckern-tw-stewart-td-1957');
        (!$method->exists) ? $method->fill($data)->save() : $method->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name', '=', 'Cervical vertebra 6/7')->first()->id;
		$method = Method::firstOrNew(['sb_id' => $sb_id, 'name' =>'McKern and Stewart 1957', 'submethod' => '']);
		$data = array('sb_id' => $sb_id, 'name' => 'McKern and Stewart 1957', 'submethod' => '', 'type' => 'Age', 'reference' => 'Skeletal Age Changes in Young American Males.  Quartermaster Research and Development Command Technical Report.', 'description' => 'Age estimation by scoring epiphyseal closures', 'uses_feature_score' => true, 'uses_composite_score' => false,'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt, 'help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/methods/#mckern-tw-stewart-td-1957');
        (!$method->exists) ? $method->fill($data)->save() : $method->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name', '=', 'Cervical vertebra 7')->first()->id;
		$method = Method::firstOrNew(['sb_id' => $sb_id, 'name' =>'McKern and Stewart 1957', 'submethod' => '']);
		$data = array('sb_id' => $sb_id, 'name' => 'McKern and Stewart 1957', 'submethod' => '', 'type' => 'Age', 'reference' => 'Skeletal Age Changes in Young American Males.  Quartermaster Research and Development Command Technical Report.', 'description' => 'Age estimation by scoring epiphyseal closures', 'uses_feature_score' => true, 'uses_composite_score' => false,'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt, 'help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/methods/#mckern-tw-stewart-td-1957');
        (!$method->exists) ? $method->fill($data)->save() : $method->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name', '=', 'Clavicle')->first()->id;
		$method = Method::firstOrNew(['sb_id' => $sb_id, 'name' =>'McKern and Stewart 1957', 'submethod' => '']);
		$data = array('sb_id' => $sb_id, 'name' => 'McKern and Stewart 1957', 'submethod' => '', 'type' => 'Age', 'reference' => 'Skeletal Age Changes in Young American Males.  Quartermaster Research and Development Command Technical Report.', 'description' => 'Age estimation by scoring epiphyseal closures', 'uses_feature_score' => true, 'uses_composite_score' => false,'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt, 'help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/methods/#mckern-tw-stewart-td-1957');
        (!$method->exists) ? $method->fill($data)->save() : $method->fill(array_except($data, ['created_at']))->save();

//        $sb_id = SkeletalBone::where('name', '=', 'Cranium')->first()->id;
//		$method = Method::firstOrNew(['sb_id' => $sb_id, 'name' =>'McKern and Stewart 1957', 'submethod' => '']);
//		$data = array('sb_id' => $sb_id, 'name' => 'McKern and Stewart 1957', 'submethod' => '', 'type' => 'Age', 'reference' => 'Skeletal Age Changes in Young American Males.  Quartermaster Research and Development Command Technical Report.', 'description' => 'Age estimation by scoring epiphyseal closures', 'uses_feature_score' => true, 'uses_composite_score' => false,'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt, 'help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/methods/#mckern-tw-stewart-td-1957');
//        (!$method->exists) ? $method->fill($data)->save() : $method->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name', '=', 'Extra vertebra')->first()->id;
		$method = Method::firstOrNew(['sb_id' => $sb_id, 'name' =>'McKern and Stewart 1957', 'submethod' => '']);
		$data = array('sb_id' => $sb_id, 'name' => 'McKern and Stewart 1957', 'submethod' => '', 'type' => 'Age', 'reference' => 'Skeletal Age Changes in Young American Males.  Quartermaster Research and Development Command Technical Report.', 'description' => 'Age estimation by scoring epiphyseal closures', 'uses_feature_score' => true, 'uses_composite_score' => false,'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt, 'help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/methods/#mckern-tw-stewart-td-1957');
        (!$method->exists) ? $method->fill($data)->save() : $method->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name', '=', 'Femur')->first()->id;
		$method = Method::firstOrNew(['sb_id' => $sb_id, 'name' =>'McKern and Stewart 1957', 'submethod' => '']);
		$data = array('sb_id' => $sb_id, 'name' => 'McKern and Stewart 1957', 'submethod' => '', 'type' => 'Age', 'reference' => 'Skeletal Age Changes in Young American Males.  Quartermaster Research and Development Command Technical Report.', 'description' => 'Age estimation by scoring epiphyseal closures', 'uses_feature_score' => true, 'uses_composite_score' => false,'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt, 'help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/methods/#mckern-tw-stewart-td-1957');
        (!$method->exists) ? $method->fill($data)->save() : $method->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name', '=', 'Fibula')->first()->id;
		$method = Method::firstOrNew(['sb_id' => $sb_id, 'name' =>'McKern and Stewart 1957', 'submethod' => '']);
		$data = array('sb_id' => $sb_id, 'name' => 'McKern and Stewart 1957', 'submethod' => '', 'type' => 'Age', 'reference' => 'Skeletal Age Changes in Young American Males.  Quartermaster Research and Development Command Technical Report.', 'description' => 'Age estimation by scoring epiphyseal closures', 'uses_feature_score' => true, 'uses_composite_score' => false,'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt, 'help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/methods/#mckern-tw-stewart-td-1957');
        (!$method->exists) ? $method->fill($data)->save() : $method->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name', '=', 'Humerus')->first()->id;
		$method = Method::firstOrNew(['sb_id' => $sb_id, 'name' =>'McKern and Stewart 1957', 'submethod' => '']);
		$data = array('sb_id' => $sb_id, 'name' => 'McKern and Stewart 1957', 'submethod' => '', 'type' => 'Age', 'reference' => 'Skeletal Age Changes in Young American Males.  Quartermaster Research and Development Command Technical Report.', 'description' => 'Age estimation by scoring epiphyseal closures', 'uses_feature_score' => true, 'uses_composite_score' => false,'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt, 'help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/methods/#mckern-tw-stewart-td-1957');
        (!$method->exists) ? $method->fill($data)->save() : $method->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name', '=', 'Lumbar vertebra 1')->first()->id;
		$method = Method::firstOrNew(['sb_id' => $sb_id, 'name' =>'McKern and Stewart 1957', 'submethod' => '']);
		$data = array('sb_id' => $sb_id, 'name' => 'McKern and Stewart 1957', 'submethod' => '', 'type' => 'Age', 'reference' => 'Skeletal Age Changes in Young American Males.  Quartermaster Research and Development Command Technical Report.', 'description' => 'Age estimation by scoring epiphyseal closures', 'uses_feature_score' => true, 'uses_composite_score' => false,'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt, 'help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/methods/#mckern-tw-stewart-td-1957');
        (!$method->exists) ? $method->fill($data)->save() : $method->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name', '=', 'Lumbar vertebra 1/2')->first()->id;
		$method = Method::firstOrNew(['sb_id' => $sb_id, 'name' =>'McKern and Stewart 1957', 'submethod' => '']);
		$data = array('sb_id' => $sb_id, 'name' => 'McKern and Stewart 1957', 'submethod' => '', 'type' => 'Age', 'reference' => 'Skeletal Age Changes in Young American Males.  Quartermaster Research and Development Command Technical Report.', 'description' => 'Age estimation by scoring epiphyseal closures', 'uses_feature_score' => true, 'uses_composite_score' => false,'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt, 'help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/methods/#mckern-tw-stewart-td-1957');
        (!$method->exists) ? $method->fill($data)->save() : $method->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name', '=', 'Lumbar vertebra 2')->first()->id;
		$method = Method::firstOrNew(['sb_id' => $sb_id, 'name' =>'McKern and Stewart 1957', 'submethod' => '']);
		$data = array('sb_id' => $sb_id, 'name' => 'McKern and Stewart 1957', 'submethod' => '', 'type' => 'Age', 'reference' => 'Skeletal Age Changes in Young American Males.  Quartermaster Research and Development Command Technical Report.', 'description' => 'Age estimation by scoring epiphyseal closures', 'uses_feature_score' => true, 'uses_composite_score' => false,'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt, 'help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/methods/#mckern-tw-stewart-td-1957');
        (!$method->exists) ? $method->fill($data)->save() : $method->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name', '=', 'Lumbar vertebra 2/3')->first()->id;
		$method = Method::firstOrNew(['sb_id' => $sb_id, 'name' =>'McKern and Stewart 1957', 'submethod' => '']);
		$data = array('sb_id' => $sb_id, 'name' => 'McKern and Stewart 1957', 'submethod' => '', 'type' => 'Age', 'reference' => 'Skeletal Age Changes in Young American Males.  Quartermaster Research and Development Command Technical Report.', 'description' => 'Age estimation by scoring epiphyseal closures', 'uses_feature_score' => true, 'uses_composite_score' => false,'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt, 'help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/methods/#mckern-tw-stewart-td-1957');
        (!$method->exists) ? $method->fill($data)->save() : $method->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name', '=', 'Lumbar vertebra 3')->first()->id;
		$method = Method::firstOrNew(['sb_id' => $sb_id, 'name' =>'McKern and Stewart 1957', 'submethod' => '']);
		$data = array('sb_id' => $sb_id, 'name' => 'McKern and Stewart 1957', 'submethod' => '', 'type' => 'Age', 'reference' => 'Skeletal Age Changes in Young American Males.  Quartermaster Research and Development Command Technical Report.', 'description' => 'Age estimation by scoring epiphyseal closures', 'uses_feature_score' => true, 'uses_composite_score' => false,'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt, 'help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/methods/#mckern-tw-stewart-td-1957');
        (!$method->exists) ? $method->fill($data)->save() : $method->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name', '=', 'Lumbar vertebra 3/4')->first()->id;
		$method = Method::firstOrNew(['sb_id' => $sb_id, 'name' =>'McKern and Stewart 1957', 'submethod' => '']);
		$data = array('sb_id' => $sb_id, 'name' => 'McKern and Stewart 1957', 'submethod' => '', 'type' => 'Age', 'reference' => 'Skeletal Age Changes in Young American Males.  Quartermaster Research and Development Command Technical Report.', 'description' => 'Age estimation by scoring epiphyseal closures', 'uses_feature_score' => true, 'uses_composite_score' => false,'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt, 'help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/methods/#mckern-tw-stewart-td-1957');
        (!$method->exists) ? $method->fill($data)->save() : $method->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name', '=', 'Lumbar vertebra 4')->first()->id;
		$method = Method::firstOrNew(['sb_id' => $sb_id, 'name' =>'McKern and Stewart 1957', 'submethod' => '']);
		$data = array('sb_id' => $sb_id, 'name' => 'McKern and Stewart 1957', 'submethod' => '', 'type' => 'Age', 'reference' => 'Skeletal Age Changes in Young American Males.  Quartermaster Research and Development Command Technical Report.', 'description' => 'Age estimation by scoring epiphyseal closures', 'uses_feature_score' => true, 'uses_composite_score' => false,'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt, 'help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/methods/#mckern-tw-stewart-td-1957');
        (!$method->exists) ? $method->fill($data)->save() : $method->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name', '=', 'Lumbar vertebra 4/5')->first()->id;
		$method = Method::firstOrNew(['sb_id' => $sb_id, 'name' =>'McKern and Stewart 1957', 'submethod' => '']);
		$data = array('sb_id' => $sb_id, 'name' => 'McKern and Stewart 1957', 'submethod' => '', 'type' => 'Age', 'reference' => 'Skeletal Age Changes in Young American Males.  Quartermaster Research and Development Command Technical Report.', 'description' => 'Age estimation by scoring epiphyseal closures', 'uses_feature_score' => true, 'uses_composite_score' => false,'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt, 'help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/methods/#mckern-tw-stewart-td-1957');
        (!$method->exists) ? $method->fill($data)->save() : $method->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name', '=', 'Lumbar vertebra 5')->first()->id;
		$method = Method::firstOrNew(['sb_id' => $sb_id, 'name' =>'McKern and Stewart 1957', 'submethod' => '']);
		$data = array('sb_id' => $sb_id, 'name' => 'McKern and Stewart 1957', 'submethod' => '', 'type' => 'Age', 'reference' => 'Skeletal Age Changes in Young American Males.  Quartermaster Research and Development Command Technical Report.', 'description' => 'Age estimation by scoring epiphyseal closures', 'uses_feature_score' => true, 'uses_composite_score' => false,'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt, 'help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/methods/#mckern-tw-stewart-td-1957');
        (!$method->exists) ? $method->fill($data)->save() : $method->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name', '=', 'Os coxa')->first()->id;
		$method = Method::firstOrNew(['sb_id' => $sb_id, 'name' =>'McKern and Stewart 1957', 'submethod' => 'Epiphyseal fusion']);
		$data = array('sb_id' => $sb_id, 'name' => 'McKern and Stewart 1957', 'submethod' => 'Epiphyseal fusion', 'type' => 'Age', 'reference' => 'Skeletal Age Changes in Young American Males.  Quartermaster Research and Development Command Technical Report.', 'description' => 'Age estimation by scoring epiphyseal closures', 'uses_feature_score' => true, 'uses_composite_score' => false,'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt, 'help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/methods/#mckern-tw-stewart-td-1957');
        (!$method->exists) ? $method->fill($data)->save() : $method->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name', '=', 'Os coxa')->first()->id;
        $method = Method::firstOrNew(['sb_id' => $sb_id, 'name' =>'McKern and Stewart 1957', 'submethod' => 'Pubic symphysis']);
        $data = array('sb_id' => $sb_id, 'name' => 'McKern and Stewart 1957', 'submethod' => 'Pubic symphysis', 'type' => 'Age', 'reference' => 'Skeletal Age Changes in Young American Males.  Quartermaster Research and Development Command Technical Report.', 'description' => 'Age estimation by scoring morphological features of the pubic symphysis', 'uses_feature_score' => true, 'uses_composite_score' => true,'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt, 'help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/methods/#mckern-tw-stewart-td-1957');
        (!$method->exists) ? $method->fill($data)->save() : $method->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name', '=', 'Radius')->first()->id;
		$method = Method::firstOrNew(['sb_id' => $sb_id, 'name' =>'McKern and Stewart 1957', 'submethod' => '']);
		$data = array('sb_id' => $sb_id, 'name' => 'McKern and Stewart 1957', 'submethod' => '', 'type' => 'Age', 'reference' => 'Skeletal Age Changes in Young American Males.  Quartermaster Research and Development Command Technical Report.', 'description' => 'Age estimation by scoring epiphyseal closures', 'uses_feature_score' => true, 'uses_composite_score' => false,'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt, 'help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/methods/#mckern-tw-stewart-td-1957');
        (!$method->exists) ? $method->fill($data)->save() : $method->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name', '=', 'Unseriated rib')->first()->id;
		$method = Method::firstOrNew(['sb_id' => $sb_id, 'name' =>'McKern and Stewart 1957', 'submethod' => '']);
		$data = array('sb_id' => $sb_id, 'name' => 'McKern and Stewart 1957', 'submethod' => '', 'type' => 'Age', 'reference' => 'Skeletal Age Changes in Young American Males.  Quartermaster Research and Development Command Technical Report.', 'description' => 'Age estimation by scoring epiphyseal closures', 'uses_feature_score' => true, 'uses_composite_score' => false,'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt, 'help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/methods/#mckern-tw-stewart-td-1957');
        (!$method->exists) ? $method->fill($data)->save() : $method->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name', '=', 'Rib 1')->first()->id;
		$method = Method::firstOrNew(['sb_id' => $sb_id, 'name' =>'McKern and Stewart 1957', 'submethod' => '']);
		$data = array('sb_id' => $sb_id, 'name' => 'McKern and Stewart 1957', 'submethod' => '', 'type' => 'Age', 'reference' => 'Skeletal Age Changes in Young American Males.  Quartermaster Research and Development Command Technical Report.', 'description' => 'Age estimation by scoring epiphyseal closures', 'uses_feature_score' => true, 'uses_composite_score' => false,'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt, 'help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/methods/#mckern-tw-stewart-td-1957');
        (!$method->exists) ? $method->fill($data)->save() : $method->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name', '=', 'Rib 10')->first()->id;
		$method = Method::firstOrNew(['sb_id' => $sb_id, 'name' =>'McKern and Stewart 1957', 'submethod' => '']);
		$data = array('sb_id' => $sb_id, 'name' => 'McKern and Stewart 1957', 'submethod' => '', 'type' => 'Age', 'reference' => 'Skeletal Age Changes in Young American Males.  Quartermaster Research and Development Command Technical Report.', 'description' => 'Age estimation by scoring epiphyseal closures', 'uses_feature_score' => true, 'uses_composite_score' => false,'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt, 'help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/methods/#mckern-tw-stewart-td-1957');
        (!$method->exists) ? $method->fill($data)->save() : $method->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name', '=', 'Rib 10/11')->first()->id;
		$method = Method::firstOrNew(['sb_id' => $sb_id, 'name' =>'McKern and Stewart 1957', 'submethod' => '']);
		$data = array('sb_id' => $sb_id, 'name' => 'McKern and Stewart 1957', 'submethod' => '', 'type' => 'Age', 'reference' => 'Skeletal Age Changes in Young American Males.  Quartermaster Research and Development Command Technical Report.', 'description' => 'Age estimation by scoring epiphyseal closures', 'uses_feature_score' => true, 'uses_composite_score' => false,'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt, 'help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/methods/#mckern-tw-stewart-td-1957');
        (!$method->exists) ? $method->fill($data)->save() : $method->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name', '=', 'Rib 11')->first()->id;
		$method = Method::firstOrNew(['sb_id' => $sb_id, 'name' =>'McKern and Stewart 1957', 'submethod' => '']);
		$data = array('sb_id' => $sb_id, 'name' => 'McKern and Stewart 1957', 'submethod' => '', 'type' => 'Age', 'reference' => 'Skeletal Age Changes in Young American Males.  Quartermaster Research and Development Command Technical Report.', 'description' => 'Age estimation by scoring epiphyseal closures', 'uses_feature_score' => true, 'uses_composite_score' => false,'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt, 'help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/methods/#mckern-tw-stewart-td-1957');
        (!$method->exists) ? $method->fill($data)->save() : $method->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name', '=', 'Rib 11/12')->first()->id;
		$method = Method::firstOrNew(['sb_id' => $sb_id, 'name' =>'McKern and Stewart 1957', 'submethod' => '']);
		$data = array('sb_id' => $sb_id, 'name' => 'McKern and Stewart 1957', 'submethod' => '', 'type' => 'Age', 'reference' => 'Skeletal Age Changes in Young American Males.  Quartermaster Research and Development Command Technical Report.', 'description' => 'Age estimation by scoring epiphyseal closures', 'uses_feature_score' => true, 'uses_composite_score' => false,'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt, 'help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/methods/#mckern-tw-stewart-td-1957');
        (!$method->exists) ? $method->fill($data)->save() : $method->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name', '=', 'Rib 12')->first()->id;
		$method = Method::firstOrNew(['sb_id' => $sb_id, 'name' =>'McKern and Stewart 1957', 'submethod' => '']);
		$data = array('sb_id' => $sb_id, 'name' => 'McKern and Stewart 1957', 'submethod' => '', 'type' => 'Age', 'reference' => 'Skeletal Age Changes in Young American Males.  Quartermaster Research and Development Command Technical Report.', 'description' => 'Age estimation by scoring epiphyseal closures', 'uses_feature_score' => true, 'uses_composite_score' => false,'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt, 'help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/methods/#mckern-tw-stewart-td-1957');
        (!$method->exists) ? $method->fill($data)->save() : $method->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name', '=', 'Rib 2')->first()->id;
		$method = Method::firstOrNew(['sb_id' => $sb_id, 'name' =>'McKern and Stewart 1957', 'submethod' => '']);
		$data = array('sb_id' => $sb_id, 'name' => 'McKern and Stewart 1957', 'submethod' => '', 'type' => 'Age', 'reference' => 'Skeletal Age Changes in Young American Males.  Quartermaster Research and Development Command Technical Report.', 'description' => 'Age estimation by scoring epiphyseal closures', 'uses_feature_score' => true, 'uses_composite_score' => false,'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt, 'help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/methods/#mckern-tw-stewart-td-1957');
        (!$method->exists) ? $method->fill($data)->save() : $method->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name', '=', 'Rib 2/3')->first()->id;
		$method = Method::firstOrNew(['sb_id' => $sb_id, 'name' =>'McKern and Stewart 1957', 'submethod' => '']);
		$data = array('sb_id' => $sb_id, 'name' => 'McKern and Stewart 1957', 'submethod' => '', 'type' => 'Age', 'reference' => 'Skeletal Age Changes in Young American Males.  Quartermaster Research and Development Command Technical Report.', 'description' => 'Age estimation by scoring epiphyseal closures', 'uses_feature_score' => true, 'uses_composite_score' => false,'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt, 'help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/methods/#mckern-tw-stewart-td-1957');
        (!$method->exists) ? $method->fill($data)->save() : $method->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name', '=', 'Rib 3')->first()->id;
		$method = Method::firstOrNew(['sb_id' => $sb_id, 'name' =>'McKern and Stewart 1957', 'submethod' => '']);
		$data = array('sb_id' => $sb_id, 'name' => 'McKern and Stewart 1957', 'submethod' => '', 'type' => 'Age', 'reference' => 'Skeletal Age Changes in Young American Males.  Quartermaster Research and Development Command Technical Report.', 'description' => 'Age estimation by scoring epiphyseal closures', 'uses_feature_score' => true, 'uses_composite_score' => false,'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt, 'help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/methods/#mckern-tw-stewart-td-1957');
        (!$method->exists) ? $method->fill($data)->save() : $method->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name', '=', 'Rib 3/4')->first()->id;
		$method = Method::firstOrNew(['sb_id' => $sb_id, 'name' =>'McKern and Stewart 1957', 'submethod' => '']);
		$data = array('sb_id' => $sb_id, 'name' => 'McKern and Stewart 1957', 'submethod' => '', 'type' => 'Age', 'reference' => 'Skeletal Age Changes in Young American Males.  Quartermaster Research and Development Command Technical Report.', 'description' => 'Age estimation by scoring epiphyseal closures', 'uses_feature_score' => true, 'uses_composite_score' => false,'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt, 'help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/methods/#mckern-tw-stewart-td-1957');
        (!$method->exists) ? $method->fill($data)->save() : $method->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name', '=', 'Rib 4')->first()->id;
		$method = Method::firstOrNew(['sb_id' => $sb_id, 'name' =>'McKern and Stewart 1957', 'submethod' => '']);
		$data = array('sb_id' => $sb_id, 'name' => 'McKern and Stewart 1957', 'submethod' => '', 'type' => 'Age', 'reference' => 'Skeletal Age Changes in Young American Males.  Quartermaster Research and Development Command Technical Report.', 'description' => 'Age estimation by scoring epiphyseal closures', 'uses_feature_score' => true, 'uses_composite_score' => false,'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt, 'help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/methods/#mckern-tw-stewart-td-1957');
        (!$method->exists) ? $method->fill($data)->save() : $method->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name', '=', 'Rib 5')->first()->id;
		$method = Method::firstOrNew(['sb_id' => $sb_id, 'name' =>'McKern and Stewart 1957', 'submethod' => '']);
		$data = array('sb_id' => $sb_id, 'name' => 'McKern and Stewart 1957', 'submethod' => '', 'type' => 'Age', 'reference' => 'Skeletal Age Changes in Young American Males.  Quartermaster Research and Development Command Technical Report.', 'description' => 'Age estimation by scoring epiphyseal closures', 'uses_feature_score' => true, 'uses_composite_score' => false,'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt, 'help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/methods/#mckern-tw-stewart-td-1957');
        (!$method->exists) ? $method->fill($data)->save() : $method->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name', '=', 'Rib 6')->first()->id;
		$method = Method::firstOrNew(['sb_id' => $sb_id, 'name' =>'McKern and Stewart 1957', 'submethod' => '']);
		$data = array('sb_id' => $sb_id, 'name' => 'McKern and Stewart 1957', 'submethod' => '', 'type' => 'Age', 'reference' => 'Skeletal Age Changes in Young American Males.  Quartermaster Research and Development Command Technical Report.', 'description' => 'Age estimation by scoring epiphyseal closures', 'uses_feature_score' => true, 'uses_composite_score' => false,'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt, 'help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/methods/#mckern-tw-stewart-td-1957');
        (!$method->exists) ? $method->fill($data)->save() : $method->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name', '=', 'Rib 7')->first()->id;
		$method = Method::firstOrNew(['sb_id' => $sb_id, 'name' =>'McKern and Stewart 1957', 'submethod' => '']);
		$data = array('sb_id' => $sb_id, 'name' => 'McKern and Stewart 1957', 'submethod' => '', 'type' => 'Age', 'reference' => 'Skeletal Age Changes in Young American Males.  Quartermaster Research and Development Command Technical Report.', 'description' => 'Age estimation by scoring epiphyseal closures', 'uses_feature_score' => true, 'uses_composite_score' => false,'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt, 'help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/methods/#mckern-tw-stewart-td-1957');
        (!$method->exists) ? $method->fill($data)->save() : $method->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name', '=', 'Rib 8')->first()->id;
		$method = Method::firstOrNew(['sb_id' => $sb_id, 'name' =>'McKern and Stewart 1957', 'submethod' => '']);
		$data = array('sb_id' => $sb_id, 'name' => 'McKern and Stewart 1957', 'submethod' => '', 'type' => 'Age', 'reference' => 'Skeletal Age Changes in Young American Males.  Quartermaster Research and Development Command Technical Report.', 'description' => 'Age estimation by scoring epiphyseal closures', 'uses_feature_score' => true, 'uses_composite_score' => false,'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt, 'help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/methods/#mckern-tw-stewart-td-1957');
        (!$method->exists) ? $method->fill($data)->save() : $method->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name', '=', 'Rib 9')->first()->id;
		$method = Method::firstOrNew(['sb_id' => $sb_id, 'name' =>'McKern and Stewart 1957', 'submethod' => '']);
		$data = array('sb_id' => $sb_id, 'name' => 'McKern and Stewart 1957', 'submethod' => '', 'type' => 'Age', 'reference' => 'Skeletal Age Changes in Young American Males.  Quartermaster Research and Development Command Technical Report.', 'description' => 'Age estimation by scoring epiphyseal closures', 'uses_feature_score' => true, 'uses_composite_score' => false,'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt, 'help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/methods/#mckern-tw-stewart-td-1957');
        (!$method->exists) ? $method->fill($data)->save() : $method->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name', '=', 'Sacral vertebra 1')->first()->id;
		$method = Method::firstOrNew(['sb_id' => $sb_id, 'name' =>'McKern and Stewart 1957', 'submethod' => '']);
		$data = array('sb_id' => $sb_id, 'name' => 'McKern and Stewart 1957', 'submethod' => '', 'type' => 'Age', 'reference' => 'Skeletal Age Changes in Young American Males.  Quartermaster Research and Development Command Technical Report.', 'description' => 'Age estimation by scoring epiphyseal closures', 'uses_feature_score' => true, 'uses_composite_score' => false,'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt, 'help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/methods/#mckern-tw-stewart-td-1957');
        (!$method->exists) ? $method->fill($data)->save() : $method->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name', '=', 'Sacral vertebra 2')->first()->id;
		$method = Method::firstOrNew(['sb_id' => $sb_id, 'name' =>'McKern and Stewart 1957', 'submethod' => '']);
		$data = array('sb_id' => $sb_id, 'name' => 'McKern and Stewart 1957', 'submethod' => '', 'type' => 'Age', 'reference' => 'Skeletal Age Changes in Young American Males.  Quartermaster Research and Development Command Technical Report.', 'description' => 'Age estimation by scoring epiphyseal closures', 'uses_feature_score' => true, 'uses_composite_score' => false,'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt, 'help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/methods/#mckern-tw-stewart-td-1957');
        (!$method->exists) ? $method->fill($data)->save() : $method->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name', '=', 'Sacral vertebra 3')->first()->id;
		$method = Method::firstOrNew(['sb_id' => $sb_id, 'name' =>'McKern and Stewart 1957', 'submethod' => '']);
		$data = array('sb_id' => $sb_id, 'name' => 'McKern and Stewart 1957', 'submethod' => '', 'type' => 'Age', 'reference' => 'Skeletal Age Changes in Young American Males.  Quartermaster Research and Development Command Technical Report.', 'description' => 'Age estimation by scoring epiphyseal closures', 'uses_feature_score' => true, 'uses_composite_score' => false,'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt, 'help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/methods/#mckern-tw-stewart-td-1957');
        (!$method->exists) ? $method->fill($data)->save() : $method->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name', '=', 'Sacral vertebra 4')->first()->id;
		$method = Method::firstOrNew(['sb_id' => $sb_id, 'name' =>'McKern and Stewart 1957', 'submethod' => '']);
		$data = array('sb_id' => $sb_id, 'name' => 'McKern and Stewart 1957', 'submethod' => '', 'type' => 'Age', 'reference' => 'Skeletal Age Changes in Young American Males.  Quartermaster Research and Development Command Technical Report.', 'description' => 'Age estimation by scoring epiphyseal closures', 'uses_feature_score' => true, 'uses_composite_score' => false,'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt, 'help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/methods/#mckern-tw-stewart-td-1957');
        (!$method->exists) ? $method->fill($data)->save() : $method->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name', '=', 'Sacral vertebra 5')->first()->id;
		$method = Method::firstOrNew(['sb_id' => $sb_id, 'name' =>'McKern and Stewart 1957', 'submethod' => '']);
		$data = array('sb_id' => $sb_id, 'name' => 'McKern and Stewart 1957', 'submethod' => '', 'type' => 'Age', 'reference' => 'Skeletal Age Changes in Young American Males.  Quartermaster Research and Development Command Technical Report.', 'description' => 'Age estimation by scoring epiphyseal closures', 'uses_feature_score' => true, 'uses_composite_score' => false,'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt, 'help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/methods/#mckern-tw-stewart-td-1957');
        (!$method->exists) ? $method->fill($data)->save() : $method->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name', '=', 'Sacrum')->first()->id;
		$method = Method::firstOrNew(['sb_id' => $sb_id, 'name' =>'McKern and Stewart 1957', 'submethod' => '']);
		$data = array('sb_id' => $sb_id, 'name' => 'McKern and Stewart 1957', 'submethod' => '', 'type' => 'Age', 'reference' => 'Skeletal Age Changes in Young American Males.  Quartermaster Research and Development Command Technical Report.', 'description' => 'Age estimation by scoring epiphyseal closures', 'uses_feature_score' => true, 'uses_composite_score' => false,'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt, 'help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/methods/#mckern-tw-stewart-td-1957');
        (!$method->exists) ? $method->fill($data)->save() : $method->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name', '=', 'Scapula')->first()->id;
		$method = Method::firstOrNew(['sb_id' => $sb_id, 'name' =>'McKern and Stewart 1957', 'submethod' => '']);
		$data = array('sb_id' => $sb_id, 'name' => 'McKern and Stewart 1957', 'submethod' => '', 'type' => 'Age', 'reference' => 'Skeletal Age Changes in Young American Males.  Quartermaster Research and Development Command Technical Report.', 'description' => 'Age estimation by scoring epiphyseal closures', 'uses_feature_score' => true, 'uses_composite_score' => false,'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt, 'help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/methods/#mckern-tw-stewart-td-1957');
        (!$method->exists) ? $method->fill($data)->save() : $method->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name', '=', 'Sternal body')->first()->id;
		$method = Method::firstOrNew(['sb_id' => $sb_id, 'name' =>'McKern and Stewart 1957', 'submethod' => '']);
		$data = array('sb_id' => $sb_id, 'name' => 'McKern and Stewart 1957', 'submethod' => '', 'type' => 'Age', 'reference' => 'Skeletal Age Changes in Young American Males.  Quartermaster Research and Development Command Technical Report.', 'description' => 'Age estimation by scoring epiphyseal closures', 'uses_feature_score' => true, 'uses_composite_score' => false,'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt, 'help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/methods/#mckern-tw-stewart-td-1957');
        (!$method->exists) ? $method->fill($data)->save() : $method->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name', '=', 'Sternum')->first()->id;
		$method = Method::firstOrNew(['sb_id' => $sb_id, 'name' =>'McKern and Stewart 1957', 'submethod' => '']);
		$data = array('sb_id' => $sb_id, 'name' => 'McKern and Stewart 1957', 'submethod' => '', 'type' => 'Age', 'reference' => 'Skeletal Age Changes in Young American Males.  Quartermaster Research and Development Command Technical Report.', 'description' => 'Age estimation by scoring epiphyseal closures', 'uses_feature_score' => true, 'uses_composite_score' => false,'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt, 'help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/methods/#mckern-tw-stewart-td-1957');
        (!$method->exists) ? $method->fill($data)->save() : $method->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name', '=', 'Thoracic vertebra 1')->first()->id;
		$method = Method::firstOrNew(['sb_id' => $sb_id, 'name' =>'McKern and Stewart 1957', 'submethod' => '']);
		$data = array('sb_id' => $sb_id, 'name' => 'McKern and Stewart 1957', 'submethod' => '', 'type' => 'Age', 'reference' => 'Skeletal Age Changes in Young American Males.  Quartermaster Research and Development Command Technical Report.', 'description' => 'Age estimation by scoring epiphyseal closures', 'uses_feature_score' => true, 'uses_composite_score' => false,'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt, 'help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/methods/#mckern-tw-stewart-td-1957');
        (!$method->exists) ? $method->fill($data)->save() : $method->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name', '=', 'Thoracic vertebra 1/2')->first()->id;
		$method = Method::firstOrNew(['sb_id' => $sb_id, 'name' =>'McKern and Stewart 1957', 'submethod' => '']);
		$data = array('sb_id' => $sb_id, 'name' => 'McKern and Stewart 1957', 'submethod' => '', 'type' => 'Age', 'reference' => 'Skeletal Age Changes in Young American Males.  Quartermaster Research and Development Command Technical Report.', 'description' => 'Age estimation by scoring epiphyseal closures', 'uses_feature_score' => true, 'uses_composite_score' => false,'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt, 'help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/methods/#mckern-tw-stewart-td-1957');
        (!$method->exists) ? $method->fill($data)->save() : $method->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name', '=', 'Thoracic vertebra 10')->first()->id;
		$method = Method::firstOrNew(['sb_id' => $sb_id, 'name' =>'McKern and Stewart 1957', 'submethod' => '']);
		$data = array('sb_id' => $sb_id, 'name' => 'McKern and Stewart 1957', 'submethod' => '', 'type' => 'Age', 'reference' => 'Skeletal Age Changes in Young American Males.  Quartermaster Research and Development Command Technical Report.', 'description' => 'Age estimation by scoring epiphyseal closures', 'uses_feature_score' => true, 'uses_composite_score' => false,'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt, 'help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/methods/#mckern-tw-stewart-td-1957');
        (!$method->exists) ? $method->fill($data)->save() : $method->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name', '=', 'Thoracic vertebra 10/11')->first()->id;
		$method = Method::firstOrNew(['sb_id' => $sb_id, 'name' =>'McKern and Stewart 1957', 'submethod' => '']);
		$data = array('sb_id' => $sb_id, 'name' => 'McKern and Stewart 1957', 'submethod' => '', 'type' => 'Age', 'reference' => 'Skeletal Age Changes in Young American Males.  Quartermaster Research and Development Command Technical Report.', 'description' => 'Age estimation by scoring epiphyseal closures', 'uses_feature_score' => true, 'uses_composite_score' => false,'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt, 'help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/methods/#mckern-tw-stewart-td-1957');
        (!$method->exists) ? $method->fill($data)->save() : $method->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name', '=', 'Thoracic vertebra 10/11/12')->first()->id;
		$method = Method::firstOrNew(['sb_id' => $sb_id, 'name' =>'McKern and Stewart 1957', 'submethod' => '']);
		$data = array('sb_id' => $sb_id, 'name' => 'McKern and Stewart 1957', 'submethod' => '', 'type' => 'Age', 'reference' => 'Skeletal Age Changes in Young American Males.  Quartermaster Research and Development Command Technical Report.', 'description' => 'Age estimation by scoring epiphyseal closures', 'uses_feature_score' => true, 'uses_composite_score' => false,'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt, 'help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/methods/#mckern-tw-stewart-td-1957');
        (!$method->exists) ? $method->fill($data)->save() : $method->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name', '=', 'Thoracic vertebra 11')->first()->id;
		$method = Method::firstOrNew(['sb_id' => $sb_id, 'name' =>'McKern and Stewart 1957', 'submethod' => '']);
		$data = array('sb_id' => $sb_id, 'name' => 'McKern and Stewart 1957', 'submethod' => '', 'type' => 'Age', 'reference' => 'Skeletal Age Changes in Young American Males.  Quartermaster Research and Development Command Technical Report.', 'description' => 'Age estimation by scoring epiphyseal closures', 'uses_feature_score' => true, 'uses_composite_score' => false,'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt, 'help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/methods/#mckern-tw-stewart-td-1957');
        (!$method->exists) ? $method->fill($data)->save() : $method->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name', '=', 'Thoracic vertebra 11/12')->first()->id;
		$method = Method::firstOrNew(['sb_id' => $sb_id, 'name' =>'McKern and Stewart 1957', 'submethod' => '']);
		$data = array('sb_id' => $sb_id, 'name' => 'McKern and Stewart 1957', 'submethod' => '', 'type' => 'Age', 'reference' => 'Skeletal Age Changes in Young American Males.  Quartermaster Research and Development Command Technical Report.', 'description' => 'Age estimation by scoring epiphyseal closures', 'uses_feature_score' => true, 'uses_composite_score' => false,'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt, 'help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/methods/#mckern-tw-stewart-td-1957');
        (!$method->exists) ? $method->fill($data)->save() : $method->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name', '=', 'Thoracic vertebra 12')->first()->id;
		$method = Method::firstOrNew(['sb_id' => $sb_id, 'name' =>'McKern and Stewart 1957', 'submethod' => '']);
		$data = array('sb_id' => $sb_id, 'name' => 'McKern and Stewart 1957', 'submethod' => '', 'type' => 'Age', 'reference' => 'Skeletal Age Changes in Young American Males.  Quartermaster Research and Development Command Technical Report.', 'description' => 'Age estimation by scoring epiphyseal closures', 'uses_feature_score' => true, 'uses_composite_score' => false,'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt, 'help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/methods/#mckern-tw-stewart-td-1957');
        (!$method->exists) ? $method->fill($data)->save() : $method->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name', '=', 'Thoracic vertebra 2')->first()->id;
		$method = Method::firstOrNew(['sb_id' => $sb_id, 'name' =>'McKern and Stewart 1957', 'submethod' => '']);
		$data = array('sb_id' => $sb_id, 'name' => 'McKern and Stewart 1957', 'submethod' => '', 'type' => 'Age', 'reference' => 'Skeletal Age Changes in Young American Males.  Quartermaster Research and Development Command Technical Report.', 'description' => 'Age estimation by scoring epiphyseal closures', 'uses_feature_score' => true, 'uses_composite_score' => false,'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt, 'help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/methods/#mckern-tw-stewart-td-1957');
        (!$method->exists) ? $method->fill($data)->save() : $method->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name', '=', 'Thoracic vertebra 3')->first()->id;
		$method = Method::firstOrNew(['sb_id' => $sb_id, 'name' =>'McKern and Stewart 1957', 'submethod' => '']);
		$data = array('sb_id' => $sb_id, 'name' => 'McKern and Stewart 1957', 'submethod' => '', 'type' => 'Age', 'reference' => 'Skeletal Age Changes in Young American Males.  Quartermaster Research and Development Command Technical Report.', 'description' => 'Age estimation by scoring epiphyseal closures', 'uses_feature_score' => true, 'uses_composite_score' => false,'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt, 'help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/methods/#mckern-tw-stewart-td-1957');
        (!$method->exists) ? $method->fill($data)->save() : $method->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name', '=', 'Thoracic vertebra 4')->first()->id;
		$method = Method::firstOrNew(['sb_id' => $sb_id, 'name' =>'McKern and Stewart 1957', 'submethod' => '']);
		$data = array('sb_id' => $sb_id, 'name' => 'McKern and Stewart 1957', 'submethod' => '', 'type' => 'Age', 'reference' => 'Skeletal Age Changes in Young American Males.  Quartermaster Research and Development Command Technical Report.', 'description' => 'Age estimation by scoring epiphyseal closures', 'uses_feature_score' => true, 'uses_composite_score' => false,'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt, 'help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/methods/#mckern-tw-stewart-td-1957');
        (!$method->exists) ? $method->fill($data)->save() : $method->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name', '=', 'Thoracic vertebra 5')->first()->id;
		$method = Method::firstOrNew(['sb_id' => $sb_id, 'name' =>'McKern and Stewart 1957', 'submethod' => '']);
		$data = array('sb_id' => $sb_id, 'name' => 'McKern and Stewart 1957', 'submethod' => '', 'type' => 'Age', 'reference' => 'Skeletal Age Changes in Young American Males.  Quartermaster Research and Development Command Technical Report.', 'description' => 'Age estimation by scoring epiphyseal closures', 'uses_feature_score' => true, 'uses_composite_score' => false,'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt, 'help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/methods/#mckern-tw-stewart-td-1957');
        (!$method->exists) ? $method->fill($data)->save() : $method->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name', '=', 'Thoracic vertebra 6')->first()->id;
		$method = Method::firstOrNew(['sb_id' => $sb_id, 'name' =>'McKern and Stewart 1957', 'submethod' => '']);
		$data = array('sb_id' => $sb_id, 'name' => 'McKern and Stewart 1957', 'submethod' => '', 'type' => 'Age', 'reference' => 'Skeletal Age Changes in Young American Males.  Quartermaster Research and Development Command Technical Report.', 'description' => 'Age estimation by scoring epiphyseal closures', 'uses_feature_score' => true, 'uses_composite_score' => false,'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt, 'help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/methods/#mckern-tw-stewart-td-1957');
        (!$method->exists) ? $method->fill($data)->save() : $method->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name', '=', 'Thoracic vertebra 7')->first()->id;
		$method = Method::firstOrNew(['sb_id' => $sb_id, 'name' =>'McKern and Stewart 1957', 'submethod' => '']);
		$data = array('sb_id' => $sb_id, 'name' => 'McKern and Stewart 1957', 'submethod' => '', 'type' => 'Age', 'reference' => 'Skeletal Age Changes in Young American Males.  Quartermaster Research and Development Command Technical Report.', 'description' => 'Age estimation by scoring epiphyseal closures', 'uses_feature_score' => true, 'uses_composite_score' => false,'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt, 'help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/methods/#mckern-tw-stewart-td-1957');
        (!$method->exists) ? $method->fill($data)->save() : $method->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name', '=', 'Thoracic vertebra 8')->first()->id;
		$method = Method::firstOrNew(['sb_id' => $sb_id, 'name' =>'McKern and Stewart 1957', 'submethod' => '']);
		$data = array('sb_id' => $sb_id, 'name' => 'McKern and Stewart 1957', 'submethod' => '', 'type' => 'Age', 'reference' => 'Skeletal Age Changes in Young American Males.  Quartermaster Research and Development Command Technical Report.', 'description' => 'Age estimation by scoring epiphyseal closures', 'uses_feature_score' => true, 'uses_composite_score' => false,'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt, 'help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/methods/#mckern-tw-stewart-td-1957');
        (!$method->exists) ? $method->fill($data)->save() : $method->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name', '=', 'Thoracic vertebra 9')->first()->id;
		$method = Method::firstOrNew(['sb_id' => $sb_id, 'name' =>'McKern and Stewart 1957', 'submethod' => '']);
		$data = array('sb_id' => $sb_id, 'name' => 'McKern and Stewart 1957', 'submethod' => '', 'type' => 'Age', 'reference' => 'Skeletal Age Changes in Young American Males.  Quartermaster Research and Development Command Technical Report.', 'description' => 'Age estimation by scoring epiphyseal closures', 'uses_feature_score' => true, 'uses_composite_score' => false,'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt, 'help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/methods/#mckern-tw-stewart-td-1957');
        (!$method->exists) ? $method->fill($data)->save() : $method->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name', '=', 'Tibia')->first()->id;
		$method = Method::firstOrNew(['sb_id' => $sb_id, 'name' =>'McKern and Stewart 1957', 'submethod' => '']);
		$data = array('sb_id' => $sb_id, 'name' => 'McKern and Stewart 1957', 'submethod' => '', 'type' => 'Age', 'reference' => 'Skeletal Age Changes in Young American Males.  Quartermaster Research and Development Command Technical Report.', 'description' => 'Age estimation by scoring epiphyseal closures', 'uses_feature_score' => true, 'uses_composite_score' => false,'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt, 'help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/methods/#mckern-tw-stewart-td-1957');
        (!$method->exists) ? $method->fill($data)->save() : $method->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name', '=', 'Ulna')->first()->id;
		$method = Method::firstOrNew(['sb_id' => $sb_id, 'name' =>'McKern and Stewart 1957', 'submethod' => '']);
		$data = array('sb_id' => $sb_id, 'name' => 'McKern and Stewart 1957', 'submethod' => '', 'type' => 'Age', 'reference' => 'Skeletal Age Changes in Young American Males.  Quartermaster Research and Development Command Technical Report.', 'description' => 'Age estimation by scoring epiphyseal closures', 'uses_feature_score' => true, 'uses_composite_score' => false,'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt, 'help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/methods/#mckern-tw-stewart-td-1957');
        (!$method->exists) ? $method->fill($data)->save() : $method->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name', '=', 'Unseriated cervical vertebra')->first()->id;
		$method = Method::firstOrNew(['sb_id' => $sb_id, 'name' =>'McKern and Stewart 1957', 'submethod' => '']);
		$data = array('sb_id' => $sb_id, 'name' => 'McKern and Stewart 1957', 'submethod' => '', 'type' => 'Age', 'reference' => 'Skeletal Age Changes in Young American Males.  Quartermaster Research and Development Command Technical Report.', 'description' => 'Age estimation by scoring epiphyseal closures', 'uses_feature_score' => true, 'uses_composite_score' => false,'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt, 'help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/methods/#mckern-tw-stewart-td-1957');
        (!$method->exists) ? $method->fill($data)->save() : $method->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name', '=', 'Unseriated lumbar vertebra')->first()->id;
		$method = Method::firstOrNew(['sb_id' => $sb_id, 'name' =>'McKern and Stewart 1957', 'submethod' => '']);
		$data = array('sb_id' => $sb_id, 'name' => 'McKern and Stewart 1957', 'submethod' => '', 'type' => 'Age', 'reference' => 'Skeletal Age Changes in Young American Males.  Quartermaster Research and Development Command Technical Report.', 'description' => 'Age estimation by scoring epiphyseal closures', 'uses_feature_score' => true, 'uses_composite_score' => false,'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt, 'help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/methods/#mckern-tw-stewart-td-1957');
        (!$method->exists) ? $method->fill($data)->save() : $method->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name', '=', 'Unseriated thoracic vertebra')->first()->id;
		$method = Method::firstOrNew(['sb_id' => $sb_id, 'name' =>'McKern and Stewart 1957', 'submethod' => '']);
		$data = array('sb_id' => $sb_id, 'name' => 'McKern and Stewart 1957', 'submethod' => '', 'type' => 'Age', 'reference' => 'Skeletal Age Changes in Young American Males.  Quartermaster Research and Development Command Technical Report.', 'description' => 'Age estimation by scoring epiphyseal closures', 'uses_feature_score' => true, 'uses_composite_score' => false,'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt, 'help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/methods/#mckern-tw-stewart-td-1957');
        (!$method->exists) ? $method->fill($data)->save() : $method->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name', '=', 'Unidentified vertebra')->first()->id;
		$method = Method::firstOrNew(['sb_id' => $sb_id, 'name' =>'McKern and Stewart 1957', 'submethod' => '']);
		$data = array('sb_id' => $sb_id, 'name' => 'McKern and Stewart 1957', 'submethod' => '', 'type' => 'Age', 'reference' => 'Skeletal Age Changes in Young American Males.  Quartermaster Research and Development Command Technical Report.', 'description' => 'Age estimation by scoring epiphyseal closures', 'uses_feature_score' => true, 'uses_composite_score' => false,'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt, 'help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/methods/#mckern-tw-stewart-td-1957');
        (!$method->exists) ? $method->fill($data)->save() : $method->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name', '=', 'Cranium')->first()->id;
        $method = Method::firstOrNew(['sb_id' => $sb_id, 'name' =>'Meindl and Lovejoy 1985', 'submethod' => '']);
        $data = array('sb_id' => $sb_id, 'name' => 'Meindl and Lovejoy 1985', 'submethod' => '', 'type' => 'Age', 'reference' => 'AJPA 68:57-66', 'description' => 'Age estimation by scoring ectocranial vault suture closure', 'uses_feature_score' => true, 'uses_composite_score' => true,'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt, 'help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/methods/#meindl-rs-lovejoy-co-1985');
        (!$method->exists) ? $method->fill($data)->save() : $method->fill(array_except($data, ['created_at']))->save();

//        $sb_id = SkeletalBone::where('name', '=', 'Cranium')->first()->id;
//		$method = Method::firstOrNew(['sb_id' => $sb_id, 'name' =>'Meindl and Lovejoy 1985', 'submethod' => 'Ectocranial vault']);
//		$data = array('sb_id' => $sb_id, 'name' => 'Meindl and Lovejoy 1985', 'submethod' => 'Ectocranial vault', 'type' => 'Age', 'reference' => 'AJPA 68:57-66', 'description' => 'Age estimation by scoring ectocranial vault suture closure', 'uses_feature_score' => true, 'uses_composite_score' => true,'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt, 'help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/methods/#meindl-rs-lovejoy-co-1985');
//        (!$method->exists) ? $method->fill($data)->save() : $method->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name', '=', 'Cranium')->first()->id;
//		$method = Method::firstOrNew(['sb_id' => $sb_id, 'name' =>'Meindl and Lovejoy 1985', 'submethod' => 'Ectocranial lateral-anterior']);
//		$data = array('sb_id' => $sb_id, 'name' => 'Meindl and Lovejoy 1985', 'submethod' => 'Ectocranial lateral-anterior', 'type' => 'Age', 'reference' => 'AJPA 68:57-66', 'description' => 'Age estimation by scoring ectocranial lateral anterior suture closure', 'uses_feature_score' => true, 'uses_composite_score' => true,'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt, 'help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/methods/#meindl-rs-lovejoy-co-1985');
//        (!$method->exists) ? $method->fill($data)->save() : $method->fill(array_except($data, ['created_at']))->save();
//
        $sb_id = SkeletalBone::where('name', '=', 'Cranium')->first()->id;
		$method = Method::firstOrNew(['sb_id' => $sb_id, 'name' =>'Mincer et al 1993', 'submethod' => '']);
		$data = array('sb_id' => $sb_id, 'name' => 'Mincer et al 1993', 'submethod' => '', 'type' => 'Age', 'reference' => 'JFS 38:379-390', 'description' => 'Age estimation of White males by scoring third molar development', 'uses_feature_score' => true, 'uses_composite_score' => false,'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt, 'help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/methods/#mincer-hh-harris-ef-berryman-he-1993');
        (!$method->exists) ? $method->fill($data)->save() : $method->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name', '=', 'Mandible')->first()->id;
		$method = Method::firstOrNew(['sb_id' => $sb_id, 'name' =>'Mincer et al 1993', 'submethod' => '']);
		$data = array('sb_id' => $sb_id, 'name' => 'Mincer et al 1993', 'submethod' => '', 'type' => 'Age', 'reference' => 'JFS 38:379-390', 'description' => 'Age estimation of White males by scoring third molar development', 'uses_feature_score' => true, 'uses_composite_score' => false,'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt, 'help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/methods/#mincer-hh-harris-ef-berryman-he-1993');
        (!$method->exists) ? $method->fill($data)->save() : $method->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name', '=', 'Maxilla')->first()->id;
		$method = Method::firstOrNew(['sb_id' => $sb_id, 'name' =>'Mincer et al 1993', 'submethod' => '']);
		$data = array('sb_id' => $sb_id, 'name' => 'Mincer et al 1993', 'submethod' => '', 'type' => 'Age', 'reference' => 'JFS 38:379-390', 'description' => 'Age estimation of White males by scoring third molar development', 'uses_feature_score' => true, 'uses_composite_score' => false,'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt, 'help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/methods/#mincer-hh-harris-ef-berryman-he-1993');
        (!$method->exists) ? $method->fill($data)->save() : $method->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name', '=', 'Tooth 1')->first()->id;
        $method = Method::firstOrNew(['sb_id' => $sb_id, 'name' =>'Mincer et al 1993', 'submethod' => '']);
        $data = array('sb_id' => $sb_id, 'name' => 'Mincer et al 1993', 'submethod' => '', 'type' => 'Age', 'reference' => 'JFS 38:379-390', 'description' => 'Age estimation of White males by scoring third molar development', 'uses_feature_score' => true, 'uses_composite_score' => false,'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt, 'help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/methods/#mincer-hh-harris-ef-berryman-he-1993');
        (!$method->exists) ? $method->fill($data)->save() : $method->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name', '=', 'Tooth 16')->first()->id;
        $method = Method::firstOrNew(['sb_id' => $sb_id, 'name' =>'Mincer et al 1993', 'submethod' => '']);
        $data = array('sb_id' => $sb_id, 'name' => 'Mincer et al 1993', 'submethod' => '', 'type' => 'Age', 'reference' => 'JFS 38:379-390', 'description' => 'Age estimation of White males by scoring third molar development', 'uses_feature_score' => true, 'uses_composite_score' => false,'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt, 'help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/methods/#mincer-hh-harris-ef-berryman-he-1993');
        (!$method->exists) ? $method->fill($data)->save() : $method->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name', '=', 'Tooth 17')->first()->id;
        $method = Method::firstOrNew(['sb_id' => $sb_id, 'name' =>'Mincer et al 1993', 'submethod' => '']);
        $data = array('sb_id' => $sb_id, 'name' => 'Mincer et al 1993', 'submethod' => '', 'type' => 'Age', 'reference' => 'JFS 38:379-390', 'description' => 'Age estimation of White males by scoring third molar development', 'uses_feature_score' => true, 'uses_composite_score' => false,'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt, 'help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/methods/#mincer-hh-harris-ef-berryman-he-1993');
        (!$method->exists) ? $method->fill($data)->save() : $method->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name', '=', 'Tooth 32')->first()->id;
        $method = Method::firstOrNew(['sb_id' => $sb_id, 'name' =>'Mincer et al 1993', 'submethod' => '']);
        $data = array('sb_id' => $sb_id, 'name' => 'Mincer et al 1993', 'submethod' => '', 'type' => 'Age', 'reference' => 'JFS 38:379-390', 'description' => 'Age estimation of White males by scoring third molar development', 'uses_feature_score' => true, 'uses_composite_score' => false,'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt, 'help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/methods/#mincer-hh-harris-ef-berryman-he-1993');
        (!$method->exists) ? $method->fill($data)->save() : $method->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name', '=', 'Cranium')->first()->id;
        $method = Method::firstOrNew(['sb_id' => $sb_id, 'name' =>'Nawrocki 1998', 'submethod' => '']);
        $data = array('sb_id' => $sb_id, 'name' => 'Nawrocki 1998', 'submethod' => '', 'type' => 'Age', 'reference' => 'Forensic Osteology, edited by K. Reichs.  Charles C. Thomas.', 'description' => 'Age estimation by scoring ectocranial suture closure', 'uses_feature_score' => true, 'uses_composite_score' => true, 'feature_groups' => '{"Ectocranial":"Ectocranial", "Endocranial":"Endocranial", "Palatine":"Palatine"}', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt, 'help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/methods/#nawrocki-sp-1998');
        (!$method->exists) ? $method->fill($data)->save() : $method->fill(array_except($data, ['created_at']))->save();

//        $sb_id = SkeletalBone::where('name', '=', 'Cranium')->first()->id;
//		$method = Method::firstOrNew(['sb_id' => $sb_id, 'name' =>'Nawrocki 1998', 'submethod' => 'Ectocranial Suture']);
//		$data = array('sb_id' => $sb_id, 'name' => 'Nawrocki 1998', 'submethod' => 'Ectocranial Suture', 'type' => 'Age', 'reference' => 'Forensic Osteology, edited by K. Reichs.  Charles C. Thomas.', 'description' => 'Age estimation by scoring ectocranial suture closure', 'uses_feature_score' => true, 'uses_composite_score' => true,'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt, 'help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/methods/#nawrocki-sp-1998');
//        (!$method->exists) ? $method->fill($data)->save() : $method->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name', '=', 'Cranium')->first()->id;
//		$method = Method::firstOrNew(['sb_id' => $sb_id, 'name' =>'Nawrocki 1998', 'submethod' => 'Endocranial Suture']);
//		$data = array('sb_id' => $sb_id, 'name' => 'Nawrocki 1998', 'submethod' => 'Endocranial Suture', 'type' => 'Age', 'reference' => 'Forensic Osteology, edited by K. Reichs.  Charles C. Thomas.', 'description' => 'Age estimate by scoring endocranial suture closure', 'uses_feature_score' => true, 'uses_composite_score' => true,'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt, 'help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/methods/#nawrocki-sp-1998');
//        (!$method->exists) ? $method->fill($data)->save() : $method->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name', '=', 'Cranium')->first()->id;
//		$method = Method::firstOrNew(['sb_id' => $sb_id, 'name' =>'Nawrocki 1998', 'submethod' => 'Palatine']);
//		$data = array('sb_id' => $sb_id, 'name' => 'Nawrocki 1998', 'submethod' => 'Palatine', 'type' => 'Age', 'reference' => 'Forensic Osteology, edited by K. Reichs.  Charles C. Thomas.', 'description' => 'Age estimate scoring maxillary suture closure', 'uses_feature_score' => true, 'uses_composite_score' => true,'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt, 'help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/methods/#nawrocki-sp-1998');
//        (!$method->exists) ? $method->fill($data)->save() : $method->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name', '=', 'Os coxa')->first()->id;
		$method = Method::firstOrNew(['sb_id' => $sb_id, 'name' =>'Osborne et al 2004', 'submethod' => '']);
		$data = array('sb_id' => $sb_id, 'name' => 'Osborne et al 2004', 'submethod' => '', 'type' => 'Age', 'reference' => 'JFS 49(5):905-911', 'description' => 'Age estimation based on auricular surface morphology', 'uses_feature_score' => true, 'uses_composite_score' => false,'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt, 'help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/methods/#osborne-dl-simmons-tl-nawrocki-sp-2004');
        (!$method->exists) ? $method->fill($data)->save() : $method->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name', '=', 'Os coxa')->first()->id;
		$method = Method::firstOrNew(['sb_id' => $sb_id, 'name' =>'Phenice 1969', 'submethod' => '']);
		$data = array('sb_id' => $sb_id, 'name' => 'Phenice 1969', 'submethod' => '', 'type' => 'Sex', 'reference' => 'AJPA 30:297-301', 'description' => 'Sex estimation based on os coxa morphology', 'uses_feature_score' => true, 'uses_composite_score' => false,'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt, 'help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/methods/#phenice-tw-1969');
        (!$method->exists) ? $method->fill($data)->save() : $method->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name', '=', 'Cranium')->first()->id;
		$method = Method::firstOrNew(['sb_id' => $sb_id, 'name' =>'Rhine 1990', 'submethod' => '']);
		$data = array('sb_id' => $sb_id, 'name' => 'Rhine 1990', 'submethod' => '', 'type' => 'Ancestry', 'reference' => 'Skeletal Attribution of Race, edited by G. Gill and S. Rhine.  Maxwell Museum Anthropological Papers No. 4', 'description' => 'Ancestry estimation based on cranial morphology (Asian, Black, White)', 'uses_feature_score' => true, 'uses_composite_score' => false,'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt, 'help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/methods/#rhine-s-1990');
        (!$method->exists) ? $method->fill($data)->save() : $method->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name', '=', 'Humerus')->first()->id;
		$method = Method::firstOrNew(['sb_id' => $sb_id, 'name' =>'Rogers 1999', 'submethod' => '']);
		$data = array('sb_id' => $sb_id, 'name' => 'Rogers 1999', 'submethod' => '', 'type' => 'Sex', 'reference' => 'JFS 44:57-60', 'description' => 'Sex estimation based on distal humerus morphology', 'uses_feature_score' => true, 'uses_composite_score' => false,'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt, 'help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/methods/#rogers-tl-1999');
        (!$method->exists) ? $method->fill($data)->save() : $method->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name', '=', 'Clavicle')->first()->id;
        $method = Method::firstOrNew(['sb_id' => $sb_id, 'name' =>'Rogers et al 2000', 'submethod' => '']);
		$data = array('sb_id' => $sb_id, 'name' => 'Rogers et al 2000', 'submethod' => '', 'type' => 'Sex', 'reference' => 'JFS 45:61-67', 'description' => 'Sex estimation based on clavicle morphology', 'uses_feature_score' => true, 'uses_composite_score' => false,'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt, 'help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/methods/#rogers-nl-flournoy-le-mccormick-wf-2000');
        (!$method->exists) ? $method->fill($data)->save() : $method->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name', '=', 'Os coxa')->first()->id;
        $method = Method::firstOrNew(['sb_id' => $sb_id, 'name' =>'Samworth and Gowland 2007', 'submethod' => '']);
		$data = array('sb_id' => $sb_id, 'name' => 'Samworth and Gowland 2007', 'submethod' => '', 'type' => 'Age', 'reference' => 'IJO 17:174-188', 'description' => 'Age estimate based on features of the os coxa', 'uses_feature_score' => true, 'uses_composite_score' => false,'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt, 'help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/methods/#samworth-r-gowland-r-2007');
        (!$method->exists) ? $method->fill($data)->save() : $method->fill(array_except($data, ['created_at']))->save();

        //////////////////////////////////////////////////////////////////
        /// Start - New Schaefer 2008 method

        $sb_id = SkeletalBone::where('name', '=', 'Humerus')->first()->id;
        $method = Method::firstOrNew(['sb_id' => $sb_id, 'name' =>'Schaefer 2008', 'submethod' => '']);
        $data = array('sb_id' => $sb_id, 'name' => 'Schaefer 2008', 'submethod' => '', 'type' => 'Age', 'reference' => 'A summary of epiphyseal union timings in Bosnian males. International Journal of Osteoarchaeology 18(5):536-545', 'description' => 'Age estimation based on epiphyseal fusion', 'uses_feature_score' => true, 'uses_composite_score' => false,'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt, 'help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/methods/#schaefer-mc-2008');
        (!$method->exists) ? $method->fill($data)->save() : $method->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name', '=', 'Radius')->first()->id;
        $method = Method::firstOrNew(['sb_id' => $sb_id, 'name' =>'Schaefer 2008', 'submethod' => '']);
        $data = array('sb_id' => $sb_id, 'name' => 'Schaefer 2008', 'submethod' => '', 'type' => 'Age', 'reference' => 'A summary of epiphyseal union timings in Bosnian males. International Journal of Osteoarchaeology 18(5):536-545', 'description' => 'Age estimation based on epiphyseal fusion', 'uses_feature_score' => true, 'uses_composite_score' => false,'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt, 'help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/methods/#schaefer-mc-2008');
        (!$method->exists) ? $method->fill($data)->save() : $method->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name', '=', 'Ulna')->first()->id;
        $method = Method::firstOrNew(['sb_id' => $sb_id, 'name' =>'Schaefer 2008', 'submethod' => '']);
        $data = array('sb_id' => $sb_id, 'name' => 'Schaefer 2008', 'submethod' => '', 'type' => 'Age', 'reference' => 'A summary of epiphyseal union timings in Bosnian males. International Journal of Osteoarchaeology 18(5):536-545', 'description' => 'Age estimation based on epiphyseal fusion', 'uses_feature_score' => true, 'uses_composite_score' => false,'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt, 'help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/methods/#schaefer-mc-2008');
        (!$method->exists) ? $method->fill($data)->save() : $method->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name', '=', 'Femur')->first()->id;
        $method = Method::firstOrNew(['sb_id' => $sb_id, 'name' =>'Schaefer 2008', 'submethod' => '']);
        $data = array('sb_id' => $sb_id, 'name' => 'Schaefer 2008', 'submethod' => '', 'type' => 'Age', 'reference' => 'A summary of epiphyseal union timings in Bosnian males. International Journal of Osteoarchaeology 18(5):536-545', 'description' => 'Age estimation based on epiphyseal fusion', 'uses_feature_score' => true, 'uses_composite_score' => false,'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt, 'help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/methods/#schaefer-mc-2008');
        (!$method->exists) ? $method->fill($data)->save() : $method->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name', '=', 'Tibia')->first()->id;
        $method = Method::firstOrNew(['sb_id' => $sb_id, 'name' =>'Schaefer 2008', 'submethod' => '']);
        $data = array('sb_id' => $sb_id, 'name' => 'Schaefer 2008', 'submethod' => '', 'type' => 'Age', 'reference' => 'A summary of epiphyseal union timings in Bosnian males. International Journal of Osteoarchaeology 18(5):536-545', 'description' => 'Age estimation based on epiphyseal fusion', 'uses_feature_score' => true, 'uses_composite_score' => false,'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt, 'help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/methods/#schaefer-mc-2008');
        (!$method->exists) ? $method->fill($data)->save() : $method->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name', '=', 'Fibula')->first()->id;
        $method = Method::firstOrNew(['sb_id' => $sb_id, 'name' =>'Schaefer 2008', 'submethod' => '']);
        $data = array('sb_id' => $sb_id, 'name' => 'Schaefer 2008', 'submethod' => '', 'type' => 'Age', 'reference' => 'A summary of epiphyseal union timings in Bosnian males. International Journal of Osteoarchaeology 18(5):536-545', 'description' => 'Age estimation based on epiphyseal fusion', 'uses_feature_score' => true, 'uses_composite_score' => false,'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt, 'help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/methods/#schaefer-mc-2008');
        (!$method->exists) ? $method->fill($data)->save() : $method->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name', '=', 'Os coxa')->first()->id;
        $method = Method::firstOrNew(['sb_id' => $sb_id, 'name' =>'Schaefer 2008', 'submethod' => '']);
        $data = array('sb_id' => $sb_id, 'name' => 'Schaefer 2008', 'submethod' => '', 'type' => 'Age', 'reference' => 'A summary of epiphyseal union timings in Bosnian males. International Journal of Osteoarchaeology 18(5):536-545', 'description' => 'Age estimation based on epiphyseal fusion', 'uses_feature_score' => true, 'uses_composite_score' => false,'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt, 'help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/methods/#schaefer-mc-2008');
        (!$method->exists) ? $method->fill($data)->save() : $method->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name', '=', 'Clavicle')->first()->id;
        $method = Method::firstOrNew(['sb_id' => $sb_id, 'name' =>'Schaefer 2008', 'submethod' => '']);
        $data = array('sb_id' => $sb_id, 'name' => 'Schaefer 2008', 'submethod' => '', 'type' => 'Age', 'reference' => 'A summary of epiphyseal union timings in Bosnian males. International Journal of Osteoarchaeology 18(5):536-545', 'description' => 'Age estimation based on epiphyseal fusion', 'uses_feature_score' => true, 'uses_composite_score' => false,'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt, 'help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/methods/#schaefer-mc-2008');
        (!$method->exists) ? $method->fill($data)->save() : $method->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name', '=', 'Scapula')->first()->id;
        $method = Method::firstOrNew(['sb_id' => $sb_id, 'name' =>'Schaefer 2008', 'submethod' => '']);
        $data = array('sb_id' => $sb_id, 'name' => 'Schaefer 2008', 'submethod' => '', 'type' => 'Age', 'reference' => 'A summary of epiphyseal union timings in Bosnian males. International Journal of Osteoarchaeology 18(5):536-545', 'description' => 'Age estimation based on epiphyseal fusion', 'uses_feature_score' => true, 'uses_composite_score' => false,'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt, 'help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/methods/#schaefer-mc-2008');
        (!$method->exists) ? $method->fill($data)->save() : $method->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name', '=', 'Sacrum')->first()->id;
        $method = Method::firstOrNew(['sb_id' => $sb_id, 'name' =>'Schaefer 2008', 'submethod' => '']);
        $data = array('sb_id' => $sb_id, 'name' => 'Schaefer 2008', 'submethod' => '', 'type' => 'Age', 'reference' => 'A summary of epiphyseal union timings in Bosnian males. International Journal of Osteoarchaeology 18(5):536-545', 'description' => 'Age estimation based on epiphyseal fusion', 'uses_feature_score' => true, 'uses_composite_score' => false,'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt, 'help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/methods/#schaefer-mc-2008');
        (!$method->exists) ? $method->fill($data)->save() : $method->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name', '=', 'Sternum')->first()->id;
        $method = Method::firstOrNew(['sb_id' => $sb_id, 'name' =>'Schaefer 2008', 'submethod' => '']);
        $data = array('sb_id' => $sb_id, 'name' => 'Schaefer 2008', 'submethod' => '', 'type' => 'Age', 'reference' => 'A summary of epiphyseal union timings in Bosnian males. International Journal of Osteoarchaeology 18(5):536-545', 'description' => 'Age estimation based on epiphyseal fusion', 'uses_feature_score' => true, 'uses_composite_score' => false,'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt, 'help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/methods/#schaefer-mc-2008');
        (!$method->exists) ? $method->fill($data)->save() : $method->fill(array_except($data, ['created_at']))->save();

        /// End - New Schaefer 2008 method
        //////////////////////////////////////////////////////////////////

        //////////////////////////////////////////////////////////////////
        /// Start - Old Schaefer et al 2009 method

//        $sb_id = SkeletalBone::where('name', '=', 'Accessory rib')->first()->id;
//		$method = Method::firstOrNew(['sb_id' => $sb_id, 'name' =>'Schaefer et al 2009', 'submethod' => '']);
//		$data = array('sb_id' => $sb_id, 'name' => 'Schaefer et al 2009', 'submethod' => '', 'type' => 'Age', 'reference' => 'Juvenile Osteology.  Elsevier.', 'description' => 'Age estimation based on various skeletal morphology', 'uses_feature_score' => true, 'uses_composite_score' => false,'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt, 'help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/methods/#schaefer-m-black-s-scheuer-l-2009');
//        (!$method->exists) ? $method->fill($data)->save() : $method->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name', '=', 'Calcaneus')->first()->id;
//		$method = Method::firstOrNew(['sb_id' => $sb_id, 'name' =>'Schaefer et al 2009', 'submethod' => '']);
//		$data = array('sb_id' => $sb_id, 'name' => 'Schaefer et al 2009', 'submethod' => '', 'type' => 'Age', 'reference' => 'Juvenile Osteology.  Elsevier.', 'description' => 'Age estimation based on various skeletal morphology', 'uses_feature_score' => true, 'uses_composite_score' => false,'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt, 'help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/methods/#schaefer-m-black-s-scheuer-l-2009');
//        (!$method->exists) ? $method->fill($data)->save() : $method->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name', '=', 'Capitate')->first()->id;
//		$method = Method::firstOrNew(['sb_id' => $sb_id, 'name' =>'Schaefer et al 2009', 'submethod' => '']);
//		$data = array('sb_id' => $sb_id, 'name' => 'Schaefer et al 2009', 'submethod' => '', 'type' => 'Age', 'reference' => 'Juvenile Osteology.  Elsevier.', 'description' => 'Age estimation based on various skeletal morphology', 'uses_feature_score' => true, 'uses_composite_score' => false,'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt, 'help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/methods/#schaefer-m-black-s-scheuer-l-2009');
//        (!$method->exists) ? $method->fill($data)->save() : $method->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name', '=', 'Cervical vertebra 1')->first()->id;
//		$method = Method::firstOrNew(['sb_id' => $sb_id, 'name' =>'Schaefer et al 2009', 'submethod' => '']);
//		$data = array('sb_id' => $sb_id, 'name' => 'Schaefer et al 2009', 'submethod' => '', 'type' => 'Age', 'reference' => 'Juvenile Osteology.  Elsevier.', 'description' => 'Age estimation based on various skeletal morphology', 'uses_feature_score' => true, 'uses_composite_score' => false,'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt, 'help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/methods/#schaefer-m-black-s-scheuer-l-2009');
//        (!$method->exists) ? $method->fill($data)->save() : $method->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name', '=', 'Cervical vertebra 2')->first()->id;
//		$method = Method::firstOrNew(['sb_id' => $sb_id, 'name' =>'Schaefer et al 2009', 'submethod' => '']);
//		$data = array('sb_id' => $sb_id, 'name' => 'Schaefer et al 2009', 'submethod' => '', 'type' => 'Age', 'reference' => 'Juvenile Osteology.  Elsevier.', 'description' => 'Age estimation based on various skeletal morphology', 'uses_feature_score' => true, 'uses_composite_score' => false,'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt, 'help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/methods/#schaefer-m-black-s-scheuer-l-2009');
//        (!$method->exists) ? $method->fill($data)->save() : $method->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name', '=', 'Cervical vertebra 3')->first()->id;
//		$method = Method::firstOrNew(['sb_id' => $sb_id, 'name' =>'Schaefer et al 2009', 'submethod' => '']);
//		$data = array('sb_id' => $sb_id, 'name' => 'Schaefer et al 2009', 'submethod' => '', 'type' => 'Age', 'reference' => 'Juvenile Osteology.  Elsevier.', 'description' => 'Age estimation based on various skeletal morphology', 'uses_feature_score' => true, 'uses_composite_score' => false,'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt, 'help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/methods/#schaefer-m-black-s-scheuer-l-2009');
//        (!$method->exists) ? $method->fill($data)->save() : $method->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name', '=', 'Cervical vertebra 4')->first()->id;
//		$method = Method::firstOrNew(['sb_id' => $sb_id, 'name' =>'Schaefer et al 2009', 'submethod' => '']);
//		$data = array('sb_id' => $sb_id, 'name' => 'Schaefer et al 2009', 'submethod' => '', 'type' => 'Age', 'reference' => 'Juvenile Osteology.  Elsevier.', 'description' => 'Age estimation based on various skeletal morphology', 'uses_feature_score' => true, 'uses_composite_score' => false,'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt, 'help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/methods/#schaefer-m-black-s-scheuer-l-2009');
//        (!$method->exists) ? $method->fill($data)->save() : $method->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name', '=', 'Cervical vertebra 5')->first()->id;
//		$method = Method::firstOrNew(['sb_id' => $sb_id, 'name' =>'Schaefer et al 2009', 'submethod' => '']);
//		$data = array('sb_id' => $sb_id, 'name' => 'Schaefer et al 2009', 'submethod' => '', 'type' => 'Age', 'reference' => 'Juvenile Osteology.  Elsevier.', 'description' => 'Age estimation based on various skeletal morphology', 'uses_feature_score' => true, 'uses_composite_score' => false,'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt, 'help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/methods/#schaefer-m-black-s-scheuer-l-2009');
//        (!$method->exists) ? $method->fill($data)->save() : $method->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name', '=', 'Cervical vertebra 6')->first()->id;
//		$method = Method::firstOrNew(['sb_id' => $sb_id, 'name' =>'Schaefer et al 2009', 'submethod' => '']);
//		$data = array('sb_id' => $sb_id, 'name' => 'Schaefer et al 2009', 'submethod' => '', 'type' => 'Age', 'reference' => 'Juvenile Osteology.  Elsevier.', 'description' => 'Age estimation based on various skeletal morphology', 'uses_feature_score' => true, 'uses_composite_score' => false,'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt, 'help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/methods/#schaefer-m-black-s-scheuer-l-2009');
//        (!$method->exists) ? $method->fill($data)->save() : $method->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name', '=', 'Cervical vertebra 6/7')->first()->id;
//		$method = Method::firstOrNew(['sb_id' => $sb_id, 'name' =>'Schaefer et al 2009', 'submethod' => '']);
//		$data = array('sb_id' => $sb_id, 'name' => 'Schaefer et al 2009', 'submethod' => '', 'type' => 'Age', 'reference' => 'Juvenile Osteology.  Elsevier.', 'description' => 'Age estimation based on various skeletal morphology', 'uses_feature_score' => true, 'uses_composite_score' => false,'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt, 'help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/methods/#schaefer-m-black-s-scheuer-l-2009');
//        (!$method->exists) ? $method->fill($data)->save() : $method->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name', '=', 'Cervical vertebra 7')->first()->id;
//		$method = Method::firstOrNew(['sb_id' => $sb_id, 'name' =>'Schaefer et al 2009', 'submethod' => '']);
//		$data = array('sb_id' => $sb_id, 'name' => 'Schaefer et al 2009', 'submethod' => '', 'type' => 'Age', 'reference' => 'Juvenile Osteology.  Elsevier.', 'description' => 'Age estimation based on various skeletal morphology', 'uses_feature_score' => true, 'uses_composite_score' => false,'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt, 'help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/methods/#schaefer-m-black-s-scheuer-l-2009');
//        (!$method->exists) ? $method->fill($data)->save() : $method->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name', '=', 'Clavicle')->first()->id;
//		$method = Method::firstOrNew(['sb_id' => $sb_id, 'name' =>'Schaefer et al 2009', 'submethod' => '']);
//		$data = array('sb_id' => $sb_id, 'name' => 'Schaefer et al 2009', 'submethod' => '', 'type' => 'Age', 'reference' => 'Juvenile Osteology.  Elsevier.', 'description' => 'Age estimation based on various skeletal morphology', 'uses_feature_score' => true, 'uses_composite_score' => false,'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt, 'help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/methods/#schaefer-m-black-s-scheuer-l-2009');
//        (!$method->exists) ? $method->fill($data)->save() : $method->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name', '=', 'Coccygeal vertebra 1')->first()->id;
//		$method = Method::firstOrNew(['sb_id' => $sb_id, 'name' =>'Schaefer et al 2009', 'submethod' => '']);
//		$data = array('sb_id' => $sb_id, 'name' => 'Schaefer et al 2009', 'submethod' => '', 'type' => 'Age', 'reference' => 'Juvenile Osteology.  Elsevier.', 'description' => 'Age estimation based on various skeletal morphology', 'uses_feature_score' => true, 'uses_composite_score' => false,'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt, 'help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/methods/#schaefer-m-black-s-scheuer-l-2009');
//        (!$method->exists) ? $method->fill($data)->save() : $method->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name', '=', 'Coccygeal vertebra 2')->first()->id;
//		$method = Method::firstOrNew(['sb_id' => $sb_id, 'name' =>'Schaefer et al 2009', 'submethod' => '']);
//		$data = array('sb_id' => $sb_id, 'name' => 'Schaefer et al 2009', 'submethod' => '', 'type' => 'Age', 'reference' => 'Juvenile Osteology.  Elsevier.', 'description' => 'Age estimation based on various skeletal morphology', 'uses_feature_score' => true, 'uses_composite_score' => false,'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt, 'help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/methods/#schaefer-m-black-s-scheuer-l-2009');
//        (!$method->exists) ? $method->fill($data)->save() : $method->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name', '=', 'Coccygeal vertebra 3')->first()->id;
//		$method = Method::firstOrNew(['sb_id' => $sb_id, 'name' =>'Schaefer et al 2009', 'submethod' => '']);
//		$data = array('sb_id' => $sb_id, 'name' => 'Schaefer et al 2009', 'submethod' => '', 'type' => 'Age', 'reference' => 'Juvenile Osteology.  Elsevier.', 'description' => 'Age estimation based on various skeletal morphology', 'uses_feature_score' => true, 'uses_composite_score' => false,'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt, 'help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/methods/#schaefer-m-black-s-scheuer-l-2009');
//        (!$method->exists) ? $method->fill($data)->save() : $method->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name', '=', 'Coccygeal vertebra 4')->first()->id;
//		$method = Method::firstOrNew(['sb_id' => $sb_id, 'name' =>'Schaefer et al 2009', 'submethod' => '']);
//		$data = array('sb_id' => $sb_id, 'name' => 'Schaefer et al 2009', 'submethod' => '', 'type' => 'Age', 'reference' => 'Juvenile Osteology.  Elsevier.', 'description' => 'Age estimation based on various skeletal morphology', 'uses_feature_score' => true, 'uses_composite_score' => false,'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt, 'help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/methods/#schaefer-m-black-s-scheuer-l-2009');
//        (!$method->exists) ? $method->fill($data)->save() : $method->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name', '=', 'Cranium')->first()->id;
//		$method = Method::firstOrNew(['sb_id' => $sb_id, 'name' =>'Schaefer et al 2009', 'submethod' => '']);
//		$data = array('sb_id' => $sb_id, 'name' => 'Schaefer et al 2009', 'submethod' => '', 'type' => 'Age', 'reference' => 'Juvenile Osteology.  Elsevier.', 'description' => 'Age estimation based on various skeletal morphology', 'uses_feature_score' => true, 'uses_composite_score' => false,'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt, 'help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/methods/#schaefer-m-black-s-scheuer-l-2009');
//        (!$method->exists) ? $method->fill($data)->save() : $method->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name', '=', 'Cuboid')->first()->id;
//		$method = Method::firstOrNew(['sb_id' => $sb_id, 'name' =>'Schaefer et al 2009', 'submethod' => '']);
//		$data = array('sb_id' => $sb_id, 'name' => 'Schaefer et al 2009', 'submethod' => '', 'type' => 'Age', 'reference' => 'Juvenile Osteology.  Elsevier.', 'description' => 'Age estimation based on various skeletal morphology', 'uses_feature_score' => true, 'uses_composite_score' => false,'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt, 'help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/methods/#schaefer-m-black-s-scheuer-l-2009');
//        (!$method->exists) ? $method->fill($data)->save() : $method->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name', '=', 'Distal manual phalanx 1')->first()->id;
//		$method = Method::firstOrNew(['sb_id' => $sb_id, 'name' =>'Schaefer et al 2009', 'submethod' => '']);
//		$data = array('sb_id' => $sb_id, 'name' => 'Schaefer et al 2009', 'submethod' => '', 'type' => 'Age', 'reference' => 'Juvenile Osteology.  Elsevier.', 'description' => 'Age estimation based on various skeletal morphology', 'uses_feature_score' => true, 'uses_composite_score' => false,'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt, 'help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/methods/#schaefer-m-black-s-scheuer-l-2009');
//        (!$method->exists) ? $method->fill($data)->save() : $method->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name', '=', 'Distal manual phalanx 2')->first()->id;
//		$method = Method::firstOrNew(['sb_id' => $sb_id, 'name' =>'Schaefer et al 2009', 'submethod' => '']);
//		$data = array('sb_id' => $sb_id, 'name' => 'Schaefer et al 2009', 'submethod' => '', 'type' => 'Age', 'reference' => 'Juvenile Osteology.  Elsevier.', 'description' => 'Age estimation based on various skeletal morphology', 'uses_feature_score' => true, 'uses_composite_score' => false,'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt, 'help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/methods/#schaefer-m-black-s-scheuer-l-2009');
//        (!$method->exists) ? $method->fill($data)->save() : $method->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name', '=', 'Distal manual phalanx 3')->first()->id;
//		$method = Method::firstOrNew(['sb_id' => $sb_id, 'name' =>'Schaefer et al 2009', 'submethod' => '']);
//		$data = array('sb_id' => $sb_id, 'name' => 'Schaefer et al 2009', 'submethod' => '', 'type' => 'Age', 'reference' => 'Juvenile Osteology.  Elsevier.', 'description' => 'Age estimation based on various skeletal morphology', 'uses_feature_score' => true, 'uses_composite_score' => false,'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt, 'help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/methods/#schaefer-m-black-s-scheuer-l-2009');
//        (!$method->exists) ? $method->fill($data)->save() : $method->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name', '=', 'Distal manual phalanx 4')->first()->id;
//		$method = Method::firstOrNew(['sb_id' => $sb_id, 'name' =>'Schaefer et al 2009', 'submethod' => '']);
//		$data = array('sb_id' => $sb_id, 'name' => 'Schaefer et al 2009', 'submethod' => '', 'type' => 'Age', 'reference' => 'Juvenile Osteology.  Elsevier.', 'description' => 'Age estimation based on various skeletal morphology', 'uses_feature_score' => true, 'uses_composite_score' => false,'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt, 'help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/methods/#schaefer-m-black-s-scheuer-l-2009');
//        (!$method->exists) ? $method->fill($data)->save() : $method->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name', '=', 'Distal manual phalanx 5')->first()->id;
//		$method = Method::firstOrNew(['sb_id' => $sb_id, 'name' =>'Schaefer et al 2009', 'submethod' => '']);
//		$data = array('sb_id' => $sb_id, 'name' => 'Schaefer et al 2009', 'submethod' => '', 'type' => 'Age', 'reference' => 'Juvenile Osteology.  Elsevier.', 'description' => 'Age estimation based on various skeletal morphology', 'uses_feature_score' => true, 'uses_composite_score' => false,'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt, 'help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/methods/#schaefer-m-black-s-scheuer-l-2009');
//        (!$method->exists) ? $method->fill($data)->save() : $method->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name', '=', 'Distal pedal phalanx 1')->first()->id;
//		$method = Method::firstOrNew(['sb_id' => $sb_id, 'name' =>'Schaefer et al 2009', 'submethod' => '']);
//		$data = array('sb_id' => $sb_id, 'name' => 'Schaefer et al 2009', 'submethod' => '', 'type' => 'Age', 'reference' => 'Juvenile Osteology.  Elsevier.', 'description' => 'Age estimation based on various skeletal morphology', 'uses_feature_score' => true, 'uses_composite_score' => false,'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt, 'help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/methods/#schaefer-m-black-s-scheuer-l-2009');
//        (!$method->exists) ? $method->fill($data)->save() : $method->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name', '=', 'Distal pedal phalanx 2')->first()->id;
//		$method = Method::firstOrNew(['sb_id' => $sb_id, 'name' =>'Schaefer et al 2009', 'submethod' => '']);
//		$data = array('sb_id' => $sb_id, 'name' => 'Schaefer et al 2009', 'submethod' => '', 'type' => 'Age', 'reference' => 'Juvenile Osteology.  Elsevier.', 'description' => 'Age estimation based on various skeletal morphology', 'uses_feature_score' => true, 'uses_composite_score' => false,'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt, 'help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/methods/#schaefer-m-black-s-scheuer-l-2009');
//        (!$method->exists) ? $method->fill($data)->save() : $method->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name', '=', 'Distal pedal phalanx 3')->first()->id;
//		$method = Method::firstOrNew(['sb_id' => $sb_id, 'name' =>'Schaefer et al 2009', 'submethod' => '']);
//		$data = array('sb_id' => $sb_id, 'name' => 'Schaefer et al 2009', 'submethod' => '', 'type' => 'Age', 'reference' => 'Juvenile Osteology.  Elsevier.', 'description' => 'Age estimation based on various skeletal morphology', 'uses_feature_score' => true, 'uses_composite_score' => false,'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt, 'help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/methods/#schaefer-m-black-s-scheuer-l-2009');
//        (!$method->exists) ? $method->fill($data)->save() : $method->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name', '=', 'Distal pedal phalanx 4')->first()->id;
//		$method = Method::firstOrNew(['sb_id' => $sb_id, 'name' =>'Schaefer et al 2009', 'submethod' => '']);
//		$data = array('sb_id' => $sb_id, 'name' => 'Schaefer et al 2009', 'submethod' => '', 'type' => 'Age', 'reference' => 'Juvenile Osteology.  Elsevier.', 'description' => 'Age estimation based on various skeletal morphology', 'uses_feature_score' => true, 'uses_composite_score' => false,'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt, 'help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/methods/#schaefer-m-black-s-scheuer-l-2009');
//        (!$method->exists) ? $method->fill($data)->save() : $method->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name', '=', 'Distal pedal phalanx 5')->first()->id;
//		$method = Method::firstOrNew(['sb_id' => $sb_id, 'name' =>'Schaefer et al 2009', 'submethod' => '']);
//		$data = array('sb_id' => $sb_id, 'name' => 'Schaefer et al 2009', 'submethod' => '', 'type' => 'Age', 'reference' => 'Juvenile Osteology.  Elsevier.', 'description' => 'Age estimation based on various skeletal morphology', 'uses_feature_score' => true, 'uses_composite_score' => false,'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt, 'help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/methods/#schaefer-m-black-s-scheuer-l-2009');
//        (!$method->exists) ? $method->fill($data)->save() : $method->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name', '=', 'Ethmoid')->first()->id;
//        $method = Method::firstOrNew(['sb_id' => $sb_id, 'name' =>'Schaefer et al 2009', 'submethod' => '']);
//		$data = array('sb_id' => $sb_id, 'name' => 'Schaefer et al 2009', 'submethod' => '', 'type' => 'Age', 'reference' => 'Juvenile Osteology.  Elsevier.', 'description' => 'Age estimation based on various skeletal morphology', 'uses_feature_score' => true, 'uses_composite_score' => false,'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt, 'help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/methods/#schaefer-m-black-s-scheuer-l-2009');
//        (!$method->exists) ? $method->fill($data)->save() : $method->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name', '=', 'Extra vertebra')->first()->id;
//		$method = Method::firstOrNew(['sb_id' => $sb_id, 'name' =>'Schaefer et al 2009', 'submethod' => '']);
//		$data = array('sb_id' => $sb_id, 'name' => 'Schaefer et al 2009', 'submethod' => '', 'type' => 'Age', 'reference' => 'Juvenile Osteology.  Elsevier.', 'description' => 'Age estimation based on various skeletal morphology', 'uses_feature_score' => true, 'uses_composite_score' => false,'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt, 'help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/methods/#schaefer-m-black-s-scheuer-l-2009');
//        (!$method->exists) ? $method->fill($data)->save() : $method->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name', '=', 'Femur')->first()->id;
//		$method = Method::firstOrNew(['sb_id' => $sb_id, 'name' =>'Schaefer et al 2009', 'submethod' => '']);
//		$data = array('sb_id' => $sb_id, 'name' => 'Schaefer et al 2009', 'submethod' => '', 'type' => 'Age', 'reference' => 'Juvenile Osteology.  Elsevier.', 'description' => 'Age estimation based on various skeletal morphology', 'uses_feature_score' => true, 'uses_composite_score' => false,'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt, 'help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/methods/#schaefer-m-black-s-scheuer-l-2009');
//        (!$method->exists) ? $method->fill($data)->save() : $method->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name', '=', 'Fibula')->first()->id;
//		$method = Method::firstOrNew(['sb_id' => $sb_id, 'name' =>'Schaefer et al 2009', 'submethod' => '']);
//		$data = array('sb_id' => $sb_id, 'name' => 'Schaefer et al 2009', 'submethod' => '', 'type' => 'Age', 'reference' => 'Juvenile Osteology.  Elsevier.', 'description' => 'Age estimation based on various skeletal morphology', 'uses_feature_score' => true, 'uses_composite_score' => false,'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt, 'help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/methods/#schaefer-m-black-s-scheuer-l-2009');
//        (!$method->exists) ? $method->fill($data)->save() : $method->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name', '=', 'First (Medial) cuneiform')->first()->id;
//		$method = Method::firstOrNew(['sb_id' => $sb_id, 'name' =>'Schaefer et al 2009', 'submethod' => '']);
//		$data = array('sb_id' => $sb_id, 'name' => 'Schaefer et al 2009', 'submethod' => '', 'type' => 'Age', 'reference' => 'Juvenile Osteology.  Elsevier.', 'description' => 'Age estimation based on various skeletal morphology', 'uses_feature_score' => true, 'uses_composite_score' => false,'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt, 'help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/methods/#schaefer-m-black-s-scheuer-l-2009');
//        (!$method->exists) ? $method->fill($data)->save() : $method->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name', '=', 'Frontal')->first()->id;
//		$method = Method::firstOrNew(['sb_id' => $sb_id, 'name' =>'Schaefer et al 2009', 'submethod' => '']);
//		$data = array('sb_id' => $sb_id, 'name' => 'Schaefer et al 2009', 'submethod' => '', 'type' => 'Age', 'reference' => 'Juvenile Osteology.  Elsevier.', 'description' => 'Age estimation based on various skeletal morphology', 'uses_feature_score' => true, 'uses_composite_score' => false,'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt, 'help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/methods/#schaefer-m-black-s-scheuer-l-2009');
//        (!$method->exists) ? $method->fill($data)->save() : $method->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name', '=', 'Hamate')->first()->id;
//		$method = Method::firstOrNew(['sb_id' => $sb_id, 'name' =>'Schaefer et al 2009', 'submethod' => '']);
//		$data = array('sb_id' => $sb_id, 'name' => 'Schaefer et al 2009', 'submethod' => '', 'type' => 'Age', 'reference' => 'Juvenile Osteology.  Elsevier.', 'description' => 'Age estimation based on various skeletal morphology', 'uses_feature_score' => true, 'uses_composite_score' => false,'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt, 'help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/methods/#schaefer-m-black-s-scheuer-l-2009');
//        (!$method->exists) ? $method->fill($data)->save() : $method->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name', '=', 'Humerus')->first()->id;
//		$method = Method::firstOrNew(['sb_id' => $sb_id, 'name' =>'Schaefer et al 2009', 'submethod' => '']);
//		$data = array('sb_id' => $sb_id, 'name' => 'Schaefer et al 2009', 'submethod' => '', 'type' => 'Age', 'reference' => 'Juvenile Osteology.  Elsevier.', 'description' => 'Age estimation based on various skeletal morphology', 'uses_feature_score' => true, 'uses_composite_score' => false,'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt, 'help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/methods/#schaefer-m-black-s-scheuer-l-2009');
//        (!$method->exists) ? $method->fill($data)->save() : $method->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name', '=', 'Hyoid')->first()->id;
//		$method = Method::firstOrNew(['sb_id' => $sb_id, 'name' =>'Schaefer et al 2009', 'submethod' => '']);
//		$data = array('sb_id' => $sb_id, 'name' => 'Schaefer et al 2009', 'submethod' => '', 'type' => 'Age', 'reference' => 'Juvenile Osteology.  Elsevier.', 'description' => 'Age estimation based on various skeletal morphology', 'uses_feature_score' => true, 'uses_composite_score' => false,'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt, 'help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/methods/#schaefer-m-black-s-scheuer-l-2009');
//        (!$method->exists) ? $method->fill($data)->save() : $method->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name', '=', 'Inferior nasal concha')->first()->id;
//		$method = Method::firstOrNew(['sb_id' => $sb_id, 'name' =>'Schaefer et al 2009', 'submethod' => '']);
//		$data = array('sb_id' => $sb_id, 'name' => 'Schaefer et al 2009', 'submethod' => '', 'type' => 'Age', 'reference' => 'Juvenile Osteology.  Elsevier.', 'description' => 'Age estimation based on various skeletal morphology', 'uses_feature_score' => true, 'uses_composite_score' => false,'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt, 'help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/methods/#schaefer-m-black-s-scheuer-l-2009');
//        (!$method->exists) ? $method->fill($data)->save() : $method->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name', '=', 'Intermediate manual phalanx 2')->first()->id;
//		$method = Method::firstOrNew(['sb_id' => $sb_id, 'name' =>'Schaefer et al 2009', 'submethod' => '']);
//		$data = array('sb_id' => $sb_id, 'name' => 'Schaefer et al 2009', 'submethod' => '', 'type' => 'Age', 'reference' => 'Juvenile Osteology.  Elsevier.', 'description' => 'Age estimation based on various skeletal morphology', 'uses_feature_score' => true, 'uses_composite_score' => false,'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt, 'help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/methods/#schaefer-m-black-s-scheuer-l-2009');
//        (!$method->exists) ? $method->fill($data)->save() : $method->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name', '=', 'Intermediate manual phalanx 3')->first()->id;
//		$method = Method::firstOrNew(['sb_id' => $sb_id, 'name' =>'Schaefer et al 2009', 'submethod' => '']);
//		$data = array('sb_id' => $sb_id, 'name' => 'Schaefer et al 2009', 'submethod' => '', 'type' => 'Age', 'reference' => 'Juvenile Osteology.  Elsevier.', 'description' => 'Age estimation based on various skeletal morphology', 'uses_feature_score' => true, 'uses_composite_score' => false,'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt, 'help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/methods/#schaefer-m-black-s-scheuer-l-2009');
//        (!$method->exists) ? $method->fill($data)->save() : $method->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name', '=', 'Intermediate manual phalanx 4')->first()->id;
//		$method = Method::firstOrNew(['sb_id' => $sb_id, 'name' =>'Schaefer et al 2009', 'submethod' => '']);
//		$data = array('sb_id' => $sb_id, 'name' => 'Schaefer et al 2009', 'submethod' => '', 'type' => 'Age', 'reference' => 'Juvenile Osteology.  Elsevier.', 'description' => 'Age estimation based on various skeletal morphology', 'uses_feature_score' => true, 'uses_composite_score' => false,'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt, 'help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/methods/#schaefer-m-black-s-scheuer-l-2009');
//        (!$method->exists) ? $method->fill($data)->save() : $method->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name', '=', 'Intermediate manual phalanx 5')->first()->id;
//		$method = Method::firstOrNew(['sb_id' => $sb_id, 'name' =>'Schaefer et al 2009', 'submethod' => '']);
//		$data = array('sb_id' => $sb_id, 'name' => 'Schaefer et al 2009', 'submethod' => '', 'type' => 'Age', 'reference' => 'Juvenile Osteology.  Elsevier.', 'description' => 'Age estimation based on various skeletal morphology', 'uses_feature_score' => true, 'uses_composite_score' => false,'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt, 'help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/methods/#schaefer-m-black-s-scheuer-l-2009');
//        (!$method->exists) ? $method->fill($data)->save() : $method->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name', '=', 'Intermediate pedal phalanx 2')->first()->id;
//		$method = Method::firstOrNew(['sb_id' => $sb_id, 'name' =>'Schaefer et al 2009', 'submethod' => '']);
//		$data = array('sb_id' => $sb_id, 'name' => 'Schaefer et al 2009', 'submethod' => '', 'type' => 'Age', 'reference' => 'Juvenile Osteology.  Elsevier.', 'description' => 'Age estimation based on various skeletal morphology', 'uses_feature_score' => true, 'uses_composite_score' => false,'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt, 'help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/methods/#schaefer-m-black-s-scheuer-l-2009');
//        (!$method->exists) ? $method->fill($data)->save() : $method->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name', '=', 'Intermediate pedal phalanx 3')->first()->id;
//		$method = Method::firstOrNew(['sb_id' => $sb_id, 'name' =>'Schaefer et al 2009', 'submethod' => '']);
//		$data = array('sb_id' => $sb_id, 'name' => 'Schaefer et al 2009', 'submethod' => '', 'type' => 'Age', 'reference' => 'Juvenile Osteology.  Elsevier.', 'description' => 'Age estimation based on various skeletal morphology', 'uses_feature_score' => true, 'uses_composite_score' => false,'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt, 'help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/methods/#schaefer-m-black-s-scheuer-l-2009');
//        (!$method->exists) ? $method->fill($data)->save() : $method->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name', '=', 'Intermediate pedal phalanx 4')->first()->id;
//		$method = Method::firstOrNew(['sb_id' => $sb_id, 'name' =>'Schaefer et al 2009', 'submethod' => '']);
//		$data = array('sb_id' => $sb_id, 'name' => 'Schaefer et al 2009', 'submethod' => '', 'type' => 'Age', 'reference' => 'Juvenile Osteology.  Elsevier.', 'description' => 'Age estimation based on various skeletal morphology', 'uses_feature_score' => true, 'uses_composite_score' => false,'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt, 'help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/methods/#schaefer-m-black-s-scheuer-l-2009');
//        (!$method->exists) ? $method->fill($data)->save() : $method->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name', '=', 'Intermediate pedal phalanx 5')->first()->id;
//		$method = Method::firstOrNew(['sb_id' => $sb_id, 'name' =>'Schaefer et al 2009', 'submethod' => '']);
//		$data = array('sb_id' => $sb_id, 'name' => 'Schaefer et al 2009', 'submethod' => '', 'type' => 'Age', 'reference' => 'Juvenile Osteology.  Elsevier.', 'description' => 'Age estimation based on various skeletal morphology', 'uses_feature_score' => true, 'uses_composite_score' => false,'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt, 'help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/methods/#schaefer-m-black-s-scheuer-l-2009');
//        (!$method->exists) ? $method->fill($data)->save() : $method->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name', '=', 'Lacrimal')->first()->id;
//		$method = Method::firstOrNew(['sb_id' => $sb_id, 'name' =>'Schaefer et al 2009', 'submethod' => '']);
//		$data = array('sb_id' => $sb_id, 'name' => 'Schaefer et al 2009', 'submethod' => '', 'type' => 'Age', 'reference' => 'Juvenile Osteology.  Elsevier.', 'description' => 'Age estimation based on various skeletal morphology', 'uses_feature_score' => true, 'uses_composite_score' => false,'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt, 'help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/methods/#schaefer-m-black-s-scheuer-l-2009');
//        (!$method->exists) ? $method->fill($data)->save() : $method->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name', '=', 'Lumbar vertebra 1')->first()->id;
//		$method = Method::firstOrNew(['sb_id' => $sb_id, 'name' =>'Schaefer et al 2009', 'submethod' => '']);
//		$data = array('sb_id' => $sb_id, 'name' => 'Schaefer et al 2009', 'submethod' => '', 'type' => 'Age', 'reference' => 'Juvenile Osteology.  Elsevier.', 'description' => 'Age estimation based on various skeletal morphology', 'uses_feature_score' => true, 'uses_composite_score' => false,'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt, 'help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/methods/#schaefer-m-black-s-scheuer-l-2009');
//        (!$method->exists) ? $method->fill($data)->save() : $method->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name', '=', 'Lumbar vertebra 1/2')->first()->id;
//		$method = Method::firstOrNew(['sb_id' => $sb_id, 'name' =>'Schaefer et al 2009', 'submethod' => '']);
//		$data = array('sb_id' => $sb_id, 'name' => 'Schaefer et al 2009', 'submethod' => '', 'type' => 'Age', 'reference' => 'Juvenile Osteology.  Elsevier.', 'description' => 'Age estimation based on various skeletal morphology', 'uses_feature_score' => true, 'uses_composite_score' => false,'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt, 'help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/methods/#schaefer-m-black-s-scheuer-l-2009');
//        (!$method->exists) ? $method->fill($data)->save() : $method->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name', '=', 'Lumbar vertebra 2')->first()->id;
//		$method = Method::firstOrNew(['sb_id' => $sb_id, 'name' =>'Schaefer et al 2009', 'submethod' => '']);
//		$data = array('sb_id' => $sb_id, 'name' => 'Schaefer et al 2009', 'submethod' => '', 'type' => 'Age', 'reference' => 'Juvenile Osteology.  Elsevier.', 'description' => 'Age estimation based on various skeletal morphology', 'uses_feature_score' => true, 'uses_composite_score' => false,'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt, 'help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/methods/#schaefer-m-black-s-scheuer-l-2009');
//        (!$method->exists) ? $method->fill($data)->save() : $method->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name', '=', 'Lumbar vertebra 2/3')->first()->id;
//		$method = Method::firstOrNew(['sb_id' => $sb_id, 'name' =>'Schaefer et al 2009', 'submethod' => '']);
//		$data = array('sb_id' => $sb_id, 'name' => 'Schaefer et al 2009', 'submethod' => '', 'type' => 'Age', 'reference' => 'Juvenile Osteology.  Elsevier.', 'description' => 'Age estimation based on various skeletal morphology', 'uses_feature_score' => true, 'uses_composite_score' => false,'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt, 'help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/methods/#schaefer-m-black-s-scheuer-l-2009');
//        (!$method->exists) ? $method->fill($data)->save() : $method->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name', '=', 'Lumbar vertebra 3')->first()->id;
//		$method = Method::firstOrNew(['sb_id' => $sb_id, 'name' =>'Schaefer et al 2009', 'submethod' => '']);
//		$data = array('sb_id' => $sb_id, 'name' => 'Schaefer et al 2009', 'submethod' => '', 'type' => 'Age', 'reference' => 'Juvenile Osteology.  Elsevier.', 'description' => 'Age estimation based on various skeletal morphology', 'uses_feature_score' => true, 'uses_composite_score' => false,'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt, 'help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/methods/#schaefer-m-black-s-scheuer-l-2009');
//        (!$method->exists) ? $method->fill($data)->save() : $method->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name', '=', 'Lumbar vertebra 3/4')->first()->id;
//		$method = Method::firstOrNew(['sb_id' => $sb_id, 'name' =>'Schaefer et al 2009', 'submethod' => '']);
//		$data = array('sb_id' => $sb_id, 'name' => 'Schaefer et al 2009', 'submethod' => '', 'type' => 'Age', 'reference' => 'Juvenile Osteology.  Elsevier.', 'description' => 'Age estimation based on various skeletal morphology', 'uses_feature_score' => true, 'uses_composite_score' => false,'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt, 'help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/methods/#schaefer-m-black-s-scheuer-l-2009');
//        (!$method->exists) ? $method->fill($data)->save() : $method->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name', '=', 'Lumbar vertebra 4')->first()->id;
//		$method = Method::firstOrNew(['sb_id' => $sb_id, 'name' =>'Schaefer et al 2009', 'submethod' => '']);
//		$data = array('sb_id' => $sb_id, 'name' => 'Schaefer et al 2009', 'submethod' => '', 'type' => 'Age', 'reference' => 'Juvenile Osteology.  Elsevier.', 'description' => 'Age estimation based on various skeletal morphology', 'uses_feature_score' => true, 'uses_composite_score' => false,'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt, 'help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/methods/#schaefer-m-black-s-scheuer-l-2009');
//        (!$method->exists) ? $method->fill($data)->save() : $method->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name', '=', 'Lumbar vertebra 4/5')->first()->id;
//		$method = Method::firstOrNew(['sb_id' => $sb_id, 'name' =>'Schaefer et al 2009', 'submethod' => '']);
//		$data = array('sb_id' => $sb_id, 'name' => 'Schaefer et al 2009', 'submethod' => '', 'type' => 'Age', 'reference' => 'Juvenile Osteology.  Elsevier.', 'description' => 'Age estimation based on various skeletal morphology', 'uses_feature_score' => true, 'uses_composite_score' => false,'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt, 'help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/methods/#schaefer-m-black-s-scheuer-l-2009');
//        (!$method->exists) ? $method->fill($data)->save() : $method->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name', '=', 'Lumbar vertebra 5')->first()->id;
//		$method = Method::firstOrNew(['sb_id' => $sb_id, 'name' =>'Schaefer et al 2009', 'submethod' => '']);
//		$data = array('sb_id' => $sb_id, 'name' => 'Schaefer et al 2009', 'submethod' => '', 'type' => 'Age', 'reference' => 'Juvenile Osteology.  Elsevier.', 'description' => 'Age estimation based on various skeletal morphology', 'uses_feature_score' => true, 'uses_composite_score' => false,'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt, 'help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/methods/#schaefer-m-black-s-scheuer-l-2009');
//        (!$method->exists) ? $method->fill($data)->save() : $method->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name', '=', 'Lunate')->first()->id;
//		$method = Method::firstOrNew(['sb_id' => $sb_id, 'name' =>'Schaefer et al 2009', 'submethod' => '']);
//		$data = array('sb_id' => $sb_id, 'name' => 'Schaefer et al 2009', 'submethod' => '', 'type' => 'Age', 'reference' => 'Juvenile Osteology.  Elsevier.', 'description' => 'Age estimation based on various skeletal morphology', 'uses_feature_score' => true, 'uses_composite_score' => false,'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt, 'help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/methods/#schaefer-m-black-s-scheuer-l-2009');
//        (!$method->exists) ? $method->fill($data)->save() : $method->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name', '=', 'Mandible')->first()->id;
//		$method = Method::firstOrNew(['sb_id' => $sb_id, 'name' =>'Schaefer et al 2009', 'submethod' => '']);
//		$data = array('sb_id' => $sb_id, 'name' => 'Schaefer et al 2009', 'submethod' => '', 'type' => 'Age', 'reference' => 'Juvenile Osteology.  Elsevier.', 'description' => 'Age estimation based on various skeletal morphology', 'uses_feature_score' => true, 'uses_composite_score' => false,'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt, 'help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/methods/#schaefer-m-black-s-scheuer-l-2009');
//        (!$method->exists) ? $method->fill($data)->save() : $method->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name', '=', 'Manubrium')->first()->id;
//		$method = Method::firstOrNew(['sb_id' => $sb_id, 'name' =>'Schaefer et al 2009', 'submethod' => '']);
//		$data = array('sb_id' => $sb_id, 'name' => 'Schaefer et al 2009', 'submethod' => '', 'type' => 'Age', 'reference' => 'Juvenile Osteology.  Elsevier.', 'description' => 'Age estimation based on various skeletal morphology', 'uses_feature_score' => true, 'uses_composite_score' => false,'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt, 'help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/methods/#schaefer-m-black-s-scheuer-l-2009');
//        (!$method->exists) ? $method->fill($data)->save() : $method->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name', '=', 'Maxilla')->first()->id;
//		$method = Method::firstOrNew(['sb_id' => $sb_id, 'name' =>'Schaefer et al 2009', 'submethod' => '']);
//		$data = array('sb_id' => $sb_id, 'name' => 'Schaefer et al 2009', 'submethod' => '', 'type' => 'Age', 'reference' => 'Juvenile Osteology.  Elsevier.', 'description' => 'Age estimation based on various skeletal morphology', 'uses_feature_score' => true, 'uses_composite_score' => false,'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt, 'help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/methods/#schaefer-m-black-s-scheuer-l-2009');
//        (!$method->exists) ? $method->fill($data)->save() : $method->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name', '=', 'Metacarpal 1')->first()->id;
//		$method = Method::firstOrNew(['sb_id' => $sb_id, 'name' =>'Schaefer et al 2009', 'submethod' => '']);
//		$data = array('sb_id' => $sb_id, 'name' => 'Schaefer et al 2009', 'submethod' => '', 'type' => 'Age', 'reference' => 'Juvenile Osteology.  Elsevier.', 'description' => 'Age estimation based on various skeletal morphology', 'uses_feature_score' => true, 'uses_composite_score' => false,'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt, 'help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/methods/#schaefer-m-black-s-scheuer-l-2009');
//        (!$method->exists) ? $method->fill($data)->save() : $method->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name', '=', 'Metacarpal 2')->first()->id;
//		$method = Method::firstOrNew(['sb_id' => $sb_id, 'name' =>'Schaefer et al 2009', 'submethod' => '']);
//		$data = array('sb_id' => $sb_id, 'name' => 'Schaefer et al 2009', 'submethod' => '', 'type' => 'Age', 'reference' => 'Juvenile Osteology.  Elsevier.', 'description' => 'Age estimation based on various skeletal morphology', 'uses_feature_score' => true, 'uses_composite_score' => false,'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt, 'help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/methods/#schaefer-m-black-s-scheuer-l-2009');
//        (!$method->exists) ? $method->fill($data)->save() : $method->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name', '=', 'Metacarpal 3')->first()->id;
//		$method = Method::firstOrNew(['sb_id' => $sb_id, 'name' =>'Schaefer et al 2009', 'submethod' => '']);
//		$data = array('sb_id' => $sb_id, 'name' => 'Schaefer et al 2009', 'submethod' => '', 'type' => 'Age', 'reference' => 'Juvenile Osteology.  Elsevier.', 'description' => 'Age estimation based on various skeletal morphology', 'uses_feature_score' => true, 'uses_composite_score' => false,'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt, 'help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/methods/#schaefer-m-black-s-scheuer-l-2009');
//        (!$method->exists) ? $method->fill($data)->save() : $method->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name', '=', 'Metacarpal 4')->first()->id;
//		$method = Method::firstOrNew(['sb_id' => $sb_id, 'name' =>'Schaefer et al 2009', 'submethod' => '']);
//		$data = array('sb_id' => $sb_id, 'name' => 'Schaefer et al 2009', 'submethod' => '', 'type' => 'Age', 'reference' => 'Juvenile Osteology.  Elsevier.', 'description' => 'Age estimation based on various skeletal morphology', 'uses_feature_score' => true, 'uses_composite_score' => false,'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt, 'help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/methods/#schaefer-m-black-s-scheuer-l-2009');
//        (!$method->exists) ? $method->fill($data)->save() : $method->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name', '=', 'Metacarpal 5')->first()->id;
//		$method = Method::firstOrNew(['sb_id' => $sb_id, 'name' =>'Schaefer et al 2009', 'submethod' => '']);
//		$data = array('sb_id' => $sb_id, 'name' => 'Schaefer et al 2009', 'submethod' => '', 'type' => 'Age', 'reference' => 'Juvenile Osteology.  Elsevier.', 'description' => 'Age estimation based on various skeletal morphology', 'uses_feature_score' => true, 'uses_composite_score' => false,'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt, 'help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/methods/#schaefer-m-black-s-scheuer-l-2009');
//        (!$method->exists) ? $method->fill($data)->save() : $method->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name', '=', 'Metatarsal 1')->first()->id;
//		$method = Method::firstOrNew(['sb_id' => $sb_id, 'name' =>'Schaefer et al 2009', 'submethod' => '']);
//		$data = array('sb_id' => $sb_id, 'name' => 'Schaefer et al 2009', 'submethod' => '', 'type' => 'Age', 'reference' => 'Juvenile Osteology.  Elsevier.', 'description' => 'Age estimation based on various skeletal morphology', 'uses_feature_score' => true, 'uses_composite_score' => false,'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt, 'help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/methods/#schaefer-m-black-s-scheuer-l-2009');
//        (!$method->exists) ? $method->fill($data)->save() : $method->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name', '=', 'Metatarsal 2')->first()->id;
//		$method = Method::firstOrNew(['sb_id' => $sb_id, 'name' =>'Schaefer et al 2009', 'submethod' => '']);
//		$data = array('sb_id' => $sb_id, 'name' => 'Schaefer et al 2009', 'submethod' => '', 'type' => 'Age', 'reference' => 'Juvenile Osteology.  Elsevier.', 'description' => 'Age estimation based on various skeletal morphology', 'uses_feature_score' => true, 'uses_composite_score' => false,'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt, 'help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/methods/#schaefer-m-black-s-scheuer-l-2009');
//        (!$method->exists) ? $method->fill($data)->save() : $method->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name', '=', 'Metatarsal 3')->first()->id;
//		$method = Method::firstOrNew(['sb_id' => $sb_id, 'name' =>'Schaefer et al 2009', 'submethod' => '']);
//		$data = array('sb_id' => $sb_id, 'name' => 'Schaefer et al 2009', 'submethod' => '', 'type' => 'Age', 'reference' => 'Juvenile Osteology.  Elsevier.', 'description' => 'Age estimation based on various skeletal morphology', 'uses_feature_score' => true, 'uses_composite_score' => false,'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt, 'help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/methods/#schaefer-m-black-s-scheuer-l-2009');
//        (!$method->exists) ? $method->fill($data)->save() : $method->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name', '=', 'Metatarsal 4')->first()->id;
//		$method = Method::firstOrNew(['sb_id' => $sb_id, 'name' =>'Schaefer et al 2009', 'submethod' => '']);
//		$data = array('sb_id' => $sb_id, 'name' => 'Schaefer et al 2009', 'submethod' => '', 'type' => 'Age', 'reference' => 'Juvenile Osteology.  Elsevier.', 'description' => 'Age estimation based on various skeletal morphology', 'uses_feature_score' => true, 'uses_composite_score' => false,'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt, 'help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/methods/#schaefer-m-black-s-scheuer-l-2009');
//        (!$method->exists) ? $method->fill($data)->save() : $method->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name', '=', 'Metatarsal 5')->first()->id;
//        $method = Method::firstOrNew(['sb_id' => $sb_id, 'name' =>'Schaefer et al 2009', 'submethod' => '']);
//		$data = array('sb_id' => $sb_id, 'name' => 'Schaefer et al 2009', 'submethod' => '', 'type' => 'Age', 'reference' => 'Juvenile Osteology.  Elsevier.', 'description' => 'Age estimation based on various skeletal morphology', 'uses_feature_score' => true, 'uses_composite_score' => false,'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt, 'help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/methods/#schaefer-m-black-s-scheuer-l-2009');
//        (!$method->exists) ? $method->fill($data)->save() : $method->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name', '=', 'Nasal')->first()->id;
//		$method = Method::firstOrNew(['sb_id' => $sb_id, 'name' =>'Schaefer et al 2009', 'submethod' => '']);
//		$data = array('sb_id' => $sb_id, 'name' => 'Schaefer et al 2009', 'submethod' => '', 'type' => 'Age', 'reference' => 'Juvenile Osteology.  Elsevier.', 'description' => 'Age estimation based on various skeletal morphology', 'uses_feature_score' => true, 'uses_composite_score' => false,'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt, 'help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/methods/#schaefer-m-black-s-scheuer-l-2009');
//        (!$method->exists) ? $method->fill($data)->save() : $method->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name', '=', 'Navicular')->first()->id;
//        $method = Method::firstOrNew(['sb_id' => $sb_id, 'name' =>'Schaefer et al 2009', 'submethod' => '']);
//		$data = array('sb_id' => $sb_id, 'name' => 'Schaefer et al 2009', 'submethod' => '', 'type' => 'Age', 'reference' => 'Juvenile Osteology.  Elsevier.', 'description' => 'Age estimation based on various skeletal morphology', 'uses_feature_score' => true, 'uses_composite_score' => false,'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt, 'help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/methods/#schaefer-m-black-s-scheuer-l-2009');
//        (!$method->exists) ? $method->fill($data)->save() : $method->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name', '=', 'Occipital')->first()->id;
//		$method = Method::firstOrNew(['sb_id' => $sb_id, 'name' =>'Schaefer et al 2009', 'submethod' => '']);
//		$data = array('sb_id' => $sb_id, 'name' => 'Schaefer et al 2009', 'submethod' => '', 'type' => 'Age', 'reference' => 'Juvenile Osteology.  Elsevier.', 'description' => 'Age estimation based on various skeletal morphology', 'uses_feature_score' => true, 'uses_composite_score' => false,'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt, 'help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/methods/#schaefer-m-black-s-scheuer-l-2009');
//        (!$method->exists) ? $method->fill($data)->save() : $method->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name', '=', 'Os coxa')->first()->id;
//		$method = Method::firstOrNew(['sb_id' => $sb_id, 'name' =>'Schaefer et al 2009', 'submethod' => '']);
//		$data = array('sb_id' => $sb_id, 'name' => 'Schaefer et al 2009', 'submethod' => '', 'type' => 'Age', 'reference' => 'Juvenile Osteology.  Elsevier.', 'description' => 'Age estimation based on various skeletal morphology', 'uses_feature_score' => true, 'uses_composite_score' => false,'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt, 'help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/methods/#schaefer-m-black-s-scheuer-l-2009');
//        (!$method->exists) ? $method->fill($data)->save() : $method->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name', '=', 'Palatine')->first()->id;
//		$method = Method::firstOrNew(['sb_id' => $sb_id, 'name' =>'Schaefer et al 2009', 'submethod' => '']);
//		$data = array('sb_id' => $sb_id, 'name' => 'Schaefer et al 2009', 'submethod' => '', 'type' => 'Age', 'reference' => 'Juvenile Osteology.  Elsevier.', 'description' => 'Age estimation based on various skeletal morphology', 'uses_feature_score' => true, 'uses_composite_score' => false,'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt, 'help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/methods/#schaefer-m-black-s-scheuer-l-2009');
//        (!$method->exists) ? $method->fill($data)->save() : $method->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name', '=', 'Parietal')->first()->id;
//		$method = Method::firstOrNew(['sb_id' => $sb_id, 'name' =>'Schaefer et al 2009', 'submethod' => '']);
//		$data = array('sb_id' => $sb_id, 'name' => 'Schaefer et al 2009', 'submethod' => '', 'type' => 'Age', 'reference' => 'Juvenile Osteology.  Elsevier.', 'description' => 'Age estimation based on various skeletal morphology', 'uses_feature_score' => true, 'uses_composite_score' => false,'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt, 'help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/methods/#schaefer-m-black-s-scheuer-l-2009');
//        (!$method->exists) ? $method->fill($data)->save() : $method->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name', '=', 'Patella')->first()->id;
//		$method = Method::firstOrNew(['sb_id' => $sb_id, 'name' =>'Schaefer et al 2009', 'submethod' => '']);
//		$data = array('sb_id' => $sb_id, 'name' => 'Schaefer et al 2009', 'submethod' => '', 'type' => 'Age', 'reference' => 'Juvenile Osteology.  Elsevier.', 'description' => 'Age estimation based on various skeletal morphology', 'uses_feature_score' => true, 'uses_composite_score' => false,'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt, 'help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/methods/#schaefer-m-black-s-scheuer-l-2009');
//        (!$method->exists) ? $method->fill($data)->save() : $method->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name', '=', 'Pisiform')->first()->id;
//		$method = Method::firstOrNew(['sb_id' => $sb_id, 'name' =>'Schaefer et al 2009', 'submethod' => '']);
//		$data = array('sb_id' => $sb_id, 'name' => 'Schaefer et al 2009', 'submethod' => '', 'type' => 'Age', 'reference' => 'Juvenile Osteology.  Elsevier.', 'description' => 'Age estimation based on various skeletal morphology', 'uses_feature_score' => true, 'uses_composite_score' => false,'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt, 'help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/methods/#schaefer-m-black-s-scheuer-l-2009');
//        (!$method->exists) ? $method->fill($data)->save() : $method->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name', '=', 'Proximal manual phalanx 1')->first()->id;
//		$method = Method::firstOrNew(['sb_id' => $sb_id, 'name' =>'Schaefer et al 2009', 'submethod' => '']);
//		$data = array('sb_id' => $sb_id, 'name' => 'Schaefer et al 2009', 'submethod' => '', 'type' => 'Age', 'reference' => 'Juvenile Osteology.  Elsevier.', 'description' => 'Age estimation based on various skeletal morphology', 'uses_feature_score' => true, 'uses_composite_score' => false,'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt, 'help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/methods/#schaefer-m-black-s-scheuer-l-2009');
//        (!$method->exists) ? $method->fill($data)->save() : $method->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name', '=', 'Proximal manual phalanx 2')->first()->id;
//		$method = Method::firstOrNew(['sb_id' => $sb_id, 'name' =>'Schaefer et al 2009', 'submethod' => '']);
//		$data = array('sb_id' => $sb_id, 'name' => 'Schaefer et al 2009', 'submethod' => '', 'type' => 'Age', 'reference' => 'Juvenile Osteology.  Elsevier.', 'description' => 'Age estimation based on various skeletal morphology', 'uses_feature_score' => true, 'uses_composite_score' => false,'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt, 'help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/methods/#schaefer-m-black-s-scheuer-l-2009');
//        (!$method->exists) ? $method->fill($data)->save() : $method->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name', '=', 'Proximal manual phalanx 3')->first()->id;
//		$method = Method::firstOrNew(['sb_id' => $sb_id, 'name' =>'Schaefer et al 2009', 'submethod' => '']);
//		$data = array('sb_id' => $sb_id, 'name' => 'Schaefer et al 2009', 'submethod' => '', 'type' => 'Age', 'reference' => 'Juvenile Osteology.  Elsevier.', 'description' => 'Age estimation based on various skeletal morphology', 'uses_feature_score' => true, 'uses_composite_score' => false,'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt, 'help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/methods/#schaefer-m-black-s-scheuer-l-2009');
//        (!$method->exists) ? $method->fill($data)->save() : $method->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name', '=', 'Proximal manual phalanx 4')->first()->id;
//		$method = Method::firstOrNew(['sb_id' => $sb_id, 'name' =>'Schaefer et al 2009', 'submethod' => '']);
//		$data = array('sb_id' => $sb_id, 'name' => 'Schaefer et al 2009', 'submethod' => '', 'type' => 'Age', 'reference' => 'Juvenile Osteology.  Elsevier.', 'description' => 'Age estimation based on various skeletal morphology', 'uses_feature_score' => true, 'uses_composite_score' => false,'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt, 'help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/methods/#schaefer-m-black-s-scheuer-l-2009');
//        (!$method->exists) ? $method->fill($data)->save() : $method->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name', '=', 'Proximal manual phalanx 5')->first()->id;
//		$method = Method::firstOrNew(['sb_id' => $sb_id, 'name' =>'Schaefer et al 2009', 'submethod' => '']);
//		$data = array('sb_id' => $sb_id, 'name' => 'Schaefer et al 2009', 'submethod' => '', 'type' => 'Age', 'reference' => 'Juvenile Osteology.  Elsevier.', 'description' => 'Age estimation based on various skeletal morphology', 'uses_feature_score' => true, 'uses_composite_score' => false,'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt, 'help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/methods/#schaefer-m-black-s-scheuer-l-2009');
//        (!$method->exists) ? $method->fill($data)->save() : $method->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name', '=', 'Proximal pedal phalanx 1')->first()->id;
//		$method = Method::firstOrNew(['sb_id' => $sb_id, 'name' =>'Schaefer et al 2009', 'submethod' => '']);
//		$data = array('sb_id' => $sb_id, 'name' => 'Schaefer et al 2009', 'submethod' => '', 'type' => 'Age', 'reference' => 'Juvenile Osteology.  Elsevier.', 'description' => 'Age estimation based on various skeletal morphology', 'uses_feature_score' => true, 'uses_composite_score' => false,'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt, 'help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/methods/#schaefer-m-black-s-scheuer-l-2009');
//        (!$method->exists) ? $method->fill($data)->save() : $method->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name', '=', 'Proximal pedal phalanx 2')->first()->id;
//		$method = Method::firstOrNew(['sb_id' => $sb_id, 'name' =>'Schaefer et al 2009', 'submethod' => '']);
//		$data = array('sb_id' => $sb_id, 'name' => 'Schaefer et al 2009', 'submethod' => '', 'type' => 'Age', 'reference' => 'Juvenile Osteology.  Elsevier.', 'description' => 'Age estimation based on various skeletal morphology', 'uses_feature_score' => true, 'uses_composite_score' => false,'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt, 'help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/methods/#schaefer-m-black-s-scheuer-l-2009');
//        (!$method->exists) ? $method->fill($data)->save() : $method->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name', '=', 'Proximal pedal phalanx 3')->first()->id;
//		$method = Method::firstOrNew(['sb_id' => $sb_id, 'name' =>'Schaefer et al 2009', 'submethod' => '']);
//		$data = array('sb_id' => $sb_id, 'name' => 'Schaefer et al 2009', 'submethod' => '', 'type' => 'Age', 'reference' => 'Juvenile Osteology.  Elsevier.', 'description' => 'Age estimation based on various skeletal morphology', 'uses_feature_score' => true, 'uses_composite_score' => false,'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt, 'help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/methods/#schaefer-m-black-s-scheuer-l-2009');
//        (!$method->exists) ? $method->fill($data)->save() : $method->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name', '=', 'Proximal pedal phalanx 4')->first()->id;
//		$method = Method::firstOrNew(['sb_id' => $sb_id, 'name' =>'Schaefer et al 2009', 'submethod' => '']);
//		$data = array('sb_id' => $sb_id, 'name' => 'Schaefer et al 2009', 'submethod' => '', 'type' => 'Age', 'reference' => 'Juvenile Osteology.  Elsevier.', 'description' => 'Age estimation based on various skeletal morphology', 'uses_feature_score' => true, 'uses_composite_score' => false,'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt, 'help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/methods/#schaefer-m-black-s-scheuer-l-2009');
//        (!$method->exists) ? $method->fill($data)->save() : $method->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name', '=', 'Proximal pedal phalanx 5')->first()->id;
//		$method = Method::firstOrNew(['sb_id' => $sb_id, 'name' =>'Schaefer et al 2009', 'submethod' => '']);
//		$data = array('sb_id' => $sb_id, 'name' => 'Schaefer et al 2009', 'submethod' => '', 'type' => 'Age', 'reference' => 'Juvenile Osteology.  Elsevier.', 'description' => 'Age estimation based on various skeletal morphology', 'uses_feature_score' => true, 'uses_composite_score' => false,'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt, 'help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/methods/#schaefer-m-black-s-scheuer-l-2009');
//        (!$method->exists) ? $method->fill($data)->save() : $method->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name', '=', 'Radius')->first()->id;
//		$method = Method::firstOrNew(['sb_id' => $sb_id, 'name' =>'Schaefer et al 2009', 'submethod' => '']);
//		$data = array('sb_id' => $sb_id, 'name' => 'Schaefer et al 2009', 'submethod' => '', 'type' => 'Age', 'reference' => 'Juvenile Osteology.  Elsevier.', 'description' => 'Age estimation based on various skeletal morphology', 'uses_feature_score' => true, 'uses_composite_score' => false,'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt, 'help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/methods/#schaefer-m-black-s-scheuer-l-2009');
//        (!$method->exists) ? $method->fill($data)->save() : $method->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name', '=', 'Unseriated rib')->first()->id;
//		$method = Method::firstOrNew(['sb_id' => $sb_id, 'name' =>'Schaefer et al 2009', 'submethod' => '']);
//		$data = array('sb_id' => $sb_id, 'name' => 'Schaefer et al 2009', 'submethod' => '', 'type' => 'Age', 'reference' => 'Juvenile Osteology.  Elsevier.', 'description' => 'Age estimation based on various skeletal morphology', 'uses_feature_score' => true, 'uses_composite_score' => false,'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt, 'help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/methods/#schaefer-m-black-s-scheuer-l-2009');
//        (!$method->exists) ? $method->fill($data)->save() : $method->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name', '=', 'Rib 1')->first()->id;
//		$method = Method::firstOrNew(['sb_id' => $sb_id, 'name' =>'Schaefer et al 2009', 'submethod' => '']);
//		$data = array('sb_id' => $sb_id, 'name' => 'Schaefer et al 2009', 'submethod' => '', 'type' => 'Age', 'reference' => 'Juvenile Osteology.  Elsevier.', 'description' => 'Age estimation based on various skeletal morphology', 'uses_feature_score' => true, 'uses_composite_score' => false,'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt, 'help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/methods/#schaefer-m-black-s-scheuer-l-2009');
//        (!$method->exists) ? $method->fill($data)->save() : $method->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name', '=', 'Rib 10')->first()->id;
//		$method = Method::firstOrNew(['sb_id' => $sb_id, 'name' =>'Schaefer et al 2009', 'submethod' => '']);
//		$data = array('sb_id' => $sb_id, 'name' => 'Schaefer et al 2009', 'submethod' => '', 'type' => 'Age', 'reference' => 'Juvenile Osteology.  Elsevier.', 'description' => 'Age estimation based on various skeletal morphology', 'uses_feature_score' => true, 'uses_composite_score' => false,'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt, 'help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/methods/#schaefer-m-black-s-scheuer-l-2009');
//        (!$method->exists) ? $method->fill($data)->save() : $method->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name', '=', 'Rib 10/11')->first()->id;
//		$method = Method::firstOrNew(['sb_id' => $sb_id, 'name' =>'Schaefer et al 2009', 'submethod' => '']);
//		$data = array('sb_id' => $sb_id, 'name' => 'Schaefer et al 2009', 'submethod' => '', 'type' => 'Age', 'reference' => 'Juvenile Osteology.  Elsevier.', 'description' => 'Age estimation based on various skeletal morphology', 'uses_feature_score' => true, 'uses_composite_score' => false,'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt, 'help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/methods/#schaefer-m-black-s-scheuer-l-2009');
//        (!$method->exists) ? $method->fill($data)->save() : $method->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name', '=', 'Rib 11')->first()->id;
//		$method = Method::firstOrNew(['sb_id' => $sb_id, 'name' =>'Schaefer et al 2009', 'submethod' => '']);
//		$data = array('sb_id' => $sb_id, 'name' => 'Schaefer et al 2009', 'submethod' => '', 'type' => 'Age', 'reference' => 'Juvenile Osteology.  Elsevier.', 'description' => 'Age estimation based on various skeletal morphology', 'uses_feature_score' => true, 'uses_composite_score' => false,'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt, 'help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/methods/#schaefer-m-black-s-scheuer-l-2009');
//        (!$method->exists) ? $method->fill($data)->save() : $method->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name', '=', 'Rib 11/12')->first()->id;
//		$method = Method::firstOrNew(['sb_id' => $sb_id, 'name' =>'Schaefer et al 2009', 'submethod' => '']);
//		$data = array('sb_id' => $sb_id, 'name' => 'Schaefer et al 2009', 'submethod' => '', 'type' => 'Age', 'reference' => 'Juvenile Osteology.  Elsevier.', 'description' => 'Age estimation based on various skeletal morphology', 'uses_feature_score' => true, 'uses_composite_score' => false,'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt, 'help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/methods/#schaefer-m-black-s-scheuer-l-2009');
//        (!$method->exists) ? $method->fill($data)->save() : $method->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name', '=', 'Rib 12')->first()->id;
//		$method = Method::firstOrNew(['sb_id' => $sb_id, 'name' =>'Schaefer et al 2009', 'submethod' => '']);
//		$data = array('sb_id' => $sb_id, 'name' => 'Schaefer et al 2009', 'submethod' => '', 'type' => 'Age', 'reference' => 'Juvenile Osteology.  Elsevier.', 'description' => 'Age estimation based on various skeletal morphology', 'uses_feature_score' => true, 'uses_composite_score' => false,'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt, 'help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/methods/#schaefer-m-black-s-scheuer-l-2009');
//        (!$method->exists) ? $method->fill($data)->save() : $method->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name', '=', 'Rib 2')->first()->id;
//		$method = Method::firstOrNew(['sb_id' => $sb_id, 'name' =>'Schaefer et al 2009', 'submethod' => '']);
//		$data = array('sb_id' => $sb_id, 'name' => 'Schaefer et al 2009', 'submethod' => '', 'type' => 'Age', 'reference' => 'Juvenile Osteology.  Elsevier.', 'description' => 'Age estimation based on various skeletal morphology', 'uses_feature_score' => true, 'uses_composite_score' => false,'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt, 'help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/methods/#schaefer-m-black-s-scheuer-l-2009');
//        (!$method->exists) ? $method->fill($data)->save() : $method->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name', '=', 'Rib 2/3')->first()->id;
//		$method = Method::firstOrNew(['sb_id' => $sb_id, 'name' =>'Schaefer et al 2009', 'submethod' => '']);
//		$data = array('sb_id' => $sb_id, 'name' => 'Schaefer et al 2009', 'submethod' => '', 'type' => 'Age', 'reference' => 'Juvenile Osteology.  Elsevier.', 'description' => 'Age estimation based on various skeletal morphology', 'uses_feature_score' => true, 'uses_composite_score' => false,'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt, 'help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/methods/#schaefer-m-black-s-scheuer-l-2009');
//        (!$method->exists) ? $method->fill($data)->save() : $method->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name', '=', 'Rib 3')->first()->id;
//		$method = Method::firstOrNew(['sb_id' => $sb_id, 'name' =>'Schaefer et al 2009', 'submethod' => '']);
//		$data = array('sb_id' => $sb_id, 'name' => 'Schaefer et al 2009', 'submethod' => '', 'type' => 'Age', 'reference' => 'Juvenile Osteology.  Elsevier.', 'description' => 'Age estimation based on various skeletal morphology', 'uses_feature_score' => true, 'uses_composite_score' => false,'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt, 'help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/methods/#schaefer-m-black-s-scheuer-l-2009');
//        (!$method->exists) ? $method->fill($data)->save() : $method->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name', '=', 'Rib 3/4')->first()->id;
//		$method = Method::firstOrNew(['sb_id' => $sb_id, 'name' =>'Schaefer et al 2009', 'submethod' => '']);
//		$data = array('sb_id' => $sb_id, 'name' => 'Schaefer et al 2009', 'submethod' => '', 'type' => 'Age', 'reference' => 'Juvenile Osteology.  Elsevier.', 'description' => 'Age estimation based on various skeletal morphology', 'uses_feature_score' => true, 'uses_composite_score' => false,'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt, 'help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/methods/#schaefer-m-black-s-scheuer-l-2009');
//        (!$method->exists) ? $method->fill($data)->save() : $method->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name', '=', 'Rib 4')->first()->id;
//		$method = Method::firstOrNew(['sb_id' => $sb_id, 'name' =>'Schaefer et al 2009', 'submethod' => '']);
//		$data = array('sb_id' => $sb_id, 'name' => 'Schaefer et al 2009', 'submethod' => '', 'type' => 'Age', 'reference' => 'Juvenile Osteology.  Elsevier.', 'description' => 'Age estimation based on various skeletal morphology', 'uses_feature_score' => true, 'uses_composite_score' => false,'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt, 'help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/methods/#schaefer-m-black-s-scheuer-l-2009');
//        (!$method->exists) ? $method->fill($data)->save() : $method->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name', '=', 'Rib 5')->first()->id;
//		$method = Method::firstOrNew(['sb_id' => $sb_id, 'name' =>'Schaefer et al 2009', 'submethod' => '']);
//		$data = array('sb_id' => $sb_id, 'name' => 'Schaefer et al 2009', 'submethod' => '', 'type' => 'Age', 'reference' => 'Juvenile Osteology.  Elsevier.', 'description' => 'Age estimation based on various skeletal morphology', 'uses_feature_score' => true, 'uses_composite_score' => false,'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt, 'help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/methods/#schaefer-m-black-s-scheuer-l-2009');
//        (!$method->exists) ? $method->fill($data)->save() : $method->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name', '=', 'Rib 6')->first()->id;
//		$method = Method::firstOrNew(['sb_id' => $sb_id, 'name' =>'Schaefer et al 2009', 'submethod' => '']);
//		$data = array('sb_id' => $sb_id, 'name' => 'Schaefer et al 2009', 'submethod' => '', 'type' => 'Age', 'reference' => 'Juvenile Osteology.  Elsevier.', 'description' => 'Age estimation based on various skeletal morphology', 'uses_feature_score' => true, 'uses_composite_score' => false,'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt, 'help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/methods/#schaefer-m-black-s-scheuer-l-2009');
//        (!$method->exists) ? $method->fill($data)->save() : $method->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name', '=', 'Rib 7')->first()->id;
//		$method = Method::firstOrNew(['sb_id' => $sb_id, 'name' =>'Schaefer et al 2009', 'submethod' => '']);
//		$data = array('sb_id' => $sb_id, 'name' => 'Schaefer et al 2009', 'submethod' => '', 'type' => 'Age', 'reference' => 'Juvenile Osteology.  Elsevier.', 'description' => 'Age estimation based on various skeletal morphology', 'uses_feature_score' => true, 'uses_composite_score' => false,'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt, 'help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/methods/#schaefer-m-black-s-scheuer-l-2009');
//        (!$method->exists) ? $method->fill($data)->save() : $method->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name', '=', 'Rib 8')->first()->id;
//		$method = Method::firstOrNew(['sb_id' => $sb_id, 'name' =>'Schaefer et al 2009', 'submethod' => '']);
//		$data = array('sb_id' => $sb_id, 'name' => 'Schaefer et al 2009', 'submethod' => '', 'type' => 'Age', 'reference' => 'Juvenile Osteology.  Elsevier.', 'description' => 'Age estimation based on various skeletal morphology', 'uses_feature_score' => true, 'uses_composite_score' => false,'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt, 'help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/methods/#schaefer-m-black-s-scheuer-l-2009');
//        (!$method->exists) ? $method->fill($data)->save() : $method->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name', '=', 'Rib 9')->first()->id;
//		$method = Method::firstOrNew(['sb_id' => $sb_id, 'name' =>'Schaefer et al 2009', 'submethod' => '']);
//		$data = array('sb_id' => $sb_id, 'name' => 'Schaefer et al 2009', 'submethod' => '', 'type' => 'Age', 'reference' => 'Juvenile Osteology.  Elsevier.', 'description' => 'Age estimation based on various skeletal morphology', 'uses_feature_score' => true, 'uses_composite_score' => false,'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt, 'help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/methods/#schaefer-m-black-s-scheuer-l-2009');
//        (!$method->exists) ? $method->fill($data)->save() : $method->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name', '=', 'Sacral vertebra 1')->first()->id;
//		$method = Method::firstOrNew(['sb_id' => $sb_id, 'name' =>'Schaefer et al 2009', 'submethod' => '']);
//		$data = array('sb_id' => $sb_id, 'name' => 'Schaefer et al 2009', 'submethod' => '', 'type' => 'Age', 'reference' => 'Juvenile Osteology.  Elsevier.', 'description' => 'Age estimation based on various skeletal morphology', 'uses_feature_score' => true, 'uses_composite_score' => false,'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt, 'help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/methods/#schaefer-m-black-s-scheuer-l-2009');
//        (!$method->exists) ? $method->fill($data)->save() : $method->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name', '=', 'Sacral vertebra 2')->first()->id;
//		$method = Method::firstOrNew(['sb_id' => $sb_id, 'name' =>'Schaefer et al 2009', 'submethod' => '']);
//		$data = array('sb_id' => $sb_id, 'name' => 'Schaefer et al 2009', 'submethod' => '', 'type' => 'Age', 'reference' => 'Juvenile Osteology.  Elsevier.', 'description' => 'Age estimation based on various skeletal morphology', 'uses_feature_score' => true, 'uses_composite_score' => false,'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt, 'help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/methods/#schaefer-m-black-s-scheuer-l-2009');
//        (!$method->exists) ? $method->fill($data)->save() : $method->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name', '=', 'Sacral vertebra 3')->first()->id;
//		$method = Method::firstOrNew(['sb_id' => $sb_id, 'name' =>'Schaefer et al 2009', 'submethod' => '']);
//		$data = array('sb_id' => $sb_id, 'name' => 'Schaefer et al 2009', 'submethod' => '', 'type' => 'Age', 'reference' => 'Juvenile Osteology.  Elsevier.', 'description' => 'Age estimation based on various skeletal morphology', 'uses_feature_score' => true, 'uses_composite_score' => false,'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt, 'help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/methods/#schaefer-m-black-s-scheuer-l-2009');
//        (!$method->exists) ? $method->fill($data)->save() : $method->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name', '=', 'Sacral vertebra 4')->first()->id;
//		$method = Method::firstOrNew(['sb_id' => $sb_id, 'name' =>'Schaefer et al 2009', 'submethod' => '']);
//		$data = array('sb_id' => $sb_id, 'name' => 'Schaefer et al 2009', 'submethod' => '', 'type' => 'Age', 'reference' => 'Juvenile Osteology.  Elsevier.', 'description' => 'Age estimation based on various skeletal morphology', 'uses_feature_score' => true, 'uses_composite_score' => false,'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt, 'help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/methods/#schaefer-m-black-s-scheuer-l-2009');
//        (!$method->exists) ? $method->fill($data)->save() : $method->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name', '=', 'Sacral vertebra 5')->first()->id;
//        $method = Method::firstOrNew(['sb_id' => $sb_id, 'name' =>'Schaefer et al 2009', 'submethod' => '']);
//		$data = array('sb_id' => $sb_id, 'name' => 'Schaefer et al 2009', 'submethod' => '', 'type' => 'Age', 'reference' => 'Juvenile Osteology.  Elsevier.', 'description' => 'Age estimation based on various skeletal morphology', 'uses_feature_score' => true, 'uses_composite_score' => false,'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt, 'help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/methods/#schaefer-m-black-s-scheuer-l-2009');
//        (!$method->exists) ? $method->fill($data)->save() : $method->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name', '=', 'Sacrum')->first()->id;
//		$method = Method::firstOrNew(['sb_id' => $sb_id, 'name' =>'Schaefer et al 2009', 'submethod' => '']);
//		$data = array('sb_id' => $sb_id, 'name' => 'Schaefer et al 2009', 'submethod' => '', 'type' => 'Age', 'reference' => 'Juvenile Osteology.  Elsevier.', 'description' => 'Age estimation based on various skeletal morphology', 'uses_feature_score' => true, 'uses_composite_score' => false,'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt, 'help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/methods/#schaefer-m-black-s-scheuer-l-2009');
//        (!$method->exists) ? $method->fill($data)->save() : $method->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name', '=', 'Scaphoid')->first()->id;
//		$method = Method::firstOrNew(['sb_id' => $sb_id, 'name' =>'Schaefer et al 2009', 'submethod' => '']);
//		$data = array('sb_id' => $sb_id, 'name' => 'Schaefer et al 2009', 'submethod' => '', 'type' => 'Age', 'reference' => 'Juvenile Osteology.  Elsevier.', 'description' => 'Age estimation based on various skeletal morphology', 'uses_feature_score' => true, 'uses_composite_score' => false,'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt, 'help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/methods/#schaefer-m-black-s-scheuer-l-2009');
//        (!$method->exists) ? $method->fill($data)->save() : $method->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name', '=', 'Scapula')->first()->id;
//		$method = Method::firstOrNew(['sb_id' => $sb_id, 'name' =>'Schaefer et al 2009', 'submethod' => '']);
//		$data = array('sb_id' => $sb_id, 'name' => 'Schaefer et al 2009', 'submethod' => '', 'type' => 'Age', 'reference' => 'Juvenile Osteology.  Elsevier.', 'description' => 'Age estimation based on various skeletal morphology', 'uses_feature_score' => true, 'uses_composite_score' => false,'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt, 'help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/methods/#schaefer-m-black-s-scheuer-l-2009');
//        (!$method->exists) ? $method->fill($data)->save() : $method->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name', '=', 'Second (Intermediate) cuneiform')->first()->id;
//		$method = Method::firstOrNew(['sb_id' => $sb_id, 'name' =>'Schaefer et al 2009', 'submethod' => '']);
//		$data = array('sb_id' => $sb_id, 'name' => 'Schaefer et al 2009', 'submethod' => '', 'type' => 'Age', 'reference' => 'Juvenile Osteology.  Elsevier.', 'description' => 'Age estimation based on various skeletal morphology', 'uses_feature_score' => true, 'uses_composite_score' => false,'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt, 'help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/methods/#schaefer-m-black-s-scheuer-l-2009');
//        (!$method->exists) ? $method->fill($data)->save() : $method->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name', '=', 'Sphenoid')->first()->id;
//		$method = Method::firstOrNew(['sb_id' => $sb_id, 'name' =>'Schaefer et al 2009', 'submethod' => '']);
//		$data = array('sb_id' => $sb_id, 'name' => 'Schaefer et al 2009', 'submethod' => '', 'type' => 'Age', 'reference' => 'Juvenile Osteology.  Elsevier.', 'description' => 'Age estimation based on various skeletal morphology', 'uses_feature_score' => true, 'uses_composite_score' => false,'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt, 'help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/methods/#schaefer-m-black-s-scheuer-l-2009');
//        (!$method->exists) ? $method->fill($data)->save() : $method->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name', '=', 'Sternal body')->first()->id;
//		$method = Method::firstOrNew(['sb_id' => $sb_id, 'name' =>'Schaefer et al 2009', 'submethod' => '']);
//		$data = array('sb_id' => $sb_id, 'name' => 'Schaefer et al 2009', 'submethod' => '', 'type' => 'Age', 'reference' => 'Juvenile Osteology.  Elsevier.', 'description' => 'Age estimation based on various skeletal morphology', 'uses_feature_score' => true, 'uses_composite_score' => false,'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt, 'help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/methods/#schaefer-m-black-s-scheuer-l-2009');
//        (!$method->exists) ? $method->fill($data)->save() : $method->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name', '=', 'Sternum')->first()->id;
//		$method = Method::firstOrNew(['sb_id' => $sb_id, 'name' =>'Schaefer et al 2009', 'submethod' => '']);
//		$data = array('sb_id' => $sb_id, 'name' => 'Schaefer et al 2009', 'submethod' => '', 'type' => 'Age', 'reference' => 'Juvenile Osteology.  Elsevier.', 'description' => 'Age estimation based on various skeletal morphology', 'uses_feature_score' => true, 'uses_composite_score' => false,'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt, 'help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/methods/#schaefer-m-black-s-scheuer-l-2009');
//        (!$method->exists) ? $method->fill($data)->save() : $method->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name', '=', 'Talus')->first()->id;
//		$method = Method::firstOrNew(['sb_id' => $sb_id, 'name' =>'Schaefer et al 2009', 'submethod' => '']);
//		$data = array('sb_id' => $sb_id, 'name' => 'Schaefer et al 2009', 'submethod' => '', 'type' => 'Age', 'reference' => 'Juvenile Osteology.  Elsevier.', 'description' => 'Age estimation based on various skeletal morphology', 'uses_feature_score' => true, 'uses_composite_score' => false,'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt, 'help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/methods/#schaefer-m-black-s-scheuer-l-2009');
//        (!$method->exists) ? $method->fill($data)->save() : $method->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name', '=', 'Temporal')->first()->id;
//        $method = Method::firstOrNew(['sb_id' => $sb_id, 'name' =>'Schaefer et al 2009', 'submethod' => '']);
//		$data = array('sb_id' => $sb_id, 'name' => 'Schaefer et al 2009', 'submethod' => '', 'type' => 'Age', 'reference' => 'Juvenile Osteology.  Elsevier.', 'description' => 'Age estimation based on various skeletal morphology', 'uses_feature_score' => true, 'uses_composite_score' => false,'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt, 'help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/methods/#schaefer-m-black-s-scheuer-l-2009');
//        (!$method->exists) ? $method->fill($data)->save() : $method->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name', '=', 'Third (Lateral) cuneiform')->first()->id;
//		$method = Method::firstOrNew(['sb_id' => $sb_id, 'name' =>'Schaefer et al 2009', 'submethod' => '']);
//		$data = array('sb_id' => $sb_id, 'name' => 'Schaefer et al 2009', 'submethod' => '', 'type' => 'Age', 'reference' => 'Juvenile Osteology.  Elsevier.', 'description' => 'Age estimation based on various skeletal morphology', 'uses_feature_score' => true, 'uses_composite_score' => false,'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt, 'help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/methods/#schaefer-m-black-s-scheuer-l-2009');
//        (!$method->exists) ? $method->fill($data)->save() : $method->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name', '=', 'Thoracic vertebra 1')->first()->id;
//		$method = Method::firstOrNew(['sb_id' => $sb_id, 'name' =>'Schaefer et al 2009', 'submethod' => '']);
//		$data = array('sb_id' => $sb_id, 'name' => 'Schaefer et al 2009', 'submethod' => '', 'type' => 'Age', 'reference' => 'Juvenile Osteology.  Elsevier.', 'description' => 'Age estimation based on various skeletal morphology', 'uses_feature_score' => true, 'uses_composite_score' => false,'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt, 'help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/methods/#schaefer-m-black-s-scheuer-l-2009');
//        (!$method->exists) ? $method->fill($data)->save() : $method->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name', '=', 'Thoracic vertebra 1/2')->first()->id;
//		$method = Method::firstOrNew(['sb_id' => $sb_id, 'name' =>'Schaefer et al 2009', 'submethod' => '']);
//		$data = array('sb_id' => $sb_id, 'name' => 'Schaefer et al 2009', 'submethod' => '', 'type' => 'Age', 'reference' => 'Juvenile Osteology.  Elsevier.', 'description' => 'Age estimation based on various skeletal morphology', 'uses_feature_score' => true, 'uses_composite_score' => false,'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt, 'help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/methods/#schaefer-m-black-s-scheuer-l-2009');
//        (!$method->exists) ? $method->fill($data)->save() : $method->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name', '=', 'Thoracic vertebra 10')->first()->id;
//		$method = Method::firstOrNew(['sb_id' => $sb_id, 'name' =>'Schaefer et al 2009', 'submethod' => '']);
//		$data = array('sb_id' => $sb_id, 'name' => 'Schaefer et al 2009', 'submethod' => '', 'type' => 'Age', 'reference' => 'Juvenile Osteology.  Elsevier.', 'description' => 'Age estimation based on various skeletal morphology', 'uses_feature_score' => true, 'uses_composite_score' => false,'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt, 'help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/methods/#schaefer-m-black-s-scheuer-l-2009');
//        (!$method->exists) ? $method->fill($data)->save() : $method->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name', '=', 'Thoracic vertebra 10/11')->first()->id;
//		$method = Method::firstOrNew(['sb_id' => $sb_id, 'name' =>'Schaefer et al 2009', 'submethod' => '']);
//		$data = array('sb_id' => $sb_id, 'name' => 'Schaefer et al 2009', 'submethod' => '', 'type' => 'Age', 'reference' => 'Juvenile Osteology.  Elsevier.', 'description' => 'Age estimation based on various skeletal morphology', 'uses_feature_score' => true, 'uses_composite_score' => false,'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt, 'help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/methods/#schaefer-m-black-s-scheuer-l-2009');
//        (!$method->exists) ? $method->fill($data)->save() : $method->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name', '=', 'Thoracic vertebra 10/11/12')->first()->id;
//		$method = Method::firstOrNew(['sb_id' => $sb_id, 'name' =>'Schaefer et al 2009', 'submethod' => '']);
//		$data = array('sb_id' => $sb_id, 'name' => 'Schaefer et al 2009', 'submethod' => '', 'type' => 'Age', 'reference' => 'Juvenile Osteology.  Elsevier.', 'description' => 'Age estimation based on various skeletal morphology', 'uses_feature_score' => true, 'uses_composite_score' => false,'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt, 'help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/methods/#schaefer-m-black-s-scheuer-l-2009');
//        (!$method->exists) ? $method->fill($data)->save() : $method->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name', '=', 'Thoracic vertebra 11')->first()->id;
//		$method = Method::firstOrNew(['sb_id' => $sb_id, 'name' =>'Schaefer et al 2009', 'submethod' => '']);
//		$data = array('sb_id' => $sb_id, 'name' => 'Schaefer et al 2009', 'submethod' => '', 'type' => 'Age', 'reference' => 'Juvenile Osteology.  Elsevier.', 'description' => 'Age estimation based on various skeletal morphology', 'uses_feature_score' => true, 'uses_composite_score' => false,'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt, 'help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/methods/#schaefer-m-black-s-scheuer-l-2009');
//        (!$method->exists) ? $method->fill($data)->save() : $method->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name', '=', 'Thoracic vertebra 11/12')->first()->id;
//        $method = Method::firstOrNew(['sb_id' => $sb_id, 'name' =>'Schaefer et al 2009', 'submethod' => '']);
//		$data = array('sb_id' => $sb_id, 'name' => 'Schaefer et al 2009', 'submethod' => '', 'type' => 'Age', 'reference' => 'Juvenile Osteology.  Elsevier.', 'description' => 'Age estimation based on various skeletal morphology', 'uses_feature_score' => true, 'uses_composite_score' => false,'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt, 'help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/methods/#schaefer-m-black-s-scheuer-l-2009');
//        (!$method->exists) ? $method->fill($data)->save() : $method->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name', '=', 'Thoracic vertebra 12')->first()->id;
//		$method = Method::firstOrNew(['sb_id' => $sb_id, 'name' =>'Schaefer et al 2009', 'submethod' => '']);
//		$data = array('sb_id' => $sb_id, 'name' => 'Schaefer et al 2009', 'submethod' => '', 'type' => 'Age', 'reference' => 'Juvenile Osteology.  Elsevier.', 'description' => 'Age estimation based on various skeletal morphology', 'uses_feature_score' => true, 'uses_composite_score' => false,'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt, 'help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/methods/#schaefer-m-black-s-scheuer-l-2009');
//        (!$method->exists) ? $method->fill($data)->save() : $method->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name', '=', 'Thoracic vertebra 2')->first()->id;
//        $method = Method::firstOrNew(['sb_id' => $sb_id, 'name' =>'Schaefer et al 2009', 'submethod' => '']);
//		$data = array('sb_id' => $sb_id, 'name' => 'Schaefer et al 2009', 'submethod' => '', 'type' => 'Age', 'reference' => 'Juvenile Osteology.  Elsevier.', 'description' => 'Age estimation based on various skeletal morphology', 'uses_feature_score' => true, 'uses_composite_score' => false,'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt, 'help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/methods/#schaefer-m-black-s-scheuer-l-2009');
//        (!$method->exists) ? $method->fill($data)->save() : $method->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name', '=', 'Thoracic vertebra 3')->first()->id;
//		$method = Method::firstOrNew(['sb_id' => $sb_id, 'name' =>'Schaefer et al 2009', 'submethod' => '']);
//		$data = array('sb_id' => $sb_id, 'name' => 'Schaefer et al 2009', 'submethod' => '', 'type' => 'Age', 'reference' => 'Juvenile Osteology.  Elsevier.', 'description' => 'Age estimation based on various skeletal morphology', 'uses_feature_score' => true, 'uses_composite_score' => false,'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt, 'help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/methods/#schaefer-m-black-s-scheuer-l-2009');
//        (!$method->exists) ? $method->fill($data)->save() : $method->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name', '=', 'Thoracic vertebra 4')->first()->id;
//		$method = Method::firstOrNew(['sb_id' => $sb_id, 'name' =>'Schaefer et al 2009', 'submethod' => '']);
//		$data = array('sb_id' => $sb_id, 'name' => 'Schaefer et al 2009', 'submethod' => '', 'type' => 'Age', 'reference' => 'Juvenile Osteology.  Elsevier.', 'description' => 'Age estimation based on various skeletal morphology', 'uses_feature_score' => true, 'uses_composite_score' => false,'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt, 'help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/methods/#schaefer-m-black-s-scheuer-l-2009');
//        (!$method->exists) ? $method->fill($data)->save() : $method->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name', '=', 'Thoracic vertebra 5')->first()->id;
//		$method = Method::firstOrNew(['sb_id' => $sb_id, 'name' =>'Schaefer et al 2009', 'submethod' => '']);
//		$data = array('sb_id' => $sb_id, 'name' => 'Schaefer et al 2009', 'submethod' => '', 'type' => 'Age', 'reference' => 'Juvenile Osteology.  Elsevier.', 'description' => 'Age estimation based on various skeletal morphology', 'uses_feature_score' => true, 'uses_composite_score' => false,'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt, 'help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/methods/#schaefer-m-black-s-scheuer-l-2009');
//        (!$method->exists) ? $method->fill($data)->save() : $method->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name', '=', 'Thoracic vertebra 6')->first()->id;
//		$method = Method::firstOrNew(['sb_id' => $sb_id, 'name' =>'Schaefer et al 2009', 'submethod' => '']);
//		$data = array('sb_id' => $sb_id, 'name' => 'Schaefer et al 2009', 'submethod' => '', 'type' => 'Age', 'reference' => 'Juvenile Osteology.  Elsevier.', 'description' => 'Age estimation based on various skeletal morphology', 'uses_feature_score' => true, 'uses_composite_score' => false,'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt, 'help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/methods/#schaefer-m-black-s-scheuer-l-2009');
//        (!$method->exists) ? $method->fill($data)->save() : $method->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name', '=', 'Thoracic vertebra 7')->first()->id;
//		$method = Method::firstOrNew(['sb_id' => $sb_id, 'name' =>'Schaefer et al 2009', 'submethod' => '']);
//		$data = array('sb_id' => $sb_id, 'name' => 'Schaefer et al 2009', 'submethod' => '', 'type' => 'Age', 'reference' => 'Juvenile Osteology.  Elsevier.', 'description' => 'Age estimation based on various skeletal morphology', 'uses_feature_score' => true, 'uses_composite_score' => false,'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt, 'help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/methods/#schaefer-m-black-s-scheuer-l-2009');
//        (!$method->exists) ? $method->fill($data)->save() : $method->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name', '=', 'Thoracic vertebra 8')->first()->id;
//		$method = Method::firstOrNew(['sb_id' => $sb_id, 'name' =>'Schaefer et al 2009', 'submethod' => '']);
//		$data = array('sb_id' => $sb_id, 'name' => 'Schaefer et al 2009', 'submethod' => '', 'type' => 'Age', 'reference' => 'Juvenile Osteology.  Elsevier.', 'description' => 'Age estimation based on various skeletal morphology', 'uses_feature_score' => true, 'uses_composite_score' => false,'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt, 'help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/methods/#schaefer-m-black-s-scheuer-l-2009');
//        (!$method->exists) ? $method->fill($data)->save() : $method->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name', '=', 'Thoracic vertebra 9')->first()->id;
//		$method = Method::firstOrNew(['sb_id' => $sb_id, 'name' =>'Schaefer et al 2009', 'submethod' => '']);
//		$data = array('sb_id' => $sb_id, 'name' => 'Schaefer et al 2009', 'submethod' => '', 'type' => 'Age', 'reference' => 'Juvenile Osteology.  Elsevier.', 'description' => 'Age estimation based on various skeletal morphology', 'uses_feature_score' => true, 'uses_composite_score' => false,'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt, 'help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/methods/#schaefer-m-black-s-scheuer-l-2009');
//        (!$method->exists) ? $method->fill($data)->save() : $method->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name', '=', 'Tibia')->first()->id;
//		$method = Method::firstOrNew(['sb_id' => $sb_id, 'name' =>'Schaefer et al 2009', 'submethod' => '']);
//		$data = array('sb_id' => $sb_id, 'name' => 'Schaefer et al 2009', 'submethod' => '', 'type' => 'Age', 'reference' => 'Juvenile Osteology.  Elsevier.', 'description' => 'Age estimation based on various skeletal morphology', 'uses_feature_score' => true, 'uses_composite_score' => false,'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt, 'help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/methods/#schaefer-m-black-s-scheuer-l-2009');
//        (!$method->exists) ? $method->fill($data)->save() : $method->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name', '=', 'Trapezium')->first()->id;
//		$method = Method::firstOrNew(['sb_id' => $sb_id, 'name' =>'Schaefer et al 2009', 'submethod' => '']);
//		$data = array('sb_id' => $sb_id, 'name' => 'Schaefer et al 2009', 'submethod' => '', 'type' => 'Age', 'reference' => 'Juvenile Osteology.  Elsevier.', 'description' => 'Age estimation based on various skeletal morphology', 'uses_feature_score' => true, 'uses_composite_score' => false,'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt, 'help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/methods/#schaefer-m-black-s-scheuer-l-2009');
//        (!$method->exists) ? $method->fill($data)->save() : $method->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name', '=', 'Trapezoid')->first()->id;
//		$method = Method::firstOrNew(['sb_id' => $sb_id, 'name' =>'Schaefer et al 2009', 'submethod' => '']);
//		$data = array('sb_id' => $sb_id, 'name' => 'Schaefer et al 2009', 'submethod' => '', 'type' => 'Age', 'reference' => 'Juvenile Osteology.  Elsevier.', 'description' => 'Age estimation based on various skeletal morphology', 'uses_feature_score' => true, 'uses_composite_score' => false,'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt, 'help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/methods/#schaefer-m-black-s-scheuer-l-2009');
//        (!$method->exists) ? $method->fill($data)->save() : $method->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name', '=', 'Triquetral')->first()->id;
//		$method = Method::firstOrNew(['sb_id' => $sb_id, 'name' =>'Schaefer et al 2009', 'submethod' => '']);
//		$data = array('sb_id' => $sb_id, 'name' => 'Schaefer et al 2009', 'submethod' => '', 'type' => 'Age', 'reference' => 'Juvenile Osteology.  Elsevier.', 'description' => 'Age estimation based on various skeletal morphology', 'uses_feature_score' => true, 'uses_composite_score' => false,'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt, 'help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/methods/#schaefer-m-black-s-scheuer-l-2009');
//        (!$method->exists) ? $method->fill($data)->save() : $method->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name', '=', 'Ulna')->first()->id;
//		$method = Method::firstOrNew(['sb_id' => $sb_id, 'name' =>'Schaefer et al 2009', 'submethod' => '']);
//		$data = array('sb_id' => $sb_id, 'name' => 'Schaefer et al 2009', 'submethod' => '', 'type' => 'Age', 'reference' => 'Juvenile Osteology.  Elsevier.', 'description' => 'Age estimation based on various skeletal morphology', 'uses_feature_score' => true, 'uses_composite_score' => false,'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt, 'help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/methods/#schaefer-m-black-s-scheuer-l-2009');
//        (!$method->exists) ? $method->fill($data)->save() : $method->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name', '=', 'Unseriated cervical vertebra')->first()->id;
//        $method = Method::firstOrNew(['sb_id' => $sb_id, 'name' =>'Schaefer et al 2009', 'submethod' => '']);
//		$data = array('sb_id' => $sb_id, 'name' => 'Schaefer et al 2009', 'submethod' => '', 'type' => 'Age', 'reference' => 'Juvenile Osteology.  Elsevier.', 'description' => 'Age estimation based on various skeletal morphology', 'uses_feature_score' => true, 'uses_composite_score' => false,'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt, 'help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/methods/#schaefer-m-black-s-scheuer-l-2009');
//        (!$method->exists) ? $method->fill($data)->save() : $method->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name', '=', 'Unseriated distal manual phalanx')->first()->id;
//		$method = Method::firstOrNew(['sb_id' => $sb_id, 'name' =>'Schaefer et al 2009', 'submethod' => '']);
//		$data = array('sb_id' => $sb_id, 'name' => 'Schaefer et al 2009', 'submethod' => '', 'type' => 'Age', 'reference' => 'Juvenile Osteology.  Elsevier.', 'description' => 'Age estimation based on various skeletal morphology', 'uses_feature_score' => true, 'uses_composite_score' => false,'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt, 'help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/methods/#schaefer-m-black-s-scheuer-l-2009');
//        (!$method->exists) ? $method->fill($data)->save() : $method->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name', '=', 'Unseriated distal pedal phalanx')->first()->id;
//		$method = Method::firstOrNew(['sb_id' => $sb_id, 'name' =>'Schaefer et al 2009', 'submethod' => '']);
//		$data = array('sb_id' => $sb_id, 'name' => 'Schaefer et al 2009', 'submethod' => '', 'type' => 'Age', 'reference' => 'Juvenile Osteology.  Elsevier.', 'description' => 'Age estimation based on various skeletal morphology', 'uses_feature_score' => true, 'uses_composite_score' => false,'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt, 'help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/methods/#schaefer-m-black-s-scheuer-l-2009');
//        (!$method->exists) ? $method->fill($data)->save() : $method->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name', '=', 'Unseriated intermediate manual phalanx')->first()->id;
//		$method = Method::firstOrNew(['sb_id' => $sb_id, 'name' =>'Schaefer et al 2009', 'submethod' => '']);
//		$data = array('sb_id' => $sb_id, 'name' => 'Schaefer et al 2009', 'submethod' => '', 'type' => 'Age', 'reference' => 'Juvenile Osteology.  Elsevier.', 'description' => 'Age estimation based on various skeletal morphology', 'uses_feature_score' => true, 'uses_composite_score' => false,'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt, 'help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/methods/#schaefer-m-black-s-scheuer-l-2009');
//        (!$method->exists) ? $method->fill($data)->save() : $method->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name', '=', 'Unseriated intermediate pedal phalanx')->first()->id;
//		$method = Method::firstOrNew(['sb_id' => $sb_id, 'name' =>'Schaefer et al 2009', 'submethod' => '']);
//		$data = array('sb_id' => $sb_id, 'name' => 'Schaefer et al 2009', 'submethod' => '', 'type' => 'Age', 'reference' => 'Juvenile Osteology.  Elsevier.', 'description' => 'Age estimation based on various skeletal morphology', 'uses_feature_score' => true, 'uses_composite_score' => false,'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt, 'help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/methods/#schaefer-m-black-s-scheuer-l-2009');
//        (!$method->exists) ? $method->fill($data)->save() : $method->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name', '=', 'Unseriated lumbar vertebra')->first()->id;
//		$method = Method::firstOrNew(['sb_id' => $sb_id, 'name' =>'Schaefer et al 2009', 'submethod' => '']);
//		$data = array('sb_id' => $sb_id, 'name' => 'Schaefer et al 2009', 'submethod' => '', 'type' => 'Age', 'reference' => 'Juvenile Osteology.  Elsevier.', 'description' => 'Age estimation based on various skeletal morphology', 'uses_feature_score' => true, 'uses_composite_score' => false,'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt, 'help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/methods/#schaefer-m-black-s-scheuer-l-2009');
//        (!$method->exists) ? $method->fill($data)->save() : $method->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name', '=', 'Unseriated metacarpal')->first()->id;
//		$method = Method::firstOrNew(['sb_id' => $sb_id, 'name' =>'Schaefer et al 2009', 'submethod' => '']);
//		$data = array('sb_id' => $sb_id, 'name' => 'Schaefer et al 2009', 'submethod' => '', 'type' => 'Age', 'reference' => 'Juvenile Osteology.  Elsevier.', 'description' => 'Age estimation based on various skeletal morphology', 'uses_feature_score' => true, 'uses_composite_score' => false,'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt, 'help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/methods/#schaefer-m-black-s-scheuer-l-2009');
//        (!$method->exists) ? $method->fill($data)->save() : $method->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name', '=', 'Unseriated metatarsal')->first()->id;
//		$method = Method::firstOrNew(['sb_id' => $sb_id, 'name' =>'Schaefer et al 2009', 'submethod' => '']);
//		$data = array('sb_id' => $sb_id, 'name' => 'Schaefer et al 2009', 'submethod' => '', 'type' => 'Age', 'reference' => 'Juvenile Osteology.  Elsevier.', 'description' => 'Age estimation based on various skeletal morphology', 'uses_feature_score' => true, 'uses_composite_score' => false,'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt, 'help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/methods/#schaefer-m-black-s-scheuer-l-2009');
//        (!$method->exists) ? $method->fill($data)->save() : $method->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name', '=', 'Unseriated proximal manual phalanx')->first()->id;
//		$method = Method::firstOrNew(['sb_id' => $sb_id, 'name' =>'Schaefer et al 2009', 'submethod' => '']);
//		$data = array('sb_id' => $sb_id, 'name' => 'Schaefer et al 2009', 'submethod' => '', 'type' => 'Age', 'reference' => 'Juvenile Osteology.  Elsevier.', 'description' => 'Age estimation based on various skeletal morphology', 'uses_feature_score' => true, 'uses_composite_score' => false,'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt, 'help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/methods/#schaefer-m-black-s-scheuer-l-2009');
//        (!$method->exists) ? $method->fill($data)->save() : $method->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name', '=', 'Unseriated proximal pedal phalanx')->first()->id;
//		$method = Method::firstOrNew(['sb_id' => $sb_id, 'name' =>'Schaefer et al 2009', 'submethod' => '']);
//		$data = array('sb_id' => $sb_id, 'name' => 'Schaefer et al 2009', 'submethod' => '', 'type' => 'Age', 'reference' => 'Juvenile Osteology.  Elsevier.', 'description' => 'Age estimation based on various skeletal morphology', 'uses_feature_score' => true, 'uses_composite_score' => false,'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt, 'help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/methods/#schaefer-m-black-s-scheuer-l-2009');
//        (!$method->exists) ? $method->fill($data)->save() : $method->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name', '=', 'Unseriated thoracic vertebra')->first()->id;
//		$method = Method::firstOrNew(['sb_id' => $sb_id, 'name' =>'Schaefer et al 2009', 'submethod' => '']);
//		$data = array('sb_id' => $sb_id, 'name' => 'Schaefer et al 2009', 'submethod' => '', 'type' => 'Age', 'reference' => 'Juvenile Osteology.  Elsevier.', 'description' => 'Age estimation based on various skeletal morphology', 'uses_feature_score' => true, 'uses_composite_score' => false,'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt, 'help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/methods/#schaefer-m-black-s-scheuer-l-2009');
//        (!$method->exists) ? $method->fill($data)->save() : $method->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name', '=', 'Unidentified vertebra')->first()->id;
//		$method = Method::firstOrNew(['sb_id' => $sb_id, 'name' =>'Schaefer et al 2009', 'submethod' => '']);
//		$data = array('sb_id' => $sb_id, 'name' => 'Schaefer et al 2009', 'submethod' => '', 'type' => 'Age', 'reference' => 'Juvenile Osteology.  Elsevier.', 'description' => 'Age estimation based on various skeletal morphology', 'uses_feature_score' => true, 'uses_composite_score' => false,'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt, 'help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/methods/#schaefer-m-black-s-scheuer-l-2009');
//        (!$method->exists) ? $method->fill($data)->save() : $method->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name', '=', 'Vomer')->first()->id;
//		$method = Method::firstOrNew(['sb_id' => $sb_id, 'name' =>'Schaefer et al 2009', 'submethod' => '']);
//		$data = array('sb_id' => $sb_id, 'name' => 'Schaefer et al 2009', 'submethod' => '', 'type' => 'Age', 'reference' => 'Juvenile Osteology.  Elsevier.', 'description' => 'Age estimation based on various skeletal morphology', 'uses_feature_score' => true, 'uses_composite_score' => false,'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt, 'help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/methods/#schaefer-m-black-s-scheuer-l-2009');
//        (!$method->exists) ? $method->fill($data)->save() : $method->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name', '=', 'Xiphoid process')->first()->id;
//		$method = Method::firstOrNew(['sb_id' => $sb_id, 'name' =>'Schaefer et al 2009', 'submethod' => '']);
//		$data = array('sb_id' => $sb_id, 'name' => 'Schaefer et al 2009', 'submethod' => '', 'type' => 'Age', 'reference' => 'Juvenile Osteology.  Elsevier.', 'description' => 'Age estimation based on various skeletal morphology', 'uses_feature_score' => true, 'uses_composite_score' => false,'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt, 'help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/methods/#schaefer-m-black-s-scheuer-l-2009');
//        (!$method->exists) ? $method->fill($data)->save() : $method->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name', '=', 'Zygomatic')->first()->id;
//		$method = Method::firstOrNew(['sb_id' => $sb_id, 'name' =>'Schaefer et al 2009', 'submethod' => '']);
//		$data = array('sb_id' => $sb_id, 'name' => 'Schaefer et al 2009', 'submethod' => '', 'type' => 'Age', 'reference' => 'Juvenile Osteology.  Elsevier.', 'description' => 'Age estimation based on various skeletal morphology', 'uses_feature_score' => true, 'uses_composite_score' => false,'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt, 'help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/methods/#schaefer-m-black-s-scheuer-l-2009');
//        (!$method->exists) ? $method->fill($data)->save() : $method->fill(array_except($data, ['created_at']))->save();

        /// End - Old Schaefer et al 2009 method
        //////////////////////////////////////////////////////////////////

        $sb_id = SkeletalBone::where('name', '=', 'Os coxa')->first()->id;
		$method = Method::firstOrNew(['sb_id' => $sb_id, 'name' =>'Walker 2005', 'submethod' => '']);
		$data = array('sb_id' => $sb_id, 'name' => 'Walker 2005', 'submethod' => '', 'type' => 'Sex', 'reference' => 'AJPA 127:385-391', 'description' => 'Sex estimation by scoring greater sciatic notch morphology', 'uses_feature_score' => true, 'uses_composite_score' => false,'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt, 'help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/methods/#walker-pl-2005');
        (!$method->exists) ? $method->fill($data)->save() : $method->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name', '=', 'Cranium')->first()->id;
		$method = Method::firstOrNew(['sb_id' => $sb_id, 'name' =>'Walker 2008', 'submethod' => '']);
		$data = array('sb_id' => $sb_id, 'name' => 'Walker 2008', 'submethod' => '', 'type' => 'Sex', 'reference' => 'AJPA 136:39-50', 'description' => 'Sex estimation by scoring cranial morphology', 'uses_feature_score' => true, 'uses_composite_score' => false,'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt, 'help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/methods/#walker-pl-2008');
        (!$method->exists) ? $method->fill($data)->save() : $method->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name', '=', 'Mandible')->first()->id;
        $method = Method::firstOrNew(['sb_id' => $sb_id, 'name' =>'Walker 2008', 'submethod' => '']);
        $data = array('sb_id' => $sb_id, 'name' => 'Walker 2008', 'submethod' => '', 'type' => 'Sex', 'reference' => 'AJPA 136:39-50', 'description' => 'Sex estimation by scoring cranial morphology', 'uses_feature_score' => true, 'uses_composite_score' => false,'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt, 'help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/methods/#walker-pl-2008');
        (!$method->exists) ? $method->fill($data)->save() : $method->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name', '=', 'Temporal')->first()->id;
        $method = Method::firstOrNew(['sb_id' => $sb_id, 'name' =>'Walker 2008', 'submethod' => '']);
        $data = array('sb_id' => $sb_id, 'name' => 'Walker 2008', 'submethod' => '', 'type' => 'Sex', 'reference' => 'AJPA 136:39-50', 'description' => 'Sex estimation by scoring cranial morphology', 'uses_feature_score' => true, 'uses_composite_score' => false,'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt, 'help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/methods/#walker-pl-2008');
        (!$method->exists) ? $method->fill($data)->save() : $method->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name', '=', 'Occipital')->first()->id;
        $method = Method::firstOrNew(['sb_id' => $sb_id, 'name' =>'Walker 2008', 'submethod' => '']);
        $data = array('sb_id' => $sb_id, 'name' => 'Walker 2008', 'submethod' => '', 'type' => 'Sex', 'reference' => 'AJPA 136:39-50', 'description' => 'Sex estimation by scoring cranial morphology', 'uses_feature_score' => true, 'uses_composite_score' => false,'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt, 'help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/methods/#walker-pl-2008');
        (!$method->exists) ? $method->fill($data)->save() : $method->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name', '=', 'Frontal')->first()->id;
        $method = Method::firstOrNew(['sb_id' => $sb_id, 'name' =>'Walker 2008', 'submethod' => '']);
        $data = array('sb_id' => $sb_id, 'name' => 'Walker 2008', 'submethod' => '', 'type' => 'Sex', 'reference' => 'AJPA 136:39-50', 'description' => 'Sex estimation by scoring cranial morphology', 'uses_feature_score' => true, 'uses_composite_score' => false,'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt, 'help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/methods/#walker-pl-2008');
        (!$method->exists) ? $method->fill($data)->save() : $method->fill(array_except($data, ['created_at']))->save();

        // New method added a request from University of Milano for ICRC project on Migrant Shiprwreck 2015 and Ca'Granda
        $sb_id = SkeletalBone::where('name', '=', 'Os coxa')->first()->id;
        $method = Method::firstOrNew(['sb_id' => $sb_id, 'name' =>'Rougé-Maillart et al 2009', 'submethod' => '']);
        $data = array('sb_id' => $sb_id, 'name' => 'Rougé-Maillart et al 2009', 'submethod' => '', 'type' => 'Age', 'reference' => 'FSI 188(1-3):91-95', 'description' => 'Age estimation based on the scoring of degenerative features of the acetabulum and auricular surface', 'uses_feature_score' => true, 'uses_composite_score' => false,'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt, 'help_url' => 'https://cora-docs.readthedocs.io/en/latest/forensics-anthro-guide/methods/#rouge-maillart-2009');
        (!$method->exists) ? $method->fill($data)->save() : $method->fill(array_except($data, ['created_at']))->save();

    }
}

