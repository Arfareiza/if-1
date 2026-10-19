
@extends('layouts.app')

@section('content')
<div class="container mx-auto max-w-2xl px-4 py-8">
    <h1 class="mb-6 text-2xl font-bold text-gray-800">
        Edit Semester
    </h1>

    @if ($errors->any())
        <div class="mb-4 rounded-lg bg-red-100 p-4 text-red-700">
            <ul class="list-inside list-disc">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.semesters.update', $semester) }}"
          method="POST"
          class="space-y-5 rounded-xl border bg-white p-6 shadow-sm">
        @csrf
        @method('PUT')

        <div>
            <label class="mb-1 block font-medium">Semester</label>
            <select name="name" required class="w-full rounded-lg border-gray-300">
                <option value="Ganjil" @selected(old('name', $semester->name) === 'Ganjil')>Ganjil</option>
                <option value="Genap" @selected(old('name', $semester->name) === 'Genap')>Genap</option>
            </select>
        </div>

        <div>
            <label class="mb-1 block font-medium">Tahun Akademik</label>
            <input type="text" name="academic_year"
                   value="{{ old('academic_year', $semester->academic_year) }}"
                   required maxlength="20"
                   class="w-full rounded-lg border-gray-300">
        </div>

        <div>
            <label class="mb-1 block font-medium">Tanggal Mulai</label>
            <input type="date" name="start_date"
                   value="{{ old('start_date', $semester->start_date->format('Y-m-d')) }}"
                   required class="w-full rounded-lg border-gray-300">
        </div>

        <div>
            <label class="mb-1 block font-medium">Tanggal Selesai</label>
            <input type="date" name="end_date"
                   value="{{ old('end_date', $semester->end_date->format('Y-m-d')) }}"
                   required class="w-full rounded-lg border-gray-300">
        </div>

        <label class="flex items-center gap-2">
            <input type="checkbox" name="is_active" value="1"
                   @checked(old('is_active', $semester->is_active))>
            Jadikan semester aktif
        </label>

        <div class="flex gap-3">
            <button type="submit"
                    class="rounded-lg bg-blue-600 px-5 py-2 text-white hover:bg-blue-700">
                Simpan Perubahan
            </button>
            <a href="{{ route('admin.semesters.index') }}"
               class="rounded-lg border px-5 py-2 hover:bg-gray-50">
                Kembali
            </a>
        </div>
    </form>
</div>
@endsection
