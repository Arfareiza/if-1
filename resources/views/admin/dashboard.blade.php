
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin — TIFONE.ALGORITHM</title>
    @vite(['resources/css/app.css', 'resources/js/app.jsx'])
</head>

<body class="min-h-screen bg-slate-950 text-white">

<div class="min-h-screen md:flex">

    {{-- SIDEBAR DESKTOP --}}
    <aside class="hidden w-72 shrink-0 border-r border-slate-800 bg-slate-900 p-6 md:flex md:flex-col">

        <a href="{{ route('admin.dashboard') }}" class="text-xl font-black tracking-tight">
            TIFONE<span class="text-cyan-400">.</span>ALGORITHM
        </a>

        <p class="mt-2 text-xs uppercase tracking-widest text-slate-500">
            Admin Panel · IF 1
        </p>

        <nav class="mt-10 space-y-2">

            <a href="{{ route('admin.dashboard') }}"
               class="block rounded-xl bg-cyan-400/10 px-4 py-3 font-semibold text-cyan-300">
                🏠 Dashboard
            </a>

            <a href="{{ route('admin.students.index') }}"
               class="block rounded-xl px-4 py-3 text-slate-300 transition hover:bg-slate-800 hover:text-white">
                👨‍🎓 Data Mahasiswa
            </a>

            <a href="{{ route('admin.semesters.index') }}"
               class="block rounded-xl px-4 py-3 text-slate-300 transition hover:bg-slate-800 hover:text-white">
                📚 Semester
            </a>

            <a href="{{ route('admin.class-schedules.index') }}"
               class="block rounded-xl px-4 py-3 text-slate-300 transition hover:bg-slate-800 hover:text-white">
                🗓️ Jadwal Kuliah
            </a>

            <a href="{{ route('admin.class-events.index') }}"
               class="block rounded-xl px-4 py-3 text-slate-300 transition hover:bg-slate-800 hover:text-white">
                📅 Kalender Akademik
            </a>

            <a href="{{ route('admin.confessions.index') }}"
               class="flex items-center justify-between rounded-xl px-4 py-3 text-slate-300 transition hover:bg-slate-800 hover:text-white">
                <span>💌 Moderasi Menfess</span>

                @if (($pendingConfessions ?? 0) > 0)
                    <span class="rounded-full bg-amber-400 px-2 py-1 text-xs font-bold text-slate-950">
                        {{ $pendingConfessions }}
                    </span>
                @endif
            </a>

            <a href="{{ route('home') }}"
               class="block rounded-xl px-4 py-3 text-slate-300 transition hover:bg-slate-800 hover:text-white">
                🌐 Lihat Website ↗
            </a>

        </nav>

        <div class="mt-auto border-t border-slate-800 pt-6">
            <form action="{{ route('admin.logout') }}" method="POST">
                @csrf
                <button type="submit"
                    class="w-full rounded-xl border border-red-500/30 px-4 py-3 text-left font-semibold text-red-300 transition hover:bg-red-500/10">
                    Keluar dari Admin
                </button>
            </form>
        </div>

    </aside>

    {{-- KONTEN UTAMA --}}
    <main class="min-w-0 flex-1 p-5 md:p-10">

        {{-- NAVIGASI MOBILE --}}
        <div class="mb-8 md:hidden">

            <a href="{{ route('admin.dashboard') }}"
               class="text-lg font-black tracking-tight">
                TIFONE<span class="text-cyan-400">.</span>ALGORITHM
            </a>

            <p class="mt-2 text-xs uppercase tracking-widest text-slate-500">
                Admin Panel · IF 1
            </p>

            <nav class="mt-4 flex flex-wrap gap-2 text-sm">

                <a href="{{ route('admin.dashboard') }}"
                   class="rounded-lg bg-cyan-400/10 px-3 py-2 text-cyan-300">
                    Dashboard
                </a>

                <a href="{{ route('admin.students.index') }}"
                   class="rounded-lg bg-slate-900 px-3 py-2 text-slate-300">
                    Mahasiswa
                </a>

                <a href="{{ route('admin.semesters.index') }}"
                   class="rounded-lg bg-slate-900 px-3 py-2 text-slate-300">
                    Semester
                </a>

                <a href="{{ route('admin.class-schedules.index') }}"
                   class="rounded-lg bg-slate-900 px-3 py-2 text-slate-300">
                    Jadwal Kuliah
                </a>

                <a href="{{ route('admin.class-events.index') }}"
                   class="rounded-lg bg-slate-900 px-3 py-2 text-slate-300">
                    Kalender Akademik
                </a>

                <a href="{{ route('admin.confessions.index') }}"
                   class="rounded-lg bg-slate-900 px-3 py-2 text-slate-300">
                    Menfess
                    @if (($pendingConfessions ?? 0) > 0)
                        ({{ $pendingConfessions }})
                    @endif
                </a>

                <a href="{{ route('home') }}"
                   class="rounded-lg bg-slate-900 px-3 py-2 text-slate-300">
                    Website ↗
                </a>

            </nav>

            <form action="{{ route('admin.logout') }}" method="POST" class="mt-4">
                @csrf
                <button type="submit"
                    class="rounded-lg border border-red-500/30 px-3 py-2 text-sm text-red-300">
                    Logout
                </button>
            </form>

        </div>

        {{-- HEADER --}}
        <header class="mb-10">

            <p class="text-xs font-bold uppercase tracking-[0.3em] text-cyan-400">
                TIFONE.ALGORITHM · IF 1 UNIKOM
            </p>

            <h1 class="mt-3 text-3xl font-black md:text-4xl">
                Dashboard Admin
            </h1>

            <p class="mt-3 text-slate-400">
                Selamat datang di panel pengelolaan website kelas IF 1.
                Kelola mahasiswa, semester, jadwal kuliah, kalender akademik,
                dan menfess dalam satu tempat.
            </p>

        </header>

        {{-- STATISTIK UMUM --}}
        <section class="mb-10">

            <div class="mb-5">
                <h2 class="text-xl font-bold">Statistik Umum</h2>
                <p class="mt-2 text-sm text-slate-400">
                    Ringkasan data website kelas.
                </p>
            </div>

            <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">

                {{-- MAHASISWA --}}
                <a href="{{ route('admin.students.index') }}"
                   class="rounded-2xl border border-slate-800 bg-slate-900 p-6 transition hover:border-cyan-400">

                    <p class="text-sm text-slate-400">Total Mahasiswa</p>

                    <p class="mt-3 text-3xl font-black text-cyan-400">
                        {{ $totalStudents ?? 0 }}
                    </p>

                    <p class="mt-2 text-xs text-slate-500">
                        Mahasiswa terdaftar
                    </p>
                </a>

                {{-- ADMIN --}}
                <div class="rounded-2xl border border-slate-800 bg-slate-900 p-6">

                    <p class="text-sm text-slate-400">Total Admin</p>

                    <p class="mt-3 text-3xl font-black text-violet-400">
                        {{ $totalAdmins ?? 0 }}
                    </p>

                    <p class="mt-2 text-xs text-slate-500">
                        Pengelola website
                    </p>
                </div>

                {{-- TOTAL MENFESS --}}
                <a href="{{ route('admin.confessions.index') }}"
                   class="rounded-2xl border border-slate-800 bg-slate-900 p-6 transition hover:border-cyan-400">

                    <p class="text-sm text-slate-400">Total Menfess</p>

                    <p class="mt-3 text-3xl font-black text-cyan-400">
                        {{ $totalConfessions ?? 0 }}
                    </p>

                    <p class="mt-2 text-xs text-slate-500">
                        Seluruh kiriman
                    </p>
                </a>

                {{-- MENFESS MENUNGGU --}}
                <a href="{{ route('admin.confessions.index', ['status' => 'pending']) }}"
                   class="rounded-2xl border border-amber-500/20 bg-slate-900 p-6 transition hover:border-amber-400/60">

                    <p class="text-sm text-slate-400">Menfess Menunggu</p>

                    <p class="mt-3 text-3xl font-black text-amber-400">
                        {{ $pendingConfessions ?? 0 }}
                    </p>

                    <p class="mt-2 text-xs text-slate-500">
                        Perlu ditinjau admin
                    </p>
                </a>

            </div>
        </section>

        {{-- STATISTIK AKADEMIK --}}
        <section class="mb-10">

            <div class="mb-5">
                <h2 class="text-xl font-bold">Statistik Akademik</h2>

                <p class="mt-2 text-sm text-slate-400">
                    Ringkasan semester, jadwal perkuliahan, dan agenda akademik.
                </p>
            </div>

            <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-3">

                {{-- SEMESTER --}}
                <a href="{{ route('admin.semesters.index') }}"
                   class="rounded-2xl border border-slate-800 bg-slate-900 p-6 transition hover:border-violet-400">

                    <div class="flex items-center justify-between">
                        <p class="text-sm text-slate-400">Total Semester</p>
                        <span class="text-2xl">📚</span>
                    </div>

                    <p class="mt-3 text-3xl font-black text-violet-400">
                        {{ $totalSemesters ?? 0 }}
                    </p>

                    <p class="mt-2 text-sm text-slate-400">
                        @if (!empty($activeSemester))
                            Semester aktif:
                            {{ $activeSemester->name }}
                            · {{ $activeSemester->academic_year }}
                        @else
                            Belum ada semester aktif
                        @endif
                    </p>
                </a>

                {{-- JADWAL KULIAH --}}
                <a href="{{ route('admin.class-schedules.index') }}"
                   class="rounded-2xl border border-slate-800 bg-slate-900 p-6 transition hover:border-cyan-400">

                    <div class="flex items-center justify-between">
                        <p class="text-sm text-slate-400">Total Jadwal Kuliah</p>
                        <span class="text-2xl">🗓️</span>
                    </div>

                    <p class="mt-3 text-3xl font-black text-cyan-400">
                        {{ $totalSchedules ?? 0 }}
                    </p>

                    <p class="mt-2 text-sm text-slate-400">
                        {{ $activeSchedules ?? 0 }} jadwal aktif
                    </p>
                </a>

                {{-- KALENDER AKADEMIK --}}
                <a href="{{ route('admin.class-events.index') }}"
                   class="rounded-2xl border border-slate-800 bg-slate-900 p-6 transition hover:border-emerald-400">

                    <div class="flex items-center justify-between">
                        <p class="text-sm text-slate-400">Total Agenda Akademik</p>
                        <span class="text-2xl">📅</span>
                    </div>

                    <p class="mt-3 text-3xl font-black text-emerald-400">
                        {{ $totalEvents ?? 0 }}
                    </p>

                    <p class="mt-2 text-sm text-slate-400">
                        {{ $publishedEvents ?? 0 }} agenda dipublikasikan
                    </p>
                </a>

            </div>
        </section>

        {{-- MANAJEMEN WEBSITE --}}
        <section>

            <div class="mb-5">
                <h2 class="text-xl font-bold">Manajemen Website</h2>

                <p class="mt-2 text-sm text-slate-400">
                    Pilih fitur yang ingin kamu kelola.
                </p>
            </div>

            <div class="grid gap-5 sm:grid-cols-2 xl:grid-cols-3">

                {{-- DATA MAHASISWA --}}
                <a href="{{ route('admin.students.index') }}"
                   class="group rounded-2xl border border-slate-800 bg-slate-900 p-6 transition hover:-translate-y-1 hover:border-cyan-400">

                    <div class="mb-4 text-3xl">👨‍🎓</div>

                    <h3 class="text-lg font-bold transition group-hover:text-cyan-300">
                        Data Mahasiswa
                    </h3>

                    <p class="mt-2 text-sm leading-6 text-slate-400">
                        Tambah, edit, cari, dan kelola informasi mahasiswa IF 1.
                    </p>

                    <p class="mt-5 text-sm font-semibold text-cyan-300">
                        Kelola Mahasiswa →
                    </p>
                </a>

                {{-- SEMESTER --}}
                <a href="{{ route('admin.semesters.index') }}"
                   class="group rounded-2xl border border-slate-800 bg-slate-900 p-6 transition hover:-translate-y-1 hover:border-violet-400">

                    <div class="mb-4 text-3xl">📚</div>

                    <h3 class="text-lg font-bold transition group-hover:text-violet-300">
                        Manajemen Semester
                    </h3>

                    <p class="mt-2 text-sm leading-6 text-slate-400">
                        Atur semester ganjil atau genap, tahun akademik,
                        tanggal mulai, tanggal selesai, dan semester aktif.
                    </p>

                    <p class="mt-5 text-sm font-semibold text-violet-300">
                        Kelola Semester →
                    </p>
                </a>

                {{-- JADWAL KULIAH --}}
                <a href="{{ route('admin.class-schedules.index') }}"
                   class="group rounded-2xl border border-slate-800 bg-slate-900 p-6 transition hover:-translate-y-1 hover:border-cyan-400">

                    <div class="mb-4 text-3xl">🗓️</div>

                    <h3 class="text-lg font-bold transition group-hover:text-cyan-300">
                        Jadwal Mata Kuliah
                    </h3>

                    <p class="mt-2 text-sm leading-6 text-slate-400">
                        Atur mata kuliah, dosen, hari, jam perkuliahan,
                        ruangan, dan jenis pertemuan.
                    </p>

                    <p class="mt-5 text-sm font-semibold text-cyan-300">
                        Kelola Jadwal →
                    </p>
                </a>

                {{-- KALENDER AKADEMIK --}}
                <a href="{{ route('admin.class-events.index') }}"
                   class="group rounded-2xl border border-slate-800 bg-slate-900 p-6 transition hover:-translate-y-1 hover:border-emerald-400">

                    <div class="mb-4 text-3xl">📅</div>

                    <h3 class="text-lg font-bold transition group-hover:text-emerald-300">
                        Kalender Akademik
                    </h3>

                    <p class="mt-2 text-sm leading-6 text-slate-400">
                        Kelola jadwal UTS, UAS, presentasi, tenggat tugas,
                        hari libur, dan agenda kelas.
                    </p>

                    <p class="mt-5 text-sm font-semibold text-emerald-300">
                        Kelola Kalender →
                    </p>
                </a>

                {{-- MODERASI MENFESS --}}
                <a href="{{ route('admin.confessions.index') }}"
                   class="group rounded-2xl border border-slate-800 bg-slate-900 p-6 transition hover:-translate-y-1 hover:border-pink-400">

                    <div class="mb-4 flex items-center justify-between">
                        <span class="text-3xl">💌</span>

                        @if (($pendingConfessions ?? 0) > 0)
                            <span class="rounded-full bg-amber-400/10 px-3 py-1 text-xs font-bold text-amber-300">
                                {{ $pendingConfessions }} menunggu
                            </span>
                        @else
                            <span class="rounded-full bg-emerald-400/10 px-3 py-1 text-xs font-bold text-emerald-300">
                                Tidak ada antrean
                            </span>
                        @endif
                    </div>

                    <h3 class="text-lg font-bold transition group-hover:text-pink-300">
                        Moderasi Menfess
                    </h3>

                    <p class="mt-2 text-sm leading-6 text-slate-400">
                        Periksa, setujui, tolak, atau hapus pesan anonim mahasiswa.
                    </p>

                    <p class="mt-5 text-sm font-semibold text-pink-300">
                        Kelola Menfess →
                    </p>
                </a>

            </div>
        </section>

        {{-- FOOTER --}}
        <footer class="mt-12 border-t border-slate-800 pt-6 text-center text-xs text-slate-500">
            © {{ date('Y') }} TIFONE.ALGORITHM · IF 1 UNIKOM

            <p class="mt-2">
                Dibuat untuk mahasiswa Teknik Informatika 1.
            </p>
        </footer>

    </main>

</div>

</body>
</html>
