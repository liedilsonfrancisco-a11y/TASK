@push('styles')
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
@endpush

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="container py-4">
        <h3>Resumo das tarefas</h3>

        <div class="row g-3 my-3">
            <div class="col-12 col-md-6 col-lg-3">
                <div class="card p-3 h-100">
                    <h5>Total de tarefas</h5>
                    <p class="fs-3 mb-0">{{ $totalTasks }}</p>
                </div>
            </div>

            <div class="col-12 col-md-6 col-lg-3">
                <div class="card p-3 h-100">
                    <h5>Pendentes</h5>
                    <p class="fs-3 mb-0">{{ $pendingTasks }}</p>
                </div>
            </div>

            <div class="col-12 col-md-6 col-lg-3">
                <div class="card p-3 h-100">
                    <h5>Concluídas</h5>
                    <p class="fs-3 mb-0">{{ $completedTasks }}</p>
                </div>
            </div>

            <div class="col-12 col-md-6 col-lg-3">
                <div class="card p-3 h-100">
                    <h5>Agendadas para hoje</h5>
                    <p class="fs-3 mb-0">{{ $todayTasks }}</p>
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-between align-items-center mt-4 mb-3">
            <h3>Próximas tarefas</h3>

            <a href="{{ route('tasks.index') }}" class="btn btn-primary">
                Ver todas as tarefas
            </a>
        </div>

        @forelse ($upcomingTasks as $task)
            <div class="card p-3 mb-3">
                <h5>{{ $task->title }}</h5>

                @if ($task->scheduled_date)
                    <p class="mb-1">
                        Data: {{ $task->scheduled_date->format('d/m/Y') }}
                    </p>
                @endif

                @if ($task->start_time)
                    <p class="mb-1">
                        Início: {{ substr($task->start_time, 0, 5) }}
                    </p>
                @endif

                <p class="mb-0">
                    Prioridade: {{ ucfirst($task->priority) }}
                </p>
            </div>
        @empty
            <p>Ainda não tens tarefas futuras por concluir.</p>
        @endforelse

        <a href="{{ route('tasks.index') }}" class="btn btn-success mt-2">
            + Criar uma tarefa
        </a>
    </div>
</x-app-layout>