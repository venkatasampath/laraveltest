<?php

/**
 * AccessionSyncCommand Class derived from Command
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

use App\Accession;

/**
 * Class AccessionSyncCommand
 * @package App\Console\Commands
 *
 * This Command finds all the unique ANP1P2 combinations in a project by looking at the
 * Specimen (SE) table. If any ANP1P2 combination does not exist in the Accession
 * table for which there is a Specimen record then go ahead and create it.
 *
 * This Command should typically be called once to fix imported Specimen data.
 * This was needed for the USS Oklahoma project, For most other projects
 * where data is entered via CoRA we will not run into this issue as
 * it is automatically handled by CoRA business layer which is
 * typically implemented in the SkeletalElement controller.
 *
 * This can also be used as a Data Quality (Dq) check, as part of a weekly Dq job.
 *
 * Example usage: php artisan cora:accession-sync --org=all
 *              : php artisan cora:accession-sync --org=DPAA
 *              : php artisan cora:accession-sync --project="USS Oklahoma"
 *
 */
class AccessionSyncCommand extends CoraBaseCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cora:accession-sync {--confirm}
                    {--O|org=all : All projects in a specific org by acronym, all orgs by default}
                    {--P|project= : For a specific project}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Find all Unique Accessions in Specimens table and create corresponding records in Accession table for accession, provenance1 and provenance2';

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
     * Find all the unique ANP1P2 combinations in a project by looking at the Specimen
     * (SE) table. If any ANP1P2 combination does not exist in the Accession table
     * for which there is a Specimen record then go ahead and create it
     *
     * @param $project
     */
    protected function handleWork($project)
    {
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
}
