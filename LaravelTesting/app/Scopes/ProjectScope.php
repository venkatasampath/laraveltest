<?php

namespace App\Scopes;

/**
 * Project Scope
 *
 * @category   Project Scope
 * @package    CoRA-Scopes
 * @author     Sachin Pawaskar<spawaskar@unomaha.edu>
 * @copyright  2016-2018
 * @license    The MIT License (MIT)
 * @version    GIT: $Id$
 * @since      File available since Release 1.0.0
 */

use App\Project;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

use App\User;
use Auth;

class ProjectScope implements Scope
{
    /**
     * Apply the scope to a given Eloquent query builder.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $builder
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @return void
     */
    public function apply(Builder $builder, Model $model)
    {
        $user = Auth::user();
        if (isset($user)) {
            $project_id = $user->getProfileValue('default_project');
            $project = $user->projects()->find($project_id);
            if (isset($project)) {
                $builder->where('project_id', '=', $project->id);
            }
        }
    }
}