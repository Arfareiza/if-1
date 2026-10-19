<?php

use Illuminate\Support\Facades\Route;
use App\Models\Student;
use App\Models\Announcement;
use App\Models\ClassEvent;

use App\Http\Controllers\ConfessionController as PublicConfessionController;

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\StudentController;
use App\Http\Controllers\Admin\AnnouncementController;
use App\Http\Controllers\Admin\ConfessionController as AdminConfessionController;
use App\Http\Controllers\Admin\SemesterController;
use App\Http\Controllers\Admin\ClassScheduleController;
use App\Http\Controllers\Admin\ClassEventController;


// ========================================
// HALAMAN UTAMA / LANDING PAGE
// ========================================
Route::get('/', function () {
    return view('welcome');
})->name('home');


// ========================================
// DATA MAHASISWA UNTUK WEBSITE PUBLIK
// ========================================
Route::get('/students-data', function () {
    return Student::query()
        ->select(
            'id',
            'nim',
            'name',
            'class_name',
            'photo',
            'instagram',
            'bio'
        )
        ->orderBy('name')
        ->get();
})->name('students.data');


// ========================================
// DETAIL DATA MAHASISWA FORMAT JSON
// ========================================
Route::get('/students-data/{student}', function (Student $student) {
    return $student->only([
        'id',
        'nim',
        'name',
        'class_name',
        'email',
        'phone',
        'photo',
        'instagram',
        'bio',
    ]);
})->name('students.data.show');


// ========================================
// DATA PENGUMUMAN LAMA
// DIPERTAHANKAN
// ========================================
Route::get('/announcements-data', function () {
    return Announcement::query()
        ->where('is_published', true)
        ->whereNotNull('published_at')
        ->where('published_at', '<=', now())
        ->latest('published_at')
        ->get([
            'id',
            'title',
            'content',
            'published_at',
        ]);
})->name('announcements.data');


// ========================================
// DATA JADWAL KULIAH SEMESTER AKTIF
// ========================================
Route::get('/class-schedules-data', function () {
    $semester = \App\Models\Semester::query()
        ->where('is_active', true)
        ->with([
            'classSchedules' => function ($query) {
                $query->where('is_active', true)
                    ->orderBy('start_time');
            },
        ])
        ->first();

    if (! $semester) {
        return response()->json([
            'semester' => null,
            'schedules' => [],
        ]);
    }

    return response()->json([
        'semester' => $semester,
        'schedules' => $semester->classSchedules,
    ]);
})->name('class-schedules.data');


// ========================================
// DATA AGENDA AKADEMIK UNTUK KALENDER PUBLIK
// HANYA AGENDA TERBIT DARI SEMESTER AKTIF
// ========================================
Route::get('/class-events-data', function () {
    $activeSemester = \App\Models\Semester::query()
        ->where('is_active', true)
        ->first();

    if (! $activeSemester) {
        return response()->json([]);
    }

    $events = ClassEvent::query()
        ->where('semester_id', $activeSemester->id)
        ->where('is_published', true)
        ->orderBy('event_date')
        ->orderBy('start_time')
        ->get([
            'id',
            'semester_id',
            'title',
            'description',
            'event_date',
            'start_time',
            'end_time',
            'event_type',
            'location',
            'is_published',
        ]);

    return response()->json($events);
})->name('class-events.data');


// ========================================
// API MENFESS UNTUK WEBSITE PUBLIK
// ========================================

// Menampilkan menfess yang sudah disetujui
Route::get('/confessions-data', [
    PublicConfessionController::class,
    'index',
])->name('confessions.data');

// Mengirim menfess secara anonim
Route::post('/confessions-data', [
    PublicConfessionController::class,
    'store',
])->middleware('throttle:5,1')->name('confessions.store');


// ========================================
// HALAMAN PROFIL DETAIL MAHASISWA
// ========================================
Route::get('/mahasiswa/{student}', function (Student $student) {
    return view('student-detail', compact('student'));
})->name('students.detail');


// ========================================
// LOGIN ADMIN
// ========================================
Route::get('/admin/login', [
    AuthController::class,
    'showLogin',
])->middleware('guest')->name('admin.login');

Route::post('/admin/login', [
    AuthController::class,
    'login',
])->middleware('guest')->name('admin.login.submit');


// ========================================
// LOGOUT ADMIN
// ========================================
Route::post('/admin/logout', [
    AuthController::class,
    'logout',
])->middleware('auth')->name('admin.logout');


// ========================================
// DASHBOARD ADMIN
// ========================================
Route::get('/admin/dashboard', [
    DashboardController::class,
    'index',
])->middleware(['auth', 'admin'])->name('admin.dashboard');


// ========================================
// CRUD KHUSUS ADMIN
// ========================================
Route::middleware(['auth', 'admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        // Data mahasiswa
        Route::resource('students', StudentController::class);

        // Pengumuman lama
        Route::resource('announcements', AnnouncementController::class);

        // Pengaturan semester
        Route::resource('semesters', SemesterController::class);

        // Jadwal kuliah mingguan
        Route::resource('class-schedules', ClassScheduleController::class);

        // Agenda akademik: tugas, UTS, UAS, presentasi, libur, dan lainnya
        Route::resource('class-events', ClassEventController::class);

        // Daftar menfess untuk moderasi
        Route::get('/confessions', [
            AdminConfessionController::class,
            'index',
        ])->name('confessions.index');

        // Menyetujui menfess
        Route::patch('/confessions/{confession}/approve', [
            AdminConfessionController::class,
            'approve',
        ])->name('confessions.approve');

        // Menolak menfess
        Route::patch('/confessions/{confession}/reject', [
            AdminConfessionController::class,
            'reject',
        ])->name('confessions.reject');

        // Menghapus menfess
        Route::delete('/confessions/{confession}', [
            AdminConfessionController::class,
            'destroy',
        ])->name('confessions.destroy');
    });

