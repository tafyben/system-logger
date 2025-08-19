<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Example placeholder data (replace with real queries later)
        $stats = [
            'total_logs' => 120,
            'deleted_logs' => 15,
            'users' => 8,
            'systems' => 5,
        ];

        $recentLogs = [
            ['title' => 'Server Update', 'type' => 'Update', 'user' => 'Admin', 'time' => '2 mins ago'],
            ['title' => 'PC Added', 'type' => 'Create', 'user' => 'John Doe', 'time' => '10 mins ago'],
            ['title' => 'Website Patch', 'type' => 'Update', 'user' => 'Jane Doe', 'time' => '30 mins ago'],
        ];

        // Chart data placeholder
        $chartData = [
            'labels' => ['Logs', 'Deleted Logs', 'Users', 'Systems'],
            'values' => [$stats['total_logs'], $stats['deleted_logs'], $stats['users'], $stats['systems']]
        ];

        return view('dashboard', compact('stats', 'recentLogs', 'chartData'));
    }
}
