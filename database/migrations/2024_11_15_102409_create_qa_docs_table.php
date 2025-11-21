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
        Schema::create('documents', function (Blueprint $table) {
            $table->id(); // Primary Key
            $table->unsignedBigInteger('category_document_id'); // Foreign Key ke jenis_documents
            $table->unsignedBigInteger('jenis_document_id'); // Foreign Key ke jenis_documents
            $table->unsignedBigInteger('department_id'); // Foreign Key ke divisions
            $table->unsignedBigInteger('user_id'); // Foreign Key ke users (Created By)
            $table->string('nodocument')->unique(); // Nomor Dokumen
            $table->string('namadocument'); // Nama Dokumen
            $table->text('deskripsi')->nullable(); // Deskripsi Dokumen
            $table->date('tanggal_berlaku'); // Tanggal Berlaku
            $table->enum('statusdocument', ['Draft', 'Active', 'Archived']); // Status Dokumen
            $table->integer('revisidocument')->default(0); // Revisi Dokumen
            $table->boolean('verified')->default(false); // Apakah dokumen telah diverifikasi
            $table->string('file_path'); // Lokasi penyimpanan file dokumen
            $table->timestamps(); // Created At & Updated At

            // Foreign Key Constraints
            $table->foreign('jenis_document_id')->references('id')->on('master_docs')->onDelete('cascade');
            $table->foreign('department_id')->references('id')->on('department')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('documents');
    }
};
