<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use Illuminate\Http\Request;

class FeedbackController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $feedbacks = Feedback::with('user')->latest()->paginate(10);
        return view('feedback.index', compact('feedbacks'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = \App\Models\User::all();
        return view('feedback.create', compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Check if it's guest feedback or authenticated user feedback
        if ($request->has('guest_name') && $request->has('guest_email')) {
            // Guest feedback validation
            $request->validate([
                'guest_name' => 'required|string|max:255',
                'guest_email' => 'required|email|max:255',
                'feedback_text' => 'required|string|max:1000',
                'rating' => 'nullable|integer|min:1|max:5',
            ]);

            Feedback::create([
                'user_id' => $request->user_id ?: null,
                'guest_name' => $request->guest_name,
                'guest_email' => $request->guest_email,
                'feedback_text' => $request->feedback_text,
                'rating' => $request->rating,
            ]);

            return redirect('/')->with('success', 'Thank you for your feedback! We appreciate your input.');
        } else {
            // Authenticated user feedback validation
            $request->validate([
                'user_id' => 'required|exists:users,id',
                'feedback_text' => 'required|string|max:1000',
                'rating' => 'nullable|integer|min:1|max:5',
            ]);

            Feedback::create([
                'user_id' => $request->user_id,
                'feedback_text' => $request->feedback_text,
                'rating' => $request->rating,
            ]);

            return redirect()->route('feedback.index')->with('success', 'Feedback added successfully!');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    /**
     * Store feedback from user dashboard.
     * Auto-associates the authenticated user.
     */
    public function storeFromDashboard(Request $request)
    {
        $request->validate([
            'feedback_text' => 'required|string|max:1000',
            'rating' => 'nullable|integer|min:1|max:5',
        ]);

        Feedback::create([
            'user_id' => auth()->id(),
            'feedback_text' => $request->feedback_text,
            'rating' => $request->rating ?? null,
        ]);

        return redirect()->route('dashboard')->with('success', 'Thank you for your feedback! We appreciate your input.');
    }
}
