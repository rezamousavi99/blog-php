<?php

namespace App\Http\Middleware;

use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureTokenIsNotExpired
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Get the current authenticated user's token
        $token = $request->user()->currentAccessToken();

        // Check if the token has an expiration date and if it has expired
        if ($token->expires_at && $token->expires_at->lt(now())) {
            // If the token has expired, revoke it and return an unauthorized response
            $token->delete();

            return response()->json(['message' => 'Your token has expired.'], 401);
        }

        return $next($request);
    }
}
