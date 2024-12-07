<?php

use App\Http\Controllers\FacultyController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\ScholarshipController;
use App\Http\Controllers\SpecializationController;
use App\Http\Controllers\StudentController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [FacultyController::class, 'index'])->middleware(['auth', 'verified'])->name('faculty');

Route::get('faculty', [FacultyController::class, 'index'])->middleware(['auth', 'verified'])->name('faculty');
Route::get('specialization', [SpecializationController::class, 'index'])->middleware(['auth', 'verified'])->name('specialization');
Route::get('group', [GroupController::class, 'index'])->middleware(['auth', 'verified'])->name('group');
Route::get('student', [StudentController::class, 'index'])->middleware(['auth', 'verified'])->name('student');
Route::get('scholarship', [ScholarshipController::class, 'index'])->middleware(['auth', 'verified'])->name('scholarship');

Route::view('dashboard', 'dashboard')->middleware(['auth', 'verified'])->name('dashboard');

Route::view('profile', 'profile')->middleware(['auth'])->name('profile');

require __DIR__ . '/auth.php';
