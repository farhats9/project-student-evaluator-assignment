<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\EvaluatorController;

// Public Routes


Route::get('/',[HomeController::class, 'dashboard'])->name('home');
Route::post('/register',[HomeController::class, 'register']);
Route::post('/login',[HomeController::class, 'login']);
Route::post('/evalregister',[HomeController::class, 'evalregister']);

// Student Routes

Route::prefix('student')->middleware('auth:student')->group(function () {
    Route::get('/dashboard', [StudentController::class, 'dashboard'])->name('student.dashboard');
    Route::post('/logout', [StudentController::class, 'logout'])->name('student.logout');
    Route::post('/save',[StudentController::class, 'save'])->name('student.save');
    Route::get('/mysubmission', [StudentController::class, 'mySubmission'])->name('student.mySubmission');
    Route::post('/resubmit/{id}', [StudentController::class, 'resubmit'])->name('student.resubmit');
});

// Admin routes

Route::prefix('admin')->middleware('auth:admin')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::post('/logout', [AdminController::class, 'logout'])->name('admin.logout');
    Route::get('/assign-evaluator/{projectId}', [AdminController::class, 'assignEvaluator'])->name('admin.assignEvaluator');
    Route::post('/assign-evaluator/{projectId}/submit', [AdminController::class, 'submitEvaluatorAssignment'])->name('admin.submitEvaluatorAssignment');
    Route::post('/submit-admin-comments/{id}', [AdminController::class, 'submitAdminComments'])->name('admin.submitAdminComments');
    Route::get('/search', [AdminController::class, 'search'])->name('admin.search');
    Route::get('/add_domain', [AdminController::class, 'showDomain'])->name('admin.showDomain');
    Route::post('/add_domain/save', [AdminController::class, 'saveDomain'])->name('admin.saveDomain');
    Route::post('/domain_update', [AdminController::class, 'toggle'])->name('admin.toggle');
    Route::get('/assign-evaluator/search/{projectId}', [AdminController::class, 'assignEvaluatorSearch'])->name('admin.assignEvaluatorSearch');

});

// Evaluator routes

Route::prefix('evaluator')->middleware('auth:evaluator')->group(function () {
    Route::get('/dashboard', [EvaluatorController::class, 'dashboard'])->name('evaluator.dashboard');
    Route::post('/give-consent/{id}', [EvaluatorController::class, 'giveConsent'])->name('evaluator.giveConsent');
    Route::post('/submit-comments/{id}', [EvaluatorController::class, 'submitComments'])->name('evaluator.submitComments');
    Route::get('/view-file/{projectId}', [EvaluatorController::class, 'viewFile'])->name('evaluator.viewFile');
    Route::post('/logout', [EvaluatorController::class, 'logout'])->name('evaluator.logout');
    Route::get('/search', [EvaluatorController::class, 'search'])->name('evaluator.search');
});

