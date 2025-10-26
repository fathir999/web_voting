<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\VoteController;
use App\Http\Controllers\ExportController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\UserMiddleware; // <- pastikan ini ada di atas
use App\Http\Controllers\CandidateController;
use App\Http\Controllers\CommentController;
// Public routes
Route::get('/', function () {
    return redirect()->route('login');
});

// Auth routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// Admin routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

    // CRUD Candidates
    Route::get('/candidates', [AdminController::class, 'candidates'])->name('candidates');
    Route::get('/candidates/create', [AdminController::class, 'createCandidate'])->name('candidates.create');
    Route::post('/candidates', [AdminController::class, 'storeCandidate'])->name('candidates.store');
    Route::get('/candidates/{candidate}/edit', [AdminController::class, 'editCandidate'])->name('candidates.edit');
    Route::put('/candidates/{candidate}', [AdminController::class, 'updateCandidate'])->name('candidates.update');
    Route::delete('/candidates/{candidate}', [AdminController::class, 'deleteCandidate'])->name('candidates.delete');

    // SoftDelete Features
    Route::post('/candidates/{id}/restore', [AdminController::class, 'restoreCandidate'])->name('candidates.restore');
    Route::delete('/candidates/{id}/force', [AdminController::class, 'forceDeleteCandidate'])->name('candidates.force-delete');

    // Export Features
    Route::get('/export/excel', [ExportController::class, 'exportExcel'])->name('export.excel');
    Route::get('/export/detail', [ExportController::class, 'exportDetailExcel'])->name('export.detail');

    // Reset Votes
    Route::get('/candidates/trashed', [AdminController::class, 'trashed'])->name('candidates.trashed');
    Route::post('/candidates/reset-votes', [AdminController::class, 'resetVotes'])->name('reset-votes');

    // Comments
    Route::get('/comments', [AdminController::class, 'comments'])->name('comments.index');
    Route::delete('/comments/reset', [CommentController::class, 'reset'])->name('comments.reset');
    //export comments
    Route::get('comments/export', [AdminController::class, 'exportComments'])->name('comments.export');
    Route::delete('/comments/{id}', [CommentController::class, 'destroy'])->name('comments.destroy');
    //aktif/nonaktif
    Route::patch('/candidates/{id}/toggle-Status', [AdminController::class, 'toggleStatus'])->name('candidates.toggleStatus');

    // Voting & Results
    Route::get('/vote', [VoteController::class, 'index'])->name('vote');
    Route::post('/vote', [VoteController::class, 'store'])->name('vote.store');
    Route::get('/results', [VoteController::class, 'results'])->name('results');
});
// User routes
Route::middleware(['auth', 'user'])->prefix('user')->name('user.')->group(function () {
    Route::get('/results', [VoteController::class, 'results'])->name('results');


    // Voting routes (jika user juga bisa voting)
    Route::get('/vote', [VoteController::class, 'index'])->name('vote');
    Route::post('/vote', [VoteController::class, 'store'])->name('vote.store');


    //commemnt
    Route::post('/comments', [CommentController::class, 'store'])->name('comments.store');



    // Comments (user bisa kirim komentar)
});
