
@extends('layouts.app')

@section('content')
<div class="container mx-auto max-w-2xl px-4 py-8">
    <h1 class="mb-6 text-2xl font-bold text-gray-800">Edit Jadwal Kuliah</h1>

    @if ($errors->any())
        <div class="mb-4 rounded-lg bg-red-100 p-4 text-red-700">
            <ul class="list-inside list-disc">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.class-schedules.update', $schedule) }}" method="POST"
          class="space-y-5 rounded-xl border bg-white p-6 shadow-sm">
        @csrf
        @method('PUT')

        <div>
            <label class="mb-1 block font-medium">Semester</label>
            <select name="semester_id" required class="w-full rounded-lg border-gray-300">
                @foreach ($semesters as $semester)
                    <option value="{{ $semester->id }}"
                        @selected(old('semester_id', $schedule->semester_id) == $semester->id)>
                        {{ $semester->name }} - {{ $semester->academic_year }}
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="mb-1 block font-medium">Nama Mata Kuliah</label>
            <input name="subject" value="{{ old('subject', $schedule->subject) }}" required
                   maxlength="255" class="w-full rounded-lg border-gray-300">
        </div>

        <div>
            <label class="mb-1 block font-medium">Nama Dosen</label>
            <input name="lecturer" value="{{ old('lecturer', $schedule->lecturer) }}"
                   maxlength="255" class="w-full rounded-lg border-gray-300">
        </div>

        <div>
            <label class="mb-1 block font-medium">Hari</label>
            <select name="day" required class="w-full rounded-lg border-gray-300">
                @foreach (['Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu'] as $day)
                    <option value="{{ $day }}" @selected(old('day', $schedule->day) === $day)>
                        {{ $day }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="grid gap-4 sm:grid-cols-2">
            <div>
                <label class="mb-1 block font-medium">Jam Mulai</label>
                <input type="time" name="start_time"
                       value="{{ old('start_time', substr($schedule->start_time, 0, 5)) }}"
                       required class="w-full rounded-lg border-gray-300">
            </div>
            <div>
                <label class="mb-1 block font-medium">Jam Selesai</label>
                <input type="time" name="end_time"
                       value="{{ old('end_time', substr($schedule->end_time, 0, 5)) }}"
                       required class="w-full rounded-lg border-gray-300">
            </div>
        </div>

        <div>
            <label class="mb-1 block font-medium">Ruangan</label>
            <input name="room" value="{{ old('room', $schedule->room) }}"
                   maxlength="255" class="w-full rounded-lg border-gray-300">
        </div>

        <div>
            <label class="mb-1 block font-medium">Metode Perkuliahan</label>
            <select name="meeting_type" required class="w-full rounded-lg border-gray-300">
                <option value="offline" @selected(old('meeting_type', $schedule->meeting_type) === 'offline')>Offline</option>
                <option value="online" @selected(old('meeting_type', $schedule->meeting_type) === 'online')>Online</option>
            </select>
        </div>

        <div>
            <label class="mb-1 block font-medium">Catatan</label>
            <textarea name="notes" rows="3" class="w-full rounded-lg border-gray-300">{{ old('notes', $schedule->notes) }}</textarea>
        </div>

        <label class="flex items-center gap-2">
            <input type="checkbox" name="is_active" value="1"
                   @checked(old('is_active', $schedule->is_active))>
            Jadwal aktif
        </label>

        <div class="flex gap-3">
            <button type="submit" class="rounded-lg bg-blue-600 px-5 py-2 text-white hover:bg-blue-700">
                Simpan Perubahan
            </button>
            <a href="{{ route('admin.class-schedules.index') }}" class="rounded-lg border px-5 py-2">
                Kembali
            </a>
        </div>
    </form>
</div>
@endsection
