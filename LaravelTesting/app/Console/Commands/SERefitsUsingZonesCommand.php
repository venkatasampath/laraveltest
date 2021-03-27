<?php

namespace App\Console\Commands;

use App\Dna;
use App\SkeletalElement;
use App\Zone;
use App\AnalyticsSummary;

/**
 * Class SERefitsUsingZonesCommand
 * @package App\Console\Commands
 *
 * This Command creates a list of all possible refits for incomplete specimens based on zones.
 * This list includes id of specimens, id of refits, zones, and numbers of overlapping zones.
 *
 * Example usage: php artisan cora:se-refits-using-zones --org=all
 *              : php artisan cora:se-refits-using-zones --org=DPAA
 *              : php artisan cora:se-refits-using-zones --project=Buna
 *              : php artisan cora:se-refits-using-zones --project=Buna --max-overlap-number = 0
 *              : php artisan cora:se-refits-using-zones --project=Buna --refit-matches-number = 2
 *              : php artisan cora:se-refits-using-zones --project=Buna --max-overlap-number = 0 --refit-matches-number = 2
 *
 */
class SERefitsUsingZonesCommand extends CoraBaseCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cora:se-refits-using-zones {--confirm}
                    {--O|org=all : All projects in a specific org by acronym, all orgs by default}
                    {--P|project= : For a specific project}
                    {--M|max-overlap-number=3 : Desired number of overlapping zones between specimen and its refits}
                    {--N|refit-matches-number=16 : Desired number of refit matches}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Find all Specimens (SE) marked as Incomplete and the potential related refits by using zones';

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
     * Find all the Specimens (SE) that are marked as incomplete and list all possible refits
     * of these specimens within a project.
     *
     * @param $project
     * @param $params
     */
    public function handleAnalyticsWork($project, $params)
    {
        try {
            //Get the list of skeletal elements of the given project that satisfy the following conditions
            //1. A bone has zones
            //2. A skeletal element has at least a zone defined for it
            //3. A skeletal element is incomplete
            $skeletalelements = SkeletalElement::where('skeletal_elements.project_id', '=', $project->id)
                ->join('skeletal_bones', 'skeletal_bones.id', '=', 'skeletal_elements.sb_id')
                ->where('skeletal_bones.zones','=', 'true')
                ->join('se_zone', 'se_zone.se_id', '=', 'skeletal_elements.id')
                ->where('skeletal_elements.completeness', '=', 'Incomplete')
                ->where('skeletal_elements.deleted_at', '=', null)
                ->select('skeletal_elements.id as id', 'skeletal_elements.sb_id as sb_id'
                    , 'skeletal_elements.dna_sampled as dna_sampled', 'skeletal_elements.individual_number as individual_number')
                ->distinct()->get();

            $this->info("For Project " . $project->name . ", " . count($skeletalelements) . " Specimens were found Incomplete\n");
            $bar = $this->output->createProgressBar(count($skeletalelements));
            $max_overlap_number_requested = $params["max-overlap-number"];
            $refit_match_number = $params["refit-matches-number"];

            //Find potential refits for each skeletal element from the list above
            foreach ($skeletalelements as $seincomplete) {

                $refits = [];
                $se_refit_summary = [];
                $existingrefits = array();
                $isresultscomplete = true;
                $bar->advance();
                $this->info("\n\nFind potential refits of SE: " . $seincomplete->id);

                //Find the remaining zones of the current skeletal element
                $zones = Zone::where('sb_id', $seincomplete->sb_id)->get();
                $remainingzones = array();
                foreach ($zones as $zone) {
                    if (($seincomplete->getZone($zone->id) == null)
                        || $seincomplete->getZonesPresent->where('id', '=', $zone->id)->first() == null) {
                        array_push($remainingzones, $zone->id);
                    }
                }

                //Get all incomplete SE that have same skeletal bone as the current SE.
                $secandidates = $skeletalelements->where('sb_id', '=', $seincomplete->sb_id)->where('id', '!=', $seincomplete->id);

                //Go through se candidates
                // 1. Check if se candidates dna sampled is false or if true then compare the mito seq number with the incomplete SE
                // 2. Check if individual number is null or if true then compare it with the individual number of the incomplete SE
                // 3. Check if se candidate has at least one of the remaining zones of incomplete SE.
                // 4. Count number of overlapping zones
                // 5. Count number of matches zones
                // 6. Check if the size of the result is greater than the size of analytic results
                //7. Load the result into analytic_summary table
                $bar1 = $this->output->createProgressBar(count($secandidates));
                foreach ($secandidates as $secandidate) {
                    $bar1->advance();

                    $ispossiblerefit = false;
                    // 1. Check if se candidates dna sampled is false or if true then compare the mito seq number with the incomplete SE
                    // 2. Check if individual number is null or if true then compare it with the individual number of the incomplete SE
                    $samemitoseq = null;
                    if (!$secandidate->dna_sampled) {
                        //Can't use orWhere on a collection
                        if (($seincomplete->individual_number != null)
                            && ($seincomplete->individual_number == $secandidate->individual_number)) {
                            $ispossiblerefit = true;
                        } elseif ($secandidate->individual_number == null) {
                            $ispossiblerefit = true;
                        }
                    } else {
                        $seincompletemitoseq = DNA::where('se_id', '=', $seincomplete->id)->select('mito_sequence_number')->get();
                        $secandidatemitoseq = DNA::where('se_id', '=', $secandidate->id)->select('mito_sequence_number');
                        foreach ($seincompletemitoseq as $semitoseq) {
                            if (($semitoseq->mito_sequence_number != null)
                                && ($secandidatemitoseq->where('mito_sequence_number', '=', $semitoseq->mito_sequence_number)->first())) {
                                $samemitoseq = $semitoseq->mito_sequence_number;
                                $ispossiblerefit = true;
                                break;
                            }
                        }
                        if ($samemitoseq == null) {
                            //If both se do not have the same mito seq number
                            //Check if both mito-seq number is null
                            $mq = $secandidatemitoseq->where('mito_sequence_number', '!=', null)->get();
                            if(!$mq->first()) {
                                if (($seincomplete->individual_number != null)
                                    && ($seincomplete->individual_number == $secandidate->individual_number)) {
                                        $ispossiblerefit = true;
                                }elseif ($secandidate->individual_number == null){
                                    $ispossiblerefit = true;
                                }

                            }
                        }
                    }
                    //Only process the se candidate that satisfies the condition above.
                    if ($ispossiblerefit) {

                        $isrefit = false;
                        $array_se_candidate_zones = array();
                        $num_overlap = 0;

                        if ($secandidate->getZonesPresent->count() > 0) {
                            foreach ($remainingzones as $zone_id) {
                                if ($secandidate->getZone($zone_id) != null
                                    && $secandidate->getZonesPresent->where('id', '=', $zone_id)->first() != null) {
                                    $isrefit = true;
                                    break;
                                }
                            }
                            if (!$isrefit) {
                                // 3. Check if se candidate has at least one of the remaining zones of incomplete SE.
                                foreach ($secandidate->getZonesPresent as $zone) {
                                    array_push($array_se_candidate_zones, $zone->id);
                                    if ($seincomplete->getZonesPresent->where('id', '=', $zone->id)->first() != null) {
                                        $num_overlap++;
                                    }
                                }
                                if ($num_overlap < $seincomplete->getZonesPresent->count()) {
                                    $isrefit = true;
                                }
                            }
                            //If isRefit is true and the number of overlapping zone is less than the total zones of
                            //the bone itself, then add se candidate to the list of refits
                            if ($isrefit) {
                                // 4. Count number of overlapping zones
                                if ($num_overlap == 0) {
                                    $se_candidate_zones = $secandidate->getZonesPresent;
                                    foreach ($se_candidate_zones as $zone) {
                                        array_push($array_se_candidate_zones, $zone->id);
                                        if ($seincomplete->getZonesPresent->where('id', '=', $zone->id)->first() != null) {
                                            $num_overlap++;
                                        }
                                    }
                                }
                                // 5. Count number of matches zones
                                $key = implode(",", $array_se_candidate_zones);
                                if (!array_key_exists($key, $existingrefits)) {
                                    $existingrefits[$key] = 1;
                                } else {
                                    $existingrefits[$key] += 1;
                                }
                                //Convert to json format
                                //If the size of the refits added with the next refit does not exceed the size of the analytics_results
                                //column, then keep adding se candidate into the list of refits
                                //Also, test if number of matches is reached.
                                $refit = ['refit_id' => null, 'refit_zones' => null, 'num_overlap' => 0];
                                $refit['refit_id'] = $secandidate->id;
                                $refit['refit_zones'] = json_encode($array_se_candidate_zones);
                                $refit['num_overlap'] = $num_overlap;
                                $refit['dna_sampled'] = $secandidate->dna_sampled;
                                $refit['mito_seq'] = $samemitoseq;
                                $refit['i_number'] = $secandidate->individual_number;
                                if (($existingrefits[$key] - 1) > $refit_match_number) {
                                    continue;
                                } else {
                                    if ((($num_overlap < $zones->count()) && ($num_overlap <= $max_overlap_number_requested))) {
                                        array_push($refits, $refit);
                                    }
                                }
                            }
                        }
                    }
                }
                $bar1->finish();
                $se_refit_summary = ['se_id' => null, 'se_zones' => null, 'se_refits' => null];
                $se_refit_summary['se_id'] = $seincomplete->id;
                $se_refit_summary['se_zones'] = $seincomplete->getZonesPresent->count();
                $se_refit_summary['se_refits'] = $refits;
                // 6. Check if the size of the result is greater than the size of analytic results
                $result = json_encode($se_refit_summary);
                if(strlen($result) > $this->sizeofanalyticsresults){
                    $result = substr($result,0, $this->sizeofanalyticsresults);
                    $isresultscomplete = false;
                }
                $this->info("\n\n" . $result);

                //7. Load the result into analytic_summary table
                $dt = date_create();
                $analyticsummary = AnalyticsSummary::firstOrNew(['se_id' => $seincomplete->id, 'type' => 'refits using zones']);
                $data = array('org_id' => $project->org->id, 'project_id' => $project->id,
                         'results_status' => $isresultscomplete ? "Complete" : "Incomplete",
                         'analytics_results' => $result,
                         'created_by' =>  __CLASS__, 'updated_by' => __CLASS__,
                         'created_at' => $dt, 'updated_at' => $dt);
                (!$analyticsummary->exists) ? $analyticsummary->fill($data)->save() : $analyticsummary->fill(array_except($data, ['created_at']))->save();

            }
        } catch (QueryException $ex) {
            $this->info($this->name . " failed for " . $project->name);
            return;
        }
    }
}