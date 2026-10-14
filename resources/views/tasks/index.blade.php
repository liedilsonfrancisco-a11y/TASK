
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Task | Minhas tarefas</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    <style>
        body {
            background: #f4f6fb;
            color: #20243a;
            min-height: 100vh;
        }

        .task-header {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            border-radius: 18px;
            padding: 28px;
        }

        .task-card {
            border: 0;
            border-radius: 16px;
            box-shadow: 0 4px 18px rgba(25, 35, 70, .06);
        }

        .form-control,
        .form-select {
            padding: 11px;
            border-radius: 10px;
        }

        .btn-task {
            background: #667eea;
            color: white;
            border: 0;
            border-radius: 10px;
            padding: 11px 20px;
        }

        .btn-task:hover {
            background: #5365ce;
            color: white;
        }

        .priority {
            font-size: .8rem;
            padding: 6px 10px;
            border-radius: 20px;
        }

        .priority-baixa {
            background: #e1f7e9;
            color: #187343;
        }

        .priority-media {
            background: #fff0cc;
            color: #8a5a00;
        }

        .priority-alta {
            background: #ffe0e0;
            color: #a32121;
        }
    </style>
</head>

<body>
    <main class="container py-4 py-md-5">

        <header class="task-header mb-4">
            <div class="d-flex flex-wrap justify-content-between align-items-center gap-3">
                <div>
                    <h1 class="h2 fw-bold mb-2">Minhas tarefas</h1>
                    <p class="mb-0">Organiza o teu dia, uma tarefa de cada vez.</p>
                </div>

                <a href="{{ route('dashboard') }}"
                   class="btn btn-light rounded-pill px-4">
                    Voltar ao dashboard
                </a>
            </div>
        </header>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close"
                        data-bs-dismiss="alert" aria-label="Fechar"></button>
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger">
                <strong>Verifica os seguintes campos:</strong>
                <ul class="mb-0 mt-2">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="row g-4">

            <div class="col-12 col-lg-5">
                <section class="card task-card">
                    <div class="card-body p-4">
                        <h2 class="h5 fw-bold mb-4">Criar nova tarefa</h2>

                        <form method="POST" action="{{ route('tasks.store') }}">
                            @csrf

                            <div class="mb-3">
                                <label for="title" class="form-label">Título *</label>
                                <input
                                    type="text"
                                    id="title"
                                    name="title"
                                    class="form-control"
                                    value="{{ old('title') }}"
                                    maxlength="255"
                                    required
                                    placeholder="Ex.: Estudar matemática"
                                >
                            </div>

                            <div class="mb-3">
                                <label for="description" class="form-label">
                                    Descrição
                                </label>
                                <textarea
                                    id="description"
                                    name="description"
                                    class="form-control"
                                    rows="3"
                                    placeholder="Detalhes da tarefa..."
                                >{{ old('description') }}</textarea>
                            </div>

                            <div class="mb-3">
                                <label for="scheduled_date" class="form-label">
                                    Data
                                </label>
                                <input
                                    type="date"
                                    id="scheduled_date"
                                    name="scheduled_date"
                                    class="form-control"
                                    value="{{ old('scheduled_date') }}"
                                >
                            </div>

                            <div class="row g-3 mb-3">
                                <div class="col-6">
                                    <label for="start_time" class="form-label">
                                        Início
                                    </label>
                                    <input
                                        type="time"
                                        id="start_time"
                                        name="start_time"
                                        class="form-control"
                                        value="{{ old('start_time') }}"
                                    >
                                </div>

                                <div class="col-6">
                                    <label for="end_time" class="form-label">
                                        Término
                                    </label>
                                    <input
                                        type="time"
                                        id="end_time"
                                        name="end_time"
                                        class="form-control"
                                        value="{{ old('end_time') }}"
                                    >
                                </div>
                            </div>

                            <div class="mb-4">
                                <label for="priority" class="form-label">
                                    Prioridade
                                </label>
                                <select
                                    id="priority"
                                    name="priority"
                                    class="form-select"
                                    required
                                >
                                    <option value="baixa"
                                        @selected(old('priority', 'media') === 'baixa')>
                                        Baixa
                                    </option>
                                    <option value="media"
                                        @selected(old('priority', 'media') === 'media')>
                                        Média
                                    </option>
                                    <option value="alta"
                                        @selected(old('priority', 'media') === 'alta')>
                                        Alta
                                    </option>
                                </select>
                            </div>

                            <button type="submit" class="btn btn-task w-100">
                                Criar tarefa
                            </button>
                        </form>
                    </div>
                </section>
            </div>

            <div class="col-12 col-lg-7">
                <section class="card task-card">
                    <div class="card-body p-4">
                        <h2 class="h5 fw-bold mb-4">Lista de tarefas</h2>

                        @forelse ($tasks as $task)
                            <article class="border rounded-3 p-3 mb-3">
                                <div class="d-flex flex-wrap justify-content-between
                                            align-items-start gap-2 mb-2">
                                    <h3 class="h6 fw-bold mb-0">
                                        {{ $task->title }}
                                    </h3>

                                    <span class="priority priority-{{ $task->priority }}">
                                        {{ ucfirst($task->priority) }}
                                    </span>
                                </div>

                                @if ($task->description)
                                    <p class="text-secondary mb-3">
                                        {{ $task->description }}
                                    </p>
                                @endif

                                <div class="small text-secondary mb-2">
                                    <div>
                                        <strong>Data:</strong>
                                        {{ $task->scheduled_date
                                            ? $task->scheduled_date->format('d/m/Y')
                                            : 'Não definida' }}
                                    </div>

                                    <div>
                                        <strong>Horário:</strong>
                                        {{ $task->start_time
                                            ? substr((string) $task->start_time, 0, 5)
                                            : '--:--' }}
                                        -
                                        {{ $task->end_time
                                            ? substr((string) $task->end_time, 0, 5)
                                            : '--:--' }}
                                    </div>

                                    <div>
                                        <strong>Estado:</strong>
                                        {{ ucfirst($task->status) }}
                                    </div>
                                </div>
                            </article>
                        @empty
                            <div class="text-center py-5">
                                <h3 class="h6 fw-bold">Ainda não tens tarefas</h3>
                                <p class="text-secondary mb-0">
                                    Cria a tua primeira tarefa no formulário.
                                </p>
                            </div>
                        @endforelse
                    </div>
                </section>
            </div>

        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
