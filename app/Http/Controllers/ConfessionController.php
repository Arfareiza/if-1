<?php

namespace App\Http\Controllers;

use App\Models\Confession;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ConfessionController extends Controller
{
    public function index(): JsonResponse
    {
        $confessions = Confession::query()
            ->where('status', 'approved')
            ->latest()
            ->limit(50)
            ->get([
                'id',
                'recipient',
                'message',
                'created_at',
            ]);

        return response()->json($confessions);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'recipient' => ['nullable', 'string', 'max:100'],
            'message' => ['required', 'string', 'min:5', 'max:1000'],
        ]);

        $recipient = trim($validated['recipient'] ?? '');
        $message = trim($validated['message']);

        if (mb_strlen($message) < 5) {
            return response()->json([
                'message' => 'Pesan minimal 5 karakter setelah spasi dihapus.',
            ], 422);
        }

        $confession = Confession::create([
            'recipient' => $recipient !== '' ? $recipient : null,
            'message' => $message,
            'status' => 'pending',
        ]);

        return response()->json([
            'message' => 'Menfess berhasil dikirim dan menunggu persetujuan admin.',
            'id' => $confession->id,
        ], 201);
    }
}
