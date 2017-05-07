<?php

namespace Smsapp\Http\Middleware;

use Log;
use Closure;

class TwilioSmsLogger
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
        return $next($request);
    }

    public function terminate($request, $response)
    {
        Log::info('requests', [
            'request' => $request->all(),
            'response' => $response
        ]);
    }
}
