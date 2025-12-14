<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SurveyController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\ResponseController;
use App\Http\Controllers\AnswerController;

// =======================================================
// 🔹 PENGISI (Mahasiswa / Public Survey Access)
// =======================================================

// Halaman utama survei (bisa menerima nim & nama via query string)
Route::get('/', [SurveyController::class, 'welcome'])
    ->name('survey.welcome');

// Grup route survei mahasiswa
Route::prefix('survey')
    ->name('survey.')
    ->controller(SurveyController::class)
    ->group(function () {
        Route::get('/instructions', 'instructions')->name('instructions');
        Route::get('/question/{step}', 'showQuestion')->name('question');

        // Simpan jawaban sementara (session)
        Route::post('/question/{step}', 'saveTempAnswer')->name('temp.store');

        // Simpan semua ke database di akhir
        Route::post('/submit', 'storeAll')->name('submit');

        Route::get('/thanks', 'thanks')->name('thanks');
    });

// =======================================================
// 🔹 ADMIN AREA (Protected by auth + role admin)
// =======================================================

Route::prefix('admin')
    ->middleware(['auth', 'admin'])
    ->name('admin.')
    ->group(function () {

        // Dashboard Admin
        Route::get('/', fn() => redirect()->route('admin.dashboard'))->name('home');
        Route::view('/dashboard', 'admin.dashboard')->name('dashboard');

        // CRUD Pertanyaan & Respon
        Route::resource('questions', QuestionController::class);
        Route::resource('responses', ResponseController::class);

        // Lihat jawaban per respon
        Route::get('responses/{response}/answers', [AnswerController::class, 'index'])
            ->name('answers.index');
    });

// =======================================================
// 🔹 AUTH (Laravel Breeze / Fortify / Jetstream Support)
// =======================================================

if (file_exists(__DIR__ . '/auth.php')) {
    require __DIR__ . '/auth.php';
}