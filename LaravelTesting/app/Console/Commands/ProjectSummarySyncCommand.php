<?php

/**
 * ProjectSummarySyncCommand Class derived from Command
 *
 * @category   Project Summary Sync Command
 * @package    Commands
 * @author     Sachin Pawaskar<spawaskar@unomaha.edu>
 * @copyright  2016-2019
 * @license    The MIT License (MIT)
 * @version    GIT: $Id$
 * @since      File available since Release 1.0.0
 */

namespace App\Console\Commands;

use App\ProjectSummarySE;
use App\ProjectSummaryDNA;
use App\ProjectSummary;

/**
 * Class ProjectSummarySyncCommand
 * @package App\Console\Commands
 *
 * This Command syncs the project summary records with summary information such as Specimens, DNA, etc.
 * This summary information will typically be used to display Project/Org Admin Dashboard information
 * It can also be used to send daily or weekly digest emails.
 *
 * This Command should typically be called once to fix imported Specimen data.
 * This was needed for the USS Oklahoma project, For most other projects
 * where data is entered via CoRA we will not run into this issue as
 * it is automatically handled by CoRA business layer which is
 * typically implemented in the SkeletalElement controller.
 *
 * Example usage: php artisan cora:project-summary-sync --org=all
 *              : php artisan cora:project-summary-sync --org=DPAA
 *              : php artisan cora:project-summary-sync --project="USS Oklahoma"
 *
 */
class ProjectSummarySyncCommand extends CoraBaseCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cora:project-summary-sync {--confirm}
                    {--D|daily : Calculate Daily project summary, by default}
                    {--O|org=all : All projects in a specific org by acronym, all orgs by default}
                    {--P|project= : For a specific project}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync the Daily Project Summary Information such as se_total, se_num_complete, se_dna_sampled, etc.';

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
            $se_summary = ProjectSummarySE::orderby('created_at')->get();
            $dna_summary = ProjectSummaryDNA::orderby('created_at')->get();

            $records_created_count = 0;
            foreach ($se_summary as $row) {
                $json_se = json_encode($row->getOriginal());
                $record = $dna_summary->where('created_at', "=", $row->created_at)
                    ->where('project_id', "=", $row->project_id);
                $json_dna = null;
                if ($record != null && $record->first() != null) {
                    $json_dna = json_encode($record->first()->getOriginal());
                }

                $new_summary = ProjectSummary::firstOrNew(['org_id'=>$org->id, 'project_id'=>$row->project_id, 'created_at'=>$row->created_at, 'updated_at'=>$row->updated_at,]);
                $data = array('org_id'=>$org->id, 'project_id'=>$row->project_id, 'created_by'=> __CLASS__, 'updated_by'=> __CLASS__,
                    'specimen_stats'=>$json_se, 'dna_stats'=>$json_dna);

                if (!$new_summary->exists) {
                    $new_summary->fill($data)->save();
                    $new_summary->created_at = $row->created_at;
                    $new_summary->updated_at = $row->updated_at;
                    $new_summary->save(['timestamps' => false]);
                    $records_created_count++;
                }
            }

            $this->info($se_summary->count()." records found, ".$records_created_count." created for Org:".$org->name);
            $this->info($this->name." succeeded for ".$org->name);
        } catch (QueryException $ex) {
            $this->info($this->name." failed for ".$org->name);
            return;
        }
    }
}
