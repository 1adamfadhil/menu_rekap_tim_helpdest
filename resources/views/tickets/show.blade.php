<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Detail Ticket</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

    <div class="container py-5">

        <a href="/tickets" class="btn btn-secondary mb-4">
            ← Kembali
        </a>

        <div class="card">
            <div class="card-body">

                <h2 class="mb-1">
                    {{ $ticket->title }}
                </h2>

                <p class="text-muted">
                    {{ $ticket->ticket_number }}
                </p>

                <hr>

                <div class="row mb-3">

                    <div class="col-md-6">
                        <strong>User</strong>
                        <p>{{ $ticket->user->name }}</p>
                    </div>

                    <div class="col-md-6">
                        <strong>Agent</strong>
                        <p>
                            {{ $ticket->agent?->name ?? 'Belum ditugaskan' }}
                        </p>
                    </div>

                    <div class="col-md-6">
                        <strong>Kategori</strong>
                        <p>{{ $ticket->category->name }}</p>
                    </div>

                    <div class="col-md-3">
                        <strong>Priority</strong>
                        <p>{{ ucfirst($ticket->priority) }}</p>
                    </div>

                    <div class="col-md-3">
                        <strong>Status</strong>
                        <p>
                            {{ ucfirst(str_replace('_', ' ', $ticket->status)) }}
                        </p>
                    </div>

                    @if (in_array(Auth::user()->role, ['admin', 'agent']))
                    <div class="col-md-6 mt-3">
                        <strong>Ubah Status</strong>

                        <form action="/tickets/{{ $ticket->id }}/status" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="input-group mt-2">
                                <select name="status" class="form-select">

                                    <option value="open" {{ $ticket->status == 'open' ? 'selected' : '' }}>
                                        Open
                                    </option>

                                    <option value="in_progress"
                                        {{ $ticket->status == 'in_progress' ? 'selected' : '' }}>
                                        In Progress
                                    </option>

                                    <option value="closed" {{ $ticket->status == 'closed' ? 'selected' : '' }}>
                                        Closed
                                    </option>

                                </select>

                                <button type="submit" class="btn btn-primary">
                                    Ubah Status
                                </button>
                            </div>
                        </form>
                    </div>
                    @endif

                    @if (Auth::user()->role === 'admin')
                    <div class="col-md-6 mt-3">
                        <strong>Assign Agent</strong>

                        <form action="/tickets/{{ $ticket->id }}/agent" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="input-group mt-2">
                                <select name="agent_id" class="form-select">
                                    <option value="">Pilih Agent</option>

                                    @foreach ($agents as $agent)
                                    <option
                                        value="{{ $agent->id }}" {{ $ticket->agent_id == $agent->id ? 'selected' : '' }}>
                                        {{ $agent->name }}
                                    </option>
                                    @endforeach
                                </select>

                                <button type="submit" class="btn btn-primary">
                                    Assign
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
                @endif

                <hr>
                <br>

                <h5>Deskripsi</h5>

                <p>
                    {{ $ticket->description }}
                </p>

                <div class="d-flex gap-2">

                    @if (Auth::user()->role === 'admin')
                    <a href="/tickets/{{ $ticket->id }}/edit" class="btn btn-warning">
                        Edit
                    </a>

                    <form action="/tickets/{{ $ticket->id }}" method="POST">
                        @csrf
                        @method('DELETE')

                        <button type="submit" class="btn btn-danger">
                            Hapus Ticket
                        </button>
                    </form>

                    @elseif (Auth::user()->role === 'agent' && $ticket->user_id !== Auth::id())
                    <a href="/tickets/{{ $ticket->id }}/edit" class="btn btn-warning">
                        Edit
                    </a>

                    <form action="/tickets/{{ $ticket->id }}" method="POST">
                        @csrf
                        @method('DELETE')

                        <button type="submit" class="btn btn-danger">
                            Hapus Ticket
                        </button>
                    </form>

                    @elseif (Auth::user()->role === 'user' && $ticket->user_id === Auth::id())
                    <a href="/tickets/{{ $ticket->id }}/edit" class="btn btn-warning">
                        Edit
                    </a>

                    <form action="/tickets/{{ $ticket->id }}" method="POST">
                        @csrf
                        @method('DELETE')

                        <button type="submit" class="btn btn-danger">
                            Delete
                        </button>
                    </form>
                    @endif

                </div>

                <hr class="my-4">

                <h5 class="mb-3">Komentar</h5>

                <form action="/tickets/{{ $ticket->id }}/comments" method="POST">
                    @csrf

                    @if ($errors->has('comment'))
                    <div class="alert alert-danger">
                        {{ $errors->first('comment') }}
                    </div>
                    @endif

                    <div class="mb-3">
                        <textarea name="comment" class="form-control" rows="3" placeholder="Tulis Komentar...">{{ old('comment') }}</textarea>
                    </div>

                    <button type="submit" class="btn btn-primary">
                        Kirim Komentar
                    </button>
                </form>

                <div class="mt-4">
                    @forelse ($ticket->comments as $comment)
                    <div class="border rounded p-3 mb-3">
                        <strong>{{ $comment->user->name }}</strong>

                        <small class="text-muted">
                            {{ $comment->created_at->format('d M Y H:i') }}
                        </small>

                        <p class="mb-0 mt-2">{{ $comment->comment }}</p>
                    </div>

                    @empty

                    <p class="text-muted">Belum ada komentar.</p>
                    @endforelse
                </div>
            </div>
        </div>

    </div>

</body>

</html>