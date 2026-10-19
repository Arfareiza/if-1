
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Mahasiswa — TIFONE.ALGORITHM</title>
    @vite(['resources/css/app.css', 'resources/js/app.jsx'])
</head>

<body class="min-h-screen bg-slate-950 text-white">
    <main class="mx-auto max-w-4xl px-5 py-10 md:px-8">

        <a href="{{ route('admin.students.index') }}"
           class="text-sm font-semibold text-cyan-400 hover:text-cyan-300">
            ← Kembali ke Data Mahasiswa
        </a>

        <header class="mb-8 mt-6">
            <p class="text-xs font-bold uppercase tracking-[0.3em] text-cyan-400">
                TIFONE.ALGORITHM · IF 1 UNIKOM
            </p>

            <h1 class="mt-3 text-3xl font-black md:text-4xl">
                Detail Mahasiswa
            </h1>

            <p class="mt-2 text-slate-400">
                Informasi lengkap mahasiswa yang terdaftar.
            </p>
        </header>

        <section class="overflow-hidden rounded-3xl border border-slate-800 bg-slate-900">

            {{-- FOTO DAN IDENTITAS --}}
            <div class="flex flex-col items-center border-b border-slate-800 bg-gradient-to-br from-cyan-950/60 to-slate-900 px-6 py-10 text-center">
                @if ($student->photo)
                    <img
                        src="{{ asset('storage/' . $student->photo) }}"
                        alt="Foto {{ $student->name }}"
                        class="h-32 w-32 rounded-full border-4 border-cyan-400/30 object-cover"
                    >
                @else
                    <div class="flex h-32 w-32 items-center justify-center rounded-full border-4 border-cyan-400/20 bg-cyan-400/10 text-5xl font-black text-cyan-400">
                        {{ strtoupper(substr($student->name, 0, 1)) }}
                    </div>
                @endif

                <h2 class="mt-5 text-2xl font-black">
                    {{ $student->name }}
                </h2>

                <p class="mt-2 text-cyan-400">
                    {{ $student->nim }}
                </p>

                <span class="mt-3 rounded-full border border-cyan-400/20 bg-cyan-400/10 px-4 py-1 text-sm text-cyan-300">
                    {{ $student->class_name }}
                </span>
            </div>

            {{-- BIODATA --}}
            <div class="p-6 md:p-8">
                <h3 class="mb-5 text-lg font-bold">Informasi Mahasiswa</h3>

                <div class="grid gap-4 sm:grid-cols-2">

                    <div class="rounded-xl border border-slate-800 bg-slate-950/60 p-4">
                        <p class="text-sm text-slate-400">NIM</p>
                        <p class="mt-2 break-words font-semibold">
                            {{ $student->nim }}
                        </p>
                    </div>

                    <div class="rounded-xl border border-slate-800 bg-slate-950/60 p-4">
                        <p class="text-sm text-slate-400">Nama Lengkap</p>
                        <p class="mt-2 break-words font-semibold">
                            {{ $student->name }}
                        </p>
                    </div>

                    <div class="rounded-xl border border-slate-800 bg-slate-950/60 p-4">
                        <p class="text-sm text-slate-400">Kelas</p>
                        <p class="mt-2 font-semibold">
                            {{ $student->class_name }}
                        </p>
                    </div>

                    <div class="rounded-xl border border-slate-800 bg-slate-950/60 p-4">
                        <p class="text-sm text-slate-400">Email</p>
                        <p class="mt-2 break-words font-semibold">
                            {{ $student->email ?: 'Belum diisi' }}
                        </p>
                    </div>

                    <div class="rounded-xl border border-slate-800 bg-slate-950/60 p-4">
                        <p class="text-sm text-slate-400">Nomor Telepon</p>
                        <p class="mt-2 font-semibold">
                            {{ $student->phone ?: 'Belum diisi' }}
                        </p>
                    </div>

                    <div class="rounded-xl border border-slate-800 bg-slate-950/60 p-4">
                        <p class="text-sm text-slate-400">Instagram</p>
                        <p class="mt-2 break-words font-semibold text-cyan-400">
                            {{ $student->instagram ?: 'Belum diisi' }}
                        </p>

                        @if ($student->instagram)
                            <a
                                href="{{ 'https://www.instagram.com/' . ltrim($student->instagram, '@') . '/' }}"
                                target="_blank"
                                rel="noopener noreferrer"
                                class="mt-2 inline-block text-sm text-cyan-300 hover:underline"
                            >
                                Buka Instagram →
                            </a>
                        @endif
                    </div>

                </div>

                {{-- BIODATA DIRI --}}
                <div class="mt-4 rounded-xl border border-slate-800 bg-slate-950/60 p-4">
                    <p class="text-sm text-slate-400">Tentang Saya</p>

                    <p class="mt-3 whitespace-pre-line leading-7 text-slate-300">
                        {{ $student->bio ?: 'Belum ada biodata mahasiswa.' }}
                    </p>
                </div>

                {{-- TOMBOL AKSI --}}
                <div class="mt-8 flex flex-wrap gap-3">
                    <a
                        href="{{ route('admin.students.edit', $student) }}"
                        class="rounded-xl bg-amber-400 px-5 py-3 font-bold text-slate-950 transition hover:bg-amber-300"
                    >
                        Edit Data
                    </a>

                    <a
                        href="{{ route('students.detail', $student) }}"
                        target="_blank"
                        class="rounded-xl border border-cyan-400/30 px-5 py-3 font-bold text-cyan-300 transition hover:bg-cyan-400/10"
                    >
                        Lihat Profil Publik
                    </a>

                    <a
                        href="{{ route('admin.students.index') }}"
                        class="rounded-xl border border-slate-700 px-5 py-3 font-semibold text-slate-300 transition hover:bg-slate-800"
                    >
                        Kembali
                    </a>
                </div>
            </div>
        </section>

        <footer class="mt-8 text-center text-xs text-slate-500">
            © {{ date('Y') }} TIFONE.ALGORITHM · IF 1 UNIKOM
        </footer>

    </main>
</body>
</html>
