<?php

/**
 * DqCheckCommand Class derived from Command
 *
 * @category   Cora Command
 * @package    Commands
 * @author     Sachin Pawaskar<spawaskar@unomaha.edu>
 * @copyright  2016-2019
 * @license    The MIT License (MIT)
 * @version    GIT: $Id$
 * @since      File available since Release 1.0.0
 */

namespace App\Console\Commands;

use App\Accession;
use App\Dna;
use App\Measurement;
use App\SkeletalElement;
use App\Zone;

/**
 * Class DqCheckCommand
 * @package App\Console\Commands
 *
 * This Command will run all the Data Quality (dq) checks for a given project
 * This should typically be run as part of a weekly Data Quality job.
 *
 * Example usage: php artisan cora:dq-check --org=all --check=ABMZ
 *              : php artisan cora:dq-check --org=DPAA --check=AMZ
 *              : php artisan cora:dq-check --project="USS Oklahoma" --check=B
 *
 */
class DqCheckCommand extends CoraBaseCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cora:dq-check {--confirm}
                    {--O|org=all : All projects in a specific org by acronym, all orgs by default}
                    {--P|project= : For a specific project}
                    {--C|check=all : ABMZ, all checks by default}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run the Data Quality checks on a given project';

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
     * Run all the Data Quality checks on a given project. Following are the DQ checks.
     * 1) Check if a specimens has values in all measurements that it is marked as measured, if not mark as measured.
     * 2) Check that the sb_id (Bone) field in dna or other specimen associated tables is populated.
     * 3) Check if a specimen is complete then all zones are present, if not create the missing zones.
     * 4) Check if all unique ANP1P2 combinations in a project exist in the Accession table,
     *    if not create missing ANP1P2 in Accession table.
     *
     * @param $project
     */
    protected function handleWork($project)
    {
        if ($this->option('check')) {
            $check = $this->option('check');

            if ($this->option('check') === "all") {
                $this->dqCheckProjectHasAllUniqueANP1P2($project);
                $this->dqCheckBoneID($project);
                $this->dqCheckSpecimenMeasured($project);
                $this->dqCheckSpecimenCompleteZones($project);
            } else {
                if (strpos(strtoupper($check), 'A') !== false) {
                    $this->dqCheckProjectHasAllUniqueANP1P2($project);
                }
                if (strpos(strtoupper($check), 'B') !== false) {
                    $this->dqCheckBoneID($project);
                }
                if (strpos(strtoupper($check), 'M') !== false) {
                    $this->dqCheckSpecimenMeasured($project);
                }
                if (strpos(strtoupper($check), 'Z') !== false) {
                    $this->dqCheckSpecimenCompleteZones($project);
                }
            }
        }
    }

    /**
     * Find all the Specimens (SE) that are marked as unmeasured that have
     * values in all measurements and mark those SE as measured within a project.
     *
     * @return void
     */
    protected function dqCheckSpecimenMeasured($project)
    {
        $this->info("\n" . "Running DQ Check Specimen Measured for " . $project->name);
        try {
            $skeletalelements = SkeletalElement::where('project_id', $project->id)->where('measured', false)->get();
            $this->info("For Project " . $project->name . ", " . count($skeletalelements) . " Specimens were found which are marked as unmeasured");
            $count = 0;
            $se_count = 0;
            $sys = __CLASS__;

            $bar = $this->output->createProgressBar(count($skeletalelements));
            foreach ($skeletalelements as $skeletalelement) {
                $measurements = Measurement::where('sb_id', $skeletalelement->sb_id)->get();
                foreach ($measurements as $measurement) {
                    if ($skeletalelement->getMeasurement($measurement->id) != null) {
                        if ($skeletalelement->getMeasure($measurement->id) != null) {
                            $skeletalelement->update(['measured' => true, 'updated_by' => $sys]);
                            $count += 1;
                            break;
                        }
                    }
                }
                $se_count += 1;
                $bar->advance();
            }
            $this->info("\n" . $count . " specimen rows changed for project " . $project->name);
        } catch (QueryException $ex) {
            $this->info($this->name . " failed for " . $project->name);
            return;
        }
    }

    /**
     * Find all the Specimens (SE) that are marked as complete and if any zone is not
     * present (null) then create these zones for these specimens within a project.
     *
     * @param $project
     */
    protected function dqCheckSpecimenCompleteZones($project)
    {
        $this->info("\n" . "Running DQ Check Specimen Complete Zones for " . $project->name);
        try {
            $skeletalelements = SkeletalElement::where('project_id', $project->id )->where('completeness', 'Complete')->get();
            $this->info("\nFor Project ".$project->name.", ".count($skeletalelements)." Specimens were found which are marked as Complete");
            $count = 0; $se_count = 0;
            $sys = __CLASS__;

            $bar = $this->output->createProgressBar(count($skeletalelements));
            foreach ($skeletalelements as $skeletalelement) {
                $zones = Zone::where('sb_id', $skeletalelement->sb_id)->get();
                foreach ($zones as $zone){
                    if ( $skeletalelement->getZone($zone->id) == null) {
                        $skeletalelement->zones()->attach($zone->id, ['org_id' => $skeletalelement->org_id, 'project_id' => $skeletalelement->project_id, 'presence' => true, 'element_complete' => true, 'created_by' => $sys, 'updated_by' => $sys]);
                        $count += 1;
                    }
                }
                $se_count += 1;
                $bar->advance();
            }
            $this->info("\n".$count." rows added for project ".$project->name);
        } catch (QueryException $ex) {
            $this->info($this->name." failed for ".$project->name);
            return;
        }
    }

    /**
     * Find all the unique ANP1P2 combinations in a project by looking at the Specimen
     * (SE) table. If any ANP1P2 combination does not exist in the Accession table
     * for which there is a Specimen record then go ahead and create it
     *
     * @param $project
     */
    protected function dqCheckProjectHasAllUniqueANP1P2($project)
    {
        $this->info("\n" . "Running DQ Check Project has All Unique ANP1P2 for " . $project->name);
        try {
            $count = 0;
            $sys = __CLASS__;
            $anp1p2 = $project->getUniqueANP1P2();

            $bar = $this->output->createProgressBar(count($anp1p2));
            foreach ($anp1p2 as $row) {
                $acc = Accession::firstOrNew(['org_id'=>$project->org_id, 'project_id'=>$project->id,
                    'number'=>$row->accession_number, 'provenance1'=>$row->provenance1, 'provenance2'=>$row->provenance2]);
                $data = array('org_id'=>$project->org_id, 'project_id'=>$project->id,
                    'number'=>$row->accession_number, 'provenance1'=>$row->provenance1, 'provenance2'=>$row->provenance2,
                    'created_by' => $sys, 'updated_by' => $sys, 'created_at' => date_create(), 'updated_at' => date_create());
                if (!$acc->exists) {
                    $acc->fill($data)->save();
                    $count += 1;
                    $this->info("\nCreating ".$row->accession_number.'-'.$row->provenance1.'-'.$row->provenance2." which does not exist");
                }
                $bar->advance();
            }
            $this->info("\n".$count." rows added for project ".$project->name);
        } catch (QueryException $ex) {
            $this->info($this->name." failed for ".$project->name);
            return;
        }
    }

    /**
     * Find all the DNAs that do not have sb_id (Bone) and assign
     * it using the specimen sb_id within a project.
     *
     * @return void
     */
    protected function dqCheckBoneID($project)
    {
        $this->info("\n" . "Running DQ Check Bone ID being pupulated in various Specimen associations such as DNA, etc. for " . $project->name);
        try {
            $dnas = DNA::where('project_id', $project->id)->where('sb_id', null)->get();
            $this->info("For Project " . $project->name . ", " . count($dnas) . " DNAs were found with Null sb_id");
            $count = 0;
            $sys = __CLASS__;

            $bar = $this->output->createProgressBar(count($dnas));
            foreach ($dnas as $dna) {
                $specimen = $dna->specimen;
                if (isset($specimen)) {
                    $dna->update(['sb_id' => $specimen->sb_id, 'updated_by' => $sys]);
                    $count += 1;
                }
                $bar->advance();
            }
            $this->info("\n" . $count . " DNA rows changed for project " . $project->name);
        } catch (QueryException $ex) {
            $this->info($this->name . " failed for " . $project->name);
            return;
        }
    }
}
