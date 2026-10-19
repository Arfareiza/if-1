
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('class_schedules', function (Blueprint $table) {
            $table->id();

            $table->foreignId('semester_id')
                ->constrained('semesters')
                ->cascadeOnDelete();

            $table->string('subject'); // Nama mata kuliah
            $table->string('lecturer')->nullable(); // Nama dosen
            $table->string('day'); // Senin, Selasa, dst.
            $table->time('start_time');
            $table->time('end_time');
            $table->string('room')->nullable(); // Ruangan
            $table->string('meeting_type')->default('offline'); // offline/online
            $table->text('notes')->nullable();
            $table->boolean('is_active')->default(true);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('class_schedules');
    }
};
