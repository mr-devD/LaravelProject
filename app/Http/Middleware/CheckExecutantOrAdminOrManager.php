<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckExecutantOrAdminOrManager
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->user() && ($request->user()->type_id === 1 || $request->user()->type_id === 2)) {
            return $next($request);
        }

        if ($request->user()->type_id === 3) {
            $tasks = $request->user()->tasks;
            $flag = 0;
            $request_id = (int)$request->id;
            foreach ($tasks as $task) {
                if ($request_id == $task->id) {
                    $flag = 1;
                    break;
                }
            }
            if ($flag == 1) {
                return $next($request);
            }
        }

        abort(403, 'NO ACCESS');
    }
}
