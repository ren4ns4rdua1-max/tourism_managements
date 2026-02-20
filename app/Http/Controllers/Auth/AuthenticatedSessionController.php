<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        // Check if there's a redirect_to parameter in the request (from query string or hidden input)
        $redirectTo = $request->input('redirect_to');
        
        // If not in request, check session
        if (!$redirectTo) {
            $redirectTo = $request->session()->get('redirect_to');
        }
        
        // Store redirect_to in session for future use
        if ($redirectTo) {
            $request->session()->put('redirect_to', $redirectTo);
        }
        
        // If we have a redirect_to, use it
        if ($redirectTo) {
            $request->session()->forget('redirect_to');
            return redirect($redirectTo);
        }

        return redirect()->intended(route('dashboard', absolute: false));
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
