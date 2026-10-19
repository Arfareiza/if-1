 @extends('layouts.app')

@section('content')
<div class="container mx-auto max-w-3xl px-4 py-8">
    <div class="mb-6">
        <a href="{{ route('admin.class-events.index') }}"
           class="text-sm font-medium text-indigo-600 hover:underline">
            ← Kembali ke Agenda Akademik
        </a>
        <h1 class="mt-3 text-2xl font-bold text-gray-800">Edit Agenda Akademik</h1>
        <p class="mt-1 text-sm text-gray-500">Perbarui informasi agenda yang dipilih.</p>
    </div>

    @if ($errors->any())
        <div class="mb-5 rounded-lg bg-red-50 p-4 text-sm text-red-700">
            <ul class="list-inside list-disc">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.class-events.update', $event) }}" method="POST"
          class="space-y-5 rounded-xl border border-gray-200 bg-white p-6 shadow-sm">
        @csrf
        @method('PUT')

        <div>
            <label for="title" class="mb-1 block text-sm font-medium text-gray-700">
                Nama agenda <span class="text-red-500">*</span>
            </label>
            <input id="title" name="title" type="text" required maxlength="255"
                   value="{{ old('title', $event->title) }}"
                   class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
        </div>

        <div>
            <label for="semester_id" class="mb-1 block text-sm font-medium text-gray-700">
                Semester <span class="text-red-500">*</span>
            </label>
            <select id="semester_id" name="semester_id" required
                    class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
                @foreach ($semesters as $semester)
                    <option value="{{ $semester->id }}"
                        @selected(old('semester_id', $event->semester_id) == $semester->id)>
                        {{ $semester->name }} - {{ $semester->academic_year }}
                        {{ $semester->is_active ? '(Aktif)' : '' }}
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <label for="event_type" class="mb-1 block text-sm font-medium text-gray-700">
                Jenis agenda <span class="text-red-500">*</span>
            </label>
            <select id="event_type" name="event_type" required
                    class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
                <option value="assignment" @selected(old('event_type', $event->event_type) === 'assignment')>Tugas</option>
                <option value="exam" @selected(old('event_type', $event->event_type) === 'exam')>Ujian</option>
                <option value="presentation" @selected(old('event_type', $event->event_type) === 'presentation')>Presentasi</option>
                <option value="holiday" @selected(old('event_type', $event->event_type) === 'holiday')>Hari libur</option>
                <option value="other" @selected(old('event_type', $event->event_type) === 'other')>Lainnya</option>
            </select>
        </div>

        <div>
            <label for="event_date" class="mb-1 block text-sm font-medium text-gray-700">
                Tanggal agenda <span class="text-red-500">*</span>
            </label>
            <input id="event_date" name="event_date" type="date" required
                   value="{{ old('event_date', $event->event_date->format('Y-m-d')) }}"
                   class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
        </div>

        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
            <div>
                <label for="start_time" class="mb-1 block text-sm font-medium text-gray-700">
                    Waktu mulai
                </label>
                <input id="start_time" name="start_time" type="time"
                       value="{{ old('start_time', $event->start_time ? substr($event->start_time, 0, 5) : '') }}"
                       class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
            </div>

            <div>
                <label for="end_time" class="mb-1 block text-sm font-medium text-gray-700">
                    Waktu selesai
                </label>
                <input id="end_time" name="end_time" type="time"
                       value="{{ old('end_time', $event->end_time ? substr($event->end_time, 0, 5) : '') }}"
                       class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
            </div>
        </div>

        <div>
            <label for="location" class="mb-1 block text-sm font-medium text-gray-700">
                Lokasi
            </label>
            <input id="location" name="location" type="text" maxlength="255"
                   value="{{ old('location', $event->location) }}"
                   class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
        </div>

        <div>
            <label for="description" class="mb-1 block text-sm font-medium text-gray-700">
                Deskripsi
            </label>
            <textarea id="description" name="description" rows="4" maxlength="5000"
                      class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">{{ old('description', $event->description) }}</textarea>
        </div>

        <div class="rounded-lg bg-gray-50 p-4">
            <label class="flex cursor-pointer items-start gap-3">
                <input type="checkbox" name="is_published" value="1"
                       @checked(old('is_published', $event->is_published))
                       class="mt-1 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                <span>
                    <span class="block text-sm font-semibold text-gray-800">
                        Publikasikan agenda
                    </span>
                    <span class="mt-1 block text-xs text-gray-500">
                        Centang agar agenda berstatus dipublikasikan. Hilangkan centang untuk menjadikannya draft.
                    </span>
                </span>
            </label>
        </div>

        <div class="flex flex-wrap justify-end gap-3 border-t border-gray-100 pt-5">
            <a href="{{ route('admin.class-events.index') }}"
               class="rounded-lg border border-gray-300 px-5 py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-50">
                Batal
            </a>
            <button type="submit"
                    class="rounded-lg bg-indigo-600 px-5 py-2.5 text-sm font-semibold text-white hover:bg-indigo-700">
                Simpan Perubahan
            </button>
        </div>
    </form>
</div>
@endsection