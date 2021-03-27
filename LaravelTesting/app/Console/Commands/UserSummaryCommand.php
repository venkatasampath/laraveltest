<?php

/**
 * ProjectSummaryCommand Class derived from Command
 *
 * @category   User Summary Command
 * @package    Commands
 * @author     Sachin Pawaskar<spawaskar@unomaha.edu>
 * @copyright  2016-2019
 * @license    The MIT License (MIT)
 * @version    GIT: $Id$
 * @since      File available since Release 1.0.0
 */

namespace App\Console\Commands;

use App\UserSummary;

/**
 * Class UserSummaryCommand
 * @package App\Console\Commands
 *
 * This Command creates the user summary records with summary information such as Specimens, DNA, etc.
 * This summary information will typically be used to display User Dashboard information
 * It can also be used to send daily or weekly digest emails.
 *
 * This Command should typically be called as a scheduled cron job on a nightly basis.
 *
 * Example usage: php artisan cora:user-summary --org=all
 *              : php artisan cora:user-summary --org=DPAA
 *              : php artisan cora:user-summary --user="bnew@sna-intl.com"
 *
 */
class UserSummaryCommand extends CoraBaseCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cora:user-summary {--confirm}
                    {--D|daily : Calculate Daily user summary, by default}
                    {--O|org=all : All users in a specific org by acronym, all orgs by default}
                    {--U|user= : For a specific user}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Calculate Daily User Summary Information such as se_total, se_num_complete, se_dna_sampled, etc.';

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
     * Create the user summary information for the given user.
     * This includes summary information for Specimens, DNA,
     * Accessions, etc.
     *
     * @param $user
     */
    protected function handleForUser($user)
    {
        try {
            $arr['created_by'] = $arr['updated_by'] = __CLASS__;
            $se_summary = $user->generateSESummary() + $arr;
            $dna_summary = $user->generateDNASummary() + $arr;
            $project_summary = $user->generateProjectSummary() + $arr;
            $isotope_summary = $user->generateIsotopeSummary()+ $arr;

            UserSummary::create(['org_id'=>$user->org->id, 'user_id'=>$user->id,
                'created_by'=> __CLASS__, 'updated_by'=> __CLASS__,
                'specimen_stats'=>json_encode($se_summary),
                'dna_stats'=>json_encode($dna_summary),
                'project_stats'=>json_encode($project_summary),
                'isotope_stats'=>json_encode($isotope_summary)]);

            $this->info("------> Specimen Stats");
            $this->info(json_encode($se_summary));
            $this->info("------> DNA Stats");
            $this->info(json_encode($dna_summary));
            $this->info("------> Project Stats");
            $this->info(json_encode($project_summary));
            $this->info("------> Isotope Stats");
            $this->info(json_encode($isotope_summary));

//            // Testing purposes
//            $this->info("Array: ".$org->name);
//            $arr_se = json_decode($json_se);
//            dd([$se_summary, $arr_se, $json_se]);
            $this->info($this->name." succeeded for ".$user->name);
        } catch (QueryException $ex) {
            $this->info($this->name." failed for ".$user->name);
            return;
        }
    }
}
