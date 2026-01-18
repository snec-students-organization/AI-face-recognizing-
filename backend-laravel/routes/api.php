<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FaceRecognitionController;

Route::post('/recognize', [FaceRecognitionController::class, 'recognize']);
Route::post('/scan', [FaceRecognitionController::class, 'scan']);
