
@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="mb-6 flex flex-wrap items-center justify-between gap-3">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">
                Manajemen Semester
            </h1>
            <p class="mt-1 text-sm text-gray-500">
                Kelola semester akademik untuk jadwal kelas IF 1.
            </p>
        </div>

        <a href="{{ route('admin.semesters.create') }}"
           class="rounded-lg bg-blue-600 px-4 py-2 text-white hover:bg-blue-700">
            + Tambah Semester
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
                    <th class="p-4">Semester</th>
                    <th class="p-4">Tahun Akademik</th>
                    <th class="p-4">Mulai</th>
                    <th class="p-4">Selesai</th>
                    <th class="p-4">Status</th>
                    <th class="p-4">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($semesters as $semester)
                    <tr class="border-t">
                        <td class="p-4">{{ $semester->name }}</td>
                        <td class="p-4">{{ $semester->academic_year }}</td>
                        <td class="p-4">{{ $semester->start_date->format('d/m/Y') }}</td>
                        <td class="p-4">{{ $semester->end_date->format('d/m/Y') }}</td>
                        <td class="p-4">
                            @if ($semester->is_active)
                                <span class="rounded-full bg-green-100 px-3 py-1 text-green-700">
                                    Aktif
                                </span>
                            @else
                                <span class="rounded-full bg-gray-100 px-3 py-1 text-gray-600">
                                    Tidak aktif
                                </span>
                            @endif
                        </td>
                        <td class="p-4">
                            <div class="flex gap-3">
                                <a href="{{ route('admin.semesters.edit', $semester) }}"
                                   class="font-medium text-blue-600 hover:underline">
                                    Edit
                                </a>

                                <form action="{{ route('admin.semesters.destroy', $semester) }}"
                                      method="POST"
                                      onsubmit="return confirm('Yakin ingin menghapus semester ini beserta jadwal dan agendanya?')">
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
                        <td colspan="6" class="p-8 text-center text-gray-500">
                            Belum ada semester. Silakan tambahkan semester terlebih dahulu.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $semesters->links() }}
    </div>
</div>
@endsection
