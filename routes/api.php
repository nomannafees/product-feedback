<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('/register', [\App\Http\Controllers\Api\AuthController::class, 'register']);
Route::post('/login', [\App\Http\Controllers\Api\AuthController::class, 'login'])->middleware('throttle:6,1');

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [\App\Http\Controllers\Api\AuthController::class, 'logout']);
    Route::post('/feedback-add', [App\Http\Controllers\API\FeedbackController::class, 'store']);
    Route::post('/comment-add', [App\Http\Controllers\Api\CommentController::class, 'store']);
});
Route::get('/get-categories', [App\Http\Controllers\CategoryController::class, 'GetCategories']);
Route::get('/get-feedback', [App\Http\Controllers\API\FeedbackController::class, 'GetFeedback']);
Route::get('/get-comments/{id}', [App\Http\Controllers\API\FeedbackController::class, 'GeComment']);

