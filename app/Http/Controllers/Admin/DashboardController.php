<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ClassEvent;
use App\Models\ClassSchedule;
use App\Models\Confession;
use App\Models\Semester;
use App\Models\Student;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $activeSemester = Semester::where('is_active', true)->first();

        return view('admin.dashboard', [
            // Statistik mahasiswa dan admin
            'totalStudents' => Student::count(),
            'totalAdmins' => User::where('role', 'admin')->count(),

            // Statistik Menfess
            'totalConfessions' => Confession::count(),
            'pendingConfessions' => Confession::where(
                'status',
                'pending'
            )->count(),

            // Statistik semester
            'totalSemesters' => Semester::count(),
            'activeSemester' => $activeSemester,

            // Statistik jadwal kuliah
            'totalSchedules' => ClassSchedule::count(),
            'activeSchedules' => ClassSchedule::where(
                'is_active',
                true
            )->count(),

            // Statistik kalender akademik
            'totalEvents' => ClassEvent::count(),
            'publishedEvents' => ClassEvent::where(
                'is_published',
                true
            )->count(),
        ]);
    }
}
