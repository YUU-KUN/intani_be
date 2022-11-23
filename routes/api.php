<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BankController;
use App\Http\Controllers\FarmGroupController;
use App\Http\Controllers\InvestmentController;
use App\Http\Controllers\InvestorInvestmentController;

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

Route::middleware(['cors', 'json.response'])->group(function () {
    // Authentication
    Route::post('login', [AuthController::class, 'login']); // Login
    Route::post('register', [AuthController::class, 'register']); // Register
    
    // PUBLIC CAN ACCESS
    Route::get('banks', [BankController::class, 'index']); // Get All Banks
    Route::get('farm_groups', [FarmGroupController::class, 'index']); // Get All Farm Groups
    
    // All with token can access
    Route::middleware('auth:api')->group(function() {
        Route::get('profile', [AuthController::class, 'profile']); // Get Profile
        Route::get('farmer_investments', [InvestmentController::class, 'getFarmerInvestment']); // Get Farmer Investment
        Route::get('investor_investments/{investment_id}', [InvestmentController::class, 'getDetailInvestment']); // Get Investment Detail
        Route::resource('investments', InvestmentController::class);
    });
    
    // Only Farmer can access
    Route::middleware(['auth:api', 'api.farmer'])->group(function () {
        Route::post('investments', [InvestmentController::class, 'store']); // Create Farmer Investment
        Route::get('farmer_pending_investment', [InvestmentController::class, 'GetFarmerPendingInvestment']); // Get Farmer Pending Investment
        Route::get('farmer_accepted_investment', [InvestmentController::class, 'getFarmerAcceptedInvestment']); // Get Farmer Accepted Investment
        Route::get('farmer_completed_investment', [InvestmentController::class, 'getFarmerCompletedInvestment']); // Get Farmer Accepted Investment
        Route::get('farmer_history_investment', [InvestmentController::class, 'getFarmerHistoryInvestment']); // Get Farmer History Investment
        Route::post('farmer_finish_investment/{investment_id}', [InvestmentController::class, 'farmerFinishInvestment']); // Farmer FInish Investment
        
        Route::get('profit-sharing', [InvestmentController::class, 'getProfitSharing']); // Get Farmer Profit Sharing
        Route::put('profit-sharing', [InvestmentController::class, 'updateIncome']); // Get Farmer Profit Sharing

        Route::post('profit-sharing', [InvestmentController::class, 'proceedProfitSharing']); // Get Farmer Profit Sharing
        
        Route::put('accept_investment/{investment_id}', [InvestmentController::class, 'acceptInvestment']); // Accept Investor Investment
    });

    // Only Investor can access
    Route::middleware(['auth:api', 'api.investor'])->group(function () {
        Route::resource('investor_investments', InvestorInvestmentController::class);
        Route::get('investor_investments', [InvestmentController::class, 'getInvestorInvestment']); // Get Investor Investment
        Route::get('available_investments', [InvestmentController::class, 'getAvailableInvestment']); // Get Available Investor Investment
        Route::post('pay_investment', [InvestmentController::class, 'PayInvestment']); // Pay Investor Investment
    });
});