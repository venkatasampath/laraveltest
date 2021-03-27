<?php

/**
 * ForceHttps Middleware
 *
 * @category   ForceHttps
 * @package    CoRA-Middleware
 * @author     Sachin Pawaskar<spawaskar@unomaha.edu>
 * @copyright  2016-2018
 * @license    The MIT License (MIT)
 * @version    GIT: $Id$
 * @since      File available since Release 1.0.0
 */

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Log;

class ForceHttps
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
        if (config('app.env') === 'production') {
            Request::setTrustedProxies([$request->getClientIp()]); // for Proxies

            if (!$request->isSecure()) {
                Log::info(__METHOD__.' - NOT SECURE IP='.$request->getClientIp().' requestURI=['.$request->getRequestUri().']');
                $request->server->set('HTTPS', true);
                return redirect()->secure($request->getRequestUri());
            }
        }

        return $next($request);
    }
}
