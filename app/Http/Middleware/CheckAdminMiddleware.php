<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

use App\Helpers\ApiResponse;

class CheckAdminMiddleware
{
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        $user = $request->user();

        if (!$user || !in_array($user->role->code, $roles)) {
            return ApiResponse::error('Unauthorized', 403);
        }

        return $next($request);
    }
}
