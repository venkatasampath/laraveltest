<?php

namespace App\Console\Commands;

use App\DNA;
use App\Method;
use App\SkeletalElement;
use App\AnalyticsSummary;

/**
 * Class SEMethodFeatureCommand
 * @package App\Console\Commands
 *
 * This Command creates a list of all SE that have the similar age.
 * This list includes id of specimens, ...
 *
 * Example usage: php artisan cora:se-methodfeature --org=all
 *              : php artisan cora:se-methodfeature  --org=DPAA
 *              : php artisan cora:se-methodfeature  --project=Buna
 *
 */

class SEMethodFeatureCommand extends CoraBaseCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cora:se-methodfeature {--confirm}
                    {--O|org=all : All projects in a specific org by acronym, all orgs by default}
                    {--P|project= : For a specific project}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Find all Specimens (SE) that have similar method interval';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Find all the Specimens (SE) that have same method features age interval
     * of these specimens within a project.
     *
     * @param $project
     * @param $params
     */
    public function handleAnalyticsWork($project, $params)
    {
        try {
            //Get the list of skeletal elements of the given project that satisfy the following conditions
            // 1. SE has method features defined for it
            // 2. Method feature has display_interval
            $skeletalelements = SkeletalElement::where('skeletal_elements.project_id', '=', $project->id)
                ->join('se_method_feature', 'se_method_feature.se_id', '=', 'skeletal_elements.id')
                ->join('method_features', 'method_features.id', '=' ,'se_method_feature.method_feature_id')
                ->where('skeletal_elements.deleted_at', '=', null)
                ->where('method_features.display_interval', '!=', null)
                ->select('skeletal_elements.id as id',
                    'skeletal_elements.dna_sampled as dna_sampled',
                    'skeletal_elements.individual_number as individual_number',
                    'se_method_feature.method_id as method',
                    'method_features.display_interval as display_interval',
                    'se_method_feature.score as score')
                ->distinct()->get();

            // We need the list of ids to be unique at the first place
            $listids = $skeletalelements->pluck('id')->unique();
            $this->info("\nFor Project " . $project->name . ", there are " . count($listids) . " occurances of specimen - method features");
            $bar = $this->output->createProgressBar(count($skeletalelements));

            foreach ($listids as $securrentid) {

                $bar->advance();
                $this->info("\n\nFind possible SE with similar age as: " . $securrentid);

                // 1.Get all the methods of this current SE
                $securrent = SkeletalElement::where('id', '=', $securrentid)->first();
                $securrentmethods = $securrent->methods()->get();
                $listsecurrentmethods = array();

                //2. Go through each method of the current SE
                foreach ($securrentmethods as $securrentmethod) {

                    $listmethods = array();
                    $securrentrealage = null;
                    //3. Get all the method that have the same name as the current method
                    $methods = Method::where('name', '=', $securrentmethod->name)->get();
                    foreach ($methods as $method) {

                        $methodid = $method->id;
                        $listsecandidate = array();
                        $count_semethod = 0;

                        // 4. Get all SE from the list of SE generated at the beginning of the command that have the same $methodid
                        $secandidates = $skeletalelements->where('method', '=', $methodid)->where('id', '!=', $securrentid)->pluck('id')->unique();
                        // Go through all SE candidates
                        foreach ($secandidates as $secandidateid) {

                            $secandidate = $skeletalelements->where('id', '=', $secandidateid)->first();
                            //5. Check if DNA sampled and I-number conditions are good
                            $samemitoseq = null;
                            $isdnainumber = true;
                            if (!$secandidate->dna_sampled) {
                                //Can't use orWhere on a collection
                                if (($securrent->individual_number != null)
                                    && ($securrent->individual_number == $secandidate->individual_number)) {
                                    $isdnainumber = true;
                                } elseif ($secandidate->individual_number == null) {
                                    $isdnainumber = true;
                                }
                            } else {
                                $securrentmitoseq = DNA::where('se_id', '=', $securrent->id)->select('mito_sequence_number')->get();
                                $secandidatemitoseq = DNA::where('se_id', '=', $secandidate->id)->select('mito_sequence_number');
                                foreach ($securrentmitoseq as $semitoseq) {
                                    if (($semitoseq->mito_sequence_number != null)
                                        && ($secandidatemitoseq->where('mito_sequence_number', '=', $semitoseq->mito_sequence_number)->first())) {
                                        $samemitoseq = $semitoseq->mito_sequence_number;
                                        $isdnainumber = true;
                                        break;
                                    }
                                }
                                if ($samemitoseq == null) {
                                    //If both se do not have the same mito seq number
                                    //Check if both mito-seq number is null
                                    $mq = $secandidatemitoseq->where('mito_sequence_number', '!=', null)->get();
                                    if (!$mq->first()) {
                                        if (($securrent->individual_number != null)
                                            && ($securrent->individual_number == $secandidate->individual_number)) {
                                            $isdnainumber = true;
                                        } elseif ($secandidate->individual_number == null) {
                                            $isdnainumber = true;
                                        }
                                    }
                                }
                            }
                            // 5. Find the age of the se current and se candidate
                            if ($isdnainumber) {

                                $securrentmeathodefeatures = $skeletalelements->where('id', '=', $securrentid)->where('method', '=', $securrentmethod->id);
                                // Get the list of ages based on each score of securrent
                                $securrentagesinterval = $this->getListOfAgesFromMethodFeatures($securrentmeathodefeatures);
                                // Choose from the list of ages the real age of the current SE
                                if ($securrentagesinterval != null) {
                                    // Find the real se current age interval
                                    $securrentrealage = $this->getRealAgeInterval($securrentagesinterval);
                                    // Do the same process to the SE Candidate
                                    $secandidatemeathodefeatures = $skeletalelements->where('id', '=', $secandidateid)->where('method', '=', $methodid);
                                    // Get the list of ages based on each score of se candidate
                                    $secandidateagesinterval = $this->getListOfAgesFromMethodFeatures($secandidatemeathodefeatures);
                                    if ($secandidateagesinterval != null) {
                                        $secandidaterealage = $this->getRealAgeInterval($secandidateagesinterval);
                                        // Check if the range of se candidate is included into the range of se current
                                        $issecandidateageinrange = false;
                                        // SE current age: "17-20" - SE candidate age "<25"
                                        $rangecurrent = range(($securrentrealage["min"]), $securrentrealage["max"], 1);
                                        $rangecandidate = range(($secandidaterealage["min"]), $secandidaterealage["max"], 1);
                                        $intersection = array_intersect($rangecandidate, $rangecurrent);
                                        $confidence = "High";
                                        if ($intersection != null) {
                                            $issecandidateageinrange = true;
                                            if(count($rangecurrent) != count($intersection)){
                                                $confidence = "Medium";
                                            }
                                        }
                                        // If both have similar age for example
                                        if ($issecandidateageinrange) {
                                            $se = ['id' => null, 'age' => 0];
                                            $se['id'] = $secandidate->id;
                                            $se['confidence'] = $confidence;
                                            $se['age_interval'] = $secandidaterealage;
                                            array_push($listsecandidate, $se);
                                            $count_semethod += 1;
                                        }
                                    }
                                }
                            }
                        }
                        if(!empty($listsecandidate)) {
                            $sepermethod = ['method_id' => null, 'number' => null, 'sb_id'=>null, 'se' => null];
                            $sepermethod['method_id'] = $methodid;
                            $sepermethod['number'] = $count_semethod;
                            $sepermethod['sb_id'] = $method->sb_id;
                            $sepermethod['se'] = $listsecandidate;
                            array_push($listmethods, $sepermethod);
                        }
                    }
                    if(!empty($listmethods)) {
                        $se_method_summary = ['se_id' => null, 'se_age_interval' => null, 'method_name' => null, 'methods' => null];
                        $se_method_summary['se_id'] = $securrentid;
                        $se_method_summary['se_age_interval'] = $securrentrealage;
                        $se_method_summary['method_name'] = $securrentmethod->name;
                        $se_method_summary['methods'] = $listmethods;

                        // 6. Check if the size of the result is greater than the size of analytic results
                        $isresultscomplete = true;
                        $result = json_encode($se_method_summary);
                        if (strlen($result) > $this->sizeofanalyticsresults) {
                            $result = substr($result, 0, $this->sizeofanalyticsresults);
                            $isresultscomplete = false;
                        }
                        $this->info("\n\n" . $result);

                        //7. Load the result into analytic_summary table
                        $dt = date_create();
                        $type = "method-" . $method->type . "-" . $method->name;
                        $analyticsummary = AnalyticsSummary::firstOrNew(['se_id' => $securrentid, 'type' => $type]);
                        $data = array('org_id' => $project->org->id, 'project_id' => $project->id,
                            'results_status' => $isresultscomplete ? "Complete" : "Incomplete",
                            'analytics_results' => $result,
                            'created_by' => __CLASS__, 'updated_by' => __CLASS__,
                            'created_at' => $dt, 'updated_at' => $dt);
                        (!$analyticsummary->exists) ? $analyticsummary->fill($data)->save() : $analyticsummary->fill(array_except($data, ['created_at']))->save();
                    }
                }
            }

        } catch (QueryException $ex) {
            $this->info($this->name . " failed for " . $project->name);
            return;
        }
    }

    /**
     * This function retrieves all the age intervals that correspond to the score
     * of method features.
     *
     * @param $semeathodefeatures
     * @return array
     */
    protected function getListOfAgesFromMethodFeatures($semeathodefeatures){
        $ages = array();
        foreach ($semeathodefeatures as $semeathodefeatures){
            //Decide on the age of the current SE
            //display_interval: {"0":"17-20", "1":"17-20", "2":"17-21", "3":"17-23", "4":"17+"}
            $displayintervals = json_decode($semeathodefeatures->display_interval, true);
            // Get the interval that corresponds to the score
            $ageofsecurrent = $displayintervals[$semeathodefeatures->score];
            // Convert the interval to string
            $ageofcurrentstring = str_split($ageofsecurrent) ;

            $ageinterval = ["min"=> 0, "max"=>0];
            //{"0":"17-20", "1":"17-20", "2":"17-21", "3":"17-23", "4":"17+"}
            //{"0":"≤20", "1":"16-21", "2":"≥18"}
            if(in_array("-", $ageofcurrentstring)){
                $interval = explode("-", $ageofsecurrent);
                $ageinterval["min"] = $interval[0];
                $ageinterval["max"] = $interval[1];
            } elseif(in_array("<", $ageofcurrentstring)){
                $interval = explode("<", $ageofsecurrent);
                $ageinterval["min"] = 0;
                $ageinterval["max"] = $interval[1]-1;
            } elseif( strpos( $ageofsecurrent, "≤" ) !== false) {
                $interval = explode("≤", $ageofsecurrent);
                $ageinterval["min"] = 0;
                $ageinterval["max"] = $interval[1];
            } elseif(in_array(">", $ageofcurrentstring)){
                $interval = explode(">", $ageofsecurrent);
                $ageinterval["min"] = $interval[1]+1;
                $ageinterval["max"] = 100;
            } elseif( strpos( $ageofsecurrent, "≥" ) !== false){
                $interval = explode("≥", $ageofsecurrent);
                $ageinterval["min"] = $interval[1];
                $ageinterval["max"] = 100;
            } elseif(in_array("+", $ageofcurrentstring)){
                $interval = explode("+", $ageofsecurrent);
                $ageinterval["min"] = $interval[0];
                $ageinterval["max"] = 100;
            } else {
                $ageinterval["min"] = $ageofsecurrent;
                $ageinterval["max"] = 100;
            }
            array_push($ages, $ageinterval);
        }
        return $ages;
    }

    /**
     * This function merges all age intervals to generate one single interval.
     *
     * @param $ageintervals
     * @return array
     */
    protected function getRealAgeInterval($ageintervals){
        // eg: 17-20 vs <20 -> 0-20
        $interval = ["min" => $ageintervals[0]["min"], "max"=> $ageintervals[0]["max"]];
        foreach ($ageintervals as $ageinterval) {
            if($ageinterval["min"] < $interval["min"]){
                $interval["min"] = $ageinterval["min"];
            }
            if($ageinterval["max"] > $interval["max"]){
                $interval["max"] = $ageinterval["max"];
            }
        }
        return $interval;
    }
}
