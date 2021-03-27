<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use Log;

class VerifyUserOrgAndProject
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $org = $request->session()->get('org');
        $currentProject = $request->session()->get('currentProject');
        $user = Auth::user();
//        dd([$request->session()->get('user'), $org, $currentProject, $user]);
        if (isset($user)) {
            if ($user->org->id !== $org->id || $user->currentProject !== $currentProject) {
                Log::info(__METHOD__.' Middleware Failed for '.$user->org->acronym.':'.$user->name);
                return redirect('/logout');
            }

        }

        return $next($request);
    }
}
