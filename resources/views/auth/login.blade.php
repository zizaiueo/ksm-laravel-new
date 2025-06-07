<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KSM Tirta Lestari Flamboyan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: url('{{ asset('images/background.jpg') }}') no-repeat center center fixed;
            background-size: cover;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .login-container {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 12px;
            box-shadow: 0 0 15px rgba(0,0,0,0.2);
            display: flex;
            max-width: 600px;
            width: 100%;
            padding: 30px;
        }
        .login-logo {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .login-logo img {
            max-width: 120px;
        }
        .login-form {
            flex: 2;
            padding-left: 20px;
        }
        .login-form h4 {
            margin-bottom: 20px;
        }
        .form-floating {
            margin-bottom: 15px;
        }
        .login-btn {
            background-color: #0d6efd;
            color: white;
        }
        .login-btn:hover {
            background-color: #0b5ed7;
        }
    </style>
</head>
<body>

<div class="login-container">
    <div class="login-logo">
        <img src="{{ asset('images/logo.jpg') }}" alt="Logo KSM">
    </div>
        <div class="login-form">
        <h4 class="text-center mb-4">LOGIN</h4>

        {{-- Notifikasi error login --}}
        @if ($errors->has('username'))
            <div class="alert alert-danger">
                {{ $errors->first('username') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="form-floating">
                <input type="text" name="username" id="username" class="form-control" placeholder="Username" required autofocus value="{{ old('username') }}">
                <label for="username">Username</label>
            </div>

            <div class="form-floating">
                <input type="password" name="password" id="password" class="form-control" placeholder="Password" required>
                <label for="password">Password</label>
            </div>

            <button type="submit" class="btn login-btn w-100">Login</button>
        </form>
    </div>
</div>

</body>
</html>
