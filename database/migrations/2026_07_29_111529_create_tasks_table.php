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
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            //judul Tugas
            $table->string('title');
            
            //untuk deskripsi
            $table->text('description')->nullable();
            
            //tanggal dibuat/waktu 
            $table->date('task_date')->nullable();
            
            //update status
            $table->boolean('is_completed')->default(false);
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
