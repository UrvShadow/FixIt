<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $user = auth()->user();

        $totalDevices = $user->devices()->count();

        $activeRepairs = $user->repairRequests()
            ->whereNotIn('status', ['completed', 'rejected', 'cancelled'])
            ->count();

        $completedRepairs = $user->repairRequests()
            ->where('status', 'completed')
            ->count();

        $recentRepairs = $user->repairRequests()
            ->with('device')
            ->latest()
            ->take(5)
            ->get();

        return view('dashboard', compact(
            'totalDevices',
            'activeRepairs',
            'completedRepairs',
            'recentRepairs'
        ));
    }
}