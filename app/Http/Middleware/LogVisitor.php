<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\VisitorTable;

class LogVisitor
{
    public function handle($request, Closure $next)
    {
        $ip = $request->ip();
        VisitorTable::create([
            'ip_address' => $ip,
            'visit_time' => now()
        ]);

        return $next($request);
    }
}