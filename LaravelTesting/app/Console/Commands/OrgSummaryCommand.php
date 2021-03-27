<?php

/**
 * OrgSummaryCommand Class derived from Command
 *
 * @category   Org Summary Command
 * @package    Commands
 * @author     Sachin Pawaskar<spawaskar@unomaha.edu>
 * @copyright  2016-2019
 * @license    The MIT License (MIT)
 * @version    GIT: $Id$
 * @since      File available since Release 1.1.0
 */

namespace App\Console\Commands;

use App\OrgSummary;

/**
 * Class OrgSummaryCommand
 * @package App\Console\Commands
 *
 * This Command creates the org summary records with summary information such as Specimens, DNA, etc.
 * This summary information will typically be used to display Org Admin Dashboard information
 * It can also be used to send daily or weekly digest emails.
 *
 * This Command should typically be called as a scheduled cron job on a nightly basis.
 *
 * Example usage: php artisan cora:org-summary --org=all
 *              : php artisan cora:org-summary --org=DPAA
 *
 */
class OrgSummaryCommand extends CoraBaseCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cora:org-summary {--confirm}
                    {--D|daily : Calculate Daily org summary, by default}
                    {--O|org=all : All projects in a specific org by acronym, all orgs by default}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Calculate Daily Org Summary Information such as se_total, se_num_complete, se_dna_sampled, etc.';

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
    protected function handleForOrg($org)
    {
        try {
            $arr['created_by'] = $arr['updated_by'] = __CLASS__;

            $se_summary = $org->generateSESummary() + $arr;
            $dna_summary = $org->generateDNASummary() + $arr;
            $user_summary = $org->generateUserSummary() + $arr;
            $project_summary = $org->generateProjectSummary() + $arr;
            $isotope_summary = $org->generateIsotopeSummary()+ $arr;


            OrgSummary::create(['org_id'=>$org->id,
                'created_by'=> __CLASS__, 'updated_by'=> __CLASS__,
                'specimen_stats'=>json_encode($se_summary),
                'dna_stats'=>json_encode($dna_summary),
                'user_stats'=>json_encode($user_summary),
                'project_stats'=>json_encode($project_summary),
                'isotope_stats'=>json_encode($isotope_summary)]);

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

//            // Testing purposes
//            $this->info("Array: ".$org->name);
//            $arr_se = json_decode($json_se);
//            dd([$se_summary, $arr_se, $json_se]);
            $this->info($this->name." succeeded for ".$org->name);
        } catch (QueryException $ex) {
            $this->info($this->name." failed for ".$org->name);
            return;
        }
    }
}
