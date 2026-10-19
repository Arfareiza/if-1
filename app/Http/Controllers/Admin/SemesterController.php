<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Semester;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class SemesterController extends Controller
{
    public function index()
    {
        $semesters = Semester::latest()->paginate(10);

        return view('admin.semesters.index', compact('semesters'));
    }

    public function create()
    {
        return view('admin.semesters.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', Rule::in(['Ganjil', 'Genap'])],
            'academic_year' => ['required', 'string', 'max:20'],
            'start_date' => ['required', 'date'],
            'end_date' => ['required', 'date', 'after_or_equal:start_date'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        DB::transaction(function () use ($validated) {
            $active = (bool) ($validated['is_active'] ?? false);

            if ($active) {
                Semester::query()->update(['is_active' => false]);
            }

            Semester::create([
                ...$validated,
                'is_active' => $active,
            ]);
        });

        return redirect()
            ->route('admin.semesters.index')
            ->with('success', 'Semester berhasil ditambahkan.');
    }

    public function show(Semester $semester)
    {
        return redirect()->route('admin.semesters.edit', $semester);
    }

    public function edit(Semester $semester)
    {
        return view('admin.semesters.edit', compact('semester'));
    }

    public function update(Request $request, Semester $semester)
    {
        $validated = $request->validate([
            'name' => ['required', Rule::in(['Ganjil', 'Genap'])],
            'academic_year' => ['required', 'string', 'max:20'],
            'start_date' => ['required', 'date'],
            'end_date' => ['required', 'date', 'after_or_equal:start_date'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        DB::transaction(function () use ($validated, $semester) {
            $active = (bool) ($validated['is_active'] ?? false);

            if ($active) {
                Semester::whereKeyNot($semester->id)
                    ->update(['is_active' => false]);
            }

            $semester->update([
                ...$validated,
                'is_active' => $active,
            ]);
        });

        return redirect()
            ->route('admin.semesters.index')
            ->with('success', 'Semester berhasil diperbarui.');
    }

    public function destroy(Semester $semester)
    {
        $semester->delete();

        return redirect()
            ->route('admin.semesters.index')
            ->with('success', 'Semester berhasil dihapus.');
    }
}
