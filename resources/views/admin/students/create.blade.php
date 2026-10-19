
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Mahasiswa — TIFONE.ALGORITHM</title>
    @vite(['resources/css/app.css', 'resources/js/app.jsx'])
</head>

<body class="min-h-screen bg-slate-950 p-5 text-white md:p-10">
    <main class="mx-auto max-w-3xl">

        {{-- NAVIGASI --}}
        <a href="{{ route('admin.students.index') }}"
           class="text-sm text-cyan-400 transition hover:text-cyan-300">
            ← Kembali ke Data Mahasiswa
        </a>

        {{-- HEADER --}}
        <header class="mb-8 mt-5">
            <p class="text-xs font-bold uppercase tracking-[0.3em] text-cyan-400">
                TIFONE.ALGORITHM · IF 1 UNIKOM
            </p>

            <h1 class="mt-3 text-3xl font-black md:text-4xl">
                Tambah Mahasiswa
            </h1>

            <p class="mt-2 leading-6 text-slate-400">
                Lengkapi informasi mahasiswa untuk ditampilkan pada website kelas.
            </p>

            <p class="mt-3 text-sm text-slate-500">
                Kolom bertanda <span class="text-red-400">*</span> wajib diisi.
            </p>
        </header>

        {{-- PESAN ERROR --}}
        @if ($errors->any())
            <div class="mb-6 rounded-xl border border-red-800 bg-red-950/70 p-4 text-red-300"
                 role="alert">
                <p class="mb-2 font-bold">
                    Data belum dapat disimpan.
                </p>

                <ul class="list-inside list-disc space-y-1 text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- FORM TAMBAH MAHASISWA --}}
        <form
            action="{{ route('admin.students.store') }}"
            method="POST"
            enctype="multipart/form-data"
            class="space-y-6 rounded-2xl border border-slate-800 bg-slate-900 p-6 shadow-xl shadow-black/10 md:p-8"
        >
            @csrf

            {{-- NIM --}}
            <div>
                <label for="nim" class="mb-2 block text-sm font-semibold">
                    NIM <span class="text-red-400">*</span>
                </label>

                <input
                    id="nim"
                    name="nim"
                    type="text"
                    value="{{ old('nim') }}"
                    maxlength="30"
                    required
                    autocomplete="off"
                    aria-describedby="nim-help"
                    class="w-full rounded-xl border border-slate-700 bg-slate-950 p-3.5 text-white outline-none transition placeholder:text-slate-600 focus:border-cyan-400 focus:ring-2 focus:ring-cyan-400/20"
                    placeholder="Masukkan NIM mahasiswa"
                >

                <p id="nim-help" class="mt-2 text-xs text-slate-500">
                    NIM harus unik dan tidak boleh sama dengan mahasiswa lain.
                </p>
            </div>

            {{-- NAMA LENGKAP --}}
            <div>
                <label for="name" class="mb-2 block text-sm font-semibold">
                    Nama Lengkap <span class="text-red-400">*</span>
                </label>

                <input
                    id="name"
                    name="name"
                    type="text"
                    value="{{ old('name') }}"
                    maxlength="255"
                    required
                    autocomplete="name"
                    class="w-full rounded-xl border border-slate-700 bg-slate-950 p-3.5 text-white outline-none transition placeholder:text-slate-600 focus:border-cyan-400 focus:ring-2 focus:ring-cyan-400/20"
                    placeholder="Masukkan nama lengkap"
                >
            </div>

            {{-- KELAS --}}
            <div>
                <label for="class_name" class="mb-2 block text-sm font-semibold">
                    Kelas <span class="text-red-400">*</span>
                </label>

                <input
                    id="class_name"
                    name="class_name"
                    type="text"
                    value="{{ old('class_name', 'IF 1') }}"
                    maxlength="100"
                    required
                    class="w-full rounded-xl border border-slate-700 bg-slate-950 p-3.5 text-white outline-none transition focus:border-cyan-400 focus:ring-2 focus:ring-cyan-400/20"
                >
            </div>

            {{-- EMAIL DAN TELEPON --}}
            <div class="grid gap-6 sm:grid-cols-2">
                <div>
                    <label for="email" class="mb-2 block text-sm font-semibold">
                        Email
                    </label>

                    <input
                        id="email"
                        name="email"
                        type="email"
                        value="{{ old('email') }}"
                        maxlength="255"
                        autocomplete="email"
                        class="w-full rounded-xl border border-slate-700 bg-slate-950 p-3.5 text-white outline-none transition placeholder:text-slate-600 focus:border-cyan-400 focus:ring-2 focus:ring-cyan-400/20"
                        placeholder="nama@email.com"
                    >
                </div>

                <div>
                    <label for="phone" class="mb-2 block text-sm font-semibold">
                        Nomor Telepon
                    </label>

                    <input
                        id="phone"
                        name="phone"
                        type="tel"
                        value="{{ old('phone') }}"
                        maxlength="30"
                        autocomplete="tel"
                        class="w-full rounded-xl border border-slate-700 bg-slate-950 p-3.5 text-white outline-none transition placeholder:text-slate-600 focus:border-cyan-400 focus:ring-2 focus:ring-cyan-400/20"
                        placeholder="Contoh: 08xxxxxxxxxx"
                    >
                </div>
            </div>

            {{-- INSTAGRAM --}}
            <div>
                <label for="instagram" class="mb-2 block text-sm font-semibold">
                    Instagram
                </label>

                <input
                    id="instagram"
                    name="instagram"
                    type="text"
                    value="{{ old('instagram') }}"
                    maxlength="255"
                    autocomplete="off"
                    class="w-full rounded-xl border border-slate-700 bg-slate-950 p-3.5 text-white outline-none transition placeholder:text-slate-600 focus:border-cyan-400 focus:ring-2 focus:ring-cyan-400/20"
                    placeholder="@username"
                >

                <p class="mt-2 text-xs text-slate-500">
                    Masukkan username Instagram, misalnya @namakamu.
                </p>
            </div>

            {{-- FOTO --}}
            <div>
                <label for="photo" class="mb-2 block text-sm font-semibold">
                    Foto Mahasiswa
                </label>

                <input
                    id="photo"
                    name="photo"
                    type="file"
                    accept=".jpg,.jpeg,.png,.webp,image/jpeg,image/png,image/webp"
                    aria-describedby="photo-help"
                    class="w-full rounded-xl border border-slate-700 bg-slate-950 p-3 text-sm text-slate-300 outline-none transition file:mr-4 file:cursor-pointer file:rounded-lg file:border-0 file:bg-cyan-500 file:px-4 file:py-2 file:font-bold file:text-slate-950 hover:file:bg-cyan-400 focus:border-cyan-400"
                >

                <p id="photo-help" class="mt-2 text-xs leading-5 text-slate-500">
                    Format JPG, JPEG, PNG, atau WEBP. Ukuran maksimal 2 MB.
                </p>

                {{-- PREVIEW FOTO --}}
                <div id="photo-preview-container" class="mt-4 hidden">
                    <p class="mb-2 text-sm text-slate-400">Pratinjau foto:</p>

                    <img
                        id="photo-preview"
                        src=""
                        alt="Pratinjau foto mahasiswa"
                        class="h-36 w-36 rounded-2xl border border-slate-700 object-cover"
                    >

                    <button
                        id="remove-photo"
                        type="button"
                        class="mt-3 block text-sm font-semibold text-red-400 hover:text-red-300"
                    >
                        Hapus pilihan foto
                    </button>
                </div>

                <p id="photo-error" class="mt-3 hidden text-sm text-red-400" role="alert"></p>
            </div>

            {{-- BIODATA --}}
            <div>
                <div class="mb-2 flex items-center justify-between gap-3">
                    <label for="bio" class="text-sm font-semibold">
                        Biodata Singkat
                    </label>

                    <span id="bio-counter" class="text-xs text-slate-500">
                        0/1000
                    </span>
                </div>

                <textarea
                    id="bio"
                    name="bio"
                    rows="4"
                    maxlength="1000"
                    class="w-full rounded-xl border border-slate-700 bg-slate-950 p-3.5 text-white outline-none transition placeholder:text-slate-600 focus:border-cyan-400 focus:ring-2 focus:ring-cyan-400/20"
                    placeholder="Ceritakan sedikit tentang mahasiswa ini..."
                >{{ old('bio') }}</textarea>

                <p class="mt-2 text-xs text-slate-500">
                    Biodata dapat ditampilkan pada profil publik mahasiswa.
                </p>
            </div>

            {{-- TOMBOL --}}
            <div class="flex flex-wrap gap-3 border-t border-slate-800 pt-6">
                <button
                    type="submit"
                    class="rounded-xl bg-cyan-500 px-6 py-3 font-bold text-slate-950 transition hover:bg-cyan-400 focus:outline-none focus:ring-2 focus:ring-cyan-300 focus:ring-offset-2 focus:ring-offset-slate-900"
                >
                    Simpan Mahasiswa
                </button>

                <a
                    href="{{ route('admin.students.index') }}"
                    class="rounded-xl border border-slate-700 px-6 py-3 font-semibold text-slate-300 transition hover:bg-slate-800"
                >
                    Batal
                </a>
            </div>
        </form>

        {{-- FOOTER --}}
        <footer class="mt-8 text-center text-xs text-slate-500">
            © {{ date('Y') }} TIFONE.ALGORITHM · IF 1 UNIKOM
        </footer>
    </main>

    {{-- PREVIEW FOTO DAN PENGHITUNG BIODATA --}}
    <script>
        const photoInput = document.getElementById('photo');
        const previewContainer = document.getElementById('photo-preview-container');
        const previewImage = document.getElementById('photo-preview');
        const removePhotoButton = document.getElementById('remove-photo');
        const photoError = document.getElementById('photo-error');

        const bioInput = document.getElementById('bio');
        const bioCounter = document.getElementById('bio-counter');

        const allowedTypes = ['image/jpeg', 'image/png', 'image/webp'];
        const maxFileSize = 2 * 1024 * 1024;

        function clearPhotoPreview() {
            photoInput.value = '';
            previewImage.removeAttribute('src');
            previewContainer.classList.add('hidden');
        }

        photoInput.addEventListener('change', function () {
            photoError.textContent = '';
            photoError.classList.add('hidden');

            const file = this.files[0];

            if (!file) {
                clearPhotoPreview();
                return;
            }

            if (!allowedTypes.includes(file.type)) {
                clearPhotoPreview();
                photoError.textContent = 'Format foto harus JPG, JPEG, PNG, atau WEBP.';
                photoError.classList.remove('hidden');
                return;
            }

            if (file.size > maxFileSize) {
                clearPhotoPreview();
                photoError.textContent = 'Ukuran foto maksimal 2 MB.';
                photoError.classList.remove('hidden');
                return;
            }

            previewImage.src = URL.createObjectURL(file);
            previewContainer.classList.remove('hidden');
        });

        removePhotoButton.addEventListener('click', clearPhotoPreview);

        function updateBioCounter() {
            bioCounter.textContent = `${bioInput.value.length}/1000`;
        }

        bioInput.addEventListener('input', updateBioCounter);
        updateBioCounter();
    </script>
</body>
</html>
