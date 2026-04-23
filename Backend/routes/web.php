<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

Route::get('/db-test', function () {
    return response()->json([
        'default' => config('database.default'),
        'host' => config('database.connections.mysql.host'),
        'port' => config('database.connections.mysql.port'),
        'database' => config('database.connections.mysql.database'),
        'username' => config('database.connections.mysql.username'),
        'url' => config('database.connections.mysql.url'),
        'current_database' => DB::select('select database() as db')[0]->db ?? null,
    ]);
});
