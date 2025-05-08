<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return ['CashbackGR API' => "0.1.0 alpha"];
});

require __DIR__.'/auth.php';
