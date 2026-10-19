<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Detail Pengumuman — TIFONE.ALGORITHM</title>

    @vite('resources/css/app.css')
</head>

<body class="min-h-screen bg-slate-100 text-slate-800">
    <div class="mx-auto max-w-4xl px-4 py-8 sm:px-6 lg:px-8">

        <!-- NAVIGASI -->
        <a href="{{ route('admin.announcements.index') }}"
           class="text-sm font-semibold text-indigo-600 hover:text-indigo-800">
            ← Kembali ke Pengumuman
        </a>

        <!-- KONTEN -->
        <article class="mt-6 overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">

            <!-- HEADER KARTU -->
            <div class="border-b border-slate-100 bg-slate-50 p-6 sm:p-8">
                <div class="flex flex-wrap items-center justify-between gap-3">
                    <span class="inline-flex rounded-full px-3 py-1 text-xs font-bold
                        {{ $announcement->is_published
                            ? 'bg-emerald-100 text-emerald-700'
                            : 'bg-amber-100 text-amber-700' }}">
                        {{ $announcement->is_published ? 'Sudah diterbitkan' : 'Draft' }}
                    </span>

                    <span class="text-xs text-slate-500">
                        ID Pengumuman: #{{ $announcement->id }}
                    </span>
                </div>

                <h1 class="mt-5 break-words text-2xl font-black leading-tight sm:text-3xl">
                    {{ $announcement->title }}
                </h1>

                <p class="mt-4 text-sm text-slate-500">
                    Dibuat pada
                    {{ $announcement->created_at->format('d M Y, H:i') }}
                </p>

                @if ($announcement->published_at)
                    <p class="mt-1 text-sm text-slate-500">
                        Waktu publikasi:
                        {{ $announcement->published_at->format('d M Y, H:i') }}
                    </p>
                @endif
            </div>

            <!-- ISI PENGUMUMAN -->
            <div class="p-6 sm:p-8">
                <h2 class="mb-4 text-sm font-bold uppercase tracking-wider text-slate-400">
                    Isi Pengumuman
                </h2>

                <div class="whitespace-pre-line break-words text-base leading-8 text-slate-700">{{ $announcement->content }}</div>
            </div>

            <!-- TOMBOL AKSI -->
            <div class="flex flex-col gap-3 border-t border-slate-100 bg-slate-50 p-6 sm:flex-row sm:justify-between">
                <a
                    href="{{ route('admin.announcements.index') }}"
                    class="rounded-xl border border-slate-300 px-5 py-3 text-center text-sm font-semibold text-slate-700 transition hover:bg-white"
                >
                    Kembali ke Daftar
                </a>

                <a
                    href="{{ route('admin.announcements.edit', $announcement) }}"
                    class="rounded-xl bg-indigo-600 px-5 py-3 text-center text-sm font-bold text-white transition hover:bg-indigo-700"
                >
                    ✎ Edit Pengumuman
                </a>
            </div>

        </article>

        <footer class="mt-8 text-center text-xs text-slate-400">
            TIFONE.ALGORITHM · IF 1 UNIKOM
        </footer>

    </div>
</body>
</html>
```