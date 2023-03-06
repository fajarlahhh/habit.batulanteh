<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Pengguna;
use Illuminate\Http\Request;
use Illuminate\Session\TokenMismatchException;

class ApiToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if ($this->verify($request)) {
            return $next($request);
        }

        return response()->json([
            'status' => 'error',
            'data' => 'Api token tidak valid',
        ], 403);
    }

    public function verify($request): bool //optional return types
    {
        return Pengguna::select('id')->where('api_token', $request->header('Token'))->exists();
    }
}
