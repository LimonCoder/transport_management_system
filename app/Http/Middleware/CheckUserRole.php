<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckUserRole
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param  \Closure  $next
     * @param  string  ...$roles
     * @return mixed
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $userType = Auth::user()->user_type;

        if (!in_array($userType, $roles)) {
            abort(403, 'অননুমোদিত অনুরোধ। এই রিসোর্সে প্রবেশের জন্য আপনার অনুমতি নেই।');
        }

        return $next($request);
    }
} 