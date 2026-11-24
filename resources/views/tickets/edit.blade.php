<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Ticket</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

    <div class="container py-5">

        <a href="/tickets/{{ $ticket->id }}" class="btn btn-secondary mb-4"><- Kembali</a>

                <div class="card">
                    <div class="card-body">
                        <h2 class="mb-4">Edit Ticket</h2>

                        <form action="/tickets/{{ $ticket->id }}" method="POST">

                            @csrf

                            @method('PUT')

                            <div class="mb-3">
                                <label class="form-label">User</label>

                                <select name="user_id" class="form-select">

                                    @foreach ($users as $user)
                                        <option value="{{ $user->id }}"
                                            {{ $ticket->user_id == $user->id ? 'selected' : '' }}>
                                            {{ $user->name }}
                                        </option>
                                    @endforeach

                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Kategori</label>

                                <select name="category_id" class="form-select">

                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}"
                                            {{ $ticket->category_id == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach

                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Judul</label>

                                <input type="text" name="title" class="form-control" value="{{ $ticket->title }}">
                            </div>

                            <div class="mb-3">
                                <label for="form-label">Deskripsi</label>

                                <textarea name="description" class="form-control" rows="5">{{ $ticket->description }}</textarea>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Priority</label>

                                <select name="priority" class="form-select">

                                    <option value="low" {{ $ticket->priority == 'low' ? 'selected' : '' }}>
                                        Low
                                    </option>

                                    <option value="medium" {{ $ticket->priority == 'medium' ? 'selected' : '' }}>
                                        Medium
                                    </option>

                                    <option value="high"{{ $ticket->priority == 'high' ? 'selected' : '' }}>
                                        High
                                    </option>
                                </select>
                            </div>

                            <button type="submit" class="btn btn-danger">Simpan Perubahan</button>
                        </form>
                    </div>
                </div>
    </div>

</body>

</html>
