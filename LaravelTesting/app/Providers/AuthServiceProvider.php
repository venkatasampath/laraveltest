<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model'             => 'App\Policies\ModelPolicy',
        'App\User'              => 'App\Policies\UserPolicy',
        'App\Org'               => 'App\Policies\OrgPolicy',
        'App\Profile'           => 'App\Policies\ProfilePolicy',
        'App\SkeletalElement'   => 'App\Policies\SkeletalElementPolicy',
        'App\Project'           => 'App\Policies\ProjectPolicy',
        'App\Accession'         => 'App\Policies\AccessionPolicy',
        'App\Instrument'        => 'App\Policies\InstrumentPolicy',
        'App\Haplogroup'        => 'App\Policies\HaplogroupPolicy',
        'App\Dna'               => 'App\Policies\DnaPolicy',
        'App\Isotope'           => 'App\Policies\IsotopePolicy',
        'App\IsotopeBatch'      => 'App\Policies\IsotopeBatchPolicy',
        'App\MissingPerson'     => 'App\Policies\MissingPersonPolicy',


//        'App\Role'              => 'App\Policies\RolePolicy',
//        'App\Eula'              => 'App\Policies\EulaPolicy',
//        'App\Taphonomy'         => 'App\Policies\TaphonomyPolicy',
//        'App\Articulation'      => 'App\Policies\ArticulationPolicy',
//        'App\Haplogroup'        => 'App\Policies\HaplogroupPolicy',
        'App\Pathology'         => 'App\Policies\PathologyPolicy',
//        'App\Method'            => 'App\Policies\MethodPolicy',
//        'App\MethodFeature'     => 'App\Policies\MethodFeaturePolicy',
//        'App\Measurement'       => 'App\Policies\MeasurementPolicy',
//        'App\Zone'              => 'App\Policies\ZonePolicy',
        'App\Trauma'            => 'App\Policies\TraumaPolicy',
//        'App\Anomaly'           => 'App\Policies\AnomalyPolicy',
//        'App\Task'              => 'App\Policies\TaskPolicy',
//        'App\TaskAssignment'    => 'App\Policies\TaskAssignmentPolicy'
        'App\Tag'               => 'App\Policies\TagPolicy',
        'App\Comment'           => 'App\Policies\CommentPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //
    }
}
