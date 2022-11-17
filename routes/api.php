<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware(['cors', 'json.response'])->group(function () {
    // Authentication
    Route::post('/login', [AuthController::class, 'login']); // Login
    Route::post('/register/company', [AuthController::class, 'registerCompany']); // Register Company
    Route::post('/register/job_finder', [AuthController::class, 'registerJobFinder']); // Register Job Finder
    
    // PUBLIC CAN ACCESS
    // Route::get('job-vacancy/{id}', [JobVacancyController::class, 'show']); // Get Detail Job Vacancy
    // Route::get('job-training/{id}', [JobTrainingController::class, 'show']); // Get Detail Job Training
    
    // All with token can access
    Route::middleware('auth:api')->group(function() {
        // Route::get('user', [AuthController::class, 'getProfile']); // Get User Profile
        // Route::post('user', [AuthController::class, 'updateProfile']); // Get User Profile
        // Route::get('my-vacancy-applications', [JobVacancyApplicationController::class, 'index']); // Get User Profile
        // Route::resource('job-vacancy', JobVacancyController::class); // Job Vacancy
    });

    // Only Farmer can access
    Route::middleware(['auth:api', 'api.farmer'])->group(function () {
        // Route::get('company/job_vacancy', [JobVacancyController::class, 'getCompanyJobVacancy']); // Get Conmpany Job Vacancy
        // Route::resource('company', CompanyController::class); // Company
    });

    // Only Investor can access
    Route::middleware(['auth:api', 'api.investor'])->group(function () {
        // Route::resource('job-finder', JobFinderController::class); // Job Finder
        // Route::post('apply-job-vacancy', [JobVacancyController::class, 'apply']); // Get User Profile
        // Route::post('apply-job-training', [JobTrainingController::class, 'apply']); // Get User Profile
    });
});