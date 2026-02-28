<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UtilityController extends Controller
{
    public function checkRole()
    {
        if (!auth()->check()) {
            return 'Not logged in';
        }

        $user = auth()->user();

        return [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'role' => $user->role ?? 'NO ROLE SET'
        ];
    }

    public function setAdmin()
    {
        if (!auth()->check()) {
            return 'Please login first';
        }

        $user = auth()->user();
        $user->role = 'admin';
        $user->save();

        return 'Success! You are now admin. Role: ' . $user->role;
    }

    public function dashboard()
    {
        $user = auth()->user();

        if ($user->role === 'admin') {
            return view('dashboard');
        } elseif ($user->role === 'manager') {
            return view('dashboard.manager');
        } else {
            return view('dashboard.user');
        }
    }
}