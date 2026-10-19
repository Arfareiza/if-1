<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ClassEvent;
use App\Models\Semester;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ClassEventController extends Controller
{
    private function getValidationRules(): array
    {
        return [
            'semester_id' => [
                'required',
                'integer',
                'exists:semesters,id',
            ],
            'title' => [
                'required',
                'string',
                'max:255',
            ],
            'description' => [
                'nullable',
                'string',
                'max:5000',
            ],
            'event_date' => [
                'required',
                'date',
            ],
            'start_time' => [
                'nullable',
                'date_format:H:i',
            ],
            'end_time' => [
                'nullable',
                'date_format:H:i',
                'required_with:start_time',
                'after:start_time',
            ],
            'event_type' => [
                'required',
                Rule::in([
                    'assignment',
                    'exam',
                    'presentation',
                    'holiday',
                    'other',
                ]),
            ],
            'location' => [
                'nullable',
                'string',
                'max:255',
            ],
            'is_published' => [
                'nullable',
                'boolean',
            ],
        ];
    }

    public function index(Request $request)
    {
        $query = ClassEvent::with('semester')
            ->orderBy('event_date')
            ->orderBy('start_time');

        // Filter berdasarkan semester.
        if ($request->filled('semester_id')) {
            $query->where(
                'semester_id',
                $request->input('semester_id')
            );
        }

        // Filter berdasarkan jenis agenda.
        if ($request->filled('event_type')) {
            $request->validate([
                'event_type' => [
                    Rule::in([
                        'assignment',
                        'exam',
                        'presentation',
                        'holiday',
                        'other',
                    ]),
                ],
            ]);

            $query->where(
                'event_type',
                $request->input('event_type')
            );
        }

        // Filter berdasarkan status publikasi.
        if ($request->filled('publication')) {
            $request->validate([
                'publication' => [
                    Rule::in(['published', 'draft']),
                ],
            ]);

            $query->where(
                'is_published',
                $request->input('publication') === 'published'
            );
        }

        $events = $query
            ->paginate(15)
            ->withQueryString();

        $semesters = Semester::orderByDesc('start_date')->get();

        return view(
            'admin.class-events.index',
            compact('events', 'semesters')
        );
    }

    public function create()
    {
        $semesters = Semester::orderByDesc('start_date')->get();

        return view(
            'admin.class-events.create',
            compact('semesters')
        );
    }

    public function store(Request $request)
    {
        $validated = $request->validate(
            $this->getValidationRules()
        );

        $validated['is_published'] =
            $request->boolean('is_published');

        ClassEvent::create($validated);

        return redirect()
            ->route('admin.class-events.index')
            ->with('success', 'Agenda kelas berhasil ditambahkan.');
    }

    public function show(ClassEvent $class_event)
    {
        return redirect()->route(
            'admin.class-events.edit',
            $class_event
        );
    }

    public function edit(ClassEvent $class_event)
    {
        $semesters = Semester::orderByDesc('start_date')->get();

        return view('admin.class-events.edit', [
            'event' => $class_event,
            'semesters' => $semesters,
        ]);
    }

    public function update(
        Request $request,
        ClassEvent $class_event
    ) {
        $validated = $request->validate(
            $this->getValidationRules()
        );

        $validated['is_published'] =
            $request->boolean('is_published');

        $class_event->update($validated);

        return redirect()
            ->route('admin.class-events.index')
            ->with('success', 'Agenda kelas berhasil diperbarui.');
    }

    public function destroy(ClassEvent $class_event)
    {
        $class_event->delete();

        return redirect()
            ->route('admin.class-events.index')
            ->with('success', 'Agenda kelas berhasil dihapus.');
    }
}
