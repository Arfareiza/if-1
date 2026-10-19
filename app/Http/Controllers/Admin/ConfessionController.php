<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Confession;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ConfessionController extends Controller
{
    public function index(Request $request): View
    {
        $query = Confession::query()->latest();

        if (in_array($request->query('status'), [
            'pending',
            'approved',
            'rejected',
        ], true)) {
            $query->where('status', $request->query('status'));
        }

        $confessions = $query->paginate(15)->withQueryString();

        $statusCounts = Confession::query()
            ->selectRaw('status, COUNT(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status');

        return view('admin.confessions.index', [
            'confessions' => $confessions,
            'totalPending' => (int) ($statusCounts['pending'] ?? 0),
            'totalApproved' => (int) ($statusCounts['approved'] ?? 0),
            'totalRejected' => (int) ($statusCounts['rejected'] ?? 0),
        ]);
    }

    public function approve(Confession $confession): RedirectResponse
    {
        $confession->update([
            'status' => 'approved',
        ]);

        return back()->with('success', 'Menfess berhasil disetujui.');
    }

    public function reject(Confession $confession): RedirectResponse
    {
        $confession->update([
            'status' => 'rejected',
        ]);

        return back()->with('success', 'Menfess berhasil ditolak.');
    }

    public function destroy(Confession $confession): RedirectResponse
    {
        $confession->delete();

        return back()->with('success', 'Menfess berhasil dihapus.');
    }
}
