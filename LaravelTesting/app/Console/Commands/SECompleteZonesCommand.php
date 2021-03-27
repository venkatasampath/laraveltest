<?php

/**
 * SECompleteZonesCommand Class derived from Command
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

use App\SkeletalElement;
use App\Zone;

/**
 * Class SECompleteZonesCommand
 * @package App\Console\Commands
 *
 * This Command finds all the Specimens (SE) that are marked as complete and if any zone
 * is not present (null) then create these zones for these specimens within a project.
 *
 * This Command should typically be called once to fix imported Specimen data.
 * This was needed for the USS Oklahoma project, For most other projects
 * where data is entered via CoRA we will not run into this issue as
 * it is automatically handled by CoRA business layer which is
 * typically implemented in the SkeletalElement controller
 *
 * This can also be used as a Data Quality (Dq) check, as part of a weekly Dq job.

 * Example usage: php artisan cora:se-complete-zones --org=all
 *              : php artisan cora:se-complete-zones --org=DPAA
 *              : php artisan cora:se-complete-zones --project="USS Oklahoma"
 *
 */
class SECompleteZonesCommand extends CoraBaseCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cora:se-complete-zones {--confirm}
                    {--O|org=all : All projects in a specific org by acronym, all orgs by default}
                    {--P|project= : For a specific project}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Find all Specimens (SE) marked as Complete and create all corresponding SE Zone records';

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
     * Find all the Specimens (SE) that are marked as complete and if any zone is not
     * present (null) then create these zones for these specimens within a project.
     *
     * @param $project
     */
    protected function handleWork($project)
    {
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
}
