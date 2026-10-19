
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Pengumuman — TIFONE.ALGORITHM</title>
    @vite('resources/css/app.css')
</head>
<body class="min-h-screen bg-slate-100 text-slate-800">
    <div class="mx-auto max-w-4xl px-4 py-8 sm:px-6 lg:px-8">

        <div class="mb-8">
            <a href="{{ route('admin.announcements.index') }}"
               class="text-sm font-semibold text-indigo-600 hover:text-indigo-800">
                ← Kembali ke Pengumuman
            </a>

            <h1 class="mt-4 text-3xl font-black tracking-tight">
                Tambah Pengumuman
            </h1>

            <p class="mt-2 text-slate-500">
                Buat informasi terbaru untuk mahasiswa IF 1 UNIKOM.
            </p>
        </div>

        @if ($errors->any())
            <div class="mb-6 rounded-xl border border-red-200 bg-red-50 p-4 text-red-700">
                <p class="font-bold">Ada data yang perlu diperbaiki:</p>
                <ul class="mt-2 list-inside list-disc text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.announcements.store') }}"
              method="POST"
              class="space-y-6 rounded-2xl border border-slate-200 bg-white p-6 shadow-sm sm:p-8">
            @csrf

            <div>
                <label for="title" class="mb-2 block text-sm font-bold">
                    Judul Pengumuman <span class="text-red-500">*</span>
                </label>

                <input
                    type="text"
                    id="title"
                    name="title"
                    value="{{ old('title') }}"
                    maxlength="255"
                    required
                    placeholder="Contoh: Informasi Jadwal Ujian"
                    class="w-full rounded-xl border border-slate-300 px-4 py-3 outline-none transition focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100"
                >
            </div>

            <div>
                <label for="content" class="mb-2 block text-sm font-bold">
                    Isi Pengumuman <span class="text-red-500">*</span>
                </label>

                <textarea
                    id="content"
                    name="content"
                    rows="8"
                    required
                    placeholder="Tuliskan informasi pengumuman di sini..."
                    class="w-full rounded-xl border border-slate-300 px-4 py-3 outline-none transition focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100"
                >{{ old('content') }}</textarea>

                <p class="mt-2 text-xs text-slate-500">
                    Gunakan bahasa yang jelas agar mudah dipahami seluruh mahasiswa.
                </p>
            </div>

            <div>
                <label for="is_published" class="mb-2 block text-sm font-bold">
                    Status Pengumuman
                </label>

                <select
                    id="is_published"
                    name="is_published"
                    required
                    class="w-full rounded-xl border border-slate-300 bg-white px-4 py-3 outline-none transition focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100"
                >
                    <option value="0" @selected(old('is_published', '0') == '0')>
                        Draft — belum ditampilkan ke mahasiswa
                    </option>
                    <option value="1" @selected(old('is_published') == '1')>
                        Terbitkan — tampilkan pengumuman
                    </option>
                </select>
            </div>

            <div>
                <label for="published_at" class="mb-2 block text-sm font-bold">
                    Waktu Publikasi (opsional)
                </label>

                <input
                    type="datetime-local"
                    id="published_at"
                    name="published_at"
                    value="{{ old('published_at') }}"
                    class="w-full rounded-xl border border-slate-300 px-4 py-3 outline-none transition focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100"
                >

                <p class="mt-2 text-xs text-slate-500">
                    Jika dikosongkan saat pengumuman diterbitkan, waktu sekarang akan digunakan.
                </p>
            </div>

            <div class="flex flex-col-reverse gap-3 border-t border-slate-100 pt-6 sm:flex-row sm:justify-end">
                <a
                    href="{{ route('admin.announcements.index') }}"
                    class="rounded-xl border border-slate-300 px-5 py-3 text-center font-semibold text-slate-700 transition hover:bg-slate-50"
                >
                    Batal
                </a>

                <button
                    type="submit"
                    class="rounded-xl bg-indigo-600 px-5 py-3 font-bold text-white shadow-sm transition hover:bg-indigo-700"
                >
                    Simpan Pengumuman
                </button>
            </div>
        </form>

        <p class="mt-6 text-center text-xs text-slate-400">
            TIFONE.ALGORITHM · IF 1 UNIKOM
        </p>
    </div>
</body>
</html>
