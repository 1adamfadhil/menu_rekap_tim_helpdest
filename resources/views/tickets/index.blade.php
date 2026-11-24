<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HelpDesku - Tickets</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

    <div class="container py-5">

        <div class="d-flex justify-content-between align-items-center mb-4">
            @if (Auth::user()->role === 'admin')
                <p>Login sebagai: <strong>{{ Auth::user()->name }}</strong>
                    ({{ Auth::user()->role }})
                </p>
            @endif

            <form action="/logout" method="POST" class="mb-3">

                @csrf

                <button type="submit" class="btn btn-danger">Logout</button>
            </form>
        </div>

        <div class="d-flex justify-content-between align-items-center mb-4">

            <div>
                <h2 class="mb-1">Daftar Ticket</h2>
                <p class="text-muted mb-0">
                    Daftar Laporan HelpDesKu
                </p>
            </div>
            <a href="/tickets/create" class="btn btn-primary">
                + Buat Ticket
            </a>
        </div>

        <div class="card shadow-sm">
            <div class="card-body">

                <div class="table-responsive">
                    <table class="table table-hover align-middle">

                        <thead>
                            <tr>
                                <th>No Ticket</th>
                                <th>Judul</th>
                                <th>User</th>
                                <th>Agent</th>
                                <th>Kategori</th>
                                <th>Priority</th>
                                <th>Status</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse ($tickets as $ticket)
                                <tr>
                                    <td><a href="/tickets/{{ $ticket->id }}">
                                            <strong>{{ $ticket->ticket_number }}</strong></a></td>
                                    <td>{{ $ticket->title }}</td>
                                    <td>{{ $ticket->user->name }}</td>
                                    <td>{{ $ticket->agent?->name ?? 'Belum ditugaskan' }}</td>
                                    <td>{{ $ticket->category->name }}</td>
                                    <td>{{ $ticket->priority }}</td>
                                    <td>{{ ucfirst(str_replace('_', ' ', $ticket->status)) }}</td>
                                </tr>
                            @empty

                                <tr>
                                    <td colspan="7" class="text-center py-4">Belum ada ticket</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
