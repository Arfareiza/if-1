<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use Illuminate\Http\Request;

class AnnouncementController extends Controller
{
    /**
     * Menampilkan semua pengumuman di panel admin.
     */
    public function index()
    {
        $announcements = Announcement::latest()->paginate(10);

        return view('admin.announcements.index', compact('announcements'));
    }

    /**
     * Menampilkan formulir tambah pengumuman.
     */
    public function create()
    {
        return view('admin.announcements.create');
    }

    /**
     * Menyimpan pengumuman baru.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'content' => ['required', 'string'],
            'is_published' => ['required', 'boolean'],
            'published_at' => ['nullable', 'date'],
        ]);

        if ($validated['is_published'] && empty($validated['published_at'])) {
            $validated['published_at'] = now();
        }

        if (!$validated['is_published']) {
            $validated['published_at'] = null;
        }

        Announcement::create($validated);

        return redirect()
            ->route('admin.announcements.index')
            ->with('success', 'Pengumuman berhasil ditambahkan.');
    }

    /**
     * Menampilkan detail pengumuman.
     */
    public function show(Announcement $announcement)
    {
        return view('admin.announcements.show', compact('announcement'));
    }

    /**
     * Menampilkan formulir edit pengumuman.
     */
    public function edit(Announcement $announcement)
    {
        return view('admin.announcements.edit', compact('announcement'));
    }

    /**
     * Memperbarui pengumuman.
     */
    public function update(Request $request, Announcement $announcement)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'content' => ['required', 'string'],
            'is_published' => ['required', 'boolean'],
            'published_at' => ['nullable', 'date'],
        ]);

        if ($validated['is_published'] && empty($validated['published_at'])) {
            $validated['published_at'] = $announcement->published_at ?? now();
        }

        if (!$validated['is_published']) {
            $validated['published_at'] = null;
        }

        $announcement->update($validated);

        return redirect()
            ->route('admin.announcements.index')
            ->with('success', 'Pengumuman berhasil diperbarui.');
    }

    /**
     * Menghapus pengumuman.
     */
    public function destroy(Announcement $announcement)
    {
        $announcement->delete();

        return redirect()
            ->route('admin.announcements.index')
            ->with('success', 'Pengumuman berhasil dihapus.');
    }
}
