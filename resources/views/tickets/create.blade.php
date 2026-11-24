<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buat Ticket</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container py-5">

        <a href="/tickets" class="btn btn-secondary mb-4"><- Kembali</a>

                <div class="card">
                    <div class="card-body">
                        <h2 class="mb-4">Buat Ticket</h2>

                        @if ($errors->any())

                            <div class="alert alert-danger">
                                <strong>Terjadi kesalahan:</strong>

                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>

                        @endif

                        <form action="/tickets" method="POST">

                            @csrf

                            @if (Auth::user()->role === 'admin')
                                <div class="mb-3">
                                    <label class="form-label">User</label>
                                    <select name="user_id" class="form-select">
                                        <option value="">Pilih User</option>

                                        @foreach ($users as $user)
                                            <option value="{{ $user->id }}"
                                                {{ old('user_id') == $user->id ? 'selected' : '' }}>
                                                {{ $user->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            @endif

                            <div class="mb-3">
                                <label class="form-label">Kategori</label>

                                <select name="category_id" class="form-select">

                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}"
                                            {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach

                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Judul</label>

                                <input type="text" name="title" class="form-control" value="{{ old('title') }}"
                                    placeholder="Masukkan judul ticket">
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Deskripsi</label>

                                <textarea name="description" class="form-control" rows="5" placeholder="Jelaskan masalah yang dialami">{{ old('description') }}</textarea>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Priority</label>

                                <select name="priority" class="form-select">
                                    <option value="low" {{ old('priority', 'medium') == 'low' ? 'selected' : '' }}>
                                        Low</option>
                                    <option value="medium"
                                        {{ old('priority', 'medium' == 'medium') ? 'selected' : '' }}>Medium</option>
                                    <option value="high" {{ old('priority', 'medium') == 'high' ? 'selected' : '' }}>
                                        High</option>
                                </select>
                            </div>

                            <button type="submit" class="btn btn-primary">
                                Simpan Ticket
                            </button>

                        </form>

                    </div>
                </div>

    </div>
</body>

</html>
