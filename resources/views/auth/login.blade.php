<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login HelpDeskKu</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="card shadow-sm">
                    <div class="card-body p-4">
                        <h2 class="mb-1">
                            Login
                        </h2>

                        <p class="text-muted mb-4">
                            HelpDeskKu
                        </p>

                        @if ($errors->any())
                        <div class="alert alert-danger">
                            {{ $errors->first() }}
                        </div>
                        @endif

                        <form action="/login" method="POST">

                        @csrf

                        <div class="mb-3">
                            <label class="form-label">
                                Email
                            </label>

                            <input type="email" name="email" class="form-control" value="{{ old('email') }}" placeholder="Masukkan email">
                            
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Password</label>

                            <input type="password" name="password" class="form-control" placeholder="Masukkan password">
                        </div>

                        <button type="submit" class="btn btn-primary w-100">Login</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>