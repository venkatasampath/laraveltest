<?php

namespace App\Console\Commands;

use App\DNA;
use App\SkeletalElement;
use App\AnalyticsSummary;

/**
 * Class SEPairMatchingCommand
 * @package App\Console\Commands
 *
 * This Command creates a list of all possible pair matching.
 * This list includes id of specimens, id of pair match, ...
 *
 * Example usage: php artisan cora:se-pairmatching --org=all
 *              : php artisan cora:se-pairmatching  --org=DPAA
 *              : php artisan cora:se-pairmatching  --project=Buna
 *
 */
class SEPairMatchingCommand extends CoraBaseCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cora:se-pairmatching {--confirm}
                    {--O|org=all : All projects in a specific org by acronym, all orgs by default}
                    {--P|project= : For a specific project}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Find all Specimens (SE) marked paired and all related possible pair matching';

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
     * Find all the Specimens (SE) that are marked paired and all the related possible pair matching
     * of these specimens within a project.
     *
     * @param $project
     * @param $params
     */
    public function handleAnalyticsWork($project, $params)
    {
        try {
            //Get the list of skeletal elements of the given project that satisfy the following conditions
            //1. Paired bone
            $skeletalelements = SkeletalElement::where('skeletal_elements.project_id', '=', $project->id)
                ->join('skeletal_bones', 'skeletal_bones.id', '=', 'skeletal_elements.sb_id')
                ->where('skeletal_bones.paired','=', 'true')
                ->where('skeletal_elements.deleted_at', '=', null)
                ->select('skeletal_elements.id as id', 'skeletal_elements.sb_id as sb_id', 'skeletal_elements.dna_sampled as dna_sampled',
                    'skeletal_elements.individual_number as individual_number', 'skeletal_elements.side as side')
                ->distinct()->get();

            $this->info("\nFor Project " . $project->name . ", there are " . count($skeletalelements) . " Specimens that can be paired");
            $bar = $this->output->createProgressBar(count($skeletalelements));

            foreach ($skeletalelements as $securrent) {

                $bar->advance();
                $this->info("\n\nFind possible pair matching for SE: " . $securrent->id);

                $list_pairmatch = [];
                $se_pairmatch_summary = [];
                $isresultscomplete = true;
                $count_pairmatch = 0;

                //What are the possible bones that can be paired with this SE
                // 1. Get all SE with the same bone type and same side as se candidates
                // 2. Check if se candidates dna sampled is false or if true then compare the mito seq number with the current SE
                // 3. Check if individual number is null or if true then compare it with the individual number of the current SE
                // 4. Check if the size of the result exceeds the size of analytic results
                // 5. Load the result into analytic_summary table

                //DNA sampled is false
                // 1. Get all SE with the same bone type and same side as se candidates
                // 2. Check if se candidates dna sampled is false or if true then compare the mito seq number with the incomplete SE
                // 3. Check if individual number is null or if true then compare it with the individual number of the incomplete SE
                $secandidates = SkeletalElement::where("sb_id", '=', $securrent->sb_id)
                    ->where("side", "!=", $securrent->side)   // not opposite side
                    ->where("id", "!=", $securrent->id)
                    ->where("project_id", "=", $project->id)
                    ->where("dna_sampled", false)
                    ->get();
                foreach ($secandidates as $secandidate) {
                    $pairmatch = array();
                    if (($secandidate->individual_number == null)
                        || ($secandidate->individual_number == $securrent->individual_number)) {
                        $pairmatch = ['id' => null, 'dna_sampled' => '0', 'mito_seq' => null, 'i_number' => null];
                        $pairmatch['id'] = $secandidate->id;
                        $pairmatch['i_number'] = $secandidate->individual_number;
                        array_push($list_pairmatch, $pairmatch);
                        $count_pairmatch += 1;
                    }
                }

                //DNA Sampled is true, check if they have the same mito sequence number
                // 1. Get all SE with the same bone type and same side as se candidates
                // 2. Check if se candidates dna sampled is false or if true then compare the mito seq number with the incomplete SE
                // 3. Check if individual number is null or if true then compare it with the individual number of the incomplete SE
                $secandidates = SkeletalElement::where("sb_id", '=', $securrent->sb_id)
                    ->where("side", "!=", $securrent->side)   // not opposite side
                    ->where("id", "!=", $securrent->id)
                    ->where("project_id", "=", $project->id)
                    ->where("dna_sampled", true)
                    ->get();
                $securrentmitoseq = DNA::where('se_id', '=', $securrent->id)->select('mito_sequence_number')->get();
                foreach ($secandidates as $secandidate) {
                    $pairmatch = array();
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
                    if ($samemitoseq || (!$secandidatemitoseq->where('mito_sequence_number', '!=', null)->first())) {
                        if (($secandidate->individual_number == null)
                            || ($secandidate->individual_number == $securrent->individual_number)) {
                            $pairmatch = ['id' => null, 'dna_sampled' => '1', 'mito_seq' => null, 'i_number' => null];
                            $pairmatch['id'] = $secandidate->id;
                            $pairmatch['mito_seq'] = $samemitoseq;
                            $pairmatch['i_number'] = $secandidate->individual_number;
                            $count_pairmatch += 1;
                            array_push($list_pairmatch, $pairmatch);
                        }
                    }
                }
                $se_pairmatch_summary = ['se_id' => null, 'number' => null, 'pairmatches' => null];
                $se_pairmatch_summary['se_id'] = $securrent->id;
                $se_pairmatch_summary['number'] = $count_pairmatch;
                $se_pairmatch_summary['pairmatches'] = $list_pairmatch;

                // 4. Check if the size of the result is greater than the size of analytic results
                $result = json_encode($se_pairmatch_summary);
                if(strlen($result) > $this->sizeofanalyticsresults){
                    $result = substr($result,0, $this->sizeofanalyticsresults);
                    $isresultscomplete = false;
                }
                $this->info("\n\n" . $result);

                // 5. Load the result into analytic_summary table
                $dt = date_create();
                $analyticsummary = AnalyticsSummary::firstOrNew(['se_id' => $securrent->id, 'type' => 'pair matching']);
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
