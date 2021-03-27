<?php
/**
 * SETrauma DummyData Partial Seeder
 *
 * @category   SETrauma DummyData Partial
 * @package    Seeder
 * @author     Sachin Pawaskar<spawaskar@unomaha.edu>
 * @copyright  2016-2018
 * @license    The MIT License (MIT)
 * @version    GIT: $Id$
 * @since      File available since Release 1.0.0
 */

use Illuminate\Database\Seeder;
use App\SkeletalElement;
use App\Trauma;
use App\Org;
use App\Project;

class SETraumaPartialTableSeeder extends Seeder {
    
    public function run()
    {
        $dt = date_create();
        $sys = 'System';
        $org = Org::where('acronym', '=', 'UNO')->first()->id;
        $project = Project::where('name', '=', 'CoRA Demo')->first()->id;

        $se_id = SkeletalElement::where([['accession_number', '=', 'UNO 2016-212'],[ 'provenance1', '=', 'G-04'], ['provenance2','=', 'X-56F'], ['designator', '=', '403']])->first()->id;$trauma_id = Trauma::where([['timing', '=', 'Antemortem'],['type', '=','']])->first()->id;DB::table('se_trauma')->insert(array(array('org_id'=>$org,'project_id'=>$project,'se_id'=> $se_id,'trauma_id'=> $trauma_id, 'zone_id' => null,'additional_information'=>'Healed AM fx, distal 1/3 shaft, misaligned','created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt)));
        $se_id = SkeletalElement::where([['accession_number', '=', 'UNO 2016-212'],[ 'provenance1', '=', 'G-05'], ['provenance2','=', 'X-219A'], ['designator', '=', '403']])->first()->id;$trauma_id = Trauma::where([['timing', '=', 'Antemortem'],['type', '=','']])->first()->id;DB::table('se_trauma')->insert(array(array('org_id'=>$org,'project_id'=>$project,'se_id'=> $se_id,'trauma_id'=> $trauma_id, 'zone_id' => null,'additional_information'=>'Possible AM fx, antero-medial distal articular surface','created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt)));
        $se_id = SkeletalElement::where([['accession_number', '=', 'UNO 2016-212'],[ 'provenance1', '=', 'G-05'], ['provenance2','=', 'X-219D'], ['designator', '=', '812']])->first()->id;$trauma_id = Trauma::where([['timing', '=', 'Antemortem'],['type', '=','']])->first()->id;DB::table('se_trauma')->insert(array(array('org_id'=>$org,'project_id'=>$project,'se_id'=> $se_id,'trauma_id'=> $trauma_id, 'zone_id' => null,'additional_information'=>'Anterior collapse (wedge) with lipping','created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt)));
        $se_id = SkeletalElement::where([['accession_number', '=', 'UNO 2016-212'],[ 'provenance1', '=', 'G-05'], ['provenance2','=', 'X-219E'], ['designator', '=', '810']])->first()->id;$trauma_id = Trauma::where([['timing', '=', 'Antemortem'],['type', '=','']])->first()->id;DB::table('se_trauma')->insert(array(array('org_id'=>$org,'project_id'=>$project,'se_id'=> $se_id,'trauma_id'=> $trauma_id, 'zone_id' => null,'additional_information'=>'Healed centrum fracture','created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt)));
        $se_id = SkeletalElement::where([['accession_number', '=', 'UNO 2016-212'],[ 'provenance1', '=', 'G-01'], ['provenance2','=', 'X-233E'], ['designator', '=', '403']])->first()->id;$trauma_id = Trauma::where([['timing', '=', 'Perimortem'],['type', '=','']])->first()->id;DB::table('se_trauma')->insert(array(array('org_id'=>$org,'project_id'=>$project,'se_id'=> $se_id,'trauma_id'=> $trauma_id, 'zone_id' => null,'additional_information'=>'fx along distal shaft','created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt)));
        $se_id = SkeletalElement::where([['accession_number', '=', 'UNO 2016-212'],[ 'provenance1', '=', 'G-04'], ['provenance2','=', 'X-56B'], ['designator', '=', '203']])->first()->id;$trauma_id = Trauma::where([['timing', '=', 'Perimortem'],['type', '=','']])->first()->id;DB::table('se_trauma')->insert(array(array('org_id'=>$org,'project_id'=>$project,'se_id'=> $se_id,'trauma_id'=> $trauma_id, 'zone_id' => null,'additional_information'=>'Peri fx proximal third of shaft, taped','created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt)));
        $se_id = SkeletalElement::where([['accession_number', '=', 'UNO 2016-212'],[ 'provenance1', '=', 'G-04'], ['provenance2','=', 'X-56E'], ['designator', '=', '405']])->first()->id;$trauma_id = Trauma::where([['timing', '=', 'Perimortem'],['type', '=','']])->first()->id;DB::table('se_trauma')->insert(array(array('org_id'=>$org,'project_id'=>$project,'se_id'=> $se_id,'trauma_id'=> $trauma_id, 'zone_id' => null,'additional_information'=>'Peri fx proximal','created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt)));
        $se_id = SkeletalElement::where([['accession_number', '=', 'UNO 2016-212'],[ 'provenance1', '=', 'G-04'], ['provenance2','=', 'X-56E'], ['designator', '=', '406']])->first()->id;$trauma_id = Trauma::where([['timing', '=', 'Perimortem'],['type', '=','']])->first()->id;DB::table('se_trauma')->insert(array(array('org_id'=>$org,'project_id'=>$project,'se_id'=> $se_id,'trauma_id'=> $trauma_id, 'zone_id' => null,'additional_information'=>'Peri fx proximal  ','created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt)));
        $se_id = SkeletalElement::where([['accession_number', '=', 'UNO 2016-212'],[ 'provenance1', '=', 'G-22'], ['provenance2','=', 'X-228E'], ['designator', '=', '405']])->first()->id;$trauma_id = Trauma::where([['timing', '=', 'Perimortem'],['type', '=','']])->first()->id;DB::table('se_trauma')->insert(array(array('org_id'=>$org,'project_id'=>$project,'se_id'=> $se_id,'trauma_id'=> $trauma_id, 'zone_id' => null,'additional_information'=>'peri fx shaft','created_by' => $sys, 'updated_by' => $sys, 'created_at' => $dt, 'updated_at' => $dt)));
	}
}