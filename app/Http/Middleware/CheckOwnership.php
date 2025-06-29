<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckOwnership
{
    /**
     * Handle an incoming request to check if the user owns the resource.
     *
     * @param Request $request
     * @param  \Closure  $next
     * @param string $modelClass
     * @param string $paramName
     * @return mixed
     */
    public function handle(Request $request, Closure $next, string $modelClass, string $paramName = 'id')
    {
        $user = Auth::user();

        // System admin has access to everything
        if ($user->user_type === 'system-admin') {
            return $next($request);
        }

        // Get the resource ID from request
        $resourceId = $request->input($paramName) ?? $request->route($paramName);

        if (!$resourceId) {
            abort(400, 'রিসোর্স আইডি প্রদান করা হয়নি।');
        }

        // Find the model instance
        $model = $modelClass::find($resourceId);

        if (!$model) {
            abort(404, 'রিসোর্স খুঁজে পাওয়া যায়নি।');
        }

        // For operators, check if they created the resource
        if ($user->user_type === 'operator') {
            if ($model->created_by !== $user->id) {
                abort(403, 'আপনি শুধুমাত্র নিজের তৈরি করা রিসোর্স পরিবর্তন করতে পারেন।');
            }
        }

        // For drivers, deny access
        if ($user->user_type === 'driver') {
            abort(403, 'ড্রাইভারদের এই রিসোর্স পরিবর্তনের অনুমতি নেই।');
        }

        return $next($request);
    }
} 