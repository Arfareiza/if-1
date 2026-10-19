
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengumuman Kelas — TIFONE.ALGORITHM</title>
    @vite('resources/css/app.css')
</head>

<body class="min-h-screen bg-slate-950 p-5 text-white md:p-10">
    <main class="mx-auto max-w-7xl">

        <a href="{{ route('admin.dashboard') }}"
           class="text-sm text-cyan-400 hover:text-cyan-300">
            ← Kembali ke Dashboard
        </a>

        <header class="mb-8 mt-5 flex flex-wrap items-end justify-between gap-4">
            <div>
                <p class="text-xs font-bold tracking-[0.25em] text-cyan-400">
                    TIFONE.ALGORITHM
                </p>

                <h1 class="mt-3 text-3xl font-black md:text-4xl">
                    Pengumuman Kelas
                </h1>

                <p class="mt-2 text-slate-400">
                    Kelola informasi untuk mahasiswa IF 1 UNIKOM.
                </p>
            </div>

            <a href="{{ route('admin.announcements.create') }}"
               class="rounded-xl bg-cyan-500 px-5 py-3 font-bold text-slate-950 transition hover:bg-cyan-400">
                + Tambah Pengumuman
            </a>
        </header>

        @if (session('success'))
            <div class="mb-6 rounded-xl border border-emerald-800 bg-emerald-950 p-4 text-emerald-300">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="mb-6 rounded-xl border border-red-800 bg-red-950 p-4 text-red-300">
                <ul class="list-inside list-disc">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <section class="overflow-hidden rounded-2xl border border-slate-800 bg-slate-900">
            <div class="flex flex-wrap items-center justify-between gap-3 border-b border-slate-800 p-5">
                <div>
                    <h2 class="font-bold">Daftar Pengumuman</h2>
                    <p class="mt-1 text-sm text-slate-400">
                        Total {{ $announcements->total() }} pengumuman.
                    </p>
                </div>

                <span class="rounded-full bg-slate-800 px-3 py-1 text-xs text-slate-300">
                    Halaman {{ $announcements->currentPage() }}
                </span>
            </div>

            @if ($announcements->count())
                <div class="overflow-x-auto">
                    <table class="w-full min-w-[760px] text-left text-sm">
                        <thead class="bg-slate-950/70 text-xs uppercase tracking-wider text-slate-400">
                            <tr>
                                <th class="px-5 py-4">No.</th>
                                <th class="px-5 py-4">Judul</th>
                                <th class="px-5 py-4">Tanggal Publikasi</th>
                                <th class="px-5 py-4">Status</th>
                                <th class="px-5 py-4">Tindakan</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-slate-800">
                            @foreach ($announcements as $announcement)
                                <tr class="transition hover:bg-slate-800/50">
                                    <td class="px-5 py-4 text-slate-500">
                                        {{ $announcements->firstItem() + $loop->index }}
                                    </td>

                                    <td class="max-w-sm px-5 py-4">
                                        <p class="font-semibold text-white">
                                            {{ $announcement->title }}
                                        </p>

                                        <p class="mt-1 text-xs text-slate-500">
                                            {{ \Illuminate\Support\Str::limit($announcement->content, 85) }}
                                        </p>
                                    </td>

                                    <td class="px-5 py-4 text-slate-300">
                                        {{ $announcement->published_at
                                            ? $announcement->published_at->format('d/m/Y H:i')
                                            : 'Belum dijadwalkan' }}
                                    </td>

                                    <td class="px-5 py-4">
                                        @if ($announcement->is_published)
                                            <span class="rounded-full bg-emerald-500/10 px-3 py-1.5 text-xs font-semibold text-emerald-400">
                                                Dipublikasikan
                                            </span>
                                        @else
                                            <span class="rounded-full bg-amber-500/10 px-3 py-1.5 text-xs font-semibold text-amber-400">
                                                Draft
                                            </span>
                                        @endif
                                    </td>

                                    <td class="px-5 py-4">
                                        <div class="flex items-center gap-3">
                                            <a href="{{ route('admin.announcements.show', $announcement) }}"
                                               class="font-semibold text-cyan-400 hover:text-cyan-300">
                                                Detail
                                            </a>

                                            <a href="{{ route('admin.announcements.edit', $announcement) }}"
                                               class="font-semibold text-amber-400 hover:text-amber-300">
                                                Edit
                                            </a>

                                            <form action="{{ route('admin.announcements.destroy', $announcement) }}"
                                                  method="POST"
                                                  onsubmit="return confirm('Yakin ingin menghapus pengumuman ini?')">
                                                @csrf
                                                @method('DELETE')

                                                <button type="submit"
                                                    class="font-semibold text-red-400 hover:text-red-300">
                                                    Hapus
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="border-t border-slate-800 p-5">
                    {{ $announcements->links() }}
                </div>
            @else
                <div class="px-6 py-16 text-center">
                    <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-2xl bg-slate-800 text-3xl">
                        📢
                    </div>

                    <h3 class="mt-5 text-lg font-bold">
                        Belum Ada Pengumuman
                    </h3>

                    <p class="mx-auto mt-2 max-w-md text-sm leading-6 text-slate-400">
                        Mulai tambahkan pengumuman agar informasi penting kelas
                        IF 1 bisa dikelola melalui dashboard.
                    </p>

                    <a href="{{ route('admin.announcements.create') }}"
                       class="mt-5 inline-block rounded-xl bg-cyan-500 px-5 py-3 font-bold text-slate-950 hover:bg-cyan-400">
                        Buat Pengumuman Pertama
                    </a>
                </div>
            @endif
        </section>

        <footer class="mt-8 text-center text-xs text-slate-600">
            TIFONE.ALGORITHM · Panel Administrasi IF 1 UNIKOM
        </footer>
    </main>
</body>
</html>
