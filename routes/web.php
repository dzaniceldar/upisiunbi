<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CarController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\RideController;
use App\Http\Controllers\FacultyController;
use App\Http\Controllers\Admin\ApplicationManagementController;
use App\Http\Controllers\Admin\FacultyManagementController;
use App\Http\Controllers\Applicant\ApplicationController;
use App\Http\Controllers\Applicant\DocumentController;
use App\Models\Department;
use App\Models\Faculty;
use App\Models\Subject;
use App\Models\User;
 
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/faculties', [FacultyController::class, 'index'])->name('faculties.index');
Route::get('/faculties/{faculty:slug}', [FacultyController::class, 'show'])->name('faculties.show');

Route::middleware(['auth:sanctum', 'verified'])->get('/', function () {
    return view('dashboard', [
        'stats' => [
            'faculties' => Faculty::count(),
            'departments' => Department::count(),
            'subjects' => Subject::count(),
            'students' => User::where('role', 'applicant')->count(),
            'graduates' => 12480,
        ],
    ]);
})->name('dashboard');

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return redirect()->route('dashboard');
});

/*
Route::middleware(['auth:sanctum', 'verified'])->get('/cars', function () {
    return view('cars.index');
})->name('cars');
*/

Route::middleware(['auth:sanctum', 'verified'])->get('cars', [CarController::class, 'index'])->name('cars');
Route::middleware(['auth:sanctum', 'verified'])->get('add_car', [CarController::class, 'create'])->name('add_car');
Route::middleware(['auth:sanctum', 'verified'])->post('store_car', [CarController::class, 'store'])->name('store_car');
Route::middleware(['auth:sanctum', 'verified'])->post('delete_car', [CarController::class, 'delete'])->name('delete_car');
Route::middleware(['auth:sanctum', 'verified'])->post('edit_car', [CarController::class, 'edit'])->name('edit_car');
Route::middleware(['auth:sanctum', 'verified'])->post('update_car', [CarController::class, 'update'])->name('update_car');
Route::middleware(['auth:sanctum', 'verified'])->post('file_add', [CarController::class, 'file_add'])->name('file_add');
Route::middleware(['auth:sanctum', 'verified'])->post('process', [CarController::class, 'process'])->name('process');

Route::middleware(['auth:sanctum', 'verified'])->get('brands', [BrandController::class, 'index'])->name('brands');

Route::middleware(['auth:sanctum', 'verified'])->get('rides', [RideController::class, 'index'])->name('rides');

Route::middleware(['auth:sanctum', 'verified'])->group(function () {
    Route::get('applications', [ApplicationController::class, 'index'])->name('applications.index');
    Route::get('documents', [DocumentController::class, 'index'])->name('applicant.documents.index');
    Route::post('documents/upload-required', [DocumentController::class, 'uploadRequired'])->name('applicant.documents.upload-required');
    Route::get('documents/{document}/download', [DocumentController::class, 'download'])->name('applicant.documents.download');
});

Route::prefix('admin')
    ->middleware(['auth:sanctum', 'verified', 'admin'])
    ->name('admin.')
    ->group(function () {
        Route::get('/applications', [ApplicationManagementController::class, 'index'])->name('applications.index');
        Route::get('/applications/export/csv', [ApplicationManagementController::class, 'exportCsv'])->name('applications.export');
        Route::get('/applications/{application}', [ApplicationManagementController::class, 'show'])->name('applications.show');
        Route::post('/applications/{application}/status', [ApplicationManagementController::class, 'updateStatus'])->name('applications.status');
        Route::post('/applications/{application}/notes', [ApplicationManagementController::class, 'storeNote'])->name('applications.notes');
        Route::get('/documents/{document}/download', [ApplicationManagementController::class, 'downloadDocument'])->name('documents.download');
        Route::get('/faculties', [FacultyManagementController::class, 'index'])->name('faculties.index');
        Route::get('/faculties/{faculty}/edit', [FacultyManagementController::class, 'edit'])->name('faculties.edit');
        Route::put('/faculties/{faculty}', [FacultyManagementController::class, 'update'])->name('faculties.update');
    });