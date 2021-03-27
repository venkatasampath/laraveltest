<?php

namespace App\Scopes;

/**
 * Org Scope
 *
 * @category   Org Scope
 * @package    CoRA-Scopes
 * @author     Sachin Pawaskar<spawaskar@unomaha.edu>
 * @copyright  2016-2018
 * @license    The MIT License (MIT)
 * @version    GIT: $Id$
 * @since      File available since Release 1.0.0
 */

use App\Org;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

use App\User;
use Auth;

class OrgScope implements Scope
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
        if (isset($user) && !$user->isAdmin()) {
            $org = $user->org;
            if (isset($org)) {
                if ($model->getMorphClass() === 'App\Project') {
                    $builder->where('org_id', '=', $org->id)
                        ->orWhere('public', '=', true);
                } else {
                    $builder->where('org_id', '=', $org->id);
                }
            }
        }
    }
}