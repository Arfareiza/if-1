
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('class_events', function (Blueprint $table) {
            $table->id();

            $table->foreignId('semester_id')
                ->constrained('semesters')
                ->cascadeOnDelete();

            $table->string('title'); // Nama agenda
            $table->text('description')->nullable();
            $table->date('event_date'); // Tanggal agenda
            $table->time('start_time')->nullable();
            $table->time('end_time')->nullable();

            $table->string('event_type')->default('other');
            // assignment, exam, presentation, holiday, other

            $table->string('location')->nullable();
            $table->boolean('is_published')->default(false);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('class_events');
    }
};
