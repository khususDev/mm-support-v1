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
        Schema::create('permissions', function (Blueprint $table) {
            $table->id(); // Otomatis membuat id sebagai primary key
            $table->string('resource_type');  // Jenis data yang di-approve (misalnya: document, project, dll.)
            $table->integer('resource_id');   // ID data yang membutuhkan persetujuan
            $table->integer('requested_by');  // ID pengguna yang mengajukan permintaan
            $table->integer('approved_by')->nullable(); // ID pengguna yang memberikan persetujuan
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending'); // Status persetujuan
            $table->text('comments')->nullable(); // Komentar opsional terkait persetujuan
            $table->timestamps(); // created_at dan updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('permissions');
    }
};
