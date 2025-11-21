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
        Schema::create('distribution', function (Blueprint $table) {
            $table->id();
            $table->string('nodocument'); // Nomor Dokumen
            $table->unsignedBigInteger('user_id'); // Foreign Key ke users (Created By)
            $table->unsignedBigInteger('created_by'); // Foreign Key ke users (Created By)
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('distribution');
    }
};
