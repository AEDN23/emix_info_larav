<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('stds', function (Blueprint $table) {
            $table->id();
            $table->string('nama_std');
            $table->foreignId('departemen_id')->constrained('departemens')->onDelete('cascade');
            $table->string('keterangan');
            $table->string('approve');
            $table->string('tahun');
            $table->string('file');
            $table->string('active');
            $table->string('video');
            $table->foreignId('created_by')->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stds');
    }
};
