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
        Schema::create('photos', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable(); // cukup satu kali
            $table->text('description')->nullable();
            $table->string('image_path'); // path file untuk ditampilkan
            $table->string('file_path');   // simpan nama file (boleh pakai satu dari dua ini)
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade');
            $table->boolean('status')->default(true); // aktif/nonaktif oleh admin

            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('photos');
    }
};