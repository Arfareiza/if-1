
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Edit Mahasiswa | TIFONE.ALGORITHM</title>

    @vite('resources/css/app.css')
</head>

<body class="min-h-screen bg-slate-950 p-5 text-white md:p-10">
    <main class="mx-auto max-w-3xl">

        <a href="{{ route('admin.students.index') }}"
           class="text-sm text-cyan-400 transition hover:text-cyan-300">
            ← Kembali ke Data Mahasiswa
        </a>

        <header class="mb-8 mt-5">
            <p class="text-sm font-bold tracking-[0.25em] text-cyan-400">
                TIFONE.ALGORITHM
            </p>

            <h1 class="mt-3 text-3xl font-black md:text-4xl">
                Edit Data Mahasiswa
            </h1>

            <p class="mt-2 text-slate-400">
                Perbarui informasi mahasiswa IF 1 UNIKOM.
            </p>
        </header>

        @if (session('success'))
            <div class="mb-6 rounded-xl border border-emerald-800 bg-emerald-950 p-4 text-emerald-300">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="mb-6 rounded-xl border border-red-800 bg-red-950 p-4 text-red-300">
                <p class="mb-2 font-bold">Periksa kembali data berikut:</p>

                <ul class="list-inside list-disc space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form
            action="{{ route('admin.students.update', $student) }}"
            method="POST"
            enctype="multipart/form-data"
            class="space-y-6 rounded-2xl border border-slate-800 bg-slate-900 p-6 shadow-xl md:p-8"
        >
            @csrf
            @method('PUT')

            <div>
                <label for="nim" class="mb-2 block text-sm font-semibold">
                    NIM <span class="text-red-400">*</span>
                </label>

                <input
                    id="nim"
                    type="text"
                    name="nim"
                    value="{{ old('nim', $student->nim) }}"
                    maxlength="30"
                    required
                    autocomplete="off"
                    class="w-full rounded-xl border border-slate-700 bg-slate-800 p-3 text-white outline-none transition focus:border-cyan-400 focus:ring-2 focus:ring-cyan-400/20"
                >
            </div>

            <div>
                <label for="name" class="mb-2 block text-sm font-semibold">
                    Nama Lengkap <span class="text-red-400">*</span>
                </label>

                <input
                    id="name"
                    type="text"
                    name="name"
                    value="{{ old('name', $student->name) }}"
                    maxlength="255"
                    required
                    autocomplete="name"
                    class="w-full rounded-xl border border-slate-700 bg-slate-800 p-3 text-white outline-none transition focus:border-cyan-400 focus:ring-2 focus:ring-cyan-400/20"
                >
            </div>

            <div>
                <label for="class_name" class="mb-2 block text-sm font-semibold">
                    Kelas <span class="text-red-400">*</span>
                </label>

                <input
                    id="class_name"
                    type="text"
                    name="class_name"
                    value="{{ old('class_name', $student->class_name) }}"
                    maxlength="100"
                    required
                    class="w-full rounded-xl border border-slate-700 bg-slate-800 p-3 text-white outline-none transition focus:border-cyan-400 focus:ring-2 focus:ring-cyan-400/20"
                >
            </div>

            <div>
                <label for="email" class="mb-2 block text-sm font-semibold">
                    Email
                </label>

                <input
                    id="email"
                    type="email"
                    name="email"
                    value="{{ old('email', $student->email) }}"
                    maxlength="255"
                    autocomplete="email"
                    class="w-full rounded-xl border border-slate-700 bg-slate-800 p-3 text-white outline-none transition focus:border-cyan-400 focus:ring-2 focus:ring-cyan-400/20"
                >
            </div>

            <div>
                <label for="phone" class="mb-2 block text-sm font-semibold">
                    Nomor Telepon
                </label>

                <input
                    id="phone"
                    type="text"
                    name="phone"
                    value="{{ old('phone', $student->phone) }}"
                    maxlength="30"
                    autocomplete="tel"
                    class="w-full rounded-xl border border-slate-700 bg-slate-800 p-3 text-white outline-none transition focus:border-cyan-400 focus:ring-2 focus:ring-cyan-400/20"
                >
            </div>

            <div>
                <label for="instagram" class="mb-2 block text-sm font-semibold">
                    Instagram
                </label>

                <input
                    id="instagram"
                    type="text"
                    name="instagram"
                    value="{{ old('instagram', $student->instagram) }}"
                    maxlength="255"
                    placeholder="@username"
                    class="w-full rounded-xl border border-slate-700 bg-slate-800 p-3 text-white outline-none transition focus:border-cyan-400 focus:ring-2 focus:ring-cyan-400/20"
                >
            </div>

            <div>
                <label class="mb-3 block text-sm font-semibold">
                    Foto Profil
                </label>

                <div class="mb-4 flex flex-wrap items-center gap-4">
                    <div>
                        <p class="mb-2 text-xs text-slate-400">Foto saat ini</p>

                        @if ($student->photo)
                            <img
                                src="{{ asset('storage/' . $student->photo) }}"
                                alt="Foto mahasiswa saat ini"
                                class="h-28 w-28 rounded-xl border border-slate-700 object-cover"
                            >
                        @else
                            <div class="flex h-28 w-28 items-center justify-center rounded-xl border border-dashed border-slate-700 bg-slate-800 text-center text-xs text-slate-400">
                                Belum ada foto
                            </div>
                        @endif
                    </div>

                    <div id="preview-container" class="hidden">
                        <p class="mb-2 text-xs text-cyan-400">Pratinjau foto baru</p>

                        <img
                            id="photo-preview"
                            src=""
                            alt="Pratinjau foto baru"
                            class="h-28 w-28 rounded-xl border border-cyan-500 object-cover"
                        >
                    </div>
                </div>

                <input
                    id="photo"
                    type="file"
                    name="photo"
                    accept=".jpg,.jpeg,.png,.webp,image/jpeg,image/png,image/webp"
                    class="w-full rounded-xl border border-slate-700 bg-slate-800 p-3 text-sm text-slate-300 file:mr-4 file:rounded-lg file:border-0 file:bg-cyan-500 file:px-4 file:py-2 file:font-bold file:text-slate-950 hover:file:bg-cyan-400"
                >

                <p class="mt-2 text-xs text-slate-400">
                    Format JPG, JPEG, PNG, atau WEBP. Maksimal 2 MB.
                    Kosongkan jika tidak ingin mengganti foto.
                </p>

                <p id="photo-error" class="mt-2 hidden text-sm text-red-400"></p>

                <button
                    id="remove-photo"
                    type="button"
                    class="mt-3 hidden text-sm text-red-400 hover:text-red-300"
                >
                    Batalkan foto baru
                </button>
            </div>

            <div>
                <div class="mb-2 flex items-center justify-between gap-3">
                    <label for="bio" class="text-sm font-semibold">
                        Biodata
                    </label>

                    <span id="bio-counter" class="text-xs text-slate-400">
                        0/1000 karakter
                    </span>
                </div>

                <textarea
                    id="bio"
                    name="bio"
                    rows="5"
                    maxlength="1000"
                    placeholder="Tuliskan biodata singkat mahasiswa..."
                    class="w-full resize-y rounded-xl border border-slate-700 bg-slate-800 p-3 text-white outline-none transition focus:border-cyan-400 focus:ring-2 focus:ring-cyan-400/20"
                >{{ old('bio', $student->bio) }}</textarea>
            </div>

            <div class="flex flex-wrap gap-3 border-t border-slate-800 pt-6">
                <button
                    type="submit"
                    class="rounded-xl bg-cyan-500 px-6 py-3 font-bold text-slate-950 transition hover:bg-cyan-400"
                >
                    Simpan Perubahan
                </button>

                <a
                    href="{{ route('admin.students.index') }}"
                    class="rounded-xl border border-slate-700 px-6 py-3 font-semibold transition hover:bg-slate-800"
                >
                    Batal
                </a>
            </div>
        </form>
    </main>

    <script>
        const photoInput = document.getElementById('photo');
        const previewContainer = document.getElementById('preview-container');
        const photoPreview = document.getElementById('photo-preview');
        const photoError = document.getElementById('photo-error');
        const removePhotoButton = document.getElementById('remove-photo');
        const bioInput = document.getElementById('bio');
        const bioCounter = document.getElementById('bio-counter');

        let previewUrl = null;

        function clearPhotoPreview() {
            if (previewUrl) {
                URL.revokeObjectURL(previewUrl);
                previewUrl = null;
            }

            photoPreview.removeAttribute('src');
            previewContainer.classList.add('hidden');
            removePhotoButton.classList.add('hidden');
        }

        photoInput.addEventListener('change', function () {
            photoError.textContent = '';
            photoError.classList.add('hidden');

            const file = this.files[0];

            if (!file) {
                clearPhotoPreview();
                return;
            }

            const allowedTypes = [
                'image/jpeg',
                'image/png',
                'image/webp'
            ];

            if (!allowedTypes.includes(file.type)) {
                photoError.textContent = 'Format foto harus JPG, PNG, atau WEBP.';
                photoError.classList.remove('hidden');
                this.value = '';
                clearPhotoPreview();
                return;
            }

            if (file.size > 2 * 1024 * 1024) {
                photoError.textContent = 'Ukuran foto tidak boleh lebih dari 2 MB.';
                photoError.classList.remove('hidden');
                this.value = '';
                clearPhotoPreview();
                return;
            }

            clearPhotoPreview();

            previewUrl = URL.createObjectURL(file);
            photoPreview.src = previewUrl;
            previewContainer.classList.remove('hidden');
            removePhotoButton.classList.remove('hidden');
        });

        removePhotoButton.addEventListener('click', function () {
            photoInput.value = '';
            photoError.textContent = '';
            photoError.classList.add('hidden');
            clearPhotoPreview();
        });

        function updateBioCounter() {
            bioCounter.textContent = `${bioInput.value.length}/1000 karakter`;
        }

        bioInput.addEventListener('input', updateBioCounter);
        updateBioCounter();
    </script>
</body>
</html>
