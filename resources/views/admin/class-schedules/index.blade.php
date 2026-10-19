
    @extends('layouts.app')

    @section('content')
    <div class="container mx-auto px-4 py-8">
        <div class="mb-6 flex flex-wrap items-center justify-between gap-3">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Jadwal Mata Kuliah</h1>
                <p class="mt-1 text-sm text-gray-500">Kelola jadwal kuliah mingguan IF 1.</p>
            </div>
            <a href="{{ route('admin.class-schedules.create') }}"
            class="rounded-lg bg-blue-600 px-4 py-2 text-white hover:bg-blue-700">
                + Tambah Jadwal
            </a>
        </div>

        @if (session('success'))
            <div class="mb-4 rounded-lg bg-green-100 p-3 text-green-800">
                {{ session('success') }}
            </div>
        @endif

        <div class="overflow-x-auto rounded-xl border bg-white shadow-sm">
            <table class="w-full text-left text-sm">
                <thead class="bg-gray-100 text-gray-700">
                    <tr>
                        <th class="p-4">Mata Kuliah</th>
                        <th class="p-4">Dosen</th>
                        <th class="p-4">Hari</th>
                        <th class="p-4">Waktu</th>
                        <th class="p-4">Ruangan</th>
                        <th class="p-4">Semester</th>
                        <th class="p-4">Status</th>
                        <th class="p-4">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($schedules as $schedule)
                        <tr class="border-t">
                            <td class="p-4 font-medium">{{ $schedule->subject }}</td>
                            <td class="p-4">{{ $schedule->lecturer ?: '-' }}</td>
                            <td class="p-4">{{ $schedule->day }}</td>
                            <td class="p-4">
                                {{ substr($schedule->start_time, 0, 5) }}
                                -
                                {{ substr($schedule->end_time, 0, 5) }}
                            </td>
                            <td class="p-4">{{ $schedule->room ?: '-' }}</td>
                            <td class="p-4">
                                {{ $schedule->semester?->name }}
                                {{ $schedule->semester?->academic_year }}
                            </td>
                            <td class="p-4">
                                {{ $schedule->is_active ? 'Aktif' : 'Nonaktif' }}
                            </td>
                            <td class="p-4">
                                <div class="flex gap-3">
                                    <a href="{{ route('admin.class-schedules.edit', $schedule) }}"
                                    class="text-blue-600 hover:underline">Edit</a>

                                    <form action="{{ route('admin.class-schedules.destroy', $schedule) }}"
                                        method="POST"
                                        onsubmit="return confirm('Yakin ingin menghapus jadwal ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="text-red-600 hover:underline" type="submit">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="p-8 text-center text-gray-500">
                                Belum ada jadwal mata kuliah.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">{{ $schedules->links() }}</div>
    </div>
    @endsection
