<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return response()->json([
        'message' => 'University of Africa API',
        'version' => '1.0.0',
    ]);
});
