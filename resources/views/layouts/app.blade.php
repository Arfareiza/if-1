
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Admin Agenda Akademik') - TIFONE.ALGORITHM</title>

    @vite(['resources/css/app.css', 'resources/js/app.jsx'])
</head>
<body class="min-h-screen bg-slate-100 text-slate-800">

    <header class="border-b border-slate-200 bg-white">
        <div class="mx-auto flex max-w-7xl items-center justify-between px-4 py-4 sm:px-6 lg:px-8">
            <a href="/" class="text-lg font-bold text-indigo-600">
                TIFONE.ALGORITHM
            </a>

            <a href="{{ route('admin.class-events.index') }}"
               class="text-sm font-medium text-slate-600 hover:text-indigo-600">
                Agenda Akademik
            </a>
        </div>
    </header>

    <main>
        @yield('content')
    </main>

</body>
</html>
