<?php

namespace App\Http\Middleware\Users;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;

class VerifyUserExists
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        $id = $request->route('id');

        if (
            User::query()->where('id', $id)->doesntExist()
        ) {
            return response()->json([
                'message' => 'User not found'
            ], 404);
        }

        return $next($request);
    }
}
