<?php

namespace App\Http\Controllers;

use App\Models\Log;
use App\Models\LogType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $logs = Log::with(['user', 'type'])
            ->orderBy('event_time', 'desc')
            ->paginate(10);

        return view('logs.index', compact('logs'));
    }

    public function create()
    {
        $types = LogType::all();
        return view('logs.create', compact('types'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'log_type_id' => 'required|exists:log_types,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'affected_system' => 'required|string|max:255',
            'changes' => 'nullable|array',
            'event_time' => 'required|date'
        ]);

        $validated['user_id'] = Auth::id();

        Log::create($validated);

        return redirect()->route('logs.index')->with('success', 'Log entry added successfully.');
    }

    public function edit(Log $log)
    {
        // Fetch types for dropdown
        $types = \App\Models\LogType::all();

        return view('logs.edit', compact('log', 'types'));
    }


    public function update(Request $request, Log $log)
    {
        $request->validate([
            'log_type_id'     => 'required|exists:log_types,id',
            'title'           => 'required|string|max:255',
            'description'     => 'nullable|string',
            'affected_system' => 'required|string|max:255',
            'event_time'      => 'required|date',
        ]);

        $log->update($request->all());

        // Spatie automatically records this update with before/after in activity_log

        return redirect()->route('logs.index')
            ->with('success', 'Log updated successfully. Changes have been recorded.');
    }

    public function history(Log $log)
    {
        $activities = $log->activities()->latest()->get();
        $creator = $log->user; // Relationship from Log model

        return view('logs.history', compact('log', 'activities', 'creator'));
    }

    // Move to Trash
    public function destroy(Log $log)
    {
        $log->delete();
        return redirect()->route('logs.index')->with('success', 'Log moved to trash.');
    }

// View Trash
    public function trash()
    {
        $logs = Log::onlyTrashed()->latest()->paginate(10);
        return view('logs.trash', compact('logs'));
    }

// Restore from Trash
    public function restore($id)
    {
        $log = Log::onlyTrashed()->findOrFail($id);
        $log->restore();
        return redirect()->route('logs.trash')->with('success', 'Log restored successfully.');
    }

// Permanently Delete
    public function forceDelete($id)
    {
        $log = Log::onlyTrashed()->findOrFail($id);
        $log->forceDelete();
        return redirect()->route('logs.trash')->with('success', 'Log permanently deleted.');
    }




}
