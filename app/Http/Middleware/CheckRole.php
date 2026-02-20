<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckRole
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        if (!$request->user()) {
            return redirect('/login');
        }

        $user = $request->user();
        if (!$user->role) {
            $user->role = 'admin';
            $user->save();
        }

        // Flatten the roles array - handle both comma and pipe separated roles
        $allRoles = [];
        foreach ($roles as $role) {
            // Split by comma or pipe
            $splitRoles = preg_split('/[|,]/', $role);
            foreach ($splitRoles as $r) {
                $r = trim($r);
                if (!empty($r)) {
                    $allRoles[] = $r;
                }
            }
        }

        if (!in_array($user->role, $allRoles)) {
            abort(403, 'Unauthorized action.');
        }

        return $next($request);
    }
}
