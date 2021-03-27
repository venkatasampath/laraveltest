<?php

/**
 * SEMeasuredCommand Class derived from Command
 *
 * @category   Cora Command
 * @package    Commands
 * @author     Sachin Pawaskar<spawaskar@unomaha.edu>
 * @copyright  2016-2018
 * @license    The MIT License (MIT)
 * @version    GIT: $Id$
 * @since      File available since Release 1.0.0
 */

namespace App\Console\Commands;

use App\Measurement;
use App\SkeletalElement;

/**
 * Class SEMeasuredCommand
 * @package App\Console\Commands
 *
 * This Command Find all the Specimens (SE) that are marked as unmeasured that have
 * values in all measurements and mark those SE as measured within a project.
 *
 * This Command should typically be called once to fix imported Specimen data.
 * This was needed for the USS Oklahoma project, For most other projects
 * where data is entered via CoRA we will not run into this issue as
 * it is automatically handled by CoRA business layer which is
 * typically implemented in the SkeletalElement controller
 *
 * This can also be used as a Data Quality (Dq) check, as part of a weekly Dq job.

 * Example usage: php artisan cora:se-complete-measurements --org=all
 *              : php artisan cora:se-complete-measurements --org=DPAA
 *              : php artisan cora:se-complete-measurements --project="USS Oklahoma"
 *
 */
class SEMeasuredCommand extends CoraBaseCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cora:se-complete-measurements {--confirm}
                    {--O|org=all : All projects in a specific org by acronym, all orgs by default}
                    {--P|project= : For a specific project}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Find all Specimens (SE) with values for all measurements and mark them as Measured';

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
     * Find all the Specimens (SE) that are marked as unmeasured that have values
     * in all measurements and mark those SE as measured within a project.
     *
     * @param $project
     */
    protected function handleWork($project)
    {
        try {
            $skeletalelements = SkeletalElement::where('project_id', $project->id )->where('measured', false)->get();
            $this->info("For Project ".$project->name.", ".count($skeletalelements)." Specimens were found which are marked as unmeasured");
            $count = 0; $se_count = 0;
            $sys = __CLASS__;

            $bar = $this->output->createProgressBar(count($skeletalelements));
            foreach ($skeletalelements as $skeletalelement) {
                $measurements = Measurement::where('sb_id', $skeletalelement->sb_id)->get();
                foreach ($measurements as $measurement){
                    if( $skeletalelement->getMeasurement($measurement->id) != null) {
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
            $this->info("\n".$count." specimen rows changed for project ".$project->name);
        } catch (QueryException $ex) {
            $this->info($this->name." failed for ".$project->name);
            return;
        }
    }
}
