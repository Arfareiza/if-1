
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Moderasi Menfess — TIFONE.ALGORITHM</title>
    @vite(['resources/css/app.css', 'resources/js/app.jsx'])
</head>

<body class="min-h-screen bg-slate-950 text-white">
<main class="mx-auto max-w-7xl p-5 md:p-10">

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
                Moderasi Menfess
            </h1>

            <p class="mt-2 text-slate-400">
                Periksa, setujui, atau tolak pesan anonim mahasiswa.
            </p>
        </div>

        <a href="{{ route('home') }}#menfess"
           target="_blank"
           rel="noopener noreferrer"
           class="rounded-xl border border-cyan-500/30 px-5 py-3 font-bold text-cyan-300 transition hover:bg-cyan-400/10">
            Lihat Website Publik ↗
        </a>
    </header>

    @if (session('success'))
        <div class="mb-6 rounded-xl border border-emerald-800 bg-emerald-950 p-4 text-emerald-300">
            {{ session('success') }}
        </div>
    @endif

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

    @php
        $totalAll = $totalPending + $totalApproved + $totalRejected;
    @endphp

    <section class="mb-6 grid gap-4 sm:grid-cols-2 lg:grid-cols-4">

        <a href="{{ route('admin.confessions.index') }}"
           class="rounded-2xl border border-slate-800 bg-slate-900 p-5 transition hover:border-cyan-500/50">
            <p class="text-sm text-slate-400">Total Menfess</p>
            <p class="mt-3 text-3xl font-black text-cyan-400">{{ $totalAll }}</p>
            <p class="mt-2 text-xs text-slate-500">Semua pesan tersimpan</p>
        </a>

        <a href="{{ route('admin.confessions.index', ['status' => 'pending']) }}"
           class="rounded-2xl border border-amber-500/20 bg-slate-900 p-5 transition hover:border-amber-400/60">
            <p class="text-sm text-slate-400">Menunggu Persetujuan</p>
            <p class="mt-3 text-3xl font-black text-amber-400">{{ $totalPending }}</p>
            <p class="mt-2 text-xs text-slate-500">Perlu diperiksa admin</p>
        </a>

        <a href="{{ route('admin.confessions.index', ['status' => 'approved']) }}"
           class="rounded-2xl border border-emerald-500/20 bg-slate-900 p-5 transition hover:border-emerald-400/60">
            <p class="text-sm text-slate-400">Disetujui</p>
            <p class="mt-3 text-3xl font-black text-emerald-400">{{ $totalApproved }}</p>
            <p class="mt-2 text-xs text-slate-500">Dapat ditampilkan publik</p>
        </a>

        <a href="{{ route('admin.confessions.index', ['status' => 'rejected']) }}"
           class="rounded-2xl border border-red-500/20 bg-slate-900 p-5 transition hover:border-red-400/60">
            <p class="text-sm text-slate-400">Ditolak</p>
            <p class="mt-3 text-3xl font-black text-red-400">{{ $totalRejected }}</p>
            <p class="mt-2 text-xs text-slate-500">Tidak ditampilkan publik</p>
        </a>

    </section>

    <section class="overflow-hidden rounded-2xl border border-slate-800 bg-slate-900">

        <div class="flex flex-wrap items-center justify-between gap-4 border-b border-slate-800 p-5">
            <div>
                <h2 class="text-lg font-bold">Daftar Menfess</h2>
                <p class="mt-1 text-sm text-slate-400">
                    Periksa isi pesan sebelum menyetujuinya.
                </p>
            </div>

            <form action="{{ route('admin.confessions.index') }}"
                  method="GET"
                  class="flex flex-wrap items-center gap-2">

                <label for="status" class="text-sm text-slate-400">
                    Filter:
                </label>

                <select
                    id="status"
                    name="status"
                    onchange="this.form.submit()"
                    class="rounded-xl border border-slate-700 bg-slate-950 px-4 py-2 text-sm text-white focus:border-cyan-400 focus:outline-none"
                >
                    <option value="" @selected(!request()->filled('status'))>
                        Semua Status
                    </option>
                    <option value="pending" @selected(request('status') === 'pending')>
                        Menunggu
                    </option>
                    <option value="approved" @selected(request('status') === 'approved')>
                        Disetujui
                    </option>
                    <option value="rejected" @selected(request('status') === 'rejected')>
                        Ditolak
                    </option>
                </select>
            </form>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full min-w-[900px] text-left text-sm">
                <thead class="border-b border-slate-800 bg-slate-800/70 text-xs uppercase tracking-wider text-slate-300">
                    <tr>
                        <th class="px-5 py-4">No.</th>
                        <th class="px-5 py-4">Pesan Menfess</th>
                        <th class="px-5 py-4">Status</th>
                        <th class="px-5 py-4">Waktu</th>
                        <th class="px-5 py-4 text-right">Aksi</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-slate-800">
                    @forelse ($confessions as $confession)
                        <tr class="align-top transition hover:bg-slate-800/50">

                            <td class="whitespace-nowrap px-5 py-5 text-slate-500">
                                {{ $confessions->firstItem() + $loop->index }}
                            </td>

                            <td class="max-w-xl px-5 py-5">
                                @if ($confession->recipient)
                                    <p class="mb-2 text-xs text-cyan-300">
                                        Untuk: {{ $confession->recipient }}
                                    </p>
                                @endif

                                <p class="whitespace-pre-line break-words leading-7 text-slate-200">{{ $confession->message }}</p>

                                <p class="mt-2 text-xs text-slate-500">
                                    ID Menfess: #{{ $confession->id }}
                                </p>
                            </td>

                            <td class="whitespace-nowrap px-5 py-5">
                                @if ($confession->status === 'pending')
                                    <span class="rounded-full border border-amber-400/20 bg-amber-400/10 px-3 py-1 text-xs font-semibold text-amber-300">
                                        Menunggu
                                    </span>
                                @elseif ($confession->status === 'approved')
                                    <span class="rounded-full border border-emerald-400/20 bg-emerald-400/10 px-3 py-1 text-xs font-semibold text-emerald-300">
                                        Disetujui
                                    </span>
                                @elseif ($confession->status === 'rejected')
                                    <span class="rounded-full border border-red-400/20 bg-red-400/10 px-3 py-1 text-xs font-semibold text-red-300">
                                        Ditolak
                                    </span>
                                @else
                                    <span class="rounded-full border border-slate-700 px-3 py-1 text-xs text-slate-400">
                                        {{ $confession->status }}
                                    </span>
                                @endif
                            </td>

                            <td class="whitespace-nowrap px-5 py-5 text-slate-400">
                                {{ $confession->created_at?->format('d/m/Y') ?? '—' }}
                                <p class="mt-1 text-xs text-slate-500">
                                    {{ $confession->created_at?->format('H:i') ?? '' }}
                                </p>
                            </td>

                            <td class="px-5 py-5">
                                <div class="flex flex-col items-end gap-3">

                                    @if ($confession->status !== 'approved')
                                        <form
                                            action="{{ route('admin.confessions.approve', $confession) }}"
                                            method="POST"
                                            onsubmit="return confirm('Setujui menfess ini agar dapat ditampilkan di website publik?')"
                                        >
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit"
                                                class="font-semibold text-emerald-400 hover:text-emerald-300">
                                                ✓ Setujui
                                            </button>
                                        </form>
                                    @endif

                                    @if ($confession->status !== 'rejected')
                                        <form
                                            action="{{ route('admin.confessions.reject', $confession) }}"
                                            method="POST"
                                            onsubmit="return confirm('Tolak menfess ini?')"
                                        >
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit"
                                                class="font-semibold text-amber-400 hover:text-amber-300">
                                                ✕ Tolak
                                            </button>
                                        </form>
                                    @endif

                                    <form
                                        action="{{ route('admin.confessions.destroy', $confession) }}"
                                        method="POST"
                                        onsubmit="return confirm('Yakin ingin menghapus menfess ini secara permanen?')"
                                    >
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
                    @empty
                        <tr>
                            <td colspan="5" class="px-5 py-12 text-center">
                                <p class="text-lg font-bold text-slate-300">
                                    Belum ada Menfess
                                </p>
                                <p class="mt-2 text-sm text-slate-500">
                                    Pesan yang sesuai filter akan muncul di sini.
                                </p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($confessions->hasPages())
            <div class="border-t border-slate-800 p-5">
                {{ $confessions->links() }}
            </div>
        @endif

    </section>

    <footer class="mt-6 flex flex-wrap items-center justify-between gap-3 text-xs text-slate-500">
        <p>© {{ date('Y') }} TIFONE.ALGORITHM</p>
        <p>IF 1 · Teknik Informatika UNIKOM</p>
    </footer>

</main>
</body>
</html>
