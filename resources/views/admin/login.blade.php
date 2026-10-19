
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin — TIFONE.ALGORITHM</title>
    @vite(['resources/css/app.css', 'resources/js/app.jsx'])
</head>
<body class="min-h-screen bg-slate-950 text-white flex items-center justify-center p-6">
    <main class="w-full max-w-md rounded-2xl border border-cyan-900 bg-slate-900 p-8 shadow-xl">
        <p class="mb-3 text-sm font-bold tracking-widest text-cyan-400">
            TIFONE.ALGORITHM
        </p>

        <h1 class="mb-2 text-2xl font-bold">Login Admin</h1>
        <p class="mb-6 text-sm text-slate-400">
            Masuk untuk mengelola website kelas IF 1.
        </p>

        @if ($errors->any())
            <div class="mb-4 rounded-lg bg-red-950 p-3 text-sm text-red-300">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('admin.login.submit') }}" class="space-y-4">
            @csrf

            <div>
                <label for="email" class="mb-2 block text-sm">Email Admin</label>
                <input
                    id="email"
                    name="email"
                    type="email"
                    value="{{ old('email') }}"
                    required
                    autocomplete="username"
                    class="w-full rounded-lg border border-slate-700 bg-slate-950 p-3 text-white"
                >
            </div>

            <div>
                <label for="password" class="mb-2 block text-sm">Password</label>
                <input
                    id="password"
                    name="password"
                    type="password"
                    required
                    autocomplete="current-password"
                    class="w-full rounded-lg border border-slate-700 bg-slate-950 p-3 text-white"
                >
            </div>

            <button
                type="submit"
                class="w-full rounded-lg bg-cyan-500 p-3 font-bold text-slate-950 hover:bg-cyan-400"
            >
                Masuk ke Dashboard
            </button>
        </form>

        <a href="/" class="mt-6 block text-center text-sm text-slate-400 hover:text-cyan-400">
            ← Kembali ke halaman utama
        </a>
    </main>
</body>
</html>
