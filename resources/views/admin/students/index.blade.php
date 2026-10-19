
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Mahasiswa — TIFONE.ALGORITHM</title>
    @vite(['resources/css/app.css', 'resources/js/app.jsx'])
</head>

<body class="min-h-screen bg-slate-950 text-white">
    <main class="mx-auto max-w-7xl p-5 md:p-10">

        {{-- HEADER --}}
        <header class="mb-8 flex flex-wrap items-center justify-between gap-4">
            <div>
                <a href="{{ route('admin.dashboard') }}"
                   class="text-sm text-cyan-400 hover:text-cyan-300">
                    ← Kembali ke Dashboard
                </a>

                <p class="mt-5 text-xs font-bold uppercase tracking-[0.3em] text-cyan-400">
                    TIFONE.ALGORITHM · IF 1 UNIKOM
                </p>

                <h1 class="mt-3 text-3xl font-black md:text-4xl">
                    Data Mahasiswa
                </h1>

                <p class="mt-2 text-slate-400">
                    Kelola data mahasiswa kelas IF 1 UNIKOM.
                </p>
            </div>

            <a href="{{ route('admin.students.create') }}"
               class="inline-flex items-center rounded-xl bg-cyan-500 px-5 py-3 font-bold text-slate-950 transition hover:bg-cyan-400">
                + Tambah Mahasiswa
            </a>
        </header>

        {{-- NOTIFIKASI SUKSES --}}
        @if (session('success'))
            <div class="mb-6 rounded-xl border border-emerald-800 bg-emerald-950 p-4 text-emerald-300">
                {{ session('success') }}
            </div>
        @endif

        {{-- NOTIFIKASI ERROR --}}
        @if ($errors->any())
            <div class="mb-6 rounded-xl border border-red-800 bg-red-950 p-4 text-red-300">
                <p class="mb-2 font-bold">Terjadi kesalahan:</p>

                <ul class="list-inside list-disc space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- STATISTIK --}}
        <section class="mb-6 grid gap-4 sm:grid-cols-2">
            <div class="rounded-2xl border border-slate-800 bg-slate-900 p-5">
                <p class="text-sm text-slate-400">Total Mahasiswa</p>

                <p class="mt-3 text-3xl font-black text-cyan-400">
                    {{ $students->total() }}
                </p>

                <p class="mt-2 text-xs text-slate-500">
                    Seluruh data mahasiswa yang terdaftar
                </p>
            </div>

            <div class="rounded-2xl border border-slate-800 bg-slate-900 p-5">
                <p class="text-sm text-slate-400">Data di Halaman Ini</p>

                <p class="mt-3 text-3xl font-black text-white">
                    {{ $students->count() }}
                </p>

                <p class="mt-2 text-xs text-slate-500">
                    Maksimal 10 data per halaman sesuai pengaturan controller
                </p>
            </div>
        </section>

        {{-- TABEL MAHASISWA --}}
        <section class="overflow-hidden rounded-2xl border border-slate-800 bg-slate-900">

            <div class="border-b border-slate-800 p-5">
                <h2 class="text-lg font-bold">Daftar Mahasiswa</h2>

                <p class="mt-1 text-sm text-slate-400">
                    Informasi mahasiswa yang tersimpan di database.
                </p>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full min-w-[850px] text-left text-sm">
                    <thead class="border-b border-slate-800 bg-slate-800/70 text-xs uppercase tracking-wider text-slate-300">
                        <tr>
                            <th class="px-5 py-4">Foto</th>
                            <th class="px-5 py-4">NIM</th>
                            <th class="px-5 py-4">Nama</th>
                            <th class="px-5 py-4">Kelas</th>
                            <th class="px-5 py-4">Instagram</th>
                            <th class="px-5 py-4 text-right">Aksi</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-slate-800">
                        @forelse ($students as $student)
                            <tr class="transition hover:bg-slate-800/50">

                                {{-- FOTO --}}
                                <td class="px-5 py-4">
                                    @if ($student->photo)
                                        <img
                                            src="{{ asset('storage/' . $student->photo) }}"
                                            alt="Foto {{ $student->name }}"
                                            class="h-12 w-12 rounded-full border border-slate-700 object-cover"
                                        >
                                    @else
                                        <div class="flex h-12 w-12 items-center justify-center rounded-full bg-cyan-400/10 text-lg font-bold text-cyan-400">
                                            {{ strtoupper(substr($student->name, 0, 1)) }}
                                        </div>
                                    @endif
                                </td>

                                {{-- NIM --}}
                                <td class="whitespace-nowrap px-5 py-4 text-slate-300">
                                    {{ $student->nim }}
                                </td>

                                {{-- NAMA --}}
                                <td class="px-5 py-4">
                                    <p class="font-semibold text-white">
                                        {{ $student->name }}
                                    </p>

                                    <p class="mt-1 text-xs text-slate-500">
                                        {{ $student->email ?: 'Email belum diisi' }}
                                    </p>
                                </td>

                                {{-- KELAS --}}
                                <td class="whitespace-nowrap px-5 py-4">
                                    <span class="rounded-full border border-cyan-400/20 bg-cyan-400/10 px-3 py-1 text-xs font-semibold text-cyan-300">
                                        {{ $student->class_name }}
                                    </span>
                                </td>

                                {{-- INSTAGRAM --}}
                                <td class="px-5 py-4 text-cyan-400">
                                    @if ($student->instagram)
                                        {{ $student->instagram }}
                                    @else
                                        <span class="text-slate-500">—</span>
                                    @endif
                                </td>

                                {{-- AKSI --}}
                                <td class="px-5 py-4">
                                    <div class="flex items-center justify-end gap-3">

                                        <a
                                            href="{{ route('admin.students.show', $student) }}"
                                            class="font-semibold text-slate-300 hover:text-white"
                                        >
                                            Detail
                                        </a>

                                        <a
                                            href="{{ route('admin.students.edit', $student) }}"
                                            class="font-semibold text-amber-400 hover:text-amber-300"
                                        >
                                            Edit
                                        </a>

                                        <form
                                            action="{{ route('admin.students.destroy', $student) }}"
                                            method="POST"
                                            onsubmit="return confirm('Yakin ingin menghapus data mahasiswa {{ $student->name }}?')"
                                        >
                                            @csrf
                                            @method('DELETE')

                                            <button
                                                type="submit"
                                                class="font-semibold text-red-400 hover:text-red-300"
                                            >
                                                Hapus
                                            </button>
                                        </form>

                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-5 py-12 text-center">
                                    <div class="mx-auto max-w-md">
                                        <p class="text-lg font-bold text-slate-300">
                                            Belum ada data mahasiswa
                                        </p>

                                        <p class="mt-2 text-sm text-slate-500">
                                            Tambahkan mahasiswa untuk mulai mengisi daftar kelas IF 1.
                                        </p>

                                        <a
                                            href="{{ route('admin.students.create') }}"
                                            class="mt-5 inline-flex rounded-xl bg-cyan-500 px-5 py-3 font-bold text-slate-950 hover:bg-cyan-400"
                                        >
                                            + Tambah Mahasiswa
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- PAGINATION --}}
            @if ($students->hasPages())
                <div class="border-t border-slate-800 p-5">
                    {{ $students->links() }}
                </div>
            @endif

        </section>

        {{-- FOOTER --}}
        <footer class="mt-6 flex flex-wrap items-center justify-between gap-3 text-xs text-slate-500">
            <p>© {{ date('Y') }} TIFONE.ALGORITHM</p>

            <p>IF 1 · Teknik Informatika UNIKOM</p>
        </footer>

    </main>
</body>
</html>
