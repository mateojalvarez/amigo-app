<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

require base_path('routes/contexts/auth.php');

Route::get('/user', fn (Request $request) => $request->user())->middleware('auth:sanctum');
