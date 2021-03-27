<?php

/**
 * CoraBaseCommand Class derived from Command
 *
 * @category   Cora Base Command
 * @package    Commands
 * @author     Sachin Pawaskar<spawaskar@unomaha.edu>
 * @copyright  2016-2019
 * @license    The MIT License (MIT)
 * @version    GIT: $Id$
 * @since      File available since Release 1.1.0
 */

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Project;
use App\Org;
use App\User;

/**
 * Class CoraBaseCommand
 * @package App\Console\Commands
 *
 * The Cora Commad should never be called directly. This is a base class that provides
 * boilerplate code/functionality for derived classes to use which is common for
 * the Cora project such as handling of orgs and projects level processing.
 *
 * Example usage: php artisan cora:project-summary --org=all
 *              : php artisan cora:project-summary --org=DPAA
 *              : php artisan cora:project-summary --project="USS Oklahoma"
 *              : php artisan cora:project-summary --report-type=Daily
 *              : php artisan cora:project-summary --report-type=Daily --project="USS Oklahoma"
 *              : php artisan cora:project-summary --report-type=Daily --org=DPAA
 *
 * Note: Daily option not implement as yet, Not sure if it makes sense
 *       Probably need as option to do daily over time, meaning previous months/years of data.
 */
class CoraBaseCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cora:base {--confirm}
                    {--O|org=all : All projects in a specific org by acronym, e.g. "UNO", "DPAA", all orgs by default}
                    {--P|project= : For a specific project, e.g. "CoRA Demo", "USS Oklahoma"}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cora Base Command, should never be called directly.';

    /**
     * The size of analytics results
     */
    protected $sizeofanalyticsresults = 4096;

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
     * Executes the console command.
     * This method will find all orgs (this is the default) or a given org or a project.
     * It calls the handleOrg function which then handles processing for a given org
     * If org:all is provided, it will iterate over all the projects in the org.
     * If org:acronym is provided, it will iterate over all the projects in org.
     * If project:name is provided, it will call the handleForProject method.
     */
    public function handle()
    {
        $this->info("Running CoRA Command - ". $this->name ."...");

        if ($this->option('org')) {
            if (strtolower($this->option('org')) === "all") {
                //cora:org-summary and cora:user-summary do not have 'project' option,
                //cora:org-summary and cora:project-summary do not have 'user' option,
                // so we need to test if a command has user or project option
                //before testing ! $this->option('project') or ! $this->option('project')
                if (((array_key_exists('user', $this->getDefinition()->getOptions())) && ! $this->option('user'))
                      || ((array_key_exists('project', $this->getDefinition()->getOptions())) && ! $this->option('project'))
                      || !((array_key_exists('project', $this->getDefinition()->getOptions()))
                            || ((array_key_exists('user', $this->getDefinition()->getOptions()))))) {
                    $orgs = Org::all();
                    $confirm_continue = true;
                    if ($this->option('confirm')) {
                        $confirm_continue = $this->confirm('Do you wish to run this command for all Orgs and Projects?');
                    }

                    if ($confirm_continue) {
                        $bar = $this->output->createProgressBar(count($orgs));
                        foreach($orgs as $org) {
                            $bar->advance();
                            $this->handleForOrg($org);
                        }
                        $bar->finish();
                        $this->info("\nCompleted all Org :".$orgs->count());
                    }
                }
            } else {
                $org = Org::where('acronym', $this->option('org'))->get()->first();
                $this->handleForOrg($org);
            }
        }
        // Test if a command has 'project' option
        if ((array_key_exists('project', $this->getDefinition()->getOptions())) && $this->option('project')) {
            $project = Project::where('name', $this->option('project'))->get()->first();
            if (!isset($project)) {
                $this->error("Project not found - ".$this->option('project'));
            } else {
                $this->handleForProject($project, $project->org);
            }
        }
        // Test if a command has 'user' option
        if ((array_key_exists('user', $this->getDefinition()->getOptions())) && $this->option('user')) {
            $user = User::where('email', $this->option('user'))
                ->where('active', true)->get()->first();
            if (!isset($user)) {
                $this->error("User not found - ".$this->option('user'));
            } else {
                    $this->handleForUser($user);
            }
        }
    }

    /**
     * This method will handle processing for a given org only. It will iterate
     * over all the projects in org and call the handleForProject method.
     *
     * @param $org
     */
    protected function handleForOrg($org)
    {
        if (!isset($org)) {
            $this->error("Org not found - ".$this->option('org'));
        } else {
            $this->info("\n");
            $confirm_continue = true;
            if ($this->option('confirm')) {
                $confirm_continue = $this->confirm('This Org ['.$org->name.'] has '.$org->projects->count().' project(s), Do you wish to continue?');
            }

            if ($confirm_continue) {
                $this->info("Handling for Org ".$org->acronym.":".$org->name);
                //Test if the command is a user summary
                if($this->getName() === "cora:user-summary"){
                    $bar = $this->output->createProgressBar(count($org->users));
                    foreach($org->users as $user) {
                        $bar->advance();
                        //test if the user is an active user
                        if($user->isActive())
                            $this->handleForUser($user);
                    }
                } else {
                    $bar = $this->output->createProgressBar(count($org->projects));
                    foreach($org->projects as $project) {
                        $bar->advance();
                        $this->handleForProject($project, $org);
                    }
                }
                $bar->finish();
                $this->info("\nCompleted Org :".$org->acronym." - ".$org->name);
            }
        }
    }

    /**
     * This method will handle processing for a given project only. It will call the handleWork
     * method which should be overridden by derived class where the actual work is performed
     *
     * @param $project
     * @param $org
     */
    protected function handleForProject($project, $org)
    {
        if (!isset($project)) {
            $this->error("Project not found - isset");
        } else {
            $this->info("\nHandling ".$this->name ." for ".$org->acronym.":".$project->name);
            //If se-refits-using-zones command, default max-overlap-number to 3 if not provided
            $params = array();
            if($this->getName() === "cora:se-refits-using-zones"){
                $params["max-overlap-number"] = $this->option('max-overlap-number');
                $params["refit-matches-number"] = $this->option('refit-matches-number');
                $this->handleAnalyticsWork($project, $params);
            }
            if($this->getName() === "cora:se-articulations"){
                $params["max-articulations-per-sb"] = $this->option('max-articulations-per-sb');
                $this->handleAnalyticsWork($project, $params);
            }
            if($this->getName() === "cora:se-pairmatching" || $this->getName() === "cora:se-methodfeature"){
                $this->handleAnalyticsWork($project, $params);
            }
            //If the command consists of a project-summary and report-type option is not provided
            //then it generates overall project summary and records are stored in project_summary table
            //otherwise, the command generates summary for the given type of report (daily, weekly, or monthly)
            //and summary records are stored in daily_weekly_monthly_summary table.
            elseif(((array_key_exists('report-type', $this->getDefinition()->getOptions())) && !$this->option('report-type'))
                || !(array_key_exists('report-type', $this->getDefinition()->getOptions()))) {
                $this->handleWork($project);
            }
            else{
                $reportType = strtolower($this->option('report-type'));
                $this->handleDailyWeeklyMonthlyWork($project, $reportType);
            }
        }
    }

    /**
     * This method must be overridden by the derived class
     * to do the actual work for any given user.
     *
     * @param $user
     */
    protected function handleForUser($user)
    {

    }

    /**
     * This method must be overridden by the derived class
     * to do the actual work for any given project.
     *
     * @param $project
     */
    protected function handleWork($project)
    {
        // Do your work here.
    }

    /**
     * This method must be overridden by the derived class
     * to do the actual work for any given project.
     *
     * @param $project
     * @param $reportType
     */
    protected function handleDailyWeeklyMonthlyWork($project, $reportType)
    {
        // Do your work here.
    }

    /**
     * This method must be overridden by the derived class
     * to do the actual work for any given project.
     * $params is an array containing all different params for analytics command
     *
     * @param $project
     * @param $params
     */
    protected function handleAnalyticsWork($project, $params)
    {
        // Do your work here.
    }
}
