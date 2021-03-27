<?php

namespace App\Console\Commands;

use App\Articulation;
use App\SkeletalBone;
use App\DNA;
use App\SkeletalElement;
use App\AnalyticsSummary;
/**
 * Class SEArticulationsCommand
 * @package App\Console\Commands
 *
 * This Command creates a list of all possible articulations.
 * This list includes id of specimens, id of articulations, ...
 *
 * Example usage: php artisan cora:se-articulations --org=all
 *              : php artisan cora:se-articulations  --org=DPAA
 *              : php artisan cora:se-articulations  --project=Buna
 *              : php artisan cora:se-articulations  --project=Buna --max-overlap-number = 0
 *              : php artisan cora:se-articulations  --project=Buna --max-overlap-number = 0 --update-table=0
 *
 *
 */
class SEArticulationsCommand extends CoraBaseCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cora:se-articulations {--confirm}
                    {--O|org=all : All projects in a specific org by acronym, all orgs by default}
                    {--P|project= : For a specific project}
                    {--N|max-articulations-per-sb=15 : Desired number of articulations on the same bone type}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Find all Specimens (SE) marked articulated and all related possible articulations';

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
     * Find all the Specimens (SE) that are marked articulated and all the related possible articulations
     * of these specimens within a project.
     *
     * @param $project
     * @param $params
     */
    public function handleAnalyticsWork($project, $params)
    {
        try {
            //Get the list of skeletal elements of the given project that satisfy the following conditions
            //1. Articulated bone
            $skeletalelements = SkeletalElement::where('skeletal_elements.project_id', '=', $project->id)
                ->join('skeletal_bones', 'skeletal_bones.id', '=', 'skeletal_elements.sb_id')
                ->where('skeletal_bones.articulated','=', 'true')
                ->where('skeletal_elements.deleted_at', '=', null)
                ->select('skeletal_elements.id as id', 'skeletal_elements.sb_id as sb_id', 'skeletal_elements.dna_sampled as dna_sampled',
                    'skeletal_elements.individual_number as individual_number', 'skeletal_elements.side as side')
                ->distinct()->get();

            $this->info("\nFor Project " . $project->name . ", there are " . count($skeletalelements) . " Specimens articulated");
            $bar = $this->output->createProgressBar(count($skeletalelements));

            $maxnumberofmatches = $params["max-articulations-per-sb"];

            foreach ($skeletalelements as $securrent) {

                $bar->advance();
                $this->info("\n\nFind possible articulations for SE: " . $securrent->id);

                $list_articulations = [];
                $se_articulation_summary = [];
                $isresultscomplete = true;

                //Find all types of bones that should be articulated with this current SE
                $sb_articulations = Articulation::where('sb_id', '=', $securrent->sb_id)->select('articulation_id as articulation_id')->get();
                //What are the possible bones that can be articulated with this SE
                $bar1 = $this->output->createProgressBar(count($sb_articulations));

                //Go through the type of bones
                // 1. Get all SE with the same current bone type in the project as se candidates
                // 2. Check if se candidates dna sampled is false or if true then compare the mito seq number with the current SE
                // 3. Check if individual number is null or if true then compare it with the individual number of the current SE
                // 4. Check if the size of the result is greater than the size of analytic results
                // 5. Load the result into analytic_summary table
                foreach ($sb_articulations as $sb_articulation) {

                    $seunassociated = [];
                    $count_number_per_sb_id = 0;

                    $bar1->advance();
                    //DNA sampled is false
                    // 1. Get all SE with the same current bone type in the project as se candidates
                    // 2. Check if se candidates dna sampled is false or if true then compare the mito seq number with the current SE
                    // 3. Check if individual number is null or if true then compare it with the individual number of the current SE
                    $secandidates = SkeletalElement::where("sb_id", '=', $sb_articulation->articulation_id)
                        ->where("side", "!=", $securrent->getOppositeSide())   // not opposite side
                        ->where("id", "!=", $securrent->id)
                        ->where("project_id", "=", $project->id)
                        ->where("dna_sampled", false)
                        //->where("individual_number", "=", null)
                        //->orwhere("individual_number", "=", $securrent->individual_number)
                        ->get();
                    foreach ($secandidates as $secandidate) {
                        $articulation = array();
                        if (($secandidate->individual_number == null)
                            || ($secandidate->individual_number == $securrent->individual_number)) {
                            $articulation = ['id' => null, 'dna_sampled' => '0', 'mito_seq' => null, 'i_number' => null];
                            $articulation['id'] = $secandidate->id;
                            $articulation['i_number'] = $secandidate->individual_number;
                            //if ($count_number_per_sb_id < $maxnumberofmatches) {
                                array_push($seunassociated, $articulation);
                                $count_number_per_sb_id += 1;
                            //}
                        }
                    }
                    //DNA Sampled is true, check if they have the same mito sequence number
                    // 1. Get all SE with the same current bone type in the project as se candidates
                    // 2. Check if se candidates dna sampled is false or if true then compare the mito seq number with the current SE
                    // 3. Check if individual number is null or if true then compare it with the individual number of the current SE
                    $secandidates = SkeletalElement::where("sb_id", '=', $sb_articulation->articulation_id)
                        ->where("side", "!=", $securrent->getOppositeSide())   // not opposite side
                        ->where("id", "!=", $securrent->id)
                        ->where("project_id", "=", $project->id)
                        ->where("dna_sampled", true)
                        //->where("individual_number", "=", null)
                        //->orwhere("individual_number", "=", $securrent->individual_number)
                        ->get();
                    $securrentmitoseq = DNA::where('se_id', '=', $securrent->id)->select('mito_sequence_number')->get();
                    foreach ($secandidates as $secandidate) {
                        $articulation = array();
                        $secandidatemitoseq = DNA::where('se_id', '=', $secandidate->id)->select('mito_sequence_number')->get();
                        $samemitoseq = null;
                        foreach ($securrentmitoseq as $mitoseq) {
                            $mt = $secandidatemitoseq->where('mito_sequence_number', '=', $mitoseq->mito_sequence_number)->first();
                            if (($mitoseq->mito_sequence_number != null) && ($mt != null)) {
                                $samemitoseq = $mitoseq->mito_sequence_number;
                                break;
                            }
                        }
                        //If same mito seq number or both mito seq numbers are null
                        if ($samemitoseq || (!$secandidatemitoseq->where('mito_sequence_number', '!=', null)->first())){
                            if(($secandidate->individual_number == null)
                                || ($secandidate->individual_number == $securrent->individual_number)) {
                                $articulation = ['id' => null, 'dna_sampled' => '1', 'mito_seq' => null, 'i_number' => null];
                                $articulation['id'] = $secandidate->id;
                                $articulation['mito_seq'] = $samemitoseq;
                                $articulation['i_number'] = $secandidate->individual_number;
                                //if ($count_number_per_sb_id < $maxnumberofmatches) {
                                $count_number_per_sb_id += 1;
                                array_push($seunassociated, $articulation);
                                }
                            }
                    }
                    $articulations = array();
                    $articulations = ['sb_id' => null, 'number' => null, 'articulations' => null];
                    $articulations['sb_id'] = $sb_articulation->articulation_id;
                    $articulations['number'] = $count_number_per_sb_id;
                    $articulations['articulations'] = $seunassociated;
                    array_push($list_articulations, $articulations);
                }
                $bar1->finish();
                $se_articulation_summary = ['se_id' => null, 'se_articulations' => null];
                $se_articulation_summary['se_id'] = $securrent->id;
                $se_articulation_summary['se_articulations'] = $list_articulations;
                // 4. Check if the size of the result is greater than the size of analytic results
                $result = json_encode($se_articulation_summary);
                if(strlen($result) > $this->sizeofanalyticsresults){
                    $result = substr($result,0, $this->sizeofanalyticsresults);
                    $isresultscomplete = false;
                }
                $this->info("\n\n" . $result);

                // 5. Load the result into analytic_summary table
                $dt = date_create();
                $analyticsummary = AnalyticsSummary::firstOrNew(['se_id' => $securrent->id, 'type' => 'articulation']);
                $data = array('org_id' => $project->org->id, 'project_id' => $project->id,
                    'results_status' => $isresultscomplete ? "Complete" : "Incomplete",
                    'analytics_results' => $result,
                    'created_by' =>  __CLASS__, 'updated_by' => __CLASS__,
                    'created_at' => $dt, 'updated_at' => $dt);
                (!$analyticsummary->exists) ? $analyticsummary->fill($data)->save() : $analyticsummary->fill(array_except($data, ['created_at']))->save();
            }
            $bar->finish();
        } catch (QueryException $ex) {
            $this->info($this->name . " failed for " . $project->name);
            return;
        }
    }
}
