<?php

/**
 * ProjectSummaryCommand Class derived from Command
 *
 * @category   Project Summary Command
 * @package    Commands
 * @author     Sachin Pawaskar<spawaskar@unomaha.edu>
 * @copyright  2016-2019
 * @license    The MIT License (MIT)
 * @version    GIT: $Id$
 * @since      File available since Release 1.0.0
 */

namespace App\Console\Commands;

use App\DailyWeeklyMonthlySummary;
use App\ProjectSummary;
use Carbon\Carbon;

/**
 * Class ProjectSummaryCommand
 * @package App\Console\Commands
 *
 * This Command creates the project summary records with summary information such as Specimens, DNA, etc.
 * This summary information also could be generated daily, weekly or monthly.
 * This summary information will typically be used to display Project/Org Admin Dashboard information
 * It can also be used to send daily or weekly digest emails.
 *
 * This Command should typically be called as a scheduled cron job on a nightly basis.
 *
 * Example usage: php artisan cora:project-summary --org=all
 *              : php artisan cora:project-summary --org=DPAA
 *              : php artisan cora:project-summary --project="USS Oklahoma"
 *              : php artisan cora:project-summary --report-type=Daily
 *              : php artisan cora:project-summary --report-type=Daily --project="USS Oklahoma"
 *              : php artisan cora:project-summary --report-type=Daily --org=DPAA
 *
 */
class ProjectSummaryCommand extends CoraBaseCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cora:project-summary {--confirm}
                    {--report-type= : Calculate Daily, Weekly, or Monthly project summary}
                    {--O|org=all : All projects in a specific org by acronym, all orgs by default}
                    {--P|project= : For a specific project}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Calculate Project Summary Information such as se_total, se_num_complete, se_dna_sampled, etc.';

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
     * Create the project summary information for the given project.
     * This includes summary information for Specimens, DNA,
     * Accessions, etc.
     *
     * @param $project
     */
    protected function handleWork($project)
    {
        try {
            $project_summary = $project->generateProjectSummary();
            $se_summary = $project->generateSESummary();
            $dna_summary = $project->generateDNASummary();
            $user_summary = $project->generateUserSummary();
            $isotope_summary = $project->generateIsotopeSummary();

            // Delete these lines once the tables are dropped
            $se_summary['created_by'] = $se_summary['updated_by'] = __CLASS__;
            $dna_summary['created_by'] = $dna_summary['updated_by'] = __CLASS__;
            $project_summary['created_by'] = $project_summary['updated_by'] = __CLASS__;
            $user_summary['created_by'] = $user_summary['updated_by'] = __CLASS__;
            $isotope_summary['created_by'] = $user_summary['updated_by'] = __CLASS__;

            $this->info("------> Specimen Stats");
            $this->info(json_encode($se_summary));
            $this->info("------> DNA Stats");
            $this->info(json_encode($dna_summary));
            $this->info("------> Project Stats");
            $this->info(json_encode($project_summary));
            $this->info("------> User Stats");
            $this->info(json_encode($user_summary));
            $this->info("------> Isotope Stats");
            $this->info(json_encode($isotope_summary));

            // Uncomment the 3 lines below when ready to move to PROD
            ProjectSummary::create(['org_id'=>$project->org->id, 'project_id'=>$project->id,
                'created_by'=> __CLASS__, 'updated_by'=> __CLASS__,
                'specimen_stats'=>json_encode($se_summary),
                'dna_stats'=>json_encode($dna_summary),
                'project_stats'=>json_encode($project_summary),
                'user_stats'=>json_encode($user_summary),
                'isotope_stats'=>json_encode($isotope_summary)]);

//            // Testing purposes
//            $this->info("Array: ".$project->name);
//            $arr_se = json_decode($json_se);
//            dd([$se_summary, $arr_se, $json_se]);
            $this->info($this->name." succeeded for ".$project->name);
        } catch (QueryException $ex) {
            $this->info($this->name." failed for ".$project->name);
            return;
        }
    }

    /**
     * Create the daily weekly monthly project summary information for the given project.
     * This includes summary information for Specimens, DNA,
     * Accessions, etc.
     *
     * @param $project
     * @param $reportType
     */
    public function handleDailyWeeklyMonthlyWork($project, $reportType)
    {
        try {
            //set yesterday as a default value of startdate and enddate
            //default report type is 'daily'
            date_default_timezone_set('America/Chicago');
            $yesterday = Carbon::yesterday();
            $startDate = date('Y-m-d 00:00:00', $yesterday->getTimestamp());
            $endDate = date('Y-m-d 23:59:59', $yesterday->getTimestamp());
            if ($reportType === 'weekly') {
                $firstDayOfPreviousWeek = Carbon::now()->startOfWeek()->subWeek();
                $startDate = date('Y-m-d 00:00:00', $firstDayOfPreviousWeek->getTimestamp());
                $lastDayOfPreviousWeek = Carbon::now()->endOfWeek()->subWeek();
                $endDate = date('Y-m-d 23:59:59', $lastDayOfPreviousWeek->getTimestamp());
            } elseif ($reportType === 'monthly')  {
                $firstDayOfPreviousMonth = Carbon::now()->startOfMonth()->subMonth();
                $startDate = date('Y-m-d 00:00:00', $firstDayOfPreviousMonth->getTimestamp());
                $lastDayOfPreviousMonth = Carbon::now()->subMonth()->endOfMonth();
                $endDate = date('Y-m-d 23:59:59', $lastDayOfPreviousMonth->getTimestamp());
            }

            $project_summary = $project->generateDailyWeeklyMonthlyProjectSummary($startDate, $endDate);
            $se_summary = $project->generateDailyWeeklyMonthlySESummary($startDate, $endDate);
            $dna_summary = $project->generateDailyWeeklyMonthlyDNASummary($startDate, $endDate);
            $user_summary = $project->generateDailyWeeklyMonthlyUserSummary($startDate, $endDate);
            $isotope_summary = $project->generateDailyWeeklyMonthlyIsotopeSummary($startDate, $endDate);

            // Delete these lines once the tables are dropped
            $se_summary['created_by'] = $se_summary['updated_by'] = __CLASS__;
            $dna_summary['created_by'] = $dna_summary['updated_by'] = __CLASS__;
            $project_summary['created_by'] = $project_summary['updated_by'] = __CLASS__;
            $user_summary['created_by'] = $user_summary['updated_by'] = __CLASS__;
            $isotope_summary['created_by'] = $user_summary['updated_by'] = __CLASS__;

            $this->info("------> ".$reportType." Specimen Stats");
            $this->info(json_encode($se_summary));
            $this->info("------> ".$reportType." DNA Stats");
            $this->info(json_encode($dna_summary));
            $this->info("------> ".$reportType." Project Stats");
            $this->info(json_encode($project_summary));
            $this->info("------> ".$reportType." User Stats");
            $this->info(json_encode($user_summary));
            $this->info("------> ".$reportType." Isotope Stats");
            $this->info(json_encode($isotope_summary));

            // Uncomment the 3 lines below when ready to move to PROD
            DailyWeeklyMonthlySummary::create(['org_id'=>$project->org->id, 'project_id'=>$project->id,
                'created_by'=> __CLASS__, 'updated_by'=> __CLASS__,
                'type'=>$reportType,
                'specimen_stats'=>json_encode($se_summary),
                'dna_stats'=>json_encode($dna_summary),
                'project_stats'=>json_encode($project_summary),
                'user_stats'=>json_encode($user_summary),
                'isotope_stats'=>json_encode($isotope_summary)]);

            $this->info($this->name." succeeded for ".$project->name);
        } catch (QueryException $ex) {
            $this->info($this->name." failed for ".$project->name);
            return;
        }
    }
}
