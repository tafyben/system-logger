<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Log;
use App\Models\LogType;
use App\Models\System;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Activitylog\Models\Activity;

class LogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $logs = Log::with(['user', 'type', 'system', 'department'])
            ->orderBy('event_time', 'desc')
            ->paginate(10);

        return view('logs.index', compact('logs'));
    }

    public function create()
    {
        $systems = System::orderBy('name')->get();
        $types = LogType::all();
        $departments = Department::all();
        return view('logs.create', compact('types', 'systems', 'departments'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'log_type_id' => 'required|exists:log_types,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'system_id' => 'required|exists:systems,id',
            'department_id' => 'required|exists:departments,id',

            'changes' => 'nullable|array',
            'event_time' => 'required|date',
            'notes' => 'nullable|string', // new
        ]);



        // Add location_id from department
        $department = Department::findOrFail($validated['department_id']);
        $validated['location_id'] = $department->location_id;

        // making sure user is tracked
        $validated['user_id'] = Auth::id();
        Log::create($validated);

        return redirect()->route('logs.index')->with('success', 'Log entry added successfully.');
    }

    public function edit(Log $log)
    {
        // Fetch types for dropdown
        $systems = System::orderBy('name')->get();
        $types = \App\Models\LogType::all();
        $departments = Department::all();

        return view('logs.edit', compact('log', 'types', 'systems', 'departments'));
    }


    public function update(Request $request, Log $log)
    {

        $request->validate([
            'log_type_id'     => 'required|exists:log_types,id',
            'title'           => 'required|string|max:255',
            'description'     => 'nullable|string',
            'system_id'       => 'required|exists:systems,id',
            'department_id'   => 'required|exists:departments,id',
            'event_time'      => 'required|date',
            'notes'           => 'nullable|string', // new
        ]);

        $log->update($request->only([
            'log_type_id',
            'title',
            'description',
            'system_id',
            'department_id',
            'event_time',
            'notes',
        ]));

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
    public function destroy($id)
    {
        $log = Log::findOrFail($id);
        $log->delete(); // soft delete
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


    public function audit(Request $request)
    {
        $query = Activity::with('causer')->where('log_name', 'log')->orderBy('created_at', 'desc');

        // Filters
        if ($request->filled('action')) {
            $query->where('description', 'like', "%{$request->action}%");
        }

        if ($request->filled('user_id')) {
            $query->where('causer_id', $request->user_id);
        }

        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $histories = Activity::with('causer', 'subject')
            ->where('log_name', 'log_changes') // matches model
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        $users = \App\Models\User::all();

        return view('logs.audit', compact('histories', 'users'));
    }




}
