<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $userId = Auth::id();
        $today = now()->toDateString();

        $tasks = Task::where('user_id', $userId);

        $totalTasks = (clone $tasks)->count();

        $pendingTasks = (clone $tasks)
            ->where('status', 'pendente')
            ->count();

        $completedTasks = (clone $tasks)
            ->where('status', 'concluida')
            ->count();

        $todayTasks = (clone $tasks)
            ->whereDate('scheduled_date', $today)
            ->count();

        $upcomingTasks = (clone $tasks)
            ->whereDate('scheduled_date', '>=', $today)
            ->where('status', '!=', 'concluida')
            ->orderBy('scheduled_date')
            ->orderBy('start_time')
            ->take(5)
            ->get();

        return view('dashboard', compact(
            'totalTasks',
            'pendingTasks',
            'completedTasks',
            'todayTasks',
            'upcomingTasks'
        ));
    }
}
