
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Mahasiswa | TIFONE.ALGORITHM</title>
    @vite('resources/css/app.css')
</head>
<body class="min-h-screen bg-[#080b14] text-white">
    <main class="mx-auto max-w-3xl px-6 py-12">
        <a href="/" class="text-cyan-400 hover:text-cyan-300">
            ← Kembali ke halaman utama
        </a>

        <section class="mt-8 overflow-hidden rounded-3xl border border-white/10 bg-white/[0.04]">
            <div class="flex min-h-64 items-center justify-center bg-gradient-to-br from-cyan-950 to-slate-900">
                @if ($student->photo)
                    <img
                        src="{{ asset('storage/' . $student->photo) }}"
                        alt="Foto {{ $student->name }}"
                        class="h-64 w-full object-cover"
                    >
                @else
                    <div class="flex h-28 w-28 items-center justify-center rounded-full border border-cyan-400/40 bg-cyan-400/10 text-4xl font-black text-cyan-300">
                        {{ strtoupper(substr($student->name, 0, 1)) }}
                    </div>
                @endif
            </div>

            <div class="space-y-6 p-6 md:p-10">
                <div>
                    <p class="text-sm font-bold tracking-widest text-cyan-400">
                        {{ $student->nim }}
                    </p>
                    <h1 class="mt-2 text-3xl font-black md:text-4xl">
                        {{ $student->name }}
                    </h1>
                    <p class="mt-2 text-slate-400">
                        {{ $student->class_name }} · Teknik Informatika UNIKOM
                    </p>
                </div>

                <div class="border-t border-white/10 pt-6">
                    <h2 class="mb-3 text-lg font-bold text-cyan-400">
                        Tentang Saya
                    </h2>
                    <p class="leading-7 text-slate-300">
                        {{ $student->bio ?: 'Belum ada biodata mahasiswa.' }}
                    </p>
                </div>

                <div class="grid gap-4 sm:grid-cols-2">
                    <div class="rounded-xl border border-white/10 bg-white/5 p-4">
                        <p class="text-sm text-slate-400">Email</p>
                        <p class="mt-2 break-words">
                            {{ $student->email ?: 'Belum diisi' }}
                        </p>
                    </div>

                    <div class="rounded-xl border border-white/10 bg-white/5 p-4">
                        <p class="text-sm text-slate-400">Telepon</p>
                        <p class="mt-2">
                            {{ $student->phone ?: 'Belum diisi' }}
                        </p>
                    </div>
                </div>

                @if ($student->instagram)
                    <a
                        href="{{ 'https://www.instagram.com/' . ltrim($student->instagram, '@') . '/' }}"
                        target="_blank"
                        rel="noopener noreferrer"
                        class="inline-flex rounded-xl bg-cyan-500 px-5 py-3 font-bold text-slate-950 hover:bg-cyan-400"
                    >
                        Kunjungi Instagram →
                    </a>
                @endif
            </div>
        </section>

        <footer class="mt-8 text-center text-sm text-slate-500">
            © {{ date('Y') }} TIFONE.ALGORITHM · IF 1 UNIKOM
        </footer>
    </main>
</body>
</html>
