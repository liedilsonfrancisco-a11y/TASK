<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class TaskController extends Controller
{
    public function index()
    {
        $tasks = Task::where('user_id', Auth::id())
            ->orderByRaw('scheduled_date IS NULL')
            ->orderBy('scheduled_date')
            ->orderBy('start_time')
            ->get();

        return view('tasks.index', compact('tasks'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'scheduled_date' => ['nullable', 'date'],
            'start_time' => ['nullable', 'date_format:H:i'],
            'end_time' => ['nullable', 'date_format:H:i'],
            'priority' => ['required', 'in:baixa,media,alta'],
        ]);

        if (
            !empty($validated['start_time']) &&
            !empty($validated['end_time']) &&
            $validated['end_time'] <= $validated['start_time']
        ) {
            throw ValidationException::withMessages([
                'end_time' => 'A hora de término deve ser posterior à hora de início.',
            ]);
        }

        $validated['user_id'] = Auth::id();

        Task::create($validated);

        return redirect()
            ->route('tasks.index')
            ->with('success', 'Tarefa criada com sucesso!');
    }
}
