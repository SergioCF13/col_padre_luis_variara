<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Acceso administrativo | Colegio Padre Luis Variara</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@4.0.0-beta3/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <style>
        body { min-height: 100vh; display: grid; place-items: center; background: #142c36; }
        .login-box { width: min(410px, calc(100% - 32px)); }
        .login-logo { color: #fff; font-size: 22px; font-weight: 700; }
        .login-logo i { color: #d3f36b; }
        .login-card-body { border-radius: 4px; }
    </style>
</head>
<body>
    <main class="login-box">
        <h1 class="login-logo"><i class="fa-solid fa-book-open"></i> Colegio Padre Luis Variara</h1>
        <div class="card">
            <div class="card-body login-card-body">
                <p class="login-box-msg">Acceso al panel de administración</p>
                @if ($errors->any())
                    <div class="alert alert-danger" role="alert">{{ $errors->first() }}</div>
                @endif
                <form method="POST" action="{{ route('admin.login.store') }}">
                    @csrf
                    <div class="input-group mb-3">
                        <input class="form-control" type="email" name="email" value="{{ old('email') }}" placeholder="Correo electrónico" autocomplete="username" required autofocus>
                        <div class="input-group-text"><i class="fa-regular fa-envelope"></i></div>
                    </div>
                    <div class="input-group mb-3">
                        <input class="form-control" type="password" name="password" placeholder="Contraseña" autocomplete="current-password" required>
                        <div class="input-group-text"><i class="fa-solid fa-lock"></i></div>
                    </div>
                    <label class="form-check mb-3"><input class="form-check-input" type="checkbox" name="remember" value="1"><span class="form-check-label">Mantener sesión iniciada</span></label>
                    <button class="btn btn-primary w-100" type="submit">Ingresar</button>
                </form>
                <a class="d-inline-block mt-3 small" href="{{ route('home') }}"><i class="fa-solid fa-arrow-left"></i> Volver al sitio</a>
            </div>
        </div>
    </main>
</body>
</html>