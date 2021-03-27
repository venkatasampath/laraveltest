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

use App\Method;
use App\MethodFeature;
use App\SkeletalBone;
use Illuminate\Database\Seeder;

class MethodFeaturesTableSeeder extends Seeder {

    public function run()
    {
        $dt = date_create();
        $sys = 'System';

        $sb_id = SkeletalBone::where('name','=','Clavicle')->first()->id;
        $method_id = Method::where([['name','=','Falys and Prangle 2015'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Surface Topography']);
        $data = array('method_id'=>$method_id,'feature'=>'Surface Topography','display_name'=>'Surface Topography', 'display_order' =>  1, 'display_values' => '{"1":"1", "2":"2", "3":"3", "4":"4", "5":"5", "6":"6"}','computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name','=','Clavicle')->first()->id;
        $method_id = Method::where([['name','=','Falys and Prangle 2015'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Porosity']);
        $data = array('method_id'=>$method_id,'feature'=>'Porosity','display_name'=>'Porosity', 'display_order' =>  2, 'display_values' => '{"1":"1", "2":"2", "3":"3", "4":"4", "5":"5", "6":"6"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name','=','Clavicle')->first()->id;
        $method_id = Method::where([['name','=','Falys and Prangle 2015'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Osteophyte Formation']);
        $data = array('method_id'=>$method_id,'feature'=>'Osteophyte Formation','display_name'=>'Osteophyte Formation', 'display_order' =>  3, 'display_values' => '{"1":"1", "2":"2", "3":"3", "4":"4"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name','=','Clavicle')->first()->id;
        $method_id = Method::where([['name','=','Falys and Prangle 2015'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'SUMALL']);
        $data = array('method_id'=>$method_id,'feature'=>'SUMALL','display_name'=>'Composite Score - SUMALL', 'display_order' => 4,
            'display_values' => '{"3":"3", "4":"4", "5":"5", "6":"6", "7":"7", "8":"8", "9":"9", "10":"10", "11":"11", "12":"12", "13":"13", "14":"14", "15":"15", "16":"16"}',
            'computed' => true, 'compute_rule' => 'Surface Topography,Porosity,Osteophyte Formation', 'display_interval' => null, 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();


        $sb_id = SkeletalBone::where('name','=','Clavicle')->first()->id;
        $method_id = Method::where([['name','=','Langley and Jantz 2010'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Medial']);
        $data = array('method_id'=>$method_id,'feature'=>'Medial','display_name'=>'Medial', 'display_order' =>  1, 'display_values' => '{"1":"1", "2":"2", "3":"3", "4":"4", "5":"5"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();


        $sb_id = SkeletalBone::where('name','=','Os coxa')->first()->id;
        $method_id = Method::where([['name','=','Brooks and Suchey 1990'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Public Symphysis']);
        $data = array('method_id'=>$method_id,'feature'=>'Public Symphysis','display_name'=>'Public Symphysis', 'display_order' =>  1, 'display_values' => '{"1":"1", "2":"2", "3":"3", "4":"4", "5":"5", "6":"6"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();


        $sb_id = SkeletalBone::where('name','=','Os coxa')->first()->id;
        $method_id = Method::where([['name','=','Berg 2008'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Pubic Symphysis']);
        $data = array('method_id'=>$method_id,'feature'=>'Pubic Symphysis','display_name'=>'Pubic Symphysis', 'display_order' =>  1, 'display_values' => '{"5":"5", "6":"6", "7":"7"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();


        $sb_id = SkeletalBone::where('name','=','Os coxa')->first()->id;
        $method_id = Method::where([['name','=','Lovejoy et al 1985'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Auricular Surface']);
        $data = array('method_id'=>$method_id,'feature'=>'Auricular Surface','display_name'=>'Auricular Surface', 'display_order' =>  1, 'display_values' => '{"1":"1", "2":"2", "3":"3", "4":"4", "5":"5", "6":"6", "7":"7", "8":"8"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();


        $sb_id = SkeletalBone::where('name','=','Os coxa')->first()->id;
        $method_id = Method::where([['name','=','Osborne et al 2004'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Auricular Surface']);
        $data = array('method_id'=>$method_id,'feature'=>'Auricular Surface','display_name'=>'Auricular Surface', 'display_order' =>  1, 'display_values' => '{"1":"1", "2":"2", "3":"3", "4":"4", "5":"5", "6":"6"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();


        $sb_id = SkeletalBone::where('name','=','Os coxa')->first()->id;
        $method_id = Method::where([['name','=','Buckberry and Chamberlain 2002'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Transverse Organization']);
        $data = array('method_id'=>$method_id,'feature'=>'Transverse Organization','display_name'=>'Transverse Organization', 'display_order' =>  1, 'display_values' => '{"1":"1", "2":"2", "3":"3", "4":"4", "5":"5"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name','=','Os coxa')->first()->id;
        $method_id = Method::where([['name','=','Buckberry and Chamberlain 2002'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Surface Texture']);
        $data = array('method_id'=>$method_id,'feature'=>'Surface Texture','display_name'=>'Surface Texture', 'display_order' =>  2, 'display_values' => '{"1":"1", "2":"2", "3":"3", "4":"4", "5":"5"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name','=','Os coxa')->first()->id;
        $method_id = Method::where([['name','=','Buckberry and Chamberlain 2002'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Microporosity']);
        $data = array('method_id'=>$method_id,'feature'=>'Microporosity','display_name'=>'Microporosity', 'display_order' =>  3, 'display_values' => '{"1":"1", "2":"2", "3":"3"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name','=','Os coxa')->first()->id;
        $method_id = Method::where([['name','=','Buckberry and Chamberlain 2002'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Macroporosity']);
        $data = array('method_id'=>$method_id,'feature'=>'Macroporosity','display_name'=>'Macroporosity', 'display_order' =>  4, 'display_values' => '{"1":"1", "2":"2", "3":"3"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name','=','Os coxa')->first()->id;
        $method_id = Method::where([['name','=','Buckberry and Chamberlain 2002'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Apical Changes']);
        $data = array('method_id'=>$method_id,'feature'=>'Apical Changes','display_name'=>'Apical Changes', 'display_order' =>  5, 'display_values' => '{"1":"1", "2":"2", "3":"3"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name','=','Os coxa')->first()->id;
        $method_id = Method::where([['name','=','Buckberry and Chamberlain 2002'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'SUMALL']);
        $data = array('method_id'=>$method_id,'feature'=>'SUMALL','display_name'=>'Composite Score - SUMALL', 'display_order' => 6,
            'display_values' => '{"5":"5", "6":"6", "7":"7", "8":"8", "9":"9", "10":"10", "11":"11", "12":"12", "13":"13", "14":"14", "15":"15", "16":"16", "17":"17", "18":"18", "19":"19"}',
            'computed' => true, 'compute_rule' => 'Transverse Organization,Surface Texture,Microporosity,Macroporosity,Apical Changes', 'display_interval' => null, 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();


        $sb_id = SkeletalBone::where('name','=','Os coxa')->first()->id;
        $method_id = Method::where([['name','=','Samworth and Gowland 2007'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Auricular Surface']);
        $data = array('method_id'=>$method_id,'feature'=>'Auricular Surface','display_name'=>'Auricular Surface', 'display_order' =>  1, 'display_values' => '{"1":"1", "2":"2", "3":"3", "4":"4", "5":"5", "6":"6", "7":"7", "8":"8"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name','=','Os coxa')->first()->id;
        $method_id = Method::where([['name','=','Samworth and Gowland 2007'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Pubic Symphysis']);
        $data = array('method_id'=>$method_id,'feature'=>'Pubic Symphysis','display_name'=>'Pubic Symphysis', 'display_order' =>  2, 'display_values' => '{"1":"1", "2":"2", "3":"3", "4":"4", "5":"5", "6":"6"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();


        $sb_id = SkeletalBone::where('name','=','Rib 4')->first()->id;
        $method_id = Method::where([['name','=','Iscan et al 1984'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Sternal end']);
        $data = array('method_id'=>$method_id,'feature'=>'Sternal end','display_name'=>'Sternal end', 'display_order' =>  1, 'display_values' => '{"1":"1", "2":"2", "3":"3", "4":"4", "5":"5", "6":"6", "7":"7", "8":"8"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();


        $sb_id = SkeletalBone::where('name','=','Rib 4')->first()->id;
        $method_id = Method::where([['name','=','Iscan et al 1985'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Sternal end']);
        $data = array('method_id'=>$method_id,'feature'=>'Sternal end','display_name'=>'Sternal end', 'display_order' =>  1, 'display_values' => '{"1":"1", "2":"2", "3":"3", "4":"4", "5":"5", "6":"6", "7":"7", "8":"8"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();


        $sb_id = SkeletalBone::where('name','=','Cranium')->first()->id;
        $method_id = Method::where([['name','=','Mann et al 1991'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Incisive']);
        $data = array('method_id'=>$method_id,'feature'=>'Incisive','display_name'=>'Incisive', 'display_order' =>  1, 'display_values' => '{"open":"open", "partial obliteration":"partial obliteration", "complete obliteration":"complete obliteration"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name','=','Cranium')->first()->id;
        $method_id = Method::where([['name','=','Mann et al 1991'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Posterior median palatine']);
        $data = array('method_id'=>$method_id,'feature'=>'Posterior median palatine','display_name'=>'Posterior median palatine', 'display_order' =>  2, 'display_values' => '{"open":"open", "partial obliteration":"partial obliteration", "complete obliteration":"complete obliteration"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name','=','Cranium')->first()->id;
        $method_id = Method::where([['name','=','Mann et al 1991'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Transverse palatine']);
        $data = array('method_id'=>$method_id,'feature'=>'Transverse palatine','display_name'=>'Transverse palatine', 'display_order' =>  3, 'display_values' => '{"open":"open", "partial obliteration":"partial obliteration", "complete obliteration":"complete obliteration"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name','=','Cranium')->first()->id;
        $method_id = Method::where([['name','=','Mann et al 1991'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Anterior median palatine']);
        $data = array('method_id'=>$method_id,'feature'=>'Anterior median palatine','display_name'=>'Anterior median palatine', 'display_order' =>  4, 'display_values' => '{"open":"open", "partial obliteration":"partial obliteration", "complete obliteration":"complete obliteration"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();


        $sb_id = SkeletalBone::where('name','=','Cranium')->first()->id;
        $method_id = Method::where([['name','=','Meindl and Lovejoy 1985'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Midlambdoid']);
        $data = array('method_id'=>$method_id,'feature'=>'Midlambdoid','display_name'=>'Midlambdoid', 'display_order' =>  1, 'display_values' => '{"0":"0", "1":"1", "2":"2", "3":"3"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name','=','Cranium')->first()->id;
        $method_id = Method::where([['name','=','Meindl and Lovejoy 1985'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Lambda']);
        $data = array('method_id'=>$method_id,'feature'=>'Lambda','display_name'=>'Lambda', 'display_order' =>  2, 'display_values' => '{"0":"0", "1":"1", "2":"2", "3":"3"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name','=','Cranium')->first()->id;
        $method_id = Method::where([['name','=','Meindl and Lovejoy 1985'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Obelion']);
        $data = array('method_id'=>$method_id,'feature'=>'Obelion','display_name'=>'Obelion', 'display_order' =>  3, 'display_values' => '{"0":"0", "1":"1", "2":"2", "3":"3"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name','=','Cranium')->first()->id;
        $method_id = Method::where([['name','=','Meindl and Lovejoy 1985'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Anterior sagittal']);
        $data = array('method_id'=>$method_id,'feature'=>'Anterior sagittal','display_name'=>'Anterior sagittal', 'display_order' =>  4, 'display_values' => '{"0":"0", "1":"1", "2":"2", "3":"3"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name','=','Cranium')->first()->id;
        $method_id = Method::where([['name','=','Meindl and Lovejoy 1985'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Bregma']);
        $data = array('method_id'=>$method_id,'feature'=>'Bregma','display_name'=>'Bregma', 'display_order' =>  5, 'display_values' => '{"0":"0", "1":"1", "2":"2", "3":"3"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name','=','Cranium')->first()->id;
        $method_id = Method::where([['name','=','Meindl and Lovejoy 1985'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Midcoronal']);
        $data = array('method_id'=>$method_id,'feature'=>'Midcoronal','display_name'=>'Midcoronal', 'display_order' =>  6, 'display_values' => '{"0":"0", "1":"1", "2":"2", "3":"3"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name','=','Cranium')->first()->id;
        $method_id = Method::where([['name','=','Meindl and Lovejoy 1985'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Pterion']);
        $data = array('method_id'=>$method_id,'feature'=>'Pterion','display_name'=>'Pterion', 'display_order' =>  7, 'display_values' => '{"0":"0", "1":"1", "2":"2", "3":"3"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name','=','Cranium')->first()->id;
        $method_id = Method::where([['name','=','Meindl and Lovejoy 1985'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Sphenofrontal']);
        $data = array('method_id'=>$method_id,'feature'=>'Sphenofrontal','display_name'=>'Sphenofrontal', 'display_order' =>  8, 'display_values' => '{"0":"0", "1":"1", "2":"2", "3":"3"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name','=','Cranium')->first()->id;
        $method_id = Method::where([['name','=','Meindl and Lovejoy 1985'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Inferior sphenotemporal']);
        $data = array('method_id'=>$method_id,'feature'=>'Inferior sphenotemporal','display_name'=>'Inferior sphenotemporal', 'display_order' =>  9, 'display_values' => '{"0":"0", "1":"1", "2":"2", "3":"3"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name','=','Cranium')->first()->id;
        $method_id = Method::where([['name','=','Meindl and Lovejoy 1985'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Superior sphenotemporal']);
        $data = array('method_id'=>$method_id,'feature'=>'Superior sphenotemporal','display_name'=>'Superior sphenotemporal', 'display_order' =>  10, 'display_values' => '{"0":"0", "1":"1", "2":"2", "3":"3"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name','=','Cranium')->first()->id;
        $method_id = Method::where([['name','=','Meindl and Lovejoy 1985'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'VAULT']);
        $data = array('method_id'=>$method_id,'feature'=>'VAULT','display_name'=>'Composite Score - VAULT', 'display_order' => 11,
            'display_values' => '{"0":"0", "1":"1", "2":"2", "3":"3", "4":"4", "5":"5", "6":"6", "7":"7", "8":"8", "9":"9", "10":"10", "11":"11", "12":"12", "13":"13", "14":"14", "15":"15", "16":"16", "17":"17", "18":"18", "19":"19", "20":"20", "21":"21"}',
            'computed' => true, 'compute_rule' => 'Midlambdoid,Lambda,Obelion,Anterior sagittal,Bregma,Midcoronal,Pterion', 'display_interval' => null, 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name','=','Cranium')->first()->id;
        $method_id = Method::where([['name','=','Meindl and Lovejoy 1985'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'LAT-ANT']);
        $data = array('method_id'=>$method_id,'feature'=>'LAT-ANT','display_name'=>'Composite Score - LAT-ANT', 'display_order' => 12,
            'display_values' => '{"0":"0", "1":"1", "2":"2", "3":"3", "4":"4", "5":"5", "6":"6", "7":"7", "8":"8", "9":"9", "10":"10", "11":"11", "12":"12", "13":"13", "14":"14", "15":"15"}',
            'computed' => true, 'compute_rule' => 'Midcoronal,Pterion,Sphenofrontal,Inferior sphenotemporal,Superior sphenotemporal', 'display_interval' => null, 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();



        $sb_id = SkeletalBone::where('name','=','Cranium')->first()->id;
        $method_id = Method::where([['name','=','Nawrocki 1998'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'LLQ: midlambdoid left']);
        $data = array('method_id'=>$method_id,'feature'=>'LLQ: midlambdoid left','display_name'=>'LLQ: midlambdoid left', 'display_order' =>  1, 'groups'=>'Ectocranial', 
			'display_values' => '{"0":"0", "1":"1", "2":"2", "3":"3"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name','=','Cranium')->first()->id;
        $method_id = Method::where([['name','=','Nawrocki 1998'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'LRQ: midlambdoid right']);
        $data = array('method_id'=>$method_id,'feature'=>'LRQ: midlambdoid right','display_name'=>'LRQ: midlambdoid right', 'display_order' =>  2, 'groups'=>'Ectocranial', 
			'display_values' => '{"0":"0", "1":"1", "2":"2", "3":"3"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name','=','Cranium')->first()->id;
        $method_id = Method::where([['name','=','Nawrocki 1998'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'LAQ: lambda']);
        $data = array('method_id'=>$method_id,'feature'=>'LAQ: lambda','display_name'=>'LAQ: lambda', 'display_order' =>  3, 'groups'=>'Ectocranial', 
			'display_values' => '{"0":"0", "1":"1", "2":"2", "3":"3"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name','=','Cranium')->first()->id;
        $method_id = Method::where([['name','=','Nawrocki 1998'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'OBQ: obelion']);
        $data = array('method_id'=>$method_id,'feature'=>'OBQ: obelion','display_name'=>'OBQ: obelion', 'display_order' =>  4, 'groups'=>'Ectocranial', 
			'display_values' => '{"0":"0", "1":"1", "2":"2", "3":"3"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name','=','Cranium')->first()->id;
        $method_id = Method::where([['name','=','Nawrocki 1998'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'ASQ: anterior sagittal']);
        $data = array('method_id'=>$method_id,'feature'=>'ASQ: anterior sagittal','display_name'=>'ASQ: anterior sagittal', 'display_order' =>  5, 'groups'=>'Ectocranial', 
			'display_values' => '{"0":"0", "1":"1", "2":"2", "3":"3"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name','=','Cranium')->first()->id;
        $method_id = Method::where([['name','=','Nawrocki 1998'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'BRQ: bregma']);
        $data = array('method_id'=>$method_id,'feature'=>'BRQ: bregma','display_name'=>'BRQ: bregma', 'display_order' =>  6, 'groups'=>'Ectocranial', 
			'display_values' => '{"0":"0", "1":"1", "2":"2", "3":"3"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name','=','Cranium')->first()->id;
        $method_id = Method::where([['name','=','Nawrocki 1998'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'midcoronal left']);
        $data = array('method_id'=>$method_id,'feature'=>'CLQ: midcoronal left','display_name'=>'CLQ: midcoronal left', 'display_order' =>  7, 'groups'=>'Ectocranial', 
			'display_values' => '{"0":"0", "1":"1", "2":"2", "3":"3"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name','=','Cranium')->first()->id;
        $method_id = Method::where([['name','=','Nawrocki 1998'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'CRQ: midcoronal right']);
        $data = array('method_id'=>$method_id,'feature'=>'CRQ: midcoronal right','display_name'=>'CRQ: midcoronal right', 'display_order' =>  8, 'groups'=>'Ectocranial', 
			'display_values' => '{"0":"0", "1":"1", "2":"2", "3":"3"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name','=','Cranium')->first()->id;
        $method_id = Method::where([['name','=','Nawrocki 1998'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'PLQ: pterion left']);
        $data = array('method_id'=>$method_id,'feature'=>'PLQ: pterion left','display_name'=>'PLQ: pterion left', 'display_order' =>  9, 'groups'=>'Ectocranial', 
			'display_values' => '{"0":"0", "1":"1", "2":"2", "3":"3"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name','=','Cranium')->first()->id;
        $method_id = Method::where([['name','=','Nawrocki 1998'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'PRQ: pterion right']);
        $data = array('method_id'=>$method_id,'feature'=>'PRQ: pterion right','display_name'=>'PRQ: pterion right', 'display_order' =>  10, 'groups'=>'Ectocranial', 
			'display_values' => '{"0":"0", "1":"1", "2":"2", "3":"3"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name','=','Cranium')->first()->id;
        $method_id = Method::where([['name','=','Nawrocki 1998'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'SLQ: sphenofrontal left']);
        $data = array('method_id'=>$method_id,'feature'=>'SLQ: sphenofrontal left','display_name'=>'SLQ: sphenofrontal left', 'display_order' =>  11, 'groups'=>'Ectocranial', 
			'display_values' => '{"0":"0", "1":"1", "2":"2", "3":"3"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name','=','Cranium')->first()->id;
        $method_id = Method::where([['name','=','Nawrocki 1998'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'SRQ: sphenofrontal right']);
        $data = array('method_id'=>$method_id,'feature'=>'SRQ: sphenofrontal right','display_name'=>'SRQ: sphenofrontal right', 'display_order' =>  12, 'groups'=>'Ectocranial', 
			'display_values' => '{"0":"0", "1":"1", "2":"2", "3":"3"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name','=','Cranium')->first()->id;
        $method_id = Method::where([['name','=','Nawrocki 1998'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'ILQ: inferior sphenotemporal left']);
        $data = array('method_id'=>$method_id,'feature'=>'ILQ: inferior sphenotemporal left','display_name'=>'ILQ: inferior sphenotemporal left', 'display_order' =>  13, 'groups'=>'Ectocranial', 
			'display_values' => '{"0":"0", "1":"1", "2":"2", "3":"3"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name','=','Cranium')->first()->id;
        $method_id = Method::where([['name','=','Nawrocki 1998'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'IRQ: inferior sphenotemporal right']);
        $data = array('method_id'=>$method_id,'feature'=>'IRQ: inferior sphenotemporal right','display_name'=>'IRQ: inferior sphenotemporal right', 'display_order' =>  14, 'groups'=>'Ectocranial', 
			'display_values' => '{"0":"0", "1":"1", "2":"2", "3":"3"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name','=','Cranium')->first()->id;
        $method_id = Method::where([['name','=','Nawrocki 1998'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'TLQ: superior sphenotemporal left']);
        $data = array('method_id'=>$method_id,'feature'=>'TLQ: superior sphenotemporal left','display_name'=>'TLQ: superior sphenotemporal left', 'display_order' =>  15, 'groups'=>'Ectocranial', 
			'display_values' => '{"0":"0", "1":"1", "2":"2", "3":"3"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name','=','Cranium')->first()->id;
        $method_id = Method::where([['name','=','Nawrocki 1998'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'TRQ: superior sphenotemporal right']);
        $data = array('method_id'=>$method_id,'feature'=>'TRQ: superior sphenotemporal right','display_name'=>'TRQ: superior sphenotemporal right', 'display_order' =>  16, 'groups'=>'Ectocranial', 
			'display_values' => '{"0":"0", "1":"1", "2":"2", "3":"3"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name','=','Cranium')->first()->id;
        $method_id = Method::where([['name','=','Nawrocki 1998'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'LLZ: midlambdoid left']);
        $data = array('method_id'=>$method_id,'feature'=>'LLZ: midlambdoid left','display_name'=>'LLZ: midlambdoid left', 'display_order' =>  17, 'groups'=>'Endocranial',
			'display_values' => '{"0":"0", "1":"1", "2":"2", "3":"3"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name','=','Cranium')->first()->id;
        $method_id = Method::where([['name','=','Nawrocki 1998'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'LRZ: midlambdoid right']);
        $data = array('method_id'=>$method_id,'feature'=>'LRZ: midlambdoid right','display_name'=>'LRZ: midlambdoid right', 'display_order' =>  18, 'groups'=>'Endocranial',
			'display_values' => '{"0":"0", "1":"1", "2":"2", "3":"3"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name','=','Cranium')->first()->id;
        $method_id = Method::where([['name','=','Nawrocki 1998'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'LAZ: lambda']);
        $data = array('method_id'=>$method_id,'feature'=>'LAZ: lambda','display_name'=>'LAZ: lambda', 'display_order' =>  19, 'groups'=>'Endocranial',
			'display_values' => '{"0":"0", "1":"1", "2":"2", "3":"3"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name','=','Cranium')->first()->id;
        $method_id = Method::where([['name','=','Nawrocki 1998'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'SAZ: midsagittal']);
        $data = array('method_id'=>$method_id,'feature'=>'SAZ: midsagittal','display_name'=>'SAZ: midsagittal', 'display_order' =>  20, 'groups'=>'Endocranial',
			'display_values' => '{"0":"0", "1":"1", "2":"2", "3":"3"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name','=','Cranium')->first()->id;
        $method_id = Method::where([['name','=','Nawrocki 1998'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'BRZ: bregma']);
        $data = array('method_id'=>$method_id,'feature'=>'BRZ: bregma','display_name'=>'BRZ: bregma', 'display_order' =>  21, 'groups'=>'Endocranial',
			'display_values' => '{"0":"0", "1":"1", "2":"2", "3":"3"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name','=','Cranium')->first()->id;
        $method_id = Method::where([['name','=','Nawrocki 1998'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'CLZ: midcoronal left']);
        $data = array('method_id'=>$method_id,'feature'=>'CLZ: midcoronal left','display_name'=>'CLZ: midcoronal left', 'display_order' =>  22, 'groups'=>'Endocranial',
			'display_values' => '{"0":"0", "1":"1", "2":"2", "3":"3"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name','=','Cranium')->first()->id;
        $method_id = Method::where([['name','=','Nawrocki 1998'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'CRZ: midcoronal right']);
        $data = array('method_id'=>$method_id,'feature'=>'CRZ: midcoronal right','display_name'=>'CRZ: midcoronal right', 'display_order' =>  23, 'groups'=>'Endocranial',
			'display_values' => '{"0":"0", "1":"1", "2":"2", "3":"3"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name','=','Cranium')->first()->id;
        $method_id = Method::where([['name','=','Nawrocki 1998'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'ICP: incisive']);
        $data = array('method_id'=>$method_id,'feature'=>'ICP: incisive','display_name'=>'ICP: incisive', 'display_order' =>  24, 'groups'=>'Palatine',
			'display_values' => '{"0":"0", "1":"1", "2":"2", "3":"3"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name','=','Cranium')->first()->id;
        $method_id = Method::where([['name','=','Nawrocki 1998'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'AMP: anterior median palatine']);
        $data = array('method_id'=>$method_id,'feature'=>'AMP: anterior median palatine','display_name'=>'AMP: anterior median palatine', 'display_order' =>  25, 'groups'=>'Palatine',
			'display_values' => '{"0":"0", "1":"1", "2":"2", "3":"3"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name','=','Cranium')->first()->id;
        $method_id = Method::where([['name','=','Nawrocki 1998'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'TRP: transverse palatine']);
        $data = array('method_id'=>$method_id,'feature'=>'TRP: transverse palatine','display_name'=>'TRP: transverse palatine', 'display_order' =>  26, 'groups'=>'Palatine',
			'display_values' => '{"0":"0", "1":"1", "2":"2", "3":"3"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name','=','Cranium')->first()->id;
        $method_id = Method::where([['name','=','Nawrocki 1998'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'PMP: posterior median palatine']);
        $data = array('method_id'=>$method_id,'feature'=>'PMP: posterior median palatine','display_name'=>'PMP: posterior median palatine', 'display_order' =>  27, 'groups'=>'Palatine',
			'display_values' => '{"0":"0", "1":"1", "2":"2", "3":"3"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name','=','Cranium')->first()->id;
        $method_id = Method::where([['name','=','Nawrocki 1998'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'SUMCAL']);
        $data = array('method_id'=>$method_id,'feature'=>'SUMCAL','display_name'=>'Composite Score - SUMCAL', 'display_order' => 28,
            'display_values' => '{"0":"0", "1":"1", "2":"2", "3":"3", "4":"4", "5":"5", "6":"6", "7":"7", "8":"8", "9":"9", "10":"10", "11":"11", "12":"12", "13":"13", "14":"14", "15":"15", "16":"16", "17":"17", "18":"18", "19":"19", "20":"20", "21":"21", "22":"22", 
                "23":"23", "24":"24", "25":"25", "26":"26", "27":"27", "28":"28", "29":"29", "30":"30", "31":"31", "32":"32", "33":"33", "34":"34", "35":"35", "36":"36", "37":"37", "38":"38", "39":"39", "40":"40", "41":"41", "42":"42", "43":"43", "44":"44", "45":"45"}',
            'computed' => true,
            'compute_rule' => 'LLQ: midlambdoid left,LRQ: midlambdoid right,LAQ: lambda,OBQ: obelion,ASQ: anterior sagittal,BRQ: bregma,CLQ: midcoronal left,CRQ: midcoronal right,LLZ: midlambdoid left,LRZ: midlambdoid right,LAZ: lambda,SAZ: midsagittal,BRZ: bregma,CLZ: midcoronal left,CRZ: midcoronal right',
            'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name','=','Cranium')->first()->id;
        $method_id = Method::where([['name','=','Nawrocki 1998'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'SUMALL']);
        $data = array('method_id'=>$method_id,'feature'=>'SUMALL','display_name'=>'Composite Score - SUMALL', 'display_order' => 29,
            'display_values' => '{"0":"0", "1":"1", "2":"2", "3":"3", "4":"4", "5":"5", "6":"6", "7":"7", "8":"8", "9":"9", "10":"10", "11":"11", "12":"12", "13":"13", "14":"14", "15":"15", "16":"16", "17":"17", "18":"18", "19":"19", "20":"20", "21":"21", "22":"22", 
                "23":"23", "24":"24", "25":"25", "26":"26", "27":"27", "28":"28", "29":"29", "30":"30", "31":"31", "32":"32", "33":"33", "34":"34", "35":"35", "36":"36", "37":"37", "38":"38", "39":"39", "40":"40", "41":"41", "42":"42", "43":"43", "44":"44", "45":"45",
                "46":"46", "47":"47", "48":"48", "49":"49", "50":"50", "51":"51", "52":"52", "53":"53", "54":"54", "55":"55", "56":"56", "57":"57", "58":"58", "59":"59", "60":"60", "61":"61", "62":"62", "63":"63", "64":"64", "65":"65", "66":"66", "67":"67", "68":"68",
                "69":"69", "70":"70", "71":"71", "72":"72", "73":"73", "74":"74", "75":"75", "76":"76", "77":"77", "78":"78", "79":"79", "80":"80", "81":"81"}',
            'computed' => true,
            'compute_rule' => 'LLQ: midlambdoid left,LRQ: midlambdoid right,LAQ: lambda,OBQ: obelion,ASQ: anterior sagittal,BRQ: bregma,CLQ: midcoronal left,CRQ: midcoronal right,PLQ: pterion left,PRQ: pterion right,SLQ: sphenofrontal left,SRQ: sphenofrontal right,ILQ: inferior sphenotemporal left,IRQ: inferior sphenotemporal right,TLQ: superior sphenotemporal left,TRQ: superior sphenotemporal right,LLZ: midlambdoid left,LRZ: midlambdoid right,LAZ: lambda,SAZ: midsagittal,BRZ: bregma,CLZ: midcoronal left,CRZ: midcoronal right,ICP: incisive,AMP: anterior median palatine,TRP: transverse palatine,PMP: posterior median palatine',
            'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();



        $sb_id = SkeletalBone::where('name','=','Mandible')->first()->id;
        $method_id = Method::where([['name','=','Mincer et al 1993'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Tooth 17']);
        $data = array('method_id'=>$method_id,'feature'=>'Tooth 17','display_name'=>'Tooth 17', 'display_order' =>  1, 'display_values' => '{"D":"D - Crown complete", "E":"E - Root length < crown", "F":"F - Funnel-shaped root ends", "G":"G - Root apices open", "H":"H - Root apices closed"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name','=','Mandible')->first()->id;
        $method_id = Method::where([['name','=','Mincer et al 1993'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Tooth 32']);
        $data = array('method_id'=>$method_id,'feature'=>'Tooth 32','display_name'=>'Tooth 32', 'display_order' =>  2, 'display_values' => '{"D":"D - Crown complete", "E":"E - Root length < crown", "F":"F - Funnel-shaped root ends", "G":"G - Root apices open", "H":"H - Root apices closed"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();


        $sb_id = SkeletalBone::where('name','=','Maxilla')->first()->id;
        $method_id = Method::where([['name','=','Mincer et al 1993'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Tooth 1']);
        $data = array('method_id'=>$method_id,'feature'=>'Tooth 1','display_name'=>'Tooth 1', 'display_order' =>  1, 'display_values' => '{"D":"D - Crown complete", "E":"E - Root length < crown", "F":"F - Funnel-shaped root ends", "G":"G - Root apices open", "H":"H - Root apices closed"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name','=','Maxilla')->first()->id;
        $method_id = Method::where([['name','=','Mincer et al 1993'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Tooth 16']);
        $data = array('method_id'=>$method_id,'feature'=>'Tooth 16','display_name'=>'Tooth 16', 'display_order' =>  2, 'display_values' => '{"D":"D - Crown complete", "E":"E - Root length < crown", "F":"F - Funnel-shaped root ends", "G":"G - Root apices open", "H":"H - Root apices closed"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();


        $sb_id = SkeletalBone::where('name','=','Cranium')->first()->id;
        $method_id = Method::where([['name','=','Mincer et al 1993'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Tooth 1']);
        $data = array('method_id'=>$method_id,'feature'=>'Tooth 1','display_name'=>'Tooth 1', 'display_order' =>  1, 'display_values' => '{"D":"D - Crown complete", "E":"E - Root length < crown", "F":"F - Funnel-shaped root ends", "G":"G - Root apices open", "H":"H - Root apices closed"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name','=','Cranium')->first()->id;
        $method_id = Method::where([['name','=','Mincer et al 1993'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Tooth 16']);
        $data = array('method_id'=>$method_id,'feature'=>'Tooth 16','display_name'=>'Tooth 16', 'display_order' =>  2, 'display_values' => '{"D":"D - Crown complete", "E":"E - Root length < crown", "F":"F - Funnel-shaped root ends", "G":"G - Root apices open", "H":"H - Root apices closed"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name','=','Tooth 1')->first()->id;
        $method_id = Method::where([['name','=','Mincer et al 1993'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Tooth 1']);
        $data = array('method_id'=>$method_id,'feature'=>'Tooth 1','display_name'=>'Tooth 1', 'display_order' =>  1, 'display_values' => '{"D":"D - Crown complete", "E":"E - Root length < crown", "F":"F - Funnel-shaped root ends", "G":"G - Root apices open", "H":"H - Root apices closed"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name','=','Tooth 16')->first()->id;
        $method_id = Method::where([['name','=','Mincer et al 1993'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Tooth 16']);
        $data = array('method_id'=>$method_id,'feature'=>'Tooth 16','display_name'=>'Tooth 16', 'display_order' =>  1, 'display_values' => '{"D":"D - Crown complete", "E":"E - Root length < crown", "F":"F - Funnel-shaped root ends", "G":"G - Root apices open", "H":"H - Root apices closed"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name','=','Tooth 17')->first()->id;
        $method_id = Method::where([['name','=','Mincer et al 1993'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Tooth 17']);
        $data = array('method_id'=>$method_id,'feature'=>'Tooth 17','display_name'=>'Tooth 17', 'display_order' =>  1, 'display_values' => '{"D":"D - Crown complete", "E":"E - Root length < crown", "F":"F - Funnel-shaped root ends", "G":"G - Root apices open", "H":"H - Root apices closed"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name','=','Tooth 32')->first()->id;
        $method_id = Method::where([['name','=','Mincer et al 1993'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Tooth 32']);
        $data = array('method_id'=>$method_id,'feature'=>'Tooth 32','display_name'=>'Tooth 32', 'display_order' =>  1, 'display_values' => '{"D":"D - Crown complete", "E":"E - Root length < crown", "F":"F - Funnel-shaped root ends", "G":"G - Root apices open", "H":"H - Root apices closed"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name','=','Mandible')->first()->id;
        $method_id = Method::where([['name','=','Blankenship et al 2007'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Tooth 17']);
        $data = array('method_id'=>$method_id,'feature'=>'Tooth 17','display_name'=>'Tooth 17', 'display_order' =>  1, 'display_values' => '{"D":"D - Crown complete", "E":"E - Root length < crown", "F":"F - Funnel-shaped root ends", "G":"G - Root apices open", "H":"H - Root apices closed"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name','=','Mandible')->first()->id;
        $method_id = Method::where([['name','=','Blankenship et al 2007'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Tooth 32']);
        $data = array('method_id'=>$method_id,'feature'=>'Tooth 32','display_name'=>'Tooth 32', 'display_order' =>  2, 'display_values' => '{"D":"D - Crown complete", "E":"E - Root length < crown", "F":"F - Funnel-shaped root ends", "G":"G - Root apices open", "H":"H - Root apices closed"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();


        $sb_id = SkeletalBone::where('name','=','Maxilla')->first()->id;
        $method_id = Method::where([['name','=','Blankenship et al 2007'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Tooth 1']);
        $data = array('method_id'=>$method_id,'feature'=>'Tooth 1','display_name'=>'Tooth 1', 'display_order' =>  1, 'display_values' => '{"D":"D - Crown complete", "E":"E - Root length < crown", "F":"F - Funnel-shaped root ends", "G":"G - Root apices open", "H":"H - Root apices closed"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name','=','Maxilla')->first()->id;
        $method_id = Method::where([['name','=','Blankenship et al 2007'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Tooth 16']);
        $data = array('method_id'=>$method_id,'feature'=>'Tooth 16','display_name'=>'Tooth 16', 'display_order' =>  2, 'display_values' => '{"D":"D - Crown complete", "E":"E - Root length < crown", "F":"F - Funnel-shaped root ends", "G":"G - Root apices open", "H":"H - Root apices closed"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();


        $sb_id = SkeletalBone::where('name','=','Cranium')->first()->id;
        $method_id = Method::where([['name','=','Blankenship et al 2007'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Tooth 1']);
        $data = array('method_id'=>$method_id,'feature'=>'Tooth 1','display_name'=>'Tooth 1', 'display_order' =>  1, 'display_values' => '{"D":"D - Crown complete", "E":"E - Root length < crown", "F":"F - Funnel-shaped root ends", "G":"G - Root apices open", "H":"H - Root apices closed"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name','=','Cranium')->first()->id;
        $method_id = Method::where([['name','=','Blankenship et al 2007'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Tooth 16']);
        $data = array('method_id'=>$method_id,'feature'=>'Tooth 16','display_name'=>'Tooth 16', 'display_order' =>  2, 'display_values' => '{"D":"D - Crown complete", "E":"E - Root length < crown", "F":"F - Funnel-shaped root ends", "G":"G - Root apices open", "H":"H - Root apices closed"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();


        $sb_id = SkeletalBone::where('name','=','Mandible')->first()->id;
        $method_id = Method::where([['name','=','Kasper et al 2009'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Tooth 17']);
        $data = array('method_id'=>$method_id,'feature'=>'Tooth 17','display_name'=>'Tooth 17', 'display_order' =>  1, 'display_values' => '{"B":"B - Mineralized cusps united", "C":"C - Crown half formed", "D":"D - Crown complete", "E":"E - Root length < crown", "F":"F - Funnel-shaped root ends", "G":"G - Root apices open", "H":"H - Root apices closed"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name','=','Mandible')->first()->id;
        $method_id = Method::where([['name','=','Kasper et al 2009'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Tooth 32']);
        $data = array('method_id'=>$method_id,'feature'=>'Tooth 32','display_name'=>'Tooth 32', 'display_order' =>  2, 'display_values' => '{"B":"B - Mineralized cusps united", "C":"C - Crown half formed", "D":"D - Crown complete", "E":"E - Root length < crown", "F":"F - Funnel-shaped root ends", "G":"G - Root apices open", "H":"H - Root apices closed"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();


        $sb_id = SkeletalBone::where('name','=','Maxilla')->first()->id;
        $method_id = Method::where([['name','=','Kasper et al 2009'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Tooth 1']);
        $data = array('method_id'=>$method_id,'feature'=>'Tooth 1','display_name'=>'Tooth 1', 'display_order' =>  1, 'display_values' => '{"B":"B - Mineralized cusps united", "C":"C - Crown half formed", "D":"D - Crown complete", "E":"E - Root length < crown", "F":"F - Funnel-shaped root ends", "G":"G - Root apices open", "H":"H - Root apices closed"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name','=','Maxilla')->first()->id;
        $method_id = Method::where([['name','=','Kasper et al 2009'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Tooth 16']);
        $data = array('method_id'=>$method_id,'feature'=>'Tooth 16','display_name'=>'Tooth 16', 'display_order' =>  2, 'display_values' => '{"B":"B - Mineralized cusps united", "C":"C - Crown half formed", "D":"D - Crown complete", "E":"E - Root length < crown", "F":"F - Funnel-shaped root ends", "G":"G - Root apices open", "H":"H - Root apices closed"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();


        $sb_id = SkeletalBone::where('name','=','Cranium')->first()->id;
        $method_id = Method::where([['name','=','Kasper et al 2009'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Tooth 1']);
        $data = array('method_id'=>$method_id,'feature'=>'Tooth 1','display_name'=>'Tooth 1', 'display_order' =>  1, 'display_values' => '{"B":"B - Mineralized cusps united", "C":"C - Crown half formed", "D":"D - Crown complete", "E":"E - Root length < crown", "F":"F - Funnel-shaped root ends", "G":"G - Root apices open", "H":"H - Root apices closed"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name','=','Cranium')->first()->id;
        $method_id = Method::where([['name','=','Kasper et al 2009'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Tooth 16']);
        $data = array('method_id'=>$method_id,'feature'=>'Tooth 16','display_name'=>'Tooth 16', 'display_order' =>  2, 'display_values' => '{"B":"B - Mineralized cusps united", "C":"C - Crown half formed", "D":"D - Crown complete", "E":"E - Root length < crown", "F":"F - Funnel-shaped root ends", "G":"G - Root apices open", "H":"H - Root apices closed"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();


        $sb_id = SkeletalBone::where('name','=','Humerus')->first()->id;
        $method_id = Method::where([['name','=','McKern and Stewart 1957'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Proximal']);
        $data = array('method_id'=>$method_id,'feature'=>'Proximal','display_name'=>'Proximal', 'display_order' =>  1, 'display_values' => '{"0":"0", "1":"1", "2":"2", "3":"3", "4":"4"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => '{"0":"17-20", "1":"17-20", "2":"17-21", "3":"17-23", "4":"17+"}', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name','=','Humerus')->first()->id;
        $method_id = Method::where([['name','=','McKern and Stewart 1957'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Medial Epicondyle']);
        $data = array('method_id'=>$method_id,'feature'=>'Medial Epicondyle','display_name'=>'Medial Epicondyle', 'display_order' =>  2, 'display_values' => '{"0":"0", "1":"1", "2":"2", "3":"3", "4":"4"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => '{"0":"<20", "1":"<20", "2":"<20", "3":"<20", "4":"17+"}', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();


        $sb_id = SkeletalBone::where('name','=','Radius')->first()->id;
        $method_id = Method::where([['name','=','McKern and Stewart 1957'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Proximal']);
        $data = array('method_id'=>$method_id,'feature'=>'Proximal','display_name'=>'Proximal', 'display_order' =>  1, 'display_values' => '{"0":"0", "1":"1", "2":"2", "3":"3", "4":"4"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => '{"0":"<19", "1":"<19", "2":"<19", "3":"<19", "4":"17-+"}', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name','=','Radius')->first()->id;
        $method_id = Method::where([['name','=','McKern and Stewart 1957'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Distal']);
        $data = array('method_id'=>$method_id,'feature'=>'Distal','display_name'=>'Distal', 'display_order' =>  2, 'display_values' => '{"0":"0", "1":"1", "2":"2", "3":"3", "4":"4"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => '{"0":"17-20", "1":"17-18", "2":"17-20", "3":"17-22", "4":"17+"}', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();


        $sb_id = SkeletalBone::where('name','=','Ulna')->first()->id;
        $method_id = Method::where([['name','=','McKern and Stewart 1957'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Proximal']);
        $data = array('method_id'=>$method_id,'feature'=>'Proximal','display_name'=>'Proximal', 'display_order' =>  1, 'display_values' => '{"0":"0", "1":"1", "2":"2", "3":"3", "4":"4"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => '{"0":"<19", "1":"<19", "2":"<19", "3":"<19", "4":"17+"}', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name','=','Ulna')->first()->id;
        $method_id = Method::where([['name','=','McKern and Stewart 1957'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Distal']);
        $data = array('method_id'=>$method_id,'feature'=>'Distal','display_name'=>'Distal', 'display_order' =>  2, 'display_values' => '{"0":"0", "1":"1", "2":"2", "3":"3", "4":"4"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => '{"0":"17-20", "1":"17-20", "2":"17-19", "3":"17-22", "4":"17+"}', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();


        $sb_id = SkeletalBone::where('name','=','Femur')->first()->id;
        $method_id = Method::where([['name','=','McKern and Stewart 1957'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Head']);
        $data = array('method_id'=>$method_id,'feature'=>'Head','display_name'=>'Head', 'display_order' =>  1, 'display_values' => '{"0":"0", "1":"1", "2":"2", "3":"3", "4":"4"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => '{"0":"<20", "1":"<20", "2":"<20", "3":"<20", "4":"17+"}', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name','=','Femur')->first()->id;
        $method_id = Method::where([['name','=','McKern and Stewart 1957'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Greater trochanter']);
        $data = array('method_id'=>$method_id,'feature'=>'Greater trochanter','display_name'=>'Greater trochanter', 'display_order' =>  2, 'display_values' => '{"0":"0", "1":"1", "2":"2", "3":"3", "4":"4"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => '{"0":"<20", "1":"<20", "2":"<20", "3":"<20", "4":"17+"}', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name','=','Femur')->first()->id;
        $method_id = Method::where([['name','=','McKern and Stewart 1957'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Lesser trochanter']);
        $data = array('method_id'=>$method_id,'feature'=>'Lesser trochanter','display_name'=>'Lesser trochanter', 'display_order' =>  3, 'display_values' => '{"0":"0", "1":"1", "2":"2", "3":"3", "4":"4"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => '{"0":"<20", "1":"<20", "2":"<20", "3":"<20", "4":"17+"}', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name','=','Femur')->first()->id;
        $method_id = Method::where([['name','=','McKern and Stewart 1957'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Distal']);
        $data = array('method_id'=>$method_id,'feature'=>'Distal','display_name'=>'Distal', 'display_order' =>  4, 'display_values' => '{"0":"0", "1":"1", "2":"2", "3":"3", "4":"4"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => '{"0":"17-19", "1":"17-18", "2":"17-20", "3":"17-21", "4":"17+"}', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();


        $sb_id = SkeletalBone::where('name','=','Tibia')->first()->id;
        $method_id = Method::where([['name','=','McKern and Stewart 1957'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Proximal']);
        $data = array('method_id'=>$method_id,'feature'=>'Proximal','display_name'=>'Proximal', 'display_order' =>  1, 'display_values' => '{"0":"0", "1":"1", "2":"2", "3":"3", "4":"4"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => '{"0":"17-19", "1":"17-18", "2":"17-19", "3":"17-22", "4":"17+"}', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name','=','Tibia')->first()->id;
        $method_id = Method::where([['name','=','McKern and Stewart 1957'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Distal']);
        $data = array('method_id'=>$method_id,'feature'=>'Distal','display_name'=>'Distal', 'display_order' =>  2, 'display_values' => '{"0":"0", "1":"1", "2":"2", "3":"3", "4":"4"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => '{"0":"<20", "1":"<20", "2":"<20", "3":"<20", "4":"17+"}', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();


        $sb_id = SkeletalBone::where('name','=','Fibula')->first()->id;
        $method_id = Method::where([['name','=','McKern and Stewart 1957'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Proximal']);
        $data = array('method_id'=>$method_id,'feature'=>'Proximal','display_name'=>'Proximal', 'display_order' =>  1, 'display_values' => '{"0":"0", "1":"1", "2":"2", "3":"3", "4":"4"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => '{"0":"17-19", "1":"N/A", "2":"17-20", "3":"17-21", "4":"17+"}', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name','=','Fibula')->first()->id;
        $method_id = Method::where([['name','=','McKern and Stewart 1957'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Distal']);
        $data = array('method_id'=>$method_id,'feature'=>'Distal','display_name'=>'Distal', 'display_order' =>  2, 'display_values' => '{"0":"0", "1":"1", "2":"2", "3":"3", "4":"4"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => '{"0":"<20", "1":"<20", "2":"<20", "3":"<20", "4":"17+"}', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();


        $sb_id = SkeletalBone::where('name','=','Os coxa')->first()->id;
        $method_id = Method::where([['name','=','McKern and Stewart 1957'],['submethod','=','Epiphyseal fusion'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Iliac crest']);
        $data = array('method_id'=>$method_id,'feature'=>'Iliac crest','display_name'=>'Iliac crest', 'display_order' =>  1, 'display_values' => '{"0":"0", "1":"1", "2":"2", "3":"3", "4":"4"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => '{"0":"17-20", "1":"17-21", "2":"17-22", "3":"17-22", "4":"18+"}', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name','=','Os coxa')->first()->id;
        $method_id = Method::where([['name','=','McKern and Stewart 1957'],['submethod','=','Epiphyseal fusion'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Ischial tuberosity']);
        $data = array('method_id'=>$method_id,'feature'=>'Ischial tuberosity','display_name'=>'Ischial tuberosity', 'display_order' =>  2, 'display_values' => '{"0":"0", "1":"1", "2":"2", "3":"3", "4":"4"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => '{"0":"17-22", "1":"17-21", "2":"17-23", "3":"17-23", "4":"17+"}', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();


        $sb_id = SkeletalBone::where('name','=','Clavicle')->first()->id;
        $method_id = Method::where([['name','=','McKern and Stewart 1957'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Medial ']);
        $data = array('method_id'=>$method_id,'feature'=>'Medial ','display_name'=>'Medial ', 'display_order' =>  1, 'display_values' => '{"0":"0", "1":"1", "2":"2", "3":"3", "4":"4"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => '{"0":"18-22", "1":"18-25", "2":"18-25", "3":"20-30", "4":"23+"}', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();


//        $sb_id = SkeletalBone::where('name','=','Cervical vertebra 1')->first()->id;
//        $method_id = Method::where([['name','=','McKern and Stewart 1957'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
//        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Epiphyseal Ring']);
//        $data = array('method_id'=>$method_id,'feature'=>'Epiphyseal Ring','display_name'=>'Epiphyseal Ring', 'display_order' =>  1, 'display_values' => '{"0":"0", "1":"1", "2":"2", "3":"3", "4":"4"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => '{"0":"17-18", "1":"17-20", "2":"17-22", "3":"17-23", "4":"17+"}', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
//        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();


        $sb_id = SkeletalBone::where('name','=','Cervical vertebra 2')->first()->id;
        $method_id = Method::where([['name','=','McKern and Stewart 1957'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Epiphyseal Ring']);
        $data = array('method_id'=>$method_id,'feature'=>'Epiphyseal Ring','display_name'=>'Epiphyseal Ring', 'display_order' =>  1, 'display_values' => '{"0":"0", "1":"1", "2":"2", "3":"3", "4":"4"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => '{"0":"17-18", "1":"17-20", "2":"17-22", "3":"17-23", "4":"17+"}', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();


        $sb_id = SkeletalBone::where('name','=','Cervical vertebra 3')->first()->id;
        $method_id = Method::where([['name','=','McKern and Stewart 1957'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Epiphyseal Ring']);
        $data = array('method_id'=>$method_id,'feature'=>'Epiphyseal Ring','display_name'=>'Epiphyseal Ring', 'display_order' =>  1, 'display_values' => '{"0":"0", "1":"1", "2":"2", "3":"3", "4":"4"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => '{"0":"17-18", "1":"17-20", "2":"17-22", "3":"17-23", "4":"17+"}', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name','=','Cervical vertebra 4')->first()->id;
        $method_id = Method::where([['name','=','McKern and Stewart 1957'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Epiphyseal Ring']);
        $data = array('method_id'=>$method_id,'feature'=>'Epiphyseal Ring','display_name'=>'Epiphyseal Ring', 'display_order' =>  1, 'display_values' => '{"0":"0", "1":"1", "2":"2", "3":"3", "4":"4"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => '{"0":"17-18", "1":"17-20", "2":"17-22", "3":"17-23", "4":"17+"}', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name','=','Cervical vertebra 5')->first()->id;
        $method_id = Method::where([['name','=','McKern and Stewart 1957'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Epiphyseal Ring']);
        $data = array('method_id'=>$method_id,'feature'=>'Epiphyseal Ring','display_name'=>'Epiphyseal Ring', 'display_order' =>  1, 'display_values' => '{"0":"0", "1":"1", "2":"2", "3":"3", "4":"4"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => '{"0":"17-18", "1":"17-20", "2":"17-22", "3":"17-23", "4":"17+"}', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name','=','Cervical vertebra 6')->first()->id;
        $method_id = Method::where([['name','=','McKern and Stewart 1957'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Epiphyseal Ring']);
        $data = array('method_id'=>$method_id,'feature'=>'Epiphyseal Ring','display_name'=>'Epiphyseal Ring', 'display_order' =>  1, 'display_values' => '{"0":"0", "1":"1", "2":"2", "3":"3", "4":"4"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => '{"0":"17-18", "1":"17-20", "2":"17-22", "3":"17-23", "4":"17+"}', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name','=','Cervical vertebra 6/7')->first()->id;
        $method_id = Method::where([['name','=','McKern and Stewart 1957'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Epiphyseal Ring']);
        $data = array('method_id'=>$method_id,'feature'=>'Epiphyseal Ring','display_name'=>'Epiphyseal Ring', 'display_order' =>  1, 'display_values' => '{"0":"0", "1":"1", "2":"2", "3":"3", "4":"4"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => '{"0":"17-18", "1":"17-20", "2":"17-22", "3":"17-23", "4":"17+"}', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name','=','Cervical vertebra 7')->first()->id;
        $method_id = Method::where([['name','=','McKern and Stewart 1957'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Epiphyseal Ring']);
        $data = array('method_id'=>$method_id,'feature'=>'Epiphyseal Ring','display_name'=>'Epiphyseal Ring', 'display_order' =>  1, 'display_values' => '{"0":"0", "1":"1", "2":"2", "3":"3", "4":"4"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => '{"0":"17-18", "1":"17-20", "2":"17-22", "3":"17-23", "4":"17+"}', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name','=','Extra vertebra')->first()->id;
        $method_id = Method::where([['name','=','McKern and Stewart 1957'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Epiphyseal Ring']);
        $data = array('method_id'=>$method_id,'feature'=>'Epiphyseal Ring','display_name'=>'Epiphyseal Ring', 'display_order' =>  1, 'display_values' => '{"0":"0", "1":"1", "2":"2", "3":"3", "4":"4"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => '{"0":"N/A", "1":"N/A", "2":"N/A", "3":"N/A", "4":"N/A"}', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name','=','Lumbar vertebra 1')->first()->id;
        $method_id = Method::where([['name','=','McKern and Stewart 1957'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Epiphyseal Ring']);
        $data = array('method_id'=>$method_id,'feature'=>'Epiphyseal Ring','display_name'=>'Epiphyseal Ring', 'display_order' =>  1, 'display_values' => '{"0":"0", "1":"1", "2":"2", "3":"3", "4":"4"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => '{"0":"17-18", "1":"17-20", "2":"17-22", "3":"17-23", "4":"17+"}', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name','=','Lumbar vertebra 1/2')->first()->id;
        $method_id = Method::where([['name','=','McKern and Stewart 1957'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Epiphyseal Ring']);
        $data = array('method_id'=>$method_id,'feature'=>'Epiphyseal Ring','display_name'=>'Epiphyseal Ring', 'display_order' =>  1, 'display_values' => '{"0":"0", "1":"1", "2":"2", "3":"3", "4":"4"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => '{"0":"17-18", "1":"17-20", "2":"17-22", "3":"17-23", "4":"17+"}', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name','=','Lumbar vertebra 2')->first()->id;
        $method_id = Method::where([['name','=','McKern and Stewart 1957'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Epiphyseal Ring']);
        $data = array('method_id'=>$method_id,'feature'=>'Epiphyseal Ring','display_name'=>'Epiphyseal Ring', 'display_order' =>  1, 'display_values' => '{"0":"0", "1":"1", "2":"2", "3":"3", "4":"4"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => '{"0":"17-18", "1":"17-20", "2":"17-22", "3":"17-23", "4":"17+"}', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name','=','Lumbar vertebra 2/3')->first()->id;
        $method_id = Method::where([['name','=','McKern and Stewart 1957'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Epiphyseal Ring']);
        $data = array('method_id'=>$method_id,'feature'=>'Epiphyseal Ring','display_name'=>'Epiphyseal Ring', 'display_order' =>  1, 'display_values' => '{"0":"0", "1":"1", "2":"2", "3":"3", "4":"4"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => '{"0":"17-18", "1":"17-20", "2":"17-22", "3":"17-23", "4":"17+"}', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name','=','Lumbar vertebra 3')->first()->id;
        $method_id = Method::where([['name','=','McKern and Stewart 1957'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Epiphyseal Ring']);
        $data = array('method_id'=>$method_id,'feature'=>'Epiphyseal Ring','display_name'=>'Epiphyseal Ring', 'display_order' =>  1, 'display_values' => '{"0":"0", "1":"1", "2":"2", "3":"3", "4":"4"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => '{"0":"17-18", "1":"17-20", "2":"17-22", "3":"17-23", "4":"17+"}', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name','=','Lumbar vertebra 3/4')->first()->id;
        $method_id = Method::where([['name','=','McKern and Stewart 1957'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Epiphyseal Ring']);
        $data = array('method_id'=>$method_id,'feature'=>'Epiphyseal Ring','display_name'=>'Epiphyseal Ring', 'display_order' =>  1, 'display_values' => '{"0":"0", "1":"1", "2":"2", "3":"3", "4":"4"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => '{"0":"17-18", "1":"17-20", "2":"17-22", "3":"17-23", "4":"17+"}', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name','=','Lumbar vertebra 4')->first()->id;
        $method_id = Method::where([['name','=','McKern and Stewart 1957'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Epiphyseal Ring']);
        $data = array('method_id'=>$method_id,'feature'=>'Epiphyseal Ring','display_name'=>'Epiphyseal Ring', 'display_order' =>  1, 'display_values' => '{"0":"0", "1":"1", "2":"2", "3":"3", "4":"4"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => '{"0":"17-18", "1":"17-20", "2":"17-22", "3":"17-23", "4":"17+"}', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name','=','Lumbar vertebra 4/5')->first()->id;
        $method_id = Method::where([['name','=','McKern and Stewart 1957'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Epiphyseal Ring']);
        $data = array('method_id'=>$method_id,'feature'=>'Epiphyseal Ring','display_name'=>'Epiphyseal Ring', 'display_order' =>  1, 'display_values' => '{"0":"0", "1":"1", "2":"2", "3":"3", "4":"4"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => '{"0":"17-18", "1":"17-20", "2":"17-22", "3":"17-23", "4":"17+"}', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name','=','Lumbar vertebra 5')->first()->id;
        $method_id = Method::where([['name','=','McKern and Stewart 1957'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Epiphyseal Ring']);
        $data = array('method_id'=>$method_id,'feature'=>'Epiphyseal Ring','display_name'=>'Epiphyseal Ring', 'display_order' =>  1, 'display_values' => '{"0":"0", "1":"1", "2":"2", "3":"3", "4":"4"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => '{"0":"17-18", "1":"17-20", "2":"17-22", "3":"17-23", "4":"17+"}', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name','=','Unseriated rib')->first()->id;
        $method_id = Method::where([['name','=','McKern and Stewart 1957'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Head']);
        $data = array('method_id'=>$method_id,'feature'=>'Head','display_name'=>'Head', 'display_order' =>  1, 'display_values' => '{"0":"0", "1":"1", "2":"2", "3":"3", "4":"4"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => '{"0":"<24", "1":"<24", "2":"<24", "3":"<24", "4":"18+"}', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name','=','Rib 1')->first()->id;
        $method_id = Method::where([['name','=','McKern and Stewart 1957'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Head']);
        $data = array('method_id'=>$method_id,'feature'=>'Head','display_name'=>'Head', 'display_order' =>  1, 'display_values' => '{"0":"0", "1":"1", "2":"2", "3":"3", "4":"4"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => '{"0":"<24", "1":"<24", "2":"<24", "3":"<24", "4":"18+"}', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name','=','Rib 10')->first()->id;
        $method_id = Method::where([['name','=','McKern and Stewart 1957'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Head']);
        $data = array('method_id'=>$method_id,'feature'=>'Head','display_name'=>'Head', 'display_order' =>  1, 'display_values' => '{"0":"0", "1":"1", "2":"2", "3":"3", "4":"4"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => '{"0":"<24", "1":"<24", "2":"<24", "3":"<24", "4":"18+"}', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name','=','Rib 10/11')->first()->id;
        $method_id = Method::where([['name','=','McKern and Stewart 1957'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Head']);
        $data = array('method_id'=>$method_id,'feature'=>'Head','display_name'=>'Head', 'display_order' =>  1, 'display_values' => '{"0":"0", "1":"1", "2":"2", "3":"3", "4":"4"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => '{"0":"<24", "1":"<24", "2":"<24", "3":"<24", "4":"18+"}', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name','=','Rib 11')->first()->id;
        $method_id = Method::where([['name','=','McKern and Stewart 1957'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Head']);
        $data = array('method_id'=>$method_id,'feature'=>'Head','display_name'=>'Head', 'display_order' =>  1, 'display_values' => '{"0":"0", "1":"1", "2":"2", "3":"3", "4":"4"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => '{"0":"<24", "1":"<24", "2":"<24", "3":"<24", "4":"18+"}', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name','=','Rib 11/12')->first()->id;
        $method_id = Method::where([['name','=','McKern and Stewart 1957'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Head']);
        $data = array('method_id'=>$method_id,'feature'=>'Head','display_name'=>'Head', 'display_order' =>  1, 'display_values' => '{"0":"0", "1":"1", "2":"2", "3":"3", "4":"4"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => '{"0":"<24", "1":"<24", "2":"<24", "3":"<24", "4":"18+"}', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name','=','Rib 12')->first()->id;
        $method_id = Method::where([['name','=','McKern and Stewart 1957'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Head']);
        $data = array('method_id'=>$method_id,'feature'=>'Head','display_name'=>'Head', 'display_order' =>  1, 'display_values' => '{"0":"0", "1":"1", "2":"2", "3":"3", "4":"4"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => '{"0":"<24", "1":"<24", "2":"<24", "3":"<24", "4":"18+"}', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name','=','Rib 2')->first()->id;
        $method_id = Method::where([['name','=','McKern and Stewart 1957'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Head']);
        $data = array('method_id'=>$method_id,'feature'=>'Head','display_name'=>'Head', 'display_order' =>  1, 'display_values' => '{"0":"0", "1":"1", "2":"2", "3":"3", "4":"4"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => '{"0":"<24", "1":"<24", "2":"<24", "3":"<24", "4":"18+"}', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name','=','Rib 2/3')->first()->id;
        $method_id = Method::where([['name','=','McKern and Stewart 1957'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Head']);
        $data = array('method_id'=>$method_id,'feature'=>'Head','display_name'=>'Head', 'display_order' =>  1, 'display_values' => '{"0":"0", "1":"1", "2":"2", "3":"3", "4":"4"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => '{"0":"<24", "1":"<24", "2":"<24", "3":"<24", "4":"18+"}', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name','=','Rib 3')->first()->id;
        $method_id = Method::where([['name','=','McKern and Stewart 1957'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Head']);
        $data = array('method_id'=>$method_id,'feature'=>'Head','display_name'=>'Head', 'display_order' =>  1, 'display_values' => '{"0":"0", "1":"1", "2":"2", "3":"3", "4":"4"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => '{"0":"<24", "1":"<24", "2":"<24", "3":"<24", "4":"18+"}', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name','=','Rib 3/4')->first()->id;
        $method_id = Method::where([['name','=','McKern and Stewart 1957'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Head']);
        $data = array('method_id'=>$method_id,'feature'=>'Head','display_name'=>'Head', 'display_order' =>  1, 'display_values' => '{"0":"0", "1":"1", "2":"2", "3":"3", "4":"4"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => '{"0":"<24", "1":"<24", "2":"<24", "3":"<24", "4":"18+"}', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name','=','Rib 4')->first()->id;
        $method_id = Method::where([['name','=','McKern and Stewart 1957'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Head']);
        $data = array('method_id'=>$method_id,'feature'=>'Head','display_name'=>'Head', 'display_order' =>  1, 'display_values' => '{"0":"0", "1":"1", "2":"2", "3":"3", "4":"4"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => '{"0":"<24", "1":"<24", "2":"<24", "3":"<24", "4":"18+"}', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name','=','Rib 5')->first()->id;
        $method_id = Method::where([['name','=','McKern and Stewart 1957'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Head']);
        $data = array('method_id'=>$method_id,'feature'=>'Head','display_name'=>'Head', 'display_order' =>  1, 'display_values' => '{"0":"0", "1":"1", "2":"2", "3":"3", "4":"4"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => '{"0":"<24", "1":"<24", "2":"<24", "3":"<24", "4":"18+"}', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name','=','Rib 6')->first()->id;
        $method_id = Method::where([['name','=','McKern and Stewart 1957'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Head']);
        $data = array('method_id'=>$method_id,'feature'=>'Head','display_name'=>'Head', 'display_order' =>  1, 'display_values' => '{"0":"0", "1":"1", "2":"2", "3":"3", "4":"4"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => '{"0":"<24", "1":"<24", "2":"<24", "3":"<24", "4":"18+"}', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name','=','Rib 7')->first()->id;
        $method_id = Method::where([['name','=','McKern and Stewart 1957'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Head']);
        $data = array('method_id'=>$method_id,'feature'=>'Head','display_name'=>'Head', 'display_order' =>  1, 'display_values' => '{"0":"0", "1":"1", "2":"2", "3":"3", "4":"4"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => '{"0":"<24", "1":"<24", "2":"<24", "3":"<24", "4":"18+"}', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name','=','Rib 8')->first()->id;
        $method_id = Method::where([['name','=','McKern and Stewart 1957'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Head']);
        $data = array('method_id'=>$method_id,'feature'=>'Head','display_name'=>'Head', 'display_order' =>  1, 'display_values' => '{"0":"0", "1":"1", "2":"2", "3":"3", "4":"4"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => '{"0":"<24", "1":"<24", "2":"<24", "3":"<24", "4":"18+"}', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name','=','Rib 9')->first()->id;
        $method_id = Method::where([['name','=','McKern and Stewart 1957'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Head']);
        $data = array('method_id'=>$method_id,'feature'=>'Head','display_name'=>'Head', 'display_order' =>  1, 'display_values' => '{"0":"0", "1":"1", "2":"2", "3":"3", "4":"4"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => '{"0":"<24", "1":"<24", "2":"<24", "3":"<24", "4":"18+"}', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name','=','Thoracic vertebra 1')->first()->id;
        $method_id = Method::where([['name','=','McKern and Stewart 1957'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Epiphyseal Ring']);
        $data = array('method_id'=>$method_id,'feature'=>'Epiphyseal Ring','display_name'=>'Epiphyseal Ring', 'display_order' =>  1, 'display_values' => '{"0":"0", "1":"1", "2":"2", "3":"3", "4":"4"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => '{"0":"<20", "1":"<20", "2":"<20", "3":"<20", "4":"17+"}', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name','=','Thoracic vertebra 1')->first()->id;
        $method_id = Method::where([['name','=','McKern and Stewart 1957'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Epiphyseal Ring']);
        $data = array('method_id'=>$method_id,'feature'=>'Epiphyseal Ring','display_name'=>'Epiphyseal Ring', 'display_order' =>  2, 'display_values' => '{"0":"0", "1":"1", "2":"2", "3":"3", "4":"4"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => '{"0":"<20", "1":"<20", "2":"<20", "3":"<20", "4":"17+"}', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name','=','Thoracic vertebra 1/2')->first()->id;
        $method_id = Method::where([['name','=','McKern and Stewart 1957'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Epiphyseal Ring']);
        $data = array('method_id'=>$method_id,'feature'=>'Epiphyseal Ring','display_name'=>'Epiphyseal Ring', 'display_order' =>  1, 'display_values' => '{"0":"0", "1":"1", "2":"2", "3":"3", "4":"4"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => '{"0":"<25", "1":"<25", "2":"<25", "3":"<25", "4":"17+"}', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name','=','Thoracic vertebra 10')->first()->id;
        $method_id = Method::where([['name','=','McKern and Stewart 1957'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Epiphyseal Ring']);
        $data = array('method_id'=>$method_id,'feature'=>'Epiphyseal Ring','display_name'=>'Epiphyseal Ring', 'display_order' =>  1, 'display_values' => '{"0":"0", "1":"1", "2":"2", "3":"3", "4":"4"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => '{"0":"<19", "1":"<19", "2":"<19", "3":"<19", "4":"17+"}', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name','=','Thoracic vertebra 10/11')->first()->id;
        $method_id = Method::where([['name','=','McKern and Stewart 1957'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Epiphyseal Ring']);
        $data = array('method_id'=>$method_id,'feature'=>'Epiphyseal Ring','display_name'=>'Epiphyseal Ring', 'display_order' =>  1, 'display_values' => '{"0":"0", "1":"1", "2":"2", "3":"3", "4":"4"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => '{"0":"<19", "1":"<19", "2":"<19", "3":"<19", "4":"17+"}', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name','=','Thoracic vertebra 10/11/12')->first()->id;
        $method_id = Method::where([['name','=','McKern and Stewart 1957'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Epiphyseal Ring']);
        $data = array('method_id'=>$method_id,'feature'=>'Epiphyseal Ring','display_name'=>'Epiphyseal Ring', 'display_order' =>  1, 'display_values' => '{"0":"0", "1":"1", "2":"2", "3":"3", "4":"4"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => '{"0":"<19", "1":"<19", "2":"<19", "3":"<19", "4":"17+"}', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name','=','Thoracic vertebra 11')->first()->id;
        $method_id = Method::where([['name','=','McKern and Stewart 1957'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Epiphyseal Ring']);
        $data = array('method_id'=>$method_id,'feature'=>'Epiphyseal Ring','display_name'=>'Epiphyseal Ring', 'display_order' =>  1, 'display_values' => '{"0":"0", "1":"1", "2":"2", "3":"3", "4":"4"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => '{"0":"<19", "1":"<19", "2":"<19", "3":"<19", "4":"17+"}', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name','=','Thoracic vertebra 11/12')->first()->id;
        $method_id = Method::where([['name','=','McKern and Stewart 1957'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Epiphyseal Ring']);
        $data = array('method_id'=>$method_id,'feature'=>'Epiphyseal Ring','display_name'=>'Epiphyseal Ring', 'display_order' =>  1, 'display_values' => '{"0":"0", "1":"1", "2":"2", "3":"3", "4":"4"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => '{"0":"<19", "1":"<19", "2":"<19", "3":"<19", "4":"17+"}', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name','=','Thoracic vertebra 12')->first()->id;
        $method_id = Method::where([['name','=','McKern and Stewart 1957'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Epiphyseal Ring']);
        $data = array('method_id'=>$method_id,'feature'=>'Epiphyseal Ring','display_name'=>'Epiphyseal Ring', 'display_order' =>  1, 'display_values' => '{"0":"0", "1":"1", "2":"2", "3":"3", "4":"4"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => '{"0":"<19", "1":"<19", "2":"<19", "3":"<19", "4":"17+"}', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name','=','Thoracic vertebra 2')->first()->id;
        $method_id = Method::where([['name','=','McKern and Stewart 1957'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Epiphyseal Ring']);
        $data = array('method_id'=>$method_id,'feature'=>'Epiphyseal Ring','display_name'=>'Epiphyseal Ring', 'display_order' =>  1, 'display_values' => '{"0":"0", "1":"1", "2":"2", "3":"3", "4":"4"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => '{"0":"<25", "1":"<25", "2":"<25", "3":"<25", "4":"17+"}', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name','=','Thoracic vertebra 3')->first()->id;
        $method_id = Method::where([['name','=','McKern and Stewart 1957'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Epiphyseal Ring']);
        $data = array('method_id'=>$method_id,'feature'=>'Epiphyseal Ring','display_name'=>'Epiphyseal Ring', 'display_order' =>  1, 'display_values' => '{"0":"0", "1":"1", "2":"2", "3":"3", "4":"4"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => '{"0":"<25", "1":"<25", "2":"<25", "3":"<25", "4":"17+"}', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name','=','Thoracic vertebra 4')->first()->id;
        $method_id = Method::where([['name','=','McKern and Stewart 1957'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Epiphyseal Ring']);
        $data = array('method_id'=>$method_id,'feature'=>'Epiphyseal Ring','display_name'=>'Epiphyseal Ring', 'display_order' =>  1, 'display_values' => '{"0":"0", "1":"1", "2":"2", "3":"3", "4":"4"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => '{"0":"<25", "1":"<25", "2":"<25", "3":"<25", "4":"17+"}', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name','=','Thoracic vertebra 5')->first()->id;
        $method_id = Method::where([['name','=','McKern and Stewart 1957'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Epiphyseal Ring']);
        $data = array('method_id'=>$method_id,'feature'=>'Epiphyseal Ring','display_name'=>'Epiphyseal Ring', 'display_order' =>  1, 'display_values' => '{"0":"0", "1":"1", "2":"2", "3":"3", "4":"4"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => '{"0":"<25", "1":"<25", "2":"<25", "3":"<25", "4":"17+"}', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name','=','Thoracic vertebra 6')->first()->id;
        $method_id = Method::where([['name','=','McKern and Stewart 1957'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Epiphyseal Ring']);
        $data = array('method_id'=>$method_id,'feature'=>'Epiphyseal Ring','display_name'=>'Epiphyseal Ring', 'display_order' =>  1, 'display_values' => '{"0":"0", "1":"1", "2":"2", "3":"3", "4":"4"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => '{"0":"<25", "1":"<25", "2":"<25", "3":"<25", "4":"17+"}', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name','=','Thoracic vertebra 7')->first()->id;
        $method_id = Method::where([['name','=','McKern and Stewart 1957'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Epiphyseal Ring']);
        $data = array('method_id'=>$method_id,'feature'=>'Epiphyseal Ring','display_name'=>'Epiphyseal Ring', 'display_order' =>  1, 'display_values' => '{"0":"0", "1":"1", "2":"2", "3":"3", "4":"4"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => '{"0":"<23", "1":"<23", "2":"<23", "3":"<23", "4":"17+"}', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name','=','Thoracic vertebra 8')->first()->id;
        $method_id = Method::where([['name','=','McKern and Stewart 1957'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Epiphyseal Ring']);
        $data = array('method_id'=>$method_id,'feature'=>'Epiphyseal Ring','display_name'=>'Epiphyseal Ring', 'display_order' =>  1, 'display_values' => '{"0":"0", "1":"1", "2":"2", "3":"3", "4":"4"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => '{"0":"<19", "1":"<19", "2":"<19", "3":"<19", "4":"17+"}', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name','=','Thoracic vertebra 9')->first()->id;
        $method_id = Method::where([['name','=','McKern and Stewart 1957'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Epiphyseal Ring']);
        $data = array('method_id'=>$method_id,'feature'=>'Epiphyseal Ring','display_name'=>'Epiphyseal Ring', 'display_order' =>  1, 'display_values' => '{"0":"0", "1":"1", "2":"2", "3":"3", "4":"4"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => '{"0":"<19", "1":"<19", "2":"<19", "3":"<19", "4":"17+"}', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name','=','Unseriated cervical vertebra')->first()->id;
        $method_id = Method::where([['name','=','McKern and Stewart 1957'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Epiphyseal Ring']);
        $data = array('method_id'=>$method_id,'feature'=>'Epiphyseal Ring','display_name'=>'Epiphyseal Ring', 'display_order' =>  1, 'display_values' => '{"0":"0", "1":"1", "2":"2", "3":"3", "4":"4"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => '{"0":"17-18", "1":"17-20", "2":"17-22", "3":"17-23", "4":"17+"}', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name','=','Unseriated lumbar vertebra')->first()->id;
        $method_id = Method::where([['name','=','McKern and Stewart 1957'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Epiphyseal Ring']);
        $data = array('method_id'=>$method_id,'feature'=>'Epiphyseal Ring','display_name'=>'Epiphyseal Ring', 'display_order' =>  1, 'display_values' => '{"0":"0", "1":"1", "2":"2", "3":"3", "4":"4"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => '{"0":"17-18", "1":"17-20", "2":"17-22", "3":"17-23", "4":"17+"}', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name','=','Unseriated thoracic vertebra')->first()->id;
        $method_id = Method::where([['name','=','McKern and Stewart 1957'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Epiphyseal Ring']);
        $data = array('method_id'=>$method_id,'feature'=>'Epiphyseal Ring','display_name'=>'Epiphyseal Ring', 'display_order' =>  1, 'display_values' => '{"0":"0", "1":"1", "2":"2", "3":"3", "4":"4"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => '{"0":"<25", "1":"<25", "2":"<25", "3":"<25", "4":"17+"}', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name','=','Unidentified vertebra')->first()->id;
        $method_id = Method::where([['name','=','McKern and Stewart 1957'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Epiphyseal Ring']);
        $data = array('method_id'=>$method_id,'feature'=>'Epiphyseal Ring','display_name'=>'Epiphyseal Ring', 'display_order' =>  1, 'display_values' => '{"0":"0", "1":"1", "2":"2", "3":"3", "4":"4"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => '{"0":"17-18", "1":"17-20", "2":"17-22", "3":"17-23", "4":"17+"}', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name','=','Scapula')->first()->id;
        $method_id = Method::where([['name','=','McKern and Stewart 1957'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Acromion']);
        $data = array('method_id'=>$method_id,'feature'=>'Acromion','display_name'=>'Acromion', 'display_order' =>  1, 'display_values' => '{"0":"0", "1":"1", "2":"2", "3":"3", "4":"4"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => '{"0":"17-22", "1":"18-19", "2":"18-20", "3":"17-21", "4":"17+"}', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name','=','Scapula')->first()->id;
        $method_id = Method::where([['name','=','McKern and Stewart 1957'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Inferior Angle']);
        $data = array('method_id'=>$method_id,'feature'=>'Inferior Angle','display_name'=>'Inferior Angle', 'display_order' =>  2, 'display_values' => '{"0":"0", "1":"1", "2":"2", "3":"3", "4":"4"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => '{"0":"17-21", "1":"17-18", "2":"18-22", "3":"18-21", "4":"17+"}', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name','=','Scapula')->first()->id;
        $method_id = Method::where([['name','=','McKern and Stewart 1957'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Medial Border']);
        $data = array('method_id'=>$method_id,'feature'=>'Medial Border','display_name'=>'Medial Border', 'display_order' =>  3, 'display_values' => '{"0":"0", "1":"1", "2":"2", "3":"3", "4":"4"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => '{"0":"17-20", "1":"18-22", "2":"18-22", "3":"17-22", "4":"17+"}', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name','=','Sternum')->first()->id;
        $method_id = Method::where([['name','=','McKern and Stewart 1957'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Sternebra 1 + 2 ']);
        $data = array('method_id'=>$method_id,'feature'=>'Sternebra 1 + 2 ','display_name'=>'Sternebra 1 + 2 ', 'display_order' =>  1, 'display_values' => '{"0":"0", "1":"1", "2":"2", "3":"3", "4":"4"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => '{"0":"17-30", "1":"17-20", "2":"17-25", "3":"17-30", "4":"17+"}', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name','=','Sternum')->first()->id;
        $method_id = Method::where([['name','=','McKern and Stewart 1957'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Sternebra 2 +3 ']);
        $data = array('method_id'=>$method_id,'feature'=>'Sternebra 2 +3 ','display_name'=>'Sternebra 2 +3 ', 'display_order' =>  2, 'display_values' => '{"0":"0", "1":"1", "2":"2", "3":"3", "4":"4"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => '{"0":"17-22", "1":"17-21", "2":"17-21", "3":"17-25", "4":"17+"}', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name','=','Sacrum')->first()->id;
        $method_id = Method::where([['name','=','McKern and Stewart 1957'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'S1 + S2']);
        $data = array('method_id'=>$method_id,'feature'=>'S1 + S2','display_name'=>'S1 + S2', 'display_order' =>  1, 'display_values' => '{"0":"0", "1":"1", "2":"2", "3":"3", "4":"4"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => '{"0":"17-19", "1":"17-21", "2":"17-22", "3":"17-32", "4":"17+"}', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name','=','Sacrum')->first()->id;
        $method_id = Method::where([['name','=','McKern and Stewart 1957'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'S2 + S3']);
        $data = array('method_id'=>$method_id,'feature'=>'S2 + S3','display_name'=>'S2 + S3', 'display_order' =>  2, 'display_values' => '{"0":"0", "1":"1", "2":"2", "3":"3", "4":"4"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => '{"0":"N/A", "1":"N/A", "2":"17-21", "3":"17-23", "4":"17+"}', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name','=','Sacrum')->first()->id;
        $method_id = Method::where([['name','=','McKern and Stewart 1957'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'S3+ S4 ']);
        $data = array('method_id'=>$method_id,'feature'=>'S3+ S4 ','display_name'=>'S3+ S4 ', 'display_order' =>  3, 'display_values' => '{"0":"0", "1":"1", "2":"2", "3":"3", "4":"4"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => '{"0":"17-18", "1":"17-19", "2":"17-19", "3":"17-22", "4":"17+"}', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name','=','Sacrum')->first()->id;
        $method_id = Method::where([['name','=','McKern and Stewart 1957'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'S4 + S5']);
        $data = array('method_id'=>$method_id,'feature'=>'S4 + S5','display_name'=>'S4 + S5', 'display_order' =>  4, 'display_values' => '{"0":"0", "1":"1", "2":"2", "3":"3", "4":"4"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => '{"0":"17-18", "1":"17-19", "2":"17-19", "3":"17-22", "4":"17+"}', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name','=','Sacrum')->first()->id;
        $method_id = Method::where([['name','=','McKern and Stewart 1957'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'S1: Sup. Epiphyseal Ring']);
        $data = array('method_id'=>$method_id,'feature'=>'S1: Sup. Epiphyseal Ring','display_name'=>'S1: Sup. Epiphyseal Ring', 'display_order' =>  5, 'display_values' => '{"0":"0", "1":"1", "2":"2", "3":"3", "4":"4"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => '{"0":"17-19", "1":"17-19", "2":"17-19", "3":"17-21", "4":"17+"}', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name','=','Sacrum')->first()->id;
        $method_id = Method::where([['name','=','McKern and Stewart 1957'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Lateral Joints']);
        $data = array('method_id'=>$method_id,'feature'=>'Lateral Joints','display_name'=>'Lateral Joints', 'display_order' =>  6, 'display_values' => '{"0":"0", "1":"1", "2":"2", "3":"3", "4":"4"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => '{"0":"N/A", "1":"17", "2":"17-19", "3":"17-21", "4":"18+"}', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name','=','Sacrum')->first()->id;
        $method_id = Method::where([['name','=','McKern and Stewart 1957'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Auricular Epiphysis']);
        $data = array('method_id'=>$method_id,'feature'=>'Auricular Epiphysis','display_name'=>'Auricular Epiphysis', 'display_order' =>  7, 'display_values' => '{"0":"0", "1":"1", "2":"2", "3":"3", "4":"4"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => '{"0":"17-19", "1":"17-19", "2":"17-21", "3":"17-21", "4":"18+"}', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name','=','Os coxa')->first()->id;
        $method_id = Method::where([['name','=','McKern and Stewart 1957'],['submethod','=','Pubic symphysis'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Dorsal']);
        $data = array('method_id'=>$method_id,'feature'=>'Dorsal','display_name'=>'Dorsal', 'display_order' =>  1, 'display_values' => '{"0":"0", "1":"1", "2":"2", "3":"3", "4":"4", "5":"5"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => '{"0":"17-18", "1":"18-21", "2":"18-21", "3":"18-24", "4":"19-30", "5":"23+"}', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name','=','Os coxa')->first()->id;
        $method_id = Method::where([['name','=','McKern and Stewart 1957'],['submethod','=','Pubic symphysis'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Ventral']);
        $data = array('method_id'=>$method_id,'feature'=>'Ventral','display_name'=>'Ventral', 'display_order' =>  2, 'display_values' => '{"0":"0", "1":"1", "2":"2", "3":"3", "4":"4", "5":"5"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => '{"0":"17-22", "1":"19-23", "2":"19-24", "3":"21-28", "4":"22-33", "5":"24+"}', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name','=','Os coxa')->first()->id;
        $method_id = Method::where([['name','=','McKern and Stewart 1957'],['submethod','=','Pubic symphysis'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Rim']);
        $data = array('method_id'=>$method_id,'feature'=>'Rim','display_name'=>'Rim', 'display_order' =>  3, 'display_values' => '{"0":"0", "1":"1", "2":"2", "3":"3", "4":"4", "5":"5"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => '{"0":"17-24", "1":"21-28", "2":"24-32", "3":"24-39", "4":"29+", "5":"38+"}', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name','=','Os coxa')->first()->id;
        $method_id = Method::where([['name','=','McKern and Stewart 1957'],['submethod','=','Pubic symphysis'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'SUMALL']);
        $data = array('method_id'=>$method_id,'feature'=>'SUMALL','display_name'=>'Composite Score - SUMALL', 'display_order' => 4,
            'display_values' => '{"0":"0", "1":"1", "2":"2", "3":"3", "4":"4", "5":"5", "6":"6", "7":"7", "8":"8", "9":"9", "10":"10", "11":"11", "12":"12", "13":"13", "14":"14", "15":"15"}',
            'computed' => true, 'compute_rule' => 'Dorsal,Ventral,Rim', 'display_interval' => '{"0":"<19", "1":"17-20", "2":"17-20", "3":"18-21", "4":"18-23", "5":"18-23", "6":"20-24", "7":"20-24", "8":"22-28", "9":"22-28", "10":"23-28", "11":"23-39", "12":"23-39", "13":"23-39", "14":"29+", "15":"36+"}', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();

        //////////////////////////////////////////////////////////////////
        /// Start - New Schaefer 2008 method

        $sb_id = SkeletalBone::where('name','=','Humerus')->first()->id;
        $method_id = Method::where([['name','=','Schaefer 2008'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Proximal Humerus']);
        $data = array('method_id'=>$method_id,'feature'=>'Proximal Humerus','display_name'=>'Proximal Humerus', 'display_order' =>  1, 'display_values' => '{"0":"0", "1":"1", "2":"2"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => '{"0":"≤20", "1":"16-21", "2":"≥18"}', 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();

        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Medial Humerus']);
        $data = array('method_id'=>$method_id,'feature'=>'Medial Humerus','display_name'=>'Medial Humerus', 'display_order' =>  2, 'display_values' => '{"0":"0", "1":"1", "2":"2"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => '{"0":"≤18", "1":"16-17", "2":"≥16"}', 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();

        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Distal Humerus']);
        $data = array('method_id'=>$method_id,'feature'=>'Distal Humerus','display_name'=>'Distal Humerus', 'display_order' =>  3, 'display_values' => '{"0":"0", "1":"1", "2":"2"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => '{"0":"≤14", "1":"15-18", "2":"≥15"}', 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name','=','Radius')->first()->id;
        $method_id = Method::where([['name','=','Schaefer 2008'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Proximal Radius']);
        $data = array('method_id'=>$method_id,'feature'=>'Proximal Radius','display_name'=>'Proximal Radius', 'display_order' =>  1, 'display_values' => '{"0":"0", "1":"1", "2":"2"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => '{"0":"≤18", "1":"15-18", "2":"≥16"}', 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();

        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Distal Radius']);
        $data = array('method_id'=>$method_id,'feature'=>'Distal Radius','display_name'=>'Distal Radius', 'display_order' =>  2, 'display_values' => '{"0":"0", "1":"1", "2":"2"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => '{"0":"≤19", "1":"16-20", "2":"≥17"}', 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name','=','Ulna')->first()->id;
        $method_id = Method::where([['name','=','Schaefer 2008'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Proximal Ulna']);
        $data = array('method_id'=>$method_id,'feature'=>'Proximal Ulna','display_name'=>'Proximal Ulna', 'display_order' =>  1, 'display_values' => '{"0":"0", "1":"1", "2":"2"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => '{"0":"≤14", "1":"15-18", "2":"≥15"}', 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();

        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Distal Ulna']);
        $data = array('method_id'=>$method_id,'feature'=>'Distal Ulna','display_name'=>'Distal Ulna', 'display_order' =>  2, 'display_values' => '{"0":"0", "1":"1", "2":"2"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => '{"0":"≤20", "1":"17-20", "2":"≥17"}', 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name','=','Femur')->first()->id;
        $method_id = Method::where([['name','=','Schaefer 2008'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Proximal Femur']);
        $data = array('method_id'=>$method_id,'feature'=>'Proximal Femur','display_name'=>'Proximal Femur', 'display_order' =>  1, 'display_values' => '{"0":"0", "1":"1", "2":"2"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => '{"0":"≤18", "1":"16-20", "2":"≥16"}', 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();

        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Greater Trochanter']);
        $data = array('method_id'=>$method_id,'feature'=>'Greater Trochanter','display_name'=>'Greater Trochanter', 'display_order' =>  2, 'display_values' => '{"0":"0", "1":"1", "2":"2"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => '{"0":"≤18", "1":16-20"", "2":"≥16"}', 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();

        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Lesser Trochanter']);
        $data = array('method_id'=>$method_id,'feature'=>'Lesser Trochanter','display_name'=>'Lesser Trochanter', 'display_order' =>  3, 'display_values' => '{"0":"0", "1":"1", "2":"2"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => '{"0":"≤18", "1":"16-20", "2":"≥16"}', 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();

        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Distal Femur']);
        $data = array('method_id'=>$method_id,'feature'=>'Distal Femur','display_name'=>'Distal Femur', 'display_order' =>  4, 'display_values' => '{"0":"0", "1":"1", "2":"2"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => '{"0":"≤19", "1":"16-20", "2":"≥17"}', 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name','=','Tibia')->first()->id;
        $method_id = Method::where([['name','=','Schaefer 2008'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Proximal Tibia']);
        $data = array('method_id'=>$method_id,'feature'=>'Proximal Tibia','display_name'=>'Proximal Tibia', 'display_order' =>  1, 'display_values' => '{"0":"0", "1":"1", "2":"2"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => '{"0":"≤18", "1":"16-20", "2":"≥17"}', 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();

        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Distal Tibia']);
        $data = array('method_id'=>$method_id,'feature'=>'Distal Tibia','display_name'=>'Distal Tibia', 'display_order' =>  2, 'display_values' => '{"0":"0", "1":"1", "2":"2"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => '{"0":"≤18", "1":"16-18", "2":"≥16"}', 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name','=','Fibula')->first()->id;
        $method_id = Method::where([['name','=','Schaefer 2008'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Proximal Fibula']);
        $data = array('method_id'=>$method_id,'feature'=>'Proximal Fibula','display_name'=>'Proximal Fibula', 'display_order' =>  1, 'display_values' => '{"0":"0", "1":"1", "2":"2"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => '{"0":"≤20", "1":"16-20", "2":"≥17"}', 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();

        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Distal Fibula']);
        $data = array('method_id'=>$method_id,'feature'=>'Distal Fibula','display_name'=>'Distal Fibula', 'display_order' =>  2, 'display_values' => '{"0":"0", "1":"1", "2":"2"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => '{"0":"≤18", "1":"16-20", "2":"≥17"}', 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name','=','Os coxa')->first()->id;
        $method_id = Method::where([['name','=','Schaefer 2008'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Tri-radiate Complex']);
        $data = array('method_id'=>$method_id,'feature'=>'Tri-radiate Complex','display_name'=>'Tri-radiate Complex', 'display_order' =>  1, 'display_values' => '{"0":"0", "1":"1", "2":"2"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => '{"0":"NA", "1":"≤20", "2":"≥16"}', 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();

        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Ant Inf Iliac Spine']);
        $data = array('method_id'=>$method_id,'feature'=>'Ant Inf Iliac Spine','display_name'=>'Ant Inf Iliac Spine', 'display_order' =>  2, 'display_values' => '{"0":"0", "1":"1", "2":"2"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => '{"0":"≤18", "1":"16", "2":"≥16"}', 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();

        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Ischium']);
        $data = array('method_id'=>$method_id,'feature'=>'Ischium','display_name'=>'Ischium', 'display_order' =>  3, 'display_values' => '{"0":"0", "1":"1", "2":"2"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => '{"0":"≤18", "1":"16-20", "2":"≥17"}', 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();

        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Iliac Crest']);
        $data = array('method_id'=>$method_id,'feature'=>'Iliac Crest','display_name'=>'Iliac Crest', 'display_order' =>  4, 'display_values' => '{"0":"0", "1":"1", "2":"2"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => '{"0":"≤20", "1":"17-21", "2":"≥18"}', 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name','=','Clavicle')->first()->id;
        $method_id = Method::where([['name','=','Schaefer 2008'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Medial Clavicle']);
        $data = array('method_id'=>$method_id,'feature'=>'Medial Clavicle','display_name'=>'Medial Clavicle', 'display_order' =>  1, 'display_values' => '{"0":"0", "1":"1", "2":"2"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => '{"0":"≤23", "1":"17-29", "2":"≥21"}', 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name','=','Scapula')->first()->id;
        $method_id = Method::where([['name','=','Schaefer 2008'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Coraco-Glenoid']);
        $data = array('method_id'=>$method_id,'feature'=>'Coraco-Glenoid','display_name'=>'Coraco-Glenoid', 'display_order' =>  1, 'display_values' => '{"0":"0", "1":"1", "2":"2"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => '{"0":"≤16", "1":"15-18", "2":"≥16"}', 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();

        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Angle of Coracoid']);
        $data = array('method_id'=>$method_id,'feature'=>'Angle of Coracoid','display_name'=>'Angle of Coracoid', 'display_order' =>  2, 'display_values' => '{"0":"0", "1":"1", "2":"2"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => '{"0":"≤18", "1":"16-20", "2":"≥16"}', 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();

        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Acromion']);
        $data = array('method_id'=>$method_id,'feature'=>'Acromion','display_name'=>'Acromion', 'display_order' =>  3, 'display_values' => '{"0":"0", "1":"1", "2":"2"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => '{"0":"≤20", "1":"17-19", "2":"≥17"}', 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();

        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Inferior Angle']);
        $data = array('method_id'=>$method_id,'feature'=>'Inferior Angle','display_name'=>'Inferior Angle', 'display_order' =>  4, 'display_values' => '{"0":"0", "1":"1", "2":"2"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => '{"0":"≤21", "1":"17-22", "2":"≥17"}', 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();

        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Medial Border']);
        $data = array('method_id'=>$method_id,'feature'=>'Medial Border','display_name'=>'Medial Border', 'display_order' =>  5, 'display_values' => '{"0":"0", "1":"1", "2":"2"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => '{"0":"≤21", "1":"19-22", "2":"≥18"}', 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name','=','Sacrum')->first()->id;
        $method_id = Method::where([['name','=','Schaefer 2008'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Auricular Epiphysis of Sacrume']);
        $data = array('method_id'=>$method_id,'feature'=>'Auricular Epiphysis of Sacrum','display_name'=>'Auricular Epiphysis of Sacrum', 'display_order' =>  1, 'display_values' => '{"0":"0", "1":"1", "2":"2"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => '{"0":"≤21", "1":"19-24", "2":"≥18"}', 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name','=','Sternum')->first()->id;
        $method_id = Method::where([['name','=','Schaefer 2008'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Sternebrae 1-2']);
        $data = array('method_id'=>$method_id,'feature'=>'Sternebrae 1-2','display_name'=>'Sternebrae 1-2', 'display_order' =>  1, 'display_values' => '{"0":"0", "1":"1", "2":"2"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => '{"0":"≤23", "1":"17-26", "2":"≥18"}', 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();

        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Sternebrae 2-3']);
        $data = array('method_id'=>$method_id,'feature'=>'Sternebrae 2-3','display_name'=>'Sternebrae 2-3', 'display_order' =>  2, 'display_values' => '{"0":"0", "1":"1", "2":"2"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => '{"0":"≤19", "1":"16-20", "2":"≥16"}', 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();

        /// End - New Schaefer 2008 method
        //////////////////////////////////////////////////////////////////

        //////////////////////////////////////////////////////////////////
        /// Start - Old SSchaefer et al 2009 method

//        $sb_id = SkeletalBone::where('name','=','Mandible')->first()->id;
//        $method_id = Method::where([['name','=','Schaefer et al 2009'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
//        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Left and right halves']);
//        $data = array('method_id'=>$method_id,'feature'=>'Left and right halves','display_name'=>'Left and right halves', 'display_order' =>  1, 'display_values' => '{"Unfused":"Unfused", "Fused":"Fused"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
//        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name','=','Frontal')->first()->id;
//        $method_id = Method::where([['name','=','Schaefer et al 2009'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
//        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Metopic']);
//        $data = array('method_id'=>$method_id,'feature'=>'Metopic','display_name'=>'Metopic', 'display_order' =>  1, 'display_values' => '{"Unfused":"Unfused", "Fused":"Fused"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
//        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name','=','Occipital')->first()->id;
//        $method_id = Method::where([['name','=','Schaefer et al 2009'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
//        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Intra-occipital Posterior']);
//        $data = array('method_id'=>$method_id,'feature'=>'Intra-occipital Posterior','display_name'=>'Intra-occipital Posterior', 'display_order' =>  1, 'display_values' => '{"Unfused":"Unfused", "Fused":"Fused"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
//        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name','=','Occipital')->first()->id;
//        $method_id = Method::where([['name','=','Schaefer et al 2009'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
//        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Intra-occipital Anterior']);
//        $data = array('method_id'=>$method_id,'feature'=>'Intra-occipital Anterior','display_name'=>'Intra-occipital Anterior', 'display_order' =>  2, 'display_values' => '{"Unfused":"Unfused", "Fused":"Fused"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
//        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name','=','Temporal')->first()->id;
//        $method_id = Method::where([['name','=','Schaefer et al 2009'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
//        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Tympanic ring']);
//        $data = array('method_id'=>$method_id,'feature'=>'Tympanic ring','display_name'=>'Tympanic ring', 'display_order' =>  1, 'display_values' => '{"Unfused":"Unfused", "Fused":"Fused"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
//        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name','=','Temporal')->first()->id;
//        $method_id = Method::where([['name','=','Schaefer et al 2009'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
//        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Petrosquamous suture']);
//        $data = array('method_id'=>$method_id,'feature'=>'Petrosquamous suture','display_name'=>'Petrosquamous suture', 'display_order' =>  2, 'display_values' => '{"Unfused":"Unfused", "Fused":"Fused"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
//        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name','=','Cranium')->first()->id;
//        $method_id = Method::where([['name','=','Schaefer et al 2009'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
//        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Left and right halves']);
//        $data = array('method_id'=>$method_id,'feature'=>'Left and right halves','display_name'=>'Left and right halves', 'display_order' =>  1, 'display_values' => '{"Unfused":"Unfused", "Fused":"Fused"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
//        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name','=','Cranium')->first()->id;
//        $method_id = Method::where([['name','=','Schaefer et al 2009'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
//        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Metopic']);
//        $data = array('method_id'=>$method_id,'feature'=>'Metopic','display_name'=>'Metopic', 'display_order' =>  2, 'display_values' => '{"Unfused":"Unfused", "Fused":"Fused"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
//        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name','=','Cranium')->first()->id;
//        $method_id = Method::where([['name','=','Schaefer et al 2009'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
//        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Intra-occipital Posterior']);
//        $data = array('method_id'=>$method_id,'feature'=>'Intra-occipital Posterior','display_name'=>'Intra-occipital Posterior', 'display_order' =>  3, 'display_values' => '{"Unfused":"Unfused", "Fused":"Fused"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
//        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name','=','Cranium')->first()->id;
//        $method_id = Method::where([['name','=','Schaefer et al 2009'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
//        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Intra-occipital Anterior']);
//        $data = array('method_id'=>$method_id,'feature'=>'Intra-occipital Anterior','display_name'=>'Intra-occipital Anterior', 'display_order' =>  4, 'display_values' => '{"Unfused":"Unfused", "Fused":"Fused"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
//        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name','=','Cranium')->first()->id;
//        $method_id = Method::where([['name','=','Schaefer et al 2009'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
//        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Tympanic ring']);
//        $data = array('method_id'=>$method_id,'feature'=>'Tympanic ring','display_name'=>'Tympanic ring', 'display_order' => 5, 'display_values' => '{"Unfused":"Unfused", "Fused":"Fused"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
//        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name','=','Cranium')->first()->id;
//        $method_id = Method::where([['name','=','Schaefer et al 2009'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
//        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Petrosquamous suture']);
//        $data = array('method_id'=>$method_id,'feature'=>'Petrosquamous suture','display_name'=>'Petrosquamous suture', 'display_order' =>  6, 'display_values' => '{"Unfused":"Unfused", "Fused":"Fused"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
//        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name','=','Cranium')->first()->id;
//        $method_id = Method::where([['name','=','Schaefer et al 2009'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
//        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Anterior Fontanelle']);
//        $data = array('method_id'=>$method_id,'feature'=>'Anterior Fontanelle','display_name'=>'Anterior Fontanelle', 'display_order' =>  7, 'display_values' => '{"Unfused":"Unfused", "Fused":"Fused"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
//        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name','=','Cranium')->first()->id;
//        $method_id = Method::where([['name','=','Schaefer et al 2009'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
//        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Posterior Fontanelle']);
//        $data = array('method_id'=>$method_id,'feature'=>'Posterior Fontanelle','display_name'=>'Posterior Fontanelle', 'display_order' =>  8, 'display_values' => '{"Unfused":"Unfused", "Fused":"Fused"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
//        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name','=','Cranium')->first()->id;
//        $method_id = Method::where([['name','=','Schaefer et al 2009'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
//        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Anterolateral Fontanelle']);
//        $data = array('method_id'=>$method_id,'feature'=>'Anterolateral Fontanelle','display_name'=>'Anterolateral Fontanelle', 'display_order' =>  9, 'display_values' => '{"Unfused":"Unfused", "Fused":"Fused"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
//        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name','=','Cranium')->first()->id;
//        $method_id = Method::where([['name','=','Schaefer et al 2009'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
//        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Posterolateral Fontanelle']);
//        $data = array('method_id'=>$method_id,'feature'=>'Posterolateral Fontanelle','display_name'=>'Posterolateral Fontanelle', 'display_order' =>  10, 'display_values' => '{"Unfused":"Unfused", "Fused":"Fused"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
//        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name','=','Cranium')->first()->id;
//        $method_id = Method::where([['name','=','Schaefer et al 2009'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
//        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Spheno-occipital synchondrosis']);
//        $data = array('method_id'=>$method_id,'feature'=>'Spheno-occipital synchondrosis','display_name'=>'Spheno-occipital synchondrosis', 'display_order' =>  11, 'display_values' => '{"Unfused":"Unfused", "Fused":"Fused"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
//        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name','=','Calcaneus')->first()->id;
//        $method_id = Method::where([['name','=','Schaefer et al 2009'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
//        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Posterior Epiphysis']);
//        $data = array('method_id'=>$method_id,'feature'=>'Posterior Epiphysis','display_name'=>'Posterior Epiphysis', 'display_order' =>  1, 'display_values' => '{"Unfused":"Unfused", "Fused":"Fused"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
//        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name','=','Cervical vertebra 1')->first()->id;
//        $method_id = Method::where([['name','=','Schaefer et al 2009'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
//        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Posterior Arch']);
//        $data = array('method_id'=>$method_id,'feature'=>'Posterior Arch','display_name'=>'Posterior Arch', 'display_order' =>  1, 'display_values' => '{"Unfused":"Unfused", "Fused":"Fused"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
//        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name','=','Cervical vertebra 1')->first()->id;
//        $method_id = Method::where([['name','=','Schaefer et al 2009'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
//        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Centrum']);
//        $data = array('method_id'=>$method_id,'feature'=>'Centrum','display_name'=>'Centrum', 'display_order' =>  2, 'display_values' => '{"Unfused":"Unfused", "Fused":"Fused"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
//        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name','=','Cervical vertebra 2')->first()->id;
//        $method_id = Method::where([['name','=','Schaefer et al 2009'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
//        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Dens']);
//        $data = array('method_id'=>$method_id,'feature'=>'Dens','display_name'=>'Dens', 'display_order' =>  1, 'display_values' => '{"Unfused":"Unfused", "Fused":"Fused"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
//        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name','=','Cervical vertebra 2')->first()->id;
//        $method_id = Method::where([['name','=','Schaefer et al 2009'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
//        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Posterior Arch']);
//        $data = array('method_id'=>$method_id,'feature'=>'Posterior Arch','display_name'=>'Posterior Arch', 'display_order' =>  2, 'display_values' => '{"Unfused":"Unfused", "Fused":"Fused"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
//        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name','=','Cervical vertebra 2')->first()->id;
//        $method_id = Method::where([['name','=','Schaefer et al 2009'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
//        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Anterior Arch']);
//        $data = array('method_id'=>$method_id,'feature'=>'Anterior Arch','display_name'=>'Anterior Arch', 'display_order' =>  3, 'display_values' => '{"Unfused":"Unfused", "Fused":"Fused"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
//        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name','=','Cervical vertebra 3')->first()->id;
//        $method_id = Method::where([['name','=','Schaefer et al 2009'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
//        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Epiphyseal Ring']);
//        $data = array('method_id'=>$method_id,'feature'=>'Epiphyseal Ring','display_name'=>'Epiphyseal Ring', 'display_order' =>  1, 'display_values' => '{"Unfused":"Unfused", "Fused":"Fused"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
//        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name','=','Cervical vertebra 3')->first()->id;
//        $method_id = Method::where([['name','=','Schaefer et al 2009'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
//        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Centrum']);
//        $data = array('method_id'=>$method_id,'feature'=>'Centrum','display_name'=>'Centrum', 'display_order' =>  2, 'display_values' => '{"Unfused":"Unfused", "Fused":"Fused"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
//        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name','=','Cervical vertebra 3')->first()->id;
//        $method_id = Method::where([['name','=','Schaefer et al 2009'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
//        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Posterior Arch']);
//        $data = array('method_id'=>$method_id,'feature'=>'Posterior Arch','display_name'=>'Posterior Arch', 'display_order' =>  3, 'display_values' => '{"Unfused":"Unfused", "Fused":"Fused"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
//        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name','=','Cervical vertebra 4')->first()->id;
//        $method_id = Method::where([['name','=','Schaefer et al 2009'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
//        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Epiphyseal Ring']);
//        $data = array('method_id'=>$method_id,'feature'=>'Epiphyseal Ring','display_name'=>'Epiphyseal Ring', 'display_order' =>  1, 'display_values' => '{"Unfused":"Unfused", "Fused":"Fused"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
//        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name','=','Cervical vertebra 4')->first()->id;
//        $method_id = Method::where([['name','=','Schaefer et al 2009'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
//        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Centrum']);
//        $data = array('method_id'=>$method_id,'feature'=>'Centrum','display_name'=>'Centrum', 'display_order' =>  2, 'display_values' => '{"Unfused":"Unfused", "Fused":"Fused"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
//        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name','=','Cervical vertebra 4')->first()->id;
//        $method_id = Method::where([['name','=','Schaefer et al 2009'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
//        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Posterior Arch']);
//        $data = array('method_id'=>$method_id,'feature'=>'Posterior Arch','display_name'=>'Posterior Arch', 'display_order' =>  3, 'display_values' => '{"Unfused":"Unfused", "Fused":"Fused"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
//        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name','=','Cervical vertebra 5')->first()->id;
//        $method_id = Method::where([['name','=','Schaefer et al 2009'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
//        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Epiphyseal Ring']);
//        $data = array('method_id'=>$method_id,'feature'=>'Epiphyseal Ring','display_name'=>'Epiphyseal Ring', 'display_order' =>  1, 'display_values' => '{"Unfused":"Unfused", "Fused":"Fused"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
//        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name','=','Cervical vertebra 5')->first()->id;
//        $method_id = Method::where([['name','=','Schaefer et al 2009'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
//        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Centrum']);
//        $data = array('method_id'=>$method_id,'feature'=>'Centrum','display_name'=>'Centrum', 'display_order' =>  2, 'display_values' => '{"Unfused":"Unfused", "Fused":"Fused"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
//        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name','=','Cervical vertebra 5')->first()->id;
//        $method_id = Method::where([['name','=','Schaefer et al 2009'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
//        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Posterior Arch']);
//        $data = array('method_id'=>$method_id,'feature'=>'Posterior Arch','display_name'=>'Posterior Arch', 'display_order' =>  3, 'display_values' => '{"Unfused":"Unfused", "Fused":"Fused"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
//        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name','=','Cervical vertebra 6')->first()->id;
//        $method_id = Method::where([['name','=','Schaefer et al 2009'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
//        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Epiphyseal Ring']);
//        $data = array('method_id'=>$method_id,'feature'=>'Epiphyseal Ring','display_name'=>'Epiphyseal Ring', 'display_order' =>  1, 'display_values' => '{"Unfused":"Unfused", "Fused":"Fused"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
//        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name','=','Cervical vertebra 6')->first()->id;
//        $method_id = Method::where([['name','=','Schaefer et al 2009'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
//        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Centrum']);
//        $data = array('method_id'=>$method_id,'feature'=>'Centrum','display_name'=>'Centrum', 'display_order' =>  2, 'display_values' => '{"Unfused":"Unfused", "Fused":"Fused"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
//        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name','=','Cervical vertebra 6')->first()->id;
//        $method_id = Method::where([['name','=','Schaefer et al 2009'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
//        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Posterior Arch']);
//        $data = array('method_id'=>$method_id,'feature'=>'Posterior Arch','display_name'=>'Posterior Arch', 'display_order' =>  3, 'display_values' => '{"Unfused":"Unfused", "Fused":"Fused"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
//        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name','=','Cervical vertebra 7')->first()->id;
//        $method_id = Method::where([['name','=','Schaefer et al 2009'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
//        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Epiphyseal Ring']);
//        $data = array('method_id'=>$method_id,'feature'=>'Epiphyseal Ring','display_name'=>'Epiphyseal Ring', 'display_order' =>  1, 'display_values' => '{"Unfused":"Unfused", "Fused":"Fused"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
//        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name','=','Cervical vertebra 7')->first()->id;
//        $method_id = Method::where([['name','=','Schaefer et al 2009'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
//        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Centrum']);
//        $data = array('method_id'=>$method_id,'feature'=>'Centrum','display_name'=>'Centrum', 'display_order' =>  2, 'display_values' => '{"Unfused":"Unfused", "Fused":"Fused"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
//        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name','=','Cervical vertebra 7')->first()->id;
//        $method_id = Method::where([['name','=','Schaefer et al 2009'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
//        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Posterior Arch']);
//        $data = array('method_id'=>$method_id,'feature'=>'Posterior Arch','display_name'=>'Posterior Arch', 'display_order' =>  3, 'display_values' => '{"Unfused":"Unfused", "Fused":"Fused"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
//        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name','=','Cervical vertebra 6/7')->first()->id;
//        $method_id = Method::where([['name','=','Schaefer et al 2009'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
//        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Epiphyseal Ring']);
//        $data = array('method_id'=>$method_id,'feature'=>'Epiphyseal Ring','display_name'=>'Epiphyseal Ring', 'display_order' =>  1, 'display_values' => '{"Unfused":"Unfused", "Fused":"Fused"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
//        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name','=','Cervical vertebra 6/7')->first()->id;
//        $method_id = Method::where([['name','=','Schaefer et al 2009'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
//        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Centrum']);
//        $data = array('method_id'=>$method_id,'feature'=>'Centrum','display_name'=>'Centrum', 'display_order' =>  2, 'display_values' => '{"Unfused":"Unfused", "Fused":"Fused"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
//        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name','=','Cervical vertebra 6/7')->first()->id;
//        $method_id = Method::where([['name','=','Schaefer et al 2009'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
//        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Posterior Arch']);
//        $data = array('method_id'=>$method_id,'feature'=>'Posterior Arch','display_name'=>'Posterior Arch', 'display_order' =>  3, 'display_values' => '{"Unfused":"Unfused", "Fused":"Fused"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
//        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name','=','Unseriated cervical vertebra')->first()->id;
//        $method_id = Method::where([['name','=','Schaefer et al 2009'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
//        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Epiphyseal Ring']);
//        $data = array('method_id'=>$method_id,'feature'=>'Epiphyseal Ring','display_name'=>'Epiphyseal Ring', 'display_order' =>  1, 'display_values' => '{"Unfused":"Unfused", "Fused":"Fused"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
//        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name','=','Unseriated cervical vertebra')->first()->id;
//        $method_id = Method::where([['name','=','Schaefer et al 2009'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
//        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Centrum']);
//        $data = array('method_id'=>$method_id,'feature'=>'Centrum','display_name'=>'Centrum', 'display_order' =>  2, 'display_values' => '{"Unfused":"Unfused", "Fused":"Fused"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
//        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name','=','Unseriated cervical vertebra')->first()->id;
//        $method_id = Method::where([['name','=','Schaefer et al 2009'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
//        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Posterior Arch']);
//        $data = array('method_id'=>$method_id,'feature'=>'Posterior Arch','display_name'=>'Posterior Arch', 'display_order' =>  3, 'display_values' => '{"Unfused":"Unfused", "Fused":"Fused"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
//        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name','=','Clavicle')->first()->id;
//        $method_id = Method::where([['name','=','Schaefer et al 2009'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
//        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Medial ']);
//        $data = array('method_id'=>$method_id,'feature'=>'Medial ','display_name'=>'Medial ', 'display_order' =>  1, 'display_values' => '{"Unfused":"Unfused", "Fused":"Fused"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
//        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name','=','Clavicle')->first()->id;
//        $method_id = Method::where([['name','=','Schaefer et al 2009'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
//        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Medial']);
//        $data = array('method_id'=>$method_id,'feature'=>'Medial','display_name'=>'Medial', 'display_order' =>  2, 'display_values' => '{"Unfused":"Unfused", "Fused":"Fused"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
//        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name','=','Clavicle')->first()->id;
//        $method_id = Method::where([['name','=','Schaefer et al 2009'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
//        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Lateral ']);
//        $data = array('method_id'=>$method_id,'feature'=>'Lateral ','display_name'=>'Lateral ', 'display_order' =>  3, 'display_values' => '{"Unfused":"Unfused", "Fused":"Fused"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
//        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name','=','Distal manual phalanx 1')->first()->id;
//        $method_id = Method::where([['name','=','Schaefer et al 2009'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
//        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Epiphysis']);
//        $data = array('method_id'=>$method_id,'feature'=>'Epiphysis','display_name'=>'Epiphysis', 'display_order' =>  1, 'display_values' => '{"Unfused":"Unfused", "Fused":"Fused"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
//        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name','=','Distal manual phalanx 2')->first()->id;
//        $method_id = Method::where([['name','=','Schaefer et al 2009'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
//        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Epiphysis']);
//        $data = array('method_id'=>$method_id,'feature'=>'Epiphysis','display_name'=>'Epiphysis', 'display_order' =>  1, 'display_values' => '{"Unfused":"Unfused", "Fused":"Fused"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
//        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name','=','Distal manual phalanx 3')->first()->id;
//        $method_id = Method::where([['name','=','Schaefer et al 2009'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
//        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Epiphysis']);
//        $data = array('method_id'=>$method_id,'feature'=>'Epiphysis','display_name'=>'Epiphysis', 'display_order' =>  1, 'display_values' => '{"Unfused":"Unfused", "Fused":"Fused"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
//        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name','=','Distal manual phalanx 4')->first()->id;
//        $method_id = Method::where([['name','=','Schaefer et al 2009'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
//        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Epiphysis']);
//        $data = array('method_id'=>$method_id,'feature'=>'Epiphysis','display_name'=>'Epiphysis', 'display_order' =>  1, 'display_values' => '{"Unfused":"Unfused", "Fused":"Fused"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
//        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name','=','Distal manual phalanx 5')->first()->id;
//        $method_id = Method::where([['name','=','Schaefer et al 2009'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
//        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Epiphysis']);
//        $data = array('method_id'=>$method_id,'feature'=>'Epiphysis','display_name'=>'Epiphysis', 'display_order' =>  1, 'display_values' => '{"Unfused":"Unfused", "Fused":"Fused"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
//        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name','=','Distal pedal phalanx 1')->first()->id;
//        $method_id = Method::where([['name','=','Schaefer et al 2009'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
//        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Epiphysis']);
//        $data = array('method_id'=>$method_id,'feature'=>'Epiphysis','display_name'=>'Epiphysis', 'display_order' =>  1, 'display_values' => '{"Unfused":"Unfused", "Fused":"Fused"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
//        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name','=','Distal pedal phalanx 2')->first()->id;
//        $method_id = Method::where([['name','=','Schaefer et al 2009'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
//        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Epiphysis']);
//        $data = array('method_id'=>$method_id,'feature'=>'Epiphysis','display_name'=>'Epiphysis', 'display_order' =>  1, 'display_values' => '{"Unfused":"Unfused", "Fused":"Fused"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
//        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name','=','Distal pedal phalanx 3')->first()->id;
//        $method_id = Method::where([['name','=','Schaefer et al 2009'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
//        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Epiphysis']);
//        $data = array('method_id'=>$method_id,'feature'=>'Epiphysis','display_name'=>'Epiphysis', 'display_order' =>  1, 'display_values' => '{"Unfused":"Unfused", "Fused":"Fused"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
//        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name','=','Distal pedal phalanx 4')->first()->id;
//        $method_id = Method::where([['name','=','Schaefer et al 2009'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
//        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Epiphysis']);
//        $data = array('method_id'=>$method_id,'feature'=>'Epiphysis','display_name'=>'Epiphysis', 'display_order' =>  1, 'display_values' => '{"Unfused":"Unfused", "Fused":"Fused"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
//        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name','=','Distal pedal phalanx 5')->first()->id;
//        $method_id = Method::where([['name','=','Schaefer et al 2009'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
//        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Epiphysis']);
//        $data = array('method_id'=>$method_id,'feature'=>'Epiphysis','display_name'=>'Epiphysis', 'display_order' =>  1, 'display_values' => '{"Unfused":"Unfused", "Fused":"Fused"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
//        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name','=','Femur')->first()->id;
//        $method_id = Method::where([['name','=','Schaefer et al 2009'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
//        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Lesser Trochanter']);
//        $data = array('method_id'=>$method_id,'feature'=>'Lesser Trochanter','display_name'=>'Lesser Trochanter', 'display_order' =>  1, 'display_values' => '{"Unfused":"Unfused", "Fused":"Fused"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
//        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name','=','Femur')->first()->id;
//        $method_id = Method::where([['name','=','Schaefer et al 2009'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
//        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Head']);
//        $data = array('method_id'=>$method_id,'feature'=>'Head','display_name'=>'Head', 'display_order' =>  2, 'display_values' => '{"Unfused":"Unfused", "Fused":"Fused"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
//        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name','=','Femur')->first()->id;
//        $method_id = Method::where([['name','=','Schaefer et al 2009'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
//        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Greater Trochanter']);
//        $data = array('method_id'=>$method_id,'feature'=>'Greater Trochanter','display_name'=>'Greater Trochanter', 'display_order' =>  3, 'display_values' => '{"Unfused":"Unfused", "Fused":"Fused"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
//        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name','=','Femur')->first()->id;
//        $method_id = Method::where([['name','=','Schaefer et al 2009'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
//        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Distal']);
//        $data = array('method_id'=>$method_id,'feature'=>'Distal','display_name'=>'Distal', 'display_order' =>  4, 'display_values' => '{"Unfused":"Unfused", "Fused":"Fused"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
//        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name','=','Fibula')->first()->id;
//        $method_id = Method::where([['name','=','Schaefer et al 2009'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
//        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Distal']);
//        $data = array('method_id'=>$method_id,'feature'=>'Distal','display_name'=>'Distal', 'display_order' =>  1, 'display_values' => '{"Unfused":"Unfused", "Fused":"Fused"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
//        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name','=','Fibula')->first()->id;
//        $method_id = Method::where([['name','=','Schaefer et al 2009'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
//        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Proximal']);
//        $data = array('method_id'=>$method_id,'feature'=>'Proximal','display_name'=>'Proximal', 'display_order' =>  2, 'display_values' => '{"Unfused":"Unfused", "Fused":"Fused"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
//        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name','=','Humerus')->first()->id;
//        $method_id = Method::where([['name','=','Schaefer et al 2009'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
//        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Head and tubercles']);
//        $data = array('method_id'=>$method_id,'feature'=>'Head and tubercles','display_name'=>'Head and tubercles', 'display_order' =>  1, 'display_values' => '{"Unfused":"Unfused", "Fused":"Fused"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
//        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name','=','Humerus')->first()->id;
//        $method_id = Method::where([['name','=','Schaefer et al 2009'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
//        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Capitulum trochlea and lateral']);
//        $data = array('method_id'=>$method_id,'feature'=>'Capitulum trochlea and lateral','display_name'=>'Capitulum trochlea and lateral', 'display_order' =>  2, 'display_values' => '{"Unfused":"Unfused", "Fused":"Fused"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
//        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name','=','Humerus')->first()->id;
//        $method_id = Method::where([['name','=','Schaefer et al 2009'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
//        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Medial epicondyle']);
//        $data = array('method_id'=>$method_id,'feature'=>'Medial epicondyle','display_name'=>'Medial epicondyle', 'display_order' =>  3, 'display_values' => '{"Unfused":"Unfused", "Fused":"Fused"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
//        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name','=','Intermediate manual phalanx 2')->first()->id;
//        $method_id = Method::where([['name','=','Schaefer et al 2009'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
//        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Epiphysis']);
//        $data = array('method_id'=>$method_id,'feature'=>'Epiphysis','display_name'=>'Epiphysis', 'display_order' =>  1, 'display_values' => '{"Unfused":"Unfused", "Fused":"Fused"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
//        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name','=','Intermediate manual phalanx 3')->first()->id;
//        $method_id = Method::where([['name','=','Schaefer et al 2009'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
//        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Epiphysis']);
//        $data = array('method_id'=>$method_id,'feature'=>'Epiphysis','display_name'=>'Epiphysis', 'display_order' =>  1, 'display_values' => '{"Unfused":"Unfused", "Fused":"Fused"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
//        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name','=','Intermediate manual phalanx 4')->first()->id;
//        $method_id = Method::where([['name','=','Schaefer et al 2009'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
//        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Epiphysis']);
//        $data = array('method_id'=>$method_id,'feature'=>'Epiphysis','display_name'=>'Epiphysis', 'display_order' =>  1, 'display_values' => '{"Unfused":"Unfused", "Fused":"Fused"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
//        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name','=','Intermediate manual phalanx 5')->first()->id;
//        $method_id = Method::where([['name','=','Schaefer et al 2009'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
//        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Epiphysis']);
//        $data = array('method_id'=>$method_id,'feature'=>'Epiphysis','display_name'=>'Epiphysis', 'display_order' =>  1, 'display_values' => '{"Unfused":"Unfused", "Fused":"Fused"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
//        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name','=','Intermediate pedal phalanx 2')->first()->id;
//        $method_id = Method::where([['name','=','Schaefer et al 2009'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
//        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Epiphysis']);
//        $data = array('method_id'=>$method_id,'feature'=>'Epiphysis','display_name'=>'Epiphysis', 'display_order' =>  1, 'display_values' => '{"Unfused":"Unfused", "Fused":"Fused"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
//        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name','=','Intermediate pedal phalanx 3')->first()->id;
//        $method_id = Method::where([['name','=','Schaefer et al 2009'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
//        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Epiphysis']);
//        $data = array('method_id'=>$method_id,'feature'=>'Epiphysis','display_name'=>'Epiphysis', 'display_order' =>  1, 'display_values' => '{"Unfused":"Unfused", "Fused":"Fused"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
//        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name','=','Intermediate pedal phalanx 4')->first()->id;
//        $method_id = Method::where([['name','=','Schaefer et al 2009'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
//        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Epiphysis']);
//        $data = array('method_id'=>$method_id,'feature'=>'Epiphysis','display_name'=>'Epiphysis', 'display_order' =>  1, 'display_values' => '{"Unfused":"Unfused", "Fused":"Fused"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
//        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name','=','Intermediate pedal phalanx 5')->first()->id;
//        $method_id = Method::where([['name','=','Schaefer et al 2009'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
//        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Epiphysis']);
//        $data = array('method_id'=>$method_id,'feature'=>'Epiphysis','display_name'=>'Epiphysis', 'display_order' =>  1, 'display_values' => '{"Unfused":"Unfused", "Fused":"Fused"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
//        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name','=','Lumbar vertebra 1')->first()->id;
//        $method_id = Method::where([['name','=','Schaefer et al 2009'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
//        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Epiphyseal Ring']);
//        $data = array('method_id'=>$method_id,'feature'=>'Epiphyseal Ring','display_name'=>'Epiphyseal Ring', 'display_order' =>  1, 'display_values' => '{"Unfused":"Unfused", "Fused":"Fused"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
//        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name','=','Lumbar vertebra 1')->first()->id;
//        $method_id = Method::where([['name','=','Schaefer et al 2009'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
//        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Centrum']);
//        $data = array('method_id'=>$method_id,'feature'=>'Centrum','display_name'=>'Centrum', 'display_order' =>  2, 'display_values' => '{"Unfused":"Unfused", "Fused":"Fused"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
//        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name','=','Lumbar vertebra 1')->first()->id;
//        $method_id = Method::where([['name','=','Schaefer et al 2009'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
//        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Posterior Arch']);
//        $data = array('method_id'=>$method_id,'feature'=>'Posterior Arch','display_name'=>'Posterior Arch', 'display_order' =>  3, 'display_values' => '{"Unfused":"Unfused", "Fused":"Fused"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
//        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name','=','Lumbar vertebra 2')->first()->id;
//        $method_id = Method::where([['name','=','Schaefer et al 2009'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
//        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Epiphyseal Ring']);
//        $data = array('method_id'=>$method_id,'feature'=>'Epiphyseal Ring','display_name'=>'Epiphyseal Ring', 'display_order' =>  1, 'display_values' => '{"Unfused":"Unfused", "Fused":"Fused"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
//        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name','=','Lumbar vertebra 2')->first()->id;
//        $method_id = Method::where([['name','=','Schaefer et al 2009'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
//        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Centrum']);
//        $data = array('method_id'=>$method_id,'feature'=>'Centrum','display_name'=>'Centrum', 'display_order' =>  2, 'display_values' => '{"Unfused":"Unfused", "Fused":"Fused"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
//        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name','=','Lumbar vertebra 2')->first()->id;
//        $method_id = Method::where([['name','=','Schaefer et al 2009'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
//        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Posterior Arch']);
//        $data = array('method_id'=>$method_id,'feature'=>'Posterior Arch','display_name'=>'Posterior Arch', 'display_order' =>  3, 'display_values' => '{"Unfused":"Unfused", "Fused":"Fused"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
//        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name','=','Lumbar vertebra 3')->first()->id;
//        $method_id = Method::where([['name','=','Schaefer et al 2009'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
//        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Epiphyseal Ring']);
//        $data = array('method_id'=>$method_id,'feature'=>'Epiphyseal Ring','display_name'=>'Epiphyseal Ring', 'display_order' =>  1, 'display_values' => '{"Unfused":"Unfused", "Fused":"Fused"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
//        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name','=','Lumbar vertebra 3')->first()->id;
//        $method_id = Method::where([['name','=','Schaefer et al 2009'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
//        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Centrum']);
//        $data = array('method_id'=>$method_id,'feature'=>'Centrum','display_name'=>'Centrum', 'display_order' =>  2, 'display_values' => '{"Unfused":"Unfused", "Fused":"Fused"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
//        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name','=','Lumbar vertebra 3')->first()->id;
//        $method_id = Method::where([['name','=','Schaefer et al 2009'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
//        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Posterior Arch']);
//        $data = array('method_id'=>$method_id,'feature'=>'Posterior Arch','display_name'=>'Posterior Arch', 'display_order' =>  3, 'display_values' => '{"Unfused":"Unfused", "Fused":"Fused"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
//        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name','=','Lumbar vertebra 4')->first()->id;
//        $method_id = Method::where([['name','=','Schaefer et al 2009'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
//        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Epiphyseal Ring']);
//        $data = array('method_id'=>$method_id,'feature'=>'Epiphyseal Ring','display_name'=>'Epiphyseal Ring', 'display_order' =>  1, 'display_values' => '{"Unfused":"Unfused", "Fused":"Fused"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
//        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name','=','Lumbar vertebra 4')->first()->id;
//        $method_id = Method::where([['name','=','Schaefer et al 2009'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
//        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Centrum']);
//        $data = array('method_id'=>$method_id,'feature'=>'Centrum','display_name'=>'Centrum', 'display_order' =>  2, 'display_values' => '{"Unfused":"Unfused", "Fused":"Fused"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
//        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name','=','Lumbar vertebra 4')->first()->id;
//        $method_id = Method::where([['name','=','Schaefer et al 2009'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
//        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Posterior Arch']);
//        $data = array('method_id'=>$method_id,'feature'=>'Posterior Arch','display_name'=>'Posterior Arch', 'display_order' =>  3, 'display_values' => '{"Unfused":"Unfused", "Fused":"Fused"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
//        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name','=','Lumbar vertebra 5')->first()->id;
//        $method_id = Method::where([['name','=','Schaefer et al 2009'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
//        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Epiphyseal Ring']);
//        $data = array('method_id'=>$method_id,'feature'=>'Epiphyseal Ring','display_name'=>'Epiphyseal Ring', 'display_order' =>  1, 'display_values' => '{"Unfused":"Unfused", "Fused":"Fused"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
//        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name','=','Lumbar vertebra 5')->first()->id;
//        $method_id = Method::where([['name','=','Schaefer et al 2009'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
//        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Centrum']);
//        $data = array('method_id'=>$method_id,'feature'=>'Centrum','display_name'=>'Centrum', 'display_order' =>  2, 'display_values' => '{"Unfused":"Unfused", "Fused":"Fused"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
//        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name','=','Lumbar vertebra 5')->first()->id;
//        $method_id = Method::where([['name','=','Schaefer et al 2009'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
//        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Posterior Arch']);
//        $data = array('method_id'=>$method_id,'feature'=>'Posterior Arch','display_name'=>'Posterior Arch', 'display_order' =>  3, 'display_values' => '{"Unfused":"Unfused", "Fused":"Fused"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
//        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name','=','Lumbar vertebra 1/2')->first()->id;
//        $method_id = Method::where([['name','=','Schaefer et al 2009'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
//        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Epiphyseal Ring']);
//        $data = array('method_id'=>$method_id,'feature'=>'Epiphyseal Ring','display_name'=>'Epiphyseal Ring', 'display_order' =>  1, 'display_values' => '{"Unfused":"Unfused", "Fused":"Fused"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
//        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name','=','Lumbar vertebra 1/2')->first()->id;
//        $method_id = Method::where([['name','=','Schaefer et al 2009'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
//        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Centrum']);
//        $data = array('method_id'=>$method_id,'feature'=>'Centrum','display_name'=>'Centrum', 'display_order' =>  2, 'display_values' => '{"Unfused":"Unfused", "Fused":"Fused"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
//        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name','=','Lumbar vertebra 1/2')->first()->id;
//        $method_id = Method::where([['name','=','Schaefer et al 2009'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
//        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Posterior Arch']);
//        $data = array('method_id'=>$method_id,'feature'=>'Posterior Arch','display_name'=>'Posterior Arch', 'display_order' =>  3, 'display_values' => '{"Unfused":"Unfused", "Fused":"Fused"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
//        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name','=','Lumbar vertebra 2/3')->first()->id;
//        $method_id = Method::where([['name','=','Schaefer et al 2009'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
//        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Epiphyseal Ring']);
//        $data = array('method_id'=>$method_id,'feature'=>'Epiphyseal Ring','display_name'=>'Epiphyseal Ring', 'display_order' =>  1, 'display_values' => '{"Unfused":"Unfused", "Fused":"Fused"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
//        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name','=','Lumbar vertebra 2/3')->first()->id;
//        $method_id = Method::where([['name','=','Schaefer et al 2009'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
//        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Centrum']);
//        $data = array('method_id'=>$method_id,'feature'=>'Centrum','display_name'=>'Centrum', 'display_order' =>  2, 'display_values' => '{"Unfused":"Unfused", "Fused":"Fused"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
//        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name','=','Lumbar vertebra 2/3')->first()->id;
//        $method_id = Method::where([['name','=','Schaefer et al 2009'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
//        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Posterior Arch']);
//        $data = array('method_id'=>$method_id,'feature'=>'Posterior Arch','display_name'=>'Posterior Arch', 'display_order' =>  3, 'display_values' => '{"Unfused":"Unfused", "Fused":"Fused"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
//        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name','=','Lumbar vertebra 3/4')->first()->id;
//        $method_id = Method::where([['name','=','Schaefer et al 2009'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
//        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Epiphyseal Ring']);
//        $data = array('method_id'=>$method_id,'feature'=>'Epiphyseal Ring','display_name'=>'Epiphyseal Ring', 'display_order' =>  1, 'display_values' => '{"Unfused":"Unfused", "Fused":"Fused"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
//        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name','=','Lumbar vertebra 3/4')->first()->id;
//        $method_id = Method::where([['name','=','Schaefer et al 2009'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
//        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Centrum']);
//        $data = array('method_id'=>$method_id,'feature'=>'Centrum','display_name'=>'Centrum', 'display_order' =>  2, 'display_values' => '{"Unfused":"Unfused", "Fused":"Fused"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
//        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name','=','Lumbar vertebra 3/4')->first()->id;
//        $method_id = Method::where([['name','=','Schaefer et al 2009'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
//        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Posterior Arch']);
//        $data = array('method_id'=>$method_id,'feature'=>'Posterior Arch','display_name'=>'Posterior Arch', 'display_order' =>  3, 'display_values' => '{"Unfused":"Unfused", "Fused":"Fused"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
//        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name','=','Lumbar vertebra 4/5')->first()->id;
//        $method_id = Method::where([['name','=','Schaefer et al 2009'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
//        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Epiphyseal Ring']);
//        $data = array('method_id'=>$method_id,'feature'=>'Epiphyseal Ring','display_name'=>'Epiphyseal Ring', 'display_order' =>  1, 'display_values' => '{"Unfused":"Unfused", "Fused":"Fused"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
//        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name','=','Lumbar vertebra 4/5')->first()->id;
//        $method_id = Method::where([['name','=','Schaefer et al 2009'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
//        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Centrum']);
//        $data = array('method_id'=>$method_id,'feature'=>'Centrum','display_name'=>'Centrum', 'display_order' =>  2, 'display_values' => '{"Unfused":"Unfused", "Fused":"Fused"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
//        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name','=','Lumbar vertebra 4/5')->first()->id;
//        $method_id = Method::where([['name','=','Schaefer et al 2009'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
//        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Posterior Arch']);
//        $data = array('method_id'=>$method_id,'feature'=>'Posterior Arch','display_name'=>'Posterior Arch', 'display_order' =>  3, 'display_values' => '{"Unfused":"Unfused", "Fused":"Fused"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
//        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name','=','Unseriated lumbar vertebra')->first()->id;
//        $method_id = Method::where([['name','=','Schaefer et al 2009'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
//        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Epiphyseal Ring']);
//        $data = array('method_id'=>$method_id,'feature'=>'Epiphyseal Ring','display_name'=>'Epiphyseal Ring', 'display_order' =>  1, 'display_values' => '{"Unfused":"Unfused", "Fused":"Fused"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
//        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name','=','Unseriated lumbar vertebra')->first()->id;
//        $method_id = Method::where([['name','=','Schaefer et al 2009'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
//        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Centrum']);
//        $data = array('method_id'=>$method_id,'feature'=>'Centrum','display_name'=>'Centrum', 'display_order' =>  2, 'display_values' => '{"Unfused":"Unfused", "Fused":"Fused"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
//        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name','=','Unseriated lumbar vertebra')->first()->id;
//        $method_id = Method::where([['name','=','Schaefer et al 2009'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
//        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Posterior Arch']);
//        $data = array('method_id'=>$method_id,'feature'=>'Posterior Arch','display_name'=>'Posterior Arch', 'display_order' =>  3, 'display_values' => '{"Unfused":"Unfused", "Fused":"Fused"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
//        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name','=','Unidentified vertebra')->first()->id;
//        $method_id = Method::where([['name','=','Schaefer et al 2009'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
//        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Epiphyseal Ring']);
//        $data = array('method_id'=>$method_id,'feature'=>'Epiphyseal Ring','display_name'=>'Epiphyseal Ring', 'display_order' =>  1, 'display_values' => '{"Unfused":"Unfused", "Fused":"Fused"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
//        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name','=','Unidentified vertebra')->first()->id;
//        $method_id = Method::where([['name','=','Schaefer et al 2009'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
//        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Centrum']);
//        $data = array('method_id'=>$method_id,'feature'=>'Centrum','display_name'=>'Centrum', 'display_order' =>  2, 'display_values' => '{"Unfused":"Unfused", "Fused":"Fused"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
//        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name','=','Unidentified vertebra')->first()->id;
//        $method_id = Method::where([['name','=','Schaefer et al 2009'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
//        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Posterior Arch']);
//        $data = array('method_id'=>$method_id,'feature'=>'Posterior Arch','display_name'=>'Posterior Arch', 'display_order' =>  3, 'display_values' => '{"Unfused":"Unfused", "Fused":"Fused"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
//        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name','=','Metacarpal 1')->first()->id;
//        $method_id = Method::where([['name','=','Schaefer et al 2009'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
//        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Base']);
//        $data = array('method_id'=>$method_id,'feature'=>'Base','display_name'=>'Base', 'display_order' =>  1, 'display_values' => '{"Unfused":"Unfused", "Fused":"Fused"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
//        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name','=','Metacarpal 2')->first()->id;
//        $method_id = Method::where([['name','=','Schaefer et al 2009'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
//        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Head']);
//        $data = array('method_id'=>$method_id,'feature'=>'Head','display_name'=>'Head', 'display_order' =>  1, 'display_values' => '{"Unfused":"Unfused", "Fused":"Fused"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
//        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name','=','Metacarpal 3')->first()->id;
//        $method_id = Method::where([['name','=','Schaefer et al 2009'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
//        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Head']);
//        $data = array('method_id'=>$method_id,'feature'=>'Head','display_name'=>'Head', 'display_order' =>  1, 'display_values' => '{"Unfused":"Unfused", "Fused":"Fused"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
//        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name','=','Metacarpal 4')->first()->id;
//        $method_id = Method::where([['name','=','Schaefer et al 2009'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
//        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Head']);
//        $data = array('method_id'=>$method_id,'feature'=>'Head','display_name'=>'Head', 'display_order' =>  1, 'display_values' => '{"Unfused":"Unfused", "Fused":"Fused"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
//        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name','=','Metacarpal 5')->first()->id;
//        $method_id = Method::where([['name','=','Schaefer et al 2009'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
//        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Head']);
//        $data = array('method_id'=>$method_id,'feature'=>'Head','display_name'=>'Head', 'display_order' =>  1, 'display_values' => '{"Unfused":"Unfused", "Fused":"Fused"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
//        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name','=','Unseriated metacarpal')->first()->id;
//        $method_id = Method::where([['name','=','Schaefer et al 2009'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
//        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Head']);
//        $data = array('method_id'=>$method_id,'feature'=>'Head','display_name'=>'Head', 'display_order' =>  1, 'display_values' => '{"Unfused":"Unfused", "Fused":"Fused"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
//        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name','=','Unseriated metatarsal')->first()->id;
//        $method_id = Method::where([['name','=','Schaefer et al 2009'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
//        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Head']);
//        $data = array('method_id'=>$method_id,'feature'=>'Head','display_name'=>'Head', 'display_order' =>  2, 'display_values' => '{"Unfused":"Unfused", "Fused":"Fused"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
//        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name','=','Metatarsal 1')->first()->id;
//        $method_id = Method::where([['name','=','Schaefer et al 2009'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
//        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Base']);
//        $data = array('method_id'=>$method_id,'feature'=>'Base','display_name'=>'Base', 'display_order' =>  1, 'display_values' => '{"Unfused":"Unfused", "Fused":"Fused"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
//        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name','=','Metatarsal 2')->first()->id;
//        $method_id = Method::where([['name','=','Schaefer et al 2009'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
//        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Head']);
//        $data = array('method_id'=>$method_id,'feature'=>'Head','display_name'=>'Head', 'display_order' =>  1, 'display_values' => '{"Unfused":"Unfused", "Fused":"Fused"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
//        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name','=','Metatarsal 3')->first()->id;
//        $method_id = Method::where([['name','=','Schaefer et al 2009'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
//        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Head']);
//        $data = array('method_id'=>$method_id,'feature'=>'Head','display_name'=>'Head', 'display_order' =>  1, 'display_values' => '{"Unfused":"Unfused", "Fused":"Fused"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
//        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name','=','Metatarsal 4')->first()->id;
//        $method_id = Method::where([['name','=','Schaefer et al 2009'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
//        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Head']);
//        $data = array('method_id'=>$method_id,'feature'=>'Head','display_name'=>'Head', 'display_order' =>  1, 'display_values' => '{"Unfused":"Unfused", "Fused":"Fused"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
//        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name','=','Metatarsal 5')->first()->id;
//        $method_id = Method::where([['name','=','Schaefer et al 2009'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
//        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Head']);
//        $data = array('method_id'=>$method_id,'feature'=>'Head','display_name'=>'Head', 'display_order' =>  1, 'display_values' => '{"Unfused":"Unfused", "Fused":"Fused"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
//        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name','=','Os coxa')->first()->id;
//        $method_id = Method::where([['name','=','Schaefer et al 2009'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
//        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Ischiopubic ramus']);
//        $data = array('method_id'=>$method_id,'feature'=>'Ischiopubic ramus','display_name'=>'Ischiopubic ramus', 'display_order' =>  1, 'display_values' => '{"Unfused":"Unfused", "Fused":"Fused"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
//        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name','=','Os coxa')->first()->id;
//        $method_id = Method::where([['name','=','Schaefer et al 2009'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
//        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Ischium']);
//        $data = array('method_id'=>$method_id,'feature'=>'Ischium','display_name'=>'Ischium', 'display_order' =>  2, 'display_values' => '{"Unfused":"Unfused", "Fused":"Fused"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
//        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name','=','Os coxa')->first()->id;
//        $method_id = Method::where([['name','=','Schaefer et al 2009'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
//        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Iliac Crest']);
//        $data = array('method_id'=>$method_id,'feature'=>'Iliac Crest','display_name'=>'Iliac Crest', 'display_order' =>  3, 'display_values' => '{"Unfused":"Unfused", "Fused":"Fused"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
//        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name','=','Os coxa')->first()->id;
//        $method_id = Method::where([['name','=','Schaefer et al 2009'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
//        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Acetabulum ']);
//        $data = array('method_id'=>$method_id,'feature'=>'Acetabulum ','display_name'=>'Acetabulum ', 'display_order' =>  4, 'display_values' => '{"Unfused":"Unfused", "Fused":"Fused"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
//        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name','=','Os coxa')->first()->id;
//        $method_id = Method::where([['name','=','Schaefer et al 2009'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
//        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Anterior Inferior Iliac Spine']);
//        $data = array('method_id'=>$method_id,'feature'=>'Anterior Inferior Iliac Spine','display_name'=>'Anterior Inferior Iliac Spine', 'display_order' =>  5, 'display_values' => '{"Unfused":"Unfused", "Fused":"Fused"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
//        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name','=','Proximal manual phalanx 1')->first()->id;
//        $method_id = Method::where([['name','=','Schaefer et al 2009'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
//        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Epiphysis']);
//        $data = array('method_id'=>$method_id,'feature'=>'Epiphysis','display_name'=>'Epiphysis', 'display_order' =>  1, 'display_values' => '{"Unfused":"Unfused", "Fused":"Fused"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
//        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name','=','Proximal manual phalanx 2')->first()->id;
//        $method_id = Method::where([['name','=','Schaefer et al 2009'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
//        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Epiphysis']);
//        $data = array('method_id'=>$method_id,'feature'=>'Epiphysis','display_name'=>'Epiphysis', 'display_order' =>  1, 'display_values' => '{"Unfused":"Unfused", "Fused":"Fused"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
//        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name','=','Proximal manual phalanx 3')->first()->id;
//        $method_id = Method::where([['name','=','Schaefer et al 2009'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
//        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Epiphysis']);
//        $data = array('method_id'=>$method_id,'feature'=>'Epiphysis','display_name'=>'Epiphysis', 'display_order' =>  1, 'display_values' => '{"Unfused":"Unfused", "Fused":"Fused"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
//        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name','=','Proximal manual phalanx 4')->first()->id;
//        $method_id = Method::where([['name','=','Schaefer et al 2009'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
//        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Epiphysis']);
//        $data = array('method_id'=>$method_id,'feature'=>'Epiphysis','display_name'=>'Epiphysis', 'display_order' =>  1, 'display_values' => '{"Unfused":"Unfused", "Fused":"Fused"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
//        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name','=','Proximal manual phalanx 5')->first()->id;
//        $method_id = Method::where([['name','=','Schaefer et al 2009'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
//        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Epiphysis']);
//        $data = array('method_id'=>$method_id,'feature'=>'Epiphysis','display_name'=>'Epiphysis', 'display_order' =>  1, 'display_values' => '{"Unfused":"Unfused", "Fused":"Fused"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
//        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name','=','Proximal pedal phalanx 1')->first()->id;
//        $method_id = Method::where([['name','=','Schaefer et al 2009'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
//        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Epiphysis']);
//        $data = array('method_id'=>$method_id,'feature'=>'Epiphysis','display_name'=>'Epiphysis', 'display_order' =>  1, 'display_values' => '{"Unfused":"Unfused", "Fused":"Fused"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
//        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name','=','Proximal pedal phalanx 2')->first()->id;
//        $method_id = Method::where([['name','=','Schaefer et al 2009'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
//        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Epiphysis']);
//        $data = array('method_id'=>$method_id,'feature'=>'Epiphysis','display_name'=>'Epiphysis', 'display_order' =>  1, 'display_values' => '{"Unfused":"Unfused", "Fused":"Fused"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
//        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name','=','Proximal pedal phalanx 3')->first()->id;
//        $method_id = Method::where([['name','=','Schaefer et al 2009'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
//        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Epiphysis']);
//        $data = array('method_id'=>$method_id,'feature'=>'Epiphysis','display_name'=>'Epiphysis', 'display_order' =>  1, 'display_values' => '{"Unfused":"Unfused", "Fused":"Fused"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
//        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name','=','Proximal pedal phalanx 4')->first()->id;
//        $method_id = Method::where([['name','=','Schaefer et al 2009'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
//        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Epiphysis']);
//        $data = array('method_id'=>$method_id,'feature'=>'Epiphysis','display_name'=>'Epiphysis', 'display_order' =>  1, 'display_values' => '{"Unfused":"Unfused", "Fused":"Fused"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
//        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name','=','Proximal pedal phalanx 5')->first()->id;
//        $method_id = Method::where([['name','=','Schaefer et al 2009'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
//        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Epiphysis']);
//        $data = array('method_id'=>$method_id,'feature'=>'Epiphysis','display_name'=>'Epiphysis', 'display_order' =>  1, 'display_values' => '{"Unfused":"Unfused", "Fused":"Fused"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
//        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name','=','Radius')->first()->id;
//        $method_id = Method::where([['name','=','Schaefer et al 2009'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
//        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Proximal']);
//        $data = array('method_id'=>$method_id,'feature'=>'Proximal','display_name'=>'Proximal', 'display_order' =>  1, 'display_values' => '{"Unfused":"Unfused", "Fused":"Fused"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
//        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name','=','Radius')->first()->id;
//        $method_id = Method::where([['name','=','Schaefer et al 2009'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
//        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Distal']);
//        $data = array('method_id'=>$method_id,'feature'=>'Distal','display_name'=>'Distal', 'display_order' =>  2, 'display_values' => '{"Unfused":"Unfused", "Fused":"Fused"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
//        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name','=','Unseriated rib')->first()->id;
//        $method_id = Method::where([['name','=','Schaefer et al 2009'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
//        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Head']);
//        $data = array('method_id'=>$method_id,'feature'=>'Head','display_name'=>'Head', 'display_order' =>  1, 'display_values' => '{"Unfused":"Unfused", "Fused":"Fused"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
//        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name','=','Rib 1')->first()->id;
//        $method_id = Method::where([['name','=','Schaefer et al 2009'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
//        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Head']);
//        $data = array('method_id'=>$method_id,'feature'=>'Head','display_name'=>'Head', 'display_order' =>  1, 'display_values' => '{"Unfused":"Unfused", "Fused":"Fused"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
//        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name','=','Rib 1')->first()->id;
//        $method_id = Method::where([['name','=','Schaefer et al 2009'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
//        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Tubercle']);
//        $data = array('method_id'=>$method_id,'feature'=>'Tubercle','display_name'=>'Tubercle', 'display_order' =>  2, 'display_values' => '{"Unfused":"Unfused", "Fused":"Fused"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
//        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name','=','Rib 1')->first()->id;
//        $method_id = Method::where([['name','=','Schaefer et al 2009'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
//        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Non-articular ']);
//        $data = array('method_id'=>$method_id,'feature'=>'Non-articular ','display_name'=>'Non-articular ', 'display_order' =>  3, 'display_values' => '{"Unfused":"Unfused", "Fused":"Fused"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
//        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name','=','Rib 10')->first()->id;
//        $method_id = Method::where([['name','=','Schaefer et al 2009'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
//        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Head']);
//        $data = array('method_id'=>$method_id,'feature'=>'Head','display_name'=>'Head', 'display_order' =>  1, 'display_values' => '{"Unfused":"Unfused", "Fused":"Fused"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
//        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name','=','Rib 10')->first()->id;
//        $method_id = Method::where([['name','=','Schaefer et al 2009'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
//        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Tubercle']);
//        $data = array('method_id'=>$method_id,'feature'=>'Tubercle','display_name'=>'Tubercle', 'display_order' =>  2, 'display_values' => '{"Unfused":"Unfused", "Fused":"Fused"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
//        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name','=','Rib 10')->first()->id;
//        $method_id = Method::where([['name','=','Schaefer et al 2009'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
//        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Non-articular ']);
//        $data = array('method_id'=>$method_id,'feature'=>'Non-articular ','display_name'=>'Non-articular ', 'display_order' =>  3, 'display_values' => '{"Unfused":"Unfused", "Fused":"Fused"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
//        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name','=','Rib 11')->first()->id;
//        $method_id = Method::where([['name','=','Schaefer et al 2009'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
//        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Head']);
//        $data = array('method_id'=>$method_id,'feature'=>'Head','display_name'=>'Head', 'display_order' =>  1, 'display_values' => '{"Unfused":"Unfused", "Fused":"Fused"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
//        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name','=','Rib 12')->first()->id;
//        $method_id = Method::where([['name','=','Schaefer et al 2009'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
//        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Head']);
//        $data = array('method_id'=>$method_id,'feature'=>'Head','display_name'=>'Head', 'display_order' =>  1, 'display_values' => '{"Unfused":"Unfused", "Fused":"Fused"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
//        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name','=','Rib 2')->first()->id;
//        $method_id = Method::where([['name','=','Schaefer et al 2009'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
//        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Head']);
//        $data = array('method_id'=>$method_id,'feature'=>'Head','display_name'=>'Head', 'display_order' =>  1, 'display_values' => '{"Unfused":"Unfused", "Fused":"Fused"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
//        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name','=','Rib 2')->first()->id;
//        $method_id = Method::where([['name','=','Schaefer et al 2009'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
//        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Tubercle']);
//        $data = array('method_id'=>$method_id,'feature'=>'Tubercle','display_name'=>'Tubercle', 'display_order' =>  2, 'display_values' => '{"Unfused":"Unfused", "Fused":"Fused"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
//        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name','=','Rib 2')->first()->id;
//        $method_id = Method::where([['name','=','Schaefer et al 2009'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
//        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Non-articular ']);
//        $data = array('method_id'=>$method_id,'feature'=>'Non-articular ','display_name'=>'Non-articular ', 'display_order' =>  3, 'display_values' => '{"Unfused":"Unfused", "Fused":"Fused"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
//        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name','=','Rib 3')->first()->id;
//        $method_id = Method::where([['name','=','Schaefer et al 2009'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
//        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Head']);
//        $data = array('method_id'=>$method_id,'feature'=>'Head','display_name'=>'Head', 'display_order' =>  1, 'display_values' => '{"Unfused":"Unfused", "Fused":"Fused"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
//        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name','=','Rib 3')->first()->id;
//        $method_id = Method::where([['name','=','Schaefer et al 2009'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
//        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Tubercle']);
//        $data = array('method_id'=>$method_id,'feature'=>'Tubercle','display_name'=>'Tubercle', 'display_order' =>  2, 'display_values' => '{"Unfused":"Unfused", "Fused":"Fused"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
//        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name','=','Rib 3')->first()->id;
//        $method_id = Method::where([['name','=','Schaefer et al 2009'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
//        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Non-articular ']);
//        $data = array('method_id'=>$method_id,'feature'=>'Non-articular ','display_name'=>'Non-articular ', 'display_order' =>  3, 'display_values' => '{"Unfused":"Unfused", "Fused":"Fused"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
//        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name','=','Rib 4')->first()->id;
//        $method_id = Method::where([['name','=','Schaefer et al 2009'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
//        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Head']);
//        $data = array('method_id'=>$method_id,'feature'=>'Head','display_name'=>'Head', 'display_order' =>  1, 'display_values' => '{"Unfused":"Unfused", "Fused":"Fused"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
//        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name','=','Rib 4')->first()->id;
//        $method_id = Method::where([['name','=','Schaefer et al 2009'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
//        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Tubercle']);
//        $data = array('method_id'=>$method_id,'feature'=>'Tubercle','display_name'=>'Tubercle', 'display_order' =>  2, 'display_values' => '{"Unfused":"Unfused", "Fused":"Fused"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
//        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name','=','Rib 4')->first()->id;
//        $method_id = Method::where([['name','=','Schaefer et al 2009'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
//        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Non-articular ']);
//        $data = array('method_id'=>$method_id,'feature'=>'Non-articular ','display_name'=>'Non-articular ', 'display_order' =>  3, 'display_values' => '{"Unfused":"Unfused", "Fused":"Fused"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
//        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name','=','Rib 5')->first()->id;
//        $method_id = Method::where([['name','=','Schaefer et al 2009'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
//        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Head']);
//        $data = array('method_id'=>$method_id,'feature'=>'Head','display_name'=>'Head', 'display_order' =>  1, 'display_values' => '{"Unfused":"Unfused", "Fused":"Fused"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
//        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name','=','Rib 5')->first()->id;
//        $method_id = Method::where([['name','=','Schaefer et al 2009'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
//        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Tubercle']);
//        $data = array('method_id'=>$method_id,'feature'=>'Tubercle','display_name'=>'Tubercle', 'display_order' =>  2, 'display_values' => '{"Unfused":"Unfused", "Fused":"Fused"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
//        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name','=','Rib 5')->first()->id;
//        $method_id = Method::where([['name','=','Schaefer et al 2009'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
//        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Non-articular ']);
//        $data = array('method_id'=>$method_id,'feature'=>'Non-articular ','display_name'=>'Non-articular ', 'display_order' =>  3, 'display_values' => '{"Unfused":"Unfused", "Fused":"Fused"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
//        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name','=','Rib 6')->first()->id;
//        $method_id = Method::where([['name','=','Schaefer et al 2009'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
//        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Head']);
//        $data = array('method_id'=>$method_id,'feature'=>'Head','display_name'=>'Head', 'display_order' =>  1, 'display_values' => '{"Unfused":"Unfused", "Fused":"Fused"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
//        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name','=','Rib 6')->first()->id;
//        $method_id = Method::where([['name','=','Schaefer et al 2009'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
//        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Tubercle']);
//        $data = array('method_id'=>$method_id,'feature'=>'Tubercle','display_name'=>'Tubercle', 'display_order' =>  2, 'display_values' => '{"Unfused":"Unfused", "Fused":"Fused"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
//        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name','=','Rib 6')->first()->id;
//        $method_id = Method::where([['name','=','Schaefer et al 2009'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
//        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Non-articular ']);
//        $data = array('method_id'=>$method_id,'feature'=>'Non-articular ','display_name'=>'Non-articular ', 'display_order' =>  3, 'display_values' => '{"Unfused":"Unfused", "Fused":"Fused"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
//        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name','=','Rib 7')->first()->id;
//        $method_id = Method::where([['name','=','Schaefer et al 2009'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
//        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Head']);
//        $data = array('method_id'=>$method_id,'feature'=>'Head','display_name'=>'Head', 'display_order' =>  1, 'display_values' => '{"Unfused":"Unfused", "Fused":"Fused"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
//        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name','=','Rib 7')->first()->id;
//        $method_id = Method::where([['name','=','Schaefer et al 2009'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
//        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Tubercle']);
//        $data = array('method_id'=>$method_id,'feature'=>'Tubercle','display_name'=>'Tubercle', 'display_order' =>  2, 'display_values' => '{"Unfused":"Unfused", "Fused":"Fused"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
//        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name','=','Rib 7')->first()->id;
//        $method_id = Method::where([['name','=','Schaefer et al 2009'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
//        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Non-articular ']);
//        $data = array('method_id'=>$method_id,'feature'=>'Non-articular ','display_name'=>'Non-articular ', 'display_order' =>  3, 'display_values' => '{"Unfused":"Unfused", "Fused":"Fused"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
//        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name','=','Rib 8')->first()->id;
//        $method_id = Method::where([['name','=','Schaefer et al 2009'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
//        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Head']);
//        $data = array('method_id'=>$method_id,'feature'=>'Head','display_name'=>'Head', 'display_order' =>  1, 'display_values' => '{"Unfused":"Unfused", "Fused":"Fused"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
//        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name','=','Rib 8')->first()->id;
//        $method_id = Method::where([['name','=','Schaefer et al 2009'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
//        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Tubercle']);
//        $data = array('method_id'=>$method_id,'feature'=>'Tubercle','display_name'=>'Tubercle', 'display_order' =>  2, 'display_values' => '{"Unfused":"Unfused", "Fused":"Fused"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
//        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name','=','Rib 8')->first()->id;
//        $method_id = Method::where([['name','=','Schaefer et al 2009'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
//        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Non-articular ']);
//        $data = array('method_id'=>$method_id,'feature'=>'Non-articular ','display_name'=>'Non-articular ', 'display_order' =>  3, 'display_values' => '{"Unfused":"Unfused", "Fused":"Fused"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
//        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name','=','Rib 9')->first()->id;
//        $method_id = Method::where([['name','=','Schaefer et al 2009'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
//        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Head']);
//        $data = array('method_id'=>$method_id,'feature'=>'Head','display_name'=>'Head', 'display_order' =>  1, 'display_values' => '{"Unfused":"Unfused", "Fused":"Fused"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
//        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name','=','Rib 9')->first()->id;
//        $method_id = Method::where([['name','=','Schaefer et al 2009'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
//        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Tubercle']);
//        $data = array('method_id'=>$method_id,'feature'=>'Tubercle','display_name'=>'Tubercle', 'display_order' =>  2, 'display_values' => '{"Unfused":"Unfused", "Fused":"Fused"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
//        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name','=','Rib 9')->first()->id;
//        $method_id = Method::where([['name','=','Schaefer et al 2009'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
//        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Non-articular ']);
//        $data = array('method_id'=>$method_id,'feature'=>'Non-articular ','display_name'=>'Non-articular ', 'display_order' =>  3, 'display_values' => '{"Unfused":"Unfused", "Fused":"Fused"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
//        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name','=','Rib 11/12')->first()->id;
//        $method_id = Method::where([['name','=','Schaefer et al 2009'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
//        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Head']);
//        $data = array('method_id'=>$method_id,'feature'=>'Head','display_name'=>'Head', 'display_order' =>  1, 'display_values' => '{"Unfused":"Unfused", "Fused":"Fused"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
//        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name','=','Rib 2/3')->first()->id;
//        $method_id = Method::where([['name','=','Schaefer et al 2009'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
//        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Head']);
//        $data = array('method_id'=>$method_id,'feature'=>'Head','display_name'=>'Head', 'display_order' =>  1, 'display_values' => '{"Unfused":"Unfused", "Fused":"Fused"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
//        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name','=','Rib 2/3')->first()->id;
//        $method_id = Method::where([['name','=','Schaefer et al 2009'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
//        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Tubercle']);
//        $data = array('method_id'=>$method_id,'feature'=>'Tubercle','display_name'=>'Tubercle', 'display_order' =>  2, 'display_values' => '{"Unfused":"Unfused", "Fused":"Fused"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
//        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name','=','Rib 2/3')->first()->id;
//        $method_id = Method::where([['name','=','Schaefer et al 2009'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
//        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Non-articular ']);
//        $data = array('method_id'=>$method_id,'feature'=>'Non-articular ','display_name'=>'Non-articular ', 'display_order' =>  3, 'display_values' => '{"Unfused":"Unfused", "Fused":"Fused"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
//        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name','=','Rib 3/4')->first()->id;
//        $method_id = Method::where([['name','=','Schaefer et al 2009'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
//        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Head']);
//        $data = array('method_id'=>$method_id,'feature'=>'Head','display_name'=>'Head', 'display_order' =>  1, 'display_values' => '{"Unfused":"Unfused", "Fused":"Fused"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
//        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name','=','Rib 3/4')->first()->id;
//        $method_id = Method::where([['name','=','Schaefer et al 2009'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
//        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Tubercle']);
//        $data = array('method_id'=>$method_id,'feature'=>'Tubercle','display_name'=>'Tubercle', 'display_order' =>  2, 'display_values' => '{"Unfused":"Unfused", "Fused":"Fused"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
//        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name','=','Rib 3/4')->first()->id;
//        $method_id = Method::where([['name','=','Schaefer et al 2009'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
//        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Non-articular ']);
//        $data = array('method_id'=>$method_id,'feature'=>'Non-articular ','display_name'=>'Non-articular ', 'display_order' =>  3, 'display_values' => '{"Unfused":"Unfused", "Fused":"Fused"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
//        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name','=','Unseriated rib')->first()->id;
//        $method_id = Method::where([['name','=','Schaefer et al 2009'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
//        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Tubercle']);
//        $data = array('method_id'=>$method_id,'feature'=>'Tubercle','display_name'=>'Tubercle', 'display_order' =>  1, 'display_values' => '{"Unfused":"Unfused", "Fused":"Fused"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
//        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name','=','Unseriated rib')->first()->id;
//        $method_id = Method::where([['name','=','Schaefer et al 2009'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
//        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Non-articular ']);
//        $data = array('method_id'=>$method_id,'feature'=>'Non-articular ','display_name'=>'Non-articular ', 'display_order' =>  2, 'display_values' => '{"Unfused":"Unfused", "Fused":"Fused"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
//        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name','=','Sacral vertebra 1')->first()->id;
//        $method_id = Method::where([['name','=','Schaefer et al 2009'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
//        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Posterior Arch']);
//        $data = array('method_id'=>$method_id,'feature'=>'Posterior Arch','display_name'=>'Posterior Arch', 'display_order' =>  1, 'display_values' => '{"Unfused":"Unfused", "Fused":"Fused"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
//        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name','=','Sacral vertebra 1')->first()->id;
//        $method_id = Method::where([['name','=','Schaefer et al 2009'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
//        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Centrum']);
//        $data = array('method_id'=>$method_id,'feature'=>'Centrum','display_name'=>'Centrum', 'display_order' =>  2, 'display_values' => '{"Unfused":"Unfused", "Fused":"Fused"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
//        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name','=','Sacral vertebra 1')->first()->id;
//        $method_id = Method::where([['name','=','Schaefer et al 2009'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
//        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Lateral ']);
//        $data = array('method_id'=>$method_id,'feature'=>'Lateral ','display_name'=>'Lateral ', 'display_order' =>  3, 'display_values' => '{"Unfused":"Unfused", "Fused":"Fused"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
//        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name','=','Sacral vertebra 1')->first()->id;
//        $method_id = Method::where([['name','=','Schaefer et al 2009'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
//        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Auricular Epiphysis']);
//        $data = array('method_id'=>$method_id,'feature'=>'Auricular Epiphysis','display_name'=>'Auricular Epiphysis', 'display_order' =>  4, 'display_values' => '{"Unfused":"Unfused", "Fused":"Fused"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
//        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name','=','Sacral vertebra 2')->first()->id;
//        $method_id = Method::where([['name','=','Schaefer et al 2009'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
//        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Centrum']);
//        $data = array('method_id'=>$method_id,'feature'=>'Centrum','display_name'=>'Centrum', 'display_order' =>  1, 'display_values' => '{"Unfused":"Unfused", "Fused":"Fused"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
//        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name','=','Sacral vertebra 2')->first()->id;
//        $method_id = Method::where([['name','=','Schaefer et al 2009'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
//        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Lateral ']);
//        $data = array('method_id'=>$method_id,'feature'=>'Lateral ','display_name'=>'Lateral ', 'display_order' =>  2, 'display_values' => '{"Unfused":"Unfused", "Fused":"Fused"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
//        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name','=','Sacral vertebra 2')->first()->id;
//        $method_id = Method::where([['name','=','Schaefer et al 2009'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
//        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Auricular Epiphysis']);
//        $data = array('method_id'=>$method_id,'feature'=>'Auricular Epiphysis','display_name'=>'Auricular Epiphysis', 'display_order' =>  3, 'display_values' => '{"Unfused":"Unfused", "Fused":"Fused"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
//        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name','=','Sacral vertebra 2')->first()->id;
//        $method_id = Method::where([['name','=','Schaefer et al 2009'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
//        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Posterior Arch']);
//        $data = array('method_id'=>$method_id,'feature'=>'Posterior Arch','display_name'=>'Posterior Arch', 'display_order' =>  4, 'display_values' => '{"Unfused":"Unfused", "Fused":"Fused"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
//        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name','=','Sacral vertebra 3')->first()->id;
//        $method_id = Method::where([['name','=','Schaefer et al 2009'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
//        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Centrum']);
//        $data = array('method_id'=>$method_id,'feature'=>'Centrum','display_name'=>'Centrum', 'display_order' =>  1, 'display_values' => '{"Unfused":"Unfused", "Fused":"Fused"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
//        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name','=','Sacral vertebra 3')->first()->id;
//        $method_id = Method::where([['name','=','Schaefer et al 2009'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
//        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Lateral ']);
//        $data = array('method_id'=>$method_id,'feature'=>'Lateral ','display_name'=>'Lateral ', 'display_order' =>  2, 'display_values' => '{"Unfused":"Unfused", "Fused":"Fused"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
//        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name','=','Sacral vertebra 3')->first()->id;
//        $method_id = Method::where([['name','=','Schaefer et al 2009'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
//        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Auricular Epiphysis']);
//        $data = array('method_id'=>$method_id,'feature'=>'Auricular Epiphysis','display_name'=>'Auricular Epiphysis', 'display_order' =>  3, 'display_values' => '{"Unfused":"Unfused", "Fused":"Fused"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
//        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name','=','Sacral vertebra 3')->first()->id;
//        $method_id = Method::where([['name','=','Schaefer et al 2009'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
//        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Posterior Arch']);
//        $data = array('method_id'=>$method_id,'feature'=>'Posterior Arch','display_name'=>'Posterior Arch', 'display_order' =>  4, 'display_values' => '{"Unfused":"Unfused", "Fused":"Fused"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
//        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name','=','Sacral vertebra 4')->first()->id;
//        $method_id = Method::where([['name','=','Schaefer et al 2009'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
//        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Centrum']);
//        $data = array('method_id'=>$method_id,'feature'=>'Centrum','display_name'=>'Centrum', 'display_order' =>  1, 'display_values' => '{"Unfused":"Unfused", "Fused":"Fused"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
//        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name','=','Sacral vertebra 5')->first()->id;
//        $method_id = Method::where([['name','=','Schaefer et al 2009'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
//        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Centrum']);
//        $data = array('method_id'=>$method_id,'feature'=>'Centrum','display_name'=>'Centrum', 'display_order' =>  1, 'display_values' => '{"Unfused":"Unfused", "Fused":"Fused"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
//        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name','=','Sacrum')->first()->id;
//        $method_id = Method::where([['name','=','Schaefer et al 2009'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
//        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Centrum']);
//        $data = array('method_id'=>$method_id,'feature'=>'Centrum','display_name'=>'Centrum', 'display_order' =>  1, 'display_values' => '{"Unfused":"Unfused", "Fused":"Fused"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
//        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name','=','Sacrum')->first()->id;
//        $method_id = Method::where([['name','=','Schaefer et al 2009'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
//        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Lateral ']);
//        $data = array('method_id'=>$method_id,'feature'=>'Lateral ','display_name'=>'Lateral ', 'display_order' =>  2, 'display_values' => '{"Unfused":"Unfused", "Fused":"Fused"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
//        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name','=','Scapula')->first()->id;
//        $method_id = Method::where([['name','=','Schaefer et al 2009'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
//        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Superior Glenoid']);
//        $data = array('method_id'=>$method_id,'feature'=>'Superior Glenoid','display_name'=>'Superior Glenoid', 'display_order' =>  1, 'display_values' => '{"Unfused":"Unfused", "Fused":"Fused"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
//        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name','=','Scapula')->first()->id;
//        $method_id = Method::where([['name','=','Schaefer et al 2009'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
//        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Coracoid']);
//        $data = array('method_id'=>$method_id,'feature'=>'Coracoid','display_name'=>'Coracoid', 'display_order' =>  2, 'display_values' => '{"Unfused":"Unfused", "Fused":"Fused"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
//        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name','=','Scapula')->first()->id;
//        $method_id = Method::where([['name','=','Schaefer et al 2009'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
//        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Coracoid Epiphysis 1']);
//        $data = array('method_id'=>$method_id,'feature'=>'Coracoid Epiphysis 1','display_name'=>'Coracoid Epiphysis 1', 'display_order' =>  3, 'display_values' => '{"Unfused":"Unfused", "Fused":"Fused"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
//        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name','=','Scapula')->first()->id;
//        $method_id = Method::where([['name','=','Schaefer et al 2009'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
//        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Coracoid Epiphysis 2']);
//        $data = array('method_id'=>$method_id,'feature'=>'Coracoid Epiphysis 2','display_name'=>'Coracoid Epiphysis 2', 'display_order' =>  4, 'display_values' => '{"Unfused":"Unfused", "Fused":"Fused"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
//        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name','=','Scapula')->first()->id;
//        $method_id = Method::where([['name','=','Schaefer et al 2009'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
//        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Inferior Glenoid']);
//        $data = array('method_id'=>$method_id,'feature'=>'Inferior Glenoid','display_name'=>'Inferior Glenoid', 'display_order' =>  5, 'display_values' => '{"Unfused":"Unfused", "Fused":"Fused"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
//        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name','=','Scapula')->first()->id;
//        $method_id = Method::where([['name','=','Schaefer et al 2009'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
//        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Acromion']);
//        $data = array('method_id'=>$method_id,'feature'=>'Acromion','display_name'=>'Acromion', 'display_order' =>  6, 'display_values' => '{"Unfused":"Unfused", "Fused":"Fused"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
//        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name','=','Scapula')->first()->id;
//        $method_id = Method::where([['name','=','Schaefer et al 2009'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
//        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Superior border']);
//        $data = array('method_id'=>$method_id,'feature'=>'Superior border','display_name'=>'Superior border', 'display_order' =>  7, 'display_values' => '{"Unfused":"Unfused", "Fused":"Fused"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
//        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name','=','Scapula')->first()->id;
//        $method_id = Method::where([['name','=','Schaefer et al 2009'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
//        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Medial  border']);
//        $data = array('method_id'=>$method_id,'feature'=>'Medial  border','display_name'=>'Medial  border', 'display_order' =>  8, 'display_values' => '{"Unfused":"Unfused", "Fused":"Fused"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
//        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name','=','Scapula')->first()->id;
//        $method_id = Method::where([['name','=','Schaefer et al 2009'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
//        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Medial border']);
//        $data = array('method_id'=>$method_id,'feature'=>'Medial border','display_name'=>'Medial border', 'display_order' =>  9, 'display_values' => '{"Unfused":"Unfused", "Fused":"Fused"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
//        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name','=','Scapula')->first()->id;
//        $method_id = Method::where([['name','=','Schaefer et al 2009'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
//        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'inferior border']);
//        $data = array('method_id'=>$method_id,'feature'=>'inferior border','display_name'=>'inferior border', 'display_order' =>  10, 'display_values' => '{"Unfused":"Unfused", "Fused":"Fused"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
//        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name','=','Sternum')->first()->id;
//        $method_id = Method::where([['name','=','Schaefer et al 2009'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
//        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Manubrium']);
//        $data = array('method_id'=>$method_id,'feature'=>'Manubrium','display_name'=>'Manubrium', 'display_order' =>  1, 'display_values' => '{"Unfused":"Unfused", "Fused":"Fused"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
//        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name','=','Sternum')->first()->id;
//        $method_id = Method::where([['name','=','Schaefer et al 2009'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
//        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Sternebra 1-2']);
//        $data = array('method_id'=>$method_id,'feature'=>'Sternebra 1-2','display_name'=>'Sternebra 1-2', 'display_order' =>  2, 'display_values' => '{"Unfused":"Unfused", "Fused":"Fused"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
//        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name','=','Sternum')->first()->id;
//        $method_id = Method::where([['name','=','Schaefer et al 2009'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
//        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Sternebra 2-3']);
//        $data = array('method_id'=>$method_id,'feature'=>'Sternebra 2-3','display_name'=>'Sternebra 2-3', 'display_order' =>  3, 'display_values' => '{"Unfused":"Unfused", "Fused":"Fused"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
//        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name','=','Sternum')->first()->id;
//        $method_id = Method::where([['name','=','Schaefer et al 2009'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
//        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Sternebra 3-4']);
//        $data = array('method_id'=>$method_id,'feature'=>'Sternebra 3-4','display_name'=>'Sternebra 3-4', 'display_order' =>  4, 'display_values' => '{"Unfused":"Unfused", "Fused":"Fused"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
//        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name','=','Sternum')->first()->id;
//        $method_id = Method::where([['name','=','Schaefer et al 2009'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
//        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Sternebra']);
//        $data = array('method_id'=>$method_id,'feature'=>'Sternebra','display_name'=>'Sternebra', 'display_order' =>  5, 'display_values' => '{"Unfused":"Unfused", "Fused":"Fused"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
//        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name','=','Sternum')->first()->id;
//        $method_id = Method::where([['name','=','Schaefer et al 2009'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
//        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Xiphoid Process']);
//        $data = array('method_id'=>$method_id,'feature'=>'Xiphoid Process','display_name'=>'Xiphoid Process', 'display_order' =>  6, 'display_values' => '{"Unfused":"Unfused", "Fused":"Fused"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
//        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name','=','Manubrium')->first()->id;
//        $method_id = Method::where([['name','=','Schaefer et al 2009'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
//        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Sternal Body']);
//        $data = array('method_id'=>$method_id,'feature'=>'Sternal Body','display_name'=>'Sternal Body', 'display_order' =>  1, 'display_values' => '{"Unfused":"Unfused", "Fused":"Fused"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
//        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name','=','Sternal body')->first()->id;
//        $method_id = Method::where([['name','=','Schaefer et al 2009'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
//        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Sternebra 1-2']);
//        $data = array('method_id'=>$method_id,'feature'=>'Sternebra 1-2','display_name'=>'Sternebra 1-2', 'display_order' =>  1, 'display_values' => '{"Unfused":"Unfused", "Fused":"Fused"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
//        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name','=','Sternal body')->first()->id;
//        $method_id = Method::where([['name','=','Schaefer et al 2009'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
//        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Sternebra 2-3']);
//        $data = array('method_id'=>$method_id,'feature'=>'Sternebra 2-3','display_name'=>'Sternebra 2-3', 'display_order' =>  2, 'display_values' => '{"Unfused":"Unfused", "Fused":"Fused"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
//        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name','=','Sternal body')->first()->id;
//        $method_id = Method::where([['name','=','Schaefer et al 2009'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
//        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Sternebra 3-4']);
//        $data = array('method_id'=>$method_id,'feature'=>'Sternebra 3-4','display_name'=>'Sternebra 3-4', 'display_order' =>  3, 'display_values' => '{"Unfused":"Unfused", "Fused":"Fused"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
//        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name','=','Sternal body')->first()->id;
//        $method_id = Method::where([['name','=','Schaefer et al 2009'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
//        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Sternebra']);
//        $data = array('method_id'=>$method_id,'feature'=>'Sternebra','display_name'=>'Sternebra', 'display_order' =>  4, 'display_values' => '{"Unfused":"Unfused", "Fused":"Fused"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
//        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name','=','Xiphoid process')->first()->id;
//        $method_id = Method::where([['name','=','Schaefer et al 2009'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
//        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Sternebra 4']);
//        $data = array('method_id'=>$method_id,'feature'=>'Sternebra 4','display_name'=>'Sternebra 4', 'display_order' =>  1, 'display_values' => '{"Unfused":"Unfused", "Fused":"Fused"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
//        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name','=','Thoracic vertebra 1')->first()->id;
//        $method_id = Method::where([['name','=','Schaefer et al 2009'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
//        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Epiphyseal Ring']);
//        $data = array('method_id'=>$method_id,'feature'=>'Epiphyseal Ring','display_name'=>'Epiphyseal Ring', 'display_order' =>  1, 'display_values' => '{"Unfused":"Unfused", "Fused":"Fused"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
//        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name','=','Thoracic vertebra 1')->first()->id;
//        $method_id = Method::where([['name','=','Schaefer et al 2009'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
//        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Centrum']);
//        $data = array('method_id'=>$method_id,'feature'=>'Centrum','display_name'=>'Centrum', 'display_order' =>  2, 'display_values' => '{"Unfused":"Unfused", "Fused":"Fused"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
//        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name','=','Thoracic vertebra 1')->first()->id;
//        $method_id = Method::where([['name','=','Schaefer et al 2009'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
//        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Posterior Arch']);
//        $data = array('method_id'=>$method_id,'feature'=>'Posterior Arch','display_name'=>'Posterior Arch', 'display_order' =>  3, 'display_values' => '{"Unfused":"Unfused", "Fused":"Fused"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
//        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name','=','Thoracic vertebra 10')->first()->id;
//        $method_id = Method::where([['name','=','Schaefer et al 2009'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
//        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Epiphyseal Ring']);
//        $data = array('method_id'=>$method_id,'feature'=>'Epiphyseal Ring','display_name'=>'Epiphyseal Ring', 'display_order' =>  1, 'display_values' => '{"Unfused":"Unfused", "Fused":"Fused"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
//        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name','=','Thoracic vertebra 10')->first()->id;
//        $method_id = Method::where([['name','=','Schaefer et al 2009'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
//        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Centrum']);
//        $data = array('method_id'=>$method_id,'feature'=>'Centrum','display_name'=>'Centrum', 'display_order' =>  2, 'display_values' => '{"Unfused":"Unfused", "Fused":"Fused"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
//        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name','=','Thoracic vertebra 10')->first()->id;
//        $method_id = Method::where([['name','=','Schaefer et al 2009'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
//        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Posterior Arch']);
//        $data = array('method_id'=>$method_id,'feature'=>'Posterior Arch','display_name'=>'Posterior Arch', 'display_order' =>  3, 'display_values' => '{"Unfused":"Unfused", "Fused":"Fused"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
//        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name','=','Thoracic vertebra 11')->first()->id;
//        $method_id = Method::where([['name','=','Schaefer et al 2009'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
//        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Epiphyseal Ring']);
//        $data = array('method_id'=>$method_id,'feature'=>'Epiphyseal Ring','display_name'=>'Epiphyseal Ring', 'display_order' =>  1, 'display_values' => '{"Unfused":"Unfused", "Fused":"Fused"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
//        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name','=','Thoracic vertebra 11')->first()->id;
//        $method_id = Method::where([['name','=','Schaefer et al 2009'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
//        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Centrum']);
//        $data = array('method_id'=>$method_id,'feature'=>'Centrum','display_name'=>'Centrum', 'display_order' =>  2, 'display_values' => '{"Unfused":"Unfused", "Fused":"Fused"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
//        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name','=','Thoracic vertebra 11')->first()->id;
//        $method_id = Method::where([['name','=','Schaefer et al 2009'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
//        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Posterior Arch']);
//        $data = array('method_id'=>$method_id,'feature'=>'Posterior Arch','display_name'=>'Posterior Arch', 'display_order' =>  3, 'display_values' => '{"Unfused":"Unfused", "Fused":"Fused"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
//        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name','=','Thoracic vertebra 12')->first()->id;
//        $method_id = Method::where([['name','=','Schaefer et al 2009'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
//        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Epiphyseal Ring']);
//        $data = array('method_id'=>$method_id,'feature'=>'Epiphyseal Ring','display_name'=>'Epiphyseal Ring', 'display_order' =>  1, 'display_values' => '{"Unfused":"Unfused", "Fused":"Fused"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
//        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name','=','Thoracic vertebra 12')->first()->id;
//        $method_id = Method::where([['name','=','Schaefer et al 2009'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
//        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Centrum']);
//        $data = array('method_id'=>$method_id,'feature'=>'Centrum','display_name'=>'Centrum', 'display_order' =>  2, 'display_values' => '{"Unfused":"Unfused", "Fused":"Fused"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
//        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name','=','Thoracic vertebra 12')->first()->id;
//        $method_id = Method::where([['name','=','Schaefer et al 2009'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
//        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Posterior Arch']);
//        $data = array('method_id'=>$method_id,'feature'=>'Posterior Arch','display_name'=>'Posterior Arch', 'display_order' =>  3, 'display_values' => '{"Unfused":"Unfused", "Fused":"Fused"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
//        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name','=','Thoracic vertebra 2')->first()->id;
//        $method_id = Method::where([['name','=','Schaefer et al 2009'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
//        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Epiphyseal Ring']);
//        $data = array('method_id'=>$method_id,'feature'=>'Epiphyseal Ring','display_name'=>'Epiphyseal Ring', 'display_order' =>  1, 'display_values' => '{"Unfused":"Unfused", "Fused":"Fused"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
//        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name','=','Thoracic vertebra 2')->first()->id;
//        $method_id = Method::where([['name','=','Schaefer et al 2009'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
//        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Centrum']);
//        $data = array('method_id'=>$method_id,'feature'=>'Centrum','display_name'=>'Centrum', 'display_order' =>  2, 'display_values' => '{"Unfused":"Unfused", "Fused":"Fused"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
//        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name','=','Thoracic vertebra 2')->first()->id;
//        $method_id = Method::where([['name','=','Schaefer et al 2009'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
//        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Posterior Arch']);
//        $data = array('method_id'=>$method_id,'feature'=>'Posterior Arch','display_name'=>'Posterior Arch', 'display_order' =>  3, 'display_values' => '{"Unfused":"Unfused", "Fused":"Fused"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
//        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name','=','Thoracic vertebra 3')->first()->id;
//        $method_id = Method::where([['name','=','Schaefer et al 2009'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
//        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Epiphyseal Ring']);
//        $data = array('method_id'=>$method_id,'feature'=>'Epiphyseal Ring','display_name'=>'Epiphyseal Ring', 'display_order' =>  1, 'display_values' => '{"Unfused":"Unfused", "Fused":"Fused"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
//        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name','=','Thoracic vertebra 3')->first()->id;
//        $method_id = Method::where([['name','=','Schaefer et al 2009'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
//        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Centrum']);
//        $data = array('method_id'=>$method_id,'feature'=>'Centrum','display_name'=>'Centrum', 'display_order' =>  2, 'display_values' => '{"Unfused":"Unfused", "Fused":"Fused"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
//        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name','=','Thoracic vertebra 3')->first()->id;
//        $method_id = Method::where([['name','=','Schaefer et al 2009'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
//        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Posterior Arch']);
//        $data = array('method_id'=>$method_id,'feature'=>'Posterior Arch','display_name'=>'Posterior Arch', 'display_order' =>  3, 'display_values' => '{"Unfused":"Unfused", "Fused":"Fused"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
//        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name','=','Thoracic vertebra 10/11/12')->first()->id;
//        $method_id = Method::where([['name','=','Schaefer et al 2009'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
//        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Epiphyseal Ring']);
//        $data = array('method_id'=>$method_id,'feature'=>'Epiphyseal Ring','display_name'=>'Epiphyseal Ring', 'display_order' =>  1, 'display_values' => '{"Unfused":"Unfused", "Fused":"Fused"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
//        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name','=','Thoracic vertebra 10/11/12')->first()->id;
//        $method_id = Method::where([['name','=','Schaefer et al 2009'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
//        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Centrum']);
//        $data = array('method_id'=>$method_id,'feature'=>'Centrum','display_name'=>'Centrum', 'display_order' =>  2, 'display_values' => '{"Unfused":"Unfused", "Fused":"Fused"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
//        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name','=','Thoracic vertebra 10/11/12')->first()->id;
//        $method_id = Method::where([['name','=','Schaefer et al 2009'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
//        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Posterior Arch']);
//        $data = array('method_id'=>$method_id,'feature'=>'Posterior Arch','display_name'=>'Posterior Arch', 'display_order' =>  3, 'display_values' => '{"Unfused":"Unfused", "Fused":"Fused"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
//        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name','=','Thoracic vertebra 10/11')->first()->id;
//        $method_id = Method::where([['name','=','Schaefer et al 2009'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
//        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Epiphyseal Ring']);
//        $data = array('method_id'=>$method_id,'feature'=>'Epiphyseal Ring','display_name'=>'Epiphyseal Ring', 'display_order' =>  1, 'display_values' => '{"Unfused":"Unfused", "Fused":"Fused"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
//        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name','=','Thoracic vertebra 10/11')->first()->id;
//        $method_id = Method::where([['name','=','Schaefer et al 2009'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
//        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Centrum']);
//        $data = array('method_id'=>$method_id,'feature'=>'Centrum','display_name'=>'Centrum', 'display_order' =>  2, 'display_values' => '{"Unfused":"Unfused", "Fused":"Fused"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
//        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name','=','Thoracic vertebra 10/11')->first()->id;
//        $method_id = Method::where([['name','=','Schaefer et al 2009'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
//        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Posterior Arch']);
//        $data = array('method_id'=>$method_id,'feature'=>'Posterior Arch','display_name'=>'Posterior Arch', 'display_order' =>  3, 'display_values' => '{"Unfused":"Unfused", "Fused":"Fused"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
//        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name','=','Thoracic vertebra 11/12')->first()->id;
//        $method_id = Method::where([['name','=','Schaefer et al 2009'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
//        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Epiphyseal Ring']);
//        $data = array('method_id'=>$method_id,'feature'=>'Epiphyseal Ring','display_name'=>'Epiphyseal Ring', 'display_order' =>  1, 'display_values' => '{"Unfused":"Unfused", "Fused":"Fused"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
//        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name','=','Thoracic vertebra 11/12')->first()->id;
//        $method_id = Method::where([['name','=','Schaefer et al 2009'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
//        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Centrum']);
//        $data = array('method_id'=>$method_id,'feature'=>'Centrum','display_name'=>'Centrum', 'display_order' =>  2, 'display_values' => '{"Unfused":"Unfused", "Fused":"Fused"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
//        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name','=','Thoracic vertebra 11/12')->first()->id;
//        $method_id = Method::where([['name','=','Schaefer et al 2009'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
//        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Posterior Arch']);
//        $data = array('method_id'=>$method_id,'feature'=>'Posterior Arch','display_name'=>'Posterior Arch', 'display_order' =>  3, 'display_values' => '{"Unfused":"Unfused", "Fused":"Fused"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
//        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name','=','Thoracic vertebra 4')->first()->id;
//        $method_id = Method::where([['name','=','Schaefer et al 2009'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
//        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Epiphyseal Ring']);
//        $data = array('method_id'=>$method_id,'feature'=>'Epiphyseal Ring','display_name'=>'Epiphyseal Ring', 'display_order' =>  1, 'display_values' => '{"Unfused":"Unfused", "Fused":"Fused"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
//        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name','=','Thoracic vertebra 4')->first()->id;
//        $method_id = Method::where([['name','=','Schaefer et al 2009'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
//        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Centrum']);
//        $data = array('method_id'=>$method_id,'feature'=>'Centrum','display_name'=>'Centrum', 'display_order' =>  2, 'display_values' => '{"Unfused":"Unfused", "Fused":"Fused"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
//        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name','=','Thoracic vertebra 4')->first()->id;
//        $method_id = Method::where([['name','=','Schaefer et al 2009'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
//        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Posterior Arch']);
//        $data = array('method_id'=>$method_id,'feature'=>'Posterior Arch','display_name'=>'Posterior Arch', 'display_order' =>  3, 'display_values' => '{"Unfused":"Unfused", "Fused":"Fused"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
//        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name','=','Unseriated thoracic vertebra')->first()->id;
//        $method_id = Method::where([['name','=','Schaefer et al 2009'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
//        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Epiphyseal Ring']);
//        $data = array('method_id'=>$method_id,'feature'=>'Epiphyseal Ring','display_name'=>'Epiphyseal Ring', 'display_order' =>  1, 'display_values' => '{"Unfused":"Unfused", "Fused":"Fused"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
//        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name','=','Unseriated thoracic vertebra')->first()->id;
//        $method_id = Method::where([['name','=','Schaefer et al 2009'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
//        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Centrum']);
//        $data = array('method_id'=>$method_id,'feature'=>'Centrum','display_name'=>'Centrum', 'display_order' =>  2, 'display_values' => '{"Unfused":"Unfused", "Fused":"Fused"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
//        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name','=','Unseriated thoracic vertebra')->first()->id;
//        $method_id = Method::where([['name','=','Schaefer et al 2009'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
//        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Posterior Arch']);
//        $data = array('method_id'=>$method_id,'feature'=>'Posterior Arch','display_name'=>'Posterior Arch', 'display_order' =>  3, 'display_values' => '{"Unfused":"Unfused", "Fused":"Fused"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
//        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name','=','Thoracic vertebra 5')->first()->id;
//        $method_id = Method::where([['name','=','Schaefer et al 2009'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
//        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Epiphyseal Ring']);
//        $data = array('method_id'=>$method_id,'feature'=>'Epiphyseal Ring','display_name'=>'Epiphyseal Ring', 'display_order' =>  1, 'display_values' => '{"Unfused":"Unfused", "Fused":"Fused"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
//        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name','=','Thoracic vertebra 5')->first()->id;
//        $method_id = Method::where([['name','=','Schaefer et al 2009'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
//        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Centrum']);
//        $data = array('method_id'=>$method_id,'feature'=>'Centrum','display_name'=>'Centrum', 'display_order' =>  2, 'display_values' => '{"Unfused":"Unfused", "Fused":"Fused"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
//        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name','=','Thoracic vertebra 5')->first()->id;
//        $method_id = Method::where([['name','=','Schaefer et al 2009'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
//        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Posterior Arch']);
//        $data = array('method_id'=>$method_id,'feature'=>'Posterior Arch','display_name'=>'Posterior Arch', 'display_order' =>  3, 'display_values' => '{"Unfused":"Unfused", "Fused":"Fused"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
//        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name','=','Thoracic vertebra 6')->first()->id;
//        $method_id = Method::where([['name','=','Schaefer et al 2009'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
//        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Epiphyseal Ring']);
//        $data = array('method_id'=>$method_id,'feature'=>'Epiphyseal Ring','display_name'=>'Epiphyseal Ring', 'display_order' =>  1, 'display_values' => '{"Unfused":"Unfused", "Fused":"Fused"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
//        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name','=','Thoracic vertebra 6')->first()->id;
//        $method_id = Method::where([['name','=','Schaefer et al 2009'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
//        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Centrum']);
//        $data = array('method_id'=>$method_id,'feature'=>'Centrum','display_name'=>'Centrum', 'display_order' =>  2, 'display_values' => '{"Unfused":"Unfused", "Fused":"Fused"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
//        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name','=','Thoracic vertebra 6')->first()->id;
//        $method_id = Method::where([['name','=','Schaefer et al 2009'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
//        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Posterior Arch']);
//        $data = array('method_id'=>$method_id,'feature'=>'Posterior Arch','display_name'=>'Posterior Arch', 'display_order' =>  3, 'display_values' => '{"Unfused":"Unfused", "Fused":"Fused"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
//        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name','=','Thoracic vertebra 7')->first()->id;
//        $method_id = Method::where([['name','=','Schaefer et al 2009'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
//        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Epiphyseal Ring']);
//        $data = array('method_id'=>$method_id,'feature'=>'Epiphyseal Ring','display_name'=>'Epiphyseal Ring', 'display_order' =>  1, 'display_values' => '{"Unfused":"Unfused", "Fused":"Fused"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
//        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name','=','Thoracic vertebra 7')->first()->id;
//        $method_id = Method::where([['name','=','Schaefer et al 2009'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
//        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Centrum']);
//        $data = array('method_id'=>$method_id,'feature'=>'Centrum','display_name'=>'Centrum', 'display_order' =>  2, 'display_values' => '{"Unfused":"Unfused", "Fused":"Fused"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
//        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name','=','Thoracic vertebra 7')->first()->id;
//        $method_id = Method::where([['name','=','Schaefer et al 2009'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
//        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Posterior Arch']);
//        $data = array('method_id'=>$method_id,'feature'=>'Posterior Arch','display_name'=>'Posterior Arch', 'display_order' =>  3, 'display_values' => '{"Unfused":"Unfused", "Fused":"Fused"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
//        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name','=','Thoracic vertebra 8')->first()->id;
//        $method_id = Method::where([['name','=','Schaefer et al 2009'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
//        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Epiphyseal Ring']);
//        $data = array('method_id'=>$method_id,'feature'=>'Epiphyseal Ring','display_name'=>'Epiphyseal Ring', 'display_order' =>  1, 'display_values' => '{"Unfused":"Unfused", "Fused":"Fused"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
//        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name','=','Thoracic vertebra 8')->first()->id;
//        $method_id = Method::where([['name','=','Schaefer et al 2009'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
//        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Centrum']);
//        $data = array('method_id'=>$method_id,'feature'=>'Centrum','display_name'=>'Centrum', 'display_order' =>  2, 'display_values' => '{"Unfused":"Unfused", "Fused":"Fused"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
//        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name','=','Thoracic vertebra 8')->first()->id;
//        $method_id = Method::where([['name','=','Schaefer et al 2009'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
//        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Posterior Arch']);
//        $data = array('method_id'=>$method_id,'feature'=>'Posterior Arch','display_name'=>'Posterior Arch', 'display_order' =>  3, 'display_values' => '{"Unfused":"Unfused", "Fused":"Fused"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
//        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name','=','Thoracic vertebra 9')->first()->id;
//        $method_id = Method::where([['name','=','Schaefer et al 2009'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
//        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Epiphyseal Ring']);
//        $data = array('method_id'=>$method_id,'feature'=>'Epiphyseal Ring','display_name'=>'Epiphyseal Ring', 'display_order' =>  1, 'display_values' => '{"Unfused":"Unfused", "Fused":"Fused"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
//        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name','=','Thoracic vertebra 9')->first()->id;
//        $method_id = Method::where([['name','=','Schaefer et al 2009'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
//        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Centrum']);
//        $data = array('method_id'=>$method_id,'feature'=>'Centrum','display_name'=>'Centrum', 'display_order' =>  2, 'display_values' => '{"Unfused":"Unfused", "Fused":"Fused"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
//        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name','=','Thoracic vertebra 9')->first()->id;
//        $method_id = Method::where([['name','=','Schaefer et al 2009'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
//        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Posterior Arch']);
//        $data = array('method_id'=>$method_id,'feature'=>'Posterior Arch','display_name'=>'Posterior Arch', 'display_order' =>  3, 'display_values' => '{"Unfused":"Unfused", "Fused":"Fused"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
//        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name','=','Tibia')->first()->id;
//        $method_id = Method::where([['name','=','Schaefer et al 2009'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
//        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Distal']);
//        $data = array('method_id'=>$method_id,'feature'=>'Distal','display_name'=>'Distal', 'display_order' =>  1, 'display_values' => '{"Unfused":"Unfused", "Fused":"Fused"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
//        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name','=','Tibia')->first()->id;
//        $method_id = Method::where([['name','=','Schaefer et al 2009'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
//        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Tuberosity']);
//        $data = array('method_id'=>$method_id,'feature'=>'Tuberosity','display_name'=>'Tuberosity', 'display_order' =>  2, 'display_values' => '{"Unfused":"Unfused", "Fused":"Fused"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
//        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name','=','Tibia')->first()->id;
//        $method_id = Method::where([['name','=','Schaefer et al 2009'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
//        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Proximal']);
//        $data = array('method_id'=>$method_id,'feature'=>'Proximal','display_name'=>'Proximal', 'display_order' =>  3, 'display_values' => '{"Unfused":"Unfused", "Fused":"Fused"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
//        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name','=','Ulna')->first()->id;
//        $method_id = Method::where([['name','=','Schaefer et al 2009'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
//        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Proximal']);
//        $data = array('method_id'=>$method_id,'feature'=>'Proximal','display_name'=>'Proximal', 'display_order' =>  1, 'display_values' => '{"Unfused":"Unfused", "Fused":"Fused"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
//        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name','=','Ulna')->first()->id;
//        $method_id = Method::where([['name','=','Schaefer et al 2009'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
//        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Distal']);
//        $data = array('method_id'=>$method_id,'feature'=>'Distal','display_name'=>'Distal', 'display_order' =>  2, 'display_values' => '{"Unfused":"Unfused", "Fused":"Fused"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
//        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name','=','Unseriated distal pedal phalanx')->first()->id;
//        $method_id = Method::where([['name','=','Schaefer et al 2009'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
//        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Epiphysis']);
//        $data = array('method_id'=>$method_id,'feature'=>'Epiphysis','display_name'=>'Epiphysis', 'display_order' =>  1, 'display_values' => '{"Unfused":"Unfused", "Fused":"Fused"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
//        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name','=','Unseriated proximal pedal phalanx')->first()->id;
//        $method_id = Method::where([['name','=','Schaefer et al 2009'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
//        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Epiphysis']);
//        $data = array('method_id'=>$method_id,'feature'=>'Epiphysis','display_name'=>'Epiphysis', 'display_order' =>  1, 'display_values' => '{"Unfused":"Unfused", "Fused":"Fused"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
//        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name','=','Unseriated intermediate pedal phalanx')->first()->id;
//        $method_id = Method::where([['name','=','Schaefer et al 2009'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
//        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Epiphysis']);
//        $data = array('method_id'=>$method_id,'feature'=>'Epiphysis','display_name'=>'Epiphysis', 'display_order' =>  1, 'display_values' => '{"Unfused":"Unfused", "Fused":"Fused"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
//        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name','=','Unseriated distal manual phalanx')->first()->id;
//        $method_id = Method::where([['name','=','Schaefer et al 2009'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
//        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Epiphysis']);
//        $data = array('method_id'=>$method_id,'feature'=>'Epiphysis','display_name'=>'Epiphysis', 'display_order' =>  1, 'display_values' => '{"Unfused":"Unfused", "Fused":"Fused"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
//        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name','=','Unseriated proximal manual phalanx')->first()->id;
//        $method_id = Method::where([['name','=','Schaefer et al 2009'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
//        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Epiphysis']);
//        $data = array('method_id'=>$method_id,'feature'=>'Epiphysis','display_name'=>'Epiphysis', 'display_order' =>  1, 'display_values' => '{"Unfused":"Unfused", "Fused":"Fused"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
//        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();
//
//        $sb_id = SkeletalBone::where('name','=','Unseriated intermediate manual phalanx')->first()->id;
//        $method_id = Method::where([['name','=','Schaefer et al 2009'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
//        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Epiphysis']);
//        $data = array('method_id'=>$method_id,'feature'=>'Epiphysis','display_name'=>'Epiphysis', 'display_order' =>  1, 'display_values' => '{"Unfused":"Unfused", "Fused":"Fused"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
//        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();

        /// End - Old SSchaefer et al 2009 method
        //////////////////////////////////////////////////////////////////

        $sb_id = SkeletalBone::where('name','=','Thoracic vertebra 1')->first()->id;
        $method_id = Method::where([['name','=','Albert and Maples 1995'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Superior Vertebral Ring']);
        $data = array('method_id'=>$method_id,'feature'=>'Superior Vertebral Ring','display_name'=>'Superior Vertebral Ring', 'display_order' =>  1, 'display_values' => '{"0":"0", "1":"1", "2":"2", "3":"3"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name','=','Thoracic vertebra 1')->first()->id;
        $method_id = Method::where([['name','=','Albert and Maples 1995'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Inferior Vertebral Ring']);
        $data = array('method_id'=>$method_id,'feature'=>'Inferior Vertebral Ring','display_name'=>'Inferior Vertebral Ring', 'display_order' =>  2, 'display_values' => '{"0":"0", "1":"1", "2":"2", "3":"3"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name','=','Thoracic vertebra 2')->first()->id;
        $method_id = Method::where([['name','=','Albert and Maples 1995'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Superior Vertebral Ring']);
        $data = array('method_id'=>$method_id,'feature'=>'Superior Vertebral Ring','display_name'=>'Superior Vertebral Ring', 'display_order' =>  1, 'display_values' => '{"0":"0", "1":"1", "2":"2", "3":"3"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name','=','Thoracic vertebra 2')->first()->id;
        $method_id = Method::where([['name','=','Albert and Maples 1995'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Inferior Vertebral Ring']);
        $data = array('method_id'=>$method_id,'feature'=>'Inferior Vertebral Ring','display_name'=>'Inferior Vertebral Ring', 'display_order' =>  2, 'display_values' => '{"0":"0", "1":"1", "2":"2", "3":"3"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name','=','Thoracic vertebra 3')->first()->id;
        $method_id = Method::where([['name','=','Albert and Maples 1995'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Superior Vertebral Ring']);
        $data = array('method_id'=>$method_id,'feature'=>'Superior Vertebral Ring','display_name'=>'Superior Vertebral Ring', 'display_order' =>  1, 'display_values' => '{"0":"0", "1":"1", "2":"2", "3":"3"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name','=','Thoracic vertebra 3')->first()->id;
        $method_id = Method::where([['name','=','Albert and Maples 1995'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Inferior Vertebral Ring']);
        $data = array('method_id'=>$method_id,'feature'=>'Inferior Vertebral Ring','display_name'=>'Inferior Vertebral Ring', 'display_order' =>  2, 'display_values' => '{"0":"0", "1":"1", "2":"2", "3":"3"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name','=','Thoracic vertebra 4')->first()->id;
        $method_id = Method::where([['name','=','Albert and Maples 1995'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Superior Vertebral Ring']);
        $data = array('method_id'=>$method_id,'feature'=>'Superior Vertebral Ring','display_name'=>'Superior Vertebral Ring', 'display_order' =>  1, 'display_values' => '{"0":"0", "1":"1", "2":"2", "3":"3"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name','=','Thoracic vertebra 4')->first()->id;
        $method_id = Method::where([['name','=','Albert and Maples 1995'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Inferior Vertebral Ring']);
        $data = array('method_id'=>$method_id,'feature'=>'Inferior Vertebral Ring','display_name'=>'Inferior Vertebral Ring', 'display_order' =>  2, 'display_values' => '{"0":"0", "1":"1", "2":"2", "3":"3"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name','=','Thoracic vertebra 5')->first()->id;
        $method_id = Method::where([['name','=','Albert and Maples 1995'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Superior Vertebral Ring']);
        $data = array('method_id'=>$method_id,'feature'=>'Superior Vertebral Ring','display_name'=>'Superior Vertebral Ring', 'display_order' =>  1, 'display_values' => '{"0":"0", "1":"1", "2":"2", "3":"3"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name','=','Thoracic vertebra 5')->first()->id;
        $method_id = Method::where([['name','=','Albert and Maples 1995'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Inferior Vertebral Ring']);
        $data = array('method_id'=>$method_id,'feature'=>'Inferior Vertebral Ring','display_name'=>'Inferior Vertebral Ring', 'display_order' =>  2, 'display_values' => '{"0":"0", "1":"1", "2":"2", "3":"3"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name','=','Thoracic vertebra 6')->first()->id;
        $method_id = Method::where([['name','=','Albert and Maples 1995'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Superior Vertebral Ring']);
        $data = array('method_id'=>$method_id,'feature'=>'Superior Vertebral Ring','display_name'=>'Superior Vertebral Ring', 'display_order' =>  1, 'display_values' => '{"0":"0", "1":"1", "2":"2", "3":"3"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name','=','Thoracic vertebra 6')->first()->id;
        $method_id = Method::where([['name','=','Albert and Maples 1995'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Inferior Vertebral Ring']);
        $data = array('method_id'=>$method_id,'feature'=>'Inferior Vertebral Ring','display_name'=>'Inferior Vertebral Ring', 'display_order' =>  2, 'display_values' => '{"0":"0", "1":"1", "2":"2", "3":"3"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name','=','Thoracic vertebra 7')->first()->id;
        $method_id = Method::where([['name','=','Albert and Maples 1995'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Superior Vertebral Ring']);
        $data = array('method_id'=>$method_id,'feature'=>'Superior Vertebral Ring','display_name'=>'Superior Vertebral Ring', 'display_order' =>  1, 'display_values' => '{"0":"0", "1":"1", "2":"2", "3":"3"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name','=','Thoracic vertebra 7')->first()->id;
        $method_id = Method::where([['name','=','Albert and Maples 1995'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Inferior Vertebral Ring']);
        $data = array('method_id'=>$method_id,'feature'=>'Inferior Vertebral Ring','display_name'=>'Inferior Vertebral Ring', 'display_order' =>  2, 'display_values' => '{"0":"0", "1":"1", "2":"2", "3":"3"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name','=','Thoracic vertebra 8')->first()->id;
        $method_id = Method::where([['name','=','Albert and Maples 1995'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Superior Vertebral Ring']);
        $data = array('method_id'=>$method_id,'feature'=>'Superior Vertebral Ring','display_name'=>'Superior Vertebral Ring', 'display_order' =>  1, 'display_values' => '{"0":"0", "1":"1", "2":"2", "3":"3"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name','=','Thoracic vertebra 8')->first()->id;
        $method_id = Method::where([['name','=','Albert and Maples 1995'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Inferior Vertebral Ring']);
        $data = array('method_id'=>$method_id,'feature'=>'Inferior Vertebral Ring','display_name'=>'Inferior Vertebral Ring', 'display_order' =>  2, 'display_values' => '{"0":"0", "1":"1", "2":"2", "3":"3"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name','=','Thoracic vertebra 9')->first()->id;
        $method_id = Method::where([['name','=','Albert and Maples 1995'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Superior Vertebral Ring']);
        $data = array('method_id'=>$method_id,'feature'=>'Superior Vertebral Ring','display_name'=>'Superior Vertebral Ring', 'display_order' =>  1, 'display_values' => '{"0":"0", "1":"1", "2":"2", "3":"3"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name','=','Thoracic vertebra 9')->first()->id;
        $method_id = Method::where([['name','=','Albert and Maples 1995'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Inferior Vertebral Ring']);
        $data = array('method_id'=>$method_id,'feature'=>'Inferior Vertebral Ring','display_name'=>'Inferior Vertebral Ring', 'display_order' =>  2, 'display_values' => '{"0":"0", "1":"1", "2":"2", "3":"3"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name','=','Thoracic vertebra 10')->first()->id;
        $method_id = Method::where([['name','=','Albert and Maples 1995'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Superior Vertebral Ring']);
        $data = array('method_id'=>$method_id,'feature'=>'Superior Vertebral Ring','display_name'=>'Superior Vertebral Ring', 'display_order' =>  1, 'display_values' => '{"0":"0", "1":"1", "2":"2", "3":"3"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name','=','Thoracic vertebra 10')->first()->id;
        $method_id = Method::where([['name','=','Albert and Maples 1995'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Inferior Vertebral Ring']);
        $data = array('method_id'=>$method_id,'feature'=>'Inferior Vertebral Ring','display_name'=>'Inferior Vertebral Ring', 'display_order' =>  2, 'display_values' => '{"0":"0", "1":"1", "2":"2", "3":"3"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name','=','Thoracic vertebra 11')->first()->id;
        $method_id = Method::where([['name','=','Albert and Maples 1995'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Superior Vertebral Ring']);
        $data = array('method_id'=>$method_id,'feature'=>'Superior Vertebral Ring','display_name'=>'Superior Vertebral Ring', 'display_order' =>  1, 'display_values' => '{"0":"0", "1":"1", "2":"2", "3":"3"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name','=','Thoracic vertebra 11')->first()->id;
        $method_id = Method::where([['name','=','Albert and Maples 1995'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Inferior Vertebral Ring']);
        $data = array('method_id'=>$method_id,'feature'=>'Inferior Vertebral Ring','display_name'=>'Inferior Vertebral Ring', 'display_order' =>  2, 'display_values' => '{"0":"0", "1":"1", "2":"2", "3":"3"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name','=','Thoracic vertebra 12')->first()->id;
        $method_id = Method::where([['name','=','Albert and Maples 1995'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Superior Vertebral Ring']);
        $data = array('method_id'=>$method_id,'feature'=>'Superior Vertebral Ring','display_name'=>'Superior Vertebral Ring', 'display_order' =>  1, 'display_values' => '{"0":"0", "1":"1", "2":"2", "3":"3"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name','=','Thoracic vertebra 12')->first()->id;
        $method_id = Method::where([['name','=','Albert and Maples 1995'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Inferior Vertebral Ring']);
        $data = array('method_id'=>$method_id,'feature'=>'Inferior Vertebral Ring','display_name'=>'Inferior Vertebral Ring', 'display_order' =>  2, 'display_values' => '{"0":"0", "1":"1", "2":"2", "3":"3"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name','=','Thoracic vertebra 10/11/12')->first()->id;
        $method_id = Method::where([['name','=','Albert and Maples 1995'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Superior Vertebral Ring']);
        $data = array('method_id'=>$method_id,'feature'=>'Superior Vertebral Ring','display_name'=>'Superior Vertebral Ring', 'display_order' =>  1, 'display_values' => '{"0":"0", "1":"1", "2":"2", "3":"3"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name','=','Thoracic vertebra 10/11/12')->first()->id;
        $method_id = Method::where([['name','=','Albert and Maples 1995'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Inferior Vertebral Ring']);
        $data = array('method_id'=>$method_id,'feature'=>'Inferior Vertebral Ring','display_name'=>'Inferior Vertebral Ring', 'display_order' =>  2, 'display_values' => '{"0":"0", "1":"1", "2":"2", "3":"3"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name','=','Thoracic vertebra 10/11')->first()->id;
        $method_id = Method::where([['name','=','Albert and Maples 1995'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Superior Vertebral Ring']);
        $data = array('method_id'=>$method_id,'feature'=>'Superior Vertebral Ring','display_name'=>'Superior Vertebral Ring', 'display_order' =>  1, 'display_values' => '{"0":"0", "1":"1", "2":"2", "3":"3"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name','=','Thoracic vertebra 10/11')->first()->id;
        $method_id = Method::where([['name','=','Albert and Maples 1995'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Inferior Vertebral Ring']);
        $data = array('method_id'=>$method_id,'feature'=>'Inferior Vertebral Ring','display_name'=>'Inferior Vertebral Ring', 'display_order' =>  2, 'display_values' => '{"0":"0", "1":"1", "2":"2", "3":"3"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name','=','Thoracic vertebra 11/12')->first()->id;
        $method_id = Method::where([['name','=','Albert and Maples 1995'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Superior Vertebral Ring']);
        $data = array('method_id'=>$method_id,'feature'=>'Superior Vertebral Ring','display_name'=>'Superior Vertebral Ring', 'display_order' =>  1, 'display_values' => '{"0":"0", "1":"1", "2":"2", "3":"3"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name','=','Thoracic vertebra 11/12')->first()->id;
        $method_id = Method::where([['name','=','Albert and Maples 1995'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Inferior Vertebral Ring']);
        $data = array('method_id'=>$method_id,'feature'=>'Inferior Vertebral Ring','display_name'=>'Inferior Vertebral Ring', 'display_order' =>  2, 'display_values' => '{"0":"0", "1":"1", "2":"2", "3":"3"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name','=','Thoracic vertebra 1/2')->first()->id;
        $method_id = Method::where([['name','=','Albert and Maples 1995'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Superior Vertebral Ring']);
        $data = array('method_id'=>$method_id,'feature'=>'Superior Vertebral Ring','display_name'=>'Superior Vertebral Ring', 'display_order' =>  1, 'display_values' => '{"0":"0", "1":"1", "2":"2", "3":"3"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name','=','Thoracic vertebra 1/2')->first()->id;
        $method_id = Method::where([['name','=','Albert and Maples 1995'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Inferior Vertebral Ring']);
        $data = array('method_id'=>$method_id,'feature'=>'Inferior Vertebral Ring','display_name'=>'Inferior Vertebral Ring', 'display_order' =>  2, 'display_values' => '{"0":"0", "1":"1", "2":"2", "3":"3"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name','=','Lumbar vertebra 1')->first()->id;
        $method_id = Method::where([['name','=','Albert and Maples 1995'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Superior Vertebral Ring']);
        $data = array('method_id'=>$method_id,'feature'=>'Superior Vertebral Ring','display_name'=>'Superior Vertebral Ring', 'display_order' =>  1, 'display_values' => '{"0":"0", "1":"1", "2":"2", "3":"3"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name','=','Lumbar vertebra 1')->first()->id;
        $method_id = Method::where([['name','=','Albert and Maples 1995'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Inferior Vertebral Ring']);
        $data = array('method_id'=>$method_id,'feature'=>'Inferior Vertebral Ring','display_name'=>'Inferior Vertebral Ring', 'display_order' =>  2, 'display_values' => '{"0":"0", "1":"1", "2":"2", "3":"3"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name','=','Lumbar vertebra 2')->first()->id;
        $method_id = Method::where([['name','=','Albert and Maples 1995'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Superior Vertebral Ring']);
        $data = array('method_id'=>$method_id,'feature'=>'Superior Vertebral Ring','display_name'=>'Superior Vertebral Ring', 'display_order' =>  1, 'display_values' => '{"0":"0", "1":"1", "2":"2", "3":"3"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name','=','Lumbar vertebra 2')->first()->id;
        $method_id = Method::where([['name','=','Albert and Maples 1995'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Inferior Vertebral Ring']);
        $data = array('method_id'=>$method_id,'feature'=>'Inferior Vertebral Ring','display_name'=>'Inferior Vertebral Ring', 'display_order' =>  2, 'display_values' => '{"0":"0", "1":"1", "2":"2", "3":"3"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name','=','Lumbar vertebra 3')->first()->id;
        $method_id = Method::where([['name','=','Albert and Maples 1995'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Superior Vertebral Ring']);
        $data = array('method_id'=>$method_id,'feature'=>'Superior Vertebral Ring','display_name'=>'Superior Vertebral Ring', 'display_order' =>  1, 'display_values' => '{"0":"0", "1":"1", "2":"2", "3":"3"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name','=','Lumbar vertebra 3')->first()->id;
        $method_id = Method::where([['name','=','Albert and Maples 1995'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Inferior Vertebral Ring']);
        $data = array('method_id'=>$method_id,'feature'=>'Inferior Vertebral Ring','display_name'=>'Inferior Vertebral Ring', 'display_order' =>  2, 'display_values' => '{"0":"0", "1":"1", "2":"2", "3":"3"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name','=','Lumbar vertebra 4')->first()->id;
        $method_id = Method::where([['name','=','Albert and Maples 1995'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Superior Vertebral Ring']);
        $data = array('method_id'=>$method_id,'feature'=>'Superior Vertebral Ring','display_name'=>'Superior Vertebral Ring', 'display_order' =>  1, 'display_values' => '{"0":"0", "1":"1", "2":"2", "3":"3"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name','=','Lumbar vertebra 4')->first()->id;
        $method_id = Method::where([['name','=','Albert and Maples 1995'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Inferior Vertebral Ring']);
        $data = array('method_id'=>$method_id,'feature'=>'Inferior Vertebral Ring','display_name'=>'Inferior Vertebral Ring', 'display_order' =>  2, 'display_values' => '{"0":"0", "1":"1", "2":"2", "3":"3"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name','=','Lumbar vertebra 5')->first()->id;
        $method_id = Method::where([['name','=','Albert and Maples 1995'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Superior Vertebral Ring']);
        $data = array('method_id'=>$method_id,'feature'=>'Superior Vertebral Ring','display_name'=>'Superior Vertebral Ring', 'display_order' =>  1, 'display_values' => '{"0":"0", "1":"1", "2":"2", "3":"3"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name','=','Lumbar vertebra 5')->first()->id;
        $method_id = Method::where([['name','=','Albert and Maples 1995'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Inferior Vertebral Ring']);
        $data = array('method_id'=>$method_id,'feature'=>'Inferior Vertebral Ring','display_name'=>'Inferior Vertebral Ring', 'display_order' =>  2, 'display_values' => '{"0":"0", "1":"1", "2":"2", "3":"3"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name','=','Lumbar vertebra 1/2')->first()->id;
        $method_id = Method::where([['name','=','Albert and Maples 1995'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Superior Vertebral Ring']);
        $data = array('method_id'=>$method_id,'feature'=>'Superior Vertebral Ring','display_name'=>'Superior Vertebral Ring', 'display_order' =>  1, 'display_values' => '{"0":"0", "1":"1", "2":"2", "3":"3"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name','=','Lumbar vertebra 1/2')->first()->id;
        $method_id = Method::where([['name','=','Albert and Maples 1995'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Inferior Vertebral Ring']);
        $data = array('method_id'=>$method_id,'feature'=>'Inferior Vertebral Ring','display_name'=>'Inferior Vertebral Ring', 'display_order' =>  2, 'display_values' => '{"0":"0", "1":"1", "2":"2", "3":"3"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name','=','Lumbar vertebra 2/3')->first()->id;
        $method_id = Method::where([['name','=','Albert and Maples 1995'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Superior Vertebral Ring']);
        $data = array('method_id'=>$method_id,'feature'=>'Superior Vertebral Ring','display_name'=>'Superior Vertebral Ring', 'display_order' =>  1, 'display_values' => '{"0":"0", "1":"1", "2":"2", "3":"3"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name','=','Lumbar vertebra 2/3')->first()->id;
        $method_id = Method::where([['name','=','Albert and Maples 1995'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Inferior Vertebral Ring']);
        $data = array('method_id'=>$method_id,'feature'=>'Inferior Vertebral Ring','display_name'=>'Inferior Vertebral Ring', 'display_order' =>  2, 'display_values' => '{"0":"0", "1":"1", "2":"2", "3":"3"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name','=','Lumbar vertebra 3/4')->first()->id;
        $method_id = Method::where([['name','=','Albert and Maples 1995'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Superior Vertebral Ring']);
        $data = array('method_id'=>$method_id,'feature'=>'Superior Vertebral Ring','display_name'=>'Superior Vertebral Ring', 'display_order' =>  1, 'display_values' => '{"0":"0", "1":"1", "2":"2", "3":"3"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name','=','Lumbar vertebra 3/4')->first()->id;
        $method_id = Method::where([['name','=','Albert and Maples 1995'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Inferior Vertebral Ring']);
        $data = array('method_id'=>$method_id,'feature'=>'Inferior Vertebral Ring','display_name'=>'Inferior Vertebral Ring', 'display_order' =>  2, 'display_values' => '{"0":"0", "1":"1", "2":"2", "3":"3"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name','=','Lumbar vertebra 4/5')->first()->id;
        $method_id = Method::where([['name','=','Albert and Maples 1995'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Superior Vertebral Ring']);
        $data = array('method_id'=>$method_id,'feature'=>'Superior Vertebral Ring','display_name'=>'Superior Vertebral Ring', 'display_order' =>  1, 'display_values' => '{"0":"0", "1":"1", "2":"2", "3":"3"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name','=','Lumbar vertebra 4/5')->first()->id;
        $method_id = Method::where([['name','=','Albert and Maples 1995'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Inferior Vertebral Ring']);
        $data = array('method_id'=>$method_id,'feature'=>'Inferior Vertebral Ring','display_name'=>'Inferior Vertebral Ring', 'display_order' =>  2, 'display_values' => '{"0":"0", "1":"1", "2":"2", "3":"3"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name','=','Unseriated thoracic vertebra')->first()->id;
        $method_id = Method::where([['name','=','Albert and Maples 1995'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Superior Vertebral Ring']);
        $data = array('method_id'=>$method_id,'feature'=>'Superior Vertebral Ring','display_name'=>'Superior Vertebral Ring', 'display_order' =>  1, 'display_values' => '{"0":"0", "1":"1", "2":"2", "3":"3"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name','=','Unseriated thoracic vertebra')->first()->id;
        $method_id = Method::where([['name','=','Albert and Maples 1995'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Inferior Vertebral Ring']);
        $data = array('method_id'=>$method_id,'feature'=>'Inferior Vertebral Ring','display_name'=>'Inferior Vertebral Ring', 'display_order' =>  2, 'display_values' => '{"0":"0", "1":"1", "2":"2", "3":"3"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name','=','Unseriated lumbar vertebra')->first()->id;
        $method_id = Method::where([['name','=','Albert and Maples 1995'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Superior Vertebral Ring']);
        $data = array('method_id'=>$method_id,'feature'=>'Superior Vertebral Ring','display_name'=>'Superior Vertebral Ring', 'display_order' =>  1, 'display_values' => '{"0":"0", "1":"1", "2":"2", "3":"3"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name','=','Unseriated lumbar vertebra')->first()->id;
        $method_id = Method::where([['name','=','Albert and Maples 1995'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Inferior Vertebral Ring']);
        $data = array('method_id'=>$method_id,'feature'=>'Inferior Vertebral Ring','display_name'=>'Inferior Vertebral Ring', 'display_order' =>  2, 'display_values' => '{"0":"0", "1":"1", "2":"2", "3":"3"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys,'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name','=','Os coxa')->first()->id;
        $method_id = Method::where([['name','=','Phenice 1969'],['type','=','Sex'],['sb_id','=',$sb_id]])->first()->id;
        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Subpubic concavity']);
        $data = array('method_id'=>$method_id,'feature'=>'Subpubic concavity','display_name'=>'Subpubic concavity', 'display_order' =>  1, 'display_values' => '{"1":"1", "2":"2", "3":"3"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name','=','Os coxa')->first()->id;
        $method_id = Method::where([['name','=','Phenice 1969'],['type','=','Sex'],['sb_id','=',$sb_id]])->first()->id;
        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Ischiopubic ramus']);
        $data = array('method_id'=>$method_id,'feature'=>'Ischiopubic ramus','display_name'=>'Ischiopubic ramus',  'display_order' =>  2, 'display_values' => '{"1":"1", "2":"2", "3":"3"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name','=','Os coxa')->first()->id;
        $method_id = Method::where([['name','=','Phenice 1969'],['type','=','Sex'],['sb_id','=',$sb_id]])->first()->id;
        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Ventral Arc']);
        $data = array('method_id'=>$method_id,'feature'=>'Ventral Arc','display_name'=>'Ventral Arc',  'display_order' =>  3, 'display_values' => '{"1":"1", "2":"2", "3":"3"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name','=','Humerus')->first()->id;
        $method_id = Method::where([['name','=','Rogers 1999'],['type','=','Sex'],['sb_id','=',$sb_id]])->first()->id;
        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Olecranon fossa']);
        $data = array('method_id'=>$method_id,'feature'=>'Olecranon fossa','display_name'=>'Olecranon fossa', 'display_order' =>  1, 'display_values' => '{"triangle":"triangle", "oval":"oval"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name','=','Humerus')->first()->id;
        $method_id = Method::where([['name','=','Rogers 1999'],['type','=','Sex'],['sb_id','=',$sb_id]])->first()->id;
        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Medial epicondyle']);
        $data = array('method_id'=>$method_id,'feature'=>'Medial epicondyle','display_name'=>'Medial epicondyle', 'display_order' =>  2, 'display_values' => '{"flat raised":"flat raised", "marked angle":"marked angle"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name','=','Humerus')->first()->id;
        $method_id = Method::where([['name','=','Rogers 1999'],['type','=','Sex'],['sb_id','=',$sb_id]])->first()->id;
        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Trochlear constriction']);
        $data = array('method_id'=>$method_id,'feature'=>'Trochlear constriction','display_name'=>'Trochlear constriction', 'display_order' =>  3, 'display_values' => '{"less constricted":"less constricted", "more constricted":"more constricted"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name','=','Humerus')->first()->id;
        $method_id = Method::where([['name','=','Rogers 1999'],['type','=','Sex'],['sb_id','=',$sb_id]])->first()->id;
        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Trochlear symmetry']);
        $data = array('method_id'=>$method_id,'feature'=>'Trochlear symmetry','display_name'=>'Trochlear symmetry', 'display_order' =>  4, 'display_values' => '{"asymmetrical":"asymmetrical", "symmetrical":"symmetrical"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name','=','Clavicle')->first()->id;
        $method_id = Method::where([['name','=','Rogers et al 2000'],['type','=','Sex'],['sb_id','=',$sb_id]])->first()->id;
        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Rhomboid fossa']);
        $data = array('method_id'=>$method_id,'feature'=>'Rhomboid fossa','display_name'=>'Rhomboid fossa', 'display_order' =>  1, 'display_values' => '{"absent":"absent", "present":"present"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name','=','Os coxa')->first()->id;
        $method_id = Method::where([['name','=','Walker 2005'],['type','=','Sex'],['sb_id','=',$sb_id]])->first()->id;
        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Greater sciatic notch']);
        $data = array('method_id'=>$method_id,'feature'=>'Greater sciatic notch','display_name'=>'Greater sciatic notch', 'display_order' =>  1, 'display_values' => '{"1":"1", "2":"2", "3":"3", "4":"4", "5":"5"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name','=','Cranium')->first()->id;
        $method_id = Method::where([['name','=','Gill 1998'],['type','=','Ancestry'],['sb_id','=',$sb_id]])->first()->id;
        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Cranial form']);
        $data = array('method_id'=>$method_id,'feature'=>'Cranial form','display_name'=>'Cranial form', 'display_order' =>  1, 'display_values' => '{"broad":"broad", "medium":"medium", "long":"long"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name','=','Cranium')->first()->id;
        $method_id = Method::where([['name','=','Gill 1998'],['type','=','Ancestry'],['sb_id','=',$sb_id]])->first()->id;
        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Nose form']);
        $data = array('method_id'=>$method_id,'feature'=>'Nose form','display_name'=>'Nose form', 'display_order' =>  2, 'display_values' => '{"narrow":"narrow", "medium":"medium", "broad":"broad"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name','=','Cranium')->first()->id;
        $method_id = Method::where([['name','=','Gill 1998'],['type','=','Ancestry'],['sb_id','=',$sb_id]])->first()->id;
        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Facial prognathism']);
        $data = array('method_id'=>$method_id,'feature'=>'Facial prognathism','display_name'=>'Facial prognathism', 'display_order' =>  3, 'display_values' => '{"reduced":"reduced", "moderate":"moderate", "extreme":"extreme"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name','=','Cranium')->first()->id;
        $method_id = Method::where([['name','=','Gill 1998'],['type','=','Ancestry'],['sb_id','=',$sb_id]])->first()->id;
        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Malar form']);
        $data = array('method_id'=>$method_id,'feature'=>'Malar form','display_name'=>'Malar form', 'display_order' =>  4, 'display_values' => '{"reduced":"reduced", "projecting":"projecting"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name','=','Cranium')->first()->id;
        $method_id = Method::where([['name','=','Gill 1998'],['type','=','Ancestry'],['sb_id','=',$sb_id]])->first()->id;
        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Palatal form']);
        $data = array('method_id'=>$method_id,'feature'=>'Palatal form','display_name'=>'Palatal form', 'display_order' =>  5, 'display_values' => '{"parabolic":"parabolic", "elliptical":"elliptical", "hyperbolic":"hyperbolic"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name','=','Cranium')->first()->id;
        $method_id = Method::where([['name','=','Gill 1998'],['type','=','Ancestry'],['sb_id','=',$sb_id]])->first()->id;
        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Orbital form']);
        $data = array('method_id'=>$method_id,'feature'=>'Orbital form','display_name'=>'Orbital form', 'display_order' =>  6, 'display_values' => '{"round":"round", "rhomboid":"rhomboid"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name','=','Cranium')->first()->id;
        $method_id = Method::where([['name','=','Gill 1998'],['type','=','Ancestry'],['sb_id','=',$sb_id]])->first()->id;
        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Mastoid form']);
        $data = array('method_id'=>$method_id,'feature'=>'Mastoid form','display_name'=>'Mastoid form', 'display_order' =>  7, 'display_values' => '{"wide":"wide", "narrow":"narrow", "oblique with posterior tubercle":"oblique with posterior tubercle"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name','=','Cranium')->first()->id;
        $method_id = Method::where([['name','=','Hefner 2009'],['type','=','Ancestry'],['sb_id','=',$sb_id]])->first()->id;
        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Post-bregmatic depression']);
        $data = array('method_id'=>$method_id,'feature'=>'Post-bregmatic depression','display_name'=>'Post-bregmatic depression', 'display_order' =>  1, 'display_values' => '{"0":"0", "1":"1"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name','=','Cranium')->first()->id;
        $method_id = Method::where([['name','=','Hefner 2009'],['type','=','Ancestry'],['sb_id','=',$sb_id]])->first()->id;
        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Anterior nasal spine']);
        $data = array('method_id'=>$method_id,'feature'=>'Anterior nasal spine','display_name'=>'Anterior nasal spine', 'display_order' =>  2, 'display_values' => '{"1":"1", "2":"2", "3":"3"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name','=','Cranium')->first()->id;
        $method_id = Method::where([['name','=','Hefner 2009'],['type','=','Ancestry'],['sb_id','=',$sb_id]])->first()->id;
        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Inferior nasal aperture']);
        $data = array('method_id'=>$method_id,'feature'=>'Inferior nasal aperture','display_name'=>'Inferior nasal aperture', 'display_order' =>  3, 'display_values' => '{"1":"1", "2":"2", "3":"3", "4":"4", "5":"5"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name','=','Cranium')->first()->id;
        $method_id = Method::where([['name','=','Hefner 2009'],['type','=','Ancestry'],['sb_id','=',$sb_id]])->first()->id;
        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Interorbital breadth']);
        $data = array('method_id'=>$method_id,'feature'=>'Interorbital breadth','display_name'=>'Interorbital breadth', 'display_order' =>  4, 'display_values' => '{"1":"1", "2":"2", "3":"3"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name','=','Cranium')->first()->id;
        $method_id = Method::where([['name','=','Hefner 2009'],['type','=','Ancestry'],['sb_id','=',$sb_id]])->first()->id;
        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Malar tubercle']);
        $data = array('method_id'=>$method_id,'feature'=>'Malar tubercle','display_name'=>'Malar tubercle', 'display_order' =>  5, 'display_values' => '{"0":"0", "1":"1", "2":"2", "3":"3"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name','=','Cranium')->first()->id;
        $method_id = Method::where([['name','=','Hefner 2009'],['type','=','Ancestry'],['sb_id','=',$sb_id]])->first()->id;
        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Nasal aperture width']);
        $data = array('method_id'=>$method_id,'feature'=>'Nasal aperture width','display_name'=>'Nasal aperture width', 'display_order' =>  6, 'display_values' => '{"1":"1", "2":"2", "3":"3"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name','=','Cranium')->first()->id;
        $method_id = Method::where([['name','=','Hefner 2009'],['type','=','Ancestry'],['sb_id','=',$sb_id]])->first()->id;
        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Nasal bone contour']);
        $data = array('method_id'=>$method_id,'feature'=>'Nasal bone contour','display_name'=>'Nasal bone contour', 'display_order' =>  7, 'display_values' => '{"0":"0", "1":"1", "2":"2", "3":"3", "4":"4"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name','=','Cranium')->first()->id;
        $method_id = Method::where([['name','=','Hefner 2009'],['type','=','Ancestry'],['sb_id','=',$sb_id]])->first()->id;
        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Nasal overgrowth']);
        $data = array('method_id'=>$method_id,'feature'=>'Nasal overgrowth','display_name'=>'Nasal overgrowth', 'display_order' =>  8, 'display_values' => '{"0":"0", "1":"1"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name','=','Cranium')->first()->id;
        $method_id = Method::where([['name','=','Hefner 2009'],['type','=','Ancestry'],['sb_id','=',$sb_id]])->first()->id;
        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Supranasal suture']);
        $data = array('method_id'=>$method_id,'feature'=>'Supranasal suture','display_name'=>'Supranasal suture', 'display_order' =>  9, 'display_values' => '{"0":"0", "1":"1", "2":"2"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name','=','Cranium')->first()->id;
        $method_id = Method::where([['name','=','Hefner 2009'],['type','=','Ancestry'],['sb_id','=',$sb_id]])->first()->id;
        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Transverse palatine suture']);
        $data = array('method_id'=>$method_id,'feature'=>'Transverse palatine suture','display_name'=>'Transverse palatine suture', 'display_order' =>  10, 'display_values' => '{"0":"0", "1":"1", "2":"2", "3":"3"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name','=','Cranium')->first()->id;
        $method_id = Method::where([['name','=','Hefner 2009'],['type','=','Ancestry'],['sb_id','=',$sb_id]])->first()->id;
        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Zygomaticomaxillary suture']);
        $data = array('method_id'=>$method_id,'feature'=>'Zygomaticomaxillary suture','display_name'=>'Zygomaticomaxillary suture', 'display_order' =>  11, 'display_values' => '{"0":"0", "1":"1", "2":"2", "3":"3"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name','=','Cranium')->first()->id;
        $method_id = Method::where([['name','=','Hefner and Ousley 2014'],['type','=','Ancestry'],['sb_id','=',$sb_id]])->first()->id;
        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Anterior nasal spine']);
        $data = array('method_id'=>$method_id,'feature'=>'Anterior nasal spine','display_name'=>'Anterior nasal spine (ANS) OSSA Score', 'display_order' =>  1, 'display_values' => '{"0":"0", "1":"1"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name','=','Cranium')->first()->id;
        $method_id = Method::where([['name','=','Hefner and Ousley 2014'],['type','=','Ancestry'],['sb_id','=',$sb_id]])->first()->id;
        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Inferior nasal aperture']);
        $data = array('method_id'=>$method_id,'feature'=>'Inferior nasal aperture','display_name'=>'Inferior nasal aperture (INA) OSSA Score', 'display_order' =>  2, 'display_values' => '{"0":"0", "1":"1"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name','=','Cranium')->first()->id;
        $method_id = Method::where([['name','=','Hefner and Ousley 2014'],['type','=','Ancestry'],['sb_id','=',$sb_id]])->first()->id;
        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Interorbital breadth']);
        $data = array('method_id'=>$method_id,'feature'=>'Interorbital breadth','display_name'=>'Interorbital breadth (IB) OSSA Score', 'display_order' =>  3, 'display_values' => '{"0":"0", "1":"1"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name','=','Cranium')->first()->id;
        $method_id = Method::where([['name','=','Hefner and Ousley 2014'],['type','=','Ancestry'],['sb_id','=',$sb_id]])->first()->id;
        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Nasal aperture width']);
        $data = array('method_id'=>$method_id,'feature'=>'Nasal aperture width','display_name'=>'Nasal aperture width (NAW) OSSA Score', 'display_order' =>  4, 'display_values' => '{"0":"0", "1":"1"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name','=','Cranium')->first()->id;
        $method_id = Method::where([['name','=','Hefner and Ousley 2014'],['type','=','Ancestry'],['sb_id','=',$sb_id]])->first()->id;
        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Nasal bone contour']);
        $data = array('method_id'=>$method_id,'feature'=>'Nasal bone contour','display_name'=>'Nasal bone contour (NBC) OSSA Score', 'display_order' =>  5, 'display_values' => '{"0":"0", "1":"1"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name','=','Cranium')->first()->id;
        $method_id = Method::where([['name','=','Hefner and Ousley 2014'],['type','=','Ancestry'],['sb_id','=',$sb_id]])->first()->id;
        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Post-bregmatic depression']);
        $data = array('method_id'=>$method_id,'feature'=>'Post-bregmatic depression','display_name'=>'Post-bregmatic depression (PBD) OSSA Score', 'display_order' =>  6, 'display_values' => '{"0":"0", "1":"1"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name','=','Cranium')->first()->id;
        $method_id = Method::where([['name','=','Hefner and Ousley 2014'],['type','=','Ancestry'],['sb_id','=',$sb_id]])->first()->id;
        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'SUMALL']);
        $data = array('method_id'=>$method_id,'feature'=>'SUMALL','display_name'=>'Composite Score - SUMALL', 'display_order' => 7,
            'display_values' => '{"0":"0", "1":"1", "2":"2", "3":"3", "4":"4", "5":"5", "6":"6"}',
            'computed' => true, 'compute_rule' => 'Anterior nasal spine,Inferior nasal aperture,Interorbital breadth,Nasal aperture width,Nasal bone contour,Post-bregmatic depression', 'display_interval' => null, 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();


        $sb_id = SkeletalBone::where('name','=','Cranium')->first()->id;
        $method_id = Method::where([['name','=','Rhine 1990'],['type','=','Ancestry'],['sb_id','=',$sb_id]])->first()->id;
        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Orbital form']);
        $data = array('method_id'=>$method_id,'feature'=>'Orbital form','display_name'=>'Orbital form', 'display_order' =>  1, 'display_values' => '{"round":"round", "rectangular":"rectangular", "sloping":"sloping"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name','=','Cranium')->first()->id;
        $method_id = Method::where([['name','=','Rhine 1990'],['type','=','Ancestry'],['sb_id','=',$sb_id]])->first()->id;
        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Nasal opening']);
        $data = array('method_id'=>$method_id,'feature'=>'Nasal opening','display_name'=>'Nasal opening', 'display_order' =>  2, 'display_values' => '{"narrow":"narrow", "medium":"medium", "broad":"broad"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name','=','Cranium')->first()->id;
        $method_id = Method::where([['name','=','Rhine 1990'],['type','=','Ancestry'],['sb_id','=',$sb_id]])->first()->id;
        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Nasal depression']);
        $data = array('method_id'=>$method_id,'feature'=>'Nasal depression','display_name'=>'Nasal depression', 'display_order' =>  3, 'display_values' => '{"straight":"straight", "slight":"slight", "deep":"deep"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name','=','Cranium')->first()->id;
        $method_id = Method::where([['name','=','Rhine 1990'],['type','=','Ancestry'],['sb_id','=',$sb_id]])->first()->id;
        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Nasal sill']);
        $data = array('method_id'=>$method_id,'feature'=>'Nasal sill','display_name'=>'Nasal sill', 'display_order' =>  4, 'display_values' => '{"deep":"deep", "shallow":"shallow", "guttered":"guttered"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name','=','Cranium')->first()->id;
        $method_id = Method::where([['name','=','Rhine 1990'],['type','=','Ancestry'],['sb_id','=',$sb_id]])->first()->id;
        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Zygomatic projection']);
        $data = array('method_id'=>$method_id,'feature'=>'Zygomatic projection','display_name'=>'Zygomatic projection', 'display_order' =>  5, 'display_values' => '{"retreating":"retreating", "vertical":"vertical", "projecting":"projecting"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name','=','Cranium')->first()->id;
        $method_id = Method::where([['name','=','Rhine 1990'],['type','=','Ancestry'],['sb_id','=',$sb_id]])->first()->id;
        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Prognathism']);
        $data = array('method_id'=>$method_id,'feature'=>'Prognathism','display_name'=>'Prognathism', 'display_order' =>  6, 'display_values' => '{"slight":"slight", "moderate":"moderate", "none":"none"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name','=','Cranium')->first()->id;
        $method_id = Method::where([['name','=','Rhine 1990'],['type','=','Ancestry'],['sb_id','=',$sb_id]])->first()->id;
        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Palatine torus']);
        $data = array('method_id'=>$method_id,'feature'=>'Palatine torus','display_name'=>'Palatine torus', 'display_order' =>  7, 'display_values' => '{"present":"present", "absent":"absent"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name','=','Cranium')->first()->id;
        $method_id = Method::where([['name','=','Rhine 1990'],['type','=','Ancestry'],['sb_id','=',$sb_id]])->first()->id;
        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Chin shape']);
        $data = array('method_id'=>$method_id,'feature'=>'Chin shape','display_name'=>'Chin shape', 'display_order' =>  8, 'display_values' => '{"bilobate":"bilobate", "blunt":"blunt", "pointed":"pointed"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name','=','Cranium')->first()->id;
        $method_id = Method::where([['name','=','Rhine 1990'],['type','=','Ancestry'],['sb_id','=',$sb_id]])->first()->id;
        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Ascending ramus']);
        $data = array('method_id'=>$method_id,'feature'=>'Ascending ramus','display_name'=>'Ascending ramus', 'display_order' =>  9, 'display_values' => '{"pinched":"pinched", "wide":"wide", "vertical":"vertical", "slanted":"slanted"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name','=','Cranium')->first()->id;
        $method_id = Method::where([['name','=','Rhine 1990'],['type','=','Ancestry'],['sb_id','=',$sb_id]])->first()->id;
        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Gonial angle']);
        $data = array('method_id'=>$method_id,'feature'=>'Gonial angle','display_name'=>'Gonial angle', 'display_order' =>  10, 'display_values' => '{"inverted":"inverted", "straight":"straight", "everted":"everted"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name','=','Cranium')->first()->id;
        $method_id = Method::where([['name','=','Rhine 1990'],['type','=','Ancestry'],['sb_id','=',$sb_id]])->first()->id;
        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Mandibular torus']);
        $data = array('method_id'=>$method_id,'feature'=>'Mandibular torus','display_name'=>'Mandibular torus', 'display_order' =>  11, 'display_values' => '{"present":"present", "absent":"absent"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name','=','Cranium')->first()->id;
        $method_id = Method::where([['name','=','Rhine 1990'],['type','=','Ancestry'],['sb_id','=',$sb_id]])->first()->id;
        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Keeling']);
        $data = array('method_id'=>$method_id,'feature'=>'Keeling','display_name'=>'Keeling', 'display_order' =>  12, 'display_values' => '{"present":"present", "absent":"absent"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name','=','Cranium')->first()->id;
        $method_id = Method::where([['name','=','Rhine 1990'],['type','=','Ancestry'],['sb_id','=',$sb_id]])->first()->id;
        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Post-bregmatic depression']);
        $data = array('method_id'=>$method_id,'feature'=>'Post-bregmatic depression','display_name'=>'Post-bregmatic depression', 'display_order' =>  13, 'display_values' => '{"present":"present", "absent":"absent"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name','=','Cranium')->first()->id;
        $method_id = Method::where([['name','=','Edgar 2013'],['type','=','Ancestry'],['sb_id','=',$sb_id]])->first()->id;
        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'UI1DS']);
        $data = array('method_id'=>$method_id,'feature'=>'UI1DS','display_name'=>'UI1DS', 'display_order' =>  1, 'display_values' => '{"0":"0", "1":"1", "2":"2", "3":"3", "4":"4", "5":"5", "6":"6"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name','=','Cranium')->first()->id;
        $method_id = Method::where([['name','=','Edgar 2013'],['type','=','Ancestry'],['sb_id','=',$sb_id]])->first()->id;
        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'UI2SS']);
        $data = array('method_id'=>$method_id,'feature'=>'UI2SS','display_name'=>'UI2SS', 'display_order' =>  2, 'display_values' => '{"0":"0", "1":"1", "2":"2", "3":"3", "4":"4", "5":"5", "6":"6"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name','=','Cranium')->first()->id;
        $method_id = Method::where([['name','=','Edgar 2013'],['type','=','Ancestry'],['sb_id','=',$sb_id]])->first()->id;
        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'UI2DS']);
        $data = array('method_id'=>$method_id,'feature'=>'UI2DS','display_name'=>'UI2DS', 'display_order' =>  3, 'display_values' => '{"0":"0", "1":"1", "2":"2", "3":"3", "4":"4", "5":"5", "6":"6"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name','=','Cranium')->first()->id;
        $method_id = Method::where([['name','=','Edgar 2013'],['type','=','Ancestry'],['sb_id','=',$sb_id]])->first()->id;
        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'UCSS']);
        $data = array('method_id'=>$method_id,'feature'=>'UCSS','display_name'=>'UCSS', 'display_order' =>  4, 'display_values' => '{"0":"0", "1":"1", "2":"2", "3":"3", "4":"4", "5":"5", "6":"6"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name','=','Cranium')->first()->id;
        $method_id = Method::where([['name','=','Edgar 2013'],['type','=','Ancestry'],['sb_id','=',$sb_id]])->first()->id;
        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'UCDR']);
        $data = array('method_id'=>$method_id,'feature'=>'UCDR','display_name'=>'UCDR', 'display_order' =>  5, 'display_values' => '{"0":"0", "1":"1", "2":"2", "3":"3", "4":"4", "5":"5"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name','=','Cranium')->first()->id;
        $method_id = Method::where([['name','=','Edgar 2013'],['type','=','Ancestry'],['sb_id','=',$sb_id]])->first()->id;
        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'UCTD']);
        $data = array('method_id'=>$method_id,'feature'=>'UCTD','display_name'=>'UCTD', 'display_order' =>  6, 'display_values' => '{"0":"0", "1":"1", "2":"2", "3":"3", "4":"4", "5":"5", "6":"6"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name','=','Cranium')->first()->id;
        $method_id = Method::where([['name','=','Edgar 2013'],['type','=','Ancestry'],['sb_id','=',$sb_id]])->first()->id;
        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'UM1HC']);
        $data = array('method_id'=>$method_id,'feature'=>'UM1HC','display_name'=>'UM1HC', 'display_order' =>  7, 'display_values' => '{"0":"0", "1":"1", "2":"2", "3":"3", "4":"4", "5":"5"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name','=','Cranium')->first()->id;
        $method_id = Method::where([['name','=','Edgar 2013'],['type','=','Ancestry'],['sb_id','=',$sb_id]])->first()->id;
        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'UM1MC']);
        $data = array('method_id'=>$method_id,'feature'=>'UM1MC','display_name'=>'UM1MC', 'display_order' =>  8, 'display_values' => '{"0":"0", "1":"1", "2":"2", "3":"3", "4":"4", "5":"5"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name','=','Cranium')->first()->id;
        $method_id = Method::where([['name','=','Edgar 2013'],['type','=','Ancestry'],['sb_id','=',$sb_id]])->first()->id;
        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'UM2MC']);
        $data = array('method_id'=>$method_id,'feature'=>'UM2MC','display_name'=>'UM2MC', 'display_order' =>  9, 'display_values' => '{"0":"0", "1":"1", "2":"2", "3":"3", "4":"4", "5":"5"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name','=','Cranium')->first()->id;
        $method_id = Method::where([['name','=','Edgar 2013'],['type','=','Ancestry'],['sb_id','=',$sb_id]])->first()->id;
        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'UM2C5']);
        $data = array('method_id'=>$method_id,'feature'=>'UM2C5','display_name'=>'UM2C5', 'display_order' =>  10, 'display_values' => '{"0":"0", "1":"1", "2":"2", "3":"3", "4":"4", "5":"5"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name','=','Mandible')->first()->id;
        $method_id = Method::where([['name','=','Edgar 2013'],['type','=','Ancestry'],['sb_id','=',$sb_id]])->first()->id;
        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'LI1SS']);
        $data = array('method_id'=>$method_id,'feature'=>'LI1SS','display_name'=>'LI1SS', 'display_order' =>  1, 'display_values' => '{"0":"0", "1":"1", "2":"2", "3":"3"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name','=','Mandible')->first()->id;
        $method_id = Method::where([['name','=','Edgar 2013'],['type','=','Ancestry'],['sb_id','=',$sb_id]])->first()->id;
        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'LI2SS']);
        $data = array('method_id'=>$method_id,'feature'=>'LI2SS','display_name'=>'LI2SS', 'display_order' =>  2, 'display_values' => '{"0":"0", "1":"1", "2":"2", "3":"3"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name','=','Mandible')->first()->id;
        $method_id = Method::where([['name','=','Edgar 2013'],['type','=','Ancestry'],['sb_id','=',$sb_id]])->first()->id;
        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'LCDR']);
        $data = array('method_id'=>$method_id,'feature'=>'LCDR','display_name'=>'LCDR', 'display_order' =>  3, 'display_values' => '{"0":"0", "1":"1", "2":"2", "3":"3", "4":"4", "5":"5"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name','=','Mandible')->first()->id;
        $method_id = Method::where([['name','=','Edgar 2013'],['type','=','Ancestry'],['sb_id','=',$sb_id]])->first()->id;
        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'LP3LC']);
        $data = array('method_id'=>$method_id,'feature'=>'LP3LC','display_name'=>'LP3LC', 'display_order' =>  4, 'display_values' => '{"0":"0", "1":"1", "2":"2", "3":"3", "4":"4", "5":"5", "6":"6", "7":"7", "8":"8", "9":"9"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name','=','Mandible')->first()->id;
        $method_id = Method::where([['name','=','Edgar 2013'],['type','=','Ancestry'],['sb_id','=',$sb_id]])->first()->id;
        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'LM1AF']);
        $data = array('method_id'=>$method_id,'feature'=>'LM1AF','display_name'=>'LM1AF', 'display_order' =>  5, 'display_values' => '{"0":"0", "1":"1", "2":"2", "3":"3", "4":"4"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name','=','Mandible')->first()->id;
        $method_id = Method::where([['name','=','Edgar 2013'],['type','=','Ancestry'],['sb_id','=',$sb_id]])->first()->id;
        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'LM1DW']);
        $data = array('method_id'=>$method_id,'feature'=>'LM1DW','display_name'=>'LM1DW', 'display_order' =>  6, 'display_values' => '{"0":"0", "1":"1", "2":"2", "3":"3"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name','=','Mandible')->first()->id;
        $method_id = Method::where([['name','=','Edgar 2013'],['type','=','Ancestry'],['sb_id','=',$sb_id]])->first()->id;
        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'LM1PS']);
        $data = array('method_id'=>$method_id,'feature'=>'LM1PS','display_name'=>'LM1PS', 'display_order' =>  7, 'display_values' => '{"0":"0", "1":"1", "2":"2", "3":"3", "4":"4", "5":"5", "6":"6", "7":"7"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name','=','Mandible')->first()->id;
        $method_id = Method::where([['name','=','Edgar 2013'],['type','=','Ancestry'],['sb_id','=',$sb_id]])->first()->id;
        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'LM1C7']);
        $data = array('method_id'=>$method_id,'feature'=>'LM1C7','display_name'=>'LM1C7', 'display_order' =>  8, 'display_values' => '{"0":"0", "1":"1", "2":"2", "3":"3", "4":"4"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name','=','Mandible')->first()->id;
        $method_id = Method::where([['name','=','Edgar 2013'],['type','=','Ancestry'],['sb_id','=',$sb_id]])->first()->id;
        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'LM2C5']);
        $data = array('method_id'=>$method_id,'feature'=>'LM2C5','display_name'=>'LM2C5', 'display_order' =>  9, 'display_values' => '{"0":"0", "1":"1", "2":"2", "3":"3", "4":"4", "5":"5"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name','=','Mandible')->first()->id;
        $method_id = Method::where([['name','=','Edgar 2013'],['type','=','Ancestry'],['sb_id','=',$sb_id]])->first()->id;
        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'LM2C7']);
        $data = array('method_id'=>$method_id,'feature'=>'LM2C7','display_name'=>'LM2C7', 'display_order' =>  10, 'display_values' => '{"0":"0", "1":"1", "2":"2", "3":"3", "4":"4"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name','=','Cranium')->first()->id;
        $method_id = Method::where([['name','=','Walker 2008'],['type','=','Sex'],['sb_id','=',$sb_id]])->first()->id;
        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Mastoid Process']);
        $data = array('method_id'=>$method_id,'feature'=>'Mastoid Process','display_name'=>'Mastoid Process', 'display_order' =>  1, 'display_values' => '{"1":"1", "2":"2", "3":"3", "4":"4", "5":"5"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name','=','Cranium')->first()->id;
        $method_id = Method::where([['name','=','Walker 2008'],['type','=','Sex'],['sb_id','=',$sb_id]])->first()->id;
        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Nuchal Crest']);
        $data = array('method_id'=>$method_id,'feature'=>'Nuchal Crest','display_name'=>'Nuchal Crest', 'display_order' =>  2, 'display_values' => '{"1":"1", "2":"2", "3":"3", "4":"4", "5":"5"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name','=','Cranium')->first()->id;
        $method_id = Method::where([['name','=','Walker 2008'],['type','=','Sex'],['sb_id','=',$sb_id]])->first()->id;
        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Supraorbital margin']);
        $data = array('method_id'=>$method_id,'feature'=>'Supraorbital margin','display_name'=>'Supraorbital margin', 'display_order' =>  3, 'display_values' => '{"1":"1", "2":"2", "3":"3", "4":"4", "5":"5"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name','=','Cranium')->first()->id;
        $method_id = Method::where([['name','=','Walker 2008'],['type','=','Sex'],['sb_id','=',$sb_id]])->first()->id;
        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Glabella']);
        $data = array('method_id'=>$method_id,'feature'=>'Glabella','display_name'=>'Glabella', 'display_order' =>  4, 'display_values' => '{"1":"1", "2":"2", "3":"3", "4":"4", "5":"5"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name','=','Mandible')->first()->id;
        $method_id = Method::where([['name','=','Walker 2008'],['type','=','Sex'],['sb_id','=',$sb_id]])->first()->id;
        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Mental Eminence']);
        $data = array('method_id'=>$method_id,'feature'=>'Mental Eminence','display_name'=>'Mental Eminence', 'display_order' =>  1, 'display_values' => '{"1":"1", "2":"2", "3":"3", "4":"4", "5":"5"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name','=','Temporal')->first()->id;
        $method_id = Method::where([['name','=','Walker 2008'],['type','=','Sex'],['sb_id','=',$sb_id]])->first()->id;
        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Mastoid Process']);
        $data = array('method_id'=>$method_id,'feature'=>'Mastoid Process','display_name'=>'Mastoid Process', 'display_order' =>  1, 'display_values' => '{"1":"1", "2":"2", "3":"3", "4":"4", "5":"5"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name','=','Occipital')->first()->id;
        $method_id = Method::where([['name','=','Walker 2008'],['type','=','Sex'],['sb_id','=',$sb_id]])->first()->id;
        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Nuchal Crest']);
        $data = array('method_id'=>$method_id,'feature'=>'Nuchal Crest','display_name'=>'Nuchal Crest', 'display_order' =>  1, 'display_values' => '{"1":"1", "2":"2", "3":"3", "4":"4", "5":"5"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name','=','Frontal')->first()->id;
        $method_id = Method::where([['name','=','Walker 2008'],['type','=','Sex'],['sb_id','=',$sb_id]])->first()->id;
        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Supraorbital margin']);
        $data = array('method_id'=>$method_id,'feature'=>'Supraorbital margin','display_name'=>'Supraorbital margin', 'display_order' =>  1, 'display_values' => '{"1":"1", "2":"2", "3":"3", "4":"4", "5":"5"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name','=','Frontal')->first()->id;
        $method_id = Method::where([['name','=','Walker 2008'],['type','=','Sex'],['sb_id','=',$sb_id]])->first()->id;
        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Glabella']);
        $data = array('method_id'=>$method_id,'feature'=>'Glabella','display_name'=>'Glabella', 'display_order' =>  2, 'display_values' => '{"1":"1", "2":"2", "3":"3", "4":"4", "5":"5"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name','=','Cranium')->first()->id;
        $method_id = Method::where([['name','=','Buikstra and Ubelaker 1994'],['type','=','Sex'],['sb_id','=',$sb_id]])->first()->id;
        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Mastoid Process']);
        $data = array('method_id'=>$method_id,'feature'=>'Mastoid Process','display_name'=>'Mastoid Process', 'display_order' =>  1, 'display_values' => '{"1":"1", "2":"2", "3":"3", "4":"4", "5":"5"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name','=','Cranium')->first()->id;
        $method_id = Method::where([['name','=','Buikstra and Ubelaker 1994'],['type','=','Sex'],['sb_id','=',$sb_id]])->first()->id;
        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Nuchal Crest']);
        $data = array('method_id'=>$method_id,'feature'=>'Nuchal Crest','display_name'=>'Nuchal Crest', 'display_order' =>  2, 'display_values' => '{"1":"1", "2":"2", "3":"3", "4":"4", "5":"5"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name','=','Cranium')->first()->id;
        $method_id = Method::where([['name','=','Buikstra and Ubelaker 1994'],['type','=','Sex'],['sb_id','=',$sb_id]])->first()->id;
        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Supraorbital margin']);
        $data = array('method_id'=>$method_id,'feature'=>'Supraorbital margin','display_name'=>'Supraorbital margin', 'display_order' =>  3, 'display_values' => '{"1":"1", "2":"2", "3":"3", "4":"4", "5":"5"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name','=','Cranium')->first()->id;
        $method_id = Method::where([['name','=','Buikstra and Ubelaker 1994'],['type','=','Sex'],['sb_id','=',$sb_id]])->first()->id;
        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Glabella']);
        $data = array('method_id'=>$method_id,'feature'=>'Glabella','display_name'=>'Glabella', 'display_order' =>  4, 'display_values' => '{"1":"1", "2":"2", "3":"3", "4":"4", "5":"5"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name','=','Mandible')->first()->id;
        $method_id = Method::where([['name','=','Buikstra and Ubelaker 1994'],['type','=','Sex'],['sb_id','=',$sb_id]])->first()->id;
        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Mental Eminence']);
        $data = array('method_id'=>$method_id,'feature'=>'Mental Eminence','display_name'=>'Mental Eminence', 'display_order' =>  1, 'display_values' => '{"1":"1", "2":"2", "3":"3", "4":"4", "5":"5"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name','=','Os coxa')->first()->id;
        $method_id = Method::where([['name','=','Buikstra and Ubelaker 1994'],['type','=','Sex'],['sb_id','=',$sb_id]])->first()->id;
        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Greater sciatic notch']);
        $data = array('method_id'=>$method_id,'feature'=>'Greater sciatic notch','display_name'=>'Greater sciatic notch', 'display_order' =>  1, 'display_values' => '{"1":"1", "2":"2", "3":"3", "4":"4", "5":"5"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();

        $sb_id = SkeletalBone::where('name','=','Os coxa')->first()->id;
        $method_id = Method::where([['name','=','Buikstra and Ubelaker 1994'],['type','=','Sex'],['sb_id','=',$sb_id]])->first()->id;
        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Preauricular sulcus']);
        $data = array('method_id'=>$method_id,'feature'=>'Preauricular sulcus','display_name'=>'Preauricular sulcus', 'display_order' =>  2, 'display_values' => '{"0":"0", "1":"1", "2":"2", "3":"3", "4":"4"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => null, 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();

        // New method added a request from University of Milano for ICRC project on Migrant Shiprwreck 2015 and Ca'Granda
        $sb_id = SkeletalBone::where('name','=','Os coxa')->first()->id;
        $method_id = Method::where([['name','=','Rougé-Maillart et al 2009'],['type','=','Age'],['sb_id','=',$sb_id]])->first()->id;
        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Transverse Organization']);
        $data = array('method_id'=>$method_id,'feature'=>'Transverse Organization','display_name'=>'Transverse Organization', 'display_order' =>  1, 'display_values' => '{"1":"1", "2":"2", "3":"3", "4":"4", "5":"5", "6":"6", "7":"7"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => '{"1":"17-21", "2":"17-22", "3":"17-22", "4":"18+", "5":"17-20", "6":"17-20", "7":"17-20"}', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();

        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'Rim']);
        $data = array('method_id'=>$method_id,'feature'=>'Rim','display_name'=>'Rim', 'display_order' =>  2, 'display_values' => '{"1":"1", "2":"2", "3":"3", "4":"4", "5":"5"}', 'computed' => false, 'compute_rule' => null, 'display_interval' => '{"1":"17-21", "2":"17-22", "3":"17-22", "4":"18+", "5":"17-20"}', 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();

//        $methodFeature = MethodFeature::firstOrNew(['method_id' => $method_id, 'feature'=>'SUMALL']);
//        $data = array('method_id'=>$method_id,'feature'=>'SUMALL','display_name'=>'Composite Score - SUMALL', 'display_order' => 4,
//            'display_values' => '{"3":"3", "4":"4", "5":"5", "6":"6", "7":"7", "8":"8", "9":"9", "10":"10", "11":"11", "12":"12", "13":"13", "14":"14", "15":"15", "16":"16"}',
//            'computed' => true, 'compute_rule' => 'Surface Topography,Porosity,Osteophyte Formation', 'display_interval' => null, 'created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt);
//        (!$methodFeature->exists) ? $methodFeature->fill($data)->save() : $methodFeature->fill(array_except($data, ['created_at']))->save();
    }
}
