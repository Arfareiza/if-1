
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('announcements', function (Blueprint $table) {
            $table->id();

            // Judul pengumuman
            $table->string('title', 255);

            // Isi lengkap pengumuman
            $table->longText('content');

            // Tanggal dan waktu publikasi
            $table->timestamp('published_at')->nullable();

            // Status publikasi: false = draft, true = dipublikasikan
            $table->boolean('is_published')->default(false);

            // Waktu data dibuat dan diperbarui
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('announcements');
    }
};
