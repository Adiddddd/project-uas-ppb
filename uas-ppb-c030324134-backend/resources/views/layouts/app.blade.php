<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aplikasi Gudang</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .sidebar { 
            width: 250px; 
            min-height: 100vh;
        }
    </style>
</head>
<body class="bg-light">

<div class="d-flex">
    <div class="bg-dark text-white p-3 d-flex flex-column sidebar shadow">
        <h4 class="text-center mt-2 mb-3">📦 App Gudang</h4>
        <hr class="text-secondary">

        <ul class="nav flex-column mb-auto">
            <li class="nav-item mb-2">
                <a class="nav-link text-white {{ request()->routeIs('gudang.index') ? 'bg-secondary bg-opacity-50 fw-bold rounded' : '' }}" href="{{ route('gudang.index') }}">
                    🏠 Dashboard
                </a>
            </li>

            {{-- Menu Tambah Gudang HANYA untuk Admin --}}
            @if(auth()->user()->role === 'admin')
            <li class="nav-item mb-2">
                <a class="nav-link text-white {{ request()->routeIs('gudang.create') ? 'bg-secondary bg-opacity-50 fw-bold rounded' : '' }}" href="{{ route('gudang.create') }}">
                    ➕ Tambah Gudang
                </a>
            </li>
            @endif

            {{-- Menu Profil (Tampil untuk Admin & User) --}}
            <li class="nav-item mb-2">
                <a class="nav-link text-white {{ request()->routeIs('profile.index') ? 'bg-secondary bg-opacity-50 fw-bold rounded' : '' }}" href="{{ route('profile.index') }}">
                    👤 Profil
                </a>
            </li>
        </ul>

        <hr class="text-secondary">
        
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-danger w-100 fw-bold">Logout</button>
        </form>
    </div>
    <div class="p-4 flex-grow-1" style="height: 100vh; overflow-y: auto;">
        @yield('content')
    </div>
    </div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>