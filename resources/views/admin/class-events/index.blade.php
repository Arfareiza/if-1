 @extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="mb-6 flex flex-col justify-between gap-4 sm:flex-row sm:items-center">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Agenda Akademik</h1>
            <p class="mt-1 text-sm text-gray-500">
                Kelola tugas, ujian, presentasi, hari libur, dan kegiatan kelas IF 1.
            </p>
        </div>

        <a href="{{ route('admin.class-events.create') }}"
           class="inline-flex items-center justify-center rounded-lg bg-indigo-600 px-4 py-2.5 text-sm font-semibold text-white hover:bg-indigo-700">
            + Tambah Agenda
        </a>
    </div>

    @if (session('success'))
        <div class="mb-5 rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-green-800">
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="mb-5 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-red-700">
            <p class="font-semibold">Terjadi kesalahan:</p>
            <ul class="mt-2 list-inside list-disc">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="mb-6 rounded-xl border border-gray-200 bg-white p-4 shadow-sm">
        <form method="GET" action="{{ route('admin.class-events.index') }}"
              class="grid grid-cols-1 gap-4 md:grid-cols-4">
            <div>
                <label for="semester_id" class="mb-1 block text-sm font-medium text-gray-700">
                    Semester
                </label>
                <select id="semester_id" name="semester_id"
                        class="w-full rounded-lg border-gray-300 text-sm focus:border-indigo-500 focus:ring-indigo-500">
                    <option value="">Semua semester</option>
                    @foreach ($semesters as $semester)
                        <option value="{{ $semester->id }}"
                            @selected(request('semester_id') == $semester->id)>
                            {{ $semester->name }} - {{ $semester->academic_year }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="event_type" class="mb-1 block text-sm font-medium text-gray-700">
                    Jenis agenda
                </label>
                <select id="event_type" name="event_type"
                        class="w-full rounded-lg border-gray-300 text-sm focus:border-indigo-500 focus:ring-indigo-500">
                    <option value="">Semua jenis</option>
                    <option value="assignment" @selected(request('event_type') === 'assignment')>Tugas</option>
                    <option value="exam" @selected(request('event_type') === 'exam')>Ujian</option>
                    <option value="presentation" @selected(request('event_type') === 'presentation')>Presentasi</option>
                    <option value="holiday" @selected(request('event_type') === 'holiday')>Hari libur</option>
                    <option value="other" @selected(request('event_type') === 'other')>Lainnya</option>
                </select>
            </div>

            <div>
                <label for="publication" class="mb-1 block text-sm font-medium text-gray-700">
                    Status publikasi
                </label>
                <select id="publication" name="publication"
                        class="w-full rounded-lg border-gray-300 text-sm focus:border-indigo-500 focus:ring-indigo-500">
                    <option value="">Semua status</option>
                    <option value="published" @selected(request('publication') === 'published')>Dipublikasikan</option>
                    <option value="draft" @selected(request('publication') === 'draft')>Draft</option>
                </select>
            </div>

            <div class="flex items-end gap-2">
                <button type="submit"
                        class="rounded-lg bg-gray-800 px-4 py-2 text-sm font-medium text-white hover:bg-gray-700">
                    Filter
                </button>
                <a href="{{ route('admin.class-events.index') }}"
                   class="rounded-lg border border-gray-300 px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50">
                    Reset
                </a>
            </div>
        </form>
    </div>

    <div class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-gray-600">
                <thead class="bg-gray-50 text-xs uppercase text-gray-700">
                    <tr>
                        <th class="px-5 py-4">Agenda</th>
                        <th class="px-5 py-4">Tanggal</th>
                        <th class="px-5 py-4">Jenis</th>
                        <th class="px-5 py-4">Semester</th>
                        <th class="px-5 py-4">Status</th>
                        <th class="px-5 py-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse ($events as $event)
                        <tr class="hover:bg-gray-50">
                            <td class="px-5 py-4">
                                <p class="font-semibold text-gray-900">{{ $event->title }}</p>
                                @if ($event->description)
                                    <p class="mt-1 max-w-xs truncate text-xs text-gray-500">
                                        {{ $event->description }}
                                    </p>
                                @endif
                                @if ($event->start_time)
                                    <p class="mt-1 text-xs text-gray-500">
                                        {{ substr($event->start_time, 0, 5) }}
                                        @if ($event->end_time)
                                            – {{ substr($event->end_time, 0, 5) }}
                                        @endif
                                    </p>
                                @endif
                            </td>

                            <td class="whitespace-nowrap px-5 py-4">
                                {{ $event->event_date->format('d M Y') }}
                            </td>

                            <td class="whitespace-nowrap px-5 py-4">
                                @switch($event->event_type)
                                    @case('assignment') Tugas @break
                                    @case('exam') Ujian @break
                                    @case('presentation') Presentasi @break
                                    @case('holiday') Hari libur @break
                                    @default Lainnya
                                @endswitch
                            </td>

                            <td class="whitespace-nowrap px-5 py-4">
                                {{ $event->semester?->name ?? '-' }}
                                {{ $event->semester?->academic_year ?? '' }}
                            </td>

                            <td class="px-5 py-4">
                                @if ($event->is_published)
                                    <span class="rounded-full bg-green-100 px-3 py-1 text-xs font-medium text-green-700">
                                        Dipublikasikan
                                    </span>
                                @else
                                    <span class="rounded-full bg-yellow-100 px-3 py-1 text-xs font-medium text-yellow-700">
                                        Draft
                                    </span>
                                @endif
                            </td>

                            <td class="px-5 py-4">
                                <div class="flex items-center justify-center gap-3">
                                    <a href="{{ route('admin.class-events.edit', $event) }}"
                                       class="font-medium text-indigo-600 hover:underline">
                                        Edit
                                    </a>

                                    <form action="{{ route('admin.class-events.destroy', $event) }}"
                                          method="POST"
                                          onsubmit="return confirm('Yakin ingin menghapus agenda ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="font-medium text-red-600 hover:underline">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-5 py-12 text-center">
                                <p class="font-medium text-gray-700">Belum ada agenda akademik.</p>
                                <p class="mt-1 text-sm text-gray-500">
                                    Tambahkan agenda pertama menggunakan tombol di atas.
                                </p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($events->hasPages())
            <div class="border-t border-gray-200 px-5 py-4">
                {{ $events->links() }}
            </div>
        @endif
    </div>
</div>
@endsection