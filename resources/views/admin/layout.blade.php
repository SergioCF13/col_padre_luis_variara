<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Administración') | Colegio Padre Luis Variara</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@4.0.0-beta3/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <style>
        :root { --adminlte-primary: #36595a; }
        .app-sidebar { background: #142c36; }
        .app-sidebar .nav-link.active { background: #d3f36b; color: #142c36; }
        .brand-link { border-color: rgba(255,255,255,.12); }
        .brand-link .brand-text { color: #fff; font-weight: 700; }
        .content-header h1 { font-size: 1.5rem; }
        .required::after { content: ' *'; color: #c33; }
    </style>
</head>
<body class="layout-fixed sidebar-expand-lg bg-body-tertiary">
<div class="app-wrapper">
    <nav class="app-header navbar navbar-expand bg-body">
        <div class="container-fluid">
            <ul class="navbar-nav"><li class="nav-item"><a class="nav-link" data-lte-toggle="sidebar" href="#" role="button" aria-label="Alternar menú"><i class="fa-solid fa-bars"></i></a></li><li class="nav-item d-none d-md-block"><a href="{{ route('home') }}" class="nav-link" target="_blank">Ver sitio <i class="fa-solid fa-arrow-up-right-from-square ms-1"></i></a></li></ul>
            <ul class="navbar-nav ms-auto"><li class="nav-item"><span class="nav-link">{{ auth()->user()->name }}</span></li><li class="nav-item"><form method="POST" action="{{ route('admin.logout') }}">@csrf<button class="nav-link border-0 bg-transparent" type="submit">Salir <i class="fa-solid fa-arrow-right-from-bracket ms-1"></i></button></form></li></ul>
        </div>
    </nav>
    <aside class="app-sidebar" data-bs-theme="dark">
        <div class="sidebar-brand"><a href="{{ route('admin.dashboard') }}" class="brand-link"><i class="fa-solid fa-book-open text-warning me-2"></i><span class="brand-text">Padre Luis Variara</span></a></div>
        <div class="sidebar-wrapper"><nav class="mt-2"><ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" role="menu">
            <li class="nav-item"><a href="{{ route('admin.contents.index') }}" class="nav-link {{ request()->routeIs('admin.contents.*') ? 'active' : '' }}"><i class="nav-icon fa-regular fa-newspaper"></i><p>Contenido del sitio</p></a></li>
            <li class="nav-item"><a href="{{ route('admin.settings.edit') }}" class="nav-link {{ request()->routeIs('admin.settings.*') ? 'active' : '' }}"><i class="nav-icon fa-solid fa-sliders"></i><p>Información institucional</p></a></li>
            <li class="nav-item"><a href="{{ route('home') }}" class="nav-link" target="_blank"><i class="nav-icon fa-solid fa-arrow-up-right-from-square"></i><p>Abrir página pública</p></a></li>
        </ul></nav></div>
    </aside>
    <main class="app-main">
        <div class="app-content-header"><div class="container-fluid"><div class="row"><div class="col-sm-8"><h1 class="mb-0">@yield('heading', 'Administración')</h1></div><div class="col-sm-4"><ol class="breadcrumb float-sm-end"><li class="breadcrumb-item"><a href="{{ route('admin.contents.index') }}">Panel</a></li><li class="breadcrumb-item active">@yield('breadcrumb', 'Contenido')</li></ol></div></div></div></div>
        <div class="app-content"><div class="container-fluid">
            @if (session('status'))<div class="alert alert-success alert-dismissible" role="status">{{ session('status') }}<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button></div>@endif
            @if ($errors->any())<div class="alert alert-danger" role="alert"><ul class="mb-0">@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>@endif
            @yield('content')
        </div></div>
    </main>
    <footer class="app-footer"><strong>Colegio Padre Luis Variara</strong><span class="float-end">Administración de contenido</span></footer>
</div>
<script src="https://cdn.jsdelivr.net/npm/admin-lte@4.0.0-beta3/dist/js/adminlte.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')
</body>
</html>