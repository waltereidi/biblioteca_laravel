<?php

use App\Http\Controllers\ZapierController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/test', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');


Route::post('zapier/googleDriveFileUpload', [ZapierController::class, 'googleDriveFileUpload'])->middleware('bearer.auth');
