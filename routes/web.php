<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;

// Halaman Utama & Pencarian
Route::get('/', [TaskController::class, 'index'])->name('tasks.index');

// Halaman Form Tambah Tugas
Route::get('/tasks/create', [TaskController::class, 'create'])->name('tasks.create');

// Proses Simpan Tugas Baru
Route::post('/tasks', [TaskController::class, 'store'])->name('tasks.store');

// Halaman Form Edit Tugas
Route::get('/tasks/{task}/edit', [TaskController::class, 'edit'])->name('tasks.edit');

// Proses Update Tugas
Route::put('/tasks/{task}', [TaskController::class, 'update'])->name('tasks.update');

// Proses Hapus Tugas (Mendukung Massal)
Route::delete('/tasks', [TaskController::class, 'destroy'])->name('tasks.destroy');

// Proses Toggle Status (Selesai / Belum)
Route::patch('/tasks/{task}/toggle', [TaskController::class, 'toggleComplete'])->name('tasks.toggle');
