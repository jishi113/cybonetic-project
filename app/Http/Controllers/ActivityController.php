<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Lead;
use Illuminate\Http\Request;

class ActivityController extends Controller
{
    public function store(Request $request, Lead $lead)
    {
        $request->validate([
            'type' => ['required', 'in:call,email,meeting,demo,follow_up,note'],
            'subject' => ['required', 'string', 'max:200'],
            'description' => ['nullable', 'string'],
            'occurred_at' => ['nullable', 'date'],
        ]);

        $lead->activities()->create([
            'user_id' => auth()->id(),
            'type' => $request->type,
            'subject' => $request->subject,
            'description' => $request->description,
            'occurred_at' => $request->occurred_at ?? now(),
        ]);

        return back()->with('success', 'Activity logged.');
    }

    public function destroy(Activity $activity)
    {
        if ($activity->user_id !== auth()->id() && auth()->user()->role !== 'admin') {
            abort(403);
        }

        $activity->delete();

        return back()->with('success', 'Activity removed.');
    }
}