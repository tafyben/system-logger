<?php

namespace App\Http\Controllers;

use App\Models\Log;
use App\Models\LogType;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Counts
        $stats = [
            'total_logs'   => Log::count(),
            'deleted_logs' => Log::onlyTrashed()->count(), // if using SoftDeletes
            'users'        => User::count(),
            'systems'      => LogType::count(),
        ];

        // Recent logs (latest 5)
        $recentLogs = Log::with(['user', 'type'])
            ->latest()
            ->take(5)
            ->get()
            ->map(function ($log) {
                return [
                    'title' => $log->title,
                    'type'  => $log->type->name ?? 'N/A',
                    'user'  => $log->user->name ?? 'System',
                    'time'  => $log->created_at->diffForHumans(),
                ];
            });

        // Chart Data: logs count by type
        $logsByType = LogType::withCount('logs')->get();
        $chartData = [
            'labels' => $logsByType->pluck('name'),
            'data'   => $logsByType->pluck('logs_count'),
        ];

        // Chart Data: logs created per day (last 7 days)
        $logsPerDay = Log::selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->where('created_at', '>=', now()->subDays(7))
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        $chartLogsPerDay = [
            'labels' => $logsPerDay->pluck('date'),
            'data'   => $logsPerDay->pluck('count'),
        ];

        return view('dashboard', compact('stats', 'recentLogs', 'chartData', 'chartLogsPerDay'));
    }
}
