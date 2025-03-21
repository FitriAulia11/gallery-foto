<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('photos', function (Blueprint $table) {
            $table->id();
            $table->string('title')->default('Untitled'); // Menambahkan default value
            $table->text('description')->nullable();
            $table->string('image_path'); // Sesuai dengan model
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->boolean('status')->default(true); // Untuk On/Off Foto oleh admin
            $table->string('file_name'); // Menyimpan nama file gambar
            $table->string('title')->nullable(); // Opsional, untuk judul foto
            $table->unsignedBigInteger('user_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('photos', function (Blueprint $table) {
            $table->dropColumn('image_path');
        });
        }
};
